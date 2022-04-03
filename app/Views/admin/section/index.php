<?= $this->extend('admin/layout') ?>

<?= $this->section('contentHead') ?>
<h3 class="kt-subheader__title">Bölüm Yönetimi</h3>
<div class="kt-subheader__breadcrumbs">
    <a href="/admin" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>

    <a class="kt-subheader__breadcrumbs-link">Bölüm Yönetimi</a>
</div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script>
    var datatable = null;
    var options = {};
    var sectionsJSON = <?= json_encode($sections) ?>

    var KTDatatableHtmlTableDemo = function() {
        // Private functions

        // demo initializer
        var demo = function() {
            options = {
                pagination: true,
                sortable: true,
                data: {
                    type: 'local',
                    source: sectionsJSON,
                    saveState: {cookie: false},
                    pageSize: 20
                },
                search: {
                    input: $('input#generalSearch')
                },
                layout: {
                    spinner: {
                        message: 'Yükleniyor...'
                    }
                },
                rows: {
                    autoHide: false
                },
                translate: {
                    records: {
                        noRecords: 'Kayıt bulunamadı',
                        processing: 'Lütfen bekleyin...'
                    },
                    toolbar: {
                        pagination: {
                            items: {
                                info: '{{total}} kayıttan {{start}} - {{end}} arası gösteriliyor'
                            }
                        }
                    }
                },
                columns: [
                    {
                        field: 'id',
                        title: '#',
                        sortable: false,
                        width: 20,
                        type: 'number',
                        selector: {class: 'kt-checkbox--solid'},
                        textAlign: 'center'
                    },
                    {
                        field: 'name',
                        title: 'Bölüm Adı'
                    },
                    {
                        field: 'course_name',
                        title: 'Kurs Adı'
                    },
                    {
                        field: 'created_at',
                        title: 'Oluşturulma Tarihi',
                        type: 'date',
                        format: 'DD/MM/YYYY'
                    },
                    {
                        field: 'updated_at',
                        title: 'Güncellenme Tarihi',
                        type: 'date',
                        format: 'DD/MM/YYYY'
                    },
                    {
                        field: 'Eylemler',
                        title: 'Eylemler',
                        sortable: false,
                        width: 110,
                        overflow: 'visible',
                        autoHide: false,
                        template: function (data) {
                            return `
                            <a href=javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit-section" title="Düzenle" data-id="${data.id}">
                                <i class="la la-edit"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-delete-section" title="Sil" data-id="${data.id}">
                                <i class="la la-trash"></i>
                            </a>`;
                        }
                    },
                ]
            };

            datatable = $('.kt-datatable').KTDatatable(options);
        };

        return {
            // Public functions
            init: function() {
                // init dmeo
                demo();
            },
        };
    }();

    jQuery(document).ready(function() {
        KTDatatableHtmlTableDemo.init();

        $("body").on("click", ".btn-delete-section", function () {
            var id = $(this).data("id");

            $.showDeleteSwal(function () {
                $.get("/admin/section/delete/" + id, function (response) {
                    if (response.success) {
                        var section = sectionsJSON.find(function (item) {
                            return item.id == id;
                        });
                        var index = sectionsJSON.indexOf(section);
                        sectionsJSON.splice(index, 1);
                        options.data.source = sectionsJSON;
                        datatable.destroy();
                        datatable = $(".kt-datatable").KTDatatable(options);

                        $.notify({
                            // options
                            icon: 'flaticon2-checkmark',
                            message: response.message
                        },{
                            // settings
                            type: 'success'
                        });
                    }
                }, "JSON");
            });
        });

        $("body").on("click", ".btn-edit-section" ,function () {
            var id = $(this).data("id");
            var section = sectionsJSON.find(function(item) { return item.id == id });
            $("#update-section-form input[type=text]").val(section.name);
            $("#update-section-form input[name=section_id]").val(section.id);
            $('#update-section-form select[name=course_id]').selectpicker('val', section.course_id);
            $("#editSectionModal").modal("show");
        });

        $(".btn-create-course").click(function () {
            var form = $("#create-section-form");
            var btn = $(this);

            form.validate({
                rules: {
                    name: {
                        required: true
                    },
                    course_id: {
                        required: true
                      }
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);

            form.ajaxSubmit({
                url: '/admin/section/create',
                success: function(response, status, xhr, $form) {
                    form.clearForm(); // clear form
                    form.validate().resetForm(); // reset validation states
                    $('select[name=course_id]', form).selectpicker('val', '');
                    $.showSuccessNotification(response.message);

                    sectionsJSON.push(response.section);
                    options.data.source = sectionsJSON;
                    datatable.destroy();
                    datatable = $('.kt-datatable').KTDatatable(options);

                    $('.modal').modal('hide');
                },
                error: function (error) {
                    $.showErrorNotification(error.responseJSON.message);
                },
                complete: function () {
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false); // remove
                }
            });
        });

        $(".btn-update-course").click(function () {
            var form = $("#update-section-form");
            var sectionId = $("input[name=section_id]", form).val();
            var btn = $(this);

            form.validate({
                rules: {
                    name: {
                        required: true
                    },
                    course_id: {
                        required: true
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);

            form.ajaxSubmit({
                url: '/admin/section/update',
                success: function(response, status, xhr, $form) {
                    $.showSuccessNotification(response.message);

                    var section = sectionsJSON.find(function(item) { return item.id == sectionId });
                    var index = sectionsJSON.indexOf(section);

                    sectionsJSON[index] = response.section;
                    options.data.source = sectionsJSON;
                    datatable.destroy();
                    datatable = $('.kt-datatable').KTDatatable(options);

                    $('.modal').modal('hide');
                },
                error: function (error) {
                    $.showErrorNotification(error.responseJSON.message);
                },
                complete: function () {
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false); // remove
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    Bölümler
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a href="javascript:void(0)" class="btn btn-brand btn-elevate btn-icon-sm" data-toggle="modal" data-target="#createSectionModal">
                            <i class="la la-plus"></i>
                            Yeni Bölüm Ekle
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">

            <!--begin: Search Form -->
            <div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
                <div class="row align-items-center">
                    <div class="col-xl-8 order-2 order-xl-1">
                        <div class="row align-items-center">
                            <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                <div class="kt-input-icon kt-input-icon--left">
                                    <input type="text" class="form-control" placeholder="Ara..." id="generalSearch">
                                    <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                        <span><i class="la la-search"></i></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--end: Search Form -->
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">

            <!--begin: Datatable -->
            <div class="kt-datatable" id="kt_datatable"></div>
            <!--end: Datatable -->
        </div>
    </div>
</div>

<!-- Create Section Modal -->
<div class="modal fade" id="createSectionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Bölüm Ekle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" method="post" id="create-section-form">
                    <?= csrf_field() ?>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Bölüm Adı <small class="text-danger">(*)</small></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Kurs <small class="text-danger">(*)</small></label>
                            <select name="course_id" class="form-control selectpicker" required>
                                <option value="" selected disabled>Kurs seçin</option>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?= $course['id'] ?>"><?= $course['title'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Vazgeç</button>
                <button type="button" class="btn btn-success font-weight-bold btn-create-course">Kaydet</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Section Modal -->
<div class="modal fade" id="editSectionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bölüm Düzenle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" method="post" id="update-section-form">
                    <?= csrf_field() ?>
                    <input type="hidden" name="section_id">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Bölüm Adı <small class="text-danger">(*)</small></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Kurs <small class="text-danger">(*)</small></label>
                            <select name="course_id" class="form-control selectpicker" required>
                                <option value="" selected disabled>Kurs seçin</option>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?= $course['id'] ?>"><?= $course['title'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Vazgeç</button>
                <button type="button" class="btn btn-success font-weight-bold btn-update-course">Kaydet</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
