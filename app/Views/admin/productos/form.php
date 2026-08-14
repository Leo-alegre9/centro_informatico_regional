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

<div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-[0_1px_4px_rgba(0,0,0,0.05)] max-w-[820px]">
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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
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

            <div id="wrap-linea" class="hidden">
                <label for="linea_id" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">
                    Línea <span class="text-gray-400 font-normal">(opcional)</span>
                </label>
                <select id="linea_id" name="linea_id" class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]">
                    <option value="">— Sin línea —</option>
                </select>
                <div class="text-xs text-gray-400 mt-[0.2rem]" id="linea_hint">
                    Línea de la fábrica seleccionada, si corresponde.
                    <a href="#" id="linea_admin_link" target="_blank" class="text-rojo">Gestionar líneas</a>.
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

            <div>
                <label for="slug" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">URL amigable (slug)</label>
                <input type="text" id="slug" name="slug"
                       class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]"
                       value="<?= esc(old('slug', $producto['slug'] ?? '')) ?>"
                       placeholder="Se genera automáticamente si lo dejás vacío" maxlength="220">
                <div class="text-xs text-gray-400 mt-[0.2rem]">Define la URL pública: <?= esc(base_url('producto/')) ?>&lt;slug&gt;. Si lo dejás vacío se genera solo a partir del nombre.</div>
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

        <!-- ── SECCIÓN 2b: MEDIDAS, MATERIAL Y COLORES ── -->
        <div class="text-[0.72rem] font-bold uppercase tracking-[0.9px] text-gray-400 mb-4 pb-2 border-b border-gray-100"><i class="fas fa-ruler-combined mr-1"></i>Medidas, material y colores</div>

        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 mb-4">
            <div>
                <label for="ancho" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">Ancho</label>
                <input type="number" id="ancho" name="ancho" min="0" step="0.01"
                       class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]"
                       value="<?= esc(old('ancho', $producto['ancho'] ?? '')) ?>" placeholder="Ej: 60">
            </div>
            <div>
                <label for="alto" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">Alto</label>
                <input type="number" id="alto" name="alto" min="0" step="0.01"
                       class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]"
                       value="<?= esc(old('alto', $producto['alto'] ?? '')) ?>" placeholder="Ej: 55">
            </div>
            <div>
                <label for="profundidad" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">Profundidad</label>
                <input type="number" id="profundidad" name="profundidad" min="0" step="0.01"
                       class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]"
                       value="<?= esc(old('profundidad', $producto['profundidad'] ?? '')) ?>" placeholder="Ej: 45">
            </div>
            <div>
                <label for="unidad_medida" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">Unidad</label>
                <?php $unidadActual = old('unidad_medida', $producto['unidad_medida'] ?? 'cm'); ?>
                <select id="unidad_medida" name="unidad_medida"
                        class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]">
                    <option value="cm" <?= $unidadActual === 'cm' ? 'selected' : '' ?>>cm</option>
                    <option value="mm" <?= $unidadActual === 'mm' ? 'selected' : '' ?>>mm</option>
                    <option value="m"  <?= $unidadActual === 'm'  ? 'selected' : '' ?>>m</option>
                    <option value="in" <?= $unidadActual === 'in' ? 'selected' : '' ?>>in</option>
                </select>
            </div>
            <div class="text-xs text-gray-400 -mt-2 sm:col-span-4">Dejá estos campos vacíos si el producto no tiene medidas relevantes (no se muestran en la ficha si están vacíos).</div>

            <div class="sm:col-span-2">
                <label for="material" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">Material</label>
                <input type="text" id="material" name="material"
                       class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]"
                       value="<?= esc(old('material', $producto['material'] ?? '')) ?>" placeholder="Ej: Melamina 15mm, Aluminio, Plástico ABS" maxlength="150">
            </div>

        </div>

        <!-- ── COLORES DISPONIBLES (muestras) ── -->
        <div class="text-[0.72rem] font-bold uppercase tracking-[0.9px] text-gray-400 mb-4 pb-2 border-b border-gray-100"><i class="fas fa-palette mr-1"></i>Colores disponibles</div>
        <div class="text-xs text-gray-400 -mt-2 mb-3">Cada variante es una muestra independiente (color simple, combinación de dos colores, o imagen/textura) que se muestra como cuadrado en la ficha pública del producto.</div>

        <div id="variantes-lista" class="flex flex-col gap-3 mb-2">
            <?php
                $variantesColor = $variantesColor ?? [];
                if (empty($variantesColor)) {
                    $variantesColor = [[
                        'id' => null, 'nombre' => '', 'tipo' => 'simple',
                        'color_primario' => '#ffffff', 'color_secundario' => '#000000',
                        'imagen_muestra' => null, 'orden' => 0, 'activo' => 1,
                    ]];
                }
            ?>
            <?php foreach ($variantesColor as $i => $v): ?>
                <?php
                    $tipoActual    = $v['tipo'] ?? 'simple';
                    $estiloPreview = \App\Models\ColorVarianteModel::estiloSwatch($v);
                    $imagenUrl     = !empty($v['imagen_muestra']) ? base_url($v['imagen_muestra']) : '';
                ?>
                <div class="variante-card border-[1.5px] border-gray-200 rounded-[12px] p-4 bg-gray-50/60" data-idx="<?= $i ?>">
                    <input type="hidden" name="variantes[<?= $i ?>][id]" value="<?= (int) ($v['id'] ?? 0) ?>">
                    <div class="flex gap-3 items-start flex-wrap">
                        <div class="shrink-0 flex flex-col items-center gap-1">
                            <div class="variante-preview w-[42px] h-[42px] rounded-[8px] border-[1.5px] border-gray-200 bg-white shrink-0"
                                 style="<?= esc($estiloPreview, 'attr') ?>" title="<?= esc($v['nombre'] ?? '') ?>"></div>
                            <span class="text-[0.62rem] text-gray-400">Vista previa</span>
                        </div>

                        <div class="flex-1 min-w-[220px] grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <div class="sm:col-span-2">
                                <label class="text-[0.78rem] font-semibold text-gray-600 mb-1 block">Nombre de la variante <span class="text-rojo">*</span></label>
                                <input type="text" name="variantes[<?= $i ?>][nombre]" value="<?= esc($v['nombre'] ?? '') ?>"
                                       class="variante-nombre border-[1.5px] border-gray-200 rounded-[8px] px-3 py-[0.45rem] text-[0.85rem] text-dark bg-white outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]"
                                       placeholder="Ej: Hickory / Blanco texturizado">
                            </div>

                            <div>
                                <label class="text-[0.78rem] font-semibold text-gray-600 mb-1 block">Tipo de muestra</label>
                                <select name="variantes[<?= $i ?>][tipo]" class="variante-tipo border-[1.5px] border-gray-200 rounded-[8px] px-3 py-[0.45rem] text-[0.85rem] text-dark bg-white outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]">
                                    <option value="simple"    <?= $tipoActual === 'simple'    ? 'selected' : '' ?>>Color simple</option>
                                    <option value="combinado" <?= $tipoActual === 'combinado' ? 'selected' : '' ?>>Combinación de dos colores</option>
                                    <option value="textura"   <?= $tipoActual === 'textura'   ? 'selected' : '' ?>>Imagen / textura</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-[0.78rem] font-semibold text-gray-600 mb-1 block">Orden</label>
                                <input type="number" name="variantes[<?= $i ?>][orden]" value="<?= (int) ($v['orden'] ?? 0) ?>" min="0" step="1"
                                       class="border-[1.5px] border-gray-200 rounded-[8px] px-3 py-[0.45rem] text-[0.85rem] text-dark bg-white outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]">
                            </div>

                            <div class="campo-color-primario">
                                <label class="text-[0.78rem] font-semibold text-gray-600 mb-1 block">Color primario</label>
                                <input type="color" name="variantes[<?= $i ?>][color_primario]" value="<?= esc(!empty($v['color_primario']) ? $v['color_primario'] : '#ffffff') ?>"
                                       class="variante-color-primario w-full h-9 border-[1.5px] border-gray-200 rounded-[8px] p-[2px] cursor-pointer">
                            </div>

                            <div class="campo-color-secundario <?= $tipoActual === 'combinado' ? '' : 'hidden' ?>">
                                <label class="text-[0.78rem] font-semibold text-gray-600 mb-1 block">Color secundario</label>
                                <input type="color" name="variantes[<?= $i ?>][color_secundario]" value="<?= esc(!empty($v['color_secundario']) ? $v['color_secundario'] : '#000000') ?>"
                                       class="variante-color-secundario w-full h-9 border-[1.5px] border-gray-200 rounded-[8px] p-[2px] cursor-pointer">
                            </div>

                            <div class="campo-imagen sm:col-span-2 <?= $tipoActual === 'textura' ? '' : 'hidden' ?>">
                                <label class="text-[0.78rem] font-semibold text-gray-600 mb-1 block">Imagen / textura</label>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <?php if ($imagenUrl): ?>
                                        <img src="<?= esc($imagenUrl) ?>" alt="" class="variante-imagen-actual w-9 h-9 rounded-[6px] object-cover border border-gray-200">
                                        <label class="text-[0.72rem] text-gray-500 inline-flex items-center gap-1 cursor-pointer">
                                            <input type="checkbox" name="variantes[<?= $i ?>][quitar_imagen]" value="1" class="variante-quitar-imagen">
                                            Quitar imagen actual
                                        </label>
                                    <?php endif; ?>
                                    <input type="file" name="variantes[<?= $i ?>][imagen]" accept="image/*" class="variante-imagen-input text-[0.8rem]">
                                </div>
                                <div class="text-xs text-gray-400 mt-1">JPG, PNG o WebP · Máx. 3 MB.</div>
                            </div>

                            <div class="galeria-color sm:col-span-2 border-t border-gray-200 pt-3 mt-1">
                                <label class="text-[0.78rem] font-semibold text-gray-600 mb-2 block">Imágenes de este color</label>
                                <input type="hidden" name="variantes[<?= $i ?>][galeria_principal]" class="galeria-principal-input" value="<?php
                                    $principalId = 0;
                                    foreach (($v['galeria'] ?? []) as $imgGal) {
                                        if (!empty($imgGal['es_principal'])) { $principalId = (int) $imgGal['id']; break; }
                                    }
                                    echo $principalId;
                                ?>">
                                <div class="galeria-existente-lista flex flex-wrap gap-2 mb-2">
                                    <?php foreach (($v['galeria'] ?? []) as $img): ?>
                                    <div class="galeria-img-item w-[92px]" data-id="<?= (int) $img['id'] ?>">
                                        <div class="relative w-[92px] h-[72px] rounded-[8px] overflow-hidden border-2 <?= !empty($img['es_principal']) ? 'border-rojo' : 'border-gray-200' ?>">
                                            <input type="hidden" name="variantes[<?= $i ?>][galeria_existente][]" value="<?= (int) $img['id'] ?>">
                                            <img src="<?= base_url(esc($img['imagen'])) ?>" alt="<?= esc($img['texto_alternativo'] ?? '') ?>" class="w-full h-full object-cover block">
                                            <span class="galeria-badge-principal absolute top-0 left-0 bg-rojo text-white text-[0.55rem] font-bold px-1 rounded-br-[6px] <?= !empty($img['es_principal']) ? '' : 'hidden' ?>"><i class="fas fa-star"></i></span>
                                        </div>
                                        <input type="text" name="variantes[<?= $i ?>][galeria_alt][<?= (int) $img['id'] ?>]" value="<?= esc($img['texto_alternativo'] ?? '') ?>"
                                               class="mt-1 w-full text-[0.65rem] border border-gray-200 rounded px-1 py-[2px] outline-none focus:border-rojo" placeholder="Texto alternativo">
                                        <div class="flex items-center justify-between mt-1">
                                            <button type="button" class="btn-galeria-principal text-gray-400 hover:text-amber-500 p-1" title="Marcar como principal"><i class="fas fa-star text-[0.7rem]"></i></button>
                                            <button type="button" class="btn-galeria-mover text-gray-400 hover:text-gray-700 p-1" data-dir="-1" title="Mover antes"><i class="fas fa-arrow-left text-[0.7rem]"></i></button>
                                            <button type="button" class="btn-galeria-mover text-gray-400 hover:text-gray-700 p-1" data-dir="1" title="Mover después"><i class="fas fa-arrow-right text-[0.7rem]"></i></button>
                                            <button type="button" class="btn-galeria-quitar text-gray-400 hover:text-red-600 p-1" title="Quitar imagen"><i class="fas fa-trash text-[0.7rem]"></i></button>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="galeria-nueva-lista flex flex-wrap gap-2 mb-2"></div>
                                <input type="file" name="variantes[<?= $i ?>][galeria_nueva][]" class="galeria-input-real hidden" multiple>
                                <label class="galeria-btn-agregar inline-flex items-center gap-2 text-[0.78rem] font-semibold text-rojo bg-rojo/[0.06] border-[1.5px] border-rojo/20 rounded-full px-3 py-[0.35rem] cursor-pointer transition-colors hover:bg-rojo/10">
                                    <i class="fas fa-images"></i> Agregar imágenes
                                    <input type="file" class="galeria-input-nueva hidden" accept="image/*" multiple>
                                </label>
                                <div class="text-xs text-gray-400 mt-1">JPG, PNG o WebP · Máx. 3 MB c/u. La marcada con estrella se muestra primero al elegir este color en la ficha pública.</div>
                            </div>

                            <div class="sm:col-span-2 flex items-center justify-between mt-1">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="variantes[<?= $i ?>][activo]" value="1" class="sr-only peer" <?= !empty($v['activo'] ?? 1) ? 'checked' : '' ?>>
                                    <span class="w-9 h-5 bg-gray-200 rounded-full peer-checked:bg-rojo transition-colors relative
                                                 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-4"></span>
                                    <span class="ml-2 text-[0.78rem] font-semibold text-gray-600">Activa</span>
                                </label>
                                <button type="button" class="btn-quitar-variante text-gray-400 hover:text-red-600 transition-colors w-8 h-8 flex items-center justify-center shrink-0" title="Quitar variante">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" id="btn-agregar-variante" class="text-[0.82rem] font-semibold text-rojo bg-rojo/[0.06] border-[1.5px] border-rojo/20 rounded-full px-4 py-[0.4rem] cursor-pointer transition-colors hover:bg-rojo/10">
            <i class="fas fa-plus mr-1"></i> Agregar color
        </button>

        <div class="mb-4"></div>

        <!-- ── SECCIÓN 2c: CARACTERÍSTICAS TÉCNICAS ── -->
        <div class="text-[0.72rem] font-bold uppercase tracking-[0.9px] text-gray-400 mb-4 pb-2 border-b border-gray-100"><i class="fas fa-list-ul mr-1"></i>Características técnicas</div>

        <div id="caract-filas" class="flex flex-col gap-2 mb-3">
            <?php $caracteristicasActuales = $caracteristicasActuales ?? []; ?>
            <?php if (empty($caracteristicasActuales)): $caracteristicasActuales = [['clave' => '', 'valor' => '']]; endif; ?>
            <?php foreach ($caracteristicasActuales as $car): ?>
            <div class="caract-fila flex gap-2 items-center">
                <input type="text" name="caracteristicas[clave][]" value="<?= esc($car['clave']) ?>"
                       class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.85rem] py-[0.5rem] text-[0.88rem] text-dark bg-white outline-none w-[38%] focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]"
                       placeholder="Ej: Color, Peso, Garantía">
                <input type="text" name="caracteristicas[valor][]" value="<?= esc($car['valor']) ?>"
                       class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.85rem] py-[0.5rem] text-[0.88rem] text-dark bg-white outline-none flex-1 focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]"
                       placeholder="Ej: Gris, 2.5kg, 12 meses">
                <button type="button" class="btn-quitar-caract text-gray-400 hover:text-red-600 transition-colors w-9 h-9 flex items-center justify-center shrink-0" title="Quitar fila" onclick="this.closest('.caract-fila').remove()">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="button" id="btn-agregar-caract" class="text-[0.82rem] font-semibold text-rojo bg-rojo/[0.06] border-[1.5px] border-rojo/20 rounded-full px-4 py-[0.4rem] cursor-pointer transition-colors hover:bg-rojo/10">
            <i class="fas fa-plus mr-1"></i> Agregar característica
        </button>

        <div class="mb-4"></div>

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
                <label for="precio_interno" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">
                    Precio interno (control)
                    <span class="inline-block bg-amber-500/10 text-amber-600 text-[0.68rem] font-bold px-[7px] py-px rounded-full ml-1.5 align-middle">
                        <i class="fas fa-lock text-[0.6rem]"></i> Solo administrador
                    </span>
                </label>
                <div class="flex">
                    <span class="flex items-center bg-gray-50 border-[1.5px] border-r-0 border-gray-200 rounded-l-[9px] px-[0.85rem] text-[0.9rem] font-semibold text-amber-600">$</span>
                    <input type="number" id="precio_interno" name="precio_interno"
                           class="border-[1.5px] border-gray-200 rounded-r-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full flex-1 focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]"
                           value="<?= esc(old('precio_interno', $producto['precio_interno'] ?? '')) ?>"
                           min="0" step="0.01"
                           placeholder="Ej: 60000.00">
                </div>
                <div class="text-xs text-gray-400 mt-[0.2rem]">
                    Nunca se muestra en el sitio público. Solo visible en «Ver» dentro de Gestión de Productos.
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

