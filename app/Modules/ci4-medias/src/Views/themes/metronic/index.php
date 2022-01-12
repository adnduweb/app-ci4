<?= $this->extend('Themes\backend\metronic\layout\admin') ?>
<?= $this->section('main') ?>


    <?= view('Adnduweb\Ci4Medias\Views\themes\metronic\_partials\cartd_top', ['medias' => $medias, 'active' => $active]) ?>

    <div class="card card-flush">

        <?= view('Adnduweb\Ci4Medias\Views\themes\metronic\_partials\header_flush') ?>

        <?= view('Adnduweb\Ci4Medias\Views\themes\metronic\_partials\list_media' , ['medias' => $medias]) ?>

        <?= view('Adnduweb\Ci4Medias\Views\themes\metronic\_templates\rename') ?>
        <?= view('Adnduweb\Ci4Medias\Views\themes\metronic\_templates\action') ?>
        <?= view('Adnduweb\Ci4Medias\Views\themes\metronic\_templates\checkbox') ?>

        <?= view('Adnduweb\Ci4Medias\Views\themes\metronic\_modals\upload') ?>
        <?= view('Adnduweb\Ci4Medias\Views\themes\metronic\_modals\remove') ?>


    </div>


<?= $this->endSection() ?>

<?= $this->section('AdminAfterExtraJs') ?>

<script type="text/javascript">

"use strict";

