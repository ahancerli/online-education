<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>
<section class="inner_page_breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3 text-center">
                <div class="breadcrumb_content">
                    <h4 class="breadcrumb_title">TEŞEKKÜRLER</h4>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div>
                    <h3 class="text-success text-center">Ödemeniz Alındı</h3>
                    <p class="text-center">
                        <i class="fa fa-4x fa-check-circle text-success text-center"></i>
                    </p>
                    <p class="text-center">Ödeme işleminiz başarıyla gerçekleşti.</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt20">
            <div class="col-sm-12 col-md-3">
                <table class="table">
                    <tr>
                        <th>Sipariş Kodu:</th>
                        <td><?= $order_code ?></td>
                    </tr>
                    <tr>
                        <th>Sipariş Tutarı:</th>
                        <td><?= $amount ?> TL</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>