<!-- ═══════════════════════════════════════════════
     CATÁLOGO HEADER
═══════════════════════════════════════════════ -->
<div class="relative overflow-hidden pt-12 pb-10 bg-[linear-gradient(135deg,#070c1a_0%,var(--dark-2)_60%,#180a10_100%)]">
    <div class="absolute w-[450px] h-[450px] bg-[radial-gradient(circle,rgba(255,0,51,0.11)_0%,transparent_70%)] -top-[120px] -right-[80px] rounded-full pointer-events-none"></div>
    <div class="container relative z-[1]">

        <nav class="flex items-center gap-[7px] text-[0.82rem] text-white/40 mb-[1.6rem] flex-wrap" aria-label="breadcrumb">
            <?php foreach ($breadcrumb as $i => $crumb): ?>
                <?php if ($i > 0): ?><span class="text-white/20">/</span><?php endif; ?>
                <?php if ($crumb['url'] !== null): ?>
                    <a href="<?= esc($crumb['url']) ?>" class="text-white/50 no-underline transition-colors duration-200 hover:text-rojo"><?php if ($i === 0): ?><i class="fas fa-home"></i> <?php endif; ?><?= esc($crumb['nombre']) ?></a>
                <?php else: ?>
                    <span class="text-rojo font-semibold"><?= esc($crumb['nombre']) ?></span>
                <?php endif; ?>
            <?php endforeach; ?>
        </nav>

        <div class="w-[70px] h-[70px] bg-rojo/10 border-2 border-rojo/[0.28] rounded-[18px] flex items-center justify-center text-[1.75rem] text-rojo mb-[1.1rem]">
            <i class="<?= esc($current['icono']) ?>"></i>
        </div>
        <h1 class="text-white text-[clamp(1.8rem,3.5vw,2.7rem)] font-black mb-2 leading-[1.15]"><?= esc($current['nombre']) ?></h1>
        <p class="text-white/[0.58] text-base leading-[1.75] max-w-[580px] mb-0"><?= esc($current['descripcion']) ?></p>

        <!-- Barra de búsqueda -->
        <div class="mt-8">
            <div class="flex items-center gap-[0.6rem] max-w-[640px]">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-[1.15rem] top-1/2 -translate-y-1/2 text-white/45 text-[0.95rem] pointer-events-none z-[2]"></i>
                    <input type="text"
                           id="cat-hero-search"
                           class="w-full py-[0.9rem] pr-[3rem] pl-[3rem] border-2 border-white/15 rounded-full text-[0.95rem] text-white bg-white/[0.08] outline-none transition-all duration-200 placeholder:text-white/[0.35] focus:border-rojo focus:bg-white/[0.12] focus:shadow-[0_0_0_3px_rgba(255,0,51,0.18)]"
                           placeholder="Buscar producto...">
                    <button type="button" class="hidden absolute right-[1.1rem] top-1/2 -translate-y-1/2 bg-transparent border-none text-white/50 cursor-pointer text-[0.9rem] p-1 z-[2] leading-none hover:text-rojo" id="cat-hero-clear">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <?php
            $contextNombre = $current['nombre'] ?? 'el catálogo';
            ?>
            <div class="text-[0.78rem] text-white/30 mt-[0.55rem] ml-[0.2rem]" id="cat-hero-hint">
                Buscá dentro de <strong class="text-white/[0.55]"><?= esc($contextNombre) ?></strong> — hacé clic en un resultado para ver los detalles
            </div>
        </div>

        <?php if (!empty($siblings)): ?>
        <nav class="mt-10 flex gap-[0.55rem] flex-wrap" aria-label="Navegación de rubros">
            <?php foreach ($siblings as $key => $sibling): ?>
            <a href="<?= esc($sibling['url']) ?>"
               class="inline-flex items-center gap-[6px] px-[13px] py-[6px] rounded-full text-[0.8rem] font-semibold no-underline border-[1.5px] whitespace-nowrap transition-colors duration-200 <?= $sibling['activo'] ? 'bg-rojo border-rojo text-white' : 'border-white/[0.13] text-white/60 hover:border-rojo/50 hover:text-rojo hover:bg-rojo/5' ?>">
                <i class="<?= esc($sibling['icono']) ?>"></i>
                <?= esc($sibling['nombre']) ?>
            </a>
            <?php endforeach; ?>
        </nav>
        <?php endif; ?>

    </div>
</div>

<!-- ═══════════════════════════════════════════════
     PANEL DE RESULTADOS DE BÚSQUEDA
