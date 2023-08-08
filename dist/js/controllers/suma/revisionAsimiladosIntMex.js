var totaPen = 0;

function cleanCommentsAsimilados() {
    var myCommentsList = document.getElementById('comments-list-asimilados');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}

$(document).ready(function() {
    $("#tabla_asimilados").prop("hidden", true);
    $.post(general_base_url+"Suma/lista_roles", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idRol'];
            var name = data[i]['descripcion'];
            $("#filtro33").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#filtro33").selectpicker('refresh');
    }, 'json');
});

$('#filtro33').change(function(){
    idRol = $('#filtro33').val();
    $("#filtro44").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url + `Suma/lista_usuarios/${idRol}/3`,
        type: 'post',
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++){
                var id = response[i]['id_usuario'];
                var name = response[i]['nombre'];
                $("#filtro44").append($('<option>').val(id).text(name));
            }
            $("#filtro44").selectpicker('refresh');
        }
    });
});

$('#filtro44').change( function() {
    idRol = $('#filtro33').val();
    idUsuario = $('#filtro44').val();
    if(idUsuario == '' || idUsuario == null || idUsuario == undefined){
        idUsuario = 0;
    }
    getAssimilatedCommissions(idRol, idUsuario);
});

let titulos = [];
$('#tabla_asimilados thead tr:eq(0) th').each( function (i) {
    if(i != 0){
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function() {
            if (tabla_asimilados.column(i).search() !== this.value) {
                tabla_asimilados.column(i).search(this.value).draw();
                var total = 0;
                var index = tabla_asimilados.rows({
                    selected: true,
                    search: 'applied'
                }).indexes();
                var data = tabla_asimilados.rows(index).data();
                $.each(data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                document.getElementById("totpagarAsimilados").textContent = formatMoney(total);
            }
        });
    } 
    else {
        $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
    }
});

$(document).on("click", ".individualCheck", function() {
    tr = $(this).closest('tr');
    var row = tabla_asimilados.row(tr).data();
    if ($(this).prop('checked')) totaPen += parseFloat(row.impuesto);
    else totaPen -= parseFloat(row.impuesto);
    $("#totpagarPen").html(formatMoney(totaPen));
});

