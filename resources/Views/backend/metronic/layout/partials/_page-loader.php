<!-- Default --->
<?php if (Config('Metronic')->layout['page-loader']['type'] == 'default'){ ?>
    <div class="page-loader">
        <div class="spinner spinner-primary"></div>
    </div>
<?php } ?>

<!-- Spinner Message --->
<?php if (Config('Metronic')->layout['page-loader']['type'] == 'spinner-message'){ ?>
    <div class="page-loader page-loader-base">
        <div class="blockui">
            <span>Please wait...</span>
            <span><div class="spinner spinner-primary"></div></span>
        </div>
    </div>
<?php } ?>


<!-- Spinner Logo --->
<?php if (Config('Metronic')->layout['page-loader']['type'] == 'spinner-logo'){ ?>
    <div class="page-loader page-loader-logo">
        <img alt="{{ config('app.name') }}" src="{{ asset('media/logos/logo-letter-1.png') }}"/>
        <div class="spinner spinner-primary"></div>
    </div>
<?php } ?>