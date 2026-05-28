<?= $this->extend('componentes/base') ?>

<?= $this->section('contenido') ?>
    <?= $this->include('contenido/catalogo_header') ?>

    <?php if (isset($current['subrubros'])): ?>
        <?php /* Página de rubro: primero la grilla de subrubros */ ?>
        <?= $this->include('contenido/catalogo_subrubros') ?>
        <?php if (!empty($productosSeccion)): ?>
            <?php /* Debajo de los subrubros: productos destacados de este rubro */ ?>
            <?= $this->include('componentes/productos_seccion') ?>
        <?php endif; ?>
    <?php else: ?>
        <?php /* Página de subrubro (hoja): primero la grilla completa, luego los destacados */ ?>
        <?= $this->include('contenido/catalogo_grid') ?>
        <?php if (!empty($productosSeccion)): ?>
            <?= $this->include('componentes/productos_seccion') ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php /* Modal único para todas las tarjetas de producto de la página */ ?>
    <?= $this->include('componentes/modal_producto') ?>

    <?php if (!empty($destacados)): ?>
        <?= $this->include('componentes/carrusel_destacados') ?>
    <?php endif; ?>
<?= $this->endSection() ?>
