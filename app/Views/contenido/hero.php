<style>
    /* ══════════════════════════════════════════════════════════
       HERO — White Premium 2026
    ══════════════════════════════════════════════════════════ */
    .hero-section {
        min-height: 90vh;
        background: #fff;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid #EEF0F3;
    }

    /* Fondo decorativo: dot grid sutil */
    .hero-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle, #E5E7EB 1px, transparent 1px);
        background-size: 28px 28px;
        opacity: 0.45;
        pointer-events: none;
    }
    /* Fade blanco que apaga el grid cerca del contenido */
    .hero-section::after {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 65% 80% at 30% 50%, rgba(255,255,255,0.97) 0%, rgba(255,255,255,0.6) 55%, transparent 75%),
            radial-gradient(ellipse 50% 70% at 80% 50%, rgba(255,255,255,0.85) 0%, transparent 70%);
        pointer-events: none;
    }

    .hero-inner {
        position: relative;
        z-index: 1;
        width: 100%;
        padding: 5rem 0 4.5rem;
    }

    /* ── LEFT: Text ── */
    .hero-eyebrow {
        display: flex;
        align-items: center;
        gap: 9px;
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: #9CA3AF;
        margin-bottom: 1.3rem;
        animation: heroFadeUp 0.55s ease both;
    }
    .hero-eyebrow-line {
        display: inline-block;
        width: 22px; height: 2px;
        background: #FF0033;
        border-radius: 2px;
        flex-shrink: 0;
    }

    .hero-title {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: clamp(2rem, 3.8vw, 3.1rem);
        font-weight: 800;
        line-height: 1.15;
        color: #0F172A;
        letter-spacing: -0.025em;
        margin-bottom: 1.3rem;
        animation: heroFadeUp 0.55s ease 0.1s both;
    }
    .hero-title .ha { color: #FF0033; }

    .hero-desc {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 1rem;
        color: #6B7280;
        line-height: 1.85;
        max-width: 480px;
        margin-bottom: 2rem;
        animation: heroFadeUp 0.55s ease 0.18s both;
    }

    /* CTAs */
    .hero-ctas {
        display: flex;
        flex-wrap: wrap;
        gap: 0.7rem;
        animation: heroFadeUp 0.55s ease 0.26s both;
    }
    .hero-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #FF0033;
        color: #fff !important;
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.88rem;
        font-weight: 700;
        padding: 0.78rem 1.65rem;
        border-radius: 50px;
        text-decoration: none;
        box-shadow: 0 4px 18px rgba(255,0,51,0.28);
        transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
    }
    .hero-btn-primary:hover {
        background: #cc0029;
        box-shadow: 0 7px 24px rgba(255,0,51,0.38);
        transform: translateY(-2px);
        color: #fff !important;
    }
    .hero-btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        color: #374151 !important;
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.88rem;
        font-weight: 600;
        padding: 0.78rem 1.65rem;
        border-radius: 50px;
        text-decoration: none;
        border: 1.5px solid #E5E7EB;
        transition: border-color 0.2s, background 0.2s, color 0.2s, transform 0.15s;
    }
    .hero-btn-secondary:hover {
        border-color: #25D366;
        color: #1a9e4e !important;
        background: #F0FDF4;
        transform: translateY(-2px);
    }
    .hero-btn-secondary .wa-icon { color: #25D366; }

    /* ── RIGHT: Logo ── */
    .hero-logo-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        animation: heroFadeIn 0.7s ease 0.3s both;
    }
    /* Glow ambiental detrás del logo */
    .hero-logo-wrap::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 70% 55% at 50% 50%,
            rgba(255,0,51,0.08) 0%,
            rgba(255,0,51,0.03) 55%,
            transparent 75%);
        filter: blur(30px);
        border-radius: 50%;
        pointer-events: none;
    }
    .hero-logo-img {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 520px;
        height: auto;
        display: block;
        object-fit: contain;
    }

    /* ── Keyframes ── */
    @keyframes heroFadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes heroFadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

    /* ── Responsive ── */
    @media (max-width: 991px) {
        .hero-inner { padding: 3.5rem 0 3rem; }
        .hero-desc { max-width: 100%; }
        .hero-logo-img { max-width: 380px; }
    }
    @media (max-width: 767px) {
        .hero-inner { padding: 3rem 0 2.5rem; }
        .hero-logo-wrap { margin-top: 2rem; }
        .hero-logo-img { max-width: 280px; }
    }
    @media (max-width: 575px) {
        .hero-title { font-size: 1.85rem; letter-spacing: -0.02em; }
    }
</style>

<!-- ═══════════════════════════════════════════════════════════
     HERO SECTION
═══════════════════════════════════════════════════════════ -->
<section class="hero-section" aria-label="Presentación de Centro Informático Regional">
    <div class="hero-inner">
        <div class="container">
            <div class="row align-items-center g-5">

                <!-- ── LEFT: Contenido principal ── -->
                <div class="col-lg-6">

                    <p class="hero-eyebrow">
                        <span class="hero-eyebrow-line"></span>
                        Centro Informático Regional
                    </p>

                    <h1 class="hero-title">
                        Tecnología, hogar y<br>
                        equipamiento para<br>
                        <span class="ha">cada necesidad.</span>
                    </h1>

                    <p class="hero-desc">
                        Encontrá informática, muebles, electrodomésticos y soluciones
                        comerciales en un solo lugar. Calidad y asesoramiento real.
                    </p>

                    <div class="hero-ctas">
                        <a href="<?= base_url('catalogo') ?>" class="hero-btn-primary">
                            <i class="fas fa-th-large"></i> Ver Catálogo
                        </a>
                        <a href="https://wa.me/5493704616482?text=Hola%2C%20quiero%20consultar%20sobre%20sus%20productos"
                           target="_blank" rel="noopener noreferrer"
                           class="hero-btn-secondary">
                            <i class="fab fa-whatsapp wa-icon"></i> Consultar por WhatsApp
                        </a>
                    </div>

                </div>

                <!-- ── RIGHT: Logo ── -->
                <div class="col-lg-6 hero-logo-wrap">
                    <img src="<?= base_url('assets/img/CIR_sinfondo.png') ?>"
                         alt="Centro Informático Regional"
                         class="hero-logo-img">
                </div>

            </div>
        </div>
    </div>
</section>
