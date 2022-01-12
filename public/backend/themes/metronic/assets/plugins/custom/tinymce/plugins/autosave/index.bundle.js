/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/backend/core/plugins/custom/tinymce/plugins/autosave/plugin.js":
/*!**********************************************************************************!*\
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/autosave/plugin.js ***!
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

  var global$4 = tinymce.util.Tools.resolve('tinymce.PluginManager');

  var eq = function eq(t) {
    return function (a) {
      return t === a;
    };
  };

  var isUndefined = eq(undefined);
  var global$3 = tinymce.util.Tools.resolve('tinymce.util.Delay');
  var global$2 = tinymce.util.Tools.resolve('tinymce.util.LocalStorage');
  var global$1 = tinymce.util.Tools.resolve('tinymce.util.Tools');

  var fireRestoreDraft = function fireRestoreDraft(editor) {
    return editor.fire('RestoreDraft');
  };

  var fireStoreDraft = function fireStoreDraft(editor) {
    return editor.fire('StoreDraft');
  };

  var fireRemoveDraft = function fireRemoveDraft(editor) {
    return editor.fire('RemoveDraft');
  };

  var parse = function parse(timeString, defaultTime) {
    var multiples = {
      s: 1000,
      m: 60000
    };
    var toParse = timeString || defaultTime;
    var parsedTime = /^(\d+)([ms]?)$/.exec('' + toParse);
    return (parsedTime[2] ? multiples[parsedTime[2]] : 1) * parseInt(toParse, 10);
  };

  var shouldAskBeforeUnload = function shouldAskBeforeUnload(editor) {
    return editor.getParam('autosave_ask_before_unload', true);
  };

  var getAutoSavePrefix = function getAutoSavePrefix(editor) {
    var location = document.location;
    return editor.getParam('autosave_prefix', 'tinymce-autosave-{path}{query}{hash}-{id}-').replace(/{path}/g, location.pathname).replace(/{query}/g, location.search).replace(/{hash}/g, location.hash).replace(/{id}/g, editor.id);
  };

  var shouldRestoreWhenEmpty = function shouldRestoreWhenEmpty(editor) {
    return editor.getParam('autosave_restore_when_empty', false);
  };

  var getAutoSaveInterval = function getAutoSaveInterval(editor) {
    return parse(editor.getParam('autosave_interval'), '30s');
  };

  var getAutoSaveRetention = function getAutoSaveRetention(editor) {
    return parse(editor.getParam('autosave_retention'), '20m');
  };

  var _isEmpty = function isEmpty(editor, html) {
    if (isUndefined(html)) {
      return editor.dom.isEmpty(editor.getBody());
    } else {
      var trimmedHtml = global$1.trim(html);

      if (trimmedHtml === '') {
        return true;
      } else {
        var fragment = new DOMParser().parseFromString(trimmedHtml, 'text/html');
        return editor.dom.isEmpty(fragment);
      }
    }
  };

  var _hasDraft = function hasDraft(editor) {
    var time = parseInt(global$2.getItem(getAutoSavePrefix(editor) + 'time'), 10) || 0;

    if (new Date().getTime() - time > getAutoSaveRetention(editor)) {
      _removeDraft(editor, false);

      return false;
    }

    return true;
  };

  var _removeDraft = function removeDraft(editor, fire) {
    var prefix = getAutoSavePrefix(editor);
    global$2.removeItem(prefix + 'draft');
    global$2.removeItem(prefix + 'time');

    if (fire !== false) {
      fireRemoveDraft(editor);
    }
  };

  var _storeDraft = function storeDraft(editor) {
    var prefix = getAutoSavePrefix(editor);

    if (!_isEmpty(editor) && editor.isDirty()) {
      global$2.setItem(prefix + 'draft', editor.getContent({
        format: 'raw',
        no_events: true
      }));
      global$2.setItem(prefix + 'time', new Date().getTime().toString());
      fireStoreDraft(editor);
    }
  };

  var _restoreDraft = function restoreDraft(editor) {
    var prefix = getAutoSavePrefix(editor);

    if (_hasDraft(editor)) {
      editor.setContent(global$2.getItem(prefix + 'draft'), {
        format: 'raw'
      });
      fireRestoreDraft(editor);
    }
  };

  var startStoreDraft = function startStoreDraft(editor) {
    var interval = getAutoSaveInterval(editor);
    global$3.setEditorInterval(editor, function () {
      _storeDraft(editor);
    }, interval);
  };

  var restoreLastDraft = function restoreLastDraft(editor) {
    editor.undoManager.transact(function () {
      _restoreDraft(editor);

      _removeDraft(editor);
    });
    editor.focus();
  };

  var get = function get(editor) {
    return {
      hasDraft: function hasDraft() {
        return _hasDraft(editor);
      },
      storeDraft: function storeDraft() {
        return _storeDraft(editor);
      },
      restoreDraft: function restoreDraft() {
        return _restoreDraft(editor);
      },
      removeDraft: function removeDraft(fire) {
        return _removeDraft(editor, fire);
      },
      isEmpty: function isEmpty(html) {
        return _isEmpty(editor, html);
      }
    };
  };

  var global = tinymce.util.Tools.resolve('tinymce.EditorManager');

  var setup = function setup(editor) {
    editor.editorManager.on('BeforeUnload', function (e) {
      var msg;
      global$1.each(global.get(), function (editor) {
        if (editor.plugins.autosave) {
          editor.plugins.autosave.storeDraft();
        }

        if (!msg && editor.isDirty() && shouldAskBeforeUnload(editor)) {
          msg = editor.translate('You have unsaved changes are you sure you want to navigate away?');
        }
      });

      if (msg) {
        e.preventDefault();
        e.returnValue = msg;
      }
    });
  };

  var makeSetupHandler = function makeSetupHandler(editor) {
    return function (api) {
      api.setDisabled(!_hasDraft(editor));

      var editorEventCallback = function editorEventCallback() {
        return api.setDisabled(!_hasDraft(editor));
      };

      editor.on('StoreDraft RestoreDraft RemoveDraft', editorEventCallback);
      return function () {
        return editor.off('StoreDraft RestoreDraft RemoveDraft', editorEventCallback);
      };
    };
  };

  var register = function register(editor) {
    startStoreDraft(editor);
    editor.ui.registry.addButton('restoredraft', {
      tooltip: 'Restore last draft',
      icon: 'restore-draft',
      onAction: function onAction() {
        restoreLastDraft(editor);
      },
      onSetup: makeSetupHandler(editor)
    });
    editor.ui.registry.addMenuItem('restoredraft', {
      text: 'Restore last draft',
      icon: 'restore-draft',
      onAction: function onAction() {
        restoreLastDraft(editor);
      },
      onSetup: makeSetupHandler(editor)
    });
  };

  function Plugin() {
    global$4.add('autosave', function (editor) {
      setup(editor);
      register(editor);
      editor.on('init', function () {
        if (shouldRestoreWhenEmpty(editor) && editor.dom.isEmpty(editor.getBody())) {
          _restoreDraft(editor);
        }
      });
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
/*!*********************************************************************************!*\
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/autosave/index.js ***!
  \*********************************************************************************/
// Exports the "autosave" plugin for usage with module loaders
// Usage:
//   CommonJS:
//     require('tinymce/plugins/autosave')
//   ES2015:
//     import 'tinymce/plugins/autosave'
__webpack_require__(/*! ./plugin.js */ "./resources/backend/core/plugins/custom/tinymce/plugins/autosave/plugin.js");
})();

/******/ })()
;