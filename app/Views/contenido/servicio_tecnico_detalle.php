<style>
    /* ── Hero ── */
    .st-hero {
        background: var(--dark);
        padding: 3.5rem 0 2.8rem;
        text-align: center;
    }
    .st-hero .eyebrow {
        display: inline-block;
        background: rgba(255,0,51,0.12);
        color: var(--rojo);
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        padding: 0.35rem 1rem;
        border-radius: 50px;
        margin-bottom: 1.1rem;
    }
    .st-hero h1 {
        color: #fff;
        font-size: clamp(1.8rem, 4vw, 2.6rem);
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 0.9rem;
    }
    .st-hero h1 span { color: var(--rojo); }
    .st-hero p {
        color: rgba(255,255,255,0.65);
        font-size: 1.05rem;
        max-width: 540px;
        margin: 0 auto;
        line-height: 1.75;
    }

    /* ── Layout principal ── */
    .st-body { background: var(--fondo); padding: 3.5rem 0 4rem; }

    /* ── Técnicos ── */
    .tecnico-card {
        background: #fff;
        border-radius: 20px;
        border: 1.5px solid #e5e7eb;
        padding: 2rem 1.75rem;
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: transform 0.25s, box-shadow 0.25s;
    }
    .tecnico-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 40px rgba(0,0,0,0.1);
    }
    .tecnico-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: var(--dark-2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
        border: 3px solid var(--rojo);
        flex-shrink: 0;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(255,0,51,0.18);
    }
    .tecnico-avatar i { color: rgba(255,255,255,0.75); font-size: 2.2rem; }
    .tecnico-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top center;
        display: block;
        border-radius: 50%;
    }
    .tecnico-nombre {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--dark-2);
        margin-bottom: 0.2rem;
    }
    .tecnico-rol {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--rojo);
        text-transform: uppercase;
        letter-spacing: 0.7px;
        margin-bottom: 0.85rem;
    }
    .tecnico-desc {
        font-size: 0.9rem;
        color: var(--gris);
        line-height: 1.7;
        flex: 1;
        margin-bottom: 1.4rem;
    }
    .btn-tecnico-wsp {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #25D366;
        color: #fff;
        font-weight: 700;
        font-size: 0.9rem;
        padding: 0.75rem 1.4rem;
        border-radius: 50px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: background 0.2s;
        width: 100%;
    }
    .btn-tecnico-wsp:hover { background: #1ebe5a; color: #fff; }
    .btn-tecnico-wsp:disabled {
        background: #9CA3AF;
        cursor: not-allowed;
    }

    /* ── Formulario ── */
    .st-form-card {
        background: #fff;
        border-radius: 20px;
        border: 1.5px solid #e5e7eb;
        padding: 2rem 2rem 2.2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        position: sticky;
        top: 90px;
    }
    .st-form-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--dark-2);
        margin-bottom: 0.25rem;
    }
    .st-form-subtitle {
        font-size: 0.85rem;
        color: var(--gris);
        margin-bottom: 1.5rem;
        line-height: 1.5;
    }
    .st-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.3rem;
        display: block;
    }
    .st-input, .st-select, .st-textarea {
        width: 100%;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        padding: 0.65rem 1rem;
        font-size: 0.92rem;
        color: #111827;
        background: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-family: inherit;
    }
    .st-input:focus, .st-select:focus, .st-textarea:focus {
        border-color: var(--rojo);
        box-shadow: 0 0 0 3px rgba(255,0,51,0.1);
        outline: none;
    }
    .st-textarea { min-height: 120px; resize: vertical; }
    .st-input.error, .st-select.error, .st-textarea.error {
        border-color: #DC2626;
    }
    .st-error-msg {
        font-size: 0.78rem;
        color: #DC2626;
        margin-top: 0.2rem;
        display: none;
    }
    .st-error-msg.visible { display: block; }
    .st-hint { font-size: 0.76rem; color: #9CA3AF; margin-top: 0.2rem; }

    .st-divider {
        border: none;
        border-top: 1.5px dashed #e5e7eb;
        margin: 1.5rem 0;
    }
    .st-contact-label {
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #9CA3AF;
        margin-bottom: 0.85rem;
        display: block;
    }

    /* ── Info chips debajo de técnico ── */
    .tecnico-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 1rem;
    }
    .tecnico-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f3f4f6;
        color: #374151;
        font-size: 0.76rem;
        font-weight: 600;
        padding: 0.28rem 0.7rem;
        border-radius: 50px;
    }
    .tecnico-chip i { color: var(--rojo); font-size: 0.72rem; }

    /* ── Breadcrumb ── */
    .st-breadcrumb {
        padding: 0.85rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        margin-bottom: 0;
        background: var(--dark);
    }
    .st-breadcrumb a, .st-breadcrumb span {
        font-size: 0.83rem;
        color: rgba(255,255,255,0.5);
        text-decoration: none;
    }
    .st-breadcrumb a:hover { color: rgba(255,255,255,0.85); }
    .st-breadcrumb .sep { margin: 0 0.5rem; }
    .st-breadcrumb .current { color: rgba(255,255,255,0.85); }

    @media (max-width: 991px) {
        .st-form-card { position: static; }
    }
