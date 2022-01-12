<!--begin::Modal - Add task-->
<div class="modal fade" id="kt_modal_add_auth_app" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">Add Authenticator App</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <?= service('theme')->getSVG('duotone/Navigation/Close.svg', "svg-icon svg-icon-1"); ?>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <?= form_open('', ['id' => 'kt_modal_2fa_form', 'class' => 'kt-form form', 'novalidate' => false]); ?>
            <?php $secret = $google_auth->generateSecret(); ?>
                <input type="hidden" name="action" value="edit_user_2fa_auth" />
                <input type="hidden" name="uuid" value="<?= $form->uuid; ?>" />
                <input type="hidden" name="id" value="<?= $form->id; ?>" />
                <input type="hidden" name="secret" value="<?= $secret; ?>" />

            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Content-->
                <div class="fw-bolder d-flex flex-column justify-content-center mb-5">
                    <!--begin::Label-->
                    <div class="text-center mb-5" data-kt-add-auth-action="qr-code-label">Download the
                    <a href="#">Authenticator app</a>, add a new account, then scan this barcode to set up your account.</div>
                    <div class="text-center mb-5 d-none" data-kt-add-auth-action="text-code-label">Download the
                    <a href="#">Authenticator app</a>, add a new account, then enter this code to set up your account.</div>
                    <!--end::Label-->
                    <!--begin::QR code-->
                    <div class="d-flex flex-center" data-kt-add-auth-action="qr-code">
                        <img src="<?= \Sonata\GoogleAuthenticator\GoogleQrUrl::generate($form->email, $secret, 'ApplicationDoutony');?>" alt="Scan this QR code" />
                    </div>
                    <!--end::QR code-->
                    <!--begin::Text code-->
                    <div class="border rounded p-5 d-flex flex-center d-none" data-kt-add-auth-action="text-code">
                        <div class="fs-1"><?= $secret; ?> </div>
                    </div>
                    <!--end::Text code-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold mb-2"><?= ucfirst(lang('Core.Code')); ?>*</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" placeholder="" name="2fa[code]" value="" />
                        <!--end::Input-->
                    </div>
                    
                </div>
                <!--end::Content-->
                <!--begin::Action-->
                <div class="d-flex flex-center">
                    <div class="btn btn-light-primary" data-kt-add-auth-action="text-code-button">Enter code manually</div>
                    <div class="btn btn-light-primary d-none" data-kt-add-auth-action="qr-code-button">Scan barcode instead</div>
                </div>
                <!--end::Action-->
              
            </div>
            <!--end::Modal body-->
             <!--begin::Modal footer-->
             <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="reset" class="btn btn-light me-3"  data-bs-dismiss="modal">Discard</button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="submit" class="btn btn-primary" data-kt-modal-action="submit">
                        <span class="indicator-label">Valider</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Modal footer-->
            <?= form_close(); ?>
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
var KTUsersAddAuthApp = function () {
    // Shared variables
    const element = document.getElementById('kt_modal_add_auth_app');
    var spinner = document.querySelector('.card_1 [data-kt-search-element="spinner"]');
    const modal = new bootstrap.Modal(element);

    // Init add schedule modal
    var initAddAuthApp = () => {

        // Close button handler
        const submitButtonAuthApp = element.querySelector('[data-kt-modal-action="submit"]');
        submitButtonAuthApp.addEventListener('click', e => {
           // Prevent default button action
            e.preventDefault();

            submitButtonAuthApp.setAttribute('data-kt-indicator', 'on'); // Show loading indication                       
            submitButtonAuthApp.disabled = true;// Disable button to avoid multiple click 

            axios.post("<?= route_to('user-save-detail') ?>", $('#kt_modal_2fa_form').serialize())
            .then( response => {
                submitButtonAuthApp.removeAttribute('data-kt-indicator'); // remove the indicator
                toastr.success(response.data.messages.success, _LANG_.updated + "!"); // Notif
                $('#kt_auth_two_step_list').html(response.data.display_auth_two_step_list); // display the user
                submitButtonAuthApp.disabled = false; // hide the submit
                modal.hide(); // hide the modal
            })
            .catch(error => {submitButtonAuthApp.disabled = false;});            
        });

    }

    // QR code to text code swapper
    var initCodeSwap = () => {
        const qrCode = element.querySelector('[ data-kt-add-auth-action="qr-code"]');
        const textCode = element.querySelector('[ data-kt-add-auth-action="text-code"]');
        const qrCodeButton = element.querySelector('[ data-kt-add-auth-action="qr-code-button"]');
        const textCodeButton = element.querySelector('[ data-kt-add-auth-action="text-code-button"]');
        const qrCodeLabel = element.querySelector('[ data-kt-add-auth-action="qr-code-label"]');
        const textCodeLabel = element.querySelector('[ data-kt-add-auth-action="text-code-label"]');

        const toggleClass = () =>{
            qrCode.classList.toggle('d-none');
            qrCodeButton.classList.toggle('d-none');
            qrCodeLabel.classList.toggle('d-none');
            textCode.classList.toggle('d-none');
            textCodeButton.classList.toggle('d-none');
            textCodeLabel.classList.toggle('d-none');
        }

        // Swap to text code handler
        textCodeButton.addEventListener('click', e =>{
            e.preventDefault();
            toggleClass();
        });

        qrCodeButton.addEventListener('click', e =>{
            e.preventDefault();

            toggleClass();
        });
    }

    return {
        // Public functions
        init: function () {
            initAddAuthApp();
            initCodeSwap();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersAddAuthApp.init();
});

</script>

<?= $this->endSection() ?>