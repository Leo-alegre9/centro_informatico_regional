<?php
$imgFrenteRuta = FCPATH . 'assets/img/imagen_frente_cir.jpeg';
$imgFrenteUrl  = base_url('assets/img/imagen_frente_cir.jpeg');
$imgFrenteOk   = file_exists($imgFrenteRuta) && filesize($imgFrenteRuta) > 0;
?>

<!-- ═══════════════════════════════════════════════
     HISTORIA — Texto + Imagen
═══════════════════════════════════════════════ -->
<section class="bg-white pt-[5.5rem] pb-[4.5rem]">
    <div class="container">
        <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-2">

            <!-- Texto -->
            <div>
                <div class="mb-4 inline-flex items-center gap-2 text-[0.72rem] font-bold tracking-[3px] text-rojo uppercase">
                    <i class="fas fa-building"></i> Nuestra Historia
                </div>
                <h2 class="mb-6 text-[clamp(1.7rem,2.8vw,2.4rem)] font-black leading-[1.2] text-dark-2">
                    Una empresa formoseña<br>con <em class="text-rojo not-italic">vocación de servicio</em>
                </h2>
                <div class="mb-7 h-1 w-12 rounded-full bg-rojo"></div>

                <p class="mb-[1.1rem] text-[0.97rem] leading-[1.9] text-gris">
                    Somos una empresa formoseña fundada en el año <strong>1997</strong>, que surge como un emprendimiento dedicado a brindar servicios de capacitación en informática. A lo largo de los años logramos un crecimiento y evolución constante para adaptarnos a las demandas cambiantes del mercado.
                </p>
                <p class="mb-0 text-[0.97rem] leading-[1.9] text-gris">
                    Hoy contamos con una <strong>presencia regional sólida en la provincia de Formosa y parte del interior del Chaco</strong>. Trabajamos en estrecha colaboración con <strong>más de 50 marcas de renombre internacional</strong>, con un portafolio que abarca tecnología, muebles, electrodomésticos y equipamiento comercial.
                </p>

                <div class="mt-8 flex items-start gap-4 rounded-l-none rounded-r-[14px] border-l-4 border-rojo bg-[#F7F8FA] px-6 py-[1.3rem]">
                    <i class="fas fa-quote-left mt-[3px] flex-shrink-0 text-base text-rojo"></i>
                    <p class="m-0 text-[0.9rem] leading-[1.75] font-medium text-dark-2 italic">Con amplia trayectoria en el rubro, ágiles y eficaces, asumimos la gran responsabilidad de cumplir fielmente con cada uno de nuestros clientes, porque nos eligieron y nos otorgaron esa posibilidad.</p>
                </div>
            </div>

            <!-- Imagen del local -->
            <div>
                <div class="relative aspect-[4/3] overflow-hidden rounded-[24px] shadow-[0_28px_70px_rgba(0,0,0,0.14)]">
                    <?php if ($imgFrenteOk): ?>
                        <img src="<?= $imgFrenteUrl ?>"
                             alt="Centro Informático Regional — Local en Formosa"
                             class="block h-full w-full object-cover object-center">
                    <?php else: ?>
                        <div class="flex h-full w-full flex-col items-center justify-center gap-4 bg-dark-2 text-white/25">
                            <i class="fas fa-store text-[3rem]"></i>
                            <span class="text-[0.82rem] tracking-[1.5px] uppercase">Centro Informático Regional</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════
     PILARES — 4 tarjetas
