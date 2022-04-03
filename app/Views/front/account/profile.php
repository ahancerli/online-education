<?= $this->extend('front/account/layout_account') ?>

<?= $this->section('content') ?>
    <div class="col-lg-12">
        <nav class="breadcrumb_widgets" aria-label="breadcrumb mb30">
            <h4 class="title float-left">Kişisel Bilgilerim</h4>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
                <li class="breadcrumb-item"><a href="/account">Hesabım</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profil</li>
            </ol>
        </nav>
    </div>
    <div class="col-lg-12">
        <div class="my_course_content_container">
            <div class="my_setting_content mb30">
                <div class="my_setting_content_header">
                    <div class="my_sch_title">
                        <h4 class="m0">Kişisel Bilgilerim</h4>
                    </div>
                </div>
                <form action="" method="post">

                    <div class="row my_setting_content_details pb0">

                        <div class="col-xl-12">
                            <?= view('Myth\Auth\Views\_message_block') ?>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="my_profile_setting_input form-group">
                                        <label for="formGroupExampleInput1">Adı Soyadı</label>
                                        <input type="text" class="form-control" name="name" id="name" value="<?= user()->name?>">
                                    </div>
                                    <div class="my_profile_setting_input form-group">
                                        <label for="formGroupExampleInput2">Email Adresi</label>
                                        <input type="text" class="form-control" disabled value="<?= user()->email?>">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="my_profile_setting_input form-group">
                                        <label for="formGroupExampleInput3">Kullanıcı Adı</label>
                                        <input type="text" class="form-control"  disabled value="<?= user()->username?>">
                                    </div>
                                    <div class="my_profile_setting_input form-group">
                                        <label for="exampleInputPhone">Telefon Numarası</label>
                                        <input type="tel" class="form-control" name="phone" id="phone" value="<?= user()->phone?>">
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <button style="width: 100%;" type="submit" class="my_setting_savechange_btn btn btn-thm btn_profile">Kaydet <span class="flaticon-right-arrow-1 ml15"></span></button>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
<?= $this->endSection() ?>