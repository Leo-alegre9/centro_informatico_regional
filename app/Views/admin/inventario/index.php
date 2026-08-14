<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<?php
$inputCls = 'w-full border-[1.5px] border-gray-200 rounded-[9px] px-[0.95rem] py-[0.6rem] text-[0.92rem] text-dark transition-colors focus:border-rojo focus:ring-[3px] focus:ring-rojo/10 focus:outline-none';
?>

<div class="mb-7">
    <h2 class="text-[1.4rem] font-bold text-dark mb-[0.2rem]"><i class="fas fa-warehouse mr-2 text-rojo text-[1.1rem]"></i>Inventario por ubicación</h2>
    <p class="text-gray-500 text-[0.92rem] m-0">Buscá productos según el lugar donde se encuentran. Solo visible para el administrador.</p>
</div>

<!-- Formulario de búsqueda -->
<div class="bg-white border border-gray-100 rounded-2xl p-7 shadow-[0_1px_4px_rgba(0,0,0,0.05)] mb-7">
    <form method="GET" action="<?= base_url('admin/inventario') ?>">
        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-1/3">
                <label for="ubicacion" class="block text-[0.85rem] font-semibold text-gray-700 mb-[0.3rem]">
                    <i class="fas fa-map-marker-alt mr-1 text-rojo"></i>Ubicación
                </label>
                <select id="ubicacion" name="ubicacion" class="<?= $inputCls ?>">
                    <option value="">— Todas las ubicaciones —</option>
                    <option value="En el negocio"        <?= $ubicacion === 'En el negocio'        ? 'selected' : '' ?>>En el negocio</option>
                    <option value="Deposito nuevo local"  <?= $ubicacion === 'Deposito nuevo local'  ? 'selected' : '' ?>>Deposito nuevo local</option>
                    <option value="Deposito quincho"     <?= $ubicacion === 'Deposito quincho'     ? 'selected' : '' ?>>Deposito quincho</option>
                    <option value="Deposito casa"        <?= $ubicacion === 'Deposito casa'        ? 'selected' : '' ?>>Deposito casa</option>
                </select>
            </div>
            <div class="w-full md:w-5/12">
                <label for="q" class="block text-[0.85rem] font-semibold text-gray-700 mb-[0.3rem]">
                    <i class="fas fa-search mr-1 text-rojo"></i>Buscar producto
                </label>
                <input type="text" id="q" name="q" class="<?= $inputCls ?>"
                       value="<?= esc($q) ?>"
                       placeholder="Nombre, modelo, marca...">
            </div>
            <div class="w-full md:w-1/4">
                <div class="flex gap-2">
                    <button type="submit" class="bg-rojo hover:bg-rojo-dark text-white px-7 py-[0.65rem] rounded-full text-[0.92rem] font-semibold inline-flex items-center gap-[0.4rem] transition-colors cursor-pointer">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    <?php if ($buscando): ?>
                    <a href="<?= base_url('admin/inventario') ?>" class="text-gray-500 hover:bg-gray-100 hover:text-gray-700 no-underline px-[1.2rem] py-[0.65rem] rounded-full text-[0.92rem] font-semibold border-[1.5px] border-gray-200 inline-flex items-center gap-[0.4rem] transition-colors">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Resultados -->
