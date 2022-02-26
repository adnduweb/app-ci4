/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************************************************************!*\
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/nonbreaking/plugin.js ***!
  \*************************************************************************************/
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

  var getKeyboardSpaces = function getKeyboardSpaces(editor) {
    var spaces = editor.getParam('nonbreaking_force_tab', 0);

    if (typeof spaces === 'boolean') {
      return spaces === true ? 3 : 0;
    } else {
      return spaces;
    }
  };

  var wrapNbsps = function wrapNbsps(editor) {
    return editor.getParam('nonbreaking_wrap', true, 'boolean');
  };

  var stringRepeat = function stringRepeat(string, repeats) {
    var str = '';

    for (var index = 0; index < repeats; index++) {
      str += string;
    }

    return str;
  };

  var isVisualCharsEnabled = function isVisualCharsEnabled(editor) {
    return editor.plugins.visualchars ? editor.plugins.visualchars.isEnabled() : false;
  };

  var insertNbsp = function insertNbsp(editor, times) {
    var classes = function classes() {
      return isVisualCharsEnabled(editor) ? 'mce-nbsp-wrap mce-nbsp' : 'mce-nbsp-wrap';
    };

    var nbspSpan = function nbspSpan() {
      return '<span class="' + classes() + '" contenteditable="false">' + stringRepeat('&nbsp;', times) + '</span>';
    };

    var shouldWrap = wrapNbsps(editor);
    var html = shouldWrap || editor.plugins.visualchars ? nbspSpan() : stringRepeat('&nbsp;', times);
    editor.undoManager.transact(function () {
      return editor.insertContent(html);
    });
  };

  var register$1 = function register$1(editor) {
    editor.addCommand('mceNonBreaking', function () {
      insertNbsp(editor, 1);
    });
  };

  var global = tinymce.util.Tools.resolve('tinymce.util.VK');

  var setup = function setup(editor) {
    var spaces = getKeyboardSpaces(editor);

    if (spaces > 0) {
      editor.on('keydown', function (e) {
        if (e.keyCode === global.TAB && !e.isDefaultPrevented()) {
          if (e.shiftKey) {
            return;
          }

          e.preventDefault();
          e.stopImmediatePropagation();
          insertNbsp(editor, spaces);
        }
      });
    }
  };

  var register = function register(editor) {
    var onAction = function onAction() {
      return editor.execCommand('mceNonBreaking');
    };

    editor.ui.registry.addButton('nonbreaking', {
      icon: 'non-breaking',
      tooltip: 'Nonbreaking space',
      onAction: onAction
    });
    editor.ui.registry.addMenuItem('nonbreaking', {
      icon: 'non-breaking',
      text: 'Nonbreaking space',
      onAction: onAction
    });
  };

  function Plugin() {
    global$1.add('nonbreaking', function (editor) {
      register$1(editor);
      register(editor);
      setup(editor);
    });
  }

  Plugin();
})();
/******/ })()
;