function getAssimilatedCommissions(idRol, idUsuario){
    $('#tabla_asimilados').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(total);
        document.getElementById("totpagarAsimilados").textContent = to;
    });
    $("#tabla_asimilados").prop("hidden", false);
    tabla_asimilados = $("#tabla_asimilados").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            text: '<div class="d-flex"><i class="fa fa-check "></i><p class="m-0 pl-1">Marcar como pagado</p></div>',
            action: function() {
                if ($('input[name="idTQ[]"]:checked').length > 0) {
                    $('#spiner-loader').removeClass('hide');
                    var idcomision = $(tabla_asimilados.$('input[name="idTQ[]"]:checked')).map(function() {
                        return this.value;
                    }).get();
                    
                    var com2 = new FormData();
                    com2.append("idcomision", idcomision); 
                    $.ajax({
                        url : general_base_url + 'Suma/pago_internomex/',
                        data: com2,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST', 
                        success: function(data){
                            response = JSON.parse(data);
                            if(data) {
                                $('#spiner-loader').addClass('hide');
                                $("#totpagarPen").html(formatMoney(0));
                                $("#all").prop('checked', false);
                                var fecha = new Date();
                                $("#myModalEnviadas").modal('toggle');
                                tabla_asimilados.ajax.reload();
                                $("#myModalEnviadas .modal-body").html("");
                                $("#myModalEnviadas").modal();
                                $("#myModalEnviadas .modal-body").append("<center><img style='width: 75%; height: 75%;' src='"+general_base_url+"dist/img/send_intmex.gif'><p style='color:#676767;'>Comisiones de esquema <b>asimilados</b>, fueron marcadas como <b>PAGADAS</b> correctamente.</p></center>");
                            } else {
                                $('#spiner-loader').addClass('hide');
                                $("#myModalEnviadas").modal('toggle');
                                $("#myModalEnviadas .modal-body").html("");
                                $("#myModalEnviadas").modal();
                                $("#myModalEnviadas .modal-body").append("<center><P>ERROR AL ENVIAR COMISIONES </P><BR><i style='font-size:12px;'>NO SE HA PODIDO EJECUTAR ESTA ACCIÓN, INTÉNTALO MÁS TARDE.</i></P></center>");
                            }
                        },
                        error: function( data ){
                            $('#spiner-loader').addClass('hide');
                            $("#myModalEnviadas").modal('toggle');
                            $("#myModalEnviadas .modal-body").html("");
                            $("#myModalEnviadas").modal();
                            $("#myModalEnviadas .modal-body").append("<center><P>ERROR AL ENVIAR COMISIONES </P><BR><i style='font-size:12px;'>NO SE HA PODIDO EJECUTAR ESTA ACCIÓN, INTÉNTALO MÁS TARDE.</i></P></center>");
                        }
                    });
                }
            },
            attr: {
                class: 'btn btn-azure',
                style: 'position: relative; float: right;',
            }
        },
        {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'ASIMILADOS INTERNOMEX COMISIONES SUMA',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9],
                format: {
                    header: function (d, columnIndex) {
                        return ' '+titulos[columnIndex-1] +' ';
                    }
                }
            }
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
            "width": "3%" 
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.id_pago_suma + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.referencia + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.puesto + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + d.nombreComisionista + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + d.sede + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.total_comision) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.impuesto) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + d.porcentaje_comision + '%</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + d.estatusString + '</b></p>';
            }
        },
        {
            "orderable": false,
            "data": function( data ){
                var BtnStats;
                BtnStats = `<button href="#" value="${data.id_pago_suma}"  data-referencia="${data.referencia}" class="btn-data btn-blueMaderas consultar_logs_asimilados" data-toggle="tooltip" data-placement="top" title="HISTORIAL"><i class="fas fa-info"></i></button>
                <button href="#" value="${data.id_pago_suma}" data-value="${data.id_pago_suma}" class="btn-data btn-warning cambiar_estatus" data-toggle="tooltip" data-placement="top" title="${(data.estatus == 3) ? 'PAUSAR SOLICITUD': 'ACTIVAR SOLICITUD' }">${(data.estatus == 3) ? '<i class="fas fa-pause"></i>' : '<i class="fas fa-play"></i>'}</button>`;
                return '<div class="d-flex justify-center">'+BtnStats+'</div>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
            searchable:false,
            className: 'dt-body-center',
            render: function (d, type, full, meta){
                if(full.estatus == 3){
                    if(full.referencia){
                        return '<input type="checkbox" name="idTQ[]" class="individualCheck" style="width:20px;height:20px;"  value="' + full.id_pago_suma + '">';
                    }else{
                        return '';
                    }
                }
                else{
                    return '';
                }
            },
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            url: general_base_url + "Suma/getRevisionIntMex",
            type: "POST",
            data: { idRol: idRol, idUsuario: idUsuario, formaPago: '3'},
            dataType: 'json',
            dataSrc: ""
        }
    });

    $('#tabla_asimilados').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $("#tabla_asimilados tbody").on("click", ".consultar_logs_asimilados", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        referencia = $(this).attr("data-referencia");
        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").html("");
        $("#comments-list-asimilados").html("");
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DE LA REFERENCIA <b style="color:#39A1C0; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+referencia+'</b></h5></p>');
        $.getJSON("getHistorial/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><small>COMENTARIO: </small><b>' + v.comentario + '</b></a><br></div><div class="float-end text-right"><a>'+v.fecha_movimiento+'</a></div><div class="col-md-12"><p class="m-0"><small>MODIFICADO POR: </small><b> ' +v.modificado_por+ '</b></p></div><h6></h6></div></div></li>');
            });
        });
    });

    $("#tabla_asimilados tbody").on("click", ".cambiar_estatus", function(){
        var tr = $(this).closest('tr');
        var row = tabla_asimilados.row( tr );
        id_pago_i = $(this).val();
        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-body").append(`<div class="row"><div class="col-lg-12"><p class="text-center">¿Estás seguro de ${(row.data().estatus == 4 ) ? 'activar' : 'pausar'} la comisión con referencia <b>${row.data().referencia}</b> para <b>${(row.data().nombreComisionista).toUpperCase()}</b>?</p></div></div>`);
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="estatus" value="'+row.data().estatus+'"><input type="text" class="form-control input-gral observaciones" name="observaciones" required placeholder="Describe motivo para el cambio de estatus de esta solicitud"></input></div></div>');
        $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+id_pago_i+'">');
        $("#modal_nuevas .modal-body").append('<div class="row mt-3"><div class="col-md-6"></div><div class="col-md-3"><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button></div><div class="col-md-3"><input type="submit" class="btn btn-primary"></div></div>');
        $("#modal_nuevas").modal();
    });
}

$(window).resize(function(){
    tabla_asimilados.columns.adjust();
});

function cancela(){
    $("#modal_nuevas").modal('toggle');
}

