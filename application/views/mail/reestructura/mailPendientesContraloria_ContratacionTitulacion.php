<div class="text-center">
    <h3>A continuación, presentamos un listado de los expedientes que presentan retrasos en el envío a la siguiente etapa.</h3>
</div>

<div>
    <?php
    $this->load->view('template/mail/componentes/tabla', [
        'encabezados' => $encabezados,
        'contenido' => $contenido
    ])
    ?>
</div>