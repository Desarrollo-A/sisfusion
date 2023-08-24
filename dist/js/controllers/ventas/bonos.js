
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

$("#tabla_bonos").ready( function(){
    let titulos = [];
    $('#tabla_bonos thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $( 'input', this ).on('keyup change', function () {
            if (tabla_bonos1.column(i).search() !== this.value ) {
                tabla_bonos1.column(i).search(this.value).draw();
                var total = 0;
                var index = tabla_bonos1.rows({ selected: true, search: 'applied' }).indexes();
                var data = tabla_bonos1.rows( index ).data();
                $.each(data, function(i, v){
                    if(v.suma != null){
                    total += parseFloat(v.monto);
                    }
                });
                var to1 = formatMoney(total);
                document.getElementById("totalp").textContent = to1;
            }
        });
    });

    $('#tabla_bonos').on('xhr.dt', function ( e, settings, json, xhr ) {
        var total = 0;
        $.each(json.data, function(i, v){
            if(v.suma != null){
                total += parseFloat(v.monto);
            }
        });
        var to = formatMoney(total);
        document.getElementById("totalp").textContent = to;
    });

    tabla_bonos1 = $("#tabla_bonos").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        bAutoWidth: true,
        buttons: [{
            text: '<i class="fa fa-check"></i> NUEVO BONO',
            action: function() {
                open_Mb();
            },
            attr: {
                class: 'btn btn-azure',
                style: 'position: relative; float: right',
            }
            },
            {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'BONOS - PAGOS ACTIVOS',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10],
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
                return '<p class="m-0">'+d.id_bono+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.nombre+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.id_rol+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.monto)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+formatMoney(d.suma)+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+formatMoney(d.monto-d.suma)+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+Math.round(d.suma/d.pago)+'/'+d.num_pagos+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+formatMoney(d.pago)+'</b></p>';
            }
        },
        {
            "data": function(d) {
                if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                return '<p class="m-0"><b>0%</b></p>';
                }
                else{
                return '<p class="m-0"><b>'+parseFloat(d.impuesto)+'%</b></p>';
                }
            }
        },
        {
            "data": function(d) {
                if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                    return '<p class="m-0"><b>' + formatMoney(d.pago) + '</b></p>';
                }else{
                    let iva = ((parseFloat(d.impuesto)/100)*d.pago);
                    let pagar = parseFloat(d.pago) - iva;
                    return '<p class="m-0"><b>' + formatMoney(pagar) + '</b></p>';
                }
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.fecha_creacion+'</p>';
            }
        },
        {
            "orderable": false,
            "data": function( d ){
                if(d.estatus==1){
                    return '<div class="d-flex justify-center"><button class="btn-data btn-gray consulta_abonos" value="'+d.id_bono+','+ d.nombre+'"><i class="material-icons" data-toggle="tooltip" data-placement="left" title="HISTORIAL">bar_chart</i></button>'
                    +'<button class="btn-data btn-green abonar" value="'+d.id_bono+','+d.pago+','+d.id_usuario+','+d.nombre+'" data-toggle="tooltip" data-placement="left" title="ABONAR"><i class="fas fa-dollar-sign"></i></button>'
                    +'<button class="btn-data btn-warning btn-delete" value="'+d.id_bono+'" data-toggle="tooltip" data-placement="left" title="ELIMINAR"><i class="fas fa-trash"></i></button></div>';
                }else{
                    return '<button class="btn-data btn-gray consulta_abonos" value="'+d.id_bono+'"><i class="material-icons" data-toggle="tooltip" data-placement="left" title="HISTORIAL">trash</i></button>';
                }
            }
        }],
        columnDefs: [{
        orderable: false,
        className: 'select-checkbox',
        targets:   0,
        searchable:false,
        className: 'dt-body-center'
        }], 
        ajax: {
            "url": general_base_url + "Comisiones/getBonos",
            "type": "POST",
            cache: false,
            "data": function( d ){
            }
        },
    });

    $("#tabla_bonos tbody").on("click", ".consulta_abonos", function() {
        bono = $(this).val();
        var dat = bono.split(",");
        let id = dat[0];
        let nombre = dat[1];

        $.getJSON(general_base_url + "Comisiones/getHistorialAbono/" + id).done(function(data) {
            if (data.length == 0) {
                alerts.showNotification("top", "right", "No hay saldo abonado.", "warning");
            }
            else {
                $("#modal_bonos .modal-header").html("");
                $("#modal_bonos .modal-body").html("");
                $("#modal_bonos .modal-footer").html("");
                var sumabonado = 0;
                var sumpagado = 0;
                var num;
                var num2;
                for (var i = 0; i < data.length; i++) {
                if(data[i].estado == 3){
                    num = parseFloat(data[i].abono);
                }else{
                    num = 0;
                }
                    sumpagado = sumpagado + num;  
                }

                for (var j = 0; j < data.length; j++) {
                if(data[j].estado != 5){
                    num2 = parseFloat(data[j].abono);
                }else{
                    num2 = 0;
                }
                sumabonado = sumabonado + num2;  
                }
                pagado = formatMoney(sumpagado);
                abonado = formatMoney(sumabonado);
                pendiente = formatMoney(data[0].monto-sumabonado);
                $("#modal_bonos .modal-header").append('<h4 class="card-title"><b>Detalle de pagos</b></h4>');
                $("#modal_bonos .modal-body").append(`<div class="row">
                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-12"><h6>Descripción: <u>${data[0].motivo}</u></h6></div>
                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-12"><h6>Usuario: <b>${nombre}</b></h6></div>
                <div class="col xol-xs-4 col-sm-4 col-md-4 col-lg-4"><h6>Monto Bono: formatMoney(data[0].monto)}</b></h6></div>
                <div class="col xol-xs-4 col-sm-4 col-md-4 col-lg-4"><h6>Pago mensual: <b>${formatMoney(data[0].pago)}</b></h6></div>
                <div class="col xol-xs-4 col-sm-4 col-md-4 col-lg-4"><h6>Pagos: <b>${data.length} /${data[0].num_pagos}</b></h6></div>
                <div class="col xol-xs-4 col-sm-4 col-md-4 col-lg-4"><h6>Abonado: <b style="color:blue;">${abonado}</b></h6></div>
                <div class="col xol-xs-4 col-sm-4 col-md-4 col-lg-4"><h6>Pagado: <b style="color:green;">${pagado}</b></h6></div>
                <div class="col xol-xs-4 col-sm-4 col-md-4 col-lg-4"><h6>Pendiente: <b style="color:red;">${pendiente}</b></h6></div>`);
                $("#modal_bonos .modal-body").append(`<br><div class="row">
                <div class="col-md-1"><h6><b>#</b></h6></div>
                <div class="col-md-2"><h6><b>MONTO</b></h6></div>
                <div class="col-md-2"><h6><b>FECHA ABONO</b></h6></div>
                <div class="col-md-4"><center><h6><b>CREADO POR</b></h6></center></div>
                <div class="col-md-3"><center><h6><b>ESTATUS</b></h6></center></div></div>`);

                for (let index = 0; index < data.length; index++) {
                let estatus = '';
                let color='';

                if(data[index].estado == 1){
                    estatus=data[index].est;
                    colorCss='lbl-azure'
                }
                else if(data[index].estado == 2){
                    estatus=data[index].est;
                    colorCss='lbl-violetBoots';
                }
                else if(data[index].estado == 3){
                    estatus=data[index].est;
                    colorCss='lbl-green';
                }
                else if(data[index].estado == 4){
                    estatus=data[index].est;
                    colorCss='lbl-violetBoots';
                }
                else if(data[index].estado == 5){
                    estatus=data[index].est;
                    colorCss='lbl-warning';
                }
                else if(data[index].estado == 6){
                    estatus=data[index].est;
                    colorCss='lbl-azure';
                } 
                $("#modal_bonos .modal-body").append(`<div class="row">
                    <div class="col-md-1"><h7>${index +1}</h7></div>
                    <div class="col-md-2"><h7>${formatMoney(data[index].abono)}</h7></div>
                    <div class="col-md-2"><h7>${data[index].date_final}</h7></div>
                    <div class="col-md-4"><h7>${data[index].creado_por}</h7></div>
                    <div class="col-md-3"><center><span class="label ${colorCss}">${estatus}</span><center></h7></div></div><br>`);
                }
                $("#modal_bonos").modal();
            }
        });
    });

    $('#tabla_bonos').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $("#tabla_bonos tbody").on("click", ".abonar", function(){
        bono = $(this).val();
        var dat = bono.split(",");
        $("#modal_abono .modal-header").html('');
        $("#modal_abono .modal-body").html('');
        $("#modal_abono .modal-footer").html('');
        $("#modal_abono .modal-header").append('<h4 class="card-title"><b>Abonar saldo</b></h4>');
        $("#modal_abono .modal-body").append(`<div id="inputhidden"><p>Se abonará la cantidad de <b style="color:green;">${formatMoney(dat[1])}</b> al usuario <b>${dat[3]}</b>.</p><input type="hidden" name="id_bono" id="id_bono" value="${dat[0]}"><input type="hidden" name="pago" id="pago" value="${dat[1]}"><input type="hidden" name="id_usuario" id="id_usuario" value="${dat[2]}">`);
        $("#modal_abono .modal-footer").append('<div class="row"><div class="col-md-12"><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button><input type="submit" class="btn btn-primary" value="ACEPTAR" style="margin: 15px;"></div></div>');
        $('#modal_abono').modal('show');
    });

    $("#tabla_bonos tbody").on("click", ".btn-delete", function(){    
        id = $(this).val();
        $("#modal-delete .modal-body").html('');
        $.getJSON(general_base_url + "Comisiones/TieneAbonos/" + id).done(function(data) {
        if(data == 1){
            $("#modal-delete .modal-body").append(`<center><img style='width: 80%; height: 80%;' src='${general_base_url}dist/img/error.gif'><p style='color:#9D9D9D;'><b>No se puede eliminar este bono</b>, ya cuenta con saldo abonado.</p></center>`);
        }
        else{
            $("#modal-delete .modal-body").append(`<div id="borrarBono"><form id="form-delete"><center><p style='color:#9D9D9D;'><b>¿Está seguro de eliminar este bono?</b><br>No tiene saldo abonado aún.</p></center><input type="hidden" id="id_bono" name="id_bono" value="${id}"><button class="btn btn-danger btn-simple" onclick="CloseModalDelete2();">Cerrar</button><input type="submit"  class="btn btn-primary" style="margin: 15px;" value="Aceptar"></form></div>`);
        }
        });
        $('#modal-delete').modal('show');
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

function CloseModalDelete2(){
    document.getElementById("form-delete").reset();
    a = document.getElementById('borrarBono');
    padre = a.parentNode;
    padre.removeChild(a);
    $("#modal-delete").modal('toggle');  
}

$(document).on('submit','#form-delete', function(e){ 
    e.preventDefault();
    var formData = new FormData(document.getElementById("form-delete"));
    formData.append("dato", "valor");
    $.ajax({
        method: 'POST',
        url: general_base_url + 'Comisiones/BorrarBono',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
        if (data == 1) {
            $('#tabla_bonos').DataTable().ajax.reload(null, false);
            CloseModalDelete2();
            alerts.showNotification("top", "right", "Abono registrado con exito.", "success");
            document.getElementById("form_abono").reset();
        } else if(data == 0) {
            $('#tabla_bonos').DataTable().ajax.reload(null, false);
            CloseModalDelete2();
            alerts.showNotification("top", "right", "Pago liquidado.", "warning");
        }
        },
        error: function(){
        closeModalEng();
        $('#modal_abono').modal('hide');
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#form_abono").on('submit', function(e){
    e.preventDefault();
    var formData = new FormData(document.getElementById("form_abono"));
    formData.append("dato", "valor");       
    $.ajax({
        method: 'POST',
        url: general_base_url + 'Comisiones/InsertAbono',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data == 1) {
            $('#tabla_bonos').DataTable().ajax.reload(null, false);
            closeModalEng();
            $('#modal_abono').modal('hide');
            alerts.showNotification("top", "right", "Abono registrado con éxito.", "success");
            document.getElementById("form_abono").reset(); 
            }
            else if(data == 2) {
            $('#tabla_bonos').DataTable().ajax.reload(null, false);
            closeModalEng();
            $('#modal_abono').modal('hide');
            alerts.showNotification("top", "right", "Pago liquidado.", "warning");
            }
            else if(data == 3){
            closeModalEng();
            $('#modal_abono').modal('hide');
            alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
            }
        },
        error: function(){
            closeModalEng();
            $('#modal_abono').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(window).resize(function(){
tabla_bonos1.columns.adjust();
});

$("#roles").change(function() {
    var parent = $(this).val();
    document.getElementById("users").innerHTML ='';
    $('#users').append(`<label class="control-label">Usuario</label><select id="usuarioid" name="usuarioid" class="selectpicker select-gral m-0 directorSelect" title="SELECCIONA UNA OPCIÓN" data-container="body" required data-live-search="true"></select>`);
    $.post('getUsuariosRolBonos/'+parent, function(data) {
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

function replaceAll( text, busca, reemplaza ){
    while (text.toString().indexOf(busca) != -1)
    text = text.toString().replace(busca,reemplaza);
    return text;
}

$("#numeroP").change(function(){
    let monto1 = replaceAll($('#monto').val(),',','');
    let monto = replaceAll(monto1,'$',''); 
    let cantidad = parseFloat($('#numeroP').val());
    let resultado=0;
    if (isNaN(monto)) {
        alerts.showNotification("top", "right", "Debe ingresar un monto válido.", "warning");
        $('#pago').val(resultado);
        document.getElementById('btn_abonar').disabled=true;
    }else{
        resultado = monto /cantidad;
        if(resultado > 0){
        document.getElementById('btn_abonar').disabled=false;
        $('#pago').val(formatMoney(resultado));
        }else{
        document.getElementById('btn_abonar').disabled=true;
        $('#pago').val(formatMoney(0));
        }
    }
});

function verificar(){
    let monto = parseFloat($('#monto').val());
    if(monto < 1 || isNaN(monto)){
        alerts.showNotification("top", "right", "Debe ingresar un monto mayor a 0.", "warning");
        document.getElementById('btn_abonar').disabled=true;
    }
    else{
        let cantidad = parseFloat($('#numeroP').val());
        resultado = monto /cantidad;
        $('#pago').val(formatMoney(resultado));
        document.getElementById('btn_abonar').disabled=false;
    }
}

function open_Mb(){
    $("#miModalBonos").modal();   
}

window.onload = function() {
    var myInput = document.getElementById('monto');
    myInput.onpaste = function(e) {
        e.preventDefault();
    }
    
    myInput.oncopy = function(e) {
        e.preventDefault();
    }
}