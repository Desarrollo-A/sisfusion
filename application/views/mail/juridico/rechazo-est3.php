<div class="text-center">
    <h3>Se ha rechazado el registro en estatus 7 (Asesor).</h3>
    <p>En seguida se podrá visualizar la información del registro junto con los comentarios realizados.</p>
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