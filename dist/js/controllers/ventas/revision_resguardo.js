
var totalLeon = 0;
var totalQro = 0;
var totalSlp = 0;
var totalMerida = 0;
var totalCdmx = 0;
var totalCancun = 0;
var tr;
var tabla_resguardo2 ;
var totaPen = 0;
let titulos = [];

function cleanCommentsremanente() {
    var myCommentsList = document.getElementById('comments-list-remanente');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}

$(document).ready(function() {
    $("#tabla_resguardo").prop("hidden", true);
    $.post(general_base_url + "Contratacion/lista_proyecto", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#filtro3").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#filtro3").selectpicker('refresh');
    }, 'json');

    $.post(general_base_url + "Comisiones/getDirectivos", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            if(id_usuario_general == 1875 ){
                if(id == 2){
                    $("#filtro33").append($('<option>').val(id).text(name.toUpperCase()));
                }
            }
            else{
                $("#filtro33").append($('<option>').val(id).text(name.toUpperCase()));
            }
        }
        $("#filtro33").selectpicker('refresh');
    }, 'json');
});


$('#filtro33').change(function(ruta){
    residencial = $('#filtro33').val();
    $("#filtro44").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url + 'Contratacion/lista_proyecto/'+residencial,
        type: 'post',
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++){
                var id = response[i]['idResidencial'];
                var name = response[i]['descripcion'];
                $("#filtro44").append($('<option>').val(id).text(name));
            }
            $("#filtro44").selectpicker('refresh');
        }
    });
});

$('#filtro3').change(function(ruta){
    proyecto = $('#filtro3').val();
    condominio = $('#filtro4').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getInvoiceCommissions(proyecto, condominio);
});

$('#filtro4').change(function(ruta){
    proyecto = $('#filtro3').val();
    condominio = $('#filtro4').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getInvoiceCommissions(proyecto, condominio);
});


$('#filtro33').change(function(ruta){
    proyecto = $('#filtro33').val();
    condominio = $('#filtro44').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0; 
    }

    getAssimilatedCommissions(proyecto, condominio);
});

$('#filtro44').change(function(ruta){
    proyecto = $('#filtro33').val();
    condominio = $('#filtro44').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getAssimilatedCommissions(proyecto, condominio);
});

$('#filtro333').change(function(ruta){
    proyecto = $('#filtro333').val();
    getHistoryCommissions(proyecto);
});

$('#tabla_resguardo thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function() {
        if (tabla_resguardo2.column(i).search() !== this.value) {
            tabla_resguardo2.column(i).search(this.value).draw();
            var total = 0;
            var index = tabla_resguardo2.rows({
                selected: true,
                search: 'applied'
            }).indexes();
            var data = tabla_resguardo2.rows(index).data();
        }
    });
});

