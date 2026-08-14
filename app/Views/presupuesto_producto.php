<?= $this->extend('componentes/base_presupuesto') ?>

<?= $this->section('contenido') ?>

<?php
$esListado   = $presupuesto['tipo'] === 'listado';
$volverUrl   = base_url("presupuesto/{$presupuesto['numero']}/{$presupuesto['token']}");
$nombreDoc   = $esListado ? 'listado' : 'presupuesto';
$nombre      = $producto['nombre'] ?? $detalle['producto_nombre'];
$descripcion = $producto['descripcion'] ?? $producto['descripcion_corta'] ?? '';
$marca       = $producto['marca_nombre'] ?? $producto['fabrica_nombre'] ?? '';

// Si el producto sigue en el catálogo se usa su galería completa; si no, se cae al único
// dato que sobrevive congelado en la línea del presupuesto (la imagen que ya se mostraba
// en la tarjeta), y si tampoco hay eso, se muestra un placeholder.
$galeria = !empty($imagenes)
    ? $imagenes
    : (!empty($detalle['imagen_ruta']) ? [['ruta' => $detalle['imagen_ruta'], 'alt_text' => $nombre]] : []);
?>

<div class="bg-white min-h-[60vh] font-inter">

    <!-- ═══ HEADER (marca + volver) — página específica, sin header/navbar del sitio ═══ -->
    <div class="border-b border-gray-100">
        <div class="container max-w-6xl mx-auto flex items-center justify-between flex-wrap gap-3 py-5">
            <img src="<?= base_url('assets/img/logo_cir_nuevo.png') ?>" alt="Centro Informático Regional" class="h-20 sm:h-28 w-auto object-contain">
            <a href="<?= esc($volverUrl) ?>" class="inline-flex items-center gap-2 text-[0.85rem] font-semibold text-gray-500 no-underline transition-colors duration-150 hover:text-rojo">
                <i class="fas fa-arrow-left"></i> Volver al <?= esc($nombreDoc) ?> <span class="text-gray-400 font-normal">&middot; <?= esc($presupuesto['numero']) ?></span>
            </a>
        </div>
    </div>

    <!-- ═══ DETALLE DEL PRODUCTO (dentro de este presupuesto, no el catálogo del sitio) ═══ -->
    <section class="py-10 md:py-14 bg-fondo">
        <div class="container max-w-6xl mx-auto">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">

                    <!-- ── Galería ── -->
                    <div class="flex flex-col">
                        <div class="relative w-full aspect-square bg-gray-50 rounded-2xl border border-gray-100 overflow-hidden flex items-center justify-center shadow-sm">
                            <?php if (!empty($galeria)): ?>
                            <img id="ppMainImg" src="<?= base_url(esc($galeria[0]['ruta'])) ?>"
                                 alt="<?= esc($galeria[0]['alt_text'] ?? $nombre) ?>"
                                 class="w-full h-full object-contain p-6">
                            <?php else: ?>
                            <i class="fas fa-box text-[5rem] text-gray-200"></i>
                            <?php endif; ?>
                        </div>

                        <?php if (count($galeria) > 1): ?>
                        <div class="flex gap-3 mt-4 overflow-x-auto pb-1">
                            <?php foreach ($galeria as $idx => $img): ?>
                            <button type="button" data-src="<?= base_url(esc($img['ruta'])) ?>"
                                    class="pp-thumb shrink-0 w-[70px] h-[70px] rounded-xl overflow-hidden border-2 <?= $idx === 0 ? 'border-rojo' : 'border-gray-100' ?> bg-gray-50 flex items-center justify-center transition-colors duration-200 hover:border-rojo/60"
                                    aria-label="Ver imagen <?= $idx + 1 ?>">
                                <img src="<?= base_url(esc($img['ruta'])) ?>" alt="" loading="lazy" class="w-full h-full object-cover">
                            </button>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- ── Información ── -->
                    <div class="flex flex-col">
                        <?php if (!empty($marca)): ?>
                        <div class="text-[0.78rem] font-bold text-rojo uppercase tracking-[1px] mb-2"><?= esc($marca) ?></div>
                        <?php endif; ?>

                        <h1 class="text-[1.7rem] sm:text-3xl font-extrabold text-dark-2 leading-[1.25] mb-2"><?= esc($nombre) ?></h1>

                        <?php if (!empty($detalle['producto_codigo'])): ?>
                        <div class="text-[0.85rem] text-gray-500 mb-4">Código: <strong class="text-gray-700"><?= esc($detalle['producto_codigo']) ?></strong></div>
                        <?php endif; ?>

                        <div class="w-[42px] h-[3px] bg-rojo rounded mb-5"></div>

                        <?php if (!empty($descripcion)): ?>
                        <p class="text-gray-600 text-[0.98rem] leading-[1.8] mb-6 max-w-[46ch] whitespace-pre-line"><?= esc($descripcion) ?></p>
                        <?php endif; ?>

                        <div class="mb-5">
                            <span class="text-[0.72rem] font-bold uppercase tracking-[1px] text-gray-400 block mb-1">Precio</span>
                            <div class="text-[2rem] font-extrabold text-rojo leading-none">$<?= number_format((float) $detalle['precio_unitario'], 0, ',', '.') ?></div>
                        </div>

                        <?php if (!$esListado): ?>
                        <div class="mb-6 text-[0.88rem] text-gray-700 bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 inline-flex items-center gap-2 w-fit">
                            <i class="fas fa-box-open text-gray-400"></i>
                            Cantidad: <strong><?= (int) $detalle['cantidad'] ?></strong>
                            <span class="text-gray-300">&middot;</span>
                            Subtotal: <strong>$<?= number_format((float) $detalle['subtotal'], 0, ',', '.') ?></strong>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($caracteristicas)): ?>
                        <div class="mb-7">
                            <span class="text-[0.72rem] font-bold uppercase tracking-[1px] text-gray-400 block mb-2">Características</span>
                            <ul class="rounded-xl border border-gray-100 divide-y divide-gray-100 overflow-hidden m-0 p-0 list-none">
                                <?php foreach ($caracteristicas as $car): ?>
                                <li class="flex items-center justify-between px-4 py-[0.65rem] text-[0.86rem]">
                                    <span class="text-gray-400 font-semibold"><?= esc($car['clave']) ?></span>
                                    <span class="text-gray-700 font-semibold text-right"><?= esc($car['valor']) ?></span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php elseif (!$producto): ?>
                        <p class="text-[0.82rem] text-gray-400 mb-7 italic">Este producto ya no está disponible en el catálogo actual; se muestran los datos con los que fue cargado en el <?= esc($nombreDoc) ?>.</p>
                        <?php endif; ?>

                        <div class="flex items-center gap-3 flex-wrap">
                            <a href="<?= esc($volverUrl) ?>"
                               class="inline-flex items-center justify-center gap-2 border-[1.5px] border-rojo text-rojo px-6 py-[0.8rem] rounded-full font-bold text-[0.9rem] no-underline transition-colors duration-200 hover:bg-rojo hover:text-white">
                                <i class="fas fa-arrow-left"></i> Volver al <?= esc($nombreDoc) ?>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->include('componentes/presupuesto_footer') ?>

<?php if (count($galeria) > 1): ?>
<script>
document.querySelectorAll('.pp-thumb').forEach(function (btn) {
    btn.addEventListener('click', function () {
        document.getElementById('ppMainImg').src = this.dataset.src;
        document.querySelectorAll('.pp-thumb').forEach(function (b) {
            b.classList.remove('border-rojo');
            b.classList.add('border-gray-100');
        });
        this.classList.remove('border-gray-100');
        this.classList.add('border-rojo');
    });
});
</script>
<?php endif; ?>

<?= $this->endSection() ?>
