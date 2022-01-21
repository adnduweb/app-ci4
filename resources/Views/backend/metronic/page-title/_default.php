<?php
   // $breadcrumb = \Adnduweb\Ci4Admin\Libraries\Init::getBreadcrumb();
   $breadcrumb = [];

    if (Config('Theme')->layout['page-title']['direction'] === 'column') {
        $baseClass = 'flex-column align-items-start me-3';
    } else {
        $baseClass = 'align-items-center me-3';
    }

    $attr = array();
    if (Config('Theme')->layout['toolbar']['fixed']['desktop'] === true && Config('Theme')->layout['toolbar']['fixed']['tablet-and-mobile'] === true &&  Config('Theme')->layout['page-title']['responsive'] === true) {
        $baseClass .= " flex-wrap mb-5 mb-lg-0 lh-1";
    }
?>

<!--begin::Page title-->
<div  <?= service('theme')->printHtmlAttributes('page-title'); ?> class="d-flex <?= $baseClass; ?>">
    <!--begin::Title-->
    <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-4 lh-1">
    <?= $titleToolbar; ?>

        <?php  if (isset(Config('Theme')->layout['page']['description']) && Config('Theme')->layout['page-title']['description']  === true ) { ?>
        <!--begin::Separator-->
            <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
            <!--end::Separator-->

            <!--begin::Description-->
            <small class="text-muted fs-7 fw-bold my-1 ms-1">
                <?= Config('Theme')->layout['page']['description']; ?>
            </small>
            <!--end::Description-->
        <?php } ?>
    </h1>
    <!--end::Title-->

<?php  if (Config('Theme')->layout['page-title']['breadcrumb'] === true && !empty($breadcrumbs)) { ?>
    <?php  if (Config('Theme')->layout['page-title']['direction'] === 'row') { ?>
        <!--begin::Separator-->
            <span class="h-20px border-gray-200 border-start mx-4"></span>
            <!--end::Separator-->
    <?php } ?>

    <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
             <?php echo $breadcrumbs; ?>
        </ul>
        <!--end::Breadcrumb-->
    <?php } ?>
</div>
<!--end::Page title-->
