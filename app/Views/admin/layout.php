<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($titulo ?? 'Panel Admin | CIR') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --rojo: #FF0033; --rojo-hover: #cc0028; --sidebar-bg: #111827; --sidebar-width: 260px; }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            display: flex;
            min-height: 100vh;
            background: #f4f6f9;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        /* ── SIDEBAR ── */
        #adminSidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            z-index: 1040;
            transition: transform 0.3s ease;
        }
        .sidebar-brand {
            padding: 1.5rem 1.25rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .sidebar-brand .brand-icon {
            width: 42px; height: 42px;
            background: rgba(255,0,51,0.15);
            border: 1.5px solid rgba(255,0,51,0.3);
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.6rem;
        }
        .sidebar-brand .brand-icon i { color: var(--rojo); font-size: 1.1rem; }
        .sidebar-brand .brand-name {
            color: #fff;
            font-size: 0.95rem;
            font-weight: 700;
            line-height: 1.2;
        }
        .sidebar-brand .brand-sub {
            color: rgba(255,255,255,0.4);
            font-size: 0.72rem;
            display: block;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1rem 0.75rem;
            overflow-y: auto;
        }
        .sidebar-nav .nav-section-title {
            color: rgba(255,255,255,0.3);
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 0.75rem 0.5rem 0.25rem;
            margin-top: 0.5rem;
        }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 0.62rem 0.85rem;
            border-radius: 9px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 2px;
            transition: background 0.15s, color 0.15s;
        }
        .sidebar-nav a i {
            width: 20px;
            margin-right: 0.7rem;
            text-align: center;
            font-size: 0.95rem;
        }
        .sidebar-nav a:hover {
            background: rgba(255,255,255,0.07);
            color: #fff;
        }
        .sidebar-nav a.activo {
            background: rgba(255,0,51,0.15);
            color: #fff;
            font-weight: 600;
        }
        .sidebar-nav a.activo i { color: var(--rojo); }
        .sidebar-nav a.nav-external {
            color: rgba(255,255,255,0.5);
            font-size: 0.85rem;
        }
        .sidebar-nav a.nav-external:hover { color: rgba(255,255,255,0.8); }

        .sidebar-footer {
            padding: 1rem 0.75rem;
            border-top: 1px solid rgba(255,255,255,0.07);
        }
        .sidebar-footer .admin-info {
            display: flex;
            align-items: center;
            padding: 0.6rem 0.85rem;
            border-radius: 9px;
            background: rgba(255,255,255,0.05);
            margin-bottom: 0.5rem;
        }
        .sidebar-footer .avatar {
            width: 36px; height: 36px;
            background: var(--rojo);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
            margin-right: 0.65rem;
        }
        .sidebar-footer .admin-nombre {
            color: #fff;
            font-size: 0.88rem;
            font-weight: 600;
            line-height: 1.2;
        }
        .sidebar-footer .admin-rol {
            color: rgba(255,255,255,0.4);
            font-size: 0.72rem;
        }
        .sidebar-footer .logout-link {
            display: flex;
            align-items: center;
            padding: 0.5rem 0.85rem;
            color: rgba(255,100,100,0.8);
            text-decoration: none;
            font-size: 0.85rem;
            border-radius: 9px;
            transition: background 0.15s, color 0.15s;
        }
        .sidebar-footer .logout-link i { margin-right: 0.6rem; }
        .sidebar-footer .logout-link:hover {
            background: rgba(255,0,51,0.12);
            color: #ff6b6b;
        }

        /* ── CONTENIDO PRINCIPAL ── */
        #mainContent {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
        }
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.85rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        .topbar-left { display: flex; align-items: center; gap: 1rem; }
        .hamburger-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.3rem;
            color: #374151;
            font-size: 1.2rem;
            line-height: 1;
        }
        .page-title {
            font-size: 1rem;
            font-weight: 600;
            color: #111827;
            margin: 0;
        }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #6B7280;
            font-size: 0.88rem;
        }
        .topbar-right .admin-badge {
            background: rgba(255,0,51,0.08);
            color: var(--rojo);
            padding: 0.25rem 0.7rem;
            border-radius: 50px;
            font-size: 0.82rem;
            font-weight: 600;
        }

        main { padding: 1.75rem; flex: 1; }

        /* Overlay sidebar mobile */
        #sidebarOverlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1039;
        }

        @media (max-width: 991px) {
            #adminSidebar { transform: translateX(-100%); }
            #adminSidebar.open { transform: translateX(0); }
            #mainContent { margin-left: 0; }
            .hamburger-btn { display: block; }
            #sidebarOverlay.visible { display: block; }
        }
    </style>
</head>
<body>

<!-- Overlay mobile -->
<div id="sidebarOverlay"></div>

