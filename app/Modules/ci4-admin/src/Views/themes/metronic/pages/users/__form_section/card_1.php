<!--begin::Card-->
<div class="card mb-5 mb-xl-8 card_1">

    <!--begin::Card body-->
    <div class="card-body">
        <!--begin::Summary-->
        <!--begin::User Info-->
        <div class="d-flex flex-center flex-column py-5">
            <!--begin::Avatar-->
            <div class="symbol symbol-100px symbol-circle mb-7">
                <span class="symbol-label fs-3 bg-light-danger text-danger"><?= $form->lastname[0]; ?> <?= $form->firstname[0]; ?></span>
            </div>
            <!--end::Avatar-->
            <!--begin::Name-->
            <span href="#" class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-3 fullname"><?= $form->lastname; ?> <?= $form->firstname; ?></span>
            <!--end::Name-->
            <!--begin::Position-->
            <div class="mb-9">
                <!--begin::Badge-->
                <div class="badge badge-lg badge-light-primary d-inline"><?= ucwords($form->setAuthGroupsUsers()[0]->group->name); ?></div>
                <!--begin::Badge-->
            </div>
            <!--end::Position-->
        </div>
        <!--end::User Info-->
        <!--end::Summary-->
        <!--begin::Details toggle-->
        <div class="d-flex flex-stack fs-4 py-3">
            <div class="fw-bolder rotate collapsible collapsed"><?= lang('Core.details'); ?> </div>
            <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="" data-bs-original-title="<?= lang('Core.Edit customer details'); ?>'">
                <a href="#" class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_update_details"><?= lang('Core.Edit'); ?></a>
            </span>
        </div>
        <!--end::Details toggle-->
        <div class="separator"></div>
        <!--begin::Details content-->
        <div id="kt_user_view_details" class="">
            <?= view('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\_partials\_kt_user_view_details', ['form' => $form]) ?>
        </div>
        <!--end::Details content-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->


<?= $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\users\__modals\_update_details') ?>