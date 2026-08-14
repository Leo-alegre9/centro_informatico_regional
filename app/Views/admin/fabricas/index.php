<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<?php
$badgeActivo   = 'bg-emerald-500/10 text-emerald-600 px-2.5 py-1 rounded-full text-xs font-semibold';
$badgeInactivo = 'bg-red-500/10 text-red-600 px-2.5 py-1 rounded-full text-xs font-semibold';
$btnAccionBase = 'inline-flex items-center justify-center rounded-[7px] px-[0.7rem] py-[0.3rem] text-[0.78rem] font-semibold transition-colors border';
$btnSecondary  = $btnAccionBase . ' border-gray-300 text-gray-600 bg-white hover:bg-gray-100';
$btnDanger     = $btnAccionBase . ' border-red-400 text-red-600 bg-white hover:bg-red-50';
$btnRojo       = 'bg-rojo hover:bg-rojo-dark text-white px-5 py-[0.55rem] rounded-full text-sm font-semibold no-underline inline-flex items-center gap-[0.4rem] transition-colors whitespace-nowrap';
?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
    <h2 class="text-[1.4rem] font-bold text-dark m-0"><i class="fas fa-industry mr-2 text-rojo text-[1.1rem]"></i>Gestión de Fábricas</h2>
    <a href="<?= base_url('admin/fabricas/crear') ?>" class="<?= $btnRojo ?>">
        <i class="fas fa-plus"></i> Nueva Fábrica
    </a>
</div>

<?php if ($success = session()->getFlashdata('success')): ?>
<div class="bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-[10px] flex items-center gap-2 mb-4 px-4 py-3 text-sm">
    <i class="fas fa-check-circle"></i> <?= esc($success) ?>
</div>
<?php endif; ?>

<div class="bg-white border border-gray-200 rounded-xl px-5 py-4 mb-5 flex items-center gap-4 flex-wrap">
    <label for="filtroBuscar" class="text-[0.85rem] font-semibold text-gray-700 m-0"><i class="fas fa-search mr-1"></i>Buscar:</label>
    <input type="text" id="filtroBuscar"
           class="border-[1.5px] border-gray-200 rounded-lg px-[0.9rem] py-[0.4rem] text-[0.88rem] text-gray-700 bg-gray-50 outline-none transition-colors flex-1 min-w-[180px] focus:border-rojo"
           placeholder="Nombre o slug..." oninput="filtrarTabla(this.value)">
    <span class="bg-rojo/10 text-rojo rounded-full px-[0.7rem] py-[0.2rem] text-[0.8rem] font-semibold ml-auto" id="countVisible"><?= count($fabricas) ?> fábricas</span>
</div>

<?php if (!empty($fabricas)): ?>
<div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.05)]">
    <div class="overflow-x-auto">
        <table class="w-full text-[0.88rem] border-collapse" id="tablaFabricas">
            <thead>
                <tr>
                    <th class="bg-gray-50/70 text-gray-500 font-bold text-[0.72rem] uppercase tracking-wider border-b border-gray-100 px-5 py-3.5 whitespace-nowrap text-left">Nombre</th>
                    <th class="bg-gray-50/70 text-gray-500 font-bold text-[0.72rem] uppercase tracking-wider border-b border-gray-100 px-5 py-3.5 whitespace-nowrap text-left">Slug</th>
                    <th class="bg-gray-50/70 text-gray-500 font-bold text-[0.72rem] uppercase tracking-wider border-b border-gray-100 px-5 py-3.5 whitespace-nowrap text-left">Estado</th>
                    <th class="bg-gray-50/70 text-gray-500 font-bold text-[0.72rem] uppercase tracking-wider border-b border-gray-100 px-5 py-3.5 whitespace-nowrap text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fabricas as $fabrica): ?>
                <tr class="border-b border-gray-50 hover:bg-gray-50/60 transition-colors" data-busqueda="<?= esc(strtolower($fabrica['nombre'] . ' ' . $fabrica['slug'])) ?>">
                    <td class="align-middle px-5 py-4"><strong class="text-dark"><?= esc($fabrica['nombre']) ?></strong></td>
                    <td class="align-middle px-5 py-4"><code class="text-[0.78rem] text-gray-700"><?= esc($fabrica['slug']) ?></code></td>
                    <td class="align-middle px-5 py-4">
                        <span class="<?= $fabrica['activo'] ? $badgeActivo : $badgeInactivo ?>">
                            <?= $fabrica['activo'] ? 'Activa' : 'Inactiva' ?>
                        </span>
                    </td>
                    <td class="align-middle px-5 py-4">
                        <div class="flex items-center gap-1">
                            <a href="<?= base_url("admin/fabricas/{$fabrica['id']}/lineas") ?>"
                               class="<?= $btnSecondary ?>" title="Líneas de esta fábrica">
                                <i class="fas fa-stream"></i> Líneas
                            </a>
                            <a href="<?= base_url("admin/fabricas/{$fabrica['id']}/editar") ?>"
                               class="<?= $btnSecondary ?>">
                                <i class="fas fa-pen"></i>
                            </a>
                            <button type="button" class="<?= $btnDanger ?>"
                                    onclick="confirmarEliminar(<?= $fabrica['id'] ?>, '<?= esc($fabrica['nombre']) ?>')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <form id="del-<?= $fabrica['id'] ?>" method="POST"
                              action="<?= base_url("admin/fabricas/{$fabrica['id']}/eliminar") ?>" class="hidden">
                            <?= csrf_field() ?>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
<div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.05)]">
    <div class="text-center py-16 px-8 text-gray-400">
        <i class="fas fa-industry text-5xl mb-4 block text-gray-300"></i>
        <h5 class="text-gray-700 font-semibold mb-2">No hay fábricas aún</h5>
        <p>Agregá fábricas para asociarlas a los productos de Muebles.</p>
        <a href="<?= base_url('admin/fabricas/crear') ?>" class="<?= $btnRojo ?> mt-4">
            <i class="fas fa-plus"></i> Crear fábrica
        </a>
    </div>
</div>
<?php endif; ?>

<script>
function filtrarTabla(q) {
    q = q.toLowerCase().trim();
    var rows = document.querySelectorAll('#tablaFabricas tbody tr');
    var vis  = 0;
    rows.forEach(function (r) {
        var show = !q || r.dataset.busqueda.includes(q);
        r.style.display = show ? '' : 'none';
        if (show) vis++;
    });
    document.getElementById('countVisible').textContent = vis + ' fábricas';
}

function confirmarEliminar(id, nombre) {
    Swal.fire({
        title: '¿Eliminar fábrica?',
        text: '"' + nombre + '" será eliminada permanentemente.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF0033',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then(function (result) {
        if (result.isConfirmed) {
            document.getElementById('del-' + id).submit();
        }
    });
}
</script>

<?= $this->endSection() ?>