/* ─── Línea: depende de la fábrica seleccionada ─── */
const LINEAS_POR_FABRICA = <?= json_encode($lineasPorFabrica ?? [], JSON_UNESCAPED_UNICODE) ?>;
const initLineaId = '<?= esc(old('linea_id', $producto['linea_id'] ?? '')) ?>';

const wrapLinea      = document.getElementById('wrap-linea');
const selLinea       = document.getElementById('linea_id');
const lineaAdminLink = document.getElementById('linea_admin_link');

function poblarLineas(fabricaId, seleccionarLineaId) {
    selLinea.innerHTML = '<option value="">— Sin línea —</option>';

    const lineas = LINEAS_POR_FABRICA[fabricaId] || [];
    if (!fabricaId || lineas.length === 0) {
        wrapLinea.classList.add('hidden');
        return;
    }

    lineas.forEach(function (l) {
        const opt       = document.createElement('option');
        opt.value       = l.id;
        opt.textContent = l.nombre;
        if (String(l.id) === String(seleccionarLineaId)) opt.selected = true;
        selLinea.appendChild(opt);
    });

    if (lineaAdminLink) lineaAdminLink.href = '<?= base_url('admin/fabricas') ?>/' + fabricaId + '/lineas';
    wrapLinea.classList.remove('hidden');
}

