var tr;
var tabla_bonos2 ;
var totaPen = 0;

$('#mes').change( function(){
    mes = $('#mes').val();
    anio = $('#anio').val();
    if(anio == ''){
    }
    else{
    getComisionesPasadas(mes, anio, 0, 0);
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
    getComisionesPasadas(mes, anio, 0, 0);
    }      
});

let titulos = [];
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
        let SumaNus=0;
        let SumaMKTD=0;
        let com=0;
        let pagado1=0;
        let pagado2=0;
        let pagado_mktd=0;
        $.each(data, function(i, v) {
            total += parseFloat(v.Total);
            SumaNus += parseFloat(v.sumaBono1);
            SumaMKTD += parseFloat(v.sumaBono2);
            com += parseFloat(v.comision);
            if(v.pagadoBono1 != null || v.pagadoBono1 != undefined){
            pagado1 += parseFloat(v.pagadoBono1);
            }
            
            if(v.pagadoBono2 != null || v.pagadoBono2 != undefined){
            pagado2 += parseFloat(v.pagadoBono2);
            }
            if(v.pagado_mktd != null || v.pagado_mktd != undefined){
            pagado_mktd += parseFloat(v.pagado_mktd);
            }        
        });
        var NUS = formatMoney(SumaNus);
        document.getElementById("totalN").innerHTML = NUS;
        var MK = formatMoney(SumaMKTD);
        document.getElementById("totalM").innerHTML = MK;
        var comi = formatMoney(com);
        document.getElementById("totalC").innerHTML = comi;
        var pag1 = formatMoney(pagado1);
        document.getElementById("totalN2").innerHTML = pag1;
        var pag2 = formatMoney(pagado2);
        document.getElementById("totalM2").innerHTML = pag2;
        var pagado_mktdT = formatMoney(pagado_mktd);
        document.getElementById("pagadas_mktd").innerHTML = pagado_mktdT;
        }
    });  
});

