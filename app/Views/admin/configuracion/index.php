<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<?php
$inputCls = 'border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark transition-colors focus:border-rojo focus:ring-[3px] focus:ring-rojo/10 focus:outline-none w-full';
?>

<div class="flex items-center gap-3 mb-6">
    <h2 class="text-[1.35rem] font-bold text-dark m-0">
        <i class="fas fa-sliders mr-2 text-rojo text-[1.05rem]"></i>
        Configuración de precios
    </h2>
</div>

<?php $errors = session()->getFlashdata('errors'); ?>
<?php if ($errors): ?>
<div class="bg-rojo/5 border border-rojo/20 rounded-[10px] px-5 py-4 mb-4 text-[0.88rem] text-red-600">
    <strong><i class="fas fa-exclamation-triangle mr-1"></i>Corregí los siguientes errores:</strong>
    <ul class="mt-2 pl-5 list-disc"><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
</div>
<?php endif; ?>

<?php $success = session()->getFlashdata('success'); ?>
<?php if ($success): ?>
<div class="bg-emerald-500/[0.07] border border-emerald-500/25 rounded-[10px] px-5 py-[0.9rem] mb-5 text-emerald-800 text-[0.9rem] flex items-center gap-[0.6rem]">
    <i class="fas fa-check-circle text-emerald-500"></i>
    <?= esc($success) ?>
</div>
<?php endif; ?>

