<?= $this->extend('Themes\backend\metronic\auth') ?>
<?= $this->section('main') ?>
<!--begin::Authentication - Sign-in -->
	<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(<?= assetAdmin('/media/illustrations/progress-hd.png'); ?>)">
	<!--begin::Content-->
	<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
		<!--begin::Logo-->
		<a href="<?= current_url(); ?>" class="mb-12">
			<img alt="Logo" src="<?= assetAdmin('/media/logos/logo-ADN.svg'); ?>" class="h-65px" />
		</a>
		<!--end::Logo-->
		<!--begin::Wrapper-->
		<div class="w-lg-500px bg-white rounded shadow-sm p-10 p-lg-15 mx-auto">
			<!--begin::Form-->
			<?= form_open(route_to('login-area'), ['id' => 'kt_sign_in_form', 'class' => 'form form-login form w-100', 'novalidate' => 'novalidate']); ?>
				<!--begin::Heading-->
				<div class="text-center mb-10">
					<!--begin::Title-->
					<h1 class="text-dark mb-3"><?= lang("Core.sign_in"); ?></h1>
					<!--end::Title-->
					<?php if ($config->allowRegistration): ?>
					<!--begin::Link-->
					<div class="text-gray-400 fw-bold fs-4"><?= lang('Auth.New Here?') ?>
					<a href="/<?= CI_AREA_ADMIN; ?>/sign-up" class="link-primary fw-bolder"><?= lang('Auth.Create an Account') ?></a></div>
					<!--end::Link-->
					<?php endif; ?>
				</div>
				<?= view('Themes\backend\metronic\partials\message_block') ?>
				<!--begin::Heading-->
				
				<!--begin::Input group-->
				<div class="fv-row mb-10">
					<!--begin::Label-->
					<label class="form-label fs-6 fw-bolder text-dark"><?= lang("Core.your_email"); ?></label>
					<!--end::Label-->
					<!--begin::Input-->
					<input class="form-control form-control-lg form-control-solid" required type="text"  placeholder="<?= lang('Auth.emailOrUsername') ?>" name="login" autocomplete="off" value="" />
					<!--end::Input-->
				</div>
				<!--end::Input group-->
				<!--begin::Input group-->
				<div class="fv-row mb-10">
					<!--begin::Wrapper-->
					<div class="d-flex flex-stack mb-2">
						<!--begin::Label-->
						<label class="form-label fw-bolder text-dark fs-6 mb-0"><?= lang("Core.your_password"); ?></label>
						<!--end::Label-->
						<!--begin::Link-->
						<a href="/<?= CI_AREA_ADMIN; ?>/forgot-password" class="link-primary fs-6 fw-bolder"><?= lang('Auth.forgotYourPassword') ?></a>
						<!--end::Link-->
					</div>
					<!--end::Wrapper-->
					<!--begin::Input-->
					<input class="form-control form-control-lg form-control-solid" required type="password"  placeholder="<?= lang('Auth.password') ?>" name="password" value="">
					<!--end::Input-->
				</div>
				
				<!--end::Form group-->
				<?php if ($config->allowRemembering): ?>
				<div class="fv-row mb-10">
					<label class="form-check form-check-custom form-check-solid">
						<input class="form-check-input" type="checkbox" name="remember" <?php if(old('remember')) : ?> checked <?php endif ?>>
						<span class="form-check-label fw-bold text-gray-700 fs-6"><?=lang('Auth.rememberMe')?>
					</span>
					</label>
				</div>
				<?php endif; ?>      

				<!--end::Input group-->
				<!--begin::Actions-->
				<div class="text-center">
					<!--begin::Submit button-->
					<button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
						<span class="indicator-label"><?=lang('Auth.continue');?></span>
						<span class="indicator-progress"><?=lang('Auth.Please wait');?>...
						<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
					</button>
					<!--end::Submit button-->
					<?php if ($config->allowRegistration): ?>
						<!--begin::Separator-->
						<div class="text-center text-muted text-uppercase fw-bolder mb-5">or</div>
						<!--end::Separator-->
						<!--begin::Google link-->
						<a href="#" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5">
						<img alt="Logo" src="<?= assetAdmin('/media/svg/brand-logos/google-icon.svg'); ?>" class="h-20px me-3" /><?=lang('Auth.Continue with Google')?></a>
						<!--end::Google link-->
						<!--begin::Google link-->
						<a href="#" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5">
						<img alt="Logo" src="<?= assetAdmin('/media/svg/brand-logos/facebook-4.svg'); ?>" class="h-20px me-3" /><?=lang('Auth.Continue with Facebook')?></a>
						<!--end::Google link-->
						<!--begin::Google link-->
						<a href="#" class="btn btn-flex flex-center btn-light btn-lg w-100">
						<img alt="Logo" src="<?= assetAdmin('/media/svg/brand-logos/apple-black.svg'); ?>" class="h-20px me-3" /><?=lang('Auth.Continue with Apple')?></a>
						<!--end::Google link-->
					<?php endif; ?>      
				</div>
				<!--end::Actions-->
			<?= form_close(); ?>
			<!--end::Form-->
		</div>
		<!--end::Wrapper-->
	</div>
	<!--end::Content-->
	<!--begin::Footer-->
	<div class="d-flex flex-center flex-column-auto p-10">
		<!--begin::Links-->
		<div class="d-flex align-items-center fw-bold fs-6">
			<a href="<?= current_url(); ?>" class="text-muted text-hover-primary px-2">A propos de </a>
			<a href="mailto:contact@adnduweb.com" class="text-muted text-hover-primary px-2">Contact</a>
			<a href="<?= current_url(); ?>" class="text-muted text-hover-primary px-2">Nous contacter</a>
		</div>
		<!--end::Links-->
	</div>
	<!--end::Footer-->
</div>
<!--end::Authentication - Sign-in-->
<?= $this->endSection() ?>
