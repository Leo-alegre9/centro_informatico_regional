<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($titulo ?? 'Panel Admin | CIR') ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <?= $this->include('componentes/tailwind_config') ?>
</head>
<body class="flex min-h-screen bg-[#f4f6f9] font-sans">

<!-- Overlay mobile -->
<div id="sidebarOverlay" class="hidden fixed inset-0 bg-black/50 z-[1039]"></div>

<!-- SIDEBAR -->
<aside id="adminSidebar"
       class="fixed top-0 left-0 h-screen w-[260px] bg-dark flex flex-col shrink-0 z-[1040]
              -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="px-5 pt-6 pb-5 border-b border-white/[0.07] flex items-center">
        <div class="w-[42px] h-[42px] inline-flex items-center justify-center mr-2.5 shrink-0">
            <img src="<?= base_url('assets/img/CIR_sinfondo.png') ?>" alt="CIR" class="w-full h-full object-contain">
        </div>
        <div>
            <div class="text-white text-[0.95rem] font-bold leading-tight">CIR Admin</div>
            <span class="text-white/40 text-[0.72rem] block">Centro Informático Regional</span>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto px-3 py-4">
        <div class="text-white/30 text-[0.68rem] font-bold tracking-wider uppercase px-2 pt-3 pb-1 mt-2">Principal</div>

        <?php
        $currentUrl   = current_url();
        $isDashboard  = strpos($currentUrl, 'admin/dashboard') !== false || preg_match('#/admin/?$#', $currentUrl);
        $isBuscar     = strpos($currentUrl, 'admin/productos/buscar') !== false;
        $isProductos  = !$isBuscar && strpos($currentUrl, 'admin/productos') !== false;
        $isCategorias = strpos($currentUrl, 'admin/categorias') !== false;
        $isMarcas     = strpos($currentUrl, 'admin/marcas') !== false;
        $isFabricas   = strpos($currentUrl, 'admin/fabricas') !== false;
        $isConsultas  = strpos($currentUrl, 'admin/consultas') !== false;
        $isInventario     = strpos($currentUrl, 'admin/inventario') !== false;
        $isStock          = strpos($currentUrl, 'admin/stock') !== false;
        $isConfiguracion  = strpos($currentUrl, 'admin/configuracion') !== false;
        $unreadCount      = (new \App\Models\ConsultaServicioModel())->getUnreadCount();

        $navLink = 'flex items-center px-[0.85rem] py-[0.62rem] rounded-[9px] text-white/65 no-underline text-[0.9rem] font-medium mb-0.5 transition-colors hover:bg-white/[0.07] hover:text-white';
        $navLinkActivo = 'flex items-center px-[0.85rem] py-[0.62rem] rounded-[9px] bg-rojo/15 text-white font-semibold no-underline text-[0.9rem] mb-0.5';
        $navIcon = 'w-5 mr-[0.7rem] text-center text-[0.95rem]';
        ?>

        <a href="<?= base_url('admin/dashboard') ?>" class="<?= $isDashboard ? $navLinkActivo : $navLink ?>">
            <i class="fas fa-tachometer-alt <?= $navIcon ?> <?= $isDashboard ? 'text-rojo' : '' ?>"></i> Dashboard
        </a>

        <div class="text-white/30 text-[0.68rem] font-bold tracking-wider uppercase px-2 pt-3 pb-1 mt-2">Catálogo</div>

        <a href="<?= base_url('admin/productos') ?>" class="<?= $isProductos ? $navLinkActivo : $navLink ?>">
            <i class="fas fa-box <?= $navIcon ?> <?= $isProductos ? 'text-rojo' : '' ?>"></i> Productos
        </a>

        <a href="<?= base_url('admin/productos/buscar') ?>" class="<?= $isBuscar ? $navLinkActivo : $navLink ?>">
            <i class="fas fa-search <?= $navIcon ?> <?= $isBuscar ? 'text-rojo' : '' ?>"></i> Buscar producto
        </a>

        <a href="<?= base_url('admin/categorias') ?>" class="<?= $isCategorias ? $navLinkActivo : $navLink ?>">
            <i class="fas fa-sitemap <?= $navIcon ?> <?= $isCategorias ? 'text-rojo' : '' ?>"></i> Categorías
        </a>

        <a href="<?= base_url('admin/marcas') ?>" class="<?= $isMarcas ? $navLinkActivo : $navLink ?>">
            <i class="fas fa-tag <?= $navIcon ?> <?= $isMarcas ? 'text-rojo' : '' ?>"></i> Marcas
        </a>

        <a href="<?= base_url('admin/fabricas') ?>" class="<?= $isFabricas ? $navLinkActivo : $navLink ?>">
            <i class="fas fa-industry <?= $navIcon ?> <?= $isFabricas ? 'text-rojo' : '' ?>"></i> Fábricas
        </a>

        <div class="text-white/30 text-[0.68rem] font-bold tracking-wider uppercase px-2 pt-3 pb-1 mt-2">Inventario</div>

        <a href="<?= base_url('admin/inventario') ?>" class="<?= $isInventario ? $navLinkActivo : $navLink ?>">
            <i class="fas fa-warehouse <?= $navIcon ?> <?= $isInventario ? 'text-rojo' : '' ?>"></i> Ubicaciones
        </a>

        <a href="<?= base_url('admin/stock') ?>" class="<?= $isStock ? $navLinkActivo : $navLink ?>">
            <i class="fas fa-boxes <?= $navIcon ?> <?= $isStock ? 'text-rojo' : '' ?>"></i> Stock
        </a>

        <div class="text-white/30 text-[0.68rem] font-bold tracking-wider uppercase px-2 pt-3 pb-1 mt-2">Servicio Técnico</div>

        <a href="<?= base_url('admin/consultas') ?>" class="<?= $isConsultas ? $navLinkActivo : $navLink ?> justify-between">
            <span><i class="fas fa-headset <?= $navIcon ?> <?= $isConsultas ? 'text-rojo' : '' ?>"></i> Consultas</span>
            <?php if ($unreadCount > 0): ?>
            <span class="bg-rojo text-white text-[0.7rem] font-bold px-[7px] py-0.5 rounded-full min-w-[20px] text-center">
                <?= $unreadCount ?>
            </span>
            <?php endif; ?>
        </a>

        <div class="text-white/30 text-[0.68rem] font-bold tracking-wider uppercase px-2 pt-3 pb-1 mt-2">Configuración</div>

        <a href="<?= base_url('admin/configuracion') ?>" class="<?= $isConfiguracion ? $navLinkActivo : $navLink ?>">
            <i class="fas fa-sliders <?= $navIcon ?> <?= $isConfiguracion ? 'text-rojo' : '' ?>"></i> Precios y cotización
        </a>

        <div class="text-white/30 text-[0.68rem] font-bold tracking-wider uppercase px-2 pt-3 pb-1 mt-2">Sitio</div>

        <a href="<?= base_url() ?>" target="_blank" class="flex items-center px-[0.85rem] py-[0.62rem] rounded-[9px] text-white/50 no-underline text-[0.85rem] font-medium mb-0.5 transition-colors hover:text-white/80">
            <i class="fas fa-external-link-alt <?= $navIcon ?>"></i> Ver sitio
        </a>
    </nav>

    <div class="px-3 py-4 border-t border-white/[0.07]">
        <div class="flex items-center px-[0.85rem] py-[0.6rem] rounded-[9px] bg-white/5 mb-2">
            <div class="w-9 h-9 bg-rojo rounded-full flex items-center justify-center text-[0.9rem] font-bold text-white shrink-0 mr-[0.65rem]">
                <?= strtoupper(substr(session()->get('admin_nombre') ?? 'A', 0, 1)) ?>
            </div>
            <div>
                <div class="text-white text-[0.88rem] font-semibold leading-tight"><?= esc(session()->get('admin_nombre') ?? 'Admin') ?></div>
                <div class="text-white/40 text-[0.72rem]">Administrador</div>
            </div>
        </div>
        <a href="<?= base_url('admin/logout') ?>"
           class="flex items-center px-[0.85rem] py-2 text-red-400/80 no-underline text-[0.85rem] rounded-[9px] transition-colors hover:bg-rojo/[0.12] hover:text-[#ff6b6b]">
            <i class="fas fa-sign-out-alt mr-[0.6rem]"></i> Cerrar sesión
        </a>
    </div>
