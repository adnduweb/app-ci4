<div class="card-title">
    <!--begin::Search-->
    <div class="d-flex align-items-center position-relative my-1">

        <?= service('theme')->getSVG('duotone/General/Search.svg', "svg-icon svg-icon-1 position-absolute ms-6"); ?>

        <input type="text" data-kt-<?= singular($controller); ?>-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="<?= lang('Core.search'); ?>" />
    </div>
    <!--end::Search-->
</div>