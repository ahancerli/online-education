<?= $this->extend('front/layout') ?>

<?= $this->section('pageScripts') ?>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
    function onSubmit(token) {
        document.getElementById("contact_form").submit();
    }
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Inner Page Breadcrumb -->
<section class="inner_page_breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3 text-center">
                <div class="breadcrumb_content">
                    <h4 class="breadcrumb_title">İletişim</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">İletişim</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It's Work -->
<section class="our-contact">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <div class="contact_localtion text-center">
                    <div class="icon"><span class="flaticon-placeholder-1"></span></div>
                    <h4>Adres</h4>
                    <p>Şahintepe Mah. Mahmur Sok 124/2 <br>Başakşehir/Istanbul</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="contact_localtion text-center">
                    <div class="icon"><span class="flaticon-phone-call"></span></div>
                    <h4>Telefon</h4>
                    <p class="mb0">GSM: <?= $settings['site_gsm'] ?> <br> Fax: <?= $settings['site_fax'] ?></p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="contact_localtion text-center">
                    <div class="icon"><span class="flaticon-email"></span></div>
                    <h4>E-posta</h4>
                    <p><a href="javascript:void(0)"><?= $settings['site_email'] ?></a></p>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-12 form_grid">
                <h4 class="mb5">Bize Yazın</h4>
                <p>Değerli görüş ve önerilerinizi belirtmek için bize yazabilirsiniz.</p>
                <?= view('Myth\Auth\Views\_message_block') ?>
                <form class="contact_form" id="contact_form" name="contact_form" action="" method="post">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputName">Adınız ve Soyadınız <small class="text-danger ">(*)</small></label>
                                <input id="form_name" name="form_name" class="form-control" required="required" type="text" placeholder="Ad Soyad" value="<?= old('form_name') ?>">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputEmail">E-posta Adresiniz <small class="text-danger ">(*)</small></label>
                                <input id="form_email" name="form_email" class="form-control required email" required="required" type="email" placeholder="E-posta" value="<?= old('form_email') ?>">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputSubject">Konu <small class="text-danger ">(*)</small></label>
                                <input id="form_subject" name="form_subject" class="form-control required" required="required" type="text" placeholder="Konu" value="<?= old('form_subject') ?>">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mesajınız <small class="text-danger ">(*)</small></label>
                                <textarea id="form_message" name="form_message" class="form-control required" rows="5" required="required" placeholder="Mesaj" value="<?= old('form_message') ?>"></textarea>
                            </div>
                            <div class="form-group ui_kit_button mb0">
                                <button type="button"
                                        class="btn dbxshad btn-thm circle white g-recaptcha"
                                        data-sitekey="6Lfkbs0ZAAAAAC3ZaGDxETQ1RACjfkySHrJeyLDK"
                                        data-callback='onSubmit'
                                        data-action='submit'>Gönder</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
