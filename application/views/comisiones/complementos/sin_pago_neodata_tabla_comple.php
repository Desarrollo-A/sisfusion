<div class="encabezadoBox">
    <p class="card-title pl-1">Comisiones sin pago reflejado en NEODATA y que por ello no se han dispersado ciertos lotes con tus comisiones.</p>
</div>
<div class="toolbar">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="m-0" for="proyecto">Proyecto</label>
                    <select name="proyecto_sp" id="proyecto_sp" class="selectpicker select-gral proyecto" data-estatus="0" data-style="btn btn-second" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required></select>
                </div>
            </div>
            <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="m-0" for="proyecto">Condominio</label>
                    <select name="condominio_sp" id="condominio_sp" class="selectpicker select-gral condominio" data-estatus="0" data-style="btn btn-second" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required><option disabled selected>Selecciona una opción</option></select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="material-datatables" id="boxTablaComisionesSinPago">
    <table class="table-striped table-hover" id="tabla_comisiones_sin_pago" name="tabla_comisiones_sin_pago">
        <thead>
            <tr>
                <th>ID</th>
                <th>PROYECTO</th>
                <th>CONDOMINIO</th>
                <th>LOTE</th>
                <th>CLIENTE</th>
                <th>ASESOR</th>
                <th>COORDINADOR</th>
                <th>GERENTE</th>
                <th>ESTATUS</th>
            </tr>
        </thead>
    </table>
</div>