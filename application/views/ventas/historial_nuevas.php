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
                                    <h3 class="card-title center-align" >Comisiones nuevas </h3>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Acumulado:</h4>
                                                    <p class="input-tot pl-1" name="pagar_asimilados" id="pagar_asimilados">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row aligned-row d-flex align-end">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 overflow-hidden">
                                                <div class="form-group">
                                                    <label class="m-0" for="comisiones_nuevas">Puesto</label>
                                                    <select name="comisiones_nuevas" id="comisiones_nuevas" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 overflow-hidden">
                                                <div class="form-group">
                                                    <label class="m-0" for="usuario_nuevas">Usuario</label>
                                                    <select class="selectpicker select-gral" id="usuario_nuevas" name="usuario_nuevas[]" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN " data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla_asimilados" name="tabla_asimilados">
                                            <thead>
                                            <tr>
                                                                <th>ID</th>
                                                                <th>PROYECTO</th>
                                                                <th>CONDOMINIO</th>
                                                                <th>LOTE</th>
                                                                <th>REFERENCIA</th>
                                                                <th>PRECIO DEL LOTE</th>
                                                                <th>TOTAL DE LA COMISIÓN</th>
                                                                <th>PAGO DEL CLIENTE</th>
                                                                <th>DISPERSADO</th>
                                                                <th>PAGADO</th>
                                                                <th>PENDIENTE</th>
                                                                <th>USUARIO</th>
                                                                <th>PUESTO</th>
                                                                <th>DETALLE</th>
                                                                <th>ESTATUS</th>
                                                                <th>ACCIONES</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/historial_nuevas.js"></script>
</body>