<style>
    /* ── Excepciones que Tailwind no puede expresar como utilidad ── */

    /* Animación de entrada del modal: no está en tailwind.config (no debía tocarse).
       Si se agrega a la config, sería un keyframe "modal-in" + animate-modal-in. */
    @keyframes mpIn {
        from { opacity: 0; transform: scale(0.94) translateY(12px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }
    #mpBox { animation: mpIn 0.28s cubic-bezier(0.34, 1.26, 0.64, 1); }

    /* Scrollbar custom de Firefox: no existe utilidad Tailwind para scrollbar-color */
    #mpBox {
        scrollbar-width: thin;
        scrollbar-color: rgba(255,0,51,0.3) transparent;
    }
</style>

<!-- ══ MODAL PRODUCTO ══ -->
<div id="mpOverlay" class="hidden fixed inset-0 bg-black/[0.78] z-[8000] items-center justify-center p-4 backdrop-blur-[5px]" role="dialog" aria-modal="true" aria-labelledby="mpNombre">
    <div class="bg-[#0f1520] rounded-[22px] max-md:rounded-2xl border border-white/[0.09] max-w-[900px] w-full max-h-[92vh] overflow-y-auto relative" id="mpBox">
        <button class="mp-close absolute top-4 right-4 w-9 h-9 rounded-full bg-white/[0.07] border border-white/[0.12] text-white/65 text-[0.88rem] flex items-center justify-center cursor-pointer z-[2] transition-colors duration-200 hover:bg-rojo hover:text-white hover:border-rojo" id="mpClose" aria-label="Cerrar">
            <i class="fas fa-times"></i>
        </button>
        <div class="grid grid-cols-1 md:grid-cols-2 min-h-0 md:min-h-[460px]">

            <!-- Galería -->
            <div class="p-6 md:pt-[2.2rem] md:px-8 md:pb-8 flex flex-col items-center border-b md:border-b-0 md:border-r border-white/[0.07]">
                <div class="mp-main-img-wrap group relative w-full max-w-[240px] md:max-w-[300px] aspect-square bg-[#131b27] rounded-2xl overflow-hidden cursor-zoom-in flex items-center justify-center border border-white/[0.07] hover:after:content-[''] hover:after:absolute hover:after:inset-0 hover:after:bg-black/[0.18]" id="mpMainWrap">
                    <img id="mpMainImg" src="" alt="" class="hidden w-full h-full object-contain block transition-transform duration-[350ms] ease group-hover:scale-[1.04]">
                    <div class="text-[4rem] text-white/[0.18]" id="mpIconFallback">
                        <i id="mpIconEl" class="fas fa-box"></i>
                    </div>
                    <div class="absolute bottom-[10px] right-[10px] bg-black/[0.55] border border-white/[0.15] text-white/75 rounded-lg px-[9px] py-1 text-[0.72rem] font-semibold flex items-center gap-1 pointer-events-none">
                        <i class="fas fa-search-plus"></i> Zoom
                    </div>
                </div>
                <div class="mp-thumbs flex gap-2 mt-[1.1rem] flex-wrap justify-center" id="mpThumbs"></div>
            </div>

            <!-- Info -->
            <div class="p-6 md:pt-[2.2rem] md:px-8 md:pb-8 flex flex-col">
                <div class="mb-[0.9rem] min-h-[1.6rem]" id="mpBadgeRow"></div>
                <h2 class="text-[1.2rem] md:text-[1.42rem] font-extrabold text-white leading-[1.3] mb-[0.35rem]" id="mpNombre"></h2>
                <div class="text-[0.75rem] font-bold text-rojo uppercase tracking-[1.8px] mb-4" id="mpCat"></div>
                <div class="w-[38px] h-[3px] bg-rojo rounded mb-[1.1rem]"></div>
                <p class="text-white/[0.62] text-[0.91rem] leading-[1.8] flex-1 mb-[1.4rem] whitespace-pre-line" id="mpDesc"></p>
                <div class="mb-[1.6rem]">
                    <span class="text-[0.7rem] font-bold uppercase tracking-[1.2px] text-white/[0.38] block mb-[0.2rem]">Precio</span>
                    <div class="text-[1.55rem] font-extrabold text-white leading-[1.2]" id="mpPrecio"></div>
                </div>
                <a id="mpWaBtn" href="#" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 bg-[#25D366] text-white px-6 py-[0.8rem] rounded-full font-bold text-[0.9rem] no-underline transition-colors duration-200 hover:bg-[#1ebe5a] hover:text-white">
                    <i class="fab fa-whatsapp"></i> Consultar por WhatsApp
                </a>
            </div>

        </div>
    </div>
</div>

<!-- ══ LIGHTBOX ZOOM ══ -->
<div id="mpLightbox" class="hidden fixed inset-0 bg-black/[0.96] z-[9000] items-center justify-center select-none" aria-label="Zoom de imagen">
    <div class="absolute inset-0 flex items-center justify-center overflow-hidden cursor-grab" id="mpLbWrap">
        <img id="mpLbImg" src="" alt="" class="max-w-[90vw] max-h-[90vh] object-contain pointer-events-none origin-center transition-transform duration-[180ms] ease will-change-transform" draggable="false">
    </div>
    <button class="fixed top-[1.1rem] right-[1.1rem] w-[46px] h-[46px] bg-white/10 border border-white/[0.18] rounded-full text-white text-base cursor-pointer flex items-center justify-center z-[9001] transition-colors duration-200 hover:bg-rojo hover:border-rojo" id="mpLbClose" aria-label="Cerrar zoom">
        <i class="fas fa-times"></i>
    </button>
    <div class="fixed bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-[9001] bg-black/50 border border-white/10 rounded-full px-[10px] py-[6px]">
        <button id="mpLbIn" title="Acercar" class="w-[38px] h-[38px] bg-transparent border-0 rounded-lg text-white/80 text-[0.85rem] cursor-pointer flex items-center justify-center transition-colors duration-150 hover:bg-white/[0.12] hover:text-white"><i class="fas fa-plus"></i></button>
        <button id="mpLbReset" title="Tamaño original" class="w-[38px] h-[38px] bg-transparent border-0 rounded-lg text-white/80 text-[0.85rem] cursor-pointer flex items-center justify-center transition-colors duration-150 hover:bg-white/[0.12] hover:text-white"><i class="fas fa-expand-arrows-alt"></i></button>
        <button id="mpLbOut" title="Alejar" class="w-[38px] h-[38px] bg-transparent border-0 rounded-lg text-white/80 text-[0.85rem] cursor-pointer flex items-center justify-center transition-colors duration-150 hover:bg-white/[0.12] hover:text-white"><i class="fas fa-minus"></i></button>
    </div>
</div>

<script>
(function () {
    /* ── Clases Tailwind reutilizadas por el JS (equivalentes a los antiguos
         modificadores .active / .vacia / .consultar / .grabbing) ── */
    var MP_DESC_BASE    = 'text-white/[0.62] text-[0.91rem] leading-[1.8] flex-1 mb-[1.4rem] whitespace-pre-line';
    var MP_DESC_VACIA   = 'text-white/30 text-[0.91rem] leading-[1.8] flex-1 mb-[1.4rem] whitespace-pre-line italic';
    var MP_PRECIO_BASE  = 'text-[1.55rem] font-extrabold text-white leading-[1.2]';
    var MP_PRECIO_CONSULTAR = 'text-[0.95rem] text-white/45 italic font-semibold';
    var MP_THUMB_BASE   = 'mp-thumb w-[58px] h-[58px] rounded-[10px] overflow-hidden border-2 cursor-pointer transition-all duration-200 bg-[#131b27] flex-shrink-0 flex items-center justify-center hover:border-[rgba(255,0,51,0.5)] hover:-translate-y-0.5';
    var MP_THUMB_ACTIVE   = 'border-rojo';
    var MP_THUMB_INACTIVE = 'border-white/[0.08]';

    /* ── Referencias ── */
    const overlay   = document.getElementById('mpOverlay');
    const closeBtn  = document.getElementById('mpClose');
    const mainWrap  = document.getElementById('mpMainWrap');
    const mainImg   = document.getElementById('mpMainImg');
    const iconFallb = document.getElementById('mpIconFallback');
    const iconEl    = document.getElementById('mpIconEl');
    const thumbsEl  = document.getElementById('mpThumbs');
    const badgeRow  = document.getElementById('mpBadgeRow');
    const nombreEl  = document.getElementById('mpNombre');
    const catEl     = document.getElementById('mpCat');
    const descEl    = document.getElementById('mpDesc');
    const precioEl  = document.getElementById('mpPrecio');
    const waBtn     = document.getElementById('mpWaBtn');

    const lightbox  = document.getElementById('mpLightbox');
    const lbWrap    = document.getElementById('mpLbWrap');
    const lbImg     = document.getElementById('mpLbImg');
    const lbClose   = document.getElementById('mpLbClose');
    const lbIn      = document.getElementById('mpLbIn');
    const lbOut     = document.getElementById('mpLbOut');
    const lbReset   = document.getElementById('mpLbReset');

    let lbScale = 1, lbX = 0, lbY = 0;
    let dragging = false, dragStartX = 0, dragStartY = 0;
    let currentImages = [];
    let currentImgIdx = 0;

    /* ── Abrir modal ── */
    function mpAbrir(datos) {
        currentImages = datos.imagenes || [];

        /* Badge */
        badgeRow.innerHTML = datos.badge
            ? '<span class="inline-block bg-rojo text-white text-[0.7rem] font-bold tracking-[0.6px] px-3 py-[3px] rounded-full uppercase">' + escHtml(datos.badge) + '</span>'
            : '';

        /* Texto */
        nombreEl.textContent = datos.nombre || '';
        catEl.textContent    = datos.categoria || '';
        const desc = datos.descripcion || '';
        descEl.textContent   = desc || 'Sin descripción disponible.';
        descEl.className     = desc ? MP_DESC_BASE : MP_DESC_VACIA;

        /* Precio */
        const precio = datos.precio || '';
        const esConsultar = !precio || precio.toLowerCase() === 'consultar precio';
        precioEl.textContent = esConsultar ? 'Consultar precio' : precio;
        precioEl.className   = esConsultar ? MP_PRECIO_CONSULTAR : MP_PRECIO_BASE;

        /* WhatsApp */
        waBtn.href = 'https://wa.me/5493704616482?text=' +
            encodeURIComponent('Hola! Quiero consultar por ' + (datos.nombre || ''));

        /* Imagen principal */
        const imgPrincipal = datos.imagen || (currentImages[0] ? currentImages[0].ruta : '');
        mostrarImgPrincipal(imgPrincipal, datos.nombre || '', datos.icono || 'fas fa-box');

        /* Thumbnails */
        thumbsEl.innerHTML = '';
        if (currentImages.length > 1) {
            currentImages.forEach(function (img, idx) {
                var th = document.createElement('div');
                th.className = MP_THUMB_BASE + ' ' + (idx === 0 ? MP_THUMB_ACTIVE : MP_THUMB_INACTIVE);
                if (img.ruta) {
                    var ti = document.createElement('img');
                    ti.src = img.ruta.startsWith('http') ? img.ruta : (window._baseUrl || '') + img.ruta;
                    ti.alt = img.alt_text || '';
                    ti.className = 'w-full h-full object-cover block';
                    th.appendChild(ti);
                } else {
                    th.innerHTML = '<span class="text-white/30 text-[1.2rem]"><i class="fas fa-image"></i></span>';
                }
                th.addEventListener('click', function () {
                    currentImgIdx = idx;
                    thumbsEl.querySelectorAll('.mp-thumb').forEach(function(t, i) {
                        t.classList.remove(MP_THUMB_ACTIVE, MP_THUMB_INACTIVE);
                        t.classList.add(i === idx ? MP_THUMB_ACTIVE : MP_THUMB_INACTIVE);
                    });
                    mostrarImgPrincipal(img.ruta || '', img.alt_text || datos.nombre, datos.icono || 'fas fa-box');
                });
                thumbsEl.appendChild(th);
            });
        }

        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function mostrarImgPrincipal(ruta, alt, icono) {
        if (ruta) {
            const src = ruta.startsWith('http') ? ruta : (window._baseUrl || '') + ruta;
            mainImg.src = src;
            mainImg.alt = alt;
            mainImg.classList.remove('hidden');
            iconFallb.classList.add('hidden');
            mainImg.onerror = function () {
                this.classList.add('hidden');
                iconFallb.classList.remove('hidden');
                iconEl.className = icono;
            };
        } else {
            mainImg.classList.add('hidden');
            iconFallb.classList.remove('hidden');
            iconEl.className = icono;
        }
    }

    function escHtml(s) {
        return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    /* ── Cerrar modal ── */
    function mpCerrar() {
        overlay.classList.remove('flex');
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
    }
    closeBtn.addEventListener('click', mpCerrar);
    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) mpCerrar();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            if (!lightbox.classList.contains('hidden')) lbCerrar();
            else mpCerrar();
        }
    });

    /* ── Click en imagen → Lightbox ── */
    mainWrap.addEventListener('click', function () {
        const src = !mainImg.classList.contains('hidden') ? mainImg.src : '';
        if (!src) return;
        lbImg.src = src;
        lbImg.alt = mainImg.alt;
        lbScale = 1; lbX = 0; lbY = 0;
        aplicarZoom();
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
    });

    /* ── Lightbox zoom y drag ── */
    function aplicarZoom() {
        lbImg.style.transform = 'translate(' + lbX + 'px, ' + lbY + 'px) scale(' + lbScale + ')';
    }
    function cambiarZoom(delta) {
        lbScale = Math.min(5, Math.max(1, lbScale + delta));
        if (lbScale === 1) { lbX = 0; lbY = 0; }
        aplicarZoom();
    }

    lbIn.addEventListener('click',    function() { cambiarZoom(0.4); });
    lbOut.addEventListener('click',   function() { cambiarZoom(-0.4); });
    lbReset.addEventListener('click', function() { lbScale = 1; lbX = 0; lbY = 0; aplicarZoom(); });

    lbWrap.addEventListener('wheel', function(e) {
        e.preventDefault();
        cambiarZoom(e.deltaY < 0 ? 0.35 : -0.35);
    }, { passive: false });

    lbWrap.addEventListener('mousedown', function(e) {
        if (lbScale <= 1) return;
        dragging = true;
        dragStartX = e.clientX - lbX;
        dragStartY = e.clientY - lbY;
        lbWrap.classList.remove('cursor-grab');
        lbWrap.classList.add('cursor-grabbing');
    });
    document.addEventListener('mousemove', function(e) {
        if (!dragging) return;
        lbX = e.clientX - dragStartX;
        lbY = e.clientY - dragStartY;
        lbImg.style.transform = 'translate(' + lbX + 'px, ' + lbY + 'px) scale(' + lbScale + ')';
    });
    document.addEventListener('mouseup', function() {
        if (!dragging) return;
        dragging = false;
        lbWrap.classList.remove('cursor-grabbing');
        lbWrap.classList.add('cursor-grab');
    });

    /* Touch pinch zoom (mobile) */
    var lastDist = 0;
    lbWrap.addEventListener('touchstart', function(e) {
        if (e.touches.length === 2) {
            lastDist = Math.hypot(
                e.touches[0].clientX - e.touches[1].clientX,
                e.touches[0].clientY - e.touches[1].clientY
            );
        }
    }, { passive: true });
    lbWrap.addEventListener('touchmove', function(e) {
        if (e.touches.length === 2) {
            e.preventDefault();
            var dist = Math.hypot(
                e.touches[0].clientX - e.touches[1].clientX,
                e.touches[0].clientY - e.touches[1].clientY
            );
            cambiarZoom((dist - lastDist) * 0.01);
            lastDist = dist;
        }
    }, { passive: false });

    function lbCerrar() {
        lightbox.classList.remove('flex');
        lightbox.classList.add('hidden');
    }
    lbClose.addEventListener('click', lbCerrar);
    lbWrap.addEventListener('click', function(e) {
        if (e.target === lbWrap && lbScale === 1) lbCerrar();
    });

    /* ── Trigger: clicks en .producto-card y .sec-prod-card ── */
    document.querySelectorAll('.producto-card[data-nombre], .sec-prod-card[data-nombre]').forEach(function(card) {
        card.addEventListener('click', function(e) {
            if (e.target.closest('.btn-consultar') || e.target.closest('.sec-prod-btn')) return;
            var imgs = [];
            try { imgs = JSON.parse(this.dataset.imagenes || '[]'); } catch(err) {}
            mpAbrir({
                nombre:      this.dataset.nombre      || '',
                precio:      this.dataset.precio      || 'Consultar precio',
                descripcion: this.dataset.descripcion || '',
                badge:       this.dataset.badge       || '',
                icono:       this.dataset.icono       || 'fas fa-box',
                imagen:      this.dataset.imagen      || '',
                imagenes:    imgs,
                categoria:   this.dataset.categoria   || '',
            });
        });
    });

    /* Exponer baseUrl y mpAbrir globalmente */
    window._baseUrl = '<?= base_url() ?>';
    window.mpAbrir  = mpAbrir;
})();
</script>
