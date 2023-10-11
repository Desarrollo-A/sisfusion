$(document).ready(function(){
Shadowbox.init();
var newDiv = document.createElement("div");
newDiv.setAttribute("id", "modalRemove");
document.body.appendChild(newDiv); 
newDiv.innerHTML += `<div class="modal fade" id="addDeleteFileModal" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header"></div>
        <div class="modal-body text-center">
            <h5 id="mainLabelText"></h5>
            <p style="font-size: 0.8em" id="secondaryLabelDetail"></p>
            <div class="input-group hide" id="selectFileSection">
                <label class="input-group-btn">
                    <span class="btn btn-primary btn-file">
                        Seleccionar archivo&hellip;<input type="file" name="uploadedDocument" id="uploadedDocument" style="display: none;">
                    </span>
                </label>
                <input type="text" class="form-control" id="txtexp" readonly>
            </div>
            <div class="input-group hide" id="rejectReasonsSection">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 pr-0">
                    <select class="selectpicker" data-style="btn btn-primary btn-round" title="Selecciona un motivo de rechazo" data-size="7" id="rejectionReasons" data-live-search="true" multiple></select>
                </div>
            </div>
            <input type="text" class="hide" id="idLote">
            <input type="text" class="hide" id="idDocumento">
            <input type="text" class="hide" id="documentType">
            <input type="text" class="hide" id="docName">
            <input type="text" class="hide" id="action">
            <input type="text" class="hide" id="tableID">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
            <button type="button" id="sendRequestButton" class="btn btn-primary"></button>
        </div>
    </div>
</div>
</div>`;
}); 

$(document).on("click", ".addRemoveFile", function (e) {
    e.preventDefault();
    let idDocumento = $(this).attr("data-idDocumento");
    let documentType = $(this).attr("data-documentType");
    let action = $(this).data("action");
    let documentName = $(this).data("name");
    let tableID = $(this).attr("data-tableID");
    $("#idLote").val($(this).attr("data-idLote"));
    $("#idDocumento").val(idDocumento);
    $("#documentType").val(documentType);
    $("#docName").val(documentName);
    $("#action").val(action);
    $("#tableID").val(tableID);
    var get = document.getElementById('sendRequestButton');
    action == 1 ? get.innerHTML = 'Cargar':action == 2 ? get.innerHTML = 'Eliminar' :action == 4 ? get.innerHTML = 'Agregar':'';
    
    if (action == 1 || action == 2 || action == 4) {
        document.getElementById("mainLabelText").innerHTML = action == 1 ? "Selecciona el archivo que desees asociar a <b>" + documentName + "</b>" : action == 2 ? "¿Estás seguro de eliminar el archivo <b>" + documentName + "</b>?" : "Selecciona los motivos de rechazo que asociarás al documento <b>" + documentName + "</b>.";
        document.getElementById("secondaryLabelDetail").innerHTML = action == 1 ? "El documento que hayas elegido se almacenará de manera automática una vez que des clic en <i>Guardar</i>." : action == 2 ? "El documento se eliminará de manera permanente una vez que des clic en <i>Guardar</i>." : "Los motivos de rechazo que selecciones se registrarán de manera permanente una vez que des clic en <i>Guardar</i>.";
        if(action == 1) { // ADD FILE
            $("#selectFileSection").removeClass("hide");
            $("#rejectReasonsSection").addClass("hide");
            $("#txtexp").val("");
        } else if(action == 2) { // REMOVE FILE
            $("#selectFileSection").addClass("hide");
            $("#rejectReasonsSection").addClass("hide");
        } else { // REJECT FILE
            filterSelectOptions(documentType);
            $("#selectFileSection").addClass("hide");
            $("#rejectReasonsSection").removeClass("hide");
        }
        $("#addDeleteFileModal").modal("show");

    } else if(action == 3) {
        let fileName = $(this).attr("data-file");
        Shadowbox.open({
            content:    '<div style="height:100%"><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="'+general_base_url+'static/documentos/cliente/contrato/'+fileName+'"></iframe></div>',
            player:     "html",
            title:      "Visualizando archivo: Contrato",
            width:      985,
            height:     660
        });
    } else if(action == 5) {
        $("#sendRequestButton").click();
    }
});

