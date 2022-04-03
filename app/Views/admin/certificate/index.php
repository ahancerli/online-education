<?= $this->extend('admin/layout') ?>

<?= $this->section('pageScripts') ?>
<script>
    var datatable = null;
    var certificates = [];
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
                            url: '/admin/certificate/list',
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
                        field: 'customer_name',
                        title: 'Müşteri Adı'
                    },
                    {
                        field: 'customer_email',
                        title: 'Müşteri E-posta'
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
                    }
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

        $('#grid_course_filter').selectpicker();

        $("#grid_course_filter").change(function () {
            datatable.search($(this).val(), "course_id");
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('contentHead') ?>
<h3 class="kt-subheader__title">Sertifika Yönetimi</h3>
<div class="kt-subheader__breadcrumbs">
    <a href="/admin" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="/admin/certificate" class="kt-subheader__breadcrumbs-link">Sertifika Yönetimi</a>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    Sertifika İstekleri
                </h3>
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
