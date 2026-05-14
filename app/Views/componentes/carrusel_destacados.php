<style>
    .carrusel-section {
        background: #0c1117;
        padding: 3.5rem 0 4rem;
    }
    .carrusel-section .section-heading { color: #fff; }
    .carrusel-track-wrap {
        overflow: hidden;
        position: relative;
    }
    .carrusel-track {
        display: flex;
        gap: 1.25rem;
        transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        will-change: transform;
    }
    .dest-card {
        flex: 0 0 calc(25% - 1rem);
        background: #111a27;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.06);
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .dest-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.4);
        border-color: rgba(255,0,51,0.2);
    }
    .dest-img {
        height: 160px;
        background: #0d1520;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }
    .dest-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.85;
        transition: opacity 0.3s, transform 0.4s;
    }
    .dest-card:hover .dest-img img { opacity: 1; transform: scale(1.04); }
    .dest-img-placeholder {
        color: rgba(255,255,255,0.12);
        font-size: 2.5rem;
    }
    .dest-body {
        padding: 1rem 1.1rem 1.2rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .dest-marca {
        font-size: 0.72rem;
        font-weight: 700;
        color: rgba(255,0,51,0.7);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 0.25rem;
    }
    .dest-nombre {
        color: #fff;
        font-size: 0.95rem;
        font-weight: 700;
        line-height: 1.35;
        margin-bottom: 0.4rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .dest-modelo {
        font-size: 0.78rem;
        color: rgba(255,255,255,0.35);
        margin-bottom: 0.6rem;
    }
    .dest-precio {
        margin-top: auto;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--rojo, #FF0033);
    }
    .dest-badge {
        display: inline-block;
        background: rgba(255,0,51,0.1);
        color: var(--rojo, #FF0033);
        font-size: 0.68rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 50px;
        margin-bottom: 0.5rem;
        width: fit-content;
    }
    .carrusel-nav {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        margin-top: 2rem;
    }
    .carrusel-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: 1.5px solid rgba(255,255,255,0.12);
        background: rgba(255,255,255,0.05);
        color: rgba(255,255,255,0.6);
        font-size: 0.85rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s, border-color 0.2s, color 0.2s;
    }
    .carrusel-btn:hover:not(:disabled) {
        background: rgba(255,0,51,0.15);
        border-color: rgba(255,0,51,0.4);
        color: #fff;
    }
    .carrusel-btn:disabled { opacity: 0.3; cursor: default; }
    .carrusel-dots {
        display: flex;
        gap: 5px;
    }
    .carrusel-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        cursor: pointer;
        transition: background 0.2s, transform 0.2s;
    }
    .carrusel-dot.activo {
        background: var(--rojo, #FF0033);
        transform: scale(1.3);
    }

    @media (max-width: 991px) {
        .dest-card { flex: 0 0 calc(50% - 0.65rem); }
    }
    @media (max-width: 575px) {
        .dest-card { flex: 0 0 calc(85%); }
    }
</style>

<section class="carrusel-section">
    <div class="container-xxl px-3 px-lg-5">
        <div class="text-center mb-2">
            <span class="section-eyebrow">Selección especial</span>
            <h2 class="section-heading">Productos Destacados</h2>
        </div>
        <div class="section-divider"></div>

        <div class="carrusel-track-wrap" id="destTrackWrap">
            <div class="carrusel-track" id="destTrack">
                <?php foreach ($destacados as $dest): ?>
                <div class="dest-card">
                    <div class="dest-img">
                        <?php if (!empty($dest['imagen_ruta'])): ?>
                            <img src="<?= base_url(esc($dest['imagen_ruta'])) ?>"
                                 alt="<?= esc($dest['nombre']) ?>"
                                 loading="lazy"
                                 onerror="this.parentElement.innerHTML='<span class=\'dest-img-placeholder\'><i class=\'fas fa-image\'></i></span>'">
                        <?php else: ?>
                            <span class="dest-img-placeholder"><i class="fas fa-image"></i></span>
                        <?php endif; ?>
                    </div>
                    <div class="dest-body">
                        <?php if (!empty($dest['marca_nombre'])): ?>
                            <div class="dest-marca"><?= esc($dest['marca_nombre']) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($dest['badge'])): ?>
                            <span class="dest-badge"><?= esc($dest['badge']) ?></span>
                        <?php endif; ?>
                        <div class="dest-nombre"><?= esc($dest['nombre']) ?></div>
                        <?php if (!empty($dest['modelo'])): ?>
                            <div class="dest-modelo"><?= esc($dest['modelo']) ?></div>
                        <?php endif; ?>
                        <div class="dest-precio">
                            <?= !empty($dest['precio_texto']) ? esc($dest['precio_texto']) : 'Consultar precio' ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="carrusel-nav">
            <button class="carrusel-btn" id="destPrev" title="Anterior"><i class="fas fa-chevron-left"></i></button>
            <div class="carrusel-dots" id="destDots"></div>
            <button class="carrusel-btn" id="destNext" title="Siguiente"><i class="fas fa-chevron-right"></i></button>
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
            d.className = 'carrusel-dot' + (i === current ? ' activo' : '');
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
