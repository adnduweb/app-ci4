<?= $this->extend('Themes\backend\metronic\admin') ?>
<?= $this->section('main') ?>


    <?= view('Adnduweb\Ci4Medias\Views\themes\metronic\_partials\cartd_top', ['medias' => $medias, 'active' => $active]) ?>

    <div class="card card-flush">


            <!--begin::Card-->
            <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-8">
                <!--begin::Card title-->
                <div class="card-title">
                    <h2>Preferences</h2>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Form-->
                <?= form_open('', ['id' => 'kt_file_manager_settings', 'class' => 'kt-form', 'novalidate' => false]); ?>
                    <!--begin::Input group-->
                    <div class="fv-row row mb-15">
                        <!--begin::Col-->
                        <div class="col-md-3 d-flex align-items-center">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold">Format vignette</label>
                            <!--end::Label-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-9">
                            <input class="form-control form-control-solid" required="" type="text" value="<?= old('thumbnail') ? old('thumbnail') : service('settings')->get('Medias.format', 'thumbnail'); ?>" name="format[thumbnail]" id="thumbnail-format">
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row row mb-15">
                        <!--begin::Col-->
                        <div class="col-md-3 d-flex align-items-center">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold">Format small</label>
                            <!--end::Label-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-9">
                            <input class="form-control form-control-solid" required="" type="text" value="<?= old('small') ? old('small') : service('settings')->get('Medias.format', 'small'); ?>" name="format[small]" id="small-format">
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                     <div class="fv-row row mb-15">
                        <!--begin::Col-->
                        <div class="col-md-3 d-flex align-items-center">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold">Format medium</label>
                            <!--end::Label-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-9">
                            <input class="form-control form-control-solid" required="" type="text" value="<?= old('medium') ? old('medium') : service('settings')->get('Medias.format', 'medium'); ?>" name="format[medium]" id="medium-format">
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                     <!--begin::Input group-->
                     <div class="fv-row row mb-15">
                        <!--begin::Col-->
                        <div class="col-md-3 d-flex align-items-center">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold">Format large</label>
                            <!--end::Label-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-9">
                            <input class="form-control form-control-solid" required="" type="text" value="<?= old('large') ? old('large') : service('settings')->get('Medias.format', 'large'); ?>" name="format[large]" id="large-format">
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <div class="fv-row row mb-15">
                        <div class="d-flex justify-content-between">
                            <div class="col-md-3 d-flex align-items-center">
                                <label class="fs-6 fw-bold">activer le Watermark</label>
                            </div>
                        
                            <div class="col-md-9">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input w-30px h-20px" type="checkbox"  name="format[watermark]" <?= (service('settings')->get('Medias.format', 'watermark') == 1) ? 'checked' : '' ?> value="1">
                                    <label class="form-check-label" for="flexCheckDefault"></label>
                                </div>
                            </div>
                        </div>
                    </div>

                     <!--begin::Input group-->
                     <div class="fv-row row mb-15">
                        <!--begin::Col-->
                        <div class="col-md-3 d-flex align-items-center">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold"> Texte Watermark</label>
                            <!--end::Label-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-9">
                            <input class="form-control form-control-solid" type="text" value="<?= old('text_watermark') ? old('text_watermark') : service('settings')->get('Medias.format', 'text_watermark'); ?>" name="format[text_watermark]" id="text_watermark-format">
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row row mb-15">
                        <div class="d-flex justify-content-between">
                            <div class="col-md-3 d-flex align-items-center">
                                <label class="fs-6 fw-bold">Supprimer les fichiers</label>
                            </div>
                        
                            <div class="col-md-9">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input w-30px h-20px" type="checkbox"  name="delete_files" value="1">
                                    <label class="form-check-label" for="flexCheckDefault"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                     <!--end::Input group-->

                     <?php if (!is_writable(ROOTPATH . 'writable/medias/')){ ?>
                        <div class="d-flex align-items-sm-center mb-7">
                            <!--begin::Title-->
                            <div class="d-flex flex-row-fluid flex-wrap align-items-center">
                                <div class="flex-grow-1 me-2">
                                    <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6"> medias not writable:</a>
                                </div>
                                <span class="badge badge-light-success fs-8 fw-bolder my-2"><?= ROOTPATH . 'writable/medias/'; ?></span>
                            </div>
                            <!--end::Title-->
                        </div>
                    <?php  } ?>

                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="reset" class="btn btn-white btn-active-light-primary me-2"> <?= ucfirst(lang('Core.cancel')); ?></button>
                        <button type="submit"  id="btnGroupDrop1" type="submit" name="submithandler" value="save_continue" class="btn btn-light-primary font-weight-bolder btn-sm kt_form_submit kt_form_submit_<?= strtolower($controller); ?>"> <?= ucfirst(lang('Core.saves_changes')); ?></button>
                    </div>
                <?= form_close(); ?>
                <!--end::Form-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->

      


    </div>


<?= $this->endSection() ?>

<?= $this->section('AdminAfterExtraJs') ?>


<?= $this->endSection() ?>