<?= $this->extend('admin/layout') ?>

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
                            url: '/admin/order/list',
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
                        field: 'order_code',
                        title: 'Sipariş Kodu'
                    },
                    {
                        field: 'customer_name',
                        title: 'Müşteri Adı'
                    },
                    {
                        field: 'amount',
                        title: 'Tutar',
                        template: function(data) { return data.amount + ' TL'; }
                    },
                    {
                        field: 'created_at',
                        title: 'Sipariş Tarihi',
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
                            <a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-view-order" title="Siparişi Görüntüle" data-id="${data.id}">
                                <i class="la la-eye"></i>
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

        $("body").on("click", ".btn-view-order", function () {
            var id = $(this).data("id");

            $.get("/admin/order/detail/" + id, function (response) {
                var table = $("#viewOrderModal .modal-body > table:first");
                table.find("tbody").html("");
                $(".order-note-field p").text("");
                $(".order-note-field").hide();

                $.each(response.data, function (index, course) {
                    var price = 0;

                    if (course.discount_ratio > 0) price = course.price - (course.price * course.discount_ratio / 100);
                    else price = course.price;

                    table.find("tbody").append("<tr><td>"+ course.title +"</td><td>"+ parseFloat(price).toFixed(2) +" TL</td></tr>")
                });

                if (response.order_note) {
                    $(".order-note-field p").text(response.order_note);
                    $(".order-note-field").show();
                }

                $("#viewOrderModal").modal("show");
            }, "JSON");
        });

        $(".btn-filter").click(function () {
            var orderCode = $("input[name=order_code]").val().trim();

            datatable.search(orderCode, "order_code");
        });

        <?php if ($queryString): ?>
        var queryString = "<?= $queryString ?>";
        var params = queryString.split("=");

        if (params[0] === "customer_id")
            datatable.search(params[1], "customer_id");
        <?php endif ?>
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('contentHead') ?>
<h3 class="kt-subheader__title">Siparişler</h3>
<div class="kt-subheader__breadcrumbs">
    <a href="/admin" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="/admin/order" class="kt-subheader__breadcrumbs-link">Siparişler</a>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    Sipariş Listesi
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
                                        <input type="text" name="order_code" class="form-control" placeholder="Sipariş Kodu">
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

<!-- View Order Modal -->
<div class="modal fade" id="viewOrderModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sipariş Detay</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <td>Kurs Adı</td>
                            <td>Tutar</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <div class="order-note-field" style="display: none">
                    <strong>Sipariş Notu:</strong>
                    <p></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
