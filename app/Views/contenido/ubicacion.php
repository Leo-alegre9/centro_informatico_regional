<style>
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
</style>

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
