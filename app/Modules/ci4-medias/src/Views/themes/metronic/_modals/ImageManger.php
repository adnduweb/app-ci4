<div class="modal fade" id="kt_modal_image_manager" data-kt-filemanager-modal="template" tabindex="-1" role="dialog" aria-labelledby="kt_modal_image_managerLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dropzoneModalTitle">Image manager</h5>
               <!--begin::Close-->
               <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body">
                <!--begin::Input group-->
                <div class="fv-row mb-2">

               <!--begin::Dropzone-->
               <div class="dropzone mb-5" id="kt_modal_upload_dropzone_modal">
                    <!--begin::Message-->
                    <div class="dz-message needsclick">
                        <!--begin::Icon-->
                        <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                        <!--end::Icon-->
                        <!--begin::Info-->
                        <div class="ms-4">
                            <h3 class="fs-5 fw-bolder text-gray-900 mb-1">Drop files here or click to upload.</h3>
                            <span class="fs-7 fw-bold text-gray-400">Upload up to 10 files</span>
                        </div>
                        <!--end::Info-->
                    </div>
                </div>
                <!--end::Dropzone-->

                <div id="list-media-container" class="py-5 mb-10"></div>
                </div>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" disabled="disabled" kt-filemanager-modal="inserer">Insérer</button>
            </div>
        </div>
    </div>
</div>