<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
    <?php
    $this->load->view('template/sidebar');
    $this->load->view('template/controversy_modals');
    ?>
    <style>
        textarea:focus, textarea.form-control:focus {

            outline: none !important;
            outline-width: 0 !important;
            box-shadow: none;
            -moz-box-shadow: none;
            -webkit-box-shadow: none;
        }

        .textoshead::placeholder {
            color: white;
        }

        .zoom {
            transition: 1.5s ease;
            -moz-transition: 1.5s ease; /* Firefox */
            -webkit-transition: 1.5s ease; /* Chrome - Safari */
            -o-transition: 1.5s ease; /* Opera */
        }

        .zoom:hover {
            transform: scale(1.5);
            -moz-transform: scale(1.5); /* Firefox */
            -webkit-transform: scale(1.5); /* Chrome - Safari */
            -o-transform: scale(1.5); /* Opera */
            -ms-transform: scale(1.5); /* IE9 */
            z-index: 999999999999999999999999;
        }
    </style>

    <!-- modal  INSERT COMENTARIOS-->
    <div class="modal fade" id="evidenciaModalRev" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="sendRespFromCB" name="sendRespFromCB">
                    <div class="modal-header text-center">
                        <h3 class="modal-title" id="myModalLabel"><b>Autorizar evidencia</b></h3>
                    </div>
                    <div class="modal-body">
                        <div id="loadAuts">
                        </div>
                        <input type="hidden" name="nombreLote" id="nombreLote" value="">
                        <input type="hidden" name="idCliente" id="idCliente" value="">
                        <input type="hidden" name="idLote" id="idLote" value="">
                        <input type="hidden" name="id_evidencia" id="id_evidencia" value="">
                        <input type="hidden" name="evidencia_file" id="evidencia_file" value="">
                        <input type="hidden" name="rowType" id="rowType" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary hide" id="button_enviar">Enviar autorización</button>
                        <a href="#" class="btn btn-primary" id="btnSubmit">Enviar autorización</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-bookmark fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Autorizaciones de evidencia </h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div  class="toolbar">
                                <div class="row">
                                </div>
                            </div>
                            <div class="material-datatables">
                                <table  id="autorizarEvidencias" class="table-striped table-hover" style="text-align:center;">
                                    <thead>
                                        <tr>
                                            <th>ID LOTE</th>
                                            <th>FECHA APARTADO</th>
                                            <th>PLAZA</th>
                                            <th>LOTE</th>
                                            <th>Cliente</th>
                                            <th>SOLICITANTE</th>
                                            <th>ESTATUS</th>
                                            <th>TIPO</th>
                                            <th>VALIDACIÓN GERENTE</th>
                                            <th>VALIDACIÓN COBRANZA</th>
                                            <th>VALIDACIÓN CONTRALORÍA</th>
                                            <th>RECHAZO COBRANZA</th>
                                            <th>RECHAZO VALIDACIÓN</th>
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
</body>
<?php $this->load->view('template/footer'); ?>
<script src="<?= base_url() ?>dist/js/evidencias.js"></script>
<script src="<?=base_url()?>dist/js/controllers/ventas/autorizarEvidenciaCN.js"></script>