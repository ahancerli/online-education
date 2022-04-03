<?= $this->extend('front/layout') ?>

<?= $this->section('pageScripts') ?>
<script>
    $(function () {
        var page = "<?= $page ?? '1' ?>";
        var searchQuery = "<?= $searchQuery ?? '' ?>";
        var sort = "created_at|DESC";

        function filterCourses() {
            var serializedData = $("#filter-form").serialize();
            var queryString = "page=" + page;

            if (serializedData)
                queryString += "&" + serializedData;

            if (sort)
                queryString += "&sort=" + sort;

            if (searchQuery)
                queryString += "&search_query=" + searchQuery;

            window.location.search = queryString;
        }

        $("[name^=category_id]").change(function () {
            filterCourses();
        });

        $("[name^=instructor_id]").change(function () {
            filterCourses();
        });

        $("[name^=point]").change(function () {
            filterCourses();
        });

        $("#btn-search").click(function () {
            searchQuery = $(this).prev("input[type=search]").val().trim();
            filterCourses();
        });

        $("#select-sorting").change(function () {
            sort = $(this).val();
            filterCourses();
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
                    <h4 class="breadcrumb_title">Eğitim Kataloğu</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Eğitim Kataloğu</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Courses List 2 -->
<section class="courses-list2 pb40">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8 col-xl-9">
                <div class="row courses_list_heading style2">
                    <div class="col-xl-4 p0">
                        <div class="instructor_search_result style2">
                            <p class="mt10 fz15">
                                <span class="color-dark"><?= $total ?></span> kurstan <span class="color-dark"><?= count($courses) ?></span> kurs gösteriliyor
                            </p>
                        </div>
                    </div>
                    <div class="col-xl-8 p0">
                        <div class="candidate_revew_select style2 text-right">
                            <ul class="mb0">
                                <li class="list-inline-item">
                                    <select class="selectpicker show-tick" id="select-sorting">
                                        <option value="created_at|DESC" <?= $sort == 'created_at|DESC' ? 'selected' : '' ?>>Tarihe göre (Önce en yeni)</option>
                                        <option value="created_at|ASC" <?= $sort == 'created_at|ASC' ? 'selected' : '' ?>>Tarihe göre (Önce en eski)</option>
                                        <option value="price|DESC" <?= $sort == 'price|DESC' ? 'selected' : '' ?>>Fiyata göre (Önce en yüksek)</option>
                                        <option value="price|ASC" <?= $sort == 'price|ASC' ? 'selected' : '' ?>>Fiyata göre (Önce en düşük)</option>
                                    </select>
                                </li>
                                <li class="list-inline-item">
                                    <div class="candidate_revew_search_box course fn-520">
                                        <form class="form-inline my-2 my-lg-0">
                                            <input class="form-control mr-sm-2" type="search" placeholder="Kurs ara..." value="<?= $searchQuery ?? '' ?>">
                                            <button class="btn my-2 my-sm-0" id="btn-search" type="button"><span class="flaticon-magnifying-glass"></span></button>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <?php if (count($courses) == 0) : ?>
                    <p class="text-center" style="margin-top: 20px">Eşleşen kurs bulunamadı</p>
                <?php endif ?>

                <div class="row courses_container style2">
                    <?php foreach ($courses as $course): ?>
                        <div class="col-lg-12 p0">
                            <div class="courses_list_content">
                                <div class="top_courses list">
                                    <div class="thumb">
                                        <?php if ($course['image_name']): ?>
                                            <img class="img-whp" src="<?= base_url('assets')  ?>/uploads/course/<?= $course['image_name'] ?>">
                                        <?php else: ?>
                                            <img class="img-whp" src="<?= base_url('assets')  ?>/images/courses/t1.jpg">
                                        <?php endif ?>
                                        <div class="overlay">
                                            <a class="tc_preview_course" href="/course/<?= $course['slug'] ?>">Kursa Git</a>
                                        </div>
                                    </div>
                                    <div class="details">
                                        <div class="tc_content">
                                            <p><?= $course['instructor_name'] ?></p>
                                            <h5 onclick="window.location.href = '/course/<?= $course['slug'] ?>'"><?= $course['title'] ?></h5>
                                            <!--                                        <p>--><?//= htmlentities(strip_tags($course['description'])) ?><!--</p>-->
                                        </div>
                                        <div class="tc_footer">
                                            <ul class="tc_meta float-left fn-414">
                                                <li class="list-inline-item"><a href="#"><i class="flaticon-profile"></i></a></li>
                                                <li class="list-inline-item"><a href="#"><?= $course['user_count'] ?></a></li>
                                                <li class="list-inline-item"><a href="#"><i class="flaticon-comment"></i></a></li>
                                                <li class="list-inline-item"><a href="#"><?= $course['comment_count'] ?></a></li>
                                            </ul>
                                            <div class="tc_price float-right fn-414 <?= $course['avg_point'] <= 0 ? 'ml20' : '' ?>">
                                                <?php if ($course['discount_ratio'] > 0): ?>
                                                    <?= number_format($course['price'] - ($course['price'] * $course['discount_ratio'] / 100), 2) ?> ₺
                                                <?php else: ?>
                                                    <?= number_format($course['price'], 2) ?> ₺
                                                <?php endif ?>
                                            </div>
                                            <?php if ($course['avg_point'] > 0): ?>
                                            <ul class="tc_review float-right fn-414">
                                                <?php for ($i = 1; $i <= $course['avg_point']; $i++): ?>
                                                <li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>
                                                <?php endfor ?>
                                                <li class="list-inline-item"><a href="#">(<?= number_format(round($course['avg_point']), 1) ?>)</a></li>
                                            </ul>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (count($courses) > 0): ?>
                    <div class="row">
                        <div class="col-lg-12 mt50">
                            <?= $pager->makeLinks($page, $perPage, $total, 'default_full', 0, 'default') ?>
                        </div>
                    </div>
                <?php endif ?>
            </div>
            <div class="col-lg-4 col-xl-3">
                <form id="filter-form" action="" method="get">
                    <?php if (count($categories) > 0): ?>
                    <div class="selected_filter_widget style3 mb30">
                        <div id="accordion" class="panel-group">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a href="#panelBodySoftware" class="accordion-toggle link fz20 mb15" data-toggle="collapse" data-parent="#accordion">Kategori</a>
                                    </h4>
                                </div>
                                <div id="panelBodySoftware" class="panel-collapse collapse show">
                                    <div class="panel-body">
                                        <div class="ui_kit_checkbox">
                                            <?php foreach ($categories as $index => $category): ?>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="category_id[]" value="<?= $category['id'] ?>" id="categoryCheck<?= $index ?>" <?= in_array($category['id'], $categoryId) ? 'checked' : '' ?>>
                                                    <label class="custom-control-label" for="categoryCheck<?= $index ?>"><?= $category['name'] ?> <span class="float-right">(<?= $category['course_count'] ?>)</span></label>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif ?>
                    <?php if (count($instructors) > 0): ?>
                    <div class="selected_filter_widget style3">
                        <div id="accordion" class="panel-group">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a href="#panelBodyAuthors" class="accordion-toggle link fz20 mb15" data-toggle="collapse" data-parent="#accordion">Eğitmen</a>
                                    </h4>
                                </div>
                                <div id="panelBodyAuthors" class="panel-collapse collapse show">
                                    <div class="panel-body">
                                        <div class="cl_skill_checkbox">
                                            <div class="content ui_kit_checkbox style2 text-left">
                                                <?php foreach ($instructors as $index => $instructor): ?>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="instructor_id[]" value="<?= $instructor->id ?>" class="custom-control-input" id="instructorCheck<?= $index ?>" <?= in_array($instructor->id, $instructorId) ? 'checked' : '' ?>>
                                                        <label class="custom-control-label" for="instructorCheck<?= $index ?>"><?= $instructor->name ?> <span class="float-right">(<?= $instructor->course_count ?>)</span></label>
                                                    </div>
                                                <?php endforeach ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif ?>
                    <div class="selected_filter_widget style3">
                        <div id="accordion" class="panel-group">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a href="#panelBodyRating" class="accordion-toggle link fz20 mb15" data-toggle="collapse" data-parent="#accordion">Puan</a>
                                    </h4>
                                </div>
                                <div id="panelBodyRating" class="panel-collapse collapse show">
                                    <div class="panel-body">
                                        <div class="ui_kit_checkbox style2">
                                            <div class="custom-control custom-checkbox">
                                                <input name="point[]" type="checkbox" class="custom-control-input" id="customCheck82" value="1" <?= in_array(1, $point) ? 'checked' : '' ?>>
                                                <label class="custom-control-label" for="customCheck82">1+</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input name="point[]" type="checkbox" class="custom-control-input" id="customCheck83" value="2" <?= in_array(2, $point) ? 'checked' : '' ?>>
                                                <label class="custom-control-label" for="customCheck83">2+</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input name="point[]" type="checkbox" class="custom-control-input" id="customCheck84" value="3" <?= in_array(3, $point) ? 'checked' : '' ?>>
                                                <label class="custom-control-label" for="customCheck84">3+</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input name="point[]" type="checkbox" class="custom-control-input" id="customCheck85" value="4" <?= in_array(4, $point) ? 'checked' : '' ?>>
                                                <label class="custom-control-label" for="customCheck85">4+</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input name="point[]" type="checkbox" class="custom-control-input" id="customCheck86" value="5" <?= in_array(5, $point) ? 'checked' : '' ?>>
                                                <label class="custom-control-label" for="customCheck86">5+</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
