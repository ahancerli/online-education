<?= $this->extend('admin/layout') ?>

<?= $this->section('contentHead') ?>
<h3 class="kt-subheader__title">Profil</h3>
<div class="kt-subheader__breadcrumbs">
    <a href="/admin" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>

    <a class="kt-subheader__breadcrumbs-link">Ayarlar</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>

    <a href="" class="kt-subheader__breadcrumbs-link">Profil</a>
</div>
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

    // phone number format
    $("input[type=tel]").inputmask("mask", {
        "mask": "(999) 999-9999"
    });

    var profileImage = new KTAvatar('profile_image');

    DescriptionCKEditorDocument.init();
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <!--Begin::App-->
        <div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">

            <!--Begin:: App Aside Mobile Toggle-->
            <button class="kt-app__aside-close" id="kt_user_profile_aside_close">
                <i class="la la-close"></i>
            </button>

            <!--End:: App Aside Mobile Toggle-->

            <!--Begin:: App Aside-->
            <div class="kt-grid__item kt-app__toggle kt-app__aside" id="kt_user_profile_aside">

                <!--begin:: Widgets/Applications/User/Profile1-->
                <div class="kt-portlet ">
                    <div class="kt-portlet__head  kt-portlet__head--noborder">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body kt-portlet__body--fit-y">

                        <!--begin::Widget -->
                        <div class="kt-widget kt-widget--user-profile-1">
                            <div class="kt-widget__head">
                                <div class="kt-widget__media">
                                    <?php if(user()->profile_image): ?>
                                    <img src="/assets/uploads/user/<?= user()->profile_image ?>">
                                    <?php else: ?>
                                    <img src="/assets/admin/media/bg/cropped-placeholder.jpg">
                                    <?php endif ?>
                                </div>
                                <div class="kt-widget__content">
                                    <div class="kt-widget__section">
                                        <a href="#" class="kt-widget__username">
                                            <?= user()->name ?>
                                        </a>
                                        <span class="kt-widget__subtitle">
                                            <?= user()->title ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-widget__body">
                                <div class="kt-widget__content">
                                </div>
                                <div class="kt-widget__items">
                                    <a href="" class="kt-widget__item kt-widget__item--active">
                                        <span class="kt-widget__section">
                                            <span class="kt-widget__icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24" />
                                                        <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                        <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                                                    </g>
                                                </svg>
                                            </span>
                                            <span class="kt-widget__desc">
                                                Kişisel Bilgiler
                                            </span>
                                        </span>
                                    </a>
                                    <a href="/admin/profile/change_password" class="kt-widget__item ">
                                        <span class="kt-widget__section">
                                            <span class="kt-widget__icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3" />
                                                        <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3" />
                                                        <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                            </span>
                                            <span class="kt-widget__desc">
                                                Şifre Değiştir
                                            </span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!--end::Widget -->
                    </div>
                </div>

                <!--end:: Widgets/Applications/User/Profile1-->
            </div>

            <!--End:: App Aside-->

            <!--Begin:: App Content-->
            <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="kt-portlet">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title">Kişisel Bilgiler</h3>
                                </div>
                            </div>
                            <form class="kt-form kt-form--label-right" action="" method="post" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                <div class="kt-portlet__body">
                                    <div class="kt-section kt-section--first">
                                        <div class="kt-section__body">
                                            <?= view('Myth\Auth\Views\_message_block') ?>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Profil Fotoğrafı</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="kt-avatar kt-avatar--outline" id="profile_image">
                                                        <?php if(user()->profile_image): ?>
                                                        <div class="kt-avatar__holder" style="background-image: url(/assets/uploads/user/<?= user()->profile_image ?>)"></div>
                                                        <?php else: ?>
                                                        <div class="kt-avatar__holder" style="background-image: url(/assets/admin/media/bg/cropped-placeholder.jpg)"></div>
                                                        <?php endif ?>
                                                        <label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Görseli değiştir">
                                                            <i class="fa fa-pen"></i>
                                                            <input type="file" name="profile_image" accept=".png, .jpg, .jpeg">
                                                        </label>
                                                        <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="Görseli kaldır">
                                                            <i class="fa fa-times"></i>
                                                        </span>
                                                    </div>
                                                    <span class="form-text text-muted">İzin verilen dosya formatları: png, jpg, jpeg.</span>
                                                    <span class="form-text text-muted">Maks. dosya boyutu: 1 MB</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Ad Soyad</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <input class="form-control" name="name" type="text" value="<?= old('name') ?? user()->name ?>" placeholder="Tam Adınız" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Ünvan</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <input class="form-control" name="title" type="text" value="<?= old('title') ?? user()->title ?>" placeholder="Ünvanınız">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-xl-3"></label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <h3 class="kt-section__title kt-section__title-sm">İletişim Bilgileri:</h3>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Telefon</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"><i class="la la-phone"></i></span></div>
                                                        <input type="tel" name="phone" class="form-control" value="<?= old('phone') ?? user()->phone ?>" placeholder="Telefon">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Web Site</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <input type="url" name="website" class="form-control" placeholder="Web Site" value="<?= old('website') ?? user()->website ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-xl-3"></label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <h3 class="kt-section__title kt-section__title-sm">Diğer:</h3>
                                                </div>
                                            </div>
                                            <div class="form-group form-group-last row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Eğitmen Açıklaması</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <textarea name="description" id="description-editor"><?= user()->description ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="kt-portlet__foot">
                                    <div class="kt-form__actions">
                                        <div class="row">
                                            <div class="col-lg-3 col-xl-3">
                                            </div>
                                            <div class="col-lg-9 col-xl-9">
                                                <button type="submit" class="btn btn-success">Profili Güncelle</button>&nbsp;
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!--End:: App Content-->
        </div>

        <!--End::App-->
    </div>
<?= $this->endSection() ?>