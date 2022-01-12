<?php
    // List items
    $listRows = array(
        array(
            'color' => 'warning',
            'icon' => 'icons/duotone/Home/Library.svg',
            'title' => 'Group lunch celebration',
            'text' => 'Due in 2 Days',
            'number' => '+28%'
        ),
        array(
            'color' => 'success',
            'icon' => 'icons/duotone/Communication/Write.svg',
            'title' => 'Navigation optimization',
            'text' => 'Due in 2 Days',
            'number' => '+50%'
        ),
        array(
            'color' => 'danger',
            'icon' => 'icons/duotone/Communication/Group-chat.svg',
            'title' => 'Rebrand strategy planning',
            'text' => 'Due in 5 Days',
            'number' => '-27%'
        ),
        array(
            'color' => 'info',
            'icon' => 'icons/duotone/Communication/Group-chat.svg',
            'title' => 'Product goals strategy',
            'text' => 'Due in 7 Days',
            'number' => '+8%'
        )
    );
?>

<!--begin::List Widget 6-->
<div class="card <?= $class; ?>">
    <!--begin::Header-->
    <div class="card-header border-0">
        <h3 class="card-title fw-bolder text-dark">Notifications</h3>

        <div class="card-toolbar">
            <!--begin::Menu-->
            <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                <?= service('theme')->getSVG("icons/duotone/Layout/Layout-4-blocks-2.svg", "svg-icon-2"); ?>
            </button>
            <?= $this->include('\Themes\backend\/'.$theme_admin.'/\partials\menus\_menu-3') ?>
            <!--end::Menu-->
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body pt-0">
        <?php foreach ($listRows as $row){ ?>
            <!--begin::Item-->
            <div class="d-flex align-items-center bg-light-<?= $row['color']; ?> rounded p-5 mb-7">
                <!--begin::Icon-->
                <span class="svg-icon svg-icon-<?= $row['color']; ?> me-5">
                    <?= service('theme')->getSVG("icons/duotone/Home/Library.svg", "svg-icon-1"); ?>

                </span>
                <!--end::Icon-->

                <!--begin::Title-->
                <div class="flex-grow-1 me-2">
                    <a href="#" class="fw-bolder text-gray-800 text-hover-primary fs-6"><?= $row['title']; ?></a>

                    <span class="text-muted fw-bold d-block"><?= $row['text']; ?></span>
                </div>
                <!--end::Title-->

                <!--begin::Lable-->
                <span class="fw-bolder text-<?= $row['color']; ?> py-1"><?= $row['number']; ?></span>
                <!--end::Lable-->
            </div>
            <!--end::Item-->
        <?php } ?>
    </div>
    <!--end::Body-->
</div>
<!--end::List Widget 6-->
