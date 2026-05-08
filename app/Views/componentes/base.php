<!DOCTYPE html>
<html lang="es">

<?= $this->include('componentes/header') ?>

<body>

    <?= $this->include('componentes/navbar') ?>

    <main>
        <?= $this->renderSection('contenido') ?>
    </main>

    <?= $this->include('componentes/footer') ?>

    <script src="<?= base_url('public/assets/js/bootstrap.bundle.min.js') ?>"></script>

    <?= $this->renderSection('scripts') ?>

</body>
</html>
