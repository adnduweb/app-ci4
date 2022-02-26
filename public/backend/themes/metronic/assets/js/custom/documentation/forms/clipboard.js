/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!***************************************************************************!*\
  !*** ./resources/backend/core/js/custom/documentation/forms/clipboard.js ***!
  \***************************************************************************/
 // Class definition

var KTFormsClipboard = function () {
  // Shared variables
  var clipboard; // Private functions

  var example1 = function example1() {
    // Select elements
    var target = document.getElementById('kt_clipboard_1');
    var button = target.nextElementSibling; // Init clipboard -- for more info, please read the offical documentation: https://clipboardjs.com/

    clipboard = new ClipboardJS(button, {
      target: target,
      text: function text() {
        return target.value;
      }
    }); // Success action handler

    clipboard.on('success', function (e) {
      var currentLabel = button.innerHTML; // Exit label update when already in progress

      if (button.innerHTML === 'Copied!') {
        return;
      } // Update button label


      button.innerHTML = "Copied!"; // Revert button label after 3 seconds

      setTimeout(function () {
        button.innerHTML = currentLabel;
      }, 3000);
    });
  };

  var example2 = function example2() {
    // Select elements
    var target = document.getElementById('kt_clipboard_2');
    var button = target.nextElementSibling; // Init clipboard -- for more info, please read the offical documentation: https://clipboardjs.com/

    clipboard = new ClipboardJS(button, {
      target: target,
      text: function text() {
        return target.innerText;
      }
    }); // Success action handler

    clipboard.on('success', function (e) {
      var currentLabel = button.innerHTML; // Exit label update when already in progress

      if (button.innerHTML === 'Copied!') {
        return;
      } // Update button label


      button.innerHTML = "Copied!"; // Revert button label after 3 seconds

      setTimeout(function () {
        button.innerHTML = currentLabel;
      }, 3000);
    });
  };

  var example3 = function example3() {
    // Select element
    var target = document.getElementById('kt_clipboard_3'); // Init clipboard -- for more info, please read the offical documentation: https://clipboardjs.com/

    clipboard = new ClipboardJS(target); // Success action handler

    clipboard.on('success', function (e) {
      var currentLabel = target.innerHTML; // Exit label update when already in progress

      if (target.innerHTML === 'Copied!') {
        return;
      } // Update button label


      target.innerHTML = "Copied!"; // Revert button label after 3 seconds

      setTimeout(function () {
        target.innerHTML = currentLabel;
      }, 3000);
    });
  };

  var example4 = function example4() {
    // Select elements
    var target = document.getElementById('kt_clipboard_4');
    var button = target.nextElementSibling; // Init clipboard -- for more info, please read the offical documentation: https://clipboardjs.com/

    clipboard = new ClipboardJS(button, {
      target: target,
      text: function text() {
        return target.innerHTML;
      }
    }); // Success action handler

    clipboard.on('success', function (e) {
      var _target$classList;

      var checkIcon = button.querySelector('.bi.bi-check');
      var svgIcon = button.querySelector('.svg-icon'); // Exit check icon when already showing

      if (checkIcon) {
        return;
      } // Create check icon


      checkIcon = document.createElement('i');
      checkIcon.classList.add('bi');
      checkIcon.classList.add('bi-check');
      checkIcon.classList.add('fs-2x'); // Append check icon

      button.appendChild(checkIcon); // Highlight target

      var classes = ['text-success', 'fw-boldest'];

      (_target$classList = target.classList).add.apply(_target$classList, classes); // Highlight button


      button.classList.add('btn-success'); // Hide copy icon

      svgIcon.classList.add('d-none'); // Revert button label after 3 seconds

      setTimeout(function () {
        var _target$classList2;

        // Remove check icon
        svgIcon.classList.remove('d-none'); // Revert icon

        button.removeChild(checkIcon); // Remove target highlight

        (_target$classList2 = target.classList).remove.apply(_target$classList2, classes); // Remove button highlight


        button.classList.remove('btn-success');
      }, 3000);
    });
  };

  return {
    // Public Functions
    init: function init() {
      example1();
      example2();
      example3();
      example4();
    }
  };
}(); // On document ready


KTUtil.onDOMContentLoaded(function () {
  KTFormsClipboard.init();
});
/******/ })()
;