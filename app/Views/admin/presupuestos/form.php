<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<?php
$esEdicion   = $presupuesto !== null;
$tipoInicial = $tipoInicial ?? 'presupuesto';
$inputCls    = 'w-full border-[1.5px] border-gray-200 rounded-lg px-4 py-2.5 text-[0.9rem] text-dark transition-colors outline-none focus:border-rojo focus:ring-[3px] focus:ring-rojo/10';
$labelCls    = 'block text-[0.82rem] font-semibold text-gray-700 mb-1.5';
$cardCls     = 'bg-white border border-gray-100 rounded-2xl p-7 shadow-[0_1px_3px_rgba(0,0,0,0.04)]';
$btnRojo     = 'bg-rojo hover:bg-rojo-dark text-white px-5 py-2.5 rounded-full text-sm font-semibold no-underline inline-flex items-center gap-2 transition-colors whitespace-nowrap justify-center';

$detallesIniciales = [];
foreach ($presupuesto['detalles'] ?? [] as $d) {
    $detallesIniciales[] = [
        'producto_id'     => $d['producto_id'],
        'producto_nombre' => $d['producto_nombre'],
        'producto_codigo' => $d['producto_codigo'],
        'precio_unitario' => (float) $d['precio_unitario'],
        'cantidad'        => (int) $d['cantidad'],
        'imagen'          => !empty($d['imagen_ruta']) ? base_url($d['imagen_ruta']) : null,
    ];
}
?>

<div class="flex items-center gap-3 mb-1">
    <a href="<?= base_url('admin/presupuestos') ?>" class="text-gray-500 hover:text-rojo no-underline transition-colors">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h2 class="text-[1.4rem] font-bold text-dark m-0">
        <i class="fas fa-file-invoice-dollar mr-2 text-rojo text-[1.1rem]"></i>
        <?= $esEdicion ? 'Editar presupuesto ' . esc($presupuesto['numero']) : 'Nuevo presupuesto' ?>
    </h2>
</div>
<p class="text-gray-400 text-[0.85rem] mb-6 ml-[1.9rem]">Cargá los datos del cliente y agregá productos del catálogo.</p>

<?php $errors = session()->getFlashdata('errors'); ?>
<?php if ($errors): ?>
<div class="bg-rojo/5 border border-rojo/20 rounded-xl px-5 py-4 mb-5 text-[0.88rem] text-red-600">
    <strong><i class="fas fa-exclamation-triangle mr-1"></i>Revisá lo siguiente:</strong>
    <ul class="mt-2 pl-5 list-disc"><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
</div>
<?php endif; ?>

<style>
    #tablaItems.modo-listado .col-cantidad,
    #tablaItems.modo-listado .col-subtotal { display: none; }
</style>

