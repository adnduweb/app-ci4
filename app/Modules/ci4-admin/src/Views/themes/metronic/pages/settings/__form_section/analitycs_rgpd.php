<div class="kt-separator kt-separator--border-dashed kt-separator--portlet-fit kt-separator--space-lg"></div>

<div class="row mb-10">
    <label for="tagManager" class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.tagManager')); ?>* : </label>
     <div class="col-lg-8">
        <input class="form-control form-control-solid" type="text" value="<?= old('tagManager') ? old('tagManager') : $form->tagManager ?>" name="global[tagManager]" id="tagManagercode">
    </div>
</div>

<?php foreach ($languages as $language) { ?>
    <div class="row mb-10">
        <label for="googleAnalitycs<?= $language->iso_code; ?>Code" class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.googleAnalitycs' . $language->iso_code . 'Code')); ?>* : </label>
         <div class="col-lg-8">
            <?php $googleAnalitycscode = 'googleAnalitycs' . $language->iso_code . 'Code'; ?>
            <input class="form-control form-control-solid" type="text" value="<?= old('googleAnalitycs' . $language->iso_code . 'Code') ? old('googleAnalitycs' . $language->iso_code . 'Code') : $form->{$googleAnalitycscode} ?>" name="global[googleAnalitycs<?= $language->iso_code; ?>Code]" id="front_meta_description">
        </div>
    </div>
    <div class="row mb-10">
        <label for="googleAnalitycs<?= $language->iso_code; ?>_domain" class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.googleAnalitycs' . $language->iso_code . 'Domain')); ?>* : </label>
         <div class="col-lg-8">
            <?php $googleAnalitycsdomain = 'googleAnalitycs' . $language->iso_code . 'Domain'; ?>
            <input class="form-control form-control-solid" type="text" value="<?= old('googleAnalitycs' . $language->iso_code . 'Domain') ? old('googleAnalitycs' . $language->iso_code . 'Domain') :  $form->{$googleAnalitycsdomain}  ?>" name="global[googleAnalitycs<?= $language->iso_code; ?>Domain]" id="front_meta_description">
        </div>
    </div>
<?php } ?>


<div class="row mb-10">
    <label for="google_maps" class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.googleMaps')); ?>* : </label>
     <div class="col-lg-8">
        <input class="form-control form-control-solid" type="text" value="<?= old('googleMaps') ? old('googleMaps') : $form->googleMaps ?>" name="global[googleMaps]" id="googleMaps">
    </div>
</div>


<div class="row mb-10">
    <label for="googleMaps" class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.googleMaps')); ?>* : </label>
     <div class="col-lg-8">
        <input class="form-control form-control-solid" type="text" value="<?= old('googleMaps') ? old('googleMaps') : $form->googleMaps ?>" name="global[googleMaps]" id="google_maps">
    </div>
</div>

<div class="kt-separator kt-separator--border-dashed kt-separator--portlet-fit kt-separator--space-lg"></div>

<div class="row mb-10">
    <label class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.rgpdYoutube')); ?></label>
     <div class="col-lg-8">
        <div class="form-check form-switch form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" <?= ($form->rgpdYoutube == true) ? 'checked="checked"' : ''; ?> name="global[rgpdYoutube]" value="1">
                <label class="form-check-label" for="flexCheckDefault"></label>
        </div>
    </div>
</div>

<div class="row mb-10">
    <label class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.rgpdFacebook')); ?></label>
     <div class="col-lg-8">
        <div class="form-check form-switch form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" <?= ($form->rgpdFacebook == true) ? 'checked="checked"' : ''; ?> name="global[rgpdFacebook]" value="1">
                <label class="form-check-label" for="flexCheckDefault"></label>
        </div>
    </div>
</div>

<div class="row mb-10">
    <label class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.rgpdTwitter')); ?></label>
     <div class="col-lg-8">
        <div class="form-check form-switch form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" <?= ($form->rgpdTwitter == true) ? 'checked="checked"' : ''; ?> name="global[rgpdTwitter]" value="1">
                <label class="form-check-label" for="flexCheckDefault"></label>
        </div>
    </div>
</div>

<div class="row mb-10">
    <label class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.rgpdStoreCookieConsent')); ?></label>
     <div class="col-lg-8">
        <div class="form-check form-switch form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" <?= ($form->rgpdStoreCookieConsent == true) ? 'checked="checked"' : ''; ?> name="global[rgpdStoreCookieConsent]" value="1">
                <label class="form-check-label" for="flexCheckDefault"></label>
        </div>
    </div>
</div>
