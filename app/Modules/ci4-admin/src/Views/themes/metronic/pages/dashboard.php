<?= $this->extend('Themes\backend\metronic\layout\admin') ?>
<?= $this->section('main') ?>


<!--begin::Notice-->
<div class="d-flex align-items-center rounded border-info border border-dashed rounded-3 py-5 px-4 bg-light-info ">
   <!--begin::Icon-->  
   <div class="d-flex h-80px w-80px flex-shrink-0 flex-center position-relative ms-3 me-6">
        <?= service('theme')->getSVG("icons/duotone/Layout/Layout-polygon.svg", "svg-icon svg-icon-info position-absolute opacity-10"); ?>
        <?= service('theme')->getSVG("duotune/art/art006.svg", "svg-icon svg-icon-3x svg-icon-info  position-absolute"); ?>
         
   </div>
   <!--end::Icon-->  <!--begin::Description-->      
   <div class="text-gray-700 fw-bold fs-6 lh-lg">Information! <br> Vous retrouverez toutes les informations importantes sur votre tableau de bord</div>
   <!--end::Description-->
</div>
<!--end::Notice-->

<?= $this->endSection() ?>