<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<!-- Header -->
<div class="flex items-center justify-between mb-6">
    <h2 class="text-[1.35rem] font-bold text-dark m-0">
        <i class="fas fa-boxes mr-2 text-rojo text-[1.05rem]"></i>
        Gestión de Stock
    </h2>
    <a href="<?= base_url('admin/productos') ?>" class="text-[0.85rem] text-gray-500 no-underline flex items-center gap-1 hover:text-rojo transition-colors">
        <i class="fas fa-box"></i> Ver todos los productos
    </a>
</div>

<?php if ($msg = session()->getFlashdata('success')): ?>
<div class="bg-emerald-500/[0.07] border border-emerald-500/25 rounded-[10px] px-5 py-[0.85rem] text-emerald-800 text-[0.88rem] mb-5 flex items-center gap-[0.6rem]"><i class="fas fa-check-circle"></i> <?= esc($msg) ?></div>
<?php endif; ?>
<?php if ($msg = session()->getFlashdata('error')): ?>
<div class="bg-rojo/5 border border-rojo/20 rounded-[10px] px-5 py-[0.85rem] text-red-600 text-[0.88rem] mb-5 flex items-center gap-[0.6rem]"><i class="fas fa-exclamation-triangle"></i> <?= esc($msg) ?></div>
<?php endif; ?>

<!-- Buscador -->
<div class="bg-white border border-gray-200 rounded-[14px] px-8 py-7 shadow-[0_1px_4px_rgba(0,0,0,0.05)] mb-6">
    <div class="text-[0.72rem] font-bold uppercase tracking-[0.9px] text-gray-400 mb-4 pb-2 border-b border-gray-100"><i class="fas fa-search mr-1"></i>Buscar producto</div>
    <form method="GET" action="<?= base_url('admin/stock') ?>">
        <div class="flex gap-[0.6rem]">
            <input type="text"
                   name="q"
                   class="border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark flex-1 transition-colors focus:border-rojo focus:ring-[3px] focus:ring-rojo/10 focus:outline-none"
                   placeholder="Nombre, modelo o marca del producto..."
                   value="<?= esc($q) ?>"
                   autofocus>
            <button type="submit" class="bg-rojo hover:bg-rojo-dark text-white px-[1.4rem] py-[0.6rem] rounded-[9px] text-[0.92rem] font-semibold inline-flex items-center gap-[0.4rem] cursor-pointer transition-colors whitespace-nowrap">
                <i class="fas fa-search"></i> Buscar
            </button>
            <?php if ($q !== ''): ?>
            <a href="<?= base_url('admin/stock') ?>"
               class="inline-flex items-center gap-[5px] px-4 py-[0.6rem] rounded-[9px] border-[1.5px] border-gray-200 text-gray-500 no-underline text-[0.88rem] font-semibold whitespace-nowrap transition-colors hover:bg-gray-100">
                <i class="fas fa-times"></i> Limpiar
            </a>
            <?php endif; ?>
        </div>
        <div class="text-[0.78rem] text-gray-400 mt-2">
            <i class="fas fa-info-circle mr-1"></i>
            Podés buscar por nombre del producto, número de modelo o marca.
        </div>
    </form>
</div>

<!-- Resultados -->
<?php if ($q === ''): ?>
    <div class="bg-white border border-gray-200 rounded-[14px] shadow-[0_1px_4px_rgba(0,0,0,0.05)] overflow-hidden">
        <div class="text-center py-12 px-4 text-gray-400">
            <i class="fas fa-search text-[2.5rem] block mb-3 text-gray-300"></i>
            <p class="text-[0.9rem] m-0">Ingresá un término de búsqueda para consultar el stock de un producto.</p>
        </div>
    </div>

<?php elseif (empty($productos)): ?>
    <div class="bg-white border border-gray-200 rounded-[14px] shadow-[0_1px_4px_rgba(0,0,0,0.05)] overflow-hidden">
        <div class="text-center py-12 px-4 text-gray-400">
            <i class="fas fa-box-open text-[2.5rem] block mb-3 text-gray-300"></i>
            <p class="text-[0.9rem] m-0">No se encontraron productos para <strong class="text-dark">"<?= esc($q) ?>"</strong>.</p>
        </div>
    </div>

