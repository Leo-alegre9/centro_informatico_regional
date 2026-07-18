<!-- ── BREADCRUMB ── -->
<div class="mb-0 border-b border-white/[0.08] bg-dark py-[0.85rem]">
    <div class="container">
        <a href="<?= base_url() ?>" class="text-[0.83rem] text-white/50 no-underline hover:text-white/85">Inicio</a>
        <span class="mx-2 text-[0.83rem] text-white/50">/</span>
        <span class="text-[0.83rem] text-white/85">Servicio Técnico</span>
    </div>
</div>

<!-- ── HERO ── -->
<div class="bg-dark pt-14 pb-[2.8rem] text-center">
    <div class="container">
        <span class="mb-[1.1rem] inline-block rounded-full bg-rojo/[0.12] px-4 py-[0.35rem] text-[0.78rem] font-bold tracking-[1.2px] text-rojo uppercase"><i class="fas fa-tools mr-1"></i> Soporte profesional</span>
        <h1 class="mb-[0.9rem] text-[clamp(1.8rem,4vw,2.6rem)] leading-[1.2] font-extrabold text-white">Solicitá tu <span class="text-rojo">Servicio Técnico</span></h1>
        <p class="mx-auto max-w-[540px] text-[1.05rem] leading-[1.75] text-white/65">Completá el formulario con los datos de tu equipo y contactá directamente con nuestros técnicos por WhatsApp. El mensaje llegará con toda la información lista.</p>
    </div>
</div>

