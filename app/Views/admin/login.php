<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión | Centro Informático Regional</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <?= $this->include('componentes/tailwind_config') ?>
</head>
<body class="flex min-h-screen font-sans m-0 p-0">

    <!-- Panel izquierdo — branding -->
    <div class="hidden lg:flex relative w-1/2 flex-col justify-center items-center overflow-hidden p-12
                bg-[linear-gradient(135deg,#070c1a_0%,#1F2937_55%,#0c1117_100%)]
                before:content-[''] before:absolute before:w-[420px] before:h-[420px]
                before:bg-[radial-gradient(circle,rgba(255,0,51,0.14)_0%,transparent_70%)]
                before:top-1/2 before:left-1/2 before:-translate-x-1/2 before:-translate-y-1/2 before:pointer-events-none">
        <div class="relative z-10 text-center">
            <div class="w-[110px] h-[110px] mx-auto mb-[1.8rem]">
                <img src="<?= base_url('assets/img/CIR_sinfondo.png') ?>" alt="Logo CIR" class="w-full h-full object-contain">
            </div>
            <h1 class="text-white text-[1.75rem] font-bold mb-2 leading-[1.25]">Centro Informático<br>Regional</h1>
            <div class="text-white/40 text-[0.7rem] font-semibold tracking-[3px] uppercase">El Colorado, Formosa</div>
        </div>
    </div>

    <!-- Panel derecho — formulario -->
    <div class="w-full lg:w-1/2 bg-white flex flex-col justify-center items-center px-6 py-8 lg:p-12">
        <div class="w-full max-w-[420px]">

            <!-- Logo para mobile -->
            <div class="block lg:hidden text-center mb-8">
                <img src="<?= base_url('assets/img/logo_negrorojo.jpg') ?>" alt="Logo CIR" class="w-14 h-14 rounded-xl object-cover border-2 border-rojo/25 mx-auto">
                <div class="mt-[0.6rem] font-bold text-dark text-base">Centro Informático Regional</div>
            </div>

            <h2 class="text-[1.6rem] font-bold text-dark mb-[0.4rem]">Iniciar sesión</h2>
            <p class="text-gray-500 text-[0.95rem] mb-8">Ingresá tu email y contraseña para continuar</p>

            <form action="<?= base_url('admin/login') ?>" method="POST">

                <div class="mb-4">
                    <label for="email" class="text-[0.85rem] font-semibold text-gray-700 mb-[0.35rem] block">Correo electrónico</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="w-full border-[1.5px] border-gray-200 rounded-[10px] px-4 py-[0.65rem] text-[0.95rem] text-dark transition-colors focus:border-rojo focus:ring-[3px] focus:ring-rojo/10 focus:outline-none"
                        placeholder="tu@email.com"
                        value="<?= esc(old('email')) ?>"
                        required
                        autocomplete="email"
                    >
                </div>

                <div class="mb-6">
                    <label for="password" class="text-[0.85rem] font-semibold text-gray-700 mb-[0.35rem] block">Contraseña</label>
                    <div class="flex">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full border-[1.5px] border-gray-200 border-r-0 rounded-l-[10px] rounded-r-none px-4 py-[0.65rem] text-[0.95rem] text-dark transition-colors focus:border-rojo focus:ring-[3px] focus:ring-rojo/10 focus:outline-none"
                            placeholder="••••••••"
                            required
                            autocomplete="current-password"
                        >
                        <button type="button" class="flex items-center justify-center border-[1.5px] border-gray-200 border-l-0 bg-white rounded-r-[10px] px-4 text-gray-400 cursor-pointer transition-colors hover:text-rojo" id="togglePass" title="Mostrar/ocultar">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="bg-rojo hover:bg-rojo-dark text-white border-none rounded-full px-8 py-[0.72rem] text-base font-semibold w-full cursor-pointer transition-all duration-200 mt-2 hover:-translate-y-px active:translate-y-0">
                    <i class="fas fa-right-to-bracket mr-2"></i>Ingresar
                </button>

            </form>

            <!-- Registro deshabilitado (próximamente) -->
            <div class="flex items-center gap-3 my-6 mb-4 text-gray-300 text-[0.82rem]
                        before:content-[''] before:flex-1 before:h-px before:bg-gray-200
                        after:content-[''] after:flex-1 after:h-px after:bg-gray-200">o</div>
            <button class="w-full bg-transparent border-[1.5px] border-gray-200 rounded-full px-8 py-[0.65rem] text-[0.92rem] font-medium text-gray-300 cursor-not-allowed flex items-center justify-center gap-2" disabled title="Disponible próximamente">
                <i class="fas fa-user-plus"></i> Crear una cuenta
            </button>
            <p class="text-center text-[0.77rem] text-gray-300 mt-[0.55rem] flex items-center justify-center gap-1.5">
                <i class="fas fa-clock"></i> Registro de usuarios próximamente
            </p>

            <div class="text-center mt-7 text-[0.88rem] text-gray-400">
                <a href="<?= base_url() ?>" class="text-rojo no-underline font-medium hover:underline"><i class="fas fa-arrow-left mr-1"></i>Volver al sitio</a>
            </div>
        </div>
    </div>

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
