<style>
    .rubros-section {
        background: #0c1117;
        position: relative;
    }
    .rubros-section .section-heading { color: #fff; }
    .rubros-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.6rem;
    }

    /* ── Card ── */
    .rubro-card {
        background: #111a27;
        border-radius: 14px;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        border: 1px solid rgba(255,255,255,0.07);
        border-left: 3px solid rgba(255,0,51,0.2);
        overflow: hidden;
        position: relative;
    }
    .rubro-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 60px rgba(0,0,0,0.4);
        border-color: rgba(255,255,255,0.1);
        border-left-color: var(--rojo);
    }

    /* ── Visual strip ── */
    .rubro-visual {
        position: relative;
        height: 155px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .rubro-visual-bg {
        position: absolute;
        inset: 0;
        background: var(--grad);
        transition: transform 0.45s ease;
    }
    .rubro-card:hover .rubro-visual-bg { transform: scale(1.06); }
    .rubro-visual-img {
        position: absolute;
        inset: 0;
        width: 100%; height: 100%;
        object-fit: cover;
        opacity: 0.35;
        transition: opacity 0.35s ease, transform 0.45s ease;
    }
    .rubro-card:hover .rubro-visual-img { opacity: 0.52; transform: scale(1.05); }
    .rubro-visual-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(10,15,25,0.85) 100%);
    }
    .rubro-icon-big {
        position: relative;
        z-index: 1;
        width: 62px;
        height: 62px;
        border-radius: 14px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.65rem;
        color: rgba(255,255,255,0.9);
        transition: transform 0.3s ease, background 0.3s ease, border-color 0.3s ease;
    }
    .rubro-card:hover .rubro-icon-big {
        transform: scale(1.1);
        background: rgba(255,0,51,0.15);
        border-color: rgba(255,0,51,0.4);
    }

    /* ── Card body ── */
    .rubro-body {
        padding: 1.4rem 1.8rem 1.7rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .rubro-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 0.6rem;
    }
    .rubro-name { color: #fff; font-size: 1.15rem; font-weight: 800; line-height: 1.25; }
    .rubro-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: rgba(255,255,255,0.05);
        color: rgba(255,255,255,0.45);
        border: 1px solid rgba(255,255,255,0.08);
        font-size: 0.7rem;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 50px;
        white-space: nowrap;
    }
    .rubro-desc-text {
        color: rgba(255,255,255,0.48);
        font-size: 0.86rem;
        line-height: 1.65;
        margin-bottom: 1rem;
        flex: 1;
    }
    .rubro-subcats {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 1.2rem;
    }
    .rubro-subcat-chip {
        display: inline-block;
        background: rgba(255,255,255,0.04);
        color: rgba(255,255,255,0.42);
        border: 1px solid rgba(255,255,255,0.07);
        font-size: 0.72rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 50px;
        transition: background 0.2s, color 0.2s, border-color 0.2s;
        white-space: nowrap;
    }
    .rubro-card:hover .rubro-subcat-chip {
        background: rgba(255,0,51,0.07);
        color: rgba(255,120,120,0.72);
        border-color: rgba(255,0,51,0.18);
    }
    .rubro-link {
        color: rgba(255,255,255,0.5);
        font-size: 0.83rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: color 0.2s, gap 0.2s;
        margin-top: auto;
    }
    .rubro-card:hover .rubro-link {
        color: var(--rojo);
        gap: 12px;
    }

    @media (max-width: 991px) { .rubros-grid { grid-template-columns: 1fr; } }
</style>

<!-- ═══════════════════════════════════════════════
     RUBROS
