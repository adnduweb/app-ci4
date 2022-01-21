<?= $this->extend('Themes\backend\metronic\admin') ?>
<?= $this->section('main') ?>
<div class="row g-5 g-xl-8">
    <!--begin::Col-->
    <div class="col-xl-6">
        <!--begin::Tables Widget 1-->
        <div class="card card-xl-stretch mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Environnement</span>
                </h3>
            </div>

            <div class="card-body py-3">
                <?php foreach ($envs as $env) { ?>
                    <?php if ($env['name'] == 'Cache driver') { ?>
                        <a href="#" class="btn btn-primary er fs-6 px-8 py-4" data-bs-toggle="modal" data-bs-target="#kt_modal_view_cache"> <?= $env['name']; ?> | <?= $env['value'][0]; ?></a>
                        <?= view('Adnduweb\Ci4Admin\themes\metronic\pages\informations\_modals\_kt_modal_view_cache', ['env' => $env]) ?>    
                       
                    <?php } else { ?>
                        <div class="d-flex align-items-center flex-wrap mb-10">
                            <div class="symbol symbol-50 symbol-light mr-5 me-2">
                                <span class="symbol-label">
                                    <?= $env['name'][0]; ?><?= $env['name'][1]; ?>
                                </span>
                            </div>
                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                <span class="text-dark fw-bolder text-hover-primary mb-1 fs-6"><?= $env['name']; ?></span>
                            </div>
                            <span class="label label-xl label-light label-inline my-lg-0 my-2 text-dark-50 font-weight-bolder"><?= (!empty($env['value'])) ? word_limiter($env['value'], 5) : ''; ?></span>
                        </div>
                    <?php } ?>

                <?php } ?>

            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <!--begin::Tables Widget 2-->
        <div class="card card-xl-stretch mb-5 mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Dépendances</span>
                </h3>
            </div>

            <div class="card-body">
                <?php foreach ($dependencies as $k => $v) { ?>
                    <div class="d-flex align-items-center flex-wrap mb-10">
                            <div class="symbol symbol-50 symbol-light mr-5 me-2">
                                <span class="symbol-label">
                                    <?= $k[0]; ?><?= $k[1]; ?>
                                </span>
                            </div>
                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                <span class="text-dark fw-bolder text-hover-primary mb-1 fs-6"><?= $k; ?></span>
                            </div>
                            <a target="_blank" href="https://github.com/<?= $k; ?>" class="label label-xl label-light label-inline my-lg-0 my-2 text-dark-50 font-weight-bolder"><?= $v; ?></a>
                        </div>

                        
                <?php } ?>

            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>