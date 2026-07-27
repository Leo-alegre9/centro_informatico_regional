<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<?php
    $imagenesGenerales = $imagenesGenerales ?? [];
    $variantesColor    = $variantesColor ?? [];
    $caracteristicas   = $caracteristicas ?? [];
    $imgPrincipal      = $imagenesGenerales[0] ?? null;
    $tieneMedidas      = !empty($producto['ancho']) || !empty($producto['alto']) || !empty($producto['profundidad']);
?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
    <div class="flex items-center gap-3">
        <a href="<?= base_url('admin/productos') ?>" class="text-gray-400 hover:text-rojo transition-colors text-lg" title="Volver">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-[1.4rem] font-bold text-dark m-0"><i class="fas fa-eye mr-2 text-rojo text-[1.1rem]"></i><?= esc($producto['nombre']) ?></h2>
        <?php if ($producto['activo']): ?>
            <span class="bg-emerald-500/10 text-emerald-600 px-[0.6rem] py-[0.2rem] rounded-full text-xs font-semibold"><i class="fas fa-check mr-1"></i>Activo</span>
        <?php else: ?>
            <span class="bg-red-500/10 text-red-600 px-[0.6rem] py-[0.2rem] rounded-full text-xs font-semibold"><i class="fas fa-times mr-1"></i>Inactivo</span>
        <?php endif; ?>
        <?php if ($producto['destacado']): ?>
            <span class="bg-violet-500/10 text-violet-600 px-[0.6rem] py-[0.2rem] rounded-full text-xs font-semibold"><i class="fas fa-star mr-1"></i>Destacado</span>
        <?php endif; ?>
    </div>
    <a href="<?= base_url("admin/productos/{$producto['id']}/editar") ?>" class="bg-rojo text-white border-none px-5 py-[0.55rem] rounded-full text-sm font-semibold no-underline inline-flex items-center gap-[0.4rem] transition-colors hover:bg-rojo-dark hover:text-white">
        <i class="fas fa-pen"></i> Editar producto
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- ── GALERÍA ── -->
    <div class="bg-white border border-gray-200 rounded-[14px] p-5">
        <div class="relative w-full aspect-square bg-gray-50 rounded-xl border border-gray-200 overflow-hidden flex items-center justify-center" id="pdMainWrap">
            <img id="pdMainImg"
                 src="<?= $imgPrincipal ? base_url(esc($imgPrincipal['ruta'])) : '' ?>"
                 alt="<?= esc($producto['nombre']) ?>"
                 class="w-full h-full object-contain p-4 <?= $imgPrincipal ? '' : 'hidden' ?>">
            <i id="pdMainIcon" class="<?= esc($producto['icono'] ?? 'fas fa-box') ?> text-[5rem] text-gray-300 <?= $imgPrincipal ? 'hidden' : '' ?>"></i>
            <button type="button" id="pdPrevBtn" aria-label="Imagen anterior"
                    class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/90 border border-gray-200 text-gray-600 flex items-center justify-center shadow-sm transition-colors hover:bg-rojo hover:text-white z-10 <?= count($imagenesGenerales) > 1 ? '' : 'hidden' ?>">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button type="button" id="pdNextBtn" aria-label="Imagen siguiente"
                    class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/90 border border-gray-200 text-gray-600 flex items-center justify-center shadow-sm transition-colors hover:bg-rojo hover:text-white z-10 <?= count($imagenesGenerales) > 1 ? '' : 'hidden' ?>">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <div class="flex gap-[0.6rem] mt-4 overflow-x-auto pb-1 <?= count($imagenesGenerales) > 1 ? '' : 'hidden' ?>" id="pdThumbs">
            <?php foreach ($imagenesGenerales as $idx => $img): ?>
            <button type="button" class="pd-thumb shrink-0 w-[64px] h-[64px] rounded-[10px] overflow-hidden border-2 <?= $idx === 0 ? 'border-rojo' : 'border-gray-200' ?> bg-gray-50 flex items-center justify-center transition-colors">
                <img src="<?= base_url(esc($img['ruta'])) ?>" alt="" loading="lazy" class="w-full h-full object-cover">
            </button>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($variantesColor)): ?>
        <div class="mt-5 pt-4 border-t border-gray-100">
            <span class="text-[0.7rem] font-bold uppercase tracking-[1px] text-gray-400 block mb-2">Colores cargados (<?= count($variantesColor) ?>)</span>
            <div class="flex flex-wrap gap-3" id="pdColorSwatches">
                <?php foreach ($variantesColor as $v): ?>
                <button type="button"
                        class="pd-color-swatch relative w-[38px] h-[38px] rounded-lg border-2 border-gray-200 cursor-pointer transition-all hover:border-rojo/60"
                        style="<?= esc($v['estilo'], 'attr') ?>"
                        data-nombre="<?= esc($v['nombre']) ?>"
                        data-color-id="<?= (int) $v['id'] ?>"
                        title="<?= esc($v['nombre']) ?> <?= $v['activo'] ? '' : '(inactivo)' ?>">
                    <?php if (!$v['activo']): ?>
                        <span class="absolute -top-1 -right-1 w-[14px] h-[14px] bg-gray-400 text-white rounded-full flex items-center justify-center text-[0.5rem]"><i class="fas fa-slash"></i></span>
                    <?php endif; ?>
                    <span class="pd-swatch-check absolute -top-[6px] -right-[6px] w-[16px] h-[16px] bg-rojo text-white rounded-full hidden items-center justify-center text-[0.5rem] shadow">
                        <i class="fas fa-check"></i>
                    </span>
                </button>
                <?php endforeach; ?>
            </div>
            <div class="mt-2 text-[0.82rem] text-gray-600">Color: <strong id="pdColorSeleccionado">Ninguno (imágenes generales)</strong></div>
        </div>
        <?php endif; ?>
    </div>

    <!-- ── DETALLES ── -->
    <div class="flex flex-col gap-5">

        <div class="bg-amber-50 border border-amber-200 rounded-[14px] px-5 py-4">
            <div class="text-[0.7rem] font-bold uppercase tracking-[1px] text-amber-700 mb-1"><i class="fas fa-lock mr-1"></i>Precio interno (solo administrador)</div>
            <div class="text-[1.4rem] font-extrabold text-amber-800">
                <?= !empty($producto['precio_interno']) ? '$' . number_format((float) $producto['precio_interno'], 2, ',', '.') : 'No cargado' ?>
            </div>
            <div class="text-[0.78rem] text-amber-700/80 mt-1">Este valor nunca se muestra al cliente en el sitio público.</div>
        </div>

        <div class="bg-white border border-gray-200 rounded-[14px] divide-y divide-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-3 text-[0.88rem]">
                <span class="text-gray-400 font-semibold">Precio público</span>
                <span class="text-dark font-semibold"><?= esc($producto['precio_texto'] ?: 'Consultar precio') ?></span>
            </div>
            <?php if (!empty($producto['precio_dolar'])): ?>
            <div class="flex items-center justify-between px-5 py-3 text-[0.88rem]">
                <span class="text-gray-400 font-semibold">Precio base (USD)</span>
                <span class="text-dark font-semibold">USD <?= esc(number_format((float) $producto['precio_dolar'], 2)) ?></span>
            </div>
            <?php endif; ?>
            <div class="flex items-center justify-between px-5 py-3 text-[0.88rem]">
                <span class="text-gray-400 font-semibold">Código</span>
                <span class="text-dark font-semibold"><?= esc($producto['codigo'] ?: '—') ?></span>
            </div>
            <div class="flex items-center justify-between px-5 py-3 text-[0.88rem]">
                <span class="text-gray-400 font-semibold">Modelo</span>
                <span class="text-dark font-semibold"><?= esc($producto['modelo'] ?: '—') ?></span>
            </div>
            <div class="flex items-center justify-between px-5 py-3 text-[0.88rem]">
                <span class="text-gray-400 font-semibold">Categoría</span>
                <span class="text-dark font-semibold"><?= esc($producto['categoria_nombre'] ?? '—') ?></span>
            </div>
            <?php if (!empty($producto['marca_nombre'])): ?>
            <div class="flex items-center justify-between px-5 py-3 text-[0.88rem]">
                <span class="text-gray-400 font-semibold">Marca</span>
                <span class="text-dark font-semibold"><?= esc($producto['marca_nombre']) ?></span>
            </div>
            <?php endif; ?>
            <?php if (!empty($producto['fabrica_nombre'])): ?>
            <div class="flex items-center justify-between px-5 py-3 text-[0.88rem]">
                <span class="text-gray-400 font-semibold">Fábrica</span>
                <span class="text-dark font-semibold"><?= esc($producto['fabrica_nombre']) ?></span>
            </div>
            <?php endif; ?>
            <?php if (!empty($producto['linea_nombre'])): ?>
            <div class="flex items-center justify-between px-5 py-3 text-[0.88rem]">
                <span class="text-gray-400 font-semibold">Línea</span>
                <span class="text-dark font-semibold"><?= esc($producto['linea_nombre']) ?></span>
            </div>
            <?php endif; ?>
            <div class="flex items-center justify-between px-5 py-3 text-[0.88rem]">
                <span class="text-gray-400 font-semibold">Stock</span>
                <span class="text-dark font-semibold"><?= (int) $producto['stock'] ?></span>
            </div>
            <div class="flex items-center justify-between px-5 py-3 text-[0.88rem]">
                <span class="text-gray-400 font-semibold">Ubicación</span>
                <span class="text-dark font-semibold"><?= esc($producto['ubicacion'] ?: '—') ?></span>
            </div>
            <?php if ($tieneMedidas): ?>
            <div class="flex items-center justify-between px-5 py-3 text-[0.88rem]">
                <span class="text-gray-400 font-semibold">Dimensiones (An × Al × Prof)</span>
                <span class="text-dark font-semibold"><?= esc($producto['ancho'] ?: '—') ?> × <?= esc($producto['alto'] ?: '—') ?> × <?= esc($producto['profundidad'] ?: '—') ?> <?= esc($producto['unidad_medida'] ?? 'cm') ?></span>
            </div>
            <?php endif; ?>
            <?php if (!empty($producto['material'])): ?>
            <div class="flex items-center justify-between px-5 py-3 text-[0.88rem]">
                <span class="text-gray-400 font-semibold">Material</span>
                <span class="text-dark font-semibold"><?= esc($producto['material']) ?></span>
            </div>
            <?php endif; ?>
            <?php if (!empty($producto['badge'])): ?>
            <div class="flex items-center justify-between px-5 py-3 text-[0.88rem]">
                <span class="text-gray-400 font-semibold">Etiqueta</span>
                <span class="bg-rojo/[0.08] text-rojo px-[0.6rem] py-[0.15rem] rounded-full text-xs font-semibold"><?= esc($producto['badge']) ?></span>
            </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($producto['descripcion_corta']) || !empty($producto['descripcion'])): ?>
        <div class="bg-white border border-gray-200 rounded-[14px] px-5 py-4">
            <div class="text-[0.7rem] font-bold uppercase tracking-[1px] text-gray-400 mb-2">Descripción</div>
            <?php if (!empty($producto['descripcion_corta'])): ?>
                <p class="text-[0.88rem] text-gray-700 font-semibold mb-2"><?= esc($producto['descripcion_corta']) ?></p>
            <?php endif; ?>
            <?php if (!empty($producto['descripcion'])): ?>
                <p class="text-[0.86rem] text-gray-500 leading-relaxed whitespace-pre-line m-0"><?= esc($producto['descripcion']) ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($caracteristicas)): ?>
        <div class="bg-white border border-gray-200 rounded-[14px] overflow-hidden">
            <div class="text-[0.7rem] font-bold uppercase tracking-[1px] text-gray-400 px-5 pt-4 mb-1">Características</div>
            <div class="divide-y divide-gray-100">
                <?php foreach ($caracteristicas as $car): ?>
                <div class="flex items-center justify-between px-5 py-3 text-[0.86rem]">
                    <span class="text-gray-400 font-semibold"><?= esc($car['clave']) ?></span>
                    <span class="text-dark font-semibold text-right"><?= esc($car['valor']) ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<?php
    $pdGaleriaInicialJs = array_map(static fn (array $img): array => [
        'src' => base_url($img['ruta']),
        'alt' => $img['alt_text'] ?? $producto['nombre'],
    ], $imagenesGenerales);

    $pdGaleriasPorColorJs = [];
    foreach ($variantesColor as $v) {
        $galeriaColor = $v['galeria'] ?? [];
        $pdGaleriasPorColorJs[$v['id']] = $galeriaColor !== []
            ? array_map(static fn (array $img): array => [
                'src' => base_url($img['imagen']),
                'alt' => $img['texto_alternativo'] ?? $v['nombre'],
            ], $galeriaColor)
            : $pdGaleriaInicialJs;
    }
