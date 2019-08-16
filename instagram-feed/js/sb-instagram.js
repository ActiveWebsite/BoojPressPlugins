var sbi_js_exists = (typeof sbi_js_exists !== 'undefined') ? true : false;
if(!sbi_js_exists){

    /*!
 * Isotope PACKAGED v3.0.6
 *
 * Licensed GPLv3 for open source use
 * or Isotope Commercial License for commercial use
 *
 * https://isotope.metafizzy.co
 * Copyright 2010-2018 Metafizzy
 */

    !function(t,e){"function"==typeof define&&define.amd?define("jquery-bridget/jquery-bridget",["jquery"],function(i){return e(t,i)}):"object"==typeof module&&module.exports?module.exports=e(t,require("jquery")):t.jQueryBridget=e(t,t.jQuery)}(window,function(t,e){"use strict";function i(i,s,a){function u(t,e,o){var n,s="$()."+i+'("'+e+'")';return t.each(function(t,u){var h=a.data(u,i);if(!h)return void r(i+" not initialized. Cannot call methods, i.e. "+s);var d=h[e];if(!d||"_"==e.charAt(0))return void r(s+" is not a valid method");var l=d.apply(h,o);n=void 0===n?l:n}),void 0!==n?n:t}function h(t,e){t.each(function(t,o){var n=a.data(o,i);n?(n.option(e),n._init()):(n=new s(o,e),a.data(o,i,n))})}a=a||e||t.jQuery,a&&(s.prototype.option||(s.prototype.option=function(t){a.isPlainObject(t)&&(this.options=a.extend(!0,this.options,t))}),a.fn[i]=function(t){if("string"==typeof t){var e=n.call(arguments,1);return u(this,t,e)}return h(this,t),this},o(a))}function o(t){!t||t&&t.bridget||(t.bridget=i)}var n=Array.prototype.slice,s=t.console,r="undefined"==typeof s?function(){}:function(t){s.error(t)};return o(e||t.jQuery),i}),function(t,e){"function"==typeof define&&define.amd?define("ev-emitter/ev-emitter",e):"object"==typeof module&&module.exports?module.exports=e():t.EvEmitter=e()}("undefined"!=typeof window?window:this,function(){function t(){}var e=t.prototype;return e.on=function(t,e){if(t&&e){var i=this._events=this._events||{},o=i[t]=i[t]||[];return o.indexOf(e)==-1&&o.push(e),this}},e.once=function(t,e){if(t&&e){this.on(t,e);var i=this._onceEvents=this._onceEvents||{},o=i[t]=i[t]||{};return o[e]=!0,this}},e.off=function(t,e){var i=this._events&&this._events[t];if(i&&i.length){var o=i.indexOf(e);return o!=-1&&i.splice(o,1),this}},e.emitEvent=function(t,e){var i=this._events&&this._events[t];if(i&&i.length){i=i.slice(0),e=e||[];for(var o=this._onceEvents&&this._onceEvents[t],n=0;n<i.length;n++){var s=i[n],r=o&&o[s];r&&(this.off(t,s),delete o[s]),s.apply(this,e)}return this}},e.allOff=function(){delete this._events,delete this._onceEvents},t}),function(t,e){"function"==typeof define&&define.amd?define("get-size/get-size",e):"object"==typeof module&&module.exports?module.exports=e():t.getSize=e()}(window,function(){"use strict";function t(t){var e=parseFloat(t),i=t.indexOf("%")==-1&&!isNaN(e);return i&&e}function e(){}function i(){for(var t={width:0,height:0,innerWidth:0,innerHeight:0,outerWidth:0,outerHeight:0},e=0;e<h;e++){var i=u[e];t[i]=0}return t}function o(t){var e=getComputedStyle(t);return e||a("Style returned "+e+". Are you running this code in a hidden iframe on Firefox? See https://bit.ly/getsizebug1"),e}function n(){if(!d){d=!0;var e=document.createElement("div");e.style.width="200px",e.style.padding="1px 2px 3px 4px",e.style.borderStyle="solid",e.style.borderWidth="1px 2px 3px 4px",e.style.boxSizing="border-box";var i=document.body||document.documentElement;i.appendChild(e);var n=o(e);r=200==Math.round(t(n.width)),s.isBoxSizeOuter=r,i.removeChild(e)}}function s(e){if(n(),"string"==typeof e&&(e=document.querySelector(e)),e&&"object"==typeof e&&e.nodeType){var s=o(e);if("none"==s.display)return i();var a={};a.width=e.offsetWidth,a.height=e.offsetHeight;for(var d=a.isBorderBox="border-box"==s.boxSizing,l=0;l<h;l++){var f=u[l],c=s[f],m=parseFloat(c);a[f]=isNaN(m)?0:m}var p=a.paddingLeft+a.paddingRight,y=a.paddingTop+a.paddingBottom,g=a.marginLeft+a.marginRight,v=a.marginTop+a.marginBottom,_=a.borderLeftWidth+a.borderRightWidth,z=a.borderTopWidth+a.borderBottomWidth,I=d&&r,x=t(s.width);x!==!1&&(a.width=x+(I?0:p+_));var S=t(s.height);return S!==!1&&(a.height=S+(I?0:y+z)),a.innerWidth=a.width-(p+_),a.innerHeight=a.height-(y+z),a.outerWidth=a.width+g,a.outerHeight=a.height+v,a}}var r,a="undefined"==typeof console?e:function(t){console.error(t)},u=["paddingLeft","paddingRight","paddingTop","paddingBottom","marginLeft","marginRight","marginTop","marginBottom","borderLeftWidth","borderRightWidth","borderTopWidth","borderBottomWidth"],h=u.length,d=!1;return s}),function(t,e){"use strict";"function"==typeof define&&define.amd?define("desandro-matches-selector/matches-selector",e):"object"==typeof module&&module.exports?module.exports=e():t.matchesSelector=e()}(window,function(){"use strict";var t=function(){var t=window.Element.prototype;if(t.matches)return"matches";if(t.matchesSelector)return"matchesSelector";for(var e=["webkit","moz","ms","o"],i=0;i<e.length;i++){var o=e[i],n=o+"MatchesSelector";if(t[n])return n}}();return function(e,i){return e[t](i)}}),function(t,e){"function"==typeof define&&define.amd?define("fizzy-ui-utils/utils",["desandro-matches-selector/matches-selector"],function(i){return e(t,i)}):"object"==typeof module&&module.exports?module.exports=e(t,require("desandro-matches-selector")):t.fizzyUIUtils=e(t,t.matchesSelector)}(window,function(t,e){var i={};i.extend=function(t,e){for(var i in e)t[i]=e[i];return t},i.modulo=function(t,e){return(t%e+e)%e};var o=Array.prototype.slice;i.makeArray=function(t){if(Array.isArray(t))return t;if(null===t||void 0===t)return[];var e="object"==typeof t&&"number"==typeof t.length;return e?o.call(t):[t]},i.removeFrom=function(t,e){var i=t.indexOf(e);i!=-1&&t.splice(i,1)},i.getParent=function(t,i){for(;t.parentNode&&t!=document.body;)if(t=t.parentNode,e(t,i))return t},i.getQueryElement=function(t){return"string"==typeof t?document.querySelector(t):t},i.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},i.filterFindElements=function(t,o){t=i.makeArray(t);var n=[];return t.forEach(function(t){if(t instanceof HTMLElement){if(!o)return void n.push(t);e(t,o)&&n.push(t);for(var i=t.querySelectorAll(o),s=0;s<i.length;s++)n.push(i[s])}}),n},i.debounceMethod=function(t,e,i){i=i||100;var o=t.prototype[e],n=e+"Timeout";t.prototype[e]=function(){var t=this[n];clearTimeout(t);var e=arguments,s=this;this[n]=setTimeout(function(){o.apply(s,e),delete s[n]},i)}},i.docReady=function(t){var e=document.readyState;"complete"==e||"interactive"==e?setTimeout(t):document.addEventListener("DOMContentLoaded",t)},i.toDashed=function(t){return t.replace(/(.)([A-Z])/g,function(t,e,i){return e+"-"+i}).toLowerCase()};var n=t.console;return i.htmlInit=function(e,o){i.docReady(function(){var s=i.toDashed(o),r="data-"+s,a=document.querySelectorAll("["+r+"]"),u=document.querySelectorAll(".js-"+s),h=i.makeArray(a).concat(i.makeArray(u)),d=r+"-options",l=t.jQuery;h.forEach(function(t){var i,s=t.getAttribute(r)||t.getAttribute(d);try{i=s&&JSON.parse(s)}catch(a){return void(n&&n.error("Error parsing "+r+" on "+t.className+": "+a))}var u=new e(t,i);l&&l.data(t,o,u)})})},i}),function(t,e){"function"==typeof define&&define.amd?define("outlayer/item",["ev-emitter/ev-emitter","get-size/get-size"],e):"object"==typeof module&&module.exports?module.exports=e(require("ev-emitter"),require("get-size")):(t.Outlayer={},t.Outlayer.Item=e(t.EvEmitter,t.getSize))}(window,function(t,e){"use strict";function i(t){for(var e in t)return!1;return e=null,!0}function o(t,e){t&&(this.element=t,this.layout=e,this.position={x:0,y:0},this._create())}function n(t){return t.replace(/([A-Z])/g,function(t){return"-"+t.toLowerCase()})}var s=document.documentElement.style,r="string"==typeof s.transition?"transition":"WebkitTransition",a="string"==typeof s.transform?"transform":"WebkitTransform",u={WebkitTransition:"webkitTransitionEnd",transition:"transitionend"}[r],h={transform:a,transition:r,transitionDuration:r+"Duration",transitionProperty:r+"Property",transitionDelay:r+"Delay"},d=o.prototype=Object.create(t.prototype);d.constructor=o,d._create=function(){this._transn={ingProperties:{},clean:{},onEnd:{}},this.css({position:"absolute"})},d.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},d.getSize=function(){this.size=e(this.element)},d.css=function(t){var e=this.element.style;for(var i in t){var o=h[i]||i;e[o]=t[i]}},d.getPosition=function(){var t=getComputedStyle(this.element),e=this.layout._getOption("originLeft"),i=this.layout._getOption("originTop"),o=t[e?"left":"right"],n=t[i?"top":"bottom"],s=parseFloat(o),r=parseFloat(n),a=this.layout.size;o.indexOf("%")!=-1&&(s=s/100*a.width),n.indexOf("%")!=-1&&(r=r/100*a.height),s=isNaN(s)?0:s,r=isNaN(r)?0:r,s-=e?a.paddingLeft:a.paddingRight,r-=i?a.paddingTop:a.paddingBottom,this.position.x=s,this.position.y=r},d.layoutPosition=function(){var t=this.layout.size,e={},i=this.layout._getOption("originLeft"),o=this.layout._getOption("originTop"),n=i?"paddingLeft":"paddingRight",s=i?"left":"right",r=i?"right":"left",a=this.position.x+t[n];e[s]=this.getXValue(a),e[r]="";var u=o?"paddingTop":"paddingBottom",h=o?"top":"bottom",d=o?"bottom":"top",l=this.position.y+t[u];e[h]=this.getYValue(l),e[d]="",this.css(e),this.emitEvent("layout",[this])},d.getXValue=function(t){var e=this.layout._getOption("horizontal");return this.layout.options.percentPosition&&!e?t/this.layout.size.width*100+"%":t+"px"},d.getYValue=function(t){var e=this.layout._getOption("horizontal");return this.layout.options.percentPosition&&e?t/this.layout.size.height*100+"%":t+"px"},d._transitionTo=function(t,e){this.getPosition();var i=this.position.x,o=this.position.y,n=t==this.position.x&&e==this.position.y;if(this.setPosition(t,e),n&&!this.isTransitioning)return void this.layoutPosition();var s=t-i,r=e-o,a={};a.transform=this.getTranslate(s,r),this.transition({to:a,onTransitionEnd:{transform:this.layoutPosition},isCleaning:!0})},d.getTranslate=function(t,e){var i=this.layout._getOption("originLeft"),o=this.layout._getOption("originTop");return t=i?t:-t,e=o?e:-e,"translate3d("+t+"px, "+e+"px, 0)"},d.goTo=function(t,e){this.setPosition(t,e),this.layoutPosition()},d.moveTo=d._transitionTo,d.setPosition=function(t,e){this.position.x=parseFloat(t),this.position.y=parseFloat(e)},d._nonTransition=function(t){this.css(t.to),t.isCleaning&&this._removeStyles(t.to);for(var e in t.onTransitionEnd)t.onTransitionEnd[e].call(this)},d.transition=function(t){if(!parseFloat(this.layout.options.transitionDuration))return void this._nonTransition(t);var e=this._transn;for(var i in t.onTransitionEnd)e.onEnd[i]=t.onTransitionEnd[i];for(i in t.to)e.ingProperties[i]=!0,t.isCleaning&&(e.clean[i]=!0);if(t.from){this.css(t.from);var o=this.element.offsetHeight;o=null}this.enableTransition(t.to),this.css(t.to),this.isTransitioning=!0};var l="opacity,"+n(a);d.enableTransition=function(){if(!this.isTransitioning){var t=this.layout.options.transitionDuration;t="number"==typeof t?t+"ms":t,this.css({transitionProperty:l,transitionDuration:t,transitionDelay:this.staggerDelay||0}),this.element.addEventListener(u,this,!1)}},d.onwebkitTransitionEnd=function(t){this.ontransitionend(t)},d.onotransitionend=function(t){this.ontransitionend(t)};var f={"-webkit-transform":"transform"};d.ontransitionend=function(t){if(t.target===this.element){var e=this._transn,o=f[t.propertyName]||t.propertyName;if(delete e.ingProperties[o],i(e.ingProperties)&&this.disableTransition(),o in e.clean&&(this.element.style[t.propertyName]="",delete e.clean[o]),o in e.onEnd){var n=e.onEnd[o];n.call(this),delete e.onEnd[o]}this.emitEvent("transitionEnd",[this])}},d.disableTransition=function(){this.removeTransitionStyles(),this.element.removeEventListener(u,this,!1),this.isTransitioning=!1},d._removeStyles=function(t){var e={};for(var i in t)e[i]="";this.css(e)};var c={transitionProperty:"",transitionDuration:"",transitionDelay:""};return d.removeTransitionStyles=function(){this.css(c)},d.stagger=function(t){t=isNaN(t)?0:t,this.staggerDelay=t+"ms"},d.removeElem=function(){this.element.parentNode.removeChild(this.element),this.css({display:""}),this.emitEvent("remove",[this])},d.remove=function(){return r&&parseFloat(this.layout.options.transitionDuration)?(this.once("transitionEnd",function(){this.removeElem()}),void this.hide()):void this.removeElem()},d.reveal=function(){delete this.isHidden,this.css({display:""});var t=this.layout.options,e={},i=this.getHideRevealTransitionEndProperty("visibleStyle");e[i]=this.onRevealTransitionEnd,this.transition({from:t.hiddenStyle,to:t.visibleStyle,isCleaning:!0,onTransitionEnd:e})},d.onRevealTransitionEnd=function(){this.isHidden||this.emitEvent("reveal")},d.getHideRevealTransitionEndProperty=function(t){var e=this.layout.options[t];if(e.opacity)return"opacity";for(var i in e)return i},d.hide=function(){this.isHidden=!0,this.css({display:""});var t=this.layout.options,e={},i=this.getHideRevealTransitionEndProperty("hiddenStyle");e[i]=this.onHideTransitionEnd,this.transition({from:t.visibleStyle,to:t.hiddenStyle,isCleaning:!0,onTransitionEnd:e})},d.onHideTransitionEnd=function(){this.isHidden&&(this.css({display:"none"}),this.emitEvent("hide"))},d.destroy=function(){this.css({position:"",left:"",right:"",top:"",bottom:"",transition:"",transform:""})},o}),function(t,e){"use strict";"function"==typeof define&&define.amd?define("outlayer/outlayer",["ev-emitter/ev-emitter","get-size/get-size","fizzy-ui-utils/utils","./item"],function(i,o,n,s){return e(t,i,o,n,s)}):"object"==typeof module&&module.exports?module.exports=e(t,require("ev-emitter"),require("get-size"),require("fizzy-ui-utils"),require("./item")):t.Outlayer=e(t,t.EvEmitter,t.getSize,t.fizzyUIUtils,t.Outlayer.Item)}(window,function(t,e,i,o,n){"use strict";function s(t,e){var i=o.getQueryElement(t);if(!i)return void(u&&u.error("Bad element for "+this.constructor.namespace+": "+(i||t)));this.element=i,h&&(this.$element=h(this.element)),this.options=o.extend({},this.constructor.defaults),this.option(e);var n=++l;this.element.outlayerGUID=n,f[n]=this,this._create();var s=this._getOption("initLayout");s&&this.layout()}function r(t){function e(){t.apply(this,arguments)}return e.prototype=Object.create(t.prototype),e.prototype.constructor=e,e}function a(t){if("number"==typeof t)return t;var e=t.match(/(^\d*\.?\d*)(\w*)/),i=e&&e[1],o=e&&e[2];if(!i.length)return 0;i=parseFloat(i);var n=m[o]||1;return i*n}var u=t.console,h=t.jQuery,d=function(){},l=0,f={};s.namespace="outlayer",s.Item=n,s.defaults={containerStyle:{position:"relative"},initLayout:!0,originLeft:!0,originTop:!0,resize:!0,resizeContainer:!0,transitionDuration:"0.4s",hiddenStyle:{opacity:0,transform:"scale(0.001)"},visibleStyle:{opacity:1,transform:"scale(1)"}};var c=s.prototype;o.extend(c,e.prototype),c.option=function(t){o.extend(this.options,t)},c._getOption=function(t){var e=this.constructor.compatOptions[t];return e&&void 0!==this.options[e]?this.options[e]:this.options[t]},s.compatOptions={initLayout:"isInitLayout",horizontal:"isHorizontal",layoutInstant:"isLayoutInstant",originLeft:"isOriginLeft",originTop:"isOriginTop",resize:"isResizeBound",resizeContainer:"isResizingContainer"},c._create=function(){this.reloadItems(),this.stamps=[],this.stamp(this.options.stamp),o.extend(this.element.style,this.options.containerStyle);var t=this._getOption("resize");t&&this.bindResize()},c.reloadItems=function(){this.items=this._itemize(this.element.children)},c._itemize=function(t){for(var e=this._filterFindItemElements(t),i=this.constructor.Item,o=[],n=0;n<e.length;n++){var s=e[n],r=new i(s,this);o.push(r)}return o},c._filterFindItemElements=function(t){return o.filterFindElements(t,this.options.itemSelector)},c.getItemElements=function(){return this.items.map(function(t){return t.element})},c.layout=function(){this._resetLayout(),this._manageStamps();var t=this._getOption("layoutInstant"),e=void 0!==t?t:!this._isLayoutInited;this.layoutItems(this.items,e),this._isLayoutInited=!0},c._init=c.layout,c._resetLayout=function(){this.getSize()},c.getSize=function(){this.size=i(this.element)},c._getMeasurement=function(t,e){var o,n=this.options[t];n?("string"==typeof n?o=this.element.querySelector(n):n instanceof HTMLElement&&(o=n),this[t]=o?i(o)[e]:n):this[t]=0},c.layoutItems=function(t,e){t=this._getItemsForLayout(t),this._layoutItems(t,e),this._postLayout()},c._getItemsForLayout=function(t){return t.filter(function(t){return!t.isIgnored})},c._layoutItems=function(t,e){if(this._emitCompleteOnItems("layout",t),t&&t.length){var i=[];t.forEach(function(t){var o=this._getItemLayoutPosition(t);o.item=t,o.isInstant=e||t.isLayoutInstant,i.push(o)},this),this._processLayoutQueue(i)}},c._getItemLayoutPosition=function(){return{x:0,y:0}},c._processLayoutQueue=function(t){this.updateStagger(),t.forEach(function(t,e){this._positionItem(t.item,t.x,t.y,t.isInstant,e)},this)},c.updateStagger=function(){var t=this.options.stagger;return null===t||void 0===t?void(this.stagger=0):(this.stagger=a(t),this.stagger)},c._positionItem=function(t,e,i,o,n){o?t.goTo(e,i):(t.stagger(n*this.stagger),t.moveTo(e,i))},c._postLayout=function(){this.resizeContainer()},c.resizeContainer=function(){var t=this._getOption("resizeContainer");if(t){var e=this._getContainerSize();e&&(this._setContainerMeasure(e.width,!0),this._setContainerMeasure(e.height,!1))}},c._getContainerSize=d,c._setContainerMeasure=function(t,e){if(void 0!==t){var i=this.size;i.isBorderBox&&(t+=e?i.paddingLeft+i.paddingRight+i.borderLeftWidth+i.borderRightWidth:i.paddingBottom+i.paddingTop+i.borderTopWidth+i.borderBottomWidth),t=Math.max(t,0),this.element.style[e?"width":"height"]=t+"px"}},c._emitCompleteOnItems=function(t,e){function i(){n.dispatchEvent(t+"Complete",null,[e])}function o(){r++,r==s&&i()}var n=this,s=e.length;if(!e||!s)return void i();var r=0;e.forEach(function(e){e.once(t,o)})},c.dispatchEvent=function(t,e,i){var o=e?[e].concat(i):i;if(this.emitEvent(t,o),h)if(this.$element=this.$element||h(this.element),e){var n=h.Event(e);n.type=t,this.$element.trigger(n,i)}else this.$element.trigger(t,i)},c.ignore=function(t){var e=this.getItem(t);e&&(e.isIgnored=!0)},c.unignore=function(t){var e=this.getItem(t);e&&delete e.isIgnored},c.stamp=function(t){t=this._find(t),t&&(this.stamps=this.stamps.concat(t),t.forEach(this.ignore,this))},c.unstamp=function(t){t=this._find(t),t&&t.forEach(function(t){o.removeFrom(this.stamps,t),this.unignore(t)},this)},c._find=function(t){if(t)return"string"==typeof t&&(t=this.element.querySelectorAll(t)),t=o.makeArray(t)},c._manageStamps=function(){this.stamps&&this.stamps.length&&(this._getBoundingRect(),this.stamps.forEach(this._manageStamp,this))},c._getBoundingRect=function(){var t=this.element.getBoundingClientRect(),e=this.size;this._boundingRect={left:t.left+e.paddingLeft+e.borderLeftWidth,top:t.top+e.paddingTop+e.borderTopWidth,right:t.right-(e.paddingRight+e.borderRightWidth),bottom:t.bottom-(e.paddingBottom+e.borderBottomWidth)}},c._manageStamp=d,c._getElementOffset=function(t){var e=t.getBoundingClientRect(),o=this._boundingRect,n=i(t),s={left:e.left-o.left-n.marginLeft,top:e.top-o.top-n.marginTop,right:o.right-e.right-n.marginRight,bottom:o.bottom-e.bottom-n.marginBottom};return s},c.handleEvent=o.handleEvent,c.bindResize=function(){t.addEventListener("resize",this),this.isResizeBound=!0},c.unbindResize=function(){t.removeEventListener("resize",this),this.isResizeBound=!1},c.onresize=function(){this.resize()},o.debounceMethod(s,"onresize",100),c.resize=function(){this.isResizeBound&&this.needsResizeLayout()&&this.layout()},c.needsResizeLayout=function(){var t=i(this.element),e=this.size&&t;return e&&t.innerWidth!==this.size.innerWidth},c.addItems=function(t){var e=this._itemize(t);return e.length&&(this.items=this.items.concat(e)),e},c.appended=function(t){var e=this.addItems(t);e.length&&(this.layoutItems(e,!0),this.reveal(e))},c.prepended=function(t){var e=this._itemize(t);if(e.length){var i=this.items.slice(0);this.items=e.concat(i),this._resetLayout(),this._manageStamps(),this.layoutItems(e,!0),this.reveal(e),this.layoutItems(i)}},c.reveal=function(t){if(this._emitCompleteOnItems("reveal",t),t&&t.length){var e=this.updateStagger();t.forEach(function(t,i){t.stagger(i*e),t.reveal()})}},c.hide=function(t){if(this._emitCompleteOnItems("hide",t),t&&t.length){var e=this.updateStagger();t.forEach(function(t,i){t.stagger(i*e),t.hide()})}},c.revealItemElements=function(t){var e=this.getItems(t);this.reveal(e)},c.hideItemElements=function(t){var e=this.getItems(t);this.hide(e)},c.getItem=function(t){for(var e=0;e<this.items.length;e++){var i=this.items[e];if(i.element==t)return i}},c.getItems=function(t){t=o.makeArray(t);var e=[];return t.forEach(function(t){var i=this.getItem(t);i&&e.push(i)},this),e},c.remove=function(t){var e=this.getItems(t);this._emitCompleteOnItems("remove",e),e&&e.length&&e.forEach(function(t){t.remove(),o.removeFrom(this.items,t)},this)},c.destroy=function(){var t=this.element.style;t.height="",t.position="",t.width="",this.items.forEach(function(t){t.destroy()}),this.unbindResize();var e=this.element.outlayerGUID;delete f[e],delete this.element.outlayerGUID,h&&h.removeData(this.element,this.constructor.namespace)},s.data=function(t){t=o.getQueryElement(t);var e=t&&t.outlayerGUID;return e&&f[e]},s.create=function(t,e){var i=r(s);return i.defaults=o.extend({},s.defaults),o.extend(i.defaults,e),i.compatOptions=o.extend({},s.compatOptions),i.namespace=t,i.data=s.data,i.Item=r(n),o.htmlInit(i,t),h&&h.bridget&&h.bridget(t,i),i};var m={ms:1,s:1e3};return s.Item=n,s}),function(t,e){"function"==typeof define&&define.amd?define("isotope-layout/js/item",["outlayer/outlayer"],e):"object"==typeof module&&module.exports?module.exports=e(require("outlayer")):(t.Isotope=t.Isotope||{},t.Isotope.Item=e(t.Outlayer))}(window,function(t){"use strict";function e(){t.Item.apply(this,arguments)}var i=e.prototype=Object.create(t.Item.prototype),o=i._create;i._create=function(){this.id=this.layout.itemGUID++,o.call(this),this.sortData={}},i.updateSortData=function(){if(!this.isIgnored){this.sortData.id=this.id,this.sortData["original-order"]=this.id,this.sortData.random=Math.random();var t=this.layout.options.getSortData,e=this.layout._sorters;for(var i in t){var o=e[i];this.sortData[i]=o(this.element,this)}}};var n=i.destroy;return i.destroy=function(){n.apply(this,arguments),this.css({display:""})},e}),function(t,e){"function"==typeof define&&define.amd?define("isotope-layout/js/layout-mode",["get-size/get-size","outlayer/outlayer"],e):"object"==typeof module&&module.exports?module.exports=e(require("get-size"),require("outlayer")):(t.Isotope=t.Isotope||{},t.Isotope.LayoutMode=e(t.getSize,t.Outlayer))}(window,function(t,e){"use strict";function i(t){this.isotope=t,t&&(this.options=t.options[this.namespace],this.element=t.element,this.items=t.filteredItems,this.size=t.size)}var o=i.prototype,n=["_resetLayout","_getItemLayoutPosition","_manageStamp","_getContainerSize","_getElementOffset","needsResizeLayout","_getOption"];return n.forEach(function(t){o[t]=function(){return e.prototype[t].apply(this.isotope,arguments)}}),o.needsVerticalResizeLayout=function(){var e=t(this.isotope.element),i=this.isotope.size&&e;return i&&e.innerHeight!=this.isotope.size.innerHeight},o._getMeasurement=function(){this.isotope._getMeasurement.apply(this,arguments)},o.getColumnWidth=function(){this.getSegmentSize("column","Width")},o.getRowHeight=function(){this.getSegmentSize("row","Height")},o.getSegmentSize=function(t,e){var i=t+e,o="outer"+e;if(this._getMeasurement(i,o),!this[i]){var n=this.getFirstItemSize();this[i]=n&&n[o]||this.isotope.size["inner"+e]}},o.getFirstItemSize=function(){var e=this.isotope.filteredItems[0];return e&&e.element&&t(e.element)},o.layout=function(){this.isotope.layout.apply(this.isotope,arguments)},o.getSize=function(){this.isotope.getSize(),this.size=this.isotope.size},i.modes={},i.create=function(t,e){function n(){i.apply(this,arguments)}return n.prototype=Object.create(o),n.prototype.constructor=n,e&&(n.options=e),n.prototype.namespace=t,i.modes[t]=n,n},i}),function(t,e){"function"==typeof define&&define.amd?define("masonry-layout/masonry",["outlayer/outlayer","get-size/get-size"],e):"object"==typeof module&&module.exports?module.exports=e(require("outlayer"),require("get-size")):t.Masonry=e(t.Outlayer,t.getSize)}(window,function(t,e){var i=t.create("masonry");i.compatOptions.fitWidth="isFitWidth";var o=i.prototype;return o._resetLayout=function(){this.getSize(),this._getMeasurement("columnWidth","outerWidth"),this._getMeasurement("gutter","outerWidth"),this.measureColumns(),this.colYs=[];for(var t=0;t<this.cols;t++)this.colYs.push(0);this.maxY=0,this.horizontalColIndex=0},o.measureColumns=function(){if(this.getContainerWidth(),!this.columnWidth){var t=this.items[0],i=t&&t.element;this.columnWidth=i&&e(i).outerWidth||this.containerWidth}var o=this.columnWidth+=this.gutter,n=this.containerWidth+this.gutter,s=n/o,r=o-n%o,a=r&&r<1?"round":"floor";s=Math[a](s),this.cols=Math.max(s,1)},o.getContainerWidth=function(){var t=this._getOption("fitWidth"),i=t?this.element.parentNode:this.element,o=e(i);this.containerWidth=o&&o.innerWidth},o._getItemLayoutPosition=function(t){t.getSize();var e=t.size.outerWidth%this.columnWidth,i=e&&e<1?"round":"ceil",o=Math[i](t.size.outerWidth/this.columnWidth);o=Math.min(o,this.cols);for(var n=this.options.horizontalOrder?"_getHorizontalColPosition":"_getTopColPosition",s=this[n](o,t),r={x:this.columnWidth*s.col,y:s.y},a=s.y+t.size.outerHeight,u=o+s.col,h=s.col;h<u;h++)this.colYs[h]=a;return r},o._getTopColPosition=function(t){var e=this._getTopColGroup(t),i=Math.min.apply(Math,e);return{col:e.indexOf(i),y:i}},o._getTopColGroup=function(t){if(t<2)return this.colYs;for(var e=[],i=this.cols+1-t,o=0;o<i;o++)e[o]=this._getColGroupY(o,t);return e},o._getColGroupY=function(t,e){if(e<2)return this.colYs[t];var i=this.colYs.slice(t,t+e);return Math.max.apply(Math,i)},o._getHorizontalColPosition=function(t,e){var i=this.horizontalColIndex%this.cols,o=t>1&&i+t>this.cols;i=o?0:i;var n=e.size.outerWidth&&e.size.outerHeight;return this.horizontalColIndex=n?i+t:this.horizontalColIndex,{col:i,y:this._getColGroupY(i,t)}},o._manageStamp=function(t){var i=e(t),o=this._getElementOffset(t),n=this._getOption("originLeft"),s=n?o.left:o.right,r=s+i.outerWidth,a=Math.floor(s/this.columnWidth);a=Math.max(0,a);var u=Math.floor(r/this.columnWidth);u-=r%this.columnWidth?0:1,u=Math.min(this.cols-1,u);for(var h=this._getOption("originTop"),d=(h?o.top:o.bottom)+i.outerHeight,l=a;l<=u;l++)this.colYs[l]=Math.max(d,this.colYs[l])},o._getContainerSize=function(){this.maxY=Math.max.apply(Math,this.colYs);var t={height:this.maxY};return this._getOption("fitWidth")&&(t.width=this._getContainerFitWidth()),t},o._getContainerFitWidth=function(){for(var t=0,e=this.cols;--e&&0===this.colYs[e];)t++;return(this.cols-t)*this.columnWidth-this.gutter},o.needsResizeLayout=function(){var t=this.containerWidth;return this.getContainerWidth(),t!=this.containerWidth},i}),function(t,e){"function"==typeof define&&define.amd?define("isotope-layout/js/layout-modes/masonry",["../layout-mode","masonry-layout/masonry"],e):"object"==typeof module&&module.exports?module.exports=e(require("../layout-mode"),require("masonry-layout")):e(t.Isotope.LayoutMode,t.Masonry)}(window,function(t,e){"use strict";var i=t.create("masonry"),o=i.prototype,n={_getElementOffset:!0,layout:!0,_getMeasurement:!0};for(var s in e.prototype)n[s]||(o[s]=e.prototype[s]);var r=o.measureColumns;o.measureColumns=function(){this.items=this.isotope.filteredItems,r.call(this)};var a=o._getOption;return o._getOption=function(t){return"fitWidth"==t?void 0!==this.options.isFitWidth?this.options.isFitWidth:this.options.fitWidth:a.apply(this.isotope,arguments)},i}),function(t,e){"function"==typeof define&&define.amd?define("isotope-layout/js/layout-modes/fit-rows",["../layout-mode"],e):"object"==typeof exports?module.exports=e(require("../layout-mode")):e(t.Isotope.LayoutMode)}(window,function(t){"use strict";var e=t.create("fitRows"),i=e.prototype;return i._resetLayout=function(){this.x=0,this.y=0,this.maxY=0,this._getMeasurement("gutter","outerWidth")},i._getItemLayoutPosition=function(t){t.getSize();var e=t.size.outerWidth+this.gutter,i=this.isotope.size.innerWidth+this.gutter;0!==this.x&&e+this.x>i&&(this.x=0,this.y=this.maxY);var o={x:this.x,y:this.y};return this.maxY=Math.max(this.maxY,this.y+t.size.outerHeight),this.x+=e,o},i._getContainerSize=function(){return{height:this.maxY}},e}),function(t,e){"function"==typeof define&&define.amd?define("isotope-layout/js/layout-modes/vertical",["../layout-mode"],e):"object"==typeof module&&module.exports?module.exports=e(require("../layout-mode")):e(t.Isotope.LayoutMode)}(window,function(t){"use strict";var e=t.create("vertical",{horizontalAlignment:0}),i=e.prototype;return i._resetLayout=function(){this.y=0},i._getItemLayoutPosition=function(t){t.getSize();var e=(this.isotope.size.innerWidth-t.size.outerWidth)*this.options.horizontalAlignment,i=this.y;return this.y+=t.size.outerHeight,{x:e,y:i}},i._getContainerSize=function(){return{height:this.y}},e}),function(t,e){"function"==typeof define&&define.amd?define(["outlayer/outlayer","get-size/get-size","desandro-matches-selector/matches-selector","fizzy-ui-utils/utils","isotope-layout/js/item","isotope-layout/js/layout-mode","isotope-layout/js/layout-modes/masonry","isotope-layout/js/layout-modes/fit-rows","isotope-layout/js/layout-modes/vertical"],function(i,o,n,s,r,a){return e(t,i,o,n,s,r,a)}):"object"==typeof module&&module.exports?module.exports=e(t,require("outlayer"),require("get-size"),require("desandro-matches-selector"),require("fizzy-ui-utils"),require("isotope-layout/js/item"),require("isotope-layout/js/layout-mode"),require("isotope-layout/js/layout-modes/masonry"),require("isotope-layout/js/layout-modes/fit-rows"),require("isotope-layout/js/layout-modes/vertical")):t.Isotope=e(t,t.Outlayer,t.getSize,t.matchesSelector,t.fizzyUIUtils,t.Isotope.Item,t.Isotope.LayoutMode)}(window,function(t,e,i,o,n,s,r){function a(t,e){return function(i,o){for(var n=0;n<t.length;n++){var s=t[n],r=i.sortData[s],a=o.sortData[s];if(r>a||r<a){var u=void 0!==e[s]?e[s]:e,h=u?1:-1;return(r>a?1:-1)*h}}return 0}}var u=t.jQuery,h=String.prototype.trim?function(t){return t.trim()}:function(t){return t.replace(/^\s+|\s+$/g,"")},d=e.create("isotope",{layoutMode:"masonry",isJQueryFiltering:!0,sortAscending:!0});d.Item=s,d.LayoutMode=r;var l=d.prototype;l._create=function(){this.itemGUID=0,this._sorters={},this._getSorters(),e.prototype._create.call(this),this.modes={},this.filteredItems=this.items,this.sortHistory=["original-order"];for(var t in r.modes)this._initLayoutMode(t)},l.reloadItems=function(){this.itemGUID=0,e.prototype.reloadItems.call(this)},l._itemize=function(){for(var t=e.prototype._itemize.apply(this,arguments),i=0;i<t.length;i++){var o=t[i];o.id=this.itemGUID++}return this._updateItemsSortData(t),t},l._initLayoutMode=function(t){var e=r.modes[t],i=this.options[t]||{};this.options[t]=e.options?n.extend(e.options,i):i,this.modes[t]=new e(this)},l.layout=function(){return!this._isLayoutInited&&this._getOption("initLayout")?void this.arrange():void this._layout()},l._layout=function(){var t=this._getIsInstant();this._resetLayout(),this._manageStamps(),this.layoutItems(this.filteredItems,t),this._isLayoutInited=!0},l.arrange=function(t){this.option(t),this._getIsInstant();var e=this._filter(this.items);this.filteredItems=e.matches,this._bindArrangeComplete(),this._isInstant?this._noTransition(this._hideReveal,[e]):this._hideReveal(e),this._sort(),this._layout()},l._init=l.arrange,l._hideReveal=function(t){this.reveal(t.needReveal),this.hide(t.needHide)},l._getIsInstant=function(){var t=this._getOption("layoutInstant"),e=void 0!==t?t:!this._isLayoutInited;return this._isInstant=e,e},l._bindArrangeComplete=function(){function t(){e&&i&&o&&n.dispatchEvent("arrangeComplete",null,[n.filteredItems])}var e,i,o,n=this;this.once("layoutComplete",function(){e=!0,t()}),this.once("hideComplete",function(){i=!0,t()}),this.once("revealComplete",function(){o=!0,t()})},l._filter=function(t){var e=this.options.filter;e=e||"*";for(var i=[],o=[],n=[],s=this._getFilterTest(e),r=0;r<t.length;r++){var a=t[r];if(!a.isIgnored){var u=s(a);u&&i.push(a),u&&a.isHidden?o.push(a):u||a.isHidden||n.push(a)}}return{matches:i,needReveal:o,needHide:n}},l._getFilterTest=function(t){return u&&this.options.isJQueryFiltering?function(e){return u(e.element).is(t);
    }:"function"==typeof t?function(e){return t(e.element)}:function(e){return o(e.element,t)}},l.updateSortData=function(t){var e;t?(t=n.makeArray(t),e=this.getItems(t)):e=this.items,this._getSorters(),this._updateItemsSortData(e)},l._getSorters=function(){var t=this.options.getSortData;for(var e in t){var i=t[e];this._sorters[e]=f(i)}},l._updateItemsSortData=function(t){for(var e=t&&t.length,i=0;e&&i<e;i++){var o=t[i];o.updateSortData()}};var f=function(){function t(t){if("string"!=typeof t)return t;var i=h(t).split(" "),o=i[0],n=o.match(/^\[(.+)\]$/),s=n&&n[1],r=e(s,o),a=d.sortDataParsers[i[1]];return t=a?function(t){return t&&a(r(t))}:function(t){return t&&r(t)}}function e(t,e){return t?function(e){return e.getAttribute(t)}:function(t){var i=t.querySelector(e);return i&&i.textContent}}return t}();d.sortDataParsers={parseInt:function(t){return parseInt(t,10)},parseFloat:function(t){return parseFloat(t)}},l._sort=function(){if(this.options.sortBy){var t=n.makeArray(this.options.sortBy);this._getIsSameSortBy(t)||(this.sortHistory=t.concat(this.sortHistory));var e=a(this.sortHistory,this.options.sortAscending);this.filteredItems.sort(e)}},l._getIsSameSortBy=function(t){for(var e=0;e<t.length;e++)if(t[e]!=this.sortHistory[e])return!1;return!0},l._mode=function(){var t=this.options.layoutMode,e=this.modes[t];if(!e)throw new Error("No layout mode: "+t);return e.options=this.options[t],e},l._resetLayout=function(){e.prototype._resetLayout.call(this),this._mode()._resetLayout()},l._getItemLayoutPosition=function(t){return this._mode()._getItemLayoutPosition(t)},l._manageStamp=function(t){this._mode()._manageStamp(t)},l._getContainerSize=function(){return this._mode()._getContainerSize()},l.needsResizeLayout=function(){return this._mode().needsResizeLayout()},l.appended=function(t){var e=this.addItems(t);if(e.length){var i=this._filterRevealAdded(e);this.filteredItems=this.filteredItems.concat(i)}},l.prepended=function(t){var e=this._itemize(t);if(e.length){this._resetLayout(),this._manageStamps();var i=this._filterRevealAdded(e);this.layoutItems(this.filteredItems),this.filteredItems=i.concat(this.filteredItems),this.items=e.concat(this.items)}},l._filterRevealAdded=function(t){var e=this._filter(t);return this.hide(e.needHide),this.reveal(e.matches),this.layoutItems(e.matches,!0),e.matches},l.insert=function(t){var e=this.addItems(t);if(e.length){var i,o,n=e.length;for(i=0;i<n;i++)o=e[i],this.element.appendChild(o.element);var s=this._filter(e).matches;for(i=0;i<n;i++)e[i].isLayoutInstant=!0;for(this.arrange(),i=0;i<n;i++)delete e[i].isLayoutInstant;this.reveal(s)}};var c=l.remove;return l.remove=function(t){t=n.makeArray(t);var e=this.getItems(t);c.call(this,t);for(var i=e&&e.length,o=0;i&&o<i;o++){var s=e[o];n.removeFrom(this.filteredItems,s)}},l.shuffle=function(){for(var t=0;t<this.items.length;t++){var e=this.items[t];e.sortData.random=Math.random()}this.options.sortBy="random",this._sort(),this._layout()},l._noTransition=function(t,e){var i=this.options.transitionDuration;this.options.transitionDuration=0;var o=t.apply(this,e);return this.options.transitionDuration=i,o},l.getFilteredItemElements=function(){return this.filteredItems.map(function(t){return t.element})},d});



    // Carousel
    !function(a,b,c,d){function e(b,c){this.settings=null,this.options=a.extend({},e.Defaults,c),this.$element=a(b),this._handlers={},this._plugins={},this._supress={},this._current=null,this._speed=null,this._coordinates=[],this._breakpoint=null,this._width=null,this._items=[],this._clones=[],this._mergers=[],this._widths=[],this._invalidated={},this._pipe=[],this._drag={time:null,target:null,pointer:null,stage:{start:null,current:null},direction:null},this._states={current:{},tags:{initializing:["busy"],animating:["busy"],dragging:["interacting"]}},a.each(["onResize","onThrottledResize"],a.proxy(function(b,c){this._handlers[c]=a.proxy(this[c],this)},this)),a.each(e.Plugins,a.proxy(function(a,b){this._plugins[a.charAt(0).toLowerCase()+a.slice(1)]=new b(this)},this)),a.each(e.Workers,a.proxy(function(b,c){this._pipe.push({filter:c.filter,run:a.proxy(c.run,this)})},this)),this.setup(),this.initialize()}e.Defaults={items:3,loop:!1,center:!1,rewind:!1,mouseDrag:!0,touchDrag:!0,pullDrag:!0,freeDrag:!1,margin:0,stagePadding:0,merge:!1,mergeFit:!0,autoWidth:!1,startPosition:0,rtl:!1,smartSpeed:250,fluidSpeed:!1,dragEndSpeed:!1,responsive:{},responsiveRefreshRate:200,responsiveBaseElement:b,fallbackEasing:"swing",info:!1,nestedItemSelector:!1,itemElement:"div",stageElement:"div",refreshClass:"sbi-owl-refresh",loadedClass:"sbi-owl-loaded",loadingClass:"sbi-owl-loading",rtlClass:"sbi-owl-rtl",responsiveClass:"sbi-owl-responsive",dragClass:"sbi-owl-drag",itemClass:"sbi-owl-item",stageClass:"sbi-owl-stage",stageOuterClass:"sbi-owl-stage-outer",grabClass:"sbi-owl-grab"},e.Width={Default:"default",Inner:"inner",Outer:"outer"},e.Type={Event:"event",State:"state"},e.Plugins={},e.Workers=[{filter:["width","settings"],run:function(){this._width=this.$element.width()}},{filter:["width","items","settings"],run:function(a){a.current=this._items&&this._items[this.relative(this._current)]}},{filter:["items","settings"],run:function(){this.$stage.children(".cloned").remove()}},{filter:["width","items","settings"],run:function(a){var b=this.settings.margin||"",c=!this.settings.autoWidth,d=this.settings.rtl,e={width:"auto","margin-left":d?b:"","margin-right":d?"":b};!c&&this.$stage.children().css(e),a.css=e}},{filter:["width","items","settings"],run:function(a){var b=(this.width()/this.settings.items).toFixed(3)-this.settings.margin,c=null,d=this._items.length,e=!this.settings.autoWidth,f=[];for(a.items={merge:!1,width:b};d--;)c=this._mergers[d],c=this.settings.mergeFit&&Math.min(c,this.settings.items)||c,a.items.merge=c>1||a.items.merge,f[d]=e?b*c:this._items[d].width();this._widths=f}},{filter:["items","settings"],run:function(){var b=[],c=this._items,d=this.settings,e=Math.max(2*d.items,4),f=2*Math.ceil(c.length/2),g=d.loop&&c.length?d.rewind?e:Math.max(e,f):0,h="",i="";for(g/=2;g--;)b.push(this.normalize(b.length/2,!0)),h+=c[b[b.length-1]][0].outerHTML,b.push(this.normalize(c.length-1-(b.length-1)/2,!0)),i=c[b[b.length-1]][0].outerHTML+i;this._clones=b,a(h).addClass("cloned").appendTo(this.$stage),a(i).addClass("cloned").prependTo(this.$stage)}},{filter:["width","items","settings"],run:function(){for(var a=this.settings.rtl?1:-1,b=this._clones.length+this._items.length,c=-1,d=0,e=0,f=[];++c<b;)d=f[c-1]||0,e=this._widths[this.relative(c)]+this.settings.margin,f.push(d+e*a);this._coordinates=f}},{filter:["width","items","settings"],run:function(){var a=this.settings.stagePadding,b=this._coordinates,c={width:Math.ceil(Math.abs(b[b.length-1]))+2*a,"padding-left":a||"","padding-right":a||""};this.$stage.css(c)}},{filter:["width","items","settings"],run:function(a){var b=this._coordinates.length,c=!this.settings.autoWidth,d=this.$stage.children();if(c&&a.items.merge)for(;b--;)a.css.width=this._widths[this.relative(b)],d.eq(b).css(a.css);else c&&(a.css.width=a.items.width,d.css(a.css))}},{filter:["items"],run:function(){this._coordinates.length<1&&this.$stage.removeAttr("style")}},{filter:["width","items","settings"],run:function(a){a.current=a.current?this.$stage.children().index(a.current):0,a.current=Math.max(this.minimum(),Math.min(this.maximum(),a.current)),this.reset(a.current)}},{filter:["position"],run:function(){this.animate(this.coordinates(this._current))}},{filter:["width","position","items","settings"],run:function(){var a,b,c,d,e=this.settings.rtl?1:-1,f=2*this.settings.stagePadding,g=this.coordinates(this.current())+f,h=g+this.width()*e,i=[];for(c=0,d=this._coordinates.length;c<d;c++)a=this._coordinates[c-1]||0,b=Math.abs(this._coordinates[c])+f*e,(this.op(a,"<=",g)&&this.op(a,">",h)||this.op(b,"<",g)&&this.op(b,">",h))&&i.push(c);this.$stage.children(".active").removeClass("active"),this.$stage.children(":eq("+i.join("), :eq(")+")").addClass("active"),this.settings.center&&(this.$stage.children(".center").removeClass("center"),this.$stage.children().eq(this.current()).addClass("center"))}}],e.prototype.initialize=function(){if(this.enter("initializing"),this.trigger("initialize"),this.$element.toggleClass(this.settings.rtlClass,this.settings.rtl),this.settings.autoWidth&&!this.is("pre-loading")){var b,c,e;b=this.$element.find("img"),c=this.settings.nestedItemSelector?"."+this.settings.nestedItemSelector:d,e=this.$element.children(c).width(),b.length&&e<=0&&this.preloadAutoWidthImages(b)}this.$element.addClass(this.options.loadingClass),this.$stage=a("<"+this.settings.stageElement+' class="'+this.settings.stageClass+'"/>').wrap('<div class="'+this.settings.stageOuterClass+'"/>'),this.$element.append(this.$stage.parent()),this.replace(this.$element.children().not(this.$stage.parent())),this.$element.is(":visible")?this.refresh():this.invalidate("width"),this.$element.removeClass(this.options.loadingClass).addClass(this.options.loadedClass),this.registerEventHandlers(),this.leave("initializing"),this.trigger("initialized")},e.prototype.setup=function(){var b=this.viewport(),c=this.options.responsive,d=-1,e=null;c?(a.each(c,function(a){a<=b&&a>d&&(d=Number(a))}),e=a.extend({},this.options,c[d]),"function"==typeof e.stagePadding&&(e.stagePadding=e.stagePadding()),delete e.responsive,e.responsiveClass&&this.$element.attr("class",this.$element.attr("class").replace(new RegExp("("+this.options.responsiveClass+"-)\\S+\\s","g"),"$1"+d))):e=a.extend({},this.options),this.trigger("change",{property:{name:"settings",value:e}}),this._breakpoint=d,this.settings=e,this.invalidate("settings"),this.trigger("changed",{property:{name:"settings",value:this.settings}})},e.prototype.optionsLogic=function(){this.settings.autoWidth&&(this.settings.stagePadding=!1,this.settings.merge=!1)},e.prototype.prepare=function(b){var c=this.trigger("prepare",{content:b});return c.data||(c.data=a("<"+this.settings.itemElement+"/>").addClass(this.options.itemClass).append(b)),this.trigger("prepared",{content:c.data}),c.data},e.prototype.update=function(){for(var b=0,c=this._pipe.length,d=a.proxy(function(a){return this[a]},this._invalidated),e={};b<c;)(this._invalidated.all||a.grep(this._pipe[b].filter,d).length>0)&&this._pipe[b].run(e),b++;this._invalidated={},!this.is("valid")&&this.enter("valid")},e.prototype.width=function(a){switch(a=a||e.Width.Default){case e.Width.Inner:case e.Width.Outer:return this._width;default:return this._width-2*this.settings.stagePadding+this.settings.margin}},e.prototype.refresh=function(){this.enter("refreshing"),this.trigger("refresh"),this.setup(),this.optionsLogic(),this.$element.addClass(this.options.refreshClass),this.update(),this.$element.removeClass(this.options.refreshClass),this.leave("refreshing"),this.trigger("refreshed")},e.prototype.onThrottledResize=function(){b.clearTimeout(this.resizeTimer),this.resizeTimer=b.setTimeout(this._handlers.onResize,this.settings.responsiveRefreshRate)},e.prototype.onResize=function(){return!!this._items.length&&(this._width!==this.$element.width()&&(!!this.$element.is(":visible")&&(this.enter("resizing"),this.trigger("resize").isDefaultPrevented()?(this.leave("resizing"),!1):(this.invalidate("width"),this.refresh(),this.leave("resizing"),void this.trigger("resized")))))},e.prototype.registerEventHandlers=function(){a.support.transition&&this.$stage.on(a.support.transition.end+".owl.core",a.proxy(this.onTransitionEnd,this)),this.settings.responsive!==!1&&this.on(b,"resize",this._handlers.onThrottledResize),this.settings.mouseDrag&&(this.$element.addClass(this.options.dragClass),this.$stage.on("mousedown.owl.core",a.proxy(this.onDragStart,this)),this.$stage.on("dragstart.owl.core selectstart.owl.core",function(){return!1})),this.settings.touchDrag&&(this.$stage.on("touchstart.owl.core",a.proxy(this.onDragStart,this)),this.$stage.on("touchcancel.owl.core",a.proxy(this.onDragEnd,this)))},e.prototype.onDragStart=function(b){var d=null;3!==b.which&&(a.support.transform?(d=this.$stage.css("transform").replace(/.*\(|\)| /g,"").split(","),d={x:d[16===d.length?12:4],y:d[16===d.length?13:5]}):(d=this.$stage.position(),d={x:this.settings.rtl?d.left+this.$stage.width()-this.width()+this.settings.margin:d.left,y:d.top}),this.is("animating")&&(a.support.transform?this.animate(d.x):this.$stage.stop(),this.invalidate("position")),this.$element.toggleClass(this.options.grabClass,"mousedown"===b.type),this.speed(0),this._drag.time=(new Date).getTime(),this._drag.target=a(b.target),this._drag.stage.start=d,this._drag.stage.current=d,this._drag.pointer=this.pointer(b),a(c).on("mouseup.owl.core touchend.owl.core",a.proxy(this.onDragEnd,this)),a(c).one("mousemove.owl.core touchmove.owl.core",a.proxy(function(b){var d=this.difference(this._drag.pointer,this.pointer(b));a(c).on("mousemove.owl.core touchmove.owl.core",a.proxy(this.onDragMove,this)),Math.abs(d.x)<Math.abs(d.y)&&this.is("valid")||(b.preventDefault(),this.enter("dragging"),this.trigger("drag"))},this)))},e.prototype.onDragMove=function(a){var b=null,c=null,d=null,e=this.difference(this._drag.pointer,this.pointer(a)),f=this.difference(this._drag.stage.start,e);this.is("dragging")&&(a.preventDefault(),this.settings.loop?(b=this.coordinates(this.minimum()),c=this.coordinates(this.maximum()+1)-b,f.x=((f.x-b)%c+c)%c+b):(b=this.settings.rtl?this.coordinates(this.maximum()):this.coordinates(this.minimum()),c=this.settings.rtl?this.coordinates(this.minimum()):this.coordinates(this.maximum()),d=this.settings.pullDrag?-1*e.x/5:0,f.x=Math.max(Math.min(f.x,b+d),c+d)),this._drag.stage.current=f,this.animate(f.x))},e.prototype.onDragEnd=function(b){var d=this.difference(this._drag.pointer,this.pointer(b)),e=this._drag.stage.current,f=d.x>0^this.settings.rtl?"left":"right";a(c).off(".owl.core"),this.$element.removeClass(this.options.grabClass),(0!==d.x&&this.is("dragging")||!this.is("valid"))&&(this.speed(this.settings.dragEndSpeed||this.settings.smartSpeed),this.current(this.closest(e.x,0!==d.x?f:this._drag.direction)),this.invalidate("position"),this.update(),this._drag.direction=f,(Math.abs(d.x)>3||(new Date).getTime()-this._drag.time>300)&&this._drag.target.one("click.owl.core",function(){return!1})),this.is("dragging")&&(this.leave("dragging"),this.trigger("dragged"))},e.prototype.closest=function(b,c){var d=-1,e=30,f=this.width(),g=this.coordinates();return this.settings.freeDrag||a.each(g,a.proxy(function(a,h){return"left"===c&&b>h-e&&b<h+e?d=a:"right"===c&&b>h-f-e&&b<h-f+e?d=a+1:this.op(b,"<",h)&&this.op(b,">",g[a+1]||h-f)&&(d="left"===c?a+1:a),d===-1},this)),this.settings.loop||(this.op(b,">",g[this.minimum()])?d=b=this.minimum():this.op(b,"<",g[this.maximum()])&&(d=b=this.maximum())),d},e.prototype.animate=function(b){var c=this.speed()>0;this.is("animating")&&this.onTransitionEnd(),c&&(this.enter("animating"),this.trigger("translate")),a.support.transform3d&&a.support.transition?this.$stage.css({transform:"translate3d("+b+"px,0px,0px)",transition:this.speed()/1e3+"s"}):c?this.$stage.animate({left:b+"px"},this.speed(),this.settings.fallbackEasing,a.proxy(this.onTransitionEnd,this)):this.$stage.css({left:b+"px"})},e.prototype.is=function(a){return this._states.current[a]&&this._states.current[a]>0},e.prototype.current=function(a){if(a===d)return this._current;if(0===this._items.length)return d;if(a=this.normalize(a),this._current!==a){var b=this.trigger("change",{property:{name:"position",value:a}});b.data!==d&&(a=this.normalize(b.data)),this._current=a,this.invalidate("position"),this.trigger("changed",{property:{name:"position",value:this._current}})}return this._current},e.prototype.invalidate=function(b){return"string"===a.type(b)&&(this._invalidated[b]=!0,this.is("valid")&&this.leave("valid")),a.map(this._invalidated,function(a,b){return b})},e.prototype.reset=function(a){a=this.normalize(a),a!==d&&(this._speed=0,this._current=a,this.suppress(["translate","translated"]),this.animate(this.coordinates(a)),this.release(["translate","translated"]))},e.prototype.normalize=function(a,b){var c=this._items.length,e=b?0:this._clones.length;return!this.isNumeric(a)||c<1?a=d:(a<0||a>=c+e)&&(a=((a-e/2)%c+c)%c+e/2),a},e.prototype.relative=function(a){return a-=this._clones.length/2,this.normalize(a,!0)},e.prototype.maximum=function(a){var b,c,d,e=this.settings,f=this._coordinates.length;if(e.loop)f=this._clones.length/2+this._items.length-1;else if(e.autoWidth||e.merge){for(b=this._items.length,c=this._items[--b].width(),d=this.$element.width();b--&&(c+=this._items[b].width()+this.settings.margin,!(c>d)););f=b+1}else f=e.center?this._items.length-1:this._items.length-e.items;return a&&(f-=this._clones.length/2),Math.max(f,0)},e.prototype.minimum=function(a){return a?0:this._clones.length/2},e.prototype.items=function(a){return a===d?this._items.slice():(a=this.normalize(a,!0),this._items[a])},e.prototype.mergers=function(a){return a===d?this._mergers.slice():(a=this.normalize(a,!0),this._mergers[a])},e.prototype.clones=function(b){var c=this._clones.length/2,e=c+this._items.length,f=function(a){return a%2===0?e+a/2:c-(a+1)/2};return b===d?a.map(this._clones,function(a,b){return f(b)}):a.map(this._clones,function(a,c){return a===b?f(c):null})},e.prototype.speed=function(a){return a!==d&&(this._speed=a),this._speed},e.prototype.coordinates=function(b){var c,e=1,f=b-1;return b===d?a.map(this._coordinates,a.proxy(function(a,b){return this.coordinates(b)},this)):(this.settings.center?(this.settings.rtl&&(e=-1,f=b+1),c=this._coordinates[b],c+=(this.width()-c+(this._coordinates[f]||0))/2*e):c=this._coordinates[f]||0,c=Math.ceil(c))},e.prototype.duration=function(a,b,c){return 0===c?0:Math.min(Math.max(Math.abs(b-a),1),6)*Math.abs(c||this.settings.smartSpeed)},e.prototype.to=function(a,b){var c=this.current(),d=null,e=a-this.relative(c),f=(e>0)-(e<0),g=this._items.length,h=this.minimum(),i=this.maximum();this.settings.loop?(!this.settings.rewind&&Math.abs(e)>g/2&&(e+=f*-1*g),a=c+e,d=((a-h)%g+g)%g+h,d!==a&&d-e<=i&&d-e>0&&(c=d-e,a=d,this.reset(c))):this.settings.rewind?(i+=1,a=(a%i+i)%i):a=Math.max(h,Math.min(i,a)),this.speed(this.duration(c,a,b)),this.current(a),this.$element.is(":visible")&&this.update()},e.prototype.next=function(a){a=a||!1,this.to(this.relative(this.current())+1,a)},e.prototype.prev=function(a){a=a||!1,this.to(this.relative(this.current())-1,a)},e.prototype.onTransitionEnd=function(a){if(a!==d&&(a.stopPropagation(),(a.target||a.srcElement||a.originalTarget)!==this.$stage.get(0)))return!1;this.leave("animating"),this.trigger("translated")},e.prototype.viewport=function(){var d;return this.options.responsiveBaseElement!==b?d=a(this.options.responsiveBaseElement).width():b.innerWidth?d=b.innerWidth:c.documentElement&&c.documentElement.clientWidth?d=c.documentElement.clientWidth:console.warn("Can not detect viewport width."),d},e.prototype.replace=function(b){this.$stage.empty(),this._items=[],b&&(b=b instanceof jQuery?b:a(b)),this.settings.nestedItemSelector&&(b=b.find("."+this.settings.nestedItemSelector)),b.filter(function(){return 1===this.nodeType}).each(a.proxy(function(a,b){b=this.prepare(b),this.$stage.append(b),this._items.push(b),this._mergers.push(1*b.find("[data-merge]").addBack("[data-merge]").attr("data-merge")||1)},this)),this.reset(this.isNumeric(this.settings.startPosition)?this.settings.startPosition:0),this.invalidate("items")},e.prototype.add=function(b,c){var e=this.relative(this._current);c=c===d?this._items.length:this.normalize(c,!0),b=b instanceof jQuery?b:a(b),this.trigger("add",{content:b,position:c}),b=this.prepare(b),0===this._items.length||c===this._items.length?(0===this._items.length&&this.$stage.append(b),0!==this._items.length&&this._items[c-1].after(b),this._items.push(b),this._mergers.push(1*b.find("[data-merge]").addBack("[data-merge]").attr("data-merge")||1)):(this._items[c].before(b),this._items.splice(c,0,b),this._mergers.splice(c,0,1*b.find("[data-merge]").addBack("[data-merge]").attr("data-merge")||1)),this._items[e]&&this.reset(this._items[e].index()),this.invalidate("items"),this.trigger("added",{content:b,position:c})},e.prototype.remove=function(a){a=this.normalize(a,!0),a!==d&&(this.trigger("remove",{content:this._items[a],position:a}),this._items[a].remove(),this._items.splice(a,1),this._mergers.splice(a,1),this.invalidate("items"),this.trigger("removed",{content:null,position:a}))},e.prototype.preloadAutoWidthImages=function(b){b.each(a.proxy(function(b,c){this.enter("pre-loading"),c=a(c),a(new Image).one("load",a.proxy(function(a){c.attr("src",a.target.src),c.css("opacity",1),this.leave("pre-loading"),!this.is("pre-loading")&&!this.is("initializing")&&this.refresh()},this)).attr("src",c.attr("src")||c.attr("data-src")||c.attr("data-src-retina"))},this))},e.prototype.destroy=function(){this.$element.off(".owl.core"),this.$stage.off(".owl.core"),a(c).off(".owl.core"),this.settings.responsive!==!1&&(b.clearTimeout(this.resizeTimer),this.off(b,"resize",this._handlers.onThrottledResize));for(var d in this._plugins)this._plugins[d].destroy();this.$stage.children(".cloned").remove(),this.$stage.unwrap(),this.$stage.children().contents().unwrap(),this.$stage.children().unwrap(),this.$element.removeClass(this.options.refreshClass).removeClass(this.options.loadingClass).removeClass(this.options.loadedClass).removeClass(this.options.rtlClass).removeClass(this.options.dragClass).removeClass(this.options.grabClass).attr("class",this.$element.attr("class").replace(new RegExp(this.options.responsiveClass+"-\\S+\\s","g"),"")).removeData("owl.carousel")},e.prototype.op=function(a,b,c){var d=this.settings.rtl;switch(b){case"<":return d?a>c:a<c;case">":return d?a<c:a>c;case">=":return d?a<=c:a>=c;case"<=":return d?a>=c:a<=c}},e.prototype.on=function(a,b,c,d){a.addEventListener?a.addEventListener(b,c,d):a.attachEvent&&a.attachEvent("on"+b,c)},e.prototype.off=function(a,b,c,d){a.removeEventListener?a.removeEventListener(b,c,d):a.detachEvent&&a.detachEvent("on"+b,c)},e.prototype.trigger=function(b,c,d,f,g){var h={item:{count:this._items.length,index:this.current()}},i=a.camelCase(a.grep(["on",b,d],function(a){return a}).join("-").toLowerCase()),j=a.Event([b,"owl",d||"carousel"].join(".").toLowerCase(),a.extend({relatedTarget:this},h,c));return this._supress[b]||(a.each(this._plugins,function(a,b){b.onTrigger&&b.onTrigger(j)}),this.register({type:e.Type.Event,name:b}),this.$element.trigger(j),this.settings&&"function"==typeof this.settings[i]&&this.settings[i].call(this,j)),j},e.prototype.enter=function(b){a.each([b].concat(this._states.tags[b]||[]),a.proxy(function(a,b){this._states.current[b]===d&&(this._states.current[b]=0),this._states.current[b]++},this))},e.prototype.leave=function(b){a.each([b].concat(this._states.tags[b]||[]),a.proxy(function(a,b){this._states.current[b]--},this))},e.prototype.register=function(b){if(b.type===e.Type.Event){if(a.event.special[b.name]||(a.event.special[b.name]={}),!a.event.special[b.name].owl){var c=a.event.special[b.name]._default;a.event.special[b.name]._default=function(a){return!c||!c.apply||a.namespace&&a.namespace.indexOf("owl")!==-1?a.namespace&&a.namespace.indexOf("owl")>-1:c.apply(this,arguments)},a.event.special[b.name].owl=!0}}else b.type===e.Type.State&&(this._states.tags[b.name]?this._states.tags[b.name]=this._states.tags[b.name].concat(b.tags):this._states.tags[b.name]=b.tags,this._states.tags[b.name]=a.grep(this._states.tags[b.name],a.proxy(function(c,d){return a.inArray(c,this._states.tags[b.name])===d},this)))},e.prototype.suppress=function(b){a.each(b,a.proxy(function(a,b){this._supress[b]=!0},this))},e.prototype.release=function(b){a.each(b,a.proxy(function(a,b){delete this._supress[b]},this))},e.prototype.pointer=function(a){var c={x:null,y:null};return a=a.originalEvent||a||b.event,a=a.touches&&a.touches.length?a.touches[0]:a.changedTouches&&a.changedTouches.length?a.changedTouches[0]:a,a.pageX?(c.x=a.pageX,c.y=a.pageY):(c.x=a.clientX,c.y=a.clientY),c},e.prototype.isNumeric=function(a){return!isNaN(parseFloat(a))},e.prototype.difference=function(a,b){return{x:a.x-b.x,y:a.y-b.y}},a.fn.sbiOwlCarousel=function(b){var c=Array.prototype.slice.call(arguments,1);return this.each(function(){var d=a(this),f=d.data("owl.carousel");f||(f=new e(this,"object"==typeof b&&b),d.data("owl.carousel",f),a.each(["next","prev","to","destroy","refresh","replace","add","remove"],function(b,c){f.register({type:e.Type.Event,name:c}),f.$element.on(c+".owl.carousel.core",a.proxy(function(a){a.namespace&&a.relatedTarget!==this&&(this.suppress([c]),f[c].apply(this,[].slice.call(arguments,1)),this.release([c]))},f))})),"string"==typeof b&&"_"!==b.charAt(0)&&f[b].apply(f,c)})},a.fn.sbiOwlCarousel.Constructor=e}(window.Zepto||window.jQuery,window,document),function(a,b,c,d){var e=function(b){this._core=b,this._interval=null,this._visible=null,this._handlers={"initialized.owl.carousel":a.proxy(function(a){a.namespace&&this._core.settings.autoRefresh&&this.watch()},this)},this._core.options=a.extend({},e.Defaults,this._core.options),this._core.$element.on(this._handlers)};e.Defaults={autoRefresh:!0,autoRefreshInterval:500},e.prototype.watch=function(){this._interval||(this._visible=this._core.$element.is(":visible"),this._interval=b.setInterval(a.proxy(this.refresh,this),this._core.settings.autoRefreshInterval))},e.prototype.refresh=function(){this._core.$element.is(":visible")!==this._visible&&(this._visible=!this._visible,this._core.$element.toggleClass("sbi-owl-hidden",!this._visible),this._visible&&this._core.invalidate("width")&&this._core.refresh())},e.prototype.destroy=function(){var a,c;b.clearInterval(this._interval);for(a in this._handlers)this._core.$element.off(a,this._handlers[a]);for(c in Object.getOwnPropertyNames(this))"function"!=typeof this[c]&&(this[c]=null)},a.fn.sbiOwlCarousel.Constructor.Plugins.AutoRefresh=e}(window.Zepto||window.jQuery,window,document),function(a,b,c,d){var e=function(b){this._core=b,this._loaded=[],this._handlers={"initialized.owl.carousel change.owl.carousel resized.owl.carousel":a.proxy(function(b){if(b.namespace&&this._core.settings&&this._core.settings.lazyLoad&&(b.property&&"position"==b.property.name||"initialized"==b.type))for(var c=this._core.settings,e=c.center&&Math.ceil(c.items/2)||c.items,f=c.center&&e*-1||0,g=(b.property&&b.property.value!==d?b.property.value:this._core.current())+f,h=this._core.clones().length,i=a.proxy(function(a,b){this.load(b)},this);f++<e;)this.load(h/2+this._core.relative(g)),h&&a.each(this._core.clones(this._core.relative(g)),i),g++},this)},this._core.options=a.extend({},e.Defaults,this._core.options),this._core.$element.on(this._handlers)};e.Defaults={lazyLoad:!1},e.prototype.load=function(c){var d=this._core.$stage.children().eq(c),e=d&&d.find(".sbi-owl-lazy");!e||a.inArray(d.get(0),this._loaded)>-1||(e.each(a.proxy(function(c,d){var e,f=a(d),g=b.devicePixelRatio>1&&f.attr("data-src-retina")||f.attr("data-src");this._core.trigger("load",{element:f,url:g},"lazy"),f.is("img")?f.one("load.owl.lazy",a.proxy(function(){f.css("opacity",1),this._core.trigger("loaded",{element:f,url:g},"lazy")},this)).attr("src",g):(e=new Image,e.onload=a.proxy(function(){f.css({"background-image":'url("'+g+'")',opacity:"1"}),this._core.trigger("loaded",{element:f,url:g},"lazy")},this),e.src=g)},this)),this._loaded.push(d.get(0)))},e.prototype.destroy=function(){var a,b;for(a in this.handlers)this._core.$element.off(a,this.handlers[a]);for(b in Object.getOwnPropertyNames(this))"function"!=typeof this[b]&&(this[b]=null)},a.fn.sbiOwlCarousel.Constructor.Plugins.Lazy=e}(window.Zepto||window.jQuery,window,document),function(a,b,c,d){var e=function(b){this._core=b,this._handlers={"initialized.owl.carousel refreshed.owl.carousel":a.proxy(function(a){a.namespace&&this._core.settings.autoHeight&&this.update()},this),"changed.owl.carousel":a.proxy(function(a){a.namespace&&this._core.settings.autoHeight&&"position"==a.property.name&&this.update()},this),"loaded.owl.lazy":a.proxy(function(a){a.namespace&&this._core.settings.autoHeight&&a.element.closest("."+this._core.settings.itemClass).index()===this._core.current()&&this.update()},this)},this._core.options=a.extend({},e.Defaults,this._core.options),this._core.$element.on(this._handlers)};e.Defaults={autoHeight:!1,autoHeightClass:"sbi-owl-height"},e.prototype.update=function(){var b=this._core._current,c=b+this._core.settings.items,d=this._core.$stage.children().toArray().slice(b,c),e=[],f=0;a.each(d,function(b,c){e.push(a(c).height())}),f=Math.max.apply(null,e),this._core.$stage.parent().height(f).addClass(this._core.settings.autoHeightClass)},e.prototype.destroy=function(){var a,b;for(a in this._handlers)this._core.$element.off(a,this._handlers[a]);for(b in Object.getOwnPropertyNames(this))"function"!=typeof this[b]&&(this[b]=null)},a.fn.sbiOwlCarousel.Constructor.Plugins.AutoHeight=e}(window.Zepto||window.jQuery,window,document),function(a,b,c,d){var e=function(b){this._core=b,this._videos={},this._playing=null,this._handlers={"initialized.owl.carousel":a.proxy(function(a){a.namespace&&this._core.register({type:"state",name:"playing",tags:["interacting"]})},this),"resize.owl.carousel":a.proxy(function(a){a.namespace&&this._core.settings.video&&this.isInFullScreen()&&a.preventDefault()},this),"refreshed.owl.carousel":a.proxy(function(a){a.namespace&&this._core.is("resizing")&&this._core.$stage.find(".cloned .sbi-owl-video-frame").remove()},this),"changed.owl.carousel":a.proxy(function(a){a.namespace&&"position"===a.property.name&&this._playing&&this.stop()},this),"prepared.owl.carousel":a.proxy(function(b){if(b.namespace){var c=a(b.content).find(".sbi-owl-video");c.length&&(c.css("display","none"),this.fetch(c,a(b.content)))}},this)},this._core.options=a.extend({},e.Defaults,this._core.options),this._core.$element.on(this._handlers),this._core.$element.on("click.owl.video",".sbi-owl-video-play-icon",a.proxy(function(a){this.play(a)},this))};e.Defaults={video:!1,videoHeight:!1,videoWidth:!1},e.prototype.fetch=function(a,b){var c=function(){return a.attr("data-vimeo-id")?"vimeo":a.attr("data-vzaar-id")?"vzaar":"youtube"}(),d=a.attr("data-vimeo-id")||a.attr("data-youtube-id")||a.attr("data-vzaar-id"),e=a.attr("data-width")||this._core.settings.videoWidth,f=a.attr("data-height")||this._core.settings.videoHeight,g=a.attr("href");if(!g)throw new Error("Missing video URL.");if(d=g.match(/(http:|https:|)\/\/(player.|www.|app.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com)|vzaar\.com)\/(video\/|videos\/|embed\/|channels\/.+\/|groups\/.+\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/),d[3].indexOf("youtu")>-1)c="youtube";else if(d[3].indexOf("vimeo")>-1)c="vimeo";else{if(!(d[3].indexOf("vzaar")>-1))throw new Error("Video URL not supported.");c="vzaar"}d=d[6],this._videos[g]={type:c,id:d,width:e,height:f},b.attr("data-video",g),this.thumbnail(a,this._videos[g])},e.prototype.thumbnail=function(b,c){var d,e,f,g=c.width&&c.height?'style="width:'+c.width+"px;height:"+c.height+'px;"':"",h=b.find("img"),i="src",j="",k=this._core.settings,l=function(a){e='<div class="sbi-owl-video-play-icon"></div>',d=k.lazyLoad?'<div class="sbi-owl-video-tn '+j+'" '+i+'="'+a+'"></div>':'<div class="sbi-owl-video-tn" style="opacity:1;background-image:url('+a+')"></div>',b.after(d),b.after(e)};if(b.wrap('<div class="sbi-owl-video-wrapper"'+g+"></div>"),this._core.settings.lazyLoad&&(i="data-src",j="sbi-owl-lazy"),h.length)return l(h.attr(i)),h.remove(),!1;"youtube"===c.type?(f="//img.youtube.com/vi/"+c.id+"/hqdefault.jpg",l(f)):"vimeo"===c.type?a.ajax({type:"GET",url:"//vimeo.com/api/v2/video/"+c.id+".json",jsonp:"callback",dataType:"jsonp",success:function(a){f=a[0].thumbnail_large,l(f)}}):"vzaar"===c.type&&a.ajax({type:"GET",url:"//vzaar.com/api/videos/"+c.id+".json",jsonp:"callback",dataType:"jsonp",success:function(a){f=a.framegrab_url,l(f)}})},e.prototype.stop=function(){this._core.trigger("stop",null,"video"),this._playing.find(".sbi-owl-video-frame").remove(),this._playing.removeClass("sbi-owl-video-playing"),this._playing=null,this._core.leave("playing"),this._core.trigger("stopped",null,"video")},e.prototype.play=function(b){var c,d=a(b.target),e=d.closest("."+this._core.settings.itemClass),f=this._videos[e.attr("data-video")],g=f.width||"100%",h=f.height||this._core.$stage.height();this._playing||(this._core.enter("playing"),this._core.trigger("play",null,"video"),e=this._core.items(this._core.relative(e.index())),this._core.reset(e.index()),"youtube"===f.type?c='<iframe width="'+g+'" height="'+h+'" src="//www.youtube.com/embed/'+f.id+"?autoplay=1&rel=0&v="+f.id+'" frameborder="0" allowfullscreen></iframe>':"vimeo"===f.type?c='<iframe src="//player.vimeo.com/video/'+f.id+'?autoplay=1" width="'+g+'" height="'+h+'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>':"vzaar"===f.type&&(c='<iframe frameborder="0"height="'+h+'"width="'+g+'" allowfullscreen mozallowfullscreen webkitAllowFullScreen src="//view.vzaar.com/'+f.id+'/player?autoplay=true"></iframe>'),a('<div class="sbi-owl-video-frame">'+c+"</div>").insertAfter(e.find(".sbi-owl-video")),this._playing=e.addClass("sbi-owl-video-playing"))},e.prototype.isInFullScreen=function(){var b=c.fullscreenElement||c.mozFullScreenElement||c.webkitFullscreenElement;return b&&a(b).parent().hasClass("sbi-owl-video-frame")},e.prototype.destroy=function(){var a,b;this._core.$element.off("click.owl.video");for(a in this._handlers)this._core.$element.off(a,this._handlers[a]);for(b in Object.getOwnPropertyNames(this))"function"!=typeof this[b]&&(this[b]=null)},a.fn.sbiOwlCarousel.Constructor.Plugins.Video=e}(window.Zepto||window.jQuery,window,document),function(a,b,c,d){var e=function(b){this.core=b,this.core.options=a.extend({},e.Defaults,this.core.options),this.swapping=!0,this.previous=d,this.next=d,this.handlers={"change.owl.carousel":a.proxy(function(a){a.namespace&&"position"==a.property.name&&(this.previous=this.core.current(),this.next=a.property.value)},this),"drag.owl.carousel dragged.owl.carousel translated.owl.carousel":a.proxy(function(a){a.namespace&&(this.swapping="translated"==a.type)},this),"translate.owl.carousel":a.proxy(function(a){a.namespace&&this.swapping&&(this.core.options.animateOut||this.core.options.animateIn)&&this.swap()},this)},this.core.$element.on(this.handlers)};e.Defaults={animateOut:!1,animateIn:!1},e.prototype.swap=function(){if(1===this.core.settings.items&&a.support.animation&&a.support.transition){this.core.speed(0);var b,c=a.proxy(this.clear,this),d=this.core.$stage.children().eq(this.previous),e=this.core.$stage.children().eq(this.next),f=this.core.settings.animateIn,g=this.core.settings.animateOut;this.core.current()!==this.previous&&(g&&(b=this.core.coordinates(this.previous)-this.core.coordinates(this.next),d.one(a.support.animation.end,c).css({left:b+"px"}).addClass("animated sbi-owl-animated-out").addClass(g)),f&&e.one(a.support.animation.end,c).addClass("animated sbi-owl-animated-in").addClass(f))}},e.prototype.clear=function(b){a(b.target).css({left:""}).removeClass("animated sbi-owl-animated-out sbi-owl-animated-in").removeClass(this.core.settings.animateIn).removeClass(this.core.settings.animateOut),this.core.onTransitionEnd()},e.prototype.destroy=function(){var a,b;for(a in this.handlers)this.core.$element.off(a,this.handlers[a]);for(b in Object.getOwnPropertyNames(this))"function"!=typeof this[b]&&(this[b]=null)},
        a.fn.sbiOwlCarousel.Constructor.Plugins.Animate=e}(window.Zepto||window.jQuery,window,document),function(a,b,c,d){var e=function(b){this._core=b,this._timeout=null,this._paused=!1,this._handlers={"changed.owl.carousel":a.proxy(function(a){a.namespace&&"settings"===a.property.name?this._core.settings.autoplay?this.play():this.stop():a.namespace&&"position"===a.property.name&&this._core.settings.autoplay&&this._setAutoPlayInterval()},this),"initialized.owl.carousel":a.proxy(function(a){a.namespace&&this._core.settings.autoplay&&this.play()},this),"play.owl.autoplay":a.proxy(function(a,b,c){a.namespace&&this.play(b,c)},this),"stop.owl.autoplay":a.proxy(function(a){a.namespace&&this.stop()},this),"mouseover.owl.autoplay":a.proxy(function(){this._core.settings.autoplayHoverPause&&this._core.is("rotating")&&this.pause()},this),"mouseleave.owl.autoplay":a.proxy(function(){this._core.settings.autoplayHoverPause&&this._core.is("rotating")&&this.play()},this),"touchstart.owl.core":a.proxy(function(){this._core.settings.autoplayHoverPause&&this._core.is("rotating")&&this.pause()},this),"touchend.owl.core":a.proxy(function(){this._core.settings.autoplayHoverPause&&this.play()},this)},this._core.$element.on(this._handlers),this._core.options=a.extend({},e.Defaults,this._core.options)};e.Defaults={autoplay:!1,autoplayTimeout:5e3,autoplayHoverPause:!1,autoplaySpeed:!1},e.prototype.play=function(a,b){this._paused=!1,this._core.is("rotating")||(this._core.enter("rotating"),this._setAutoPlayInterval())},e.prototype._getNextTimeout=function(d,e){return this._timeout&&b.clearTimeout(this._timeout),b.setTimeout(a.proxy(function(){this._paused||this._core.is("busy")||this._core.is("interacting")||c.hidden||this._core.next(e||this._core.settings.autoplaySpeed)},this),d||this._core.settings.autoplayTimeout)},e.prototype._setAutoPlayInterval=function(){this._timeout=this._getNextTimeout()},e.prototype.stop=function(){this._core.is("rotating")&&(b.clearTimeout(this._timeout),this._core.leave("rotating"))},e.prototype.pause=function(){this._core.is("rotating")&&(this._paused=!0)},e.prototype.destroy=function(){var a,b;this.stop();for(a in this._handlers)this._core.$element.off(a,this._handlers[a]);for(b in Object.getOwnPropertyNames(this))"function"!=typeof this[b]&&(this[b]=null)},a.fn.sbiOwlCarousel.Constructor.Plugins.autoplay=e}(window.Zepto||window.jQuery,window,document),function(a,b,c,d){"use strict";var e=function(b){this._core=b,this._initialized=!1,this._pages=[],this._controls={},this._templates=[],this.$element=this._core.$element,this._overrides={next:this._core.next,prev:this._core.prev,to:this._core.to},this._handlers={"prepared.owl.carousel":a.proxy(function(b){b.namespace&&this._core.settings.dotsData&&this._templates.push('<div class="'+this._core.settings.dotClass+'">'+a(b.content).find("[data-dot]").addBack("[data-dot]").attr("data-dot")+"</div>")},this),"added.owl.carousel":a.proxy(function(a){a.namespace&&this._core.settings.dotsData&&this._templates.splice(a.position,0,this._templates.pop())},this),"remove.owl.carousel":a.proxy(function(a){a.namespace&&this._core.settings.dotsData&&this._templates.splice(a.position,1)},this),"changed.owl.carousel":a.proxy(function(a){a.namespace&&"position"==a.property.name&&this.draw()},this),"initialized.owl.carousel":a.proxy(function(a){a.namespace&&!this._initialized&&(this._core.trigger("initialize",null,"navigation"),this.initialize(),this.update(),this.draw(),this._initialized=!0,this._core.trigger("initialized",null,"navigation"))},this),"refreshed.owl.carousel":a.proxy(function(a){a.namespace&&this._initialized&&(this._core.trigger("refresh",null,"navigation"),this.update(),this.draw(),this._core.trigger("refreshed",null,"navigation"))},this)},this._core.options=a.extend({},e.Defaults,this._core.options),this.$element.on(this._handlers)};e.Defaults={nav:!1,navText:["prev","next"],navSpeed:!1,navElement:"div",navContainer:!1,navContainerClass:"sbi-owl-nav",navClass:["sbi-owl-prev","sbi-owl-next"],slideBy:1,dotClass:"sbi-owl-dot",dotsClass:"sbi-owl-dots",dots:!0,dotsEach:!1,dotsData:!1,dotsSpeed:!1,dotsContainer:!1},e.prototype.initialize=function(){var b,c=this._core.settings;this._controls.$relative=(c.navContainer?a(c.navContainer):a("<div>").addClass(c.navContainerClass).appendTo(this.$element)).addClass("disabled"),this._controls.$previous=a("<"+c.navElement+">").addClass(c.navClass[0]).html(c.navText[0]).prependTo(this._controls.$relative).on("click",a.proxy(function(a){this.prev(c.navSpeed)},this)),this._controls.$next=a("<"+c.navElement+">").addClass(c.navClass[1]).html(c.navText[1]).appendTo(this._controls.$relative).on("click",a.proxy(function(a){this.next(c.navSpeed)},this)),c.dotsData||(this._templates=[a("<div>").addClass(c.dotClass).append(a("<span>")).prop("outerHTML")]),this._controls.$absolute=(c.dotsContainer?a(c.dotsContainer):a("<div>").addClass(c.dotsClass).appendTo(this.$element)).addClass("disabled"),this._controls.$absolute.on("click","div",a.proxy(function(b){var d=a(b.target).parent().is(this._controls.$absolute)?a(b.target).index():a(b.target).parent().index();b.preventDefault(),this.to(d,c.dotsSpeed)},this));for(b in this._overrides)this._core[b]=a.proxy(this[b],this)},e.prototype.destroy=function(){var a,b,c,d;for(a in this._handlers)this.$element.off(a,this._handlers[a]);for(b in this._controls)this._controls[b].remove();for(d in this.overides)this._core[d]=this._overrides[d];for(c in Object.getOwnPropertyNames(this))"function"!=typeof this[c]&&(this[c]=null)},e.prototype.update=function(){var a,b,c,d=this._core.clones().length/2,e=d+this._core.items().length,f=this._core.maximum(!0),g=this._core.settings,h=g.center||g.autoWidth||g.dotsData?1:g.dotsEach||g.items;if("page"!==g.slideBy&&(g.slideBy=Math.min(g.slideBy,g.items)),g.dots||"page"==g.slideBy)for(this._pages=[],a=d,b=0,c=0;a<e;a++){if(b>=h||0===b){if(this._pages.push({start:Math.min(f,a-d),end:a-d+h-1}),Math.min(f,a-d)===f)break;b=0,++c}b+=this._core.mergers(this._core.relative(a))}},e.prototype.draw=function(){var b,c=this._core.settings,d=this._core.items().length<=c.items,e=this._core.relative(this._core.current()),f=c.loop||c.rewind;this._controls.$relative.toggleClass("disabled",!c.nav||d),c.nav&&(this._controls.$previous.toggleClass("disabled",!f&&e<=this._core.minimum(!0)),this._controls.$next.toggleClass("disabled",!f&&e>=this._core.maximum(!0))),this._controls.$absolute.toggleClass("disabled",!c.dots||d),c.dots&&(b=this._pages.length-this._controls.$absolute.children().length,c.dotsData&&0!==b?this._controls.$absolute.html(this._templates.join("")):b>0?this._controls.$absolute.append(new Array(b+1).join(this._templates[0])):b<0&&this._controls.$absolute.children().slice(b).remove(),this._controls.$absolute.find(".active").removeClass("active"),this._controls.$absolute.children().eq(a.inArray(this.current(),this._pages)).addClass("active"))},e.prototype.onTrigger=function(b){var c=this._core.settings;b.page={index:a.inArray(this.current(),this._pages),count:this._pages.length,size:c&&(c.center||c.autoWidth||c.dotsData?1:c.dotsEach||c.items)}},e.prototype.current=function(){var b=this._core.relative(this._core.current());return a.grep(this._pages,a.proxy(function(a,c){return a.start<=b&&a.end>=b},this)).pop()},e.prototype.getPosition=function(b){var c,d,e=this._core.settings;return"page"==e.slideBy?(c=a.inArray(this.current(),this._pages),d=this._pages.length,b?++c:--c,c=this._pages[(c%d+d)%d].start):(c=this._core.relative(this._core.current()),d=this._core.items().length,b?c+=e.slideBy:c-=e.slideBy),c},e.prototype.next=function(b){a.proxy(this._overrides.to,this._core)(this.getPosition(!0),b)},e.prototype.prev=function(b){a.proxy(this._overrides.to,this._core)(this.getPosition(!1),b)},e.prototype.to=function(b,c,d){var e;!d&&this._pages.length?(e=this._pages.length,a.proxy(this._overrides.to,this._core)(this._pages[(b%e+e)%e].start,c)):a.proxy(this._overrides.to,this._core)(b,c)},a.fn.sbiOwlCarousel.Constructor.Plugins.Navigation=e}(window.Zepto||window.jQuery,window,document),function(a,b,c,d){"use strict";var e=function(c){this._core=c,this._hashes={},this.$element=this._core.$element,this._handlers={"initialized.owl.carousel":a.proxy(function(c){c.namespace&&"URLHash"===this._core.settings.startPosition&&a(b).trigger("hashchange.owl.navigation")},this),"prepared.owl.carousel":a.proxy(function(b){if(b.namespace){var c=a(b.content).find("[data-hash]").addBack("[data-hash]").attr("data-hash");if(!c)return;this._hashes[c]=b.content}},this),"changed.owl.carousel":a.proxy(function(c){if(c.namespace&&"position"===c.property.name){var d=this._core.items(this._core.relative(this._core.current())),e=a.map(this._hashes,function(a,b){return a===d?b:null}).join();if(!e||b.location.hash.slice(1)===e)return;b.location.hash=e}},this)},this._core.options=a.extend({},e.Defaults,this._core.options),this.$element.on(this._handlers),a(b).on("hashchange.owl.navigation",a.proxy(function(a){var c=b.location.hash.substring(1),e=this._core.$stage.children(),f=this._hashes[c]&&e.index(this._hashes[c]);f!==d&&f!==this._core.current()&&this._core.to(this._core.relative(f),!1,!0)},this))};e.Defaults={URLhashListener:!1},e.prototype.destroy=function(){var c,d;a(b).off("hashchange.owl.navigation");for(c in this._handlers)this._core.$element.off(c,this._handlers[c]);for(d in Object.getOwnPropertyNames(this))"function"!=typeof this[d]&&(this[d]=null)},a.fn.sbiOwlCarousel.Constructor.Plugins.Hash=e}(window.Zepto||window.jQuery,window,document),function(a,b,c,d){function e(b,c){var e=!1,f=b.charAt(0).toUpperCase()+b.slice(1);return a.each((b+" "+h.join(f+" ")+f).split(" "),function(a,b){if(g[b]!==d)return e=!c||b,!1}),e}function f(a){return e(a,!0)}var g=a("<support>").get(0).style,h="Webkit Moz O ms".split(" "),i={transition:{end:{WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd",transition:"transitionend"}},animation:{end:{WebkitAnimation:"webkitAnimationEnd",MozAnimation:"animationend",OAnimation:"oAnimationEnd",animation:"animationend"}}},j={csstransforms:function(){return!!e("transform")},csstransforms3d:function(){return!!e("perspective")},csstransitions:function(){return!!e("transition")},cssanimations:function(){return!!e("animation")}};j.csstransitions()&&(a.support.transition=new String(f("transition")),a.support.transition.end=i.transition.end[a.support.transition]),j.cssanimations()&&(a.support.animation=new String(f("animation")),a.support.animation.end=i.animation.end[a.support.animation]),j.csstransforms()&&(a.support.transform=new String(f("transform")),a.support.transform3d=j.csstransforms3d())}(window.Zepto||window.jQuery,window,document);

    !function(a,b){"function"==typeof define&&define.amd?define("packery/js/rect",b):"object"==typeof module&&module.exports?module.exports=b():(a.Packery=a.Packery||{},a.Packery.Rect=b())}(window,function(){function a(b){for(var c in a.defaults)this[c]=a.defaults[c];for(c in b)this[c]=b[c]}a.defaults={x:0,y:0,width:0,height:0};var b=a.prototype;return b.contains=function(a){var b=a.width||0,c=a.height||0;return this.x<=a.x&&this.y<=a.y&&this.x+this.width>=a.x+b&&this.y+this.height>=a.y+c},b.overlaps=function(a){var b=this.x+this.width,c=this.y+this.height,d=a.x+a.width,e=a.y+a.height;return this.x<d&&b>a.x&&this.y<e&&c>a.y},b.getMaximalFreeRects=function(b){if(!this.overlaps(b))return!1;var c,d=[],e=this.x+this.width,f=this.y+this.height,g=b.x+b.width,h=b.y+b.height;return this.y<b.y&&(c=new a({x:this.x,y:this.y,width:this.width,height:b.y-this.y}),d.push(c)),e>g&&(c=new a({x:g,y:this.y,width:e-g,height:this.height}),d.push(c)),f>h&&(c=new a({x:this.x,y:h,width:this.width,height:f-h}),d.push(c)),this.x<b.x&&(c=new a({x:this.x,y:this.y,width:b.x-this.x,height:this.height}),d.push(c)),d},b.canFit=function(a){return this.width>=a.width&&this.height>=a.height},a}),function(a,b){if("function"==typeof define&&define.amd)define("packery/js/packer",["./rect"],b);else if("object"==typeof module&&module.exports)module.exports=b(require("./rect"));else{var c=a.Packery=a.Packery||{};c.Packer=b(c.Rect)}}(window,function(a){function b(a,b,c){this.width=a||0,this.height=b||0,this.sortDirection=c||"downwardLeftToRight",this.reset()}var c=b.prototype;c.reset=function(){this.spaces=[];var b=new a({x:0,y:0,width:this.width,height:this.height});this.spaces.push(b),this.sorter=d[this.sortDirection]||d.downwardLeftToRight},c.pack=function(a){for(var b=0;b<this.spaces.length;b++){var c=this.spaces[b];if(c.canFit(a)){this.placeInSpace(a,c);break}}},c.columnPack=function(a){for(var b=0;b<this.spaces.length;b++){var c=this.spaces[b],d=c.x<=a.x&&c.x+c.width>=a.x+a.width&&c.height>=a.height-.01;if(d){a.y=c.y,this.placed(a);break}}},c.rowPack=function(a){for(var b=0;b<this.spaces.length;b++){var c=this.spaces[b],d=c.y<=a.y&&c.y+c.height>=a.y+a.height&&c.width>=a.width-.01;if(d){a.x=c.x,this.placed(a);break}}},c.placeInSpace=function(a,b){a.x=b.x,a.y=b.y,this.placed(a)},c.placed=function(a){for(var b=[],c=0;c<this.spaces.length;c++){var d=this.spaces[c],e=d.getMaximalFreeRects(a);e?b.push.apply(b,e):b.push(d)}this.spaces=b,this.mergeSortSpaces()},c.mergeSortSpaces=function(){b.mergeRects(this.spaces),this.spaces.sort(this.sorter)},c.addSpace=function(a){this.spaces.push(a),this.mergeSortSpaces()},b.mergeRects=function(a){var b=0,c=a[b];a:for(;c;){for(var d=0,e=a[b+d];e;){if(e==c)d++;else{if(e.contains(c)){a.splice(b,1),c=a[b];continue a}c.contains(e)?a.splice(b+d,1):d++}e=a[b+d]}b++,c=a[b]}return a};var d={downwardLeftToRight:function(a,b){return a.y-b.y||a.x-b.x},rightwardTopToBottom:function(a,b){return a.x-b.x||a.y-b.y}};return b}),function(a,b){"function"==typeof define&&define.amd?define("packery/js/item",["outlayer/outlayer","./rect"],b):"object"==typeof module&&module.exports?module.exports=b(require("outlayer"),require("./rect")):a.Packery.Item=b(a.Outlayer,a.Packery.Rect)}(window,function(a,b){var c=document.documentElement.style,d="string"==typeof c.transform?"transform":"WebkitTransform",e=function(){a.Item.apply(this,arguments)},f=e.prototype=Object.create(a.Item.prototype),g=f._create;f._create=function(){g.call(this),this.rect=new b};var h=f.moveTo;return f.moveTo=function(a,b){var c=Math.abs(this.position.x-a),d=Math.abs(this.position.y-b),e=this.layout.dragItemCount&&!this.isPlacing&&!this.isTransitioning&&1>c&&1>d;return e?void this.goTo(a,b):void h.apply(this,arguments)},f.enablePlacing=function(){this.removeTransitionStyles(),this.isTransitioning&&d&&(this.element.style[d]="none"),this.isTransitioning=!1,this.getSize(),this.layout._setRectSize(this.element,this.rect),this.isPlacing=!0},f.disablePlacing=function(){this.isPlacing=!1},f.removeElem=function(){this.element.parentNode.removeChild(this.element),this.layout.packer.addSpace(this.rect),this.emitEvent("remove",[this])},f.showDropPlaceholder=function(){var a=this.dropPlaceholder;a||(a=this.dropPlaceholder=document.createElement("div"),a.className="packery-drop-placeholder",a.style.position="absolute"),a.style.width=this.size.width+"px",a.style.height=this.size.height+"px",this.positionDropPlaceholder(),this.layout.element.appendChild(a)},f.positionDropPlaceholder=function(){this.dropPlaceholder.style[d]="translate("+this.rect.x+"px, "+this.rect.y+"px)"},f.hideDropPlaceholder=function(){this.layout.element.removeChild(this.dropPlaceholder)},e}),function(a,b){"function"==typeof define&&define.amd?define("packery/js/packery",["get-size/get-size","outlayer/outlayer","./rect","./packer","./item"],b):"object"==typeof module&&module.exports?module.exports=b(require("get-size"),require("outlayer"),require("./rect"),require("./packer"),require("./item")):a.Packery=b(a.getSize,a.Outlayer,a.Packery.Rect,a.Packery.Packer,a.Packery.Item)}(window,function(a,b,c,d,e){function f(a,b){return a.position.y-b.position.y||a.position.x-b.position.x}function g(a,b){return a.position.x-b.position.x||a.position.y-b.position.y}function h(a,b){var c=b.x-a.x,d=b.y-a.y;return Math.sqrt(c*c+d*d)}c.prototype.canFit=function(a){return this.width>=a.width-1&&this.height>=a.height-1};var i=b.create("packery");i.Item=e;var j=i.prototype;j._create=function(){b.prototype._create.call(this),this.packer=new d,this.shiftPacker=new d,this.isEnabled=!0,this.dragItemCount=0;var a=this;this.handleDraggabilly={dragStart:function(){a.itemDragStart(this.element)},dragMove:function(){a.itemDragMove(this.element,this.position.x,this.position.y)},dragEnd:function(){a.itemDragEnd(this.element)}},this.handleUIDraggable={start:function(b,c){c&&a.itemDragStart(b.currentTarget)},drag:function(b,c){c&&a.itemDragMove(b.currentTarget,c.position.left,c.position.top)},stop:function(b,c){c&&a.itemDragEnd(b.currentTarget)}}},j._resetLayout=function(){this.getSize(),this._getMeasurements();var a,b,c;this._getOption("horizontal")?(a=1/0,b=this.size.innerHeight+this.gutter,c="rightwardTopToBottom"):(a=this.size.innerWidth+this.gutter,b=1/0,c="downwardLeftToRight"),this.packer.width=this.shiftPacker.width=a,this.packer.height=this.shiftPacker.height=b,this.packer.sortDirection=this.shiftPacker.sortDirection=c,this.packer.reset(),this.maxY=0,this.maxX=0},j._getMeasurements=function(){this._getMeasurement("columnWidth","width"),this._getMeasurement("rowHeight","height"),this._getMeasurement("gutter","width")},j._getItemLayoutPosition=function(a){if(this._setRectSize(a.element,a.rect),this.isShifting||this.dragItemCount>0){var b=this._getPackMethod();this.packer[b](a.rect)}else this.packer.pack(a.rect);return this._setMaxXY(a.rect),a.rect},j.shiftLayout=function(){this.isShifting=!0,this.layout(),delete this.isShifting},j._getPackMethod=function(){return this._getOption("horizontal")?"rowPack":"columnPack"},j._setMaxXY=function(a){this.maxX=Math.max(a.x+a.width,this.maxX),this.maxY=Math.max(a.y+a.height,this.maxY)},j._setRectSize=function(b,c){var d=a(b),e=d.outerWidth,f=d.outerHeight;(e||f)&&(e=this._applyGridGutter(e,this.columnWidth),f=this._applyGridGutter(f,this.rowHeight)),c.width=Math.min(e,this.packer.width),c.height=Math.min(f,this.packer.height)},j._applyGridGutter=function(a,b){if(!b)return a+this.gutter;b+=this.gutter;var c=a%b,d=c&&1>c?"round":"ceil";return a=Math[d](a/b)*b},j._getContainerSize=function(){return this._getOption("horizontal")?{width:this.maxX-this.gutter}:{height:this.maxY-this.gutter}},j._manageStamp=function(a){var b,d=this.getItem(a);if(d&&d.isPlacing)b=d.rect;else{var e=this._getElementOffset(a);b=new c({x:this._getOption("originLeft")?e.left:e.right,y:this._getOption("originTop")?e.top:e.bottom})}this._setRectSize(a,b),this.packer.placed(b),this._setMaxXY(b)},j.sortItemsByPosition=function(){var a=this._getOption("horizontal")?g:f;this.items.sort(a)},j.fit=function(a,b,c){var d=this.getItem(a);d&&(this.stamp(d.element),d.enablePlacing(),this.updateShiftTargets(d),b=void 0===b?d.rect.x:b,c=void 0===c?d.rect.y:c,this.shift(d,b,c),this._bindFitEvents(d),d.moveTo(d.rect.x,d.rect.y),this.shiftLayout(),this.unstamp(d.element),this.sortItemsByPosition(),d.disablePlacing())},j._bindFitEvents=function(a){function b(){d++,2==d&&c.dispatchEvent("fitComplete",null,[a])}var c=this,d=0;a.once("layout",b),this.once("layoutComplete",b)},j.resize=function(){this.isResizeBound&&this.needsResizeLayout()&&(this.options.shiftPercentResize?this.resizeShiftPercentLayout():this.layout())},j.needsResizeLayout=function(){var b=a(this.element),c=this._getOption("horizontal")?"innerHeight":"innerWidth";return b[c]!=this.size[c]},j.resizeShiftPercentLayout=function(){var b=this._getItemsForLayout(this.items),c=this._getOption("horizontal"),d=c?"y":"x",e=c?"height":"width",f=c?"rowHeight":"columnWidth",g=c?"innerHeight":"innerWidth",h=this[f];if(h=h&&h+this.gutter){this._getMeasurements();var i=this[f]+this.gutter;b.forEach(function(a){var b=Math.round(a.rect[d]/h);a.rect[d]=b*i})}else{var j=a(this.element)[g]+this.gutter,k=this.packer[e];b.forEach(function(a){a.rect[d]=a.rect[d]/k*j})}this.shiftLayout()},j.itemDragStart=function(a){if(this.isEnabled){this.stamp(a);var b=this.getItem(a);b&&(b.enablePlacing(),b.showDropPlaceholder(),this.dragItemCount++,this.updateShiftTargets(b))}},j.updateShiftTargets=function(a){this.shiftPacker.reset(),this._getBoundingRect();var b=this._getOption("originLeft"),d=this._getOption("originTop");this.stamps.forEach(function(a){var e=this.getItem(a);if(!e||!e.isPlacing){var f=this._getElementOffset(a),g=new c({x:b?f.left:f.right,y:d?f.top:f.bottom});this._setRectSize(a,g),this.shiftPacker.placed(g)}},this);var e=this._getOption("horizontal"),f=e?"rowHeight":"columnWidth",g=e?"height":"width";this.shiftTargetKeys=[],this.shiftTargets=[];var h,i=this[f];if(i=i&&i+this.gutter){var j=Math.ceil(a.rect[g]/i),k=Math.floor((this.shiftPacker[g]+this.gutter)/i);h=(k-j)*i;for(var l=0;k>l;l++)this._addShiftTarget(l*i,0,h)}else h=this.shiftPacker[g]+this.gutter-a.rect[g],this._addShiftTarget(0,0,h);var m=this._getItemsForLayout(this.items),n=this._getPackMethod();m.forEach(function(a){var b=a.rect;this._setRectSize(a.element,b),this.shiftPacker[n](b),this._addShiftTarget(b.x,b.y,h);var c=e?b.x+b.width:b.x,d=e?b.y:b.y+b.height;if(this._addShiftTarget(c,d,h),i)for(var f=Math.round(b[g]/i),j=1;f>j;j++){var k=e?c:b.x+i*j,l=e?b.y+i*j:d;this._addShiftTarget(k,l,h)}},this)},j._addShiftTarget=function(a,b,c){var d=this._getOption("horizontal")?b:a;if(!(0!==d&&d>c)){var e=a+","+b,f=-1!=this.shiftTargetKeys.indexOf(e);f||(this.shiftTargetKeys.push(e),this.shiftTargets.push({x:a,y:b}))}},j.shift=function(a,b,c){var d,e=1/0,f={x:b,y:c};this.shiftTargets.forEach(function(a){var b=h(a,f);e>b&&(d=a,e=b)}),a.rect.x=d.x,a.rect.y=d.y};var k=120;j.itemDragMove=function(a,b,c){function d(){f.shift(e,b,c),e.positionDropPlaceholder(),f.layout()}var e=this.isEnabled&&this.getItem(a);if(e){b-=this.size.paddingLeft,c-=this.size.paddingTop;var f=this,g=new Date;this._itemDragTime&&g-this._itemDragTime<k?(clearTimeout(this.dragTimeout),this.dragTimeout=setTimeout(d,k)):(d(),this._itemDragTime=g)}},j.itemDragEnd=function(a){function b(){d++,2==d&&(c.element.classList.remove("is-positioning-post-drag"),c.hideDropPlaceholder(),e.dispatchEvent("dragItemPositioned",null,[c]))}var c=this.isEnabled&&this.getItem(a);if(c){clearTimeout(this.dragTimeout),c.element.classList.add("is-positioning-post-drag");var d=0,e=this;c.once("layout",b),this.once("layoutComplete",b),c.moveTo(c.rect.x,c.rect.y),this.layout(),this.dragItemCount=Math.max(0,this.dragItemCount-1),this.sortItemsByPosition(),c.disablePlacing(),this.unstamp(c.element)}},j.bindDraggabillyEvents=function(a){this._bindDraggabillyEvents(a,"on")},j.unbindDraggabillyEvents=function(a){this._bindDraggabillyEvents(a,"off")},j._bindDraggabillyEvents=function(a,b){var c=this.handleDraggabilly;a[b]("dragStart",c.dragStart),a[b]("dragMove",c.dragMove),a[b]("dragEnd",c.dragEnd)},j.bindUIDraggableEvents=function(a){this._bindUIDraggableEvents(a,"on")},j.unbindUIDraggableEvents=function(a){this._bindUIDraggableEvents(a,"off")},j._bindUIDraggableEvents=function(a,b){var c=this.handleUIDraggable;a[b]("dragstart",c.start)[b]("drag",c.drag)[b]("dragstop",c.stop)};var l=j.destroy;return j.destroy=function(){l.apply(this,arguments),this.isEnabled=!1},i.Rect=c,i.Packer=d,i}),function(a,b){"function"==typeof define&&define.amd?define(["isotope-layout/js/layout-mode","packery/js/packery"],b):"object"==typeof module&&module.exports?module.exports=b(require("isotope-layout/js/layout-mode"),require("packery")):b(a.Isotope.LayoutMode,a.Packery)}(window,function(a,b){var c=a.create("packery"),d=c.prototype,e={_getElementOffset:!0,_getMeasurement:!0};for(var f in b.prototype)e[f]||(d[f]=b.prototype[f]);var g=d._resetLayout;d._resetLayout=function(){this.packer=this.packer||new b.Packer,this.shiftPacker=this.shiftPacker||new b.Packer,g.apply(this,arguments)};var h=d._getItemLayoutPosition;d._getItemLayoutPosition=function(a){return a.rect=a.rect||new b.Rect,h.call(this,a)};var i=d.needsResizeLayout;d.needsResizeLayout=function(){return this._getOption("horizontal")?this.needsVerticalResizeLayout():i.call(this)};var j=d._getOption;return d._getOption=function(a){return"horizontal"==a?void 0!==this.options.isHorizontal?this.options.isHorizontal:this.options.horizontal:j.apply(this.isotope,arguments)},c});

    // Two Row Carousel
    ;(function ($, window, document, undefined) {
        Owl2row = function (scope) {
            this.owl = scope;
            this.owl.options = $.extend({}, Owl2row.Defaults, this.owl.options);
            //link callback events with owl carousel here

            this.handlers = {
                'initialize.owl.carousel': $.proxy(function (e) {
                    if (this.owl.settings.owl2row) {
                        this.build2row(this);
                    }
                }, this)
            };

            this.owl.$element.on(this.handlers);
        };

        Owl2row.Defaults = {
            owl2row: false,
            owl2rowTarget: 'sbi_item',
            owl2rowContainer: 'sbi_owl2row-item',
            owl2rowDirection: 'utd' // ltr
        };

        //mehtods:
        Owl2row.prototype.build2row = function(thisScope){

            var carousel = $(thisScope.owl.$element);
            var carouselItems = carousel.find('.' + thisScope.owl.options.owl2rowTarget);

            var aEvenElements = [];
            var aOddElements = [];

            $.each(carouselItems, function (index, item) {
                if ( index % 2 === 0 ) {
                    aEvenElements.push(item);
                } else {
                    aOddElements.push(item);
                }
            });

            //carousel.empty();

            switch (thisScope.owl.options.owl2rowDirection) {
                case 'ltr':
                    thisScope.leftToright(thisScope, carousel, carouselItems);
                    break;

                default :
                    thisScope.upTodown(thisScope, aEvenElements, aOddElements, carousel);
            }

        };

        Owl2row.prototype.leftToright = function(thisScope, carousel, carouselItems){

            var o2wContainerClass = thisScope.owl.options.owl2rowContainer;
            var owlMargin = thisScope.owl.options.margin;
            var carouselItemsLength = carouselItems.length;
            var firsArr = [];
            var secondArr = [];

            if (carouselItemsLength %2 === 1) {
                carouselItemsLength = ((carouselItemsLength - 1)/2) + 1;
            } else {
                carouselItemsLength = carouselItemsLength/2;
            }

            $.each(carouselItems, function (index, item) {


                if (index < carouselItemsLength) {
                    firsArr.push(item);
                } else {
                    secondArr.push(item);
                }
            });

            $.each(firsArr, function (index, item) {
                var rowContainer = $('<div class="' + o2wContainerClass + '"/>');

                var firstRowElement = firsArr[index];
                firstRowElement.style.marginBottom = owlMargin + 'px';

                rowContainer
                    .append(firstRowElement)
                    .append(secondArr[index]);

                carousel.append(rowContainer);
            });

        };

        Owl2row.prototype.upTodown = function(thisScope, aEvenElements, aOddElements, carousel){

            var o2wContainerClass = thisScope.owl.options.owl2rowContainer;
            var owlMargin = thisScope.owl.options.margin;

            $.each(aEvenElements, function (index, item) {

                var rowContainer = $('<div class="' + o2wContainerClass + '"/>');
                var evenElement = aEvenElements[index];

                evenElement.style.marginBottom = owlMargin + 'px';

                rowContainer
                    .append(evenElement)
                    .append(aOddElements[index]);

                carousel.append(rowContainer);
            });
        };

        /**
         * Destroys the plugin.
         */
        Owl2row.prototype.destroy = function() {
            var handler, property;
        };

        $.fn.sbiOwlCarousel.Constructor.Plugins['owl2row'] = Owl2row;
    })( window.Zepto || window.jQuery, window,  document );

    /* JavaScript Linkify - v0.3 - 6/27/2009 - http://benalman.com/projects/javascript-linkify/ */
    window.sbiLinkify=(function(){var k="[a-z\\d.-]+://",h="(?:(?:[0-9]|[1-9]\\d|1\\d{2}|2[0-4]\\d|25[0-5])\\.){3}(?:[0-9]|[1-9]\\d|1\\d{2}|2[0-4]\\d|25[0-5])",c="(?:(?:[^\\s!@#$%^&*()_=+[\\]{}\\\\|;:'\",.<>/?]+)\\.)+",n="(?:ac|ad|aero|ae|af|ag|ai|al|am|an|ao|aq|arpa|ar|asia|as|at|au|aw|ax|az|ba|bb|bd|be|bf|bg|bh|biz|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|cat|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|coop|com|co|cr|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gg|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|im|info|int|in|io|iq|ir|is|it|je|jm|jobs|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mobi|mo|mp|mq|mr|ms|mt|museum|mu|mv|mw|mx|my|mz|name|na|nc|net|ne|nf|ng|ni|nl|no|np|nr|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pro|pr|ps|pt|pw|py|qa|re|ro|rs|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tel|tf|tg|th|tj|tk|tl|tm|tn|to|tp|travel|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|xn--0zwm56d|xn--11b5bs3a9aj6g|xn--80akhbyknj4f|xn--9t4b11yi5a|xn--deba0ad|xn--g6w251d|xn--hgbk6aj7f53bba|xn--hlcj6aya9esc7a|xn--jxalpdlp|xn--kgbechtv|xn--zckzah|ye|yt|yu|za|zm|zw)",f="(?:"+c+n+"|"+h+")",o="(?:[;/][^#?<>\\s]*)?",e="(?:\\?[^#<>\\s]*)?(?:#[^<>\\s]*)?",d="\\b"+k+"[^<>\\s]+",a="\\b"+f+o+e+"(?!\\w)",m="mailto:",j="(?:"+m+")?[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@"+f+e+"(?!\\w)",l=new RegExp("(?:"+d+"|"+a+"|"+j+")","ig"),g=new RegExp("^"+k,"i"),b={"'":"`",">":"<",")":"(","]":"[","}":"{","B;":"B+","b:":"b9"},i={callback:function(q,p){return p?'<a href="'+p+'" title="'+p+'" target="_blank">'+q+"</a>":q},punct_regexp:/(?:[!?.,:;'"]|(?:&|&amp;)(?:lt|gt|quot|apos|raquo|laquo|rsaquo|lsaquo);)$/};return function(u,z){z=z||{};var w,v,A,p,x="",t=[],s,E,C,y,q,D,B,r;for(v in i){if(z[v]===undefined){z[v]=i[v]}}while(w=l.exec(u)){A=w[0];E=l.lastIndex;C=E-A.length;if(/[\/:]/.test(u.charAt(C-1))){continue}do{y=A;r=A.substr(-1);B=b[r];if(B){q=A.match(new RegExp("\\"+B+"(?!$)","g"));D=A.match(new RegExp("\\"+r,"g"));if((q?q.length:0)<(D?D.length:0)){A=A.substr(0,A.length-1);E--}}if(z.punct_regexp){A=A.replace(z.punct_regexp,function(F){E-=F.length;return""})}}while(A.length&&A!==y);p=A;if(!g.test(p)){p=(p.indexOf("@")!==-1?(!p.indexOf(m)?"":m):!p.indexOf("irc.")?"irc://":!p.indexOf("ftp.")?"ftp://":"http://")+p}if(s!=C){t.push([u.slice(s,C)]);s=E}t.push([A,p])}t.push([u.substr(s)]);for(v=0;v<t.length;v++){x+=z.callback.apply(window,t[v])}return x||u}})();

    //Shim for "fixing" IE's lack of support (IE < 9) for applying slice on host objects like NamedNodeMap, NodeList, and HTMLCollection) https://github.com/stevenschobert/instafeed.js/issues/84
    (function(){"use strict";var e=Array.prototype.slice;try{e.call(document.documentElement)}catch(t){Array.prototype.slice=function(t,n){n=typeof n!=="undefined"?n:this.length;if(Object.prototype.toString.call(this)==="[object Array]"){return e.call(this,t,n)}var r,i=[],s,o=this.length;var u=t||0;u=u>=0?u:o+u;var a=n?n:o;if(n<0){a=o+n}s=a-u;if(s>0){i=new Array(s);if(this.charAt){for(r=0;r<s;r++){i[r]=this.charAt(u+r)}}else{for(r=0;r<s;r++){i[r]=this[u+r]}}}return i}}})()

    //IE8 also doesn't offer the .bind() method triggered by the 'sortBy' property. Copy and paste the polyfill offered here:
    if(!Function.prototype.bind){Function.prototype.bind=function(e){if(typeof this!=="function"){throw new TypeError("Function.prototype.bind - what is trying to be bound is not callable")}var t=Array.prototype.slice.call(arguments,1),n=this,r=function(){},i=function(){return n.apply(this instanceof r&&e?this:e,t.concat(Array.prototype.slice.call(arguments)))};r.prototype=this.prototype;i.prototype=new r;return i}}

    /*! Hammer.JS - v2.0.8 - 2016-04-23
    * http://hammerjs.github.io/
    *
    * Copyright (c) 2016 Jorik Tangelder;
    * Licensed under the MIT license
    * */
    if (typeof sb_instagram_js_options.no_mob_swipe === 'undefined') {
        !function(a,b,c,d){"use strict";function e(a,b,c){return setTimeout(j(a,c),b)}function f(a,b,c){return Array.isArray(a)?(g(a,c[b],c),!0):!1}function g(a,b,c){var e;if(a)if(a.forEach)a.forEach(b,c);else if(a.length!==d)for(e=0;e<a.length;)b.call(c,a[e],e,a),e++;else for(e in a)a.hasOwnProperty(e)&&b.call(c,a[e],e,a)}function h(b,c,d){var e="DEPRECATED METHOD: "+c+"\n"+d+" AT \n";return function(){var c=new Error("get-stack-trace"),d=c&&c.stack?c.stack.replace(/^[^\(]+?[\n$]/gm,"").replace(/^\s+at\s+/gm,"").replace(/^Object.<anonymous>\s*\(/gm,"{anonymous}()@"):"Unknown Stack Trace",f=a.console&&(a.console.warn||a.console.log);return f&&f.call(a.console,e,d),b.apply(this,arguments)}}function i(a,b,c){var d,e=b.prototype;d=a.prototype=Object.create(e),d.constructor=a,d._super=e,c&&la(d,c)}function j(a,b){return function(){return a.apply(b,arguments)}}function k(a,b){return typeof a==oa?a.apply(b?b[0]||d:d,b):a}function l(a,b){return a===d?b:a}function m(a,b,c){g(q(b),function(b){a.addEventListener(b,c,!1)})}function n(a,b,c){g(q(b),function(b){a.removeEventListener(b,c,!1)})}function o(a,b){for(;a;){if(a==b)return!0;a=a.parentNode}return!1}function p(a,b){return a.indexOf(b)>-1}function q(a){return a.trim().split(/\s+/g)}function r(a,b,c){if(a.indexOf&&!c)return a.indexOf(b);for(var d=0;d<a.length;){if(c&&a[d][c]==b||!c&&a[d]===b)return d;d++}return-1}function s(a){return Array.prototype.slice.call(a,0)}function t(a,b,c){for(var d=[],e=[],f=0;f<a.length;){var g=b?a[f][b]:a[f];r(e,g)<0&&d.push(a[f]),e[f]=g,f++}return c&&(d=b?d.sort(function(a,c){return a[b]>c[b]}):d.sort()),d}function u(a,b){for(var c,e,f=b[0].toUpperCase()+b.slice(1),g=0;g<ma.length;){if(c=ma[g],e=c?c+f:b,e in a)return e;g++}return d}function v(){return ua++}function w(b){var c=b.ownerDocument||b;return c.defaultView||c.parentWindow||a}function x(a,b){var c=this;this.manager=a,this.callback=b,this.element=a.element,this.target=a.options.inputTarget,this.domHandler=function(b){k(a.options.enable,[a])&&c.handler(b)},this.init()}function y(a){var b,c=a.options.inputClass;return new(b=c?c:xa?M:ya?P:wa?R:L)(a,z)}function z(a,b,c){var d=c.pointers.length,e=c.changedPointers.length,f=b&Ea&&d-e===0,g=b&(Ga|Ha)&&d-e===0;c.isFirst=!!f,c.isFinal=!!g,f&&(a.session={}),c.eventType=b,A(a,c),a.emit("hammer.input",c),a.recognize(c),a.session.prevInput=c}function A(a,b){var c=a.session,d=b.pointers,e=d.length;c.firstInput||(c.firstInput=D(b)),e>1&&!c.firstMultiple?c.firstMultiple=D(b):1===e&&(c.firstMultiple=!1);var f=c.firstInput,g=c.firstMultiple,h=g?g.center:f.center,i=b.center=E(d);b.timeStamp=ra(),b.deltaTime=b.timeStamp-f.timeStamp,b.angle=I(h,i),b.distance=H(h,i),B(c,b),b.offsetDirection=G(b.deltaX,b.deltaY);var j=F(b.deltaTime,b.deltaX,b.deltaY);b.overallVelocityX=j.x,b.overallVelocityY=j.y,b.overallVelocity=qa(j.x)>qa(j.y)?j.x:j.y,b.scale=g?K(g.pointers,d):1,b.rotation=g?J(g.pointers,d):0,b.maxPointers=c.prevInput?b.pointers.length>c.prevInput.maxPointers?b.pointers.length:c.prevInput.maxPointers:b.pointers.length,C(c,b);var k=a.element;o(b.srcEvent.target,k)&&(k=b.srcEvent.target),b.target=k}function B(a,b){var c=b.center,d=a.offsetDelta||{},e=a.prevDelta||{},f=a.prevInput||{};b.eventType!==Ea&&f.eventType!==Ga||(e=a.prevDelta={x:f.deltaX||0,y:f.deltaY||0},d=a.offsetDelta={x:c.x,y:c.y}),b.deltaX=e.x+(c.x-d.x),b.deltaY=e.y+(c.y-d.y)}function C(a,b){var c,e,f,g,h=a.lastInterval||b,i=b.timeStamp-h.timeStamp;if(b.eventType!=Ha&&(i>Da||h.velocity===d)){var j=b.deltaX-h.deltaX,k=b.deltaY-h.deltaY,l=F(i,j,k);e=l.x,f=l.y,c=qa(l.x)>qa(l.y)?l.x:l.y,g=G(j,k),a.lastInterval=b}else c=h.velocity,e=h.velocityX,f=h.velocityY,g=h.direction;b.velocity=c,b.velocityX=e,b.velocityY=f,b.direction=g}function D(a){for(var b=[],c=0;c<a.pointers.length;)b[c]={clientX:pa(a.pointers[c].clientX),clientY:pa(a.pointers[c].clientY)},c++;return{timeStamp:ra(),pointers:b,center:E(b),deltaX:a.deltaX,deltaY:a.deltaY}}function E(a){var b=a.length;if(1===b)return{x:pa(a[0].clientX),y:pa(a[0].clientY)};for(var c=0,d=0,e=0;b>e;)c+=a[e].clientX,d+=a[e].clientY,e++;return{x:pa(c/b),y:pa(d/b)}}function F(a,b,c){return{x:b/a||0,y:c/a||0}}function G(a,b){return a===b?Ia:qa(a)>=qa(b)?0>a?Ja:Ka:0>b?La:Ma}function H(a,b,c){c||(c=Qa);var d=b[c[0]]-a[c[0]],e=b[c[1]]-a[c[1]];return Math.sqrt(d*d+e*e)}function I(a,b,c){c||(c=Qa);var d=b[c[0]]-a[c[0]],e=b[c[1]]-a[c[1]];return 180*Math.atan2(e,d)/Math.PI}function J(a,b){return I(b[1],b[0],Ra)+I(a[1],a[0],Ra)}function K(a,b){return H(b[0],b[1],Ra)/H(a[0],a[1],Ra)}function L(){this.evEl=Ta,this.evWin=Ua,this.pressed=!1,x.apply(this,arguments)}function M(){this.evEl=Xa,this.evWin=Ya,x.apply(this,arguments),this.store=this.manager.session.pointerEvents=[]}function N(){this.evTarget=$a,this.evWin=_a,this.started=!1,x.apply(this,arguments)}function O(a,b){var c=s(a.touches),d=s(a.changedTouches);return b&(Ga|Ha)&&(c=t(c.concat(d),"identifier",!0)),[c,d]}function P(){this.evTarget=bb,this.targetIds={},x.apply(this,arguments)}function Q(a,b){var c=s(a.touches),d=this.targetIds;if(b&(Ea|Fa)&&1===c.length)return d[c[0].identifier]=!0,[c,c];var e,f,g=s(a.changedTouches),h=[],i=this.target;if(f=c.filter(function(a){return o(a.target,i)}),b===Ea)for(e=0;e<f.length;)d[f[e].identifier]=!0,e++;for(e=0;e<g.length;)d[g[e].identifier]&&h.push(g[e]),b&(Ga|Ha)&&delete d[g[e].identifier],e++;return h.length?[t(f.concat(h),"identifier",!0),h]:void 0}function R(){x.apply(this,arguments);var a=j(this.handler,this);this.touch=new P(this.manager,a),this.mouse=new L(this.manager,a),this.primaryTouch=null,this.lastTouches=[]}function S(a,b){a&Ea?(this.primaryTouch=b.changedPointers[0].identifier,T.call(this,b)):a&(Ga|Ha)&&T.call(this,b)}function T(a){var b=a.changedPointers[0];if(b.identifier===this.primaryTouch){var c={x:b.clientX,y:b.clientY};this.lastTouches.push(c);var d=this.lastTouches,e=function(){var a=d.indexOf(c);a>-1&&d.splice(a,1)};setTimeout(e,cb)}}function U(a){for(var b=a.srcEvent.clientX,c=a.srcEvent.clientY,d=0;d<this.lastTouches.length;d++){var e=this.lastTouches[d],f=Math.abs(b-e.x),g=Math.abs(c-e.y);if(db>=f&&db>=g)return!0}return!1}function V(a,b){this.manager=a,this.set(b)}function W(a){if(p(a,jb))return jb;var b=p(a,kb),c=p(a,lb);return b&&c?jb:b||c?b?kb:lb:p(a,ib)?ib:hb}function X(){if(!fb)return!1;var b={},c=a.CSS&&a.CSS.supports;return["auto","manipulation","pan-y","pan-x","pan-x pan-y","none"].forEach(function(d){b[d]=c?a.CSS.supports("touch-action",d):!0}),b}function Y(a){this.options=la({},this.defaults,a||{}),this.id=v(),this.manager=null,this.options.enable=l(this.options.enable,!0),this.state=nb,this.simultaneous={},this.requireFail=[]}function Z(a){return a&sb?"cancel":a&qb?"end":a&pb?"move":a&ob?"start":""}function $(a){return a==Ma?"down":a==La?"up":a==Ja?"left":a==Ka?"right":""}function _(a,b){var c=b.manager;return c?c.get(a):a}function aa(){Y.apply(this,arguments)}function ba(){aa.apply(this,arguments),this.pX=null,this.pY=null}function ca(){aa.apply(this,arguments)}function da(){Y.apply(this,arguments),this._timer=null,this._input=null}function ea(){aa.apply(this,arguments)}function fa(){aa.apply(this,arguments)}function ga(){Y.apply(this,arguments),this.pTime=!1,this.pCenter=!1,this._timer=null,this._input=null,this.count=0}function ha(a,b){return b=b||{},b.recognizers=l(b.recognizers,ha.defaults.preset),new ia(a,b)}function ia(a,b){this.options=la({},ha.defaults,b||{}),this.options.inputTarget=this.options.inputTarget||a,this.handlers={},this.session={},this.recognizers=[],this.oldCssProps={},this.element=a,this.input=y(this),this.touchAction=new V(this,this.options.touchAction),ja(this,!0),g(this.options.recognizers,function(a){var b=this.add(new a[0](a[1]));a[2]&&b.recognizeWith(a[2]),a[3]&&b.requireFailure(a[3])},this)}function ja(a,b){var c=a.element;if(c.style){var d;g(a.options.cssProps,function(e,f){d=u(c.style,f),b?(a.oldCssProps[d]=c.style[d],c.style[d]=e):c.style[d]=a.oldCssProps[d]||""}),b||(a.oldCssProps={})}}function ka(a,c){var d=b.createEvent("Event");d.initEvent(a,!0,!0),d.gesture=c,c.target.dispatchEvent(d)}var la,ma=["","webkit","Moz","MS","ms","o"],na=b.createElement("div"),oa="function",pa=Math.round,qa=Math.abs,ra=Date.now;la="function"!=typeof Object.assign?function(a){if(a===d||null===a)throw new TypeError("Cannot convert undefined or null to object");for(var b=Object(a),c=1;c<arguments.length;c++){var e=arguments[c];if(e!==d&&null!==e)for(var f in e)e.hasOwnProperty(f)&&(b[f]=e[f])}return b}:Object.assign;var sa=h(function(a,b,c){for(var e=Object.keys(b),f=0;f<e.length;)(!c||c&&a[e[f]]===d)&&(a[e[f]]=b[e[f]]),f++;return a},"extend","Use `assign`."),ta=h(function(a,b){return sa(a,b,!0)},"merge","Use `assign`."),ua=1,va=/mobile|tablet|ip(ad|hone|od)|android/i,wa="ontouchstart"in a,xa=u(a,"PointerEvent")!==d,ya=wa&&va.test(navigator.userAgent),za="touch",Aa="pen",Ba="mouse",Ca="kinect",Da=25,Ea=1,Fa=2,Ga=4,Ha=8,Ia=1,Ja=2,Ka=4,La=8,Ma=16,Na=Ja|Ka,Oa=La|Ma,Pa=Na|Oa,Qa=["x","y"],Ra=["clientX","clientY"];x.prototype={handler:function(){},init:function(){this.evEl&&m(this.element,this.evEl,this.domHandler),this.evTarget&&m(this.target,this.evTarget,this.domHandler),this.evWin&&m(w(this.element),this.evWin,this.domHandler)},destroy:function(){this.evEl&&n(this.element,this.evEl,this.domHandler),this.evTarget&&n(this.target,this.evTarget,this.domHandler),this.evWin&&n(w(this.element),this.evWin,this.domHandler)}};var Sa={mousedown:Ea,mousemove:Fa,mouseup:Ga},Ta="mousedown",Ua="mousemove mouseup";i(L,x,{handler:function(a){var b=Sa[a.type];b&Ea&&0===a.button&&(this.pressed=!0),b&Fa&&1!==a.which&&(b=Ga),this.pressed&&(b&Ga&&(this.pressed=!1),this.callback(this.manager,b,{pointers:[a],changedPointers:[a],pointerType:Ba,srcEvent:a}))}});var Va={pointerdown:Ea,pointermove:Fa,pointerup:Ga,pointercancel:Ha,pointerout:Ha},Wa={2:za,3:Aa,4:Ba,5:Ca},Xa="pointerdown",Ya="pointermove pointerup pointercancel";a.MSPointerEvent&&!a.PointerEvent&&(Xa="MSPointerDown",Ya="MSPointerMove MSPointerUp MSPointerCancel"),i(M,x,{handler:function(a){var b=this.store,c=!1,d=a.type.toLowerCase().replace("ms",""),e=Va[d],f=Wa[a.pointerType]||a.pointerType,g=f==za,h=r(b,a.pointerId,"pointerId");e&Ea&&(0===a.button||g)?0>h&&(b.push(a),h=b.length-1):e&(Ga|Ha)&&(c=!0),0>h||(b[h]=a,this.callback(this.manager,e,{pointers:b,changedPointers:[a],pointerType:f,srcEvent:a}),c&&b.splice(h,1))}});var Za={touchstart:Ea,touchmove:Fa,touchend:Ga,touchcancel:Ha},$a="touchstart",_a="touchstart touchmove touchend touchcancel";i(N,x,{handler:function(a){var b=Za[a.type];if(b===Ea&&(this.started=!0),this.started){var c=O.call(this,a,b);b&(Ga|Ha)&&c[0].length-c[1].length===0&&(this.started=!1),this.callback(this.manager,b,{pointers:c[0],changedPointers:c[1],pointerType:za,srcEvent:a})}}});var ab={touchstart:Ea,touchmove:Fa,touchend:Ga,touchcancel:Ha},bb="touchstart touchmove touchend touchcancel";i(P,x,{handler:function(a){var b=ab[a.type],c=Q.call(this,a,b);c&&this.callback(this.manager,b,{pointers:c[0],changedPointers:c[1],pointerType:za,srcEvent:a})}});var cb=2500,db=25;i(R,x,{handler:function(a,b,c){var d=c.pointerType==za,e=c.pointerType==Ba;if(!(e&&c.sourceCapabilities&&c.sourceCapabilities.firesTouchEvents)){if(d)S.call(this,b,c);else if(e&&U.call(this,c))return;this.callback(a,b,c)}},destroy:function(){this.touch.destroy(),this.mouse.destroy()}});var eb=u(na.style,"touchAction"),fb=eb!==d,gb="compute",hb="auto",ib="manipulation",jb="none",kb="pan-x",lb="pan-y",mb=X();V.prototype={set:function(a){a==gb&&(a=this.compute()),fb&&this.manager.element.style&&mb[a]&&(this.manager.element.style[eb]=a),this.actions=a.toLowerCase().trim()},update:function(){this.set(this.manager.options.touchAction)},compute:function(){var a=[];return g(this.manager.recognizers,function(b){k(b.options.enable,[b])&&(a=a.concat(b.getTouchAction()))}),W(a.join(" "))},preventDefaults:function(a){var b=a.srcEvent,c=a.offsetDirection;if(this.manager.session.prevented)return void b.preventDefault();var d=this.actions,e=p(d,jb)&&!mb[jb],f=p(d,lb)&&!mb[lb],g=p(d,kb)&&!mb[kb];if(e){var h=1===a.pointers.length,i=a.distance<2,j=a.deltaTime<250;if(h&&i&&j)return}return g&&f?void 0:e||f&&c&Na||g&&c&Oa?this.preventSrc(b):void 0},preventSrc:function(a){this.manager.session.prevented=!0,a.preventDefault()}};var nb=1,ob=2,pb=4,qb=8,rb=qb,sb=16,tb=32;Y.prototype={defaults:{},set:function(a){return la(this.options,a),this.manager&&this.manager.touchAction.update(),this},recognizeWith:function(a){if(f(a,"recognizeWith",this))return this;var b=this.simultaneous;return a=_(a,this),b[a.id]||(b[a.id]=a,a.recognizeWith(this)),this},dropRecognizeWith:function(a){return f(a,"dropRecognizeWith",this)?this:(a=_(a,this),delete this.simultaneous[a.id],this)},requireFailure:function(a){if(f(a,"requireFailure",this))return this;var b=this.requireFail;return a=_(a,this),-1===r(b,a)&&(b.push(a),a.requireFailure(this)),this},dropRequireFailure:function(a){if(f(a,"dropRequireFailure",this))return this;a=_(a,this);var b=r(this.requireFail,a);return b>-1&&this.requireFail.splice(b,1),this},hasRequireFailures:function(){return this.requireFail.length>0},canRecognizeWith:function(a){return!!this.simultaneous[a.id]},emit:function(a){function b(b){c.manager.emit(b,a)}var c=this,d=this.state;qb>d&&b(c.options.event+Z(d)),b(c.options.event),a.additionalEvent&&b(a.additionalEvent),d>=qb&&b(c.options.event+Z(d))},tryEmit:function(a){return this.canEmit()?this.emit(a):void(this.state=tb)},canEmit:function(){for(var a=0;a<this.requireFail.length;){if(!(this.requireFail[a].state&(tb|nb)))return!1;a++}return!0},recognize:function(a){var b=la({},a);return k(this.options.enable,[this,b])?(this.state&(rb|sb|tb)&&(this.state=nb),this.state=this.process(b),void(this.state&(ob|pb|qb|sb)&&this.tryEmit(b))):(this.reset(),void(this.state=tb))},process:function(a){},getTouchAction:function(){},reset:function(){}},i(aa,Y,{defaults:{pointers:1},attrTest:function(a){var b=this.options.pointers;return 0===b||a.pointers.length===b},process:function(a){var b=this.state,c=a.eventType,d=b&(ob|pb),e=this.attrTest(a);return d&&(c&Ha||!e)?b|sb:d||e?c&Ga?b|qb:b&ob?b|pb:ob:tb}}),i(ba,aa,{defaults:{event:"pan",threshold:10,pointers:1,direction:Pa},getTouchAction:function(){var a=this.options.direction,b=[];return a&Na&&b.push(lb),a&Oa&&b.push(kb),b},directionTest:function(a){var b=this.options,c=!0,d=a.distance,e=a.direction,f=a.deltaX,g=a.deltaY;return e&b.direction||(b.direction&Na?(e=0===f?Ia:0>f?Ja:Ka,c=f!=this.pX,d=Math.abs(a.deltaX)):(e=0===g?Ia:0>g?La:Ma,c=g!=this.pY,d=Math.abs(a.deltaY))),a.direction=e,c&&d>b.threshold&&e&b.direction},attrTest:function(a){return aa.prototype.attrTest.call(this,a)&&(this.state&ob||!(this.state&ob)&&this.directionTest(a))},emit:function(a){this.pX=a.deltaX,this.pY=a.deltaY;var b=$(a.direction);b&&(a.additionalEvent=this.options.event+b),this._super.emit.call(this,a)}}),i(ca,aa,{defaults:{event:"pinch",threshold:0,pointers:2},getTouchAction:function(){return[jb]},attrTest:function(a){return this._super.attrTest.call(this,a)&&(Math.abs(a.scale-1)>this.options.threshold||this.state&ob)},emit:function(a){if(1!==a.scale){var b=a.scale<1?"in":"out";a.additionalEvent=this.options.event+b}this._super.emit.call(this,a)}}),i(da,Y,{defaults:{event:"press",pointers:1,time:251,threshold:9},getTouchAction:function(){return[hb]},process:function(a){var b=this.options,c=a.pointers.length===b.pointers,d=a.distance<b.threshold,f=a.deltaTime>b.time;if(this._input=a,!d||!c||a.eventType&(Ga|Ha)&&!f)this.reset();else if(a.eventType&Ea)this.reset(),this._timer=e(function(){this.state=rb,this.tryEmit()},b.time,this);else if(a.eventType&Ga)return rb;return tb},reset:function(){clearTimeout(this._timer)},emit:function(a){this.state===rb&&(a&&a.eventType&Ga?this.manager.emit(this.options.event+"up",a):(this._input.timeStamp=ra(),this.manager.emit(this.options.event,this._input)))}}),i(ea,aa,{defaults:{event:"rotate",threshold:0,pointers:2},getTouchAction:function(){return[jb]},attrTest:function(a){return this._super.attrTest.call(this,a)&&(Math.abs(a.rotation)>this.options.threshold||this.state&ob)}}),i(fa,aa,{defaults:{event:"swipe",threshold:10,velocity:.3,direction:Na|Oa,pointers:1},getTouchAction:function(){return ba.prototype.getTouchAction.call(this)},attrTest:function(a){var b,c=this.options.direction;return c&(Na|Oa)?b=a.overallVelocity:c&Na?b=a.overallVelocityX:c&Oa&&(b=a.overallVelocityY),this._super.attrTest.call(this,a)&&c&a.offsetDirection&&a.distance>this.options.threshold&&a.maxPointers==this.options.pointers&&qa(b)>this.options.velocity&&a.eventType&Ga},emit:function(a){var b=$(a.offsetDirection);b&&this.manager.emit(this.options.event+b,a),this.manager.emit(this.options.event,a)}}),i(ga,Y,{defaults:{event:"tap",pointers:1,taps:1,interval:300,time:250,threshold:9,posThreshold:10},getTouchAction:function(){return[ib]},process:function(a){var b=this.options,c=a.pointers.length===b.pointers,d=a.distance<b.threshold,f=a.deltaTime<b.time;if(this.reset(),a.eventType&Ea&&0===this.count)return this.failTimeout();if(d&&f&&c){if(a.eventType!=Ga)return this.failTimeout();var g=this.pTime?a.timeStamp-this.pTime<b.interval:!0,h=!this.pCenter||H(this.pCenter,a.center)<b.posThreshold;this.pTime=a.timeStamp,this.pCenter=a.center,h&&g?this.count+=1:this.count=1,this._input=a;var i=this.count%b.taps;if(0===i)return this.hasRequireFailures()?(this._timer=e(function(){this.state=rb,this.tryEmit()},b.interval,this),ob):rb}return tb},failTimeout:function(){return this._timer=e(function(){this.state=tb},this.options.interval,this),tb},reset:function(){clearTimeout(this._timer)},emit:function(){this.state==rb&&(this._input.tapCount=this.count,this.manager.emit(this.options.event,this._input))}}),ha.VERSION="2.0.8",ha.defaults={domEvents:!1,touchAction:gb,enable:!0,inputTarget:null,inputClass:null,preset:[[ea,{enable:!1}],[ca,{enable:!1},["rotate"]],[fa,{direction:Na}],[ba,{direction:Na},["swipe"]],[ga],[ga,{event:"doubletap",taps:2},["tap"]],[da]],cssProps:{userSelect:"none",touchSelect:"none",touchCallout:"none",contentZooming:"none",userDrag:"none",tapHighlightColor:"rgba(0,0,0,0)"}};var ub=1,vb=2;ia.prototype={set:function(a){return la(this.options,a),a.touchAction&&this.touchAction.update(),a.inputTarget&&(this.input.destroy(),this.input.target=a.inputTarget,this.input.init()),this},stop:function(a){this.session.stopped=a?vb:ub},recognize:function(a){var b=this.session;if(!b.stopped){this.touchAction.preventDefaults(a);var c,d=this.recognizers,e=b.curRecognizer;(!e||e&&e.state&rb)&&(e=b.curRecognizer=null);for(var f=0;f<d.length;)c=d[f],b.stopped===vb||e&&c!=e&&!c.canRecognizeWith(e)?c.reset():c.recognize(a),!e&&c.state&(ob|pb|qb)&&(e=b.curRecognizer=c),f++}},get:function(a){if(a instanceof Y)return a;for(var b=this.recognizers,c=0;c<b.length;c++)if(b[c].options.event==a)return b[c];return null},add:function(a){if(f(a,"add",this))return this;var b=this.get(a.options.event);return b&&this.remove(b),this.recognizers.push(a),a.manager=this,this.touchAction.update(),a},remove:function(a){if(f(a,"remove",this))return this;if(a=this.get(a)){var b=this.recognizers,c=r(b,a);-1!==c&&(b.splice(c,1),this.touchAction.update())}return this},on:function(a,b){if(a!==d&&b!==d){var c=this.handlers;return g(q(a),function(a){c[a]=c[a]||[],c[a].push(b)}),this}},off:function(a,b){if(a!==d){var c=this.handlers;return g(q(a),function(a){b?c[a]&&c[a].splice(r(c[a],b),1):delete c[a]}),this}},emit:function(a,b){this.options.domEvents&&ka(a,b);var c=this.handlers[a]&&this.handlers[a].slice();if(c&&c.length){b.type=a,b.preventDefault=function(){b.srcEvent.preventDefault()};for(var d=0;d<c.length;)c[d](b),d++}},destroy:function(){this.element&&ja(this,!1),this.handlers={},this.session={},this.input.destroy(),this.element=null}},la(ha,{INPUT_START:Ea,INPUT_MOVE:Fa,INPUT_END:Ga,INPUT_CANCEL:Ha,STATE_POSSIBLE:nb,STATE_BEGAN:ob,STATE_CHANGED:pb,STATE_ENDED:qb,STATE_RECOGNIZED:rb,STATE_CANCELLED:sb,STATE_FAILED:tb,DIRECTION_NONE:Ia,DIRECTION_LEFT:Ja,DIRECTION_RIGHT:Ka,DIRECTION_UP:La,DIRECTION_DOWN:Ma,DIRECTION_HORIZONTAL:Na,DIRECTION_VERTICAL:Oa,DIRECTION_ALL:Pa,Manager:ia,Input:x,TouchAction:V,TouchInput:P,MouseInput:L,PointerEventInput:M,TouchMouseInput:R,SingleTouchInput:N,Recognizer:Y,AttrRecognizer:aa,Tap:ga,Pan:ba,Swipe:fa,Pinch:ca,Rotate:ea,Press:da,on:m,off:n,each:g,merge:ta,extend:sa,assign:la,inherit:i,bindFn:j,prefixed:u});var wb="undefined"!=typeof a?a:"undefined"!=typeof self?self:{};wb.Hammer=ha,"function"==typeof define&&define.amd?define(function(){return ha}):"undefined"!=typeof module&&module.exports?module.exports=ha:a[c]=ha}(window,document,"Hammer");
        (function(factory) {
            if (typeof define === 'function' && define.amd) {
                define(['jquery', 'hammerjs'], factory);
            } else if (typeof exports === 'object') {
                factory(require('jquery'), require('hammerjs'));
            } else {
                factory(jQuery, Hammer);
            }
        }(function(jQuery, Hammer) {
            function hammerify(el, options) {
                var $el = jQuery(el);
                if(!$el.data("hammer")) {
                    $el.data("hammer", new Hammer($el[0], options));
                }
            }

            jQuery.fn.hammer = function(options) {
                return this.each(function() {
                    hammerify(this, options);
                });
            };

            // extend the emit method to also trigger jQuery events
            Hammer.Manager.prototype.emit = (function(originalEmit) {
                return function(type, data) {
                    originalEmit.call(this, type, data);
                    jQuery(this.element).trigger({
                        type: type,
                        gesture: data
                    });
                };
            })(Hammer.Manager.prototype.emit);
        }));

//# sourceMappingURL=hammer.min.js.map
    } else {
        var Hammer = {
            Manager : {
                prototype : {
                }
            }
        };
        (function(factory) {
            if (typeof define === 'function' && define.amd) {
                define(['jquery', 'hammerjs'], factory);
            } else if (typeof exports === 'object') {
                factory(require('jquery'), require('hammerjs'));
            } else {
                factory(jQuery, Hammer);
            }
        }(function(jQuery, Hammer) {
            function hammerify(el, options) {
            }
            jQuery.fn.hammer = function(options) {
                return this.each(function() {
                    hammerify(this, options);
                });
            };
            // extend the emit method to also trigger jQuery events
            Hammer.Manager.prototype.emit = (function(originalEmit) {
                return function(type, data) {
                    originalEmit.call(this, type, data);
                    jQuery(this.element).trigger({
                        type: type,
                        gesture: data
                    });
                };
            })(Hammer.Manager.prototype.emit);
        }));
    }
    /* Font Awesome SVG implementation */
    var sbIconSVG = {
        'fa-clock' : 'class="svg-inline--fa fa-clock fa-w-16" aria-hidden="true" data-fa-processed="" data-prefix="far" data-icon="clock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm61.8-104.4l-84.9-61.7c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v141.7l66.8 48.6c5.4 3.9 6.5 11.4 2.6 16.8L334.6 349c-3.9 5.3-11.4 6.5-16.8 2.6z"></path></svg>',
        'fa-play' : 'class="svg-inline--fa fa-play fa-w-14 sbi_playbtn" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="play" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z"></path></svg>',
        'fa-image' : 'class="svg-inline--fa fa-image fa-w-16" aria-hidden="true" data-fa-processed="" data-prefix="far" data-icon="image" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M464 448H48c-26.51 0-48-21.49-48-48V112c0-26.51 21.49-48 48-48h416c26.51 0 48 21.49 48 48v288c0 26.51-21.49 48-48 48zM112 120c-30.928 0-56 25.072-56 56s25.072 56 56 56 56-25.072 56-56-25.072-56-56-56zM64 384h384V272l-87.515-87.515c-4.686-4.686-12.284-4.686-16.971 0L208 320l-55.515-55.515c-4.686-4.686-12.284-4.686-16.971 0L64 336v48z"></path></svg>',
        'fa-user' : 'class="svg-inline--fa fa-user fa-w-16" style="margin-right: 3px;" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M96 160C96 71.634 167.635 0 256 0s160 71.634 160 160-71.635 160-160 160S96 248.366 96 160zm304 192h-28.556c-71.006 42.713-159.912 42.695-230.888 0H112C50.144 352 0 402.144 0 464v24c0 13.255 10.745 24 24 24h464c13.255 0 24-10.745 24-24v-24c0-61.856-50.144-112-112-112z"></path></svg>',
        'fa-comment' : 'class="svg-inline--fa fa-comment fa-w-18" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="comment" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M576 240c0 115-129 208-288 208-48.3 0-93.9-8.6-133.9-23.8-40.3 31.2-89.8 50.3-142.4 55.7-5.2.6-10.2-2.8-11.5-7.7-1.3-5 2.7-8.1 6.6-11.8 19.3-18.4 42.7-32.8 51.9-94.6C21.9 330.9 0 287.3 0 240 0 125.1 129 32 288 32s288 93.1 288 208z"></path></svg>',
        'fa-heart' : 'class="svg-inline--fa fa-heart fa-w-18" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="heart" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M414.9 24C361.8 24 312 65.7 288 89.3 264 65.7 214.2 24 161.1 24 70.3 24 16 76.9 16 165.5c0 72.6 66.8 133.3 69.2 135.4l187 180.8c8.8 8.5 22.8 8.5 31.6 0l186.7-180.2c2.7-2.7 69.5-63.5 69.5-136C560 76.9 505.7 24 414.9 24z"></path></svg>',
        'fa-check' : 'class="svg-inline--fa fa-check fa-w-16" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>',
        'fa-exclamation-circle' : 'class="svg-inline--fa fa-exclamation-circle fa-w-16" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M504 256c0 136.997-111.043 248-248 248S8 392.997 8 256C8 119.083 119.043 8 256 8s248 111.083 248 248zm-248 50c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"></path></svg>',
        'fa-map-marker' : 'class="svg-inline--fa fa-map-marker fa-w-12" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="map-marker" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M172.268 501.67C26.97 291.031 0 269.413 0 192 0 85.961 85.961 0 192 0s192 85.961 192 192c0 77.413-26.97 99.031-172.268 309.67-9.535 13.774-29.93 13.773-39.464 0z"></path></svg>',
        'fa-clone' : 'class="svg-inline--fa fa-clone fa-w-16 sbi_lightbox_carousel_icon" aria-hidden="true" data-fa-processed="" data-prefix="far" data-icon="clone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M464 0H144c-26.51 0-48 21.49-48 48v48H48c-26.51 0-48 21.49-48 48v320c0 26.51 21.49 48 48 48h320c26.51 0 48-21.49 48-48v-48h48c26.51 0 48-21.49 48-48V48c0-26.51-21.49-48-48-48zM362 464H54a6 6 0 0 1-6-6V150a6 6 0 0 1 6-6h42v224c0 26.51 21.49 48 48 48h224v42a6 6 0 0 1-6 6zm96-96H150a6 6 0 0 1-6-6V54a6 6 0 0 1 6-6h308a6 6 0 0 1 6 6v308a6 6 0 0 1-6 6z"></path></svg>',
        'fa-chevron-right' : 'class="svg-inline--fa fa-chevron-right fa-w-10" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"></path></svg>',
        'fa-chevron-left' : 'class="svg-inline--fa fa-chevron-left fa-w-10" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="chevron-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"></path></svg>',
        'fa-share' : 'class="svg-inline--fa fa-share fa-w-16" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="share" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M503.691 189.836L327.687 37.851C312.281 24.546 288 35.347 288 56.015v80.053C127.371 137.907 0 170.1 0 322.326c0 61.441 39.581 122.309 83.333 154.132 13.653 9.931 33.111-2.533 28.077-18.631C66.066 312.814 132.917 274.316 288 272.085V360c0 20.7 24.3 31.453 39.687 18.164l176.004-152c11.071-9.562 11.086-26.753 0-36.328z"></path></svg>',
        'fa-times' : 'class="svg-inline--fa fa-times fa-w-12" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M323.1 441l53.9-53.9c9.4-9.4 9.4-24.5 0-33.9L279.8 256l97.2-97.2c9.4-9.4 9.4-24.5 0-33.9L323.1 71c-9.4-9.4-24.5-9.4-33.9 0L192 168.2 94.8 71c-9.4-9.4-24.5-9.4-33.9 0L7 124.9c-9.4 9.4-9.4 24.5 0 33.9l97.2 97.2L7 353.2c-9.4 9.4-9.4 24.5 0 33.9L60.9 441c9.4 9.4 24.5 9.4 33.9 0l97.2-97.2 97.2 97.2c9.3 9.3 24.5 9.3 33.9 0z"></path></svg>',
        'fa-envelope' : 'class="svg-inline--fa fa-envelope fa-w-16" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"></path></svg>',
        'fa-edit' : 'class="svg-inline--fa fa-edit fa-w-18" aria-hidden="true" data-fa-processed="" data-prefix="far" data-icon="edit" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1.8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z"></path></svg>',
        'fa-arrows-alt' : 'class="svg-inline--fa fa-arrows-alt fa-w-16" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="arrows-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M352.201 425.775l-79.196 79.196c-9.373 9.373-24.568 9.373-33.941 0l-79.196-79.196c-15.119-15.119-4.411-40.971 16.971-40.97h51.162L228 284H127.196v51.162c0 21.382-25.851 32.09-40.971 16.971L7.029 272.937c-9.373-9.373-9.373-24.569 0-33.941L86.225 159.8c15.119-15.119 40.971-4.411 40.971 16.971V228H228V127.196h-51.23c-21.382 0-32.09-25.851-16.971-40.971l79.196-79.196c9.373-9.373 24.568-9.373 33.941 0l79.196 79.196c15.119 15.119 4.411 40.971-16.971 40.971h-51.162V228h100.804v-51.162c0-21.382 25.851-32.09 40.97-16.971l79.196 79.196c9.373 9.373 9.373 24.569 0 33.941L425.773 352.2c-15.119 15.119-40.971 4.411-40.97-16.971V284H284v100.804h51.23c21.382 0 32.09 25.851 16.971 40.971z"></path></svg>',
        'fa-check-circle' : 'class="svg-inline--fa fa-check-circle fa-w-16" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="check-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path></svg>',
        'fa-ban' : 'class="svg-inline--fa fa-ban fa-w-16" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="ban" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119.034 8 8 119.033 8 256s111.034 248 248 248 248-111.034 248-248S392.967 8 256 8zm130.108 117.892c65.448 65.448 70 165.481 20.677 235.637L150.47 105.216c70.204-49.356 170.226-44.735 235.638 20.676zM125.892 386.108c-65.448-65.448-70-165.481-20.677-235.637L361.53 406.784c-70.203 49.356-170.226 44.736-235.638-20.676z"></path></svg>',
        'fa-facebook-square' : 'class="svg-inline--fa fa-facebook-square fa-w-14" aria-hidden="true" data-fa-processed="" data-prefix="fab" data-icon="facebook-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M448 80v352c0 26.5-21.5 48-48 48h-85.3V302.8h60.6l8.7-67.6h-69.3V192c0-19.6 5.4-32.9 33.5-32.9H384V98.7c-6.2-.8-27.4-2.7-52.2-2.7-51.6 0-87 31.5-87 89.4v49.9H184v67.6h60.9V480H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48z"></path></svg>',
        'fa-twitter' : 'class="svg-inline--fa fa-twitter fa-w-16" aria-hidden="true" data-fa-processed="" data-prefix="fab" data-icon="twitter" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>',
        'fa-google-plus' : 'class="svg-inline--fa fa-google-plus fa-w-16" aria-hidden="true" data-fa-processed="" data-prefix="fab" data-icon="google-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path fill="currentColor" d="M248 8C111.1 8 0 119.1 0 256s111.1 248 248 248 248-111.1 248-248S384.9 8 248 8zm-70.7 372c-68.8 0-124-55.5-124-124s55.2-124 124-124c31.3 0 60.1 11 83 32.3l-33.6 32.6c-13.2-12.9-31.3-19.1-49.4-19.1-42.9 0-77.2 35.5-77.2 78.1s34.2 78.1 77.2 78.1c32.6 0 64.9-19.1 70.1-53.3h-70.1v-42.6h116.9c1.3 6.8 1.9 13.6 1.9 20.7 0 70.8-47.5 121.2-118.8 121.2zm230.2-106.2v35.5H372v-35.5h-35.5v-35.5H372v-35.5h35.5v35.5h35.2v35.5h-35.2z"></path></svg>',
        'fa-instagram' : 'class="svg-inline--fa fa-instagram fa-w-14" aria-hidden="true" data-fa-processed="" data-prefix="fab" data-icon="instagram" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path></svg>',
        'fa-linkedin' : 'class="svg-inline--fa fa-linkedin fa-w-14" aria-hidden="true" data-fa-processed="" data-prefix="fab" data-icon="linkedin" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"></path></svg>',
        'fa-pinterest' : 'class="svg-inline--fa fa-pinterest fa-w-16" aria-hidden="true" data-fa-processed="" data-prefix="fab" data-icon="pinterest" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path fill="currentColor" d="M496 256c0 137-111 248-248 248-25.6 0-50.2-3.9-73.4-11.1 10.1-16.5 25.2-43.5 30.8-65 3-11.6 15.4-59 15.4-59 8.1 15.4 31.7 28.5 56.8 28.5 74.8 0 128.7-68.8 128.7-154.3 0-81.9-66.9-143.2-152.9-143.2-107 0-163.9 71.8-163.9 150.1 0 36.4 19.4 81.7 50.3 96.1 4.7 2.2 7.2 1.2 8.3-3.3.8-3.4 5-20.3 6.9-28.1.6-2.5.3-4.7-1.7-7.1-10.1-12.5-18.3-35.3-18.3-56.6 0-54.7 41.4-107.6 112-107.6 60.9 0 103.6 41.5 103.6 100.9 0 67.1-33.9 113.6-78 113.6-24.3 0-42.6-20.1-36.7-44.8 7-29.5 20.5-61.3 20.5-82.6 0-19-10.2-34.9-31.4-34.9-24.9 0-44.9 25.7-44.9 60.2 0 22 7.4 36.8 7.4 36.8s-24.5 103.8-29 123.2c-5 21.4-3 51.6-.9 71.2C65.4 450.9 0 361.1 0 256 0 119 111 8 248 8s248 111 248 248z"></path></svg>',
        'fa-spinner' : 'class="svg-inline--fa fa-spinner fa-w-16 fa-pulse" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="spinner" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z"></path></svg>',
        'fa-spin' : 'class="svg-inline--fa fa-spin fa-w-16 fa-pulse" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="spinner" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z"></path></svg>',
        'fa-times' : 'class="svg-inline--fa fa-times fa-w-16" aria-hidden="true" data-fa-processed="" data-prefix="fas" data-icon="times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z" class=""></path></svg>'
    };

    function sbEncodeHTML(raw) {
        // make sure passed variable is defined
        if (typeof raw === 'undefined') {
            return '';
        }
        // replace greater than and less than symbols with html entity to disallow html in comments
        var encoded = raw.replace(/(>)/g,'&gt;'),
            encoded = encoded.replace(/(<)/g,'&lt;');
            encoded = encoded.replace(/(&lt;br\/&gt;)/g,'<br>');
        encoded = encoded.replace(/(&lt;br&gt;)/g,'<br>');

        return encoded;
    }

    function sbSVGify(elem) {
        if (sb_instagram_js_options.font_method != 'fontfile') {

            if (typeof elem === 'undefined') {
                elem = jQuery('.sbi');
            }

            // loop through each matched html element based on the passed context
            elem.each(function() {
                jQuery(this).find('i.fa').each(function() {
                    // preserve any classes or styles attached to icons
                    var faClass = jQuery(this).attr('class').match(/fa-[a-z-]+/),
                        styles = jQuery(this).attr('style');
                    if (faClass && typeof sbIconSVG[faClass[0]] !== 'undefined') {
                        var theStyle = typeof styles !== 'undefined' ? 'style="'+styles+'" ' : '';
                        jQuery(this).replaceWith('<svg '+theStyle+sbIconSVG[faClass[0]]);
                    } else {
                        console.log(faClass,'missing');
                    }
                })
            });
        }
    }

    // add links to page
    var addLinks={regexString:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",hashtags:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=addLinks._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this.regexString.charAt(s)+this.regexString.charAt(o)+this.regexString.charAt(u)+this.regexString.charAt(a)}return t},handles:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this.regexString.indexOf(e.charAt(f++));o=this.regexString.indexOf(e.charAt(f++));u=this.regexString.indexOf(e.charAt(f++));a=this.regexString.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=addLinks._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
    function addLinksToPage(s) {
        if ( (s.match(/\./g) || []).length === 2) {
            return s;
        }
        var a = s.split('.'),
            b = a[0],
            c = addLinks.handles(a[1]),
            d = addLinks.handles(a[2]+a[3]);

        return b+'.'+c+'.'+d;
    }

    /* Lightbox v2.7.1 by Lokesh Dhakar - http://lokeshdhakar.com/projects/lightbox2/ - Heavily modified specifically for this plugin */
    (function() {
        var a = jQuery,
            b = function() {
                function a() {
                    this.fadeDuration = 400, this.fitImagesInViewport = !0, this.resizeDuration = 400, this.positionFromTop = 50, this.showImageNumberLabel = !0, this.alwaysShowNavOnTouchDevices = !1, this.wrapAround = !1
                }
                return a.prototype.albumLabel = function(a, b) {
                    return a + " / " + b
                }, a
            }(),
            c = function() {
                function b(a) {
                    this.options = a, this.album = [], this.currentImageIndex = void 0, this.init()
                }
                return b.prototype.init = function() {
                    this.enable(), this.build()
                }, b.prototype.enable = function() {
                    var b = this;
                    a("body").on("click", "a[data-lightbox-sbi]", function(c) {
                        return b.start(a(c.currentTarget)), !1
                    })
                }, b.prototype.build = function() {
                    var b = this,
                        sbLbCarouselDestroy = function() {
                            jQuery('#sbi_lightbox .sbi_lb_lightbox-image').remove();
                            if (jQuery('#sbi_lightbox .sbi_lb-image-wrap').length)  {
                                jQuery('#sbi_lightbox .sbi_lb-image-wrap').sbiOwlCarousel('destroy');
                                jQuery('#sbi_lightbox .sbi-owl-item').remove();
                            }
                            jQuery('#sbi_lightbox').find('video').remove();
                            jQuery('.sbi_lb-container').prepend("<video class='sbi_video' src='' poster='' controls></video>");
                        };
                    a("<div id='sbi_lightboxOverlay' class='sbi_lightboxOverlay'></div>" +
                        "<div id='sbi_lightbox' class='sbi_lightbox'>" +
                        "<div class='sbi_lb-outerContainer'>" +
                        "<div class='sbi_lb-nav'><a class='sbi_lb-prev' href='#' ><p class='sbi-screenreader'>Previous Slide</p><span></span></a><a class='sbi_lb-next' href='#' ><p class='sbi-screenreader'>Next Slide</p><span></span></a></div>" +
                        "<div class='sbi_lb-container-wrapper'>" +
                        "<div class='sbi_lb-container'>" +
                        "<div class='sbi_lb-image-wrap-outer'>" +
                        "<div class='sbi_lb-image-wrap'>" +
                        "<img class='sbi_lb-image' src='' alt='Lightbox image placeholder'/>" +
                        "</div>" +
                        "</div>" +
                        "<div class='sbi_lb-loader'><i class='fa fa-spin'></i></div>" +
                        "</div>" +
                        "<div class='sbi_lb-dataContainer'>" +
                        "<div class='sbi_lb-data'>" +
                        "<div class='sbi_lb-details'>" +
                        "<span class='sbi_lb-caption'></span>" +
                        "<span class='sbi_lb-number'></span>" +
                        "<div class='sbi_lightbox_action sbi_share'><a href='JavaScript:void(0);'><i class='fa fa-share'></i>"+sbiTranslate('Share')+"</a><p class='sbi_lightbox_tooltip sbi_tooltip_social'><a href='' target='_blank' id='sbi_facebook_icon'><span class='sbi-screenreader'>Facebook</span><i class='fa fa-facebook-square'></i></a><a href='' target='_blank' id='sbi_twitter_icon'><span class='sbi-screenreader'>Twitter</span><i class='fa fa-twitter'></i></a><a href='' target='_blank' id='sbi_google_icon'><span class='sbi-screenreader'>Google Plus</span><i class='fa fa-google-plus'></i></a><a href='' target='_blank' id='sbi_linkedin_icon'><span class='sbi-screenreader'>Linkedin</span><i class='fa fa-linkedin'></i></a><a href='' id='sbi_pinterest_icon' target='_blank'><span class='sbi-screenreader'>Pinterest</span><i class='fa fa-pinterest'></i></a><a href='' id='sbi_email_icon' target='_blank'><span class='sbi-screenreader'>Email</span><i class='fa fa-envelope'></i></a></p></div><div class='sbi_lightbox_action sbi_instagram'><a href='https://instagram.com/' target='_blank'><i class='fa fa-instagram'></i>Instagram</a></div>" +
                        "<div id='sbi_mod_link' class='sbi_lightbox_action'><a href='JavaScript:void(0);'><i class='fa fa-times'></i>Hide photo (admin)</a><p id='sbi_mod_box' class='sbi_lightbox_tooltip'>Add ID to the <strong>Hide Specific Photos</strong> setting: <span id='sbi_photo_id'></span></p></div></div><div class='sbi_lb-closeContainer'><a class='sbi_lb-close'><i class='fa fa-times'></i></a></div></div></div></div>").appendTo(a("body")), this.$lightbox = a("#sbi_lightbox"), this.$overlay = a("#sbi_lightboxOverlay"), this.$outerContainer = this.$lightbox.find(".sbi_lb-outerContainer"), this.$container = this.$lightbox.find(".sbi_lb-container"), this.containerTopPadding = parseInt(this.$container.css("padding-top"), 10), this.containerRightPadding = parseInt(this.$container.css("padding-right"), 10), this.containerBottomPadding = parseInt(this.$container.css("padding-bottom"), 10), this.containerLeftPadding = parseInt(this.$container.css("padding-left"), 10), this.$overlay.hide().on("click", function() {
                        return b.end(), !1
                    }), jQuery(document).on('click', function(event, b, c) {
                        //Fade out the lightbox if click anywhere outside of the two elements defined below
                        if (!jQuery(event.target).closest('.sbi_lb-outerContainer').length) {
                            if (!jQuery(event.target).closest('.sbi_lb-dataContainer').length) {
                                //Fade out lightbox
                                jQuery('#sbi_lightboxOverlay, #sbi_lightbox').fadeOut();
                                //Pause video
                                if( sbi_supports_video() && jQuery('#sbi_lightbox video.sbi_video').length ) jQuery('#sbi_lightbox video.sbi_video')[0].pause();
                                // easiest to destroy carousel and build a new one
                                sbLbCarouselDestroy();
                            }
                        }
                    }), this.$lightbox.hide(),
                        jQuery('#sbi_lightboxOverlay').on("click", function(c) {
                            sbLbCarouselDestroy();
                            if( sbi_supports_video() ) jQuery('#sbi_lightbox video.sbi_video')[0].pause();
                            return "sbi_lightbox" === a(c.target).attr("id") && b.end(), !1
                        }), this.$lightbox.find(".sbi_lb-prev").on("click", function() {
                        sbLbCarouselDestroy();
                        if( sbi_supports_video() ) jQuery('#sbi_lightbox video.sbi_video')[0].pause();
                        return b.changeImage(0 === b.currentImageIndex ? b.album.length - 1 : b.currentImageIndex - 1), !1
                    }), this.$lightbox.find(".sbi_lb-container").hammer().on("swiperight", function() {
                        sbLbCarouselDestroy();
                        if( sbi_supports_video() ) jQuery('#sbi_lightbox video.sbi_video')[0].pause();
                        return b.changeImage(0 === b.currentImageIndex ? b.album.length - 1 : b.currentImageIndex - 1), !1
                    }), this.$lightbox.find(".sbi_lb-next").on("click", function() {
                        sbLbCarouselDestroy();
                        if( sbi_supports_video() ) jQuery('#sbi_lightbox video.sbi_video')[0].pause();
                        return b.changeImage(b.currentImageIndex === b.album.length - 1 ? 0 : b.currentImageIndex + 1), !1
                    }), this.$lightbox.find(".sbi_lb-container").hammer().on("swipeleft", function() {
                        sbLbCarouselDestroy();
                        if( sbi_supports_video() ) jQuery('#sbi_lightbox video.sbi_video')[0].pause();
                        return b.changeImage(b.currentImageIndex === b.album.length - 1 ? 0 : b.currentImageIndex + 1), !1
                    }), this.$lightbox.find(".sbi_lb-loader, .sbi_lb-close").on("click", function() {
                        sbLbCarouselDestroy();
                        if( sbi_supports_video() ) jQuery('#sbi_lightbox video.sbi_video')[0].pause();
                        return b.end(), !1
                    })
                }, b.prototype.start = function(b) {
                    function c(a) {

                        //Get the options for this feed
                        var sbiFeedOptions = a.closest('.sbi').attr('data-options');
                        sbiFeedOptions = jQuery.parseJSON(sbiFeedOptions);
                        
                        var carouselData = -1;
                        if(a.attr("data-carousel").length > 1) carouselData = jQuery.parseJSON(a.attr("data-carousel"));
                        if (!carouselData) {
                            carouselData = {};
                        }

                        d.album.push({
                            link: a.attr("href"),
                            title: a.attr("data-title") || a.attr("title"),
                            video: a.attr("data-video"),
                            id: a.attr("data-id"),
                            url: a.attr("data-url"),
                            user: a.attr("data-user"),
                            avatar: a.attr("data-avatar"),
                            lightboxcomments: sbiFeedOptions.lightboxcomments,
                            numcomments: sbiFeedOptions.numcomments,
                            carousel: carouselData,
                            feedID: sbiFeedOptions.feedID,
                            mid: sbiFeedOptions.mid,
                            callback: sbiFeedOptions.callback,
                            type: sbiFeedOptions.type
                        });

                    }
                    var d = this,
                        e = a(window);
                    e.on("resize", a.proxy(this.sizeOverlay, this)), a("select, object, embed").css({
                        visibility: "hidden"
                    }), this.sizeOverlay(), this.album = [];
                    var f, g = 0,
                        h = b.attr("data-lightbox-sbi");
                    if (h) {
                        f = a(b.prop("tagName") + '[data-lightbox-sbi="' + h + '"]');
                        for (var i = 0; i < f.length; i = ++i) c(a(f[i])), f[i] === b[0] && (g = i)
                    } else if ("lightbox" === b.attr("rel")) c(b);
                    else {
                        f = a(b.prop("tagName") + '[rel="' + b.attr("rel") + '"]');
                        for (var j = 0; j < f.length; j = ++j) c(a(f[j])), f[j] === b[0] && (g = j)
                    }
                    var k = e.scrollTop() + this.options.positionFromTop,
                        l = e.scrollLeft();
                    this.$lightbox.css({
                        top: k + "px",
                        left: l + "px"
                    }).fadeIn(this.options.fadeDuration), this.changeImage(g)
                }, b.prototype.changeImage = function(b) {
                    var c = this;
                    this.disableKeyboardNav();
                    var d = this.$lightbox.find(".sbi_lb-image");
                    this.$overlay.fadeIn(this.options.fadeDuration), a(".sbi_lb-loader").fadeIn("slow"), this.$lightbox.find(".sbi_lb-image, .sbi_lb-nav, .sbi_lb-prev, .sbi_lb-next, .sbi_lb-dataContainer, .sbi_lb-numbers, .sbi_lb-caption").hide(), this.$outerContainer.addClass("animating");
                    var e = new Image;
                    e.onload = function() {

                        //If this feed has lightbox comments enabled then add room for the sidebar
                        var sbi_lb_comments_width = 0,
                            sbiNavArrowsWidth = 0;
                        if((jQuery('.sbi').attr('data-sbi-lb-comments') === 'true') && window.innerWidth > 640) {
                            sbi_lb_comments_width = 300;
                        }
                        if(window.innerWidth < (740 + sbi_lb_comments_width) && window.innerWidth > 640) {
                            sbiNavArrowsWidth = 100;
                        }

                            var f, g, h, i, j, k, l;
                        d.attr("src", c.album[b].link), f = a(e), d.width(e.width), d.height(e.height), c.options.fitImagesInViewport && (l = a(window).width(), k = a(window).height(), j = l - c.containerLeftPadding - c.containerRightPadding - 20 - sbi_lb_comments_width - sbiNavArrowsWidth, i = k - c.containerTopPadding - c.containerBottomPadding - 150, (e.width > j || e.height > i) && (e.width / j > e.height / i ? (h = j, g = parseInt(e.height / (e.width / h), 10), d.width(h), d.height(g)) : (g = i, h = parseInt(e.width / (e.height / g), 10), d.width(h), d.height(g)))), c.sizeContainer(d.width(), d.height())
                    }, e.src = this.album[b].link, this.currentImageIndex = b
                }, b.prototype.sizeOverlay = function() {
                    this.$overlay.width(a(window).width()).height(a(document).height())
                }, b.prototype.sizeContainer = function(a, b) {
                    function c() {
                        d.$lightbox.find(".sbi_lb-dataContainer").width(g), d.$lightbox.find(".sbi_lb-prevLink").height(h), d.$lightbox.find(".sbi_lb-nextLink").height(h), d.showImage()
                    }
                    var d = this,
                        e = this.$outerContainer.outerWidth(),
                        f = this.$outerContainer.outerHeight(),
                        g = a + this.containerLeftPadding + this.containerRightPadding,
                        h = b + this.containerTopPadding + this.containerBottomPadding;
                    e !== g || f !== h ? this.$outerContainer.animate({
                        width: g,
                        height: h
                    }, this.options.resizeDuration, "swing", function() {
                        c()
                    }) : c()
                }, b.prototype.showImage = function() {
                    this.$lightbox.find(".sbi_lb-loader").hide(), this.$lightbox.find(".sbi_lb-image").fadeIn("slow"), this.updateNav(), this.updateDetails(), this.preloadNeighboringImages(), this.enableKeyboardNav()
                }, b.prototype.updateNav = function() {
                    var a = !1;
                    try {
                        document.createEvent("TouchEvent"), a = this.options.alwaysShowNavOnTouchDevices ? !0 : !1
                    } catch (b) {}
                    this.$lightbox.find(".sbi_lb-nav").show(), this.album.length > 1 && (this.options.wrapAround ? (a && this.$lightbox.find(".sbi_lb-prev, .sbi_lb-next").css("opacity", "1"), this.$lightbox.find(".sbi_lb-prev, .sbi_lb-next").show()) : (this.currentImageIndex > 0 && (this.$lightbox.find(".sbi_lb-prev").show(), a && this.$lightbox.find(".sbi_lb-prev").css("opacity", "1")), this.currentImageIndex < this.album.length - 1 && (this.$lightbox.find(".sbi_lb-next").show(), a && this.$lightbox.find(".sbi_lb-next").css("opacity", "1"))))
                }, b.prototype.updateDetails = function() {
                    var b = this;
                    /** NEW PHOTO ACTION **/
                    //Switch video when either a new popup or navigating to new one
                    if( sbi_supports_video() ){
                        jQuery('#sbi_lightbox').removeClass('sbi_video_lightbox');
                        if( this.album[this.currentImageIndex].video.length ){
                            jQuery('#sbi_lightbox').addClass('sbi_video_lightbox');
                            // video created on the fly to prevent issue with safari not playing videos
                            if( jQuery('.sbi_lightbox .sbi_video').length == 0 ) {
                                jQuery('.sbi_lb-container').prepend("<video class='sbi_video' src='"+this.album[this.currentImageIndex].video+"' poster='"+this.album[this.currentImageIndex].link+"' controls autoplay></video>");
                            } else {
                                jQuery('.sbi_video').attr({
                                    'src' : this.album[this.currentImageIndex].video,
                                    'poster' : this.album[this.currentImageIndex].link,
                                    'autoplay' : 'true'
                                });
                            }
                        } else {
                            jQuery('.sbi_lb-container .sbi_video').remove();
                        }
                    }

                    // hide video initially to prevent jerkiness until it's fully loaded
                    jQuery('.sbi_video').css('opacity','0');
                    jQuery('#sbi_lightbox .sbi_instagram a').attr('href', this.album[this.currentImageIndex].url);
                    jQuery('#sbi_lightbox .sbi_lightbox_tooltip').hide();
                    jQuery('#sbi_lightbox #sbi_mod_box').find('#sbi_photo_id').text( this.album[this.currentImageIndex].id );
                    //Change social media sharing links on the fly
                    jQuery('#sbi_lightbox #sbi_facebook_icon').attr('href', 'https://www.facebook.com/sharer/sharer.php?u=' + this.album[this.currentImageIndex].url+'&t=Text');
                    jQuery('#sbi_lightbox #sbi_twitter_icon').attr('href', 'https://twitter.com/home?status='+this.album[this.currentImageIndex].url+' ' + this.album[this.currentImageIndex].title);
                    jQuery('#sbi_lightbox #sbi_google_icon').attr('href', 'https://plus.google.com/share?url='+this.album[this.currentImageIndex].url);
                    jQuery('#sbi_lightbox #sbi_linkedin_icon').attr('href', 'https://www.linkedin.com/shareArticle?mini=true&url='+this.album[this.currentImageIndex].url+'&title='+this.album[this.currentImageIndex].title);
                    jQuery('#sbi_lightbox #sbi_pinterest_icon').attr('href', 'https://pinterest.com/pin/create/button/?url='+this.album[this.currentImageIndex].url+'&media='+this.album[this.currentImageIndex].link+'&description='+this.album[this.currentImageIndex].title);
                    jQuery('#sbi_lightbox #sbi_email_icon').attr('href', 'mailto:?subject=Instagram&body='+this.album[this.currentImageIndex].title+' '+this.album[this.currentImageIndex].url);
                    jQuery('.sbi_lb-container-wrapper').find('.fa-clone').remove();

                    // carousel in lightbox
                    if( this.album[this.currentImageIndex].carousel !== '' && typeof this.album[this.currentImageIndex].carousel[0] !== 'undefined' ) {
                        var wrapEl = jQuery('.sbi_lb-image-wrap'),
                            styles = jQuery('.sbi_lb-image').attr('style') + 'opacity: 1 !important',
                            thisPoster = this.album[this.currentImageIndex].link,
                            thisStartsWithVideo = (this.album[this.currentImageIndex].carousel[0].type == 'video'),
                            thisVideoUrl = '';

                        jQuery.each(this.album[this.currentImageIndex].carousel,function(index,value) {
                            if (index > 0) {
                                if (value.type === 'image') {
                                    wrapEl.append('<img class="sbi_lb-image sbi_lb_lightbox-image" src="'+value.media+'" style="'+styles+'" alt="Lightbox Image"/>');
                                } else if (sbi_supports_video() && value.type === 'video') {
                                    wrapEl.append( '<video class="sbi_video sbi_lb_lightbox-image sbi_lb_lightbox-carousel-video added" src="'+value.media+'" style="'+styles+'" poster="'+thisPoster+'" controls="" autoplay="autoplay"></video>');
                                }
                            }
                        });
                        jQuery('.sbi_lb-image-wrap-outer').prepend('<i class="fa fa-clone sbi_lightbox_carousel_icon" aria-hidden="true"></i>');

                        wrapEl.sbiOwlCarousel({
                            items: 1,
                            rewind: true,
                            nav: true,
                            navText: ['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
                            dots: true,
                            autoPlay: false,
                            stopOnHover: true,
                            onInitialized :function(el) {

                                if(thisStartsWithVideo) {
                                    jQuery('.sbi_lb-image-wrap').find('.sbi-owl-item').first().find('img').before( jQuery('#sbi_lightbox .sbi_video').first() );
                                    jQuery('#sbi_lightbox .sbi_video').first().get(0).play();
                                }

                            },
                            onChanged :function(el) {
                                var $owlCarousel = jQuery(el.target),
                                    $maybeVideo = $owlCarousel.find('.sbi-owl-item:eq('+el.item.index+')').find('.sbi_video');

                                if($owlCarousel.find('.sbi_video').length) {
                                    $owlCarousel.find('.sbi_video').each(function() {
                                        jQuery(this).get(0).pause();
                                    });
                                }

                                if ($maybeVideo.length) {
                                    $maybeVideo.get(0).play();
                                }

                            }
                        });

                        var $navElementsWrapper = wrapEl.find('.sbi-owl-buttons');
                        if (window.width > 640) {
                            $navElementsWrapper.addClass('onhover').hide();
                            wrapEl.on({
                                mouseenter: function () {
                                    $navElementsWrapper.fadeIn();
                                },
                                mouseleave: function () {
                                    $navElementsWrapper.fadeOut();
                                }
                            });
                        }

                    }
                    // fade video back in after a slight delay
                    setTimeout(function(){
                        jQuery('.sbi_video').css('opacity','1');
                    },500);
                    //clear mailto links
                    setTimeout(function(){
                        jQuery(".sbi_lb-caption").find('a[href^="mailto:"]').each(function() {
                            jQuery(this).replaceWith(jQuery(this).text());
                        });
                    },101);

                    sbSVGify(jQuery('#sbi_lightbox'));
                    //start by removing any existing comments
                    jQuery('.sbi_lb-commentBox').remove();
                    // check to see if comments are enabled for this feed
                    if((this.album[this.currentImageIndex].lightboxcomments === 'true' || this.album[this.currentImageIndex].lightboxcomments === true) && this.album[this.currentImageIndex].numcomments > 0) {
                        var sbiComments = {
                            postID: '',
                            thisAlbum: this.album[this.currentImageIndex],
                            maxNumComments: this.album[this.currentImageIndex].numcomments,
                            disableCache: (this.album[this.currentImageIndex].disablecache || this.album[this.currentImageIndex].disablecache === 'true'),
                            numCommentsOnPage: parseInt(jQuery('#'+this.album[this.currentImageIndex].id).find('.sbi_comments').text().replace(',', '')), // number of comments for this specific post, grabbed from feed html
                            commentObj: [],

                            getRemoteComments: function (missing) {
                                var accessTokens = [],
                                    userIDs = [],
                                    postIDParts = this.postID.split('_'),
                                    feedID = postIDParts[ postIDParts.length-1 ],
                                    commentAccessToken = false;

                                // get correct access token for comments that are being retrieved
                                if (typeof this.thisAlbum.feedID !== 'undefined') {
                                    var startArr = this.thisAlbum.feedID.split(','),
                                        midArr = this.thisAlbum.mid.split(','),
                                        lastArr = this.thisAlbum.callback.split(',');
                                    jQuery.each(startArr, function(index) {
                                        accessTokens.push(startArr[index] + '.' + midArr[index] + '.' + lastArr[index]);
                                        userIDs.push(startArr[index]);
                                        if (startArr[index] === feedID) {
                                            commentAccessToken = accessTokens[index];
                                        }
                                    });

                                }

                                if (!commentAccessToken) {
                                    commentAccessToken = sb_instagram_js_options.sb_instagram_at.indexOf(feedID) > -1 ? sb_instagram_js_options.sb_instagram_at : false;
                                }

                                // only attempt to retrieve comments if we have a valid access token for them
                                if (commentAccessToken) {
                                    var cleanId = this.postID.replace('sbi_',''),
                                        at = addLinksToPage(commentAccessToken),
                                        url = 'https://api.instagram.com/v1/media/' + cleanId + '/comments?access_token=' + at;
                                    jQuery.ajax({
                                        method: "GET",
                                        url: url,
                                        dataType: "jsonp",
                                        success: function(data) {
                                            sbiComments.commentObj = data.data;
                                            var toBeCached = [];
                                            jQuery.each(sbiComments.commentObj, function() {
                                                var comment = {
                                                    created_time: this.created_time,
                                                    id: this.id,
                                                    text: this.text,
                                                    user_name: this.from.username
                                                };
                                                toBeCached.push(comment);
                                            });
                                            if ( typeof sb_instagram_js_options.sbiPageCommentCache === 'undefined' ) {
                                                sb_instagram_js_options.sbiPageCommentCache = [];
                                            }
                                            sb_instagram_js_options.sbiPageCommentCache[cleanId] = [toBeCached, new Date().getTime() / 1000 + 100*60,sbiComments.numCommentsOnPage];

                                            if(missing !== 'all') {
                                                sbiComments.replaceWithNewComments(sb_instagram_js_options.sbiPageCommentCache[cleanId][0]);
                                            } else {
                                                sbiComments.appendExistingComments();
                                            }
                                            if (!sbiComments.disableCache && window.sbiStandalone.noDB !== true) {
                                                sbiComments.cacheComments(toBeCached, sbiComments.numCommentsOnPage);
                                            }
                                        }
                                    });
                                }

                            },
                            getCommentHtml: function (comment) {
                                var comHtml = '',
                                    comText = comment.text.replace(/(\\')/g,"'").replace(/(\\")/g,'"');

                                comHtml += '<p class="sbi_lb-comment" id="sbi_com_'+comment.id+'" data-sbi-created="'+comment.created_time+'">';
                                comHtml += '<a class="sbi_lb-commenter" href="https://www.instagram.com/'+sbEncodeHTML(comment.user_name)+'/" target="_blank">'+sbEncodeHTML(comment.user_name)+'</a>';
                                comHtml += '<span class="sbi_lb-comment-text">'+sbEncodeHTML(comText)+'</span>';
                                comHtml += '</p>';

                                return comHtml;
                            },
                            appendExistingComments: function () {
                                var cleanId = this.postID.replace('sbi_',''),
                                    comments = sb_instagram_js_options.sbiPageCommentCache[cleanId][0],
                                    fifteenMinutesFromLastCache = sb_instagram_js_options.sbiPageCommentCache[cleanId][1],
                                    nowInSeconds = new Date().getTime() / 1000,
                                    maxNumComments = parseInt(this.maxNumComments),
                                    commentsNeeded = sbiComments.numCommentsOnPage - parseInt(sb_instagram_js_options.sbiPageCommentCache[cleanId][2]);

                                var loadingHTML = '';
                                // every time the comment cache is updated, a time 15 minutes in the future is also included in the saved data
                                // this checks to see if it's been at least 15 minutes since new comments were cached
                                if (fifteenMinutesFromLastCache > nowInSeconds) {
                                    commentsNeeded = 0;
                                } else {
                                    if (commentsNeeded > 0) {
                                        loadingHTML = '<p class="sbi_loading_comments"><i class="fa fa-spinner fa-pulse"></i></p>';
                                        sbiComments.getRemoteComments();
                                    }
                                }
                                var comsHtml = '';
                                //check to see if there is at least one comment to use
                                if (typeof comments[0] !== 'undefined') {
                                    comsHtml += '<div class="sbi_lb-commentBox">';
                                    var lastIndex = -1;
                                    // grab the maximum number of latest tweets available without going over the max
                                    if ((comments.length + commentsNeeded) < maxNumComments) {
                                        lastIndex = 0 - comments.length;
                                    } else if ((maxNumComments - commentsNeeded) > 0) {
                                        lastIndex = 0 - (maxNumComments - commentsNeeded);
                                    }
                                    // only append existing comments if there are less new comments than the max
                                    if (commentsNeeded < maxNumComments) {
                                        comments = comments.slice(lastIndex);
                                        jQuery.each(comments, function() {
                                            comsHtml += sbiComments.getCommentHtml(this);
                                        });
                                    }
                                    // let the visitor know that more comments are coming
                                    comsHtml += loadingHTML;
                                    comsHtml += '</div>';
                                    jQuery('.sbi_lb-dataContainer').append(comsHtml);
                                }
                            },
                            replaceWithNewComments: function (comments) {
                                var comsHtml = '',
                                    lastIndex = Math.max((0 - parseInt(this.maxNumComments)), (0 - comments.length)),
                                    newComments = comments.slice(lastIndex);

                                jQuery.each(newComments, function() {
                                    comsHtml += sbiComments.getCommentHtml(this);
                                });
                                jQuery('.sbi_lb-commentBox').html(comsHtml);
                            },
                            cacheComments: function (comments, totalComments) {
                                var submittedData = {
                                    'action': 'sbi_update_comment_cache',
                                    'post_id': this.postID,
                                    'comments': comments,
                                    'total_comments': totalComments
                                };

                                jQuery.ajax({
                                    url: sbiajaxurl,
                                    type: 'post',
                                    data: submittedData,
                                    success: function(data) {
                                    }
                                }); // ajax*/
                            }
                        };

                        function sbiCommentsInit(id) {
                            // set the id of the current post in the lightbox
                            sbiComments.postID = id;
                            // append comments localized for this feed that apply to this post, otherwise retrieve new comments and use those
                            if (sb_instagram_js_options.sbiPageCommentCache && sb_instagram_js_options.sbiPageCommentCache.hasOwnProperty(sbiComments.postID.replace('sbi_',''))) {
                                sbiComments.appendExistingComments();
                            } else {
                                sbiComments.getRemoteComments('all');
                            }
                        }

                        // wait until the comments object is done being retrieved before displaying comments
                        if (typeof this.album[this.currentImageIndex].id !== 'undefined') {
                            sbiCommentsInit(this.album[this.currentImageIndex].id);
                        } else {
                            setTimeout(function() {
                                if (typeof this.album[this.currentImageIndex].id !== 'undefined') {
                                    sbiCommentsInit(this.album[this.currentImageIndex].id);
                                }
                            },500);
                        }
                    }

                    //Add links to the caption
                    var sbiLightboxCaption = sbEncodeHTML(this.album[this.currentImageIndex].title),
                        hashRegex = /(^|\s)#(\w[\u0041-\u005A\u0061-\u007A\u00AA\u00B5\u00BA\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02C1\u02C6-\u02D1\u02E0-\u02E4\u02EC\u02EE\u0370-\u0374\u0376\u0377\u037A-\u037D\u0386\u0388-\u038A\u038C\u038E-\u03A1\u03A3-\u03F5\u03F7-\u0481\u048A-\u0527\u0531-\u0556\u0559\u0561-\u0587\u05D0-\u05EA\u05F0-\u05F2\u0620-\u064A\u066E\u066F\u0671-\u06D3\u06D5\u06E5\u06E6\u06EE\u06EF\u06FA-\u06FC\u06FF\u0710\u0712-\u072F\u074D-\u07A5\u07B1\u07CA-\u07EA\u07F4\u07F5\u07FA\u0800-\u0815\u081A\u0824\u0828\u0840-\u0858\u08A0\u08A2-\u08AC\u0904-\u0939\u093D\u0950\u0958-\u0961\u0971-\u0977\u0979-\u097F\u0985-\u098C\u098F\u0990\u0993-\u09A8\u09AA-\u09B0\u09B2\u09B6-\u09B9\u09BD\u09CE\u09DC\u09DD\u09DF-\u09E1\u09F0\u09F1\u0A05-\u0A0A\u0A0F\u0A10\u0A13-\u0A28\u0A2A-\u0A30\u0A32\u0A33\u0A35\u0A36\u0A38\u0A39\u0A59-\u0A5C\u0A5E\u0A72-\u0A74\u0A85-\u0A8D\u0A8F-\u0A91\u0A93-\u0AA8\u0AAA-\u0AB0\u0AB2\u0AB3\u0AB5-\u0AB9\u0ABD\u0AD0\u0AE0\u0AE1\u0B05-\u0B0C\u0B0F\u0B10\u0B13-\u0B28\u0B2A-\u0B30\u0B32\u0B33\u0B35-\u0B39\u0B3D\u0B5C\u0B5D\u0B5F-\u0B61\u0B71\u0B83\u0B85-\u0B8A\u0B8E-\u0B90\u0B92-\u0B95\u0B99\u0B9A\u0B9C\u0B9E\u0B9F\u0BA3\u0BA4\u0BA8-\u0BAA\u0BAE-\u0BB9\u0BD0\u0C05-\u0C0C\u0C0E-\u0C10\u0C12-\u0C28\u0C2A-\u0C33\u0C35-\u0C39\u0C3D\u0C58\u0C59\u0C60\u0C61\u0C85-\u0C8C\u0C8E-\u0C90\u0C92-\u0CA8\u0CAA-\u0CB3\u0CB5-\u0CB9\u0CBD\u0CDE\u0CE0\u0CE1\u0CF1\u0CF2\u0D05-\u0D0C\u0D0E-\u0D10\u0D12-\u0D3A\u0D3D\u0D4E\u0D60\u0D61\u0D7A-\u0D7F\u0D85-\u0D96\u0D9A-\u0DB1\u0DB3-\u0DBB\u0DBD\u0DC0-\u0DC6\u0E01-\u0E30\u0E32\u0E33\u0E40-\u0E46\u0E81\u0E82\u0E84\u0E87\u0E88\u0E8A\u0E8D\u0E94-\u0E97\u0E99-\u0E9F\u0EA1-\u0EA3\u0EA5\u0EA7\u0EAA\u0EAB\u0EAD-\u0EB0\u0EB2\u0EB3\u0EBD\u0EC0-\u0EC4\u0EC6\u0EDC-\u0EDF\u0F00\u0F40-\u0F47\u0F49-\u0F6C\u0F88-\u0F8C\u1000-\u102A\u103F\u1050-\u1055\u105A-\u105D\u1061\u1065\u1066\u106E-\u1070\u1075-\u1081\u108E\u10A0-\u10C5\u10C7\u10CD\u10D0-\u10FA\u10FC-\u1248\u124A-\u124D\u1250-\u1256\u1258\u125A-\u125D\u1260-\u1288\u128A-\u128D\u1290-\u12B0\u12B2-\u12B5\u12B8-\u12BE\u12C0\u12C2-\u12C5\u12C8-\u12D6\u12D8-\u1310\u1312-\u1315\u1318-\u135A\u1380-\u138F\u13A0-\u13F4\u1401-\u166C\u166F-\u167F\u1681-\u169A\u16A0-\u16EA\u1700-\u170C\u170E-\u1711\u1720-\u1731\u1740-\u1751\u1760-\u176C\u176E-\u1770\u1780-\u17B3\u17D7\u17DC\u1820-\u1877\u1880-\u18A8\u18AA\u18B0-\u18F5\u1900-\u191C\u1950-\u196D\u1970-\u1974\u1980-\u19AB\u19C1-\u19C7\u1A00-\u1A16\u1A20-\u1A54\u1AA7\u1B05-\u1B33\u1B45-\u1B4B\u1B83-\u1BA0\u1BAE\u1BAF\u1BBA-\u1BE5\u1C00-\u1C23\u1C4D-\u1C4F\u1C5A-\u1C7D\u1CE9-\u1CEC\u1CEE-\u1CF1\u1CF5\u1CF6\u1D00-\u1DBF\u1E00-\u1F15\u1F18-\u1F1D\u1F20-\u1F45\u1F48-\u1F4D\u1F50-\u1F57\u1F59\u1F5B\u1F5D\u1F5F-\u1F7D\u1F80-\u1FB4\u1FB6-\u1FBC\u1FBE\u1FC2-\u1FC4\u1FC6-\u1FCC\u1FD0-\u1FD3\u1FD6-\u1FDB\u1FE0-\u1FEC\u1FF2-\u1FF4\u1FF6-\u1FFC\u2071\u207F\u2090-\u209C\u2102\u2107\u210A-\u2113\u2115\u2119-\u211D\u2124\u2126\u2128\u212A-\u212D\u212F-\u2139\u213C-\u213F\u2145-\u2149\u214E\u2183\u2184\u2C00-\u2C2E\u2C30-\u2C5E\u2C60-\u2CE4\u2CEB-\u2CEE\u2CF2\u2CF3\u2D00-\u2D25\u2D27\u2D2D\u2D30-\u2D67\u2D6F\u2D80-\u2D96\u2DA0-\u2DA6\u2DA8-\u2DAE\u2DB0-\u2DB6\u2DB8-\u2DBE\u2DC0-\u2DC6\u2DC8-\u2DCE\u2DD0-\u2DD6\u2DD8-\u2DDE\u2E2F\u3005\u3006\u3031-\u3035\u303B\u303C\u3041-\u3096\u309D-\u309F\u30A1-\u30FA\u30FC-\u30FF\u3105-\u312D\u3131-\u318E\u31A0-\u31BA\u31F0-\u31FF\u3400-\u4DB5\u4E00-\u9FCC\uA000-\uA48C\uA4D0-\uA4FD\uA500-\uA60C\uA610-\uA61F\uA62A\uA62B\uA640-\uA66E\uA67F-\uA697\uA6A0-\uA6E5\uA717-\uA71F\uA722-\uA788\uA78B-\uA78E\uA790-\uA793\uA7A0-\uA7AA\uA7F8-\uA801\uA803-\uA805\uA807-\uA80A\uA80C-\uA822\uA840-\uA873\uA882-\uA8B3\uA8F2-\uA8F7\uA8FB\uA90A-\uA925\uA930-\uA946\uA960-\uA97C\uA984-\uA9B2\uA9CF\uAA00-\uAA28\uAA40-\uAA42\uAA44-\uAA4B\uAA60-\uAA76\uAA7A\uAA80-\uAAAF\uAAB1\uAAB5\uAAB6\uAAB9-\uAABD\uAAC0\uAAC2\uAADB-\uAADD\uAAE0-\uAAEA\uAAF2-\uAAF4\uAB01-\uAB06\uAB09-\uAB0E\uAB11-\uAB16\uAB20-\uAB26\uAB28-\uAB2E\uABC0-\uABE2\uAC00-\uD7A3\uD7B0-\uD7C6\uD7CB-\uD7FB\uF900-\uFA6D\uFA70-\uFAD9\uFB00-\uFB06\uFB13-\uFB17\uFB1D\uFB1F-\uFB28\uFB2A-\uFB36\uFB38-\uFB3C\uFB3E\uFB40\uFB41\uFB43\uFB44\uFB46-\uFBB1\uFBD3-\uFD3D\uFD50-\uFD8F\uFD92-\uFDC7\uFDF0-\uFDFB\uFE70-\uFE74\uFE76-\uFEFC\uFF21-\uFF3A\uFF41-\uFF5A\uFF66-\uFFBE\uFFC2-\uFFC7\uFFCA-\uFFCF\uFFD2-\uFFD7\uFFDA-\uFFDC+0-9_]+)/gi,
                        tagRegex = /[@]+[A-Za-z0-9-_\."<]+/g;
                    if (typeof sbiLightboxCaption !== 'undefined' && sbiLightboxCaption !== '') {
                        sbiLightboxCaption = sbiLightboxCaption.replace(/(>#)/g,'> #');
                    }
                    (sbiLightboxCaption) ? sbiLightboxCaption = sbiLinkify(sbiLightboxCaption) : sbiLightboxCaption = '';

                    //Link #hashtags
                    function sbiReplaceHashtags(hash){
                        //Remove white space at beginning of hash
                        var replacementString = jQuery.trim(hash);
                        //If the hash is a hex code then don't replace it with a link as it's likely in the style attr, eg: "color: #ff0000"
                        if ( /^#[0-9A-F]{6}$/i.test( replacementString ) ){
                            return replacementString;
                        } else {
                            return ' <a href="https://instagram.com/explore/tags/'+ replacementString.substring(1) +'" target="_blank" rel="nofollow">' + replacementString + '</a>';
                        }
                    }
                    sbiLightboxCaption = sbiLightboxCaption.replace( hashRegex , sbiReplaceHashtags );
                    //Link @tags
                    function sbiReplaceTags(tag){
                        var replacementString = jQuery.trim(tag);
                        //If it contains a quote, don't link
                        if (replacementString.indexOf('<br>') == -1 && /["<]+/g.test( replacementString ) ){
                            return replacementString;
                        } else {
                            return ' <a href="https://instagram.com/'+ replacementString.substring(1).replace(/</g,'') +'" target="_blank" rel="nofollow">' + replacementString.replace(/</g,'') + '</a>';
                        }
                    }
                    sbiLightboxCaption = sbiLightboxCaption.replace( tagRegex , sbiReplaceTags );
                    if (typeof sbiLightboxAction === 'function') {
                        setTimeout(function() {
                            sbiLightboxAction();
                        },100);
                    }
                    var avatarImageHtml = '';
                    if (this.album[this.currentImageIndex].avatar !== 'undefined') {
                        avatarImageHtml = '<img src="'+this.album[this.currentImageIndex].avatar+'" />';
                    }
                    this.$lightbox.find(".sbi_lb-caption").html('<a class="sbi_lightbox_username" href="https://instagram.com/'+this.album[this.currentImageIndex].user+'" target="_blank">'+avatarImageHtml+'<p>@'+this.album[this.currentImageIndex].user + '</p></a> ' + sbiLightboxCaption).fadeIn("fast"), this.album.length > 1 && this.options.showImageNumberLabel ? this.$lightbox.find(".sbi_lb-number").text(this.options.albumLabel(this.currentImageIndex + 1, this.album.length)).fadeIn("fast") : this.$lightbox.find(".sbi_lb-number").hide(), this.$outerContainer.removeClass("animating"), this.$lightbox.find(".sbi_lb-dataContainer").fadeIn(this.options.resizeDuration, function() {
                        return b.sizeOverlay()
                    })
                }, b.prototype.preloadNeighboringImages = function() {
                    if (this.album.length > this.currentImageIndex + 1) {
                        var a = new Image;
                        a.src = this.album[this.currentImageIndex + 1].link
                    }
                    if (this.currentImageIndex > 0) {
                        var b = new Image;
                        b.src = this.album[this.currentImageIndex - 1].link
                    }
                }, b.prototype.enableKeyboardNav = function() {
                    a(document).on("keyup.keyboard", a.proxy(this.keyboardAction, this))
                }, b.prototype.disableKeyboardNav = function() {
                    a(document).off(".keyboard")
                }, b.prototype.keyboardAction = function(a) {
                    var sbLbCarouselDestroy = function() {
                            jQuery('.sbi_lightbox_carousel_icon').remove();
                            jQuery('#sbi_lightbox .sbi_lb_lightbox-image, .sbi_lb-image-wrap video').remove();
                            //if (jQuery('#sbi_lightbox .sbi_lb-image-wrap').length)  { //jQuery('.sbi_lb-image-wrap')
                                    jQuery('#sbi_lightbox .sbi_lb-image-wrap').sbiOwlCarousel('destroy');
                                jQuery('#sbi_lightbox .sbi-owl-item').remove();
                            //}
                            };
                    var KEYCODE_ESC        = 27;
                    var KEYCODE_LEFTARROW  = 37;
                    var KEYCODE_RIGHTARROW = 39;

                    var keycode = event.keyCode;
                    var key     = String.fromCharCode(keycode).toLowerCase();
                    if (keycode === KEYCODE_ESC || key.match(/x|o|c/)) {
                        sbLbCarouselDestroy();
                        if( sbi_supports_video() && typeof jQuery('#sbi_lightbox video.sbi_video')[0] !== 'undefined' ) jQuery('#sbi_lightbox video.sbi_video')[0].pause();
                        jQuery('#sbi_lightbox iframe').attr('src', '');
                        sbSVGify(jQuery('#sbi_lightbox'));
                        this.end();
                    } else if (key === 'p' || keycode === KEYCODE_LEFTARROW) {
                        if (this.currentImageIndex !== 0) {
                            this.changeImage(this.currentImageIndex - 1);
                                                    } else if (this.options.wrapAround && this.album.length > 1) {
                            this.changeImage(this.album.length - 1);
                        }
                        sbLbCarouselDestroy();
                        if( sbi_supports_video() ) jQuery('#sbi_lightbox video.sbi_video')[0].pause();
                        sbSVGify(jQuery('#sbi_lightbox'));
                        jQuery('#sbi_lightbox iframe').attr('src', '');

                    } else if (key === 'n' || keycode === KEYCODE_RIGHTARROW) {
                        if (this.currentImageIndex !== this.album.length - 1) {
                            this.changeImage(this.currentImageIndex + 1);
                        } else if (this.options.wrapAround && this.album.length > 1) {
                            this.changeImage(0);
                        }
                        sbLbCarouselDestroy();
                        if( sbi_supports_video() ) jQuery('#sbi_lightbox video.sbi_video')[0].pause();
                        jQuery('#sbi_lightbox iframe').attr('src', '');
                        sbSVGify(jQuery('#sbi_lightbox'));

                    }

                }, b.prototype.end = function() {
                    this.disableKeyboardNav(), a(window).off("resize", this.sizeOverlay), this.$lightbox.fadeOut(this.options.fadeDuration), this.$overlay.fadeOut(this.options.fadeDuration), a("select, object, embed").css({
                        visibility: "visible"
                    })
                }, b
            }();
        a(function() {
            {
                var a = new b;
                new c(a)
            }
        })
    }).call(this);
    //Checks whether browser support HTML5 video element
    function sbi_supports_video() {
        return !!document.createElement('video').canPlayType;
    }

    var modMode = {
        status: false,
        usingDB: true,
        $self: jQuery('.sbi_moderation_mode'), // gets reassigned to current feed
        originalParent: jQuery('.sbi_moderation_mode').parent(),
        hideOrShow: 'hide',
        dbHidePhotos: sb_instagram_js_options.sb_instagram_hide_photos.replace(/ /g,'').split(','),
        dbBlockUsers: sb_instagram_js_options.sb_instagram_block_users.replace(/ /g,'').split(','),
        dbWhiteList: [],
        whiteListIndex: '',
        selectedHide: [], // image ids that are selected
        selectedShow: [],
        selectedUsers: [],
        isPermanent: false,
        isPermanentDb: false,

        setStatus: function (status) {
            this.status = status;
        },
        setPermanent: function (permanent, permanentDb) {
            this.isPermanent = typeof permanent !== 'undefined' ? true : false;
            this.isPermanentDb = typeof permanentDb !== 'undefined' ? true : false;
        },
        setUsingDB: function (usingDB) {
            this.usingDB = usingDB;
        },
        setSelf: function ($self) {
            if ($self.hasClass('sbi')) {
                this.$self = $self;
            } else {
                this.$self = $self.closest('.sbi');
            }
        },
        setOriginalPosition: function () {
            this.originalParent= this.$self.parent();
        },
        updateHideOrShow: function (hideOrShow) {
            this.hideOrShow = hideOrShow;
            modMode.afterTypeChange(hideOrShow);
        },
        afterTypeChange: function (hideOrShow) {
            if (hideOrShow === 'show') {
                jQuery('#sbi_mod_permanent_toggle').closest('.sbi_mod_row').slideDown();
                if (jQuery('#sbi_mod_permanent_toggle').is(':checked') || modMode.isPermanentDb) {
                    jQuery('#sb_mod_is_permanent_warning').slideDown();
                }
            } else {
                jQuery('#sbi_mod_permanent_toggle').closest('.sbi_mod_row').slideUp();
                jQuery('#sb_mod_is_permanent_warning').slideUp();
            }
        },
        mergeDBAndSelected: function () {
            if(!this.$self.hasClass('sbi_mod_merged')) {
                // remove any empty array elements
                for (var i = 0; i < modMode.dbHidePhotos.length; i++) {
                    if (modMode.dbHidePhotos[i] == '') {
                        modMode.dbHidePhotos.splice(i, 1);
                    }
                }
                // add id to array if unique
                for (var i = 0; i < modMode.dbHidePhotos.length; i++) {
                    if (modMode.selectedHide.indexOf(modMode.dbHidePhotos[i].replace('sbi_', '')) == -1) {
                        modMode.selectedHide.push(modMode.dbHidePhotos[i].replace('sbi_', ''));
                    }
                }
                // remove any empty array elements for show
                for (var i = 0; i < modMode.dbWhiteList.length; i++) {
                    if (modMode.dbWhiteList[i] == '') {
                        modMode.dbWhiteList.splice(i, 1);
                    }
                }
                // add id to array if unique
                for (var i = 0; i < modMode.dbWhiteList.length; i++) {
                    if (modMode.selectedShow.indexOf(modMode.dbWhiteList[i].replace('sbi_', '')) == -1) {
                        modMode.selectedShow.push(modMode.dbWhiteList[i].replace('sbi_', ''));
                    }
                }
                // remove any empty array elements
                for (var i = 0; i < modMode.dbBlockUsers.length; i++) {
                    if (modMode.dbBlockUsers[i] == '') {
                        modMode.dbBlockUsers.splice(i, 1)
                    }
                }
                // add blocked user to array if unique
                for (var i = 0; i < modMode.dbBlockUsers.length; i++) {
                    if (modMode.selectedUsers.indexOf(modMode.dbBlockUsers[i]) == -1) {
                        modMode.selectedUsers.push(modMode.dbBlockUsers[i]);
                    }
                }
            }

        },
        setWhiteListData: function(listNum, ids) {
            this.whiteListIndex = listNum;
            this.dbWhiteList = ids.replace(/ /g,'').split(',');
        },
        updateBlockUser: function(checkbox) { //sbi_mod_block_user
            var user = checkbox.val();
            if (checkbox.is(':checked')) {
                if (modMode.selectedUsers.indexOf(user) < 0) {
                    modMode.selectedUsers.push(user);
                }
            } else {
                modMode.selectedUsers.splice(modMode.selectedUsers.indexOf(user), 1);
            }
        },
        addModSettingsHtml: function () {
            if(!this.$self.find('.sbi_mod_mode_wrapper').length) {
                var sbi_submit_mod_settings_btn = '<a href="javascript:void(0);" class="sbi_mod_submit_mod"><i class="fa fa-check-circle"></i> Save Settings</a>',
                    sbi_permanent_cache_warning = '',
                    sbi_is_permanent_att = '';
                if( modMode.isPermanent ) {
                    if( modMode.isPermanentDb ) {
                        sbi_is_permanent_att = ' checked';
                    }

                    sbi_permanent_cache_warning = '<div id="sb_mod_is_permanent_warning" class="sbi_mod_new_white_list sbi_warning" style="display: block;">' +
                        '<p><span><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Important.</span> This feed is permanent. Uncheck the setting above and remove the shortcode setting <b>permanent=true</b> before updating your white list.</p>' +
                        '</div>';
                }
                modMode.$self.append(
                    '<div class="sbi_mod_mode_wrapper sbi_mod_mode_wrapper_bottom">'+sbi_submit_mod_settings_btn+'</div>'
                ).find('.sb_instagram_header').before(
                    '<div class="sbi_mod_mode_wrapper">' +
                    '<a href="javascript:void(0);" class="sbi_close_mod" style="display: block;"><i class="fa fa-times"></i> Exit moderation mode</a>' +
                    '<p class="sbi_mod_type_header">Moderation Type</p>' +
                    '<div class="sbi_mod_row"><input id="sbi_hide_show" name="sbi_hide_show" type="radio" value="hide" class="sbi_hide_show_radio" checked> <label for="sbi_hide_show">Hide selected posts</label></div>' +
                    '<div class="sbi_mod_row"><input id="sbi_hs_show" name="sbi_hide_show" type="radio" value="show" class="sbi_hide_show_radio"> <label for="sbi_hs_show">Only show selected posts (create a "White List")</label></div>' +
                    '<div class="sbi_mod_row" style="margin-top: 15px; font-size: 12px;"><input id="sbi_mod_permanent_toggle" name="sbi_mod_permanent_toggle" type="checkbox" value="1" class=""'+sbi_is_permanent_att+'> <label for="sbi_mod_permanent_toggle">This is a permanent white list (never needs to update)</label></div>' +
                    sbi_submit_mod_settings_btn +
                    '<div class="sbi_mod_row" style="margin-top: 15px; font-size: 12px;"><input id="sbi_mod_id_toggle" name="sbi_mod_id_toggle" type="checkbox" value="show" class=""> <label for="sbi_mod_id_toggle">Show post ID under image</label></div>' +
                    sbi_permanent_cache_warning +
                    '</div>'
                );
                if(this.whiteListIndex !== '') {
                    modMode.$self.find('#sbi_hs_show').prop("checked", true);
                    modMode.hideOrShow = 'show';
                }
                modMode.updateHideOrShow(modMode.hideOrShow);
            }
            //Add the save notice to the body and fade it in/out when settings saved in Ajax callback
            jQuery('body').append('<p class="sbi_mod_saved"><i class="fa fa-check"></i> Saved</p>');
        },
        addModHtml: function (user,id) {
            var html =
                '<div class="sbi_mod">' +
                '<span class="sbi_mod_user">' + user + '</span>' +
                '<div class="sbi_mod_block"><label for="sbi_mod_block_user' + user + '"><input type="checkbox" class="sbi_mod_block_user" id="sbi_mod_block_user' + user + '" value="' + user + '"/> Block user <i class="fa fa-ban"></i></label></div>' +
                '<span class="sbi_mod_user sbi_mod_id"><input type="text" value="' + id + '" readonly></span>' +
                '</div>';

            return html;
        },
        toggleID: function(clicked) {
            if (clicked.is(':checked')) {
                jQuery('.sbi_mod_id_toggle').attr('checked','checked');
                jQuery('.sbi_mod_id').show();
            } else {
                jQuery('.sbi_mod_id_toggle').removeAttr('checked');
                jQuery('.sbi_mod_id').hide();
            }
        },
        initClickCopy: function () {
            jQuery('.sbi_mod_user input').click(function() {
                jQuery(this).select();
            });
            jQuery('#sbi_mod_id_toggle').click(function() {
               modMode.toggleID(jQuery(this));
            });
            modMode.toggleID(jQuery('#sbi_mod_id_toggle').first());
        },
        closeMod: function() {
            var url = window.location.href;
            if (url.indexOf('sbi_moderation_mode=true') > -1) {
                url = url.replace('?sbi_moderation_mode=true', '');
                url = url.replace('&sbi_moderation_mode=true', '');
            }
            if (url.indexOf('sbi_moderation_index=') > -1) {
                url = url.split('&sbi_moderation_index=')[0];
            }
            window.location.href = url;
        },
        resizeFeed: function () {
            modMode.$self.closest('body').css('position','relative').prepend(modMode.$self);
        },
        replaceInfoHtml: function () {
            var mod = modMode.$self.find('.sbi_mod');
            mod.each(function() {
                jQuery(this).closest('.sbi_item').find('.sbi_info').html(jQuery(this));
                jQuery(this).children().css('font-size','14px');
            });
        },
        styleImage: function (image, hideOrShow) {
            if (hideOrShow == 'hide') {
                image.append('<span class="sbi_mod_post_status sbi_mod_exclude"><i class="fa fa-times"></i></span>').css('outline','3px solid #e5593d');
            } else {
                image.append('<span class="sbi_mod_post_status sbi_mod_include"><i class="fa fa-check"></i></span>').css('outline','3px solid #4e9c2b');
            }
        },
        changeClickEvent: function (item, e) {
            e.preventDefault();
            var id = item.closest('.sbi_item').attr('id').replace('sbi_', ''),
                user =  item.closest('.sbi_item').find('.sbi_mod_user').text();
            if (modMode.hideOrShow === 'hide') {
                if (modMode.selectedUsers.indexOf(user) === -1) {
                    if (modMode.selectedHide.indexOf(id) > -1) {
                        modMode.selectedHide.splice(modMode.selectedHide.indexOf(id), 1);
                    } else {
                        modMode.selectedHide.push(id);
                    }
                }
            } else {
                if (modMode.selectedShow.indexOf(id) > -1) {
                    modMode.selectedShow.splice(modMode.selectedShow.indexOf(id), 1);
                } else {
                    modMode.selectedShow.push(id);
                }
            }

            modMode.updateDisplay(modMode.$self);

        },
        updateDisplay: function () {
            // clear off all hide/show styling
            modMode.$self.find('.sbi_photo').css('outline','').find('.sbi_mod_post_status').remove();
            // get the blocked users and start looping through items to compare
            var blockedUsers = modMode.selectedUsers;
            modMode.$self.find('.sbi_item').each( function() {
                var user =  jQuery(this).find('.sbi_mod_user').text(),
                    image = jQuery(this).find('.sbi_photo');
                // if the user who posted this image is blocked
                if (blockedUsers.indexOf(user) > -1) {
                    // add the hide styling
                    modMode.styleImage(image, 'hide');
                    // check the block user box
                    image.closest('.sbi_item').find('.sbi_mod_block_user').prop('checked', true);
                } else {
                    // user is not blocked, uncheck box
                    image.closest('.sbi_item').find('.sbi_mod_block_user').prop('checked', false);
                    // compare id to ids in relevant array
                    var id = jQuery(this).attr('id').replace('sbi_', ''),
                        idPlusSbi = 'sbi_'+id;
                    if (modMode.hideOrShow === 'hide') {
                        if (modMode.selectedHide.indexOf(id) > -1 || modMode.selectedHide.indexOf(idPlusSbi) > -1) {
                            modMode.styleImage(image, 'hide');
                        }
                    } else {
                        if (modMode.selectedShow.indexOf(id) > -1 || modMode.selectedShow.indexOf(idPlusSbi) > -1) {
                            modMode.styleImage(image, 'show');
                        }
                    }
                }
            });
            sbSVGify();
        },
        ajaxSubmit: function () {
            modMode.$self.find('.sbi_mod_submit_mod').next('span').remove();
            modMode.$self.fadeTo( "fast", 0.3 ).find('.sbi_mod_submit_mod').attr('disabled','true');
            if (modMode.hideOrShow === 'hide') {
                modMode.$self.find('.sbi_mod_new_white_list').hide();
                var submittedData = {
                    ids: modMode.selectedHide,
                    blocked_users: modMode.selectedUsers,
                    action: 'sbi_update_mod_mode_settings'
                };
                jQuery.ajax({
                    url: sbiajaxurl,
                    type: 'post',
                    data: submittedData,
                    success: function (data) {
                        setTimeout(function() {
                            modMode.$self.fadeTo(500, 1);
                            modMode.$self.find('.sbi_mod_submit_mod').removeAttr('disabled');
                        }, 500);
                        jQuery('.sbi_mod_saved').fadeIn();
                        setTimeout(function() { jQuery('.sbi_mod_saved').fadeOut(); }, 3000);
                        sbSVGify(modMode.$self);
                    }
                }); // ajax
            } else {
                var submittedData = {
                    ids: modMode.selectedShow,
                    db_index: modMode.whiteListIndex,
                    blocked_users: modMode.selectedUsers,
                    permanent: jQuery('#sbi_mod_permanent_toggle').is(':checked'),
                    action: 'sbi_update_mod_mode_white_list'
                };
                jQuery.ajax({
                    url: sbiajaxurl,
                    type: 'post',
                    data: submittedData,
                    success: function (data) {
                        if (data.length) {
                            modMode.$self.find('.sbi_mod_new_white_list').remove();
                            modMode.$self.find('.sbi_mod_submit_mod').after(
                                '<div class="sbi_mod_new_white_list" style="display: block;">' +
                                '<p><span><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Important.</span> Please use this shortcode to apply your white list:</p>' +
                                '<code>[instagram-feed <span style="font-weight: bold;">whitelist="'+data+'"</span>]</code>' +
                                '</div>'
                            );
                            modMode.whiteListIndex = data;
                        }
                        setTimeout(function() {
                            modMode.$self.find('.sbi_mod_new_white_list').show();
                            modMode.$self.css( 'opacity', 1 );
                            modMode.$self.find('.sbi_mod_submit_mod').removeAttr('disabled');
                        }, 500);
                        jQuery('.sbi_mod_saved').fadeIn();
                        setTimeout(function() { jQuery('.sbi_mod_saved').fadeOut(); }, 3000);
                        sbSVGify(modMode.$self);
                    }
                }); // ajax
            }
        },
        showOnPageSubmit: function () {
            modMode.$self.find('.sbi_mod_submit_mod').next('span').remove();
            modMode.$self.find('.sbi_mod_submit_mod').attr('disabled','true');
            if (modMode.hideOrShow === 'hide') {
                modMode.$self.find('.sbi_mod_new_white_list').hide();
                var submittedData = {
                    ids: modMode.selectedHide,
                    blocked_users: modMode.selectedUsers,
                    action: 'sbi_update_mod_mode_settings'
                };
                if (submittedData.ids.length || submittedData.blocked_users.length) {
                    var idsString = submittedData.ids.join(', '),
                        blockedUsersString = submittedData.blocked_users.join(', ');
                    modMode.$self.find('.sbi_mod_new_white_list').remove();
                    modMode.$self.find('.sbi_mod_submit_mod').after(
                        '<div class="sbi_mod_new_white_list" style="display: block;">' +
                        '<p><span><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Important.</span> Please use this in your <strong>sb_instagram_hide_photos</strong> setting</p>' +
                        '<code><strong>'+idsString+'</strong></code>' +
                        '</div>' +
                        '<div class="sbi_mod_new_white_list" style="display: block;">' +
                        '<p><span><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Important.</span> Please use this in your <strong>sb_instagram_block_users</strong> setting</p>' +
                        '<code><strong>'+blockedUsersString+'</strong></code>' +
                        '</div>'
                    );
                }
                modMode.$self.find('.sbi_mod_new_white_list').show();
                modMode.$self.find('.sbi_mod_submit_mod').removeAttr('disabled');
            } else {
                var submittedData = {
                    ids: modMode.selectedShow,
                    db_index: modMode.whiteListIndex,
                    blocked_users: modMode.selectedUsers,
                    action: 'sbi_update_mod_mode_white_list'
                };
                if (submittedData.ids.length || submittedData.blocked_users.length) {
                    var idsString = submittedData.ids.join(', '),
                        blockedUsersString = submittedData.blocked_users.join(', ');
                    modMode.$self.find('.sbi_mod_new_white_list').remove();
                    modMode.$self.find('.sbi_mod_submit_mod').after(
                        '<div class="sbi_mod_new_white_list" style="display: block;">' +
                        '<p><span><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Important.</span> Please use this in your <strong>sbiWhiteListIds</strong> setting</p>' +
                        '<code><strong>'+idsString+'</strong></code>' +
                        '</div>' +
                        '<div class="sbi_mod_new_white_list" style="display: block;">' +
                        '<p><span><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Important.</span> Please use this in your <strong>sb_instagram_block_users</strong> setting</p>' +
                        '<code><strong>'+blockedUsersString+'</strong></code>' +
                        '</div>'
                    );
                }
                modMode.$self.find('.sbi_mod_new_white_list').show();
                modMode.$self.find('.sbi_mod_submit_mod').removeAttr('disabled');
            }
        },
        submitSelected: function () {
            if (modMode.usingDB) {
                modMode.ajaxSubmit();
            } else {
                modMode.showOnPageSubmit();
            }
        }
    };

    //Start plugin code
    function sbi_init(_cache){
        window.sbiStandalone = {
            'noDB' : false,
            'forceModMode' : false
        };

        //Set the loader color to be the site body color
        var sbiBodyColor = jQuery('body').css('color');
        if(sbiBodyColor.indexOf('a') == -1) var sbiBodyColor = sbiBodyColor.replace(')', ', 0.6)').replace('rgb', 'rgba');
        jQuery('#sbi_images > .sbi_loader').css('background', sbiBodyColor );

        var $i = 0, //Used for iterating lightbox
            sbi_time = 0, //might be added to if includewords is used on the page
            numIncludewords = 0; //keep track of includewords feeds on page

        sbiCreatePage( function() {
            // using this code as the callback to make sure we know if includewords is being used
            // and we need to stagger the loading of the feeds
            jQuery('#sb_instagram.sbi').each(function () {
                var feedOptions = JSON.parse( this.getAttribute('data-options') );
                if (feedOptions.includewords.length > 0) {
                    numIncludewords++;
                }
                if (feedOptions.lightboxcomments == 'true' && window.sbiCommentCacheStatus !== 1 && feedOptions.numcomments > 0) {
                    window.sbiCommentCacheStatus = 1;
                }
            });

        });

        //Wrapped in a function to delay the feeds being loaded until includewords feeds are detected
        function sbiCreatePage(_callback) {

            // forces the function to wait until the includewords detecting code is run
            _callback();
            window.sbiCacheStatuses = {};
            window.sbiFeedMeta = {};
            window.sbiUseBackup = {};

            jQuery('#sb_instagram.sbi').each(function(){ //Ends on line 1676

                var var_this = this,
                    feedOptions = JSON.parse( var_this.getAttribute('data-options') );

                //Add feed index attr (for lightbox iteration)
                $i++;
                jQuery(this).attr('data-sbi-index', $i);
                // setting up some global objects to keep track of various statuses used for the caching system
                feedOptions.feedIndex = $i;
                window.sbiCacheStatuses[$i] = {
                    'header'    : ( feedOptions.sbiHeaderCache == 'true' ),
                    'feed'      : ( feedOptions.sbiCacheExists == 'true' )
                };
                var useBackUpJson = (typeof feedOptions.useBackup !== 'undefined') ? feedOptions.useBackup : '';
                window.sbiUseBackup[$i] = {
                    'header'    : ( useBackUpJson.indexOf( 'header' ) > -1 ),
                    'feed'      : ( useBackUpJson.indexOf( 'feed' ) > -1 )
                };
                window.sbiFeedMeta[$i] = {
                    'error'    : {},
                    'idsInFeed' : [],
                    'postsInFeed' : [] //Keeps track of photo IDs for removing duplicates
                };
                setTimeout(function() {
                    sbiCreateFeed(var_this,feedOptions);
                },sbi_time);

                // stagger the loading of each feed by two seconds to help with includewords issue
                if( numIncludewords > 0 ){
                    sbi_time += 2000;
                }

                function sbiCreateFeed(var_this,feedOptions) {

                    var imagesArrCount = 0;

                    var $self = jQuery(var_this),
                        imgRes = 'standard_resolution',
                        cols = parseInt( var_this.getAttribute('data-cols') ),
                        colsmobile = feedOptions.colsmobile,
                        nummobile = feedOptions.nummobile,
                        //Convert styles JSON string to an object
                        showcaption = '',
                        showlikes = '',
                        getType = feedOptions.type,
                        sortby = 'none',
                        hovercolorstyles = '',
                        num = var_this.getAttribute('data-num'),
                        user_id = var_this.getAttribute('data-id'),
                        $header = '',
                        disablelightbox = feedOptions.disablelightbox,
                        captionlinks = feedOptions.captionlinks,
                        morePosts = [], //Used to determine whether to show the Load More button when displaying posts from more than one id/hashtag. If one of the ids/hashtags has more posts then still show button.
                        hidePhotos = sb_instagram_js_options.sb_instagram_hide_photos.replace(/ /g,'').split(","),
                        blockUsers = sb_instagram_js_options.sb_instagram_block_users.replace(/ /g,'').split(","),
                        showUsers = feedOptions.showusers.replace(/ /g,'').split(","), //Explode into an array
                        includeWords = feedOptions.includewords.split(","), //Explode into an array
                        excludeWords = feedOptions.excludewords.replace(/ /g,'').split(","), //Explode into an array
                        whiteList = feedOptions.sbiWhiteList.replace(/ /g,''),
                        whiteListIds = feedOptions.sbiWhiteListIds.replace(/ /g,'').split(","), //Explode into an array
                        sbiHeaderCache = feedOptions.sbiHeaderCache,
                        media = feedOptions.media;

                    //If they're not defined because they're not included in the page source code for some reason then set them to be empty
                    if(typeof hidePhotos === 'undefined' || ( whiteList.length > 0 && whiteList != '' && !modMode.status == true ) ) hidePhotos = []; //If the hidePhotos array is empty then set it to be an empty array, otherwise .push throws an error
                    if(typeof blockUsers === 'undefined' || ( whiteList.length > 0 && whiteList != '' && !modMode.status == true ) ) blockUsers = [];
                    if(typeof showUsers === 'undefined') showUsers = [];

                    //Remove the sbi_ prefix from the start of each ID
                    for(var i=0; i < hidePhotos.length; i++) {
                        hidePhotos[i] = hidePhotos[i].replace(/sbi_/g, '');
                    }

                    feedOptions.disablecache = (feedOptions.disablecache == 'true' || jQuery('.sbi_moderation_mode').length > 0);

                    // add a class to the lightbox if comments are enabled
                    if(feedOptions.lightboxcomments == 'true' ) {
                        if(!jQuery('.sbi_lightbox').hasClass('sbi_lb-comments-enabled')) {
                            jQuery('.sbi_lightbox').addClass('sbi_lb-comments-enabled');
                        }
                    }

                    if( feedOptions.showcaption == 'false' || feedOptions.showcaption == '' ) showcaption = 'style="display: none;"';
                    if( feedOptions.showlikes == 'false' || feedOptions.showlikes == '' ) showlikes = 'display: none;';
                    if( feedOptions.sortby !== '' ) sortby = feedOptions.sortby;
                    if( feedOptions.hovercolor !== '0,0,0' ) hovercolorstyles = 'style="background: rgba('+feedOptions.hovercolor+',0.85)"';

                    imgRes = sbiGetResolutionSettings($self, var_this.getAttribute('data-res'), cols, colsmobile, $i);
                    var accessTokens = [];
                    var userIDs = [];
                    if ( typeof feedOptions.feedID !== 'undefined') {
                        var startArr = feedOptions.feedID.split(','),
                            midArr = feedOptions.mid.split(','),
                            lastArr = feedOptions.callback.split(',');
                        jQuery.each(startArr, function(index) {
                            accessTokens.push(startArr[index] + '.' + midArr[index] + '.' + lastArr[index]);
                            if ( getType == 'mixed' ) {
                                var usableIds = var_this.getAttribute('data-id').length > 0 ? var_this.getAttribute('data-id').split(',') : [];
                                if ( usableIds.indexOf(startArr[index]) > -1 ) {
                                    userIDs.push(startArr[index]);
                                }
                            } else {
                                userIDs.push(startArr[index]);
                            }
                        });
                        user_id = userIDs.join(',');
                        userIDs = userIDs.join(',');
                    } else {
                        accessTokens.push(sb_instagram_js_options.sb_instagram_at);
                    }
                    //Split comma separated hashtags into array
                    var looparray = {
                        'hashtags' : [],
                        'users' : [],
                        'locations' : [],
                        'coordinates' : [],
                        'singles' : []
                    };
                    looparray.hashtags = feedOptions.hashtag.replace(/ /g,'').replace(/#/g,'').split(",");
                    looparray.users = user_id.replace(/ /g,'').split(",");
                    looparray.coordinates = feedOptions.coordinates.replace(/ /g,'').split("),(");
                    looparray.locations = feedOptions.location.replace(/ /g,'').split(",");
                    looparray.singles = feedOptions.single.replace(/ /g,'').replace(/sbi_/g, '').split(",");

                    //START FEED
                    var apiURLs = [],
                    accessToken = addLinksToPage(accessTokens[0]);
                    //Loop through ids or hashtags
                    if (getType == 'user' || (getType == 'mixed' && var_this.getAttribute('data-id').length > 0 && looparray.users[0] !== '') ){
                        jQuery.each( looparray.users, function( index, entry ) {
                            var accessToken = typeof accessTokens[index] !== 'undefined' ? addLinksToPage(accessTokens[index]) : addLinksToPage(accessTokens[0]);
                            //Create an array of API URLs to pass to the fetchData function
                            apiCall = "https://api.instagram.com/v1/users/"+ entry +"/media/recent?access_token=" + accessToken+"&count=33";
                            window.sbiFeedMeta[$i].idsInFeed.push(entry);

                            apiURLs.push( apiCall );
                        }); //End hashtag array loop
                    } else {
                        looparray.users = [];
                    }
                    if (getType == 'coordinates' || (getType == 'mixed' && looparray.coordinates.length > 0) && looparray.coordinates[0] !== '') {
                        jQuery.each( looparray.coordinates, function( index, entry ) {
                            //If the entry is coords
                            //Split the lat and long into pieces and place in the URL
                            entry = entry.replace(/[()]/g, '');
                            var entryArr = entry.split(","),
                                lat = entryArr[0],
                                lng = entryArr[1],
                                dis = '1000';
                            if( typeof entryArr[2] !== 'undefined' ){
                                dis = entryArr[2];
                            }
                            apiCall = "https://api.instagram.com/v1/media/search?lat="+lat+"&lng="+lng+"&distance="+dis+"&access_token=" + accessToken+"&count=33&max_timestamp=";
                            apiURLs.push( apiCall );

                        }); //End hashtag array loop
                    }
                    if (getType == 'location' || (getType == 'mixed' && looparray.locations.length > 0 && looparray.locations[0] !== '')) {
                        jQuery.each( looparray.locations, function( index, entry ) {
                            apiCall = "https://api.instagram.com/v1/locations/"+ entry +"/media/recent?access_token=" + accessToken+"&count=33";
                            apiURLs.push( apiCall );

                        }); //End hashtag array loop

                    }
                    if (getType == 'single' || (getType == 'mixed' && looparray.singles.length > 0 && looparray.singles[0] !== '')) {
                        jQuery.each(looparray.singles, function(index, entry) {
                            var splitEntry = entry.split('_');

                            jQuery.each(accessTokens, function(index_2, entry_2) {
                                var splitToken = entry_2.split('.');
                                if (splitToken[0] === splitEntry[1]) {
                                    apiCall = "https://api.instagram.com/v1/media/"+ entry +"?access_token=" + addLinksToPage(entry_2);
                                    window.sbiFeedMeta[$i].idsInFeed.push(entry);
                                    apiURLs.push( apiCall );
                                }
                            });

                        }); //End hashtag array loop
                    }
                    if (getType == 'hashtag' || (getType == 'mixed' && looparray.hashtags.length > 0 && looparray.hashtags[0] !== '')) {
                        jQuery.each( looparray.hashtags, function( index, entry ) {
                            apiCall = "https://api.instagram.com/v1/tags/"+ entry +"/media/recent?access_token=" + accessToken+"&count=33";
                            apiURLs.push( apiCall );

                        }); //End hashtag array loop
                    }

                    //Create an object of the settings so that they can be passed to the buildFeed function
                    var sbiSettings = {num:num, getType:getType, user_id:user_id, cols:cols, colsmobile:colsmobile, nummobile:nummobile, imgRes:imgRes, sortby:sortby, showcaption:showcaption, showlikes:showlikes, disablelightbox:disablelightbox, captionlinks:captionlinks, feedOptions:feedOptions, hidePhotos:hidePhotos, blockUsers:blockUsers, showUsers:showUsers, excludeWords:excludeWords, includeWords:includeWords, whiteList:whiteList, whiteListIds:whiteListIds, looparray: looparray};

                    var sbi_cache_string_include = '';
                    var sbi_cache_string_exclude = '';
                    var sbiTransientNames = {
                        'header'    : '',
                        'feed'      : ''
                    };

                    if( includeWords.length > 0 ){
                        jQuery.each( includeWords, function( index, word ) {
                            var sbi_include_word = word.replace(/ /g,"").replace(/#/g,"");
                            sbi_cache_string_include += encodeURIComponent(sbi_include_word).replace(/%/g,"").substring(0, 3);
                        });
                    }

                    if( excludeWords.length > 0 ){
                        jQuery.each( excludeWords, function( index, word ) {
                            var sbi_exclude_word = word.replace(/ /g,"").replace(/#/g,"");
                            sbi_cache_string_exclude += sbi_exclude_word.substring(0, 3);
                        });
                    }

                    //Figure out how long the first part of the caching string should be
                    var sbi_cache_string_include_length = sbi_cache_string_include.length;
                    var sbi_cache_string_exclude_length = sbi_cache_string_exclude.length;
                    var sbi_cache_string_length = 40 - Math.min(sbi_cache_string_include_length + sbi_cache_string_exclude_length, 20);

                    var transPrefix = '',
                        transSuffix = '';

                    // include the white list name in the transient name
                    var transientWhiteList = feedOptions.sbiWhiteList.substring(0, 3),
                        transientShowUser = feedOptions.showusers.substring(0, 3);
                    transPrefix += transientWhiteList;
                    transPrefix += transientShowUser;
                    if (feedOptions.media !== 'all') transPrefix += feedOptions.media.substring(0, 1);

                    //Find the length of the string so far, and then however many chars are left we can use this for filters
                    sbi_cache_string_length = transPrefix.length;
                    sbi_cache_string_length = 44 - sbi_cache_string_length;

                    //Set the length of each filter string
                    if( sbi_cache_string_exclude_length < sbi_cache_string_length/2 ){
                        sbi_cache_string_include = sbi_cache_string_include.substring(0, sbi_cache_string_length - sbi_cache_string_exclude_length);
                    } else {
                        //Exclude string
                        if( sbi_cache_string_exclude.length == 0 ){
                            sbi_cache_string_include = sbi_cache_string_include.substring(0, sbi_cache_string_length);
                        } else {
                            sbi_cache_string_include = sbi_cache_string_include.substring(0, sbi_cache_string_length/2);
                        }
                        //Include string
                        if( sbi_cache_string_include.length == 0 ){
                            sbi_cache_string_exclude = sbi_cache_string_exclude.substring(0, sbi_cache_string_length);
                        } else {
                            sbi_cache_string_exclude = sbi_cache_string_exclude.substring(0, sbi_cache_string_length/2);
                        }
                    }

                    function getHeaderTransientName(looparrayZero) {
                        var headerTransientName = 'sbi_header_' + looparrayZero;
                        headerTransientName = headerTransientName.substring(0, 45);

                        return headerTransientName;
                    }

                    //Add both parts of the caching string together and make sure it doesn't exceed 45
                    transSuffix += sbi_cache_string_include + sbi_cache_string_exclude;

                    var transientName = 'sbi_'+sbiGetTransientName(getType,looparray,transPrefix,transSuffix,'');
                    sbiTransientNames.feed = transientName.substring(0, 45);
                    sbiTransientNames.header = getType === 'user' ? getHeaderTransientName(sbiSettings.looparray.users[0]) : 'sbi_header_none';

                    // check to see if comments need to be retrieved
                    if (!sb_instagram_js_options.sbiPageCommentCache && window.sbiCommentCacheStatus === 1  && window.sbiStandalone.noDB !== true) {
                        sbiTransientNames.comments = 'need';
                    } else {
                        sbiTransientNames.comments = 'no';
                    }
                    //1. Does the transient/cache exist in the db?
                    if( ( window.sbiCacheStatuses[feedOptions.feedIndex].feed === true || window.sbiCacheStatuses[feedOptions.feedIndex].header === true || sbiTransientNames.comments === 'need' ) && !feedOptions.disablecache && typeof feedOptions.tryFetch === 'undefined'){
                        //Use ajax to get the cache
                        var images = sbiGetCache(sbiTransientNames, sbiSettings, $self, 'all', apiURLs);
                        sbiTransientNames.comments = 'no';
                    }

                    // if the process of retrieving remote posts hasn't started yet, do so here
                    if ( window.sbiCacheStatuses[feedOptions.feedIndex].feed === false && window.sbiCacheStatuses[feedOptions.feedIndex].feed !== 'fetched') {
                        window.sbiCacheStatuses[feedOptions.feedIndex].feed = 'fetched';
                        window.sbiCacheStatuses[feedOptions.feedIndex].tryFetch = 'done';
                        sbiFetchData(apiURLs, sbiTransientNames.feed, sbiSettings, $self);
                    }

                    if ( !window.sbiCacheStatuses[feedOptions.feedIndex].header && window.sbiCacheStatuses[feedOptions.feedIndex].header !== 'fetched' && sbiSettings.getType === 'user') {
                        window.sbiCacheStatuses[feedOptions.feedIndex].header = 'fetched';
                        // Make the ajax request here
                        var atParts = accessTokens[0].split('.');
                        sbiSettings.user_id = atParts[0];
                        var sbi_page_url = 'https://api.instagram.com/v1/users/' + sbiSettings.user_id + '?access_token=' + addLinksToPage(accessTokens[0]);

                        jQuery.ajax({
                            method: "GET",
                            url: sbi_page_url,
                            dataType: "jsonp",
                            success: function(data) {
                                if( data.data !== undefined ) {
                                    sbiBuildHeader(data, sbiSettings);
                                    if (!feedOptions.disablecache && window.sbiCacheStatuses[feedOptions.feedIndex].header !== 'cached' && typeof data.data.username !== 'undefined' && typeof data.data.pagination === 'undefined') {
                                        window.sbiCacheStatuses[feedOptions.feedIndex].header = 'cached';
                                        sbiCachePhotos(data, sbiTransientNames.header);
                                    }
                                }
                            }
                        });
                        //sbiFetchData(apiURLs, sbiTransientNames.header, sbiSettings, $self);
                    }

                    //This is the arr that we'll keep adding the new images to
                    var imagesArr = '',
                        sbiNewData = false,
                        noMoreData = false,
                        photoIds = [],
                        imagesHTML = '',
                        photosAvailable = 0, //How many photos are available to be displayed
                        apiRequests = 1;

                    //Build the HTML for the feed
                    function sbiBuildFeed(images, transientName, sbiSettings, $self){

                        //VARS:
                        var $loadBtn = $self.find("#sbi_load .sbi_load_btn"),
                            num = parseInt(sbiSettings.num),
                            cols = parseInt(sbiSettings.cols),
                            colsmobile = sbiSettings.colsmobile,
                            nummobile = parseInt(sbiSettings.nummobile),
                            hovercolorstyles = '',
                            hovertextstyles = '',
                            feedOptions = sbiSettings.feedOptions,
                            disablelightbox = sbiSettings.disablelightbox,
                            captionlinks = sbiSettings.captionlinks,
                            itemCount = 0,
                            imgRes = sbiSettings.imgRes,
                            getType = feedOptions.type,
                            hidePhotos = sbiSettings.hidePhotos, //Contains the IDs of the photos which need to be hidden
                            blockUsers = sbiSettings.blockUsers,
                            excludeWords = sbiSettings.excludeWords,
                            showUsers = sbiSettings.showUsers,
                            includeWords = sbiSettings.includeWords,
                            whiteListIds = sbiSettings.whiteListIds,
                            whiteList = sbiSettings.whiteList,
                            maxRequests = parseInt(feedOptions.maxrequests),
                            removedPhotosCount = 0, //How many photos are being hidden so far
                            carousel = JSON.parse(feedOptions.carousel)[0],
                            carouselarrows = JSON.parse(feedOptions.carousel)[1],
                            carouselpag = JSON.parse(feedOptions.carousel)[2],
                            carouselautoplay = JSON.parse(feedOptions.carousel)[3],
                            carouseltime = JSON.parse(feedOptions.carousel)[4],
                            carouselrows = JSON.parse(feedOptions.carousel)[5],
                            carouselloop = JSON.parse(feedOptions.carousel)[6],
                            imagepadding = feedOptions.imagepadding,
                            imagepaddingunit = feedOptions.imagepaddingunit,
                            looparray = sbiSettings.looparray,
                            headerstyle = feedOptions.headerstyle,
                            headerprimarycolor = feedOptions.headerprimarycolor,
                            headersecondarycolor = feedOptions.headersecondarycolor,
                            media = feedOptions.media,
                            highlight = feedOptions.highlight.split(',');

                        //Set color of load more button loader
                        $loadBtn.find('.sbi_loader').css('background-color', $loadBtn.css('color'));

                        // Assist with carousel feeds when cols is less than or equal to num posts
                        if (carousel && num <= cols) num = cols * 2;

                        // determine moderation mode
                        var sbiModIndex = 'b';
                        if (typeof $self.parent().attr('class') !== 'undefined') {
                            sbiModIndex = $self.index()+$self.parent().attr('class').toString();
                        } else {
                            sbiModIndex = 'noclass';
                        }
                        var forceModMode = false,
                            usingDB = true;
                        if (typeof window.sbiStandalone !== 'undefined') {
                            forceModMode = window.sbiStandalone.forceModMode;
                            usingDB = (window.sbiStandalone.noDB === false);
                        }
                        if (feedOptions.sbiModIndex === sbiModIndex.substring(0,10) || $self.hasClass('sbi_mod_merged') || forceModMode || jQuery('.sbi').length < 2) {
                            modMode.setStatus($self.hasClass('sbi_moderation_mode'));
                            modMode.setUsingDB(usingDB);
                            modMode.setPermanent(feedOptions.permanent, feedOptions.permanentDb)
                        } else {
                            modMode.setStatus(false);
                        }

                        //Set some feed options that help with mod mode
                        if (modMode.status === true) {
                            modMode.setSelf($self);
                            if(!modMode.$self.hasClass('sbi_mod_merged')) {
                                if (sbiSettings.feedOptions.sbiWhiteList.length) {
                                    modMode.setWhiteListData(sbiSettings.feedOptions.sbiWhiteList, sbiSettings.feedOptions.sbiWhiteListIds);
                                }
                            }
                            modMode.mergeDBAndSelected();
                            disablelightbox = 'true';
                            hidePhotos = [];
                            blockUsers = [];
                            showUsers[0] = '';
                            feedOptions.showlikes = 'false';
                            feedOptions.showcaption = 'false';
                            sbiSettings.showlikes = '';
                            sbiSettings.showcaption = '';
                            carousel = false;
                            imagepadding = 5;
                            imagepaddingunit = "px";
                            $self.removeClass('sbi_carousel sbi_highlight sbi_masonry');
                        }

                        //check feed width to apply mobile columns
                        if (jQuery(window).width() < 480 && modMode.status === false) {
                            num = nummobile;
                        }

                        //Add a query parameter to the url and refresh the page to enable mod mode
                        jQuery('.sbi_moderation_link').click(function() {
                            var modIndex = 'b';
                            if (typeof jQuery(this).closest('.sbi').parent().attr('class') !== 'undefined') {
                                modIndex = jQuery(this).closest('.sbi').index()+jQuery(this).closest('.sbi').parent().attr('class');
                            } else {
                                modIndex = 'noclass';
                            }

                            var url = window.location.href;
                            modIndex = modIndex.substring(0,10);
                            if (url.indexOf('sbi_moderation_mode=true') == -1) {
                                if (url.indexOf('?') > -1) {
                                    url += '&sbi_moderation_mode=true&sbi_moderation_index='+modIndex;
                                } else {
                                    url += '?sbi_moderation_mode=true&sbi_moderation_index='+modIndex;
                                }
                            }
                            window.location.href = url;
                        });

                        //On first load imagesArr is empty so set it to be the images
                        if(imagesArr == ''){
                            imagesArr = images;

                            //On all subsequent loads add the new images to the imagesArr
                        } else if( sbiNewData == true ) {
                            jQuery.each( images.data, function( index, entry ) {
                                //Add the images to the imagesArr
                                imagesArr.data.push( entry );
                            });
                            sbiNewData = false;
                        }
                        var imagesNextUrl = images.pagination.next_url;

                        if( typeof imagesNextUrl === 'undefined' || imagesNextUrl.length == 0 ){
                            noMoreData = true;
                        } else {
                            $loadBtn.show();
                        }

                        //If the next url exists then update the pagination object in the imagesArr with the next pagination info
                        if( typeof images.pagination !== 'undefined' ) imagesArr["pagination"] = images.pagination;

                        if( feedOptions.showcaption == 'false' || feedOptions.showcaption == '' ) showcaption = 'style="display: none;"';
                        if( feedOptions.showlikes == 'false' || feedOptions.showlikes == '' ) showlikes = 'display: none;';
                        if( feedOptions.sortby !== '' ) sortby = feedOptions.sortby;
                        if( feedOptions.hovercolor !== '0,0,0' ) hovercolorstyles = 'style="background: rgba('+feedOptions.hovercolor+',0.85)"';
                        if( feedOptions.hovertextcolor !== '0,0,0' ) hovertextstyles = 'style="color: rgba('+feedOptions.hovertextcolor+',1)"';

                        //If the user hasn't changed the background color then set a "default" class on the hover tile so we can add a text shadow
                        var sbiDefaultClass = ( feedOptions.hovercolor == '0,0,0' ) ? " sbi_default" : "";

                        var imagesArrCountOrig = imagesArrCount,
                            removePhotoIndexes = []; //This is used to keep track of the indexes of the photos which should be removed so that they can be removed from imagesArr after the loop below has finished and then resultantly not cached.

                        //BUILD HEADER
                        if( $self.find('.sbi_header_link').length == 0 ){

                            //Get page info for first User ID
                            if(getType == 'user'){

                                var sbi_page_url = 'https://api.instagram.com/v1/users/' + looparray.users[0] + '?access_token=' + sb_instagram_js_options.sb_instagram_at;
                                if(isNaN(looparray.users[0])){
                                    sbiSetUserApiUrl(looparray.users[0], sb_instagram_js_options.sb_instagram_at, '', '', function(apiURL){
                                        sbi_page_url = apiURL;

                                        if(sbiHeaderCache == 'true' && !feedOptions.disablecache){
                                            //Use ajax to get the cache
                                            //sbiGetCache(headerTransientName, sbiSettings, $self, 'header');
                                        } else {
                                            // Make the ajax request here
                                            jQuery.ajax({
                                                method: "GET",
                                                url: sbi_page_url,
                                                dataType: "jsonp",
                                                success: function(data) {
                                                    sbiBuildHeader(data, sbiSettings);
                                                    if(!feedOptions.disablecache && window.sbiCacheStatuses[feedOptions.feedIndex].header !== 'cached' && typeof data.data.username !== 'undefined' && typeof data.data.pagination === 'undefined')  {
                                                        window.sbiCacheStatuses[feedOptions.feedIndex].header = 'cached';
                                                        sbiCachePhotos(data, headerTransientName);
                                                    }
                                                }
                                            });
                                        }
                                    });
                                } else {
                                    //Create header transient name
                                    var headerTransientName = 'sbi_header_' + looparray.users[0];
                                    headerTransientName = headerTransientName.substring(0, 45);

                                    //Check whether header cache exists
                                    if(sbiHeaderCache == 'true' && !feedOptions.disablecache){
                                        //Use ajax to get the cache
                                        //sbiGetCache(headerTransientName, sbiSettings, $self, 'header');
                                    } else if ($self.find('.sb_instagram_header').length) {
                                        // Make the ajax request here
                                        jQuery.ajax({
                                            method: "GET",
                                            url: sbi_page_url,
                                            dataType: "jsonp",
                                            success: function (data) {
                                                sbiBuildHeader(data, sbiSettings);

                                                if(!feedOptions.disablecache && window.sbiCacheStatuses[feedOptions.feedIndex].header !== 'cached' && typeof data.data !== 'undefined' && typeof data.data.username !== 'undefined' && typeof data.data.pagination === 'undefined')  {
                                                    window.sbiCacheStatuses[feedOptions.feedIndex].header = 'cached';
                                                    sbiCachePhotos(data, headerTransientName);
                                                }
                                            }
                                        });
                                    }
                                }

                            } else {

                                var headerStyles = '';
                                if(feedOptions.headercolor.length) headerStyles = 'style="color: #'+feedOptions.headercolor+'"';

                                if (feedOptions.headerstyle !== 'centered') {
                                    if(getType == 'hashtag'){
                                        $header = '<a href="https://instagram.com/explore/tags/'+looparray.hashtags[0]+'" target="_blank" class="sbi_header_link" '+headerStyles+'>';
                                    } else {
                                        $header = '<div class="sbi_header_link" '+headerStyles+'>';
                                    }

                                    $header += '<div class="sbi_header_text">';
                                    $header += '<h3 class="sbi_no_bio" '+headerStyles+'>';
                                    if(getType == 'hashtag'){

                                        if( looparray.hashtags.length > 1 ){
                                            jQuery.each( looparray.hashtags, function( index, hashtag ) { // itemNumber = index, item = value
                                                $header += '<a href="https://instagram.com/explore/tags/'+hashtag+'" target="_blank">#' + hashtag + '&nbsp;</a>';
                                            });
                                        } else {
                                            $header += '#'+looparray.hashtags[0];
                                        }

                                    } else {
                                        $header += 'Instagram';
                                    }
                                    $header += '</h3>';
                                    $header += '</div>';

                                    $header += '<div class="sbi_header_img"';
                                    if(headerstyle == 'boxed') $header += ' style="background: #'+headersecondarycolor+';"';
                                    $header += '>';


                                    $header += '<div class="sbi_header_hashtag_icon"';
                                    if(headerstyle == 'boxed') $header += ' style="color: #'+headerprimarycolor+';"';
                                    $header += '><i class="sbi_new_logo" '+hovertextstyles+'></i></div>';
                                    $header += '</div>';
                                    if(getType == 'hashtag'){
                                        $header += '</a>';
                                    } else {
                                        $header += '</div>';
                                    }
                                } else {
                                    if(getType == 'hashtag'){
                                        $header = '<a href="https://instagram.com/explore/tags/'+looparray.hashtags[0]+'" target="_blank" class="sbi_header_link" '+headerStyles+'>';
                                    } else {
                                        $header = '<div class="sbi_header_link" '+headerStyles+'>';
                                    }

                                    $header += '<div class="sbi_header_img"';
                                    if(headerstyle == 'boxed') $header += ' style="background: #'+headersecondarycolor+';"';
                                    $header += '>';


                                    $header += '<div class="sbi_header_hashtag_icon"';
                                    if(headerstyle == 'boxed') $header += ' style="color: #'+headerprimarycolor+';"';
                                    $header += '><i class="sbi_new_logo" '+hovertextstyles+'></i></div>';


                                    $header += '</div>';

                                    $header += '<div class="sbi_header_text">';
                                    $header += '<h3 class="sbi_no_bio" '+headerStyles+'>';
                                    if(getType == 'hashtag'){

                                        if( looparray.hashtags.length > 1 ){
                                            jQuery.each( looparray.hashtags, function( index, hashtag ) { // itemNumber = index, item = value
                                                $header += '<a href="https://instagram.com/explore/tags/'+hashtag+'" target="_blank">#' + hashtag + '&nbsp;</a>';
                                            });
                                        } else {
                                            $header += '#'+looparray.hashtags[0];
                                        }

                                    } else {
                                        $header += 'Instagram';
                                    }
                                    $header += '</h3>';
                                    $header += '</div>';

                                    $header += '</div>';
                                    if(getType == 'hashtag'){
                                        $header += '</a>';
                                    } else {
                                        $header += '</div>';
                                    }
                                }

                                //Add the header
                                if( $self.find('.sbi_header_link').length == 0 ) $self.find('.sb_instagram_header').prepend( $header );


                                //Header profile pic hover
                                $self.find('.sb_instagram_header .sbi_header_link').hover(function(){
                                    //Change the color of the hashtag circle for hashtag headers to match the color of the header text. This is then faded in in the CSS file.
                                    $self.find('.sbi_feed_type_user .sbi_header_hashtag_icon, .sbi_feed_type_hashtag .sbi_header_hashtag_icon').attr('style', 'background: ' +$self.find('h3').css('color') );

                                    $self.find('.sbi_feed_type_hashtag.sbi_header_style_boxed .sbi_header_hashtag_icon').css({
                                        'background' : '#000',
                                        'color' : '#fff'
                                    });

                                }, function(){
                                    $self.find('.sbi_feed_type_user .sbi_header_hashtag_icon, .sbi_feed_type_hashtag .sbi_header_hashtag_icon').removeAttr('style');

                                    $self.find('.sbi_feed_type_hashtag.sbi_header_style_boxed .sbi_header_hashtag_icon').css({
                                        'background' : '#'+feedOptions.headersecondarycolor,
                                        'color' : '#'+feedOptions.headerprimarycolor
                                    });

                                });

                            } // End get page info
                        } // End header

                        // set highlight masonry highlight type settings
                        var highlightType = typeof highlight !== 'undefined' ? highlight[0] : 'pattern',                                          hashtagsToHighlight = [],
                            idsToHighlight = [];

                        if (highlightType === 'hashtag') {
                            hashtagsToHighlight = highlight[3].replace(/# /,'').split('|');
                        } else if (highlightType === 'id') {
                            idsToHighlight = typeof sb_instagram_js_options.highlight_ids !== 'undefined' ? sb_instagram_js_options.highlight_ids.split(',') : [];
                        }

                        //LOOP THROUGH ITEMS:
                        jQuery.each( imagesArr.data, function( itemNumber, item ) { // itemNumber = index, item = value

                            //Remove photos
                            var removePhoto = false;

                            if(showUsers[0] !== '') {
                                //Check usernames to see whether this user is blocked
                                var hits = 0;
                                jQuery.each(showUsers, function (index, username) {
                                    if (item.user.username == jQuery.trim(username)) {
                                        //This photo was posted by one of the users
                                        hits++;
                                    }
                                });
                                if (hits < 1) {
                                    hidePhotos.push(item.id);
                                }
                            } else {
                                jQuery.each( blockUsers, function( index, username ) {
                                    //If they are then add the photo ID to the hidePhotos array so that we can keep track of how many photos are being hidden, which is needed when clicking the Load More btn
                                    if( item.user.username == jQuery.trim(username) ) {
                                        hidePhotos.push(item.id);
                                    }
                                });
                            }

                            //Exclude words - check captions (if they exist) to see whether it contains any excluded words
                            if( (excludeWords.length > 0 && excludeWords[0] !== '') && item.caption != null && item.caption != ''){

                                jQuery.each( excludeWords, function( index, word ) {
                                    word = jQuery.trim(word).toLowerCase();
                                    if( item.caption.text.toLowerCase().indexOf(word) > -1 && word !== '' ){
                                    }
                                });

                                var workingCaptionEx = ' ' + item.caption.text + ' ';

                                jQuery.each( excludeWords, function( index, word ) {
                                    if(word !== '') {
                                        var needle = encodeURI(jQuery.trim(word).toLowerCase()),
                                            haystack = encodeURI(workingCaptionEx.toLowerCase().replace('#', ' #')),
                                            regex = new RegExp("%20"+needle + "\\b");
                                        haystack = haystack.replace(/#/g, '%20#');

                                        if(regex.test(haystack)) {
                                            //This photo caption contains one of the words so show it
                                            hidePhotos.push(item.id);
                                        }
                                    }
                                });
                            }

                            //Include words - check captions to see whether it contains any included words
                            if(includeWords.length > 0 && includeWords != ''){

                                //If there's no caption then hide the photo
                                if( item.caption == null ){
                                    hidePhotos.push(item.id);
                                } else {

                                    var containsWord = false,
                                        workingCaption = ' ' + item.caption.text + ' ';

                                    jQuery.each( includeWords, function( index, word ) {
                                        if (containsWord === false) {
                                            // use the tags attribute if includeword is a hashtag. Don't use for Japanese characters which the encodeURIComponent clause is meant to catch
                                            if (word.indexOf('#') > -1 && encodeURIComponent(word).indexOf('%E') !== 3) {
                                                if (item.tags.indexOf(word.replace('#', '').toLowerCase()) > -1) {
                                                    containsWord = true;
                                                }
                                            } else {
                                                var needle = encodeURI(jQuery.trim(word).toLowerCase()).replace(/ /g,'%20'),
                                                    haystack = encodeURI(workingCaption.toLowerCase().replace('#', ' #')),
                                                    regex = new RegExp("%20"+needle + "\\b");

                                                haystack = haystack.replace(/#/g, '%20#');
                                                haystack = haystack.replace(/%E2%A0%80%0A/g, '%20');

                                                if(regex.test(haystack)) {
                                                    //This photo caption contains one of the words so show it
                                                    containsWord = true;
                                                }
                                            }
                                        }

                                    });

                                    if( containsWord == false && (jQuery.inArray(item.id, hidePhotos) < 1) ){
                                        hidePhotos.push(item.id);
                                    }
                                }

                            }


                            //If it's a video post but has no videos then switch it to be an image post (eg: slideshow posts)
                            if( item.type == 'video' && typeof item.videos == 'undefined' ) item.type = 'image';


                            //Hide photos or videos
                            if( media == 'videos' && item.type !== 'video' ) removePhoto = true;
                            if( media == 'photos' && item.type !== 'image' && item.type !== 'carousel' ) removePhoto = true;


                            //White List
                            if (whiteList.length > 0 && whiteList != '' && !modMode.status == true){
                                if (whiteListIds.indexOf(item.id) === -1) {
                                    hidePhotos.push(item.id);
                                }
                            }

                            //Check the ID of the item to see if it matches any ID in the hidephotos array then skip it and don't iterate the imagesArrCount var
                            jQuery.each( hidePhotos, function( index, id ) {
                                if( item.id == jQuery.trim(id) ) removePhoto = true;
                            });
                            if(removePhoto){
                                removedPhotosCount++;
                                //Remove photo from imagesArr here so that it isn't cached
                                removePhotoIndexes.push(itemNumber);
                                return;
                            }

                            //Used to make sure we display the right amount of photos
                            itemCount++;

                            //This makes sure that only the correct number of photos is shown. So if num is set to 10 then it only shows the next 10 in the array. photosAvailable is subtracted from imagesArrCountOrig as imagesArrCountOrig is updated every time and we need to calculate how many photos are currently displayed in the feed in order to calculate how many to show.
                            if( itemCount > ( (imagesArrCountOrig-photosAvailable )+num) || itemCount <= imagesArrCountOrig ) return;

                            imagesArrCount++; //Keeps track of where we are in the images array


                            //Prevent duplicates
                            $i = $self.attr('data-sbi-index');
                            if( jQuery.inArray(item.id, window.sbiFeedMeta[$i].postsInFeed) > -1 ){
                                return; //Don't add image
                            } else {
                                //Store the IDs of the images added to the feed so we can prevent duplicates
                                window.sbiFeedMeta[$i].postsInFeed.push(item.id);
                            }


                            //FILTER:
                            //Video
                            var data_video = 'data-video=""';
                            if( item.type == 'video' ){
                                data_video = 'data-video="'+item.videos.standard_resolution.url + '"';
                            }

                            var data_carousel = 'data-carousel=""',
                                videoIsFirstCarouselItem = false;
                            if ( item.type === 'carousel' && typeof item.carousel_media !== 'undefined') {
                                var data_carousel_object = {};
                                jQuery.each(item.carousel_media,function(index,value) {
                                    if (typeof value.images !== 'undefined') {
                                        data_carousel_object[index] = {
                                            'type' : 'image',
                                            'media' : value.images.standard_resolution.url
                                        };
                                    } else if (typeof value.videos !== 'undefined') {
                                        data_carousel_object[index] = {
                                            'type' : 'video',
                                            'media' : value.videos.standard_resolution.url
                                        };

                                        if (index === 0) {
                                            videoIsFirstCarouselItem = true;
                                        }
                                    }
                                });
                                data_carousel = "data-carousel='"+JSON.stringify(data_carousel_object).replace(/'/g, "\\'")+"'";
                                if (typeof item.carousel_media[0].videos !== 'undefined') {
                                    data_video = 'data-video="'+item.carousel_media[0].videos.standard_resolution.url + '"';
                                }
                            }

                            //Image res
                            var data_image = item.images.standard_resolution.url;
                            switch( imgRes.type ){
                                case 'thumbnail':
                                    data_image = item.images.thumbnail.url;
                                    break;
                                case 'low_resolution':
                                    data_image = item.images.low_resolution.url;
                                    break;
                                case 'auto':
                                    imgRes = sbiGetResolutionSettings($self, var_this.getAttribute('data-res'), cols, colsmobile, $i);
                                    var thisImageReplace = sbiGetBestResolutionForAuto(imgRes.width,item.images.standard_resolution.width,item.images.standard_resolution.height,($self.hasClass('sbi_highlight')));
                                    switch (thisImageReplace) {
                                        case 320:
                                            data_image = item.images.low_resolution.url;
                                            break;
                                        case 150:
                                            data_image = item.images.thumbnail.url;
                                            break;
                                    }
                                    break;
                            }
                            data_image = data_image.split("?ig_cache_key")[0];

                            //Date
                            var canUseTranslations = sbiDateInternationalizationNotSupported() === false,
                                date = new Date(item.created_time*1000),
                                created_time_raw = item.created_time;

                            if (canUseTranslations) {
                                var options = { month: 'short', day: 'numeric' },
                                    itemDate = date.toLocaleDateString(sbiTranslations.DATE_FORMAT,options);
                            } else {
                                //Create time for sorting
                                //Create pretty date for display
                                var m = date.getMonth();
                                var d = date.getDate();
                                var month_names = new Array ( );
                                month_names[month_names.length] = sbiTranslate("Jan");
                                month_names[month_names.length] = sbiTranslate("Feb");
                                month_names[month_names.length] = sbiTranslate("Mar");
                                month_names[month_names.length] = sbiTranslate("Apr");
                                month_names[month_names.length] = sbiTranslate("May");
                                month_names[month_names.length] = sbiTranslate("Jun");
                                month_names[month_names.length] = sbiTranslate("Jul");
                                month_names[month_names.length] = sbiTranslate("Aug");
                                month_names[month_names.length] = sbiTranslate("Sep");
                                month_names[month_names.length] = sbiTranslate("Oct");
                                month_names[month_names.length] = sbiTranslate("Nov");
                                month_names[month_names.length] = sbiTranslate("Dec");
                                var itemDate = d + ' ' + month_names[m];
                            }

                            //Caption
                            var captionText = '';
                            if(item.caption != null && item.caption != ''){
                                //Replace double quotes in the captions with the HTML symbol
                                var captionText = typeof item.caption !== 'undefined' ? sbEncodeHTML(item.caption.text.replace(/"/g, "&quot;")) : '',
                                captionText = captionText.replace(/\n/g, "<br/>");
                            }

                            //Hover display info
                            if( feedOptions.hoverdisplay.indexOf('location') > -1 ){ var showHoverLocation = true; } else { var showHoverLocation = false; }
                            if( feedOptions.hoverdisplay.indexOf('caption') > -1 ){ var showHoverCaption = true; } else { var showHoverCaption = false; }
                            if( feedOptions.hoverdisplay.indexOf('likes') > -1 ){ var showHoverLikes = true; } else { var showHoverLikes = false; }
                            if( feedOptions.hoverdisplay.indexOf('username') > -1 ){ var showHoverUsername = true; } else { var showHoverUsername = false; }
                            if( feedOptions.hoverdisplay.indexOf('icon') > -1 ){ var showHoverIcon = true; } else { var showHoverIcon = false; }
                            if( feedOptions.hoverdisplay.indexOf('date') > -1 ){ var showHoverDate = true; } else { var showHoverDate = false; }
                            if( feedOptions.hoverdisplay.indexOf('instagram') > -1 ){ var showHoverInstagram = true; } else { var showHoverInstagram = false; }


                            //Location
                            if(item.location != null && item.caption != '' && showHoverLocation){
                                if(item.location.name == 'undefined' || item.location.name == null){
                                    var locationName = '';
                                } else {
                                    var sbi_lat = (item.location.hasOwnProperty("latitude")) ? 'data-lat="'+item.location.latitude+'"' : '',
                                        sbi_long = (item.location.hasOwnProperty("longitude")) ? 'data-long="'+item.location.longitude+'"' : '',
                                        locationName = '<a href="https://instagram.com/explore/locations/'+item.location.id+'" class="sbi_location" target="_blank" '+hovertextstyles+' '+sbi_lat+' '+sbi_long+'><i class="fa fa-map-marker"></i>'+item.location.name+'</a>';
                                }
                            } else {
                                var locationName = '';
                            }

                            var sbiCaptionHTML = '';
                            if(showHoverCaption){
                                sbiCaptionHTML = '<p class="sbi_caption" '+hovertextstyles+'>'+ captionText.substring(0, feedOptions.captionlength);
                                if( captionText.length > parseInt(feedOptions.captionlength) ) sbiCaptionHTML += '...';
                                sbiCaptionHTML += '</p>';
                            }

                            var sbiMetaHTML = '';
                            if(showHoverLikes){
                                sbiMetaHTML = '<div class="sbi_meta" style="color: #'+feedOptions.likescolor+';"><span class="sbi_likes" '+hovertextstyles+'><i class="fa fa-heart" '+hovertextstyles+'></i>'+commaSeparateNumber(item.likes.count)+'</span><span class="sbi_comments" '+hovertextstyles+'><i class="fa fa-comment" '+hovertextstyles+'></i>'+commaSeparateNumber(item.comments.count)+'</span></div>';
                            }

                            var sbiUsernameHTML = '';
                            if(showHoverUsername){
                                sbiUsernameHTML = '<p class="sbi_username"><a href="https://instagram.com/'+item.user.username+'" target="_blank" '+hovertextstyles+'>'+item.user.username+'</a></p>';
                            }

                            var sbiIconHTML = '';
                            if(showHoverIcon){
                                sbiIconHTML = '<i class="fa fa-arrows-alt"></i>';
                            }

                            var sbiDateHTML = '';
                            if(showHoverDate){
                                sbiDateHTML = '<span class="sbi_date"><i class="fa fa-clock"></i>'+itemDate + '</span>';
                            }

                            var sbiInstagramHTML = '';
                            if(showHoverInstagram){
                                sbiInstagramHTML = '<a class="sbi_instagram_link" href="'+item.link+'" target="_blank" title="Instagram" '+hovertextstyles+'><span class="sbi-screenreader">View on Instagram</span><i class="fa fa-instagram"></i></a>';
                            }

                            //If it's a carousel feed then set the image padding directly on the sbi_item as the inherit in the CSS file doesn't work
                            var carouselPadding = (carousel == true) ? ' style="padding: '+imagepadding+imagepaddingunit+' !important;"' : '';

                            var videoIsFirstCarouselItemClass = videoIsFirstCarouselItem ? ' sbi_carousel_vid_first' : '',
                                carouselTypeIcon = item.type === 'carousel' ? '<i class="fa fa-clone sbi_carousel_icon" aria-hidden="true"></i>': '';
                            var highlightClass = '';

                            if (hashtagsToHighlight.length > 0) {
                                jQuery.each(hashtagsToHighlight, function(index,val) {
                                    if (item.tags.indexOf(val) > -1) {
                                        highlightClass = ' sbi_highlighted';
                                    }
                                });
                            } else if (idsToHighlight.length > 0) {
                                if (idsToHighlight.indexOf(item.id) > -1) {
                                    highlightClass = ' sbi_highlighted';
                                }
                            }
                            //TEMPLATE:
                            imagesHTML += '<div class="sbi_item'+highlightClass+' sbi_type_'+item.type+videoIsFirstCarouselItemClass+' sbi_new sbi_transition" id="sbi_'+item.id+'" data-date="'+created_time_raw+'"'+carouselPadding+'><div class="sbi_photo_wrap">'+carouselTypeIcon+'<i class="fa fa-play sbi_playbtn"></i><div class="sbi_link'+sbiDefaultClass+'" '+hovercolorstyles+'><div class="sbi_hover_top">'+sbiUsernameHTML+sbiCaptionHTML+'</div>'+sbiInstagramHTML+'<div class="sbi_hover_bottom" '+hovertextstyles+'><p>'+sbiDateHTML+locationName+'</p>'+sbiMetaHTML+'</div><a class="sbi_link_area" href="'+item.images.standard_resolution.url+'" data-lightbox-sbi="'+$self.attr('data-sbi-index')+'" data-title="'+sbEncodeHTML(captionText)+'" '+data_video+data_carousel+' data-id="sbi_'+item.id+'" data-user="'+item.user.username+'" data-url="'+item.link+'" data-avatar="'+item.user.profile_picture+'"><span class="sbi-screenreader">Link to display lightbox</span><i class="fa fa-play sbi_playbtn" '+hovertextstyles+'></i><span class="sbi_lightbox_link" '+hovertextstyles+'>'+sbiIconHTML+'</span></a></div><a class="sbi_photo" href="'+item.link+'" target="_blank"><img src="'+data_image+'" alt="'+sbEncodeHTML(captionText)+'" width="200" height="200" /></a></div><div class="sbi_info"><p class="sbi_caption_wrap" '+sbiSettings.showcaption+'><span class="sbi_caption" style="color: #'+feedOptions.captioncolor+'; font-size: '+feedOptions.captionsize+'px;">'+sbEncodeHTML(captionText)+'</span><span class="sbi_expand"> <a href="#"><span class="sbi_more">...</span></a></span></p><div class="sbi_meta" style="color: #'+feedOptions.likescolor+'; '+sbiSettings.showlikes+'"><span class="sbi_likes" style="font-size: '+feedOptions.likessize+'px;"><i class="fa fa-heart" style="font-size: '+feedOptions.likessize+'px;"></i>'+commaSeparateNumber(item.likes.count)+'</span><span class="sbi_comments" style="font-size: '+feedOptions.likessize+'px;"><i class="fa fa-comment" style="font-size: '+feedOptions.likessize+'px;"></i>'+commaSeparateNumber(item.comments.count)+'</span></div></div>';

                            if(modMode.status === true) {
                                imagesHTML += modMode.addModHtml(item.user.username,item.id);
                            }

                            imagesHTML += '</div>';
                        }); //End images.data forEach loop

                        //Loop through and remove any photos from imagesArr which are hidden so that they're not cached
                        removePhotoIndexes.reverse(); //Reverse the indexes in the array so that it takes out the last items first and doesn't affect the order
                        jQuery.each( removePhotoIndexes, function( index, itemNumber ) {
                            imagesArr.data.splice(itemNumber, 1);
                        });

                        if( (imagesArrCount - imagesArrCountOrig) < num ) photosAvailable += imagesArrCount - imagesArrCountOrig;

                        //CACHE all of the photos in the imagesArr using ajax call to db after the photos have been displayed
                        var numWhiteListIds = feedOptions.sbiWhiteListIds.replace(/ /g,'').split(",").length;

                        if( ((imagesArrCount - imagesArrCountOrig) < num) && (photosAvailable < num) /*&& (numberOfPhotosDisplayed < num)*/ && (apiRequests < maxRequests) && !noMoreData && (imagesArrCount < numWhiteListIds || feedOptions.sbiWhiteList === '') ){ //Also check here whether next_url is available. If it's not then don't try to get more photos.
                            //Get more photos
                            var sbiFetchURL = imagesArr.pagination.next_url;

                            window.sbiCacheStatuses[feedOptions.feedIndex].feed = 'fetched';

                            sbiFetchData(sbiFetchURL, sbiTransientNames.feed, sbiSettings, $self);
                            //Set the flag so that we know to add the new photos to the imagesArr
                            sbiNewData = true;
                        } else {

                            //If there are enough photos
                            //Add the images to the feed
                            $self.find('#sbi_images').append(imagesHTML);
                            if ($self.find('#sbi_images').data('isotope')) {
                                // $self.find('.sbi_new').addClass('sbi_hide');
                                $self.find('#sbi_images').isotope('appended', jQuery('.sbi_new'));
                            }
                            sbiAfterImagesLoaded(imagesArr,sbiTransientNames.feed);

                            if( !$self.hasClass('sbi_masonry') && !$self.hasClass('sbi_highlight') && !$self.hasClass('sbi_carousel') ){
	                            //Loop through items and remove class to reveal them
	                            var time = 10;
	                            $self.find('.sbi_transition').each(function() {
								    var $sbi_item_transition_el = jQuery(this);

								    setTimeout( function(){
								    	$sbi_item_transition_el.removeClass('sbi_transition');
								    }, time)
								    time += 10;
								});
	                        }

                            imagesHTML = '';

                            //Remove the initial loader
                            $self.find('#sbi_images > .sbi_loader').remove();

                            //Show the Load More button
                            $self.find('#sbi_load').removeClass('sbi_hidden');
                            //Don't show the button if there aren't enough photos to fill the feed
                            if( imagesArrCount >= num ) $self.find('.sbi_load_btn').show();

                            setTimeout(function(){
	                        	//Hide the loader in the load more button
	                        	$loadBtn.find('.sbi_loader').addClass('sbi_hidden');
	                        	$loadBtn.find('.sbi_btn_text').removeClass('sbi_hidden');
	                        }, 500);
                        }


                        //AFTER:
                        //Things to add after the photos have been added
                        function sbiAfterImagesLoaded(imagesArr,transientName){

                            /* Scripts for each feed */
                            $self.find('.sbi_item').each(function(){

                                var $self = jQuery(this),
                                    $sbi_link_area = $self.find('.sbi_link_area');

                                //Change lightbox image to be full size
                                var $sbi_lightbox = jQuery('#sbi_lightbox');
                                $self.find('.sbi_lightbox_link').click(function(){
                                    $sbi_lightbox.removeClass('sbi_video_lightbox');
                                    if( $self.hasClass('sbi_type_video') ){
                                        $sbi_lightbox.addClass('sbi_video_lightbox');
                                        //Add the image as the poster so doesn't show an empty video element when clicking the first video link
                                        jQuery('.sbi_video').attr({
                                            'poster' : jQuery(this).attr('href')
                                        });

                                    }
                                });

                                //Expand post
                                var $post_text = $self.find('.sbi_info .sbi_caption'),
                                    text_limit = feedOptions.captionlength;
                                if (typeof text_limit === 'undefined' || text_limit == '') text_limit = 99999;

                                //Set the full text to be the caption (used in the image alt)
                                var full_text = $self.find('.sbi_photo img').attr('alt');
                                if(full_text == undefined) full_text = '';
                                var brCount = (full_text.match(/<br>/g) || []).length,
                                brAdjust = (typeof sb_instagram_js_options.br_adjust === 'undefined' || sb_instagram_js_options.br_adjust === '1');
                                if (brAdjust && brCount > 0 && full_text.indexOf('<br>') < text_limit) {
                                    var captionPadding = $post_text.closest('.sbi_caption_wrap').css("padding-left"),                                           captionWidth = $post_text.closest('.sbi_caption_wrap').width() - (parseInt(captionPadding) *2),
                                        fontSize = $post_text.css('font-size'),
                                        charactersPerLine = captionWidth/parseInt(fontSize)*1.85,
                                        maxCharsPerLine = Math.floor(charactersPerLine),
                                        projectedMaxLines = Math.ceil(text_limit/charactersPerLine);

                                    var splitCaption = full_text.split('<br>'),
                                        linesConsumed = 0,
                                        adjustedTextLimit = 0;
                                    jQuery.each(splitCaption,function() {

                                        var linesLeft = projectedMaxLines - linesConsumed;
                                        if (linesLeft > 0) {
                                            var thisLinesConsumed = Math.max(1,Math.ceil(this.length / charactersPerLine));
                                            adjustedTextLimit += Math.min(this.length + 4,linesLeft*maxCharsPerLine);
                                            linesConsumed += thisLinesConsumed;
                                        }
                                    });
                                    text_limit = adjustedTextLimit;
                                }

                                var short_text = full_text.substring(0,text_limit);

                                //Cut the text based on limits set
                                $post_text.html( sbEncodeHTML(short_text) );
                                //Show the 'See More' link if needed
                                if (full_text.length > text_limit) $self.find('.sbi_expand').show();
                                //Click function
                                $self.find('.sbi_expand a').unbind('click').bind('click', function(e){
                                    e.preventDefault();
                                    var $expand = jQuery(this);
                                    if ( $self.hasClass('sbi_caption_full') ){
                                        $post_text.html( sbEncodeHTML(short_text) );
                                        $self.removeClass('sbi_caption_full');
                                    } else {
                                        $post_text.html( sbEncodeHTML(full_text) );
                                        $self.addClass('sbi_caption_full');
                                    }
                                });

                                //Photo links
                                //If lightbox is disabled
                                if( disablelightbox == 'true' || captionlinks == 'true' ){

                                    if ( captionlinks == 'true' ) {
                                        function sbiUrlDetect(text) {
                                            var urlRegex = /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g;
                                            return text.match(urlRegex);
                                        }
                                        var cap = $self.find('img').attr('alt'),
                                            url = sbiUrlDetect(cap);
                                        if(url) {
                                            $self.find('a').attr('href', url);
                                        }
                                    }
                                    $self.find('.sbi_link').addClass('sbi_disable_lightbox');
                                    //If lightbox is enabled add lightbox links
                                } else {

                                    var $sbi_photo_wrap = $self.find('.sbi_photo_wrap'),
                                        $sbi_link = $sbi_photo_wrap.find('.sbi_link');

                                    if(feedOptions.hovereffect == 'none'){
                                        //launch lightbox on click
                                        $sbi_link.css('background', 'none').show();
                                        $sbi_link.find('*').hide().end().find('.sbi_link_area').show();
                                    } else {
                                        //Fade in links on hover
                                        $sbi_photo_wrap.hover(function(){
                                            //$sbi_link.fadeIn(200);
                                            // css transitions instead

                                            //Zoom effect
                                            $self.addClass('sbi_animate');
                                        }, function(){
                                            //$sbi_link.stop().fadeOut(600);

                                            //Zoom effect
                                            $self.removeClass('sbi_animate');
                                        });

                                    }

                                }

                            }); //End .sbi_item each

                            //Lightbox hide photo function
                            jQuery('.sbi_lightbox_action a').unbind().bind('click', function(){
                                jQuery(this).parent().find('.sbi_lightbox_tooltip').toggle();
                            });


                            //Sort posts by date
                            //only sort the new posts that are loaded in, not the whole feed, otherwise some photos will switch positions due to dates
                            $self.find('#sbi_images .sbi_item.sbi_new').sort(function (a, b) {
                                var aComp = jQuery(a).attr("data-date"),
                                    bComp = jQuery(b).attr("data-date");

                                if(sortby == 'none'){
                                    //Order by date
                                    return bComp - aComp;
                                } else {
                                    //Randomize
                                    return (Math.round(Math.random())-0.5);
                                }

                            }).appendTo( $self.find("#sbi_images") );

                            //Remove the new class after 500ms, once the sorting is done
                            setTimeout(function(){
                                // jQuery('#sbi_images .sbi_item.sbi_new').removeClass('sbi_new').addClass('sbi_fade_in');
                                jQuery('#sbi_images .sbi_item.sbi_new').removeClass('sbi_new');

                                //Reset the morePosts variable so we can check whether there are more posts every time the Load More button is clicked
                                morePosts = [];
                            }, 500);


                            var imagesArrLength = imagesArr.data.length;

                            //Adjust the imagesArr length to account for the hidden photos
                            // imagesArrLength = parseInt(imagesArrLength) - parseInt(removedPhotosCount); //June 13 2016 - the imagesArr length is already adjusted earlier and so don't need to adjust it again here
                            //Check initially whether we should show the Load More button. If it's coordinates then if the last API request returns no photos then there are no more to show.
                            if( ( (imagesArrCount >= imagesArrLength) && noMoreData ) || (getType == 'coordinates' && images.data.length == 0) ){
                                $loadBtn.hide();
                            }

                            //If all of the posts in the white list are visible, hide the load button
                            if(sbiSettings.whiteList.length && ($self.find('.sbi_item').length === sbiSettings.whiteListIds.length)){
                                $loadBtn.hide();
                            }

                            //Load More button
                            $self.find('#sbi_load .sbi_load_btn').off().on('click', function(){

                                jQuery(this).find('.sbi_loader').removeClass('sbi_hidden');
                                jQuery(this).find('.sbi_btn_text').addClass('sbi_hidden');
                                //Reset the photosAvailable var so it can be used again
                                photosAvailable = 0;

                                //Check the global var to see where we are in the array
                                imagesArrCount = parseInt(imagesArrCount);

                                //Adjust the imagesArr length to account for the hidden photos
                                imagesArrLength = imagesArr.data.length;
                                // imagesArrLength = parseInt(imagesArrLength) - parseInt(removedPhotosCount); //June 13 2016 - the imagesArr length is already adjusted earlier and so don't need to adjust it again here
                                var numWhiteListIds = feedOptions.sbiWhiteListIds.replace(/ /g,'').split(",").length;

                                //If there are enough photos left in the array then display them
                                if( (imagesArrCount + num) < imagesArrLength || noMoreData || (imagesArrCount >= numWhiteListIds && feedOptions.sbiWhiteList !== '' &&  modMode.status !== true) ){

                                    if(photosAvailable !== 'finished') sbiBuildFeed(images, transientName, sbiSettings, $self);
                                    //Unset the flag so that we know not to add these photos to the imagesArr again
                                    sbiNewData = false;

                                    //If there are no photos left in the array and there's no more data to load then hide the load more button
                                    if( ( (imagesArrCount >= imagesArrLength) && noMoreData ) || (getType == 'coordinates' && images.data.length == 0) ){
                                        $loadBtn.hide();
                                    }

                                    //If all of the posts in the white list are visible, hide the load button
                                    if(sbiSettings.whiteList.length && ($self.find('.sbi_item').length === sbiSettings.whiteListIds.length)){
                                        $loadBtn.hide();
                                    }

                                    //Else if there aren't enough photos left then hit the api again
                                } else {

                                    sbiFetchURL = imagesArr.pagination.next_url;
                                    window.sbiCacheStatuses[feedOptions.feedIndex].feed = 'fetched';
                                    sbiFetchData(sbiFetchURL, transientName, sbiSettings, $self);
                                    //Set the flag so that we know to add the new photos to the imagesArr
                                    sbiNewData = true;
                                    //Reset this to zero so that we can limit requests to 3 per button click
                                    apiRequests = 0;
                                }


                            }); //End click event
                            if(modMode.status === true) {
                                if(!modMode.$self.hasClass('sbi_mod_merged')) {
                                    modMode.setOriginalPosition();
                                    modMode.resizeFeed();
                                }
                                setTimeout(function () {
                                    modMode.$self.find('.sbi_item .sbi_photo').each(function () {
                                        if (!jQuery(this).hasClass('sbi_mod_changed')) {
                                            jQuery(this).click(function (e) {
                                                modMode.changeClickEvent(jQuery(this), e);
                                            });
                                            jQuery(this).addClass('sbi_mod_changed');
                                        }
                                    });
                                    setTimeout(function () {
                                        modMode.addModSettingsHtml();
                                        if (!modMode.$self.find('.sbi_mod_submit_mod').hasClass('sbi_initialized')) {
                                            modMode.$self.find('.sbi_mod_submit_mod').click(function () {
                                                modMode.submitSelected();
                                            });
                                        }
                                        modMode.$self.find('.sbi_mod_submit_mod').addClass('sbi_initialized');
                                        modMode.$self.find('.sbi_hide_show_radio').click(function () {
                                            modMode.updateHideOrShow(jQuery(this).val());
                                            modMode.updateDisplay();
                                        });
                                        modMode.$self.find('.sbi_mod_block_user').each(function() {
                                            if(!jQuery(this).hasClass('sbi_mod_changed')) {
                                                jQuery(this).click(function () {
                                                    modMode.updateBlockUser(jQuery(this));
                                                    modMode.updateDisplay();
                                                });
                                                jQuery(this).addClass('sbi_mod_changed');
                                            }
                                        });
                                        modMode.$self.find('.sbi_close_mod').click(function () {
                                            modMode.closeMod();
                                        });
                                        modMode.replaceInfoHtml();
                                        // needed for random bug
                                        jQuery('.sbi_item').each(function() {
                                            jQuery(this).css('height',jQuery('.sbi_photo_wrap').innerHeight()+jQuery('.sbi_info').innerHeight());
                                        });
                                        modMode.updateDisplay();
                                        modMode.$self.addClass('sbi_mod_merged');
                                        modMode.$self.find('.sbi_info').removeClass('sbi_info');
                                        modMode.initClickCopy();
                                    }, 600);

                                }, 350);
                            }

                            if(!$self.hasClass('sbi_carousel') && $self.hasClass('sbi_autoscroll')) {
                                sbiBindAutoScroll($self);
                            }

                            // Call Custom JS if it exists
                            if (typeof sbi_custom_js == 'function') setTimeout(function(){ sbi_custom_js(); }, 100);

                            if( imgRes !== 'thumbnail' && !$self.hasClass('sbi_masonry') ){
                                //This needs to be here otherwise it results in the following error for some sites: $self.find(...).sbi_imgLiquid() is not a function.
                                /*! imgLiquid v0.9.944 / 03-05-2013 https://github.com/karacas/imgLiquid */
                                var sbi_imgLiquid=sbi_imgLiquid||{VER:"0.9.944"};sbi_imgLiquid.bgs_Available=!1,sbi_imgLiquid.bgs_CheckRunned=!1,function(i){function t(){if(!sbi_imgLiquid.bgs_CheckRunned){sbi_imgLiquid.bgs_CheckRunned=!0;var t=i('<span style="background-size:cover" />');i("body").append(t),!function(){var i=t[0];if(i&&window.getComputedStyle){var e=window.getComputedStyle(i,null);e&&e.backgroundSize&&(sbi_imgLiquid.bgs_Available="cover"===e.backgroundSize)}}(),t.remove()}}i.fn.extend({sbi_imgLiquid:function(e){this.defaults={fill:!0,verticalAlign:"center",horizontalAlign:"center",useBackgroundSize:!0,useDataHtmlAttr:!0,responsive:!0,delay:0,fadeInTime:0,removeBoxBackground:!0,hardPixels:!0,responsiveCheckTime:500,timecheckvisibility:500,onStart:null,onFinish:null,onItemStart:null,onItemFinish:null,onItemError:null},t();var a=this;return this.options=e,this.settings=i.extend({},this.defaults,this.options),this.settings.onStart&&this.settings.onStart(),this.each(function(t){function e(){-1===u.css("background-image").indexOf(encodeURI(c.attr("src")))&&u.css({"background-image":'url("'+encodeURI(c.attr("src"))+'")'}),u.css({"background-size":g.fill?"cover":"contain","background-position":(g.horizontalAlign+" "+g.verticalAlign).toLowerCase(),"background-repeat":"no-repeat"}),i("a:first",u).css({display:"block",width:"100%",height:"100%"}),i("img",u).css({display:"none"}),g.onItemFinish&&g.onItemFinish(t,u,c),u.addClass("sbi_imgLiquid_bgSize"),u.addClass("sbi_imgLiquid_ready"),l()}function o(){function e(){c.data("sbi_imgLiquid_error")||c.data("sbi_imgLiquid_loaded")||c.data("sbi_imgLiquid_oldProcessed")||(u.is(":visible")&&c[0].complete&&c[0].width>0&&c[0].height>0?(c.data("sbi_imgLiquid_loaded",!0),setTimeout(r,t*g.delay)):setTimeout(e,g.timecheckvisibility))}if(c.data("oldSrc")&&c.data("oldSrc")!==c.attr("src")){var a=c.clone().removeAttr("style");return a.data("sbi_imgLiquid_settings",c.data("sbi_imgLiquid_settings")),c.parent().prepend(a),c.remove(),c=a,c[0].width=0,void setTimeout(o,10)}return c.data("sbi_imgLiquid_oldProcessed")?void r():(c.data("sbi_imgLiquid_oldProcessed",!1),c.data("oldSrc",c.attr("src")),i("img:not(:first)",u).css("display","none"),u.css({overflow:"hidden"}),c.fadeTo(0,0).removeAttr("width").removeAttr("height").css({visibility:"visible","max-width":"none","max-height":"none",width:"auto",height:"auto",display:"block"}),c.on("error",n),c[0].onerror=n,e(),void d())}function d(){(g.responsive||c.data("sbi_imgLiquid_oldProcessed"))&&c.data("sbi_imgLiquid_settings")&&(g=c.data("sbi_imgLiquid_settings"),u.actualSize=u.get(0).offsetWidth+u.get(0).offsetHeight/1e4,u.sizeOld&&u.actualSize!==u.sizeOld&&r(),u.sizeOld=u.actualSize,setTimeout(d,g.responsiveCheckTime))}function n(){c.data("sbi_imgLiquid_error",!0),u.addClass("sbi_imgLiquid_error"),g.onItemError&&g.onItemError(t,u,c),l()}function s(){var i={};if(a.settings.useDataHtmlAttr){var t=u.attr("data-sbi_imgLiquid-fill"),e=u.attr("data-sbi_imgLiquid-horizontalAlign"),o=u.attr("data-sbi_imgLiquid-verticalAlign");("true"===t||"false"===t)&&(i.fill=Boolean("true"===t)),void 0===e||"left"!==e&&"center"!==e&&"right"!==e&&-1===e.indexOf("%")||(i.horizontalAlign=e),void 0===o||"top"!==o&&"bottom"!==o&&"center"!==o&&-1===o.indexOf("%")||(i.verticalAlign=o)}return sbi_imgLiquid.isIE&&a.settings.ieFadeInDisabled&&(i.fadeInTime=0),i}function r(){var i,e,a,o,d,n,s,r,m=0,h=0,f=u.width(),v=u.height();void 0===c.data("owidth")&&c.data("owidth",c[0].width),void 0===c.data("oheight")&&c.data("oheight",c[0].height),g.fill===f/v>=c.data("owidth")/c.data("oheight")?(i="100%",e="auto",a=Math.floor(f),o=Math.floor(f*(c.data("oheight")/c.data("owidth")))):(i="auto",e="100%",a=Math.floor(v*(c.data("owidth")/c.data("oheight"))),o=Math.floor(v)),d=g.horizontalAlign.toLowerCase(),s=f-a,"left"===d&&(h=0),"center"===d&&(h=.5*s),"right"===d&&(h=s),-1!==d.indexOf("%")&&(d=parseInt(d.replace("%",""),10),d>0&&(h=s*d*.01)),n=g.verticalAlign.toLowerCase(),r=v-o,"left"===n&&(m=0),"center"===n&&(m=.5*r),"bottom"===n&&(m=r),-1!==n.indexOf("%")&&(n=parseInt(n.replace("%",""),10),n>0&&(m=r*n*.01)),g.hardPixels&&(i=a,e=o),c.css({width:i,height:e,"margin-left":Math.floor(h),"margin-top":Math.floor(m)}),c.data("sbi_imgLiquid_oldProcessed")||(c.fadeTo(g.fadeInTime,1),c.data("sbi_imgLiquid_oldProcessed",!0),g.removeBoxBackground&&u.css("background-image","none"),u.addClass("sbi_imgLiquid_nobgSize"),u.addClass("sbi_imgLiquid_ready")),g.onItemFinish&&g.onItemFinish(t,u,c),l()}function l(){t===a.length-1&&a.settings.onFinish&&a.settings.onFinish()}var g=a.settings,u=i(this),c=i("img:first",u);return c.length?(c.data("sbi_imgLiquid_settings")?(u.removeClass("sbi_imgLiquid_error").removeClass("sbi_imgLiquid_ready"),g=i.extend({},c.data("sbi_imgLiquid_settings"),a.options)):g=i.extend({},a.settings,s()),c.data("sbi_imgLiquid_settings",g),g.onItemStart&&g.onItemStart(t,u,c),void(sbi_imgLiquid.bgs_Available&&g.useBackgroundSize?e():o())):void n()})}})}(jQuery);

                                // Use imagefill to set the images as backgrounds so they can be square
                                !function () {
                                    var css = sbi_imgLiquid.injectCss,
                                        head = document.getElementsByTagName('head')[0],
                                        style = document.createElement('style');
                                    style.type = 'text/css';
                                    if (style.styleSheet) {
                                        style.styleSheet.cssText = css;
                                    } else {
                                        style.appendChild(document.createTextNode(css));
                                    }
                                    head.appendChild(style);
                                }();
                                if (!$self.hasClass('sbi_masonry')) {
                                    $self.find(".sbi_photo").sbi_imgLiquid({fill:true});
                                }
                            }

                            //Only check the width once the resize event is over
                            var sbi_delay = (function(){
                                var sbi_timer = 0;
                                return function(sbi_callback, sbi_ms){
                                    clearTimeout (sbi_timer);
                                    sbi_timer = setTimeout(sbi_callback, sbi_ms);
                                };
                            })();

                            jQuery(window).resize(function(){
                                sbi_delay(function(){
                                    sbiSetPhotoHeight();
                                    sbiGetItemSize();

                                    jQuery('.sbi').each(function() {
                                        var $sbiSelf = jQuery(this),
                                            $i = jQuery(this).attr('data-sbi-index');

                                        if ($sbiSelf.attr('data-res') ==='auto') {
                                            var oldRes = window.sbiFeedMeta[$i].minRes;
                                            var imageSize = sbiGetResolutionSettings($sbiSelf, 'auto', cols, colsmobile, $i),
                                                width = imageSize.width !== '' ? imageSize.width : sbiGetWidthForResType(imageSize.type);

                                            if (sbiNeedToRaiseRes(width,oldRes)) {
                                                window.sbiFeedMeta[$i].minRes = 640;
                                                $sbiSelf.find('.sbi_item').each(function() {
                                                    var newUrl = jQuery(this).find('.sbi_link_area').length ? jQuery(this).find('.sbi_link_area').attr('href') : '';
                                                    var oldUrl = jQuery(this).find('.sbi_photo img').attr('src'),
                                                        newRes = 640,
                                                        $photo = jQuery(this);
                                                    if (newUrl === '') {
                                                        if (oldUrl.indexOf('p'+oldRes+'x'+oldRes) > -1) {
                                                            newUrl = oldUrl.replace('p'+oldRes+'x'+oldRes,'p'+newRes+'x'+newRes);
                                                        } else if(oldUrl.indexOf('s'+oldRes+'x'+oldRes) > -1) {
                                                            newUrl = oldUrl.replace('s'+oldRes+'x'+oldRes,'s'+newRes+'x'+newRes);
                                                        }
                                                    }

                                                    $photo.find('.sbi_photo img').attr('src',newUrl);
                                                    $photo.find('.sbi_photo').css('background-image','url("'+newUrl+'")');
                                                });
                                            }
                                        }
                                    });

                                }, 500);
                            });

                            //Resize image height
                            function sbiSetPhotoHeight(){
                                var isHighlight = $self.hasClass('sbi_highlight'),
                                    isMasonry = $self.hasClass('sbi_masonry');

                                 if( imgRes !== 'thumbnail' && !isMasonry ){
                                    var sbi_photo_width = $self.find('.sbi_photo').eq(0).innerWidth();

                                    //Figure out number of columns for either desktop or mobile
                                    var sbi_num_cols = sbiGetColumnCount($self, parseInt(cols), parseInt(colsmobile));

                                    //Figure out what the width should be using the number of cols
                                     var imagesPadding = jQuery('#sbi_images').innerWidth() - jQuery('#sbi_images').width(),
                                         sbi_photo_width_manual = ( $self.find('#sbi_images').width() / sbi_num_cols ) - imagesPadding;
                                    //If the width is less than it should be then set it manually
                                    if( sbi_photo_width <= (sbi_photo_width_manual) ) sbi_photo_width = sbi_photo_width_manual;

                                    $self.find('.sbi_photo').css('height', sbi_photo_width);

                                    //Set the position of the carousel arrows
                                    setTimeout(function(){
                                    	//If there's 2 rows then adjust position
                                    	var sbi_ratio = 2;
                                    	if( $self.find('.sbi_owl2row-item').length ) sbi_ratio = 1;

	                                    var sbi_arrows_top = ($self.find('.sbi_photo').eq(0).innerWidth()/sbi_ratio);
	                                    if(imagepaddingunit == 'px') sbi_arrows_top += parseInt(imagepadding)*(2+(2-sbi_ratio));
	                                    $self.find('.sbi-owl-nav div').css('top', sbi_arrows_top);
	                                }, 100);
                                }
                                if (isMasonry || isHighlight) {

                                    var highlight = feedOptions.highlight.split(',');
                                        sbiMasonrySetSizes($self, cols, colsmobile, highlight, isHighlight);
                                    if ($self.find('#sbi_images').data('isotope')) {
                                        $self.find('#sbi_images').isotope('layout');
                                    }

                                    var $container = $self.find('#sbi_images'),
                                        columnWidth = '.sbi_item',
                                        calcCols = sbiGetColumnCount($self, parseInt(cols), parseInt(colsmobile));
                                    if (isHighlight) {
                                        columnWidth = $container.width() / calcCols;
                                    }

                                    $container.isotope({
                                        itemSelector: '.sbi_item',
                                        layoutMode: 'packery',
                                        transitionDuration: 0,
                                        // options...
                                        resizable: false, // disable normal resizing
                                        // set columnWidth to a percentage of container width
                                        masonry: { columnWidth: columnWidth }
                                    });

                                }

                            }
                            if(carousel == false) sbiSetPhotoHeight();

                            /* Detect when element becomes visible. Used for when the feed is initially hidden, in a tab for example. https://github.com/shaunbowe/jquery.visibilityChanged */
                            !function(i){var n={callback:function(){},runOnLoad:!0,frequency:100,sbiPreviousVisibility:null},c={};c.sbiCheckVisibility=function(i,n){if(jQuery.contains(document,i[0])){var e=n.sbiPreviousVisibility,t=i.is(":visible");n.sbiPreviousVisibility=t,null==e?n.runOnLoad&&n.callback(i,t):e!==t&&n.callback(i,t),setTimeout(function(){c.sbiCheckVisibility(i,n)},n.frequency)}},i.fn.sbiVisibilityChanged=function(e){var t=i.extend({},n,e);return this.each(function(){c.sbiCheckVisibility(i(this),t)})}}(jQuery);

                            //If the feed is initially hidden (in a tab for example) then check for when it becomes visible and set then set the height
                            jQuery(".sbi").filter(':hidden').sbiVisibilityChanged({
                                callback: function(element, visible) {
                                    sbiSetPhotoHeight();
                                    sbiGetItemSize();
                                },
                                runOnLoad: false
                            });

                            if(carousel == true){
                                setTimeout(function(){
                                    //Initiate carousel
                                    if( !carouselautoplay ) carouseltime = false;

                                    //Set defaults for responsive breakpoints
                                    var itemsTabletSmall = cols,
                                        itemsMobile = cols,
                                        arrows = carouselarrows ? 'onhover' : 'hide',
                                        autoplay = carouseltime !== false,
                                        has2rows = (carouselrows == 2),
                                        loop = (!carouselloop),
                                        afterUpdate = function() {
                                            setTimeout(function(){
                                                sbiSetPhotoHeight();
                                                sbiGetItemSize();
                                            }, 250);
                                        },
                                        afterInit = function() {
                                            sbSVGify($self);
                                            jQuery('#sb_instagram #sbi_images.sbi_carousel').fadeIn();
                                            setTimeout(function(){

                                            sbiSetPhotoHeight();
                                            sbiGetItemSize();
                                            jQuery('#sb_instagram #sbi_images.sbi_carousel .sbi_info, .sbi_owl2row-item,#sb_instagram #sbi_images.sbi_carousel').fadeIn();
                                            }, 50);

                                            setTimeout(function(){

                                                var $navElementsWrapper = $self.find('.sbi-owl-nav');
                                                if (arrows === 'onhover') {
                                                    // $navElementsWrapper.addClass('onhover');
                                                    // $self.on({
                                                    //     mouseenter: function () {
                                                    //         $navElementsWrapper.fadeIn();
                                                    //     },
                                                    //     mouseleave: function () {
                                                    //         $navElementsWrapper.fadeOut();
                                                    //     }
                                                    // });
                                                } else if (arrows === 'below') {
                                                    var $dots = $ctf.find('.ctf-owl-dots'),
                                                        $prev = $ctf.find('.ctf-owl-prev'),
                                                        $next = $ctf.find('.ctf-owl-next'),
                                                        $nav = $ctf.find('.ctf-owl-nav'),
                                                        $dot = $ctf.find('.ctf-owl-dot'),
                                                        widthDots = $dot.length * $dot.innerWidth(),
                                                        maxWidth = $ctf.innerWidth();

                                                    $prev.after($dots);

                                                    $nav.css('position', 'relative');
                                                    $next.css('position', 'absolute').css('top', '-6px').css('right', Math.max((.5 * $nav.innerWidth() - .5 * (widthDots) - $next.innerWidth() - 6), 0));
                                                    $prev.css('position', 'absolute').css('top', '-6px').css('left', Math.max((.5 * $nav.innerWidth() - .5 * (widthDots) - $prev.innerWidth() - 6), 0));
                                                } else if (arrows === 'hide') {
                                                    $navElementsWrapper.addClass('hide').hide();
                                                }
                                                sbSVGify($navElementsWrapper);
                                            }, 100);
                                        };

                                    //Disable mobile layout
                                    if( $self.hasClass('sbi_mob_col_auto') ) {
                                        itemsTabletSmall = 2;
                                        if( parseInt(cols) != 2 ) itemsMobile = 1;
                                        if( parseInt(cols) == 2 ) itemsMobile = 2; //If the cols are set to 2 then don't change to 1 col on mobile
                                    } else {
                                        itemsMobile = colsmobile;
                                    }

                                    $self.find(".sbi_carousel").sbiOwlCarousel({
                                        items: cols,
                                        loop: loop,
                                        rewind: !loop,
                                        autoplay: autoplay,
                                        autoplayTimeout: Math.max(carouseltime,2000),
                                        autoplayHoverPause: true,
                                        nav: true,
                                        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
                                        dots: carouselpag,
                                        owl2row: has2rows,
                                        responsive: {
                                            0: {
                                                items: itemsMobile
                                            },
                                            480: {
                                                items: itemsTabletSmall
                                            },
                                            640: {
                                                items: cols
                                            }
                                        },
                                        onUpdate: afterUpdate,
                                        onInitialize: afterInit
                                    });

                                }, 100);


                            } // End carousel

                            function sbiGetItemSize(){
                                $self.removeClass('sbi_small sbi_medium');
                                var sbiItemWidth = $self.find('.sbi_item').innerWidth();
                                if( sbiItemWidth > 120 && sbiItemWidth < 240 ){
                                    $self.addClass('sbi_medium');
                                } else if( sbiItemWidth <= 120 ){
                                    $self.addClass('sbi_small');
                                }
                            }

                            if(carousel !== true) sbiGetItemSize();
                            // caching done at the end of all posts in the images Array
                            if(!feedOptions.disablecache && typeof _cache !== 'undefined' && window.sbiCacheStatuses[feedOptions.feedIndex].feed === 'fetched') {
                                _cache(imagesArr,transientName); // cache_all_posts
                                window.sbiCacheStatuses[feedOptions.feedIndex].feed = 'cached';
                            }

                            if (!$self.find('.sbi_item').length && modMode.status === false && !$self.find('.sbi_too_much').length) {
                                $self.prepend('<div id="sbi_mod_error" class="sbi_too_much">No posts to display. You may be filtering out too many posts. See <a href="https://smashballoon.com/post-filtering-not-working/" target="_blank">this FAQ article</a> for some possible solutions</div>');
                                //sbi_set_use_backup
                                var submittedData = {
                                    action: 'sbi_set_use_backup',
                                    transientName : transientName
                                };
                                jQuery.ajax({
                                    url: sbiajaxurl,
                                    type: 'post',
                                    data: submittedData,
                                    success: function (data) {
                                    }
                                }); // ajax
                            }

                            // prevent sbiImagesReady from running code to get and display more posts
                            photosAvailable = 'finished';

                            var $i = $self.attr('data-sbi-index');
                            if (typeof window.sbiFeedMeta[$i].error.errorMsg === 'undefined' && $self.find('.sbi_item').first().find('.sbi_photo img').length && ($self.attr('data-res') === 'auto') || !isNaN($self.attr('data-res'))) {
                                var imgCheckUrl = $self.find('.sbi_item').first().find('.sbi_photo img').attr('src');
                                sbiImageExists(imgCheckUrl,function(exists) {
                                    if (!exists) {
                                        var submittedData = {
                                            action: 'sbi_cancel_custom_image_sizing'
                                        };
                                        jQuery.ajax({
                                            url: sbiajaxurl,
                                            type: 'post',
                                            data: submittedData,
                                            success: function (data) {
                                                console.log(data);
                                            }
                                        }); // ajax
                                        console.log(imgCheckUrl + ' does not exist');
                                    }
                                });
                            }

                            var isHighlight = $self.hasClass('sbi_highlight'),
                                isMasonry = $self.hasClass('sbi_masonry');
                            if (isHighlight || isMasonry) {

                            	var layoutDelay = 0;

                            	//If it's masonry then delay the reveal transition by a second to allow the items to be positioned
                            	if( isMasonry ){
                            		layoutDelay = 1000;
                            		//Initiate the isotope layout initially
									$self.find('#sbi_images').isotope('layout');
                            	}
                            	
                            	//Re-initiate the isotope layout multiple times
                                setTimeout(function() {
                                    $self.find('#sbi_images').isotope('layout');

                                    //Loop through items and remove class to reveal them after they've been laid out
		                            var time = 10;
		                            $self.find('.sbi_transition').each(function() {
									    var $sbi_item_transition_el = jQuery(this);
									    setTimeout( function(){
									    	$sbi_item_transition_el.removeClass('sbi_transition');
									    }, time)
									    time += 10;
									});
                                }, layoutDelay);

                                setTimeout(function() {
                                    $self.find('#sbi_images').isotope('layout');
                                }, 1500);
                                setTimeout(function() {
                                    $self.find('#sbi_images').isotope('layout');
                                }, 2000);

                                // Lay out the items again after clicking to see more text
                                $self.find('.sbi_more').click(function() {
                                    setTimeout(function () {
                                        $self.find('#sbi_images').isotope('layout');
                                    }, 200);
                                });
                            }

                            sbSVGify($self);

                        } // End sbiAfterImagesLoaded() function


                    } //End buildFeed function

                    function commaSeparateNumber(val){
                        while (/(\d+)(\d{3})/.test(val.toString())){
                            val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
                        }
                        return val;
                    }

                    function sbiBuildHeader(data, sbiSettings){

                        if(typeof data.meta.error_message !== 'undefined') return;

                        var feedOptions = sbiSettings.feedOptions,
                            headerType = feedOptions.headerstyle,
                            headerClasses = '';

                        var headerStyles = feedOptions.headercolor.length ? 'style="color: #'+feedOptions.headercolor+'"' : '';
                        if( ( ( typeof data.data.bio !== 'undefined' && data.data.bio.length == 0 ) || feedOptions.showbio != 'true' ) && feedOptions.showfollowers != 'true' ) {
                            headerClasses += ' sbi_no_info';
                        }
                        if( ( typeof data.data.bio !== 'undefined' && data.data.bio.length < 1 ) || feedOptions.showbio != 'true' ) {
                            headerClasses += ' sbi_no_bio';
                        }

                        $header = '<a href="https://instagram.com/'+data.data.username+'" target="_blank" title="@'+data.data.username+'" class="sbi_header_link" '+headerStyles+'>';
                        if (headerType === 'centered') {
                            $header += '<div class="sbi_header_img">';
                            $header += '<div class="sbi_header_img_hover"><i class="sbi_new_logo"></i></div>';
                            $header += '<img src="'+data.data.profile_picture+'" alt="'+sbEncodeHTML(data.data.full_name)+'" width="50" height="50">';
                            $header += '</div>';
                        }
                        $header += '<div class="sbi_header_text' + headerClasses + '">';
                            $header += '<h3 '+headerStyles+'>'+sbEncodeHTML(data.data.username)+'</h3>';
                        //Compile and add the header info
                        var $headerInfo = '<p class="sbi_bio_info" ';
                        if(feedOptions.headerstyle == 'boxed'){
                            $headerInfo += 'style="color: #' + feedOptions.headerprimarycolor + ';"';
                        } else {
                            $headerInfo += headerStyles;
                        }
                        if ( typeof data.data.counts !== 'undefined') $headerInfo += '><span class="sbi_posts_count"><i class="fa fa-image"></i>'+commaSeparateNumber(data.data.counts.media)+'</span><span class="sbi_followers"><i class="fa fa-user"></i>'+commaSeparateNumber(data.data.counts.followed_by)+'</span></p>';

                        if(feedOptions.showfollowers != '' && feedOptions.showfollowers != 'false' && feedOptions.headerstyle !== 'boxed') $header += $headerInfo;

                        //Add the bio
                        if( typeof data.data.bio !== 'undefined' && data.data.bio.length > 1 && feedOptions.showbio != '' && feedOptions.showbio != 'false' ) $header += '<p class="sbi_bio" '+headerStyles+'>'+sbEncodeHTML(data.data.bio)+'</p>';
                        $header += '</div>';
                        if (headerType !== 'centered') {
                            $header += '<div class="sbi_header_img">';
                            $header += '<div class="sbi_header_img_hover"><i class="sbi_new_logo"></i></div>';
                            $header += '<img src="'+data.data.profile_picture+'" alt="'+sbEncodeHTML(data.data.full_name)+'" width="50" height="50">';
                            $header += '</div>';
                        }

                        $header += '</a>';
                        if(feedOptions.headerstyle == 'boxed') {
                            $header += '<div class="sbi_header_bar" style="background: #'+feedOptions.headersecondarycolor+'">';
                            if(feedOptions.showbio != 'false') $header += $headerInfo;
                            $header += '<a class="sbi_header_follow_btn" href="https://instagram.com/'+data.data.username+'" target="_blank" style="color: #'+feedOptions.headercolor+'; background: #'+feedOptions.headerprimarycolor+';"><i class="sbi_new_logo"></i><span></span></div></div>';
                        }

                        //Add the header to the feed
                        if( $self.find('.sbi_header_link').length == 0 ) $self.find('.sb_instagram_header').prepend( $header );

                        //Change the URL of the follow button
                        if( $self.find('.sbi_follow_btn').length ) $self.find('.sbi_follow_btn a').attr('href', 'https://instagram.com/' + data.data.username );
                        //Change the text of the header follow button
                        if( feedOptions.headerstyle == 'boxed' && $self.find('.sbi_header_follow_btn').length ) $self.find('.sbi_header_follow_btn span').text( $self.find('.sb_instagram_header').attr('data-follow-text').replace(/\\/g, "") );


                        //Header profile pic hover
                        $self.find('.sb_instagram_header .sbi_header_link').hover(function(){
                            $self.find('.sb_instagram_header .sbi_header_img_hover').addClass('sbi_fade_in');
                        }, function(){
                            $self.find('.sb_instagram_header .sbi_header_img_hover').removeClass('sbi_fade_in');
                        });

                        sbSVGify($self.find('.sb_instagram_header'));
                    } // End sbiBuildHeader()


                    function sbiFetchData(next_url, transientName, sbiSettings, $self) {
                        apiURLs = next_url;
                        var urlCount = apiURLs.length,
                            getType = sbiSettings.getType;

                        //If the apiURLs array is empty then this means that there's no more next_urls and so hide the load more button
                        if( urlCount == 0 ){

                            if (typeof imagesArr !== 'undefined') {
                                //Don't hit the API any more
                                //If there's no more photos to retrieve then hide the load more button
                                if( imagesArrCount + parseInt(sbiSettings.num) >= imagesArr.data.length ){
                                    //Hide the Load More button
                                    jQuery('#sbi_load .sbi_load_btn').hide();
                                }
                            } else {
                                data = 'error';
                                if (!$self.find('#sbi_mod_error').length) {
                                    $self.prepend('<div id="sbi_mod_error"><p><b>No images available or could not make a request</b><br /><span>This error message is only visible to WordPress admins</span></p><p>If you are using a single post feed, make sure that you connect the account of the post you are trying to display.</p></div>');
                                }
                            }

                        } else {

                            var returnedImages = [],
                                numberOfRequests = urlCount;
                            jQuery.each(apiURLs, function(index, entry){

                                jQuery.ajax({
                                    method: "GET",
                                    url: entry,
                                    dataType: "jsonp",
                                    success: function(data) {
                                        //Pretty error messages
                                        var sbiErrorResponse = data.meta.error_message,
                                            sbiErrorMsg = '',
                                            sbiErrorDir = '';

                                        if(typeof sbiErrorResponse !== 'undefined'){

                                            if( sbiErrorResponse.indexOf('access_token') > -1 ){
                                                sbiErrorMsg += '<p><b>Error: Access Token is not valid or has expired</b><br /><span>This error message is only visible to WordPress admins</span></p>';
                                                sbiErrorDir = "<p>There's an issue with the Instagram Access Token that you are using. Please obtain a new Access Token on the plugin's Settings page.<br />If you continue to have an issue with your Access Token then please see <a href='https://smashballoon.com/my-instagram-access-token-keep-expiring/' target='_blank'>this FAQ</a> for more information.</p>";
                                                jQuery('#sb_instagram').empty().append( '<p style="text-align: center;">Unable to show Instagram photos</p><div id="sbi_mod_error">' + sbiErrorMsg + sbiErrorDir + '</div>');
                                                var splitUp = entry.split('?'),
                                                    splitUp = splitUp[1].split('&'),
                                                    accessTokenExpired = splitUp[0].replace('access_token=','');
                                                sbiAddTokenToExpiredList(accessTokenExpired);
                                                var submittedData = {
                                                    action: 'sbi_set_use_backup',
                                                    transientName : transientName
                                                };
                                                jQuery.ajax({
                                                    url: sbiajaxurl,
                                                    type: 'post',
                                                    data: submittedData,
                                                    success: function (data) {
                                                    }
                                                }); // ajax
                                                return;
                                            } else if( sbiErrorResponse.indexOf('retired') > -1 ){
                                                sbiErrorMsg += '<p><b>No longer possible to display this feed</b><br /><span>This error message is only visible to WordPress admins</span></p>';
                                                sbiErrorDir = "<p>Due to changes in the Instagram API, it is no longer possible to display a feed from an Instagram account which is not your own. You can now only display your own Instagram account. Please see <a href='https://smashballoon.com/instagram-api-changes-april-4-2018/' target='_blank'>this post</a> for more information.</p>";
                                                jQuery('#sb_instagram').empty().append( '<p style="text-align: center;">Unable to show Instagram photos</p><div id="sbi_mod_error">' + sbiErrorMsg + sbiErrorDir + '</div>');
                                                return;
                                                //requests per hour
                                            } else if( sbiErrorResponse.indexOf('user does not exist') > -1 || sbiErrorResponse.indexOf('you cannot view this resource') > -1 ){
                                                window.sbiFeedMeta[$i].error = {
                                                    errorMsg    : '<p><b>Error: User ID <span class="sbiErrorIds">'+window.sbiFeedMeta[$i].idsInFeed[index]+'</span> does not exist, is invalid, or is private</b><br /><span>This error is only visible to WordPress admins</span>',
                                                    errorDir    : "<p>Please double check that the Instagram User ID you are using is valid and not from a private account. To find your User ID simply enter your Instagram user name into this <a href='https://smashballoon.com/instagram-feed/find-instagram-user-id/' target='_blank'>tool</a>.</p>"
                                                };
                                                if (!$self.find('#sbi_mod_error').length) {
                                                    $self.prepend('<div id="sbi_mod_error">'+window.sbiFeedMeta[$i].error.errorMsg+window.sbiFeedMeta[$i].error.errorDir+'</div>');
                                                } else if ($self.find('.sbiErrorIds').text().indexOf(window.sbiFeedMeta[$i].idsInFeed[index]) == -1) {
                                                    $self.find('.sbiErrorIds').append(','+window.sbiFeedMeta[$i].idsInFeed[index]);
                                                }
                                                data = 'error';
                                            } else if( sbiErrorResponse.indexOf('invalid media id') > -1 ){
                                                window.sbiFeedMeta[$i].error = {
                                                    errorMsg    : '<p><b>Error: Post Id <span class="sbiErrorIds">'+window.sbiFeedMeta[$i].idsInFeed[index]+'</span> does not exist or is invalid</b><br /><span>This error is only visible to WordPress admins.</span>',
                                                    errorDir    : "<p>Please double check the media (post) id is correct.</p>"
                                                };
                                                if (!$self.find('#sbi_mod_error').length) {
                                                    $self.prepend('<div id="sbi_mod_error">'+window.sbiFeedMeta[$i].error.errorMsg+window.sbiFeedMeta[$i].error.errorDir+'</div>');
                                                } else if ($self.find('.sbiErrorIds').text().indexOf(window.sbiFeedMeta[$i].idsInFeed[index]) == -1) {
                                                    $self.find('.sbiErrorIds').append(','+window.sbiFeedMeta[$i].idsInFeed[index]);
                                                }
                                                data = 'error';
                                            }

                                        }

                                        //If it's a coordinates type then add the existing URL to the object so that we can use it to create the next URL for pagination
                                        if( getType == 'coordinates' ) data.pagination = {'previous_url':entry};

                                        if (data !== 'error') returnedImages.push(data);

                                        numberOfRequests--;
                                        if(numberOfRequests == 0 && photosAvailable !== 'finished') sbiImagesReady(getType);

                                    }

                                })

                            });

                            //When all of the images have been returned then pass them to the buildFeed function
                            function sbiImagesReady(getType){

                                var paginationArr = [],
                                    returnedImagesArr = [];

                                //Loop through the array of returned sets of data from the Instagram API
                                jQuery.each( returnedImages, function( index, object ) {

                                    if (typeof object.data !== 'undefined'){ //Check whether the returned object has data in it as error may be returned it
                                        if (Array.isArray(object.data) === false) {
                                            object.data = [ object.data ] ;
                                        }
                                        //Loop through each image object in the array and add it to the returnedImagesArr for sorting
                                        jQuery.each( object.data, function( index, image ) {

                                            //Filter out duplicate images here. This is after the items have been counted (used below for coordinates pagination) but before being cached as duplicate images don't need to be cached.
                                            if( jQuery.inArray(image.id, photoIds) > -1 ){
                                                //Duplicate image
                                            } else {
                                                photoIds.push(image.id);
                                                returnedImagesArr.push( image );
                                            }
                                        });


                                        if(getType == 'coordinates'){
                                            //If it's a coordinates then need to create the next_url string manually by using max_timestamp and then push it onto the array

                                            //Get the created_date of the last object so we can use it to create the next_url
                                            var lastCreatedTime = object.data[ object.data.length - 1 ].created_time,
                                                existing_url = object.pagination.previous_url,
                                                existing_url_parts = existing_url.split('max_timestamp='),
                                                new_url = existing_url_parts[0] + 'max_timestamp=' + lastCreatedTime;

                                            //If the number of photos returned (eg: 10) is less than the number the user wants to display (eg: 20) then there are no more photos to load for this coordinates
                                            paginationArr.push( new_url );

                                        } else {
                                            //If there's a next_url then add it to the pagination array
                                            if( typeof object.pagination === 'object' && !!object.pagination && typeof object.pagination.next_url !== 'undefined' ) paginationArr.push( object.pagination.next_url );
                                        }

                                    }

                                });

                                //Sort the images by date if not set to random
                                if(sortby !== 'random') {
                                    returnedImagesArr.sort(function(x, y){
                                        return y.created_time - x.created_time;
                                    });
                                } else {
                                    returnedImagesArr.sort(function (a, b) {
                                        //Randomize
                                        return (Math.round(Math.random())-0.5);
                                    });
                                    transientName += '!';
                                }

                                //Add the data and pagination objects to the first object in the array so that we can create a super object to send back
                                if (typeof returnedImages !== 'undefined') returnedImages[0].data = returnedImagesArr;

                                //Replace the next_url string with an array of URLs
                                //If it's a coordinates type then we need to create the pagination object here as it doesn't exist yet
                                if(typeof returnedImages[0].pagination !== 'undefined' && !!returnedImages[0].pagination) {
                                    //if( typeof returnedImages[0].pagination.next_url !== 'undefined' ) {
                                    returnedImages[0].pagination.next_url = paginationArr;
                                    //}
                                } else {
                                    returnedImages[0].pagination = {
                                        "next_url" : ""
                                    };
                                }
                                var allImages = returnedImages[0];
                                //Pass the returned images to the buildFeed function

                                if(photosAvailable !== 'finished') sbiBuildFeed(allImages, transientName, sbiSettings, $self);

                                //Iterate the API request variable so that we can limit of the number of subsequent API requests when the Load More button is clicked
                                apiRequests++;

                            } // End sbiImagesReady()

                        }

                    } //End sbiFetchData()

                    //Cache the likes and comments counts by sending an array via ajax to the main plugin file which then stores it in a transient
                    function sbiGetCache(transientName, sbiSettings, $self, cacheWhat, apiURLs){
                        var transientData = transientName;
                        window.sbiCommentCacheStatus = 0;
                        var thisIndex = $self[0].getAttribute('data-sbi-index');

                        // our initial request now sends all transient names at once
                        if (typeof transientName === 'object') {
                            transientData = JSON.stringify(transientName);
                        }
                        var getCacheOpts = {
                            url: sbiajaxurl,
                            type: 'POST',
                            async: true,
                            cache: false,
                            data:{
                                action: 'get_cache',
                                transientName: transientData,
                                useBackupHeader: window.sbiUseBackup[thisIndex].header,
                                useBackupFeed: window.sbiUseBackup[thisIndex].feed
                            },
                            success: function(data) {

                                //Decode the JSON to that it can be used again
                                data = decodeURI(data);
                                data = data.replace(/\\'/g, "'");

                                //Replace any escaped single quotes as it results in invalid JSON

                                data = data.replace(/\\'/g, "'");
                                //Convert the cached JSON string back to a JSON object
                                var jsonobj = JSON.parse( data );

                                if ( cacheWhat == 'all' ) {
                                    if (typeof jsonobj.header.error === 'undefined') {
                                        sbiBuildHeader(jsonobj.header, sbiSettings);
                                    }
                                    if (typeof jsonobj.feed.error === 'undefined') {
                                        if(photosAvailable !== 'finished') sbiBuildFeed(jsonobj.feed, transientName, sbiSettings, $self);
                                        if (typeof jsonobj.warning !== 'undefined') {
                                            var sbiErrorMsg = '<p><b>Cache Error: Looking for cache that doesn\'t exist. Now using a backup feed.</b><br /><span>This error is only visible to WordPress admins.</span>';
                                            var sbiErrorDir = "<p>If you are using a caching plugin, try enabling the option on the Customize tab 'Cache error API recheck' or 'Force cache to clear on interval'</p>";
                                            jQuery('#sb_instagram').before('<div id="sbi_mod_error">' + sbiErrorMsg + sbiErrorDir + '</div>');
                                        }
                                    } else {
                                        // get the index of the feed to check what processes have been done already
                                        feedOptions = JSON.parse($self[0].getAttribute('data-options'));
                                        var thisIndex = $self[0].getAttribute('data-sbi-index');
                                        feedOptions.feedIndex = thisIndex;
                                        // if the cache is unavailable and the user has enabled an attempt at the api, "tryfetch" is returned as the error
                                        if (window.sbiCacheStatuses[thisIndex].feed !== false && jsonobj.feed.error === 'tryfetch') {
                                            // on the second try, indicate that the cache isn't available to prevent this endless loop
                                            window.sbiCacheStatuses[thisIndex].feed = false;
                                            if (!$self.find('.sb_instagram_header .sbi_header_text').length) {
                                                window.sbiCacheStatuses[thisIndex].header = false;
                                            }

                                            // comments do not need to be retrieved
                                            window.sbiCacheStatuses[thisIndex].comments = 'no';
                                            // prevents multiple attempts
                                            feedOptions.tryFetch = true;
                                            // start from scratch with updated feed options and statuses
                                            if (typeof window.sbiCacheStatuses[feedOptions.feedIndex].tryFetch === 'undefined') sbiCreateFeed($self[0], feedOptions);
                                        } else if (window.sbiCacheStatuses[thisIndex].feed === true) {
                                            var sbiErrorMsg = '<p><b>Cache Error: Looking for cache that doesn\'t exist</b><br /><span>This error is only visible to WordPress admins.</span>';
                                            var sbiErrorDir = "<p>If you are using a caching plugin, try enabling the option on the Customize tab 'Cache error API recheck' or 'Force cache to clear on interval'</p>";
                                            jQuery('#sb_instagram').empty().append( '<p style="text-align: center;">Unable to show Instagram photos</p><div id="sbi_mod_error">' + sbiErrorMsg + sbiErrorDir + '</div>');
                                            //sbi_set_use_backup
                                            var submittedData = {
                                                action: 'sbi_set_use_backup',
                                                transientName : transientName,
                                                context : 'falsecache'
                                            };
                                            jQuery.ajax({
                                                url: sbiajaxurl,
                                                type: 'post',
                                                data: submittedData,
                                                success: function (data) {
                                                }
                                            }); // ajax
                                        }
                                    }
                                    if (jsonobj.header.error === 'tryfetch') {
                                        feedOptions = JSON.parse($self[0].getAttribute('data-options'));
                                        var thisIndex = $self[0].getAttribute('data-sbi-index');
                                        feedOptions.feedIndex = thisIndex;
                                        if (window.sbiCacheStatuses[thisIndex].header !== false) {
                                            if (!$self.find('.sb_instagram_header .sbi_header_text').length) {
                                                window.sbiCacheStatuses[thisIndex].header = false;
                                                feedOptions.tryFetch = true;
                                                // start from scratch with updated feed options and statuses
                                                if (typeof window.sbiCacheStatuses[feedOptions.feedIndex].tryFetch === 'undefined') sbiCreateFeed($self[0], feedOptions);

                                            }
                                        }
                                    }
                                    if (typeof jsonobj.comments.error === 'undefined') {
                                        sb_instagram_js_options.sbiPageCommentCache = jsonobj.comments;
                                    }

                                } else {
                                    if( cacheWhat == 'header' ){
                                        sbiBuildHeader(jsonobj, sbiSettings);
                                    } else {
                                        if(photosAvailable !== 'finished') sbiBuildFeed(jsonobj, transientName, sbiSettings, $self);
                                    }
                                }
                                //Pass the returned images to the buildFeed function

                            },
                            error: function(xhr,textStatus,e) {
                                console.log(e);
                                return;
                            }
                        };

                        jQuery.ajax(getCacheOpts);

                    }

                } // sbiCreateFeed

            }); // End jQuery('#sb_instagram.sbi').each

            function sbiBindAutoScroll($sbi) {
                //var scrollPosOffset = parseInt($sbi.attr('data-scroll-offset'));
                var scrollPosOffset = parseInt($sbi.attr('data-scrolldistance')),
                    sbiScrolled = 0;

                //Scroll the container if it has a height
                if ($sbi.hasClass('sbi_fixed_height')) {
                    $sbi.on('scroll.instagram-feed', function () {

                        var yScrollPos = $sbi.scrollTop(),
                            windowSize = $sbi.innerHeight(),
                            bodyHeight = $sbi[0].scrollHeight,
                            triggerDistance = bodyHeight - scrollPosOffset - windowSize;

                        if (yScrollPos > triggerDistance) {
                            $sbi.unbind('scroll.instagram-feed');
                            if (sbiScrolled === 0) {
                                sbiScrolled = 1;
                                $sbi.find('.sbi_load_btn').trigger('click');
                            }
                        }
                    });
                    //Scrolling the window
                } else {
                    jQuery(window).on('scroll.instagram-feed', function () {
                        var yScrollPos = window.pageYOffset,
                            windowSize = window.innerHeight,
                            bodyHeight = document.body.offsetHeight,
                            triggerDistance = bodyHeight - scrollPosOffset - windowSize;

                        if (yScrollPos > triggerDistance) {
                            jQuery(window).unbind('scroll.instagram-feed');
                            if (sbiScrolled === 0) {
                                sbiScrolled = 1;
                                $sbi.find('.sbi_load_btn').trigger('click');
                            }
                        }
                    });
                }

            }

        }


    } // sb_init

    function sbiAddTokenToExpiredList(access_token) {
        var accessTokenOpts = {
            url: sbiajaxurl,
            type: 'POST',
            async: true,
            cache: false,
            data:{
                action: 'sbi_set_expired_token',
                access_token: access_token
            },
            success: function(response) {
                return;
            },
            error: function(xhr,textStatus,e) {
                console.log(e);
                return;
            }
        };
        jQuery.ajax(accessTokenOpts);
    }

    function sbiCachePhotos(images, transientName){
        //Convert the JSON object to a string
        var jsonstring = JSON.stringify( images );
        //Encode the JSON string so that it can be stored in the database
        jsonstring = encodeURI(jsonstring);

        if (jsonstring.indexOf('%7B%22') === 0) {
            var setCacheOpts = {
                url: sbiajaxurl,
                type: 'POST',
                async: true,
                cache: false,
                data:{
                    action: 'cache_photos',
                    photos: jsonstring,
                    transientName: transientName,
                },
                success: function(response) {
                    if ( response.indexOf('too much filtering') > -1) {
                        var useBackupOpts = {
                            url: sbiajaxurl,
                            type: 'POST',
                            async: true,
                            cache: false,
                            data: {
                                action: 'set_use_backup',
                                transientName: transientName,
                            },
                            success: function (response) {
                                console.log(response)
                            }
                        };
                        jQuery.ajax(useBackupOpts);
                    }
                    return;
                },
                error: function(xhr,textStatus,e) {
                    console.log(e);
                    return;
                }
            };
            jQuery.ajax(setCacheOpts);
        }

    }

    //function function sbiSetPhotoHeight(){
    function sbiGetColumnCount($self, cols, colsmobile) {
        var sbi_num_cols = cols,
            sbiWindowWidth = window.innerWidth;

        if( $self.hasClass('sbi_mob_col_auto') ){
            if( sbiWindowWidth < 640 && (parseInt(cols) > 2 && parseInt(cols) < 7 ) ) sbi_num_cols = 2;
            if( sbiWindowWidth < 640 && (parseInt(cols) > 6 && parseInt(cols) < 11 ) ) sbi_num_cols = 4;
            if( sbiWindowWidth <= 480 && parseInt(cols) > 2 ) sbi_num_cols = 1;
        } else if (sbiWindowWidth <= 480){
            sbi_num_cols = colsmobile;
        }

        return sbi_num_cols;
    }

    function sbiGetTransientName(feedType,loopArray,prefix,suffix,override) {
        var transientName = prefix;

        if (feedType === 'user') {
            transientName += loopArray.users.join('');
        } else if (feedType === 'hashtag') {
            var fullTag = encodeURIComponent(loopArray.hashtags.join('')).replace(/%/g,""),
                transientTermLength = fullTag.length < 20 ? fullTag.length : 20;

            transientName += encodeURIComponent(loopArray.hashtags.join('')).replace(/%/g,"").substr(0,transientTermLength);
        } else if (feedType === 'location') {
            transientName += loopArray.locations.join('');
        } else if (feedType === 'coordinates') {
            transientName += loopArray.coordinates.join('').replace(/[,().-]/g,"");
        } else if (feedType === 'single') {
            jQuery.each(loopArray.singles, function(index, value) {
                transientName +=  value.substr(10,9);
            });
        } else if (feedType === 'mixed') {
            transientName += loopArray.users.join('');
            jQuery.each(loopArray.hashtags, function(index, value) {
                transientName +=  value.substr(0,7);
            });
            transientName += loopArray.locations.join('');
            transientName += loopArray.coordinates.join('').replace(/[,().-]/g,"");
            jQuery.each(loopArray.singles, function(index, value) {
                transientName +=  value.substr(10,9);
            });
        }

        transientName += suffix;

        return transientName;
    }

    function sbiGetWidthForResType(type) {
        switch (type) {
            case 'thumbnail':
                return 150;
            case 'low_resolution':
                return 320;
            default:
                return 640;
        }
    }

    function sbiGetBestResolutionForAuto(colWidth,imageWidth,imageHeight,isHighlight) {

        var aspectRatio = Math.max(1,imageWidth/imageHeight),
            bestWidth = colWidth*aspectRatio,
            bestWidthRounded = Math.ceil(bestWidth / 10) * 10,
            customSizes = [150,320,640];

        if (isHighlight) {
            bestWidthRounded = bestWidthRounded*2;
        }

        if (customSizes.indexOf(parseInt(bestWidthRounded)) === -1) {
            var done = false;
            jQuery.each(customSizes, function (index, item) {
                if (item > parseInt(bestWidthRounded) && !done) {
                    bestWidthRounded = item;

                    done = true;
                }
            });
        }

        return bestWidthRounded;
    }

    function sbiImageExists(url, callback) {
        var img = new Image();
        img.onload = function() { callback(true); };
        img.onerror = function() { callback(false); };
        img.src = url;
    }

// Sample usage


    function sbiNeedToRaiseRes(width,oldRes) {
        return (width > oldRes);
    }

    function sbiGetResolutionSettings($self, imgRes, cols, colsmobile, $i) {
        var photoPadding = parseInt(($self.find('#sbi_images').outerWidth() - $self.find('#sbi_images').width())) / 2,
            cols = sbiGetColumnCount($self, parseInt(cols), parseInt(colsmobile)),
            colWidth = ($self.innerWidth() / cols) - photoPadding,
            imgResReturn = {
                'type'  : 'low_resolution',
                'width' : ''
            };

        switch(imgRes) {
            case 'auto':
                imgResReturn.type = 'auto';
                imgResReturn.width = colWidth;

                break;
            case 'thumb':
                imgResReturn.type = 'thumbnail';
                break;
            case 'medium':
                imgResReturn.type = 'low_resolution';
                break;
            default:
                // do custom sizes if set
                imgResReturn.type = 'standard_resolution';
        }

        if ( typeof window.sbiFeedMeta[$i].minRes === 'undefined' ) {
            window.sbiFeedMeta[$i].minRes = imgResReturn.type === 'auto' ? sbiGetBestResolutionForAuto(colWidth,imgResReturn.width,imgResReturn.width,$self.hasClass('sbi_highlight')): sbiGetWidthForResType(imgResReturn.type);
        }

        return imgResReturn;
    }
    // Called at the very end of the feed creation process
    // Takes all of the data retrieved from the API during the feed creation process and caches it
    function sbi_cache_all(imagesArr,transientName) {
        if (transientName.indexOf('header') && typeof imagesArr.data.pagination === 'undefined') {
            sbiCachePhotos(imagesArr,transientName);
        } else if (!transientName.indexOf('header') && typeof imagesArr.data.pagination !== 'undefined') {
            sbiCachePhotos(imagesArr,transientName);
        }
    }
    function sbiMasonrySetSizes($self,cols,colsmobile,highlight,isHighlight) {
        var feedWidth = $self.innerWidth(),
            photoPadding = parseInt(($self.find('#sbi_images').outerWidth() - $self.find('#sbi_images').width())) / 2,
            cols = sbiGetColumnCount($self, parseInt(cols), parseInt(colsmobile)),
            feedWidthSansPadding = feedWidth - (photoPadding * (cols+2)),
            colWidth = (feedWidthSansPadding / cols),
            highlightType = (typeof highlight === 'object') ? highlight[0] : '',
            firstBigify = highlightType === 'pattern' ? parseInt(highlight[2]) : 0,
            widthAdjustForPercentPadding = $self.find('#sbi_images').css('padding').indexOf('.') > -1 ? 1 : 0;

        // set the highlighted post to a maximum size of the containing element
        if (cols === 1 && !$self.hasClass('sbi_mob_col_auto')) {
            isHighlight = false;
        }
        if (isHighlight && (colWidth) * 2 > feedWidthSansPadding) {
            if ($self.hasClass('sbi_mob_col_auto')) {
                cols = 2;
            }
            feedWidthSansPadding = feedWidth - (photoPadding * (cols+2));
            colWidth = feedWidthSansPadding/cols;
        }

        $self.find('.sbi_item').each(function(index) {
            var shouldBigify = false;

            if (highlightType === 'pattern') {
                if (index === firstBigify || (index>firstBigify && (index) % parseInt(highlight[1]) === 0)) {
                    shouldBigify = true;
                }
            } else {
                shouldBigify = jQuery(this).hasClass('sbi_highlighted');
            }
            if (isHighlight && shouldBigify) {
                jQuery(this).css({
                    height: ((colWidth * 2) - widthAdjustForPercentPadding)  + 'px',
                    width: ((colWidth * 2) - widthAdjustForPercentPadding) + 'px'
                });
                jQuery(this).find('.sbi_photo').css({
                    height: (colWidth * 2) + 'px'
                });
            } else if (isHighlight) {
                jQuery(this).css({
                    height: ((colWidth )- photoPadding - widthAdjustForPercentPadding) + 'px',
                    width: ((colWidth )- photoPadding - widthAdjustForPercentPadding) + 'px'
                });
                jQuery(this).find('.sbi_photo').css({
                    height: (colWidth )- photoPadding + 'px'
                });
            } else {
                jQuery(this).css({
                    width: (colWidth) - photoPadding + 'px',
                });
                if (!$self.hasClass('sbi_masonry')) {
                    jQuery(this).css({
                        height: (colWidth)- photoPadding + 'px'
                    });
                }

            }
        });

    }

    function sbiDateInternationalizationNotSupported() {
        if ( typeof sbiTranslations === 'undefined' ) {
            return true;
        } else {
            var locale = sbiTranslations.DATE_FORMAT;
            try {
                new Date().toLocaleDateString(locale);
            } catch (e) {
                return e.name === 'RangeError';
            }
            return false;
        }
    }

    function sbiTranslate(origString) {
        if (typeof sbiTranslations === 'undefined') {
            return origString;
        } else {

            if (typeof sbiTranslations[origString]  !== 'undefined') {
                return sbiTranslations[origString];
            } else {
                return origString;
            }

        }
    }

    jQuery( document ).ready(function() {
        window.sbiCommentCacheStatus = 0;
        sbi_init(function(imagesArr,transientName) {
            sbi_cache_all(imagesArr,transientName);
        });

    });

    // detect if touch device and disable hover
    window.addEventListener('touchstart', function onFirstTouch() {

        jQuery('.sbi_photo').off('hover');
        jQuery('.sbi_photo_wrap').off('hover');
        jQuery('.sbi_link *').css('opacity',0);

        window.removeEventListener('touchstart', onFirstTouch, false);
    }, false);

    //Dismiss the frontend notice
    jQuery('#sb_instagram .sbi_close_notice').on('click', function(e){
        e.preventDefault();
        jQuery(this).closest('.sbi_frontend_notice').remove();

        jQuery.ajax({
            url : sbiajaxurl,
            type : 'post',
            data : {
                action : 'sbi_dismiss_frontend_notices'
            }
        });
    });

} // end sbi_js_exists check