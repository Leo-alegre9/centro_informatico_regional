<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<style>
    .stock-search-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 1.75rem 2rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        margin-bottom: 1.5rem;
    }
    .stock-search-title {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.9px;
        color: #9CA3AF;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #f3f4f6;
    }
    .search-bar-wrap {
        display: flex;
        gap: 0.6rem;
    }
    .search-bar-wrap .form-control {
        border: 1.5px solid #e5e7eb;
        border-radius: 9px;
        padding: 0.6rem 0.95rem;
        font-size: 0.92rem;
        color: #111827;
        transition: border-color 0.2s, box-shadow 0.2s;
        flex: 1;
    }
    .search-bar-wrap .form-control:focus {
        border-color: #FF0033;
        box-shadow: 0 0 0 3px rgba(255,0,51,0.1);
        outline: none;
    }
    .btn-buscar {
        background: #FF0033;
        color: #fff;
        border: none;
        padding: 0.6rem 1.4rem;
        border-radius: 9px;
        font-size: 0.92rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        cursor: pointer;
        transition: background 0.2s;
        white-space: nowrap;
    }
    .btn-buscar:hover { background: #cc0028; }

    /* ── Tabla de resultados ── */
    .stock-table-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .stock-table-card table {
        margin: 0;
        width: 100%;
        border-collapse: collapse;
    }
    .stock-table-card thead th {
        background: #f9fafb;
        color: #6B7280;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        padding: 0.75rem 1.1rem;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }
    .stock-table-card tbody tr {
        border-bottom: 1px solid #f3f4f6;
        transition: background 0.12s;
    }
    .stock-table-card tbody tr:last-child { border-bottom: none; }
    .stock-table-card tbody tr:hover { background: #fafafa; }
    .stock-table-card tbody td {
        padding: 0.85rem 1.1rem;
        font-size: 0.88rem;
        color: #374151;
        vertical-align: middle;
    }

    .prod-name { font-weight: 600; color: #111827; }
    .prod-modelo { font-size: 0.78rem; color: #9CA3AF; margin-top: 1px; }
    .prod-cat { font-size: 0.78rem; color: #6B7280; }

    /* ── Badge de stock ── */
    .stock-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.25rem 0.7rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 700;
        white-space: nowrap;
    }
    .stock-badge.sin-stock  { background: #fef2f2; color: #DC2626; border: 1px solid #fecaca; }
    .stock-badge.stock-bajo { background: #fffbeb; color: #D97706; border: 1px solid #fde68a; }
    .stock-badge.stock-ok   { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }

    /* ── Formulario inline de actualización ── */
    .stock-update-form {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .stock-input {
        width: 80px;
        border: 1.5px solid #e5e7eb;
        border-radius: 7px;
        padding: 0.35rem 0.55rem;
        font-size: 0.88rem;
        font-weight: 600;
        color: #111827;
        text-align: center;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .stock-input:focus {
        border-color: #FF0033;
        box-shadow: 0 0 0 3px rgba(255,0,51,0.1);
        outline: none;
    }
    .btn-stock-save {
        background: none;
        border: 1.5px solid #e5e7eb;
        border-radius: 7px;
        padding: 0.35rem 0.7rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: #374151;
        cursor: pointer;
        transition: border-color 0.2s, color 0.2s, background 0.2s;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .btn-stock-save:hover {
        border-color: #16a34a;
        color: #16a34a;
        background: #f0fdf4;
    }

    /* ── Estado vacío / sin búsqueda ── */
    .stock-empty {
        text-align: center;
        padding: 3rem 1rem;
        color: #9CA3AF;
    }
    .stock-empty i { font-size: 2.5rem; display: block; margin-bottom: 0.75rem; color: #d1d5db; }
    .stock-empty p { font-size: 0.9rem; margin: 0; }

    /* ── Flash messages ── */
    .flash-success {
        background: rgba(16,185,129,0.07);
        border: 1px solid rgba(16,185,129,0.25);
        border-radius: 10px;
        padding: 0.85rem 1.25rem;
        color: #065f46;
        font-size: 0.88rem;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .flash-error {
        background: rgba(255,0,51,0.05);
        border: 1px solid rgba(255,0,51,0.2);
        border-radius: 10px;
        padding: 0.85rem 1.25rem;
        color: #DC2626;
        font-size: 0.88rem;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .results-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.9rem 1.1rem;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
    }
    .results-header span {
        font-size: 0.82rem;
        font-weight: 600;
        color: #6B7280;
    }
    .results-count {
        background: rgba(255,0,51,0.08);
        color: #FF0033;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 50px;
    }

    .estado-dot {
        display: inline-block;
        width: 7px; height: 7px;
        border-radius: 50%;
        margin-right: 5px;
        vertical-align: middle;
    }
    .dot-activo   { background: #16a34a; }
    .dot-inactivo { background: #9CA3AF; }
</style>

<!-- Header -->
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
    <h2 style="font-size:1.35rem;font-weight:700;color:#111827;margin:0;">
        <i class="fas fa-boxes me-2" style="color:#FF0033;font-size:1.05rem;"></i>
        Gestión de Stock
    </h2>
    <a href="<?= base_url('admin/productos') ?>" style="font-size:0.85rem;color:#6B7280;text-decoration:none;display:flex;align-items:center;gap:4px;">
        <i class="fas fa-box"></i> Ver todos los productos
    </a>
</div>

<?php if ($msg = session()->getFlashdata('success')): ?>
<div class="flash-success"><i class="fas fa-check-circle"></i> <?= esc($msg) ?></div>
<?php endif; ?>
<?php if ($msg = session()->getFlashdata('error')): ?>
<div class="flash-error"><i class="fas fa-exclamation-triangle"></i> <?= esc($msg) ?></div>
<?php endif; ?>

<!-- Buscador -->
<div class="stock-search-card">
    <div class="stock-search-title"><i class="fas fa-search me-1"></i>Buscar producto</div>
    <form method="GET" action="<?= base_url('admin/stock') ?>">
        <div class="search-bar-wrap">
            <input type="text"
                   name="q"
                   class="form-control"
                   placeholder="Nombre, modelo o marca del producto..."
                   value="<?= esc($q) ?>"
                   autofocus>
            <button type="submit" class="btn-buscar">
                <i class="fas fa-search"></i> Buscar
            </button>
            <?php if ($q !== ''): ?>
            <a href="<?= base_url('admin/stock') ?>"
               style="display:inline-flex;align-items:center;gap:5px;padding:0.6rem 1rem;border-radius:9px;border:1.5px solid #e5e7eb;color:#6B7280;text-decoration:none;font-size:0.88rem;font-weight:600;white-space:nowrap;transition:background .15s;"
               onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background=''">
                <i class="fas fa-times"></i> Limpiar
            </a>
            <?php endif; ?>
        </div>
        <div style="font-size:0.78rem;color:#9CA3AF;margin-top:0.5rem;">
            <i class="fas fa-info-circle me-1"></i>
            Podés buscar por nombre del producto, número de modelo o marca.
        </div>
    </form>
</div>

<!-- Resultados -->
<?php if ($q === ''): ?>
    <div class="stock-table-card">
        <div class="stock-empty">
            <i class="fas fa-search"></i>
            <p>Ingresá un término de búsqueda para consultar el stock de un producto.</p>
        </div>
    </div>

<?php elseif (empty($productos)): ?>
    <div class="stock-table-card">
        <div class="stock-empty">
            <i class="fas fa-box-open"></i>
            <p>No se encontraron productos para <strong style="color:#111827;">"<?= esc($q) ?>"</strong>.</p>
        </div>
    </div>

<?php else: ?>
    <div class="stock-table-card">
        <div class="results-header">
            <span>Resultados para <strong style="color:#111827;">"<?= esc($q) ?>"</strong></span>
            <span class="results-count"><?= count($productos) ?> producto<?= count($productos) !== 1 ? 's' : '' ?></span>
        </div>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Stock actual</th>
                        <th>Estado</th>
                        <th>Actualizar stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $i => $p): ?>
                    <?php
                        $stock = (int) $p['stock'];
                        if ($stock === 0) {
                            $stockClass = 'sin-stock';
                            $stockLabel = 'Sin stock';
                        } elseif ($stock <= 3) {
                            $stockClass = 'stock-bajo';
                            $stockLabel = $stock . ' unid.';
                        } else {
                            $stockClass = 'stock-ok';
                            $stockLabel = $stock . ' unid.';
                        }
                    ?>
                    <tr>
                        <td style="color:#9CA3AF;font-size:0.8rem;"><?= $i + 1 ?></td>
                        <td>
                            <div class="prod-name"><?= esc($p['nombre']) ?></div>
                            <?php if (!empty($p['modelo'])): ?>
                            <div class="prod-modelo"><?= esc($p['modelo']) ?></div>
                            <?php endif; ?>
                            <?php if (!empty($p['marca_nombre'])): ?>
                            <div class="prod-modelo" style="color:#6B7280;"><?= esc($p['marca_nombre']) ?></div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="prod-cat"><?= esc($p['categoria_nombre'] ?? '—') ?></span>
                        </td>
                        <td>
                            <span class="stock-badge <?= $stockClass ?>">
                                <i class="fas fa-<?= $stock === 0 ? 'times-circle' : ($stock <= 3 ? 'exclamation-triangle' : 'check-circle') ?>"></i>
                                <?= $stockLabel ?>
                            </span>
                        </td>
                        <td>
                            <span>
                                <span class="estado-dot <?= $p['activo'] ? 'dot-activo' : 'dot-inactivo' ?>"></span>
                                <?= $p['activo'] ? 'Activo' : 'Inactivo' ?>
                            </span>
                        </td>
                        <td>
                            <form method="POST"
                                  action="<?= base_url('admin/stock/' . $p['id'] . '/actualizar') ?>"
                                  class="stock-update-form">
                                <?= csrf_field() ?>
                                <input type="hidden" name="q" value="<?= esc($q) ?>">
                                <input type="number"
                                       name="stock"
                                       class="stock-input"
                                       value="<?= (int) $p['stock'] ?>"
                                       min="0"
                                       step="1"
                                       required>
                                <button type="submit" class="btn-stock-save">
                                    <i class="fas fa-save"></i> Guardar
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
