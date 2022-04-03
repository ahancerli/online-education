<?= $this->extend('admin/layout') ?>

<?= $this->section('contentHead') ?>
<h3 class="kt-subheader__title">Kategori Düzenle</h3>
<div class="kt-subheader__breadcrumbs">
    <a href="/admin" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>

    <a href="/admin/category" class="kt-subheader__breadcrumbs-link">Kategoriler</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>

    <a href="" class="kt-subheader__breadcrumbs-link">Kategori Düzenle</a>
</div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script>
    var categoryImage = new KTAvatar('category_image');

    $(function () {
        <?php if (session()->has('message')) : ?>
        $.showSuccessNotification("<?= session('message') ?>");
        <?php endif ?>

        <?php if (session()->has('error')) : ?>
        $.showErrorNotification("<?= session('error') ?>");
        <?php endif ?>
    });
</script>
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
                            Kategori Düzenle
                        </h3>
                    </div>
                </div>

                <!--begin::Form-->
                <form class="form" action="/admin/category/update" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="category_id" value="<?= $category['id'] ?>">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Kategori Adı <small class="text-danger">(*)</small></label>
                                <input type="text" name="name" class="form-control" value="<?= $category['name'] ?>" required>
                            </div>
                            <div class="col-lg-6">
                                <label>Durum</label>
                                <div class="clearfix"></div>
                                <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                    <label>
                                        <input type="checkbox" name="status" value="1" <?= $category['status'] ? 'checked' : '' ?>>
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Kategori Sırası</label>
                                <input type="number" name="sort_order" class="form-control" value="<?= $category['sort_order'] ?>">
                            </div>
                            <div class="col-lg-6">
                                <label>Kategori Görseli</label>
                                <div>
                                    <div class="kt-avatar kt-avatar--outline" id="category_image">
                                        <?php if($category['image_name']): ?>
                                        <div class="kt-avatar__holder" style="background-image: url(/assets/uploads/category/<?= $category['image_name'] ?>)"></div>
                                        <?php else: ?>
                                        <div class="kt-avatar__holder" style="background-image: url(/assets/admin/media/bg/cropped-placeholder.jpg)"></div>
                                        <?php endif ?>
                                        <label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Görseli değiştir">
                                            <i class="fa fa-pen"></i>
                                            <input type="file" name="category_image" accept=".png, .jpg, .jpeg">
                                        </label>
                                        <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="Görseli kaldır">
                                            <i class="fa fa-times"></i>
                                        </span>
                                    </div>
                                    <span class="form-text text-muted">İzin verilen dosya formatları: png, jpg, jpeg.</span>
                                    <span class="form-text text-muted">Maks. dosya boyutu: 1 MB</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary">Güncelle</button>
                                </div>
                                <div class="col-lg-6 kt-align-right">
                                    <button type="button" class="btn btn-danger btn-delete-category" data-id="<?= $category['id'] ?>">Sil</button>
                                </div>
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
