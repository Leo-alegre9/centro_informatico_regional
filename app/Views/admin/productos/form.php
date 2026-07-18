<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<div class="flex items-center gap-3 mb-6">
    <a href="<?= base_url('admin/productos') ?>" class="text-gray-500 no-underline flex items-center gap-1 transition-colors hover:text-rojo">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h2 class="text-[1.35rem] font-bold text-dark m-0">
        <i class="fas fa-<?= $producto ? 'pen' : 'plus-circle' ?> mr-2 text-rojo text-[1.05rem]"></i>
        <?= $producto ? 'Editar producto' : 'Agregar nuevo producto' ?>
    </h2>
</div>

<?php $errors = session()->getFlashdata('errors'); ?>
<?php if ($errors): ?>
<div class="bg-rojo/5 border border-rojo/20 rounded-[10px] px-5 py-4 mb-3 text-[0.88rem] text-red-600">
    <strong><i class="fas fa-exclamation-triangle mr-1"></i>Corregí los siguientes errores:</strong>
    <ul class="list-disc mt-2 pl-5"><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
</div>
<?php endif; ?>

<div class="bg-white border border-gray-200 rounded-[14px] p-8 shadow-[0_1px_4px_rgba(0,0,0,0.05)] max-w-[820px]">
    <form action="<?= esc($accion) ?>" method="POST" enctype="multipart/form-data">

        <!-- Campo oculto con el ID de la categoría seleccionada -->
        <input type="hidden" id="categoria_id" name="categoria_id"
               value="<?= esc(old('categoria_id', $producto['categoria_id'] ?? '')) ?>">

        <!-- ── SECCIÓN 1: CATEGORÍA ── -->
        <div class="text-[0.72rem] font-bold uppercase tracking-[0.9px] text-gray-400 mb-4 pb-2 border-b border-gray-100"><i class="fas fa-sitemap mr-1"></i>¿A qué categoría pertenece?</div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-2">
            <div>
                <label for="sel_rubro" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">
                    Rubro <span class="text-rojo">*</span>
                </label>
                <select id="sel_rubro" class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]">
                    <option value="">— Seleccioná un rubro —</option>
                </select>
            </div>

            <div>
                <label for="sel_subrubro" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">
                    Subrubro <span class="text-rojo">*</span>
                </label>
                <select id="sel_subrubro" disabled
                        class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)] disabled:bg-gray-50 disabled:text-gray-400 disabled:cursor-not-allowed">
                    <option value="">— Primero elegí el rubro —</option>
                </select>
            </div>

            <div id="wrap-subsub" class="hidden">
                <label for="sel_subsub" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">Subcategoría</label>
                <select id="sel_subsub" class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]">
                    <option value="">— Seleccioná —</option>
                </select>
            </div>
        </div>

        <div id="catConfirmacion" class="hidden items-center gap-[0.6rem] bg-emerald-500/[0.07] border border-emerald-500/25 rounded-lg px-[0.9rem] py-[0.55rem] mt-3 text-[0.85rem] text-emerald-800">
            <i class="fas fa-check-circle text-emerald-500 text-[0.9rem]"></i>
            <span>Categoría: <strong id="catNombreTexto"></strong></span>
        </div>

        <div class="mb-4"></div>

        <!-- ── SECCIÓN 1b: MARCA Y FÁBRICA ── -->
        <div class="text-[0.72rem] font-bold uppercase tracking-[0.9px] text-gray-400 mb-4 pb-2 border-b border-gray-100"><i class="fas fa-tag mr-1"></i>Marca y fábrica</div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
            <div>
                <label for="marca_id" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">Marca del producto</label>
                <select id="marca_id" name="marca_id" class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]">
                    <option value="">— Sin marca / Genérico —</option>
                    <?php foreach ($marcas as $m): ?>
                        <option value="<?= $m['id'] ?>"
                            <?= old('marca_id', $producto['marca_id'] ?? '') == $m['id'] ? 'selected' : '' ?>>
                            <?= esc($m['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="text-xs text-gray-400 mt-[0.2rem]">Seleccioná la marca fabricante del producto.</div>
            </div>

            <div>
                <label for="fabrica_id" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">
                    Fábrica <span id="fabrica_requerida" class="text-rojo hidden">*</span>
                </label>
                <select id="fabrica_id" name="fabrica_id" class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]">
                    <option value="">— Sin fábrica —</option>
                    <?php foreach ($fabricas as $f): ?>
                        <option value="<?= $f['id'] ?>"
                            <?= old('fabrica_id', $producto['fabrica_id'] ?? '') == $f['id'] ? 'selected' : '' ?>>
                            <?= esc($f['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="text-xs text-gray-400 mt-[0.2rem]" id="fabrica_hint">
                    Obligatorio para productos del rubro Muebles.
                    <a href="<?= base_url('admin/fabricas/crear') ?>" target="_blank" class="text-rojo">Agregar fábrica</a>.
                </div>
            </div>
        </div>

        <!-- ── SECCIÓN 2: DATOS DEL PRODUCTO ── -->
        <div class="text-[0.72rem] font-bold uppercase tracking-[0.9px] text-gray-400 mb-4 pb-2 border-b border-gray-100"><i class="fas fa-box mr-1"></i>Información del producto</div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
            <div class="sm:col-span-2">
                <label for="nombre" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">
                    Nombre del producto <span class="text-rojo">*</span>
                </label>
                <input type="text" id="nombre" name="nombre"
                       class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]"
                       value="<?= esc(old('nombre', $producto['nombre'] ?? '')) ?>"
                       placeholder="Ej: Teclado Mecánico RGB, Heladera No Frost 420L" required>
            </div>

            <div>
                <label for="modelo" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">Modelo / SKU</label>
                <input type="text" id="modelo" name="modelo"
                       class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]"
                       value="<?= esc(old('modelo', $producto['modelo'] ?? '')) ?>"
                       placeholder="Ej: MX Keys, G915, GTX-3090-TI" maxlength="200">
                <div class="text-xs text-gray-400 mt-[0.2rem]">Número de modelo o código del fabricante (opcional).</div>
            </div>

            <div>
                <label for="codigo" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">
                    Código interno
                    <span class="inline-block bg-indigo-500/10 text-indigo-600 text-[0.68rem] font-bold px-[7px] py-px rounded-full ml-1.5 align-middle">
                        <i class="fas fa-lock text-[0.6rem]"></i> Solo admin
                    </span>
                </label>
                <input type="text" id="codigo" name="codigo"
                       class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]"
                       value="<?= esc(old('codigo', $producto['codigo'] ?? '')) ?>"
                       placeholder="Ej: CIR-0042, PROD-2024-001" maxlength="100">
                <div class="text-xs text-gray-400 mt-[0.2rem]">
                    <i class="fas fa-lock mr-1 text-gray-400"></i>
                    Código único para identificar el producto internamente. No aparece en el catálogo.
                </div>
            </div>

            <div class="sm:col-span-2">
                <label for="descripcion_corta" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">Descripción breve</label>
                <input type="text" id="descripcion_corta" name="descripcion_corta"
                       class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]"
                       value="<?= esc(old('descripcion_corta', $producto['descripcion_corta'] ?? '')) ?>"
                       placeholder="Una línea que resume el producto (aparece en las tarjetas del catálogo)"
                       maxlength="500">
                <div class="text-xs text-gray-400 mt-[0.2rem]">Máximo 500 caracteres. Se muestra en las tarjetas del catálogo.</div>
            </div>

            <div class="sm:col-span-2">
                <label for="descripcion" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">Descripción completa</label>
                <textarea id="descripcion" name="descripcion"
                          class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)] min-h-[95px] resize-y"
                          placeholder="Características, especificaciones técnicas, materiales, colores disponibles..."><?= esc(old('descripcion', $producto['descripcion'] ?? '')) ?></textarea>
                <div class="text-xs text-gray-400 mt-[0.2rem]">Descripción detallada que aparece en la página del producto.</div>
            </div>

            <div class="sm:col-span-2">
                <label for="url_fabricante" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">
                    Sitio web del fabricante
                    <span class="inline-block bg-indigo-500/10 text-indigo-600 text-[0.68rem] font-bold px-[7px] py-px rounded-full ml-1.5 align-middle">
                        <i class="fas fa-lock text-[0.6rem]"></i> Solo admin
                    </span>
                </label>
                <div class="flex">
                    <span class="flex items-center bg-gray-50 border-[1.5px] border-r-0 border-gray-200 rounded-l-[9px] px-[0.85rem] text-[0.9rem] text-gray-400">
                        <i class="fas fa-link"></i>
                    </span>
                    <input type="url" id="url_fabricante" name="url_fabricante"
                           class="border-[1.5px] border-gray-200 rounded-r-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full flex-1 focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]"
                           value="<?= esc(old('url_fabricante', $producto['url_fabricante'] ?? '')) ?>"
                           placeholder="https://www.fabricante.com">
                </div>
                <div class="text-xs text-gray-400 mt-[0.2rem]">
                    <i class="fas fa-lock mr-1 text-gray-400"></i>
                    Opcional. URL del sitio oficial del fabricante para consultar especificaciones o soporte. No aparece en el catálogo público.
                </div>
            </div>
        </div>

        <!-- ── SECCIÓN 3: PRECIO Y ESTADO ── -->
        <div class="text-[0.72rem] font-bold uppercase tracking-[0.9px] text-gray-400 mb-4 pb-2 border-b border-gray-100"><i class="fas fa-tag mr-1"></i>Precio y estado</div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
            <div>
                <label for="precio_dolar" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">
                    Precio en dólares (USD)
                    <span class="inline-block bg-emerald-600/10 text-emerald-600 text-[0.68rem] font-bold px-[7px] py-px rounded-full ml-1.5 align-middle">
                        <i class="fas fa-dollar-sign text-[0.6rem]"></i> Precio base
                    </span>
                </label>
                <div class="flex">
                    <span class="flex items-center bg-gray-50 border-[1.5px] border-r-0 border-gray-200 rounded-l-[9px] px-[0.85rem] text-[0.9rem] font-semibold text-emerald-600">USD</span>
                    <input type="number" id="precio_dolar" name="precio_dolar"
                           class="border-[1.5px] border-gray-200 rounded-r-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full flex-1 focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]"
                           value="<?= esc(old('precio_dolar', $producto['precio_dolar'] ?? '')) ?>"
                           min="0" step="0.01"
                           placeholder="Ej: 150.00">
                </div>
                <div class="text-xs text-gray-400 mt-[0.2rem]">
                    <i class="fas fa-sync-alt mr-1 text-emerald-600"></i>
                    Al actualizar la cotización en <a href="<?= base_url('admin/configuracion') ?>" class="text-rojo">Configuración</a>,
                    el precio en pesos se recalcula automáticamente.
                </div>
            </div>

            <div>
                <label for="precio_texto" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">Precio mostrado al público</label>
                <input type="text" id="precio_texto" name="precio_texto"
                       class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]"
                       value="<?= esc(old('precio_texto', $producto['precio_texto'] ?? '')) ?>"
                       placeholder="Ej: $85.000  —  o dejalo vacío para 'Consultar precio'">
                <div class="text-xs text-gray-400 mt-[0.2rem]">
                    Se actualiza automáticamente si tiene precio en USD. También podés editarlo manualmente.
                </div>
            </div>

            <div>
                <label for="badge_select" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">Etiqueta destacada</label>
                <?php
                    $badgeActual = old('badge', $producto['badge'] ?? '');
                    $badgesOpciones = ['', 'Nuevo', 'Destacado', 'Más vendido', 'Oferta', 'Recomendado', 'Premium'];
                    $esPersonalizado = !in_array($badgeActual, $badgesOpciones);
                ?>
                <select id="badge_select" onchange="cambiarBadge(this.value)"
                        class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]">
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
                <input type="text" id="badge_custom"
                       class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full mt-2 focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)] <?= ($esPersonalizado && $badgeActual !== '') ? '' : 'hidden' ?>"
                       placeholder="Escribí la etiqueta personalizada"
                       value="<?= $esPersonalizado && $badgeActual !== '' ? esc($badgeActual) : '' ?>">
                <div class="text-xs text-gray-400 mt-[0.2rem]">
                    Aparece como una pequeña etiqueta de color sobre la tarjeta del producto.
                    <?php if ($badgeActual): ?>
                        <span class="inline-block bg-rojo/[0.08] text-rojo px-[0.6rem] py-[0.15rem] rounded-full text-[0.78rem] font-semibold ml-2 align-middle"><?= esc($badgeActual) ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="sm:col-span-2">
                <label class="relative inline-flex items-center cursor-pointer mt-1">
                    <input type="checkbox" id="activo" name="activo" value="1" class="sr-only peer"
                           <?= old('activo', $producto['activo'] ?? 1) ? 'checked' : '' ?>>
                    <span class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-rojo transition-colors relative
                                 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5"></span>
                    <span class="ml-3 text-[0.9rem] font-semibold text-gray-700">Mostrar este producto en el catálogo</span>
                </label>
                <div class="text-xs text-gray-400 mt-[0.2rem] ml-[3.5rem]">
                    Si está desactivado, el producto no aparece para los visitantes del sitio.
                </div>
            </div>

        </div>

        <!-- ── SECCIÓN 3b: UBICACIÓN FÍSICA Y STOCK ── -->
        <div class="text-[0.72rem] font-bold uppercase tracking-[0.9px] text-gray-400 mb-4 pb-2 border-b border-gray-100"><i class="fas fa-warehouse mr-1"></i>Ubicación física y stock</div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
            <div>
                <label for="ubicacion" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">¿Dónde está el producto?</label>
                <?php $ubicacionActual = old('ubicacion', $producto['ubicacion'] ?? ''); ?>
                <select id="ubicacion" name="ubicacion"
                        class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]">
                    <option value="">— Sin ubicación asignada —</option>
                    <option value="En el negocio"       <?= $ubicacionActual === 'En el negocio'       ? 'selected' : '' ?>>En el negocio</option>
                    <option value="Deposito nuevo local" <?= $ubicacionActual === 'Deposito nuevo local' ? 'selected' : '' ?>>Deposito nuevo local</option>
                    <option value="Deposito quincho"    <?= $ubicacionActual === 'Deposito quincho'    ? 'selected' : '' ?>>Deposito quincho</option>
                    <option value="Deposito casa"       <?= $ubicacionActual === 'Deposito casa'       ? 'selected' : '' ?>>Deposito casa</option>
                </select>
                <div class="text-xs text-gray-400 mt-[0.2rem]">
                    <i class="fas fa-lock mr-1 text-gray-400"></i>
                    Solo visible para el administrador. No aparece en el catálogo público.
                </div>
            </div>

            <div>
                <label for="stock" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">
                    Cantidad en stock
                </label>
                <input type="number" id="stock" name="stock"
                       class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]"
                       min="0" step="1"
                       value="<?= esc(old('stock', $producto['stock'] ?? 0)) ?>"
                       placeholder="0">
                <div class="text-xs text-gray-400 mt-[0.2rem]">
                    <i class="fas fa-lock mr-1 text-gray-400"></i>
                    Solo visible para el administrador. No aparece en el catálogo público.
                </div>
            </div>
        </div>

        <!-- ── SECCIÓN 3c: VISIBILIDAD ── -->
        <div class="text-[0.72rem] font-bold uppercase tracking-[0.9px] text-gray-400 mb-4 pb-2 border-b border-gray-100"><i class="fas fa-map-marker-alt mr-1"></i>¿Dónde destacar este producto?</div>

        <div class="text-[0.8rem] text-gray-500 mb-[0.85rem] leading-normal bg-gray-50 rounded-lg px-[0.9rem] py-[0.6rem] border-l-[3px] border-rojo">
            <i class="fas fa-info-circle mr-1 text-rojo"></i>
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
            'carrusel_promo' => [
                'icono' => 'fas fa-percent',
                'label' => 'En oferta',
                'desc'  => 'Aparece en la sección Promociones del inicio y en la página de Promociones.',
            ],
        ];
        ?>

        <div class="grid gap-3 mb-4" style="grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));">
            <?php foreach ($secciones as $sec): ?>
            <?php
                $estaActiva = in_array((int)$sec['id'], $seccionesActivas);
                $info = $seccionInfo[$sec['slug']] ?? [
                    'icono' => $sec['icono'],
                    'label' => $sec['nombre'],
                    'desc'  => $sec['descripcion'] ?? '',
                ];
            ?>
            <label class="group relative border-[1.5px] border-gray-200 rounded-[10px] px-[0.85rem] py-[0.9rem] cursor-pointer select-none transition-all bg-white hover:border-rojo hover:bg-red-50 data-[active=true]:border-rojo data-[active=true]:bg-rojo/[0.04] data-[active=true]:shadow-[0_0_0_3px_rgba(255,0,51,0.08)]"
                   id="seccion-label-<?= $sec['id'] ?>"
                   data-active="<?= $estaActiva ? 'true' : 'false' ?>"
                   onclick="toggleSeccion(<?= $sec['id'] ?>)">
                <input type="checkbox"
                       name="secciones[]"
                       value="<?= $sec['id'] ?>"
                       id="seccion-check-<?= $sec['id'] ?>"
                       class="hidden"
                       <?= $estaActiva ? 'checked' : '' ?>>
                <span class="absolute top-[0.7rem] right-[0.7rem] w-[17px] h-[17px] border-2 border-gray-300 rounded-[4px] bg-white flex items-center justify-center transition-colors
                             group-data-[active=true]:border-rojo group-data-[active=true]:bg-rojo
                             after:content-[''] after:block after:w-1 after:h-[7px] after:border-r-2 after:border-b-2 after:border-transparent after:[transform:rotate(45deg)_translate(-1px,-1px)]
                             group-data-[active=true]:after:border-white"></span>
                <i class="<?= esc($info['icono']) ?> block mb-[0.45rem] text-[1.4rem] text-gray-300 transition-colors group-data-[active=true]:text-rojo"></i>
                <span class="font-semibold text-[0.84rem] text-gray-700 block"><?= esc($info['label']) ?></span>
                <span class="text-[0.72rem] text-gray-400 block mt-1 leading-[1.35]"><?= esc($info['desc']) ?></span>
            </label>
            <?php endforeach; ?>
        </div>

        <!-- ── SECCIÓN 4: IMÁGENES ── -->
        <div class="text-[0.72rem] font-bold uppercase tracking-[0.9px] text-gray-400 mb-4 pb-2 border-b border-gray-100"><i class="fas fa-images mr-1"></i>Imágenes del producto</div>

        <?php if (!empty($imagenesActuales)): ?>
        <label class="text-[0.85rem] font-semibold text-gray-700 mb-2 block">Imágenes actuales</label>
        <div class="flex flex-wrap gap-[0.85rem] mb-3" id="img-grid-actual">
            <?php foreach ($imagenesActuales as $img): ?>
            <div class="w-[140px] border-[1.5px] border-gray-200 rounded-xl overflow-hidden bg-gray-50 flex flex-col relative transition-all data-[marked=true]:opacity-[0.35] data-[marked=true]:border-red-300"
                 id="imgcard-<?= $img['id'] ?>" data-marked="false">
                <img src="<?= base_url(esc($img['ruta'])) ?>"
                     alt="<?= esc($img['alt_text'] ?? '') ?>"
                     class="w-full h-[110px] object-cover block">
                <div class="px-2 pb-2 pt-[0.45rem] flex flex-col gap-[5px]">
                    <?php if ($img['es_principal']): ?>
                    <span class="img-badge-principal inline-block bg-rojo/10 text-rojo text-[0.67rem] font-bold px-[7px] py-[2px] rounded-full uppercase tracking-[0.4px] w-fit">Principal</span>
                    <?php endif; ?>

                    <?php if (!$img['es_principal']): ?>
                    <button type="button" class="btn-set-principal text-[0.72rem] font-semibold text-gray-700 bg-white border-[1.5px] border-gray-200 rounded-md px-[7px] py-[3px] cursor-pointer transition-colors text-center w-full hover:border-rojo hover:text-rojo"
                            onclick="setPrincipal(<?= $img['id'] ?>)">
                        <i class="fas fa-star mr-1 text-amber-500 text-[0.65rem]"></i>Principal
                    </button>
                    <?php endif; ?>

                    <button type="button"
                            class="btn-del-img text-[0.72rem] font-semibold rounded-md px-[7px] py-[3px] cursor-pointer transition-colors text-center w-full border-[1.5px] text-gray-400 bg-white border-gray-200 hover:border-red-300 hover:text-red-600 data-[marked=true]:text-red-600 data-[marked=true]:border-red-300 data-[marked=true]:bg-red-50"
                            id="btn-del-<?= $img['id'] ?>"
                            data-marked="false"
                            onclick="toggleEliminar(<?= $img['id'] ?>)">
                        <i class="fas fa-trash mr-1"></i>Eliminar
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

        <label class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">Agregar imágenes</label>
        <div class="border-2 border-dashed border-gray-200 rounded-xl bg-gray-50 p-6 text-center cursor-pointer transition-colors hover:border-rojo hover:bg-red-50 data-[drag=true]:border-rojo data-[drag=true]:bg-red-50"
             id="upload-area" data-drag="false" onclick="document.getElementById('imagenesInput').click()">
            <i class="fas fa-cloud-arrow-up text-3xl text-gray-300 block mb-2"></i>
            <span class="text-[0.84rem] text-gray-400"><strong class="text-gray-700">Hacé clic</strong> o arrastrá las imágenes aquí</span>
            <div class="text-xs text-gray-400 mt-1">JPG, PNG o WebP · Máx. 3 MB por imagen · Podés subir varias a la vez</div>
        </div>
        <input type="file" id="imagenesInput" name="imagenes[]" multiple accept="image/*" class="hidden">

        <div class="flex flex-wrap gap-3 mt-[0.9rem]" id="img-previews-nuevas"></div>

        <div class="mb-4"></div>

        <!-- ── BOTONES ── -->
        <div class="flex items-center gap-3 flex-wrap pt-2">
            <button type="submit" class="bg-rojo text-white border-none px-8 py-[0.7rem] rounded-full text-[0.95rem] font-semibold inline-flex items-center gap-[0.45rem] cursor-pointer transition-colors hover:bg-rojo-dark">
                <i class="fas fa-save"></i>
                <?= $producto ? 'Guardar cambios' : 'Agregar producto' ?>
            </button>
            <a href="<?= base_url('admin/productos') ?>" class="text-gray-500 no-underline px-6 py-[0.7rem] rounded-full text-[0.95rem] font-semibold inline-flex items-center gap-2 border-[1.5px] border-gray-200 transition-colors hover:bg-gray-100 hover:text-gray-700">
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
    label.dataset.active = checkbox.checked ? 'true' : 'false';
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
const selFabrica     = document.getElementById('fabrica_id');
const fabricaAsterisco = document.getElementById('fabrica_requerida');

