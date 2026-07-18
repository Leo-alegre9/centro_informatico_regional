<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<div class="mb-7">
    <h2 class="text-[1.4rem] font-bold text-dark mb-1">Dashboard</h2>
    <p class="text-gray-500 text-[0.95rem]">Bienvenido, <strong><?= esc($adminNombre) ?></strong>. Aquí tenés un resumen del sistema.</p>
</div>

<!-- Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3 mb-4">
    <div class="bg-white rounded-[14px] p-6 shadow-[0_1px_4px_rgba(0,0,0,0.06)] border border-[#f0f0f0] flex items-center gap-[1.2rem] transition-all duration-200 hover:shadow-[0_4px_16px_rgba(0,0,0,0.09)] hover:-translate-y-0.5">
        <div class="w-[54px] h-[54px] rounded-[13px] flex items-center justify-center text-[1.4rem] shrink-0 bg-rojo/10 text-rojo">
            <i class="fas fa-box"></i>
        </div>
        <div>
            <div class="text-[1.9rem] font-bold text-dark leading-none"><?= $totalProductos ?></div>
            <div class="text-[0.82rem] text-gray-500 mt-1">Productos activos</div>
        </div>
    </div>
    <div class="bg-white rounded-[14px] p-6 shadow-[0_1px_4px_rgba(0,0,0,0.06)] border border-[#f0f0f0] flex items-center gap-[1.2rem] transition-all duration-200 hover:shadow-[0_4px_16px_rgba(0,0,0,0.09)] hover:-translate-y-0.5">
        <div class="w-[54px] h-[54px] rounded-[13px] flex items-center justify-center text-[1.4rem] shrink-0 bg-blue-500/10 text-blue-500">
            <i class="fas fa-user-shield"></i>
        </div>
        <div>
            <div class="text-[1.9rem] font-bold text-dark leading-none"><?= $totalAdmins ?></div>
            <div class="text-[0.82rem] text-gray-500 mt-1">Administradores</div>
        </div>
    </div>
    <div class="bg-white rounded-[14px] p-6 shadow-[0_1px_4px_rgba(0,0,0,0.06)] border border-[#f0f0f0] flex items-center gap-[1.2rem] transition-all duration-200 hover:shadow-[0_4px_16px_rgba(0,0,0,0.09)] hover:-translate-y-0.5">
        <div class="w-[54px] h-[54px] rounded-[13px] flex items-center justify-center text-[1.4rem] shrink-0 bg-amber-500/10 text-amber-500">
            <i class="fas fa-layer-group"></i>
        </div>
        <div>
            <div class="text-[1.9rem] font-bold text-dark leading-none">4</div>
            <div class="text-[0.82rem] text-gray-500 mt-1">Rubros</div>
        </div>
    </div>
    <div class="bg-white rounded-[14px] p-6 shadow-[0_1px_4px_rgba(0,0,0,0.06)] border border-[#f0f0f0] flex items-center gap-[1.2rem] transition-all duration-200 hover:shadow-[0_4px_16px_rgba(0,0,0,0.09)] hover:-translate-y-0.5">
        <div class="w-[54px] h-[54px] rounded-[13px] flex items-center justify-center text-[1.4rem] shrink-0 bg-emerald-500/10 text-emerald-500">
            <i class="fas fa-check-circle"></i>
        </div>
        <div>
            <div class="text-[1.9rem] font-bold text-dark leading-none">Online</div>
            <div class="text-[0.82rem] text-gray-500 mt-1">Estado del sitio</div>
        </div>
    </div>
</div>

<!-- Acceso rápido -->
<div class="mb-4">
    <h5 class="text-base font-bold text-gray-700 mb-1">
        <i class="fas fa-bolt mr-2 text-rojo"></i>Acceso rápido
    </h5>
    <p class="text-[0.82rem] text-gray-400">Navegá directo a cada sección del panel.</p>
</div>

