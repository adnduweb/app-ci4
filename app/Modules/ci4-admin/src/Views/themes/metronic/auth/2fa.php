<?= $this->extend('Themes\backend\metronic\layout\auth') ?>
<?= $this->section('main') ?>
<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(<?= assetAdmin('/media/illustrations/sketchy-1/14.png'); ?>">
    <!--begin::Content-->
    <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
        <!--begin::Logo-->
        <a href="<?=route_to('dashboard'); ?>" class="mb-12">
            <img alt="Logo" src="<?= assetAdmin('/media/logos/logo-2-dark.svg'); ?>" class="h-40px">
        </a>
        <!--end::Logo-->
        <!--begin::Wrapper-->
        <div class="w-lg-600px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
            <!--begin::Form-->
            <?= form_open('', ['id' => 'kt_sing_in_two_steps_form', 'class' => 'kt-form form w-100 mb-10', 'novalidate' => false]); ?>
                <input type="hidden" name="action" value="<?= user()->two_factor; ?>" />
                <input type="hidden" name="uuid" value="<?= user()->uuid; ?>" />

                <!--begin::Icon-->
                <div class="text-center mb-10">
                    <img alt="Logo" class="mh-125px" src="<?= assetAdmin('/media/svg/misc/smartphone.svg'); ?>">
                </div>
                <!--end::Icon-->
                <!--begin::Heading-->
                <div class="text-center mb-10">
                    <!--begin::Title-->
                    <h1 class="text-dark mb-3">Two Step Verification</h1>
                    <!--end::Title-->
                    <!--begin::Sub-title-->
                    <!-- <div class="text-muted fw-bold fs-5 mb-5">Enter the verification code we sent to</div> -->
                    <!--end::Sub-title-->
                    <!--begin::Mobile no-->
                    <!-- <div class="fw-bolder text-dark fs-3">******7859</div> -->
                    <!--end::Mobile no-->
                </div>
                <!--end::Heading-->
                <!--begin::Section-->
                <div class="mb-10 px-md-10">
                    <!--begin::Label-->
                    <div class="fw-bolder text-start text-dark fs-6 mb-1 ms-1">Type your 6 digit security code</div>
                    <!--end::Label-->
                    <!--begin::Input group-->
                    <div class="d-flex flex-wrap flex-stack">
                        <input type="text" name="code_secret[]" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center code-secret code-secret-1 border-primary border-hover mx-1 my-2" value="" inputmode="text">
                        <input type="text" name="code_secret[]" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center code-secret code-secret-2 border-primary border-hover mx-1 my-2" value="" inputmode="text">
                        <input type="text" name="code_secret[]" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center code-secret code-secret-3 border-primary border-hover mx-1 my-2" value="" inputmode="text">
                        <input type="text" name="code_secret[]" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center code-secret code-secret-4 border-primary border-hover mx-1 my-2" value="" inputmode="text">
                        <input type="text" name="code_secret[]" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center code-secret code-secret-5 border-primary border-hover mx-1 my-2" value="" inputmode="text">
                        <input type="text" name="code_secret[]" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center code-secret code-secret-6 border-primary border-hover mx-1 my-2" value="" inputmode="text">
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
            <?php if(user()->two_factor != '2fa_sms'){ ?>

                <!--begin::Notice-->
                <div class="text-center fw-bold fs-5">
                    <span class="text-muted me-1">Essayer une autre méthode ?</span>
                    <a href="<?= route_to('two-factor-auth-2fa-code-recovery'); ?>" class="link-primary fw-bolder fs-5 me-1">Code de secours</a>
                    <span class="text-muted me-1">or</span>
                    <a href="#" class="link-primary fw-bolder fs-5">Call Us</a>
                </div>
                <!--end::Notice-->

            <?php } ?>
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
var KTUsers2FA = function () {
    // Shared variables
    const element = document.getElementById('kt_modal_add_one_time_sms');
   // const modal = new bootstrap.Modal(element);

    // Init add schedule modal
    var initVerif2FA = () => {


        const element     = document.getElementById('kt_sing_in_two_steps_form');
        const submitVerif = element.querySelector('[data-kt-2fa-action="send"]');  // Close button handler
        const codeSecret  = element.querySelectorAll('[name="code_secret[]"]');    // Close button handler

        codeSecret.forEach(c => {
            c.addEventListener('keyup', e => {
                const currentNode = e.target;
                const currentIndex = [...codeSecret].findIndex(el => currentNode.isEqualNode(el));
                const targetIndex = (currentIndex + 1) % codeSecret.length;
                codeSecret[targetIndex].focus();
 
            });
        });

        submitVerif.addEventListener('click', e => {
        e.preventDefault();
        
            submitVerif.setAttribute('data-kt-indicator', 'on');// Show loading indication

            axios.post("<?= route_to('confirm-two-factor-auth-2fa') ?>", $('#kt_sing_in_two_steps_form').serialize() + '&addVerifTel=1')
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
            initVerif2FA();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsers2FA.init();
});

</script>

<?= $this->endSection() ?>