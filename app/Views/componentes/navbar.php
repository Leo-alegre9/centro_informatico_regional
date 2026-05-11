<style>
    .navbar-cir {
        background-color: var(--dark);
        padding: 0.85rem 0;
        position: sticky;
        top: 0;
        z-index: 1030;
        box-shadow: 0 2px 14px rgba(0,0,0,0.35);
    }
    .navbar-brand-cir {
        color: #fff;
        font-size: 1.2rem;
        font-weight: 800;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
        letter-spacing: -0.3px;
    }
    .navbar-brand-cir img {
        height: 38px;
        border-radius: 7px;
        object-fit: cover;
    }
    .brand-accent { color: var(--rojo); }
    .nav-link-cir {
        color: rgba(255,255,255,0.82) !important;
        font-weight: 500;
        font-size: 0.95rem;
        padding: 0.45rem 1rem !important;
        border-radius: 6px;
        transition: color 0.2s, background 0.2s;
        text-decoration: none;
    }
    .nav-link-cir:hover { color: #fff !important; background: rgba(255,255,255,0.07); }
    .nav-cta {
        background-color: var(--rojo) !important;
        color: #fff !important;
        border-radius: 50px !important;
        padding: 0.45rem 1.4rem !important;
        font-weight: 700 !important;
    }
    .nav-cta:hover { background-color: var(--rojo-dark) !important; }
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
    .nav-lock-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px; height: 34px;
        border-radius: 8px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: rgba(255,255,255,0.35) !important;
        font-size: 0.82rem;
        text-decoration: none;
        transition: background 0.2s, color 0.2s, border-color 0.2s;
    }
    .nav-lock-btn:hover {
        background: rgba(255,0,51,0.12);
        border-color: rgba(255,0,51,0.35);
        color: var(--rojo) !important;
    }
</style>

<?php $adminLoggedIn = session()->get('admin_logged_in'); ?>
<?php $adminNombre   = session()->get('admin_nombre'); ?>

<nav class="navbar-cir">
    <div class="container d-flex align-items-center justify-content-between gap-3">

        <a href="<?= base_url('/') ?>" class="navbar-brand-cir">
            <img src="<?= base_url('assets/img/logo_negrorojo.jpg') ?>" alt="Logo CIR">
            Centro <span class="brand-accent ms-1">Informático</span>
        </a>

        <button class="navbar-toggler-cir d-lg-none" type="button"
                data-bs-toggle="collapse" data-bs-target="#navMenu" aria-expanded="false">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse d-lg-flex align-items-center gap-1" id="navMenu">
            <a href="<?= base_url() ?>#rubros"           class="nav-link-cir">Rubros</a>
            <a href="<?= base_url('servicio-tecnico') ?>" class="nav-link-cir">Servicio Técnico</a>
            <a href="<?= base_url('nosotros') ?>"        class="nav-link-cir">Nosotros</a>
            <a href="<?= base_url('contacto') ?>"        class="nav-link-cir nav-cta ms-2">Contacto</a>

            <!-- Separador + zona admin -->
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
                   class="nav-lock-btn ms-1"
                   title="Acceso administrador">
                    <i class="fas fa-lock"></i>
                </a>
            <?php endif; ?>
        </div>

    </div>
</nav>
