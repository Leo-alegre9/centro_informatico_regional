<?= $this->extend('componentes/base') ?>

<?= $this->section('contenido') ?>

<?php
    $imgPrincipal = $imagenes[0] ?? null;
    $tieneMedidas = !empty($producto['ancho']) || !empty($producto['alto']) || !empty($producto['profundidad']);
    $marcaOFabrica = $producto['marca_nombre'] ?? $producto['fabrica_nombre'] ?? '';
    $disponible   = ((int) ($producto['stock'] ?? 0)) > 0;
    $esConsultar  = empty($producto['precio_texto']) || mb_strtolower($producto['precio_texto']) === 'consultar precio';
?>

<div class="bg-white min-h-[60vh] font-inter">

    <!-- ═══ BREADCRUMB ═══ -->
    <div class="border-b border-[#EEF0F3] pt-6 pb-4">
        <div class="container">
            <nav class="flex items-center gap-[6px] text-[0.78rem] text-[#9CA3AF] flex-wrap" aria-label="Breadcrumb">
                <?php foreach ($breadcrumb as $i => $b): ?>
                    <?php if ($i > 0): ?><span class="text-[#D1D5DB] text-[0.65rem]"><i class="fas fa-chevron-right"></i></span><?php endif; ?>
                    <?php if ($b['url']): ?>
                        <a href="<?= esc($b['url']) ?>" class="text-[#6B7280] no-underline transition-colors duration-150 hover:text-rojo"><?= esc($b['nombre']) ?></a>
                    <?php else: ?>
                        <span class="text-[#374151]"><?= esc($b['nombre']) ?></span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </nav>
        </div>
    </div>

    <!-- ═══ FICHA DE PRODUCTO ═══ -->
    <section class="py-8 md:py-12">
        <div class="container">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-start">

                <!-- ── GALERÍA ── -->
                <div class="flex flex-col">
                    <div class="relative w-full aspect-square bg-[#F5F5F5] rounded-2xl border border-[#EEF0F3] overflow-hidden flex items-center justify-center cursor-zoom-in" id="pdMainWrap">
                        <?php if ($imgPrincipal): ?>
                            <img id="pdMainImg"
                                 src="<?= base_url(esc($imgPrincipal['ruta'])) ?>"
                                 alt="<?= esc($imgPrincipal['alt_text'] ?? $producto['nombre']) ?>"
                                 class="w-full h-full object-contain p-4">
                            <div class="absolute bottom-3 right-3 bg-black/[0.55] text-white/90 rounded-lg px-[9px] py-1 text-[0.72rem] font-semibold flex items-center gap-1 pointer-events-none">
                                <i class="fas fa-search-plus"></i> Zoom
                            </div>
                        <?php else: ?>
                            <i class="<?= esc($producto['icono'] ?? 'fas fa-box') ?> text-[5rem] text-[#D1D5DB]"></i>
                        <?php endif; ?>
                    </div>

                    <?php if (count($imagenes) > 1): ?>
                    <div class="flex gap-[0.6rem] mt-4 overflow-x-auto pb-1" id="pdThumbs">
                        <?php foreach ($imagenes as $idx => $img): ?>
                        <button type="button"
                                class="pd-thumb shrink-0 w-[64px] h-[64px] rounded-[10px] overflow-hidden border-2 <?= $idx === 0 ? 'border-rojo' : 'border-[#EEF0F3]' ?> bg-[#F5F5F5] flex items-center justify-center transition-colors duration-200 hover:border-rojo/60"
                                data-src="<?= base_url(esc($img['ruta'])) ?>"
                                data-alt="<?= esc($img['alt_text'] ?? $producto['nombre']) ?>"
                                aria-label="Ver imagen <?= $idx + 1 ?> de <?= esc($producto['nombre']) ?>">
                            <img src="<?= base_url(esc($img['ruta'])) ?>" alt="" loading="lazy" class="w-full h-full object-cover">
                        </button>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- ── INFORMACIÓN ── -->
                <div class="flex flex-col">
                    <?php if (!empty($marcaOFabrica)): ?>
                        <div class="text-[0.75rem] font-bold text-rojo uppercase tracking-[1px] mb-1"><?= esc($marcaOFabrica) ?></div>
                    <?php endif; ?>

                    <?php if (!empty($producto['categoria_nombre'])): ?>
                        <div class="text-[0.78rem] text-[#9CA3AF] font-semibold mb-2"><?= esc($producto['categoria_nombre']) ?></div>
                    <?php endif; ?>

                    <h1 class="text-[1.5rem] md:text-[1.8rem] font-extrabold text-[#111827] leading-[1.3] mb-2"><?= esc($producto['nombre']) ?></h1>

                    <?php if (!empty($producto['modelo']) || !empty($producto['codigo'])): ?>
                        <div class="text-[0.85rem] text-[#6B7280] mb-3">
                            <?php if (!empty($producto['modelo'])): ?>Modelo: <strong class="text-[#374151]"><?= esc($producto['modelo']) ?></strong><?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($producto['badge'])): ?>
                        <span class="inline-block bg-rojo text-white text-[0.72rem] font-bold tracking-[0.5px] px-3 py-[4px] rounded-full uppercase mb-4 w-fit"><?= esc($producto['badge']) ?></span>
                    <?php endif; ?>

                    <div class="w-[42px] h-[3px] bg-rojo rounded mb-4"></div>

                    <?php if (!empty($producto['descripcion'] ?? $producto['descripcion_corta'] ?? '')): ?>
                        <p class="text-[#4B5563] text-[0.94rem] leading-[1.75] mb-5 whitespace-pre-line"><?= esc($producto['descripcion'] ?: $producto['descripcion_corta']) ?></p>
                    <?php endif; ?>

                    <div class="mb-5">
                        <span class="text-[0.7rem] font-bold uppercase tracking-[1px] text-[#9CA3AF] block mb-1">Precio</span>
                        <div class="<?= $esConsultar ? 'text-[1.05rem] text-[#6B7280] italic font-semibold' : 'text-[1.6rem] font-extrabold text-[#111827]' ?>">
                            <?= $esConsultar ? 'Consultar precio' : esc($producto['precio_texto']) ?>
                        </div>
                    </div>

                    <?php if (!empty($colores)): ?>
                    <div class="mb-5">
                        <span class="text-[0.7rem] font-bold uppercase tracking-[1px] text-[#9CA3AF] block mb-2">Colores disponibles</span>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($colores as $c): ?>
                            <span class="inline-flex items-center gap-[6px] border-[1.5px] border-[#E5E7EB] rounded-full pl-[6px] pr-[12px] py-[4px] text-[0.82rem] text-[#374151]">
                                <?php if (!empty($c['hex'])): ?>
                                <span class="w-[16px] h-[16px] rounded-full border border-black/10" style="background-color: <?= esc($c['hex']) ?>"></span>
                                <?php endif; ?>
                                <?= esc($c['nombre']) ?>
                            </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($tieneMedidas || !empty($producto['material'])): ?>
                    <div class="mb-5 rounded-xl border border-[#EEF0F3] divide-y divide-[#EEF0F3] overflow-hidden">
                        <?php if ($tieneMedidas): ?>
                        <div class="flex items-center justify-between px-4 py-[0.6rem] text-[0.86rem]">
                            <span class="text-[#9CA3AF] font-semibold">Dimensiones (An × Al × Prof)</span>
                            <span class="text-[#374151] font-semibold">
                                <?= esc($producto['ancho'] ?: '—') ?> × <?= esc($producto['alto'] ?: '—') ?> × <?= esc($producto['profundidad'] ?: '—') ?> <?= esc($producto['unidad_medida'] ?? 'cm') ?>
                            </span>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($producto['material'])): ?>
                        <div class="flex items-center justify-between px-4 py-[0.6rem] text-[0.86rem]">
                            <span class="text-[#9CA3AF] font-semibold">Material</span>
                            <span class="text-[#374151] font-semibold"><?= esc($producto['material']) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($caracteristicas)): ?>
                    <div class="mb-5">
                        <span class="text-[0.7rem] font-bold uppercase tracking-[1px] text-[#9CA3AF] block mb-2">Características</span>
                        <ul class="rounded-xl border border-[#EEF0F3] divide-y divide-[#EEF0F3] overflow-hidden m-0 p-0 list-none">
                            <?php foreach ($caracteristicas as $car): ?>
                            <li class="flex items-center justify-between px-4 py-[0.6rem] text-[0.86rem]">
                                <span class="text-[#9CA3AF] font-semibold"><?= esc($car['clave']) ?></span>
                                <span class="text-[#374151] font-semibold text-right"><?= esc($car['valor']) ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <div class="mb-6 flex items-center gap-2 text-[0.85rem] font-semibold <?= $disponible ? 'text-emerald-600' : 'text-[#9CA3AF]' ?>">
                        <i class="fas fa-circle text-[0.5rem]"></i>
                        <?= $disponible ? 'Disponible' : 'Sin stock por el momento' ?>
                    </div>

                    <a href="<?= esc($waHref) ?>" target="_blank" rel="noopener"
                       class="inline-flex items-center justify-center gap-2 bg-[#25D366] text-white px-7 py-[0.85rem] rounded-full font-bold text-[0.94rem] no-underline transition-colors duration-200 hover:bg-[#1ebe5a] hover:text-white w-full sm:w-auto">
                        <i class="fab fa-whatsapp text-[1.1rem]"></i> Consultar por WhatsApp
                    </a>
                </div>

            </div>
        </div>
    </section>
