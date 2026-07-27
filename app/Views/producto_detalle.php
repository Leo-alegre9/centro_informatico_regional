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
                    <div class="relative w-full aspect-square bg-[#F5F5F5] rounded-2xl border border-[#EEF0F3] overflow-hidden flex items-center justify-center cursor-zoom-in outline-none focus-visible:ring-2 focus-visible:ring-rojo" id="pdMainWrap" tabindex="0" aria-label="Galería de imágenes del producto, usá las flechas del teclado o deslizá para cambiar de imagen">
                        <img id="pdMainImg"
                             src="<?= $imgPrincipal ? base_url(esc($imgPrincipal['ruta'])) : '' ?>"
                             alt="<?= esc($imgPrincipal ? ($imgPrincipal['alt_text'] ?? $producto['nombre']) : $producto['nombre']) ?>"
                             class="w-full h-full object-contain p-4 <?= $imgPrincipal ? '' : 'hidden' ?>">
                        <i id="pdMainIcon" class="<?= esc($producto['icono'] ?? 'fas fa-box') ?> text-[5rem] text-[#D1D5DB] <?= $imgPrincipal ? 'hidden' : '' ?>"></i>
                        <div id="pdZoomBadge" class="absolute bottom-3 right-3 bg-black/[0.55] text-white/90 rounded-lg px-[9px] py-1 text-[0.72rem] font-semibold flex items-center gap-1 pointer-events-none <?= $imgPrincipal ? '' : 'hidden' ?>">
                            <i class="fas fa-search-plus"></i> Zoom
                        </div>
                        <button type="button" id="pdPrevBtn" aria-label="Imagen anterior"
                                class="pd-nav-btn absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/85 border border-[#EEF0F3] text-[#374151] flex items-center justify-center shadow-sm transition-colors duration-150 hover:bg-rojo hover:text-white hover:border-rojo z-10 <?= count($imagenes) > 1 ? '' : 'hidden' ?>">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" id="pdNextBtn" aria-label="Imagen siguiente"
                                class="pd-nav-btn absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/85 border border-[#EEF0F3] text-[#374151] flex items-center justify-center shadow-sm transition-colors duration-150 hover:bg-rojo hover:text-white hover:border-rojo z-10 <?= count($imagenes) > 1 ? '' : 'hidden' ?>">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                    <div class="flex gap-[0.6rem] mt-4 overflow-x-auto pb-1 <?= count($imagenes) > 1 ? '' : 'hidden' ?>" id="pdThumbs">
                        <?php foreach ($imagenes as $idx => $img): ?>
                        <button type="button"
                                class="pd-thumb shrink-0 w-[64px] h-[64px] rounded-[10px] overflow-hidden border-2 <?= $idx === 0 ? 'border-rojo' : 'border-[#EEF0F3]' ?> bg-[#F5F5F5] flex items-center justify-center transition-colors duration-200 hover:border-rojo/60"
                                aria-label="Ver imagen <?= $idx + 1 ?> de <?= esc($producto['nombre']) ?>">
                            <img src="<?= base_url(esc($img['ruta'])) ?>" alt="" loading="lazy" class="w-full h-full object-cover">
                        </button>
                        <?php endforeach; ?>
                    </div>
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

                    <?php if (!empty($variantesColor)): ?>
                    <div class="mb-5">
                        <span class="text-[0.7rem] font-bold uppercase tracking-[1px] text-[#9CA3AF] block mb-2">Color</span>
                        <div class="flex flex-wrap gap-3" id="pdColorSwatches" role="group" aria-label="Colores disponibles">
                            <?php foreach ($variantesColor as $i => $v): ?>
                            <button type="button"
                                    class="pd-color-swatch relative w-[42px] h-[42px] rounded-lg border-2 border-[#E5E7EB] cursor-pointer transition-all duration-150 hover:border-rojo/60 outline-none focus-visible:ring-2 focus-visible:ring-rojo focus-visible:ring-offset-2"
                                    style="<?= esc($v['estilo'], 'attr') ?>"
                                    data-nombre="<?= esc($v['nombre']) ?>"
                                    data-color-id="<?= (int) $v['id'] ?>"
                                    title="<?= esc($v['nombre']) ?>"
                                    aria-label="Color: <?= esc($v['nombre']) ?>"
                                    aria-pressed="false">
                                <span class="pd-swatch-check absolute -top-[7px] -right-[7px] w-[18px] h-[18px] bg-rojo text-white rounded-full items-center justify-center text-[0.55rem] shadow hidden">
                                    <i class="fas fa-check"></i>
                                </span>
                            </button>
                            <?php endforeach; ?>
                        </div>
                        <div class="mt-2 text-[0.85rem] text-[#374151]">Color: <strong id="pdColorSeleccionado">Ninguno seleccionado</strong></div>
                    </div>
                    <?php endif; ?>

                    <?php if ($tieneMedidas || !empty($producto['material']) || !empty($producto['linea_nombre'])): ?>
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
                        <?php if (!empty($producto['linea_nombre'])): ?>
                        <div class="flex items-center justify-between px-4 py-[0.6rem] text-[0.86rem]">
                            <span class="text-[#9CA3AF] font-semibold">Línea</span>
                            <span class="text-[#374151] font-semibold"><?= esc($producto['linea_nombre']) ?></span>
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
    <button type="button" id="pdLbPrev" aria-label="Imagen anterior" class="fixed left-3 md:left-6 top-1/2 -translate-y-1/2 w-11 h-11 bg-white/10 border border-white/20 rounded-full text-white flex items-center justify-center cursor-pointer hover:bg-rojo hover:border-rojo transition-colors duration-200 <?= count($imagenes) > 1 ? '' : 'hidden' ?>">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button type="button" id="pdLbNext" aria-label="Imagen siguiente" class="fixed right-3 md:right-6 top-1/2 -translate-y-1/2 w-11 h-11 bg-white/10 border border-white/20 rounded-full text-white flex items-center justify-center cursor-pointer hover:bg-rojo hover:border-rojo transition-colors duration-200 <?= count($imagenes) > 1 ? '' : 'hidden' ?>">
        <i class="fas fa-chevron-right"></i>
    </button>
