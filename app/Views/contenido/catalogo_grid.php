<?php
    // Reutilizable en 3 contextos: hoja de subrubro ($current['productos']), rubro completo
    // y catálogo general (ambos vía $productosGrid). El filtrado es 100% client-side; los
    // chips de Rubro/Subrubro se ocultan solos cuando el contexto ya tiene un solo valor.
    $productosParaGrid = $productosGrid ?? $current['productos'] ?? [];
    $tituloGridTexto    = $tituloGrid ?? 'Productos disponibles';
    $subtituloGridTexto = $subtituloGrid ?? 'Disponible en local';
?>
<!-- ═══════════════════════════════════════════════
     GRILLA DE PRODUCTOS
═══════════════════════════════════════════════ -->
<section class="bg-fondo py-12">
    <div class="container">

        <div class="flex items-end justify-between flex-wrap gap-4 mb-6">
            <div>
                <span class="section-eyebrow"><?= esc($subtituloGridTexto) ?></span>
                <h2 class="section-heading !mb-0"><?= esc($tituloGridTexto) ?></h2>
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
                           placeholder="Buscar por código, nombre, marca...">
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

            <!-- Fila de chips de Rubro (solo aparece si hay más de un rubro en el listado, p. ej. catálogo general) -->
            <div class="hidden items-center gap-2 flex-wrap" id="rubro-filter-row">
                <span class="text-[0.73rem] font-bold text-[#9CA3AF] uppercase tracking-[0.6px] whitespace-nowrap shrink-0"><i class="fas fa-layer-group mr-1"></i>Rubro</span>
                <div id="rubro-chips" class="flex flex-wrap gap-[0.4rem]"></div>
            </div>

            <!-- Fila de chips de Subrubro (solo aparece si hay más de un subrubro en el listado) -->
            <div class="hidden items-center gap-2 flex-wrap" id="subrubro-filter-row">
                <span class="text-[0.73rem] font-bold text-[#9CA3AF] uppercase tracking-[0.6px] whitespace-nowrap shrink-0"><i class="fas fa-sitemap mr-1"></i>Subrubro</span>
                <div id="subrubro-chips" class="flex flex-wrap gap-[0.4rem]"></div>
            </div>

            <!-- Fila: chips de marca (generados por JS) -->
            <div class="hidden items-center gap-2 flex-wrap" id="marcas-filter-row">
                <span class="text-[0.73rem] font-bold text-[#9CA3AF] uppercase tracking-[0.6px] whitespace-nowrap shrink-0"><i class="fas fa-tag mr-1"></i>Marca</span>
                <div id="marcas-chips" class="flex flex-wrap gap-[0.4rem]"></div>
            </div>

            <!-- Fila: chips de fábrica (generados por JS) -->
            <div class="hidden items-center gap-2 flex-wrap" id="fabricas-filter-row">
                <span class="text-[0.73rem] font-bold text-[#9CA3AF] uppercase tracking-[0.6px] whitespace-nowrap shrink-0"><i class="fas fa-industry mr-1"></i>Fábrica</span>
                <div id="fabricas-chips" class="flex flex-wrap gap-[0.4rem]"></div>
            </div>

            <!-- Fila: chips de línea, dependen de la fábrica elegida (generados por JS) -->
            <div class="hidden items-center gap-2 flex-wrap" id="lineas-filter-row">
                <span class="text-[0.73rem] font-bold text-[#9CA3AF] uppercase tracking-[0.6px] whitespace-nowrap shrink-0"><i class="fas fa-stream mr-1"></i>Línea</span>
                <div id="lineas-chips" class="flex flex-wrap gap-[0.4rem]"></div>
            </div>

            <!-- Fila: chips de etiqueta (generados por JS) -->
            <div class="hidden items-center gap-2 flex-wrap" id="badges-filter-row">
                <span class="text-[0.73rem] font-bold text-[#9CA3AF] uppercase tracking-[0.6px] whitespace-nowrap shrink-0"><i class="fas fa-star mr-1"></i>Etiqueta</span>
                <div id="badges-chips" class="flex flex-wrap gap-[0.4rem]"></div>
            </div>

            <!-- Fila de precio: botones de rango (calculados según los precios cargados en esta sección) + rango manual -->
            <div class="hidden flex-col gap-[0.6rem]" id="precio-filter-row">
                <div class="flex items-center gap-2 flex-wrap" id="precio-chips-row">
                    <span class="text-[0.73rem] font-bold text-[#9CA3AF] uppercase tracking-[0.6px] whitespace-nowrap shrink-0"><i class="fas fa-dollar-sign mr-1"></i>Precio</span>
                    <div id="precio-chips" class="flex flex-wrap gap-[0.4rem]"></div>
                </div>
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-[0.73rem] font-bold text-[#9CA3AF] uppercase tracking-[0.6px] whitespace-nowrap shrink-0 invisible md:visible"><i class="fas fa-dollar-sign mr-1"></i>Precio</span>
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
            <div class="flex items-center justify-between gap-2 flex-wrap">
                <div class="text-[0.82rem] text-gris min-h-[1.1em]" id="info-productos"></div>
                <button type="button" id="limpiar-todo-productos" class="hidden inline-flex items-center gap-[5px] text-[0.78rem] font-semibold text-gris border-[1.5px] border-[#e5e7eb] bg-white px-3 py-[0.3rem] rounded-full cursor-pointer transition-colors duration-150 hover:border-rojo hover:text-rojo">
                    <i class="fas fa-times"></i> Limpiar filtros
                </button>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-[1.3rem] max-[991px]:grid-cols-2 max-[575px]:grid-cols-1" id="productos-grid">
            <?php foreach ($productosParaGrid as $producto): ?>
            <?php
                $marcaNombre    = $producto['marca'] ?? '';
                $fabricaNombre  = $producto['fabrica'] ?? '';
                $lineaNombre    = $producto['linea'] ?? '';
                $rubroNombre    = $producto['rubro'] ?? '';
                $subrubroNombre = $producto['subrubro'] ?? '';
                $categoriaLabel = $subrubroNombre !== '' ? $subrubroNombre : $rubroNombre;
                $urlProducto    = base_url('producto/' . ($producto['slug'] ?: $producto['id']));
            ?>
            <div class="producto-card relative bg-white rounded-2xl overflow-hidden flex flex-col shadow-[0_3px_16px_rgba(0,0,0,0.07)] border-[1.5px] border-[#f0f0f0] transition-all duration-[280ms] ease-out hover:-translate-y-[5px] hover:shadow-[0_16px_45px_rgba(0,0,0,0.13)]"
                 id="producto-<?= (int)$producto['id'] ?>"
                 data-busqueda="<?= esc(strtolower(($producto['codigo'] ?? '') . ' ' . $producto['nombre'] . ' ' . $producto['descripcion'] . ' ' . $producto['badge'] . ' ' . $marcaNombre . ' ' . $fabricaNombre . ' ' . $lineaNombre . ' ' . $rubroNombre . ' ' . $subrubroNombre)) ?>"
                 data-nombre="<?= esc($producto['nombre']) ?>"
                 data-precio="<?= esc($producto['precio']) ?>"
                 data-precio-num="<?= esc($producto['precio_num'] ?? '') ?>"
                 data-badge="<?= esc($producto['badge'] ?? '') ?>"
                 data-marca="<?= esc($marcaNombre) ?>"
                 data-fabrica="<?= esc($fabricaNombre) ?>"
                 data-linea="<?= esc($lineaNombre) ?>"
                 data-rubro="<?= esc($rubroNombre) ?>"
                 data-subrubro="<?= esc($subrubroNombre) ?>">
                <div class="bg-dark-2 flex items-center justify-center h-[180px] relative overflow-hidden">
                    <?php if (!empty($producto['imagen_url'])): ?>
                    <img src="<?= base_url(esc($producto['imagen_url'])) ?>"
                         alt="<?= esc($producto['nombre']) ?>"
                         loading="lazy"
                         class="absolute top-0 left-0 w-full h-full object-cover">
                    <?php else: ?>
                    <i class="<?= esc($producto['icono']) ?> text-white/[0.22] text-[3rem]"></i>
                    <?php endif; ?>
                    <?php if (!empty($producto['badge'])): ?>
                    <span class="absolute top-[11px] right-[11px] bg-rojo text-white text-[0.7rem] font-bold px-[10px] py-1 rounded-full tracking-[0.4px] whitespace-nowrap"><?= esc($producto['badge']) ?></span>
                    <?php endif; ?>
                    <?php if ($categoriaLabel !== ''): ?>
                    <span class="absolute bottom-2 left-2 bg-black/[0.55] text-white text-[0.65rem] font-semibold px-2 py-[3px] rounded-[4px] backdrop-blur-[4px] whitespace-nowrap max-w-[calc(100%-16px)] overflow-hidden text-ellipsis">
                        <i class="fas fa-folder mr-1 opacity-70"></i><?= esc($categoriaLabel) ?>
                    </span>
                    <?php endif; ?>
                </div>
                <div class="px-[1.4rem] pt-[1.35rem] pb-[1.4rem] flex-1 flex flex-col">
                    <?php if (!empty($marcaNombre)): ?>
                    <div class="text-[0.72rem] font-bold text-rojo/65 uppercase tracking-[0.5px] mb-[0.2rem]"><?= esc($marcaNombre) ?></div>
                    <?php endif; ?>
                    <h3 class="font-extrabold text-dark-2 text-[0.97rem] mb-[0.45rem] leading-[1.4]">
                        <a href="<?= esc($urlProducto) ?>" class="text-dark-2 no-underline hover:text-rojo transition-colors duration-150 after:absolute after:inset-0 after:content-['']"><?= esc($producto['nombre']) ?></a>
                    </h3>
                    <?php if (!empty($producto['descripcion'])): ?>
                    <div class="text-gris text-[0.84rem] leading-[1.6] flex-1 mb-[1.15rem] line-clamp-2"><?= esc($producto['descripcion']) ?></div>
                    <?php else: ?>
                    <div class="flex-1 mb-[1.15rem]"></div>
                    <?php endif; ?>
                    <div class="relative z-[2] flex items-center justify-between gap-2 flex-wrap">
                        <span class="font-bold text-gris text-[0.85rem]"><?= esc($producto['precio']) ?></span>
                        <div class="flex items-center gap-[0.5rem]">
                            <a href="<?= esc($urlProducto) ?>"
                               class="inline-flex items-center gap-[6px] border-[1.5px] border-rojo text-rojo px-[1rem] py-[0.46rem] rounded-full font-bold text-[0.8rem] no-underline transition-colors duration-200 whitespace-nowrap hover:bg-rojo hover:text-white">
                                Ver producto
                            </a>
                            <a href="https://wa.me/5493704616482?text=Hola!%20Quiero%20consultar%20por%20<?= rawurlencode($producto['nombre']) ?>"
                               target="_blank" rel="noopener"
                               class="inline-flex items-center gap-[6px] bg-[#25D366] text-white px-[0.85rem] py-[0.48rem] rounded-full font-bold text-[0.8rem] no-underline transition-colors duration-200 whitespace-nowrap hover:bg-[#1ebe5a] hover:text-white"
                               aria-label="Consultar por WhatsApp sobre <?= esc($producto['nombre']) ?>">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <div class="hidden text-center py-12 px-4 col-span-full" id="sin-resultados-productos">
                <i class="fas fa-box-open text-[2.5rem] text-[#dee2e6] mb-4 block"></i>
                <p class="text-gris text-[0.95rem] m-0">No se encontraron productos con los filtros seleccionados<span id="termino-productos-wrap"> para <strong class="text-rojo" id="termino-productos"></strong></span></p>
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
    const termWrap = document.getElementById('termino-productos-wrap');
    const termSpan = document.getElementById('termino-productos');
    const infoEl   = document.getElementById('info-productos');
    const limpiarBtn = document.getElementById('limpiar-todo-productos');
    const total    = grid.querySelectorAll('.producto-card').length;

    const ETIQUETAS = { rubro: 'rubro', subrubro: 'subrubro', marca: 'marca', fabrica: 'fábrica', linea: 'línea', badge: 'etiqueta' };

    const CHIP_BASE     = ['cat-chip', 'inline-flex', 'items-center', 'gap-[5px]', 'px-3', 'py-[0.3rem]', 'rounded-full', 'text-[0.78rem]', 'font-semibold', 'cursor-pointer', 'border-[1.5px]', 'transition-colors', 'duration-[180ms]', 'select-none', 'whitespace-nowrap'];
    const CHIP_INACTIVE = ['border-[#e5e7eb]', 'bg-white', 'text-[#6B7280]', 'hover:border-rojo', 'hover:text-rojo', 'hover:bg-rojo/[0.04]'];
    const CHIP_ACTIVE   = ['bg-rojo', 'border-rojo', 'text-white'];

    function setChipEstado(chip, activo) {
        chip.classList.remove.apply(chip.classList, CHIP_INACTIVE.concat(CHIP_ACTIVE));
        chip.classList.add.apply(chip.classList, CHIP_BASE.concat(activo ? CHIP_ACTIVE : CHIP_INACTIVE));
        const icon = chip.querySelector('i');
        if (icon) icon.classList.toggle('opacity-[0.85]', activo);
    }

    /* ── Dimensiones de filtro (chips), con dependencias entre ellas ──
       rubro → subrubro → {marca, fabrica} → linea; badge depende de rubro/subrubro.
       Un chip se oculta solo si su universo de valores tiene 0 o 1 opción (no aporta filtrar). */
    const dims = {};

    function registrarDimension(key, opts) {
        const row  = document.getElementById(opts.rowId);
        const wrap = document.getElementById(opts.wrapId);
        if (!row || !wrap) return;
        dims[key] = { activo: '', row: row, wrap: wrap, dataAttr: opts.dataAttr, icon: opts.icon, dependsOn: opts.dependsOn || [] };
    }

    registrarDimension('rubro',    { rowId: 'rubro-filter-row',    wrapId: 'rubro-chips',    dataAttr: 'rubro',    icon: 'fas fa-layer-group' });
    registrarDimension('subrubro', { rowId: 'subrubro-filter-row', wrapId: 'subrubro-chips', dataAttr: 'subrubro', icon: 'fas fa-sitemap',  dependsOn: ['rubro'] });
    registrarDimension('marca',    { rowId: 'marcas-filter-row',   wrapId: 'marcas-chips',   dataAttr: 'marca',    icon: 'fas fa-tag',      dependsOn: ['rubro', 'subrubro'] });
    registrarDimension('fabrica',  { rowId: 'fabricas-filter-row', wrapId: 'fabricas-chips', dataAttr: 'fabrica',  icon: 'fas fa-industry', dependsOn: ['rubro', 'subrubro'] });
    registrarDimension('linea',    { rowId: 'lineas-filter-row',   wrapId: 'lineas-chips',   dataAttr: 'linea',    icon: 'fas fa-stream',   dependsOn: ['rubro', 'subrubro', 'fabrica'] });
    registrarDimension('badge',    { rowId: 'badges-filter-row',   wrapId: 'badges-chips',   dataAttr: 'badge',    icon: 'fas fa-star',     dependsOn: ['rubro', 'subrubro'] });

    function valoresDisponibles(key) {
        const d = dims[key];
        const set = new Set();
        grid.querySelectorAll('.producto-card').forEach(function (c) {
            const v = c.dataset[d.dataAttr];
            if (!v) return;
            for (let i = 0; i < d.dependsOn.length; i++) {
                const p = dims[d.dependsOn[i]];
                if (p && p.activo && c.dataset[p.dataAttr] !== p.activo) return;
            }
            set.add(v);
        });
        return set;
    }

    function renderChips(key) {
        const d = dims[key];
        if (!d) return;
        d.wrap.innerHTML = '';
        const valores = Array.from(valoresDisponibles(key)).sort(function (a, b) { return a.localeCompare(b, 'es'); });

        if (valores.length <= 1) {
            d.activo = '';
            d.row.classList.add('hidden');
            d.row.classList.remove('flex');
            return;
        }

        d.row.classList.remove('hidden');
        d.row.classList.add('flex');
        valores.forEach(function (v) {
            const chip = document.createElement('button');
            chip.type = 'button';
            chip.dataset.valor = v;
            chip.innerHTML = '<i class="' + d.icon + '"></i> ' + v;
            setChipEstado(chip, v === d.activo);
            chip.addEventListener('click', function () {
                d.activo = d.activo === v ? '' : v;
                Array.from(d.wrap.children).forEach(function (c) { setChipEstado(c, c.dataset.valor === d.activo); });
                resetDependientes(key);
                filtrar();
            });
            d.wrap.appendChild(chip);
        });
    }

    function resetDependientes(key) {
        Object.keys(dims).forEach(function (k) {
            if (dims[k].dependsOn.indexOf(key) !== -1) {
                dims[k].activo = '';
                renderChips(k);
                resetDependientes(k);
            }
        });
    }

    Object.keys(dims).forEach(renderChips);

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

    let activePrecioMin = 0;
    let activePrecioMax = 0;
    let precioFiltroActivo = false;
    let precioChipActivo = -1;

    /* ── Filtrar ── */
    function filtrar() {
        const q = input.value.trim().toLowerCase();
        clearBtn.style.display = q ? 'block' : 'none';

        const cards = grid.querySelectorAll('.producto-card');
        let visible = 0;

        cards.forEach(function (card) {
            let match = !q || card.dataset.busqueda.includes(q);

            if (match) {
                for (const key in dims) {
                    const d = dims[key];
                    if (d.activo && card.dataset[d.dataAttr] !== d.activo) { match = false; break; }
                }
            }

            if (match && precioFiltroActivo) {
                const precioNum = parseFloat(card.dataset.precioNum);
                if (!isNaN(precioNum) && precioNum > 0) {
                    if (activePrecioMin > 0 && precioNum < activePrecioMin) match = false;
                    if (activePrecioMax > 0 && precioNum > activePrecioMax) match = false;
                }
                // Productos sin precio numérico (Consultar precio) siempre pasan el filtro de precio
            }

            card.classList.toggle('hidden', !match);
            if (match) visible++;
        });

        const hayFiltroActivo = q || precioFiltroActivo || Object.keys(dims).some(function (k) { return dims[k].activo; });

        termWrap.style.display = q ? 'inline' : 'none';
        noRes.style.display = visible === 0 ? 'block' : 'none';
        termSpan.textContent = '"' + input.value.trim() + '"';
        limpiarBtn.classList.toggle('hidden', !hayFiltroActivo);

        const partes = [];
        if (hayFiltroActivo) partes.push(visible + ' de ' + total + ' productos');
        Object.keys(dims).forEach(function (key) {
            if (dims[key].activo) partes.push(ETIQUETAS[key] + ': ' + dims[key].activo);
        });
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
    const precioMinInput   = document.getElementById('precio-min');
    const precioMaxInput   = document.getElementById('precio-max');
    const precioApplyBtn   = document.getElementById('precio-apply');
    const precioClearBtn   = document.getElementById('precio-clear');
    const precioFilterRow  = document.getElementById('precio-filter-row');
    const precioChipsRow   = document.getElementById('precio-chips-row');
    const precioChipsWrap  = document.getElementById('precio-chips');

    function formatearPrecio(v) {
        return '$' + Math.round(v).toLocaleString('es-AR');
    }

    /** Redondea a un número "lindo" (múltiplo de una potencia de 10 acorde a su magnitud) para que los botones de rango queden prolijos. */
    function redondearLindo(valor) {
        if (valor <= 0) return 0;
        const magnitud = Math.pow(10, Math.floor(Math.log10(valor)));
        const paso = magnitud >= 1000 ? magnitud / 2 : Math.max(magnitud, 1);
        return Math.floor(valor / paso) * paso;
    }

    function limpiarChipsPrecio() {
        precioChipActivo = -1;
        Array.from(precioChipsWrap.children).forEach(function (c) { setChipEstado(c, false); });
    }

    /**
     * Genera botones de rango de precio a partir de los precios realmente cargados
     * en esta sección (cuartiles reales, no rangos fijos), para que cada botón
     * tenga productos y se adapte al rubro/subrubro en el que se está navegando.
     * Se calcula una sola vez al cargar la página, sobre el conjunto de productos
     * de esta sección.
     */
    function generarBotonesPrecio() {
        if (!precioFilterRow || !precioChipsRow || !precioChipsWrap) return;

        const precios = [];
        grid.querySelectorAll('.producto-card').forEach(function (c) {
            const v = parseFloat(c.dataset.precioNum);
            if (!isNaN(v) && v > 0) precios.push(v);
        });

        if (precios.length === 0) {
            precioFilterRow.classList.add('hidden');
            precioFilterRow.classList.remove('flex');
            return;
        }

        precioFilterRow.classList.remove('hidden');
        precioFilterRow.classList.add('flex');
        precioChipsWrap.innerHTML = '';

        if (precios.length < 4) {
            precioChipsRow.classList.add('hidden');
            return;
        }

        precios.sort(function (a, b) { return a - b; });

        function percentil(p) {
            const idx = Math.min(precios.length - 1, Math.floor(p * (precios.length - 1)));
            return precios[idx];
        }

        const min = precios[0];
        const max = precios[precios.length - 1];
        const cortes = Array.from(new Set([percentil(0.25), percentil(0.5), percentil(0.75)].map(function (v) { return redondearLindo(v); })))
            .filter(function (v) { return v > min && v < max; })
            .sort(function (a, b) { return a - b; });

        if (cortes.length === 0) {
            precioChipsRow.classList.add('hidden');
            return;
        }

        precioChipsRow.classList.remove('hidden');

        const tramos = [];
        let anterior = null;
        cortes.forEach(function (corte) {
            tramos.push({
                min:   anterior,
                max:   corte,
                label: anterior === null ? 'Hasta ' + formatearPrecio(corte) : formatearPrecio(anterior) + ' - ' + formatearPrecio(corte),
            });
            anterior = corte;
        });
        tramos.push({ min: anterior, max: null, label: 'Más de ' + formatearPrecio(anterior) });

        tramos.forEach(function (tramo, idx) {
            const chip = document.createElement('button');
            chip.type = 'button';
            chip.innerHTML = '<i class="fas fa-dollar-sign"></i> ' + tramo.label;
            setChipEstado(chip, false);
            chip.addEventListener('click', function () {
                if (precioChipActivo === idx) {
                    limpiarChipsPrecio();
                    activePrecioMin = 0;
                    activePrecioMax = 0;
                    precioFiltroActivo = false;
                    precioMinInput.value = '';
                    precioMaxInput.value = '';
                    precioClearBtn.style.display = 'none';
                } else {
                    precioChipActivo = idx;
                    Array.from(precioChipsWrap.children).forEach(function (c, i) { setChipEstado(c, i === idx); });
                    activePrecioMin = tramo.min || 0;
                    activePrecioMax = tramo.max || 0;
                    precioFiltroActivo = true;
                    precioMinInput.value = tramo.min || '';
                    precioMaxInput.value = tramo.max || '';
                    precioClearBtn.style.display = 'inline-flex';
                }
                filtrar();
            });
            precioChipsWrap.appendChild(chip);
        });
    }

    if (precioApplyBtn) {
        precioApplyBtn.addEventListener('click', function () {
            const minVal = parseFloat(precioMinInput.value) || 0;
            const maxVal = parseFloat(precioMaxInput.value) || 0;
            activePrecioMin = minVal;
            activePrecioMax = maxVal;
            precioFiltroActivo = (minVal > 0 || maxVal > 0);
            limpiarChipsPrecio();
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
            limpiarChipsPrecio();
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

    /* ── Limpiar todos los filtros de una vez ── */
    limpiarBtn.addEventListener('click', function () {
        input.value = '';
        Object.keys(dims).forEach(function (k) { dims[k].activo = ''; });
        activePrecioMin = 0;
        activePrecioMax = 0;
        precioFiltroActivo = false;
        if (precioMinInput) precioMinInput.value = '';
        if (precioMaxInput) precioMaxInput.value = '';
        if (precioClearBtn) precioClearBtn.style.display = 'none';
        limpiarChipsPrecio();
        Object.keys(dims).forEach(renderChips);
        filtrar();
    });

    generarBotonesPrecio();
    filtrar();
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
