<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
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
</style>

<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <div class="modal fade" id="asignacionModal" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <div class="modal-body text-center">
                        <h5 id="mainLabelText"></h5>
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 overflow-hidden">
                            <label class="control-label" for="idAsesor">Asesor</label>
                            <select id="idAsesor" name="idAsesor" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" size="5" data-container="body" required></select>
                        </div>
                        <input type="text" class="hide" id="idLote">
                        <input type="text" class="hide" id="nombreLote">
                        <input type="text" class="hide" id="fusionLote">
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="sendRequestButton" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="preguntaConfirmacion" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <div class="modal-body text-center">
                        <h5 id="mainLabelText">¿Desea fusionar los siguientes lotes para proceso de reubicación?</h5>
                        <p id="txtLotes"></p>
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="fusionarLotes" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalQuitarFusion" data-backdrop="static" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
                    <form id="formQuitarFusion"> 
                        <div class="modal-body">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-1 text-center">
                                <h4>Seleccione los lotes a eliminar de la fusión</h4>
                            </div>
                            <br>
                            <div id="lotesFusiones2">

                            </div><br>
                        </div><br>
                        <div class="modal-footer"><br><br><br>
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                            <button type="submit"  class="btn btn-primary">Aceptar</button>
                        </div>
                    </form>
				</div>
			</div>
		</div>
        <div class="modal fade" id="modalDropFusion" data-backdrop="static" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form id="formDesFusion">
                        <input id="pvLote" name="pvLote"  hidden readonly />
                        <div class="modal-body">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-1 text-center">
                                <h4><b style='color:red;'>¡Atención!</b></h4>
                            </div>
                            <br>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-1 text-center">
                                <div>
                                    <h4>¿Esta seguro que quiere deshacer la fusión de los siguientes lotes?</h4>
                                </div>
                            </div>
                            <div id="lotesFusiones">
                            </div><br>
                        </div><br>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-1 text-center">
                            <!-- espacio en blanco -->
                        </div>
                        <div class="modal-footer"><br><br><br>
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Aceptar</button>
                        </div>
                    </form>
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
                                    <h3 class="card-title center-align">Asignación de cartera</h3>
                                    <p class="card-title pl-1"></p>
                                </div>
                                <div class="material-datatables">
                                    <table id="tablaAsignacionCartera" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th></th>
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
                                                <th>ASIGNADO A</th>
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
<script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/reestructura/asignacionCartera.js"></script>