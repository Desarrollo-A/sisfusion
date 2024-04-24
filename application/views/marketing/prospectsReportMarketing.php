<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>

<div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>
    <div class="modal fade" id="verDetalles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <b><h4 class="card-title ">Ventas compartidas</h4></b>
                    <div class="material-datatables">
                        <div class="form-group">
                            <table id="verDet" class="table-striped table-hover">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="nav nav-tabs nav-tabs-cm" role="tablist">
                        <li class="active menuTab" id="prospectosTab"><a href="#generalProspectos" role="tab" data-toggle="tab">LISTADO PROSPECTOS</a></li>
                        <li class="menuTab" id="clientesTab"><a href="#generalClientes" role="tab" data-toggle="tab">LISTADO CLIENTES</a></li>
                    </ul>
                    <div class="card no-shadow m-0">
                        <div class="card-content p-0">
                            <div class="nav-tabs-custom">
                                <div class="tab-content p-2">
                                    <div class="tab-pane active" id="generalProspectos">
                                        <div class="text-center">
                                            <h3 class="card-title center-align">Listado general de prospectos</h3>
                                        </div>
                                        <div class="toolbar">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mt-2 hide">
                                                        <label class="control-label">TIPO</label>
                                                        <div class="radio_container w-100">
                                                            <input class="d-none generate" type="radio" name="modoSubida" id="dragonId" checked value="1">
                                                            <label for="dragonId" class="w-50">Dragon</label>
                                                            <input class="d-none find-results" type="radio" name="modoSubida" id="loteM" value="0">
                                                            <label for="loteM" class="w-50">Salesforce</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mt-2">
                                                        <div class="form-group m-0">
                                                            <label class="control-label m-0">TIPO</label>
                                                            <select class="selectpicker select-gral m-0" id="tipoBusqueda" name="modoSubida" data-container="body" data-style="btn btn-primary "data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7"required="" tabindex="-98">
                                                                <option value="0">Salesforce</option>
                                                                <option value="1" selected="selected">Dragon</option>
                                                                <option value="2">Arcus</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <label class="control-label">NOMBRE</label>
                                                            <input id="name" name="name" type="text" class="form-control input-gral" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group">
                                                            <label class="control-label">CORREO</label>
                                                            <input id="mail" name="mail" type="text" class="form-control input-gral" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group m-0">
                                                            <label class="control-label m-0">TELÉFONO</label>
                                                            <input id="telephone" name="telephone" type="text" class="form-control input-gral" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 hide" id="dragonInput">
                                                        <div class="form-group m-0">
                                                            <label class="control-label m-0">ID DRAGÓN</label>
                                                            <input id="idDragon" name="idDragonC" type="number" class="form-control input-gral" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 hide" id="salesforceInput">
                                                        <div class="form-group m-0">
                                                            <label class="control-label m-0">ID SALESFORCE</label>
                                                            <input id="idSales" name="idSalesF" type="text" class="form-control input-gral" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 hide" id="arcusInput">
                                                        <div class="form-group m-0">
                                                            <label class="control-label m-0">ID ARCUS</label>
                                                            <input id="idArcus" name="idArcus" type="text" class="form-control input-gral" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group m-0">
                                                            <label class="control-label m-0">SEDE</label>
                                                            <select class="selectpicker select-gral m-0" id="sede" name="sede[]" data-container="body" data-style="btn btn-primary "data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7"required="" multiple="" tabindex="-98" onchange="changeSede()">
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="container-fluid hide" id="fechasFiltro">
                                                            <div class="row">
                                                                <div class="col-md-12 p-0">
                                                                    <div class="form-group d-flex">
                                                                        <input type="text" class="form-control datepicker" id="beginDate"/>
                                                                        <input type="text" class="form-control datepicker" id="endDate" />
                                                                        <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange"></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"></div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" id="inside">
                                                        <div class="form-group d-flex justify-end">
                                                            <button type="button" class="btn btn-danger btn-simple" onclick="cleanFilters()" id="cleanButton">LIMPIAR</button>
                                                            <button type="button" class="btn btn-primary" id="searchButton">BUSCAR</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="material-datatables">
                                                    <table class="table-striped table-hover hide" id="tabla_prospectos" name="tabla_prospectos">
                                                        <thead>
                                                        <tr>
                                                            <th>NOMBRE</th>
                                                            <th>TELÉFONO</th>
                                                            <th>CORREO</th>
                                                            <th>LUGAR DE PROSPECCIÓN</th>
                                                            <th>ASESOR</th>
                                                            <th>COORDINADOR</th>
                                                            <th>GERENTE</th>
                                                            <th>FECHA DE CREACIÓN</th>
                                                            <th>ID CRM</th>
                                                            <th>ID DRAGON</th>
                                                            <th>ID SALESFORCE</th>
                                                            <th>ID ARCUS</th>
                                                            <th>ORIGEN</th>
                                                            <th>SEDE</th>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="generalClientes">
                                        <div class="text-center">
                                            <h3 class="card-title center-align">Listado general de clientes</h3>
                                        </div>
                                        <div class="toolbar">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mt-3 hide">
                                                    <label class="control-label m-0">TIPO</label>
                                                    <div class="radio_container w-100">
                                                        <input class="d-none generate" type="radio" name="modoSubidag" id="dragonIdg" checked value="1">
                                                        <label for="dragonIdg" class="w-50">Dragon</label>
                                                        <input class="d-none find-results" type="radio" name="modoSubidag" id="loteMg" value="0">
                                                        <label for="loteMg" class="w-50">Salesforce</label>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mt-2">
                                                    <div class="form-group m-0">
                                                        <label class="control-label m-0">TIPO</label>
                                                        <select class="selectpicker select-gral m-0" id="tipoBusquedag" name="modoSubida" data-container="body" data-style="btn btn-primary "data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7"required="" tabindex="-98">
                                                            <option value="0">Salesforce</option>
                                                            <option value="1" selected="selected">Dragon</option>
                                                            <option value="2">Arcus</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                                    <div class="form-group">
                                                        <label class="control-label">ID LOTE</label>
                                                        <input id="idLotteC" name="idLotteC" type="text" class="form-control input-gral" required>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                                    <div class="form-group">
                                                        <label class="control-label">TELÉFONO</label>
                                                        <input id="telephoneC" name="telephoneC" type="text" class="form-control input-gral" required>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label">NOMBRE</label>
                                                        <input id="nameC" name="nameC" type="text" class="form-control input-gral" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group m-0">
                                                        <label class="control-label m-0">CORREO</label>
                                                        <input id="mailC" name="mailC" type="text" class="form-control input-gral" required>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 hide" id="dragonInputg">
                                                    <div class="form-group m-0">
                                                        <label class="control-label m-0">ID DRAGÓN</label>
                                                        <input id="idDragonC" name="idDragonC" type="number" class="form-control input-gral" required>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 hide" id="arcusInputg">
                                                    <div class="form-group m-0">
                                                        <label class="control-label m-0">ID ARCUS</label>
                                                        <input id="idArcusg" name="idArcusg" type="text" class="form-control input-gral" required>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 hide" id="salesforceInputg">
                                                    <div class="form-group m-0">
                                                        <label class="control-label m-0">ID SALESFORCE</label>
                                                        <input id="idSalesF" name="idSalesF" type="text" class="form-control input-gral" required>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group m-0">
                                                        <label class="control-label m-0">SEDE</label>
                                                        <select class="selectpicker select-gral m-0" id="sedeC" name="sedeC[]" data-style="btn btn-primary " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required="" multiple="" tabindex="-98" onchange="changeSedeC()"></select>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                    <div class="container-fluid hide" id="fechasFiltroC">
                                                        <div class="row">
                                                            <div class="col-md-12 p-0">
                                                                <div class="form-group d-flex">
                                                                    <input type="text" class="form-control datepicker beginDate" id="beginDateC"/>
                                                                    <input type="text" class="form-control datepicker endDate" id="endDateC" />
                                                                    <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRangeC"></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"></div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" id="insideC">
                                                    <div class="form-group d-flex justify-end">
                                                        <button type="button" class="btn btn-danger btn-simple" onclick="cleanFiltersC()" id="cleanButton">LIMPIAR</button>
                                                        <button type="button" class="btn btn-primary" id="searchButtonC">BUSCAR</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <table class="table-striped table-hover hide" id="tabla_clientes" name="tabla_clientes">
                                                        <thead>
                                                        <tr>
                                                            <th>ID LOTE</th>
                                                            <th>PROYECTO</th>
                                                            <th>CONDOMINIO</th>
                                                            <th>LOTE</th>
                                                            <th>NOMBRE DEL CLIENTE</th>
                                                            <th>NÚMERO DE RECIBO</th>
                                                            <th>REFERENCIA</th>
                                                            <th>FECHA DE APARTADO</th>
                                                            <th>ENGANCHE</th>
                                                            <th>FECHA DE ENGANCHE</th>
                                                            <th>FECHA DE CREACIÓN DEL PROSPECTO</th>
                                                            <th>ID CRM</th>
                                                            <th>ID DRAGON</th>
                                                            <th>ID SALESFORCE</th>
                                                            <th>ID ARCUS</th>
                                                            <th>ORIGEN</th>
                                                            <th>ESTATUS DEL LOTE</th>
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
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('template/footer_legend');?>
</div>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<script src="<?=base_url()?>dist/js/controllers/marketing/marketing.js"></script>
</body>
