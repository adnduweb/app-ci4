/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/backend/core/plugins/custom/tinymce/plugins/emoticons/plugin.js":
/*!***********************************************************************************!*\
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/emoticons/plugin.js ***!
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

  var global$3 = tinymce.util.Tools.resolve('tinymce.PluginManager');

  var eq = function eq(t) {
    return function (a) {
      return t === a;
    };
  };

  var isNull = eq(null);

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

  var exists = function exists(xs, pred) {
    for (var i = 0, len = xs.length; i < len; i++) {
      var x = xs[i];

      if (pred(x, i)) {
        return true;
      }
    }

    return false;
  };

  var map$1 = function map$1(xs, f) {
    var len = xs.length;
    var r = new Array(len);

    for (var i = 0; i < len; i++) {
      var x = xs[i];
      r[i] = f(x, i);
    }

    return r;
  };

  var each$1 = function each$1(xs, f) {
    for (var i = 0, len = xs.length; i < len; i++) {
      var x = xs[i];
      f(x, i);
    }
  };

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

  var last = function last(fn, rate) {
    var timer = null;

    var cancel = function cancel() {
      if (!isNull(timer)) {
        clearTimeout(timer);
        timer = null;
      }
    };

    var throttle = function throttle() {
      var args = [];

      for (var _i = 0; _i < arguments.length; _i++) {
        args[_i] = arguments[_i];
      }

      cancel();
      timer = setTimeout(function () {
        timer = null;
        fn.apply(null, args);
      }, rate);
    };

    return {
      cancel: cancel,
      throttle: throttle
    };
  };

  var insertEmoticon = function insertEmoticon(editor, ch) {
    editor.insertContent(ch);
  };

  var _assign = function __assign() {
    _assign = Object.assign || function __assign(t) {
      for (var s, i = 1, n = arguments.length; i < n; i++) {
        s = arguments[i];

        for (var p in s) {
          if (Object.prototype.hasOwnProperty.call(s, p)) t[p] = s[p];
        }
      }

      return t;
    };

    return _assign.apply(this, arguments);
  };

  var keys = Object.keys;
  var hasOwnProperty = Object.hasOwnProperty;

  var each = function each(obj, f) {
    var props = keys(obj);

    for (var k = 0, len = props.length; k < len; k++) {
      var i = props[k];
      var x = obj[i];
      f(x, i);
    }
  };

  var map = function map(obj, f) {
    return tupleMap(obj, function (x, i) {
      return {
        k: i,
        v: f(x, i)
      };
    });
  };

  var tupleMap = function tupleMap(obj, f) {
    var r = {};
    each(obj, function (x, i) {
      var tuple = f(x, i);
      r[tuple.k] = tuple.v;
    });
    return r;
  };

  var has = function has(obj, key) {
    return hasOwnProperty.call(obj, key);
  };

  var shallow = function shallow(old, nu) {
    return nu;
  };

  var baseMerge = function baseMerge(merger) {
    return function () {
      var objects = [];

      for (var _i = 0; _i < arguments.length; _i++) {
        objects[_i] = arguments[_i];
      }

      if (objects.length === 0) {
        throw new Error('Can\'t merge zero objects');
      }

      var ret = {};

      for (var j = 0; j < objects.length; j++) {
        var curObject = objects[j];

        for (var key in curObject) {
          if (has(curObject, key)) {
            ret[key] = merger(ret[key], curObject[key]);
          }
        }
      }

      return ret;
    };
  };

  var merge = baseMerge(shallow);

  var singleton = function singleton(doRevoke) {
    var subject = Cell(Optional.none());

    var revoke = function revoke() {
      return subject.get().each(doRevoke);
    };

    var clear = function clear() {
      revoke();
      subject.set(Optional.none());
    };

    var isSet = function isSet() {
      return subject.get().isSome();
    };

    var get = function get() {
      return subject.get();
    };

    var set = function set(s) {
      revoke();
      subject.set(Optional.some(s));
    };

    return {
      clear: clear,
      isSet: isSet,
      get: get,
      set: set
    };
  };

  var value = function value() {
    var subject = singleton(noop);

    var on = function on(f) {
      return subject.get().each(f);
    };

    return _assign(_assign({}, subject), {
      on: on
    });
  };

  var checkRange = function checkRange(str, substr, start) {
    return substr === '' || str.length >= substr.length && str.substr(start, start + substr.length) === substr;
  };

  var contains = function contains(str, substr) {
    return str.indexOf(substr) !== -1;
  };

  var startsWith = function startsWith(str, prefix) {
    return checkRange(str, prefix, 0);
  };

  var global$2 = tinymce.util.Tools.resolve('tinymce.Resource');
  var global$1 = tinymce.util.Tools.resolve('tinymce.util.Delay');
  var global = tinymce.util.Tools.resolve('tinymce.util.Promise');
  var DEFAULT_ID = 'tinymce.plugins.emoticons';

  var getEmoticonDatabase = function getEmoticonDatabase(editor) {
    return editor.getParam('emoticons_database', 'emojis', 'string');
  };

  var getEmoticonDatabaseUrl = function getEmoticonDatabaseUrl(editor, pluginUrl) {
    var database = getEmoticonDatabase(editor);
    return editor.getParam('emoticons_database_url', pluginUrl + '/js/' + database + editor.suffix + '.js', 'string');
  };

  var getEmoticonDatabaseId = function getEmoticonDatabaseId(editor) {
    return editor.getParam('emoticons_database_id', DEFAULT_ID, 'string');
  };

  var getAppendedEmoticons = function getAppendedEmoticons(editor) {
    return editor.getParam('emoticons_append', {}, 'object');
  };

  var getEmotionsImageUrl = function getEmotionsImageUrl(editor) {
    return editor.getParam('emoticons_images_url', 'https://twemoji.maxcdn.com/v/13.0.1/72x72/', 'string');
  };

  var ALL_CATEGORY = 'All';
  var categoryNameMap = {
    symbols: 'Symbols',
    people: 'People',
    animals_and_nature: 'Animals and Nature',
    food_and_drink: 'Food and Drink',
    activity: 'Activity',
    travel_and_places: 'Travel and Places',
    objects: 'Objects',
    flags: 'Flags',
    user: 'User Defined'
  };

  var translateCategory = function translateCategory(categories, name) {
    return has(categories, name) ? categories[name] : name;
  };

  var getUserDefinedEmoticons = function getUserDefinedEmoticons(editor) {
    var userDefinedEmoticons = getAppendedEmoticons(editor);
    return map(userDefinedEmoticons, function (value) {
      return _assign({
        keywords: [],
        category: 'user'
      }, value);
    });
  };

  var initDatabase = function initDatabase(editor, databaseUrl, databaseId) {
    var categories = value();
    var all = value();
    var emojiImagesUrl = getEmotionsImageUrl(editor);

    var getEmoji = function getEmoji(lib) {
      if (startsWith(lib["char"], '<img')) {
        return lib["char"].replace(/src="([^"]+)"/, function (match, url) {
          return 'src="' + emojiImagesUrl + url + '"';
        });
      } else {
        return lib["char"];
      }
    };

    var processEmojis = function processEmojis(emojis) {
      var cats = {};
      var everything = [];
      each(emojis, function (lib, title) {
        var entry = {
          title: title,
          keywords: lib.keywords,
          "char": getEmoji(lib),
          category: translateCategory(categoryNameMap, lib.category)
        };
        var current = cats[entry.category] !== undefined ? cats[entry.category] : [];
        cats[entry.category] = current.concat([entry]);
        everything.push(entry);
      });
      categories.set(cats);
      all.set(everything);
    };

    editor.on('init', function () {
      global$2.load(databaseId, databaseUrl).then(function (emojis) {
        var userEmojis = getUserDefinedEmoticons(editor);
        processEmojis(merge(emojis, userEmojis));
      }, function (err) {
        console.log('Failed to load emoticons: ' + err);
        categories.set({});
        all.set([]);
      });
    });

    var listCategory = function listCategory(category) {
      if (category === ALL_CATEGORY) {
        return listAll();
      }

      return categories.get().bind(function (cats) {
        return Optional.from(cats[category]);
      }).getOr([]);
    };

    var listAll = function listAll() {
      return all.get().getOr([]);
    };

    var listCategories = function listCategories() {
      return [ALL_CATEGORY].concat(keys(categories.get().getOr({})));
    };

    var waitForLoad = function waitForLoad() {
      if (hasLoaded()) {
        return global.resolve(true);
      } else {
        return new global(function (resolve, reject) {
          var numRetries = 15;
          var interval = global$1.setInterval(function () {
            if (hasLoaded()) {
              global$1.clearInterval(interval);
              resolve(true);
            } else {
              numRetries--;

              if (numRetries < 0) {
                console.log('Could not load emojis from url: ' + databaseUrl);
                global$1.clearInterval(interval);
                reject(false);
              }
            }
          }, 100);
        });
      }
    };

    var hasLoaded = function hasLoaded() {
      return categories.isSet() && all.isSet();
    };

    return {
      listCategories: listCategories,
      hasLoaded: hasLoaded,
      waitForLoad: waitForLoad,
      listAll: listAll,
      listCategory: listCategory
    };
  };

  var emojiMatches = function emojiMatches(emoji, lowerCasePattern) {
    return contains(emoji.title.toLowerCase(), lowerCasePattern) || exists(emoji.keywords, function (k) {
      return contains(k.toLowerCase(), lowerCasePattern);
    });
  };

  var emojisFrom = function emojisFrom(list, pattern, maxResults) {
    var matches = [];
    var lowerCasePattern = pattern.toLowerCase();
    var reachedLimit = maxResults.fold(function () {
      return never;
    }, function (max) {
      return function (size) {
        return size >= max;
      };
    });

    for (var i = 0; i < list.length; i++) {
      if (pattern.length === 0 || emojiMatches(list[i], lowerCasePattern)) {
        matches.push({
          value: list[i]["char"],
          text: list[i].title,
          icon: list[i]["char"]
        });

        if (reachedLimit(matches.length)) {
          break;
        }
      }
    }

    return matches;
  };

  var patternName = 'pattern';

  var open = function open(editor, database) {
    var initialState = {
      pattern: '',
      results: emojisFrom(database.listAll(), '', Optional.some(300))
    };
    var currentTab = Cell(ALL_CATEGORY);

    var scan = function scan(dialogApi) {
      var dialogData = dialogApi.getData();
      var category = currentTab.get();
      var candidates = database.listCategory(category);
      var results = emojisFrom(candidates, dialogData[patternName], category === ALL_CATEGORY ? Optional.some(300) : Optional.none());
      dialogApi.setData({
        results: results
      });
    };

    var updateFilter = last(function (dialogApi) {
      scan(dialogApi);
    }, 200);
    var searchField = {
      label: 'Search',
      type: 'input',
      name: patternName
    };
    var resultsField = {
      type: 'collection',
      name: 'results'
    };

    var getInitialState = function getInitialState() {
      var body = {
        type: 'tabpanel',
        tabs: map$1(database.listCategories(), function (cat) {
          return {
            title: cat,
            name: cat,
            items: [searchField, resultsField]
          };
        })
      };
      return {
        title: 'Emoticons',
        size: 'normal',
        body: body,
        initialData: initialState,
        onTabChange: function onTabChange(dialogApi, details) {
          currentTab.set(details.newTabName);
          updateFilter.throttle(dialogApi);
        },
        onChange: updateFilter.throttle,
        onAction: function onAction(dialogApi, actionData) {
          if (actionData.name === 'results') {
            insertEmoticon(editor, actionData.value);
            dialogApi.close();
          }
        },
        buttons: [{
          type: 'cancel',
          text: 'Close',
          primary: true
        }]
      };
    };

    var dialogApi = editor.windowManager.open(getInitialState());
    dialogApi.focus(patternName);

    if (!database.hasLoaded()) {
      dialogApi.block('Loading emoticons...');
      database.waitForLoad().then(function () {
        dialogApi.redial(getInitialState());
        updateFilter.throttle(dialogApi);
        dialogApi.focus(patternName);
        dialogApi.unblock();
      })["catch"](function (_err) {
        dialogApi.redial({
          title: 'Emoticons',
          body: {
            type: 'panel',
            items: [{
              type: 'alertbanner',
              level: 'error',
              icon: 'warning',
              text: '<p>Could not load emoticons</p>'
            }]
          },
          buttons: [{
            type: 'cancel',
            text: 'Close',
            primary: true
          }],
          initialData: {
            pattern: '',
            results: []
          }
        });
        dialogApi.focus(patternName);
        dialogApi.unblock();
      });
    }
  };

  var register$1 = function register$1(editor, database) {
    editor.addCommand('mceEmoticons', function () {
      return open(editor, database);
    });
  };

  var setup = function setup(editor) {
    editor.on('PreInit', function () {
      editor.parser.addAttributeFilter('data-emoticon', function (nodes) {
        each$1(nodes, function (node) {
          node.attr('data-mce-resize', 'false');
          node.attr('data-mce-placeholder', '1');
        });
      });
    });
  };

  var init = function init(editor, database) {
    editor.ui.registry.addAutocompleter('emoticons', {
      ch: ':',
      columns: 'auto',
      minChars: 2,
      fetch: function fetch(pattern, maxResults) {
        return database.waitForLoad().then(function () {
          var candidates = database.listAll();
          return emojisFrom(candidates, pattern, Optional.some(maxResults));
        });
      },
      onAction: function onAction(autocompleteApi, rng, value) {
        editor.selection.setRng(rng);
        editor.insertContent(value);
        autocompleteApi.hide();
      }
    });
  };

  var register = function register(editor) {
    var onAction = function onAction() {
      return editor.execCommand('mceEmoticons');
    };

    editor.ui.registry.addButton('emoticons', {
      tooltip: 'Emoticons',
      icon: 'emoji',
      onAction: onAction
    });
    editor.ui.registry.addMenuItem('emoticons', {
      text: 'Emoticons...',
      icon: 'emoji',
      onAction: onAction
    });
  };

  function Plugin() {
    global$3.add('emoticons', function (editor, pluginUrl) {
      var databaseUrl = getEmoticonDatabaseUrl(editor, pluginUrl);
      var databaseId = getEmoticonDatabaseId(editor);
      var database = initDatabase(editor, databaseUrl, databaseId);
      register$1(editor, database);
      register(editor);
      init(editor, database);
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
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/emoticons/index.js ***!
  \**********************************************************************************/
// Exports the "emoticons" plugin for usage with module loaders
// Usage:
//   CommonJS:
//     require('tinymce/plugins/emoticons')
//   ES2015:
//     import 'tinymce/plugins/emoticons'
__webpack_require__(/*! ./plugin.js */ "./resources/backend/core/plugins/custom/tinymce/plugins/emoticons/plugin.js");
})();

/******/ })()
;