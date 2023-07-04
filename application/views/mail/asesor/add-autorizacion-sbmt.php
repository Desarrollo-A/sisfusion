<div class="text-center">
    <h1>SOLICITUD DE AUTORIZACION</h1>

    <p><?=$comentario?></p>
</div>

<div>
    <?php
    $this->load->view('template/mail/componentes/tabla', [
        'encabezados' => $encabezados,
        'contenido' => $contenido
    ])
    ?>
</div>