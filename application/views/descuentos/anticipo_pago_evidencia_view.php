<div class="tab-pane" id="anticipo_adelantos">
    <div class="card">

        <div class="card-content">
            <h3 class="card-title center-align">Adelantos</h3>
            <div class="toolbar">
                <div class="container-fluid p-0">
                    <form method="post" id="formularioAdelantoNomina">
                        <div class="form-group">
                            <div class="col-md-5">
                                <label class="control-label">Monto</label>
                                <input class="form-control input-gral" id="montoSolicitado" type="number" min="1" name="montoSolicitado" required>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Pago</label>
                                <input class="form-control input-gral" id="pa" type="text" name="pagoDescuento" required>
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">Pago</label>
                                <input class="form-control input-gral" id="pagoDescuento23" type="text" min="1" name="pagoDescuento" required>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Pago</label>
                                <input class="form-control input-gral" id="pagoDescuento34" type="text" min="1" name="pagoDescuento" required>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label"></label>
                                <div class="input-group">
                                    <label class="input-group-btn"></label>
                                    <span class="btn btn-info btn-file">
                                        <i class="fa fa-upload"></i> Subir archivo
                                        <input id="file_adelanto" name="file_adelanto" required accept="application/pdf" type="file"/>
                                    </span>
                                    <p id="archivo-extranjero"></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-content" id="evidenciaContainer" style="display: none;">
            <h3 class="card-title center-align">Enviar evidencia</h3>
            <div class="toolbar">
                <div class="container-fluid p-0">
                    <div class="col-md-12" style="display: none">
                        <div class="toggle-button-cover">
                            <div class="button-cover">
                                <div class="button b2" id="button-16">
                                    <input type="checkbox" class="checkbox" id="checkbox" />
                                    <div class="knobs"></div>
                                    <div class="layer"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group d-flex justify-center align-center">
                            <button type="button" id="mandarIncidencias" class="btn-gral-data">
                                Enviar evidencia
                                <i class="fas fa-arrow-circle-up"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-0 col-sm-0 col-md-0 col-lg-6 p-0" id="preview-div">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
