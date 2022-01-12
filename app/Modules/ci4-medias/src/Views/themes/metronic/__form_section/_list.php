 <!--begin::Button-->
 <button type="button" data-kt-filemanager="croppedFile" data-uuid=<?= $form->getUUID(); ?> id="kt_modal_redimensionner" class="btn btn-primary me-3 select-image"> <?= ucfirst(lang('Core.redimensionner')); ?></button>
<!--end::Button-->

<div class="table-responsive">
<!--begin::Table-->
<table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
    <!--begin::Table head-->
    <thead>
        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
            <th class="min-w-175px">Images</th>
            <th class="min-w-100px text-end">Taille</th>
            <th class="min-w-70px text-end">dimension</th>
            <th class="min-w-100px text-end">date</th>
        </tr>
    </thead>
    <!--end::Table head-->
    <!--begin::Table body-->
    <tbody class="fw-bold text-gray-600">
        <?php $file = new \CodeIgniter\Files\File($form->getPath('thumbnails')); ?>
        <?php list($width, $height, $type, $attr) =  getimagesize($form->getPath('thumbnails')); ?>
        <tr>
            <!--begin::Product-->
            <td>
                <div class="d-flex align-items-center">
                    <!--begin::Thumbnail-->
                    <a href="<?= current_url(); ?>#" class="symbol symbol-50px">
                        <span class="symbol-label" style="background-image:url(<?= img_data($form->getPath('thumbnails')); ?>"></span>
                    </a>
                    

                     <!--end::Thumbnail-->
                    <!--begin::Title-->
                    <div class="ms-5">
                        <div class="fs-7 text-muted">Vignette</div>
                        <div class="fs-7 text-muted">
                            <a target="_blank" href="<?= $form->getUrlMedia('thumbnails'); ?>" class="symbol symbol-50px"><?= $form->getUrlMedia('thumbnails'); ?></a>
                        </div>
                    </div>
                    <!--end::Title-->
                </div>
            </td>
            <!--end::Product-->
            <!--begin::SKU-->
            <td class="text-end"><?= bytes2human($file->getSize()); ?></td>
            <!--end::SKU-->
            <!--begin::Quantity-->
            <td class="text-end"><?= $width; ?> x <?= $height; ?></td>
            <!--end::Quantity-->
            <!--begin::Price-->
            <td class="text-end"><?= $time = \CodeIgniter\I18n\Time::parse(date("F d, Y H:i:s", filemtime($form->getPath('thumbnails'))))->humanize(); ?></td>
            <!--end::Price-->
        </tr>


        <?php $file = new \CodeIgniter\Files\File($form->getPath('small')); ?>
        <?php list($width, $height, $type, $attr) =  getimagesize($form->getPath('small')); ?>
        <tr>
            <!--begin::Product-->
            <td>
                <div class="d-flex align-items-center">
                    <!--begin::Thumbnail-->
                    <a href="<?= current_url(); ?>#" class="symbol symbol-50px">
                        <span class="symbol-label" style="background-image:url(<?= img_data($form->getPath('thumbnails')); ?>"></span>
                    </a>

                     <!--end::Thumbnail-->
                    <!--begin::Title-->
                    <div class="ms-5">
                        <div class="fs-7 text-muted">Small</div>
                        <div class="fs-7 text-muted">
                            <a target="_blank" href="<?= $form->getUrlMedia('small'); ?>" class="symbol symbol-50px"><?= $form->getUrlMedia('small'); ?></a>
                        </div>
                    </div>
                    <!--end::Title-->
                </div>
            </td>
            <!--end::Product-->
            <!--begin::SKU-->
            <td class="text-end"><?= bytes2human($file->getSize()); ?></td>
            <!--end::SKU-->
            <!--begin::Quantity-->
            <td class="text-end"><?= $width; ?> x <?= $height; ?></td>
            <!--end::Quantity-->
            <!--begin::Price-->
            <td class="text-end"><?= $time = \CodeIgniter\I18n\Time::parse(date("F d, Y H:i:s", filemtime($form->getPath('small'))))->humanize(); ?></td>
            <!--end::Price-->
        </tr>

        <?php $file = new \CodeIgniter\Files\File($form->getPath('medium')); ?>
        <?php list($width, $height, $type, $attr) =  getimagesize($form->getPath('medium')); ?>
        <tr>
            <!--begin::Product-->
            <td>
                <div class="d-flex align-items-center">
                    <!--begin::Thumbnail-->
                    <a href="<?= current_url(); ?>#" class="symbol symbol-50px">
                        <span class="symbol-label" style="background-image:url(<?= img_data($form->getPath('thumbnails')); ?>"></span>
                    </a>

                     <!--end::Thumbnail-->
                    <!--begin::Title-->
                    <div class="ms-5">
                        <div class="fs-7 text-muted">Medium</div>
                        <div class="fs-7 text-muted">
                            <a target="_blank" href="<?= $form->getUrlMedia('medium'); ?>" class="symbol symbol-50px"><?= $form->getUrlMedia('medium'); ?></a>
                        </div>
                    </div>
                    <!--end::Title-->
                </div>
            </td>
            <!--end::Product-->
            <!--begin::SKU-->
            <td class="text-end"><?= bytes2human($file->getSize()); ?></td>
            <!--end::SKU-->
            <!--begin::Quantity-->
            <td class="text-end"><?= $width; ?> x <?= $height; ?></td>
            <!--end::Quantity-->
            <!--begin::Price-->
            <td class="text-end"><?= $time = \CodeIgniter\I18n\Time::parse(date("F d, Y H:i:s", filemtime($form->getPath('medium'))))->humanize(); ?></td>
            <!--end::Price-->
        </tr>

        <?php $file = new \CodeIgniter\Files\File($form->getPath('large')); ?>
        <?php list($width, $height, $type, $attr) =  getimagesize($form->getPath('large')); ?>
        <tr>
            <!--begin::Product-->
            <td>
                <div class="d-flex align-items-center">
                    <!--begin::Thumbnail-->
                    <a href="<?= current_url(); ?>#" class="symbol symbol-50px">
                        <span class="symbol-label" style="background-image:url(<?= img_data($form->getPath('thumbnails')); ?>"></span>
                    </a>

                     <!--end::Thumbnail-->
                    <!--begin::Title-->
                    <div class="ms-5">
                        <div class="fs-7 text-muted">large</div>
                        <div class="fs-7 text-muted">
                            <a target="_blank" href="<?= $form->getUrlMedia('large'); ?>" class="symbol symbol-50px"><?= $form->getUrlMedia('large'); ?></a>
                        </div>
                    </div>
                    <!--end::Title-->
                </div>
            </td>
            <!--end::Product-->
            <!--begin::SKU-->
            <td class="text-end"><?= bytes2human($file->getSize()); ?></td>
            <!--end::SKU-->
            <!--begin::Quantity-->
            <td class="text-end"><?= $width; ?> x <?= $height; ?></td>
            <!--end::Quantity-->
            <!--begin::Price-->
            <td class="text-end"><?= $time = \CodeIgniter\I18n\Time::parse(date("F d, Y H:i:s", filemtime($form->getPath('large'))))->humanize(); ?></td>
            <!--end::Price-->
        </tr>

        <?php if(!empty($form->custom)){ ?>
                <?php foreach($form->custom as $custom){ ?>
                    <?php $file = new \CodeIgniter\Files\File(config('Medias')->getPath() . 'custom/' . $custom); ?>
                    <?php list($width, $height, $type, $attr) =  getimagesize(config('Medias')->getPath() . 'custom/' . $custom); ?>
                    <tr>
                        <!--begin::Product-->
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin::Thumbnail-->
                                <a href="<?= current_url(); ?>#" class="symbol symbol-50px">
                                    <span class="symbol-label" style="background-image:url(<?= img_data($form->getPath('thumbnails')); ?>"></span>
                                </a>

                                <!--end::Thumbnail-->
                                <!--begin::Title-->
                                <div class="ms-5">
                                    <div class="fs-7 text-muted">Personnalisé</div>
                                    <div class="fs-7 text-muted">
                                        <a target="_blank" href="<?= $form->getUrlMedia('custom', $width, $height); ?>" class="symbol symbol-50px"><?= $form->getUrlMedia('custom', $width, $height); ?></a>
                                    </div>
                                </div>
                                <!--end::Title-->
                            </div>
                        </td>
                        <!--end::Product-->
                        <!--begin::SKU-->
                        <td class="text-end"><?= bytes2human($file->getSize()); ?></td>
                        <!--end::SKU-->
                        <!--begin::Quantity-->
                        <td class="text-end"><?= $width; ?> x <?= $height; ?></td>
                        <!--end::Quantity-->
                        <!--begin::Price-->
                        <td class="text-end"><?= $time = \CodeIgniter\I18n\Time::parse(date("F d, Y H:i:s", filemtime(config('Medias')->getPath() . 'custom/' . $custom)))->humanize(); ?></td>
                        <!--end::Price-->
                    </tr>
                <?php } ?>
        <?php } ?>

    </tbody>
</table>