<?php $esListado = $presupuesto['tipo'] === 'listado'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title><?= $esListado ? 'Listado' : 'Presupuesto' ?> <?= esc($presupuesto['numero']) ?></title>
<style>
    @page { margin: 28px 34px; }
    * { box-sizing: border-box; }
    body { font-family: 'DejaVu Sans', sans-serif; color: #1F2937; font-size: 11px; line-height: 1.5; margin: 0; }

    .header-table { width: 100%; border-collapse: collapse; margin-bottom: 18px; padding-bottom: 14px; border-bottom: 2px solid #FF0033; }
    .header-table td { vertical-align: top; }
    .logo { height: 74px; width: auto; max-width: 190px; margin-bottom: 8px; }
    .empresa-nombre { font-size: 14px; font-weight: bold; color: #1F2937; }
    .empresa-datos { font-size: 9.5px; color: #6B7280; margin-top: 2px; }
    .doc-titulo { font-size: 9px; text-transform: uppercase; letter-spacing: 1px; color: #9CA3AF; text-align: right; }
    .doc-numero { font-size: 17px; font-weight: bold; color: #FF0033; text-align: right; }
    .doc-fecha { font-size: 9.5px; color: #6B7280; text-align: right; margin-top: 2px; }

    .cliente-table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
    .cliente-table td { width: 50%; vertical-align: top; padding-right: 12px; }
    .label { font-size: 8.5px; text-transform: uppercase; letter-spacing: 0.5px; color: #9CA3AF; margin-bottom: 3px; }
    .valor-fuerte { font-size: 11.5px; font-weight: bold; color: #1F2937; }
    .valor { font-size: 10.5px; color: #4B5563; }

    table.items { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
    table.items th { background: #F9FAFB; color: #6B7280; font-size: 8.5px; text-transform: uppercase; letter-spacing: 0.5px; text-align: left; padding: 8px 10px; border-bottom: 1px solid #E5E7EB; }
    table.items td { padding: 8px 10px; border-bottom: 1px solid #F3F4F6; font-size: 10.5px; }
    table.items td.num { text-align: right; }
    table.items td.center { text-align: center; }
    .prod-nombre { font-weight: bold; color: #1F2937; }
    .prod-codigo { font-size: 8.5px; color: #9CA3AF; }
    .prod-img-cell { width: 60px; text-align: center; vertical-align: middle; }
    .prod-img { width: 55px; height: 55px; max-width: 55px; max-height: 55px; }
    .prod-img-placeholder { width: 55px; height: 55px; background: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 4px; display: inline-block; }

    .totales-table { width: 260px; float: right; border-collapse: collapse; margin-bottom: 20px; }
    .totales-table td { padding: 4px 0; font-size: 10.5px; color: #6B7280; }
    .totales-table td.num { text-align: right; font-weight: bold; color: #1F2937; }
    .totales-table tr.total td { border-top: 1px solid #E5E7EB; padding-top: 8px; font-size: 13px; color: #1F2937; font-weight: bold; }
    .totales-table tr.total td.num { color: #FF0033; font-size: 15px; }

    .clear { clear: both; }
    .seccion { margin-top: 8px; margin-bottom: 10px; }
    .seccion .label { margin-bottom: 3px; }
    .seccion p { font-size: 9.5px; color: #4B5563; margin: 0; white-space: pre-line; }

    .footer { margin-top: 24px; padding-top: 10px; border-top: 1px solid #E5E7EB; font-size: 8.5px; color: #9CA3AF; text-align: center; }
</style>
</head>
<body>

<table class="header-table">
    <tr>
        <td style="width: 60%;">
            <?php if ($logoBase64): ?><img src="<?= $logoBase64 ?>" class="logo"><br><?php endif; ?>
            <div class="empresa-nombre">Centro Informático Regional</div>
            <div class="empresa-datos">Sarmiento 177, El Colorado, Formosa</div>
            <div class="empresa-datos">(+54) 370 461-6482</div>
        </td>
        <td style="width: 40%;">
            <div class="doc-titulo"><?= $esListado ? 'Listado de opciones' : 'Presupuesto' ?></div>
            <div class="doc-numero"><?= esc($presupuesto['numero']) ?></div>
            <div class="doc-fecha">Fecha: <?= esc(date('d/m/Y', strtotime($presupuesto['fecha']))) ?></div>
            <?php if (!empty($presupuesto['valido_hasta'])): ?>
            <div class="doc-fecha">Válido hasta: <?= esc(date('d/m/Y', strtotime($presupuesto['valido_hasta']))) ?></div>
            <?php endif; ?>
        </td>
    </tr>
</table>

<table class="cliente-table">
    <tr>
        <td>
            <div class="label">Cliente</div>
            <div class="valor-fuerte"><?= esc($presupuesto['cliente_nombre']) ?></div>
            <?php if (!empty($presupuesto['cliente_documento'])): ?><div class="valor">DNI/CUIT: <?= esc($presupuesto['cliente_documento']) ?></div><?php endif; ?>
        </td>
        <td>
            <div class="label">Contacto</div>
            <div class="valor"><?= esc($presupuesto['cliente_telefono']) ?></div>
            <?php if (!empty($presupuesto['cliente_email'])): ?><div class="valor"><?= esc($presupuesto['cliente_email']) ?></div><?php endif; ?>
        </td>
    </tr>
</table>

<table class="items">
    <thead>
        <tr>
            <th class="prod-img-cell">&nbsp;</th>
            <?php if ($esListado): ?>
            <th style="width: 60%;">Producto</th>
            <th style="width: 20%;" class="num">Precio</th>
            <?php else: ?>
            <th style="width: 38%;">Producto</th>
            <th style="width: 18%;" class="num">Precio</th>
            <th style="width: 10%;" class="center">Cant.</th>
            <th style="width: 22%;" class="num">Subtotal</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($presupuesto['detalles'] as $d): ?>
        <tr>
            <td class="prod-img-cell">
                <?php if (!empty($d['imagen_base64'])): ?>
                    <img src="<?= $d['imagen_base64'] ?>" class="prod-img">
                <?php else: ?>
                    <span class="prod-img-placeholder"></span>
                <?php endif; ?>
            </td>
            <td>
                <div class="prod-nombre"><?= esc($d['producto_nombre']) ?></div>
                <?php if (!empty($d['producto_codigo'])): ?><div class="prod-codigo"><?= esc($d['producto_codigo']) ?></div><?php endif; ?>
            </td>
            <td class="num">$<?= number_format((float) $d['precio_unitario'], 0, ',', '.') ?></td>
            <?php if (!$esListado): ?>
            <td class="center"><?= (int) $d['cantidad'] ?></td>
            <td class="num"><strong>$<?= number_format((float) $d['subtotal'], 0, ',', '.') ?></strong></td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if (!$esListado): ?>
<table class="totales-table">
    <tr>
        <td>Subtotal</td>
        <td class="num">$<?= number_format((float) $presupuesto['subtotal'], 0, ',', '.') ?></td>
    </tr>
    <tr>
        <td>Descuento<?= $presupuesto['descuento_tipo'] === 'porcentaje' ? ' (' . rtrim(rtrim(number_format((float) $presupuesto['descuento_valor'], 2, ',', '.'), '0'), ',') . '%)' : '' ?></td>
        <td class="num">-$<?= number_format((float) $presupuesto['descuento_monto'], 0, ',', '.') ?></td>
    </tr>
    <tr class="total">
        <td>Total</td>
        <td class="num">$<?= number_format((float) $presupuesto['total'], 0, ',', '.') ?></td>
    </tr>
</table>
<div class="clear"></div>
<?php endif; ?>

<?php if (!empty($presupuesto['observaciones'])): ?>
<div class="seccion">
    <div class="label">Observaciones</div>
    <p><?= esc($presupuesto['observaciones']) ?></p>
</div>
<?php endif; ?>

<?php if (!empty($presupuesto['condiciones'])): ?>
<div class="seccion">
    <div class="label">Condiciones comerciales</div>
    <p><?= esc($presupuesto['condiciones']) ?></p>
</div>
<?php endif; ?>

<div class="footer">
    Centro Informático Regional · Sarmiento 177, El Colorado, Formosa · (+54) 370 461-6482 &middot; Documento generado el <?= esc(date('d/m/Y H:i')) ?>
</div>

</body>
</html>
