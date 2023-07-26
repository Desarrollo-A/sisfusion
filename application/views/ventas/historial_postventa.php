<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
<div class="wrapper ">
    <?php
    if (in_array($this->session->userdata('id_rol'), array('33', '17', '74', '75', '76', '77', '78', '79', '80', '81', '82', '83'))) {
        $this->load->view('template/sidebar');
    } else {
        echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
    }
    ?>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-user-circle fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Comisiones - Pagado por lote</h3>
                            <div class="toolbar">
                                <div class="row">
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <table id="tabla_ingresar_9" name="tabla_ingresar_9"
                                            class="table-striped table-hover" style="text-align:center;">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>ID LOTE</th>
                                                <th>COMISIONISTA</th>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>REFERENCIA</th>
                                                <th>PRECIO DEL LOTE</th>
                                                <th>TOTAL DE LA COMISIÓN</th>
                                                <th>ABONADO</th>
                                                <th>PAGADO</th>
                                                <th>CLIENTE</th>
                                                <th>ESTATUS</th>
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
    </div>
    <?php $this->load->view('template/footer_legend'); ?>
</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer'); ?>

<script src="<?= base_url() ?>dist/js/controllers/comisiones/historial_postventa.js"></script>


