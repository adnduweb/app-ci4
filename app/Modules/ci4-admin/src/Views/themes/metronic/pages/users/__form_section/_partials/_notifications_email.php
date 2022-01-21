 <!--begin::Card-->
 <div class="card pt-4 mb-6 mb-xl-9" id="kt_notification_form">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title flex-column">
            <h2><?= ucfirst(lang('Core.settings')); ?></h2>
            <div class="fs-6 fw-bold text-muted">Choose what messages you’d like to receive for each of your accounts.</div>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body">
        <!--begin::Form-->

        <?= form_open('', ['id' => 'kt_users_notification_form', 'class' => 'kt-form form', 'novalidate' => false]); ?>
        <input type="hidden" name="action" value="edit_user_notification" />
        <input type="hidden" name="uuid" value="<?= $form->uuid; ?>" />
        <input type="hidden" name="id" value="<?= $form->id; ?>" />
   
        <div class="separator separator-dashed my-5"></div>
            <!--begin::Item-->
            <div class="d-flex">
                <!--begin::Checkbox-->
                <div class="form-check form-check-custom form-check-solid">
                    <!--begin::Input-->
                    <input class="form-check-input me-3" <?=  (service('settings')->get('App.theme_bo', 'connexionUnique') == '1') ? 'checked="checked"' : ''; ?> name="connexionUnique" type="checkbox" value="1" id="connexionUnique">
                    <!--end::Input-->
                    <!--begin::Label-->
                    <label class="form-check-label" for="kt_modal_update_email_notification_2">
                        <div class="fw-bolder"><?= lang('Core.connexionUnique'); ?></div>
                        <div class="text-gray-600"><?= lang('Core.connexion avec une seule adresse ip'); ?></div>
                    </label>
                    <!--end::Label-->
                </div>
                <!--end::Checkbox-->
            </div>
            <!--end::Item-->
            <div class="separator separator-dashed my-5"></div>
            <!--begin::Item-->
            <div class="d-flex">
                <!--begin::Checkbox-->
                <div class="form-check form-check-custom form-check-solid">
                    <!--begin::Input-->
                    <input class="form-check-input me-3" <?= ($form->force_pass_reset == '1') ? 'checked="checked"' : ''; ?> name="force_pass_reset" type="checkbox" value="1" id="force_pass_reset">
                    <!--end::Input-->
                    <!--begin::Label-->
                    <label class="form-check-label" for="kt_modal_update_email_notification_3">
                        <div class="fw-bolder"><?= lang('Core.force_chgt_password'); ?></div>
                        <div class="text-gray-600"><?= lang('Core.force_pass_reset_form_tooltip_info'); ?></div>
                    </label>
                    <!--end::Label-->
                </div>
                <!--end::Checkbox-->
            </div>
            <!--begin::Action buttons-->
            <div class="d-flex justify-content-end align-items-center mt-12">
                <!--begin::Button-->
                <button type="button" class="btn btn-light me-5" id="kt_users_email_notification_cancel">Cancel</button>
                <!--end::Button-->
                <!--begin::Button-->
                <button type="button" class="btn btn-primary" id="kt_users_email_notification_submit" data-kt-users-modal-action="submit">
                    <span class="indicator-label">Save</span>
                    <span class="indicator-progress">Please wait... 
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!--end::Button-->
            </div>
            <!--begin::Action buttons-->
        <?= form_close(); ?>
        <!--end::Form-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->

<?= $this->section('AdminAfterExtraJs') ?>
<script type="text/javascript">

"use strict";

// Class definition
var KTUsersUpdateNotification = function () {
    // Shared variables
    const element = document.getElementById('kt_notification_form');
    const form = element.querySelector('#kt_users_notification_form');
    const modal = new bootstrap.Modal(element);

    // Init add schedule modal
    var initUpdateNotification = () => {

        // Submit button handler
        const submitButtonNotification = element.querySelector('[data-kt-users-modal-action="submit"]');
        var target = document.querySelector("#kt_notification_form");
        var blockUI = new KTBlockUI(target);
        submitButtonNotification.addEventListener('click', function (e) {
            // Prevent default button action
            e.preventDefault();

            submitButtonNotification.setAttribute('data-kt-indicator', 'on'); // Show loading indication                       
            blockUI.block(); // Spinner
            submitButtonNotification.disabled = true;// Disable button to avoid multiple click 

            axios.post("<?= route_to('user-save-detail') ?>", $('#kt_users_notification_form').serialize())
            .then( response => {
                submitButtonNotification.removeAttribute('data-kt-indicator'); // remove the indicator
                toastr.success(response.data.messages.success, _LANG_.updated + "!"); // Notifils'
                blockUI.release(); // hide the spinner
                submitButtonNotification.disabled = false; // hide the submit
                modal.hide(); // hide the modal
            })
            .catch(error => {blockUI.release(); submitButtonNotification.disabled = false;}); 
        });
    }

    return {
        // Public functions
        init: function () {
            initUpdateNotification();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersUpdateNotification.init();
});

</script>

<?= $this->endSection() ?>