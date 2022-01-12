<?php use \Adnduweb\Ci4Admin\Libraries\Theme; ?>
<?= $this->extend('Themes\backend\metronic\layout\admin') ?>
<?= $this->section('main') ?>

<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">

	<?= form_open('', ['id' => 'kt_apps_user_'.$action.'_user_form', 'class' => 'kt_apps_user_form', 'novalidate' => false]); ?>
	<input type="hidden" name="action" value="<?= $action; ?>" />

	<?php if (Config('Theme')->layout['subheader']['display_form']){ ?>
		<?= $this->include('Themes\backend\/'.$theme_admin.'/\layout\partials\subheader\/_' . Config('Theme')->layout['subheader']['layout_form']) ?>
	<?php } ?>

	<!-- begin:: Content -->
	<div id="ContentUsers" class="d-flex flex-column-fluid">
		<!--Begin::App-->
		<div class="container-fluid">
			<div class="flex-row ">
				<div class="card card-custom py-5 px-5">
					<ul class="nav nav-tabs nav-tabs-line mb-5" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="<?= base_url(uri_string()); ?>#kt_user_edit_tab_1" role="tab">
								<?= Theme::getSVG('media/svg/icons/Design/Layers.svg', 'svg-icon svg-icon-sm', true); ?> 
							 	<?= lang('Core.tab_profile'); ?>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="<?= base_url(uri_string()); ?>#kt_user_edit_tab_4" role="tab">
								<?= Theme::getSVG('media/svg/icons/Design/Layers.svg', 'svg-icon svg-icon-sm', true); ?> 
							 	<?= lang('Core.tab_settings'); ?>
							</a>
						</li>
						<?php if (has_permission('Users::views', user()->id) == true) { ?>
							<?php if (isset($form->id)) { ?>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="<?= base_url(uri_string()); ?>#kt_user_edit_tab_5" role="tab">
										<?= Theme::getSVG('media/svg/icons/Design/Layers.svg', 'svg-icon svg-icon-sm', true); ?> 
									 	<?= lang('Core.tab_permissions'); ?>
									</a>
								</li>
							<?php } ?>
						<?php } ?>
					</ul>

					<div class="tab-content mt-5">
						<div class="tab-pane active" id="kt_user_edit_tab_1" role="tabpanel">
							<div class="kt-form kt-form--label-right">
								<div class="kt-form__body">
									<div class="kt-section kt-section--first">
										<div class="kt-section__body">
											<?= $this->include('Themes\backend\metronic\pages\users\__form_section\profile') ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="kt_user_edit_tab_4" role="tabpanel">
							<div class="kt-form kt-form--label-right">
								<div class="kt-form__body">
									<?= $this->include('Themes\backend\metronic\pages\users\__form_section\settings') ?>
								</div>
							</div>
						</div>
						<?php if (has_permission('Users::views', user()->id) == true) { ?>
							<?php if (isset($form->id)) { ?>
								<div class="tab-pane" id="kt_user_edit_tab_5" role="tabpanel">
									<div class="kt-form kt-form--label-right">
										<div class="kt-form__body">
											<?= $this->include('Themes\backend\metronic\pages\users\__form_section\permissions') ?>
										</div>
									</div>
								</div>
							<?php } ?>
						<?php } ?>
					</div>

				</div>
			</div>

		</div>
	</div>
	<!-- end:: Content -->
	<?= form_close(); ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('page_toolbar_left') ?>

	<?= $this->include('Themes\backend\metronic\layout\partials\extras\_save_form_button') ?>

<?= $this->endSection() ?>