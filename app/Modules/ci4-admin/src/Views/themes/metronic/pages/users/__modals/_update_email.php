<!--begin::Modal - Update email-->
<div class="modal fade" id="kt_modal_update_email" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">Update Email Address</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                     <?= service('theme')->getSVG('duotone/Navigation/Close.svg', "svg-icon svg-icon-1"); ?>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <?= form_open('', ['id' => 'kt_modal_update_email_form', 'class' => 'kt-form form', 'novalidate' => false]); ?>
                    <input type="hidden" name="action" value="edit_user_email" />
                    <input type="hidden" name="uuid" value="<?= $form->uuid; ?>" />
                    <input type="hidden" name="id" value="<?= $form->id; ?>" />

                    <!--begin::Notice-->
                    <!--begin::Notice-->
                    <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                        <!--begin::Icon-->
                        <?= service('theme')->getSVG('duotone/Code/Warning-1-circle.svg', "svg-icon svg-icon-2tx svg-icon-primary me-4"); ?>
                        <!--end::Icon-->
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-grow-1">
                            <!--begin::Content-->
                            <div class="fw-bold">
                                <div class="fs-6 text-gray-700">Please note that a valid email address is required to complete the email verification.</div>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Notice-->
                    <!--end::Notice-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mb-2">
                            <span class="required">Email Address</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid" placeholder="" name="email" value="<?= $form->email; ?>" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    <!--end::Actions-->
                <?= form_close(); ?>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Update email-->


<?= $this->section('AdminAfterExtraJs') ?>

<script type="text/javascript">

"use strict";

// Class definition
var KTUsersUpdateEmail = function () {
    // Shared variables
    const element = document.getElementById('kt_modal_update_email');
    const form = element.querySelector('#kt_modal_update_email_form');
    var spinner = document.querySelector('.card_profile [data-kt-search-element="spinner"]');
    const modal = new bootstrap.Modal(element);

    // Init add schedule modal
    var initUpdateEmail = () => {

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'email': {
                        validators: {
                            notEmpty: {
                                message: 'Email address is required'
                            }
                        }
                    },
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        // Submit button handler
        const submitButtonEmail = element.querySelector('[data-kt-users-modal-action="submit"]');
        var target = document.querySelector(".card_profile.card");
        var blockUI = new KTBlockUI(target);
        submitButtonEmail.addEventListener('click', function (e) {
            // Prevent default button action
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {
                    console.log('validated Email!');

                    if (status == 'Valid') {
                       
                        e.preventDefault(); // Prevent default button action

                        submitButtonEmail.setAttribute('data-kt-indicator', 'on'); // Show loading indication                       
                        blockUI.block(); // Spinner
                        submitButtonEmail.disabled = true;// Disable button to avoid multiple click 

                        axios.post("<?= route_to('user-save-detail') ?>", $('#kt_modal_update_email_form').serialize())
                        .then( response => {
                            submitButtonEmail.removeAttribute('data-kt-indicator'); // remove the indicator
                            toastr.success(response.data.messages.success, _LANG_.updated + "!"); // Notif
                            $('input.address_id').val(response.data.address_id); // Add the address to the
                            $('#kt_table_users_profile').html(response.data.display_kt_table_users_profile); // display the user
                            $('#kt_user_view_details').html(response.data.display_kt_user_view_details); //display the user's details'
                            blockUI.release(); // hide the spinner
                            submitButtonEmail.disabled = false; // hide the submit
                            modal.hide(); // hide the modal
                        })
                        .catch(error => {blockUI.release(); submitButtonEmail.disabled = false;}); 
                    }
                });
            }
        });
    }

    return {
        // Public functions
        init: function () {
            initUpdateEmail();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersUpdateEmail.init();
});

</script>

<?= $this->endSection() ?>