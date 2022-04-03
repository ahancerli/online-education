<?= $this->extend('admin/layout') ?>

<?= $this->section('contentHead') ?>
<h3 class="kt-subheader__title">Müşteriler</h3>
<div class="kt-subheader__breadcrumbs">
    <a href="/admin" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="/admin/customer" class="kt-subheader__breadcrumbs-link">Müşteriler</a>
</div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script>
    var datatable = null;
    var customers = [];
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
                            url: '/admin/customer/list',
                            // sample custom headers
                            // headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
                            map: function(raw) {
                                // sample data mapping
                                var dataSet = raw;
                                if (typeof raw.data !== 'undefined') {
                                    dataSet = raw.data;
                                }
                                customers = dataSet;
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
                        title: 'Müşteri Adı'
                    },
                    {
                        field: 'email',
                        title: 'E-posta'
                    },
                    {
                        field: 'order_count',
                        title: 'Sipariş Sayısı',
                        template: function (data) {
                            return '<a href="/admin/order?customer_id='+ data.id +'" target="_blank">'+ data.order_count +' Sipariş</a>'
                        }
                    },
                    {
                        field: 'created_at',
                        title: 'Kayıt Tarihi',
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

        $(".btn-filter").click(function () {
            var searchValue = $("input[name=search_value]").val();
            datatable.search(searchValue.trim(), "search_value");
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
                    Müşteriler
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">

            <!--begin: Search Form -->
            <div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
                <div class="row align-items-center">
                    <div class="col-xl-10 order-2 order-xl-1">
                        <div class="row align-items-center">
                            <div class="col-md-6 kt-margin-b-20-tablet-and-mobile">
                                <div class="input-daterange input-group" id="kt_datepicker_5">
                                    <input type="text" class="form-control" name="start_date" placeholder="Başlangıç Tarihi" autocomplete="off" />
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="end_date" placeholder="Bitiş Tarihi" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                <div class="kt-form__group kt-form__group--inline" style="display: block">
                                    <div class="kt-form__control" style="display: block">
                                        <input type="text" name="search_value" class="form-control" placeholder="Müşteri Adı/E-posta">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-info btn-sm btn-filter">
                                    <i class="fa fa-filter"></i> Filtrele
                                </button>
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
