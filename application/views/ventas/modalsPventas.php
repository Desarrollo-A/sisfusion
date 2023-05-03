<link href="<?= base_url() ?>dist/css/commonModals.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<style>
    .modal-backdrop{
        z-index:9;
    }
 

</style>

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
                <h4 class="modal-title card-title"><b id="titleAvance"></b></h4>
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

