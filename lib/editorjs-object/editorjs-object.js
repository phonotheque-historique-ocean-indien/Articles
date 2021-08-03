/**
 * Tool for creating CollectiveAccess Object Blocks for Editor.js
 * IDEESCULTURE 2021, by Gautier MICHELIN
 *
 * @typedef {object} CAObjectToolData — Input/Output data format for our Tool
 * @property {string} url - image source URL
 * @property {string} caption - image caption
 *
 * @typedef {object} AudioToolConfig
 * @property {string} placeholder — custom placeholder for URL field
 */
class CaObject {
  /**
   * Our tool should be placed at the Toolbox, so describe an icon and title
   */
  static get toolbox() {
    return {
      title: 'CaObject',
      icon: '<svg version="1.1" id="Calque_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve"><g><path d="M7.8,8.9c0,2.8-1.7,4.3-3.8,4.3c-2.1,0-3.6-1.7-3.6-4.1c0-2.6,1.6-4.2,3.8-4.2C6.4,4.8,7.8,6.5,7.8,8.9z M1.5,9c0,1.7,0.9,3.3,2.6,3.3c1.7,0,2.6-1.5,2.6-3.4c0-1.6-0.8-3.3-2.6-3.3C2.4,5.6,1.5,7.2,1.5,9z"/><path d="M9.2,5c0.5-0.1,1.2-0.2,1.9-0.2c1,0,1.7,0.2,2.2,0.6C13.7,5.7,14,6.2,14,6.9c0,0.8-0.5,1.5-1.4,1.8v0c0.8,0.2,1.7,0.8,1.7,2c0,0.7-0.3,1.2-0.7,1.6c-0.6,0.5-1.5,0.8-2.8,0.8c-0.7,0-1.3,0-1.6-0.1V5z M10.2,8.3h0.9c1.1,0,1.8-0.6,1.8-1.4c0-0.9-0.7-1.3-1.8-1.3c-0.5,0-0.8,0-0.9,0.1V8.3z M10.2,12.2c0.2,0,0.5,0,0.9,0c1.1,0,2.1-0.4,2.1-1.6c0-1.1-0.9-1.6-2.1-1.6h-0.9V12.2z"/><path d="M17.3,4.9h1v5.4c0,2.1-1.1,2.8-2.4,2.8c-0.4,0-0.9-0.1-1.1-0.2l0.2-0.9c0.2,0.1,0.5,0.2,0.9,0.2c0.9,0,1.5-0.4,1.5-2V4.9z"/></g></svg>'
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

    caObjectId.setAttribute("data-placeholder", (this.config.placeholder || 'CollectiveAccess object id...'));
    caObjectId.addEventListener('paste', (event) => {
      this._createObjectPreview(event.clipboardData.getData('text'));
    });

    // const caObjectPreview = document.createElement('div');
    // caObjectPreview.setAttribute("class", "preview");
    // this.wrapper.appendChild(caObjectPreview);

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
    caObjectPreview.setAttribute("src", "http://dev.phoi.test/index.php/Articles/Display/Object/id/"+id);

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

    const caObjectPreview = document.createElement('iframe');
    caObjectPreview.setAttribute("class", "preview");
    caObjectPreview.setAttribute("src", "http://dev.phoi.test/index.php/Articles/Display/Object/id/"+id);
    
    blockContent.prepend(caObjectPreview);

    return Object.assign(this.data, {
      id: id
    });
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