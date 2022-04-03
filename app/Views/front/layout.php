<?php
helper('auth');
helper('cookie');

$settings = model('SiteSettingsModel')->first();
$cart = get_cookie('cart') ? json_decode(get_cookie('cart'), true) : [];
$cartItems = [];

if (count($cart) > 0)
    $cartItems = model('CourseModel')
        ->where('status', 1)
        ->whereIn('id', $cart)
        ->select('id, title, image_name, slug, price, discount_ratio')
        ->findAll();
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<!-- Mirrored from grandetest.com/theme/edumy-html/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 15 Aug 2020 11:26:50 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="<?= $settings['site_keywords'] ?>">
    <meta name="description" content="<?= $settings['site_description'] ?>">
    <meta name="CreativeLayers" content="ATFN">
    <!-- css file -->
    <link rel="stylesheet" href="<?= base_url('assets') ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets') ?>/css/style.css">
    <!-- Responsive stylesheet -->
    <link rel="stylesheet" href="<?= base_url('assets') ?>/css/responsive.css">
    <!-- Title -->
    <title><?= isset($pageTitle) ? $pageTitle . ' - ' : '' ?><?= $settings['site_title'] ?></title>
    <!-- Favicon -->
    <link href="<?= base_url('assets') ?>/images/favicon.ico" sizes="128x128" rel="shortcut icon" type="image/x-icon" />
    <link href="<?= base_url('assets') ?>/images/favicon.ico" sizes="128x128" rel="shortcut icon" />

    <?= $this->renderSection('pageStyles') ?>

    <!-- Animated Css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>

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
    <div class="ajax_loader"></div>

    <!-- Main Header Nav -->
    <header class="header-nav menu_style_home_one navbar-scrolltofixed stricky main-menu">
        <div class="container-fluid">
            <!-- Ace Responsive Menu -->
            <nav>
                <!-- Menu Toggle btn-->
                <div class="menu-toggle">
                    <img class="nav_logo_img img-fluid" src="<?= base_url('assets') ?>/images/header-logo.png" alt="header-logo.png">
                    <button type="button" id="menu-btn">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <a href="/" class="navbar_brand float-left dn-smd">
                    <img class="logo1 img-fluid" src="<?= base_url('assets') ?>/images/header-logo.png" alt="header-logo.png">
                    <img class="logo2 img-fluid" src="<?= base_url('assets') ?>/images/header-logo2.png" alt="header-logo2.png">
                    <span><?= $settings['site_title'] ?></span>
                </a>
                <!-- Responsive Menu Structure-->
                <!--Note: declare the Menu style in the data-menu-style="horizontal" (options: horizontal, vertical, accordion) -->
                <ul id="respMenu" class="ace-responsive-menu" data-menu-style="horizontal">
                    <li>
                        <a href="/"><span class="title">Anasayfa</span></a>
                    </li>
                    <li>
                        <a href="/category"><span class="title">Eğitim Kataloğu</span></a>
                    </li>
                    <li class="last">
                        <a href="/contact"><span class="title">İletişim</span></a>
                    </li>
                </ul>

                <ul class="sign_up_btn pull-right dn-smd mt20" style="margin-right: 0">
                    <?php if(!logged_in()): ?>
                        <li class="list-inline-item list_s"><a href="#" class="btn flaticon-user" data-toggle="modal" data-target="#exampleModalCenter"> <span class="dn-lg">Giriş Yap/Kayıt Ol</span></a></li>
                    <?php else: ?>
                    <li class="list-inline-item list_s"><a href="#" class="btn flaticon-user" data-toggle="modal" data-target="#exampleModalCenterAccount"> <span class="dn-lg"><?= user()->name?></span></a></li>
                    <?php endif ?>
                    <li class="list-inline-item">
                        <div class="cart_btn">
                            <ul class="cart">
                                <li>
                                    <a href="javascript:void(0)" class="btn cart_btn flaticon-shopping-bag"><?php if (count($cartItems) > 0): ?><span><?= count($cartItems) ?></span><?php endif ?></a>
                                    <ul class="dropdown_content">
                                        <?php if (count($cartItems) == 0): ?>
                                        <li class="list_content">
                                            <p class="text-center">Sepetiniz boş</p>
                                        </li>
                                        <?php endif ?>
                                        <?php $totalPrice = 0; ?>
                                        <?php foreach ($cartItems as $cartItem): ?>
                                        <li class="list_content">
                                            <a href="#">
                                                <p><?= $cartItem['title'] ?></p>
                                                <?php
                                                    if ($cartItem['discount_ratio'] > 0)
                                                        $itemPrice = number_format($cartItem['price'] - ($cartItem['price'] * $cartItem['discount_ratio'] / 100), 2);
                                                    else
                                                        $itemPrice = number_format($cartItem['price'], 2);

                                                    $totalPrice += $itemPrice;
                                                ?>
                                                <small><?= $itemPrice ?> TL</small>
                                                <span class="close_icon float-right remove-from-cart" data-id="<?= $cartItem['id'] ?>"><i class="fa fa-plus"></i></span>
                                            </a>
                                        </li>
                                        <?php endforeach ?>
                                        <?php if (count($cartItems) > 0): ?>
                                        <li class="list_content">
                                            <h5>Toplam: <?= number_format($totalPrice, 2); ?> TL</h5>
                                            <a href="/cart" class="btn btn-thm cart_btns">Sepeti Göster</a>
                                            <a href="/checkout" class="btn btn-thm3 checkout_btns">Ödeme Yap</a>
                                        </li>
                                        <?php endif ?>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul><!-- Button trigger modal -->
            </nav>
        </div>
    </header>

    <!-- Modal -->
    <div class="sign_up_modal modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <ul class="sign_up_tab nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Giriş Yap</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Kayıt Ol</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="login_form">
                            <form action="" id = "main_login_frm">
                                <div class="heading">
                                    <h3 class="text-center">Hesabınıza Giriş Yapın</h3>
                                </div>

                                <div id="login_message" class="alert alert-danger" style="display: none"></div>
                                <div class="form-group">
                                    <input type="email" class="form-control" id="login_email" placeholder="E-posta">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="login_password" placeholder="Şifre">
                                </div>
                                <div class="form-group custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="login_check">
                                    <label class="custom-control-label" for="exampleCheck1">Beni Hatırla</label>
                                    <a class="tdu btn-fpswd float-right" href="#">Şifremi Unuttum?</a>
                                </div>
                                <button type="button" class="btn btn-log btn-block btn-thm2 login_btn">Giriş Yap</button>
                                <hr>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="sign_up_form">
                            <div class="heading">
                                <h3 class="text-center">Yeni Hesap Oluştur</h3>
                            </div>
                            <div id="register_message" class="alert alert-danger" style="display: none"></div>
                            <form action="#">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="register_name" placeholder="Ad Soyad">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="register_username" placeholder="Kullanıcı Adı">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" id="register_email" placeholder="E-posta Adresi">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="register_password" placeholder="Şifre">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="register_repassword" placeholder="Şifre Tekrar">
                                </div>
                                <button type="button" class="btn btn-log btn-block btn-thm2 register_btn">Kayıt Ol</button>
                                <hr>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search Button Bacground Overlay -->

    <!-- Modal -->
    <div class="sign_up_modal modal fade" id="exampleModalCenterAccount" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="login_form">
                            <form action="" id = "main_login_frm">
                                <div class="heading">
                                    <h3 class="text-center">Hesabım</h3>
                                </div>
                                <a href="/account" class="btn btn-log btn-block btn-thm2">Hesabım</a>
                                <a href="/account/profile" class="btn btn-log btn-block btn-thm2">Profil</a>
                                <a href="/account/courses" class="btn btn-log btn-block btn-thm2">Kurslarım</a>
                                <a href="/logout" class="btn btn-log btn-block btn-thm2">Çıkış Yap</a>
                                <hr>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search Button Bacground Overlay -->

    <div class="search_overlay dn-992">
        <div class="mk-fullscreen-search-overlay" id="mk-search-overlay">
            <a href="#" class="mk-fullscreen-close" id="mk-fullscreen-close-button"><i class="fa fa-times"></i></a>
            <div id="mk-fullscreen-search-wrapper">
                <form method="get" id="mk-fullscreen-searchform">
                    <input type="text" value="" placeholder="Site içinde ara..." id="mk-fullscreen-search-input">
                    <i class="flaticon-magnifying-glass fullscreen-search-icon"><input value="" type="submit"></i>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Header Nav For Mobile -->
    <div id="page" class="stylehome1 h0">
        <div class="mobile-menu">
            <div class="header stylehome1">
                <div class="main_logo_home2">
                    <img class="nav_logo_img img-fluid float-left mt20" src="<?= base_url('assets') ?>/images/header-logo.png" alt="header-logo.png">
                    <span><?= $settings['site_title'] ?></span>
                </div>
                <ul class="menu_bar_home2">
                    <li class="list-inline-item">
                        <div class="search_overlay">
                            <a id="search-button-listener2" class="mk-search-trigger mk-fullscreen-trigger" href="#">
                                <div id="search-button2"><i class="flaticon-magnifying-glass"></i></div>
                            </a>
                            <div class="mk-fullscreen-search-overlay" id="mk-search-overlay2">
                                <a href="#" class="mk-fullscreen-close" id="mk-fullscreen-close-button2"><i class="fa fa-times"></i></a>
                                <div id="mk-fullscreen-search-wrapper2">
                                    <form method="get" id="mk-fullscreen-searchform2">
                                        <input type="text" value="" placeholder="Site İçinde Ara.." id="mk-fullscreen-search-input2">
                                        <i class="flaticon-magnifying-glass fullscreen-search-icon"><input value="" type="submit"></i>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-inline-item"><a href="#menu"><span></span></a></li>
                </ul>
            </div>
        </div><!-- /.mobile-menu -->
        <nav id="menu" class="stylehome1">
            <ul>
                <li><a href="index.php"><span>Anasayfa</span></a></li>
                <li><a href="category"><span>Eğitim Kataloğu</span></a></li>
                <li><a href="news"><span>Haberler</span></a></li>
                <li><a href="contact"><span>İletişim</span></a></li>
                <li><a href="login"><span class="flaticon-user"></span> Giriş Yap</a></li>
                <li><a href="register"><span class="flaticon-edit"></span> Kayıt Ol</a></li>
            </ul>
        </nav>
    </div>

    <?= $this->renderSection('content') ?>

    <!-- Our Footer -->
    <section class="footer_one">
        <div class="container">
            <div class="row">


                <div class="col-sm-6 col-md-6 col-md-3 col-lg-4">
                    <div class="footer_contact_widget">
                        <h4>İLETİŞİM</h4>
                        <p></p>
                        <p><strong>Adres:</strong> Şahintepe Mah. Mahmur Sok 124/2 <br>Başakşehir/Istanbul</p>
                        <?php if ($settings['site_phone']): ?>
                            <p><strong>Telefon:</strong> <?= $settings['site_phone'] ?></p>
                        <?php endif ?>
                        <?php if ($settings['site_gsm']): ?>
                            <p><strong>GSM:</strong> <?= $settings['site_gsm'] ?></p>
                        <?php endif ?>
                        <?php if ($settings['site_fax']): ?>
                            <p><strong>Fax:</strong> <?= $settings['site_fax'] ?></p>
                        <?php endif ?>
                        <?php if ($settings['site_email']): ?>
                            <p><strong>E-posta:</strong> <a href="mailto:<?= $settings['site_email'] ?>"><?= $settings['site_email'] ?></a></p>
                        <?php endif ?>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-md-3 col-lg-4">
                    <div class="footer_company_widget">
                        <h4>Firmamız</h4>
                        <ul class="list-unstyled">
                            <?php foreach (model('ContentsModel')->where('status',1)->findAll() as $content): ?>
                            <li><a href="/content/<?= $content['slug'] ?>"><?= $content['name'] ?></a></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-md-3 col-lg-4">
                    <div class="footer_apps_widget">
                        <h4>Mobil Uygulamalar</h4>
                        <div class="app_grid">
                            <button class="apple_btn btn-dark">
									<span class="icon">
										<span class="flaticon-apple"></span>
									</span>
                                <span class="title">App Store</span>
                                <span class="subtitle">Available now on the</span>
                            </button>
                            <button class="play_store_btn btn-dark">
									<span class="icon">
										<span class="flaticon-google-play"></span>
									</span>
                                <span class="title">Google Play</span>
                                <span class="subtitle">Get in on</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
