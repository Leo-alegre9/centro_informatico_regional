<!-- ═══════════════════════════════════════════════
     GRILLA DE PRODUCTOS
═══════════════════════════════════════════════ -->
<section class="bg-fondo py-12">
    <div class="container">

        <div class="flex items-end justify-between flex-wrap gap-4 mb-6">
            <div>
                <span class="section-eyebrow">Disponible en local</span>
                <h2 class="section-heading !mb-0">Productos disponibles</h2>
            </div>
            <a href="https://wa.me/5493704616482?text=Hola!%20Me%20interesa%20conocer%20los%20precios%20de%20<?= rawurlencode($current['nombre']) ?>"
               target="_blank" rel="noopener"
               class="btn-rojo whitespace-nowrap !text-[0.88rem] !py-[0.7rem] !px-[1.6rem]">
                <i class="fab fa-whatsapp"></i> Consultar por WhatsApp
            </a>
        </div>

        <!-- Barra de herramientas de filtrado -->
        <div class="bg-white rounded-[14px] border-[1.5px] border-[#e9ecef] px-5 py-[1.1rem] mb-6 flex flex-col gap-[0.85rem]">
            <!-- Fila 1: búsqueda + ordenamiento -->
            <div class="flex items-center gap-3 flex-wrap">
                <div class="relative flex-1 min-w-[180px] max-w-[400px] max-[575px]:max-w-full">
                    <i class="fas fa-search cat-search-icon absolute left-4 top-1/2 -translate-y-1/2 text-gris text-[0.9rem] pointer-events-none"></i>
                    <input type="text"
                           id="buscador-productos"
                           class="w-full py-[0.65rem] px-[2.6rem] rounded-full text-[0.9rem] text-dark bg-[#f9fafb] outline-none border-[1.5px] border-[#e5e7eb] transition-all duration-200 placeholder:text-[#adb5bd] focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.08)] focus:bg-white"
                           placeholder="Buscar por nombre, modelo...">
                    <button type="button" class="hidden absolute right-[0.9rem] top-1/2 -translate-y-1/2 bg-transparent border-none text-[#adb5bd] cursor-pointer text-[0.82rem] p-1 leading-none hover:text-rojo" id="clear-productos" title="Limpiar búsqueda">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <select id="cat-orden" class="py-[0.6rem] px-[0.9rem] border-[1.5px] border-[#e5e7eb] rounded-full text-[0.85rem] text-[#374151] bg-[#f9fafb] outline-none cursor-pointer transition-colors duration-200 whitespace-nowrap focus:border-rojo" title="Ordenar">
                    <option value="">Ordenar por...</option>
                    <option value="az">Nombre A → Z</option>
                    <option value="za">Nombre Z → A</option>
                </select>
            </div>

            <!-- Fila 2: chips de marca (generados por JS) -->
            <div class="hidden items-center gap-2 flex-wrap" id="marcas-filter-row">
                <span class="text-[0.73rem] font-bold text-[#9CA3AF] uppercase tracking-[0.6px] whitespace-nowrap shrink-0"><i class="fas fa-tag mr-1"></i>Marca</span>
                <div id="marcas-chips" class="flex flex-wrap gap-[0.4rem]"></div>
            </div>

            <!-- Fila 3: chips de etiqueta (generados por JS) -->
            <div class="hidden items-center gap-2 flex-wrap" id="badges-filter-row">
                <span class="text-[0.73rem] font-bold text-[#9CA3AF] uppercase tracking-[0.6px] whitespace-nowrap shrink-0"><i class="fas fa-star mr-1"></i>Etiqueta</span>
                <div id="badges-chips" class="flex flex-wrap gap-[0.4rem]"></div>
            </div>

            <!-- Fila de precio -->
            <div class="flex items-center gap-3 flex-wrap" id="precio-filter-row">
                <span class="text-[0.73rem] font-bold text-[#9CA3AF] uppercase tracking-[0.6px] whitespace-nowrap shrink-0"><i class="fas fa-dollar-sign mr-1"></i>Precio</span>
                <div class="flex items-center gap-2 flex-wrap">
                    <input type="number" id="precio-min" class="py-[0.45rem] px-[0.7rem] border-[1.5px] border-[#e5e7eb] rounded-[9px] text-[0.85rem] text-[#374151] bg-[#f9fafb] w-[110px] outline-none transition-colors duration-200 focus:border-rojo" placeholder="Mínimo" min="0">
                    <span class="text-[#9CA3AF] text-[0.8rem]">—</span>
                    <input type="number" id="precio-max" class="py-[0.45rem] px-[0.7rem] border-[1.5px] border-[#e5e7eb] rounded-[9px] text-[0.85rem] text-[#374151] bg-[#f9fafb] w-[110px] outline-none transition-colors duration-200 focus:border-rojo" placeholder="Máximo" min="0">
                    <button type="button" id="precio-apply" class="cat-chip inline-flex items-center gap-[5px] px-3 py-[0.3rem] rounded-full text-[0.78rem] font-semibold cursor-pointer border-[1.5px] whitespace-nowrap bg-rojo border-rojo text-white">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <button type="button" id="precio-clear" class="hidden cat-chip items-center gap-[5px] px-3 py-[0.3rem] rounded-full text-[0.78rem] font-semibold cursor-pointer border-[1.5px] whitespace-nowrap border-[#e5e7eb] bg-white text-[#6B7280] transition-colors duration-[180ms] hover:border-rojo hover:text-rojo hover:bg-rojo/[0.04]">
                        <i class="fas fa-times"></i> Limpiar precio
                    </button>
                </div>
            </div>

            <!-- Info de resultados -->
            <div class="text-[0.82rem] text-gris min-h-[1.1em]" id="info-productos"></div>
        </div>

        <div class="grid grid-cols-3 gap-[1.3rem] max-[991px]:grid-cols-2 max-[575px]:grid-cols-1" id="productos-grid">
            <?php foreach ($current['productos'] as $producto): ?>
            <?php
                $imgUrl   = $producto['imagen_url'] ?? '';
                $imgJson  = isset($producto['imagenes'])
                    ? htmlspecialchars(json_encode($producto['imagenes'], JSON_UNESCAPED_UNICODE), ENT_QUOTES)
                    : '[]';
                $descFull = $producto['descripcion_full'] ?? $producto['descripcion'] ?? '';
                $marcaNombre = $producto['marca'] ?? '';
            ?>
            <div class="producto-card bg-white rounded-2xl overflow-hidden flex flex-col shadow-[0_3px_16px_rgba(0,0,0,0.07)] border-[1.5px] border-[#f0f0f0] transition-all duration-[280ms] ease-out cursor-pointer hover:-translate-y-[5px] hover:shadow-[0_16px_45px_rgba(0,0,0,0.13)]"
                 id="producto-<?= (int)$producto['id'] ?>"
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
                <div class="bg-dark-2 p-[2.2rem_2rem] flex items-center justify-center min-h-[160px] relative overflow-hidden">
                    <?php if (!empty($producto['imagen_url'])): ?>
                    <img src="<?= base_url(esc($producto['imagen_url'])) ?>"
                         alt="<?= esc($producto['nombre']) ?>"
                         class="absolute top-0 left-0 w-full h-full object-cover">
                    <?php else: ?>
                    <i class="<?= esc($producto['icono']) ?> text-white/[0.22] text-[3rem]"></i>
                    <?php endif; ?>
                    <?php if (!empty($producto['badge'])): ?>
                    <span class="absolute top-[11px] right-[11px] bg-rojo text-white text-[0.7rem] font-bold px-[10px] py-1 rounded-full tracking-[0.4px] whitespace-nowrap"><?= esc($producto['badge']) ?></span>
                    <?php endif; ?>
                </div>
                <div class="px-[1.4rem] pt-[1.35rem] pb-[1.4rem] flex-1 flex flex-col">
                    <?php if (!empty($marcaNombre)): ?>
                    <div class="text-[0.72rem] font-bold text-rojo/65 uppercase tracking-[0.5px] mb-[0.2rem]"><?= esc($marcaNombre) ?></div>
                    <?php endif; ?>
                    <div class="font-extrabold text-dark-2 text-[0.97rem] mb-[0.45rem] leading-[1.4]"><?= esc($producto['nombre']) ?></div>
                    <div class="text-gris text-[0.84rem] leading-[1.6] flex-1 mb-[1.15rem]"><?= esc($producto['descripcion']) ?></div>
                    <div class="flex items-center justify-between gap-2 flex-wrap">
                        <span class="font-bold text-gris text-[0.85rem]"><?= esc($producto['precio']) ?></span>
                        <a href="https://wa.me/5493704616482?text=Hola!%20Quiero%20consultar%20por%20<?= rawurlencode($producto['nombre']) ?>"
                           target="_blank" rel="noopener"
                           class="inline-flex items-center gap-[6px] bg-[#25D366] text-white px-[1.1rem] py-[0.48rem] rounded-full font-bold text-[0.8rem] no-underline transition-colors duration-200 whitespace-nowrap hover:bg-[#1ebe5a] hover:text-white"
                           onclick="event.stopPropagation();">
                            <i class="fab fa-whatsapp"></i> Consultar
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <div class="hidden text-center py-12 px-4 col-span-full" id="sin-resultados-productos">
                <i class="fas fa-box-open text-[2.5rem] text-[#dee2e6] mb-4 block"></i>
                <p class="text-gris text-[0.95rem] m-0">No se encontraron productos para <strong class="text-rojo" id="termino-productos"></strong></p>
            </div>
        </div>

        <div class="text-center mt-14 p-6 border-t border-[#e5e7eb]">
            <p class="text-gris text-[0.95rem] m-0">¿No encontrás lo que buscás? <a href="<?= base_url('contacto') ?>" class="text-rojo font-semibold no-underline hover:underline">Contactanos</a> y lo conseguimos para vos.</p>
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

    const CHIP_BASE     = ['cat-chip', 'inline-flex', 'items-center', 'gap-[5px]', 'px-3', 'py-[0.3rem]', 'rounded-full', 'text-[0.78rem]', 'font-semibold', 'cursor-pointer', 'border-[1.5px]', 'transition-colors', 'duration-[180ms]', 'select-none', 'whitespace-nowrap'];
    const CHIP_INACTIVE = ['border-[#e5e7eb]', 'bg-white', 'text-[#6B7280]', 'hover:border-rojo', 'hover:text-rojo', 'hover:bg-rojo/[0.04]'];
    const CHIP_ACTIVE   = ['bg-rojo', 'border-rojo', 'text-white'];

    function setChipEstado(chip, activo) {
        chip.classList.remove.apply(chip.classList, CHIP_INACTIVE.concat(CHIP_ACTIVE));
        chip.classList.add.apply(chip.classList, CHIP_BASE.concat(activo ? CHIP_ACTIVE : CHIP_INACTIVE));
        const icon = chip.querySelector('i');
        if (icon) icon.classList.toggle('opacity-[0.85]', activo);
    }

    /* ── Generar chips de marca ── */
    (function generarMarcas() {
        const marcas = new Set();
        grid.querySelectorAll('.producto-card').forEach(function (c) {
            if (c.dataset.marca) marcas.add(c.dataset.marca);
        });
        if (marcas.size === 0) return;

        const row    = document.getElementById('marcas-filter-row');
        const wrap   = document.getElementById('marcas-chips');
        row.classList.remove('hidden');
        row.classList.add('flex');
        marcas.forEach(function (m) {
            const chip = document.createElement('button');
            chip.type = 'button';
            chip.dataset.valor = m;
            chip.innerHTML = '<i class="fas fa-tag"></i> ' + m;
            setChipEstado(chip, false);
            chip.addEventListener('click', function () {
                activaMarca = activaMarca === m ? '' : m;
                wrap.querySelectorAll('.cat-chip').forEach(function (c) {
                    setChipEstado(c, c.dataset.valor === activaMarca);
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
        row.classList.remove('hidden');
        row.classList.add('flex');
        badges.forEach(function (b) {
            const chip = document.createElement('button');
            chip.type = 'button';
            chip.dataset.valor = b;
            chip.innerHTML = '<i class="fas fa-star"></i> ' + b;
            setChipEstado(chip, false);
            chip.addEventListener('click', function () {
                activaBadge = activaBadge === b ? '' : b;
                wrap.querySelectorAll('.cat-chip').forEach(function (c) {
                    setChipEstado(c, c.dataset.valor === activaBadge);
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
            card.classList.toggle('hidden', !match);
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

/* ── Resaltar producto si se llega desde búsqueda (#producto-X) ── */
(function () {
    var hash = window.location.hash;
    if (!hash || !/^#producto-\d+$/.test(hash)) return;
    var card = document.querySelector(hash);
    if (!card) return;
    card.scrollIntoView({ behavior: 'smooth', block: 'center' });
    card.style.transition = 'box-shadow 0.4s ease, outline 0.4s ease';
    card.style.outline = '3px solid #FF0033';
    card.style.outlineOffset = '3px';
    setTimeout(function () {
        card.style.outline = '';
        card.style.outlineOffset = '';
    }, 2800);
})();
</script>
