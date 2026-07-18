<style>
    /* ══════════════════════════════════════════════════════════
       MARCAS — Carrusel infinito: @keyframes no registrado en
       tailwind_config.php, se mantiene como excepción scoped.
    ══════════════════════════════════════════════════════════ */
    @keyframes marcas-slide {
        from { transform: translateX(0); }
        to   { transform: translateX(-50%); }
    }
    .marcas-track { animation: marcas-slide 40s linear infinite; }
    .marcas-track:hover { animation-play-state: paused; }
</style>

<?php
$marcasMeta = [
    'HP'        => ['slug' => 'hp',       'cat' => 'Informática', 'img' => 'hp.png'],
    'Lenovo'    => ['slug' => 'lenovo',   'cat' => 'Informática', 'img' => 'LogoLenovo.png'],
    'Samsung'   => ['slug' => 'samsung',  'cat' => 'Electrónica', 'img' => 'samsung.png'],
    'LG'        => ['slug' => 'lg',       'cat' => 'Electrónica', 'img' => 'LG.png'],
    'Epson'     => ['slug' => 'epson',    'cat' => 'Impresoras', 'img' => 'Epson.png'],
    'Logitech'  => ['slug' => 'logitech', 'cat' => 'Periféricos', 'img' => 'logitech.png'],
    'Intel'     => ['slug' => 'intel',    'cat' => 'Procesadores', 'img' => 'intel.png'],
    'AMD'       => ['slug' => 'amd',      'cat' => 'Procesadores', 'img' => 'amd.png'],
    'BenQ'      => ['slug' => 'benq',     'cat' => 'Monitores', 'img' => 'benq.png'],
    'TP-Link'   => ['slug' => 'tplink',   'cat' => 'Redes', 'img' => 'tplink.png'],
    'Hikvision' => ['slug' => 'hikvision','cat' => 'Seguridad', 'img' => 'hikvision.png'],
    'ADATA'     => ['slug' => 'adata',    'cat' => 'Almacenamiento', 'img' => 'adata.png'],
    'Inelro'    => ['slug' => 'inelro',   'cat' => 'Electrónica',   'img' => 'LogoInelro.png'],
];

/* Marcas cuyo logo se muestra más grande (isotipos con más "aire") */
$_marcasGrandes = ['samsung', 'logitech', 'amd'];

/* Render de una tarjeta de marca (se repite dos veces para el loop infinito) */
$_renderMarcaCard = function ($nombre, $meta) use ($_marcasGrandes) {
    $logoSizeClass = in_array($meta['slug'], $_marcasGrandes, true)
        ? 'max-h-14 max-w-[140px]'
        : 'max-h-[38px] max-w-[110px]';
    ?>
    <div class="group bg-white border-[1.5px] border-[#EEF0F3] rounded-[18px] pt-[1.4rem] px-5 pb-[1.2rem] sm:pt-[1.8rem] sm:px-7 sm:pb-6 flex flex-col items-center justify-center gap-[0.55rem] text-center shrink-0 min-w-[138px] min-h-[108px] sm:min-w-[158px] sm:min-h-[120px] relative overflow-hidden cursor-default select-none
                transition-[transform,box-shadow,border-color] duration-[250ms] ease-[cubic-bezier(.4,0,.2,1)]
                hover:-translate-y-[5px] hover:shadow-[0_18px_44px_rgba(0,0,0,0.08),0_4px_12px_rgba(0,0,0,0.04)] hover:border-rojo/15
                after:content-[''] after:absolute after:bottom-0 after:left-1/2 after:-translate-x-1/2 after:w-0 after:h-[2.5px] after:bg-rojo after:rounded-t-[2px]
                after:transition-[width] after:duration-[280ms] after:ease-[cubic-bezier(.4,0,.2,1)] hover:after:w-[55%]">
        <img src="<?= base_url('assets/img/marcas/' . esc($meta['img'] ?? ($meta['slug'] . '.svg'))) ?>"
             alt="Logo <?= esc($nombre) ?>"
             class="<?= $logoSizeClass ?> w-auto h-auto object-contain block grayscale contrast-75 opacity-50 transition-[filter,opacity] duration-300 ease-in-out group-hover:grayscale-0 group-hover:contrast-100 group-hover:opacity-100"
             data-slug="<?= esc($meta['slug']) ?>"
             loading="lazy"
             onerror="this.style.display='none';"
             onload="this.nextElementSibling.style.display='none';this.nextElementSibling.nextElementSibling.style.display='none';">
        <div class="font-inter text-base font-extrabold text-gray-700 tracking-[-0.015em] leading-none transition-colors duration-200 group-hover:text-slate-900"><?= esc($nombre) ?></div>
        <div class="font-inter text-[0.62rem] font-medium text-[#C4C9D4] tracking-[0.05em] uppercase transition-colors duration-200 group-hover:text-gray-400"><?= esc($meta['cat']) ?></div>
    </div>
    <?php
};
?>

