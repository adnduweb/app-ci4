<!--begin::Modal - Add task-->
<div class="modal fade" id="kt_modal_add_one_time_email" tabindex="-1" aria-hidden="true">
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

                <?= form_open('', ['id' => 'opt_email_form', 'class' => 'kt-form form', 'novalidate' => false]); ?>
                    <input type="hidden" name="action" value="edit_user_2fa_email" />
                    <input type="hidden" name="uuid" value="<?= $form->uuid; ?>" />
                    <input type="hidden" name="id" value="<?= $form->id; ?>" />

                    <!--begin::Label-->
                    <div class="fw-bolder mb-9">Enter the new email to receive an email to when you log in.</div>
                    <!--end::Label-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mb-2">
                            <span class="required">Email</span>
                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="A valid email is required to receive the one-time password to validate your account login."></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <input type="text" class="form-control form-control-solid" name="otp_email" placeholder="" value="<?= $form->email; ?>" />
                            <div class="input-group-append">
                                <button class="btn btn-secondary" data-kt-send-action="sms" type="button">vérifié!</button>
                            </div>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Separator-->
                    <div class="separator saperator-dashed my-5"></div>
                    <!--end::Separator-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" data-kt-modal-action="submit">
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
<!--end::Modal - Add task-->

<?= $this->section('AdminAfterExtraJs') ?>

<script type="text/javascript">


"use strict";

// Class definition
var KTUsersAddAuthAppEmail = function () {
    // Shared variables
    const element = document.getElementById('kt_modal_add_one_time_email');
    const modal = new bootstrap.Modal(element);

    // Init add schedule modal
    var initAddAuthAppEmail = () => {

        // Close button handler
        const submitButton = element.querySelector('[data-kt-modal-action="submit"]');
        submitButton.addEventListener('click', e => {
           // Prevent default button action
           e.preventDefault();

            // Show loading indication
            submitButton.setAttribute('data-kt-indicator', 'on');

            // Disable button to avoid multiple click 
            submitButton.disabled = true;

            $.ajax({
                type: 'POST',
                url: "<?= route_to('user-save-detail') ?>",
                data: $('#opt_email_form').serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.error == false) {
                        submitButton.removeAttribute('data-kt-indicator');
                        toastr.success(response.success.message, _LANG_.updated + "!");
                        submitButton.disabled = false;
                    
                        modal.hide();
                    }
                }
            });
           
        });

    }


    return {
        // Public functions
        init: function () {
            initAddAuthAppEmail();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersAddAuthAppEmail.init();
});

</script>

<?= $this->endSection() ?>