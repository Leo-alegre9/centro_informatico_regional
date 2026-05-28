<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<style>
    .config-card {
        background: #fff; border: 1px solid #e5e7eb; border-radius: 14px;
        padding: 2rem; box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }
    .form-section-title {
        font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.9px;
        color: #9CA3AF; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f3f4f6;
    }
    .form-label { font-size: 0.85rem; font-weight: 600; color: #374151; margin-bottom: 0.3rem; }
    .form-control {
        border: 1.5px solid #e5e7eb; border-radius: 9px; padding: 0.6rem 0.95rem;
        font-size: 0.92rem; color: #111827; transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus {
        border-color: #FF0033; box-shadow: 0 0 0 3px rgba(255,0,51,0.1); outline: none;
    }
    .field-hint { font-size: 0.75rem; color: #9CA3AF; margin-top: 0.3rem; }
    .input-prefix {
        background: #f9fafb; border: 1.5px solid #e5e7eb; border-right: none;
        border-radius: 9px 0 0 9px; padding: 0.6rem 0.85rem;
        font-size: 0.9rem; font-weight: 600; color: #6B7280;
    }
    .input-suffix {
        background: #f9fafb; border: 1.5px solid #e5e7eb; border-left: none;
        border-radius: 0 9px 9px 0; padding: 0.6rem 0.85rem;
        font-size: 0.9rem; font-weight: 600; color: #6B7280;
    }
    .input-group .form-control { border-radius: 0; }

    /* ── Caja de preview del cálculo ── */
    .calc-preview {
        background: linear-gradient(135deg, #fff5f5 0%, #fff 100%);
        border: 1.5px solid rgba(255,0,51,0.2); border-radius: 12px;
        padding: 1.25rem 1.5rem;
    }
    .calc-preview .calc-titulo {
        font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px;
        color: #FF0033; margin-bottom: 0.9rem; display: flex; align-items: center; gap: 0.4rem;
    }
    .calc-formula {
        font-size: 0.88rem; color: #374151; line-height: 1.7;
    }
    .calc-formula .val {
        font-weight: 700; color: #111827;
        background: rgba(255,0,51,0.07); border-radius: 4px; padding: 1px 6px;
    }
    .calc-result {
        font-size: 1.35rem; font-weight: 800; color: #FF0033; margin-top: 0.6rem;
        display: flex; align-items: baseline; gap: 0.4rem;
    }
    .calc-result .ejemplo-label {
        font-size: 0.75rem; font-weight: 500; color: #9CA3AF;
    }

    /* ── Tabla de productos ── */
    .productos-table-wrap {
        overflow-x: auto; margin-top: 0.5rem; border-radius: 10px;
        border: 1px solid #e5e7eb;
    }
    .productos-table {
        width: 100%; border-collapse: collapse; font-size: 0.88rem;
    }
    .productos-table th {
        background: #f9fafb; color: #6B7280; font-size: 0.75rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.5px; padding: 0.65rem 1rem;
        border-bottom: 1px solid #e5e7eb; white-space: nowrap;
    }
    .productos-table td {
        padding: 0.65rem 1rem; border-bottom: 1px solid #f3f4f6; color: #374151; vertical-align: middle;
    }
    .productos-table tr:last-child td { border-bottom: none; }
    .productos-table tr:hover td { background: #fafafa; }
    .precio-usd {
        font-weight: 600; color: #059669; white-space: nowrap;
    }
    .precio-ars {
        font-weight: 700; color: #FF0033; white-space: nowrap;
    }
    .precio-nuevo {
        font-weight: 700; color: #FF0033; white-space: nowrap;
    }
    .sin-precio { color: #D1D5DB; font-style: italic; }

    .btn-guardar {
        background: #FF0033; color: #fff; border: none; padding: 0.72rem 2rem;
        border-radius: 50px; font-size: 0.95rem; font-weight: 600;
        display: inline-flex; align-items: center; gap: 0.45rem; cursor: pointer;
        transition: background 0.2s, transform 0.1s;
    }
    .btn-guardar:hover { background: #cc0028; transform: translateY(-1px); }
    .btn-guardar:active { transform: translateY(0); }

    .page-header-row { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem; }
    .page-header-row h2 { font-size: 1.35rem; font-weight: 700; color: #111827; margin: 0; }
    .errors-box {
        background: rgba(255,0,51,0.05); border: 1px solid rgba(255,0,51,0.2); border-radius: 10px;
        padding: 1rem 1.25rem; margin-bottom: 1.5rem; font-size: 0.88rem; color: #DC2626;
    }
    .errors-box ul { margin: 0.5rem 0 0; padding-left: 1.2rem; }
    .alert-success {
        background: rgba(16,185,129,0.07); border: 1px solid rgba(16,185,129,0.25);
        border-radius: 10px; padding: 0.9rem 1.25rem; margin-bottom: 1.25rem;
        color: #065f46; font-size: 0.9rem; display: flex; align-items: center; gap: 0.6rem;
    }
    .info-box {
        background: rgba(59,130,246,0.06); border: 1px solid rgba(59,130,246,0.2);
        border-radius: 9px; padding: 0.75rem 1rem; font-size: 0.82rem; color: #1e40af;
        display: flex; align-items: flex-start; gap: 0.5rem; margin-bottom: 1.25rem;
    }
    .info-box i { margin-top: 1px; flex-shrink: 0; }

    .empty-state { text-align: center; padding: 2.5rem 1rem; color: #9CA3AF; }
    .empty-state i { font-size: 2.5rem; display: block; margin-bottom: 0.75rem; color: #E5E7EB; }
    .empty-state p { font-size: 0.88rem; }
</style>

<div class="page-header-row">
    <h2>
        <i class="fas fa-sliders me-2" style="color:#FF0033;font-size:1.05rem;"></i>
        Configuración de precios
    </h2>
</div>

<?php $errors = session()->getFlashdata('errors'); ?>
<?php if ($errors): ?>
<div class="errors-box mb-3">
    <strong><i class="fas fa-exclamation-triangle me-1"></i>Corregí los siguientes errores:</strong>
    <ul><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
</div>
<?php endif; ?>

<?php $success = session()->getFlashdata('success'); ?>
<?php if ($success): ?>
<div class="alert-success">
    <i class="fas fa-check-circle" style="color:#10b981;"></i>
    <?= esc($success) ?>
</div>
<?php endif; ?>

<div class="row g-4">

    <!-- ── Columna izquierda: formulario ── -->
    <div class="col-12 col-lg-5">
        <div class="config-card">
            <div class="form-section-title">
                <i class="fas fa-dollar-sign me-1"></i>Cotización y ganancia
            </div>

            <div class="info-box">
                <i class="fas fa-info-circle"></i>
                <span>
                    Al guardar, se recalculará automáticamente el precio en pesos de todos los
                    productos que tengan precio en dólares cargado.
                </span>
            </div>

            <form action="<?= base_url('admin/configuracion/guardar') ?>" method="POST" id="formConfig">

                <div class="mb-4">
                    <label for="cotizacion_dolar" class="form-label">
                        Cotización del dólar <span style="color:#FF0033;">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-prefix">$</span>
                        <input type="number" id="cotizacion_dolar" name="cotizacion_dolar"
                               class="form-control"
                               value="<?= esc($cotizacion_dolar > 0 ? $cotizacion_dolar : '') ?>"
                               min="0" step="0.01"
                               placeholder="Ej: 1250.00"
                               oninput="actualizarPreview()"
                               required>
                        <span class="input-suffix">ARS / USD</span>
                    </div>
                    <div class="field-hint">Precio en pesos de 1 dólar.</div>
                </div>

                <div class="mb-4">
                    <label for="porcentaje_ganancia" class="form-label">
                        Porcentaje de ganancia <span style="color:#FF0033;">*</span>
                    </label>
                    <div class="input-group">
                        <input type="number" id="porcentaje_ganancia" name="porcentaje_ganancia"
                               class="form-control"
                               value="<?= esc($porcentaje_ganancia >= 0 ? $porcentaje_ganancia : '') ?>"
                               min="0" max="999" step="0.1"
                               placeholder="Ej: 30"
                               oninput="actualizarPreview()"
                               required>
                        <span class="input-suffix">%</span>
                    </div>
                    <div class="field-hint">Porcentaje de ganancia del negocio sobre el costo en dólares.</div>
                </div>

                <!-- Preview del cálculo -->
                <div class="calc-preview mb-4">
                    <div class="calc-titulo">
                        <i class="fas fa-calculator"></i>
                        Ejemplo de cálculo (producto a USD <span id="prev-ej-usd">100</span>)
                    </div>
                    <div class="calc-formula">
                        USD <span class="val" id="prev-usd">100</span>
                        × $<span class="val" id="prev-cotiz"><?= number_format($cotizacion_dolar, 2, ',', '.') ?></span>
                        × (1 + <span class="val" id="prev-porc"><?= number_format($porcentaje_ganancia, 1, ',', '.') ?></span>%)
                    </div>
                    <div class="calc-result">
                        <span id="prev-resultado">
                            <?php
                                $ejemplo = 100 * $cotizacion_dolar * (1 + $porcentaje_ganancia / 100);
                                echo '$' . number_format(round($ejemplo), 0, ',', '.');
                            ?>
                        </span>
                        <span class="ejemplo-label">precio final estimado</span>
                    </div>
                </div>

                <button type="submit" class="btn-guardar">
                    <i class="fas fa-save"></i> Guardar y recalcular precios
                </button>

            </form>
        </div>
    </div>

    <!-- ── Columna derecha: tabla de productos afectados ── -->
    <div class="col-12 col-lg-7">
        <div class="config-card">
            <div class="form-section-title">
                <i class="fas fa-box me-1"></i>
                Productos con precio en dólares
                <?php if (!empty($productosConDolar)): ?>
                <span style="background:rgba(255,0,51,0.1);color:#FF0033;font-size:0.68rem;
                             padding:1px 8px;border-radius:50px;margin-left:6px;font-weight:700;">
                    <?= count($productosConDolar) ?>
                </span>
                <?php endif; ?>
            </div>

            <?php if (empty($productosConDolar)): ?>
            <div class="empty-state">
                <i class="fas fa-dollar-sign"></i>
                <p>Ningún producto tiene precio en dólares cargado aún.<br>
                Editá un producto y completá el campo <strong>Precio en USD</strong>.</p>
            </div>
            <?php else: ?>
            <div class="productos-table-wrap">
                <table class="productos-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio USD</th>
                            <th>Precio actual (ARS)</th>
                            <th>Precio nuevo estimado</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-productos">
                        <?php foreach ($productosConDolar as $p): ?>
                        <tr data-usd="<?= esc($p['precio_dolar']) ?>">
                            <td>
                                <div style="font-weight:600;color:#111827;line-height:1.3;">
                                    <?= esc($p['nombre']) ?>
                                </div>
                                <?php if ($p['modelo']): ?>
                                <div style="font-size:0.75rem;color:#9CA3AF;"><?= esc($p['modelo']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="precio-usd">
                                USD <?= number_format((float)$p['precio_dolar'], 2, ',', '.') ?>
                            </td>
                            <td>
                                <?php if ($p['precio_texto']): ?>
                                <span class="precio-ars"><?= esc($p['precio_texto']) ?></span>
                                <?php else: ?>
                                <span class="sin-precio">Sin precio</span>
                                <?php endif; ?>
                            </td>
                            <td class="precio-nuevo">
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
