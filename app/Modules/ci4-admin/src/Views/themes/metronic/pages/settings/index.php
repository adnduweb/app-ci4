<?= $this->extend('\Themes\backend\metronic\admin') ?>
<?= $this->section('main') ?>

<?= form_open('', ['id' => 'kt_apps_user_add_user_form', 'class' => 'kt-form', 'novalidate' => false]); ?>
<input type="hidden" name="action" value="edit" />
<input type="hidden" name="controller" value="AdminSettingController" />
    <div class="card mb-5 mb-xxl-8">
        <div class="card-body pb-0">
            <!--begin::Navs-->
            <div class="py-2">
                <div class="rounded ">
                    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6 mb-20">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="<?= base_url(uri_string()); ?>#kt_tab_pane_1">
                                <?= service('theme')->getSVG('icons/duotone/Design/Layers.svg', 'svg-icon svg-icon-sm', true); ?> 
                                <?= ucfirst(lang('Core.tab_general')); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="<?= base_url(uri_string()); ?>#kt_tab_pane_2">
                                <?= service('theme')->getSVG('icons/duotone/Communication/Mail-opened.svg', 'svg-icon svg-icon-sm', true); ?> 
                                <?= ucfirst(lang('Core.tab_security')); ?>
                            </a>
                        </li>
                        <?php if(class_exists('\Adnduweb\Ci4Web\Web')){ ?>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="<?= base_url(uri_string()); ?>#kt_tab_pane_3">
                                <?= service('theme')->getSVG('icons/duotone/Communication/Mail-opened.svg', 'svg-icon svg-icon-sm', true); ?> 
                                <?= ucfirst(lang('Core.tab_front')); ?>
                            </a>
                        </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="<?= base_url(uri_string()); ?>#kt_tab_pane_4">
                                <?= service('theme')->getSVG('icons/duotone/Communication/Mail-opened.svg', 'svg-icon svg-icon-sm', true); ?> 
                                <?= ucfirst(lang('Core.tab_analitycs_rgpd')); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="<?= base_url(uri_string()); ?>#kt_tab_pane_5">
                                <?= service('theme')->getSVG('icons/duotone/Communication/Mail-opened.svg', 'svg-icon svg-icon-sm', true); ?> 
                                <?= ucfirst(lang('Core.tab_email')); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="<?= base_url(uri_string()); ?>#kt_tab_pane_6">
                                <?= service('theme')->getSVG('icons/duotone/Communication/Mail-opened.svg', 'svg-icon svg-icon-sm', true); ?> 
                                <?= ucfirst(lang('Core.tab_language')); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="<?= base_url(uri_string()); ?>#kt_tab_pane_7">
                                <?= service('theme')->getSVG('icons/duotone/Communication/Mail-opened.svg', 'svg-icon svg-icon-sm', true); ?> 
                                <?= ucfirst(lang('Core.tab_image')); ?>
                            </a>
                        </li>
                        <?php if(class_exists('\Adnduweb\Ci4Ecommerce\Shopping')){ ?>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="<?= base_url(uri_string()); ?>#kt_tab_pane_8">
                                <?= service('theme')->getSVG('icons/duotone/Communication/Mail-opened.svg', 'svg-icon svg-icon-sm', true); ?> 
                                <?= ucfirst(lang('Core.tab_ecommerce')); ?>
                            </a>
                        </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="<?= base_url(uri_string()); ?>#kt_tab_pane_9">
                                <?= service('theme')->getSVG('icons/duotone/Communication/Mail-opened.svg', 'svg-icon svg-icon-sm', true); ?> 
                                <?= ucfirst(lang('Core.tab_command')); ?>
                            </a>
                        </li>

                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="kt_tab_pane_1" role="tabpanel">
                            <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\settings\__form_section\general') ?>
                        </div>
                        <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                            <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\settings\__form_section\security') ?>
                        </div>
 

                        
                    </div>
                </div>
            </div>

            <!--begin::Navs-->
        </div>
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <button type="reset" class="btn btn-white btn-active-light-primary me-2"> <?= ucfirst(lang('Core.cancel')); ?></button>
            <button type="submit"  id="btnGroupDrop1" type="submit" name="submithandler" value="save_continue" class="btn btn-light-primary font-weight-bolder btn-sm kt_form_submit kt_form_submit_<?= strtolower($controller); ?>"> <?= ucfirst(lang('Core.saves_changes')); ?></button>
        </div>
    </div>
<?= form_close(); ?>

<?= $this->endSection() ?>
<?= $this->section('AdminAfterExtraJs') ?>

<script type="text/javascript">

    function addRemoteAddr() {
        var length = $('input#setting_maintenance_ip_restrict').attr('value').length;
        if (length > 0)
            $('input#setting_maintenance_ip_restrict').attr('value', $('input#setting_maintenance_ip_restrict').attr('value') + ';<?= service('request')->getIPAddress(); ?>');
        else
            $('input#setting_maintenance_ip_restrict').attr('value', '<?= service('request')->getIPAddress(); ?>');
    }

</script>
<?= $this->endSection() ?>