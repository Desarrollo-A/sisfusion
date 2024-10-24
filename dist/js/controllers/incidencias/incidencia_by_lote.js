var mensualidad = [];
var catalogoUsuario = [];
var listaUsuarios = [];
var catalogo2 = [];
var subdirector = [];
var gerente = [];
var coordinador = [];
var asesor = [];
var diRegional = [];

$(document).ready(function () {
    $.getJSON(general_base_url + "Incidencias/fillMensualidades").done(function(data) {
        mensualidad = data;
        for (let i = 0; i < mensualidad.length; i++) {
            $("#mensualidad9").append($('<option>').val(mensualidad[i]['id_opcion']).text(mensualidad[i]['nombre']));
        }
        $('#mensualidad9').selectpicker('refresh');
    });

    $.getJSON( general_base_url + "Incidencias/catalogoUsuarios").done( function( data ){
        catalogoUsuario = data;
    });
    
    $.getJSON( general_base_url + "Incidencias/getUsers/").done( function( data ){
        listaUsuarios = data;

        diRegional = data.filter((diReg) => diReg.idRol == parseInt(59));
        len5 = diRegional.length;
        for( let i5=0; i5<len5; i5++){
            var id_usuario_diRegional = diRegional[i5]['id_usuario'];
            var nombre_diRegional = diRegional[i5]['name_user'];
            $("#elegir_diRegional").append($('<option>').val(id_usuario_diRegional).attr('data-value',id_usuario_diRegional ).text(id_usuario_diRegional+ "- "+ nombre_diRegional));
        }
        subdirector = data.filter((subdi) => subdi.id_rol == parseInt(2));
        len4 = subdirector.length;
        for( let i4 = 0; i4<len4; i4++){
            var id_usuario_subdirector = subdirector[i4]['id_usuario'];
            var nombre_subdirecto = subdirector[i4]['name_user'];

            var id4 = id_usuario_subdirector+','+nombre_subdirecto;
            
            $("#add_subdirector").append($('<option>').val(id4).attr('data-value',id_usuario_subdirector ).text(id_usuario_subdirector+ "- "+nombre_subdirecto));
            $("#elegir_subdirector").append($('<option>').val(id_usuario_subdirector).attr('data-value',id_usuario_subdirector ).text(id_usuario_subdirector+ "- "+ nombre_subdirecto));
           
        }

        gerente = data.filter((gere) => gere.id_rol == parseInt(3));
        len3 = gerente.length;
        for( let i3=0; i3<len3; i3++){
            var id_usario_gerente = gerente[i3]['id_usuario'];
            var nombre_gerente = gerente[i3]['name_user'];

            var id3 = id_usario_gerente+','+nombre_gerente;
            
            $("#add_gerente").append($('<option>').val(id3).attr('data-value',id_usario_gerente ).text(id_usario_gerente+ "- "+ nombre_gerente));
            $("#elegir_gerente").append($('<option>').val(id_usario_gerente).attr('data-value',id_usario_gerente ).text(id_usario_gerente+ "- "+ nombre_gerente));
        }

        coordinador = data.filter((coor) => coor.id_rol == parseInt(9));
        len2 = coordinador.length;
        for( var i2= 0; i2<len2; i2++){
            var id_opcion_coordinador = coordinador[i2]['id_usuario'];
            var nombre_coordinador = coordinador[i2]['name_user'];

            var id2 = id_opcion_coordinador+','+nombre_coordinador;
            
            $("#add_coordinador").append($('<option>').val(id2).attr('data-value',id_opcion_coordinador ).text(id_opcion_coordinador+ "- "+ nombre_coordinador));
            $("#elegir_coordinador").append($('<option>').val(id_opcion_coordinador).attr('data-value',id_opcion_coordinador ).text(id_opcion_coordinador+ "- "+ nombre_coordinador)); 
        }


        asesor = data.filter((ases) => ases.id_rol == parseInt(7));
        len = coordinador.length;
        for( var i= 0; i<len; i++){
            var id_usuario_asesor = asesor[i]['id_usuario'];
            var nombre_asesor = asesor[i]['name_user'];
            
            id =id_usuario_asesor+','+nombre_asesor; 
            $("#elegir_asesor").append($('<option>').val(id_usuario_asesor).attr('data-value',id_usuario_asesor ).text(id_usuario_asesor+ "- "+ nombre_asesor));
            $("#add_asesor").append($('<option>').val(id).attr('data-value',id_usuario_asesor ).text(id_usuario_asesor+ "- "+ nombre_asesor));
             
        }
        $("#add_coordinador, #add_asesor, #add_gerente, #add_subdirector").selectpicker('refresh');
        $("#elegir_coordinador, #elegir_gerente, #elegir_subdirector, #elegir_asesor").selectpicker('refresh');
        
    });

    $.getJSON( general_base_url + "Incidencias/listaRol/").done( function( data ){
        catalogo2 = data;
    });
});

 
$.post(general_base_url+"Incidencias/getAsesoresBaja", function(data) {
    var len = data.length;
    for (var i = 0; i < len; i++) {
        var id = data[i]['id_usuario'];
        var name = data[i]['nombre'];
        $("#asesorold").append($('<option>').val(id).text(name.toUpperCase()));
    }
 
    $("#asesorold").selectpicker('refresh');
}, 'json'); 

$("#modal_avisos").draggable({
    handle: ".modal-header"
}); 

// ---------------------------Inicia funciones del botón con la clase Inventario-----------------------

var rol  = id_rol_general;
const id_usuariosPermisos = [1, 2767, 2826, 11947, 5957, 2749, 9775, 11815];
var id_user  = id_usuario_general;
var banderaPermisos = id_usuariosPermisos.includes(id_usuario_general) ? 1 : 0;
var idLote = 0;
var banderaAgregarVenta=0;

$('#editar_venta_compartida').on('click', function(){
    $('#miModalVc').modal('show');
    $('#modal_vCompartida').modal('hide');

})

$('#agregar_venta_compartida').on('click', function(){
    $('#miModalVcNew').modal('show');
    $('#modal_vCompartida').modal('hide');

    $("#elegir_asesor, #elegir_coordinador, #elegir_gerente,#elegir_subdirector, #elegir_diRegional").val('');
    $("#elegir_asesor, #elegir_coordinador, #elegir_gerente,#elegir_subdirector, #elegir_diRegional").selectpicker("refresh");
    $("#elegir_asesor, #elegir_coordinador, #elegir_gerente,#elegir_subdirector, #elegir_diRegional").val('default');
                
    banderaAgregarVenta =1;

})

var banderaBoton =0;
$('.boton_usuario').click(function(ef) {
    ef.preventDefault();
    $("#boton_vCompartida").prop('disabled',false);
    $('#add_subdirector, #add_coordinador, #add_gerente, #add_asesor').attr('required', true);
    $('#puesto_usuario, #add_coordinador, #add_gerente, #add_subdirector, #add_asesor').val('');
    $("#puesto_usuario, #add_coordinador, #add_gerente, #add_subdirector, #add_asesor").selectpicker("refresh");
    $('#input_coordinador, #input_asesor, #input_gerente, #input_subdirector').addClass('hide');

    var selectId = $(this).attr('data-target');
                        
    switch (selectId) {
        case 'select1':
            banderaBoton = 1;
            $('#titulo_modal_cordi').text('AGREGAR COORDINADOR');                           
            break;
        case 'select2':
            banderaBoton = 2;
            $('#titulo_modal_cordi').text('AGREGAR GERENTE');
            break;
        case 'select3':
            banderaBoton = 3;
            $('#titulo_modal_cordi').text('AGREGAR SUBDIRECTOR');
            break;
        case 'select4':
            banderaBoton = 4;
            $('#titulo_modal_cordi').text('AGREGAR DIRECTOR REGIONAL');
            break;
        case 'select5':
            banderaBoton = 5;
            $('#titulo_modal_cordi').text('AGREGAR ASESOR');
            break;
        default:
            $('#modal_coordinador').modal('hide');
            alerts.showNotification("top", "right", "Ocurrio un error, intenta mas tarde.", "danger");
            break;
    }

    $('#modal_coordinador').modal('show');
});

$('#puesto_usuario').change(function(){
    var seleccionado = $('#puesto_usuario').val();

    if(seleccionado == 2){
        $('#input_subdirector').removeClass('hide');
        $('#add_subdirector').attr('required', true);
        $('#add_coordinador, #add_gerente, #add_asesor').removeAttr('required');
        $('#input_asesor,#input_gerente,#input_coordinador').addClass('hide');
        $("#add_coordinador, #add_gerente, #add_asesor").selectpicker("refresh");
        $('#add_coordinador, #add_gerente, #add_asesor').val('');
        $("#add_coordinador, #add_gerente, #add_asesor").trigger('change');

    }else if(seleccionado == 3){
        $('#input_gerente').removeClass('hide');
        $('#add_gerente').attr('required', true);
        $('#add_coordinador, #add_subdirector, #add_asesor').removeAttr('required');
        $('#input_asesor, #input_subdirector, #input_coordinador').addClass('hide');
        $("#add_coordinador, #add_subdirector, #add_asesor").selectpicker("refresh");
        $('#add_coordinador, #add_subdirector, #add_asesor').val('');
        $("#add_coordinador, #add_subdirector, #add_asesor").trigger('change');
    }else if(seleccionado == 9){
        $('#input_coordinador').removeClass('hide');
        $('#add_coordinador').attr('required', true);
        $('#add_gerente, #add_subdirector, #add_asesor').removeAttr('required');
        $('#input_asesor, #input_gerente, #input_subdirector').addClass('hide');
        $("#add_gerente, #add_subdirector, #add_asesor").selectpicker("refresh");
        $('#add_gerente, #add_subdirector, #add_asesor').val('');
        $("#add_gerente, #add_subdirector, #add_asesor").trigger('change');

    }else if(seleccionado == 7){
        $('#input_asesor').removeClass('hide');
        $('#add_asesor').attr('required', true);
        $('#add_gerente, #add_subdirector, #add_coordinador').removeAttr('required');
        $('#input_gerente, #input_subdirector, #input_coordinador').addClass('hide');
        $("#add_gerente, #add_subdirector, #add_coordinador").selectpicker("refresh");
        $('#add_gerente, #add_subdirector, #add_coordinador').val('');
        $("#add_gerente, #add_subdirector, #add_coordinador").trigger('change');
    }
       
});

$("#agregar_lider").on("submit", function(e){ 
    e.preventDefault();
    e.stopImmediatePropagation();
    $("#boton_vCompartida").prop('disabled',true);


    var coordi = $('#add_coordinador').val();
    var id1 = coordi.split(',');
    var id_usuario1 = id1[0];
    var name1 = id1[1];

     var gere = $('#add_gerente').val();
     var id2 = gere.split(',');
     var id_usuario2 = id2[0];
     var name2 = id2[1];

     var subd = $('#add_subdirector').val();
     var id3 = subd.split(',');
     var id_usuario3 = id3[0];
     var name3 = id3[1];

     var asesor = $('#add_asesor').val();
     var id4 = asesor.split(',');
     var id_usuario4 = id4[0];
     var name4 = id4[1];

     if(banderaBoton == 1 ){
        inputselect = 'elegir_coordinador';
     }else if(banderaBoton == 2){
        inputselect = 'elegir_gerente';
     } else if(banderaBoton == 3){
         inputselect = 'elegir_subdirector';
     } else if(banderaBoton == 4){
        inputselect = 'elegir_diRegional';
     } else if(banderaBoton == 5){
       inputselect = 'elegir_asesor';
     }

     id_usuario2 == 0 && id_usuario3 == 0 && id_usuario4 == 0 && id_usuario1 != 0 ? $('#'+inputselect+'').append($('<option>').val(id_usuario1).attr('data-value', id_usuario1).text(id_usuario1+' - '+name1))+ $('#'+inputselect+'').val(parseInt(id_usuario1)).trigger('change') + alerts.showNotification("top", "right", "Datos actualizados.", "success"): '';
     id_usuario1 == 0 && id_usuario3 == 0 && id_usuario4 == 0 && id_usuario2 != 0 ? $('#'+inputselect+'').append($('<option>').val(id_usuario2).attr('data-value', id_usuario2).text(id_usuario2+' - '+name2))+ $('#'+inputselect+'').val(parseInt(id_usuario2)).trigger('change') + alerts.showNotification("top", "right", "Datos actualizados.", "success"): '';
     id_usuario2 == 0 && id_usuario1 == 0 && id_usuario4 == 0 && id_usuario3 != 0 ? $('#'+inputselect+'').append($('<option>').val(id_usuario3).attr('data-value', id_usuario3).text(id_usuario3+' - '+name3))+ $('#'+inputselect+'').val(parseInt(id_usuario3)).trigger('change') + alerts.showNotification("top", "right", "Datos actualizados.", "success"): '';
     id_usuario2 == 0 && id_usuario1 == 0 && id_usuario3 == 0 && id_usuario4 != 0 ? $('#'+inputselect+'').append($('<option>').val(id_usuario4).attr('data-value', id_usuario4).text(id_usuario4+' - '+name4))+ $('#'+inputselect+'').val(parseInt(id_usuario4)).trigger('change') + alerts.showNotification("top", "right", "Datos actualizados.", "success"): '';


     $('#'+inputselect+'').selectpicker("refresh");

    $('#modal_coordinador').modal('hide');

});

