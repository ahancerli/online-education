<?php
helper('auth');
$settings = model('SiteSettingsModel')->first();

?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<!-- Mirrored from grandetest.com/theme/edumy-html/page-dashboard.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 15 Aug 2020 11:28:27 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="<?= $settings['site_keywords'] ?>">
    <meta name="description" content="<?= $settings['site_description'] ?>">
    <meta name="CreativeLayers" content="ATFN">
    <!-- css file -->
    <link rel="stylesheet" href="<?= base_url('assets')  ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets')  ?>/css/style.css">
    <link rel="stylesheet" href="<?= base_url('assets')  ?>/css/dashbord_navitaion.css">
    <!-- Responsive stylesheet -->
    <link rel="stylesheet" href="<?= base_url('assets')  ?>/css/responsive.css">
    <!-- Title -->
    <title><?= $settings['site_title'] ?></title>
    <!-- Favicon -->
    <link href="<?= base_url('assets')  ?>/images/favicon.ico" sizes="128x128" rel="shortcut icon" type="image/x-icon" />
    <link href="<?= base_url('assets')  ?>/images/favicon.ico" sizes="128x128" rel="shortcut icon" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?= base_url('assets')  ?>/https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="<?= base_url('assets')  ?>/https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="wrapper">
    <div class="preloader"></div>

    <!-- Main Header Nav -->
    <header class="header-nav menu_style_home_one dashbord_pages navbar-scrolltofixed stricky main-menu">
        <div class="container-fluid">
            <!-- Ace Responsive Menu -->
            <nav>
                <!-- Menu Toggle btn-->
                <div class="menu-toggle">
                    <img class="nav_logo_img img-fluid" src="<?= base_url('assets')  ?>/images/header-logo.png" alt="header-logo.png">
                    <button type="button" id="menu-btn">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <a href="<?= base_url()  ?>" class="navbar_brand float-left dn-smd">
                    <img class="logo1 img-fluid" src="<?= base_url('assets')  ?>/images/header-logo.png" alt="header-logo.png">
                    <img class="logo2 img-fluid" src="<?= base_url('assets')  ?>/images/header-logo.png" alt="header-logo.png">
                    <span><?= $settings['site_title'] ?></span>
                </a>
                <!-- Responsive Menu Structure-->
                <!--Note: declare the Menu style in the data-menu-style="horizontal" (options: horizontal, vertical, accordion) -->
                <ul id="respMenu" class="ace-responsive-menu" data-menu-style="horizontal">
                    <li><a href="/"><span class="title">Anasayfa</span></a></li>
                    <li><a href="/category"><span class="title">Eğitim Kataloğu</span></a></li>
                    <li><a href="/contact"><span class="title">İletişim</span></a></li>
                </ul>
                <!--<ul class="header_user_notif pull-right dn-smd">
                    <li class="user_setting">
                        <div class="dropdown">
                            <a class="btn dropdown-toggle" href="#" data-toggle="dropdown"><img class="rounded-circle" src="<?/*= base_url('assets/uploads/user')  */?>/<?/*= user()->profile_image*/?>" style="height: 50px"></a>
                            <div class="dropdown-menu">
                                <div class="user_set_header">
                                    <img class="float-left" src="<?/*= base_url('assets/uploads/user')  */?>/<?/*= user()->profile_image*/?>" alt="e1.png">
                                    <p><?/*= user()->name*/?> <br><span class="address"><a href="https://grandetest.com/cdn-cgi/l/email-protection" class="__cf_email__"><?/*= user()->email*/?></a></span></p>
                                </div>
                                <div class="user_setting_content">
                                    <a class="dropdown-item active" href="<?/*= base_url()  */?>/account/profile">Profil</a>
                                    <a class="dropdown-item" href="<?/*= base_url()  */?>/logout">Çıkış</a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>-->
            </nav>
        </div>
    </header>

    <!-- Main Header Nav For Mobile -->
    <div id="page" class="stylehome1 h0">
        <div class="mobile-menu">
            <!--<ul class="header_user_notif dashbord_pages_mobile_version pull-right">
                <li class="user_setting">
                    <div class="dropdown">
                        <a class="btn dropdown-toggle" href="#" data-toggle="dropdown"><img class="rounded-circle" src="<?/*= base_url('assets/uploads/user/')  */?>/<?/*= user()->profile_image*/?>" style="height: 50px"></a>
                        <div class="dropdown-menu">
                            <div class="user_set_header">
                                <img class="float-left" src="<?/*= base_url('assets/uploads/user/')  */?>/<?/*= user()->profile_image*/?>" alt="e1.png">
                                <p><?/*= user()->name*/?>  <br><span class="address"><a href="<?/*= base_url('assets')  */?>/https://grandetest.com/cdn-cgi/l/email-protection" class="__cf_email__"><?/*= user()->email*/?> </a></span></p>
                            </div>
                            <div class="user_setting_content">
                                <a class="dropdown-item active" href="<?/*= base_url()  */?>/account/profile">Profil</a>
                                <a class="dropdown-item" href="<?/*= base_url()  */?>/logout">Çıkış</a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>-->
            <div class="header stylehome1 dashbord_mobile_logo dashbord_pages">
                <div class="main_logo_home2">
                    <img class="nav_logo_img img-fluid float-left mt20" src="<?= base_url('assets')  ?>/images/header-logo.png" alt="header-logo.png">

                    <span><?= base_url('assets')  ?>/</span>
                    <span>Orenda Akademi</span>
                </div>
                <ul class="menu_bar_home2">
                    <li class="list-inline-item"></li>
                    <li class="list-inline-item"><a href="#menu"><span></span></a></li>
                </ul>
            </div>
        </div><!-- /.mobile-menu -->
        <nav id="menu" class="stylehome1">
            <ul>
                <li><span><a href="/">Anasayfa</a></span></li>
                <li><span><a href="/category">Eğitim Kataloğu</a></span></li>
                <li><span><a href="/contact">İletişim</a></span></li>
            </ul>
        </nav>
    </div>

    <!-- Our Dashbord Sidebar -->
    <section class="dashboard_sidebar dn-1199">
        <div class="dashboard_sidebars">
            <div class="user_board">
                <div class="dashbord_nav_list">
                    <ul>
                        <li <?= uri_string() == 'account' ? 'class="active"' : '' ?>><a href="/account"><span class="flaticon-user"></span> Anasayfa</a></li>
                        <li <?= uri_string() == 'account/courses' ? 'class="active"' : '' ?>><a href="/account"><a href="/account/courses"><span class="flaticon-online-learning"></span> Kurslarım</a></li>
                        <li <?= uri_string() == 'account/orders' ? 'class="active"' : '' ?>><a href="/account/orders"><span class="flaticon-shopping-bag-1"></span> Siparişlerim</a></li>
                        <li <?= uri_string() == 'account/certificate' ? 'class="active"' : '' ?>><a href="/account/certificate"><span class="flaticon-cap"></span> Sertifikalarım</a></li>
                    </ul>
                    <h4>Hesap</h4>
                    <ul>
                        <li <?= uri_string() == 'account/profile' ? 'class="active"' : '' ?>><a href="/account/profile"><span class="flaticon-user"></span> Profil</a></li>
                        <li <?= uri_string() == 'account/change_password' ? 'class="active"' : '' ?>><a href="/account/change_password"><span class="flaticon-key"></span> Şifre Değiştir</a></li>
                        <li><a href="/logout"><span class="flaticon-logout"></span> Çıkış</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Dashbord -->
    <div class="our-dashbord dashbord">
        <div class="dashboard_main_content">
            <div class="container-fluid">
                <div class="main_content_container">

                    <div class="row">

                        <div class="col-lg-12">
                            <div class="dashboard_navigationbar dn db-1199">
                                <div class="dropdown">
                                    <button onclick="myFunction()" class="dropbtn"><i class="fa fa-bars pr10"></i> Hesabım</button>
                                    <ul id="myDropdown" class="dropdown-content">
                                        <li <?= uri_string() == 'account' ? 'class="active"' : '' ?>><a href="/account"><span class="flaticon-user"></span> Anasayfa</a></li>
                                        <li <?= uri_string() == 'account/courses' ? 'class="active"' : '' ?>><a href="/account"><a href="/account/courses"><span class="flaticon-online-learning"></span> Kurslarım</a></li>
                                        <li <?= uri_string() == 'account/orders' ? 'class="active"' : '' ?>><a href="/account/orders"><span class="flaticon-shopping-bag-1"></span> Siparişlerim</a></li>
                                        <li <?= uri_string() == 'account/certificate' ? 'class="active"' : '' ?>><a href="/account/certificate"><span class="flaticon-cap"></span> Sertifikalarım</a></li>
                                        <li <?= uri_string() == 'account/profile' ? 'class="active"' : '' ?>><a href="/account/profile"><span class="flaticon-user"></span> Profil</a></li>
                                        <li <?= uri_string() == 'account/change_password' ? 'class="active"' : '' ?>><a href="/account/change_password"><span class="flaticon-key"></span> Şifre Değiştir</a></li>
                                        <li><a href="/logout"><span class="flaticon-logout"></span> Çıkış</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?= $this->renderSection('content') ?>
                    </div>

                    <div class="row mt50 mb50">
                        <div class="col-lg-6 offset-lg-3">
                            <div class="copyright-widget text-center">
                                <p class="color-black2">Copyright <?= $settings['site_title'] ?> © <?= date('Y') ?>. Tüm Hakları Gizlidir.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="scrollToHome" href="#"><i class="flaticon-up-arrow-1"></i></a>
