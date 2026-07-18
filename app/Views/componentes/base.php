<!DOCTYPE html>
<html lang="es">

<?= $this->include('componentes/header') ?>

<body>

    <?= $this->include('componentes/navbar') ?>

    <main>
        <?= $this->renderSection('contenido') ?>
    </main>

    <?= $this->include('componentes/footer') ?>

    <?= $this->renderSection('scripts') ?>

</body>
</html>