<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 mb-4">

    <a href="<?= base_url('admin/productos') ?>" class="bg-white rounded-[14px] px-5 pt-6 pb-5 border border-[#f0f0f0] border-t-4 border-t-rojo text-center no-underline block shadow-[0_1px_4px_rgba(0,0,0,0.06)] transition-all duration-200 hover:shadow-[0_6px_20px_rgba(0,0,0,0.1)] hover:-translate-y-[3px] hover:no-underline">
        <div class="w-[52px] h-[52px] rounded-[13px] inline-flex items-center justify-center text-[1.4rem] mb-[0.85rem] bg-rojo/10 text-rojo">
            <i class="fas fa-box"></i>
        </div>
        <h6 class="text-[0.95rem] font-bold text-dark mb-1">Productos</h6>
        <small class="text-[0.78rem] text-gray-400">Listado completo</small>
    </a>

    <a href="<?= base_url('admin/productos/crear') ?>" class="bg-white rounded-[14px] px-5 pt-6 pb-5 border border-[#f0f0f0] border-t-4 border-t-red-500 text-center no-underline block shadow-[0_1px_4px_rgba(0,0,0,0.06)] transition-all duration-200 hover:shadow-[0_6px_20px_rgba(0,0,0,0.1)] hover:-translate-y-[3px] hover:no-underline">
        <div class="w-[52px] h-[52px] rounded-[13px] inline-flex items-center justify-center text-[1.4rem] mb-[0.85rem] bg-red-500/10 text-red-500">
            <i class="fas fa-plus-circle"></i>
        </div>
        <h6 class="text-[0.95rem] font-bold text-dark mb-1">Nuevo Producto</h6>
        <small class="text-[0.78rem] text-gray-400">Agregar al catálogo</small>
    </a>

    <a href="<?= base_url('admin/categorias') ?>" class="bg-white rounded-[14px] px-5 pt-6 pb-5 border border-[#f0f0f0] border-t-4 border-t-amber-500 text-center no-underline block shadow-[0_1px_4px_rgba(0,0,0,0.06)] transition-all duration-200 hover:shadow-[0_6px_20px_rgba(0,0,0,0.1)] hover:-translate-y-[3px] hover:no-underline">
        <div class="w-[52px] h-[52px] rounded-[13px] inline-flex items-center justify-center text-[1.4rem] mb-[0.85rem] bg-amber-500/10 text-amber-500">
            <i class="fas fa-sitemap"></i>
        </div>
        <h6 class="text-[0.95rem] font-bold text-dark mb-1">Categorías</h6>
        <small class="text-[0.78rem] text-gray-400">Rubros y subrubros</small>
    </a>

    <a href="<?= base_url('admin/marcas') ?>" class="bg-white rounded-[14px] px-5 pt-6 pb-5 border border-[#f0f0f0] border-t-4 border-t-emerald-500 text-center no-underline block shadow-[0_1px_4px_rgba(0,0,0,0.06)] transition-all duration-200 hover:shadow-[0_6px_20px_rgba(0,0,0,0.1)] hover:-translate-y-[3px] hover:no-underline">
        <div class="w-[52px] h-[52px] rounded-[13px] inline-flex items-center justify-center text-[1.4rem] mb-[0.85rem] bg-emerald-500/10 text-emerald-500">
            <i class="fas fa-tag"></i>
        </div>
        <h6 class="text-[0.95rem] font-bold text-dark mb-1">Marcas</h6>
        <small class="text-[0.78rem] text-gray-400">Gestionar marcas</small>
    </a>

    <a href="<?= base_url('admin/consultas') ?>" class="bg-white rounded-[14px] px-5 pt-6 pb-5 border border-[#f0f0f0] border-t-4 border-t-blue-500 text-center no-underline block shadow-[0_1px_4px_rgba(0,0,0,0.06)] transition-all duration-200 hover:shadow-[0_6px_20px_rgba(0,0,0,0.1)] hover:-translate-y-[3px] hover:no-underline">
        <div class="w-[52px] h-[52px] rounded-[13px] inline-flex items-center justify-center text-[1.4rem] mb-[0.85rem] bg-blue-500/10 text-blue-500">
            <i class="fas fa-comments"></i>
        </div>
        <h6 class="text-[0.95rem] font-bold text-dark mb-1">Consultas</h6>
        <small class="text-[0.78rem] text-gray-400">Mensajes recibidos</small>
    </a>

    <a href="<?= base_url('admin/stock') ?>" class="bg-white rounded-[14px] px-5 pt-6 pb-5 border border-[#f0f0f0] border-t-4 border-t-cyan-500 text-center no-underline block shadow-[0_1px_4px_rgba(0,0,0,0.06)] transition-all duration-200 hover:shadow-[0_6px_20px_rgba(0,0,0,0.1)] hover:-translate-y-[3px] hover:no-underline">
        <div class="w-[52px] h-[52px] rounded-[13px] inline-flex items-center justify-center text-[1.4rem] mb-[0.85rem] bg-cyan-500/10 text-cyan-500">
            <i class="fas fa-cubes"></i>
        </div>
        <h6 class="text-[0.95rem] font-bold text-dark mb-1">Stock</h6>
        <small class="text-[0.78rem] text-gray-400">Actualizar cantidades</small>
    </a>

    <a href="<?= base_url('admin/inventario') ?>" class="bg-white rounded-[14px] px-5 pt-6 pb-5 border border-[#f0f0f0] border-t-4 border-t-violet-500 text-center no-underline block shadow-[0_1px_4px_rgba(0,0,0,0.06)] transition-all duration-200 hover:shadow-[0_6px_20px_rgba(0,0,0,0.1)] hover:-translate-y-[3px] hover:no-underline">
        <div class="w-[52px] h-[52px] rounded-[13px] inline-flex items-center justify-center text-[1.4rem] mb-[0.85rem] bg-violet-500/10 text-violet-500">
            <i class="fas fa-warehouse"></i>
        </div>
        <h6 class="text-[0.95rem] font-bold text-dark mb-1">Inventario</h6>
        <small class="text-[0.78rem] text-gray-400">Ver por ubicación</small>
    </a>

    <a href="<?= base_url('admin/configuracion') ?>" class="bg-white rounded-[14px] px-5 pt-6 pb-5 border border-[#f0f0f0] border-t-4 border-t-gray-500 text-center no-underline block shadow-[0_1px_4px_rgba(0,0,0,0.06)] transition-all duration-200 hover:shadow-[0_6px_20px_rgba(0,0,0,0.1)] hover:-translate-y-[3px] hover:no-underline">
        <div class="w-[52px] h-[52px] rounded-[13px] inline-flex items-center justify-center text-[1.4rem] mb-[0.85rem] bg-gray-500/10 text-gray-500">
            <i class="fas fa-cog"></i>
        </div>
        <h6 class="text-[0.95rem] font-bold text-dark mb-1">Configuración</h6>
        <small class="text-[0.78rem] text-gray-400">Ajustes del sistema</small>
    </a>

    <a href="<?= base_url() ?>" target="_blank" class="bg-white rounded-[14px] px-5 pt-6 pb-5 border border-[#f0f0f0] border-t-4 border-t-sky-500 text-center no-underline block shadow-[0_1px_4px_rgba(0,0,0,0.06)] transition-all duration-200 hover:shadow-[0_6px_20px_rgba(0,0,0,0.1)] hover:-translate-y-[3px] hover:no-underline">
        <div class="w-[52px] h-[52px] rounded-[13px] inline-flex items-center justify-center text-[1.4rem] mb-[0.85rem] bg-sky-500/10 text-sky-500">
            <i class="fas fa-globe"></i>
        </div>
        <h6 class="text-[0.95rem] font-bold text-dark mb-1">Ver Sitio</h6>
        <small class="text-[0.78rem] text-gray-400">Abrir en nueva pestaña</small>
    </a>

</div>

<?= $this->endSection() ?>
