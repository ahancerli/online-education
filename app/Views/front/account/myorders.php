<?= $this->extend('front/account/layout_account') ?>

<?= $this->section('pageScripts') ?>
<script>
    $(function () {
        var orders = <?= json_encode($orders, true); ?>;

        $(".btn-show-detail").click(function () {
            var id = $(this).data("id");

            var order = orders.find(function(x) { return x.id == id; });

            $("#orderDetailModal table tbody").html("");

            $.each(order.courses, function (index, course) {
                var price = 0;

                if (course.discount_ratio > 0) price = course.price - (course.price * course.discount_ratio / 100);
                else price = course.price;

                $("#orderDetailModal table tbody").append('<tr><td>'+ course.title +'</td><td>'+ parseFloat(price).toFixed(2) +' TL</td></tr>');
            });

            $("#orderDetailModal").modal("show");
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="col-lg-12">
        <nav class="breadcrumb_widgets" aria-label="breadcrumb mb30">
            <h4 class="title float-left">Siparişlerim</h4>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
                <li class="breadcrumb-item"><a href="/account">Hesabım</a></li>
                <li class="breadcrumb-item active" aria-current="page">Siparişlerim</li>
            </ol>
        </nav>
    </div>
<div class="col-lg-12">
    <div class="my_course_content_container">
        <div class="my_setting_content">
            <div class="my_setting_content_header">
                <div class="my_sch_title">
                    <h4 class="m0">Siparişlerim</h4>
                </div>
            </div>
            <div class="my_setting_content_details">
                <div class="cart_page_form style2">
                    <table class="table table-responsive">
                            <thead>
                            <tr class="carttable_row">
                                <th class="cartm_title">Sipariş Kodu</th>
                                <th class="cartm_title">Tarih</th>
                                <th class="cartm_title">Tutar</th>
                                <th class="cartm_title">Eylem</th>
                            </tr>
                            </thead>
                            <tbody class="table_body">
                                <?php if (count($orders)==0): ?>
                                <tr>
                                    <th style="width: 100%" scope="row">
                                       LİSTELENECEK BİR SİPARİŞİNİZ BULUNMAMAKTADIR
                                    </th>
                                </tr>
                                <?php endif; ?>

                                <?php foreach ($orders as $order): ?>
                                <tr>
                                    <th scope="row">
                                        <?= $order['order_code'] ?>
                                    </th>
                                    <th style="width: 30%" scope="row">
                                        <?= $order['created_at'] ?>
                                    </th>
                                    <th style="width: 30%" scope="row">
                                        <?= number_format($order['amount'], 2) ?> TL
                                    </th>
                                    <th style="width: 10%" scope="row">
                                        <a href="javascript:void(0)" class="btn-show-detail" data-id="<?= $order['id'] ?>">Detay</a>
                                    </th>
                                </tr>
                            <?php endforeach; ?>

                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="orderDetailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sipariş Detay</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kurs Adı</th>
                                <th>Fiyat</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>