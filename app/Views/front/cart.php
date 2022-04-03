<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>

<!-- Inner Page Breadcrumb -->
<!-- Inner Page Breadcrumb -->
<section class="inner_page_breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3 text-center">
                <div class="breadcrumb_content">
                    <h4 class="breadcrumb_title">Sepet</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sepet</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $totalPrice = 0; ?>

<!-- Shop Checkouts Content -->
<section class="shop-checkouts">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8 col-xl-8">
                <?php if (count($courses) == 0): ?>
                <p class="text-center mt30">Sepetinizde herhangi bir kurs bulunmamaktadır</p>
                <?php endif?>

                <?php if (count($courses) > 0): ?>
                <div class="cart_page_form">
                    <form action="#">
                        <table class="table table-responsive">
                            <thead>
                                <tr class="carttable_row">
                                    <th class="cartm_title">Kurs Adı</th>
                                    <th class="cartm_title"></th>
                                    <th class="cartm_title"></th>
                                    <th class="cartm_title"></th>
                                    <th class="cartm_title">Fiyat</th>
                                </tr>
                            </thead>
                            <tbody class="table_body">
                            <?php foreach ($courses as $course): ?>
                                <tr>
                                    <td scope="row">
                                        <ul class="cart_list">
                                            <li class="list-inline-item pr15"><a href="javascript:void(0)" class="remove-from-cart" data-id="<?= $course['id'] ?>"><img src="<?= base_url('assets') ?>/images/shop/close.png" alt="close.png"></a></li>
                                            <?php if ($course['image_name']): ?>
                                            <li class="list-inline-item pr20">
                                                <a href="/course/<?= $course['slug'] ?>">
                                                    <img style="max-width: 80px" src="<?= base_url('assets') ?>/uploads/course/<?= $course['image_name'] ?>">
                                                </a>
                                            </li>
                                            <?php endif ?>
                                            <li class="list-inline-item"><a class="cart_title" href="/course/<?= $course['slug'] ?>"><?= $course['title'] ?></a></li>
                                        </ul>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <?php if ($course['discount_ratio'] > 0): ?>
                                        <?php $coursePrice = number_format($course['price'] - ($course['price'] * $course['discount_ratio'] / 100), 2); ?>
                                    <?php else: ?>
                                        <?php $coursePrice = number_format($course['price'], 2);  ?>
                                    <?php endif?>
                                    <?php $totalPrice += $coursePrice; ?>
                                    <td class="cart_total"><?= $coursePrice ?> TL</td>
                                </tr>
                            <?php endforeach ?>
                            </tbody>
                        </table>
                    </form>
                </div>
                <?php endif ?>
            </div>
            <div class="col-lg-4 col-xl-4 order_sidebar_wrapper">
                <div class="order_sidebar_widget mb30">
                    <h4 class="title">Sepet Toplam</h4>
                    <ul>
                        <li class="subtitle"><p>Ara Toplam <span class="float-right"><?= number_format($totalPrice, 2) ?> TL</span></p></li>
                        <li class="subtitle"><p>Toplam <span class="float-right totals color-orose"><?= number_format($totalPrice, 2) ?> TL</span></p></li>
                    </ul>
                </div>
                <?php if (count($courses) > 0): ?>
                <div class="ui_kit_button payment_widget_btn">
                    <button type="button" class="btn dbxshad btn-lg btn-thm3 circle btn-block" onclick="window.location.href = '/checkout'">Ödeme Yap</button>
                </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
