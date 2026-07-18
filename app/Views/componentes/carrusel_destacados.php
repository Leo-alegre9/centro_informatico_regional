<section class="bg-[#0c1117] pt-14 pb-16">
    <div class="container lg:px-12">
        <div class="text-center mb-2">
            <span class="section-eyebrow">Selección especial</span>
            <h2 class="section-heading !text-white">Productos Destacados</h2>
        </div>
        <div class="section-divider"></div>

        <div class="overflow-hidden relative" id="destTrackWrap">
            <div class="flex gap-5 transition-transform duration-[400ms] [transition-timing-function:cubic-bezier(0.25,0.46,0.45,0.94)] will-change-transform" id="destTrack">
                <?php foreach ($destacados as $dest): ?>
                <div class="dest-card shrink-0 grow-0 w-[85%] sm:w-[calc(50%-0.65rem)] lg:w-[calc(25%-1rem)] bg-[#111a27] rounded-[14px] overflow-hidden border border-white/[0.06] flex flex-col transition-all duration-300 ease hover:-translate-y-[5px] hover:shadow-[0_20px_50px_rgba(0,0,0,0.4)] hover:border-[rgba(255,0,51,0.2)]">
                    <div class="group h-40 bg-[#0d1520] flex items-center justify-center overflow-hidden shrink-0">
                        <?php if (!empty($dest['imagen_ruta'])): ?>
                            <img src="<?= base_url(esc($dest['imagen_ruta'])) ?>"
                                 alt="<?= esc($dest['nombre']) ?>"
                                 loading="lazy"
                                 class="w-full h-full object-cover opacity-85 group-hover:opacity-100 group-hover:scale-[1.04] [transition:opacity_0.3s,transform_0.4s]"
                                 onerror="this.parentElement.innerHTML='<span class=\'text-white/[0.12] text-[2.5rem]\'><i class=\'fas fa-image\'></i></span>'">
                        <?php else: ?>
                            <span class="text-white/[0.12] text-[2.5rem]"><i class="fas fa-image"></i></span>
                        <?php endif; ?>
                    </div>
                    <div class="px-[1.1rem] pt-4 pb-[1.2rem] flex flex-col flex-1">
                        <?php if (!empty($dest['marca_nombre'])): ?>
                            <div class="text-[0.72rem] font-bold text-[rgba(255,0,51,0.7)] uppercase tracking-[0.8px] mb-1"><?= esc($dest['marca_nombre']) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($dest['badge'])): ?>
                            <span class="inline-block bg-[rgba(255,0,51,0.1)] text-rojo text-[0.68rem] font-bold px-2 py-[2px] rounded-full mb-2 w-fit"><?= esc($dest['badge']) ?></span>
                        <?php endif; ?>
                        <div class="text-white text-[0.95rem] font-bold leading-[1.35] mb-[0.4rem] line-clamp-2"><?= esc($dest['nombre']) ?></div>
                        <?php if (!empty($dest['modelo'])): ?>
                            <div class="text-[0.78rem] text-white/[0.35] mb-[0.6rem]"><?= esc($dest['modelo']) ?></div>
                        <?php endif; ?>
                        <div class="mt-auto text-[0.9rem] font-bold text-rojo">
                            <?= !empty($dest['precio_texto']) ? esc($dest['precio_texto']) : 'Consultar precio' ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="flex items-center justify-center gap-[0.6rem] mt-8">
            <button class="w-[38px] h-[38px] rounded-full border-[1.5px] border-white/[0.12] bg-white/5 text-white/60 text-[0.85rem] cursor-pointer flex items-center justify-center transition-colors duration-200 hover:enabled:bg-[rgba(255,0,51,0.15)] hover:enabled:border-[rgba(255,0,51,0.4)] hover:enabled:text-white disabled:opacity-30 disabled:cursor-default" id="destPrev" title="Anterior"><i class="fas fa-chevron-left"></i></button>
            <div class="flex gap-[5px]" id="destDots"></div>
            <button class="w-[38px] h-[38px] rounded-full border-[1.5px] border-white/[0.12] bg-white/5 text-white/60 text-[0.85rem] cursor-pointer flex items-center justify-center transition-colors duration-200 hover:enabled:bg-[rgba(255,0,51,0.15)] hover:enabled:border-[rgba(255,0,51,0.4)] hover:enabled:text-white disabled:opacity-30 disabled:cursor-default" id="destNext" title="Siguiente"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</section>

<script>
(function () {
    var track    = document.getElementById('destTrack');
    var wrap     = document.getElementById('destTrackWrap');
    var btnPrev  = document.getElementById('destPrev');
    var btnNext  = document.getElementById('destNext');
    var dotsWrap = document.getElementById('destDots');

    var cards       = track.querySelectorAll('.dest-card');
    var total       = cards.length;
    var current     = 0;
    var visibles    = 4;

    var DOT_BASE = 'w-[6px] h-[6px] rounded-full bg-white/20 cursor-pointer transition-all duration-200';

    function getVisibles() {
        var w = wrap.offsetWidth;
        if (w < 576) return 1;
        if (w < 992) return 2;
        return 4;
    }

    function pages() {
        return Math.max(1, total - visibles + 1);
    }

    function renderDots() {
        dotsWrap.innerHTML = '';
        var p = pages();
        for (var i = 0; i < p; i++) {
            var d = document.createElement('button');
            d.className = DOT_BASE + (i === current ? ' !bg-rojo scale-[1.3]' : '');
            d.setAttribute('data-i', i);
            d.addEventListener('click', function () { goTo(parseInt(this.getAttribute('data-i'))); });
            dotsWrap.appendChild(d);
        }
    }

    function goTo(idx) {
        visibles = getVisibles();
        current  = Math.max(0, Math.min(idx, pages() - 1));
        var cardW   = cards[0] ? cards[0].offsetWidth : 0;
        var gap     = 20;
        track.style.transform = 'translateX(-' + (current * (cardW + gap)) + 'px)';
        btnPrev.disabled = current === 0;
        btnNext.disabled = current >= pages() - 1;
        renderDots();
    }

    btnPrev.addEventListener('click', function () { goTo(current - 1); });
    btnNext.addEventListener('click', function () { goTo(current + 1); });
    window.addEventListener('resize', function () { goTo(0); });
    goTo(0);
})();
</script>
