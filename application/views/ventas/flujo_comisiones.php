<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Flujo comisiones</h3>
                                </div>
                                <div class="material-datatables">
                                    <div class="container-fluid encabezado-totales">
                                        <div class="row">
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4">
                                                <div class="row d-flex justify-center">
                                                    <div class="col-md-12">
                                                        <h4 class="text-center">TOTAL COMISIÓN</h4>
                                                        <p class="text-center"><i class="fa fa-usd" aria-hidden="true"></i></p>
                                                        <input class="styles-tot" disabled="disabled" readonly="readonly" type="text" id="total_comision" style="font-size:30px">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4">
                                                <div class="row d-flex justify-center">
                                                    <div class="col-md-12">
                                                        <h4 class="text-center">ABONADO</h4>
                                                        <p class="text-center"><i class="fa fa-usd" aria-hidden="true"></i></p>
                                                        <input class="styles-tot" disabled="disabled" readonly="readonly" type="text" id="total_abono" style="font-size:30px">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4">
                                                <div class="row d-flex justify-center">
                                                    <div class="col-md-12">
                                                        <h4 class="text-center">PENDIENTE</h4>
                                                        <p class="text-center"><i class="fa fa-usd" aria-hidden="true"></i></p>
                                                        <input class="styles-tot" disabled="disabled" readonly="readonly" type="text" id="total_pendiente" style="font-size:30px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla_flujo_comisiones" name="tabla_flujo_comisiones">
                                            <thead>
                                                <tr>
                                                    <th>ID LOTE</th>
                                                    <th>NOMBRE LOTE</th>
                                                    <th>ESTATUS CONTRATACIÓN</th>
                                                    <th>FECHA APARTADO</th>
                                                    <th>FECHA PRSPECTO</th>
                                                    <th>TOTAL COMISIONES</th>
                                                    <th>ABONO PAGADO</th>
                                                    <th>PENDIENTE</th>
                                                    <th>DISPERSIÓN</th>
                                                    <th>OBSERVACIONES</th>
                                                    <th>ESTATUS COMISIÓN</th>
                                                    <th>ESTATUS GENERAL</th>
                                                    <th>ESTATUS MKTD</th>
                                                    <th>ESTATUS EVIDENCIA</th>
                                                    <th>PLAZA</th>
                                                    <th>SEDE</th>
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
    </div>
    </div>
    <?php $this->load->view('template/footer'); ?>
    <script src="<?=base_url()?>dist/js/controllers/ventas/flujo_comisiones.js"></script>
</body>