</aside>

<!-- CONTENIDO PRINCIPAL -->
<div id="mainContent" class="flex-1 flex flex-col min-w-0 ml-0 lg:ml-[260px] transition-[margin-left] duration-300 ease-in-out">
    <!-- TOPBAR -->
    <header class="bg-white border-b border-gray-200 px-6 py-[0.85rem] flex items-center justify-between sticky top-0 z-[1030]">
        <div class="flex items-center gap-4">
            <button class="block lg:hidden bg-transparent border-0 cursor-pointer p-[0.3rem] text-gray-700 text-xl leading-none" id="sidebarToggle" title="Menú">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="text-base font-semibold text-gray-900 m-0"><?= esc($titulo ?? 'Panel Admin') ?></h1>
        </div>
        <div class="flex items-center gap-3 text-gray-500 text-[0.88rem]">
            <span><i class="fas fa-user-circle mr-1"></i><?= esc(session()->get('admin_nombre') ?? 'Admin') ?></span>
            <span class="bg-rojo/[0.08] text-rojo px-[0.7rem] py-1 rounded-full text-[0.82rem] font-semibold">Admin</span>
        </div>
    </header>

    <!-- MAIN -->
    <main class="p-7 flex-1">
        <?= $this->renderSection('contenido') ?>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Sidebar toggle mobile
    const sidebarEl   = document.getElementById('adminSidebar');
    const overlayEl   = document.getElementById('sidebarOverlay');
    const toggleBtn   = document.getElementById('sidebarToggle');

    function openSidebar() {
        sidebarEl.classList.remove('-translate-x-full');
        sidebarEl.classList.add('translate-x-0');
        overlayEl.classList.remove('hidden');
    }
    function closeSidebar() {
        sidebarEl.classList.add('-translate-x-full');
        sidebarEl.classList.remove('translate-x-0');
        overlayEl.classList.add('hidden');
    }

    toggleBtn.addEventListener('click', function () {
        sidebarEl.classList.contains('translate-x-0') ? closeSidebar() : openSidebar();
    });
    overlayEl.addEventListener('click', closeSidebar);
</script>

</body>
</html>
