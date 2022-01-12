<!-- Global Theme JS Bundle (used by all pages)  -->
<?php foreach (Config('ThemeFO')->layout['assets']['js'] as $script) { ?>
<script type="text/javascript" src="<?= assetFront($script); ?>?v=<?= Config('ThemeFO')->version; ?>&t<?= filemtime(env('DOCUMENT_ROOT') . '/frontend/themes/'.$theme_front . '/' . $script); ?>"></script>
<?php } ?> 

<?= $this->renderSection('beforeExtraJs') ?>

<?= service('theme_fo')::js(); ?>
<?= service('theme_fo')::message(); ?>
<!--end::Page Scripts -->

<?= $this->renderSection('AdminAfterExtraJs') ?>