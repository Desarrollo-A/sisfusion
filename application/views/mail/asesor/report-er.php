<style>
    p {
        padding: 10px 90px;
    }
</style>

<div class="text-center">
    <h1>SISTEMA DE CONTRATACIÓN</h1>
</div>

<div>
    <h3>¡ Buenos días estimad@ !</h3>

    <p class="text-justify">¿Cómo estás?, espero que bien, te adjunto el reporte semanal de las evidencias rechazadas por
        <b>cobranza/contraloria</b>, te invito a leer las observaciones. Recuerda que deben ser corregidas a más
        tardar los jueves a las 12:00 PM, con esto ayudas a que el proceso en cobranza sea en tiempo y forma,
        dando como resultado el cobro a tiempo de las comisiones.
    </p>
</div>

<div>
    <?php
    $this->load->view('template/mail/componentes/tabla', [
        'encabezados' => $encabezados,
        'contenido' => $contenido
    ])
    ?>
</div>