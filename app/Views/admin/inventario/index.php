<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<style>
    .inv-form-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 1.75rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        margin-bottom: 1.75rem;
    }
    .inv-form-card .form-label {
        font-size: 0.85rem; font-weight: 600; color: #374151; margin-bottom: 0.3rem;
    }
    .inv-form-card .form-control,
    .inv-form-card .form-select {
        border: 1.5px solid #e5e7eb; border-radius: 9px;
        padding: 0.6rem 0.95rem; font-size: 0.92rem; color: #111827;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .inv-form-card .form-control:focus,
    .inv-form-card .form-select:focus {
        border-color: #FF0033; box-shadow: 0 0 0 3px rgba(255,0,51,0.1); outline: none;
    }
    .btn-buscar {
        background: #FF0033; color: #fff; border: none;
        padding: 0.65rem 1.75rem; border-radius: 50px;
        font-size: 0.92rem; font-weight: 600;
        display: inline-flex; align-items: center; gap: 0.4rem;
        transition: background 0.2s; cursor: pointer;
    }
    .btn-buscar:hover { background: #cc0028; }
    .btn-limpiar {
        color: #6B7280; text-decoration: none;
        padding: 0.65rem 1.2rem; border-radius: 50px;
        font-size: 0.92rem; font-weight: 600;
        border: 1.5px solid #e5e7eb; display: inline-flex;
        align-items: center; gap: 0.4rem; transition: background 0.15s;
    }
    .btn-limpiar:hover { background: #f3f4f6; color: #374151; }

    .page-header { margin-bottom: 1.75rem; }
    .page-header h2 { font-size: 1.4rem; font-weight: 700; color: #111827; margin-bottom: 0.2rem; }
    .page-header p { color: #6B7280; font-size: 0.92rem; margin: 0; }

    .results-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }
    .results-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 0.5rem;
    }
    .results-header .results-title {
        font-size: 0.92rem; font-weight: 700; color: #111827;
    }
    .results-header .results-count {
        background: rgba(255,0,51,0.08); color: #FF0033;
        font-size: 0.78rem; font-weight: 700;
        padding: 0.2rem 0.65rem; border-radius: 50px;
    }
    .inv-table { width: 100%; border-collapse: collapse; font-size: 0.87rem; }
    .inv-table th {
        background: #f9fafb;
        color: #6B7280; font-size: 0.72rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.8px;
        padding: 0.7rem 1.2rem; border-bottom: 1px solid #f0f0f0;
        white-space: nowrap; text-align: left;
    }
    .inv-table td {
        padding: 0.85rem 1.2rem;
        border-bottom: 1px solid #f8f9fa;
        color: #374151; vertical-align: middle;
    }
    .inv-table tr:last-child td { border-bottom: none; }
    .inv-table tr:hover td { background: #fafafa; }
    .inv-nombre { font-weight: 700; color: #111827; }
    .inv-modelo { font-size: 0.78rem; color: #9CA3AF; }
    .inv-categoria { font-size: 0.78rem; color: #6B7280; }
    .inv-marca { font-size: 0.82rem; color: #6B7280; }
    .inv-precio { font-weight: 600; color: #111827; font-size: 0.85rem; }
    .badge-ubicacion {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 0.3rem 0.75rem; border-radius: 50px;
        font-size: 0.75rem; font-weight: 700; white-space: nowrap;
    }
    .ubic-negocio    { background: rgba(16,185,129,0.1);  color: #065f46; }
    .ubic-deposito-a { background: rgba(59,130,246,0.1);  color: #1e40af; }
    .ubic-deposito-b { background: rgba(245,158,11,0.1);  color: #92400e; }
    .ubic-deposito-c { background: rgba(139,92,246,0.1);  color: #5b21b6; }
    .ubic-sin        { background: rgba(156,163,175,0.15); color: #6B7280; }

    .estado-badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 0.2rem 0.6rem; border-radius: 50px; font-size: 0.73rem; font-weight: 700;
    }
    .estado-activo   { background: rgba(16,185,129,0.1); color: #065f46; }
    .estado-inactivo { background: rgba(156,163,175,0.15); color: #6B7280; }

    .empty-state {
        text-align: center; padding: 4rem 2rem;
    }
    .empty-state i { font-size: 3rem; color: #dee2e6; margin-bottom: 1rem; display: block; }
    .empty-state h5 { font-size: 1rem; font-weight: 700; color: #374151; margin-bottom: 0.4rem; }
    .empty-state p { font-size: 0.88rem; color: #9CA3AF; margin: 0; }

    .estado-inicial {
        text-align: center; padding: 4rem 2rem;
    }
    .estado-inicial i { font-size: 3rem; color: #dee2e6; margin-bottom: 1rem; display: block; }
    .estado-inicial p { font-size: 0.9rem; color: #9CA3AF; margin: 0; }

    .btn-editar-prod {
        display: inline-flex; align-items: center; gap: 4px;
        color: #6B7280; font-size: 0.78rem; text-decoration: none;
        padding: 0.25rem 0.6rem; border: 1px solid #e5e7eb;
        border-radius: 6px; transition: border-color 0.15s, color 0.15s;
    }
    .btn-editar-prod:hover { border-color: #FF0033; color: #FF0033; }
</style>

<div class="page-header">
    <h2><i class="fas fa-warehouse me-2" style="color:#FF0033;font-size:1.1rem;"></i>Inventario por ubicación</h2>
    <p>Buscá productos según el lugar donde se encuentran. Solo visible para el administrador.</p>
</div>

<!-- Formulario de búsqueda -->
<div class="inv-form-card">
    <form method="GET" action="<?= base_url('admin/inventario') ?>">
        <div class="row g-3 align-items-end">
            <div class="col-12 col-md-4">
                <label for="ubicacion" class="form-label">
                    <i class="fas fa-map-marker-alt me-1" style="color:#FF0033;"></i>Ubicación
                </label>
                <select id="ubicacion" name="ubicacion" class="form-select">
                    <option value="">— Todas las ubicaciones —</option>
                    <option value="En el negocio"        <?= $ubicacion === 'En el negocio'        ? 'selected' : '' ?>>En el negocio</option>
                    <option value="Deposito nuevo local"  <?= $ubicacion === 'Deposito nuevo local'  ? 'selected' : '' ?>>Deposito nuevo local</option>
                    <option value="Deposito quincho"     <?= $ubicacion === 'Deposito quincho'     ? 'selected' : '' ?>>Deposito quincho</option>
                    <option value="Deposito casa"        <?= $ubicacion === 'Deposito casa'        ? 'selected' : '' ?>>Deposito casa</option>
                </select>
            </div>
            <div class="col-12 col-md-5">
                <label for="q" class="form-label">
                    <i class="fas fa-search me-1" style="color:#FF0033;"></i>Buscar producto
                </label>
                <input type="text" id="q" name="q" class="form-control"
                       value="<?= esc($q) ?>"
                       placeholder="Nombre, modelo, marca...">
            </div>
            <div class="col-12 col-md-3">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn-buscar">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    <?php if ($buscando): ?>
                    <a href="<?= base_url('admin/inventario') ?>" class="btn-limpiar">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Resultados -->
<div class="results-card">
    <?php if (!$buscando): ?>
        <div class="estado-inicial">
            <i class="fas fa-warehouse"></i>
            <p>Seleccioná una ubicación o escribí el nombre de un producto para buscar.</p>
        </div>
    <?php elseif (empty($productos)): ?>
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <h5>Sin resultados</h5>
            <p>No se encontraron productos que coincidan con los filtros seleccionados.</p>
        </div>
    <?php else: ?>
        <div class="results-header">
            <span class="results-title">
                <i class="fas fa-list me-1" style="color:#FF0033;"></i>
                <?php if ($ubicacion): ?>
                    Productos en <strong><?= esc($ubicacion) ?></strong>
                    <?php if ($q): ?> que coinciden con <strong>"<?= esc($q) ?>"</strong><?php endif; ?>
                <?php else: ?>
                    Resultados para <strong>"<?= esc($q) ?>"</strong>
                <?php endif; ?>
            </span>
            <span class="results-count"><?= count($productos) ?> producto<?= count($productos) !== 1 ? 's' : '' ?></span>
        </div>
        <div style="overflow-x:auto;">
            <table class="inv-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Marca</th>
                        <th>Precio</th>
                        <th>Ubicación</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($productos as $p): ?>
                    <?php
                        $ubic = $p['ubicacion'] ?? '';
                        $ubicClase = match($ubic) {
                            'En el negocio'        => 'ubic-negocio',
                            'Deposito nuevo local'  => 'ubic-deposito-a',
                            'Deposito quincho'     => 'ubic-deposito-b',
                            'Deposito casa'        => 'ubic-deposito-c',
                            default                => 'ubic-sin',
                        };
                        $ubicIcono = match($ubic) {
                            'En el negocio'        => 'fas fa-store',
                            'Deposito nuevo local'  => 'fas fa-warehouse',
                            'Deposito quincho'     => 'fas fa-campground',
                            'Deposito casa'        => 'fas fa-home',
                            default                => 'fas fa-question-circle',
                        };
                    ?>
                    <tr>
                        <td>
                            <div class="inv-nombre"><?= esc($p['nombre']) ?></div>
                            <?php if (!empty($p['modelo'])): ?>
                                <div class="inv-modelo"><?= esc($p['modelo']) ?></div>
                            <?php endif; ?>
                        </td>
                        <td><span class="inv-categoria"><?= esc($p['categoria_nombre'] ?? '—') ?></span></td>
                        <td><span class="inv-marca"><?= esc($p['marca_nombre'] ?? '—') ?></span></td>
                        <td><span class="inv-precio"><?= esc($p['precio_texto'] ?? 'Consultar') ?></span></td>
                        <td>
                            <span class="badge-ubicacion <?= $ubicClase ?>">
                                <i class="<?= $ubicIcono ?>"></i>
                                <?= $ubic !== '' ? esc($ubic) : 'Sin asignar' ?>
                            </span>
                        </td>
                        <td>
                            <span class="estado-badge <?= $p['activo'] ? 'estado-activo' : 'estado-inactivo' ?>">
                                <i class="fas fa-circle" style="font-size:0.5rem;"></i>
                                <?= $p['activo'] ? 'Activo' : 'Inactivo' ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/productos/' . $p['id'] . '/editar') ?>"
                               class="btn-editar-prod">
                                <i class="fas fa-pen"></i> Editar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
