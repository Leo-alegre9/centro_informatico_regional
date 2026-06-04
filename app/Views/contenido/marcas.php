<style>
    /* ══════════════════════════════════════════════════════════
       MARCAS — Premium White 2026
    ══════════════════════════════════════════════════════════ */
    .marcas-section {
        background: #F9FAFB;
        padding: 5rem 0 5.5rem;
        position: relative;
        border-top: 1px solid #EEF0F3;
    }

    /* ── Encabezado ── */
    .marcas-hdr {
        text-align: center;
        margin-bottom: 3.5rem;
    }
    .marcas-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.67rem;
        font-weight: 700;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: #9CA3AF;
        margin-bottom: 0.85rem;
    }
    .marcas-eyebrow::before,
    .marcas-eyebrow::after {
        content: '';
        display: inline-block;
        width: 18px; height: 2px;
        background: #FF0033;
        border-radius: 2px;
        flex-shrink: 0;
    }
    .marcas-title {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: clamp(1.8rem, 3vw, 2.5rem);
        font-weight: 800;
        color: #0F172A;
        letter-spacing: -0.025em;
        line-height: 1.18;
        margin-bottom: 0;
    }
    .marcas-title .ma { color: #FF0033; }

    /* ── Carrusel ── */
    .marcas-track-outer {
        position: relative;
        overflow: hidden;
    }
    .marcas-track-outer::before,
    .marcas-track-outer::after {
        content: '';
        position: absolute;
        top: 0; bottom: 0;
        width: 120px;
        z-index: 2;
        pointer-events: none;
    }
    .marcas-track-outer::before {
        left: 0;
        background: linear-gradient(to right, #F9FAFB 0%, transparent 100%);
    }
    .marcas-track-outer::after {
        right: 0;
        background: linear-gradient(to left, #F9FAFB 0%, transparent 100%);
    }

    .marcas-track {
        display: flex;
        gap: 14px;
        width: max-content;
        padding: 0.75rem 0 1rem;
        animation: marcas-slide 40s linear infinite;
        will-change: transform;
    }
    .marcas-track:hover { animation-play-state: paused; }

    @keyframes marcas-slide {
        from { transform: translateX(0); }
        to   { transform: translateX(-50%); }
    }

    /* ── Tarjeta de marca ── */
    .marca-card {
        background: #fff;
        border: 1.5px solid #EEF0F3;
        border-radius: 18px;
        padding: 1.8rem 1.75rem 1.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.55rem;
        text-align: center;
        flex-shrink: 0;
        min-width: 158px;
        min-height: 120px;
        position: relative;
        overflow: hidden;
        cursor: default;
        user-select: none;
        transition:
            transform    0.25s cubic-bezier(.4,0,.2,1),
            box-shadow   0.25s,
            border-color 0.25s;
    }
    .marca-card::after {
        content: '';
        position: absolute;
        bottom: 0; left: 50%;
        transform: translateX(-50%);
        width: 0; height: 2.5px;
        background: #FF0033;
        border-radius: 2px 2px 0 0;
        transition: width 0.28s cubic-bezier(.4,0,.2,1);
    }
    .marca-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 18px 44px rgba(0,0,0,0.08), 0 4px 12px rgba(0,0,0,0.04);
        border-color: rgba(255,0,51,0.15);
    }
    .marca-card:hover::after { width: 55%; }

    .marca-logo-img {
        max-height: 38px;
        max-width: 110px;
        width: auto;
        height: auto;
        object-fit: contain;
        display: block;
        filter: grayscale(100%) contrast(0.75);
        opacity: 0.5;
        transition: filter 0.3s ease, opacity 0.3s ease;
    }
    .marca-card:hover .marca-logo-img {
        filter: grayscale(0%) contrast(1);
        opacity: 1;
    }

    .marca-name-display {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 1rem;
        font-weight: 800;
        color: #374151;
        letter-spacing: -0.015em;
        line-height: 1;
        transition: color 0.2s;
    }
    .marca-card:hover .marca-name-display { color: #0F172A; }

    .marca-cat-tag {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.62rem;
        font-weight: 500;
        color: #C4C9D4;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        transition: color 0.2s;
    }
    .marca-card:hover .marca-cat-tag { color: #9CA3AF; }

    /* ── Scroll reveal ── */
    .marcas-reveal {
        opacity: 0;
        transform: translateY(22px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    .marcas-reveal.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* ── Responsive ── */
    @media (max-width: 991px) {
        .marcas-track-outer::before,
        .marcas-track-outer::after { width: 60px; }
    }
    @media (max-width: 575px) {
        .marcas-section { padding: 3rem 0 3.5rem; }
        .marca-card { min-width: 138px; min-height: 108px; padding: 1.4rem 1.25rem 1.2rem; }
        .marcas-track-outer::before,
        .marcas-track-outer::after { width: 40px; }
    }
</style>

<?php
$marcasMeta = [
    'HP'        => ['slug' => 'hp',       'cat' => 'Informática'],
    'Lenovo'    => ['slug' => 'lenovo',   'cat' => 'Informática', 'img' => 'LogoLenovo.png'],
    'Samsung'   => ['slug' => 'samsung',  'cat' => 'Electrónica'],
    'LG'        => ['slug' => 'lg',       'cat' => 'Electrónica'],
    'Epson'     => ['slug' => 'epson',    'cat' => 'Impresoras'],
    'Logitech'  => ['slug' => 'logitech', 'cat' => 'Periféricos'],
    'Intel'     => ['slug' => 'intel',    'cat' => 'Procesadores'],
    'AMD'       => ['slug' => 'amd',      'cat' => 'Procesadores'],
    'Apple'     => ['slug' => 'apple',    'cat' => 'Informática'],
    'BenQ'      => ['slug' => 'benq',     'cat' => 'Monitores'],
    'TP-Link'   => ['slug' => 'tplink',   'cat' => 'Redes'],
    'Hikvision' => ['slug' => 'hikvision','cat' => 'Seguridad'],
    'ADATA'     => ['slug' => 'adata',    'cat' => 'Almacenamiento'],
    'Inelro'    => ['slug' => 'inelro',   'cat' => 'Electrónica',   'img' => 'logoInelro.png'],
];
?>

<!-- ═══════════════════════════════════════════════════════════
     SECCIÓN: NUESTRAS MARCAS
═══════════════════════════════════════════════════════════ -->
<section class="marcas-section" id="marcas" aria-label="Marcas con las que trabajamos">
    <div class="container">
        <div class="marcas-hdr marcas-reveal">
            <p class="marcas-eyebrow">Respaldo comercial</p>
            <h2 class="marcas-title">
                Trabajamos con las <span class="ma">mejores marcas</span>
            </h2>
        </div>
    </div>

    <!-- Carrusel fuera del container para ocupar ancho completo -->
    <div class="marcas-track-outer" aria-hidden="true">
        <div class="marcas-track" id="marcasTrack">
            <?php /* Primera pasada */ foreach ($marcasMeta as $nombre => $meta): ?>
            <div class="marca-card">
                <img src="<?= base_url('assets/img/marcas/' . esc($meta['img'] ?? ($meta['slug'] . '.svg'))) ?>"
                     alt="Logo <?= esc($nombre) ?>"
                     class="marca-logo-img"
                     loading="lazy"
                     onerror="this.style.display='none';"
                     onload="this.nextElementSibling.style.display='none';this.nextElementSibling.nextElementSibling.style.display='none';">
                <div class="marca-name-display"><?= esc($nombre) ?></div>
                <div class="marca-cat-tag"><?= esc($meta['cat']) ?></div>
            </div>
            <?php endforeach; ?>
            <?php /* Segunda pasada — idéntica, para el loop sin corte */ foreach ($marcasMeta as $nombre => $meta): ?>
            <div class="marca-card">
                <img src="<?= base_url('assets/img/marcas/' . esc($meta['img'] ?? ($meta['slug'] . '.svg'))) ?>"
                     alt="Logo <?= esc($nombre) ?>"
                     class="marca-logo-img"
                     loading="lazy"
                     onerror="this.style.display='none';"
                     onload="this.nextElementSibling.style.display='none';this.nextElementSibling.nextElementSibling.style.display='none';">
                <div class="marca-name-display"><?= esc($nombre) ?></div>
                <div class="marca-cat-tag"><?= esc($meta['cat']) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</section>

<script>
(function () {
    var els = document.querySelectorAll('.marcas-reveal');
    if (!els.length) return;
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.08 });
    els.forEach(function (el) { io.observe(el); });
})();
</script>
