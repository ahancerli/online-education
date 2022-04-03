<?= $this->extend('admin/layout') ?>

<?= $this->section('contentHead') ?>
<h3 class="kt-subheader__title">Kurs Listesi</h3>
<div class="kt-subheader__breadcrumbs">
    <a href="/admin" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>

    <a class="kt-subheader__breadcrumbs-link">Kurs Yönetimi</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>

    <a href="" class="kt-subheader__breadcrumbs-link">Kurs Listesi</a>
</div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script>
    var KTDatatableHtmlTableDemo = function() {
        // Private functions

        // demo initializer
        var demo = function() {

            var datatable = $('.kt-datatable').KTDatatable({
                pagination: true,
                data: {
                    saveState: {cookie: false},
                    pageSize: 20
                },
                search: {
                    input: $('input#generalSearch')
                },
                columns: [
                    {
                        field: 'Fiyat',
                        type: 'number',
                    },
                    {
                        field: 'Yayınlanma Tarihi',
                        type: 'date',
                        format: 'DD-MM-YYYY'
                    },
                    {
                        field: 'Durum',
                        title: 'Durum',
                        autoHide: false,
                        // callback function support for column rendering
                        template: function(row) {
                            var status = {
                                0: {'title': 'Pasif', 'class': 'kt-badge--dark'},
                                1: {'title': 'Aktif', 'class': ' kt-badge--success'},
                            };
                            return '<span class="kt-badge ' + status[row.Durum].class + ' kt-badge--inline kt-badge--pill">' + status[row.Durum].title + '</span>';
                        }
                    },
                    {
                        field: 'Kurs Tipi',
                        title: 'Kurs Tipi',
                        autoHide: false,
                        // callback function support for column rendering
                        template: function(row) {
                            var status = {
                                100: {'title': 'Çevrimdışı Ders', 'state': 'danger'},
                                101: {'title': 'Canlı Ders', 'state': 'success'},
                                102: {'title': 'Yüzyüze Eğitim', 'state': 'info'},
                                103: {'title': 'Döküman', 'state': 'primary'},
                            };
                            return '<span class="kt-badge kt-badge--' + status[row['Kurs Tipi']].state + ' kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-' +status[row['Kurs Tipi']].state + '">' +	status[row['Kurs Tipi']].title + '</span>';
                        }
                    }
                ],
                layout: {
                    spinner: {
                        message: 'Yükleniyor...'
                    }
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
                }
            });

            $('#grid_status_filter').on('change', function() {
                datatable.search($(this).val().toLowerCase(), 'Durum');
            });

            $('#grid_course_type_filter').on('change', function() {
                datatable.search($(this).val().toLowerCase(), 'Kurs Tipi');
            });

            $('#grid_instructor_filter').on('change', function() {
                datatable.search($(this).val().toLowerCase(), 'Eğitmen');
            });

            $('#grid_status_filter,#grid_course_type_filter,#grid_instructor_filter').selectpicker();

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

        $("body").on("click", ".btn-delete-course", function () {
            var id = $(this).data("id");
            var thisEl = $(this);

            $.showDeleteSwal(function () {
                $.get("/admin/course/delete/" + id, function (response) {
                    if (response.success) {
                        thisEl.closest("tr").remove();
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
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    Kurslar
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a href="/admin/course/create" class="btn btn-brand btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i>
                            Yeni Kurs Ekle
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
                            <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
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
                            <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                <div class="kt-form__group kt-form__group--inline">
                                    <div class="kt-form__label">
                                        <label>Tip:</label>
                                    </div>
                                    <div class="kt-form__control">
                                        <select class="form-control bootstrap-select" id="grid_course_type_filter">
                                            <option value="">Hepsi</option>
                                            <?php foreach ($courseTypes as $id => $type): ?>
                                            <option value="<?= $id ?>"><?= $type ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 order-1 order-xl-2">
                        <div class="kt-form__group kt-form__group--inline">
                            <div class="kt-form__label">
                                <label>Eğitmen:</label>
                            </div>
                            <div class="kt-form__control">
                                <select class="form-control bootstrap-select" id="grid_instructor_filter">
                                    <option value="">Hepsi</option>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= $user->name ?>"><?= $user->name ?></option>
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
            <table class="kt-datatable" id="html_table" width="100%">
                <thead>
                <tr>
                    <th>Kurs Adı</th>
                    <th>Eğitmen</th>
                    <th>Fiyat</th>
                    <th>İndirim Oranı</th>
                    <th>Durum</th>
                    <th>Kurs Tipi</th>
                    <th>Eylemler</th>
                    <th>Yayınlanma Tarihi</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($courses as $course): ?>
                    <tr>
                        <td><?= $course['title'] ?></td>
                        <td><?= $course['instructor_name'] ?></td>
                        <td><?= number_format($course['price'], 2) ?> ₺</td>
                        <td><?= $course['discount_ratio'] . '%' ?></td>
                        <td align="right"><?= $course['status'] ?></td>
                        <td align="right"><?= $course['course_type_id'] ?></td>
                        <td align="right">
                            <a href="/admin/course/edit/<?= $course['id'] ?>" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Düzenle">
                                <i class="la la-edit"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-delete-course" title="Sil" data-id="<?= $course['id'] ?>">
                                <i class="la la-trash"></i>
                            </a>
                        </td>
                        <td><?= $course['publish_date'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!--end: Datatable -->
        </div>
    </div>
</div>
<?= $this->endSection() ?>