getComisionesPasadas(0,0);
function getComisionesPasadas(mes,anio){
    let sumaT=0;
    $('#tabla_bonos').on('xhr.dt', function(e, settings, json, xhr) {
    var total = 0;
    let SumaNus=0;
    let SumaMKTD=0;
    let com=0;
    let pagad1=0;
    let pagad2=0;
    let pagado_mktd=0;
    $.each(json.data, function(i, v) {
        total += parseFloat(v.Total);
        SumaNus += parseFloat(v.sumaBono1);
        SumaMKTD += parseFloat(v.sumaBono2);
        com += parseFloat(v.comision);
        if(v.pagadoBono1 != null || v.pagadoBono1 != undefined){
        pagad1 += parseFloat(v.pagadoBono1);
        }
        
        if(v.pagadoBono2 != null || v.pagadoBono2 != undefined){
        pagad2 += parseFloat(v.pagadoBono2);
        }
        if(v.pagado_mktd != null || v.pagado_mktd != undefined){
        pagado_mktd += parseFloat(v.pagado_mktd);
        }              
    });
    var NUS = formatMoney(SumaNus);
    document.getElementById("totalN").innerHTML = NUS;
    var MK = formatMoney(SumaMKTD);
    document.getElementById("totalM").innerHTML = MK;
    var comi = formatMoney(com);
    document.getElementById("totalC").innerHTML = comi;
    var pag1 = formatMoney(pagad1);
    document.getElementById("totalN2").innerHTML = pag1;
    var pag2 = formatMoney(pagad2);
    document.getElementById("totalM2").innerHTML = pag2;
    var pagado_mktdT = formatMoney(pagado_mktd);
    document.getElementById("pagadas_mktd").innerHTML = pagado_mktdT;
    });
    $("#tabla_bonos").prop("hidden", false);
    tabla_bonos1 = $("#tabla_bonos").DataTable({
    dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: '100%',
    scrollX: true,
    bAutoWidth: true,
    buttons: [{
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo de Excel',
        title: 'REPORTE COMISIONES',
        exportOptions: {
        columns: [0,1,2,3,4,5,6,7,8,9,10],
        format: {
            header:  function (d, columnIdx) {
            if(columnIdx==10){
                return ' TOTAL '; 
            }
            else{
                return ' '+titulos[columnIdx] +' '; 
            }        
            },
        }
        }
    }],
    pagingType: "full_numbers",
    fixedHeader: true,
    language: {
        url: general_base_url + "/static/spanishLoader_v2.json",
        paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>"
        }
    },
    destroy: true,
    ordering: false,
    columns: [{
        "data": function( d ){
        return '<p class="m-0"><center>'+d.nombre+'</center></p>';
        }
    },
    {
        "data": function( d ){
        return '<p class="m-0"><b style="color:green;">'+formatMoney(d.comision)+'</b></p>';
        }
    },
    {
        "data": function( d ){
        return '<p class="m-0"><b>'+formatMoney(d.bono1)+'</b></p>';
        }
    },
    {
        "data": function( d ){
        let a='';
        d.bono_1.forEach((element, index, array) => {
            if(index == (d.bono_1.length -1)){
            a = a +  `<p class="m-0"><b> ${element.n_p}/${element.num_pagos}</b></p>`;
            }
        });
        
        return a;
        }
    },
    {
        "data": function( d ){
        let a='';
        let suma=0;
        d.bono_1.forEach((element, index, array) => {
            suma = suma + parseFloat(element.impuesto1);
            if(index == (d.bono_1.length -1)){
            a = a + `<p class="m-0"><b style="color:green;">${formatMoney(suma)}</b></p>`;
            }
        });
        return a;
        }
    },
    {
        "data": function( d ){
        let pagado = 0;
        if(d.forma_pago == 3){
            pagado = d.pagadoBono1 - (d.pagadoBono1 * (d.impuesto / 100));
        }
        else{
            pagado=d.pagadoBono1;
        }
        return '<p class="m-0"><b>'+formatMoney(pagado)+'</b></p>';
        }
    },
    {
        "data": function( d ){
        return '<p class="m-0"><b>'+formatMoney(d.bono2)+'</b></p>';
        }
    },
    {
        "data": function( d ){
        let a='';
        d.bono_2.forEach((element, index, array) => {
            if(index == (d.bono_2.length -1)){
            a = a +  `<p class="m-0"><b>${element.n_p}/${element.num_pagos}</b></p>`;
            }
        });
        
        return a;
        }
    },
    {
        "data": function( d ){
        let a='';
        let suma=0;
        d.bono_2.forEach((element, index, array) => {
            suma = suma + parseFloat(element.impuesto1);
            if(index == (d.bono_2.length -1)){
            a = a + `<p class="m-0"><b style="color:green;">${formatMoney(suma)}</b></p>`;
            sumaT=sumaT+parseFloat(suma);
            }
        });
        
        return a;
        }
    },
    {
        "data": function( d ){
        let pagado = 0;
        if(d.forma_pago == 3){
            pagado = d.pagadoBono2 - (d.pagadoBono2 * (d.impuesto / 100));
        }
        else{
            pagado=d.pagadoBono2;
        }
        return '<p class="m-0"><b>'+formatMoney(pagado)+'</b></p>';
        }
    },
    {
        "data": function( d ){
        return '<p class="m-0"><b  style="color:green;">'+formatMoney(d.Total)+'</b></p>';
        }
    }],
    columnDefs: [{
        "searchable": true,
        "orderable": false,
        "targets": 0
    }], 
    ajax: {
        url: general_base_url + "Comisiones/ReporteTotalMktd/"+mes+"/"+anio,
        type: "POST",
        cache: false,
        data: function( d ){
        },
    },
    });
    
    $('#tabla_bonos').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}

$(window).resize(function(){
    tabla_bonos1.columns.adjust();
});
