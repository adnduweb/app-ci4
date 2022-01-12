<style>
    .margin-right-flag {
        margin-right: 5px;
    }
    .nav-wrapper2 {
        margin-top: 6px;
        text-align: center;
        margin-left: 10px;
    }
    .sl-nav {
        display: inline;
    }
    .sl-nav ul {
        margin: 0;
        padding: 0;
        list-style: none;
        position: relative;
        display: inline-block;
    }
    .sl-nav li {
        cursor: pointer;
        padding-bottom: 10px;
    }
    .sl-nav li ul {
        display: none;
    }
    .sl-nav li:hover ul {
        position: absolute;
        top: 29px;
        left: -15px;
        display: block;
        background: #fff;
        width: 130px;
        padding-top: 0px;
        z-index: 1;
        border-radius: 5px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
    }
    .sl-nav li:hover .triangle {
        position: absolute;
        top: 15px;
        right: -10px;
        z-index: 10;
        height: 14px;
        overflow: hidden;
        width: 30px;
        background: transparent;
    }
    .sl-nav li:hover .triangle:after {
        content: "";
        display: block;
        z-index: 20;
        width: 15px;
        transform: rotate(45deg) translateY(0px) translatex(10px);
        height: 15px;
        background: #fff;
        border-radius: 2px 0px 0px 0px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
    }
    .sl-nav li ul li {
        position: relative;
        text-align: left;
        background: transparent;
        padding: 15px 15px;
        padding-bottom: 0;
        z-index: 2;
        font-size: 15px;
    }
    .sl-nav li ul li:last-of-type {
        padding-bottom: 15px;
    }
    .sl-nav li ul li span {
        padding-left: 5px;
    }
    .sl-nav li ul li span:hover,
    .sl-nav li ul li span.active {
        color: #146c78;
    }
    .sl-flag {
        display: inline-block;
        box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.4);
        width: 15px;
        height: 15px;
        background: #aaa;
        border-radius: 50%;
        position: relative;
        top: 2px;
        overflow: hidden;
    }
    .flag-de {
        background-image: url("<?= base_url(); ?>/wp-content/themes/eskimoz/img/de.svg");
        background-size: cover;
        background-position: center center;
    }
    .flag-it {
        background-image: url("<?= base_url(); ?>/wp-content/themes/eskimoz/img/it.svg");
        background-size: cover;
        background-position: center center;
    }
    .flag-fr {
        background-size: cover;
        background-position: center center;
        background-image: url("<?= base_url(); ?>/wp-content/themes/eskimoz/img/fr.svg");
    }
    .flag-es {
        background-size: cover;
        background-position: center center;
        background-image: url("<?= base_url(); ?>/wp-content/themes/eskimoz/img/es.svg");
    }
    .flag-couk {
        background-size: cover;
        background-position: center center;
        background-image: url("<?= base_url(); ?>/wp-content/themes/eskimoz/img/co.uk.svg");
    }
    .sl-nav ul li a {
        color: inherit;
        text-decoration: none;
    }
    .sl-nav ul li a:hover {
        color: inherit;
    }
    </style>
    <div class="nav-wrapper2">
    <div class="sl-nav">
        <ul>
            <li>
                <i class="sl-flag flag-fr margin-right-flag"> </i><i class="fa fa-angle-down" aria-hidden="true"></i>
                <div class="triangle"></div>
                <ul>
                    <li>
                        <a href="<?= base_url(); ?>/">
                            <i class="sl-flag flag-fr"><div id="germany"></div></i> <span>Français</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.eskimoz.co.uk/">
                            <i class="sl-flag flag-couk"><div id="germany"></div></i> <span>Anglais</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.eskimoz.es/">
                            <i class="sl-flag flag-es"><div id="germany"></div></i> <span>Espagnol</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.eskimoz.it/homepage/">
                            <i class="sl-flag flag-it"><div id="germany"></div></i> <span>Italien</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    </div>