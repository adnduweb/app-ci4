!function(){"use strict";var t=function(t){var e=t;return{get:function(){return e},set:function(t){e=t}}},e=tinymce.util.Tools.resolve("tinymce.PluginManager"),n=function(){return n=Object.assign||function(t){for(var e,n=1,i=arguments.length;n<i;n++)for(var l in e=arguments[n])Object.prototype.hasOwnProperty.call(e,l)&&(t[l]=e[l]);return t},n.apply(this,arguments)},i=tinymce.util.Tools.resolve("tinymce.util.Tools"),l=tinymce.util.Tools.resolve("tinymce.html.DomParser"),r=tinymce.util.Tools.resolve("tinymce.html.Node"),o=tinymce.util.Tools.resolve("tinymce.html.Serializer"),a=function(t){return t.getParam("fullpage_hide_in_source_view")},c=function(t){return t.getParam("fullpage_default_encoding")},s=function(t){return t.getParam("fullpage_default_font_family")},d=function(t){return t.getParam("fullpage_default_font_size")},u=function(t,e){return l({validate:!1,root_name:"#document"},t.schema).parse(e,{format:"xhtml"})},f=function(t,e){var l=function(t,e){var n,l,r=u(t,e),o={},a=function(t,e){return t.attr(e)||""};return o.fontface=s(t),o.fontsize=d(t),7===(n=r.firstChild).type&&(o.xml_pi=!0,(l=/encoding="([^"]+)"/.exec(n.value))&&(o.docencoding=l[1])),(n=r.getAll("#doctype")[0])&&(o.doctype="<!DOCTYPE"+n.value+">"),(n=r.getAll("title")[0])&&n.firstChild&&(o.title=n.firstChild.value),i.each(r.getAll("meta"),(function(t){var e,n=t.attr("name"),i=t.attr("http-equiv");n?o[n.toLowerCase()]=t.attr("content"):"Content-Type"===i&&(e=/charset\s*=\s*(.*)\s*/gi.exec(t.attr("content")))&&(o.docencoding=e[1])})),(n=r.getAll("html")[0])&&(o.langcode=a(n,"lang")||a(n,"xml:lang")),o.stylesheets=[],i.each(r.getAll("link"),(function(t){"stylesheet"===t.attr("rel")&&o.stylesheets.push(t.attr("href"))})),(n=r.getAll("body")[0])&&(o.langdir=a(n,"dir"),o.style=a(n,"style"),o.visited_color=a(n,"vlink"),o.link_color=a(n,"link"),o.active_color=a(n,"alink")),o}(t,e.get()),a=n(n({},{title:"",keywords:"",description:"",robots:"",author:"",docencoding:""}),l);t.windowManager.open({title:"Metadata and Document Properties",size:"normal",body:{type:"panel",items:[{name:"title",type:"input",label:"Title"},{name:"keywords",type:"input",label:"Keywords"},{name:"description",type:"input",label:"Description"},{name:"robots",type:"input",label:"Robots"},{name:"author",type:"input",label:"Author"},{name:"docencoding",type:"input",label:"Encoding"}]},buttons:[{type:"cancel",name:"cancel",text:"Cancel"},{type:"submit",name:"save",text:"Save",primary:!0}],initialData:a,onSubmit:function(n){var a=n.getData(),c=function(t,e,n){var l,a,c=t.dom,s=function(t,e,n){t.attr(e,n||void 0)},d=function(t){l.firstChild?l.insert(t,l.firstChild):l.append(t)},f=u(t,n);if((l=f.getAll("head")[0])||(a=f.getAll("html")[0],l=new r("head",1),a.firstChild?a.insert(l,a.firstChild,!0):a.append(l)),a=f.firstChild,e.xml_pi){var m='version="1.0"';e.docencoding&&(m+=' encoding="'+e.docencoding+'"'),7!==a.type&&(a=new r("xml",7),f.insert(a,f.firstChild,!0)),a.value=m}else a&&7===a.type&&a.remove();a=f.getAll("#doctype")[0],e.doctype?(a||(a=new r("#doctype",10),e.xml_pi?f.insert(a,f.firstChild):d(a)),a.value=e.doctype.substring(9,e.doctype.length-1)):a&&a.remove(),a=null,i.each(f.getAll("meta"),(function(t){"Content-Type"===t.attr("http-equiv")&&(a=t)})),e.docencoding?(a||((a=new r("meta",1)).attr("http-equiv","Content-Type"),a.shortEnded=!0,d(a)),a.attr("content","text/html; charset="+e.docencoding)):a&&a.remove(),a=f.getAll("title")[0],e.title?(a?a.empty():(a=new r("title",1),d(a)),a.append(new r("#text",3)).value=e.title):a&&a.remove(),i.each("keywords,description,author,copyright,robots".split(","),(function(t){var n,i,l=f.getAll("meta"),o=e[t];for(n=0;n<l.length;n++)if((i=l[n]).attr("name")===t)return void(o?i.attr("content",o):i.remove());o&&((a=new r("meta",1)).attr("name",t),a.attr("content",o),a.shortEnded=!0,d(a))}));var g={};i.each(f.getAll("link"),(function(t){"stylesheet"===t.attr("rel")&&(g[t.attr("href")]=t)})),i.each(e.stylesheets,(function(t){g[t]||((a=new r("link",1)).attr({rel:"stylesheet",text:"text/css",href:t}),a.shortEnded=!0,d(a)),delete g[t]})),i.each(g,(function(t){t.remove()})),(a=f.getAll("body")[0])&&(s(a,"dir",e.langdir),s(a,"style",e.style),s(a,"vlink",e.visited_color),s(a,"link",e.link_color),s(a,"alink",e.active_color),c.setAttribs(t.getBody(),{style:e.style,dir:e.dir,vLink:e.visited_color,link:e.link_color,aLink:e.active_color})),(a=f.getAll("html")[0])&&(s(a,"lang",e.langcode),s(a,"xml:lang",e.langcode)),l.firstChild||l.remove();var p=o({validate:!1,indent:!0,indent_before:"head,html,body,meta,title,script,link,style",indent_after:"head,html,body,meta,title,script,link,style"}).serialize(f);return p.substring(0,p.indexOf("</body>"))}(t,i.extend(l,a),e.get());e.set(c),n.close()}})},m=i.each,g=function(t){return t.replace(/<\/?[A-Z]+/g,(function(t){return t.toLowerCase()}))},p=function(t,e,n,l){var r,o,c,s,d,f="",p=t.dom;if(!(l.selection||(s=function(t){return t.getParam("protect")}(t),d=l.content,i.each(s,(function(t){d=d.replace(t,(function(t){return"\x3c!--mce:protected "+escape(t)+"--\x3e"}))})),c=d,"raw"===l.format&&e.get()||l.source_view&&a(t)))){0!==c.length||l.source_view||(c=i.trim(e.get())+"\n"+i.trim(c)+"\n"+i.trim(n.get())),-1!==(r=(c=c.replace(/<(\/?)BODY/gi,"<$1body")).indexOf("<body"))?(r=c.indexOf(">",r),e.set(g(c.substring(0,r+1))),-1===(o=c.indexOf("</body",r))&&(o=c.length),l.content=i.trim(c.substring(r+1,o)),n.set(g(c.substring(o)))):(e.set(h(t)),n.set("\n</body>\n</html>"));var y=u(t,e.get());m(y.getAll("style"),(function(t){t.firstChild&&(f+=t.firstChild.value)}));var v=y.getAll("body")[0];v&&p.setAttribs(t.getBody(),{style:v.attr("style")||"",dir:v.attr("dir")||"",vLink:v.attr("vlink")||"",link:v.attr("link")||"",aLink:v.attr("alink")||""}),p.remove("fullpage_styles");var _=t.getDoc().getElementsByTagName("head")[0];f&&p.add(_,"style",{id:"fullpage_styles"}).appendChild(document.createTextNode(f));var b={};i.each(_.getElementsByTagName("link"),(function(t){"stylesheet"===t.rel&&t.getAttribute("data-mce-fullpage")&&(b[t.href]=t)})),i.each(y.getAll("link"),(function(t){var e=t.attr("href");if(!e)return!0;b[e]||"stylesheet"!==t.attr("rel")||p.add(_,"link",{rel:"stylesheet",text:"text/css",href:e,"data-mce-fullpage":"1"}),delete b[e]})),i.each(b,(function(t){t.parentNode.removeChild(t)}))}},h=function(t){var e,n="",i="";if(function(t){return t.getParam("fullpage_default_xml_pi")}(t)){var l=c(t);n+='<?xml version="1.0" encoding="'+(l||"ISO-8859-1")+'" ?>\n'}return n+=function(t){return t.getParam("fullpage_default_doctype","<!DOCTYPE html>")}(t),n+="\n<html>\n<head>\n",(e=function(t){return t.getParam("fullpage_default_title")}(t))&&(n+="<title>"+e+"</title>\n"),(e=c(t))&&(n+='<meta http-equiv="Content-Type" content="text/html; charset='+e+'" />\n'),(e=s(t))&&(i+="font-family: "+e+";"),(e=d(t))&&(i+="font-size: "+e+";"),(e=function(t){return t.getParam("fullpage_default_text_color")}(t))&&(i+="color: "+e+";"),n+="</head>\n<body"+(i?' style="'+i+'"':"")+">\n"},y=function(t,e,n,l){"html"!==l.format||l.selection||l.source_view&&a(t)||(l.content=(i.trim(e)+"\n"+i.trim(l.content)+"\n"+i.trim(n)).replace(/<!--mce:protected ([\s\S]*?)-->/g,(function(t,e){return unescape(e)})))};e.add("fullpage",(function(e){var n=t(""),i=t("");!function(t,e){t.addCommand("mceFullPageProperties",(function(){f(t,e)}))}(e,n),function(t){t.ui.registry.addButton("fullpage",{tooltip:"Metadata and document properties",icon:"document-properties",onAction:function(){t.execCommand("mceFullPageProperties")}}),t.ui.registry.addMenuItem("fullpage",{text:"Metadata and document properties",icon:"document-properties",onAction:function(){t.execCommand("mceFullPageProperties")}})}(e),function(t,e,n){t.on("BeforeSetContent",(function(i){p(t,e,n,i)})),t.on("GetContent",(function(i){y(t,e.get(),n.get(),i)}))}(e,n,i)}))}();