<form method="POST" action="<?= esc($accion) ?>" id="formPresupuesto">
    <?= csrf_field() ?>
    <input type="hidden" name="items_json" id="itemsJson">
    <input type="hidden" name="tipo" id="tipoInput" value="<?= esc($tipoInicial) ?>">

    <!-- Tipo de documento -->
    <div class="<?= $cardCls ?> mb-6">
        <div class="text-[0.72rem] font-bold uppercase tracking-wider text-gray-400 mb-4">
            <i class="fas fa-layer-group mr-1.5"></i>Tipo de documento
        </div>
        <div class="flex gap-3 flex-wrap" id="tipoPills">
            <button type="button" data-tipo="presupuesto" class="tipo-pill-btn text-left flex items-start gap-3 px-5 py-4 rounded-xl border-2 transition-colors">
                <i class="fas fa-file-invoice-dollar text-lg mt-0.5"></i>
                <span>
                    <span class="block font-bold text-[0.9rem]">Presupuesto</span>
                    <span class="block text-[0.78rem] opacity-70">Cantidades, descuento y total</span>
                </span>
            </button>
            <button type="button" data-tipo="listado" class="tipo-pill-btn text-left flex items-start gap-3 px-5 py-4 rounded-xl border-2 transition-colors">
                <i class="fas fa-th-large text-lg mt-0.5"></i>
                <span>
                    <span class="block font-bold text-[0.9rem]">Listado de opciones</span>
                    <span class="block text-[0.78rem] opacity-70">Varios productos con precio, sin total, para que el cliente elija</span>
                </span>
            </button>
        </div>
    </div>

    <div class="flex flex-wrap gap-6 items-start">

        <!-- ── Columna principal ── -->
        <div class="w-full lg:w-8/12 flex flex-col gap-6">

            <!-- Datos del cliente -->
            <div class="<?= $cardCls ?>">
                <div class="text-[0.72rem] font-bold uppercase tracking-wider text-gray-400 mb-5 pb-3 border-b border-gray-100">
                    <i class="fas fa-user mr-1.5"></i>Datos del cliente
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="<?= $labelCls ?>">Nombre y apellido / Razón social <span class="text-rojo">*</span></label>
                        <input type="text" name="cliente_nombre" class="<?= $inputCls ?>" required maxlength="150"
                               value="<?= esc(old('cliente_nombre', $presupuesto['cliente_nombre'] ?? '')) ?>">
                    </div>
                    <div>
                        <label class="<?= $labelCls ?>">Teléfono <span class="text-rojo">*</span></label>
                        <input type="text" name="cliente_telefono" class="<?= $inputCls ?>" required maxlength="30"
                               placeholder="Ej: 3704 616482"
                               value="<?= esc(old('cliente_telefono', $presupuesto['cliente_telefono'] ?? '')) ?>">
                    </div>
                    <div>
                        <label class="<?= $labelCls ?>">Email <span class="text-gray-400 font-normal">(opcional)</span></label>
                        <input type="email" name="cliente_email" class="<?= $inputCls ?>" maxlength="150"
                               value="<?= esc(old('cliente_email', $presupuesto['cliente_email'] ?? '')) ?>">
                    </div>
                    <div>
                        <label class="<?= $labelCls ?>">DNI / CUIT <span class="text-gray-400 font-normal">(opcional)</span></label>
                        <input type="text" name="cliente_documento" class="<?= $inputCls ?>" maxlength="30"
                               value="<?= esc(old('cliente_documento', $presupuesto['cliente_documento'] ?? '')) ?>">
                    </div>
                    <div>
                        <label class="<?= $labelCls ?>">Válido hasta <span class="text-gray-400 font-normal">(opcional)</span></label>
                        <input type="date" name="valido_hasta" class="<?= $inputCls ?>"
                               value="<?= esc(old('valido_hasta', $presupuesto['valido_hasta'] ?? '')) ?>">
                    </div>
                </div>
            </div>

            <!-- Buscador de productos -->
            <div class="<?= $cardCls ?>">
                <div class="text-[0.72rem] font-bold uppercase tracking-wider text-gray-400 mb-5 pb-3 border-b border-gray-100">
                    <i class="fas fa-box mr-1.5"></i>Productos
                </div>

                <div class="relative mb-5">
                    <input type="text" id="buscadorProducto" class="<?= $inputCls ?>" autocomplete="off"
                           placeholder="Buscá por nombre, código, marca, fábrica, rubro o subrubro...">
                    <div id="resultadosProducto"
                         class="hidden absolute z-20 left-0 right-0 mt-1.5 bg-white border border-gray-200 rounded-xl shadow-lg max-h-80 overflow-y-auto"></div>
                </div>

                <div class="overflow-x-auto rounded-xl border border-gray-100">
                    <table class="w-full text-[0.86rem] border-collapse" id="tablaItems">
                        <thead>
                            <tr>
                                <th class="bg-gray-50/70 text-gray-500 text-[0.7rem] font-bold uppercase tracking-wider px-4 py-3 text-left border-b border-gray-100 w-[70px]">Img.</th>
                                <th class="bg-gray-50/70 text-gray-500 text-[0.7rem] font-bold uppercase tracking-wider px-4 py-3 text-left border-b border-gray-100">Producto</th>
                                <th class="bg-gray-50/70 text-gray-500 text-[0.7rem] font-bold uppercase tracking-wider px-4 py-3 text-left border-b border-gray-100 w-[140px]">Precio</th>
                                <th class="col-cantidad bg-gray-50/70 text-gray-500 text-[0.7rem] font-bold uppercase tracking-wider px-4 py-3 text-center border-b border-gray-100 w-[100px]">Cant.</th>
                                <th class="col-subtotal bg-gray-50/70 text-gray-500 text-[0.7rem] font-bold uppercase tracking-wider px-4 py-3 text-right border-b border-gray-100 w-[130px]">Subtotal</th>
                                <th class="bg-gray-50/70 text-gray-500 text-[0.7rem] font-bold uppercase tracking-wider px-4 py-3 border-b border-gray-100 w-[46px]"></th>
                            </tr>
                        </thead>
                        <tbody id="itemsBody"></tbody>
                    </table>
                    <div id="itemsVacio" class="text-center py-10 px-4 text-gray-400">
                        <i class="fas fa-search text-3xl mb-2 block text-gray-200"></i>
                        <p class="text-[0.85rem]">Buscá arriba y hacé click en un producto para agregarlo.</p>
                    </div>
                </div>
                <p id="notaListado" class="hidden text-[0.8rem] text-gray-400 mt-3">
                    <i class="fas fa-circle-info mr-1"></i>Este listado no calcula un total: cada producto se muestra con su precio individual para que el cliente elija.
                </p>
            </div>

            <!-- Observaciones y condiciones -->
            <div class="<?= $cardCls ?>">
                <div class="text-[0.72rem] font-bold uppercase tracking-wider text-gray-400 mb-5 pb-3 border-b border-gray-100">
                    <i class="fas fa-align-left mr-1.5"></i>Información adicional
                </div>
                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label class="<?= $labelCls ?>">Observaciones</label>
                        <textarea name="observaciones" rows="3" class="<?= $inputCls ?>"><?= esc(old('observaciones', $presupuesto['observaciones'] ?? '')) ?></textarea>
                    </div>
                    <div>
                        <label class="<?= $labelCls ?>">Condiciones comerciales</label>
                        <textarea name="condiciones" rows="3" class="<?= $inputCls ?>" placeholder="Ej: Precios sujetos a variación sin previo aviso. Forma de pago a coordinar."><?= esc(old('condiciones', $presupuesto['condiciones'] ?? '')) ?></textarea>
                    </div>
                </div>
            </div>

        </div>

        <!-- ── Columna lateral: totales ── -->
        <div class="w-full lg:w-[calc(33.333%-1.5rem)] lg:sticky lg:top-24">
            <div class="<?= $cardCls ?>">
                <div class="text-[0.72rem] font-bold uppercase tracking-wider text-gray-400 mb-5 pb-3 border-b border-gray-100">
                    <i class="fas fa-calculator mr-1.5"></i>Resumen
                </div>

                <div id="panelTotales">
                    <div class="mb-4">
                        <label class="<?= $labelCls ?>">Descuento</label>
                        <div class="flex gap-2">
                            <select name="descuento_tipo" id="descuentoTipo" class="border-[1.5px] border-gray-200 rounded-lg px-2 py-2.5 text-[0.85rem] bg-white outline-none focus:border-rojo">
                                <option value="monto" <?= ($presupuesto['descuento_tipo'] ?? 'monto') === 'monto' ? 'selected' : '' ?>>$</option>
                                <option value="porcentaje" <?= ($presupuesto['descuento_tipo'] ?? '') === 'porcentaje' ? 'selected' : '' ?>>%</option>
                            </select>
                            <input type="text" inputmode="decimal" name="descuento_valor" id="descuentoValor" class="<?= $inputCls ?>"
                                   value="<?= esc(old('descuento_valor', isset($presupuesto['descuento_valor']) ? rtrim(rtrim((string)(float)$presupuesto['descuento_valor'], '0'), '.') : '0')) ?>">
                        </div>
                    </div>

                    <div class="flex flex-col gap-2.5 py-4 border-t border-gray-100 text-[0.9rem]">
                        <div class="flex justify-between text-gray-500">
                            <span>Subtotal</span>
                            <span id="resSubtotal" class="font-semibold text-dark">$0</span>
                        </div>
                        <div class="flex justify-between text-gray-500">
                            <span>Descuento</span>
                            <span id="resDescuento" class="font-semibold text-dark">-$0</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-baseline py-4 border-t border-gray-100">
                        <span class="font-bold text-dark">Total</span>
                        <span id="resTotal" class="text-[1.5rem] font-extrabold text-rojo">$0</span>
                    </div>
                </div>

                <button type="submit" class="<?= $btnRojo ?> w-full mt-3">
                    <i class="fas fa-save"></i> <?= $esEdicion ? 'Guardar cambios' : 'Crear presupuesto' ?>
                </button>
            </div>
        </div>

    </div>
