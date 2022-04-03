<?= $this->extend('admin/layout') ?>

<?= $this->section('contentHead') ?>
<h3 class="kt-subheader__title"><?= $mode == 'edit' ? 'Kullanıcı Düzenle' : 'Kullanıcı Ekle' ?></h3>
<div class="kt-subheader__breadcrumbs">
    <a href="/admin" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>

    <a class="kt-subheader__breadcrumbs-link">Ayarlar</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>

    <a href="/admin/user" class="kt-subheader__breadcrumbs-link">Kullanıcı Yönetimi</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>

    <a href="" class="kt-subheader__breadcrumbs-link"><?= $mode == 'edit' ? 'Kullanıcı Düzenle' : 'Kullanıcı Ekle' ?></a>
</div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script>
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
                            <?= $mode == 'edit' ? 'Kullanıcı Düzenle' : 'Yeni Kullanıcı Ekle' ?>
                        </h3>
                    </div>
                </div>

                <!--begin::Form-->
                <form class="form" action="<?= $mode == 'edit' ? '/admin/user/update' : '' ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <?php if ($mode == 'edit'): ?>
                    <input type="hidden" name="user_id" value="<?= $user->id ?>">
                    <?php endif ?>
                    <div class="card-body">
                        <?= view('Myth\Auth\Views\_message_block') ?>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label>Ad Soyad <small class="text-danger">(*)</small></label>
                                <input type="text" name="name" class="form-control" value="<?= $mode == 'edit' ? $user->name : old('name') ?>" required>
                            </div>
                            <div class="col-lg-4">
                                <label>E-posta <small class="text-danger">(*)</small></label>
                                <input type="email" name="email" class="form-control" value="<?= $mode == 'edit' ? $user->email : old('email') ?>" required>
                            </div>
                            <div class="col-lg-4">
                                <label>Kullanıcı Adı <small class="text-danger">(*)</small></label>
                                <input type="text" name="username" class="form-control" value="<?= $mode == 'edit' ? $user->username : old('username') ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label>Şifre <?php if ($mode != 'edit'): ?><small class="text-danger">(*)</small><?php endif ?></label>
                                <input type="password" name="password" class="form-control" value="" <?= $mode != 'edit' ? 'required' : '' ?>>
                            </div>
                            <div class="col-lg-4">
                                <label>Şifre Tekrar <?php if ($mode != 'edit'): ?><small class="text-danger">(*)</small><?php endif ?></label>
                                <input type="password" name="password_confirm" class="form-control" value="" <?= $mode != 'edit' ? 'required' : '' ?>>
                            </div>
                            <div class="col-lg-4">
                                <label>Durum</label>
                                <div class="clearfix"></div>
                                <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                    <label>
                                        <?php if ($mode == 'edit'): ?>
                                        <input type="checkbox" name="active" value="1" <?= $user->active ? 'checked' : '' ?>>
                                        <?php else: ?>
                                        <input type="checkbox" name="active" value="1" checked>
                                        <?php endif ?>
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary">Kaydet</button>
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
