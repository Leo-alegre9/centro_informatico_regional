<?= $this->extend('componentes/base') ?>

<?= $this->section('contenido') ?>

<div class="bg-fondo min-h-[60vh] font-inter">

<?php
    $filtros           = $filtros ?? [];
    $rubros            = $rubros ?? [];
    $subrubrosOpciones = $subrubrosOpciones ?? [];
    $marcasOpciones    = $marcasOpciones ?? [];
    $fabricasOpciones  = $fabricasOpciones ?? [];
    $lineasOpciones    = $lineasOpciones ?? [];
    $chips             = $chips ?? [];
    $baseParams        = $baseParams ?? [];
?>

<!-- ═══════════════════════════════════════════════
     ENCABEZADO DE BÚSQUEDA
═══════════════════════════════════════════════ -->
<div class="bg-white border-b border-[#EEF0F3] pt-8 pb-6">
    <div class="container">

        <nav class="flex items-center gap-[6px] text-[0.78rem] text-[#9CA3AF] mb-4 flex-wrap" aria-label="Breadcrumb">
            <a href="<?= base_url('/') ?>" class="text-[#6B7280] no-underline transition-colors duration-150 hover:text-rojo"><i class="fas fa-home"></i> Inicio</a>
            <span class="text-[#D1D5DB] text-[0.65rem]"><i class="fas fa-chevron-right"></i></span>
            <a href="<?= base_url('catalogo') ?>" class="text-[#6B7280] no-underline transition-colors duration-150 hover:text-rojo">Catálogo</a>
            <span class="text-[#D1D5DB] text-[0.65rem]"><i class="fas fa-chevron-right"></i></span>
            <span class="text-[#374151]">Resultados de búsqueda</span>
        </nav>

        <p class="text-[0.72rem] font-bold tracking-[0.12em] uppercase text-rojo mb-[0.35rem] flex items-center gap-[6px]"><i class="fas fa-search"></i> Resultados de búsqueda</p>
        <h1 class="text-[1.65rem] font-extrabold text-[#111827] mb-1 leading-[1.25]">
            <?php if ($query !== ''): ?>
                Resultados para <span class="text-rojo">"<?= esc($query) ?>"</span>
            <?php else: ?>
                Resultados de búsqueda
            <?php endif; ?>
        </h1>
        <p class="text-[0.875rem] text-[#6B7280] m-0">
            <?php if ($total > 0): ?>
                Se <?= $total === 1 ? 'encontró' : 'encontraron' ?> <strong class="text-[#374151]"><?= $total ?> producto<?= $total !== 1 ? 's' : '' ?></strong> con los filtros seleccionados.
            <?php else: ?>
                No se encontraron productos con los filtros seleccionados.
            <?php endif; ?>
        </p>

        <form action="<?= base_url('catalogo/buscar') ?>" method="GET" id="formBusquedaCatalogo"
              class="flex items-center bg-[#F4F6F9] border-[1.5px] border-[#E8ECF0] rounded-full overflow-hidden max-w-[560px] transition-all duration-[220ms] mt-[1.1rem] focus-within:border-rojo focus-within:shadow-[0_0_0_3px_rgba(255,0,51,0.08)] focus-within:bg-white"
              role="search">
            <input type="search" name="q"
                   class="flex-1 border-none bg-transparent py-[0.65rem] px-[1.2rem] text-[0.9rem] text-[#111827] outline-none placeholder:text-[#9CA3AF]"
                   value="<?= esc($query) ?>"
                   placeholder="Código, nombre, marca, fábrica, línea..."
                   autocomplete="off" aria-label="Buscar">
            <button type="submit" class="flex items-center justify-center w-[46px] h-[46px] bg-rojo border-none rounded-[0_50px_50px_0] text-white text-[0.9rem] cursor-pointer shrink-0 transition-colors duration-200 hover:bg-rojo-dark" aria-label="Buscar">
                <i class="fas fa-search"></i>
            </button>

            <!-- Filtros activos se preservan como campos ocultos al lanzar una nueva búsqueda de texto -->
            <?php foreach (['rubro', 'subrubro', 'marca', 'fabrica', 'linea', 'orden'] as $campoOculto): ?>
                <?php if (($filtros[$campoOculto] ?? '') !== ''): ?>
                    <input type="hidden" name="<?= esc($campoOculto) ?>" value="<?= esc($filtros[$campoOculto]) ?>">
                <?php endif; ?>
            <?php endforeach; ?>
        </form>

        <!-- ═══ Panel de filtros ═══ -->
        <details class="mt-4 max-w-[820px]" <?= (!empty($filtros['rubro']) || !empty($filtros['marca']) || !empty($filtros['fabrica']) || !empty($filtros['linea'])) ? 'open' : '' ?>>
            <summary class="cursor-pointer select-none inline-flex items-center gap-2 text-[0.85rem] font-semibold text-[#374151] list-none">
                <i class="fas fa-sliders-h text-rojo"></i> Filtrar resultados
            </summary>

            <form action="<?= base_url('catalogo/buscar') ?>" method="GET" class="mt-3 bg-[#F9FAFB] border-[1.5px] border-[#E8ECF0] rounded-[14px] p-4">
                <?php if ($query !== ''): ?><input type="hidden" name="q" value="<?= esc($query) ?>"><?php endif; ?>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                    <div>
                        <label class="text-[0.72rem] font-bold uppercase tracking-wide text-[#9CA3AF] mb-1 block">Rubro</label>
                        <select name="rubro" id="filtroRubro" class="w-full py-2 px-3 border-[1.5px] border-[#e5e7eb] rounded-[9px] text-[0.85rem] text-[#374151] bg-white outline-none focus:border-rojo" onchange="this.form.submit()">
                            <option value="">Todos</option>
                            <?php foreach ($rubros as $r): ?>
                                <option value="<?= esc($r['slug']) ?>" <?= ($filtros['rubro'] ?? '') === $r['slug'] ? 'selected' : '' ?>><?= esc($r['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <?php if (!empty($subrubrosOpciones)): ?>
                    <div>
                        <label class="text-[0.72rem] font-bold uppercase tracking-wide text-[#9CA3AF] mb-1 block">Subrubro</label>
                        <select name="subrubro" class="w-full py-2 px-3 border-[1.5px] border-[#e5e7eb] rounded-[9px] text-[0.85rem] text-[#374151] bg-white outline-none focus:border-rojo">
                            <option value="">Todos</option>
                            <?php foreach ($subrubrosOpciones as $s): ?>
                                <option value="<?= esc($s['slug']) ?>" <?= ($filtros['subrubro'] ?? '') === $s['slug'] ? 'selected' : '' ?>><?= esc($s['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($marcasOpciones)): ?>
                    <div>
                        <label class="text-[0.72rem] font-bold uppercase tracking-wide text-[#9CA3AF] mb-1 block">Marca</label>
                        <select name="marca" class="w-full py-2 px-3 border-[1.5px] border-[#e5e7eb] rounded-[9px] text-[0.85rem] text-[#374151] bg-white outline-none focus:border-rojo">
                            <option value="">Todas</option>
                            <?php foreach ($marcasOpciones as $m): ?>
                                <option value="<?= (int) $m['id'] ?>" <?= (string) ($filtros['marca'] ?? '') === (string) $m['id'] ? 'selected' : '' ?>><?= esc($m['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($fabricasOpciones)): ?>
                    <div>
                        <label class="text-[0.72rem] font-bold uppercase tracking-wide text-[#9CA3AF] mb-1 block">Fábrica</label>
                        <select name="fabrica" id="filtroFabrica" class="w-full py-2 px-3 border-[1.5px] border-[#e5e7eb] rounded-[9px] text-[0.85rem] text-[#374151] bg-white outline-none focus:border-rojo" onchange="this.form.submit()">
                            <option value="">Todas</option>
                            <?php foreach ($fabricasOpciones as $f): ?>
                                <option value="<?= (int) $f['id'] ?>" <?= (string) ($filtros['fabrica'] ?? '') === (string) $f['id'] ? 'selected' : '' ?>><?= esc($f['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($lineasOpciones)): ?>
                    <div>
                        <label class="text-[0.72rem] font-bold uppercase tracking-wide text-[#9CA3AF] mb-1 block">Línea</label>
                        <select name="linea" class="w-full py-2 px-3 border-[1.5px] border-[#e5e7eb] rounded-[9px] text-[0.85rem] text-[#374151] bg-white outline-none focus:border-rojo">
                            <option value="">Todas</option>
                            <?php foreach ($lineasOpciones as $l): ?>
                                <option value="<?= (int) $l['id'] ?>" <?= (string) ($filtros['linea'] ?? '') === (string) $l['id'] ? 'selected' : '' ?>><?= esc($l['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <div>
                        <label class="text-[0.72rem] font-bold uppercase tracking-wide text-[#9CA3AF] mb-1 block">Ordenar por</label>
                        <select name="orden" class="w-full py-2 px-3 border-[1.5px] border-[#e5e7eb] rounded-[9px] text-[0.85rem] text-[#374151] bg-white outline-none focus:border-rojo">
                            <option value="">Relevancia</option>
                            <option value="az" <?= ($filtros['orden'] ?? '') === 'az' ? 'selected' : '' ?>>Nombre A → Z</option>
                            <option value="za" <?= ($filtros['orden'] ?? '') === 'za' ? 'selected' : '' ?>>Nombre Z → A</option>
                            <option value="precio_asc" <?= ($filtros['orden'] ?? '') === 'precio_asc' ? 'selected' : '' ?>>Precio: menor a mayor</option>
                            <option value="precio_desc" <?= ($filtros['orden'] ?? '') === 'precio_desc' ? 'selected' : '' ?>>Precio: mayor a menor</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-2 mt-4">
                    <button type="submit" class="inline-flex items-center gap-[6px] bg-rojo text-white text-[0.82rem] font-bold px-4 py-[0.5rem] rounded-full border-none cursor-pointer hover:bg-rojo-dark">
                        <i class="fas fa-filter"></i> Aplicar filtros
                    </button>
                    <a href="<?= base_url('catalogo/buscar') ?><?= $query !== '' ? '?q=' . rawurlencode($query) : '' ?>" class="inline-flex items-center gap-[6px] border-[1.5px] border-[#e5e7eb] text-[#6B7280] text-[0.82rem] font-bold px-4 py-[0.5rem] rounded-full no-underline hover:border-rojo hover:text-rojo">
                        <i class="fas fa-times"></i> Limpiar filtros
                    </a>
                </div>
            </form>
        </details>

        <!-- ═══ Chips de filtros activos ═══ -->
        <?php if (!empty($chips)): ?>
        <div class="flex items-center gap-2 flex-wrap mt-4">
            <?php foreach ($chips as $chip): ?>
                <a href="?<?= http_build_query($chip['quitar']) ?>"
                   class="inline-flex items-center gap-[6px] bg-rojo/[0.08] text-rojo text-[0.78rem] font-semibold px-3 py-[0.3rem] rounded-full no-underline hover:bg-rojo hover:text-white transition-colors duration-150">
                    <?= esc($chip['label']) ?> <i class="fas fa-times text-[0.7rem]"></i>
                </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</div>

<!-- ═══════════════════════════════════════════════
     RESULTADOS
═══════════════════════════════════════════════ -->
<section class="pt-10 pb-16">
    <div class="container">

        <div class="grid grid-cols-3 gap-[1.3rem] max-[991px]:grid-cols-2 max-[575px]:grid-cols-1">

            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $p): ?>
                <div class="bg-white rounded-2xl border-[1.5px] border-[#F0F2F5] shadow-[0_3px_14px_rgba(0,0,0,0.06)] flex flex-col overflow-hidden transition-all duration-[250ms] ease-out hover:-translate-y-1 hover:shadow-[0_14px_40px_rgba(0,0,0,0.11)]">
                    <div class="bg-[#1C1C2A] min-h-[160px] flex items-center justify-center relative overflow-hidden">
                        <?php if (!empty($p['imagen_url'])): ?>
                            <img src="<?= base_url(esc($p['imagen_url'])) ?>"
                                 alt="<?= esc($p['nombre']) ?>"
                                 class="absolute inset-0 w-full h-full object-cover"
                                 loading="lazy">
                        <?php else: ?>
                            <i class="<?= esc($p['icono']) ?> text-[3rem] text-white/[0.18]"></i>
                        <?php endif; ?>

                        <?php if (!empty($p['badge'])): ?>
                            <span class="absolute top-[10px] right-[10px] bg-rojo text-white text-[0.68rem] font-bold px-[9px] py-[3px] rounded-full tracking-[0.3px] whitespace-nowrap"><?= esc($p['badge']) ?></span>
                        <?php endif; ?>

                        <?php if (!empty($p['categoria'])): ?>
                            <span class="absolute bottom-2 left-2 bg-black/[0.55] text-white text-[0.65rem] font-semibold px-2 py-[3px] rounded-[4px] backdrop-blur-[4px] whitespace-nowrap max-w-[calc(100%-16px)] overflow-hidden text-ellipsis">
                                <i class="fas fa-folder mr-1 opacity-70"></i>
                                <?= esc($p['categoria']) ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="px-5 pt-[1.2rem] pb-[1.3rem] flex-1 flex flex-col">
                        <?php if (!empty($p['marca'])): ?>
                            <div class="text-[0.68rem] font-bold text-rojo/65 uppercase tracking-[0.5px] mb-[0.18rem]"><?= esc($p['marca']) ?></div>
                        <?php endif; ?>
                        <div class="font-extrabold text-[0.95rem] text-[#111827] mb-[0.35rem] leading-[1.4]"><?= esc($p['nombre']) ?></div>
                        <?php if (!empty($p['descripcion'])): ?>
                            <div class="text-[0.82rem] text-[#6B7280] leading-[1.55] flex-1 mb-4 line-clamp-3"><?= esc($p['descripcion']) ?></div>
                        <?php endif; ?>
                        <div class="flex items-center justify-between gap-2 flex-wrap">
                            <?php if (!empty($p['precio'])): ?>
                                <span class="font-bold text-[0.85rem] text-[#6B7280]"><?= esc($p['precio']) ?></span>
                            <?php else: ?>
                                <span></span>
                            <?php endif; ?>
                            <a href="<?= esc($p['url_producto']) ?>" class="inline-flex items-center gap-[6px] bg-rojo text-white text-[0.78rem] font-bold px-4 py-[0.44rem] rounded-full no-underline whitespace-nowrap transition-colors duration-200 hover:bg-rojo-dark hover:text-white">
                                Ver producto <i class="fas fa-arrow-right text-[0.7rem]"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            <?php else: ?>
                <div class="col-span-full text-center py-16 px-4">
                    <i class="fas fa-box-open text-[3.5rem] text-[#D1D5DB] mb-4 block"></i>
                    <h3 class="text-[1.15rem] font-bold text-[#374151] mb-2">
                        <?= $query !== '' ? 'Sin resultados para "' . esc($query) . '"' : 'No se encontraron productos con los filtros seleccionados' ?>
                    </h3>
                    <p class="text-[0.9rem] text-[#9CA3AF] mx-auto mb-6 max-w-[420px]">
                        Probá con otros términos, quitá algún filtro o explorá el catálogo completo.
                        También podés consultarnos directamente por WhatsApp.
                    </p>
                    <div class="flex items-center justify-center gap-3 flex-wrap">
                        <a href="<?= base_url('catalogo') ?>" class="inline-flex items-center gap-[6px] border-[1.5px] border-rojo text-rojo bg-transparent text-[0.85rem] font-bold px-[1.2rem] py-2 rounded-full no-underline transition-colors duration-[180ms] hover:bg-rojo hover:text-white">
                            <i class="fas fa-th-large"></i> Ver catálogo
                        </a>
                        <a href="https://wa.me/5493704616482?text=Hola!%20Busco%20<?= rawurlencode($query) ?>%20y%20no%20lo%20encontré%20en%20el%20sitio."
                           target="_blank" rel="noopener"
                           class="inline-flex items-center gap-[6px] border-[1.5px] border-[#25D366] bg-[#25D366] text-white text-[0.85rem] font-bold px-[1.2rem] py-2 rounded-full no-underline transition-colors duration-[180ms] hover:bg-rojo hover:border-rojo hover:text-white">
                            <i class="fab fa-whatsapp"></i> Consultar por WhatsApp
                        </a>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <?= $this->include('componentes/paginador') ?>

    </div>
</section>

</div>

<?= $this->endSection() ?>