<!-- ── BODY ── -->
<div class="bg-fondo pt-14 pb-16">
    <div class="container">
        <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-12">

            <!-- ── COLUMNA IZQUIERDA: Técnicos ── -->
            <div class="lg:col-span-5">
                <div class="grid grid-cols-1 gap-6">

                    <!-- Técnico 1 -->
                    <div>
                        <div class="flex items-center gap-[1.1rem] rounded-2xl border-[1.5px] border-gray-200 bg-white p-[1.1rem_1.5rem] shadow-[0_4px_20px_rgba(0,0,0,0.06)] transition-all duration-[250ms] hover:-translate-y-[2px] hover:shadow-[0_10px_30px_rgba(0,0,0,0.1)]">
                            <div class="flex h-[62px] w-[62px] flex-shrink-0 items-center justify-center overflow-hidden rounded-full border-[2.5px] border-rojo bg-dark-2 shadow-[0_3px_12px_rgba(255,0,51,0.16)]">
                                <img src="<?= base_url('assets/img/perfiles/hernan.png') ?>" alt="Hernán Medero" class="block h-full w-full object-cover object-top">
                            </div>
                            <div class="flex flex-col gap-[2px]">
                                <div class="text-base leading-[1.2] font-extrabold text-dark-2">Hernán Medero</div>
                                <div class="text-[0.76rem] font-semibold tracking-[0.5px] text-rojo uppercase">Técnico en Informática</div>
                            </div>
                        </div>
                    </div>

                    <!-- Técnico 2 -->
                    <div>
                        <div class="flex items-center gap-[1.1rem] rounded-2xl border-[1.5px] border-gray-200 bg-white p-[1.1rem_1.5rem] shadow-[0_4px_20px_rgba(0,0,0,0.06)] transition-all duration-[250ms] hover:-translate-y-[2px] hover:shadow-[0_10px_30px_rgba(0,0,0,0.1)]">
                            <div class="flex h-[62px] w-[62px] flex-shrink-0 items-center justify-center overflow-hidden rounded-full border-[2.5px] border-rojo bg-dark-2 shadow-[0_3px_12px_rgba(255,0,51,0.16)]">
                                <img src="<?= base_url('assets/img/perfiles/pilito.jpeg') ?>" alt="Hugo Díaz" class="block h-full w-full object-cover object-top">
                            </div>
                            <div class="flex flex-col gap-[2px]">
                                <div class="text-base leading-[1.2] font-extrabold text-dark-2">Hugo Díaz</div>
                                <div class="text-[0.76rem] font-semibold tracking-[0.5px] text-rojo uppercase">Técnico en Informática</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ── COLUMNA DERECHA: Formulario ── -->
            <div class="lg:col-span-7">
                <div class="static rounded-[20px] border-[1.5px] border-gray-200 bg-white p-[2rem_2rem_2.2rem] shadow-[0_4px_20px_rgba(0,0,0,0.06)] lg:sticky lg:top-[90px]">
                    <div class="mb-1 text-[1.1rem] font-extrabold text-dark-2"><i class="fas fa-clipboard-list mr-2 text-rojo"></i>Describirme tu problema</div>
                    <div class="mb-6 text-[0.85rem] leading-[1.5] text-gris">Completá estos datos para que el técnico ya sepa con qué necesitás ayuda cuando lo contactes.</div>

                    <div class="mb-4">
                        <label class="mb-[0.3rem] block text-[0.85rem] font-semibold text-gray-700" for="st-nombre">Tu nombre <span class="text-rojo">*</span></label>
                        <input type="text" id="st-nombre" class="w-full rounded-[10px] border-[1.5px] border-gray-200 px-4 py-[0.65rem] font-sans text-[0.92rem] text-dark transition-colors duration-200 focus:border-rojo focus:ring-[3px] focus:ring-rojo/10 focus:outline-none" placeholder="Ej: Juan Rodríguez">
                        <div class="mt-[0.2rem] hidden text-[0.78rem] text-[#DC2626]" id="err-nombre">Por favor ingresá tu nombre.</div>
                    </div>

                    <div class="mb-4">
                        <label class="mb-[0.3rem] block text-[0.85rem] font-semibold text-gray-700" for="st-equipo">Tipo de equipo <span class="text-rojo">*</span></label>
                        <select id="st-equipo" class="w-full rounded-[10px] border-[1.5px] border-gray-200 px-4 py-[0.65rem] font-sans text-[0.92rem] text-dark transition-colors duration-200 focus:border-rojo focus:ring-[3px] focus:ring-rojo/10 focus:outline-none">
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
                        <div class="mt-[0.2rem] hidden text-[0.78rem] text-[#DC2626]" id="err-equipo">Seleccioná el tipo de equipo.</div>
                    </div>

                    <div class="mb-4">
                        <label class="mb-[0.3rem] block text-[0.85rem] font-semibold text-gray-700" for="st-marca">Marca y modelo <span class="font-normal text-[#9CA3AF]">(opcional)</span></label>
                        <input type="text" id="st-marca" class="w-full rounded-[10px] border-[1.5px] border-gray-200 px-4 py-[0.65rem] font-sans text-[0.92rem] text-dark transition-colors duration-200 focus:border-rojo focus:ring-[3px] focus:ring-rojo/10 focus:outline-none" placeholder="Ej: HP Pavilion 15, Samsung Galaxy A54...">
                        <div class="mt-[0.2rem] text-[0.76rem] text-[#9CA3AF]">Si no lo sabés, dejalo en blanco.</div>
                    </div>

                    <div class="mb-4">
                        <label class="mb-[0.3rem] block text-[0.85rem] font-semibold text-gray-700" for="st-problema">Descripción del problema <span class="text-rojo">*</span></label>
                        <textarea id="st-problema" class="min-h-[120px] w-full resize-y rounded-[10px] border-[1.5px] border-gray-200 px-4 py-[0.65rem] font-sans text-[0.92rem] text-dark transition-colors duration-200 focus:border-rojo focus:ring-[3px] focus:ring-rojo/10 focus:outline-none"
                            placeholder="Describí qué está pasando con tu equipo. Por ejemplo: no enciende, pantalla negra, hace ruido, está lento, tiene virus, no conecta al WiFi..."></textarea>
                        <div class="mt-[0.2rem] hidden text-[0.78rem] text-[#DC2626]" id="err-problema">Describí el problema para que el técnico pueda ayudarte mejor.</div>
                    </div>

                    <div class="mb-4">
                        <label class="mb-[0.3rem] block text-[0.85rem] font-semibold text-gray-700" for="st-urgencia">Urgencia</label>
                        <select id="st-urgencia" class="w-full rounded-[10px] border-[1.5px] border-gray-200 px-4 py-[0.65rem] font-sans text-[0.92rem] text-dark transition-colors duration-200 focus:border-rojo focus:ring-[3px] focus:ring-rojo/10 focus:outline-none">
                            <option value="Sin urgencia particular">Sin urgencia particular</option>
                            <option value="Puede esperar unos días">Puede esperar unos días</option>
                            <option value="Lo antes posible">Lo antes posible</option>
                            <option value="Es urgente, lo necesito hoy">Es urgente, lo necesito hoy</option>
                        </select>
                    </div>

                    <hr class="my-6 border-0 border-t-[1.5px] border-dashed border-gray-200">

                    <span class="mb-[0.85rem] block text-[0.82rem] font-bold tracking-[0.8px] text-[#9CA3AF] uppercase"><i class="fab fa-whatsapp mr-1 text-[#25D366]"></i> Elegí con quién querés hablar</span>

                    <div class="flex flex-col gap-4 sm:flex-row">
                        <button type="button" class="inline-flex flex-1 w-full cursor-pointer items-center justify-center gap-2 rounded-full border-none bg-[#25D366] px-[1.4rem] py-3 font-sans text-[0.9rem] font-bold text-white no-underline transition-colors duration-200 hover:bg-[#1ebe5a] hover:text-white"
                                onclick="contactarTecnico('543731448928', 'Hernán')">
                            <i class="fab fa-whatsapp"></i> Enviar a Hernán
                        </button>
                        <button type="button" class="inline-flex flex-1 w-full cursor-pointer items-center justify-center gap-2 rounded-full border-none bg-[#25D366] px-[1.4rem] py-3 font-sans text-[0.9rem] font-bold text-white no-underline transition-colors duration-200 hover:bg-[#1ebe5a] hover:text-white"
                                onclick="contactarTecnico('5493704661520', 'Hugo')">
                            <i class="fab fa-whatsapp"></i> Enviar a Hugo
                        </button>
                    </div>

                    <div class="mt-2 text-center text-[0.76rem] text-[#9CA3AF]">
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

    function marcarError(inputId, errId, ok) {
        var input = document.getElementById(inputId);
        var err = document.getElementById(errId);
        if (!ok) {
            err.classList.remove('hidden');
            input.classList.remove('border-gray-200');
            input.classList.add('border-[#DC2626]');
        } else {
            err.classList.add('hidden');
            input.classList.remove('border-[#DC2626]');
            input.classList.add('border-gray-200');
        }
    }

    marcarError('st-nombre', 'err-nombre', !!nombre);
    if (!nombre) valid = false;

    marcarError('st-equipo', 'err-equipo', !!equipo);
    if (!equipo) valid = false;

    marcarError('st-problema', 'err-problema', !!problema);
    if (!problema) valid = false;

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
        this.classList.remove('border-[#DC2626]');
        this.classList.add('border-gray-200');
        var errId = 'err-' + id.replace('st-', '');
        var errEl = document.getElementById(errId);
        if (errEl) errEl.classList.add('hidden');
    });
});
</script>