/* ── Poblar el select de rubros ── */
Object.keys(JERARQUIA).forEach(function (slug) {
    const opt       = document.createElement('option');
    opt.value       = slug;
    opt.textContent = JERARQUIA[slug].nombre;
    if (slug === initRubro) opt.selected = true;
    selRubro.appendChild(opt);
});

/* ── Fábrica obligatoria solo para el rubro Muebles ── */
function actualizarRequeridoFabrica() {
    const esMuebles = selRubro.value === 'muebles';
    fabricaAsterisco.classList.toggle('hidden', !esMuebles);
    selFabrica.required = esMuebles;
}

function setCategoria(id, label) {
    hiddenCatId.value   = id ? String(id) : '';
    catNombreTxt.textContent = label || '';
    const mostrar = !!id;
    catConfirm.classList.toggle('hidden', !mostrar);
    catConfirm.classList.toggle('flex', mostrar);
}

function resetSubSub() {
    selSubSub.innerHTML  = '<option value="">— Seleccioná —</option>';
    wrapSubSub.classList.add('hidden');
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
        wrapSubSub.classList.remove('hidden');
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
    actualizarRequeridoFabrica();
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
actualizarRequeridoFabrica();

/* ─── Badge: select predefinido + campo personalizado ─── */
function cambiarBadge(valor) {
    const custom  = document.getElementById('badge_custom');
    const hidden  = document.getElementById('badge');
    if (valor === '_custom') {
        custom.classList.remove('hidden');
        hidden.value = custom.value;
        custom.focus();
    } else {
        custom.classList.add('hidden');
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
        document.getElementById('badge_custom').classList.remove('hidden');
    }
})();