$(document).on("click", "#sendRequestButton", function (e) {
    e.preventDefault();
    let action = $("#action").val();
    let sendRequestPermission = 0;
    if (action == 1){
        let uploadedDocument = $("#uploadedDocument")[0].files[0];
        let validateUploadedDocument = (uploadedDocument == undefined) ? 0 : 1;
        if (validateUploadedDocument == 0) alerts.showNotification("top", "right", "Asegúrate de haber seleccionado un archivo antes de guardar.", "warning");
        else sendRequestPermission = 1;
    } else if (action == 4){
        let rejectionReasons = $("#rejectionReasons").val();
        if (rejectionReasons == ''){
            alerts.showNotification("top", "right", "Asegúrate de haber seleccionado al menos un motivo de rechazo", "warning");
        } else sendRequestPermission = 1;
    }else sendRequestPermission = 1;

    if (sendRequestPermission == 1) {
        let idLote = $("#idLote").val();
        let data = new FormData();
        data.append("idLote", idLote);
        data.append("idDocumento", $("#idDocumento").val());
        data.append("documentType", $("#documentType").val());
        data.append("uploadedDocument", $("#uploadedDocument")[0].files[0]);
        data.append("rejectionReasons", $("#rejectionReasons").val());
        data.append("action", action);
        let documentName = $("#docName").val();
        $('#uploadFileButton').prop('disabled', true);
        $.ajax({
            url: action == 1 ? `${base_url}index.php/Documentacion/uploadFile` : action == 2 ? `${general_base_url}index.php/Documentacion/deleteFile` : `${general_base_url}index.php/Documentacion/validateFile`,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (response) {
                $("#sendRequestButton").prop("disabled", false);
                if (response == 1) {
                    var tableID = $("#tableID").val();
                    $(`#${tableID}`).DataTable().ajax.reload();
                    alerts.showNotification("top", "right", action == 1 ? "El documento " + documentName + " se ha cargado con éxito." : action == 2 ? "El documento " + documentName + " se ha eliminado con éxito." : action == 4 ? "Los motivos de rechazo se han asociado de manera exitosa para el documento " + documentName + "." : "El documento " + documentName + " se ha sido validado correctamente.", "success");
                    $("#addDeleteFileModal").modal("hide");
                } else if (response == 0) alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
                else if (response == 2) alerts.showNotification("top", "right", "No fue posible almacenar el archivo en el servidor.", "warning");
                else if (response == 3) alerts.showNotification("top", "right", "El archivo que se intenta subir no cuenta con la extención .xlsx", "warning");
            }, error: function () {
                $("#sendRequestButton").prop("disabled", false);
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    }
});

$(document).ready (function() {
    $(document).on('fileselect', '.btn-file :file', function(event, numFiles, label) {
        var input = $(this).closest('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }
    });

    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    $('#filtro3').change(function(){
        $('#spiner-loader').removeClass('hide');
        var valorSeleccionado = $(this).val();
        $("#filtro4").empty().selectpicker('refresh');
        $.ajax({
            url: general_base_url + 'registroCliente/getCondominios/'+valorSeleccionado,
            type: 'post',
            dataType: 'json',
            success:function(response){
                var len = response.length;
                for( var i = 0; i<len; i++)
                {
                    var id = response[i]['idCondominio'];
                    var name = response[i]['nombre'];
                    $("#filtro4").append($('<option>').val(id).text(name));
                }
                $("#filtro4").selectpicker('refresh');
                $('#spiner-loader').addClass('hide');
            }
        });
    });

    $('#filtro4').change(function(){
        $('#spiner-loader').removeClass('hide');
        var residencial = $('#filtro3').val();
        var valorSeleccionado = $(this).val();
        $("#filtro5").empty().selectpicker('refresh');
        $.ajax({
            url: general_base_url + 'registroCliente/getLotesJuridico/'+valorSeleccionado+'/'+residencial,
            type: 'post',
            dataType: 'json',
            success:function(response){
                var len = response.length;
                for( var i = 0; i<len; i++)
                {
                    var id = response[i]['idLote'];
                    var name = response[i]['nombreLote'];
                    $("#filtro5").append($('<option>').val(id).text(name));
                }
                $("#filtro5").selectpicker('refresh');
                $('#spiner-loader').addClass('hide');
            }
        });
    });

    $('#filtro5').change(function(){
        $('#spiner-loader').removeClass('hide');
        $('#tableDoct thead tr:eq(0) th').each(function (i) {  
            var title = $(this).text();
            $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if ($('#tableDoct').DataTable().column(i).search() !== this.value) {
                    $('#tableDoct').DataTable().column(i).search(this.value).draw();
                }
            });
        });

        var valorSeleccionado = $(this).val();
        $('#tableDoct').DataTable({
            dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            width: true,
            bAutoWidth: true,
            destroy: true,
            searching: true,
            ajax:
                {
                    "url": general_base_url + '/registroCliente/expedientesReplace/'+valorSeleccionado,
                    "dataSrc": ""
                },
                initComplete: function() {
                    $("#tableDoct").removeClass('hide');
                    $('#spiner-loader').addClass('hide');
                },
            pagingType: "full_numbers",
            fixedHeader: true,
            language: {
                url: general_base_url + "static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            ordering: false,
            columns: [{
                "data": function( d ){
                    return '<p class="m-0">'+d.nombreResidencial+'</p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0">'+d.nombre+'</p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0">'+d.nombreLote+'</p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0">'+d.nomCliente +' ' +d.apellido_paterno+' '+d.apellido_materno+'</p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0">'+d.movimiento+'</p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0">'+d.modificado.split('.')[0]+'</p>';
                }
            },
            {
                data: null,
                render: function ( data, type, row ){
                    let deletePermission = '';
                    let vdPermission = '';
                    if (data.expediente == null) {
                        vdPermission = '<button type="button" title= "Asociar a contrato" class="btn-data btn-sky addRemoveFile"  data-tableID="tableDoct" data-action="1" data-idLote="' + data.idLote + '" data-idDocumento="' + data.idDocumento + '" data-documentType="' + data.tipo_doc + '" data-name="Contrato"><i class="fas fa-upload"></i></button>';
                    } else {
                        label = '';
                        vdPermission = '<button type="button" title= "Ver contrato" class="btn-data btn-orangeYellow addRemoveFile" data-action="3" data-idDocumento="' + data.idDocumento + '" data-documentType="' + data.tipo_doc + '" data-file="' + data.expediente + '" data-name="Contrato"><i class="far fa-eye"></i></button>';
                        deletePermission = '<button type="button" title= "Eliminar contrato" class="btn-data btn-gray addRemoveFile" data-tableID="tableDoct" data-action="2" data-idLote="' + data.idLote + '" data-idDocumento="' + data.idDocumento + '" data-documentType="' + data.tipo_doc + '" data-name="Contrato"><i class="fas fa-trash"></i></button>';
                    }
                    return '<div class="d-flex justify-center">'+vdPermission + deletePermission + '</div>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0">'+ myFunctions.validateEmptyFieldDocs(d.primerNom) +' '+myFunctions.validateEmptyFieldDocs(d.apellidoPa)+' '+myFunctions.validateEmptyFieldDocs(d.apellidoMa)+'</p>';
                }
            },
            {
                "data": function( d ){
                    var validaub = (d.ubic == null) ? '' : d.ubic;
                    return '<p class="m-0">'+ validaub +'</p>';
                }
            }]
        });

        $.post( general_base_url + "registroCliente/expedientesReplace/"+valorSeleccionado, function( data_json ) {
            var data = jQuery.parseJSON(data_json);
            if(data.length>0){
                $('#btnFilesGral').removeClass('hide');
                $('#btnFilesGral').attr('data-idLote', valorSeleccionado);
            }
            else
            {
                $('#btnFilesGral').addClass('hide');
                $('#btnFilesGral').attr('data-idLote', valorSeleccionado);
            }
        });
    });

    $('#tableDoct').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
});
