<!--begin::Search-->
<div
    id="kt_header_search"
    class="d-flex align-items-stretch"

    data-kt-search-keypress="true"
    data-kt-search-min-length="2"
    data-kt-search-enter="enter"
    data-kt-search-layout="menu"

    data-kt-menu-trigger="auto"
    data-kt-menu-overflow="false"
    data-kt-menu-permanent="true"
    data-kt-menu-placement="bottom-end"
    data-kt-menu-flip="bottom">

    <!--begin::Search toggle-->
    <div class="d-flex align-items-center" data-kt-search-element="toggle" id="kt_header_search_toggle">
        <div class="btn btn-icon btn-active-light-primary">
            <?= service('theme')->getSVG("icons/duotone/General/Search.svg", "svg-icon-1"); ?>
        </div>
    </div>
    <!--end::Search toggle-->

    <!--begin::Menu-->
    <div data-kt-search-element="content" class="menu menu-sub menu-sub-dropdown p-7 w-325px w-md-375px">
        <!--begin::Wrapper-->
        <div data-kt-search-element="wrapper">
            <?= $this->include('\Themes\backend\/'.$theme_admin.'/\search\partials\_form'); ?>

            <?= ''; // $this->include('\Themes\backend\/'.$theme_admin.'/\search\partials\_results'); ?>

            <?= ''; // $this->include('\Themes\backend\/'.$theme_admin.'/\search\partials\_main'); ?>

            <?= ''; // $this->include('\Themes\backend\/'.$theme_admin.'/\search\partials\_empty'); ?>
        </div>
        <!--end::Wrapper-->

        <?= $this->include('\Themes\backend\/'.$theme_admin.'/\search\partials\_advanced-options'); ?>

        <?= $this->include('\Themes\backend\/'.$theme_admin.'/\search\partials\_preferences'); ?>
    </div>
    <!--end::Menu-->
</div>
<!--end::Search-->
