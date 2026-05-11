<style>
    .tech-section { background: var(--fondo); }
    .check-list { list-style: none; padding: 0; margin: 0 0 2rem; }
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
</style>

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
                <a href="<?= base_url('servicio-tecnico') ?>" class="btn-rojo">
                    Solicitar servicio <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="col-lg-6 text-center">
                <img src="<?= base_url('assets/img/serviciotecnico.webp') ?>"
                     alt="Servicio Técnico Especializado"
                     class="tech-img">
            </div>

        </div>
    </div>
</section>
