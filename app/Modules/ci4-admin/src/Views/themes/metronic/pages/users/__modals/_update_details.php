<!--begin::Modal - Update user details-->
<div class="modal fade" id="kt_modal_update_details" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->

            <?= form_open('', ['id' => 'kt_modal_update_user_form', 'class' => 'kt-form form', 'novalidate' => false]); ?>
                <input type="hidden" name="action" value="edit_user" />
                <input type="hidden" name="uuid" value="<?= $form->uuid; ?>" />
                <input type="hidden" name="id" value="<?= $form->id; ?>" />
                <input type="hidden" class="address_id" name="address[id]" value="<?= (!empty($form->users_adresses)) ? $form->users_adresses[0]->id : ''; ?>" />
                <?php $country_id = (!empty($form->users_adresses)) ? $form->users_adresses[0]->country_id : 0; ?>
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_update_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder">Update User Details</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary"  data-bs-dismiss="modal">
                        <?= service('theme')->getSVG('duotone/Navigation/Close.svg', "svg-icon svg-icon-1"); ?>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_user_header" data-kt-scroll-wrappers="#kt_modal_update_user_scroll" data-kt-scroll-offset="300px">
                        <!--begin::User toggle-->
                        <div class="fw-boldest fs-3 rotate collapsible mb-7" data-bs-toggle="collapse" href="#kt_modal_update_user_user_info" role="button" aria-expanded="false" aria-controls="kt_modal_update_user_user_info">User Information
                            <span class="ms-2 rotate-180">
                                <?= service('theme')->getSVG('duotone/Navigation/Angle-down.svg', "svg-icon svg-icon-3"); ?>
                            </span>
                        </div>
                        <!--end::User toggle-->
                        <!--begin::User form-->
                        <div id="kt_modal_update_user_user_info" class="collapse show">

                            <?php if (inGroups(1, user()->id)) { ?>
                                <div class="fv-row mb-7">
                                    <label for="company_id" class="fs-6 fw-bold mb-2"><?= ucfirst(lang('Core.companies')); ?>* : </label>
                                    <select required name="company_id" class="form-control kt-selectpicker" id="company_id" data-actions-box="true" title="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>">
                                        <?php foreach ($form->company as $company) { ?>
                                            <option <?= ($company->id == $form->company_id) ? 'selected'  : ''; ?> value="<?= $company->id; ?>"><?= ucfirst($company->raison_social); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } else { ?>
                                <div class="form-group row" style="display:none">
                                    <?= form_hidden('company_id', $form->company_id); ?>
                                </div>
                            <?php } ?>
                             <!--begin::Input group-->
                             <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">
                                    <span><?= ucfirst(lang('Core.username')); ?>*</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="<?= lang('Core.username_form_tooltip_info'); ?>"></i>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" readonly required placeholder="" name="username" value="<?= $form->username; ?>" />
                                <!--end::Input-->
                            </div>
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2"><?= ucfirst(lang('Core.lastname')); ?>*</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" placeholder="" name="lastname" value="<?= $form->lastname; ?>" />
                                <!--end::Input-->
                            </div>
                             <!--begin::Input group-->
                             <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label for="firstname" class="fs-6 fw-bold mb-2"><?= ucfirst(lang('Core.firstname')); ?>*</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" placeholder="" name="firstname" value="<?= $form->firstname; ?>" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">
                                    <span>Email</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="<?= lang('Core.Email address must be active'); ?> "></i>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="email" class="form-control form-control-solid" placeholder="" name="email" value="<?= $form->email; ?>" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-15">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">Language</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="lang" aria-label="Select a Language" data-control="select2" data-placeholder="Select a Language..." class="form-select form-select-solid">
                                    <option></option>
                                    <?php foreach (Config('Language')->supportedLocales as $lang) { ?>
                                        <option value="<?= $lang['iso_code']; ?>" <?= ($lang['iso_code'] == $form->lang) ? 'selected' : ''; ?>><?= $lang['name']; ?></option>
                                    <?php } ?>
                   
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::User form-->
                        <!--begin::Address toggle-->
                        <div class="fw-boldest fs-3 rotate collapsible mb-7" data-bs-toggle="collapse" href="#kt_modal_update_user_address" role="button" aria-expanded="false" aria-controls="kt_modal_update_user_address">Address Details
                        <span class="ms-2 rotate-180">
                                <?= service('theme')->getSVG('duotone/Navigation/Angle-down.svg', "svg-icon svg-icon-3"); ?>
                            </span>
                        </div>
                        <!--end::Address toggle-->
                        <!--begin::Address form-->
                        <div id="kt_modal_update_user_address" class="collapse show">
                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-7 fv-row">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">Address Line 1</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-solid" placeholder="" name="address[adresse1]" value="<?= (!empty($form->users_adresses)) ? $form->users_adresses[0]->adresse1 : ''; ?>" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-7 fv-row">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">Address Line 2</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-solid" placeholder="" name="address[adresse2]" value="<?= (!empty($form->users_adresses)) ? $form->users_adresses[0]->adresse2 : ''; ?>" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-7 fv-row">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">Town</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-solid" placeholder="" name="address[ville]" value="<?= (!empty($form->users_adresses)) ? $form->users_adresses[0]->ville : ''; ?>" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-7 fv-row">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">Post Code</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-solid" placeholder="" name="address[code_postal]" value="<?= (!empty($form->users_adresses)) ? $form->users_adresses[0]->code_postal : ''; ?>" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-7 fv-row">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">
                                    <span>Country</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Country of origination"></i>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="address[country_id]" aria-label="Select a Country" data-control="select2" data-placeholder="Select a Country..." class="form-select form-select-solid" data-dropdown-parent="#kt_modal_update_details">
                                    <option value="">Select a Country...</option>
                                    <?php foreach (model(Adnduweb\Ci4Core\Models\CountryModel::class)->getAllCountry() as $country) { ?>
                                        <option value="<?= $country->id; ?>" <?= ($country->id == $country_id) ? 'selected' : ''; ?> ><?= $country->name; ?></option>
                                    <?php } ?>
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Address form-->
                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                        <span class="indicator-label">Submit</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Modal footer-->
            	<!-- end:: Content -->
            <?= form_close(); ?>
            <!--end::Form-->
        </div>
    </div>
</div>
<!--end::Modal - Update user details-->


<?= $this->section('AdminAfterExtraJs') ?>

<script type="text/javascript">

"use strict";

// Class definition
var KTUsersUpdateDetails = function () {
    // Shared variables
    const element = document.getElementById('kt_modal_update_details');
    const form = element.querySelector('#kt_modal_update_user_form');
    var spinner = document.querySelector('.card_1 [data-kt-search-element="spinner"]');
    const modal = new bootstrap.Modal(element);

    // Init add schedule modal
    var initUpdateDetails = () => {

         // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            var validatorUser = FormValidation.formValidation(
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
        const submitButtonUser = element.querySelector('[data-kt-users-modal-action="submit"]');
        var target = document.querySelector(".card_1.card");
        var blockUI = new KTBlockUI(target);
        submitButtonUser.addEventListener('click', function (e) {

            // Prevent default button action
            e.preventDefault();
            
            // Validate form before submit
            if (validatorUser) {
                validatorUser.validate().then(function (status) {
                    console.log('validated details!');

                    if (status == 'Valid') {

                        submitButtonUser.setAttribute('data-kt-indicator', 'on'); // Show loading indication         
                        blockUI.block();              
                        submitButtonUser.disabled = true;// Disable button to avoid multiple click 

                        axios.post("<?= route_to('user-save-detail') ?>", $('#kt_modal_update_user_form').serialize())
                        .then( response => {
                            submitButtonUser.removeAttribute('data-kt-indicator'); // remove the indicator
                            toastr.success(response.data.messages.success, _LANG_.updated + "!"); // Notif
                            $('input.address_id').val(response.data.address_id); // Add the address to the
                            $('#kt_table_users_profile').html(response.data.display_kt_table_users_profile); // display the user
                            $('#kt_user_view_details').html(response.data.display_kt_user_view_details); //display the user's details'
                            blockUI.release(); // hide the spinner
                            submitButtonUser.disabled = false; // hide the submit
                            modal.hide(); // hide the modal
                        })
                        .catch(error => {blockUI.release(); submitButtonUser.disabled = false;}); 
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
            initUpdateDetails();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersUpdateDetails.init();
});

</script>

<?= $this->endSection() ?>