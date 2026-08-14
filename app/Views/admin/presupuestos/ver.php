<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<?php
$btnRojo     = 'bg-rojo hover:bg-rojo-dark text-white px-5 py-2.5 rounded-full text-sm font-semibold no-underline inline-flex items-center gap-2 transition-colors whitespace-nowrap';
$btnOutline  = 'border-[1.5px] border-gray-200 text-gray-600 hover:border-gray-300 hover:bg-gray-50 px-5 py-2.5 rounded-full text-sm font-semibold no-underline inline-flex items-center gap-2 transition-colors whitespace-nowrap bg-white';
$btnWhatsapp = 'bg-[#25D366] hover:bg-[#1ebe5a] text-white px-5 py-2.5 rounded-full text-sm font-semibold no-underline inline-flex items-center gap-2 transition-colors whitespace-nowrap';

$badgeEstado = [
    'borrador'  => 'bg-gray-100 text-gray-500',
    'generado'  => 'bg-blue-500/10 text-blue-600',
    'enviado'   => 'bg-violet-500/10 text-violet-600',
    'aceptado'  => 'bg-emerald-500/10 text-emerald-600',
    'rechazado' => 'bg-red-500/10 text-red-600',
];
$estadoLabel = [
    'borrador'  => 'Borrador',
    'generado'  => 'Generado',
    'enviado'   => 'Enviado',
    'aceptado'  => 'Aceptado',
    'rechazado' => 'Rechazado',
];

$esListado = $presupuesto['tipo'] === 'listado';
?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
    <div class="flex items-center gap-3">
        <a href="<?= base_url('admin/presupuestos') ?>" class="text-gray-500 hover:text-rojo no-underline transition-colors">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="text-[1.4rem] font-bold text-dark m-0"><?= $esListado ? 'Listado' : 'Presupuesto' ?> <?= esc($presupuesto['numero']) ?></h2>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold mt-1 <?= $badgeEstado[$presupuesto['estado']] ?? 'bg-gray-100 text-gray-500' ?>">
                <?= esc($estadoLabel[$presupuesto['estado']] ?? $presupuesto['estado']) ?>
            </span>
        </div>
    </div>

    <div class="flex items-center gap-2 flex-wrap">
        <form method="POST" action="<?= base_url("admin/presupuestos/{$presupuesto['id']}/estado") ?>" class="flex items-center gap-2">
            <?= csrf_field() ?>
            <select name="estado" onchange="this.form.submit()"
                    class="border-[1.5px] border-gray-200 rounded-full pl-4 pr-8 py-2.5 text-[0.85rem] font-semibold bg-white outline-none focus:border-rojo">
                <?php foreach ($estados as $e): ?>
                    <option value="<?= esc($e) ?>" <?= $presupuesto['estado'] === $e ? 'selected' : '' ?>><?= esc($estadoLabel[$e] ?? $e) ?></option>
                <?php endforeach; ?>
            </select>
        </form>
        <a href="<?= base_url("admin/presupuestos/{$presupuesto['id']}/editar") ?>" class="<?= $btnOutline ?>">
            <i class="fas fa-pen"></i> Editar
        </a>
        <a href="<?= esc($urlPublica) ?>" target="_blank" rel="noopener" class="<?= $btnOutline ?>">
            <i class="fas fa-arrow-up-right-from-square"></i> Ver página pública
        </a>
        <a href="<?= base_url("admin/presupuestos/{$presupuesto['id']}/pdf") ?>" class="<?= $btnOutline ?>">
            <i class="fas fa-file-pdf"></i> Descargar PDF
        </a>
        <a href="<?= esc($waHref) ?>" target="_blank" rel="noopener" class="<?= $btnWhatsapp ?>">
            <i class="fab fa-whatsapp"></i> Compartir por WhatsApp
        </a>
    </div>
</div>

<?php if ($success = session()->getFlashdata('success')): ?>
<div class="bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-xl flex items-center gap-2 mb-5 px-4 py-3 text-sm">
    <i class="fas fa-check-circle"></i> <?= esc($success) ?>
</div>
<?php endif; ?>

