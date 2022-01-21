<div class="d-flex align-items-center ms-1 ms-lg-3">
    <!--begin::Menu toggle-->
    <a href="#" class="btn btn-icon btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
        <i class="la la-sun fs-2  <?= service('settings')->get('App.theme_bo', 'modeDark') == 1 ? 'd-none' : '' ; ?>"></i>
        <i class="la la-moon fs-2 <?= service('settings')->get('App.theme_bo', 'modeDark') == 1 ? '' : 'd-none' ; ?>"></i>
    </a>
    <!--begin::Menu toggle-->
    <!--begin::Menu-->
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-primary fw-bold py-4 fs-6 w-200px" data-kt-menu="true" style="">
        <!--begin::Menu item-->
        <div class="menu-item px-3 my-1">
            <a href="<?= route_to('settings-update-user') ; ?>?darkModeEnabled=false" class="menu-link px-3 active">
                <span class="menu-icon">
                    <i class="la la-sun fs-2"></i>
                </span>
                <span class="menu-title">Light</span>
            </a>
        </div>
        <!--end::Menu item-->
        <!--begin::Menu item-->
        <div class="menu-item px-3 my-1">
            <a href="<?= route_to('settings-update-user') ; ?>?darkModeEnabled=true" class="menu-link px-3">
                <span class="menu-icon">
                    <i class="la la-moon fs-2"></i>
                </span>
                <span class="menu-title">Dark</span>
            </a>
        </div>
        <!--end::Menu item-->
    </div>
    <!--end::Menu-->
</div>