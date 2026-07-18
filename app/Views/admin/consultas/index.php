<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<!-- Stats -->
<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-4">
    <div class="bg-white border border-gray-200 rounded-[14px] px-6 py-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-lg flex-shrink-0 bg-blue-500/10 text-blue-500">
            <i class="fas fa-inbox"></i>
        </div>
        <div>
            <div class="text-[1.75rem] font-extrabold text-dark leading-none"><?= $stats['total'] ?></div>
            <div class="text-[0.78rem] text-gray-500 font-medium mt-0.5">Total consultas</div>
        </div>
    </div>
    <div class="bg-white border border-gray-200 rounded-[14px] px-6 py-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-lg flex-shrink-0 bg-orange-500/10 text-orange-500">
            <i class="fas fa-bell"></i>
        </div>
        <div>
            <div class="text-[1.75rem] font-extrabold text-dark leading-none"><?= $stats['sin_leer'] ?></div>
            <div class="text-[0.78rem] text-gray-500 font-medium mt-0.5">Sin leer</div>
        </div>
    </div>
    <div class="bg-white border border-gray-200 rounded-[14px] px-6 py-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-lg flex-shrink-0 bg-emerald-500/10 text-emerald-500">
            <i class="fas fa-calendar-day"></i>
        </div>
        <div>
            <div class="text-[1.75rem] font-extrabold text-dark leading-none"><?= $stats['hoy'] ?></div>
            <div class="text-[0.78rem] text-gray-500 font-medium mt-0.5">Hoy</div>
        </div>
    </div>
    <div class="bg-white border border-gray-200 rounded-[14px] px-6 py-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-lg flex-shrink-0 bg-rojo/10 text-rojo">
            <i class="fas fa-calendar-week"></i>
        </div>
        <div>
            <div class="text-[1.75rem] font-extrabold text-dark leading-none"><?= $stats['esta_semana'] ?></div>
            <div class="text-[0.78rem] text-gray-500 font-medium mt-0.5">Esta semana</div>
        </div>
    </div>
</div>

<!-- Filtros -->
<form class="bg-white border border-gray-200 rounded-xl p-4 flex flex-wrap gap-3 items-end mb-6" method="GET" action="<?= base_url('admin/consultas') ?>">
    <div class="flex flex-col gap-1 min-w-[160px]">
        <label class="text-[0.72rem] font-bold text-gray-500 uppercase tracking-wider">Técnico</label>
        <select name="tecnico" class="border-[1.5px] border-gray-200 rounded-lg px-3 py-2 text-sm text-dark bg-white transition-colors focus:border-rojo focus:outline-none focus:ring-[3px] focus:ring-rojo/10">
            <option value="">Todos</option>
            <option value="Hernán" <?= ($filtros['tecnico'] === 'Hernán') ? 'selected' : '' ?>>Hernán</option>
            <option value="Hugo"   <?= ($filtros['tecnico'] === 'Hugo')   ? 'selected' : '' ?>>Hugo</option>
        </select>
    </div>
    <div class="flex flex-col gap-1 min-w-[160px]">
        <label class="text-[0.72rem] font-bold text-gray-500 uppercase tracking-wider">Estado</label>
        <select name="estado" class="border-[1.5px] border-gray-200 rounded-lg px-3 py-2 text-sm text-dark bg-white transition-colors focus:border-rojo focus:outline-none focus:ring-[3px] focus:ring-rojo/10">
            <option value="">Todos</option>
            <option value="nueva"    <?= ($filtros['estado'] === 'nueva')    ? 'selected' : '' ?>>Nueva</option>
            <option value="vista"    <?= ($filtros['estado'] === 'vista')    ? 'selected' : '' ?>>Vista</option>
            <option value="resuelta" <?= ($filtros['estado'] === 'resuelta') ? 'selected' : '' ?>>Resuelta</option>
        </select>
    </div>
    <div class="flex flex-col gap-1 min-w-[160px]">
        <label class="text-[0.72rem] font-bold text-gray-500 uppercase tracking-wider">Urgencia</label>
        <select name="urgencia" class="border-[1.5px] border-gray-200 rounded-lg px-3 py-2 text-sm text-dark bg-white transition-colors focus:border-rojo focus:outline-none focus:ring-[3px] focus:ring-rojo/10">
            <option value="">Todas</option>
            <option value="Es urgente, lo necesito hoy"  <?= ($filtros['urgencia'] === 'Es urgente, lo necesito hoy')  ? 'selected' : '' ?>>Urgente hoy</option>
            <option value="Lo antes posible"              <?= ($filtros['urgencia'] === 'Lo antes posible')              ? 'selected' : '' ?>>Lo antes posible</option>
            <option value="Puede esperar unos días"       <?= ($filtros['urgencia'] === 'Puede esperar unos días')       ? 'selected' : '' ?>>Puede esperar</option>
            <option value="Sin urgencia particular"       <?= ($filtros['urgencia'] === 'Sin urgencia particular')       ? 'selected' : '' ?>>Sin urgencia</option>
        </select>
    </div>
    <button type="submit" class="bg-rojo hover:bg-rojo-dark text-white border-none px-5 py-2 rounded-lg text-sm font-semibold cursor-pointer transition-colors flex items-center gap-1.5 self-end">
        <i class="fas fa-filter"></i> Filtrar
    </button>
    <a href="<?= base_url('admin/consultas') ?>" class="bg-transparent border-[1.5px] border-gray-200 text-gray-500 px-4 py-2 rounded-lg text-sm cursor-pointer transition-colors self-end hover:border-gray-400 hover:text-gray-700">Limpiar</a>
