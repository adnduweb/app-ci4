<?php 

use \Adnduweb\Ci4Admin\Libraries\Theme;

?>
<?= $this->extend('Themes\backend\metronic\admin') ?>
<?= $this->section('main') ?>

<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">

	<div id="kt_content_users" class="container-xxl">
		<!--begin::About card-->
		<div class="card">
			<!--begin::Body-->
			<div class="card-body p-lg-17">
				<!--begin::About-->
				<div class="mb-18">
					<!--begin::Description-->
					<div class="fs-5 fw-bold text-gray-600">
						<?= $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\new') ?>
					</div>
					<!--end::Description-->
				</div>
				<!--end::About-->
			</div>
			<!--end::Body-->
		</div>
		<!--end::About card-->
	</div>

</div>
<?= $this->endSection() ?>
