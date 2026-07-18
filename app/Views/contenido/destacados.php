<?php if (empty($productosDestacados)) return; ?>

<!-- ═══════════════════════════════════════════════
     PRODUCTOS DESTACADOS
═══════════════════════════════════════════════ -->
<section class="bg-[#0c1117] relative overflow-hidden py-12 [&_.section-heading]:text-white" id="destacados">
    <div class="mx-auto w-full max-w-[1320px] px-4 lg:px-12">

        <div class="flex items-end justify-between flex-wrap gap-4 mb-2">
            <div>
                <span class="section-eyebrow">Lo mejor de nuestro catálogo</span>
                <h2 class="section-heading mb-0">Productos Destacados</h2>
            </div>
            <div class="flex items-center gap-3">
                <button class="w-[42px] h-[42px] rounded-full bg-white/[0.06] border-[1.5px] border-white/[0.12] text-white text-[0.95rem] flex items-center justify-center cursor-pointer transition-colors duration-200 shrink-0 [&:hover:not(:disabled)]:bg-rojo [&:hover:not(:disabled)]:border-rojo disabled:opacity-30 disabled:cursor-default" id="destPrev" aria-label="Anterior" disabled>
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="flex gap-[6px] items-center" id="destDots"></div>
                <button class="w-[42px] h-[42px] rounded-full bg-white/[0.06] border-[1.5px] border-white/[0.12] text-white text-[0.95rem] flex items-center justify-center cursor-pointer transition-colors duration-200 shrink-0 [&:hover:not(:disabled)]:bg-rojo [&:hover:not(:disabled)]:border-rojo disabled:opacity-30 disabled:cursor-default" id="destNext" aria-label="Siguiente">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
        <div class="section-divider" style="margin: 0 0 2.5rem;"></div>

        <div class="overflow-hidden relative">
            <div class="flex gap-6 transition-transform duration-[450ms] ease-[cubic-bezier(0.25,0.46,0.45,0.94)] will-change-transform" id="destTrack">

                <?php foreach ($productosDestacados as $p): ?>
                <a href="<?= esc($p['catalog_url']) ?>"
                   class="group w-[82vw] sm:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] shrink-0 bg-dark-2 rounded-[18px] border-[1.5px] border-white/5 border-b-[3px] border-b-transparent overflow-hidden transition-[transform,box-shadow,border-color] duration-300 ease-out no-underline flex flex-col text-inherit hover:-translate-y-[6px] hover:shadow-[0_20px_50px_rgba(0,0,0,0.35)] hover:border-b-rojo hover:text-inherit hover:no-underline">
                    <div class="relative h-[160px] sm:h-[190px] overflow-hidden bg-[#131b27] flex items-center justify-center shrink-0">
                        <?php if (!empty($p['imagen_ruta'])): ?>
                            <img src="<?= base_url(esc($p['imagen_ruta'])) ?>"
                                 alt="<?= esc($p['imagen_alt'] ?? $p['nombre']) ?>"
                                 class="w-full h-full object-cover transition-[transform,opacity] duration-[400ms] ease-out opacity-[0.88] group-hover:scale-[1.04] group-hover:opacity-100"
                                 loading="lazy"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='none'; this.parentElement.querySelector('.dest-icon-fallback').style.display='flex';">
                            <div class="absolute inset-0 bg-[linear-gradient(to_bottom,rgba(0,0,0,0.05)_0%,rgba(15,22,35,0.75)_100%)]"></div>
                        <?php else: ?>
                            <div class="dest-icon-fallback text-[3rem] text-white/25 flex items-center justify-center">
                                <i class="<?= esc($p['icono'] ?? 'fas fa-box') ?>"></i>
                            </div>
                        <?php endif; ?>
                        <div class="dest-icon-fallback text-[3rem] text-white/25 hidden absolute inset-0 items-center justify-center">
                            <i class="<?= esc($p['icono'] ?? 'fas fa-box') ?>"></i>
                        </div>
                        <?php if (!empty($p['badge'])): ?>
                            <span class="absolute top-3 left-[14px] bg-rojo text-white text-[0.7rem] font-bold tracking-[0.5px] px-[10px] py-[3px] rounded-full z-[1]"><?= esc($p['badge']) ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="px-[1.4rem] pt-[1.2rem] pb-6 flex flex-col flex-1">
                        <?php if (!empty($p['categoria_nombre'])): ?>
                            <div class="text-[0.72rem] font-bold tracking-[1.5px] uppercase text-rojo mb-[0.45rem]"><?= esc($p['categoria_nombre']) ?></div>
                        <?php endif; ?>
                        <div class="text-base font-bold text-white leading-[1.35] mb-2 flex-1"><?= esc($p['nombre']) ?></div>
                        <?php if (!empty($p['descripcion_corta'])): ?>
                            <div class="text-[0.8rem] text-white/45 leading-[1.55] mb-[0.9rem] line-clamp-2"><?= esc($p['descripcion_corta']) ?></div>
                        <?php endif; ?>
                        <?php
                            $precio = $p['precio_texto'] ?? '';
                            $esConsultar = empty($precio) || strtolower($precio) === 'consultar precio';
                        ?>
                        <div class="<?= $esConsultar ? 'text-[0.85rem] font-semibold text-white/45 italic' : 'text-[1.05rem] font-extrabold text-white' ?>">
                            <?= $esConsultar ? 'Consultar precio' : esc($precio) ?>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>

            </div>
        </div>

    </div>
</section>

<script>
(function () {
    const track   = document.getElementById('destTrack');
    const prevBtn = document.getElementById('destPrev');
    const nextBtn = document.getElementById('destNext');
    const dotsWrap = document.getElementById('destDots');
    if (!track || !track.children.length) return;

    let current = 0;

    function getVisible() {
        if (window.innerWidth >= 992) return 3;
        if (window.innerWidth >= 576) return 2;
        return 1;
    }

    function getTotal() { return track.children.length; }

    function getCardWidth() {
        const card = track.children[0];
        if (!card) return 0;
        return card.offsetWidth + 24;
    }

    function maxPos() { return Math.max(0, getTotal() - getVisible()); }

    function dotClass(isActive) {
        return 'w-[7px] h-[7px] rounded-full transition-[background,transform] duration-200 cursor-pointer border-none p-0 '
            + (isActive ? 'bg-rojo scale-[1.3]' : 'bg-white/20');
    }

    function buildDots() {
        dotsWrap.innerHTML = '';
        const steps = maxPos() + 1;
        for (let i = 0; i < steps; i++) {
            const d = document.createElement('button');
            d.className = dotClass(i === current);
            d.setAttribute('aria-label', 'Ir a posición ' + (i + 1));
            d.addEventListener('click', function () { current = i; update(); });
            dotsWrap.appendChild(d);
        }
    }

    function update() {
        const max = maxPos();
        current = Math.max(0, Math.min(current, max));
        track.style.transform = 'translateX(-' + (current * getCardWidth()) + 'px)';
        prevBtn.disabled = current === 0;
        nextBtn.disabled = current >= max;
        dotsWrap.querySelectorAll('button').forEach(function (d, i) {
            d.className = dotClass(i === current);
        });
    }

    prevBtn.addEventListener('click', function () { current--; update(); });
    nextBtn.addEventListener('click', function () { current++; update(); });
    window.addEventListener('resize', function () { current = 0; buildDots(); update(); });

    buildDots();
    update();
})();
</script>
