<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<?php
$inputCls = 'w-full border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors focus:border-rojo focus:ring-[3px] focus:ring-rojo/10 focus:outline-none';
$selectDisabledCls = 'disabled:bg-gray-50 disabled:text-gray-400 disabled:cursor-not-allowed';
?>

<div class="flex items-center gap-3 mb-6">
    <a href="<?= base_url('admin/categorias') ?>" class="text-gray-500 hover:text-rojo no-underline flex items-center gap-[0.3rem] transition-colors">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h2 class="text-[1.35rem] font-bold text-dark m-0">
        <i class="fas fa-<?= $categoria ? 'pen' : 'plus-circle' ?> mr-2 text-rojo text-[1.05rem]"></i>
        <?= $categoria ? 'Editar categoría' : 'Nueva categoría' ?>
    </h2>
</div>

<?php $errors = session()->getFlashdata('errors'); ?>
<?php if ($errors): ?>
<div class="bg-rojo/5 border border-rojo/20 rounded-[10px] px-5 py-4 mb-4 text-[0.88rem] text-red-600">
    <strong><i class="fas fa-exclamation-triangle mr-1"></i>Corregí los siguientes errores:</strong>
    <ul class="mt-2 pl-5 list-disc"><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
</div>
<?php endif; ?>

<?php
// Para el JS: serializar los datos de padres disponibles
$rubrosJson = json_encode(array_values($rubros), JSON_UNESCAPED_UNICODE);
$cats2Json  = json_encode(array_values($cats2),  JSON_UNESCAPED_UNICODE);
$nivelActual     = old('nivel', $categoria['nivel'] ?? '');
$parentIdActual  = old('parent_id', $categoria['parent_id'] ?? '');
?>

<div class="bg-white border border-gray-200 rounded-[14px] p-8 shadow-[0_1px_4px_rgba(0,0,0,0.05)] max-w-[700px]">
    <form action="<?= esc($accion) ?>" method="POST">
        <?= csrf_field() ?>

        <div class="text-[0.72rem] font-bold uppercase tracking-[0.9px] text-gray-400 mb-4 pb-2 border-b border-gray-100"><i class="fas fa-layer-group mr-1"></i>Jerarquía</div>

        <div class="flex flex-wrap gap-4 mb-6">
            <div class="w-full md:w-1/3">
                <label for="nivel" class="block text-[0.85rem] font-semibold text-gray-700 mb-[0.3rem]">Nivel <span class="text-rojo">*</span></label>
                <select id="nivel" name="nivel" class="<?= $inputCls ?> <?= $selectDisabledCls ?>" onchange="actualizarNivel(this.value)" required>
                    <option value="">— Elegí el nivel —</option>
                    <option value="1" <?= $nivelActual == 1 ? 'selected' : '' ?>>Nivel 1 — Rubro</option>
                    <option value="2" <?= $nivelActual == 2 ? 'selected' : '' ?>>Nivel 2 — Categoría</option>
                    <option value="3" <?= $nivelActual == 3 ? 'selected' : '' ?>>Nivel 3 — Subcategoría</option>
                </select>
            </div>

            <div class="w-full md:w-2/3" id="wrapParent" style="display:<?= $nivelActual > 1 ? 'block' : 'none' ?>;">
                <label for="parent_id" class="block text-[0.85rem] font-semibold text-gray-700 mb-[0.3rem]">Categoría padre <span class="text-rojo">*</span></label>
                <select id="parent_id" name="parent_id" class="<?= $inputCls ?>">
                    <option value="">— Seleccioná el padre —</option>
                </select>
                <div class="hidden text-[0.78rem] bg-gray-100 rounded-lg px-3 py-2 text-gray-500 mt-[0.4rem]" id="nivelHint"></div>
            </div>
        </div>

        <div class="text-[0.72rem] font-bold uppercase tracking-[0.9px] text-gray-400 mb-4 pb-2 border-b border-gray-100"><i class="fas fa-info-circle mr-1"></i>Datos de la categoría</div>

        <div class="flex flex-wrap gap-4 mb-6">
            <div class="w-full md:w-7/12">
                <label for="nombre" class="block text-[0.85rem] font-semibold text-gray-700 mb-[0.3rem]">Nombre <span class="text-rojo">*</span></label>
                <input type="text" id="nombre" name="nombre" class="<?= $inputCls ?>"
                       value="<?= esc(old('nombre', $categoria['nombre'] ?? '')) ?>"
                       placeholder="Ej: Procesadores, Gaming, Heladeras" required
                       oninput="autoSlug(this.value)">
            </div>

            <div class="w-full md:w-5/12">
                <label for="slug" class="block text-[0.85rem] font-semibold text-gray-700 mb-[0.3rem]">Slug (URL) <span class="text-rojo">*</span></label>
                <input type="text" id="slug" name="slug" class="<?= $inputCls ?>"
                       value="<?= esc(old('slug', $categoria['slug'] ?? '')) ?>"
                       placeholder="procesadores" required>
                <div class="text-xs text-gray-400 mt-[0.2rem]">Solo letras minúsculas, números y guiones.</div>
            </div>

            <div class="w-full md:w-2/3">
                <label for="icono" class="block text-[0.85rem] font-semibold text-gray-700 mb-[0.3rem]">Ícono (Font Awesome)</label>
                <div class="flex gap-2 items-center">
                    <span class="text-[1.4rem] text-rojo w-9 text-center"><i id="iconPreview" class="<?= esc(old('icono', $categoria['icono'] ?? 'fas fa-folder')) ?>"></i></span>
                    <input type="text" id="icono" name="icono" class="<?= $inputCls ?>"
                           value="<?= esc(old('icono', $categoria['icono'] ?? 'fas fa-folder')) ?>"
                           placeholder="fas fa-folder"
                           oninput="document.getElementById('iconPreview').className = this.value || 'fas fa-folder'">
                </div>
                <div class="text-xs text-gray-400 mt-[0.2rem]">Clase de Font Awesome 6. Ej: fas fa-microchip, fas fa-chair</div>
            </div>

            <div class="w-full md:w-1/3">
                <label for="orden" class="block text-[0.85rem] font-semibold text-gray-700 mb-[0.3rem]">Orden</label>
                <input type="number" id="orden" name="orden" class="<?= $inputCls ?>" min="0"
                       value="<?= esc(old('orden', $categoria['orden'] ?? 0)) ?>"
                       placeholder="0">
                <div class="text-xs text-gray-400 mt-[0.2rem]">Menor número = aparece primero.</div>
            </div>

            <div class="w-full">
                <label for="descripcion" class="block text-[0.85rem] font-semibold text-gray-700 mb-[0.3rem]">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="<?= $inputCls ?> min-h-[90px] resize-y"
                          placeholder="Breve descripción de esta categoría..."><?= esc(old('descripcion', $categoria['descripcion'] ?? '')) ?></textarea>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="bg-rojo hover:bg-rojo-dark text-white px-8 py-[0.7rem] rounded-full text-[0.95rem] font-semibold inline-flex items-center gap-[0.45rem] cursor-pointer transition-colors">
                <i class="fas fa-save"></i> <?= $categoria ? 'Guardar cambios' : 'Crear categoría' ?>
            </button>
            <a href="<?= base_url('admin/categorias') ?>" class="text-gray-500 hover:bg-gray-100 hover:text-gray-700 no-underline px-[1.4rem] py-[0.7rem] rounded-full text-[0.95rem] font-semibold inline-flex items-center gap-[0.4rem] border-[1.5px] border-gray-200 transition-colors">
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
