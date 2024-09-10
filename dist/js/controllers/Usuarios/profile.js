$(document).ready(function(){
    Shadowbox.init();
    ocultarBtnActualizar();
});

$("input:file").on("change", function () {
    var target = $(this);
    var relatedTarget = target.siblings(".file-name");
    var fileName = target[0].files[0].name;
    relatedTarget.val(fileName);
});

$("#file-uploadE").on('change', function (e) {
    $('#file-name').val('');
    v2 = document.getElementById("file-uploadE").files[0].name;
    document.getElementById("file-name").innerHTML = v2;
});

$(document).on("click", ".update", function (e) {
    e.preventDefault();
    $('#file-name').val('');
    $('#addFile').modal('show');
});

function Recargar() {
    $("#Aviso").modal('hide');
    setTimeout('document.location.reload()', 10);
}

$("#EditarPerfilForm").one('submit', function (e) {
    $('#spiner-loader').removeClass('hide');
    document.getElementById('sendFile').disabled = true;
    $("#sendFile").prop("disabled", true);
    e.preventDefault();
    var formData = new FormData(document.getElementById("EditarPerfilForm"));
    formData.append("dato", "valor");
    $.ajax({
        type: 'POST',
        url: `${general_base_url}Usuarios/SubirPDF`,
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            document.getElementById('sendFile').disabled = false;
            $("#sendFile").prop("disabled", false);
            $('#spiner-loader').addClass('hide');
            if (data == 1) {
                $("#addFile").modal('hide');
                // $("#Aviso .msj").append('Una vez que haya cargado sus factura, ya no podrá modificar su opinión de cumplimiento en caso de ser errónea. por favor revise si el archivo seleccionado fue el correcto.');
                setTimeout('document.location.reload()', 10);
                alerts.showNotification("top", "right", "Opinión de cumplimiento cargada con éxito.", "success");

            } else {
                $("#addFile").modal('hide');
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function () {
            $('#spiner-loader').addClass('hide');
            $("#addFile").modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '.verPDF', function () {
    console.log('1');
    var $itself = $(this);
    Shadowbox.open({
        /*verPDF*/
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${general_base_url}static/documentos/cumplimiento/${$itself.attr('data-nombreArchivo')}"></iframe></div>`,
        player: "html",
        title: "Visualizando archivo de cumplimiento: " + $itself.attr('data-nombreArchivo'),
        width: 985,
        height: 660

    });
});


$("#formDelete").on('submit', function (e) {
    $('#spiner-loader').removeClass('hide');
    e.preventDefault();
    var formData = new FormData(document.getElementById("formDelete"));
    formData.append("dato", "valor");
    $.ajax({
        type: 'POST',
        url:  `${general_base_url}Usuarios/UpdatePDF`,
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            $('#spiner-loader').addClass('hide');
            if (data == 1) {
                $("#Aviso2").modal('hide');
                setTimeout('document.location.reload()', 10);
                alerts.showNotification("top", "right", "El archivo se eliminó exitosamente.", "success");
            } else {
                $("#addFile").modal('hide');
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function () {
            $('#spiner-loader').addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });

});

function ocultarBtnActualizar(){
    if(id_usuario_general == 12874){
        document.getElementById('btn-actualizar').classList.add('hide');
        $('#contrasena').prop('disabled', true);
    }
}