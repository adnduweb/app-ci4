<div class="card-header pt-8">
    <div class="card-title">
        <!--begin::Search-->
        <div class="d-flex align-items-center position-relative my-1">
            <?= service('theme')->getSVG('duotune/general/gen021.svg', "svg-icon svg-icon-1 position-absolute ms-6"); ?>
            <input type="text" data-kt-filemanager-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Files &amp; Folders">
        </div>
        <!--end::Search-->
    </div>
    <!--begin::Card toolbar-->
    <div class="card-toolbar">
        <!--begin::Toolbar-->
        <div class="d-flex justify-content-end" data-kt-filemanager-table-toolbar="base">
            <!--begin::Add customer-->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_upload">
                <?= service('theme')->getSVG('duotune/files/fil018.svg', "svg-icon svg-icon-2"); ?>
                <span>Upload Files</span>
            </button>
            <!--end::Add customer-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Group actions-->
        <div class="d-flex justify-content-end align-items-center d-none" data-kt-filemanager-table-toolbar="selected">
            <div class="fw-bolder me-5">
            <span class="me-2" data-kt-filemanager-table-select="selected_count"></span>Selected</div>
            <button type="button" class="btn btn-danger" data-kt-filemanager-table-select="delete_selected">Delete Selected</button>
        </div>
        <!--end::Group actions-->
    </div>
    <!--end::Card toolbar-->
</div>