function selectOpcion(){
    banderaAgregarVenta = 0 ;

    id_cliente = document.getElementById("clientes2").value;
    idLote     = document.getElementById("lotes1").value;
    cuantos = document.getElementById("ventaCompartida").value;
    
    var parent = $('#opcion').val();
    $('#modal_avisitos').modal('hide');
    document.getElementById('UserSelect').innerHTML='';
    $('#usuarioid4 option').remove(); 
    $("#usuarioid4").val('');
    $('#usuarioid4').val('default');
    $("#usuarioid4").selectpicker("refresh");

    if(parent == 1){
        $.getJSON( general_base_url + "incidencias/getUserInventario/"+id_cliente).done( function( data ){

            $('#miModalInventario .invent').html('');
            $('#miModalInventario .invent').append(`
            <h5>Usuarios titulares registrados</h5>
            <div class="row">
            <div class="col-md-6" id="ase2">
            <b><label class="control-label" >Asesor</b></label>
            <input class="form-control input-gral ng-invalid ng-invalid-required" required readonly="true" value="${data.asesor}" style="font-size:12px;">
        
            </div>
            <div class="col-md-6" id="coor2">
            <b><label class="control-label" >Coordinador</b></label>
            <input class="form-control input-gral ng-invalid ng-invalid-required" required readonly="true" value="${data.coordinador == '' || data.coordinador == ' ' || data.coordinador == '  ' ? 'NO REGISTRADO' : data.coordinador}" style="font-size:12px;">
         
            </div>
            <div class="col-md-6" id="ger2">
            <b><label class="control-label" >Gerente</b></label>
            <input class="form-control input-gral ng-invalid ng-invalid-required" required readonly="true" value="${data.gerente}" style="font-size:12px;">
 
            </div>
            
            <div class="col-md-6" id="sub">
            <b><label class="control-label" >Sub-director</b></label>
            <input class="form-control input-gral ng-invalid ng-invalid-required" required readonly="true" value="${data.subdirector}" style="font-size:12px;">
          
            </div>
            <div class="col-md-6" id="regio">
            <b><label class="control-label" >Regional</b></label>
            <input class="form-control input-gral ng-invalid ng-invalid-required" required readonly="true" value="${data.regional}" style="font-size:12px;">
         
            </div>

            </div>
            <input type="hidden" value="${data.id_asesor}" id="asesor" name="asesor">
            <input type="hidden" value="${data.id_coordinador}" id="coordinador" name="coordinador">
            <input type="hidden" value="${data.id_gerente}" id="gerente" name="gerente">
          
            <input type="hidden" value="${data.id_subdirector}" id="subdirector" name="subdirector">
            <input type="hidden" value="${data.id_regional}" id="regional" name="regional">
            
            <input type="hidden" value="${data.asesor}" id="asesorname" name="asesorname">
            <input type="hidden" value="${data.coordinador}" id="coordinadorname" name="coordinadorname">
            <input type="hidden" value="${data.gerente}" id="gerentename" name="gerentename">

            <input type="hidden" value="${data.subdirector}" id="subdirectorname" name="subdirectorname">
            <input type="hidden" value="${data.regional}" id="regionalname" name="regionalname">

            <input type="hidden" value="${idLote}" id="idLote" name="idLote" >
            <input type="hidden" value="${id_cliente}" id="idCliente" name="idCliente">
            `);
            $('#miModalInventario').modal('show');
        });
    }
    else if (parent == 2){
        //VENTA COMPARTIDA

            $('[data-toggle="tooltip"]').tooltip();
            $('#miModalVcNew .vcnew').html('');
            $("#btn_vcnew").prop('disabled',false);
            if(cuantos == 0 || banderaAgregarVenta==1){
                $('#form_vcNew')[0].reset();

                $("#elegir_asesor, #elegir_coordinador, #elegir_gerente,#elegir_subdirector, #elegir_diRegional").val('');
                $("#elegir_asesor, #elegir_coordinador, #elegir_gerente,#elegir_subdirector, #elegir_diRegional").selectpicker("refresh");
                $("#elegir_asesor, #elegir_coordinador, #elegir_gerente,#elegir_subdirector, #elegir_diRegional").val('default');
                
                $('#miModalVcNew .vcnew').append(`
                <input type="hidden" id="id_lote" value="${idLote}" name="id_lote" >
                <input type="hidden" id="id_cliente" value="${id_cliente}" name="id_cliente" >`);
                
                $('#miModalVcNew').modal('show');

            }
            else if(cuantos == 1){

                $('#modal_vCompartida').modal('show');
                $('#agregar_venta_compartida').prop('disabled', false);
                $('#agregar_venta_compartida').removeClass('btn-gray');
                
                banderaAgregarVenta = 0;

                $.getJSON( general_base_url + "Incidencias/getUserVC/"+id_cliente).done( function( data ){
                    let cVentas = data.length;

                    if(cVentas == 3){
                        $('#agregar_venta_compartida').prop('disabled', true);
                        $('#agregar_venta_compartida').addClass('btn-gray');
                        alerts.showNotification("top", "right", "Esta lote ya alcanzó el limite de ventas compartidas.", "warning");
                    }

                    $('#miModalVc .vc').html('');
                    $('#miModalVc .vc').append(`
                        <h5>Usuarios registrados en venta compartida</h5>
                        <div class="row">
                        <div class="col-md-4" id="ase">
                        <input class="form-control input-gral ng-invalid ng-invalid-required" required readonly="true" value="${data[0].asesor}" style="font-size:12px;">
                        <b><p style="font-size:12px;">Asesor</b></p>
                        </div>
                        <div class="col-md-4" id="coor">
                        <input class="form-control input-gral ng-invalid ng-invalid-required" required readonly="true" value="${data[0].coordinador == '' || data[0].coordinador == ' ' || data[0].coordinador == '  ' ? 'NO REGISTRADO' : data[0].coordinador}" style="font-size:12px;color:${data[0].coordinador == '' || data[0].coordinador == ' ' || data[0].coordinador == '  ' ? 'red' : 'black'}">
                        <b><p style="font-size:12px;">Coordinador</b></p>
                        </div>
                        <div class="col-md-4" id="ger">
                        <input class="form-control input-gral ng-invalid ng-invalid-required" required readonly="true" value="${data[0].gerente}" style="font-size:12px;">
                        <b><p style="font-size:12px;">Gerente</b></p>
                        </div>
                        </div>
                        <input type="hidden" value="${data[0].id_vcompartida}" id="id_vc" name="id_vc">
                        <input type="hidden" value="${cuantos}" id="cuantos" name="cuantos">
                        <input type="hidden" value="${data[0].id_asesor}" id="asesor" name="asesor">
                        <input type="hidden" value="${data[0].id_coordinador}" id="coordinador" name="coordinador">
                        <input type="hidden" value="${data[0].id_gerente}" id="gerente" name="gerente">
                        <input type="hidden" value="${data[0].asesor}" id="asesorname" name="asesorname">
                        <input type="hidden" value="${data[0].coordinador}" id="coordinadorname" name="coordinadorname">
                        <input type="hidden" value="${data[0].gerente}" id="gerentename" name="gerentename">
                        <input type="hidden" value="${idLote}" id="idLote" name="idLote" >
                        <input type="hidden" value="${id_cliente}" id="idCliente" name="idCliente">
                        
                        `);
                });
                }
                else if(cuantos == 2){
                    $('#modal_avisos .modal-body').html('');
                    $('#modal_avisos .modal-body').append(`
                    <h4><em>Revisar con sistema para esté caso.</em></h4>`);
                    $('#modal_avisos').modal('show');
                }
         
    } else if(parent == 3) {
        $("#btn_rol").prop('disabled',false);
        $('#select_usuarios').html('');
        $('#select_roles').html('');
        $("#select_usuarios").selectpicker("refresh");
        $('#select_usuarios').val('default');
        $("#select_roles").selectpicker("refresh");
        $('#select_roles').val('default');
        $('#rol_usuario').val('');

        $('#modal_cambio_rol').modal('show');

        $.getJSON( general_base_url + "Incidencias/comisionesUsuarios/"+idLote+"/"+1).done( function( data ){
            datos2 = data;
            var len2 = datos2.length;
            for( var i2 = 0; i2<len2; i2++){
                var id_opcion = datos2[i2]['id_usuario'];
                var descripcion = datos2[i2]['colaborador'];
                var nombre = datos2[i2]['nombre'];

                var id = id_opcion+','+nombre
                
                $("#select_usuarios").append($('<option>').val(id).attr('data-value',id_opcion ).text(id_opcion+ "- "+ descripcion));
                
            }
            $("#select_usuarios").selectpicker('refresh');
            
            $('#select_usuarios').change(function(){
                var idSeleccionado = $('#select_usuarios').val();
                var puesto = idSeleccionado.split(',')
                var puesto1 = puesto[1];
                $('#rol_usuario').val(puesto1);

                var puesto2 = puesto[0];
                if(puesto2 == 2){
                    $('#select_roles').html('');
                    for (let i = 0; i < catalogoUsuario.length; i++) {
                        $("#select_roles").append($('<option>').val(catalogoUsuario[i]['id_opcion']).text(catalogoUsuario[i]['nombre']));
                    }
                    $("#select_roles").selectpicker('refresh');

                }else{
                    $('#select_roles').html('');
                    for (let i = 1; i < catalogoUsuario.length; i++) {
                        $("#select_roles").append($('<option>').val(catalogoUsuario[i]['id_opcion']).text(catalogoUsuario[i]['nombre']));
                    }
                    $("#select_roles").selectpicker('refresh');
                    
                }

            });
            
        }); 

       

    }
    
}
// ---------------------------Termina funciones del botón con la clase Inventario-----------------------

$("#form_roles").on("submit" , function(e){
    e.preventDefault();
    $("#btn_rol").prop('disabled',true);
    idLote     = document.getElementById("lotes1").value;
    proceso     = document.getElementById("proceso").value;

    var id = $('#select_usuarios').val();
    var id1 = id.split(',')
    var id_usuario = id1[0];

    var id_rol = $('#select_roles').val();

    var updateRoles = new FormData();

    updateRoles.append("idLote", idLote);
    updateRoles.append("id_rol", id_rol);
    updateRoles.append("id_usuario", id_usuario);
    updateRoles.append("proceso", proceso);
    

    $.ajax({
        url: general_base_url+'Incidencias/actualizarRol',
        data: updateRoles,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'JSON',
        type: 'POST', 
        success:function(data){
            if (data == 1) {
                $('#modal_cambio_rol').modal("hide");
                
                alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
            } else {
                alerts.showNotification("top", "right", "Oops, algo salió mal. Error al intentar actualizar.", "warning");
            }

        }

    });

});


    
$("#asesorold").change(function() {
    $("#info").removeAttr('style');
    document.getElementById('info').innerHTML='Cargando...';
    var parent = $(this).val();
     $.post(general_base_url+'Incidencias/datosLotesaCeder/'+parent, function(data) { 
        document.getElementById('info').innerHTML='';
        var len = data[0].length;
        if(len ==0 ){
            $('#info').append(`<h5>No se encontraron comisiones</h5>`);
        }
        else{    
            if(len > 5){
                $("#info").css("max-height", "300px");
                $("#info").css("overflow", "scroll");
            }
            $('#info').append(`
            <table class="table mt-2 tableAsesorOld">
            <thead style="color: white; font-size: 9px;">
            <tr>
                <th style="text-align: center">ID LOTE</th>
                <th style="text-align: center">LOTE</th>
                <th style="text-align: center">COMISIÓN TOTAL</th>
                <th style="text-align: center">COMISIÓN TOPADA</th>
                <th style="text-align: center">COMISIÓN NUEVO ASESOR</th>
            </tr>
            <tbody class="tinfo" style="font-size:12px;text-align:center;">`);
            
            for( var i = 0; i<len; i++){
                $('#info .tinfo').append(`<tr>
                <td>${data[0][i].id_lote}</td>
                <td>${data[0][i].nombreLote}</td>
                <td>$${formatMoney(data[0][i].com_total)}</td>
                <td>$${formatMoney(data[0][i].tope)}</td>
                <td style="color:green;">$${formatMoney(data[0][i].resto)}</td>
                </tr>`);    
            }
            
            $('#info').append(`</tbody></thead></table>`);
            if(len<=0){
                $("#datosLote").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
            }
        }
    }, 'json'); 
});