</div>

<!-- ═══ LIGHTBOX ZOOM (liviano, tema claro) ═══ -->
<div id="pdLightbox" class="hidden fixed inset-0 bg-black/[0.92] z-[9000] items-center justify-center select-none">
    <img id="pdLbImg" src="" alt="" class="max-w-[92vw] max-h-[92vh] object-contain">
    <button id="pdLbClose" aria-label="Cerrar zoom" class="fixed top-4 right-4 w-11 h-11 bg-white/10 border border-white/20 rounded-full text-white flex items-center justify-center cursor-pointer hover:bg-rojo hover:border-rojo transition-colors duration-200">
        <i class="fas fa-times"></i>
    </button>
</div>

<script>
(function () {
    var mainWrap = document.getElementById('pdMainWrap');
    var mainImg  = document.getElementById('pdMainImg');
    var thumbs   = document.querySelectorAll('.pd-thumb');
    var lightbox = document.getElementById('pdLightbox');
    var lbImg    = document.getElementById('pdLbImg');
    var lbClose  = document.getElementById('pdLbClose');

    thumbs.forEach(function (th) {
        th.addEventListener('click', function () {
            if (!mainImg) return;
            mainImg.src = this.dataset.src;
            mainImg.alt = this.dataset.alt || '';
            thumbs.forEach(function (t) {
                t.classList.remove('border-rojo');
                t.classList.add('border-[#EEF0F3]');
            });
            this.classList.remove('border-[#EEF0F3]');
            this.classList.add('border-rojo');
        });
    });

    if (mainWrap && mainImg) {
        mainWrap.addEventListener('click', function () {
            if (!mainImg.src) return;
            lbImg.src = mainImg.src;
            lbImg.alt = mainImg.alt;
            lightbox.classList.remove('hidden');
            lightbox.classList.add('flex');
            document.body.style.overflow = 'hidden';
        });
    }

    function cerrarLightbox() {
        lightbox.classList.remove('flex');
        lightbox.classList.add('hidden');
        document.body.style.overflow = '';
    }
    lbClose.addEventListener('click', cerrarLightbox);
    lightbox.addEventListener('click', function (e) {
        if (e.target === lightbox) cerrarLightbox();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') cerrarLightbox();
    });
})();
</script>

<?= $this->endSection() ?>
