<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<?php
$inputCls = 'w-full border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors focus:border-rojo focus:ring-[3px] focus:ring-rojo/10 focus:outline-none';
?>

<div class="flex items-center gap-3 mb-6">
    <a href="<?= base_url('admin/marcas') ?>" class="text-gray-500 hover:text-rojo no-underline flex items-center gap-[0.3rem] transition-colors">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h2 class="text-[1.35rem] font-bold text-dark m-0">
        <i class="fas fa-<?= $marca ? 'pen' : 'plus-circle' ?> mr-2 text-rojo text-[1.05rem]"></i>
        <?= $marca ? 'Editar marca' : 'Nueva marca' ?>
    </h2>
</div>

<?php $errors = session()->getFlashdata('errors'); ?>
<?php if ($errors): ?>
<div class="bg-rojo/5 border border-rojo/20 rounded-[10px] px-5 py-4 mb-4 text-[0.88rem] text-red-600">
    <strong><i class="fas fa-exclamation-triangle mr-1"></i>Corregí los siguientes errores:</strong>
    <ul class="mt-2 pl-5 list-disc"><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
</div>
<?php endif; ?>

<div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-[0_1px_4px_rgba(0,0,0,0.05)] max-w-[620px]">
    <form action="<?= esc($accion) ?>" method="POST">
        <?= csrf_field() ?>

        <div class="text-[0.72rem] font-bold uppercase tracking-[0.9px] text-gray-400 mb-4 pb-2 border-b border-gray-100"><i class="fas fa-tag mr-1"></i>Datos de la marca</div>

        <div class="flex flex-wrap gap-4 mb-6">
            <div class="w-full md:w-7/12">
                <label for="nombre" class="block text-[0.85rem] font-semibold text-gray-700 mb-[0.3rem]">Nombre <span class="text-rojo">*</span></label>
                <input type="text" id="nombre" name="nombre" class="<?= $inputCls ?>"
                       value="<?= esc(old('nombre', $marca['nombre'] ?? '')) ?>"
                       placeholder="Ej: Samsung, Intel, Logitech" required
                       oninput="autoSlug(this.value)">
            </div>

            <div class="w-full md:w-5/12">
                <label for="slug" class="block text-[0.85rem] font-semibold text-gray-700 mb-[0.3rem]">Slug <span class="text-rojo">*</span></label>
                <input type="text" id="slug" name="slug" class="<?= $inputCls ?>"
                       value="<?= esc(old('slug', $marca['slug'] ?? '')) ?>"
                       placeholder="samsung" required>
                <div class="text-xs text-gray-400 mt-[0.2rem]">Solo letras minúsculas y guiones.</div>
            </div>

            <div class="w-full">
                <label for="sitio_web" class="block text-[0.85rem] font-semibold text-gray-700 mb-[0.3rem]">Sitio web</label>
                <input type="url" id="sitio_web" name="sitio_web" class="<?= $inputCls ?>"
                       value="<?= esc(old('sitio_web', $marca['sitio_web'] ?? '')) ?>"
                       placeholder="https://www.samsung.com">
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="bg-rojo hover:bg-rojo-dark text-white px-8 py-[0.7rem] rounded-full text-[0.95rem] font-semibold inline-flex items-center gap-[0.45rem] cursor-pointer transition-colors">
                <i class="fas fa-save"></i> <?= $marca ? 'Guardar cambios' : 'Crear marca' ?>
            </button>
            <a href="<?= base_url('admin/marcas') ?>" class="text-gray-500 hover:bg-gray-100 hover:text-gray-700 no-underline px-[1.4rem] py-[0.7rem] rounded-full text-[0.95rem] font-semibold inline-flex items-center gap-[0.4rem] border-[1.5px] border-gray-200 transition-colors">
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


</script>

<?= $this->endSection() ?>
