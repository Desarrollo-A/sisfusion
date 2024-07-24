
Shadowbox.init();

$("#file-uploadE").on('change', function (e) {
    $('#archivoE').val('');
    v2 = document.getElementById("file-uploadE").files[0].name;
    document.getElementById("archivoE").innerHTML = v2;
});

$(document).on("click", ".update", function (e) {
    e.preventDefault();
    $('#archivoE').val('');
    var id_usurio = $(this).attr("data-id_usuario");
    $('#addFile').modal('show');
    console.log('alcuishe');
});

function Recargar() {
    $("#Aviso").modal('hide');
    setTimeout('document.location.reload()', 10);
}

$("#EditarPerfilForm").one('submit', function (e) {
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
            $("#addFile").modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '.verPDF', function () {
    var $itself = $(this);
    Shadowbox.open({
        /*verPDF*/
        content: '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/cumplimiento/' + $itself.attr('data-usuario') + '"></iframe></div>',
        player: "html",
        title: "Visualizando archivo de cumplimiento: " + $itself.attr('data-usuario'),
        width: 985,
        height: 660

    });
});


$("#formDelete").on('submit', function (e) {
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
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });

});