═══════════════════════════════════════════════ -->
<div id="cat-search-panel" class="hidden bg-[#f4f6f9] border-b-2 border-[#e5e7eb]">
    <div class="container pt-8 pb-10">
        <div class="flex items-center justify-between flex-wrap gap-3 mb-6">
            <div class="text-base font-bold text-[#111827] flex items-center gap-2">
                <i class="fas fa-search text-rojo"></i>
                <span id="cat-srp-label">Resultados</span>
                <span class="hidden bg-rojo/10 text-rojo text-[0.78rem] font-bold px-[0.65rem] py-[0.18rem] rounded-full" id="cat-srp-count"></span>
            </div>
            <button type="button" class="inline-flex items-center gap-[5px] text-[#6B7280] border-[1.5px] border-[#e5e7eb] bg-white px-[0.9rem] py-[0.4rem] rounded-full text-[0.82rem] font-semibold cursor-pointer transition-colors duration-150 hover:border-rojo hover:text-rojo" id="cat-srp-close">
                <i class="fas fa-times"></i> Cerrar búsqueda
            </button>
        </div>
        <div id="cat-srp-body"></div>
    </div>
</div>

<?php
// Construir contexto de búsqueda para el JS
$searchSegments = [];
if (!empty($currentPath)) {
    $parts = explode('/', ltrim($currentPath, '/'));
    if (isset($parts[0]) && $parts[0] === 'catalogo') array_shift($parts);
    $searchSegments = array_values(array_filter($parts));
}
$contextNombreJs = addslashes($current['nombre'] ?? 'el catálogo');
?>

