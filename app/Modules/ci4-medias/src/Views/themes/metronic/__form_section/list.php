 <!--begin::Button-->
 <button type="button" data-kt-filemanager="croppedFile" data-uuid=<?= $form->getUUID(); ?> id="kt_modal_redimensionner" class="btn btn-primary me-3 select-image"> <?= ucfirst(lang('Core.redimensionner')); ?></button>
<!--end::Button-->

<!--begin::Table-->
<table class="table align-middle table-row-dashed fs-6 gy-5" data-uuid=<?= $form->getUUID(); ?> id="kt_table_media_dimensions">
    <!--begin::Table head-->
    <thead>
        <!--begin::Table row-->
        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
            <th class="min-w-125px" title="Name"><?= lang('Core.images'); ?></th>
            <th class="min-w-125px" title="Description"><?= lang('Core.tailles'); ?></th>
            <th class="min-w-125px" title="dimensions"><?= lang('Core.dimensions'); ?></th>
            <th class="min-w-125px" title="date"><?= lang('Core.date'); ?></th>
            <th class="text-end min-w-70px" title="Action"><?= lang('Core.date'); ?></th>

        </tr>
        <!--end::Table row-->
    </thead>
    <!--end::Table head-->

</table>
<!--end::Table-->