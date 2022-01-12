<?php 

use \Adnduweb\Ci4Admin\Libraries\Theme;

?>
<?= $this->extend('Themes\backend\metronic\layout\admin') ?>
<?= $this->section('main') ?>

<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">

	<div id="kt_content_permissions" class="container-xxl">
		<!--begin::About card-->
		<div class="card">
			<!--begin::Body-->
			<div class="card-body p-lg-17">
				<!--begin::About-->
				<div class="mb-18">
					<!--begin::Description-->
					<div class="fs-5 fw-bold text-gray-600">
						<?= $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\groups\__form_section\general') ?>
					</div>
					<!--end::Description-->

					<?php if (isset($form->id)) { ?>
						<?php if ($form->id == '1') { ?>
							<div class="alert alert-elevate alert-light alert-bold" role="alert">
								<div class="alert-text"><?= lang('Core.all_access_permissions'); ?></div>
							</div>
						<?php } else {  ?>
							<?= $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\groups\__form_section\permissions') ?>
						<?php }  ?>
					<?php } else { ?>
						<div class="alert alert-elevate alert-light alert-bold" role="alert">
							<div class="alert-text"><?= lang('Core.allow_save_after_show'); ?></div>
						</div>
					<?php }  ?>

				</div>
				<!--end::About-->
			</div>
			<!--end::Body-->
		</div>
		<!--end::About card-->
	</div>

</div>
<?= $this->endSection() ?>
