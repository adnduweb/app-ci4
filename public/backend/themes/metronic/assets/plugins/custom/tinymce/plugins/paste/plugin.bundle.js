/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************************************************************!*\
  !*** ./resources/backend/core/plugins/custom/tinymce/plugins/paste/plugin.js ***!
  \*******************************************************************************/
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

  var global$b = tinymce.util.Tools.resolve('tinymce.PluginManager');

  var hasProPlugin = function hasProPlugin(editor) {
    if (editor.hasPlugin('powerpaste', true)) {
      if (typeof window.console !== 'undefined' && window.console.log) {
        window.console.log('PowerPaste is incompatible with Paste plugin! Remove \'paste\' from the \'plugins\' option.');
      }

      return true;
    } else {
      return false;
    }
  };

  var get = function get(clipboard) {
    return {
      clipboard: clipboard
    };
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

  var isArray = isType('array');

  var isNullable = function isNullable(a) {
    return a === null || a === undefined;
  };

  var isNonNullable = function isNonNullable(a) {
    return !isNullable(a);
  };

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

  var from$1 = function from$1(value) {
    return value === null || value === undefined ? NONE : some(value);
  };

  var Optional = {
    some: some,
    none: none,
    from: from$1
  };
  var nativeSlice = Array.prototype.slice;
  var nativePush = Array.prototype.push;

  var exists = function exists(xs, pred) {
    for (var i = 0, len = xs.length; i < len; i++) {
      var x = xs[i];

      if (pred(x, i)) {
        return true;
      }
    }

    return false;
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

  var each = function each(xs, f) {
    for (var i = 0, len = xs.length; i < len; i++) {
      var x = xs[i];
      f(x, i);
    }
  };

  var filter$1 = function filter$1(xs, pred) {
    var r = [];

    for (var i = 0, len = xs.length; i < len; i++) {
      var x = xs[i];

      if (pred(x, i)) {
        r.push(x);
      }
    }

    return r;
  };

  var foldl = function foldl(xs, f, acc) {
    each(xs, function (x, i) {
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

  var from = isFunction(Array.from) ? Array.from : function (x) {
    return nativeSlice.call(x);
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

  var startsWith = function startsWith(str, prefix) {
    return checkRange(str, prefix, 0);
  };

  var endsWith = function endsWith(str, suffix) {
    return checkRange(str, suffix, str.length - suffix.length);
  };

  var repeat = function repeat(s, count) {
    return count <= 0 ? '' : new Array(count + 1).join(s);
  };

  var global$a = tinymce.util.Tools.resolve('tinymce.Env');
  var global$9 = tinymce.util.Tools.resolve('tinymce.util.Delay');
  var global$8 = tinymce.util.Tools.resolve('tinymce.util.Promise');
  var global$7 = tinymce.util.Tools.resolve('tinymce.util.VK');

  var firePastePreProcess = function firePastePreProcess(editor, html, internal, isWordHtml) {
    return editor.fire('PastePreProcess', {
      content: html,
      internal: internal,
      wordContent: isWordHtml
    });
  };

  var firePastePostProcess = function firePastePostProcess(editor, node, internal, isWordHtml) {
    return editor.fire('PastePostProcess', {
      node: node,
      internal: internal,
      wordContent: isWordHtml
    });
  };

  var firePastePlainTextToggle = function firePastePlainTextToggle(editor, state) {
    return editor.fire('PastePlainTextToggle', {
      state: state
    });
  };

  var firePaste = function firePaste(editor, ieFake) {
    return editor.fire('paste', {
      ieFake: ieFake
    });
  };

  var global$6 = tinymce.util.Tools.resolve('tinymce.util.Tools');

  var shouldBlockDrop = function shouldBlockDrop(editor) {
    return editor.getParam('paste_block_drop', false);
  };

  var shouldPasteDataImages = function shouldPasteDataImages(editor) {
    return editor.getParam('paste_data_images', false);
  };

  var shouldFilterDrop = function shouldFilterDrop(editor) {
    return editor.getParam('paste_filter_drop', true);
  };

  var getPreProcess = function getPreProcess(editor) {
    return editor.getParam('paste_preprocess');
  };

  var getPostProcess = function getPostProcess(editor) {
    return editor.getParam('paste_postprocess');
  };

  var getWebkitStyles = function getWebkitStyles(editor) {
    return editor.getParam('paste_webkit_styles');
  };

  var shouldRemoveWebKitStyles = function shouldRemoveWebKitStyles(editor) {
    return editor.getParam('paste_remove_styles_if_webkit', true);
  };

  var shouldMergeFormats = function shouldMergeFormats(editor) {
    return editor.getParam('paste_merge_formats', true);
  };

  var isSmartPasteEnabled = function isSmartPasteEnabled(editor) {
    return editor.getParam('smart_paste', true);
  };

  var isPasteAsTextEnabled = function isPasteAsTextEnabled(editor) {
    return editor.getParam('paste_as_text', false);
  };

  var getRetainStyleProps = function getRetainStyleProps(editor) {
    return editor.getParam('paste_retain_style_properties');
  };

  var getWordValidElements = function getWordValidElements(editor) {
    var defaultValidElements = '-strong/b,-em/i,-u,-span,-p,-ol,-ul,-li,-h1,-h2,-h3,-h4,-h5,-h6,' + '-p/div,-a[href|name],sub,sup,strike,br,del,table[width],tr,' + 'td[colspan|rowspan|width],th[colspan|rowspan|width],thead,tfoot,tbody';
    return editor.getParam('paste_word_valid_elements', defaultValidElements);
  };

  var shouldConvertWordFakeLists = function shouldConvertWordFakeLists(editor) {
    return editor.getParam('paste_convert_word_fake_lists', true);
  };

  var shouldUseDefaultFilters = function shouldUseDefaultFilters(editor) {
    return editor.getParam('paste_enable_default_filters', true);
  };

  var getValidate = function getValidate(editor) {
    return editor.getParam('validate');
  };

  var getAllowHtmlDataUrls = function getAllowHtmlDataUrls(editor) {
    return editor.getParam('allow_html_data_urls', false, 'boolean');
  };

  var getPasteDataImages = function getPasteDataImages(editor) {
    return editor.getParam('paste_data_images', false, 'boolean');
  };

  var getImagesDataImgFilter = function getImagesDataImgFilter(editor) {
    return editor.getParam('images_dataimg_filter');
  };

  var getImagesReuseFilename = function getImagesReuseFilename(editor) {
    return editor.getParam('images_reuse_filename');
  };

  var getForcedRootBlock = function getForcedRootBlock(editor) {
    return editor.getParam('forced_root_block');
  };

  var getForcedRootBlockAttrs = function getForcedRootBlockAttrs(editor) {
    return editor.getParam('forced_root_block_attrs');
  };

  var getTabSpaces = function getTabSpaces(editor) {
    return editor.getParam('paste_tab_spaces', 4, 'number');
  };

  var getAllowedImageFileTypes = function getAllowedImageFileTypes(editor) {
    var defaultImageFileTypes = 'jpeg,jpg,jpe,jfi,jif,jfif,png,gif,bmp,webp';
    return global$6.explode(editor.getParam('images_file_types', defaultImageFileTypes, 'string'));
  };

  var internalMimeType = 'x-tinymce/html';
  var internalMark = '<!-- ' + internalMimeType + ' -->';

  var mark = function mark(html) {
    return internalMark + html;
  };

  var unmark = function unmark(html) {
    return html.replace(internalMark, '');
  };

  var isMarked = function isMarked(html) {
    return html.indexOf(internalMark) !== -1;
  };

  var internalHtmlMime = constant(internalMimeType);
  var hasOwnProperty = Object.hasOwnProperty;

  var has = function has(obj, key) {
    return hasOwnProperty.call(obj, key);
  };

  var global$5 = tinymce.util.Tools.resolve('tinymce.html.Entities');

  var isPlainText = function isPlainText(text) {
    return !/<(?:\/?(?!(?:div|p|br|span)>)\w+|(?:(?!(?:span style="white-space:\s?pre;?">)|br\s?\/>))\w+\s[^>]+)>/i.test(text);
  };

  var toBRs = function toBRs(text) {
    return text.replace(/\r?\n/g, '<br>');
  };

  var openContainer = function openContainer(rootTag, rootAttrs) {
    var attrs = [];
    var tag = '<' + rootTag;

    if (_typeof(rootAttrs) === 'object') {
      for (var key in rootAttrs) {
        if (has(rootAttrs, key)) {
          attrs.push(key + '="' + global$5.encodeAllRaw(rootAttrs[key]) + '"');
        }
      }

      if (attrs.length) {
        tag += ' ' + attrs.join(' ');
      }
    }

    return tag + '>';
  };

  var toBlockElements = function toBlockElements(text, rootTag, rootAttrs) {
    var blocks = text.split(/\n\n/);
    var tagOpen = openContainer(rootTag, rootAttrs);
    var tagClose = '</' + rootTag + '>';
    var paragraphs = global$6.map(blocks, function (p) {
      return p.split(/\n/).join('<br />');
    });

    var stitch = function stitch(p) {
      return tagOpen + p + tagClose;
    };

    return paragraphs.length === 1 ? paragraphs[0] : global$6.map(paragraphs, stitch).join('');
  };

  var convert = function convert(text, rootTag, rootAttrs) {
    return rootTag ? toBlockElements(text, rootTag === true ? 'p' : rootTag, rootAttrs) : toBRs(text);
  };

  var global$4 = tinymce.util.Tools.resolve('tinymce.html.DomParser');
  var global$3 = tinymce.util.Tools.resolve('tinymce.html.Serializer');
  var nbsp = '\xA0';
  var global$2 = tinymce.util.Tools.resolve('tinymce.html.Node');
  var global$1 = tinymce.util.Tools.resolve('tinymce.html.Schema');

  var isRegExp = function isRegExp(val) {
    return val.constructor === RegExp;
  };

  var filter = function filter(content, items) {
    global$6.each(items, function (v) {
      if (isRegExp(v)) {
        content = content.replace(v, '');
      } else {
        content = content.replace(v[0], v[1]);
      }
    });
    return content;
  };

  var innerText = function innerText(html) {
    var schema = global$1();
    var domParser = global$4({}, schema);
    var text = '';
    var shortEndedElements = schema.getShortEndedElements();
    var ignoreElements = global$6.makeMap('script noscript style textarea video audio iframe object', ' ');
    var blockElements = schema.getBlockElements();

    var walk = function walk(node) {
      var name = node.name,
          currentNode = node;

      if (name === 'br') {
        text += '\n';
        return;
      }

      if (name === 'wbr') {
        return;
      }

      if (shortEndedElements[name]) {
        text += ' ';
      }

      if (ignoreElements[name]) {
        text += ' ';
        return;
      }

      if (node.type === 3) {
        text += node.value;
      }

      if (!node.shortEnded) {
        if (node = node.firstChild) {
          do {
            walk(node);
          } while (node = node.next);
        }
      }

      if (blockElements[name] && currentNode.next) {
        text += '\n';

        if (name === 'p') {
          text += '\n';
        }
      }
    };

    html = filter(html, [/<!\[[^\]]+\]>/g]);
    walk(domParser.parse(html));
    return text;
  };

  var trimHtml = function trimHtml(html) {
    var trimSpaces = function trimSpaces(all, s1, s2) {
      if (!s1 && !s2) {
        return ' ';
      }

      return nbsp;
    };

    html = filter(html, [/^[\s\S]*<body[^>]*>\s*|\s*<\/body[^>]*>[\s\S]*$/ig, /<!--StartFragment-->|<!--EndFragment-->/g, [/( ?)<span class="Apple-converted-space">\u00a0<\/span>( ?)/g, trimSpaces], /<br class="Apple-interchange-newline">/g, /<br>$/i]);
    return html;
  };

  var createIdGenerator = function createIdGenerator(prefix) {
    var count = 0;
    return function () {
      return prefix + count++;
    };
  };

  var getImageMimeType = function getImageMimeType(ext) {
    var lowerExt = ext.toLowerCase();
    var mimeOverrides = {
      jpg: 'jpeg',
      jpe: 'jpeg',
      jfi: 'jpeg',
      jif: 'jpeg',
      jfif: 'jpeg',
      pjpeg: 'jpeg',
      pjp: 'jpeg',
      svg: 'svg+xml'
    };
    return global$6.hasOwn(mimeOverrides, lowerExt) ? 'image/' + mimeOverrides[lowerExt] : 'image/' + lowerExt;
  };

  var isWordContent = function isWordContent(content) {
    return /<font face="Times New Roman"|class="?Mso|style="[^"]*\bmso-|style='[^']*\bmso-|w:WordDocument/i.test(content) || /class="OutlineElement/.test(content) || /id="?docs\-internal\-guid\-/.test(content);
  };

  var isNumericList = function isNumericList(text) {
    var found = false;
    var patterns = [/^[IVXLMCD]+\.[ \u00a0]/, /^[ivxlmcd]+\.[ \u00a0]/, /^[a-z]{1,2}[\.\)][ \u00a0]/, /^[A-Z]{1,2}[\.\)][ \u00a0]/, /^[0-9]+\.[ \u00a0]/, /^[\u3007\u4e00\u4e8c\u4e09\u56db\u4e94\u516d\u4e03\u516b\u4e5d]+\.[ \u00a0]/, /^[\u58f1\u5f10\u53c2\u56db\u4f0d\u516d\u4e03\u516b\u4e5d\u62fe]+\.[ \u00a0]/];
    text = text.replace(/^[\u00a0 ]+/, '');
    global$6.each(patterns, function (pattern) {
      if (pattern.test(text)) {
        found = true;
        return false;
      }
    });
    return found;
  };

  var isBulletList = function isBulletList(text) {
    return /^[\s\u00a0]*[\u2022\u00b7\u00a7\u25CF]\s*/.test(text);
  };

  var convertFakeListsToProperLists = function convertFakeListsToProperLists(node) {
    var currentListNode,
        prevListNode,
        lastLevel = 1;

    var getText = function getText(node) {
      var txt = '';

      if (node.type === 3) {
        return node.value;
      }

      if (node = node.firstChild) {
        do {
          txt += getText(node);
        } while (node = node.next);
      }

      return txt;
    };

    var trimListStart = function trimListStart(node, regExp) {
      if (node.type === 3) {
        if (regExp.test(node.value)) {
          node.value = node.value.replace(regExp, '');
          return false;
        }
      }

      if (node = node.firstChild) {
        do {
          if (!trimListStart(node, regExp)) {
            return false;
          }
        } while (node = node.next);
      }

      return true;
    };

    var removeIgnoredNodes = function removeIgnoredNodes(node) {
      if (node._listIgnore) {
        node.remove();
        return;
      }

      if (node = node.firstChild) {
        do {
          removeIgnoredNodes(node);
        } while (node = node.next);
      }
    };

    var convertParagraphToLi = function convertParagraphToLi(paragraphNode, listName, start) {
      var level = paragraphNode._listLevel || lastLevel;

      if (level !== lastLevel) {
        if (level < lastLevel) {
          if (currentListNode) {
            currentListNode = currentListNode.parent.parent;
          }
        } else {
          prevListNode = currentListNode;
          currentListNode = null;
        }
      }

      if (!currentListNode || currentListNode.name !== listName) {
        prevListNode = prevListNode || currentListNode;
        currentListNode = new global$2(listName, 1);

        if (start > 1) {
          currentListNode.attr('start', '' + start);
        }

        paragraphNode.wrap(currentListNode);
      } else {
        currentListNode.append(paragraphNode);
      }

      paragraphNode.name = 'li';

      if (level > lastLevel && prevListNode) {
        prevListNode.lastChild.append(currentListNode);
      }

      lastLevel = level;
      removeIgnoredNodes(paragraphNode);
      trimListStart(paragraphNode, /^\u00a0+/);
      trimListStart(paragraphNode, /^\s*([\u2022\u00b7\u00a7\u25CF]|\w+\.)/);
      trimListStart(paragraphNode, /^\u00a0+/);
    };

    var elements = [];
    var child = node.firstChild;

    while (typeof child !== 'undefined' && child !== null) {
      elements.push(child);
      child = child.walk();

      if (child !== null) {
        while (typeof child !== 'undefined' && child.parent !== node) {
          child = child.walk();
        }
      }
    }

    for (var i = 0; i < elements.length; i++) {
      node = elements[i];

      if (node.name === 'p' && node.firstChild) {
        var nodeText = getText(node);

        if (isBulletList(nodeText)) {
          convertParagraphToLi(node, 'ul');
          continue;
        }

        if (isNumericList(nodeText)) {
          var matches = /([0-9]+)\./.exec(nodeText);
          var start = 1;

          if (matches) {
            start = parseInt(matches[1], 10);
          }

          convertParagraphToLi(node, 'ol', start);
          continue;
        }

        if (node._listLevel) {
          convertParagraphToLi(node, 'ul', 1);
          continue;
        }

        currentListNode = null;
      } else {
        prevListNode = currentListNode;
        currentListNode = null;
      }
    }
  };

  var filterStyles = function filterStyles(editor, validStyles, node, styleValue) {
    var outputStyles = {};
    var styles = editor.dom.parseStyle(styleValue);
    global$6.each(styles, function (value, name) {
      switch (name) {
        case 'mso-list':
          var matches = /\w+ \w+([0-9]+)/i.exec(styleValue);

          if (matches) {
            node._listLevel = parseInt(matches[1], 10);
          }

          if (/Ignore/i.test(value) && node.firstChild) {
            node._listIgnore = true;
            node.firstChild._listIgnore = true;
          }

          break;

        case 'horiz-align':
          name = 'text-align';
          break;

        case 'vert-align':
          name = 'vertical-align';
          break;

        case 'font-color':
        case 'mso-foreground':
          name = 'color';
          break;

        case 'mso-background':
        case 'mso-highlight':
          name = 'background';
          break;

        case 'font-weight':
        case 'font-style':
          if (value !== 'normal') {
            outputStyles[name] = value;
          }

          return;

        case 'mso-element':
          if (/^(comment|comment-list)$/i.test(value)) {
            node.remove();
            return;
          }

          break;
      }

      if (name.indexOf('mso-comment') === 0) {
        node.remove();
        return;
      }

      if (name.indexOf('mso-') === 0) {
        return;
      }

      if (getRetainStyleProps(editor) === 'all' || validStyles && validStyles[name]) {
        outputStyles[name] = value;
      }
    });

    if (/(bold)/i.test(outputStyles['font-weight'])) {
      delete outputStyles['font-weight'];
      node.wrap(new global$2('b', 1));
    }

    if (/(italic)/i.test(outputStyles['font-style'])) {
      delete outputStyles['font-style'];
      node.wrap(new global$2('i', 1));
    }

    var outputStyle = editor.dom.serializeStyle(outputStyles, node.name);

    if (outputStyle) {
      return outputStyle;
    }

    return null;
  };

  var filterWordContent = function filterWordContent(editor, content) {
    var validStyles;
    var retainStyleProperties = getRetainStyleProps(editor);

    if (retainStyleProperties) {
      validStyles = global$6.makeMap(retainStyleProperties.split(/[, ]/));
    }

    content = filter(content, [/<br class="?Apple-interchange-newline"?>/gi, /<b[^>]+id="?docs-internal-[^>]*>/gi, /<!--[\s\S]+?-->/gi, /<(!|script[^>]*>.*?<\/script(?=[>\s])|\/?(\?xml(:\w+)?|img|meta|link|style|\w:\w+)(?=[\s\/>]))[^>]*>/gi, [/<(\/?)s>/gi, '<$1strike>'], [/&nbsp;/gi, nbsp], [/<span\s+style\s*=\s*"\s*mso-spacerun\s*:\s*yes\s*;?\s*"\s*>([\s\u00a0]*)<\/span>/gi, function (str, spaces) {
      return spaces.length > 0 ? spaces.replace(/./, ' ').slice(Math.floor(spaces.length / 2)).split('').join(nbsp) : '';
    }]]);
    var validElements = getWordValidElements(editor);
    var schema = global$1({
      valid_elements: validElements,
      valid_children: '-li[p]'
    });
    global$6.each(schema.elements, function (rule) {
      if (!rule.attributes["class"]) {
        rule.attributes["class"] = {};
        rule.attributesOrder.push('class');
      }

      if (!rule.attributes.style) {
        rule.attributes.style = {};
        rule.attributesOrder.push('style');
      }
    });
    var domParser = global$4({}, schema);
    domParser.addAttributeFilter('style', function (nodes) {
      var i = nodes.length,
          node;

      while (i--) {
        node = nodes[i];
        node.attr('style', filterStyles(editor, validStyles, node, node.attr('style')));

        if (node.name === 'span' && node.parent && !node.attributes.length) {
          node.unwrap();
        }
      }
    });
    domParser.addAttributeFilter('class', function (nodes) {
      var i = nodes.length,
          node,
          className;

      while (i--) {
        node = nodes[i];
        className = node.attr('class');

        if (/^(MsoCommentReference|MsoCommentText|msoDel)$/i.test(className)) {
          node.remove();
        }

        node.attr('class', null);
      }
    });
    domParser.addNodeFilter('del', function (nodes) {
      var i = nodes.length;

      while (i--) {
        nodes[i].remove();
      }
    });
    domParser.addNodeFilter('a', function (nodes) {
      var i = nodes.length,
          node,
          href,
          name;

      while (i--) {
        node = nodes[i];
        href = node.attr('href');
        name = node.attr('name');

        if (href && href.indexOf('#_msocom_') !== -1) {
          node.remove();
          continue;
        }

        if (href && href.indexOf('file://') === 0) {
          href = href.split('#')[1];

          if (href) {
            href = '#' + href;
          }
        }

        if (!href && !name) {
          node.unwrap();
        } else {
          if (name && !/^_?(?:toc|edn|ftn)/i.test(name)) {
            node.unwrap();
            continue;
          }

          node.attr({
            href: href,
            name: name
          });
        }
      }
    });
    var rootNode = domParser.parse(content);

    if (shouldConvertWordFakeLists(editor)) {
      convertFakeListsToProperLists(rootNode);
    }

    content = global$3({
      validate: getValidate(editor)
    }, schema).serialize(rootNode);
    return content;
  };

  var preProcess$1 = function preProcess$1(editor, content) {
    return shouldUseDefaultFilters(editor) ? filterWordContent(editor, content) : content;
  };

  var preProcess = function preProcess(editor, html) {
    var parser = global$4({}, editor.schema);
    parser.addNodeFilter('meta', function (nodes) {
      global$6.each(nodes, function (node) {
        node.remove();
      });
    });
    var fragment = parser.parse(html, {
      forced_root_block: false,
      isRootContent: true
    });
    return global$3({
      validate: getValidate(editor)
    }, editor.schema).serialize(fragment);
  };

  var processResult = function processResult(content, cancelled) {
    return {
      content: content,
      cancelled: cancelled
    };
  };

  var postProcessFilter = function postProcessFilter(editor, html, internal, isWordHtml) {
    var tempBody = editor.dom.create('div', {
      style: 'display:none'
    }, html);
    var postProcessArgs = firePastePostProcess(editor, tempBody, internal, isWordHtml);
    return processResult(postProcessArgs.node.innerHTML, postProcessArgs.isDefaultPrevented());
  };

  var filterContent = function filterContent(editor, content, internal, isWordHtml) {
    var preProcessArgs = firePastePreProcess(editor, content, internal, isWordHtml);
    var filteredContent = preProcess(editor, preProcessArgs.content);

    if (editor.hasEventListeners('PastePostProcess') && !preProcessArgs.isDefaultPrevented()) {
      return postProcessFilter(editor, filteredContent, internal, isWordHtml);
    } else {
      return processResult(filteredContent, preProcessArgs.isDefaultPrevented());
    }
  };

  var process = function process(editor, html, internal) {
    var isWordHtml = isWordContent(html);
    var content = isWordHtml ? preProcess$1(editor, html) : html;
    return filterContent(editor, content, internal, isWordHtml);
  };

  var pasteHtml$1 = function pasteHtml$1(editor, html) {
    editor.insertContent(html, {
      merge: shouldMergeFormats(editor),
      paste: true
    });
    return true;
  };

  var isAbsoluteUrl = function isAbsoluteUrl(url) {
    return /^https?:\/\/[\w\?\-\/+=.&%@~#]+$/i.test(url);
  };

  var isImageUrl = function isImageUrl(editor, url) {
    return isAbsoluteUrl(url) && exists(getAllowedImageFileTypes(editor), function (type) {
      return endsWith(url.toLowerCase(), '.' + type.toLowerCase());
    });
  };

  var createImage = function createImage(editor, url, pasteHtmlFn) {
    editor.undoManager.extra(function () {
      pasteHtmlFn(editor, url);
    }, function () {
      editor.insertContent('<img src="' + url + '">');
    });
    return true;
  };

  var createLink = function createLink(editor, url, pasteHtmlFn) {
    editor.undoManager.extra(function () {
      pasteHtmlFn(editor, url);
    }, function () {
      editor.execCommand('mceInsertLink', false, url);
    });
    return true;
  };

  var linkSelection = function linkSelection(editor, html, pasteHtmlFn) {
    return editor.selection.isCollapsed() === false && isAbsoluteUrl(html) ? createLink(editor, html, pasteHtmlFn) : false;
  };

  var insertImage = function insertImage(editor, html, pasteHtmlFn) {
    return isImageUrl(editor, html) ? createImage(editor, html, pasteHtmlFn) : false;
  };

  var smartInsertContent = function smartInsertContent(editor, html) {
    global$6.each([linkSelection, insertImage, pasteHtml$1], function (action) {
      return action(editor, html, pasteHtml$1) !== true;
    });
  };

  var insertContent = function insertContent(editor, html, pasteAsText) {
    if (pasteAsText || isSmartPasteEnabled(editor) === false) {
      pasteHtml$1(editor, html);
    } else {
      smartInsertContent(editor, html);
    }
  };

  var isCollapsibleWhitespace = function isCollapsibleWhitespace(c) {
    return ' \f\t\x0B'.indexOf(c) !== -1;
  };

  var isNewLineChar = function isNewLineChar(c) {
    return c === '\n' || c === '\r';
  };

  var isNewline = function isNewline(text, idx) {
    return idx < text.length && idx >= 0 ? isNewLineChar(text[idx]) : false;
  };

  var normalizeWhitespace = function normalizeWhitespace(editor, text) {
    var tabSpace = repeat(' ', getTabSpaces(editor));
    var normalizedText = text.replace(/\t/g, tabSpace);
    var result = foldl(normalizedText, function (acc, c) {
      if (isCollapsibleWhitespace(c) || c === nbsp) {
        if (acc.pcIsSpace || acc.str === '' || acc.str.length === normalizedText.length - 1 || isNewline(normalizedText, acc.str.length + 1)) {
          return {
            pcIsSpace: false,
            str: acc.str + nbsp
          };
        } else {
          return {
            pcIsSpace: true,
            str: acc.str + ' '
          };
        }
      } else {
        return {
          pcIsSpace: isNewLineChar(c),
          str: acc.str + c
        };
      }
    }, {
      pcIsSpace: false,
      str: ''
    });
    return result.str;
  };

  var doPaste = function doPaste(editor, content, internal, pasteAsText) {
    var args = process(editor, content, internal);

    if (args.cancelled === false) {
      insertContent(editor, args.content, pasteAsText);
    }
  };

  var _pasteHtml = function pasteHtml(editor, html, internalFlag) {
    var internal = internalFlag ? internalFlag : isMarked(html);
    doPaste(editor, unmark(html), internal, false);
  };

  var _pasteText = function pasteText(editor, text) {
    var encodedText = editor.dom.encode(text).replace(/\r\n/g, '\n');
    var normalizedText = normalizeWhitespace(editor, encodedText);
    var html = convert(normalizedText, getForcedRootBlock(editor), getForcedRootBlockAttrs(editor));
    doPaste(editor, html, false, true);
  };

  var getDataTransferItems = function getDataTransferItems(dataTransfer) {
    var items = {};
    var mceInternalUrlPrefix = 'data:text/mce-internal,';

    if (dataTransfer) {
      if (dataTransfer.getData) {
        var legacyText = dataTransfer.getData('Text');

        if (legacyText && legacyText.length > 0) {
          if (legacyText.indexOf(mceInternalUrlPrefix) === -1) {
            items['text/plain'] = legacyText;
          }
        }
      }

      if (dataTransfer.types) {
        for (var i = 0; i < dataTransfer.types.length; i++) {
          var contentType = dataTransfer.types[i];

          try {
            items[contentType] = dataTransfer.getData(contentType);
          } catch (ex) {
            items[contentType] = '';
          }
        }
      }
    }

    return items;
  };

  var getClipboardContent = function getClipboardContent(editor, clipboardEvent) {
    return getDataTransferItems(clipboardEvent.clipboardData || editor.getDoc().dataTransfer);
  };

  var hasContentType = function hasContentType(clipboardContent, mimeType) {
    return mimeType in clipboardContent && clipboardContent[mimeType].length > 0;
  };

  var hasHtmlOrText = function hasHtmlOrText(content) {
    return hasContentType(content, 'text/html') || hasContentType(content, 'text/plain');
  };

  var parseDataUri = function parseDataUri(uri) {
    var matches = /data:([^;]+);base64,([a-z0-9\+\/=]+)/i.exec(uri);

    if (matches) {
      return {
        type: matches[1],
        data: decodeURIComponent(matches[2])
      };
    } else {
      return {
        type: null,
        data: null
      };
    }
  };

  var isValidDataUriImage = function isValidDataUriImage(editor, imgElm) {
    var filter = getImagesDataImgFilter(editor);
    return filter ? filter(imgElm) : true;
  };

  var extractFilename = function extractFilename(editor, str) {
    var m = str.match(/([\s\S]+?)(?:\.[a-z0-9.]+)$/i);
    return isNonNullable(m) ? editor.dom.encode(m[1]) : null;
  };

  var uniqueId = createIdGenerator('mceclip');

  var pasteImage = function pasteImage(editor, imageItem) {
    var _a = parseDataUri(imageItem.uri),
        base64 = _a.data,
        type = _a.type;

    var id = uniqueId();
    var file = imageItem.blob;
    var img = new Image();
    img.src = imageItem.uri;

    if (isValidDataUriImage(editor, img)) {
      var blobCache = editor.editorUpload.blobCache;
      var blobInfo = void 0;
      var existingBlobInfo = blobCache.getByData(base64, type);

      if (!existingBlobInfo) {
        var useFileName = getImagesReuseFilename(editor) && isNonNullable(file.name);
        var name_1 = useFileName ? extractFilename(editor, file.name) : id;
        var filename = useFileName ? file.name : undefined;
        blobInfo = blobCache.create(id, file, base64, name_1, filename);
        blobCache.add(blobInfo);
      } else {
        blobInfo = existingBlobInfo;
      }

      _pasteHtml(editor, '<img src="' + blobInfo.blobUri() + '">', false);
    } else {
      _pasteHtml(editor, '<img src="' + imageItem.uri + '">', false);
    }
  };

  var isClipboardEvent = function isClipboardEvent(event) {
    return event.type === 'paste';
  };

  var isDataTransferItem = function isDataTransferItem(item) {
    return isNonNullable(item.getAsFile);
  };

  var readFilesAsDataUris = function readFilesAsDataUris(items) {
    return global$8.all(map(items, function (item) {
      return new global$8(function (resolve) {
        var blob = isDataTransferItem(item) ? item.getAsFile() : item;
        var reader = new window.FileReader();

        reader.onload = function () {
          resolve({
            blob: blob,
            uri: reader.result
          });
        };

        reader.readAsDataURL(blob);
      });
    }));
  };

  var isImage = function isImage(editor) {
    var allowedExtensions = getAllowedImageFileTypes(editor);
    return function (file) {
      return startsWith(file.type, 'image/') && exists(allowedExtensions, function (extension) {
        return getImageMimeType(extension) === file.type;
      });
    };
  };

  var getImagesFromDataTransfer = function getImagesFromDataTransfer(editor, dataTransfer) {
    var items = dataTransfer.items ? bind(from(dataTransfer.items), function (item) {
      return item.kind === 'file' ? [item.getAsFile()] : [];
    }) : [];
    var files = dataTransfer.files ? from(dataTransfer.files) : [];
    return filter$1(items.length > 0 ? items : files, isImage(editor));
  };

  var _pasteImageData = function pasteImageData(editor, e, rng) {
    var dataTransfer = isClipboardEvent(e) ? e.clipboardData : e.dataTransfer;

    if (getPasteDataImages(editor) && dataTransfer) {
      var images = getImagesFromDataTransfer(editor, dataTransfer);

      if (images.length > 0) {
        e.preventDefault();
        readFilesAsDataUris(images).then(function (fileResults) {
          if (rng) {
            editor.selection.setRng(rng);
          }

          each(fileResults, function (result) {
            pasteImage(editor, result);
          });
        });
        return true;
      }
    }

    return false;
  };

  var isBrokenAndroidClipboardEvent = function isBrokenAndroidClipboardEvent(e) {
    var clipboardData = e.clipboardData;
    return navigator.userAgent.indexOf('Android') !== -1 && clipboardData && clipboardData.items && clipboardData.items.length === 0;
  };

  var isKeyboardPasteEvent = function isKeyboardPasteEvent(e) {
    return global$7.metaKeyPressed(e) && e.keyCode === 86 || e.shiftKey && e.keyCode === 45;
  };

  var registerEventHandlers = function registerEventHandlers(editor, pasteBin, pasteFormat) {
    var keyboardPasteEvent = value();
    var keyboardPastePressed = value();
    var keyboardPastePlainTextState;
    editor.on('keyup', keyboardPastePressed.clear);
    editor.on('keydown', function (e) {
      var removePasteBinOnKeyUp = function removePasteBinOnKeyUp(e) {
        if (isKeyboardPasteEvent(e) && !e.isDefaultPrevented()) {
          pasteBin.remove();
        }
      };

      if (isKeyboardPasteEvent(e) && !e.isDefaultPrevented()) {
        keyboardPastePlainTextState = e.shiftKey && e.keyCode === 86;

        if (keyboardPastePlainTextState && global$a.webkit && navigator.userAgent.indexOf('Version/') !== -1) {
          return;
        }

        e.stopImmediatePropagation();
        keyboardPasteEvent.set(e);
        keyboardPastePressed.set(true);

        if (global$a.ie && keyboardPastePlainTextState) {
          e.preventDefault();
          firePaste(editor, true);
          return;
        }

        pasteBin.remove();
        pasteBin.create();
        editor.once('keyup', removePasteBinOnKeyUp);
        editor.once('paste', function () {
          editor.off('keyup', removePasteBinOnKeyUp);
        });
      }
    });

    var insertClipboardContent = function insertClipboardContent(editor, clipboardContent, isKeyBoardPaste, plainTextMode, internal) {
      var content;

      if (hasContentType(clipboardContent, 'text/html')) {
        content = clipboardContent['text/html'];
      } else {
        content = pasteBin.getHtml();
        internal = internal ? internal : isMarked(content);

        if (pasteBin.isDefaultContent(content)) {
          plainTextMode = true;
        }
      }

      content = trimHtml(content);
      pasteBin.remove();
      var isPlainTextHtml = internal === false && isPlainText(content);
      var isAbsoluteUrl$1 = isAbsoluteUrl(content);

      if (!content.length || isPlainTextHtml && !isAbsoluteUrl$1) {
        plainTextMode = true;
      }

      if (plainTextMode || isAbsoluteUrl$1) {
        if (hasContentType(clipboardContent, 'text/plain') && isPlainTextHtml) {
          content = clipboardContent['text/plain'];
        } else {
          content = innerText(content);
        }
      }

      if (pasteBin.isDefaultContent(content)) {
        if (!isKeyBoardPaste) {
          editor.windowManager.alert('Please use Ctrl+V/Cmd+V keyboard shortcuts to paste contents.');
        }

        return;
      }

      if (plainTextMode) {
        _pasteText(editor, content);
      } else {
        _pasteHtml(editor, content, internal);
      }
    };

    var getLastRng = function getLastRng() {
      return pasteBin.getLastRng() || editor.selection.getRng();
    };

    editor.on('paste', function (e) {
      var isKeyboardPaste = keyboardPasteEvent.isSet() || keyboardPastePressed.isSet();

      if (isKeyboardPaste) {
        keyboardPasteEvent.clear();
      }

      var clipboardContent = getClipboardContent(editor, e);
      var plainTextMode = pasteFormat.get() === 'text' || keyboardPastePlainTextState;
      var internal = hasContentType(clipboardContent, internalHtmlMime());
      keyboardPastePlainTextState = false;

      if (e.isDefaultPrevented() || isBrokenAndroidClipboardEvent(e)) {
        pasteBin.remove();
        return;
      }

      if (!hasHtmlOrText(clipboardContent) && _pasteImageData(editor, e, getLastRng())) {
        pasteBin.remove();
        return;
      }

      if (!isKeyboardPaste) {
        e.preventDefault();
      }

      if (global$a.ie && (!isKeyboardPaste || e.ieFake) && !hasContentType(clipboardContent, 'text/html')) {
        pasteBin.create();
        editor.dom.bind(pasteBin.getEl(), 'paste', function (e) {
          e.stopPropagation();
        });
        editor.getDoc().execCommand('Paste', false, null);
        clipboardContent['text/html'] = pasteBin.getHtml();
      }

      if (hasContentType(clipboardContent, 'text/html')) {
        e.preventDefault();

        if (!internal) {
          internal = isMarked(clipboardContent['text/html']);
        }

        insertClipboardContent(editor, clipboardContent, isKeyboardPaste, plainTextMode, internal);
      } else {
        global$9.setEditorTimeout(editor, function () {
          insertClipboardContent(editor, clipboardContent, isKeyboardPaste, plainTextMode, internal);
        }, 0);
      }
    });
  };

  var registerEventsAndFilters = function registerEventsAndFilters(editor, pasteBin, pasteFormat) {
    registerEventHandlers(editor, pasteBin, pasteFormat);
    var src;
    editor.parser.addNodeFilter('img', function (nodes, name, args) {
      var isPasteInsert = function isPasteInsert(args) {
        return args.data && args.data.paste === true;
      };

      var remove = function remove(node) {
        if (!node.attr('data-mce-object') && src !== global$a.transparentSrc) {
          node.remove();
        }
      };

      var isWebKitFakeUrl = function isWebKitFakeUrl(src) {
        return src.indexOf('webkit-fake-url') === 0;
      };

      var isDataUri = function isDataUri(src) {
        return src.indexOf('data:') === 0;
      };

      if (!getPasteDataImages(editor) && isPasteInsert(args)) {
        var i = nodes.length;

        while (i--) {
          src = nodes[i].attr('src');

          if (!src) {
            continue;
          }

          if (isWebKitFakeUrl(src)) {
            remove(nodes[i]);
          } else if (!getAllowHtmlDataUrls(editor) && isDataUri(src)) {
            remove(nodes[i]);
          }
        }
      }
    });
  };

  var getPasteBinParent = function getPasteBinParent(editor) {
    return global$a.ie && editor.inline ? document.body : editor.getBody();
  };

  var isExternalPasteBin = function isExternalPasteBin(editor) {
    return getPasteBinParent(editor) !== editor.getBody();
  };

  var delegatePasteEvents = function delegatePasteEvents(editor, pasteBinElm, pasteBinDefaultContent) {
    if (isExternalPasteBin(editor)) {
      editor.dom.bind(pasteBinElm, 'paste keyup', function (_e) {
        if (!_isDefault(editor, pasteBinDefaultContent)) {
          editor.fire('paste');
        }
      });
    }
  };

  var _create = function create(editor, lastRngCell, pasteBinDefaultContent) {
    var dom = editor.dom,
        body = editor.getBody();
    lastRngCell.set(editor.selection.getRng());
    var pasteBinElm = editor.dom.add(getPasteBinParent(editor), 'div', {
      'id': 'mcepastebin',
      'class': 'mce-pastebin',
      'contentEditable': true,
      'data-mce-bogus': 'all',
      'style': 'position: fixed; top: 50%; width: 10px; height: 10px; overflow: hidden; opacity: 0'
    }, pasteBinDefaultContent);

    if (global$a.ie || global$a.gecko) {
      dom.setStyle(pasteBinElm, 'left', dom.getStyle(body, 'direction', true) === 'rtl' ? 65535 : -65535);
    }

    dom.bind(pasteBinElm, 'beforedeactivate focusin focusout', function (e) {
      e.stopPropagation();
    });
    delegatePasteEvents(editor, pasteBinElm, pasteBinDefaultContent);
    pasteBinElm.focus();
    editor.selection.select(pasteBinElm, true);
  };

  var _remove = function remove(editor, lastRngCell) {
    if (_getEl(editor)) {
      var pasteBinClone = void 0;
      var lastRng = lastRngCell.get();

      while (pasteBinClone = editor.dom.get('mcepastebin')) {
        editor.dom.remove(pasteBinClone);
        editor.dom.unbind(pasteBinClone);
      }

      if (lastRng) {
        editor.selection.setRng(lastRng);
      }
    }

    lastRngCell.set(null);
  };

  var _getEl = function getEl(editor) {
    return editor.dom.get('mcepastebin');
  };

  var _getHtml = function getHtml(editor) {
    var copyAndRemove = function copyAndRemove(toElm, fromElm) {
      toElm.appendChild(fromElm);
      editor.dom.remove(fromElm, true);
    };

    var pasteBinClones = global$6.grep(getPasteBinParent(editor).childNodes, function (elm) {
      return elm.id === 'mcepastebin';
    });
    var pasteBinElm = pasteBinClones.shift();
    global$6.each(pasteBinClones, function (pasteBinClone) {
      copyAndRemove(pasteBinElm, pasteBinClone);
    });
    var dirtyWrappers = editor.dom.select('div[id=mcepastebin]', pasteBinElm);

    for (var i = dirtyWrappers.length - 1; i >= 0; i--) {
      var cleanWrapper = editor.dom.create('div');
      pasteBinElm.insertBefore(cleanWrapper, dirtyWrappers[i]);
      copyAndRemove(cleanWrapper, dirtyWrappers[i]);
    }

    return pasteBinElm ? pasteBinElm.innerHTML : '';
  };

  var _isDefaultContent = function isDefaultContent(pasteBinDefaultContent, content) {
    return content === pasteBinDefaultContent;
  };

  var isPasteBin = function isPasteBin(elm) {
    return elm && elm.id === 'mcepastebin';
  };

  var _isDefault = function isDefault(editor, pasteBinDefaultContent) {
    var pasteBinElm = _getEl(editor);

    return isPasteBin(pasteBinElm) && _isDefaultContent(pasteBinDefaultContent, pasteBinElm.innerHTML);
  };

  var PasteBin = function PasteBin(editor) {
    var lastRng = Cell(null);
    var pasteBinDefaultContent = '%MCEPASTEBIN%';
    return {
      create: function create() {
        return _create(editor, lastRng, pasteBinDefaultContent);
      },
      remove: function remove() {
        return _remove(editor, lastRng);
      },
      getEl: function getEl() {
        return _getEl(editor);
      },
      getHtml: function getHtml() {
        return _getHtml(editor);
      },
      getLastRng: lastRng.get,
      isDefault: function isDefault() {
        return _isDefault(editor, pasteBinDefaultContent);
      },
      isDefaultContent: function isDefaultContent(content) {
        return _isDefaultContent(pasteBinDefaultContent, content);
      }
    };
  };

  var Clipboard = function Clipboard(editor, pasteFormat) {
    var pasteBin = PasteBin(editor);
    editor.on('PreInit', function () {
      return registerEventsAndFilters(editor, pasteBin, pasteFormat);
    });
    return {
      pasteFormat: pasteFormat,
      pasteHtml: function pasteHtml(html, internalFlag) {
        return _pasteHtml(editor, html, internalFlag);
      },
      pasteText: function pasteText(text) {
        return _pasteText(editor, text);
      },
      pasteImageData: function pasteImageData(e, rng) {
        return _pasteImageData(editor, e, rng);
      },
      getDataTransferItems: getDataTransferItems,
      hasHtmlOrText: hasHtmlOrText,
      hasContentType: hasContentType
    };
  };

  var togglePlainTextPaste = function togglePlainTextPaste(editor, clipboard) {
    if (clipboard.pasteFormat.get() === 'text') {
      clipboard.pasteFormat.set('html');
      firePastePlainTextToggle(editor, false);
    } else {
      clipboard.pasteFormat.set('text');
      firePastePlainTextToggle(editor, true);
    }

    editor.focus();
  };

  var register$2 = function register$2(editor, clipboard) {
    editor.addCommand('mceTogglePlainTextPaste', function () {
      togglePlainTextPaste(editor, clipboard);
    });
    editor.addCommand('mceInsertClipboardContent', function (ui, value) {
      if (value.content) {
        clipboard.pasteHtml(value.content, value.internal);
      }

      if (value.text) {
        clipboard.pasteText(value.text);
      }
    });
  };

  var hasWorkingClipboardApi = function hasWorkingClipboardApi(clipboardData) {
    return global$a.iOS === false && typeof (clipboardData === null || clipboardData === void 0 ? void 0 : clipboardData.setData) === 'function';
  };

  var setHtml5Clipboard = function setHtml5Clipboard(clipboardData, html, text) {
    if (hasWorkingClipboardApi(clipboardData)) {
      try {
        clipboardData.clearData();
        clipboardData.setData('text/html', html);
        clipboardData.setData('text/plain', text);
        clipboardData.setData(internalHtmlMime(), html);
        return true;
      } catch (e) {
        return false;
      }
    } else {
      return false;
    }
  };

  var setClipboardData = function setClipboardData(evt, data, fallback, done) {
    if (setHtml5Clipboard(evt.clipboardData, data.html, data.text)) {
      evt.preventDefault();
      done();
    } else {
      fallback(data.html, done);
    }
  };

  var fallback = function fallback(editor) {
    return function (html, done) {
      var markedHtml = mark(html);
      var outer = editor.dom.create('div', {
        'contenteditable': 'false',
        'data-mce-bogus': 'all'
      });
      var inner = editor.dom.create('div', {
        contenteditable: 'true'
      }, markedHtml);
      editor.dom.setStyles(outer, {
        position: 'fixed',
        top: '0',
        left: '-3000px',
        width: '1000px',
        overflow: 'hidden'
      });
      outer.appendChild(inner);
      editor.dom.add(editor.getBody(), outer);
      var range = editor.selection.getRng();
      inner.focus();
      var offscreenRange = editor.dom.createRng();
      offscreenRange.selectNodeContents(inner);
      editor.selection.setRng(offscreenRange);
      global$9.setTimeout(function () {
        editor.selection.setRng(range);
        outer.parentNode.removeChild(outer);
        done();
      }, 0);
    };
  };

  var getData = function getData(editor) {
    return {
      html: editor.selection.getContent({
        contextual: true
      }),
      text: editor.selection.getContent({
        format: 'text'
      })
    };
  };

  var isTableSelection = function isTableSelection(editor) {
    return !!editor.dom.getParent(editor.selection.getStart(), 'td[data-mce-selected],th[data-mce-selected]', editor.getBody());
  };

  var hasSelectedContent = function hasSelectedContent(editor) {
    return !editor.selection.isCollapsed() || isTableSelection(editor);
  };

  var cut = function cut(editor) {
    return function (evt) {
      if (hasSelectedContent(editor)) {
        setClipboardData(evt, getData(editor), fallback(editor), function () {
          if (global$a.browser.isChrome() || global$a.browser.isFirefox()) {
            var rng_1 = editor.selection.getRng();
            global$9.setEditorTimeout(editor, function () {
              editor.selection.setRng(rng_1);
              editor.execCommand('Delete');
            }, 0);
          } else {
            editor.execCommand('Delete');
          }
        });
      }
    };
  };

  var copy = function copy(editor) {
    return function (evt) {
      if (hasSelectedContent(editor)) {
        setClipboardData(evt, getData(editor), fallback(editor), noop);
      }
    };
  };

  var register$1 = function register$1(editor) {
    editor.on('cut', cut(editor));
    editor.on('copy', copy(editor));
  };

  var global = tinymce.util.Tools.resolve('tinymce.dom.RangeUtils');

  var getCaretRangeFromEvent = function getCaretRangeFromEvent(editor, e) {
    return global.getCaretRangeFromPoint(e.clientX, e.clientY, editor.getDoc());
  };

  var isPlainTextFileUrl = function isPlainTextFileUrl(content) {
    var plainTextContent = content['text/plain'];
    return plainTextContent ? plainTextContent.indexOf('file://') === 0 : false;
  };

  var setFocusedRange = function setFocusedRange(editor, rng) {
    editor.focus();
    editor.selection.setRng(rng);
  };

  var setup$2 = function setup$2(editor, clipboard, draggingInternallyState) {
    if (shouldBlockDrop(editor)) {
      editor.on('dragend dragover draggesture dragdrop drop drag', function (e) {
        e.preventDefault();
        e.stopPropagation();
      });
    }

    if (!shouldPasteDataImages(editor)) {
      editor.on('drop', function (e) {
        var dataTransfer = e.dataTransfer;

        if (dataTransfer && dataTransfer.files && dataTransfer.files.length > 0) {
          e.preventDefault();
        }
      });
    }

    editor.on('drop', function (e) {
      var rng = getCaretRangeFromEvent(editor, e);

      if (e.isDefaultPrevented() || draggingInternallyState.get()) {
        return;
      }

      var dropContent = clipboard.getDataTransferItems(e.dataTransfer);
      var internal = clipboard.hasContentType(dropContent, internalHtmlMime());

      if ((!clipboard.hasHtmlOrText(dropContent) || isPlainTextFileUrl(dropContent)) && clipboard.pasteImageData(e, rng)) {
        return;
      }

      if (rng && shouldFilterDrop(editor)) {
        var content_1 = dropContent['mce-internal'] || dropContent['text/html'] || dropContent['text/plain'];

        if (content_1) {
          e.preventDefault();
          global$9.setEditorTimeout(editor, function () {
            editor.undoManager.transact(function () {
              if (dropContent['mce-internal']) {
                editor.execCommand('Delete');
              }

              setFocusedRange(editor, rng);
              content_1 = trimHtml(content_1);

              if (!dropContent['text/html']) {
                clipboard.pasteText(content_1);
              } else {
                clipboard.pasteHtml(content_1, internal);
              }
            });
          });
        }
      }
    });
    editor.on('dragstart', function (_e) {
      draggingInternallyState.set(true);
    });
    editor.on('dragover dragend', function (e) {
      if (shouldPasteDataImages(editor) && draggingInternallyState.get() === false) {
        e.preventDefault();
        setFocusedRange(editor, getCaretRangeFromEvent(editor, e));
      }

      if (e.type === 'dragend') {
        draggingInternallyState.set(false);
      }
    });
  };

  var setup$1 = function setup$1(editor) {
    var plugin = editor.plugins.paste;
    var preProcess = getPreProcess(editor);

    if (preProcess) {
      editor.on('PastePreProcess', function (e) {
        preProcess.call(plugin, plugin, e);
      });
    }

    var postProcess = getPostProcess(editor);

    if (postProcess) {
      editor.on('PastePostProcess', function (e) {
        postProcess.call(plugin, plugin, e);
      });
    }
  };

  var addPreProcessFilter = function addPreProcessFilter(editor, filterFunc) {
    editor.on('PastePreProcess', function (e) {
      e.content = filterFunc(editor, e.content, e.internal, e.wordContent);
    });
  };

  var addPostProcessFilter = function addPostProcessFilter(editor, filterFunc) {
    editor.on('PastePostProcess', function (e) {
      filterFunc(editor, e.node);
    });
  };

  var removeExplorerBrElementsAfterBlocks = function removeExplorerBrElementsAfterBlocks(editor, html) {
    if (!isWordContent(html)) {
      return html;
    }

    var blockElements = [];
    global$6.each(editor.schema.getBlockElements(), function (block, blockName) {
      blockElements.push(blockName);
    });
    var explorerBlocksRegExp = new RegExp('(?:<br>&nbsp;[\\s\\r\\n]+|<br>)*(<\\/?(' + blockElements.join('|') + ')[^>]*>)(?:<br>&nbsp;[\\s\\r\\n]+|<br>)*', 'g');
    html = filter(html, [[explorerBlocksRegExp, '$1']]);
    html = filter(html, [[/<br><br>/g, '<BR><BR>'], [/<br>/g, ' '], [/<BR><BR>/g, '<br>']]);
    return html;
  };

  var removeWebKitStyles = function removeWebKitStyles(editor, content, internal, isWordHtml) {
    if (isWordHtml || internal) {
      return content;
    }

    var webKitStylesSetting = getWebkitStyles(editor);
    var webKitStyles;

    if (shouldRemoveWebKitStyles(editor) === false || webKitStylesSetting === 'all') {
      return content;
    }

    if (webKitStylesSetting) {
      webKitStyles = webKitStylesSetting.split(/[, ]/);
    }

    if (webKitStyles) {
      var dom_1 = editor.dom,
          node_1 = editor.selection.getNode();
      content = content.replace(/(<[^>]+) style="([^"]*)"([^>]*>)/gi, function (all, before, value, after) {
        var inputStyles = dom_1.parseStyle(dom_1.decode(value));
        var outputStyles = {};

        if (webKitStyles === 'none') {
          return before + after;
        }

        for (var i = 0; i < webKitStyles.length; i++) {
          var inputValue = inputStyles[webKitStyles[i]],
              currentValue = dom_1.getStyle(node_1, webKitStyles[i], true);

          if (/color/.test(webKitStyles[i])) {
            inputValue = dom_1.toHex(inputValue);
            currentValue = dom_1.toHex(currentValue);
          }

          if (currentValue !== inputValue) {
            outputStyles[webKitStyles[i]] = inputValue;
          }
        }

        var outputStyle = dom_1.serializeStyle(outputStyles, 'span');

        if (outputStyle) {
          return before + ' style="' + outputStyle + '"' + after;
        }

        return before + after;
      });
    } else {
      content = content.replace(/(<[^>]+) style="([^"]*)"([^>]*>)/gi, '$1$3');
    }

    content = content.replace(/(<[^>]+) data-mce-style="([^"]+)"([^>]*>)/gi, function (all, before, value, after) {
      return before + ' style="' + value + '"' + after;
    });
    return content;
  };

  var removeUnderlineAndFontInAnchor = function removeUnderlineAndFontInAnchor(editor, root) {
    editor.$('a', root).find('font,u').each(function (i, node) {
      editor.dom.remove(node, true);
    });
  };

  var setup = function setup(editor) {
    if (global$a.webkit) {
      addPreProcessFilter(editor, removeWebKitStyles);
    }

    if (global$a.ie) {
      addPreProcessFilter(editor, removeExplorerBrElementsAfterBlocks);
      addPostProcessFilter(editor, removeUnderlineAndFontInAnchor);
    }
  };

  var makeSetupHandler = function makeSetupHandler(editor, clipboard) {
    return function (api) {
      api.setActive(clipboard.pasteFormat.get() === 'text');

      var pastePlainTextToggleHandler = function pastePlainTextToggleHandler(e) {
        return api.setActive(e.state);
      };

      editor.on('PastePlainTextToggle', pastePlainTextToggleHandler);
      return function () {
        return editor.off('PastePlainTextToggle', pastePlainTextToggleHandler);
      };
    };
  };

  var register = function register(editor, clipboard) {
    var onAction = function onAction() {
      return editor.execCommand('mceTogglePlainTextPaste');
    };

    editor.ui.registry.addToggleButton('pastetext', {
      active: false,
      icon: 'paste-text',
      tooltip: 'Paste as text',
      onAction: onAction,
      onSetup: makeSetupHandler(editor, clipboard)
    });
    editor.ui.registry.addToggleMenuItem('pastetext', {
      text: 'Paste as text',
      icon: 'paste-text',
      onAction: onAction,
      onSetup: makeSetupHandler(editor, clipboard)
    });
  };

  function Plugin() {
    global$b.add('paste', function (editor) {
      if (hasProPlugin(editor) === false) {
        var draggingInternallyState = Cell(false);
        var pasteFormat = Cell(isPasteAsTextEnabled(editor) ? 'text' : 'html');
        var clipboard = Clipboard(editor, pasteFormat);
        setup(editor);
        register(editor, clipboard);
        register$2(editor, clipboard);
        setup$1(editor);
        register$1(editor);
        setup$2(editor, clipboard, draggingInternallyState);
        return get(clipboard);
      }
    });
  }

  Plugin();
})();
/******/ })()
;