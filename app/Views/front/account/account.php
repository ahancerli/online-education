<?= $this->extend('front/account/layout_account') ?>

<?= $this->section('content') ?>
<div class="col-lg-12">
    <nav class="breadcrumb_widgets" aria-label="breadcrumb mb30">
        <h4 class="title float-left">Hesabım</h4>
        <ol class="breadcrumb float-right">
            <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
            <li class="breadcrumb-item active" aria-current="page">Hesabım</li>
        </ol>
    </nav>
</div>

<div class="col-xl-12">
    <div class="application_statics">
        <div class="row">
            <div class="col-xl-6">
                <div class="my_profile_setting_input form-group">
                    <label for="formGroupExampleInput1">Ad Soyad</label>
                    <input type="text" class="form-control" disabled value="<?= user()->name?>">
                </div>
                <div class="my_profile_setting_input form-group">
                    <label for="formGroupExampleInput2">E-posta Adresi</label>
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
                    <input type="tel" class="form-control" disabled value="<?= user()->phone?>">
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>