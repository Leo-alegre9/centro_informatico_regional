<style>
    .nosotros-propuesta { background: var(--fondo); }
    .propuesta-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.6rem;
        margin-top: 0.5rem;
    }
    .propuesta-card {
        background: #fff;
        border-radius: 20px;
        padding: 2.4rem 2rem;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        border: 1.5px solid #f0f0f0;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .propuesta-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 50px rgba(0,0,0,0.11);
    }
    .propuesta-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: var(--rojo);
        border-radius: 20px 20px 0 0;
    }
    .propuesta-icon-wrap {
        width: 68px; height: 68px;
        border-radius: 18px;
        background: rgba(255,0,51,0.07);
        border: 2px solid rgba(255,0,51,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.7rem;
        color: var(--rojo);
        margin-bottom: 1.4rem;
        transition: background 0.25s, color 0.25s;
    }
    .propuesta-card:hover .propuesta-icon-wrap {
        background: var(--rojo);
        color: #fff;
        border-color: var(--rojo);
    }
    .propuesta-card-num {
        position: absolute;
        top: 1.4rem;
        right: 1.6rem;
        font-size: 3.5rem;
        font-weight: 900;
        color: rgba(0,0,0,0.04);
        line-height: 1;
        user-select: none;
    }
    .propuesta-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--dark-2);
        margin-bottom: 1rem;
    }
    .propuesta-text {
        color: var(--gris);
        font-size: 0.9rem;
        line-height: 1.8;
        flex: 1;
        margin-bottom: 1.4rem;
    }
    .propuesta-puntos { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.55rem; }
    .propuesta-puntos li {
        display: flex;
        align-items: flex-start;
        gap: 0.6rem;
        color: var(--gris);
        font-size: 0.85rem;
        line-height: 1.5;
    }
    .propuesta-puntos li i { color: var(--rojo); font-size: 0.7rem; margin-top: 4px; flex-shrink: 0; }

    /* CTA inferior */
    .nosotros-cta {
        background: var(--dark-2);
        border-radius: 20px;
        padding: 2.8rem 2.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        flex-wrap: wrap;
        margin-top: 3.5rem;
    }
    .nosotros-cta-text { flex: 1; min-width: 260px; }
    .nosotros-cta-text h3 { color: #fff; font-size: 1.35rem; font-weight: 800; margin-bottom: 0.4rem; }
    .nosotros-cta-text p { color: rgba(255,255,255,0.5); font-size: 0.92rem; margin: 0; }
    .nosotros-cta-btns { display: flex; gap: 0.8rem; flex-wrap: wrap; }

    @media (max-width: 991px) { .propuesta-grid { grid-template-columns: 1fr; } }
</style>

<!-- ═══════════════════════════════════════════════
     NOSOTROS — NUESTRA PROPUESTA
═══════════════════════════════════════════════ -->
<section class="nosotros-propuesta py-5">
    <div class="container">

        <div class="text-center mb-2">
            <span class="section-eyebrow">Nuestros valores</span>
            <h2 class="section-heading">Nuestra Propuesta</h2>
        </div>
        <div class="section-divider"></div>

        <div class="propuesta-grid">

            <!-- Calidad -->
            <div class="propuesta-card">
                <div class="propuesta-card-num">01</div>
                <div class="propuesta-icon-wrap"><i class="fas fa-award"></i></div>
                <div class="propuesta-title">Calidad</div>
                <p class="propuesta-text">
                    Nos aseguramos de que toda nuestra línea de productos sea de alta calidad, con buen respaldo en servicio posventa y garantía en cada artículo que ofrecemos.
                </p>
                <ul class="propuesta-puntos">
                    <li><i class="fas fa-circle"></i> Productos de marcas líderes internacionales</li>
                    <li><i class="fas fa-circle"></i> Garantía en todos los artículos</li>
                    <li><i class="fas fa-circle"></i> Soporte posventa personalizado</li>
                </ul>
            </div>

            <!-- Responsabilidad -->
            <div class="propuesta-card">
                <div class="propuesta-card-num">02</div>
                <div class="propuesta-icon-wrap"><i class="fas fa-handshake"></i></div>
                <div class="propuesta-title">Responsabilidad</div>
                <p class="propuesta-text">
                    Cumplimos exactamente con todo lo pactado con cada cliente, a través de un seguimiento personalizado desde las primeras tratativas hasta el soporte técnico o garantías que necesite.
                </p>
                <ul class="propuesta-puntos">
                    <li><i class="fas fa-circle"></i> Seguimiento personalizado de cada caso</li>
                    <li><i class="fas fa-circle"></i> Cumplimiento de plazos y acuerdos</li>
                    <li><i class="fas fa-circle"></i> Soporte técnico post-venta garantizado</li>
                </ul>
            </div>

            <!-- Capacitación -->
            <div class="propuesta-card">
                <div class="propuesta-card-num">03</div>
                <div class="propuesta-icon-wrap"><i class="fas fa-graduation-cap"></i></div>
                <div class="propuesta-title">Capacitación</div>
                <p class="propuesta-text">
                    La capacitación es donde ponemos especial dedicación. Conformamos un equipo de profesionales para asesorar a nuestro personal en forma permanente, realizando talleres y conferencias para mejorar sistemáticamente cada área.
                </p>
                <ul class="propuesta-puntos">
                    <li><i class="fas fa-circle"></i> Equipo profesional en formación continua</li>
                    <li><i class="fas fa-circle"></i> Talleres y conferencias periódicas</li>
                    <li><i class="fas fa-circle"></i> Asesoramiento técnico calificado</li>
                </ul>
            </div>

        </div>

        <!-- CTA -->
        <div class="nosotros-cta">
            <div class="nosotros-cta-text">
                <h3>¿Querés trabajar con nosotros?</h3>
                <p>Conocé nuestro catálogo completo o ponete en contacto con nuestro equipo para asesoramiento personalizado.</p>
            </div>
            <div class="nosotros-cta-btns">
                <a href="<?= base_url('catalogo') ?>" class="btn-rojo">
                    <i class="fas fa-th-large"></i> Ver Catálogo
                </a>
                <a href="<?= base_url('contacto') ?>" class="btn-outline-claro">
                    <i class="fas fa-envelope"></i> Contactanos
                </a>
            </div>
        </div>

    </div>
</section>
