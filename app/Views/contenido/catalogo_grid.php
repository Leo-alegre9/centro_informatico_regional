<style>
    .catalogo-section { background: var(--fondo); }
    .catalogo-section-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .productos-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.3rem;
    }
    .producto-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: 0 3px 16px rgba(0,0,0,0.07);
        border: 1.5px solid #f0f0f0;
        transition: transform 0.28s ease, box-shadow 0.28s ease;
    }
    .producto-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 45px rgba(0,0,0,0.13);
    }
    .producto-card.oculto { display: none; }
    .producto-icon-wrap {
        background: var(--dark-2);
        padding: 2.2rem 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 160px;
        position: relative;
        overflow: hidden;
    }
    .producto-icon-wrap i {
        color: rgba(255,255,255,0.22);
        font-size: 3rem;
    }
    .producto-img {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        object-fit: cover;
    }
    .producto-badge {
        position: absolute;
        top: 11px;
        right: 11px;
        background: var(--rojo);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 50px;
        letter-spacing: 0.4px;
        white-space: nowrap;
    }
    .producto-body {
        padding: 1.35rem 1.4rem 1.4rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .producto-name {
        font-weight: 800;
        color: var(--dark-2);
        font-size: 0.97rem;
        margin-bottom: 0.45rem;
        line-height: 1.4;
    }
    .producto-desc {
        color: var(--gris);
        font-size: 0.84rem;
        line-height: 1.6;
        flex: 1;
        margin-bottom: 1.15rem;
    }
    .producto-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        flex-wrap: wrap;
    }
    .producto-precio {
        font-weight: 700;
        color: var(--gris);
        font-size: 0.85rem;
    }
    .btn-consultar {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #25D366;
        color: #fff;
        padding: 0.48rem 1.1rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.8rem;
        text-decoration: none;
        transition: background 0.2s;
        white-space: nowrap;
    }
    .btn-consultar:hover { background: #1ebe5a; color: #fff; }

    /* ── Buscador ── */
    .cat-buscador-wrap {
        position: relative;
        max-width: 520px;
        margin: 0 auto 2rem;
    }
    .cat-buscador-wrap .cat-search-icon {
        position: absolute;
        left: 1.1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gris);
        font-size: 0.95rem;
        pointer-events: none;
    }
    .cat-buscador {
        width: 100%;
        padding: 0.75rem 3rem 0.75rem 2.85rem;
        border: 2px solid #e5e7eb;
        border-radius: 50px;
        font-size: 0.93rem;
        color: var(--dark);
        background: #fff;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .cat-buscador:focus {
        border-color: var(--rojo);
        box-shadow: 0 0 0 3px rgba(255,0,51,0.1);
    }
    .cat-buscador::placeholder { color: #adb5bd; }
    .cat-clear-btn {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #adb5bd;
        cursor: pointer;
        font-size: 0.85rem;
        padding: 4px;
        line-height: 1;
        display: none;
    }
    .cat-clear-btn:hover { color: var(--rojo); }
    .cat-resultados-info {
        text-align: center;
        margin-bottom: 1.2rem;
        font-size: 0.84rem;
        color: var(--gris);
        min-height: 1.2em;
    }
    .cat-sin-resultados-prod {
        display: none;
        text-align: center;
        padding: 3rem 1rem;
        grid-column: 1 / -1;
    }
    .cat-sin-resultados-prod i { font-size: 2.5rem; color: #dee2e6; margin-bottom: 1rem; display: block; }
    .cat-sin-resultados-prod p { color: var(--gris); font-size: 0.95rem; margin: 0; }
    .cat-sin-resultados-prod strong { color: var(--rojo); }
    .catalogo-empty-note {
        text-align: center;
        margin-top: 3.5rem;
        padding: 1.5rem;
        border-top: 1px solid #e5e7eb;
    }
    .catalogo-empty-note p { color: var(--gris); font-size: 0.95rem; margin: 0; }
    .catalogo-empty-note a { color: var(--rojo); font-weight: 600; text-decoration: none; }
    .catalogo-empty-note a:hover { text-decoration: underline; }

    @media (max-width: 991px) { .productos-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 575px)  { .productos-grid { grid-template-columns: 1fr; } }
</style>

<!-- ═══════════════════════════════════════════════
     GRILLA DE PRODUCTOS
═══════════════════════════════════════════════ -->
<section class="catalogo-section py-5">
    <div class="container">

        <div class="catalogo-section-header">
            <div>
                <span class="section-eyebrow">Disponible en local</span>
                <h2 class="section-heading mb-0">Productos disponibles</h2>
            </div>
            <a href="https://wa.me/5493704616482?text=Hola!%20Me%20interesa%20conocer%20los%20precios%20de%20<?= rawurlencode($current['nombre']) ?>"
               target="_blank" rel="noopener"
               class="btn-rojo" style="font-size:0.88rem; padding:0.7rem 1.6rem; white-space:nowrap;">
                <i class="fab fa-whatsapp"></i> Consultar por WhatsApp
            </a>
        </div>

        <div class="cat-buscador-wrap">
            <i class="fas fa-search cat-search-icon"></i>
            <input type="text"
                   id="buscador-productos"
                   class="cat-buscador"
                   placeholder="Buscar producto...">
            <button type="button" class="cat-clear-btn" id="clear-productos" title="Limpiar búsqueda">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="cat-resultados-info" id="info-productos"></div>

        <div class="productos-grid" id="productos-grid">
            <?php foreach ($current['productos'] as $producto): ?>
            <div class="producto-card"
                 data-busqueda="<?= esc(strtolower($producto['nombre'] . ' ' . $producto['descripcion'] . ' ' . $producto['badge'])) ?>">
                <div class="producto-icon-wrap">
                    <?php if (!empty($producto['imagen_url'])): ?>
                    <img src="<?= base_url(esc($producto['imagen_url'])) ?>"
                         alt="<?= esc($producto['nombre']) ?>"
                         class="producto-img">
                    <?php else: ?>
                    <i class="<?= esc($producto['icono']) ?>"></i>
                    <?php endif; ?>
                    <?php if (!empty($producto['badge'])): ?>
                    <span class="producto-badge"><?= esc($producto['badge']) ?></span>
                    <?php endif; ?>
                </div>
                <div class="producto-body">
                    <div class="producto-name"><?= esc($producto['nombre']) ?></div>
                    <div class="producto-desc"><?= esc($producto['descripcion']) ?></div>
                    <div class="producto-footer">
                        <span class="producto-precio"><?= esc($producto['precio']) ?></span>
                        <a href="https://wa.me/5493704616482?text=Hola!%20Quiero%20consultar%20por%20<?= rawurlencode($producto['nombre']) ?>"
                           target="_blank" rel="noopener"
                           class="btn-consultar">
                            <i class="fab fa-whatsapp"></i> Consultar
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <div class="cat-sin-resultados-prod" id="sin-resultados-productos">
                <i class="fas fa-box-open"></i>
                <p>No se encontraron productos para <strong id="termino-productos"></strong></p>
            </div>
        </div>

        <div class="catalogo-empty-note">
            <p>¿No encontrás lo que buscás? <a href="<?= base_url('contacto') ?>">Contactanos</a> y lo conseguimos para vos.</p>
        </div>

    </div>
</section>

<script>
(function () {
    const input    = document.getElementById('buscador-productos');
    const clearBtn = document.getElementById('clear-productos');
    const grid     = document.getElementById('productos-grid');
    const noRes    = document.getElementById('sin-resultados-productos');
    const termSpan = document.getElementById('termino-productos');
    const infoEl   = document.getElementById('info-productos');
    const total    = grid.querySelectorAll('.producto-card').length;

    function filtrar() {
        const q = input.value.trim().toLowerCase();
        clearBtn.style.display = q ? 'block' : 'none';
        const cards = grid.querySelectorAll('.producto-card');
        let visible = 0;
        cards.forEach(function(card) {
            const match = !q || card.dataset.busqueda.includes(q);
            card.classList.toggle('oculto', !match);
            if (match) visible++;
        });
        noRes.style.display  = visible === 0 ? 'block' : 'none';
        termSpan.textContent = '"' + input.value.trim() + '"';
        infoEl.textContent   = q ? (visible + ' de ' + total + ' productos') : '';
    }

    input.addEventListener('input', filtrar);
    clearBtn.addEventListener('click', function() {
        input.value = '';
        filtrar();
        input.focus();
    });
})();
</script>
