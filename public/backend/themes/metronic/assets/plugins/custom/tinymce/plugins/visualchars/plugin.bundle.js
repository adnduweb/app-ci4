/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************************************************************!*\
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/visualchars/plugin.js ***!
  \*************************************************************************************/
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

  var global$1 = tinymce.util.Tools.resolve('tinymce.PluginManager');

  var get$2 = function get$2(toggleState) {
    var isEnabled = function isEnabled() {
      return toggleState.get();
    };

    return {
      isEnabled: isEnabled
    };
  };

  var fireVisualChars = function fireVisualChars(editor, state) {
    return editor.fire('VisualChars', {
      state: state
    });
  };

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

  var isType$1 = function isType$1(type) {
    return function (value) {
      return typeOf(value) === type;
    };
  };

  var isSimpleType = function isSimpleType(type) {
    return function (value) {
      return _typeof(value) === type;
    };
  };

  var isString = isType$1('string');
  var isBoolean = isSimpleType('boolean');
  var isNumber = isSimpleType('number');

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

  var map = function map(xs, f) {
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

  var filter = function filter(xs, pred) {
    var r = [];

    for (var i = 0, len = xs.length; i < len; i++) {
      var x = xs[i];

      if (pred(x, i)) {
        r.push(x);
      }
    }

    return r;
  };

  var keys = Object.keys;

  var each = function each(obj, f) {
    var props = keys(obj);

    for (var k = 0, len = props.length; k < len; k++) {
      var i = props[k];
      var x = obj[i];
      f(x, i);
    }
  };

  typeof window !== 'undefined' ? window : Function('return this;')();
  var TEXT = 3;

  var type = function type(element) {
    return element.dom.nodeType;
  };

  var value = function value(element) {
    return element.dom.nodeValue;
  };

  var isType = function isType(t) {
    return function (element) {
      return type(element) === t;
    };
  };

  var isText = isType(TEXT);

  var rawSet = function rawSet(dom, key, value) {
    if (isString(value) || isBoolean(value) || isNumber(value)) {
      dom.setAttribute(key, value + '');
    } else {
      console.error('Invalid call to Attribute.set. Key ', key, ':: Value ', value, ':: Element ', dom);
      throw new Error('Attribute value was not simple');
    }
  };

  var set = function set(element, key, value) {
    rawSet(element.dom, key, value);
  };

  var get$1 = function get$1(element, key) {
    var v = element.dom.getAttribute(key);
    return v === null ? undefined : v;
  };

  var remove$3 = function remove$3(element, key) {
    element.dom.removeAttribute(key);
  };

  var read = function read(element, attr) {
    var value = get$1(element, attr);
    return value === undefined || value === '' ? [] : value.split(' ');
  };

  var add$2 = function add$2(element, attr, id) {
    var old = read(element, attr);
    var nu = old.concat([id]);
    set(element, attr, nu.join(' '));
    return true;
  };

  var remove$2 = function remove$2(element, attr, id) {
    var nu = filter(read(element, attr), function (v) {
      return v !== id;
    });

    if (nu.length > 0) {
      set(element, attr, nu.join(' '));
    } else {
      remove$3(element, attr);
    }

    return false;
  };

  var supports = function supports(element) {
    return element.dom.classList !== undefined;
  };

  var get = function get(element) {
    return read(element, 'class');
  };

  var add$1 = function add$1(element, clazz) {
    return add$2(element, 'class', clazz);
  };

  var remove$1 = function remove$1(element, clazz) {
    return remove$2(element, 'class', clazz);
  };

  var add = function add(element, clazz) {
    if (supports(element)) {
      element.dom.classList.add(clazz);
    } else {
      add$1(element, clazz);
    }
  };

  var cleanClass = function cleanClass(element) {
    var classList = supports(element) ? element.dom.classList : get(element);

    if (classList.length === 0) {
      remove$3(element, 'class');
    }
  };

  var remove = function remove(element, clazz) {
    if (supports(element)) {
      var classList = element.dom.classList;
      classList.remove(clazz);
    } else {
      remove$1(element, clazz);
    }

    cleanClass(element);
  };

  var fromHtml = function fromHtml(html, scope) {
    var doc = scope || document;
    var div = doc.createElement('div');
    div.innerHTML = html;

    if (!div.hasChildNodes() || div.childNodes.length > 1) {
      console.error('HTML does not have a single root node', html);
      throw new Error('HTML must have a single root node');
    }

    return fromDom(div.childNodes[0]);
  };

  var fromTag = function fromTag(tag, scope) {
    var doc = scope || document;
    var node = doc.createElement(tag);
    return fromDom(node);
  };

  var fromText = function fromText(text, scope) {
    var doc = scope || document;
    var node = doc.createTextNode(text);
    return fromDom(node);
  };

  var fromDom = function fromDom(node) {
    if (node === null || node === undefined) {
      throw new Error('Node cannot be null or undefined');
    }

    return {
      dom: node
    };
  };

  var fromPoint = function fromPoint(docElm, x, y) {
    return Optional.from(docElm.dom.elementFromPoint(x, y)).map(fromDom);
  };

  var SugarElement = {
    fromHtml: fromHtml,
    fromTag: fromTag,
    fromText: fromText,
    fromDom: fromDom,
    fromPoint: fromPoint
  };
  var charMap = {
    '\xA0': 'nbsp',
    '\xAD': 'shy'
  };

  var charMapToRegExp = function charMapToRegExp(charMap, global) {
    var regExp = '';
    each(charMap, function (_value, key) {
      regExp += key;
    });
    return new RegExp('[' + regExp + ']', global ? 'g' : '');
  };

  var charMapToSelector = function charMapToSelector(charMap) {
    var selector = '';
    each(charMap, function (value) {
      if (selector) {
        selector += ',';
      }

      selector += 'span.mce-' + value;
    });
    return selector;
  };

  var regExp = charMapToRegExp(charMap);
  var regExpGlobal = charMapToRegExp(charMap, true);
  var selector = charMapToSelector(charMap);
  var nbspClass = 'mce-nbsp';

  var wrapCharWithSpan = function wrapCharWithSpan(value) {
    return '<span data-mce-bogus="1" class="mce-' + charMap[value] + '">' + value + '</span>';
  };

  var isMatch = function isMatch(n) {
    var value$1 = value(n);
    return isText(n) && value$1 !== undefined && regExp.test(value$1);
  };

  var filterDescendants = function filterDescendants(scope, predicate) {
    var result = [];
    var dom = scope.dom;
    var children = map(dom.childNodes, SugarElement.fromDom);
    each$1(children, function (x) {
      if (predicate(x)) {
        result = result.concat([x]);
      }

      result = result.concat(filterDescendants(x, predicate));
    });
    return result;
  };

  var findParentElm = function findParentElm(elm, rootElm) {
    while (elm.parentNode) {
      if (elm.parentNode === rootElm) {
        return elm;
      }

      elm = elm.parentNode;
    }
  };

  var replaceWithSpans = function replaceWithSpans(text) {
    return text.replace(regExpGlobal, wrapCharWithSpan);
  };

  var isWrappedNbsp = function isWrappedNbsp(node) {
    return node.nodeName.toLowerCase() === 'span' && node.classList.contains('mce-nbsp-wrap');
  };

  var show = function show(editor, rootElm) {
    var nodeList = filterDescendants(SugarElement.fromDom(rootElm), isMatch);
    each$1(nodeList, function (n) {
      var parent = n.dom.parentNode;

      if (isWrappedNbsp(parent)) {
        add(SugarElement.fromDom(parent), nbspClass);
      } else {
        var withSpans = replaceWithSpans(editor.dom.encode(value(n)));
        var div = editor.dom.create('div', null, withSpans);
        var node = void 0;

        while (node = div.lastChild) {
          editor.dom.insertAfter(node, n.dom);
        }

        editor.dom.remove(n.dom);
      }
    });
  };

  var hide = function hide(editor, rootElm) {
    var nodeList = editor.dom.select(selector, rootElm);
    each$1(nodeList, function (node) {
      if (isWrappedNbsp(node)) {
        remove(SugarElement.fromDom(node), nbspClass);
      } else {
        editor.dom.remove(node, true);
      }
    });
  };

  var toggle = function toggle(editor) {
    var body = editor.getBody();
    var bookmark = editor.selection.getBookmark();
    var parentNode = findParentElm(editor.selection.getNode(), body);
    parentNode = parentNode !== undefined ? parentNode : body;
    hide(editor, parentNode);
    show(editor, parentNode);
    editor.selection.moveToBookmark(bookmark);
  };

  var applyVisualChars = function applyVisualChars(editor, toggleState) {
    fireVisualChars(editor, toggleState.get());
    var body = editor.getBody();

    if (toggleState.get() === true) {
      show(editor, body);
    } else {
      hide(editor, body);
    }
  };

  var toggleVisualChars = function toggleVisualChars(editor, toggleState) {
    toggleState.set(!toggleState.get());
    var bookmark = editor.selection.getBookmark();
    applyVisualChars(editor, toggleState);
    editor.selection.moveToBookmark(bookmark);
  };

  var register$1 = function register$1(editor, toggleState) {
    editor.addCommand('mceVisualChars', function () {
      toggleVisualChars(editor, toggleState);
    });
  };

  var isEnabledByDefault = function isEnabledByDefault(editor) {
    return editor.getParam('visualchars_default_state', false);
  };

  var hasForcedRootBlock = function hasForcedRootBlock(editor) {
    return editor.getParam('forced_root_block') !== false;
  };

  var setup$1 = function setup$1(editor, toggleState) {
    editor.on('init', function () {
      applyVisualChars(editor, toggleState);
    });
  };

  var global = tinymce.util.Tools.resolve('tinymce.util.Delay');

  var setup = function setup(editor, toggleState) {
    var debouncedToggle = global.debounce(function () {
      toggle(editor);
    }, 300);

    if (hasForcedRootBlock(editor)) {
      editor.on('keydown', function (e) {
        if (toggleState.get() === true) {
          e.keyCode === 13 ? toggle(editor) : debouncedToggle();
        }
      });
    }

    editor.on('remove', debouncedToggle.stop);
  };

  var toggleActiveState = function toggleActiveState(editor, enabledStated) {
    return function (api) {
      api.setActive(enabledStated.get());

      var editorEventCallback = function editorEventCallback(e) {
        return api.setActive(e.state);
      };

      editor.on('VisualChars', editorEventCallback);
      return function () {
        return editor.off('VisualChars', editorEventCallback);
      };
    };
  };

  var register = function register(editor, toggleState) {
    var onAction = function onAction() {
      return editor.execCommand('mceVisualChars');
    };

    editor.ui.registry.addToggleButton('visualchars', {
      tooltip: 'Show invisible characters',
      icon: 'visualchars',
      onAction: onAction,
      onSetup: toggleActiveState(editor, toggleState)
    });
    editor.ui.registry.addToggleMenuItem('visualchars', {
      text: 'Show invisible characters',
      icon: 'visualchars',
      onAction: onAction,
      onSetup: toggleActiveState(editor, toggleState)
    });
  };

  function Plugin() {
    global$1.add('visualchars', function (editor) {
      var toggleState = Cell(isEnabledByDefault(editor));
      register$1(editor, toggleState);
      register(editor, toggleState);
      setup(editor, toggleState);
      setup$1(editor, toggleState);
      return get$2(toggleState);
    });
  }

  Plugin();
})();
/******/ })()
;