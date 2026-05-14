<style>
    .hero-section {
        min-height: 90vh;
        background: linear-gradient(135deg, #070c1a 0%, var(--dark-2) 55%, #0c1117 100%);
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    .hero-bottom-fade {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100px;
        background: linear-gradient(to bottom, transparent 0%, #0c1117 100%);
        pointer-events: none;
        z-index: 0;
    }
    .hero-glow-1 {
        position: absolute;
        width: 650px; height: 650px;
        background: radial-gradient(circle, rgba(255,0,51,0.14) 0%, transparent 70%);
        top: -150px; right: -150px;
        border-radius: 50%;
        pointer-events: none;
    }
    .hero-glow-2 {
        position: absolute;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(255,0,51,0.07) 0%, transparent 70%);
        bottom: -100px; left: -100px;
        border-radius: 50%;
        pointer-events: none;
    }
    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,0,51,0.12);
        border: 1px solid rgba(255,0,51,0.4);
        color: var(--rojo);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        padding: 7px 18px;
        border-radius: 50px;
        margin-bottom: 1.6rem;
    }
    .hero-title {
        font-size: clamp(2.2rem, 5vw, 4rem);
        font-weight: 900;
        line-height: 1.12;
        color: #fff;
        margin-bottom: 1.5rem;
    }
    .hero-title .accent { color: var(--rojo); }
    .hero-desc {
        font-size: 1.1rem;
        color: rgba(255,255,255,0.68);
        line-height: 1.85;
        max-width: 520px;
        margin-bottom: 2.5rem;
    }
    .hero-img-wrap img {
        width: 100%;
        max-width: 620px;
        display: block;
        filter: drop-shadow(0 0 32px rgba(255,0,51,0.18));
    }

    @media (max-width: 991px) { .hero-img-wrap { display: none; } }
    @media (max-width: 575px) { .hero-title { font-size: 2rem; } }
</style>

<!-- ═══════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════ -->
<section class="hero-section">
    <div class="hero-glow-1"></div>
    <div class="hero-glow-2"></div>

    <div class="container position-relative" style="z-index:1;">
        <div class="row align-items-center g-5 py-5">

            <div class="col-lg-6">
                <div class="hero-badge">
                    <i class="fas fa-map-marker-alt"></i>
                    El Colorado, Formosa
                </div>
                <h1 class="hero-title">
                    Tu aliado en<br>
                    <span class="accent">Tecnología</span>
                </h1>
                <p class="hero-desc">
                    Soluciones completas de informática para tu hogar y empresa. Venta de equipos, componentes y servicio técnico especializado con garantía en cada trabajo.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#rubros" class="btn-rojo">
                        <i class="fas fa-th-large"></i> Ver Rubros
                    </a>
                    <a href="#servicio-tecnico" class="btn-outline-claro">
                        <i class="fas fa-tools"></i> Servicio Técnico
                    </a>
                </div>
            </div>

            <div class="col-lg-6 text-center hero-img-wrap">
                <img src="<?= base_url('assets/img/logocir_transparent.png') ?>"
                     alt="Centro Informático Regional">
            </div>

        </div>
    </div>
    <div class="hero-bottom-fade"></div>
</section>
