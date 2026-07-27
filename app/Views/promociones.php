<?= $this->extend('componentes/base') ?>

<?= $this->section('contenido') ?>

<!-- ═══════ HERO ═══════════════════════════════════════════════ -->
<section class="relative overflow-hidden bg-[linear-gradient(135deg,#0c0f14_0%,#1a0507_50%,#2a0009_100%)] py-16 pb-14">
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_20%_50%,rgba(255,0,51,0.12)_0%,transparent_50%),radial-gradient(circle_at_80%_20%,rgba(255,0,51,0.07)_0%,transparent_45%)]"></div>
    <div class="pointer-events-none absolute inset-x-0 bottom-0 h-px bg-[linear-gradient(90deg,transparent,rgba(255,0,51,0.6),transparent)]"></div>
    <div class="container lg:px-12">
        <div class="relative z-[1] flex flex-wrap items-center justify-between gap-8">
            <div>
                <div class="mb-3 inline-flex items-center gap-[0.4rem] text-[0.72rem] font-extrabold uppercase tracking-[2px] text-rojo">
                    <span class="block h-0.5 w-[18px] rounded-sm bg-rojo"></span>
                    <i class="fas fa-percent text-[0.9rem]"></i>
                    Ofertas y promociones
                </div>
                <h1 class="mb-3 text-[clamp(2rem,4vw,2.8rem)] font-black leading-[1.1] tracking-[-0.5px] text-white">
                    Nuestras<br><span class="text-rojo">Promociones</span>
                </h1>
                <p class="m-0 max-w-[480px] text-base leading-[1.6] text-white/55">
                    Productos seleccionados a precios especiales. Tecnología, electrodomésticos, muebles y más con las mejores condiciones del mercado.
                </p>
                <?php if (!empty($productos)): ?>
                <div class="mt-8 flex flex-wrap gap-8">
                    <div class="text-center">
                        <span class="block text-2xl font-black leading-none text-white"><?= count($productos) ?></span>
                        <span class="mt-[0.2rem] block text-[0.72rem] font-semibold uppercase tracking-[0.5px] text-white/40">Productos en oferta</span>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="hidden flex-shrink-0 rounded-2xl border border-rojo/35 bg-rojo/15 px-10 py-8 text-center min-[480px]:block">
                <i class="fas fa-tags mb-2 block text-5xl text-rojo"></i>
                <div class="text-[0.8rem] font-bold uppercase tracking-[0.5px] text-white/70">Precios<br>especiales</div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════ BARRA DE INFO ═══════════════════════════════════════ -->
<div class="border-b border-[#ECEEF2] bg-white py-[0.9rem]">
    <div class="container lg:px-12">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <nav class="text-[0.8rem] text-gray-400" aria-label="Breadcrumb">
                <a href="<?= base_url('/') ?>" class="text-gray-500 no-underline hover:text-rojo">Inicio</a>
                <span class="mx-[0.4rem]">/</span>
                <strong class="text-gray-700">Promociones</strong>
            </nav>
            <?php if (!empty($productos)): ?>
            <span class="inline-flex items-center gap-[0.4rem] rounded-full border border-rojo/15 bg-rojo/[0.06] px-4 py-[0.35rem] text-[0.82rem] font-bold text-rojo">
                <i class="fas fa-fire text-[0.75rem]"></i>
                <?= count($productos) ?> <?= count($productos) === 1 ? 'producto en oferta' : 'productos en oferta' ?>
            </span>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ═══════ GRID DE PRODUCTOS ═══════════════════════════════════ -->
