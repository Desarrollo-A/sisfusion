$(document).ready(function () {
    peticionDataTable();
});

function mostrarNotificacion(mensaje, tipo) {
    alerts.showNotification("top", "right", mensaje, tipo);
}

function validarFechas(diaInicio, diaFin, diaTijuana, mes, mesFin, fechaValue, añoInicio, añoFin, añoTijuana) {

    // Validación de años
    if (isNaN(añoInicio) || isNaN(añoFin) || isNaN(añoTijuana) || añoInicio !== añoFin || añoInicio !== añoTijuana) {
        mostrarNotificacion("Por favor, ingresa fechas con años iguales.", "danger");
        return false;
    }

    // Validación de días y meses
    if (isNaN(diaInicio) || diaInicio < 1 || diaInicio > 31 || isNaN(diaFin) || diaFin < 1 || diaFin > 31 || isNaN(diaTijuana) || diaTijuana < 1 || diaTijuana > 31 || isNaN(mes) || mes < 1 || mes > 12 || isNaN(mesFin) || mesFin < 1 || mesFin > 12) {
        mostrarNotificacion("Por favor, ingresa fechas válidas.", "danger");
        return false;
    }

    // Comparación de días
    const diferenciaDiasFin = diaFin - diaInicio;
    const diferenciaDiasTijuana = diaTijuana - diaInicio;

    if (diferenciaDiasFin !== 1 || diferenciaDiasTijuana !== 1) {
        if (diferenciaDiasFin !== 1) {
            mostrarNotificacion("La FECHA FIN GENERAL debe ser el día siguiente a la FECHA DE INICIO. Por favor, elige otra fecha.", "danger");
        } else {
            mostrarNotificacion("La FECHA TIJUANA debe ser el día siguiente a la FECHA DE INICIO. Por favor, elige otra fecha.", "danger");
        }
        return false;
    }

    // Comparación de meses
    if (mes !== mesFin || mes !== fechaValue) {
        mostrarNotificacion("No puedes EDITAR, debido a que los meses no coinciden.", "danger");
        return false;
    }

    return true;
}

function compararFechas(fechaInicio, fechaFinGeneral, fechaTijuana) {
    const fechaInicioObj = new Date(fechaInicio);
    const fechaFinObj = new Date(fechaFinGeneral);
    const fechaTijuanaObj = new Date(fechaTijuana);

    if (fechaFinObj <= fechaInicioObj) {
        mostrarNotificacion("La FECHA FIN GENERAL no puede ser mayor o igual que la FECHA INICIO.", "danger");
        return false;
    } else if (fechaTijuanaObj <= fechaInicioObj) {
        mostrarNotificacion("La FECHA TIJUANA no puede ser mayor o igual que la FECHA INICIO.", "danger");
        return false;
    }

    return true;
}

function editarFila(idFechaCorte) {
    if (!idFechaCorte) {
        console.error("El idFechaCorte es nulo o undefined");
        return;
    }

    // Obtener valores de los inputs
    const fechaInicioInput = document.getElementById(`fechaInicio_${idFechaCorte}`);
    const nuevaFechaInicio = fechaInicioInput.value;
    const mes = parseInt(nuevaFechaInicio.split('-')[1], 10);
    const diaInicio = parseInt(nuevaFechaInicio.split('-')[2], 10);

    const nuevaFechaFinGeneral = document.getElementById(`fechaFin_${idFechaCorte}`).value;
    const nuevaFechaFin = nuevaFechaFinGeneral;
    const mesFin = parseInt(nuevaFechaFin.split('-')[1], 10);
    const diaFin = parseInt(nuevaFechaFinGeneral.split('-')[2], 10);

    const fechaValue = parseInt(document.getElementById(`mes_${idFechaCorte}`).value, 10);

    const nuevaFechaTijuana = document.getElementById(`fechaTijuana_${idFechaCorte}`).value;
    const diaTijuana = parseInt(nuevaFechaTijuana.split('-')[2], 10);

    // Obtener años
    const añoInicio = parseInt(nuevaFechaInicio.split('-')[0], 10);
    const añoFin = parseInt(nuevaFechaFinGeneral.split('-')[0], 10);
    const añoTijuana = parseInt(nuevaFechaTijuana.split('-')[0], 10);

    // Validar fechas
    if (!validarFechas(diaInicio, diaFin, diaTijuana, mes, mesFin, fechaValue, añoInicio, añoFin, añoTijuana)) {
        return;
    }

    // Comparar fechas
    if (!compararFechas(nuevaFechaInicio, nuevaFechaFinGeneral, nuevaFechaTijuana)) {
        return;
    }

    $.ajax({
        url: 'editarFecha',
        type: 'post',
        data: { idFechaCorte, nuevaFechaInicio, nuevaFechaFinGeneral, nuevaFechaTijuana },
        success: function (respuesta) {
            if (respuesta !== true) {
                peticionDataTable();
                mostrarNotificacion("Datos actualizados con éxito.", "success");
            } else {
                mostrarNotificacion("No se pudo actualizar los datos.", "danger");
            }
        }
    });
}

function validarNumeros(input) {
    input.value = input.value.replace(/[^0-9-]/g, '');
}

let ventasFechas = [];
let OaamFechas = [];
let ResguardoFechas = [];

var permisosEdicion = document.getElementById('permisos-edicion').value;

function htmlArmado(tipoCorte, containerId) {
    const fechas = (tipoCorte === 1) ? ventasFechas : (tipoCorte === 2) ? OaamFechas : ResguardoFechas;
    const container = document.getElementById(containerId);

    container.innerHTML = '';

    for (let i = 0; i < fechas.length; i++) {
        const editarBtn = (permisosEdicion === "1") ? `<a class="btn btn-primary btn-edit" onclick="editarFila(${fechas[i].idFechaCorte})">Editar</a>` : '';

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
                        <input id="mes_${fechas[i].idFechaCorte}" name="mes_${fechas[i].idFechaCorte}" class="form-control input-gral" type="hidden" value="${fechas[i].mes}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="fechaInicio_ventas">FECHA INICIO:</label>
                        <input type="text" id="fechaInicio_${fechas[i].idFechaCorte}" name="fechaInicio_ventas" class="form-control input-gral" value="${fechas[i].fechaInicioSinHora}" oninput="validarNumeros(this)">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="fechaFin_ventas">FECHA FIN GENERAL:</label>
                        <input type="text" id="fechaFin_${fechas[i].idFechaCorte}" name="fechaFin_ventas" class="form-control input-gral" value="${fechas[i].fechaFinGeneralSinHora}" oninput="validarNumeros(this)">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="fechaTijuana_ventas">FECHA TIJUANA:</label>
                        <input type="text" id="fechaTijuana_${fechas[i].idFechaCorte}" name="fechaTijuana_ventas" class="form-control input-gral" value="${fechas[i].fechaTijuanaSinHora}" oninput="validarNumeros(this)">
                    </div>
                    <div class="col-md-1 mb-3 text-center">
                        <label for="editarVentas">ACCIONES:</label>
                        ${editarBtn}
                    </div>
                    <div class="col-md-1">
                        <br class="my-1">
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
