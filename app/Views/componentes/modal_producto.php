<style>
    /* ── Modal overlay ── */
    .mp-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.78);
        z-index: 8000;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
    }
    .mp-overlay.open { display: flex; }

    .mp-box {
        background: #0f1520;
        border-radius: 22px;
        border: 1px solid rgba(255,255,255,0.09);
        max-width: 900px;
        width: 100%;
        max-height: 92vh;
        overflow-y: auto;
        position: relative;
        animation: mpIn 0.28s cubic-bezier(0.34, 1.26, 0.64, 1);
        scrollbar-width: thin;
        scrollbar-color: rgba(255,0,51,0.3) transparent;
    }
    @keyframes mpIn {
        from { opacity: 0; transform: scale(0.94) translateY(12px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }

    .mp-close {
        position: absolute;
        top: 1rem; right: 1rem;
        width: 36px; height: 36px;
        border-radius: 50%;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.12);
        color: rgba(255,255,255,0.65);
        font-size: 0.88rem;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        z-index: 2;
        transition: background 0.2s, color 0.2s, border-color 0.2s;
    }
    .mp-close:hover { background: #FF0033; color: #fff; border-color: #FF0033; }

    /* ── Grid ── */
    .mp-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 460px;
    }

    /* ── Image panel ── */
    .mp-img-panel {
        padding: 2.2rem 2rem 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        border-right: 1px solid rgba(255,255,255,0.07);
    }
    .mp-main-img-wrap {
        position: relative;
        width: 100%;
        max-width: 300px;
        aspect-ratio: 1 / 1;
        background: #131b27;
        border-radius: 16px;
        overflow: hidden;
        cursor: zoom-in;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255,255,255,0.07);
    }
    .mp-main-img-wrap:hover::after {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.18);
    }
    .mp-main-img {
        width: 100%; height: 100%;
        object-fit: contain;
        display: block;
        transition: transform 0.35s ease;
    }
    .mp-main-img-wrap:hover .mp-main-img { transform: scale(1.04); }
    .mp-icon-fallback {
        font-size: 4rem;
        color: rgba(255,255,255,0.18);
    }
    .mp-zoom-badge {
        position: absolute;
        bottom: 10px; right: 10px;
        background: rgba(0,0,0,0.55);
        border: 1px solid rgba(255,255,255,0.15);
        color: rgba(255,255,255,0.75);
        border-radius: 8px;
        padding: 4px 9px;
        font-size: 0.72rem;
        font-weight: 600;
        display: flex; align-items: center; gap: 4px;
        pointer-events: none;
    }

    .mp-thumbs {
        display: flex;
        gap: 8px;
        margin-top: 1.1rem;
        flex-wrap: wrap;
        justify-content: center;
    }
    .mp-thumb {
        width: 58px; height: 58px;
        border-radius: 10px;
        overflow: hidden;
        border: 2px solid rgba(255,255,255,0.08);
        cursor: pointer;
        transition: border-color 0.2s, transform 0.2s;
        background: #131b27;
        flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .mp-thumb:hover { border-color: rgba(255,0,51,0.5); transform: translateY(-2px); }
    .mp-thumb.active { border-color: #FF0033; }
    .mp-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .mp-thumb-icon { color: rgba(255,255,255,0.3); font-size: 1.2rem; }

    /* ── Info panel ── */
    .mp-info-panel {
        padding: 2.2rem 2rem 2rem;
        display: flex;
        flex-direction: column;
    }
    .mp-badge-row { margin-bottom: 0.9rem; min-height: 1.6rem; }
    .mp-badge {
        display: inline-block;
        background: #FF0033;
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.6px;
        padding: 3px 12px;
        border-radius: 50px;
        text-transform: uppercase;
    }
    .mp-nombre {
        font-size: 1.42rem;
        font-weight: 800;
        color: #fff;
        line-height: 1.3;
        margin-bottom: 0.35rem;
    }
    .mp-cat {
        font-size: 0.75rem;
        font-weight: 700;
        color: #FF0033;
        text-transform: uppercase;
        letter-spacing: 1.8px;
        margin-bottom: 1rem;
    }
    .mp-divider {
        width: 38px; height: 3px;
        background: #FF0033;
        border-radius: 2px;
        margin-bottom: 1.1rem;
    }
    .mp-desc {
        color: rgba(255,255,255,0.62);
        font-size: 0.91rem;
        line-height: 1.8;
        flex: 1;
        margin-bottom: 1.4rem;
        white-space: pre-line;
    }
    .mp-desc.vacia { color: rgba(255,255,255,0.3); font-style: italic; }
    .mp-precio-block { margin-bottom: 1.6rem; }
    .mp-precio-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: rgba(255,255,255,0.38);
        display: block;
        margin-bottom: 0.2rem;
    }
    .mp-precio {
        font-size: 1.55rem;
        font-weight: 800;
        color: #fff;
        line-height: 1.2;
    }
    .mp-precio.consultar {
        font-size: 0.95rem;
        color: rgba(255,255,255,0.45);
        font-style: italic;
        font-weight: 600;
    }
    .mp-btn-wa {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #25D366;
        color: #fff;
        padding: 0.8rem 1.5rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        transition: background 0.2s;
    }
    .mp-btn-wa:hover { background: #1ebe5a; color: #fff; }

    /* ── Zoom lightbox ── */
    .mp-lightbox {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.96);
        z-index: 9000;
        align-items: center;
        justify-content: center;
        user-select: none;
    }
    .mp-lightbox.open { display: flex; }
    .mp-lb-img-wrap {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        cursor: grab;
    }
    .mp-lb-img-wrap.grabbing { cursor: grabbing; }
    .mp-lb-img {
        max-width: 90vw;
        max-height: 90vh;
        object-fit: contain;
        pointer-events: none;
        transform-origin: center;
        transition: transform 0.18s ease;
        will-change: transform;
    }
    .mp-lb-close {
        position: fixed;
        top: 1.1rem; right: 1.1rem;
        width: 46px; height: 46px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.18);
        border-radius: 50%;
        color: #fff;
        font-size: 1rem;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        z-index: 9001;
        transition: background 0.2s;
    }
    .mp-lb-close:hover { background: #FF0033; border-color: #FF0033; }
    .mp-lb-controls {
        position: fixed;
        bottom: 1.5rem; left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 8px;
        z-index: 9001;
        background: rgba(0,0,0,0.5);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 50px;
        padding: 6px 10px;
    }
    .mp-lb-controls button {
        width: 38px; height: 38px;
        background: transparent;
        border: none;
        border-radius: 8px;
        color: rgba(255,255,255,0.8);
        font-size: 0.85rem;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background 0.15s, color 0.15s;
    }
    .mp-lb-controls button:hover { background: rgba(255,255,255,0.12); color: #fff; }

    @media (max-width: 767px) {
        .mp-grid { grid-template-columns: 1fr; min-height: unset; }
        .mp-img-panel { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.07); padding: 1.5rem; }
        .mp-info-panel { padding: 1.5rem; }
        .mp-nombre { font-size: 1.2rem; }
        .mp-main-img-wrap { max-width: 240px; }
        .mp-box { border-radius: 16px; }
    }
</style>

<!-- ══ MODAL PRODUCTO ══ -->
<div id="mpOverlay" class="mp-overlay" role="dialog" aria-modal="true" aria-labelledby="mpNombre">
    <div class="mp-box" id="mpBox">
        <button class="mp-close" id="mpClose" aria-label="Cerrar">
            <i class="fas fa-times"></i>
        </button>
        <div class="mp-grid">

            <!-- Galería -->
            <div class="mp-img-panel">
                <div class="mp-main-img-wrap" id="mpMainWrap">
                    <img id="mpMainImg" src="" alt="" class="mp-main-img" style="display:none;">
                    <div class="mp-icon-fallback" id="mpIconFallback">
                        <i id="mpIconEl" class="fas fa-box"></i>
                    </div>
                    <div class="mp-zoom-badge"><i class="fas fa-search-plus"></i> Zoom</div>
                </div>
                <div class="mp-thumbs" id="mpThumbs"></div>
            </div>

            <!-- Info -->
            <div class="mp-info-panel">
                <div class="mp-badge-row" id="mpBadgeRow"></div>
                <h2 class="mp-nombre" id="mpNombre"></h2>
                <div class="mp-cat" id="mpCat"></div>
                <div class="mp-divider"></div>
                <p class="mp-desc" id="mpDesc"></p>
                <div class="mp-precio-block">
                    <span class="mp-precio-label">Precio</span>
                    <div class="mp-precio" id="mpPrecio"></div>
                </div>
                <a id="mpWaBtn" href="#" target="_blank" rel="noopener" class="mp-btn-wa">
                    <i class="fab fa-whatsapp"></i> Consultar por WhatsApp
                </a>
            </div>

        </div>
    </div>
</div>

<!-- ══ LIGHTBOX ZOOM ══ -->
<div id="mpLightbox" class="mp-lightbox" aria-label="Zoom de imagen">
    <div class="mp-lb-img-wrap" id="mpLbWrap">
        <img id="mpLbImg" src="" alt="" class="mp-lb-img" draggable="false">
    </div>
    <button class="mp-lb-close" id="mpLbClose" aria-label="Cerrar zoom">
        <i class="fas fa-times"></i>
    </button>
    <div class="mp-lb-controls">
        <button id="mpLbIn" title="Acercar"><i class="fas fa-plus"></i></button>
        <button id="mpLbReset" title="Tamaño original"><i class="fas fa-expand-arrows-alt"></i></button>
        <button id="mpLbOut" title="Alejar"><i class="fas fa-minus"></i></button>
    </div>
</div>

<script>
(function () {
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
            ? '<span class="mp-badge">' + escHtml(datos.badge) + '</span>'
            : '';

        /* Texto */
        nombreEl.textContent = datos.nombre || '';
        catEl.textContent    = datos.categoria || '';
        const desc = datos.descripcion || '';
        descEl.textContent   = desc || 'Sin descripción disponible.';
        descEl.classList.toggle('vacia', !desc);

        /* Precio */
        const precio = datos.precio || '';
        const esConsultar = !precio || precio.toLowerCase() === 'consultar precio';
        precioEl.textContent = esConsultar ? 'Consultar precio' : precio;
        precioEl.className   = 'mp-precio' + (esConsultar ? ' consultar' : '');

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
                th.className = 'mp-thumb' + (idx === 0 ? ' active' : '');
                if (img.ruta) {
                    var ti = document.createElement('img');
                    ti.src = img.ruta.startsWith('http') ? img.ruta : (window._baseUrl || '') + img.ruta;
                    ti.alt = img.alt_text || '';
                    th.appendChild(ti);
                } else {
                    th.innerHTML = '<span class="mp-thumb-icon"><i class="fas fa-image"></i></span>';
                }
                th.addEventListener('click', function () {
                    currentImgIdx = idx;
                    thumbsEl.querySelectorAll('.mp-thumb').forEach(function(t, i) {
                        t.classList.toggle('active', i === idx);
                    });
                    mostrarImgPrincipal(img.ruta || '', img.alt_text || datos.nombre, datos.icono || 'fas fa-box');
                });
                thumbsEl.appendChild(th);
            });
        }

        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function mostrarImgPrincipal(ruta, alt, icono) {
        if (ruta) {
            const src = ruta.startsWith('http') ? ruta : (window._baseUrl || '') + ruta;
            mainImg.src = src;
            mainImg.alt = alt;
            mainImg.style.display = '';
            iconFallb.style.display = 'none';
            mainImg.onerror = function () {
                this.style.display = 'none';
                iconFallb.style.display = 'flex';
                iconEl.className = icono;
            };
        } else {
            mainImg.style.display = 'none';
            iconFallb.style.display = 'flex';
            iconEl.className = icono;
        }
    }

    function escHtml(s) {
        return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    /* ── Cerrar modal ── */
    function mpCerrar() {
        overlay.classList.remove('open');
        document.body.style.overflow = '';
    }
    closeBtn.addEventListener('click', mpCerrar);
    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) mpCerrar();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            if (lightbox.classList.contains('open')) lbCerrar();
            else mpCerrar();
        }
    });

    /* ── Click en imagen → Lightbox ── */
    mainWrap.addEventListener('click', function () {
        const src = mainImg.style.display !== 'none' ? mainImg.src : '';
        if (!src) return;
        lbImg.src = src;
        lbImg.alt = mainImg.alt;
        lbScale = 1; lbX = 0; lbY = 0;
        aplicarZoom();
        lightbox.classList.add('open');
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
        lbWrap.classList.add('grabbing');
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
        lbWrap.classList.remove('grabbing');
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
        lightbox.classList.remove('open');
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
