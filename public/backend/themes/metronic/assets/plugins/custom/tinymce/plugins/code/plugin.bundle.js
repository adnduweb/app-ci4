/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************************************************************!*\
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/code/plugin.js ***!
  \******************************************************************************/
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

  var setContent = function setContent(editor, html) {
    editor.focus();
    editor.undoManager.transact(function () {
      editor.setContent(html);
    });
    editor.selection.setCursorLocation();
    editor.nodeChanged();
  };

  var getContent = function getContent(editor) {
    return editor.getContent({
      source_view: true
    });
  };

  var open = function open(editor) {
    var editorContent = getContent(editor);
    editor.windowManager.open({
      title: 'Source Code',
      size: 'large',
      body: {
        type: 'panel',
        items: [{
          type: 'textarea',
          name: 'code'
        }]
      },
      buttons: [{
        type: 'cancel',
        name: 'cancel',
        text: 'Cancel'
      }, {
        type: 'submit',
        name: 'save',
        text: 'Save',
        primary: true
      }],
      initialData: {
        code: editorContent
      },
      onSubmit: function onSubmit(api) {
        setContent(editor, api.getData().code);
        api.close();
      }
    });
  };

  var register$1 = function register$1(editor) {
    editor.addCommand('mceCodeEditor', function () {
      open(editor);
    });
  };

  var register = function register(editor) {
    var onAction = function onAction() {
      return editor.execCommand('mceCodeEditor');
    };

    editor.ui.registry.addButton('code', {
      icon: 'sourcecode',
      tooltip: 'Source code',
      onAction: onAction
    });
    editor.ui.registry.addMenuItem('code', {
      icon: 'sourcecode',
      text: 'Source code',
      onAction: onAction
    });
  };

  function Plugin() {
    global.add('code', function (editor) {
      register$1(editor);
      register(editor);
      return {};
    });
  }

  Plugin();
})();
/******/ })()
;