</div>

<?php
    // Galería inicial (la que ya viene renderizada por PHP) y galería propia de cada color,
    // para que el selector de color pueda cambiar las imágenes sin recargar la página.
    $pdGaleriaInicialJs = array_map(static fn (array $img): array => [
        'src' => base_url($img['ruta']),
        'alt' => $img['alt_text'] ?? $producto['nombre'],
    ], $imagenes);

    $pdGaleriasPorColorJs = [];
    foreach ($variantesColor as $v) {
        $pdGaleriasPorColorJs[$v['id']] = array_map(static fn (array $img): array => [
            'src' => base_url($img['ruta']),
            'alt' => $img['alt_text'] ?? $v['nombre'],
        ], $v['imagenes'] ?? []);
    }
?>
<script>
var pdGaleriaInicial   = <?= json_encode($pdGaleriaInicialJs) ?>;
var pdGaleriasPorColor = <?= json_encode($pdGaleriasPorColorJs) ?>;

(function () {
    var mainWrap   = document.getElementById('pdMainWrap');
    var mainImg    = document.getElementById('pdMainImg');
    var mainIcon   = document.getElementById('pdMainIcon');
    var zoomBadge  = document.getElementById('pdZoomBadge');
    var thumbsWrap = document.getElementById('pdThumbs');
    var lightbox   = document.getElementById('pdLightbox');
    var lbImg      = document.getElementById('pdLbImg');
    var lbClose    = document.getElementById('pdLbClose');
    var prevBtn    = document.getElementById('pdPrevBtn');
    var nextBtn    = document.getElementById('pdNextBtn');
    var lbPrev     = document.getElementById('pdLbPrev');
    var lbNext     = document.getElementById('pdLbNext');

    var images = pdGaleriaInicial || [];
    var currentIndex = 0;

    function buildThumbs() {
        if (!thumbsWrap) return;
        thumbsWrap.innerHTML = '';
        if (images.length < 2) {
            thumbsWrap.classList.add('hidden');
            return;
        }
        thumbsWrap.classList.remove('hidden');
        images.forEach(function (data, idx) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'pd-thumb shrink-0 w-[64px] h-[64px] rounded-[10px] overflow-hidden border-2 ' +
                (idx === 0 ? 'border-rojo' : 'border-[#EEF0F3]') +
                ' bg-[#F5F5F5] flex items-center justify-center transition-colors duration-200 hover:border-rojo/60';
            btn.setAttribute('aria-label', 'Ver imagen ' + (idx + 1));
            var thumbImg = document.createElement('img');
            thumbImg.src = data.src;
            thumbImg.alt = '';
            thumbImg.loading = 'lazy';
            thumbImg.className = 'w-full h-full object-cover';
            btn.appendChild(thumbImg);
            btn.addEventListener('click', function () { showImage(idx); });
            thumbsWrap.appendChild(btn);
        });
    }

    function setActiveThumb(idx) {
        if (!thumbsWrap) return;
        Array.prototype.forEach.call(thumbsWrap.children, function (t, i) {
            t.classList.toggle('border-rojo', i === idx);
            t.classList.toggle('border-[#EEF0F3]', i !== idx);
        });
    }

    function toggleNav() {
        var visible = images.length > 1;
        [prevBtn, nextBtn, lbPrev, lbNext].forEach(function (b) {
            if (b) b.classList.toggle('hidden', !visible);
        });
    }

    function showImage(idx) {
        if (!images.length) {
            if (mainImg) mainImg.classList.add('hidden');
            if (mainIcon) mainIcon.classList.remove('hidden');
            if (zoomBadge) zoomBadge.classList.add('hidden');
            return;
        }
        idx = ((idx % images.length) + images.length) % images.length;
        currentIndex = idx;
        var data = images[idx];
        if (mainImg) {
            mainImg.src = data.src;
            mainImg.alt = data.alt;
            mainImg.classList.remove('hidden');
        }
        if (mainIcon) mainIcon.classList.add('hidden');
        if (zoomBadge) zoomBadge.classList.remove('hidden');
        setActiveThumb(idx);
        if (lightbox && lightbox.classList.contains('flex')) {
            lbImg.src = data.src;
            lbImg.alt = data.alt;
        }
    }

    /** Reemplaza la galería activa (usado al elegir un color) y muestra su primera imagen. */
    function setGaleria(nuevasImagenes) {
        images = nuevasImagenes || [];
        buildThumbs();
        toggleNav();
        showImage(0);
    }
    window.pdSetGaleria = setGaleria;

    buildThumbs();

    [prevBtn, lbPrev].forEach(function (btn) {
        if (!btn) return;
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            showImage(currentIndex - 1);
        });
    });
    [nextBtn, lbNext].forEach(function (btn) {
        if (!btn) return;
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            showImage(currentIndex + 1);
        });
    });

    // Soporte de deslizamiento táctil (swipe) para cambiar de imagen
    function addSwipeSupport(el) {
        if (!el) return;
        var startX = 0, startY = 0, deltaX = 0, deltaY = 0, tracking = false, swiped = false;

        el.addEventListener('touchstart', function (e) {
            if (e.touches.length !== 1 || images.length < 2) return;
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
            deltaX = 0;
            deltaY = 0;
            tracking = true;
            swiped = false;
        }, { passive: true });

        el.addEventListener('touchmove', function (e) {
            if (!tracking) return;
            deltaX = e.touches[0].clientX - startX;
            deltaY = e.touches[0].clientY - startY;
            if (!swiped && Math.abs(deltaX) > 10 && Math.abs(deltaX) > Math.abs(deltaY)) {
                swiped = true;
            }
            if (swiped && e.cancelable) e.preventDefault();
        }, { passive: false });

        el.addEventListener('touchend', function () {
            if (!tracking) return;
            tracking = false;
            if (swiped && Math.abs(deltaX) > 40) {
                showImage(currentIndex + (deltaX < 0 ? 1 : -1));
            }
        });

        // Evita que un swipe también dispare el click (abrir/cerrar zoom)
        el.addEventListener('click', function (e) {
            if (swiped) {
                swiped = false;
                e.stopImmediatePropagation();
                e.preventDefault();
            }
        }, true);
    }
    addSwipeSupport(mainWrap);
    addSwipeSupport(lightbox);

    if (mainWrap && mainImg) {
        mainWrap.addEventListener('click', function (e) {
            if (e.target === prevBtn || e.target === nextBtn || (prevBtn && prevBtn.contains(e.target)) || (nextBtn && nextBtn.contains(e.target))) return;
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
        if (e.key === 'Escape') {
            cerrarLightbox();
            return;
        }
        if (images.length < 2 || (e.key !== 'ArrowLeft' && e.key !== 'ArrowRight')) return;

        var lightboxOpen = lightbox && lightbox.classList.contains('flex');
        var mainFocused  = mainWrap && (document.activeElement === mainWrap || mainWrap.contains(document.activeElement));
        if (!lightboxOpen && !mainFocused) return;

        e.preventDefault();
        showImage(currentIndex + (e.key === 'ArrowLeft' ? -1 : 1));
    });
})();

