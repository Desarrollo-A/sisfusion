<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <!-- Modals -->
        <div class="modal fade" id="seeInformationModalAsimilados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    </div>
                    <form id="form_baja" name="form_baja" method="post">
                        <div class="modal-body cancelacion"></div>
                        <div class="modal-footer" ></div>
                    </form>
                </div>
            </div>
        </div>
        <!--END MODALS-->
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="material-icons">money_off</i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Reporte de descuentos <b>universidad maderas</b></h3>
                                    <p class="card-title pl-1">(Listado de lotes donde se aplicó el descuento según el mes seleccionado)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                    <p class="input-tot pl-1" name="myText_desU" id="myText_desU">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="mes">Año (<span class="isRequired">*</span>)</label>
                                                    <select name="anio" id="anio" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="mes">Mes</label>
                                                    <select name="mes" id="mes" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body"  required>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover hide" id="tabla_historialGral" name="tabla_historialGral">
                                            <thead>
                                                <tr>
                                                    <th>ID PAGO</th>
                                                    <th>LOTE</th>  
                                                    <th>EMPRESA</th>          
                                                    <th>ID USUARIO</th>
                                                    <th>NOMBRE</th>
                                                    <th>PUESTO</th>
                                                    <th>PLAZA</th>
                                                    <th>DESCUENTO</th>
                                                    <th>CREADO POR</th>
                                                    <th>FECHA DE CREACIÓN</th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div>
    <?php $this->load->view('template/footer'); ?>
    <script src="<?= base_url() ?>dist/js/controllers/ventas/historialCapitalFechas.js"></script>
</body>