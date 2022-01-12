<?= csrf_meta() ?>
<meta charset="utf-8" />
<title><?= $page->getMeta('meta_title'); ?> | <?= service('settings')->get('App.core', 'nameApp'); ?></title>
<meta name='robots' content='<?= $page->getMeta('robots'); ?>' />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url(); ?>/frontend/themes/default/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url(); ?>/frontend/themes/default/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(); ?>/frontend/themes/default/favicon-16x16.png">
<meta name="theme-color" content="#FFFFFF">

<link rel="shortcut icon" type="image/x-icon" href="<?= base_url(); ?>/frontend/themes/default/favicons/favicon.ico">
<link rel="apple-touch-icon" sizes="57x57" href="<?= base_url(); ?>/frontend/themes/default/favicons/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?= base_url(); ?>/frontend/themes/default/favicons/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?= base_url(); ?>/frontend/themes/default/favicons/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?= base_url(); ?>/frontend/themes/default/favicons/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?= base_url(); ?>/frontend/themes/default/favicons/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?= base_url(); ?>/frontend/themes/default/favicons/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?= base_url(); ?>/frontend/themes/default/favicons/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?= base_url(); ?>/frontend/themes/default/favicons/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url(); ?>/frontend/themes/default/favicons/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="<?= base_url(); ?>/frontend/themes/default/favicons/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url(); ?>/frontend/themes/default/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?= base_url(); ?>/frontend/themes/default/favicons/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(); ?>/frontend/themes/default/favicons/favicon-16x16.png">
<link rel="manifest" href="<?= base_url(); ?>/frontend/themes/default/favicons/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">


<meta name="HandheldFriendly" content="true" />
<meta name="format-detection" content="telephone=no" />
<meta name="msapplication-tap-highlight" content="no">
<!-- Add to Home Screen -->
<meta name="apple-mobile-web-app-title" content="" />
<meta name="apple-mobile-web-app-capable" content="no" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link rel="author" type="text/plain"  href="ADN du Web" />

<meta name="description" content="<?= $page->getMeta('meta_description'); ?>" />
<link rel="canonical" href="<?= current_url(); ?>"/>

<meta property="og:locale" content="<?= service('request')->getLocale(); ?>_<?= strtoupper(service('request')->getLocale()); ?>" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?= (isset($meta_title)) ? ucfirst($meta_title) : ''; ?> | <?= service('settings')->get('App.core', 'nameApp'); ?>" />
<meta property="og:description" content="<?= (isset($meta_description)) ? ucfirst($meta_description) : ''; ?>" />
<meta property="og:url" content="<?= current_url(); ?>" />
<meta property="og:site_name" content="<?= service('settings')->get('App.core', 'nameApp'); ?>" />
<meta property="article:modified_time" content="<?= $page->getDateUpdatedTime(); ?>" />
<meta name="twitter:card" content="summary_large_image" />


<!-- <script type="application/ld+json" class="yoast-schema-graph">{"@context":"https://schema.org","@graph":[{"@type":"WebSite","@id":"https://www.eskimoz.fr/#website","url":"https://www.eskimoz.fr/","name":"Eskimoz","description":"L\u2019agence Eskimoz, sp\u00e9cialis\u00e9e en r\u00e9f\u00e9rencement naturel","potentialAction":[{"@type":"SearchAction","target":{"@type":"EntryPoint","urlTemplate":"https://www.eskimoz.fr/?s={search_term_string}"},"query-input":"required name=search_term_string"}],"inLanguage":"fr-FR"},{"@type":"WebPage","@id":"https://www.eskimoz.fr/penalites-google/#webpage","url":"https://www.eskimoz.fr/penalites-google/","name":"Eskimoz : Agence sp\u00e9cialis\u00e9e en p\u00e9nalit\u00e9 google","isPartOf":{"@id":"https://www.eskimoz.fr/#website"},"datePublished":"2019-08-20T12:16:50+00:00","dateModified":"2020-03-02T10:59:40+00:00","description":"Notre \u00e9quipe a suivi plusieurs formations sp\u00e9cialis\u00e9es dans les p\u00e9nalit\u00e9s Google et maitrise parfaitement les derni\u00e8res techniques permettant d\u2019en sortir.","breadcrumb":{"@id":"https://www.eskimoz.fr/penalites-google/#breadcrumb"},"inLanguage":"fr-FR","potentialAction":[{"@type":"ReadAction","target":["https://www.eskimoz.fr/penalites-google/"]}]},{"@type":"BreadcrumbList","@id":"https://www.eskimoz.fr/penalites-google/#breadcrumb","itemListElement":[{"@type":"ListItem","position":1,"name":"P\u00e9nalit\u00e9s Google"}]}]}</script> -->
