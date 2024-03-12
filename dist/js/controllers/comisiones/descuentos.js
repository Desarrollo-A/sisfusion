var totaPen = 0;
var tr;
var puestosGlobal = [], usuariosGlobal = [];
$(document).ready(function() {     
    $.post(general_base_url+"Descuentos/getDatosView", function (data) {
        var len = data.puestos.length;
        puestosGlobal = data.puestos;
        usuariosGlobal = data.usuarios;
        $(".selectpicker.rolesGlobal").append($('<option disabled selected>').val("").text("SELECCIONA UNA OPCIÓN"));
        for (var i = 0; i < len; i++) {
            var id = puestosGlobal[i]['id_opcion'];
            var name = puestosGlobal[i]['nombre'];
            $(".selectpicker.rolesGlobal").append($('<option>').val(id).text(name.toUpperCase()));
        }
        for (var i = 0; i < data.tipoDescuento.length; i++) {
            var id = data.tipoDescuento[i]['id_opcion'];
            var name = data.tipoDescuento[i]['nombre'];
            $("#tipo").append($('<option>').val(id).text(name.toUpperCase()));
        }
        if(len<=0){
            $(".selectpicker.rolesGlobal").append('<option selected="selected" disabled>NO SE HAN ENCONTRADOS REGISTROS</option>');
        }
        data.tipoDescuento.length <= 0 ? $("#tipo").append('<option selected="selected" disabled>NO SE HAN ENCONTRADOS REGISTROS</option>') : '';
        $(".selectpicker.rolesGlobal").selectpicker('refresh');
        $("#tipo").selectpicker('refresh');
    }, 'json');       
});
function changeName(e){
    const fileName = e.files[0].name;
    let relatedTarget = $( e ).closest( '.file-gph' ).find( '.file-name' );
    relatedTarget[0].value = fileName;
}
$("#form_descuentos").on('submit', function(e){
    $("#idloteorigen").prop("disabled", false);
    e.preventDefault();
    document.getElementById('btn_abonar').disabled=true;
    let formData = new FormData(document.getElementById("form_descuentos"));
    $.ajax({
        url: 'saveDescuento/'+1,
        data: formData,
        method: 'POST',
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {

            if (data == 1) {
                document.getElementById("form_descuentos").reset();
                $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                $('#miModal').modal('hide');
                $('#idloteorigen option').remove();
                $("#roles").selectpicker("refresh");
                $('#usuarioid').val('default');
                $("#usuarioid").selectpicker("refresh");
                document.getElementById('sumaReal').innerHTML = '';
                document.getElementById('btn_abonar').disabled=false;
                alerts.showNotification("top", "right", "Descuento registrado con exito.", "success");
            }
            else if(data == 2) {
                document.getElementById('btn_abonar').disabled=false;

                $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
                $(".directorSelect2").empty();
            }
            else if(data == 3){
                document.getElementById('btn_abonar').disabled=false;

                $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
                $(".directorSelect2").empty();
            }
        },
        error: function(){
            document.getElementById('btn_abonar').disabled=false;
            $('#miModal').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#form_descuentos2").on('submit', function(e){ 
    document.getElementById('btn_abonar2').disabled=true;
    $("#idloteorigen2").prop("disabled", false);
    e.preventDefault();

    let formData = new FormData(document.getElementById("form_descuentos2"));
    formData.append("dato", "valor");
    $.ajax({
        url: 'saveDescuento/'+2,
        data: formData,
        method: 'POST',
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {

            if (data == 1) {
                document.getElementById('btn_abonar2').disabled=false;
                document.getElementById("form_descuentos2").reset();
                $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                $('#miModal2').modal('hide');
                $('#idloteorigen2 option').remove();
                $("#roles2").val('');
                $("#roles2").selectpicker("refresh");
                $('#usuarioid2').val('default');
                $("#usuarioid2").selectpicker("refresh");
                document.getElementById('sumaReal2').innerHTML = '';
                document.getElementById('btn_abonar2').disabled=true;
                alerts.showNotification("top", "right", "Descuento registrado con exito.", "success");
            }
            else if(data == 2) {
                document.getElementById('btn_abonar2').disabled=false;
                $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
                $(".directorSelect2").empty();
            }
            else if(data == 3){
                document.getElementById('btn_abonar2').disabled=false;
                $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
                $(".directorSelect2").empty();
            }
        },
        error: function(){
            document.getElementById('btn_abonar2').disabled=false;
            $('#miModal').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

let titulos = [];
$("#tabla_descuentos").ready( function(){
    $('#tabla_descuentos thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
        $( 'input', this ).on('keyup change', function () {

            if (tabla_nuevas.column(i).search() !== this.value ) {
                tabla_nuevas.column(i).search(this.value).draw();
                var total = 0;
                var index = tabla_nuevas.rows({ selected: true, search: 'applied' }).indexes();
                var data = tabla_nuevas.rows( index ).data();
                $.each(data, function(i, v){
                    total += parseFloat(v.monto);
                });
                var to1 = formatMoney(total);
                document.getElementById("totalp").textContent = to1;
            }
        });
        $('[data-toggle="tooltip"]').tooltip({trigger: "hover" });
    });

    $('#tabla_descuentos').on('xhr.dt', function ( e, settings, json, xhr ) {
        var total = 0;
        $.each(json.data, function(i, v){
            total += parseFloat(v.monto);
        });
        var to = formatMoney(total);
        document.getElementById("totalp").textContent = to;
    });


    tabla_nuevas = $("#tabla_descuentos").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        scrollX: true,
        width:'100%',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'DESCUENTOS SIN APLICAR',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7],
                format: {
                    header:  function (d, columnIdx) {
                            return titulos[columnIdx];
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
        columns: [{
            data: function( d ){
                return d.id_pago_i
            }
        },
        {
            data: function( d ){
                return d.usuario
            }
        },
        {
            data: function( d ){
                return formatMoney(d.monto)
            }
        },
        {
            data: function( d ){
                return d.nombreLote
            }
        },
        {
            data: function( d ){
                return d.motivo
            }
        },
        {
            data: function( d ){
                if(d.estatus == 16 || d.estatus == '16'){
                    return '<span class="label lbl-oceanGreen">APLICADO</span>'; 
                }else{
                    return '<span class="label lbl-warning">INACTIVO</span>'; 
                }
            }
        },
        {
            data: function( d ){
                return d.modificado_por
            }
        },
        {
            data: function( d ){
                return d.fecha_abono
            }
        },
        {
            "orderable": false,
            data: function( d ){
                if((d.estatus != 16 || d.estatus != '16') && (id_rol_general != 63)){
                    return '<div class="d-flex justify-center"><button class="btn-data btn-green btn-update"  data-toggle="tooltip" data-placement="top" title="APROBAR DESCUENTO" value="'+d.id_pago_i+','+d.monto+','+d.usuario+','+d.nombreLote+'"><i class="material-icons">check</i></button></div>';
                }
                else{
                    return 'N/A';
                }
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            searchable:true,
            className: 'dt-body-center'
        }],
        ajax: {
            url: url2 + "Comisiones/getdescuentos",
            type: "POST",
            cache: false,
            data: function( d ){}
        },
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip({ 
        });       
        }
    });

    $("#tabla_descuentos tbody").on("click", ".abonar", function(){    
        bono = $(this).val();
        var dat = bono.split(",");
        $("#modal_abono .modal-body").append(`<div id="inputhidden">
        <h6>¿Seguro que desea descontar a <b>${dat[3]}</b> la cantidad de <b style="color:red;">${formatMoney(dat[1])}</b> correspondiente a la comisión de <b>${dat[2]}</b> ?</h6>
        <input type='hidden' name="id_bono" id="id_bono" value="${dat[0]}"><input type='hidden' name="pago" id="pago" value="${dat[1]}"><input type='hidden' name="id_usuario" id="id_usuario" value="${dat[2]}">
        <div class="col-md-3"></div>
        <div class="col-md-3">
            <button type="submit" id="" class="btn btn-primary ">GUARDAR</button>
            </div>
            <div class="col-md-3">
            <button type="button" onclick="closeModalEng()" class=" btn btn-danger" data-dismiss="modal">CANCELAR</button>
            </div>
            <div class="col-md-3"></div>
            </div>`);
        $("#modal_abono .modal-body").append(``);
        $('#modal_abono').modal('show');
    });

    $("#tabla_descuentos tbody").on("click", ".btn-delete", function(){    
        id = $(this).val();
        $("#modal-borrar .modal-body").append(`<div id="borrarBono"><form id="form-delete">
        <h5>¿Estas seguro que deseas eliminar este bono?</h5>
        <br>
        <input type="hidden" id="id_descuento" name="id_descuento" value="${id}">
        <input type="submit" class="btn btn-success" value="Aceptar">
        <button class="btn btn-danger" onclick="CloseModalDelete2();">Cerrar</button>
        </form></div>`);
        $('#modal-borrar').modal('show');
    });

    $("#tabla_descuentos tbody").on("click", ".btn-update", function(){
        var tr = $(this).closest('tr');
        var row = tabla_nuevas.row( tr );
        id_pago_i = $(this).val();
        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-body").append(`
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <p><h5>¿Seguro que desea descontar a <b>${row.data().usuario}</b> la cantidad de <b style="color:red;">${formatMoney(row.data().monto)}</b> correspondiente al lote <b>${row.data().nombreLote}</b> ?</h5></p>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12 text-right">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">ACEPTAR</button>
                </div>
            </div>
            `);
        $("#modal_nuevas").modal();
    });
});

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
    $("#modal-borrar").modal('toggle');
}

$(document).on('submit','#form-delete', function(e){ 
    e.preventDefault();
    var formData = new FormData(document.getElementById("form-delete"));
    formData.append("dato", "valor");
    $.ajax({
        method: 'POST',
        url: general_base_url+'Comisiones/BorrarDescuento',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data == 1) {
                $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                CloseModalDelete2();
                alerts.showNotification("top", "right", "Abono borrado con exito.", "success");
                document.getElementById("form_abono").reset();
            } else if(data == 0) {
                $('#tabla_descuentos').DataTable().ajax.reload(null, false);
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

$("#form_aplicar").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: general_base_url+'Comisiones/UpdateDescuento',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST',
            success: function(data){
                if( data = 1 ){
                    $("#modal_nuevas").modal('toggle' );
                    alerts.showNotification("top", "right", "Se aplicó el descuento correctamente", "success");
                    setTimeout(function() {
                        tabla_nuevas.ajax.reload();
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

function mandar_espera(idLote, nombre) {
    idLoteespera = idLote;
    link_espera1 = "Comisiones/generar comisiones/";
    $("#myModalEspera .modal-footer").html("");
    $("#myModalEspera .modal-body").html("");
    $("#myModalEspera ").modal();
    $("#myModalEspera .modal-footer").append("<div class='btn-group'><button type='submit' class='btn btn-success'>GENERAR COMISIÓN</button></div>");
}

$(window).resize(function(){
    tabla_nuevas.columns.adjust();
});

$("#roles").change(function() {
    var idPuesto = $(this).val();
    let getUsers = usuariosGlobal.filter(users => users.id_rol == idPuesto);
    document.getElementById('monto').value = ''; 
    document.getElementById('idmontodisponible').value = ''; 
    document.getElementById('comentario').value = '';
    document.getElementById('sumaReal').innerHTML = '';
    $('#idloteorigen option').remove();
    $('#usuarioid option').remove();
        var len = getUsers.length;
        $("#users").removeClass('hide');
        for( var i = 0; i<len; i++){
            var id = getUsers[i]['id_usuario'];
            var name =getUsers[i]['id_usuario']+' - '+getUsers[i]['nombre'];
            $("#usuarioid").append($('<option>').val(id).attr('data-value', id).text(name));
        }
        if(len<=0){
            $("#usuarioid").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#usuarioid").selectpicker('refresh');
});

$("#roles2").change(function() {
    var parent = $(this).val();
    document.getElementById('monto2').value = ''; 
    document.getElementById('idmontodisponible2').value = '';
    document.getElementById('sumaReal2').innerHTML = '';
    document.getElementById('comentario2').value = '';
    document.getElementById('sumaReal2').innerHTML = '';
    $('#usuarioid2 option').remove();
    $('#idloteorigen2 option').remove();
    $.post('getUsuariosRol/'+parent, function(data) {
        $(".usuario_seleccionar").removeClass('hide');
        var len = data.length;
        for( var i = 0; i<len; i++){
            var id = data[i]['id_usuario'];
            var name =data[i]['id_usuario']+' - '+data[i]['name_user'];    
            $("#usuarioid2").append($('<option>').val(id).attr('data-value', id).text(name));
        }
        if(len<=0){
            $("#usuarioid2").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#usuarioid2").selectpicker('refresh');
    }, 'json'); 
});

$("#idloteorigen").select2({dropdownParent:$('#miModal')});
$("#idloteorigen2").select2({dropdownParent:$('#miModal2')}); 
$("#usuarioid").change(function() {
    document.getElementById('monto').value = ''; 
    document.getElementById('idmontodisponible').value = ''; 
    document.getElementById('comentario').value = '';
    document.getElementById('montodisponible').innerHTML = '';
    document.getElementById('sumaReal').innerHTML = '';
    var user = $(this).val();
    $('#idloteorigen option').remove(); // clear all values
    $.post('getLotesOrigen/'+user+'/'+1, function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++){
            var name = data[i]['nombreLote'];
            var comision = data[i]['id_pago_i'];
            var pago_neodata = data[i]['pago_neodata'];
            let comtotal = data[i]['comision_total'] -data[i]['abono_pagado'];
            $("#idloteorigen").append(`<option value='${comision},${comtotal.toFixed(3)},${pago_neodata}'>${name}  - ${ formatMoney(comtotal.toFixed(3))}</option>`);
        }
        if(len<=0){
            $("#idloteorigen").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }else{
            $("#idloteorigen").prop("disabled", true);
            
        }
        $("#idloteorigen").selectpicker('refresh');
    }, 'json');     
    document.getElementById("monto").focus();
    alerts.showNotification("top", "right", "Debe ingresar el monto a descontar, antes de seleccionar pagos.", "warning"); 
});

$("#usuarioid2").change(function() {
    document.getElementById('monto2').value = ''; 
    document.getElementById('idmontodisponible2').value = '';
    document.getElementById('comentario2').value = '';
    document.getElementById('montodisponible2').innerHTML = ''; 
    document.getElementById('sumaReal2').innerHTML = '';

    var user = $(this).val();
    $('#idloteorigen2 option').remove();
    $.post('getLotesOrigen/'+user+'/'+2, function(data) {
        $("#idloteorigen2").append($('<option disabled>').val("default").text("Seleccione una opción"));
        var len = data.length;
    
        for( var i = 0; i<len; i++){
            var name = data[i]['nombreLote'];
            var comision = data[i]['id_pago_i'];
            var pago_neodata = data[i]['pago_neodata'];
            let comtotal = data[i]['comision_total'] -data[i]['abono_pagado'];
            
            $("#idloteorigen2").append(`<option value='${comision},${comtotal.toFixed(3)},${pago_neodata}'>${name}  - ${ formatMoney(comtotal.toFixed(3))}</option>`);
        }

        if(len<=0){
            $("#idloteorigen2").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }else{
            $("#idloteorigen2").prop("disabled", true);
        }

        $("#idloteorigen2").selectpicker('refresh');
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
            $.post('getInformacionData/'+id+'/'+1, function(data) {
                var disponible = (data[0]['comision_total']-data[0]['abono_pagado']);
                var idecomision = data[0]['id_pago_i'];
                suma = suma + disponible;
                document.getElementById('montodisponible').innerHTML = '';
                document.getElementById('sumaReal').innerHTML = 'Suma real:'+suma;
                $("#idmontodisponible").val(formatMoney(suma));
                $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="'+suma+'">');
                $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="'+idecomision+'">');
    
                var len = data.length;
                if(len<=0){
                    $("#idmontodisponible").val(formatMoney(0));
                }
                
                $("#montodisponible").selectpicker('refresh');
                verificarMontos();
            }, 'json');
        }
    }
    else if(cuantos == 1){
        var comision = $(this).val();
        datos = comision[0].split(',');
        let id = datos[0];
        let monto = datos[1];
        $.post('getInformacionData/'+id+'/'+1, function(data) {
            var disponible = (data[0]['comision_total']-data[0]['abono_pagado']);
            var idecomision = data[0]['id_pago_i'];
        
            document.getElementById('montodisponible').innerHTML = '';
            document.getElementById('sumaReal').innerHTML = 'Suma real:'+disponible;
            $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="'+disponible+'">');
            $("#idmontodisponible").val(formatMoney(disponible));
            $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="'+idecomision+'">');
                        
            var len = data.length;
            if(len<=0){
                $("#idmontodisponible").val(formatMoney(0));
            }

            $("#montodisponible").selectpicker('refresh');
            verificarMontos();
        }, 'json'); 
    }else {
        document.getElementById('montodisponible').innerHTML = '';
            document.getElementById('sumaReal').innerHTML = '';
        $("#montodisponible").append('');
        $("#idmontodisponible").val(0);
    }

});

$("#idloteorigen2").change(function() {
    let cuantos = $('#idloteorigen2').val().length;
    let suma =0;
    if(cuantos > 1){
        var comision = $(this).val();
        for (let index = 0; index < $('#idloteorigen2').val().length; index++) {
            datos = comision[index].split(',');
            let id = datos[0];
            let monto = datos[1];
            $.post('getInformacionData/'+id+'/'+2, function(data) {
                var disponible = (data[0]['comision_total']-data[0]['abono_pagado']);
                var idecomision = data[0]['id_pago_i'];
                suma = suma + disponible;
                document.getElementById('montodisponible2').innerHTML = '';
                document.getElementById('sumaReal2').innerHTML = 'Suma real:'+suma;
                $("#idmontodisponible2").val(formatMoney(suma));
                $("#montodisponible2").append('<input type="hidden" name="valor_comision2" id="valor_comision2" value="'+suma+'">');
                $("#montodisponible2").append('<input type="hidden" name="ide_comision2" id="ide_comision2" value="'+idecomision+'">');
            
                var len = data.length;
                if(len<=0){
                    $("#idmontodisponible2").val(formatMoney(0));
                }
                
                $("#montodisponible2").selectpicker('refresh');
                verificarMontos2();
            }, 'json');
        }
    }
    else if(cuantos == 1){
        var comision = $(this).val();
        datos = comision[0].split(',');
        let id = datos[0];
        let monto = datos[1];
        $.post('getInformacionData/'+id+'/'+2, function(data) {
            var disponible = (data[0]['comision_total']-data[0]['abono_pagado']);
            var idecomision = data[0]['id_pago_i'];
            document.getElementById('montodisponible2').innerHTML = '';
            document.getElementById('sumaReal2').innerHTML = 'Suma real:'+disponible;
            $("#montodisponible2").append('<input type="hidden" name="valor_comision2" id="valor_comision2" value="'+disponible+'">');
            $("#idmontodisponible2").val(formatMoney(disponible));
        
            $("#montodisponible2").append('<input type="hidden" name="ide_comision2" id="ide_comision2" value="'+idecomision+'">');
                        
            var len = data.length;
            if(len<=0){
                $("#idmontodisponible2").val(formatMoney(0));
            }
            $("#montodisponible2").selectpicker('refresh');
            verificarMontos2();
        }, 'json'); 

    }else {
        document.getElementById('montodisponible2').innerHTML = '';
            document.getElementById('sumaReal2').innerHTML = '';
        $("#montodisponible2").append('');
        $("#idmontodisponible2").val(0);
    }
});

$("#numeroP").change(function(){
    let monto = parseFloat($('#monto').val());
    let cantidad = parseFloat($('#numeroP').val());
    let resultado=0;

    if (isNaN(monto)) {
        alerts.showNotification("top", "right", "Debe ingresar un monto valido.", "warning");
        $('#pago').val(resultado);
        document.getElementById('btn_abonar').disabled=true;
    }
    else{
        resultado = monto /cantidad;

        if(resultado > 0){
            document.getElementById('btn_abonar').disabled=false;
            $('#pago').val(formatMoney(resultado));
        }
        else{
            document.getElementById('btn_abonar').disabled=true;
            $('#pago').val(formatMoney(0));
        }
    }
});

$("#numeroP2").change(function(){
    let monto = parseFloat($('#monto2').val());
    let cantidad = parseFloat($('#numeroP2').val());
    let resultado=0;
    if (isNaN(monto)) {
        alerts.showNotification("top", "right", "Debe ingresar un monto valido.", "warning");
        $('#pago2').val(resultado);
        document.getElementById('btn_abonar2').disabled=true;
    }
    else{
        resultado = monto /cantidad;
        if(resultado > 0){
            document.getElementById('btn_abonar2').disabled=false;
            $('#pago2').val(formatMoney(resultado));
        }
        else{
            document.getElementById('btn_abonar2').disabled=true;
            $('#pago2').val(formatMoney(0));
        }
    }
});

function verificar(){
    let disponible = $('#valor_comision').val();
    let monto = remplazarCaracter($('#monto').val(), ',', '');
    monto = remplazarCaracter(monto, '$', '');
    if(monto < 1 || isNaN(monto)){
        alerts.showNotification("top", "right", "Debe ingresar un monto mayor a 0.", "warning");
        document.getElementById('btn_abonar').disabled=true; 
    }
    else{
        if(disponible !== '' && disponible !== undefined && disponible !== 'undefined'){
            disponible = remplazarCaracter($('#valor_comision').val(), '$', '');
            disponible = remplazarCaracter(disponible, ',', '');
            if(parseFloat(disponible) >= parseFloat(monto)){
            $("#idloteorigen").prop("disabled", true);
            document.getElementById('btn_abonar').disabled=false; 
            }else{
                $("#idloteorigen").prop("disabled", false);
                document.getElementById('btn_abonar').disabled=true; 
            }
        }else{
            $("#idloteorigen").prop("disabled", false);
        }       
    }      
}
function verificarMontos(){
    
    let disponible = remplazarCaracter($('#valor_comision').val(), '$', '');
    disponible = remplazarCaracter(disponible, ',', '');
    let monto = remplazarCaracter($('#monto').val(), ',', '');
    let cuantos = $('#idloteorigen').val().length;
    if(parseFloat(monto) <= parseFloat(disponible) ){
        $("#idloteorigen").prop("disabled", true);
        $("#btn_abonar").prop("disabled", false);    
            let cantidad = parseFloat($('#numeroP').val());
            resultado = monto /cantidad;
            $('#pago').val(formatMoney(resultado));
            document.getElementById('btn_abonar').disabled=false;

          
            let cadena = '';
            var data = $('#idloteorigen').select2('data')
            for (let index = 0; index < cuantos; index++) {
                let datos = data[index].id;
                let montoLote = datos.split(',');

                cadena = cadena+' , '+data[index].text;
                document.getElementById('msj2').innerHTML='';
            }
            $('#comentario').val('Lotes involucrados en el descuento: '+cadena+'. Por la cantidad de: $'+formatMoney(monto));
        }
        else if(parseFloat(monto) > parseFloat(disponible) ){
                                 document.getElementById('btn_abonar').disabled=true; 
        }
}
function verificarMontos2(){
    let disponible = remplazarCaracter($('#valor_comision2').val(), '$', '');
    disponible = remplazarCaracter(disponible, ',', '');
    let monto = remplazarCaracter($('#monto2').val(), ',', '');
    let cuantos = $('#idloteorigen2').val().length;
    if(parseFloat(monto) <= parseFloat(disponible) ){
        $("#idloteorigen2").prop("disabled", true);
        $("#btn_abonar2").prop("disabled", false);
            let cantidad = parseFloat($('#numeroP2').val());
            resultado = monto /cantidad;
            $('#pago2').val(formatMoney(resultado));
            document.getElementById('btn_abonar2').disabled=false;
            let cadena = '';
            var data = $('#idloteorigen2').select2('data')
            for (let index = 0; index < cuantos; index++) {
                let datos = data[index].id;
                let montoLote = datos.split(',');
                cadena = cadena+' , '+data[index].text;
                document.getElementById('msj').innerHTML='';
            }
            $('#comentario2').val('Lotes involucrados en el descuento: '+cadena+'. Por la cantidad de: '+formatMoney(monto));
        }
        else if(parseFloat(monto) > parseFloat(disponible) ){
            document.getElementById('btn_abonar2').disabled=true; 
        }
}

function verificar2(){
    let disponible = $('#valor_comision2').val();
    let monto = remplazarCaracter($('#monto2').val(), ',', '');
    monto = remplazarCaracter(monto, '$', '');
    if(monto < 1 || isNaN(monto)){
        alerts.showNotification("top", "right", "Debe ingresar un monto mayor a 0.", "warning");
        document.getElementById('btn_abonar2').disabled=true; 
    }
    else{
        if(disponible != '' && disponible !== undefined && disponible != 'undefined'){
            disponible = remplazarCaracter(disponible, '$', '');
            disponible = remplazarCaracter(disponible, ',', '');

            if(parseFloat(disponible) >= parseFloat(monto)){
            $("#idloteorigen2").prop("disabled", true);
            document.getElementById('btn_abonar2').disabled=false; 
            }else{
                $("#idloteorigen2").prop("disabled", false);
                document.getElementById('btn_abonar2').disabled=true; 
            }
        }else{
            $("#idloteorigen2").prop("disabled", false);
        }            
    }    
}