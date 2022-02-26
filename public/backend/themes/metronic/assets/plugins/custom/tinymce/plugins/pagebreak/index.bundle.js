/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/backend/core/plugins/custom/tinymce/plugins/pagebreak/plugin.js":
/*!***********************************************************************************!*\
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/pagebreak/plugin.js ***!
  \***********************************************************************************/
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

  var global$1 = tinymce.util.Tools.resolve('tinymce.PluginManager');
  var global = tinymce.util.Tools.resolve('tinymce.Env');

  var getSeparatorHtml = function getSeparatorHtml(editor) {
    return editor.getParam('pagebreak_separator', '<!-- pagebreak -->');
  };

  var shouldSplitBlock = function shouldSplitBlock(editor) {
    return editor.getParam('pagebreak_split_block', false);
  };

  var pageBreakClass = 'mce-pagebreak';

  var getPlaceholderHtml = function getPlaceholderHtml(shouldSplitBlock) {
    var html = '<img src="' + global.transparentSrc + '" class="' + pageBreakClass + '" data-mce-resize="false" data-mce-placeholder />';
    return shouldSplitBlock ? '<p>' + html + '</p>' : html;
  };

  var setup$1 = function setup$1(editor) {
    var separatorHtml = getSeparatorHtml(editor);

    var shouldSplitBlock$1 = function shouldSplitBlock$1() {
      return shouldSplitBlock(editor);
    };

    var pageBreakSeparatorRegExp = new RegExp(separatorHtml.replace(/[\?\.\*\[\]\(\)\{\}\+\^\$\:]/g, function (a) {
      return '\\' + a;
    }), 'gi');
    editor.on('BeforeSetContent', function (e) {
      e.content = e.content.replace(pageBreakSeparatorRegExp, getPlaceholderHtml(shouldSplitBlock$1()));
    });
    editor.on('PreInit', function () {
      editor.serializer.addNodeFilter('img', function (nodes) {
        var i = nodes.length,
            node,
            className;

        while (i--) {
          node = nodes[i];
          className = node.attr('class');

          if (className && className.indexOf(pageBreakClass) !== -1) {
            var parentNode = node.parent;

            if (editor.schema.getBlockElements()[parentNode.name] && shouldSplitBlock$1()) {
              parentNode.type = 3;
              parentNode.value = separatorHtml;
              parentNode.raw = true;
              node.remove();
              continue;
            }

            node.type = 3;
            node.value = separatorHtml;
            node.raw = true;
          }
        }
      });
    });
  };

  var register$1 = function register$1(editor) {
    editor.addCommand('mcePageBreak', function () {
      editor.insertContent(getPlaceholderHtml(shouldSplitBlock(editor)));
    });
  };

  var setup = function setup(editor) {
    editor.on('ResolveName', function (e) {
      if (e.target.nodeName === 'IMG' && editor.dom.hasClass(e.target, pageBreakClass)) {
        e.name = 'pagebreak';
      }
    });
  };

  var register = function register(editor) {
    var onAction = function onAction() {
      return editor.execCommand('mcePageBreak');
    };

    editor.ui.registry.addButton('pagebreak', {
      icon: 'page-break',
      tooltip: 'Page break',
      onAction: onAction
    });
    editor.ui.registry.addMenuItem('pagebreak', {
      text: 'Page break',
      icon: 'page-break',
      onAction: onAction
    });
  };

  function Plugin() {
    global$1.add('pagebreak', function (editor) {
      register$1(editor);
      register(editor);
      setup$1(editor);
      setup(editor);
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
/*!**********************************************************************************!*\
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/pagebreak/index.js ***!
  \**********************************************************************************/
// Exports the "pagebreak" plugin for usage with module loaders
// Usage:
//   CommonJS:
//     require('tinymce/plugins/pagebreak')
//   ES2015:
//     import 'tinymce/plugins/pagebreak'
__webpack_require__(/*! ./plugin.js */ "./resources/backend/core/plugins/custom/tinymce/plugins/pagebreak/plugin.js");
})();

/******/ })()
;