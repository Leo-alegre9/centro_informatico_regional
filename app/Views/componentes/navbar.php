<style>
    /* ── Mega trigger (desktop) ── */
    .mega-trigger {
        color: rgba(255,255,255,0.72);
        font-weight: 500;
        font-size: 0.95rem;
        padding: 0.45rem 1rem;
        border-radius: 6px;
        transition: color 0.2s, background 0.2s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        user-select: none;
        position: relative;
        white-space: nowrap;
    }
    .mega-trigger:hover,
    .mega-trigger.mega-open {
        color: #fff;
        background: rgba(255,255,255,0.07);
    }
    .mega-trigger.mega-open { background: rgba(255,0,51,0.08); }
    .mega-arrow {
        font-size: 0.7rem;
        transition: transform 0.2s;
    }
    .mega-trigger.mega-open .mega-arrow { transform: rotate(180deg); }

    /* ── Mega dropdown panel (desktop) ── */
    .mega-dropdown {
        position: fixed;
        top: 68px;
        left: 0;
        right: 0;
        background: #111827;
        z-index: 1029;
        box-shadow: 0 12px 40px rgba(0,0,0,0.45);
        max-height: 480px;
        overflow-y: auto;
        display: none;
        border-top: 2px solid rgba(255,0,51,0.25);
        animation: megaSlideIn 0.2s ease;
    }
    @keyframes megaSlideIn {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .mega-dropdown.open { display: block; }

    /* ── Nivel 1: chips de rubros ── */
    .mega-rubros-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.5rem;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.07);
        max-width: 1400px;
        margin: 0 auto;
    }
    .mega-rubro-chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 0.48rem 1.1rem;
        border-radius: 50px;
        font-size: 0.84rem;
        font-weight: 600;
        color: rgba(255,255,255,0.58);
        background: rgba(255,255,255,0.05);
        border: 1.5px solid rgba(255,255,255,0.1);
        cursor: pointer;
        transition: color .18s, background .18s, border-color .18s;
        white-space: nowrap;
    }
    .mega-rubro-chip:hover {
        color: #fff;
        background: rgba(255,255,255,0.09);
        border-color: rgba(255,255,255,0.22);
    }
    .mega-rubro-chip.active {
        color: #fff;
        background: rgba(255,0,51,0.18);
        border-color: rgba(255,0,51,0.45);
    }
    .mega-rubro-chip .mrc-arrow {
        font-size: 0.65rem;
        transition: transform .2s;
        opacity: .5;
    }
    .mega-rubro-chip.active .mrc-arrow { transform: rotate(180deg); opacity: 1; }

    /* ── Nivel 2: panel de subrubros ── */
    .mega-subs-panel {
        padding: 1.25rem 1.5rem 1.4rem;
        max-width: 1400px;
        margin: 0 auto;
        animation: megaSubIn .18s ease;
    }
    @keyframes megaSubIn {
        from { opacity: 0; transform: translateY(-5px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .mega-pane-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
        padding-bottom: 0.65rem;
        border-bottom: 1px solid rgba(255,255,255,0.07);
    }
    .mega-pane-title {
        color: #fff;
        font-size: 0.88rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .mega-pane-title i { color: #FF0033; font-size: .82rem; }
    .mega-ver-todo {
        color: #FF0033;
        font-size: .8rem;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: gap .18s;
    }
    .mega-ver-todo:hover { gap: 9px; }
    .mega-pane-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(145px, 1fr));
        gap: 1rem 1.5rem;
    }
    .mega-sub-col-hdr {
        color: rgba(255,255,255,0.85);
        font-size: .83rem;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: .3rem;
        transition: color .15s;
    }
    .mega-sub-col-hdr:hover { color: #FF0033; }
    .mega-sub-col-hdr i { font-size: .72rem; opacity: .6; flex-shrink: 0; }
    .mega-subsub-link {
        color: rgba(255,255,255,0.36);
        font-size: .75rem;
        text-decoration: none;
        display: block;
        padding: 2px 0 2px .1rem;
        transition: color .15s;
    }
    .mega-subsub-link:hover { color: rgba(255,120,120,0.8); }

    /* ── Navbar base ── */
    .navbar-cir {
        background-color: var(--dark) !important;
        padding: 0.75rem 0 !important;
        position: sticky !important;
        top: 0 !important;
        z-index: 1030 !important;
        box-shadow: 0 2px 14px rgba(0,0,0,0.35);
    }

    /* ── Brand ── */
    .navbar-brand-cir {
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 13px;
        flex-shrink: 0;
        transition: opacity 0.22s;
    }
    .navbar-brand-cir:hover { opacity: 0.88; }

    .brand-logo-wrap {
        flex-shrink: 0;
        line-height: 0;
    }
    .brand-logo-wrap img {
        height: 40px;
        width: 40px;
        border-radius: 10px;
        object-fit: cover;
        display: block;
        border: 1.5px solid rgba(255,255,255,0.1);
        transition: border-color 0.25s, box-shadow 0.25s;
    }
    .navbar-brand-cir:hover .brand-logo-wrap img,
    .navbar-brand-cir.brand-active .brand-logo-wrap img {
        border-color: rgba(255,255,255,0.2);
        box-shadow: 0 0 16px rgba(255,0,51,0.18);
    }

    .brand-name {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }
    .brand-main {
        color: #fff;
        font-size: 1.06rem;
        font-weight: 700;
        letter-spacing: -0.4px;
        line-height: 1.15;
        white-space: nowrap;
    }
    .brand-region {
        color: rgba(255,255,255,0.28);
        font-size: 0.5rem;
        font-weight: 700;
        letter-spacing: 5px;
        text-transform: uppercase;
        line-height: 1;
    }

    /* ── Toggler ── */
    .navbar-toggler-cir {
        background: none !important;
        border: 1px solid rgba(255,255,255,0.3) !important;
        color: #fff;
        padding: 6px 12px !important;
        border-radius: 7px !important;
        box-shadow: none !important;
        line-height: 1;
    }
    .navbar-toggler-cir i { font-size: 1rem; }

    /* ── Nav links ── */
    .nav-link-cir {
        color: rgba(255,255,255,0.72) !important;
        font-weight: 500;
        font-size: 0.95rem;
        padding: 0.45rem 1rem !important;
        border-radius: 6px;
        transition: color 0.2s, background 0.2s;
        text-decoration: none;
        position: relative;
        white-space: nowrap;
    }
    .nav-link-cir:hover {
        color: #fff !important;
        background: rgba(255,255,255,0.07);
    }
    .nav-link-cir.nav-link-active {
        color: #fff !important;
        font-weight: 600 !important;
        background: rgba(255,0,51,0.08) !important;
    }
    .nav-link-cir.nav-link-active::after {
        content: '';
        position: absolute;
        bottom: 3px;
        left: 50%;
        transform: translateX(-50%);
        width: 18px;
        height: 2px;
        background: var(--rojo);
        border-radius: 1px;
    }

    /* ── Admin area ── */
    .nav-admin-sep {
        width: 1px;
        height: 22px;
        background: rgba(255,255,255,0.12);
        margin: 0 0.4rem;
        flex-shrink: 0;
    }
    .nav-admin-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,0,51,0.12);
        border: 1px solid rgba(255,0,51,0.3);
        color: var(--rojo) !important;
        font-size: 0.82rem;
        font-weight: 700;
        padding: 0.38rem 0.9rem !important;
        border-radius: 50px !important;
        transition: background 0.2s, border-color 0.2s !important;
        text-decoration: none;
    }
    .nav-admin-badge:hover {
        background: rgba(255,0,51,0.22) !important;
        border-color: rgba(255,0,51,0.55) !important;
        color: var(--rojo) !important;
    }
    .nav-admin-logout {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px; height: 34px;
        border-radius: 8px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: rgba(255,255,255,0.5) !important;
        font-size: 0.85rem;
        transition: background 0.2s, color 0.2s, border-color 0.2s !important;
        text-decoration: none;
    }
    .nav-admin-logout:hover {
        background: rgba(255,0,51,0.15) !important;
        border-color: rgba(255,0,51,0.4) !important;
        color: var(--rojo) !important;
    }
    .nav-login-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: rgba(255,255,255,0.55) !important;
        font-size: 0.88rem;
        font-weight: 500;
        padding: 0.4rem 0.9rem !important;
        border-radius: 6px;
        border: 1px solid rgba(255,255,255,0.12);
        text-decoration: none;
        transition: color 0.2s, border-color 0.2s, background 0.2s;
        white-space: nowrap;
    }
    .nav-login-btn:hover {
        color: #fff !important;
        border-color: rgba(255,255,255,0.28);
        background: rgba(255,255,255,0.05);
    }

    /* ── Mobile accordion (dentro del collapse) ── */
    .mega-mobile-item {
        border-bottom: 1px solid rgba(255,255,255,0.07);
        width: 100%;
    }
    .mega-mobile-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.65rem 1rem;
        color: rgba(255,255,255,0.72);
        font-weight: 500;
        font-size: 0.9rem;
        cursor: pointer;
        user-select: none;
        text-decoration: none;
        transition: color 0.15s;
        width: 100%;
    }
    .mega-mobile-toggle:hover,
    .mega-mobile-toggle.nav-link-active { color: #fff; }
    .mega-mobile-arrow { font-size: 0.7rem; transition: transform 0.2s; }
    .mega-mobile-toggle.open .mega-mobile-arrow { transform: rotate(180deg); }
    .mega-mobile-body {
        display: none;
        background: rgba(0,0,0,0.18);
        padding: 0.3rem 1rem 0.6rem 1.25rem;
    }
    .mega-mobile-body.open { display: block; }
    .mega-mobile-link {
        color: rgba(255,255,255,0.52);
        font-size: 0.84rem;
        text-decoration: none;
        display: block;
        padding: 4px 0;
        transition: color 0.15s;
    }
    .mega-mobile-link:hover { color: #FF0033; }
    .mega-mobile-link.ver-todo {
        color: rgba(255,0,51,0.75);
        font-weight: 600;
        margin-top: 0.3rem;
    }
    .mega-mobile-link.ver-todo:hover { color: #FF0033; }

    /* Sub-acordeón de rubros en mobile */
    .mega-mob-rubro-item {
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .mega-mob-rubro-item:last-of-type { border-bottom: none; }
    .mega-mob-rubro-hdr {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.5rem 0;
        color: rgba(255,255,255,0.6);
        font-size: 0.84rem;
        font-weight: 600;
        cursor: pointer;
        user-select: none;
        transition: color .15s;
    }
    .mega-mob-rubro-hdr:hover,
    .mega-mob-rubro-hdr.open { color: #fff; }
    .mega-mob-rubro-arrow {
        font-size: 0.65rem;
        opacity: .5;
        transition: transform .2s;
    }
    .mega-mob-rubro-hdr.open .mega-mob-rubro-arrow {
        transform: rotate(90deg);
        opacity: 1;
    }
    .mega-mob-rubro-body {
        display: none;
        padding: 0.1rem 0 0.4rem 0.6rem;
    }
    .mega-mob-rubro-body.open { display: block; }

    /* ══ RESPONSIVE MOBILE (< 992px) ══════════════════════════════════ */
    @media (max-width: 991px) {
        /* El mega dropdown desktop no aparece en mobile */
        .mega-dropdown { display: none !important; }

        /* Collapse panel: separador visual del resto del nav */
        #navMenu {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding: 0.25rem 0 0.6rem;
            margin-top: 0.5rem;
        }

        /* Todos los nav-links en mobile: bloque ancho completo */
        #navMenu .nav-link-cir {
            display: block !important;
            width: 100%;
            padding: 0.65rem 1rem !important;
            border-radius: 0;
            font-size: 0.9rem;
            white-space: normal;
        }
        /* Sin indicador activo (dot) en mobile */
        #navMenu .nav-link-cir::after { display: none !important; }

        /* Separador admin oculto */
        #navMenu .nav-admin-sep { display: none !important; }

        /* Botones admin/login en mobile */
        #navMenu .nav-admin-badge {
            display: inline-flex !important;
            margin: 0.4rem 1rem;
            width: auto !important;
        }
        #navMenu .nav-login-btn {
            display: inline-flex !important;
            margin: 0.4rem 1rem;
            width: auto !important;
        }
        #navMenu .nav-admin-logout {
            display: inline-flex !important;
            margin: 0.4rem 0.5rem;
        }
    }
