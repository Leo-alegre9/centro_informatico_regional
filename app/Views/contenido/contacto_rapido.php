<style>
    /* Únicamente el keyframe del punto pulsante — no expresable como utilidad Tailwind */
    @keyframes ctaPulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: 0.6; transform: scale(1.3); }
    }
</style>

<!-- ═══════════════════════════════════════════════════════════
     CONTACTO RÁPIDO
═══════════════════════════════════════════════════════════ -->
<section class="relative overflow-hidden border-t border-[#EEF0F3] bg-[#F9FAFB] py-12 before:pointer-events-none before:absolute before:-top-40 before:-right-40 before:z-0 before:h-[460px] before:w-[460px] before:rounded-full before:bg-[radial-gradient(circle,rgba(255,0,51,0.055)_0%,transparent_65%)] before:content-[''] sm:py-20" id="contacto" aria-label="Contacto rápido">
    <div class="container relative z-[1]">

        <div class="cta-reveal relative overflow-hidden rounded-[20px] border-[1.5px] border-[#EEF0F3] bg-white p-[2rem_1.5rem] opacity-0 translate-y-5 shadow-[0_8px_32px_rgba(0,0,0,0.05),0_2px_8px_rgba(0,0,0,0.03)] transition-all duration-500 ease-out before:absolute before:inset-y-0 before:left-0 before:w-1 before:rounded-tl-[20px] before:rounded-bl-[20px] before:bg-rojo before:content-[''] sm:rounded-[28px] sm:p-10 sm:before:rounded-tl-[28px] sm:before:rounded-bl-[28px] lg:p-[3.5rem_3rem]">
            <div class="grid grid-cols-1 items-center gap-4 lg:grid-cols-12">

                <!-- ── Texto ── -->
                <div class="lg:col-span-8">
                    <p class="mb-[0.85rem] inline-flex items-center gap-[9px] font-inter text-[0.67rem] font-bold tracking-[0.18em] text-[#9CA3AF] uppercase before:inline-block before:h-[2px] before:w-[18px] before:flex-shrink-0 before:rounded-sm before:bg-rojo before:content-['']">Contacto rápido</p>
                    <h2 class="mb-3 font-inter text-[clamp(1.75rem,3vw,2.4rem)] leading-[1.18] font-extrabold tracking-[-0.025em] text-[#0F172A]">
                        ¿Necesitás <span class="text-rojo">ayuda?</span>
                    </h2>
                    <p class="mb-0 max-w-[500px] font-inter text-[0.97rem] leading-[1.75] text-[#6B7280]">
                        Nuestro equipo de expertos está listo para atenderte.
                        Contáctanos ahora y resolvemos tus dudas sin compromiso.
                    </p>
                </div>

                <!-- ── Acciones ── -->
                <div class="lg:col-span-4">
                    <div class="flex flex-col items-stretch gap-3 sm:flex-row sm:flex-wrap sm:items-start md:flex-col md:items-start">
                        <a href="<?= base_url('contacto') ?>" class="inline-flex items-center justify-center gap-2 rounded-full bg-rojo px-[1.65rem] py-[0.78rem] font-inter text-[0.88rem] font-bold whitespace-nowrap text-white shadow-[0_4px_18px_rgba(255,0,51,0.28)] transition-all duration-200 hover:-translate-y-[2px] hover:bg-rojo-dark hover:text-white hover:shadow-[0_7px_24px_rgba(255,0,51,0.38)] sm:justify-start">
                            <i class="fas fa-envelope"></i> Enviar mensaje
                        </a>
                        <a href="https://wa.me/5493704616482"
                           target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center justify-center gap-2 rounded-full border-[1.5px] border-[#E5E7EB] bg-white px-[1.65rem] py-[0.78rem] font-inter text-[0.88rem] font-semibold whitespace-nowrap text-[#374151] transition-all duration-200 hover:-translate-y-[2px] hover:border-[#25D366] hover:bg-[#F0FDF4] hover:text-[#1a9e4e] sm:justify-start">
                            <i class="fab fa-whatsapp text-[#25D366]"></i> WhatsApp
                        </a>
                        <div class="mt-2 flex items-center gap-[6px]">
                            <div class="h-[7px] w-[7px] flex-shrink-0 rounded-full bg-[#22C55E] [animation:ctaPulse_2s_ease-in-out_infinite]"></div>
                            <span class="font-inter text-[0.72rem] font-medium text-[#9CA3AF]">Respuesta en menos de 24 horas</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<script>
(function () {
    var els = document.querySelectorAll('.cta-reveal');
    if (!els.length) return;
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) {
                e.target.classList.remove('opacity-0', 'translate-y-5');
                e.target.classList.add('opacity-100', 'translate-y-0');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });
    els.forEach(function (el) { io.observe(el); });
})();
</script>
