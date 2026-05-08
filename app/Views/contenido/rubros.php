<style>
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
    .rubro-card:hover .rubro-icon { background: var(--rojo); color: #fff; border-color: var(--rojo); }
    .rubro-name { color: #fff; font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; }
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

    @media (max-width: 991px) { .rubros-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 575px) { .rubros-grid { grid-template-columns: 1fr; } }
</style>

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
