<?= form_open('', ['id' => 'kt_apps_user_add_user_form', 'class' => 'kt-form', 'novalidate' => false]); ?>
    <input type="hidden" name="action" value="<?= $action; ?>" />
    
  
    <?php if (isset($notice) ){ ?>
        <?= $this->include('\Themes\backend\metronic\partials\extras\_notice'); ?>
    <?php } ?>

  
        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fs-6 fw-bold mb-2"><?= ucfirst(lang('Core.name')); ?>*</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" class="form-control form-control-solid" required placeholder="" name="name" type="text" value="<?= old('name') ? old('name') : $form->name; ?>" kl_vkbd_parsed="true">
            <!--end::Input-->
            <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
            <span class="form-text text-muted"><?= lang('Core.define_default_name_permission_delimiter'); ?></span>
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="fv-row mb-15">
            <!--begin::Label-->
            <label class="fs-6 fw-bold mb-2"><?= ucfirst(lang('Core.description')); ?>*</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" class="form-control form-control-solid" required placeholder="" value="<?= old('description') ? old('description') : $form->description; ?>" name="description" kl_vkbd_parsed="true">
            <!--end::Input-->
            <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
        </div>
        <!--end::Input group-->
    <!--end::User form-->

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
