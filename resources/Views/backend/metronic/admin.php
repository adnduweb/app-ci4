<!DOCTYPE html>
<html class="<?= $html; ?>" lang="<?= service('request')->getLocale(); ?>">

<head>
	<?= $this->include('\Themes\backend\/'.$theme_admin.'/\_head') ?>
	<?= $this->include('\Themes\backend\/'.$theme_admin.'/\partials\stylesheets') ?>
	<script type="text/javascript">
        <?php
        $htmlJs = "";
        foreach ($paramJs as $k => $v) {
            $htmlJs .= ' let ' . $k . ' = ';
            if (preg_match('`\[(.+)\]`iU', $v)) {
                $htmlJs .=  $v;
            }
            elseif (preg_match('#{#', $v)) {
                $htmlJs .=  $v;
            } 
             else {
                $htmlJs .= "'" . $v . "'";
            }

            $htmlJs .= '; ' . "\n\t\t";
        }
        echo $htmlJs;
    ?>
    </script>
	<script type="text/javascript">
        /**
         * ----------------------------------------------------------------------------
         * Javascript Auto Logout in CodeIgniter 4
         * ---------------------------------------------------------------------------
         */
        // Set timeout variables.
        var timoutNow = <?= env('app.sessionExpiration') * 1000; ?>; // Timeout of 1800000 / 30 mins - time in ms
        var logoutUrl = base_url + segementAdmin + '/logout'; // URL to logout page.

        var timeoutTimer;

        // Start timer
        function StartTimers() {
            timeoutTimer = setTimeout("IdleTimeout()", timoutNow);
        }

        // Reset timer
        function ResetTimers() {
            clearTimeout(timeoutTimer);
            StartTimers();
        }

        // Logout user
        function IdleTimeout() {
            window.location = logoutUrl;
        }

</script>

</head>


<!-- begin::Body -->

<body <?= service('theme')->printHtmlAttributes('body'); ?> <?= service('theme')->printHtmlClasses('body'); ?>  <?= service('theme')->printCssVariables('body'); ?> >

	<?php if (Config('Theme')->layout['loader']['display'] === true){ ?>
		<?= $this->include('\Themes\backend\/'.$theme_admin.'/\partials\_page-loader') ?>
	<?php } ?>


	<?= $this->include('\Themes\backend\/'.$theme_admin.'/\_content') ?>
				
    <?php if(user()->isSuperHero() == true || user()->isSuperCaptain() == true) { ?>
        <!-- begin::Modal En tant que -->
        <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\pages\users\__modals\_entantque') ?> 
        <!-- end::Modal En tant que -->
     <?php } ?>
     <?= $this->renderSection('AdminModal') ?>

     <?= $this->include('\Themes\backend\/'.$theme_admin.'/\aside/_modals/_modal_devis') ?> 

    <?= $this->include('\Themes\backend\/'.$theme_admin.'/\partials\javascript') ?>
    
</body>

<!-- end::Body --> 

</html>