$(document).ready(function () {
    peticionDataTable();
});

function editarFila(idFechaCorte) {

    if (idFechaCorte) {
        const nuevaFechaInicio = document.getElementById(`fechaInicio_${idFechaCorte}`).value;
        const nuevaFechaFinGeneral = document.getElementById(`fechaFin_${idFechaCorte}`).value;
        const nuevaFechaTijuana = document.getElementById(`fechaTijuana_${idFechaCorte}`).value;
        const mesVentas = document.getElementById(`mes_ventas`).value.toUpperCase();

        var fechaActual = new Date();
        var nombreMes = fechaActual.toLocaleDateString(undefined, { month: 'long' });
        var prueba = nombreMes.toLocaleUpperCase();

        console.log("mesVentas:", mesVentas);
        console.log("prueba:", prueba);
        
        
        if (new Date(nuevaFechaFinGeneral) < new Date(nuevaFechaInicio)) {
            alerts.showNotification("top", "right", "La fecha fin general no puede ser mayor que la fecha de inicio.", "danger");
            return;
        }
        
        if (new Date(nuevaFechaTijuana) < new Date(nuevaFechaInicio)) {
            alerts.showNotification("top", "right", "La fecha de Tijuana no puede ser mayor que la fecha de inicio.", "danger");
            return;
        }
        
        if (mesVentas === nombreMes) {
            console.log("true");
        } else {
            alerts.showNotification("top", "right", "No puedes escoger otro mes que no sea el actual.", "danger");
            return;
        }
        




        $.ajax({
            url: 'editarFecha',
            type: 'post',
            data: { idFechaCorte, nuevaFechaInicio, nuevaFechaFinGeneral,nuevaFechaTijuana },
            success: function (respuesta) {

                if(respuesta!== true){
                    peticionDataTable();
                    alerts.showNotification("top", "right", "Datos actualizados con éxito.", "success");
                }else{
                    alerts.showNotification("top", "right", "No se pudo actualizar los datos.", "danger");
                }
                                
            }
        });
    } else {
        console.error("El ID es nulo o indefinido");
    }
}

let ventasFechas = [];
let OaamFechas = [];
let ResguardoFechas = [];

function htmlArmado(tipoCorte, containerId) {
    const fechas = (tipoCorte === 1) ? ventasFechas : (tipoCorte === 2) ? OaamFechas : ResguardoFechas;
    const container = document.getElementById(containerId);
    container.innerHTML = '';

    for (let i = 0; i < fechas.length; i++) {
        container.innerHTML += `
        <div class="row justify-center col-xs-10 col-sm-10 col-md-10 col-lg-10">
        <div class="material-datatables">
            <div class="form-group">
                <div class="card-content">
                    <div class="col-md-12">
                        <hr class="my-4">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="mes_ventas">MES:</label>
                        <input type="text" id="mes_ventas" name="mes_ventas" class="form-control input-gral" readonly value="${fechas[i].nombreMes}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="fechaInicio_ventas">FECHA INICIO:</label>
                        <input type="text" id="fechaInicio_${fechas[i].idFechaCorte}" name="fechaInicio_ventas" class="form-control input-gral" value="${fechas[i].fechaInicioSinHora}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="fechaFin_ventas">FECHA FIN GENERAL:</label>
                        <input type="text" id="fechaFin_${fechas[i].idFechaCorte}" name="fechaFin_ventas" class="form-control input-gral" value="${fechas[i].fechaFinGeneralSinHora}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="fechaTijuana_ventas">FECHA TIJUANA:</label>
                        <input type="text" id="fechaTijuana_${fechas[i].idFechaCorte}" name="fechaTijuana_ventas" class="form-control input-gral" value="${fechas[i].fechaTijuanaSinHora}">
                    </div>
                    <div class="col-md-1 mb-3 text-center">
                        <label for="editarVentas">EDITAR:</label>
                        <a class="btn btn-primary btn-edit" onclick="editarFila(${fechas[i].idFechaCorte})">Editar</a>
                    </div>
                    <div class="col-md-12">
                        <br class="my-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
        `;
    }
}

function peticionDataTable() {
    $.ajax({
        url: 'getDatosFechas',
        type: 'post',
        dataType: 'JSON',
        success: function (INFORMACION) {
            ventasFechas = INFORMACION.filter(fechas => fechas.tipoCorte == 1);
            OaamFechas = INFORMACION.filter(fechas => fechas.tipoCorte == 2);
            ResguardoFechas = INFORMACION.filter(fechas => fechas.tipoCorte == 3);

            htmlArmado(1, 'fechasAjuste');
            htmlArmado(2, 'fechasAjusteOOAM');
            htmlArmado(3, 'fechasResguardo');
        }
    });
}
