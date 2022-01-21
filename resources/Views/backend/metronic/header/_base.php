<!--begin::Header-->
<div id="kt_header" style="" class="header <?= service('theme')->printHtmlClasses('header', false); ?> align-items-stretch" <?= service('theme')->printHtmlClasses('header'); ?>>
	<!--begin::Container-->
	<div class="<?= service('theme')->printHtmlClasses('header-container', false); ?> d-flex align-items-stretch justify-content-between">
		<!--begin::Aside mobile toggle-->
		<?php  if (Config('Theme')->layout['aside']['display'] == true){ ?>
			<div class="d-flex align-items-center d-lg-none ms-n3 me-1" data-bs-toggle="tooltip" title="Show aside menu">
				<div class="btn btn-icon btn-active-light-primary" id="kt_aside_mobile_toggle">
					<?= service('theme')->getSVG("icons/duotone/Text/Menu.svg", "svg-icon-2x mt-1"); ?>
				</div>
			</div>
		<?php } ?>
		<!--end::Aside mobile toggle-->

		<?php  if (Config('Theme')->layout['aside']['display'] == false){ ?>
			<!--begin::Logo-->
			<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-15">
				<a href="<?= site_url(); ?>">
					<img alt="Logo" src="<?= assetAdmin('/media/logos/logo-2-dark.svg'); ?>" class="h-35px"/>
				</a>
			</div>
			<!--end::Logo-->
		<?php }else{ ?>
			<!--begin::Mobile logo-->
			<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
				<a href="<?= site_url(); ?>" class="d-lg-none">
					<img alt="Logo" src="<?= assetAdmin('/media/logos/logo-1-dark.svg'); ?>" class="h-15px"/>
				</a>
			</div>
			<!--end::Mobile logo-->
		<?php } ?>

		<!--begin::Wrapper-->
		<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
			<!--begin::Navbar-->
			<?php  if (Config('Theme')->layout['header']['left'] == 'menu'){ ?>
				<div class="d-flex align-items-stretch" id="kt_header_nav">
					<?=  $this->include('\Themes\backend\/'.$theme_admin.'/\header\_menu'); ?>
				</div>
			<?php }elseif(Config('Theme')->layout['header']['left']=== 'page-title'){ ?>
				<div class="d-flex align-items-center" id="kt_header_nav">
					<?=  $this->include('\Themes\backend\/'.$theme_admin.'/\page-title\_' . Config('Theme')->layout['page-title']['layout']); ?>
				</div>
			<?php } ?>
			<!--end::Navbar-->

			<!--begin::Topbar-->
	        <div class="d-flex align-items-stretch flex-shrink-0">
				<?=  $this->include('\Themes\backend\/'.$theme_admin.'/\topbar\_base'); ?>
			</div>
			<!--end::Topbar-->
		</div>
		<!--end::Wrapper-->
	</div>
	<!--end::Container-->
</div>
<!--end::Header-->
