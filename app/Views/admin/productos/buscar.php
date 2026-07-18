<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
    <h2 class="text-[1.4rem] font-bold text-dark m-0"><i class="fas fa-search mr-2 text-rojo text-[1.05rem]"></i>Buscar producto</h2>
    <a href="<?= base_url('admin/productos') ?>" class="text-gray-500 no-underline text-[0.88rem] font-semibold hover:text-gray-700">
        <i class="fas fa-arrow-left mr-1"></i> Ver todos los productos
    </a>
</div>

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
                    placeholder="Escribí el código, nombre o cualquier referencia..."
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
        <div class="text-[0.78rem] text-gray-400 mt-[0.6rem]">
            <i class="fas fa-info-circle mr-1"></i>
            <strong>Todo</strong>: busca en código, nombre, modelo y marca.
            <strong>Por código</strong>: busca solo en el código interno del producto.
            <strong>Por nombre</strong>: busca solo en el nombre del producto.
        </div>
    </form>
</div>

<!-- Resultados -->
<?php if ($q !== ''): ?>
<div class="flex items-center justify-between mb-[0.85rem] flex-wrap gap-2">
    <h5 class="text-[0.95rem] font-bold text-gray-700 m-0">
        Resultados para
        <span class="text-rojo">"<?= esc($q) ?>"</span>
        <?php if ($tipo !== 'todos'): ?>
            <span class="text-gray-400 font-normal text-[0.85rem]">
                — buscando por <?= $tipo === 'codigo' ? 'código' : 'nombre' ?>
            </span>
        <?php endif; ?>
    </h5>
    <span class="bg-rojo/[0.08] text-rojo px-3 py-[0.2rem] rounded-full text-[0.82rem] font-semibold"><?= count($resultados) ?> resultado<?= count($resultados) !== 1 ? 's' : '' ?></span>
</div>

<?php if (!empty($resultados)): ?>
<div class="bg-white border border-gray-200 rounded-[14px] overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.05)]">
    <div class="overflow-x-auto">
        <table class="w-full text-[0.88rem] border-collapse">
            <thead>
                <tr>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Código</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Categoría</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Nombre del producto</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Marca / Modelo</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Precio</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Stock</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Activo</th>
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
                        <span class="bg-gray-100 text-gray-500 px-[0.55rem] py-[0.15rem] rounded-full text-xs font-semibold"><?= esc($p['categoria_path'] ?? '—') ?></span>
                    </td>
                    <td class="align-middle px-4 py-3">
                        <div class="font-semibold text-dark"><?= esc($p['nombre']) ?></div>
                        <?php if (!empty($p['descripcion_corta'])): ?>
                            <div class="text-[0.78rem] text-gray-400 mt-0.5"><?= esc(mb_substr($p['descripcion_corta'], 0, 70)) ?>...</div>
                        <?php endif; ?>
                    </td>
                    <td class="align-middle px-4 py-3 text-[0.85rem]">
                        <?php if (!empty($p['marca_nombre'])): ?>
                            <div class="font-semibold"><?= esc($p['marca_nombre']) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($p['modelo'])): ?>
                            <div class="text-gray-400 text-[0.78rem]"><?= esc($p['modelo']) ?></div>
                        <?php endif; ?>
                        <?php if (empty($p['marca_nombre']) && empty($p['modelo'])): ?>
                            <span class="text-gray-300">—</span>
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
                            <span class="inline-flex items-center bg-emerald-500/[0.12] text-emerald-600 px-[0.6rem] py-[0.2rem] rounded-full text-xs font-semibold"><i class="fas fa-check mr-1"></i>Sí</span>
                        <?php else: ?>
                            <span class="inline-flex items-center bg-red-500/10 text-red-600 px-[0.6rem] py-[0.2rem] rounded-full text-xs font-semibold"><i class="fas fa-times mr-1"></i>No</span>
                        <?php endif; ?>
                    </td>
                    <td class="align-middle px-4 py-3">
                        <a href="<?= base_url("admin/productos/{$p['id']}/editar") ?>"
                           class="inline-flex items-center border border-blue-500 text-blue-500 rounded-md px-[0.7rem] py-[0.3rem] text-[0.78rem] font-semibold no-underline transition-colors hover:bg-blue-500 hover:text-white">
                            <i class="fas fa-pen mr-1"></i>Editar
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php else: ?>
<div class="bg-white border border-gray-200 rounded-[14px] overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.05)]">
    <div class="text-center px-8 py-16 text-gray-400">
        <i class="fas fa-search text-5xl mb-4 block text-gray-300"></i>
        <h5 class="text-gray-700 font-semibold mb-2">Sin resultados</h5>
        <p class="text-[0.9rem]">No se encontró ningún producto que coincida con "<?= esc($q) ?>". Probá con otro término.</p>
    </div>
</div>
<?php endif; ?>

<?php else: ?>
<div class="bg-white border border-gray-200 rounded-[14px] overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.05)]">
    <div class="text-center px-8 py-16 text-gray-400">
        <i class="fas fa-search text-5xl mb-4 block text-gray-300"></i>
        <h5 class="text-gray-700 font-semibold mb-2">Ingresá un término para buscar</h5>
        <p class="text-[0.9rem]">Podés buscar por código interno, nombre del producto, modelo o marca.</p>
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
