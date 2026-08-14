<?= $this->extend('componentes/base_presupuesto') ?>

<?= $this->section('contenido') ?>

<?php
$esListado = $presupuesto['tipo'] === 'listado';
$fechaFmt  = date('d/m/Y', strtotime($presupuesto['fecha']));
$numWa     = '5493704616482';

$tituloPrincipal = $esListado
    ? 'Opciones seleccionadas para vos'
    : 'Tu presupuesto de Centro Informático Regional';

$intro = $esListado
    ? 'preparamos estas opciones según tu consulta.'
    : 'armamos este presupuesto para vos.';
?>

<!-- ═══════════════════════════════════════════════
     PRESUPUESTO / LISTADO PÚBLICO — página específica, sin header/navbar del sitio
═══════════════════════════════════════════════ -->
<section class="bg-fondo py-10 sm:py-14">
    <div class="container max-w-5xl mx-auto">

        <!-- Header profesional -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-6 sm:px-12 py-9 sm:py-11 text-center mb-8">
            <img src="<?= base_url('assets/img/logo_cir_nuevo.png') ?>" alt="Centro Informático Regional"
                 class="w-40 sm:w-52 h-auto object-contain mx-auto mb-5">

            <span class="section-eyebrow !mb-2 block">Propuesta comercial</span>
            <h1 class="text-[1.5rem] sm:text-[1.9rem] font-extrabold text-dark-2 leading-[1.3] mb-2">
                <?= esc($tituloPrincipal) ?>
            </h1>
            <p class="text-gris text-[0.98rem] sm:text-[1.02rem] font-medium mb-5">
                Hola <?= esc($presupuesto['cliente_nombre']) ?>, <?= esc($intro) ?>
            </p>

            <div class="flex items-center justify-center gap-x-3 gap-y-1.5 flex-wrap text-[0.85rem]">
                <span class="inline-flex items-center gap-1.5 bg-rojo/[0.08] text-rojo font-bold px-3.5 py-1.5 rounded-full">
                    <?= $esListado ? 'Listado' : 'Presupuesto' ?> N.º <?= esc($presupuesto['numero']) ?>
                </span>
                <span class="text-gray-300">&middot;</span>
                <span class="text-gray-500">Fecha: <?= esc($fechaFmt) ?></span>
                <?php if (!empty($presupuesto['valido_hasta'])): ?>
                <span class="text-gray-300">&middot;</span>
                <span class="text-gray-500">Válido hasta <?= esc(date('d/m/Y', strtotime($presupuesto['valido_hasta']))) ?></span>
                <?php endif; ?>
            </div>

            <?php if ($esListado): ?>
            <p class="text-gris text-[0.88rem] mt-4">Elegí el que más te guste y contanos por WhatsApp con cuál te querés quedar.</p>
            <?php endif; ?>
        </div>

        <!-- Grid de productos: centrado aunque haya pocas tarjetas -->
        <div class="grid grid-cols-[repeat(auto-fit,minmax(250px,290px))] justify-center gap-6 mb-8">
            <?php foreach ($presupuesto['detalles'] as $d): ?>
                <?php
                    // Vista de detalle propia de este presupuesto (no la ficha del catálogo público).
                    $urlDetalle = base_url("presupuesto/{$presupuesto['numero']}/{$presupuesto['token']}/producto/{$d['id']}");
                ?>
                <div class="bg-white rounded-2xl overflow-hidden flex flex-col border border-gray-100 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-lg">
                    <a href="<?= esc($urlDetalle) ?>" class="block bg-gray-50 h-[210px] shrink-0 flex items-center justify-center overflow-hidden">
                        <?php if (!empty($d['imagen_ruta'])): ?>
                            <img src="<?= base_url(esc($d['imagen_ruta'])) ?>"
                                 alt="<?= esc($d['producto_nombre']) ?>"
                                 loading="lazy"
                                 class="w-full h-full object-contain p-5">
                        <?php else: ?>
                            <i class="fas fa-box text-gray-300 text-[2.6rem]"></i>
                        <?php endif; ?>
                    </a>
                    <div class="px-5 pt-4 pb-5 flex-1 flex flex-col">
                        <h3 class="font-semibold text-dark-2 text-lg mb-1 leading-[1.35]">
                            <a href="<?= esc($urlDetalle) ?>" class="text-dark-2 no-underline hover:text-rojo transition-colors duration-150"><?= esc($d['producto_nombre']) ?></a>
                        </h3>
                        <?php if (!empty($d['producto_codigo'])): ?>
                        <div class="text-gris text-[0.78rem] mb-3">Código: <?= esc($d['producto_codigo']) ?></div>
                        <?php endif; ?>
                        <div class="flex-1"></div>
                        <div class="flex items-end justify-between gap-2 flex-wrap pt-3 mt-1 border-t border-gray-50">
                            <span class="font-extrabold text-rojo text-[1.4rem] leading-none">$<?= number_format((float) $d['precio_unitario'], 0, ',', '.') ?></span>
                            <?php if (!$esListado): ?>
                            <span class="text-gris text-[0.8rem]">cant. <?= (int) $d['cantidad'] ?></span>
                            <?php endif; ?>
                        </div>
                        <a href="<?= esc($urlDetalle) ?>"
                           class="mt-4 inline-flex items-center justify-center gap-2 border-[1.5px] border-rojo text-rojo px-4 py-2.5 rounded-full font-bold text-[0.85rem] no-underline transition-colors duration-200 hover:bg-rojo hover:text-white">
                            Ver detalle <i class="fas fa-arrow-right text-[0.75rem]"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (!$esListado): ?>
        <!-- Resumen de totales -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm max-w-md mx-auto p-7 mb-8">
            <div class="flex flex-col gap-2 text-[0.92rem]">
                <div class="flex justify-between text-gris">
                    <span>Subtotal</span><span class="font-semibold text-dark-2">$<?= number_format((float) $presupuesto['subtotal'], 0, ',', '.') ?></span>
                </div>
                <div class="flex justify-between text-gris">
                    <span>Descuento</span><span class="font-semibold text-dark-2">-$<?= number_format((float) $presupuesto['descuento_monto'], 0, ',', '.') ?></span>
                </div>
                <div class="flex justify-between items-baseline pt-3 mt-1 border-t border-gray-100">
                    <span class="font-bold text-dark-2">Total</span>
                    <span class="text-[1.5rem] font-extrabold text-rojo">$<?= number_format((float) $presupuesto['total'], 0, ',', '.') ?></span>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($presupuesto['observaciones']) || !empty($presupuesto['condiciones'])): ?>
        <div class="max-w-2xl mx-auto mb-8 text-center">
            <?php if (!empty($presupuesto['observaciones'])): ?>
            <p class="text-gris text-[0.88rem] mb-2"><strong>Observaciones:</strong> <?= esc($presupuesto['observaciones']) ?></p>
            <?php endif; ?>
            <?php if (!empty($presupuesto['condiciones'])): ?>
            <p class="text-gris text-[0.88rem]"><strong>Condiciones:</strong> <?= esc($presupuesto['condiciones']) ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Acciones -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-8 text-center mb-4">
            <p class="text-gris text-[0.92rem] mb-5">¿Querés consultar alguna de estas opciones?</p>
            <div class="flex items-center justify-center gap-3 flex-wrap">
                <a href="<?= base_url("presupuesto/{$presupuesto['numero']}/{$presupuesto['token']}/pdf") ?>"
                   class="btn-rojo" target="_blank" rel="noopener">
                    <i class="fas fa-file-pdf"></i> Descargar PDF
                </a>
                <a href="https://wa.me/<?= $numWa ?>?text=<?= rawurlencode('Hola! Tengo una consulta sobre el ' . ($esListado ? 'listado' : 'presupuesto') . ' N° ' . $presupuesto['numero']) ?>"
                   target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 bg-[#25D366] text-white px-[2.2rem] py-[0.85rem] rounded-full font-bold text-[0.97rem] no-underline transition-colors duration-200 hover:bg-[#1ebe5a]">
                    <i class="fab fa-whatsapp"></i> Consultar por WhatsApp
                </a>
            </div>
        </div>

    </div>
</section>

<?= $this->include('componentes/presupuesto_footer') ?>

<?= $this->endSection() ?>
