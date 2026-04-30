<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro Informático Regional</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* ── Variables ── */
        :root {
            --rojo:       #FF0033;
            --rojo-dark:  #cc0029;
            --dark:       #111827;
            --dark-2:     #1F2937;
            --gris:       #4B5563;
            --fondo:      #F5F5F5;
        }
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { margin: 0; font-family: 'Segoe UI', Arial, sans-serif; color: #333; background: #fff; }

        /* ── Navbar ── */
        .navbar-cir {
            background-color: var(--dark);
            padding: 0.85rem 0;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: 0 2px 14px rgba(0,0,0,0.35);
        }
        .navbar-brand-cir {
            color: #fff;
            font-size: 1.2rem;
            font-weight: 800;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: -0.3px;
        }
        .navbar-brand-cir img {
            height: 38px;
            border-radius: 7px;
            object-fit: cover;
        }
        .brand-accent { color: var(--rojo); }
        .nav-link-cir {
            color: rgba(255,255,255,0.82) !important;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.45rem 1rem !important;
            border-radius: 6px;
            transition: color 0.2s, background 0.2s;
        }
        .nav-link-cir:hover { color: #fff !important; background: rgba(255,255,255,0.07); }
        .nav-cta {
            background-color: var(--rojo) !important;
            color: #fff !important;
            border-radius: 50px !important;
            padding: 0.45rem 1.4rem !important;
            font-weight: 700 !important;
        }
        .nav-cta:hover { background-color: var(--rojo-dark) !important; }
        .navbar-toggler-cir {
            background: none;
            border: 1px solid rgba(255,255,255,0.3);
            color: #fff;
            padding: 6px 12px;
            border-radius: 7px;
            cursor: pointer;
        }

        /* ── Hero ── */
        .hero-section {
            min-height: 90vh;
            background: linear-gradient(135deg, #070c1a 0%, var(--dark-2) 55%, #180a10 100%);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
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
        .btn-rojo {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: var(--rojo);
            color: #fff;
            padding: 0.85rem 2.2rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.97rem;
            text-decoration: none;
            border: 2px solid var(--rojo);
            transition: background 0.25s, color 0.25s;
        }
        .btn-rojo:hover { background-color: var(--rojo-dark); color: #fff; border-color: var(--rojo-dark); }
        .btn-outline-claro {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: transparent;
            color: #fff;
            padding: 0.85rem 2.2rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.97rem;
            text-decoration: none;
            border: 2px solid rgba(255,255,255,0.28);
            transition: border-color 0.25s, color 0.25s;
        }
        .btn-outline-claro:hover { border-color: #fff; color: #fff; }
        .hero-img-wrap img {
            width: 100%;
            max-width: 480px;
            border-radius: 20px;
            border: 3px solid rgba(255,0,51,0.35);
            box-shadow: 0 30px 80px rgba(0,0,0,0.5), 0 0 60px rgba(255,0,51,0.08);
        }

        /* ── Stats bar ── */
        .stats-bar {
            background: var(--dark-2);
            padding: 2rem 0;
            border-bottom: 3px solid var(--rojo);
        }
        .stat-item { text-align: center; }
        .stat-number {
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--rojo);
            line-height: 1;
        }
        .stat-label {
            font-size: 0.78rem;
            color: rgba(255,255,255,0.55);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-top: 5px;
        }

        /* ── Section helpers ── */
        .section-eyebrow {
            display: inline-block;
            color: var(--rojo);
            font-weight: 700;
            font-size: 0.78rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }
        .section-heading {
            font-size: clamp(1.8rem, 3vw, 2.6rem);
            font-weight: 800;
            color: var(--dark-2);
            margin-bottom: 0.75rem;
        }
        .section-divider {
            width: 55px;
            height: 4px;
            background: var(--rojo);
            border-radius: 2px;
            margin: 0 auto 3rem;
        }

        /* ── Rubros grid ── */
        .rubros-section { background: #fff; }
        .rubros-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.4rem;
        }
        .rubro-card {
            background: var(--dark-2);
            border-radius: 18px;
            padding: 2rem 1.8rem;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            gap: 0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-bottom: 3px solid transparent;
        }
        .rubro-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 22px 55px rgba(0,0,0,0.22);
            border-bottom-color: var(--rojo);
        }
        .rubro-icon {
            width: 58px; height: 58px;
            border-radius: 14px;
            background: rgba(255,0,51,0.1);
            border: 1.5px solid rgba(255,0,51,0.28);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: var(--rojo);
            margin-bottom: 1.1rem;
            transition: background 0.25s, color 0.25s, border-color 0.25s;
        }
        .rubro-card:hover .rubro-icon {
            background: var(--rojo);
            color: #fff;
            border-color: var(--rojo);
        }
        .rubro-name {
            color: #fff;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .rubro-desc-text {
            color: rgba(255,255,255,0.55);
            font-size: 0.87rem;
            line-height: 1.6;
            flex: 1;
            margin-bottom: 1.1rem;
        }
        .rubro-link {
            color: var(--rojo);
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: gap 0.2s;
        }
        .rubro-card:hover .rubro-link { gap: 10px; }

        /* ── Servicio Técnico ── */
        .tech-section { background: var(--fondo); }
        .check-list {
            list-style: none;
            padding: 0;
            margin: 0 0 2rem;
        }
        .check-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 0;
            border-bottom: 1px solid #e5e7eb;
            color: var(--dark-2);
            font-size: 1rem;
            font-weight: 500;
        }
        .check-list li:last-child { border-bottom: none; }
        .check-list li i { color: var(--rojo); font-size: 1.05rem; flex-shrink: 0; }
        .tech-img {
            border-radius: 18px;
            border-left: 6px solid var(--rojo);
            border-right: 6px solid var(--rojo);
            box-shadow: 0 20px 65px rgba(0,0,0,0.13);
            width: 100%;
        }

        /* ── Contacto Rápido ── */
        .contacto-section { background: #fff; }
        .contacto-card {
            background: var(--dark-2);
            border-radius: 22px;
            padding: 3.5rem;
            border-left: 7px solid var(--rojo);
            box-shadow: 0 10px 45px rgba(0,0,0,0.1);
        }
        .contacto-card h2 { color: #fff; font-weight: 800; font-size: 2.1rem; }
        .contacto-card p { color: rgba(255,255,255,0.68); font-size: 1.05rem; line-height: 1.75; }

        /* ── Ubicación ── */
        .ubicacion-section { background: var(--fondo); }
        .info-circle {
            width: 50px; height: 50px;
            background: var(--rojo);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .info-circle i { color: #fff; font-size: 1rem; }
        .info-label { font-weight: 700; color: var(--dark-2); font-size: 0.95rem; }
        .info-value { color: var(--gris); font-size: 0.95rem; margin: 0; }
        .mapa-iframe {
            width: 100%;
            height: 420px;
            border: 0;
            border-radius: 18px;
            box-shadow: 0 12px 45px rgba(0,0,0,0.11);
            display: block;
        }

        /* ── Responsive ── */
        @media (max-width: 991px) {
            .rubros-grid { grid-template-columns: repeat(2, 1fr); }
            .hero-img-wrap { display: none; }
            .contacto-card { padding: 2.5rem 2rem; }
        }
        @media (max-width: 575px) {
            .rubros-grid { grid-template-columns: 1fr; }
            .hero-title { font-size: 2rem; }
            .contacto-card { padding: 2rem 1.5rem; }
            .contacto-card h2 { font-size: 1.6rem; }
        }
    </style>
</head>
<body>

<!-- ═══════════════════════════════════════════════
     NAVBAR
═══════════════════════════════════════════════ -->
<nav class="navbar-cir">
    <div class="container d-flex align-items-center justify-content-between gap-3">
        <a href="<?= base_url('/') ?>" class="navbar-brand-cir">
            <img src="<?= base_url('public/assets/img/logofinal.jpeg') ?>" alt="Logo CIR">
            Centro <span class="brand-accent ms-1">Informático</span>
        </a>

        <button class="navbar-toggler-cir d-lg-none" type="button"
                data-bs-toggle="collapse" data-bs-target="#navMenu" aria-expanded="false">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse d-lg-flex align-items-center gap-1" id="navMenu">
            <a href="#rubros"           class="nav-link-cir">Rubros</a>
            <a href="#servicio-tecnico" class="nav-link-cir">Servicio Técnico</a>
            <a href="#ubicacion"        class="nav-link-cir">Ubicación</a>
            <a href="<?= base_url('contacto') ?>" class="nav-link-cir nav-cta ms-2">Contacto</a>
        </div>
    </div>
</nav>


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
                <img src="<?= base_url('public/assets/img/logofinal.jpeg') ?>"
                     alt="Centro Informático Regional">
            </div>

        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     STATS BAR
═══════════════════════════════════════════════ -->
<div class="stats-bar">
    <div class="container">
        <div class="row g-3">
            <div class="col-6 col-md-3 stat-item">
                <div class="stat-number">+5</div>
                <div class="stat-label">Años de experiencia</div>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <div class="stat-number">+500</div>
                <div class="stat-label">Clientes satisfechos</div>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <div class="stat-number">6</div>
                <div class="stat-label">Rubros disponibles</div>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <div class="stat-number">100%</div>
                <div class="stat-label">Garantía en servicios</div>
            </div>
        </div>
    </div>
</div>


<!-- ═══════════════════════════════════════════════
     RUBROS
═══════════════════════════════════════════════ -->
<section class="rubros-section py-5" id="rubros">
    <div class="container">
        <div class="text-center mb-2">
            <span class="section-eyebrow">Lo que ofrecemos</span>
            <h2 class="section-heading">Nuestros Rubros</h2>
        </div>
        <div class="section-divider"></div>

        <div class="rubros-grid">

            <a href="<?= base_url('catalogo/rubro/computadoras') ?>" class="rubro-card">
                <div class="rubro-icon"><i class="fas fa-laptop"></i></div>
                <div class="rubro-name">Computadoras y Notebooks</div>
                <div class="rubro-desc-text">PCs de escritorio, laptops y equipos de última generación para trabajo y gaming.</div>
                <div class="rubro-link">Explorar <i class="fas fa-arrow-right"></i></div>
            </a>

            <a href="<?= base_url('catalogo/rubro/perifericos') ?>" class="rubro-card">
                <div class="rubro-icon"><i class="fas fa-keyboard"></i></div>
                <div class="rubro-name">Periféricos y Accesorios</div>
                <div class="rubro-desc-text">Monitores, teclados, mouse, auriculares y todo lo que tu equipo necesita.</div>
                <div class="rubro-link">Explorar <i class="fas fa-arrow-right"></i></div>
            </a>

            <a href="<?= base_url('catalogo/rubro/componentes') ?>" class="rubro-card">
                <div class="rubro-icon"><i class="fas fa-microchip"></i></div>
                <div class="rubro-name">Componentes y Hardware</div>
                <div class="rubro-desc-text">RAM, SSD, procesadores y placas de video para actualizar o armar tu PC.</div>
                <div class="rubro-link">Explorar <i class="fas fa-arrow-right"></i></div>
            </a>

            <a href="<?= base_url('catalogo/rubro/redes') ?>" class="rubro-card">
                <div class="rubro-icon"><i class="fas fa-network-wired"></i></div>
                <div class="rubro-name">Redes e Infraestructura</div>
                <div class="rubro-desc-text">Routers, switches, cables y soluciones de conectividad para hogar y oficina.</div>
                <div class="rubro-link">Explorar <i class="fas fa-arrow-right"></i></div>
            </a>

            <a href="<?= base_url('catalogo/rubro/impresoras') ?>" class="rubro-card">
                <div class="rubro-icon"><i class="fas fa-print"></i></div>
                <div class="rubro-name">Impresoras y Consumibles</div>
                <div class="rubro-desc-text">Impresoras, tintas y tóneres para mantener tu oficina siempre en marcha.</div>
                <div class="rubro-link">Explorar <i class="fas fa-arrow-right"></i></div>
            </a>

            <a href="<?= base_url('catalogo/rubro/software') ?>" class="rubro-card">
                <div class="rubro-icon"><i class="fas fa-shield-alt"></i></div>
                <div class="rubro-name">Software y Seguridad</div>
                <div class="rubro-desc-text">Sistemas operativos, antivirus, licencias y soluciones de ciberseguridad.</div>
                <div class="rubro-link">Explorar <i class="fas fa-arrow-right"></i></div>
            </a>

        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     SERVICIO TÉCNICO
═══════════════════════════════════════════════ -->
<section class="tech-section py-5" id="servicio-tecnico">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-6">
                <span class="section-eyebrow">Soporte profesional</span>
                <h2 class="section-heading">Servicio Técnico<br>Especializado</h2>
                <p style="color: var(--gris); font-size: 1.05rem; line-height: 1.85; margin-bottom: 1.5rem;">
                    Nuestro equipo de técnicos altamente capacitados está listo para resolver cualquier problema con tu equipo, con rapidez y garantía en cada intervención.
                </p>
                <ul class="check-list">
                    <li><i class="fas fa-check-circle"></i> Mantenimiento preventivo y correctivo de equipos</li>
                    <li><i class="fas fa-check-circle"></i> Diagnóstico y reparación de hardware y software</li>
                    <li><i class="fas fa-check-circle"></i> Soporte técnico especializado en sitio</li>
                    <li><i class="fas fa-check-circle"></i> Instalación de redes y sistemas</li>
                    <li><i class="fas fa-check-circle"></i> Garantía en todos nuestros trabajos</li>
                </ul>
                <a href="<?= base_url('contacto') ?>" class="btn-rojo">
                    Solicitar servicio <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="col-lg-6 text-center">
                <img src="<?= base_url('public/assets/img/serviciotecnico.webp') ?>"
                     alt="Servicio Técnico Especializado"
                     class="tech-img">
            </div>

        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     CONTACTO RÁPIDO
═══════════════════════════════════════════════ -->
<section class="contacto-section py-5" id="contacto">
    <div class="container">
        <div class="contacto-card">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <span class="section-eyebrow">CONTACTO RÁPIDO</span>
                    <h2 class="mt-2 mb-3">¿Necesitas ayuda con tu equipo?</h2>
                    <p class="mb-0">
                        Nuestro equipo de expertos está listo para atenderte. Contáctanos ahora mismo y resuelve tus dudas sin compromiso.
                    </p>
                </div>
                <div class="col-lg-4 d-flex flex-column align-items-start align-items-lg-end gap-3">
                    <a href="<?= base_url('contacto') ?>" class="btn-rojo">
                        <i class="fas fa-envelope"></i> Enviar mensaje
                    </a>
                    <a href="https://wa.me/5493704616482" target="_blank" rel="noopener" class="btn-outline-claro">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     UBICACIÓN
═══════════════════════════════════════════════ -->
<section class="ubicacion-section py-5" id="ubicacion">
    <div class="container">
        <div class="text-center mb-2">
            <span class="section-eyebrow">Dónde estamos</span>
            <h2 class="section-heading">Nuestra Ubicación</h2>
        </div>
        <div class="section-divider"></div>

        <div class="row align-items-center g-5">

            <div class="col-lg-5">
                <div class="d-flex align-items-start gap-3 mb-4">
                    <div class="info-circle"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <div class="info-label">Dirección</div>
                        <p class="info-value">Calle Sarmiento 177, El Colorado, Formosa</p>
                    </div>
                </div>
                <div class="d-flex align-items-start gap-3 mb-4">
                    <div class="info-circle"><i class="fas fa-phone"></i></div>
                    <div>
                        <div class="info-label">Teléfono</div>
                        <p class="info-value">(+54) 370 461-6482</p>
                    </div>
                </div>
                <div class="d-flex align-items-start gap-3">
                    <div class="info-circle"><i class="fas fa-clock"></i></div>
                    <div>
                        <div class="info-label">Horario de atención</div>
                        <p class="info-value">Lun – Vie: 8:00 – 12:00 hs y 16:00 – 20:00 hs</p>
                        <p class="info-value">Sábados: 8:00 – 12:00 hs</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <iframe class="mapa-iframe"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3576.483416505246!2d-59.37469782497257!3d-26.310841677011034!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9443915317fd14ed%3A0xbd0406a56294362!2sSarmiento%20177%2C%20P3603%20El%20Colorado%2C%20Formosa!5e0!3m2!1ses!2sar!4v1745451130862!5m2!1ses!2sar"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════════ -->
<?php include 'componentes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
