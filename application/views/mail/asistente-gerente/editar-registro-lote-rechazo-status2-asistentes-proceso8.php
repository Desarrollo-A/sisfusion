<div>
    <p>Se ha rechazado el registro en estatus 8 (Contrato entregado al asesor para firma del cliente).</p>
    <p>En seguida se podrá visualizar la información del registro junto con los comentarios realizados.</p>
</div>

<div>
    <?php
    $this->load->view('template/mail/componentes/tabla', [
        'encabezados' => $encabezados,
        'contenido' => $contenido
    ])
    ?>
</div>