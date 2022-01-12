<!-- <div class="row">
    <label class="col-xl-3"></label>
    <div class="col-lg-9 col-xl-6">
        <h3 class="kt-section__title kt-section__title-sm"><?= ucfirst(lang('Core.info_images')); ?>:</h3>
    </div>
</div> -->

<div class="form-group row">
    <label for="setting_image_thumbnail_size" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_image_thumbnail_size')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="text" value="<?= old('setting_image_thumbnail_size') ? old('setting_image_thumbnail_size') : $form->setting_image_thumbnail_size; ?>" name="global[setting_image_thumbnail_size]" id="setting_image_thumbnail_size">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<div class="form-group row">
    <label for="setting_image_small_size" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_image_small_size')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="text" value="<?= old('setting_image_small_size') ? old('setting_image_small_size') : $form->setting_image_small_size; ?>" name="global[setting_image_small_size]" id="setting_image_small_size">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<div class="form-group row">
    <label for="setting_image_medium_size" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_image_medium_size')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="text" value="<?= old('setting_image_medium_size') ? old('setting_image_medium_size') : $form->setting_image_medium_size; ?>" name="global[setting_image_medium_size]" id="setting_image_thumbnail_size">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<div class="form-group row">
    <label for="setting_image_large_size" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_image_large_size')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="text" value="<?= old('setting_image_large_size') ? old('setting_image_large_size') : $form->setting_image_large_size; ?>" name="global[setting_image_large_size]" id="setting_image_large_size">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>



<?php if (!empty($form->id)) { ?> <?= form_hidden('_id', $form->_id); ?> <?php } ?>