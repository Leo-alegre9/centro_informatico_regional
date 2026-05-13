<style>
    .contacto-section { background: #0b1017; }
    .contacto-card {
        background: var(--dark-2);
        border-radius: 22px;
        padding: 3.5rem;
        border: 1px solid rgba(255,0,51,0.15);
        border-left: 7px solid var(--rojo);
        box-shadow: 0 10px 55px rgba(0,0,0,0.35), 0 0 60px rgba(255,0,51,0.05);
    }
    .contacto-card h2 { color: #fff; font-weight: 800; font-size: 2.1rem; }
    .contacto-card p { color: rgba(255,255,255,0.68); font-size: 1.05rem; line-height: 1.75; }

    @media (max-width: 991px) { .contacto-card { padding: 2.5rem 2rem; } }
    @media (max-width: 575px) {
        .contacto-card { padding: 2rem 1.5rem; }
        .contacto-card h2 { font-size: 1.6rem; }
    }
</style>

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
