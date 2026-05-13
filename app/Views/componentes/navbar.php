<style>
    .navbar-cir {
        background-color: var(--dark);
        padding: 0.85rem 0;
        position: sticky;
        top: 0;
        z-index: 1030;
        box-shadow: 0 2px 14px rgba(0,0,0,0.35);
    }

    /* ── Brand ── */
    .navbar-brand-cir {
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 11px;
        flex-shrink: 0;
    }
    .navbar-brand-cir img {
        height: 36px;
        border-radius: 8px;
        object-fit: cover;
        transition: box-shadow 0.25s;
    }
    .navbar-brand-cir.brand-active img {
        box-shadow: 0 0 0 2px var(--rojo);
    }
    .brand-name {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }
    .brand-main {
        color: #fff;
        font-size: 1.05rem;
        font-weight: 700;
        letter-spacing: -0.2px;
    }
    .brand-region {
        color: rgba(255,255,255,0.35);
        font-size: 0.58rem;
        font-weight: 600;
        letter-spacing: 3px;
        text-transform: uppercase;
    }

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

    /* ── Toggler ── */
    .navbar-toggler-cir {
        background: none;
        border: 1px solid rgba(255,255,255,0.3);
        color: #fff;
        padding: 6px 12px;
        border-radius: 7px;
        cursor: pointer;
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
    }
    .nav-login-btn:hover {
        color: #fff !important;
        border-color: rgba(255,255,255,0.28);
        background: rgba(255,255,255,0.05);
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
?>

<nav class="navbar-cir">
    <div class="container d-flex align-items-center justify-content-between gap-3">

        <a href="<?= base_url('/') ?>" class="navbar-brand-cir<?= $isHome ? ' brand-active' : '' ?>">
            <img src="<?= base_url('assets/img/logo_negrorojo.jpg') ?>" alt="Logo CIR">
            <span class="brand-name">
                <span class="brand-main">Centro Informático</span>
                <span class="brand-region">Regional</span>
            </span>
        </a>

        <button class="navbar-toggler-cir d-lg-none" type="button"
                data-bs-toggle="collapse" data-bs-target="#navMenu" aria-expanded="false">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse d-lg-flex align-items-center gap-1" id="navMenu">
            <a href="<?= base_url() ?>#rubros"
               class="nav-link-cir<?= $isCatalogo ? ' nav-link-active' : '' ?>">
               Rubros
            </a>
            <a href="<?= base_url('servicio-tecnico') ?>"
               class="nav-link-cir<?= $isServicio ? ' nav-link-active' : '' ?>">
               Servicio Técnico
            </a>
            <a href="<?= base_url('nosotros') ?>"
               class="nav-link-cir<?= $isNosotros ? ' nav-link-active' : '' ?>">
               Nosotros
            </a>
            <a href="<?= base_url('contacto') ?>"
               class="nav-link-cir<?= $isContacto ? ' nav-link-active' : '' ?>">
               Contacto
            </a>

            <span class="nav-admin-sep d-none d-lg-block"></span>

            <?php if ($adminLoggedIn): ?>
                <a href="<?= base_url('admin/dashboard') ?>"
                   class="nav-link-cir nav-admin-badge"
                   title="Ir al panel de administración">
                    <i class="fas fa-shield-halved"></i>
                    <span class="d-none d-xl-inline">Panel</span>
                </a>
                <a href="<?= base_url('admin/logout') ?>"
                   class="nav-admin-logout ms-1"
                   title="Cerrar sesión (<?= esc($adminNombre) ?>)">
                    <i class="fas fa-right-from-bracket"></i>
                </a>
            <?php else: ?>
                <a href="<?= base_url('admin/login') ?>"
                   class="nav-login-btn ms-1">
                    <i class="fas fa-right-to-bracket"></i>
                    <span>Iniciar sesión</span>
                </a>
            <?php endif; ?>
        </div>

    </div>
</nav>
