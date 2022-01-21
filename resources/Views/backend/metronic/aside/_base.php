<?php $logoFileName = 'logo-ADN.svg'; ?>
 <?php  if (Config('Theme')->layout['aside']['theme'] == 'light'){ ?>
     <?php $logoFileName = 'logo-1-dark.svg'; ?>
 <?php } ?>
 
 <!--begin::Aside-->
 <div
     id="kt_aside"
     class="aside <?= service('theme')->printHtmlClasses('aside', false); ?>"
     data-kt-drawer="true"
     data-kt-drawer-name="aside"
     data-kt-drawer-activate="{default: true, lg: false}"
     data-kt-drawer-overlay="true"
     data-kt-drawer-width="{default:'200px', '300px': '250px'}"
     data-kt-drawer-direction="start"
     data-kt-drawer-toggle="#kt_aside_mobile_toggle"
 >
 
    <!--begin::Brand-->
     <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <!--begin::Logo-->
         <a href="<?= route_to('dashboard'); ?> ">
             <img alt="Logo" src="<?= assetAdmin('/media/logos/' . $logoFileName); ?>" class="h-35px logo"/>
         </a>
        <!--end::Logo-->
         <?php  if (Config('Theme')->layout['aside']['minimize'] == true){ ?>
            <!--begin::Aside toggler-->
             <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle"
                  data-kt-toggle="true"
                  data-kt-toggle-state="active"
                  data-kt-toggle-target="body"
                  data-kt-toggle-name="aside-minimize" 
                  data-kt-url="<?= route_to('settings-update-user') ; ?>?asideToogle=true"
             >
 
                 <?= service('theme')->getSVG("icons/duotone/Navigation/Angle-double-left.svg", "svg-icon-1 rotate-180"); ?>
             </div>
            <!--end::Aside toggler-->
            <?php } ?>
     </div>
    <!--end::Brand-->
 
    <!--begin::Aside menu-->
     <div class="aside-menu flex-column-fluid">
         <?=  $this->include('\Themes\backend\/'.$theme_admin.'/\aside\_menu'); ?>
     </div>
    <!--end::Aside menu-->
 
    <!--begin::Footer-->
     <div class="aside-footer flex-column-auto pt-5 pb-7 px-5" id="kt_aside_footer">
         <?php if(service('theme')->isDocumentationMenu()){ ?>
             <a href="<?= site_url(); ?> " class="btn btn-primary w-100"> <?= lang('Core.Preview Application'); ?></a>
         <?php }else{ ?>
                 <a href="<?= current_url(); ?> " class="btn btn-custom btn-primary w-100" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-delay-show="8000" title="Check out the complete documentation with over 100 components">
             <span class="btn-label">
                 <?= lang('Core.Documentation'); ?>
             </span>
                 <?= service('theme')->getSVG("icons/duotone/General/Clipboard.svg", "btn-icon svg-icon-2"); ?>
             </a>
         <?php } ?>
     </div>
    <!--end::Footer-->
 </div>
 <!--end::Aside-->