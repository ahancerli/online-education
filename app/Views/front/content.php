<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>

<!-- Inner Page Breadcrumb -->
<section class="inner_page_breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3 text-center">
                <div class="breadcrumb_content">
                    <h4 class="breadcrumb_title"><?= $content['name'] ?></h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Anasafa</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $content['name'] ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Team Members -->
<section class="our-team pb40">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="become_instructor_container">
                    <h4 class="titles"><?= $content['name'] ?></h4>
                    <p><?= $content['content'] ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