</div>
<!-- Wrapper End -->
<script data-cfasync="false" src="<?= base_url('assets')  ?>/js/email-decode.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets')  ?>/js/jquery-3.3.1.js"></script>
<script type="text/javascript" src="<?= base_url('assets')  ?>/js/jquery-migrate-3.0.0.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets')  ?>/js/popper.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets')  ?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets')  ?>/js/jquery.mmenu.all.js"></script>
<script type="text/javascript" src="<?= base_url('assets')  ?>/js/ace-responsive-menu.js"></script>
<script type="text/javascript" src="<?= base_url('assets')  ?>/js/chart.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets')  ?>/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets')  ?>/js/snackbar.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets')  ?>/js/simplebar.js"></script>
<script type="text/javascript" src="<?= base_url('assets')  ?>/js/parallax.js"></script>
<script type="text/javascript" src="<?= base_url('assets')  ?>/js/scrollto.js"></script>
<script type="text/javascript" src="<?= base_url('assets')  ?>/js/jquery-scrolltofixed-min.js"></script>
<script type="text/javascript" src="<?= base_url('assets')  ?>/js/jquery.counterup.js"></script>
<script type="text/javascript" src="<?= base_url('assets')  ?>/js/wow.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets')  ?>/js/progressbar.js"></script>
<script type="text/javascript" src="<?= base_url('assets')  ?>/js/slider.js"></script>
<script type="text/javascript" src="<?= base_url('assets')  ?>/js/timepicker.js"></script>
<script type="text/javascript" src="<?= base_url('assets')  ?>/js/wow.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets')  ?>/js/dashboard-script.js"></script>
<!-- Custom script for all pages -->
<script type="text/javascript" src="<?= base_url('assets')  ?>/js/script.js"></script>
<?= $this->renderSection('pageScripts') ?>
</body>

<!-- Mirrored from grandetest.com/theme/edumy-html/page-dashboard.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 15 Aug 2020 11:28:29 GMT -->
</html>