<?php use \Adnduweb\Ci4Admin\Libraries\Theme; ?>
<?= $this->extend('Themes\backend\metronic\layout\admin') ?>
<?= $this->section('main') ?>
<div class="card ">
<!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
            <?= $this->include('\Themes\backend\metronic\layout\partials\extras\_search') ?> 
        <!--begin::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">

            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-kt-<?= singular($controller); ?>-table-toolbar="base">
            
                <?php if ($filterDatabase == true) { ?>
                    <?= $this->include('\Themes\backend\metronic\layout\partials\extras\_filter_database') ?> 
                <?php } ?>


                <?php if ($allow_export == true) { ?>
                    <?= $this->include('\Themes\backend\metronic\layout\partials\extras\_export_data') ?>
                <?php } ?>
            </div>
            <!--end::Toolbar-->

            <!--begin::Group actions-->
            <div class="d-flex justify-content-end align-items-center d-none" data-kt-<?= singular($controller); ?>-table-toolbar="selected">
                <div class="fw-bolder me-5">
                <span class="me-2" data-kt-<?= singular($controller); ?>-table-select="selected_count"></span>Selected</div>
                <button type="button" class="btn btn-danger" data-kt-<?= singular($controller); ?>-table-select="delete_selected">Delete Selected</button>
            </div>
            <!--end::Group actions-->

        </div>
        <!--end::Card toolbar-->
    </div>
                    

    <!--end::Card header-->
    <div class="card-body pt-0">
        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_<?= $controller; ?>">
            <!--begin::Table head-->
            <thead>
                <!--begin::Table row-->
                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                    <!-- <th class="min-w-125px" title="RecordId"><?= lang('Core.Id'); ?></th> -->
                    <th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input allCheck" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_<?= $controller; ?> .form-check-input" value="1" />
                        </div>
                    </th>
                    <th class="min-w-125px" title="Name"><?= lang('Core.source'); ?></th>
                    <th class="min-w-125px" title="Event"><?= lang('Core.event'); ?></th>
                    <th class="min-w-125px" title="Summary"><?= lang('Core.summary'); ?></th>
                    <th class="min-w-125px" title="User"><?= lang('Core.user'); ?></th>
                    <th class="min-w-125px" title="Date" ><?= lang('Core.date'); ?></th>
                    <th class="min-w-125px" title="Data"><?= lang('Core.data'); ?></th>

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

var KTLogsTrafficsList = function () {
    // Define shared variables
    var table = document.getElementById('kt_table_<?= $controller; ?>');
    var datatable;
    var toolbarBase;
    var toolbarSelected;
    var selectedCount;

    // Private functions
    var initLogsTrafficsTable = function () {

        // Init datatable --- more info on datatables: https://datatables.net/manual/
        window.Ci4DataTables["kt_table_<?= $controller; ?>-table"] = $(table).DataTable({
            'responsive': true,
            "info": false,
            "retrieve": true,
            "select": {
				style: 'multi',
				selector: 'td:first-child .checkable',
			},
            "autoWidth": false,
            'deferRender': true,
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
                'url':baseController + "/datatable-traffics",
                'data': {
                    // CSRF Hash
                    [crsftoken]: $('meta[name="X-CSRF-TOKEN"]').attr('content') // CSRF Token
                },
            },
            'order': [[1, 'asc']],
            "pageLength": 50,
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
                    data: 'ip_address',
                    targets: 1,
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'user_agent',
                    targets: 2,
                    render: function(data, type, full, meta) {
                        return full.user_agent;
                    },
                    orderable: false,
                    searchable: true,
                },
                {
                    data: 'user_id',
                    targets: 3,
                    render: function(data, type, full, meta) {
                        return (full.user_id == 0) ? 'System' : 'Utilisateur: ' + full.user_id         
                    },
                    orderable: false,
                    searchable: true,
                },
                {
                    data: 'path',
                    targets: 4,
                    render: function(data, type, full, meta) {
                       
                        return full.path                    
                    },
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'views',
                    targets: 5,
                    render: function(data, type, full, meta) {
                       
                        return full.views                    
                    },
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'created_at',
                    targets: 6,
                    render: function(data, type, full, meta) {
                        var ukDatea = full.created_at.split(' ');
                        var date = ukDatea[0].split('-');
                        return (date[2] + '-' + date[1] + '-' + date[0]) + ' à ' + ukDatea[1] ; 
                    },
                    orderable: true,
                    searchable: true,
                },
            ],
        });

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        Ci4DataTables["kt_table_<?= $controller; ?>-table"].on('draw', function (jqXHR, settings) {
            initToggleToolbar();
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
            tRow = window.Ci4DataTables["kt_table_<?= $controller; ?>-table"].rows($(this).closest("tr"));
            const ids = [];
            var dtRow = window.Ci4DataTables["kt_table_<?= $controller; ?>-table"].rows('.selected').data().map(function(t, e) {
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
                        action: 'traffic',
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

            initLogsTrafficsTable();
            initToggleToolbar();
            handleSearchDatatable();
            <?php if ($filterDatabase == true) { ?>
            handleResetForm();
            <?php } ?>
            <?php if ($filterDatabase == true) { ?>
            handleFilterDatatable();
            <?php } ?>
            //exportData();

        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTLogsTrafficsList.init();
});

</script>

<?= $this->endSection() ?>