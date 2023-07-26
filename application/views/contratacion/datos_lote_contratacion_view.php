<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body>
    <div class="wrapper">
        <?php
			if (in_array($this->session->userdata('id_rol'), array(16, 6, 5, 13, 17, 32, 2, 3, 4, 9, 7, 33, 23, 35, 2, 11, 12, 15, 28, 19, 20, 50, 40, 53, 55, 47, 58, 61, 54, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 55, 63, 18)))
            	$this->load->view('template/sidebar');
			else
				echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
		?>

        <!-- Modals -->
        <div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Consulta de historial <b id="nomLoteHistorial"></b></h4>
                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                                <li role="presentation" class="active">
                                    <a href="#tabHistoriaContratacion" aria-controls="tabHistoriaContratacion" role="tab" data-toggle="tab">Historial de contratación</a>
                                </li>
                                <li role="presentation">
                                    <a href="#tabHistoriaLiberacion" aria-controls="tabHistoriaLiberacion" role="tab" data-toggle="tab">Historial de liberación</a>
                                </li>
                                <li role="presentation">
                                    <a href="#tabVentasCompartidas" aria-controls="tabVentasCompartidas" role="tab" data-toggle="tab">Ventas compartidas</a>
                                </li>
                                <li role="presentation" id="divTabClausulas">
                                    <a href="#tabClausulas" aria-controls="tabClausulas" role="tab" data-toggle="tab">Cláusulas</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="tabHistoriaContratacion">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content">
                                                    <table id="tablaHistorialContratacion">
                                                        <thead>
                                                            <tr>
                                                                <th>LOTE</th>
                                                                <th>ESTATUS</th>
                                                                <th>DETALLES</th>
                                                                <th>COMENTARIO</th>
                                                                <th>FECHA DE ESTATUS</th>
                                                                <th>USUARIO</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tabHistoriaLiberacion">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content">
                                                    <table id="tablaHistoriaLiberacion">
                                                        <thead>
                                                            <tr>
                                                                <th>LOTE</th>
                                                                <th>PRECIO</th>
                                                                <th>FECHA DE LIBERACIÓN</th>
                                                                <th>COMENTARIO</th>
                                                                <th>USUARIO</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tabVentasCompartidas">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content">
                                                    <table id="tablaVentasCompartidas">
                                                        <thead>
                                                            <tr>
                                                                <th>ASESOR</th>
                                                                <th>COORDINADOR</th>
                                                                <th>GERENTE</th>
                                                                <th>SUBDIRECTOR</th>
                                                                <th>DIRECTOR REGIONAL</th>
                                                                <th>DIRECTOR REGIONAL 2</th>
                                                                <th>FECHA DE ALTA</th>
                                                                <th>USUARIO</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tabClausulas">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content">
                                                    <h6 id="clauses_content"></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Modals -->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon fa-2x" data-background-color="goldMaderas">
                                <?php
                                    if(in_array($this->session->userdata('id_rol'), array(7, 9, 3, 2, 1, 6, 5, 4))) {
                                ?>
                                    <a href="https://youtu.be/cfRUmAdELkU" class="align-center justify-center u2be" target="_blank">
                                        <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                                    </a>
                                <?php
                                    } else {
                                ?>
                                    <i class="fas fa-box"></i>
                                <?php
                                    }
                                ?>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Inventario lotes</h3>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-md-4 form-group overflow-hidden">
                                            <div class="form-group">
                                                <label class="m-0" for="idResidencial">Proyecto</label>
                                                <select id="idResidencial" name="idResidencial" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" size="5" data-container="body" required></select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group overflow-hidden">
                                            <div class="form-group">
                                                <label class="m-0" for="idCondominioInventario">Condominio</label>
                                                <select name="idCondominioInventario" id="idCondominioInventario" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required></select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group overflow-hidden">
                                            <div class="form-group">
                                                <label class="m-0" for="idEstatus">Estatus</label>
                                                <select name="idEstatus" id="idEstatus" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <table class="table-striped table-hover hide" id="tablaInventario" name="tablaInventario">
                                        <thead>
                                            <tr>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>ID LOTE</th>
                                                <th>SUPERFICIE</th>
                                                <th>PRECIO DE LISTA</th>
                                                <th>TOTAL CON DESCUENTOS</th>
                                                <th>M2</th>
                                                <th>REFERENCIA</th>
                                                <th>MSI</th>
                                                <th>ASESOR</th>
                                                <th>COORDINADOR</th>
                                                <th>GERENTE</th>
                                                <th>SUBDIRECTOR</th>
                                                <th>DIRECTOR REGIONAL</th>
                                                <th>DIRECTOR REGIONAL 2</th>
                                                <th>ESTATUS</th>
                                                <th>ESTATUS DE CONTRATACIÓN</th>
                                                <th>APARTADO</th>
                                                <th>COMENTARIO</th>
                                                <th>LUGAR DE PROSPECCIÓN</th>
                                                <th>FECHA DE VALIDACIÓN ENGANCHE</th>
                                                <th>CANTIDAD DE ENGANCHE PAGADO</th>
                                                <th>ESTATUS DE LA CONTRATACIÓN</th>
                                                <th>CLIENTE</th>
                                                <th>COPROPIETARIO (S)</th>
                                                <th>COMENTARIO DE NEODATA</th>
                                                <th>FECHA DE APERTURA</th>
                                                <th>APARTADO DE REUBICACIÓN</th>
                                                <th>FECHA DE ALTA</th>
                                                <th>VENTA COMPARTIDA</th>
                                                <th>UBICACIÓN DE LA VENTA</th>
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
    <!--main-panel close-->
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/controllers/contratacion/datos_lote_contratacion.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
</body>