/* ─── Imágenes: eliminar / principal / preview nuevas ─── */
function toggleEliminar(id) {
    const card  = document.getElementById('imgcard-' + id);
    const input = document.getElementById('del-input-' + id);
    const btn   = document.getElementById('btn-del-' + id);
    const marked = card.dataset.marked !== 'true';
    card.dataset.marked = marked ? 'true' : 'false';
    input.disabled = !marked;
    btn.dataset.marked = marked ? 'true' : 'false';
    btn.innerHTML = marked
        ? '<i class="fas fa-undo mr-1"></i>Deshacer'
        : '<i class="fas fa-trash mr-1"></i>Eliminar';
}

function setPrincipal(id) {
    document.getElementById('imagen_principal_id').value = id;
    document.querySelectorAll('[id^="imgcard-"]').forEach(function (card) {
        const badge  = card.querySelector('.img-badge-principal');
        const btnSet = card.querySelector('.btn-set-principal');
        const cardId = parseInt(card.id.replace('imgcard-', ''));
        const body   = card.querySelector('div.flex.flex-col');
        if (cardId === id) {
            if (!badge) {
                const b = document.createElement('span');
                b.className   = 'img-badge-principal inline-block bg-rojo/10 text-rojo text-[0.67rem] font-bold px-[7px] py-[2px] rounded-full uppercase tracking-[0.4px] w-fit';
                b.textContent = 'Principal';
                body.prepend(b);
            }
            if (btnSet) btnSet.remove();
        } else {
            if (badge) badge.remove();
            if (!btnSet) {
                const b       = document.createElement('button');
                b.type        = 'button';
                b.className   = 'btn-set-principal text-[0.72rem] font-semibold text-gray-700 bg-white border-[1.5px] border-gray-200 rounded-md px-[7px] py-[3px] cursor-pointer transition-colors text-center w-full hover:border-rojo hover:text-rojo';
                b.innerHTML   = '<i class="fas fa-star mr-1 text-amber-500 text-[0.65rem]"></i>Principal';
                b.onclick     = function () { setPrincipal(cardId); };
                const delBtn  = card.querySelector('.btn-del-img');
                body.insertBefore(b, delBtn);
            }
        }
    });
}

/* Drag-over visual */
(function () {
    const area = document.getElementById('upload-area');
    if (!area) return;
    area.addEventListener('dragover', function (e) { e.preventDefault(); area.dataset.drag = 'true'; });
    area.addEventListener('dragleave', function () { area.dataset.drag = 'false'; });
    area.addEventListener('drop', function (e) {
        e.preventDefault();
        area.dataset.drag = 'false';
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
    div.className   = 'w-[100px] h-[100px] rounded-[10px] overflow-hidden border-[1.5px] border-gray-200 relative';
    div.id          = 'prev-nueva-' + idx;
    const reader    = new FileReader();
    reader.onload   = function (e) {
        div.innerHTML = '<img src="' + e.target.result + '" alt="" class="w-full h-full object-cover block">'
            + '<button type="button" class="absolute top-[3px] right-[3px] bg-black/[0.55] text-white border-none rounded-full w-5 h-5 text-[0.65rem] cursor-pointer flex items-center justify-center leading-none" onclick="quitarPreview(' + idx + ')">'
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
