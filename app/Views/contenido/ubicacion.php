<style>
    /* ══════════════════════════════════════════════════════════
       UBICACIÓN — Premium White 2026
    ══════════════════════════════════════════════════════════ */
    .ubicacion-section {
        background: #fff;
        padding: 5rem 0 5.5rem;
        position: relative;
        border-top: 1px solid #EEF0F3;
    }

    /* ── Encabezado ── */
    .ubicacion-hdr {
        text-align: center;
        margin-bottom: 3.5rem;
    }
    .ubicacion-eyebrow {
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
    .ubicacion-eyebrow::before,
    .ubicacion-eyebrow::after {
        content: '';
        display: inline-block;
        width: 18px; height: 2px;
        background: #FF0033;
        border-radius: 2px;
        flex-shrink: 0;
    }
    .ubicacion-title {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: clamp(1.8rem, 3vw, 2.5rem);
        font-weight: 800;
        color: #0F172A;
        letter-spacing: -0.025em;
        line-height: 1.15;
        margin-bottom: 0;
    }
    .ubicacion-title .ua { color: #FF0033; }

    /* ── Tarjeta de información ── */
    .ubicacion-info-card {
        background: #F9FAFB;
        border: 1.5px solid #EEF0F3;
        border-radius: 24px;
        padding: 2.5rem 2rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    /* ── Ítem de información ── */
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 1.35rem 0;
        border-bottom: 1px solid #EEF0F3;
        transition: background 0.15s;
    }
    .info-item:first-child { padding-top: 0; }
    .info-item:last-child  { border-bottom: none; padding-bottom: 0; }

    .info-icon-wrap {
        width: 44px; height: 44px;
        border-radius: 12px;
        background: rgba(255,0,51,0.07);
        border: 1px solid rgba(255,0,51,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #FF0033;
        font-size: 0.95rem;
        transition: background 0.2s, border-color 0.2s, transform 0.2s;
    }
    .info-item:hover .info-icon-wrap {
        background: rgba(255,0,51,0.12);
        border-color: rgba(255,0,51,0.22);
        transform: scale(1.06);
    }

    .info-label {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.72rem;
        font-weight: 700;
        color: #9CA3AF;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 5px;
    }
    .info-value {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.9rem;
        font-weight: 500;
        color: #374151;
        line-height: 1.6;
        margin: 0;
    }
    .info-value + .info-value { margin-top: 2px; }

    /* ── Mapa ── */
    .ubicacion-map-wrap {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        border: 1.5px solid #EEF0F3;
        box-shadow: 0 20px 55px rgba(0,0,0,0.08), 0 4px 14px rgba(0,0,0,0.04);
        height: 100%;
        min-height: 420px;
    }
    .mapa-iframe {
        width: 100%;
        height: 100%;
        min-height: 420px;
        border: 0;
        display: block;
    }
    /* Franja roja decorativa inferior */
    .ubicacion-map-wrap::after {
        content: '';
        position: absolute;
        bottom: 0; right: 0;
        width: 80px; height: 4px;
        background: #FF0033;
        border-radius: 4px 0 0 0;
        pointer-events: none;
    }

    /* ── Scroll reveal ── */
    .ubicacion-reveal {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    .ubicacion-reveal.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* ── Responsive ── */
    @media (max-width: 991px) {
        .ubicacion-info-card { height: auto; }
        .ubicacion-map-wrap  { min-height: 360px; }
        .mapa-iframe         { min-height: 360px; }
    }
    @media (max-width: 575px) {
        .ubicacion-section   { padding: 3rem 0 3.5rem; }
        .ubicacion-info-card { padding: 1.75rem 1.5rem; }
        .ubicacion-map-wrap  { min-height: 300px; }
        .mapa-iframe         { min-height: 300px; }
    }
</style>

<!-- ═══════════════════════════════════════════════════════════
     NUESTRA UBICACIÓN
═══════════════════════════════════════════════════════════ -->
<section class="ubicacion-section" id="ubicacion" aria-label="Nuestra ubicación">
    <div class="container">

        <!-- ── Encabezado ── -->
        <div class="ubicacion-hdr ubicacion-reveal">
            <p class="ubicacion-eyebrow">Dónde estamos</p>
            <h2 class="ubicacion-title">
                Nuestra <span class="ua">Ubicación</span>
            </h2>
        </div>

        <!-- ── Contenido ── -->
        <div class="row align-items-stretch g-4">

            <!-- Columna de información -->
            <div class="col-lg-5 ubicacion-reveal" style="transition-delay:0.08s;">
                <div class="ubicacion-info-card">

                    <div class="info-item">
                        <div class="info-icon-wrap">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <div class="info-label">Dirección</div>
                            <p class="info-value">Calle Sarmiento 177</p>
                            <p class="info-value">El Colorado, Formosa</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon-wrap">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <div class="info-label">Teléfono</div>
                            <p class="info-value">(+54) 370 461-6482</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon-wrap">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <div class="info-label">Horario de atención</div>
                            <p class="info-value">Lun – Vie: 8:00 – 12:00 hs y 16:00 – 20:00 hs</p>
                            <p class="info-value">Sábados: 8:00 – 12:00 hs</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Mapa -->
            <div class="col-lg-7 ubicacion-reveal" style="transition-delay:0.16s;">
                <div class="ubicacion-map-wrap">
                    <iframe class="mapa-iframe"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3576.483416505246!2d-59.37469782497257!3d-26.310841677011034!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9443915317fd14ed%3A0xbd0406a56294362!2sSarmiento%20177%2C%20P3603%20El%20Colorado%2C%20Formosa!5e0!3m2!1ses!2sar!4v1745451130862!5m2!1ses!2sar"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        title="Ubicación de Centro Informático Regional">
                    </iframe>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
(function () {
    var els = document.querySelectorAll('.ubicacion-reveal');
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
