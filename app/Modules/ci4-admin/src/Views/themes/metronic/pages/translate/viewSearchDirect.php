<?php
helper('form');

?>
<div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobile ">
    <div class="kt-portlet__head kt-portlet__head--lg kt-portlet__head--noborder kt-portlet__head--break-sm">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                <?= lang('Core.resultats'); ?> : <?= count($searchTextLang); ?>
            </h3>
        </div>
    </div>

    <div class="kt-portlet__body">
        <?php foreach ($searchTextLang as $v) { ?>
            <?= form_open('', ['id' => 'save_translate', 'class' => 'kt-form saveText_translate', 'novalidate' => false]); ?>
            <div class="form-group row">
                <div class="col-lg-4">
                    <label><?= lang('Core.label_texte'); ?>: </label>
                    <input disabled type="text" class="form-control" placeholder="<?= lang('Core.enter_texte'); ?>" value="<?= $v['info_key']; ?>">
                   
                </div>
                <div class="col-lg-4">
                    <label><?= lang('Core.label_value'); ?>: </label>
                    <input type="text" class="form-control" placeholder="<?= lang('Core.enter_value'); ?>" name="<?= $v['info_key']; ?>" value="<?= $v['info_name']; ?>">
                </div>
                <div class="col-lg-4 action" style="padding: 18px;">
                    <input type="hidden" value="<?= $v['info_bundlename']; ?>" name="file" />
                    <input type="hidden" value="<?= $v['info_lang']; ?>" name="lang" />
                    <button type="submit" data-kt-translate-action="save_row" class="btn btnSaveTranslate btn btn-icon btn-success btn-circle mr-2"><i class="fas fa-check"></i></button>
                </div>
            </div>
            <?= form_close(); ?>
            <span class="btn btn-label-primary btn-pill btn-sm" style="margin-top:5px;">Fichier : <?= $v['info_interface']; ?></span>
        <?php } ?>

    </div>
</div>