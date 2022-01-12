<?= $this->extend('Themes\backend\metronic\layout\auth') ?>
<?= $this->section('main') ?>
<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(<?= assetAdmin('/media/illustrations/sketchy-1/14.png'); ?>">
    <!--begin::Content-->
    <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
        <!--begin::Logo-->
        <a href="/metronic8/demo1/../demo1/index.html" class="mb-12">
            <img alt="Logo" src="<?= assetAdmin('/media/logos/logo-2-dark.svg'); ?>" class="h-40px">
        </a>
        <!--end::Logo-->
        <!--begin::Wrapper-->
        <div class="w-lg-600px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
            <!--begin::Form-->
            <?= form_open('', ['id' => 'kt_code_recovery_form', 'class' => 'kt-form form w-100 mb-10', 'novalidate' => false]); ?>
                <input type="hidden" name="action" value="edit_user_2fa_sms" />
                <input type="hidden" name="uuid" value="<?= user()->uuid; ?>" />

                <!--begin::Icon-->
                <div class="text-center mb-10">
                    <img alt="Logo" class="mh-125px" src="<?= assetAdmin('/media/svg/misc/smartphone.svg'); ?>">
                </div>
                <!--end::Icon-->
                <!--begin::Heading-->
                <div class="text-center mb-10">
                    <!--begin::Title-->
                    <h1 class="text-dark mb-3">Code de récupération</h1>
                </div>
                <!--end::Heading-->
                <!--begin::Section-->
                <div class="mb-10 px-md-10">
                    <!--begin::Label-->
                    <div class="fw-bolder text-start text-dark fs-6 mb-1 ms-1">Type your héxadecimal security code</div>
                    <!--end::Label-->
                    <!--begin::Input group-->
                    <div class="d-flex ">
                        <input type="text" name="code_secret" class="form-control form-control-solid h-60px fs-2qx text-center border-primary border-hover mx-1 my-2" value="">
                    </div>
                    <!--begin::Input group-->
                </div>
                <!--end::Section-->
                <!--begin::Submit-->
                <div class="d-flex flex-center">
                    <button type="button" id="kt_sing_in_two_steps_submit" data-kt-2fa-action="send" class="btn btn-lg btn-primary fw-bolder">
                        <span class="indicator-label">Submit</span>
                        <span class="indicator-progress">Please wait... 
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
                <!--end::Submit-->
            <?= form_close(); ?>
            <!--end::Form-->
            <!--begin::Notice-->
            <div class="text-center fw-bold fs-5">
                <span class="text-muted me-1">Essayer une autre méthode ?</span>
                <a href="<?= route_to('two-factor-auth-2fa'); ?>" class="link-primary fw-bolder fs-5 me-1">Google Authentification</a>
                <span class="text-muted me-1">or</span>
                <a href="#" class="link-primary fw-bolder fs-5">Call Us</a>
            </div>
            <!--end::Notice-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Content-->
</div>
<?= $this->endSection() ?>

<?= $this->section('AdminAfterExtraJs') ?>

<script type="text/javascript">

$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')}});

"use strict";

// Class definition
var KTUsers2FACodeRecovery = function () {
    // Shared variables

    // Init add schedule modal
    var initVerif2FACodeRecovery = () => {


        const element = document.getElementById('kt_code_recovery_form');
        const submitVerif = element.querySelector('[data-kt-2fa-action="send"]'); // Close button handler



        submitVerif.addEventListener('click', e => {
        // Prevent default button action
        e.preventDefault();
        
            submitVerif.setAttribute('data-kt-indicator', 'on');// Show loading indication
           // submitVerif.disabled = true; // Disable button to avoid multiple click 

           axios.post("<?= route_to('confirm-two-factor-auth-2fa-recovery') ?>", $('#kt_code_recovery_form').serialize() + '&addVerifTel=1')
            .then( response => {
                submitVerif.removeAttribute('data-kt-indicator');
                toastr.success(response.data.messages.success, _LANG_.updated + "!"); // Notif
                window.location.href = response.data.redirect;
            })
            .catch(error => {submitVerif.removeAttribute('data-kt-indicator');}); 	        
        });

    }

    return {
        // Public functions
        init: function () {
            initVerif2FACodeRecovery();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsers2FACodeRecovery.init();
});

</script>

<?= $this->endSection() ?>