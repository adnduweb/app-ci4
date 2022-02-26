/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/backend/core/plugins/custom/tinymce/plugins/link/plugin.js":
/*!******************************************************************************!*\
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/link/plugin.js ***!
  \******************************************************************************/
/***/ (() => {

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

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

  var global$7 = tinymce.util.Tools.resolve('tinymce.PluginManager');
  var global$6 = tinymce.util.Tools.resolve('tinymce.util.VK');

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

  var isSimpleType = function isSimpleType(type) {
    return function (value) {
      return _typeof(value) === type;
    };
  };

  var eq = function eq(t) {
    return function (a) {
      return t === a;
    };
  };

  var isString = isType('string');
  var isArray = isType('array');
  var isNull = eq(null);
  var isBoolean = isSimpleType('boolean');
  var isFunction = isSimpleType('function');

  var noop = function noop() {};

  var constant = function constant(value) {
    return function () {
      return value;
    };
  };

  var identity = function identity(x) {
    return x;
  };

  var tripleEquals = function tripleEquals(a, b) {
    return a === b;
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
  var nativeIndexOf = Array.prototype.indexOf;
  var nativePush = Array.prototype.push;

  var rawIndexOf = function rawIndexOf(ts, t) {
    return nativeIndexOf.call(ts, t);
  };

  var contains = function contains(xs, x) {
    return rawIndexOf(xs, x) > -1;
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

  var foldl = function foldl(xs, f, acc) {
    each$1(xs, function (x, i) {
      acc = f(acc, x, i);
    });
    return acc;
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

  var findMap = function findMap(arr, f) {
    for (var i = 0; i < arr.length; i++) {
      var r = f(arr[i], i);

      if (r.isSome()) {
        return r;
      }
    }

    return Optional.none();
  };

  var is = function is(lhs, rhs, comparator) {
    if (comparator === void 0) {
      comparator = tripleEquals;
    }

    return lhs.exists(function (left) {
      return comparator(left, rhs);
    });
  };

  var cat = function cat(arr) {
    var r = [];

    var push = function push(x) {
      r.push(x);
    };

    for (var i = 0; i < arr.length; i++) {
      arr[i].each(push);
    }

    return r;
  };

  var someIf = function someIf(b, a) {
    return b ? Optional.some(a) : Optional.none();
  };

  var assumeExternalTargets = function assumeExternalTargets(editor) {
    var externalTargets = editor.getParam('link_assume_external_targets', false);

    if (isBoolean(externalTargets) && externalTargets) {
      return 1;
    } else if (isString(externalTargets) && (externalTargets === 'http' || externalTargets === 'https')) {
      return externalTargets;
    }

    return 0;
  };

  var hasContextToolbar = function hasContextToolbar(editor) {
    return editor.getParam('link_context_toolbar', false, 'boolean');
  };

  var getLinkList = function getLinkList(editor) {
    return editor.getParam('link_list');
  };

  var getDefaultLinkTarget = function getDefaultLinkTarget(editor) {
    return editor.getParam('default_link_target');
  };

  var getTargetList = function getTargetList(editor) {
    return editor.getParam('target_list', true);
  };

  var getRelList = function getRelList(editor) {
    return editor.getParam('rel_list', [], 'array');
  };

  var getLinkClassList = function getLinkClassList(editor) {
    return editor.getParam('link_class_list', [], 'array');
  };

  var shouldShowLinkTitle = function shouldShowLinkTitle(editor) {
    return editor.getParam('link_title', true, 'boolean');
  };

  var allowUnsafeLinkTarget = function allowUnsafeLinkTarget(editor) {
    return editor.getParam('allow_unsafe_link_target', false, 'boolean');
  };

  var useQuickLink = function useQuickLink(editor) {
    return editor.getParam('link_quicklink', false, 'boolean');
  };

  var getDefaultLinkProtocol = function getDefaultLinkProtocol(editor) {
    return editor.getParam('link_default_protocol', 'http', 'string');
  };

  var global$5 = tinymce.util.Tools.resolve('tinymce.util.Tools');

  var getValue = function getValue(item) {
    return isString(item.value) ? item.value : '';
  };

  var getText = function getText(item) {
    if (isString(item.text)) {
      return item.text;
    } else if (isString(item.title)) {
      return item.title;
    } else {
      return '';
    }
  };

  var sanitizeList = function sanitizeList(list, extractValue) {
    var out = [];
    global$5.each(list, function (item) {
      var text = getText(item);

      if (item.menu !== undefined) {
        var items = sanitizeList(item.menu, extractValue);
        out.push({
          text: text,
          items: items
        });
      } else {
        var value = extractValue(item);
        out.push({
          text: text,
          value: value
        });
      }
    });
    return out;
  };

  var sanitizeWith = function sanitizeWith(extracter) {
    if (extracter === void 0) {
      extracter = getValue;
    }

    return function (list) {
      return Optional.from(list).map(function (list) {
        return sanitizeList(list, extracter);
      });
    };
  };

  var sanitize = function sanitize(list) {
    return sanitizeWith(getValue)(list);
  };

  var createUi = function createUi(name, label) {
    return function (items) {
      return {
        name: name,
        type: 'listbox',
        label: label,
        items: items
      };
    };
  };

  var ListOptions = {
    sanitize: sanitize,
    sanitizeWith: sanitizeWith,
    createUi: createUi,
    getValue: getValue
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

  var objAcc = function objAcc(r) {
    return function (x, i) {
      r[i] = x;
    };
  };

  var internalFilter = function internalFilter(obj, pred, onTrue, onFalse) {
    var r = {};
    each(obj, function (x, i) {
      (pred(x, i) ? onTrue : onFalse)(x, i);
    });
    return r;
  };

  var filter = function filter(obj, pred) {
    var t = {};
    internalFilter(obj, pred, objAcc(t), noop);
    return t;
  };

  var has = function has(obj, key) {
    return hasOwnProperty.call(obj, key);
  };

  var hasNonNullableKey = function hasNonNullableKey(obj, key) {
    return has(obj, key) && obj[key] !== undefined && obj[key] !== null;
  };

  var global$4 = tinymce.util.Tools.resolve('tinymce.dom.TreeWalker');
  var global$3 = tinymce.util.Tools.resolve('tinymce.util.URI');

  var isAnchor = function isAnchor(elm) {
    return elm && elm.nodeName.toLowerCase() === 'a';
  };

  var isLink = function isLink(elm) {
    return isAnchor(elm) && !!getHref(elm);
  };

  var collectNodesInRange = function collectNodesInRange(rng, predicate) {
    if (rng.collapsed) {
      return [];
    } else {
      var contents = rng.cloneContents();
      var walker = new global$4(contents.firstChild, contents);
      var elements = [];
      var current = contents.firstChild;

      do {
        if (predicate(current)) {
          elements.push(current);
        }
      } while (current = walker.next());

      return elements;
    }
  };

  var hasProtocol = function hasProtocol(url) {
    return /^\w+:/i.test(url);
  };

  var getHref = function getHref(elm) {
    var href = elm.getAttribute('data-mce-href');
    return href ? href : elm.getAttribute('href');
  };

  var applyRelTargetRules = function applyRelTargetRules(rel, isUnsafe) {
    var rules = ['noopener'];
    var rels = rel ? rel.split(/\s+/) : [];

    var toString = function toString(rels) {
      return global$5.trim(rels.sort().join(' '));
    };

    var addTargetRules = function addTargetRules(rels) {
      rels = removeTargetRules(rels);
      return rels.length > 0 ? rels.concat(rules) : rules;
    };

    var removeTargetRules = function removeTargetRules(rels) {
      return rels.filter(function (val) {
        return global$5.inArray(rules, val) === -1;
      });
    };

    var newRels = isUnsafe ? addTargetRules(rels) : removeTargetRules(rels);
    return newRels.length > 0 ? toString(newRels) : '';
  };

  var trimCaretContainers = function trimCaretContainers(text) {
    return text.replace(/\uFEFF/g, '');
  };

  var getAnchorElement = function getAnchorElement(editor, selectedElm) {
    selectedElm = selectedElm || editor.selection.getNode();

    if (isImageFigure(selectedElm)) {
      return editor.dom.select('a[href]', selectedElm)[0];
    } else {
      return editor.dom.getParent(selectedElm, 'a[href]');
    }
  };

  var getAnchorText = function getAnchorText(selection, anchorElm) {
    var text = anchorElm ? anchorElm.innerText || anchorElm.textContent : selection.getContent({
      format: 'text'
    });
    return trimCaretContainers(text);
  };

  var hasLinks = function hasLinks(elements) {
    return global$5.grep(elements, isLink).length > 0;
  };

  var hasLinksInSelection = function hasLinksInSelection(rng) {
    return collectNodesInRange(rng, isLink).length > 0;
  };

  var isOnlyTextSelected = function isOnlyTextSelected(editor) {
    var inlineTextElements = editor.schema.getTextInlineElements();

    var isElement = function isElement(elm) {
      return elm.nodeType === 1 && !isAnchor(elm) && !has(inlineTextElements, elm.nodeName.toLowerCase());
    };

    var elements = collectNodesInRange(editor.selection.getRng(), isElement);
    return elements.length === 0;
  };

  var isImageFigure = function isImageFigure(elm) {
    return elm && elm.nodeName === 'FIGURE' && /\bimage\b/i.test(elm.className);
  };

  var getLinkAttrs = function getLinkAttrs(data) {
    var attrs = ['title', 'rel', 'class', 'target'];
    return foldl(attrs, function (acc, key) {
      data[key].each(function (value) {
        acc[key] = value.length > 0 ? value : null;
      });
      return acc;
    }, {
      href: data.href
    });
  };

  var handleExternalTargets = function handleExternalTargets(href, assumeExternalTargets) {
    if ((assumeExternalTargets === 'http' || assumeExternalTargets === 'https') && !hasProtocol(href)) {
      return assumeExternalTargets + '://' + href;
    }

    return href;
  };

  var applyLinkOverrides = function applyLinkOverrides(editor, linkAttrs) {
    var newLinkAttrs = _assign({}, linkAttrs);

    if (!(getRelList(editor).length > 0) && allowUnsafeLinkTarget(editor) === false) {
      var newRel = applyRelTargetRules(newLinkAttrs.rel, newLinkAttrs.target === '_blank');
      newLinkAttrs.rel = newRel ? newRel : null;
    }

    if (Optional.from(newLinkAttrs.target).isNone() && getTargetList(editor) === false) {
      newLinkAttrs.target = getDefaultLinkTarget(editor);
    }

    newLinkAttrs.href = handleExternalTargets(newLinkAttrs.href, assumeExternalTargets(editor));
    return newLinkAttrs;
  };

  var updateLink = function updateLink(editor, anchorElm, text, linkAttrs) {
    text.each(function (text) {
      if (has(anchorElm, 'innerText')) {
        anchorElm.innerText = text;
      } else {
        anchorElm.textContent = text;
      }
    });
    editor.dom.setAttribs(anchorElm, linkAttrs);
    editor.selection.select(anchorElm);
  };

  var createLink = function createLink(editor, selectedElm, text, linkAttrs) {
    if (isImageFigure(selectedElm)) {
      linkImageFigure(editor, selectedElm, linkAttrs);
    } else {
      text.fold(function () {
        editor.execCommand('mceInsertLink', false, linkAttrs);
      }, function (text) {
        editor.insertContent(editor.dom.createHTML('a', linkAttrs, editor.dom.encode(text)));
      });
    }
  };

  var linkDomMutation = function linkDomMutation(editor, attachState, data) {
    var selectedElm = editor.selection.getNode();
    var anchorElm = getAnchorElement(editor, selectedElm);
    var linkAttrs = applyLinkOverrides(editor, getLinkAttrs(data));
    editor.undoManager.transact(function () {
      if (data.href === attachState.href) {
        attachState.attach();
      }

      if (anchorElm) {
        editor.focus();
        updateLink(editor, anchorElm, data.text, linkAttrs);
      } else {
        createLink(editor, selectedElm, data.text, linkAttrs);
      }
    });
  };

  var unlinkSelection = function unlinkSelection(editor) {
    var dom = editor.dom,
        selection = editor.selection;
    var bookmark = selection.getBookmark();
    var rng = selection.getRng().cloneRange();
    var startAnchorElm = dom.getParent(rng.startContainer, 'a[href]', editor.getBody());
    var endAnchorElm = dom.getParent(rng.endContainer, 'a[href]', editor.getBody());

    if (startAnchorElm) {
      rng.setStartBefore(startAnchorElm);
    }

    if (endAnchorElm) {
      rng.setEndAfter(endAnchorElm);
    }

    selection.setRng(rng);
    editor.execCommand('unlink');
    selection.moveToBookmark(bookmark);
  };

  var unlinkDomMutation = function unlinkDomMutation(editor) {
    editor.undoManager.transact(function () {
      var node = editor.selection.getNode();

      if (isImageFigure(node)) {
        unlinkImageFigure(editor, node);
      } else {
        unlinkSelection(editor);
      }

      editor.focus();
    });
  };

  var unwrapOptions = function unwrapOptions(data) {
    var cls = data["class"],
        href = data.href,
        rel = data.rel,
        target = data.target,
        text = data.text,
        title = data.title;
    return filter({
      "class": cls.getOrNull(),
      href: href,
      rel: rel.getOrNull(),
      target: target.getOrNull(),
      text: text.getOrNull(),
      title: title.getOrNull()
    }, function (v, _k) {
      return isNull(v) === false;
    });
  };

  var sanitizeData = function sanitizeData(editor, data) {
    var href = data.href;
    return _assign(_assign({}, data), {
      href: global$3.isDomSafe(href, 'a', editor.settings) ? href : ''
    });
  };

  var link = function link(editor, attachState, data) {
    var sanitizedData = sanitizeData(editor, data);
    editor.hasPlugin('rtc', true) ? editor.execCommand('createlink', false, unwrapOptions(sanitizedData)) : linkDomMutation(editor, attachState, sanitizedData);
  };

  var unlink = function unlink(editor) {
    editor.hasPlugin('rtc', true) ? editor.execCommand('unlink') : unlinkDomMutation(editor);
  };

  var unlinkImageFigure = function unlinkImageFigure(editor, fig) {
    var img = editor.dom.select('img', fig)[0];

    if (img) {
      var a = editor.dom.getParents(img, 'a[href]', fig)[0];

      if (a) {
        a.parentNode.insertBefore(img, a);
        editor.dom.remove(a);
      }
    }
  };

  var linkImageFigure = function linkImageFigure(editor, fig, attrs) {
    var img = editor.dom.select('img', fig)[0];

    if (img) {
      var a = editor.dom.create('a', attrs);
      img.parentNode.insertBefore(a, img);
      a.appendChild(img);
    }
  };

  var isListGroup = function isListGroup(item) {
    return hasNonNullableKey(item, 'items');
  };

  var findTextByValue = function findTextByValue(value, catalog) {
    return findMap(catalog, function (item) {
      if (isListGroup(item)) {
        return findTextByValue(value, item.items);
      } else {
        return someIf(item.value === value, item);
      }
    });
  };

  var getDelta = function getDelta(persistentText, fieldName, catalog, data) {
    var value = data[fieldName];
    var hasPersistentText = persistentText.length > 0;
    return value !== undefined ? findTextByValue(value, catalog).map(function (i) {
      return {
        url: {
          value: i.value,
          meta: {
            text: hasPersistentText ? persistentText : i.text,
            attach: noop
          }
        },
        text: hasPersistentText ? persistentText : i.text
      };
    }) : Optional.none();
  };

  var findCatalog = function findCatalog(catalogs, fieldName) {
    if (fieldName === 'link') {
      return catalogs.link;
    } else if (fieldName === 'anchor') {
      return catalogs.anchor;
    } else {
      return Optional.none();
    }
  };

  var init = function init(initialData, linkCatalog) {
    var persistentData = {
      text: initialData.text,
      title: initialData.title
    };

    var getTitleFromUrlChange = function getTitleFromUrlChange(url) {
      return someIf(persistentData.title.length <= 0, Optional.from(url.meta.title).getOr(''));
    };

    var getTextFromUrlChange = function getTextFromUrlChange(url) {
      return someIf(persistentData.text.length <= 0, Optional.from(url.meta.text).getOr(url.value));
    };

    var onUrlChange = function onUrlChange(data) {
      var text = getTextFromUrlChange(data.url);
      var title = getTitleFromUrlChange(data.url);

      if (text.isSome() || title.isSome()) {
        return Optional.some(_assign(_assign({}, text.map(function (text) {
          return {
            text: text
          };
        }).getOr({})), title.map(function (title) {
          return {
            title: title
          };
        }).getOr({})));
      } else {
        return Optional.none();
      }
    };

    var onCatalogChange = function onCatalogChange(data, change) {
      var catalog = findCatalog(linkCatalog, change.name).getOr([]);
      return getDelta(persistentData.text, change.name, catalog, data);
    };

    var onChange = function onChange(getData, change) {
      var name = change.name;

      if (name === 'url') {
        return onUrlChange(getData());
      } else if (contains(['anchor', 'link'], name)) {
        return onCatalogChange(getData(), change);
      } else if (name === 'text' || name === 'title') {
        persistentData[name] = getData()[name];
        return Optional.none();
      } else {
        return Optional.none();
      }
    };

    return {
      onChange: onChange
    };
  };

  var DialogChanges = {
    init: init,
    getDelta: getDelta
  };
  var global$2 = tinymce.util.Tools.resolve('tinymce.util.Delay');
  var global$1 = tinymce.util.Tools.resolve('tinymce.util.Promise');

  var delayedConfirm = function delayedConfirm(editor, message, callback) {
    var rng = editor.selection.getRng();
    global$2.setEditorTimeout(editor, function () {
      editor.windowManager.confirm(message, function (state) {
        editor.selection.setRng(rng);
        callback(state);
      });
    });
  };

  var tryEmailTransform = function tryEmailTransform(data) {
    var url = data.href;
    var suggestMailTo = url.indexOf('@') > 0 && url.indexOf('/') === -1 && url.indexOf('mailto:') === -1;
    return suggestMailTo ? Optional.some({
      message: 'The URL you entered seems to be an email address. Do you want to add the required mailto: prefix?',
      preprocess: function preprocess(oldData) {
        return _assign(_assign({}, oldData), {
          href: 'mailto:' + url
        });
      }
    }) : Optional.none();
  };

  var tryProtocolTransform = function tryProtocolTransform(assumeExternalTargets, defaultLinkProtocol) {
    return function (data) {
      var url = data.href;
      var suggestProtocol = assumeExternalTargets === 1 && !hasProtocol(url) || assumeExternalTargets === 0 && /^\s*www(\.|\d\.)/i.test(url);
      return suggestProtocol ? Optional.some({
        message: 'The URL you entered seems to be an external link. Do you want to add the required ' + defaultLinkProtocol + ':// prefix?',
        preprocess: function preprocess(oldData) {
          return _assign(_assign({}, oldData), {
            href: defaultLinkProtocol + '://' + url
          });
        }
      }) : Optional.none();
    };
  };

  var preprocess = function preprocess(editor, data) {
    return findMap([tryEmailTransform, tryProtocolTransform(assumeExternalTargets(editor), getDefaultLinkProtocol(editor))], function (f) {
      return f(data);
    }).fold(function () {
      return global$1.resolve(data);
    }, function (transform) {
      return new global$1(function (callback) {
        delayedConfirm(editor, transform.message, function (state) {
          callback(state ? transform.preprocess(data) : data);
        });
      });
    });
  };

  var DialogConfirms = {
    preprocess: preprocess
  };

  var getAnchors = function getAnchors(editor) {
    var anchorNodes = editor.dom.select('a:not([href])');
    var anchors = bind(anchorNodes, function (anchor) {
      var id = anchor.name || anchor.id;
      return id ? [{
        text: id,
        value: '#' + id
      }] : [];
    });
    return anchors.length > 0 ? Optional.some([{
      text: 'None',
      value: ''
    }].concat(anchors)) : Optional.none();
  };

  var AnchorListOptions = {
    getAnchors: getAnchors
  };

  var getClasses = function getClasses(editor) {
    var list = getLinkClassList(editor);

    if (list.length > 0) {
      return ListOptions.sanitize(list);
    }

    return Optional.none();
  };

  var ClassListOptions = {
    getClasses: getClasses
  };
  var global = tinymce.util.Tools.resolve('tinymce.util.XHR');

  var parseJson = function parseJson(text) {
    try {
      return Optional.some(JSON.parse(text));
    } catch (err) {
      return Optional.none();
    }
  };

  var getLinks = function getLinks(editor) {
    var extractor = function extractor(item) {
      return editor.convertURL(item.value || item.url, 'href');
    };

    var linkList = getLinkList(editor);
    return new global$1(function (callback) {
      if (isString(linkList)) {
        global.send({
          url: linkList,
          success: function success(text) {
            return callback(parseJson(text));
          },
          error: function error(_) {
            return callback(Optional.none());
          }
        });
      } else if (isFunction(linkList)) {
        linkList(function (output) {
          return callback(Optional.some(output));
        });
      } else {
        callback(Optional.from(linkList));
      }
    }).then(function (optItems) {
      return optItems.bind(ListOptions.sanitizeWith(extractor)).map(function (items) {
        if (items.length > 0) {
          var noneItem = [{
            text: 'None',
            value: ''
          }];
          return noneItem.concat(items);
        } else {
          return items;
        }
      });
    });
  };

  var LinkListOptions = {
    getLinks: getLinks
  };

  var getRels = function getRels(editor, initialTarget) {
    var list = getRelList(editor);

    if (list.length > 0) {
      var isTargetBlank_1 = is(initialTarget, '_blank');
      var enforceSafe = allowUnsafeLinkTarget(editor) === false;

      var safeRelExtractor = function safeRelExtractor(item) {
        return applyRelTargetRules(ListOptions.getValue(item), isTargetBlank_1);
      };

      var sanitizer = enforceSafe ? ListOptions.sanitizeWith(safeRelExtractor) : ListOptions.sanitize;
      return sanitizer(list);
    }

    return Optional.none();
  };

  var RelOptions = {
    getRels: getRels
  };
  var fallbacks = [{
    text: 'Current window',
    value: ''
  }, {
    text: 'New window',
    value: '_blank'
  }];

  var getTargets = function getTargets(editor) {
    var list = getTargetList(editor);

    if (isArray(list)) {
      return ListOptions.sanitize(list).orThunk(function () {
        return Optional.some(fallbacks);
      });
    } else if (list === false) {
      return Optional.none();
    }

    return Optional.some(fallbacks);
  };

  var TargetOptions = {
    getTargets: getTargets
  };

  var nonEmptyAttr = function nonEmptyAttr(dom, elem, name) {
    var val = dom.getAttrib(elem, name);
    return val !== null && val.length > 0 ? Optional.some(val) : Optional.none();
  };

  var extractFromAnchor = function extractFromAnchor(editor, anchor) {
    var dom = editor.dom;
    var onlyText = isOnlyTextSelected(editor);
    var text = onlyText ? Optional.some(getAnchorText(editor.selection, anchor)) : Optional.none();
    var url = anchor ? Optional.some(dom.getAttrib(anchor, 'href')) : Optional.none();
    var target = anchor ? Optional.from(dom.getAttrib(anchor, 'target')) : Optional.none();
    var rel = nonEmptyAttr(dom, anchor, 'rel');
    var linkClass = nonEmptyAttr(dom, anchor, 'class');
    var title = nonEmptyAttr(dom, anchor, 'title');
    return {
      url: url,
      text: text,
      title: title,
      target: target,
      rel: rel,
      linkClass: linkClass
    };
  };

  var collect = function collect(editor, linkNode) {
    return LinkListOptions.getLinks(editor).then(function (links) {
      var anchor = extractFromAnchor(editor, linkNode);
      return {
        anchor: anchor,
        catalogs: {
          targets: TargetOptions.getTargets(editor),
          rels: RelOptions.getRels(editor, anchor.target),
          classes: ClassListOptions.getClasses(editor),
          anchor: AnchorListOptions.getAnchors(editor),
          link: links
        },
        optNode: Optional.from(linkNode),
        flags: {
          titleEnabled: shouldShowLinkTitle(editor)
        }
      };
    });
  };

  var DialogInfo = {
    collect: collect
  };

  var handleSubmit = function handleSubmit(editor, info) {
    return function (api) {
      var data = api.getData();

      if (!data.url.value) {
        unlink(editor);
        api.close();
        return;
      }

      var getChangedValue = function getChangedValue(key) {
        return Optional.from(data[key]).filter(function (value) {
          return !is(info.anchor[key], value);
        });
      };

      var changedData = {
        href: data.url.value,
        text: getChangedValue('text'),
        target: getChangedValue('target'),
        rel: getChangedValue('rel'),
        "class": getChangedValue('linkClass'),
        title: getChangedValue('title')
      };
      var attachState = {
        href: data.url.value,
        attach: data.url.meta !== undefined && data.url.meta.attach ? data.url.meta.attach : noop
      };
      DialogConfirms.preprocess(editor, changedData).then(function (pData) {
        link(editor, attachState, pData);
      });
      api.close();
    };
  };

  var collectData = function collectData(editor) {
    var anchorNode = getAnchorElement(editor);
    return DialogInfo.collect(editor, anchorNode);
  };

  var getInitialData = function getInitialData(info, defaultTarget) {
    var anchor = info.anchor;
    var url = anchor.url.getOr('');
    return {
      url: {
        value: url,
        meta: {
          original: {
            value: url
          }
        }
      },
      text: anchor.text.getOr(''),
      title: anchor.title.getOr(''),
      anchor: url,
      link: url,
      rel: anchor.rel.getOr(''),
      target: anchor.target.or(defaultTarget).getOr(''),
      linkClass: anchor.linkClass.getOr('')
    };
  };

  var makeDialog = function makeDialog(settings, onSubmit, editor) {
    var urlInput = [{
      name: 'url',
      type: 'urlinput',
      filetype: 'file',
      label: 'URL'
    }];
    var displayText = settings.anchor.text.map(function () {
      return {
        name: 'text',
        type: 'input',
        label: 'Text to display'
      };
    }).toArray();
    var titleText = settings.flags.titleEnabled ? [{
      name: 'title',
      type: 'input',
      label: 'Title'
    }] : [];
    var defaultTarget = Optional.from(getDefaultLinkTarget(editor));
    var initialData = getInitialData(settings, defaultTarget);
    var catalogs = settings.catalogs;
    var dialogDelta = DialogChanges.init(initialData, catalogs);
    var body = {
      type: 'panel',
      items: flatten([urlInput, displayText, titleText, cat([catalogs.anchor.map(ListOptions.createUi('anchor', 'Anchors')), catalogs.rels.map(ListOptions.createUi('rel', 'Rel')), catalogs.targets.map(ListOptions.createUi('target', 'Open link in...')), catalogs.link.map(ListOptions.createUi('link', 'Link list')), catalogs.classes.map(ListOptions.createUi('linkClass', 'Class'))])])
    };
    return {
      title: 'Insert/Edit Link',
      size: 'normal',
      body: body,
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
      initialData: initialData,
      onChange: function onChange(api, _a) {
        var name = _a.name;
        dialogDelta.onChange(api.getData, {
          name: name
        }).each(function (newData) {
          api.setData(newData);
        });
      },
      onSubmit: onSubmit
    };
  };

  var open$1 = function open$1(editor) {
    var data = collectData(editor);
    data.then(function (info) {
      var onSubmit = handleSubmit(editor, info);
      return makeDialog(info, onSubmit, editor);
    }).then(function (spec) {
      editor.windowManager.open(spec);
    });
  };

  var appendClickRemove = function appendClickRemove(link, evt) {
    document.body.appendChild(link);
    link.dispatchEvent(evt);
    document.body.removeChild(link);
  };

  var open = function open(url) {
    var link = document.createElement('a');
    link.target = '_blank';
    link.href = url;
    link.rel = 'noreferrer noopener';
    var evt = document.createEvent('MouseEvents');
    evt.initMouseEvent('click', true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
    appendClickRemove(link, evt);
  };

  var getLink = function getLink(editor, elm) {
    return editor.dom.getParent(elm, 'a[href]');
  };

  var getSelectedLink = function getSelectedLink(editor) {
    return getLink(editor, editor.selection.getStart());
  };

  var hasOnlyAltModifier = function hasOnlyAltModifier(e) {
    return e.altKey === true && e.shiftKey === false && e.ctrlKey === false && e.metaKey === false;
  };

  var gotoLink = function gotoLink(editor, a) {
    if (a) {
      var href = getHref(a);

      if (/^#/.test(href)) {
        var targetEl = editor.$(href);

        if (targetEl.length) {
          editor.selection.scrollIntoView(targetEl[0], true);
        }
      } else {
        open(a.href);
      }
    }
  };

  var openDialog = function openDialog(editor) {
    return function () {
      open$1(editor);
    };
  };

  var gotoSelectedLink = function gotoSelectedLink(editor) {
    return function () {
      gotoLink(editor, getSelectedLink(editor));
    };
  };

  var setupGotoLinks = function setupGotoLinks(editor) {
    editor.on('click', function (e) {
      var link = getLink(editor, e.target);

      if (link && global$6.metaKeyPressed(e)) {
        e.preventDefault();
        gotoLink(editor, link);
      }
    });
    editor.on('keydown', function (e) {
      var link = getSelectedLink(editor);

      if (link && e.keyCode === 13 && hasOnlyAltModifier(e)) {
        e.preventDefault();
        gotoLink(editor, link);
      }
    });
  };

  var toggleState = function toggleState(editor, toggler) {
    editor.on('NodeChange', toggler);
    return function () {
      return editor.off('NodeChange', toggler);
    };
  };

  var toggleActiveState = function toggleActiveState(editor) {
    return function (api) {
      var updateState = function updateState() {
        return api.setActive(!editor.mode.isReadOnly() && getAnchorElement(editor, editor.selection.getNode()) !== null);
      };

      updateState();
      return toggleState(editor, updateState);
    };
  };

  var toggleEnabledState = function toggleEnabledState(editor) {
    return function (api) {
      var updateState = function updateState() {
        return api.setDisabled(getAnchorElement(editor, editor.selection.getNode()) === null);
      };

      updateState();
      return toggleState(editor, updateState);
    };
  };

  var toggleUnlinkState = function toggleUnlinkState(editor) {
    return function (api) {
      var hasLinks$1 = function hasLinks$1(parents) {
        return hasLinks(parents) || hasLinksInSelection(editor.selection.getRng());
      };

      var parents = editor.dom.getParents(editor.selection.getStart());
      api.setDisabled(!hasLinks$1(parents));
      return toggleState(editor, function (e) {
        return api.setDisabled(!hasLinks$1(e.parents));
      });
    };
  };

  var register = function register(editor) {
    editor.addCommand('mceLink', function () {
      if (useQuickLink(editor)) {
        editor.fire('contexttoolbar-show', {
          toolbarKey: 'quicklink'
        });
      } else {
        openDialog(editor)();
      }
    });
  };

  var setup = function setup(editor) {
    editor.addShortcut('Meta+K', '', function () {
      editor.execCommand('mceLink');
    });
  };

  var setupButtons = function setupButtons(editor) {
    editor.ui.registry.addToggleButton('link', {
      icon: 'link',
      tooltip: 'Insert/edit link',
      onAction: openDialog(editor),
      onSetup: toggleActiveState(editor)
    });
    editor.ui.registry.addButton('openlink', {
      icon: 'new-tab',
      tooltip: 'Open link',
      onAction: gotoSelectedLink(editor),
      onSetup: toggleEnabledState(editor)
    });
    editor.ui.registry.addButton('unlink', {
      icon: 'unlink',
      tooltip: 'Remove link',
      onAction: function onAction() {
        return unlink(editor);
      },
      onSetup: toggleUnlinkState(editor)
    });
  };

  var setupMenuItems = function setupMenuItems(editor) {
    editor.ui.registry.addMenuItem('openlink', {
      text: 'Open link',
      icon: 'new-tab',
      onAction: gotoSelectedLink(editor),
      onSetup: toggleEnabledState(editor)
    });
    editor.ui.registry.addMenuItem('link', {
      icon: 'link',
      text: 'Link...',
      shortcut: 'Meta+K',
      onAction: openDialog(editor)
    });
    editor.ui.registry.addMenuItem('unlink', {
      icon: 'unlink',
      text: 'Remove link',
      onAction: function onAction() {
        return unlink(editor);
      },
      onSetup: toggleUnlinkState(editor)
    });
  };

  var setupContextMenu = function setupContextMenu(editor) {
    var inLink = 'link unlink openlink';
    var noLink = 'link';
    editor.ui.registry.addContextMenu('link', {
      update: function update(element) {
        return hasLinks(editor.dom.getParents(element, 'a')) ? inLink : noLink;
      }
    });
  };

  var setupContextToolbars = function setupContextToolbars(editor) {
    var collapseSelectionToEnd = function collapseSelectionToEnd(editor) {
      editor.selection.collapse(false);
    };

    var onSetupLink = function onSetupLink(buttonApi) {
      var node = editor.selection.getNode();
      buttonApi.setDisabled(!getAnchorElement(editor, node));
      return noop;
    };

    var getLinkText = function getLinkText(value) {
      var anchor = getAnchorElement(editor);
      var onlyText = isOnlyTextSelected(editor);

      if (!anchor && onlyText) {
        var text = getAnchorText(editor.selection, anchor);
        return Optional.some(text.length > 0 ? text : value);
      } else {
        return Optional.none();
      }
    };

    editor.ui.registry.addContextForm('quicklink', {
      launch: {
        type: 'contextformtogglebutton',
        icon: 'link',
        tooltip: 'Link',
        onSetup: toggleActiveState(editor)
      },
      label: 'Link',
      predicate: function predicate(node) {
        return !!getAnchorElement(editor, node) && hasContextToolbar(editor);
      },
      initValue: function initValue() {
        var elm = getAnchorElement(editor);
        return !!elm ? getHref(elm) : '';
      },
      commands: [{
        type: 'contextformtogglebutton',
        icon: 'link',
        tooltip: 'Link',
        primary: true,
        onSetup: function onSetup(buttonApi) {
          var node = editor.selection.getNode();
          buttonApi.setActive(!!getAnchorElement(editor, node));
          return toggleActiveState(editor)(buttonApi);
        },
        onAction: function onAction(formApi) {
          var value = formApi.getValue();
          var text = getLinkText(value);
          var attachState = {
            href: value,
            attach: noop
          };
          link(editor, attachState, {
            href: value,
            text: text,
            title: Optional.none(),
            rel: Optional.none(),
            target: Optional.none(),
            "class": Optional.none()
          });
          collapseSelectionToEnd(editor);
          formApi.hide();
        }
      }, {
        type: 'contextformbutton',
        icon: 'unlink',
        tooltip: 'Remove link',
        onSetup: onSetupLink,
        onAction: function onAction(formApi) {
          unlink(editor);
          formApi.hide();
        }
      }, {
        type: 'contextformbutton',
        icon: 'new-tab',
        tooltip: 'Open link',
        onSetup: onSetupLink,
        onAction: function onAction(formApi) {
          gotoSelectedLink(editor)();
          formApi.hide();
        }
      }]
    });
  };

  function Plugin() {
    global$7.add('link', function (editor) {
      setupButtons(editor);
      setupMenuItems(editor);
      setupContextMenu(editor);
      setupContextToolbars(editor);
      setupGotoLinks(editor);
      register(editor);
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
/*!*****************************************************************************!*\
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/link/index.js ***!
  \*****************************************************************************/
// Exports the "link" plugin for usage with module loaders
// Usage:
//   CommonJS:
//     require('tinymce/plugins/link')
//   ES2015:
//     import 'tinymce/plugins/link'
__webpack_require__(/*! ./plugin.js */ "./resources/backend/core/plugins/custom/tinymce/plugins/link/plugin.js");
})();

/******/ })()
;