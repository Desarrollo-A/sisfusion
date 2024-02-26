<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <?php $this->load->view('complementos/estilos_extra'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-chart-pie fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Planes de comision</h3>
                                </div>
                                    <p class="card-title pl-1 center-align">
                                        Los planes se ejecutaran en el orden que se ve en la tabla.<br>
                                        Puede bajar y subir la piroridad de cada plan.<br>
                                        Menor numero significa mayor prioridad.
                                    </p>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla_planes_comisiones" name="tabla_planes_comisiones">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID</th>
                                                    <th>nombre</th>
                                                    <th>ACTUALIZADO</th>
                                                    <th>ESTADO</th>
                                                    <th>PRIORIDAD</th>
                                                    <th>cambiar PRIORIDAD</th>
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

        <div id="ask-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex d-wrap"> 
                        <h4 class="modal-title" ><b id="title-ask-modal" class="text-center"></b></h4>
                    </div>
                    <div class="modal-body">
                        <span id="text-ask-modal"></span>
                    </div>
                    <div class="modal-footer">
                        <button id="cancel-button-ask-modal" type="button" class="btn btn-danger btn-simple" data-dismiss="modal" >No</button>
                        <button id="ok-button-ask-modal" type="button" class="btn btn-info btn-simple" >Si</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="alert-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex d-wrap"> 
                        <h4 class="modal-title" ><b id="title-alert-modal" class="text-center"></b></h4>
                    </div>
                    <div class="modal-body">
                        <span id="text-alert-modal"></span>
                    </div>
                    <div class="modal-footer">
                        <button id="cancel-button-alert-modal" type="button" class="btn btn-danger btn-simple" data-dismiss="modal" >Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="plan-modal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header d-flex d-wrap"> 
                        <h4 class="modal-title" ><b class="text-center">Plan de comision</b></h4>
                    </div>
                    <div class="modal-body">
                        <form id="form-plan-modal" onsubmit="event.preventDefault()">
                            <input type="hidden" id="idPlan" name="idPlan" />

                            <div class="col-md-12">
                                <div class="col-md-6 col-lg-3">
                                    <label for="nombre" class="control-label">Nombre</label>
                                    <input class="form-control input-gral" type="text" id="nombre" name="nombre" placeholder="NOMBRE DEL PLAN" />
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label for="estatus" class="control-label label-gral">Activo</label>
                                    <select name="estatus" id="estatus" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" title="Selecciona una opción" data-container="body">
                                        <option value="1">SI</option>
                                        <option value="0">NO</option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label for="fechaInicio" class="control-label label-gral">inicio</label>
                                    <input type="text" class="form-control input-gral datepicker fechaInicio" name="fechaInicio" id="fechaInicio" placeholder="FECHA DE INICIO" />
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label for="fechaFin" class="control-label label-gral">Termino</label>
                                    <input type="text" class="form-control input-gral datepicker fechaFin" name="fechaFin" id="fechaFin" placeholder="FECHA DE TERMINO" />
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label for="sedes" class="control-label label-gral">Sede</label>
                                    <select name="sedes" id="sedes" multiple="multiple" class="selectpicker select-gral mt-2" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-container="body"></select>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label for="residencial" class="control-label label-gral">Residencial</label>
                                    <select name="residencial" id="residencial" multiple="multiple" class="selectpicker select-gral mt-2" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-container="body"></select>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label for="lotes" class="control-label label-gral">Lotes</label>
                                    <input id="lotes" name="lotes" class="form-control input-gral" type="text" placeholder="IDS DE LOS LOTE, SEPARADOS POR COMA" />
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label for="prospeccion" class="control-label label-gral">Lugar de prospeccion</label>
                                    <select name="prospeccion" id="prospeccion" multiple="multiple" class="selectpicker select-gral mt-2" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-container="body"></select>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label for="prioridad" class="control-label label-gral">Prioridad</label>
                                    <input id="prioridad" name="prioridad" class="form-control input-gral" type="number" value="0" placeholder="PRIORIDAD DE EJECUCION" />
                                </div>
                            </div>
                            <span class="col-md-12">Esquema de comisiones</span>
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <label class="col-md-4 control-label">Puesto</label>
                                    <label class="col-md-4 control-label">Porcentaje</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <input class="form-control input-gral" type="text" value="Director comercial" readonly />
                                </div>
                                <div class="col-md-4">
                                    <input id="comision_director" name="comision_director" class="form-control input-gral" type="number" value="1" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <input class="form-control input-gral" type="text" value="Gerente regional" readonly />
                                </div>
                                <div class="col-md-4">
                                    <input id="comision_regional" name="comision_regional" class="form-control input-gral" type="number" value="1" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <input class="form-control input-gral" type="text" value="Subdirector" readonly />
                                </div>
                                <div class="col-md-4">
                                    <input id="comision_subdirector" name="comision_subdirector" class="form-control input-gral" type="number" value="1" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <input class="form-control input-gral" type="text" value="Gerente" readonly />
                                </div>
                                <div class="col-md-4">
                                    <input id="comision_gerente" name="comision_gerente" class="form-control input-gral" type="number" value="1" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <input class="form-control input-gral" type="text" value="Coordinador de ventas" readonly />
                                </div>
                                <div class="col-md-4">
                                    <input id="comision_coordinador" name="comision_coordinador" class="form-control input-gral" type="number" value="1" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <input class="form-control input-gral" type="text" value="Asesor" readonly />
                                </div>
                                <div class="col-md-4">
                                    <input id="comision_asesor" name="comision_asesor" class="form-control input-gral" type="number" value="1" />
                                </div>
                            </div>
                            <div id="usuarios_plan_comisiones"></div>
                            <span class="col-md-12">Añadir usuario comisionando</span>
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label for="id_usuario" class="control-label label-gral">ID del usuario</label>
                                    <input class="form-control input-gral" type="number" id="id_usuario" name="id_usuario" />
                                </div>
                                <div class="col-md-4">
                                    <button type="button" id="btn_add_usuario_comision" class="btn btn-primary" >Buscar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" >Cerrar</button>
                        <button id="ok-button-plan-modal" type="button" class="btn btn-danger btn-simple" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('template/footer_legend');?>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/planes/table.js"></script>
</body>