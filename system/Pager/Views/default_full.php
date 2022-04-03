<?php
/**
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */

$pager->setSurroundCount(2);
?>

<div class="mbp_pagination">
    <ul class="page_navigation">
        <li class="page-item <?= !$pager->hasPrevious() ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $pager->getPrevious() ?>" tabindex="-1" aria-disabled="true"> <span class="flaticon-left-arrow"></span> Önceki</a>
        </li>

        <?php if ($pager->hasPrevious()) : ?>
            <li class="page-item"><a class="page-link" href="<?= $pager->getFirst() ?>">1</a></li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link <?= $link['active'] ? 'text-white' : '' ?>" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li class="page-item disabled"><a class="page-link" href="javascript:void(0)">...</a></li>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getLast() ?>">Son</a>
            </li>
        <?php endif ?>

        <li class="page-item <?= !$pager->hasNext() ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $pager->getNext() ?>">Sonraki <span class="flaticon-right-arrow-1 float-right"></span></a>
        </li>
    </ul>
</div>