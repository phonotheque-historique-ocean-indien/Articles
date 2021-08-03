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
      tags: ['AUDIO'],
      files: {
        mimeTypes: ['audio/*'],
        extensions: ['wav', 'mp3'] // You can specify extensions instead of mime-types
      },
      patterns: {
        image: /https?:\/\/\S+\.(wav|mp3)$/i
      }
    };
  }

  /**
   * Automatic sanitize config
   * @see {@link https://editorjs.io/sanitize-saved-data}
   */
  static get sanitize(){
    return {
      url: {},
      caption: {
        b: true,
        a: {
          href: true
        },
        i: true
      }
    };
  }

  /**
   * Tool class constructor
   * @param {AudioToolData} data — previously saved data
   * @param {object} api — Editor.js Core API {@link  https://editorjs.io/api}
   * @param {AudioToolConfig} config — custom config that we provide to our tool's user
   */
  constructor({data, api, config}){
    this.api = api;
    this.config = config || {};
    this.data = {
      url: data.url || '',
      caption: data.caption || ''
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
    this.wrapper.classList.add('simple-audio');

    if (this.data && this.data.url){
      this._createAudio(this.data.url, this.data.caption);
      return this.wrapper;
    }

    const input = document.createElement('input');

    input.placeholder = this.config.placeholder || 'Paste an audio URL...';
    input.addEventListener('paste', (event) => {
      this._createAudio(event.clipboardData.getData('text'));
    });

    this.wrapper.appendChild(input);

    return this.wrapper;
  }

  /**
   * @private
   * Create audio tag with player
   * @param {string} url — image source
   * @param {string} captionText — caption value
   */
  _createAudio(url, captionText){
    const audio = document.createElement('audio');
    audio.setAttribute('controls', 'controls');
    const source = document.createElement('source');
    const caption = document.createElement('div');
    //caption.setAttribute('placeholder', 'Enter a title or a description');

    source.src = url;
    audio.appendChild(source);
    caption.contentEditable = true;
    caption.innerHTML = captionText || '';

    this.wrapper.innerHTML = '';
    this.wrapper.appendChild(audio);
    this.wrapper.appendChild(caption);

    this._acceptTuneView();
  }

  /**
   * Extract data from the UI
   * @param {HTMLElement} blockContent — element returned by render method
   * @return {SimpleAudioData}
   */
  save(blockContent){
    const audio = blockContent.querySelector('audio');
    const source = audio.querySelector('source');
    const caption = blockContent.querySelector('[contenteditable]');

    return Object.assign(this.data, {
      url: source.src,
      caption: caption.innerHTML || ''
    });
  }

  /**
   * Skip empty blocks
   * @see {@link https://editorjs.io/saved-data-validation}
   * @param {AudioToolConfig} savedData
   * @return {boolean}
   */
  validate(savedData){
    if (!savedData.url.trim()){
      return false;
    }

    return true;
  }

  s = 'simple-audio';

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
        $('.' + this.s).parent().removeClass('floatRight');
        $('.' + this.s).parent().removeClass('floatLeft');
        $('.simple-audio.floatLeft').parent().addClass('floatLeft');
        $('.simple-audio.floatRight').parent().addClass('floatRight');
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
      case 'tag':
        const audio = event.detail.data;
        console.log('audio tag pasted', event.detail.data);
        //this._createAudio(imgTag.src);
        break;
      case 'file':
        /* We need to read file here as base64 string */
        const file = event.detail.file;
        const reader = new FileReader();

        reader.onload = (loadEvent) => {
          this._createAudio(loadEvent.target.result);
        };

        reader.readAsDataURL(file);
        break;
      case 'pattern':
        const src = event.detail.data;

        this._createAudio(src);
        break;
    }
  }
}