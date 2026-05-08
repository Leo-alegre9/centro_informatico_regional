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
</style>

<nav class="navbar-cir">
    <div class="container d-flex align-items-center justify-content-between gap-3">

        <a href="<?= base_url('/') ?>" class="navbar-brand-cir">
            <img src="<?= base_url('public/assets/img/logofinal.jpeg') ?>" alt="Logo CIR">
            Centro <span class="brand-accent ms-1">Informático</span>
        </a>

        <button class="navbar-toggler-cir d-lg-none" type="button"
                data-bs-toggle="collapse" data-bs-target="#navMenu" aria-expanded="false">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse d-lg-flex align-items-center gap-1" id="navMenu">
            <a href="#rubros"           class="nav-link-cir">Rubros</a>
            <a href="#servicio-tecnico" class="nav-link-cir">Servicio Técnico</a>
            <a href="#ubicacion"        class="nav-link-cir">Ubicación</a>
            <a href="<?= base_url('contacto') ?>" class="nav-link-cir nav-cta ms-2">Contacto</a>
        </div>

    </div>
</nav>
