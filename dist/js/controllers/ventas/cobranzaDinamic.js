let datos = '';
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

$('#mes').change( function(){
    $('#tableDinamicMKTD').removeClass('hide');
    mes = $('#mes').val();
    anio = $('#anio').val();
    if(anio == ''){
    }else{
        getAssimilatedCommissions(mes, anio, 0, 0);
    }
});
$('#anio').change( function(){
    for (let index = 0; index < meses.length; index++) {
        datos = datos + `<option value="${meses[index]['id']}">${meses[index]['mes']}</option>`;
        $('#mes').html(datos);
        $('#mes').selectpicker('refresh');
        }
    $("#plaza").html("");
    $("#gerente").html("");
    mes = $('#mes').val();
    if(mes == '')
    {
        mes =0;
    }
    anio = $('#anio').val();
    $(document).ready(function(){
        $.post(general_base_url + "Comisiones/listSedes", function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++){
                var id = data[i]['id_sede'];
                var name = data[i]['nombre'];
                $("#plaza").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#plaza").selectpicker('refresh');
            $("#gerente").selectpicker('refresh');
        }, 'json');
    });
});
$(document).ready(function(){
    $('#anio').html("");
    $('#plaza').html("");
    $('#gerente').html("");
    var d = new Date();
    var n = d.getFullYear();
    for (var i = n; i >= 2020; i--){
        var id = i;
        $("#anio").append($('<option>').val(id).text(id));
    }
    $("#anio").selectpicker('refresh');
    $("#plaza").selectpicker('refresh');
    $("#gerente").selectpicker('refresh');
});



$('#plaza').change( function(){
    $("#gerente").html("");
    mes = $('#mes').val();
    anio = $('#anio').val();
    plaza = $('#plaza').val();
    if(mes == '')
    {
        mes =0;
    }
    $(document).ready(function(){
        $.post(general_base_url + "Comisiones/listGerentes/"+plaza, function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++)
            {
                var id = data[i]['id_usuario'];
                var name = data[i]['nombreUser'];
                $("#gerente").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#gerente").selectpicker('refresh');
        }, 'json');
    });
    getAssimilatedCommissions(mes, anio, plaza, 0);
});

$('#gerente').change( function(){
    mes = $('#mes').val();
    anio = $('#anio').val();
    plaza = $('#plaza').val();
    gerente = $('#gerente').val();
    if(mes == '') {
        mes =0;
    }
    getAssimilatedCommissions(mes, anio, plaza, gerente);
});

var tr;
var tableDinamicMKTD2 ;
var totaPen = 0;

let titulos = [];
$('#tableDinamicMKTD thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tableDinamicMKTD').DataTable().column(i).search() !== this.value) {
            $('#tableDinamicMKTD').DataTable().column(i).search(this.value).draw();
        }
    });
    titulos.push(title);    
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

function getAssimilatedCommissions(mes, anio, plaza, gerente){
    $('#tableDinamicMKTD').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.monto_vendido);
        });
        var to = formatMoney(total);
        document.getElementById("myText_vendido").textContent =to;
    });

$("#tableDinamicMKTD").prop("hidden", false);
    tableDinamicMKTD2 = $("#tableDinamicMKTD").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX:true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE DINÁMICO',
            exportOptions: {
                columns: [0,1,2,3,4,5,6],
                format: {
                    header: function (d, columnIdx) {
                        return ' '+titulos[columnIdx] +' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
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
                if(d.status == 0)
                    return '<p class="m-0"      >'+d.lotes_vendidos+'</p>';
                else
                    return '<p class="m-0">'+d.lotes_vendidos+'</p>';
            }
        },
        {
            data: function( d ){
                if(d.status == 0)
                    return '<p class="m-0" style="color:crimson;">'+formatMoney(d.monto_vendido)+'</p>';
                else
                    return '<p class="m-0">'+formatMoney(d.monto_vendido)+'</p>';
            }
        },
        {
            data: function( d ){
                if(d.status == 0)
                    return '<p class="m-0" style="color:crimson;">'+d.asesor+'</p>';
                else
                    return '<p class="m-0">'+d.asesor+'</p>';
            }
        },
        {
            data: function( d ){
                if(d.status == 0)
                    return '<p class="m-0" style="color:crimson;">'+d.gerente+'</p>';
                else
                    return '<p class="m-0">'+d.gerente+'</p>';
            }
        },
        {
            data: function( d ){
                if(d.status == 0)
                    return '<p class="m-0" style="color:crimson;">'+($('select[name="mes"] option:selected').text()).toUpperCase()+'</p>';
                else
                    return '<p class="m-0">'+($('select[name="mes"] option:selected').text()).toUpperCase()+'</p>';
            }
        },
        {
            data: function( d ){
                if(d.status == 0)
                    return '<p class="m-0" style="color:crimson;">'+(d.nombre).toUpperCase()+' </p>';
                else 
                    return '<p class="m-0">'+(d.nombre).toUpperCase()+' </p>';
            }
        },
        {
            data: function( d ){
                if(d.status == 0)
                    return '<p class="m-0"><span class="label lbl-warning">CANCELADO</span></p>';
                else
                    return '<p class="m-0"><span class="label lbl-azure">ACTIVO</span></p>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            'searchable':false,
            'className': 'dt-body-center',
        }],
        ajax: {
            "url": url2 + "Comisiones/getDatosCobranzaDimamic/" + mes + "/" + anio+ "/" + plaza+ "/" + gerente,
            "type": "POST",
            cache: false,
            data: function( d ){}
        },
        order: [[ 1, 'asc' ]]
    });

    $('#tableDinamicMKTD').on('click', 'input', function() {
        tr = $(this).closest('tr');
        var row = tableDinamicMKTD2.row(tr).data();
        if (row.pa == 0) {
            row.pa = row.monto_vendido;
            totaPen += parseFloat(row.pa);
            tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
        } else{
            totaPen -= parseFloat(row.pa);
            row.pa = 0;
        }
        $("#totpagarPen").html(formatMoney(totaPen));
    });
}
