<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-expand fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Historial Estatus 3 </h3>
                                <p class="card-title pl-1">(Ventas particulares)</p>
                            </div>
                            <div  class="toolbar">
                                <div class="row">
                                </div>
                            </div>
                            <div class="material-datatables">
                                <table  id="tabla_historial" name="tabla_historial" class="table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>PROYECTO</th>
                                        <th>CONDOMINIO</th>
                                        <th>LOTE</th>
                                        <th>CLIENTE</th>
                                        <th>FECHA SOLICITUD (avance de expediente)</th>
                                        <th>FECHA EXPEDIENTE</th>
                                        <th>COMENTARIO</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('template/footer_legend');?>
</div>

</body>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/controllers/postventa/historial_estatus3.js"></script>


