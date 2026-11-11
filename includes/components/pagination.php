<?php
declare(strict_types=1);
/** @var int $page */
/** @var int $pages */
/** @var string $path */
/** @var array<string, mixed> $query */
if ($pages < 2) {
    return;
}
?>
<nav class="pager" aria-label="Pagination">
    <?php if ($page > 1): ?><a class="btn btn--ghost" href="<?= e(query_url($path, $query, ['page' => $page - 1])) ?>">Previous</a><?php endif; ?>
    <?php for ($i = 1; $i <= $pages; $i++): ?>
        <a class="btn <?= $i === $page ? 'btn--primary' : 'btn--ghost' ?>" href="<?= e(query_url($path, $query, ['page' => $i])) ?>"<?= $i === $page ? ' aria-current="page"' : '' ?>><?= e((string) $i) ?></a>
    <?php endfor; ?>
    <?php if ($page < $pages): ?><a class="btn btn--ghost" href="<?= e(query_url($path, $query, ['page' => $page + 1])) ?>">Next</a><?php endif; ?>
</nav>
