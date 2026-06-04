<style>
    /* ══════════════════════════════════════════════════════════
       CONTACTO RÁPIDO — Premium White 2026
    ══════════════════════════════════════════════════════════ */
    .cta-section {
        background: #F9FAFB;
        padding: 5rem 0;
        position: relative;
        overflow: hidden;
        border-top: 1px solid #EEF0F3;
    }

    /* Acento decorativo: gran círculo rojo muy sutil en esquina derecha */
    .cta-section::before {
        content: '';
        position: absolute;
        top: -160px; right: -160px;
        width: 460px; height: 460px;
        background: radial-gradient(circle, rgba(255,0,51,0.055) 0%, transparent 65%);
        pointer-events: none;
        z-index: 0;
    }

    .cta-inner { position: relative; z-index: 1; }

    /* ── Card principal ── */
    .cta-card {
        background: #fff;
        border: 1.5px solid #EEF0F3;
        border-radius: 28px;
        padding: 3.5rem 3rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0,0,0,0.05), 0 2px 8px rgba(0,0,0,0.03);
    }
    /* Franja roja izquierda */
    .cta-card::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 4px;
        background: #FF0033;
        border-radius: 28px 0 0 28px;
    }

    /* ── Eyebrow ── */
    .cta-eyebrow {
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
    .cta-eyebrow::before {
        content: '';
        display: inline-block;
        width: 18px; height: 2px;
        background: #FF0033;
        border-radius: 2px;
        flex-shrink: 0;
    }

    /* ── Título ── */
    .cta-title {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: clamp(1.75rem, 3vw, 2.4rem);
        font-weight: 800;
        color: #0F172A;
        line-height: 1.18;
        letter-spacing: -0.025em;
        margin-bottom: 0.75rem;
    }
    .cta-title .ca { color: #FF0033; }

    /* ── Descripción ── */
    .cta-desc {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.97rem;
        color: #6B7280;
        line-height: 1.75;
        margin-bottom: 0;
        max-width: 500px;
    }

    /* ── Columna de acciones ── */
    .cta-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        align-items: flex-start;
    }

    /* Botón principal */
    .cta-btn-primary {
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
        white-space: nowrap;
        box-shadow: 0 4px 18px rgba(255,0,51,0.28);
        transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
    }
    .cta-btn-primary:hover {
        background: #cc0029;
        box-shadow: 0 7px 24px rgba(255,0,51,0.38);
        transform: translateY(-2px);
        color: #fff !important;
    }

    /* Botón WhatsApp */
    .cta-btn-wa {
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
        white-space: nowrap;
        border: 1.5px solid #E5E7EB;
        transition: border-color 0.2s, background 0.2s, color 0.2s, transform 0.15s;
    }
    .cta-btn-wa .wa-c { color: #25D366; }
    .cta-btn-wa:hover {
        border-color: #25D366;
        color: #1a9e4e !important;
        background: #F0FDF4;
        transform: translateY(-2px);
    }

    /* ── Mini info: respuesta rápida ── */
    .cta-info-row {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 0.5rem;
    }
    .cta-info-dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: #22C55E;
        flex-shrink: 0;
        animation: ctaPulse 2s ease-in-out infinite;
    }
    @keyframes ctaPulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: 0.6; transform: scale(1.3); }
    }
    .cta-info-text {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.72rem;
        color: #9CA3AF;
        font-weight: 500;
    }

    /* ── Scroll reveal ── */
    .cta-reveal {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    .cta-reveal.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* ── Responsive ── */
    @media (max-width: 991px) {
        .cta-card { padding: 2.5rem 2.5rem; }
        .cta-actions { align-items: flex-start; }
    }
    @media (max-width: 767px) {
        .cta-actions { flex-direction: row; flex-wrap: wrap; }
    }
    @media (max-width: 575px) {
        .cta-section { padding: 3rem 0; }
        .cta-card { padding: 2rem 1.5rem; border-radius: 20px; }
        .cta-actions { flex-direction: column; align-items: stretch; }
        .cta-btn-primary,
        .cta-btn-wa { justify-content: center; }
        .cta-desc { max-width: 100%; }
    }
</style>

<!-- ═══════════════════════════════════════════════════════════
     CONTACTO RÁPIDO
═══════════════════════════════════════════════════════════ -->
<section class="cta-section" id="contacto" aria-label="Contacto rápido">
    <div class="container cta-inner">

        <div class="cta-card cta-reveal">
            <div class="row align-items-center g-4">

                <!-- ── Texto ── -->
                <div class="col-lg-8">
                    <p class="cta-eyebrow">Contacto rápido</p>
                    <h2 class="cta-title">
                        ¿Necesitás <span class="ca">ayuda?</span>
                    </h2>
                    <p class="cta-desc">
                        Nuestro equipo de expertos está listo para atenderte.
                        Contáctanos ahora y resolvemos tus dudas sin compromiso.
                    </p>
                </div>

                <!-- ── Acciones ── -->
                <div class="col-lg-4">
                    <div class="cta-actions">
                        <a href="<?= base_url('contacto') ?>" class="cta-btn-primary">
                            <i class="fas fa-envelope"></i> Enviar mensaje
                        </a>
                        <a href="https://wa.me/5493704616482"
                           target="_blank" rel="noopener noreferrer"
                           class="cta-btn-wa">
                            <i class="fab fa-whatsapp wa-c"></i> WhatsApp
                        </a>
                        <div class="cta-info-row">
                            <div class="cta-info-dot"></div>
                            <span class="cta-info-text">Respuesta en menos de 24 horas</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<script>
(function () {
    var els = document.querySelectorAll('.cta-reveal');
    if (!els.length) return;
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });
    els.forEach(function (el) { io.observe(el); });
})();
</script>
