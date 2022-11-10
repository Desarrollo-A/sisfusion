$(document).ready(function () {
    getProyectos();
    $('.collapse').collapse()

})

//JQuery events
$(document).on('change', '#proyecto', function () {
    getCondominios($(this).val());
    clearInputs();
})

$(document).on('change', '#condominio', function () {
    getLotes($(this).val());
    clearInputs();
})

$(document).on('change', '#lotes', function () {
    getClient($(this).val());
    clearInputs();
})

$(document).on('click', '#print', function () {
    print();
})

$(document).on('click', '#email', function () {
    email();
})

$(document).on('submit', '#formEscrituracion', function (e) {
    console.log(e.target);
    const nom_id_butt = document.querySelector('.cont-button_apl');
    e.preventDefault();
    loading();
    $('#'+nom_id_butt.children[0].id).prop('disabled', true);
    $('#'+nom_id_butt.children[0].id).css('background-color', 'gray');
    let formData = new FormData(this);
    if(nom_id_butt.children[0].id == 'alta_cli'){
        AltaCli(formData);
    }else{
        aportaciones(formData);
    }
})

//Functions
function loading() {
    $(".fa-spinner").show();
    $(".btn-text").html("Cargando...");
}

function complete() {
    $(".fa-spinner").hide();
    $(".btn-text").html("Completado");
    $('#spiner-loader').addClass('hide');
}

function aportaciones(data) {
    let idLote = $('#lotes').val();
    let idCliente = $('#idCliente').val();
    let idPostventa = $('#idPostventa').val();
    data.append('idLote', idLote);

    $('#spiner-loader').removeClass('hide');
    $.ajax({
        url: 'aportaciones',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            console.log(response);
            $('#spiner-loader').addClass('hide');
            if(response == true){
                alerts.showNotification("top", "right", "Se ha creado la solicitud correctamente.", "success");
                $('#lotes').val('');
                $("#lotes").selectpicker('refresh');
                clearInputs();
                getLotes($('#condominio').val());
                $('#aportaciones').prop('disabled', false);
                $('#aportaciones').css('background-color', '');
            }else{
                alerts.showNotification("top", "right", "Oops, algo salio mal.", "error");
            }
        }
    });
}

function AltaCli(data) {
    let idLote = $('#lotes').val();
    let idCond = $('#condominio').val();
    let idPostventa = $('#idPostventa').val();
    data.append('idLote', idLote);
    data.append('idCondominio', idCond);
    data.append('nombreComp', $('#nombre').val());
    $('#spiner-loader').removeClass('hide');
    $.ajax({
        url: 'AltaCli',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            console.log(response);
            $('#spiner-loader').addClass('hide');
            if(response == true){
                alerts.showNotification("top", "right", "Se ha creado la solicitud correctamente.", "success");
                $('#lotes').val('');
                $("#lotes").selectpicker('refresh');
                clearInputs();
                getLotes($('#condominio').val());
                $('#alta_cli').prop('disabled', false);
                $('#alta_cli').css('background-color', '');
            }else{
                alerts.showNotification("top", "right", "Oops, algo salio mal.", "error");
            }
        }
    });
}

function print() {
    let data = $('#lotes').val();
    window.open("printChecklist/" + data, "_blank")
}

function email() {
    let data = getInputData();
    $.post('sendMail', {
        data: data
    }, function (data) {

    }, 'json');
}

