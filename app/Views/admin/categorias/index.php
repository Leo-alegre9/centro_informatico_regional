<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<?php
$badgeActivo   = 'bg-emerald-500/10 text-emerald-600 px-2.5 py-1 rounded-full text-xs font-semibold';
$badgeInactivo = 'bg-red-500/10 text-red-600 px-2.5 py-1 rounded-full text-xs font-semibold';
$btnAccionBase = 'inline-flex items-center justify-center rounded-[6px] px-[0.6rem] py-[0.25rem] text-[0.75rem] font-semibold transition-colors border';
$btnSecondary  = $btnAccionBase . ' border-gray-300 text-gray-600 bg-white hover:bg-gray-100';
$btnWarning    = $btnAccionBase . ' border-amber-400 text-amber-600 bg-white hover:bg-amber-50';
$btnSuccess    = $btnAccionBase . ' border-emerald-400 text-emerald-600 bg-white hover:bg-emerald-50';
$btnDanger     = $btnAccionBase . ' border-red-400 text-red-600 bg-white hover:bg-red-50';
$btnRojo       = 'bg-rojo hover:bg-rojo-dark text-white px-5 py-[0.55rem] rounded-full text-sm font-semibold no-underline inline-flex items-center gap-[0.4rem] transition-colors whitespace-nowrap';
?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
    <h2 class="text-[1.4rem] font-bold text-dark m-0">
        <i class="fas fa-sitemap mr-2 text-rojo text-[1.1rem]"></i>
        Gestión de Categorías
        <span class="text-[0.8rem] font-medium text-gray-400 ml-2"><?= $total ?> en total</span>
    </h2>
    <a href="<?= base_url('admin/categorias/crear') ?>" class="<?= $btnRojo ?>">
        <i class="fas fa-plus"></i> Nueva Categoría
    </a>
</div>

<?php if ($success = session()->getFlashdata('success')): ?>
<div class="bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-[10px] flex items-center gap-2 mb-4 px-4 py-3 text-sm">
    <i class="fas fa-check-circle"></i> <?= esc($success) ?>
</div>
<?php endif; ?>

<?php if (!empty($tree)): ?>

