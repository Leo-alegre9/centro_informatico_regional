<style>
    .nosotros-quienes { background: #fff; }
    .nosotros-historia-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--rojo);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }
    .nosotros-historia-title {
        font-size: clamp(1.7rem, 2.8vw, 2.4rem);
        font-weight: 900;
        color: var(--dark-2);
        line-height: 1.2;
        margin-bottom: 1.5rem;
    }
    .nosotros-historia-title em {
        font-style: normal;
        color: var(--rojo);
    }
    .nosotros-historia-text {
        color: var(--gris);
        font-size: 0.97rem;
        line-height: 1.9;
        margin-bottom: 1.1rem;
    }
    .nosotros-historia-text:last-child { margin-bottom: 0; }
    .nosotros-highlight {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        background: var(--fondo);
        border-left: 4px solid var(--rojo);
        border-radius: 0 12px 12px 0;
        padding: 1.2rem 1.4rem;
        margin-top: 1.8rem;
    }
    .nosotros-highlight i { color: var(--rojo); font-size: 1.1rem; margin-top: 2px; flex-shrink: 0; }
    .nosotros-highlight p { color: var(--dark-2); font-size: 0.92rem; line-height: 1.7; margin: 0; font-weight: 500; }

    /* Tarjetas laterales */
    .nosotros-cards-col { display: flex; flex-direction: column; gap: 1.2rem; }
    .nosotros-card {
        background: var(--dark-2);
        border-radius: 18px;
        padding: 1.6rem 1.7rem;
        display: flex;
        align-items: flex-start;
        gap: 1.1rem;
        border: 1.5px solid rgba(255,255,255,0.05);
    }
    .nosotros-card-icon {
        width: 50px; height: 50px;
        flex-shrink: 0;
        border-radius: 13px;
        background: rgba(255,0,51,0.1);
        border: 1.5px solid rgba(255,0,51,0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: var(--rojo);
    }
    .nosotros-card-title { color: #fff; font-size: 0.96rem; font-weight: 700; margin-bottom: 0.3rem; }
    .nosotros-card-text { color: rgba(255,255,255,0.5); font-size: 0.84rem; line-height: 1.6; margin: 0; }
    .nosotros-divider {
        width: 50px; height: 4px;
        background: var(--rojo);
        border-radius: 2px;
        margin-bottom: 1.8rem;
    }
</style>

<!-- ═══════════════════════════════════════════════
     NOSOTROS — QUIÉNES SOMOS
═══════════════════════════════════════════════ -->
<section class="nosotros-quienes py-5">
    <div class="container">
        <div class="row g-5 align-items-start">

            <div class="col-lg-7">
                <div class="nosotros-historia-label">
                    <i class="fas fa-building"></i> Nuestra Historia
                </div>
                <h2 class="nosotros-historia-title">
                    Una empresa formoseña<br>con <em>vocación de servicio</em>
                </h2>
                <div class="nosotros-divider"></div>

                <p class="nosotros-historia-text">
                    Somos una empresa formoseña fundada en el año <strong>1997</strong>, que surge como un emprendimiento dedicado a brindar servicios de capacitación en informática. A lo largo de los años hemos logrado un crecimiento y evolución constante para adaptarnos a las demandas cambiantes del mercado.
                </p>
                <p class="nosotros-historia-text">
                    Hoy contamos con una <strong>presencia regional sólida en la provincia de Formosa y parte del interior del Chaco</strong>. Nuestro compromiso con la excelencia y la calidad nos ha permitido forjar relaciones duraderas tanto con los clientes como con las marcas que representamos.
                </p>
                <p class="nosotros-historia-text">
                    Trabajamos en estrecha colaboración con <strong>más de 50 marcas de renombre internacional</strong>. Nuestro portafolio abarca desde tecnología de vanguardia hasta productos de consumo cotidiano, muebles de oficina y hogar, toda la línea comercial en amoblamientos y la línea de frío y calor.
                </p>

                <div class="nosotros-highlight">
                    <i class="fas fa-quote-left"></i>
                    <p>Con amplia trayectoria en el rubro, ágiles y eficaces, asumimos la gran responsabilidad de cumplir fielmente con cada uno de nuestros clientes, porque nos eligieron y nos otorgaron esa posibilidad.</p>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="nosotros-cards-col">

                    <div class="nosotros-card">
                        <div class="nosotros-card-icon"><i class="fas fa-seedling"></i></div>
                        <div>
                            <div class="nosotros-card-title">Origen emprendedor</div>
                            <p class="nosotros-card-text">Nacimos en 1997 como un servicio de capacitación en informática y evolucionamos hasta convertirnos en una empresa multirubro de alcance regional.</p>
                        </div>
                    </div>

                    <div class="nosotros-card">
                        <div class="nosotros-card-icon"><i class="fas fa-chart-line"></i></div>
                        <div>
                            <div class="nosotros-card-title">Crecimiento constante</div>
                            <p class="nosotros-card-text">Más de 28 años de evolución continua, adaptándonos a cada cambio del mercado y ampliando nuestra oferta para cubrir todas las necesidades de nuestra región.</p>
                        </div>
                    </div>

                    <div class="nosotros-card">
                        <div class="nosotros-card-icon"><i class="fas fa-handshake"></i></div>
                        <div>
                            <div class="nosotros-card-title">Relaciones duraderas</div>
                            <p class="nosotros-card-text">Construimos vínculos sólidos con clientes y marcas basados en la confianza, el cumplimiento y el acompañamiento permanente en cada etapa.</p>
                        </div>
                    </div>

                    <div class="nosotros-card">
                        <div class="nosotros-card-icon"><i class="fas fa-boxes-stacked"></i></div>
                        <div>
                            <div class="nosotros-card-title">Portafolio diversificado</div>
                            <p class="nosotros-card-text">Tecnología, muebles, electrodomésticos y equipamiento comercial: más de 50 marcas internacionales bajo un mismo techo.</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