</form>

<!-- Tabla -->
<div class="bg-white border border-gray-200 rounded-[14px] overflow-hidden">
    <?php if (empty($consultas)): ?>
    <div class="text-center py-14 px-4 text-gray-400">
        <i class="fas fa-inbox text-[2.8rem] mb-4 block text-gray-300"></i>
        <p class="text-[0.95rem] m-0">No hay consultas que coincidan con los filtros.</p>
    </div>
    <?php else: ?>
    <div class="overflow-x-auto">
    <table class="w-full border-collapse text-sm">
        <thead>
            <tr>
                <th class="bg-gray-50 px-4 py-3.5 font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-gray-200 whitespace-nowrap">#</th>
                <th class="bg-gray-50 px-4 py-3.5 font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-gray-200 whitespace-nowrap">Fecha</th>
                <th class="bg-gray-50 px-4 py-3.5 font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-gray-200 whitespace-nowrap">Cliente</th>
                <th class="bg-gray-50 px-4 py-3.5 font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-gray-200 whitespace-nowrap">Equipo</th>
                <th class="bg-gray-50 px-4 py-3.5 font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-gray-200 whitespace-nowrap">Descripción</th>
                <th class="bg-gray-50 px-4 py-3.5 font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-gray-200 whitespace-nowrap">Urgencia</th>
                <th class="bg-gray-50 px-4 py-3.5 font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-gray-200 whitespace-nowrap">Técnico</th>
                <th class="bg-gray-50 px-4 py-3.5 font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-gray-200 whitespace-nowrap">Estado</th>
                <th class="bg-gray-50 px-4 py-3.5 font-bold text-xs uppercase tracking-wide text-gray-500 border-b border-gray-200 whitespace-nowrap">Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($consultas as $c): ?>
        <?php
            $urgClass = 'bg-gray-100 text-gray-500';
            if ($c['urgencia'] === 'Es urgente, lo necesito hoy') $urgClass = 'bg-red-500/10 text-red-600';
            elseif ($c['urgencia'] === 'Lo antes posible')        $urgClass = 'bg-orange-500/10 text-orange-700';
            elseif ($c['urgencia'] === 'Puede esperar unos días') $urgClass = 'bg-emerald-500/10 text-emerald-700';
        ?>
        <tr class="border-b border-gray-100 transition-colors hover:bg-gray-50/70 <?= $c['estado'] === 'nueva' ? 'border-l-[3px] border-l-orange-500' : '' ?>"
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
            <td class="px-4 py-3.5 align-middle text-gray-400 text-[0.8rem]">#<?= $c['id'] ?></td>
            <td class="px-4 py-3.5 align-middle whitespace-nowrap text-[0.82rem] text-gray-500">
                <?= date('d/m/Y', strtotime($c['created_at'])) ?><br>
                <span class="text-[0.76rem]"><?= date('H:i', strtotime($c['created_at'])) ?></span>
            </td>
            <td class="px-4 py-3.5 align-middle text-gray-700 font-semibold"><?= esc($c['nombre_cliente']) ?></td>
            <td class="px-4 py-3.5 align-middle text-gray-700">
                <?= esc($c['tipo_equipo']) ?>
                <?php if ($c['marca_modelo']): ?>
                <br><span class="text-[0.76rem] text-gray-400"><?= esc($c['marca_modelo']) ?></span>
                <?php endif; ?>
            </td>
            <td class="px-4 py-3.5 align-middle max-w-[260px] overflow-hidden text-ellipsis whitespace-nowrap text-gray-500" title="<?= esc($c['descripcion_problema']) ?>">
                <?= esc(mb_strimwidth($c['descripcion_problema'], 0, 70, '…')) ?>
            </td>
            <td class="px-4 py-3.5 align-middle"><span class="inline-block px-2 py-0.5 rounded-full text-[0.7rem] font-bold <?= $urgClass ?>"><?= esc($c['urgencia']) ?></span></td>
            <td class="px-4 py-3.5 align-middle text-gray-700 font-semibold"><?= esc($c['tecnico_contactado']) ?></td>
            <td class="px-4 py-3.5 align-middle">
                <?php
                    $estadoClasses = 'bg-gray-500/10 text-gris';
                    if ($c['estado'] === 'nueva')    $estadoClasses = 'bg-orange-500/10 text-orange-700';
                    elseif ($c['estado'] === 'resuelta') $estadoClasses = 'bg-emerald-500/10 text-emerald-700';
                ?>
                <span class="badge-estado inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[0.73rem] font-bold whitespace-nowrap <?= $estadoClasses ?>">
                    <?php if ($c['estado'] === 'nueva'): ?>
                    <i class="fas fa-circle text-[0.55rem]"></i> Nueva
                    <?php elseif ($c['estado'] === 'vista'): ?>
                    <i class="fas fa-eye"></i> Vista
                    <?php else: ?>
                    <i class="fas fa-check-circle"></i> Resuelta
                    <?php endif; ?>
                </span>
            </td>
            <td class="px-4 py-3.5 align-middle">
                <div class="flex gap-1 flex-wrap">
                    <button class="btn-ver-detalle bg-transparent border border-gray-200 rounded-[7px] px-2.5 py-1 text-xs cursor-pointer text-gray-700 transition-colors inline-flex items-center gap-1.5 hover:bg-gray-100 hover:border-gray-300" title="Ver detalle">
                        <i class="fas fa-eye"></i> Ver
                    </button>
                    <?php if ($c['estado'] !== 'resuelta'): ?>
                    <button class="btn-resolver bg-transparent border border-gray-200 rounded-[7px] px-2.5 py-1 text-xs cursor-pointer text-gray-700 transition-colors inline-flex items-center gap-1.5 hover:bg-emerald-500/10 hover:border-emerald-500 hover:text-emerald-700" data-id="<?= $c['id'] ?>" title="Marcar como resuelta">
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
<div id="modalDetalleOverlay" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div id="modalDetalleBox" class="w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-xl">
        <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
            <h5 class="flex items-center text-base font-bold text-dark m-0">
                <i class="fas fa-clipboard-list mr-2 text-rojo"></i>
                Detalle de consulta
            </h5>
            <button type="button" class="btn-cerrar-modal-detalle text-2xl leading-none text-gray-400 hover:text-gray-600 bg-transparent border-none cursor-pointer" aria-label="Cerrar">&times;</button>
        </div>
        <div class="px-5 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div class="mb-4">
                        <div class="text-[0.72rem] font-bold uppercase tracking-wider text-gray-400 mb-1">Cliente</div>
                        <div class="text-[0.92rem] text-dark font-medium" id="det-nombre"></div>
                    </div>
                    <div class="mb-4">
                        <div class="text-[0.72rem] font-bold uppercase tracking-wider text-gray-400 mb-1">Equipo</div>
                        <div class="text-[0.92rem] text-dark font-medium" id="det-equipo"></div>
                    </div>
                    <div class="mb-4">
                        <div class="text-[0.72rem] font-bold uppercase tracking-wider text-gray-400 mb-1">Marca / Modelo</div>
                        <div class="text-[0.92rem] text-dark font-medium" id="det-marca"></div>
                    </div>
                </div>
                <div>
                    <div class="mb-4">
                        <div class="text-[0.72rem] font-bold uppercase tracking-wider text-gray-400 mb-1">Técnico contactado</div>
                        <div class="text-[0.92rem] text-dark font-medium" id="det-tecnico"></div>
                    </div>
                    <div class="mb-4">
                        <div class="text-[0.72rem] font-bold uppercase tracking-wider text-gray-400 mb-1">Urgencia</div>
                        <div class="text-[0.92rem] text-dark font-medium" id="det-urgencia"></div>
                    </div>
                    <div class="mb-4">
                        <div class="text-[0.72rem] font-bold uppercase tracking-wider text-gray-400 mb-1">Fecha y hora</div>
                        <div class="text-[0.92rem] text-dark font-medium" id="det-fecha"></div>
                    </div>
                </div>
                <div class="md:col-span-2">
                    <div class="text-[0.72rem] font-bold uppercase tracking-wider text-gray-400 mb-1">Descripción del problema</div>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm text-gray-700 leading-relaxed" id="det-problema"></div>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap items-center justify-between gap-2 border-t border-gray-200 px-5 py-4">
            <div class="flex gap-2">
                <a id="det-wsp-link" href="#" target="_blank" rel="noopener"
                   class="inline-flex items-center px-3 py-1.5 text-sm rounded-md bg-[#25D366] text-white font-semibold">
                    <i class="fab fa-whatsapp mr-1"></i> Abrir en WhatsApp
                </a>
            </div>
            <div class="flex gap-2">
                <button class="btn-cerrar-modal-detalle px-3 py-1.5 text-sm rounded-md border border-gray-300 text-gray-600 bg-white hover:bg-gray-100">Cerrar</button>
                <button class="px-3 py-1.5 text-sm rounded-md bg-emerald-500 text-white font-semibold" id="det-btn-resolver">
                    <i class="fas fa-check mr-1"></i> Marcar resuelta
                </button>
            </div>
        </div>
    </div>
