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
</style>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <!--MODALS-->
        <div class="modal fade modal-alertas" id="modal_sedes" name="modal_sedes" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header ">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons">clear</i>
                    </button> 
                    <h4 class="card-title"><b>Cambio de sedes</b></h4>
                    </div>
                    <form method="post" id="form_sede">
                        <div class="modal-body">
                            <div class="tituloLote" id="tituloLote" ></div>
                            <div class="sedeOld" id="sedeOld" ></div>
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
                            <button type="button" class="btn btn-danger btn-simple " data-dismiss="modal">CANCELAR</button>
                            <button type="submit" class="btn btn-gral-data" value="ACEPTAR" style="margin: 15px;">ACEPTAR</button>
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
                        <div class="modal-footer">  </div>
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
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>   
                    </div>
                    <form method="post" id="form_empresa">
                        <div class="modal-body">
                            <input type="hidden" name="idLoteE" readonly="true" id="idLoteE" >
                            <input type="hidden" name="idClienteE" readonly="true" id="idClienteE" >
                            <input type="hidden" name="PrecioLoteE" readonly="true" id="PrecioLoteE" >
                            <h4>¿Esta seguro que desea agregar empresa?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" disabled id="btn-save" class="btn btn-gral-data" value="GUARDAR">GUARDAR</button>
                            <button type="button" class="btn btn-danger btn-simple"  data-dismiss="modal" value="CANCELAR"> CANCELAR</button>
                        <!-- <button type="submit" id="btn_add" class="btn btn-primary">GUARDAR</button>
                            <button class="btn btn-danger" type="button" data-dismiss="modal" >CANCELAR</button> -->
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
                                                                <th><center>Lote</center></th>
                                                                <th><center>Status</center></th>
                                                                <th><center>Detalles</center></th>
                                                                <th><center>Comentario</center></th>
                                                                <th><center>Fecha</center></th>
                                                                <th><center>Usuario</center></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th><center>Lote</center></th>
                                                                <th><center>Status</center></th>
                                                                <th><center>Detalles</center></th>
                                                                <th><center>Comentario</center></th>
                                                                <th><center>Fecha</center></th>
                                                                <th><center>Usuario</center></th>
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
                                                                <th><center>Lote</center></th>
                                                                <th><center>Precio</center></th>
                                                                <th><center>Fecha Liberación</center></th>
                                                                <th><center>Comentario Liberación</center></th>
                                                                <th><center>Usuario</center></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th><center>Lote</center></th>
                                                                <th><center>Precio</center></th>
                                                                <th><center>Fecha Liberación</center></th>
                                                                <th><center>Comentario Liberación</center></th>
                                                                <th><center>Usuario</center></th>
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
                                                                <th><center>Asesor</center></th>
                                                                <th><center>Coordinador</center></th>
                                                                <th><center>Gerente</center></th>
                                                                <th><center>Fecha alta</center></th>
                                                                <th><center>Usuario</center></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th><center>Asesor</center></th>
                                                                <th><center>Coordinador</center></th>
                                                                <th><center>Gerente</center></th>
                                                                <th><center>Fecha alta</center></th>
                                                                <th><center>Usuario</center></th>
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

        <div class="modal fade" id="modal_avisitos" style="overflow-y: scroll;" style="overflow:auto !important;" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">           
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>      
                        <!-- <button type="button" style="font-size: 20px;top:20px;" class="close" data-dismiss="modal">  <i class="large material-icons">close</i></button> -->
                    </div>
                    <div class="modal-body"> 
                        <h4 class="modal-title" >Cambiar usuario</h4>
                        <div class="form-group">        
                            <div class="col-md-12" >
                                <label class="control-label"  >Seleccione una opción</label>
                                <select class="selectpicker select-gral m-0" data-style="btn" data-cliente="" data-lote="" title="SELECCIONA UNA OPCIÓN" required data-live-search="true"name="opcion" onchange="selectOpcion()" id="opcion" >
                                    <option value="1">Cliente</option>
                                    <option value="2">Venta compartida</option>
                                </select>
                                <input type="hidden" class="form-control"id="lotes1" name="lotes1">
                                <input type="hidden" class="form-control"id="clientes2" name="clientes2">
                                <!-- aqui mero vamos a poner los imputs  -->
                                <!--  -->
                            </div> 
                        </div> 
                    </div>
                    <div class="modal-footer"></div>
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
                        <h4 class="card-title"><b>Ceder comisiones</b></h4>
                    </div>
                    <form method="post" id="form_ceder">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="control-label">Asesor dado de baja</label>
                                <select name="asesorold" id="asesorold" class="selectpicker select-gral" 
                                title="SELECCIONA UNA OPCIÓN"
                                data-style="btn " data-show-subtext="true" data-live-search="true" 
                                title="Selecciona un usuario" data-size="7" required>
                                </select>
                            </div>
                            <div id="info"></div>
                            <div class="form-group" id="users"></div>
                            <div class="form-group">
                                <label class="control-label">Puesto del usuario a ceder la comisiones</label>
                                <select class="selectpicker select-gral roles2"  name="roles2" id="roles2" required title="SELECCIONA UNA OPCIÓN" required data-live-search="true">
                                    <option value="7">Asesor</option>
                                    <option value="9">Coordinador</option>
                                    <option value="3">Gerente</option>
                                </select> 
                            </div>
                            <div class="form-group" id="users">
                                <label class="control-label">Usuario a ceder comisiones</label>
                                <select id="usuarioid2" name="usuarioid2" class="selectpicker directorSelect select-gral" title="SELECCIONA UNA OPCIÓN"  required data-live-search="true"></select>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Descripción</label>
                                <textarea id="comentario" name="comentario" class="form-control input-gral" rows="3" placeholder="Descripción" required="required"></textarea>
                            </div>
                            <div class="form-group">
                            </div>
                        </div>
                        <div class="modal-footer">     
                            <button class="btn btn-danger btn-simple" type="button" data-dismiss="modal" >CANCELAR</button>
                            <button type="submit" id="btn_ceder" class="btn btn-gral-data ">GUARDAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="miModalInventario" style="overflow:auto !important;" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <h4 class="card-title"><b>Actualizar inventario</b></h4>
                    </div>
                    <form method="post" id="form_inventario" >
                        <div class="modal-body">
                            <div class="invent"></div>
                            <div class="form-group" id="users"></div>
                            <div class="form-group">
                                <label class="control-label">Puesto del usuario a modificar</label>
                                <select class="selectpicker select-gral roles3"  name="roles3"  id="roles3" required title="SELECCIONA UNA OPCIÓN" required data-live-search="true">
                                    <option value="7">Asesor</option>
                                    <option value="9">Coordinador</option>
                                    <option value="3">Gerente</option>
                                    <option value="2">Sub director</option>
                                    <option value="59">Regional</option>
                                </select>
                                <p id="UserSelect"></p>
                            </div>
                            <div class="form-group" id="users">
                                <label class="control-label">Seleccionar usuario</label>
                                <select id="usuarioid3" name="usuarioid3"  class="selectpicker select-gral directorSelect "  title="SELECCIONA UNA OPCIÓN"  required data-live-search="true"></select>
                            </div>      
                            <p id="UserSelectDirec"></p>                
                            <div class="form-group">
                                <label class="control-label">Descripción</label>
                                <textarea id="comentario3" name="comentario3" class="form-control input-gral" rows="3" placeholder="Descripción"required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">    
                            <button class="btn btn-danger btn-simple" type="button" data-dismiss="modal" >CANCELAR</button>
                            <button type="submit" id="btn_inv" class="btn btn-gral-data">GUARDAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="miModalVc" style="overflow:auto !important;" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <h4 class="card-title"><b>Actualizar venta compartida</b></h4>
                    </div>
                    <form method="post" id="form_vc" >
                        <div class="modal-body">
                            <div class="vc"></div>
                            <div class="form-group" id="users"></div>
                            <div class="form-group">
                                <label class="control-label">Puesto del usuario a modificar</label>
                                    <select class="selectpicker select-gral rolesvc"  name="rolesvc" id="rolesvc" required title="SELECCIONA UNA OPCIÓN" required data-live-search="true">
                                    <option value="7">Asesor</option>
                                    <option value="9">Coordinador</option>
                                    <option value="3">Gerente</option>
                                </select>
                                <p id="UserSelectvc"></p>
                            </div>
                            <div class="form-group" id="users">
                                <label class="control-label">Seleccionar usuario</label>
                                <select id="usuarioid4" name="usuarioid4"  class="selectpicker select-gral directorSelect"  title="SELECCIONA UNA OPCIÓN" required data-live-search="true"></select>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Descripción</label>
                                <textarea id="comentario4" name="comentario4" class="form-control input-gral" rows="3" placeholder="Descripción" required="required"></textarea>
                            </div>
                            <div class="form-group"></div>
                        </div>
                        <div class="modal-footer">     
                            <button class="btn btn-danger btn-simple " type="button" data-dismiss="modal" >CANCELAR</button>
                            <button type="submit" id="btn_vc" class="btn btn-gral-data" >GUARDAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="miModalVcNew" style="overflow:auto !important;" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <h4 class="card-title"><b>Agregar venta compartida</b></h4>
                    </div>
                    <form method="post" id="form_vcNew" >
                        <div class="modal-body">
                            <div class="vcnew"></div>
                            <div class="form-group" id="users5">
                                <label class="control-label">Asesor</label>
                                <select id="usuarioid5" name="usuarioid5" class="selectpicker select-gral  asesor " required data-live-search="true"    title="SELECCIONA UNA OPCIÓN" ></select>
                            </div>
                            <div class="form-group" id="users6">
                                <label class="control-label">Coordinador</label>
                                <select id="usuarioid6" name="usuarioid6" class="selectpicker select-gral  coor "data-live-search="true" required    title="SELECCIONA UNA OPCIÓN"></select>
                            </div>
                            <div class="form-group" id="users7">
                                <label class="control-label">Gerente</label>
                                <select id="usuarioid7" name="usuarioid7" class="selectpicker select-gral  ger " required data-live-search="true"    title="SELECCIONA UNA OPCIÓN" ></select>
                            </div>
                            <div class="form-group" id="users7">
                                <label class="control-label">Subdirector</label>
                                <select id="usuarioid8" name="usuarioid8" class="selectpicker select-gral ger " required data-live-search="true"    title="SELECCIONA UNA OPCIÓN"></select>
                            </div>
                        </div>
                        <div class="modal-footer">     
                            <button class="btn btn-danger btn-simple" type="button" data-dismiss="modal" >CANCELAR</button>
                            <button type="submit" id="btn_vcnew" class="btn btn-gral-data">GUARDAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--END MODALS-->

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
                                    <h3 class="card-title center-align" >Panel de incidencias</h3>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid">
                                        <div class="row aligned-row">
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <label class="control-label">Lote (<span class="isRequired">*</span>)</label>
                                                <input id="inp_lote" onkeyup="onKeyUp(event)" name="inp_lote"  onkeydown="return event.keyCode !== 69" class="form-control input-gral" type="number" min="1"  maxlength="6">
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 d-flex align-end">
                                                <div class="form-group w-100">
                                                    <button type="button" class="btn-gral-data buscarLote ">Buscar <i class="fas fa-search pl-1"></i></button>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2"></div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 d-flex align-end">
                                                <div class="form-group w-100">
                                                    <button class="btn-gral-data" onclick="open_Modal();">Ceder comisiones</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover hide" id="tabla_incidencias_contraloria" name="tabla_incidencias_contraloria">
                                            <thead>
                                                <tr>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>ID LOTE</th>
                                                    <th>CLIENTE</th>
                                                    <th>TIPO DE VENTA</th>
                                                    <th>MODALIDAD</th>
                                                    <th>CONTRATACIÓN</th>
                                                    <th>PLAN DE VENTA</th>
                                                    <th>FECHA EN SISTEMA</th> 
                                                    <th>FECHA DE NEODATA</th>
                                                    <th>ESTATUS DE LA COMISIÓN</th>
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
 
    <?php $this->load->view('template/footer_legend');?>
    </div>
    </div>
    </div><!--main-panel close-->
    <?php $this->load->view('template/footer');?>
        
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="<?= base_url() ?>dist/js/controllers/incidencias/incidencia_by_lote.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
</body>