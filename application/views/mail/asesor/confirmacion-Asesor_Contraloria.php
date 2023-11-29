<div class="text-center">
    <h3>Se ha validado el traslado del expediente desde la posición de Asesor, categoría 2, a la categoría de Contraloría, nivel 5.</h3>
    <p>En seguida se podrá visualizar la información del registro.</p>
    <p>Comentario: <?=$comentario?></p> 
</div>

<div>
    <?php
    $this->load->view('template/mail/componentes/tabla', [
        'encabezados' => $encabezados,
        'contenido' => $contenido
    ])
    ?>
</div>  