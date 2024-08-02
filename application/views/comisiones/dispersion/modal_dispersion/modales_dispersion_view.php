      <!-- Modals -->
      <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex d-wrap"> 
                        <h4 class="modal-title" ><b class="text-center">Reporte dispersión</b></h4>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="container-fluid p-0">
                                <div class="row">
                                    <div class="col-md-12 p-r">
                                        <div class="form-group d-flex">
                                            <input type="text" class="form-control datepicker beginDate" id="beginDate" />
                                            <input type="text" class="form-control datepicker endDate"  id="endDate"/>
                                            <button class="btn btn-success btn-round btn-fab btn-fab-mini"id="searchByDateRange">
                                                <span class="material-icons update-dataTable">search</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <br><br><br><br> -->
                    <div id="mBody" class="modal-body pr-0 ml-4"></div>
                    <div class="modal-footer"><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanComments()">Cerrar</button></div>
                </div>
            </div>
        </div>

        <div id="llenadoPlan" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header alcenter-align">
         
                        <h4 class="modal-title  center-align" ><b>Llenado de Plan</b></h4>
                    </div>
                    <div class="modal-body ">
                        <label class="">Nota:</label>
                        <label class="">La siguiente acción asignará el plan de venta a los lotes que cumplan con las condiciones correspondientes, si no se asigna favor de revisar otros datos como la sede o los usuarios que tiene asignados la venta. Esta acción solo se podrá realizar cada 4 horas.</span>
                         <label  id='tiempoRestante' name='tiempoRestante' class=" tiempoRestante hide"></label> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple cerradoPlan hide" id="cerradoPlan" name="cerradoPlan" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary llenadoPlanbtn hide" id="llenadoPlanbtn" name="llenadoPlanbtn" >Aceptar</button>
                        <div class="spiner-loader hide" id="spiner-loader">
                            <div class="backgroundLS">
                                <div class="contentLS">
                                    <div class="center-align">
                                        Este proceso puede demorar algunos segundos
                                    </div>
                                    <div class="inner">
                                        <div class="load-container load1">
                                            <div class="loader">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myUpdateBanderaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="my_updatebandera_form" name="my_updatebandera_form" method="post">
                        <div class="modal-header bg-red">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="material-icons">clear</i></button>
                        </div>
                        <div class="modal-body" style="text-align: center;"></div>
                        <div class="modal-footer">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                <button type="submit" id="updateBandera" class="btn btn-primary">Aceptar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="detenciones-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="material-icons">clear</i></button>
                    </div>
                    <form method="post" class="row" id="detenidos-form" autocomplete="off">
                        <div class="modal-body">
                            <input type="hidden" name="id_pagoc" id="id-lote-detenido">
                            <input type="hidden" name="anterior" id="anterior">
                            <input type="hidden" name="saldoNeodata" id="saldoNeodata">
                            
                            <div class="col-lg-12" >
                                <div class="form-group">
                                <label for="motivo" class="control-label mt-0">Motivo (<span class="isRequired">*</span>)</label>
                                    <select class="selectpicker select-gral" id="motivo" name="motivo" data-style="btn" required title="SELECCIONA UNA OPCIÓN">
                                        <?php foreach($controversias as $controversia){ ?>
                                                <?php if($controversia['id_opcion'] != 8 ){  ?>
                                                    <option value="<?= $controversia['id_opcion']; ?>"><?= $controversia['nombre'] ?> </option>
                                        <?php }} ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mt-0">
                                    <label class="control-label">Detalles de la controversia (<span class="isRequired">*</span>)</label>
                                    <textarea class="text-modal" id="descripcion" name="descripcion" rows="3" placeholder="Escriba detalles de la controversia." required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                <button type="submit" id="detenerLote" class="btn btn-primary">Aceptar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="penalizacion4-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="material-icons">clear</i></button>
                    </div>
                    <form method="post" class="row" id="penalizacion4-form" autocomplete="off">
                        <div class="modal-body">
                            <input type="hidden" name="id_lote" id="id-lote-penalizacion4">
                            <input type="hidden" name="id_cliente" id="id-cliente-penalizacion4">
                            <div class="col-lg-4">
                                <div class="form-group is-empty">
                                    <label for="asesor" class="control-label label-gral">Asesor</label>
                                    <input id="asesor" name="asesor" type="number" step="any" class="form-control input-gral" placeholder="% Asesor" required />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group is-empty">
                                    <label for="coordinador" class="control-label label-gral">Coordinador</label>
                                    <input id="coordinador" name="coordinador" type="number" step="any" class="form-control input-gral" placeholder="% Coordinador" required />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group is-empty">
                                    <label for="gerente" class="control-label label-gral">Gerente</label>
                                    <input id="gerente" name="gerente" type="number" step="any" class="form-control input-gral" placeholder="% Gerente" required />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer pr-4">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar </button>
                            <button type="submit" class="btn btn-primary"> Aceptar </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="penalizacion-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                    </div>
                    <form method="post" class="row neeed-validation" id="penalizacion-form" autocomplete="off" novalidate>
                        <div class="modal-body pt-0">
                            <input type="hidden" name="id_lote" id="id_lote_penalizacion">
                            <input type="hidden" name="id_cliente" id="id_cliente_penalizacion">
                            <div class="col-lg-12">
                                <div class="form-group is-empty ">
                                    <label class="control-label ml-0">Comentarios</label>
                                    <textarea class="text-modal" rows="3" name="comentario_aceptado" id="comentario_aceptado" placeholder="Agregue sus comentarios..."></textarea>
                                </div>
                            </div>   
                        </div>
                        <div class="modal-footer pr-4">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar </button>
                            <button type="submit" class="btn btn-primary"> Aceptar </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="Nopenalizacion-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                    </div>
                    <form method="post" class="row" id="Nopenalizacion-form" autocomplete="off">
                        <div class="modal-body pt-0">
                            <input type="hidden" name="id_lote" id="id_lote_cancelar">
                            <input type="hidden" name="id_cliente" id="id_cliente_cancelar">
                            <div class="col-lg-12">
                                <div class="form-group is-empty">
                                    <label class="control-label">Comentarios</label>
                                    <textarea class="text-modal" rows="2" name="comentario_rechazado" id="comentario_rechazado" placeholder="Agregue sus comentarios..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer pr-4">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar </button>
                            <button type="submit" class="btn btn-primary"> Aceptar </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_NEODATA_Casas" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" id="form_NEODATA_Casas">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>


        <!-- modal verifyNEODATA -->
        <div class="modal fade modal-alertas" id="modal_NEODATA" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" id="form_NEODATA">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="detalle-plan-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" id="mHeader"></div>
                    <div class="modal-body pb-0 pt-0">
                        <div class="row">
                            <div class="col-lg-12" id="planes-div">
                                <div class="form-group">
                                    <select class="selectpicker select-gral" id="planes" name="planes" title="SELECCIONA UNA OPCIÓN" required data-live-search="true" data-style="btn" required></select>
                                </div>
                            </div>
                            <div id="detalle-tabla-div"class="container-fluid">
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="modal fade" id="modalPrioridad" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" id="mHeader"></div>
                    <form method="post" class="row" id="modalPrioridad" autocomplete="off">
                        <div class="modal-body pb-0 pt-0"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary"> Aceptar </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END Modals -->