$(document).ready(function () { //AL CARGAR LA PAGINA LLAMAR FUNCIÓN PARA LLENAR SELECT DE PROYECTOS
    getProyectos();
    $('.collapse').collapse()
})

//JQuery events
$(document).on('change', '#proyecto', function () { //AL CARGAR DE UN PROYECTO LLAMAR FUNCIÓN PARA MOSTRAR LOS CONDOMINIOS DE ESE PROYECTO
    getCondominios($(this).val());
    clearInputs();
})

$(document).on('change', '#condominio', function () { //AL CARGAR DE UN CONDOMINIO LLAMAR FUNCIÓN PARA MOSTRAR LOS LOTES DE ESE CONDOMINIO
    getLotes($(this).val());
    clearInputs(); // LIMPIAR INPUTS AL SELECCIONAR UN CONDOMINIO
})

$(document).on('change', '#lotes', function () { //AL CARGAR DE UN LOTE LLAMAR FUNCIÓN PARA MOSTRAR INFORMACIÓN DEL CLIENTE ASOCIADO A ESE LOTE
    getClient($(this).val());
    clearInputs(); // LIMPIAR INPUTS AL SELECCIONAR UN CONDOMINIO
})

$(document).on('change', '#perj', function (){ // AL SELECCIONAR UNA PERSONALIDAD JURÍDICA, MOSTRAR LA DOCUMENTACIÓN REQUERIDA PARA CADA PERSONALIDAD
        var perJur = $('#perj').val(); //OBTENER EL VALOR SELECCIONADO DEL SELECT
        archivosCaptura(perJur);
    })

$(document).on('click', '#print', function () { //AL DAR CLIC EL BOTON IMPRESIÓN, EJECUTAR FUNCIÓN PARA MOSTRAR LA DOCUMENTACIÓN(PDF) REQUERIDA
    print();
})

$(document).on('click', '#email', function () { //FUNCIÓN PARA ENVIAR POR CORREO LA DOCUMENTACIÓN REQUERIDA (PEDIENTE SI BORRAR O NO)
    email();
})

$(document).on('submit', '#formEscrituracion', function (e) {//EJECUCIÓN DEL SUBMIT DEL FORMULARIO DE SOLICITUDES DE ESCRITURACIÓN
    $('#perj').prop('disabled', false); // DESBLOQUEAMOS EL SELECT DE PERSONALIDAD JURÍDICA PARA OBTENER SU VALOR
    const nom_id_butt = document.querySelector('.cont-button_apl');//SE OBTIENE EL ELEMENTO QUE TIENE LA CLASE SELECCIONADA
    e.preventDefault();
    let formData = new FormData(this);
    //VALIDAMOS SI EL BOTON DEL DEL ELEMENTO TIENE POR ID "alta_cli" ESTO QUIERE DECIR QUE NO EXISTE UN CLIENTE Y SE HACE EL REGISTRO DEL MISMO Y POSTERIOMENTE SE ACTUALIZA EL CLIENTE DEL LOTE Y EL INGRESO DE LA SOLICITUD
    if(nom_id_butt.children[0].id == 'alta_cli'){
        AltaCliente(formData);
    }else{ // DE LO CONTRARIO SI EXISTE EL CLIENTE Y SE REALIZA EL REGISTRO DE LA SOLICITUD
        guardarSolicitud(formData);
    }
})

//Functions
function complete() {  
    $(".fa-spinner").hide();
    $(".btn-text").html("Completado");
    $('#spiner-loader').addClass('hide');
}

function guardarSolicitud(data) { // FUNCIÓN PARA GUARDAR SOLICITUD CUANDO EL LOTE SELECCIONADO SI TIENE UN CLIENTE ASIGNADO
    $('#perj').prop('disabled', false);
    let idLote = $('#lotes').val();
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
                clearInputs();//LIMPIAMOS LOS INTUP DEL FORMULARIO
                getLotes($('#condominio').val());//SE EJECUTA LA FUNCIÓN PARA ACTUALIZAR LA LISTA DE LOTES
            }else{
                alerts.showNotification("top", "right", "Oops, algo salio mal.", "error");
            }
        }
    });
}

