$("#tabla_bonos").prop("hidden", true);
    $('#roles').change(function(ruta){
        roles = $('#roles').val();
        param = $('#param').val();
        $("#users").empty().selectpicker('refresh');
        $.ajax({
        url: general_base_url + 'Comisiones/getUsuariosRolBonos/'+roles,
        type: 'post',
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++){
                var id = response[i]['id_usuario'];
                var name = response[i]['name_user'];
                $("#users").append($('<option>').val(id).text(name));
            }
            $("#users").selectpicker('refresh');
        }
    });
});

$('#roles').change(function(ruta){
    roles = $('#roles').val();
    users = $('#users').val();
    if(users == '' || users == null || users == undefined){
        users = 0;
    }
    getBonusCommissions(roles, users);
});

$('#users').change(function(ruta){
    roles = $('#roles').val();
    users = $('#users').val();
    if(users == '' || users == null || users == undefined){
        users = 0;
    }
    else{
    getBonusCommissions(roles, users);
    }
});

var tr;
var tabla_bonos2 ;
var totaPen = 0;
let titulos = [];
$('#tabla_bonos thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function() {
        if (tabla_bonos1.column(i).search() !== this.value) {
        tabla_bonos1.column(i).search(this.value).draw();
            var total = 0;
            var index = tabla_bonos1.rows({
            selected: true,
            search: 'applied'
        }).indexes();
            var data = tabla_bonos1.rows(index).data();
            $.each(data, function(i, v) {
                total += parseFloat(v.pago);
            });
            var to1 = formatMoney(total);
            document.getElementById("totalp").textContent = to1;
        }
    });  
});

function getBonusCommissions(roles, users){
    $("#tabla_bonos").prop("hidden", false);
    $('#tabla_bonos').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.pago);
        });
        var to = formatMoney(total);
        document.getElementById("totalp").textContent = to;
    });
    $("#tabla_bonos").prop("hidden", false);
    tabla_bonos1 = $("#tabla_bonos").DataTable({
    dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: '100%',
    scrollX: true,
    buttons: [{
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo de Excel',
        title: 'HISTORIAL BONOS - PAGOS LIQUIDADOS',
        exportOptions: {
        columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13],
        format: {
            header: function (d, columnIndex) {
                return ' '+titulos[columnIndex] +' ';
            }
        }
        },
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
        return '<p class="m-0"><center>'+d.id_pago_bono+'</center></p>';
        }
    },  
    {
        "data": function( d ){
        return '<p class="m-0"><center>'+d.id_bono+'</center></p>';
        }
    },
    {
        "data": function( d ){
        return '<p class="m-0"><b>'+d.nombre+'</b></p>';
        }
    },
        {
        "data": function( d ){
        return '<p class="m-0"><b>'+d.rfc+'</b></p>';
        }
    },
    {
        "data": function( d ){
        return '<p class="m-0">'+d.id_rol+'</p>';
        }
    },
    {
        "data": function( d ){
        if(d.estatus == 2){
            return '<p class="m-0"><center>'+formatMoney(d.monto)+'</center></p><p style="font-size: .8em"><span class="label lbl-green">LIQUIDADO</span></p>';
        }else{
            return '<p class="m-0"><center>'+formatMoney(d.monto)+'</center></p>';
        }
        }
    },
    {
        "data": function(d) {
        let abonado = d.n_p*d.pago;
        if(abonado >= d.monto -.30 && abonado <= d.monto +.30){
            abonado = d.monto;
        }else{
            abonado =d.n_p*d.pago;
        }
        return '<p class="m-0"><center><b>' + formatMoney(abonado) + '</b></center></p>';
        }
    },
    {
        "data": function(d) {
        let pendiente = d.monto - (d.n_p*d.pago);
        if(pendiente < 1){
            pendiente = 0;
        }else{
            pendiente = d.monto - (d.n_p*d.pago);
        }
        if(d.estatus == 2){
            return '<p class="m-0"><center>$ 0.00</center></p>';
        }else{
            return '<p class="m-0"><center><b>' + formatMoney(pendiente) + '</b></center></p>';
        }
        }
    },
    {
        "data": function( d ){
        return '<p class="m-0"><center><b>' +d.n_p+'</b>/'+d.num_pagos+ '</center></p>';
        }
    },
    {
        "data": function( d ){
        return '<p class="m-0"><center><b>'+formatMoney(d.pago)+'</b></center></p>';
        }
    },
    {
        "data": function(d) {
        if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
            return '<p class="m-0"><center><b>0%</b></center></p>';
        }else{
            return '<p class="m-0"><center><b>'+parseFloat(d.impuesto)+'%</b></center></p>';
        }
        }
    },
    {
        
        "data": function(d) {
        if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
            return '<p class="m-0"><center><b>' + formatMoney(d.pago) + '</b></center></p>';
        }else{
            let iva = ((parseFloat(d.impuesto)/100)*d.pago);
            let pagar = parseFloat(d.pago) - iva;
            return '<p class="m-0"><center><b>' + formatMoney(pagar) + '</b></center></p>';
        }
        }
    },
    {
        "data": function( d ){
        return '<p class="m-0"><center>'+d.fecha_abono+'</center></p>';
        }
    },
    {
        "data": function( d ){
        if(d.estado == 1){
            estatus = d.est;
            color='29A2CC';
        }else if(d.estado == 2){
            estatus=d.est;
            color='9129CC';
        }else if(d.estado == 3){
            estatus=d.est;
            color='05A134';
        }else if(d.estado == 4){
            estatus=d.est;
            color='9129CC';
        }else if(d.estado == 5){
            estatus=d.est;
            color='B03A2E';
        }else if(d.estado == 6){
            estatus=d.est;
            color='4D7FA1';
        }
        return '<span class="label" style="color:#'+color+'; background:#'+color+'18;">'+estatus+'</span>';
        }
    },
    {
        "orderable": false,
        "data": function( d ){
            return '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas consulta_abonos" value="'+d.id_pago_bono+'" data-toggle="tooltip" data-placement="top" title="HISTORIAL"><i class="fas fa-info"></i></button></div>';
        }
    }],
    columnDefs: [{
        orderable: false,
        className: 'select-checkbox',
        targets: 0,
        searchable:false,
        className: 'dt-body-center'
    }], 
    ajax: {
        url: general_base_url + "Comisiones/getBonosAllUser/" + roles + "/" + users,
        type: "POST",
        cache: false,
        data: function( d ){
        }
    },
    });

    $("#tabla_bonos tbody").on("click", ".consulta_abonos", function(e){
    e.preventDefault();
    e.stopImmediatePropagation();
    id_pago = $(this).val();
    lote = $(this).attr("data-value");
    $("#modal_bonos").modal();
    $("#nameLote").append('<p><h5>HISTORIAL DE BONO</b></h5></p>');
    $.getJSON("getHistorialAbono2/"+id_pago).done( function( data ){
        $.each( data, function(i, v){
        $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><small>COMENTARIO: </small><b>' + v.comentario + '</b></a><br></div><div class="float-end text-right"><a>' + v.date_final + '</a></div><div class="col-md-12"><p class="m-0"><small>USUARIO: </small><b> ' + v.nombre_usuario + '</b></p></div><h6></h6></div></div></li>');
        });
    });
    });
}