</style>

<!-- ── BREADCRUMB ── -->
<div class="st-breadcrumb">
    <div class="container">
        <a href="<?= base_url() ?>">Inicio</a>
        <span class="sep">/</span>
        <span class="current">Servicio Técnico</span>
    </div>
</div>

<!-- ── HERO ── -->
<div class="st-hero">
    <div class="container">
        <span class="eyebrow"><i class="fas fa-tools me-1"></i> Soporte profesional</span>
        <h1>Solicitá tu <span>Servicio Técnico</span></h1>
        <p>Completá el formulario con los datos de tu equipo y contactá directamente con nuestros técnicos por WhatsApp. El mensaje llegará con toda la información lista.</p>
    </div>
</div>

<!-- ── BODY ── -->
<div class="st-body">
    <div class="container">
        <div class="row g-4 align-items-start">

            <!-- ── COLUMNA IZQUIERDA: Técnicos ── -->
            <div class="col-lg-5">
                <div class="row g-4">

                    <!-- Técnico 1 -->
                    <div class="col-12">
                        <div class="tecnico-card">
                            <div class="tecnico-avatar">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="tecnico-nombre">Hernán Medero</div>
                            <div class="tecnico-rol">Técnico en Hardware &amp; Redes</div>
                            <div class="tecnico-chips">
                                <span class="tecnico-chip"><i class="fas fa-check-circle"></i> Reparación de PC</span>
                                <span class="tecnico-chip"><i class="fas fa-check-circle"></i> Redes</span>
                                <span class="tecnico-chip"><i class="fas fa-check-circle"></i> Notebooks</span>
                            </div>
                            <div class="tecnico-desc">
                                Especialista en reparación de hardware, diagnóstico de fallas, instalación de redes y configuración de sistemas. Más de 8 años de experiencia en soporte técnico profesional.
                            </div>
                        </div>
                    </div>

                    <!-- Técnico 2 -->
                    <div class="col-12">
                        <div class="tecnico-card">
                            <div class="tecnico-avatar">
                                <img src="<?= base_url('assets/img/perfiles/perfil_pilito.jpeg') ?>"
                                     alt="Hugo Díaz"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <i class="fas fa-user-tie" style="display:none;"></i>
                            </div>
                            <div class="tecnico-nombre">Hugo Díaz</div>
                            <div class="tecnico-rol">Técnico en Software &amp; Sistemas</div>
                            <div class="tecnico-chips">
                                <span class="tecnico-chip"><i class="fas fa-check-circle"></i> Software</span>
                                <span class="tecnico-chip"><i class="fas fa-check-circle"></i> Sistemas</span>
                                <span class="tecnico-chip"><i class="fas fa-check-circle"></i> Recuperación</span>
                            </div>
                            <div class="tecnico-desc">
                                Experto en resolución de problemas de software, instalación y configuración de sistemas operativos, recuperación de datos y soporte en sitio para empresas y particulares.
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ── COLUMNA DERECHA: Formulario ── -->
            <div class="col-lg-7">
                <div class="st-form-card">
                    <div class="st-form-title"><i class="fas fa-clipboard-list me-2" style="color:var(--rojo);"></i>Describirme tu problema</div>
                    <div class="st-form-subtitle">Completá estos datos para que el técnico ya sepa con qué necesitás ayuda cuando lo contactes.</div>

                    <div class="mb-3">
                        <label class="st-label" for="st-nombre">Tu nombre <span style="color:var(--rojo);">*</span></label>
                        <input type="text" id="st-nombre" class="st-input" placeholder="Ej: Juan Rodríguez">
                        <div class="st-error-msg" id="err-nombre">Por favor ingresá tu nombre.</div>
                    </div>

                    <div class="mb-3">
                        <label class="st-label" for="st-equipo">Tipo de equipo <span style="color:var(--rojo);">*</span></label>
                        <select id="st-equipo" class="st-select">
                            <option value="">— Seleccioná el tipo de equipo —</option>
                            <option value="PC de escritorio">PC de escritorio</option>
                            <option value="Notebook / Laptop">Notebook / Laptop</option>
                            <option value="Tablet">Tablet</option>
                            <option value="Celular / Smartphone">Celular / Smartphone</option>
                            <option value="Impresora">Impresora</option>
                            <option value="Monitor">Monitor</option>
                            <option value="Televisor">Televisor</option>
                            <option value="Electrodoméstico">Electrodoméstico</option>
                            <option value="Equipo de red (router/switch)">Equipo de red (router/switch)</option>
                            <option value="Otro">Otro</option>
                        </select>
                        <div class="st-error-msg" id="err-equipo">Seleccioná el tipo de equipo.</div>
                    </div>

                    <div class="mb-3">
                        <label class="st-label" for="st-marca">Marca y modelo <span style="color:#9CA3AF;font-weight:400;">(opcional)</span></label>
                        <input type="text" id="st-marca" class="st-input" placeholder="Ej: HP Pavilion 15, Samsung Galaxy A54...">
                        <div class="st-hint">Si no lo sabés, dejalo en blanco.</div>
                    </div>

                    <div class="mb-3">
                        <label class="st-label" for="st-problema">Descripción del problema <span style="color:var(--rojo);">*</span></label>
                        <textarea id="st-problema" class="st-textarea"
                            placeholder="Describí qué está pasando con tu equipo. Por ejemplo: no enciende, pantalla negra, hace ruido, está lento, tiene virus, no conecta al WiFi..."></textarea>
                        <div class="st-error-msg" id="err-problema">Describí el problema para que el técnico pueda ayudarte mejor.</div>
                    </div>

                    <div class="mb-3">
                        <label class="st-label" for="st-urgencia">Urgencia</label>
                        <select id="st-urgencia" class="st-select">
                            <option value="Sin urgencia particular">Sin urgencia particular</option>
                            <option value="Puede esperar unos días">Puede esperar unos días</option>
                            <option value="Lo antes posible">Lo antes posible</option>
                            <option value="Es urgente, lo necesito hoy">Es urgente, lo necesito hoy</option>
                        </select>
                    </div>

                    <hr class="st-divider">

                    <span class="st-contact-label"><i class="fab fa-whatsapp me-1" style="color:#25D366;"></i> Elegí con quién querés hablar</span>

                    <div class="d-flex flex-column flex-sm-row gap-3">
                        <button type="button" class="btn-tecnico-wsp flex-fill"
                                onclick="contactarTecnico('543731448928', 'Hernán')">
                            <i class="fab fa-whatsapp"></i> Enviar a Hernán
                        </button>
                        <button type="button" class="btn-tecnico-wsp flex-fill"
                                onclick="contactarTecnico('5493704661520', 'Hugo')">
                            <i class="fab fa-whatsapp"></i> Enviar a Hugo
                        </button>
                    </div>

                    <div class="st-hint mt-2 text-center">
                        Se abrirá WhatsApp con el mensaje ya redactado listo para enviar.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function contactarTecnico(numero, nombreTec) {
    var nombre   = document.getElementById('st-nombre').value.trim();
    var equipo   = document.getElementById('st-equipo').value;
    var marca    = document.getElementById('st-marca').value.trim();
    var problema = document.getElementById('st-problema').value.trim();
    var urgencia = document.getElementById('st-urgencia').value;

    var valid = true;

    var errNombre = document.getElementById('err-nombre');
    var inputNombre = document.getElementById('st-nombre');
    if (!nombre) {
        errNombre.classList.add('visible'); inputNombre.classList.add('error'); valid = false;
    } else {
        errNombre.classList.remove('visible'); inputNombre.classList.remove('error');
    }

    var errEquipo = document.getElementById('err-equipo');
    var inputEquipo = document.getElementById('st-equipo');
    if (!equipo) {
        errEquipo.classList.add('visible'); inputEquipo.classList.add('error'); valid = false;
    } else {
        errEquipo.classList.remove('visible'); inputEquipo.classList.remove('error');
    }

    var errProblema = document.getElementById('err-problema');
    var inputProblema = document.getElementById('st-problema');
    if (!problema) {
        errProblema.classList.add('visible'); inputProblema.classList.add('error'); valid = false;
    } else {
        errProblema.classList.remove('visible'); inputProblema.classList.remove('error');
    }

    if (!valid) return;

    /* Armar mensaje */
    var msg = '¡Hola ' + nombreTec + '! Me contacto desde el sitio web de Centro Informático Regional.\n\n';
    msg += '👤 *Nombre:* ' + nombre + '\n';
    msg += '💻 *Equipo:* ' + equipo;
    if (marca) msg += ' — ' + marca;
    msg += '\n';
    msg += '🔧 *Problema:* ' + problema + '\n';
    msg += '⏱️ *Urgencia:* ' + urgencia + '\n\n';
    msg += '¿Podrías ayudarme?';

    /* Abrir WhatsApp inmediatamente (antes de async para evitar bloqueo de popup) */
    var url = 'https://wa.me/' + numero + '?text=' + encodeURIComponent(msg);
    window.open(url, '_blank', 'noopener,noreferrer');

    /* Guardar consulta en background (fire and forget) */
    var fd = new FormData();
    fd.append('nombre_cliente',        nombre);
    fd.append('tipo_equipo',           equipo);
    fd.append('marca_modelo',          marca);
    fd.append('descripcion_problema',  problema);
    fd.append('urgencia',              urgencia);
    fd.append('tecnico_contactado',    nombreTec);
    fd.append('numero_tecnico',        numero);
    fd.append('<?= csrf_token() ?>',   '<?= csrf_hash() ?>');

    fetch('<?= base_url("consultas/guardar") ?>', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: fd
    }).catch(function () {});
}

/* Limpiar errores al escribir */
['st-nombre', 'st-equipo', 'st-problema'].forEach(function(id) {
    var el = document.getElementById(id);
    el.addEventListener(el.tagName === 'SELECT' ? 'change' : 'input', function() {
        this.classList.remove('error');
        var errId = 'err-' + id.replace('st-', '');
        var errEl = document.getElementById(errId);
        if (errEl) errEl.classList.remove('visible');
    });
});
</script>
