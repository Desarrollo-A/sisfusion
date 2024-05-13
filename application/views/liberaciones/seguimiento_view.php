<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
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

        .form-group > input[name="costoM2"] {
            margin-top: -10px !important;
        }
        
        .tituloDeshacer {
            font-weight: 500;
            font-size: 1.4em;
        }

        .textoDeshacer {
            font-size: 1.5rem;
        }

    </style>
    <div class="wrapper">
        <?php  $this->load->view('documentacion/documentosModales'); ?> <!--Modales para el manejo de los documentos-->
        <?php  $this->load->view('template/sidebar'); ?>

        <!-- MODAL DE AVANCE O RECHAZO DE CONTRALORÍA A POSTVENTA -->
        <div class="modal fade" id="accion-modal" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header text-center" id="labelHeaderAccionModal">
                        <!-- <h4>¿Está seguro de <b>rechazar</b> el expediente de <b>'+nombreLote+'</b>?</h4> -->
                    </div>
                    <div class="modal-body pt-0">
                        <div id="extra-content-accion-modal"></div>
                        <div class="col-md-12 mb-2 text-center comment">
                            <label class="control-label" id="labelComentarioAccionModal">
                                <!-- Motivo del rechazo (opcional) -->
                            </label>
                            <input class="text-modal mb-1" id="comentarioAccionModal" name="comentarioAccionModal" autocomplete="off">                   
                        </div>
                        <div id="data-modal"></div>
                    </div> 
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btn-accion">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de cambios -->
        <div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Bitácora de cambios</h4>
                        </div>
                        <div class="modal-body">                      
                            <div class="container-fluid" id="changelogTab">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll-styles" style="height: 350px; overflow: auto">
                                        <ul class="timeline-3" id="changelog">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="prospecto_lbl" id="prospecto_lbl">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanComments()">Cerrar</button>
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
                                    <h3 class="card-title center-align">Proceso de liberación de lotes (Particulares)</h3>
                                    <p class="card-title pl-1"></p>
                                </div>
                                <div class="material-datatables">
                                    <table id="liberacionesDataTable" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>MOVIMIENTO</th>
                                                <th>PROCESO</th>
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

        <!-- ANIMACIÓN DE CARGA EN TODA LA VISTA -->
        <div class="spiner-loader hide" id="spiner-loader">
            <div class="backgroundLS">
                <div class="contentLS">
                    <div class="center-align">
                        Este proceso puede demorar algunos segundos
                    </div>
                    <div class="inner">
                        <div class="load-container load1">
                            <div class="loader">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend');?>
    </div>
</body>
<?php $this->load->view('template/footer');?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
<script src="<?=base_url()?>dist/js/core/modal-general.js"></script>
<script src="<?=base_url()?>dist/js/controllers/liberaciones/seguimiento.js"></script>
<!-- <script src="<?=base_url()?>dist/js/controllers/liberaciones/subirArchivosLiberaciones.js"></script> -->