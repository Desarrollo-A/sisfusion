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
    e.preventDefault();
    // loading();
    $('#aportaciones').prop('disabled', true);
    $('#aportaciones').css('background-color', 'gray');
    let formData = new FormData(this);
    aportaciones(formData);
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

function getClient(idLote) {
    $('#spiner-loader').removeClass('hide');
    $.post('getClient', {
        idLote: idLote
    }, function (data) {
        console.log(data);
        if(data){
            $('#nombre').val(data.ncliente);
            $('#nombre2').val(data.ncliente);
            $('#ocupacion').val(data.ocupacion); //pendiente
            $('#origen').val(data.estado);
            $('#ecivil').val(data.estado_civil);//pendiente
            $('#rconyugal').val(data.regimen_matrimonial);//pendiente
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
            $('#lotes').val('');
            $("#lotes").selectpicker('refresh');
            clearInputs();
            getLotes($('#condominio').val());
            alerts.showNotification("top", "right", "No se han encontrado registros.", "danger");
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