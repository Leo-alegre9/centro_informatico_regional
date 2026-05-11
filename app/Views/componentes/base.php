<!DOCTYPE html>
<html lang="es">

<?= $this->include('componentes/header') ?>

<body>

    <?= $this->include('componentes/navbar') ?>

    <main>
        <?= $this->renderSection('contenido') ?>
    </main>

    <?= $this->include('componentes/footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <?= $this->renderSection('scripts') ?>

</body>
</html>
