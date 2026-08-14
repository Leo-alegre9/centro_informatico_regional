<!DOCTYPE html>
<html lang="es">

<?= $this->include('componentes/header') ?>

<body>

    <main>
        <?= $this->renderSection('contenido') ?>
    </main>

    <?= $this->renderSection('scripts') ?>

</body>
</html>