function getAssimilatedCommissions(proyecto, condominio){
    $('#tabla_resguardo').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });

        var to = formatMoney(total);
        document.getElementById("totpagarremanente").textContent = to;
    });

    $("#tabla_resguardo").prop("hidden", false);
    tabla_resguardo2 = $("#tabla_resguardo").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        bAutoWidth: true, 
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'RESGUARDOS_COMISIONES',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13],
                format: {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            "data": function( d ){
                return '<p class="m-0">'+d.id_pago_i+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.proyecto+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.condominio+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.lote+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.referencia+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.empresa+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.comision_total)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.pago_neodata)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+formatMoney(d.impuesto)+'</b></p>';
            }
        },
        {
            "data": function( d ){
                if(d.lugar_prospeccion == 0){
                    return '<p class="m-0" style="color:red;">VENTA CANCELADA <br><b> ('+d.porcentaje_decimal+'% de '+d.porcentaje_abono+'%)</b></p>';
                }
                else if(d.lugar_prospeccion == 6){
                    return '<p class="m-0">COMISIÓN + MKTD <br><b> ('+d.porcentaje_decimal+'% de '+d.porcentaje_abono+'%)</b></p>';
                }
                else{
                    return '<p class="m-0">COMISIÓN <br><b> ('+d.porcentaje_decimal+'% de '+d.porcentaje_abono+'%)</b></p>';
                }
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.usuario+'</b></i></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><i> '+d.puesto+'</i></p>';
            }
        },
        {
            "data": function( d ){
                var BtnStats1;
                BtnStats1 =  '<p class="m-0">'+d.fecha_creacion.split('.')[0]+'</p>';
                return BtnStats1;
            }
        },
        {
            "orderable": false,
            "data": function( data ){
                var BtnStats;
                BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_remanente" data-toggle="tooltip" data-placement="top" title="HISTORIAL DEL PAGO">' +'<i class="fas fa-info"></i></button>';
                return '<div class="d-flex justify-center">'+BtnStats+'</div>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            searchable:false,
            className: 'dt-body-center',
        }],
        ajax: {
            url: general_base_url + "Comisiones/getDatosResguardoContraloria/" + proyecto + "/" + condominio,
            type: "POST",
            cache: false,
            data: function( d ){
            }
        },
    });

    $('#tabla_resguardo').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $("#tabla_resguardo tbody").on("click", ".consultar_logs_remanente", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        $("#seeInformationModalremanente").modal();
        $("#nameLote").append('<p><h5>HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-remanente").append('<li><div class="container-fluid"><div class="row"><div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><a><b>' + v.nombre_usuario + '</b></a><br></div> <div class="float-end text-right"><a>' + v.fecha_movimiento + '</a></div><div class="col-md-12"><p class="m-0"><b> ' + v.comentario + '</b></p></div></div></div></li>');
            });
        });
    });

    $('#tabla_resguardo').on('click', 'input', function() {
        tr = $(this).closest('tr');
        var row = tabla_resguardo2.row(tr).data();
        if (row.pa == 0) {
            row.pa = row.impuesto;
            totaPen += parseFloat(row.pa);
            tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
        }
        else {
            totaPen -= parseFloat(row.pa);
            row.pa = 0;
        }
        $("#totpagarPen").html(formatMoney(totaPen));
    });

    $("#tabla_resguardo tbody").on("click", ".despausar_estatus", function(){
        var tr = $(this).closest('tr');
        var row = tabla_resguardo2.row( tr );
        id_pago_i = $(this).val();
        $("#modal_refresh .modal-body").html("");
        $("#modal_refresh .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro regresar al estatus inicial la comisión  de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p></div></div>');
        $("#modal_refresh .modal-body").append('<input class="idComPau" name="id_comision" type="text" value="'+row.data().id_comision+'" hidden>');
        $("#modal_refresh .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="CONFIRMAR"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></div></div>');
        $("#modal_refresh").modal();
    });

    $("#tabla_resguardo tbody").on("click", ".consultar_documentos", function(){
        id_com = $(this).val();
        id_pj = $(this).attr("data-personalidad");
        $("#seeInformationModal").modal();
        $.getJSON( general_base_url + "Comisiones/getDatosDocumentos/"+id_com+"/"+id_pj).done( function( data ){
            $.each( data, function( i, v){
                $("#seeInformationModal .documents").append('<div class="row">');
                if (v.estado == "NO EXISTE"){
                    $("#seeInformationModal .documents").append('<div class="col-md-7"><label style="font-size:10px; margin:0; color:gray;">'+(v.nombre).substr(0, 52)+'</label></div><div class="col-md-5"><label style="font-size:10px; margin:0; color:gray;">(No existente)</label></div>');
                }
                else{
                    $("#seeInformationModal .documents").append('<div class="col-md-7"><label style="font-size:10px; margin:0; color:#0a548b;"><b>'+(v.nombre).substr(0, 52)+'</b></label></div> <div class="col-md-5"><label style="font-size:10px; margin:0; color:#0a548b;"><b>('+v.expediente+')</label></b> - <button onclick="preview_info(&#39;'+(v.expediente)+'&#39;)" style="border:none; background-color:#fff;"><i class="fa fa-file" aria-hidden="true" style="font-size: 12px; color:#0a548b;"></i></button></div>');
                }
                $("#seeInformationModal .documents").append('</div>');
            });
        });
    });
}

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable()
    .columns.adjust();
});

