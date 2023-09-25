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

var idLote = 0;

function selectOpcion(){
    id_cliente = document.getElementById("clientes2").value;
    idLote     = document.getElementById("lotes1").value;
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
    else{
        //VENTA COMPARTIDA
        let id_asesor=0;
        $.getJSON( general_base_url + "Incidencias/getUserVC/"+id_cliente).done( function( data ){
            $('#miModalVcNew .vcnew').html('');
            let cuantos = data.length;
            if(cuantos == 0){
                $('#form_vcNew')[0].reset();
                $('#usuarioid6 option').remove(); 
                $('#usuarioid7 option').remove(); 
                $('#usuarioid8 option').remove(); 
                $("#usuarioid6").val('');
                $("#usuarioid7").val('');
                $("#usuarioid6").val('');
                $("#usuarioid6").selectpicker("refresh");
                $('#usuarioid7').val('default');
                $("#usuarioid7").selectpicker("refresh");
                $('#usuarioid8').val('default');
                $("#usuarioid8").selectpicker("refresh");
                $('#miModalVcNew .vcnew').append(`
                <input type="hidden" id="id_lote" value="${idLote}" name="id_lote" >
                <input type="hidden" id="id_cliente" value="${id_cliente}" name="id_cliente" >`);
                $('#usuarioid5 option').remove(); 
                $.post(general_base_url+'Incidencias/getUsuariosRol3/'+7, function(data) {
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id_usuario'];
                        var name = data[i]['name_user'];
                        var id_lider = data[i]['id_lider'];
                        $("#usuarioid5").append($('<option>').val(id+','+id_lider).attr('data-value', id).text(name));
                    }
                    if(len<=0){
                        $("#usuarioid5").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                    }
                    $("#usuarioid6").selectpicker('refresh');
                    $("#usuarioid7").selectpicker('refresh');
                    $("#usuarioid8").selectpicker('refresh');
                    $("#usuarioid5").selectpicker('refresh');
                }, 'json');
                $("#usuarioid5").change(function() {
                    var parent = $(this).val();
                    let id_l = parent.split(',');
                    console.log(id_l);
                    $.post(general_base_url+'Incidencias/getLideres/'+id_l[1], function(data) {
                        $('#usuarioid6 option').remove(); 
                        $('#usuarioid7 option').remove(); 
                        $('#usuarioid8 option').remove(); 
                        $("#usuarioid6").val('');
                        $("#usuarioid7").val('');
                        $("#usuarioid6").val('');
                        $("#usuarioid6").selectpicker("refresh");
                        $('#usuarioid7').val('default');
                        $("#usuarioid7").selectpicker("refresh");
                        $('#usuarioid8').val('default');
                        $("#usuarioid8").selectpicker("refresh");
                        var len = data.length;
                        if(len == 1){
                            var id = data[0]['id_usuario1'];
                            var name = data[0]['name_user'];
                            var id2 = data[0]['id_usuario2'];
                            var name2 = data[0]['name_user2'];
                            var id3 = data[0]['id_usuario3'];
                            var name3 = data[0]['name_user3'];
                            $("#usuarioid6").append($('<option>').val(id).attr('data-value', id).text(name));
                            $("#usuarioid7").append($('<option>').val(id2).attr('data-value', id2).text(name2));
                            $("#usuarioid8").append($('<option>').val(id3).attr('data-value', id3).text(name3));
                        }
                        if(len<=0){
                            $("#usuarioid6").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                            $("#usuarioid7").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                            $("#usuarioid8").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                        }
                        $("#usuarioid6").selectpicker('refresh');
                        $("#usuarioid7").selectpicker('refresh');
                        $("#usuarioid8").selectpicker('refresh');
                    }, 'json');
                }); 
                $('#miModalVcNew').modal('show');
            }
            else if(cuantos == 1){
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
                    $('#miModalVc').modal('show');
            }
            else if(cuantos == 2){
                $('#modal_avisos .modal-body').html('');
                $('#modal_avisos .modal-body').append(`
                <h4><em>Revisar con sistema para esté caso.</em></h4>`);
                $('#modal_avisos').modal('show');
            }
        }); 
    }
}

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
            <table class="table">
            <thead style="font-size:9px;text-align:center;">
            <tr>
                <th>ID LOTE</th>
                <th>LOTE</th>
                <th>COMISIÓN TOTAL</th>
                <th>COMISIÓN TOPADA</th>
                <th>COMISIÓN NUEVO ASESOR</th>
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
        console.log(subdirector);
        console.log(subdirector);
        console.log('subdirector')
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
                    console.log(data[0].id_usuario)    
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
            $('#UserSelectvc').append(`
            <div class="form-check form-check-inline">
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
    let total = parseFloat(precioLote * (por / 100));
    $('#modal_avisos .modal-body').append(`<h4 class="card-title"><b>Revertir cambio</b></h4>`); 
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
    <button type="button" class="btn btn-danger btn-simple"  data-dismiss="modal" value="CANCELAR">
        CANCELAR
    </button>
    <button type="button" onclick="SaveAjusteRegre(${i},${por},${total})" 
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
                    $('#modal_pagadas .modal-body').html('');
                    $("#modal_pagadas").modal('toggle');
                    $('#tabla_incidencias_contraloria').DataTable().ajax.reload();
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "Tipo de venta actualizado", "success");
                }
                else{
                    $('#modal_pagadas .modal-body').html('');
                    $("#modal_pagadas").modal('toggle');
                    $('#tabla_incidencias_contraloria').DataTable().ajax.reload();
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "Algo salio mal", "danger");
                }
            }
        });
    }
}

function Editar(i,precio,id_usuario){
    $('#modal_avisos .modal-body').html('');
    let precioLote = parseFloat(precio);
    let nuevoPorce1 = replaceAll($('#porcentaje_'+i).val(), ',',''); 
    let nuevoPorce = replaceAll(nuevoPorce1, '%',''); 
    let  abonado =  replaceAll($('#abonado_'+i).val(), ',','');
    let id_comision = $('#id_comision_'+i).val();
    let id_rol = $('#id_rol_'+i).val();
    let pendiente = replaceAll($('#pendiente_'+i).val(), ',',''); 
    if(id_rol == 1 || id_rol == 2 || id_rol == 3 || id_rol == 9 || id_rol == 38 || id_rol == 45){
        if(parseFloat(nuevoPorce) > 1 || parseFloat(nuevoPorce) < 0){
            $('#porcentaje_'+i).val(1);
            nuevoPorce=1;
            document.getElementById('msj_'+i).innerHTML = 'Debe ingresar un número entre 0 y 1';
        }
        else{
            document.getElementById('msj_'+i).innerHTML = '';
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
                    console.log(response);
                    $('#modal_avisos .modal-body').append(`<table class="table table-hover">
                    <thead>
                    <tr>
                    <th>ID pago</th>
                    <th>Monto</th>
                    <th>Usuario</th>
                    <th>Estatus</th>
                    </tr>
                    </thead><tbody>`);
                    for( var j = 0; j<len; j++){
                        suma = suma + response[j]['abono_neodata'];
                        $('#modal_avisos .modal-body .table').append(`<tr>
                        <td>${response[j]['id_pago_i']}</td>
                        <td>$${formatMoney(response[j]['abono_neodata'])}</td>
                        <td>${response[j]['usuario']}</td>
                        <td>${response[j]['nombre']}</td>
                        </tr>`);
                    }
                    $('#modal_avisos .modal-body').append(`</tbody></table>`);
                    let nuevoAbono=parseFloat(abonado-suma);
                    let NuevoPendiente=parseFloat(comisionTotal - nuevoAbono);
                    $('#abonado_'+i).val(formatMoney(nuevoAbono));
                    $('#pendiente_'+i).val(formatMoney(NuevoPendiente));
                    if(nuevoAbono > comisionTotal){
                        $('#modal_avisos .modal-body').append('<p>La nueva comisión total <b style="color:green;">$'+formatMoney(comisionTotal)+'</b> es menor a lo abondado <b>$'+formatMoney(nuevoAbono)+'</b> (ya con los pagos eliminados),Se eliminar los pagos mostrados una vez guardado el cambio. <b style="color:red;">Aplicar los respectivos descuentos</b></p>');
                    }
                    else{
                        $('#modal_avisos .modal-body').append('<p>La nueva comisión total es de <b style="color:green;">$'+formatMoney(comisionTotal)+'</b>, se eliminaran los pagos mostrados una vez guardado el ajuste. El nuevo saldo abonado sera de <b>$'+formatMoney(nuevoAbono)+'</b>. <b>No se requiere aplicar descuentos</b> </p>');
                    }
                }
            }
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
    document.getElementById('btn_vc').disabled=false;
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
        $('.buscarLote').click();
    }
}

$('#tabla_incidencias_contraloria thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $( 'input', this ).on('keyup change', function () {
        if ($('#tabla_incidencias_contraloria').DataTable().column(i).search() !== this.value ) {
            $('#tabla_incidencias_contraloria').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
})

$(".buscarLote").click( function() {
    var idLote = $('#inp_lote').val();
    if(idLote != '' ){
    $('#tabla_incidencias_contraloria').removeClass('hide');
    tabla_inventario = $("#tabla_incidencias_contraloria").DataTable({
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
                title: 'Reporte Incidencia por lote',
                exportOptions: {
                    columns: [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                    format: {
                        header:  function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                            }
                        }
                }
            }
        ],
        ajax:{
                "url": general_base_url+'Incidencias/getInCommissions/'+idLote,
                "dataSrc": ""
            },
        pagingType: "full_numbers",
        fixedHeader: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [ 
        {data: 'nombreResidencial'},
        {data: 'nombreCondominio'},
        {data: 'nombreLote'},
        {data: 'idLote'}, 
        {data: 'nombre_cliente'}, 
        { data: function (d) {
            var labelTipoVenta;
            if(d.tipo_venta == 1) {
                labelTipoVenta ='<span class="label lbl-orageYellow" >Particular</span>';
            }else if(d.tipo_venta == 2) {
                labelTipoVenta ='<span class="label lbl-green" >Normal</span>';
            }else if(d.tipo_venta == 7) {
                labelTipoVenta ='<span class="label lbl-violetDeep" >Especial</span>';
            }else{
                labelTipoVenta ='<span class="label lbl-gray" >Sin Definir</span>';
            }
            return labelTipoVenta;
        }},  
        { data: function (d) {
            var labelCompartida;
            if(d.compartida == null) {
                labelCompartida ='<span class="label lbl-yellow" >Individual</span>';
            } else{
                labelCompartida ='<span class="label lbl-orangeYellow">Compartida</span>';
            }
            return labelCompartida;
        }}, 
        { data: function (d) {
            var labelStatus;
            if(d.idStatusContratacion == 15) {
                labelStatus ='<span class="label lbl-violetDeep">Contratado</span>';
            }else {
                labelStatus ='<span class="label lbl-gray"><b>'+d.idStatusContratacion+'</b></span>';
            }
            return labelStatus;
        }},
        { data: function (d) {
            var labelEstatus;
            if(d.totalNeto2 == null) {
                labelEstatus ='<p class="m-0"><b>Sin Precio Lote</b></p>';
            }else if(d.registro_comision == 2){
                labelEstatus ='<span class="label lbl-sky">SOLICITADO MKT</span>'+' '+d.plan_descripcion;
            }else {
                labelEstatus =`<span onclick="showDetailModal(${d.plan_comision})" style="cursor: pointer;">${d.plan_descripcion}</span>`;
            }
            return labelEstatus;
        }},
        
        { data: function (d) {
            var ultima_dispersion;
            if( d.ultima_dispersion == null ) {
                ultima_dispersion ='<span class="label lbl-deepGray">Sin Definir</span>';
            }else {
                ultima_dispersion = '<br><span class="label lbl-lightBlue">'+d.ultima_dispersion+'</span>';
            }
            return ultima_dispersion;
        }} ,
        { data: function (d) {
            var fechaNeodata;
            var rescisionLote;
            fechaNeodata = '<br><span class="label lbl-cerulean">'+d.fecha_neodata+'</span>';
            rescisionLote = '';
            if(d.fecha_neodata <= '01 OCT 20' || d.fecha_neodata == null ) {
                fechaNeodata = '<span class="label lbl-gray">Sin Definir</span>';
            } 
            if (d.registro_comision == 8){
                rescisionLote = '<br><span class="label lbl-warning">Recisión Nueva Venta</span>';
            }
            return fechaNeodata+rescisionLote;
        }},
        {
            "width": "8%",
            "data": function( d ){
                var lblStats = '';
                switch(d.registro_comision){
                    case 7:
                        lblStats ='<span class="label lbl-warning">LIQUIDADA</span>';
                    break;
                    
                    case 1:
                        lblStats ='<span class="label lbl-sky">COMISIÓN ACTIVA</span>';
                    break;
                    case 8:
                        lblStats ='<span class="label lbl-blueMaderas">NUEVA, rescisión</span>';
                    break;

                    case 0:
                        lblStats ='<span class="label lbl-blueMaderas">NUEVA, sin dispersar</span>';
                    break;

                    default:
                        lblStats ='-';
                    break;
                }
                return lblStats;      
            }
        },
        
 
        { 
            "width": "20%",
            "orderable": false,
            "data": function( data ){
                var BtnStats ='';
                if(data.totalNeto2==null && data.idStatusContratacion > 8 ) {
                    BtnStats += '<button class="btn-data btn-sky cambiar_precio" title="Cambiar precio" value="' + data.idLote +'" data-precioAnt="'+data.totalNeto2+'"><i class="fas fa-pencil-alt"></i></button>';
                    if(data.tipo_venta == 'null' || data.tipo_venta == 0  || data.tipo_venta == null){
                        BtnStats += '<button href="#" value="'+data.idLote+'" data-nombre="'+data.nombreLote+'" data-tipo="'+data.tipo+'" data-tipo="I" class="btn-data btn-orangeYellow tipo_venta" title="Cambiar tipo de venta"><i class="fas fa-map-marker-alt"></i></button>';
                    }
                  
                }
                else {
                    if(data.registro_comision == 0 || data.registro_comision == 8) {
                        BtnStats += '<button class="btn-data btn-sky cambiar_precio" title="Cambiar precio" value="' + data.idLote +'" data-precioAnt="'+data.totalNeto2+'"><i class="fas fa-pencil-alt"></i></button>';
                        if(data.tipo_venta == 'null' || data.tipo_venta == 0 || data.tipo_venta == null){
                            BtnStats += '<button href="#" value="'+data.idLote+'" data-nombre="'+data.nombreLote+'" data-tipo="'+data.tipo+'" data-tipo="I" class="btn-data btn-orangeYellow tipo_venta" title="Cambiar tipo de venta"><i class="fas fa-map-marker-alt"></i></button><button href="#" value="'+data.idLote+'" data-idLote="'+data.idLote+'"  data-cliente="'+data.id_cliente+'" data-sedesName="'+data.sede+'"  data-sedes="'+data.id_sede+'" data-nombre="'+data.nombreLote+'" data-tipo="'+data.tipo+'" data-tipo="1" class="btn-data btn-violetDeep cambioSede"  title="Cambio de sede"> <i class="fas fa-map-signs"></i> </button> '

                        }     
                    }
                    else if(data.registro_comision == 7 ) {
                        BtnStats = '<button class="btn-data btn-sky cambiar_precio" title="Cambiar precio" value="' + data.idLote +'"  data-precioAnt="'+data.totalNeto2+'"><i class="fas fa-pencil-alt"></i></button><button class="btn-data btn-orangeYellow update_bandera" title="Cambiar estatus" value="' + data.idLote +'" data-nombre="'+data.nombreLote+'"><i class="fas fa-sync-alt"></i></button>';
                        BtnStats += '<button class="btn-data btn-green inventario"  title="Cambiar usuarios" value="' + data.idLote +'" data-registro="'+data.registro_comision+'" data-cliente="'+data.id_cliente+'" data-precioAnt="'+data.totalNeto2+'"><i class="fas fa-user-plus"></i></button>';

                    }
                    else if(data.registro_comision == 1 ) {
                        BtnStats = '<button href="#" value="'+data.idLote+'" data-estatus="'+data.idStatusContratacion+'" data-tipo="I" data-precioAnt="'+data.totalNeto2+'"  data-value="'+data.registro_comision+'" data-code="'+data.cbbtton+'" ' +
                        'class="btn-data btn-gray verify_neodata" title="Ajustes"><i class="fas fa-wrench"></i></button><button class="btn-data btn-sky cambiar_precio" title="Cambiar precio" value="' + data.idLote +'"  data-precioAnt="'+data.totalNeto2+'"><i class="fas fa-pencil-alt"></i></button>';
                        BtnStats += '<button class="btn-data btn-green inventario"  title="Cambiar usuarios" value="' + data.idLote +'" data-registro="'+data.registro_comision+'" data-cliente="'+data.id_cliente+'" data-precioAnt="'+data.totalNeto2+'"><i class="fas fa-user-plus"></i></button>';

                    }
                    else {
                        BtnStats = '<button href="#" value="'+data.idLote+'" data-estatus="'+data.idStatusContratacion+'" data-tipo="I" data-precioAnt="'+data.totalNeto2+'"  data-value="'+data.registro_comision+'" data-code="'+data.cbbtton+'" ' +
                        'class="btn-data btn-gray verify_neodata" title="Ajustes"><i class="fas fa-wrench"></i></button><button class="btn-data btn-sky cambiar_precio" title="Cambiar precio" value="' + data.idLote +'" data-precioAnt="'+data.totalNeto2+'"><i class="fas fa-pencil-alt"></i></button><button class="btn-data btn-orangeYellow update_bandera" title="Cambiar estatus" value="' + data.idLote +'" data-nombre="'+data.nombreLote+'"><i class="fas fa-sync-alt"></i></button>';
                        BtnStats += '<button class="btn-data btn-green inventario"  title="Cambiar usuarios" value="' + data.idLote +'" data-registro="'+data.registro_comision+'" data-cliente="'+data.id_cliente+'" data-precioAnt="'+data.totalNeto2+'"><i class="fas fa-user-plus"></i></button>';  
                    
                    }
                }
                return '<div class="d-flex justify-center">'+BtnStats+'</div>';
            }
        }
    ]
    });
    }
    else{
        alerts.showNotification("top", "right", "Ingresa el ID de un lote.", "danger");
    }

    $("#tabla_incidencias_contraloria tbody").on("click", ".cambiar_precio", function(){
        var tr = $(this).closest('tr');
        var row = tabla_inventario.row( tr );
        idLote = $(this).val();
        precioAnt = $(this).attr("data-precioAnt");
        if(precioAnt == 'null'){
            precioAnt=0;
        }
        $("#modal_pagadas .modal-body").html("");
        $("#modal_pagadas .modal-footer").html("");

        $("#modal_pagadas .modal-body").append('<h4 class="modal-title">Cambiar precio del lote <b>'+row.data().nombreLote+'</b></h4><br><em>Precio actual: $<b>'+formatMoney(precioAnt)+'</b></em>');
        $("#modal_pagadas .modal-body").append('<input type="hidden" name="idLote" id="idLote" readonly="true" value="'+idLote+'"><input type="hidden" name="precioAnt" id="precioAnt" readonly="true" value="'+precioAnt+'">');
        $("#modal_pagadas .modal-body").append(`<div class="form-group">
        <label class="control-label" >Nuevo precio</label>
        <input type="text" name="precioL" onblur="verificar(${precioAnt})" required id="precioL" class="form-control input-gral">
        <p id="msj" style="color:red;"></p>
        </div>`);

        $("#modal_pagadas .modal-footer").append(`
            <button type="button" class="btn btn-danger btn-simple" id="btn-cancelar" name="btn-cancelar"  data-dismiss="modal" value="CANCELAR"> CANCELAR</button>
            <button type="submit" disabled id="btn-save" class="btn btn-gral-data" value="GUARDAR">GUARDAR</button>
            `);
        $("#modal_pagadas").modal();
    });
    
    $("#tabla_incidencias_contraloria tbody").on("click", ".tipo_venta", function(){
        var tr = $(this).closest('tr');
        var row = tabla_inventario.row( tr );
        idLote = $(this).val();

        tipo = $(this).attr("data-tipo");
        let ventaTipo 
        if(tipo == 'null' || tipo == undefined ){
            ventaTipo = 'Sin tipo de venta';
        }else{
            ventaTipo = tipo;
        }
        $("#modal_pagadas .modal-body").html("");
        $("#modal_pagadas .modal-footer").html("");
        $("#modal_pagadas .modal-body").append(`<h4 class="modal-title">Cambiar tipo de venta del lote <b>${row.data().nombreLote}</b></h4><br><em>Tipo de venta actual: <b>${ ventaTipo }</b></em>`);
        $("#modal_pagadas .modal-body").append(`<input type="hidden" name="idLote" id="idLote" readonly="true" value="${idLote}"><input type="hidden" name="precioAnt" id="precioAnt" readonly="true" value="">
        `);
        $("#modal_pagadas .modal-body").append(`
        <div class="form-group">
        <label  class="label">Seleccionar tipo de venta</label>
        <select class="form-control  select-gral tipo_v" id="tipo_v" name="tipo_v"
        title="SELECCIONA UNA OPCIÓN" required data-live-search="true">
        <option value="1">Venta de particulares</option>
        <option value="2">Venta normal</option>
        </select>
        </div> ` );

        $("#modal_pagadas .modal-footer").append( ` 
            <div class="col-md-12">
                <button type="button" class="btn btn-danger btn-simple"  data-dismiss="modal" >
                CANCELAR
                </button>
                <button type="button" onclick="saveTipo(${idLote})" class="btn btn-gral-data" >
                GUARDAR
                </button> 
            </div>`);
        $("#modal_pagadas").modal();
    });

    /**-------------------INVENTARIO------------------------------- */
    $("#tabla_incidencias_contraloria tbody").on("click", ".inventario", function(e){
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
        if(registro_comision == 0){
            // $("#modal_inventario .seleccionar").html('');
            $('#modal_inventario .seleccionar').append(`
                <h4><em>El lote seleccionado aun no esta comisionando, revisarlo con caja</em></h4>`);
            $("#modal_inventario").modal();
        }
        else{ 
            document.getElementById("lotes1").value = (idLote);
            document.getElementById("clientes2").value = (id_cliente);
            $("#modal_avisitos").modal();
        }                      
    }); 

    $("#tabla_incidencias_contraloria tbody").on("click", ".verify_neodata", function(e){
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
        $("#modal_NEODATA .modal-header").html("");
        $("#modal_NEODATA .modal-body").html("");
        $("#modal_NEODATA .modal-footer").html("");
        $.getJSON( general_base_url + "ComisionesNeo/getStatusNeodata/"+idLote).done( function( data ){
            if(data.length > 0){
                switch (data[0].Marca) {
                    case 0:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>En espera de próximo abono en NEODATA de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case 1:
                        if(registro_status==0 || registro_status==8){//COMISION NUEVA
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
                                    
                                    $("#modal_NEODATA .modal-body").append(`
                                        <div class="row">
                                            <div class="col-md-2">
                                                <p style="font-zise:10px;">
                                                    <b>USUARIOS</b></p>
                                            </div>
                                            <div class="col-md-1">
                                                <b>%</b>
                                            </div>
                                            <div class="col-md-2">
                                                <b>TOT. COMISIÓN</b>
                                            </div>
                                            <div class="col-md-2">
                                                <b><b>ABONADO</b>
                                            </div>
                                            <div class="col-md-2">
                                                <b>PENDIENTE</b>
                                            </div>
                                            <div class="col-md-3">ACCIONES
                                            </div>
                                        </div>`);
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
                                        let boton = `
                                        <button type="button" id="btn_${i}" 
                                        ${(id_usuario_general != 1 && id_usuario_general != 2767 && id_usuario_general != 2826 && id_usuario_general != 4878 && id_usuario_general != 5957 && id_usuario_general != 2749) ? 'style="display:none" ' : 'style="display:show" '} 
                                        onclick="SaveAjuste(${i})" ${v.descuento == 1 || v.descuento > 1  ? 'style="display:none" ' : 'style="display:show" ' }  
                                        data-toggle="tooltip" disabled
                                        data-placement="top" title="GUARDAR PORCENTAJE" class="btn btn-dark btn-round btn-fab btn-fab-mini"><span class="material-icons">check</span>
                                        </button>`;
                                        // boton topar
                                        let boton_topar = `
                                        <button type="button" id="btnTopar_${i}"  data-toggle="tooltip"
                                        data-placement="top" title="TOPAR COMISIÓN" 
                                        ${v.descuento == 1 || v.descuento > 1 ? 'style="display:none" ' : 'style="display:show" '} 
                                        onclick="Confirmacion(${i} ,'${v.colaborador}')" class="btn btn-danger btn-round btn-fab btn-fab-mini">
                                        <span class="material-icons">pan_tool</span>
                                        </button>`;
                                        // boton  regresar 
                                        let boton_regresar = `
                                        <button type="button" id="btnReload_${i}"  data-toggle="tooltip" 
                                        data-placement="top" 
                                        ${v.descuento == 0 || v.descuento > 1 ? 'style="display:none" ' : 'style="display:show" '} 
                                        title="Regresar" onclick="Regresar(${i}, ${v.porcentaje_decimal},'${v.colaborador}','${v.id_rol_general}',${data1[0].totalNeto2})" 
                                        class="btn btn-dark btn-info btn-fab btn-fab-mini"><span class="material-icons">cached</span>
                                        </button>`;
                                        // botton pago
                                        let boton_pago = `
                                        <button type="button" id="btnAdd_${i}"  data-toggle="tooltip" 
                                        data-placement="top" title="AGREGAR PAGO" 
                                        ${v.descuento == 1 || v.descuento > 1  ? 'style="display:none" ' : 'style="display:show" '} 
                                        onclick="AgregarPago(${i}, ${pending},'${v.colaborador}','${v.rol}')" 
                                        class="btn btn-dark btn-success btn-fab btn-fab-mini"><span class="material-icons">add</span>
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
                                        <input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="${v.colaborador}" 
                                            style="font-size:12px; ${v.descuento == 1 ? 'color:red;' : ''} "><b>
                                            <p style="font-size:12px; ${v.descuento == 1 ? 'color:red;' : ''} ">${ v.descuento == "1" ? v.rol+' Incorrecto' : v.rol}</b>
                                            <b style="color:${v.descuento > 1 && v.observaciones != 'COMISIÓN CEDIDA'  ? 'red' : 'green'}; 
                                            font-size:10px;">${v.observaciones == 'COMISIÓN CEDIDA' ? '(COMISIÓN CEDIDA)' : ''} ${v.descuento > 1 && v.observaciones != 'COMISIÓN CEDIDA'  ? '(CEDIÓ COMISIÓN)' : ''}<b></p>
                                        </div>
                                        <div class="col-md-1">
                                        <input class="form-control ng-invalid ng-invalid-required" ${(id_usuario_general != 1 && id_usuario_general != 2767 && id_usuario_general != 2826 && id_usuario_general != 4878 && id_usuario_general != 5957 && id_usuario_general != 2749) ? 'readonly="true"' : ''} style="${v.descuento == 1 ? 'color:red;' : ''}" ${v.descuento == 1 || v.descuento > 1 ? 'disabled' : ''} id="porcentaje_${i}" ${(v.rol_generado == 1 || v.rol_generado == 2 || v.rol_generado == 3 || v.rol_generado == 9 || v.rol_generado == 45 || v.rol_generado == 38) ? 'max="1"' : 'max="4"'}   onblur="Editar(${i},${precioAnt},${v.id_usuario})" value="${parseFloat(v.porcentaje_decimal)}">
                                        <input type="hidden" id="porcentaje_ant_${i}" name="porcentaje_ant_${i}" value="${v.porcentaje_decimal}"><br>
                                        <b id="msj_${i}" style="color:red;"></b>
                                        </div>
                                        <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" style="${v.descuento == 1 ? 'color:red;' : ''}" readonly="true" id="comision_total_${i}" value="${formatMoney(v.comision_total)}"></div>
                                        <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" style="${v.descuento == 1 ? 'color:red;' : ''}" readonly="true" id="abonado_${i}" value="${formatMoney(v.abono_pagado)}"></div>
                                        <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required readonly="true"  id="pendiente_${i}" value="${formatMoney(v.comision_total-v.abono_pagado)}"></div>
                                        <div class="col-md-3 botones">
                                        ${(id_usuario_general != 1 && id_usuario_general != 2767 && id_usuario_general != 2826 && id_usuario_general != 4878 && id_usuario_general != 5957 && id_usuario_general != 2749) ? '' : boton}  
                                        ${boton_topar}
                                        ${boton_pago}
                                        ${boton_regresar}
                                        </div>
                                        </div> `);
                                        counts++
                                    });
                                });
                                $("#modal_NEODATA .modal-footer").append('<div class="row"><div class="col-md-3"></div><div class="col-md-3"></div><div class="col-md-3"></div></div>');
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
                    break;
                    case 3:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No tiene vivienda, si hay referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case 4:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No hay pagos aplicados a esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case 5:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Referencia duplicada de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    default:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Sin localizar.</b></h4><br><h5>Revisar con sistemas: '+row.data().nombreLote+'.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        
                    break;
                }
            }
            else{
                $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><b>No se encontró esta referencia en NEODATA de '+row.data().nombreLote+'.</b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
            }
        });
        $("#modal_NEODATA").modal();
    });

});

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
    $("#myUpdateBanderaModal .modal-header").append('<h4 class="card-title"><b>Regresar a activas</b></h4>');
    $("#myUpdateBanderaModal .modal-body").append( ` <div id="inputhidden"><p>¿Está seguro de regresar el lote <b>${nombre}</b> a activas?</p> <input type="hidden" name="id_pagoc" id="id_pagoc"><input type="hidden" name="param" id="param">`);
    $("#myUpdateBanderaModal .modal-footer").append(`
    <div class="row">
    <div class="col-md-12" style="align-content: left;">
    <button type="button" class="btn btn-danger btn-simple " data-dismiss="modal">
    CANCELAR
    </button>
    <button type="submit" class="btn btn-gral-data" value="ACEPTAR" style="margin: 15px;">
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
                $('#tabla_incidencias_contraloria').DataTable().ajax.reload();
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
        $('#btn-save').prop('disabled', true);
        $('#btn-cancelar').prop('disabled', true);
        $("#btn-save").hide(1000);
        $("#btn-cancelar").hide(1000);
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

                    $('#tabla_incidencias_contraloria').DataTable().ajax.reload();
               
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
    if(id_rol_general == 13 || id_rol_general == 8 || id_rol_general == 17){
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
    if(id_rol_general == 13 || id_rol_general == 17 || id_rol_general == 8){
        console.log(parseFloat(precioAct).toFixed(2));
    console.log(parseFloat(precioAnt).toFixed(2));
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
    $("#modal_avisos .modal-header").append('<h4 class="card-title"><b></b></h4>');
    $("#modal_avisos .modal-body").append(`
        <div id="inputhidden">
            <label class="lbl-gral" >¿Estás seguro de DETENER la comisión al usuario <b>${name}</b>?<br><br>
            <b>NOTA:</B> El cambio ya no se podrá revertir.</label>
            <div class="form-group">
                <textarea id="comentario_topaT_${i}" name="comentario_topaT_${i}" class="form-control input-gral" rows="3" 
                    required placeholder="Describe el motivo por el cual se detendrán los pagos de esta comisión">
                </textarea>
            </div>
        </div>`);
    $("#modal_avisos .modal-footer").append(`
            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR
            </button>
            <button type="submit"  onclick="ToparComision(${i})"  class="btn btn-gral-data" value="ACEPTAR" style="margin: 15px;">
            ACEPTAR
        </button>
            `);
    $('#modal_avisos').modal('show');
}

// aqui falta crear la function para validar que no existan menores.
function validar()
{
//    var input1 = document.getElementById();   

}

// 
function AgregarPago(i,pendiente,colab,id_rol_general){
    $('#modal_add .modal-header').html(''); 
    $('#modal_add .modal-body').html(''); 
    $('#modal_add .modal-footer').html(''); 
    let comisionTotal = replaceAll($('#comision_total_'+i).val(), ',','');
    let comision1  = replaceAll(comisionTotal, '$','');

    console.log(comisionTotal)
    let abonado = replaceAll($('#abonado_'+i).val(), ',','');
    let abono1  = replaceAll(abonado, '$','');

    let cosos2 = (comision1 - abono1);
    
    let pendiente2 = (cosos2.toFixed(3));

    pendiente=pendiente2;
    // toFixed(2); 
    $("#modal_add .modal-header").append('<h4 class="card-title"><b>Agregar Pago</b></h4>');
    $("#modal_add .modal-body").append(`
    <div id="inputhidden"><p>El monto no puede ser mayor a <b>${formatMoney(pendiente)}</b> para el <b>
    ${id_rol_general} - ${colab} </b> , en caso de ser mayor válida si hay algún pago en <b>NUEVAS</b> que puedas quitar.</p>
        <div class="form-group">
            <input id="monotAdd" name="monotAdd" min="1" class="form-control input-gral"  type="number" onblur="verifica_pago(${pendiente})" placeholder="Monto a abonar" maxlength="6"/>
            <p id="msj2" style="color:red;"></p>
            <br>
            <textarea id="comentario_topa" name="comentario_topa" class="form-control input-gral" rows="3" required placeholder="Describe el motivo por el cual se agrega este pago">
            </textarea>
        </div>
    </div>`);
    $("#modal_add .modal-footer").append(`
        <button type="button" class="btn btn-danger btn-simple"  data-dismiss="modal" value="CANCELAR">
        CANCELAR
        </button>
        <button type="button" onclick="GuardarPago(${i})" class="btn btn-gral-data" disabled  id="btn-save2" value="ACEPTAR">
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
            console.log(JSON.parse(response));
            console.log(JSON.parse(response).length)
            var len =JSON.parse(response).length; //response.length;
            console.log(len);
            response = JSON.parse(response);
            if(len == 0){
                // document.getElementById('btnTopar_'+i).disabled = true;
                $("#btnTopar_"+i).hide(1500); 
                // document.getElementById('btn_'+i).disabled = true;
                $("#btn_"+i).hide(1500); 
                // document.getElementById('btnAdd_'+i).disabled = true;
                $("#btnAdd_"+i).hide(1500);
                console.log('1');
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
                $('#modal_NEODATA').modal('hide');
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
                console.log('2');
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
                    $('#modal_avisos .modal-body').append('<center><button type="button" class="btn btn-primary" data-dismiss="modal">ENTENDIDO</button></center>');
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
    document.getElementById('btn_'+i).disabled=true;
    
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
                // $('#tabla_incidencias_contraloria').DataTable().ajax.reload(null, false);
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
                $('#tabla_incidencias_contraloria').DataTable().ajax.reload();
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
                $('#tabla_incidencias_contraloria').DataTable().ajax.reload();
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
    e.preventDefault();
    document.getElementById('btn_vc').disabled=true;
    if( $('#usuarioid6').val() != 0 && $('#usuarioid7').val() != 0 && $('#usuarioid8').val() != 0){
    let formData = new FormData(document.getElementById("form_vcNew"));
    $.ajax({
        url: general_base_url+'Incidencias/AddVentaCompartida',
        data: formData,
        method: 'POST',
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {
            console.log(data);
            if (data == 1) {
                $('#form_vcNew')[0].reset();
                $('#tabla_incidencias_contraloria').DataTable().ajax.reload();
                $('#usuarioid5').val('default');
                $("#usuarioid5").selectpicker("refresh");
                $('#usuarioid6').val('default');
                $("#usuarioid6").selectpicker("refresh");
                $('#usuarioid7').val('default');
                $("#usuarioid7").selectpicker("refresh");
                $('#miModalVcNew').modal('toggle');
                alerts.showNotification("top", "right", "Datos actualizados.", "success");
                document.getElementById('btn_vc').disabled=false;
                document.getElementById('UserSelectvc').innerHTML = '';
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
    $('#tabla_incidencias_contraloria').DataTable().ajax.reload();
    nombreLote  = $(this).attr("data-nombre");
    nombreSede  = $(this).attr("data-sedesName");
    idSedes     = $(this).attr("data-sedes");
    cliente    = $(this).attr("data-cliente");
    idLote    = $(this).attr("data-idLote");
    tipoLote    = $(this).attr("data-tipo");
    if (idSedes == 0){
        nombreSede = "Sin sede";
    }
    $("#tituloLote").append( `  <div id="sedes"><p>Selecciona la nueva sede del lote <b>${nombreLote}</b> </p>`);
    $('#sedeOld').append(`      <span class="card-title"> Sede actual :  <b>${nombreSede} </b></span>`);
    $("#modal_sedes").modal();
});

$("#form_sede").submit(function(e) {;
    e.preventDefault();
}).validate({
    submitHandler: function(form) {
        var data = new FormData($(form)[0]);
        data.append('cliente', cliente);
        data.append('idLote', idLote);
        
        console.log(data);
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
                $("#sedeOld").html('')
                $('#modal_sedes').modal('hide');
                $('#tabla_incidencias_contraloria').DataTable().ajax.reload();
            },
            error: function() {
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});

