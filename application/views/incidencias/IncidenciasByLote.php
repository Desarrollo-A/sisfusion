<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<style>
hr {
  display: block;
  height: 1px;
  border: 0;
  border-top: 1px solid #ccc;
  margin: 1em 0;
  padding: 0;
}
.tableAsesorOld tr:nth-child(even) {
  background-color: #f9f9f9;
}
.tableAsesorOld>tbody>tr>td{
    border: none;
}
.tableAsesorOld>th, td {
  padding: 15px;
}
</style>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade modal-alertas" id="modal_sedes" name="modal_sedes" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header ">
                        <h4 class="card-title text-center"><b>Cambio de sedes</b></h4>
                    </div>
                    <form method="post" id="form_sede">

                        <div class="modal-body">
                            <div class="tituloLote" id="tituloLote" ></div>
                            <div class="form-group" >
                                <label class="control-label">Selecciona una opción </label>
                                <select id="sedesCambio" name="sedesCambio" 
                                class="selectpicker select-gral sedesNuevo" 
                                title="SELECCIONA UNA OPCIÓN"
                                required data-live-search="true">
                                <?php foreach($sedes as $sede){ ?>>
                                    <option value="<?= $sede->id_sede ?>"> <?= $sede->nombre  ?> </option>
                                <?php  }  ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">  
                            <button type="button" class="btn btn-danger btn-simple " data-dismiss="modal">
                                CANCELAR
                            </button>
                            <button type="submit" class="btn btn-primary" value="ACEPTAR">
                                ACEPTAR
                            </button>
            			</div>
                    
                    </form>
                
                </div>
            </div>
        </div>
       
        <div class="modal fade modal-alertas" id="modal_pagadas" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header ">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons">clear</i>
                    </button>   
                    </div>
                    <form method="post" id="form_pagadas">
                        <div class="modal-body"></div>
                        <div class="modal-footer">  
            				</div>
                    </form>
                
                </div>
            </div>
        </div>

        <!-- Modal cambio de plan de comision -->

        <div class="modal fade modal-alertas" id="modal_comision" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header ">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>   
                    </div>
                    <form method="post" id="form_comision">
                        <div class="form-group" id="select_planes"></div>
                    
                        <div class="modal-body">
                            <div id="titulos"> 
                            </div>

                            <select class="selectpicker select-gral m-0" data-style="btn"title="SELECCIONA UNA OPCIÓN" required data-live-search="true"name="plan_comision" id="plan_comision"> 
                                <label  class="label">Seleccionar plan de comisión</label>
                            </select>
            
                            <input type="hidden" name="cliente" id="cliente">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple " data-dismiss="modal"> CANCELAR</button>
                            
                            <button type="submit" class="btn btn-primary" value="ACEPTAR" style="15px" id="boton">ACEPTAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas"  id="modal_NEODATA" style="overflow:auto !important;" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form method="post" id="form_NEODATA">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas"  id="modal_inventario" style="overflow:auto !important;" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form method="post" id="form_i">
                        <div class="seleccionar"></div>
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas"  id="addEmpresa" style="overflow:auto !important;" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-red">  
                    </div>
                    <form method="post" id="form_empresa">
                        <div class="modal-body">
                            <input type="hidden" name="idLoteE" readonly="true" id="idLoteE" >
                            <input type="hidden" name="idClienteE" readonly="true" id="idClienteE" >
                            <input type="hidden" name="PrecioLoteE" readonly="true" id="PrecioLoteE" >
                            <h4>¿Esta seguro que desea agregar empresa?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="btn_add" class="btn btn-primary" value="GUARDAR">ACEPTAR</button>
                            <button type="button" class="btn btn-danger btn-simple"  data-dismiss="modal" value="CANCELAR"> CANCELAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                                <?php 
                                $id_rol = $this->session->userdata('id_rol');
                                if($id_rol == 11){
                                    echo '<li role="presentation"><a href="#tab_asignacion" aria-controls="tab_asignacion" role="tab" data-toggle="tab"
                                        onclick="fill_data_asignacion();">Asignación</a>
                                    </li>';
                                }
                                ?>
                                <li role="presentation" class="hide" id="li_individual_sales">
                                    <a href="#salesOfIndividuals" aria-controls="salesOfIndividuals" role="tab" 
                                    data-toggle="tab">Clausulas</a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="changeprocesTab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content">
                                                    <table id="verDet" class="table table-bordered table-hover" width="100%" style="text-align:center;">
                                                        <thead>
                                                            <tr>
                                                                <th>Lote</th>
                                                                <th>Status</th>
                                                                <th>Detalles</th>
                                                                <th>Comentario</th>
                                                                <th>Fecha</th>
                                                                <th>Usuario</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Lote</th>
                                                                <th>Status</th>
                                                                <th>Detalles</th>
                                                                <th>Comentario</th>
                                                                <th>Fecha</th>
                                                                <th>Usuario</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
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
                                                    <table id="verDetBloqueo" class="table table-bordered table-hover" width="100%" style="text-align:center;">
                                                        <thead>
                                                            <tr>
                                                                <th>Lote</th>
                                                                <th>Precio</th>
                                                                <th>Fecha Liberación</th>
                                                                <th>Comentario Liberación</th>
                                                                <th>Usuario</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Lote</th>
                                                                <th>Precio</th>
                                                                <th>Fecha Liberación</th>
                                                                <th>Comentario Liberación</th>
                                                                <th>Usuario</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
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
                                                    <table id="seeCoSellingAdvisers" class="table table-bordered table-hover" width="100%" style="text-align:center;">
                                                        <thead>
                                                            <tr>
                                                                <th>Asesor</th>
                                                                <th>Coordinador</th>
                                                                <th>Gerente</th>
                                                                <th>Fecha alta</th>
                                                                <th>Usuario</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Asesor</th>
                                                                <th>Coordinador</th>
                                                                <th>Gerente</th>
                                                                <th>Fecha alta</th>
                                                                <th>Usuario</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tab_asignacion">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content">
                                                    <div class="form-group">
                                                        <label for="des">Desarrollo</label>
                                                        <select name="sel_desarrollo" id="sel_desarrollo" class="selectpicker" 
                                                        data-style="btn btn-second" data-show-subtext="true" 
                                                        data-live-search="true"  title="" data-size="7" required>
                                                            <option disabled selected>Selecciona un desarrollo</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group"></div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="check_edo">
                                                        <label class="form-check-label" for="check_edo">Intercambio</label>
                                                    </div>
                                                    <div class="form-group text-right">
                                                        <button type="button" id="save_asignacion" class="btn btn-primary">ENVIAR</button>
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
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_avisos" style="overflow-y: scroll;" style="overflow:auto !important;" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" style="font-size: 20px;top:20px;" class="close" data-dismiss="modal">
                            <i class="large material-icons">close</i>
                        </button>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_avisitos" style="overflow-y: scroll;"style="overflow:auto !important;" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" style="font-size: 20px;top:20px;" class="close" type="button" data-dismiss="modal">
                            <i class="large material-icons">close</i>
                        </button>
                    <h4 class="modal-title" >Cambiar usuario</h4>
                        
                    </div>
                    <div class="modal-body"> 
                    
                        <div class="form-group">        
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 overflow-hidden" >
                                    <select class="selectpicker select-gral ng-invalid ng-invalid-required"
                                    data-container="body"
                                    data-style="btn"
                                    data-cliente=""
                                    data-lote=""
                                    title="SELECCIONA UNA OPCIÓN" required data-live-search="true"
                                    name="opcion" 
                                    onchange="selectOpcion()" id="opcion" >
                                        <option value="1">Cliente</option>
                                        <option value="2">Venta compartida</option>
                                        <option value="3">Cambiar roles (Con comisiones)</option>
                                        <option value="4">Cambiar tipo de venta</option>

                                    </select>
                                    <input type="hidden" class="form-control"
                                    id="lotes1" name="lotes1">
                                    <input type="hidden" class="form-control"
                                    id="clientes2" name="clientes2">
                                    <input type="hidden" class="form-control"
                                    id="proceso" name="proceso">
                                    <input type="hidden" class="form-control"
                                    id="precioLote" name="precioLote">
                                    <input type="hidden" class="form-control"
                                    id="ventaCompartida" name="ventaCompartida">
                                </div> 
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_cambio_rol" style="overflow-y: scroll;" style="overflow:auto !important;" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                        <!-- formulario -->
                    <form method="post" id="form_roles">
                        <div class="modal-header">
                            <button type="button" style="font-size: 20px;top:20px;" class="close" type="button" data-dismiss="modal">
                                <i class="large material-icons">close</i>
                            </button>
                            <h4 class="modal-title">CAMBIO DE ROL</h4>
                        </div>

                        <div class="modal-body">
                            <div class="col-md-12">
                                <div class="form-group" id="lista_usuarios">
                                    <label class="label">USUARIOS</label>
                                    <select class="selectpicker select-gral descuento ng-invalid ng-invalid-required" title="SELECCIONA UNA OPCIÓN" name="select_usuarios" id="select_usuarios" required></select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group is-empty" id="rol">
                                    <label class="label">ROL ACTUAL DEL USUARIO</label>
                                    <input class="form-control input-gral" type="text" name="rol_usuario" id="rol_usuario" readonly></input>
                                </div>
                            </div>
                                
                            <div class="col-md-12">
                                <div class="form-group" id="cambiar_usuarios">
                                    <label class="label">NUEVO ROL</label>
                                    <select class="selectpicker select-gral descuento ng-invalid ng-invalid-required" title="SELECCIONA UNA OPCIÓN" name="select_roles" id="select_roles" required></select>
                                    </div>
                                </div>
                        </div>

                        <div class="modal-footer">
                            <label class="control-label"  >
                                Cualquier cambio realizado será registrado con la sesión
                            </label>
                            <button class=" btn btn-danger btn-simple" type="button" data-dismiss="modal">CANCELAR</button>
                            <button type="submit" id="btn_rol" class="btn btn-primary">GUARDAR</button>
                        </div>    
                       
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_add_user" style="overflow-y: scroll;" style="overflow:auto !important;" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                        <!-- formulario -->
                    <form method="post" id="form_add_users">
                        <div class="modal-header">
                            <button type="button" style="font-size: 20px;top:20px;" class="close" type="button" data-dismiss="modal">
                                <i class="large material-icons">close</i>
                            </button>
                            <h4 class="modal-title">AGREGAR USUARIO</h4>
                        </div>

                        <div class="modal-body">
                            <div class="col-md-12">
                                <div class="form-group overflow-hidden" id="add_usuario">
                                    <label class="label">USUARIOS</label>
                                    <select class="selectpicker select-gral descuento ng-invalid ng-invalid-required" title="SELECCIONA UNA OPCIÓN" name="agregar_usuario" id="agregar_usuario" required data-live-search="true" data-container="body"></select>
                                </div>
                            </div>

                        <div class="col-md-12">
                            <div class="form-group is-empty" id="add_rol">
                                <label class="label">PORCENTAJE DE COMISIÓN</label>
                                <input class="form-control input-gral" type="number" name="porcentaje" id="porcentaje" required min="0.04" max="4" step="0.01" placeholder="0.0"></input>
                            </div>
                        </div>

                            <div class="col-md-12">
                                <div class="form-group" id="cambiar_usuarios">
                                    <label class="label">ROL PARA EL USUARIO</label>
                                    <select class="selectpicker select-gral descuento ng-invalid ng-invalid-required" title="SELECCIONA UNA OPCIÓN" name="agregar_roles" id="agregar_roles" required></select>
                                </div>
                            </div>
                            
                        </div>
                    
                        <div class="modal-footer">
                            <button class=" btn btn-danger btn-simple" type="button" data-dismiss="modal">CANCELAR</button>
                            <button type="submit" id="btn_add_user" class="btn btn-primary">GUARDAR</button>
                        </div>    
                       
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="myUpdateBanderaModal" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <form method="post" id="my_updatebandera_form">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_add" style="overflow-y: scroll;" style="overflow:auto !important;" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <form method="post" id="form_add">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_quitar" style="overflow-y: scroll;" style="overflow:auto !important;" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <form method="post" id="form_quitar">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="miModalCeder" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <h4 class="card-title text-center"><b>Ceder comisiones</b></h4>
                    </div>
                    <form method="post" id="form_ceder">
                        <div class="modal-body pt-0">
                            <div class="form-group m-0">
                                <label class="control-label">Asesor dado de baja</label>
                                <select name="asesorold" id="asesorold" class="selectpicker select-gral" 
                                title="SELECCIONA UNA OPCIÓN"
                                data-style="btn " data-show-subtext="true" data-live-search="true" 
                                title="Selecciona un usuario" data-size="7" required>
                                </select>
                            </div>
                            <div id="info" class="text-center"></div>
                            <div class="form-group mt-0">
                                <label class="control-label">Puesto del usuario a ceder la comisiones</label>
                                <select class="selectpicker select-gral roles2" 
                                    name="roles2" id="roles2" required
                                 title="SELECCIONA UNA OPCIÓN" required data-live-search="true">
                                    <option value="7">Asesor</option>
                                    <option value="9">Coordinador</option>
                                    <option value="3">Gerente</option>
                                </select> 
                            </div>
                            <div class="form-group mt-0" id="users">
                                <label class="control-label">Usuario a ceder comisiones</label>
                                <select id="usuarioid2" name="usuarioid2" class="selectpicker directorSelect select-gral"
                                title="SELECCIONA UNA OPCIÓN" 
                                 required data-live-search="true"></select>
                            </div>
                            <div class="form-group mt-0">
                                <label class="control-label">Descripción</label>
                                <textarea id="comentario" name="comentario" class="text-modal" rows="3" 
                                 required="required"></textarea>
                            </div>
                            <div class="form-group">
                             
                            </div>
                        </div>
                        
                        <div class="modal-footer">     
                            <button class="btn btn-danger btn-simple" type="button" data-dismiss="modal" >CANCELAR</button>
                            <button type="submit" id="btn_ceder" class="btn btn-primary">ACEPTAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="miModalInventario" style="overflow:auto !important;" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <h4 class="card-title text-center"><b>Actualizar inventario</b></h4>
                    </div>
                    <form method="post" id="form_inventario" >
                        <div class="modal-body">
                            <div class="invent"></div>
                            <div class="form-group">
                                <label class="control-label">Puesto del usuario a modificar</label>
                                <select class="selectpicker select-gral roles3"  name="roles3" 
                                    id="roles3" required
                                    title="SELECCIONA UNA OPCIÓN" required data-live-search="true">
                                    <option value="7">Asesor</option>
                                    <option value="9">Coordinador</option>
                                    <option value="3">Gerente</option>
                                    <option value="2">Sub director</option>
                                    <option value="59">Regional</option>
                                </select>
                                <p id="UserSelect"></p>
                            </div>
                            <div class="form-group m-0" id="users">
                                <label class="control-label">Seleccionar usuario</label>
                                <select id="usuarioid3" name="usuarioid3" 
                                class="selectpicker select-gral directorSelect " 
                                title="SELECCIONA UNA OPCIÓN" 
                                required data-live-search="true"></select>
                            </div>      
                            <p id="UserSelectDirec"></p>                
                            <div class="form-group">
                                <label class="control-label">Descripción</label>
                                <textarea id="comentario3" name="comentario3" 
                                class="text-modal" rows="3"
                                 required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-simple" type="button" data-dismiss="modal" >CANCELAR</button>
                            <button type="submit" id="btn_inv" class="btn btn-primary">ACEPTAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="miModalVc" style="overflow:auto !important;" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <h4 class="card-title text-center"><b>Actualizar venta compartida</b></h4>
                    </div>
                    <form method="post" id="form_vc" >
                        <div class="modal-body">
                            <div class="vc"></div>
                            <div class="form-group m-0">
                                <label class="control-label">Puesto del usuario a modificar</label>
                                    <select class="selectpicker select-gral rolesvc" 
                                    name="rolesvc" id="rolesvc" required
                                 title="SELECCIONA UNA OPCIÓN" required data-live-search="true">
                                    <option value="7">Asesor</option>
                                    <option value="9">Coordinador</option>
                                    <option value="3">Gerente</option>
                                </select>
                                <p id="UserSelectvc"></p>
                            </div>
                            <div class="form-group m-0" id="users">
                                <label class="control-label">Seleccionar usuario</label>
                                <select id="usuarioid4" name="usuarioid4" 
                                class="selectpicker select-gral directorSelect" 
                                title="SELECCIONA UNA OPCIÓN"
                                required data-live-search="true"></select>
                            </div>
                            <div class="form-group m-0">
                                <label class="control-label">Descripción</label>
                                <textarea id="comentario4" name="comentario4" class="text-modal"
                                 rows="3" required="required"></textarea>
                            </div>
                            <div class="form-group">
                              
                            </div>
                        </div>
                        <div class="modal-footer">     
                                <button class="btn btn-danger btn-simple " type="button" data-dismiss="modal" >CANCELAR</button>
                                <button type="submit" id="btn_vc" class="btn btn-primary" >ACEPTAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modalBajaVc" id="modalBajaVc" style="overflow:auto !important;" role="dialog" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <h3 class="card-title text-center"><b>Baja de venta compartida</b></h3>
                    </div>
                    <div class="modal-body text-center">
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div> 
        </div>

        <div class="modal fade modalBajaVcUpdate" id="modalBajaVcUpdate" style="overflow:auto !important;" role="dialog" data-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="miModalVcNew" style="overflow:auto !important;" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red col-md-12">
                        <h4 class="card-title"><b>Agregar venta compartida</b></h4>
                    </div>
                    <form method="post" id="form_vcNew" class="form-group">
                        <div class="modal-body">
                            <div class="vcnew"></div>
                            <div class="container-fluid">
                                <div class="row">

                                <div class="row" id="users5">
                                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 overflow-hidden">
                                        <label class="control-label">Asesor</label>
                                        <select id="elegir_asesor" name="elegir_asesor" class="selectpicker select-gral ng-invalid ng-invalid-required " required data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-container="body">
                                        </select>
                                    </div>
                                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 overflow-hidden">
                                            <button data-toggle="tooltip" data-placement="top" type="button" class="btn-data btn-sky boton_usuario" style="margin-top: 40px;" data-target="select5" title="Agregar asesor"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>

                                    <div class="row" id="users6">
                                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 overflow-hidden">
                                            <label class="control-label">Coordinador</label>
                                            <select id="elegir_coordinador" name="elegir_coordinador" class="selectpicker select-gral ng-invalid ng-invalid-required coor " data-live-search="true" required title="SELECCIONA UNA OPCIÓN" data-container="body">
                                                <option value="0">NO CONTARÁ CON COORDINADOR</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 overflow-hidden">
                                            <button data-toggle="tooltip" data-placement="top" type="button" class="btn-data btn-sky boton_usuario" style="margin-top: 40px;" data-target="select1" title="Agregar coordinador"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <div class="row" id="users7">
                                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 overflow-hidden">
                                            <label class="control-label">Gerente</label>
                                            <select id="elegir_gerente" name="elegir_gerente" class="selectpicker  select-gral ng-invalid ng-invalid-required ger " required data-live-search="true" title="SELECCIONA UNA OPCIÓN"  data-container="body"></select>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 overflow-hidden">
                                            <button data-toggle="tooltip" data-placement="top" type="button" class="btn-data btn-sky boton_usuario" style="margin-top: 40px;" data-target="select2" title="Agregar gerente"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>

                                    <div class="row" id="users8">
                                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 overflow-hidden">
                                            <label class="control-label">Subdirector</label>
                                            <select id="elegir_subdirector" name="elegir_subdirector" class="selectpicker  select-gral ng-invalid ng-invalid-required sub " required data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-container="body"></select>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 overflow-hidden">
                                            <button data-toggle="tooltip" data-placement="top" type="button" class="btn-data btn-sky boton_usuario" style="margin-top: 40px;" data-target="select3" title="Agregar subdirector"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>

                                    <div class="row" id="users9">
                                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 overflow-hidden">
                                            <label class="control-label">Director Regional</label>
                                            <select id="elegir_diRegional" name="elegir_diRegional" class="selectpicker  select-gral ng-invalid ng-invalid-required diReg " required data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-container="body">
                                                <option value="0">NO CONTARÁ CON DIRECTOR REGIONAL</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 overflow-hidden">
                                            <button data-toggle="tooltip" data-placement="top" type="button" class="btn-data btn-sky boton_usuario" style="margin-top: 40px;" data-target="select4" title="Agregar subdirector"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">     
                            <button class="btn btn-danger btn-simple" type="button" data-dismiss="modal" >CANCELAR</button>
                            <button type="submit" id="btn_vcnew" class="btn btn-primary">ACEPTAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_coordinador" style="overflow-y: scroll;" style="overflow:auto !important;" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form method="post" id="agregar_lider">
                        <div class="modal-header">
                            <button type="button" style="font-size: 20px;top:20px;" class="close" type="button" data-dismiss="modal">
                                <i class="large material-icons">close</i>
                            </button>
                            <h4 class="modal-title" id="titulo_modal_cordi"></h4>
                        </div>

                        <div class="modal-body">
                            <div class="">
                                <div class="form-group" id="form_opcion_roles">
                                    <label class="label">PUESTO ACTUAL DEL USUARIO</label>
                                    <select class="selectpicker select-gral  ng-invalid ng-invalid-required" title="SELECCIONA UNA OPCIÓN" name="puesto_usuario" id="puesto_usuario" required data-live-search="true">
                                    <option value="2">SUBDIRECTOR / DIRECTOR REGIONAL</option>
                                    <option value="3">GERENTE</option>
                                    <option value="9">COORDINADOR</option>
                                    <option value="7">ASESOR</option>
                                    </select>
                                </div>
                            </div>
                            <div class="">
                                <div class="form-group" id="input_coordinador">
                                    <label class="label">USUARIOS</label>
                                    <select class="selectpicker select-gral  ng-invalid ng-invalid-required" title="SELECCIONA UNA OPCIÓN" name="add_coordinador" id="add_coordinador" data-live-search="true" required></select>
                                </div>
                            </div>

                            <div class="">
                                <div class="form-group" id="input_gerente">
                                    <label class="label">USUARIOS</label>
                                    <select class="selectpicker select-gral  ng-invalid ng-invalid-required" title="SELECCIONA UNA OPCIÓN" name="add_gerente" id="add_gerente" data-live-search="true" required></select>
                                </div>
                            </div>

                            <div class="">
                                <div class="form-group" id="input_subdirector">
                                    <label class="label">USUARIOS</label>
                                    <select class="selectpicker select-gral ng-invalid ng-invalid-required" title="SELECCIONA UNA OPCIÓN" name="add_subdirector" id="add_subdirector" data-live-search="true" required></select>
                                </div>
                            </div>

                            <div class="">
                                <div class="form-group" id="input_asesor">
                                    <label class="label">USUARIOS</label>
                                    <select class="selectpicker select-gral ng-invalid ng-invalid-required" title="SELECCIONA UNA OPCIÓN" name="add_subdirector" id="add_asesor" data-live-search="true" required></select>
                                </div>
                            </div>

                        </div>
                    
                        <div class="modal-footer">
                            <button class=" btn btn-danger btn-simple" type="button" data-dismiss="modal">CANCELAR</button>
                            <button type="submit" id="boton_vCompartida" class="btn btn-primary">GUARDAR</button>
                        </div>    
                       
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_vCompartida" style="overflow-y: scroll;" style="overflow:auto !important;" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" style="font-size: 20px;top:20px;" class="close" type="button" data-dismiss="modal">
                                <i class="large material-icons">close</i>
                            </button>
                            <h4 class="modal-title">ACCIONES EN VENTA COMPARTIDA</h4>
                            
                        </div>

                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">    
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-1 overflow-hidden">
                                        <button type="button" class="btn-gral-data" data-toggle="modal" id="editar_venta_compartida" >EDITAR VENTA COMPARTIDA</button>
                                     </div>
                                     <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-1 overflow-hidden">
                                        <button type="button" class="btn-gral-data " data-toggle="modal" id="agregar_venta_compartida">AGREGAR VENTA COMPARIDA</button>
                                     </div>
                                    
                                </div>    
                            </div>
                            
                            
                        </div>
                    
                        <div class="modal-footer">
                            
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
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Panel de incidencias</h3>
                                <div class="toolbar">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <button class="btn-gral-data" onclick="open_Modal();">Ceder comisiones</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                                <div class="form-group  label-floating is-empty">
                                                    <label class="control-label label-gral">Lote</label>
                                                    <input id="inp_lote" onkeyup="onKeyUp(event)" name="inp_lote" 
                                                    onkeydown="return event.keyCode !== 69"
                                                    class="form-control input-gral" type="number" min="1"  maxlength="6">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <button type="button" class="btn-gral-data find_doc">Buscar <i class="fas fa-search pl-1"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover" id="tabla_inventario_contraloria" name="tabla_inventario_contraloria">
                                                <thead>
                                                    <tr>   
                                                        <th>PROYECTO</th>
                                                        <th>CONDOMINIO</th>
                                                        <th>LOTE</th>
                                                        <th>ID LOTE</th>
                                                        <th>CLIENTE</th>
                                                        <th>TIPO VENTA</th>
                                                        <th>MODALIDAD</th>
                                                        <th>CONTRATACIÓN</th>
                                                        
                                                        <th>PLAN VENTA</th>
                                                        <th>FEC. SISTEMA</th> 
                                                        <th>FEC. NEODATA</th>

                                                        <th>ENT. VENTA</th>
                                                        <th>ESTATUS COM.</th>
                                                        <th>MÁS</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
    </div>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/controllers/incidencias/incidencia_by_lote.js"></script>
</body>