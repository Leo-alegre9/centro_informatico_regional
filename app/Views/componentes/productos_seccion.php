<style>
    .sec-productos-section {
        background: #f8f9fa;
        padding: 3.5rem 0 4rem;
        border-top: 1px solid #e9ecef;
    }
    .sec-productos-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.2rem;
        margin-top: 1.5rem;
    }
    .sec-prod-card {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        border: 1.5px solid #f0f0f0;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        display: flex;
        flex-direction: column;
        cursor: pointer;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .sec-prod-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 35px rgba(0,0,0,0.12);
    }
    .sec-prod-img {
        height: 150px;
        background: #1a232e;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        flex-shrink: 0;
    }
    .sec-prod-img img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform 0.35s ease;
    }
    .sec-prod-card:hover .sec-prod-img img { transform: scale(1.05); }
    .sec-prod-img-icon { color: rgba(255,255,255,0.18); font-size: 2.2rem; }
    .sec-prod-badge {
        position: absolute; top: 9px; right: 9px;
        background: #FF0033; color: #fff;
        font-size: 0.67rem; font-weight: 700;
        padding: 3px 9px; border-radius: 50px;
        letter-spacing: 0.4px;
    }
    .sec-prod-body {
        padding: 1rem 1.1rem 1.1rem;
        flex: 1; display: flex; flex-direction: column;
    }
    .sec-prod-cat {
        font-size: 0.7rem; font-weight: 700; color: rgba(255,0,51,0.7);
        text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 0.25rem;
    }
    .sec-prod-nombre {
        font-weight: 700; color: #111827; font-size: 0.9rem;
        line-height: 1.35; margin-bottom: 0.35rem;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    .sec-prod-desc {
        font-size: 0.8rem; color: #6B7280; line-height: 1.5;
        flex: 1; margin-bottom: 0.8rem;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    .sec-prod-footer {
        display: flex; align-items: center;
        justify-content: space-between; gap: 6px; flex-wrap: wrap;
    }
    .sec-prod-precio {
        font-weight: 700; color: #FF0033; font-size: 0.88rem;
    }
    .sec-prod-btn {
        display: inline-flex; align-items: center; gap: 5px;
        background: #25D366; color: #fff;
        padding: 0.4rem 0.9rem; border-radius: 50px;
        font-weight: 700; font-size: 0.75rem;
        text-decoration: none; transition: background 0.2s;
        white-space: nowrap;
    }
    .sec-prod-btn:hover { background: #1ebe5a; color: #fff; }

    @media (max-width: 1199px) { .sec-productos-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 767px)  { .sec-productos-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 479px)  { .sec-productos-grid { grid-template-columns: 1fr; } }
</style>

<section class="sec-productos-section">
    <div class="container">
        <div class="text-center mb-1">
            <span class="section-eyebrow">Selección especial</span>
            <h2 class="section-heading"><?= esc($tituloSeccion ?? 'Productos destacados') ?></h2>
        </div>
        <div class="section-divider"></div>

        <div class="sec-productos-grid" id="sec-productos-grid">
            <?php foreach ($productosSeccion as $sp): ?>
            <?php
                $imgUrl  = $sp['imagen_ruta'] ?? '';
                $imgAlt  = $sp['imagen_alt']  ?? $sp['nombre'];
            ?>
            <div class="sec-prod-card"
                 data-nombre="<?= esc($sp['nombre']) ?>"
                 data-precio="<?= esc($sp['precio_texto']) ?>"
                 data-descripcion="<?= esc($sp['descripcion'] ?? $sp['descripcion_corta'] ?? '') ?>"
                 data-badge="<?= esc($sp['badge'] ?? '') ?>"
                 data-icono="<?= esc($sp['icono'] ?? 'fas fa-box') ?>"
                 data-imagen="<?= esc($imgUrl) ?>"
                 data-imagenes="[]"
                 data-categoria="<?= esc($sp['categoria_nombre'] ?? '') ?>">
                <div class="sec-prod-img">
                    <?php if (!empty($imgUrl)): ?>
                        <img src="<?= base_url(esc($imgUrl)) ?>"
                             alt="<?= esc($imgAlt) ?>"
                             loading="lazy"
                             onerror="this.parentElement.innerHTML='<span class=\'sec-prod-img-icon\'><i class=\'fas fa-box\'></i></span>'">
                    <?php else: ?>
                        <span class="sec-prod-img-icon">
                            <i class="<?= esc($sp['icono'] ?? 'fas fa-box') ?>"></i>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($sp['badge'])): ?>
                        <span class="sec-prod-badge"><?= esc($sp['badge']) ?></span>
                    <?php endif; ?>
                </div>
                <div class="sec-prod-body">
                    <?php if (!empty($sp['categoria_nombre'])): ?>
                        <div class="sec-prod-cat"><?= esc($sp['categoria_nombre']) ?></div>
                    <?php endif; ?>
                    <div class="sec-prod-nombre"><?= esc($sp['nombre']) ?></div>
                    <?php if (!empty($sp['descripcion_corta'])): ?>
                        <div class="sec-prod-desc"><?= esc($sp['descripcion_corta']) ?></div>
                    <?php endif; ?>
                    <div class="sec-prod-footer">
                        <span class="sec-prod-precio">
                            <?= !empty($sp['precio_texto']) ? esc($sp['precio_texto']) : 'Consultar precio' ?>
                        </span>
                        <a href="https://wa.me/5493704616482?text=Hola!%20Quiero%20consultar%20por%20<?= rawurlencode($sp['nombre']) ?>"
                           target="_blank" rel="noopener"
                           class="sec-prod-btn"
                           onclick="event.stopPropagation();">
                            <i class="fab fa-whatsapp"></i> Consultar
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
