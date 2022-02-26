/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!*************************************************************************!*\
  !*** ./resources/backend/core/js/custom/documentation/general/typed.js ***!
  \*************************************************************************/
 // Class definition

var KTGeneralTypedJsDemos = function () {
  // Private functions
  var exampleBasic = function exampleBasic() {
    var typed = new Typed("#kt_typedjs_example_1", {
      strings: ["First sentence.", "Second sentence.", "Third sentense", "And some longer sentence"],
      typeSpeed: 30
    });
  };

  return {
    // Public Functions
    init: function init() {
      exampleBasic();
    }
  };
}(); // On document ready


KTUtil.onDOMContentLoaded(function () {
  KTGeneralTypedJsDemos.init();
});
/******/ })()
;