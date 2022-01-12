<!--begin::Card-->
<div class="card mb-6 mb-xl-9 card_profile">

    <!--begin::Spinner-->
    <span class="spinner_card spinner_card_1 spinner-warning spinner-lg position-absolute lh-0 d-none" data-kt-search-element="spinner">
        <span class="spinner-border h-45px w-45px align-middle text-warning"></span>
    </span>
    <!--end::Spinner-->

    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title">
            <h2><?= lang('Core.Profile'); ?></h2>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0 pb-5">
        <!--begin::Table wrapper-->
        <div class="table-responsive">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed gy-5" id="kt_table_users_profile">
                <?= view('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\_partials\_kt_table_users_profile', ['form' => $form]) ?>
            </table>
            <!--end::Table-->
        </div>
        <!--end::Table wrapper-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->

<?= $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\users\__modals\_update_email') ?>
<?= $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\users\__modals\_update_password') ?>
<?= $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\users\__modals\_update_groups') ?>
<?= $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\users\__modals\_update_phone') ?>