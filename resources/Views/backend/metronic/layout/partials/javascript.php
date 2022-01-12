<script>
	var HOST_URL = "<?= current_url(); ?>";
</script>
<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
	var optionsPortlet = {
		bodyToggleSpeed: 400,
		tooltips: true,
		tools: {
			toggle: {
				collapse: _LANG_.expand,
				expand: _LANG_.collapse
			},
			reload: _LANG_.reload,
			remove: _LANG_.remove,
			fullscreen: {
				on: 'Fullscreen',
				off: 'Exit Fullscreen'
			}
		},
		sticky: {
			offset: 300,
			zIndex: 101
		}
	};
</script>
<!-- end::Global Config -->

<!-- Global Theme JS Bundle (used by all pages)  -->
<?php foreach (Config('Theme')->layout['assets']['js'] as $script) { ?>
<script type="text/javascript" src="<?= assetAdmin($script); ?>?v=<?= Config('Theme')->version; ?>&t<?= filemtime(env('DOCUMENT_ROOT') . '/backend/themes/'.$theme_admin . '/assets/' . $script); ?>"></script>
<?php } ?> 

<?= $this->renderSection('beforeExtraJs') ?>

<?= service('Theme')::js(); ?>
<?= service('Theme')::message(); ?>
<!--end::Page Scripts -->
<script type="text/javascript" src="<?= assetAdmin('/js/app.js'); ?>?v=<?= Config('Theme')->version; ?>&t<?= filemtime(env('DOCUMENT_ROOT') . '/backend/themes/' . $theme_admin . '/assets/js/app.js'); ?>"></script>
<?php if(file_exists(env('DOCUMENT_ROOT') . '/backend/themes/' . $theme_admin . '/assets/js/custom.js')){ ?>
<script type="text/javascript" src="<?= assetAdmin('/js/custom.js'); ?>?v=<?= Config('Theme')->version; ?>&t<?= filemtime(env('DOCUMENT_ROOT') . '/backend/themes/' . $theme_admin . '/assets/js/custom.js'); ?>"></script>
<?php } ?>

<?= $this->renderSection('AdminAfterExtraJs') ?>