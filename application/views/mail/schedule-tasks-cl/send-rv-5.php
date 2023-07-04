<div class="text-center">
    <h3>Acumulado de lotes sin integrar Expediente</h3>
</div>

<div>
    <?php
    $this->load->view('template/mail/componentes/tabla', [
        'encabezados' => $encabezados,
        'contenido' => $contenido
    ])
    ?>
</div>