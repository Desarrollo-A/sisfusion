<div class="text-center">
    <h3>PRUEBA PARA SOLICITUD DE CONTRATACIÓN</h3>
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