<div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.05)]">
    <?php if (!$buscando): ?>
        <div class="text-center py-16 px-8">
            <i class="fas fa-warehouse text-5xl text-gray-200 mb-4 block"></i>
            <p class="text-[0.9rem] text-gray-400 m-0">Seleccioná una ubicación o escribí el nombre de un producto para buscar.</p>
        </div>
    <?php elseif (empty($productos)): ?>
        <div class="text-center py-16 px-8">
            <i class="fas fa-box-open text-5xl text-gray-200 mb-4 block"></i>
            <h5 class="text-base font-bold text-gray-700 mb-[0.4rem]">Sin resultados</h5>
            <p class="text-[0.88rem] text-gray-400 m-0">No se encontraron productos que coincidan con los filtros seleccionados.</p>
        </div>
    <?php else: ?>
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between flex-wrap gap-2">
            <span class="text-[0.92rem] font-bold text-dark">
                <i class="fas fa-list mr-1 text-rojo"></i>
                <?php if ($ubicacion): ?>
                    Productos en <strong><?= esc($ubicacion) ?></strong>
                    <?php if ($q): ?> que coinciden con <strong>"<?= esc($q) ?>"</strong><?php endif; ?>
                <?php else: ?>
                    Resultados para <strong>"<?= esc($q) ?>"</strong>
                <?php endif; ?>
            </span>
            <span class="bg-rojo/10 text-rojo text-[0.78rem] font-bold px-[0.65rem] py-[0.2rem] rounded-full"><?= count($productos) ?> producto<?= count($productos) !== 1 ? 's' : '' ?></span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-[0.87rem]">
                <thead>
                    <tr>
                        <th class="bg-gray-50 text-gray-500 text-[0.72rem] font-bold uppercase tracking-[0.8px] px-[1.2rem] py-[0.7rem] border-b border-gray-100 whitespace-nowrap text-left">Producto</th>
                        <th class="bg-gray-50 text-gray-500 text-[0.72rem] font-bold uppercase tracking-[0.8px] px-[1.2rem] py-[0.7rem] border-b border-gray-100 whitespace-nowrap text-left">Categoría</th>
                        <th class="bg-gray-50 text-gray-500 text-[0.72rem] font-bold uppercase tracking-[0.8px] px-[1.2rem] py-[0.7rem] border-b border-gray-100 whitespace-nowrap text-left">Marca</th>
                        <th class="bg-gray-50 text-gray-500 text-[0.72rem] font-bold uppercase tracking-[0.8px] px-[1.2rem] py-[0.7rem] border-b border-gray-100 whitespace-nowrap text-left">Precio</th>
                        <th class="bg-gray-50 text-gray-500 text-[0.72rem] font-bold uppercase tracking-[0.8px] px-[1.2rem] py-[0.7rem] border-b border-gray-100 whitespace-nowrap text-left">Ubicación</th>
                        <th class="bg-gray-50 text-gray-500 text-[0.72rem] font-bold uppercase tracking-[0.8px] px-[1.2rem] py-[0.7rem] border-b border-gray-100 whitespace-nowrap text-left">Estado</th>
                        <th class="bg-gray-50 text-gray-500 text-[0.72rem] font-bold uppercase tracking-[0.8px] px-[1.2rem] py-[0.7rem] border-b border-gray-100 whitespace-nowrap text-left"></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($productos as $p): ?>
                    <?php
                        $ubic = $p['ubicacion'] ?? '';
                        $ubicClase = match($ubic) {
                            'En el negocio'        => 'bg-emerald-500/10 text-emerald-800',
                            'Deposito nuevo local'  => 'bg-blue-500/10 text-blue-800',
                            'Deposito quincho'     => 'bg-amber-500/10 text-amber-800',
                            'Deposito casa'        => 'bg-violet-500/10 text-violet-800',
                            default                => 'bg-gray-400/15 text-gray-500',
                        };
                        $ubicIcono = match($ubic) {
                            'En el negocio'        => 'fas fa-store',
                            'Deposito nuevo local'  => 'fas fa-warehouse',
                            'Deposito quincho'     => 'fas fa-campground',
                            'Deposito casa'        => 'fas fa-home',
                            default                => 'fas fa-question-circle',
                        };
                    ?>
                    <tr class="border-b border-gray-50 last:border-b-0 hover:bg-gray-50">
                        <td class="px-[1.2rem] py-[0.85rem] align-middle">
                            <div class="font-bold text-dark"><?= esc($p['nombre']) ?></div>
                            <?php if (!empty($p['modelo'])): ?>
                                <div class="text-[0.78rem] text-gray-400"><?= esc($p['modelo']) ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-[1.2rem] py-[0.85rem] align-middle"><span class="text-[0.78rem] text-gray-500"><?= esc($p['categoria_nombre'] ?? '—') ?></span></td>
                        <td class="px-[1.2rem] py-[0.85rem] align-middle"><span class="text-[0.82rem] text-gray-500"><?= esc($p['marca_nombre'] ?? '—') ?></span></td>
                        <td class="px-[1.2rem] py-[0.85rem] align-middle"><span class="font-semibold text-dark text-[0.85rem]"><?= esc($p['precio_texto'] ?? 'Consultar') ?></span></td>
                        <td class="px-[1.2rem] py-[0.85rem] align-middle">
                            <span class="inline-flex items-center gap-[5px] px-3 py-[0.3rem] rounded-full text-[0.75rem] font-bold whitespace-nowrap <?= $ubicClase ?>">
                                <i class="<?= $ubicIcono ?>"></i>
                                <?= $ubic !== '' ? esc($ubic) : 'Sin asignar' ?>
                            </span>
                        </td>
                        <td class="px-[1.2rem] py-[0.85rem] align-middle">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[0.73rem] font-bold <?= $p['activo'] ? 'bg-emerald-500/10 text-emerald-800' : 'bg-gray-400/15 text-gray-500' ?>">
                                <i class="fas fa-circle text-[0.5rem]"></i>
                                <?= $p['activo'] ? 'Activo' : 'Inactivo' ?>
                            </span>
                        </td>
                        <td class="px-[1.2rem] py-[0.85rem] align-middle">
                            <a href="<?= base_url('admin/productos/' . $p['id'] . '/editar') ?>"
                               class="inline-flex items-center gap-1 text-gray-500 text-[0.78rem] no-underline px-[0.6rem] py-1 border border-gray-200 rounded-md transition-colors hover:border-rojo hover:text-rojo">
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
