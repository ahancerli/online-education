<?php
    $siteSettings = model('SiteSettingsModel')->first();
?>

<!DOCTYPE html>
<html dir="ltr" lang="tr">

<!-- Mirrored from grandetest.com/theme/edumy-html/page-error.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 15 Aug 2020 11:28:37 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- css file -->
    <link rel="stylesheet" href="<?= base_url('assets') ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets') ?>/css/style.css">
    <!-- Responsive stylesheet -->
    <link rel="stylesheet" href="<?= base_url('assets') ?>/css/responsive.css">
    <!-- Title -->
    <title>Sayfa Bulunamadı<?= $siteSettings ? ' - ' . $siteSettings['site_title'] : '' ?></title>
    <!-- Favicon -->
    <link href="<?= base_url('assets') ?>/images/favicon.ico" sizes="128x128" rel="shortcut icon" type="image/x-icon" />
    <link href="<?= base_url('assets') ?>/images/favicon.ico" sizes="128x128" rel="shortcut icon" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="wrapper">
    <div class="preloader"></div>

    <!-- Our Error Page -->
    <section class="our-error bg-img6">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 offset-sm-4 col-lg-6 offset-lg-5 text-center">
                    <div class="logo-widget error_paged">
                        <a href="#" class="navbar_brand float-left">
                            <img class="nav_logo_img img-fluid" src="<?= base_url('assets') ?>/images/header-logo.png" alt="header-logo.png">
                            <span><?= $siteSettings ? $siteSettings['site_title'] : '' ?></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 offset-lg-1 text-center">
                    <div class="error_page footer_apps_widget">
                        <div class="erro_code"><h1>404</h1></div>
                        <h4>Üzgünüz, Sayfa Bulunamadı</h4>
                        <p>Maalesef aradığınız sayfa bulunamadı. Geçici olarak kullanım dışı, taşınmış veya artık mevcut olmayabilir. Girdiğiniz URL’de herhangi bir hata olup olmadığını kontrol edin ve tekrar deneyin.</p>
                    </div>
                    <a class="color-white mt25" href="/">Anasayfaya Dön <span class="flaticon-right-arrow-1 pl10"></span></a>
                </div>
            </div>
        </div>
    </section>
    <a class="scrollToHome" href="#"><i class="flaticon-up-arrow-1"></i></a>
</div>
<!-- Wrapper End -->
<script type="text/javascript" src="<?= base_url('assets') ?>/js/jquery-3.3.1.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/jquery-migrate-3.0.0.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/popper.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/jquery.mmenu.all.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/ace-responsive-menu.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/snackbar.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/simplebar.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/parallax.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/scrollto.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/jquery-scrolltofixed-min.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/jquery.counterup.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/wow.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/progressbar.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/slider.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/timepicker.js"></script>
<!-- Custom script for all pages -->
<script type="text/javascript" src="<?= base_url('assets') ?>/js/script.js"></script>
</body>
</html>