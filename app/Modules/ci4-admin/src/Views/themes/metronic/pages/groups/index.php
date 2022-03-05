<?php use \Adnduweb\Ci4Admin\Libraries\Theme; ?>
<?= $this->extend('Themes\backend\metronic\admin') ?>
<?= $this->section('main') ?>
<div class="card ">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
            <?= $this->include('\Themes\backend\metronic\partials\extras\_search') ?> 
        <!--begin::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">

            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-kt-<?= singular($controller); ?>-table-toolbar="base">
            
                <?php if ($filterDatabase == true) { ?>
                    <?= $this->include('\Themes\backend\metronic\partials\extras\_filter_database') ?> 
                <?php } ?>


                <?php if ($allow_export == true) { ?>
                    <?= $this->include('\Themes\backend\metronic\partials\extras\_export_data') ?>
                <?php } ?>
            </div>
            <!--end::Toolbar-->

            <?= $this->include('\Themes\backend\metronic\partials\extras\_delete_toolbar') ?>

        </div>
        <!--end::Card toolbar-->
    </div>
                    

    <!--end::Card header-->
    <div class="card-body p-0">
        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_<?= $controller; ?>">
            <!--begin::Table head-->
            <thead>
                <!--begin::Table row-->
                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                    <th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input allCheck" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_<?= $controller; ?> .form-check-input" value="1" />
                        </div>
                    </th>
                    <th class="min-w-125px" title="Name"><?= lang('Core.name'); ?></th>
                    <th class="min-w-125px" title="Description"><?= lang('Core.description'); ?></th>
                    <th class="text-end min-w-70px" title="Action"><?= lang('Core.Actions'); ?></th>

                </tr>
                <!--end::Table row-->
            </thead>
            <!--end::Table head-->

        </table>
    <!--end::Table-->
    </div>
    <!--end: Datatable -->
</div>


<?= $this->endSection() ?>

<?= $this->section('AdminAfterExtraJs') ?>

<script type="text/javascript">


