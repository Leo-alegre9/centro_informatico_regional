<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">

    <!-- Agregamos Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <title>Centro Informático</title>
    <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        color: #333;
        background: #f4f7fb;
    }

    header {
        background: linear-gradient(135deg, #0d47a1 0%, #1976d2 100%);
        color: white;
        padding: 60px 20px;
        text-align: center;
    }

    header h1 {
        margin: 0;
        font-size: 3rem;
    }

    header p {
        margin: 15px auto 0;
        max-width: 720px;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    .btn-primary {
        display: inline-block;
        margin-top: 25px;
        padding: 15px 30px;
        background: #ff9800;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
    }

    main {
        padding: 60px 20px;
        max-width: 1100px;
        margin: 0 auto;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 24px;
    }

    .card {
        background: white;
        border-radius: 14px;
        box-shadow: 0 14px 35px rgba(0, 0, 0, 0.08);
        padding: 28px;
    }

    .card h2 {
        margin-top: 0;
        color: #0d47a1;
    }

    .card p {
        line-height: 1.7;
        color: #555;
    }

    .highlight {
        color: #1976d2;
        font-weight: bold;
    }

    .section-title {
        text-align: center;
        margin-bottom: 40px;
    }

    footer {
        text-align: center;
        padding: 30px 20px;
        color: #777;
    }
    </style>
</head>

<body>
    <header>
        <h1>Centro Informático</h1>
        <p>Bienvenido a tu aliado tecnológico en el corazón de la ciudad. Reparación, asesoría, mantenimiento y
            soluciones completas para tu equipo.</p>
        <a href="#servicios" class="btn-primary">Conoce nuestros servicios</a>
    </header>
    <main>
        <section class="section-title">
            <h2>Servicios especializados</h2>
            <p>En el Centro Informático ofrecemos soluciones rápidas y confiables para particulares, empresas y
                profesionales.</p>
        </section>
        <div class="grid" id="servicios">
            <article class="card">
                <h2>Reparación de computadoras</h2>
                <p>Diagnóstico preciso y reparación de hardware: PC, portátiles, pantallas, fuentes de alimentación,
                    memorias y más.</p>
            </article>
            <article class="card">
                <h2>Soporte técnico</h2>
                <p>Asesoría personalizada para resolver incidencias, configurar redes, instalar software y optimizar tu
                    equipo.</p>
            </article>
            <article class="card">
                <h2>Instalación y mantenimiento</h2>
                <p>Mantenimientos preventivos y correctivos para prolongar la vida útil de tus dispositivos y mejorar su
                    rendimiento.</p>
            </article>
            <article class="card">
                <h2>Venta de componentes</h2>
                <p>Componentes fiables y compatibles para actualizar tu equipo: discos SSD, memorias RAM, procesadores y
                    periféricos.</p>
            </article>
        </div>
        <section class="section-title" style="margin-top: 60px;">
            <h2>Por qué elegirnos</h2>
        </section>
        <div class="grid">
            <article class="card">
                <h2>Atención cercana</h2>
                <p>Servicio local con trato amable y transparente. Te explicamos el problema y las opciones para
                    solucionarlo.</p>
            </article>
            <article class="card">
                <h2>Calidad garantizada</h2>
                <p>Trabajamos con piezas de primera calidad y realizamos pruebas completas antes de entregar tu equipo.
                </p>
            </article>
            <article class="card">
                <h2>Soluciones rápidas</h2>
                <p>Atendemos tus urgencias con velocidad para que vuelvas a trabajar o estudiar sin demoras.</p>
            </article>
        </div>
    </main>
    <?php include 'componentes/footer.php'; ?>
</body>

</html>