?>
<script>
var pdGaleriaInicial   = <?= json_encode($pdGaleriaInicialJs) ?>;
var pdGaleriasPorColor = <?= json_encode($pdGaleriasPorColorJs) ?>;

(function () {
    var mainImg    = document.getElementById('pdMainImg');
    var mainIcon   = document.getElementById('pdMainIcon');
    var thumbsWrap = document.getElementById('pdThumbs');
    var prevBtn    = document.getElementById('pdPrevBtn');
    var nextBtn    = document.getElementById('pdNextBtn');

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
                (idx === 0 ? 'border-rojo' : 'border-gray-200') +
                ' bg-gray-50 flex items-center justify-center transition-colors';
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
            t.classList.toggle('border-gray-200', i !== idx);
        });
    }

    function toggleNav() {
        var visible = images.length > 1;
        [prevBtn, nextBtn].forEach(function (b) { if (b) b.classList.toggle('hidden', !visible); });
    }

    function showImage(idx) {
        if (!images.length) {
            if (mainImg) mainImg.classList.add('hidden');
            if (mainIcon) mainIcon.classList.remove('hidden');
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
        setActiveThumb(idx);
    }

    function setGaleria(nuevasImagenes) {
        images = nuevasImagenes || [];
        buildThumbs();
        toggleNav();
        showImage(0);
    }
    window.pdSetGaleria = setGaleria;

    buildThumbs();

    if (prevBtn) prevBtn.addEventListener('click', function () { showImage(currentIndex - 1); });
    if (nextBtn) nextBtn.addEventListener('click', function () { showImage(currentIndex + 1); });
})();

