<?= $this->extend('admin/layout') ?>

<?= $this->section('pageVendorStyles') ?>
<link href="<?= base_url('assets/admin') ?>/plugins/custom/jstree/jstree.bundle.css?v=7.0.8" rel="stylesheet" type="text/css" />
<?= $this->endSection() ?>

<?= $this->section('pageVendorScripts') ?>
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<script src="<?= base_url('assets/admin') ?>/plugins/custom/jstree/jstree.bundle.js?v=7.0.8"></script>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script>
    var avatar1 = new KTAvatar('course_image');

    $(function () {
        CKEDITOR.config.allowedContent = true;

        <?php if (session()->has('message')) : ?>
        $.showSuccessNotification("<?= session('message') ?>");
        <?php endif ?>

        <?php if (session()->has('error')) : ?>
        $.showErrorNotification("<?= session('error') ?>");
        <?php endif ?>

        var categoryTree = $('#category_tree').jstree({
            "plugins": ["wholerow", "checkbox", "types"],
            "core": {
                "animation": 0,
                "check_callback": true,
                'force_text': true,
                "themes": {"stripes": true, "responsive": true},
                'data': {
                    'url': "/admin/category/get_tree",
                    'dataType': 'json'
                }
            },
            "types": {
                "default": {
                    "icon": "flaticon2-folder"
                },
                "file": {
                    "icon": "flaticon2-file"
                }
            },
            "plugins": ["search", "types", "wholerow"],
            "search": {
                "show_only_matches": true
            }
        });

        // Search
        var to = false;
        $('#tree_search').keyup(function () {
            if (to) {
                clearTimeout(to);
            }
            to = setTimeout(function () {
                var v = $('#tree_search').val();
                $('#category_tree').jstree(true).search(v);
            }, 250);
        });

        // multi select
        $('#category_select2').select2({
            placeholder: "Kategori seç...",
        });

        $('#category_select2').on('select2:opening', function (e) {
            e.preventDefault();
            $("#categoryTreeModal").modal("show");
        });

        $("#btn_select_categories").click(function () {
            var selectedItems = categoryTree.jstree(true).get_selected(true);
            $("#category_select2 > option").remove();

            selectedItems.forEach(function (item, index) {
                if (item.id !== 'j1_1') {
                    var newOption = new Option(item.text, item.id, true, true);
                    $('#category_select2').append(newOption).trigger('change');
                }
            });

            $("#categoryTreeModal").modal("hide");
        });

        $("select[name=course_type_id]").change(function () {
            var val = $(this).val();

            $(".document-file-row").hide();
            $(".vimeo-id-row").hide();

            $(".document-file-row input[type=file]").removeAttr("required");
            $(".vimeo-id-row input[name=vimeo_id]").removeAttr("required");

            if (val === "102") {
                $(".document-file-row").show();
                $(".document-file-row input[type=file]").attr("required", true);
            } else if (val === "101") {
                $(".vimeo-id-row").show();
                $(".vimeo-id-row input[name=vimeo_id]").attr("required", true);
            }
        });

        $("body").on("click", ".btn-delete-course", function () {
            var id = $(this).data("id");
            var thisEl = $(this);

            $.showDeleteSwal(function () {
                $.get("/admin/course/delete/" + id, function (response) {
                    if (response.success) {
                        $.notify({
                            // options
                            icon: 'flaticon2-checkmark',
                            message: response.message
                        },{
                            // settings
                            type: 'success'
                        });
                        setTimeout(function () {
                            window.location.href = "/admin/course";
                        }, 1000);
                    }
                }, "JSON");
            });
        });

        <?php if($mode == 'edit'): ?>
        $("select[name=course_type_id]").trigger("change");
        <?php endif ?>
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('contentHead') ?>
<h3 class="kt-subheader__title"><?= $mode == 'edit' ? 'Kurs Düzenle' : 'Yeni Kurs Oluştur' ?></h3>
<div class="kt-subheader__breadcrumbs">
    <a href="/admin" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>

    <a href="/admin/course" class="kt-subheader__breadcrumbs-link">Kurs Yönetimi</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>

    <a href="" class="kt-subheader__breadcrumbs-link"><?= $mode == 'edit' ? 'Kurs Düzenle' : 'Yeni Kurs Oluştur' ?></a>
</div>
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
                            <?= $mode == 'edit' ? 'Kurs Düzenle' : 'Yeni Kurs Oluştur' ?>
                        </h3>
                    </div>
                    <!--<div class="kt-portlet__head-toolbar">
                        <ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-right nav-tabs-line-brand" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_portlet_genel" role="tab">
                                    Genel
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_portlet_program" role="tab">
                                    Ders Programı
                                </a>
                            </li>
                        </ul>
                    </div>-->
                </div>

                <!--begin::Form-->
                <form class="form" action="<?= $mode == 'edit' ? '/admin/course/update' : '/admin/course/create' ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <?php if($mode == 'edit'): ?>
                        <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                    <?php endif ?>

                    <div class="kt-portlet__body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="kt_portlet_genel">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Kurs Adı <small class="text-danger">(*)</small></label>
                                        <input type="text" name="title" class="form-control" value="<?= $mode == 'edit' ? $course['title'] : '' ?>" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Durum</label>
                                        <div class="clearfix"></div>
                                        <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                    <label>
                                        <?php if ($mode == 'edit'): ?>
                                            <input type="checkbox" name="status" value="1" <?= $course['status'] ? 'checked' : '' ?>>
                                        <?php elseif ($mode == 'add'): ?>
                                            <input type="checkbox" name="status" value="1" checked>
                                        <?php endif ?>
                                        <span></span>
                                    </label>
                                </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label style="width: 100%">Kategori <small class="text-danger">(*)</small></label>
                                        <select class="form-control select2" style="width: 100%" id="category_select2" name="category_id[]" multiple="multiple" required>
                                            <?php if($mode == 'edit'): ?>
                                                <?php foreach ($categories as $category): ?>
                                                    <option value="<?= $category['category_id'] ?>" selected><?= $category['category_name'] ?></option>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Kurs Tipi <small class="text-danger">(*)</small></label>
                                        <select name="course_type_id" class="form-control selectpicker" required>
                                            <?php foreach ($courseTypes as $id => $name): ?>
                                                <?php
                                                $badgeClass = '';
                                                if ($id == 100) $badgeClass = 'danger';
                                                else if ($id == 101) $badgeClass = 'success';
                                                else if ($id == 102) $badgeClass = 'info';
                                                else if ($id == 103) $badgeClass = 'primary';
                                                ?>
                                                <option value="<?= $id ?>" data-content="<span class='kt-badge kt-badge--<?= $badgeClass ?> kt-badge--inline kt-badge--<?= $badgeClass ?>'><?= $name ?></span>" <?= isset($course['course_type_id']) && $course['course_type_id'] == $id ? 'selected' : '' ?>><?= $name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row document-file-row" style="display: none">
                                    <div class="col-lg-6">
                                        <label>Ders Programı <small class="text-danger">(*)</small></label>
                                        <div class="custom-file">
                                            <input type="file" name="document" class="custom-file-input" id="customFile"/>
                                            <label class="custom-file-label" for="customFile">Dosya seçin</label>
                                        </div>
                                        <?php if($mode == 'edit'): ?>
                                            <?php if ($course['document_name']): ?>
                                                <div class="alert alert-custom alert-outline-primary fade show mt-3" role="alert">
                                                    <div class="alert-icon"><i class="fa fa-file"></i></div>
                                                    <div class="alert-text">
                                                        <a href="<?= base_url('assets/uploads/document') . '/' . $course['document_name'] ?>" target="_blank">
                                                            <?= $course['document_name'] ?>
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
                                <div class="form-group row vimeo-id-row" style="display: none">
                                    <div class="col-lg-6">
                                        <label>Vimeo ID <small class="text-danger">(*)</small></label>
                                        <input name="vimeo_id" type="text" class="form-control" value="<?= isset($course['vimeo_id']) ? $course['vimeo_id'] : old('vimeo_id') ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Fiyat <small class="text-danger">(*)</small></label>
                                        <div class="input-group">
                                            <input type="number" name="price" class="form-control" placeholder="Kurs Fiyatı" value="<?= isset($course['price']) ? number_format($course['price'], 2) : '0' ?>" min="0" step=".01" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">TL</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>İndirim Oranı</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="number" name="discount_ratio" class="form-control" placeholder="İndirim Oranı" value="<?= $course['discount_ratio'] ?? 0 ?>" min="0" step=".01">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Yayınlanma Tarihi <small class="text-danger">(*)</small></label>
                                        <input name="publish_date" class="form-control" type="datetime-local"
                                               value="<?= isset($course['publish_date']) ? date('Y-m-d', strtotime($course['publish_date'])) . 'T' . date('H:i', strtotime($course['publish_date'])) : '' ?>"
                                               required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Kurs Görseli</label>
                                        <div>
                                            <div class="kt-avatar kt-avatar--outline" id="course_image">
                                                <?php if ($mode === 'edit'): ?>
                                                    <?php if (!is_null($course['image_name'])): ?>
                                                        <div class="kt-avatar__holder" style="background-image: url(<?= base_url('assets/uploads/course/' . $course['image_name']) ?>)"></div>
                                                    <?php else: ?>
                                                        <div class="kt-avatar__holder" style="background-image: url(/assets/admin/media/bg/cropped-placeholder.jpg)"></div>
                                                    <?php endif ?>
                                                <?php else: ?>
                                                    <div class="kt-avatar__holder" style="background-image: url(/assets/admin/media/bg/cropped-placeholder.jpg)"></div>
                                                <?php endif ?>
                                                <label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Görseli değiştir">
                                                    <i class="fa fa-pen"></i>
                                                    <input type="file" name="course_image" accept=".png, .jpg, .jpeg">
                                                </label>
                                                <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="Görseli kaldır">
                                            <i class="fa fa-times"></i>
                                        </span>
                                            </div>
                                            <span class="form-text text-muted">İzin verilen dosya formatları: png, jpg, jpeg.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>Kurs Açıklaması</label>
                                        <div id="description-editor-toolbar"></div>
                                        <textarea class="ckeditor" name="description" id="editor1"><?= $course['description'] ?? '' ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane active" id="kt_portlet_program">
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
                                    <button type="button" class="btn btn-danger btn-delete-course" data-id="<?= $course['id'] ?>">Sil</button>
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

<!-- Kategori Modal-->
<div class="modal fade" id="categoryTreeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kategori Seç</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" style="min-height: 300px;">
                <div class="row" style="margin-bottom: 20px">
                    <div class="col-sm-12">
                        <input type="text" id="tree_search" class="form-control form-control-sm" placeholder="Kategori Ara..."/>
                    </div>
                    <div class="col-sm-12">
                        <small class="form-text">Birden fazla kategori seçmek için CTRL veya SHIFT tuşuna basarak seçim yapabilirsiniz.</small>
                    </div>
                </div>
                <div id="category_tree" class="tree-demo">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary font-weight-bold" id="btn_select_categories">Kategorileri Seç</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
