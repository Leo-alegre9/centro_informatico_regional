<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Centro Informático Regional' ?></title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?= $this->include('componentes/tailwind_config') ?>

    <style>
        /* ── Variables globales ── */
        :root {
            --rojo:      #FF0033;
            --rojo-dark: #cc0029;
            --dark:      #111827;
            --dark-2:    #1F2937;
            --gris:      #4B5563;
            --fondo:     #F5F5F5;
        }
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { margin: 0; font-family: 'Segoe UI', Arial, sans-serif; color: #333; background: #fff; }

        /* ── Botones compartidos ── */
        .btn-rojo {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: var(--rojo);
            color: #fff;
            padding: 0.85rem 2.2rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.97rem;
            text-decoration: none;
            border: 2px solid var(--rojo);
            transition: background 0.25s, color 0.25s;
        }
        .btn-rojo:hover { background-color: var(--rojo-dark); color: #fff; border-color: var(--rojo-dark); }
        .btn-outline-claro {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: transparent;
            color: #fff;
            padding: 0.85rem 2.2rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.97rem;
            text-decoration: none;
            border: 2px solid rgba(255,255,255,0.28);
            transition: border-color 0.25s, color 0.25s;
        }
        .btn-outline-claro:hover { border-color: #fff; color: #fff; }

        /* ── Helpers de sección compartidos ── */
        .section-eyebrow {
            display: inline-block;
            color: var(--rojo);
            font-weight: 700;
            font-size: 0.78rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }
        .section-heading {
            font-size: clamp(1.8rem, 3vw, 2.6rem);
            font-weight: 800;
            color: var(--dark-2);
            margin-bottom: 0.75rem;
        }
        .section-divider {
            width: 55px;
            height: 4px;
            background: var(--rojo);
            border-radius: 2px;
            margin: 0 auto 3rem;
        }
    </style>

    <?= $this->renderSection('estilos') ?>
</head>
