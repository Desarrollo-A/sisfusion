<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<body class="">
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

    <div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"></div>
                <form method="post" id="form_interes">
                    <div class="modal-body"></div>
                </form>
            </div>
        </div>
    </div>  
   <!-- inicia modal para editar descuento  -->
        <!--Modal para add costo universidad -->
        <div class="modal fade" id="modalUni" nombre="modalUni" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header" id="header_modal" name="header_modal">
                        <h3 id="tituloModalUni" name="tituloModalUni"> Editando descuento actual </h3>
                    </div>
                    <div class="modal-body" >
                    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label class="label">Certificaciones*</label>       
                                    <select class="form-control select2 certificaciones" name="certificaciones" id="certificaciones">
                                        <?php if(isset($certificaciones)){ foreach($certificaciones as $certificacion){ ?>
                                            <option value="<?= $certificacion->id_opcion ?>"><?= $certificacion->nombre ?> </option>
                                        <?php } } ?>
                                    </select>
                                </div>      
                    </div>
                                <div class="col-md-4" style="display:none;">
                                    <div class="form-group">
                                        <input class="form-control" type="text"   name="dineroPagado" id="dineroPagado" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4" style="display:none;">
                                    <div class="form-group">
                                        <input class="form-control" type="text"   name="pagoIndiv" id="pagoIndiv" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4" style="display:none;">
                                    <div class="form-group">
                                        <input class="form-control" type="text"   name="idDescuento" id="idDescuento" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4" style="display:none;">
                                    <div class="form-group">
                                        <input class="form-control" type="text"   name="totalPagos" id="totalPagos" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4" style="display:none;">
                                    <div class="form-group">
                                        <input class="form-control" type="text"   name="pagoDado" id="pagoDado" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4" style="display:none;">
                                    <div class="form-group">
                                        <input class="form-control" type="text"   name="banderaLiquidado" id="banderaLiquidado" readonly>
                                    </div>
                                </div>   
                                  <div class="col-md-4" style="display:none;">
                                    <div class="form-group">
                                        <input class="form-control" type="text"   name="precioOrginal" id="precioOrginal" readonly>
                                    </div>
                                </div>
                        <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label class="label">Descripcion:</label> 
                                    <span class="small text-gray textDescripcion"  id="textDescripcion"  name="textDescripcion">
                                    Persona que obtuvo una calificación favorable y con ello la certificación
                                    </span>        
                                </div>
                        </div>
                        <div class="col-4 col-sm-4 col-md-4 col-lg-4 ">
                            <div class="form-group">
                                    <label class="label">Fecha nueva*</label>  
                                            <div class="row">
                                                <div class="col-md-12 p-r">
                                                    <div > 
                                                        <input type="date" class="form-control datepicker" id="fechaIncial" name="fechaIncial"  />
                                                    </div>
                                                </div>
                                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                            <div class="row">
                                
                                <div class="col-xs-12 col-sm-12 col-md-12" id="cuerpoModalUni" name="cuerpoModalUni">
                                                
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12" >
                                </div>
                                    <div class="form-group col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <center>
                                                <button name="updateDescuentoCertificado" style="display:block;" id="updateDescuentoCertificado"
                                                    class="btn btn-primary updateDescuentoCertificado">GUARDAR</button>
                                            </center>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <center>
                                                <button class="btn btn-danger" type="button" data-dismiss="modal"
                                                    data-toggle="modal">
                                                    CANCELAR
                                                </button>
                                            </center>
                                        </div>
                                    </div>
                            </div>  
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin modal add costo Universidad -->
   <div class="modal fade" id="editDescuento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3> Editando descuento actual </h3>
                </div>
                <div class="modal-body">
                    <div role="tabpanel">
                   
                    <div class="modal-body">

                        <div class="form-group row">
                            <div class="col-md-4" style="display:none;">
                                <div class="form-group">
                                    <input class="form-control" type="text"   name="mensualidad" id="mensualidad" readonly>
                                </div>

                            </div>
                            <div class="col-md-4" style="display:none;">
                                <div class="form-group">
                                    <input class="form-control" type="text"   name="pagado" id="pagado" readonly>
                                </div>

                            </div>
                            <div class="col-md-4" style="display:none;">
                                <div class="form-group">
                                    <input class="form-control" type="text"   name="total_pagos" id="total_pagos" readonly>
                                </div>

                            </div>
                            <div class="col-md-4" style="display:none;">
                                <div class="form-group">
                                    <input class="form-control" type="text"   name="actualess" id="actualess" readonly>
                                </div>

                            </div>
                            <div class="col-md-4" style="display:none;">
                                <div class="form-group">
                                    <input class="form-control" type="text"   name="totalmeses" id="totalmeses" readonly>
                                </div>
                            </div>
                            <div class="col-md-4" style="display:none;">
                                <div class="form-group">
                                    <input class="form-control" type="text"   name="cuanto" id="cuanto" readonly>
                                </div>
                            </div>
                            <div class="col-md-4" style="display:none;">
                                <div class="form-group">
                                    <input class="form-control" type="text"   name="id_pagos" id="id_pagos" readonly>
                                </div>
                            </div>
                            <div class="col-md-4" style="display:none;">
                                <div class="form-group">
                                    <input class="form-control" type="text"   name="descuento_id" id="descuento_id" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label">Monto Descuento *</label>
                                    <input class="form-control descuentoEscrito"
                                           type="number"
                                           id="descuentoEscrito"
                                           name="descuentoEscrito"
                                           autocomplete="off"
                                           min="1"
                                           max="99000"
                                           step=".01"
                                           required
                                    />
                                </div>

                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label">Pagos Restantes*</label>
                                    <select class="form-control" name="numeroDeMensualidades" id="numeroDeMensualidades" >
                                        <option value="" disabled="true" selected="selected">- Selecciona opción -</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                    </select>
                                </div>

                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label">Monto a descontar</label>
                                    <input class="form-control" type="text" id="nuevasMensualidades" name="nuevasMensualidades">
                                </div>
                            </div>


                        </div>

          

                        <div class="form-group">

                            <center>
                                <button  name="updateDescuento" id="updateDescuento" class="btn btn-primary updateDescuento">GUARDAR</button>
                                <button class="btn btn-danger" type="button" data-dismiss="modal" data-toggle="modal">
                                 </button>
                            </center>
                        </div>

                    </div>
            
                    
                    </div>
                </div>
             
            </div>
        </div>
    </div>
    <!-- finalizar modal para editar descuento -->
    <div class="modal fade"
         id="activar-pago-modal"
         tabindex="-1"
         role="dialog"
         aria-labelledby="myModalLabel"
         aria-hidden="true"
         data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog"
             role="document">
            <div class="modal-content">
                <div class="modal-header bg-red">
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-hidden="true">
                        <i class="material-icons">clear</i>
                    </button>
                    <h4 class="modal-title">Reactivar pagos</h4>
                </div>

                <form method="post"
                      class="row"
                      id="activar-pago-form"
                      autocomplete="off">
                    <div class="modal-body">
                        <input type="hidden"
                               name="id_descuento"
                               id="id-descuento-pago">

                        <div class="col-lg-6">
                            <h4>Faltante: <BR> <b><span id="faltante-pago"></span></b></h4>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="fecha">Fecha reactivación</label>
                                <input type="date"
                                       class="form-control"
                                       name="fecha"
                                       id="fecha"
                                       min="<?=date('Y-m-d')?>"
                                       required />
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="modal-footer">
                        <button type="submit"
                                class="btn btn-primary">
                            Aceptar
                        </button>
                        <button type="button"
                                class="btn btn-danger btn-simple"
                                data-dismiss="modal">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="seeInformationModalDU" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist" style="background: #3982C0;">
                            <div id="nameLote"></div>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="changelogTab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content">
                                                <ul class="timeline timeline-simple" id="comments-list-asimilados"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"
                            onclick="cleanCommentsAsimilados()"><b>Cerrar</b></button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="seeInformationModalP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="" name="" method="post">
                    <div class="modal-header">
                    <h4 class="card-title aling-center"><b id="nameUser"></b></h4>
                </div>
                        <div class="modal-body" style="text-align: center;">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <input type="hidden" name="userid" id="userid">
                            <div class="form-group">
                                <label class="m-0" for="mes">Mes</label>
                                <select name="mes" id="mes" class="selectpicker select-gral m-0 " data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un mes" data-size="7" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label class="m-0" for="mes">Año</label>
                                <select name="anio" id="anio" class="selectpicker select-gral m-0 "  data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona año" data-size="7" required>
                                </select>
                            </div>
                        </div>

                        <div class="form-group text-center" ><label class="m-0" for="mes">MONTO:<p class="category input-tot pl-1" ><B id="montito">$0</B></p>
                    </div>

                    </div>
                        <div class="modal-footer">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <div class="modal fade modal-alertas" id="miModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-red">
                    <h4 class="card-title aling-center"><b>Aplicar descuento</b></h4>
                </div>
                <form method="post" id="form_basta">
                    <div class="modal-body">              
                    
                    
                        <b id="msj2" style="color: red;"></b>
                        <div id="loteorigen" style="display:none;">
                            <label class="label">Lote origen</label>
                            <select id="idloteorigen" disabled name="idloteorigen[]" multiple="multiple"
                                    class="form-control directorSelect2 js-example-theme-multiple"
                                    style="width: 100%;height:200px !important;" required
                                    data-live-search="true">
                            </select>
                        </div>
                        <div class="col-md-12">
							<div class="form-group">
								<label class="control-label">Lotes</label>
                                <!-- <textarea id="condominios1"></textarea> -->
                                <div id="condominios1" name="condominios1" class="form-control" required></div>
								<!-- <select id="condominios2"
										name="condominios2[]"
										class="selectpicker select-gral m-0"
										data-style="btn"
										data-show-subtext="true"
										data-live-search="true"
										multiple
										title="Selecciona una opción" 
										data-size="7"
										data-container="body"
										required>
								</select> -->
							</div>	
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Total lote(s) disponible(s)</label>
                                <input class="form-control input-gral" type="text" id="idmontodisponible" readonly required
                                       name="idmontodisponible" value=""></div>
                            <div id="montodisponible">

                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Total a descontar</label>
                                <input class="form-control input-gral" type="text" id="monto" readonly="readonly" name="monto"
                                       value="">
                            </div>
                        </div>
                    
                        <div class="col-md-12">

                            <label class="control-label">Mótivo de descuento</label>
                            <textarea id="comentario" name="comentario" class="form-control input-gral" rows="5"
                                      required></textarea>

                        </div>

                        <input class="form-control" type="hidden" id="usuarioid" name="usuarioid" value="">
                        <input class="form-control" type="hidden" id="pagos_aplicados" name="pagos_aplicados" value="">
                        <input class="form-control" type="hidden" id="saldo_comisiones" name="saldo_comisiones">
                    </div>
                    <div class="modal-footer">
                            <button class="btn btn-danger btn-simple" type="button" data-dismiss="modal">CANCELAR</button>
                            <button type="submit" id="btn_abonar" class="btn btn-primary">GUARDAR</button>
                                
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-alertas" id="myModalEspera" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <form method="post" id="form_espera_uno">
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-alertas" id="modal-delete" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body"></div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="actualizar-descuento-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="actualizar-descuento-form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" data-toggle="modal"> &times;</button>
                        <h4 class="modal-title">Actualizar descuento</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden"
                               name="id_descuento"
                               id="id-descuento-pago-update">
                        <div class="row">
                            <div class="col-lg-12">
                                <span id="usuario-update"></span>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label">Monto Descuento *</label>
                                    <input class="form-control"
                                           type="number"
                                           id="descuento-update"
                                           name="descuento"
                                           autocomplete="off"
                                           min="1"
                                           max="99000"
                                           step=".01"
                                           required />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label">Número de Pagos *</label>
                                    <select class="form-control" name="numero-pagos" id="numero-pagos-update" required>
                                        <option value="" disabled="true" selected="selected">- Selecciona opción -</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label" for="pago-ind-update">Monto a descontar</label>
                                    <input class="form-control"
                                           type="text"
                                           id="pago-ind-update"
                                           name="pago_ind"
                                           readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit"
                                class="btn btn-primary">
                            Guardar
                        </button>
                        <button type="button"
                                class="btn btn-danger btn-simple"
                                data-dismiss="modal">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-alertas" id="ModalBonos" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-red center-align">
                    <button type="button" class="close" data-dismiss="modal" data-toggle="modal"> &times;</button>
                    <h4 class="modal-title">Descuentos</h4>
                </div>
                <form method="post" id="form_nuevo">
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="label">Puesto del usuario *</label>
                            <select class="selectpicker select-gral roles" name="roles" id="roles"
                            title="SELECCIONA UNA OPCIÓN" required data-live-search="true" required>
                        
                                <option value="7">Asesor</option>
                                <option value="9">Coordinador</option>
                                <option value="3">Gerente</option>
                            </select>
                        </div>


                        <div class="form-group" id="users2">
                        </div>


                        <div class="form-group row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label">Monto Descuento *</label>
                                    <input class="form-control input-gral"
                                           type="number"
                                           id="descuento"
                                           name="descuento"
                                           autocomplete="off"
                                           min="1" 
                                           max="99000"
                                           step=".01"
                                           required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label">Número de Pagos *</label>
                                    <select class="selectpicker select-gral " name="numeroPagos" id="numeroPagos" 
                                    title="SELECCIONA UNA OPCIÓN" required data-live-search="true" required>
                                        
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                    </select>
                                </div>

                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label">Monto a descontar</label>
                                    <input class="form-control input-gral" type="text" id="pago_ind01" name="pago_ind01" value="">
                                </div>
                            </div>


                        </div>

                        <div class="form-group">

                            <label class="label">Mótivo de descuento *</label>
                            <textarea id="comentario2" name="comentario2" class="form-control input-gral" rows="3"
                                      required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger btn-simple" type="button" data-dismiss="modal" data-toggle="modal">
                                    CANCELAR
                        </button>
                        <button type="submit" id="btn_descontar" class="btn btn-gral-data">GUARDAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-alertas" id="modal_abono" data-backdrop="static" data-keyboard="false" role="dialog">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-red">
                    <center><img src="<?= base_url() ?>static/images/preview.gif" width="250" height="200"></center>


                </div>
                <form method="post" id="form_abono">
                    <div class="modal-body"></div>
                    <div class="modal-footer">

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
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-building fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Descuentos Universidad</h3>
                                    <!-- <p class="card-title pl-1 center-align"></p> -->
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid">
                                        <div class="row aligned-row">

                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <h4 class="title-tot center-align m-0">
                                                    Total $
                                                    <p class="category input-tot pl-1" id="total-baja"></p>
                                                </h4>
                                            </div>

                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <h4 class="title-tot center-align m-0">
                                                Total recaudado $
                                                    <p class="category input-tot pl-1" id="abonado-baja"></p>
                                                </h4>
                                            </div>

                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <h4 class="title-tot center-align m-0">
                                                    Pendiente $
                                                    <p class="category input-tot pl-1" id="pendiente-baja"></p>
                                                </h4>
                                            </div> 

                                            <!-- <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <div class="form-group text-center">
                                                    <h4 class="title-tot center-align m-0">Monto hoy: </h4>
                                                    <p class="category input-tot pl-1" id="monto_label">
                                                    </p>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <div class="form-group text-center">
                                                    <h4 class="title-tot center-align m-0">Pagos hoy: </h4>
                                                    <p class="category input-tot pl-1" id="pagos_label">
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-2">
                                                <div class="form-group text-center">
                                                    <h4 class="title-tot center-align m-0">Lotes hoy: </h4>
                                                    <p class="category input-tot pl-1" id="lotes_label">
                                                    </p>
                                                </div>
                                            </div> -->
                                                                                       
                                        </div>
                                        <div class="col-lg-12">
                                        <div class="form-group is-empty">
                                            <label for="proyecto">Tipo descuento:</label>
                                            <select name="tipo_descuento" id="tipo_descuento" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" 
                                                    data-live-search="true"  title="Selecciona el tipo de descuento" data-size="7" required onChange="checkTypeOfDesc()">
                                                <!--<option value="0">Seleccione all</option>-->
                                                <option value="1" selected>Activos</option>
                                                <option value="3">Liquidados</option>
                                                <option value="2">Baja</option>
                                                <option value="5">Detenidos</option>
                                                <option value="4">Conglomerado</option>
                                            </select>
                                        </div>
                                    </div>

                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla-general" name="tabla-general">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>USUARIO</th>
                                                    <th>PUESTO</th>
                                                    <th>SEDE</th>
                                                    <th>SALDO COMISIONES</th>
                                                    <th>TOTAL</th>
                                                    <th>DESCONTADO</th>
                                                    <th>PAGADO CAJA</th>
                                                    <th>PENDIENTE</th>
                                                    <th>MONTO POR MES</th>
                                                    <th>ESTATUS</th>
                                                    <th>DESCUENTO DISPONIBLE</th>
                                                    <th>FECHA 1° DESCUENTO</th>
                                                    <th>FECHA DE CREACIÓN</th>
                                                    <th>ESTATUS CERTIFICACIÓN</th>
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
    <?php $this->load->view('template/footer');?>
    <script src="http://momentjs.com/downloads/moment.min.js"></script>
    <script src="<?= base_url() ?>dist/js/funciones-generales.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/ventas/conglomerado.js"></script>
</body>


