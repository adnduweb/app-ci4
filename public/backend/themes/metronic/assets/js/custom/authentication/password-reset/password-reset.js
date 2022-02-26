/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!**********************************************************************************************!*\
  !*** ./resources/backend/extended/js/custom/authentication/password-reset/password-reset.js ***!
  \**********************************************************************************************/
 // Class Definition

var KTPasswordResetGeneral = function () {
  // Elements
  var form;
  var submitButton;
  var validator; // Handle form

  var handleForm = function handleForm(e) {
    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    validator = FormValidation.formValidation(form, {
      fields: {
        'email': {
          validators: {
            notEmpty: {
              message: _LANG_.EmailAddressIsRequired
            },
            emailAddress: {
              message: _LANG_.ValueIsNotAValidEmail
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap: new FormValidation.plugins.Bootstrap5({
          rowSelector: '.fv-row',
          eleInvalidClass: '',
          eleValidClass: ''
        })
      }
    }); // Handle form submit

    submitButton.addEventListener('click', function (e) {
      // Prevent button default action
      e.preventDefault(); // Validate form

      validator.validate().then(function (status) {
        if (status === 'Valid') {
          // Show loading indication
          submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click

          submitButton.disabled = true; // Simulate ajax request

          axios.post(submitButton.closest('form').getAttribute('action'), new FormData(form)).then(function (response) {
            // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
            Swal.fire({
              text: _LANG_.SorryErrorsDetected,
              icon: "success",
              buttonsStyling: false,
              confirmButtonText: "Ok, got it!",
              customClass: {
                confirmButton: "btn btn-primary"
              }
            }).then(function (result) {
              if (result.isConfirmed) {
                form.querySelector('[name="email"]').value = "";
              }
            });
          })["catch"](function (error) {
            var dataMessage = error.response.data.message;
            var dataErrors = error.response.data.errors;

            for (var errorsKey in dataErrors) {
              if (!dataErrors.hasOwnProperty(errorsKey)) continue;
              dataMessage += "\r\n" + dataErrors[errorsKey];
            }

            if (error.response) {
              Swal.fire({
                text: dataMessage,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                  confirmButton: "btn btn-primary"
                }
              });
            }
          }).then(function () {
            // always executed
            // Hide loading indication
            submitButton.removeAttribute('data-kt-indicator'); // Enable button

            submitButton.disabled = false;
          });
        } else {
          // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
          Swal.fire({
            text: "Sorry, looks like there are some errors detected, please try again.",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
              confirmButton: "btn btn-primary"
            }
          });
        }
      });
    });
  }; // Public functions


  return {
    // Initialization
    init: function init() {
      form = document.querySelector('#kt_password_reset_form');
      submitButton = document.querySelector('#kt_password_reset_submit');
      handleForm();
    }
  };
}(); // On document ready


KTUtil.onDOMContentLoaded(function () {
  KTPasswordResetGeneral.init();
});
/******/ })()
;