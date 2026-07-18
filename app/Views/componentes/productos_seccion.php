<section class="bg-[#f8f9fa] pt-14 pb-16 border-t border-[#e9ecef]">
    <div class="container">
        <div class="text-center mb-1">
            <span class="section-eyebrow">Selección especial</span>
            <h2 class="section-heading"><?= esc($tituloSeccion ?? 'Productos destacados') ?></h2>
        </div>
        <div class="section-divider"></div>

        <div class="grid grid-cols-1 min-[480px]:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-[1.2rem] mt-6" id="sec-productos-grid">
            <?php foreach ($productosSeccion as $sp): ?>
            <?php
                $imgUrl  = $sp['imagen_ruta'] ?? '';
                $imgAlt  = $sp['imagen_alt']  ?? $sp['nombre'];
            ?>
            <div class="sec-prod-card group bg-white rounded-[14px] overflow-hidden border-[1.5px] border-[#f0f0f0] shadow-[0_2px_12px_rgba(0,0,0,0.06)] flex flex-col cursor-pointer transition-all duration-[250ms] ease hover:-translate-y-1 hover:shadow-[0_12px_35px_rgba(0,0,0,0.12)]"
                 data-nombre="<?= esc($sp['nombre']) ?>"
                 data-precio="<?= esc($sp['precio_texto']) ?>"
                 data-descripcion="<?= esc($sp['descripcion'] ?? $sp['descripcion_corta'] ?? '') ?>"
                 data-badge="<?= esc($sp['badge'] ?? '') ?>"
                 data-icono="<?= esc($sp['icono'] ?? 'fas fa-box') ?>"
                 data-imagen="<?= esc($imgUrl) ?>"
                 data-imagenes="[]"
                 data-categoria="<?= esc($sp['categoria_nombre'] ?? '') ?>">
                <div class="h-[150px] bg-[#1a232e] flex items-center justify-center overflow-hidden relative shrink-0">
                    <?php if (!empty($imgUrl)): ?>
                        <img src="<?= base_url(esc($imgUrl)) ?>"
                             alt="<?= esc($imgAlt) ?>"
                             loading="lazy"
                             class="w-full h-full object-cover transition-transform duration-[350ms] ease group-hover:scale-105"
                             onerror="this.parentElement.innerHTML='<span class=\'text-white/[0.18] text-[2.2rem]\'><i class=\'fas fa-box\'></i></span>'">
                    <?php else: ?>
                        <span class="text-white/[0.18] text-[2.2rem]">
                            <i class="<?= esc($sp['icono'] ?? 'fas fa-box') ?>"></i>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($sp['badge'])): ?>
                        <span class="absolute top-[9px] right-[9px] bg-rojo text-white text-[0.67rem] font-bold px-[9px] py-[3px] rounded-full tracking-[0.4px]"><?= esc($sp['badge']) ?></span>
                    <?php endif; ?>
                </div>
                <div class="px-[1.1rem] pt-4 pb-[1.1rem] flex-1 flex flex-col">
                    <?php if (!empty($sp['categoria_nombre'])): ?>
                        <div class="text-[0.7rem] font-bold text-[rgba(255,0,51,0.7)] uppercase tracking-[0.6px] mb-1"><?= esc($sp['categoria_nombre']) ?></div>
                    <?php endif; ?>
                    <div class="font-bold text-dark text-[0.9rem] leading-[1.35] mb-[0.35rem] line-clamp-2"><?= esc($sp['nombre']) ?></div>
                    <?php if (!empty($sp['descripcion_corta'])): ?>
                        <div class="text-[0.8rem] text-gris leading-[1.5] flex-1 mb-[0.8rem] line-clamp-2"><?= esc($sp['descripcion_corta']) ?></div>
                    <?php endif; ?>
                    <div class="flex items-center justify-between gap-[6px] flex-wrap">
                        <span class="font-bold text-rojo text-[0.88rem]">
                            <?= !empty($sp['precio_texto']) ? esc($sp['precio_texto']) : 'Consultar precio' ?>
                        </span>
                        <a href="https://wa.me/5493704616482?text=Hola!%20Quiero%20consultar%20por%20<?= rawurlencode($sp['nombre']) ?>"
                           target="_blank" rel="noopener"
                           class="sec-prod-btn inline-flex items-center gap-[5px] bg-[#25D366] text-white px-[0.9rem] py-[0.4rem] rounded-full font-bold text-[0.75rem] no-underline transition-colors duration-200 whitespace-nowrap hover:bg-[#1ebe5a] hover:text-white"
                           onclick="event.stopPropagation();">
                            <i class="fab fa-whatsapp"></i> Consultar
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
