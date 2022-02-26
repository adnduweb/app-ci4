<div class="kt-separator kt-separator--border-dashed kt-separator--portlet-fit kt-separator--space-lg"></div>

<div class="row mb-10">
    <label for="tagManager" class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.tagManager')); ?>* : </label>
     <div class="col-lg-8">
        <input class="form-control form-control-solid" type="text" value="<?= old('tagManager') ? old('tagManager') : service('settings')->get('App.core', 'tagManager'); ?>" name="core[tagManager]" id="tagManagercode">
    </div>
</div>

<div class="row mb-10">
    <label for="googleAnalitycs" class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.googleAnalitycsCode')); ?>* : </label>
        <div class="col-lg-8">
        <input class="form-control form-control-solid" type="text" value="<?= old('core.googleAnalitycs_' .service('request')->getLocale()) ? old('core.googleAnalitycs_' .service('request')->getLocale()) : service('settings')->get('App.core', 'googleAnalitycs_' .service('request')->getLocale()); ?>" name="core[googleAnalitycs_<?= service('request')->getLocale(); ?>]" id="consent-googleAnalitycs_<?= service('request')->getLocale(); ?>" id="googleAnalitycs">
    </div>
</div>


<div class="row mb-10">
    <label for="google_maps" class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.googleMaps')); ?>* : </label>
     <div class="col-lg-8">
        <input class="form-control form-control-solid" type="text" value="<?= old('googleMaps') ? old('googleMaps') : service('settings')->get('App.core', 'googleMaps'); ?>" name="core[googleMaps]" id="googleMaps">
    </div>
</div>

<div class="kt-separator kt-separator--border-dashed kt-separator--portlet-fit kt-separator--space-lg"></div>

<div class="row mb-10">
    <label class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.rgpdYoutube')); ?></label>
     <div class="col-lg-8">
        <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox"  <?= service('settings')->get('App.rgpd', 'rgpdYoutube') == true ? 'checked="checked"' : ''; ?> name="rgpd[rgpdYoutube]" value="1">
                <label class="form-check-label" for="flexCheckDefault"></label>
        </div>
    </div>
</div>

<div class="row mb-10">
    <label class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.rgpdFacebook')); ?></label>
     <div class="col-lg-8">
        <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" <?= service('settings')->get('App.rgpd', 'rgpdFacebook') == true ? 'checked="checked"' : ''; ?> name="rgpd[rgpdFacebook]" value="1">
                <label class="form-check-label" for="flexCheckDefault"></label>
        </div>
    </div>
</div>

<div class="row mb-10">
    <label class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.rgpdTwitter')); ?></label>
     <div class="col-lg-8">
        <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" <?= service('settings')->get('App.rgpd', 'rgpdTwitter') == true ? 'checked="checked"' : ''; ?> name="rgpd[rgpdTwitter]" value="1">
                <label class="form-check-label" for="flexCheckDefault"></label>
        </div>
    </div>
</div>

<div class="row mb-10">
    <label class="col-lg-4 col-form-label required fw-bold fs-6"><?= ucfirst(lang('Core.rgpdStoreCookieConsent')); ?></label>
     <div class="col-lg-8">
        <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" <?= service('settings')->get('App.rgpd', 'rgpdStoreCookieConsent') == true ? 'checked="checked"' : ''; ?> name="rgpd[rgpdStoreCookieConsent]" value="1">
                <label class="form-check-label" for="flexCheckDefault"></label>
        </div>
    </div>
</div>
