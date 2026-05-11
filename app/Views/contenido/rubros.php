<style>
    .rubros-section { background: #fff; }
    .rubros-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.6rem;
    }
    .rubro-card {
        background: var(--dark-2);
        border-radius: 20px;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1.5px solid rgba(255,255,255,0.05);
        border-bottom: 3px solid transparent;
        overflow: hidden;
    }
    .rubro-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 22px 55px rgba(0,0,0,0.3);
        border-bottom-color: var(--rojo);
    }

    /* ── Visual strip ── */
    .rubro-visual {
        position: relative;
        height: 162px;
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
        opacity: 0.5;
        transition: opacity 0.35s ease, transform 0.45s ease;
    }
    .rubro-card:hover .rubro-visual-img { opacity: 0.68; transform: scale(1.05); }
    .rubro-visual-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.08) 0%, rgba(31,41,55,0.82) 100%);
    }
    .rubro-icon-big {
        position: relative;
        z-index: 1;
        font-size: 3.2rem;
        color: rgba(255,255,255,0.88);
        filter: drop-shadow(0 4px 14px rgba(0,0,0,0.35));
        transition: transform 0.3s ease;
    }
    .rubro-card:hover .rubro-icon-big { transform: scale(1.14); }

    /* ── Card body ── */
    .rubro-body {
        padding: 1.5rem 2rem 1.8rem;
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
        margin-bottom: 0.7rem;
    }
    .rubro-name { color: #fff; font-size: 1.2rem; font-weight: 800; line-height: 1.25; }
    .rubro-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: rgba(255,0,51,0.12);
        color: var(--rojo);
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 50px;
        white-space: nowrap;
    }
    .rubro-desc-text {
        color: rgba(255,255,255,0.5);
        font-size: 0.86rem;
        line-height: 1.65;
        margin-bottom: 1.1rem;
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
        background: rgba(255,255,255,0.06);
        color: rgba(255,255,255,0.5);
        border: 1px solid rgba(255,255,255,0.09);
        font-size: 0.73rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 50px;
        transition: background 0.2s, color 0.2s;
        white-space: nowrap;
    }
    .rubro-card:hover .rubro-subcat-chip {
        background: rgba(255,0,51,0.08);
        color: rgba(255,100,100,0.75);
        border-color: rgba(255,0,51,0.2);
    }
    .rubro-link {
        color: var(--rojo);
        font-size: 0.85rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: gap 0.2s;
        margin-top: auto;
    }
    .rubro-card:hover .rubro-link { gap: 12px; }

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
                    <div class="rubro-visual-bg" style="--grad: linear-gradient(135deg, #0f172a 0%, #0369a1 55%, #0ea5e9 100%);"></div>
                    <img src="<?= base_url('assets/img/rubros/informatica.jpg') ?>"
                         alt="" class="rubro-visual-img" loading="lazy"
                         onerror="this.style.display='none'">
                    <div class="rubro-visual-overlay"></div>
                    <div class="rubro-icon-big"><i class="fas fa-laptop"></i></div>
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
                    <div class="rubro-visual-bg" style="--grad: linear-gradient(135deg, #1c0f0a 0%, #78350f 55%, #d97706 100%);"></div>
                    <img src="<?= base_url('assets/img/rubros/muebles.jpg') ?>"
                         alt="" class="rubro-visual-img" loading="lazy"
                         onerror="this.style.display='none'">
                    <div class="rubro-visual-overlay"></div>
                    <div class="rubro-icon-big"><i class="fas fa-couch"></i></div>
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
                    <div class="rubro-visual-bg" style="--grad: linear-gradient(135deg, #0a0f1e 0%, #1e3a8a 55%, #3b82f6 100%);"></div>
                    <img src="<?= base_url('assets/img/rubros/electrodomesticos.jpg') ?>"
                         alt="" class="rubro-visual-img" loading="lazy"
                         onerror="this.style.display='none'">
                    <div class="rubro-visual-overlay"></div>
                    <div class="rubro-icon-big"><i class="fas fa-blender"></i></div>
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
                    <div class="rubro-visual-bg" style="--grad: linear-gradient(135deg, #051b11 0%, #065f46 55%, #10b981 100%);"></div>
                    <img src="<?= base_url('assets/img/rubros/linea-comercial.jpg') ?>"
                         alt="" class="rubro-visual-img" loading="lazy"
                         onerror="this.style.display='none'">
                    <div class="rubro-visual-overlay"></div>
                    <div class="rubro-icon-big"><i class="fas fa-store"></i></div>
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
