<?= $this->extend('front/layout') ?>

<?= $this->section('pageScripts') ?>
<script>
    $(function () {
        setTimeout(function () {
            $(".option-isotop ul li:first a").click();
        }, 300);
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- 2nd Home Slider -->
<div class="home1-mainslider">
    <div class="container-fluid p0">
        <div class="row">
            <div class="col-lg-12">
                <div class="main-banner-wrapper">
                    <div class="banner-style-one owl-theme owl-carousel">
                        <div class="slide slide-one" style="background-image: url(assets/images/home/1.jpg); height: 95vh;">
                            <div class="container">
                                <div class="row home-content">
                                    <div class="col-lg-12 text-center p0">
                                        <h3 class="banner-title">Orenda Akademi</h3>
                                        <p>En iyi dersler burada hizmetinizde...</p>
                                        <div class="btn-block"><a href="javascript:void(0)" class="banner-btn">Şimdi Başla</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="slide slide-one" style="background-image: url(assets/images/home/2.jpg);height: 95vh;">
                            <div class="container">
                                <div class="row home-content">
                                    <div class="col-lg-12 text-center p0">
                                        <h3 class="banner-title">Orenda Akademi</h3>
                                        <p>En iyi dersler burada hizmetinizde...</p>
                                        <div class="btn-block"><a href="javascript:void(0)" class="banner-btn">Şimdi Başla</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="slide slide-one" style="background-image: url(assets/images/home/3.jpg);height: 95vh;">
                            <div class="container">
                                <div class="row home-content">
                                    <div class="col-lg-12 text-center p0">
                                        <h3 class="banner-title">Orenda Akademi</h3>
                                        <p>En iyi dersler burada hizmetinizde...</p>
                                        <div class="btn-block"><a href="javascript:void(0)" class="banner-btn">Şimdi Başla</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-btn-block banner-carousel-btn">
                        <span class="carousel-btn left-btn"><i class="flaticon-left-arrow left"></i> <span class="left"></span></span>
                        <span class="carousel-btn right-btn"><span class="right"></span> <i class="flaticon-right-arrow-1 right"></i></span>
                    </div><!-- /.carousel-btn-block banner-carousel-btn -->
                </div><!-- /.main-banner-wrapper -->
            </div>
        </div>
    </div>
</div>

<?php if (count($categories) > 0): ?>
<!-- School Category Courses -->
<section id="our-courses" class="our-courses pt90 pt650-992">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <a href="#our-courses">
                    <div class="mouse_scroll">
                        <div class="icon"><span class="flaticon-download-arrow"></span></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="main-title text-center">
                    <h3 class="mt0">Popüler Kategoriler</h3>
                    <p>Popüler kategorilerimize göz atabilirsiniz.</p>
                </div>
            </div>
        </div>
        <div class="row">

            <?php foreach ($categories as $category): ?>
            <div class="col-sm-6 col-lg-3">
                <a href="/category?category_id%5B%5D=<?= $category['id'] ?>">
                    <div class="img_hvr_box" style="background-image: url(<?= base_url('assets') ?>/uploads/category/<?= $category['image_name'] ?>);">
                        <div class="overlay">
                            <div class="details">
                                <h5><?= $category['name'] ?></h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach ?>

            <div class="col-sm-12">
                <div class="courses_all_btn text-center">
                    <a class="btn btn-transparent" href="/category">Tümünü Gor</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif ?>

<?php if (count($categories) > 0): ?>
<!-- Top Courses -->
<section id="top-courses" class="top-courses pb30">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="main-title text-center">
                    <h3 class="mt0">Popüler Dersler</h3>
                    <p>En popüler derslerimize göz atabilirsiniz.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="options" class="alpha-pag full">
                    <div class="option-isotop">
                        <ul id="filter" class="option-set" data-option-key="filter">
                            <!--<li class="list-inline-item">
                                <a href="#all" data-option-value="*" class="selected">Tümü</a>
                            </li>-->
                            <?php foreach ($categories as $index => $category): ?>
                                <li class="list-inline-item">
                                    <a href="#<?= $category['slug'] ?>" data-option-value=".<?= $category['slug'] ?>"><?= $category['name'] ?></a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
                <!-- FILTER BUTTONS -->
                <div class="emply-text-sec">
                    <div class="row" id="masonry_abc">
                        <?php foreach ($categories as $category): ?>
                            <?php foreach ($category['courses'] as $course): ?>
                                <div class="col-md-6 col-lg-4 col-xl-3 <?= $category['slug'] ?>">
                                    <div class="top_courses">
                                        <?php if ($course['image_name']): ?>
                                        <div class="thumb">
                                            <img class="img-whp" src="<?= base_url('assets/uploads/course') ?>/<?= $course['image_name'] ?>">
                                            <div class="overlay">
                                                <a class="tc_preview_course" href="course/<?= $course['slug'] ?>"><?= $course['title'] ?></a>
                                            </div>
                                        </div>
                                        <?php endif ?>
                                        <div class="details">
                                            <div class="tc_content">
                                                <p><?= $course['instructor_name'] ?></p>
                                                <h5 onclick="window.location.href = '/course/<?= $course['slug'] ?>'"><?= $course['title'] ?></h5>
                                                <?php if ($course['avg_point'] > 0): ?>
                                                <ul class="tc_review">
                                                    <?php for ($i = 1; $i <= round($course['avg_point']); $i++): ?>
                                                    <li class="list-inline-item"><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                    <?php endfor ?>
                                                    <li class="list-inline-item"><a href="javascript:void(0)">(<?= number_format(round($course['avg_point']), 1) ?>)</a></li>
                                                </ul>
                                                <?php endif ?>
                                            </div>
                                            <div class="tc_footer">
                                                <ul class="tc_meta float-left">
                                                    <li class="list-inline-item"><a href="javascript:void(0)"><i class="flaticon-profile"></i></a></li>
                                                    <li class="list-inline-item"><a href="javascript:void(0)"><?= $course['user_count'] ?></a></li>
                                                    <li class="list-inline-item"><a href="javascript:void(0)"><i class="flaticon-comment"></i></a></li>
                                                    <li class="list-inline-item"><a href="javascript:void(0)"><?= $course['comment_count'] ?></a></li>
                                                </ul>
                                                <?php if ($course['discount_ratio'] > 0): ?>
                                                <div class="tc_price float-right"><?= number_format($course['price'] - ($course['price'] * $course['discount_ratio'] / 100), 2) ?> ₺</div>
                                                <?php else: ?>
                                                <div class="tc_price float-right"><?= number_format($course['price'], 2) ?> ₺</div>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif ?>
<?= $this->endSection() ?>
