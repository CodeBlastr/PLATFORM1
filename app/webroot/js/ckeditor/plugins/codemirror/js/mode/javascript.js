﻿CodeMirror.defineMode("javascript",function(R,p){var v,j,n,w;function E(a,d){for(var c=!1,f;null!=(f=a.next());){if(f==d&&!c)return!1;c=!c&&"\\"==f}return c}function k(a,d,c){r=a;F=c;return d}function s(a,d){var c=a.next();if('"'==c||"'"==c)return c=S(c),d.tokenize=c,c(a,d);if(/[\[\]{}\(\),;\:\.]/.test(c))return k(c);if("0"==c&&a.eat(/x/i))return a.eatWhile(/[\da-f]/i),k("number","number");if(/\d/.test(c)||"-"==c&&a.eat(/\d/))return a.match(/^\d*(?:\.\d*)?(?:[eE][+\-]?\d+)?/),k("number","number");
if("/"==c){if(a.eat("*"))return c=G,d.tokenize=c,c(a,d);if(a.eat("/"))return a.skipToEnd(),k("comment","comment");if("operator"==d.lastType||"keyword c"==d.lastType||/^[\[{}\(,;:]$/.test(d.lastType))return E(a,"/"),a.eatWhile(/[gimy]/),k("regexp","string-2");a.eatWhile(x);return k("operator",null,a.current())}if("#"==c)return a.skipToEnd(),k("error","error");if(x.test(c))return a.eatWhile(x),k("operator",null,a.current());a.eatWhile(/[\w\$_]/);var c=a.current(),f=H.propertyIsEnumerable(c)&&H[c];return f&&
"."!=d.lastType?k(f.type,f.style,c):k("variable","variable",c)}function S(a){return function(d,c){E(d,a)||(c.tokenize=s);return k("string","string")}}function G(a,d){for(var c=!1,f;f=a.next();){if("/"==f&&c){d.tokenize=s;break}c="*"==f}return k("comment","comment")}function I(a,d,c,f,b,e){this.indented=a;this.column=d;this.type=c;this.prev=b;this.info=e;null!=f&&(this.align=f)}function l(){for(var a=arguments.length-1;0<=a;a--)v.push(arguments[a])}function b(){l.apply(null,arguments);return!0}function y(a){function d(c){for(;c;c=
c.next)if(c.name==a)return!0;return!1}var c=j;c.context?(n="def",d(c.localVars)||(c.localVars={name:a,next:c.localVars})):d(c.globalVars)||(c.globalVars={name:a,next:c.globalVars})}function J(){j.context={prev:j.context,vars:j.localVars};j.localVars=T}function K(){j.localVars=j.context.vars;j.context=j.context.prev}function i(a,d){var c=function(){var c=j;c.lexical=new I(c.indented,w.column(),a,null,c.lexical,d)};c.lex=!0;return c}function e(){var a=j;a.lexical.prev&&(")"==a.lexical.type&&(a.indented=
a.lexical.indented),a.lexical=a.lexical.prev)}function h(a){return function(d){return d==a?b():";"==a?l():b(arguments.callee)}}function o(a){return"var"==a?b(i("vardef"),z,h(";"),e):"keyword a"==a?b(i("form"),g,o,e):"keyword b"==a?b(i("form"),o,e):"{"==a?b(i("}"),A,e):";"==a?b():"function"==a?b(B):"for"==a?b(i("form"),h("("),i(")"),U,h(")"),e,o,e):"variable"==a?b(i("stat"),V):"switch"==a?b(i("form"),g,i("}","switch"),h("{"),A,e,e):"case"==a?b(g,h(":")):"default"==a?b(h(":")):"catch"==a?b(i("form"),
J,h("("),L,h(")"),o,e,K):l(i("stat"),g,h(";"),e)}function g(a){return M.hasOwnProperty(a)?b(m):"function"==a?b(B):"keyword c"==a?b(N):"("==a?b(i(")"),N,h(")"),e,m):"operator"==a?b(g):"["==a?b(i("]"),t(g,"]"),e,m):"{"==a?b(i("}"),t(W,"}"),e,m):b()}function N(a){return a.match(/[;\}\)\],]/)?l():l(g)}function m(a,d){if("operator"==a)return/\+\+|--/.test(d)?b(m):"?"==d?b(g,h(":"),g):b(g);if(";"!=a){if("("==a)return b(i(")"),t(g,")"),e,m);if("."==a)return b(X,m);if("["==a)return b(i("]"),g,h("]"),e,m)}}
function V(a){return":"==a?b(e,o):l(m,h(";"),e)}function X(a){if("variable"==a)return n="property",b()}function W(a){if("variable"==a)n="property";else if("number"==a||"string"==a)n=a+" property";if(M.hasOwnProperty(a))return b(h(":"),g)}function t(a,d){function c(f){return","==f?b(a,c):f==d?b():b(h(d))}return function(f){return f==d?b():l(a,c)}}function A(a){return"}"==a?b():l(o,A)}function O(a){return":"==a?b(Y):l()}function Y(a){return"variable"==a?(n="variable-3",b()):l()}function z(a,d){return"variable"==
a?(y(d),C?b(O,D):b(D)):l()}function D(a,d){if("="==d)return b(g,D);if(","==a)return b(z)}function U(a){return"var"==a?b(z,h(";"),u):";"==a?b(u):"variable"==a?b(Z):b(u)}function Z(a,d){return"in"==d?b(g):b(m,u)}function u(a,d){return";"==a?b(P):"in"==d?b(g):b(g,h(";"),P)}function P(a){")"!=a&&b(g)}function B(a,d){if("variable"==a)return y(d),b(B);if("("==a)return b(i(")"),J,t(L,")"),e,o,K)}function L(a,d){if("variable"==a)return y(d),C?b(O):b()}var q=R.indentUnit,Q=p.json,C=p.typescript,H=function(){function a(a){return{type:a,
style:"keyword"}}var d=a("keyword a"),c=a("keyword b"),b=a("keyword c"),e=a("operator"),g={type:"atom",style:"atom"},d={"if":d,"while":d,"with":d,"else":c,"do":c,"try":c,"finally":c,"return":b,"break":b,"continue":b,"new":b,"delete":b,"throw":b,"var":a("var"),"const":a("var"),let:a("var"),"function":a("function"),"catch":a("catch"),"for":a("for"),"switch":a("switch"),"case":a("case"),"default":a("default"),"in":e,"typeof":e,"instanceof":e,"true":g,"false":g,"null":g,undefined:g,NaN:g,Infinity:g};
if(C){var c={type:"variable",style:"variable-3"},c={"interface":a("interface"),"class":a("class"),"extends":a("extends"),constructor:a("constructor"),"public":a("public"),"private":a("private"),"protected":a("protected"),"static":a("static"),"super":a("super"),string:c,number:c,bool:c,any:c},i;for(i in c)d[i]=c[i]}return d}(),x=/[+\-*&%=<>!?|]/,r,F,M={atom:!0,number:!0,variable:!0,string:!0,regexp:!0};v=n=j=null;w=void 0;var T={name:"this",next:{name:"arguments"}};e.lex=!0;return{startState:function(a){return{tokenize:s,
lastType:null,cc:[],lexical:new I((a||0)-q,0,"block",!1),localVars:p.localVars,globalVars:p.globalVars,context:p.localVars&&{vars:p.localVars},indented:0}},token:function(a,d){a.sol()&&(d.lexical.hasOwnProperty("align")||(d.lexical.align=!1),d.indented=a.indentation());if(a.eatSpace())return null;var c=d.tokenize(a,d);if("comment"==r)return c;d.lastType=r;var b;a:{var e=r,i=F,h=d.cc;j=d;w=a;n=null;v=h;d.lexical.hasOwnProperty("align")||(d.lexical.align=!0);for(;;)if((h.length?h.pop():Q?g:o)(e,i)){for(;h.length&&
h[h.length-1].lex;)h.pop()();if(n){b=n;break a}if(b="variable"==e)b:{for(b=d.localVars;b;b=b.next)if(b.name==i){b=!0;break b}b=void 0}if(b){b="variable-2";break a}b=c;break a}}return b},indent:function(a,b){if(a.tokenize==G)return CodeMirror.Pass;if(a.tokenize!=s)return 0;var c=b&&b.charAt(0),f=a.lexical;"stat"==f.type&&"}"==c&&(f=f.prev);var e=f.type,g=c==e;return"vardef"==e?f.indented+("operator"==a.lastType||","==a.lastType?4:0):"form"==e&&"{"==c?f.indented:"form"==e?f.indented+q:"stat"==e?f.indented+
("operator"==a.lastType||","==a.lastType?q:0):"switch"==f.info&&!g?f.indented+(/^(?:case|default)\b/.test(b)?q:2*q):f.align?f.column+(g?0:1):f.indented+(g?0:q)},electricChars:":{}",jsonMode:Q}});CodeMirror.defineMIME("text/javascript","javascript");CodeMirror.defineMIME("text/ecmascript","javascript");CodeMirror.defineMIME("application/javascript","javascript");CodeMirror.defineMIME("application/ecmascript","javascript");CodeMirror.defineMIME("application/json",{name:"javascript",json:!0});
CodeMirror.defineMIME("text/typescript",{name:"javascript",typescript:!0});CodeMirror.defineMIME("application/typescript",{name:"javascript",typescript:!0});