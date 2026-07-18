<!-- ═══════════════════════════════════════════════
     FORMULARIO DE CONTACTO
═══════════════════════════════════════════════ -->
<section class="bg-fondo py-12">
    <div class="container">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

            <!-- Formulario -->
            <div class="lg:col-span-8">
                <div class="rounded-[20px] bg-white p-10 shadow-[0_6px_30px_rgba(0,0,0,0.07)]">
                    <h2 class="mb-[0.3rem] text-[1.55rem] font-extrabold text-dark-2">Envianos tu consulta</h2>
                    <p class="mb-8 text-[0.93rem] text-gris">Completá el formulario y te responderemos lo antes posible.</p>

                    <?php $errores = session()->getFlashdata('errors') ?? []; ?>

                    <form action="<?= base_url('contacto') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label class="mb-[0.4rem] block text-[0.87rem] font-semibold text-dark-2" for="nombre">Nombre completo *</label>
                                <input type="text" id="nombre" name="nombre"
                                       class="w-full rounded-[10px] border-[1.5px] <?= isset($errores['nombre']) ? 'border-red-500' : 'border-gray-200' ?> bg-[#fafafa] px-4 py-3 font-sans text-[0.95rem] text-dark-2 transition-colors duration-200 focus:border-rojo focus:bg-white focus:ring-[3px] focus:ring-rojo/10 focus:outline-none"
                                       placeholder="Tu nombre completo"
                                       value="<?= esc(old('nombre')) ?>">
                            </div>
                            <div>
                                <label class="mb-[0.4rem] block text-[0.87rem] font-semibold text-dark-2" for="email">Correo electrónico *</label>
                                <input type="email" id="email" name="email"
                                       class="w-full rounded-[10px] border-[1.5px] <?= isset($errores['email']) ? 'border-red-500' : 'border-gray-200' ?> bg-[#fafafa] px-4 py-3 font-sans text-[0.95rem] text-dark-2 transition-colors duration-200 focus:border-rojo focus:bg-white focus:ring-[3px] focus:ring-rojo/10 focus:outline-none"
                                       placeholder="tu@email.com"
                                       value="<?= esc(old('email')) ?>">
                            </div>
                            <div>
                                <label class="mb-[0.4rem] block text-[0.87rem] font-semibold text-dark-2" for="telefono">Teléfono <span class="font-normal text-gris">(opcional)</span></label>
                                <input type="tel" id="telefono" name="telefono"
                                       class="w-full rounded-[10px] border-[1.5px] border-gray-200 bg-[#fafafa] px-4 py-3 font-sans text-[0.95rem] text-dark-2 transition-colors duration-200 focus:border-rojo focus:bg-white focus:ring-[3px] focus:ring-rojo/10 focus:outline-none"
                                       placeholder="+54 370 000-0000"
                                       value="<?= esc(old('telefono')) ?>">
                            </div>
                            <div>
                                <label class="mb-[0.4rem] block text-[0.87rem] font-semibold text-dark-2" for="asunto">Asunto *</label>
                                <select id="asunto" name="asunto"
                                        class="w-full rounded-[10px] border-[1.5px] <?= isset($errores['asunto']) ? 'border-red-500' : 'border-gray-200' ?> bg-[#fafafa] px-4 py-3 font-sans text-[0.95rem] text-dark-2 transition-colors duration-200 focus:border-rojo focus:bg-white focus:ring-[3px] focus:ring-rojo/10 focus:outline-none">
                                    <option value="" disabled <?= !old('asunto') ? 'selected' : '' ?>>Seleccioná un motivo</option>
                                    <option value="servicio-tecnico"  <?= old('asunto') === 'servicio-tecnico'  ? 'selected' : '' ?>>Servicio Técnico</option>
                                    <option value="consulta-producto" <?= old('asunto') === 'consulta-producto' ? 'selected' : '' ?>>Consulta de Producto</option>
                                    <option value="presupuesto"       <?= old('asunto') === 'presupuesto'       ? 'selected' : '' ?>>Solicitar Presupuesto</option>
                                    <option value="otro"              <?= old('asunto') === 'otro'              ? 'selected' : '' ?>>Otro</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="mb-[0.4rem] block text-[0.87rem] font-semibold text-dark-2" for="mensaje">Mensaje *</label>
                                <textarea id="mensaje" name="mensaje"
                                          class="min-h-[130px] w-full resize-y rounded-[10px] border-[1.5px] <?= isset($errores['mensaje']) ? 'border-red-500' : 'border-gray-200' ?> bg-[#fafafa] px-4 py-3 font-sans text-[0.95rem] text-dark-2 transition-colors duration-200 focus:border-rojo focus:bg-white focus:ring-[3px] focus:ring-rojo/10 focus:outline-none"
                                          placeholder="Describí tu consulta o problema..."><?= esc(old('mensaje')) ?></textarea>
                            </div>
                            <div class="md:col-span-2">
                                <button type="submit" class="inline-flex items-center gap-[10px] rounded-full border-none bg-rojo px-[2.4rem] py-[0.85rem] font-sans text-[0.97rem] font-bold text-white transition-colors duration-[250ms] hover:bg-rojo-dark">
                                    <i class="fas fa-paper-plane"></i> Enviar mensaje
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info lateral -->
            <div class="lg:col-span-4">
                <div class="h-full rounded-[20px] bg-dark-2 p-8">
                    <h3 class="mb-[1.6rem] text-xl font-extrabold text-white">Información de contacto</h3>

                    <div class="mb-[1.3rem] flex items-start gap-[14px] border-b border-white/[0.06] pb-[1.3rem]">
                        <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl border border-rojo/25 bg-rojo/[0.12] text-base text-rojo"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <span class="mb-1 block text-[0.72rem] tracking-[1.2px] text-white/45 uppercase">Dirección</span>
                            <p class="m-0 text-[0.93rem] leading-[1.55] font-medium text-white">Sarmiento 177<br>El Colorado, Formosa</p>
                        </div>
                    </div>

                    <div class="mb-[1.3rem] flex items-start gap-[14px] border-b border-white/[0.06] pb-[1.3rem]">
                        <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl border border-rojo/25 bg-rojo/[0.12] text-base text-rojo"><i class="fas fa-phone"></i></div>
                        <div>
                            <span class="mb-1 block text-[0.72rem] tracking-[1.2px] text-white/45 uppercase">Teléfono</span>
                            <p class="m-0 text-[0.93rem] leading-[1.55] font-medium text-white">(+54) 370 461-6482</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-[14px]">
                        <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl border border-rojo/25 bg-rojo/[0.12] text-base text-rojo"><i class="fas fa-clock"></i></div>
                        <div>
                            <span class="mb-1 block text-[0.72rem] tracking-[1.2px] text-white/45 uppercase">Horario</span>
                            <p class="m-0 text-[0.93rem] leading-[1.55] font-medium text-white">
                                Lun–Vie: 8:00–12:00 hs<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;16:00–20:00 hs<br>
                                Sábados: 8:00–12:00 hs
                            </p>
                        </div>
                    </div>

                    <a href="https://wa.me/5493704616482" target="_blank" rel="noopener" class="mt-[1.8rem] flex items-center justify-center gap-[10px] rounded-full bg-[#25D366] px-6 py-[0.82rem] text-[0.95rem] font-bold text-white no-underline transition-colors duration-[250ms] hover:bg-[#1ebe5a] hover:text-white">
                        <i class="fab fa-whatsapp fa-lg"></i> Chatear por WhatsApp
                    </a>

                    <div class="mt-6 flex gap-[14px]">
                        <a href="https://www.instagram.com/centro_informatico_regional" target="_blank" rel="noopener" class="flex h-10 w-10 items-center justify-center rounded-full border border-white/[0.12] bg-white/[0.07] text-base text-white/65 no-underline transition-colors duration-200 hover:border-rojo hover:bg-rojo hover:text-white" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.facebook.com/profile.php?id=61578451747153" target="_blank" rel="noopener" class="flex h-10 w-10 items-center justify-center rounded-full border border-white/[0.12] bg-white/[0.07] text-base text-white/65 no-underline transition-colors duration-200 hover:border-rojo hover:bg-rojo hover:text-white" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://wa.me/5493704616482" target="_blank" rel="noopener" class="flex h-10 w-10 items-center justify-center rounded-full border border-white/[0.12] bg-white/[0.07] text-base text-white/65 no-underline transition-colors duration-200 hover:border-rojo hover:bg-rojo hover:text-white" title="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
