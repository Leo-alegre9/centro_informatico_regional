<style>
    /* ══════════════════════════════════════════════════════════
       CATEGORÍAS — Compra Gamer style · Tab + Visual Grid 2026
    ══════════════════════════════════════════════════════════ */
    .cats-section {
        background: #fff;
        padding: 5rem 0 5.5rem;
        border-top: 1px solid #EEF0F3;
    }

    /* ── Encabezado ── */
    .cats-hdr {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    .cats-eyebrow {
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
    .cats-eyebrow::before,
    .cats-eyebrow::after {
        content: '';
        display: inline-block;
        width: 18px; height: 2px;
        background: #FF0033;
        border-radius: 2px;
        flex-shrink: 0;
    }
    .cats-title {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: clamp(1.9rem, 3vw, 2.6rem);
        font-weight: 800;
        color: #0F172A;
        letter-spacing: -0.025em;
        line-height: 1.15;
        margin-bottom: 0.75rem;
    }
    .cats-title .ca { color: #FF0033; }
    .cats-subtitle {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.98rem;
        color: #6B7280;
        max-width: 500px;
        margin: 0 auto;
        line-height: 1.75;
    }

    /* ── Tabs de rubros ── */
    .cats-tabs-wrap {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;
    }
    .cats-tabs {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: center;
        background: #F9FAFB;
        border: 1.5px solid #EEF0F3;
        border-radius: 50px;
        padding: 5px;
    }
    .cats-tab {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 0.52rem 1.25rem;
        border-radius: 50px;
        border: none;
        background: transparent;
        color: #6B7280;
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.84rem;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.2s, color 0.2s, box-shadow 0.2s;
        outline: none;
    }
    .cats-tab i { font-size: 0.78rem; }
    .cats-tab:hover:not(.active) { color: #374151; background: #fff; }
    .cats-tab.active {
        background: #FF0033;
        color: #fff;
        box-shadow: 0 4px 14px rgba(255,0,51,0.28);
    }

    /* ── Panel de categorías (visible/oculto) ── */
    .cats-panel {
        display: none;
        animation: catsPanelIn 0.32s cubic-bezier(.4,0,.2,1);
    }
    .cats-panel.active { display: block; }
    @keyframes catsPanelIn {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ══════════════════════════════════════════════════════════
       GRILLA ASIMÉTRICA — Compra Gamer layout
    ══════════════════════════════════════════════════════════ */
    .cats-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        grid-auto-rows: 208px;
        gap: 12px;
    }

    /* ── Tarjeta base ── */
    .cat-card {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        display: block;
        text-decoration: none;
        cursor: pointer;
    }

    /* Card destacada (primera) */
    .cat-card-featured {
        grid-row: span 2;
        border-radius: 20px;
    }

    /* Fondo / imagen */
    .cat-bg {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        transition: transform 0.65s cubic-bezier(.4,0,.2,1);
        will-change: transform;
    }
    .cat-card:hover .cat-bg { transform: scale(1.07); }

    /* Tinte de color (diferencia visual entre categorías del mismo rubro) */
    .cat-tint {
        position: absolute;
        inset: 0;
        transition: opacity 0.3s;
    }
    .cat-card:hover .cat-tint { opacity: 0.6; }

    /* Overlay degradado */
    .cat-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to top,
            rgba(0,0,0,0.88) 0%,
            rgba(0,0,0,0.45) 38%,
            rgba(0,0,0,0.1)  70%,
            transparent      100%
        );
        transition: background 0.35s;
    }
    .cat-card:hover .cat-overlay {
        background: linear-gradient(
            to top,
            rgba(0,0,0,0.94) 0%,
            rgba(0,0,0,0.58) 38%,
            rgba(0,0,0,0.2)  70%,
            rgba(0,0,0,0.05) 100%
        );
    }

    /* Contenido superpuesto */
    .cat-content {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        padding: 1.1rem 1.25rem 1.2rem;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .cat-card-featured .cat-content {
        padding: 1.6rem 1.75rem 1.75rem;
    }

    /* Ícono */
    .cat-icon {
        font-size: 1.1rem;
        color: rgba(255,255,255,0.65);
        margin-bottom: 4px;
        transition: color 0.2s;
    }
    .cat-card-featured .cat-icon { font-size: 1.4rem; }
    .cat-card:hover .cat-icon { color: rgba(255,255,255,0.9); }

    /* Nombre de categoría */
    .cat-name {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: #fff;
        line-height: 1.2;
        letter-spacing: -0.01em;
    }
    .cat-card-featured .cat-name {
        font-size: clamp(1.4rem, 2.2vw, 1.9rem);
        font-weight: 800;
        letter-spacing: -0.025em;
        margin-bottom: 6px;
    }

    /* CTA flecha (aparece en hover) */
    .cat-arrow {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.75rem;
        font-weight: 700;
        color: rgba(255,255,255,0.7);
        opacity: 0;
        transform: translateY(6px);
        transition: opacity 0.25s, transform 0.25s, color 0.2s;
        margin-top: 2px;
    }
    .cat-arrow i { font-size: 0.6rem; }
    .cat-card:hover .cat-arrow {
        opacity: 1;
        transform: translateY(0);
        color: #fff;
    }
    .cat-card-featured .cat-arrow { font-size: 0.85rem; }

    /* ── CTA general ── */
    .cats-cta-wrap {
        text-align: center;
        margin-top: 2.5rem;
    }
    .cats-cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        background: #FF0033;
        color: #fff !important;
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.92rem;
        font-weight: 700;
        padding: 0.85rem 2rem;
        border-radius: 50px;
        text-decoration: none;
        box-shadow: 0 4px 18px rgba(255,0,51,0.25);
        transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
    }
    .cats-cta-btn:hover {
        background: #cc0029;
        box-shadow: 0 7px 24px rgba(255,0,51,0.36);
        transform: translateY(-2px);
        color: #fff !important;
    }

    /* ── Scroll reveal ── */
    .cats-reveal {
        opacity: 0;
        transform: translateY(22px);
        transition: opacity 0.52s ease, transform 0.52s ease;
    }
    .cats-reveal.visible { opacity: 1; transform: translateY(0); }
    .cats-d1 { transition-delay: 0.05s; }
    .cats-d2 { transition-delay: 0.12s; }
    .cats-d3 { transition-delay: 0.19s; }

    /* ── Responsive ── */
    @media (max-width: 991px) {
        .cats-grid { grid-template-columns: 2fr 1fr; grid-auto-rows: 185px; }
        /* En tablet la card featured ocupa solo col 1 */
    }
    @media (max-width: 767px) {
        .cats-grid {
            grid-template-columns: 1fr 1fr;
            grid-auto-rows: 155px;
        }
        .cat-card-featured {
            grid-column: span 2;
            grid-row: span 1;
            border-radius: 16px;
        }
        .cat-card-featured .cat-name { font-size: 1.35rem; }
        .cat-arrow { opacity: 1; transform: translateY(0); }
        .cats-tabs { gap: 6px; }
        .cats-tab  { padding: 0.45rem 0.9rem; font-size: 0.78rem; }
    }
    @media (max-width: 575px) {
        .cats-section { padding: 3rem 0 3.5rem; }
        .cats-grid    { grid-auto-rows: 140px; gap: 10px; }
        .cat-name     { font-size: 0.88rem; }
        .cat-content  { padding: 0.85rem 1rem; }
        .cat-card-featured .cat-name { font-size: 1.15rem; }
        .cat-card-featured .cat-content { padding: 1.1rem 1.25rem; }
        .cats-tabs    { border-radius: 16px; padding: 4px; }
        .cats-tab     { border-radius: 12px; }
    }
</style>

<?php
/* ══════════════════════════════════════════════════════════
   Datos de la BD
══════════════════════════════════════════════════════════ */
$_catModel   = new \App\Models\CategoriaModel();
$_rubrosData = $_catModel->getMegaMenu();

/* Imágenes de fondo por rubro */
$_rubroImg = [
    'informatica'       => base_url('assets/img/rubros/fondo_informatica.png'),
    'muebles'           => base_url('assets/img/rubros/muebles_fondo.jpg'),
    'electrodomesticos' => base_url('assets/img/rubros/fondo_electrodomesticos.png'),
    'linea-comercial'   => base_url('assets/img/rubros/fondo_lineaComercial}.jpg'),
];

/*
 * Imágenes específicas por categoría (slug → URL).
 * Agregar aquí cuando estén disponibles.
 * Si no existe, usa la imagen del rubro con tinte.
 */
$_catImg = [
    /* Ejemplo:
    'notebooks'    => base_url('assets/img/cats/notebooks.jpg'),
    'heladeras'    => base_url('assets/img/cats/heladeras.jpg'),
    */
];

/* Tintes de color que diferencian tarjetas dentro del mismo rubro */
$_tints = [
    'rgba(15,31,60,0.25)',
    'rgba(60,20,10,0.28)',
    'rgba(10,45,25,0.28)',
    'rgba(35,10,60,0.28)',
    'rgba(60,40,10,0.25)',
    'rgba(10,45,55,0.28)',
    'rgba(55,15,30,0.25)',
    'rgba(20,50,15,0.25)',
    'rgba(50,25,10,0.28)',
    'rgba(10,20,55,0.25)',
];

/* Posiciones de fondo variadas para simular diferentes encuadres */
$_bgPos = [
    'center center', 'center left',  'center right',
    'top center',    'bottom center','top left',
    'top right',     'bottom left',  'bottom right',
    'center center',
];

/* Config visual por rubro */
$_rubroConfig = [
    'informatica'       => ['icono' => 'fas fa-laptop',       'color' => '#2563EB', 'label' => 'Tecnología'],
    'muebles'           => ['icono' => 'fas fa-chair',         'color' => '#EA580C', 'label' => 'Ambientes'],
    'electrodomesticos' => ['icono' => 'fas fa-tv',            'color' => '#16A34A', 'label' => 'Hogar'],
    'linea-comercial'   => ['icono' => 'fas fa-store',         'color' => '#7C3AED', 'label' => 'Comercio'],
];
$_cfgDefault = ['icono' => 'fas fa-folder', 'color' => '#6B7280', 'label' => 'Categoría'];
?>

<!-- ═══════════════════════════════════════════════════════════
     EXPLORÁ NUESTRAS CATEGORÍAS
═══════════════════════════════════════════════════════════ -->
<section class="cats-section" id="rubros" aria-label="Explorá nuestras categorías">
    <div class="container">

        <!-- ── Encabezado ── -->
        <div class="cats-hdr cats-reveal">
            <p class="cats-eyebrow">Lo que ofrecemos</p>
            <h2 class="cats-title">
                Explorá nuestras <span class="ca">categorías</span>
            </h2>
            <p class="cats-subtitle">
                Todo lo que necesitás para tu hogar, oficina o negocio en un solo lugar.
            </p>
        </div>

        <?php if (!empty($_rubrosData)): ?>

        <!-- ── Tabs de rubros ── -->
        <div class="cats-tabs-wrap cats-reveal cats-d1">
            <div class="cats-tabs" role="tablist" aria-label="Rubros">
                <?php foreach ($_rubrosData as $ri => $rubro):
                    $cfg = $_rubroConfig[$rubro['slug']] ?? $_cfgDefault;
                ?>
                <button class="cats-tab <?= $ri === 0 ? 'active' : '' ?>"
                        role="tab"
                        aria-selected="<?= $ri === 0 ? 'true' : 'false' ?>"
                        aria-controls="panel-<?= esc($rubro['slug']) ?>"
                        data-panel="panel-<?= esc($rubro['slug']) ?>">
                    <i class="<?= esc($cfg['icono']) ?>"></i>
                    <?= esc($rubro['nombre']) ?>
                </button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ── Paneles de categorías ── -->
        <?php foreach ($_rubrosData as $ri => $rubro):
            $cfg       = $_rubroConfig[$rubro['slug']] ?? $_cfgDefault;
            $bgRubro   = $_rubroImg[$rubro['slug']] ?? '';
            $hijos     = array_values($rubro['hijos']);
        ?>
        <div class="cats-panel cats-reveal cats-d2 <?= $ri === 0 ? 'active' : '' ?>"
             id="panel-<?= esc($rubro['slug']) ?>"
             role="tabpanel"
             aria-label="Categorías de <?= esc($rubro['nombre']) ?>">

            <?php if (!empty($hijos)): ?>
            <div class="cats-grid">
                <?php foreach ($hijos as $ci => $cat):
                    $isFirst  = ($ci === 0);
                    $bgImg    = $_catImg[$cat['slug']] ?? $bgRubro;
                    $tint     = $_tints[$ci % count($_tints)];
                    $bgPos    = $_bgPos[$ci % count($_bgPos)];
                    $catUrl   = base_url('catalogo/' . esc($rubro['slug']) . '/' . esc($cat['slug']));
                ?>
                <a href="<?= $catUrl ?>"
                   class="cat-card <?= $isFirst ? 'cat-card-featured' : '' ?>"
                   aria-label="Ver <?= esc($cat['nombre']) ?>">

                    <!-- Imagen de fondo -->
                    <div class="cat-bg"
                         style="background-image:url('<?= $bgImg ?>');
                                background-position:<?= $bgPos ?>;"></div>

                    <!-- Tinte diferenciador -->
                    <div class="cat-tint" style="background:<?= $tint ?>;"></div>

                    <!-- Overlay de legibilidad -->
                    <div class="cat-overlay"></div>

                    <!-- Contenido -->
                    <div class="cat-content">
                        <span class="cat-icon">
                            <i class="<?= esc($cat['icono']) ?>"></i>
                        </span>
                        <div class="cat-name"><?= esc($cat['nombre']) ?></div>
                        <span class="cat-arrow">
                            Ver productos <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>

                </a>
                <?php endforeach; ?>
            </div>

            <?php else: ?>
            <div style="text-align:center;padding:4rem 0;font-family:'Inter',system-ui,sans-serif;color:#C4C9D4;font-size:0.9rem;">
                Categorías de <?= esc($rubro['nombre']) ?> próximamente…
            </div>
            <?php endif; ?>

        </div>
        <?php endforeach; ?>

        <?php else: ?>
        <div style="text-align:center;padding:3rem 0;font-family:'Inter',system-ui,sans-serif;color:#9CA3AF;font-size:0.9rem;">
            El catálogo estará disponible próximamente.
        </div>
        <?php endif; ?>

        <!-- ── CTA general ── -->
        <div class="cats-cta-wrap cats-reveal cats-d3">
            <a href="<?= base_url('catalogo') ?>" class="cats-cta-btn">
                <i class="fas fa-th-large"></i> Ver catálogo completo
            </a>
        </div>

    </div>
</section>

<script>
(function () {
    /* ── Scroll reveal ── */
    var revels = document.querySelectorAll('.cats-reveal');
    if (revels.length) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); }
            });
        }, { threshold: 0.07 });
        revels.forEach(function (el) { io.observe(el); });
    }

    /* ── Tab switching ── */
    var tabs   = document.querySelectorAll('.cats-tab');
    var panels = document.querySelectorAll('.cats-panel');
    if (!tabs.length) return;

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            var target = tab.dataset.panel;

            /* Desactivar todo */
            tabs.forEach(function (t) {
                t.classList.remove('active');
                t.setAttribute('aria-selected', 'false');
            });
            panels.forEach(function (p) { p.classList.remove('active'); });

            /* Activar seleccionado */
            tab.classList.add('active');
            tab.setAttribute('aria-selected', 'true');
            var panel = document.getElementById(target);
            if (panel) {
                panel.classList.add('active');
                /* Asegurarse de que sea visible si ya pasó el reveal */
                panel.classList.add('visible');
            }
        });
    });
})();
</script>
