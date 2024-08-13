<div class="tab-pane" id="dispersionCasas">
   <div class="text-center">
        <h3 class="card-title center-align">Dispersión de pago Casas</h3>
        <p class="card-title pl-1">Lotes nuevos sin dispersar, con saldo disponible.</p>
    </div>

    <div class="toolbar">
        <div class="container-fluid p-0">
            <?php $this->load->view('comisiones/dispersion/menu_superior/menu_superior_view'); ?>
            <div class="material-datatables">
                <div class="form-group">
                    <table class="table-striped table-hover" id="tabla_dispersion_casas" name="tabla_dispersion_casas">
                        <thead>
                        <tr>
                            <th></th>
                            <th>PROYECTO</th>
                            <th>CONDOMINIO</th>
                            <th>LOTE</th>
                            <th>ID LOTE</th>
                            <th>CLIENTE</th>
                            <th>TIPO CRÉDITO</th>
                            <th>MODALIDAD</th>
                            <th>CONTRATACIÓN</th>
                            <th>PLAN DE VENTA</th>
                            <th>PRECIO FINAL LOTE</th>
                            <th>% COMISION TOTAL</th>
                            <th>IMPORTE COMISION PAGADA</th>
                            <th>IMPORTE COMISION PENDIENTE</th>
                            <th>DETALLES</th>
                            <th>FECHA ACTUALIZACIÓN</th>
                            <th>ACCIONES</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


