<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
    <h2 class="text-[1.4rem] font-bold text-dark m-0"><i class="fas fa-box mr-2 text-rojo text-[1.1rem]"></i>Gestión de Productos</h2>
    <a href="<?= base_url('admin/productos/crear') ?>" class="bg-rojo text-white border-none px-5 py-[0.55rem] rounded-full text-sm font-semibold no-underline inline-flex items-center gap-[0.4rem] whitespace-nowrap transition-colors hover:bg-rojo-dark hover:text-white">
        <i class="fas fa-plus"></i> Nuevo Producto
    </a>
</div>

<div class="bg-white border border-gray-200 rounded-xl px-5 py-4 mb-5 flex items-center gap-4 flex-wrap">
    <label for="filtroBuscar" class="text-[0.85rem] font-semibold text-gray-700 m-0"><i class="fas fa-search mr-1"></i>Buscar:</label>
    <input type="text" id="filtroBuscar"
           class="border-[1.5px] border-gray-200 rounded-lg px-[0.9rem] py-[0.4rem] text-[0.88rem] text-gray-700 bg-gray-50 outline-none transition-colors flex-1 min-w-[180px] focus:border-rojo"
           placeholder="Nombre, categoría o badge..." oninput="filtrarTabla(this.value)">
    <span class="bg-rojo/[0.08] text-rojo rounded-full px-[0.7rem] py-[0.2rem] text-[0.8rem] font-semibold ml-auto" id="countVisible"><?= count($productos) ?> productos</span>
</div>

