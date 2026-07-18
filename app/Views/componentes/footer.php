<!-- ═══════════════════════════════════════════════════════════
     FOOTER — Minimal Premium 2026
     Inspiración: Apple · Shopify · Stripe
═══════════════════════════════════════════════════════════ -->
<footer class="bg-dark border-t border-white/[0.07] pt-14 sm:pt-20 font-inter" role="contentinfo">
    <div class="container">
        <div class="flex flex-col items-center text-center">

            <!-- Logo + nombre -->
            <a href="<?= base_url('/') ?>" class="flex items-center gap-2.5 no-underline mb-5 transition-opacity duration-200 hover:opacity-80" aria-label="Inicio">
                <img src="<?= base_url('assets/img/logo_sinfondo.png') ?>"
                     alt="Centro Informático Regional"
                     class="h-[38px] sm:h-11 w-auto object-contain">
                <div class="flex flex-col items-start leading-[1.1] gap-px">
                    <span class="text-[0.92rem] font-extrabold text-white tracking-[0.03em] uppercase">Centro Informático</span>
                    <span class="text-[0.57rem] font-bold text-rojo tracking-[0.28em] uppercase">Regional</span>
                </div>
            </a>

            <!-- Descripción -->
            <p class="text-[0.88rem] sm:text-[0.92rem] text-white/45 leading-[1.75] max-w-[420px] mb-9">
                Soluciones en informática, muebles, electrodomésticos y equipamiento
                comercial para hogares, oficinas y empresas.
            </p>

            <!-- Redes sociales -->
            <div class="flex items-center gap-2.5 mb-14 sm:mb-20" aria-label="Redes sociales">
                <a href="https://www.instagram.com/centro_informatico_regional"
                   target="_blank" rel="noopener noreferrer"
                   class="w-[42px] h-[42px] rounded-full bg-white/[0.07] border-[1.5px] border-white/10 flex items-center justify-center text-white/55 text-[0.95rem] no-underline transition-all duration-200 hover:-translate-y-[3px] hover:text-white hover:bg-[rgba(225,48,108,0.15)] hover:border-[rgba(225,48,108,0.4)]"
                   aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.facebook.com/profile.php?id=61578451747153"
                   target="_blank" rel="noopener noreferrer"
                   class="w-[42px] h-[42px] rounded-full bg-white/[0.07] border-[1.5px] border-white/10 flex items-center justify-center text-white/55 text-[0.95rem] no-underline transition-all duration-200 hover:-translate-y-[3px] hover:text-white hover:bg-[rgba(24,119,242,0.15)] hover:border-[rgba(24,119,242,0.4)]"
                   aria-label="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://wa.me/5493704616482"
                   target="_blank" rel="noopener noreferrer"
                   class="w-[42px] h-[42px] rounded-full bg-white/[0.07] border-[1.5px] border-white/10 flex items-center justify-center text-white/55 text-[0.95rem] no-underline transition-all duration-200 hover:-translate-y-[3px] hover:text-white hover:bg-[rgba(37,211,102,0.15)] hover:border-[rgba(37,211,102,0.4)]"
                   aria-label="WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>

        </div>
    </div>

    <!-- Copyright + enlaces legales -->
    <div class="border-t border-white/[0.07] py-[1.4rem]">
        <div class="container">
            <div class="flex flex-col items-center gap-3 text-center sm:flex-row sm:justify-between sm:gap-4">
                <p class="font-inter text-[0.76rem] text-white/[0.28] m-0 order-2 sm:order-1">
                    &copy; <?= date('Y') ?> Centro Informático Regional. Todos los derechos reservados.
                </p>
                <nav class="flex items-center gap-4 order-1 sm:order-2" aria-label="Enlaces legales">
                    <a href="<?= base_url('politica-privacidad') ?>"
                       class="font-inter text-[0.76rem] text-white/45 no-underline transition-colors duration-200 hover:text-white">
                        Política de privacidad
                    </a>
                    <span class="text-white/20 text-[0.7rem]">·</span>
                    <a href="<?= base_url('condiciones-servicio') ?>"
                       class="font-inter text-[0.76rem] text-white/45 no-underline transition-colors duration-200 hover:text-white">
                        Condiciones del servicio
                    </a>
                </nav>
            </div>
        </div>
    </div>

</footer>
