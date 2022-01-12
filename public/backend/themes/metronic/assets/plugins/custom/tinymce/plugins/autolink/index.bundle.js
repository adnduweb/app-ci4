/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/backend/core/plugins/custom/tinymce/plugins/autolink/plugin.js":
/*!**********************************************************************************!*\
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/autolink/plugin.js ***!
  \**********************************************************************************/
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

  var checkRange = function checkRange(str, substr, start) {
    return substr === '' || str.length >= substr.length && str.substr(start, start + substr.length) === substr;
  };

  var contains = function contains(str, substr) {
    return str.indexOf(substr) !== -1;
  };

  var startsWith = function startsWith(str, prefix) {
    return checkRange(str, prefix, 0);
  };

  var global = tinymce.util.Tools.resolve('tinymce.Env');

  var link = function link() {
    return /(?:[A-Za-z][A-Za-z\d.+-]{0,14}:\/\/(?:[-.~*+=!&;:'%@?^${}(),\w]+@)?|www\.|[-;:&=+$,.\w]+@)[A-Za-z\d-]+(?:\.[A-Za-z\d-]+)*(?::\d+)?(?:\/(?:[-+~=.,%()\/\w]*[-+~=%()\/\w])?)?(?:\?(?:[-.~*+=!&;:'%@?^${}(),\/\w]+))?(?:#(?:[-.~*+=!&;:'%@?^${}(),\/\w]+))?/g;
  };

  var defaultLinkPattern = new RegExp('^' + link().source + '$', 'i');

  var getAutoLinkPattern = function getAutoLinkPattern(editor) {
    return editor.getParam('autolink_pattern', defaultLinkPattern);
  };

  var getDefaultLinkTarget = function getDefaultLinkTarget(editor) {
    return editor.getParam('default_link_target', false);
  };

  var getDefaultLinkProtocol = function getDefaultLinkProtocol(editor) {
    return editor.getParam('link_default_protocol', 'http', 'string');
  };

  var rangeEqualsDelimiterOrSpace = function rangeEqualsDelimiterOrSpace(rangeString, delimiter) {
    return rangeString === delimiter || rangeString === ' ' || rangeString.charCodeAt(0) === 160;
  };

  var handleEclipse = function handleEclipse(editor) {
    parseCurrentLine(editor, -1, '(');
  };

  var handleSpacebar = function handleSpacebar(editor) {
    parseCurrentLine(editor, 0, '');
  };

  var handleEnter = function handleEnter(editor) {
    parseCurrentLine(editor, -1, '');
  };

  var scopeIndex = function scopeIndex(container, index) {
    if (index < 0) {
      index = 0;
    }

    if (container.nodeType === 3) {
      var len = container.data.length;

      if (index > len) {
        index = len;
      }
    }

    return index;
  };

  var setStart = function setStart(rng, container, offset) {
    if (container.nodeType !== 1 || container.hasChildNodes()) {
      rng.setStart(container, scopeIndex(container, offset));
    } else {
      rng.setStartBefore(container);
    }
  };

  var setEnd = function setEnd(rng, container, offset) {
    if (container.nodeType !== 1 || container.hasChildNodes()) {
      rng.setEnd(container, scopeIndex(container, offset));
    } else {
      rng.setEndAfter(container);
    }
  };

  var hasProtocol = function hasProtocol(url) {
    return /^([A-Za-z][A-Za-z\d.+-]*:\/\/)|mailto:/.test(url);
  };

  var isPunctuation = function isPunctuation(_char) {
    return /[?!,.;:]/.test(_char);
  };

  var parseCurrentLine = function parseCurrentLine(editor, endOffset, delimiter) {
    var end, endContainer, bookmark, text, prev, len, rngText;
    var autoLinkPattern = getAutoLinkPattern(editor);
    var defaultLinkTarget = getDefaultLinkTarget(editor);

    if (editor.selection.getNode().tagName === 'A') {
      return;
    }

    var rng = editor.selection.getRng().cloneRange();

    if (rng.startOffset < 5) {
      prev = rng.endContainer.previousSibling;

      if (!prev) {
        if (!rng.endContainer.firstChild || !rng.endContainer.firstChild.nextSibling) {
          return;
        }

        prev = rng.endContainer.firstChild.nextSibling;
      }

      len = prev.length;
      setStart(rng, prev, len);
      setEnd(rng, prev, len);

      if (rng.endOffset < 5) {
        return;
      }

      end = rng.endOffset;
      endContainer = prev;
    } else {
      endContainer = rng.endContainer;

      if (endContainer.nodeType !== 3 && endContainer.firstChild) {
        while (endContainer.nodeType !== 3 && endContainer.firstChild) {
          endContainer = endContainer.firstChild;
        }

        if (endContainer.nodeType === 3) {
          setStart(rng, endContainer, 0);
          setEnd(rng, endContainer, endContainer.nodeValue.length);
        }
      }

      if (rng.endOffset === 1) {
        end = 2;
      } else {
        end = rng.endOffset - 1 - endOffset;
      }
    }

    var start = end;

    do {
      setStart(rng, endContainer, end >= 2 ? end - 2 : 0);
      setEnd(rng, endContainer, end >= 1 ? end - 1 : 0);
      end -= 1;
      rngText = rng.toString();
    } while (rngText !== ' ' && rngText !== '' && rngText.charCodeAt(0) !== 160 && end - 2 >= 0 && rngText !== delimiter);

    if (rangeEqualsDelimiterOrSpace(rng.toString(), delimiter)) {
      setStart(rng, endContainer, end);
      setEnd(rng, endContainer, start);
      end += 1;
    } else if (rng.startOffset === 0) {
      setStart(rng, endContainer, 0);
      setEnd(rng, endContainer, start);
    } else {
      setStart(rng, endContainer, end);
      setEnd(rng, endContainer, start);
    }

    text = rng.toString();

    if (isPunctuation(text.charAt(text.length - 1))) {
      setEnd(rng, endContainer, start - 1);
    }

    text = rng.toString().trim();
    var matches = text.match(autoLinkPattern);
    var protocol = getDefaultLinkProtocol(editor);

    if (matches) {
      var url = matches[0];

      if (startsWith(url, 'www.')) {
        url = protocol + '://' + url;
      } else if (contains(url, '@') && !hasProtocol(url)) {
        url = 'mailto:' + url;
      }

      bookmark = editor.selection.getBookmark();
      editor.selection.setRng(rng);
      editor.execCommand('createlink', false, url);

      if (defaultLinkTarget !== false) {
        editor.dom.setAttrib(editor.selection.getNode(), 'target', defaultLinkTarget);
      }

      editor.selection.moveToBookmark(bookmark);
      editor.nodeChanged();
    }
  };

  var setup = function setup(editor) {
    var autoUrlDetectState;
    editor.on('keydown', function (e) {
      if (e.keyCode === 13) {
        return handleEnter(editor);
      }
    });

    if (global.browser.isIE()) {
      editor.on('focus', function () {
        if (!autoUrlDetectState) {
          autoUrlDetectState = true;

          try {
            editor.execCommand('AutoUrlDetect', false, true);
          } catch (ex) {}
        }
      });
      return;
    }

    editor.on('keypress', function (e) {
      if (e.keyCode === 41) {
        return handleEclipse(editor);
      }
    });
    editor.on('keyup', function (e) {
      if (e.keyCode === 32) {
        return handleSpacebar(editor);
      }
    });
  };

  function Plugin() {
    global$1.add('autolink', function (editor) {
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
/*!*********************************************************************************!*\
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/autolink/index.js ***!
  \*********************************************************************************/
// Exports the "autolink" plugin for usage with module loaders
// Usage:
//   CommonJS:
//     require('tinymce/plugins/autolink')
//   ES2015:
//     import 'tinymce/plugins/autolink'
__webpack_require__(/*! ./plugin.js */ "./resources/backend/core/plugins/custom/tinymce/plugins/autolink/plugin.js");
})();

/******/ })()
;