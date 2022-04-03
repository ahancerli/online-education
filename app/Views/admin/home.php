<?= $this->extend('admin/layout') ?>

<?= $this->section('contentHead') ?>
<h3 class="kt-subheader__title">Anasayfa</h3>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script src="<?= base_url('assets/admin') ?>/js/pages/dashboard.js" type="text/javascript"></script>
<script>
    var orderCountChart = function(data) {
        if ($('#kt_chart_orders').length == 0) {
            return;
        }

        var ctx = document.getElementById("kt_chart_orders").getContext("2d");

        var gradient = ctx.createLinearGradient(0, 0, 0, 240);
        gradient.addColorStop(0, Chart.helpers.color('#e14c86').alpha(1).rgbString());
        gradient.addColorStop(1, Chart.helpers.color('#e14c86').alpha(0.3).rgbString());

        var config = {
            type: 'line',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    label: "Sipariş Sayısı",
                    backgroundColor: Chart.helpers.color('#e14c86').alpha(1).rgbString(),  //gradient
                    borderColor: '#e13a58',

                    pointBackgroundColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointHoverBackgroundColor: KTApp.getStateColor('light'),
                    pointHoverBorderColor: Chart.helpers.color('#ffffff').alpha(0.1).rgbString(),

                    fill: 'start',
                    data: Object.values(data)
                }]
            },
            options: {
                title: {
                    display: false,
                },
                tooltips: {
                    mode: 'nearest',
                    intersect: false,
                    position: 'nearest',
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        },
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.0000001
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 10,
                        bottom: 80
                    }
                }
            }
        };

        var chart = new Chart(ctx, config);
    };

    var totalIncomeChart = function(data) {
        if ($('#kt_chart_income').length == 0) {
            return;
        }

        var ctx = document.getElementById("kt_chart_income").getContext("2d");

        var gradient = ctx.createLinearGradient(0, 0, 0, 240);
        gradient.addColorStop(0, Chart.helpers.color('#d1f1ec').alpha(1).rgbString());
        gradient.addColorStop(1, Chart.helpers.color('#d1f1ec').alpha(0.3).rgbString());

        var config = {
            type: 'line',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    label: "Toplam Gelir",
                    backgroundColor: gradient,
                    borderColor: KTApp.getStateColor('success'),

                    pointBackgroundColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointHoverBackgroundColor: KTApp.getStateColor('danger'),
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.1).rgbString(),

                    //fill: 'start',
                    data: Object.values(data)
                }]
            },
            options: {
                title: {
                    display: false,
                },
                tooltips: {
                    mode: 'nearest',
                    intersect: false,
                    position: 'nearest',
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        },
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.0000001
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 10,
                        bottom: 0
                    }
                }
            }
        };

        var chart = new Chart(ctx, config);
    }

    var soldCourseCount = function(data) {
        if ($('#kt_chart_sold_course').length == 0) {
            return;
        }

        var ctx = document.getElementById("kt_chart_sold_course").getContext("2d");

        var gradient = ctx.createLinearGradient(0, 0, 0, 240);
        gradient.addColorStop(0, Chart.helpers.color('#ffefce').alpha(1).rgbString());
        gradient.addColorStop(1, Chart.helpers.color('#ffefce').alpha(0.3).rgbString());

        var config = {
            type: 'line',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    label: "Satılan Kurs",
                    backgroundColor: gradient,
                    borderColor: KTApp.getStateColor('warning'),
                    pointBackgroundColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointHoverBackgroundColor: KTApp.getStateColor('danger'),
                    pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.1).rgbString(),

                    //fill: 'start',
                    data: Object.values(data)
                }]
            },
            options: {
                title: {
                    display: false,
                },
                tooltips: {
                    mode: 'nearest',
                    intersect: false,
                    position: 'nearest',
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        },
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.0000001
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 10,
                        bottom: 0
                    }
                }
            }
        };

        var chart = new Chart(ctx, config);
    }

    var bestSellingCourses = function(data) {
        if (!KTUtil.getByID('kt_chart_best_selling_course')) {
            return;
        }

        var randomScalingFactor = function() {
            return Math.round(Math.random() * 100);
        };

        var config = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: data.values,
                    backgroundColor: [
                        KTApp.getStateColor('success'),
                        KTApp.getStateColor('danger'),
                        KTApp.getStateColor('brand')
                    ]
                }],
                labels: data.labels
            },
            options: {
                cutoutPercentage: 75,
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false,
                    position: 'top',
                },
                title: {
                    display: false,
                    text: 'Kurs'
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                },
                tooltips: {
                    enabled: true,
                    intersect: false,
                    mode: 'nearest',
                    bodySpacing: 5,
                    yPadding: 10,
                    xPadding: 10,
                    caretPadding: 0,
                    displayColors: false,
                    backgroundColor: KTApp.getStateColor('brand'),
                    titleFontColor: '#ffffff',
                    cornerRadius: 4,
                    footerSpacing: 0,
                    titleSpacing: 0
                }
            }
        };

        var ctx = KTUtil.getByID('kt_chart_best_selling_course').getContext('2d');
        var myDoughnut = new Chart(ctx, config);
    };

    $(function () {
        var options = {
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

        $.get("/admin/order_count_statistics", function (response) {
            orderCountChart(response);
        }, "JSON");

        $.get("/admin/total_income_by_month", function (response) {
            totalIncomeChart(response);
        }, "JSON");

        $.get("/admin/sold_course_statistics", function (response) {
            soldCourseCount(response);
        }, "JSON");

        $.get("/admin/best_selling_courses", function (response) {
            if (response.values.length === 0)
                return;

            var total = response.values.reduce(function (a, b) { return parseInt(a) + parseInt(b) });
            $(".kt-widget14__stat").text(total);

            $.each(response.labels, function (index, label) {
                var bgClass = index === 0 ? "kt-bg-success" : index === 1 ? "kt-bg-warning" : "kt-bg-brand";
                var percentage = Math.round(response.values[index] / response.values.length * 100);

                $(".kt-widget14__legends").append(`
                            <div class="kt-widget14__legend">
                                <span class="kt-widget14__bullet ${bgClass}"></span>
                                <span class="kt-widget14__stats">${percentage}% ${label}</span>
                            </div>`);
            });

            bestSellingCourses(response);
        }, "JSON");
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

    <!--Begin::Dashboard 1-->

    <!--Begin::Row-->
    <div class="row">
        <div class="col-lg-6 col-xl-4 order-lg-1 order-xl-1">

            <!--begin:: Widgets/Activity-->
            <div class="kt-portlet kt-portlet--fit kt-portlet--head-lg kt-portlet--head-overlay kt-portlet--skin-solid kt-portlet--height-fluid">
                <div class="kt-portlet__head kt-portlet__head--noborder kt-portlet__space-x">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Aylık Sipariş Sayısı
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div class="kt-widget17">
                        <div class="kt-widget17__visual kt-widget17__visual--chart kt-portlet-fit--top kt-portlet-fit--sides" style="background-color: #fd397a">
                            <div class="kt-widget17__chart" style="height:320px;">
                                <canvas id="kt_chart_orders"></canvas>
                            </div>
                        </div>
                        <div class="kt-widget17__stats">
                            <div class="kt-widget17__items">
                                <div class="kt-widget17__item">
                                    <span class="kt-widget17__icon">
                                        <i class="fa fa-wallet text-success"></i>
                                    </span>
                                    <span class="kt-widget17__subtitle">Gelir</span>
                                    <span class="kt-widget17__desc"><?= number_format($orderReport['total_income'], 2) ?> TL</span>
                                </div>
                                <div class="kt-widget17__item">
                                    <span class="kt-widget17__icon">
                                        <i class="fa fa-cart-arrow-down text-success"></i>
                                    </span>
                                    <span class="kt-widget17__subtitle">Sipariş</span>
                                    <span class="kt-widget17__desc"><?= $orderReport['order_count'] ?> Sipariş</span>
                                </div>
                            </div>
                            <div class="kt-widget17__items">
                                <div class="kt-widget17__item">
                                    <span class="kt-widget17__icon">
                                        <i class="fa fa-graduation-cap text-warning"></i>
                                    </span>
                                    <span class="kt-widget17__subtitle">Kurs</span>
                                    <span class="kt-widget17__desc"><?= $weeklyCourseCount ?> Kurs</span>
                                </div>
                                <div class="kt-widget17__item">
                                    <span class="kt-widget17__icon">
                                        <i class="fa fa-users text-danger"></i>
                                    </span>
                                    <span class="kt-widget17__subtitle">Kullanıcı</span>
                                    <span class="kt-widget17__desc"><?= $weeklyCourseCount ?> Yeni Kullanıcı</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--end:: Widgets/Activity-->
        </div>
        <div class="col-lg-6 col-xl-4 order-lg-1 order-xl-1">

            <!--begin:: Widgets/Inbound Bandwidth-->
            <div class="kt-portlet kt-portlet--fit kt-portlet--head-noborder kt-portlet--height-fluid-half">
                <div class="kt-portlet__head kt-portlet__space-x">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Aylık Toplam Gelir
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body kt-portlet__body--fluid">
                    <div class="kt-widget20">
                        <div class="kt-widget20__content kt-portlet__space-x">
                            <span class="kt-widget20__number kt-font-brand">&nbsp;</span>
                            <span class="kt-widget20__desc">&nbsp;</span>
                        </div>
                        <div class="kt-widget20__chart" style="height:130px;">
                            <canvas id="kt_chart_income"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!--end:: Widgets/Inbound Bandwidth-->
            <div class="kt-space-20"></div>

            <!--begin:: Widgets/Outbound Bandwidth-->
            <div class="kt-portlet kt-portlet--fit kt-portlet--head-noborder kt-portlet--height-fluid-half">
                <div class="kt-portlet__head kt-portlet__space-x">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Aylık Satılan Kurs
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body kt-portlet__body--fluid">
                    <div class="kt-widget20">
                        <div class="kt-widget20__content kt-portlet__space-x">
                            <span class="kt-widget20__number kt-font-danger">&nbsp;</span>
                            <span class="kt-widget20__desc">&nbsp;</span>
                        </div>
                        <div class="kt-widget20__chart" style="height:130px;">
                            <canvas id="kt_chart_sold_course"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!--end:: Widgets/Outbound Bandwidth-->
        </div>
        <div class="col-lg-6 col-xl-4 order-lg-1 order-xl-1">
            <!--begin:: Widgets/Profit Share-->
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-widget14">
                    <div class="kt-widget14__header">
                        <h3 class="kt-widget14__title">
                            En Çok Satılan Kurslar
                        </h3>
                        <span class="kt-widget14__desc">
                            En çok satılan 3 kurs
                        </span>
                    </div>
                    <div class="kt-widget14__content" style="justify-content: center">
                        <div class="kt-widget14__chart">
                            <div class="kt-widget14__stat"></div>
                            <canvas id="kt_chart_best_selling_course" style="height: 200px; width: 200px;"></canvas>
                        </div>
                    </div>
                    <div class="kt-widget14__legends" style="margin-top: 30px">
                    </div>
                </div>
            </div>

            <!--end:: Widgets/Profit Share-->
        </div>
        <div class="col-sm-12 order-xl-1">
            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobile ">
                <div class="kt-portlet__head kt-portlet__head--lg kt-portlet__head--noborder kt-portlet__head--break-sm">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Son Siparişler
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body kt-portlet__body--fit">

                    <!--begin: Datatable -->
                    <div class="kt-datatable"></div>

                    <!--end: Datatable -->
                </div>
            </div>
        </div>
    </div>

    <!--End::Row-->

    <!--End::Dashboard 1-->

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
</div>
<?= $this->endSection() ?>
