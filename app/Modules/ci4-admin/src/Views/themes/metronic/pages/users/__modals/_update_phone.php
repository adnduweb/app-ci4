<!--begin::Modal - Update email-->
<div class="modal fade" id="kt_modal_update_phone" tabindex="-1" aria-hidden="true">
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
                <?= form_open('', ['id' => 'kt_modal_update_phone_form', 'class' => 'kt-form form', 'novalidate' => false]); ?>
                    <input type="hidden" name="action" value="edit_user_phone" />
                    <input type="hidden" name="uuid" value="<?= $form->uuid; ?>" />
                    <input type="hidden" name="id" value="<?= $form->id; ?>" />
                    <input type="hidden" class="address_id" name="address[id]" value="<?= (!empty($form->users_adresses)) ? $form->users_adresses[0]->id : ''; ?>" />

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
                                <div class="fs-6 text-gray-700">Please note that a valid phone  is required to complete the phone verification.</div>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Notice-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label for="firstname" class="fs-6 fw-bold mb-2"><?= ucfirst(lang('Core.phone')); ?>*</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <?php $unique = uniqid(); ?>
                        <input type="text" id="phone_<?= $unique; ?>" class="form-control form-control-solid phone" placeholder="" name="phone" value="<?= (!empty($form->users_adresses[0]->phone)) ? $form->users_adresses[0]->phone : ''; ?>" />
                        <input name="prefix_code_phone" class="phone_<?= $unique; ?>_prefix" type="hidden">
                        <input name="iso2_code_phone" class="phone_<?= $unique; ?>_iso2" type="hidden">
                        <div class="invalid-feedback-phone" class="hide"></div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label for="firstname" class="fs-6 fw-bold mb-2"><?= ucfirst(lang('Core.phone_mobile')); ?>*</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <?php $unique = uniqid(); ?>
                        <input type="text" id="phone_mobile_<?= $unique; ?>" class="form-control form-control-solid phone" placeholder="" name="phone_mobile" value="<?= (!empty($form->users_adresses[0]->phone_mobile)) ? $form->users_adresses[0]->phone_mobile : ''; ?>" />
                        <input name="prefix_code_phone_mobile" class="phone_mobile_<?= $unique; ?>_prefix" type="hidden">
                        <input name="iso2_code_phone_mobile" class="phone_mobile_<?= $unique; ?>_iso2" type="hidden">
                        <div class="invalid-feedback-phone_mobile" class="hide"></div>
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
var KTUsersUpdatePhone = function () {
    // Shared variables
    const element = document.getElementById('kt_modal_update_phone');
    const form = element.querySelector('#kt_modal_update_phone_form');
    var spinner = document.querySelector('.card_profile [data-kt-search-element="spinner"]');
    const modal = new bootstrap.Modal(element);

    // Init add schedule modal
    var initUpdatePhone = () => {

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'phone': {
                        validators: {
                            callback: {
                                message: 'The phone number is not valid',
                                callback: function(value, validator, $field) {
                                    return value === '' || window.intlTelInput($field, 'isValidNumber');
                                }
                            }
                        }
                    },
                    'phone_mobile': {
                        validators: {
                            callback: {
                                message: 'The phone number is not valid',
                                callback: function(value, validator, $field) {
                                    return value === '' || $field.intlTelInput('isValidNumber');
                                }
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
        const submitButtonPhone = element.querySelector('[data-kt-users-modal-action="submit"]');
        var target = document.querySelector(".card_profile.card");
        var blockUI = new KTBlockUI(target);
        submitButtonPhone.addEventListener('click', function (e) {
            // Prevent default button action
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {
                    console.log('validated Email!');

                    if (status == 'Valid') {
                        // Prevent default button action
                        e.preventDefault();

                        submitButtonPhone.setAttribute('data-kt-indicator', 'on'); // Show loading indication         
                        blockUI.block();              
                        submitButtonPhone.disabled = true;// Disable button to avoid multiple click 

                        axios.post("<?= route_to('user-save-detail') ?>", $('#kt_modal_update_phone_form').serialize())
                        .then( response => {
                            submitButtonPhone.removeAttribute('data-kt-indicator'); // remove the indicator
                            toastr.success(response.data.messages.success, _LANG_.updated + "!"); // Notif
                            $('input.address_id').val(response.data.address_id); // Add the address to the
                            $('#kt_table_users_profile').html(response.data.display_kt_table_users_profile); // display the user
                            blockUI.release(); // hide the spinner
                            submitButtonPhone.disabled = false; // hide the submit
                            modal.hide(); // hide the modal
                        })
                        .catch(error => {blockUI.release(); submitButtonPhone.disabled = false;}); 
                    }
                });
            }
        });
    }

    return {
        // Public functions
        init: function () {
            initUpdatePhone();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersUpdatePhone.init();
});

</script>

<?= $this->endSection() ?>