// Class definition
var KTFileManagerList = function () {
    // Define shared variables
    var datatable;
    var table

    // Define template element variables
    var uploadTemplate;
    var renameTemplate;
    var actionTemplate;
    var checkboxTemplate;


    // Private functions
    const initTemplates = () => {
        uploadTemplate = document.querySelector('[data-kt-filemanager-template="upload"]');
        renameTemplate = document.querySelector('[data-kt-filemanager-template="rename"]');
        actionTemplate = document.querySelector('[data-kt-filemanager-template="action"]');
        checkboxTemplate = document.querySelector('[data-kt-filemanager-template="checkbox"]');
    }

    const initDatatable = () => {

        // Init datatable --- more info on datatables: https://datatables.net/manual/
        window.Ci4DataTables["kt_file_manager_list"] = $(table).DataTable({
            'responsive': true,
            "info": false,
            "retrieve": true,
            "select": {
				style: 'multi',
				selector: 'td:first-child .checkable',
			},
            "autoWidth": false,
            "serverSide" : true,
            "processing": true,
            'searchDelay': 400,
            'serverMethod': 'get',
            'headers': window.axios.defaults.headers.common,
            'language': {
              'processing': '<div class="blockui-overlay " style="z-index: 1;"><span class="spinner-border text-primary"></span></div>',
              'noRecords': _LANG_.no_record_found,
            },
            'ajax': {
                'url':current_url + "/datatable",
                'data': {
                    // CSRF Hash
                    [crsftoken]: $('meta[name="X-CSRF-TOKEN"]').attr('content') // CSRF Token
                },
            },
            // 'order': [],
            'order': [[1, 'asc']],
            "pageLength": 10,
            "lengthChange": false,
            "stateSave": true,
            createdRow: function (row, data, dataIndex) {
                $(row).attr('data-uuid', data.uuid);
            },
            
            'columnDefs': [
                { 
                    data: 'id',
                    targets: 0,
                    render: function(data, type, full, meta) {
                        return '<td class="text-right py-0 align-middle">\
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">\
                                        <input class="form-check-input group-checkable" type="checkbox" data-uuid="' + full.uuid + '" value="' + full.uuid + '" />\
                                    </div>\
                                </td>';
                    },
                    orderable: false
                }, 
                { 
                    data: 'titre',
                    targets: 1,
                    render: function(data, type, full, meta) {
                        const urlOriginal = '/' + Medias.segementUrl + '/original/' + full.filename;
                        const imgThumbnail = '/' + Medias.segementUrl + '/thumbnails/' + full.filename;

                        return '<td>\
                            <div class="d-flex align-items-center">\
                                <img src="'+imgThumbnail+'" class="img-thumbnail select-image mx-5" alt="'+full.titre+'" width="100" />\
                                <div class="row">\
                                    <span class="text-gray-800 text-hover-primary">'+full.titre+'</span>\
                                    <a class="text-muted link fs-7" target="_blank" href="' + urlOriginal + '" class="text-gray-800 text-hover-primary">Voir le lien</a>\
                                </div>\
                            </div>\
                        </td>';
               
                    },
                    orderable: true,
                    searchable: true
                },   
                { 
                    data: 'size',
                    targets: 2,
                    render: function(data, type, full, meta) {
                       
                        return humanFileSize(full.size);                
                    },
                    orderable: true,
                    searchable: true
                }, 
                { 
                    data: 'created_at',
                    targets: 3,
                    render: function(data, type, full, meta) {
                        var ukDatea = full.created_at.split(' ');
                        var date = ukDatea[0].split('-');
                        return '<div class="badge badge-light fw-bolder">' + (date[2] + '-' + date[1] + '-' + date[0]) + ' à ' + ukDatea[1] + '</div>' ;         
                    },
                    orderable: false,
                    searchable: false
                },    
                { 
                    data: null,
                    targets: 4,
                    render: function(data, type, full, meta) {
                        var htmlContent = '';
                       
                        htmlContent += '<td class="text-end" data-kt-filemanager-table="action_dropdown">';
                        htmlContent += '    <div class="d-flex justify-content-end">';
                        htmlContent += '         <div class="ms-2">';
                        htmlContent += '  <button type="button" class="btn btn-sm  btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">';
                        htmlContent += '               <?= lang('Core.action'); ?>';
                        htmlContent += '             </button>';
                        htmlContent += ' <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">';
                         htmlContent += '      <div class="menu-item px-3">';
                        htmlContent += '          <a href="#" data-uuid="'+full.uuid+'" class="menu-link px-3" data-kt-filemanager-table="rename">Rename</a>';
                        htmlContent += '      </div>';

                        htmlContent += '       <div class="menu-item px-3">';
                        htmlContent += '           <a href="' + current_url + '/edit/' + full.uuid + '" class="menu-link px-3">Modifier</a>';
                        htmlContent += '      </div>';

                        htmlContent += '     <div class="menu-item px-3">';
                        htmlContent += '        <a href="#" data-uuid="' + full.uuid + '" class="menu-link text-danger px-3" data-kt-filemanager-table-filter="delete_row">Delete</a>';
                        htmlContent += '    </div>';
                        htmlContent += '      </div>';
                        htmlContent += '  </div>';
                        htmlContent += '  </div>';
                        htmlContent += ' </td>';

                        return htmlContent;     
                        
                       
                    }, 
                    orderable: false,
                    searchable: false  
                }
                      
            ],
        });


        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        window.Ci4DataTables["kt_file_manager_list"].on('draw', function () {
            initToggleToolbar();
            handleDeleteRows();
            toggleToolbars();
            KTMenu.createInstances();
            initCopyLink();
            countTotalItems();
            handleRename();
        });
    }

    $('.allCheck').click(function() {
        if (Ci4DataTables["kt_file_manager_list"].rows({
                selected: true
            }).count() > 0) {
                Ci4DataTables["kt_file_manager_list"].rows().deselect();
            return;
        }

        Ci4DataTables["kt_file_manager_list"].rows().select();
    });

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    const handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-filemanager-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            window.Ci4DataTables["kt_file_manager_list"].search(e.target.value).draw();
        });
    }

    // Delete customer
    const handleDeleteRows = () => {
        // Select all delete buttons
        const deleteButtons = table.querySelectorAll('[data-kt-filemanager-table-filter="delete_row"]');

        deleteButtons.forEach(d => {
            // Delete button on click
            d.addEventListener('click', function (e) {
                e.preventDefault();

                // Select parent row
                const parent = e.target.closest('tr');
                const uuid = $(this).data('uuid');

                // Get customer name
                const fileName = parent.querySelectorAll('td')[1].innerText;

                // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                Swal.fire({
                    text: "Are you sure you want to delete " + fileName + "?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function (result) {
                    if (result.value) {
                       
                        const packets = {
                        uuid:  [uuid],
                        token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
                        };

                        axios.delete("<?= route_to('media-remove-file') ?>", { data: packets})
                        .then( response => {
                            toastr.success(response.data.messages.success);
                            const headerCheckbox = table.querySelectorAll('[type="checkbox"]')[0];
                            headerCheckbox.checked = false;
                            Ci4DataTables["kt_file_manager_list"].ajax.reload();
                        })
                        .catch(error => {});
                    }
                });
            })
        });
    }

    // Init toggle toolbar
    const initToggleToolbar = () => {
        // Toggle selected action toolbar
        // Select all checkboxes
        var checkboxes = table.querySelectorAll('[type="checkbox"]');
        if (table.getAttribute('data-kt-filemanager-table') === 'folders') {
            checkboxes = document.querySelectorAll('#kt_file_manager_list_wrapper [type="checkbox"]');
        }

        // Select elements
        const deleteSelected = document.querySelector('[data-kt-filemanager-table-select="delete_selected"]');

        // Toggle delete selected toolbar
        checkboxes.forEach(c => {
            // Checkbox on click event
            c.addEventListener('click', function () {
                //console.log(c);
                setTimeout(function () {
                    toggleToolbars();
                }, 50);
            });
        });

        /**
         * Deleted selected rows
         *  
         */ 
        deleteSelected.addEventListener('click', function () {

             const ids = [];
             const selected = document.querySelectorAll('#kt_file_manager_list_wrapper tbody tr.selected');
             selected.forEach(c => {
                ids.push(c.getAttribute('data-uuid'));  
             });

            // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
            Swal.fire({
                text: "Are you sure you want to delete selected files or folders?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then(function (result) {
                if (result.value) {

                    const packets = {
                        uuid:  ids,
                        token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
                    };

                    axios.delete("<?= route_to('media-remove-file') ?>", { data: packets})
                    .then( response => {
                        toastr.success(response.data.messages.success);
                        const headerCheckbox = table.querySelectorAll('[type="checkbox"]')[0];
                        headerCheckbox.checked = false;
                        Ci4DataTables["kt_file_manager_list"].ajax.reload();
                    })
                    .catch(error => {}); 
                }
            });
        });
    }

    // Toggle toolbars
    const toggleToolbars = () => {
        // Define variables
        const toolbarBase = document.querySelector('[data-kt-filemanager-table-toolbar="base"]');
        const toolbarSelected = document.querySelector('[data-kt-filemanager-table-toolbar="selected"]');
        const selectedCount = document.querySelector('[data-kt-filemanager-table-select="selected_count"]');

        // Select refreshed checkbox DOM elements 
        const allCheckboxes = table.querySelectorAll('tbody [type="checkbox"]');

        // Detect checkboxes state & count
        let checkedState = false;
        let count = 0;

        // Count checked boxes
        allCheckboxes.forEach(c => {
            if (c.checked) {
                checkedState = true;
                count++;
            }
        });

        // Toggle toolbars
        if (checkedState) {
            selectedCount.innerHTML = count;
            toolbarBase.classList.add('d-none');
            toolbarSelected.classList.remove('d-none');
        } else {
            toolbarBase.classList.remove('d-none');
            toolbarSelected.classList.add('d-none');
        }
    }

    // Handle rename file or folder
    const handleRename = () => {
        const renameButton = table.querySelectorAll('[data-kt-filemanager-table="rename"]');     

        renameButton.forEach(button => {
            button.addEventListener('click', renameCallback);
        });
    }

    // Rename callback
    const renameCallback = (e) => {
        e.preventDefault();

        // Define shared value
        let nameValue;

        // Stop renaming if there's an input existing
        if (table.querySelectorAll('#kt_file_manager_rename_input').length > 0) {
            Swal.fire({
                text: "Unsaved input detected. Please save or cancel the current item",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger"
                }
            });

            return;
        }

        // Select parent row
        const parent = e.target.closest('tr');

        // Get name column
        const nameCol = parent.querySelectorAll('td')[1];
        const colImg = nameCol.querySelector('.img-thumbnail');
        const colLink = nameCol.querySelector('.link');
        const name = nameCol.querySelector('.text-hover-primary');

        nameValue = nameCol.innerText;
        var uuid = parent.dataset.uuid;

        // Set rename input template
        const renameInput = renameTemplate.cloneNode(true);
        renameInput.querySelector('#kt_file_manager_rename_folder_img').innerHTML = colImg.outerHTML;
        renameInput.querySelector('#kt_file_manager_rename_folder_link').innerHTML = colLink.outerHTML;
        renameInput.querySelector('#kt_file_manager_rename_folder_link').innerHTML = colLink.outerHTML;

        // Swap current column content with input template
        nameCol.innerHTML = renameInput.innerHTML;
        // Set input value with current file/folder name
        parent.querySelector('#kt_file_manager_rename_input').value = name.innerHTML;

        // Rename file / folder validator
        var renameValidator = FormValidation.formValidation(
            nameCol,
            {
                fields: {
                    'rename_folder_name': {
                        validators: {
                            notEmpty: {
                                message: 'Name is required'
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        // Rename input button action
        const renameInputButton = document.querySelector('#kt_file_manager_rename_folder');
        renameInputButton.addEventListener('click', e => {
            e.preventDefault();

            // Detect if valid
            if (renameValidator) {
                renameValidator.validate().then(function (status) {
                    console.log('validated!'); 

                    if (status == 'Valid') {


                        const postData = {'titre':$("#kt_file_manager_rename_input").val(), 'uuid': uuid };
                        const apiURL = current_url + '/rename';

                        fetch(apiURL, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                "X-Requested-With": "XMLHttpRequest",
                                "X-CSRF-Token": csrfHash
                            },
                            body: JSON.stringify(postData),
                        })
                        .then(response => response.json())
                        //.then(jsonResponse => console.log('Success: ', jsonResponse))
                        .then(jsonResponse => toastr.success(jsonResponse.messages.success, _LANG_.updated + "!"))
                        .then(function(data){
                            Ci4DataTables["kt_file_manager_list"].ajax.reload();
                        })
                        .catch(error => console.log('Error: ', error));

                    }

                });
            }
        });

        // Cancel rename input
        const cancelInputButton = document.querySelector('#kt_file_manager_rename_folder_cancel');
        cancelInputButton.addEventListener('click', e => {
            e.preventDefault();

            // Simulate process for demo only
            cancelInputButton.setAttribute("data-kt-indicator", "on");

            setTimeout(function () {
                const revertTemplate = `<div class="d-flex align-items-center">
                    ${colImg.outerHTML}
                    <a href="?page=apps/file-manager/files/" class="text-gray-800 text-hover-primary">${nameValue}</a>
                </div>`;

                // Remove spinner
                cancelInputButton.removeAttribute("data-kt-indicator");

                // Draw datatable with new content -- Add more events here for any server-side events
                window.Ci4DataTables["kt_file_manager_list"].cell($(nameCol)).data(revertTemplate).draw();

                // Toggle toastr
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toastr-top-right",
                    "preventDuplicates": false,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };

                toastr.error('Cancelled rename function');
            }, 1000);
        });
    }

    // Init dropzone
    const initDropzone = () => {
        // set the dropzone container id
        const id = "#kt_modal_upload_dropzone";
        const dropzone = document.querySelector(id);

        // set the preview element template
        var previewNode = dropzone.querySelector(".dropzone-item");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        var myDropzone = new Dropzone(id, { // Make the whole body a dropzone
            url:  current_url + "/upload?time=" + $.now(), // Set the url for your upload script location
            // parallelUploads: 10,
            // previewTemplate: previewTemplate,
            // maxFilesize: 1, // Max filesize in MB
            // autoProcessQueue: false, // Stop auto upload
            // autoQueue: false, // Make sure the files aren't queued until manually added
            // previewsContainer: id + " .dropzone-items", // Define the container to display the previews
            // clickable: id + " .dropzone-select", // Define the element that should be used as click trigger to select files.
            params: function(files, xhr, chunk) {
                if (chunk) {
                    return {
                        dzUuid: chunk.file.upload.uuid,
                        dzChunkIndex: chunk.index,
                        dzTotalFileSize: chunk.file.size,
                        dzCurrentChunkSize: chunk.dataBlock.data.size,
                        dzTotalChunkCount: chunk.file.upload.totalChunkCount,
                        dzChunkByteOffset: chunk.index * this.options.chunkSize,
                        dzChunkSize: this.options.chunkSize,
                        dzFilename: chunk.file.name,
                        userID: 1,
                    };
                }
            },
            acceptedFiles: "image/jpeg,image/png,image/gif",
            uploadmultiple: true,
            addRemoveLinks: !0,
            timeout: 0,
            // parallelUploads: 1, // since we're using a global 'currentFile', we could have issues if parallelUploads > 1, so we'll make it = 1
            maxFilesize: Medias.maxFilesize, // max individual file size 1024 MB
            chunking: true, // enable chunking
            forceChunking: true, // forces chunking when file.size < chunkSize
            // parallelChunkUploads: true, // allows chunks to be uploaded in parallel (this is independent of the parallelUploads option)
            chunkSize: 75387608, // chunk size 1,000,000 bytes (~1MB)
            retryChunks: true, // retry chunks on failure
            retryChunksLimit: 3, // retry maximum of 3 times (default is 3)
            previewsContainer: id + " .dropzone-items", // Define the container to display the previews
            clickable: id + " .dropzone-select", // Define the element that should be used as click trigger to select files.
            headers: {
                'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
        });

        myDropzone.on("addedfile", function (file) {
            // // Hook each start button
            // file.previewElement.querySelector(id + " .dropzone-start").onclick = function () {
            //     // myDropzone.enqueueFile(file); -- default dropzone function

            //     // Process simulation for demo only
            //     const progressBar = file.previewElement.querySelector('.progress-bar');
            //     progressBar.style.opacity = "1";
            //     var width = 1;
            //     var timer = setInterval(function () {
            //         if (width >= 100) {
            //             myDropzone.emit("success", file);
            //             myDropzone.emit("complete", file);
            //             clearInterval(timer);
            //         } else {
            //             width++;
            //             progressBar.style.width = width + '%';
            //         }
            //     }, 20);
            // };

            // const dropzoneItems = dropzone.querySelectorAll('.dropzone-item');
            // dropzoneItems.forEach(dropzoneItem => {
            //     dropzoneItem.style.display = '';
            // });
            // dropzone.querySelector('.dropzone-upload').style.display = "inline-block";
            // dropzone.querySelector('.dropzone-remove-all').style.display = "inline-block";

            console.log('addedfile');
        });

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("complete", function (file) {
            Ci4DataTables["kt_file_manager_list"].ajax.reload();
        });

        // Setup the buttons for all transfers
        dropzone.querySelector(".dropzone-upload").addEventListener('click', function () {
            // myDropzone.processQueue(); --- default dropzone process

            // Process simulation for demo only
            myDropzone.files.forEach(file => {
                const progressBar = file.previewElement.querySelector('.progress-bar');
                progressBar.style.opacity = "1";
                var width = 1;
                var timer = setInterval(function () {
                    if (width >= 100) {
                        myDropzone.emit("success", file);
                        myDropzone.emit("complete", file);
                        clearInterval(timer);
                    } else {
                        width++;
                        progressBar.style.width = width + '%';
                    }
                }, 20);
            });
        });

        // Setup the button for remove all files
        dropzone.querySelector(".dropzone-remove-all").addEventListener('click', function () {
            Swal.fire({
                text: "Are you sure you would like to remove all files?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, remove it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    dropzone.querySelector('.dropzone-upload').style.display = "none";
                    dropzone.querySelector('.dropzone-remove-all').style.display = "none";
                    myDropzone.removeAllFiles(true);
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Your files was not removed!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        }
                    });
                }
            });
        });

        // On all files completed upload
        myDropzone.on("queuecomplete", function (progress) {
            const uploadIcons = dropzone.querySelectorAll('.dropzone-upload');
            uploadIcons.forEach(uploadIcon => {
                uploadIcon.style.display = "none";
            });
            if (myDropzone.files[0].status == Dropzone.SUCCESS) {
                toastr.success(_LANG_.saved_data);
                $('.dz-success').fadeOut('slow');
                $('.dz-message').fadeIn('slow');
                $('#kt_modal_upload').modal('hide');
            }
        });

        // On all files removed
        myDropzone.on("removedfile", function (file) {
            if (myDropzone.files.length < 1) {
                dropzone.querySelector('.dropzone-upload').style.display = "none";
                dropzone.querySelector('.dropzone-remove-all').style.display = "none";
            }
        });
    }

    // Init copy link
    const initCopyLink = () => {
        // Select all copy link elements
        const elements = table.querySelectorAll('[data-kt-filemanger-table="copy_link"]');

        elements.forEach(el => {
            // Define elements
            const button = el.querySelector('button');
            const generator = el.querySelector('[data-kt-filemanger-table="copy_link_generator"]');
            const result = el.querySelector('[data-kt-filemanger-table="copy_link_result"]');
            const input = el.querySelector('input');

            // Click action
            button.addEventListener('click', e => {
                e.preventDefault();

                // Reset toggle
                generator.classList.remove('d-none');
                result.classList.add('d-none');

                var linkTimeout;
                clearTimeout(linkTimeout);
                linkTimeout = setTimeout(() => {
                    generator.classList.add('d-none');
                    result.classList.remove('d-none');
                    input.select();
                }, 2000);
            });
        });
    }

    // Count total number of items
    const countTotalItems = () => {
        const counter = document.getElementById('kt_file_manager_items_counter');

        // Count total number of elements in datatable --- more info: https://datatables.net/reference/api/count()
        counter.innerText = window.Ci4DataTables["kt_file_manager_list"].rows().count() + ' items';
    }

     /**
     * Format bytes as human-readable text.
     * 
     * @param bytes Number of bytes.
     * @param si True to use metric (SI) units, aka powers of 1000. False to use 
     *           binary (IEC), aka powers of 1024.
     * @param dp Number of decimal places to display.
     * 
     * @return Formatted string.
     */
    const humanFileSize = function( bytes,  si=false, dp=1) {
        const thresh = si ? 1000 : 1024;

        if ( Math.abs(bytes) < thresh) {
            return bytes + ' B';
        }

        const units = si 
            ? ['kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'] 
            : ['KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
        let u = -1;
        const r = 10**dp;

        do {
            bytes /= thresh;
            ++u;
        } while (Math.round(Math.abs(bytes) * r) / r >= thresh && u < units.length - 1);


        return bytes.toFixed(dp) + ' ' + units[u];
    }

    // Public methods
    return {
        init: function () {
            table = document.querySelector('#kt_file_manager_list');

            if (!table) {
                return;
            }

            initTemplates();
            initDatatable();
            initToggleToolbar();
            handleSearchDatatable();
            handleDeleteRows();
            initDropzone();
            initCopyLink();
            handleRename();
            countTotalItems();
            KTMenu.createInstances();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTFileManagerList.init();
});

</script>

<?= $this->endSection() ?>