function getInputData() {
    let data = {
        nombre: $('#nombre').val(),
        nombre2: $('#nombre2').val(),
        ocupacion: $('#ocupacion').val(),
        origen: $('#origen').val(),
        ecivil: $('#ecivil').val(),
        rconyugal: $('#rconyugal').val(),
        correo: $('#correo').val(),
        direccionf: $('#direccionf').val(),
        direccion: $('#direccion').val(),
        rfc: $('#rfc').val(),
        telefono: $('#telefono').val(),
        cel: $('#cel').val()
    }
    return data;
};
function NombreCompleto(e){
    var nom_com_cli = $('#nombre2').val() + " " + $('#ape1').val() + " " + $('#ape2').val();
    $('#nombre').val(nom_com_cli.toUpperCase());
    e.target.value = e.target.value.toUpperCase();
}
function getClient(idLote) {
    $('#spiner-loader').removeClass('hide');
    $.post('getClient', {
        idLote: idLote
    }, function (data) {
        if(data){
            document.getElementById('nom2_cli').className = "col-md-12 pl-0";
            //Habilita los RadioButton
            document.getElementById('estatusL').disabled = true;
            document.getElementById('estatusSL').disabled = true;
            //Habilitamos Todos los campos para el llenado de informacion
            document.getElementById('nombre2').disabled = true;
            document.getElementById('ocupacion').disabled = true;
            document.getElementById('origen').disabled = true;
            document.getElementById('ecivil').disabled = true;
            document.getElementById('rconyugal').disabled = true;
            document.getElementById('correo').disabled = true;
            document.getElementById('direccion').disabled = true;
            $('#ape1_cli').hide();
            $('#ape2_cli').hide();

            $('#ape1').val('');
            $('#ape2').val('');
            $('#nombre').val(data.ncliente);
            $('#nombre2').val(data.ncliente);
            $('#ocupacion').val(data.ocupacion); //pendiente
            $('#origen').val(data.estado);
            //Se le da el valor del select corerespondientes al estado civil
            document.getElementById('ecivil').title=data.estado_civil;//pendiente
            document.getElementById('EdoCiv').children[1].children[0].title = data.estado_civil;
            document.getElementById('EdoCiv').children[1].children[0].children[0].innerText = data.estado_civil;
            //Se le da el valor del select corerespondientes al Regimen Matrimonial            
            document.getElementById('rconyugal').title=data.regimen_matrimonial;//pendiente
            document.getElementById('RegCon').children[1].children[0].title = data.regimen_matrimonial;
            document.getElementById('RegCon').children[1].children[0].children[0].innerText = data.regimen_matrimonial;
            /*Cambio de id, nombre y etiuqueta del boton del formulario a su estado original */
            const button_apli = document.querySelector('.cont-button_apl');
            button_apli.children[0].id = 'aportaciones';
            button_apli.children[0].children[0].innerText = 'Iniciar Proceso.';
            button_apli.children[0].children[1].innerText = 'Iniciar Proceso.';
            //$('#rconyugal').val(data.regimen_matrimonial);//pendiente
            $('#correo').val(data.correo);
            // $('#direccionf').val(); //nosotros insertamos
            let dir = `${data.direccion}, ${data.colonia} ${data.cod_post}`;
            $('#direccion').val(dir); 
            $('#rfc').val(data.rfc);
            $('#telefono').val(data.telefono);
            $('#cel').val(data.tfijo);
            $('#idCliente').val(data.id_cliente);
            $('#idPostventa').val(data.id_dpersonal);
            $('#referencia').val(data.referencia);
            $('#empresa').val(data.empresa);
            data.idEstatus == 8 ? $("#estatusL").prop("checked", true):$("#estatusSL").prop("checked", true);
            $('#personalidad').val(data.personalidad);
            $('#check').removeClass("d-none");
   
        }else{
            document.getElementById('nombre2').addEventListener('change', NombreCompleto);
            document.getElementById('ape1').addEventListener('change', NombreCompleto);
            document.getElementById('ape2').addEventListener('change', NombreCompleto);
             /*$('#lotes').val('');
            $("#lotes").selectpicker('refresh');
            clearInputs();
            getLotes($('#condominio').val());
            alerts.showNotification("top", "right", "No se han encontrado registros.", "danger");*/
            //Habilita los RadioButton
            document.getElementById('estatusL').disabled = false;
            document.getElementById('estatusSL').disabled = false;
            //Habilitamos Todos los campos para el llenado de informacion
            document.getElementById('nombre2').disabled = false;
            document.getElementById('ocupacion').disabled = false;
            document.getElementById('origen').disabled = false;
            document.getElementById('ecivil').disabled = false;
            document.getElementById('rconyugal').disabled = false;
            document.getElementById('correo').disabled = false;
            document.getElementById('direccion').disabled = false;
            //Mostramos campos para apellidos 
            $('#ape1_cli').show();
            $('#ape2_cli').show();
            //Modificamos el tamaño del div para los tres campos de nombre y apellidos
            document.getElementById('nom2_cli').className = "col-md-4 pl-0";
            //Limpiamos valores de cajas de texto
            $('#nombre').val('');
            $('#nombre2').val('');
            $('#ocupacion').val(''); //pendiente
            $('#origen').val('');
            //Limpiamos los valores del select corerespondientes al estado civil
            document.getElementById('ecivil').title = '';//pendiente
            document.getElementById('EdoCiv').children[1].children[0].title = '';
            document.getElementById('EdoCiv').children[1].children[0].children[0].innerText = '';
            //Se manda llamar funcion para el llenado del select correspondiente al estado civil de la persona
            getOpcCat(18, 'ecivil');
            //
            document.getElementById('rconyugal').title = '';
            document.getElementById('RegCon').children[1].children[0].title = '';
            document.getElementById('RegCon').children[1].children[0].children[0].innerText = '';
            getOpcCat(19, 'rconyugal');
            /*document.getElementById('aportaciones').id = 'alta_cli';
            document.getElementById('aportaciones').children[1].innerText = 'Alta Cliente';*/
            /*Cambio de id, nombre y etiuqueta del boton del formulario */
            const button_apli = document.querySelector('.cont-button_apl');
            button_apli.children[0].id = 'alta_cli';
            button_apli.children[0].children[0].innerText = 'Alta de Cliente';
            button_apli.children[0].children[1].innerText = 'Alta de Cliente';
            //$('#ecivil').val('');//pendiente, este es el codigo que estaba anteriormente
            //$('#rconyugal').val('');//pendiente
            $('#correo').val('');
             //$('#direccionf').val(''); //nosotros insertamos
            //let dir = `${data.direccion}, ${data.colonia} ${data.cod_post}`;
            $('#direccion').val(''); 
            $('#rfc').val('');
            $('#telefono').val('');
            $('#cel').val('');
            $('#idCliente').val('');
            $('#idPostventa').val('');
            $('#referencia').val(data.referencia);
            $('#empresa').val(data.empresa);
            $("#estatusL").prop("checked", true);
            $('#personalidad').val('');
            $('#check').removeClass("d-none");
        }
       
        $('#spiner-loader').addClass('hide');

    }, 'json');
}

