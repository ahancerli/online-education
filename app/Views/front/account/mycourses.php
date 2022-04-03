<?= $this->extend('front/account/layout_account') ?>

<?= $this->section('content') ?>
<div class="col-lg-12">
    <nav class="breadcrumb_widgets" aria-label="breadcrumb mb30">
        <h4 class="title float-left">Kurslarım</h4>
        <ol class="breadcrumb float-right">
            <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
            <li class="breadcrumb-item"><a href="/account">Hesabım</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kurslarım</li>
        </ol>
    </nav>
</div>
<div class="col-lg-12">
    <div class="my_course_content_container">
        <div class="my_course_content mb30">
            <?php if (count($courses) == 0): ?>
            <p class="text-center" style="padding: 10px;">Satın aldığınız herhangi bir kurs bulunmamaktadır</p>
            <?php endif ?>
            <div class="my_course_content_list">
                <?php foreach ($courses as $course): ?>
                <div class="mc_content_list">
                    <?php if ($course['image_name']): ?>
                    <div class="thumb" style="max-width: 200px">
                        <img class="img-whp" src="<?= base_url('assets') ?>/uploads/course/<?= $course['image_name'] ?>">
                        <div class="overlay">
                            <a class="tc_preview_course" href="/course/<?= $course['slug'] ?>" style="position: relative; top: 45%; color: white">Kursa Git</a>
                        </div>
                    </div>
                    <?php endif ?>
                    <div class="details">
                        <div class="mc_content">
                            <p class="subtitle"><?= $course['instructor_name'] ?></p>
                            <h5 class="title"><?= $course['title'] ?></h5>
                        </div>
                        <div class="mc_footer">
                            <ul class="mc_review fn-414">
                                <?php if ($course['avg_point'] > 0): ?>
                                    <?php for ($i = 1; $i <= $course['avg_point']; $i++): ?>
                                        <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                    <?php endfor ?>
                                        <li class="list-inline-item"><a href="#">(<?= number_format(round($course['avg_point']), 1) ?>)</a></li>
                                <?php endif ?>
                                <li class="list-inline-item tc_price fn-414 <?= is_null($course['avg_point']) ? 'ml-0' : '' ?>">
                                    <a href="#">
                                        <?php if ($course['discount_ratio'] > 0): ?>
                                            <?= number_format($course['price'] - ($course['price'] * $course['discount_ratio'] / 100), 2) ?> ₺
                                        <?php else: ?>
                                            <?= number_format($course['price'], 2) ?> ₺
                                        <?php endif ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>