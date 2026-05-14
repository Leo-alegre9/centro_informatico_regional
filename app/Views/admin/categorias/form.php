<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<style>
    .form-card {
        background: #fff; border: 1px solid #e5e7eb; border-radius: 14px;
        padding: 2rem; box-shadow: 0 1px 4px rgba(0,0,0,0.05); max-width: 700px;
    }
    .form-section-title {
        font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.9px;
        color: #9CA3AF; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f3f4f6;
    }
    .form-label { font-size: 0.85rem; font-weight: 600; color: #374151; margin-bottom: 0.3rem; }
    .form-control, .form-select {
        border: 1.5px solid #e5e7eb; border-radius: 9px; padding: 0.6rem 0.95rem;
        font-size: 0.92rem; color: #111827; transition: border-color 0.2s, box-shadow 0.2s; background: #fff;
    }
    .form-control:focus, .form-select:focus {
        border-color: #FF0033; box-shadow: 0 0 0 3px rgba(255,0,51,0.1); outline: none;
    }
    .form-select:disabled { background: #f9fafb; color: #9CA3AF; cursor: not-allowed; }
    textarea.form-control { min-height: 90px; resize: vertical; }
    .field-hint { font-size: 0.75rem; color: #9CA3AF; margin-top: 0.2rem; }
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
    .icon-preview { font-size: 1.4rem; color: var(--rojo,#FF0033); width: 36px; text-align: center; }
    .nivel-hint {
        font-size: 0.78rem; background: #f3f4f6; border-radius: 8px; padding: 0.5rem 0.75rem;
        color: #6B7280; margin-top: 0.4rem;
    }
</style>

<div class="page-header-row">
    <a href="<?= base_url('admin/categorias') ?>" class="back-link">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h2>
        <i class="fas fa-<?= $categoria ? 'pen' : 'plus-circle' ?> me-2" style="color:#FF0033;font-size:1.05rem;"></i>
        <?= $categoria ? 'Editar categoría' : 'Nueva categoría' ?>
    </h2>
</div>

<?php $errors = session()->getFlashdata('errors'); ?>
<?php if ($errors): ?>
<div class="errors-box mb-3">
    <strong><i class="fas fa-exclamation-triangle me-1"></i>Corregí los siguientes errores:</strong>
    <ul><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
</div>
<?php endif; ?>

<?php
// Para el JS: serializar los datos de padres disponibles
$rubrosJson = json_encode(array_values($rubros), JSON_UNESCAPED_UNICODE);
$cats2Json  = json_encode(array_values($cats2),  JSON_UNESCAPED_UNICODE);
$nivelActual     = old('nivel', $categoria['nivel'] ?? '');
$parentIdActual  = old('parent_id', $categoria['parent_id'] ?? '');
?>

<div class="form-card">
    <form action="<?= esc($accion) ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-section-title"><i class="fas fa-layer-group me-1"></i>Jerarquía</div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <label for="nivel" class="form-label">Nivel <span style="color:#FF0033;">*</span></label>
                <select id="nivel" name="nivel" class="form-select" onchange="actualizarNivel(this.value)" required>
                    <option value="">— Elegí el nivel —</option>
                    <option value="1" <?= $nivelActual == 1 ? 'selected' : '' ?>>Nivel 1 — Rubro</option>
                    <option value="2" <?= $nivelActual == 2 ? 'selected' : '' ?>>Nivel 2 — Categoría</option>
                    <option value="3" <?= $nivelActual == 3 ? 'selected' : '' ?>>Nivel 3 — Subcategoría</option>
                </select>
            </div>

            <div class="col-12 col-md-8" id="wrapParent" style="display:<?= $nivelActual > 1 ? 'block' : 'none' ?>;">
                <label for="parent_id" class="form-label">Categoría padre <span style="color:#FF0033;">*</span></label>
                <select id="parent_id" name="parent_id" class="form-select">
                    <option value="">— Seleccioná el padre —</option>
                </select>
                <div class="nivel-hint" id="nivelHint" style="display:none;"></div>
            </div>
        </div>

        <div class="form-section-title"><i class="fas fa-info-circle me-1"></i>Datos de la categoría</div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-7">
                <label for="nombre" class="form-label">Nombre <span style="color:#FF0033;">*</span></label>
                <input type="text" id="nombre" name="nombre" class="form-control"
                       value="<?= esc(old('nombre', $categoria['nombre'] ?? '')) ?>"
                       placeholder="Ej: Procesadores, Gaming, Heladeras" required
                       oninput="autoSlug(this.value)">
            </div>

            <div class="col-12 col-md-5">
                <label for="slug" class="form-label">Slug (URL) <span style="color:#FF0033;">*</span></label>
                <input type="text" id="slug" name="slug" class="form-control"
                       value="<?= esc(old('slug', $categoria['slug'] ?? '')) ?>"
                       placeholder="procesadores" required>
                <div class="field-hint">Solo letras minúsculas, números y guiones.</div>
            </div>

            <div class="col-12 col-md-8">
                <label for="icono" class="form-label">Ícono (Font Awesome)</label>
                <div class="d-flex gap-2 align-items-center">
                    <span class="icon-preview"><i id="iconPreview" class="<?= esc(old('icono', $categoria['icono'] ?? 'fas fa-folder')) ?>"></i></span>
                    <input type="text" id="icono" name="icono" class="form-control"
                           value="<?= esc(old('icono', $categoria['icono'] ?? 'fas fa-folder')) ?>"
                           placeholder="fas fa-folder"
                           oninput="document.getElementById('iconPreview').className = this.value || 'fas fa-folder'">
                </div>
                <div class="field-hint">Clase de Font Awesome 6. Ej: fas fa-microchip, fas fa-chair</div>
            </div>

            <div class="col-12 col-md-4">
                <label for="orden" class="form-label">Orden</label>
                <input type="number" id="orden" name="orden" class="form-control" min="0"
                       value="<?= esc(old('orden', $categoria['orden'] ?? 0)) ?>"
                       placeholder="0">
                <div class="field-hint">Menor número = aparece primero.</div>
            </div>

            <div class="col-12">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="form-control"
                          placeholder="Breve descripción de esta categoría..."><?= esc(old('descripcion', $categoria['descripcion'] ?? '')) ?></textarea>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn-guardar">
                <i class="fas fa-save"></i> <?= $categoria ? 'Guardar cambios' : 'Crear categoría' ?>
            </button>
            <a href="<?= base_url('admin/categorias') ?>" class="btn-cancelar">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<script>
const RUBROS      = <?= $rubrosJson ?>;
const CATS2       = <?= $cats2Json ?>;
const PARENT_ACTUAL = <?= (int) $parentIdActual ?>;

function actualizarNivel(val) {
    var wrap   = document.getElementById('wrapParent');
    var select = document.getElementById('parent_id');
    var hint   = document.getElementById('nivelHint');
    val = parseInt(val);

    wrap.style.display = val > 1 ? 'block' : 'none';
    select.innerHTML   = '<option value="">— Seleccioná el padre —</option>';
    hint.style.display = 'none';

    if (val === 2) {
        hint.textContent   = 'Seleccioná el Rubro al que pertenece esta Categoría.';
        hint.style.display = 'block';
        RUBROS.forEach(function (r) {
            var opt = document.createElement('option');
            opt.value       = r.id;
            opt.textContent = r.nombre;
            if (r.id == PARENT_ACTUAL) opt.selected = true;
            select.appendChild(opt);
        });
    } else if (val === 3) {
        hint.textContent   = 'Seleccioná la Categoría (nivel 2) a la que pertenece esta Subcategoría.';
        hint.style.display = 'block';
        CATS2.forEach(function (c) {
            var opt = document.createElement('option');
            opt.value       = c.id;
            opt.textContent = c.parent_nombre + ' › ' + c.nombre;
            if (c.id == PARENT_ACTUAL) opt.selected = true;
            select.appendChild(opt);
        });
    }
}

// Inicializar al cargar en modo edición
(function () {
    var nivel = document.getElementById('nivel').value;
    if (nivel) actualizarNivel(parseInt(nivel));
})();

function autoSlug(text) {
    var slugField = document.getElementById('slug');
    if (slugField.dataset.manual === 'true') return;
    text = text.toLowerCase();
    text = text.replace(/[áàä]/g, 'a').replace(/[éèë]/g, 'e').replace(/[íìï]/g, 'i')
               .replace(/[óòö]/g, 'o').replace(/[úùü]/g, 'u').replace(/ñ/g, 'n');
    text = text.replace(/[^a-z0-9\s\-]/g, '').replace(/[\s]+/g, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
    slugField.value = text;
}

document.getElementById('slug').addEventListener('input', function () {
    this.dataset.manual = 'true';
});
</script>

<?= $this->endSection() ?>
