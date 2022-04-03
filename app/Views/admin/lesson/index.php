<?= $this->extend('admin/layout') ?>

<?= $this->section('contentHead') ?>
<h3 class="kt-subheader__title">Ders Listesi</h3>
<div class="kt-subheader__breadcrumbs">
    <a href="/admin" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>

    <a class="kt-subheader__breadcrumbs-link">Dersler</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>

    <a href="" class="kt-subheader__breadcrumbs-link">Ders Listesi</a>
</div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script>
    var datatable = null;
    var comments = [];
    var options = {};

    var KTDatatableHtmlTableDemo = function() {
        // Private functions

        // demo initializer
        var demo = function() {
            options = {
                data: {
                    type: 'remote',
                    source: {
                        read: {
                            url: '/admin/lesson/list',
                            // sample custom headers
                            // headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
                            map: function(raw) {
                                // sample data mapping
                                var dataSet = raw;
                                if (typeof raw.data !== 'undefined') {
                                    dataSet = raw.data;
                                }
                                comments = dataSet;
                                return dataSet;
                            },
                        },
                    },
                    pageSize: 10,
                    serverPaging: true,
                    serverFiltering: true,
                    serverSorting: true,
                },
                /*search: {
                    input: $('input#generalSearch')
                },*/
                layout: {
                    spinner: {
                        message: 'Yükleniyor...'
                    }
                },
                pagination: true,
                sortable: true,
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
                        title: 'Ders Adı'
                    },
                    {
                        field: 'course_name',
                        title: 'Kurs Adı'
                    },
                    {
                        field: 'section_name',
                        title: 'Bölüm Adı'
                    },
                    {
                        field: 'created_at',
                        title: 'Oluşturulma Tarihi',
                        type: 'date',
                        format: 'DD/MM/YYYY'
                    },
                    {
                        field: 'status',
                        title: 'Durum',
                        template: function (row) {
                            var status = {
                                0: {'title': 'Pasif', 'class': 'kt-badge--dark'},
                                1: {'title': 'Aktif', 'class': ' kt-badge--success'},
                            };
                            return '<span class="kt-badge ' + status[row.status].class + ' kt-badge--inline kt-badge--pill">' + status[row.status].title + '</span>';
                        }
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
                            <a href="/admin/lesson/edit/${data.id}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Düzenle">
                                <i class="la la-edit"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-delete-lesson" style="cursor: pointer" title="Sil" data-id="${data.id}">
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

    $(function () {
        KTDatatableHtmlTableDemo.init();

        var arrows;
        if (KTUtil.isRTL()) {
            arrows = {
                leftArrow: '<i class="la la-angle-right"></i>',
                rightArrow: '<i class="la la-angle-left"></i>'
            }
        } else {
            arrows = {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
        }

        // range picker
        $('#kt_datepicker_5').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            templates: arrows,
            language: 'tr'
        }).on("changeDate", function (e) {
            var startDate = $("[name=start_date]").val();
            var endDate = $("[name=end_date]").val();

            if (startDate && endDate) {
                datatable.search({
                    start_date: startDate,
                    end_date: endDate
                }, "date_period");
            }
        });

        $("body").on("click", ".btn-delete-lesson", function () {
            var id = $(this).data("id");

            $.showDeleteSwal(function () {
                $.get("/admin/lesson/delete/" + id, function (response) {
                    if (response.success) {
                        datatable.reload();
                        $.showSuccessNotification(response.message);
                    } else {
                        $.showErrorNotification(response.message);
                    }
                }, "json");
            });
        });

        $('#grid_status_filter').on('change', function() {
            datatable.search($(this).val(), 'status');
        });

        $('#grid_course_filter').on('change', function() {
            datatable.search($(this).val(), 'course_id');
        });

        $('#grid_status_filter, #grid_course_filter').selectpicker();
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    Dersler
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a href="/admin/lesson/create" class="btn btn-brand btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i>
                            Yeni Ders Ekle
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
                            <div class="col-md-7 kt-margin-b-20-tablet-and-mobile">
                                <div class="input-daterange input-group" id="kt_datepicker_5">
                                    <input type="text" class="form-control" name="start_date" placeholder="Başlangıç Tarihi" autocomplete="off" />
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="end_date" placeholder="Bitiş Tarihi" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-5 kt-margin-b-20-tablet-and-mobile">
                                <div class="kt-form__group kt-form__group--inline">
                                    <div class="kt-form__label">
                                        <label>Durum:</label>
                                    </div>
                                    <div class="kt-form__control">
                                        <select class="form-control bootstrap-select" id="grid_status_filter">
                                            <option value="">Hepsi</option>
                                            <option value="1">Aktif</option>
                                            <option value="0">Pasif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 order-1 order-xl-2">
                        <div class="kt-form__group kt-form__group--inline">
                            <div class="kt-form__label">
                                <label>Kurs:</label>
                            </div>
                            <div class="kt-form__control">
                                <select class="form-control bootstrap-select" id="grid_course_filter" data-live-search="true">
                                    <option value="">Hepsi</option>
                                    <?php foreach ($courses as $course): ?>
                                        <option value="<?= $course['id'] ?>"><?= $course['title'] ?></option>
                                    <?php endforeach ?>
                                </select>
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
<?= $this->endSection() ?>
