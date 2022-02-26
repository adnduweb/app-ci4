(()=>{var e={88741:()=>{function e(t){return e="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},e(t)}!function(){"use strict";var t,r,n=tinymce.util.Tools.resolve("tinymce.PluginManager"),o=function(){return o=Object.assign||function(e){for(var t,r=1,n=arguments.length;r<n;r++)for(var o in t=arguments[r])Object.prototype.hasOwnProperty.call(t,o)&&(e[o]=t[o]);return e},o.apply(this,arguments)},i=function(t){return function(r){return o=e(n=r),(null===n?"null":"object"===o&&(Array.prototype.isPrototypeOf(n)||n.constructor&&"Array"===n.constructor.name)?"array":"object"===o&&(String.prototype.isPrototypeOf(n)||n.constructor&&"String"===n.constructor.name)?"string":o)===t;var n,o}},a=i("string"),c=i("object"),u=i("array"),s=function(e){return!function(e){return null==e}(e)},l=function(){},m=function(e){return function(){return e}},d=function(e){return e},f=m(!1),p=m(!0),h=function(){return g},g={fold:function(e,t){return e()},isSome:f,isNone:p,getOr:r=d,getOrThunk:t=function(e){return e()},getOrDie:function(e){throw new Error(e||"error: getOrDie called on none.")},getOrNull:m(null),getOrUndefined:m(void 0),or:r,orThunk:t,map:h,each:l,bind:h,exists:f,forall:p,filter:function(){return h()},toArray:function(){return[]},toString:m("none()")},v=function e(t){var r=m(t),n=function(){return i},o=function(e){return e(t)},i={fold:function(e,r){return r(t)},isSome:p,isNone:f,getOr:r,getOrThunk:r,getOrDie:r,getOrNull:r,getOrUndefined:r,or:n,orThunk:n,map:function(r){return e(r(t))},each:function(e){e(t)},bind:o,exists:o,forall:o,filter:function(e){return e(t)?i:g},toArray:function(){return[t]},toString:function(){return"some("+t+")"}};return i},b=v,y=h,w=function(e){return null==e?g:v(e)},x=Array.prototype.push,S=function(e,t){for(var r=0,n=e.length;r<n;r++){t(e[r],r)}},j=function(e){for(var t=[],r=0,n=e.length;r<n;++r){if(!u(e[r]))throw new Error("Arr.flatten item "+r+" was not an array, input: "+e);x.apply(t,e[r])}return t},O=function(e){var t=e;return{get:function(){return t},set:function(e){t=e}}},_=Object.keys,k=Object.hasOwnProperty,A=function(e,t){return T(e,t)?w(e[t]):y()},T=function(e,t){return k.call(e,t)},C=function(e){return e.getParam("media_scripts")},D=function(e){return e.getParam("media_live_embeds",!0)},P=tinymce.util.Tools.resolve("tinymce.util.Tools"),$=tinymce.util.Tools.resolve("tinymce.dom.DOMUtils"),M=tinymce.util.Tools.resolve("tinymce.html.SaxParser"),F=function(e,t){if(e)for(var r=0;r<e.length;r++)if(-1!==t.indexOf(e[r].filter))return e[r]},z=$.DOM,N=function(e){return e.replace(/px$/,"")},U=function(e,t){var r=O(!1),n={};return M({validate:!1,allow_conditional_comments:!0,start:function(t,o){if(r.get());else if(T(o.map,"data-ephox-embed-iri"))r.set(!0),n=function(e){var t=e.map.style,r=t?z.parseStyle(t):{};return{type:"ephox-embed-iri",source:e.map["data-ephox-embed-iri"],altsource:"",poster:"",width:A(r,"max-width").map(N).getOr(""),height:A(r,"max-height").map(N).getOr("")}}(o);else{if(n.source||"param"!==t||(n.source=o.map.movie),"iframe"!==t&&"object"!==t&&"embed"!==t&&"video"!==t&&"audio"!==t||(n.type||(n.type=t),n=P.extend(o.map,n)),"script"===t){var i=F(e,o.map.src);if(!i)return;n={type:"script",source:o.map.src,width:String(i.width),height:String(i.height)}}"source"===t&&(n.source?n.altsource||(n.altsource=o.map.src):n.source=o.map.src),"img"!==t||n.poster||(n.poster=o.map.src)}}}).parse(t),n.source=n.source||n.src||n.data,n.altsource=n.altsource||"",n.poster=n.poster||"",n},E=function(e){var t={mp3:"audio/mpeg",m4a:"audio/x-m4a",wav:"audio/wav",mp4:"video/mp4",webm:"video/webm",ogg:"video/ogg",swf:"application/x-shockwave-flash"}[e.toLowerCase().split(".").pop()];return t||""},R=tinymce.util.Tools.resolve("tinymce.html.Schema"),L=tinymce.util.Tools.resolve("tinymce.html.Writer"),I=$.DOM,B=function(e){return/^[0-9.]+$/.test(e)?e+"px":e},W=function(e,t){!function(e,t){for(var r=_(e),n=0,o=r.length;n<o;n++){var i=r[n];t(e[i],i)}}(t,(function(t,r){var n=""+t;if(e.map[r])for(var o=e.length;o--;){var i=e[o];i.name===r&&(n?(e.map[r]=n,i.value=n):(delete e.map[r],e.splice(o,1)))}else n&&(e.push({name:r,value:n}),e.map[r]=n)}))},G=["source","altsource"],q=function(e,t,r){var n,o=L(),i=O(!1),a=0;return M({validate:!1,allow_conditional_comments:!0,comment:function(e){o.comment(e)},cdata:function(e){o.cdata(e)},text:function(e,t){o.text(e,t)},start:function(e,c,u){if(i.get());else if(T(c.map,"data-ephox-embed-iri"))i.set(!0),function(e,t){var r=t.map.style,n=r?I.parseStyle(r):{};n["max-width"]=B(e.width),n["max-height"]=B(e.height),W(t,{style:I.serializeStyle(n)})}(t,c);else{switch(e){case"video":case"object":case"embed":case"img":case"iframe":void 0!==t.height&&void 0!==t.width&&W(c,{width:t.width,height:t.height})}if(r)switch(e){case"video":W(c,{poster:t.poster,src:""}),t.altsource&&W(c,{src:""});break;case"iframe":W(c,{src:t.source});break;case"source":if(a<2&&(W(c,{src:t[G[a]],type:t[G[a]+"mime"]}),!t[G[a]]))return;a++;break;case"img":if(!t.poster)return;n=!0}}o.start(e,c,u)},end:function(e){if(!i.get()){if("video"===e&&r)for(var c=0;c<2;c++)if(t[G[c]]){var u=[];u.map={},a<=c&&(W(u,{src:t[G[c]],type:t[G[c]+"mime"]}),o.start("source",u,!0))}if(t.poster&&"object"===e&&r&&!n){var s=[];s.map={},W(s,{src:t.poster,width:t.width,height:t.height}),o.start("img",s,!0)}}o.end(e)}},R({})).parse(e),o.getContent()},H=[{regex:/youtu\.be\/([\w\-_\?&=.]+)/i,type:"iframe",w:560,h:314,url:"www.youtube.com/embed/$1",allowFullscreen:!0},{regex:/youtube\.com(.+)v=([^&]+)(&([a-z0-9&=\-_]+))?/i,type:"iframe",w:560,h:314,url:"www.youtube.com/embed/$2?$4",allowFullscreen:!0},{regex:/youtube.com\/embed\/([a-z0-9\?&=\-_]+)/i,type:"iframe",w:560,h:314,url:"www.youtube.com/embed/$1",allowFullscreen:!0},{regex:/vimeo\.com\/([0-9]+)/,type:"iframe",w:425,h:350,url:"player.vimeo.com/video/$1?title=0&byline=0&portrait=0&color=8dc7dc",allowFullscreen:!0},{regex:/vimeo\.com\/(.*)\/([0-9]+)/,type:"iframe",w:425,h:350,url:"player.vimeo.com/video/$2?title=0&amp;byline=0",allowFullscreen:!0},{regex:/maps\.google\.([a-z]{2,3})\/maps\/(.+)msid=(.+)/,type:"iframe",w:425,h:350,url:'maps.google.com/maps/ms?msid=$2&output=embed"',allowFullscreen:!1},{regex:/dailymotion\.com\/video\/([^_]+)/,type:"iframe",w:480,h:270,url:"www.dailymotion.com/embed/video/$1",allowFullscreen:!0},{regex:/dai\.ly\/([^_]+)/,type:"iframe",w:480,h:270,url:"www.dailymotion.com/embed/video/$1",allowFullscreen:!0}],J=function(e,t){for(var r=function(e){var t=e.match(/^(https?:\/\/|www\.)(.+)$/i);return t&&t.length>1?"www."===t[1]?"https://":t[1]:"https://"}(t),n=e.regex.exec(t),o=r+e.url,i=function(e){o=o.replace("$"+e,(function(){return n[e]?n[e]:""}))},a=0;a<n.length;a++)i(a);return o.replace(/\?$/,"")},K=function(e,t){var r=P.extend({},t);if(!r.source&&(P.extend(r,U(C(e),r.embed)),!r.source))return"";r.altsource||(r.altsource=""),r.poster||(r.poster=""),r.source=e.convertURL(r.source,"source"),r.altsource=e.convertURL(r.altsource,"source"),r.sourcemime=E(r.source),r.altsourcemime=E(r.altsource),r.poster=e.convertURL(r.poster,"poster");var n,o,i=(n=r.source,o=H.filter((function(e){return e.regex.test(n)})),o.length>0?P.extend({},o[0],{url:J(o[0],n)}):null);if(i&&(r.source=i.url,r.type=i.type,r.allowfullscreen=i.allowFullscreen,r.width=r.width||String(i.w),r.height=r.height||String(i.h)),r.embed)return q(r.embed,r,!0);var a=F(C(e),r.source);a&&(r.type="script",r.width=String(a.width),r.height=String(a.height));var c=function(e){return e.getParam("audio_template_callback")}(e),u=function(e){return e.getParam("video_template_callback")}(e);return r.width=r.width||"300",r.height=r.height||"150",P.each(r,(function(t,n){r[n]=e.dom.encode(""+t)})),"iframe"===r.type?function(e){var t=e.allowfullscreen?' allowFullscreen="1"':"";return'<iframe src="'+e.source+'" width="'+e.width+'" height="'+e.height+'"'+t+"></iframe>"}(r):"application/x-shockwave-flash"===r.sourcemime?function(e){var t='<object data="'+e.source+'" width="'+e.width+'" height="'+e.height+'" type="application/x-shockwave-flash">';return e.poster&&(t+='<img src="'+e.poster+'" width="'+e.width+'" height="'+e.height+'" />'),t+"</object>"}(r):-1!==r.sourcemime.indexOf("audio")?function(e,t){return t?t(e):'<audio controls="controls" src="'+e.source+'">'+(e.altsource?'\n<source src="'+e.altsource+'"'+(e.altsourcemime?' type="'+e.altsourcemime+'"':"")+" />\n":"")+"</audio>"}(r,c):"script"===r.type?function(e){return'<script src="'+e.source+'"><\/script>'}(r):function(e,t){return t?t(e):'<video width="'+e.width+'" height="'+e.height+'"'+(e.poster?' poster="'+e.poster+'"':"")+' controls="controls">\n<source src="'+e.source+'"'+(e.sourcemime?' type="'+e.sourcemime+'"':"")+" />\n"+(e.altsource?'<source src="'+e.altsource+'"'+(e.altsourcemime?' type="'+e.altsourcemime+'"':"")+" />\n":"")+"</video>"}(r,u)},Q=function(e){return e.hasAttribute("data-mce-object")||e.hasAttribute("data-ephox-embed-iri")},V=tinymce.util.Tools.resolve("tinymce.util.Promise"),X={},Y=function(e){return function(t){return K(e,t)}},Z=function(e,t){var r=function(e){return e.getParam("media_url_resolver")}(e);return r?function(e,t,r){return new V((function(n,o){var i=function(r){return r.html&&(X[e.source]=r),n({url:e.source,html:r.html?r.html:t(e)})};X[e.source]?i(X[e.source]):r({url:e.source},i,o)}))}(t,Y(e),r):function(e,t){return V.resolve({html:t(e),url:e.source})}(t,Y(e))},ee=function(e,t){var r=t?function(e,t){return A(t,e).bind((function(e){return A(e,"meta")}))}(t,e).getOr({}):{},n=function(e,t,r){return function(n){var o,i=function(){return A(e,n)},a=function(){return A(t,n)},u=function(e){return A(e,"value").bind((function(e){return e.length>0?b(e):y()}))};return(o={})[n]=(n===r?i().bind((function(e){return c(e)?u(e).orThunk(a):a().orThunk((function(){return w(e)}))})):a().orThunk((function(){return i().bind((function(e){return c(e)?u(e):w(e)}))}))).getOr(""),o}}(e,r,t);return o(o(o(o(o({},n("source")),n("altsource")),n("poster")),n("embed")),function(e,t){var r={};return A(e,"dimensions").each((function(e){S(["width","height"],(function(n){A(t,n).orThunk((function(){return A(e,n)})).each((function(e){return r[n]=e}))}))})),r}(e,r))},te=function(e){var t=o(o({},e),{source:{value:A(e,"source").getOr("")},altsource:{value:A(e,"altsource").getOr("")},poster:{value:A(e,"poster").getOr("")}});return S(["width","height"],(function(r){A(e,r).each((function(e){var n=t.dimensions||{};n[r]=e,t.dimensions=n}))})),t},re=function(e){return function(t){var r=t&&t.msg?"Media embed handler error: "+t.msg:"Media embed handler threw unknown error.";e.notificationManager.open({type:"error",text:r})}},ne=function(e,t){return U(C(e),t)},oe=function(e,t){return function(r){if(a(r.url)&&r.url.trim().length>0){var n=r.html,i=ne(t,n),c=o(o({},i),{source:r.url,embed:n});e.setData(te(c))}}},ie=function(e,t){var r=e.dom.select("*[data-mce-object]");e.insertContent(t),function(e,t){for(var r=e.dom.select("*[data-mce-object]"),n=0;n<t.length;n++)for(var o=r.length-1;o>=0;o--)t[n]===r[o]&&r.splice(o,1);e.selection.select(r[0])}(e,r),e.nodeChanged()},ae=function(e,t,r){var n;t.embed=q(t.embed,t),t.embed&&(e.source===t.source||(n=t.source,T(X,n)))?ie(r,t.embed):Z(r,t).then((function(e){ie(r,e.html)})).catch(re(r))},ce=function(e){var t=function(e){var t=e.selection.getNode(),r=Q(t)?e.serializer.serialize(t,{selection:!0}):"";return o({embed:r},U(C(e),r))}(e),r=O(t),n=te(t),i=function(e){return e.getParam("media_dimensions",!0)}(e)?[{type:"sizeinput",name:"dimensions",label:"Constrain proportions",constrain:!0}]:[],a={title:"General",name:"general",items:j([[{name:"source",type:"urlinput",filetype:"media",label:"Source"}],i])},c={title:"Embed",items:[{type:"textarea",name:"embed",label:"Paste your embed code below:"}]},u=[];(function(e){return e.getParam("media_alt_source",!0)})(e)&&u.push({name:"altsource",type:"urlinput",filetype:"media",label:"Alternative source URL"}),function(e){return e.getParam("media_poster",!0)}(e)&&u.push({name:"poster",type:"urlinput",filetype:"image",label:"Media poster (Image URL)"});var s={title:"Advanced",name:"advanced",items:u},l=[a,c];u.length>0&&l.push(s);var m={type:"tabpanel",tabs:l},d=e.windowManager.open({title:"Insert/Edit Media",size:"normal",body:m,buttons:[{type:"cancel",name:"cancel",text:"Cancel"},{type:"submit",name:"save",text:"Save",primary:!0}],onSubmit:function(t){var n=ee(t.getData());ae(r.get(),n,e),t.close()},onChange:function(t,n){switch(n.name){case"source":!function(t,r){var n=ee(r.getData(),"source");t.source!==n.source&&(oe(d,e)({url:n.source,html:""}),Z(e,n).then(oe(d,e)).catch(re(e)))}(r.get(),t);break;case"embed":!function(t){var r=ee(t.getData()),n=ne(e,r.embed);t.setData(te(n))}(t);break;case"dimensions":case"altsource":case"poster":!function(t,r){var n=ee(t.getData(),r),i=K(e,n);t.setData(te(o(o({},n),{embed:i})))}(t,n.name)}r.set(ee(t.getData()))},initialData:n})},ue=tinymce.util.Tools.resolve("tinymce.html.Node"),se=tinymce.util.Tools.resolve("tinymce.Env"),le=tinymce.util.Tools.resolve("tinymce.html.DomParser"),me=function(e,t){if(!1===function(e){return e.getParam("media_filter_html",!0)}(e))return t;var r,n=L();return M({validate:!1,allow_conditional_comments:!1,comment:function(e){r||n.comment(e)},cdata:function(e){r||n.cdata(e)},text:function(e,t){r||n.text(e,t)},start:function(t,o,i){if(r=!0,"script"!==t&&"noscript"!==t&&"svg"!==t){for(var a=o.length-1;a>=0;a--){var c=o[a].name;0===c.indexOf("on")&&(delete o.map[c],o.splice(a,1)),"style"===c&&(o[a].value=e.dom.serializeStyle(e.dom.parseStyle(o[a].value),t))}n.start(t,o,i),r=!1}},end:function(e){r||n.end(e)}},R({})).parse(t),n.getContent()},de=function(e){var t=e.name;return"iframe"===t||"video"===t||"audio"===t},fe=function(e,t,r,n){void 0===n&&(n=null);var o=e.attr(r);return s(o)?o:T(t,r)?null:n},pe=function(e,t,r){var n="img"===t.name||"video"===e.name,o=n?"300":null,i="audio"===e.name?"30":"150",a=n?i:null;t.attr({width:fe(e,r,"width",o),height:fe(e,r,"height",a)})},he=function(e,t){var r=t.name,n=new ue("img",1);return n.shortEnded=!0,ve(e,t,n),pe(t,n,{}),n.attr({style:t.attr("style"),src:se.transparentSrc,"data-mce-object":r,class:"mce-object mce-object-"+r}),n},ge=function(e,t){var r=t.name,n=new ue("span",1);n.attr({contentEditable:"false",style:t.attr("style"),"data-mce-object":r,class:"mce-preview-object mce-object-"+r}),ve(e,t,n);var o=e.dom.parseStyle(t.attr("style")),i=new ue(r,1);if(pe(t,i,o),i.attr({src:t.attr("src"),style:t.attr("style"),class:t.attr("class")}),"iframe"===r)i.attr({allowfullscreen:t.attr("allowfullscreen"),frameborder:"0"});else{S(["controls","crossorigin","currentTime","loop","muted","poster","preload"],(function(e){i.attr(e,t.attr(e))}));var a=n.attr("data-mce-html");s(a)&&function(e,t,r,n){for(var o=le({forced_root_block:!1,validate:!1},e.schema).parse(n,{context:t});o.firstChild;)r.append(o.firstChild)}(e,r,i,unescape(a))}var c=new ue("span",1);return c.attr("class","mce-shim"),n.append(i),n.append(c),n},ve=function(e,t,r){for(var n=t.attributes,o=n.length;o--;){var i=n[o].name,a=n[o].value;"width"!==i&&"height"!==i&&"style"!==i&&("data"!==i&&"src"!==i||(a=e.convertURL(a,i)),r.attr("data-mce-p-"+i,a))}var c=t.firstChild&&t.firstChild.value;c&&(r.attr("data-mce-html",escape(me(e,c))),r.firstChild=null)},be=function(e){var t=e.attr("class");return t&&/\btiny-pageembed\b/.test(t)},ye=function(e){for(;e=e.parent;)if(e.attr("data-ephox-embed-iri")||be(e))return!0;return!1},we=function(e){e.on("preInit",(function(){var t=e.schema.getSpecialElements();P.each("video audio iframe object".split(" "),(function(e){t[e]=new RegExp("</"+e+"[^>]*>","gi")}));var r=e.schema.getBoolAttrs();P.each("webkitallowfullscreen mozallowfullscreen allowfullscreen".split(" "),(function(e){r[e]={}})),e.parser.addNodeFilter("iframe,video,audio,object,embed,script",function(e){return function(t){for(var r,n,o=t.length;o--;)(r=t[o]).parent&&(r.parent.attr("data-mce-object")||("script"!==r.name||(n=F(C(e),r.attr("src"))))&&(n&&(n.width&&r.attr("width",n.width.toString()),n.height&&r.attr("height",n.height.toString())),de(r)&&D(e)&&se.ceFalse?ye(r)||r.replace(ge(e,r)):ye(r)||r.replace(he(e,r))))}}(e)),e.serializer.addAttributeFilter("data-mce-object",(function(t,r){for(var n,o,i,a,c,u,s,l,m=t.length;m--;)if((n=t[m]).parent){for(s=n.attr(r),o=new ue(s,1),"audio"!==s&&"script"!==s&&((l=n.attr("class"))&&-1!==l.indexOf("mce-preview-object")?o.attr({width:n.firstChild.attr("width"),height:n.firstChild.attr("height")}):o.attr({width:n.attr("width"),height:n.attr("height")})),o.attr({style:n.attr("style")}),i=(a=n.attributes).length;i--;){var d=a[i].name;0===d.indexOf("data-mce-p-")&&o.attr(d.substr(11),a[i].value)}"script"===s&&o.attr("type","text/javascript"),(c=n.attr("data-mce-html"))&&((u=new ue("#text",3)).raw=!0,u.value=me(e,unescape(c)),o.append(u)),n.replace(o)}}))})),e.on("SetContent",(function(){e.$("span.mce-preview-object").each((function(t,r){var n=e.$(r);0===n.find("span.mce-shim").length&&n.append('<span class="mce-shim"></span>')}))}))};n.add("media",(function(e){return function(e){e.addCommand("mceMedia",(function(){ce(e)}))}(e),function(e){var t=function(){return e.execCommand("mceMedia")};e.ui.registry.addToggleButton("media",{tooltip:"Insert/edit media",icon:"embed",onAction:t,onSetup:function(t){var r=e.selection;return t.setActive(Q(r.getNode())),r.selectorChangedWithUnbind("img[data-mce-object],span[data-mce-object],div[data-ephox-embed-iri]",t.setActive).unbind}}),e.ui.registry.addMenuItem("media",{icon:"embed",text:"Media...",onAction:t})}(e),function(e){e.on("ResolveName",(function(e){var t;1===e.target.nodeType&&(t=e.target.getAttribute("data-mce-object"))&&(e.name=t)}))}(e),we(e),function(e){e.on("click keyup touchend",(function(){var t=e.selection.getNode();t&&e.dom.hasClass(t,"mce-preview-object")&&e.dom.getAttrib(t,"data-mce-selected")&&t.setAttribute("data-mce-selected","2")})),e.on("ObjectSelected",(function(e){"script"===e.target.getAttribute("data-mce-object")&&e.preventDefault()})),e.on("ObjectResized",(function(e){var t=e.target;if(t.getAttribute("data-mce-object")){var r=t.getAttribute("data-mce-html");r&&(r=unescape(r),t.setAttribute("data-mce-html",escape(q(r,{width:String(e.width),height:String(e.height)}))))}}))}(e),function(e){return{showDialog:function(){ce(e)}}}(e)}))}()}},t={};function r(n){var o=t[n];if(void 0!==o)return o.exports;var i=t[n]={exports:{}};return e[n](i,i.exports,r),i.exports}r(88741)})();