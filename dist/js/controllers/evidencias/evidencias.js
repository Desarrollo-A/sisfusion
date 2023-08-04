$(document).ready(function(){    
    getResidenciales();
    $('.iconCopy').tooltip({
        trigger: 'manual'
    });
})

$(document).on('change', "#residenciales", function () {
    $('#basic_info').addClass('hide');
    $('#generate').addClass('hide');
    getCondominios($(this).val());
});

$(document).on('change', "#condominios", function () {
    $('#basic_info').addClass('hide');
    $('#generate').addClass('hide');
    getLotes($(this).val());
});

$(document).on('change', "#lotes", function () {
    $("#url").val('');
    $('#copy_button').addClass('hide');
    $('#evidencia').addClass('hide');
    $('#generate').addClass('hide');
    getClient($(this).val());
});

$(document).on('click', "#generate", function () {
    let obj = {
        idLote: $('#idLote').val(),
        idCliente: $('#idCliente').val(),
        nombreCl: $('#nombreCl').val(),
        nombreAs: $('#nombreAs').val(),
        fechaApartado: $('#fechaApartado').val(),
        nombreResidencial: $('#nombreResidencial').val(),
        nombreCondominio: $('#nombreCondominio').val(),
        nombreLote: $('#nombreLote').val(),
    }
    console.log('obj', obj);
    if(obj.idCliente==''){
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }else{
        generateToken(obj);
    }
});

$(document).on('click', '.iconCopy',function(){
    copyToClipboard();
})

$(document).on('click', '#view',function(){
    verEvidencia();
})



function cleanSelects(action) {
    if (action == 1) { // MJ: CHANGE RESIDENCIALES
        $("#condominios").selectpicker("refresh");
        $("#lotes").empty().selectpicker('refresh');
        $("#columns").val('');
    } else if (action == 2 || action == 3 || action == 4) {
        $("#columns").val('');
        $("#columns").selectpicker("refresh");
    }
}

function getClient(idLote){
    $('#spiner-loader').removeClass('hide');
    $.ajax({
        url: "getClient",
        data: {idLote: idLote},
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            $('.nombreCl').text(response.nombre);
            $('.nombreAs').text(response.nombreAsesor);
            $('.fechaApartado').text(response.fechaApartado);
            $('.monto').text(response.totalLote);
            $('.enganche').text(response.engancheValidado);
            $('.estatus_comision').text(response.estatus_comision);
            $('.estatus_lote').text(response.estatus_lote);
            $('.estatus_contratacion').text(response.nombreStatus);
            $('#idLote').val(idLote);
            $('#idCliente').val(response.id_cliente);
            $('#nombreCl').val(response.nombre);
            $('#nombreAs').val(response.nombreAsesor);
            $('#nombreResidencial').val(response.nombreResidencial);
            $('#nombreCondominio').val(response.nombreCondominio);
            $('#nombreLote').val(response.nombreLote);
            $('#fechaApartado').val(response.fechaApartado);
            $('#videoNombre').val(response.nombre_archivo);
            $('#basic_info').removeClass('hide');
            $('#basic_info').show();
            if(response.evidencia == 1 || (response.evidencia == 0 && response.estatus_validacion != 0)){
                $('.evidencia').text('cargada');
                $('#evidencia_validacion').text(response.nombre_validacion);
                $('#evidencia').removeClass('hide');
                $('#evidencia').show();
                if(response.estatus_validacion == 2){
                    $('#generate').removeClass('hide');
                    $('#generate').show();
                }
            }else{
                $('.evidencia').text('sin evidencia');
                $('#generate').removeClass('hide');
                $('#generate').show();
            }
            $('#spiner-loader').addClass('hide');
        }, error: function () {
            $("#sendRequestButton").prop("disabled", false);
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
}

function generateToken(obj){
    $.ajax({
        url: "../Api/generateTokenDropbox",
        data: obj,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            console.log(response);
            let url = buildURL(response);
            $("#url").val(url);
            $('#copy_button').removeClass('hide');
            $('#copy_button').show();
            $('.iconCopy').tooltip('show');
            setTimeout(function(){ $('.iconCopy').tooltip('hide'); }, 3000);
            $('#spiner-loader').addClass('hide');
        }, error: function () {
            $("#sendRequestButton").prop("disabled", false);
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
}

function buildURL(token){
    let url = `${general_base_url}Evidencias/evidenciaUser/?jwt=${token}`;
    return url;
}

function copyToClipboard() {
    var copyText = document.getElementById("url");
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */
    navigator.clipboard.writeText(copyText.value);
    alerts.showNotification("top", "right", "La URL ha sido copiada a su portapapeles.", "success");
}

function verEvidencia(){
    $.ajax({
        url: "viewDropboxFile",
        type: 'POST',
        data: {videoNombre: $("#videoNombre").val()},
        dataType: 'json',
        success: function (response) {
            console.log(JSON.parse(response));
            let url = formatVideoURL(JSON.parse(response)); 
            console.log('url',url);
            var video = document.getElementById('video_preview');
            var source = document.createElement('source');
            source.setAttribute('src', url);
            source.setAttribute('type', 'video/mp4');
            video.appendChild(source);
            $("#nombre_lote").text( $('#nombreLote').val());
            $('#videoPreview').modal();
            $('#spiner-loader').addClass('hide');
        }, error: function () {
            $("#sendRequestButton").prop("disabled", false);
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
}

function formatVideoURL(response){
    let url;
    if(response.error){
        url = response.error.shared_link_already_exists.metadata.url;
        url = url.replace("dl=0", "raw=1");
    }else{
        url = response.url;
        url = url.replace("dl=0", "raw=1");
    }
    return url;
}