<header id="header">
    <div class="header">
        <div class="container">
            <div class="header-wrapper">
                <div class="header-logo">
                    <div class="main-logo">
                        <a href="<?= base_url(); ?>/" title="<?= service('settings')->get('App.core', 'nameApp'); ?>">
                            <img src="<?= base_url(); ?>/frontend/themes/<?= $theme_front;?>/img/logo-fabrice-logo-color.svg" alt="<?= service('settings')->get('App.core', 'nameApp'); ?>" class="lazyloaded" data-ll-status="loaded" />
                            <noscript><img src="<?= base_url(); ?>/frontend/themes/<?= $theme_front;?>/img/logo-fabrice-logo-color.svg" alt="<?= service('settings')->get('App.core', 'nameApp'); ?>" /></noscript>
                        </a>
                    </div>
                </div>
                <div class="header-tools">
                    <nav class="nav-wrapper d-none d-lg-flex">

                        {{mainmenu}}

                        <div>
                            <a href="<?= base_url(); ?>/contactez-nous/" title="Contact" class="btn btn-contact">Contact</a>
                        </div>

                        <?= ''; //$this->include('\Themes\frontend\/'.$theme_front.'/\_partials\menu_lang') ?>

                    </nav>
                    <button class="nav-toggle"><span>Menu</span></button>
                </div>
            </div>
        </div>
    </div>
</header>
