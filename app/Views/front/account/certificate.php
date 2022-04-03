<?= $this->extend('front/account/layout_account') ?>

<?= $this->section('content') ?>
    <div class="col-lg-12">
        <nav class="breadcrumb_widgets" aria-label="breadcrumb mb30">
            <h4 class="title float-left">Sertifikalarım</h4>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
                <li class="breadcrumb-item"><a href="/account">Hesabım</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sertifikalarım</li>
            </ol>
        </nav>
    </div>
    <div class="col-lg-12">
        <div class="my_course_content_container">
            <div class="my_setting_content">
                <div class="my_setting_content_header">
                    <div class="my_sch_title">
                        <h4 class="m0">Sertifikalarım</h4>
                    </div>
                </div>
                <div class="my_setting_content_details">
                    <div class="cart_page_form style2">
                        <form action="#">
                            <table class="table table-responsive">
                                <thead>
                                    <tr class="carttable_row">
                                        <th class="cartm_title">Kurs Adı</th>
                                        <th class="cartm_title">Veriliş Tarihi</th>
                                        <th class="cartm_title">Durum</th>
                                    </tr>
                                </thead>
                                <tbody class="table_body">
                                    <?php if (count($certificates) == 0): ?>
                                        <tr>
                                            <th style="width: 100%" scope="row">
                                                HERHANGİ SERTİFİKANIZ BULUNMAMAKTADIR
                                            </th>
                                        </tr>
                                    <?php endif; ?>

                                    <?php foreach ($certificates as $certificate) : ?>
                                        <tr>
                                            <td><?= $certificate['course_name'] ?></td>
                                            <td><?= $certificate['created_at'] ?></td>
                                            <td>Tamamlandı</td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>