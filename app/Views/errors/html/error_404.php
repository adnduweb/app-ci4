<!DOCTYPE html>
<html class="<?= $html; ?>" lang="<?= service('request')->getLocale(); ?>">
	<!--begin::Head-->
	<head>
    <title>404 Page Not Found</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta charset="utf-8" />
		<link rel="canonical" href="<?= current_url(); ?>" />
		<link rel="shortcut icon" href="/metronic8/demo1/assets/media/logos/favicon.ico" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<?php foreach (Config('Theme')->layout['assets']['css'] as $style) { ?>
            <link href="<?= assetCustom($style); ?>" rel="stylesheet" type="text/css" />
        <?php } ?>
		<!--end::Global Stylesheets Bundle-->

	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="bg-body">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Authentication - 404 Page-->
			<div class="d-flex flex-column flex-center flex-column-fluid p-10">
				<!--begin::Illustration-->
				<img src="<?= assetAdmin('/media/illustrations/sketchy-1/18.png'); ?>" alt="" class="mw-100 mb-10 h-lg-450px" />
				<!--end::Illustration-->
				<!--begin::Message-->
				<h1 class="fw-bold mb-10" style="color: #A3A3C7">Seems there is nothing here</h1>
				<!--end::Message-->
				<!--begin::Link-->
				<a href="<?= route_to('dashboard'); ?>" class="btn btn-primary">Return Home</a>
				<!--end::Link-->
			</div>
			<!--end::Authentication - 404 Page-->
		</div>
		<!--end::Main-->
		<script>var hostUrl = "<?= current_url(); ?>";</script>
		<!--begin::Javascript-->
        <!--begin::Global Javascript Bundle(used by all pages)-->
        <?php foreach (Config('Theme')->layout['assets']['js'] as $script) { ?>
            <script type="text/javascript" src="<?= assetAdmin($script); ?>?v=<?= Config('Theme')->version; ?>&t<?= filemtime(env('DOCUMENT_ROOT') . 'backend/themes/'. service('settings')->get('App.theme_fo', 'name') . '/assets/' . $script); ?>"></script>
        <?php } ?> 
		<!--end::Global Javascript Bundle-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>