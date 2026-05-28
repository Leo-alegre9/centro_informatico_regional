<style>
    .nosotros-hero {
        background: linear-gradient(135deg, #070c1a 0%, var(--dark-2) 55%, #180a10 100%);
        padding: 4rem 0 0;
        position: relative;
        overflow: hidden;
    }
    .nosotros-hero-glow-1 {
        position: absolute;
        width: 600px; height: 600px;
        background: radial-gradient(circle, rgba(255,0,51,0.1) 0%, transparent 70%);
        top: -180px; right: -120px;
        border-radius: 50%;
        pointer-events: none;
    }
    .nosotros-hero-glow-2 {
        position: absolute;
        width: 350px; height: 350px;
        background: radial-gradient(circle, rgba(255,0,51,0.06) 0%, transparent 70%);
        bottom: 60px; left: -80px;
        border-radius: 50%;
        pointer-events: none;
    }
    .nosotros-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,0,51,0.12);
        border: 1px solid rgba(255,0,51,0.38);
        color: var(--rojo);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        padding: 7px 18px;
        border-radius: 50px;
        margin-bottom: 1.5rem;
    }
    .nosotros-title {
        font-size: clamp(2.2rem, 4vw, 3.4rem);
        font-weight: 900;
        color: #fff;
        line-height: 1.12;
        margin-bottom: 1.1rem;
    }
    .nosotros-title .accent { color: var(--rojo); }
    .nosotros-subtitle {
        color: rgba(255,255,255,0.6);
        font-size: 1.05rem;
        line-height: 1.85;
        max-width: 560px;
        margin-bottom: 0;
    }
    .nosotros-stats-bar {
        margin-top: 3.5rem;
        border-top: 1px solid rgba(255,255,255,0.07);
        display: grid;
        grid-template-columns: repeat(4, 1fr);
    }
    .nosotros-stat {
        padding: 1.8rem 1.5rem;
        text-align: center;
        border-right: 1px solid rgba(255,255,255,0.07);
        position: relative;
    }
    .nosotros-stat:last-child { border-right: none; }
    .nosotros-stat-num {
        font-size: clamp(1.9rem, 3vw, 2.6rem);
        font-weight: 900;
        color: #fff;
        line-height: 1;
        margin-bottom: 0.3rem;
    }
    .nosotros-stat-num span { color: var(--rojo); }
    .nosotros-stat-label {
        color: rgba(255,255,255,0.45);
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }
    @media (max-width: 767px) {
        .nosotros-stats-bar { grid-template-columns: repeat(2, 1fr); }
        .nosotros-stat:nth-child(2) { border-right: none; }
        .nosotros-stat:nth-child(3) { border-top: 1px solid rgba(255,255,255,0.07); }
        .nosotros-stat:nth-child(4) { border-right: none; border-top: 1px solid rgba(255,255,255,0.07); }
    }
    .nosotros-hero-foto {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        opacity: 0.18;
        pointer-events: none;
        z-index: 0;
    }
    @media (max-width: 575px) {
        .nosotros-hero { padding: 3rem 0 0; }
    }
</style>

<?php
$imgFrenteRuta = FCPATH . 'assets/img/imagen_frente_cir.jpeg';
$imgFrenteUrl  = base_url('assets/img/imagen_frente_cir.jpeg');
$imgFrenteOk   = file_exists($imgFrenteRuta) && filesize($imgFrenteRuta) > 0;
?>

<!-- ═══════════════════════════════════════════════
     NOSOTROS — HERO
═══════════════════════════════════════════════ -->
<section class="nosotros-hero">
    <?php if ($imgFrenteOk): ?>
    <div class="nosotros-hero-foto"
         style="background-image:url('<?= $imgFrenteUrl ?>')"></div>
    <?php endif; ?>
    <div class="nosotros-hero-glow-1"></div>
    <div class="nosotros-hero-glow-2"></div>

    <div class="container position-relative" style="z-index:1;">
        <div class="row align-items-center g-5 pb-4">

            <div class="col-lg-7">
                <div class="nosotros-badge">
                    <i class="fas fa-map-marker-alt"></i>
                    Fundada en 1997 &mdash; Formosa
                </div>
                <h1 class="nosotros-title">
                    Quiénes<br><span class="accent">Somos</span>
                </h1>
                <p class="nosotros-subtitle">
                    Más de 28 años acompañando el crecimiento de Formosa y la región con soluciones tecnológicas, mobiliario y equipamiento comercial de primera calidad.
                </p>
            </div>

        </div>
    </div>

    <div class="nosotros-stats-bar">
        <div class="nosotros-stat">
            <div class="nosotros-stat-num">1997</div>
            <div class="nosotros-stat-label">Año de fundación</div>
        </div>
        <div class="nosotros-stat">
            <div class="nosotros-stat-num"><span>+</span>28</div>
            <div class="nosotros-stat-label">Años de trayectoria</div>
        </div>
        <div class="nosotros-stat">
            <div class="nosotros-stat-num"><span>+</span>50</div>
            <div class="nosotros-stat-label">Marcas representadas</div>
        </div>
        <div class="nosotros-stat">
            <div class="nosotros-stat-num">2</div>
            <div class="nosotros-stat-label">Provincias con presencia</div>
        </div>
    </div>
</section>
