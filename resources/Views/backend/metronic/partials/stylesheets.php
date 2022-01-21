<link rel="shortcut icon" href="<?= assetAdminFavicons('favicon.ico'); ?>" />

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<!-- Fonts -->
<?= service('theme')->includeFonts(); ?>
<!--end::Fonts -->

<?php if(isset(Config('Theme')->page['assets']['vendors']['css'])){ ?>
<!-- begin::Page Vendor Stylesheets(used by this page) -->
<?php foreach (Config('Theme')->page['assets']['vendors']['css'] as $style) { ?>
    <link href="<?=assetIfHasRTL($style); ?>" rel="stylesheet" type="text/css"/>
<?php } ?>
<!-- end::Page Vendor Stylesheets -->
<?php } ?>

<!-- Global Theme Styles (used by all pages) -->
<?php foreach (Config('Theme')->layout['assets']['css'] as $style) { ?>
<link href="<?= assetCustom($style); ?>" rel="stylesheet" type="text/css" />
<?php } ?>


<!-- <link href="<?= assetAdmin('/css/app.css'); ?>" rel="stylesheet" type="text/css" /> -->
<?= service('Theme')::css(); ?>
<!--begin::Lang Skins(used by all pages) -->
<script src="<?= assetAdminLanguage('lang_'. service('request')->getLocale() . '.js'); ?>" type="text/javascript"></script>