<?php else: ?>
    <div class="bg-white border border-gray-200 rounded-[14px] shadow-[0_1px_4px_rgba(0,0,0,0.05)] overflow-hidden">
        <div class="flex items-center justify-between px-[1.1rem] py-[0.9rem] border-b border-gray-200 bg-gray-50">
            <span class="text-[0.82rem] font-semibold text-gray-500">Resultados para <strong class="text-dark">"<?= esc($q) ?>"</strong></span>
            <span class="bg-rojo/10 text-rojo text-xs font-bold px-2 py-0.5 rounded-full"><?= count($productos) ?> producto<?= count($productos) !== 1 ? 's' : '' ?></span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr>
                        <th class="bg-gray-50 text-gray-500 text-[0.72rem] font-bold uppercase tracking-[0.7px] px-[1.1rem] py-3 border-b border-gray-200 whitespace-nowrap text-left">#</th>
                        <th class="bg-gray-50 text-gray-500 text-[0.72rem] font-bold uppercase tracking-[0.7px] px-[1.1rem] py-3 border-b border-gray-200 whitespace-nowrap text-left">Producto</th>
                        <th class="bg-gray-50 text-gray-500 text-[0.72rem] font-bold uppercase tracking-[0.7px] px-[1.1rem] py-3 border-b border-gray-200 whitespace-nowrap text-left">Categoría</th>
                        <th class="bg-gray-50 text-gray-500 text-[0.72rem] font-bold uppercase tracking-[0.7px] px-[1.1rem] py-3 border-b border-gray-200 whitespace-nowrap text-left">Stock actual</th>
                        <th class="bg-gray-50 text-gray-500 text-[0.72rem] font-bold uppercase tracking-[0.7px] px-[1.1rem] py-3 border-b border-gray-200 whitespace-nowrap text-left">Estado</th>
                        <th class="bg-gray-50 text-gray-500 text-[0.72rem] font-bold uppercase tracking-[0.7px] px-[1.1rem] py-3 border-b border-gray-200 whitespace-nowrap text-left">Actualizar stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $i => $p): ?>
                    <?php
                        $stock = (int) $p['stock'];
                        if ($stock === 0) {
                            $stockClass = 'bg-red-50 text-red-600 border-red-200';
                            $stockLabel = 'Sin stock';
                        } elseif ($stock <= 3) {
                            $stockClass = 'bg-amber-50 text-amber-600 border-amber-200';
                            $stockLabel = $stock . ' unid.';
                        } else {
                            $stockClass = 'bg-green-50 text-green-600 border-green-200';
                            $stockLabel = $stock . ' unid.';
                        }
                    ?>
                    <tr class="border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition-colors">
                        <td class="px-[1.1rem] py-[0.85rem] text-[0.8rem] text-gray-400 align-middle"><?= $i + 1 ?></td>
                        <td class="px-[1.1rem] py-[0.85rem] text-[0.88rem] text-gray-700 align-middle">
                            <div class="font-semibold text-dark"><?= esc($p['nombre']) ?></div>
                            <?php if (!empty($p['modelo'])): ?>
                            <div class="text-[0.78rem] text-gray-400 mt-px"><?= esc($p['modelo']) ?></div>
                            <?php endif; ?>
                            <?php if (!empty($p['marca_nombre'])): ?>
                            <div class="text-[0.78rem] text-gray-500 mt-px"><?= esc($p['marca_nombre']) ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-[1.1rem] py-[0.85rem] text-[0.88rem] text-gray-700 align-middle">
                            <span class="text-[0.78rem] text-gray-500"><?= esc($p['categoria_nombre'] ?? '—') ?></span>
                        </td>
                        <td class="px-[1.1rem] py-[0.85rem] text-[0.88rem] text-gray-700 align-middle">
                            <span class="inline-flex items-center gap-[5px] px-[0.7rem] py-[0.25rem] rounded-full text-[0.8rem] font-bold whitespace-nowrap border <?= $stockClass ?>">
                                <i class="fas fa-<?= $stock === 0 ? 'times-circle' : ($stock <= 3 ? 'exclamation-triangle' : 'check-circle') ?>"></i>
                                <?= $stockLabel ?>
                            </span>
                        </td>
                        <td class="px-[1.1rem] py-[0.85rem] text-[0.88rem] text-gray-700 align-middle">
                            <span>
                                <span class="inline-block w-[7px] h-[7px] rounded-full mr-[5px] align-middle <?= $p['activo'] ? 'bg-green-600' : 'bg-gray-400' ?>"></span>
                                <?= $p['activo'] ? 'Activo' : 'Inactivo' ?>
                            </span>
                        </td>
                        <td class="px-[1.1rem] py-[0.85rem] text-[0.88rem] text-gray-700 align-middle">
                            <form method="POST"
                                  action="<?= base_url('admin/stock/' . $p['id'] . '/actualizar') ?>"
                                  class="flex items-center gap-2">
                                <?= csrf_field() ?>
                                <input type="hidden" name="q" value="<?= esc($q) ?>">
                                <input type="number"
                                       name="stock"
                                       class="w-20 border-[1.5px] border-gray-200 rounded-[7px] px-[0.55rem] py-[0.35rem] text-[0.88rem] font-semibold text-dark text-center transition-colors focus:border-rojo focus:ring-[3px] focus:ring-rojo/10 focus:outline-none"
                                       value="<?= (int) $p['stock'] ?>"
                                       min="0"
                                       step="1"
                                       required>
                                <button type="submit" class="bg-transparent border-[1.5px] border-gray-200 rounded-[7px] px-[0.7rem] py-[0.35rem] text-[0.8rem] font-semibold text-gray-700 cursor-pointer transition-colors whitespace-nowrap inline-flex items-center gap-[5px] hover:border-green-600 hover:text-green-600 hover:bg-green-50">
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
