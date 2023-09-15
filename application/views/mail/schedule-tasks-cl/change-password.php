<div class="text-center">
    <h3>A continuación se muestra usuario, nueva contraseña y tiempo de validez del usuario comodín.</h3>
</div>

<div>
    <?php
    $this->load->view('template/mail/componentes/tabla', [
        'encabezados' => $encabezados,
        'contenido' => $contenido
    ])
    ?>
</div>