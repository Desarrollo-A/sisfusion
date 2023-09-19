<style>
    p {
        padding: 10px 90px;
    }
</style>

<div class="text-center">
    <h1>CRM</h1>
</div>

<div>
    <h3>Notificación de liberación de lotes</h3>
</div>

<div>
    <?php
    $this->load->view('template/mail/componentes/tabla', [
        'encabezados' => $encabezados,
        'contenido' => $contenido
    ])
    ?>
</div>