<style>
    .catalogo-hero {
        background: linear-gradient(135deg, #070c1a 0%, var(--dark-2) 60%, #180a10 100%);
        padding: 3rem 0 2.5rem;
        position: relative;
        overflow: hidden;
    }
    .catalogo-hero-glow {
        position: absolute;
        width: 450px; height: 450px;
        background: radial-gradient(circle, rgba(255,0,51,0.11) 0%, transparent 70%);
        top: -120px; right: -80px;
        border-radius: 50%;
        pointer-events: none;
    }
    .breadcrumb-cir {
        display: flex; align-items: center; gap: 7px;
        font-size: 0.82rem; color: rgba(255,255,255,0.4);
        margin-bottom: 1.6rem; flex-wrap: wrap;
    }
    .breadcrumb-cir a { color: rgba(255,255,255,0.5); text-decoration: none; transition: color 0.2s; }
    .breadcrumb-cir a:hover { color: var(--rojo); }
    .breadcrumb-cir .sep { color: rgba(255,255,255,0.2); }
    .breadcrumb-cir .current { color: var(--rojo); font-weight: 600; }
    .catalogo-rubro-icon {
        width: 70px; height: 70px;
        background: rgba(255,0,51,0.1); border: 2px solid rgba(255,0,51,0.28);
        border-radius: 18px; display: flex; align-items: center;
        justify-content: center; font-size: 1.75rem; color: var(--rojo); margin-bottom: 1.1rem;
    }
    .catalogo-rubro-title {
        color: #fff; font-size: clamp(1.8rem, 3.5vw, 2.7rem);
        font-weight: 900; margin-bottom: 0.5rem; line-height: 1.15;
    }
    .catalogo-rubro-desc {
        color: rgba(255,255,255,0.58); font-size: 1rem;
        line-height: 1.75; max-width: 580px; margin-bottom: 0;
    }
    .rubros-nav { margin-top: 2.5rem; display: flex; gap: 0.55rem; flex-wrap: wrap; }
    .rubro-chip {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 13px; border-radius: 50px; font-size: 0.8rem; font-weight: 600;
        text-decoration: none; border: 1.5px solid rgba(255,255,255,0.13);
        color: rgba(255,255,255,0.6); transition: border-color 0.2s, color 0.2s, background 0.2s;
        white-space: nowrap;
    }
    .rubro-chip:hover { border-color: rgba(255,0,51,0.5); color: var(--rojo); background: rgba(255,0,51,0.05); }
    .rubro-chip.activo { background: var(--rojo); border-color: var(--rojo); color: #fff; }

    /* ── Barra de búsqueda del hero ── */
    .cat-hero-search-area { margin-top: 2rem; }
    .cat-hero-search-row {
        display: flex; align-items: center; gap: 0.6rem;
        max-width: 640px;
    }
    .cat-hero-search-wrap {
        position: relative; flex: 1;
    }
    .cat-hero-search-icon {
        position: absolute; left: 1.15rem; top: 50%; transform: translateY(-50%);
        color: rgba(255,255,255,0.45); font-size: 0.95rem; pointer-events: none; z-index: 2;
    }
    .cat-hero-search {
        width: 100%; padding: 0.9rem 3rem 0.9rem 3rem;
        border: 2px solid rgba(255,255,255,0.15); border-radius: 50px;
        font-size: 0.95rem; color: #fff; background: rgba(255,255,255,0.08);
        outline: none; transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
    }
    .cat-hero-search:focus {
        border-color: var(--rojo); background: rgba(255,255,255,0.12);
        box-shadow: 0 0 0 3px rgba(255,0,51,0.18);
    }
    .cat-hero-search::placeholder { color: rgba(255,255,255,0.35); }
    .cat-hero-search-clear {
        position: absolute; right: 1.1rem; top: 50%; transform: translateY(-50%);
        background: none; border: none; color: rgba(255,255,255,0.5);
        cursor: pointer; font-size: 0.9rem; padding: 4px; display: none; z-index: 2; line-height: 1;
    }
    .cat-hero-search-clear:hover { color: var(--rojo); }
    .cat-hero-search-hint {
        font-size: 0.78rem; color: rgba(255,255,255,0.3);
        margin-top: 0.55rem; margin-left: 0.2rem;
    }
    .cat-hero-search-hint strong { color: rgba(255,255,255,0.55); }
</style>

<!-- ═══════════════════════════════════════════════
     CATÁLOGO HEADER
═══════════════════════════════════════════════ -->
<div class="catalogo-hero">
    <div class="catalogo-hero-glow"></div>
    <div class="container position-relative" style="z-index:1;">

        <nav class="breadcrumb-cir" aria-label="breadcrumb">
            <?php foreach ($breadcrumb as $i => $crumb): ?>
                <?php if ($i > 0): ?><span class="sep">/</span><?php endif; ?>
                <?php if ($crumb['url'] !== null): ?>
                    <a href="<?= esc($crumb['url']) ?>"><?php if ($i === 0): ?><i class="fas fa-home"></i> <?php endif; ?><?= esc($crumb['nombre']) ?></a>
                <?php else: ?>
                    <span class="current"><?= esc($crumb['nombre']) ?></span>
                <?php endif; ?>
            <?php endforeach; ?>
        </nav>

        <div class="catalogo-rubro-icon">
            <i class="<?= esc($current['icono']) ?>"></i>
        </div>
        <h1 class="catalogo-rubro-title"><?= esc($current['nombre']) ?></h1>
        <p class="catalogo-rubro-desc"><?= esc($current['descripcion']) ?></p>

        <!-- Barra de búsqueda -->
        <div class="cat-hero-search-area">
            <div class="cat-hero-search-row">
                <div class="cat-hero-search-wrap">
                    <i class="fas fa-search cat-hero-search-icon"></i>
                    <input type="text"
                           id="cat-hero-search"
                           class="cat-hero-search"
                           placeholder="Buscar producto...">
                    <button type="button" class="cat-hero-search-clear" id="cat-hero-clear">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <?php
            $contextNombre = $current['nombre'] ?? 'el catálogo';
            ?>
            <div class="cat-hero-search-hint" id="cat-hero-hint">
                Buscá dentro de <strong><?= esc($contextNombre) ?></strong> — hacé clic en un resultado para ver los detalles
            </div>
        </div>

        <?php if (!empty($siblings)): ?>
        <nav class="rubros-nav" aria-label="Navegación de rubros">
            <?php foreach ($siblings as $key => $sibling): ?>
            <a href="<?= esc($sibling['url']) ?>"
               class="rubro-chip <?= $sibling['activo'] ? 'activo' : '' ?>">
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
<div id="cat-search-panel" style="display:none; background:#f4f6f9; border-bottom:2px solid #e5e7eb;">
<style>
    .cat-srp-wrap { padding: 2rem 0 2.5rem; }
    .cat-srp-header {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.5rem;
    }
    .cat-srp-title {
        font-size: 1rem; font-weight: 700; color: #111827;
        display: flex; align-items: center; gap: 0.5rem;
    }
    .cat-srp-count {
        background: rgba(255,0,51,0.1); color: #FF0033;
        font-size: 0.78rem; font-weight: 700;
        padding: 0.18rem 0.65rem; border-radius: 50px;
    }
    .cat-srp-close {
        display: inline-flex; align-items: center; gap: 5px;
        color: #6B7280; border: 1.5px solid #e5e7eb; background: #fff;
        padding: 0.4rem 0.9rem; border-radius: 50px;
        font-size: 0.82rem; font-weight: 600; cursor: pointer;
        transition: border-color 0.15s, color 0.15s;
    }
    .cat-srp-close:hover { border-color: #FF0033; color: #FF0033; }

    .cat-srp-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
    }
    .cat-srp-card {
        background: #fff; border-radius: 14px;
        border: 1.5px solid #f0f0f0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        overflow: hidden; cursor: pointer;
        transition: transform 0.22s ease, box-shadow 0.22s ease;
        display: flex; flex-direction: column;
    }
    .cat-srp-card:hover { transform: translateY(-4px); box-shadow: 0 10px 30px rgba(0,0,0,0.11); }
    .cat-srp-img {
        height: 130px; background: #1a232e;
        display: flex; align-items: center; justify-content: center;
        position: relative; overflow: hidden; flex-shrink: 0;
    }
    .cat-srp-img img { width: 100%; height: 100%; object-fit: cover; }
    .cat-srp-img i { color: rgba(255,255,255,0.2); font-size: 2.2rem; }
    .cat-srp-badge {
        position: absolute; top: 8px; right: 8px;
        background: #FF0033; color: #fff;
        font-size: 0.65rem; font-weight: 700;
        padding: 2px 8px; border-radius: 50px; letter-spacing: 0.3px;
    }
    .cat-srp-overlay {
        position: absolute; inset: 0; background: rgba(0,0,0,0.45);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: opacity 0.2s;
    }
    .cat-srp-card:hover .cat-srp-overlay { opacity: 1; }
    .cat-srp-overlay i { color: #fff; font-size: 1.4rem; }
    .cat-srp-body { padding: 0.9rem 1rem 1rem; flex: 1; display: flex; flex-direction: column; }
    .cat-srp-marca { font-size: 0.68rem; font-weight: 700; color: rgba(255,0,51,0.7); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.15rem; }
    .cat-srp-nombre { font-weight: 700; color: #111827; font-size: 0.88rem; line-height: 1.35; margin-bottom: 0.25rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .cat-srp-cat { font-size: 0.72rem; color: #9CA3AF; margin-bottom: auto; padding-bottom: 0.6rem; }
    .cat-srp-footer { display: flex; align-items: center; justify-content: space-between; gap: 6px; margin-top: 0.6rem; flex-wrap: wrap; }
    .cat-srp-precio { font-weight: 700; color: #374151; font-size: 0.82rem; }
    .cat-srp-wa {
        display: inline-flex; align-items: center; gap: 4px;
        background: #25D366; color: #fff;
        padding: 0.3rem 0.75rem; border-radius: 50px;
        font-weight: 700; font-size: 0.72rem; text-decoration: none;
        transition: background 0.2s; white-space: nowrap;
    }
    .cat-srp-wa:hover { background: #1ebe5a; color: #fff; }

    .cat-srp-loading { text-align: center; padding: 3rem 1rem; color: #9CA3AF; }
    .cat-srp-loading i { font-size: 2rem; margin-bottom: 0.6rem; display: block; animation: srpSpin 0.9s linear infinite; }
    @keyframes srpSpin { to { transform: rotate(360deg); } }

    .cat-srp-empty { text-align: center; padding: 3rem 1rem; }
    .cat-srp-empty i { font-size: 2.5rem; color: #dee2e6; margin-bottom: 0.75rem; display: block; }
    .cat-srp-empty h5 { font-size: 0.95rem; font-weight: 700; color: #374151; margin-bottom: 0.3rem; }
    .cat-srp-empty p { font-size: 0.85rem; color: #9CA3AF; margin: 0; }

    @media (max-width: 1199px) { .cat-srp-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 767px)  { .cat-srp-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 479px)  { .cat-srp-grid { grid-template-columns: 1fr; } }
</style>
    <div class="container cat-srp-wrap">
        <div class="cat-srp-header">
            <div class="cat-srp-title">
                <i class="fas fa-search" style="color:#FF0033;"></i>
                <span id="cat-srp-label">Resultados</span>
                <span class="cat-srp-count" id="cat-srp-count" style="display:none;"></span>
            </div>
            <button type="button" class="cat-srp-close" id="cat-srp-close">
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
        srpBody.innerHTML        = '<div class="cat-srp-loading"><i class="fas fa-spinner"></i><span>Buscando productos...</span></div>';
        panel.style.display      = 'block';
        panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function renderResultados(q, data) {
        srplabel.textContent = 'Resultados para "' + q + '"';

        if (!data || data.total === 0) {
            srpCount.style.display = 'none';
            srpBody.innerHTML = '<div class="cat-srp-empty">'
                + '<i class="fas fa-box-open"></i>'
                + '<h5>Sin resultados</h5>'
                + '<p>No encontramos productos para <strong>"' + q + '"</strong>.</p>'
                + '</div>';
            return;
        }

        srpCount.textContent   = data.total + ' producto' + (data.total !== 1 ? 's' : '');
        srpCount.style.display = '';

        let html = '<div class="cat-srp-grid">';
        data.resultados.forEach(function (p) {
            const imgHtml = p.imagen_url
                ? '<img src="' + BURL + p.imagen_url + '" alt="' + escHtml(p.nombre) + '" loading="lazy" onerror="this.parentElement.innerHTML=\'<i class=\\\'fas fa-box\\\'></i>\'">'
                : '<i class="' + escHtml(p.icono || 'fas fa-box') + '"></i>';

            const waUrl = 'https://wa.me/5493704616482?text=' + encodeURIComponent('Hola! Quiero consultar por ' + p.nombre);

            html += '<div class="cat-srp-card" '
                + 'data-nombre="' + escAttr(p.nombre) + '" '
                + 'data-precio="' + escAttr(p.precio || 'Consultar precio') + '" '
                + 'data-descripcion="' + escAttr(p.descripcion || '') + '" '
                + 'data-badge="' + escAttr(p.badge || '') + '" '
                + 'data-icono="' + escAttr(p.icono || 'fas fa-box') + '" '
                + 'data-imagen="' + escAttr(p.imagen_url ? BURL + p.imagen_url : '') + '" '
                + 'data-imagenes="[]" '
                + 'data-categoria="' + escAttr(p.categoria || '') + '" '
                + 'data-wa="' + escAttr(waUrl) + '">'
                + '<div class="cat-srp-img">' + imgHtml
                + (p.badge ? '<span class="cat-srp-badge">' + escHtml(p.badge) + '</span>' : '')
                + '<div class="cat-srp-overlay"><i class="fas fa-expand-alt"></i></div>'
                + '</div>'
                + '<div class="cat-srp-body">'
                + (p.marca ? '<div class="cat-srp-marca">' + escHtml(p.marca) + '</div>' : '')
                + '<div class="cat-srp-nombre">' + escHtml(p.nombre) + '</div>'
                + (p.categoria ? '<div class="cat-srp-cat">' + escHtml(p.categoria) + '</div>' : '')
                + '<div class="cat-srp-footer">'
                + '<span class="cat-srp-precio">' + escHtml(p.precio || 'Consultar precio') + '</span>'
                + '<a href="' + waUrl + '" target="_blank" rel="noopener" class="cat-srp-wa" onclick="event.stopPropagation()">'
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
                srpBody.innerHTML = '<div class="cat-srp-empty"><i class="fas fa-exclamation-triangle" style="color:#fca5a5;"></i><h5>Error</h5><p>No se pudo completar la búsqueda.</p></div>';
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
