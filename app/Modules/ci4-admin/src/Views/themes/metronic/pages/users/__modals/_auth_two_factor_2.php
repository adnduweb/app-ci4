<!--begin::Modal - Add task-->
<div class="modal fade" id="kt_modal_add_one_time_sms" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">Auth SMS</h2>
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

                <?= form_open('', ['id' => 'opt_sms_form', 'class' => 'kt-form form', 'novalidate' => false]); ?>
                    <input type="hidden" name="action" value="edit_user_2fa_sms" />
                    <input type="hidden" name="uuid" value="<?= $form->uuid; ?>" />
                    <input type="hidden" name="id" value="<?= $form->id; ?>" />

                    <!--begin::Label-->
                    <div class="fw-bolder mb-9">Enter the new phone number to receive an SMS to when you log in.</div>
                    <!--end::Label-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mb-2">
                            <span class="required">Mobile number</span>
                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="A valid mobile number is required to receive the one-time password to validate your account login."></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <?php $unique = uniqid(); ?>
                            <input type="text" id="phone_mobile_<?= $unique; ?>" class="form-control form-control-solid phone" name="otp_mobile" placeholder="" value="<?= $form->phone_mobile; ?>" />
                            <input name="prefix_code_phone_mobile" class="phone_mobile_<?= $unique; ?>_prefix" type="hidden">
                            <input name="iso2_code_phone_mobile" class="phone_mobile_<?= $unique; ?>_iso2" type="hidden">
                            <div class="invalid-feedback-phone_mobile" class="hide"></div>
                            <div class="input-group-append">
                                <button class="btn btn-secondary" data-kt-sms-action="send" data-kt-verified-action="none" type="button">Vérifier!</button>
                            </div>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Text code-->
                    <div class="border rounded p-5 d-flex flex-center d-none" data-kt-add-sms-action="code_secret">
                        <input type="text" id="code_secret" class="form-control form-control-solid" data-kt-add-sms-action="value_code_secret" name="code_secret" placeholder="Votre code secret" value="" />
                    </div>
                    <!--end::Text code-->

                <?= form_close(); ?>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Add task-->

<?= $this->section('AdminAfterExtraJs') ?>

<script type="text/javascript">


"use strict";

// Class definition
var KTUsersAddAuthAppSMS = function () {
    // Shared variables
    const element = document.getElementById('kt_modal_add_one_time_sms');
    const modal = new bootstrap.Modal(element);

    // Init add schedule modal
    var initVerifAppSMS = () => {

        const smsVerified = element.querySelector('[data-kt-verified-action="none"]');
        var spinner = document.querySelector('.card_1 [data-kt-search-element="spinner"]');
        const submitVerif = element.querySelector('[data-kt-sms-action="send"]'); // Close button handler
        var codeSecret = element.querySelector('[data-kt-add-sms-action="code_secret"]'); // Close button handler Verif
        var codeSecretVerif = element.querySelector('[data-kt-add-sms-action="value_code_secret"]'); // Close button handler Verif
        var target = document.querySelector(".card_two_factors.card");
        var blockUI = new KTBlockUI(target);

        codeSecretVerif.addEventListener('input', (evt) => {
            if(evt.target.value.length == 6){

                //submitVerif.setAttribute('data-kt-indicator', 'on'); // Show loading indication         
                blockUI.block();              
               // submitVerif.disabled = true;// Disable button to avoid multiple click 

                axios.post("<?= route_to('user-save-detail') ?>",  $('#opt_sms_form').serialize() + '&addVerifCode=1')
                .then( response => {
                    console.log(response.data);
                    //submitVerif.removeAttribute('data-kt-indicator'); // remove the indicator
                    toastr.success(response.data.messages.success, _LANG_.updated + "!"); // Notif
                    $('#kt_auth_two_step_list').html(response.data.display_auth_two_step_list); // display the user
                    //submitVerif.disabled = false; // hide the submit
                    blockUI.release();
                    modal.hide(); // hide the modal
                    
                })
                .catch(error => {blockUI.release(); submitVerif.disabled = false;});     
            }

        });


        submitVerif.addEventListener('click', e => {
        // Prevent default button action
            e.preventDefault();

            submitVerif.setAttribute('data-kt-indicator', 'on'); // Show loading indication         
            blockUI.block();              
            submitVerif.disabled = true;// Disable button to avoid multiple click 

            axios.post("<?= route_to('user-save-detail') ?>", $('#opt_sms_form').serialize() + '&addVerifTel=1')
            .then( response => {
                blockUI.release();
                submitVerif.removeAttribute('data-kt-indicator'); // remove the indicator
                toastr.success(response.data.messages.success, _LANG_.updated + "!"); // Notif
                if(response.data.sendSms == true){
                    codeSecret.classList.remove('d-none');
                }
            })
            .catch(error => {blockUI.release();submitVerif.disabled = false;});          
        });

    }

    return {
        // Public functions
        init: function () {
            initVerifAppSMS();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersAddAuthAppSMS.init();
});

</script>

<?= $this->endSection() ?>