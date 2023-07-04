<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<style>
    label.error {
        color: red;
    }
</style>
<body>
<div class="wrapper">

    <?php


    if ($this->session->userdata('id_rol') == "49")//contraloria
    {
        $this->load->view('template/sidebar');
    } else {
        echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
    }
    ?>

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
                                    eee
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

                        <div class="col-lg-12">
                            <h4>Faltante: <b><span id="faltante-pago"></span></b></h4>
                        </div>

                        <div class="col-lg-12">
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

    <div class="modal fade" id="seeInformationModalP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content boxContent">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist" style="background: #3982C0;">
                            <div id="nameUser"></div>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="changelogTabP">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content">
                                                <ul class="" id="comments-list-asimiladosP">
                                                    <div class="row toolbar">
                                                        <input id="userid" name="userid" value="0" type="hidden">
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div class="form-group">
                                                                <label class="m-0" for="mes">Mes</label>
                                                                <select name="mes" id="mes" class="selectpicker select-gral m-0 " data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona un mes" data-size="7" required>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div class="form-group">
                                                                <label class="m-0" for="mes">Año</label>
                                                                <select name="anio" id="anio" class="selectpicker select-gral m-0 "  data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona año" data-size="7" required>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group text-center" ><h4 class="title-tot center-align m-0 " >MONTO:</h4><p class="category input-tot pl-1" ><B id="montito">$0</B></p></div>

                                                    </div>

                                                </ul>
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
								<label class="control-label">Condominio</label>
								<select id="condominios1"
										name="condominios1[]"
										class="selectpicker select-gral m-0"
										data-style="btn"
										data-show-subtext="true"
										data-live-search="true"
										multiple
										title="Selecciona una opción" 
										data-size="7"
										data-container="body"
										required>
								</select>
							</div>	
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Monto disponible</label>
                                <input class="form-control input-gral" type="text" id="idmontodisponible" readonly required
                                       name="idmontodisponible" value=""></div>
                            <div id="montodisponible">

                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Monto a descontar</label>
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
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <div class="toolbar">
                                <div class="container">
                                    <div id="title-activo">
                                        <div class="col-lg-12 text-center mt-1 p-0">
                                            <h3 class="card-title center-align">Descuentos Universidad</h3>
                                            <p class="card-title pl-1">(Descuentos activos, una vez liquidados podrás consultarlos en el Historial de descuentos)</p><br>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <h5 class="card-title center-align">
                                                Total $
                                                <input style="border-bottom: none; border-top: none; border-right: none; border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" id="total-activo">
                                            </h5>
                                        </div>

                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <h5 class="card-title center-align">
                                            Total recaudado $
                                                <input style="border-bottom: none; border-top: none; border-right: none; border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" id="total-abonado">
                                            </h5>
                                        </div>

                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <h5 class="card-title center-align">
                                                Pendiente $
                                                <input style="border-bottom: none; border-top: none; border-right: none; border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" id="total-pendiente">
                                            </h5>
                                        </div>
                                    </div>

                                    <div id="title-baja" hidden>
                                        <div class="col-lg-12 text-center mt-1 p-0">
                                            <h3 class="card-title center-align">Descuentos Universidad</h3>
                                            <p class="card-title pl-1">(Listado de descuentos de usuarios inactivos)</p><br>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <h5 class="card-title center-align">
                                                Total $
                                                <input style="border-bottom: none; border-top: none; border-right: none; border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" id="total-baja">
                                            </h5>
                                        </div>

                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <h5 class="card-title center-align">
                                            Total recaudado $
                                                <input style="border-bottom: none; border-top: none; border-right: none; border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" id="abonado-baja">
                                            </h5>
                                        </div>

                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <h5 class="card-title center-align">
                                                Pendiente $
                                                <input style="border-bottom: none; border-top: none; border-right: none; border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" id="pendiente-baja">
                                            </h5>
                                        </div>
                                    </div>

                                    <div id="title-liquidado" hidden>
                                        <div class="col-lg-12 text-center mt-1 p-0">
                                            <h3 class="card-title center-align">Descuentos Universidad - <b>Liquidados</b></h3>
                                            <p class="card-title pl-1">(Listado de descuentos completos o liquidados en caja)</p><br>
                                        </div>
                                         

                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <h5 class="card-title center-align">
                                                Total $
                                                <input style="border-bottom: none; border-top: none; border-right: none; border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" id="total-liquidado">
                                            </h5>
                                        </div>

                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <h5 class="card-title center-align">
                                            Total recaudado $
                                                <input style="border-bottom: none; border-top: none; border-right: none; border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" id="abonado-liquidado">
                                            </h5>
                                        </div>

                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <h5 class="card-title center-align">
                                                Pendiente $
                                                <input style="border-bottom: none; border-top: none; border-right: none; border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" id="pendiente-liquidado">
                                            </h5>
                                        </div>



                                    </div>

                                    <div id="title-conglomerado" hidden>
                                        <div class="col-lg-12 text-center mt-1 p-0">
                                            <h3 class="card-title center-align">Descuentos Universidad y Liquidados</h3>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <h5 class="card-title center-align">
                                                Total $
                                                <input style="border-bottom: none; border-top: none; border-right: none; border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" id="total-conglomerado">
                                            </h5>
                                        </div>

                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <h5 class="card-title center-align">
                                            Total recaudado $
                                                <input style="border-bottom: none; border-top: none; border-right: none; border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" id="abonado-conglomerado">
                                            </h5>
                                        </div>

                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <h5 class="card-title center-align">
                                                Pendiente $
                                                <input style="border-bottom: none; border-top: none; border-right: none; border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" id="pendiente-conglomerado">
                                            </h5>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group is-empty">
                                            <label for="proyecto">Tipo descuento:</label>
                                            <select name="tipo_descuento" id="tipo_descuento" class="selectpicker select-gral" data-style="btn " data-show-subtext="true"
                                                    data-live-search="true"  title="Selecciona el tipo de descuento" data-size="7" required onChange="checkTypeOfDesc()">
                                                <!--<option value="0">Seleccione all</option>-->
                                                <option value="1" selected>Activo</option>
                                                <option value="2">Baja</option>
                                                <option value="3">Liquidado</option>
                                                <option value="4">Conglomerado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="table-responsive">
                                    <table id="tabla-general"
                                            class="table-striped table-hover"
                                            style="text-align: center;">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>USUARIO</th>
                                                <th>PUESTO</th>
                                                <th>SEDE</th>
                                                <th>SALDO COMISIONES</th>
                                                <th>DESCUENTO</th>
                                                <th>APLICADO</th>
                                                <th>PENDIENTE GRAL.</th>
                                                <th>PAGO MENSUAL</th>
                                                <th>ESTATUS</th>
                                                <th>PENDIENTE MES</th>
                                                <th>DISPONIBLE DESC.</th>
                                                <th>FEC. DESC. 1</th>
                                                <th>FEC. CREACIÓN</th>
                                                <th>ESTATUS CERTIFICACIONES</th>
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


<?php $this->load->view('template/footer_legend'); ?>
</div>
</div>

</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer'); ?>
<!--DATATABLE BUTTONS DATA EXPORT-->

<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<!--<link href="<?= base_url() ?>dist/js/controllers/select2/select2.min.css" rel="stylesheet" />
<script src="<?= base_url() ?>dist/js/controllers/select2/select2.min.js"></script>-->
<script src="<?= base_url() ?>dist/js/controllers/ventas/conglomerado.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

