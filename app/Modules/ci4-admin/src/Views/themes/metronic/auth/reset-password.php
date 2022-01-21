<?= $this->extend('Themes\backend\metronic\auth') ?>
<?= $this->section('main') ?>

<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(<?= assetAdmin('/media/illustrations/sketchy-1/14.png'); ?>">
    <!--begin::Content-->
    <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
        <!--begin::Logo-->
        <a href="<?= current_url(); ?>" class="mb-12">
			<img alt="Logo" src="<?= assetAdmin('/media/logos/logo-ADN.svg'); ?>" class="h-65px" />
		</a>
        <!--end::Logo-->
        <!--begin::Wrapper-->
        <div class="w-lg-550px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
            <!--begin::Form-->
            <?= form_open(route_to('login-area'), ['id' => 'kt_new_password_form', 'class' => 'form w-100 fv-plugins-bootstrap5 fv-plugins-framework', 'novalidate' => 'novalidate']); ?>
               <!--begin::Heading-->
                <div class="text-center mb-10">
                    <!--begin::Title-->
                    <h1 class="text-dark mb-3"><?=lang('Auth.SetupNewPassword');?></h1>
                    <!--end::Title-->
                    <!--begin::Link-->
                    <?php if (config('Auth')->allowRegistration): ?>
					<!--begin::Link-->
					<div class="text-gray-400 fw-bold fs-4"><?= lang('Auth.New Here?') ?>
					<a href="/<?= CI_AREA_ADMIN; ?>/sign-up" class="link-primary fw-bolder"><?= lang('Auth.Create an Account') ?></a></div>
					<!--end::Link-->
					<?php endif; ?>
                    <!--end::Link-->
                </div>

                <!--begin::Heading-->
                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fs-6 fw-bold mb-2">
                        <span><?= ucfirst(lang('Auth.token')); ?>*</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" required placeholder="" name="tokenHash" value="<?= old('tokenHash', $token ?? '') ?>" />
                    <!--end::Input-->
                </div>
                <!--begin::Input group-->

                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fs-6 fw-bold mb-2">
                        <span><?= ucfirst(lang('Auth.email')); ?>*</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" required placeholder="" name="email" value="<?= old('email') ?>" />
                    <!--end::Input-->
                </div>
                <!--begin::Input group-->

                <!--begin::Input group-->
                <div class="mb-10 fv-row fv-plugins-icon-container" data-kt-password-meter="true">
                    <!--begin::Wrapper-->
                    <div class="mb-1">
                        <!--begin::Label-->
                        <label class="form-label fw-bolder text-dark fs-6"><?=lang('Auth.password');?></label>
                        <!--end::Label-->
                        <!--begin::Input wrapper-->
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="password" autocomplete="off">
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
                    <div class="text-muted"><?=lang('Auth.Use8OrMoreCharacters');?></div>
                    <!--end::Hint-->
                <div class="fv-plugins-message-container invalid-feedback"></div></div>
                <!--end::Input group=-->
                <!--begin::Input group=-->
                <div class="fv-row mb-10 fv-plugins-icon-container">
                    <label class="form-label fw-bolder text-dark fs-6"><?=lang('Auth.ConfirmPassword');?></label>
                    <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="confirm-password" autocomplete="off">
                <div class="fv-plugins-message-container invalid-feedback"></div></div>
                <!--end::Input group=-->
                <!--begin::Action-->
                <div class="text-center">
                    <button type="button" id="kt_new_password_submit" class="btn btn-lg btn-primary fw-bolder">
                        <span class="indicator-label"><?=lang('Auth.continue');?></span>
						<span class="indicator-progress"><?=lang('Auth.Please wait');?>...
						<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
                <!--end::Action-->
            <?= form_close(); ?>
            <!--end::Form-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Content-->
    <!--begin::Footer-->
    <div class="d-flex flex-center flex-column-auto p-10">
        <!--begin::Links-->
        <div class="d-flex align-items-center fw-bold fs-6">
			<a href="<?= current_url(); ?>" class="text-muted text-hover-primary px-2">A propos de </a>
			<a href="mailto:contact@adnduweb.com" class="text-muted text-hover-primary px-2">Contact</a>
			<a href="<?= current_url(); ?>" class="text-muted text-hover-primary px-2">Nous contacter</a>
		</div>
        <!--end::Links-->
    </div>
    <!--end::Footer-->
</div>
            

<?= $this->endSection() ?>

<?= $this->section('AdminAfterExtraJs') ?>

<script type="text/javascript">

"use strict";

// Class Definition
var KTPasswordResetNewPassword = function() {
    // Elements
    var form;
    var submitButton;
    var validator;
    var passwordMeter;

    var handleForm = function(e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
			form,
			{
				fields: {	
                    // 'email': {
                    //     validators: {
                    //         notEmpty: {
                    //             message: _LANG_.EmailAddressIsRequired
                    //         },
                    //         emailAddress: {
                    //             message: _LANG_.ValueIsNotAValidEmail
                    //         }
					// 	}
					// },				 
                    'password': {
                        validators: {
                            notEmpty: {
                                message: _LANG_.PasswordIsRequired
                            },
                            callback: {
                                message: _LANG_.PleaseEnterValidPassword,
                                callback: function(input) {
                                    if (input.value.length > 0) {        
                                        return validatePassword();
                                    }
                                }
                            }
                        }
                    },
                    'confirm-password': {
                        validators: {
                            notEmpty: {
                                message: _LANG_.PleaseConfirmationIsRequired,
                            },
                            identical: {
                                compare: function() {
                                    return form.querySelector('[name="password"]').value;
                                },
                                message: _LANG_.PasswordAndItsConfirmAreNotTheSame,
                            }
                        }
                    },
                    // 'tokenHash': {
                    //     validators: {
                    //         notEmpty: {
                    //             message: _LANG_.JetonNotConforme,
                    //         }
                    //     }
                    // }
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger({
                        event: {
                            password: false
                        }  
                    }),
					bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
				}
			}
		);

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            validator.revalidateField('password');

            validator.validate().then(function(status) {
		        if (status == 'Valid') {
                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click 
                    submitButton.disabled = true;

                    axios.post("<?= route_to('confirm-reset-password') ?>", $('#kt_new_password_form').serialize())
                    .then( response => {
                        toastr.success(response.data.messages.success, _LANG_.updated + "!"); // Notif
                        window.location.href = response.data.redirect;
                    })
                    .catch(error => {
                        submitButton.removeAttribute('data-kt-indicator');
                        submitButton.disabled = false;
                    }); 	
                } else {
                    // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                    Swal.fire({
                        text: _LANG_.SorryErrorsDetected,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: _LANG_.Fermer,
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
		    });
        });

        form.querySelector('input[name="password"]').addEventListener('input', function() {
            if (this.value.length > 0) {
                validator.updateFieldStatus('password', 'NotValidated');
            }
        });
    }

    var validatePassword = function() {
        

        return  (passwordMeter.getScore() === 100);
    }

    // Public Functions
    return {
        // public functions
        init: function() {
            form = document.querySelector('#kt_new_password_form');
            submitButton = document.querySelector('#kt_new_password_submit');
            passwordMeter = KTPasswordMeter.getInstance(form.querySelector('[data-kt-password-meter="true"]'));

            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTPasswordResetNewPassword.init();
});


</script>

<?= $this->endSection() ?>