<?php if (!empty($productos)): ?>
<div class="bg-white border border-gray-200 rounded-[14px] overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.05)]">
    <div class="overflow-x-auto">
        <table class="w-full text-[0.88rem] border-collapse">
            <thead>
                <tr>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">#</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Código</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Categoría</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Nombre</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Precio</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Badge</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Activo</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Secciones</th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left" title="Carrusel destacado (catálogo)"><i class="fas fa-star text-amber-500"></i></th>
                    <th class="bg-gray-50 text-gray-700 font-bold text-[0.78rem] uppercase tracking-wide border-b-2 border-gray-200 px-4 py-[0.85rem] whitespace-nowrap text-left">Acciones</th>
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
                    $secDotClases = [
                        'inicio'         => 'bg-red-500/10 text-red-600',
                        'catalogo'       => 'bg-blue-500/10 text-blue-600',
                        'rubro'          => 'bg-amber-500/10 text-amber-600',
                        'subrubro'       => 'bg-emerald-500/10 text-emerald-600',
                        'destacado'      => 'bg-violet-500/10 text-violet-600',
                        'carrusel_promo' => 'bg-pink-500/10 text-pink-700',
                    ];
                ?>
                <tr class="border-t border-gray-100 hover:bg-gray-50" data-busqueda="<?= strtolower(esc($p['nombre']) . ' ' . esc($p['categoria_path'] ?? '') . ' ' . esc($p['badge']) . ' ' . esc($p['codigo'] ?? '')) ?>">
                    <td class="align-middle px-4 py-3 text-gray-400 text-[0.8rem]"><?= $i + 1 ?></td>
                    <td class="align-middle px-4 py-3">
                        <?php if (!empty($p['codigo'])): ?>
                            <span class="bg-indigo-500/10 text-indigo-600 px-[0.55rem] py-[0.15rem] rounded-full text-xs font-bold font-mono">
                                <?= esc($p['codigo']) ?>
                            </span>
                        <?php else: ?>
                            <span class="text-gray-300 text-[0.8rem]">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="align-middle px-4 py-3">
                        <span class="bg-gray-100 text-gray-500 px-[0.55rem] py-[0.15rem] rounded-full text-xs font-semibold"><?= esc($p['categoria_path'] ?? '—') ?></span>
                    </td>
                    <td class="align-middle px-4 py-3">
                        <div class="font-semibold text-dark"><?= esc($p['nombre']) ?></div>
                        <?php if (!empty($p['descripcion_corta'])): ?>
                        <div class="text-[0.78rem] text-gray-400 mt-0.5">
                            <i class="<?= esc($p['icono']) ?> mr-1"></i><?= esc(mb_substr($p['descripcion_corta'], 0, 60)) ?>...
                        </div>
                        <?php endif; ?>
                    </td>
                    <td class="align-middle px-4 py-3 text-[0.85rem]"><?= esc($p['precio_texto']) ?></td>
                    <td class="align-middle px-4 py-3">
                        <?php if ($p['badge']): ?>
                            <span class="bg-rojo/[0.08] text-rojo px-[0.5rem] py-[0.15rem] rounded-full text-xs font-semibold">
                                <?= esc($p['badge']) ?>
                            </span>
                        <?php else: ?>
                            <span class="text-gray-300">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="align-middle px-4 py-3">
                        <?php if ($p['activo']): ?>
                            <span class="inline-flex items-center bg-emerald-500/[0.12] text-emerald-600 px-[0.6rem] py-[0.2rem] rounded-full text-xs font-semibold"><i class="fas fa-check mr-1"></i>Sí</span>
                        <?php else: ?>
                            <span class="inline-flex items-center bg-red-500/10 text-red-600 px-[0.6rem] py-[0.2rem] rounded-full text-xs font-semibold"><i class="fas fa-times mr-1"></i>No</span>
                        <?php endif; ?>
                    </td>
                    <td class="align-middle px-4 py-3">
                        <?php if (!empty($p['secciones_slugs'])): ?>
                        <div class="flex flex-wrap gap-[3px] min-w-[120px]">
                            <?php foreach ($p['secciones_slugs'] as $slug): ?>
                            <?php if (isset($secIconos[$slug])): ?>
                            <span class="inline-flex items-center gap-[3px] text-[0.68rem] font-semibold px-[0.45rem] py-[0.12rem] rounded-full whitespace-nowrap <?= $secDotClases[$slug] ?? '' ?>" title="<?= $secIconos[$slug]['label'] ?>">
                                <i class="fas <?= $secIconos[$slug]['icono'] ?>"></i>
                                <?= $secIconos[$slug]['label'] ?>
                            </span>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <?php else: ?>
                            <span class="text-gray-300 text-[0.8rem]">Sin secciones</span>
                        <?php endif; ?>
                    </td>
                    <td class="align-middle px-4 py-3">
                        <form method="POST" action="<?= base_url("admin/productos/{$p['id']}/destacado") ?>" class="inline">
                            <button type="submit" class="bg-transparent border-none cursor-pointer px-[0.4rem] py-[0.2rem] rounded-md text-base leading-none transition-colors hover:bg-amber-500/[0.12]"
                                    title="<?= $p['destacado'] ? 'Quitar de destacados' : 'Marcar como destacado' ?>">
                                <?php if ($p['destacado']): ?>
                                    <i class="fas fa-star text-amber-500"></i>
                                <?php else: ?>
                                    <i class="fas fa-star text-gray-300"></i>
                                <?php endif; ?>
                            </button>
                        </form>
                    </td>
                    <td class="align-middle px-4 py-3">
                        <div class="flex gap-1 flex-wrap">
                            <a href="<?= base_url("admin/productos/{$p['id']}/editar") ?>"
                               class="inline-flex items-center border border-blue-500 text-blue-500 rounded-md px-[0.7rem] py-[0.3rem] text-[0.78rem] font-semibold no-underline transition-colors hover:bg-blue-500 hover:text-white">
                                <i class="fas fa-pen mr-1"></i>Editar
                            </a>
                            <form method="POST" action="<?= base_url("admin/productos/{$p['id']}/eliminar") ?>" class="inline">
                                <button type="button" class="inline-flex items-center border border-red-500 text-red-500 bg-transparent rounded-md px-[0.7rem] py-[0.3rem] text-[0.78rem] font-semibold cursor-pointer transition-colors hover:bg-red-500 hover:text-white"
                                        onclick="confirmarEliminar(this, '<?= esc($p['nombre']) ?>')">
                                    <i class="fas fa-trash mr-1"></i>Eliminar
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
<div class="bg-white border border-gray-200 rounded-[14px] overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.05)]">
    <div class="text-center px-8 py-16 text-gray-400">
        <i class="fas fa-box-open text-5xl mb-4 block text-gray-300"></i>
        <h5 class="text-gray-700 font-semibold mb-2">No hay productos cargados</h5>
        <p class="text-[0.9rem] mb-6">Todavía no agregaste ningún producto al catálogo.</p>
        <a href="<?= base_url('admin/productos/crear') ?>" class="bg-rojo text-white border-none px-5 py-[0.55rem] rounded-full text-sm font-semibold no-underline inline-flex items-center gap-[0.4rem] transition-colors hover:bg-rojo-dark hover:text-white">
            <i class="fas fa-plus mr-1"></i>Agregar primer producto
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
