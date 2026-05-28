<style>
    .subrubros-section { background: var(--fondo); }
    /* ── Tema Gaming ── */
    .subrubros-section.tema-gaming { background: #070710; }
    .tema-gaming .subrubro-card {
        background: #0d0d1c;
        border: 1px solid rgba(255,0,51,0.06);
    }
    .tema-gaming .subrubro-card:hover {
        box-shadow: 0 22px 55px rgba(255,0,51,0.12), 0 0 0 1px rgba(255,0,51,0.12);
        border-bottom-color: var(--rojo);
    }
    .tema-gaming .subrubro-icon {
        box-shadow: 0 0 18px rgba(255,0,51,0.08);
    }
    .tema-gaming .subrubro-card:hover .subrubro-icon {
        box-shadow: 0 0 28px rgba(255,0,51,0.35);
    }
    .tema-gaming .section-heading { color: #fff; }
    .tema-gaming .cat-buscador { background: #0d0d1c; border-color: rgba(255,255,255,0.12); color: #fff; }
    .tema-gaming .cat-buscador::placeholder { color: rgba(255,255,255,0.3); }
    .tema-gaming .cat-buscador:focus { border-color: var(--rojo); }
    .subrubros-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.4rem;
    }
    .subrubro-card {
        background: var(--dark-2);
        border-radius: 18px;
        padding: 2rem 1.8rem;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-bottom: 3px solid transparent;
    }
    .subrubro-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 22px 55px rgba(0,0,0,0.22);
        border-bottom-color: var(--rojo);
    }
    .subrubro-card.oculto { display: none; }
    .subrubro-icon {
        width: 58px; height: 58px;
        border-radius: 14px;
        background: rgba(255,0,51,0.1);
        border: 1.5px solid rgba(255,0,51,0.28);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: var(--rojo);
        margin-bottom: 1.1rem;
        transition: background 0.25s, color 0.25s, border-color 0.25s;
    }
    .subrubro-card:hover .subrubro-icon { background: var(--rojo); color: #fff; border-color: var(--rojo); }
    .subrubro-name { color: #fff; font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; }
    .subrubro-desc-text {
        color: rgba(255,255,255,0.55);
        font-size: 0.87rem;
        line-height: 1.6;
        flex: 1;
        margin-bottom: 0.75rem;
    }
    .subrubro-count {
        display: inline-block;
        font-size: 0.78rem;
        font-weight: 600;
        color: rgba(255,255,255,0.35);
        margin-bottom: 0.75rem;
    }
    .subrubro-link {
        color: var(--rojo);
        font-size: 0.85rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: gap 0.2s;
    }
    .subrubro-card:hover .subrubro-link { gap: 10px; }

    /* ── Buscador ── */
    .cat-buscador-wrap {
        position: relative;
        max-width: 520px;
        margin: 0 auto 2.4rem;
    }
    .cat-buscador-wrap .cat-search-icon {
        position: absolute;
        left: 1.1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gris);
        font-size: 0.95rem;
        pointer-events: none;
    }
    .cat-buscador {
        width: 100%;
        padding: 0.75rem 3rem 0.75rem 2.85rem;
        border: 2px solid #e5e7eb;
        border-radius: 50px;
        font-size: 0.93rem;
        color: var(--dark);
        background: #fff;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .cat-buscador:focus {
        border-color: var(--rojo);
        box-shadow: 0 0 0 3px rgba(255,0,51,0.1);
    }
    .cat-buscador::placeholder { color: #adb5bd; }
    .cat-clear-btn {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #adb5bd;
        cursor: pointer;
        font-size: 0.85rem;
        padding: 4px;
        line-height: 1;
        display: none;
    }
    .cat-clear-btn:hover { color: var(--rojo); }
    .cat-sin-resultados {
        display: none;
        text-align: center;
        padding: 3rem 1rem;
        grid-column: 1 / -1;
    }
    .cat-sin-resultados i { font-size: 2.5rem; color: #dee2e6; margin-bottom: 1rem; display: block; }
    .cat-sin-resultados p { color: var(--gris); font-size: 0.95rem; margin: 0; }
    .cat-sin-resultados strong { color: var(--rojo); }

    @media (max-width: 991px) { .subrubros-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 575px)  { .subrubros-grid { grid-template-columns: 1fr; } }
</style>

<!-- ═══════════════════════════════════════════════
     SUBRUBROS GRID
═══════════════════════════════════════════════ -->
<section class="subrubros-section py-5<?= isset($current['tema']) ? ' tema-' . esc($current['tema']) : '' ?>">
    <div class="container">

        <div class="text-center mb-2">
            <span class="section-eyebrow">Explorá la categoría</span>
            <h2 class="section-heading"><?= esc($current['nombre']) ?></h2>
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

        <div class="cat-buscador-wrap" style="margin-top:1.5rem;">
            <i class="fas fa-search cat-search-icon"></i>
            <input type="text"
                   id="buscador-subrubros"
                   class="cat-buscador"
                   placeholder="Buscar en <?= esc($current['nombre']) ?>...">
            <button type="button" class="cat-clear-btn" id="clear-subrubros" title="Limpiar búsqueda">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="subrubros-grid" id="subrubros-grid">
            <?php foreach ($current['subrubros'] as $key => $sub): ?>
            <a href="<?= base_url($currentPath . '/' . $key) ?>"
               class="subrubro-card"
               data-busqueda="<?= esc(strtolower($sub['nombre'] . ' ' . $sub['descripcion'])) ?>">
                <div class="subrubro-icon"><i class="<?= esc($sub['icono']) ?>"></i></div>
                <div class="subrubro-name"><?= esc($sub['nombre']) ?></div>
                <div class="subrubro-desc-text"><?= esc($sub['descripcion']) ?></div>
                <?php if (isset($sub['subrubros'])): ?>
                    <span class="subrubro-count"><i class="fas fa-folder-open" style="margin-right:4px;"></i><?= count($sub['subrubros']) ?> subrubros</span>
                <?php elseif (isset($sub['productos'])): ?>
                    <span class="subrubro-count"><i class="fas fa-box" style="margin-right:4px;"></i><?= count($sub['productos']) ?> productos</span>
                <?php endif; ?>
                <div class="subrubro-link">Ver más <i class="fas fa-arrow-right"></i></div>
            </a>
            <?php endforeach; ?>

            <div class="cat-sin-resultados" id="sin-resultados-subrubros">
                <i class="fas fa-search"></i>
                <p>No se encontraron categorías para <strong id="termino-subrubros"></strong></p>
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
            card.classList.toggle('oculto', !match);
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
