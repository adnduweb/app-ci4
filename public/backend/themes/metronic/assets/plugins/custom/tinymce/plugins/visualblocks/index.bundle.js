/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/backend/core/plugins/custom/tinymce/plugins/visualblocks/plugin.js":
/*!**************************************************************************************!*\
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/visualblocks/plugin.js ***!
  \**************************************************************************************/
/***/ (() => {

/**
 * Copyright (c) Tiny Technologies, Inc. All rights reserved.
 * Licensed under the LGPL or a commercial license.
 * For LGPL see License.txt in the project root for license information.
 * For commercial licenses see https://www.tiny.cloud/
 *
 * Version: 5.10.0 (2021-10-11)
 */
(function () {
  'use strict';

  var Cell = function Cell(initial) {
    var value = initial;

    var get = function get() {
      return value;
    };

    var set = function set(v) {
      value = v;
    };

    return {
      get: get,
      set: set
    };
  };

  var global = tinymce.util.Tools.resolve('tinymce.PluginManager');

  var fireVisualBlocks = function fireVisualBlocks(editor, state) {
    editor.fire('VisualBlocks', {
      state: state
    });
  };

  var toggleVisualBlocks = function toggleVisualBlocks(editor, pluginUrl, enabledState) {
    var dom = editor.dom;
    dom.toggleClass(editor.getBody(), 'mce-visualblocks');
    enabledState.set(!enabledState.get());
    fireVisualBlocks(editor, enabledState.get());
  };

  var register$1 = function register$1(editor, pluginUrl, enabledState) {
    editor.addCommand('mceVisualBlocks', function () {
      toggleVisualBlocks(editor, pluginUrl, enabledState);
    });
  };

  var isEnabledByDefault = function isEnabledByDefault(editor) {
    return editor.getParam('visualblocks_default_state', false, 'boolean');
  };

  var setup = function setup(editor, pluginUrl, enabledState) {
    editor.on('PreviewFormats AfterPreviewFormats', function (e) {
      if (enabledState.get()) {
        editor.dom.toggleClass(editor.getBody(), 'mce-visualblocks', e.type === 'afterpreviewformats');
      }
    });
    editor.on('init', function () {
      if (isEnabledByDefault(editor)) {
        toggleVisualBlocks(editor, pluginUrl, enabledState);
      }
    });
  };

  var toggleActiveState = function toggleActiveState(editor, enabledState) {
    return function (api) {
      api.setActive(enabledState.get());

      var editorEventCallback = function editorEventCallback(e) {
        return api.setActive(e.state);
      };

      editor.on('VisualBlocks', editorEventCallback);
      return function () {
        return editor.off('VisualBlocks', editorEventCallback);
      };
    };
  };

  var register = function register(editor, enabledState) {
    var onAction = function onAction() {
      return editor.execCommand('mceVisualBlocks');
    };

    editor.ui.registry.addToggleButton('visualblocks', {
      icon: 'visualblocks',
      tooltip: 'Show blocks',
      onAction: onAction,
      onSetup: toggleActiveState(editor, enabledState)
    });
    editor.ui.registry.addToggleMenuItem('visualblocks', {
      text: 'Show blocks',
      icon: 'visualblocks',
      onAction: onAction,
      onSetup: toggleActiveState(editor, enabledState)
    });
  };

  function Plugin() {
    global.add('visualblocks', function (editor, pluginUrl) {
      var enabledState = Cell(false);
      register$1(editor, pluginUrl, enabledState);
      register(editor, enabledState);
      setup(editor, pluginUrl, enabledState);
    });
  }

  Plugin();
})();

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!*************************************************************************************!*\
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/visualblocks/index.js ***!
  \*************************************************************************************/
// Exports the "visualblocks" plugin for usage with module loaders
// Usage:
//   CommonJS:
//     require('tinymce/plugins/visualblocks')
//   ES2015:
//     import 'tinymce/plugins/visualblocks'
__webpack_require__(/*! ./plugin.js */ "./resources/backend/core/plugins/custom/tinymce/plugins/visualblocks/plugin.js");
})();

/******/ })()
;