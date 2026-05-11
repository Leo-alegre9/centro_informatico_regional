<style>
    .form-section { background: var(--fondo); }
    .form-card {
        background: #fff;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 6px 30px rgba(0,0,0,0.07);
    }
    .form-card h2 { font-size: 1.55rem; font-weight: 800; color: var(--dark-2); margin-bottom: 0.3rem; }
    .form-card .subtitulo { color: var(--gris); font-size: 0.93rem; margin-bottom: 2rem; }
    .form-label-cir {
        font-weight: 600;
        font-size: 0.87rem;
        color: var(--dark-2);
        margin-bottom: 0.4rem;
        display: block;
    }
    .form-control-cir,
    .form-select-cir {
        width: 100%;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        color: var(--dark-2);
        background: #fafafa;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-family: inherit;
    }
    .form-control-cir:focus,
    .form-select-cir:focus {
        border-color: var(--rojo);
        box-shadow: 0 0 0 3px rgba(255,0,51,0.1);
        outline: none;
        background: #fff;
    }
    .form-control-cir.is-invalid,
    .form-select-cir.is-invalid { border-color: #ef4444; }
    textarea.form-control-cir { resize: vertical; min-height: 130px; }
    .btn-enviar {
        background: var(--rojo);
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 0.85rem 2.4rem;
        font-weight: 700;
        font-size: 0.97rem;
        cursor: pointer;
        transition: background 0.25s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-family: inherit;
    }
    .btn-enviar:hover { background: var(--rojo-dark); }

    /* Info lateral */
    .info-aside-card {
        background: var(--dark-2);
        border-radius: 20px;
        padding: 2rem;
        height: 100%;
    }
    .info-aside-card h3 { color: #fff; font-weight: 800; font-size: 1.2rem; margin-bottom: 1.6rem; }
    .info-aside-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding-bottom: 1.3rem;
        margin-bottom: 1.3rem;
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .info-aside-item:last-of-type { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
    .info-aside-icon {
        width: 44px; height: 44px;
        background: rgba(255,0,51,0.12);
        border: 1px solid rgba(255,0,51,0.25);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--rojo);
        font-size: 1rem;
        flex-shrink: 0;
    }
    .info-aside-label {
        color: rgba(255,255,255,0.45);
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        display: block;
        margin-bottom: 4px;
    }
    .info-aside-value {
        color: #fff;
        font-size: 0.93rem;
        font-weight: 500;
        line-height: 1.55;
        margin: 0;
    }
    .btn-wa {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: #25D366;
        color: #fff;
        border-radius: 50px;
        padding: 0.82rem 1.5rem;
        font-weight: 700;
        text-decoration: none;
        margin-top: 1.8rem;
        transition: background 0.25s;
        font-size: 0.95rem;
    }
    .btn-wa:hover { background: #1ebe5a; color: #fff; }

    .rrss-links { display: flex; gap: 14px; margin-top: 1.5rem; }
    .rrss-link {
        width: 40px; height: 40px;
        border-radius: 50%;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,0.65);
        font-size: 1rem;
        text-decoration: none;
        transition: background 0.2s, color 0.2s, border-color 0.2s;
    }
    .rrss-link:hover { background: var(--rojo); color: #fff; border-color: var(--rojo); }
</style>

<!-- ═══════════════════════════════════════════════
     FORMULARIO DE CONTACTO
═══════════════════════════════════════════════ -->
<section class="form-section py-5">
    <div class="container">
        <div class="row g-4">

            <!-- Formulario -->
            <div class="col-lg-8">
                <div class="form-card">
                    <h2>Envianos tu consulta</h2>
                    <p class="subtitulo">Completá el formulario y te responderemos lo antes posible.</p>

                    <?php $errores = session()->getFlashdata('errors') ?? []; ?>

                    <form action="<?= base_url('contacto') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-cir" for="nombre">Nombre completo *</label>
                                <input type="text" id="nombre" name="nombre"
                                       class="form-control-cir <?= isset($errores['nombre']) ? 'is-invalid' : '' ?>"
                                       placeholder="Tu nombre completo"
                                       value="<?= esc(old('nombre')) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-cir" for="email">Correo electrónico *</label>
                                <input type="email" id="email" name="email"
                                       class="form-control-cir <?= isset($errores['email']) ? 'is-invalid' : '' ?>"
                                       placeholder="tu@email.com"
                                       value="<?= esc(old('email')) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-cir" for="telefono">Teléfono <span style="color:var(--gris); font-weight:400;">(opcional)</span></label>
                                <input type="tel" id="telefono" name="telefono"
                                       class="form-control-cir"
                                       placeholder="+54 370 000-0000"
                                       value="<?= esc(old('telefono')) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-cir" for="asunto">Asunto *</label>
                                <select id="asunto" name="asunto"
                                        class="form-select-cir <?= isset($errores['asunto']) ? 'is-invalid' : '' ?>">
                                    <option value="" disabled <?= !old('asunto') ? 'selected' : '' ?>>Seleccioná un motivo</option>
                                    <option value="servicio-tecnico"  <?= old('asunto') === 'servicio-tecnico'  ? 'selected' : '' ?>>Servicio Técnico</option>
                                    <option value="consulta-producto" <?= old('asunto') === 'consulta-producto' ? 'selected' : '' ?>>Consulta de Producto</option>
                                    <option value="presupuesto"       <?= old('asunto') === 'presupuesto'       ? 'selected' : '' ?>>Solicitar Presupuesto</option>
                                    <option value="otro"              <?= old('asunto') === 'otro'              ? 'selected' : '' ?>>Otro</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label-cir" for="mensaje">Mensaje *</label>
                                <textarea id="mensaje" name="mensaje"
                                          class="form-control-cir <?= isset($errores['mensaje']) ? 'is-invalid' : '' ?>"
                                          placeholder="Describí tu consulta o problema..."><?= esc(old('mensaje')) ?></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-enviar">
                                    <i class="fas fa-paper-plane"></i> Enviar mensaje
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info lateral -->
            <div class="col-lg-4">
                <div class="info-aside-card">
                    <h3>Información de contacto</h3>

                    <div class="info-aside-item">
                        <div class="info-aside-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <span class="info-aside-label">Dirección</span>
                            <p class="info-aside-value">Sarmiento 177<br>El Colorado, Formosa</p>
                        </div>
                    </div>

                    <div class="info-aside-item">
                        <div class="info-aside-icon"><i class="fas fa-phone"></i></div>
                        <div>
                            <span class="info-aside-label">Teléfono</span>
                            <p class="info-aside-value">(+54) 370 461-6482</p>
                        </div>
                    </div>

                    <div class="info-aside-item">
                        <div class="info-aside-icon"><i class="fas fa-clock"></i></div>
                        <div>
                            <span class="info-aside-label">Horario</span>
                            <p class="info-aside-value">
                                Lun–Vie: 8:00–12:00 hs<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;16:00–20:00 hs<br>
                                Sábados: 8:00–12:00 hs
                            </p>
                        </div>
                    </div>

                    <a href="https://wa.me/5493704616482" target="_blank" rel="noopener" class="btn-wa">
                        <i class="fab fa-whatsapp fa-lg"></i> Chatear por WhatsApp
                    </a>

                    <div class="rrss-links">
                        <a href="https://www.instagram.com/centro_informatico_regional" target="_blank" rel="noopener" class="rrss-link" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.facebook.com/profile.php?id=61578451747153" target="_blank" rel="noopener" class="rrss-link" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://wa.me/5493704616482" target="_blank" rel="noopener" class="rrss-link" title="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
