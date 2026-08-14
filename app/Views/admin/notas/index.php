<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
    <h2 class="text-[1.4rem] font-bold text-dark m-0"><i class="fas fa-sticky-note mr-2 text-rojo text-[1.1rem]"></i>Notas</h2>
    <span class="bg-rojo/[0.08] text-rojo rounded-full px-[0.7rem] py-[0.2rem] text-[0.8rem] font-semibold"><?= count($notas) ?> notas</span>
</div>

<?php $errors = session()->getFlashdata('errors'); ?>
<?php if ($errors): ?>
<div class="bg-red-50 text-red-800 border border-red-200 rounded-[10px] mb-4 px-4 py-3 text-sm">
    <?php foreach ($errors as $error): ?>
        <div><i class="fas fa-exclamation-circle mr-1"></i> <?= esc($error) ?></div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Formulario nueva nota -->
<div class="bg-white border border-gray-100 rounded-2xl p-5 mb-6">
    <div class="text-[0.72rem] font-bold uppercase tracking-[0.9px] text-gray-400 mb-4"><i class="fas fa-pen mr-1"></i>Nueva nota</div>
    <form method="POST" action="<?= base_url('admin/notas/crear') ?>">
        <?= csrf_field() ?>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-3">
            <div class="sm:col-span-1">
                <label for="autor" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">Tu nombre</label>
                <input type="text" id="autor" name="autor" required maxlength="100"
                       value="<?= esc(old('autor', session()->get('admin_nombre') ?? '')) ?>"
                       class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]"
                       placeholder="Ej: Hernán">
            </div>
            <div class="sm:col-span-2">
                <label for="contenido" class="text-[0.85rem] font-semibold text-gray-700 mb-1 block">Nota</label>
                <textarea id="contenido" name="contenido" required maxlength="2000" rows="2"
                          class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark bg-white transition-colors outline-none w-full resize-y focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]"
                          placeholder="Recordatorio, recomendación o algo para implementar..."><?= esc(old('contenido', '')) ?></textarea>
            </div>
        </div>
        <button type="submit" class="bg-rojo text-white border-none px-6 py-[0.55rem] rounded-full text-sm font-semibold inline-flex items-center gap-[0.4rem] cursor-pointer transition-colors hover:bg-rojo-dark">
            <i class="fas fa-plus"></i> Agregar nota
        </button>
    </form>
</div>

<!-- Listado de notas -->
<?php if (!empty($notas)): ?>
<div class="flex flex-col gap-3">
    <?php foreach ($notas as $nota): ?>
    <div class="bg-white border border-gray-100 rounded-2xl px-5 py-4 flex items-start justify-between gap-4">
        <div class="flex items-start gap-3 min-w-0">
            <div class="w-9 h-9 bg-rojo/10 text-rojo rounded-full flex items-center justify-center text-[0.85rem] font-bold shrink-0">
                <?= esc(mb_strtoupper(mb_substr($nota['autor'], 0, 1))) ?>
            </div>
            <div class="min-w-0">
                <div class="flex items-center gap-2 flex-wrap mb-1">
                    <span class="font-bold text-dark text-[0.9rem]"><?= esc($nota['autor']) ?></span>
                    <span class="text-[0.75rem] text-gray-400">
                        <i class="far fa-clock mr-1"></i><?= esc(date('d/m/Y H:i', strtotime($nota['created_at']))) ?>
                    </span>
                </div>
                <p class="text-[0.88rem] text-gray-600 leading-relaxed whitespace-pre-line m-0"><?= esc($nota['contenido']) ?></p>
            </div>
        </div>
        <form method="POST" action="<?= base_url("admin/notas/{$nota['id']}/eliminar") ?>" class="shrink-0">
            <?= csrf_field() ?>
            <button type="button" class="bg-transparent border border-red-300 text-red-500 rounded-md w-8 h-8 inline-flex items-center justify-center cursor-pointer transition-colors hover:bg-red-500 hover:text-white"
                    onclick="confirmarEliminarNota(this, '<?= esc($nota['autor']) ?>')" title="Eliminar nota">
                <i class="fas fa-trash text-[0.8rem]"></i>
            </button>
        </form>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.05)]">
    <div class="text-center px-8 py-16 text-gray-400">
        <i class="fas fa-sticky-note text-5xl mb-4 block text-gray-300"></i>
        <h5 class="text-gray-700 font-semibold mb-2">Todavía no hay notas</h5>
        <p class="text-[0.9rem] m-0">Usá el formulario de arriba para dejar la primera.</p>
    </div>
</div>
<?php endif; ?>

<script>
function confirmarEliminarNota(btn, autor) {
    Swal.fire({
        title: '¿Eliminar nota?',
        html: 'La nota de <strong>' + autor + '</strong> se va a eliminar. Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF0033',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then(function (result) {
        if (result.isConfirmed) btn.closest('form').submit();
    });
}

<?php $success = session()->getFlashdata('success'); ?>
<?php if ($success): ?>
Swal.fire({ icon:'success', title:'¡Listo!', text:'<?= addslashes($success) ?>', confirmButtonColor:'#FF0033', timer:2500, timerProgressBar:true });
<?php endif; ?>
</script>

<?= $this->endSection() ?>
