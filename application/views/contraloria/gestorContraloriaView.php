<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>
        <div class="modal fade" id="modal" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="titulo"></h4>
                    </div>
                    <div class="modal-body">
                        <row>
                            <div id="divNombre">
                                <div class="form-group m-0 overflow-hidden">
                                    <label class="control-label" for="proyecto">Nombre</label>
                                    <input type="text" class="form-control input-gral" id="nombre">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" id="divConfirmacion">
                                <div class="form-group m-0 overflow-hidden">
                                    <h6 id="confirmacion"></h6>
                                </div>
                            </div>                            
                        </row>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="btnAgregar" class="btn btn-primary"></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalConfirmarCambio" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center">Confirmar cambio de estatus</h4>
                    </div>
                    <div class="modal-body">
                        <row>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                <div class="form-group m-0 overflow-hidden">
                                    <h6 id="confirmarCambioEstatus"></h6>
                                </div>
                            </div>
                        </row>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="btnConfirmarCambio" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalCambioRL" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="titulo">Editar Representante Legal</h4>
                    </div>
                    <div class="modal-body">
                        <row>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group m-0 overflow-visible">
                                    <label class="control-label" for="nombreLote">Opciones</label>
                                    <select class="selectpicker select-gral" id="selectorCambioRL" title="SELECCIONA UNA OPCIÓN"></select>
                                </div>
                            </div>                            
                        </row>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="btnActualizarRL" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalmodelo" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="titulomodelo"></h4>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div id="divNombreModelo">
                                <div class="form-group m-0 overflow-hidden">
                                    <label class="control-label" for="nombreModelo">Nombre del modelo</label>
                                    <input type="text" class="form-control input-gral" id="nombreModelo" pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios">
                                </div>
                            </div>
                            <div id="divSuperficie">
                                <div class="form-group m-0 overflow-hidden">
                                    <label class="control-label" for="superficie">Superficie</label>
                                    <input type="number" class="form-control input-gral" id="superficie" placeholder="Ingrese solo datos númericos" oninput="this.value = this.value.replace(/[^0-9.]/g, '')">
                                </div>
                            </div>
                            <div id="divCosto">
                                <div class="form-group m-0 overflow-hidden">
                                    <label class="control-label" for="costo">Costo</label>
                                    <input type="number" class="form-control input-gral" id="costo" placeholder="Ingreso solo datos númericos" oninput="this.value = this.value.replace(/[^0-9.]/g, '')">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" id="divConfirmacionModelo">
                                <div class="form-group m-0 overflow-hidden">
                                    <h6 id="confirmacion"></h6>
                                </div>
                            </div>          
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="btnAgregarCasa" class="btn btn-primary"></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN Agrega modelos casa-->
        <!--INICIO DEL CONTENIDO DE LA PÁGINA -->
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-user-cog fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Gestor Contraloría</h3>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <label class="control-label" for="nombreLote">Opciones</label>
                                        <select class="selectpicker select-gral" id="selector" title="SELECCIONA UNA OPCIÓN"></select>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 hide" id="divBusquedaLote">
                                        <label class="control-label" for="nombreLote">Buscar Lote</label>
                                        <div class="form-inline toolbar">
                                            <input type="text" class="form-control text-center beginDate" placeholder="NOMBRE LOTE" id="nombreLote" />
                                            <button class="btn btn-fab btn-fab-mini" onclick="llenarTablaCambioRL(3)"><span class="material-icons">search</span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables col-xs-12 col-sm-12 col-md-12 col-lg-12 hide" id="divTablaRL">
                                    <table id="gestorContraloria" name="gestorContraloria" class="table-striped table-hover nowrap">
                                        <thead>
                                            <tr>                                               
                                                <th>ID</th>
                                                <th>NOMBRE</th>
                                                <th>ESTATUS</th>
                                                <th>FECHA DE CREACIÓN</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="material-datatables col-xs-12 col-sm-12 col-md-12 col-lg-12 hide" id="divTablaIntercambio">
                                    <table id="tablaIntercambios" name="tablaIntercambios" class="table-striped table-hover nowrap">
                                        <thead>
                                            <tr>                                               
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>ID LOTE</th>
                                                <th>REFERENCIA</th>
                                                <th>ESTATUS</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="material-datatables col-xs-12 col-sm-12 col-md-12 col-lg-12 hide" id="divTablaCambioRL">
                                    <table id="tablaCambioRL" name="tablaCambioRL" class="table-striped table-hover nowrap">
                                        <thead>
                                            <tr>                                               
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>ID LOTE</th>
                                                <th>REFERENCIA</th>
                                                <th>REPRESENTANTE LEGAL</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="material-datatables col-xs-12 col-sm-12 col-md-12 col-lg-12 hide" id="divmodelosTable">
                                    <div class="table-responsive">
                                        <table class="table-striped table-hover" id="modelosTable" name="modelosTable">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>MODELO</th>
                                                    <th>SUPERFICIE</th>
                                                    <th>COSTO</th>
                                                    <th>ESTATUS</th>
                                                    <th>ACCIONES</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            <!-- FIN TABLA MODELOS DE CASAS-->
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
<script src="<?= base_url() ?>dist/js/controllers/contraloria/gestorContraloria.js"></script>