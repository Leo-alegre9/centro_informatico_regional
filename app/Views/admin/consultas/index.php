<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<style>
    .stat-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .stat-icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; flex-shrink: 0;
    }
    .stat-icon.rojo    { background: rgba(255,0,51,.1);    color: #FF0033; }
    .stat-icon.naranja { background: rgba(251,146,60,.12); color: #f97316; }
    .stat-icon.verde   { background: rgba(16,185,129,.1);  color: #10b981; }
    .stat-icon.azul    { background: rgba(59,130,246,.1);  color: #3b82f6; }
    .stat-value { font-size: 1.75rem; font-weight: 800; color: #111827; line-height: 1; }
    .stat-label { font-size: 0.78rem; color: #6B7280; font-weight: 500; margin-top: 2px; }

    .filter-bar {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        align-items: flex-end;
        margin-bottom: 1.5rem;
    }
    .filter-group { display: flex; flex-direction: column; gap: 4px; min-width: 160px; }
    .filter-group label { font-size: 0.72rem; font-weight: 700; color: #6B7280; text-transform: uppercase; letter-spacing: 0.7px; }
    .filter-select {
        border: 1.5px solid #e5e7eb; border-radius: 8px;
        padding: 0.48rem 0.8rem; font-size: 0.88rem; color: #111827;
        background: #fff; transition: border-color 0.2s;
    }
    .filter-select:focus { border-color: #FF0033; outline: none; box-shadow: 0 0 0 3px rgba(255,0,51,.08); }
    .btn-filtrar {
        background: #FF0033; color: #fff; border: none;
        padding: 0.52rem 1.3rem; border-radius: 8px;
        font-size: 0.88rem; font-weight: 600; cursor: pointer; transition: background .2s;
        display: flex; align-items: center; gap: 6px; align-self: flex-end;
    }
    .btn-filtrar:hover { background: #cc0028; }
    .btn-limpiar {
        background: none; border: 1.5px solid #e5e7eb; color: #6B7280;
        padding: 0.52rem 1rem; border-radius: 8px; font-size: 0.88rem;
        cursor: pointer; transition: border-color .2s; align-self: flex-end;
    }
    .btn-limpiar:hover { border-color: #9ca3af; color: #374151; }

    .consultas-table-wrap {
        background: #fff; border: 1px solid #e5e7eb;
        border-radius: 14px; overflow: hidden;
    }
    .consultas-table {
        width: 100%; border-collapse: collapse; font-size: 0.88rem;
    }
    .consultas-table thead th {
        background: #f9fafb; padding: 0.85rem 1rem;
        font-weight: 700; font-size: 0.75rem; text-transform: uppercase;
        letter-spacing: 0.6px; color: #6B7280; border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }
    .consultas-table tbody tr {
        border-bottom: 1px solid #f3f4f6;
        transition: background 0.15s;
    }
    .consultas-table tbody tr:hover { background: #fafafa; }
    .consultas-table tbody tr.nueva { border-left: 3px solid #f97316; }
    .consultas-table td {
        padding: 0.9rem 1rem; vertical-align: middle; color: #374151;
    }
    .consultas-table td.problema-cell {
        max-width: 260px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        color: #6B7280;
    }
    .badge-estado {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 50px; font-size: 0.73rem; font-weight: 700;
        white-space: nowrap;
    }
    .badge-nueva    { background: rgba(249,115,22,.12); color: #c2410c; }
    .badge-vista    { background: rgba(107,114,128,.1); color: #4B5563; }
    .badge-resuelta { background: rgba(16,185,129,.1);  color: #047857; }

    .badge-urgencia {
        display: inline-block; padding: 2px 8px; border-radius: 50px;
        font-size: 0.7rem; font-weight: 700;
    }
    .urg-alta  { background: rgba(239,68,68,.1);  color: #dc2626; }
    .urg-media { background: rgba(249,115,22,.1); color: #c2410c; }
    .urg-baja  { background: rgba(16,185,129,.1); color: #047857; }
    .urg-none  { background: #f3f4f6; color: #6B7280; }

    .btn-action {
        background: none; border: 1px solid #e5e7eb; border-radius: 7px;
        padding: 5px 10px; font-size: 0.78rem; cursor: pointer;
        color: #374151; transition: background .15s, border-color .15s;
        display: inline-flex; align-items: center; gap: 5px;
    }
    .btn-action:hover { background: #f3f4f6; border-color: #d1d5db; }
    .btn-action.verde:hover  { background: rgba(16,185,129,.1); border-color: #10b981; color: #047857; }

    .empty-state {
        text-align: center; padding: 3.5rem 1rem; color: #9CA3AF;
    }
    .empty-state i { font-size: 2.8rem; margin-bottom: 1rem; display: block; color: #d1d5db; }
    .empty-state p { font-size: 0.95rem; margin: 0; }

    /* Modal */
    .modal-detalle .modal-header { border-bottom: 1px solid #e5e7eb; }
    .modal-detalle .modal-title  { font-size: 1rem; font-weight: 700; }
    .detalle-row { margin-bottom: 1rem; }
    .detalle-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
                     letter-spacing: 0.7px; color: #9CA3AF; margin-bottom: 3px; }
    .detalle-valor { font-size: 0.92rem; color: #111827; font-weight: 500; }
    .detalle-problema {
        background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px;
        padding: 0.75rem 1rem; font-size: 0.9rem; color: #374151; line-height: 1.6;
    }
</style>

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon azul"><i class="fas fa-inbox"></i></div>
            <div>
                <div class="stat-value"><?= $stats['total'] ?></div>
                <div class="stat-label">Total consultas</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon naranja"><i class="fas fa-bell"></i></div>
            <div>
                <div class="stat-value"><?= $stats['sin_leer'] ?></div>
                <div class="stat-label">Sin leer</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon verde"><i class="fas fa-calendar-day"></i></div>
            <div>
                <div class="stat-value"><?= $stats['hoy'] ?></div>
                <div class="stat-label">Hoy</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon rojo"><i class="fas fa-calendar-week"></i></div>
            <div>
                <div class="stat-value"><?= $stats['esta_semana'] ?></div>
                <div class="stat-label">Esta semana</div>
            </div>
        </div>
    </div>
</div>

<!-- Filtros -->
<form class="filter-bar" method="GET" action="<?= base_url('admin/consultas') ?>">
    <div class="filter-group">
        <label>Técnico</label>
        <select name="tecnico" class="filter-select">
            <option value="">Todos</option>
            <option value="Hernán" <?= ($filtros['tecnico'] === 'Hernán') ? 'selected' : '' ?>>Hernán</option>
            <option value="Hugo"   <?= ($filtros['tecnico'] === 'Hugo')   ? 'selected' : '' ?>>Hugo</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Estado</label>
        <select name="estado" class="filter-select">
            <option value="">Todos</option>
            <option value="nueva"    <?= ($filtros['estado'] === 'nueva')    ? 'selected' : '' ?>>Nueva</option>
            <option value="vista"    <?= ($filtros['estado'] === 'vista')    ? 'selected' : '' ?>>Vista</option>
            <option value="resuelta" <?= ($filtros['estado'] === 'resuelta') ? 'selected' : '' ?>>Resuelta</option>
        </select>
    </div>
    <div class="filter-group">
        <label>Urgencia</label>
        <select name="urgencia" class="filter-select">
            <option value="">Todas</option>
            <option value="Es urgente, lo necesito hoy"  <?= ($filtros['urgencia'] === 'Es urgente, lo necesito hoy')  ? 'selected' : '' ?>>Urgente hoy</option>
            <option value="Lo antes posible"              <?= ($filtros['urgencia'] === 'Lo antes posible')              ? 'selected' : '' ?>>Lo antes posible</option>
            <option value="Puede esperar unos días"       <?= ($filtros['urgencia'] === 'Puede esperar unos días')       ? 'selected' : '' ?>>Puede esperar</option>
            <option value="Sin urgencia particular"       <?= ($filtros['urgencia'] === 'Sin urgencia particular')       ? 'selected' : '' ?>>Sin urgencia</option>
        </select>
    </div>
    <button type="submit" class="btn-filtrar"><i class="fas fa-filter"></i> Filtrar</button>
    <a href="<?= base_url('admin/consultas') ?>" class="btn-limpiar">Limpiar</a>
</form>

<!-- Tabla -->
<div class="consultas-table-wrap">
    <?php if (empty($consultas)): ?>
    <div class="empty-state">
        <i class="fas fa-inbox"></i>
        <p>No hay consultas que coincidan con los filtros.</p>
    </div>
    <?php else: ?>
    <div style="overflow-x:auto;">
    <table class="consultas-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Equipo</th>
                <th>Descripción</th>
                <th>Urgencia</th>
                <th>Técnico</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($consultas as $c): ?>
        <?php
            $urgClass = 'urg-none';
            if ($c['urgencia'] === 'Es urgente, lo necesito hoy') $urgClass = 'urg-alta';
            elseif ($c['urgencia'] === 'Lo antes posible')        $urgClass = 'urg-media';
            elseif ($c['urgencia'] === 'Puede esperar unos días') $urgClass = 'urg-baja';
        ?>
        <tr class="<?= $c['estado'] === 'nueva' ? 'nueva' : '' ?>"
            data-id="<?= $c['id'] ?>"
            data-nombre="<?= esc($c['nombre_cliente']) ?>"
            data-equipo="<?= esc($c['tipo_equipo']) ?>"
            data-marca="<?= esc($c['marca_modelo'] ?? '—') ?>"
            data-problema="<?= esc($c['descripcion_problema']) ?>"
            data-urgencia="<?= esc($c['urgencia']) ?>"
            data-tecnico="<?= esc($c['tecnico_contactado']) ?>"
            data-numero="<?= esc($c['numero_tecnico']) ?>"
            data-estado="<?= esc($c['estado']) ?>"
            data-fecha="<?= esc(date('d/m/Y H:i', strtotime($c['created_at']))) ?>">
            <td style="color:#9CA3AF;font-size:0.8rem;">#<?= $c['id'] ?></td>
            <td style="white-space:nowrap; font-size:0.82rem; color:#6B7280;">
                <?= date('d/m/Y', strtotime($c['created_at'])) ?><br>
                <span style="font-size:0.76rem;"><?= date('H:i', strtotime($c['created_at'])) ?></span>
            </td>
            <td style="font-weight:600;"><?= esc($c['nombre_cliente']) ?></td>
            <td>
                <?= esc($c['tipo_equipo']) ?>
                <?php if ($c['marca_modelo']): ?>
                <br><span style="font-size:0.76rem;color:#9CA3AF;"><?= esc($c['marca_modelo']) ?></span>
                <?php endif; ?>
            </td>
            <td class="problema-cell" title="<?= esc($c['descripcion_problema']) ?>">
                <?= esc(mb_strimwidth($c['descripcion_problema'], 0, 70, '…')) ?>
            </td>
            <td><span class="badge-urgencia <?= $urgClass ?>"><?= esc($c['urgencia']) ?></span></td>
            <td style="font-weight:600;"><?= esc($c['tecnico_contactado']) ?></td>
            <td>
                <span class="badge-estado badge-<?= $c['estado'] ?>">
                    <?php if ($c['estado'] === 'nueva'): ?>
                    <i class="fas fa-circle" style="font-size:0.55rem;"></i> Nueva
                    <?php elseif ($c['estado'] === 'vista'): ?>
                    <i class="fas fa-eye"></i> Vista
                    <?php else: ?>
                    <i class="fas fa-check-circle"></i> Resuelta
                    <?php endif; ?>
                </span>
            </td>
            <td>
                <div class="d-flex gap-1 flex-wrap">
                    <button class="btn-action btn-ver-detalle" title="Ver detalle">
                        <i class="fas fa-eye"></i> Ver
                    </button>
                    <?php if ($c['estado'] !== 'resuelta'): ?>
                    <button class="btn-action verde btn-resolver" data-id="<?= $c['id'] ?>" title="Marcar como resuelta">
                        <i class="fas fa-check"></i>
                    </button>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <?php endif; ?>
</div>

<!-- Modal detalle -->
<div class="modal fade modal-detalle" id="modalDetalle" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-clipboard-list me-2" style="color:#FF0033;"></i>
                    Detalle de consulta
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="detalle-row">
                            <div class="detalle-label">Cliente</div>
                            <div class="detalle-valor" id="det-nombre"></div>
                        </div>
                        <div class="detalle-row">
                            <div class="detalle-label">Equipo</div>
                            <div class="detalle-valor" id="det-equipo"></div>
                        </div>
                        <div class="detalle-row">
                            <div class="detalle-label">Marca / Modelo</div>
                            <div class="detalle-valor" id="det-marca"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detalle-row">
                            <div class="detalle-label">Técnico contactado</div>
                            <div class="detalle-valor" id="det-tecnico"></div>
                        </div>
                        <div class="detalle-row">
                            <div class="detalle-label">Urgencia</div>
                            <div class="detalle-valor" id="det-urgencia"></div>
                        </div>
                        <div class="detalle-row">
                            <div class="detalle-label">Fecha y hora</div>
                            <div class="detalle-valor" id="det-fecha"></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="detalle-label">Descripción del problema</div>
                        <div class="detalle-problema" id="det-problema"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <div class="d-flex gap-2">
                    <a id="det-wsp-link" href="#" target="_blank" rel="noopener"
                       class="btn btn-sm"
                       style="background:#25D366;color:#fff;font-weight:600;border-radius:6px;">
                        <i class="fab fa-whatsapp me-1"></i> Abrir en WhatsApp
                    </a>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button class="btn btn-sm" id="det-btn-resolver"
                            style="background:#10b981;color:#fff;font-weight:600;border-radius:6px;">
                        <i class="fas fa-check me-1"></i> Marcar resuelta
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var BASE = '<?= base_url() ?>';
var consultaActualId = null;

document.querySelectorAll('.btn-ver-detalle').forEach(function (btn) {
    btn.addEventListener('click', function () {
        var tr = this.closest('tr');
        abrirDetalle(tr);
    });
});

function abrirDetalle(tr) {
    consultaActualId = tr.dataset.id;

    document.getElementById('det-nombre').textContent   = tr.dataset.nombre;
    document.getElementById('det-equipo').textContent   = tr.dataset.equipo + (tr.dataset.marca !== '—' ? ' — ' + tr.dataset.marca : '');
    document.getElementById('det-marca').textContent    = tr.dataset.marca;
    document.getElementById('det-tecnico').textContent  = tr.dataset.tecnico;
    document.getElementById('det-urgencia').textContent = tr.dataset.urgencia;
    document.getElementById('det-fecha').textContent    = tr.dataset.fecha;
    document.getElementById('det-problema').textContent = tr.dataset.problema;

    var msg = 'Hola ' + tr.dataset.tecnico + ', te reenvío una consulta:\n\n';
    msg += '👤 Cliente: ' + tr.dataset.nombre + '\n';
    msg += '💻 Equipo: ' + tr.dataset.equipo;
    if (tr.dataset.marca && tr.dataset.marca !== '—') msg += ' (' + tr.dataset.marca + ')';
    msg += '\n🔧 Problema: ' + tr.dataset.problema;
    document.getElementById('det-wsp-link').href = 'https://wa.me/' + tr.dataset.numero + '?text=' + encodeURIComponent(msg);

    var modal = new bootstrap.Modal(document.getElementById('modalDetalle'));
    modal.show();

    // Mark as read if new
    if (tr.dataset.estado === 'nueva') {
        fetch(BASE + 'admin/consultas/' + consultaActualId + '/vista', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: new URLSearchParams({ '<?= csrf_token() ?>': '<?= csrf_hash() ?>' })
        }).then(function () {
            tr.classList.remove('nueva');
            tr.dataset.estado = 'vista';
            var badge = tr.querySelector('.badge-estado');
            if (badge) {
                badge.className = 'badge-estado badge-vista';
                badge.innerHTML = '<i class="fas fa-eye"></i> Vista';
            }
        });
    }
}

// Resolver desde modal
document.getElementById('det-btn-resolver').addEventListener('click', function () {
    if (!consultaActualId) return;
    fetch(BASE + 'admin/consultas/' + consultaActualId + '/resuelta', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: new URLSearchParams({ '<?= csrf_token() ?>': '<?= csrf_hash() ?>' })
    }).then(function () {
        var tr = document.querySelector('tr[data-id="' + consultaActualId + '"]');
        if (tr) {
            tr.dataset.estado = 'resuelta';
            var badge = tr.querySelector('.badge-estado');
            if (badge) {
                badge.className = 'badge-estado badge-resuelta';
                badge.innerHTML = '<i class="fas fa-check-circle"></i> Resuelta';
            }
            var btnRes = tr.querySelector('.btn-resolver');
            if (btnRes) btnRes.remove();
        }
        bootstrap.Modal.getInstance(document.getElementById('modalDetalle')).hide();
    });
});

// Resolver desde tabla
document.querySelectorAll('.btn-resolver').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        var id = this.dataset.id;
        var tr = this.closest('tr');
        fetch(BASE + 'admin/consultas/' + id + '/resuelta', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: new URLSearchParams({ '<?= csrf_token() ?>': '<?= csrf_hash() ?>' })
        }).then(function () {
            tr.dataset.estado = 'resuelta';
            var badge = tr.querySelector('.badge-estado');
            if (badge) {
                badge.className = 'badge-estado badge-resuelta';
                badge.innerHTML = '<i class="fas fa-check-circle"></i> Resuelta';
            }
            btn.remove();
        });
    });
});
</script>

<?= $this->endSection() ?>
