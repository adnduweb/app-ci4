(()=>{var n={72179:()=>{!function(){"use strict";var n=tinymce.util.Tools.resolve("tinymce.PluginManager"),e=function(n,e){for(var t="",r=0;r<e;r++)t+=n;return t},t=function(n,t){var r=function(n){return n.getParam("nonbreaking_wrap",!0,"boolean")}(n),o=r||n.plugins.visualchars?'<span class="'+(function(n){return!!n.plugins.visualchars&&n.plugins.visualchars.isEnabled()}(n)?"mce-nbsp-wrap mce-nbsp":"mce-nbsp-wrap")+'" contenteditable="false">'+e("&nbsp;",t)+"</span>":e("&nbsp;",t);n.undoManager.transact((function(){return n.insertContent(o)}))},r=tinymce.util.Tools.resolve("tinymce.util.VK");n.add("nonbreaking",(function(n){!function(n){n.addCommand("mceNonBreaking",(function(){t(n,1)}))}(n),function(n){var e=function(){return n.execCommand("mceNonBreaking")};n.ui.registry.addButton("nonbreaking",{icon:"non-breaking",tooltip:"Nonbreaking space",onAction:e}),n.ui.registry.addMenuItem("nonbreaking",{icon:"non-breaking",text:"Nonbreaking space",onAction:e})}(n),function(n){var e=function(n){var e=n.getParam("nonbreaking_force_tab",0);return"boolean"==typeof e?!0===e?3:0:e}(n);e>0&&n.on("keydown",(function(o){if(o.keyCode===r.TAB&&!o.isDefaultPrevented()){if(o.shiftKey)return;o.preventDefault(),o.stopImmediatePropagation(),t(n,e)}}))}(n)}))}()}},e={};function t(r){var o=e[r];if(void 0!==o)return o.exports;var a=e[r]={exports:{}};return n[r](a,a.exports,t),a.exports}t(72179)})();