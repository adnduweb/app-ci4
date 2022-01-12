/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/backend/core/plugins/custom/tinymce/plugins/importcss/plugin.js":
/*!***********************************************************************************!*\
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/importcss/plugin.js ***!
  \***********************************************************************************/
/***/ (() => {

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

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

  var global$4 = tinymce.util.Tools.resolve('tinymce.PluginManager');

  var typeOf = function typeOf(x) {
    var t = _typeof(x);

    if (x === null) {
      return 'null';
    } else if (t === 'object' && (Array.prototype.isPrototypeOf(x) || x.constructor && x.constructor.name === 'Array')) {
      return 'array';
    } else if (t === 'object' && (String.prototype.isPrototypeOf(x) || x.constructor && x.constructor.name === 'String')) {
      return 'string';
    } else {
      return t;
    }
  };

  var isType = function isType(type) {
    return function (value) {
      return typeOf(value) === type;
    };
  };

  var isString = isType('string');
  var isArray = isType('array');
  var global$3 = tinymce.util.Tools.resolve('tinymce.dom.DOMUtils');
  var global$2 = tinymce.util.Tools.resolve('tinymce.EditorManager');
  var global$1 = tinymce.util.Tools.resolve('tinymce.Env');
  var global = tinymce.util.Tools.resolve('tinymce.util.Tools');

  var shouldMergeClasses = function shouldMergeClasses(editor) {
    return editor.getParam('importcss_merge_classes');
  };

  var shouldImportExclusive = function shouldImportExclusive(editor) {
    return editor.getParam('importcss_exclusive');
  };

  var getSelectorConverter = function getSelectorConverter(editor) {
    return editor.getParam('importcss_selector_converter');
  };

  var getSelectorFilter = function getSelectorFilter(editor) {
    return editor.getParam('importcss_selector_filter');
  };

  var getCssGroups = function getCssGroups(editor) {
    return editor.getParam('importcss_groups');
  };

  var shouldAppend = function shouldAppend(editor) {
    return editor.getParam('importcss_append');
  };

  var getFileFilter = function getFileFilter(editor) {
    return editor.getParam('importcss_file_filter');
  };

  var getSkin = function getSkin(editor) {
    var skin = editor.getParam('skin');
    return skin !== false ? skin || 'oxide' : false;
  };

  var getSkinUrl = function getSkinUrl(editor) {
    return editor.getParam('skin_url');
  };

  var nativePush = Array.prototype.push;

  var map = function map(xs, f) {
    var len = xs.length;
    var r = new Array(len);

    for (var i = 0; i < len; i++) {
      var x = xs[i];
      r[i] = f(x, i);
    }

    return r;
  };

  var flatten = function flatten(xs) {
    var r = [];

    for (var i = 0, len = xs.length; i < len; ++i) {
      if (!isArray(xs[i])) {
        throw new Error('Arr.flatten item ' + i + ' was not an array, input: ' + xs);
      }

      nativePush.apply(r, xs[i]);
    }

    return r;
  };

  var bind = function bind(xs, f) {
    return flatten(map(xs, f));
  };

  var generate = function generate() {
    var ungroupedOrder = [];
    var groupOrder = [];
    var groups = {};

    var addItemToGroup = function addItemToGroup(groupTitle, itemInfo) {
      if (groups[groupTitle]) {
        groups[groupTitle].push(itemInfo);
      } else {
        groupOrder.push(groupTitle);
        groups[groupTitle] = [itemInfo];
      }
    };

    var addItem = function addItem(itemInfo) {
      ungroupedOrder.push(itemInfo);
    };

    var toFormats = function toFormats() {
      var groupItems = bind(groupOrder, function (g) {
        var items = groups[g];
        return items.length === 0 ? [] : [{
          title: g,
          items: items
        }];
      });
      return groupItems.concat(ungroupedOrder);
    };

    return {
      addItemToGroup: addItemToGroup,
      addItem: addItem,
      toFormats: toFormats
    };
  };

  var removeCacheSuffix = function removeCacheSuffix(url) {
    var cacheSuffix = global$1.cacheSuffix;

    if (isString(url)) {
      url = url.replace('?' + cacheSuffix, '').replace('&' + cacheSuffix, '');
    }

    return url;
  };

  var isSkinContentCss = function isSkinContentCss(editor, href) {
    var skin = getSkin(editor);

    if (skin) {
      var skinUrlBase = getSkinUrl(editor);
      var skinUrl = skinUrlBase ? editor.documentBaseURI.toAbsolute(skinUrlBase) : global$2.baseURL + '/skins/ui/' + skin;
      var contentSkinUrlPart = global$2.baseURL + '/skins/content/';
      return href === skinUrl + '/content' + (editor.inline ? '.inline' : '') + '.min.css' || href.indexOf(contentSkinUrlPart) !== -1;
    }

    return false;
  };

  var compileFilter = function compileFilter(filter) {
    if (isString(filter)) {
      return function (value) {
        return value.indexOf(filter) !== -1;
      };
    } else if (filter instanceof RegExp) {
      return function (value) {
        return filter.test(value);
      };
    }

    return filter;
  };

  var isCssImportRule = function isCssImportRule(rule) {
    return rule.styleSheet;
  };

  var isCssPageRule = function isCssPageRule(rule) {
    return rule.selectorText;
  };

  var getSelectors = function getSelectors(editor, doc, fileFilter) {
    var selectors = [];
    var contentCSSUrls = {};

    var append = function append(styleSheet, imported) {
      var href = styleSheet.href,
          rules;
      href = removeCacheSuffix(href);

      if (!href || !fileFilter(href, imported) || isSkinContentCss(editor, href)) {
        return;
      }

      global.each(styleSheet.imports, function (styleSheet) {
        append(styleSheet, true);
      });

      try {
        rules = styleSheet.cssRules || styleSheet.rules;
      } catch (e) {}

      global.each(rules, function (cssRule) {
        if (isCssImportRule(cssRule)) {
          append(cssRule.styleSheet, true);
        } else if (isCssPageRule(cssRule)) {
          global.each(cssRule.selectorText.split(','), function (selector) {
            selectors.push(global.trim(selector));
          });
        }
      });
    };

    global.each(editor.contentCSS, function (url) {
      contentCSSUrls[url] = true;
    });

    if (!fileFilter) {
      fileFilter = function fileFilter(href, imported) {
        return imported || contentCSSUrls[href];
      };
    }

    try {
      global.each(doc.styleSheets, function (styleSheet) {
        append(styleSheet);
      });
    } catch (e) {}

    return selectors;
  };

  var defaultConvertSelectorToFormat = function defaultConvertSelectorToFormat(editor, selectorText) {
    var format;
    var selector = /^(?:([a-z0-9\-_]+))?(\.[a-z0-9_\-\.]+)$/i.exec(selectorText);

    if (!selector) {
      return;
    }

    var elementName = selector[1];
    var classes = selector[2].substr(1).split('.').join(' ');
    var inlineSelectorElements = global.makeMap('a,img');

    if (selector[1]) {
      format = {
        title: selectorText
      };

      if (editor.schema.getTextBlockElements()[elementName]) {
        format.block = elementName;
      } else if (editor.schema.getBlockElements()[elementName] || inlineSelectorElements[elementName.toLowerCase()]) {
        format.selector = elementName;
      } else {
        format.inline = elementName;
      }
    } else if (selector[2]) {
      format = {
        inline: 'span',
        title: selectorText.substr(1),
        classes: classes
      };
    }

    if (shouldMergeClasses(editor) !== false) {
      format.classes = classes;
    } else {
      format.attributes = {
        "class": classes
      };
    }

    return format;
  };

  var getGroupsBySelector = function getGroupsBySelector(groups, selector) {
    return global.grep(groups, function (group) {
      return !group.filter || group.filter(selector);
    });
  };

  var compileUserDefinedGroups = function compileUserDefinedGroups(groups) {
    return global.map(groups, function (group) {
      return global.extend({}, group, {
        original: group,
        selectors: {},
        filter: compileFilter(group.filter)
      });
    });
  };

  var isExclusiveMode = function isExclusiveMode(editor, group) {
    return group === null || shouldImportExclusive(editor) !== false;
  };

  var isUniqueSelector = function isUniqueSelector(editor, selector, group, globallyUniqueSelectors) {
    return !(isExclusiveMode(editor, group) ? selector in globallyUniqueSelectors : selector in group.selectors);
  };

  var markUniqueSelector = function markUniqueSelector(editor, selector, group, globallyUniqueSelectors) {
    if (isExclusiveMode(editor, group)) {
      globallyUniqueSelectors[selector] = true;
    } else {
      group.selectors[selector] = true;
    }
  };

  var convertSelectorToFormat = function convertSelectorToFormat(editor, plugin, selector, group) {
    var selectorConverter;

    if (group && group.selector_converter) {
      selectorConverter = group.selector_converter;
    } else if (getSelectorConverter(editor)) {
      selectorConverter = getSelectorConverter(editor);
    } else {
      selectorConverter = function selectorConverter() {
        return defaultConvertSelectorToFormat(editor, selector);
      };
    }

    return selectorConverter.call(plugin, selector, group);
  };

  var setup = function setup(editor) {
    editor.on('init', function () {
      var model = generate();
      var globallyUniqueSelectors = {};
      var selectorFilter = compileFilter(getSelectorFilter(editor));
      var groups = compileUserDefinedGroups(getCssGroups(editor));

      var processSelector = function processSelector(selector, group) {
        if (isUniqueSelector(editor, selector, group, globallyUniqueSelectors)) {
          markUniqueSelector(editor, selector, group, globallyUniqueSelectors);
          var format = convertSelectorToFormat(editor, editor.plugins.importcss, selector, group);

          if (format) {
            var formatName = format.name || global$3.DOM.uniqueId();
            editor.formatter.register(formatName, format);
            return {
              title: format.title,
              format: formatName
            };
          }
        }

        return null;
      };

      global.each(getSelectors(editor, editor.getDoc(), compileFilter(getFileFilter(editor))), function (selector) {
        if (selector.indexOf('.mce-') === -1) {
          if (!selectorFilter || selectorFilter(selector)) {
            var selectorGroups = getGroupsBySelector(groups, selector);

            if (selectorGroups.length > 0) {
              global.each(selectorGroups, function (group) {
                var menuItem = processSelector(selector, group);

                if (menuItem) {
                  model.addItemToGroup(group.title, menuItem);
                }
              });
            } else {
              var menuItem = processSelector(selector, null);

              if (menuItem) {
                model.addItem(menuItem);
              }
            }
          }
        }
      });
      var items = model.toFormats();
      editor.fire('addStyleModifications', {
        items: items,
        replace: !shouldAppend(editor)
      });
    });
  };

  var get = function get(editor) {
    var convertSelectorToFormat = function convertSelectorToFormat(selectorText) {
      return defaultConvertSelectorToFormat(editor, selectorText);
    };

    return {
      convertSelectorToFormat: convertSelectorToFormat
    };
  };

  function Plugin() {
    global$4.add('importcss', function (editor) {
      setup(editor);
      return get(editor);
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
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/importcss/index.js ***!
  \**********************************************************************************/
// Exports the "importcss" plugin for usage with module loaders
// Usage:
//   CommonJS:
//     require('tinymce/plugins/importcss')
//   ES2015:
//     import 'tinymce/plugins/importcss'
__webpack_require__(/*! ./plugin.js */ "./resources/backend/core/plugins/custom/tinymce/plugins/importcss/plugin.js");
})();

/******/ })()
;