function AltaCliente(data){ // FUNCIÓN PARA GUARDAR SOLICITUD CUANDO EL LOTE SELECCIONADO NO TIENE UN CLIENTE ASIGNADO
    let idLote = $('#lotes').val();
    let idCond = $('#condominio').val();
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
                clearInputs();//LIMPIAMOS LOS INTUP DEL FORMULARIO
                getLotes($('#condominio').val());//SE EJECUTA LA FUNCIÓN PARA ACTUALIZAR LA LISTA DE LOTES
                $('#alta_cli').prop('disabled', false);
                $('#alta_cli').css('background-color', '');
                habilitarInputs(true);// SE HABILITAN LOS INPUT UNA VEZ LIMPIADOS
            }else{
                alerts.showNotification("top", "right", "Oops, algo salio mal.", "error");
            }
        }
    });
    
}

function print() { //FUNCIÓN PARA GENERAR PDF DE LA DOCUMENTACIÓN REQUERIDA PARA EL PROCESO DE ESCRITURACIÓN
    let data = $('#lotes').val();
    let bandera_client = $('#bandera_client').val(); // SE VALIDA SI EL LOTE SELECCIONADO TIENE UN CLIENTE ASIGNADO, DE LO CONTRARIO MOSTRAR ALERTA
    if(bandera_client == 'true'){
        window.open("printChecklist/" + data, "_blank")
    }
    else{
        alerts.showNotification("top", "right", "No existe cliente para este lote.", "warning");
    }
}

function email() { //FUCIÓN PARA EVIAR PDF POR MAIL DEL CLIENTE - PENDIENTE SI BORRAR O NO
    let data = getInputData();
    $.post('sendMail', {
        data: data
    }, function (data) {
    }, 'json');
}

