<div class="text-center">
    <h3>Lotes Bloqueados al: <?= date("Y-m-d H:i:s"); ?></h3>
</div>

<div>
    <?php
    $this->load->view('template/mail/componentes/tabla', [
        'encabezados' => $encabezados,
        'contenido' => $contenido
    ])
    ?>
</div>