<?= $this->extend('componentes/base') ?>

<?= $this->section('contenido') ?>

<!-- ═══════════════════════════════════════════════════════════
     POLÍTICA DE PRIVACIDAD
═══════════════════════════════════════════════════════════ -->
<section class="bg-white pt-14 pb-8 sm:pt-20 border-b border-[#EEF0F3]">
    <div class="container">
        <div class="max-w-[760px]">
            <span class="section-eyebrow">Centro Informático Regional</span>
            <h1 class="section-heading mb-3">Política de Privacidad</h1>
            <p class="font-inter text-[0.95rem] text-gray-500 leading-[1.8] mb-0">
                Última actualización: <?= date('d/m/Y') ?>. En Centro Informático Regional valoramos tu
                privacidad. Esta política explica qué información podemos recopilar y cómo la utilizamos.
            </p>
        </div>
    </div>
</section>

<section class="bg-white py-12 sm:py-16">
    <div class="container">
        <div class="max-w-[760px] flex flex-col gap-10 font-inter text-[0.95rem] leading-[1.85] text-gray-600">

            <div>
                <h2 class="text-[1.25rem] font-bold text-slate-900 mb-3">1. Información que recopilamos</h2>
                <p class="mb-0">
                    Podemos recopilar información que nos proporcionás voluntariamente al utilizar nuestro sitio,
                    como nombre, teléfono, correo electrónico y el detalle de tu consulta, cuando completás un
                    formulario de contacto, solicitás un servicio técnico o nos escribís por WhatsApp. No
                    recopilamos datos sensibles ni información de pago a través del sitio.
                </p>
            </div>

            <div>
                <h2 class="text-[1.25rem] font-bold text-slate-900 mb-3">2. Uso de los datos de contacto</h2>
                <p class="mb-0">
                    Los datos que nos brindás a través de formularios de contacto, consultas de servicio técnico
                    o WhatsApp se utilizan exclusivamente para responder tu consulta, brindarte asesoramiento
                    sobre nuestros productos y servicios, y coordinar la atención solicitada. No vendemos ni
                    compartimos tus datos con terceros ajenos a la operación de la empresa.
                </p>
            </div>

            <div>
                <h2 class="text-[1.25rem] font-bold text-slate-900 mb-3">3. Consultas por WhatsApp y formularios</h2>
                <p class="mb-0">
                    Al iniciar una conversación por WhatsApp o enviar un formulario del sitio, aceptás que
                    utilicemos esa información de contacto para responderte por el mismo medio u otro que
                    indiques, con el único fin de atender tu consulta.
                </p>
            </div>

            <div>
                <h2 class="text-[1.25rem] font-bold text-slate-900 mb-3">4. Uso de cookies</h2>
                <p class="mb-0">
                    El sitio puede utilizar cookies técnicas propias de su funcionamiento (por ejemplo, para
                    mantener tu sesión iniciada en el panel administrativo). No utilizamos cookies de
                    seguimiento publicitario de terceros.
                </p>
            </div>

            <div>
                <h2 class="text-[1.25rem] font-bold text-slate-900 mb-3">5. Protección de datos</h2>
                <p class="mb-0">
                    Adoptamos medidas razonables para proteger la información que nos proporcionás de accesos no
                    autorizados, pérdida o alteración. El acceso a los datos de consultas y contacto está
                    restringido al personal autorizado de Centro Informático Regional.
                </p>
            </div>

            <div>
                <h2 class="text-[1.25rem] font-bold text-slate-900 mb-3">6. Contacto</h2>
                <p class="mb-0">
                    Ante cualquier duda sobre esta Política de Privacidad, podés contactarnos en Calle Sarmiento
                    177, El Colorado, Formosa, por teléfono al (+54) 370 461-6482, o por WhatsApp desde el botón
                    disponible en el sitio.
                </p>
            </div>

        </div>
    </div>
</section>

<?= $this->endSection() ?>
