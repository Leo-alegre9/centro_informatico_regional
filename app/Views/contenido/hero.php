<style>
    /* ══════════════════════════════════════════════════════════
       HERO — Keyframes no registrados en tailwind_config.php
    ══════════════════════════════════════════════════════════ */
    @keyframes heroFadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes heroFadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }
</style>

<!-- ═══════════════════════════════════════════════════════════
     HERO SECTION
═══════════════════════════════════════════════════════════ -->
<section class="min-h-[90vh] bg-white flex items-center relative overflow-hidden border-b border-[#EEF0F3]
                 before:content-[''] before:absolute before:inset-0
                 before:bg-[radial-gradient(circle,#E5E7EB_1px,transparent_1px)] before:bg-[length:28px_28px]
                 before:opacity-45 before:pointer-events-none
                 after:content-[''] after:absolute after:inset-0 after:pointer-events-none
                 after:bg-[radial-gradient(ellipse_65%_80%_at_30%_50%,rgba(255,255,255,0.97)_0%,rgba(255,255,255,0.6)_55%,transparent_75%),radial-gradient(ellipse_50%_70%_at_80%_50%,rgba(255,255,255,0.85)_0%,transparent_70%)]"
         aria-label="Presentación de Centro Informático Regional">
    <div class="relative z-[1] w-full pt-[3rem] pb-[2.5rem] md:pt-[3.5rem] md:pb-[3rem] lg:pt-[5rem] lg:pb-[4.5rem]">
        <div class="container">
            <div class="flex flex-col lg:flex-row lg:items-center gap-12">

                <!-- ── LEFT: Contenido principal ── -->
                <div class="lg:w-1/2">

                    <p class="flex items-center gap-[9px] font-inter text-[0.68rem] font-bold tracking-[0.18em] uppercase text-gray-400 mb-[1.3rem] animate-[heroFadeUp_0.55s_ease_both]">
                        <span class="inline-block w-[22px] h-0.5 bg-rojo rounded-full shrink-0"></span>
                        Centro Informático Regional
                    </p>

                    <h1 class="font-inter text-[1.85rem] sm:text-[clamp(2rem,3.8vw,3.1rem)] font-extrabold leading-[1.15] text-slate-900 tracking-[-0.02em] sm:tracking-[-0.025em] mb-[1.3rem] animate-[heroFadeUp_0.55s_ease_0.1s_both]">
                        Tecnología, hogar y<br>
                        equipamiento para<br>
                        <span class="text-rojo">cada necesidad.</span>
                    </h1>

                    <p class="font-inter text-base text-gray-500 leading-[1.85] max-w-full lg:max-w-[480px] mb-8 animate-[heroFadeUp_0.55s_ease_0.18s_both]">
                        Encontrá informática, muebles, electrodomésticos y soluciones
                        comerciales en un solo lugar. Calidad y asesoramiento real.
                    </p>

                    <div class="flex flex-wrap gap-[0.7rem] animate-[heroFadeUp_0.55s_ease_0.26s_both]">
                        <a href="<?= base_url('catalogo') ?>"
                           class="inline-flex items-center gap-2 bg-rojo text-white font-inter text-[0.88rem] font-bold px-[1.65rem] py-[0.78rem] rounded-full no-underline shadow-[0_4px_18px_rgba(255,0,51,0.28)] transition-[background,box-shadow,transform] duration-200 hover:bg-rojo-dark hover:shadow-[0_7px_24px_rgba(255,0,51,0.38)] hover:-translate-y-0.5 hover:text-white">
                            <i class="fas fa-th-large"></i> Ver Catálogo
                        </a>
                        <a href="https://wa.me/5493704616482?text=Hola%2C%20quiero%20consultar%20sobre%20sus%20productos"
                           target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 bg-white text-gray-700 font-inter text-[0.88rem] font-semibold px-[1.65rem] py-[0.78rem] rounded-full no-underline border-[1.5px] border-gray-200 transition-colors duration-200 hover:border-[#25D366] hover:text-[#1a9e4e] hover:bg-green-50 hover:-translate-y-0.5">
                            <i class="fab fa-whatsapp text-[#25D366]"></i> Consultar por WhatsApp
                        </a>
                    </div>

                </div>

                <!-- ── RIGHT: Logo ── -->
                <div class="lg:w-1/2 flex items-center justify-center relative mt-8 md:mt-0
                            animate-[heroFadeIn_0.7s_ease_0.3s_both]
                            before:content-[''] before:absolute before:inset-0
                            before:bg-[radial-gradient(ellipse_70%_55%_at_50%_50%,rgba(255,0,51,0.08)_0%,rgba(255,0,51,0.03)_55%,transparent_75%)]
                            before:blur-[30px] before:rounded-full before:pointer-events-none">
                    <img src="<?= base_url('assets/img/CIR_sinfondo.png') ?>"
                         alt="Centro Informático Regional"
                         class="relative z-[1] w-full max-w-[280px] md:max-w-[380px] lg:max-w-[520px] h-auto block object-contain">
                </div>

            </div>
        </div>
    </div>
</section>
