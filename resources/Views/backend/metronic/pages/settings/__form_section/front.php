<!-- <div class="row">
    <label class="col-xl-3"></label>
    <div class="col-lg-9 col-xl-6">
        <h3 class="kt-section__title kt-section__title-sm"><?= ucfirst(lang('Core.info_front')); ?>:</h3>
    </div>
</div> -->

<div class="form-group form-group-sm row">
    <label class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_activer_front')); ?></label>
    <div class="col-lg-9 col-xl-6">
        <span class="switch">
            <label>
                <input type="checkbox" <?= ($form->setting_activer_front == true) ? 'checked="checked"' : ''; ?> name="global[setting_activer_front]" value="1">
                <span></span>
            </label>
        </span>
    </div>
</div>
<div class="form-group form-group-sm row">
    <label class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_activer_espace_public')); ?></label>
    <div class="col-lg-9 col-xl-6">
        <span class="switch">
            <label>
                <input type="checkbox" <?= ($form->setting_activer_espace_public == true) ? 'checked="checked"' : ''; ?> name="global[setting_activer_espace_public]" value="1">
                <span></span>
            </label>
        </span>
    </div>
</div>
<div class="form-group row">
    <label for="setting_theme_front" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.themes_front')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <select required name="user[setting_theme_front]" class="form-control kt-selectpicker" title="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>" id="setting_theme_front">
            <?php foreach ($getThemesFront as $theme) { ?>
                <?php foreach ($getThemesFront as $theme) { ?>
                    <option <?= $theme == $form->setting_theme_front ? 'selected' : ''; ?> value="<?= $theme; ?>"><?= ucfirst($theme); ?></option>
                <?php } ?>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group form-group-sm row">
    <label class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.site_maintenance')); ?></label>
    <div class="col-lg-9 col-xl-6">
        <span class="switch">
            <label>
                <input type="checkbox" <?= ($form->setting_maintenance == true) ? 'checked="checked"' : ''; ?> name="global[setting_maintenance]" value="1">
                <span></span>
            </label>
        </span>
    </div>
</div>
<div class="form-group row">
    <label for="setting_maintenance_ip_restrict" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_maintenance_ip_restrict')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('setting_maintenance_ip_restrict') ? old('setting_maintenance_ip_restrict') : $form->setting_maintenance_ip_restrict; ?>" name="global[setting_maintenance_ip_restrict]" id="setting_maintenance_ip_restrict">
        <span class="form-text text-muted"><?= ucfirst(lang('Core.champs_separe_point_virgule')); ?> : <a target="_blank" href="https://ip.lafibre.info/">https://ip.lafibre.info/</a></span>
    </div>
    <div class="col-lg-2">
        <button type="button" class="btn btn-default" onclick="addRemoteAddr();"><i class="fa fa-plus"></i> Ajouter mon IP</button>
    </div>
</div>

<div class="form-group form-group-sm row">
    <label class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_add_signature')); ?></label>
    <div class="col-lg-9 col-xl-6">
        <span class="switch">
            <label>
                <input type="checkbox" <?= ($form->setting_add_signature == true) ? 'checked="checked"' : ''; ?> name="global[setting_add_signature]" value="1">
                <span></span>
            </label>
        </span>
    </div>
</div>

<div class="kt-separator kt-separator--border-dashed kt-separator--portlet-fit kt-separator--space-lg"></div>

<div class="row">
    <label class="col-xl-3"></label>
    <div class="col-lg-9 col-xl-6">
        <h3 class="kt-section__title kt-section__title-sm"><?= ucfirst(lang('Core.seo_front')); ?>:</h3>
    </div>
</div>

<div class="form-group row">
    <label for="setting_front_title" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_front_title')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('setting_front_title') ? old('setting_front_title') : $form->setting_front_title; ?>" name="global[setting_front_title]" id="setting_front_title">
    </div>
</div>


<div class="form-group row">
    <label for="setting_front_meta_title" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_front_meta_title')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('setting_front_meta_title') ? old('setting_front_meta_title') : $form->setting_front_meta_title; ?>" name="global[setting_front_meta_title]" id="setting_front_meta_title">
    </div>
</div>

<div class="form-group row">
    <label for="setting_front_meta_description" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_front_meta_description')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('setting_front_meta_description') ? old('setting_front_meta_description') : $form->setting_front_meta_description; ?>" name="global[setting_front_meta_description]" id="setting_front_meta_description">
    </div>
</div>

<div class="kt-separator kt-separator--border-dashed kt-separator--portlet-fit kt-separator--space-lg"></div>

<div class="form-group row">
    <label for="setting_key_google_maps" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_key_google_maps')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('setting_key_google_maps') ? old('setting_key_google_maps') : $form->setting_key_google_maps; ?>" name="global[setting_key_google_maps]" id="setting_key_google_maps">
    </div>
</div>

<div class="form-group row">
    <label for="google_site_verification" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.google_site_verification')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('google_site_verification') ? old('google_site_verification') : $form->google_site_verification; ?>" name="global[google_site_verification]" id="google_site_verification">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<div class="form-group row">
    <label for="google_signin_client_id" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.google_signin_client_id')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('google_signin_client_id') ? old('google_signin_client_id') : $form->google_signin_client_id; ?>" name="global[google_signin_client_id]" id="google_signin_client_id">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<?php if (!empty($form->id)) { ?> <?= form_hidden('_id', $form->_id); ?> <?php } ?>
