<?= $this->extend('admin/layout') ?>

<?= $this->section('contentHead') ?>
<h3 class="kt-subheader__title">Site Ayarları</h3>
<div class="kt-subheader__breadcrumbs">
    <a href="/admin" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>

    <a class="kt-subheader__breadcrumbs-link">Ayarlar</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>

    <a href="" class="kt-subheader__breadcrumbs-link">Site Ayarları</a>
</div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script>
    $(function () {
        <?php if (session()->has('message')) : ?>
        $.showSuccessNotification("<?= session('message') ?>");
        <?php endif ?>

        <?php if (session()->has('error')) : ?>
        $.showErrorNotification("<?= session('error') ?>");
        <?php endif ?>

        // phone number format
        $("input[name=site_phone], input[name=site_gsm], input[name=site_fax]").inputmask("mask", {
            "mask": "(999) 999-9999"
        });

        //email address
        $("input[name=site_email]").inputmask({
            mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
            greedy: false,
            onBeforePaste: function (pastedValue, opts) {
                pastedValue = pastedValue.toLowerCase();
                return pastedValue.replace("mailto:", "");
            },
            definitions: {
                '*': {
                    validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
                    cardinality: 1,
                    casing: "lower"
                }
            }
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="col-lg-12">

            <!--begin::Portlet-->
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Site Ayarları
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-right nav-tabs-line-brand" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_portlet_genel" role="tab">
                                    Genel
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_portlet_api" role="tab">
                                    API
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_portlet_iletisim" role="tab">
                                    İletişim
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_portlet_smtp" role="tab">
                                    SMTP
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <form action="" method="post">
                    <?= csrf_field() ?>
                <div class="kt-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="kt_portlet_genel">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Site Başlığı <small class="text-danger">(*)</small></label>
                                    <input type="text" name="site_title" class="form-control" value="<?= $siteSettings['site_title'] ?? old('site_title') ?>" required>
                                    <span class="form-text text-muted">Meta title etiket değeri</span>
                                </div>
                                <div class="col-lg-6">
                                    <label>Site Açıklaması</label>
                                    <textarea name="site_description" class="form-control" rows="4"><?= $siteSettings['site_description'] ?? old('site_description') ?></textarea>
                                    <span class="form-text text-muted">Meta description etiket değeri</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Yazar</label>
                                    <input type="text" name="site_author" class="form-control" value="<?= $siteSettings['site_author'] ?? old('site_author') ?>">
                                    <span class="form-text text-muted">Meta author etiket değeri</span>
                                </div>
                                <div class="col-lg-6">
                                    <label>Anahtar Kelimeler</label>
                                    <textarea name="site_keywords" class="form-control" rows="4"><?= $siteSettings['site_keywords'] ?? old('site_keywords') ?></textarea>
                                    <span class="form-text text-muted">Meta keywords etiket değeri</span>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="kt_portlet_api">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Google Analytics Kodu</label>
                                    <textarea name="google_analytics" class="form-control" rows="4"><?= $siteSettings['google_analytics'] ?? old('google_analytics') ?></textarea>
                                </div>
                                <div class="col-lg-6">
                                    <label>BulutChat Kodu</label>
                                    <textarea name="bulutchat_js" class="form-control" rows="4"><?= $siteSettings['bulutchat_js'] ?? old('bulutchat_js') ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="kt_portlet_iletisim">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Telefon</label>
                                    <input type="tel" name="site_phone" class="form-control" value="<?= $siteSettings['site_phone'] ?? old('site_phone') ?>">
                                </div>
                                <div class="col-lg-6">
                                    <label>E-posta</label>
                                    <input type="text" name="site_email" class="form-control" value="<?= $siteSettings['site_email'] ?? old('site_email') ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>GSM</label>
                                    <input type="tel" name="site_gsm" class="form-control" value="<?= $siteSettings['site_gsm'] ?? old('site_gsm') ?>">
                                </div>
                                <div class="col-lg-6">
                                    <label>Fax</label>
                                    <input type="text" name="site_fax" class="form-control" value="<?= $siteSettings['site_fax'] ?? old('site_fax') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="kt_portlet_smtp">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>SMTP Host</label>
                                    <input type="text" name="smtp_host" class="form-control" value="<?= $siteSettings['smtp_host'] ?? old('smtp_host') ?>">
                                </div>
                                <div class="col-lg-6">
                                    <label>SMTP Kullanıcı</label>
                                    <input type="text" name="smtp_user" class="form-control" value="<?= $siteSettings['smtp_user'] ?? old('smtp_user') ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>SMTP Şifre</label>
                                    <input type="text" name="smtp_password" class="form-control" value="<?= $siteSettings['smtp_password'] ?? old('smtp_password') ?>">
                                </div>
                                <div class="col-lg-6">
                                    <label>SMTP Port</label>
                                    <input type="text" name="smtp_port" class="form-control" value="<?= $siteSettings['smtp_port'] ?? old('smtp_port') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="submit" class="btn btn-success">Kaydet</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
