<?php if(!empty( $instance)){ ?>
    <?= $instance[service('request')->getLocale()]['name']; ?>
<?php } ?>