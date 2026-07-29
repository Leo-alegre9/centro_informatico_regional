<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
    <h2 class="text-[1.4rem] font-bold text-dark m-0"><i class="fas fa-search mr-2 text-rojo text-[1.05rem]"></i>Buscar producto</h2>
    <a href="<?= base_url('admin/productos') ?>" class="text-gray-500 no-underline text-[0.88rem] font-semibold hover:text-gray-700">
        <i class="fas fa-arrow-left mr-1"></i> Ver todos los productos
    </a>
</div>

<?php
    $filtros           = $filtros ?? [];
    $rubros            = $rubros ?? [];
    $subrubrosOpciones = $subrubrosOpciones ?? [];
    $marcasOpciones    = $marcasOpciones ?? [];
    $fabricasOpciones  = $fabricasOpciones ?? [];
    $lineasOpciones    = $lineasOpciones ?? [];
    $baseParams        = $baseParams ?? [];
    $hayFiltrosActivos = $q !== '' || !empty($filtros['rubro']) || !empty($filtros['marca']) || !empty($filtros['fabrica']) || !empty($filtros['linea']) || !empty($filtros['estado']) || !empty($filtros['stock']);
?>

<!-- Formulario de búsqueda -->
<div class="bg-white border border-gray-200 rounded-[14px] px-6 pt-6 pb-5 mb-6 shadow-[0_1px_4px_rgba(0,0,0,0.05)]">
    <form method="GET" action="<?= base_url('admin/productos/buscar') ?>" id="formBuscar">
        <input type="hidden" name="tipo" id="tipoHidden" value="<?= esc($tipo) ?>">

        <label class="text-[0.85rem] font-semibold text-gray-700 mb-1 block" for="q">¿Qué estás buscando?</label>
        <div class="flex gap-2 items-start flex-wrap">
            <div class="flex-1 min-w-[220px]">
                <input
                    type="text"
                    id="q"
                    name="q"
                    class="border-2 border-gray-200 rounded-[10px] px-4 py-[0.65rem] text-[0.95rem] text-dark w-full bg-white transition-colors outline-none focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]"
                    value="<?= esc($q) ?>"
                    placeholder="Escribí el código, nombre, marca, fábrica o línea..."
                    autocomplete="off"
                    autofocus>
            </div>
            <button type="submit" class="bg-rojo text-white border-none px-7 py-[0.65rem] rounded-full text-[0.92rem] font-semibold cursor-pointer inline-flex items-center gap-[0.4rem] whitespace-nowrap transition-colors hover:bg-rojo-dark">
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>

        <div class="flex gap-2 flex-wrap mt-[0.85rem]">
            <span class="tipo-pill" data-tipo="todos" onclick="setTipo('todos')">
                <i class="fas fa-th-list mr-1"></i>Todo
            </span>
            <span class="tipo-pill" data-tipo="codigo" onclick="setTipo('codigo')">
                <i class="fas fa-barcode mr-1"></i>Por código
            </span>
            <span class="tipo-pill" data-tipo="nombre" onclick="setTipo('nombre')">
                <i class="fas fa-font mr-1"></i>Por nombre
            </span>
        </div>
        <div class="text-[0.78rem] text-gray-400 mt-[0.6rem] mb-4">
            <i class="fas fa-info-circle mr-1"></i>
            <strong>Todo</strong>: busca en código, nombre, modelo, marca, fábrica, línea, rubro/subrubro y descripción.
            <strong>Por código</strong>: busca solo en el código interno del producto.
            <strong>Por nombre</strong>: busca solo en el nombre del producto.
        </div>

        <!-- Filtros combinables -->
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3 pt-4 border-t border-gray-100">
            <div>
                <label class="text-[0.72rem] font-bold uppercase tracking-wide text-gray-400 mb-1 block">Rubro</label>
                <select name="rubro" class="w-full py-2 px-3 border-[1.5px] border-gray-200 rounded-[9px] text-[0.85rem] text-dark bg-white outline-none focus:border-rojo" onchange="this.form.submit()">
                    <option value="">Todos</option>
                    <?php foreach ($rubros as $r): ?>
                        <option value="<?= esc($r['slug']) ?>" <?= ($filtros['rubro'] ?? '') === $r['slug'] ? 'selected' : '' ?>><?= esc($r['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if (!empty($subrubrosOpciones)): ?>
            <div>
                <label class="text-[0.72rem] font-bold uppercase tracking-wide text-gray-400 mb-1 block">Subrubro</label>
                <select name="subrubro" class="w-full py-2 px-3 border-[1.5px] border-gray-200 rounded-[9px] text-[0.85rem] text-dark bg-white outline-none focus:border-rojo">
                    <option value="">Todos</option>
                    <?php foreach ($subrubrosOpciones as $s): ?>
                        <option value="<?= esc($s['slug']) ?>" <?= ($filtros['subrubro'] ?? '') === $s['slug'] ? 'selected' : '' ?>><?= esc($s['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>

            <?php if (!empty($marcasOpciones)): ?>
            <div>
                <label class="text-[0.72rem] font-bold uppercase tracking-wide text-gray-400 mb-1 block">Marca</label>
                <select name="marca" class="w-full py-2 px-3 border-[1.5px] border-gray-200 rounded-[9px] text-[0.85rem] text-dark bg-white outline-none focus:border-rojo">
                    <option value="">Todas</option>
                    <?php foreach ($marcasOpciones as $m): ?>
                        <option value="<?= (int) $m['id'] ?>" <?= (string) ($filtros['marca'] ?? '') === (string) $m['id'] ? 'selected' : '' ?>><?= esc($m['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>

            <?php if (!empty($fabricasOpciones)): ?>
            <div>
                <label class="text-[0.72rem] font-bold uppercase tracking-wide text-gray-400 mb-1 block">Fábrica</label>
                <select name="fabrica" class="w-full py-2 px-3 border-[1.5px] border-gray-200 rounded-[9px] text-[0.85rem] text-dark bg-white outline-none focus:border-rojo" onchange="this.form.submit()">
                    <option value="">Todas</option>
                    <?php foreach ($fabricasOpciones as $f): ?>
                        <option value="<?= (int) $f['id'] ?>" <?= (string) ($filtros['fabrica'] ?? '') === (string) $f['id'] ? 'selected' : '' ?>><?= esc($f['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>

            <?php if (!empty($lineasOpciones)): ?>
            <div>
                <label class="text-[0.72rem] font-bold uppercase tracking-wide text-gray-400 mb-1 block">Línea</label>
                <select name="linea" class="w-full py-2 px-3 border-[1.5px] border-gray-200 rounded-[9px] text-[0.85rem] text-dark bg-white outline-none focus:border-rojo">
                    <option value="">Todas</option>
                    <?php foreach ($lineasOpciones as $l): ?>
                        <option value="<?= (int) $l['id'] ?>" <?= (string) ($filtros['linea'] ?? '') === (string) $l['id'] ? 'selected' : '' ?>><?= esc($l['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>

            <div>
                <label class="text-[0.72rem] font-bold uppercase tracking-wide text-gray-400 mb-1 block">Estado</label>
                <select name="estado" class="w-full py-2 px-3 border-[1.5px] border-gray-200 rounded-[9px] text-[0.85rem] text-dark bg-white outline-none focus:border-rojo">
                    <option value="">Todos</option>
                    <option value="1" <?= ($filtros['estado'] ?? '') === '1' ? 'selected' : '' ?>>Activo</option>
                    <option value="0" <?= ($filtros['estado'] ?? '') === '0' ? 'selected' : '' ?>>Inactivo</option>
                </select>
            </div>

            <div>
                <label class="text-[0.72rem] font-bold uppercase tracking-wide text-gray-400 mb-1 block">Stock</label>
                <select name="stock" class="w-full py-2 px-3 border-[1.5px] border-gray-200 rounded-[9px] text-[0.85rem] text-dark bg-white outline-none focus:border-rojo">
                    <option value="">Todos</option>
                    <option value="con" <?= ($filtros['stock'] ?? '') === 'con' ? 'selected' : '' ?>>Con stock</option>
                    <option value="sin" <?= ($filtros['stock'] ?? '') === 'sin' ? 'selected' : '' ?>>Sin stock</option>
                </select>
            </div>
        </div>

        <div class="flex items-center gap-2 mt-4">
            <button type="submit" class="inline-flex items-center gap-[6px] bg-rojo text-white text-[0.82rem] font-bold px-4 py-[0.5rem] rounded-full border-none cursor-pointer hover:bg-rojo-dark">
                <i class="fas fa-filter"></i> Aplicar filtros
            </button>
            <a href="<?= base_url('admin/productos/buscar') ?>" class="inline-flex items-center gap-[6px] border-[1.5px] border-gray-200 text-gray-500 text-[0.82rem] font-bold px-4 py-[0.5rem] rounded-full no-underline hover:border-rojo hover:text-rojo">
                <i class="fas fa-times"></i> Limpiar filtros
            </a>
        </div>
    </form>
</div>

<!-- Resultados -->
<?php if ($hayFiltrosActivos): ?>
<div class="flex items-center justify-between mb-[0.85rem] flex-wrap gap-2">
    <h5 class="text-[0.95rem] font-bold text-gray-700 m-0">
        <?php if ($q !== ''): ?>
            Resultados para
            <span class="text-rojo">"<?= esc($q) ?>"</span>
            <?php if ($tipo !== 'todos'): ?>
                <span class="text-gray-400 font-normal text-[0.85rem]">
                    — buscando por <?= $tipo === 'codigo' ? 'código' : 'nombre' ?>
                </span>
            <?php endif; ?>
        <?php else: ?>
            Resultados filtrados
        <?php endif; ?>
    </h5>
    <span class="bg-rojo/[0.08] text-rojo px-3 py-[0.2rem] rounded-full text-[0.82rem] font-semibold"><?= (int) ($total ?? count($resultados)) ?> resultado<?= (int) ($total ?? count($resultados)) !== 1 ? 's' : '' ?></span>
</div>

<?php if (!empty($resultados)): ?>
<div class="bg-white border border-gray-200 rounded-[14px] overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.05)]">
    <div class="overflow-x-auto">
        <table class="w-full text-[0.88rem] border-collapse">
            <thead>
                <tr>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Código</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Nombre del producto</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Rubro / Subrubro</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Marca</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Fábrica / Línea</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Precio</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Stock</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Estado</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $p): ?>
                <tr class="border-t border-gray-100 hover:bg-gray-50">
                    <td class="align-middle px-4 py-3">
                        <?php if (!empty($p['codigo'])): ?>
                            <span class="bg-indigo-500/10 text-indigo-600 px-[0.55rem] py-[0.15rem] rounded-full text-[0.78rem] font-bold font-mono"><?= esc($p['codigo']) ?></span>
                        <?php else: ?>
                            <span class="text-gray-300 text-[0.8rem]">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="align-middle px-4 py-3">
                        <div class="font-semibold text-dark"><?= esc($p['nombre']) ?></div>
                        <?php if (!empty($p['descripcion_corta'])): ?>
                            <div class="text-[0.78rem] text-gray-400 mt-0.5"><?= esc(mb_substr($p['descripcion_corta'], 0, 70)) ?>...</div>
                        <?php endif; ?>
                    </td>
                    <td class="align-middle px-4 py-3 text-[0.85rem]">
                        <div><?= esc($p['rubro_nombre'] ?: 'Sin asignar') ?></div>
                        <?php if (!empty($p['subrubro_nombre'])): ?>
                            <div class="text-gray-400 text-[0.78rem]"><?= esc($p['subrubro_nombre']) ?></div>
                        <?php endif; ?>
                    </td>
                    <td class="align-middle px-4 py-3 text-[0.85rem]">
                        <?= !empty($p['marca_nombre']) ? esc($p['marca_nombre']) : '<span class="text-gray-300">Sin asignar</span>' ?>
                    </td>
                    <td class="align-middle px-4 py-3 text-[0.85rem]">
                        <?php if (!empty($p['fabrica_nombre'])): ?>
                            <div class="font-semibold"><?= esc($p['fabrica_nombre']) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($p['linea_nombre'])): ?>
                            <div class="text-gray-400 text-[0.78rem]"><?= esc($p['linea_nombre']) ?></div>
                        <?php endif; ?>
                        <?php if (empty($p['fabrica_nombre']) && empty($p['linea_nombre'])): ?>
                            <span class="text-gray-300">Sin asignar</span>
                        <?php endif; ?>
                    </td>
                    <td class="align-middle px-4 py-3 text-[0.85rem]"><?= esc($p['precio_texto'] ?? '—') ?></td>
                    <td class="align-middle px-4 py-3">
                        <span class="font-bold <?= (int)($p['stock'] ?? 0) > 0 ? 'text-emerald-600' : 'text-gray-400' ?>">
                            <?= (int)($p['stock'] ?? 0) ?>
                        </span>
                    </td>
                    <td class="align-middle px-4 py-3">
                        <?php if ($p['activo']): ?>
                            <span class="inline-flex items-center bg-emerald-500/[0.12] text-emerald-600 px-[0.6rem] py-[0.2rem] rounded-full text-xs font-semibold"><i class="fas fa-check mr-1"></i>Activo</span>
                        <?php else: ?>
                            <span class="inline-flex items-center bg-red-500/10 text-red-600 px-[0.6rem] py-[0.2rem] rounded-full text-xs font-semibold"><i class="fas fa-times mr-1"></i>Inactivo</span>
                        <?php endif; ?>
                    </td>
                    <td class="align-middle px-4 py-3">
                        <div class="flex gap-1 flex-wrap">
                            <a href="<?= base_url("admin/productos/{$p['id']}/ver") ?>"
                               class="inline-flex items-center border border-gray-300 text-gray-600 rounded-md px-[0.7rem] py-[0.3rem] text-[0.78rem] font-semibold no-underline transition-colors hover:bg-gray-100">
                                <i class="fas fa-eye mr-1"></i>Ver
                            </a>
                            <a href="<?= base_url("admin/productos/{$p['id']}/editar") ?>"
                               class="inline-flex items-center border border-blue-500 text-blue-500 rounded-md px-[0.7rem] py-[0.3rem] text-[0.78rem] font-semibold no-underline transition-colors hover:bg-blue-500 hover:text-white">
                                <i class="fas fa-pen mr-1"></i>Editar
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->include('componentes/paginador') ?>

<?php else: ?>
<div class="bg-white border border-gray-200 rounded-[14px] overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.05)]">
    <div class="text-center px-8 py-16 text-gray-400">
        <i class="fas fa-search text-5xl mb-4 block text-gray-300"></i>
        <h5 class="text-gray-700 font-semibold mb-2">Sin resultados</h5>
        <p class="text-[0.9rem]">No se encontró ningún producto con los criterios y filtros indicados. Probá con otro término o quitá algún filtro.</p>
    </div>
</div>
<?php endif; ?>

<?php else: ?>
<div class="bg-white border border-gray-200 rounded-[14px] overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.05)]">
    <div class="text-center px-8 py-16 text-gray-400">
        <i class="fas fa-search text-5xl mb-4 block text-gray-300"></i>
        <h5 class="text-gray-700 font-semibold mb-2">Ingresá un término o elegí un filtro para buscar</h5>
        <p class="text-[0.9rem]">Podés buscar por código, nombre, marca, fábrica o línea, y combinarlo con los filtros de rubro, subrubro, estado o stock.</p>
    </div>
</div>
<?php endif; ?>

<script>
const PILL_BASE     = 'tipo-pill px-4 py-[0.35rem] rounded-full text-[0.84rem] font-semibold border-[1.5px] cursor-pointer select-none transition-colors';
const PILL_ACTIVE   = PILL_BASE + ' bg-rojo border-rojo text-white';
const PILL_INACTIVE = PILL_BASE + ' bg-white border-gray-200 text-gray-500 hover:border-rojo hover:text-rojo';

function setTipo(valor) {
    document.getElementById('tipoHidden').value = valor;
    document.querySelectorAll('.tipo-pill').forEach(function (el) {
        el.className = (el.dataset.tipo === valor) ? PILL_ACTIVE : PILL_INACTIVE;
    });
}

/* Enviar con Enter en el input */
document.getElementById('q').addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('formBuscar').submit();
    }
});

/* Reflejar el tipo de búsqueda actual (server-side) en los pills */
setTipo('<?= esc($tipo) ?>');
</script>

<?= $this->endSection() ?>
