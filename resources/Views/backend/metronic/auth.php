<!doctype html>
<html class="<?= $html; ?>"  lang="<?= service('request')->getLocale(); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $this->include('Themes\backend\/'.$theme_admin.'/\_head') ?>
    <?= $this->include('Themes\backend\/'.$theme_admin.'/\partials\stylesheets') ?>
</head>

<body <?= service('theme')->printHtmlAttributes('body'); ?> <?= service('theme')->printHtmlClasses('body'); ?>  style="height: 100%!important;" >
	
    <?= $this->renderSection('main') ?>


    <!-- Global Theme JS Bundle (used by all pages)  -->
    <?php foreach (Config('Theme')->layout['assets']['js'] as $script) { ?>
        <script src="<?= assetAdmin($script); ?>" type="text/javascript"></script>
    <?php } ?>

    <?= service('theme')->js(); ?>

    <?php if($display == 'index'){ ?>
        <script src="<?= assetAdmin('js/custom/authentication/sign-in/general.js', false, false); ?>?v=<?= Config('Theme')->version; ?>&t<?= dateAssetsAdmin('js/custom/authentication/sign-in/general.js', false, false); ?>" type="text/javascript"></script>
    <?php } ?>

    <?= $this->renderSection('AdminAfterExtraJs') ?>
</body>
</html>