</div>
</section>

<!-- Our Footer Middle Area -->
<section class="footer_middle_area p0">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-md-3 col-lg-3 col-xl-3 pb15 pt15">
                <div class="logo-widget home1">
                    <img class="img-fluid" src="<?= base_url('assets') ?>/images/header-logo.png" alt="<?= $settings['site_title'] ?>">
                    <span><?= $settings['site_title'] ?></span>
                </div>
            </div>
            <div class="col-sm-8 col-md-5 col-lg-6 col-xl-5 pb25 pt25 brdr_left_right">
                <div class="footer_menu_widget">
                    <ul>
                        <li class="list-inline-item"><a href="/">Anasayfa</a></li>
                        <?php foreach (model('ContentsModel')->where('status',1)->findAll() as $content): ?>

                            <li class="list-inline-item"><a href="content/<?= $content['slug'] ?>"><?= $content['name'] ?></a></li>
                        <?php endforeach ?>


                    </ul>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-3 col-xl-4 pb15 pt15">
                <div class="footer_social_widget mt15">
                    <ul>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-instagram"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-dribbble"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-google"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Footer Bottom Area -->
<section class="footer_bottom_area pt25 pb25">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="copyright-widget text-center">
                    <p>Copyright <?= $settings['site_title'] ?> © <?= date('Y') ?>. Tüm Hakları Gizlidir.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <img style = "margin-top:25px" width="498" height="35" src="<?= base_url('assets') ?>/img/logo-band.png" class="attachment-large size-large" alt="">
            </div>
        </div>
    </div>