</form>

<script>
const BASE_URL = <?= json_encode(base_url()) ?>;
let items = <?= json_encode($detallesIniciales) ?>;

const fmt = (n) => '$' + Math.round(n).toLocaleString('es-AR');

function calcularTotales() {
    const subtotal = items.reduce((acc, it) => acc + (parseFloat(it.precio_unitario) || 0) * (parseInt(it.cantidad) || 0), 0);
    const tipo  = document.getElementById('descuentoTipo').value;
    const valor = parseFloat((document.getElementById('descuentoValor').value || '0').replace(',', '.')) || 0;
    let descuento = tipo === 'porcentaje' ? subtotal * (Math.min(100, Math.max(0, valor)) / 100) : Math.max(0, valor);
    descuento = Math.min(descuento, subtotal);
    const total = subtotal - descuento;

    document.getElementById('resSubtotal').textContent  = fmt(subtotal);
    document.getElementById('resDescuento').textContent = '-' + fmt(descuento);
    document.getElementById('resTotal').textContent      = fmt(total);
}

function renderItems() {
    const tbody  = document.getElementById('itemsBody');
    const vacio  = document.getElementById('itemsVacio');
    tbody.innerHTML = '';

    vacio.classList.toggle('hidden', items.length > 0);

    items.forEach((it, idx) => {
        const tr = document.createElement('tr');
        tr.className = 'border-b border-gray-50 last:border-b-0';
        tr.innerHTML = `
            <td class="px-4 py-3 align-middle">${miniatura(it.imagen)}</td>
            <td class="px-4 py-3 align-middle">
                <div class="font-semibold text-dark">${escapeHtml(it.producto_nombre)}</div>
                ${it.producto_codigo ? `<div class="text-[0.75rem] text-gray-400 font-mono">${escapeHtml(it.producto_codigo)}</div>` : ''}
            </td>
            <td class="px-4 py-3 align-middle">
                ${it.precio_interno ? '<div class="text-[0.62rem] font-bold text-amber-600 uppercase tracking-wide mb-0.5"><i class="fas fa-lock text-[0.55rem]"></i> precio interno</div>' : ''}
                <input type="text" inputmode="decimal" value="${it.precio_unitario}" data-idx="${idx}" data-campo="precio_unitario"
                       class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-[0.85rem] text-right outline-none focus:border-rojo item-input">
            </td>
            <td class="col-cantidad px-4 py-3 align-middle">
                <input type="number" min="1" value="${it.cantidad}" data-idx="${idx}" data-campo="cantidad"
                       class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-[0.85rem] text-center outline-none focus:border-rojo item-input">
            </td>
            <td class="col-subtotal px-4 py-3 align-middle text-right font-bold text-dark">${fmt((parseFloat(it.precio_unitario) || 0) * (parseInt(it.cantidad) || 0))}</td>
            <td class="px-4 py-3 align-middle text-center">
                <button type="button" class="text-red-400 hover:text-red-600 transition-colors" data-idx="${idx}" data-accion="quitar" title="Quitar">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    calcularTotales();
}

function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str ?? '';
    return div.innerHTML;
}

/* Miniatura de producto: reutiliza la imagen principal del catálogo (o un placeholder si no tiene). */
function miniatura(url, size) {
    size = size === 'sm' ? 'w-11 h-11' : 'w-14 h-14';
    const caja = `${size} rounded-lg border border-gray-100 bg-white flex items-center justify-center overflow-hidden shrink-0`;
    if (url) {
        return `<div class="${caja}"><img src="${escapeHtml(url)}" class="max-w-full max-h-full object-contain" loading="lazy" alt=""></div>`;
    }
    return `<div class="${caja} bg-gray-50"><i class="fas fa-image text-gray-300 text-sm"></i></div>`;
}

document.getElementById('itemsBody').addEventListener('input', function (e) {
    const idx = e.target.dataset.idx;
    const campo = e.target.dataset.campo;
    if (idx === undefined || !campo) return;
    items[idx][campo] = e.target.value;
    // Actualiza solo el subtotal de la fila y los totales, sin perder el foco del input
    const subtotalCell = e.target.closest('tr').children[4];
    subtotalCell.textContent = fmt((parseFloat(items[idx].precio_unitario) || 0) * (parseInt(items[idx].cantidad) || 0));
    calcularTotales();
});

document.getElementById('itemsBody').addEventListener('click', function (e) {
    const btn = e.target.closest('[data-accion="quitar"]');
    if (!btn) return;
    items.splice(parseInt(btn.dataset.idx), 1);
    renderItems();
});

document.getElementById('descuentoTipo').addEventListener('change', calcularTotales);
document.getElementById('descuentoValor').addEventListener('input', calcularTotales);

/* Tipo de documento: presupuesto (con total) vs listado de opciones (sin total) */
const PILL_TIPO_BASE     = 'tipo-pill-btn text-left flex items-start gap-3 px-5 py-4 rounded-xl border-2 transition-colors';
const PILL_TIPO_ACTIVA   = PILL_TIPO_BASE + ' border-rojo bg-rojo/5 text-rojo';
const PILL_TIPO_INACTIVA = PILL_TIPO_BASE + ' border-gray-200 text-gray-500 hover:border-gray-300';

function setTipo(tipo) {
    document.getElementById('tipoInput').value = tipo;
    document.querySelectorAll('#tipoPills [data-tipo]').forEach(function (btn) {
        btn.className = (btn.dataset.tipo === tipo) ? PILL_TIPO_ACTIVA : PILL_TIPO_INACTIVA;
    });

    const esListado = tipo === 'listado';
    document.getElementById('tablaItems').classList.toggle('modo-listado', esListado);
    document.getElementById('panelTotales').classList.toggle('hidden', esListado);
    document.getElementById('notaListado').classList.toggle('hidden', !esListado);
}

document.querySelectorAll('#tipoPills [data-tipo]').forEach(function (btn) {
    btn.addEventListener('click', function () { setTipo(this.dataset.tipo); });
});

setTipo(<?= json_encode($tipoInicial) ?>);

/* Buscador de productos */
let debounceTimer = null;
const inputBuscar = document.getElementById('buscadorProducto');
const cajaResultados = document.getElementById('resultadosProducto');

inputBuscar.addEventListener('input', function () {
    clearTimeout(debounceTimer);
    const q = this.value.trim();
    if (q.length < 2) {
        cajaResultados.classList.add('hidden');
        return;
    }
    debounceTimer = setTimeout(() => buscarProductos(q), 300);
});

document.addEventListener('click', function (e) {
    if (!cajaResultados.contains(e.target) && e.target !== inputBuscar) {
        cajaResultados.classList.add('hidden');
    }
});

function buscarProductos(q) {
    fetch(BASE_URL + 'admin/presupuestos/buscar-productos?q=' + encodeURIComponent(q))
        .then(r => r.json())
        .then(data => {
            if (!data.length) {
                cajaResultados.innerHTML = '<div class="px-4 py-4 text-gray-400 text-[0.85rem]">Sin resultados.</div>';
                cajaResultados.classList.remove('hidden');
                return;
            }
            cajaResultados.innerHTML = data.map(p => `
                <button type="button" data-producto='${JSON.stringify(p).replace(/'/g, "&apos;")}'
                        class="w-full text-left px-4 py-3 border-b border-gray-50 last:border-b-0 hover:bg-gray-50 flex items-center gap-3 transition-colors resultado-item">
                    ${miniatura(p.imagen, 'sm')}
                    <div class="min-w-0 flex-1">
                        <div class="font-semibold text-dark truncate">${escapeHtml(p.nombre)}</div>
                        <div class="text-[0.75rem] text-gray-400 truncate">${escapeHtml(p.codigo || '')} ${p.marca ? '· ' + escapeHtml(p.marca) : ''}</div>
                    </div>
                    <div class="shrink-0 text-right whitespace-nowrap">
                        ${p.precio_interno > 0 ? '<div class="text-[0.62rem] font-bold text-amber-600 uppercase tracking-wide"><i class="fas fa-lock text-[0.55rem]"></i> interno</div>' : ''}
                        <div class="font-bold text-rojo text-[0.85rem]">${fmt(p.precio)}</div>
                    </div>
                </button>
            `).join('');
            cajaResultados.classList.remove('hidden');
        });
}

cajaResultados.addEventListener('click', function (e) {
    const btn = e.target.closest('.resultado-item');
    if (!btn) return;
    const p = JSON.parse(btn.dataset.producto.replace(/&apos;/g, "'"));

    const existente = items.find(it => it.producto_id === p.id);
    if (existente) {
        existente.cantidad = (parseInt(existente.cantidad) || 0) + 1;
    } else {
        items.push({
            producto_id: p.id,
            producto_nombre: p.nombre,
            producto_codigo: p.codigo,
            precio_unitario: p.precio,
            precio_interno: p.precio_interno > 0,
            cantidad: 1,
            imagen: p.imagen,
        });
    }
    renderItems();
    inputBuscar.value = '';
    cajaResultados.classList.add('hidden');
});

document.getElementById('formPresupuesto').addEventListener('submit', function (e) {
    if (items.length === 0) {
        e.preventDefault();
        Swal.fire({ icon: 'warning', title: 'Agregá al menos un producto', confirmButtonColor: '#FF0033' });
        return;
    }
    document.getElementById('itemsJson').value = JSON.stringify(items);
});

renderItems();
</script>

<?= $this->endSection() ?>
