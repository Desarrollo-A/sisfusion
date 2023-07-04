<div class="text-center">
    <h3>ESTO ES UNA PRUEBA PARA EL MÓDULO DE CONTRALORÍA EN VISTA "Registro estatus 2 (integración de expediente)</h3>
</div>

<div>
    <?php
    $this->load->view('template/mail/componentes/tabla', [
        'encabezados' => $encabezados,
        'contenido' => $contenido
    ])
    ?>
</div>