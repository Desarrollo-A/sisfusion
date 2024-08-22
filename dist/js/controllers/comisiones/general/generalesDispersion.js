var dataPlanes = [],planesComer = [], planesCasas = [], numeroTabla = 1;
const pivoteMultiplicador =  [
    {
        id_plan:64,
        valor:(100/0.5),
        porcentaje:0.5
    },
    {
        id_plan:65,
        valor:(100/1)
    },
    {
        id_plan:66,
        valor:12.5
    },
    {
        id_plan:84,
        valor:(100/0.6)
    },
    {
        id_plan:85,
        valor:(100/)
    },
    {
        id_plan:86,
        valor:(100/9.2)
    },
    {
        id_plan:93,
        valor:(100/8.5)
    },
    {
        id_plan:99,
        valor:(100/8.5)
    } ];
$.ajax({
    url: `${general_base_url}Comisiones/getPlanesComisiones`,
    type: 'GET',
    dataType: 'json',
    success: function (data) {
        dataPlanes = data;
         planesCasas = dataPlanes.filter(datos => datos.id_plan == 101);
         planesComer = dataPlanes.filter(datos => datos.id_plan != 101);
    },
    async: false
});

sp = {
    initFormExtendedDatetimepickers: function () {
        $('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove',
                inline: true
            }
        });
    }
}

$('.btn-detalle-plan').on('click', function () {
    cleanElement('mHeader');
    $('#planes-div').show();
    $('#planes').empty().selectpicker('refresh');
    let planesActual = numeroTabla == 1 ? planesComer : planesCasas; 
    for (let i = 0; i < planesActual.length; i++) {
        const id = planesActual[i].id_plan;
        const name = planesActual[i].descripcion.toUpperCase();
        $('#planes').append($('<option>').val(id).text(name));
    }
    $("#detalle-plan-modal .modal-header").append('<h4 class="modal-title">Planes de comisión</h4>');
    $('#planes').selectpicker('refresh');
    $('#detalle-plan-modal').modal();
    $('#detalle-tabla-div').hide();
});

$('#planes').change(function () {
    cleanElement('detalle-tabla-div');
    const idPlan = $(this).val();
    if (idPlan !== '0' || idPlan !== NULL) {
        $.ajax({
            url: `${general_base_url}Comisiones/getDetallePlanesComisiones/${idPlan}`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#plan-detalle-tabla-tbody').empty();
                $('#title-plan').text(`Plan: ${data.descripcion}`);
                $('#detalle-plan-modal').modal();
                $('#detalle-tabla-div').hide();
                const roles = data.comisiones;
                $('#detalle-tabla-div').append(`
                <div class="row subBoxDetail" id="modalInformation">
                    <div class=" col-sm-12 col-sm-12 col-lg-12 text-center" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>PLANES DE COMISIÓN</b></label></div>
                    <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label><b>PUESTO</b></label></div>
                    <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label><b>% COMISIÓN</b></label></div>
                    <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label><b>% NEODATA</b></label></div>
                    <div class="prueba"></div>
                `)
                roles.forEach(rol => {
                    if (rol.puesto !== null && (rol.com > 0 && rol.neo > 0)) {
                        $('#detalle-tabla-div .prueba').append(`
                        <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label>${(rol.puesto.split(' ')[0]).toUpperCase()}</label></div>
                        <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label>${convertirPorcentajes(rol.com)} %</label></div>
                        <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label>${convertirPorcentajes(rol.neo)} %</label></div>
                        `);
                    }

                });
                $('#detalle-tabla-div').append(`
                </div>`)
                $('#detalle-tabla-div').show();
            },
        });
    } else {
        $('#plan-detalle-tabla tbody').append('No tiene un plan asignado');
        $('#detalle-tabla-div').hide();
    }
});

function asignarNumTabla(numTabla) {
    numeroTabla = numTabla;
    console.log(numeroTabla)
}