<?php foreach ($tree as $rubro): ?>
<div class="bg-white border border-gray-100 rounded-2xl overflow-hidden mb-5 shadow-[0_1px_4px_rgba(0,0,0,0.04)]" id="rubro-<?= $rubro['id'] ?>">

    <!-- ── Cabecera del rubro (nivel 1) ── -->
    <div class="flex items-center gap-3 px-5 py-[0.9rem] bg-gray-50 border-b border-gray-200 cursor-pointer select-none hover:bg-gray-100"
         onclick="toggleRubro(<?= $rubro['id'] ?>)">
        <div class="w-[34px] h-[34px] rounded-[9px] bg-rojo/10 border-[1.5px] border-rojo/20 flex items-center justify-center text-[0.95rem] text-rojo shrink-0">
            <i class="<?= esc($rubro['icono'] ?: 'fas fa-folder') ?>"></i>
        </div>
        <div class="font-bold text-base text-dark flex-1"><?= esc($rubro['nombre']) ?></div>
        <span class="bg-rojo/10 text-rojo px-2.5 py-1 rounded-full text-xs font-semibold"><?= count($rubro['children']) ?> categorías</span>
        <div class="flex gap-[0.4rem]" onclick="event.stopPropagation()">
            <span class="<?= $rubro['activo'] ? $badgeActivo : $badgeInactivo ?>">
                <?= $rubro['activo'] ? 'Activo' : 'Inactivo' ?>
            </span>
            <a href="<?= base_url("admin/categorias/{$rubro['id']}/editar") ?>"
               class="<?= $btnSecondary ?>" title="Editar">
                <i class="fas fa-pen"></i>
            </a>
            <form method="POST" action="<?= base_url("admin/categorias/{$rubro['id']}/toggle") ?>" class="inline">
                <?= csrf_field() ?>
                <button type="submit" class="<?= $rubro['activo'] ? $btnWarning : $btnSuccess ?>" title="<?= $rubro['activo'] ? 'Desactivar' : 'Activar' ?>">
                    <i class="fas fa-<?= $rubro['activo'] ? 'eye-slash' : 'eye' ?>"></i>
                </button>
            </form>
            <button type="button" class="<?= $btnDanger ?>"
                    onclick="confirmarEliminar(<?= $rubro['id'] ?>, '<?= esc($rubro['nombre']) ?>')"
                    title="Eliminar">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200 text-[0.8rem] ml-2" id="chevron-<?= $rubro['id'] ?>"></i>
    </div>

    <!-- ── Cuerpo: categorías nivel 2 ── -->
    <div class="p-0" id="rubro-body-<?= $rubro['id'] ?>">

        <?php if (!empty($rubro['children'])): ?>
        <?php foreach ($rubro['children'] as $cat2): ?>

        <div class="flex items-center gap-[0.6rem] py-[0.6rem] pr-5 pl-10 border-b border-gray-100 last:border-b-0"
             id="cat2-wrap-<?= $cat2['id'] ?>">
            <?php if (!empty($cat2['children'])): ?>
                <i class="fas fa-chevron-down cursor-pointer text-gray-600 text-xs transition-transform duration-200" id="cat2-toggle-<?= $cat2['id'] ?>" onclick="toggleCat2(<?= $cat2['id'] ?>)" title="Expandir/colapsar"></i>
            <?php else: ?>
                <i class="fas fa-minus text-gray-200 text-[0.7rem] min-w-[13px]"></i>
            <?php endif; ?>

            <i class="<?= esc($cat2['icono'] ?: 'fas fa-folder') ?> text-amber-600 text-[0.85rem] min-w-[16px]"></i>
            <span class="font-semibold text-sm text-gray-700 flex-1"><?= esc($cat2['nombre']) ?></span>
            <code class="text-xs text-gray-400 font-mono"><?= esc($cat2['slug']) ?></code>
            <?php if (!empty($cat2['children'])): ?>
                <span class="text-[0.72rem] text-gray-400"><?= count($cat2['children']) ?> subcategorías</span>
            <?php endif; ?>
            <span class="<?= $cat2['activo'] ? $badgeActivo : $badgeInactivo ?>">
                <?= $cat2['activo'] ? 'Activo' : 'Inactivo' ?>
            </span>
            <div class="flex gap-1">
                <a href="<?= base_url("admin/categorias/{$cat2['id']}/editar") ?>"
                   class="<?= $btnSecondary ?>">
                    <i class="fas fa-pen"></i>
                </a>
                <form method="POST" action="<?= base_url("admin/categorias/{$cat2['id']}/toggle") ?>" class="inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="<?= $cat2['activo'] ? $btnWarning : $btnSuccess ?>">
                        <i class="fas fa-<?= $cat2['activo'] ? 'eye-slash' : 'eye' ?>"></i>
                    </button>
                </form>
                <button type="button" class="<?= $btnDanger ?>"
                        onclick="confirmarEliminar(<?= $cat2['id'] ?>, '<?= esc($cat2['nombre']) ?>')">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>

        <?php if (!empty($cat2['children'])): ?>
        <div class="bg-gray-50 border-t border-gray-100" id="cat3-list-<?= $cat2['id'] ?>">
            <?php foreach ($cat2['children'] as $cat3): ?>
            <div class="flex items-center gap-[0.6rem] py-2 pr-5 pl-16 border-b border-gray-100 last:border-b-0 text-[0.86rem]">
                <i class="fas fa-angle-right text-gray-300 text-xs"></i>
                <i class="<?= esc($cat3['icono'] ?: 'fas fa-tag') ?> text-emerald-600 text-xs min-w-[16px]"></i>
                <span class="text-gray-700 flex-1"><?= esc($cat3['nombre']) ?></span>
                <code class="text-[0.72rem] text-gray-400 font-mono"><?= esc($cat3['slug']) ?></code>
                <span class="<?= $cat3['activo'] ? $badgeActivo : $badgeInactivo ?>">
                    <?= $cat3['activo'] ? 'Activo' : 'Inactivo' ?>
                </span>
                <div class="flex gap-1">
                    <a href="<?= base_url("admin/categorias/{$cat3['id']}/editar") ?>"
                       class="<?= $btnSecondary ?>">
                        <i class="fas fa-pen"></i>
                    </a>
                    <form method="POST" action="<?= base_url("admin/categorias/{$cat3['id']}/toggle") ?>" class="inline">
                        <?= csrf_field() ?>
                        <button type="submit" class="<?= $cat3['activo'] ? $btnWarning : $btnSuccess ?>">
                            <i class="fas fa-<?= $cat3['activo'] ? 'eye-slash' : 'eye' ?>"></i>
                        </button>
                    </form>
                    <button type="button" class="<?= $btnDanger ?>"
                            onclick="confirmarEliminar(<?= $cat3['id'] ?>, '<?= esc($cat3['nombre']) ?>')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <form id="del-<?= $cat3['id'] ?>" method="POST"
                      action="<?= base_url("admin/categorias/{$cat3['id']}/eliminar") ?>" class="hidden">
                    <?= csrf_field() ?>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form id="del-<?= $cat2['id'] ?>" method="POST"
              action="<?= base_url("admin/categorias/{$cat2['id']}/eliminar") ?>" class="hidden">
            <?= csrf_field() ?>
        </form>

        <?php endforeach; ?>
        <?php else: ?>
        <div class="px-6 py-5 text-gray-400 text-[0.87rem]">
            <i class="fas fa-info-circle mr-1"></i> Este rubro no tiene categorías aún.
        </div>
        <?php endif; ?>

    </div>

    <form id="del-<?= $rubro['id'] ?>" method="POST"
          action="<?= base_url("admin/categorias/{$rubro['id']}/eliminar") ?>" class="hidden">
        <?= csrf_field() ?>
    </form>

</div>
<?php endforeach; ?>

<?php else: ?>
<div class="bg-white border border-gray-100 rounded-2xl overflow-hidden mb-5 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <div class="text-center py-16 px-8 text-gray-400">
        <i class="fas fa-sitemap text-5xl mb-4 block text-gray-300"></i>
        <h5 class="text-gray-700 font-semibold mb-2">No hay categorías aún</h5>
        <p>Crea la primera categoría para organizar tu catálogo.</p>
        <a href="<?= base_url('admin/categorias/crear') ?>" class="<?= $btnRojo ?> mt-4">
            <i class="fas fa-plus"></i> Crear categoría
        </a>
    </div>
</div>
<?php endif; ?>

<script>
function toggleRubro(id) {
    var body    = document.getElementById('rubro-body-' + id);
    var chevron = document.getElementById('chevron-' + id);
    body.classList.toggle('hidden');
    chevron.classList.toggle('-rotate-90');
}

function toggleCat2(id) {
    var toggle = document.getElementById('cat2-toggle-' + id);
    var list   = document.getElementById('cat3-list-' + id);
    if (!list) return;
    toggle.classList.toggle('-rotate-90');
    list.classList.toggle('hidden');
}

function confirmarEliminar(id, nombre) {
    Swal.fire({
        title: '¿Eliminar categoría?',
        text: '"' + nombre + '" será eliminada permanentemente.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF0033',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then(function (result) {
        if (result.isConfirmed) {
            document.getElementById('del-' + id).submit();
        }
    });
}
</script>

<?= $this->endSection() ?>
