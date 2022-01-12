<!--begin::Rename template-->
<div class="d-none" data-kt-filemanager-template="rename">
    <div class="fv-row">
        <div class="d-flex align-items-center justify-content-between">
            <span id="kt_file_manager_rename_folder_img"></span>
            <div>
                <input type="text" id="kt_file_manager_rename_input" name="rename_folder_name" placeholder="Enter the new folder name" class="form-control mw-250px me-3" value="" />
                <span id="kt_file_manager_rename_folder_link"></span>
            </div>
            <button class="btn btn-icon btn-light-primary me-3" id="kt_file_manager_rename_folder">
                <?= service('theme')->getSVG('duotune/arrows/arr085.svg', "svg-icon svg-icon-1"); ?>
            </button>
            <button class="btn btn-icon btn-light-danger" id="kt_file_manager_rename_folder_cancel">
                <span class="indicator-label">
                    <?= service('theme')->getSVG('duotune/arrows/arr088.svg', "svg-icon svg-icon-1"); ?>
                </span>
                <span class="indicator-progress">
                    <span class="spinner-border spinner-border-sm align-middle"></span>
                </span>
            </button>
        </div>
    </div>
</div>
<!--end::Rename template-->