<div class="footer bg-white py-4 d-flex flex-lg-column <?php service('theme')->printHtmlClasses('footer', false); ?>" id="kt_footer">

    <div class="<?php service('theme')->printHtmlClasses('footer-container', false); ?> d-flex flex-column flex-md-row align-items-center justify-content-between">

        <div class="text-dark order-2 order-md-1">
            <span class="text-muted font-weight-bold mr-2"><?= date("Y"); ?> &copy;</span>
            <a href="https://keenthemes.com/metronic" target="_blank" class="text-dark-75 text-hover-primary">ADN du Web</a>
            <p class="text-muted font-weight-bold mr-2">Page rendered in {elapsed_time} seconds - Environment: <?= ENVIRONMENT ?> - CI4: <?= CodeIgniter\CodeIgniter::CI_VERSION; ?> - Metronic : <?= service('settings')->get('App.theme_bo', 'version' ); ?> </p>
        </div>

        <div class="nav nav-dark order-1 order-md-2">
            <a href="<?= current_url(); ?>" class="text-muted text-hover-primary px-2">A propos de </a>
			<a href="mailto:contact@adnduweb.com" class="text-muted text-hover-primary px-2">Contact</a>
			<a href="<?= current_url(); ?>" class="text-muted text-hover-primary px-2">Nous contacter</a>
        </div>
    </div>
</div>
