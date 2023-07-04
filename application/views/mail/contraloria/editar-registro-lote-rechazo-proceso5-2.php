<div class="text-center">
    <h3>Se le informa que el estatus del lote mencionado a continuación, ha cambiado a un estatus de tipo "RECHAZADO", enseguida puede encontrar los comentarios y la información del lote afectado.</h3>
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