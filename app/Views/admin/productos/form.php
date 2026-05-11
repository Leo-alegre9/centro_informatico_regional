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

    .img-upload-box {
        border: 2px dashed #e5e7eb; border-radius: 12px; background: #f9fafb;
        display: flex; align-items: center; justify-content: center;
        min-height: 170px; overflow: hidden; transition: border-color 0.2s;
    }
    .img-upload-box:hover { border-color: #FF0033; }
    .img-upload-box img { max-width: 100%; max-height: 200px; object-fit: contain; display: block; }
    .img-upload-placeholder {
        display: flex; flex-direction: column; align-items: center; gap: 8px;
        color: #9CA3AF; font-size: 0.85rem;
    }
    .img-upload-placeholder i { font-size: 2rem; color: #d1d5db; }
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
                <label for="precio_texto" class="form-label">Precio</label>
                <input type="text" id="precio_texto" name="precio_texto" class="form-control"
                       value="<?= esc(old('precio_texto', $producto['precio_texto'] ?? '')) ?>"
                       placeholder="Ej: $85.000  —  o dejalo vacío para 'Consultar precio'">
                <div class="field-hint">Si no tiene precio fijo, dejalo vacío.</div>
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

        <!-- ── SECCIÓN 4: IMAGEN ── -->
        <div class="form-section-title"><i class="fas fa-image me-1"></i>Imagen del producto</div>

        <div class="row g-3 mb-4">
            <?php if (!empty($imagenActual)): ?>
            <div class="col-12 col-md-5">
                <label class="form-label">Imagen actual</label>
                <div class="img-upload-box">
                    <img src="<?= base_url(esc($imagenActual['ruta'])) ?>"
                         alt="<?= esc($imagenActual['alt_text'] ?? 'Imagen del producto') ?>">
                </div>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" id="eliminar_imagen"
                           name="eliminar_imagen" value="1">
                    <label class="form-check-label img-delete-check" for="eliminar_imagen">
                        Eliminar imagen actual
                    </label>
                </div>
            </div>
            <div class="col-12 col-md-7">
            <?php else: ?>
            <div class="col-12 col-md-6">
            <?php endif; ?>
                <label for="imagen" class="form-label">
                    <?= !empty($imagenActual) ? 'Reemplazar imagen' : 'Subir imagen' ?>
                </label>
                <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*">
                <div class="field-hint">JPG, PNG o WebP · Máx. 3 MB. Se mostrará en el catálogo.</div>

                <div class="mt-3" id="preview-wrap" style="display:none;">
                    <label class="form-label">Vista previa</label>
                    <div class="img-upload-box">
                        <img id="preview-img" src="" alt="Vista previa">
                    </div>
                </div>
            </div>

            <?php if (empty($imagenActual)): ?>
            <div class="col-12 col-md-6 d-none d-md-flex align-items-center justify-content-center">
                <div class="img-upload-box w-100" id="drop-hint">
                    <div class="img-upload-placeholder">
                        <i class="fas fa-cloud-arrow-up"></i>
                        <span>Sin imagen cargada</span>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

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

/* ─── Preview de imagen ─── */
document.getElementById('imagen').addEventListener('change', function () {
    const file = this.files[0];
    const wrap = document.getElementById('preview-wrap');
    const img  = document.getElementById('preview-img');
    const hint = document.getElementById('drop-hint');
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            img.src = e.target.result;
            wrap.style.display = '';
            if (hint) hint.style.display = 'none';
        };
        reader.readAsDataURL(file);
    } else {
        wrap.style.display = 'none';
        if (hint) hint.style.display = '';
    }
});
</script>

<?= $this->endSection() ?>
