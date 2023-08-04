var tr;
var tabla_bonos2 ;
var totaPen = 0;
let numNUS ;
let numMKTD ;
let titulos = [];
let NewHeader=[];
let aaaa = [3,5,7];
var columns = [
    { "title":"One" },
    { "title":"Two" }, 
    { "title":"cuatro" },
    { "title":"cinco" }
];

let TodosDatos=[];
var contador=0;
EjecutarFuncion(0,0);

async function EjecutarFuncion(mes,anio){
    if(mes != 0){
    contador=1;
    }  
    $.ajax({
        type: 'POST',
        url: general_base_url + 'index.php/Comisiones/ReporteTotalMktdFINAL/'+mes+"/"+anio,
        dataType: 'json',
        beforeSend: function(){
        },
        success: function(data) {
            var NUS = formatMoney(data['sumaBono1']);
            document.getElementById("totalN").innerHTML = NUS;
            var MK = formatMoney(data['sumaBono2']);
            document.getElementById("totalM").innerHTML = MK;
            var comi = formatMoney(data['sumaTotalComision']);
            document.getElementById("totalC").innerHTML = comi;
            $('#tabla_bonos').empty();
            $('#qlv').empty();
            NewHeader = [];
            TodosDatos = [];
            titulos = [];
            TodosDatos = data['data'];
            numNUS = data['numeroMayorNUS'];
            numMKTD = data['numeroMayorMKTD'];
            NewHeader[0] = {'title':'Usuario'};
            if(mes != 0){
                let mesActual = $('select[name="mes"] option:selected').text();
                NewHeader[1] = {'title':'Comisión '+mesActual};
            }else{
                NewHeader[1] = {'title':'Comisión total'};
            }
            let NumeroTotal = (numNUS + numMKTD) + 3;
            for (let index = 2; index < ((numNUS * 2) + (numMKTD *2)) +2; index++) {
                if(index%2 == 0){
                    NewHeader[index] = {'title':'# Pago'};
                }else{
                    NewHeader[index] = {'title':'Monto'};
                }
            }
            NewHeader[NewHeader.length] = {'title':'Total'};
            if(contador == 0){
                CrearTable();
            }else{
                $('#tabla_bonos').DataTable().destroy();
                $('#tabla_bonos thead').empty();
                $('#tabla_bonos tbody').empty();
            CrearTable();
            }
        },
        complete: function(data){
        },
        async: false 
    })
}
        
$('#mes').change( function(){
    mes = $('#mes').val();
    anio = $('#anio').val();
    let mesActual = $('select[name="mes"] option:selected').text();
    if(anio == ''){
    }
    else{
        EjecutarFuncion(mes, anio);
    }
});

$(document).ready(function(){
    $('#anio').html("");
    var d = new Date();
    var n = d.getFullYear();
    for (var i = n; i >= 2020; i--){
        var id = i;
        $("#anio").append($('<option>').val(id).text(id));
    }
    $("#anio").selectpicker('refresh');
});

$('#anio').change( function(){
    $("#plaza").html("");
    $("#gerente").html("");
    mes = $('#mes').val();
    if(mes == ''){
        mes =0;
    }
    else{
        anio = $('#anio').val();
        EjecutarFuncion(mes, anio);
    }
    $('#ptabla_bonos').removeClass('hide');      
});

function CrearTable() {
    let Posiciones = [];
    let impares = [];
    let pares = [];
    let ultimo = NewHeader.length -1;
    for (let h = 0; h < NewHeader.length; h++) {
        if(h%2 != 0){
            impares.push(h);
        }else{
            if(h != NewHeader.length-1){
                pares.push(h);
            } 
        } 
        Posiciones.push(h);
    }
    tabla_bonos1 = $('#tabla_bonos').DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        // scrollX: true, se coloca doble header
        // bAutoWidth: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COMISIONES',
            exportOptions: {
                columns: Posiciones,
                format: {
                    header:  function (d, columnIdx) {
                        if(columnIdx==Posiciones.length -1){
                            return ' TOTAL '; 
                        }else{
                            return ' '+titulos[columnIdx] +' '; 
                        }       
                    },
                }
            }
        }],
        destroy: true,
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        "searching": true,
        "ordering": false,
        "data": TodosDatos,
        "columns": NewHeader,
        columnDefs: [
            {
                "targets": pares,
                "render": function(data, type, full, meta) {
                    return  '<p class="m-0"><center><b>'+data+'</b></center></p>';
                }
            },
            {
                "targets": impares,
                "render": function(data, type, full, meta) {
                    return  '<p class="m-0"><b style="color:green;">'+formatMoney(data)+'</b></p>';
                }
            },
            {
                "targets": ultimo,
                "render": function(data, type, full, meta) {
                    return  '<p class="m-0"><b style="color:green;">'+formatMoney(data)+'</b></p>';
                }
            },
        ]
    });
}

$('#tabla_bonos thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function() {
        if (tabla_bonos1.column(i).search() !== this.value) {
            tabla_bonos1.column(i).search(this.value).draw();
            var total = 0;
            var index = tabla_bonos1.rows({selected: true, search: 'applied'}).indexes();
            var data = tabla_bonos1.rows(index).data();
            var data = tabla_bonos1.rows(index).data();
            let SumaNus=0;
            let SumaMKTD=0;
            let com=0;
            $.each(data, function(i, v) {
                SumaNus += parseFloat(v[v.length -2]);
                SumaMKTD += parseFloat(v[v.length -1]);
                com += parseFloat(v[1]);            
            });
            var comi = formatMoney(com);
            document.getElementById("totalC").innerHTML = comi;
            var NUS = formatMoney(SumaNus);
            document.getElementById("totalN").innerHTML = NUS;
            var MK = formatMoney(SumaMKTD);
            document.getElementById("totalM").innerHTML = MK;
        }
    });
});