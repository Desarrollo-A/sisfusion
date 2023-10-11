function getResidenciales() {
    $('#spiner-loader').removeClass('hide');
    $("#residenciales").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url + 'General/getResidencialesList',
        type: 'post',
        dataType: 'json',
        success: function (response) {
            $('#spiner-loader').addClass('hide');
            var len = response.length;
            for (var i = 0; i < len; i++) {
                $("#residenciales").append($('<option>').val(response[i]['idResidencial']).attr('data-empresa', response[i]['empresa']).text(response[i]['descripcion']));
            }
            $("#residenciales").selectpicker('refresh');
        }
    });
}

$(document).on("click", "#residenciales", function (e) { // MJ: SE OBTIENE EL CHANGE LOG DE PEDIDOS O ENVÍOS
    e.preventDefault();
    e.stopImmediatePropagation();
    let idResidencial = $(this).val();
    $("#condominios").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url + 'General/getCondominiosList',
        type: 'post',
        dataType: 'json',
        data: {
            "idResidencial": idResidencial
        },
        success: function (response) {
            var len = response.length;
            for (var i = 0; i < len; i++) {
                $("#condominios").append($('<option>').val(response[i]['idCondominio']).text(response[i]['nombre']));
            }
            $("#condominios").selectpicker('refresh');
        }
    });
});

function getCondominios(idResidencial) {
    $('#spiner-loader').removeClass('hide');
    $("#condominios").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url + 'General/getCondominiosList',
        type: 'post',
        dataType: 'json',
        data: {
            "idResidencial": idResidencial
        },
        success: function (response) {
            $('#spiner-loader').addClass('hide');
            var len = response.length;
            for (var i = 0; i < len; i++) {
                $("#condominios").append($('<option>').val(response[i]['idCondominio']).text(response[i]['nombre']));
            }
            $("#condominios").selectpicker('refresh');
        }
    });
}

$(document).on("click", "#condominios", function (e) { // MJ: SE OBTIENE EL CHANGE LOG DE PEDIDOS O ENVÍOS
    e.preventDefault();
    e.stopImmediatePropagation();
    let idCondominio = $(this).val();
    $("#lotes").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url + 'General/getLotesList',
        type: 'post',
        dataType: 'json',
        data: {
            "idCondominio": idCondominio,
            "typeTransaction": typeTransaction
        },
        success: function (response) {
            var len = response.length;
            for (var i = 0; i < len; i++) {
                $("#lotes").append($('<option>').val(response[i]['idLote']).text(response[i]['nombreLote']));
            }
            $("#lotes").selectpicker('refresh');
        }
    });
});

function getLotes(idCondominio) {
    $('#spiner-loader').removeClass('hide');
    $("#lotes").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url + 'General/getLotesList',
        type: 'post',
        dataType: 'json',
        data: {
            "idCondominio": idCondominio,
            "typeTransaction": typeTransaction
        },
        success: function (response) {
            $('#spiner-loader').addClass('hide');
            var len = response.length;
            for (var i = 0; i < len; i++) {
                $("#lotes").append($('<option>').val(response[i]['idLote']).text(response[i]['nombreLote']));
            }
            $("#lotes").selectpicker('refresh');
        }
    });
}

function getEmpresasList() {
    $('#spiner-loader').removeClass('hide');
    $("#empresas").empty().selectpicker('refresh');
    $.ajax({
        url: 'getEmpresasList',
        type: 'post',
        dataType: 'json',
        success: function (response) {
            $('#spiner-loader').addClass('hide');
            var len = response.length;
            for (var i = 0; i < len; i++) {
                $("#empresas").append($('<option>').val(response[i]['empresa']).text(response[i]['empresa']));
            }
            $("#empresas").selectpicker('refresh');
        }
    });
}

function getProyectosList(empresa) {
    $('#spiner-loader').removeClass('hide');
    $("#proyectos").empty().selectpicker('refresh');
    $.ajax({
        url: 'getProyectosList',
        type: 'post',
        dataType: 'json',
        data: {
            "empresa": empresa
        },
        success: function (response) {
            $('#spiner-loader').addClass('hide');
            var len = response.length;
            for (var i = 0; i < len; i++) {
                $("#proyectos").append($('<option>').val(response[i]['IdProyecto']).text(response[i]['Nombre']));
            }
            $("#proyectos").selectpicker('refresh');
        }
    });
}

function getClientesList(empresa, proyecto) {
    $("#clientes").empty().selectpicker('refresh');
    $.ajax({
        url: 'getClientesList',
        type: 'post',
        dataType: 'json',
        data: {
            "empresa": empresa,
            "proyecto": proyecto
        },
        success: function (response) {
            var len = response.length;
            for (var i = 0; i < len; i++) {
                $("#clientes").append($('<option>').val(response[i]['IdCliente']).text(response[i]['NombreCliete']));
            }
            $("#clientes").selectpicker('refresh');
        }
    });
}

function validateExtension(extension, allowedExtensions) {
    let allowedExtensionsArray = allowedExtensions.split(", ");
    let flag = false;
    for (let i = 0; i < allowedExtensionsArray.length; i++) {
        if (allowedExtensionsArray[i] == extension)
            flag = true;
    }
    return flag;
}

function getRejectionReasons(tipo_proceso) {
    $("#rejectionReasons").empty().selectpicker('refresh');
    $("#rejectionReasons").append($('<option disabled>').val("0").text("Selecciona un motivo de rechazo"));
    $.ajax({
        url: general_base_url + 'Documentacion/getRejectionReasons',
        type: 'post',
        dataType: 'json',
        data: {"tipo_proceso": tipo_proceso}, // MJ: TRAE MOTIVOS DE RECHAZO PARA ÁRBOL DE DOCUMENTOS POR PROCESO
        success: function (response) {
            var len = response.length;
            for (var i = 0; i < len; i++) {
                var id = response[i]['id_motivo'];
                var name = response[i]['motivo'];
                var tipo_documento = response[i]['tipo_documento'];
                $("#rejectionReasons").append($('<option>').val(id).attr('data-type', tipo_documento).text(name));
            }
            $("#rejectionReasons").selectpicker('refresh');
        }
    });
}

function getCatalogOptions(id_catalogo) {
    $("#documentos").empty().selectpicker('refresh');
    $.ajax({
        url: url + 'General/getCatalogOptions',
        type: 'post',
        dataType: 'json',
        data: {"id_catalogo": id_catalogo},
        success: function (response) {
            var len = response.length;
            for (var i = 0; i < len; i++) {
                $("#documentos").append($('<option>').val(response[i]['id_opcion']).attr('data-catalogo', response[i]['id_catalogo']).text(response[i]['nombre']));
            }
            $("#documentos").selectpicker('refresh');
        }
    });
}

function getAsesoresList() {
    $("#asesoresList").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url + 'General/getAsesoresList',
        type: 'post',
        dataType: 'json',
        success: function (response) {
            var len = response.length;
            for (var i = 0; i < len; i++) {
                $("#asesoresList").append($('<option>').val(response[i]['id']).attr('data-sede', response[i]['sede']).text(response[i]['nombre']));
            }
            $("#asesoresList").selectpicker('refresh');
        }
    });
}

function formatMoney( n ) {
    const formatter = new Intl.NumberFormat('es-MX', {
        style: 'currency',
        maximumFractionDigits: 4,
        currency: 'MXN'
    });
    return formatter.format(n);
}