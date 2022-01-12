<!-- <div class="row">
    <label class="col-xl-3"></label>
    <div class="col-lg-9 col-xl-6">
        <h3 class="kt-section__title kt-section__title-sm"><?= ucfirst(lang('Core.info_email')); ?>:</h3>
    </div>
</div> -->

<div class="form-group row">
    <label for="setting_email_fromEmail" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_email_fromEmail')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="text" value="<?= old('setting_email_fromEmail') ? old('setting_email_fromEmail') : $form->setting_email_fromEmail; ?>" name="global[setting_email_fromEmail]" id="setting_email_fromEmail">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<div class="form-group row">
    <label for="setting_email_bcc" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_email_bcc')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('setting_email_bcc') ? old('setting_email_bcc') : $form->setting_email_bcc; ?>" name="global[setting_email_bcc]" id="setting_email_fromEmail">
        <span class="form-text text-muted"><?= ucfirst(lang('Core.champs_separe_point_virgule')); ?></span>
    </div>
</div>

<div class="form-group row">
    <label for="setting_email_fromName" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_email_fromName')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="text" value="<?= old('setting_email_fromName') ? old('setting_email_fromName') : $form->setting_email_fromName; ?>" name="global[setting_email_fromName]" id="setting_email_fromEmail">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<div class="kt-separator kt-separator--border-dashed kt-separator--portlet-fit kt-separator--space-lg"></div>

<h3 class="kt-section__title kt-section__title-sm"><?= ucfirst(lang('Core.Mailchimp')); ?>:</h3>

<div class="form-group row">
    <label for="setting_mailchimp_api_key" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_mailchimp_api_key')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('setting_mailchimp_api_key') ? old('setting_mailchimp_api_key') : $form->setting_mailchimp_api_key; ?>" name="global[setting_mailchimp_api_key]" id="setting_mailchimp_api_key">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<div class="form-group row">
    <label for="setting_mailchimp_id_list_1" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_mailchimp_id_list_1')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('setting_mailchimp_id_list_1') ? old('setting_mailchimp_id_list_1') : $form->setting_mailchimp_id_list_1; ?>" name="global[setting_mailchimp_id_list_1]" id="setting_mailchimp_id_list_1">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<div class="form-group row">
    <label for="setting_mailchimp_id_list_2" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_mailchimp_id_list_2')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('setting_mailchimp_id_list_2') ? old('setting_mailchimp_id_list_2') : $form->setting_mailchimp_id_list_2; ?>" name="global[setting_mailchimp_id_list_2]" id="setting_mailchimp_id_list_2">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<div class="kt-separator kt-separator--border-dashed kt-separator--portlet-fit kt-separator--space-lg"></div>

<h3 class="kt-section__title kt-section__title-sm"><?= ucfirst(lang('Core.SendinBlue')); ?>:</h3>

<div class="form-group row">
    <label for="setting_sendinblue_api_key" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_sendinblue_api_key')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('setting_sendinblue_api_key') ? old('setting_sendinblue_api_key') : $form->setting_sendinblue_api_key; ?>" name="global[setting_sendinblue_api_key]" id="setting_sendinblue_api_key">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<div class="form-group row">
    <label for="setting_sendinblue_partner_key" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_sendinblue_partner_key')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('setting_sendinblue_partner_key') ? old('setting_sendinblue_partner_key') : $form->setting_sendinblue_partner_key; ?>" name="global[setting_sendinblue_partner_key]" id="setting_sendinblue_partner_key">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<?php if (!empty($form->id)) { ?> <?= form_hidden('_id', $form->_id); ?> <?php } ?>