<!-- SIDEBAR -->
<aside id="adminSidebar">
    <div class="sidebar-brand d-flex align-items-center">
        <div class="brand-icon"><i class="fas fa-shield-halved"></i></div>
        <div>
            <div class="brand-name">CIR Admin</div>
            <span class="brand-sub">Centro Informático Regional</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-title">Principal</div>

        <?php
        $currentUrl   = current_url();
        $isDashboard  = strpos($currentUrl, 'admin/dashboard') !== false || preg_match('#/admin/?$#', $currentUrl);
        $isBuscar     = strpos($currentUrl, 'admin/productos/buscar') !== false;
        $isProductos  = !$isBuscar && strpos($currentUrl, 'admin/productos') !== false;
        $isCategorias = strpos($currentUrl, 'admin/categorias') !== false;
        $isMarcas     = strpos($currentUrl, 'admin/marcas') !== false;
        $isConsultas  = strpos($currentUrl, 'admin/consultas') !== false;
        $isInventario     = strpos($currentUrl, 'admin/inventario') !== false;
        $isStock          = strpos($currentUrl, 'admin/stock') !== false;
        $isConfiguracion  = strpos($currentUrl, 'admin/configuracion') !== false;
        $unreadCount      = (new \App\Models\ConsultaServicioModel())->getUnreadCount();
        ?>

        <a href="<?= base_url('admin/dashboard') ?>" class="<?= $isDashboard ? 'activo' : '' ?>">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>

        <div class="nav-section-title">Catálogo</div>

        <a href="<?= base_url('admin/productos') ?>" class="<?= $isProductos ? 'activo' : '' ?>">
            <i class="fas fa-box"></i> Productos
        </a>

        <a href="<?= base_url('admin/productos/buscar') ?>" class="<?= $isBuscar ? 'activo' : '' ?>">
            <i class="fas fa-search"></i> Buscar producto
        </a>

        <a href="<?= base_url('admin/categorias') ?>" class="<?= $isCategorias ? 'activo' : '' ?>">
            <i class="fas fa-sitemap"></i> Categorías
        </a>

        <a href="<?= base_url('admin/marcas') ?>" class="<?= $isMarcas ? 'activo' : '' ?>">
            <i class="fas fa-tag"></i> Marcas
        </a>

        <div class="nav-section-title">Inventario</div>

        <a href="<?= base_url('admin/inventario') ?>" class="<?= $isInventario ? 'activo' : '' ?>">
            <i class="fas fa-warehouse"></i> Ubicaciones
        </a>

        <a href="<?= base_url('admin/stock') ?>" class="<?= $isStock ? 'activo' : '' ?>">
            <i class="fas fa-boxes"></i> Stock
        </a>

        <div class="nav-section-title">Servicio Técnico</div>

        <a href="<?= base_url('admin/consultas') ?>" class="<?= $isConsultas ? 'activo' : '' ?>"
           style="justify-content: space-between;">
            <span><i class="fas fa-headset" style="width:20px;margin-right:0.7rem;text-align:center;"></i> Consultas</span>
            <?php if ($unreadCount > 0): ?>
            <span style="background:var(--rojo);color:#fff;font-size:0.7rem;font-weight:700;
                         padding:2px 7px;border-radius:50px;min-width:20px;text-align:center;">
                <?= $unreadCount ?>
            </span>
            <?php endif; ?>
        </a>

        <div class="nav-section-title">Configuración</div>

        <a href="<?= base_url('admin/configuracion') ?>" class="<?= $isConfiguracion ? 'activo' : '' ?>">
            <i class="fas fa-sliders"></i> Precios y cotización
        </a>

        <div class="nav-section-title">Sitio</div>

        <a href="<?= base_url() ?>" target="_blank" class="nav-external">
            <i class="fas fa-external-link-alt"></i> Ver sitio
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="admin-info">
            <div class="avatar"><?= strtoupper(substr(session()->get('admin_nombre') ?? 'A', 0, 1)) ?></div>
            <div>
                <div class="admin-nombre"><?= esc(session()->get('admin_nombre') ?? 'Admin') ?></div>
                <div class="admin-rol">Administrador</div>
            </div>
        </div>
        <a href="<?= base_url('admin/logout') ?>" class="logout-link">
            <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </a>
    </div>
</aside>

<!-- CONTENIDO PRINCIPAL -->
<div id="mainContent">
    <!-- TOPBAR -->
    <header class="topbar">
        <div class="topbar-left">
            <button class="hamburger-btn" id="sidebarToggle" title="Menú">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="page-title"><?= esc($titulo ?? 'Panel Admin') ?></h1>
        </div>
        <div class="topbar-right">
            <span><i class="fas fa-user-circle me-1"></i><?= esc(session()->get('admin_nombre') ?? 'Admin') ?></span>
            <span class="admin-badge">Admin</span>
        </div>
    </header>

    <!-- MAIN -->
    <main>
        <?= $this->renderSection('contenido') ?>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Sidebar toggle mobile
    const sidebarEl   = document.getElementById('adminSidebar');
    const overlayEl   = document.getElementById('sidebarOverlay');
    const toggleBtn   = document.getElementById('sidebarToggle');

    function openSidebar() {
        sidebarEl.classList.add('open');
        overlayEl.classList.add('visible');
    }
    function closeSidebar() {
        sidebarEl.classList.remove('open');
        overlayEl.classList.remove('visible');
    }

    toggleBtn.addEventListener('click', function () {
        sidebarEl.classList.contains('open') ? closeSidebar() : openSidebar();
    });
    overlayEl.addEventListener('click', closeSidebar);
</script>

</body>
</html>
