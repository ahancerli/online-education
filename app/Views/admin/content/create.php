<?= $this->extend('admin/layout') ?>

<?= $this->section('pageVendorStyles') ?>
<?= $this->endSection() ?>

<?= $this->section('pageVendorScripts') ?>
    <script src="<?= base_url('assets') ?>/admin/plugins/custom/ckeditor/ckeditor-classic.bundle.js?v=7.0.8"></script>

<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script>


    var DescriptionCKEditorDocument = function () {
        // Private functions
        var demos = function () {
            ClassicEditor
                .create( document.querySelector( '#description-editor' ) )
                .then( editor => {
                } )
                .catch( error => {
                    console.error( error );
                } );
        }

        return {
            // public functions
            init: function() {
                demos();
            }
        };
    }();

    $(function () {
        <?php if (session()->has('message')) : ?>
        $.showSuccessNotification("<?= session('message') ?>");
        <?php endif ?>

        <?php if (session()->has('error')) : ?>
        $.showErrorNotification("<?= session('error') ?>");
        <?php endif ?>


        $("body").on("click", ".btn-delete-content", function () {
            var id = $(this).data("id");
            var thisEl = $(this);

            $.showDeleteSwal(function () {
                $.get("/admin/content/delete/" + id, function (response) {
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
                            window.location.href = "/admin/content";
                        }, 1000);
                    }
                }, "JSON");
            });
        });


        DescriptionCKEditorDocument.init();

    });
</script>


<?= $this->endSection() ?>
<?= $this->section('contentHead') ?>
<h3 class="kt-subheader__title"><?= $mode == 'edit' ? 'İçerik Düzenle' : 'İçerik Ekle' ?></h3>
<div class="kt-subheader__breadcrumbs">
    <a href="/admin" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>

    <a href="/admin/content" class="kt-subheader__breadcrumbs-link">İçerik Yönetimi</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>

    <a href="" class="kt-subheader__breadcrumbs-link"><?= $mode == 'edit' ? 'İçerik Düzenle' : 'İçerik Ekle' ?></a>
</div>
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
                            <?= $mode == 'edit' ? 'İçerik Düzenle' : 'İçerik Ekle' ?>
                        </h3>
                    </div>
                </div>

                <!--begin::Form-->
                <form class="form" action="<?= $mode == 'edit' ? '/admin/content/update' : '/admin/content/create' ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <?php if($mode == 'edit'): ?>
                        <input type="hidden" name="content_id" value="<?= $content['id'] ?>">
                    <?php endif ?>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>İçerik  Adı <small class="text-danger">(*)</small></label>
                                <input type="text" name="name" class="form-control" value="<?= $mode == 'edit' ? $content['name'] : '' ?>" required>
                            </div>
                            <div class="col-lg-6">
                                <label>Durum</label>
                                <div class="clearfix"></div>
                                <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                    <label>
                                        <?php if ($mode == 'edit'): ?>
                                            <input type="checkbox" name="status" value="1" <?= $content['status'] ? 'checked' : '' ?>>
                                        <?php elseif ($mode == 'add'): ?>
                                            <input type="checkbox" name="status" value="1" checked>
                                        <?php endif ?>
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label>Permalink <small class="text-danger">(*)</small></label>
                                <input type="text" name="slug" class="form-control" value="<?= $mode == 'edit' ? $content['slug'] : '' ?>" required>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label>İçerik Detay</label>
                                <div id="description-editor-toolbar"></div>
                                <textarea class="editor" name="content" id="description-editor"><?= $content['content'] ?? '' ?></textarea>
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
                                        <button type="button" class="btn btn-danger btn-delete-content" data-id="<?= $content['id'] ?>">Sil</button>
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
