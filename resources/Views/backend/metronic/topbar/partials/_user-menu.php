<!--begin::Menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <div class="menu-content d-flex align-items-center px-3">
            <!--begin::Avatar-->
            <div class="symbol symbol-50px me-5">
                <img alt="Logo" src="<?= assetAdmin('/media/avatars/150-2.jpg'); ?>"/>
            </div>
            <!--end::Avatar-->

            <!--begin::Username-->
            <div class="d-flex flex-column">
                <div class="fw-bolder d-flex align-items-center fs-5">
                <?= user()->firstname; ?> <?= user()->lastname; ?>
                    <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">Pro</span>
                </div>
                <a href="#" class="fw-bold text-muted text-hover-primary fs-7"><?= user()->email; ?></a>
            </div>
            <!--end::Username-->
        </div>
    </div>
    <!--end::Menu item-->

    <!--begin::Menu separator-->
    <div class="separator my-2"></div>
    <!--end::Menu separator-->

    <!--begin::Menu item-->
    <div class="menu-item px-5">
        <a href="<?= route_to('user-edit', user()->uuid); ?>" class="menu-link px-5">
            <?= ucfirst(lang('Core.My Profile')); ?>
        </a>
    </div>
    <!--end::Menu item-->
    <?php if(user()->isSuperHero() == true || user()->isSuperCaptain() == true) { ?>
      <!--begin::Menu item-->
    <div class="menu-item px-5 my-1">
        <!-- <a href="<?= route_to('en-tant-que'); ?>" class="menu-link px-5"> -->
        <a href="#" class="menu-link px-5" data-bs-toggle="modal" data-bs-target="#kt_modal_customer_search">
            <?= lang('Core.connexion_en_tant_que'); ?>
        </a>
    </div>
    <!--end::Menu item-->
    <?php } ?>

    <!--begin::Menu separator-->
    <div class="separator my-2"></div>
    <!--end::Menu separator-->

    <!--begin::Menu item-->
    <div class="menu-item px-5" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start" data-kt-menu-flip="center, top">
        <a href="#" class="menu-link px-5">
            <span class="menu-title position-relative">
                <?= ucfirst(lang('Core.language')); ?>

                <span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">
                <?= ucfirst(lang($supportedLocales[service('request')->getLocale()]['name'])); ?> <img class="w-15px h-15px rounded-1 ms-2" src="<?= assetAdmin($supportedLocales[service('request')->getLocale()]['flag']); ?>" alt="metronic"/>
                </span>
            </span>
        </a>

        <!--begin::Menu sub-->
        <div class="menu-sub menu-sub-dropdown w-175px py-4">

        <?php foreach($supportedLocales as $lang){ ?>
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="<?= route_to('settings-update-user') ; ?>?changeLanguageBO=<?=$lang['iso_code']; ?>" class="menu-link d-flex px-5 <?= ($lang['iso_code'] == service('request')->getLocale() ) ? 'active' : ''; ?>">
                    <span class="symbol symbol-20px me-4">
                        <img class="rounded-1" src="<?= assetAdmin($lang['flag']); ?>" alt="metronic"/>
                    </span>
                    <?= ucfirst(lang($lang['name'])); ?>
                </a>
            </div>
            <!--end::Menu item-->
        <?php } ?>
        </div>
        <!--end::Menu sub-->
    </div>
    <!--end::Menu item-->

    <!--begin::Menu item-->
    <div class="menu-item px-5 my-1">
        <a href="<?= route_to('settings-index'); ?>" class="menu-link px-5">
            <?= ucfirst(lang('Core.settings')); ?>
        </a>
    </div>
    <!--end::Menu item-->

    <!--begin::Menu item-->
    <div class="menu-item px-5">
        <a href="<?= site_url(CI_AREA_ADMIN . '/logout'); ?>" data-action="<?= site_url(CI_AREA_ADMIN . '/logout'); ?>" data-method="post" data-csrf="<?= csrf_hash(); ?>" data-reload="true" class="button-ajax menu-link px-5">
            <?= ucfirst(lang('Core.Sign Out')); ?> 
        </a>
    </div>
    <!--end::Menu item-->
</div>
<!--end::Menu-->
