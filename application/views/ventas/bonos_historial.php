<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-gift fa-2x"></i>
                            </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align" >Historial de bonos</h3>
                                <p class="card-title pl-1">(Historial de todos los bonos y estatus de pago, para ver bonos activos y/o agregar un abono puedes consultarlos en el panel "Bonos")</p>
                            </div>
                            <div class="toolbar">
                                <div class="container-fluid p-0">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group d-flex justify-center align-center">
                                                <h4 class="title-tot center-align m-0">Total bonos:</h4>
                                                <p class="input-tot pl-1" name="totalp" id="totalp">$0.00</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 overflow-hidden">
                                            <div class="form-group">
                                                <label class="control-label" for="roles">Puesto</label>
                                                <select class="selectpicker select-gral" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" name="roles" id="roles" required>
                                                    <?php
                                                        if($this->session->userdata('id_rol') == 18){
                                                            echo '  <option value="20">Marketing Digital</option>';
                                                        } 
                                                        else{
                                                        echo '
                                                            <option value="7">ASESOR</option>
                                                            <option value="9">COORDINADOR</option>
                                                            <option value="3">GERENTE</option>
                                                            <option value="2">SUBDIRECTOR</option>   
                                                            <option value="20">MARKETING DIGITAL</option> 
                                                            ';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 overflow-hidden">
                                            <div class="form-group">
                                                <label class="control-label" for="usuarios_bono">Usuario</label>
                                                <select class="selectpicker select-gral" id="usuarios_bono" name="usuarios_bono" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <table class="table-striped table-hover" id="tabla_bonos" name="tabla_bonos">
                                        <thead>
                                            <tr>
                                                <th>ID PAGO</th>
                                                <th># BONO</th>
                                                <th>USUARIO</th>
                                                <th>RFC</th>
                                                <th>PUESTO</th>
                                                <th>MONTO DEL BONO</th>
                                                <th>ABONADO</th>
                                                <th>PENDIENTE</th>
                                                <th># PAGOS</th>
                                                <th>MONTO INDIVIDUAL</th>
                                                <th>IMPUESTO</th>
                                                <th>TOTAL A PAGAR</th>
                                                <th>FECHA DE CREACIÓN</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/ventas/bonos_historial.js"></script>
</body>