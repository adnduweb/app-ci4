<?= $this->extend('Themes\backend\metronic\admin') ?>
<?= $this->section('main') ?>
<div class="row g-5 g-xl-8">
    <!--begin::Col-->
    <div class="col-xl-12">
        <!--begin::Tables Widget 1-->
        <div class="card card-xl-stretch mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Liste des modules</span>
                </h3>
            </div>

            <div class="card-body py-3">

            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_module">
            <thead>
                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                    <th class="min-w-125px" title="Name">Nom</th>
                    <th class="min-w-125px" title="Chemin">Chemin</th>
                    <th class="min-w-125px" title="Natif">Natif</th>
                    <th class="min-w-125px" title="Instal">Installé</th>
                    <th class="min-w-125px" title="Date_update">Date de création</th>
                    <th class="min-w-125px" >Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($modules['enabled'] as $module){  ?>
                <tr class="<?= ($module->is_natif == 1) ? 'natif' : '' ;  ?> <?= ($module->is_installed == 1) ? 'install' : '' ;  ?> <?= ($module->active == 1) ? 'active' : '' ;  ?>">
                    <td> <?= $module->name; ?> </td>
                    <td> <?= $module->path; ?> </td>

                    <td> <?= ($module->is_natif == 1) ? '<div class="badge badge-secondary fw-bolder capitalize">'.lang('Core.module natif').'</div> ' : ' -- ' ;  ?> </td>

                    <td> 
                        <?php if($module->is_installed == 1){ ?>

                                <?php if($module->is_natif == 1){ ?>
                                    <a href="javascript:;" data-kt-module-update="enabled" disabled data-status="" data-handle="<?= $module->handle; ?>" data-class="<?= $module->class; ?>"  class="actionActive btn btn-bold btn-sm btn-font-sm btn-light-success">
                                        <?= lang('Core.unenabled'); ?>
                                    </a>
                                <?php }else{ ?>
                                    <a href="javascript:;" data-kt-module-update="enabled" data-status="" data-handle="<?= $module->handle; ?>" data-class="<?= $module->class; ?>"  class="actionActive btn btn-bold btn-sm btn-font-sm btn-light-success">
                                        <?= lang('Core.unenabled'); ?>
                                    </a>
                                <?php } ?>
                         <?php }else{ ?>

                                <?php if($module->is_natif == 1){ ?>
                                    <a href="javascript:;" data-kt-module-update="enabled" disabled data-status="disabled" data-handle="<?= $module->handle; ?>" data-class="<?= $module->class; ?>"  class="actionActive btn btn-bold btn-sm btn-font-sm btn-light-danger">
                                        <?= lang('Core.enabled'); ?>
                                    </a>
                                <?php }else{ ?>
                                    <a href="javascript:;" data-kt-module-update="enabled" data-status="disabled" data-handle="<?= $module->handle; ?>" data-class="<?= $module->class; ?>"  class="actionActive btn btn-bold btn-sm btn-font-sm btn-light-danger">
                                        <?= lang('Core.enabled'); ?>
                                    </a>
                                <?php } ?>

                        <?php } ?>
                        </td>


                    <td>  <?= $module->updated_at->humanize(); ?> </td>

                    <td>
                    <?php if($module->is_installed == 1 && $module->is_natif == 0){ ?>
                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <?= service('theme')->getSVG("duotune/arrows/arr072.svg", "svg-icon svg-icon-5 m-0"); ?>
                          </a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true" style="">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a data-kt-module-sync="bdd" data-id="<?= $module->id; ?>" class="menu-link px-3">Sync la bdd</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                    <?php }else{ ?>
                        --
                    <?php } ?>
                     
                     </td>

                </tr>
            <?php } ?>

            <?php foreach ($modules['unenabled'] as $module){  ?>
                <tr class=" <?= ($module->is_installed == 1) ? 'install' : '' ;  ?> <?= ($module->active == 1) ? 'active' : '' ;  ?>">
                    <td> <?= $module->name; ?> </td>
                    <td> <?= $module->path; ?> </td>

                    <td>  -- </td>

                    <td> 
                        <?php if($module->is_installed == 1){ ?>
                                <a href="javascript:;" data-kt-module-update="enabled" data-status="" data-handle="<?= $module->handle; ?>" data-class="<?= $module->class; ?>"  class="actionActive btn btn-bold btn-sm btn-font-sm btn-light-success">
                                    <?= lang('Core.unenabled'); ?>
                                </a>
                         <?php }else{ ?>
                                <a href="javascript:;" data-kt-module-update="enabled" data-status="disabled" data-handle="<?= $module->handle; ?>" data-class="<?= $module->class; ?>"  class="actionActive btn btn-bold btn-sm btn-font-sm btn-light-danger">
                                    <?= lang('Core.enabled'); ?>
                                </a>
                        <?php } ?>
                        </td>

                    <td> -- </td>

                    <td> -- </td>
                </tr>
            <?php } ?>
            </tbody>
            </table>         

            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>



