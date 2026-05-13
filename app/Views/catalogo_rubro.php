<?= $this->extend('componentes/base') ?>

<?= $this->section('contenido') ?>
    <?= $this->include('contenido/catalogo_header') ?>
    <?php if (isset($current['subrubros'])): ?>
        <?= $this->include('contenido/catalogo_subrubros') ?>
    <?php else: ?>
        <?= $this->include('contenido/catalogo_grid') ?>
        <?= $this->include('componentes/modal_producto') ?>
    <?php endif; ?>
<?= $this->endSection() ?>