</style>

<?php
$adminLoggedIn = session()->get('admin_logged_in');
$adminNombre   = session()->get('admin_nombre');
$currentPath   = trim(service('request')->getUri()->getPath(), '/');
$isHome        = ($currentPath === '' || $currentPath === 'index.php');
$isCatalogo    = (strncmp($currentPath, 'catalogo', 8) === 0);
$isServicio    = ($currentPath === 'servicio-tecnico');
$isNosotros    = ($currentPath === 'nosotros');
$isContacto    = ($currentPath === 'contacto');

$_megaModel = new \App\Models\CategoriaModel();
$_megaData  = $_megaModel->getMegaMenu();
?>

<!-- navbar navbar-expand-lg: Bootstrap maneja colapso en mobile automáticamente -->
<nav class="navbar navbar-expand-lg navbar-cir">
    <div class="container">

        <!-- Brand -->
        <a href="<?= base_url('/') ?>" class="navbar-brand navbar-brand-cir<?= $isHome ? ' brand-active' : '' ?>">
            <div class="brand-logo-wrap">
                <img src="<?= base_url('assets/img/logo_negrorojo.jpg') ?>" alt="Logo CIR">
            </div>
            <span class="brand-name">
                <span class="brand-main">Centro Informático</span>
                <span class="brand-region">Regional</span>
            </span>
        </a>

        <!-- Toggler (solo visible en mobile) -->
        <button class="navbar-toggler navbar-toggler-cir"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navMenu"
                aria-controls="navMenu"
                aria-expanded="false"
                aria-label="Abrir menú">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Menú colapsable -->
        <div class="collapse navbar-collapse" id="navMenu">
            <!-- navbar-nav: columna en mobile, fila en desktop (Bootstrap lo maneja con navbar-expand-lg) -->
            <div class="navbar-nav ms-lg-auto align-items-lg-center gap-lg-1 w-100">

                <!-- DESKTOP únicamente: Rubros link directo -->
                <a href="<?= base_url('catalogo') ?>"
                   class="nav-link-cir d-none d-lg-inline-flex<?= $isCatalogo ? ' nav-link-active' : '' ?>">
                    Rubros
                </a>

                <!-- DESKTOP únicamente: trigger del mega dropdown -->
                <div class="d-none d-lg-block">
                    <div class="mega-trigger" id="mega-trigger-btn"
                         role="button" tabindex="0"
                         aria-haspopup="true" aria-expanded="false">
                        Catálogo <i class="fas fa-chevron-down mega-arrow"></i>
                    </div>
                </div>

                <!-- MOBILE únicamente: Rubros link -->
                <a href="<?= base_url('catalogo') ?>"
                   class="nav-link-cir d-lg-none<?= $isCatalogo ? ' nav-link-active' : '' ?>">
                    <i class="fas fa-th-large" style="margin-right:6px;font-size:.8rem;opacity:.7;"></i>Rubros
                </a>

                <!-- MOBILE únicamente: Catálogo accordion drill-down -->
                <div class="d-lg-none mega-mobile-item">
                    <div class="mega-mobile-toggle" id="mega-mobile-toggle" role="button" tabindex="0">
                        <span><i class="fas fa-layer-group" style="margin-right:6px;font-size:.8rem;opacity:.7;"></i>Catálogo</span>
                        <i class="fas fa-chevron-down mega-mobile-arrow"></i>
                    </div>
                    <div class="mega-mobile-body" id="mega-mobile-body">
                        <?php if (!empty($_megaData)): ?>
                            <?php foreach ($_megaData as $r): ?>
                            <div class="mega-mob-rubro-item">
                                <div class="mega-mob-rubro-hdr" role="button" tabindex="0">
                                    <span>
                                        <i class="<?= esc($r['icono']) ?>" style="margin-right:5px;font-size:.78rem;opacity:.65;"></i>
                                        <?= esc($r['nombre']) ?>
                                    </span>
                                    <i class="fas fa-chevron-right mega-mob-rubro-arrow"></i>
                                </div>
                                <div class="mega-mob-rubro-body">
                                    <?php foreach ($r['hijos'] as $sub): ?>
                                    <a href="<?= base_url('catalogo/' . esc($r['slug']) . '/' . esc($sub['slug'])) ?>"
                                       class="mega-mobile-link nav-close-on-click">
                                        <i class="<?= esc($sub['icono']) ?>" style="margin-right:4px;font-size:.72rem;opacity:.55;"></i>
                                        <?= esc($sub['nombre']) ?>
                                    </a>
                                    <?php endforeach; ?>
                                    <a href="<?= base_url('catalogo/' . esc($r['slug'])) ?>"
                                       class="mega-mobile-link ver-todo nav-close-on-click">
                                        Ver todo en <?= esc($r['nombre']) ?> &rarr;
                                    </a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <a href="<?= base_url('catalogo') ?>"
                               class="mega-mobile-link ver-todo nav-close-on-click"
                               style="margin-top:.4rem;border-top:1px solid rgba(255,255,255,0.06);padding-top:.45rem;display:block;">
                                Ver catálogo completo &rarr;
                            </a>
                        <?php else: ?>
                            <a href="<?= base_url('catalogo') ?>" class="mega-mobile-link nav-close-on-click">Ver catálogo</a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Todos los tamaños: links comunes -->
                <a href="<?= base_url('servicio-tecnico') ?>"
                   class="nav-link-cir nav-close-on-click<?= $isServicio ? ' nav-link-active' : '' ?>">
                   Servicio Técnico
                </a>
                <a href="<?= base_url('nosotros') ?>"
                   class="nav-link-cir nav-close-on-click<?= $isNosotros ? ' nav-link-active' : '' ?>">
                   Nosotros
                </a>
                <a href="<?= base_url('contacto') ?>"
                   class="nav-link-cir nav-close-on-click<?= $isContacto ? ' nav-link-active' : '' ?>">
                   Contacto
                </a>

                <!-- Separador (desktop únicamente) -->
                <span class="nav-admin-sep d-none d-lg-block"></span>

                <!-- Admin / Login -->
                <?php if ($adminLoggedIn): ?>
                    <a href="<?= base_url('admin/dashboard') ?>"
                       class="nav-link-cir nav-admin-badge"
                       title="Ir al panel de administración">
                        <i class="fas fa-shield-halved"></i>
                        <span class="d-none d-xl-inline">Panel</span>
                    </a>
                    <a href="<?= base_url('admin/logout') ?>"
                       class="nav-admin-logout ms-lg-1"
                       title="Cerrar sesión (<?= esc($adminNombre) ?>)">
                        <i class="fas fa-right-from-bracket"></i>
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('admin/login') ?>" class="nav-login-btn ms-lg-1">
                        <i class="fas fa-right-to-bracket"></i>
                        <span>Iniciar sesión</span>
                    </a>
                <?php endif; ?>

            </div><!-- /.navbar-nav -->
        </div><!-- /.collapse -->

    </div><!-- /.container -->
