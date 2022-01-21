<!--begin::Export-->
<button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_import_datatable">
    <?= service('theme')->getSVG('duotone/Files/Import.svg', "svg-icon svg-icon-2"); ?>
    <?= lang('Core.import'); ?>
</button>
<!--end::Export-->

<!--begin::Modal - Adjust Balance-->
<div class="modal fade" id="kt_modal_import_datatable" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder"><?= lang('Core.Importer: %s', [singular($controller)]); ?></h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <?= service('theme')->getSVG('duotone/Navigation/Close.svg', "svg-icon svg-icon-1 position-absolute ms-6"); ?>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">

                <div class="dropzone dropzone-default" id="kt_dropzone_1" data-accept="application/x-csv">
                    <div class="dropzone-msg dz-message needsclick">
                        <h3 class="dropzone-msg-title">Drop files here or click to upload.</h3>
                        <span class="dropzone-msg-desc">This is just a demo dropzone. Selected files are 
                        <strong>not</strong>actually uploaded.</span>
                    </div>
                </div>
                                                    
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - New Card-->

<?= $this->section('AdminAfterExtraJs') ?>

<script type="text/javascript">

"use strict";
// Class definition

var KTDropzoneDemo = function () {
    // Private functions
    var demo1 = function () {

        const element = document.getElementById('kt_modal_import_datatable');
        const modal = new bootstrap.Modal(element);

        // single file upload
        $('#kt_dropzone_1').dropzone({
            url: "<?= route_to(singular($controller) . '-import-ajax') ?>", // Set the url for your upload script location
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            method: 'POST',
            paramName: "file", // The name that will be used to transfer the file
            acceptedFiles: ".csv",
            maxFiles: 1,
            maxFilesize: 5, // MB
            addRemoveLinks: true,
            accept: function(file, done) {
                if (file.name == "justinbieber.jpg") {
                    done("Naha, you don't.");
                } else {
                    done();
                }
            },
            success: function(file, response) {
                toastr.success(response.messages.success, _LANG_.updated + "!");
                modal.hide(); // hide the modal
            },
            sending: function(file, xhr, formData) {
                formData.append("token", $('meta[name="X-CSRF-TOKEN"]').attr('content'));
                formData.append("fileTranslate", $('#fileTranslate').val());
            },
            error: function(file, response, xhr) {
                toastr.error((response.error != undefined ? response.error.message : response.messages.error), xhr.statusText);
            }
        });
    }

    return {
        // public functions
        init: function() {
            demo1();
        }
    };
}();

KTUtil.onDOMContentLoaded(function() {
    KTDropzoneDemo.init();
});

</script>

<?= $this->endSection() ?>