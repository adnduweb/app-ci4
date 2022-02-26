<?php if(isset($button) && $button == 'button'){ ?> 
    <!--begin::Button-->
    <button type="button" data-kt-filemanager="imageManager" data-kt-filemanager-type="<?= $type; ?>" data-bs-target="#kt_modal_image_manager" class="btn btn-primary me-3 select-image"> <?= ucfirst(lang('Core.redimensionner')); ?></button>, 
    <!--end::Button-->
<?php } ?>

<?php if(isset($button) && $button == 'icone'){ ?> 
    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-filemanager-state="false" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar" data-kt-filemanager="imageManager" data-kt-filemanager-type="<?= $type; ?>" data-bs-target="#kt_modal_image_manager" class="btn btn-primary me-3 select-image">
        <i class="bi bi-pencil-fill fs-7"></i>
    </label>
<?php } ?>


<div class="inputs">
    <input type="hidden" class="id_media" name="<?= (isset($selector)) ? $selector . "[media_id]" : 'media_id' ; ?>" value="<?= $media->getID(); ?>" />
    <input type="hidden" class="uuid_media" name="<?= (isset($selector)) ? $selector . "[uuid_media]" : 'uuid_media' ; ?>" value="<?= $media->getUuid(); ?>" />
    <input type="hidden" class="url_media_medium" name="<?= (isset($selector)) ? $selector . "[url_media_medium]" : 'url_media_medium' ; ?>" value="<?= $media->getUrlMedia('medium'); ?>" />
</div>
