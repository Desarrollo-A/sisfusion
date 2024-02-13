<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
    <style>
        #clienteConsulta .form-group{
            margin: 0px!important;
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
        #checkDS .boxChecks .checkstyleDS input:checked + span {
            transition: 0.3s;
            font-weight: 400;
            color: #0a548b;
        }
        #checkDS .boxChecks .checkstyleDS input:checked + span:before {
            font-family: FontAwesome !important;
            content: "\f00c";
            color: #0a548b;
            font-size: 18px;
            margin-right: 5px;
        }
        .tituloDeshacer{
            font-weight: 500;
            font-size: 1.4em;

        }
        .textoDeshacer{
            font-size: 1.5rem;
        }
    </style>
    <div class="wrapper">
        <?php  $this->load->view('template/sidebar'); ?>
        <div class="modal fade" id="addDeleteFileModal" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <div class="modal-body text-center">
                        <h5 id="mainLabelText"></h5>
                        <p id="secondaryLabelDetail"></p>
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                            <div class="hide" id="selectFileSection">
                                <div class="file-gph">
                                    <input class="d-none" type="file" id="fileElm">
                                    <input class="file-name" id="file-name" type="text" placeholder="No has seleccionada nada aún" readonly="">
                                    <label class="upload-btn m-0" for="fileElm"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>
                                </div>
                            </div>
                        </div>
                        <input type="text" class="hide" id="idLoteValue">
                        <input type="text" class="hide" id="idDocumento">
                        <input type="text" class="hide" id="tipoDocumento">
                        <input type="text" class="hide" id="nombreDocumento">
                        <input type="text" class="hide" id="tituloDocumento">
                        <input type="text" class="hide" id="accion">
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="sendRequestButton" class="btn btn-primary">Guardar</button>
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
                                    <h3 class="card-title center-align">Carga de contrato firmado</h3>
                                    <p class="card-title pl-1"></p>
                                </div>
                                <div class="material-datatables">
                                    <table id="cargaContratoFirmadoTabla" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>ID LOTE</th>
                                                <th>CLIENTE</th>
                                                <th>FECHA DE APARTADO</th>
                                                <th>ESTATUS PREPROCESO</th>
                                                <th>ESTATUS CARGA CONTRATO</th>
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
</body>
<?php $this->load->view('template/footer');?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
<script src="<?=base_url()?>dist/js/controllers/reestructura/cargaContratoFirmado.js"></script>