<!-- ═══════════════════════════════════════════════════════════
     SECCIÓN: NUESTRAS MARCAS
═══════════════════════════════════════════════════════════ -->
<section class="bg-gray-50 pt-[3rem] pb-14 sm:pt-20 sm:pb-[5.5rem] relative border-t border-[#EEF0F3]" id="marcas" aria-label="Marcas con las que trabajamos">
    <div class="container">
        <div class="text-center mb-14 marcas-reveal opacity-0 translate-y-[22px] transition-[opacity,transform] duration-500 ease-in-out [&.visible]:opacity-100 [&.visible]:translate-y-0">
            <p class="inline-flex items-center gap-[9px] font-inter text-[0.67rem] font-bold tracking-[0.18em] uppercase text-gray-400 mb-[0.85rem]
                      before:content-[''] before:inline-block before:w-[18px] before:h-0.5 before:bg-rojo before:rounded-full before:shrink-0
                      after:content-[''] after:inline-block after:w-[18px] after:h-0.5 after:bg-rojo after:rounded-full after:shrink-0">Respaldo comercial</p>
            <h2 class="font-inter text-[clamp(1.8rem,3vw,2.5rem)] font-extrabold text-slate-900 tracking-[-0.025em] leading-[1.18] mb-0">
                Trabajamos con las <span class="text-rojo">mejores marcas</span>
            </h2>
        </div>
    </div>

    <!-- Carrusel fuera del container para ocupar ancho completo -->
    <div class="relative overflow-hidden
                before:content-[''] before:absolute before:top-0 before:bottom-0 before:left-0 before:z-[2] before:pointer-events-none before:w-10 sm:before:w-[60px] lg:before:w-[120px]
                before:bg-[linear-gradient(to_right,#F9FAFB_0%,transparent_100%)]
                after:content-[''] after:absolute after:top-0 after:bottom-0 after:right-0 after:z-[2] after:pointer-events-none after:w-10 sm:after:w-[60px] lg:after:w-[120px]
                after:bg-[linear-gradient(to_left,#F9FAFB_0%,transparent_100%)]" aria-hidden="true">
        <div class="marcas-track flex gap-[14px] w-max pt-3 pb-4 will-change-transform" id="marcasTrack">
            <?php /* Primera pasada */ foreach ($marcasMeta as $nombre => $meta): $_renderMarcaCard($nombre, $meta); endforeach; ?>
            <?php /* Segunda pasada — idéntica, para el loop sin corte */ foreach ($marcasMeta as $nombre => $meta): $_renderMarcaCard($nombre, $meta); endforeach; ?>
        </div>
    </div>

</section>

<script>
(function () {
    var els = document.querySelectorAll('.marcas-reveal');
    if (!els.length) return;
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.08 });
    els.forEach(function (el) { io.observe(el); });
})();
</script>
