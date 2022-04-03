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
                            url: '/admin/content/list',
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
                search: {
                    input: $('input#generalSearch')
                },
                layout: {
                    spinner: {
                        message: 'Yükleniyor...'
                    }
                },
                //pagination: true,
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
                        title: 'İçerik Adı'
                    },
                    {
                        field: 'created_at',
                        title: 'Oluşturulma Tarihi',
                        type: 'date',
                        format: 'DD/MM/YYYY'
                    },
                    {
                        field: 'updated_at',
                        title: 'Son Güncelleme',
                        type: 'date',
                        format: 'DD/MM/YYYY'
                    },
                    {
                        field: 'status',
                        title: 'Durum',
                        template: function (row) {
                            return `
                                <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success kt-switch--sm">
                                    <label>
                                        <input type="checkbox" class="content-status-cb" value="${row.id}" ${row.status == 1 ? 'checked' : ''}>
                                        <span></span>
                                    </label>
                                </span>`;
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
                            <a href="/admin/content/edit/${data.id}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Düzenle">
                                <i class="la la-edit"></i>
                            </a>

                            <a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-delete-content" title="Sil" data-id="${data.id}">
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

        $("body").on("click", ".content-status-cb", function () {
            var status = null;
            var contentId = $(this).val();

            if ($(this).is(":checked")) status = 1
            else status = 0;

            $.post("/admin/content/change_status", {id: contentId, status: status}, function (response) {
                if (!response.success)
                    $.showErrorNotification(response.message);

                $.showSuccessNotification(response.message);
            }, "json");
        });

        $("body").on("click", ".btn-delete-content", function () {
            var id = $(this).data("id");

            $.showDeleteSwal(function () {
                $.get("/admin/content/delete/" + id, function (response) {
                    if (response.success) {
                        datatable.reload();
                        $.showSuccessNotification(response.message);
                    } else {
                        $.showErrorNotification(response.message);
                    }
                }, "json");
            });
        });
    });


</script>

<?= $this->endSection() ?>

<?= $this->section('contentHead') ?>
<h3 class="kt-subheader__title">İçerik Listesi</h3>
<div class="kt-subheader__breadcrumbs">
    <a href="/admin" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a class="kt-subheader__breadcrumbs-link">İçerik Yönetimi</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="/admin/content" class="kt-subheader__breadcrumbs-link">İçerik Listesi</a>
</div>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    İçerikler
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a href="/admin/content/create" class="btn btn-brand btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i>
                            Yeni İçerik Ekle
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">

            <!--begin: Datatable -->
            <div class="kt-datatable" id="kt_datatable"></div>
            <!--end: Datatable -->
        </div>
    </div>
</div>


<?= $this->endSection() ?>
