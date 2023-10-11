<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
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
                                <li role="presentation">
                                    <a href="#tabHistorialEstatus" aria-controls="tabHistorialEstatus" role="tab" data-toggle="tab">Historial Estatus</a>
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
                                <div role="tabpanel" class="tab-pane" id="tabHistorialEstatus">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                                    <ul class="timeline-3" id="HistorialEstatus"></ul>
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
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon fa-2x" data-background-color="goldMaderas">
                                <?php
                                if (in_array($this->session->userdata('id_rol'), array(7, 9, 3, 2, 1, 6, 5, 4))) {
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
                                        <div class=" col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="selectorModo">
                                            <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6 pb-3">
                                                <div class="radio_container w-100">
                                                    <input class="d-none generate" type="radio" name="modoSubida"
                                                           id="condominioM" checked value="1">
                                                    <label for="condominioM" class="w-50">Inventario Lotes</label>
                                                    <input class="d-none find-results" type="radio" name="modoSubida"
                                                           id="loteM" value="0">
                                                    <label for="loteM" class="w-50">Descargar inventario sede</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="selectoresInv">
                                            <div class="col-md-4 form-group">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="idResidencial">Proyecto</label>
                                                    <select id="idResidencial" name="idResidencial" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" size="5" data-container="body" required></select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="idCondominioInventario">Condominio</label>
                                                    <select name="idCondominioInventario" id="idCondominioInventario" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="idEstatus">Estatus</label>
                                                    <select name="idEstatus" id="idEstatus" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hide" id="selectoresDescInv">
                                            <div class="col-md-4 form-group">
                                                <div class="form-group select-is-empty">
                                                    <label class="control-label">Sedes por proyecto</label>
                                                    <select name="sedes" id="sedes" class="selectpicker select-gral m-0"
                                                            data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN"
                                                            data-size="7" data-live-search="true" required>
                                                    </select>

                                <?php
                                if (in_array($this->session->userdata('id_rol'), array(70, 71, 73, 17))) {
                                ?>
                                    <form method="POST">
                                        <div class="toolbar">
                                            <div class="row">
                                                <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                    <div class="radio_container w-100">
                                                        <input class="d-none" type="radio" name="opcion" value="opcion1" id="one" onchange="this.form.submit()">
                                                        <label for="one" class="w-50">Inventario lotes</label>
                                                        <input class="d-none" type="radio" name="opcion" value="opcion2" id="two" onchange="this.form.submit()">
                                                        <label for="two" class="w-50">Descargar</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <?php
                                    if (isset($_POST['opcion'])) {
                                        $opcion = $_POST['opcion'];

                                        if ($opcion === "opcion1") {
                                    ?>
                                            <script>
                                                document.getElementById("one").checked = true;
                                            </script>
                                            <div class="toolbar">
                                                <div class="row">
                                                    <div class="col-md-4 form-group">
                                                        <div class="form-group overflow-hidden">
                                                            <label class="control-label" for="idResidencial">Proyecto</label>
                                                            <select id="idResidencial" name="idResidencial" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" size="5" data-container="body" required></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <div class="form-group overflow-hidden">
                                                            <label class="control-label" for="idCondominioInventario">Condominio</label>
                                                            <select name="idCondominioInventario" id="idCondominioInventario" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <div class="form-group overflow-hidden">
                                                            <label class="control-label" for="idEstatus">Estatus</label>
                                                            <select name="idEstatus" id="idEstatus" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required></select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php
                                        } else if ($opcion === "opcion2") {
                                        ?>
                                            <script>
                                                document.getElementById("two").checked = true;
                                            </script>
                                            <div class="toolbar" id="contenido">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="col-md-4 form-group">
                                                            <div class="form-group select-is-empty">
                                                                <label class="control-label">Sedes por proyecto</label>
                                                                <select name="sedes" id="sedes" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" required>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    <?php
                                        }
                                    }
                                    ?>

                                <?php
                                } else {
                                ?>

                                    <div class="toolbar">
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="idResidencial">Proyecto</label>
                                                    <select id="idResidencial" name="idResidencial" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" size="5" data-container="body" required></select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="idCondominioInventario">Condominio</label>
                                                    <select name="idCondominioInventario" id="idCondominioInventario" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="idEstatus">Estatus</label>
                                                    <select name="idEstatus" id="idEstatus" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>


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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    <?php $this->load->view('template/footer'); ?>
    <script src="<?= base_url() ?>dist/js/controllers/contratacion/datos_lote_contratacion.js?=v.4.4.4"></script>
    <script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
</body>