<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>
<!-- Inner Page Breadcrumb -->
<section class="inner_page_breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3 text-center">
                <div class="breadcrumb_content">
                    <h4 class="breadcrumb_title">Giriş Yap</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Giriş Yap</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our LogIn Register -->
<section class="our-log bgc-fa">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-6 offset-lg-3">
                <div class="login_form inner_page">
                    <form action="#">
                        <div class="heading">
                            <h3 class="text-center">Giriş Yap</h3>
                            <p class="text-center">Hesabınız yok mu? <a class="text-thm" href="/register">Kayıt Ol</a></p>
                        </div>
                        <div id="login_message" class="alert alert-danger login_message" style="display: none"></div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="email" placeholder="E-posta">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password" placeholder="Şifre">
                        </div>
                        <div class="form-group custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="rememberch">
                            <label class="custom-control-label" for="exampleCheck3">Beni Hatırla</label>
                            <a class="tdu btn-fpswd float-right" href="#">Şifremi Unuttum?</a>
                        </div>
                        <button type="button" class="btn btn-log btn-block btn-thm2 page_login_btn">Giriş Yap</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>




<?= $this->section('pageScripts') ?>

<script>

    $(document).ready(function () {
        $('.page_login_btn').click(function () {
            $('.page_login_btn').attr('disabled', true);
           var email = $('#email').val();
           var password = $('#password').val();

            $.post('/login',{email:email,password:password},function (response) {
                if(response.status == "success")
                    $(location).prop('href', 'index.php');
            },'json').fail(function($xhr) {
                var data = $xhr.responseJSON;
                if ($xhr.status == 422)
                    $('.login_message').text(data['errors']).show();
                $('.page_login_btn').attr('disabled', false);
            });


        });
    });
</script>
<?= $this->endSection() ?>