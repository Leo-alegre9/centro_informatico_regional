<?php
/**
 * Mega Nav Panel — navegación por categorías con drill-down.
 *
 * Variables:
 *   $megaMenuData  array   Output de CategoriaModel::getMegaMenu()
 *   $mnpTema       string  'dark' (default) | 'light'
 */
$mnpTema = $mnpTema ?? 'dark';
$isDark  = ($mnpTema !== 'light');
$mnpId   = 'mnp-' . substr(md5(uniqid('', true)), 0, 8);

if (empty($megaMenuData)) return;

/* Clases Tailwind condicionadas al tema (dark/light) — el scoping por ID
   ya no hace falta para el CSS (son utilidades), $mnpId se conserva solo
   como hook de JS para poder tener varias instancias en la misma página. */
$borderCol      = $isDark ? 'border-white/[0.07]' : 'border-[#e9ecef]';
$chipBase       = $isDark
    ? 'border-white/[0.12] bg-white/[0.04] text-white/55'
    : 'border-[#dee2e6] bg-[#f8f9fa] text-gris';
$chipHover      = $isDark
    ? 'hover:text-white hover:bg-white/[0.09] hover:border-white/[0.22]'
    : 'hover:text-dark hover:bg-[#f1f3f5] hover:border-[#adb5bd]';
$titleColor     = $isDark ? 'text-white' : 'text-dark';
$subHeaderColor = $isDark ? 'text-white/85' : 'text-dark';
$subsubColor    = $isDark ? 'text-white/[0.42]' : 'text-gris';
$accHdrColor    = $isDark ? 'text-white/80' : 'text-[#374151]';
$accLinkBase    = $isDark
    ? 'text-white/55 border-white/[0.07] bg-white/[0.02]'
    : 'text-gris border-[#e9ecef] bg-black/[0.02]';
?>

<div id="<?= $mnpId ?>" class="rounded-2xl overflow-hidden max-w-[1200px] mx-auto <?= $isDark ? 'bg-dark' : 'bg-white border-[1.5px] border-[#e9ecef]' ?>">

    <!-- ── Fila de chips (desktop) ── -->
    <div class="mnp-chips-row hidden md:flex flex-wrap justify-center items-center gap-2 px-5 py-4 border-b <?= $borderCol ?>">
        <?php foreach ($megaMenuData as $rubro): ?>
        <button type="button"
                class="mnp-chip inline-flex items-center gap-[7px] px-[1.1rem] py-[0.45rem] rounded-full text-[0.84rem] font-semibold cursor-pointer border-[1.5px] whitespace-nowrap select-none transition-colors duration-[180ms] <?= $chipBase ?> <?= $chipHover ?>"
                data-pane="<?= $mnpId ?>-pane-<?= (int) $rubro['id'] ?>">
            <i class="<?= esc($rubro['icono']) ?>"></i>
            <?= esc($rubro['nombre']) ?>
            <i class="fas fa-chevron-down mnp-arrow text-[0.65rem] transition-transform duration-200 opacity-70"></i>
        </button>
        <?php endforeach; ?>
    </div>

    <!-- ── Panel de contenido (desktop) — oculto por defecto ── -->
    <div class="mnp-panel hidden pt-[1.4rem] px-5 pb-6" id="<?= $mnpId ?>-panel">
        <?php foreach ($megaMenuData as $rubro): ?>
        <div id="<?= $mnpId ?>-pane-<?= (int) $rubro['id'] ?>" class="hidden">
            <div class="flex items-center justify-between pb-3 mb-4 border-b <?= $borderCol ?>">
                <span class="text-[0.9rem] font-bold flex items-center gap-[7px] <?= $titleColor ?>">
                    <i class="<?= esc($rubro['icono']) ?> text-rojo text-[0.82rem]"></i>
                    <?= esc($rubro['nombre']) ?>
                </span>
                <a href="<?= base_url('catalogo/' . esc($rubro['slug'])) ?>"
                   class="text-rojo text-[0.8rem] font-bold no-underline inline-flex items-center gap-[5px] transition-[gap] duration-[180ms] hover:gap-[9px]">
                    Ver todo <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <?php if (!empty($rubro['hijos'])): ?>
            <div class="grid gap-x-6 gap-y-5 grid-cols-[repeat(auto-fill,minmax(150px,1fr))]">
                <?php foreach ($rubro['hijos'] as $sub): ?>
                <div>
                    <a href="<?= base_url('catalogo/' . esc($rubro['slug']) . '/' . esc($sub['slug'])) ?>"
                       class="flex items-center gap-[6px] mb-[0.35rem] text-[0.84rem] font-bold no-underline transition-colors duration-150 <?= $subHeaderColor ?> hover:text-rojo">
                        <i class="<?= esc($sub['icono']) ?> text-[0.73rem] opacity-60 shrink-0"></i>
                        <?= esc($sub['nombre']) ?>
                    </a>
                    <?php foreach ($sub['hijos'] as $subsub): ?>
                    <a href="<?= base_url('catalogo/' . esc($rubro['slug']) . '/' . esc($sub['slug']) . '/' . esc($subsub['slug'])) ?>"
                       class="block text-[0.77rem] no-underline py-[2px] pl-[0.1rem] transition-colors duration-150 <?= $subsubColor ?> hover:text-rojo">
                        <?= esc($subsub['nombre']) ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <a href="<?= base_url('catalogo/' . esc($rubro['slug'])) ?>"
               class="text-rojo text-[0.8rem] font-bold no-underline inline-flex items-center gap-[5px] transition-[gap] duration-[180ms] hover:gap-[9px]">
                <i class="<?= esc($rubro['icono']) ?>"></i>
                Explorar <?= esc($rubro['nombre']) ?> <i class="fas fa-arrow-right"></i>
            </a>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- ── Acordeón (mobile) ── -->
    <div class="mnp-accordion block md:hidden">
        <?php foreach ($megaMenuData as $rubro): ?>
        <div class="mnp-acc-item border-b last:border-b-0 <?= $borderCol ?>">
            <div class="mnp-acc-hdr flex items-center justify-between px-4 py-[0.8rem] cursor-pointer text-[0.9rem] font-bold select-none transition-colors duration-150 <?= $accHdrColor ?> hover:text-rojo" role="button" tabindex="0">
                <span class="mnp-acc-left flex items-center gap-2">
                    <i class="<?= esc($rubro['icono']) ?>"></i>
                    <?= esc($rubro['nombre']) ?>
                </span>
                <i class="fas fa-chevron-down mnp-acc-arrow text-[0.68rem] transition-transform duration-[220ms] opacity-50"></i>
            </div>
            <div class="mnp-acc-body hidden pt-[0.4rem] px-4 pb-[0.9rem]">
                <?php if (!empty($rubro['hijos'])): ?>
                <div class="grid grid-cols-2 gap-[0.6rem] mb-[0.6rem]">
                    <?php foreach ($rubro['hijos'] as $sub): ?>
                    <a href="<?= base_url('catalogo/' . esc($rubro['slug']) . '/' . esc($sub['slug'])) ?>"
                       class="flex items-center gap-[6px] px-[0.6rem] py-[0.4rem] rounded-lg border text-[0.82rem] font-semibold no-underline transition-colors duration-150 <?= $accLinkBase ?> hover:text-rojo hover:border-[rgba(255,0,51,0.25)] hover:bg-[rgba(255,0,51,0.04)]">
                        <i class="<?= esc($sub['icono']) ?> text-[0.7rem] shrink-0"></i>
                        <?= esc($sub['nombre']) ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <a href="<?= base_url('catalogo/' . esc($rubro['slug'])) ?>"
                   class="text-rojo text-[0.79rem] font-bold no-underline flex justify-center items-center gap-[5px] transition-[gap] duration-[180ms] hover:gap-[9px] mt-1">
                    Ver todo en <?= esc($rubro['nombre']) ?> <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>

