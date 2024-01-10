var tr;
var tabla_comisiones_contratacion;
let titulos_intxt = [];

$(document).ready(function () {

    $.post(general_base_url+"/Comisiones/usuarios_rol_7", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            $("#asesorContratacion").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#asesorContratacion").selectpicker('refresh');
    }, 'json');

    setInitialDates();
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});

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

function setInitialDates() {
    var beginDt = moment().startOf('year').format('DD/MM/YYYY');
    var endDt = moment().format('DD/MM/YYYY');
    $('.beginDate').val(beginDt);
    $('.endDate').val(endDt);
}

function formatDate(date) {
    var dateParts = date.split("/");
    var d = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]), month = '' + (d.getMonth() + 1), day = '' + d.getDate(), year = d.getFullYear();
    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;
    return [year, month, day].join('-');
}

$(document).on('click', '.searchByDateRange', function(){
    let fechaInicio = formatDate( $(".beginDate").val());
    let fechaFin = formatDate( $(".endDate").val());
    let asesorF =  $('#asesorContratacion').val();
    if((fechaInicio <= fechaFin ) || asesorF ){
        fillTableLotificacion(fechaInicio, fechaFin);
    }else{
        alerts.showNotification("top", "right", "Fecha inicial no puede ser mas mayor a la fecha final", "warning");
    }
});

$('#tabla_comisiones_contratacion thead tr:eq(0) th').each( function (i) {
    if(i != 0){
        var title = $(this).text();
        titulos_intxt.push(title);
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
        $('input', this).on('keyup change', function() {
            if ($('#tabla_comisiones_contratacion').DataTable().column(i).search() !== this.value ) {
                $('#tabla_comisiones_contratacion').DataTable().column(i).search(this.value).draw();
                var total = 0;
                var index = tabla_comisiones_contratacion.rows({ selected: true, search: 'applied' }).indexes();
                var data = tabla_comisiones_contratacion.rows(index).data();
                $.each(data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
            }
        });
    } 
    else {
        $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
    }
});
    
function fillTableLotificacion(fechaInicio, fechaFin){

    especialesDataTable = $('#tabla_comisiones_contratacion').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'Reporte Contración',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7],
                    format: {
                        header:  function (d, columnIdx) {
                            return ' ' + titulos_intxt[columnIdx] + ' ';
                            }
                        }
                }
            }
        ],
        pagingType: "full_numbers",
        fixedHeader: true,
        
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        scrollX: true,
        destroy: true,
        ordering: false,
        columns: [
            {data: 'idLote'},
            {data: 'nombre_lote'},
            {data: 'fechaApartado'},
            {data: 'plan_comision'},
            {data: 'NombreCliente'},
            {data: 'Asesor'},
            {data: 'Gerente'}
        ],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: "comisiones_reporteDatos",
            type: "POST",
            cache: false,
            data :{
                beginDate: fechaInicio,
                endDate: fechaFin
            }
        }
    });
}
