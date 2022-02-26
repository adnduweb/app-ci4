/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!************************************************************************!*\
  !*** ./resources/backend/core/js/custom/documentation/forms/dialer.js ***!
  \************************************************************************/
 // Class definition

var KTFormsDialerDemos = function () {
  // Private functions
  var example1 = function example1(element) {
    // Dialer container element
    var dialerElement = document.querySelector("#kt_dialer_example_1"); // Create dialer object and initialize a new instance

    var dialerObject = new KTDialer(dialerElement, {
      min: 1000,
      max: 50000,
      step: 1000,
      prefix: "$",
      decimals: 2
    });
  };

  return {
    // Public Functions
    init: function init(element) {
      example1();
    }
  };
}(); // On document ready


KTUtil.onDOMContentLoaded(function () {
  KTFormsDialerDemos.init();
});
/******/ })()
;