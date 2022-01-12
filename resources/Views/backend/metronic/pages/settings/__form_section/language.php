
<div class="form-group form-group-sm row">
    <label class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.activerMultilangue')); ?></label>
    <div class="col-lg-9 col-xl-6">
        <span class="switch switch--icon">
            <label>
                <input type="checkbox" <?= ($form->activerMultilangue == true) ? 'checked="checked"' : ''; ?> name="global[activerMultilangue]" value="1">
                <span></span>
            </label>
        </span>
    </div>
</div>
<div class="form-group row">
    <label for="defaultLocale" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.language_by_default')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <select required name="global[defaultLocale]" class="form-control kt-selectpicker" title="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>" id="defaultLocale">
            <?php foreach ($languages as $language) {
                $defaultLocale = explode('|', $form->defaultLocale); ?>
                <option <?= $language->iso_code == $defaultLocale[1] ? 'selected' : ''; ?> value="<?= $language->id; ?>|<?= $language->iso_code; ?>"><?= ucfirst($language->name); ?></option>
            <?php } ?>
        </select>
    </div>
</div>

<?php $supportedLocales = ($form->supportedLocales !='') ? array_flip(json_decode($form->supportedLocales)) : null;?> 
<div class="form-group row">
    <label for="defaultLocale" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.language_supported')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <select  <?= ($form->activerMultilangue == true) ? 'required' : ''; ?> name="global[supportedLocales][]" class="form-control kt-selectpicker" multiple title="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>" id="supportedLocales">
            <?php foreach ($languages as $language) { ?>
                <option <?= isset($supportedLocales[$language->id . '|' . $language->iso_code]) ? 'selected' : ''; ?> value="<?= $language->id; ?>|<?= $language->iso_code; ?>"><?= ucfirst($language->name); ?></option>
            <?php } ?>
        </select>
    </div>
</div>
