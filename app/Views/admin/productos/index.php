<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<style>
    .page-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
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
    .btn-star { background: none; border: none; cursor: pointer; padding: 0.2rem 0.4rem; border-radius: 6px; transition: background 0.15s; font-size: 1rem; line-height: 1; }
    .btn-star:hover { background: rgba(245,158,11,0.12); }
    .btn-star .fa-star { color: #f59e0b; }
    .btn-star .fa-star-o, .btn-star .empty-star { color: #D1D5DB; }
    .cat-path { background: #f3f4f6; color: #6B7280; padding: 0.15rem 0.55rem; border-radius: 50px; font-size: 0.75rem; font-weight: 600; }
    .btn-accion { padding: 0.3rem 0.7rem; font-size: 0.78rem; border-radius: 7px; font-weight: 600; }
    .empty-state { text-align: center; padding: 4rem 2rem; color: #9CA3AF; }
    .empty-state i { font-size: 3rem; margin-bottom: 1rem; display: block; color: #D1D5DB; }
    .empty-state h5 { color: #374151; font-weight: 600; margin-bottom: 0.5rem; }
    .empty-state p  { font-size: 0.9rem; margin-bottom: 1.5rem; }

    .sec-dot {
        display: inline-flex; align-items: center; gap: 3px;
        font-size: 0.68rem; font-weight: 600; padding: 0.12rem 0.45rem;
        border-radius: 50px; white-space: nowrap;
    }
    .sec-dot.inicio      { background: rgba(239,68,68,0.1);   color: #DC2626; }
    .sec-dot.catalogo    { background: rgba(59,130,246,0.1);  color: #2563EB; }
    .sec-dot.rubro       { background: rgba(245,158,11,0.1);  color: #D97706; }
    .sec-dot.subrubro    { background: rgba(16,185,129,0.1);  color: #059669; }
    .sec-dot.destacado   { background: rgba(139,92,246,0.1);  color: #7C3AED; }
    .sec-dot.carrusel_promo { background: rgba(236,72,153,0.1); color: #BE185D; }
    .secciones-cell { display: flex; flex-wrap: wrap; gap: 3px; min-width: 120px; }
</style>

<div class="page-header-row">
    <h2><i class="fas fa-box me-2" style="color:#FF0033;font-size:1.1rem;"></i>Gestión de Productos</h2>
    <a href="<?= base_url('admin/productos/crear') ?>" class="btn-rojo">
        <i class="fas fa-plus"></i> Nuevo Producto
    </a>
</div>

<div class="filtros-bar">
    <label for="filtroBuscar"><i class="fas fa-search me-1"></i>Buscar:</label>
    <input type="text" id="filtroBuscar" placeholder="Nombre, categoría o badge..." oninput="filtrarTabla(this.value)">
    <span class="count-badge" id="countVisible"><?= count($productos) ?> productos</span>
</div>

<?php if (!empty($productos)): ?>
<div class="tabla-card">
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Código</th>
                    <th>Categoría</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Badge</th>
                    <th>Activo</th>
                    <th>Secciones</th>
                    <th title="Carrusel destacado (catálogo)"><i class="fas fa-star" style="color:#f59e0b;"></i></th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaBody">
                <?php foreach ($productos as $i => $p): ?>
                <?php
                    $secIconos = [
                        'inicio'         => ['icono' => 'fa-home',       'label' => 'Inicio'],
                        'catalogo'       => ['icono' => 'fa-th-large',   'label' => 'Catálogo'],
                        'rubro'          => ['icono' => 'fa-folder-open','label' => 'Rubro'],
                        'subrubro'       => ['icono' => 'fa-tag',        'label' => 'Subrubro'],
                        'destacado'      => ['icono' => 'fa-star',       'label' => 'Dest.'],
                        'carrusel_promo' => ['icono' => 'fa-bullhorn',   'label' => 'Promo'],
                    ];
                ?>
                <tr data-busqueda="<?= strtolower(esc($p['nombre']) . ' ' . esc($p['categoria_path'] ?? '') . ' ' . esc($p['badge']) . ' ' . esc($p['codigo'] ?? '')) ?>">
                    <td style="color:#9CA3AF;font-size:0.8rem;"><?= $i + 1 ?></td>
                    <td>
                        <?php if (!empty($p['codigo'])): ?>
                            <span style="background:rgba(99,102,241,0.1);color:#4F46E5;padding:0.15rem 0.55rem;border-radius:50px;font-size:0.75rem;font-weight:700;font-family:monospace;">
                                <?= esc($p['codigo']) ?>
                            </span>
                        <?php else: ?>
                            <span style="color:#D1D5DB;font-size:0.8rem;">—</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="cat-path"><?= esc($p['categoria_path'] ?? '—') ?></span>
                    </td>
                    <td>
                        <div style="font-weight:600;color:#111827;"><?= esc($p['nombre']) ?></div>
                        <?php if (!empty($p['descripcion_corta'])): ?>
                        <div style="font-size:0.78rem;color:#9CA3AF;margin-top:2px;">
                            <i class="<?= esc($p['icono']) ?> me-1"></i><?= esc(mb_substr($p['descripcion_corta'], 0, 60)) ?>...
                        </div>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:0.85rem;"><?= esc($p['precio_texto']) ?></td>
                    <td>
                        <?php if ($p['badge']): ?>
                            <span style="background:rgba(255,0,51,0.08);color:#FF0033;padding:0.15rem 0.5rem;border-radius:50px;font-size:0.75rem;font-weight:600;">
                                <?= esc($p['badge']) ?>
                            </span>
                        <?php else: ?>
                            <span style="color:#D1D5DB;">—</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($p['activo']): ?>
                            <span class="badge-activo"><i class="fas fa-check me-1"></i>Sí</span>
                        <?php else: ?>
                            <span class="badge-inactivo"><i class="fas fa-times me-1"></i>No</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($p['secciones_slugs'])): ?>
                        <div class="secciones-cell">
                            <?php foreach ($p['secciones_slugs'] as $slug): ?>
                            <?php if (isset($secIconos[$slug])): ?>
                            <span class="sec-dot <?= $slug ?>" title="<?= $secIconos[$slug]['label'] ?>">
                                <i class="fas <?= $secIconos[$slug]['icono'] ?>"></i>
                                <?= $secIconos[$slug]['label'] ?>
                            </span>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <?php else: ?>
                            <span style="color:#D1D5DB;font-size:0.8rem;">Sin secciones</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <form method="POST" action="<?= base_url("admin/productos/{$p['id']}/destacado") ?>" style="display:inline;">
                            <button type="submit" class="btn-star"
                                    title="<?= $p['destacado'] ? 'Quitar de destacados' : 'Marcar como destacado' ?>">
                                <?php if ($p['destacado']): ?>
                                    <i class="fas fa-star"></i>
                                <?php else: ?>
                                    <i class="fas fa-star empty-star"></i>
                                <?php endif; ?>
                            </button>
                        </form>
                    </td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <a href="<?= base_url("admin/productos/{$p['id']}/editar") ?>"
                               class="btn btn-outline-primary btn-accion">
                                <i class="fas fa-pen me-1"></i>Editar
                            </a>
                            <form method="POST" action="<?= base_url("admin/productos/{$p['id']}/eliminar") ?>" style="display:inline;">
                                <button type="button" class="btn btn-outline-danger btn-accion"
                                        onclick="confirmarEliminar(this, '<?= esc($p['nombre']) ?>')">
                                    <i class="fas fa-trash me-1"></i>Eliminar
                                </button>
                            </form>
                        </div>
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
        <i class="fas fa-box-open"></i>
        <h5>No hay productos cargados</h5>
        <p>Todavía no agregaste ningún producto al catálogo.</p>
        <a href="<?= base_url('admin/productos/crear') ?>" class="btn-rojo">
            <i class="fas fa-plus me-1"></i>Agregar primer producto
        </a>
    </div>
</div>
<?php endif; ?>

<script>
    function filtrarTabla(texto) {
        const q       = texto.toLowerCase();
        const filas   = document.querySelectorAll('#tablaBody tr');
        let visible   = 0;
        filas.forEach(function (fila) {
            const busqueda = fila.getAttribute('data-busqueda') || '';
            const mostrar  = !q || busqueda.includes(q);
            fila.style.display = mostrar ? '' : 'none';
            if (mostrar) visible++;
        });
        document.getElementById('countVisible').textContent = visible + ' producto' + (visible !== 1 ? 's' : '');
    }

    function confirmarEliminar(btn, nombre) {
        Swal.fire({
            title: '¿Eliminar producto?',
            html: 'Estás por eliminar <strong>' + nombre + '</strong>. Esta acción no se puede deshacer.',
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
    Swal.fire({ icon:'success', title:'¡Listo!', text:'<?= addslashes($success) ?>', confirmButtonColor:'#FF0033', timer:3000, timerProgressBar:true });
    <?php endif; ?>

    <?php $error = session()->getFlashdata('error'); ?>
    <?php if ($error): ?>
    Swal.fire({ icon:'error', title:'Error', text:'<?= addslashes($error) ?>', confirmButtonColor:'#FF0033' });
    <?php endif; ?>
</script>

<?= $this->endSection() ?>