<!-- Documento -->
<div class="bg-white border border-gray-100 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.04)] p-8 sm:p-10 max-w-4xl mx-auto">

    <div class="flex items-start justify-between flex-wrap gap-4 pb-6 mb-6 border-b border-gray-100">
        <div class="flex items-center gap-3">
            <img src="<?= base_url('assets/img/logo_sinfondo.png') ?>" alt="CIR" class="h-14 w-auto object-contain">
            <div>
                <div class="font-extrabold text-dark text-[1.05rem] leading-tight">Centro Informático Regional</div>
                <div class="text-gray-400 text-[0.8rem] mt-0.5">Sarmiento 177, El Colorado, Formosa</div>
                <div class="text-gray-400 text-[0.8rem]">(+54) 370 461-6482</div>
            </div>
        </div>
        <div class="text-right">
            <div class="text-[0.72rem] font-bold uppercase tracking-wider text-gray-400"><?= $esListado ? 'Listado de opciones' : 'Presupuesto' ?></div>
            <div class="text-[1.3rem] font-extrabold text-rojo font-mono"><?= esc($presupuesto['numero']) ?></div>
            <div class="text-gray-500 text-[0.82rem] mt-1">Fecha: <?= esc(date('d/m/Y', strtotime($presupuesto['fecha']))) ?></div>
            <?php if (!empty($presupuesto['valido_hasta'])): ?>
            <div class="text-gray-500 text-[0.82rem]">Válido hasta: <?= esc(date('d/m/Y', strtotime($presupuesto['valido_hasta']))) ?></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8 text-[0.88rem]">
        <div>
            <div class="text-[0.7rem] font-bold uppercase tracking-wider text-gray-400 mb-1">Cliente</div>
            <div class="font-semibold text-dark"><?= esc($presupuesto['cliente_nombre']) ?></div>
            <?php if (!empty($presupuesto['cliente_documento'])): ?><div class="text-gray-500">DNI/CUIT: <?= esc($presupuesto['cliente_documento']) ?></div><?php endif; ?>
        </div>
        <div>
            <div class="text-[0.7rem] font-bold uppercase tracking-wider text-gray-400 mb-1">Contacto</div>
            <div class="text-gray-600"><?= esc($presupuesto['cliente_telefono']) ?></div>
            <?php if (!empty($presupuesto['cliente_email'])): ?><div class="text-gray-600"><?= esc($presupuesto['cliente_email']) ?></div><?php endif; ?>
        </div>
    </div>

    <div class="overflow-x-auto rounded-xl border border-gray-100 mb-6">
        <table class="w-full text-[0.86rem] border-collapse">
            <thead>
                <tr>
                    <th class="bg-gray-50/70 text-gray-500 text-[0.7rem] font-bold uppercase tracking-wider px-4 py-3 text-left border-b border-gray-100 w-[70px]">Img.</th>
                    <th class="bg-gray-50/70 text-gray-500 text-[0.7rem] font-bold uppercase tracking-wider px-4 py-3 text-left border-b border-gray-100">Producto</th>
                    <th class="bg-gray-50/70 text-gray-500 text-[0.7rem] font-bold uppercase tracking-wider px-4 py-3 text-right border-b border-gray-100">Precio</th>
                    <?php if (!$esListado): ?>
                    <th class="bg-gray-50/70 text-gray-500 text-[0.7rem] font-bold uppercase tracking-wider px-4 py-3 text-center border-b border-gray-100">Cant.</th>
                    <th class="bg-gray-50/70 text-gray-500 text-[0.7rem] font-bold uppercase tracking-wider px-4 py-3 text-right border-b border-gray-100">Subtotal</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($presupuesto['detalles'] as $d): ?>
                <tr class="border-b border-gray-50 last:border-b-0">
                    <td class="px-4 py-3 align-middle">
                        <div class="w-14 h-14 rounded-lg border border-gray-100 bg-white flex items-center justify-center overflow-hidden shrink-0">
                            <?php if (!empty($d['imagen_ruta'])): ?>
                                <img src="<?= base_url(esc($d['imagen_ruta'])) ?>" alt="" loading="lazy" class="max-w-full max-h-full object-contain">
                            <?php else: ?>
                                <i class="fas fa-image text-gray-300 text-sm"></i>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="px-4 py-3 align-middle">
                        <div class="font-semibold text-dark"><?= esc($d['producto_nombre']) ?></div>
                        <?php if (!empty($d['producto_codigo'])): ?><div class="text-[0.75rem] text-gray-400 font-mono"><?= esc($d['producto_codigo']) ?></div><?php endif; ?>
                    </td>
                    <td class="px-4 py-3 align-middle text-right text-gray-600">$<?= number_format((float) $d['precio_unitario'], 0, ',', '.') ?></td>
                    <?php if (!$esListado): ?>
                    <td class="px-4 py-3 align-middle text-center text-gray-600"><?= (int) $d['cantidad'] ?></td>
                    <td class="px-4 py-3 align-middle text-right font-bold text-dark">$<?= number_format((float) $d['subtotal'], 0, ',', '.') ?></td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if (!$esListado): ?>
    <div class="flex justify-end mb-8">
        <div class="w-full sm:w-72 flex flex-col gap-2 text-[0.9rem]">
            <div class="flex justify-between text-gray-500">
                <span>Subtotal</span><span class="font-semibold text-dark">$<?= number_format((float) $presupuesto['subtotal'], 0, ',', '.') ?></span>
            </div>
            <div class="flex justify-between text-gray-500">
                <span>Descuento<?= $presupuesto['descuento_tipo'] === 'porcentaje' ? ' (' . rtrim(rtrim(number_format((float) $presupuesto['descuento_valor'], 2, ',', '.'), '0'), ',') . '%)' : '' ?></span>
                <span class="font-semibold text-dark">-$<?= number_format((float) $presupuesto['descuento_monto'], 0, ',', '.') ?></span>
            </div>
            <div class="flex justify-between items-baseline pt-3 mt-1 border-t border-gray-100">
                <span class="font-bold text-dark">Total</span>
                <span class="text-[1.4rem] font-extrabold text-rojo">$<?= number_format((float) $presupuesto['total'], 0, ',', '.') ?></span>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($presupuesto['observaciones'])): ?>
    <div class="mb-5">
        <div class="text-[0.7rem] font-bold uppercase tracking-wider text-gray-400 mb-1.5">Observaciones</div>
        <p class="text-gray-600 text-[0.88rem] whitespace-pre-line"><?= esc($presupuesto['observaciones']) ?></p>
    </div>
    <?php endif; ?>

    <?php if (!empty($presupuesto['condiciones'])): ?>
    <div>
        <div class="text-[0.7rem] font-bold uppercase tracking-wider text-gray-400 mb-1.5">Condiciones comerciales</div>
        <p class="text-gray-600 text-[0.88rem] whitespace-pre-line"><?= esc($presupuesto['condiciones']) ?></p>
    </div>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>
