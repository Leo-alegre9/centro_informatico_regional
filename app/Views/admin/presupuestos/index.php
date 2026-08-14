<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<?php
$btnAccionBase = 'inline-flex items-center justify-center gap-1.5 rounded-lg px-3 py-2 text-[0.78rem] font-semibold transition-colors border whitespace-nowrap no-underline';
$btnSecondary  = $btnAccionBase . ' border-gray-200 text-gray-600 bg-white hover:border-gray-300 hover:bg-gray-50';
$btnInfo       = $btnAccionBase . ' border-blue-200 text-blue-600 bg-white hover:bg-blue-50';
$btnPdf        = $btnAccionBase . ' border-indigo-200 text-indigo-600 bg-white hover:bg-indigo-50';
$btnWhatsapp   = $btnAccionBase . ' border-transparent text-white bg-[#25D366] hover:bg-[#1ebe5a]';
$btnDanger     = $btnAccionBase . ' border-red-200 text-red-600 bg-white hover:bg-red-50';
$btnRojo       = 'bg-rojo hover:bg-rojo-dark text-white px-5 py-2.5 rounded-full text-sm font-semibold no-underline inline-flex items-center gap-2 transition-colors whitespace-nowrap';

$badgeEstado = [
    'borrador'  => 'bg-gray-100 text-gray-500',
    'generado'  => 'bg-blue-500/10 text-blue-600',
    'enviado'   => 'bg-violet-500/10 text-violet-600',
    'aceptado'  => 'bg-emerald-500/10 text-emerald-600',
    'rechazado' => 'bg-red-500/10 text-red-600',
];
$iconoEstado = [
    'borrador'  => 'fa-pen',
    'generado'  => 'fa-check-double',
    'enviado'   => 'fa-paper-plane',
    'aceptado'  => 'fa-check-circle',
    'rechazado' => 'fa-times-circle',
];
$estadoLabel = [
    'borrador'  => 'Borrador',
    'generado'  => 'Generado',
    'enviado'   => 'Enviado',
    'aceptado'  => 'Aceptado',
    'rechazado' => 'Rechazado',
];
$badgeTipo = [
    'presupuesto' => 'bg-blue-500/10 text-blue-600',
    'listado'     => 'bg-violet-500/10 text-violet-600',
];
$tipoLabel = [
    'presupuesto' => 'Presupuesto',
    'listado'     => 'Listado',
];
$btnOutline = 'border-[1.5px] border-gray-200 text-gray-600 hover:border-gray-300 hover:bg-gray-50 px-5 py-2.5 rounded-full text-sm font-semibold no-underline inline-flex items-center gap-2 transition-colors whitespace-nowrap bg-white';
?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-7">
    <div>
        <h2 class="text-[1.4rem] font-bold text-dark m-0"><i class="fas fa-file-invoice-dollar mr-2 text-rojo text-[1.1rem]"></i>Presupuestos</h2>
        <p class="text-gray-400 text-[0.85rem] mt-1">Armá presupuestos o listados de opciones para tus clientes con los productos del catálogo.</p>
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        <a href="<?= base_url('admin/presupuestos/crear?tipo=listado') ?>" class="<?= $btnOutline ?>">
            <i class="fas fa-th-large"></i> Nuevo listado
        </a>
        <a href="<?= base_url('admin/presupuestos/crear') ?>" class="<?= $btnRojo ?>">
            <i class="fas fa-plus"></i> Nuevo presupuesto
        </a>
    </div>
</div>

<?php if ($success = session()->getFlashdata('success')): ?>
<div class="bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-xl flex items-center gap-2 mb-5 px-4 py-3 text-sm">
    <i class="fas fa-check-circle"></i> <?= esc($success) ?>
</div>
<?php endif; ?>

