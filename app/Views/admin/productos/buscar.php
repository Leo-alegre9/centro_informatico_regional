<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<style>
    .page-header-row {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;
    }
    .page-header-row h2 { font-size: 1.4rem; font-weight: 700; color: #111827; margin: 0; }

    .search-card {
        background: #fff; border: 1px solid #e5e7eb; border-radius: 14px;
        padding: 1.5rem 1.5rem 1.25rem; margin-bottom: 1.5rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }
    .search-card .form-label { font-size: 0.85rem; font-weight: 600; color: #374151; margin-bottom: 0.3rem; }
    .search-input {
        border: 2px solid #e5e7eb; border-radius: 10px; padding: 0.65rem 1rem;
        font-size: 0.95rem; color: #111827; width: 100%;
        transition: border-color 0.2s, box-shadow 0.2s; background: #fff;
    }
    .search-input:focus { border-color: #FF0033; box-shadow: 0 0 0 3px rgba(255,0,51,0.1); outline: none; }

    .tipo-pills { display: flex; gap: 0.5rem; flex-wrap: wrap; margin-top: 0.85rem; }
    .tipo-pill {
        padding: 0.35rem 1rem; border-radius: 50px; font-size: 0.84rem; font-weight: 600;
        border: 1.5px solid #e5e7eb; background: #fff; color: #6B7280;
        cursor: pointer; transition: all 0.15s; user-select: none;
    }
    .tipo-pill:hover { border-color: #FF0033; color: #FF0033; }
    .tipo-pill.activo { background: #FF0033; border-color: #FF0033; color: #fff; }

    .btn-buscar {
        background: #FF0033; color: #fff; border: none;
        padding: 0.65rem 1.75rem; border-radius: 50px;
        font-size: 0.92rem; font-weight: 600; cursor: pointer;
        display: inline-flex; align-items: center; gap: 0.4rem;
        transition: background 0.2s; white-space: nowrap;
    }
    .btn-buscar:hover { background: #cc0028; }

    .results-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 0.85rem; flex-wrap: wrap; gap: 0.5rem;
    }
    .results-header h5 { font-size: 0.95rem; font-weight: 700; color: #374151; margin: 0; }
    .count-badge {
        background: rgba(255,0,51,0.08); color: #FF0033;
        padding: 0.2rem 0.75rem; border-radius: 50px; font-size: 0.82rem; font-weight: 600;
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
    .cat-path { background: #f3f4f6; color: #6B7280; padding: 0.15rem 0.55rem; border-radius: 50px; font-size: 0.75rem; font-weight: 600; }
    .codigo-badge {
        background: rgba(99,102,241,0.1); color: #4F46E5;
        padding: 0.15rem 0.55rem; border-radius: 50px;
        font-size: 0.78rem; font-weight: 700; font-family: monospace;
    }

    .empty-state { text-align: center; padding: 4rem 2rem; color: #9CA3AF; }
    .empty-state i { font-size: 3rem; margin-bottom: 1rem; display: block; color: #D1D5DB; }
    .empty-state h5 { color: #374151; font-weight: 600; margin-bottom: 0.5rem; }
    .empty-state p  { font-size: 0.9rem; }

    .highlight { background: rgba(255,0,51,0.12); border-radius: 3px; padding: 0 2px; }
</style>

<div class="page-header-row">
    <h2><i class="fas fa-search me-2" style="color:#FF0033;font-size:1.05rem;"></i>Buscar producto</h2>
    <a href="<?= base_url('admin/productos') ?>" style="color:#6B7280;text-decoration:none;font-size:0.88rem;font-weight:600;">
        <i class="fas fa-arrow-left me-1"></i> Ver todos los productos
    </a>
</div>

<!-- Formulario de búsqueda -->
<div class="search-card">
    <form method="GET" action="<?= base_url('admin/productos/buscar') ?>" id="formBuscar">
        <input type="hidden" name="tipo" id="tipoHidden" value="<?= esc($tipo) ?>">

        <label class="form-label" for="q">¿Qué estás buscando?</label>
        <div class="d-flex gap-2 align-items-start flex-wrap">
            <div style="flex:1;min-width:220px;">
                <input
                    type="text"
                    id="q"
                    name="q"
                    class="search-input"
                    value="<?= esc($q) ?>"
                    placeholder="Escribí el código, nombre o cualquier referencia..."
                    autocomplete="off"
                    autofocus>
            </div>
            <button type="submit" class="btn-buscar">
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>

        <div class="tipo-pills">
            <span class="tipo-pill <?= $tipo === 'todos'   ? 'activo' : '' ?>" onclick="setTipo('todos')">
                <i class="fas fa-th-list me-1"></i>Todo
            </span>
            <span class="tipo-pill <?= $tipo === 'codigo'  ? 'activo' : '' ?>" onclick="setTipo('codigo')">
                <i class="fas fa-barcode me-1"></i>Por código
            </span>
            <span class="tipo-pill <?= $tipo === 'nombre'  ? 'activo' : '' ?>" onclick="setTipo('nombre')">
                <i class="fas fa-font me-1"></i>Por nombre
            </span>
        </div>
        <div style="font-size:0.78rem;color:#9CA3AF;margin-top:0.6rem;">
            <i class="fas fa-info-circle me-1"></i>
            <strong>Todo</strong>: busca en código, nombre, modelo y marca.
            <strong>Por código</strong>: busca solo en el código interno del producto.
            <strong>Por nombre</strong>: busca solo en el nombre del producto.
        </div>
    </form>
</div>

<!-- Resultados -->
<?php if ($q !== ''): ?>
<div class="results-header">
    <h5>
        Resultados para
        <span style="color:#FF0033;">"<?= esc($q) ?>"</span>
        <?php if ($tipo !== 'todos'): ?>
            <span style="color:#9CA3AF;font-weight:400;font-size:0.85rem;">
                — buscando por <?= $tipo === 'codigo' ? 'código' : 'nombre' ?>
            </span>
        <?php endif; ?>
    </h5>
    <span class="count-badge"><?= count($resultados) ?> resultado<?= count($resultados) !== 1 ? 's' : '' ?></span>
</div>

<?php if (!empty($resultados)): ?>
<div class="tabla-card">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Categoría</th>
                    <th>Nombre del producto</th>
                    <th>Marca / Modelo</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Activo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $p): ?>
                <tr>
                    <td>
                        <?php if (!empty($p['codigo'])): ?>
                            <span class="codigo-badge"><?= esc($p['codigo']) ?></span>
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
                                <?= esc(mb_substr($p['descripcion_corta'], 0, 70)) ?>...
                            </div>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:0.85rem;">
                        <?php if (!empty($p['marca_nombre'])): ?>
                            <div style="font-weight:600;"><?= esc($p['marca_nombre']) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($p['modelo'])): ?>
                            <div style="color:#9CA3AF;font-size:0.78rem;"><?= esc($p['modelo']) ?></div>
                        <?php endif; ?>
                        <?php if (empty($p['marca_nombre']) && empty($p['modelo'])): ?>
                            <span style="color:#D1D5DB;">—</span>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:0.85rem;"><?= esc($p['precio_texto'] ?? '—') ?></td>
                    <td>
                        <span style="font-weight:700;color:<?= (int)($p['stock'] ?? 0) > 0 ? '#059669' : '#9CA3AF' ?>;">
                            <?= (int)($p['stock'] ?? 0) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($p['activo']): ?>
                            <span class="badge-activo"><i class="fas fa-check me-1"></i>Sí</span>
                        <?php else: ?>
                            <span class="badge-inactivo"><i class="fas fa-times me-1"></i>No</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url("admin/productos/{$p['id']}/editar") ?>"
                           class="btn btn-outline-primary btn-accion">
                            <i class="fas fa-pen me-1"></i>Editar
                        </a>
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
        <i class="fas fa-search"></i>
        <h5>Sin resultados</h5>
        <p>No se encontró ningún producto que coincida con "<?= esc($q) ?>". Probá con otro término.</p>
    </div>
</div>
<?php endif; ?>

<?php else: ?>
<div class="tabla-card">
    <div class="empty-state">
        <i class="fas fa-search" style="color:#D1D5DB;"></i>
        <h5>Ingresá un término para buscar</h5>
        <p>Podés buscar por código interno, nombre del producto, modelo o marca.</p>
    </div>
</div>
<?php endif; ?>

<script>
function setTipo(valor) {
    document.getElementById('tipoHidden').value = valor;
    document.querySelectorAll('.tipo-pill').forEach(function (el) {
        el.classList.remove('activo');
    });
    event.currentTarget.classList.add('activo');
}

/* Enviar con Enter en el input */
document.getElementById('q').addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('formBuscar').submit();
    }
});
</script>

<?= $this->endSection() ?>
