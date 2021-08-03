/**
 * Tool for creating audio Blocks for Editor.js
 * IDEESCULTURE 2021, edited version by Gautier MICHELIN
 *
 * @typedef {object} AudioToolData — Input/Output data format for our Tool
 * @property {string} url - image source URL
 * @property {string} caption - image caption
 *
 * @typedef {object} AudioToolConfig
 * @property {string} placeholder — custom placeholder for URL field
 */
class CaSet {
  /**
   * Our tool should be placed at the Toolbox, so describe an icon and title
   */
  static get toolbox() {
    return {
      title: 'CaSet',
      icon: '<svg version="1.1" id="Calque_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 20 16" style="enable-background:new 0 0 20 20;" xml:space="preserve"><g><path d="M1.2,9.5C1.7,9.8,2.3,10,3.1,10c1.1,0,1.7-0.6,1.7-1.4c0-0.8-0.4-1.2-1.5-1.6C1.9,6.5,1.1,5.9,1.1,4.7c0-1.3,1-2.2,2.6-2.2c0.8,0,1.4,0.2,1.8,0.4L5.2,3.8C4.9,3.6,4.4,3.4,3.7,3.4c-1.1,0-1.5,0.7-1.5,1.2c0,0.8,0.5,1.1,1.6,1.6c1.4,0.5,2.1,1.2,2.1,2.4c0,1.2-0.9,2.3-2.8,2.3c-0.8,0-1.6-0.2-2.1-0.5L1.2,9.5z"/><path d="M11.4,7H8.3v2.9h3.5v0.9H7.2V2.7h4.4v0.9H8.3v2.6h3.1V7z"/><path d="M14.9,3.6h-2.5V2.7h6v0.9h-2.5v7.2h-1.1V3.6z"/></g></svg>'
    };
  }


  /**
   * Allow render Image Blocks by pasting HTML tags, files and URLs
   * @see {@link https://editorjs.io/paste-substitutions}
   * @return {{tags: string[], files: {mimeTypes: string[], extensions: string[]}, patterns: {image: RegExp}}}
   */
   static get pasteConfig() {
    return {
      patterns: {
        image: /^[0-9]+$/i
      }
    };
  }

  /**
   * Automatic sanitize config
   * @see {@link https://editorjs.io/sanitize-saved-data}
   */
  static get sanitize(){
    return {};
  }

  /**
   * Tool class constructor
   * @param {CAObjectToolData} data — previously saved data
   * @param {object} api — Editor.js Core API {@link  https://editorjs.io/api}
   * @param {AudioToolConfig} config — custom config that we provide to our tool's user
   */
  constructor({data, api, config}){
    this.api = api;
    this.config = config || {};
    this.data = {
      id: data.id || ''
    };

    this.wrapper = undefined;
    this.settings = [];
  }

  /**
   * Return a Tool's UI
   * @return {HTMLElement}
   */
  render(){
    this.wrapper = document.createElement('div');
    this.wrapper.classList.add('ca-object');

    if (this.data && this.data.id){
      this._createObjectPreview(this.data.id);
      return this.wrapper;
    }

    
    const caObjectId = document.createElement('div');
    caObjectId.contentEditable = true;

    caObjectId.setAttribute("data-placeholder", (this.config.placeholder || 'CollectiveAccess set id...'));
    caObjectId.addEventListener('paste', (event) => {
      this._createObjectPreview(event.clipboardData.getData('text'));
    });

    const caObjectPreview = document.createElement('div');
    caObjectPreview.setAttribute("preview", "preview");
    caObjectPreview.setAttribute("class", "preview");
    caObjectPreview.innerHTML = "Enregistrer pour générer l'aperçu";

    this.wrapper.appendChild(caObjectPreview);

    this.wrapper.appendChild(caObjectId);

    return this.wrapper;
  }

  /**
   * @private
   * Create block
   * @param {string} id — CA object id
   */
   _createObjectPreview(id){
    const caObjectId = document.createElement('div');

    const caObjectPreview = document.createElement('iframe');
    caObjectPreview.setAttribute("class", "preview");
    caObjectPreview.setAttribute("src", "http://dev.phoi.test/index.php/Articles/Display/Set/id/"+id);

    caObjectId.contentEditable = true;
    caObjectId.innerHTML = id || '';

    this.wrapper.innerHTML = '';
    this.wrapper.appendChild(caObjectPreview);
    this.wrapper.appendChild(caObjectId);

    this._acceptTuneView();
  }

  /**
   * Extract data from the UI
   * @param {HTMLElement} blockContent — element returned by render method
   * @return {SimpleAudioData}
   */
  save(blockContent){
    const caObjectId = blockContent.querySelector('[contenteditable]');
    const id = caObjectId.innerHTML;

    // Do not interact if content is empty
    if(id == "") {
      return Object.assign(this.data, {
        id: id
      });
    } else {
      const caObjectOldPreview = blockContent.querySelector('iframe');
      const caObjectOldImgPlaceholder = blockContent.querySelector('[preview]');
      function remove(el) {
        if(el !== null) {
          el.parentElement.removeChild(el);
        }
      }
      remove(caObjectOldPreview);
      remove(caObjectOldImgPlaceholder);
  
      const caObjectPreview = document.createElement('iframe');
      caObjectPreview.setAttribute("class", "preview");
      caObjectPreview.setAttribute("src", "http://dev.phoi.test/index.php/Articles/Display/Set/id/"+id);
      
      blockContent.prepend(caObjectPreview);
  
      return Object.assign(this.data, {
        id: id
      });
    }
  }

  /**
   * Skip empty blocks
   * @see {@link https://editorjs.io/saved-data-validation}
   * @param {AudioToolConfig} savedData
   * @return {boolean}
   */
  validate(savedData){
    if (!savedData.id.trim()){
      return false;
    }

    return true;
  }

  s = 'ca-object';

  /**
   * Making a Block settings: 'add border', 'add background', 'stretch to full width'
   * @see https://editorjs.io/making-a-block-settings — tutorial
   * @see https://editorjs.io/tools-api#rendersettings - API method description
   * @return {HTMLDivElement}
   */
  renderSettings(){
    const wrapper = document.createElement('div');

    this.settings.forEach( tune => {
      let button = document.createElement('div');

      button.classList.add(this.api.styles.settingsButton);
      button.classList.toggle(this.api.styles.settingsButtonActive, this.data[tune.name]);
      button.innerHTML = tune.icon;
      wrapper.appendChild(button);

      button.addEventListener('click', () => {
        this._toggleTune(tune.name);
        button.classList.toggle(this.api.styles.settingsButtonActive);
      });

    });

    return wrapper;
  }

  /**
   * @private
   * Click on the Settings Button
   * @param {string} tune — tune name from this.settings
   */
  _toggleTune(tune) {
    this.data[tune] = !this.data[tune];
    this._acceptTuneView();
  }

  /**
   * Add specified class corresponds with activated tunes
   * @private
   */
  _acceptTuneView() {
    this.settings.forEach( tune => {
      this.wrapper.classList.toggle(tune.name, !!this.data[tune.name]);

      if (tune.name === 'stretched') {
        this.api.blocks.stretchBlock(this.api.blocks.getCurrentBlockIndex(), !!this.data.stretched);
      }
    });
  }

  /**
   * Handle paste event
   * @see https://editorjs.io/tools-api#onpaste - API description
   * @param {CustomEvent }event
   */
  onPaste(event){
    switch (event.type){
      case 'pattern':
        const id = event.detail.data;

        this._createObjectPreview(id);
        break;
    }
  }
}