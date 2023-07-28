<link href="<?= base_url() ?>dist/css/commonModals.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<style>
    .modal-backdrop{
        z-index:9;
    }
 

</style>
<!------MODAL CONFIRMACIÓN CAMBIO DE PESTAÑA--------> 
<div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm" >
            <div class="modal-content" style="padding: 0 20px;">
                <div class="modal-head pt-1 text-center">
                    <h4>¿Al cambiar de pestaña se limpiarán los datos cargados, deseas continuar?</h4>
                </div>
                <div class="modal-body" >
                    <div class="container-fluid">
                        <div class="row" id="" >

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnCancel" class="btn btn-danger btn-simple">Cerrar</button>
                    <button type="button" id="btnLimpiar" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
</div>
<!--------> 
<div class="modal fade" id="modalHistorial" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-head pt-1 text-center">
                    <h3>Historial</h3>
                </div>
                <div class="modal-body overflow-auto scroll-styles " style="height: 300px;">
                    <div class="container-fluid">
                        <div class="row" id="historialAut" >

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
</div>

<div class="modal fade" id="avanzarAut" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" id="modalAutorizacion">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h4 id="titleAvance"></h4>
            </div>
            
            <form id="avanceAutorizacion" name="avanceAutorizacion" method="post">
                <div class="modal-body" id="modal-body">
                    
                </div>
                <input type="hidden" name="id_autorizacion" id="id_autorizacion">
                    <input type="hidden" name="estatus" id="estatus">
                    <input type="hidden" name="tipo" id="tipo">
                <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="modalConsultarPlanes" data-keyboard="false" data-backdrop="static" style="z-index: 99;">
    <div class="modal-dialog modal-lg boxContent">
        <div class="modal-content">
            <div class="modal-header text-center">
                <i  data-toggle="tooltip" title="Cerrar" data-dismiss="modal" class="fas fa-times fl-r"></i>
                <h4 class="modal-title card-title fw-500 ">Consultar planes de ventas</h4><br>
            </div>
            <div class="modal-body text-center toolbar m-0 p-0">

            </div>
        </div>
    </div>
</div>


<!-- modales de autorizaciones msi-->
<div class="modal fade" id="addFile" style="z-index: 9999;" >
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <center><h3 class="modal-title" id="myModalLabel"><span class="lote"></span></h3></center>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <label class="input-group-btn">
								<span class="btn btn-primary btn-file">
								Seleccionar archivo&hellip;<input type="file" name="file_msni" id="file_msni" style="display: none;">
								</span>
                    </label>
                    <input type="text" class="form-control" id= "txtexp" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                <button type="button" id="sendFile" class="btn btn-primary">Actualizar </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="verAut" style="z-index: 9999;" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content" >
            <div class="modal-header">
                <center><h3 class="modal-title" id="myModalLabel"><span class="lote"></span></h3></center>
            </div>
            <form name="cambiosMSIF" id="cambiosMSIF" method="post">
                <div class="modal-body">
                    <div class="material-datatables">
                        <div class="form-group">
                            <table class="table-striped table-hover" id="tabla_msni_visualizacion" name="tabla_msni_visualizacion">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NOMBRE</th>
                                    <th>MSI</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary no-shadow rounded-circle" id="cambiosGuardaMSI">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalHistorialAM" style="z-index: 9999;" >
    <div class="modal-dialog ">
        <div class="modal-content" >
            <div class="modal-header">
                <center><h3 class="modal-title" id="myModalLabelAM">HISTORIAL</h3></center>
            </div>
            <div class="modal-body" style="height: 550px;overflow-x: auto;">
                <div id="historialAutAM" >
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="avanzarAutAM" style="z-index: 9999;" >
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <center><h3 class="modal-title" id="tittleModalAM"></h3><h5 id="leyendaAdvAM"></h5></center>
            </div>
            <div class="modal-body">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <label>Comentario:</label>
                    <textarea class="text-modal" name="comentarioAvance" id="comentarioAvanceAM" rows="3"></textarea>
                    <br>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary no-shadow" id="enviarAutBtnAM">Enviar</button>
            </div>
        </div>
    </div>
</div>
