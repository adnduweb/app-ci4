<?php 
$paramsMedia = [
    'button' => 'icone', 
    'type' => 'image', 
    'multiple' => 'false',
    'media' => $form->getMedia()
    ]; ?>

<!--begin::Thumbnail settings-->
<div class="card card-flush py-4">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>Image</h2>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body text-center pt-0">
        <!--begin::Image input-->
        <div class="image-input <?= (!empty($form->media_id)) ? '' : 'image-input-empty';?> image-input-outline mb-3" data-kt-image-input="true" style="">
            <!--begin::Preview existing avatar-->
            <div class="image-input-wrapper w-150px h-150px" style="background-image: url(<?= $form->getUrlMedia('medium'); ?>"></div>
            <!--end::Preview existing avatar-->
            <!--begin::Label-->
            <?= view('Adnduweb\Ci4Medias\Views\themes\metronic\_templates\add_button', $paramsMedia) ?>
            <!--end::Label-->
            <!--begin::Cancel-->
            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-imagemanager-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                <i class="bi bi-x fs-2"></i>
            </span>
            <!--end::Cancel-->
            <?php if(!empty($form->media_id)){ ?>
            <!--begin::Remove-->
            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-imagemanager-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                <i class="bi bi-x fs-2"></i>
            </span>
            <!--end::Remove-->
            <?php } ?>
        </div>
        <!--end::Image input-->
        <!--begin::Description-->
        <div class="text-muted fs-7">Définissez l'image miniature de la création. Seuls les fichiers images *.png, *.jpg et *.jpeg sont acceptés</div>
        <!--end::Description-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Thumbnail settings-->