═══════════════════════════════════════════════ -->
<section class="rubros-section py-5" id="rubros">
    <div class="container-xxl px-3 px-lg-5">
        <div class="text-center mb-2">
            <span class="section-eyebrow">Lo que ofrecemos</span>
            <h2 class="section-heading">Nuestros Rubros</h2>
        </div>
        <div class="section-divider"></div>

        <div class="rubros-grid">

            <!-- Informática -->
            <a href="<?= base_url('catalogo/informatica') ?>" class="rubro-card">
                <div class="rubro-visual">
                    <div class="rubro-visual-bg" style="--grad: linear-gradient(135deg, #091628 0%, #0f2240 55%, #070e18 100%);"></div>
                    <img src="<?= base_url('assets/img/rubros/informatica.jpg') ?>"
                         alt="" class="rubro-visual-img" loading="lazy"
                         onerror="this.style.display='none'">
                    <div class="rubro-visual-overlay"></div>
                    <div class="rubro-icon-big"><i class="fas fa-microchip"></i></div>
                </div>
                <div class="rubro-body">
                    <div class="rubro-meta">
                        <div class="rubro-name">Informática</div>
                        <span class="rubro-badge"><i class="fas fa-layer-group"></i> 6 categorías</span>
                    </div>
                    <div class="rubro-desc-text">Todo en tecnología para tu hogar y empresa: equipos, hardware, conectividad y más.</div>
                    <div class="rubro-subcats">
                        <span class="rubro-subcat-chip">Accesorios</span>
                        <span class="rubro-subcat-chip">Componentes</span>
                        <span class="rubro-subcat-chip">Monitores</span>
                        <span class="rubro-subcat-chip">Seguridad</span>
                        <span class="rubro-subcat-chip">Conectividad</span>
                        <span class="rubro-subcat-chip">Impresión</span>
                    </div>
                    <span class="rubro-link">Explorar categoría <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>

            <!-- Muebles -->
            <a href="<?= base_url('catalogo/muebles') ?>" class="rubro-card">
                <div class="rubro-visual">
                    <div class="rubro-visual-bg" style="--grad: linear-gradient(135deg, #160b0c 0%, #271118 55%, #0d0709 100%);"></div>
                    <img src="<?= base_url('assets/img/rubros/muebles.jpg') ?>"
                         alt="" class="rubro-visual-img" loading="lazy"
                         onerror="this.style.display='none'">
                    <div class="rubro-visual-overlay"></div>
                    <div class="rubro-icon-big"><i class="fas fa-chair"></i></div>
                </div>
                <div class="rubro-body">
                    <div class="rubro-meta">
                        <div class="rubro-name">Muebles</div>
                        <span class="rubro-badge"><i class="fas fa-layer-group"></i> Oficina &amp; Hogar</span>
                    </div>
                    <div class="rubro-desc-text">Mobiliario completo para equipar tu espacio de trabajo y cada ambiente del hogar.</div>
                    <div class="rubro-subcats">
                        <span class="rubro-subcat-chip">Escritorios</span>
                        <span class="rubro-subcat-chip">Sillas</span>
                        <span class="rubro-subcat-chip">Bibliotecas</span>
                        <span class="rubro-subcat-chip">Dormitorio</span>
                        <span class="rubro-subcat-chip">Livings</span>
                        <span class="rubro-subcat-chip">Cocina &amp; Baño</span>
                    </div>
                    <span class="rubro-link">Explorar categoría <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>

            <!-- Electrodomésticos -->
            <a href="<?= base_url('catalogo/electrodomesticos') ?>" class="rubro-card">
                <div class="rubro-visual">
                    <div class="rubro-visual-bg" style="--grad: linear-gradient(135deg, #08131d 0%, #0c1e2c 55%, #060b12 100%);"></div>
                    <img src="<?= base_url('assets/img/rubros/electrodomesticos.jpg') ?>"
                         alt="" class="rubro-visual-img" loading="lazy"
                         onerror="this.style.display='none'">
                    <div class="rubro-visual-overlay"></div>
                    <div class="rubro-icon-big"><i class="fas fa-plug"></i></div>
                </div>
                <div class="rubro-body">
                    <div class="rubro-meta">
                        <div class="rubro-name">Electrodomésticos</div>
                        <span class="rubro-badge"><i class="fas fa-layer-group"></i> 6 categorías</span>
                    </div>
                    <div class="rubro-desc-text">Todo en electrodomésticos para el hogar: frío, cocción, audio y entretenimiento.</div>
                    <div class="rubro-subcats">
                        <span class="rubro-subcat-chip">Heladeras</span>
                        <span class="rubro-subcat-chip">Cocinas</span>
                        <span class="rubro-subcat-chip">Hornos</span>
                        <span class="rubro-subcat-chip">Freezers</span>
                        <span class="rubro-subcat-chip">Smart TVs</span>
                        <span class="rubro-subcat-chip">Audio</span>
                    </div>
                    <span class="rubro-link">Explorar categoría <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>

            <!-- Línea Comercial -->
            <a href="<?= base_url('catalogo/linea-comercial') ?>" class="rubro-card">
                <div class="rubro-visual">
                    <div class="rubro-visual-bg" style="--grad: linear-gradient(135deg, #0d0b17 0%, #181123 55%, #09070f 100%);"></div>
                    <img src="<?= base_url('assets/img/rubros/linea-comercial.jpg') ?>"
                         alt="" class="rubro-visual-img" loading="lazy"
                         onerror="this.style.display='none'">
                    <div class="rubro-visual-overlay"></div>
                    <div class="rubro-icon-big"><i class="fas fa-building"></i></div>
                </div>
                <div class="rubro-body">
                    <div class="rubro-meta">
                        <div class="rubro-name">Línea Comercial</div>
                        <span class="rubro-badge"><i class="fas fa-layer-group"></i> 4 líneas</span>
                    </div>
                    <div class="rubro-desc-text">Equipamiento profesional para negocios gastronómicos y locales comerciales.</div>
                    <div class="rubro-subcats">
                        <span class="rubro-subcat-chip">Frío Comercial</span>
                        <span class="rubro-subcat-chip">Calor Industrial</span>
                        <span class="rubro-subcat-chip">Balanzas</span>
                        <span class="rubro-subcat-chip">Góndolas</span>
                        <span class="rubro-subcat-chip">Estanterías</span>
                        <span class="rubro-subcat-chip">Mostradores</span>
                    </div>
                    <span class="rubro-link">Explorar categoría <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>

        </div>
    </div>
</section>