$(window).resize(function(){
    tabla_resguardo2.columns.adjust();
});

function cancela(){
    $("#modal_nuevas").modal('toggle');
}

$("#form_interes").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        console.log(data);
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: general_base_url + "Comisiones/pausar_solicitud/",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST',
            success: function(data){
                if( data[0] ){
                    $("#modal_nuevas").modal('toggle' );
                    alerts.showNotification("top", "right", "Se ha pausado la comisión exitosamente", "success");
                    setTimeout(function() {
                        tabla_resguardo2.ajax.reload();
                    }, 3000);
                }
                else{
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                }
            },error: function( ){
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});

$("#form_refresh").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: general_base_url + "Comisiones/refresh_solicitud/",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', 
            success: function(data){
                if( data[0] ){
                    $("#modal_refresh").modal('toggle' );
                    alerts.showNotification("top", "right", "Se ha procesado la solicitud exitosamente", "success");
                    setTimeout(function() {
                        tabla_resguardo2.ajax.reload();
                    }, 3000);
                }
                else{
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                }
            },error: function( ){
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});

$("#form_despausar").submit( function(e) { e.preventDefault(); }).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: general_base_url + "Comisiones/despausar_solicitud/",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST',
            success: function(data){
                if( data[0] ){
                    $("#modal_despausar").modal('toggle' );
                    alerts.showNotification("top", "right", "Se ha regresado la comisión exitosamente", "success");
                    setTimeout(function() {
                        tabla_resguardo2.ajax.reload();
                    }, 3000);
                }
                else{
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                }
            },error: function( ){
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});

function preview_info(archivo){
    $("#documento_preview .modal-dialog").html("");
    $("#documento_preview").css('z-index', 9999);
    archivo = general_base_url + "dist/documentos/"+archivo+"";
    var re = /(?:\.([^.]+))?$/;
    var ext = re.exec(archivo)[1];
    elemento = "";
    if (ext == 'pdf'){
        elemento += '<iframe src="'+archivo+'" style="overflow:hidden; width: 100%; height: -webkit-fill-available">';
        elemento += '</iframe>';
        $("#documento_preview .modal-dialog").append(elemento);
        $("#documento_preview").modal();
    }
    if(ext == 'jpg' || ext == 'jpeg'){
        elemento += '<div class="modal-content" style="background-color: #333; display:flex; justify-content: center; padding:20px 0">';
        elemento += '<img src="'+archivo+'" style="overflow:hidden; width: 40%;">';
        elemento += '</div>';
        $("#documento_preview .modal-dialog").append(elemento);
        $("#documento_preview").modal();
    }
    if(ext == 'xlsx'){
        elemento += '<div class="modal-content">';
        elemento += '<iframe src="'+archivo+'"></iframe>';
        elemento += '</div>';
        $("#documento_preview .modal-dialog").append(elemento);
    }
}