<script>
(function () {
    const searchInput = document.getElementById('cat-hero-search');
    const clearBtn    = document.getElementById('cat-hero-clear');
    const panel       = document.getElementById('cat-search-panel');
    const srplabel    = document.getElementById('cat-srp-label');
    const srpCount    = document.getElementById('cat-srp-count');
    const srpBody     = document.getElementById('cat-srp-body');
    const srpClose    = document.getElementById('cat-srp-close');
    const gridInput   = document.getElementById('buscador-productos'); // solo en subrubro

    const BASE   = '<?= base_url('catalogo/buscar') ?>';
    const RUBRO  = '<?= esc($searchSegments[0] ?? '') ?>';
    const SUB    = '<?= esc($searchSegments[1] ?? '') ?>';
    const SUBSUB = '<?= esc($searchSegments[2] ?? '') ?>';
    const BURL   = '<?= base_url() ?>';

    let timer = null;

    function cerrar() {
        panel.style.display = 'none';
        searchInput.value   = '';
        clearBtn.style.display = 'none';
        if (gridInput) {
            gridInput.value = '';
            gridInput.dispatchEvent(new Event('input'));
        }
    }

    function mostrarLoading(q) {
        srplabel.textContent     = 'Buscando "' + q + '"...';
        srpCount.style.display   = 'none';
        srpBody.innerHTML        = '<div class="text-center py-12 px-4 text-[#9CA3AF]"><i class="fas fa-spinner animate-spin text-[2rem] mb-[0.6rem] block"></i><span>Buscando productos...</span></div>';
        panel.style.display      = 'block';
        panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function renderResultados(q, data) {
        srplabel.textContent = 'Resultados para "' + q + '"';

        if (!data || data.total === 0) {
            srpCount.style.display = 'none';
            srpBody.innerHTML = '<div class="text-center py-12 px-4">'
                + '<i class="fas fa-box-open text-[2.5rem] text-[#dee2e6] mb-3 block"></i>'
                + '<h5 class="text-[0.95rem] font-bold text-[#374151] mb-1">Sin resultados</h5>'
                + '<p class="text-[0.85rem] text-[#9CA3AF] m-0">No encontramos productos para <strong>"' + q + '"</strong>.</p>'
                + '</div>';
            return;
        }

        srpCount.textContent   = data.total + ' producto' + (data.total !== 1 ? 's' : '');
        srpCount.style.display = '';

        let html = '<div class="grid grid-cols-4 gap-4 max-[1199px]:grid-cols-3 max-[767px]:grid-cols-2 max-[479px]:grid-cols-1">';
        data.resultados.forEach(function (p) {
            const imgHtml = p.imagen_url
                ? '<img src="' + BURL + p.imagen_url + '" alt="' + escHtml(p.nombre) + '" loading="lazy" class="w-full h-full object-cover" onerror="this.parentElement.innerHTML=\'<i class=\\\'fas fa-box\\\'></i>\'">'
                : '<i class="' + escHtml(p.icono || 'fas fa-box') + '"></i>';

            const waUrl = 'https://wa.me/5493704616482?text=' + encodeURIComponent('Hola! Quiero consultar por ' + p.nombre);

            html += '<div class="cat-srp-card group bg-white rounded-[14px] border-[1.5px] border-[#f0f0f0] shadow-[0_2px_10px_rgba(0,0,0,0.06)] overflow-hidden cursor-pointer transition-all duration-[220ms] flex flex-col hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,0,0,0.11)]" '
                + 'data-nombre="' + escAttr(p.nombre) + '" '
                + 'data-precio="' + escAttr(p.precio || 'Consultar precio') + '" '
                + 'data-descripcion="' + escAttr(p.descripcion || '') + '" '
                + 'data-badge="' + escAttr(p.badge || '') + '" '
                + 'data-icono="' + escAttr(p.icono || 'fas fa-box') + '" '
                + 'data-imagen="' + escAttr(p.imagen_url ? BURL + p.imagen_url : '') + '" '
                + 'data-imagenes="[]" '
                + 'data-categoria="' + escAttr(p.categoria || '') + '" '
                + 'data-wa="' + escAttr(waUrl) + '">'
                + '<div class="h-[130px] bg-[#1a232e] flex items-center justify-center relative overflow-hidden flex-shrink-0 [&>i]:text-white/20 [&>i]:text-[2.2rem]">' + imgHtml
                + (p.badge ? '<span class="absolute top-2 right-2 bg-rojo text-white text-[0.65rem] font-bold px-2 py-[2px] rounded-full tracking-[0.3px]">' + escHtml(p.badge) + '</span>' : '')
                + '<div class="absolute inset-0 bg-black/45 flex items-center justify-center opacity-0 transition-opacity duration-200 group-hover:opacity-100"><i class="fas fa-expand-alt text-white text-[1.4rem]"></i></div>'
                + '</div>'
                + '<div class="px-4 pt-[0.9rem] pb-4 flex-1 flex flex-col">'
                + (p.marca ? '<div class="text-[0.68rem] font-bold text-rojo/70 uppercase tracking-[0.5px] mb-[0.15rem]">' + escHtml(p.marca) + '</div>' : '')
                + '<div class="font-bold text-[#111827] text-[0.88rem] leading-[1.35] mb-1 line-clamp-2">' + escHtml(p.nombre) + '</div>'
                + (p.categoria ? '<div class="text-[0.72rem] text-[#9CA3AF] mb-auto pb-[0.6rem]">' + escHtml(p.categoria) + '</div>' : '')
                + '<div class="flex items-center justify-between gap-[6px] mt-[0.6rem] flex-wrap">'
                + '<span class="font-bold text-[#374151] text-[0.82rem]">' + escHtml(p.precio || 'Consultar precio') + '</span>'
                + '<a href="' + waUrl + '" target="_blank" rel="noopener" class="cat-srp-wa inline-flex items-center gap-1 bg-[#25D366] text-white px-3 py-[0.3rem] rounded-full font-bold text-[0.72rem] no-underline transition-colors duration-200 whitespace-nowrap hover:bg-[#1ebe5a]" onclick="event.stopPropagation()">'
                + '<i class="fab fa-whatsapp"></i> Consultar'
                + '</a>'
                + '</div>'
                + '</div>'
                + '</div>';
        });
        html += '</div>';
        srpBody.innerHTML = html;

        // Vincular click → modal
        srpBody.querySelectorAll('.cat-srp-card').forEach(function (card) {
            card.addEventListener('click', function (e) {
                if (e.target.closest('.cat-srp-wa')) return;
                if (typeof window.mpAbrir === 'function') {
                    window.mpAbrir({
                        nombre:      card.dataset.nombre      || '',
                        precio:      card.dataset.precio      || 'Consultar precio',
                        descripcion: card.dataset.descripcion || '',
                        badge:       card.dataset.badge       || '',
                        icono:       card.dataset.icono       || 'fas fa-box',
                        imagen:      card.dataset.imagen      || '',
                        imagenes:    [],
                        categoria:   card.dataset.categoria   || '',
                    });
                }
            });
        });

        // También filtrar el grid local si existe (subrubro)
        if (gridInput) {
            gridInput.value = q;
            gridInput.dispatchEvent(new Event('input'));
        }
    }

    function buscar(q) {
        if (q.length < 2) {
            panel.style.display = 'none';
            if (gridInput) {
                gridInput.value = '';
                gridInput.dispatchEvent(new Event('input'));
            }
            return;
        }

        mostrarLoading(q);

        const params = new URLSearchParams({ q: q });
        if (RUBRO)  params.set('rubro', RUBRO);
        if (SUB)    params.set('sub', SUB);
        if (SUBSUB) params.set('subsub', SUBSUB);

        fetch(BASE + '?' + params.toString())
            .then(function (r) { return r.json(); })
            .then(function (data) { renderResultados(q, data); })
            .catch(function () {
                srpBody.innerHTML = '<div class="text-center py-12 px-4"><i class="fas fa-exclamation-triangle text-[#fca5a5] text-[2.5rem] mb-3 block"></i><h5 class="text-[0.95rem] font-bold text-[#374151] mb-1">Error</h5><p class="text-[0.85rem] text-[#9CA3AF] m-0">No se pudo completar la búsqueda.</p></div>';
            });
    }

    searchInput.addEventListener('input', function () {
        const q = this.value.trim();
        clearBtn.style.display = q ? 'block' : 'none';
        clearTimeout(timer);
        if (q === '') {
            cerrar();
            return;
        }
        timer = setTimeout(function () { buscar(q); }, 320);
    });

    clearBtn.addEventListener('click', cerrar);
    srpClose.addEventListener('click', cerrar);

    /* Helpers de escape */
    function escHtml(s) {
        return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }
    function escAttr(s) {
        return String(s).replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }
})();
</script>
