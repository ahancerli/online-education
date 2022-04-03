<?= $this->extend('front/account/layout_account') ?>

<?= $this->section('content') ?>
    <div class="col-lg-12">
        <nav class="breadcrumb_widgets" aria-label="breadcrumb mb30">
            <h4 class="title float-left">Şifre Değiştir</h4>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
                <li class="breadcrumb-item"><a href="/account">Hesabım</a></li>
                <li class="breadcrumb-item active" aria-current="page">Şifre Değiştir</li>
            </ol>
        </nav>
    </div>
    <div class="col-lg-12">
        <div class="my_course_content_container">
            <div class="my_setting_content mb30">
                <div class="my_setting_content_header style2">
                    <div class="my_sch_title">
                        <h4 class="m0">Şifre Değiştir</h4>
                    </div>
                </div>
                <div class="row my_setting_content_details pb0">
                    <div class="col-xl-6">
                        <div class="password_change_form">
                            <form action="" method="post">
                                <?= view('Myth\Auth\Views\_message_block') ?>
                                <div class="form-group">
                                    <label for="exampleInputPassword2">Eski Şifreniz</label>
                                    <input class="form-control" type="password" placeholder="Eski Şifreniz" name="old_password" id="old_password" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword2">Yeni Şifreniz</label>
                                    <input class="form-control" type="password" placeholder="Yeni Şifreniz" id="new_password" name="new_password" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword3">Yeni Şifrenizi Tekrarlayın</label>
                                    <input class="form-control mb0" type="password" placeholder="Yeni Şifrenizi Tekrarlayın" id="new_pass_confirm" name="new_pass_confirm" required>
                                </div>
                                <div class="form-group">
                                <button style="width: 100%" type="submit" class="my_setting_savechange_btn btn btn-thm btn btn-brand btn-pill btn-elevate">Şifreyi Değiştir </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?= $this->endSection() ?>