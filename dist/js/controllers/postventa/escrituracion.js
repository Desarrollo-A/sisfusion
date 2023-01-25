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

$(document).on('change', '#perj', function (){
        var perJur = $('#perj').val();
        archivosCaptura(perJur);
    })

$(document).on('click', '#print', function () {
    print();
})

$(document).on('click', '#email', function () {
    email();
})

$(document).on('submit', '#formEscrituracion', function (e) {
    $('#perj').prop('disabled', false);
    const nom_id_butt = document.querySelector('.cont-button_apl');
    e.preventDefault();
    loading();
    // $('#'+nom_id_butt.children[0].id).prop('disabled', true);
    // $('#'+nom_id_butt.children[0].id).css('background-color', 'gray');
    let formData = new FormData(this);
    if(nom_id_butt.children[0].id == 'alta_cli'){
        AltaCli(formData);
    }else{
        aportaciones(formData);
    }
})

//Functions
function loading() {
   // $(".fa-spinner").show();
   // $(".btn-text").html("Cargando...");
}

function complete() {
    $(".fa-spinner").hide();
    $(".btn-text").html("Completado");
    $('#spiner-loader').addClass('hide');
}

function aportaciones(data) {
    $('#perj').prop('disabled', false);
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
            $('#spiner-loader').addClass('hide');
            if(response == true){
                alerts.showNotification("top", "right", "Se ha creado la solicitud correctamente.", "success");
                $('#lotes').val('');
                $("#lotes").selectpicker('refresh');
                clearInputs();
                getLotes($('#condominio').val());
              //  $('#aportaciones').prop('disabled', false);
               // $('#aportaciones').css('background-color', '');
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
            $('#spiner-loader').addClass('hide');
            if(response == true){
                alerts.showNotification("top", "right", "Se ha creado la solicitud correctamente.", "success");
                $('#lotes').val('');
                $("#lotes").selectpicker('refresh');
                clearInputs();
                getLotes($('#condominio').val());
                $('#alta_cli').prop('disabled', false);
                $('#alta_cli').css('background-color', '');
                habilitarInputs(true);
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
        perj: $('#perj').val(),
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

function archivosCaptura(personalidad){
if(personalidad == 1){
    $('#documentosPersonalidad').html(`<li><b><h4 class="card-title">Documentos Escrituración Persona Moral</h4></b></li>
    <li><b>1) Acta constitutiva y poder notariado</b>.</li>
    <li><b>2) RFC </b><i>(Cédula o constancia de situación fiscal actual).</i></li>
    <li><b>3) Comprobante de domicilio </b><i>(Luz, agua o telefonía fija con antigüedad menor a 2 meses).</i></li>
    <li><b>4) Boleta predial al corriente y pago retroactivo </b><i>(No obligatorio).</i></li>
    <li><b>5) Constancia de no adeudo mantenimiento </b><i>(No obligatorio).</i></li>
    <li><b>6) Formas de pago <b style="color:red">*</b></b><i>(Todos los comprobantes de pagos a mensualidades / estados de cuenta bancarios).</i></li>
    <li><br></li>
    <li><b><h4 class="card-title">Documentos Escrituración Apoderado Legal</h4></b></li>
    <li><b>1) Identificación oficial vigente</b>.</li>
    <li><b>2) RFC </b><i>(Cédula o constancia de situación fiscal).</i></li>
    <li><b>3) Acta de Nacimiento</b>.</li>
    <li><b>4) Acta de Matrimonio </b><i>(No obligatorio).</i></li>
    <li><b>5) CURP </b><i>(Formato actualizado).</i></li>`);
}else if(personalidad == 2){
    $('#documentosPersonalidad').html(`<li><b><h4 class="card-title">Documentos Escrituración Persona Física</h4></b></li>
    <li><b>1) Identificación oficial vigente</b>.</li>
    <li><b>2) RFC </b><i>(Cédula o constancia de situación fiscal).</i></li>
    <li><b>3) Comprobante de domicilio </b><i>(Luz, agua o telefonía fija con antigüedad menor a 2 meses).</i></li>
    <li><b>4) Acta de Nacimiento</b>.</li>
    <li><b>5) Acta de Matrimonio </b><i>(No obligatorio).</i></li>
    <li><b>6) CURP </b><i>(Formato actualizado).</i></li>
    <li><b>7) Formas de pago <b style="color:red">*</b></b><i>(Todos los comprobantes de pagos a mensualidades / estados de cuenta bancarios).</i></li>
    <li><b>8) Boleta predial al corriente y pago retroactivo </b><i>(No obligatorio).</i></li>
    <li><b>9) Constancia de no adeudo mantenimiento </b><i>(No obligatorio).</i></li>
    <li><b>10) Constancia de no adeudo de agua </b><i>(No obligatorio).</i></li>`);
}else{
    $('#documentosPersonalidad').html('<li><b></b>Sin personalidad juridica asignada</li>');
}
}

function getClient(idLote) {
    getOpcCat('10', ['perj']);
    $('#spiner-loader').removeClass('hide');
    $.post('getClient', {
        idLote: idLote
    }, function (data) {

        archivosCaptura(data.personalidad);

        if(data.bandera_exist_cli){
            habilitarInputs(true);
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

            if(data.personalidad !=0 && data.personalidad != null && data.personalidad != 4){
                $('#perj').prop('disabled', true);
                $("#perj").selectpicker();
                $('#perj').val(data.personalidad);
            }
            else{
                $('#perj').prop('disabled', false);
                $('#personalidad').val(data.personalidad);
            }
                $("#perj").selectpicker('refresh');
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
            $('#check').removeClass("d-none");
        
        }else{
            alerts.showNotification("top", "right", "No se han encontrado los datos del cliente.<br>Por favor ingresar la información requerida.", "warning");
            clearInputs();
            habilitarInputs(false);
            document.getElementById('nombre2').addEventListener('change', NombreCompleto);
            document.getElementById('ape1').addEventListener('change', NombreCompleto);
            document.getElementById('ape2').addEventListener('change', NombreCompleto);            
            //Limpiamos los valores del select corerespondientes al estado civil
            document.getElementById('ecivil').title = '';//pendiente
            document.getElementById('EdoCiv').children[1].children[0].title = '';
            document.getElementById('EdoCiv').children[1].children[0].children[0].innerText = '';
            //Se manda llamar funcion para el llenado del select correspondiente al estado civil de la persona
            getOpcCat('18, 19', ['ecivil', 'rconyugal']);
            //Modificacion al campo de regimen conyugal
            document.getElementById('rconyugal').title = '';
            document.getElementById('RegCon').children[1].children[0].title = '';
            document.getElementById('RegCon').children[1].children[0].children[0].innerText = '';

            document.getElementById('perj').title = '';
            document.getElementById('PerJur').children[1].children[0].title = '';
            document.getElementById('PerJur').children[1].children[0].children[0].innerText = '';

            $('#nombre2').val(data.ncliente);
            $('#ocupacion').val(data.ocupacion);
            $('#origen').val(data.estado);
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
            $('#personalidada').val(data.personalidad);
            /*$('#ecivil').val('');//pendiente, este es el codigo que estaba anteriormente
            //$('#rconyugal').val('');//pendiente
            $('#correo').val('');
            $('#direccionf').val(''); //nosotros insertamos*/
            //let dir = `${data.direccion}, ${data.colonia} ${data.cod_post}`;
            /*$('#direccion').val(''); 
            $('#rfc').val('');
            $('#telefono').val('');
            $('#cel').val('');
            $('#idCliente').val('');
            $('#idPostventa').val('');
            $('#referencia').val(data.referencia);
            $('#empresa').val(data.empresa);
            $('#personalidad').val('');*/
            //$("#estatusL").prop("checked", true);
            $("#perj").selectpicker('refresh');

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
    $('#perj').val('');
    $('#direccionf').val('');
    $('#direccion').val('');
    $('#rfc').val('');
    $('#telefono').val('');
    $('#cel').val('');
    $('#idCliente').val('');
    $('#ape1').val('');
    $('#ape2').val('');
    $('#coloniaf').val('');
    $('#municipiof').val('');
    $('#numIntF').val('');
    $('#numExtF').val('');
    $('#estadof').val('');
    $('#cpf').val('');
    $('#telefono').val('');
    $('#cel').val('');
    $('#calleF').val('');
}
function habilitarInputs(resul){
    if(resul){
        $('#ape1_cli').hide();
        $('#ape2_cli').hide();
        // document.getElementById('per_jur').disabled = resul;
        // $('#perj').prop('disabled',true);
        document.getElementById('nom2_cli').className = "col-md-12 pl-0";
        /*Cambio de id, nombre y etiuqueta del boton del formulario a su estado original */
        const button_apli = document.querySelector('.cont-button_apl');
        button_apli.children[0].id = 'aportaciones';
        button_apli.children[0].children[0].innerText = 'Iniciar Proceso.';
        button_apli.children[0].children[1].innerText = 'Iniciar Proceso.';
    }else{
        //Mostramos campos para apellidos 
        $('#ape1_cli').show();
        $('#ape2_cli').show();
        // $('#per_jur').show();
        //Modificamos el tamaño del div para los tres campos de nombre y apellidos
        document.getElementById('nom2_cli').className = "col-md-4 pl-0";
        /*Cambio de id, nombre y etiuqueta del boton del formulario */
        const button_apli = document.querySelector('.cont-button_apl');
        button_apli.children[0].id = 'alta_cli';
        button_apli.children[0].children[0].innerText= 'Alta de Cliente';
        button_apli.children[0].children[1].innerText = 'Alta de Cliente';
    }
    //Habilita los RadioButton
    document.getElementById('estatusL').disabled = resul;
    document.getElementById('estatusSL').disabled = resul;
    //Habilitamos Todos los campos para el llenado de infodata.lengthrmacion
    document.getElementById('nombre2').disabled = resul;
    document.getElementById('ocupacion').disabled = resul;
    document.getElementById('origen').disabled = resul;
    document.getElementById('ecivil').disabled = resul;
    document.getElementById('rconyugal').disabled = resul;
    document.getElementById('correo').disabled = resul;
    // document.getElementById('perj').disabled = resul;
    document.getElementById('direccion').disabled = resul;

}

function getOpcCat(id_cat, element) {
    for (let index = 0; index < element.length; index++) {
        $("#"+element[index]).find("option").remove();
        $("#"+element[index]).append($('<option disabled selected>').val(null).text("Seleccione una opción"));
    }
    $.post('getOpcCat', {id_cat: id_cat}, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            var etq = data[i]['etq'];
            $("#"+etq).append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            for (let index = 0; index < element.length; index++) {
                $("#"+element[index]).append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
            }
        }
        for (let index = 0; index < element.length; index++) {
            $("#"+element[index]).selectpicker('refresh');
        }
    }, 'json');
}