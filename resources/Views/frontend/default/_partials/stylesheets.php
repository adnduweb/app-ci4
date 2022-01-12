<link rel="shortcut icon" href="<?= assetAdminFavicons('favicon.ico'); ?>" />

<!-- Fonts -->
<link href='https://fonts.gstatic.com' crossorigin rel='preconnect' />
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<!-- Fonts -->
<?= service('theme_fo')->includeFonts(); ?>
<!--end::Fonts -->


<!-- Global Theme Styles (used by all pages) -->
<?php foreach (Config('ThemeFo')->layout['assets']['css'] as $style) { ?>
    <link href="<?= assetFront($style); ?>" rel="stylesheet" type="text/css" />
<?php } ?>
 <!-- <link href="<?= assetFront('/css/front.css'); ?>" rel="stylesheet" type="text/css" /> -->

 <?= service('theme_fo')::css(); ?>