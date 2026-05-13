<?php if (empty($productosDestacados)) return; ?>

<style>
    .destacados-section { background: #070c1a; position: relative; overflow: hidden; }
    .destacados-section .section-heading { color: #fff; }

    /* ── Carrusel wrapper ── */
    .dest-viewport {
        overflow: hidden;
        position: relative;
    }
    .dest-track {
        display: flex;
        gap: 1.5rem;
        transition: transform 0.45s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        will-change: transform;
    }

    /* ── Cards ── */
    .dest-card {
        width: calc(33.333% - 1rem);
        flex-shrink: 0;
        background: var(--dark-2);
        border-radius: 18px;
        border: 1.5px solid rgba(255,255,255,0.05);
        border-bottom: 3px solid transparent;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-bottom-color 0.3s;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        color: inherit;
    }
    .dest-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.35);
        border-bottom-color: var(--rojo);
        color: inherit;
        text-decoration: none;
    }

    /* ── Card image ── */
    .dest-img-wrap {
        position: relative;
        height: 190px;
        overflow: hidden;
        background: #131b27;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .dest-img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease, opacity 0.3s ease;
        opacity: 0.88;
    }
    .dest-card:hover .dest-img { transform: scale(1.04); opacity: 1; }
    .dest-img-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.05) 0%, rgba(15,22,35,0.75) 100%);
    }
    .dest-icon-fallback {
        font-size: 3rem;
        color: rgba(255,255,255,0.25);
    }

    /* ── Badge ── */
    .dest-badge {
        position: absolute;
        top: 12px; left: 14px;
        background: var(--rojo);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 3px 10px;
        border-radius: 50px;
        z-index: 1;
    }

    /* ── Card body ── */
    .dest-body {
        padding: 1.2rem 1.4rem 1.5rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .dest-cat {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--rojo);
        margin-bottom: 0.45rem;
    }
    .dest-name {
        font-size: 1rem;
        font-weight: 700;
        color: #fff;
        line-height: 1.35;
        margin-bottom: 0.5rem;
        flex: 1;
    }
    .dest-desc {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.45);
        line-height: 1.55;
        margin-bottom: 0.9rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .dest-price {
        font-size: 1.05rem;
        font-weight: 800;
        color: #fff;
    }
    .dest-price.consultar {
        font-size: 0.85rem;
        font-weight: 600;
        color: rgba(255,255,255,0.45);
        font-style: italic;
    }

    /* ── Controles de navegación ── */
    .dest-controls {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .dest-btn {
        width: 42px; height: 42px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
        border: 1.5px solid rgba(255,255,255,0.12);
        color: #fff;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s, border-color 0.2s;
        flex-shrink: 0;
    }
    .dest-btn:hover:not(:disabled) {
        background: var(--rojo);
        border-color: var(--rojo);
    }
    .dest-btn:disabled {
        opacity: 0.3;
        cursor: default;
    }
    .dest-dots {
        display: flex;
        gap: 6px;
        align-items: center;
    }
    .dest-dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        transition: background 0.2s, transform 0.2s;
        cursor: pointer;
        border: none;
        padding: 0;
    }
    .dest-dot.active {
        background: var(--rojo);
        transform: scale(1.3);
    }

    @media (max-width: 991px) {
        .dest-card { width: calc(50% - 0.75rem); }
    }
    @media (max-width: 575px) {
        .dest-card { width: 82vw; }
        .dest-img-wrap { height: 160px; }
    }
</style>

<!-- ═══════════════════════════════════════════════
     PRODUCTOS DESTACADOS
═══════════════════════════════════════════════ -->
<section class="destacados-section py-5" id="destacados">
    <div class="container-xxl px-3 px-lg-5">

        <div class="d-flex align-items-end justify-content-between flex-wrap gap-3 mb-2">
            <div>
                <span class="section-eyebrow">Lo mejor de nuestro catálogo</span>
                <h2 class="section-heading mb-0">Productos Destacados</h2>
            </div>
            <div class="dest-controls">
                <button class="dest-btn" id="destPrev" aria-label="Anterior" disabled>
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="dest-dots" id="destDots"></div>
                <button class="dest-btn" id="destNext" aria-label="Siguiente">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
        <div class="section-divider" style="margin: 0 0 2.5rem;"></div>

        <div class="dest-viewport">
            <div class="dest-track" id="destTrack">

                <?php foreach ($productosDestacados as $p): ?>
                <a href="<?= esc($p['catalog_url']) ?>" class="dest-card">
                    <div class="dest-img-wrap">
                        <?php if (!empty($p['imagen_ruta'])): ?>
                            <img src="<?= base_url(esc($p['imagen_ruta'])) ?>"
                                 alt="<?= esc($p['imagen_alt'] ?? $p['nombre']) ?>"
                                 class="dest-img" loading="lazy"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='none'; this.parentElement.querySelector('.dest-icon-fallback').style.display='flex';">
                            <div class="dest-img-overlay"></div>
                        <?php else: ?>
                            <div class="dest-icon-fallback" style="display:flex; align-items:center; justify-content:center;">
                                <i class="<?= esc($p['icono'] ?? 'fas fa-box') ?>"></i>
                            </div>
                        <?php endif; ?>
                        <div class="dest-icon-fallback" style="display:none; position:absolute; align-items:center; justify-content:center; inset:0;">
                            <i class="<?= esc($p['icono'] ?? 'fas fa-box') ?>"></i>
                        </div>
                        <?php if (!empty($p['badge'])): ?>
                            <span class="dest-badge"><?= esc($p['badge']) ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="dest-body">
                        <?php if (!empty($p['categoria_nombre'])): ?>
                            <div class="dest-cat"><?= esc($p['categoria_nombre']) ?></div>
                        <?php endif; ?>
                        <div class="dest-name"><?= esc($p['nombre']) ?></div>
                        <?php if (!empty($p['descripcion_corta'])): ?>
                            <div class="dest-desc"><?= esc($p['descripcion_corta']) ?></div>
                        <?php endif; ?>
                        <?php
                            $precio = $p['precio_texto'] ?? '';
                            $esConsultar = empty($precio) || strtolower($precio) === 'consultar precio';
                        ?>
                        <div class="dest-price <?= $esConsultar ? 'consultar' : '' ?>">
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

    function buildDots() {
        dotsWrap.innerHTML = '';
        const steps = maxPos() + 1;
        for (let i = 0; i < steps; i++) {
            const d = document.createElement('button');
            d.className = 'dest-dot' + (i === current ? ' active' : '');
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
        dotsWrap.querySelectorAll('.dest-dot').forEach(function (d, i) {
            d.classList.toggle('active', i === current);
        });
    }

    prevBtn.addEventListener('click', function () { current--; update(); });
    nextBtn.addEventListener('click', function () { current++; update(); });
    window.addEventListener('resize', function () { current = 0; buildDots(); update(); });

    buildDots();
    update();
})();
</script>
