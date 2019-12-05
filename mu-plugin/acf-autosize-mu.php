<?php
/*
Plugin Name: ACF Autosize
Plugin URI: https://wordpress.org/plugins/acf-autosize/
Description: A wordpress plugin to automatically resize and improve upon wysiwyg and textarea fields in Advanced Custom Fields.
Version: 2.0.0
Author: Moritz Jacobs @ Yeah
Author URI: https://www.yeah.de
*/

/**
 * This is a single-file drop-in version of acf-autosize for usage in your theme or mu-plugins. It contains the javascript and is AUTOGENERATED by running `npm run mu`!
 */

namespace YeahACFAutosize;

class ACFAutosizeMu {

	public function __construct() {
		// echo javascript
		add_action("acf/input/admin_footer", array($this, "echoJs"));
		add_action("acf/input/admin_head", array($this, "echoCss"));
	}

	public function echoJs() {
		echo "<script type=\"text/javascript\">";
		echo "ACFAutosize = {";
		echo "'wysiwyg':{'minHeight': ".apply_filters('acf-autosize/wysiwyg/min-height', 200)."},";
		echo "'enabledByDefault':".apply_filters('acf-autosize/enabledByDefault', true);
		echo "};";
		echo "</script>";
		echo "<script type=\"text/javascript\">";
		echo "\"use strict\";(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c=\"function\"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error(\"Cannot find module '\"+i+\"'\");throw a.code=\"MODULE_NOT_FOUND\",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u=\"function\"==typeof require&&require,i=0;i<t.length;i++){o(t[i])}return o}return r})()({1:[function(require,module,exports){(function(global,factory){if(typeof define===\"function\"&&define.amd){define([\"module\",\"exports\"],factory)}else if(typeof exports!==\"undefined\"){factory(module,exports)}else{var mod={exports:{}};factory(mod,mod.exports);global.autosize=mod.exports}})(this,function(module,exports){'use strict';var map=typeof Map===\"function\"?new Map:function(){var keys=[];var values=[];return{has:function has(key){return keys.indexOf(key)>-1},get:function get(key){return values[keys.indexOf(key)]},set:function set(key,value){if(keys.indexOf(key)===-1){keys.push(key);values.push(value)}},\"delete\":function _delete(key){var index=keys.indexOf(key);if(index>-1){keys.splice(index,1);values.splice(index,1)}}}}();var createEvent=function createEvent(name){return new Event(name,{bubbles:true})};try{new Event(\"test\")}catch(e){createEvent=function createEvent(name){var evt=document.createEvent(\"Event\");evt.initEvent(name,true,false);return evt}}function assign(ta){if(!ta||!ta.nodeName||ta.nodeName!==\"TEXTAREA\"||map.has(ta))return;var heightOffset=null;var clientWidth=null;var cachedHeight=null;function init(){var style=window.getComputedStyle(ta,null);if(style.resize===\"vertical\"){ta.style.resize=\"none\"}else if(style.resize===\"both\"){ta.style.resize=\"horizontal\"}if(style.boxSizing===\"content-box\"){heightOffset=-(parseFloat(style.paddingTop)+parseFloat(style.paddingBottom))}else{heightOffset=parseFloat(style.borderTopWidth)+parseFloat(style.borderBottomWidth)}if(isNaN(heightOffset)){heightOffset=0}update()}function changeOverflow(value){{var width=ta.style.width;ta.style.width=\"0px\";ta.offsetWidth;ta.style.width=width}ta.style.overflowY=value}function getParentOverflows(el){var arr=[];while(el&&el.parentNode&&el.parentNode instanceof Element){if(el.parentNode.scrollTop){arr.push({node:el.parentNode,scrollTop:el.parentNode.scrollTop})}el=el.parentNode}return arr}function resize(){if(ta.scrollHeight===0){return}var overflows=getParentOverflows(ta);var docTop=document.documentElement&&document.documentElement.scrollTop;ta.style.height=\"\";ta.style.height=ta.scrollHeight+heightOffset+\"px\";clientWidth=ta.clientWidth;overflows.forEach(function(el){el.node.scrollTop=el.scrollTop});if(docTop){document.documentElement.scrollTop=docTop}}function update(){resize();var styleHeight=Math.round(parseFloat(ta.style.height));var computed=window.getComputedStyle(ta,null);var actualHeight=computed.boxSizing===\"content-box\"?Math.round(parseFloat(computed.height)):ta.offsetHeight;if(actualHeight<styleHeight){if(computed.overflowY===\"hidden\"){changeOverflow(\"scroll\");resize();actualHeight=computed.boxSizing===\"content-box\"?Math.round(parseFloat(window.getComputedStyle(ta,null).height)):ta.offsetHeight}}else{if(computed.overflowY!==\"hidden\"){changeOverflow(\"hidden\");resize();actualHeight=computed.boxSizing===\"content-box\"?Math.round(parseFloat(window.getComputedStyle(ta,null).height)):ta.offsetHeight}}if(cachedHeight!==actualHeight){cachedHeight=actualHeight;var evt=createEvent(\"autosize:resized\");try{ta.dispatchEvent(evt)}catch(err){}}}var pageResize=function pageResize(){if(ta.clientWidth!==clientWidth){update()}};var destroy=function(style){window.removeEventListener(\"resize\",pageResize,false);ta.removeEventListener(\"input\",update,false);ta.removeEventListener(\"keyup\",update,false);ta.removeEventListener(\"autosize:destroy\",destroy,false);ta.removeEventListener(\"autosize:update\",update,false);Object.keys(style).forEach(function(key){ta.style[key]=style[key]});map[\"delete\"](ta)}.bind(ta,{height:ta.style.height,resize:ta.style.resize,overflowY:ta.style.overflowY,overflowX:ta.style.overflowX,wordWrap:ta.style.wordWrap});ta.addEventListener(\"autosize:destroy\",destroy,false);if(\"onpropertychange\"in ta&&\"oninput\"in ta){ta.addEventListener(\"keyup\",update,false)}window.addEventListener(\"resize\",pageResize,false);ta.addEventListener(\"input\",update,false);ta.addEventListener(\"autosize:update\",update,false);ta.style.overflowX=\"hidden\";ta.style.wordWrap=\"break-word\";map.set(ta,{destroy:destroy,update:update});init()}function destroy(ta){var methods=map.get(ta);if(methods){methods.destroy()}}function update(ta){var methods=map.get(ta);if(methods){methods.update()}}var autosize=null;if(typeof window===\"undefined\"||typeof window.getComputedStyle!==\"function\"){autosize=function autosize(el){return el};autosize.destroy=function(el){return el};autosize.update=function(el){return el}}else{autosize=function autosize(el,options){if(el){Array.prototype.forEach.call(el.length?el:[el],function(x){return assign(x,options)})}return el};autosize.destroy=function(el){if(el){Array.prototype.forEach.call(el.length?el:[el],destroy)}return el};autosize.update=function(el){if(el){Array.prototype.forEach.call(el.length?el:[el],update)}return el}}exports[\"default\"]=autosize;module.exports=exports[\"default\"]})},{}],2:[function(require,module,exports){if(typeof acf!==\"undefined\"){require(\"./textarea\");require(\"./wysiwyg\");console.log(\"mu\");if(ACFAutosize.enabledByDefault){console.log(\"enabled\");window.jQuery(\"body\").addClass(\"acf-autosize-enabled\")}}},{\"./textarea\":3,\"./wysiwyg\":4}],3:[function(require,module,exports){var autosize=require(\"autosize\");(function(\$){var textareas;if(ACFAutosize.enabledByDefault){textareas=\$(\".acf-field:not(.no-autosize) textarea\")}else{textareas=\$(\".acf-field.autosize textarea\")}autosize(textareas);\$(document).ready(function(){autosize.update(textareas)});\$(window).on(\"load\",function(){autosize.update(textareas)});acf.add_action(\"append\",function(\$el){var textarea=null;if(ACFAutosize.enabledByDefault){textarea=\$el.find(\".acf-field:not(.no-autosize) textarea\")}else{textarea=\$el.find(\".acf-field.autosize textarea\")}if(textarea.length>0){autosize(textarea)}})})(window.jQuery)},{\"autosize\":1}],4:[function(require,module,exports){(function(\$){function editorAutoHeight(editor){var minHeight=arguments.length>1&&arguments[1]!==undefined?arguments[1]:200;var height=\$(editor.iframeElement).contents().find(\"html\").height()||minHeight;height=height<minHeight?minHeight:height;\$(editor.iframeElement).css({height:height,minHeight:minHeight})}function addSlugAttr(\$field){var name=\$field.attr(\"data-name\");var body=\$(\"iframe\",\$field).contents().find(\"body\");body.attr(\"data-wysiwyg-slug\",name)}window.acf.add_action(\"wysiwyg_tinymce_init\",function(editor,id,options,\$field){var eventHandler=function eventHandler(){editorAutoHeight(editor,ACFAutosize.wysiwyg.minHeight)};editor.on(\"init\",function(){addSlugAttr(\$field)});var doAutosize=false;if(ACFAutosize.enabledByDefault){doAutosize=!\$field.hasClass(\"no-autosize\")}else{doAutosize=\$field.hasClass(\"autosize\")}if(!doAutosize){return}editor.on(\"init\",eventHandler);editor.on(\"change\",eventHandler);\$(window).resize(eventHandler)})})(window.jQuery)},{}]},{},[2]);";
		echo "</script>";
	}

	public function echoCss() {
		echo "<style>";
		echo "body.acf-autosize-enabled .acf-field:not(.no-autosize) .mce-top-part{position:-webkit-sticky;position:sticky;top:46px}@media (min-width:783px){body.acf-autosize-enabled .acf-field:not(.no-autosize) .mce-top-part{top:30px}}body.acf-autosize-enabled .block-editor .acf-field:not(.no-autosize) .mce-top-part{top:0}.acf-field.autosize .mce-top-part{position:-webkit-sticky;position:sticky;top:46px}@media (min-width:783px){.acf-field.autosize .mce-top-part{top:30px}}.block-editor .acf-field.autosize .mce-top-part{top:0}";
		echo "</style>";
	}
}

new ACFAutosizeMu();