$("#roles3").change(function() {
    var parent = $(this).val();
    document.getElementById('UserSelect').innerHTML = '';
    document.getElementById('UserSelectDirec').innerHTML = '';
    let user =0;
    let bandera59 = 0 ;
    let nameUser='';
    if(parent == 7){
        user = $('#asesor').val();
        $('#ase').addClass('ase');
        $('#coor').removeClass('coor');
        $('#ger').removeClass('ger');

        nameUser = $('#asesorname').val();
    }
    else if(parent == 9){
        user = $('#coordinador').val();
        nameUser = $('#coordinadorname').val();
        if($('#coordinador').val() == 0 || $('#coordinador').val() == null || $('#coordinador').val() == 'null'){
            nameUser='NO REGISTRADO';
            user = 0;
        }
        $('#coor').addClass('coor');
        $('#ase').removeClass('ase');
        $('#ger').removeClass('ger');
        document.getElementById('UserSelectDirec').innerHTML = '';
    }
    else if(parent == 3){
        user = $('#gerente').val();
        nameUser = $('#gerentename').val();
        $('#ger').addClass('ger');
        $('#ase').removeClass('ase');
        $('#coor').removeClass('coor');
        document.getElementById('UserSelectDirec').innerHTML = '';

    }else if(parent == 2){
        user = $('#subdirector').val();
        nameUser = $('#subdirectorname').val();
        $('#sub').addClass('sub');
        $('#ger').removeClass('ger');
        $('#ase').removeClass('ase');
        $('#coor').removeClass('coor');
        document.getElementById('UserSelectDirec').innerHTML = '<em>Al modificar el <b>Subdirector</b> Recuerda modificar también el <b>Regional</b> </em>';

    }else if(parent == 59){
        
        subdirector = $('#subdirector').val();
        var respuesta = 0;
        bandera59 = 1;
        $.ajax({
            url: general_base_url+'Incidencias/tieneRegional',
            data: {
                'usuario' : parseInt(subdirector)
            },
            dataType: 'json',
            method: 'POST',
            type: 'POST',
            success: function(data) {
                
                if( data != false ){


                    document.getElementById('UserSelect').innerHTML = '';
              
                    user = $('#regional').val();
                    nameUser = $('#regionalname').val();
                 
                    $('#regio').addClass('regio');
                    $('#sub').removeClass('sub');
                    $('#ger').removeClass('ger');
                    $('#ase').removeClass('ase');
                    $('#coor').removeClass('coor');
                    
                     $("#usuarioid3").append($('<option>').val(data[0].id_usuario).attr('data-value', data[0].id_usuario).text(data[0].name));
                     $("#usuarioid3").selectpicker("refresh");
                   }else {
                    $("#roles3").val('');
                    $("#roles3").selectpicker("refresh");
                    alerts.showNotification("top", "right", "El siguiente usuario no es necesario el regional", "warning");
                  
                    $("#usuarioid3").val('');
                    $("#usuarioid3").selectpicker('refresh');
          
                }
            }
        });
    }

    document.getElementById('UserSelect').innerHTML = '<em>Usuario a cambiar: <b>'+nameUser+'</b></em>';
 
    $('#usuarioid3 option').remove(); 
   if(bandera59 != 1){ // LLAVE DEL  BANDERA59

    $.post(general_base_url+'Incidencias/getUsuariosByrol/'+parent+'/'+user, function(data) {
      
        var len = data.length;
        for( var i = 0; i<len; i++){
            var id = data[i]['id_usuario'];
            var name = data[i]['name_user'];
            $("#usuarioid3").append($('<option>').val(id).attr('data-value', id).text(name));
        }

        if(len<=0){
            // $("#usuarioid3").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#usuarioid3").selectpicker('refresh');
    }, 'json');
    
   } // LLAVE DEL ELSE BANDERA59
});

$("#roles2").change(function() {
    var parent = $(this).val();
    $('#usuarioid2 option').remove(); 
  
    $.post(general_base_url+'Incidencias/getUsuariosRol3/'+parent, function(data) {
     
        var len = data.length;
        for( var i = 0; i<len; i++){
            var id = data[i]['id_usuario'];
            var name = data[i]['name_user'];
    
            $("#usuarioid2").append($('<option>').val(id).attr('data-value', id).text(name));
        }
        if(len<=0){
            $("#usuarioid2").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        
        $("#usuarioid2").selectpicker('refresh');
    }, 'json'); 
});

$("#rolesvc").change(function() {
    var parent = $(this).val();
    document.getElementById('UserSelectvc').innerHTML = '';
    $('#UserSlectvc').empty();
    let user =0;
    let nameUser='';
    let cuantos2 = $('#cuantos').val();
    if(cuantos2 == 1){
        if(parent == 7){
        user = $('#asesor').val();
        $('#ase').addClass('ase');
        $('#coor').removeClass('coor');
        $('#ger').removeClass('ger');

        nameUser = $('#asesorname').val();
    }
    else if(parent == 9){    
        user = $('#coordinador').val();
        nameUser = $('#coordinadorname').val();
        if($('#coordinador').val() == 0 || $('#coordinador').val() == null || $('#coordinador').val() == 'null'){
            nameUser='NO REGISTRADO';
            user = 0;
        }
        $('#coor').addClass('coor');
        $('#ase').removeClass('ase');
        $('#ger').removeClass('ger');

    }
    else if(parent == 3){
        user = $('#gerente').val();
        nameUser = $('#gerentename').val();
        $('#ger').addClass('ger');
        $('#ase').removeClass('ase');
        $('#coor').removeClass('coor');
    }
    document.getElementById('UserSelectvc').innerHTML = '<em>Usuario a cambiar: <b>'+nameUser+'</b></em>';
    }
    else if(cuantos2 == 2){
        let id_vc = $('#id_vc').val();
        let id_vc2 = $('#id_vc2').val();
        if(parent == 7){
            user = ''+$('#asesor').val()+','+$('#asesor2').val();
            let ase1 = $('#asesorname').val();
            let ase2 = $('#asesorname2').val();
            let idAsesor1 = $('#asesor').val();
            let idAsesor2 = $('#asesor2').val();

            $('#ase').addClass('ase');
            $('#coor').removeClass('coor');
            $('#ger').removeClass('ger');

            $('#UserSelectvc').append(`<div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="asesorSelectVc" id="asesorSelectVc" value="${idAsesor1+','+id_vc}">
                <label class="form-check-label" for="inlineRadio1">${ase1}</label>
                </div>
                <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="asesorSelectVc" id="asesorSelectVc" value="${idAsesor2+','+id_vc2}">
                <label class="form-check-label" for="inlineRadio2">${ase2}</label>
                </div>`);
        }
        else if(parent == 9){
            user = $('#coordinador').val();
            nameUser = $('#coordinadorname').val();
            if($('#coordinador').val() == 0 || $('#coordinador').val() == null || $('#coordinador').val() == 'null'){
                nameUser='NO REGISTRADO';
                user = 0;
            }
            $('#coor').addClass('coor');
            $('#ase').removeClass('ase');
            $('#ger').removeClass('ger');
        }
        else if(parent == 3){
            user = ''+$('#gerente').val()+','+$('#gerente2').val();
            nameUser = $('#gerentename').val();
            let ger1 = $('#gerentename').val();
            let ger2 = $('#gerentename2').val();

            $('#ger').addClass('ger');
            $('#ase').removeClass('ase');
            $('#coor').removeClass('coor');
            let idGerente1 = $('#gerente').val();
            let idGerente2 = $('#gerente2').val();
            $('#UserSelectvc').append(`
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="GerenteSelectVc" id="GerenteSelectVc" value="${idGerente1+','+id_vc}">
            <label class="form-check-label" for="inlineRadio1">${ger1}</label>
            </div>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="GerenteSelectVc" id="GerenteSelectVc" value="${idGerente2+','+id_vc2}">
            <label class="form-check-label" for="inlineRadio2">${ger2}</label>
            </div>
            `);
        }
    }

    $('#usuarioid4 option').remove(); 
    $.post(general_base_url+'Incidencias/getUsuariosByrol/'+parent+'/'+user, function(data) {
        
        var len = data.length;
        for( var i = 0; i<len; i++){
            var id = data[i]['id_usuario'];
            var name = data[i]['name_user'];
            $("#usuarioid4").append($('<option>').val(id).attr('data-value', id).text(name));
        }
        if(len<=0){
            $("#usuarioid4").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#usuarioid4").selectpicker('refresh');
    }, 'json'); 
});

function open_Modal(){
    $("#miModalCeder").modal();
}

/**-----------------------------INVENTARIO---------------------------------------- */
function cambiarUsuarioInven(idCliente,idLote,ase,coor,ger,asesor,coordinador,gerente){
    $("#miModalInventario .invent").html('');

    $('#miModalInventario .invent').append(`
    <input type="hidden" value="${ase}" id="asesor" name="asesor">
    <input type="hidden" value="${coor}" id="coordinador" name="coordinador">
    <input type="hidden" value="${ger}" id="gerente" name="gerente">
    <input type="hidden" value="${asesor}" id="asesorname" name="asesorname">
    <input type="hidden" value="${coordinador}" id="coordinadorname" name="coordinadorname">
    <input type="hidden" value="${gerente}" id="gerentename" name="gerentename">
    <input type="hidden" value="${idLote}" id="idLote" name="idLote" >
    <input type="hidden" value="${idCliente}" id="idCliente" name="idCliente">
    `);
    $("#miModalInventario").modal();
}
/**------------------------------------------------------------------------------- */

var getInfo1 = new Array(6);
var getInfo3 = new Array(6);
function replaceAll(text, busca, reemplaza) {
    while (text.toString().indexOf(busca) != -1)
        text = text.toString().replace(busca, reemplaza);
    return text;
}

function Regresar(i,por,colab,puesto,precioLote){
    $('#modal_avisos .modal-body').html('');
    $('#modal_avisos .modal-footer').html('');
    $('#modal_avisos .modal-header').html('');
    let total = parseFloat(precioLote * (por / 100));
    $('#modal_avisos .modal-header').append(`<h4 class="card-title text-center"><b>Revertir cambio</b></h4>`); 
    $('#modal_avisos .modal-body').append(`<h5>¿Seguro que desea regresar la comisión del  <b>${puesto} - ${colab}</b>?</h5>
    <em>El porcentaje anterior es de ${por} y su comisión total corresponde a <b style="color:green;">$${formatMoney(total)}</b>. </em>
    <br>
    <div class="row">
        <div class="col-md-12">
            <center>
            </center>
        </div>
    </div>`);
    $('#modal_avisos .modal-footer').append(`

    <button data-toggle="tooltip" data-placement="top"type="button" class="btn btn-danger btn-simple"  data-dismiss="modal" value="CANCELAR">
        CANCELAR
    </button>
    <button data-toggle="tooltip" data-placement="top"type="button" onclick="SaveAjusteRegre(${i},${por},${total})" 
        id="" class="btn btn-gral-data" style="background:#003d82;" value="GUARDAR">
        GUARDAR
    </button>    

    `);
    $('#modal_avisos').modal('show');
}

function SaveAjusteRegre(i,por,total){
    let id_comision = $('#id_comision_'+i).val();
    let id_usuario = $('#id_usuario_'+i).val();
    let id_lote = $('#idLote').val();
    let porcentaje = por; 
    let comision_total = total;
    let datos = {
        'id_comision':id_comision,
        'id_usuario':id_usuario,
        'id_lote':id_lote,
        'porcentaje':porcentaje,
        'comision_total':comision_total
    }
    var formData = new FormData;
    formData.append("id_comision", id_comision);
    formData.append("id_usuario", id_usuario);
    formData.append("id_lote", id_lote);
    formData.append("porcentaje", porcentaje);
    formData.append("comision_total", comision_total);
    $.ajax({
        url: general_base_url+'Incidencias/SaveAjuste/'+1,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        method: 'POST',
        type: 'POST', // For jQuery < 1.9
        success:function(response){
            $('#porcentaje_'+i).val(por);
            $('#comision_total_'+i).val(formatMoney(total));
            let btn = document.getElementById('btnTopar_'+i);
            btn.setAttribute('style','background:#f44336;');
            // document.getElementById('btnTopar_'+i).disabled = false;
            $("#btnTopar_"+i).show('slow'); 
           // document.getElementById('btn_'+i).disabled = false;
            $("#btn_"+i).show('slow'); 
            // document.getElementById('btnAdd_'+i).disabled = false;
            $("#btnAdd_"+i).show('slow'); 
            // document.getElementById('btnReload_'+i).disabled = true;
            $("#btnReload_"+i).hide(1500); 
            // document.getElementById('porcentaje_'+i).disabled = false;
            $('#modal_avisos .modal-body').html('');
            $('#modal_avisos').modal('toggle')
            alerts.showNotification("top", "right", "Modificación almancenada con éxito.", "success");
            setTimeout(function(){ 
                $('#modal_NEODATA .modal-body').html('');
                $('#modal_NEODATA').modal('toggle')
         
             } ,2000);             
        }
    });
}

function saveTipo(id){
    let tipo = $('#tipo_v').val();
    if(tipo == ''){
    }
    else{
        var formData = new FormData;
        formData.append("tipo", tipo);
        formData.append("id", id);
        $.ajax({
            url: general_base_url+'Incidencias/saveTipoVenta',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success:function(data){
                if(data == 1){                
                    $("#modal_tipo_venta").modal('toggle');
                    $('#tabla_inventario_contraloria').DataTable().ajax.reload();
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "Tipo de venta actualizado", "success");
                }
                else{
                    $('#modal_tipo_venta .modal-body').html('');
                    $("#modal_tipo_venta").modal('toggle');
                    $('#tabla_inventario_contraloria').DataTable().ajax.reload();
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "Algo salio mal", "danger");
                }
            }
        });
    }
}

function updateVentaC(id, idLote, idCliente){
    $('#darBajaVenta').prop('disabled', true);
    
    var formData = new FormData;
    formData.append("id", id);
    formData.append("idLote", idLote);
    formData.append("idCliente", idCliente)
    $.ajax({
        url: general_base_url+'Incidencias/updateVentaCompartida',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        method: 'POST',
        type: 'POST', // For jQuery < 1.9
        success:function(data){
            if(data == 1){
                $('#modalBajaVcUpdate .modal-body').html('');
                $("#modalBajaVcUpdate").modal('toggle');
                $('#modalBajaVc .modal-body').html('');
                $("#modalBajaVc").modal('toggle');
                $("#modal_NEODATA").modal('hide');
                $('#tabla_inventario_contraloria').DataTable().ajax.reload();
                $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "Se han realizado los cambios con éxito", "success");
            }
            else{
                $('#modalBajaVcUpdate .modal-body').html('');
                $("#modalBajaVcUpdate").modal('toggle');
                $("#modal_NEODATA").modal('toggle');
                $('#tabla_inventario_contraloria').DataTable().ajax.reload();
                $('#spiner-loader').addClass('hidden');
                alerts.showNotification("top", "right", "Algo salio mal", "danger");
            }
        }
    });
}

function SaveAjuste(i){
    $('#spiner-loader').removeClass('hidden');
    $('#btn_'+i).removeClass('btn-success');
    $('#btn_'+i).addClass('btn-default');

    let id_comision = $('#id_comision_'+i).val();
    let id_usuario = $('#id_usuario_'+i).val();
    let id_lote = $('#idLote').val();
    let porcentaje = $('#porcentaje_'+i).val();
    let comision_total = $('#comision_total_'+i).val();

    var formData = new FormData;
    formData.append("id_comision", id_comision);
    formData.append("id_usuario", id_usuario);
    formData.append("id_lote", id_lote);
    formData.append("porcentaje", porcentaje);
    formData.append("comision_total", comision_total);
    $.ajax({
        url: general_base_url+'Incidencias/SaveAjuste',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        method: 'POST',
        type: 'POST', // For jQuery < 1.9
        success:function(response){
            $('#spiner-loader').addClass('hidden');
            alerts.showNotification("top", "right", "Modificación almancenada con éxito.", "success");
        }
    });
}

$('#filtro44').change(function(ruta){
    conodominio = $('#filtro44').val();
    $("#filtro55").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url+'Incidencias/lista_lote/'+conodominio,
        type: 'post',
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++){
                var id = response[i]['idLote'];
                var name = response[i]['nombreLote'];
                var totalneto2 = response[i]['totalNeto2'];
                $("#filtro55").append($('<option>').val(id+','+totalneto2).text(name));
            }
            $("#filtro55").selectpicker('refresh');
        }
    });
});

$('#filtro55').change(function(ruta){
    infolote = $('#filtro55').val();
    datos = infolote.split(',');
    idLote = datos[0];
    $.post(general_base_url+"Incidencias/getComisionesLoteSelected/"+idLote, function (data) {
        if( data.length < 1){
            document.getElementById('msj').innerHTML = '';
            document.getElementById('btn-aceptar').disabled  = false;
            var select = document.getElementById("filtro55");
            var selected = select.options[select.selectedIndex].text;
            let beforelote = $('#natahidden').val();
                
            document.getElementById('nota').innerHTML = 'Se reubicará el lote <b>'+beforelote+'</b> a <b>'+selected+'</b>, una vez aplicado el cambio no se podrá revertir este ajuste';
            $('#comentarioR').val('Se reubicará el lote '+beforelote+' a '+selected+', una vez aplicado el cambio no se podrá revertir este ajuste');
        }
        else{
            document.getElementById('btn-aceptar').disabled  = true;
            document.getElementById('msj').innerHTML = 'El lote seleccionado tiene comisiones registradas.';
        }    
    }, 'json');
});

let titulos = [];
function onKeyUp(event) {
    var keycode = event.keyCode;
        
    if(keycode == '13'){ 
        $('.find_doc').click();
    }
}

let titulos_incidencias = [];
$('#tabla_inventario_contraloria thead tr:eq(0) th').each( function (i) {
    $(this).css('text-align', 'center');
    var title = $(this).text();
    titulos_incidencias.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_inventario_contraloria').DataTable().column(i).search() !== this.value ) {
                $('#tabla_inventario_contraloria').DataTable().column(i).search(this.value).draw();
            }
            var index = $('#tabla_inventario_contraloria').DataTable().rows({
            selected: true,
            search: 'applied'
        }).indexes();
        var data = $('#tabla_inventario_contraloria').DataTable().rows(index).data();
    });
    

});
 
