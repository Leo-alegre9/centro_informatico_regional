<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión | Centro Informático Regional</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }
        body { display: flex; min-height: 100vh; font-family: 'Segoe UI', system-ui, sans-serif; }

        /* ── Panel izquierdo (branding) ── */
        .panel-izq {
            width: 50%;
            background: linear-gradient(135deg, #070c1a 0%, #1F2937 55%, #0c1117 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }
        .panel-izq::before {
            content: '';
            position: absolute;
            width: 420px; height: 420px;
            background: radial-gradient(circle, rgba(255,0,51,0.14) 0%, transparent 70%);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }
        .panel-izq .logo-area {
            position: relative;
            z-index: 1;
            text-align: center;
        }
        .panel-izq .logo-img-wrap {
            width: 90px; height: 90px;
            border-radius: 20px;
            overflow: hidden;
            margin: 0 auto 1.8rem;
            border: 2px solid rgba(255,0,51,0.35);
            box-shadow: 0 0 40px rgba(255,0,51,0.12);
        }
        .panel-izq .logo-img-wrap img {
            width: 100%; height: 100%;
            object-fit: cover;
        }
        .panel-izq h1 {
            color: #fff;
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            line-height: 1.25;
        }
        .panel-izq .subtitulo-izq {
            color: rgba(255,255,255,0.38);
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 3px;
            text-transform: uppercase;
        }
        .panel-izq .descripcion {
            color: rgba(255,255,255,0.45);
            font-size: 0.88rem;
            margin-top: 1.75rem;
            max-width: 300px;
            line-height: 1.75;
        }

        /* ── Panel derecho (formulario) ── */
        .panel-der {
            width: 50%;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
        }
        .form-card {
            width: 100%;
            max-width: 420px;
        }
        .logo-mobile {
            display: none;
            text-align: center;
            margin-bottom: 2rem;
        }
        .logo-mobile img {
            width: 56px; height: 56px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid rgba(255,0,51,0.25);
        }
        .form-titulo {
            font-size: 1.6rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.4rem;
        }
        .form-subtitulo {
            color: #6B7280;
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }
        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.35rem;
        }
        .form-control {
            border: 1.5px solid #E5E7EB;
            border-radius: 10px;
            padding: 0.65rem 1rem;
            font-size: 0.95rem;
            color: #111827;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            border-color: #FF0033;
            box-shadow: 0 0 0 3px rgba(255,0,51,0.1);
            outline: none;
        }
        .input-group .form-control {
            border-right: none;
            border-radius: 10px 0 0 10px;
        }
        .btn-ojo {
            border: 1.5px solid #E5E7EB;
            border-left: none;
            background: #fff;
            border-radius: 0 10px 10px 0;
            padding: 0 1rem;
            cursor: pointer;
            color: #9CA3AF;
            transition: color 0.2s;
        }
        .btn-ojo:hover { color: #FF0033; }
        .btn-login {
            background: #FF0033;
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 0.72rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            margin-top: 0.5rem;
        }
        .btn-login:hover { background: #cc0028; transform: translateY(-1px); }
        .btn-login:active { transform: translateY(0); }

        /* ── Registro deshabilitado ── */
        .divider-or {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 1.5rem 0 1rem;
            color: #D1D5DB;
            font-size: 0.82rem;
        }
        .divider-or::before,
        .divider-or::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #E5E7EB;
        }
        .btn-registro-disabled {
            width: 100%;
            background: transparent;
            border: 1.5px solid #E5E7EB;
            border-radius: 50px;
            padding: 0.65rem 2rem;
            font-size: 0.92rem;
            font-weight: 500;
            color: #C9CDD4;
            cursor: not-allowed;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .proximamente-text {
            text-align: center;
            font-size: 0.77rem;
            color: #C9CDD4;
            margin-top: 0.55rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
        .volver-link {
            text-align: center;
            margin-top: 1.75rem;
            font-size: 0.88rem;
            color: #9CA3AF;
        }
        .volver-link a { color: #FF0033; text-decoration: none; font-weight: 500; }
        .volver-link a:hover { text-decoration: underline; }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .panel-izq { display: none; }
            .panel-der { width: 100%; padding: 2rem 1.5rem; }
            .logo-mobile { display: block; }
        }
    </style>
</head>
<body>

    <!-- Panel izquierdo — branding -->
    <div class="panel-izq d-none d-lg-flex">
        <div class="logo-area">
            <div class="logo-img-wrap">
                <img src="<?= base_url('assets/img/logo_negrorojo.jpg') ?>" alt="Logo CIR">
            </div>
            <h1>Centro Informático<br>Regional</h1>
            <div class="subtitulo-izq">El Colorado, Formosa</div>
            <p class="descripcion">
                Accedé a tu cuenta para gestionar consultas, productos y el contenido del sitio.
            </p>
        </div>
    </div>

    <!-- Panel derecho — formulario -->
    <div class="panel-der">
        <div class="form-card">

            <!-- Logo para mobile -->
            <div class="logo-mobile">
                <img src="<?= base_url('assets/img/logo_negrorojo.jpg') ?>" alt="Logo CIR">
                <div style="margin-top:0.6rem; font-weight:700; color:#111827; font-size:1rem;">Centro Informático Regional</div>
            </div>

            <h2 class="form-titulo">Iniciar sesión</h2>
            <p class="form-subtitulo">Ingresá tu email y contraseña para continuar</p>

            <form action="<?= base_url('admin/login') ?>" method="POST">

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        placeholder="tu@email.com"
                        value="<?= esc(old('email')) ?>"
                        required
                        autocomplete="email"
                    >
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            placeholder="••••••••"
                            required
                            autocomplete="current-password"
                        >
                        <button type="button" class="btn-ojo" id="togglePass" title="Mostrar/ocultar">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-right-to-bracket me-2"></i>Ingresar
                </button>

            </form>

            <!-- Registro deshabilitado (próximamente) -->
            <div class="divider-or">o</div>
            <button class="btn-registro-disabled" disabled title="Disponible próximamente">
                <i class="fas fa-user-plus"></i> Crear una cuenta
            </button>
            <p class="proximamente-text">
                <i class="fas fa-clock"></i> Registro de usuarios próximamente
            </p>

            <div class="volver-link">
                <a href="<?= base_url() ?>"><i class="fas fa-arrow-left me-1"></i>Volver al sitio</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('togglePass').addEventListener('click', function () {
            const input = document.getElementById('password');
            const icon  = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });

        <?php $error = session()->getFlashdata('error'); ?>
        <?php if ($error): ?>
        Swal.fire({
            icon: 'error',
            title: 'Acceso denegado',
            text: '<?= addslashes($error) ?>',
            confirmButtonColor: '#FF0033',
            confirmButtonText: 'Aceptar',
        });
        <?php endif; ?>
    </script>
</body>
</html>
