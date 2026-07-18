<?= $this->extend('componentes/base') ?>

<?= $this->section('contenido') ?>

<!-- ═══════════════════════════════════════════════════════════
     CONDICIONES DEL SERVICIO
═══════════════════════════════════════════════════════════ -->
<section class="bg-white pt-14 pb-8 sm:pt-20 border-b border-[#EEF0F3]">
    <div class="container">
        <div class="max-w-[760px]">
            <span class="section-eyebrow">Centro Informático Regional</span>
            <h1 class="section-heading mb-3">Condiciones del Servicio</h1>
            <p class="font-inter text-[0.95rem] text-gray-500 leading-[1.8] mb-0">
                Última actualización: <?= date('d/m/Y') ?>. Al utilizar este sitio, aceptás las condiciones
                descritas a continuación.
            </p>
        </div>
    </div>
</section>

<section class="bg-white py-12 sm:py-16">
    <div class="container">
        <div class="max-w-[760px] flex flex-col gap-10 font-inter text-[0.95rem] leading-[1.85] text-gray-600">

            <div>
                <h2 class="text-[1.25rem] font-bold text-slate-900 mb-3">1. Uso del sitio web</h2>
                <p class="mb-0">
                    Este sitio tiene como finalidad brindar información sobre los productos y servicios de
                    Centro Informático Regional. El uso del sitio implica la aceptación de estas condiciones.
                    No está permitido utilizar el sitio con fines ilícitos o que puedan dañar, inutilizar o
                    sobrecargar su funcionamiento.
                </p>
            </div>

            <div>
                <h2 class="text-[1.25rem] font-bold text-slate-900 mb-3">2. Carácter informativo del catálogo</h2>
                <p class="mb-0">
                    El catálogo publicado en el sitio tiene carácter informativo. Las imágenes, descripciones y
                    características de los productos se muestran a modo orientativo y pueden no reflejar con
                    exactitud el producto final.
                </p>
            </div>

            <div>
                <h2 class="text-[1.25rem] font-bold text-slate-900 mb-3">3. Precios, stock y disponibilidad</h2>
                <p class="mb-0">
                    Los precios, el stock y la disponibilidad de los productos exhibidos pueden variar sin previo
                    aviso según condiciones del mercado y de nuestros proveedores. Recomendamos confirmar precio y
                    disponibilidad antes de dirigirte a nuestro local o de tomar una decisión de compra.
                </p>
            </div>

            <div>
                <h2 class="text-[1.25rem] font-bold text-slate-900 mb-3">4. Consultas y medios de contacto</h2>
                <p class="mb-0">
                    Las consultas sobre productos, precios, stock o servicio técnico pueden realizarse a través de
                    WhatsApp, el formulario de contacto del sitio o de forma presencial en nuestro local. La
                    información brindada por estos medios prevalece sobre la publicada en el catálogo web.
                </p>
            </div>

            <div>
                <h2 class="text-[1.25rem] font-bold text-slate-900 mb-3">5. Responsabilidades del usuario</h2>
                <p class="mb-0">
                    El usuario es responsable de proporcionar datos de contacto verídicos al realizar consultas o
                    solicitudes de servicio técnico, y de hacer un uso adecuado del sitio y de los medios de
                    contacto disponibles.
                </p>
            </div>

            <div>
                <h2 class="text-[1.25rem] font-bold text-slate-900 mb-3">6. Modificaciones de las condiciones</h2>
                <p class="mb-0">
                    Centro Informático Regional podrá modificar estas condiciones en cualquier momento para
                    reflejar cambios en sus servicios o en la normativa vigente. Las modificaciones entrarán en
                    vigencia desde su publicación en esta misma página.
                </p>
            </div>

            <div>
                <h2 class="text-[1.25rem] font-bold text-slate-900 mb-3">7. Contacto</h2>
                <p class="mb-0">
                    Ante cualquier consulta sobre estas Condiciones del Servicio, podés contactarnos en Calle
                    Sarmiento 177, El Colorado, Formosa, por teléfono al (+54) 370 461-6482, o por WhatsApp desde
                    el botón disponible en el sitio.
                </p>
            </div>

        </div>
    </div>
</section>

<?= $this->endSection() ?>
