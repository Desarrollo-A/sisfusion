<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/sidebar');  ?>
    
    <div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><span data-i18n="consulta-historial">Consulta de historial</span> <b id="nomLoteHistorial"></b></h4>
                </div>

                <div class="modal-body">
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                            <li role="presentation" class="active">
                                <a href="#changeprocesTab" aria-controls="changeprocesTab" role="tab" onclick="javascript:$('#verDet').DataTable().ajax.reload();" data-toggle="tab"><span data-i18n="proceso-contratacion">Proceso de contratación</span></a>
                            </li>
                            <li role="presentation">
                                <a href="#changelogTab" aria-controls="changelogTab" role="tab" data-toggle="tab" onclick="javascript:$('#verDetBloqueo').DataTable().ajax.reload();"><span data-i18n="liberacion">Liberación</span></a>
                            </li>
                            <li role="presentation">
                                <a href="#coSellingAdvisers" aria-controls="coSellingAdvisers" role="tab" data-toggle="tab" onclick="javascript:$('#seeCoSellingAdvisers').DataTable().ajax.reload();"><span data-i18n="asesores-venta-compartida">Asesores venta compartida</span></a>
                            </li>
                            <li role="presentation" class="hide" id="li_individual_sales">
                                <a href="#salesOfIndividuals" aria-controls="salesOfIndividuals" role="tab" data-toggle="tab"><span data-i18n="clausulas">Clausulas</span></a>
                            </li>
                        </ul>
                        <!-- Tab panes -->

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="changeprocesTab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content">
                                                <div class="material-datatables">
                                                    <table id="verDet"
                                                            class="table-striped table-hover text-center">
                                                        <thead>
                                                            <tr>
                                                                <th>LOTE</th>
                                                                <th>ESTATUS</th>
                                                                <th>DETALLES</th>
                                                                <th>COMENTARIOS</th>
                                                                <th>FECHA</th>
                                                                <th>USUARIO</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="changelogTab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content">
                                                <div class="material-datatables">
                                                    <table id="verDetBloqueo"
                                                            class="table-striped table-hover text-center">
                                                        <thead>
                                                            <tr>
                                                                <th>LOTE</th>
                                                                <th>PRECIO</th>
                                                                <th>FECHA LIBERACIÓN</th>
                                                                <th>COMENTARIO LIBERACIÓN</th>
                                                                <th>USUARIO</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="coSellingAdvisers">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content">
                                                <div class="material-datatables">
                                                    <table id="seeCoSellingAdvisers"
                                                            class="table-striped table-hover text-center">
                                                        <thead>
                                                            <tr>
                                                                <th>ASESOR</th>
                                                                <th>COORDINADOR</th>
                                                                <th>GERENTE</th>
                                                                <th>FECHA ALTA</th>
                                                                <th>USUARIO</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="salesOfIndividuals">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content">
                                                <h4 id="clauses_content"></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="prospecto_lbl" id="prospecto_lbl">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">
                    <span data-i18n="cerrar">CERRAR</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modals -->
    <div class="modal fade " id="modalLineaVenta" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <form id="formLineaVentas">
                <div class="modal-content">
                    <div class="modal-body">

                        <div class="modal-body" id="modalI">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"><span data-i18n="cancelar">Cancelar</span></button>
                        <button type="submit" class="btn btn-primary" id="btnInventario"><span data-i18n="aceptar">Aceptar</span></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-receipt fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align"><span data-i18n="linea-venta">Línea de venta</span></h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div  class="toolbar">
                                <div class="row">
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-md-12 p-r">
                                                    <label class="control-label" data-i18n="apartado-fecha">Fecha apartado</label>
                                                        <div class="form-group d-flex">
                                                            <input type="text" class="form-control datepicker" id="beginDate" value="" autocomplete='off' />
                                                            <input type="text" class="form-control datepicker2" id="endDate" value="" autocomplete='off' />
                                                            <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                                                                <span class="material-icons update-dataTable">search</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <table id="tabla_lineaVenta" name="tabla_lineaVenta"
                                        class="table-striped table-hover text-center">
                                    <thead>
                                    <tr>
                                        <th>proyecto</th>
                                        <th>condominio</th>
                                        <th>lote</th>
                                        <th>referencia</th>
                                        <th>asesor</th>
                                        <th>coordinador</th>
                                        <th>gerente</th>
                                        <th>subdirector</th>
                                        <th>director-regional</th>
                                        <th>director-regional2</th>
                                        <th>tipo-asesor</th>
                                        <th>estatus</th>
                                        <th>apartado-fecha</th>
                                        <th>ubicacion</th>
                                        <th>acciones</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend');?>
    </div>
</div>
</body>
<?php $this->load->view('template/footer');?>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?= base_url() ?>dist/js/moment.min.js"></script>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/contraloria/lineaVentaInventario.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>

