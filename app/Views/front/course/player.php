<?= $this->extend('front/layout') ?>

<?php helper('array') ?>

<?= $this->section('pageScripts') ?>
<script>
    $(function () {
        var lessonCount = <?= count($lessons) ?>;

        $("input[name='lesson_id[]']").change(function () {
            if($(this).is(":checked")) {
                $.post("/lesson/mark_as_watched/" + $(this).val(), function (response) {

                }, "JSON");
            } else {
                $.post("/lesson/mark_as_unwatched/" + $(this).val(), function (response) {

                }, "JSON");
            }

            if ($("input[name='lesson_id[]']:checked").length === lessonCount) {
                $("#btn-complete-course").removeClass("disabled");
                $("#btn-complete-course").removeAttr("disabled");
            } else {
                $("#btn-complete-course").addClass("disabled");
                $("#btn-complete-course").attr("disabled", true);
            }
        });

        $("#btn-complete-course").click(function () {
            if ($("input[name='lesson_id[]']:checked").length !== lessonCount)
                return;

            var thisBtn = $(this);

            $.post("/course/complete_course/<?= $course['id'] ?>", function (response) {
                thisBtn.attr("disabled", true);
                thisBtn.addClass("disabled");

                Swal.fire({
                    title: 'Başarılı!',
                    text: response.message,
                    icon: 'success'
                });
            }, "JSON").fail(function (xhr) {
                Swal.fire({
                    title: 'Hata!',
                    text: xhr.responseJSON.message,
                    icon: 'error'
                });
            });
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <!-- Inner Page Breadcrumb -->
    <section class="inner_page_breadcrumb csv1">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 offset-xl-3 text-center">
                    <div class="breadcrumb_content">
                        <h4 class="breadcrumb_title"><?= $course['title'] ?></h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><?= $currentLesson['name'] ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Team Members -->
    <section class="our-team pb40">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-7 col-xl-7">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="courses_single_container">
                                <div class="cs_row_one">
                                    <div class="cs_ins_container">
                                        <div class="courses_big_thumb">
                                            <div class="thumb">
                                                <iframe class="iframe_video" src="https://player.vimeo.com/video/<?= $currentLesson['vimeo_id'] ?>" frameborder="0" allowfullscreen></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--/////BURAYA KOYACAKSIN-->

                <div class="col-lg-5 col-xl-5">
                    <div class="cs_row_three">
                        <div class="course_content">
                            <div class="cc_headers">
                                <h4 class="title">Kurs İçeriği</h4>
                                <ul class="course_schdule float-right">
                                    <li class="list-inline-item"><a href="javascript:void(0)"><?= count($lessons) ?> Ders</a></li>
                                </ul>
                            </div>
                            <br>
                            <?php foreach ($sections as $index => $section): ?>
                                <?php $sectionLessons = array_filter($lessons, function ($lesson) use ($section) { return $lesson['section_id'] == $section['id']; }) ?>
                            <div class="details">
                                <div id="accordion" class="panel-group cc_tab">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a href="#panelBodyCourseSection<?= $section['id'] ?>" class="accordion-toggle link <?= array_search($currentLesson, $sectionLessons) === false ? 'collapsed' : '' ?>" data-toggle="collapse" data-parent="#accordion"><?= $section['name'] ?></a>
                                            </h4>
                                        </div>
                                        <div id="panelBodyCourseSection<?= $section['id'] ?>" class="panel-collapse collapse <?= array_search($currentLesson, $sectionLessons) !== false ? 'show' : '' ?>">
                                            <div class="panel-body">
                                                <ul class="cs_list mb0">
                                                    <?php foreach ($sectionLessons as $lesson): ?>
                                                        <li>
                                                            <div class="ui_kit_checkbox">
                                                                <div class="custom-control custom-checkbox float-left" style="top: -4px">
                                                                    <input type="checkbox" class="custom-control-input" name="lesson_id[]" value="<?= $lesson['id'] ?>" id="lessonCheck<?= $lesson['id'] ?>" <?= $lesson['watched'] > 0 ? 'checked' : '' ?>>
                                                                    <label class="custom-control-label" for="lessonCheck<?= $lesson['id'] ?>"></label>
                                                                </div>
                                                            </div>
                                                            <a <?= $lesson['id'] == $currentLesson['id'] ? 'class="text-primary"' : '' ?> href="/player/<?= $course['slug'] ?>/lecture/<?= $lesson['vimeo_id'] ?>"><span class="flaticon-play-button-1 icon"></span> <?= $lesson['name'] ?> <span class="cs_preiew">İzle</span></a>
                                                            <div style="clear: both"></div>
                                                        </li>
                                                    <?php endforeach ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach ?>
                        </div>
                        <button class="btn btn-rounded btn-success <?= $watchedLessonCount != count($lessons) ? 'disabled' : '' ?>" id="btn-complete-course">
                            <i class="fa fa-check"></i> Kursu Bitir
                        </button>
                    </div>
                </div>
                <?php if ($course['description']): ?>
                <div class="col-lg-12 col-xl-12">
                    <div class="cs_row_two">
                        <div class="cs_overview">
                            <?= $course['description'] ?>
                        </div>
                    </div>
                </div>
                <?php endif ?>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>