</div>

<script>
var BASE = '<?= base_url() ?>';
var consultaActualId = null;

var modalDetalleOverlay = document.getElementById('modalDetalleOverlay');

function abrirModalDetalle() {
    modalDetalleOverlay.classList.remove('hidden');
    modalDetalleOverlay.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function cerrarModalDetalle() {
    modalDetalleOverlay.classList.add('hidden');
    modalDetalleOverlay.classList.remove('flex');
    document.body.style.overflow = '';
}

document.querySelectorAll('.btn-cerrar-modal-detalle').forEach(function (btn) {
    btn.addEventListener('click', cerrarModalDetalle);
});
modalDetalleOverlay.addEventListener('click', function (e) {
    if (e.target === modalDetalleOverlay) cerrarModalDetalle();
});
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && !modalDetalleOverlay.classList.contains('hidden')) cerrarModalDetalle();
});

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

    abrirModalDetalle();

    // Mark as read if new
    if (tr.dataset.estado === 'nueva') {
        fetch(BASE + 'admin/consultas/' + consultaActualId + '/vista', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: new URLSearchParams({ '<?= csrf_token() ?>': '<?= csrf_hash() ?>' })
        }).then(function () {
            tr.classList.remove('border-l-[3px]', 'border-l-orange-500');
            tr.dataset.estado = 'vista';
            var badge = tr.querySelector('.badge-estado');
            if (badge) {
                badge.className = 'badge-estado inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[0.73rem] font-bold whitespace-nowrap bg-gray-500/10 text-gris';
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
                badge.className = 'badge-estado inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[0.73rem] font-bold whitespace-nowrap bg-emerald-500/10 text-emerald-700';
                badge.innerHTML = '<i class="fas fa-check-circle"></i> Resuelta';
            }
            var btnRes = tr.querySelector('.btn-resolver');
            if (btnRes) btnRes.remove();
        }
        cerrarModalDetalle();
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
                badge.className = 'badge-estado inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[0.73rem] font-bold whitespace-nowrap bg-emerald-500/10 text-emerald-700';
                badge.innerHTML = '<i class="fas fa-check-circle"></i> Resuelta';
            }
            btn.remove();
        });
    });
});
</script>

<?= $this->endSection() ?>