$("#roles").change(function() {
    var parent = $(this).val();
    document.getElementById('monto').value = ''; 
    document.getElementById('idmontodisponible').value = ''; 
    $('#usuarioid option').remove();
    $.post('getUsuariosRol/'+parent, function(data) {
        $("#usuarioid").append($('<option>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for( var i = 0; i<len; i++){
            var id = data[i]['id_usuario'];
            var name = data[i]['name_user'];
            $("#usuarioid").append($('<option>').val(id).attr('data-value', id).text(name));
        }
        if(len<=0){
            $("#usuarioid").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        
        $("#usuarioid").selectpicker('refresh');
    }, 'json'); 
});

$("#idloteorigen").select2({dropdownParent:$('#miModal')});

$("#usuarioid").change(function() {
    document.getElementById('monto').value = ''; 
    document.getElementById('idmontodisponible').value = ''; 
    var user = $(this).val();
    
    $('#idloteorigen option').remove(); // clear all values
    $.post('getLotesOrigenResguardo/'+user, function(data) {
        $("#idloteorigen").append($('<option disabled>').val("default").text("Seleccione una opción"));
        var len = data.length;
    
        for( var i = 0; i<len; i++)
        {
            var name = data[i]['nombreLote'];
            var comision = data[i]['id_pago_i'];
            let comtotal = data[i]['comision_total'] -data[i]['abono_pagado'];
            
            $("#idloteorigen").append(`<option value='${comision},${comtotal.toFixed(2)}'>${name}  -   ${ formatMoney(comtotal.toFixed(2))}</option>`);
        }
        if(len<=0)
        {
        $("#idloteorigen").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#idloteorigen").selectpicker('refresh');
    }, 'json'); 
});

$("#idloteorigen").change(function() {
    let cuantos = $('#idloteorigen').val().length;
    let suma =0;
    if(cuantos > 1){
        var comision = $(this).val();
        for (let index = 0; index < $('#idloteorigen').val().length; index++) {
            datos = comision[index].split(',');
            let id = datos[0];
            let monto = datos[1];
            document.getElementById('monto').value = ''; 

            $.post('getInformacionDataResguardo/'+id, function(data) {
                var disponible = (data[0]['comision_total']-data[0]['abono_pagado']);
                var idecomision = data[0]['id_pago_i'];
                suma = suma + disponible;
                document.getElementById('montodisponible').innerHTML = '';
                $("#idmontodisponible").val(formatMoney(suma));
                $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="'+suma.toFixed(2)+'">');
                $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="'+idecomision+'">');
                    
                var len = data.length;
                if(len<=0){
                    $("#idmontodisponible").val(formatMoney(0));
                }
        
                $("#montodisponible").selectpicker('refresh');
            }, 'json');
        }
    }
    else{
        var comision = $(this).val();
        datos = comision[0].split(',');
        let id = datos[0];
        let monto = datos[1];
        alert(id+'-------'+monto);

        document.getElementById('monto').value = ''; 
        $.post('getInformacionDataResguardo/'+id, function(data) {
            var disponible = (data[0]['comision_total']-data[0]['abono_pagado']);
            var idecomision = data[0]['id_pago_i'];
            document.getElementById('montodisponible').innerHTML = '';
            $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="'+disponible+'">');
            $("#idmontodisponible").val(formatMoney(disponible));
            $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="'+idecomision+'">');
            var len = data.length;
        
            if(len<=0){
                $("#idmontodisponible").val(formatMoney(0));
            }
            
            $("#montodisponible").selectpicker('refresh');
        }, 'json'); 
    }
});

function verificar(){
    let disponible = parseFloat($('#valor_comision').val()).toFixed(2);
    let monto = parseFloat($('#monto').val()).toFixed(2);
    if(monto < 1 || isNaN(monto)){
        alerts.showNotification("top", "right", "Debe ingresar un monto mayor a 0.", "warning");
        document.getElementById('btn_abonar').disabled=true; 
    }
    else{
        if(parseFloat(monto) <= parseFloat(disponible) ){
            let cantidad = parseFloat($('#numeroP').val());
            resultado = monto /cantidad;
            $('#pago').val(formatMoney(resultado));
            document.getElementById('btn_abonar').disabled=false;

            let cuantos = $('#idloteorigen').val().length;
            let cadena = '';
            var data = $('#idloteorigen').select2('data')
            for (let index = 0; index < cuantos; index++) {
                cadena = cadena+' , '+data[index].text;
            }
            
            $('#comentario').val('Lotes involucrados en el descuento: '+cadena+'. Por la cantidad de: '+formatMoney(monto));
        }
        else if(parseFloat(monto) > parseFloat(disponible) ){
            alerts.showNotification("top", "right", "Monto a descontar mayor a lo disponible", "danger");
            
            document.getElementById('monto').value = ''; 
            document.getElementById('btn_abonar').disabled=true; 
        }
    }
}