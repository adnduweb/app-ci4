/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************************************************************!*\
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/advlist/plugin.js ***!
  \*********************************************************************************/
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

  var applyListFormat = function applyListFormat(editor, listName, styleValue) {
    var cmd = listName === 'UL' ? 'InsertUnorderedList' : 'InsertOrderedList';
    editor.execCommand(cmd, false, styleValue === false ? null : {
      'list-style-type': styleValue
    });
  };

  var register$1 = function register$1(editor) {
    editor.addCommand('ApplyUnorderedListStyle', function (ui, value) {
      applyListFormat(editor, 'UL', value['list-style-type']);
    });
    editor.addCommand('ApplyOrderedListStyle', function (ui, value) {
      applyListFormat(editor, 'OL', value['list-style-type']);
    });
  };

  var global = tinymce.util.Tools.resolve('tinymce.util.Tools');

  var getNumberStyles = function getNumberStyles(editor) {
    var styles = editor.getParam('advlist_number_styles', 'default,lower-alpha,lower-greek,lower-roman,upper-alpha,upper-roman');
    return styles ? styles.split(/[ ,]/) : [];
  };

  var getBulletStyles = function getBulletStyles(editor) {
    var styles = editor.getParam('advlist_bullet_styles', 'default,circle,square');
    return styles ? styles.split(/[ ,]/) : [];
  };

  var noop = function noop() {};

  var constant = function constant(value) {
    return function () {
      return value;
    };
  };

  var identity = function identity(x) {
    return x;
  };

  var never = constant(false);
  var always = constant(true);

  var none = function none() {
    return NONE;
  };

  var NONE = function () {
    var call = function call(thunk) {
      return thunk();
    };

    var id = identity;
    var me = {
      fold: function fold(n, _s) {
        return n();
      },
      isSome: never,
      isNone: always,
      getOr: id,
      getOrThunk: call,
      getOrDie: function getOrDie(msg) {
        throw new Error(msg || 'error: getOrDie called on none.');
      },
      getOrNull: constant(null),
      getOrUndefined: constant(undefined),
      or: id,
      orThunk: call,
      map: none,
      each: noop,
      bind: none,
      exists: never,
      forall: always,
      filter: function filter() {
        return none();
      },
      toArray: function toArray() {
        return [];
      },
      toString: constant('none()')
    };
    return me;
  }();

  var some = function some(a) {
    var constant_a = constant(a);

    var self = function self() {
      return me;
    };

    var bind = function bind(f) {
      return f(a);
    };

    var me = {
      fold: function fold(n, s) {
        return s(a);
      },
      isSome: always,
      isNone: never,
      getOr: constant_a,
      getOrThunk: constant_a,
      getOrDie: constant_a,
      getOrNull: constant_a,
      getOrUndefined: constant_a,
      or: self,
      orThunk: self,
      map: function map(f) {
        return some(f(a));
      },
      each: function each(f) {
        f(a);
      },
      bind: bind,
      exists: bind,
      forall: bind,
      filter: function filter(f) {
        return f(a) ? me : NONE;
      },
      toArray: function toArray() {
        return [a];
      },
      toString: function toString() {
        return 'some(' + a + ')';
      }
    };
    return me;
  };

  var from = function from(value) {
    return value === null || value === undefined ? NONE : some(value);
  };

  var Optional = {
    some: some,
    none: none,
    from: from
  };

  var isChildOfBody = function isChildOfBody(editor, elm) {
    return editor.$.contains(editor.getBody(), elm);
  };

  var isTableCellNode = function isTableCellNode(node) {
    return node && /^(TH|TD)$/.test(node.nodeName);
  };

  var isListNode = function isListNode(editor) {
    return function (node) {
      return node && /^(OL|UL|DL)$/.test(node.nodeName) && isChildOfBody(editor, node);
    };
  };

  var getSelectedStyleType = function getSelectedStyleType(editor) {
    var listElm = editor.dom.getParent(editor.selection.getNode(), 'ol,ul');
    var style = editor.dom.getStyle(listElm, 'listStyleType');
    return Optional.from(style);
  };

  var findIndex = function findIndex(list, predicate) {
    for (var index = 0; index < list.length; index++) {
      var element = list[index];

      if (predicate(element)) {
        return index;
      }
    }

    return -1;
  };

  var styleValueToText = function styleValueToText(styleValue) {
    return styleValue.replace(/\-/g, ' ').replace(/\b\w/g, function (chr) {
      return chr.toUpperCase();
    });
  };

  var isWithinList = function isWithinList(editor, e, nodeName) {
    var tableCellIndex = findIndex(e.parents, isTableCellNode);
    var parents = tableCellIndex !== -1 ? e.parents.slice(0, tableCellIndex) : e.parents;
    var lists = global.grep(parents, isListNode(editor));
    return lists.length > 0 && lists[0].nodeName === nodeName;
  };

  var makeSetupHandler = function makeSetupHandler(editor, nodeName) {
    return function (api) {
      var nodeChangeHandler = function nodeChangeHandler(e) {
        api.setActive(isWithinList(editor, e, nodeName));
      };

      editor.on('NodeChange', nodeChangeHandler);
      return function () {
        return editor.off('NodeChange', nodeChangeHandler);
      };
    };
  };

  var addSplitButton = function addSplitButton(editor, id, tooltip, cmd, nodeName, styles) {
    editor.ui.registry.addSplitButton(id, {
      tooltip: tooltip,
      icon: nodeName === 'OL' ? 'ordered-list' : 'unordered-list',
      presets: 'listpreview',
      columns: 3,
      fetch: function fetch(callback) {
        var items = global.map(styles, function (styleValue) {
          var iconStyle = nodeName === 'OL' ? 'num' : 'bull';
          var iconName = styleValue === 'disc' || styleValue === 'decimal' ? 'default' : styleValue;
          var itemValue = styleValue === 'default' ? '' : styleValue;
          var displayText = styleValueToText(styleValue);
          return {
            type: 'choiceitem',
            value: itemValue,
            icon: 'list-' + iconStyle + '-' + iconName,
            text: displayText
          };
        });
        callback(items);
      },
      onAction: function onAction() {
        return editor.execCommand(cmd);
      },
      onItemAction: function onItemAction(_splitButtonApi, value) {
        applyListFormat(editor, nodeName, value);
      },
      select: function select(value) {
        var listStyleType = getSelectedStyleType(editor);
        return listStyleType.map(function (listStyle) {
          return value === listStyle;
        }).getOr(false);
      },
      onSetup: makeSetupHandler(editor, nodeName)
    });
  };

  var addButton = function addButton(editor, id, tooltip, cmd, nodeName, _styles) {
    editor.ui.registry.addToggleButton(id, {
      active: false,
      tooltip: tooltip,
      icon: nodeName === 'OL' ? 'ordered-list' : 'unordered-list',
      onSetup: makeSetupHandler(editor, nodeName),
      onAction: function onAction() {
        return editor.execCommand(cmd);
      }
    });
  };

  var addControl = function addControl(editor, id, tooltip, cmd, nodeName, styles) {
    if (styles.length > 1) {
      addSplitButton(editor, id, tooltip, cmd, nodeName, styles);
    } else {
      addButton(editor, id, tooltip, cmd, nodeName);
    }
  };

  var register = function register(editor) {
    addControl(editor, 'numlist', 'Numbered list', 'InsertOrderedList', 'OL', getNumberStyles(editor));
    addControl(editor, 'bullist', 'Bullet list', 'InsertUnorderedList', 'UL', getBulletStyles(editor));
  };

  function Plugin() {
    global$1.add('advlist', function (editor) {
      if (editor.hasPlugin('lists')) {
        register(editor);
        register$1(editor);
      } else {
        console.error('Please use the Lists plugin together with the Advanced List plugin.');
      }
    });
  }

  Plugin();
})();
/******/ })()
;