═══════════════════════════════════════════════ -->
<section class="border-t border-b border-[#EEF0F3] bg-[#F7F8FA] py-16">
    <div class="container">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

            <div class="group h-full rounded-[20px] border-[1.5px] border-[#EEF0F3] bg-white p-[2rem_1.75rem] shadow-[0_4px_20px_rgba(0,0,0,0.05)] transition-all duration-[250ms] ease-out hover:-translate-y-[5px] hover:border-rojo/20 hover:shadow-[0_16px_44px_rgba(0,0,0,0.1)]">
                <div class="mb-[1.15rem] flex h-[52px] w-[52px] items-center justify-center rounded-[14px] border-[1.5px] border-rojo/[0.15] bg-rojo/[0.07] text-xl text-rojo transition-colors duration-[250ms] ease-out group-hover:border-rojo group-hover:bg-rojo group-hover:text-white"><i class="fas fa-seedling"></i></div>
                <div class="mb-[0.55rem] text-base font-extrabold text-dark-2">Origen emprendedor</div>
                <p class="m-0 text-[0.85rem] leading-[1.75] text-gris">Nacimos en 1997 como un servicio de capacitación en informática y evolucionamos hasta convertirnos en una empresa multirubro de alcance regional.</p>
            </div>

            <div class="group h-full rounded-[20px] border-[1.5px] border-[#EEF0F3] bg-white p-[2rem_1.75rem] shadow-[0_4px_20px_rgba(0,0,0,0.05)] transition-all duration-[250ms] ease-out hover:-translate-y-[5px] hover:border-rojo/20 hover:shadow-[0_16px_44px_rgba(0,0,0,0.1)]">
                <div class="mb-[1.15rem] flex h-[52px] w-[52px] items-center justify-center rounded-[14px] border-[1.5px] border-rojo/[0.15] bg-rojo/[0.07] text-xl text-rojo transition-colors duration-[250ms] ease-out group-hover:border-rojo group-hover:bg-rojo group-hover:text-white"><i class="fas fa-chart-line"></i></div>
                <div class="mb-[0.55rem] text-base font-extrabold text-dark-2">Crecimiento constante</div>
                <p class="m-0 text-[0.85rem] leading-[1.75] text-gris">Más de 28 años de evolución continua, adaptándonos a cada cambio del mercado y ampliando nuestra oferta para cubrir todas las necesidades de nuestra región.</p>
            </div>

            <div class="group h-full rounded-[20px] border-[1.5px] border-[#EEF0F3] bg-white p-[2rem_1.75rem] shadow-[0_4px_20px_rgba(0,0,0,0.05)] transition-all duration-[250ms] ease-out hover:-translate-y-[5px] hover:border-rojo/20 hover:shadow-[0_16px_44px_rgba(0,0,0,0.1)]">
                <div class="mb-[1.15rem] flex h-[52px] w-[52px] items-center justify-center rounded-[14px] border-[1.5px] border-rojo/[0.15] bg-rojo/[0.07] text-xl text-rojo transition-colors duration-[250ms] ease-out group-hover:border-rojo group-hover:bg-rojo group-hover:text-white"><i class="fas fa-handshake"></i></div>
                <div class="mb-[0.55rem] text-base font-extrabold text-dark-2">Relaciones duraderas</div>
                <p class="m-0 text-[0.85rem] leading-[1.75] text-gris">Construimos vínculos sólidos con clientes y marcas basados en la confianza, el cumplimiento y el acompañamiento permanente en cada etapa.</p>
            </div>

            <div class="group h-full rounded-[20px] border-[1.5px] border-[#EEF0F3] bg-white p-[2rem_1.75rem] shadow-[0_4px_20px_rgba(0,0,0,0.05)] transition-all duration-[250ms] ease-out hover:-translate-y-[5px] hover:border-rojo/20 hover:shadow-[0_16px_44px_rgba(0,0,0,0.1)]">
                <div class="mb-[1.15rem] flex h-[52px] w-[52px] items-center justify-center rounded-[14px] border-[1.5px] border-rojo/[0.15] bg-rojo/[0.07] text-xl text-rojo transition-colors duration-[250ms] ease-out group-hover:border-rojo group-hover:bg-rojo group-hover:text-white"><i class="fas fa-boxes-stacked"></i></div>
                <div class="mb-[0.55rem] text-base font-extrabold text-dark-2">Portafolio diversificado</div>
                <p class="m-0 text-[0.85rem] leading-[1.75] text-gris">Tecnología, muebles, electrodomésticos y equipamiento comercial: más de 50 marcas internacionales bajo un mismo techo.</p>
            </div>

        </div>
    </div>
</section>
