<?php
/**
 * Paginador reutilizable basado en parámetros GET.
 * Variables esperadas:
 *   $paginaActual    int  página actual (1-based)
 *   $totalPaginas    int  cantidad total de páginas
 *   $baseParams      array parámetros GET actuales (sin 'page') a preservar en los links
 */
$paginaActual = (int) ($paginaActual ?? 1);
$totalPaginas = (int) ($totalPaginas ?? 1);
$qsBase       = $baseParams ?? [];

if ($totalPaginas <= 1) {
    return;
}

$mkUrl = function (int $p) use ($qsBase) {
    $qs         = $qsBase;
    $qs['page'] = $p;
    return '?' . http_build_query($qs);
};

$inicio = max(1, $paginaActual - 2);
$fin    = min($totalPaginas, $paginaActual + 2);

$linkBase   = 'inline-flex items-center justify-center min-w-[2.25rem] h-9 px-2 rounded-lg text-[0.85rem] font-semibold no-underline border-[1.5px] transition-colors duration-150';
$linkNorm   = $linkBase . ' border-[#e5e7eb] text-[#374151] bg-white hover:border-rojo hover:text-rojo';
$linkActivo = $linkBase . ' border-rojo bg-rojo text-white';
?>
<nav class="flex items-center justify-center gap-[6px] mt-8 flex-wrap" aria-label="Paginación de resultados">
    <?php if ($paginaActual > 1): ?>
        <a href="<?= esc($mkUrl($paginaActual - 1)) ?>" class="<?= $linkNorm ?>" aria-label="Página anterior">
            <i class="fas fa-chevron-left text-[0.75rem]"></i>
        </a>
    <?php endif; ?>

    <?php if ($inicio > 1): ?>
        <a href="<?= esc($mkUrl(1)) ?>" class="<?= $linkNorm ?>">1</a>
        <?php if ($inicio > 2): ?><span class="px-1 text-gray-400">&hellip;</span><?php endif; ?>
    <?php endif; ?>

    <?php for ($p = $inicio; $p <= $fin; $p++): ?>
        <a href="<?= esc($mkUrl($p)) ?>" class="<?= $p === $paginaActual ? $linkActivo : $linkNorm ?>" <?= $p === $paginaActual ? 'aria-current="page"' : '' ?>><?= $p ?></a>
    <?php endfor; ?>

    <?php if ($fin < $totalPaginas): ?>
        <?php if ($fin < $totalPaginas - 1): ?><span class="px-1 text-gray-400">&hellip;</span><?php endif; ?>
        <a href="<?= esc($mkUrl($totalPaginas)) ?>" class="<?= $linkNorm ?>"><?= $totalPaginas ?></a>
    <?php endif; ?>

    <?php if ($paginaActual < $totalPaginas): ?>
        <a href="<?= esc($mkUrl($paginaActual + 1)) ?>" class="<?= $linkNorm ?>" aria-label="Página siguiente">
            <i class="fas fa-chevron-right text-[0.75rem]"></i>
        </a>
    <?php endif; ?>
</nav>
