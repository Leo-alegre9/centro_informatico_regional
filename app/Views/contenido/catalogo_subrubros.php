<?php
$esTemaGaming = isset($current['tema']) && $current['tema'] === 'gaming';
?>

<!-- ═══════════════════════════════════════════════
     SUBRUBROS GRID
═══════════════════════════════════════════════ -->
<section class="py-12 <?= $esTemaGaming ? 'bg-[#070710]' : 'bg-fondo' ?>">
    <div class="container">

        <div class="text-center mb-2">
            <span class="section-eyebrow">Explorá la categoría</span>
            <h2 class="section-heading <?= $esTemaGaming ? '!text-white' : '' ?>"><?= esc($current['nombre']) ?></h2>
        </div>
        <div class="section-divider"></div>

        <?php if (($currentPath ?? '') === 'catalogo'): ?>
        <?php
        $_catModelCat = new \App\Models\CategoriaModel();
        echo view('componentes/mega_nav_panel', [
            'megaMenuData' => $_catModelCat->getMegaMenu(),
            'mnpTema'      => 'light',
        ]);
        ?>
        <?php endif; ?>

        <div class="relative max-w-[520px] mx-auto mb-[2.4rem] mt-6">
            <i class="fas fa-search cat-search-icon absolute left-[1.1rem] top-1/2 -translate-y-1/2 text-[0.95rem] pointer-events-none <?= $esTemaGaming ? 'text-white/40' : 'text-gris' ?>"></i>
            <input type="text"
                   id="buscador-subrubros"
                   class="w-full py-3 pr-12 pl-[2.85rem] rounded-full text-[0.93rem] outline-none transition-all duration-200 border-2 <?= $esTemaGaming
                        ? 'bg-[#0d0d1c] border-white/[0.12] text-white placeholder:text-white/30 focus:border-rojo'
                        : 'border-[#e5e7eb] text-dark bg-white placeholder:text-[#adb5bd] focus:border-rojo focus:shadow-[0_0_0_3px_rgba(255,0,51,0.1)]' ?>"
                   placeholder="Buscar en <?= esc($current['nombre']) ?>...">
            <button type="button" class="hidden absolute right-4 top-1/2 -translate-y-1/2 bg-transparent border-none text-[#adb5bd] cursor-pointer text-[0.85rem] p-1 leading-none hover:text-rojo" id="clear-subrubros" title="Limpiar búsqueda">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="grid grid-cols-3 gap-[1.4rem] max-[991px]:grid-cols-2 max-[575px]:grid-cols-1" id="subrubros-grid">
            <?php foreach ($current['subrubros'] as $key => $sub): ?>
            <a href="<?= base_url($currentPath . '/' . $key) ?>"
               class="subrubro-card group flex flex-col rounded-[18px] p-[2rem_1.8rem] no-underline border-b-[3px] border-b-transparent transition-all duration-300 ease-out hover:-translate-y-[7px] hover:shadow-[0_22px_55px_rgba(0,0,0,0.22)] hover:border-b-rojo <?= $esTemaGaming ? 'bg-[#0d0d1c] border border-rojo/[0.06]' : 'bg-dark-2' ?>"
               data-busqueda="<?= esc(strtolower($sub['nombre'] . ' ' . $sub['descripcion'])) ?>">
                <div class="w-[58px] h-[58px] rounded-[14px] bg-rojo/10 border-[1.5px] border-rojo/[0.28] flex items-center justify-center text-[1.4rem] text-rojo mb-[1.1rem] transition-colors duration-[250ms] group-hover:bg-rojo group-hover:text-white group-hover:border-rojo <?= $esTemaGaming ? 'shadow-[0_0_18px_rgba(255,0,51,0.08)] group-hover:shadow-[0_0_28px_rgba(255,0,51,0.35)]' : '' ?>"><i class="<?= esc($sub['icono']) ?>"></i></div>
                <div class="text-white text-[1.1rem] font-bold mb-2"><?= esc($sub['nombre']) ?></div>
                <div class="text-white/[0.55] text-[0.87rem] leading-[1.6] flex-1 mb-3"><?= esc($sub['descripcion']) ?></div>
                <?php if (isset($sub['subrubros'])): ?>
                    <span class="inline-block text-[0.78rem] font-semibold text-white/35 mb-3"><i class="fas fa-folder-open mr-1"></i><?= count($sub['subrubros']) ?> subrubros</span>
                <?php elseif (isset($sub['productos'])): ?>
                    <span class="inline-block text-[0.78rem] font-semibold text-white/35 mb-3"><i class="fas fa-box mr-1"></i><?= count($sub['productos']) ?> productos</span>
                <?php endif; ?>
                <div class="flex items-center gap-[6px] text-rojo text-[0.85rem] font-semibold transition-[gap] duration-200 group-hover:gap-[10px]">Ver más <i class="fas fa-arrow-right"></i></div>
            </a>
            <?php endforeach; ?>

            <div class="hidden text-center py-12 px-4 col-span-full" id="sin-resultados-subrubros">
                <i class="fas fa-search text-[2.5rem] text-[#dee2e6] mb-4 block"></i>
                <p class="text-gris text-[0.95rem] m-0">No se encontraron categorías para <strong class="text-rojo" id="termino-subrubros"></strong></p>
            </div>
        </div>

    </div>
</section>

<script>
(function () {
    const input   = document.getElementById('buscador-subrubros');
    const clearBtn = document.getElementById('clear-subrubros');
    const grid    = document.getElementById('subrubros-grid');
    const noRes   = document.getElementById('sin-resultados-subrubros');
    const termSpan = document.getElementById('termino-subrubros');

    function filtrar() {
        const q = input.value.trim().toLowerCase();
        clearBtn.style.display = q ? 'block' : 'none';
        const cards = grid.querySelectorAll('.subrubro-card');
        let visible = 0;
        cards.forEach(function(card) {
            const match = !q || card.dataset.busqueda.includes(q);
            card.classList.toggle('hidden', !match);
            if (match) visible++;
        });
        noRes.style.display    = visible === 0 ? 'block' : 'none';
        termSpan.textContent   = '"' + input.value.trim() + '"';
    }

    input.addEventListener('input', filtrar);
    clearBtn.addEventListener('click', function() {
        input.value = '';
        filtrar();
        input.focus();
    });
})();
</script>
