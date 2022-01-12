<!-- <div class="row">
    <label class="col-xl-3"></label>
    <div class="col-lg-9 col-xl-6">
        <h3 class="kt-section__title kt-section__title-sm"><?= ucfirst(lang('Core.info_front')); ?>:</h3>
    </div>
</div> -->

<div class="form-group form-group-sm row">
    <label class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_activer_ecommerce')); ?></label>
    <div class="col-lg-9 col-xl-6">
        <span class="switch">
            <label>
                <input type="checkbox" <?= ($form->setting_activer_ecommerce == true) ? 'checked="checked"' : ''; ?> name="global[setting_activer_ecommerce]" value="1">
                <span></span>
            </label>
        </span>
    </div>
</div>

<?php foreach ($languages as $language) {?>

    <div class="form-group row">
    <label for="setting_devise_<?= $language->iso_code; ?>" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.devise')); ?> : <?= $language->iso_code; ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <select required name="global[setting_devise_<?= $language->iso_code; ?>]" class="form-control kt-selectpicker" title="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>" id="setting_devise_<?= $language->iso_code; ?>">
        <?php foreach ($currencies as $currency) { ?>
            <?php $setting_devise = 'setting_devise_' . $language->iso_code; ?>
                <option <?= ($form->{$setting_devise} == $currency->id) ? 'selected' : ''; ?> value="<?= $currency->id; ?>"><?= ucfirst($currency->name); ?></option>
            <?php } ?>
        </select>
    </div>
</div>

<?php } ?>


<div class="form-group row">
<label for="setting_devise_default" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.devise')); ?> : default* : </label>
    <div class="col-lg-9 col-xl-6">
        <select required name="global[setting_devise_default]" class="form-control kt-selectpicker" title="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>" id="setting_devise_default">
        <?php foreach ($currencies as $currency) { ?>
                <option <?= ($form->setting_devise_default == $currency->id) ? 'selected' : ''; ?> value="<?= $currency->id; ?>"><?= ucfirst($currency->name); ?></option>
            <?php } ?>
        </select>
    </div>
</div>

<?php if (!empty($form->id)) { ?> <?= form_hidden('_id', $form->_id); ?> <?php } ?>