<section class="min-h-[50vh] bg-[#F8F9FB] py-12">
    <div class="container lg:px-12">

        <?php if (empty($productos)): ?>
        <div class="px-4 py-20 text-center">
            <div class="mb-6 text-[4rem] text-gray-200"><i class="fas fa-tags"></i></div>
            <h3 class="mb-2 text-[1.3rem] font-bold text-gray-700">Sin promociones activas</h3>
            <p class="mb-6 text-[0.95rem] text-gray-400">Por el momento no hay productos en oferta. Volvé pronto para encontrar las mejores promociones.</p>
            <a href="<?= base_url('catalogo') ?>" class="inline-flex items-center gap-[0.4rem] rounded-full bg-rojo px-7 py-[0.7rem] text-[0.9rem] font-bold text-white no-underline transition-colors duration-200 hover:bg-rojo-dark hover:text-white">
                <i class="fas fa-th-large"></i> Ver catálogo completo
            </a>
        </div>
        <?php else: ?>

        <div class="grid grid-cols-1 gap-6 min-[480px]:grid-cols-2 min-[900px]:grid-cols-3 min-[1200px]:grid-cols-4">
            <?php foreach ($productos as $p): ?>
            <?php $urlProducto = base_url('producto/' . ($p['slug'] ?: $p['id'])); ?>
            <a href="<?= esc($urlProducto) ?>" class="group relative flex flex-col overflow-hidden rounded-[18px] border-[1.5px] border-[#ECEEF2] bg-white text-inherit no-underline transition-[transform,box-shadow,border-color] duration-[280ms] hover:-translate-y-[6px] hover:border-rojo hover:text-inherit hover:no-underline hover:shadow-[0_16px_48px_rgba(0,0,0,0.1)]">

                <div class="relative flex h-[210px] flex-shrink-0 items-center justify-center overflow-hidden bg-[#F1F3F6]">
                    <?php if (!empty($p['imagen_ruta'])): ?>
                        <img src="<?= base_url(esc($p['imagen_ruta'])) ?>"
                             alt="<?= esc($p['imagen_alt'] ?? $p['nombre']) ?>"
                             class="h-full w-full object-cover transition-transform duration-[400ms] group-hover:scale-[1.06]" loading="lazy"
                             onerror="this.style.display='none';this.parentElement.querySelector('.promo-icon-fallback').style.display='flex';">
                    <?php else: ?>
                        <div class="promo-icon-fallback flex items-center justify-center text-5xl text-gray-300">
                            <i class="<?= esc($p['icono'] ?? 'fas fa-box') ?>"></i>
                        </div>
                    <?php endif; ?>
                    <div class="promo-icon-fallback absolute inset-0 hidden items-center justify-center text-5xl text-gray-300">
                        <i class="<?= esc($p['icono'] ?? 'fas fa-box') ?>"></i>
                    </div>
                    <div class="pointer-events-none absolute inset-0 bg-[linear-gradient(to_bottom,transparent_50%,rgba(0,0,0,0.04)_100%)]"></div>
                    <span class="absolute left-3 top-3 z-[1] rounded-full bg-rojo px-[11px] py-1 text-[0.65rem] font-black uppercase tracking-[0.8px] text-white shadow-[0_2px_8px_rgba(255,0,51,0.35)]">
                        <?= !empty($p['badge']) ? esc($p['badge']) : 'Promo' ?>
                    </span>
                </div>

                <div class="flex flex-1 flex-col px-5 pb-[1.4rem] pt-[1.15rem]">
                    <?php if (!empty($p['marca_nombre'])): ?>
                        <div class="mb-[0.15rem] text-[0.68rem] font-bold uppercase tracking-[1.3px] text-gray-400"><?= esc($p['marca_nombre']) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($p['categoria_nombre'])): ?>
                        <div class="mb-[0.4rem] text-[0.68rem] font-bold uppercase tracking-[1px] text-rojo"><?= esc($p['categoria_nombre']) ?></div>
                    <?php endif; ?>
                    <div class="mb-2 line-clamp-2 flex-1 text-[0.95rem] font-bold leading-[1.35] text-dark"><?= esc($p['nombre']) ?></div>
                    <?php if (!empty($p['descripcion_corta'])): ?>
                        <div class="mb-4 line-clamp-2 text-[0.79rem] leading-[1.55] text-gray-500"><?= esc($p['descripcion_corta']) ?></div>
                    <?php endif; ?>
                    <?php
                        $precio      = $p['precio_texto'] ?? '';
                        $esConsultar = empty($precio) || strtolower($precio) === 'consultar precio';
                        $precioClass = $esConsultar
                            ? 'text-[0.85rem] font-medium italic text-gray-400'
                            : 'text-[1.15rem] font-black text-dark';
                    ?>
                    <div class="mt-auto flex items-center justify-between gap-2 border-t border-gray-100 pt-[0.85rem]">
                        <span class="<?= $precioClass ?> leading-none">
                            <?= $esConsultar ? 'Consultar precio' : esc($precio) ?>
                        </span>
                        <span class="inline-flex items-center gap-[0.3rem] whitespace-nowrap rounded-full bg-rojo px-4 py-[0.45rem] text-[0.78rem] font-bold text-white transition-colors duration-200 group-hover:bg-rojo-dark">
                            Ver <i class="fas fa-arrow-right text-[0.7rem]"></i>
                        </span>
                    </div>
                </div>

            </a>
            <?php endforeach; ?>
        </div>

        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>
