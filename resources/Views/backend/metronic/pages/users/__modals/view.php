<?php use \Adnduweb\Ci4Admin\Libraries\Theme;?>
<!-- Modal -->
<div class="modal fade modal_client_<?= $user->id; ?>" id="kt_modal_loading" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle"><?= ucfirst(lang('Core.fiche_user')); ?> </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">


				<div class="">
					<div class="kt-portlet__body">
						<div class="kt-widget kt-widget--user-profile-3">
							<div class="d-flex">
								<div class="flex-shrink-0 mr-7">
									<div class="symbol symbol-50 symbol-lg-120 symbol-light-danger">
										<span class="font-size-h1 symbol-label symbol-text font-weight-boldest"><?= $user->firstname[0]; ?> <?= $user->lastname[0]; ?></span>
									</div>
								</div>
								<div class="kt-widget__content">
									<div class="kt-widget__head">
										<?php if (!empty($user->email) && !empty($user->phone) && !empty($user->phone_mobile)) {
										?>
											<a href="/<?= env('CI_AREA_ADMIN'); ?>/settings-advanced/users/detail/<?= $user->uuid; ?>" class="kt-widget__username">
												<?= $user->firstname; ?> <?= $user->lastname; ?>
											</a>
											<i class="flaticon2-correct"></i>
											<?= $user->uuid; ?>
										<?php
										} else {
										?>
											<a href="/<?= env('CI_AREA_ADMIN'); ?>/settings-advanced/users/detail/<?= $user->uuid; ?>" data-toggle="tooltip" title="" data-placement="top" data-original-title="<?= lang('Core.manque_info_account'); ?>" class="kt-widget__username tooltip-test">
												<?= $user->firstname; ?> <?= $user->lastname; ?>
												<i class="manque_data flaticon2-information"></i>
											</a>
										<?php
										} ?>
										<div class="kt-widget__action">
											<?php foreach ($user->auth_groups_users as $auth_groups_user) { ?>
												<button type="button" class="btn btn-default btn-sm btn-upper"><?= $auth_groups_user->group->name; ?></button>&nbsp;
											<?php } ?>
										</div>
									</div>

									<div class="d-flex flex-wrap my-2">
										<a class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2" href="javascript:;">
											<?= Theme::getSVG('media/svg/icons/Communication/Mail.svg', 'svg-icon svg-icon-sm', true); ?> 
											<?= $user->email; ?>
										</a>
										<a class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2" href="javascript:;">
											<?= Theme::getSVG('media/svg/icons/Communication/Address-card.svg', 'svg-icon svg-icon-sm', true); ?> 
											<?= $user->fonction; ?> 
										</a>

									</div>

									<div class="kt-widget__info">
										<div class="kt-widget__desc">
											<?php if (!empty($user->extrait)) {
											?>
												<em><?= $user->extrait; ?></em>
											<?php
											} else {
											?>
												<em><?= lang('Core.pas_de_description'); ?></em>
											<?php
											} ?>
										</div>

									</div>

									<div class="kt-widget__subhead">
										<?php if (empty($user->phone)) {
										?>
											<a class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2" href="#">
												<?= Theme::getSVG('media/svg/icons/Devices/iPhone-back.svg', 'svg-icon svg-icon-sm', true); ?> 
												<?= lang('Core.nc'); ?>
											</a>
										<?php
										} else {
										?>
											<a class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2" href="tel:<?= $user->phone; ?>">
												<?= Theme::getSVG('media/svg/icons/Devices/iPhone-back.svg', 'svg-icon svg-icon-sm', true); ?> 
												<?= $user->phone; ?>
											</a>
										<?php
										} ?>

										<?php if (empty($user->phone_mobile)) {
										?>
											<a class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2" href="#">
												<?= Theme::getSVG('media/svg/icons/Devices/iPhone-back.svg', 'svg-icon svg-icon-sm', true); ?> 
												<?= lang('Core.nc'); ?>
											</a>
										<?php
										} else {
										?>
											<a class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2" href="tel:<?= $user->phone_mobile; ?>">
												<?= Theme::getSVG('media/svg/icons/Devices/iPhone-back.svg', 'svg-icon svg-icon-sm', true); ?> 
												<?= $user->phone_mobile; ?>
											</a>
										<?php
										} ?>
									</div>
								</div>

							</div>
							<div class="separator separator-solid separator-border-2 mt-5 mb-5"></div>
							<div class="kt-widget__bottom">
								<h3 style="width:100%;margin-top:15px;"><?= ucfirst(lang('Core.last_connexion')); ?></h3>
								<div class="kt-list-timeline" style="padding:25px;">
									<div class="kt-list-timeline__items">
									<?= $this->include('Themes\backend\metronic\templates\users\__partials\lastconnexion') ?>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('Core.close'); ?></button>
				</div>
			</div>
		</div>
	</div>