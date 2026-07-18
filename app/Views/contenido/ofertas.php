<?php if (empty($productosOferta)) return; ?>

<!-- ═══════════════════════════════════════════════
     SECCIÓN DE OFERTAS
═══════════════════════════════════════════════ -->
<section class="bg-[#F8F9FB] border-t border-[#ECEEF2] py-12" id="ofertas">
    <div class="mx-auto w-full max-w-[1320px] px-4 lg:px-12">

        <div class="flex items-end justify-between flex-wrap gap-4 mb-2">
            <div>
                <span class="section-eyebrow">Aprovechá ahora</span>
                <h2 class="section-heading mb-0">Promociones</h2>
            </div>
            <a href="<?= base_url('promociones') ?>" class="inline-flex items-center gap-2 bg-rojo text-white no-underline px-8 py-[0.7rem] rounded-full text-[0.9rem] font-bold tracking-[0.2px] transition-[background,transform] duration-200 hover:bg-rojo-dark hover:text-white hover:no-underline hover:-translate-y-[1px]">
                Ver todas <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="section-divider" style="margin:0 0 2rem;"></div>

        <div class="grid grid-cols-1 min-[480px]:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5">
            <?php foreach ($productosOferta as $p): ?>
            <a href="<?= esc($p['catalog_url']) ?>"
               class="group bg-white border-[1.5px] border-[#ECEEF2] rounded-2xl overflow-hidden no-underline flex flex-col text-inherit transition-[transform,box-shadow,border-color] duration-[250ms] ease-out hover:-translate-y-[5px] hover:shadow-[0_14px_40px_rgba(0,0,0,0.09)] hover:border-rojo hover:text-inherit hover:no-underline">
                <div class="relative h-[195px] bg-[#F1F3F6] overflow-hidden shrink-0 flex items-center justify-center">
                    <?php if (!empty($p['imagen_ruta'])): ?>
                        <img src="<?= base_url(esc($p['imagen_ruta'])) ?>"
                             alt="<?= esc($p['imagen_alt'] ?? $p['nombre']) ?>"
                             class="w-full h-full object-cover transition-transform duration-[350ms] ease-out group-hover:scale-105"
                             loading="lazy"
                             onerror="this.style.display='none';this.parentElement.querySelector('.oferta-icon-fallback').style.display='flex';">
                    <?php else: ?>
                        <div class="oferta-icon-fallback text-[2.5rem] text-gray-300 flex items-center justify-center">
                            <i class="<?= esc($p['icono'] ?? 'fas fa-box') ?>"></i>
                        </div>
                    <?php endif; ?>
                    <div class="oferta-icon-fallback text-[2.5rem] text-gray-300 hidden absolute inset-0 items-center justify-center">
                        <i class="<?= esc($p['icono'] ?? 'fas fa-box') ?>"></i>
                    </div>
                    <span class="absolute top-[11px] left-[11px] bg-rojo text-white text-[0.65rem] font-extrabold tracking-[0.6px] px-[10px] py-[3px] rounded-full uppercase z-[1]">
                        <?= !empty($p['badge']) ? esc($p['badge']) : 'Oferta' ?>
                    </span>
                </div>

                <div class="px-[1.1rem] pt-4 pb-[1.2rem] flex flex-col flex-1">
                    <?php if (!empty($p['categoria_nombre'])): ?>
                        <div class="text-[0.68rem] font-bold tracking-[1.2px] uppercase text-rojo mb-[0.3rem]"><?= esc($p['categoria_nombre']) ?></div>
                    <?php endif; ?>
                    <div class="text-[0.92rem] font-bold text-dark leading-[1.35] mb-[0.35rem] line-clamp-2 flex-1"><?= esc($p['nombre']) ?></div>
                    <?php if (!empty($p['descripcion_corta'])): ?>
                        <div class="text-[0.78rem] text-gray-400 leading-[1.5] mb-3 line-clamp-1"><?= esc($p['descripcion_corta']) ?></div>
                    <?php endif; ?>
                    <?php
                        $precio      = $p['precio_texto'] ?? '';
                        $esConsultar = empty($precio) || strtolower($precio) === 'consultar precio';
                    ?>
                    <div class="flex items-center justify-between gap-2 mt-auto">
                        <span class="<?= $esConsultar ? 'text-[0.82rem] text-gray-400 italic font-medium' : 'text-[1.05rem] font-extrabold text-dark' ?>">
                            <?= $esConsultar ? 'Consultar precio' : esc($precio) ?>
                        </span>
                        <span class="text-[0.72rem] font-bold text-rojo bg-rojo/[0.07] border border-rojo/15 px-[11px] py-1 rounded-full whitespace-nowrap transition-colors duration-200 group-hover:bg-rojo group-hover:text-white group-hover:border-rojo">Ver más</span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

    </div>
</section>
