var fechaInicioCorteGlobpivoteMultiplicadoral, fechaFinCorteGlobal, horaFinCorteGlobal,datosFechaCorte = [];
$.ajax({
    url: general_base_url + 'Comisiones/getFechaCorteActual',
    cache: false,
    contentType: false,
    processData: false,
    type: 'GET',
    success: function (response) {
        const data = JSON.parse(response);
        datosFechaCorte = data.fechasCorte;
        fechaInicioCorteGlobal = data.fechasCorte[0].fechaInicio.split(' ')[0].split('-');
        fechaFinCorteGlobal = data.fechasCorte[0].fechaFin.split(' ')[0].split('-');
        //[0] hora [1] minutos [2] segundos
        horaFinCorteGlobal = data.fechasCorte[0].fechaFin.split(' ')[1].split(':');
    },
    async:false
});


sp = {
    initFormExtendedDatetimepickers: function () {
var today = new Date();
var date = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate();
var time = today.getHours() + ":" + today.getMinutes();
    $(".datepicker").datetimepicker({
            format: "DD-MM-YYYY",
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: "fa fa-chevron-left",
                next: "fa fa-chevron-right",
                today: "fa fa-screenshot",
                clear: "fa fa-trash",
                close: "fa fa-remove",
                inline: true,
            },
        });
    },
};

function setInitialValues() {
    // BEGIN DATE
    const fechaInicio = new Date();
    // Iniciar en este año, este mes, en el día 1
    const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
    // END DATE
    const fechaFin = new Date();
    // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
    const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
    finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
    finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');finalBeginDate2 = [('0' + beginDate.getDate()).slice(-2), ('0' + (beginDate.getMonth() + 1)).slice(-2), beginDate.getFullYear()].join('-');
    finalEndDate2 = [('0' + endDate.getDate()).slice(-2), ('0' + (endDate.getMonth() + 1)).slice(-2), endDate.getFullYear()].join('-');
    $('#beginDate').val(finalBeginDate2);
    $('#endDate').val(finalEndDate2);
    $('[data-toggle="tooltip"]').tooltip();
}

