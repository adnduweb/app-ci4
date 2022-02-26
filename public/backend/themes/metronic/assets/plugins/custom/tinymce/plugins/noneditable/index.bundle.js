/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/backend/core/plugins/custom/tinymce/plugins/noneditable/plugin.js":
/*!*************************************************************************************!*\
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/noneditable/plugin.js ***!
  \*************************************************************************************/
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
  var global = tinymce.util.Tools.resolve('tinymce.util.Tools');

  var getNonEditableClass = function getNonEditableClass(editor) {
    return editor.getParam('noneditable_noneditable_class', 'mceNonEditable');
  };

  var getEditableClass = function getEditableClass(editor) {
    return editor.getParam('noneditable_editable_class', 'mceEditable');
  };

  var getNonEditableRegExps = function getNonEditableRegExps(editor) {
    var nonEditableRegExps = editor.getParam('noneditable_regexp', []);

    if (nonEditableRegExps && nonEditableRegExps.constructor === RegExp) {
      return [nonEditableRegExps];
    } else {
      return nonEditableRegExps;
    }
  };

  var hasClass = function hasClass(checkClassName) {
    return function (node) {
      return (' ' + node.attr('class') + ' ').indexOf(checkClassName) !== -1;
    };
  };

  var replaceMatchWithSpan = function replaceMatchWithSpan(editor, content, cls) {
    return function (match) {
      var args = arguments,
          index = args[args.length - 2];
      var prevChar = index > 0 ? content.charAt(index - 1) : '';

      if (prevChar === '"') {
        return match;
      }

      if (prevChar === '>') {
        var findStartTagIndex = content.lastIndexOf('<', index);

        if (findStartTagIndex !== -1) {
          var tagHtml = content.substring(findStartTagIndex, index);

          if (tagHtml.indexOf('contenteditable="false"') !== -1) {
            return match;
          }
        }
      }

      return '<span class="' + cls + '" data-mce-content="' + editor.dom.encode(args[0]) + '">' + editor.dom.encode(typeof args[1] === 'string' ? args[1] : args[0]) + '</span>';
    };
  };

  var convertRegExpsToNonEditable = function convertRegExpsToNonEditable(editor, nonEditableRegExps, e) {
    var i = nonEditableRegExps.length,
        content = e.content;

    if (e.format === 'raw') {
      return;
    }

    while (i--) {
      content = content.replace(nonEditableRegExps[i], replaceMatchWithSpan(editor, content, getNonEditableClass(editor)));
    }

    e.content = content;
  };

  var setup = function setup(editor) {
    var contentEditableAttrName = 'contenteditable';
    var editClass = ' ' + global.trim(getEditableClass(editor)) + ' ';
    var nonEditClass = ' ' + global.trim(getNonEditableClass(editor)) + ' ';
    var hasEditClass = hasClass(editClass);
    var hasNonEditClass = hasClass(nonEditClass);
    var nonEditableRegExps = getNonEditableRegExps(editor);
    editor.on('PreInit', function () {
      if (nonEditableRegExps.length > 0) {
        editor.on('BeforeSetContent', function (e) {
          convertRegExpsToNonEditable(editor, nonEditableRegExps, e);
        });
      }

      editor.parser.addAttributeFilter('class', function (nodes) {
        var i = nodes.length,
            node;

        while (i--) {
          node = nodes[i];

          if (hasEditClass(node)) {
            node.attr(contentEditableAttrName, 'true');
          } else if (hasNonEditClass(node)) {
            node.attr(contentEditableAttrName, 'false');
          }
        }
      });
      editor.serializer.addAttributeFilter(contentEditableAttrName, function (nodes) {
        var i = nodes.length,
            node;

        while (i--) {
          node = nodes[i];

          if (!hasEditClass(node) && !hasNonEditClass(node)) {
            continue;
          }

          if (nonEditableRegExps.length > 0 && node.attr('data-mce-content')) {
            node.name = '#text';
            node.type = 3;
            node.raw = true;
            node.value = node.attr('data-mce-content');
          } else {
            node.attr(contentEditableAttrName, null);
          }
        }
      });
    });
  };

  function Plugin() {
    global$1.add('noneditable', function (editor) {
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
/*!************************************************************************************!*\
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/noneditable/index.js ***!
  \************************************************************************************/
// Exports the "noneditable" plugin for usage with module loaders
// Usage:
//   CommonJS:
//     require('tinymce/plugins/noneditable')
//   ES2015:
//     import 'tinymce/plugins/noneditable'
__webpack_require__(/*! ./plugin.js */ "./resources/backend/core/plugins/custom/tinymce/plugins/noneditable/plugin.js");
})();

/******/ })()
;