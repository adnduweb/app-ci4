<?= $this->extend('\Themes\backend\metronic\admin') ?>
<?= $this->section('main') ?>


    <div id="kt_translate" class="d-flex flex-column-fluid">

        <div class="container-fluid">
            <div class="flex-row ">
                <div class="card card-custom gutter-b">
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

                                <?php if ($allow_import == true) { ?>
                                    <?= $this->include('\Themes\backend\metronic\partials\extras\_import_data') ?>
                                <?php } ?>

                                <?php if ($allow_export == true) { ?>
                                    <?= $this->include('\Themes\backend\metronic\partials\extras\_export_data') ?>
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
                    <div class="card-body">

                    <?= service('Tools')->notice(lang('Core. This is a very important notice! <br/> You must choose the language in the select chmaps before exporting or importing a file '), 'info'); ?>
                        <div class="py-2">
                            <?= form_open('', ['id' => 'search_translate', 'class' => 'kt-form', 'novalidate' => false]); ?>
                                <!--begin::Input group-->
                                <div class="fv-row mb-5">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold mb-2"><?= ucfirst(lang('Core.choisir_langue')); ?>* : </label>
                                    <select data-translate-select="select" required name="lang" aria-label="Select a Language" data-placeholder="Select a Language..." data-allow-clear="true" class="form-select form-select-solid fw-bolder selectFilePicker" id="lang">
                                        <?php foreach (Config('App')->supportedLocales as $file) { ?>
                                            <option value="<?= $file; ?>"><?= ucfirst($file); ?></option>
                                        <?php } ?>
                                    </select>
                                    <input type="hidden" class="select_lang_result">
                                </div>
                                 <!--begin::Input group-->
                                 <div class="fv-row mb-5">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold mb-2"><?= ucfirst(lang('Core.rechercher_dans_core')); ?>* : </label>
                                    <select data-translate-select="select" required name="fileCore" aria-label="Select a file"  data-placeholder="Select a file..." class="form-select form-select-solid fw-bolder selectFilePicker fileCore file" data-actions-box="true" title="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>" id="fileCore">
                                    <option></option>
                                        <?php foreach ($filesCore as $file) { ?>
                                            <option value="<?= $file; ?>"><?= ucfirst(str_replace('.php', '', $file)); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                 <!--begin::Input group-->
                                 <div class="fv-row mb-5">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold mb-2"><?= ucfirst(lang('Core.rechercher_dans_themes')); ?>* : </label>
                                    <select data-translate-select="select" required name="fileTheme" aria-label="Select a file" data-placeholder="Select a file..." class="form-select form-select-solid fw-bolder selectFilePicker fileTheme file" data-actions-box="true" title="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>" id="fileTheme">
                                        <?php foreach ($filesThemesFront as $file) { ?>
                                            <option value="<?= $file; ?>"><?= ucfirst(str_replace('.php', '', $file)); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
       
                            <?= form_close(); ?>

                            </div>
                    </div>
                    <!--end: Datatable -->
                    <div id="response" class=" px-5"></div>
                </div>
                
            </div>
       
        </div>
    <?= $this->endSection() ?>

<?= $this->section('AdminAfterExtraJs') ?>

<script type="text/javascript">

var KTTranslate = function () {

    var element = document.getElementById('kt_translate');
    var selectFilePicker;

    var initRepeater = function () {
        $("#kt_repeater_1").repeater({
            initEmpty: !1,
            show: function() {
                btnSaveTranslate();
                btnDeleteTranslate();
                searchData();
                $(this).slideDown();
            },
            hide: function(e) {
                confirm("Are you sure you want to delete this element?") && $(this).slideUp(e)
            },
            isFirstItemUndeletable: true,
        });
    }


    var initTranslate = function () {
        //console.log('dfsgsdgsdgsd');

        const selectFilePicker = element.querySelectorAll('[data-translate-select="select"]');
        var target = document.querySelector("#kt_translate .card");
        var blockUI = new KTBlockUI(target);

        var options = {
        dir: document.body.getAttribute('direction'),
        };

        $('.selectFilePicker').select2(options).on('change', function (e) {

            if ($(this).attr('name') == 'lang' && $(".selectFilePicker.fileTheme option").prop("selected") && $(".selectFilePicker.fileCore option ").prop("selected")) {
                 return false;
            }
            $("#searchDirect").val("");

            blockUI.block();

            const packets = {
                value:  $('form#search_translate').serializeArray(),
                token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
            };

            axios.post(current_url + "/getfile", packets)
            .then( response => {
                $('#response').html(response.data.html);
                initRepeater();
                blockUI.release();
                searchData();
                btnSaveTranslate();
                btnDeleteTranslate();
                
            })
            .catch(error => {
                blockUI.release();
                //console.log("ERROR:: ",error.response.data);
            });

        });

    }

    var btnSaveTranslate = function () {
        //console.log('dfsgsdgsdgsd');

        const selectFilePicker = element.querySelectorAll('[data-translate-select="select"]');
        const form = document.querySelector("#save_translate");
        const btnSave = element.querySelectorAll('[data-kt-translate-action="save_row"]');

        var target = document.querySelector("#kt_translate .card");
        var blockUI = new KTBlockUI(target);
       
        btnSave.forEach(d => {

            d.addEventListener('click', function (e) {
                e.preventDefault();

                blockUI.block();

                const packets = {
                    value:  $('form#save_translate').serializeArray(),
                    token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
                };

                axios.post("<?= route_to('translate-savefile'); ?>", packets)
                .then( response => {
                    toastr.success(response.data.messages.success, _LANG_.updated + "!"); // Notif
                    $('#response').html(response.data.html);
                    blockUI.release();
                })
                .catch(error => { blockUI.release(); });

            });
        });
    }

    var btnSaveTranslateText = function () {
        //console.log('dfsgsdgsdgsd');

        const selectFilePicker = element.querySelectorAll('[data-translate-select="select"]');
        const form = document.querySelector("#save_translate");
        const btnSave = element.querySelectorAll('[data-kt-translate-action="save_row"]');

        var target = document.querySelector("#kt_translate .card");
        var blockUI = new KTBlockUI(target);
       
        btnSave.forEach(d => {

            d.addEventListener('click', function (e) {
                e.preventDefault();

                blockUI.block();

                const packets = {
                    value:  $('form#save_translate').serializeArray(),
                    token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
                };

                axios.post("<?= route_to('translate-savetextfile'); ?>", packets)
                .then( response => {
                    toastr.success(response.data.messages.success, _LANG_.updated + "!"); // Notif
                    $('#response').html(response.data.html);
                    blockUI.release();
                })
                .catch(error => { blockUI.release(); });
            });
        });
    }

    var btnDeleteTranslate = function () {
        //console.log('dfsgsdgsdgsd');

        const selectFilePicker = element.querySelectorAll('[data-translate-select="select"]');
        const form = document.querySelector("#save_translate");
        const btnDelete = element.querySelectorAll('[data-kt-translate-action="delete_row"]');

        var target = document.querySelector("#kt_translate .card");
        var blockUI = new KTBlockUI(target);
       
        btnDelete.forEach(d => {

            d.addEventListener('click', function (e) {
                e.preventDefault();

                 // Select parent row
                 const parent = e.target.closest('.form-group.row');

                $(parent).remove();

                blockUI.block();

                const packets = {
                    value:  $('form#save_translate').serializeArray(),
                    token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
                };

                axios.post("<?= route_to('translate-deletetexte'); ?>", packets)
                .then( response => {
                    toastr.success(response.data.messages.success, _LANG_.updated + "!"); // Notif
                    $('#response').html(response.data.html);
                    blockUI.release();
                })
                .catch(error => { blockUI.release(); });
            });
        });
    }

    var searchData = function () {
        //console.log('dfsgsdgsdgsd');

        const selectFilePicker = element.querySelectorAll('[data-translate-select="select"]');
        const form             = document.querySelector("#save_translate");
        const filterSearch     = document.querySelector('[data-kt-translate-table-filter="search"]');
        const btnDelete        = element.querySelectorAll('[data-kt-translate-action="delete_row"]');

        var target  = document.querySelector("#kt_translate .card");
        var blockUI = new KTBlockUI(target);
       


        filterSearch.addEventListener('keyup', e => {
            e.preventDefault();

            if(filterSearch.value.length > 3) {

                blockUI.block();

                const packets = {
                    value:  filterSearch.value,
                    lang: $('#lang').val(),
                    search: true,
                    token: $('meta[name="X-CSRF-TOKEN"]').attr('content'),
                };

                axios.post("<?= route_to('translate-searchtexte'); ?>", packets)
                .then( response => {
                    toastr.success(response.data.messages.success, _LANG_.updated + "!"); // Notif
                    $('#response').html(response.data.html);
                    blockUI.release();
                    btnSaveTranslateText();
                })
                .catch(error => { blockUI.release(); });
            }

        });
    }

    return {
        // Public functions  
        init: function () {
            initRepeater();
            initTranslate();
            btnSaveTranslate();
            btnDeleteTranslate();
            searchData();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTTranslate.init();
});



</script>

<?= $this->endSection() ?>