<div class="card hide cartSolicitar_aticipo" id="cartSolicitar_aticipo" name="cartSolicitar_aticipo">
    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <!-- <div class="card"> -->
        <div class="card-content">
        </div>
        <div class="card-content">
            <div class="encabezadoBox">
                <h3 class="card-title center-align">Formulario para alta de adelanto</h3>
                <p class="card-title pl-1">
                    (Infroamción necesaria para el adelanto de pagos)
                </p>
            </div>
            <div class="toolbar">
                <div class="container-fluid p-0">
                    <form method="post" id="anticipo_nomina">
                        <div class="form-group">
                            <div class="col-md-5 form-group m-0">
                                <label class="control-label">Monto </label>
                                <input class="form-control input-gral" id="montoSolicitado" type="number" min="1" name="montoSolicitado" required>
                            </div>
                            <div class="col-lg-6 form-group m-0">
                                <label class="control-label">Descripción del motivo</label>
                                <textarea class="text-modal" type="text" name="descripcionMotivo" id="descripcionMotivo" onkeyup="javascript:this.value=this.value.toUpperCase();" required></textarea>
                            </div>
                            <!-- <div class="col-md-6"> -->
                            <!-- <label class="control-label"></label>
                                                                        <div class="input-group">
                                                                            
                                                                            <label class="input-group-btn"></label>
                                                                            <span class="btn btn-info btn-file">
                                                                                <i class="fa fa-upload"></i> Subir archivo
                                                                                <input id="file_adelanto" name="file_adelanto" required accept="application/pdf" type="file"/>
                                                                            </span>
                                                                            <p id="archivo-extranjero"></p>
                                                                        </div>
                                                                    </div> -->
                            <div class="col-lg-6 form-group m-0">

                            </div>
                            <div class="col-lg-6 form-group m-0">

                                <button type="submit" class="btn btn-primary btn_alta" id="btn_alta" name="btn_alta">Enviar solicitud</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- </div> -->
    </div>
</div>
</div>