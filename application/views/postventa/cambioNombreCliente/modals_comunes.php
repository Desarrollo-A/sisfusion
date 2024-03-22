<div class="modal fade" id="inicioTramite" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <b><h4 class="card-title text-center">Complementa la información para el inicio del trámite decambio denombre.</h4></b>
                <form class="card-content" id="formCambioNombre" name="formCambioNombre" method="POST">
                    <div class="modal-body pt-0">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group text-left m-0">
                                        <label class="control-label label-gral">Tipo de trámite (<small style="color: red;">*</small>)</label>
                                        <select class="selectpicker select-gral m-0" data-style="btn"title="SELECCIONA UNA OPCIÓN" data-size="7" id="tipoTramite" name="tipoTramite"data-live-search="true">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group text-left m-0">
                                        <label class="control-label label-gral">Nombre (<small style="color: red;">*</small>)</label>
                                        <input id="txtNombre" name="txtNombre" class="form-control input-gral" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group text-left m-0">
                                        <label class="control-label label-gral">Apellido paterno</label>
                                        <input id="txtApellidop" name="txtApellidop" class="form-control input-gral" type="text">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left m-0">
                                        <label class="control-label label-gral">Apellido materno</label>
                                        <input id="txtApellidom" name="txtApellidom" class="form-control input-gral" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="idLote" name="idLote">
                        <input type="hidden" id="idCliente" name="idCliente">
                        <input type="hidden" id="tipoTransaccion" name="tipoTransaccion">
                        <input type="hidden" id="idRegistro" name="idRegistro">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="avance" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <b><h4 class="card-title text-center">¿Estás seguro de avanzar este registro?</h4></b>
                <form method="post" id="formAvanzarEstatus">
                    <div class="container-fluid">
                        <div class="row">
                            <div id="divTotalNeto" class="hide"></div>
                            <!--<div class="col-lg-12">
                                <label class="control-label">Precio Final</label>
                                <input class="form-control input-gral mb-1" name="precioFinal" autocomplete="off" id="precioFinal"
                                       style="margin-top: 0px;"
                                       disabled value="$25.2">
                            </div>-->
                            <div class="col-12">
                                <label class="control-label">Comentario</label>
                                <input class="form-control input-gral text-modal mb-1" name="comentario" autocomplete="off" id="comentarioAvanzar">
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" id="idLoteA" name="idLoteA">
                                <input type="hidden" id="idClienteA" name="idClienteA">
                                <input type="hidden" id="tipoTransaccionA" name="tipoTransaccionA">
                                <input type="hidden" id="tipo" name="tipo">
                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>