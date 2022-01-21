<div class="topbar">

    <?php if (Config('Theme')->layout['extras']['search']['display']){ ?>
        <?php if (Config('Theme')->layout['extras']['search']['layout'] == 'offcanvas' ){ ?>
            <div class="topbar-item">
                <div class="btn btn-icon btn-clean btn-lg mr-1" id="kt_quick_search_toggle">
                    <?= service('theme')->getSVG('svg/icons/General/Search.svg', 'svg-icon-xl svg-icon-primary'); ?>
                </div>
            </div>
        <?php }else{ ?>
            <div class="dropdown" id="kt_quick_search_toggle">
                <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                    <div class="btn btn-icon btn-clean btn-lg btn-dropdown mr-1">
                       <?= service('theme')->getSVG('svg/icons/General/Search.svg', 'svg-icon-xl svg-icon-primary'); ?>
                    </div>
                </div>

          
                <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
                    <?= $this->include('\Themes\backend\/'.$theme_admin.'/\partials\extras\dropdown\_search-dropdown') ?>
                </div>
            </div>
        <?php } ?>
    <?php } ?>


    <?php if (Config('Theme')->layout['extras']['notifications']['display']){ ?>
         <?php if (Config('Theme')->layout['extras']['notifications']['layout'] == 'offcanvas' ){ ?>
            <div class="topbar-item">
                <div class="btn btn-icon btn-clean btn-lg mr-1 pulse pulse-primary" id="kt_quick_notifications_toggle">
                    <?= service('theme')->getSVG('svg/icons/General/Search.svg', 'svg-icon-xl svg-icon-primary'); ?>
                    <span class="pulse-ring"></span>
                </div>
            </div>
        <?php }else{ ?>
            <div class="dropdown">
                <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                    <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse pulse-primary">
                        <?= service('theme')->getSVG('svg/icons/Code/Compiling.svg', 'svg-icon-xl svg-icon-primary'); ?>
                        <span class="pulse-ring"></span>
                    </div>
                </div>

                <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
                    <form>
                        <?= $this->include('\Themes\backend\/'.$theme_admin.'/\partials\extras\dropdown\_notifications') ?>
                    </form>
                </div>
            </div>
        <?php } ?>
    <?php } ?>

    <?php if (Config('Theme')->layout['extras']['quick-actions']['display']){ ?>
        <?php if (Config('Theme')->layout['extras']['quick-actions']['layout'] == 'offcanvas' ){ ?>
            <div class="topbar-item">
                <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1" id="kt_quick_actions_toggle">
                    <?= service('theme')->getSVG('svg/icons/Media/Equalizer.svg', 'svg-icon-xl svg-icon-primary'); ?>
                </div>
            </div>
        <?php }else{ ?>
            <div class="dropdown">
                <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                    <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1">
                        <?= service('theme')->getSVG('svg/icons/Media/Equalizer.svg', 'svg-icon-xl svg-icon-primary'); ?>
                    </div>
                </div>

                <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
                    <?= $this->include('\Themes\backend\/'.$theme_admin.'/\partials\extras\dropdown\_quick-actions') ?>
                </div>
            </div>
        <?php } ?>
    <?php } ?>


    <?php if (Config('Theme')->layout['extras']['cart']['display']){ ?>
        <div class="dropdown">
            <div class="topbar-item"  data-toggle="dropdown" data-offset="10px,0px">
                <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1">
                    <?= service('theme')->getSVG('svg/icons/Shopping/Cart3.svg', 'svg-icon-xl svg-icon-primary'); ?>
                </div>
            </div>

            <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-xl dropdown-menu-anim-up">
                <form>
                    <?= $this->include('\Themes\backend\/'.$theme_admin.'/\partials\extras\dropdown\_cart') ?>
                </form>
            </div>
        </div>
    <?php } ?>


    <?php if (Config('Theme')->layout['header']['topbar']['quick-panel']['display']){ ?>
        <div class="topbar-item">
            <div class="btn btn-icon btn-clean btn-lg mr-1" id="kt_quick_panel_toggle">
                <?= service('theme')->getSVG('svg/icons/Layout/Layout-4-blocks.svg', 'svg-icon-xl svg-icon-primary'); ?>
            </div>
        </div>
    <?php } ?>

    <?php if (Config('Theme')->layout['extras']['languages']['display']){ ?>
        <div class="dropdown">
            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1">
                    <img class="h-20px w-20px rounded-sm" src="<?= assetAdmin('/media/svg/flags/226-united-states.svg'); ?>" alt=""/>
                </div>
            </div>

            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                <?= $this->include('\Themes\backend\/'.$theme_admin.'/\partials\extras\dropdown\_languages') ?>
            </div>
        </div>
    <?php } ?>


    <?php if (Config('Theme')->layout['extras']['user']['display']){ ?>
        <?php if (Config('Theme')->layout['extras']['user']['layout'] == 'offcanvas' ){ ?>
            <div class="topbar-item">
                <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                    <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
                    <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">Sean</span>
                    <span class="symbol symbol-35 symbol-light-success">
                        <span class="symbol-label font-size-h5 font-weight-bold">S</span>
                    </span>
                </div>
            </div>
        <?php }else{ ?>
            <div class="dropdown">
                
                <div class="topbar-item" data-toggle="dropdown" data-offset="0px,0px">
                    <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2">
                        <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
                        <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">Sean</span>
                        <span class="symbol symbol-35 symbol-light-success">
                            <span class="symbol-label font-size-h5 font-weight-bold">S</span>
                        </span>
                    </div>
                </div>

                <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg p-0">
                    <?= $this->include('\Themes\backend\/'.$theme_admin.'/\partials\extras\dropdown\_user') ?>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>