<div class="bg-white border border-gray-100 rounded-2xl px-6 py-5 mb-6 shadow-[0_1px_3px_rgba(0,0,0,0.04)]">
    <form method="GET" action="<?= base_url('admin/presupuestos') ?>" class="flex items-end gap-3 flex-wrap">
        <div class="flex-1 min-w-[220px]">
            <label class="text-[0.72rem] font-bold uppercase tracking-wide text-gray-400 mb-1 block">Buscar</label>
            <input type="text" name="q" value="<?= esc($filtros['q']) ?>"
                   placeholder="Número, cliente o teléfono..."
                   class="w-full border-[1.5px] border-gray-200 rounded-lg px-4 py-2.5 text-[0.9rem] text-dark outline-none focus:border-rojo focus:ring-[3px] focus:ring-rojo/10 transition-colors">
        </div>
        <div>
            <label class="text-[0.72rem] font-bold uppercase tracking-wide text-gray-400 mb-1 block">Tipo</label>
            <select name="tipo" class="border-[1.5px] border-gray-200 rounded-lg px-3 py-2.5 text-[0.88rem] text-dark bg-white outline-none focus:border-rojo">
                <option value="">Todos</option>
                <?php foreach ($tipoLabel as $valor => $label): ?>
                    <option value="<?= esc($valor) ?>" <?= $filtros['tipo'] === $valor ? 'selected' : '' ?>><?= esc($label) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="text-[0.72rem] font-bold uppercase tracking-wide text-gray-400 mb-1 block">Estado</label>
            <select name="estado" class="border-[1.5px] border-gray-200 rounded-lg px-3 py-2.5 text-[0.88rem] text-dark bg-white outline-none focus:border-rojo">
                <option value="">Todos</option>
                <?php foreach ($estadoLabel as $valor => $label): ?>
                    <option value="<?= esc($valor) ?>" <?= $filtros['estado'] === $valor ? 'selected' : '' ?>><?= esc($label) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="<?= $btnRojo ?>"><i class="fas fa-filter"></i> Filtrar</button>
        <a href="<?= base_url('admin/presupuestos') ?>" class="<?= $btnSecondary ?> py-2.5">Limpiar</a>
    </form>
</div>