function getInputData() { // FUNCIÓN PARA OBTENER LOS VALORES DE LOS INPUT CON LA INFORMACIÓN DEL CLIENTE - PENDIENTE SI BORRAR O NO
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

function NombreCompleto(e){ //FUNCIÓN PARA CONCATENAR LOS INPUT NOMBRE, APELLIDO P. APELLIDO M. CUANDO NO SE TIENE UN CLIENTE ASIGNADO AL LOTE - PENDIENTE SI BORRAR O NO
    var nom_com_cli = $('#nombre2').val() + " " + $('#ape1').val() + " " + $('#ape2').val();
    $('#nombre').val(nom_com_cli.toUpperCase());
    e.target.value = e.target.value.toUpperCase();
}

function archivosCaptura(personalidad){ //FUCIÓN PARA MOSTAR EL LISTADO DE DOCUMENTOS REQUERIDOS PARA EL PROCESO DEPENDIENDO DE LA PERSONALIDAD JURÍDICA SELECCIONADA 
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

function getClient(idLote) { //FUNCIÓN PARA OBTENER LOS DATOS DEL CLIENTE DEPENDIENDO DEL LOTE SELECCIONADO, RECIBE COMO PARAMETRO EL ID DEL LOTE
    getOpcCat('10', ['perj']); // SE LLAMA FUNCIÓN PARA LLENAR SELECT DE PERSONALIDAD JURÍDICA, SE MANDA COMO PARAMETRO EL ID DE CATALOGO Y EL ID DEL SELECT
    $('#spiner-loader').removeClass('hide');
    $.post('getClient', {
        idLote: idLote
    }, function (data) {
        archivosCaptura(data.personalidad); //SE EJECUTA FUNCIÓN PARA MOSTRAR LISTADO DE DOCUMENTACIÓN REQUERIDA DEPENDIENTE LA PERSONALIDAD JURÍDICA
        $('#bandera_client').val(data.bandera_exist_cli); // SE LLENA INPUT CON EL VALOR BOOLEANO SI EXISTE O NO EL CLIENTE DEL LOTE SELECCIONADO
        if(data.bandera_exist_cli){
            habilitarInputs(true);
            $('#nombre').val(data.ncliente);
            $('#nombre2').val(data.ncliente);
            $('#ocupacion').val(data.ocupacion); //pendiente
            $('#origen').val(data.estado);
            //SE LE MUESTRA EL VALOR DEL ESTADO CIVIL OBTENIDO DEL BACK, COMO YA EXISTE EN DB YA NO SE REGISTRA SOLO SE MUESTRA
            document.getElementById('ecivil').title=data.estado_civil;//pendiente
            document.getElementById('ecivil').setAttribute('disabled',true);
            document.getElementById('EdoCiv').children[1].children[0].title = data.estado_civil;
            document.getElementById('EdoCiv').children[1].children[0].children[0].innerText = data.estado_civil;
            document.getElementById('ecivil').removeAttribute('required');
            //SE LE MUESTRA EL VALOR DEL REGIMEN MATRIMONIAL OBTENIDO DEL BACK, COMO YA EXISTE EN DB YA NO SE REGISTRA SOLO SE MUESTRA           
            document.getElementById('rconyugal').title=data.regimen_matrimonial;//pendiente
            document.getElementById('rconyugal').removeAttribute('required');
            document.getElementById('rconyugal').setAttribute('disabled',true);
            document.getElementById('RegCon').children[1].children[0].title = data.regimen_matrimonial;
            document.getElementById('RegCon').children[1].children[0].children[0].innerText = data.regimen_matrimonial;
            //VALIDACIÓN SI LA PERSONALIDAD JURÍDICA VIENE LLENA Y DIFERENTE DE NULL, 0 Y 4 BLOQUEAR EL SELECT PARA YA NO MODIFICARLO
                if(data.personalidad !=0 && data.personalidad != null && data.personalidad != 4){
                    $('#perj').prop('disabled', true);
                    $("#perj").selectpicker();
                    $('#perj').val(data.personalidad);
                }
                else{// DE LO CONTARIO PONERLO ACTIVO PARA PODER SELECCIONAR UNA OPCIÓN
                    $('#perj').prop('disabled', false);
                    $('#personalidad').val(data.personalidad);
                }
            $("#perj").selectpicker('refresh'); 
            $('#correo').val(data.correo.split(',')[0]);
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
            clearInputs();//LIMPIAMOS LOS INTUP DEL FORMULARIO
            habilitarInputs(false); // SE BLOEQUEAN LOS INPUT  
            $('#nombre').val(data.ncliente);
            document.getElementById('nombre2').value = data.nom_cliente;
            document.getElementById('ape1').value = data.app_cliente;
            document.getElementById('ape2').value = data.apm_cliente;            
            //Limpiamos los valores del select corerespondientes al estado civil
            document.getElementById('ecivil').title = '';//pendiente
            document.getElementById('ecivil').setAttribute('required',true);
            document.getElementById('EdoCiv').children[1].children[0].title = '';
            document.getElementById('EdoCiv').children[1].children[0].children[0].innerText = '';
            //Se manda llamar funcion para el llenado del select correspondiente al estado civil de la persona
            getOpcCat('18, 19', ['ecivil', 'rconyugal']);
            //Modificacion al campo de regimen conyugal
            document.getElementById('rconyugal').title = '';
            document.getElementById('rconyugal').setAttribute('required',true);
            document.getElementById('RegCon').children[1].children[0].title = '';
            document.getElementById('RegCon').children[1].children[0].children[0].innerText = '';
            $('#perj').prop('disabled', false);
            document.getElementById('ecivil').disabled = data.estado_civil == null || data.estado_civil ? false : true;
            document.getElementById('rconyugal').disabled = data.regimen_matrimonial == null || data.regimen_matrimonial ? false : true;
            document.getElementById('perj').title = '';
            document.getElementById('PerJur').children[1].children[0].title = '';
            document.getElementById('PerJur').children[1].children[0].children[0].innerText = '';
            $('#ocupacion').val(data.ocupacion);
            $('#origen').val(data.estado);
            $('#correo').val(data.correo.split(',')[0]);
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
            $("#rconyugal").selectpicker('refresh');
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
    $('#valorC').val('');
}

function habilitarInputs(resul){
    if(resul){
        $('#ape1_cli').hide();
        $('#ape2_cli').hide();
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
    document.getElementById('correo').disabled = resul;
    // document.getElementById('perj').disabled = resul;
    document.getElementById('direccion').disabled = resul;
}

function getOpcCat(id_cat, element) {
    for (let index = 0; index < element.length; index++) {
        $("#"+element[index]).find("option").remove();
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