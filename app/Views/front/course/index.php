<?= $this->extend('front/layout') ?>

<?= $this->section('pageScripts') ?>
<script>
    $(function () {
        var commentLimit = 10;

        $(".btn-send-comment").click(function () {
            var thisBtn = $(this);
            var comment = $(".comments_form textarea[name=comment]").val();
            if (!comment.trim()) {
                Swal.fire({title: 'Hata!', text: 'Lütfen yorumunuzu girin', icon: 'error'});
                return;
            }

            var point = $(".comments_form input[name=point]:checked").val();
            var body = {course_id: <?= $course['id'] ?>, comment: comment, point: point ? parseInt(point) : 0};

            thisBtn.attr("disabled", true);

            $.post("/course/add_comment", body, function (response) {
                $(".comments_form textarea[name=comment]").val("");
                $(".comments_form input[name=point]").prop("checked", false);

                thisBtn.removeAttr("disabled");

                Swal.fire({
                    title: 'Başarılı!',
                    text: response.message,
                    icon: 'success'
                });
            }, "JSON");
        });

        $("body").on("click", ".more-review-btn", function () {
            $.get("?comment_limit=" + commentLimit, function (response) {
                if ($(".mbp_pagination_comments", response).length > 0) {
                    $(".mbp_pagination_comments").replaceWith($(".mbp_pagination_comments", response));
                    commentLimit += 5;
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
helper('cookie');
$cart = get_cookie('cart') ? json_decode(get_cookie('cart'), true) : []
?>

<!-- Inner Page Breadcrumb -->
<section class="inner_page_breadcrumb csv3">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="breadcrumb_content">
                    <div class="cs_row_one csv3">
                        <div class="cs_ins_container">
                            <div class="cs_instructor">
                                <ul class="cs_instrct_list float-left mb0">
                                    <?php if ($course['instructor_image']): ?>
<!--                                    <li class="list-inline-item"><img class="thumb rounded-circle" src="--><?//= base_url('assets')  ?><!--/uploads/user/--><?//= $course['instructor_image'] ?><!--" alt="4.png"></li>-->
                                    <?php endif ?>
                                    <li class="list-inline-item"><a class="color-white" href="#"><?= $course['instructor_name'] ?></a></li>
                                    <?php if (count($lessons) > 0):  ?>
                                    <li class="list-inline-item"><a class="color-white" href="#">Son güncelleme <?= date('m/Y', strtotime($lessons[count($lessons) - 1]['updated_at'])) ?></a></li>
                                    <?php else: ?>
                                    <li class="list-inline-item"><a class="color-white" href="#">Son güncelleme <?= date('m/Y', strtotime($course['updated_at'])) ?></a></li>
                                    <?php endif ?>
                                </ul>
                            </div>
                            <h3 class="cs_title color-white"><?= $course['title'] ?></h3>
                            <?php if ($course['rating_count'] > 0): ?>
                            <ul class="cs_review_seller">
                                <li></li>
                                <?php for ($i = 1; $i <= $course['avg_point']; $i++): ?>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                <?php endfor ?>
                                <li class="list-inline-item"><a class="color-white" href="#"><?= number_format(round($course['avg_point']), 1) ?> (<?= number_format($course['rating_count']) ?> değerlendirme)</a></li>
                            </ul>
                            <?php endif ?>
                            <ul class="cs_review_enroll">
                                <?php if ($course['student_count'] > 0): ?>
                                <li class="list-inline-item"><a class="color-white" href="#"><span class="flaticon-profile"></span> <?= number_format($course['student_count']) ?> öğrenci kaydoldu</a></li>
                                <?php endif ?>
                                <?php if (count($comments) > 0): ?>
                                <li class="list-inline-item"><a class="color-white" href="#"><span class="flaticon-comment"></span> <?= number_format(count($comments)) ?> Yorum</a></li>
                                <?php endif ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Team Members -->
<section class="our-team pb40">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8 col-xl-9">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="courses_single_container">
                            <?= html_entity_decode($course['description']) ?>
                            <?php if ($course['course_type_id'] == 100): ?>
                            <!-- Offline -->
                            <div class="cs_row_three">
                                <div class="course_content b0p0">
                                    <div class="cc_headers">
                                        <h4 class="title">Kurs İçeriği</h4>
                                        <ul class="course_schdule float-right">
                                            <li class="list-inline-item"><a href="#"><?= count($lessons) ?> ders</a></li>
                                        </ul>
                                    </div>
                                    <br>
                                    <?php foreach ($sections as $index => $section): ?>
                                    <div class="details">
                                        <div id="accordion" class="panel-group cc_tab">
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a href="#panelBodyCourseSection<?= $section['id'] ?>" class="accordion-toggle link <?= $index > 0 ? 'collapsed' : '' ?>" data-toggle="collapse" data-parent="#accordion"><?= $section['name'] ?></a>
                                                    </h4>
                                                </div>
                                                <div id="panelBodyCourseSection<?= $section['id'] ?>" class="panel-collapse collapse <?= $index == 0 ? 'show' : '' ?>">
                                                    <div class="panel-body">
                                                        <ul class="cs_list mb0">
                                                            <?php $sectionLessons = array_filter($lessons, function ($lesson) use ($section) { return $lesson['section_id'] == $section['id']; }) ?>
                                                            <?php foreach ($sectionLessons as $lesson): ?>
                                                                <?php if ($enrolled): ?>
                                                                    <li><a href="/player/<?= $course['slug'] ?>/lecture/<?= $lesson['vimeo_id'] ?>"><span class="flaticon-play-button-1 icon"></span> <?= $lesson['name'] ?> <span class="cs_preiew">İzle</span></a></li>
                                                                <?php else: ?>
                                                                    <li><a><span class="flaticon-play-button-1 icon"></span> <?= $lesson['name'] ?> </a></li>
                                                                <?php endif ?>
                                                            <?php endforeach ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                            <?php elseif ($course['course_type_id'] == 101): ?>
                            <!-- Live Streaming -->
                            <div class="cs_row_one">
                                <div class="cs_ins_container">
                                    <?php if ($enrolled): ?>
                                    <div class="courses_big_thumb">
                                        <div class="thumb">
                                            <iframe class="iframe_video" src="https://player.vimeo.com/video/<?= $course['vimeo_id'] ?>" frameborder="0" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                    <div class="alert alert-warning mt50 mb50">
                                        <p class="text-center">
                                            <i class="fa fa-2x fa-lock"></i>
                                            <br>
                                            Canlı derse katılabilmek için kursu satın almalısınız.
                                        </p>
                                    </div>
                                    <?php endif ?>
                                </div>
                            </div>
                            <?php elseif ($course['course_type_id'] == 102): ?>
                            <!-- Face to Face -->
                            <div class="cs_row_three">
                                <div class="course_content b0p0">
                                    <?php if ($enrolled): ?>
                                    <div class="alert alert-success mt50 mb50 text-center">
                                        <a href="/assets/uploads/document/<?= $course['document_name'] ?>" target="_blank">
                                            <i class="fa fa-2x fa-download"></i>
                                            <br>
                                            Ders programını indir
                                        </a>
                                    </div>
                                    <?php else: ?>
                                    <div class="alert alert-warning mt50 mb50">
                                        <p class="text-center">
                                            <i class="fa fa-2x fa-lock"></i>
                                            <br>
                                            Derse kayıt olmak ve ders programını indirebilmek için kursu satın almalısınız.
                                        </p>
                                    </div>
                                    <?php endif ?>
                                </div>
                            </div>
                            <?php elseif ($course['course_type_id'] == 103): ?>
                            <!-- Document -->
                            <div class="cs_row_three">
                                <div class="course_content b0p0">
                                    <div class="cc_headers">
                                        <h4 class="title">Kurs İçeriği</h4>
                                        <ul class="course_schdule float-right">
                                            <li class="list-inline-item"><a href="#"><?= count($lessons) ?> ders</a></li>
                                        </ul>
                                    </div>
                                    <br>
                                    <?php foreach ($sections as $index => $section): ?>
                                        <div class="details">
                                            <div id="accordion" class="panel-group cc_tab">
                                                <div class="panel">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a href="#panelBodyCourseSection<?= $section['id'] ?>" class="accordion-toggle link <?= $index > 0 ? 'collapsed' : '' ?>" data-toggle="collapse" data-parent="#accordion"><?= $section['name'] ?></a>
                                                        </h4>
                                                    </div>
                                                    <div id="panelBodyCourseSection<?= $section['id'] ?>" class="panel-collapse collapse <?= $index == 0 ? 'show' : '' ?>">
                                                        <div class="panel-body">
                                                            <ul class="cs_list mb0">
                                                                <?php $sectionLessons = array_filter($lessons, function ($lesson) use ($section) { return $lesson['section_id'] == $section['id']; }) ?>
                                                                <?php foreach ($sectionLessons as $lesson): ?>
                                                                    <?php if ($enrolled): ?>
                                                                        <li>
                                                                            <a href="/assets/uploads/document/<?= $lesson['document_name'] ?>" target="_blank">
                                                                                <span class="flaticon-download icon"></span> <?= $lesson['name'] ?> <span class="cs_preiew">İndir</span>
                                                                            </a>
                                                                        </li>
                                                                    <?php else: ?>
                                                                        <li><a><span class="flaticon-download icon"></span> <?= $lesson['name'] ?> </a></li>
                                                                    <?php endif ?>
                                                                <?php endforeach ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                            <?php endif ?>
                            <div class="cs_row_four">
                                <div class="about_ins_container b0p0">
                                    <h4 class="aii_title">Eğitmen Hakkında</h4>
                                    <?php if ($course['instructor_image']): ?>
                                    <div class="about_ins_info">
                                        <div class="thumb"><img class="thumb rounded" src="<?= base_url('assets')  ?>/uploads/user/<?= $course['instructor_image'] ?>" style="max-width: 120px"></div>
                                    </div>
                                    <?php endif ?>
                                    <div class="details">
                                        <ul class="about_info_list">
                                            <li class="list-inline-item"><span class="flaticon-play-button-1"></span> <?= $instructorCourses ?> Kurs </li>
                                        </ul>
                                        <h4><?= $course['instructor_name'] ?></h4>
                                        <p class="subtitle"><?= $course['instructor_title'] ?></p>
                                        <?= $course['instructor_description'] ?>
                                    </div>
                                </div>
                            </div>
                            <div style="clear: both"></div>
                            <div class="cs_row_five" style="margin-top: 40px">
                                <div class="student_feedback_container b0p0">
                                    <h4 class="aii_title">Öğrenci değerlendirmeleri</h4>
                                    <div class="s_feeback_content">
                                        <ul class="skills">
                                            <li class="list-inline-item">5 Yıldız</li>
                                            <li class="list-inline-item progressbar1" data-width="<?= $ratingPercent[5] ?? 0 ?>" data-target="100">%<?= $ratingPercent[5] ?? 0 ?></li>
                                        </ul>
                                        <ul class="skills">
                                            <li class="list-inline-item">4 Yıldız</li>
                                            <li class="list-inline-item progressbar2" data-width="<?= $ratingPercent[4] ?? 0 ?>" data-target="100">%<?= $ratingPercent[4] ?? 0 ?></li>
                                        </ul>
                                        <ul class="skills">
                                            <li class="list-inline-item">3 Yıldız</li>
                                            <li class="list-inline-item progressbar3" data-width="<?= $ratingPercent[3] ?? 0 ?>" data-target="100">%<?= $ratingPercent[3] ?? 0 ?></li>
                                        </ul>
                                        <ul class="skills">
                                            <li class="list-inline-item">2 Yıldız</li>
                                            <li class="list-inline-item progressbar4" data-width="<?= $ratingPercent[2] ?? 0 ?>" data-target="100">%<?= $ratingPercent[2] ?? 0 ?></li>
                                        </ul>
                                        <ul class="skills">
                                            <li class="list-inline-item">1 Yıldız</li>
                                            <li class="list-inline-item progressbar5" data-width="<?= $ratingPercent[1] ?? 0 ?>" data-target="100">%<?= $ratingPercent[1] ?? 0 ?></li>
                                        </ul>
                                    </div>
                                    <div class="aii_average_review text-center">
                                        <div class="av_content">
                                            <h2><?= number_format(round($course['avg_point']), 1) ?></h2>
                                            <ul class="aii_rive_list mb0">
                                                <?php for ($i = 1; $i <= $course['avg_point']; $i++): ?>
                                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                <?php endfor ?>
                                            </ul>
                                            <p>Kurs Puanı</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if (count($comments) > 0): ?>
                            <div class="cs_row_six" style="margin-top: 60px">
                                <div class="sfeedbacks b0p0">
                                    <h4 class="aii_title">Yorumlar</h4>
                                    <div class="mbp_pagination_comments">
                                        <?php foreach ($comments as $index => $comment): ?>
                                        <div class="mbp_first media csv1 <?= $index > 0 ? 'mt30' : '' ?>">
                                            <?php if ($comment['profile_image']): ?>
                                            <img src="<?= base_url('assets')  ?>/uploads/user/<?= $comment['profile_image'] ?>" class="align-self-start mr-3 rounded" alt="review1.png">
                                            <?php endif ?>
                                            <div class="media-body">
                                                <h4 class="sub_title mt-0"><?= $comment['user_name'] ?>
                                                    <?php if ($comment['point'] > 0): ?>
                                                    <span class="sspd_review float-right">
                                                        <ul>
                                                            <?php for ($i = 1; $i <= $comment['point']; $i++): ?>
                                                            <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                                            <?php endfor ?>
                                                            <li class="list-inline-item"></li>
                                                        </ul>
                                                    </span>
                                                    <?php endif ?>
                                                </h4>
                                                <a class="sspd_postdate fz14" href="#"><?= $comment['created_at'] ?></a>
                                                <p class="fz15 mt20"><?= $comment['comment'] ?></p>
                                            </div>
                                        </div>
                                        <?php if ($index != count($comments) - 1): ?>
                                        <div class="custom_hr_2"></div>
                                        <?php endif ?>
                                        <?php endforeach ?>
                                        <?php if ($commentCount != count($comments)): ?>
                                        <div class="text-center mt50">
                                            <div class="custom_hr"></div>
                                            <button type="button" class="more-review-btn btn">Daha fazla göster</button>
                                        </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif ?>
                            <?php if ($enrolled): ?>
                            <div class="cs_row_seven">
                                <div class="sfeedbacks b0p0">
                                    <div class="mbp_comment_form style2 pb0">
                                        <form class="comments_form">
                                            <h4 class="mb0">Yorum Ekle & Değerlendir</h4>
                                            <ul>
                                                <li class="list-inline-item pr15"><p>Bu kursu nasıl buldunuz?</p></li>
                                                <li class="list-inline-item">
                                                    <span class="user-rating">
                                                        <input type="radio" name="point" value="5"><span class="star"></span>
                                                        <input type="radio" name="point" value="4"><span class="star"></span>
                                                        <input type="radio" name="point" value="3"><span class="star"></span>
                                                        <input type="radio" name="point" value="2"><span class="star"></span>
                                                        <input type="radio" name="point" value="1"><span class="star"></span>
                                                    </span>
                                                </li>
                                            </ul>
                                            <div class="form-group">
                                                <label for="textarea_comment">Yorumunuz</label>
                                                <textarea class="form-control" name="comment" id="textarea_comment" rows="6" required></textarea>
                                            </div>
                                            <button type="button" class="btn btn-thm btn-send-comment">Yorumu Gönder <span class="flaticon-right-arrow-1"></span></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <?php if (count($relatedCourses) > 0): ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="r_course_title">Benzer Kurslar</h3>
                        </div>
                        <?php foreach ($relatedCourses as $relatedCourse): ?>
                        <div class="col-lg-6 col-xl-4">
                            <div class="top_courses">
                                <div class="thumb">
                                    <?php if ($relatedCourse['image_name']): ?>
                                    <img class="img-whp" src="<?= base_url('assets')  ?>/uploads/course/<?= $relatedCourse['image_name'] ?>" alt="t1.jpg">
                                    <?php else: ?>
                                    <img class="img-whp" src="<?= base_url('assets')  ?>/images/courses/t1.jpg" alt="t1.jpg">
                                    <?php endif ?>
                                    <div class="overlay">
                                        <a class="tc_preview_course" href="/course/<?= $relatedCourse['slug'] ?>">Kursa Git</a>
                                    </div>
                                </div>
                                <div class="details">
                                    <div class="tc_content">
                                        <p><?= $relatedCourse['instructor_name'] ?></p>
                                        <h5><?= $relatedCourse['title'] ?></h5>
                                        <ul class="tc_review">
                                            <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                            <li class="list-inline-item"><a href="#">(6)</a></li>
                                        </ul>
                                    </div>
                                    <div class="tc_footer">
                                        <ul class="tc_meta float-left">
                                            <li class="list-inline-item"><a href="#"><i class="flaticon-profile"></i></a></li>
                                            <li class="list-inline-item"><a href="#">1548</a></li>
                                            <li class="list-inline-item"><a href="#"><i class="flaticon-comment"></i></a></li>
                                            <li class="list-inline-item"><a href="#"><?= $relatedCourse['comment_count'] ?></a></li>
                                        </ul>
                                        <div class="tc_price float-right">
                                            <?php if ($relatedCourse['discount_ratio'] > 0): ?>
                                                <?= number_format($relatedCourse['price'] - ($relatedCourse['price'] * $relatedCourse['discount_ratio'] / 100), 2) ?>
                                            <?php else: ?>
                                                <?= number_format($relatedCourse['price'], 2) ?> ₺
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>
            </div>
            <div class="col-lg-4 col-xl-3">
                <div class="instructor_pricing_widget">
                    <div class="price">
                        <?php if($course['discount_ratio'] > 0): ?>
                            <span>Fiyat</span> <?= number_format($course['price'] - ($course['price'] * $course['discount_ratio'] / 100), 2) ?> ₺
                            <small><?= number_format($course['price'], 2) ?> ₺</small>
                        <?php else: ?>
                            <span>Fiyat</span> <?= number_format($course['price'], 2) ?> ₺
                        <?php endif ?>
                    </div>
                    <?php if (!$enrolled && !in_array($course['id'], $cart)): ?>
                    <a href="javascript:void(0)" class="cart_btnss add-to-cart" data-id="<?= $course['id'] ?>">Sepete Ekle</a>
                    <?php endif ?>
                    <h5 class="subtitle text-left">Kurs özellikleri</h5>
                    <ul class="price_quere_list text-left">
                        <li><a href="#"><span class="flaticon-key-1"></span> Ömür boyu erişim</a></li>
                        <li><a href="#"><span class="flaticon-responsive"></span> Mobil ve TV'den erişim</a></li>
                        <li><a href="#"><span class="flaticon-award"></span> Bitirme sertifikası</a></li>
                    </ul>
                </div>
                <div class="selected_filter_widget style2">
                    <span class="float-left"><img class="mr20" src="<?= base_url('assets')  ?>/images/resource/2.png" alt="2.png"></span>
                    <h4 class="mt15 fz20 fw500">Sertifika mevcut mu?</h4>
                    <br>
                    <p>Kursu tamamladığınızda sertfika garanti</p>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
