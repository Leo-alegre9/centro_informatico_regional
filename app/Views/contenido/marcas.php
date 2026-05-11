<style>
    .marcas-section {
        background: #fff;
        padding: 3.5rem 0;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
    }
    .marcas-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 2.5rem;
    }
    .marcas-header .ver-todas {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--rojo);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: gap 0.2s;
        padding-bottom: 6px;
    }
    .marcas-header .ver-todas:hover { gap: 10px; }

    /* ── Slider wrapper ── */
    .marcas-track-outer {
        position: relative;
        overflow: hidden;
    }
    .marcas-track-outer::before,
    .marcas-track-outer::after {
        content: '';
        position: absolute;
        top: 0; bottom: 0;
        width: 90px;
        z-index: 2;
        pointer-events: none;
    }
    .marcas-track-outer::before { left: 0; background: linear-gradient(to right, #fff 0%, transparent 100%); }
    .marcas-track-outer::after  { right: 0; background: linear-gradient(to left,  #fff 0%, transparent 100%); }

    .marcas-track {
        display: flex;
        gap: 1.2rem;
        width: max-content;
        animation: slide-marcas 38s linear infinite;
        padding: 0.5rem 0 1rem;
    }
    .marcas-track:hover,
    .marcas-track.is-paused { animation-play-state: paused; }

    @keyframes slide-marcas {
        from { transform: translateX(0); }
        to   { transform: translateX(-50%); }
    }

    /* ── Brand card ── */
    .marca-card {
        background: #fff;
        border: 1.5px solid #e8e8e8;
        border-radius: 14px;
        min-width: 165px;
        height: 88px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        flex-shrink: 0;
        transition: border-color 0.25s, box-shadow 0.25s, transform 0.25s;
        cursor: default;
        user-select: none;
        padding: 1rem 1.5rem;
    }
    .marca-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 8px 30px rgba(0,0,0,0.09);
        transform: translateY(-4px);
    }
    .marca-logo-img {
        max-height: 40px;
        max-width: 120px;
        width: auto;
        object-fit: contain;
        display: block;
        filter: grayscale(100%) contrast(0.75);
        opacity: 0.7;
        transition: filter 0.3s, opacity 0.3s;
    }
    .marca-card:hover .marca-logo-img {
        filter: grayscale(0%) contrast(1);
        opacity: 1;
    }
    /* Text fallback when no image */
    .marca-text-fallback {
        font-size: 1rem;
        font-weight: 800;
        color: #1F2937;
        letter-spacing: -0.4px;
        text-align: center;
        line-height: 1;
        transition: color 0.2s;
    }
    .marca-card:hover .marca-text-fallback { color: #FF0033; }

</style>

<!-- ═══════════════════════════════════════════════
     MARCAS
═══════════════════════════════════════════════ -->
<section class="marcas-section" id="marcas">
    <div class="container">
        <div class="marcas-header">
            <div>
                <span class="section-eyebrow">Respaldo comercial</span>
                <h2 class="section-heading mb-0">Nuestras Marcas</h2>
            </div>
            <a href="#marcas" class="ver-todas">Ver todas <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="marcas-track-outer">
        <div class="marcas-track" id="marcasTrack">
            <?php
            $marcas = [
                'Lenovo', 'HP', 'AMD', 'Intel', 'Samsung', 'LG',
                'Hikvision', 'TP-Link', 'Logitech', 'ADATA', 'BenQ', 'Apple', 'Epson',
            ];
            $slugs = [
                'Lenovo'    => 'lenovo',
                'HP'        => 'hp',
                'AMD'       => 'amd',
                'Intel'     => 'intel',
                'Samsung'   => 'samsung',
                'LG'        => 'lg',
                'Hikvision' => 'hikvision',
                'TP-Link'   => 'tplink',
                'Logitech'  => 'logitech',
                'ADATA'     => 'adata',
                'BenQ'      => 'benq',
                'Apple'     => 'apple',
                'Epson'     => 'epson',
            ];
            // Duplicate list for seamless infinite loop
            $allMarcas = array_merge($marcas, $marcas);
            ?>

            <?php foreach ($allMarcas as $m): ?>
            <div class="marca-card">
                <img src="<?= base_url('assets/img/marcas/' . $slugs[$m] . '.svg') ?>"
                     alt="<?= esc($m) ?>"
                     class="marca-logo-img"
                     loading="lazy"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                <div class="marca-text-fallback" style="display:none;"><?= esc($m) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</section>
