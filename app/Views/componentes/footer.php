<style>
    /* ══════════════════════════════════════════════════════════
       FOOTER — Minimal Premium 2026
       Inspiración: Apple · Shopify · Stripe
    ══════════════════════════════════════════════════════════ */
    .site-footer {
        background: #111827;
        border-top: 1px solid rgba(255,255,255,0.07);
        padding: 5rem 0 0;
        font-family: 'Inter', system-ui, sans-serif;
    }

    /* ── Bloque central ── */
    .footer-main {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 0;
    }

    /* ── Brand ── */
    .footer-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        margin-bottom: 1.25rem;
        transition: opacity 0.2s;
    }
    .footer-brand:hover { opacity: 0.8; }
    .footer-brand-logo {
        height: 44px;
        width: auto;
        object-fit: contain;
    }
    .footer-brand-text {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        line-height: 1.1;
        gap: 1px;
    }
    .footer-brand-main {
        font-size: 0.92rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: 0.03em;
        text-transform: uppercase;
    }
    .footer-brand-sub {
        font-size: 0.57rem;
        font-weight: 700;
        color: #FF0033;
        letter-spacing: 0.28em;
        text-transform: uppercase;
    }

    /* ── Descripción ── */
    .footer-desc {
        font-size: 0.92rem;
        color: rgba(255,255,255,0.45);
        line-height: 1.75;
        max-width: 420px;
        margin: 0 0 2.25rem;
    }

    /* ── Iconos sociales ── */
    .footer-socials {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 2.25rem;
    }
    .footer-soc-btn {
        width: 42px; height: 42px;
        border-radius: 50%;
        background: rgba(255,255,255,0.07);
        border: 1.5px solid rgba(255,255,255,0.1);
        display: flex; align-items: center; justify-content: center;
        color: rgba(255,255,255,0.55) !important;
        font-size: 0.95rem;
        text-decoration: none;
        transition: border-color 0.2s, color 0.2s, transform 0.2s, background 0.2s;
    }
    .footer-soc-btn:hover {
        transform: translateY(-3px);
        color: #fff !important;
    }
    .footer-soc-btn.soc-ig:hover { background: rgba(225,48,108,0.15); border-color: rgba(225,48,108,0.4); }
    .footer-soc-btn.soc-fb:hover { background: rgba(24,119,242,0.15);  border-color: rgba(24,119,242,0.4); }
    .footer-soc-btn.soc-wa:hover { background: rgba(37,211,102,0.15);  border-color: rgba(37,211,102,0.4); }

    .footer-socials { margin-bottom: 5rem; }

    /* ── Barra de copyright ── */
    .footer-bottom {
        border-top: 1px solid rgba(255,255,255,0.07);
        padding: 1.4rem 0;
    }
    .footer-copyright {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 0.76rem;
        color: rgba(255,255,255,0.28);
        text-align: center;
        margin: 0;
    }

    /* ── Responsive ── */
    @media (max-width: 575px) {
        .site-footer       { padding: 3.5rem 0 0; }
        .footer-desc       { font-size: 0.88rem; }
        .footer-socials    { margin-bottom: 3.5rem; }
        .footer-brand-logo { height: 38px; }
    }
</style>

<!-- ═══════════════════════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════════════════════ -->
<footer class="site-footer" role="contentinfo">
    <div class="container">
        <div class="footer-main">

            <!-- Logo + nombre -->
            <a href="<?= base_url('/') ?>" class="footer-brand" aria-label="Inicio">
                <img src="<?= base_url('assets/img/logo_sinfondo.png') ?>"
                     alt="Centro Informático Regional"
                     class="footer-brand-logo">
                <div class="footer-brand-text">
                    <span class="footer-brand-main">Centro Informático</span>
                    <span class="footer-brand-sub">Regional</span>
                </div>
            </a>

            <!-- Descripción -->
            <p class="footer-desc">
                Soluciones en informática, muebles, electrodomésticos y equipamiento
                comercial para hogares, oficinas y empresas.
            </p>

            <!-- Redes sociales -->
            <div class="footer-socials" aria-label="Redes sociales">
                <a href="https://www.instagram.com/centro_informatico_regional"
                   target="_blank" rel="noopener noreferrer"
                   class="footer-soc-btn soc-ig" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.facebook.com/profile.php?id=61578451747153"
                   target="_blank" rel="noopener noreferrer"
                   class="footer-soc-btn soc-fb" aria-label="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://wa.me/5493704616482"
                   target="_blank" rel="noopener noreferrer"
                   class="footer-soc-btn soc-wa" aria-label="WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>

        </div>
    </div>

    <!-- Copyright -->
    <div class="footer-bottom">
        <div class="container">
            <p class="footer-copyright">
                &copy; <?= date('Y') ?> Centro Informático Regional. Todos los derechos reservados.
            </p>
        </div>
    </div>

</footer>
