<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<?php
$badgeActivo   = 'bg-emerald-500/10 text-emerald-600 px-[0.6rem] py-[0.2rem] rounded-full text-xs font-semibold';
$badgeInactivo = 'bg-red-500/10 text-red-600 px-[0.6rem] py-[0.2rem] rounded-full text-xs font-semibold';
$btnAccionBase = 'inline-flex items-center justify-center rounded-[7px] px-[0.7rem] py-[0.3rem] text-[0.78rem] font-semibold transition-colors border';
$btnSecondary  = $btnAccionBase . ' border-gray-300 text-gray-600 bg-white hover:bg-gray-100';
$btnDanger     = $btnAccionBase . ' border-red-400 text-red-600 bg-white hover:bg-red-50';
$btnRojo       = 'bg-rojo hover:bg-rojo-dark text-white px-5 py-[0.55rem] rounded-full text-sm font-semibold no-underline inline-flex items-center gap-[0.4rem] transition-colors whitespace-nowrap';
?>

<div class="flex items-center gap-3 mb-1">
    <a href="<?= base_url('admin/fabricas') ?>" class="text-gray-500 hover:text-rojo no-underline flex items-center gap-[0.3rem] transition-colors">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h2 class="text-[1.4rem] font-bold text-dark m-0"><i class="fas fa-stream mr-2 text-rojo text-[1.1rem]"></i>Líneas de <?= esc($fabrica['nombre']) ?></h2>
</div>
<p class="text-gray-400 text-[0.85rem] mb-6 ml-[1.9rem]">Las líneas permiten agrupar los muebles de esta fábrica (ej: Clásica, Moderna, Premium).</p>

<?php if ($success = session()->getFlashdata('success')): ?>
<div class="bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-[10px] flex items-center gap-2 mb-4 px-4 py-3 text-sm">
    <i class="fas fa-check-circle"></i> <?= esc($success) ?>
</div>
<?php endif; ?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-5">
    <a href="<?= base_url("admin/fabricas/{$fabrica['id']}/lineas/crear") ?>" class="<?= $btnRojo ?>">
        <i class="fas fa-plus"></i> Nueva línea
    </a>
    <span class="bg-rojo/10 text-rojo rounded-full px-[0.7rem] py-[0.2rem] text-[0.8rem] font-semibold"><?= count($lineas) ?> líneas</span>
</div>

<?php if (!empty($lineas)): ?>
<div class="bg-white border border-gray-200 rounded-[14px] overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.05)]">
    <div class="overflow-x-auto">
        <table class="w-full text-[0.88rem] border-collapse">
            <thead>
                <tr>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-[0.5px] border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Nombre</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-[0.5px] border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Slug</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-[0.5px] border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Estado</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-[0.5px] border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lineas as $linea): ?>
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="align-middle px-4 py-3"><strong class="text-dark"><?= esc($linea['nombre']) ?></strong></td>
                    <td class="align-middle px-4 py-3"><code class="text-[0.78rem] text-gray-700"><?= esc($linea['slug']) ?></code></td>
                    <td class="align-middle px-4 py-3">
                        <span class="<?= $linea['activo'] ? $badgeActivo : $badgeInactivo ?>">
                            <?= $linea['activo'] ? 'Activa' : 'Inactiva' ?>
                        </span>
                    </td>
                    <td class="align-middle px-4 py-3">
                        <div class="flex items-center gap-1">
                            <a href="<?= base_url("admin/fabricas/{$fabrica['id']}/lineas/{$linea['id']}/editar") ?>"
                               class="<?= $btnSecondary ?>">
                                <i class="fas fa-pen"></i>
                            </a>
                            <button type="button" class="<?= $btnDanger ?>"
                                    onclick="confirmarEliminar(<?= $linea['id'] ?>, '<?= esc($linea['nombre']) ?>')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <form id="del-<?= $linea['id'] ?>" method="POST"
                              action="<?= base_url("admin/fabricas/{$fabrica['id']}/lineas/{$linea['id']}/eliminar") ?>" class="hidden">
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
<div class="bg-white border border-gray-200 rounded-[14px] overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.05)]">
    <div class="text-center py-16 px-8 text-gray-400">
        <i class="fas fa-stream text-5xl mb-4 block text-gray-300"></i>
        <h5 class="text-gray-700 font-semibold mb-2">Esta fábrica todavía no tiene líneas</h5>
        <p>Las líneas son opcionales: agregalas si querés distinguir distintas colecciones de muebles de <?= esc($fabrica['nombre']) ?>.</p>
        <a href="<?= base_url("admin/fabricas/{$fabrica['id']}/lineas/crear") ?>" class="<?= $btnRojo ?> mt-4">
            <i class="fas fa-plus"></i> Crear línea
        </a>
    </div>
</div>
<?php endif; ?>

<script>
function confirmarEliminar(id, nombre) {
    Swal.fire({
        title: '¿Eliminar línea?',
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
