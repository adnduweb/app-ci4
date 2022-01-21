<?= form_open('', ['id' => 'kt_apps_form_new_user', 'class' => 'kt-form', 'novalidate' => false]); ?>
    <?= form_hidden('action', $action); ?>
    <?= form_hidden('company_id', 1); ?>
    
  
    <?php if (isset($notice) ){ ?>
        <?= $this->include('\Themes\backend\metronic\partials\extras\_notice'); ?>
    <?php } ?>

  
        <?php if (config('Auth')->requireActivation !== false) { ?>
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <label class="fs-6 fw-bold mb-2"><?= ucfirst(lang('Auth.code_activation')); ?> </label>
                <!--begin::Switch-->
                <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                    <!--begin::Input-->
                    <input class="form-check-input" name="requireactivation" type="checkbox" value="1" id="requireactivation">
                    <!--end::Input-->
                    <!--begin::Label-->
                    <span class="form-check-label fw-bold text-muted" for="requireactivation"></span>
                    <!--end::Label-->
                </label>
                <!--end::Switch-->
                <span class="form-text text-muted"><?= lang('Auth.explain_activation'); ?></span>
            <!--end::Input-->
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
            <input type="text" class="form-control form-control-solid" readonly required placeholder="" name="username" value="<?= old('username') ? old('username') : $form->username; ?>" />
            <!--end::Input-->
        </div>
        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fs-6 fw-bold mb-2"><?= ucfirst(lang('Core.lastname')); ?>*</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" class="form-control form-control-solid" required placeholder="" name="lastname" value="<?= old('lastname') ? old('lastname') : $form->lastname; ?>" />
            <!--end::Input-->
        </div>
            <!--begin::Input group-->
            <div class="fv-row mb-7">
            <!--begin::Label-->
            <label for="firstname" class="fs-6 fw-bold mb-2"><?= ucfirst(lang('Core.firstname')); ?>*</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" class="form-control form-control-solid" required placeholder="" name="firstname" value="<?= old('firstname') ? old('firstname') : $form->firstname; ?>" />
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
            <input type="email" class="form-control form-control-solid" required placeholder="" name="email" value="<?= old('email') ? old('email') : $form->email; ?>" />
            <!--end::Input-->
        </div>

        <!--begin::Input group-->
        <div class="mb-10 fv-row" data-kt-password-meter="true">
            <!--begin::Wrapper-->
            <div class="mb-1">
                <!--begin::Label-->
                <label class="form-label fw-bold fs-6 mb-2">New Password</label>
                <!--end::Label-->
                <!--begin::Input wrapper-->
                <div class="position-relative mb-3">
                    <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="password" autocomplete="off" />
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
            <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="pass_confirm" autocomplete="off" />
        </div>
        <!--end::Input group=-->

        <!--begin::Input group-->
        <div class="fv-row mb-15">
            <!--begin::Label-->
            <label class="fs-6 fw-bold mb-2"><?= ucfirst(lang('Core.groupes')); ?>* :</label>
            <!--end::Label-->
            <!--begin::Input-->

            <select name="group" required aria-label="Select a <?= ucfirst(lang('Core.groupes')); ?>" data-control="select2" data-placeholder="Select a <?= ucfirst(lang('Core.groupes')); ?>..." class="form-select form-control form-select-solid">
                <option></option>
                <?php foreach ($groups as $group) { ?>
                    <option value="<?= $group->name; ?>" <?= old('group') ? 'selected' : ''; ?> ><?= ucfirst($group->name); ?></option>
                <?php } ?>

            </select>
            <!--end::Input-->
        </div>
        <!--end::Input group-->

        <!--begin::Modal footer-->
        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button type="reset" id="kt_modal_update_customer_cancel" class="btn btn-light me-3"> <?= ucfirst(lang('Core.discard')); ?></button>
            <!--end::Button-->
            <!--begin::Button-->
            <button type="submit" id="kt_modal_update_customer_submit" class="btn btn-primary">
                <span class="indicator-label"> <?= ucfirst(lang('Core.save_form')); ?></span>
                <span class="indicator-progress"><?= ucfirst(lang('Core.please_wait...')); ?> 
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
        </div>
        <?php if (! empty($form->id)) { ?> <?= form_hidden('id', $form->id); ?> <?php } ?>
	<!-- end:: Content -->
<?= form_close(); ?>


<?= $this->section('AdminAfterExtraJs') ?>

<script type="text/javascript">

var createUsername = function () {
    var fname = $('#kt_apps_form_new_user input[name=firstname]').val().substring(0, 1).toLowerCase();
    var lname = $('#kt_apps_form_new_user input[name=lastname]').val().toLowerCase();
    var username = fname + lname + Math.floor(Math.random() * (10000 + 1) + 1000);
    $('#kt_apps_form_new_user input[name=username]').val(username);
}

    $('#kt_apps_form_new_user input[name=firstname]').on('keyup', createUsername);
    $('#kt_apps_form_new_user input[name=lastname]').on('keyup', createUsername);

</script>

<?= $this->endSection() ?>