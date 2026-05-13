<?= $this->extend('componentes/base') ?>

<?= $this->section('contenido') ?>
    <?= $this->include('contenido/hero') ?>
    <?= $this->include('contenido/rubros') ?>
    <?= $this->include('contenido/marcas') ?>
    <?= $this->include('contenido/destacados') ?>
    <?= $this->include('contenido/servicio_tecnico') ?>
    <?= $this->include('contenido/contacto_rapido') ?>
    <?= $this->include('contenido/ubicacion') ?>
<?= $this->endSection() ?>
