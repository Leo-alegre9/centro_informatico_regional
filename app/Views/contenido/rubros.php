<style>
    /* ══════════════════════════════════════════════════════════
       CATEGORÍAS — Keyframe no registrado en tailwind_config.php
    ══════════════════════════════════════════════════════════ */
    @keyframes catsPanelIn {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
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

/* Clases de utilidades reutilizadas para tarjeta destacada vs. normal */
$_catContentBase     = 'absolute bottom-0 left-0 right-0 flex flex-col gap-1 px-4 pt-[0.85rem] pb-4 sm:px-5 sm:pt-[1.1rem] sm:pb-[1.2rem]';
$_catContentFeatured = 'absolute bottom-0 left-0 right-0 flex flex-col gap-1 px-5 pt-[1.1rem] pb-[1.1rem] sm:px-7 sm:pt-[1.6rem] sm:pb-7';
$_catIconBase        = 'text-[1.1rem] text-white/65 mb-1 transition-colors duration-200 group-hover:text-white/90';
$_catIconFeatured    = 'text-[1.4rem] text-white/65 mb-1 transition-colors duration-200 group-hover:text-white/90';
$_catNameBase        = 'font-inter text-[0.88rem] sm:text-base font-bold text-white leading-[1.2] tracking-[-0.01em]';
$_catNameFeatured    = 'font-inter text-[1.15rem] sm:text-[1.35rem] md:text-[clamp(1.4rem,2.2vw,1.9rem)] font-extrabold text-white leading-[1.2] tracking-[-0.025em] mb-[6px]';
$_catArrowBase       = 'inline-flex items-center gap-[6px] font-inter text-xs font-bold text-white/70 opacity-100 translate-y-0 md:opacity-0 md:translate-y-[6px] transition-[opacity,transform,color] duration-[250ms] mt-0.5 group-hover:opacity-100 group-hover:translate-y-0 group-hover:text-white';
$_catArrowFeatured   = 'inline-flex items-center gap-[6px] font-inter text-[0.85rem] font-bold text-white/70 opacity-100 translate-y-0 md:opacity-0 md:translate-y-[6px] transition-[opacity,transform,color] duration-[250ms] mt-0.5 group-hover:opacity-100 group-hover:translate-y-0 group-hover:text-white';
?>

<!-- ═══════════════════════════════════════════════════════════
     EXPLORÁ NUESTRAS CATEGORÍAS
═══════════════════════════════════════════════════════════ -->
<section class="bg-white pt-[3rem] pb-14 sm:pt-20 sm:pb-[5.5rem] border-t border-[#EEF0F3]" id="rubros" aria-label="Explorá nuestras categorías">
    <div class="container">

        <!-- ── Encabezado ── -->
        <div class="text-center mb-10 cats-reveal opacity-0 translate-y-[22px] transition-[opacity,transform] duration-[520ms] ease-in-out [&.visible]:opacity-100 [&.visible]:translate-y-0">
            <p class="inline-flex items-center gap-[9px] font-inter text-[0.67rem] font-bold tracking-[0.18em] uppercase text-gray-400 mb-[0.85rem]
                      before:content-[''] before:inline-block before:w-[18px] before:h-0.5 before:bg-rojo before:rounded-full before:shrink-0
                      after:content-[''] after:inline-block after:w-[18px] after:h-0.5 after:bg-rojo after:rounded-full after:shrink-0">Lo que ofrecemos</p>
            <h2 class="font-inter text-[clamp(1.9rem,3vw,2.6rem)] font-extrabold text-slate-900 tracking-[-0.025em] leading-[1.15] mb-3">
                Explorá nuestras <span class="text-rojo">categorías</span>
            </h2>
            <p class="font-inter text-[0.98rem] text-gray-500 max-w-[500px] mx-auto leading-[1.75]">
                Todo lo que necesitás para tu hogar, oficina o negocio en un solo lugar.
            </p>
        </div>

        <?php if (!empty($_rubrosData)): ?>

        <!-- ── Tabs de rubros ── -->
        <div class="flex justify-center mb-8 cats-reveal opacity-0 translate-y-[22px] transition-[opacity,transform] duration-[520ms] ease-in-out delay-[50ms] [&.visible]:opacity-100 [&.visible]:translate-y-0">
            <div class="flex gap-1.5 md:gap-2 flex-wrap justify-center bg-gray-50 border-[1.5px] border-[#EEF0F3] rounded-2xl sm:rounded-full p-1 sm:p-[5px]" role="tablist" aria-label="Rubros">
                <?php foreach ($_rubrosData as $ri => $rubro):
                    $cfg = $_rubroConfig[$rubro['slug']] ?? $_cfgDefault;
                ?>
                <button class="cats-tab <?= $ri === 0 ? 'active' : '' ?> inline-flex items-center gap-[7px] rounded-xl sm:rounded-full border-none bg-transparent text-gray-500 font-inter text-[0.78rem] md:text-[0.84rem] font-semibold cursor-pointer whitespace-nowrap outline-none px-[0.9rem] py-[0.45rem] md:px-5 md:py-[0.52rem] transition-colors duration-200
                               [&:hover:not(.active)]:text-gray-700 [&:hover:not(.active)]:bg-white
                               [&.active]:bg-rojo [&.active]:text-white [&.active]:shadow-[0_4px_14px_rgba(255,0,51,0.28)]"
                        role="tab"
                        aria-selected="<?= $ri === 0 ? 'true' : 'false' ?>"
                        aria-controls="panel-<?= esc($rubro['slug']) ?>"
                        data-panel="panel-<?= esc($rubro['slug']) ?>">
                    <i class="<?= esc($cfg['icono']) ?> text-[0.78rem]"></i>
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
        <div class="cats-panel hidden [&.active]:block [&.active]:animate-[catsPanelIn_0.32s_cubic-bezier(.4,0,.2,1)] cats-reveal opacity-0 translate-y-[22px] transition-[opacity,transform] duration-[520ms] ease-in-out delay-[120ms] [&.visible]:opacity-100 [&.visible]:translate-y-0 <?= $ri === 0 ? 'active' : '' ?>"
             id="panel-<?= esc($rubro['slug']) ?>"
             role="tabpanel"
             aria-label="Categorías de <?= esc($rubro['nombre']) ?>">

            <?php if (!empty($hijos)): ?>
            <div class="grid grid-cols-2 auto-rows-[140px] gap-[10px] sm:auto-rows-[155px] sm:gap-3 md:grid-cols-[2fr_1fr] md:auto-rows-[185px] lg:grid-cols-[2fr_1fr_1fr] lg:auto-rows-[208px]">
                <?php foreach ($hijos as $ci => $cat):
                    $isFirst  = ($ci === 0);
                    $bgImg    = $_catImg[$cat['slug']] ?? $bgRubro;
                    $tint     = $_tints[$ci % count($_tints)];
                    $bgPos    = $_bgPos[$ci % count($_bgPos)];
                    $catUrl   = base_url('catalogo/' . esc($rubro['slug']) . '/' . esc($cat['slug']));
                ?>
                <a href="<?= $catUrl ?>"
                   class="group relative rounded-2xl <?= $isFirst ? 'md:rounded-[20px]' : '' ?> overflow-hidden block no-underline cursor-pointer <?= $isFirst ? 'col-span-2 row-span-1 md:col-span-1 md:row-span-2' : '' ?>"
                   aria-label="Ver <?= esc($cat['nombre']) ?>">

                    <!-- Imagen de fondo -->
                    <div class="absolute inset-0 bg-cover transition-transform duration-[650ms] ease-[cubic-bezier(.4,0,.2,1)] will-change-transform group-hover:scale-[1.07]"
                         style="background-image:url('<?= $bgImg ?>');
                                background-position:<?= $bgPos ?>;"></div>

                    <!-- Tinte diferenciador -->
                    <div class="absolute inset-0 transition-opacity duration-300 group-hover:opacity-60" style="background:<?= $tint ?>;"></div>

                    <!-- Overlay de legibilidad -->
                    <div class="absolute inset-0 transition-[background] duration-[350ms]
                                bg-[linear-gradient(to_top,rgba(0,0,0,0.88)_0%,rgba(0,0,0,0.45)_38%,rgba(0,0,0,0.1)_70%,transparent_100%)]
                                group-hover:bg-[linear-gradient(to_top,rgba(0,0,0,0.94)_0%,rgba(0,0,0,0.58)_38%,rgba(0,0,0,0.2)_70%,rgba(0,0,0,0.05)_100%)]"></div>

                    <!-- Contenido -->
                    <div class="<?= $isFirst ? $_catContentFeatured : $_catContentBase ?>">
                        <span class="<?= $isFirst ? $_catIconFeatured : $_catIconBase ?>">
                            <i class="<?= esc($cat['icono']) ?>"></i>
                        </span>
                        <div class="<?= $isFirst ? $_catNameFeatured : $_catNameBase ?>"><?= esc($cat['nombre']) ?></div>
                        <span class="<?= $isFirst ? $_catArrowFeatured : $_catArrowBase ?>">
                            Ver productos <i class="fas fa-arrow-right text-[0.6rem]"></i>
                        </span>
                    </div>

                </a>
                <?php endforeach; ?>
            </div>

            <?php else: ?>
            <div class="text-center py-16 font-inter text-[#C4C9D4] text-[0.9rem]">
                Categorías de <?= esc($rubro['nombre']) ?> próximamente…
            </div>
            <?php endif; ?>

        </div>
        <?php endforeach; ?>

        <?php else: ?>
        <div class="text-center py-12 font-inter text-gray-400 text-[0.9rem]">
            El catálogo estará disponible próximamente.
        </div>
        <?php endif; ?>

        <!-- ── CTA general ── -->
        <div class="text-center mt-10 cats-reveal opacity-0 translate-y-[22px] transition-[opacity,transform] duration-[520ms] ease-in-out delay-[190ms] [&.visible]:opacity-100 [&.visible]:translate-y-0">
            <a href="<?= base_url('catalogo') ?>" class="inline-flex items-center gap-[9px] bg-rojo text-white font-inter text-[0.92rem] font-bold px-8 py-[0.85rem] rounded-full no-underline shadow-[0_4px_18px_rgba(255,0,51,0.25)] transition-[background,box-shadow,transform] duration-200 hover:bg-rojo-dark hover:shadow-[0_7px_24px_rgba(255,0,51,0.36)] hover:-translate-y-0.5 hover:text-white">
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
