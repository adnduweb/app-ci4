<div class="row mb-10">
    <label for="nameApp" class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.name_app')); ?>* : </label>
    <div class="col-lg-8">
        <input class="form-control form-control-solid" required type="text" value="<?= old('nameApp') ? old('nameApp') : service('settings')->get('App.core', 'nameApp'); ?>" name="core[nameApp]" id="nameApp">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<div class="row mb-10">
    <label for="nameShortApp" class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.name_short_app')); ?>* : </label>
    <div class="col-lg-8">
        <input class="form-control form-control-solid" required type="text" value="<?= old('nameShortApp') ? old('nameShortApp') : service('settings')->get('App.core', 'nameShortApp'); ?>" name="core[nameShortApp]" id="nameShortApp">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<div class="row mb-10">
    <label for="descApp" class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.desc_app')); ?>* : </label>
    <div class="col-lg-8">
        <input class="form-control form-control-solid" required type="text" value="<?= old('descApp') ? old('descApp') : service('settings')->get('App.core', 'descApp'); ?>" name="core[descApp]" id="descApp">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<div class="row mb-10">
    <label for="id_group" class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.themes_admin')); ?>* : </label>
    <div class="col-lg-8">
        <!-- <select required name="user[themeAdmin]" class="form-select form-select-solid form-select-lg fw-bold" aria-label="Select a Country" data-kt-select2="true" data-control="select2" data-placeholder="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>" id="themeAdmin"> -->
        <select required name="theme_bo[name]" class="form-select form-select-solid" data-kt-select2="true" data-placeholder="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>" data-hide-search="true">
            <option value="">Select a Country...</option>
            <?php foreach ($getThemesAdmin as $theme) { ?>
                <option <?= $theme ==  service('settings')->get('App.theme_bo', 'name') ? 'selected' : ''; ?> value="<?= $theme; ?>"><?= ucfirst($theme); ?></option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="row mb-10">
    <label for="id_group" class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.themes_front')); ?>* : </label>
    <div class="col-lg-8">
        <!-- <select required name="user[themeAdmin]" class="form-select form-select-solid form-select-lg fw-bold" aria-label="Select a Country" data-kt-select2="true" data-control="select2" data-placeholder="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>" id="themeAdmin"> -->
        <select required name="theme_fo[name]" class="form-select form-select-solid" data-kt-select2="true" data-placeholder="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>" data-hide-search="true">
            <option value="">Select a Country...</option>
            <?php foreach ($getThemesFront as $theme) { ?>
                <option <?= $theme ==  service('settings')->get('App.theme_fo', 'name') ? 'selected' : ''; ?> value="<?= $theme; ?>"><?= ucfirst($theme); ?></option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="form-group form-group-sm row  mb-10">
    <label class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.displayManifest')); ?></label>
    <div class="col-lg-8">
        <div class="form-check form-switch form-check-custom form-check-solid">
            <input class="form-check-input" type="checkbox" <?= service('settings')->get('App.core', 'manifest') == true ? 'checked="checked"' : ''; ?> name="core[manifest]" value="1">
            <label class="form-check-label" for="flexCheckDefault"></label>
        </div>
    </div>
</div>

<div class="form-group form-group-sm row mb-10 ">
    <label class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.displayServicesWworkers')); ?></label>
    <div class="col-lg-8">
        <div class="form-check form-switch form-check-custom form-check-solid">
            <input class="form-check-input" type="checkbox" <?= ( service('settings')->get('App.core', 'servicesWworkers') == true) ? 'checked="checked"' : ''; ?> name="core[servicesWworkers]" value="1"> 
            <label class="form-check-label" for="flexCheckDefault"></label>
        </div>
    </div>
</div>


<?php if (!empty($form->id)) { ?> <?= form_hidden('_id', $form->_id); ?> <?php } ?>