$(".find_doc").click( function() {
    var idLote = $('#inp_lote').val();
    
   if(idLote != ''){

    $('#tabla_inventario_contraloria').show();

    tabla_inventario = $("#tabla_inventario_contraloria").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: 'auto',
        buttons: [],
        ajax:{
            "url": general_base_url+'Incidencias/getInCommissions/'+idLote,
            "dataSrc": ""
        },
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            emptyTable:"No hay datos",
            url: general_base_url+"/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        scrollX: true,
        destroy: true,
        ordering: false,
        columns: [ 
        {data: 'nombreResidencial'},
        {data: 'nombreCondominio'},
        {data: 'nombreLote'},
        {data: 'idLote'}, 
        {data: 'nombre_cliente'}, 
        {data: function( d ){
                var lblType;
                if(d.tipo_venta==1) {
                    lblType ='<span class="label label-danger" style="color:#78281F;background:#F5B7B1;">Venta Particular</span>';
                }
                else if(d.tipo_venta==2) {
                    lblType ='<span class="label lbl-green" style="background:#ABEBC6;">Venta normal</span>';
                }
                else{
                    lblType ='<span class="label lbl-green">SIN TIPO Venta</span>';
                }
                return lblType;
            }
        }, 
        { data: function (d) {
            var labelCompartida;
            if(d.compartida == null) {
                labelCompartida ='<span class="label lbl-yellow">Individual</span>';
            } else{
                labelCompartida ='<span class="label lbl-orangeYellow">Compartida</span>';
            }
            return labelCompartida;
        }},
        { data: function (d) {
            var labelStatus;
            if(d.idStatusContratacion == 15) {
                labelStatus ='<span class="label lbl-violetBoots">Contratado</span>';
            }else {
                labelStatus ='<span class="m-0"><b>'+d.idStatusContratacion+'</b></span>';
            }
            return labelStatus;
        }},
        // 
        {data: function (d) {
            var labelEstatus;
            if([64,65,66,84,85,86].indexOf(d.plan_comision) >= 0){
                banderaPermisos = 0;
            }
            let textoReubicacion = [64,65,66].indexOf(d.plan_comision) >= 0 ? ' (Anterior)' :( [84,85,86].indexOf(d.plan_comision) >= 0 ? ' (Nuevo)' : '' );
            if(d.totalNeto2 == null) {
                labelEstatus ='<label class="label lbl-azure btn-dataTable" data-toggle="tooltip" data-placement="top" style="cursor: pointer;"><span><b>Sin Precio Lote</b></span></label>';
            }else if(d.registro_comision == 2){
                labelEstatus ='<span class="label lbl-cerulean">SOLICITADO MKT</span>'+' '+d.plan_descripcion;
            }else {
                labelEstatus =`<label class="label lbl-azure btn-dataTable" data-toggle="tooltip"  data-placement="top"><b>${d.plan_descripcion} ${textoReubicacion}</b></label>`;
            }
            return labelEstatus;
        }},
        { data: function (d) {
            var fechaSistema;
            if(d.fecha_sistema <= '01 OCT 20' || d.fecha_sistema == null ) {
                //fechaSistema ='<span class="label" style="color:#626567;background:#E5E7E9;">Sin Definir</span>';
                fechaSistema =`<label class="label lbl-azure btn-dataTable" data-toggle="tooltip" data-placement="top"><b><span onclick="showDetailModal(${d.plan_comision})" style="cursor: pointer;">Sin Definir</span></label>`;

            }else {
                //fechaSistema = '<br><span class="label" style="color:#1B4F72;background:#AED6F1;">'+d.fecha_sistema+'</span>';
                fechaSistema =`<label class="label lbl-azure btn-dataTable" data-toggle="tooltip" data-placement="top"><b><span onclick="showDetailModal(${d.fecha_sistema})" style="cursor: pointer;">${d.fecha_sistema}</span></label>`;
            }
            return fechaSistema;
        }},
        { data: function (d) {
            var fechaNeodata;
            var rescisionLote;
            fechaNeodata = '<br><span class="label" style="color:#1B4F72;background:#AED6F1;">'+d.fecha_neodata+'</span>';
            rescisionLote = '';
            if(d.fecha_neodata <= '01 OCT 20' || d.fecha_neodata == null ) {
                fechaNeodata =`<label class="label lbl-azure btn-dataTable" data-toggle="tooltip" data-placement="top"><b><span style="cursor: pointer;">Sin Definir</span></label>`;
            } 
            if (d.registro_comision == 8){
                rescisionLote = '<br><span class="label" style="color:#78281F;background:#F5B7B1;">Recisión Nueva Venta</span>';
            }
            return fechaNeodata+rescisionLote;
        }},
        // 
        
        {
            "width": "8%",
            "data": function( d ){
                var lblStats;
                if(d.totalNeto2==null) {
                        lblStats ='<span class="label lbl-warning">Sin precio lote</span>';
                }
                else {
                    switch(d.lugar_prospeccion){
                        case '6':
                            lblStats ='<label class="label " style="color:#E5E7E9;background:#B4A269;">MARKETING DIGÍTAL</span>';
                        break;
                        case '12':
                            lblStats ='<label class="label " style="background:#00548C;">CLUB MADERAS</span>';
                        break;
                        case '25':
                            lblStats ='<label class="label " style="background:#0860BA;">IGNACIO GREENHAM</span>';
                        break;
                        case '26':
                            lblStats ='<label class="label " style="background:#0860BA;">COREANO VLOGS</span>';
                        break;
                        default:
                            lblStats ='';
                        break;
                    }
                }

                return lblStats;
            }
        },
        {
            "width": "8%",
            "data": function( d ){
                var lblStats = '';
                switch(d.registro_comision){
                    case '7':
                        lblStats ='<span class="label lbl-warning" style="background:red;" >LIQUIDADA</span>';
                    break;
                    
                    case '1':
                        lblStats ='<span class="label lbl-sky">COMISIÓN ACTIVA</span>';
                    break;
                    case '8':
                        lblStats ='<span class="label lbl-blueMaderas" style="color:#0860BA;">NUEVA, rescisión</span>';
                    break;

                    case '0':
                        lblStats ='<span class="label lbl-blueMaderas" style="color:#0860BA;">NUEVA, sin dispersar</span>';
                    break;

                    default:
                        lblStats ='';
                    break;
                }
                return lblStats;      
            }
        },
        { 
            "width": "20%",
            "orderable": false,
            "data": function( data ){
                $('[data-toggle="tooltip"]').tooltip();

                var saberCompartida = data.compartida == null ? 0 : 1;

                var BtnStats ='';
                if(data.totalNeto2==null && data.idStatusContratacion > 8 ) {
                    // if(data.tipo_venta == 'null' || data.tipo_venta == 0  || data.tipo_venta == null){
                        // BtnStats += '<button data-toggle="tooltip" data-placement="top" href="#" value="'+data.idLote+'" data-nombre="'+data.nombreLote+'" data-tipo="'+data.tipo+'" data-tipo="I" class="btn-data btn-orangeYellow tipo_venta" title="Cambiar tipo de venta"><i class="fas fa-map-marker-alt"></i></button>';
                    // }
                  
                }
                else {
                    if(data.registro_comision == 0 || data.registro_comision == 8) {
                        BtnStats += '<button data-toggle="tooltip" data-placement="top"href="#" value="'+data.idLote+'" data-idLote="'+data.idLote+'"  data-cliente="'+data.id_cliente+'" data-sedesName="'+data.nombre+'"  data-sedes="'+data.id_sede+'" data-nombre="'+data.nombreLote+'" data-tipo="'+data.tipo+'" data-tipo="1" class="btn-data btn-violetDeep cambioSede"  title="Cambio de sede"> <i class="fas fa-map-signs"></i> </button>';
                        if(data.tipo_venta == 'null' || data.tipo_venta == 0 || data.tipo_venta == null){
                            BtnStats += '<button data-toggle="tooltip" data-placement="top"href="#" value="'+data.idLote+'" data-nombre="'+data.nombreLote+'" data-tipo="'+data.tipo+'" data-tipo="I" class="btn-data btn-orangeYellow tipo_venta" title="Cambiar tipo de venta"><i class="fas fa-map-marker-alt"></i></button>';
                        }         
                    }
                    else if(data.registro_comision == 7 ) {
                        BtnStats = '<button data-toggle="tooltip" data-placement="top"class="btn-data btn-orangeYellow update_bandera" title="Cambiar estatus" value="' + data.idLote +'" data-nombre="'+data.nombreLote+'"><i class="fas fa-sync-alt"></i></button>';
                    }

                    else if(data.registro_comision == 1 ) {
                        
                       // BtnStats += '<button data-toggle="tooltip" data-placement="top"class="btn-data btn-green mensualidadTipo" title="Cambiar Mensualidad" value="' + data.idLote +'" data-registro="'+data.registro_comision+'" data-cliente="'+data.id_cliente+'" data-mensualidad="'+data.opcion+'"><i class="fas fa-cog"></i></button>';
                    }

                    else {
                       
                    
                    }

                    BtnStats += '<button data-toggle="tooltip" data-placement="top"class="btn-data btn-green inventario"  title="Cambiar usuarios" value="' + data.idLote +'" data-registro="'+data.registro_comision+'" data-cliente="'+data.id_cliente+'" data-precioAnt="'+data.totalNeto2+'" data-proceso="'+data.proceso+'" data-ventaCompartida="'+saberCompartida+'"><i class="fas fa-user-edit"></i></button>';
                }
                if(usuario_id_contraloria== 2807){
                    BtnStats += '<button data-toggle="tooltip" data-placement="top" href="#" value="'+data.idLote+'" data-nombre="'+data.nombreLote+'" data-tipo="'+data.tipo+'" data-tipo="I" class="btn-data btn-orangeYellow tipo_venta" title="Cambiar tipo de venta"><i class="fas fa-map-marker-alt"></i></button>';

                }

                BtnStats += data.registro_comision != 1 ? '' : `<button data-toggle="tooltip" data-placement="top"href="#" value="${data.idLote}" data-estatus="${data.idStatusContratacion}" data-tipo="I" data-precioAnt="${data.totalNeto2}"  data-value="${data.registro_comision}" data-cliente="${data.id_cliente}" data-lote="${data.idLote}" data-code="${data.cbbtton}" class="btn-data btn-gray verify_neodata" title="Ajustes"><i class="fas fa-wrench"></i></button>`;

               // BtnStats += data.estatus == 1 ? `<button data-toggle="tooltip" data-placement="top"data-lote="${data.idLote}" data-cliente="${data.id_cliente}" data-precioLote ="${data.totalNeto2}" class=" btn-data btn-sky agregar_usuario"  title="Agregar usuario" ><i class="fas fa-user-plus"></i></button>` : '';

                //BtnStats += (data.idStatusContratacion >= 9 && [64,65,66,84,85,86].indexOf(data.plan_comision) < 0) ? `<button data-toggle="tooltip" data-placement="top"data-estatus="${data.estatus}" data-idCliente="${data.id_cliente}" class=" btn-data btn-yellow cambiar_plan_comision"  title="Cambiar plan de comisión"><i class="fas fa-chart-bar"></i></button>` : '';
                BtnStats +=  (data.registro_comision == 0 || data.registro_comision == 8) && data.compartida !== null ? `<button data-toggle="tooltip" data-placement="top" value="${data.idLote}" data-lote="${data.idLote}" title="Baja venta compartida" data-cliente="${data.id_cliente}" class=" btn-data btn-warning bajaVentaC"><i class="fas fa-trash"></i></button>`:'';
                BtnStats += `<button class="btn-data btn-sky cambiar_precio" title="Cambiar precio" data-planComision="${data.plan_comision}" value="${data.idLote}" data-precioAnt="${data.totalNeto2}"><i class="fas fa-pencil-alt"></i></button>`;
                BtnStats += [64,65,66,84,85,86].indexOf(data.plan_comision) >= 0 ? '' : `<button class="btn-data btn-blueMaderas addEmpresa"  title="Agregar empresa" value="${data.idLote }" data-registro="${data.registro_comision}" data-cliente="${data.id_cliente}" data-precioAnt="${data.totalNeto2}"><i class="fas fa-building"></i></button>`;

                return '<div class="d-flex justify-center">'+BtnStats+'</div>';
            }
        }]
    });
   }



   $("#tabla_inventario_contraloria tbody").on("click", ".cambiar_precio", function(){
    var tr = $(this).closest('tr');
    var row = tabla_inventario.row( tr );
    idLote = $(this).val();
    precioAnt = $(this).attr("data-precioAnt");
    plan_comision = $(this).attr("data-planComision");
    if(precioAnt == 'null'){
        precioAnt=0;
    }
    $("#modal_pagadas .modal-body").html("");
    $("#modal_pagadas .modal-footer").html("");

    $("#modal_pagadas .modal-body").append('<h4 class="modal-title">Cambiar precio del lote <b>'+row.data().nombreLote+'</b></h4><br><em>Precio actual: $<b>'+formatMoney(precioAnt)+'</b></em>');
    $("#modal_pagadas .modal-body").append(`<input type="hidden" name="idLote" id="idLote" readonly="true" value="${idLote}"><input type="hidden" name="precioAnt" id="precioAnt" readonly="true" value="${precioAnt}"><input type="hidden" name="plan_comision" id="plan_comision" readonly="true" value="${plan_comision}">`);
    $("#modal_pagadas .modal-body").append(`<div class="form-group">
    <label class="control-label" >Nuevo precio</label>
    <input type="text" name="precioL" onblur="verificar(${precioAnt})" required id="precioL" class="form-control input-gral">
    <p id="msj" style="color:red;"></p>
    </div>`);

    $("#modal_pagadas .modal-footer").append(`
      
        <button type="button" class="btn btn-danger btn-simple"  data-dismiss="modal" value="CANCELAR"> CANCELAR</button>
        <button type="submit" disabled id="btn-save" class="btn btn-gral-data" value="GUARDAR">GUARDAR</button>
        `);
    $("#modal_pagadas").modal();
});

    
    $("#tabla_inventario_contraloria tbody").on("click", ".tipo_venta", function(){
        var tr = $(this).closest('tr');
        var row = tabla_inventario.row( tr );
        idLote = $(this).val();
        tipo = $(this).attr("data-tipo");

        $("#modal_tipo_venta .modal-header").html("");
        $("#modal_tipo_venta .modal-footer").html("");
        $("#modal_tipo_venta .modal-header").append(`<button type="button" class="close" aria-hidden="true" data-dismiss="modal" style="margin-top: -10px;"><i class="material-icons">clear</i></button>`);
        $("#modal_tipo_venta .modal-header").append(`<p class="modal-title">El lote <b>${row.data().nombreLote}</b>, tiene un tipo de venta actual "<b>${ (tipo == 'null' || tipo == 'undefined') ? 'Sin tipo de venta' : tipo }</b>". Seleccione el nuevo tipo de venta en caso de querer modificarlo.</p>`);
        $("#modal_tipo_venta .modal-header").append(`<input type="hidden" name="idLote" id="idLote" readonly="true" value="${idLote}"><input type="hidden" name="precioAnt" id="precioAnt" readonly="true" value="">`);

        $("#modal_tipo_venta .modal-footer").append( ` 
            <div class="col-md-12">
                <button data-toggle="tooltip" data-placement="top"type="button" class="btn btn-danger btn-simple"  data-dismiss="modal" >
                CANCELAR
                </button>
                <button data-toggle="tooltip" data-placement="top"type="button" onclick="saveTipo(${idLote})" class="btn btn-gral-data" >
                GUARDAR
                </button> 
            </div>`);
        $("#modal_tipo_venta").modal();
    });

    $("#tabla_inventario_contraloria tbody").on("click", ".cambiar_plan_comision", function(e){

        e.preventDefault();
        e.stopImmediatePropagation();
        var tr = $(this).closest('tr');
        var row = tabla_inventario.row( tr );
        idCliente = $(this).attr("data-idCliente");
        estatus = $(this).attr("data-estatus");

        if(parseInt(estatus) === 1){
            alerts.showNotification("top", "right", "Este lote ya fue dispersado, revisalo con TI", "danger");
        }else{
            $('#cliente').val(idCliente);
            $("#titulos").html("");
            $("#titulos").html(` <h4 class="modal-title">Cambiar plan de comisión del lote <b>${row.data().nombreLote}</b></h4><br><em>Plan de comisión actual: <b>${row.data().plan_descripcion}</b> </em>`);
    
            $("#modal_comision").modal();
        }
   
    });

    $("#form_comision").on('submit', function(e){
        $('#boton').prop('disabled', true);
        e.preventDefault();
        e.stopImmediatePropagation();
        $.ajax({
            type: 'POST',
            url: general_base_url+'Incidencias/updatePlanComision',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'JSON',
            success: function(data) {
            
                if (data == 1) {
                    $('#modal_comision').modal("hide");
                    $("#cliente").val("");
                    alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                    $('#tabla_inventario_contraloria').DataTable().ajax.reload();
                    $('#boton').removeAttr('disabled');
                } else {
                    alerts.showNotification("top", "right", "Oops, algo salió mal. Error al intentar actualizar.", "warning");
                }
            },
            error: function(){
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });

    $("#tabla_inventario_contraloria tbody").on("click", ".agregar_usuario", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();

        $("#btn_add_user").prop('disabled',false);

        $('#agregar_usuario').html('');
        $('#agregar_usuario').val('default');
        $("#agregar_usuario").selectpicker("refresh");

        $('#agregar_roles').html('');
        $('#agregar_roles').val('default');
        $("#agregar_roles").selectpicker("refresh");

        $('#porcentaje').val('');

        document.getElementById("lotes1").value = (idLote);
        id_cliente = $(this).attr("data-cliente");
        document.getElementById("clientes2").value = (id_cliente);

        precioLote = $(this).attr("data-precioLote");
        document.getElementById("precioLote").value = (precioLote);
                    
        var len2 = listaUsuarios.length;
        for( var i2 = 0; i2<len2; i2++){
            var id_opcion = listaUsuarios[i2]['id_usuario'];
            var descripcion = listaUsuarios[i2]['name_user'];
                
            $("#agregar_usuario").append($('<option>').val(id_opcion).attr('data-value',id_opcion ).text(id_opcion+ "- "+ descripcion));
        }
        
        $("#agregar_usuario").selectpicker('refresh');
               
        $('#agregar_usuario').change(function(){
            $('#agregar_roles').html('');

            var len2 = catalogo2.length;
            var i2
            var idSeleccionado = $('#agregar_usuario').val();
                
            i2 = idSeleccionado == 2 ? 0: 1;

            for( i2 ; i2<len2; i2++){
                var id_opcion = catalogo2[i2]['id_opcion'];
                var descripcion = catalogo2[i2]['nombre'];
                    
                $("#agregar_roles").append($('<option>').val(id_opcion).attr('data-value',id_opcion ).text(descripcion));
                    
            }
            $("#agregar_roles").selectpicker('refresh');
        }); 

        $("#modal_add_user").modal();
   
    });

    $("#form_add_users").on('submit', function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        $("#btn_add_user").prop('disabled',true);
        id_cliente= document.getElementById("clientes2").value;
        idLote= document.getElementById("lotes1").value;
        precioLote = document.getElementById("precioLote").value;
    
        var id_usuario = $('#agregar_usuario').val();
        var id_rol = $('#agregar_roles').val();
        var porcentaje = $('#porcentaje').val();
    
        var updateUsuario = new FormData();

        updateUsuario.append("idLote", idLote);
        updateUsuario.append("id_cliente",id_cliente);
        updateUsuario.append("porcentaje",porcentaje);
        updateUsuario.append("id_rol", id_rol);
        updateUsuario.append("id_usuario", id_usuario);
        updateUsuario.append("precioLote",precioLote);

        $.ajax({
            type: 'POST',
            url: general_base_url+'Incidencias/updateUser',
            data: updateUsuario,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'JSON',
            success: function(data) {
            
                if (data == 1) {
                    $('#modal_add_user').modal("hide");
                    alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                    $('#tabla_inventario_contraloria').DataTable().ajax.reload();
                } if(data == 0){
                    alerts.showNotification("top", "right", "Usuario duplicado, realiza otro registro.", "warning");
                    $('#modal_add_user').modal("hide");
                }
            },
            error: function(){
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });


/**--------------------------AGREGAR EMPRESA---------------------------- */
$("#tabla_inventario_contraloria tbody").on("click", ".addEmpresa", function(e){
    e.preventDefault();
    e.stopImmediatePropagation();
    var tr = $(this).closest('tr');
    var row = tabla_inventario.row( tr );
    idLote = $(this).val();
    $('#idLoteE').val(idLote);
    id_cliente = $(this).attr("data-cliente");
    precioAnt = $(this).attr("data-precioAnt");
    $('#idClienteE').val(id_cliente);
    $('#PrecioLoteE').val(precioAnt);
    $("#addEmpresa").modal();
           
}); 
$("#form_empresa").on('submit', function(e){ 
    e.preventDefault();
    e.stopImmediatePropagation();
   document.getElementById('btn_add').disabled=true;

   let formData = new FormData(document.getElementById("form_empresa"));
   $.ajax({
       url: 'Incidencias/AddEmpresa',
       data: formData,
       method: 'POST',
       contentType: false,
       cache: false,
       processData:false,
       success: function(data) {
           console.log(data);
           if (data == 1) {
               $('#form_empresa')[0].reset();
               $('#tabla_inventario_contraloria').DataTable().ajax.reload();

               $('#addEmpresa').modal('toggle');
               alerts.showNotification("top", "right", "El registro se guardo correctamente.", "success");
               document.getElementById('btn_add').disabled=false;

           }if (data == 2) {
               $('#form_empresa')[0].reset();
               $('#tabla_inventario_contraloria').DataTable().ajax.reload();

               $('#addEmpresa').modal('toggle');
               alerts.showNotification("top", "right", "EMPRESA YA SE ENCUENTRA REGISTRADA.", "warning");
               document.getElementById('btn_add').disabled=false;

           } else if (data == 0){
               alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
               $('#addEmpresa').modal('toggle');
               document.getElementById('btn_add').disabled=false;
               $('#form_empresa')[0].reset();

           }
       },
       error: function(){
           $('#form_empresa')[0].reset();
           $('#addEmpresa').modal('toggle');
           document.getElementById('btn_add').disabled=false;
           $('#addEmpresa').modal('hide');
           alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
       }
   });
});
/**--------------------------------------------------------------------- */

    /**-------------------INVENTARIO------------------------------- */
    $("#tabla_inventario_contraloria tbody").on("click", ".inventario", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
 
     
        $('#opcion').val('default');
        $("#opcion").selectpicker("refresh");

        var tr = $(this).closest('tr');
        var row = tabla_inventario.row( tr );
        idLote = $(this).val();
        let cadena = '';
        id_cliente = $(this).attr("data-cliente");
        precioAnt = $(this).attr("data-precioAnt");
        registro_comision = $(this).attr('data-registro');
        proceso =$(this).attr('data-proceso');
        ventaCompartida = $(this).attr("data-ventaCompartida");

        if(registro_comision == 0){
            // $("#modal_inventario .seleccionar").html('');
            $('#modal_inventario .seleccionar').append(`
                <h4><em>El lote seleccionado aún no está comisionando</em></h4>`);
            $("#modal_inventario").modal();
        }
        else{ 
            document.getElementById("lotes1").value = (idLote);
            document.getElementById("clientes2").value = (id_cliente);
            document.getElementById("proceso").value = (proceso);
            document.getElementById("ventaCompartida").value = (ventaCompartida);
            $("#modal_avisitos").modal();
        }                      
    }); 

    $(document).on("click", ".mensualidadTipo", function(e) {
        e.preventDefault(); 
    
        var idLote = $(this).val();
        var idCliente = $(this).attr("data-cliente");
        var mensualidadT = $(this).attr("data-mensualidad");
    
        $("#idLote").val(idLote);
        $("#idCliente").val(idCliente);
    
        $("#mensualidad9").val(mensualidadT);
        $("#mensualidad9").selectpicker("refresh");
    
        var mensualidadNombre = '';
        for (let i = 0; i < mensualidad.length; i++) {
            if (mensualidad[i]['id_opcion'] == mensualidadT) {
                mensualidadNombre = mensualidad[i]['nombre'];
                break;
            }
        }
    
        $("#mensualidad_anterior").text(mensualidadNombre);
    
        $("#modal_mensualidades").modal();
    });
    
    $("#modal_mensualidades_form").on("submit", function(e) {
        e.preventDefault();
        
        var idCliente = $("#idCliente").val();
        var idLote = $("#idLote").val();
        var id_usuario = $("#id_usuario").val();
        var tipoMensualidad = $("#mensualidad9").val();

        var dataAnticipo = new FormData();
    
        dataAnticipo.append("idCliente", idCliente);
        dataAnticipo.append("idLote", idLote);
        dataAnticipo.append("id_usuario", id_usuario);
        dataAnticipo.append("tipoMensualidad", tipoMensualidad);
    
        $.ajax({
            url: general_base_url + 'Incidencias/updateMensualidades',
            data: dataAnticipo,
            type: 'POST',
            contentType: false,
            cache: false,
            processData:false,
            success: function(data) {
                if (data == 1) {
                    $('#modal_mensualidades').modal("hide");
                    alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                    $('#tabla_inventario_contraloria').DataTable().ajax.reload();
                } else {
                    alerts.showNotification("top", "right", "Oops, algo salió mal. Error al intentar actualizar.", "warning");
                }
            },
            error: function() {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });

    $("#tabla_inventario_contraloria tbody").on("click", ".verify_neodata", function(e){
        $('#spiner-loader').removeClass('hide');
        e.preventDefault();
        e.stopImmediatePropagation();
        var tr = $(this).closest('tr');
        var row = tabla_inventario.row( tr );
        idLote = $(this).val();
        let cadena = '';
        registro_status = $(this).attr("data-value");
        id_estatus = $(this).attr("data-estatus");
        precioAnt = $(this).attr("data-precioAnt");
        tipo = $(this).attr('data-tipo');
        planComision = $(this).attr('data-planComision');

        cliente = $(this).attr("data-cliente");
        lote = $(this).attr("data-lote");
 
        $("#modal_NEODATA .modal-header").html("");
        $("#modal_NEODATA .modal-body").html("");
        $("#modal_NEODATA .modal-footer").html("");

        $.getJSON( general_base_url + "ComisionesNeo/getStatusNeodata/"+idLote).done( function( data ){
            if(data.length > 0){
                switch (data[0].Marca) {
                    case 0:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>En espera de próximo abono en NEODATA de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        $('#spiner-loader').addClass('hide');
                    break;
                    case 1:
                        if(registro_status==0 || registro_status==8){//COMISION NUEVA
                        $('#spiner-loader').addClass('hide');
                        }
                        else if(registro_status==1){
                            $.getJSON( general_base_url + "Incidencias/getDatosAbonadoSuma11/"+idLote).done( function( data1 ){
                                let total0 = parseFloat((data[0].Aplicado));
                                let total = 0;

                                if(total0 > 0){
                                    total = total0;
                                }else{
                                    total = 0; 
                                }

                                var counts=0;
                                /*<div class="col-md-6">Aplicado: '+formatMoney(total0)+'</div>*/ 
                                $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-6"><h4><b>Precio lote: $'+formatMoney(data1[0].totalNeto2)+'</b></h4></div><div class="col-md-6">Aplicado: '+formatMoney(total0)+'</div></div>');
                                if(parseFloat(data[0].Bonificado) > 0){
                                    cadena = '<h4>Bonificación: <b style="color:#D84B16;">$'+formatMoney(data[0].Bonificado)+'</b></h4>';
                                }
                                else{
                                    cadena = '<h4>Bonificación: <b >$'+formatMoney(0)+'</b></h4>';
                                }

                                $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i> <i>'+row.data().nombreLote+'</i></b></h3></div></div><br>');
                                $.getJSON( general_base_url + "Incidencias/getDatosAbonadoDispersion/"+idLote+"/"+1).done( function( data ){
                                    $('#spiner-loader').addClass('hide');
                                    
                                    $("#modal_NEODATA .modal-body").append(` <div class="row"><div class="col-md-2"><p style="font-zise:10px;"><b>USUARIOS</b></p></div><div class="col-md-1"><b>%</b></div><div class="col-md-2"><b>TOT. COMISIÓN</b></div><div class="col-md-2"><b><b>ABONADO</b></div><div class="col-md-2"><b>PENDIENTE</b></div><div class="col-md-3">ACCIONES</div></div>`);
                                    let contador=0;
                                        
                                    for (let index = 0; index < data.length; index++) {
                                        const element = data[index].id_usuario;
                                        if(data[index].id_usuario == 4415){
                                            contador +=1;
                                        }
                                    }

                                    $.each( data, function( i, v){
                                        $('#btn_'+i).tooltip({ boundary: 'window' })
                                        let nuevosaldo = 0;
                                        let nuevoabono=0;
                                        let evaluar =0;
                                        if(tipo == "I"){
                                            saldo =0;                           
                                            if(v.rol_generado == 7 && v.id_usuario == 4415){
                                                saldo = (( (v.porcentaje_saldos/2) /100)*(total));
                                                contador +=1;
                                            }else if(v.rol_generado == 7 && contador > 0){
                                                saldo = (( (v.porcentaje_saldos/2) /100)*(total));
                                            }else if(v.rol_generado == 7 && contador == 0){
                                                saldo = ((v.porcentaje_saldos /100)*(total));
                                            }else if(v.rol_generado != 7){
                                                saldo = ((v.porcentaje_saldos /100)*(total));
                                            }

                                            if(v.abono_pagado>0){
                                                evaluar = (v.comision_total-v.abono_pagado);
                                                if(evaluar<1){
                                                    pending = 0;
                                                    saldo = 0;
                                                }else{
                                                    pending = evaluar;
                                                }

                                                resta_1 = saldo-v.abono_pagado;
                                                if(resta_1<1){
                                                    saldo = 0;
                                                }else if(resta_1 >= 1){
                                                    if(resta_1 > pending){
                                                        saldo = pending;
                                                    }else{
                                                        saldo = saldo-v.abono_pagado;
                                                    }
                                                }
                                            }else if(v.abono_pagado<=0){
                                                pending = (v.comision_total);
                                                if(saldo > pending){
                                                    saldo = pending;
                                                }
                                                if(pending < 1){
                                                    saldo = 0;
                                                }
                                            }
                                        }else{
                                            pending = (v.comision_total-v.abono_pagado);
                                            nuevosaldo = 12.5 * v.porcentaje_decimal;
                                            saldo = ((nuevosaldo/100)*(total));
                                            if(v.abono_pagado>0){
                                                evaluar = (v.comision_total-v.abono_pagado);
                                                if(evaluar<1){
                                                    pending = 0;
                                                    saldo = 0;
                                                }else{
                                                    pending = evaluar;
                                                }
                                                resta_1 = saldo-v.abono_pagado;
                                                if(resta_1<1){
                                                    saldo = 0;
                                                }
                                                else if(resta_1 >= 1){
                                                    if(resta_1 > pending){
                                                        saldo = pending;
                                                    }
                                                    else{
                                                        saldo = saldo-v.abono_pagado;
                                                    }   
                                                }
                                            }
                                            else if(v.abono_pagado<=0){
                                                pending = (v.comision_total);
                                                if(saldo > pending){
                                                    saldo = pending;
                                                }
                                                if(pending < 1){
                                                    saldo = 0;
                                                }
                                            }
                                            if(saldo > pending){
                                                saldo = pending;
                                            }
                                            if(pending < 1){
                                                saldo = 0;
                                                pending = 0;
                                            }
                                        }                   
                                        // boton guardar
                                        $('[data-toggle="tooltip"]').tooltip();

                                        let boton = `
                                        <button data-toggle="tooltip" data-placement="top"type="button" id="btn_${i}" 
                                        ${(parseInt(banderaPermisos) != 1) ? 'style="display:none" ' : 'style="display:show" '} 
                                        onclick="SaveAjuste(${i})" ${v.descuento == 1 || v.descuento > 1  ? 'style="display:none" ' : 'style="display:show" ' }  
                                         data-toggle="tooltip" disabled
                                        data-placement="top" title="GUARDAR PORCENTAJE" class="btn-data btn-gray"><span class="material-icons">check</span>
                                        </button>`;
                                        // boton topar
                                        let boton_topar = `
                                        <button data-toggle="tooltip" data-placement="top"type="button" id="btnTopar_${i}"  data-toggle="tooltip"
                                        data-placement="top" title="TOPAR COMISIÓN" 
                                        ${v.descuento == 1 || v.descuento > 1 ? 'style="display:none" ' : 'style="display:show" '} 
                                        onclick="Confirmacion(${i} ,'${v.colaborador}')" class="btn-data btn-warning">
                                        <i class="fas fa-hand-paper"></i>
                                        </button>`;
                                        // boton  regresar 
                                        let boton_regresar = `
                                        <button data-toggle="tooltip" data-placement="top"type="button" id="btnReload_${i}"  data-toggle="tooltip" 
                                        data-placement="top" 
                                          ${v.descuento == 0 || v.descuento > 1 ? 'style="display:none" ' : 'style="display:show" '} 

                                        title="Regresar" onclick="Regresar(${i}, ${v.porcentaje_decimal},'${v.colaborador}','${v.rol}',${data1[0].totalNeto2})" 
                                        class="btn-data btn-sky"><span class="material-icons">cached</span>
                                        </button>`;
                                        // botton pago
                                        let boton_pago = `
                                        <button data-toggle="tooltip" data-placement="top"type="button" id="btnAdd_${i}"  data-toggle="tooltip" 
                                        data-placement="top" title="AGREGAR PAGO" 
                                        ${v.descuento == 1 || v.descuento > 1  ? 'style="display:none" ' : 'style="display:show" '} 
                                        
                                        onclick="AgregarPago(${i}, ${pending},'${v.colaborador}','${v.rol}')" 
                                        class="btn-data btn-green"><i class="fas fa-plus"></i>
                                        </button>
                                        `;


                                        $("#modal_NEODATA .modal-body").append(`<div class="row">
                                        <div class="col-md-2"><input id="id_disparador" type="hidden" name="id_disparador" value="1">
                                        <input type="hidden" name="pago_neo" id="pago_neo" value="${total.toFixed(3)}">
                                        <input type="hidden" name="id_rol" id="id_rol_${i}" value="${v.rol_generado}">
                                        <input type="hidden" name="pending" id="pending" value="${pending}">
                                        <input type="hidden" name="idLote" id="idLote" value="${idLote}">
                                        <input id="id_comision_${i}" type="hidden" name="id_comision_${i}" value="${v.id_comision}">
                                        <input id="id_usuario_${i}" type="hidden" name="id_usuario_${i}" value="${v.id_usuario}">
                                        <input class="form-control input-gral ng-invalid-required" required readonly="true" value="${v.colaborador}" 
                                            style="font-size:12px; ${v.descuento == 1 ? 'color:red;' : ''} "><b>
                                            <p style="font-size:12px; ${v.descuento == 1 ? 'color:red;' : ''} ">${ v.descuento == "1" ? v.rol+' Incorrecto' : v.rol}</b>
                                            <b style="color:${v.descuento > 1 && v.observaciones != 'COMISIÓN CEDIDA'  ? 'red' : 'green'}; 
                                            font-size:10px;">${v.observaciones == 'COMISIÓN CEDIDA' ? '(COMISIÓN CEDIDA)' : ''} ${v.descuento > 1 && v.observaciones != 'COMISIÓN CEDIDA'  ? '(CEDIÓ COMISIÓN)' : ''}<b></p>
                                        </div>
                                        <div class="col-md-1">
                                        <input class="form-control input-gral ng-invalid-required" ${(parseInt(banderaPermisos) != 1) ? 'readonly="true"' : ''} style="${v.descuento == 1 ? 'color:red;' : ''}" ${v.descuento == 1 || v.descuento > 1 ? 'disabled' : ''} id="porcentaje_${i}" ${(v.rol_generado == 1 || v.rol_generado == 2 || v.rol_generado == 3 || v.rol_generado == 9 || v.rol_generado == 45 || v.rol_generado == 38) ? 'max="1"' : 'max="4"'}   onblur="Editar(${i},${precioAnt},${v.id_usuario})" value="${parseFloat(v.porcentaje_decimal)}">
                                        <input type="hidden" id="porcentaje_ant_${i}" name="porcentaje_ant_${i}" value="${v.porcentaje_decimal}"><br>
                                        <b id="msj_${i}" style="color:red;"></b>
                                        </div>
                                        <div class="col-md-2"><input class="form-control input-gral ng-invalid-required" style="${v.descuento == 1 ? 'color:red;' : ''}" readonly="true" id="comision_total_${i}" value="${formatMoney(v.comision_total)}"></div>
                                        <div class="col-md-2"><input class="form-control input-gral ng-invalid-required" style="${v.descuento == 1 ? 'color:red;' : ''}" readonly="true" id="abonado_${i}" value="${formatMoney(v.abono_pagado)}"></div>
                                        <div class="col-md-2"><input class="form-control input-gral ng-invalid-required" required readonly="true"  id="pendiente_${i}" value="${formatMoney(v.comision_total-v.abono_pagado)}"></div>
                                        <div class="col-md-3 botones d-flex">
                                        ${(parseInt(banderaPermisos) != 1) ? '' : boton}  
                                        ${boton_topar}
                                        ${boton_pago}
                                        ${boton_regresar}
                                        
                                        
                                        </div>
                                        </div> `);
                                    
                                        counts++
                                    });
                                });

                                $.getJSON(general_base_url + "Incidencias/getUserVC/" + cliente)
                                .done(function (vc) {
                                    if (vc.length > 0) {
                                        $("#modal_NEODATA .modal-footer").append(`
                                            <div class="d-flex justify-content-center align-items-center w-100">
                                                <button data-toggle="tooltip" data-placement="top"type="button" value="${lote}" data-lote="${lote}" data-cliente="${cliente}" class="btn-gral-data bajaVentaC" style='background-color:red; margin: auto;'>
                                                    BAJA DE VENTAS COMPARTIDAS<i class="fas fa-trash pl-1"></i>
                                                </button>
                                            </div>
                                        `);   
                                    }  
                                });                                                          
                                
                                if(total < 1 ){
                                    $('#dispersar').prop('disabled', true);
                                }
                                else{
                                    $('#dispersar').prop('disabled', false);
                                }
                            });
                        }

                    break;
                    case 2:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No se encontró esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        $('#spiner-loader').addClass('hide');
                    break;
                    case 3:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No tiene vivienda, si hay referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        $('#spiner-loader').addClass('hide');
                    break;
                    case 4:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No hay pagos aplicados a esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        $('#spiner-loader').addClass('hide');
                    break;
                    case 5:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Referencia duplicada de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        $('#spiner-loader').addClass('hide');
                    break;
                    default:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Sin localizar.</b></h4><br><h5>Revisar con sistemas: '+row.data().nombreLote+'.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        $('#spiner-loader').addClass('hide');
                    break;
                }
            }
            else{
                $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><b>No se encontró esta referencia en NEODATA de '+row.data().nombreLote+'.</b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                $('#spiner-loader').addClass('hide');
            }
        });

        $("#modal_NEODATA").modal();
    });

    $(window).resize(function(){
        tabla_inventario.columns.adjust();
    });
});

function formatMoney( n ) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
    j = (j = i.length) > 3 ? j % 3 : 0;

    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

$(document).on('click', '#save_asignacion', function(e) {
    e.preventDefault();

    var id_desarrollo = $("#sel_desarrollo").val();
    var id_estado = ($('input:checkbox[id=check_edo]:checked').val() == 'on') ? 1 : 0;
    var data_asignacion = new FormData();
    data_asignacion.append("idLote", idLote);
    data_asignacion.append("id_desarrollo", id_desarrollo);
    data_asignacion.append("id_estado", id_estado);

    if (id_desarrollo == null) {
        alerts.showNotification("top", "right", "Debes seleccionar un desarrollo.", "danger");
    } 
    if (id_desarrollo != null) {
        $('#save_asignacion').prop('disabled', true);
        $.ajax({
            url : general_base_url+'Administracion/update_asignacion/',
            data: data_asignacion,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST', 
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save_asignacion').prop('disabled', false);
                    $('#seeInformationModal').modal('hide');
                    alerts.showNotification("top", "right", "Asignado con éxito.", "success");
                } else if(response.message == 'ERROR'){
                    $('#save_asignacion').prop('disabled', false);
                    $('#seeInformationModal').modal('hide');
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                $('#save_asignacion').prop('disabled', false);
                $('#seeInformationModal').modal('hide');
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '.update_bandera', function(e){
    id_pagoc = $(this).val();
    nombre = $(this).attr("data-nombre");
    $("#myUpdateBanderaModal .modal-header").html('');
    $("#myUpdateBanderaModal .modal-body").html('');
    $("#myUpdateBanderaModal .modal-footer").html('');

    $("#myUpdateBanderaModal .modal-header").append('<h4 class="card-title text-center"><b>Regresar a activas</b></h4>');
    $("#myUpdateBanderaModal .modal-body").append( ` <div id="inputhidden"><p>¿Está seguro de regresar el lote <b>${nombre}</b> a activas?</p> <input type="hidden" name="id_pagoc" id="id_pagoc"><input type="hidden" name="param" id="param">`);
    $("#myUpdateBanderaModal .modal-footer").append(`
    <div class="row">
    <div class="col-md-12" style="align-content: left;">
    
    <button data-toggle="tooltip" data-placement="top"type="button" class="btn btn-danger btn-simple " data-dismiss="modal">
    CANCELAR
    </button>
    <button data-toggle="tooltip" data-placement="top"type="submit" class="btn btn-gral-data" value="ACEPTAR" style="margin: 15px;">
    ACEPTAR
    </button>

    </div></div>`);

    $("#myUpdateBanderaModal").modal();
    $("#id_pagoc").val(id_pagoc);
    $("#param").val(55);
});

$("#my_updatebandera_form").on('submit', function(e){
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: general_base_url+'Incidencias/updateBandera',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
        },
        success: function(data) {
            if (data == 1) {
                $('#myUpdateBanderaModal').modal("hide");
                $("#id_pagoc").val("");
                alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                $('#tabla_inventario_contraloria').DataTable().ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Oops, algo salió mal. Error al intentar actualizar.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#form_pagadas").submit(function(e) {;
    e.preventDefault();
}).validate({
    submitHandler: function(form) {
        var data = new FormData($(form)[0]);

        $.ajax({
            url: general_base_url + "Incidencias/CambiarPrecioLote",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data) {
                if (data == 1) {
                    $("#modal_pagadas").modal('toggle');
                    $('#tabla_inventario_contraloria').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Precio Actualizado", "success");
                }else if(data == 2){
                    $("#modal_pagadas").modal('toggle');
                    alerts.showNotification("top", "right", "La nueva comisión total es menor a los pagos aplicados. CONTACTAR A SISTEMAS.", "warning");
                } 
                else {
                    $("#modal_pagadas").modal('toggle');
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            },
            error: function() {
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});

function verificar(precio){
    let precioAnt = parseFloat(precio);
    let  precioAct =  replaceAll($('#precioL').val(), ',','');
    if(precioAnt == 'null' || precioAnt == NaN){
        precioAnt=0;
    }

    if(rol == 13 || rol == 8 || rol == 17){
        if(isNaN(precioAnt) || parseFloat(precioAct) < 0){
            document.getElementById('msj').innerHTML = 'Precio no válido';
            document.getElementById('btn-save').disabled = true;

        }else if(parseFloat(precioAct) < parseFloat(precioAnt)){
            document.getElementById('msj').innerHTML = 'El precio ingresado es menor al actual, esto podria afectar las comisiones que esten registradas';
            document.getElementById('btn-save').disabled = false;
        }else if(parseFloat(precioAct) > parseFloat(precioAnt)){
            document.getElementById('btn-save').disabled = false;
            document.getElementById('msj').innerHTML = '';
        }
    }
}

function verifica_pago(precio){
    let precioAnt = parseFloat(precio);
    let  precioAct =  replaceAll($('#monotAdd').val(), ',','');
 

    if(rol == 13 || rol == 17 || rol == 8){
        if(parseFloat(precioAct) <= parseFloat(precioAnt)){
            document.getElementById('btn-save2').disabled = false;
            document.getElementById('msj2').innerHTML = '';
        }
        else{
            document.getElementById('msj2').innerHTML = 'Monto no válido, es mayor al disponible.';
            document.getElementById('btn-save2').disabled = true;
        }
    }
    else{
        document.getElementById('btn-save2').disabled = false;
        document.getElementById('msj2').innerHTML = '';

    }
}

function Confirmacion(i,name){
    $('#modal_avisos .modal-header').html(''); 
    $('#modal_avisos .modal-body').html(''); 
    $('#modal_avisos .modal-footer').html(''); 

    $("#modal_avisos .modal-header").append('<h4 class="card-title text-center"><b>Topar comisiones</b></h4>');
    $("#modal_avisos .modal-body").append(`
        <div id="inputhidden">
                <p class="text-gral" >¿Estás seguro de DETENER la comisión al usuario <b>${name}</b>?
                <br>
                 <i><b>NOTA:</b> El cambio ya no se podrá revertir.</i></p>
            <div class="form-group m-0">
                <label class="control-label">Describe el motivo por el cual se detendrán los pagos de esta comisión</label>
                <textarea id="comentario_topaT_${i}" name="comentario_topaT_${i}" class="text-modal" rows="3" 
                    required></textarea>
            </div>
        </div>`);
    $("#modal_avisos .modal-footer").append(`
         
            <button data-toggle="tooltip" data-placement="top"type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR
            </button>
            <button data-toggle="tooltip" data-placement="top"type="submit"  onclick="ToparComision(${i})"  class="btn btn-gral-data" value="ACEPTAR" style="margin: 15px;">
            ACEPTAR
        </button>
            `);
    $('#modal_avisos').modal('show');
}
// 
// aqui falta crear la function para validar que no existan menores.
    function validar()
    {
    //    var input1 = document.getElementById();   
    }

// 
function AgregarPago(i,pendiente,colab,rol){
    $('#modal_add .modal-header').html(''); 
    $('#modal_add .modal-body').html(''); 
    $('#modal_add .modal-footer').html(''); 
    let comisionTotal = replaceAll($('#comision_total_'+i).val(), ',','');
    let abonado = replaceAll($('#abonado_'+i).val(), ',','');

    let pendiente2 = parseFloat(comisionTotal-abonado);
    pendiente=pendiente2;

    $("#modal_add .modal-header").append('<h4 class="card-title text-center"><b>Agregar pago</b></h4>');
    $("#modal_add .modal-body").append(`
    <div id="inputhidden"><p>El monto no puede ser mayor a <b>$${formatMoney(pendiente)}</b> para el <b>
     ${rol} - ${colab} </b> , en caso de ser mayor válida si hay algún pago en <b>NUEVAS</b> que puedas quitar.</p>
        <div class="form-group">
            <input id="monotAdd" name="monotAdd" min="1" class="form-control input-gral"  type="number" onblur="verifica_pago(${pendiente})" placeholder="Monto a abonar" maxlength="6"/>
             <p id="msj2" style="color:red;"></p>
            <label class="control-label">Describe el motivo por el cual se agrega este pago</label>
            <textarea id="comentario_topa" name="comentario_topa" class="text-modal" rows="3" required></textarea>
        </div>
    </div>`);
    $("#modal_add .modal-footer").append(`
       <button data-toggle="tooltip" data-placement="top"type="button" class="btn btn-danger btn-simple"  data-dismiss="modal" value="CANCELAR">
       CANCELAR
       </button>
       <button data-toggle="tooltip" data-placement="top"type="button" onclick="GuardarPago(${i})" class="btn btn-gral-data" disabled  id="btn-save2" value="ACEPTAR">
       ACEPTAR
       </button>
                `);
    $('#modal_add').modal('show');

}

function VlidarNuevos(i,usuario){           
    $('#modal_quitar .modal-header').html(''); 
    $('#modal_quitar .modal-body').html(''); 
    $('#modal_quitar .modal-footer').html(''); 
    $.getJSON(general_base_url + "Comisiones/verPagos/" + i + '/' + usuario).done(function(data) {
        if(data.length < 1){
            $('#modal_quitar .modal-body').append(`SIN PAGOS NUEVOS`);
        }
        else{
            $('#modal_quitar .modal-body').append(`<table class="table table-hover">
            <thead>
            <tr>
            <th>ID pago</th>
            <th>Monto</th>
            <th>Usuario</th>
            <th>Estatus</th>
            </tr>
            </thead><tbody>`);
            for( var j = 0; j<data.length ; j++){
                $('#modal_avisos .modal-body .table').append(`<tr>
                <td>${data[j]['id_pago_i']}</td>
                <td>$${formatMoney(data[j]['abono_neodata'])}</td>
                <td>${data[j]['id_usuario']}</td>
                <td>${data[j]['id_comision']}</td></tr>`);
            }
        }
    });
    $('#modal_quitar').modal('show');
}

function ToparComision(i){
    var comentario = $('#comentario_topaT_'+i).val();
    $('#modal_avisos .modal-body').html('');
    $('#modal_avisos .modal-footer').html('');
  //  var formData = new FormData();
 // formData.append("comentario", $('#comentario_topa').val());
    let idLote = $('#idLote').val();
    
    let id_comision = $('#id_comision_'+i).val();
    let abonado = replaceAll($('#abonado_'+i).val(), ',','');
    var dataPost = "comentario=" + comentario;

    $.ajax({
        url: general_base_url+'Incidencias/ToparComision/'+id_comision+'/'+idLote,
        data: dataPost,
        type: 'POST',
        dataType: 'html',
        success:function(response){
            var len =JSON.parse(response).length; //response.length;
            response = JSON.parse(response);
            if(len == 0){
                // document.getElementById('btnTopar_'+i).disabled = true;
                $("#btnTopar_"+i).hide(1500); 
                // document.getElementById('btn_'+i).disabled = true;
                $("#btn_"+i).hide(1500); 
                // document.getElementById('btnAdd_'+i).disabled = true;
                $("#btnAdd_"+i).hide(1500);
                // document.getElementById('btnReload_'+i).disabled = false;
                $("#btnReload_"+i).show("slow");
                
                document.getElementById('porcentaje_'+i).disabled = true;

                let por = document.getElementById('porcentaje_'+i);
                por.setAttribute('readonly','true');
                let btn = document.getElementById('btnTopar_'+i);
                btn.setAttribute('style','background:#FED2C9;');
                $('#comision_total_'+i).val(formatMoney(abonado));
                let pendiente = parseFloat(abonado - abonado);
                $('#pendiente_'+i).val(formatMoney(pendiente));

                $('#modal_avisos').modal('hide');
                alerts.showNotification("top", "right", "Comisión detenida con éxito.", "success");
            }
            else{
                let suma = 0;
                // document.getElementById('btnTopar_'+i).disabled = true;
                $("#btnTopar_"+i).hide(1500); 
                //  document.getElementById('btn_'+i).disabled = true;
                 $("#btn_"+i).hide(1500); 
                // document.getElementById('btnAdd_'+i).disabled = true;
                $("#btnAdd_"+i).hide(1500);
                // document.getElementById('btnReload_'+i).disabled = false;
                $("#btnReload_"+i).show('slow');
         
                document.getElementById('porcentaje_'+i).disabled = true;
                let por = document.getElementById('porcentaje_'+i);
                por.setAttribute('readonly','true');
                let btn = document.getElementById('btnTopar_'+i);
                btn.setAttribute('style','background:#FED2C9;');
    
                $('#modal_avisos .modal-body').append(`<h6>Pagos eliminados</h6>`);
                $('#modal_avisos .modal-body').append(`<table class="table table-hover">
                <thead><tr><th>ID pago</th><th>Monto</th><th>Usuario</th><th>Estatus</th></tr></thead><tbody>`);

                for( var j = 0; j<len; j++){
                    suma = suma + response[j]['abono_neodata'];
                    $('#modal_avisos .modal-body .table').append(`<tr>
                    <td>${response[j]['id_pago_i']}</td>
                    <td>$${formatMoney(response[j]['abono_neodata'])}</td>
                    <td>${response[j]['usuario']}</td>
                    <td>${response[j]['nombre']}</td></tr>`);
                }

                $('#comision_total_'+i).val(formatMoney(abonado-suma));
                let pendiente = parseFloat((abonado-suma) - abonado);
                $('#pendiente_'+i).val(formatMoney(pendiente));
                $('#modal_avisos .modal-body').append(`</tbody></table>`);
                $('#modal_avisos .modal-body').append(`<div class="row"><div class="col-md-12"><center><input type="button" style="background:#003D82;" data-dismiss="modal" id="btn-save" class="btn btn-success" value="ACEPTAR"><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CERRAR"></center></div></div>`);
            }
        }
    });
    
    $('#modal_avisos').modal('show');
}

function GuardarPago(i){
    document.getElementById('btn-save2').disabled = true;
    let id_comision = $('#id_comision_'+i).val();
    var formData = new FormData(document.getElementById("form_add"));
    formData.append("dato", "valor");

    $.ajax({
        method: 'POST',
        url: general_base_url+'Incidencias/GuardarPago/'+id_comision,
        data: formData,
        processData: false,
        contentType: false,
        success:function(data){
            if(data == 1){
                
                $('#modal_add').modal('hide');
                $('#modal_NEODATA').modal('hide');
                alerts.showNotification("top", "right", "Pago registrado con éxito.", "success");
                document.getElementById("form_add").reset();

            }
            else{
                $('#modal_add').modal('hide');
                alerts.showNotification("top", "right", "Ocurrio un error, intenta mas tarde.", "danger");
                document.getElementById("form_add").reset();
            }
            document.getElementById('btn-save2').disabled = false;
        },

        error: function(){
            $('#modal_add').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}

function QuitarPago(i){
    let id_comision = $('#id_comision_'+i).val();
    var formData = new FormData(document.getElementById("form_add"));
    formData.append("dato", "valor");
    $.ajax({
        method: 'POST',
        url: general_base_url+'Comisiones/QuitarPago/'+id_comision,
        data: formData,
        processData: false,
        contentType: false,
        success:function(data){
            if(data == 1){
                
                $('#modal_quitar').modal('hide');
                $('#modal_NEODATA').modal('hide');
                alerts.showNotification("top", "right", "Pago eliminado con éxito.", "success");
                document.getElementById("form_add").reset();

            }
            else{
                $('#modal_quitar').modal('hide');
                alerts.showNotification("top", "right", "Ocurrio un error, intenta mas tarde.", "danger");
                document.getElementById("form_add").reset();
            }
        },
            error: function(){
            $('#modal_quitar').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}

function Editar(i,precio,id_usuario){
    $('#modal_avisos .modal-body').html('');
    document.getElementById('btn_'+i).disabled=false;
    let precioLote = parseFloat(precio);
    let nuevoPorce1 = replaceAll($('#porcentaje_'+i).val(), ',',''); 
    let nuevoPorce = replaceAll(nuevoPorce1, '%',''); 
    let  abonado =  replaceAll($('#abonado_'+i).val(), ',','');
    let id_comision = $('#id_comision_'+i).val();
    let id_rol = $('#id_rol_'+i).val();
    let porcentaje_ant = $('#porcentaje_ant_'+i).val();
    let pendiente = replaceAll($('#pendiente_'+i).val(), ',',''); 

    if(id_rol == 1 || id_rol == 2 || id_rol == 3 || id_rol == 9 || id_rol == 38 || id_rol == 45){
        if(id_usuario == "7689" || id_usuario == 7689 || id_usuario == "6739" || id_usuario == 6739 ){
            if( parseFloat(nuevoPorce) > 20){
                $('#porcentaje_'+i).val(1);
                nuevoPorce=1;
                document.getElementById('msj_'+i).innerHTML = 'Debe ingresar un número entre 0 y 1';
            }else{
                document.getElementById('msj_'+i).innerHTML = '';
            }
        }
        else if(id_usuario == "4824" || id_usuario == 4824){
            if(parseFloat(nuevoPorce) > 2 || parseFloat(nuevoPorce) < 0){
                $('#porcentaje_'+i).val(1);
                nuevoPorce=1;
                document.getElementById('msj_'+i).innerHTML = 'Debe ingresar un número entre 2 y 0';
            }
            else{
                document.getElementById('msj_'+i).innerHTML = '';
            }
        }
        else{
            if(parseFloat(nuevoPorce) > 1 || parseFloat(nuevoPorce) < 0){
                $('#porcentaje_'+i).val(1);
                nuevoPorce=1;
                document.getElementById('msj_'+i).innerHTML = 'Debe ingresar un número entre 0 y 1';
            }
            else{
                document.getElementById('msj_'+i).innerHTML = '';
            }
        }
    }
    else{
        if(parseFloat(nuevoPorce) > 4 || parseFloat(nuevoPorce) < 0){
            $('#porcentaje_'+i).val(3);
            nuevoPorce=3;
            document.getElementById('msj_'+i).innerHTML = '';
            document.getElementById('msj_'+i).innerHTML = 'Debe ingresar un número entre 0 y 3';
        }
        else{
            document.getElementById('msj_'+i).innerHTML = '';
        }
    }

    let comisionTotal = precioLote * (nuevoPorce / 100);
    $('#btn_'+i).addClass('btn-success');

    if(parseFloat(abonado) > parseFloat(comisionTotal)){
        $('#comision_total_'+i).val(formatMoney(comisionTotal));
        $.ajax({
            url: general_base_url+'Incidencias/getPagosByComision/'+id_comision,
            type: 'post',
            dataType: 'json',
            success:function(response){
                var len = response.length;
                if(len == 0){
                    let nuevoPendient=parseFloat(comisionTotal - abonado);
                    $('#pendiente_'+i).val(formatMoney(nuevoPendient));

                    $('#modal_avisos .modal-body').append('<p>La nueva comisión total <b style="color:green;">$'+formatMoney(comisionTotal)+'</b> es menor a lo abondado, No se encontraron pagos disponibles para eliminar. <b style="color:red;">Aplicar los respectivos descuentos</b></p>');
                }
                else{
                    let suma = 0;
                    $('#modal_avisos .modal-body').append(`<table class="table table-hover">
                    <thead><tr><th>ID pago</th><th>Monto</th><th>Usuario</th><th>Estatus</th></tr></thead><tbody>`);
                    for( var j = 0; j<len; j++){
                        suma = suma + response[j]['abono_neodata'];
                        $('#modal_avisos .modal-body .table').append(`<tr>
                        <td>${response[j]['id_pago_i']}</td>
                        <td>$${formatMoney(response[j]['abono_neodata'])}</td>
                        <td>${response[j]['usuario']}</td>
                        <td>${response[j]['nombre']}</td></tr>`);
                    }

                    $('#modal_avisos .modal-body').append(`</tbody></table>`);
                    let nuevoAbono=parseFloat(abonado-suma);
                    let NuevoPendiente=parseFloat(comisionTotal - nuevoAbono);
                    $('#abonado_'+i).val(formatMoney(nuevoAbono));
                    $('#pendiente_'+i).val(formatMoney(NuevoPendiente));

                    if(nuevoAbono > comisionTotal){
                        $('#modal_avisos .modal-body').append('<p>La nueva comisión total es de <b style="color:green;">$'+formatMoney(comisionTotal)+'</b> y es menor a lo abondado <b>$'+formatMoney(nuevoAbono)+'</b> (ya con los pagos eliminados), Se eliminar los pagos mostrados una vez guardado el cambio. <b style="color:red;"><br>Recuerda aplicar los respectivos descuentos</b></p>');
                    }
                    else{
                        $('#modal_avisos .modal-body').append('<p>La nueva comisión total es de <b style="color:green;">$'+formatMoney(comisionTotal)+'</b>, se eliminaran los pagos mostrados una vez guardado el ajuste. El nuevo saldo abonado sera de <b>$'+formatMoney(nuevoAbono)+'</b>. <br><b>No se requiere aplicar ningun descuento</b> </p>');
                    }

                    $('#modal_avisos .modal-body').append('<center><button data-toggle="tooltip" data-placement="top"type="button" class="btn btn-primary" data-dismiss="modal">ENTENDIDO</button></center>');
                }
            }
        });

        $('#modal_avisos').modal({
            keyboard: false,
            backdrop: 'static'
        });

    $('#modal_avisos').modal('show');   
    }
    else{
        let NuevoPendiente=parseFloat(comisionTotal - abonado);
        $('#pendiente_'+i).val(formatMoney(NuevoPendiente));
        // document.getElementById('btn_'+i).disabled=false;
        $("#btn_"+i).show('slow'); 
        $('#comision_total_'+i).val(formatMoney(comisionTotal));
    }
}

function SaveAjuste(i){
    $('#btn_'+i).removeClass('btn-success');
    $('#btn_'+i).addClass('btn-default');

    let id_comision = $('#id_comision_'+i).val();
    let id_usuario = $('#id_usuario_'+i).val();
    let id_lote = $('#idLote').val();
    let porcentaje = $('#porcentaje_'+i).val();
    let porcentaje_ant = $('#porcentaje_ant_'+i).val();
    let comision_total = $('#comision_total_'+i).val();

    var formData = new FormData;
    formData.append("id_comision", id_comision);
    formData.append("id_usuario", id_usuario);
    formData.append("id_lote", id_lote);
    formData.append("porcentaje", porcentaje);
    formData.append("porcentaje_ant", porcentaje_ant);
    formData.append("comision_total", comision_total);

    $.ajax({
        url: general_base_url+'Incidencias/SaveAjuste',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        method: 'POST',
        type: 'POST', // For jQuery < 1.9
        success:function(response){
            alerts.showNotification("top", "right", "Modificación almacenada con éxito.", "success");
        }
    });
}

$("#form_ceder").on('submit', function(e){ 
    e.preventDefault();
    document.getElementById('btn_ceder').disabled=true;

    let formData = new FormData(document.getElementById("form_ceder"));
    formData.append("dato", "valor");
    $.ajax({
        url: general_base_url+'Incidencias/CederComisiones',
        data: formData,
        method: 'POST',
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {
            if (data == 1) {
                 $("#asesorold").selectpicker('refresh');
                // $('#tabla_inventario_contraloria').DataTable().ajax.reload(null, false);

                 $("#asesorold").val('');
                 $("#asesorold").selectpicker("refresh");
                $("#roles2").val('');
                $("#roles2").selectpicker("refresh");
                $('#usuarioid2').val('default');
                $("#usuarioid2").selectpicker("refresh");
                $('#miModalCeder').modal('hide');
                $("#comentario").val("");
                document.getElementById('info').innerHTML='';

                alerts.showNotification("top", "right", "Comisión cedida.", "success");
                document.getElementById('btn_ceder').disabled=false;
            } else {
                alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
                $('#miModalCeder').modal('toggle');
                document.getElementById('btn_ceder').disabled=false;
                $('#form_ceder')[0].reset();
            }
        },
        error: function(){
            $('#form_ceder')[0].reset();
            $('#miModalCeder').modal('toggle');
            document.getElementById('btn_ceder2').disabled=false;
            $('#miModal').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#form_inventario").on('submit', function(e){ 
    e.preventDefault();
    document.getElementById('btn_inv').disabled=true;

    let formData = new FormData(document.getElementById("form_inventario"));
    $.ajax({
        url: general_base_url+'Incidencias/UpdateInventarioClient',
        data: formData,
        method: 'POST',
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {
            if (data == 1) {
                $('#tabla_inventario_contraloria').DataTable().ajax.reload();

                $('#form_inventario')[0].reset();
                $("#roles3").val('');
                $("#roles3").selectpicker("refresh");
                $('#usuarioid3').val('default');
                $("#usuarioid3").selectpicker("refresh");
                $('#miModalInventario').modal('toggle');
                alerts.showNotification("top", "right", "Datos actualizados.", "success");
                document.getElementById('btn_inv').disabled=false;
                document.getElementById('UserSelect').innerHTML = '';
            }
            else {
                alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
                $('#miModalInventario').modal('toggle');
                document.getElementById('btn_inv').disabled=false;
                $('#form_inventario')[0].reset();
                document.getElementById('UserSelect').innerHTML = '';
            }
        },
        error: function(){
            $('#form_inventario')[0].reset();
            $('#miModalInventario').modal('toggle');
            document.getElementById('btn_inv').disabled=false;
            $('#miModalInventario').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            document.getElementById('UserSelect').innerHTML = '';

        }
    });
});

$("#form_vc").on('submit', function(e){ 
    e.preventDefault();
    document.getElementById('btn_vc').disabled=true;

    let formData = new FormData(document.getElementById("form_vc"));
    $.ajax({
        url: general_base_url+'Incidencias/UpdateVcUser',
        data: formData,
        method: 'POST',
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {
            if (data == 1) {
                $('#tabla_inventario_contraloria').DataTable().ajax.reload();

                $('#form_vc')[0].reset();
                $("#rolesvc").val('');
                $("#rolesvc").selectpicker("refresh");
                $('#usuarioid4').val('default');
                $("#usuarioid4").selectpicker("refresh");
                $('#miModalVc').modal('toggle');
                alerts.showNotification("top", "right", "Datos actualizados.", "success");
                document.getElementById('btn_vc').disabled=false;
                document.getElementById('UserSelectvc').innerHTML = '';

            } else {
                alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
                $('#miModalVc').modal('toggle');
                document.getElementById('btn_vc').disabled=false;
                $('#form_vc')[0].reset();
                document.getElementById('UserSelectvc').innerHTML = '';

            }
        },
        error: function(){
            $('#form_vc')[0].reset();
            $('#miModalVc').modal('toggle');
            document.getElementById('btn_vc').disabled=false;
            $('#miModalVc').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#form_vcNew").on('submit', function(e){ 
    $("#btn_vcnew").prop('disabled',true);
    e.preventDefault();
    document.getElementById('btn_vc').disabled=true;
    id_cliente = document.getElementById("clientes2").value;
    id_lote = document.getElementById("lotes1").value;
    banderaAgregarVenta = 0;
if( $('#elegir_coordinador').val() >= 0 && $('#elegir_gerente').val() != 0 && $('#elegir_subdirector').val() != 0 && $('#elegir_diRegional').val() >=0){

    let formData = new FormData(document.getElementById("form_vcNew"));
    formData.append("id_cliente", id_cliente);
    formData.append("id_lote", id_lote);
    

    $.ajax({
        url: general_base_url+'Incidencias/AddVentaCompartida',
        data: formData,
        method: 'POST',
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {
            if (data == 1) {
                $('#spiner-loader').removeClass('hidden');

                $('#form_vcNew')[0].reset();
                $('#tabla_inventario_contraloria').DataTable().ajax.reload();

                $('#elegir_asesor').val('default');
                $("#elegir_asesor").selectpicker("refresh");
                $('#elegir_coordinador').val('default');
                $("#elegir_coordinador").selectpicker("refresh");
                $('#elegir_gerente').val('default');
                $("#elegir_gerente").selectpicker("refresh");

                $('#miModalVcNew').modal('toggle');
                alerts.showNotification("top", "right", "Datos actualizados.", "success");
                document.getElementById('btn_vc').disabled=false;
                document.getElementById('UserSelectvc').innerHTML = '';
                $("#spiner-loader").addClass('hide' );
                
            } else {
                alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
                $('#miModalVcNew').modal('toggle');
                document.getElementById('btn_vc').disabled=false;
                $('#form_vcNew')[0].reset();
                document.getElementById('UserSelectvc').innerHTML = '';
            }
        },
        error: function(){
            $('#form_vcNew')[0].reset();
            $('#miModalVcNew').modal('toggle');
            document.getElementById('btn_vc').disabled=false;
            $('#miModalVcNew').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });

}else{
    alerts.showNotification("top", "right", "DEBE SELECCIONAR COORDINADOR,GERENTE Y SUBDIRECTOR.", "warning");

}
});

    function tieneRegional(usuario){
     
    }

    $(document).on('click', '.cambioSede', function(e){
        $("#tituloLote").html('')
        $("#sedeOld").html('')

        $('#tabla_inventario_contraloria').DataTable().ajax.reload();
        nombreLote  = $(this).attr("data-nombre");
        nombreSede  = $(this).attr("data-sedesName");
        idSedes     = $(this).attr("data-sedes");
        cliente    = $(this).attr("data-cliente");
        idLote    = $(this).attr("data-idLote");
        tipoLote    = $(this).attr("data-tipo");
        if (idSedes == 0){
            nombreSede = "Sin sede";
        }
        $("#tituloLote").append( `  <div id="sedes"><tiene>El lote <b>${nombreLote}</b>tiene actualmente la sede "<b>${nombreSede} </b>". Selecione la nueva sede en caso de requerirlo</p>`);
        $("#modal_sedes").modal();

    });
    
    $("#form_sede").submit(function(e) {;
        e.preventDefault();
    }).validate({
        submitHandler: function(form) {
            var data = new FormData($(form)[0]);
            data.append('cliente', cliente);
            data.append('idLote', idLote);
            

            $.ajax({
                url: general_base_url + "Incidencias/cambioSede",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data) {
                    alerts.showNotification("top", "right", "" + data.message + "", "" + data.response_type + "");
                    $("#tituloLote").html('')
                    $('#modal_sedes').modal('hide');
                    $('#tabla_inventario_contraloria').DataTable().ajax.reload();

                },
                error: function() {
                    alert("ERROR EN EL SISTEMA");
                }
            });
        }
    });

    $(document).on('click', ".bajaVentaC", function(e){
        $('#boton').prop('disabled', true);
    
        idLote = $(this).attr('data-lote');
        idCliente = $(this).attr('data-cliente');

        console.log(idLote)

        $("#modalBajaVc .modal-body").html('');
        $("#modalBajaVc .modal-footer").html('');

        $.getJSON(general_base_url + "Incidencias/getUserVP/" + idLote)
    .done(function(dtP) {
        $("#modalBajaVc .modal-body").append(`
            <h5>Usuarios en venta principal</h5>
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="flex-grow-1 p-2">
                    <input class="form-control input-gral ng-invalid ng-invalid-required" required readonly="true" value="${dtP[0].asesor}" style="font-size:12px;">
                    <b><p style="font-size:12px; text-align: center;">Asesor</p></b>
                </div>
                <div class="flex-grow-1 p-2">
                    <input class="form-control input-gral ng-invalid ng-invalid-required" required readonly="true" value="${dtP[0].coordinador == '' || dtP[0].coordinador.trim() == '' ? 'NO REGISTRADO' : dtP[0].coordinador}" style="font-size:12px; color:${dtP[0].coordinador == '' || dtP[0].coordinador.trim() == '' ? 'red' : 'black'};">
                    <b><p style="font-size:12px; text-align: center;">Coordinador</p></b>
                </div>
                <div class="flex-grow-1 p-2">
                    <input class="form-control input-gral ng-invalid ng-invalid-required" required readonly="true" value="${dtP[0].gerente}" style="font-size:12px;">
                    <b><p style="font-size:12px; text-align: center;">Gerente</p></b>
                </div>
                <div class="flex-grow-1 p-2">
                    <input class="form-control input-gral ng-invalid ng-invalid-required" required readonly="true" value="${dtP[0].subdirector}" style="font-size:12px;">
                    <b><p style="font-size:12px; text-align: center;">Subdirector</p></b>
                </div>
                <div class="flex-grow-1 p-2">
                    <input class="form-control input-gral ng-invalid ng-invalid-required" required readonly="true" value="${dtP[0].regional == '' || dtP[0].regional.trim() == '' ? 'NO APLICA' : dtP[0].regional}" style="font-size:12px;">
                    <b><p style="font-size:12px; text-align: center;">Regional</p></b>
                </div>
            </div>
        `);

        $("#modalBajaVc .modal-body").append(`
                        <h5>Usuarios en venta compartida</h5>`);
        $.getJSON(general_base_url + "Incidencias/getUserVC/" + idCliente)
            .done(function (data) {
                if (data.length > 0) {
                    data.forEach((item) => {
                        console.log(item.asesor)
                        $("#modalBajaVc .modal-body").append(`
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <div class="flex-grow-1 p-2">
                                <input class="form-control input-gral ng-invalid ng-invalid-required" required readonly="true" value="${item.asesor}" style="font-size:12px;">
                                <b><p style="font-size:12px; text-align: center;">Asesor</p></b>
                            </div>
                            <div class="flex-grow-1 p-2">
                                <input class="form-control input-gral ng-invalid ng-invalid-required" required readonly="true" value="${item.coordinador == '' || item.coordinador.trim() == '' ? 'NO REGISTRADO' : item.coordinador}" style="font-size:12px; color:${item.coordinador == '' || item.coordinador.trim() == '' ? 'red' : 'black'};">
                                <b><p style="font-size:12px; text-align: center;">Coordinador</p></b>
                            </div>
                            <div class="flex-grow-1 p-2">
                                <input class="form-control input-gral ng-invalid ng-invalid-required" required readonly="true" value="${item.gerente}" style="font-size:12px;">
                                <b><p style="font-size:12px; text-align: center;">Gerente</p></b>
                            </div>
                            <div class="flex-grow-1 p-2">
                                <input class="form-control input-gral ng-invalid ng-invalid-required" required readonly="true" value="${item.subdirector}" style="font-size:12px;">
                                <b><p style="font-size:12px; text-align: center;">Subdirector</p></b>
                            </div>
                            <div class="flex-grow-1 p-2">
                                <input class="form-control input-gral ng-invalid ng-invalid-required" required readonly="true" value="${item.regional == '' || item.regional.trim() == '' ? 'NO APLICA' : item.regional}" style="font-size:12px;">
                                <b><p style="font-size:12px; text-align: center;">Regional</p></b>
                            </div>
                            <div class="flex-grow-1 p-2">
                                <button data-toggle="tooltip" data-placement="top"class="btn-data btn-warning bajaVCupdate" title="Eliminar venta compartida" value="${item.id_vcompartida}" data-id_vcompartida="${item.id_vcompartida}" data-lote="${idLote}" data-id_cliente="${item.id_cliente}"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    `);
                    })
                    $('#boton').prop('disabled', true);
                } else {
                    $("#modalBajaVc .modal-body").append(`<h5>No hay ventas compartidas</h5>`);
                }
            });
    });

        $("#modalBajaVc .modal-footer").append(`
          
            <button data-toggle="tooltip" data-placement="top"type="button" class="btn btn-danger btn-simple"  data-dismiss="modal" value="CANCELAR"> CANCELAR</button>
            
        `);
        $("#modalBajaVc").modal();
    
    });

    $(document).on('click', ".bajaVCupdate", function(e){
        $('#boton').prop('disabled', true);
        idLote = $(this).attr('data-lote');
        idVentaC = $(this).attr('data-id_vcompartida');
        idCliente = $(this).attr('data-id_cliente');

        $("#modalBajaVcUpdate .modal-body").html('');
        $("#modalBajaVcUpdate .modal-footer").html('');

        $("#modalBajaVcUpdate .modal-body").append(`
            <h5 style= "text-align: center;">¿Estás seguro de dar de baja esta venta compartida?
            <br><b>Nota.</b> Antes de hacerlo, asegúrate de haber ajustado los <b>porcentajes</b>.</h5>
        `);

        $("#modalBajaVcUpdate .modal-footer").append(`
            <button data-toggle="tooltip" data-placement="top"type="button" class="btn btn-danger btn-simple"  data-dismiss="modal" value="CANCELAR"> CANCELAR</button>
            <button data-toggle="tooltip" data-placement="top"type="button" id="darBajaVenta" onclick="updateVentaC(${idVentaC}, ${idLote}, ${idCliente} )" class="btn btn-gral-data" >
                GUARDAR
            </button> 
        `);
        $("#modalBajaVcUpdate").modal();
        $('#boton').prop('disabled', true);

    });