<script>
(function () {
    var wrap = document.getElementById('<?= $mnpId ?>');
    if (!wrap) return;

    var panel     = document.getElementById('<?= $mnpId ?>-panel');
    var chips     = wrap.querySelectorAll('.mnp-chip');
    var activeId  = null; // ID del pane activo

    var CHIP_ACTIVE_CLASSES = ['!bg-rojo', '!border-rojo', '!text-white'];
    var ARROW_ACTIVE_CLASSES = ['!rotate-180', '!opacity-100'];

    function setChipActive(chip, active) {
        var arrow = chip.querySelector('.mnp-arrow');
        if (active) {
            chip.classList.add.apply(chip.classList, CHIP_ACTIVE_CLASSES);
            if (arrow) arrow.classList.add.apply(arrow.classList, ARROW_ACTIVE_CLASSES);
        } else {
            chip.classList.remove.apply(chip.classList, CHIP_ACTIVE_CLASSES);
            if (arrow) arrow.classList.remove.apply(arrow.classList, ARROW_ACTIVE_CLASSES);
        }
    }

    /* ── Desktop: chip → mostrar/ocultar panel ── */
    chips.forEach(function (chip) {
        chip.addEventListener('click', function () {
            var paneId  = chip.dataset.pane;
            var same    = (activeId === paneId);

            /* Ocultar pane anterior */
            if (activeId) {
                var prev = document.getElementById(activeId);
                if (prev) prev.classList.add('hidden');
            }
            chips.forEach(function (c) { setChipActive(c, false); });

            if (same) {
                /* Mismo chip: cerrar todo */
                panel.classList.add('hidden');
                activeId = null;
            } else {
                /* Chip nuevo: mostrar pane */
                var pane = document.getElementById(paneId);
                if (pane) pane.classList.remove('hidden');
                panel.classList.remove('hidden');
                setChipActive(chip, true);
                activeId = paneId;
            }
        });
    });

    /* ── Mobile: acordeón ── */
    wrap.querySelectorAll('.mnp-acc-hdr').forEach(function (hdr) {
        function toggle() {
            var body   = hdr.nextElementSibling;
            var arrow  = hdr.querySelector('.mnp-acc-arrow');
            var isOpen = !body.classList.contains('hidden');
            wrap.querySelectorAll('.mnp-acc-body').forEach(function (b) { b.classList.add('hidden'); });
            wrap.querySelectorAll('.mnp-acc-arrow').forEach(function (a) { a.classList.remove('!rotate-180', '!opacity-100'); });
            if (!isOpen) {
                body.classList.remove('hidden');
                if (arrow) arrow.classList.add('!rotate-180', '!opacity-100');
            }
        }
        hdr.addEventListener('click', toggle);
        hdr.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); toggle(); }
        });
    });
})();
</script>
