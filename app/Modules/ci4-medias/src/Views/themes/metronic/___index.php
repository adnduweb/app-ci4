<?= $this->extend('Themes\backend\metronic\admin') ?>
<?= $this->section('main') ?>
<div class="card ">


    <!-- begin:: Content -->
    <div id="ContentMedias" class="d-flex flex-column-fluid ">
		<div class="container-fluid">
			<div class="card card-custom gutter-b">
				<div class="card-body bg-light">
						<div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">				
							<div class="btn-group mr-2" role="group" aria-label="Action group">
								<button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#dropzoneCollapse" aria-expanded="false" aria-controls="dropzoneCollapse">
									<?= service('theme')->getSVG('duotone/Design/Flatten.svg', "svg-icon svg-icon-2"); ?>
									<?= lang('Medias.add_media'); ?>
								</button>
								<a type="button" class="btn btn-icon btn-danger" href="<?= base_url(CI_AREA_ADMIN . '/medias/removeall'); ?>">
									<?= service('theme')->getSVG('duotone/Home/Trash.svg', "svg-icon svg-icon-2"); ?>
								</a>
							</div>
						</div>

						<h1><?= lang('Medias.manage_of_files'); ?></h1>

						<?= view('Adnduweb\Ci4Medias\Views\themes\metronic\Dropzone\zone') ?>


						<!-- <form class="form-inline mb-3" name="files-search" method="get" action="<?= current_url() ?>">
							<div class="input-group">
								<input name="search" type="search" class="form-control" id="files-search" placeholder="Search" value="<?= $search ?>">
								<div class="input-group-append">
									<button type="submit" class="btn btn-primary">Search</button>
								</div>
							</div>
						</form> -->

						


						<div id="files-wrapper">
							<?php if (empty($files)): ?>
							<!-- <p>
								You have no files! Would you like to
								<a class="dropzone-button" href="<?= site_url('files/new') ?>" data-toggle="modal" data-target="#dropzoneModal">add some now</a>?
							</p> -->
							<div id="imageManager"></div>

							<?php else: ?>

							
							<div id="imageManager">
								<?= view('Adnduweb\Ci4Medias\Views\themes\metronic\Forms\files') ?>
							</div>
							
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?= view('Adnduweb\Ci4Medias\Views\themes\metronic\Dropzone\modal') ?>

	<!-- begin::Outils de gestion de média -->
	<div id="imageManager_edition" class="imageManager_edition"></div>
	<!-- end::Outils de gestion de média -->

<?= $this->endSection() ?>
<?= $this->section('AdminAfterExtraJs') ?>

	<?= view(config('Medias')->views['dropzone']) ?>

<?= $this->endSection() ?>
