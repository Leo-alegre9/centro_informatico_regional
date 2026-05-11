<?= $this->extend('admin/layout') ?>
<?= $this->section('contenido') ?>

<style>
    .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 1.5rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        gap: 1.2rem;
        border: 1px solid #f0f0f0;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.09); transform: translateY(-2px); }
    .stat-icon {
        width: 54px; height: 54px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .stat-icon.rojo   { background: rgba(255,0,51,0.1);   color: #FF0033; }
    .stat-icon.azul   { background: rgba(59,130,246,0.1); color: #3B82F6; }
    .stat-icon.verde  { background: rgba(16,185,129,0.1); color: #10B981; }
    .stat-icon.naranja{ background: rgba(245,158,11,0.1); color: #F59E0B; }
    .stat-valor { font-size: 1.9rem; font-weight: 700; color: #111827; line-height: 1; }
    .stat-label { font-size: 0.82rem; color: #6B7280; margin-top: 0.2rem; }

    .quick-card {
        background: #fff;
        border-radius: 14px;
        padding: 1.75rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        border: 1px solid #f0f0f0;
        text-align: center;
    }
    .quick-card i { font-size: 2rem; margin-bottom: 0.75rem; display: block; }
    .quick-card h5 { font-size: 1rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem; }
    .quick-card p { font-size: 0.85rem; color: #6B7280; margin-bottom: 1rem; }
    .btn-rojo {
        background: #FF0033; color: #fff; border: none;
        padding: 0.55rem 1.4rem; border-radius: 50px;
        font-size: 0.9rem; font-weight: 600; text-decoration: none;
        display: inline-flex; align-items: center; gap: 0.4rem;
        transition: background 0.2s;
    }
    .btn-rojo:hover { background: #cc0028; color: #fff; }
    .btn-outline-rojo {
        background: transparent; color: #FF0033;
        border: 2px solid #FF0033;
        padding: 0.5rem 1.4rem; border-radius: 50px;
        font-size: 0.9rem; font-weight: 600; text-decoration: none;
        display: inline-flex; align-items: center; gap: 0.4rem;
        transition: background 0.2s, color 0.2s;
    }
    .btn-outline-rojo:hover { background: #FF0033; color: #fff; }

    .info-box {
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 12px;
        padding: 1.2rem 1.5rem;
        font-size: 0.88rem;
        color: #92400e;
    }
    .info-box code {
        background: rgba(0,0,0,0.07);
        padding: 0.1rem 0.4rem;
        border-radius: 4px;
        font-size: 0.85rem;
    }

    .page-header { margin-bottom: 1.75rem; }
    .page-header h2 { font-size: 1.4rem; font-weight: 700; color: #111827; margin-bottom: 0.2rem; }
    .page-header .saludo { color: #6B7280; font-size: 0.95rem; }
</style>

<div class="page-header">
    <h2>Dashboard</h2>
    <p class="saludo">Bienvenido, <strong><?= esc($adminNombre) ?></strong>. Aquí tenés un resumen del sistema.</p>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon rojo"><i class="fas fa-box"></i></div>
            <div>
                <div class="stat-valor"><?= $totalProductos ?></div>
                <div class="stat-label">Productos activos</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon azul"><i class="fas fa-user-shield"></i></div>
            <div>
                <div class="stat-valor"><?= $totalAdmins ?></div>
                <div class="stat-label">Administradores</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon naranja"><i class="fas fa-layer-group"></i></div>
            <div>
                <div class="stat-valor">4</div>
                <div class="stat-label">Rubros</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon verde"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="stat-valor">Online</div>
                <div class="stat-label">Estado del sitio</div>
            </div>
        </div>
    </div>
</div>

<!-- Acceso rápido -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <h5 style="font-size:1rem;font-weight:700;color:#374151;margin-bottom:1rem;">
            <i class="fas fa-bolt me-2" style="color:#FF0033;"></i>Acceso rápido
        </h5>
    </div>
    <div class="col-12 col-sm-6 col-md-4">
        <div class="quick-card">
            <i class="fas fa-plus-circle" style="color:#FF0033;"></i>
            <h5>Agregar Producto</h5>
            <p>Cargá un nuevo producto al catálogo de la tienda.</p>
            <a href="<?= base_url('admin/productos/crear') ?>" class="btn-rojo">
                <i class="fas fa-plus"></i> Nuevo producto
            </a>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4">
        <div class="quick-card">
            <i class="fas fa-external-link-alt" style="color:#3B82F6;"></i>
            <h5>Ver Sitio</h5>
            <p>Abrí el sitio público en una nueva pestaña.</p>
            <a href="<?= base_url() ?>" target="_blank" class="btn-outline-rojo">
                <i class="fas fa-globe"></i> Abrir sitio
            </a>
        </div>
    </div>
</div>

<!-- Nota informativa -->
<div class="info-box">
    <strong><i class="fas fa-info-circle me-2"></i>Para comenzar:</strong>
    Ejecutá <code>php spark db:seed AdminSeeder</code> para crear el primer administrador.
    Credenciales por defecto: <code>admin@cir.com</code> / <code>CIR@admin2025</code>
</div>

<?= $this->endSection() ?>
