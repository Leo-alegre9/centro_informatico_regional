<?= $this->extend('componentes/base') ?>

<?= $this->section('contenido') ?>
    <?= $this->include('contenido/contacto_hero') ?>
    <?= $this->include('contenido/contacto_form') ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?php if (session()->getFlashdata('success')): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Mensaje enviado!',
        text: <?= json_encode(session()->getFlashdata('success')) ?>,
        confirmButtonColor: '#FF0033',
        timer: 6000,
        timerProgressBar: true,
    });
</script>
<?php endif; ?>
<?php if (session()->getFlashdata('errors')): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Por favor corregí los errores',
        html: <?= json_encode(implode('<br>', session()->getFlashdata('errors'))) ?>,
        confirmButtonColor: '#FF0033',
    });
</script>
<?php endif; ?>
<?= $this->endSection() ?>
