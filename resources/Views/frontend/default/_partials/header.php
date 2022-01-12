<header id="header">

    <!-- <div class="mobile-nav-overlay">
        <nav class="mobile-nav-wrapper">
            <div class="main-logo">
                <img src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%200%200'%3E%3C/svg%3E" alt="<?= service('settings')->get('App.core', 'nameApp'); ?>" data-lazy-src="<?= base_url(); ?>/wp-content/themes/eskimoz/img/eskimoz.svg" />
                <noscript><img src="<?= base_url(); ?>/wp-content/themes/eskimoz/img/eskimoz.svg" alt="<?= service('settings')->get('App.core', 'nameApp'); ?>" /></noscript>
            </div>

            <ul id="menu-header" class="main-nav">
                <li id="menu-item-1578" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1578"><a href="<?= base_url(); ?>/seo-agency/">AGENCE SEO</a></li>
                <li id="menu-item-10949" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-10949">
                    <a href="<?= base_url(); ?>/referencement-naturel/">Services</a>
                    <ul class="sub-menu">
                        <li id="menu-item-10490" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-10490"><a href="<?= base_url(); ?>/referencement-naturel/">Référencement naturel</a></li>
                        <li id="menu-item-10800" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-10800"><a href="<?= base_url(); ?>/agence-aso/">Référencement mobile</a></li>
                        <li id="menu-item-10353" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-10353"><a href="<?= base_url(); ?>/referencement-video/">Référencement vidéo</a></li>
                        <li id="menu-item-8945" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8945"><a href="<?= base_url(); ?>/agence-relations-presse-digitales/">Relations presse digitales</a></li>
                        <li id="menu-item-9030" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-9030"><a href="<?= base_url(); ?>/penalites-google/">Pénalités Google</a></li>
                        <li id="menu-item-10283" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-10283"><a href="<?= base_url(); ?>/redaction-web/">Rédaction Web</a></li>
                        <li id="menu-item-9219" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-9219"><a href="<?= base_url(); ?>/e-reputation/">E-reputation</a></li>
                    </ul>
                </li>
                <li id="menu-item-8659" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8659"><a href="<?= base_url(); ?>/formation-seo/">Formation SEO</a></li>
                <li id="menu-item-70468" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-70468"><a target="_blank" rel="noopener" href="https://studio.<?= service('settings')->get('App.core', 'nameApp'); ?>.fr/">Content Marketing</a></li>
                <li id="menu-item-8251" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8251"><a title="Blog" href="<?= base_url(); ?>/blog/">Blog</a></li>
                <li id="menu-item-70467" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-70467">
                    <a href="<?= base_url(); ?>/histoire-de-lagence/">À propos</a>
                    <ul class="sub-menu">
                        <li id="menu-item-9399" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-9399"><a title="L’histoire de l’agence" href="<?= base_url(); ?>/histoire-de-lagence/">L’histoire</a></li>
                        <li id="menu-item-9515" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-9515"><a href="<?= base_url(); ?>/team/">L’équipe</a></li>
                        <li id="menu-item-32440" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-32440"><a href="<?= base_url(); ?>/references/">Nos clients</a></li>
                    </ul>
                </li>
            </ul>
            <a href="<?= base_url(); ?>/contact/" class="btn btn-contact">Contact</a>
            <ul class="social-links">
                <li>
                    <a href="https://www.facebook.com/Agence<?= service('settings')->get('App.core', 'nameApp'); ?>/" target="_blank" rel="noopener" title="facebook" class="facebook">Facebook</a>
                </li>
                <li>
                    <a href="https://twitter.com/agence<?= service('settings')->get('App.core', 'nameApp'); ?>" target="_blank" rel="noopener" title="twitter" class="twitter">Twitter</a>
                </li>
                <li>
                    <a href="https://www.linkedin.com/company/<?= service('settings')->get('App.core', 'nameApp'); ?>" target="_blank" rel="noopener" title="linkedin" class="linkedin">Linkedin</a>
                </li>
                <li>
                    <a href="https://www.youtube.com/c/<?= service('settings')->get('App.core', 'nameApp'); ?>" target="_blank" rel="noopener" title="youtube" class="youtube">Youtube</a>
                </li>
            </ul>
        </nav>
    </div> -->
    <div class="header">
        <div class="container">
            <div class="header-wrapper">
                <div class="header-logo">
                    <div class="main-logo">
                        <a href="<?= base_url(); ?>/" title="<?= service('settings')->get('App.core', 'nameApp'); ?>">
                            <img src="<?= base_url(); ?>/imageRender/logo-fabrice-logo-color.svg" alt="<?= service('settings')->get('App.core', 'nameApp'); ?>" class="lazyloaded" data-ll-status="loaded" />
                            <noscript><img src="<?= base_url(); ?>/imageRender/logo-fabrice-logo-color.svg" alt="<?= service('settings')->get('App.core', 'nameApp'); ?>" /></noscript>
                        </a>
                    </div>
                </div>
                <div class="header-tools">
                    <nav class="nav-wrapper d-none d-lg-flex">

                    {{mainmenu}}

                        <div>
                            <a href="<?= base_url(); ?>/contact/" title="Contact" class="btn btn-contact">Contact</a>
                        </div>

                        <?= ''; //$this->include('\Themes\frontend\/'.$theme_front.'/\_partials\menu_lang') ?>

                    </nav>
                    <button class="nav-toggle"><span>Menu</span></button>
                </div>
            </div>
        </div>
    </div>
</header>
