<!--begin::Main-->
<?php if (Config('Theme')->layout['main']['type'] === 'blank'){ ?>
    <div class="d-flex flex-column flex-root">
    <?= $slot ; ?>
    </div>
    <?php }else{?>
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
        <?php if (Config('Theme')->layout['aside']['display'] === true){ ?>
            <?= $this->include('\Themes\backend\/'.$theme_admin.'/\aside\_base') ?>
        <?php } ?>

        <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            <?= $this->include('\Themes\backend\/'.$theme_admin.'/\header\_base') ?>

          

            <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            
                <?php if (Config('Theme')->layout['toolbar']['display'] === true){ ?>
                    <?= $this->include('\Themes\backend\/'.$theme_admin.'/\toolbars\_' . Config('Theme')->layout['toolbar']['layout']) ?>
                <?php } ?>

                <?= $this->include('\Themes\backend\/'.$theme_admin.'/\partials\extras\_notice') ?>

                <!--  -->

                <!--begin::Post-->
                    <div class="post fs-base d-flex flex-column-fluid" id="kt_post">
                        <?= $this->include('\Themes\backend\/'.$theme_admin.'/\content\_' . Config('Theme')->layout['content']['layout']) ?>
                    </div>
                    <!--end::Post-->
                </div>
                <!--end::Content-->

                <?= $this->include('\Themes\backend\/'.$theme_admin.'/\_footer') ?>
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->
    <?php if (Config('Theme')->layout['scrolltop']['display'] === true){ ?>
        <?= $this->include('\Themes\backend\/'.$theme_admin.'/\_scrolltop') ?>
    <?php } ?>
<?php } ?>
    <!--end::Main-->