selFabrica.addEventListener('change', function () {
    poblarLineas(this.value, '');
});

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
if (selFabrica.value) {
    poblarLineas(selFabrica.value, initLineaId);
}

/* ─── Slug: autocompletar a partir del nombre, editable a mano ─── */
(function () {
    var nombreInput = document.getElementById('nombre');
    var slugInput   = document.getElementById('slug');
    if (!nombreInput || !slugInput) return;

    function slugify(text) {
        text = text.toLowerCase();
        text = text.replace(/[áàä]/g,'a').replace(/[éèë]/g,'e').replace(/[íìï]/g,'i')
                   .replace(/[óòö]/g,'o').replace(/[úùü]/g,'u').replace(/ñ/g,'n');
        return text.replace(/[^a-z0-9\s\-]/g,'').replace(/[\s]+/g,'-').replace(/-+/g,'-').replace(/^-|-$/g,'');
    }

    nombreInput.addEventListener('input', function () {
        if (slugInput.dataset.manual === 'true') return;
        slugInput.value = slugify(this.value);
    });
    slugInput.addEventListener('input', function () {
        this.dataset.manual = 'true';
    });
})();

/* ─── Características técnicas: filas dinámicas ─── */
document.getElementById('btn-agregar-caract').addEventListener('click', function () {
    var wrap = document.getElementById('caract-filas');
    var fila = document.createElement('div');
    fila.className = 'caract-fila flex gap-2 items-center';
    fila.innerHTML =
        '<input type="text" name="caracteristicas[clave][]" class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.85rem] py-[0.5rem] text-[0.88rem] text-dark bg-white outline-none w-[38%] focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]" placeholder="Ej: Color, Peso, Garantía">' +
        '<input type="text" name="caracteristicas[valor][]" class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.85rem] py-[0.5rem] text-[0.88rem] text-dark bg-white outline-none flex-1 focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]" placeholder="Ej: Gris, 2.5kg, 12 meses">' +
        '<button type="button" class="btn-quitar-caract text-gray-400 hover:text-red-600 transition-colors w-9 h-9 flex items-center justify-center shrink-0" title="Quitar fila" onclick="this.closest(\'.caract-fila\').remove()"><i class="fas fa-trash"></i></button>';
    wrap.appendChild(fila);
});

