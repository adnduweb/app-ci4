    <!--begin::Modal - Update password-->
    <div class="modal fade" id="kt_modal_update_password" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder">Update Password</h2>
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
                    <?= form_open('', ['id' => 'kt_modal_update_password_form', 'class' => 'kt-form form', 'novalidate' => false]); ?>
                        <input type="hidden" name="action" value="edit_user_password" />
                        <input type="hidden" name="uuid" value="<?= $form->uuid; ?>" />
                        <input type="hidden" name="id" value="<?= $form->id; ?>" />
                        <!--begin::Input group=-->
                        <div class="fv-row mb-10">
                            <label class="required form-label fs-6 mb-2">Current Password</label>
                            <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="current_password" autocomplete="off" />
                        </div>
                        <!--end::Input group=-->
                        <!--begin::Input group-->
                        <div class="mb-10 fv-row" data-kt-password-meter="true">
                            <!--begin::Wrapper-->
                            <div class="mb-1">
                                <!--begin::Label-->
                                <label class="form-label fw-bold fs-6 mb-2">New Password</label>
                                <!--end::Label-->
                                <!--begin::Input wrapper-->
                                <div class="position-relative mb-3">
                                    <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="new_password" autocomplete="off" />
                                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                        <i class="bi bi-eye-slash fs-2"></i>
                                        <i class="bi bi-eye fs-2 d-none"></i>
                                    </span>
                                </div>
                                <!--end::Input wrapper-->
                                <!--begin::Meter-->
                                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                </div>
                                <!--end::Meter-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Hint-->
                            <div class="text-muted">Use 8 or more characters with a mix of letters, numbers &amp; symbols.</div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Input group=-->
                        <!--begin::Input group=-->
                        <div class="fv-row mb-10">
                            <label class="form-label fw-bold fs-6 mb-2">Confirm New Password</label>
                            <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="confirm_password" autocomplete="off" />
                        </div>
                        <!--end::Input group=-->
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
    <!--end::Modal - Update password-->


    <?= $this->section('AdminAfterExtraJs') ?>

<script type="text/javascript">

"use strict";

// Class definition
var KTUsersUpdatePasswds = function () {
    // Shared variables
    const element = document.getElementById('kt_modal_update_password');
    const form = element.querySelector('#kt_modal_update_password_form');
    var spinner = document.querySelector('.card_profile [data-kt-search-element="spinner"]');
    const modal = new bootstrap.Modal(element);

    // Init add schedule modal
    var initUpdatePasswords = () => {

         // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            var validatorPass = FormValidation.formValidation(
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
        const submitButtonPass = element.querySelector('[data-kt-users-modal-action="submit"]');
        var target = document.querySelector(".card_profile.card");
        var blockUI = new KTBlockUI(target);
        submitButtonPass.addEventListener('click', function (e) {

            // Prevent default button action
            e.preventDefault();
            
            // Validate form before submit
            if (validatorPass) {
                validatorPass.validate().then(function (status) {
                    console.log('validated Password!');

                    if (status == 'Valid') {


                        submitButtonPass.setAttribute('data-kt-indicator', 'on'); // Show loading indication                       
                        blockUI.block(); // Spinner
                        submitButtonPass.disabled = true;// Disable button to avoid multiple click 

                        axios.post("<?= route_to('user-save-detail') ?>", $('#kt_modal_update_password_form').serialize())
                        .then( response => {
                            submitButtonPass.removeAttribute('data-kt-indicator'); // remove the indicator
                            toastr.success(response.data.messages.success, _LANG_.updated + "!"); // Notif
                            $('input.address_id').val(response.data.address_id); // Add the address to the
                            $('#kt_table_users_profile').html(response.data.display_kt_table_users_profile); // display the user
                            blockUI.release(); // hide the spinner
                            submitButtonPass.disabled = false; // hide the submit
                            modal.hide(); // hide the modal
                        })
                        .catch(error => {blockUI.release(); submitButtonPass.disabled = false;}); 
                    }
                });
            }
        });
    }

    var createUsername = function () {

        var fname = $('#kt_modal_update_user_form input[name=firstname]').val().substring(0, 1).toLowerCase();
        var lname = $('#kt_modal_update_user_form input[name=lastname]').val().toLowerCase();
        var username = fname + lname + Math.floor(Math.random() * (10000 + 1) + 1000);
        $('#kt_modal_update_user_form input[name=username]').val(username);
    }

    var updateUser = function () {

        var fname = $('#kt_modal_update_user_form input[name=firstname]').val().toLowerCase();
        var lname = $('#kt_modal_update_user_form input[name=lastname]').val().toLowerCase();
        var username = fname + lname;
        $('.card_1 .fullname').text(username);

    }

    $('#kt_modal_update_user_form input[name=firstname]').on('keyup', createUsername);
    $('#kt_modal_update_user_form input[name=lastname]').on('keyup', createUsername);

    $('#kt_modal_update_user_form input[name=firstname]').on('keyup', updateUser);
    $('#kt_modal_update_user_form input[name=lastname]').on('keyup', updateUser);

    return {
        // Public functions
        init: function () {
            initUpdatePasswords();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersUpdatePasswds.init();
});

</script>
<?= $this->endSection() ?>