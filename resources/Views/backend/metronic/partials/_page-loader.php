<!-- Default --->
<?php if (Config('Theme')->layout['loader']['type'] == 'default'){?>
    <div class="page-loader">
        <div class="spinner spinner-primary"></div>
    </div>
<?php } ?>

<!-- Spinner Message --->
<?php if (Config('Theme')->layout['loader']['type'] == 'spinner-message'){ ?>
    <div class="page-loader page-loader-base">
        <div class="blockui">
            <span>Please wait...</span>
            <span><div class="spinner spinner-primary"></div></span>
        </div>
    </div>
<?php } ?>

