
	<?php if (empty($medias)): ?>
	<p><?= lang('Medias.No medias to display'); ?></p>
	<?php else: ?>
	<div id="card-deck" class="card-deck d-flex row">

		<?php foreach ($medias as $media): ?>
		<div class="cardImage mb-4 col-lg-1 media-item" data-kt-filemanager="selectMedia" data-kt-filemanager-uuid-media="<?= $media->getUUID() ; ?>" data-kt-filemanager-id-media="<?= $media->getID() ; ?>" data-kt-filemanager-url-image="<?= $media->getUrlMedia('medium') ; ?>"> 
			<div class="bgi-no-repeat bgi-size-cover rounded min-h-180px w-100 w-180px h-150px mr-5 mb-1 mb-md-0 bg-primary-o-10">
				<div class="attachment-preview js--select-attachment subtype-<?= $media->getExtension(); ?> <?= $media->getOrientation(); ?>">
					<div class="thumbnail">
						<div class="centered">
							<div class="card-toolbar">
								<a href="javascript:;" data-uuid-media="<?= $media->uuid ; ?>" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-card-tool="toggle">
									<i class="la la-pencil icon-nm"></i>
								</a>
								<a href="#" data-imagemanager="reload" data-uuid="<?= $media->getUuid(); ?>" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow deletemediaMedia" data-card-tool="remove">
									<i class="la la-close icon-nm"></i>
								</a>
							</div>
							<img data-uuid-media="<?= $media->uuid ; ?>" src="<?= $media->getThumbnail() ?>" class="card-img-top img-thumbnail select-image" alt="<?= $media->medianame ?>">
						</div>
						<?php if ($media->getName()) { ?>
								<div class="namemedia"><?= $media->getName(); ?></div>
							<?php } ?>
							<?php if ($media->getOrientation() == 'square') { ?>
								<div class="namemedia"><?= $media->filename; ?></div>
							<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>

	</div>
	<?php endif; ?>
