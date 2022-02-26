<?php if(!empty( $instance)){ ?>
    <<?= $instance[service('request')->getLocale()]['type']; ?>  class="<?= $instance[service('request')->getLocale()]['class']; ?>">
        <?= $instance[service('request')->getLocale()]['name']; ?>

        <?php if(!empty($instance[service('request')->getLocale()]['sous_name'])){ ?>
            <span class="<?= $instance[service('request')->getLocale()]['class2']; ?>">
                <?= $instance[service('request')->getLocale()]['sous_name']; ?>
            </span>
        <?php } ?>

    </<?= $instance[service('request')->getLocale()]['type']; ?>>
<?php } ?>