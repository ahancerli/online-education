<?= $this->extend('front/layout') ?>

<?= $this->section('pageStyles') ?>
<link rel="stylesheet" href="<?= base_url('assets/css') ?>/intlTelInput.min.css">
<style>
    .iti--allow-dropdown {width: 100%}
</style>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script src="<?= base_url('assets/js') ?>/intlTelInput.min.js"></script>
<script src="https://cdn.projesoft.com.tr/assets/dopayment/dopayment3/js/utils.js"></script>
<script src="https://cdn.projesoft.com.tr/assets/dopayment/dopayment3/js/jquery.inputmask.bundle.js"></script>
<script>
    $(function () {
        var input_gsm = document.querySelector(".country-gsm-phone");

        if ($(".country-gsm-phone").length) {
            window.intlTelInput(input_gsm, {
                preferredCountries: ['tr', 'us'],
                separateDialCode: true,
            });
        }

        $(window).load(function () {
            setTimeout(function () {
                if ($(".country-gsm-phone").length) {
                    var splace_gsm_1 = $('.country-gsm-phone').attr("placeholder");
                    var currentMask_gsm_s1 = splace_gsm_1.replace(/[0-9+]/ig, '9');
                    $('.country-gsm-phone').attr('placeholder', currentMask_gsm_s1);
                    $('.country-gsm-phone').inputmask({mask: currentMask_gsm_s1, keepStatic: true});
                }
            }, 500);

            if ($(".country-gsm-phone").length) {
                $('.country-gsm-phone').on('countrychange', function (e) {

                    var currentMask = $(this).attr('placeholder').replace(/[0-9+]/ig, '9');
                    $(this).attr('placeholder', currentMask);

                    $('.country-gsm-phone').inputmask({mask: currentMask, keepStatic: true});

                });
            }
        });

        if ($("[name=identity_number]").length) {
            $("[name=identity_number]").inputmask({"mask": "99999999999"});
        }

        $("#payment-form").submit(function (e) {
            const iti = window.intlTelInputGlobals.getInstance(input_gsm);

            if (!iti.isValidNumber()) {
                e.preventDefault();
                Swal.fire({title: 'Hata!', text: 'Lütfen geçerli bir telefon numarası giriniz.', icon: 'error'});
                return false;
            }

            $("[name=phone]").val(iti.getNumber());
        });

        $("body").on("click", "#complete-order", function () {
            $("#payment-form").submit();
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Inner Page Breadcrumb -->
<section class="inner_page_breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3 text-center">
                <div class="breadcrumb_content">
                    <h4 class="breadcrumb_title">Ödeme</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ödeme</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Shop Checkouts Content -->
<section class="shop-checkouts">
    <div class="container">
        <?php if (session()->has('checkout_form_content')): ?>
            <?= session('checkout_form_content') ?>
        <?php endif ?>
        <div class="row">
            <div class="col-md-12 col-lg-8 col-xl-8">
                <div class="checkout_form">
                    <!--<div class="heading text-center">
                        <p>Have a coupon? <span class="text-thm6">Click here to enter your code</span></p>
                    </div>-->
                    <div class="checkout_coupon ui_kit_button">
                        <!--<form class="form-inline form1">
                            <input class="form-control mr-sm-4" type="search" placeholder="Coupon Code" aria-label="Search">
                            <button type="button" class="btn">Apply Coupon</button>
                        </form>-->
                        <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger"><?= session('error') ?></div>
                        <?php endif ?>
                        <h4 class="mb15">Fatura Bilgileri</h4>
                        <form id="payment-form" class="form2" action="" method="post" novalidate="novalidate">
                            <?= csrf_field() ?>
                            <input type="hidden" name="phone" <?= $address['phone'] ?>>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Adınız *</label>
                                        <input name="name" class="form-control" required="required" type="text" value="<?= $address['name'] ?? old('name') ?>">
                                        <?php if(session('errors.name')) : ?>
                                        <small class="text-danger form-text"><?= session('errors.name') ?></small>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Soyadınız *</label>
                                        <input name="surname" class="form-control" required="required" type="text" value="<?= $address['surname'] ?? old('surname') ?>">
                                        <?php if(session('errors.surname')) : ?>
                                            <small class="text-danger form-text"><?= session('errors.surname') ?></small>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Telefon *</label>
                                        <div style="clear: both"></div>
                                        <input type="tel" class="form-control country-gsm-phone" data-error="Lütfen geçerli bir telefon numarası girin" value="<?= $address['phone'] ?? old('phone') ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Vergi No/Kimlik No *</label>
                                        <input type="text" name="identity_number" class="form-control" value="<?= $address['identity_number'] ?? old('identity_number') ?>">
                                        <?php if(session('errors.identity_number')) : ?>
                                            <small class="text-danger form-text"><?= session('errors.identity_number') ?></small>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputName3">Şirket (opsiyonel)</label>
                                        <input name="company_name" class="form-control" type="text" value="<?= $address['company_name'] ?? old('company_name') ?>">
                                        <?php if(session('errors.company_name')) : ?>
                                            <small class="text-danger form-text"><?= session('errors.company_name') ?></small>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Vergi Dairesi (opsiyonel)</label>
                                        <input type="text" name="tax_office" class="form-control" value="<?= $address['tax_office'] ?? old('tax_office') ?>">
                                        <?php if(session('errors.tax_office')) : ?>
                                            <small class="text-danger form-text"><?= session('errors.tax_office') ?></small>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="my_profile_select_box form-group">
                                        <label>Ülke *</label><br>
                                        <select name="country" class="selectpicker">
                                            <option value="Türkiye">Türkiye</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Şehir *</label>
                                        <input name="city" class="form-control" required="required" type="text" value="<?= $address['city'] ?? old('city') ?>">
                                        <?php if(session('errors.city')) : ?>
                                            <small class="text-danger form-text"><?= session('errors.city') ?></small>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>İlçe *</label>
                                        <input name="county" class="form-control" required="required" type="text" value="<?= $address['county'] ?? old('county') ?>">
                                        <?php if(session('errors.county')) : ?>
                                            <small class="text-danger form-text"><?= session('errors.county') ?></small>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Posta kodu *</label>
                                        <input name="postal_code" class="form-control" required="required" type="number" value="<?= $address['postal_code'] ?? old('postal_code') ?>">
                                        <?php if(session('errors.postal_code')) : ?>
                                            <small class="text-danger form-text"><?= session('errors.postal_code') ?></small>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Adres *</label>
                                        <textarea class="form-control" name="address" id="" cols="30" rows="6" required><?= $address['address'] ?? old('address') ?></textarea>
                                        <?php if(session('errors.address')) : ?>
                                            <small class="text-danger form-text"><?= session('errors.address') ?></small>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group mb0">
                                        <label class="ai_title" for="exampleInputTextArea">Ek Bilgi</label>
                                        <p>Sipariş notu (opsiyonel)</p>
                                        <textarea name="order_note" class="form-control" rows="7"><?= old('order_note') ?></textarea>
                                        <?php if(session('errors.order_note')) : ?>
                                            <small class="text-danger form-text"><?= session('errors.order_note') ?></small>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-4">
                <div class="order_sidebar_widget mb30">
                    <h4 class="title">Siparişiniz</h4>
                    <?php $totalPrice = 0; ?>
                    <ul>
                        <li class="subtitle"><p>Kurs <span class="float-right">Fiyat</span></p></li>
                        <?php foreach ($courses as $course): ?>
                            <?php
                                if ($course['discount_ratio'] > 0)
                                    $coursePrice = number_format($course['price'] - ($course['price'] * $course['discount_ratio'] / 100), 2);
                                else
                                    $coursePrice = number_format($course['price'], 2);

                                $totalPrice += $coursePrice;
                            ?>
                        <li><p><?= truncate($course['title'], 25) ?> <span class="float-right"><?= $coursePrice ?> TL</span></p></li>
                        <?php endforeach ?>
                        <li class="subtitle"><p>Ara toplam <span class="float-right"><?= number_format($totalPrice, 2) ?> TL</span></p></li>
                        <li class="subtitle"><p>Toplam <span class="float-right totals color-orose"><?= number_format($totalPrice, 2) ?> TL</span></p></li>
                    </ul>
                </div>
                <div class="ui_kit_button payment_widget_btn">
                    <button type="button" class="btn dbxshad btn-lg btn-thm3 circle btn-block" id="complete-order">Siparişi Tamamla</button>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
