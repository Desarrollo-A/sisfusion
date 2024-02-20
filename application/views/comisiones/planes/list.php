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
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla_planes_comisiones" name="tabla_planes_comisiones">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID</th>
                                                    <th>nombre</th>
                                                    <th>ACTUALIZADO</th>
                                                    <th>PRIORIDAD</th>
                                                    <th>ESTADO</th>
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

        <div id="plan-modal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header d-flex d-wrap"> 
                        <h4 class="modal-title" ><b class="text-center">Plan de comision</b></h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="col-md-6 col-lg-3">
                                <label for="nombre" class="control-label">Nombre del plan</label>
                                <input class="form-control input-gral" type="text" id="nombre" name="nombre" placeholder="Nombre" />
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label for="estatus" class="control-label">Activo</label>
                                <input type="text" class="form-control input-gral" id="estatus" name="estatus" placeholder="Activo" />
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label for="fechaInicio" class="control-label label-gral">Fecha de inicio</label>
                                <input type="text" class="form-control input-gral datepicker fechaInicio" name="fechaInicio" id="fechaInicio" placeholder="Fecha de inicio" />
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label for="fechaFin" class="control-label label-gral">Fecha de termino</label>
                                <input type="text" class="form-control input-gral datepicker fechaInicio" name="fechaFin" id="fechaFin" placeholder="Fecha de termino" />
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label for="sede" class="control-label label-gral">Sede</label>
                                <select class="selectpicker select-gral" id="sede" name="sede" ></select>
                            </div>
                            <span class="col-md-12 modal-title">Esquema de comisiones</span>
                            <div class="col-md-12">
                                <label class="col-md-4 control-label">Puesto</label>
                                <label class="col-md-4 control-label">Porcentaje</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <input class="form-control input-gral" type="text" value="Director comercial" />
                            </div>
                            <div class="col-md-4">
                                <input class="form-control input-gral" type="number" value="1" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <input class="form-control input-gral" type="text" value="Gerente" />
                            </div>
                            <div class="col-md-4">
                                <input class="form-control input-gral" type="number" value="1" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <input class="form-control input-gral" type="text" value="Coordinador de ventas" />
                            </div>
                            <div class="col-md-4">
                                <input class="form-control input-gral" type="number" value="1" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <input class="form-control input-gral" type="text" value="Subdirector" />
                            </div>
                            <div class="col-md-4">
                                <input class="form-control input-gral" type="number" value="1" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <input class="form-control input-gral" type="text" value="Asesor" />
                            </div>
                            <div class="col-md-4">
                                <input class="form-control input-gral" type="number" value="1" />
                            </div>
                        </div>
                        <div id="usuarios_plan_comisiones"></div>
                        <div class="col-md-12">
                            <span>Añadir usuario comisionando</span>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="id_usuario" class="control-label label-gral">ID del usuario</label>
                                <input class="form-control input-gral" type="number" id="id_usuario" name="id_usuario" />
                            </div>
                            <div class="col-md-4">
                                <button id="btn_abonar" class="btn btn-primary" onclick="addUsuarioPlanComision()">Añadir</button>
                            </div>
                        </div>
                    </div>
                    <div id="mBody" class="modal-body pr-0 ml-4"></div>
                    <div class="modal-footer"><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="console.log('hide planes modal')">Cerrar</button></div>
                </div>
            </div>
        </div>

        <?php $this->load->view('template/footer_legend');?>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/planes/table.js"></script>
</body>