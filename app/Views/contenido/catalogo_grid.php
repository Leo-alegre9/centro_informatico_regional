<style>
    .catalogo-section { background: var(--fondo); }
    .catalogo-section-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .productos-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.3rem;
    }
    .producto-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: 0 3px 16px rgba(0,0,0,0.07);
        border: 1.5px solid #f0f0f0;
        transition: transform 0.28s ease, box-shadow 0.28s ease;
        cursor: pointer;
    }
    .producto-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 45px rgba(0,0,0,0.13);
    }
    .prod-ver-detalle {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.25s ease;
        color: #fff;
        font-size: 1.6rem;
    }
    .producto-card:hover .prod-ver-detalle { opacity: 1; }
    .producto-card.oculto { display: none; }
    .producto-icon-wrap {
        background: var(--dark-2);
        padding: 2.2rem 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 160px;
        position: relative;
        overflow: hidden;
    }
    .producto-icon-wrap i {
        color: rgba(255,255,255,0.22);
        font-size: 3rem;
    }
    .producto-img {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        object-fit: cover;
    }
    .producto-badge {
        position: absolute;
        top: 11px;
        right: 11px;
        background: var(--rojo);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 50px;
        letter-spacing: 0.4px;
        white-space: nowrap;
    }
    .producto-body {
        padding: 1.35rem 1.4rem 1.4rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .producto-marca {
        font-size: 0.72rem;
        font-weight: 700;
        color: rgba(255,0,51,0.65);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.2rem;
    }
    .producto-name {
        font-weight: 800;
        color: var(--dark-2);
        font-size: 0.97rem;
        margin-bottom: 0.45rem;
        line-height: 1.4;
    }
    .producto-desc {
        color: var(--gris);
        font-size: 0.84rem;
        line-height: 1.6;
        flex: 1;
        margin-bottom: 1.15rem;
    }
    .producto-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        flex-wrap: wrap;
    }
    .producto-precio {
        font-weight: 700;
        color: var(--gris);
        font-size: 0.85rem;
    }
    .btn-consultar {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #25D366;
        color: #fff;
        padding: 0.48rem 1.1rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.8rem;
        text-decoration: none;
        transition: background 0.2s;
        white-space: nowrap;
    }
    .btn-consultar:hover { background: #1ebe5a; color: #fff; }

    /* ── Barra de herramientas ── */
    .cat-toolbar {
        background: #fff;
        border-radius: 14px;
        border: 1.5px solid #e9ecef;
        padding: 1.1rem 1.25rem;
        margin-bottom: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
    }
    .cat-toolbar-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    .cat-buscador-wrap {
        position: relative;
        flex: 1;
        min-width: 180px;
        max-width: 400px;
    }
    .cat-buscador-wrap .cat-search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gris);
        font-size: 0.9rem;
        pointer-events: none;
    }
    .cat-buscador {
        width: 100%;
        padding: 0.65rem 2.6rem 0.65rem 2.6rem;
        border: 1.5px solid #e5e7eb;
        border-radius: 50px;
        font-size: 0.9rem;
        color: var(--dark);
        background: #f9fafb;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    }
    .cat-buscador:focus {
        border-color: var(--rojo);
        box-shadow: 0 0 0 3px rgba(255,0,51,0.08);
        background: #fff;
    }
    .cat-buscador::placeholder { color: #adb5bd; }
    .cat-clear-btn {
        position: absolute;
        right: 0.9rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #adb5bd;
        cursor: pointer;
        font-size: 0.82rem;
        padding: 4px;
        line-height: 1;
        display: none;
    }
    .cat-clear-btn:hover { color: var(--rojo); }

    .cat-sort-select {
        padding: 0.6rem 0.9rem;
        border: 1.5px solid #e5e7eb;
        border-radius: 50px;
        font-size: 0.85rem;
        color: #374151;
        background: #f9fafb;
        outline: none;
        cursor: pointer;
        transition: border-color 0.2s;
        white-space: nowrap;
    }
    .cat-sort-select:focus { border-color: var(--rojo); }

    /* ── Chips de filtro ── */
    .cat-filter-row {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .cat-filter-label {
        font-size: 0.73rem;
        font-weight: 700;
        color: #9CA3AF;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .cat-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.3rem 0.75rem;
        border-radius: 50px;
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        border: 1.5px solid #e5e7eb;
        background: #fff;
        color: #6B7280;
        transition: border-color 0.18s, background 0.18s, color 0.18s;
        user-select: none;
        white-space: nowrap;
    }
    .cat-chip:hover {
        border-color: var(--rojo);
        color: var(--rojo);
        background: rgba(255,0,51,0.04);
    }
    .cat-chip.activo {
        background: var(--rojo);
        border-color: var(--rojo);
        color: #fff;
    }
    .cat-chip.activo i { opacity: 0.85; }

    .cat-precio-input {
        padding: 0.45rem 0.7rem;
        border: 1.5px solid #e5e7eb;
        border-radius: 9px;
        font-size: 0.85rem;
        color: #374151;
        background: #f9fafb;
        width: 110px;
        outline: none;
        transition: border-color 0.2s;
    }
    .cat-precio-input:focus { border-color: #FF0033; }

    .cat-resultados-info {
        font-size: 0.82rem;
        color: var(--gris);
        min-height: 1.1em;
    }
    .cat-sin-resultados-prod {
        display: none;
        text-align: center;
        padding: 3rem 1rem;
        grid-column: 1 / -1;
    }
    .cat-sin-resultados-prod i { font-size: 2.5rem; color: #dee2e6; margin-bottom: 1rem; display: block; }
    .cat-sin-resultados-prod p { color: var(--gris); font-size: 0.95rem; margin: 0; }
    .cat-sin-resultados-prod strong { color: var(--rojo); }
    .catalogo-empty-note {
        text-align: center;
        margin-top: 3.5rem;
        padding: 1.5rem;
        border-top: 1px solid #e5e7eb;
    }
    .catalogo-empty-note p { color: var(--gris); font-size: 0.95rem; margin: 0; }
    .catalogo-empty-note a { color: var(--rojo); font-weight: 600; text-decoration: none; }
    .catalogo-empty-note a:hover { text-decoration: underline; }

    @media (max-width: 991px) { .productos-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 575px)  { .productos-grid { grid-template-columns: 1fr; } }
    @media (max-width: 575px)  { .cat-buscador-wrap { max-width: 100%; } }
</style>

<!-- ═══════════════════════════════════════════════
     GRILLA DE PRODUCTOS
═══════════════════════════════════════════════ -->
<section class="catalogo-section py-5">
    <div class="container">

        <div class="catalogo-section-header">
            <div>
                <span class="section-eyebrow">Disponible en local</span>
                <h2 class="section-heading mb-0">Productos disponibles</h2>
            </div>
            <a href="https://wa.me/5493704616482?text=Hola!%20Me%20interesa%20conocer%20los%20precios%20de%20<?= rawurlencode($current['nombre']) ?>"
               target="_blank" rel="noopener"
               class="btn-rojo" style="font-size:0.88rem; padding:0.7rem 1.6rem; white-space:nowrap;">
                <i class="fab fa-whatsapp"></i> Consultar por WhatsApp
            </a>
        </div>

        <!-- Barra de herramientas de filtrado -->
        <div class="cat-toolbar">
            <!-- Fila 1: búsqueda + ordenamiento -->
            <div class="cat-toolbar-row">
                <div class="cat-buscador-wrap">
                    <i class="fas fa-search cat-search-icon"></i>
                    <input type="text"
                           id="buscador-productos"
                           class="cat-buscador"
                           placeholder="Buscar por nombre, modelo...">
                    <button type="button" class="cat-clear-btn" id="clear-productos" title="Limpiar búsqueda">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <select id="cat-orden" class="cat-sort-select" title="Ordenar">
                    <option value="">Ordenar por...</option>
                    <option value="az">Nombre A → Z</option>
                    <option value="za">Nombre Z → A</option>
                </select>
            </div>

            <!-- Fila 2: chips de marca (generados por JS) -->
            <div class="cat-filter-row" id="marcas-filter-row" style="display:none;">
                <span class="cat-filter-label"><i class="fas fa-tag me-1"></i>Marca</span>
                <div id="marcas-chips" style="display:flex;flex-wrap:wrap;gap:0.4rem;"></div>
            </div>

            <!-- Fila 3: chips de etiqueta (generados por JS) -->
            <div class="cat-filter-row" id="badges-filter-row" style="display:none;">
                <span class="cat-filter-label"><i class="fas fa-star me-1"></i>Etiqueta</span>
                <div id="badges-chips" style="display:flex;flex-wrap:wrap;gap:0.4rem;"></div>
            </div>

            <!-- Fila de precio -->
            <div class="cat-toolbar-row" id="precio-filter-row">
                <span class="cat-filter-label"><i class="fas fa-dollar-sign me-1"></i>Precio</span>
                <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;">
                    <input type="number" id="precio-min" class="cat-precio-input" placeholder="Mínimo" min="0">
                    <span style="color:#9CA3AF;font-size:0.8rem;">—</span>
                    <input type="number" id="precio-max" class="cat-precio-input" placeholder="Máximo" min="0">
                    <button type="button" id="precio-apply" class="cat-chip" style="background:#FF0033;color:#fff;border-color:#FF0033;">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <button type="button" id="precio-clear" class="cat-chip" style="display:none;">
                        <i class="fas fa-times"></i> Limpiar precio
                    </button>
                </div>
            </div>

            <!-- Info de resultados -->
            <div class="cat-resultados-info" id="info-productos"></div>
        </div>

        <div class="productos-grid" id="productos-grid">
            <?php foreach ($current['productos'] as $producto): ?>
            <?php
                $imgUrl   = $producto['imagen_url'] ?? '';
                $imgJson  = isset($producto['imagenes'])
                    ? htmlspecialchars(json_encode($producto['imagenes'], JSON_UNESCAPED_UNICODE), ENT_QUOTES)
                    : '[]';
                $descFull = $producto['descripcion_full'] ?? $producto['descripcion'] ?? '';
                $marcaNombre = $producto['marca'] ?? '';
            ?>
            <div class="producto-card"
                 data-busqueda="<?= esc(strtolower($producto['nombre'] . ' ' . $producto['descripcion'] . ' ' . $producto['badge'] . ' ' . $marcaNombre)) ?>"
                 data-nombre="<?= esc($producto['nombre']) ?>"
                 data-precio="<?= esc($producto['precio']) ?>"
                 data-precio-num="<?= esc($producto['precio_num'] ?? '') ?>"
                 data-descripcion="<?= esc($descFull) ?>"
                 data-badge="<?= esc($producto['badge'] ?? '') ?>"
                 data-marca="<?= esc($marcaNombre) ?>"
                 data-icono="<?= esc($producto['icono'] ?? 'fas fa-box') ?>"
                 data-imagen="<?= esc($imgUrl) ?>"
                 data-imagenes="<?= $imgJson ?>"
                 data-categoria="<?= esc($current['nombre'] ?? '') ?>">
                <div class="producto-icon-wrap">
                    <?php if (!empty($producto['imagen_url'])): ?>
                    <img src="<?= base_url(esc($producto['imagen_url'])) ?>"
                         alt="<?= esc($producto['nombre']) ?>"
                         class="producto-img">
                    <?php else: ?>
                    <i class="<?= esc($producto['icono']) ?>"></i>
                    <?php endif; ?>
                    <?php if (!empty($producto['badge'])): ?>
                    <span class="producto-badge"><?= esc($producto['badge']) ?></span>
                    <?php endif; ?>
                    <div class="prod-ver-detalle"><i class="fas fa-expand-alt"></i></div>
                </div>
                <div class="producto-body">
                    <?php if (!empty($marcaNombre)): ?>
                    <div class="producto-marca"><?= esc($marcaNombre) ?></div>
                    <?php endif; ?>
                    <div class="producto-name"><?= esc($producto['nombre']) ?></div>
                    <div class="producto-desc"><?= esc($producto['descripcion']) ?></div>
                    <div class="producto-footer">
                        <span class="producto-precio"><?= esc($producto['precio']) ?></span>
                        <a href="https://wa.me/5493704616482?text=Hola!%20Quiero%20consultar%20por%20<?= rawurlencode($producto['nombre']) ?>"
                           target="_blank" rel="noopener"
                           class="btn-consultar"
                           onclick="event.stopPropagation();">
                            <i class="fab fa-whatsapp"></i> Consultar
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <div class="cat-sin-resultados-prod" id="sin-resultados-productos">
                <i class="fas fa-box-open"></i>
                <p>No se encontraron productos para <strong id="termino-productos"></strong></p>
            </div>
        </div>

        <div class="catalogo-empty-note">
            <p>¿No encontrás lo que buscás? <a href="<?= base_url('contacto') ?>">Contactanos</a> y lo conseguimos para vos.</p>
        </div>

    </div>
</section>

<script>
(function () {
    const input    = document.getElementById('buscador-productos');
    const clearBtn = document.getElementById('clear-productos');
    const ordenSel = document.getElementById('cat-orden');
    const grid     = document.getElementById('productos-grid');
    const noRes    = document.getElementById('sin-resultados-productos');
    const termSpan = document.getElementById('termino-productos');
    const infoEl   = document.getElementById('info-productos');
    const total    = grid.querySelectorAll('.producto-card').length;

    let activaMarca = '';
    let activaBadge = '';
    let activePrecioMin = 0;
    let activePrecioMax = 0;
    let precioFiltroActivo = false;

    /* ── Generar chips de marca ── */
    (function generarMarcas() {
        const marcas = new Set();
        grid.querySelectorAll('.producto-card').forEach(function (c) {
            if (c.dataset.marca) marcas.add(c.dataset.marca);
        });
        if (marcas.size === 0) return;

        const row    = document.getElementById('marcas-filter-row');
        const wrap   = document.getElementById('marcas-chips');
        row.style.display = '';
        marcas.forEach(function (m) {
            const chip = document.createElement('button');
            chip.type = 'button';
            chip.className = 'cat-chip';
            chip.dataset.valor = m;
            chip.innerHTML = '<i class="fas fa-tag"></i> ' + m;
            chip.addEventListener('click', function () {
                activaMarca = activaMarca === m ? '' : m;
                wrap.querySelectorAll('.cat-chip').forEach(function (c) {
                    c.classList.toggle('activo', c.dataset.valor === activaMarca);
                });
                filtrar();
            });
            wrap.appendChild(chip);
        });
    })();

    /* ── Generar chips de badge ── */
    (function generarBadges() {
        const badges = new Set();
        grid.querySelectorAll('.producto-card').forEach(function (c) {
            if (c.dataset.badge) badges.add(c.dataset.badge);
        });
        if (badges.size === 0) return;

        const row  = document.getElementById('badges-filter-row');
        const wrap = document.getElementById('badges-chips');
        row.style.display = '';
        badges.forEach(function (b) {
            const chip = document.createElement('button');
            chip.type = 'button';
            chip.className = 'cat-chip';
            chip.dataset.valor = b;
            chip.innerHTML = '<i class="fas fa-star"></i> ' + b;
            chip.addEventListener('click', function () {
                activaBadge = activaBadge === b ? '' : b;
                wrap.querySelectorAll('.cat-chip').forEach(function (c) {
                    c.classList.toggle('activo', c.dataset.valor === activaBadge);
                });
                filtrar();
            });
            wrap.appendChild(chip);
        });
    })();

    /* ── Ordenamiento ── */
    function ordenarCards() {
        const orden = ordenSel.value;
        if (!orden) return;
        const cards = Array.from(grid.querySelectorAll('.producto-card'));
        cards.sort(function (a, b) {
            const na = a.dataset.nombre.toLowerCase();
            const nb = b.dataset.nombre.toLowerCase();
            return orden === 'az' ? na.localeCompare(nb, 'es') : nb.localeCompare(na, 'es');
        });
        cards.forEach(function (c) { grid.appendChild(c); });
        grid.appendChild(noRes);
    }

    /* ── Filtrar ── */
    function filtrar() {
        const q = input.value.trim().toLowerCase();
        clearBtn.style.display = q ? 'block' : 'none';

        const cards = grid.querySelectorAll('.producto-card');
        let visible = 0;

        cards.forEach(function (card) {
            const matchQ     = !q || card.dataset.busqueda.includes(q);
            const matchMarca = !activaMarca || card.dataset.marca === activaMarca;
            const matchBadge = !activaBadge || card.dataset.badge === activaBadge;

            let matchPrecio = true;
            if (precioFiltroActivo) {
                const precioNum = parseFloat(card.dataset.precioNum);
                if (!isNaN(precioNum) && precioNum > 0) {
                    if (activePrecioMin > 0 && precioNum < activePrecioMin) matchPrecio = false;
                    if (activePrecioMax > 0 && precioNum > activePrecioMax) matchPrecio = false;
                }
                // Products with no numeric price (Consultar) always show through
            }

            const match = matchQ && matchMarca && matchBadge && matchPrecio;
            card.classList.toggle('oculto', !match);
            if (match) visible++;
        });

        noRes.style.display = visible === 0 ? 'block' : 'none';
        termSpan.textContent = '"' + input.value.trim() + '"';

        const partes = [];
        if (q) partes.push(visible + ' de ' + total + ' productos');
        if (activaMarca) partes.push('marca: ' + activaMarca);
        if (activaBadge) partes.push('etiqueta: ' + activaBadge);
        if (precioFiltroActivo) {
            var rango = [];
            if (activePrecioMin > 0) rango.push('desde $' + activePrecioMin.toLocaleString('es'));
            if (activePrecioMax > 0) rango.push('hasta $' + activePrecioMax.toLocaleString('es'));
            if (rango.length) partes.push('precio: ' + rango.join(' '));
        }
        infoEl.textContent = partes.length ? partes.join(' · ') : '';
    }

    input.addEventListener('input', filtrar);
    clearBtn.addEventListener('click', function () {
        input.value = '';
        filtrar();
        input.focus();
    });
    ordenSel.addEventListener('change', ordenarCards);

    /* ── Price filter ── */
    const precioMinInput  = document.getElementById('precio-min');
    const precioMaxInput  = document.getElementById('precio-max');
    const precioApplyBtn  = document.getElementById('precio-apply');
    const precioClearBtn  = document.getElementById('precio-clear');

    if (precioApplyBtn) {
        precioApplyBtn.addEventListener('click', function () {
            const minVal = parseFloat(precioMinInput.value) || 0;
            const maxVal = parseFloat(precioMaxInput.value) || 0;
            activePrecioMin = minVal;
            activePrecioMax = maxVal;
            precioFiltroActivo = (minVal > 0 || maxVal > 0);
            precioClearBtn.style.display = precioFiltroActivo ? 'inline-flex' : 'none';
            filtrar();
        });
    }

    if (precioClearBtn) {
        precioClearBtn.addEventListener('click', function () {
            precioMinInput.value = '';
            precioMaxInput.value = '';
            activePrecioMin = 0;
            activePrecioMax = 0;
            precioFiltroActivo = false;
            precioClearBtn.style.display = 'none';
            filtrar();
        });
    }

    if (precioMinInput && precioMaxInput) {
        [precioMinInput, precioMaxInput].forEach(function (inp) {
            inp.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') { precioApplyBtn && precioApplyBtn.click(); }
            });
        });
    }
})();
</script>
