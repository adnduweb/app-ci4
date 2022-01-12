<?php use \Adnduweb\Ci4Admin\Libraries\Theme; ?>
<?= $this->extend('\Themes\backend\metronic\layout\admin') ?>
<?= $this->section('main') ?>


<div id="kt_content_container" class="container-xxl">
	<!--begin::Layout-->
	<div class="d-flex flex-column flex-xl-row">
		<!--begin::Sidebar-->
		<div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">

			<?= $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\card_1') ?>
			
		</div>
		<!--end::Sidebar-->
		<!--begin::Content-->
		<div class="flex-lg-row-fluid ms-lg-15">

			<?= $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\tabs') ?>
			
			<!--begin:::Tab content-->
			<div class="tab-content" id="myTabContent">
				
			<?= '' ; //$this->include('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\general') ?>

			<?=  $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\security') ?>

			<?=  $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\events') ?>

			<?=  $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\users\__form_section\permissions') ?>

			
			</div>
			<!--end:::Tab content-->
		</div>
		<!--end::Content-->
	</div>
	<!--end::Layout-->

</div>

<?= $this->endSection() ?>