/* ─── Selección de color (misma lógica que la ficha pública: click = elegir, click de nuevo = destildar) ─── */
(function () {
    var swatches = Array.prototype.slice.call(document.querySelectorAll('.pd-color-swatch'));
    if (!swatches.length) return;

    var seleccionadoEl = document.getElementById('pdColorSeleccionado');
    var galerias        = pdGaleriasPorColor || {};
    var activeIdx        = -1;

    function marcarActivo(idx) {
        swatches.forEach(function (sw, i) {
            var activo = i === idx;
            sw.classList.toggle('border-rojo', activo);
            sw.classList.toggle('border-gray-200', !activo);
            var check = sw.querySelector('.pd-swatch-check');
            if (check) {
                check.classList.toggle('flex', activo);
                check.classList.toggle('hidden', !activo);
            }
        });
    }

    function deseleccionar() {
        activeIdx = -1;
        marcarActivo(-1);
        if (seleccionadoEl) seleccionadoEl.textContent = 'Ninguno (imágenes generales)';
        if (window.pdSetGaleria) window.pdSetGaleria(pdGaleriaInicial || []);
    }

    function seleccionar(idx) {
        if (idx === activeIdx) { deseleccionar(); return; }
        activeIdx = idx;
        marcarActivo(idx);
        var swatch = swatches[idx];
        if (seleccionadoEl) seleccionadoEl.textContent = swatch.dataset.nombre || '';
        if (window.pdSetGaleria) window.pdSetGaleria(galerias[swatch.dataset.colorId] || []);
    }

    swatches.forEach(function (sw, idx) {
        sw.addEventListener('click', function () { seleccionar(idx); });
    });
})();
</script>

<?= $this->endSection() ?>
