<style>
    /* Excepciones mínimas: lo único que Tailwind Play CDN no puede expresar
       como utilidad (pseudo-elemento ::-webkit-scrollbar). Todo lo demás
       (colores, spacing, flex/grid, tipografía, animaciones, hover, etc.)
       vive como clases de utilidad directamente en el markup. */
    .mega-panel-cols::-webkit-scrollbar { height: 4px; }
    .mega-panel-cols::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 4px; }
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
$isPromos      = ($currentPath === 'promociones');
$isInformatica = (strncmp($currentPath, 'catalogo/informatica', 20) === 0);
$isMuebles     = (strncmp($currentPath, 'catalogo/muebles', 16) === 0);
$isElectro     = (strncmp($currentPath, 'catalogo/electrodomesticos', 26) === 0);
$isLinea       = (strncmp($currentPath, 'catalogo/linea-comercial', 24) === 0);

$_megaModel = new \App\Models\CategoriaModel();
$_megaData  = $_megaModel->getMegaMenu();

/* Clases compartidas para links del nav (hover subrayado con ::after animado
   + estado "active"/"mega-open" aplicado como marcador de clase que el JS
   togglea en tiempo real). */
$hnavLinkBase = 'relative inline-flex items-center gap-[5px] text-[#374151] font-inter text-[0.84rem] font-medium px-4 no-underline whitespace-nowrap cursor-pointer select-none transition-colors duration-[180ms] border-b-2 border-transparent hover:text-rojo hover:no-underline '
    . 'after:content-[\'\'] after:absolute after:-bottom-px after:left-0 after:right-0 after:h-[2px] after:bg-rojo after:rounded-t-[2px] after:origin-center after:scale-x-0 after:transition-transform after:duration-[220ms] after:ease-[cubic-bezier(.4,0,.2,1)] hover:after:scale-x-100 '
    . '[&.active]:text-rojo [&.active]:font-semibold [&.active]:after:scale-x-100 [&.mega-open]:text-rojo [&.mega-open]:after:scale-x-100';

$mobLnkBase = 'flex items-center gap-[10px] text-[#374151] font-inter text-[0.9rem] font-medium py-[0.72rem] px-[1.2rem] no-underline border-b border-[#F3F4F6] transition-colors duration-150 hover:text-rojo hover:bg-[#FFF5F7] [&.active]:text-rojo [&.active]:font-semibold';
?>

<!-- ═══════════════════════════════════════════════════════════
     HEADER PRINCIPAL
