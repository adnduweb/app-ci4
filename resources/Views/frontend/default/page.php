<!DOCTYPE html>
<html class="<?= $html; ?>" lang="<?= service('request')->getLocale(); ?>">

<head>
	<?= $this->include('\Themes\frontend\/'.$theme_front.'/\_partials\head') ?>
	<?= $this->include('\Themes\frontend\/'.$theme_front.'/\_partials\stylesheets') ?>
</head>


<!-- begin::Body -->

<body id="<?= ($page->getHomePage() == true) ? 'home' : 'page'; ?>" class="<?= service('theme_fo')->printHtmlClasses('body', false); ?><?= ($page->getHomePage() == true) ? 'home' : ''; ?> page-template page-template-homepage page page-id-<?= $page->getID(); ?>"  <?= service('theme')->printCssVariables('body'); ?> >
	<div class="body-wrapper">
	
		<?= $this->include('\Themes\frontend\/'.$theme_front.'/\_partials\header') ?>
		<aside class="alerts-fixed">
			{alerts}
		</aside>
		<?= $this->include('\Themes\frontend\/'.$theme_front.'/\_content') ?>

		<?= $this->include('\Themes\frontend\/'.$theme_front.'/\_partials\footer') ?>

	</div>
    <?= $this->include('\Themes\frontend\/'.$theme_front.'/\_partials\javascript') ?>
    
</body>
<!-- end::Body -->
</html>