<?php if (!empty($presupuestos)): ?>
<div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-[0_1px_3px_rgba(0,0,0,0.04)]">
    <div class="overflow-x-auto">
        <table class="w-full text-[0.88rem] border-collapse">
            <thead>
                <tr>
                    <th class="bg-gray-50/70 text-gray-500 font-bold text-[0.72rem] uppercase tracking-wider border-b border-gray-100 px-5 py-3.5 whitespace-nowrap text-left">Número</th>
                    <th class="bg-gray-50/70 text-gray-500 font-bold text-[0.72rem] uppercase tracking-wider border-b border-gray-100 px-5 py-3.5 whitespace-nowrap text-left">Fecha</th>
                    <th class="bg-gray-50/70 text-gray-500 font-bold text-[0.72rem] uppercase tracking-wider border-b border-gray-100 px-5 py-3.5 whitespace-nowrap text-left">Cliente</th>
                    <th class="bg-gray-50/70 text-gray-500 font-bold text-[0.72rem] uppercase tracking-wider border-b border-gray-100 px-5 py-3.5 whitespace-nowrap text-left">Teléfono</th>
                    <th class="bg-gray-50/70 text-gray-500 font-bold text-[0.72rem] uppercase tracking-wider border-b border-gray-100 px-5 py-3.5 whitespace-nowrap text-center">Productos</th>
                    <th class="bg-gray-50/70 text-gray-500 font-bold text-[0.72rem] uppercase tracking-wider border-b border-gray-100 px-5 py-3.5 whitespace-nowrap text-left">Total</th>
                    <th class="bg-gray-50/70 text-gray-500 font-bold text-[0.72rem] uppercase tracking-wider border-b border-gray-100 px-5 py-3.5 whitespace-nowrap text-left">Estado</th>
                    <th class="bg-gray-50/70 text-gray-500 font-bold text-[0.72rem] uppercase tracking-wider border-b border-gray-100 px-5 py-3.5 whitespace-nowrap text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($presupuestos as $p): ?>
                <tr class="border-b border-gray-50 hover:bg-gray-50/60 transition-colors">
                    <td class="align-middle px-5 py-4">
                        <span class="font-mono font-bold text-dark text-[0.85rem] block"><?= esc($p['numero'] ?? '—') ?></span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[0.68rem] font-semibold mt-1 <?= $badgeTipo[$p['tipo']] ?? 'bg-gray-100 text-gray-500' ?>">
                            <?= esc($tipoLabel[$p['tipo']] ?? $p['tipo']) ?>
                        </span>
                    </td>
                    <td class="align-middle px-5 py-4 text-gray-600"><?= esc(date('d/m/Y', strtotime($p['fecha']))) ?></td>
                    <td class="align-middle px-5 py-4">
                        <div class="font-semibold text-dark"><?= esc($p['cliente_nombre']) ?></div>
                    </td>
                    <td class="align-middle px-5 py-4 text-gray-600"><?= esc($p['cliente_telefono']) ?></td>
                    <td class="align-middle px-5 py-4 text-center">
                        <span class="bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full text-xs font-semibold"><?= (int) $p['cantidad_items'] ?></span>
                    </td>
                    <td class="align-middle px-5 py-4 font-bold text-dark whitespace-nowrap">
                        <?php if ($p['tipo'] === 'listado'): ?>
                            <span class="text-gray-300 font-normal italic text-[0.82rem]">Sin total</span>
                        <?php else: ?>
                            $<?= number_format((float) $p['total'], 0, ',', '.') ?>
                        <?php endif; ?>
                    </td>
                    <td class="align-middle px-5 py-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold <?= $badgeEstado[$p['estado']] ?? 'bg-gray-100 text-gray-500' ?>">
                            <i class="fas <?= $iconoEstado[$p['estado']] ?? 'fa-circle' ?>"></i>
                            <?= esc($estadoLabel[$p['estado']] ?? $p['estado']) ?>
                        </span>
                    </td>
                    <td class="align-middle px-5 py-4">
                        <div class="flex items-center gap-1.5">
                            <a href="<?= base_url("admin/presupuestos/{$p['id']}/ver") ?>" class="<?= $btnInfo ?>" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?= base_url("admin/presupuestos/{$p['id']}/editar") ?>" class="<?= $btnSecondary ?>" title="Editar">
                                <i class="fas fa-pen"></i>
                            </a>
                            <a href="<?= base_url("admin/presupuestos/{$p['id']}/pdf") ?>" class="<?= $btnPdf ?>" title="Descargar PDF">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            <button type="button" class="<?= $btnDanger ?>" title="Eliminar"
                                    onclick="confirmarEliminarPresupuesto(<?= (int) $p['id'] ?>, '<?= esc($p['numero'] ?? '') ?>')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <form id="del-<?= (int) $p['id'] ?>" method="POST" action="<?= base_url("admin/presupuestos/{$p['id']}/eliminar") ?>" class="hidden">
                            <?= csrf_field() ?>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->include('componentes/paginador') ?>

<?php else: ?>
<div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-[0_1px_3px_rgba(0,0,0,0.04)]">
    <div class="text-center py-16 px-8 text-gray-400">
        <i class="fas fa-file-invoice-dollar text-5xl mb-4 block text-gray-300"></i>
        <h5 class="text-gray-700 font-semibold mb-2">Todavía no hay presupuestos</h5>
        <p class="text-[0.9rem] mb-4">Creá el primero para empezar a cotizar productos del catálogo a tus clientes.</p>
        <a href="<?= base_url('admin/presupuestos/crear') ?>" class="<?= $btnRojo ?> inline-flex">
            <i class="fas fa-plus"></i> Nuevo presupuesto
        </a>
    </div>
</div>
<?php endif; ?>

<script>
function confirmarEliminarPresupuesto(id, numero) {
    Swal.fire({
        title: '¿Eliminar presupuesto?',
        html: 'El presupuesto <strong>' + (numero || '#' + id) + '</strong> se va a eliminar. Esta acción no se puede deshacer.',
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
