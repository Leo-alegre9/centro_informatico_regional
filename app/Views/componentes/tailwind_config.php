<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            // Breakpoints alineados a los de Bootstrap 5 para que las reglas
            // responsive existentes (max-width: 991px / 575px, etc.) mapeen 1:1
            // a los prefijos lg: / sm: de Tailwind durante la migración.
            // NOTA: `screens` y `container` deben ir dentro de `theme` — a nivel
            // raíz de tailwind.config son ignorados silenciosamente y Tailwind
            // cae a sus defaults (sin centrar, sin padding), que es lo que
            // rompía el centrado general del sitio.
            screens: {
                sm: '576px',
                md: '768px',
                lg: '992px',
                xl: '1200px',
                '2xl': '1400px',
            },
            container: {
                center: true,
                padding: '1rem',
            },
            extend: {
                colors: {
                    rojo:      '#FF0033',
                    'rojo-dark': '#cc0029',
                    dark:      '#111827',
                    'dark-2':  '#1F2937',
                    gris:      '#4B5563',
                    fondo:     '#F5F5F5',
                },
                fontFamily: {
                    sans:  ['Segoe UI', 'system-ui', 'Arial', 'sans-serif'],
                    inter: ['Inter', 'system-ui', 'sans-serif'],
                },
                keyframes: {
                    'mega-slide-in': {
                        from: { opacity: 0, transform: 'translateY(-8px)' },
                        to:   { opacity: 1, transform: 'translateY(0)' },
                    },
                    'mega-panel-in': {
                        from: { opacity: 0 },
                        to:   { opacity: 1 },
                    },
                    'float-wa-in': {
                        from: { opacity: 0, transform: 'translateY(20px) scale(0.88)' },
                        to:   { opacity: 1, transform: 'translateY(0) scale(1)' },
                    },
                    'float-wa-pulse': {
                        '0%, 100%': { opacity: 0.85, transform: 'scale(1)' },
                        '50%':      { opacity: 0,    transform: 'scale(1.22)' },
                    },
                },
                animation: {
                    'mega-slide-in': 'mega-slide-in 0.2s cubic-bezier(.4,0,.2,1)',
                    'mega-panel-in': 'mega-panel-in 0.16s ease',
                    'float-wa-in':   'float-wa-in 0.55s cubic-bezier(.4,0,.2,1) 0.9s both',
                    'float-wa-pulse': 'float-wa-pulse 2.8s ease-in-out infinite 1.4s',
                },
            },
        },
    };
</script>
