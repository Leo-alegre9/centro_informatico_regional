<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<style>
    .form-card {
        background: #fff; border: 1px solid #e5e7eb; border-radius: 14px;
        padding: 2rem; box-shadow: 0 1px 4px rgba(0,0,0,0.05); max-width: 620px;
    }
    .form-section-title {
        font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.9px;
        color: #9CA3AF; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f3f4f6;
    }
    .form-label { font-size: 0.85rem; font-weight: 600; color: #374151; margin-bottom: 0.3rem; }
    .form-control {
        border: 1.5px solid #e5e7eb; border-radius: 9px; padding: 0.6rem 0.95rem;
        font-size: 0.92rem; color: #111827; transition: border-color 0.2s, box-shadow 0.2s; background: #fff;
    }
    .form-control:focus {
        border-color: #FF0033; box-shadow: 0 0 0 3px rgba(255,0,51,0.1); outline: none;
    }
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
    .logo-preview {
        width: 64px; height: 64px; border-radius: 10px; border: 1.5px solid #e5e7eb;
        background: #f9fafb; object-fit: contain; padding: 4px;
    }
</style>

<div class="page-header-row">
    <a href="<?= base_url('admin/marcas') ?>" class="back-link">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h2>
        <i class="fas fa-<?= $marca ? 'pen' : 'plus-circle' ?> me-2" style="color:#FF0033;font-size:1.05rem;"></i>
        <?= $marca ? 'Editar marca' : 'Nueva marca' ?>
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
    <form action="<?= esc($accion) ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-section-title"><i class="fas fa-tag me-1"></i>Datos de la marca</div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-7">
                <label for="nombre" class="form-label">Nombre <span style="color:#FF0033;">*</span></label>
                <input type="text" id="nombre" name="nombre" class="form-control"
                       value="<?= esc(old('nombre', $marca['nombre'] ?? '')) ?>"
                       placeholder="Ej: Samsung, Intel, Logitech" required
                       oninput="autoSlug(this.value)">
            </div>

            <div class="col-12 col-md-5">
                <label for="slug" class="form-label">Slug <span style="color:#FF0033;">*</span></label>
                <input type="text" id="slug" name="slug" class="form-control"
                       value="<?= esc(old('slug', $marca['slug'] ?? '')) ?>"
                       placeholder="samsung" required>
                <div class="field-hint">Solo letras minúsculas y guiones.</div>
            </div>

            <div class="col-12">
                <label for="logo_url" class="form-label">URL del logo</label>
                <div class="d-flex align-items-center gap-3">
                    <?php $logoActual = old('logo_url', $marca['logo_url'] ?? ''); ?>
                    <img id="logoPreview"
                         src="<?= esc($logoActual) ?: 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=' ?>"
                         alt="Logo preview" class="logo-preview"
                         style="display: <?= $logoActual ? 'block' : 'none' ?>;">
                    <input type="url" id="logo_url" name="logo_url" class="form-control"
                           value="<?= esc($logoActual) ?>"
                           placeholder="https://ejemplo.com/logo.png"
                           oninput="actualizarLogoPreview(this.value)">
                </div>
                <div class="field-hint">URL pública de la imagen del logo (PNG o SVG recomendado).</div>
            </div>

            <div class="col-12">
                <label for="sitio_web" class="form-label">Sitio web</label>
                <input type="url" id="sitio_web" name="sitio_web" class="form-control"
                       value="<?= esc(old('sitio_web', $marca['sitio_web'] ?? '')) ?>"
                       placeholder="https://www.samsung.com">
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn-guardar">
                <i class="fas fa-save"></i> <?= $marca ? 'Guardar cambios' : 'Crear marca' ?>
            </button>
            <a href="<?= base_url('admin/marcas') ?>" class="btn-cancelar">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<script>
function autoSlug(text) {
    var slugField = document.getElementById('slug');
    if (slugField.dataset.manual === 'true') return;
    text = text.toLowerCase();
    text = text.replace(/[áàä]/g,'a').replace(/[éèë]/g,'e').replace(/[íìï]/g,'i')
               .replace(/[óòö]/g,'o').replace(/[úùü]/g,'u').replace(/ñ/g,'n');
    text = text.replace(/[^a-z0-9\s\-]/g,'').replace(/[\s]+/g,'-').replace(/-+/g,'-').replace(/^-|-$/g,'');
    slugField.value = text;
}
document.getElementById('slug').addEventListener('input', function () {
    this.dataset.manual = 'true';
});

function actualizarLogoPreview(url) {
    var preview = document.getElementById('logoPreview');
    if (url) {
        preview.src = url;
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
}
</script>

<?= $this->endSection() ?>
