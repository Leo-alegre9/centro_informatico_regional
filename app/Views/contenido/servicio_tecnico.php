<style>
    /* ══════════════════════════════════════════════════════════
       SERVICIO TÉCNICO — Premium White 2026
    ══════════════════════════════════════════════════════════ */
    .tech-section {
        background: #fff;
        padding: 5rem 0 5.5rem;
        position: relative;
        overflow: hidden;
        border-top: 1px solid #EEF0F3;
    }

    /* Dot grid sutil — idéntico al Hero */
    .tech-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle, #E5E7EB 1px, transparent 1px);
        background-size: 28px 28px;
        opacity: 0.45;
        pointer-events: none;
        z-index: 0;
    }
    /* Fade que apaga el grid cerca del contenido — idéntico al Hero */
    .tech-section::after {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 65% 80% at 30% 50%, rgba(255,255,255,0.97) 0%, rgba(255,255,255,0.6) 55%, transparent 75%),
            radial-gradient(ellipse 50% 70% at 80% 50%, rgba(255,255,255,0.85) 0%, transparent 70%);
        pointer-events: none;
        z-index: 0;
    }

    .tech-inner { position: relative; z-index: 1; }

    /* ── Eyebrow ── */
    .tech-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.67rem;
        font-weight: 700;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: #9CA3AF;
        margin-bottom: 1rem;
    }
    .tech-eyebrow::before,
    .tech-eyebrow::after {
        content: '';
        display: inline-block;
        width: 18px; height: 2px;
        background: #FF0033;
        border-radius: 2px;
        flex-shrink: 0;
    }

    /* ── Título ── */
    .tech-title {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: clamp(2rem, 3.8vw, 3rem);
        font-weight: 800;
        color: #0F172A;
        line-height: 1.15;
        letter-spacing: -0.025em;
        margin-bottom: 1.1rem;
    }
    .tech-title .ta { color: #FF0033; }

    /* ── Descripción ── */
    .tech-desc {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 1rem;
        color: #6B7280;
        line-height: 1.85;
        margin-bottom: 2rem;
        max-width: 460px;
    }

    /* ── Check list moderna ── */
    .tech-check-list {
        display: flex;
        flex-direction: column;
        gap: 11px;
        margin-bottom: 2.5rem;
    }
    .tech-check-item {
        display: flex;
        align-items: center;
        gap: 13px;
    }
    .tech-check-icon {
        width: 28px; height: 28px;
        border-radius: 50%;
        background: rgba(255,0,51,0.08);
        border: 1px solid rgba(255,0,51,0.22);
        color: #FF0033;
        font-size: 0.6rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: background 0.2s, border-color 0.2s;
    }
    .tech-check-item:hover .tech-check-icon {
        background: rgba(255,0,51,0.14);
        border-color: rgba(255,0,51,0.4);
    }
    .tech-check-text {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.88rem;
        font-weight: 500;
        color: #374151;
        transition: color 0.2s;
    }
    .tech-check-item:hover .tech-check-text { color: #0F172A; }

    /* ── CTAs ── */
    .tech-ctas {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
    .tech-btn-primary {
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
    .tech-btn-primary:hover {
        background: #cc0029;
        box-shadow: 0 7px 24px rgba(255,0,51,0.38);
        transform: translateY(-2px);
        color: #fff !important;
    }
    .tech-btn-secondary {
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
    .tech-btn-secondary .wa-c { color: #25D366; }
    .tech-btn-secondary:hover {
        border-color: #25D366;
        color: #1a9e4e !important;
        background: #F0FDF4;
        transform: translateY(-2px);
    }

    /* ── Imagen ── */
    .tech-visual-wrap { position: relative; }

    .tech-img-frame {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid #EEF0F3;
        box-shadow: 0 24px 60px rgba(0,0,0,0.1), 0 6px 18px rgba(0,0,0,0.06);
    }
    .tech-img-frame img {
        width: 100%;
        display: block;
        object-fit: cover;
        min-height: 380px;
        transition: transform 0.55s cubic-bezier(.4,0,.2,1);
    }
    .tech-img-frame:hover img { transform: scale(1.04); }

    /* Borde rojo decorativo inferior izquierdo */
    .tech-img-frame::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0;
        width: 80px; height: 4px;
        background: #FF0033;
        border-radius: 0 4px 0 0;
    }

    /* ── Scroll reveal ── */
    .tech-reveal {
        opacity: 0;
        transform: translateY(22px);
        transition: opacity 0.55s ease, transform 0.55s ease;
    }
    .tech-reveal.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* ── Responsive ── */
    @media (max-width: 991px) {
        .tech-desc { max-width: 100%; }
    }
    @media (max-width: 767px) {
        .tech-visual-wrap { margin-top: 2.5rem; }
        .tech-img-frame img { min-height: 260px; }
    }
    @media (max-width: 575px) {
        .tech-section { padding: 3.5rem 0 3rem; }
    }
</style>

<!-- ═══════════════════════════════════════════════════════════
     SERVICIO TÉCNICO
═══════════════════════════════════════════════════════════ -->
<section class="tech-section" id="servicio-tecnico" aria-label="Servicio Técnico Especializado">
    <div class="container tech-inner">
        <div class="row align-items-center g-5">

            <!-- ══ Columna izquierda: contenido ══ -->
            <div class="col-lg-6">

                <div class="tech-reveal">
                    <p class="tech-eyebrow">Soporte profesional</p>
                    <h2 class="tech-title">
                        Servicio Técnico<br>
                        <span class="ta">Especializado</span>
                    </h2>
                    <p class="tech-desc">
                        Nuestro equipo de técnicos altamente capacitados está listo para resolver
                        cualquier problema con tu equipo, con rapidez y garantía en cada intervención.
                    </p>
                </div>

                <div class="tech-check-list tech-reveal" style="transition-delay:0.1s;">
                    <div class="tech-check-item">
                        <div class="tech-check-icon"><i class="fas fa-check"></i></div>
                        <span class="tech-check-text">Mantenimiento preventivo y correctivo de equipos</span>
                    </div>
                    <div class="tech-check-item">
                        <div class="tech-check-icon"><i class="fas fa-check"></i></div>
                        <span class="tech-check-text">Diagnóstico y reparación de hardware y software</span>
                    </div>
                    <div class="tech-check-item">
                        <div class="tech-check-icon"><i class="fas fa-check"></i></div>
                        <span class="tech-check-text">Soporte técnico especializado en sitio</span>
                    </div>
                    <div class="tech-check-item">
                        <div class="tech-check-icon"><i class="fas fa-check"></i></div>
                        <span class="tech-check-text">Instalación de redes y sistemas</span>
                    </div>
                    <div class="tech-check-item">
                        <div class="tech-check-icon"><i class="fas fa-check"></i></div>
                        <span class="tech-check-text">Garantía en todos nuestros trabajos</span>
                    </div>
                </div>

                <div class="tech-ctas tech-reveal" style="transition-delay:0.2s;">
                    <a href="<?= base_url('servicio-tecnico') ?>" class="tech-btn-primary">
                        <i class="fas fa-screwdriver-wrench"></i> Solicitar asistencia
                    </a>
                    <a href="https://wa.me/5493704616482?text=Hola%2C%20quiero%20consultar%20sobre%20el%20servicio%20t%C3%A9cnico"
                       target="_blank" rel="noopener noreferrer"
                       class="tech-btn-secondary">
                        <i class="fab fa-whatsapp wa-c"></i> Consultar por WhatsApp
                    </a>
                </div>

            </div>

            <!-- ══ Columna derecha: imagen ══ -->
            <div class="col-lg-6 tech-reveal" style="transition-delay:0.14s;">
                <div class="tech-visual-wrap">
                    <div class="tech-img-frame">
                        <img src="<?= base_url('assets/img/servicio_técnico.jpeg') ?>"
                             alt="Técnico realizando mantenimiento de equipo informático"
                             loading="lazy">
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
(function () {
    var els = document.querySelectorAll('.tech-reveal');
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