</nav>

<!-- ── Mega dropdown (desktop únicamente) ── -->
<div class="mega-dropdown" id="mega-dropdown" role="dialog" aria-label="Menú de categorías">

    <?php if (!empty($_megaData)): ?>

    <!-- Nivel 1: chips de rubros -->
    <div class="mega-rubros-row">
        <?php foreach ($_megaData as $rubro): ?>
        <button type="button" class="mega-rubro-chip"
                data-pane="mgp-<?= (int) $rubro['id'] ?>">
            <i class="<?= esc($rubro['icono']) ?>"></i>
            <?= esc($rubro['nombre']) ?>
            <i class="fas fa-chevron-down mrc-arrow"></i>
        </button>
        <?php endforeach; ?>
    </div>

    <!-- Nivel 2: subrubros del rubro seleccionado -->
    <div class="mega-subs-panel" id="mega-subs-panel" style="display:none;">
        <?php foreach ($_megaData as $rubro): ?>
        <div id="mgp-<?= (int) $rubro['id'] ?>" style="display:none;">
            <div class="mega-pane-header">
                <span class="mega-pane-title">
                    <i class="<?= esc($rubro['icono']) ?>"></i>
                    <?= esc($rubro['nombre']) ?>
                </span>
                <a href="<?= base_url('catalogo/' . esc($rubro['slug'])) ?>" class="mega-ver-todo">
                    Ver todo en <?= esc($rubro['nombre']) ?> <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <?php if (!empty($rubro['hijos'])): ?>
            <div class="mega-pane-grid">
                <?php foreach ($rubro['hijos'] as $sub): ?>
                <div>
                    <a href="<?= base_url('catalogo/' . esc($rubro['slug']) . '/' . esc($sub['slug'])) ?>"
                       class="mega-sub-col-hdr">
                        <i class="<?= esc($sub['icono']) ?>"></i>
                        <?= esc($sub['nombre']) ?>
                    </a>
                    <?php foreach ($sub['hijos'] as $subsub): ?>
                    <a href="<?= base_url('catalogo/' . esc($rubro['slug']) . '/' . esc($sub['slug']) . '/' . esc($subsub['slug'])) ?>"
                       class="mega-subsub-link">
                        &rsaquo; <?= esc($subsub['nombre']) ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <a href="<?= base_url('catalogo/' . esc($rubro['slug'])) ?>" class="mega-ver-todo">
                <i class="<?= esc($rubro['icono']) ?>"></i>
                Explorar <?= esc($rubro['nombre']) ?> <i class="fas fa-arrow-right"></i>
            </a>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>

    <?php else: ?>
    <div style="padding:1.25rem 1.5rem;color:rgba(255,255,255,0.4);font-size:.9rem;">
        No hay categorías disponibles.
    </div>
    <?php endif; ?>

