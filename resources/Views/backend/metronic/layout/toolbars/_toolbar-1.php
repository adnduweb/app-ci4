<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class=" <?= service('theme')->printHtmlClasses('toolbar-container', false); ?> d-flex flex-stack">
        <?= $this->include('\Themes\backend\/'.$theme_admin.'/\layout\page-title\_default') ?>


		<!--begin::Actions-->
        <div class="d-flex align-items-center py-1">

            <?php if(!empty($page_header_toolbar_btn)){ ?>
                <?php foreach($page_header_toolbar_btn as $k => $toolbar_btn){ ?>
                    <!--begin:<?= cleanTitleDebug($k); ?>-->
                    <a type="button" class="btn btn-sm btn-<?= $toolbar_btn['color']; ?>  fw-bolder <?= (count($page_header_toolbar_btn) >1) ? 'me-4' : '' ; ?>" href="<?= $toolbar_btn['href']; ?>">
                        <?= $toolbar_btn['svg']; ?>                   
                        <?= $toolbar_btn['desc']; ?>
                    </a>
                    <!--end::<?= cleanTitleDebug($k); ?>-->
                <?php } ?>
            <?php } ?>

          

        </div>
        <!--end::Actions-->
 
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->