<div class="flex flex-wrap gap-6">

    <!-- ── Columna izquierda: formulario ── -->
    <div class="w-full lg:w-5/12">
        <div class="bg-white border border-gray-200 rounded-[14px] p-8 shadow-[0_1px_4px_rgba(0,0,0,0.05)]">
            <div class="text-[0.72rem] font-bold uppercase tracking-[0.9px] text-gray-400 mb-4 pb-2 border-b border-gray-100">
                <i class="fas fa-dollar-sign mr-1"></i>Cotización y ganancia
            </div>

            <div class="bg-blue-500/[0.06] border border-blue-500/20 rounded-[9px] px-4 py-3 text-[0.82rem] text-blue-800 flex items-start gap-2 mb-5">
                <i class="fas fa-info-circle mt-px shrink-0"></i>
                <span>
                    Al guardar, se recalculará automáticamente el precio en pesos de todos los
                    productos que tengan precio en dólares cargado.
                </span>
            </div>

            <form action="<?= base_url('admin/configuracion/guardar') ?>" method="POST" id="formConfig">

                <div class="mb-6">
                    <label for="cotizacion_dolar" class="block text-[0.85rem] font-semibold text-gray-700 mb-[0.3rem]">
                        Cotización del dólar <span class="text-rojo">*</span>
                    </label>
                    <div class="flex">
                        <span class="bg-gray-50 border-[1.5px] border-gray-200 border-r-0 rounded-l-[9px] px-[0.85rem] py-[0.6rem] text-[0.9rem] font-semibold text-gray-500">$</span>
                        <input type="number" id="cotizacion_dolar" name="cotizacion_dolar"
                               class="<?= $inputCls ?> rounded-none"
                               value="<?= esc($cotizacion_dolar > 0 ? $cotizacion_dolar : '') ?>"
                               min="0" step="0.01"
                               placeholder="Ej: 1250.00"
                               oninput="actualizarPreview()"
                               required>
                        <span class="bg-gray-50 border-[1.5px] border-gray-200 border-l-0 rounded-r-[9px] px-[0.85rem] py-[0.6rem] text-[0.9rem] font-semibold text-gray-500 whitespace-nowrap">ARS / USD</span>
                    </div>
                    <div class="text-xs text-gray-400 mt-[0.3rem]">Precio en pesos de 1 dólar.</div>
                </div>

                <div class="mb-6">
                    <label for="porcentaje_ganancia" class="block text-[0.85rem] font-semibold text-gray-700 mb-[0.3rem]">
                        Porcentaje de ganancia <span class="text-rojo">*</span>
                    </label>
                    <div class="flex">
                        <input type="number" id="porcentaje_ganancia" name="porcentaje_ganancia"
                               class="<?= $inputCls ?> rounded-r-none"
                               value="<?= esc($porcentaje_ganancia >= 0 ? $porcentaje_ganancia : '') ?>"
                               min="0" max="999" step="0.1"
                               placeholder="Ej: 30"
                               oninput="actualizarPreview()"
                               required>
                        <span class="bg-gray-50 border-[1.5px] border-gray-200 border-l-0 rounded-r-[9px] px-[0.85rem] py-[0.6rem] text-[0.9rem] font-semibold text-gray-500">%</span>
                    </div>
                    <div class="text-xs text-gray-400 mt-[0.3rem]">Porcentaje de ganancia del negocio sobre el costo en dólares.</div>
                </div>

                <!-- Preview del cálculo -->
                <div class="bg-gradient-to-br from-red-50 to-white border-[1.5px] border-rojo/20 rounded-xl px-6 py-5 mb-6">
                    <div class="text-[0.78rem] font-bold uppercase tracking-[0.8px] text-rojo mb-[0.9rem] flex items-center gap-[0.4rem]">
                        <i class="fas fa-calculator"></i>
                        Ejemplo de cálculo (producto a USD <span id="prev-ej-usd">100</span>)
                    </div>
                    <div class="text-[0.88rem] text-gray-700 leading-[1.7]">
                        USD <span class="font-bold text-dark bg-rojo/[0.07] rounded px-[6px] py-px" id="prev-usd">100</span>
                        × $<span class="font-bold text-dark bg-rojo/[0.07] rounded px-[6px] py-px" id="prev-cotiz"><?= number_format($cotizacion_dolar, 2, ',', '.') ?></span>
                        × (1 + <span class="font-bold text-dark bg-rojo/[0.07] rounded px-[6px] py-px" id="prev-porc"><?= number_format($porcentaje_ganancia, 1, ',', '.') ?></span>%)
                    </div>
                    <div class="text-[1.35rem] font-extrabold text-rojo mt-[0.6rem] flex items-baseline gap-[0.4rem]">
                        <span id="prev-resultado">
                            <?php
                                $ejemplo = 100 * $cotizacion_dolar * (1 + $porcentaje_ganancia / 100);
                                echo '$' . number_format(round($ejemplo), 0, ',', '.');
                            ?>
                        </span>
                        <span class="text-xs font-medium text-gray-400">precio final estimado</span>
                    </div>
                </div>

                <button type="submit" class="bg-rojo hover:bg-rojo-dark text-white px-8 py-[0.72rem] rounded-full text-[0.95rem] font-semibold inline-flex items-center gap-[0.45rem] cursor-pointer transition-all hover:-translate-y-px active:translate-y-0">
                    <i class="fas fa-save"></i> Guardar y recalcular precios
                </button>

            </form>
        </div>
    </div>

    <!-- ── Columna derecha: tabla de productos afectados ── -->
    <div class="w-full lg:w-7/12">
        <div class="bg-white border border-gray-200 rounded-[14px] p-8 shadow-[0_1px_4px_rgba(0,0,0,0.05)]">
            <div class="text-[0.72rem] font-bold uppercase tracking-[0.9px] text-gray-400 mb-4 pb-2 border-b border-gray-100">
                <i class="fas fa-box mr-1"></i>
                Productos con precio en dólares
                <?php if (!empty($productosConDolar)): ?>
                <span class="bg-rojo/10 text-rojo text-[0.68rem] px-2 py-px rounded-full ml-[6px] font-bold">
                    <?= count($productosConDolar) ?>
                </span>
                <?php endif; ?>
            </div>

            <?php if (empty($productosConDolar)): ?>
            <div class="text-center py-10 px-4 text-gray-400">
                <i class="fas fa-dollar-sign text-[2.5rem] block mb-3 text-gray-200"></i>
                <p class="text-[0.88rem]">Ningún producto tiene precio en dólares cargado aún.<br>
                Editá un producto y completá el campo <strong>Precio en USD</strong>.</p>
            </div>
            <?php else: ?>
            <div class="overflow-x-auto mt-2 rounded-[10px] border border-gray-200">
                <table class="w-full border-collapse text-[0.88rem]">
                    <thead>
                        <tr>
                            <th class="bg-gray-50 text-gray-500 text-xs font-bold uppercase tracking-[0.5px] px-4 py-[0.65rem] border-b border-gray-200 whitespace-nowrap text-left">Producto</th>
                            <th class="bg-gray-50 text-gray-500 text-xs font-bold uppercase tracking-[0.5px] px-4 py-[0.65rem] border-b border-gray-200 whitespace-nowrap text-left">Precio USD</th>
                            <th class="bg-gray-50 text-gray-500 text-xs font-bold uppercase tracking-[0.5px] px-4 py-[0.65rem] border-b border-gray-200 whitespace-nowrap text-left">Precio actual (ARS)</th>
                            <th class="bg-gray-50 text-gray-500 text-xs font-bold uppercase tracking-[0.5px] px-4 py-[0.65rem] border-b border-gray-200 whitespace-nowrap text-left">Precio nuevo estimado</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-productos">
                        <?php foreach ($productosConDolar as $p): ?>
                        <tr class="border-b border-gray-100 last:border-b-0 hover:bg-gray-50" data-usd="<?= esc($p['precio_dolar']) ?>">
                            <td class="px-4 py-[0.65rem] align-middle">
                                <div class="font-semibold text-dark leading-[1.3]">
                                    <?= esc($p['nombre']) ?>
                                </div>
                                <?php if ($p['modelo']): ?>
                                <div class="text-[0.75rem] text-gray-400"><?= esc($p['modelo']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-[0.65rem] align-middle font-semibold text-emerald-600 whitespace-nowrap">
                                USD <?= number_format((float)$p['precio_dolar'], 2, ',', '.') ?>
                            </td>
                            <td class="px-4 py-[0.65rem] align-middle">
                                <?php if ($p['precio_texto']): ?>
                                <span class="font-bold text-rojo whitespace-nowrap"><?= esc($p['precio_texto']) ?></span>
                                <?php else: ?>
                                <span class="text-gray-300 italic">Sin precio</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-[0.65rem] align-middle font-bold text-rojo whitespace-nowrap">
                                <?php
                                    $nuevo = (float)$p['precio_dolar'] * $cotizacion_dolar * (1 + $porcentaje_ganancia / 100);
                                    echo $cotizacion_dolar > 0
                                        ? '$' . number_format(round($nuevo), 0, ',', '.')
                                        : '—';
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<script>
function actualizarPreview() {
    const cotiz = parseFloat(document.getElementById('cotizacion_dolar').value)   || 0;
    const porc  = parseFloat(document.getElementById('porcentaje_ganancia').value) || 0;
    const ejemploUsd = 100;

    // Actualizar textos de fórmula
    document.getElementById('prev-cotiz').textContent = cotiz.toLocaleString('es-AR', {minimumFractionDigits:2, maximumFractionDigits:2});
    document.getElementById('prev-porc').textContent  = porc.toLocaleString('es-AR', {minimumFractionDigits:1, maximumFractionDigits:1});

    // Resultado del ejemplo
    const resultado = ejemploUsd * cotiz * (1 + porc / 100);
    document.getElementById('prev-resultado').textContent = '$' + Math.round(resultado).toLocaleString('es-AR');

    // Actualizar tabla de productos
    document.querySelectorAll('#tabla-productos tr[data-usd]').forEach(function (tr) {
        const usd = parseFloat(tr.dataset.usd) || 0;
        const nuevoCell = tr.querySelectorAll('td')[3];
        if (nuevoCell) {
            if (cotiz > 0 && usd > 0) {
                const nuevo = usd * cotiz * (1 + porc / 100);
                nuevoCell.textContent = '$' + Math.round(nuevo).toLocaleString('es-AR');
            } else {
                nuevoCell.textContent = '—';
            }
        }
    });
}
</script>

<?php if (session()->getFlashdata('success')): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: '¡Listo!',
            text: '<?= addslashes(session()->getFlashdata('success') ?? '') ?>',
            confirmButtonColor: '#FF0033',
            confirmButtonText: 'Aceptar',
            timer: 4000,
            timerProgressBar: true,
        });
    });
</script>
<?php endif; ?>

<?= $this->endSection() ?>
