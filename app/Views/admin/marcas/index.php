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
    .filtros-bar {
        background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
        padding: 1rem 1.25rem; margin-bottom: 1.25rem;
        display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
    }
    .filtros-bar label { font-size: 0.85rem; font-weight: 600; color: #374151; margin: 0; }
    .filtros-bar input {
        border: 1.5px solid #e5e7eb; border-radius: 8px; padding: 0.4rem 0.9rem;
        font-size: 0.88rem; color: #374151; background: #f9fafb; outline: none;
        transition: border-color 0.2s; flex: 1; min-width: 180px;
    }
    .filtros-bar input:focus { border-color: #FF0033; }
    .count-badge {
        background: rgba(255,0,51,0.08); color: #FF0033; border-radius: 50px;
        padding: 0.2rem 0.7rem; font-size: 0.8rem; font-weight: 600; margin-left: auto;
    }
    .tabla-card {
        background: #fff; border: 1px solid #e5e7eb; border-radius: 14px;
        overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }
    .table { margin: 0; font-size: 0.88rem; }
    .table thead th {
        background: #f9fafb; color: #374151; font-weight: 700;
        font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px;
        border-bottom: 2px solid #e5e7eb; padding: 0.85rem 1rem; white-space: nowrap;
    }
    .table tbody td { vertical-align: middle; padding: 0.75rem 1rem; border-color: #f3f4f6; color: #374151; }
    .table tbody tr:hover { background: #fafafa; }
    .badge-activo   { background: rgba(16,185,129,0.12); color: #059669; padding: 0.2rem 0.6rem; border-radius: 50px; font-size: 0.75rem; font-weight: 600; }
    .badge-inactivo { background: rgba(239,68,68,0.1);  color: #DC2626;  padding: 0.2rem 0.6rem; border-radius: 50px; font-size: 0.75rem; font-weight: 600; }
    .btn-accion { padding: 0.3rem 0.7rem; font-size: 0.78rem; border-radius: 7px; font-weight: 600; }
    .marca-logo {
        width: 40px; height: 40px; border-radius: 8px; object-fit: contain;
        border: 1px solid #e5e7eb; background: #f9fafb; padding: 3px;
    }
    .logo-placeholder {
        width: 40px; height: 40px; border-radius: 8px; background: #f3f4f6;
        display: flex; align-items: center; justify-content: center; color: #d1d5db; font-size: 1.1rem;
    }
    .empty-state { text-align: center; padding: 4rem 2rem; color: #9CA3AF; }
    .empty-state i { font-size: 3rem; margin-bottom: 1rem; display: block; color: #D1D5DB; }
    .empty-state h5 { color: #374151; font-weight: 600; margin-bottom: 0.5rem; }
</style>

<div class="page-header-row">
    <h2><i class="fas fa-tag me-2" style="color:#FF0033;font-size:1.1rem;"></i>Gestión de Marcas</h2>
    <a href="<?= base_url('admin/marcas/crear') ?>" class="btn-rojo">
        <i class="fas fa-plus"></i> Nueva Marca
    </a>
</div>

<?php if ($success = session()->getFlashdata('success')): ?>
<div class="alert alert-success d-flex align-items-center gap-2 mb-3" style="border-radius:10px;">
    <i class="fas fa-check-circle"></i> <?= esc($success) ?>
</div>
<?php endif; ?>

<div class="filtros-bar">
    <label for="filtroBuscar"><i class="fas fa-search me-1"></i>Buscar:</label>
    <input type="text" id="filtroBuscar" placeholder="Nombre o slug..." oninput="filtrarTabla(this.value)">
    <span class="count-badge" id="countVisible"><?= count($marcas) ?> marcas</span>
</div>

<?php if (!empty($marcas)): ?>
<div class="tabla-card">
    <div class="table-responsive">
        <table class="table" id="tablaMarcas">
            <thead>
                <tr>
                    <th>Logo</th>
                    <th>Nombre</th>
                    <th>Slug</th>
                    <th>Sitio web</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($marcas as $marca): ?>
                <tr data-busqueda="<?= esc(strtolower($marca['nombre'] . ' ' . $marca['slug'])) ?>">
                    <td>
                        <?php if (!empty($marca['logo_url'])): ?>
                            <img src="<?= esc($marca['logo_url']) ?>" alt="<?= esc($marca['nombre']) ?>" class="marca-logo"
                                 onerror="this.style.display='none'">
                        <?php else: ?>
                            <div class="logo-placeholder"><i class="fas fa-image"></i></div>
                        <?php endif; ?>
                    </td>
                    <td><strong style="color:#111827;"><?= esc($marca['nombre']) ?></strong></td>
                    <td><code style="font-size:0.78rem;color:#374151;"><?= esc($marca['slug']) ?></code></td>
                    <td>
                        <?php if (!empty($marca['sitio_web'])): ?>
                            <a href="<?= esc($marca['sitio_web']) ?>" target="_blank"
                               style="color:#4f46e5;font-size:0.82rem;">
                                <i class="fas fa-external-link-alt me-1"></i><?= esc(parse_url($marca['sitio_web'], PHP_URL_HOST) ?: $marca['sitio_web']) ?>
                            </a>
                        <?php else: ?>
                            <span style="color:#D1D5DB;font-size:0.82rem;">—</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="<?= $marca['activo'] ? 'badge-activo' : 'badge-inactivo' ?>">
                            <?= $marca['activo'] ? 'Activa' : 'Inactiva' ?>
                        </span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-1">
                            <a href="<?= base_url("admin/marcas/{$marca['id']}/editar") ?>"
                               class="btn btn-sm btn-outline-secondary btn-accion">
                                <i class="fas fa-pen"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-accion"
                                    onclick="confirmarEliminar(<?= $marca['id'] ?>, '<?= esc($marca['nombre']) ?>')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <form id="del-<?= $marca['id'] ?>" method="POST"
                              action="<?= base_url("admin/marcas/{$marca['id']}/eliminar") ?>" style="display:none;">
                            <?= csrf_field() ?>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
<div class="tabla-card">
    <div class="empty-state">
        <i class="fas fa-tag"></i>
        <h5>No hay marcas aún</h5>
        <p>Agregá marcas para asociarlas a los productos del catálogo.</p>
        <a href="<?= base_url('admin/marcas/crear') ?>" class="btn-rojo">
            <i class="fas fa-plus"></i> Crear marca
        </a>
    </div>
</div>
<?php endif; ?>

<script>
function filtrarTabla(q) {
    q = q.toLowerCase().trim();
    var rows = document.querySelectorAll('#tablaMarcas tbody tr');
    var vis  = 0;
    rows.forEach(function (r) {
        var show = !q || r.dataset.busqueda.includes(q);
        r.style.display = show ? '' : 'none';
        if (show) vis++;
    });
    document.getElementById('countVisible').textContent = vis + ' marcas';
}

function confirmarEliminar(id, nombre) {
    Swal.fire({
        title: '¿Eliminar marca?',
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
