$('#mes').change(function() {
    anio = $('#anio').val();
    mes = $('#mes').val();
    if(anio == ''){
        anio=0;
    }else{
        getAssimilatedCommissions(mes, anio);
    }
    $('#tabla_historialGral').removeClass('hide');
});

$('#anio').change(function() {
    for (let index = 0; index < meses.length; index++) {
        datos = datos + `<option value="${meses[index]['id']}">${meses[index]['mes']}</option>`;
        $('#mes').html(datos);
        $('#mes').selectpicker('refresh');
        }
    mes = $('#mes').val();
    if(mes == ''){
        mes=0;
    }
    anio = $('#anio').val();
    if (anio == '' || anio == null || anio == undefined) {
        anio = 0;
    }
});

let meses = [
    {
        id: '01',
        mes:'ENERO'
    },
    {
        id:'02',
        mes:'FEBRERO'
    },
    {
        id:'03',
        mes:'MARZO'
    },
    {
        id:'04',
        mes:'ABRIL'
    },
    {
        id:'05',
        mes:'MAYO'
    },
    {
        id:'06',
        mes:'JUNIO'
    },
    {
        id:'07',
        mes:'JULIO'
    },
    {
        id:'08',
        mes:'AGOSTO'
    },
    {
        id:'09',
        mes:'SEPTIEMBRE'
    },
    {
        id:'10',
        mes:'OCTUBRE'
    },
    {
        id:'11',
        mes:'NOVIEMBRE'
    },
    {
        id:'12',
        mes:'DICIEMBRE'
    }
];
let anios = [2019,2020,2021,2022,2023];
let datos = '';
let datosA = '';

for (let index = 0; index < anios.length; index++) {
    datosA = datosA + `<option value="${anios[index]}">${anios[index]}</option>`;
}
$('#anio').html(datosA);
$('#anio').selectpicker('refresh');


$('#tabla_historialGral').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});


let titulos = [];
$('#tabla_historialGral thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $( 'input', this ).on('keyup change', function () {
        if ($('#tabla_historialGral').DataTable().column(i).search() !== this.value ) {
            $('#tabla_historialGral').DataTable().column(i).search(this.value).draw();
        }
    });
});

var tr;
var tabla_historialGral2 ;
var totaPen = 0;

function getAssimilatedCommissions(mes, anio){
    $("#tabla_historialGral").prop("hidden", false);
    tabla_historialGral2 = $("#tabla_historialGral").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [
        {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COBRANZA APARTADOS',
            exportOptions: {
                columns: [0,1,2,3,4],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
        {
            data: function( d ){
            var lblStats;
            lblStats ='<p class="m-0">'+d.nombre+'</p>';
            return lblStats;
            }
        },
        {
            data: function( d ){
                return '<p class="m-0">'+formatMoney(d.monto_vendido)+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0">'+d.lotes_vendidos+'</p>';
            }
        },
        {
            data: function( d ){
                if(d.status == 0)
                    return '<span class="label lbl-warning">CANCELADO</span>';
                else
                    return '<span class="label lbl-green">VENDIDO</span>';
            }
        },
        {
            data: function( d ){
                if(d.status == 0)
                    return '<span class="label lbl-warning">'+($('select[name="mes"] option:selected').text())+'</span>';
                else
                    return '<span class="label lbl-azure">'+($('select[name="mes"] option:selected').text())+'</span>';
            }
        }],
        columnDefs: [{
            orderable: false,
            targets:   0,
            'searchable':false,
            'className': 'dt-body-center',
        }],
        ajax: {
            "url": general_base_url + "Comisiones/getDatosCobranzaIndicador/"+ mes +"/"+ anio,
            "type": "POST",
            cache: false,
            data: function( d ){}
        },
        order: [[ 1, 'asc' ]]
});


$("#form_aplicar").submit( function(e) {
    e.preventDefault();
    }).validate({
        submitHandler: function( form ) {
            var data = new FormData( $(form)[0] );
            $.ajax({
                // url: url + "Comisiones/pausar_solicitud/",
                url: general_base_url+'Comisiones/agregar_comentarios',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if( true ){
                        $("#modal_nuevas").modal('toggle' );
                        alerts.showNotification("top", "right", "Se guardó tu información correctamente", "success");
                        setTimeout(function() {
                            tabla_historialGral2.ajax.reload();
                            // tabla_otras2.ajax.reload();
                        }, 3000);
                    }else{
                        alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                    }
                },error: function( ){
                    alert("ERROR EN EL SISTEMA");
                }
            });
        }
    });
}

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});
