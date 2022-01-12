<?php
helper('form');

?>
<div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobile ">
    <div class="kt-portlet__head kt-portlet__head--lg kt-portlet__head--noborder kt-portlet__head--break-sm">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title mb-10">
                <?= lang('Core.fichier'); ?> : <?= $file; ?> | <?= lang('Core.langue'); ?> : <?= $lang; ?>
            </h3>
        </div>
    </div>




    <div class="kt-portlet__body">
        <?= form_open('', ['id' => 'save_translate', 'class' => 'kt-form', 'novalidate' => false]); ?>
        <?php foreach ($langue as $k => $v) { ?>
            <div class="form-group row">
                <div class="col-lg-5">
                    <label><?= lang('Core.label_texte'); ?>: </label>
                    <input disabled type="text" class="form-control" placeholder="<?= lang('Core.enter_texte'); ?>" value="<?= $k; ?>">
                </div>
                <div class="col-lg-5">
                    <label><?= lang('Core.label_value'); ?>: </label>
                    <input type="text" class="form-control" placeholder="<?= lang('Core.enter_value'); ?>" name="name|<?= $k; ?>" value="<?= $v; ?>">
                </div>
                <div class="col-lg-2 action" style="padding: 18px;">
                    <button type="submit" data-kt-translate-action="save_row" class="btn btnSaveTranslate btn-icon btn-success btn-circle mr-2"><i class="fas fa-check"></i></button>
                    <button type="button" data-delete="<?= $k; ?>" data-kt-translate-action="delete_row" class="btn btnDeleteTranslate danger btn-icon btn-danger btn-circle mr-2"><i class="icon-2x text-dark-50 fas fa-trash-alt"></i></button>
                </div>
            </div>
        <?php } ?>
        <div id="kt_repeater_1">
            <div data-repeater-list="">
                <div data-repeater-item class="form-group row">

                    <div class="col-lg-5">
                        <label><?= lang('Core.label_texte'); ?>: </label>
                        <input type="text" class="form-control" placeholder="<?= lang('Core.enter_texte'); ?>" name="texte" value="">
                    </div>
                    <div class="col-lg-5">
                        <label><?= lang('Core.label_value'); ?>: </label>
                        <input type="text" class="form-control" placeholder="<?= lang('Core.enter_value'); ?>" name="value" value="">
                    </div>
                    <div class="col-lg-2 action" style="padding: 18px;">
                        <button type="submit" data-kt-translate-action="save_row" class="btn btnSaveTranslate btn btn-icon btn-success btn-circle mr-2"><i class="fas fa-check"></i></button>
                        <button type="button" data-kt-translate-action="delete_row" class="btn btnDeleteTranslate danger btn-icon btn-danger btn-circle mr-2"><i class="icon-2x text-dark-50 fas fa-trash-alt"></i></button>
                    </div>


                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-2 col-form-label"></label>
                <div class="col-lg-4">
                    <a href="javascript:;" data-repeater-create="" class="btn btn-bold btn-sm btn-light-primary">
                        <i class="la la-plus"></i> <?= lang('Core.add'); ?>
                    </a>
                </div>
            </div>
        </div>
        <input type="hidden" value="<?= $file; ?>" name="file" id="fileTranslate" />
        <input type="hidden" value="<?= (!empty($lang)) ? $lang : service('request')->getLocale(); ?>" name="lang" />
        <?= form_close(); ?>
    </div>
</div>