function getProyectos() {
    $("#condominio").val('');
    $("#condominio").selectpicker('refresh');
    $("#proyecto").find("option").remove();
    $("#proyecto").append($('<option disabled selected>').val(null).text("Seleccione una opción"));
    $.post('getProyectos', function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['nombreResidencial'];
            $("#proyecto").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#proyecto").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#proyecto").selectpicker('refresh');
    }, 'json');
}

function getCondominios(idResidencial) {
    $("#lotes").val('');
    $("#lotes").selectpicker('refresh');
    $('#spiner-loader').removeClass('hide');
    $('#check').addClass("d-none");
    $("#condominio").find("option").remove();
    $("#condominio").append($('<option disabled selected>').val(null).text("Seleccione una opción"));
    $.post('getCondominios', {
        idResidencial: idResidencial
    }, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idCondominio'];
            var name = data[i]['nombre'];
            $("#condominio").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#condominio").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#condominio").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

function getLotes(idCondominio) {
    $('#spiner-loader').removeClass('hide');
    $('#check').addClass("d-none");
    $("#lotes").find("option").remove();
    $("#lotes").append($('<option disabled selected>').val(null).text("Seleccione una opción"));
    $.post('getLotes', {
        idCondominio: idCondominio
    }, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idLote'];
            var name = data[i]['nombreLote'];
            $("#lotes").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#lotes").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#lotes").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
}   

function clearInputs(){
    $('#nombre').val('');
    $('#nombre2').val('');
    $('#ocupacion').val('');
    $('#origen').val('');
    $('#ecivil').val('');
    $('#rconyugal').val('');
    $('#correo').val('');
    $('#direccionf').val('');
    $('#direccion').val('');
    $('#rfc').val('');
    $('#telefono').val('');
    $('#cel').val('');
    $('#idCliente').val('');
}

function getOpcCat(id_cat, element) {
    //$("#ecivil").val('');
    //$("#ecivil").selectpicker('refresh');
    $("#"+element).find("option").remove();
    $("#"+element).append($('<option disabled selected>').val(null).text("Seleccione una opción"));
    $.post('getOpcCat', {id_cat: id_cat}, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#"+element).append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#"+element).append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#"+element).selectpicker('refresh');
    }, 'json');
}