$('#tabla_bonos').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

$("#form_bonos").on('submit', function(e){ 
    e.preventDefault();
    let formData = new FormData(document.getElementById("form_bonos"));
    formData.append("dato", "valor");
    $.ajax({
    url: 'saveBono',
    data: formData,
    method: 'POST',
    contentType: false,
    cache: false,
    processData:false,
    success: function(data) {
        if (data == 1) {
        $('#tabla_bonos').DataTable().ajax.reload(null, false);
        $('#miModalBonos').modal('hide');
        alerts.showNotification("top", "right", "Abono registrado con exito.", "success");
        document.getElementById("form_bonos").reset();
        } else if(data == 2) {
        $('#tabla_bonos').DataTable().ajax.reload(null, false);
        $('#miModalBonos').modal('hide');
        alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
        }else if(data == 3){
        $('#tabla_bonos').DataTable().ajax.reload(null, false);
        $('#miModalBonos').modal('hide');
        alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
        }
    },
    error: function(){
        $('#miModalBonos').modal('hide');
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
    });
});

function filterFloat(evt,input){
    var key = window.Event ? evt.which : evt.keyCode;   
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    var isNumber = (key >= 48 && key <= 57);
    var isSpecial = (key == 8 || key == 13 || key == 0 ||  key == 46);
    if(isNumber || isSpecial){
    return filter(tempValue);
    }        
    
    return false;    
}

function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
    return (preg.test(__val__) === true);
}

function closeModalEng(){
    document.getElementById("form_abono").reset();
    a = document.getElementById('inputhidden');
    padre = a.parentNode;
    padre.removeChild(a);
    $("#modal_abono").modal('toggle');
}

$(window).resize(function(){
    tabla_bonos1.columns.adjust();
});

function cleanCommentsAsimilados() {
    var myCommentsList = document.getElementById('comments-list-asimilados');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}