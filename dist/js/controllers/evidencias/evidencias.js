$(document).ready(function(){    
    getResidenciales();
    $('.iconCopy').tooltip({
        trigger: 'manual'
     });
})

$(document).on('change', "#residenciales", function () {
    $('#basic_info').addClass('hide');
    getCondominios($(this).val());
});

$(document).on('change', "#condominios", function () {
    $('#basic_info').addClass('hide');
    getLotes($(this).val());
});

$(document).on('change', "#lotes", function () {
    $("#url").val('');
    $('#copy_button').addClass('hide');
    $('#evidencia').addClass('hide');
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
    generateToken(obj);
});

$(document).on('click', '.iconCopy',function(){
    copyToClipboard();
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
            console.log(response);
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
            $('#basic_info').removeClass('hide');
            $('#basic_info').show();
            if(response.evidencia == 1){
                $('.evidencia').text('cargada');
                $('#evidencia').removeClass('hide');
                $('#evidencia').show();
            }else{
                $('.evidencia').text('sin evidencia');
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
            // $("#url_second").text(url);
            $("#url").val(url);
            $('#copy_button').removeClass('hide');
            $('#copy_button').show();
            $('.iconCopy').tooltip('show');
            setTimeout(function(){ $('.iconCopy').tooltip('hide'); }, 3000);

            // $("#url").text(url);
            // $('#urlModal').modal();
            $('#spiner-loader').addClass('hide');
        }, error: function () {
            $("#sendRequestButton").prop("disabled", false);
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
}

function buildURL(token){
    console.log(base_url);
    let url = `${base_url}Evidencias/evidenciaUser/?jwt=${token}`;
    return url;
}

function copyToClipboard() {
    /* Get the text field */
    var copyText = document.getElementById("url");
  
    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */
  
     /* Copy the text inside the text field */
    navigator.clipboard.writeText(copyText.value);
  
    /* Alert the copied text */
    alerts.showNotification("top", "right", "Se ha copiado la url.", "success");
  }