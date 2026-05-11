<style>
    .contacto-hero {
        background: linear-gradient(135deg, #070c1a 0%, var(--dark-2) 55%, #180a10 100%);
        padding: 4.5rem 0 3.5rem;
        position: relative;
        overflow: hidden;
    }
    .contacto-hero-glow {
        position: absolute;
        width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(255,0,51,0.12) 0%, transparent 70%);
        top: -150px; right: -100px;
        border-radius: 50%;
        pointer-events: none;
    }
    .contacto-badge {
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
        margin-bottom: 1.2rem;
    }
    .contacto-hero h1 {
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 900;
        color: #fff;
        margin-bottom: 0.9rem;
        line-height: 1.15;
    }
    .contacto-hero h1 span { color: var(--rojo); }
    .contacto-hero-desc {
        color: rgba(255,255,255,0.62);
        font-size: 1.05rem;
        line-height: 1.8;
        max-width: 520px;
    }
    .contacto-quick-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 14px;
        padding: 1.1rem 1.4rem;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: border-color 0.2s;
    }
    .contacto-quick-card:hover { border-color: rgba(255,0,51,0.3); }
    .contacto-quick-icon {
        width: 44px; height: 44px;
        background: rgba(255,0,51,0.13);
        border: 1px solid rgba(255,0,51,0.25);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--rojo);
        font-size: 1rem;
        flex-shrink: 0;
    }
    .contacto-quick-label {
        color: rgba(255,255,255,0.45);
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        display: block;
        margin-bottom: 2px;
    }
    .contacto-quick-value {
        color: #fff;
        font-size: 0.93rem;
        font-weight: 600;
        margin: 0;
    }
</style>

<!-- ═══════════════════════════════════════════════
     CONTACTO HERO
═══════════════════════════════════════════════ -->
<div class="contacto-hero">
    <div class="contacto-hero-glow"></div>
    <div class="container position-relative" style="z-index:1;">
        <div class="row align-items-center g-5">

            <div class="col-lg-6">
                <div class="contacto-badge">
                    <i class="fas fa-headset"></i>
                    Estamos para ayudarte
                </div>
                <h1>Ponete en <span>Contacto</span></h1>
                <p class="contacto-hero-desc">
                    Respondemos consultas, presupuestos y solicitudes de servicio técnico. Escribinos y te responderemos a la brevedad.
                </p>
            </div>

            <div class="col-lg-6">
                <div class="d-flex flex-column gap-3">
                    <div class="contacto-quick-card">
                        <div class="contacto-quick-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <span class="contacto-quick-label">Dirección</span>
                            <p class="contacto-quick-value">Sarmiento 177, El Colorado, Formosa</p>
                        </div>
                    </div>
                    <div class="contacto-quick-card">
                        <div class="contacto-quick-icon"><i class="fas fa-phone"></i></div>
                        <div>
                            <span class="contacto-quick-label">Teléfono / WhatsApp</span>
                            <p class="contacto-quick-value">(+54) 370 461-6482</p>
                        </div>
                    </div>
                    <div class="contacto-quick-card">
                        <div class="contacto-quick-icon"><i class="fas fa-clock"></i></div>
                        <div>
                            <span class="contacto-quick-label">Horario de atención</span>
                            <p class="contacto-quick-value">Lun–Vie: 8–12 y 16–20 hs &nbsp;·&nbsp; Sáb: 8–12 hs</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