</section>
<a class="scrollToHome" href="#"><i class="flaticon-up-arrow-1"></i></a>
</div>
<!-- Wrapper End -->
<script data-cfasync="false" src="<?= base_url('assets') ?>/js/email-decode.min.js"></script><script type="text/javascript" src="<?= base_url('assets') ?>/js/jquery-3.3.1.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/jquery-migrate-3.0.0.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/popper.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/jquery.mmenu.all.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/ace-responsive-menu.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/js/isotop.js"></script>
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
<script type="text/javascript" src="<?= base_url('assets') ?>/js/sweetalert2.all.min.js"></script>
<!-- Custom script for all pages -->
<script type="text/javascript" src="<?= base_url('assets') ?>/js/script.js"></script>

<script>
    $(document).ready(function () {
        $.removeFromCart = function (id) {
            $.get("/cart?remove_course=" + id, function (response) {
                $(".shop-checkouts").replaceWith($(".shop-checkouts", response));
                $(".order_sidebar_wrapper").replaceWith($(".order_sidebar_wrapper", response));
                $.renderCartWidget();
            });
        };

        $.renderCartWidget = function () {
            $.get("/cart", function (_response) {
                $(".cart_btn").html($(".cart_btn", _response).html());
            });
        };

        $.addToCart = function(id, btn = null) {
            $.post("/cart", {course_id: id}, function () {
                Swal.fire({
                    title: 'Başarılı!',
                    text: 'Kurs sepetinize eklendi',
                    icon: 'success',
                    confirmButtonText: 'Tamam'
                });

                if (btn) btn.remove();

                $.renderCartWidget();
            }, "JSON");
        };

       $('.login_btn').click(function () {
            var email = $('#login_email').val();
            var password = $('#login_password').val();

            $.post('/login',{email:email,password:password},function (response) {
                if(response.status == "success")
                    window.location.reload();
            },'json').fail(function($xhr) {
                var data = $xhr.responseJSON;
                if ($xhr.status == 422)
                    $('#login_message').text(data['errors']).show();
            });
       });

       $('.register_btn').click(function () {
           var name = $('#register_name').val();
           var username = $('#register_username').val();
           var email = $('#register_email').val();
           var password = $('#register_password').val();
           var pass_confirm = $('#register_repassword').val();
           $.post('/register',{name:name,username:username,email:email,password:password,pass_confirm:pass_confirm},function (response) {
               if(response.status == "success")
                   window.location.reload();
           },'json').fail(function($xhr) {
               var data = $xhr.responseJSON;
               if ($xhr.status == 422)
                   $('#register_message').text(data['errors']).show();
           });
       });

       $(".add-to-cart").click(function () {
           var id = $(this).data("id");
           $.addToCart(id, $(this));
       });

        $("body").on("click", ".remove-from-cart", function () {
            var id = $(this).data("id");
            $.removeFromCart(id);
        });
    }).ajaxStart(function () {
        $(".ajax_loader").show();
    }).ajaxStop(function () {
        $(".ajax_loader").hide();
    });
</script>

<!--begin::Page Vendors(used by this page) -->
<?= $this->renderSection('pageScripts') ?>
</body>

<!-- Mirrored from grandetest.com/theme/edumy-html/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 15 Aug 2020 11:27:36 GMT -->
</html>