$("#form_interes").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: general_base_url + "Suma/setPausarDespausarComision/",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                if( data ){
                    $("#modal_nuevas").modal('toggle' );
                    alerts.showNotification("top", "right", "Se aplicó el cambio exitosamente", "success");
                    setTimeout(function() {
                        tabla_asimilados.ajax.reload();
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

function CloseModalDelete2(){
    document.getElementById("form_multiples").reset();
    a = document.getElementById('borrarProyect');
    padre = a.parentNode;
    padre.removeChild(a);
    $("#modal_multiples").modal('toggle');  
}

$(document).on("click", ".Pagar", function() {          
    $("#modal_multiples .modal-body").html("");
    $("#modal_multiples .modal-header").html("");
    $("#modal_multiples .modal-header").append('<h4 class="card-title"><b>Marcar pagadas</b></h4>');
    $("#modal_multiples .modal-footer").append(`<div class="row" id="borrarProyect"><center><input type="submit" disabled id="btn-aceptar" class="btn btn-primary" value="ACEPTAR"><button type="button" class="btn btn-danger" data-dismiss="modal" onclick="CloseModalDelete2()">CANCELAR</button></center></div>`);
    $("#modal_multiples .modal-header").append(`<div class="row">
    <div class="col-md-12"><select id="desarrolloSelect" name="desarrolloSelect" class="form-control desarrolloSelect ng-invalid ng-invalid-required" required data-live-search="true"></select></div></div>`);
    $.post('getDesarrolloSelectINTMEX/'+3, function(data) {
        $("#desarrolloSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['name_user'];
            $("#desarrolloSelect").append($('<option>').val(id).attr('data-value', id).text(name));
        }
        if (len <= 0) {
            $("#desarrolloSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#desarrolloSelect").val(0);
        $("#desarrolloSelect").selectpicker('refresh');
    }, 'json');
        
    $('#desarrolloSelect').change(function() {
        $("#modal_multiples .modal-body .bodypagos").html("");
        if(document.getElementById('bodypago2')){
            let a =  document.getElementById('bodypago2');
            padre = a.parentNode;
            padre.removeChild(a);
        }
        var valorSeleccionado = $(this).val();
        var combo = document.getElementById("desarrolloSelect");
        var selected = combo.options[combo.selectedIndex].text;
        $.getJSON(general_base_url + "Comisiones/getPagosByProyect/"+valorSeleccionado+"/"+3).done(function(data) {
            let sumaComision = 0;
            if (!data) {
                $("#modal_multiples .modal-body").append('<div class="row"><div class="col-md-12">SIN DATOS A MOSTRAR</div></div>');
            } 
            else {
                if(data.length > 0){
                    $("#modal_multiples .modal-body ").append(`<div class="row bodypagos" >
                    <p style='color:#9D9D9D;'>¿Estas seguro que deseas autorizar $<b style="color:green">${formatMoney(data[0][0].suma)}</b> de ${selected}?</div>`);
                } 
                
                $("#modal_multiples .modal-body ").append(`<div  id="bodypago2"></div>`);
                $.each(data[1], function(i, v) {
                    $("#modal_multiples .modal-body #bodypago2").append(`
                    <input type="hidden" name="ids[]" id="ids" value="${v.id_pago_i}"></div>`);
                    
                });
                document.getElementById('btn-aceptar').disabled = false;
            }
        });
    });

    $("#modal_multiples").modal({
        backdrop: 'static',
        keyboard: false
    });
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
                        tabla_asimilados.ajax.reload();
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
$(document).on("click", ".btn-historial-lo", function(){
    window.open(general_base_url+"Comisiones/getHistorialEmpresa", "_blank");
});


function cleanComments(){
    var myCommentsList = document.getElementById('documents');
    myCommentsList.innerHTML = '';
    var myFactura = document.getElementById('facturaInfo');
    myFactura.innerHTML = '';
}

function selectAll(e) {
    tota2 = 0;
    if(e.checked == true){
        $(tabla_asimilados.$('input[type="checkbox"]')).each(function (i, v) {
            tr = this.closest('tr');
            row = tabla_asimilados.row(tr).data();
            tota2 += parseFloat(row.impuesto);
            if(v.checked == false){
                $(v).prop("checked", true);
            }
        }); 
        $("#totpagarPen").html(formatMoney(tota2));
    }
    if(e.checked == false){
        $(tabla_asimilados.$('input[type="checkbox"]')).each(function (i, v) {
            if(v.checked == true){
                $(v).prop("checked", false);
            }
        }); 
        $("#totpagarPen").html(formatMoney(0));
    }
}

$(document).ready( function(){
    $.getJSON( general_base_url + "Comisiones/getReporteEmpresa").done( function( data ){
        $(".report_empresa").html();
        $.each( data, function( i, v){
            $(".report_empresa").append('<div class="col xol-xs-3 col-sm-3 col-md-3 col-lg-3"><label style="color: #00B397;">&nbsp;'+v.empresa+': $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #00B397; font-weight: bold;" value="'+formatMoney(v.porc_empresa)+'" disabled="disabled" readonly="readonly" type="text"  name="myText_FRO" id="myText_FRO"></label></div>');
        });
    });
});

$("#form_multiples").submit( function(e) {
    $('#spiner-loader').removeClass('hidden');
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: general_base_url + "Comisiones/IntMexPagadosByProyect",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                if( data == 1){
                    CloseModalDelete2();
                    alerts.showNotification("top", "right", "Se aplicó el cambio exitosamente", "success");
                }else{
                    CloseModalDelete2();
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                }
                $('#spiner-loader').addClass('hidden');
            },error: function( ){
                CloseModalDelete2();
                alert("ERROR EN EL SISTEMA");
                $('#spiner-loader').addClass('hidden');
            }
        });
    }
});