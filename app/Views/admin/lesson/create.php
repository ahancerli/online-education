<?= $this->extend('admin/layout') ?>

<?= $this->section('contentHead') ?>
    <h3 class="kt-subheader__title"><?= $mode == 'edit' ? 'Ders Düzenle' : 'Ders Ekle' ?></h3>
    <div class="kt-subheader__breadcrumbs">
        <a href="/admin" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
        <span class="kt-subheader__breadcrumbs-separator"></span>

        <a class="kt-subheader__breadcrumbs-link">Dersler</a>
        <span class="kt-subheader__breadcrumbs-separator"></span>

        <a href="" class="kt-subheader__breadcrumbs-link"><?= $mode == 'edit' ? 'Ders Düzenle' : 'Ders Ekle' ?></a>
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

        var courses = <?= json_encode($courses); ?>;

        var sectionId = null;

        <?php if ($mode == 'edit'): ?>
        sectionId = <?= $lesson['section_id'] ?? 'null' ?>;
        <?php endif ?>

        $('#section_select').select2({
            placeholder: "Bölüm seçin...",
        });

        $("select[name=course_id]").change(function () {
            var val = $(this).val();

            $("#section_select > option").remove();

            if (!val) return;

            var course = courses.find(function(x) { return x.id === val });

            $("input[name=vimeo_id]").closest(".col-lg-6").show();
            $("input[name=vimeo_id]").attr("required", true);
            $("input[name=document]").removeAttr("required");
            $("input[name=document]").closest(".col-lg-6").find("label > small").hide();

            if (course.course_type_id === "101" || course.course_type_id === "102") {
                $("option:first", $(this)).prop("selected", true);
                Swal.fire("Hata!", "Çevrimdışı kurslar veya döküman kursları haricinde diğer kurs tiplerine ders ekleyemezsiniz", "error");
                return;
            } else if (course.course_type_id === "103") {
                $("input[name=vimeo_id]").closest(".col-lg-6").hide();
                $("input[name=vimeo_id]").removeAttr("required");
                $("input[name=document]").attr("required", true);
                $("input[name=document]").closest(".col-lg-6").find("label > small").show();
            }

            $("input[name=course_type_id]").val(course.course_type_id);

            $.get("/admin/section/list_by_course/" + val, function (response) {
                $.each(response.data, function (index, item) {
                    var newOption = null;

                    if (sectionId == item.id)
                        newOption = new Option(item.name, item.id, true, true);
                    else
                        newOption = new Option(item.name, item.id);

                    $('#section_select').append(newOption);
                });
            }, "json");
        })

        $("select[name=course_id]").trigger("change");

        $(".btn-delete-lesson").click(function () {
            var id = $(this).data("id");

            $.showDeleteSwal(function () {
                $.get("/admin/lesson/delete/" + id, function (response) {
                    if (response.success) {
                        $.showSuccessNotification(response.message);

                        setTimeout(function () {
                            window.location.href = "/admin/lesson";
                        }, 1000);
                    }
                }, "JSON");
            });
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="col-lg-12">

            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            <?= $mode == 'edit' ? 'Ders Düzenle' : 'Yeni Ders Ekle' ?>
                        </h3>
                    </div>
                </div>

                <!--begin::Form-->
                <form class="form" action="<?= $mode == 'edit' ? '/admin/lesson/update' : '/admin/lesson/create' ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <?php if($mode == 'edit'): ?>
                        <input type="hidden" name="lesson_id" value="<?= $lesson['id'] ?>">
                    <?php endif ?>
                    <input type="hidden" name="course_type_id">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Ders Adı <small class="text-danger">(*)</small></label>
                                <input type="text" name="name" class="form-control" value="<?= $mode == 'edit' ? $lesson['name'] : old('name') ?>" required>
                            </div>
                            <div class="col-lg-6">
                                <label>Durum</label>
                                <div class="clearfix"></div>
                                <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                    <label>
                                        <?php if ($mode == 'edit'): ?>
                                            <input type="checkbox" name="status" value="1" <?= $lesson['status'] ? 'checked' : '' ?>>
                                        <?php else: ?>
                                            <input type="checkbox" name="status" value="1" checked>
                                        <?php endif ?>
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Kurs <small class="text-danger">(*)</small></label>
                                <select name="course_id" class="form-control selectpicker" data-live-search="true" required>
                                    <option value="">Kurs seçin...</option>
                                    <?php foreach ($courses as $course): ?>
                                        <?php if($mode == 'edit'): ?>
                                        <option value="<?= $course['id'] ?>" <?= $lesson['course_id'] == $course['id'] ? 'selected' : '' ?>><?= $course['title'] ?></option>
                                        <?php else: ?>
                                        <option value="<?= $course['id'] ?>" <?= $course['id'] == old('course_id') ? 'selected' : '' ?>><?= $course['title'] ?></option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label style="width: 100%">Bölüm </label>
                                <select class="form-control select2" style="width: 100%" id="section_select" name="section_id">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Vimeo ID <small class="text-danger">(*)</small></label>
                                <input name="vimeo_id" type="text" class="form-control" value="<?= $mode == 'edit' ? $lesson['vimeo_id'] : old('vimeo_id') ?>">
                            </div>
                            <div class="col-lg-6">
                                <label>Döküman <small class="text-danger" style="display: none">(*)</small></label>
                                <div class="custom-file">
                                    <input type="file" name="document" class="custom-file-input" id="customFile"/>
                                    <label class="custom-file-label" for="customFile">Dosya seçin</label>
                                </div>
                                <?php if($mode == 'edit'): ?>
                                    <?php if ($lesson['document_name']): ?>
                                        <div class="alert alert-custom alert-outline-primary fade show mt-3" role="alert">
                                            <div class="alert-icon"><i class="fa fa-file"></i></div>
                                            <div class="alert-text">
                                                <a href="<?= base_url('assets/uploads/document') . '/' . $lesson['document_name'] ?>" target="_blank">
                                                    <?= $lesson['document_name'] ?>
                                                </a>
                                            </div>
                                            <!--<div class="alert-close">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                                                </button>
                                            </div>-->
                                        </div>
                                    <?php endif ?>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary"><?= $mode == 'edit' ? 'Güncelle' : 'Kaydet' ?></button>
                                </div>
                                <?php if ($mode == 'edit'): ?>
                                    <div class="col-lg-6 kt-align-right">
                                        <button type="button" class="btn btn-danger btn-delete-lesson" data-id="<?= $lesson['id'] ?>">Sil</button>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