/* ─── Selección visual de color/variante (sin recargar la página) ─── */
(function () {
    var swatches = Array.prototype.slice.call(document.querySelectorAll('.pd-color-swatch'));
    if (!swatches.length) return;

    var seleccionadoEl = document.getElementById('pdColorSeleccionado');
    var galerias       = pdGaleriasPorColor || {};
    var activeIdx      = -1;

    function marcarActivo(idx) {
        swatches.forEach(function (sw, i) {
            var activo = i === idx;
            sw.classList.toggle('border-rojo', activo);
            sw.classList.toggle('border-[#E5E7EB]', !activo);
            sw.setAttribute('aria-pressed', activo ? 'true' : 'false');
            var check = sw.querySelector('.pd-swatch-check');
            if (check) {
                check.classList.toggle('flex', activo);
                check.classList.toggle('hidden', !activo);
            }
        });
    }

    /** Clic en el color ya activo: lo destilda y vuelve a las imágenes generales del producto. */
    function deseleccionar() {
        activeIdx = -1;
        marcarActivo(-1);
        if (seleccionadoEl) seleccionadoEl.textContent = 'Ninguno seleccionado';
        if (window.pdSetGaleria) window.pdSetGaleria(pdGaleriaInicial || []);
    }

    function seleccionar(idx) {
        if (idx === activeIdx) {
            deseleccionar();
            return;
        }
        activeIdx = idx;
        marcarActivo(idx);
        var swatch = swatches[idx];
        if (seleccionadoEl) seleccionadoEl.textContent = swatch.dataset.nombre || '';
        if (window.pdSetGaleria) {
            window.pdSetGaleria(galerias[swatch.dataset.colorId] || []);
        }
    }

    swatches.forEach(function (sw, idx) {
        sw.addEventListener('click', function () {
            seleccionar(idx);
        });
    });
})();
</script>

<?= $this->endSection() ?>