</div>

<script>
(function () {

    /* ══════════════════════════════════════════════════════
       DESKTOP: mega dropdown
    ══════════════════════════════════════════════════════ */
    var trigger  = document.getElementById('mega-trigger-btn');
    var dropdown = document.getElementById('mega-dropdown');

    if (trigger && dropdown) {
        var subsPanel    = document.getElementById('mega-subs-panel');
        var chips        = dropdown.querySelectorAll('.mega-rubro-chip');
        var activePaneId = null;

        function resetChips() {
            chips.forEach(function (c) { c.classList.remove('active'); });
            if (subsPanel) subsPanel.style.display = 'none';
            if (activePaneId) {
                var p = document.getElementById(activePaneId);
                if (p) p.style.display = 'none';
            }
            activePaneId = null;
        }
        function openMega() {
            dropdown.classList.add('open');
            trigger.classList.add('mega-open');
            trigger.setAttribute('aria-expanded', 'true');
        }
        function closeMega() {
            dropdown.classList.remove('open');
            trigger.classList.remove('mega-open');
            trigger.setAttribute('aria-expanded', 'false');
            resetChips();
        }
        function toggleMega() {
            dropdown.classList.contains('open') ? closeMega() : openMega();
        }

        chips.forEach(function (chip) {
            chip.addEventListener('click', function (e) {
                e.stopPropagation();
                var paneId = chip.dataset.pane;
                var isSame = chip.classList.contains('active');

                if (activePaneId) {
                    var prev = document.getElementById(activePaneId);
                    if (prev) prev.style.display = 'none';
                }
                chips.forEach(function (c) { c.classList.remove('active'); });

                if (isSame) {
                    if (subsPanel) subsPanel.style.display = 'none';
                    activePaneId = null;
                } else {
                    var pane = document.getElementById(paneId);
                    if (pane) pane.style.display = 'block';
                    if (subsPanel) subsPanel.style.display = 'block';
                    chip.classList.add('active');
                    activePaneId = paneId;
                }
            });
        });

        trigger.addEventListener('click', function (e) { e.stopPropagation(); toggleMega(); });
        trigger.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); toggleMega(); }
            if (e.key === 'Escape') { closeMega(); }
        });
        document.addEventListener('click', function (e) {
            if (!dropdown.contains(e.target) && e.target !== trigger) { closeMega(); }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { closeMega(); }
        });
    }

    /* ══════════════════════════════════════════════════════
       MOBILE: acordeón principal "Catálogo"
    ══════════════════════════════════════════════════════ */
    var mobileToggle = document.getElementById('mega-mobile-toggle');
    var mobileBody   = document.getElementById('mega-mobile-body');
    if (mobileToggle && mobileBody) {
        mobileToggle.addEventListener('click', function () {
            var isOpen = mobileBody.classList.contains('open');
            mobileBody.classList.toggle('open', !isOpen);
            mobileToggle.classList.toggle('open', !isOpen);
        });
        mobileToggle.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); mobileToggle.click(); }
        });
    }

    /* ── Sub-acordeón por rubro ── */
    document.querySelectorAll('.mega-mob-rubro-hdr').forEach(function (hdr) {
        function toggleRubro() {
            var body   = hdr.nextElementSibling;
            var isOpen = hdr.classList.contains('open');
            document.querySelectorAll('.mega-mob-rubro-hdr').forEach(function (h) {
                h.classList.remove('open');
                if (h.nextElementSibling) h.nextElementSibling.classList.remove('open');
            });
            if (!isOpen) {
                hdr.classList.add('open');
                if (body) body.classList.add('open');
            }
        }
        hdr.addEventListener('click', toggleRubro);
        hdr.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); toggleRubro(); }
        });
    });

    /* ══════════════════════════════════════════════════════
       Cerrar el menú mobile al hacer clic en un link
    ══════════════════════════════════════════════════════ */
    document.querySelectorAll('.nav-close-on-click').forEach(function (el) {
        el.addEventListener('click', function () {
            var navMenu = document.getElementById('navMenu');
            if (navMenu && navMenu.classList.contains('show')) {
                /* Bootstrap 5: usar la API del Collapse */
                if (typeof bootstrap !== 'undefined' && bootstrap.Collapse) {
                    bootstrap.Collapse.getOrCreateInstance(navMenu).hide();
                } else {
                    navMenu.classList.remove('show');
                }
            }
        });
    });

})();
</script>