/* ─── Colores disponibles: tarjetas de variantes dinámicas ─── */
(function () {
    var lista       = document.getElementById('variantes-lista');
    var btnAgregar  = document.getElementById('btn-agregar-variante');
    var contador    = lista.querySelectorAll('.variante-card').length;

    function estiloSwatch(tipo, primario, secundario, imagenSrc) {
        if (tipo === 'textura' && imagenSrc) {
            return "background-image:url('" + imagenSrc + "'); background-size:cover; background-position:center;";
        }
        var p = primario || '#e5e7eb';
        if (tipo === 'combinado' && secundario) {
            return 'background: linear-gradient(135deg, ' + p + ' 0%, ' + p + ' 50%, ' + secundario + ' 50%, ' + secundario + ' 100%);';
        }
        return 'background-color: ' + p + ';';
    }

    function actualizarVarianteCard(card) {
        var tipo = card.querySelector('.variante-tipo').value;

        var campoSecundario = card.querySelector('.campo-color-secundario');
        var campoImagen     = card.querySelector('.campo-imagen');
        campoSecundario.classList.toggle('hidden', tipo !== 'combinado');
        campoImagen.classList.toggle('hidden', tipo !== 'textura');

        var primario         = card.querySelector('.variante-color-primario').value;
        var secundarioInput  = card.querySelector('.variante-color-secundario');
        var secundario       = secundarioInput ? secundarioInput.value : '';

        var imgActual  = card.querySelector('.variante-imagen-actual');
        var quitarImg  = card.querySelector('.variante-quitar-imagen');
        var imagenSrc  = (imgActual && !(quitarImg && quitarImg.checked))
            ? imgActual.getAttribute('src')
            : (card.dataset.nuevaImagen || '');

        var preview = card.querySelector('.variante-preview');
        preview.setAttribute('style', estiloSwatch(tipo, primario, secundario, imagenSrc));

        var nombreInput = card.querySelector('.variante-nombre');
        if (nombreInput) preview.setAttribute('title', nombreInput.value);
    }

    function escAttr(str) {
        return String(str || '').replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    /** Sincroniza el input de archivo real (el que se envía) con el array _nuevas de la tarjeta. */
    function sincronizarGaleriaInput(card) {
        var input = card.querySelector('.galeria-input-real');
        var dt = new DataTransfer();
        (card._nuevas || []).forEach(function (item) { dt.items.add(item.file); });
        input.files = dt.files;
    }

    /** Redibuja las miniaturas de imágenes nuevas (todavía no guardadas) de una tarjeta de color. */
    function renderGaleriaNueva(card) {
        var cont   = card.querySelector('.galeria-nueva-lista');
        var nuevas = card._nuevas || [];
        cont.innerHTML = nuevas.map(function (item, idx) {
            return '' +
            '<div class="galeria-img-item w-[92px]" data-idx="' + idx + '">' +
                '<div class="relative w-[92px] h-[72px] rounded-[8px] overflow-hidden border-2 border-dashed border-gray-300">' +
                    (item.preview ? '<img src="' + item.preview + '" alt="" class="w-full h-full object-cover block">' : '') +
                    '<span class="absolute top-0 left-0 bg-gray-500 text-white text-[0.55rem] font-bold px-1 rounded-br-[6px]">Nueva</span>' +
                '</div>' +
                '<input type="text" class="galeria-nueva-alt mt-1 w-full text-[0.65rem] border border-gray-200 rounded px-1 py-[2px] outline-none focus:border-rojo" placeholder="Texto alternativo" value="' + escAttr(item.alt) + '">' +
                '<div class="flex items-center justify-between mt-1">' +
                    '<button type="button" class="galeria-nueva-mover text-gray-400 hover:text-gray-700 p-1" data-dir="-1" title="Mover antes"><i class="fas fa-arrow-left text-[0.7rem]"></i></button>' +
                    '<button type="button" class="galeria-nueva-mover text-gray-400 hover:text-gray-700 p-1" data-dir="1" title="Mover después"><i class="fas fa-arrow-right text-[0.7rem]"></i></button>' +
                    '<button type="button" class="galeria-nueva-quitar text-gray-400 hover:text-red-600 p-1" title="Quitar"><i class="fas fa-trash text-[0.7rem]"></i></button>' +
                '</div>' +
            '</div>';
        }).join('');
        sincronizarGaleriaInput(card);
    }

    function plantillaVariante(idx) {
        return '' +
        '<div class="variante-card border-[1.5px] border-gray-200 rounded-[12px] p-4 bg-gray-50/60" data-idx="' + idx + '">' +
            '<input type="hidden" name="variantes[' + idx + '][id]" value="">' +
            '<div class="flex gap-3 items-start flex-wrap">' +
                '<div class="shrink-0 flex flex-col items-center gap-1">' +
                    '<div class="variante-preview w-[42px] h-[42px] rounded-[8px] border-[1.5px] border-gray-200 bg-white shrink-0" style="background-color:#ffffff;"></div>' +
                    '<span class="text-[0.62rem] text-gray-400">Vista previa</span>' +
                '</div>' +
                '<div class="flex-1 min-w-[220px] grid grid-cols-1 sm:grid-cols-2 gap-2">' +
                    '<div class="sm:col-span-2">' +
                        '<label class="text-[0.78rem] font-semibold text-gray-600 mb-1 block">Nombre de la variante <span class="text-rojo">*</span></label>' +
                        '<input type="text" name="variantes[' + idx + '][nombre]" class="variante-nombre border-[1.5px] border-gray-200 rounded-[8px] px-3 py-[0.45rem] text-[0.85rem] text-dark bg-white outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]" placeholder="Ej: Hickory / Blanco texturizado">' +
                    '</div>' +
                    '<div>' +
                        '<label class="text-[0.78rem] font-semibold text-gray-600 mb-1 block">Tipo de muestra</label>' +
                        '<select name="variantes[' + idx + '][tipo]" class="variante-tipo border-[1.5px] border-gray-200 rounded-[8px] px-3 py-[0.45rem] text-[0.85rem] text-dark bg-white outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]">' +
                            '<option value="simple">Color simple</option>' +
                            '<option value="combinado">Combinación de dos colores</option>' +
                            '<option value="textura">Imagen / textura</option>' +
                        '</select>' +
                    '</div>' +
                    '<div>' +
                        '<label class="text-[0.78rem] font-semibold text-gray-600 mb-1 block">Orden</label>' +
                        '<input type="number" name="variantes[' + idx + '][orden]" value="0" min="0" step="1" class="border-[1.5px] border-gray-200 rounded-[8px] px-3 py-[0.45rem] text-[0.85rem] text-dark bg-white outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]">' +
                    '</div>' +
                    '<div class="campo-color-primario">' +
                        '<label class="text-[0.78rem] font-semibold text-gray-600 mb-1 block">Color primario</label>' +
                        '<input type="color" name="variantes[' + idx + '][color_primario]" value="#ffffff" class="variante-color-primario w-full h-9 border-[1.5px] border-gray-200 rounded-[8px] p-[2px] cursor-pointer">' +
                    '</div>' +
                    '<div class="campo-color-secundario hidden">' +
                        '<label class="text-[0.78rem] font-semibold text-gray-600 mb-1 block">Color secundario</label>' +
                        '<input type="color" name="variantes[' + idx + '][color_secundario]" value="#000000" class="variante-color-secundario w-full h-9 border-[1.5px] border-gray-200 rounded-[8px] p-[2px] cursor-pointer">' +
                    '</div>' +
                    '<div class="campo-imagen sm:col-span-2 hidden">' +
                        '<label class="text-[0.78rem] font-semibold text-gray-600 mb-1 block">Imagen / textura</label>' +
                        '<input type="file" name="variantes[' + idx + '][imagen]" accept="image/*" class="variante-imagen-input text-[0.8rem]">' +
                        '<div class="text-xs text-gray-400 mt-1">JPG, PNG o WebP · Máx. 3 MB.</div>' +
                    '</div>' +
                    '<div class="galeria-color sm:col-span-2 border-t border-gray-200 pt-3 mt-1">' +
                        '<label class="text-[0.78rem] font-semibold text-gray-600 mb-2 block">Imágenes de este color</label>' +
                        '<input type="hidden" name="variantes[' + idx + '][galeria_principal]" class="galeria-principal-input" value="0">' +
                        '<div class="galeria-existente-lista flex flex-wrap gap-2 mb-2"></div>' +
                        '<div class="galeria-nueva-lista flex flex-wrap gap-2 mb-2"></div>' +
                        '<input type="file" name="variantes[' + idx + '][galeria_nueva][]" class="galeria-input-real hidden" multiple>' +
                        '<label class="galeria-btn-agregar inline-flex items-center gap-2 text-[0.78rem] font-semibold text-rojo bg-rojo/[0.06] border-[1.5px] border-rojo/20 rounded-full px-3 py-[0.35rem] cursor-pointer transition-colors hover:bg-rojo/10">' +
                            '<i class="fas fa-images"></i> Agregar imágenes' +
                            '<input type="file" class="galeria-input-nueva hidden" accept="image/*" multiple>' +
                        '</label>' +
                        '<div class="text-xs text-gray-400 mt-1">JPG, PNG o WebP · Máx. 3 MB c/u. La marcada con estrella se muestra primero al elegir este color en la ficha pública.</div>' +
                    '</div>' +
                    '<div class="sm:col-span-2 flex items-center justify-between mt-1">' +
                        '<label class="relative inline-flex items-center cursor-pointer">' +
                            '<input type="checkbox" name="variantes[' + idx + '][activo]" value="1" class="sr-only peer" checked>' +
                            '<span class="w-9 h-5 bg-gray-200 rounded-full peer-checked:bg-rojo transition-colors relative after:content-[\'\'] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-4"></span>' +
                            '<span class="ml-2 text-[0.78rem] font-semibold text-gray-600">Activa</span>' +
                        '</label>' +
                        '<button type="button" class="btn-quitar-variante text-gray-400 hover:text-red-600 transition-colors w-8 h-8 flex items-center justify-center shrink-0" title="Quitar variante"><i class="fas fa-trash"></i></button>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>';
    }

    btnAgregar.addEventListener('click', function () {
        var temp = document.createElement('div');
        temp.innerHTML = plantillaVariante(contador++);
        var card = temp.firstElementChild;
        lista.appendChild(card);
        actualizarVarianteCard(card);
    });

    lista.addEventListener('click', function (e) {
        var btnQuitarVariante = e.target.closest('.btn-quitar-variante');
        if (btnQuitarVariante) {
            var cardQV = btnQuitarVariante.closest('.variante-card');
            var tieneImagenes = cardQV.querySelectorAll('.galeria-existente-lista .galeria-img-item').length > 0
                || (cardQV._nuevas && cardQV._nuevas.length > 0);
            if (tieneImagenes && !confirm('Este color ya tiene imágenes cargadas. ¿Seguro que querés eliminarlo? Se van a perder todas sus imágenes.')) {
                return;
            }
            cardQV.remove();
            return;
        }

        var btnPrincipal = e.target.closest('.btn-galeria-principal');
        if (btnPrincipal) {
            var itemP  = btnPrincipal.closest('.galeria-img-item');
            var cardP  = btnPrincipal.closest('.variante-card');
            var hidden = cardP.querySelector('.galeria-principal-input');
            hidden.value = itemP.dataset.id;
            cardP.querySelectorAll('.galeria-existente-lista .galeria-img-item').forEach(function (it) {
                var esta = it === itemP;
                var marco = it.querySelector('.relative');
                marco.classList.toggle('border-rojo', esta);
                marco.classList.toggle('border-gray-200', !esta);
                var badge = it.querySelector('.galeria-badge-principal');
                if (badge) badge.classList.toggle('hidden', !esta);
            });
            return;
        }

        var btnMover = e.target.closest('.btn-galeria-mover');
        if (btnMover) {
            var itemM = btnMover.closest('.galeria-img-item');
            var dir   = btnMover.dataset.dir;
            if (dir === '-1' && itemM.previousElementSibling) {
                itemM.parentNode.insertBefore(itemM, itemM.previousElementSibling);
            } else if (dir === '1' && itemM.nextElementSibling) {
                itemM.parentNode.insertBefore(itemM.nextElementSibling, itemM);
            }
            return;
        }

        var btnQuitarImg = e.target.closest('.btn-galeria-quitar');
        if (btnQuitarImg) {
            if (!confirm('¿Quitar esta imagen del color?')) return;
            btnQuitarImg.closest('.galeria-img-item').remove();
            return;
        }

        var btnNuevaMover = e.target.closest('.galeria-nueva-mover');
        if (btnNuevaMover) {
            var cardNM  = btnNuevaMover.closest('.variante-card');
            var idxNM   = parseInt(btnNuevaMover.closest('.galeria-img-item').dataset.idx, 10);
            var destino = idxNM + parseInt(btnNuevaMover.dataset.dir, 10);
            if (cardNM._nuevas && destino >= 0 && destino < cardNM._nuevas.length) {
                var tmp = cardNM._nuevas[idxNM];
                cardNM._nuevas[idxNM] = cardNM._nuevas[destino];
                cardNM._nuevas[destino] = tmp;
                renderGaleriaNueva(cardNM);
            }
            return;
        }

        var btnNuevaQuitar = e.target.closest('.galeria-nueva-quitar');
        if (btnNuevaQuitar) {
            var cardNQ = btnNuevaQuitar.closest('.variante-card');
            var idxNQ  = parseInt(btnNuevaQuitar.closest('.galeria-img-item').dataset.idx, 10);
            if (cardNQ._nuevas) {
                cardNQ._nuevas.splice(idxNQ, 1);
                renderGaleriaNueva(cardNQ);
            }
            return;
        }
    });

    lista.addEventListener('change', function (e) {
        var card = e.target.closest('.variante-card');
        if (!card) return;

        if (e.target.classList.contains('galeria-input-nueva')) {
            var filesPicked = Array.prototype.slice.call(e.target.files);
            e.target.value = '';
            card._nuevas = card._nuevas || [];
            filesPicked.forEach(function (file) {
                if (!file.type.startsWith('image/')) return;
                var item = { file: file, alt: '', preview: '' };
                card._nuevas.push(item);
                var reader = new FileReader();
                reader.onload = function (ev) {
                    item.preview = ev.target.result;
                    renderGaleriaNueva(card);
                };
                reader.readAsDataURL(file);
            });
            renderGaleriaNueva(card);
            return;
        }

        if (e.target.classList.contains('variante-imagen-input')) {
            var file = e.target.files && e.target.files[0];
            if (file) {
                var reader2 = new FileReader();
                reader2.onload = function (ev) {
                    card.dataset.nuevaImagen = ev.target.result;
                    actualizarVarianteCard(card);
                };
                reader2.readAsDataURL(file);
                return;
            }
        }

        if (e.target.classList.contains('variante-quitar-imagen')) {
            var imgEl = card.querySelector('.variante-imagen-actual');
            if (imgEl) imgEl.classList.toggle('opacity-30', e.target.checked);
        }

        actualizarVarianteCard(card);
    });

    lista.addEventListener('input', function (e) {
        if (e.target.classList.contains('galeria-nueva-alt')) {
            var card = e.target.closest('.variante-card');
            var itemEl = e.target.closest('.galeria-img-item');
            var idx = itemEl ? parseInt(itemEl.dataset.idx, 10) : -1;
            if (card && card._nuevas && card._nuevas[idx]) card._nuevas[idx].alt = e.target.value;
        }
    });

    // Vista previa inicial de las tarjetas ya renderizadas por el servidor (modo edición)
    lista.querySelectorAll('.variante-card').forEach(actualizarVarianteCard);
})();

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
