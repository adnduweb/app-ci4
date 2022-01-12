<?php use \Adnduweb\Ci4Admin\Libraries\Theme; ?>

<div class="subheader py-2<?= Theme::printHtmlClasses('subheader', false); ?>" id="kt_subheader">
    <div class="<?= Theme::printHtmlClasses('subheader-container', false); ?> d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">

        <div class="d-flex align-items-center flex-wrap mr-1 right">

            <h5 class="text-dark font-weight-bold my-2 mr-5">

               <?php if (isset($controller) &&  Config('Theme')->layout['subheader']['displayDesc']){ ?>
                    <small><?= $controller; ?></small>
                <?php } ?>
            </h5>

            <?php if(!empty($page_breadcrumbs)){ ?>
                <div class="subheader-separator subheader-separator-ver my-2 mr-4 d-none"></div>

                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2">
                    <li class="breadcrumb-item"><a href="#"><i class="flaticon2-shelter text-muted icon-1x"></i></a></li>
                    <?php foreach ($page_breadcrumbs as $k => $item){ ?>
						<li class="breadcrumb-item">
                        	<a href="<?php base_url($item['page']); ?>" class="text-muted">
                            	<?= $item['title']; ?>
                        	</a>
						</li>
                    <?php } ?>
                </ul>
            <?php } ?>

            <?php if (isset($countList)) { ?>
                <span class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></span>
                <div class="d-flex align-items-center" id="kt_subheader_search">
                    <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">
                        <span class="kt_subheader_total"><?= count($countList); ?></span> <?= lang('Core.total'); ?> </span>
                    <form class="ml-5">
                        <div class="input-group input-group-sm input-group-solid" style="max-width: 175px">
                            <input type="text" class="form-control" placeholder="<?= lang('Core.search'); ?>" id="kt_subheader_search_form">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <?= Theme::getSVG('media/svg/icons/General/Search.svg', 'svg-icon svg-icon-sm', true); ?> 
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="kt-subheader__group hidden" id="kt_subheader_group_actions">
                    <div class="kt-subheader__desc"><span id="kt_subheader_group_selected_rows"></span> <?= lang('Core.elements_selected'); ?>:</div>
                    <div class="btn-toolbar kt-margin-l-20">

                        <?php if ($toolbarUpdate == true) { ?>
                            <div class="dropdown m-2" id="kt_subheader_group_actions_status_change">
                                <button type="button" class="btn btn-light-dark font-weight-bolder btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <?= lang('Core.status_update'); ?>
                                </button>
                                <div class="dropdown-menu">
                                    <ul class="navi">
                                        <li class="navi-header">
                                            <span class="navi-section-text"><?= lang('Core.change_status_to'); ?>:</span>
                                        </li>
                                        <li class="navi-separator mb-3"></li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link" data-toggle="status-change" data-status="1">
                                                <span class="navi-link-text" data-status="1"><span class="kt-badge kt-badge--unified-success kt-badge--inline kt-badge--bold"><?= lang('Core.active'); ?></span></span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link" data-toggle="status-change" data-status="0">
                                                <span class="navi-link-text" data-status="0"><span class="kt-badge kt-badge--unified-danger kt-badge--inline kt-badge--bold"><?= lang('Core.desactive'); ?></span></span>
                                            </a>
                                        </li>
                                        <?php if ($changeCategorie == true) { ?>
                                            <li class="navi-item">
                                                <a href="#" class="navi-link" data-toggle="status-change" data-status="0">
                                                    <span class="navi-link-text" data-status="!1" data-categorie="true">
                                                        <span class="kt-badge kt-badge--unified-dark kt-badge--inline kt-badge--bold"><?= lang('Core.change_categorie'); ?></span>
                                                    </span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (ENVIRONMENT != 'developement') { ?>
                            <button class="btn btn-light-success font-weight-bolder btn-sm m-2" id="kt_subheader_group_actions_fetch" data-toggle="modal" data-target="#kt_datatable_records_fetch_modal">
                                <?= lang('Core.list_selectionne'); ?>
                            </button>
                        <?php } ?>
                        <button class="btn btn-light-danger font-weight-bolder btn-sm m-2" id="kt_subheader_group_actions_delete_all">
                            <?= lang('Core.delete_all'); ?>
                        </button>
                    </div>
                </div>
            <?php }  ?>

        </div>

        <div class="d-flex align-items-center left">
            <?php if (isset($multilangue_list)) { ?>
                <?php if (service('Settings')->setting_activer_multilangue == true) { ?>
                    <?php $setting_supportedLocales = unserialize(service('Settings')->setting_supportedLocales); ?>
                    <div class="lang_tabs" data-dft-lang="<?= service('Settings')->setting_lang_iso; ?>" style="display: block;">

                        <?php foreach ($setting_supportedLocales as $k => $v) {
                            $langExplode = explode('|', $v); ?>
                            <a href="javascript:;" data-lang="<?= $langExplode[1]; ?>" data-id_lang="<?= $langExplode[0]; ?>" class="btn <?= (service('Settings')->setting_id_lang == $langExplode[0]) ? 'active'  : ''; ?> lang_tab btn-outline-brand"><?= ucfirst($langExplode[1]); ?></a>
                        <?php   } ?>
                    </div>
                <?php   } ?>
            <?php } ?>
            <?php if ($multilangue == true) { ?>
                <?php if (service('Settings')->setting_activer_multilangue == true) { ?>
                    <?php $setting_supportedLocales = json_decode(service('Settings')->setting_supportedLocales); ?>
                    <div class="lang_tabs" data-dft-lang="<?= service('Settings')->setting_lang_iso; ?>" style="display: inline-block;">

                        <?php foreach ($setting_supportedLocales as $k => $v) {
                            $langExplode = explode('|', $v); ?>
                            <a href="javascript:;" data-lang="<?= $langExplode[1]; ?>" data-id_lang="<?= $langExplode[0]; ?>" class="btn btn-xs <?= (service('Settings')->setting_id_lang == $langExplode[0]) ? 'active'  : ''; ?> lang_tab btn-outline-brand"><?= ucfirst($langExplode[1]); ?></a>
                        <?php   } ?>
                    </div>
                <?php   } ?>
            <?php   } ?>
            <?php if (isset($toolbarBack) && $toolbarBack == true) { ?>
                <a href="/<?= env('app.areaAdmin'); ?>/<?= $backPathController; ?>" class="btn btn-default font-weight-bolder btn-sm mr-2">
                    <?= ucfirst(lang('Core.back')); ?>
                </a>
            <?php } ?>

            <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="submit" name="submithandler" value="save_continue" class="btn btn-light-primary font-weight-bolder btn-sm kt_form_submit kt_form_submit_<?= strtolower($controller); ?>">
                    <?= ucfirst(lang('Core.saves_changes')); ?>
                </button>
                <button type="button" class="btn btn-light-primary font-weight-bolder btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <!-- <button type="submit" name="submithandler" value="save_continue" class="link dropdown-item kt_form_submit kt_form_submit_<?= strtolower($controller); ?>">
                        <i class="kt-nav__link-icon flaticon2-writing"></i> -->
                        <?= ucfirst(lang('Core.save_continue')); ?>
                    </button>
                    <button type="submit" name="submithandler" value="save_and_new" class="link dropdown-item kt_form_submit kt_form_submit_<?= strtolower($controller); ?>">
                        <!-- <i class="kt-nav__link-icon flaticon2-medical-records"></i> -->
                        <?= ucfirst(lang('Core.save_and_new')); ?>
                    </button>
                    <button type="submit" name="submithandler" value="save_and_exit" class="link dropdown-item kt_form_submit kt_form_submit_<?= strtolower($controller); ?>">
                        <!-- <i class="kt-nav__link-icon flaticon2-hourglass-1"></i> -->
                        <?= ucfirst(lang('Core.save_and_exit')); ?>
                    </button>
                </div>
            </div>

        </div>

    </div>
</div>