<?= $this->section('AdminAfterExtraJs') ?>

<script type="text/javascript">
   

   var KTModulesList = function () {
    // Define shared variables
    var table = document.getElementById('kt_table_module');
    var datatable;

    // Private functions
    var initPermissionTable = function () {
        // Set date data order

        // Init datatable --- more info on datatables: https://datatables.net/manual/
        window.Ci4DataTables["kt_table_module-table"] = $(table).DataTable({
            'responsive': true,
            "info": false,
            "retrieve": true,
            "info": false,
            "select": {
				style: 'multi',
				selector: 'td:first-child .checkable',
			},
            "autoWidth": false,

            'language': {
              //processing: '<i class="ace-icon fa fa-spinner fa-spin orange bigger-500" style="font-size:60px;margin-top:50px;"></i>'
              //'processing': _LANG_.loading_wait,
              'processing': '<div class="blockui-overlay " style="z-index: 1;"><span class="spinner-border text-primary"></span></div>',
              'noRecords': _LANG_.no_record_found,
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

        });

    }

      // Active item
      var initModuleActive = () => {

        window.jQuery('[data-kt-module-update="active"]').on('click', function (e) {
            // Prevent default button action
            e.preventDefault();

            const packets = {
                uuid:  $(this).data('uuid'),
                token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
            };

            axios.post("<?= route_to('user-update-ajax') ?>", packets)
            .then( response => {
                toastr.success(response.data.messages.success, _LANG_.updated + "!"); // Notif
                Ci4DataTables["kt_table_module-table"].ajax.reload();
            })
            .catch(error => {}); 
            
        });
    }

  // Active item
  var initModuleEnableOrUnabled = () => {

        window.jQuery('[data-kt-module-update="enabled"]').on('click', function (e) {
            // Prevent default button action
            e.preventDefault();

            const packets = {
                handle:  $(this).data('handle'),
                class:  $(this).data('class'),
                token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
            };

            axios.post("<?= route_to('module-update-ajax') ?>", packets)
            .then( response => {
                toastr.success(response.data.messages.success, _LANG_.updated + "!"); // Notif
                Ci4DataTables["kt_table_module-table"].ajax.reload();
            })
            .catch(error => {}); 
            
        });
    }

    var initSyncBdd = () => {

        window.jQuery('[data-kt-module-sync="bdd"]').on('click', function (e) {
            // Prevent default button action
            e.preventDefault();

            const packets = {
                id:  $(this).data('id'),
                token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
            };
            axios.post("<?= route_to('module-sync-bdd') ?>", packets)
            .then( response => {
                toastr.success(response.data.messages.success, _LANG_.updated + "!"); // Notif
                Ci4DataTables["kt_table_module-table"].ajax.reload();
            })
            .catch(error => {}); 
            
        });
    }


    return {
        // Public functions  
        init: function () {
            if (!table) {
                return;
            }

            initPermissionTable();
            initModuleEnableOrUnabled();
            initSyncBdd();

        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTModulesList.init();
});

</script>


<?= $this->endSection() ?>