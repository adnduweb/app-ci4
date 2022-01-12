/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!********************************************************************************!*\
  !*** ./resources/backend/extended/js/custom/authentication/sign-in/general.js ***!
  \********************************************************************************/
 // Class definition

var KTSigninGeneral = function () {
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
              message: _LANG_.username_is_required
            },
            emailAddress: {
              message: 'The value is not a valid email address'
            }
          }
        },
        'password': {
          validators: {
            notEmpty: {
              message: _LANG_.password_is_required
            },
            callback: {
              message: 'Please enter valid password'
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
              html: response.data.messages.success,
              icon: "success",
              buttonsStyling: false,
              //confirmButtonText: "Ok, got it!",
              showConfirmButton: false,
              timer: 1500,
              customClass: {
                confirmButton: "btn btn-primary"
              }
            }).then(function (result) {
              //console.log(result);
              // if (result.isConfirmed) {
              form.querySelector('[name="login"]').value = "";
              form.querySelector('[name="password"]').value = ""; //window.location.reload();

              window.location.href = response.data.redirect; //}
            });
          })["catch"](function (error) {
            var dataMessage = error.response.data.messages.error;
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
                //confirmButtonText: "Ok, got it!",
                customClass: {
                  confirmButton: "btn btn-primary"
                }
              });
            }

            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;
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
      form = document.querySelector('#kt_sign_in_form');
      submitButton = document.querySelector('#kt_sign_in_submit');
      handleForm();
    }
  };
}(); // On document ready


KTUtil.onDOMContentLoaded(function () {
  KTSigninGeneral.init();
});
/******/ })()
;