<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
<div class="wrapper">
    <?php
    if($this->session->userdata('id_rol')=="49" ){
        $this->load->view('template/sidebar');
    }else{
        echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
    }
    ?>
    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-wallet fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title">Reporte devoluciones</h3>
                            </div>
                            <div class="toolbar">
                                <div class="row">
                                    <div class="col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <label for="proyecto">PUESTO</label>
                                            <select name="filtro33" id="filtro33" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" required>
                                                <option value="3">GERENTE</option>
                                                <option value="9">COORDINADOR DE VENTAS</option> 
                                                <option value="7">ASESOR</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <table class="table-striped table-hover " id="tabla_historialGral" name="tabla_historialGral">
                                        <thead>
                                            <tr>
                                                <th>ID DE PAGO</th>
                                                <th>LOTE</th>
                                                <th>EMPRESA</th>
                                                <th>USUARIO</th>
                                                <th>ID DE USUARIO</th>
                                                <th>FECHA DE PAGO</th>
                                                <th>PUESTO</th>
                                                <th>ABONO </th>
                                                <th>SEDE</th>
                                                <th>MOTIVO</th>
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
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/controllers/comisiones/reporteDevolucion.js"></script>
</body>