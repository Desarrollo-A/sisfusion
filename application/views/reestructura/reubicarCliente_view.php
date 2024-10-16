<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body>
    <style>
        #clienteConsulta .form-group {
            margin: 0px !important;
        }

        #checkDS .boxChecks {
            background-color: #eeeeee;
            width: 100%;
            border-radius: 27px;
            box-shadow: none;
            padding: 5px !important;
        }

        #checkDS .boxChecks .checkstyleDS {
            cursor: pointer;
            user-select: none;
            display: block;
        }

        #checkDS .boxChecks .checkstyleDS span {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 31px;
            border-radius: 9999px;
            overflow: hidden;
            transition: linear 0.3s;
            margin: 0;
            font-weight: 100;
        }

        #checkDS .boxChecks .checkstyleDS span:nth-child(2) {
            margin: 0 3px;
        }

        #checkDS .boxChecks .checkstyleDS span:hover {
            box-shadow: none;
        }

        #checkDS .boxChecks .checkstyleDS input {
            pointer-events: none;
            display: none;
        }

        #checkDS .boxChecks .checkstyleDS input:checked+span {
            transition: 0.3s;
            font-weight: 400;
            color: #0a548b;
        }

        #checkDS .boxChecks .checkstyleDS input:checked+span:before {
            font-family: FontAwesome !important;
            content: "\f00c";
            color: #0a548b;
            font-size: 18px;
            margin-right: 5px;
        }

        .tituloDeshacer {
            font-weight: 500;
            font-size: 1.4em;

        }

        .textoDeshacer {
            font-size: 1.5rem;
        }

        .accordion {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
        }

        .accordion:hover {
            background-color: #ccc;
        }

        .panel {
            padding: 0 18px;
            display: none;
            background-color: white;
            overflow: hidden;
        }

        .coop {
            display: 'none'
        }
    </style>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <div class="modal fade" id="archivosReestructura" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <div class="modal-body text-center">
                        <h5>SELECCIONA LOS ARCHIVOS PARA ASOCIARLOS AL LOTE</h5>
                        <div class="row" id="info-cliente"></div>
                        <hr>
                        
                        <div id="formularioArchivos"></div>
                    </div>
                    <div class="modal-footer mt-2">
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                            <button type="button" id="sendRequestButton" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="archivosReestructuraFusion" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header"></div>
                        <div class="modal-body text-center">
                            <h5>SELECCIONA LOS ARCHIVOS PARA ASOCIARLOS AL LOTE</h5>
                            <div class="row" id="info-clienteFusion"></div>
                            <hr>
                            <!-- <div class="row coop" id="co-propietarios">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                            <h5 role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">COPROPIETARIO (S) <i id="copropietario-icono" class="fa fa-angle-down"></i></h5>
                                        </div>
                                    </div>

                                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div id="contenedorCoprop" role="tablist" aria-multiselectable="true">

                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div> -->
                            <div id="formularioOrigenEditar"></div>
                            <div id="formularioArchivosFusion"></div>
                        </div>
                        <div class="modal-footer mt-2">
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                <button type="button" id="sendRequestButtonFusion" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="archivosFusionEditar" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header"></div>
                        <div class="modal-body text-center">
                            <h5>SELECCIONA LOS ARCHIVOS PARA ASOCIARLOS AL LOTE</h5>
                            <div class="row" id="info-clienteEditar"></div>
                            <hr>
                            <div class="row coop" id="co-propietarios">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                            <h5 role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">COPROPIETARIO (S) <i id="copropietario-icono" class="fa fa-angle-down"></i></h5>
                                        </div>
                                    </div>

                                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div id="contenedorCoprop" role="tablist" aria-multiselectable="true">

                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div id="formularioOrigenEditar"></div>
                            <div id="formularioEditarFusion"></div>
                        </div>
                        <div class="modal-footer mt-2">
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                <button type="button" id="sendRequestButtonEditar" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="contratoFirmadoModal" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog" id="dialoSection">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <div class="modal-body text-center">
                        <h5 id="txtTituloCF"></h5>
                        <p id="secondaryLabelDetail"></p>
                        <div class="row" id="info-cliente-modal-cf"></div>
                        <b>
                            <h5 id="mainLabelTextcf" class="bold"></h5>
                        </b>
                        <div id="formularioArchivoscf"></div>
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="sendRequestButtoncf" class="btn btn-primary <?php if (!in_array($this->session->userdata('id_rol'), [17, 70])) {
                                                                                                    echo 'hidden';
                                                                                                } ?>">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="asignacionModal" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <div class="modal-body text-center">
                        <h5 id="mainLabelTextAsignacion"></h5>
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 overflow-hidden">
                            <label class="control-label" for="id_usuario">Ejecutivo jurídico</label>
                            <select id="id_usuario" name="id_usuario" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" size="5" data-container="body" required></select>
                        </div>
                        <input type="text" class="hide" id="idLote">
                        <input type="text" class="hide" id="nombreLote">
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="sendRequestButtonAsignacion" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="regresoPreproceso" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <div class="modal-body text-center pt-0">
                        <h4 id="tituloRegreso" class="tituloDeshacer"></h4>
                        <h4 id="preProcesoActual" class="textoDeshacer"></h4>
                        <div class="col-md-12">
                            <label class="control-label">Motivo del rechazo (opcional)</label>
                            <input class="text-modal mb-1" id="comentarioRegreso" name="comentarioRegreso" autocomplete="off">
                        </div>
                        <div class="container-fluid">
                            <div class="row" id="opcionesRegreso"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnRegreso">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Reubicación de clientes existentes</h3>
                                    <p class="card-title pl-1"></p>
                                </div>
                                <div class="material-datatables">
                                    <table id="reubicacionClientes" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>MOVIMIENTO</th>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>ID LOTE</th>
                                                <th>CLIENTE</th>
                                                <th>ASESOR</th>
                                                <th>COORDINADOR</th>
                                                <th>GERENTE</th>
                                                <th>SUBDIRECTOR</th>
                                                <th>DIRECTOR REGIONAL</th>
                                                <th>DIRECTOR REGIONAL 2</th>
                                                <th>FECHA DE APARTADO</th>
                                                <th>SUPERFICIE</th>
                                                <th>COSTO M2 FINAL</th>
                                                <th>TOTAL</th>
                                                <th>ESTATUS</th>
                                                <th>ASIGNADO A</th>
                                                <th>COMENTARIO</th>
                                                <th>EJECUTIVO JURÍDICO</th>
                                                <th>SEDE</th>
                                                <th>FECHA ÚLTIMO ESTATUS</th>
                                                <th>FECHA VENCIMIENTO</th>
                                                <th>ESTATUS CONTRALORÍA</th>
                                                <th>PROCESO URGENTE</th>
                                                <th>ESTATUS CANCELACIÓN</th>
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
</body>
<?php $this->load->view('template/footer'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/css/shadowbox.css">
<script type="text/javascript" src="<?= base_url() ?>dist/js/shadowbox.js"></script>
<script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/reestructura/reubicacionClientes.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/reestructura/subirArchivosReestructura.js"></script>