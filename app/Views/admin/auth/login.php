<!DOCTYPE html>

<html lang="tr">

<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>Yönetim Paneli</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--begin::Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

    <!--end::Fonts -->

    <!--begin::Page Custom Styles(used by this page) -->
    <link href="<?= base_url('assets/admin') ?>/css/pages/login/login-6.css" rel="stylesheet" type="text/css" />

    <!--end::Page Custom Styles -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="<?= base_url('assets/admin') ?>/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/admin') ?>/css/style.bundle.css" rel="stylesheet" type="text/css" />

    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->
    <link href="<?= base_url('assets/admin') ?>/css/skins/header/base/light.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/admin') ?>/css/skins/header/menu/light.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/admin') ?>/css/skins/brand/dark.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/admin') ?>/css/skins/aside/dark.css" rel="stylesheet" type="text/css" />

    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="<?= base_url('assets/admin') ?>/media/logos/favicon.ico" />
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

<!-- begin:: Page -->
<div class="kt-grid kt-grid--ver kt-grid--root">
    <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v6 kt-login--signin" id="kt_login">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">
            <div class="kt-grid__item  kt-grid__item--order-tablet-and-mobile-2  kt-grid kt-grid--hor kt-login__aside">
                <div class="kt-login__wrapper">
                    <div class="kt-login__container">
                        <div class="kt-login__body">
                            <div class="kt-login__logo">
                                <a href="#">
                                    <img src="/assets/images/header-logo2.png">
                                </a>
                            </div>
                            <div class="kt-login__signin">
                                <div class="kt-login__head">
                                    <h3 class="kt-login__title">Giriş Yap</h3>
                                </div>
                                <?= view('Myth\Auth\Views\_message_block') ?>
                                <div class="kt-login__form">
                                    <form class="kt-form" action="" method="post" novalidate="novalidate" id="kt_login_form">
                                        <?= csrf_field() ?>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="E-posta veya kullanıcı adı" name="login" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control form-control-last" type="password" placeholder="Şifre" name="password">
                                        </div>
                                        <div class="kt-login__extra">
                                            <?php if ($config->allowRemembering): ?>
                                                <label class="kt-checkbox">
                                                    <input type="checkbox" name="remember" checked> Beni hatırla
                                                    <span></span>
                                                </label>
                                            <?php endif ?>
                                            <a href="javascript:;" id="kt_login_forgot">Şifremi Unuttum</a>
                                        </div>
                                        <div class="kt-login__actions">
                                            <button id="kt_login_signin_submit" class="btn btn-brand btn-pill btn-elevate">Giriş Yap</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--<div class="kt-login__signup">
                                <div class="kt-login__head">
                                    <h3 class="kt-login__title">Kayıt Ol</h3>
                                    <div class="kt-login__desc">Hesabınızı oluşturmak için lütfen gerekli bilgileri doldurun:</div>
                                </div>
                                <div class="kt-login__form">
                                    <form class="kt-form" action="" method="post">
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Ad Soyad" name="name">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="E-posta" name="email" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Kullanıcı Adı" name="username" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="password" placeholder="Şifre" name="password">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control form-control-last" type="password" placeholder="Şifreyi Tekrarla" name="pass_confirm">
                                        </div>
                                        <div class="kt-login__actions">
                                            <button id="kt_login_signup_submit" class="btn btn-brand btn-pill btn-elevate">Kayıt Ol</button>
                                            <button id="kt_login_signup_cancel" class="btn btn-outline-brand btn-pill">İptal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>-->
                            <div class="kt-login__forgot">
                                <div class="kt-login__head">
                                    <h3 class="kt-login__title">Şifremi Unuttum</h3>
                                    <div class="kt-login__desc">Şifrenizi sıfırlamak için lütfen e-posta adresinizi girin:</div>
                                </div>
                                <div class="kt-login__form">
                                    <form class="kt-form" action="" method="POST">
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="E-posta" name="email" id="kt_email" autocomplete="off">
                                        </div>
                                        <div class="kt-login__actions">
                                            <button id="kt_login_forgot_submit" class="btn btn-brand btn-pill btn-elevate">İstek Gönder</button>
                                            <button id="kt_login_forgot_cancel" class="btn btn-outline-brand btn-pill">İptal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="kt-login__account">
                        <span class="kt-login__account-msg">
                            Hesabınız yok mu?
                        </span>&nbsp;&nbsp;
                        <a href="javascript:void(0)" id="kt_login_signup" class="kt-login__account-link">Kayıt Ol!</a>
                    </div>-->
                </div>
            </div>
            <div class="kt-grid__item kt-grid__item--fluid kt-grid__item--center kt-grid kt-grid--ver kt-login__content" style="background-image: url(<?= base_url('assets/admin') ?>/media/bg/bg-4.jpg);">
                <div class="kt-login__section">
                    <div class="kt-login__block">
                        <h3 class="kt-login__title">Yönetim Paneline Hoş Geldiniz</h3>
                        <div class="kt-login__desc">
                            Yönetim paneline giriş yapmak için lütfen e-posta ve şifrenizi girin.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end:: Page -->

<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "dark": "#282a3c",
                "light": "#ffffff",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": [
                    "#c5cbe3",
                    "#a1a8c3",
                    "#3d4465",
                    "#3e4466"
                ],
                "shape": [
                    "#f0f3ff",
                    "#d9dffa",
                    "#afb4d4",
                    "#646c9a"
                ]
            }
        }
    };
</script>

<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="<?= base_url('assets/admin') ?>/plugins/global/plugins.bundle.js" type="text/javascript"></script>
<script src="<?= base_url('assets/admin') ?>/js/scripts.bundle.js" type="text/javascript"></script>

<!--end::Global Theme Bundle -->

<!--begin::Page Scripts(used by this page) -->
<script src="<?= base_url('assets/admin') ?>/js/pages/custom/login/login-general.js" type="text/javascript"></script>

<!--end::Page Scripts -->
</body>

<!-- end::Body -->
</html>