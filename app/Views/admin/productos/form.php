<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<style>
    .form-card {
        background: #fff; border: 1px solid #e5e7eb; border-radius: 14px;
        padding: 2rem; box-shadow: 0 1px 4px rgba(0,0,0,0.05); max-width: 820px;
    }
    .form-section-title {
        font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.9px;
        color: #9CA3AF; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f3f4f6;
    }
    .form-label { font-size: 0.85rem; font-weight: 600; color: #374151; margin-bottom: 0.3rem; }
    .form-control, .form-select {
        border: 1.5px solid #e5e7eb; border-radius: 9px; padding: 0.6rem 0.95rem;
        font-size: 0.92rem; color: #111827; transition: border-color 0.2s, box-shadow 0.2s;
        background: #fff;
    }
    .form-control:focus, .form-select:focus {
        border-color: #FF0033; box-shadow: 0 0 0 3px rgba(255,0,51,0.1); outline: none;
    }
    .form-select:disabled { background: #f9fafb; color: #9CA3AF; cursor: not-allowed; }
    textarea.form-control { min-height: 95px; resize: vertical; }
    .field-hint { font-size: 0.75rem; color: #9CA3AF; margin-top: 0.2rem; }

    /* ── imágenes actuales ── */
    .img-grid-actual {
        display: flex; flex-wrap: wrap; gap: 0.85rem; margin-bottom: 0.5rem;
    }
    .img-card-actual {
        width: 140px; border: 1.5px solid #e5e7eb; border-radius: 12px; overflow: hidden;
        background: #f9fafb; display: flex; flex-direction: column;
        transition: border-color 0.2s, opacity 0.2s; position: relative;
    }
    .img-card-actual.para-eliminar { opacity: 0.35; border-color: #fca5a5; }
    .img-card-actual .img-thumb {
        width: 100%; height: 110px; object-fit: cover; display: block;
    }
    .img-card-actual .img-thumb-placeholder {
        width: 100%; height: 110px; display: flex; align-items: center; justify-content: center;
        color: #d1d5db; font-size: 2rem; background: #f3f4f6;
    }
    .img-card-actual .img-card-body {
        padding: 0.45rem 0.5rem 0.5rem; display: flex; flex-direction: column; gap: 5px;
    }
    .img-badge-principal {
        display: inline-block; background: rgba(255,0,51,0.1); color: #FF0033;
        font-size: 0.67rem; font-weight: 700; padding: 2px 7px; border-radius: 50px;
        text-transform: uppercase; letter-spacing: 0.4px; width: fit-content;
    }
    .btn-set-principal {
        font-size: 0.72rem; font-weight: 600; color: #374151; background: #fff;
        border: 1.5px solid #e5e7eb; border-radius: 6px; padding: 3px 7px;
        cursor: pointer; transition: border-color 0.2s, color 0.2s; text-align: center;
        width: 100%;
    }
    .btn-set-principal:hover { border-color: #FF0033; color: #FF0033; }
    .btn-del-img {
        font-size: 0.72rem; font-weight: 600; color: #9CA3AF; background: #fff;
        border: 1.5px solid #e5e7eb; border-radius: 6px; padding: 3px 7px;
        cursor: pointer; transition: border-color 0.2s, color 0.2s; text-align: center;
        width: 100%;
    }
    .btn-del-img:hover { border-color: #fca5a5; color: #DC2626; }
    .btn-del-img.activo { color: #DC2626; border-color: #fca5a5; background: #fef2f2; }

    /* ── upload área ── */
    .img-upload-area {
        border: 2px dashed #e5e7eb; border-radius: 12px; background: #f9fafb;
        padding: 1.5rem; text-align: center; cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
    }
    .img-upload-area:hover, .img-upload-area.drag-over { border-color: #FF0033; background: #fff5f5; }
    .img-upload-area i { font-size: 2rem; color: #d1d5db; display: block; margin-bottom: 0.5rem; }
    .img-upload-area span { font-size: 0.84rem; color: #9CA3AF; }
    .img-upload-area strong { color: #374151; }

    /* ── previews nuevas ── */
    .img-previews-nuevas {
        display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 0.9rem;
    }
    .img-preview-nueva {
        width: 100px; height: 100px; border-radius: 10px; overflow: hidden;
        border: 1.5px solid #e5e7eb; position: relative;
    }
    .img-preview-nueva img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .img-preview-nueva .rm-preview {
        position: absolute; top: 3px; right: 3px; background: rgba(0,0,0,0.55);
        color: #fff; border: none; border-radius: 50%; width: 20px; height: 20px;
        font-size: 0.65rem; cursor: pointer; display: flex; align-items: center; justify-content: center;
        line-height: 1;
    }
    .img-delete-check { font-size: 0.82rem; color: #DC2626; }

    .cat-confirmacion {
        display: none; align-items: center; gap: 0.6rem;
        background: rgba(16,185,129,0.07); border: 1px solid rgba(16,185,129,0.25);
        border-radius: 8px; padding: 0.55rem 0.9rem; margin-top: 0.75rem; font-size: 0.85rem; color: #065f46;
    }
    .cat-confirmacion.visible { display: flex; }
    .cat-confirmacion i { color: #10b981; font-size: 0.9rem; }

    .badge-preview {
        display: inline-block; background: rgba(255,0,51,0.08); color: #FF0033;
        padding: 0.15rem 0.6rem; border-radius: 50px; font-size: 0.78rem; font-weight: 600;
        margin-left: 0.5rem; vertical-align: middle;
    }

    .btn-guardar {
        background: #FF0033; color: #fff; border: none; padding: 0.7rem 2rem;
        border-radius: 50px; font-size: 0.95rem; font-weight: 600;
        display: inline-flex; align-items: center; gap: 0.45rem; cursor: pointer; transition: background 0.2s;
    }
    .btn-guardar:hover { background: #cc0028; }
    .btn-cancelar {
        color: #6B7280; text-decoration: none; padding: 0.7rem 1.4rem; border-radius: 50px;
        font-size: 0.95rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.4rem;
        border: 1.5px solid #e5e7eb; transition: background 0.15s;
    }
    .btn-cancelar:hover { background: #f3f4f6; color: #374151; }
    .errors-box {
        background: rgba(255,0,51,0.05); border: 1px solid rgba(255,0,51,0.2); border-radius: 10px;
        padding: 1rem 1.25rem; margin-bottom: 1.5rem; font-size: 0.88rem; color: #DC2626;
    }
    .errors-box ul { margin: 0.5rem 0 0; padding-left: 1.2rem; }
    .page-header-row { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem; }
    .page-header-row h2 { font-size: 1.35rem; font-weight: 700; color: #111827; margin: 0; }
    .back-link { color: #6B7280; text-decoration: none; display: flex; align-items: center; gap: 0.3rem; transition: color 0.15s; }
    .back-link:hover { color: #FF0033; }

    .select-arrow { position: relative; }
    .select-arrow::after {
        content: ''; position: absolute; right: 0.9rem; top: 50%; transform: translateY(-50%);
        width: 0; height: 0; border-left: 5px solid transparent; border-right: 5px solid transparent;
        border-top: 5px solid #9CA3AF; pointer-events: none;
    }

    /* ── secciones de visibilidad ── */
    .secciones-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 0.75rem;
    }
    .seccion-item {
        border: 1.5px solid #e5e7eb; border-radius: 10px; padding: 0.9rem 0.85rem;
        cursor: pointer; user-select: none; position: relative;
        transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        background: #fff;
    }
    .seccion-item:hover { border-color: #FF0033; background: #fff8f8; }
    .seccion-item.activa {
        border-color: #FF0033; background: rgba(255,0,51,0.04);
        box-shadow: 0 0 0 3px rgba(255,0,51,0.08);
    }
    .seccion-item input[type=checkbox] { display: none; }
    .seccion-check-box {
        position: absolute; top: 0.7rem; right: 0.7rem;
        width: 17px; height: 17px; border: 2px solid #D1D5DB; border-radius: 4px;
        background: #fff; transition: border-color 0.2s, background 0.2s;
        display: flex; align-items: center; justify-content: center;
    }
    .seccion-item.activa .seccion-check-box {
        border-color: #FF0033; background: #FF0033;
    }
    .seccion-check-box::after {
        content: ''; display: block; width: 4px; height: 7px;
        border-right: 2px solid transparent; border-bottom: 2px solid transparent;
        transform: rotate(45deg) translate(-1px, -1px);
    }
    .seccion-item.activa .seccion-check-box::after {
        border-color: #fff;
    }
    .seccion-icon {
        font-size: 1.4rem; color: #D1D5DB; display: block; margin-bottom: 0.45rem;
        transition: color 0.2s;
    }
    .seccion-item.activa .seccion-icon { color: #FF0033; }
    .seccion-nombre {
        font-weight: 600; font-size: 0.84rem; color: #374151; display: block;
    }
    .seccion-desc {
        font-size: 0.72rem; color: #9CA3AF; display: block; margin-top: 0.2rem; line-height: 1.35;
    }
    .secciones-hint {
        font-size: 0.8rem; color: #6B7280; margin-bottom: 0.85rem; line-height: 1.5;
        background: #f9fafb; border-radius: 8px; padding: 0.6rem 0.9rem;
        border-left: 3px solid #FF0033;
    }
</style>

<div class="page-header-row">
    <a href="<?= base_url('admin/productos') ?>" class="back-link">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h2>
        <i class="fas fa-<?= $producto ? 'pen' : 'plus-circle' ?> me-2" style="color:#FF0033;font-size:1.05rem;"></i>
        <?= $producto ? 'Editar producto' : 'Agregar nuevo producto' ?>
    </h2>
</div>

<?php $errors = session()->getFlashdata('errors'); ?>
<?php if ($errors): ?>
<div class="errors-box mb-3">
    <strong><i class="fas fa-exclamation-triangle me-1"></i>Corregí los siguientes errores:</strong>
    <ul><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
</div>
<?php endif; ?>

<div class="form-card">
    <form action="<?= esc($accion) ?>" method="POST" enctype="multipart/form-data">

        <!-- Campo oculto con el ID de la categoría seleccionada -->
        <input type="hidden" id="categoria_id" name="categoria_id"
               value="<?= esc(old('categoria_id', $producto['categoria_id'] ?? '')) ?>">

        <!-- ── SECCIÓN 1: CATEGORÍA ── -->
        <div class="form-section-title"><i class="fas fa-sitemap me-1"></i>¿A qué categoría pertenece?</div>

        <div class="row g-3 mb-2">
            <div class="col-12 col-md-4">
                <label for="sel_rubro" class="form-label">
                    Rubro <span style="color:#FF0033;">*</span>
                </label>
                <select id="sel_rubro" class="form-select">
                    <option value="">— Seleccioná un rubro —</option>
                </select>
            </div>

            <div class="col-12 col-md-4">
                <label for="sel_subrubro" class="form-label">
                    Subrubro <span style="color:#FF0033;">*</span>
                </label>
                <select id="sel_subrubro" class="form-select" disabled>
                    <option value="">— Primero elegí el rubro —</option>
                </select>
            </div>

            <div class="col-12 col-md-4" id="wrap-subsub" style="display:none;">
                <label for="sel_subsub" class="form-label">Subcategoría</label>
                <select id="sel_subsub" class="form-select">
                    <option value="">— Seleccioná —</option>
                </select>
            </div>
        </div>

        <div class="cat-confirmacion" id="catConfirmacion">
            <i class="fas fa-check-circle"></i>
            <span>Categoría: <strong id="catNombreTexto"></strong></span>
        </div>

        <div class="mb-4"></div>

        <!-- ── SECCIÓN 1b: MARCA ── -->
        <div class="form-section-title"><i class="fas fa-tag me-1"></i>Marca</div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-6">
                <label for="marca_id" class="form-label">Marca del producto</label>
                <select id="marca_id" name="marca_id" class="form-select">
                    <option value="">— Sin marca / Genérico —</option>
                    <?php foreach ($marcas as $m): ?>
                        <option value="<?= $m['id'] ?>"
                            <?= old('marca_id', $producto['marca_id'] ?? '') == $m['id'] ? 'selected' : '' ?>>
                            <?= esc($m['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="field-hint">Seleccioná la marca fabricante del producto.</div>
            </div>
        </div>

        <!-- ── SECCIÓN 2: DATOS DEL PRODUCTO ── -->
        <div class="form-section-title"><i class="fas fa-box me-1"></i>Información del producto</div>

        <div class="row g-3 mb-4">
            <div class="col-12">
                <label for="nombre" class="form-label">
                    Nombre del producto <span style="color:#FF0033;">*</span>
                </label>
                <input type="text" id="nombre" name="nombre" class="form-control"
                       value="<?= esc(old('nombre', $producto['nombre'] ?? '')) ?>"
                       placeholder="Ej: Teclado Mecánico RGB, Heladera No Frost 420L" required>
            </div>

            <div class="col-12 col-sm-6">
                <label for="modelo" class="form-label">Modelo / SKU</label>
                <input type="text" id="modelo" name="modelo" class="form-control"
                       value="<?= esc(old('modelo', $producto['modelo'] ?? '')) ?>"
                       placeholder="Ej: MX Keys, G915, GTX-3090-TI" maxlength="200">
                <div class="field-hint">Número de modelo o código del fabricante (opcional).</div>
            </div>

            <div class="col-12 col-sm-6">
                <label for="codigo" class="form-label">
                    Código interno
                    <span style="background:rgba(99,102,241,0.1);color:#4F46E5;font-size:0.68rem;font-weight:700;
                                 padding:1px 7px;border-radius:50px;margin-left:6px;vertical-align:middle;">
                        <i class="fas fa-lock" style="font-size:0.6rem;"></i> Solo admin
                    </span>
                </label>
                <input type="text" id="codigo" name="codigo" class="form-control"
                       value="<?= esc(old('codigo', $producto['codigo'] ?? '')) ?>"
                       placeholder="Ej: CIR-0042, PROD-2024-001" maxlength="100">
                <div class="field-hint">
                    <i class="fas fa-lock me-1" style="color:#9CA3AF;"></i>
                    Código único para identificar el producto internamente. No aparece en el catálogo.
                </div>
            </div>

            <div class="col-12">
                <label for="descripcion_corta" class="form-label">Descripción breve</label>
                <input type="text" id="descripcion_corta" name="descripcion_corta" class="form-control"
                       value="<?= esc(old('descripcion_corta', $producto['descripcion_corta'] ?? '')) ?>"
                       placeholder="Una línea que resume el producto (aparece en las tarjetas del catálogo)"
                       maxlength="500">
                <div class="field-hint">Máximo 500 caracteres. Se muestra en las tarjetas del catálogo.</div>
            </div>

            <div class="col-12">
                <label for="descripcion" class="form-label">Descripción completa</label>
                <textarea id="descripcion" name="descripcion" class="form-control"
                          placeholder="Características, especificaciones técnicas, materiales, colores disponibles..."><?= esc(old('descripcion', $producto['descripcion'] ?? '')) ?></textarea>
                <div class="field-hint">Descripción detallada que aparece en la página del producto.</div>
            </div>
        </div>

        <!-- ── SECCIÓN 3: PRECIO Y ESTADO ── -->
        <div class="form-section-title"><i class="fas fa-tag me-1"></i>Precio y estado</div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6">
                <label for="precio_dolar" class="form-label">
                    Precio en dólares (USD)
                    <span style="background:rgba(5,150,105,0.1);color:#059669;font-size:0.68rem;font-weight:700;
                                 padding:1px 7px;border-radius:50px;margin-left:6px;vertical-align:middle;">
                        <i class="fas fa-dollar-sign" style="font-size:0.6rem;"></i> Precio base
                    </span>
                </label>
                <div class="input-group">
                    <span style="background:#f9fafb;border:1.5px solid #e5e7eb;border-right:none;
                                 border-radius:9px 0 0 9px;padding:0.6rem 0.85rem;font-size:0.9rem;
                                 font-weight:600;color:#059669;">USD</span>
                    <input type="number" id="precio_dolar" name="precio_dolar"
                           class="form-control" style="border-radius:0 9px 9px 0;"
                           value="<?= esc(old('precio_dolar', $producto['precio_dolar'] ?? '')) ?>"
                           min="0" step="0.01"
                           placeholder="Ej: 150.00">
                </div>
                <div class="field-hint">
                    <i class="fas fa-sync-alt me-1" style="color:#059669;"></i>
                    Al actualizar la cotización en <a href="<?= base_url('admin/configuracion') ?>" style="color:#FF0033;">Configuración</a>,
                    el precio en pesos se recalcula automáticamente.
                </div>
            </div>

            <div class="col-12 col-sm-6">
                <label for="precio_texto" class="form-label">Precio mostrado al público</label>
                <input type="text" id="precio_texto" name="precio_texto" class="form-control"
                       value="<?= esc(old('precio_texto', $producto['precio_texto'] ?? '')) ?>"
                       placeholder="Ej: $85.000  —  o dejalo vacío para 'Consultar precio'">
                <div class="field-hint">
                    Se actualiza automáticamente si tiene precio en USD. También podés editarlo manualmente.
                </div>
            </div>

            <div class="col-12 col-sm-6">
                <label for="badge" class="form-label">Etiqueta destacada</label>
                <?php
                    $badgeActual = old('badge', $producto['badge'] ?? '');
                    $badgesOpciones = ['', 'Nuevo', 'Destacado', 'Más vendido', 'Oferta', 'Recomendado', 'Premium'];
                    $esPersonalizado = !in_array($badgeActual, $badgesOpciones);
                ?>
                <select id="badge_select" class="form-select" onchange="cambiarBadge(this.value)">
                    <option value="">Sin etiqueta</option>
                    <option value="Nuevo"        <?= $badgeActual === 'Nuevo'        ? 'selected' : '' ?>>Nuevo</option>
                    <option value="Destacado"    <?= $badgeActual === 'Destacado'    ? 'selected' : '' ?>>Destacado</option>
                    <option value="Más vendido"  <?= $badgeActual === 'Más vendido'  ? 'selected' : '' ?>>Más vendido</option>
                    <option value="Oferta"       <?= $badgeActual === 'Oferta'       ? 'selected' : '' ?>>Oferta</option>
                    <option value="Recomendado"  <?= $badgeActual === 'Recomendado'  ? 'selected' : '' ?>>Recomendado</option>
                    <option value="Premium"      <?= $badgeActual === 'Premium'      ? 'selected' : '' ?>>Premium</option>
                    <option value="_custom"      <?= $esPersonalizado && $badgeActual !== '' ? 'selected' : '' ?>>Personalizada...</option>
                </select>
                <input type="hidden" id="badge" name="badge" value="<?= esc($badgeActual) ?>">
                <input type="text" id="badge_custom" class="form-control mt-2"
                       placeholder="Escribí la etiqueta personalizada"
                       value="<?= $esPersonalizado && $badgeActual !== '' ? esc($badgeActual) : '' ?>"
                       style="display:<?= $esPersonalizado && $badgeActual !== '' ? '' : 'none' ?>;">
                <div class="field-hint">
                    Aparece como una pequeña etiqueta de color sobre la tarjeta del producto.
                    <?php if ($badgeActual): ?>
                        <span class="badge-preview"><?= esc($badgeActual) ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-12">
                <div class="form-check form-switch" style="margin:0.25rem 0 0;">
                    <input class="form-check-input" type="checkbox" id="activo" name="activo" value="1"
                           <?= old('activo', $producto['activo'] ?? 1) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="activo"
                           style="font-size:0.9rem;font-weight:600;color:#374151;cursor:pointer;">
                        Mostrar este producto en el catálogo
                    </label>
                </div>
                <div class="field-hint" style="margin-left:2.5rem;">
                    Si está desactivado, el producto no aparece para los visitantes del sitio.
                </div>
            </div>

        </div>

        <!-- ── SECCIÓN 3b: UBICACIÓN FÍSICA Y STOCK ── -->
        <div class="form-section-title"><i class="fas fa-warehouse me-1"></i>Ubicación física y stock</div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-6">
                <label for="ubicacion" class="form-label">¿Dónde está el producto?</label>
                <?php $ubicacionActual = old('ubicacion', $producto['ubicacion'] ?? ''); ?>
                <select id="ubicacion" name="ubicacion" class="form-select">
                    <option value="">— Sin ubicación asignada —</option>
                    <option value="En el negocio"       <?= $ubicacionActual === 'En el negocio'       ? 'selected' : '' ?>>En el negocio</option>
                    <option value="Deposito nuevo local" <?= $ubicacionActual === 'Deposito nuevo local' ? 'selected' : '' ?>>Deposito nuevo local</option>
                    <option value="Deposito quincho"    <?= $ubicacionActual === 'Deposito quincho'    ? 'selected' : '' ?>>Deposito quincho</option>
                    <option value="Deposito casa"       <?= $ubicacionActual === 'Deposito casa'       ? 'selected' : '' ?>>Deposito casa</option>
                </select>
                <div class="field-hint">
                    <i class="fas fa-lock me-1" style="color:#9CA3AF;"></i>
                    Solo visible para el administrador. No aparece en el catálogo público.
                </div>
            </div>

            <div class="col-12 col-md-6">
                <label for="stock" class="form-label">
                    Cantidad en stock
                </label>
                <input type="number" id="stock" name="stock" class="form-control"
                       min="0" step="1"
                       value="<?= esc(old('stock', $producto['stock'] ?? 0)) ?>"
                       placeholder="0">
                <div class="field-hint">
                    <i class="fas fa-lock me-1" style="color:#9CA3AF;"></i>
                    Solo visible para el administrador. No aparece en el catálogo público.
                </div>
            </div>
        </div>

        <!-- ── SECCIÓN 3c: VISIBILIDAD ── -->
        <div class="form-section-title"><i class="fas fa-map-marker-alt me-1"></i>¿Dónde destacar este producto?</div>

        <div class="secciones-hint">
            <i class="fas fa-info-circle me-1" style="color:#FF0033;"></i>
            <strong>Importante:</strong> la opción "Mostrar en catálogo" de arriba es el interruptor principal — si está desactivado el producto no aparece en ningún lado.
            Estas opciones permiten elegir en qué secciones del sitio se destacará el producto cuando esté activo.
        </div>

        <?php
        // Labels y descripciones personalizadas por slug
        $seccionInfo = [
            'inicio'   => [
                'icono' => 'fas fa-home',
                'label' => 'Página principal',
                'desc'  => 'El producto aparece en el carrusel de la página de inicio del sitio.',
            ],
            'catalogo' => [
                'icono' => 'fas fa-th-large',
                'label' => 'Catálogo',
                'desc'  => 'El producto aparece en la página del catálogo general, donde se ven todos los rubros (Informática, Muebles, Electrodomésticos, etc.).',
            ],
            'rubro'    => [
                'icono' => 'fas fa-folder-open',
                'label' => 'Rubro',
                'desc'  => 'El producto aparece en la página del rubro al que pertenece. Ej: si es de Informática, se muestra al entrar a esa sección.',
            ],
            'subrubro' => [
                'icono' => 'fas fa-tag',
                'label' => 'Subrubro',
                'desc'  => 'El producto aparece en la página del subrubro al que pertenece. Ej: si es de Accesorios, se muestra al navegar hasta ahí.',
            ],
        ];
        ?>

        <div class="secciones-grid mb-4">
            <?php foreach ($secciones as $sec): ?>
            <?php
                $estaActiva = in_array((int)$sec['id'], $seccionesActivas);
                $info = $seccionInfo[$sec['slug']] ?? [
                    'icono' => $sec['icono'],
                    'label' => $sec['nombre'],
                    'desc'  => $sec['descripcion'] ?? '',
                ];
            ?>
            <label class="seccion-item <?= $estaActiva ? 'activa' : '' ?>"
                   id="seccion-label-<?= $sec['id'] ?>"
                   onclick="toggleSeccion(<?= $sec['id'] ?>)">
                <input type="checkbox"
                       name="secciones[]"
                       value="<?= $sec['id'] ?>"
                       id="seccion-check-<?= $sec['id'] ?>"
                       <?= $estaActiva ? 'checked' : '' ?>>
                <span class="seccion-check-box"></span>
                <i class="<?= esc($info['icono']) ?> seccion-icon"></i>
                <span class="seccion-nombre"><?= esc($info['label']) ?></span>
                <span class="seccion-desc"><?= esc($info['desc']) ?></span>
            </label>
            <?php endforeach; ?>
        </div>

        <!-- ── SECCIÓN 4: IMÁGENES ── -->
        <div class="form-section-title"><i class="fas fa-images me-1"></i>Imágenes del producto</div>

        <?php if (!empty($imagenesActuales)): ?>
        <label class="form-label mb-2">Imágenes actuales</label>
        <div class="img-grid-actual mb-3" id="img-grid-actual">
            <?php foreach ($imagenesActuales as $img): ?>
            <div class="img-card-actual" id="imgcard-<?= $img['id'] ?>">
                <img src="<?= base_url(esc($img['ruta'])) ?>"
                     alt="<?= esc($img['alt_text'] ?? '') ?>"
                     class="img-thumb">
                <div class="img-card-body">
                    <?php if ($img['es_principal']): ?>
                    <span class="img-badge-principal">Principal</span>
                    <?php endif; ?>

                    <?php if (!$img['es_principal']): ?>
                    <button type="button" class="btn-set-principal"
                            onclick="setPrincipal(<?= $img['id'] ?>)">
                        <i class="fas fa-star me-1" style="color:#f59e0b;font-size:0.65rem;"></i>Principal
                    </button>
                    <?php endif; ?>

                    <button type="button"
                            class="btn-del-img"
                            id="btn-del-<?= $img['id'] ?>"
                            onclick="toggleEliminar(<?= $img['id'] ?>)">
                        <i class="fas fa-trash me-1"></i>Eliminar
                    </button>

                    <!-- se activa al marcar eliminar -->
                    <input type="hidden" name="eliminar_imagenes[]"
                           id="del-input-<?= $img['id'] ?>"
                           value="<?= $img['id'] ?>"
                           disabled>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <!-- hidden para imagen principal -->
        <input type="hidden" id="imagen_principal_id" name="imagen_principal_id" value="">
        <?php endif; ?>

        <label class="form-label">Agregar imágenes</label>
        <div class="img-upload-area" id="upload-area" onclick="document.getElementById('imagenesInput').click()">
            <i class="fas fa-cloud-arrow-up"></i>
            <span><strong>Hacé clic</strong> o arrastrá las imágenes aquí</span>
            <div class="field-hint mt-1">JPG, PNG o WebP · Máx. 3 MB por imagen · Podés subir varias a la vez</div>
        </div>
        <input type="file" id="imagenesInput" name="imagenes[]" multiple accept="image/*"
               style="display:none;">

        <div class="img-previews-nuevas" id="img-previews-nuevas"></div>

        <div class="mb-4"></div>

        <!-- ── BOTONES ── -->
        <div class="d-flex align-items-center gap-3 flex-wrap pt-2">
            <button type="submit" class="btn-guardar">
                <i class="fas fa-save"></i>
                <?= $producto ? 'Guardar cambios' : 'Agregar producto' ?>
            </button>
            <a href="<?= base_url('admin/productos') ?>" class="btn-cancelar">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>

    </form>
</div>

<script>
/* ─── Secciones de visibilidad ─── */
function toggleSeccion(seccionId) {
    const label    = document.getElementById('seccion-label-' + seccionId);
    const checkbox = document.getElementById('seccion-check-' + seccionId);
    if (!label || !checkbox) return;
    checkbox.checked = !checkbox.checked;
    label.classList.toggle('activa', checkbox.checked);
}

/* ─── Datos de jerarquía desde la BD ─── */
const JERARQUIA = <?= json_encode($jerarquia, JSON_UNESCAPED_UNICODE) ?>;

const initRubro  = '<?= esc($catPath['rubro']        ?? '') ?>';
const initSub    = '<?= esc($catPath['subrubro']     ?? '') ?>';
const initSubSub = '<?= esc($catPath['sub_subrubro'] ?? '') ?>';

const hiddenCatId    = document.getElementById('categoria_id');
const selRubro       = document.getElementById('sel_rubro');
const selSubrubro    = document.getElementById('sel_subrubro');
const selSubSub      = document.getElementById('sel_subsub');
const wrapSubSub     = document.getElementById('wrap-subsub');
const catConfirm     = document.getElementById('catConfirmacion');
const catNombreTxt   = document.getElementById('catNombreTexto');

/* ── Poblar el select de rubros ── */
Object.keys(JERARQUIA).forEach(function (slug) {
    const opt       = document.createElement('option');
    opt.value       = slug;
    opt.textContent = JERARQUIA[slug].nombre;
    if (slug === initRubro) opt.selected = true;
    selRubro.appendChild(opt);
});

function setCategoria(id, label) {
    hiddenCatId.value   = id ? String(id) : '';
    catNombreTxt.textContent = label || '';
    catConfirm.classList.toggle('visible', !!id);
}

function resetSubSub() {
    selSubSub.innerHTML  = '<option value="">— Seleccioná —</option>';
    wrapSubSub.style.display = 'none';
}

function poblarSubrubros(rubroSlug, seleccionarSub) {
    selSubrubro.innerHTML = '<option value="">— Seleccioná un subrubro —</option>';
    selSubrubro.disabled  = true;
    resetSubSub();
    setCategoria('', '');

    if (!rubroSlug || !JERARQUIA[rubroSlug]) return;

    const data = JERARQUIA[rubroSlug];
    data.subrubros.forEach(function (key, idx) {
        const opt       = document.createElement('option');
        opt.value       = key;
        opt.textContent = data.labels[idx];
        opt.dataset.id  = data.ids[idx];
        if (key === seleccionarSub) opt.selected = true;
        selSubrubro.appendChild(opt);
    });
    selSubrubro.disabled = false;

    if (seleccionarSub) {
        aplicarSubrubro(rubroSlug, seleccionarSub, initSubSub);
    }
}

function aplicarSubrubro(rubroSlug, subSlug, seleccionarSubSub) {
    resetSubSub();
    setCategoria('', '');

    if (!subSlug) return;

    const data = JERARQUIA[rubroSlug];
    if (!data) return;

    if (data.tieneSubSub && data.subSub[subSlug]) {
        /* Este subrubro tiene nivel 3 → mostrar tercer select */
        wrapSubSub.style.display = '';
        const subData = data.subSub[subSlug];
        subData.keys.forEach(function (key, idx) {
            const opt       = document.createElement('option');
            opt.value       = key;
            opt.textContent = subData.labels[idx];
            opt.dataset.id  = subData.ids[idx];
            if (key === seleccionarSubSub) opt.selected = true;
            selSubSub.appendChild(opt);
        });

        if (seleccionarSubSub) {
            const selOpt = selSubSub.querySelector('option[value="' + seleccionarSubSub + '"]');
            if (selOpt) setCategoria(selOpt.dataset.id, selOpt.textContent.trim());
        }
    } else {
        /* Nivel 2 es hoja → asignar directamente */
        const selOpt = selSubrubro.querySelector('option[value="' + subSlug + '"]');
        if (selOpt) setCategoria(selOpt.dataset.id, selOpt.textContent.trim());
    }
}

/* ── Eventos de los selects ── */
selRubro.addEventListener('change', function () {
    poblarSubrubros(this.value, '');
});

selSubrubro.addEventListener('change', function () {
    aplicarSubrubro(selRubro.value, this.value, '');
});

selSubSub.addEventListener('change', function () {
    if (!this.value) { setCategoria('', ''); return; }
    const selOpt = this.options[this.selectedIndex];
    setCategoria(selOpt.dataset.id, selOpt.textContent.trim());
});

/* ── Inicializar en modo edición ── */
if (initRubro) {
    poblarSubrubros(initRubro, initSub);
}

/* ─── Badge: select predefinido + campo personalizado ─── */
function cambiarBadge(valor) {
    const custom  = document.getElementById('badge_custom');
    const hidden  = document.getElementById('badge');
    if (valor === '_custom') {
        custom.style.display = '';
        hidden.value = custom.value;
        custom.focus();
    } else {
        custom.style.display = 'none';
        hidden.value = valor;
    }
}

document.getElementById('badge_custom').addEventListener('input', function () {
    document.getElementById('badge').value = this.value;
});

/* Inicializar badge al cargar */
(function () {
    const sel = document.getElementById('badge_select');
    if (sel.value === '_custom') {
        document.getElementById('badge_custom').style.display = '';
    }
})();

/* ─── Imágenes: eliminar / principal / preview nuevas ─── */
function toggleEliminar(id) {
    const card  = document.getElementById('imgcard-' + id);
    const input = document.getElementById('del-input-' + id);
    const btn   = document.getElementById('btn-del-' + id);
    const marked = card.classList.toggle('para-eliminar');
    input.disabled = !marked;
    btn.classList.toggle('activo', marked);
    btn.innerHTML = marked
        ? '<i class="fas fa-undo me-1"></i>Deshacer'
        : '<i class="fas fa-trash me-1"></i>Eliminar';
}

function setPrincipal(id) {
    document.getElementById('imagen_principal_id').value = id;
    document.querySelectorAll('.img-card-actual').forEach(function (card) {
        const badge  = card.querySelector('.img-badge-principal');
        const btnSet = card.querySelector('.btn-set-principal');
        const cardId = parseInt(card.id.replace('imgcard-', ''));
        if (cardId === id) {
            if (!badge) {
                const b = document.createElement('span');
                b.className   = 'img-badge-principal';
                b.textContent = 'Principal';
                card.querySelector('.img-card-body').prepend(b);
            }
            if (btnSet) btnSet.remove();
        } else {
            if (badge) badge.remove();
            if (!btnSet) {
                const b       = document.createElement('button');
                b.type        = 'button';
                b.className   = 'btn-set-principal';
                b.innerHTML   = '<i class="fas fa-star me-1" style="color:#f59e0b;font-size:0.65rem;"></i>Principal';
                b.onclick     = function () { setPrincipal(cardId); };
                const delBtn  = card.querySelector('.btn-del-img');
                card.querySelector('.img-card-body').insertBefore(b, delBtn);
            }
        }
    });
}

/* Drag-over visual */
(function () {
    const area = document.getElementById('upload-area');
    if (!area) return;
    area.addEventListener('dragover', function (e) { e.preventDefault(); area.classList.add('drag-over'); });
    area.addEventListener('dragleave', function () { area.classList.remove('drag-over'); });
    area.addEventListener('drop', function (e) {
        e.preventDefault();
        area.classList.remove('drag-over');
        agregarArchivos(e.dataTransfer.files);
    });
})();

/* Acumular archivos manualmente porque <input multiple> reemplaza al elegir de nuevo */
let archivosNuevos = [];

document.getElementById('imagenesInput').addEventListener('change', function () {
    const files = Array.from(this.files); // capture before clearing
    this.value = '';                       // reset so same file can be re-selected
    agregarArchivos(files);
});

function agregarArchivos(fileList) {
    Array.from(fileList).forEach(function (file) {
        if (!file.type.startsWith('image/')) return;
        archivosNuevos.push(file);
        renderPreviewNueva(file, archivosNuevos.length - 1);
    });
    sincronizarInput();
}

function renderPreviewNueva(file, idx) {
    const wrap = document.getElementById('img-previews-nuevas');
    const div  = document.createElement('div');
    div.className   = 'img-preview-nueva';
    div.id          = 'prev-nueva-' + idx;
    const reader    = new FileReader();
    reader.onload   = function (e) {
        div.innerHTML = '<img src="' + e.target.result + '" alt="">'
            + '<button type="button" class="rm-preview" onclick="quitarPreview(' + idx + ')">'
            + '<i class="fas fa-times"></i></button>';
    };
    reader.readAsDataURL(file);
    wrap.appendChild(div);
}

function quitarPreview(idx) {
    archivosNuevos[idx] = null;
    const el = document.getElementById('prev-nueva-' + idx);
    if (el) el.remove();
    sincronizarInput();
}

function sincronizarInput() {
    const input = document.getElementById('imagenesInput');
    const dt    = new DataTransfer();
    archivosNuevos.forEach(function (f) { if (f) dt.items.add(f); });
    input.files = dt.files;
}
</script>

<?= $this->endSection() ?>