═══════════════════════════════════════════════════════════ -->
<header class="site-header group sticky top-0 z-[1030] bg-white shadow-[0_1px_0_#E8ECF0] transition-shadow duration-300 font-inter [&.scrolled]:shadow-[0_4px_20px_rgba(0,0,0,0.1)]" id="siteHeader">

    <div class="border-b border-[#EEF0F3]">
        <div class="container grid grid-cols-[22fr_56fr_22fr] items-center gap-5 h-[78px] transition-[height] duration-300 max-lg:grid-cols-[1fr_auto] group-[.scrolled]:h-[60px]">

            <a href="<?= base_url('/') ?>" class="flex items-center gap-[10px] no-underline shrink-0 transition-opacity duration-200 hover:opacity-[0.85]">
                <img src="<?= base_url('assets/img/logo_sinfondo.png') ?>"
                     alt="Centro Informático Regional"
                     class="h-[50px] w-auto object-contain block shrink-0 transition-[height] duration-300 max-lg:h-10 group-[.scrolled]:h-[38px]">
                <div class="flex flex-col gap-px leading-[1.1]">
                    <span class="text-dark text-[0.9rem] font-extrabold tracking-[0.03em] uppercase whitespace-nowrap transition-[font-size] duration-300 group-[.scrolled]:text-[0.8rem] max-[575px]:text-[0.8rem]">Centro Informático</span>
                    <span class="text-rojo text-[0.6rem] font-bold tracking-[0.28em] uppercase whitespace-nowrap transition-[font-size] duration-300 group-[.scrolled]:text-[0.55rem] max-[575px]:text-[0.55rem]">Regional</span>
                </div>
            </a>

            <form action="<?= base_url('catalogo/buscar') ?>" method="GET"
                  class="flex items-center bg-[#F4F6F9] border-[1.5px] border-[#E8ECF0] rounded-[50px] overflow-hidden transition-[border-color,box-shadow] duration-[220ms] w-full max-lg:!hidden focus-within:border-rojo focus-within:shadow-[0_0_0_3px_rgba(255,0,51,0.08)] focus-within:bg-white"
                  role="search">
                <input type="search" name="q"
                       class="flex-1 border-0 bg-transparent py-[0.6rem] px-[1.1rem] font-inter text-[0.875rem] text-dark outline-none min-w-0 placeholder:text-[#9CA3AF]"
                       placeholder="Buscar productos, marcas o categorías..."
                       autocomplete="off" aria-label="Buscar">
                <button type="submit"
                        class="flex items-center justify-center w-11 h-11 bg-rojo border-0 rounded-[0_50px_50px_0] text-white text-[0.9rem] cursor-pointer shrink-0 transition-colors duration-200 hover:bg-rojo-dark"
                        aria-label="Buscar">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <div class="flex items-center justify-end gap-[0.6rem] max-lg:!hidden">
                <?php if ($adminLoggedIn): ?>
                    <a href="<?= base_url('admin/dashboard') ?>"
                       class="inline-flex items-center gap-[6px] bg-[#FFF5F7] border-[1.5px] border-rojo/[0.25] text-rojo font-inter text-[0.8rem] font-bold py-[0.42rem] px-[0.9rem] rounded-[50px] no-underline whitespace-nowrap transition-[background-color,border-color] duration-200 hover:bg-[#FFE4EA] hover:border-rojo/[0.45] hover:text-rojo"
                       title="Panel de administración">
                        <i class="fas fa-shield-halved"></i> Panel
                    </a>
                    <a href="<?= base_url('admin/logout') ?>"
                       class="flex items-center justify-center w-9 h-9 rounded-lg bg-[#F9FAFB] border-[1.5px] border-[#E5E7EB] text-[#6B7280] text-[0.85rem] no-underline transition-colors duration-200 hover:bg-[#FFF5F7] hover:border-rojo/[0.3] hover:text-rojo"
                       title="Cerrar sesión (<?= esc($adminNombre) ?>)">
                        <i class="fas fa-right-from-bracket"></i>
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('admin/login') ?>"
                       class="inline-flex items-center gap-[7px] bg-transparent text-[#374151] font-inter text-[0.82rem] font-semibold py-[0.44rem] px-[1.05rem] rounded-lg no-underline whitespace-nowrap border-[1.5px] border-[#E5E7EB] transition-colors duration-[180ms] hover:bg-[#F9FAFB] hover:border-[#D1D5DB] hover:text-dark"
                       title="Iniciar sesión">
                        <i class="fas fa-right-to-bracket text-[0.8rem]"></i> Iniciar sesión
                    </a>
                <?php endif; ?>
            </div>

            <button class="group flex flex-col justify-center items-center w-10 h-10 bg-[#F9FAFB] border-[1.5px] border-[#E5E7EB] rounded-lg cursor-pointer gap-[5px] p-0 shrink-0 transition-colors duration-200 hover:bg-[#FFF5F7] hover:border-rojo/[0.3] lg:!hidden"
                    id="headerToggler"
                    aria-label="Abrir menú" aria-expanded="false">
                <span class="block w-[18px] h-[2px] bg-[#374151] rounded-[2px] origin-center transition-[transform,opacity,width] duration-[250ms] ease-in-out group-[.open]:translate-y-[7px] group-[.open]:rotate-45"></span>
                <span class="block w-[18px] h-[2px] bg-[#374151] rounded-[2px] origin-center transition-[transform,opacity,width] duration-[250ms] ease-in-out group-[.open]:opacity-0 group-[.open]:w-0"></span>
                <span class="block w-[18px] h-[2px] bg-[#374151] rounded-[2px] origin-center transition-[transform,opacity,width] duration-[250ms] ease-in-out group-[.open]:-translate-y-[7px] group-[.open]:-rotate-45"></span>
            </button>

        </div>
    </div>

    <nav class="bg-white border-t border-[#EEF0F3] max-lg:!hidden" aria-label="Navegación principal">
        <div class="container">
            <div class="flex items-stretch h-11 gap-0">

                <a href="<?= base_url('/') ?>"
                   class="<?= $hnavLinkBase ?><?= $isHome ? ' active' : '' ?>">
                    Inicio
                </a>

                <div class="group <?= $hnavLinkBase ?>" id="mega-trigger-btn"
                     role="button" tabindex="0"
                     aria-haspopup="true" aria-expanded="false">
                    Catálogo <i class="fas fa-chevron-down text-[0.62rem] opacity-60 transition-[transform,opacity] duration-200 group-[.mega-open]:rotate-180 group-[.mega-open]:opacity-100"></i>
                </div>

                <a href="<?= base_url('promociones') ?>"
                   class="<?= $hnavLinkBase ?><?= $isPromos ? ' active' : '' ?> font-bold <?= $isPromos ? 'text-rojo' : 'text-[#e8002d]' ?>">
                    <i class="fas fa-percent text-[0.7rem]"></i>
                    Promociones
                </a>

                <div class="w-px bg-[#EEF0F3] my-2 shrink-0"></div>

                <a href="<?= base_url('servicio-tecnico') ?>"
                   class="<?= $hnavLinkBase ?><?= $isServicio ? ' active' : '' ?>">
                    <i class="fas fa-screwdriver-wrench text-[0.72rem] opacity-[0.55]"></i>
                    Servicio Técnico
                </a>
                <a href="<?= base_url('nosotros') ?>"
                   class="<?= $hnavLinkBase ?><?= $isNosotros ? ' active' : '' ?>">
                    <i class="fas fa-building text-[0.72rem] opacity-[0.55]"></i>
                    Nosotros
                </a>
                <a href="<?= base_url('contacto') ?>"
                   class="<?= $hnavLinkBase ?><?= $isContacto ? ' active' : '' ?>">
                    Contacto
                </a>

            </div>
        </div>
    </nav>

    <div class="mobile-panel bg-white border-t border-[#EEF0F3] overflow-hidden max-h-0 transition-[max-height] duration-[360ms] ease-[cubic-bezier(.4,0,.2,1)] shadow-[0_8px_24px_rgba(0,0,0,0.1)] lg:!hidden [&.open]:max-h-[85vh] [&.open]:overflow-y-auto"
         id="mobilePanel" aria-hidden="true">
        <div class="pt-[0.75rem] pb-[1.5rem]">

            <div class="pt-2 px-4 pb-3 border-b border-[#EEF0F3]">
                <form action="<?= base_url('catalogo/buscar') ?>" method="GET"
                      class="flex items-center bg-[#F4F6F9] border-[1.5px] border-[#E8ECF0] rounded-[50px] overflow-hidden transition-colors duration-[220ms] focus-within:border-rojo"
                      role="search">
                    <input type="search" name="q" placeholder="Buscar productos..."
                           class="flex-1 border-0 bg-transparent py-[0.58rem] px-4 text-[0.875rem] text-dark outline-none font-inter placeholder:text-[#9CA3AF]"
                           autocomplete="off" aria-label="Buscar">
                    <button type="submit"
                            class="flex items-center justify-center w-10 h-10 bg-rojo border-0 rounded-[0_50px_50px_0] text-white text-[0.88rem] cursor-pointer shrink-0 transition-colors duration-200 hover:bg-rojo-dark"
                            aria-label="Buscar">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <a href="<?= base_url('/') ?>"
               class="<?= $mobLnkBase ?> nav-mob-close<?= $isHome ? ' active' : '' ?>">
                <i class="fas fa-home text-[0.8rem] opacity-50 w-4 text-center shrink-0"></i> Inicio
            </a>

            <div class="group flex items-center justify-between py-[0.72rem] px-[1.2rem] text-[#374151] font-inter text-[0.9rem] font-medium cursor-pointer border-b border-[#F3F4F6] transition-colors duration-150 select-none hover:text-rojo hover:bg-[#FFF5F7]"
                 id="mega-mobile-toggle" role="button" tabindex="0">
                <span class="flex items-center gap-[10px]"><i class="fas fa-layer-group text-[0.8rem] opacity-50"></i> Catálogo</span>
                <i class="fas fa-chevron-down text-[0.68rem] opacity-50 transition-[transform,opacity] duration-[220ms] group-[.open]:rotate-180 group-[.open]:opacity-100"></i>
            </div>
            <div class="mob-acc-body hidden bg-[#FAFAFA] pt-[0.4rem] pr-[1.2rem] pb-[0.7rem] pl-[1.6rem] border-b border-[#F3F4F6] [&.open]:block"
                 id="mega-mobile-body">
                <?php if (!empty($_megaData)): ?>
                    <?php foreach ($_megaData as $r): ?>
                    <div class="border-b border-[#F3F4F6] last-of-type:border-b-0">
                        <div class="mega-mob-rubro-hdr group flex items-center justify-between py-2 text-[#4B5563] text-[0.84rem] font-semibold cursor-pointer select-none transition-colors duration-150 hover:text-rojo [&.open]:text-rojo"
                             role="button" tabindex="0">
                            <span>
                                <i class="<?= esc($r['icono']) ?> mr-[5px] text-[0.78rem] opacity-60"></i>
                                <?= esc($r['nombre']) ?>
                            </span>
                            <i class="fas fa-chevron-right text-[0.65rem] opacity-50 transition-transform duration-200 group-[.open]:rotate-90 group-[.open]:opacity-100"></i>
                        </div>
                        <div class="hidden pt-[0.1rem] pr-0 pb-[0.4rem] pl-[0.6rem] [&.open]:block">
                            <?php foreach ($r['hijos'] as $sub): ?>
                            <a href="<?= base_url('catalogo/'.esc($r['slug']).'/'.esc($sub['slug'])) ?>"
                               class="text-[#6B7280] font-inter text-[0.84rem] no-underline block py-[5px] transition-colors duration-150 hover:text-rojo nav-mob-close">
                                <i class="<?= esc($sub['icono']) ?> mr-1 text-[0.72rem] opacity-50"></i>
                                <?= esc($sub['nombre']) ?>
                            </a>
                            <?php endforeach; ?>
                            <a href="<?= base_url('catalogo/'.esc($r['slug'])) ?>"
                               class="text-rojo font-semibold mt-[0.3rem] font-inter text-[0.84rem] no-underline block py-[5px] transition-colors duration-150 nav-mob-close">
                                Ver todo en <?= esc($r['nombre']) ?> &rarr;
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <a href="<?= base_url('catalogo') ?>"
                       class="text-rojo font-semibold mt-[0.4rem] font-inter text-[0.84rem] no-underline block py-[5px] pt-[0.5rem] border-t border-[#F3F4F6] transition-colors duration-150 nav-mob-close">
                        Ver catálogo completo &rarr;
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('catalogo') ?>" class="text-[#6B7280] font-inter text-[0.84rem] no-underline block py-[5px] transition-colors duration-150 hover:text-rojo nav-mob-close">Ver catálogo</a>
                <?php endif; ?>
            </div>

            <a href="<?= base_url('promociones') ?>"
               class="<?= $mobLnkBase ?> nav-mob-close<?= $isPromos ? ' active' : '' ?> font-bold text-[#e8002d]">
                <i class="fas fa-percent text-[0.8rem] opacity-50 w-4 text-center shrink-0"></i> Promociones
            </a>

            <a href="<?= base_url('servicio-tecnico') ?>"
               class="<?= $mobLnkBase ?> nav-mob-close<?= $isServicio ? ' active' : '' ?>">
                <i class="fas fa-screwdriver-wrench text-[0.8rem] opacity-50 w-4 text-center shrink-0"></i> Servicio Técnico
            </a>
            <a href="<?= base_url('nosotros') ?>"
               class="<?= $mobLnkBase ?> nav-mob-close<?= $isNosotros ? ' active' : '' ?>">
                <i class="fas fa-building text-[0.8rem] opacity-50 w-4 text-center shrink-0"></i> Nosotros
            </a>
            <a href="<?= base_url('contacto') ?>"
               class="<?= $mobLnkBase ?> nav-mob-close<?= $isContacto ? ' active' : '' ?>">
                <i class="fas fa-envelope text-[0.8rem] opacity-50 w-4 text-center shrink-0"></i> Contacto
            </a>

            <div class="pt-4 px-[1.2rem] pb-4 border-t border-[#EEF0F3] flex flex-wrap gap-[0.7rem]">
                <?php if ($adminLoggedIn): ?>
                    <a href="<?= base_url('admin/dashboard') ?>"
                       class="inline-flex items-center gap-[6px] bg-[#FFF5F7] border-[1.5px] border-rojo/[0.25] text-rojo font-inter text-[0.8rem] font-bold py-[0.42rem] px-[0.9rem] rounded-[50px] no-underline whitespace-nowrap transition-[background-color,border-color] duration-200 hover:bg-[#FFE4EA] hover:border-rojo/[0.45] hover:text-rojo">
                        <i class="fas fa-shield-halved"></i> Panel Admin
                    </a>
                    <a href="<?= base_url('admin/logout') ?>"
                       class="flex items-center justify-center w-9 h-9 rounded-lg bg-[#F9FAFB] border-[1.5px] border-[#E5E7EB] text-[#6B7280] text-[0.85rem] no-underline transition-colors duration-200 hover:bg-[#FFF5F7] hover:border-rojo/[0.3] hover:text-rojo"
                       title="Cerrar sesión">
                        <i class="fas fa-right-from-bracket"></i>
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('admin/login') ?>"
                       class="inline-flex items-center gap-[7px] bg-transparent text-[#374151] font-inter text-[0.82rem] font-semibold py-[0.44rem] px-[1.05rem] rounded-lg no-underline whitespace-nowrap border-[1.5px] border-[#E5E7EB] transition-colors duration-[180ms] hover:bg-[#F9FAFB] hover:border-[#D1D5DB] hover:text-dark w-full justify-center">
                        <i class="fas fa-right-to-bracket text-[0.8rem]"></i> Iniciar sesión
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>

</header>

<!-- Botón flotante de WhatsApp -->
<a href="https://wa.me/5493704616482?text=Hola%2C%20quiero%20consultar%20sobre%20sus%20productos"
   target="_blank" rel="noopener noreferrer"
   class="fixed bottom-7 right-7 z-[9998] w-14 h-14 rounded-full flex items-center justify-center bg-[#25D366] text-white no-underline shadow-[0_6px_24px_rgba(37,211,102,0.4)] animate-float-wa-in transition-[transform,box-shadow] duration-200 hover:-translate-y-[3px] hover:scale-[1.07] hover:shadow-[0_10px_32px_rgba(37,211,102,0.52)] hover:text-white max-[575px]:w-[50px] max-[575px]:h-[50px] max-[575px]:bottom-5 max-[575px]:right-5 before:content-[''] before:absolute before:-inset-[6px] before:rounded-full before:border-2 before:border-[rgba(37,211,102,0.45)] before:animate-float-wa-pulse before:pointer-events-none"
   aria-label="Consultar por WhatsApp">
    <i class="fab fa-whatsapp text-[1.45rem] leading-none max-[575px]:text-[1.25rem]"></i>
    <span class="hidden">Consultar por WhatsApp</span>
</a>

<!-- ═══════════════════════════════════════════════════════════
     MEGA DROPDOWN — Estilo Naldo: sidebar + columnas de cats
═══════════════════════════════════════════════════════════ -->
<div class="mega-dropdown fixed left-0 right-0 top-[var(--header-h,120px)] z-[1028] bg-white shadow-[0_12px_32px_rgba(0,0,0,0.1),0_2px_8px_rgba(0,0,0,0.06)] border-t-[3px] border-rojo animate-mega-slide-in hidden max-lg:!hidden [&.open]:block"
     id="mega-dropdown" role="dialog" aria-label="Menú de categorías">

    <?php if (!empty($_megaData)): ?>

    <div class="flex max-w-[1400px] mx-auto max-h-[500px] min-h-[360px]">

        <!-- ══ Sidebar izquierdo: rubros ══ -->
        <div class="w-[245px] shrink-0 bg-[#F7F8FA] border-r border-[#E8ECF0] flex flex-col overflow-y-auto">
            <div class="flex items-center gap-2 pt-[0.9rem] px-[1.1rem] pb-[0.7rem] font-inter text-[0.76rem] font-extrabold text-dark tracking-[0.04em] uppercase border-b border-[#E8ECF0] shrink-0">
                <i class="fas fa-bars text-rojo text-[0.78rem]"></i> Categorías
            </div>

            <?php foreach ($_megaData as $rubro): ?>
            <div class="mega-rubro-item group flex items-center gap-[9px] py-[0.62rem] px-[1.1rem] cursor-pointer select-none border-l-[3px] border-transparent bg-transparent transition-colors duration-[120ms] no-underline hover:bg-[#ECEEF2] hover:border-l-[rgba(255,0,51,0.35)] [&.active]:bg-white [&.active]:border-l-rojo"
                 data-pane="mgp-<?= (int)$rubro['id'] ?>"
                 role="button" tabindex="0">
                <span class="w-7 h-7 flex items-center justify-center rounded-[6px] bg-[#E5E7EB] text-[#6B7280] text-[0.74rem] shrink-0 transition-colors duration-[120ms] group-hover:bg-rojo/[0.09] group-hover:text-rojo group-[.active]:bg-rojo/[0.09] group-[.active]:text-rojo"><i class="<?= esc($rubro['icono']) ?>"></i></span>
                <span class="flex-1 font-inter text-[0.84rem] font-medium text-[#374151] transition-colors duration-[120ms] whitespace-nowrap group-hover:text-dark group-hover:font-semibold group-[.active]:text-dark group-[.active]:font-semibold"><?= esc($rubro['nombre']) ?></span>
                <i class="fas fa-chevron-right text-[0.58rem] text-[#C9CDD4] shrink-0 transition-colors duration-[120ms] group-[.active]:text-rojo"></i>
            </div>
            <?php endforeach; ?>

            <div class="mt-auto py-[0.7rem] px-[1.1rem] border-t border-[#E8ECF0] shrink-0">
                <a href="<?= base_url('catalogo') ?>" class="flex items-center gap-[6px] text-rojo font-inter text-[0.76rem] font-bold no-underline transition-opacity duration-[140ms] hover:opacity-[0.72]">
                    <i class="fas fa-th-large"></i> Ver catálogo completo
                </a>
            </div>
        </div>

        <!-- ══ Panel derecho: columnas de categorías ══ -->
        <div class="flex-1 min-w-0 flex flex-col overflow-hidden bg-white" id="mega-panel-wrap">

            <?php foreach ($_megaData as $rubro): ?>
            <div id="mgp-<?= (int)$rubro['id'] ?>" class="mega-panel flex-1 hidden flex-col animate-mega-panel-in min-h-0 [&.active]:flex">

                <!-- Columnas de subcategorías -->
                <div class="mega-panel-cols flex-1 flex overflow-x-auto overflow-y-auto [scrollbar-width:thin] [scrollbar-color:#E5E7EB_transparent]">
                    <?php if (!empty($rubro['hijos'])): ?>
                        <?php foreach ($rubro['hijos'] as $sub): ?>
                        <div class="group flex-1 min-w-[160px] max-w-[215px] pt-[1.2rem] px-4 pb-4 flex flex-col border-r border-[#F0F2F5] last:border-r-0">

                            <!-- Título: enlace a la subcategoría -->
                            <a href="<?= base_url('catalogo/'.esc($rubro['slug']).'/'.esc($sub['slug'])) ?>"
                               class="font-inter text-[0.82rem] font-bold text-dark no-underline block mb-[0.6rem] whitespace-nowrap overflow-hidden text-ellipsis transition-colors duration-[130ms] leading-[1.3] hover:text-rojo">
                                <?= esc($sub['nombre']) ?>
                            </a>

                            <!-- Imagen representativa (placeholder con ícono) -->
                            <div class="w-full aspect-[1.75] bg-[#F5F7FA] border border-[#EEF0F3] rounded-lg flex items-center justify-center mb-3 shrink-0 overflow-hidden transition-colors duration-150 group-hover:bg-[#EEF1F8] group-hover:border-[#D8DCE6]">
                                <i class="<?= esc($sub['icono']) ?> text-[1.65rem] text-[#C4C9D4] transition-colors duration-150 group-hover:text-[#9CA3AF]"></i>
                            </div>

                            <!-- Sub-subcategorías -->
                            <?php if (!empty($sub['hijos'])): ?>
                            <ul class="list-none p-0 m-0 flex-1">
                                <?php foreach ($sub['hijos'] as $subsub): ?>
                                <li class="p-0 m-0">
                                    <a href="<?= base_url('catalogo/'.esc($rubro['slug']).'/'.esc($sub['slug']).'/'.esc($subsub['slug'])) ?>"
                                       class="block font-inter text-[0.76rem] text-[#6B7280] no-underline py-[3px] whitespace-nowrap overflow-hidden text-ellipsis transition-colors duration-[120ms] hover:text-dark before:content-['·'] before:mr-[5px] before:text-[#D1D5DB]">
                                        <?= esc($subsub['nombre']) ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>

                            <!-- Ver todo de esta subcategoría -->
                            <a href="<?= base_url('catalogo/'.esc($rubro['slug']).'/'.esc($sub['slug'])) ?>"
                               class="inline-flex items-center gap-1 font-inter text-[0.73rem] font-semibold text-rojo no-underline mt-2 shrink-0 transition-[gap,color] duration-[140ms] hover:gap-[7px] hover:text-rojo-dark">
                                Ver todo <i class="fas fa-arrow-right text-[0.57rem]"></i>
                            </a>

                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="flex-1 flex items-center justify-center p-8 text-[#9CA3AF]">
                            <div class="text-center">
                                <i class="<?= esc($rubro['icono']) ?> block mb-2 text-[2rem]"></i>
                                <a href="<?= base_url('catalogo/'.esc($rubro['slug'])) ?>"
                                   class="font-inter text-[0.84rem] text-rojo font-semibold no-underline">
                                    Ver <?= esc($rubro['nombre']) ?> &rarr;
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Footer: "Ver todo en Rubro" -->
                <div class="shrink-0 py-[0.55rem] px-[1.1rem] border-t border-[#F0F2F5] bg-[#FAFBFC] flex items-center justify-between">
                    <span class="font-inter text-[0.74rem] font-semibold text-[#9CA3AF] flex items-center gap-[6px]">
                        <i class="<?= esc($rubro['icono']) ?> text-[0.68rem]"></i>
                        <?= esc($rubro['nombre']) ?>
                    </span>
                    <a href="<?= base_url('catalogo/'.esc($rubro['slug'])) ?>"
                       class="inline-flex items-center gap-[5px] font-inter text-[0.74rem] font-bold text-rojo no-underline transition-[gap] duration-[140ms] hover:gap-2">
                        Ver todo en <?= esc($rubro['nombre']) ?>
                        <i class="fas fa-arrow-right text-[0.58rem]"></i>
                    </a>
                </div>

            </div><!-- /.mega-panel -->
            <?php endforeach; ?>

            <!-- Placeholder inicial -->
            <div id="mega-panel-placeholder" class="flex-1 flex flex-col items-center justify-center gap-[10px] text-[#D1D5DB] font-inter">
                <i class="fas fa-layer-group text-[2rem]"></i>
                <span class="text-[0.82rem]">Pasá el cursor por una categoría</span>
            </div>

        </div><!-- /.mega-panel-wrap -->

    </div><!-- /.mega-body -->

    <?php else: ?>
    <div class="p-8 text-[#9CA3AF] font-inter text-[0.9rem]">
        No hay categorías disponibles.
    </div>
    <?php endif; ?>

</div><!-- /.mega-dropdown -->

<script>
(function () {

    /* ── Sincronizar --header-h ── */
    var siteHeader = document.getElementById('siteHeader');
    var megaDrop   = document.getElementById('mega-dropdown');

    function syncHeaderHeight() {
        if (siteHeader) {
            document.documentElement.style.setProperty('--header-h', siteHeader.offsetHeight + 'px');
        }
    }
    syncHeaderHeight();

    window.addEventListener('scroll', function () {
        siteHeader.classList.toggle('scrolled', window.scrollY > 55);
        syncHeaderHeight();
    }, { passive: true });
    window.addEventListener('resize', syncHeaderHeight, { passive: true });

    /* ── Mobile panel toggle ── */
    var toggler     = document.getElementById('headerToggler');
    var mobilePanel = document.getElementById('mobilePanel');

    function openPanel() {
        mobilePanel.classList.add('open');
        mobilePanel.setAttribute('aria-hidden', 'false');
        toggler.classList.add('open');
        toggler.setAttribute('aria-expanded', 'true');
    }
    function closePanel() {
        mobilePanel.classList.remove('open');
        mobilePanel.setAttribute('aria-hidden', 'true');
        toggler.classList.remove('open');
        toggler.setAttribute('aria-expanded', 'false');
    }
    if (toggler && mobilePanel) {
        toggler.addEventListener('click', function () {
            mobilePanel.classList.contains('open') ? closePanel() : openPanel();
        });
    }
    document.querySelectorAll('.nav-mob-close').forEach(function (el) {
        el.addEventListener('click', closePanel);
    });

    /* ── DESKTOP: Mega dropdown ── */
    var trigger     = document.getElementById('mega-trigger-btn');
    var placeholder = document.getElementById('mega-panel-placeholder');

    if (trigger && megaDrop) {
        var rubroItems  = megaDrop.querySelectorAll('.mega-rubro-item');
        var panels      = megaDrop.querySelectorAll('.mega-panel');
        var activeId    = null;

        function selectRubro(paneId) {
            if (activeId === paneId) return;
            activeId = paneId;

            rubroItems.forEach(function (r) { r.classList.remove('active'); });
            panels.forEach(function (p) { p.classList.remove('active'); });
            if (placeholder) placeholder.style.display = 'none';

            var item = megaDrop.querySelector('[data-pane="' + paneId + '"]');
            if (item) item.classList.add('active');

            var panel = document.getElementById(paneId);
            if (panel) panel.classList.add('active');
        }

        function resetPanels() {
            rubroItems.forEach(function (r) { r.classList.remove('active'); });
            panels.forEach(function (p) { p.classList.remove('active'); });
            if (placeholder) placeholder.style.display = 'flex';
            activeId = null;
        }

        function openMega() {
            syncHeaderHeight();
            megaDrop.classList.add('open');
            trigger.classList.add('mega-open');
            trigger.setAttribute('aria-expanded', 'true');
            /* Auto-seleccionar el primer rubro */
            if (rubroItems.length > 0) {
                selectRubro(rubroItems[0].dataset.pane);
            }
        }

        function closeMega() {
            megaDrop.classList.remove('open');
            trigger.classList.remove('mega-open');
            trigger.setAttribute('aria-expanded', 'false');
            resetPanels();
        }

        /* Hover sobre rubro → muestra sus columnas */
        rubroItems.forEach(function (item) {
            item.addEventListener('mouseenter', function () {
                selectRubro(item.dataset.pane);
            });
            item.addEventListener('click', function (e) {
                e.stopPropagation();
                selectRubro(item.dataset.pane);
            });
            item.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    selectRubro(item.dataset.pane);
                }
            });
        });

        trigger.addEventListener('click', function (e) {
            e.stopPropagation();
            megaDrop.classList.contains('open') ? closeMega() : openMega();
        });
        trigger.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                megaDrop.classList.contains('open') ? closeMega() : openMega();
            }
            if (e.key === 'Escape') closeMega();
        });
        document.addEventListener('click', function (e) {
            if (!megaDrop.contains(e.target) && e.target !== trigger) closeMega();
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeMega();
        });
    }

    /* ── Mobile: acordeón Catálogo ── */
    var mobToggle = document.getElementById('mega-mobile-toggle');
    var mobBody   = document.getElementById('mega-mobile-body');
    if (mobToggle && mobBody) {
        mobToggle.addEventListener('click', function () {
            var isOpen = mobBody.classList.contains('open');
            mobBody.classList.toggle('open', !isOpen);
            mobToggle.classList.toggle('open', !isOpen);
        });
        mobToggle.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); mobToggle.click(); }
        });
    }

    /* ── Sub-acordeón por rubro (mobile) ── */
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

})();
</script>
