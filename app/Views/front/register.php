<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>

<!-- Inner Page Breadcrumb -->
<section class="inner_page_breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3 text-center">
                <div class="breadcrumb_content">
                    <h4 class="breadcrumb_title">Kayıt Ol</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kayıt Ol</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our LogIn Register -->
<section class="our-log-reg bgc-fa">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-6 offset-lg-3">
                <div class="sign_up_form inner_page">
                    <div class="heading">
                        <h3 class="text-center">Kayıt Ol</h3>
                        <p class="text-center">Hesabınız var mı? <a class="text-thm" href="login">Giriş Yap</a></p>
                    </div>
                    <div class="details">
                        <form action="#">
                            <div id="login_message" class="alert alert-danger login_message" style="display: none"></div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="page_register_name" placeholder="Ad Soyad">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="page_register_username" placeholder="Kullanıcı Adı">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" id="page_register_email" placeholder="E-posta Adresi">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="page_register_password" placeholder="Şifre">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="page_register_repassword" placeholder="Şifre Tekrar">
                            </div>

                            <button type="button" class="btn btn-log btn-block btn-thm2 page_register_btn">Kayıt Ol</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>


<?= $this->section('pageScripts') ?>

<script>

    $(document).ready(function () {
        $('.page_register_btn').click(function () {
            $('.page_register_btn').attr('disabled', true);
            var name = $('#page_register_name').val();
            var username = $('#page_register_username').val();
            var email = $('#page_register_email').val();
            var password = $('#page_register_password').val();
            var pass_confirm = $('#page_register_repassword').val();
            $.post('/register',{name:name,username:username,email:email,password:password,pass_confirm:pass_confirm},function (response) {
                if(response.status == "success")
                    $(location).prop('href', 'index.php');
            },'json').fail(function($xhr) {
                var data = $xhr.responseJSON;
                if ($xhr.status == 422)
                    $('.register_message').text(data['errors']).show();
                $('.page_register_btn').attr('disabled', false);
            });
        });

    });
</script>
<?= $this->endSection() ?>
