<div class="text-center">
    <h3>Solicitud asesor</h3>
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