var KTPermissionsList = function () {
    // Define shared variables
    var table = document.getElementById('kt_table_<?= $controller; ?>');
    var datatable;
    var toolbarBase;
    var toolbarSelected;
    var selectedCount;

    // Private functions
    var initPermissionTable = function () {
        // Set date data order

        // Init datatable --- more info on datatables: https://datatables.net/manual/
        window.Ci4DataTables["kt_table_<?= $controller; ?>-table"] = $(table).DataTable({
            'responsive': true,
            "info": false,
            "retrieve": true,
            "info": false,
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
              //processing: '<i class="ace-icon fa fa-spinner fa-spin orange bigger-500" style="font-size:60px;margin-top:50px;"></i>'
              //'processing': _LANG_.loading_wait,
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
            "lengthChange": true,
            "stateSave": true,
            'rows': {
                beforeTemplate: function(row, data, index) {
                    if (data.active == '0') {
                        row.addClass('notactive');
                    }
                }
            },
            'columnDefs': [
                {
                    data: 'id',
                    targets: 0,
                    render: function(data, type, full, meta) {
                        return '<td class="text-right py-0 align-middle">\
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">\
                                        <input class="form-check-input group-checkable" type="checkbox" data-id="' + full.id + '" value="' + full.id + '" />\
                                    </div>\
                                </td>';
                    },
                    orderable: false

                },
                {
                    data: 'name',
                    targets: 1,
                    render: function(data, type, full, meta) {

                        return '<a href="' + current_url + '/edit/' + full.id + '" class="text-dark fw-bolder text-hover-primary fs-6 capitalize"> ' + full.name + '</a>';
                    }, 
                    orderable: true,
                    searchable: true  
                },
                {
                    data: 'description',
                    width: '60%',
                    targets: 2,
                    orderable: true,
                    searchable: true  
                },
                {
                    data: null,
                    targets: 3,
                    render: function(data, type, full, meta) {
                        var htmlContent = '';
                        if(data.is_natif == 1){
                            htmlContent += '...';
                            return htmlContent;
                        }else{

                            htmlContent += '<td class="text-end">';
                            htmlContent += '<a href="javascript:;" class="btn btn-light btn-active-light-primary btn-sm ajax-datatable-action" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">Actions';
                            htmlContent += '<?= service('theme')->getSVG('icons/duotone/arrows/arr072.svg', "svg-icon svg-icon-5 m-0", false, true); ?>';
                            htmlContent += '</a>';
                            htmlContent += ' <!--begin::Menu-->';
                            htmlContent += ' <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">';
                            htmlContent += '<!--begin::Menu item-->';
                            htmlContent += '<div class="menu-item px-3">';
                            htmlContent += '<a href="' + current_url + '/edit/' + full.id + '" class="menu-link px-3">Edit</a>'; 
                            htmlContent +=  '</div>';
                            htmlContent +=  '<!--end::Menu item-->';
                            htmlContent +=  '<!--begin::Menu item-->';
                            htmlContent +=  '<div class="menu-item px-3">';
                            htmlContent +=  '<a href="#" class="menu-link px-3" data-id="' + full.id + '" data-kt-<?= $controller; ?>-table-filter="delete_row">Delete</a>';
                            htmlContent +=  '</div>';
                            htmlContent +=  '<!--end::Menu item-->';
                            htmlContent +=  '</div>';
                            htmlContent +=  '<!--end::Menu-->';
                            htmlContent +=  '</td>';

                            return htmlContent;     
                        }
                    },
                    orderable: false,
                    searchable: false  

                }
            ],
        });

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        Ci4DataTables["kt_table_<?= $controller; ?>-table"].on('draw', function (jqXHR, settings) {
            initToggleToolbar();
            handleDeleteRows();
            toggleToolbars();
        });

    }

    $('.allCheck').click(function() {
        if (Ci4DataTables["kt_table_<?= $controller; ?>-table"].rows({
                selected: true
            }).count() > 0) {
                Ci4DataTables["kt_table_<?= $controller; ?>-table"].rows().deselect();
            return;
        }

        Ci4DataTables["kt_table_<?= $controller; ?>-table"].rows().select();
    });


    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-<?= singular($controller); ?>-table-filter="search"]');
        filterSearch.addEventListener('change', function (e) {
            Ci4DataTables["kt_table_<?= $controller; ?>-table"].search(e.target.value).draw();
        });
    }

    // Filter Datatable
    var handleFilterDatatable = () => {
        // Select filter options
        const filterForm = document.querySelector('[data-kt-<?= singular($controller); ?>-table-filter="form"]');
        const filterButton = filterForm.querySelector('[data-kt-<?= singular($controller); ?>-table-filter="filter"]');
        const selectOptions = filterForm.querySelectorAll('select');

        // Filter datatable on submit
        filterButton.addEventListener('click', function () {
            var filterString = '';

            // Get filter values
            selectOptions.forEach((item, index) => {
                if (item.value && item.value !== '') {
                    if (index !== 0) {
                        filterString += ' ';
                    }

                    // Build filter value options
                    filterString += item.value;
                }
            });

            // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
            Ci4DataTables["kt_table_<?= $controller; ?>-table"].search(filterString).draw();
        });
    }

    // Reset Filter
    var handleResetForm = () => {
        // Select reset button
        const resetButton = document.querySelector('[data-kt-<?= singular($controller); ?>-table-filter="reset"]');

        // Reset datatable
        resetButton.addEventListener('click', function () {
            // Select filter options
            const filterForm = document.querySelector('[data-kt-<?= singular($controller); ?>-table-filter="form"]');
            const selectOptions = filterForm.querySelectorAll('select');

            // Reset select2 values -- more info: https://select2.org/programmatic-control/add-select-clear-items
            selectOptions.forEach(select => {
                $(select).val('').trigger('change');
            });

            // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
            Ci4DataTables["kt_table_<?= $controller; ?>-table"].search('').draw();
        });
    }


    // Delete subscirption
    var handleDeleteRows = () => {
        // Select all delete buttons
        const deleteButtons = table.querySelectorAll('[data-kt-<?= $controller; ?>-table-filter="delete_row"]');

        deleteButtons.forEach(d => {
            // Delete button on click
            d.addEventListener('click', function (e) {
                e.preventDefault();

                // Select parent row
                const parent = e.target.closest('tr');

                // Get role name
                const userName = parent.querySelectorAll('td')[1].querySelectorAll('a')[0].innerText;

                var id = $(this).data('id');

                // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                Swal.fire({
                    text: "Are you sure you want to delete " + userName + "?",
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
                            id:  [id],
                            token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
                        };

                        axios.delete("<?= route_to(singular($controller) . '-delete') ?>", { data: packets})
                        .then( response => {
                            toastr.success(response.data.messages.success);
                            const headerCheckbox = table.querySelectorAll('[type="checkbox"]')[0];
                            headerCheckbox.checked = false;
                            Ci4DataTables["kt_table_<?= $controller; ?>-table"].ajax.reload();

                        })
                        .catch(error => { }); 

                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: customerName + " was not deleted.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        });
                    }
                });
            })
        });
    }

    // Init toggle toolbar
    var initToggleToolbar = () => {
        // Toggle selected action toolbar
        // Select all checkboxes
        const checkboxes = table.querySelectorAll('[type="checkbox"]');

        // Select elements
        toolbarBase = document.querySelector('[data-kt-<?= singular($controller); ?>-table-toolbar="base"]');
        toolbarSelected = document.querySelector('[data-kt-<?= singular($controller); ?>-table-toolbar="selected"]');
        selectedCount = document.querySelector('[data-kt-<?= singular($controller); ?>-table-select="selected_count"]');
        const deleteSelected = document.querySelector('[data-kt-<?= singular($controller); ?>-table-select="delete_selected"]');

        // Toggle delete selected toolbar
        checkboxes.forEach(c => {
           // Checkbox on click event
            c.addEventListener('click', function () {
                setTimeout(function () {
                    toggleToolbars();
                }, 50);
            });
        });
        

        // Deleted selected rows
        deleteSelected.addEventListener('click', function () {
            // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
            //var dtRow = Ci4DataTables["kt_table_<?= $controller; ?>-table"].rows($(this).closest("tr"));
            const ids = [];
             var dtRow = Ci4DataTables["kt_table_<?= $controller; ?>-table"].rows('.selected').data().map(function(t, e) {
                ids.push(t.id);  
             });

            Swal.fire({
                text: _LANG_.are_you_sure_delete + " " + Ci4DataTables["kt_table_<?= $controller; ?>-table"].rows('.selected').data().length + " " + _LANG_.selected_records + " ?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: _LANG_.yes_delete + ' !',
                cancelButtonText: _LANG_.no_cancel,
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then(function (result) {
                if (result.value) {

                    const packets = {
                        id:  ids,
                        token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
                    };

                    axios.delete("<?= route_to(singular($controller) . '-delete') ?>", { data: packets})
                    .then( response => {
                        toastr.success(response.data.messages.success);
                        const headerCheckbox = table.querySelectorAll('[type="checkbox"]')[0];
                        headerCheckbox.checked = false;
                        Ci4DataTables["kt_table_<?= $controller; ?>-table"].ajax.reload();
                    })
                    .catch(error => {}); 
                } 
            });
        });
    }

    // Toggle toolbars
    const toggleToolbars = () => {
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

    return {
        // Public functions  
        init: function () {
            if (!table) {
                return;
            }

            initPermissionTable();
            initToggleToolbar();
            handleSearchDatatable();
            <?php if ($filterDatabase == true) { ?>
            handleResetForm();
            <?php } ?>
            handleDeleteRows();
            <?php if ($filterDatabase == true) { ?>
            handleFilterDatatable();
            <?php } ?>
            //exportData();

        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTPermissionsList.init();
});

</script>

<?= $this->endSection() ?>