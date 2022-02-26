<!-- Global Theme JS Bundle (used by all pages)  -->
<?php foreach (Config('ThemeFO')->layout['assets']['js'] as $script) { ?>
<script type="text/javascript" src="<?= assetFront($script); ?>?v=<?= Config('ThemeFO')->version; ?>&t<?= filemtime(env('DOCUMENT_ROOT') . '/frontend/themes/'.$theme_front . '/' . $script); ?>"></script>
<?php } ?> 

<?= $this->renderSection('FrontBeforeExtraJs') ?>

<?php if (service('settings')->get('Pages.consent', 'requireConsent') == 1){ ?>
    <script type="text/javascript">
    // Définition de la langue de tarteaucitron en fonction de la langue courante
    var tarteaucitronForceLanguage = '<?= service('request')->getLocale(); ?>'; /* supported: fr, en, de, es, it, pt, pl, ru */
    </script>
    <script type="text/javascript" src="<?= site_url(); ?>/frontend/themes/default/plugins/tarteaucitron/tarteaucitron.js"></script>
    <?= $this->include('\Themes\frontend\/'.$theme_front.'/\_rgpd\scripts') ?>
 <?php } ?>

<?= service('theme_fo')::js(); ?>
<?= service('theme_fo')::message(); ?>
<!--end::Page Scripts -->

<?= $this->renderSection('FrontAfterExtraJs') ?>