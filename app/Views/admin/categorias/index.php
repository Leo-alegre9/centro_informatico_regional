<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<style>
    .page-header-row {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;
    }
    .page-header-row h2 { font-size: 1.4rem; font-weight: 700; color: #111827; margin: 0; }
    .btn-rojo {
        background: #FF0033; color: #fff; border: none;
        padding: 0.55rem 1.25rem; border-radius: 50px;
        font-size: 0.9rem; font-weight: 600; text-decoration: none;
        display: inline-flex; align-items: center; gap: 0.4rem;
        transition: background 0.2s; white-space: nowrap;
    }
    .btn-rojo:hover { background: #cc0028; color: #fff; }

    /* ── Árbol de categorías ── */
    .rubro-block {
        background: #fff; border: 1px solid #e5e7eb; border-radius: 14px;
        overflow: hidden; margin-bottom: 1.25rem; box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }
    .rubro-header {
        display: flex; align-items: center; gap: 0.75rem;
        padding: 0.9rem 1.25rem; background: #f9fafb;
        border-bottom: 1px solid #e5e7eb; cursor: pointer;
        user-select: none;
    }
    .rubro-header:hover { background: #f3f4f6; }
    .rubro-header .rubro-icon {
        width: 34px; height: 34px; border-radius: 9px;
        background: rgba(255,0,51,0.08); border: 1.5px solid rgba(255,0,51,0.18);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.95rem; color: #FF0033; flex-shrink: 0;
    }
    .rubro-header .rubro-nombre { font-weight: 700; font-size: 1rem; color: #111827; flex: 1; }
    .rubro-header .rubro-badge {
        background: rgba(255,0,51,0.08); color: #FF0033;
        padding: 0.15rem 0.55rem; border-radius: 50px;
        font-size: 0.75rem; font-weight: 600;
    }
    .rubro-header .rubro-acciones { display: flex; gap: 0.4rem; }
    .rubro-header .chevron {
        color: #9CA3AF; transition: transform 0.2s; font-size: 0.8rem;
    }
    .rubro-block.collapsed .chevron { transform: rotate(-90deg); }
    .rubro-body { padding: 0; }
    .rubro-block.collapsed .rubro-body { display: none; }

    .cat2-row {
        display: flex; align-items: center; gap: 0.6rem;
        padding: 0.6rem 1.25rem 0.6rem 2.5rem;
        border-bottom: 1px solid #f3f4f6;
    }
    .cat2-row:last-child { border-bottom: none; }
    .cat2-row .cat2-toggle { cursor: pointer; color: #9CA3AF; font-size: 0.75rem; transition: transform 0.2s; }
    .cat2-row.has-children .cat2-toggle { color: #6B7280; }
    .cat2-row.collapsed-2 .cat2-toggle { transform: rotate(-90deg); }
    .cat2-row .cat2-icon { color: #d97706; font-size: 0.85rem; min-width: 16px; }
    .cat2-row .cat2-nombre { font-weight: 600; font-size: 0.9rem; color: #374151; flex: 1; }
    .cat2-row .cat2-slug { font-size: 0.75rem; color: #9CA3AF; font-family: monospace; }
    .cat2-row .cat2-activo { }

    .cat3-list { background: #fafafa; border-top: 1px solid #f0f0f0; }
    .cat3-row {
        display: flex; align-items: center; gap: 0.6rem;
        padding: 0.5rem 1.25rem 0.5rem 4rem;
        border-bottom: 1px solid #f3f4f6; font-size: 0.86rem;
    }
    .cat3-row:last-child { border-bottom: none; }
    .cat3-row .cat3-icon { color: #059669; font-size: 0.8rem; min-width: 16px; }
    .cat3-row .cat3-nombre { color: #374151; flex: 1; }
    .cat3-row .cat3-slug { font-size: 0.72rem; color: #9CA3AF; font-family: monospace; }

    .badge-activo   { background: rgba(16,185,129,0.12); color: #059669; padding: 0.15rem 0.5rem; border-radius: 50px; font-size: 0.72rem; font-weight: 600; }
    .badge-inactivo { background: rgba(239,68,68,0.1);  color: #DC2626;  padding: 0.15rem 0.5rem; border-radius: 50px; font-size: 0.72rem; font-weight: 600; }
    .btn-accion { padding: 0.25rem 0.6rem; font-size: 0.75rem; border-radius: 6px; font-weight: 600; }

    .empty-state { text-align: center; padding: 4rem 2rem; color: #9CA3AF; }
    .empty-state i { font-size: 3rem; margin-bottom: 1rem; display: block; color: #D1D5DB; }
    .empty-state h5 { color: #374151; font-weight: 600; margin-bottom: 0.5rem; }
</style>

<div class="page-header-row">
    <h2>
        <i class="fas fa-sitemap me-2" style="color:#FF0033;font-size:1.1rem;"></i>
        Gestión de Categorías
        <span style="font-size:0.8rem;font-weight:500;color:#9CA3AF;margin-left:0.5rem;"><?= $total ?> en total</span>
    </h2>
    <a href="<?= base_url('admin/categorias/crear') ?>" class="btn-rojo">
        <i class="fas fa-plus"></i> Nueva Categoría
    </a>
</div>

<?php if ($success = session()->getFlashdata('success')): ?>
<div class="alert alert-success d-flex align-items-center gap-2 mb-3" style="border-radius:10px;">
    <i class="fas fa-check-circle"></i> <?= esc($success) ?>
</div>
<?php endif; ?>

<?php if (!empty($tree)): ?>

<?php foreach ($tree as $rubro): ?>
<div class="rubro-block" id="rubro-<?= $rubro['id'] ?>">

    <!-- ── Cabecera del rubro (nivel 1) ── -->
    <div class="rubro-header" onclick="toggleRubro(<?= $rubro['id'] ?>)">
        <div class="rubro-icon"><i class="<?= esc($rubro['icono'] ?: 'fas fa-folder') ?>"></i></div>
        <div class="rubro-nombre"><?= esc($rubro['nombre']) ?></div>
        <span class="rubro-badge"><?= count($rubro['children']) ?> categorías</span>
        <div class="rubro-acciones" onclick="event.stopPropagation()">
            <span class="<?= $rubro['activo'] ? 'badge-activo' : 'badge-inactivo' ?>">
                <?= $rubro['activo'] ? 'Activo' : 'Inactivo' ?>
            </span>
            <a href="<?= base_url("admin/categorias/{$rubro['id']}/editar") ?>"
               class="btn btn-sm btn-outline-secondary btn-accion" title="Editar">
                <i class="fas fa-pen"></i>
            </a>
            <form method="POST" action="<?= base_url("admin/categorias/{$rubro['id']}/toggle") ?>" style="display:inline;">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-sm btn-accion <?= $rubro['activo'] ? 'btn-outline-warning' : 'btn-outline-success' ?>" title="<?= $rubro['activo'] ? 'Desactivar' : 'Activar' ?>">
                    <i class="fas fa-<?= $rubro['activo'] ? 'eye-slash' : 'eye' ?>"></i>
                </button>
            </form>
            <button type="button" class="btn btn-sm btn-outline-danger btn-accion"
                    onclick="confirmarEliminar(<?= $rubro['id'] ?>, '<?= esc($rubro['nombre']) ?>')"
                    title="Eliminar">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <i class="fas fa-chevron-down chevron ms-2"></i>
    </div>

    <!-- ── Cuerpo: categorías nivel 2 ── -->
    <div class="rubro-body">

        <?php if (!empty($rubro['children'])): ?>
        <?php foreach ($rubro['children'] as $cat2): ?>

        <div class="cat2-row <?= !empty($cat2['children']) ? 'has-children' : '' ?>"
             id="cat2-wrap-<?= $cat2['id'] ?>">
            <?php if (!empty($cat2['children'])): ?>
                <i class="fas fa-chevron-down cat2-toggle" onclick="toggleCat2(<?= $cat2['id'] ?>)" title="Expandir/colapsar"></i>
            <?php else: ?>
                <i class="fas fa-minus" style="color:#e5e7eb;font-size:0.7rem;min-width:13px;"></i>
            <?php endif; ?>

            <i class="<?= esc($cat2['icono'] ?: 'fas fa-folder') ?> cat2-icon"></i>
            <span class="cat2-nombre"><?= esc($cat2['nombre']) ?></span>
            <code class="cat2-slug"><?= esc($cat2['slug']) ?></code>
            <?php if (!empty($cat2['children'])): ?>
                <span style="font-size:0.72rem;color:#9CA3AF;"><?= count($cat2['children']) ?> subcategorías</span>
            <?php endif; ?>
            <span class="<?= $cat2['activo'] ? 'badge-activo' : 'badge-inactivo' ?>">
                <?= $cat2['activo'] ? 'Activo' : 'Inactivo' ?>
            </span>
            <div class="d-flex gap-1">
                <a href="<?= base_url("admin/categorias/{$cat2['id']}/editar") ?>"
                   class="btn btn-sm btn-outline-secondary btn-accion">
                    <i class="fas fa-pen"></i>
                </a>
                <form method="POST" action="<?= base_url("admin/categorias/{$cat2['id']}/toggle") ?>" style="display:inline;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-sm btn-accion <?= $cat2['activo'] ? 'btn-outline-warning' : 'btn-outline-success' ?>">
                        <i class="fas fa-<?= $cat2['activo'] ? 'eye-slash' : 'eye' ?>"></i>
                    </button>
                </form>
                <button type="button" class="btn btn-sm btn-outline-danger btn-accion"
                        onclick="confirmarEliminar(<?= $cat2['id'] ?>, '<?= esc($cat2['nombre']) ?>')">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>

        <?php if (!empty($cat2['children'])): ?>
        <div class="cat3-list" id="cat3-list-<?= $cat2['id'] ?>">
            <?php foreach ($cat2['children'] as $cat3): ?>
            <div class="cat3-row">
                <i class="fas fa-angle-right" style="color:#d1d5db;font-size:0.75rem;"></i>
                <i class="<?= esc($cat3['icono'] ?: 'fas fa-tag') ?> cat3-icon"></i>
                <span class="cat3-nombre"><?= esc($cat3['nombre']) ?></span>
                <code class="cat3-slug"><?= esc($cat3['slug']) ?></code>
                <span class="<?= $cat3['activo'] ? 'badge-activo' : 'badge-inactivo' ?>">
                    <?= $cat3['activo'] ? 'Activo' : 'Inactivo' ?>
                </span>
                <div class="d-flex gap-1">
                    <a href="<?= base_url("admin/categorias/{$cat3['id']}/editar") ?>"
                       class="btn btn-sm btn-outline-secondary btn-accion">
                        <i class="fas fa-pen"></i>
                    </a>
                    <form method="POST" action="<?= base_url("admin/categorias/{$cat3['id']}/toggle") ?>" style="display:inline;">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-sm btn-accion <?= $cat3['activo'] ? 'btn-outline-warning' : 'btn-outline-success' ?>">
                            <i class="fas fa-<?= $cat3['activo'] ? 'eye-slash' : 'eye' ?>"></i>
                        </button>
                    </form>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-accion"
                            onclick="confirmarEliminar(<?= $cat3['id'] ?>, '<?= esc($cat3['nombre']) ?>')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <form id="del-<?= $cat3['id'] ?>" method="POST"
                      action="<?= base_url("admin/categorias/{$cat3['id']}/eliminar") ?>" style="display:none;">
                    <?= csrf_field() ?>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form id="del-<?= $cat2['id'] ?>" method="POST"
              action="<?= base_url("admin/categorias/{$cat2['id']}/eliminar") ?>" style="display:none;">
            <?= csrf_field() ?>
        </form>

        <?php endforeach; ?>
        <?php else: ?>
        <div style="padding:1.25rem 1.5rem;color:#9CA3AF;font-size:0.87rem;">
            <i class="fas fa-info-circle me-1"></i> Este rubro no tiene categorías aún.
        </div>
        <?php endif; ?>

    </div>

    <form id="del-<?= $rubro['id'] ?>" method="POST"
          action="<?= base_url("admin/categorias/{$rubro['id']}/eliminar") ?>" style="display:none;">
        <?= csrf_field() ?>
    </form>

</div>
<?php endforeach; ?>

<?php else: ?>
<div class="rubro-block">
    <div class="empty-state">
        <i class="fas fa-sitemap"></i>
        <h5>No hay categorías aún</h5>
        <p>Crea la primera categoría para organizar tu catálogo.</p>
        <a href="<?= base_url('admin/categorias/crear') ?>" class="btn-rojo">
            <i class="fas fa-plus"></i> Crear categoría
        </a>
    </div>
</div>
<?php endif; ?>

<script>
function toggleRubro(id) {
    var block = document.getElementById('rubro-' + id);
    block.classList.toggle('collapsed');
}

function toggleCat2(id) {
    var row  = document.getElementById('cat2-wrap-' + id);
    var list = document.getElementById('cat3-list-' + id);
    if (!list) return;
    row.classList.toggle('collapsed-2');
    list.style.display = list.style.display === 'none' ? '' : 'none';
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
