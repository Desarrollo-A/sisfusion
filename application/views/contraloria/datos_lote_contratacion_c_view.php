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
                    <h4 class="modal-title">Consulta de historial <b id="nomLoteHistorial"></b></h4>
                </div>

                <div class="modal-body">
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                            <li role="presentation" class="active">
                                <a href="#changeprocesTab" aria-controls="changeprocesTab" role="tab" onclick="javascript:$('#verDet').DataTable().ajax.reload();" data-toggle="tab">Proceso de contratación</a>
                            </li>
                            <li role="presentation">
                                <a href="#changelogTab" aria-controls="changelogTab" role="tab" data-toggle="tab" onclick="javascript:$('#verDetBloqueo').DataTable().ajax.reload();">Liberación</a>
                            </li>
                            <li role="presentation">
                                <a href="#coSellingAdvisers" aria-controls="coSellingAdvisers" role="tab" data-toggle="tab" onclick="javascript:$('#seeCoSellingAdvisers').DataTable().ajax.reload();">Asesores venta compartida</a>
                            </li>
                            <li role="presentation" class="hide" id="li_individual_sales">
                                <a href="#salesOfIndividuals" aria-controls="salesOfIndividuals" role="tab" data-toggle="tab">Clausulas</a>
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
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR
                    </button>
                </div>
            </div>
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
                                <h3 class="card-title center-align">Inventario lotes</h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div  class="toolbar">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="col-md-4 form-group">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">PROYECTO</label>
                                                <select name="proyecto"
                                                        id="proyecto" 
                                                        class="selectpicker select-gral m-0"
                                                        data-style="btn"
                                                        data-show-subtext="true"
                                                        title="Selecciona una opción"
                                                        data-size="7"
                                                        data-live-search="true"
                                                        required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">CONDOMINIO</label>
                                                <select name="condominio"
                                                        id="condominio" 
                                                        class="selectpicker select-gral m-0"                                                             
                                                        data-style="btn btn-second"
                                                        data-show-subtext="true"
                                                        data-live-search="true"
                                                        title="Selecciona una opción"
                                                        data-size="7" 
                                                        data-live-search="true"
                                                        required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">ESTATUS</label>
                                                <select name="estatus"
                                                        id="estatus"
                                                        class="selectpicker select-gral m-0"                                                             
                                                        data-style="btn btn-second"
                                                        data-show-subtext="true"
                                                        data-live-search="true"
                                                        title="Selecciona una opción"
                                                        data-size="7"
                                                        data-live-search="true"
                                                        required>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <table id="tabla_inventario_contraloria" name="tabla_inventario_contraloria"
                                        class="table-striped table-hover text-center">
                                    <thead>
                                    <tr>
                                        <th>PROYECTO</th>
                                        <th>CONDOMINIO</th>
                                        <th>LOTE</th>
                                        <th>SUP</th>
                                        <th>M2</th>
                                        <th>PRECIO LISTA</th>
                                        <th>TOTAL CON DESCUENTOS</th>
                                        <th>REFERENCIA</th>
                                        <th>MSNI</th>
                                        <th>ASESOR</th>
                                        <th>COORDINADOR</th>
                                        <th>GERENTE</th>
                                        <th>SUBDIRECTOR</th>
                                        <th>DIRECTOR REGIONAL</th>
                                        <th>ESTATUS</th>
                                        <th>FECHA DE APARTADO</th>
                                        <th>COMENTARIO</th>
                                        <th>LUGAR PROSPECCIÓN</th>
                                        <th>FECHA APERTURA</th>
                                        <th>FECHA VAL. ENGANCHE</th>
                                        <th>CANTIDAD ENGANCHE PAGADO</th>
                                        <th>UBICACIÓN</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<!--CARGA DE DATOS.-->
<script src="<?= base_url() ?>dist/js/controllers/contraloria/datos_lote_contratacion_c.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>

