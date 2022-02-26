/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/backend/core/plugins/custom/tinymce/plugins/hr/plugin.js":
/*!****************************************************************************!*\
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/hr/plugin.js ***!
  \****************************************************************************/
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

  var global = tinymce.util.Tools.resolve('tinymce.PluginManager');

  var register$1 = function register$1(editor) {
    editor.addCommand('InsertHorizontalRule', function () {
      editor.execCommand('mceInsertContent', false, '<hr />');
    });
  };

  var register = function register(editor) {
    var onAction = function onAction() {
      return editor.execCommand('InsertHorizontalRule');
    };

    editor.ui.registry.addButton('hr', {
      icon: 'horizontal-rule',
      tooltip: 'Horizontal line',
      onAction: onAction
    });
    editor.ui.registry.addMenuItem('hr', {
      icon: 'horizontal-rule',
      text: 'Horizontal line',
      onAction: onAction
    });
  };

  function Plugin() {
    global.add('hr', function (editor) {
      register$1(editor);
      register(editor);
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
/*!***************************************************************************!*\
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/hr/index.js ***!
  \***************************************************************************/
// Exports the "hr" plugin for usage with module loaders
// Usage:
//   CommonJS:
//     require('tinymce/plugins/hr')
//   ES2015:
//     import 'tinymce/plugins/hr'
__webpack_require__(/*! ./plugin.js */ "./resources/backend/core/plugins/custom/tinymce/plugins/hr/plugin.js");
})();

/******/ })()
;