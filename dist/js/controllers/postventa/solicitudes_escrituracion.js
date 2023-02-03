$('#escrituracion-datatable thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    $(this).html('<input class="textoshead"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {
        if ($('#escrituracion-datatable').DataTable().column(i).search() !== this.value ) {
            $('#escrituracion-datatable').DataTable().column(i).search(this.value).draw();
        }
    });
});

$('#carga-datatable thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    $(this).html('<input class="textoshead"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {
        if ($('#carga-datatable').DataTable().column(i).search() !== this.value ) {
            $('#carga-datatable').DataTable().column(i).search(this.value).draw();
        }
    });
});

$('#notas-datatable thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    $(this).html('<input class="textoshead"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {
        if ($('#notas-datatable').DataTable().column(i).search() !== this.value ) {
            $('#notas-datatable').DataTable().column(i).search(this.value).draw();
        }
    });
});
 
sp = { // MJ: SELECT PICKER
    initFormExtendedDatetimepickers: function () {
        var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        var time = today.getHours() + ":" + today.getMinutes();
        var dateTime = date+' '+time;

        $('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove',
                inline: true,
            }
        });
    }
}

sp2 = { // CHRIS: SELECT PICKER
    initFormExtendedDatetimepickers: function () {
        $('.datepicker2').datetimepicker({
            format: 'DD/MM/YYYY LT',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove',
                inline: true
            },
            minDate:new Date(),
        });
    }
}

$(document).ready(function () {
    sp.initFormExtendedDatetimepickers();
    sp2.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    getEstatusEscrituracion();
    setInitialValues();

    $(document).on('fileselect', '.btn-file :file', function (event, numFiles, label) {
        var input = $(this).closest('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }
    });

    $(document).on('change', '.btn-file :file', function () {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    getRejectionReasons(2); // MJ: SE MANDAN TRAER LOS MOTIVOS DE RECHAZO PARA EL ÁRBOL DE DOCUMENTOS DE ESCRUTURACIÓN

});

//eventos jquery
$(document).on('change', '#cliente', function () {
    if ($(this).val() == 'uno') {
        $('.ifClient').show();
    } else {
        $('.ifClient').hide();

    }
});

$(document).on('change', '#cliente2', function () {
    if ($(this).val() == 'uno') {
        $('#ifClient2').show();
    } else {
        $('#ifClient2').hide();

    }
});

$(document).on('change', '#notaria', function () {
    $('#spiner-loader').removeClass('hide');
    $.post('getNotaria',{idNotaria: $(this).val()}, function(data) {
        $('#spiner-loader').addClass('hide');
        $('#information').html(`<p><b>Nombre de la notaria:</b> ${data[0].nombre_notaria}</p>
        <p><b>Nombre del notario:</b> ${data[0].nombre_notario}</p>
        <p><b>Direccíon de la notaria:</b> ${data[0].direccion}</p>
        <p><b>Correo de la notaria:</b> ${data[0].correo}</p>`);
    }, 'json');
});

$(document).on('change', '#valuador', function () {
    $('#spiner-loader').removeClass('hide');
    $.post('getValuador',{idValuador: $(this).val()}, function(data) {
        $('#spiner-loader').addClass('hide');
        $('#information2').html(`<p><b>Nombre del perito:</b> ${data[0].perito}</p>
        <p><b>Direccíon del valuador:</b> ${data[0].direccion}</p>
        <p><b>Correo del valuador:</b> ${data[0].correo}</p>
        <p><b>Telefono del valuador:</b> ${data[0].telefono}</p>`);
    }, 'json');
});




$(document).on('submit', '#rejectForm', function (e) {
    e.preventDefault();
    let id_solicitud = $('#id_solicitud2').val();
    let motivos_rechazo = $('#motivos_rechazo').val();
    let area_rechazo = $('#area_rechazo').val();
    if(area_rechazo != ''){
        let datos = area_rechazo.split(',');
        area_rechazo = datos[0];
    }
    let estatus = $('#estatus').val();
   let type = 3;
    changeStatus(id_solicitud, 3, motivos_rechazo, type,0,area_rechazo);
})


$(document).on('submit', '#approveForm', function (e) {
    e.preventDefault();
    let id_solicitud = $('#id_solicitud').val();
    let observations = $('#observations').val();
    let id_estatus = $('#status').val();
   // alert(id_estatus)
    let type =$('#type').val();// id_estatus == 2 ? 2 : (id_estatus == 12 ? 4 : id_estatus); //$('#type').val();
   // alert(type)
   if(id_estatus == 30 ){
    changeStatus(id_solicitud, 1, observations, 5,0,29);
   }else{
    changeStatus(id_solicitud, 1, observations, type);
   }

})

$(document).on('click', '#submitUpload', function (e) {
    e.preventDefault();
})

$(document).on("click", "#searchByDateRange", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    let fDate = formatDate(finalBeginDate);
    let fEDate = formatDate(finalEndDate);
    fillTable(fDate, fEDate, $('#estatusE').val());
    
});
$(document).on('click', '#createDate', function () {
    var data = escrituracionTable.row($(this).parents('tr')).data();
    console.log(data)
    
    let idNotaria = $(this).attr('data-idNotaria');
    let signDate = getSignDate(idNotaria);
    $('#signDate').val(signDate);
    $('#idSolicitudFecha').val($(this).attr('data-idSolicitud'));
    $('#type').val(data.id_estatus == 30 ? 5 : 1);
    $("#dateModal").modal();
});
$(document).on('click', '#newDate', function () {
    var data = escrituracionTable.row($(this).parents('tr')).data();
    console.log(data);
    // $('#id_solicitud3').val(data.idSolicitud);
    let idNotaria = $(this).attr('data-idNotaria');
    let signDate = getSignDate(idNotaria);
    $('#signDate').val(signDate);
    $('#idSolicitudFecha').val($(this).attr('data-idSolicitud'));
    $('#type').val(3);
    $("#dateModal").modal();
});

$(document).on("click", "#searchByDateTest", function (){
    let finalBeginDate = $("#startDate").val();
    let finalEndDate = $("#finalDate").val();
    let fDate = formatDate(finalBeginDate);
    let fEDate = formatDate(finalEndDate);
    fillTableCarga(fDate, fEDate,$('#estatusE').val());
})

$(document).on("click", "#dateSubmit", function () {
    let signDate = $("#signDate").val();
    let idSolicitud = $("#idSolicitudFecha").val();
    let signDateFinal = formatDate2(signDate);
    let type = $("#type").val();
    $('#spiner-loader').removeClass('hide');
    $.post('saveDate', {
        signDate: signDateFinal,
        idSolicitud: idSolicitud
    }, function (data) {
        $('#spiner-loader').addClass('hide');
        $('#dateModal').modal("hide");
        if (data == true) {
            if(type == 5){
                changeStatus(idSolicitud, 2, `Nueva fecha para firma: ${signDateFinal}`,type,31);
            }else{
                changeStatus(idSolicitud, 2, `Nueva fecha para firma: ${signDateFinal}`,type);
            }
        }
    }, 'json');
});

$(document).on("click", ".upload", function () {
    $('#spiner-loader').removeClass('hidden');
    let idDocumento = $(this).attr("data-idDocumento");
    let documentType = $(this).attr("data-documentType");
    let action = $(this).data("action");
    let documentName = $(this).data("name");
    let presupuestoType = $(this).attr("data-presupuestoType");
    let idPresupuesto = $(this).attr("data-idPresupuesto");
    let idNxS = $(this).attr("data-idNxS");

    $("#idSolicitud").val($(this).attr("data-idSolicitud"));
    $("#idDocumento").val(idDocumento);
    $("#documentType").val(documentType);
    $("#docName").val(documentName);
    $("#action").val(action);
    $("#presupuestoType").val(presupuestoType);
    $("#idPresupuesto").val(idPresupuesto);
    $("#idNxS").val(idNxS);
    $("#details").val($(this).data("details"));
    if (action == 1 || action == 2 || action == 4) {
        console.log('action upload')
        console.log(action)
        document.getElementById("mainLabelText").innerHTML = action == 1 ? "Seleccione el archivo que desees asociar." : action == 2 ? "¿Estás seguro de eliminar el archivo?" : "Seleccione los motivos de rechazo que asociarás al documento.";
        document.getElementById("secondaryLabelDetail").innerHTML = action == 1 ? "El documento que hayas elegido se almacenará de manera automática una vez que des clic en guardar." : action == 2 ? "El documento se eliminará de manera permanente una vez que des clic en Guardar." : "Los motivos de rechazo que selecciones se registrarán de manera permanente una vez que des clic en Guardar.";
        if (action == 1) { // ADD FILE
            $("#selectFileSection").removeClass("hide");
            $("#rejectReasonsSection").addClass("hide");
            $("#txtexp").val("");
        } else if (action == 2) { // REMOVE FILE
            $("#selectFileSection").addClass("hide");
            $("#rejectReasonsSection").addClass("hide");
        } else { // REJECT FILE
            filterSelectOptions(documentType);
            $("#selectFileSection").addClass("hide");
            $("#rejectReasonsSection").removeClass("hide");
        }
        $('#uploadedDocument').val('');
        $( "#uploadedDocument" ).trigger( "change" );
        $("#uploadModal").modal();
    } else if (action == 3) {
        $("#sendRequestButton").click();
    }
    
    $("input:file").on("change", function () {
        var target = $(this);
        var relatedTarget = target.siblings(".file-name");

        if(target.val() == ''){
            var fileName = 'No ha seleccionado nada aún';
        }else{
            var fileName = target[0].files[0].name;
        }
        relatedTarget.val(fileName);
    });
    $('#spiner-loader').addClass('hidden');
});

$(document).on("click", "#sendRequestButton", function (e) {
    var info = escrituracionTable.page.info();
    console.log(info)
    console.log(info.page)
    e.preventDefault();
    let action = $("#action").val();
    let sendRequestPermission = 0;
    if (action == 1) { // UPLOAD FILE
        let uploadedDocument = $("#uploadedDocument")[0].files[0];
        let allowedExtensions = /(\.xls|\.xlsx|\.pdf|\.jpg|\.jpeg|\.png|\.doc|\.docx|\.csv|\.rar|\.zip)$/i;
        let validateUploadedDocument = (uploadedDocument == undefined) || !allowedExtensions.exec(uploadedDocument.name) ? 0 : 1;
        // SE VALIDA QUE HAYA SELECCIONADO UN ARCHIVO ANTES DE LLEVAR A CABO EL REQUEST

        if (validateUploadedDocument == 0) alerts.showNotification("top", "right", "Asegúrate de haber seleccionado un archivo antes de guardar.", "warning");
        else sendRequestPermission = 1; // PUEDE MANDAR EL REQUEST PORQUE SÍ HAY ARCHIVO SELECCIONADO
    } else if (action == 2) // MJ: DELETE FILE
        sendRequestPermission = 1;
    else if (action == 3)// MJ: VALIDATE OK
        sendRequestPermission = 1;
    else if (action == 4) { // MJ: VALIDATE NOK FILE
        let rejectionReasons = $("#rejectionReasons").val();
        if (rejectionReasons == '') { // THERE ARE NO OPTIONS
            alerts.showNotification("top", "right", "Asegúrese de haber seleccionado al menos un motivo de rechazo", "warning");
        } else sendRequestPermission = 1;
    }

    if (sendRequestPermission == 1) {
        let idSolicitud = $("#idSolicitud").val();
        let data = new FormData();
        let details = $("#details").val();
        console.log('details')
        console.log(details)
        data.append("idSolicitud", idSolicitud);
        data.append("idDocumento", $("#idDocumento").val());
        data.append("documentType", $("#documentType").val());
        if($("#documentType").val() == 13){
            data.append("presupuestoType", $("#presupuestoType").val());
            data.append("idPresupuesto", $("#idPresupuesto").val());
            data.append("idNxS", $("#idNxS").val());
        }
        data.append("uploadedDocument", $("#uploadedDocument")[0].files[0]);
        data.append("rejectionReasons", $("#rejectionReasons").val());
        data.append("action", action);
        let documentName = $("#docName").val();
        $('#uploadFileButton').prop('disabled', true);
        $('#spiner-loader').removeClass('hide');
        let contador = action == 1 ? 1 : action == 2 ? 2 : 0;

        $.ajax({
            url: action == 1 ? "uploadFile" : action == 2 ? "deleteFile" : "validateFile",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (response) {
                console.log(response);
                $("#sendRequestButton").prop("disabled", false);
                if (response == 1) {
                    // getDocumentsInformation(idSolicitud);
                    alerts.showNotification("top", "right", action == 1 ? "El documento se ha cargado con éxito." : action == 2 ? "El documento se ha eliminado con éxito." : action == 4 ? "Los motivos de rechazo se han asociado de manera exitosa para el documento." : "El documento ha sido validado correctamente.", "success");
                    console.log(details);
                    if(details == 1){
                        var tr = $(`#trees${idSolicitud}`).closest('tr');
                        var row = escrituracionTable.row(tr);
                        createDocRow(row, tr, $(`#trees${idSolicitud}`));
                    }else if(details == 2){
                        console.log('details =2, buildUploadCards')
                        let idNxS = $("#idNxS").val();
                        buildUploadCards(idNxS);
                        // var tr = $(`#treePresupuesto${idSolicitud}`).closest('tr');
                        // var row = escrituracionTable.row(tr);
                        // createDocRowPresupuesto(row, tr, $(`#treePresupuesto${idSolicitud}`));
                    }else if(details == 3){
                        var tr = $(`#docs${idSolicitud}`).closest('tr');
                        var row = escrituracionTable.row(tr);
                        createDocRowOtros(row, tr, $(`#docs${idSolicitud}`),contador);
                    }else if(details == 4){
                        var tr = $(`#pago${idSolicitud}`).closest('tr');
                        var row = escrituracionTable.row(tr);
                        createDocRowPago(row, tr, $(`#pago${idSolicitud}`));
                    }
                    else{
                        escrituracionTable.ajax.reload(null,false);
                    }
                    $("#uploadModal").modal("hide");
                    $('#spiner-loader').addClass('hide');
                } else if (response == 0) alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
                else if (response == 2) alerts.showNotification("top", "right", "No fue posible almacenar el archivo en el servidor.", "warning");
                else if (response == 3) alerts.showNotification("top", "right", "El archivo que se intenta subir no cuenta con la extención .xlsx", "warning");
                $('#spiner-loader').addClass('hide');
            }, error: function () {
                $("#sendRequestButton").prop("disabled", false);
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                $('#spiner-loader').addClass('hide');
            }
        });
    }
});

$(document).on("submit", "#formPresupuesto", function (e) {
    console.log("click");
    e.preventDefault();
    let idSolicitud = $("#id_solicitud3").val();
    let data = new FormData($(this)[0]);
    data.append('nombreT', $('#nombreT').val() == '' ? null : $('#nombreT').val());
    data.append('fechaCA2', $('#fechaCA').val() == '' ? null : formatDate($('#fechaCA').val()));
    //Datos de la notaria : AR
    data.append('nombre_notaria', $('#nombre_notaria').val() == '' ? null : $('#nombre_notaria').val());
    data.append('nombre_notario', $('#nombre_notario').val() == '' ? null : $('#nombre_notario').val());
    data.append('direccion', $('#direccion').val() == '' ? null : $('#direccion').val());
    data.append('correo', $('#correo').val() == '' ? null : $('#correo').val());
    data.append('telefono', $('#telefono').val() == '' ? null : $('#telefono').val());
    data.append("idSolicitud", idSolicitud);
    $('#spiner-loader').removeClass('hide');
    $.ajax({
        url: "savePresupuesto",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (response) {
            if (response == 1) {
                $("#presupuestoModal").modal("hide");
                var win =  window.open("pdfPresupuesto/" + $('#id_solicitud3').val(), "_blank");
                $('#spiner-loader').addClass('hide');
                win.onload = function(){
                    $('#formPresupuesto')[0].reset();
                   escrituracionTable.ajax.reload(null,false);
                }
            }
        }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
});

$(document).on('click', '#request', function () {
    var data = escrituracionTable.row($(this).parents('tr')).data();
    document.getElementById('actividad_siguiente').innerHTML = '';
    // document.getElementById('notariaVo').innerHTML = '';

    $('#id_solicitud').val(data.id_solicitud);
    $('#status').val(data.id_estatus);
    $('#observations').val('');
    let actividad_next = $(this).attr('data-siguiente_actividad');
    actividad_next = actividad_next.split('-');
    let area_next = $(this).attr('data-siguiente-area');

    document.getElementById('actividad_siguiente').innerHTML = '<br><p style="color:#154360;">Estatus siguiente: <b>'+actividad_next[0]+' - '+actividad_next[1]+'</b> <br> Área(s) siguiente(s): <b>'+ ((data.id_estatus == 1) ? 'Administración y Comité Técnico':actividad_next[2])+'</b></p>';
    

    let type = $(this).attr('data-type');
     $('#type').val(data.id_estatus == 1 ? 2 :(data.id_estatus == 12 ? 4 : 1));
     
    //  if(data.id_estatus == 1){
        
    //     document.getElementById('notaria_siguiente').style.display = "show";
        
    //     // .innerHTML = '';
    //      console.log('Si entra estatus 1');
    // }
   // $('#type').val(2);
    $("#approveModal").modal();
});

$(document).on('click', '.comentariosModel', function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();

    id_solicitud = $(this).attr("data-idSolicitud");
    lote = $(this).attr("data-lotes")
    $("#comentariosModal").modal();
    $("#nameLote").append('<p><h5 style="color:#21618C;">Historial de la solicitud: <b style="color:#21618C;">'+id_solicitud+'</b></h5></p>');
    $("#infoLote").append('<p><h5 style="color:#21618C;">Lote: <b style="color:#21618C;">'+lote+'</b></h5></p>');
    $.getJSON("getDetalleNota/"+id_solicitud).done( function( data ){
        if(data != ""){
        $.each( data, function(i, v){ 
                $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:39A1C0;">'+v.descripcion+'</i><br><b style="color:#39A1C0">'+v.fecha_creacion+'</b><b style="color:gray;"> - '+v.nombre+'</b></p></div>');
        });
            }else{
                $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:39A1C0;">No se han encontrado notas</i></p></div>');  
            }
    });
});

function cleanCommentsAsimilados() {
    var myCommentsList = document.getElementById('comments-list-asimilados');
    var myCommentsLote = document.getElementById('nameLote');
    var myCommentsInfo = document.getElementById('infoLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
    myCommentsInfo.innerHTML = '';
}

$('#observations').keydown(function () {
    document.getElementById('text-observations').innerHTML = '';
    var max = 250;
    var len = $(this).val().length;
    if (len >= max) {
        //alerts.showNotification("top", "right", "Limite de caracteres superado", "warning");
        document.getElementById('text-observations').innerHTML = 'Limite de caracteres superado';
        $('#ApproveF').addClass('disabled');    
        document.getElementById('ApproveF').disabled = true;                    
    } 
    else {
        document.getElementById('text-observations').innerHTML = '';
        var ch = max - len;            
        $('#ApproveF').removeClass('disabled');
        document.getElementById('ApproveF').disabled = false;            
    }
}); 


$(document).on('click', '#reject', function () {
    var data = escrituracionTable.row($(this).parents('tr')).data();
    $('#id_solicitud2').val(data.id_solicitud);
   $('#status2').val(data.id_estatus);
    $('#estatus').val(data.idEstatus);
    data.tipo_documento=0;
    getMotivosRechazos(data.tipo_documento,data.id_estatus);
    $("#rejectModal").modal();
});



$(document).on('click', '#presupuesto', function () {
    var data = escrituracionTable.row($(this).parents('tr')).data();
    let area_actual = $(this).attr('data-area-actual');
    console.log(area_actual);

    if(area_actual == 55 && (data.id_estatus == 9  || data.id_estatus == 11)){
       /*document.getElementById('RequestPresupuesto').style.display = "none";
       document.getElementById('nombrePresupuesto2').disabled = true;
       document.getElementById('tipoE').disabled = true;
       document.getElementById('estatusPago').disabled = true;
       document.getElementById('superficie').disabled = true;
       document.getElementById('catastral').disabled = true;*/
       document.getElementById('cliente').disabled = true;
       document.getElementById('nombreT').disabled = true;
       document.getElementById('fechaCA').disabled = true;
       document.getElementById('rfcDatos').disabled = true;
       document.getElementById('aportaciones').disabled = true;
       document.getElementById('descuentos').disabled = true;
       document.getElementById('motivo').disabled = true;
    }
    // $('#id_solicitud3').val(data.idSolicitud);
    //alert(data.id_solicitud)
    getBudgetInfo(data.id_solicitud);
    $('#id_solicitud3').val(data.id_solicitud);
    $("#presupuestoModal").modal();
});

$(document).on('click', '#checkPresupuesto', function () {
    var data = escrituracionTable.row($(this).parents('tr')).data();
    // $('#id_solicitud3').val(data.idSolicitud);
    checkBudgetInfo(data.idSolicitud);
    $('#id_solicitud4').val(data.idSolicitud);

    $("#checkPresupuestoModal").modal();
});



$(document).on('click', '#sendMail', function () {
    var data = escrituracionTable.row($(this).parents('tr')).data();
    let action = $('#sendMail').attr('data-action');
    switch (action) {
        case '1':
            getNotarias();
            getValuadores();
            $('#idSolicitud').val(data.idSolicitud);
            $('#action').val(action);
            $('#information').html('');
            $('#information2').html('');
            $("#notarias").modal();
            break;
        case '2':
            email(data.idSolicitud, action);

            break;
        case '3':
            email(data.idSolicitud, action);
            break;
        case '4':
            email(data.idSolicitud, action);
            break;
        case '5':
            email(data.idSolicitud, action);
            break;
    }
});

$(document).on('click', '#tree', function () {
    var data = escrituracionTable.row($(this).parents('tr')).data();
    getDocumentsClient(data.idSolicitud, data.idEstatus);
    $("#documentTree").modal();
});

$(document).on('click', '#asignarNotariaButton', function () {

    //$('#asignarNotaria')[0].reset();

    var data = escrituracionTable.row($(this).parents('tr')).data();
    let informacion_lote = $(this).attr('data-lote');
    let solicitud = $(this).attr('data-solicitud');
    console.log('solicitud: '+ solicitud);
    $("#tipoNotaria").selectpicker('refresh');
    document.getElementById('informacion_lote').innerHTML = 'Lote: '+informacion_lote;
    $('#id_solicitud').val(solicitud);
    //$('#div_notaria').hide();
    /*$('#divnombre_notaria').hide();
    $('#divnombre_notario').hide();
    $('#divdireccion').hide();
    $('#divcorreo').hide();
    $('#divtelefono').hide();*/
 
    $("#altaNotario").modal();
});


$(document).on('change', '#tipoNotaria', function(e){

    if ($(this).val()) {
        $('#tipo_notaria').val($(this).val());
        if ($(this).val() == 2) {
            $('#div_notaria').show();
           // $('#asignarNotaria')[0].reset();

            $('#nombre_notaria').attr("required", true);
            $('#nombre_notario').attr("required", true);
            $('#direccion').attr("required", true);
            $('#correo').attr("required", true);
            $('#telefono').attr("required", true);

        }else{
            $('#div_notaria').hide();

            $('#nombre_notaria').removeAttr("required");
            $('#nombre_notario').removeAttr("required");
            $('#direccion').removeAttr("required");
            $('#correo').removeAttr("required");
            $('#telefono').removeAttr("required");

         }
    }
})


$(document).on('change', '#documents', function () {
    let idDocument = $(this).val();
    displayInput(idDocument);
});

$(document).on('click', '#notariaSubmit', function (e) {
    let idSolicitud = $('#idSolicitud').val();
    let action = $('#action').val();
    let notaria = $('#notaria').val();
    let valuador = $('#valuador').val();
    email(idSolicitud, action, notaria, valuador);
})

$(document).on("click", "#sendRequestButton2", function (e) {
    $('#spiner-loader').removeClass('hide');
    let uploadedDocument = $("#uploadedDocument2")[0].files[0];
    let validateUploadedDocument = (uploadedDocument == undefined) ? 0 : 1;
    // SE VALIDA QUE HAYA SELECCIONADO UN ARCHIVO ANTES DE LLEVAR A CABO EL REQUEST
    if (validateUploadedDocument == 0) alerts.showNotification("top", "right", "Asegúrese de haber seleccionado un archivo antes de guardar.", "warning");
    else sendRequestPermission = 1; // PUEDE MANDAR EL REQUEST PORQUE SÍ HAY ARCHIVO SELECCIONADO

    if (sendRequestPermission == 1) {
        let data = new FormData();
        data.append("idDocumento", $("#uploadedDocument2").attr('data-iddoc'));
        data.append("uploadedDocument2", uploadedDocument);

        $.ajax({
            url: "uploadFile2",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (response) {
                $("#sendRequestButton2").prop("disabled", false);
                if (response == 1) {
                    // getDocumentsInformation(idSolicitud);
                    alerts.showNotification("top", "right", action == 1 ? "El documento se ha cargado con éxito." : action == 2 ? "El documento se ha eliminado con éxito." : action == 4 ? "Los motivos de rechazo se han asociado de manera exitosa para el documento." : "El documento ha sido validado correctamente.", "success");
                    // escrituracionTable.ajax.reload();
                    // $("#uploadModal").modal("hide");
                } else if (response == 0) alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
                else if (response == 2) alerts.showNotification("top", "right", "No fue posible almacenar el archivo en el servidor.", "warning");
                else if (response == 3) alerts.showNotification("top", "right", "El archivo que se intenta subir no cuenta con la extención .xlsx", "warning");
                $('#spiner-loader').addClass('hide');
            }, error: function () {
                $("#sendRequestButton2").prop("disabled", false);
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                $('#spiner-loader').addClass('hide');
            }
        });
    }
})

$(document).on('click', '.details-control', function () {
    var detailRows = [];
    var tr = $(this).closest('tr');
    var row = escrituracionTable.row(tr);
    var idx = $.inArray(tr.attr('id'), detailRows);
    if (row.child.isShown()) {
        tr.removeClass('details');
        row.child.hide();

        // Remove from the 'open' array
        detailRows.splice(idx, 1);
    } else {
        $('#spiner-loader').removeClass('hide');
        tr.addClass('details');
        createDocRow(row, tr, $(this));
        // Add to the 'open' array
        if (idx === -1) {
            detailRows.push(tr.attr('id'));
        }
    }
});

let rowOtros = new Object();

$(document).on('click', '.details-control-otros', function () {
    var detailRows = [];
    var tr = $(this).closest('tr');
    var row = escrituracionTable.row(tr);
    var idx = $.inArray(tr.attr('id'), detailRows);
    if (row.child.isShown()) {
        tr.removeClass('details');
        row.child.hide();

        // Remove from the 'open' array
        detailRows.splice(idx, 1);
    } else {
        $('#spiner-loader').removeClass('hide');
        tr.addClass('details');
        rowOtros = {
            "row" : row,
            "tr" : tr,
            "this" : $(this)
        }
        createDocRowOtros(row, tr, $(this));
        // Add to the 'open' array
        if (idx === -1) {
            detailRows.push(tr.attr('id'));
        }
    }
});

$(document).on('click', '.details-control-pago', function () {
    var detailRows = [];
    var tr = $(this).closest('tr');
    var row = escrituracionTable.row(tr);
    var idx = $.inArray(tr.attr('id'), detailRows);
    if (row.child.isShown()) {
        tr.removeClass('details');
        row.child.hide();

        // Remove from the 'open' array
        detailRows.splice(idx, 1);
    } else {
        $('#spiner-loader').removeClass('hide');
        tr.addClass('details');
        createDocRowPago(row, tr, $(this));
        // Add to the 'open' array
        if (idx === -1) {
            detailRows.push(tr.attr('id'));
        }
    }
});

$(document).on('click', '#estatusL', function () {
    var data = escrituracionTable.row($(this).parents('tr')).data();
    document.getElementById('informacion_lote_construccion').innerHTML = ''
    document.getElementById('informacion_lote_construccion').innerHTML = '<br><p style="color:#154360;">Estatus a Lote: <b>'+data.nombreLote+'</b></p>';

    $('#id_solicitudEstatus').val(data.id_solicitud);
    let estatus_construccion = $(this).attr('data-estatus-construccion');
    getEstatusConstruccion(estatus_construccion);
    $("#estatusLModal").modal();
});

$(document).on('submit', '#formEstatusLote', function (e) {
    e.preventDefault();
    let id_solicitud = $('#id_solicitudEstatus').val();
    let formData = new FormData($(this)[0]);
    saveEstatusLote(id_solicitud, formData);
})

$(document).on('click', '.treePresupuesto', function () {
    var detailRows = [];

    var tr = $(this).closest('tr');
    console.log('tr')
    console.log(tr)
    var row = escrituracionTable.row(tr);
    console.log('lllllllllllllllllllllllll');
    console.log(row)
    var idx = $.inArray(tr.attr('id'), detailRows);
    console.log('idx')
    console.log(idx)
    //SI EL ROW DETAILS ESTA DESPLEGADO, ESCONDEERLO
    if (row.child.isShown()) {
        console.log('PRIMER IF')
        tr.removeClass('details');
        row.child.hide();

        // Remove from the 'open' array
        detailRows.splice(idx, 1);
        console.log(detailRows);
    } else {
        //DESPLEGAR EL ROW DETAILS
        console.log('ELSE')
        $('#spiner-loader').removeClass('hide');
        tr.addClass('details');
        // createDocRowPresupuesto(row, tr, $(this));
        console.log('NNNNNNNNNNNNNNNNNNNNNNNN');
        createRowNotarias(row, tr, $(this), row.data().id_solicitud);

        // Add to the 'open' array
        if (idx === -1) {
            detailRows.push(tr.attr('id'));
        }
    }
});

$(document).on('click', '.approve', function(){
    let idDocumento = $(this).attr("data-idDocumento");
    let idSolicitud = $(this).attr("data-idSolicitud");

    let data = new FormData();
    let details =  $(this).attr("data-details");
    data.append("idSolicitud", idSolicitud);
    data.append("idDocumento", idDocumento);

    $.ajax({
        url: 'approvePresupuesto',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (response) {
            console.log(details);
            $("#sendRequestButton").prop("disabled", false);
            if (response == 1) {
                // getDocumentsInformation(idSolicitud);
                alerts.showNotification("top", "right", action == 1 ? "El documento se ha cargado con éxito." : action == 2 ? "El documento se ha eliminado con éxito." : action == 4 ? "Los motivos de rechazo se han asociado de manera exitosa para el documento." : "El documento ha sido validado correctamente.", "success");
                if(details == 1){
                    var tr = $(`#trees${idSolicitud}`).closest('tr');
                    var row = escrituracionTable.row(tr);
                    createDocRow(row, tr, $(`#trees${idSolicitud}`));
                }
                else{
                    escrituracionTable.ajax.reload();
                }
                // $("#uploadModal").modal("hide");
            } else if (response == 0) alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
            else if (response == 2) alerts.showNotification("top", "right", "No fue posible almacenar el archivo en el servidor.", "warning");
            else if (response == 3) alerts.showNotification("top", "right", "El archivo que se intenta subir no cuenta con la extención .xlsx", "warning");
            $('#spiner-loader').addClass('hide');
        }, error: function () {
            $("#sendRequestButton").prop("disabled", false);
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
})
$(document).on('change', '.selectpicker.notaria-select', async function(e){
    if ($(this).val()) {
        let descripcion = {};
        let iconSave = $(this).parent().next().find('.icon-save');
        iconSave.removeClass('inactive');
        iconSave.addClass('active');
        descripcion = await getDescriptionNotaria($(this).val());
        $(this).parent().parent().next().text(descripcion.direccion);
    }
})

$(document).on('click', '.saveNotaria', function() {
    let tr = $(this).closest('tr');
    let select = tr.find('select').val();
    if (tr.find('select').val()) {
        saveNotaria($(this).attr('data-idSolicitud'), select, $(this));
    }
})

$(document).on('click', '.modalPresupuestos', function(){
    let idNxS = $(this).attr('data-idNxS');
    $("#idNxS").val(idNxS);
    buildUploadCards(idNxS);
    $('#loadPresupuestos').modal();
})

$(document).on('click', '.modalCopiaCertificada', function(){
    let idNxS = $(this).attr('data-idNxS2');
    $("#idNxS2").val(idNxS);
    buildUploadCards(idNxS);
    $('#loadPresupuestos').modal();
})

// inicia el llenado de la tabla para las solicitudes
function fillTable(beginDate, endDate, estatus) {
        escrituracionTable = $('#escrituracion-datatable').DataTable({
        dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        pagingType: "full_numbers",
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            {
                data: function (d) {
                    return d.id_solicitud
                }

            },
            {
                data: function (d) {
                    return d.nombreResidencial
                }

            },
            {
                data: function (d) {
                    return d.nombreLote
                }
            },
            {
                data: function (d) {
                    return d.cliente;
                }
            },
            {
                data: function (d) {
                    return d.fecha_creacion;
                }
            },
            {
                data: function (d) {
                    //return `<center><span><b>${d.idEstatus == 91 ? '1/2':d.idEstatus == 92 ? 3:d.idEstatus} - ${d.estatus}</b></span><center>`;   
                    return `<center><span><b> ${d.nombre_estatus}</b></span><center>`;   
                    // <center><span>(${d.area})</span><center></center>
                }
            },
            {
                
                data: function (d) {
                    //return d.tipo == 1 || d.tipo == 3 ? d.comentarios : d.tipo == 2 || d.tipo == 4? d.motivos_rechazo : d.tipo == 5 ? '':'';
                    return `<center>${d.area}</center>`;
                }
            },
            {
                data: function (d) {
                    //return d.tipo == 1 || d.tipo == 3 ? d.comentarios : d.tipo == 2 || d.tipo == 4? d.motivos_rechazo : d.tipo == 5 ? '':'';
                    return d.ultimo_comentario;
                 }
            },
            {
                data: function (d) {
                    return  `<span class="label" style="background:#F5B7B1; color:#78281F;">${d.rechazo}</span><span class="label" style="background:#A9CCE3; color:#154360;">${d.vencimiento}</span>`;
                }
            },
            {
                data: function (d) {
                    var aditional;
                    var group_buttons = '';     
                    let btnsAdicionales = ''; //variable para botones que se envian a la funcion de permisos
                    let exp;
                    let permiso;
                    let bandera_request=0;
                    var datosEstatus = {
                        area_sig: d.area_sig,
                        nombre_estatus_siguiente: d.nombre_estatus_siguiente,
                    }; 

                    switch (d.id_estatus) {
    
                            case 1: 
                                bandera_request = userType == 55 ? 1 : 0;
                            break;
                            case 2:
                                //ADMINISTRACIÓN Y COMITÉ TÉCNICO AUN NO DAN SU ESTATUS
                                if (userType == 11 || userType == 56) { 
                                    group_buttons += userType == 56 ?
                                     `<button id="estatusL" data-estatus-construccion="${d.estatus_construccion}" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Estatus del lote"><i class="fas fa-tools"></i></button>` :
                                     `<button id="informacion" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Información"><i class="fas fa-info"></i></button>`;
                                   bandera_request = userType == 11 && (d.cliente_anterior != null && d.cliente_anterior != 0 ) ? 1 
                                     : userType == 56 && (d.estatus_construccion != 0 && d.estatus_construccion != null) ? 1  : 0;
                                    }
                            break;
                            case 3:
                                //ADMINISTRACIÓN Y COMITÉ TÉCNICO YA DIERON SU ESTATUS
                                if (userType == 55 && d.bandera_admin == 1 && d.bandera_comite == 1) {
                                    /**COMITÉ Y ADMIN DIERON SU ESTATUS, ADMIN FUE EL ULTIMO EN DAR ESTATUS */
                                      // BOTON APROBAR    
                                    bandera_request = d.contrato == 1 ? 1 : 0;
                                    group_buttons += `<button id="docs${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey details-control-otros" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
                                    group_buttons +=`<button id="informacion" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Información"><i class="fas fa-info"></i></button>`;
                                    group_buttons += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="left" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                                }
                                if (userType == 56 && d.bandera_admin == 1 && (d.bandera_comite == 0 ||  d.bandera_comite == null)) { 
                                /**SI COMITÉ TÉCNICO NO HA DADO SU ESTATUS Y ADMINISTRACIÓN SI*/
                                    // BOTON APROBAR
                                    group_buttons +=  d.estatus_construccion != 0 && d.estatus_construccion != null ? `<button id="request" data-siguiente-area="${d.area_sig}" data-siguiente_actividad="${d.nombre_estatus_siguiente}" data-type="5" class="btn-data btn-green" data-toggle="tooltip" data-placement="left" title="Aprobar"><i class="fas fa-paper-plane"></i></button>` :'';
                                    group_buttons += `<button id="estatusL" data-estatus-construccion="${d.estatus_construccion}" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Estatus del lote"><i class="fas fa-tools"></i></button>`;   
                              }
                              break;
                            case 4:
                                //ADMINISTRACIÓN Y COMITÉ TÉCNICO YA DIERON SU ESTATUS
                                if (userType == 55 && d.bandera_admin == 1 && d.bandera_comite == 1) {      
                                    /**COMITÉ Y ADMIN DIERON SU ESTATUS, COMITÉ FUE EL ULTIMO EN DAR ESTATUS */
                                    // BOTON APROBAR  
                                    group_buttons += `<button id="docs${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey details-control-otros" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
                                    group_buttons += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="left" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                                    bandera_request = d.contrato == 1 ? 1 : 0;
                                }
                                if (userType == 11 && (d.bandera_admin == 0 || d.bandera_admin == null) && d.bandera_comite == 1) {
                                /**SI ADMIN NO HA DADO SU ESTATUS Y COMITÉ SI */ 
                                    // BOTON APROBAR
                                    bandera_request = userType == 11 && (d.cliente_anterior != null && d.cliente_anterior != 0 ) ? 1 : 0;
                                    group_buttons += `<button id="informacion" data-area-actual="${userType}" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Información"><i class="fas fa-info"></i></button>`;
                                }
                            break;
                            case 5:
                                if (userType == 11) { 
                                    bandera_request = 1;
                                    group_buttons += `<button id="informacion" data-area-actual="${userType}" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Información"><i class="fas fa-info"></i></button>`;
                                }
                            break;
                            case 7:
                                if (userType == 55 && d.bandera_admin == 1 && d.bandera_comite == 1) {      
                                    /**COMITÉ Y ADMIN DIERON SU ESTATUS, COMITÉ FUE EL ULTIMO EN DAR ESTATUS */
                                    // BOTON APROBAR
                                    bandera_request = 1;
                                    group_buttons += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="left" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                                }
                            break;
                            case 6:
                            case 8:
                            case 10:
                                if (userType == 55 && d.bandera_admin == 1 && d.bandera_comite == 1) {
                                    group_buttons += `<button id="docs${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey details-control-otros" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
                                    group_buttons +=`<button id="informacion" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Información"><i class="fas fa-info"></i></button>`;
                                    group_buttons += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="left" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                                    bandera_request = d.contrato == 1 ? 1 : 0;
                                }
                            break;
                            case 9:
                            case 11:
                                if (userType == 55) { 
                                    group_buttons += (d.nombre_a_escriturar != 0 && d.nombre_a_escriturar != null) ? `<button id="request" data-siguiente-area="${d.area_sig}" data-siguiente_actividad="${d.nombre_estatus_siguiente}" data-type="5" class="btn-data btn-green" data-toggle="tooltip" data-placement="left" title="Aprobar"><i class="fas fa-paper-plane"></i></button>` : '';
                                    group_buttons += `<button id="presupuesto" data-area-actual="${userType}" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Información"><i class="fas fa-info"></i></button>`;// `<button id="presupuesto" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Presupuesto"><i class="fas fa-coins"></i></button>`; 
                                    group_buttons += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="left" title="Rechazar"><i class="fas fa-ban"></i></button>`;                           
                                }
                            break;
                            case 12:
                            case 36:
                                if (userType == 57) { 
                                   btnsAdicionales += `<button id="request" data-siguiente-area="${d.area_sig}" data-siguiente_actividad="${d.nombre_estatus_siguiente}" data-type="5" class="btn-data btn-green" data-toggle="tooltip" data-placement="left" title="Aprobar"><i class="fas fa-paper-plane"></i></button>`;
                                   permiso = 2;
                                   group_buttons += permisos(permiso,  d.expediente, d.idDocumento, d.tipo_documento, d.id_solicitud, 1, btnsAdicionales,datosEstatus);
                                }
                            break;
                            case 13:
                            case 37:
                            case 16:
                                if (userType == 57) { 
                                    bandera_request = d.banderaPresupuesto == 1 ? 1 : 0;
                                    group_buttons += `<button id="treePresupuesto${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey treePresupuesto" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="Desglose presupuestos"><i class="fas fa-chevron-down"></i></button>`;
                                }
                            break;
                            case 14:
                            case 17:
                            case 38:
                                if (userType == 55) { 
                                    group_buttons += `<button id="request" data-siguiente-area="${d.area_sig}" data-siguiente_actividad="${d.nombre_estatus_siguiente}" data-type="5" class="btn-data btn-green" data-toggle="tooltip" data-placement="left" title="Aprobar"><i class="fas fa-paper-plane"></i></button>`;
                                    group_buttons += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="left" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                                    group_buttons += `<button id="treePresupuesto${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey treePresupuesto" data-permisos="2" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="Desglose presupuestos"><i class="fas fa-chevron-down"></i></button>`;

                                }
                            break;
                            case 15:
                                if (userType == 55) { 
                                    bandera_request = 1;
                                }
                            break;
                            case 18:
                            case 21:
                                if (userType == 11) { 
                                    bandera_request = d.expediente != null ? 1 : 0;
                                    permiso=1;
                                    group_buttons += permisos(permiso,  d.expediente, d.idDocumento, d.tipo_documento, d.id_solicitud, 2, btnsAdicionales,datosEstatus);
                                }
                            break;
                            case 19:
                            case 22:
                            case 24:
                                if (userType == 55) { 
                                    //BOTONES DANI
                                    group_buttons += `<button id="newNotary" data-idSolicitud=${d.id_solicitud} class="btn-data btn-sky" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="Nueva Notaría"><i class="fas fa-user-tie"></i></button>`;
                                    group_buttons += ` <button id="subirDocumentos" name="subirDocumentos" data-type="1" class="btn-data btn-green subirDocumentos " data-toggle="tooltip" data-info="${d.id_estatus}" data-solicitud='${d.id_solicitud}' data-placement="top" title="documentos"><i class="fas fa-folder-open"></i></button>`;
                                    group_buttons += `<button id="request" data-siguiente-area="${d.area_sig}" data-siguiente_actividad="${d.nombre_estatus_siguiente}" data-type="5" class="btn-data btn-green" data-toggle="tooltip" data-placement="left" title="Aprobar"><i class="fas fa-paper-plane"></i></button>`;
                                    group_buttons += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="left" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                                }
                            break;
                            case 20:
                            case 25:
                            case 34:
                                if (userType == 57) { 
                                    //BOTONES DANI
                                    group_buttons += `<button id="request" data-siguiente-area="${d.area_sig}" data-siguiente_actividad="${d.nombre_estatus_siguiente}" data-type="5" class="btn-data btn-green" data-toggle="tooltip" data-placement="left" title="Aprobar"><i class="fas fa-paper-plane"></i></button>`;
                                    group_buttons += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="left" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                                }
                            break;
                            case 23:
                                if (userType == 57) { 
                                    //BOTONES DANI
                                    group_buttons += `<button id="request" data-siguiente-area="${d.area_sig}" data-siguiente_actividad="${d.nombre_estatus_siguiente}" data-type="5" class="btn-data btn-green" data-toggle="tooltip" data-placement="left" title="Aprobar"><i class="fas fa-paper-plane"></i></button>`;
                                    group_buttons += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="left" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                                }
                            break;
                            case 26:
                                if (userType == 57) {

                                    group_buttons += d.fecha_firma != null ? '' : `<button id="createDate" data-idSolicitud=${d.id_solicitud} data-action="3" data-idNotaria=${d.id_notaria} class="btn-data btn-green" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="Fecha para firma"><i class="far fa-calendar-alt"></i></button>`;
                                    bandera_request = d.fecha_firma != null ? 1 : 0;

                                }
                            break;
                            case 27:
                                if (userType == 55) {
                                    //revisar si se muestran mas datos o solo avance
                                    bandera_request = 1;
                                }
                            break;
                            case 28:
                            case 31:
                                if (userType == 55) {
                                    //revisar si se muestran mas datos o solo avance
                                    bandera_request = 1;
                                    group_buttons +=  `<button id="newDate" data-idSolicitud=${d.id_solicitud} data-idNotaria=${d.id_notaria} class="btn-data btn-orangeYellow"  data-toggle="tooltip" data-placement="left"  title="Nueva fecha"><i class="fas fa-calendar-alt"></i></i></button>`;
                                    group_buttons += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="left" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                                }
                            break;
                            case 29:
                            case 40:
                                if (userType == 57) {
                                    //revisar si se muestran mas datos o solo avance
                                    bandera_request = d.expediente != null ? 1 : 0;
                                    group_buttons += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="left" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                                    permiso=1;
                                    group_buttons += permisos(permiso,  d.expediente, d.idDocumento, d.tipo_documento, d.id_solicitud, 2, btnsAdicionales,datosEstatus);
                                }
                            break;
                            case 30:
                                if (userType == 57) {
                                    //revisar si se muestran mas datos o solo avance
                                    group_buttons += `<button id="createDate" data-idSolicitud=${d.id_solicitud} data-action="3" data-idNotaria=${d.id_notaria} class="btn-data btn-green" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="Fecha para firma"><i class="far fa-calendar-alt"></i></button>`;
                                    bandera_request = 1;
                                }
                            break;
                            case 33:
                            case 41:
                                    if (userType == 55) {
                                        //revisar si se muestran mas datos o solo avance
                                        group_buttons += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="left" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                                        bandera_request = d.expediente != null ? 1 : 0;
                                        permiso=2;
                                        group_buttons += permisos(permiso,  d.expediente, d.idDocumento, d.tipo_documento, d.id_solicitud, 2, btnsAdicionales,datosEstatus);
                                    }
                            break;
                            case 39:
                            case 44:
                                    if (userType == 11) { 
                                        bandera_request = d.expediente != null ? 1 : 0;
                                        permiso = 1;
                                        group_buttons += permisos(permiso,  d.expediente, d.idDocumento, d.tipo_documento, d.id_solicitud, 1, btnsAdicionales,datosEstatus);
                                    }
                            break;
                            case 42:
                            case 45:
                                    if (userType == 55) { 
                                        bandera_request = d.expediente != null ? 1 : 0;
                                        group_buttons += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="left" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                                        permiso = 2;
                                        group_buttons += permisos(permiso,  d.expediente, d.idDocumento, d.tipo_documento, d.id_solicitud, 1, btnsAdicionales,datosEstatus);
                                    }
                            break;
                            case 43:
                                if (userType == 55) {
                                    //revisar si se muestran mas datos o solo avance
                                    group_buttons += d.fecha_firma != null ? '' : `<button id="createDate" data-idSolicitud=${d.id_solicitud} data-action="3" data-idNotaria=${d.id_notaria} class="btn-data btn-green" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="Fecha para firma"><i class="far fa-calendar-alt"></i></button>`;
                                    bandera_request = 1;
                                }
                            break;
                            case 46:
                            case 52:
                                if (userType == 57) { 
                                    bandera_request = d.expediente != null ? 1 : 0;
                                    permiso = 1;
                                    group_buttons += permisos(permiso,  d.expediente, d.idDocumento, d.tipo_documento, d.id_solicitud, 1, btnsAdicionales,datosEstatus);
                                }
                            break;
                            case 47:
                            case 50:
                                if (userType == 57) { 
                                    bandera_request = d.expediente != null ? 1 : 0;
                                    permiso = 1;
                                    group_buttons += permisos(permiso,  d.expediente, d.idDocumento, d.tipo_documento, d.id_solicitud, 1, btnsAdicionales,datosEstatus);
                                }
                            break;
                            case 37:
                                if (userType == 57) { 
                                    group_buttons += `<button id="request" data-siguiente-area="${d.area_sig}" data-siguiente_actividad="${d.nombre_estatus_siguiente}" data-type="5" class="btn-data btn-green" data-toggle="tooltip" data-placement="left" title="Aprobar"><i class="fas fa-paper-plane"></i></button>`;
                                }
                            break;
                            case 38:
                                if (userType == 55) { 
                                    group_buttons += `<button id="request" data-siguiente-area="${d.area_sig}" data-siguiente_actividad="${d.nombre_estatus_siguiente}" data-type="5" class="btn-data btn-green" data-toggle="tooltip" data-placement="left" title="Aprobar"><i class="fas fa-paper-plane"></i></button>`;
                                    group_buttons += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="left" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                                }
                            break;
                      
                        default:
                            break;
                    }
                    $('[data-toggle="tooltip"]').tooltip();
                    if(bandera_request == 1){
                        group_buttons += `<button id="request" data-siguiente-area="${d.area_sig}" data-siguiente_actividad="${d.nombre_estatus_siguiente}" data-type="5" class="btn-data btn-green" data-toggle="tooltip" data-placement="left" title="Aprobar"><i class="fas fa-paper-plane"></i></button>`;
                    }
                       group_buttons += `<button data-idSolicitud=${d.id_solicitud} data-lotes=${d.nombreLote} class="btn-data btn-details-grey comentariosModel" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="Comentarios Proceso"><i class="fas fa-sticky-note"></i></button>`;
                    return '<div class="d-flex justify-center">' + group_buttons + '<div>';
                }
            },
        ],
        columnDefs: [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        }
        ],
        ajax: {
            url: 'getSolicitudes',
            type: "POST",
            cache: false,
            data: {
                "beginDate": beginDate,
                "endDate": endDate,
                "estatus":estatus,
                "tipo_tabla": 0
            }
        }

    });
};

// Finaliza el llenado de la tabla para las solicitudes

// Inicia el llenado para la tabla de carga testimonio
function fillTableCarga(beginDate, endDate, estatus) {
    escrituracionTableTest = $('#carga-datatable').DataTable({
    dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: "100%",
    scrollX: true,
    pagingType: "full_numbers",
    language: {
        url: "../static/spanishLoader_v2.json",
        paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>"
        }
    },
    destroy: true,
    ordering: false,
    columns: [
        {
            data: function (d) {
                return d.id_solicitud
            }
        },
        {
            data: function (d) {
                return d.nombreResidencial
            }
        },
        {
            data: function (d) {
                return d.nombreLote
            }
        },
        {
            data: function (d) {
                return d.cliente;
            }
        },
        {
            data: function (d) {
                return d.fecha_creacion;
            }
        },
        {
            data: function (d) {
                return `<center><span><b> ${d.nombre_estatus}</b></span><center>`;   
            }
        },
        {
            data: function (d) {
                return `<center>${d.area}</center>`;
            }
        },
        {
            data: function (d) {
                //return d.tipo == 1 || d.tipo == 3 ? d.comentarios : d.tipo == 2 || d.tipo == 4? d.motivos_rechazo : d.tipo == 5 ? '':'';
                return d.ultimo_comentario
            }
        },
        {
            data: function (d) {
                return  `<span class="label" style="background:#F5B7B1; color:#78281F;">${d.rechazo}</span><span class="label" style="background:#A9CCE3; color:#154360;">${d.vencimiento}</span>`;
            }
        },
        {
            data: function (d) {
                var aditional;
                var group_buttons = '';     
                let formBoton = '';
                let permiso;
                let bandera_request=0;
                var datosEstatus = {
                    area_sig: d.area_sig,
                    nombre_estatus_siguiente: d.nombre_estatus_siguiente,
                }; 
                switch (d.id_estatus) {
                        case 47:
                        case 50: 
                        if (userType == 57) { 
                            bandera_request = d.expediente != null ? 1 : 0;
                            permiso = 1;
                            group_buttons += permisos(permiso,  d.expediente, d.idDocumento, d.tipo_documento, d.id_solicitud, 1, btnsAdicionales,datosEstatus);
                        }
                        break;
                    default:
                        break;
                }
                $('[data-toggle="tooltip"]').tooltip();
                if(bandera_request == 1){
                    group_buttons += `<button id="request" data-siguiente-area="${d.area_sig}" data-siguiente_actividad="${d.nombre_estatus}" data-type="5" class="btn-data btn-green" data-toggle="tooltip" data-placement="left" title="Aprobar"><i class="fas fa-paper-plane"></i></button>`;
                }
                group_buttons += `<button data-idSolicitud=${d.id_solicitud} data-lotes=${d.nombreLote} class="btn-data btn-details-grey comentariosModel" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="Comentarios Proceso"><i class="fas fa-sticky-note"></i></button>`;
                return '<div class="d-flex justify-center">' + group_buttons + '<div>';
            }
        },
    ],
    columnDefs: [{
        "searchable": true,
        "orderable": false,
        "targets": 0
    }
    ],
    ajax: {
        url: 'getSolicitudes',
        type: "POST",
        cache: false,
        data: {
            "beginDate": beginDate,
            "endDate": endDate,
            "estatus": 0,
            "tipo_tabla": 1
        }
    }

});
};
// Termina el llenado para la tabla de carga testimonio

function email(idSolicitud, action, notaria = null, valuador= null) {
    $('#spiner-loader').removeClass('hide');
    let obj;
    switch (action) {
        case '1':
            obj = {idSolicitud: idSolicitud, notaria: notaria, valuador: valuador};
            break;
        case '2':
            obj = {idSolicitud: idSolicitud};
            break;
        case '3':
            obj = {idSolicitud: idSolicitud};
            break;
        case '4':
            obj = {idSolicitud: idSolicitud};
            break;
        case '5':
            obj = {idSolicitud: idSolicitud};
            break;
    }
    $.post(action == 1 ? 'mailPresupuesto': action == 2 ? 'presupuestoCliente': action  == 3 ? 'mailNotaria': action  == 4 ? 'mailFecha':'mailPresupuesto', obj, function (data) {
        // if(data == true){//cambiar a true
        // }
        changeStatus(idSolicitud, action == 1 ? 4:0, 'correo enviado', 1);

        $('#spiner-loader').addClass('hide');
    }, 'json');
}

function setInitialValues() {
    // BEGIN DATE
    const fechaInicio = new Date();
    // Iniciar en este año, este mes, en el día 1
    const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
    // END DATE
    const fechaFin = new Date();
    // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
    const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
    finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
    finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
    finalBeginDate2 = [('0' + beginDate.getDate()).slice(-2), ('0' + (beginDate.getMonth() + 1)).slice(-2), beginDate.getFullYear()].join('/');
    finalEndDate2 = [('0' + endDate.getDate()).slice(-2), ('0' + (endDate.getMonth() + 1)).slice(-2), endDate.getFullYear()].join('/');
    
    $('#beginDate').val(finalBeginDate2);
    $('#endDate').val(finalEndDate2);
    $('#startDate').val(finalBeginDate);
    $('#finalDate').val(finalEndDate2);
/*cuando se carga por primera vez, se mandan los valores en cero, para no filtar por mes*/
    fillTable(0, 0, $('#estatusE').val());
    fillTableCarga(0, 0, $('#estatusE').val());
}

function getMotivosRechazos(tipo_documento,estatus) {
    document.getElementById('area_selected').innerHTML = '';
    $('#spiner-loader').removeClass('hide');
    $("#motivos_rechazo").find("option").remove();
    $("#motivos_rechazo").append($('<option disabled>').val("0").text("Seleccione una opción"));
    $("#area_rechazo").find("option").remove();
    $("#area_rechazo").append($('<option disabled>').val("0").text("Seleccione una opción"));
    let showSelect = estatus == 3 || estatus == 4 || estatus == 29 ? 'show' : 'none';

    //estatus = estatus == 3 || estatus == 4 ? '3,4' : estatus;
    if(estatus != 3 && estatus != 4){
        $('#area_rechazo').prop('required', false);
    }
    document.getElementById("rechazo").style.display = showSelect;

    $.post('getMotivosRechazos', {
        tipo_documento: tipo_documento,
        estatus: estatus
    }, function (data) {
        console.log(data);
        var len = data.dataMotivos.length;
        var len2 = data.dataEstatus.length;
        console.log(data.dataMotivos);
        for (var i = 0; i < len; i++) {
            var id = data.dataMotivos[i]['id_motivo'];
            var name = data.dataMotivos[i]['motivo'];
            $("#motivos_rechazo").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#motivos_rechazo").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }

        for (var i = 0; i < len2; i++) { 
            var id = data.dataEstatus[i]['estatus_siguiente']+','+data.dataEstatus[i]['nombre_siguiente'];
            var name = data.dataEstatus[i]['actividad_actual'] +' - '+ data.dataEstatus[i]['nombre_siguiente'];
            var descripcion = data.dataEstatus[i]['nombre_siguiente'];
            $("#area_rechazo").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#area_rechazo").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#motivos_rechazo").selectpicker('refresh');
        $("#area_rechazo").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

$(document).on('change', '#area_rechazo', function () {
    var input = $(this).val();
    let datos = input.split(',');
        document.getElementById('area_selected').innerHTML = datos[1];
    
});

function getDocumentsClient(idEscritura) {
    $('#spiner-loader').removeClass('hide');
    $("#documents").find("option").remove();
    $("#documents").append($('<option disabled>').val("0").text("Seleccione una opción"));
    $.post('getDocumentsClient', {
        idEscritura: idEscritura,
        idEstatus:idEstatus
    }, function (data) {        
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idDocumento'];
            var name = data[i]['nombre'];
            $("#documents").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#documents").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#documents").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

function getNotarias(datos=null) {
    $('#spiner-loader').removeClass('hide');
    // $("#notaria").find("option").remove();
    $(".notaria-select").find("option").remove();
    // $("#notaria").append($('<option disabled>').val("0").text("Seleccione una opción"));
    $(".notaria-select").append($('<option disabled>').val("0").text("Seleccione una opción"));

    $.post('getNotarias', function (data) {
        console.log(data.data)
        console.log(data[0])
        data = data.data;
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idNotaria'];
            var name = data[i]['nombre_notaria'];
            // $("#notaria").append($('<option>').val(id).text(name));
            $(".notaria-select").append($('<option>').val(id).text(name));

        }
        if (len <= 0) {
            // $("#notaria").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
            $(".notaria-select").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
       console.log('GET NOTARIAS')
       console.log(datos)
        // $("#notaria").selectpicker('refresh');
        $(".notaria-select").selectpicker('refresh');
        if(datos != null){
            console.log('ENTRA AL DATOS != NULL')
            let selects = $(`#notarias-${datos.id_solicitud}`).find('.selectpicker.notaria-select');
       console.log('selects1',selects);
       selects.each( function( index, element ){
           console.log('selects',element.id);
        //    $(`#${element.id}`).val(datos.notarias[index] ? datos.notarias[index].id_notaria:null);
        //    console.log('val',$(`#${element.id}`).val())
        //    $(`#${element.id}`).selectpicker('refresh');

           $(`#${element.id}`).selectpicker('val', datos.notarias[index] ? datos.notarias[index].id_notaria:null);
           $(`#${element.id}`).trigger('change');
       });
       }
       
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

    function getValuadores() {
        $('#spiner-loader').removeClass('hide');
        $("#valuador").find("option").remove();
        $("#valuador").append($('<option disabled>').val("0").text("Seleccione una opción"));
        $.post('getValuadores', function(data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['idValuador'];
                var name = data[i]['perito'];
                $("#valuador").append($('<option>').val(id).text(name));
            }
            if (len <= 0) {
                $("#valuador").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
            }
            $("#valuador").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }, 'json');
    }

    function getBudgetInfo(idSolicitud){
        $('#spiner-loader').removeClass('hide');
        getEstatusPago();
        getTipoEscrituracion();
        $.post('getBudgetInfo',{
            idSolicitud:idSolicitud
        }, function(data) {
            $('#nombrePresupuesto').val(data.nombre);
            $('#nombrePresupuesto2').val(data.nombre_a_escriturar);
            //$('#estatusPago').val(data.estatus_pago).trigger('change');
          //  $('select[name=estatusPago]').val(data.estatus_pago);
          $("#estatusPago").selectpicker();
          $('#estatusPago').val(data.estatus_pago);
          $('select[name=estatusPago]').change();
       //   $('select[name=estatusPago]').val(data.estatus_pago);
       //   $('select[name=estatusPago]').change();
           // $("#estatusPago").selectpicker('refresh');
           $('#aportaciones').val(data.aportacion);
           $('#descuentos').val(data.descuento);
           $('#motivo').val(data.motivo);
           $('#superficie').val(data.superficie);

            $('#superficie').val(data.superficie);
            var str = (data.modificado).split(" ")[0].split("-");
            var strM = `${str[2]}-${str[1]}-${str[0]}`;
            $('#fContrato').val(strM);
            $('#catastral').val(data.clave_catastral);
            $('#construccionInfo').val(data.nombreConst);
            $('#cliente').val(data.cliente_anterior == 1 ? 'uno':'dos').trigger('change');
            $("#cliente").selectpicker('refresh');
            $('#nombreT').val(data.nombre_anterior);
            let fechaAnterior =data.fecha_anterior != null ? data.fecha_anterior.split(" ")[0].split("-").reverse().join("-") :data.fecha_anterior;
            $('#fechaCA').val(fechaAnterior);
            $('#rfcDatos').val(data.RFC);
            $("#encabezado").html(`${data.nombreResidencial} / ${data.nombreCondominio} / ${data.nombreLote}`);
            //$('#tipoE').val(data.tipo_escritura).trigger('change');
           // $("#tipoE").selectpicker('refresh');

            $("#tipoE").selectpicker();
            $('#tipoE').val(data.tipo_escritura);
            $('select[name=tipoE]').change();

            $('#tipoNotaria').val(data.id_notaria != 0 ? 2 : 1).trigger('change');
            $("#tipoNotaria").selectpicker('refresh');
            
            $('#nombre_notaria').val(data.id_notaria != 0 ? data.nombre_notaria : '');
            $('#nombre_notario').val(data.id_notaria != 0 ? data.nombre_notario : '');
            $('#direccion').val(data.id_notaria != 0 ? data.direccion : '');
            $('#correo').val(data.id_notaria != 0 ? data.correo : '');
            $('#telefono').val(data.id_notaria != 0 ? data.telefono : '');
            

            $('#spiner-loader').addClass('hide');
    }, 'json');
}

function checkBudgetInfo(idSolicitud) {
    $('#spiner-loader').removeClass('hide');
    $.post('checkBudgetInfo', {
        idSolicitud: idSolicitud
    }, function (data) {
        $('#nombrePresupuesto3').val(data.nombre);
        $('#nombrePresupuesto4').val(data.nombre_escrituras);
        $('#estatusPago2').val(data.nombrePago);
        $('#superficie2').val(data.superfice);
        $('#fContrato2').val(data.modificado);
        $('#catastral2').val(data.clave_catastral);
        $('#construccion2').val(data.nombreConst);
        $('#cliente2').val(data.cliente_anterior == 1 ? 'uno':'dos').trigger('change');
        $("#cliente2").selectpicker('refresh');
        $('#nombreT2').val(data.nombre_anterior);
        $('#fechaCA2').val(data.fecha_anterior);
        $('#rfcDatos2').val(data.RFC);
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

function formatDate(date) {
    var dateParts = date.split("/");
    var d = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;

    return [year, month, day].join('-');
}

function formatDate2(date) {
    var dateParts = date.split("/");
    let timePart = dateParts[2].split(" ");
    let timeParts = timePart[1].split(':');
    var d = new Date(+timePart[0], dateParts[1] - 1, +dateParts[0], timeParts[0], timeParts[1]),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
        time = d.getTime();

    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;
    let newDate = [year, month, day].join('-') + ' ' + timeParts[0] + ':' + timeParts[1];
    return newDate;
}


function sino() {
    $("#cliente").find("option").remove();
    $("#cliente").append($('<option disabled>').val(0).text("Seleccione una opción"));
    $("#cliente").append($('<option>').val(1).text('si'));
    $("#cliente").append($('<option>').val(2).text('no'));
    $("#cliente").selectpicker('refresh');
}

function displayInput(idDocumento) {
    $("#uploadedDocument2").attr('data-idDoc', idDocumento);
    $("#documentsSection").removeClass("hide");
}

function permisos(permiso, expediente, idDocumento, tipo_documento, idSolicitud, banderaBoton, BtnsAdicionales,datosEstatus) {
/**
 * MO: Esta función recibe 8 parametros
 * permiso: 1 escritura, 2 lectura, 3 especial (ver botones adicionales, ver archivos, rechazar solicitud y avanzar solicitud), 4 especial (especial ver botones adicionales y avanzar solicitud)
 * expediente: columna de la db con el nombre del archivo enviado
 * idDocumento: ID del documentos de la tabla documentos_escrituración
 * tipo_documento: tipo documento de la tabla documentos_escritutación y catalago documentación_escrituración
 * idSolicutd: ID de la solicitud en uso
 * BanderaBoton: Este parametro se usa para saber si hay botones declados en el datatable y enviados a esta funcion para concatenarlos con los botones creados en esta función
 * BanderaBoton: 2 no hay botones adicionales, 1 si hay botones adicionales
 * BtnsAdicionales: parametro donde vienen los botones declarados en el datatable para concatenarlos con los botones creados en esta fución
 * datosEstatus: es un array donde vienen datos del área siguiente solo para mostrarlos en el modal de avance
 *  */  

    let botones = '';
    switch (permiso) {
        case 0:
            botones += ``;
            break;
        case 1: //escritura
            if (expediente == null || expediente == '' || expediente == 'null') {
                if (banderaBoton == 2) {
                    botones += `<button data-idDocumento="${idDocumento}" data-documentType="${tipo_documento}" data-idSolicitud=${idSolicitud} data-action=${expediente == null || expediente == '' ? 1 : 2} class="btn-data ${expediente == null || expediente == '' ? "btn-sky" : "btn-gray"} upload" data-toggle="tooltip" data-placement="left" title=${expediente == null || expediente == '' ? 'Cargar' : 'Eliminar'}>${expediente == null || expediente == '' ? '<i class="fas fa-upload"></i>' : '<i class="fas fa-trash"></i>'}</button>`;
                }else {
                    botones += `<button data-idDocumento="${idDocumento}" data-documentType="${tipo_documento}" data-idSolicitud=${idSolicitud} data-action=${expediente == null || expediente == '' ? 1 : 2} class="btn-data ${expediente == null || expediente == '' ? "btn-sky" : "btn-gray"} upload" data-toggle="tooltip" data-placement="left" title=${expediente == null || expediente == '' ? 'Cargar' : 'Eliminar'}>${expediente == null || expediente == '' ? '<i class="fas fa-upload"></i>' : '<i class="fas fa-trash"></i>'}</button>`;
                    botones += BtnsAdicionales;
                }
            } else {
                console.log('expediente cargado');
                if (banderaBoton == 2) {
                    console.log('adicional 2');
                    botones += `<button data-idDocumento="${idDocumento}" data-documentType="${tipo_documento}" data-idSolicitud=${idSolicitud} data-action=${expediente == null || expediente == '' ? 1 : 2} class="btn-data ${expediente == null || expediente == '' ? "btn-sky" : "btn-gray"} upload" data-toggle="tooltip" data-placement="left" title=${expediente == null || expediente == '' ? 'Cargar' : 'Eliminar'}>${expediente == null || expediente == '' ? '<i class="fas fa-upload"></i>' : '<i class="fas fa-trash"></i>'}</button>`;
                } else {
                    console.log('adicional 1');
                    botones += `<button data-idDocumento="${idDocumento}" data-documentType="${tipo_documento}" data-idSolicitud=${idSolicitud} data-action=${expediente == null || expediente == '' ? 1 : 2} class="btn-data ${expediente == null || expediente == '' ? "btn-sky" : "btn-gray"} upload" data-toggle="tooltip" data-placement="left" title=${expediente == null || expediente == '' ? 'Cargar' : 'Eliminar'}>${expediente == null || expediente == '' ? '<i class="fas fa-upload"></i>' : '<i class="fas fa-trash"></i>'}</button>`;
                    botones += BtnsAdicionales;
                }
                //VISTA PREVIA DOCUEMENTOS
                botones += `<button id="preview" data-doc="${expediente}" data-documentType="${tipo_documento}" class="btn-data btn-details-grey" data-toggle="tooltip" data-placement="left" title="Vista previa"><i class="fas fa-eye"></i></button>`;
                //SI YA SE CARGO LA COPIA CERTIFICADA AGREGAR BOTON PARA CARGAR OTRO ARCHIVO Y BLOQUEAR LA ACCIÓN DE ENVIAR
                //botones += `<button data-idDocumento="${idDocumento}" data-documentType="${tipo_documento}" data-idSolicitud=${idSolicitud} data-action="1" class="btn-data btn-sky upload" data-toggle="tooltip" data-placement="left" title="Cargar"><i class="fas fa-trash"></i></button>`;
              //PENDIENTE  botones += `<button id="request" data-siguiente-area="${datosEstatus.area_sig}" data-siguiente_actividad="${datosEstatus.nombre_estatus_siguiente}" class="btn-data btn-green" data-toggle="tooltip" data-placement="left" title="Enviar"><i class="fas fa-paper-plane"></i></button>`;
            }
            break;
        case 2: //lectura
            if (banderaBoton == 1) {
                botones += BtnsAdicionales;
            }
            if (expediente != 1) {
                botones += `<button id="preview" data-doc="${expediente}" data-documentType="${tipo_documento}" class="btn-data btn-details-grey" data-toggle="tooltip" data-placement="left" title="Vista previa"><i class="fas fa-eye"></i></button>`;
            }
            break;
        case 3: //especial ver botones adicionales, ver archivos, rechazar solicitud y avanzar solicitud
            if (expediente == null || expediente == '' || expediente == 'null') {
                if (banderaBoton == 1) {
                    botones += BtnsAdicionales;
                }
            } else {
                if (banderaBoton == 1) {
                    botones += BtnsAdicionales;
                }
                if (expediente != 1) {
                    botones += `<button id="preview" data-doc="${expediente}" data-documentType="${tipo_documento}" class="btn-data btn-details-grey" data-toggle="tooltip" data-placement="left" title="Vista previa"><i class="fas fa-eye"></i></button>`;
                    botones += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="left" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                }
                botones += '<button id="request" class="btn-data btn-green" data-toggle="tooltip" data-placement="left" title="Enviar"><i class="fas fa-paper-plane"></i></button>';

            }
            break;
        case 4: //especial ver botones adicionales y avanzar solicitud
            if (banderaBoton == 1) {
                botones += BtnsAdicionales;
            }
            if (expediente == 2) {// 2 CUANDO NINGÚN DOCUMENTO TENGA MOTIVOS DE RECHAZO
                botones += '<button id="request" class="btn-data btn-green" data-toggle="tooltip" data-placement="left" title="Enviar"><i class="fas fa-paper-plane"></i></button>';
            }
            break;
    }
    return '<div class="d-flex justify-center">'+botones+'</div>';
}

function buildTableDetail(data, permisos) {
    console.log('buildTableDetail')
    console.log(permisos)
    var filtered = data.filter(function(value){ 
        if(value.tipo_documento == 13 && value.estatusActual == 11 && value.estatusPropuesta != 1){
        }else{
            return value;
        }
    });
    var solicitudes = '<table class="table subBoxDetail">';
    solicitudes += '<tr style="border-bottom: 1px solid #fff; color: #4b4b4b;">';
    solicitudes += '<td>' + '<b>' + '# ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'DOCUMENTO ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'CARGADO POR ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'FECHA ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'MOTIVOS DE RECHAZO ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'VALIDADO POR ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'ESTATUS VALIDACIÓN ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'ACCIONES ' + '</b></td>';
    solicitudes += '</tr>';
    $.each(filtered, function (i, v) {

        //i es el indice y v son los valores de cada fila
        solicitudes += '<tr>';
        solicitudes += '<td> ' + (i + 1) + ' </td>';
        solicitudes += '<td> ' + v.descripcion + ' </td>';
        solicitudes += '<td> ' + v.documento_creado_por + ' </td>';
        solicitudes += '<td> ' + v.fecha_creacion + ' </td>';
        solicitudes += '<td> ' + v.motivos_rechazo + ' </td>';
        solicitudes += '<td> ' + v.validado_por + ' </td>';
        solicitudes += `<td> <span class="label" style="background:${v.colour}">${v.estatus_validacion}</span></td>`;
       //${v.editado == 1 ? `<br><span class="label" style="background:${v.colour}">EDITADO</span>`:``} Este frangmento va en la linea de arriba(a considerar)
        /*data-action = 1 (UPLOAD FILE)
        data-action = 2 (DELETE FILE)*/

        solicitudes += '<td><div class="d-flex justify-center">';
        // MJ: TIENE PERMISOS (ESCRITURA) && (LA RAMA ESTÁ SIN VALIDAR O RECHAZADA) && VALIDACIÓN ESTATUS
        if (permisos == 1 && (v.ev == null || v.ev == 2) && v.estatus_solicitud == 10 && (v.tipo_documento == 7 || v.tipo_documento == 13 || v.tipo_documento == 18)){
            solicitudes += ``;
            if(v.tipo_documento == 13){
                if(v.estatusPropuesta == null || v.estatusPropuesta == 0){
                    solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="3" class="btn-data btn-deepGray approve" data-toggle="tooltip" data-placement="left" title="Documento OK"><i class="fas fa-thumbs-up"></i></button>`;
                }else{
                    solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="4" class="btn-data btn-green approve" data-toggle="tooltip" data-placement="left" title="Documento NOK" disabled><i class="fas fa-thumbs-up"></i></button>`;
                }
            }
        }
        else if(permisos == 1 && (v.ev == null || v.ev == 2) && (v.estatus_solicitud == 3 || v.estatus_solicitud == 4 || v.estatus_solicitud == 6 || v.estatus_solicitud == 8 || v.estatus_solicitud == 10) && (v.tipo_documento == 17 || v.tipo_documento == 18) ) {
            console.log('ENTRA AQUI');
            solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="3" data-action=${v.expediente == null || v.expediente == '' ? 1 : 2} class="btn-data btn-${v.expediente == null || v.expediente == '' ? 'blueMaderas' : 'warning'} upload" data-toggle="tooltip" data-placement="left" title=${v.expediente == null || v.expediente == '' ? 'Cargar' : 'Eliminar'}>${v.expediente == null || v.expediente == '' ? '<i class="fas fa-upload"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
        console.log(solicitudes)
        }
        else if (permisos == 2 && v.estatus_solicitud == 5) {
            if(v.tipo_documento == 17 || v.tipo_documento == 18){
                solicitudes += ``;
            }
        }
        else if(permisos == 1 && (v.ev == null || v.ev == 2) && v.estatus_solicitud == 10){

            solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action=${v.expediente == null || v.expediente == '' ? 1 : 2} class="btn-data btn-${v.expediente == null || v.expediente == '' ? 'blueMaderas' : 'warning'} upload" data-toggle="tooltip" data-placement="left" title=${v.expediente == null || v.expediente == '' ? 'Cargar' : 'Eliminar'}>${v.expediente == null || v.expediente == '' ? '<i class="fas fa-upload"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
        }else if (permisos == 2 && v.estatus_solicitud == 11) {
            if(v.tipo_documento == 13 || v.tipo_documento == 7 || v.tipo_documento == 17 || v.tipo_documento == 18){
                solicitudes += ``;
            }else{
                if (v.ev == 1) // MJ: VALIDADO OK
                    solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="4" class="btn-data btn-warning upload" data-toggle="tooltip" data-placement="left" title="Documento NOK"><i class="fas fa-thumbs-down"></i></button>`;
                else if (v.ev == 2) // MJ: VALIDADO NOK
                    solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="3" class="btn-data btn-green upload" data-toggle="tooltip" data-placement="left" title="Documento OK"><i class="fas fa-thumbs-up"></i></button>`;
                else if (v.expediente != null) { // MJ: SIN VALIDAR
                    solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="3" class="btn-data btn-gray upload" data-toggle="tooltip" data-placement="left" title="Sin validar OK"><i class="fas fa-thumbs-up"></i></button>`;
                    solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="4" class="btn-data btn-gray upload" data-toggle="tooltip" data-placement="left" title="Sin validar NOK"><i class="fas fa-thumbs-down"></i></button>`;
                }
            }
        }
        else if (permisos == 1 && v.ev == null && v.estatus_solicitud == 13 && v.tipo_documento == 7){
            solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action=${v.expediente == null || v.expediente == '' ? 1 : 2} class="btn-data btn-${v.expediente == null || v.expediente == '' ? 'blueMaderas' : 'warning'} upload" data-toggle="tooltip" data-placement="left" title=${v.expediente == null || v.expediente == '' ? 'Cargar' : 'Eliminar'}>${v.expediente == null || v.expediente == '' ? '<i class="fas fa-upload"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
        }else if (permisos == 2 && v.ev == null && v.estatus_solicitud == 22 && (v.tipo_documento == 16 || v.tipo_documento == 22)){            
            solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="3" data-action=${v.expediente == null || v.expediente == '' ? 1 : 2} class="btn-data btn-${v.expediente == null || v.expediente == '' ? 'blueMaderas' : 'warning'} upload" data-toggle="tooltip" data-placement="left" title=${v.expediente == null || v.expediente == '' ? 'Cargar' : 'Eliminar'}>${v.expediente == null || v.expediente == '' ? '<i class="fas fa-upload"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;   
        }else if (permisos == 1 && v.ev == null && v.estatus_solicitud == 23 && (v.tipo_documento == 16 || v.tipo_documento == 22)){            
            solicitudes += ``;
        }

        if (v.expediente == null || v.expediente == '')
            solicitudes += '';
        else
            solicitudes += `<button id="preview" data-doc="${v.expediente}" data-documentType="${v.tipo_documento}" class="btn-data btn-gray" data-toggle="tooltip" data-placement="left" title="Vista previa"><i class="fas fa-eye"></i></button>`;

        solicitudes += '</div></td></tr>';

    });
    return solicitudes += '</table>';
}

function getSignDate(idNotaria) {
    let date = new Date();
    let i = 0;
    console.log(idNotaria);
    let dias = idNotaria == 1 ? 7 : idNotaria == 2 ? 7 : idNotaria == 3 ? 7 : idNotaria == 4 ? 7 : idNotaria == 5 ? 7 : idNotaria == 6 ? 7 : idNotaria == 10 ? 15 : idNotaria == 11 ? 15 : idNotaria == 12 ? 15 : 0;
    console.log(dias);

    while (i < dias) {//dias habiles despues del dia de hoy
        date.setTime(date.getTime() + 24 * 60 * 60 * 1000); // añadimos 1 día
        if (date.getDay() != 6 && date.getDay() != 0)
            i++;
    }
    let minutes = date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes();
    let fecha = date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear() + ' ' + date.getHours() + ':' + minutes;
    return fecha;
}

function changeStatus(id_solicitud, action, comentarios, type, notaria,area_rechazo = 0){
    $('#spiner-loader').removeClass('hide');
    $.post('changeStatus', {
        id_solicitud: id_solicitud,
        type: type,
        comentarios: comentarios,
        notaria: notaria,
        area_rechazo: area_rechazo
    }, function (data) {
        switch (action) {
            case 1: //MODAL PARA APROBAR LA SOLICITUD
                $('#approveModal').modal("hide");
                break;
            case 3: //MODAL PARA RECHAZAR LA SOLICITUD
                $('#rejectModal').modal("hide");
                break;
            case 2: //MODAL PARA FECHA DE FIRMA DEL CLIENTE
                $('#dateModal').modal("hide");
                break;
            case 4: //MODAL 
                $("#notarias").modal("hide");
                break;
            default:
                break;
        }   
           
        escrituracionTable.ajax.reload( null , false );
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

//INSERTAR NUEVA NOTARIA
$(document).on("submit", "#asignarNotaria", function (e) {
    e.preventDefault();
    let id_solicitud = $("#id_solicitud").val();
    let data = new FormData($(this)[0]);
    data.append('nombre_notaria', $('#nombre_notaria').val() == '' ? null : $('#nombre_notaria').val());
    data.append('nombre_notario', $('#nombre_notario').val() == '' ? null : $('#nombre_notario').val());
    data.append('direccion', $('#direccion').val() == '' ? null : $('#direccion').val());
    data.append('correo', $('#correo').val() == '' ? null : $('#correo').val());
    data.append('telefono', $('#telefono').val() == '' ? null : $('#telefono').val());
    data.append('id_solicitud', $('#id_solicitud').val() == '' ? null : $('#id_solicitud').val());

    $.ajax({
        url: "registrarNotaria",
        data: data,
        cache: false,
        contentType: false,
        processData: false, 
        type: 'POST',
        success: function (response) {
            if (response) {
            alerts.showNotification("top", "right", "Se asignó correctamente una Notaría.", "success");
            $("#altaNotario").modal("hide");
            escrituracionTable.ajax.reload();
            }else{
                alerts.showNotification("top", "right", "Error en asignar Notaría", "warning");
            }
        }
    });
});
//INSERTAR NUEVA NOTARIA
$(document).on("submit", "#newNotario", function (e) {
    e.preventDefault();
    let idSolicitud = $("#idSolicitud").val();
    let data = new FormData($(this)[0]);
    data.append('nombre_notaria', $('#nombre_notaria').val() == '' ? null : $('#nombre_notaria').val());
    data.append('nombre_notario', $('#nombre_notario').val() == '' ? null : $('#nombre_notario').val());
    data.append('direccion', $('#direccion').val() == '' ? null : $('#direccion').val());
    data.append('correo', $('#correo').val() == '' ? null : $('#correo').val());
    data.append('telefono', $('#telefono').val() == '' ? null : $('#telefono').val());
    data.append("idSolicitud", idSolicitud);
    //data.append('idSolicitud', $('#idSolicitud').val() == '' ? null : $('#idSolicitud').val());

    $.ajax({
        url: "nuevoNotario",
        data: data,
        cache: false,
        contentType: false,
        processData: false, 
        type: 'POST',
        success: function (response) {
            alerts.showNotification("top", "right", "Se agrego una nueva Notaría.", "success");
            $("#altaNotario").modal("hide");
            escrituracionTable.ajax.reload(null,false);
        }
    });
});
//MOSTRAR INFORMACION DE LA NOTARIA
$(document).on('click', '#notaria', function () {
    var data = escrituracionTable.row($(this).parents('tr')).data();
    getBudgetNotaria(data.idSolicitud);
    $('#idSolicitud').val(data.idSolicitud);
    $("#gestionNotaria").modal();
});
$(document).on('click', '#newNotary', function () {
    var data = escrituracionTable.row($(this).parents('tr')).data();
    $('#idSolicitud').val(data.id_solicitud);
    $('#nombre_notaria').val('');
    $('#nombre_notario').val('');
    $('#direccion').val('');
    $('#correo').val('');
    $('#telefono').val('');
    $("#altaNotario").modal();
});
function getBudgetNotaria(idSolicitud){
    $.get('getBudgetNotaria',{
        idSolicitud:idSolicitud
    }, function(data) {
        $('#nombreNotaria').val(data.nombre_notaria);
        $('#nombreNotario').val(data.nombre_notario);
        $('#direccionN').val(data.direccion);
        $('#correoN').val(data.correo);
        $('#telefonoN').val(data.telefono);
    }, 'json');
}

//RECHAZAR NOTARIA
$(document).on("submit", "#rechazar", function (e) {
    e.preventDefault();
    let idSolicitud = $("#idSolicitud").val();
    let data = new FormData($(this)[0]);
    data.append("idSolicitud", idSolicitud);

    $.ajax({
        url: "rechazarNotaria",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (response) {
            $("#gestionNotaria").modal("hide");
            escrituracionTable.ajax.reload();
        }
    });
});

function filterSelectOptions(documentType) {
    $("#rejectionReasons option").each(function () {
        if ($(this).attr("data-type") === documentType) {
            $(this).show();
        } else {
            $(this).hide();
        }
        $('select').val(documentType);
    });
    $("#rejectionReasons option:selected").prop("selected", false);
    $("#rejectionReasons").trigger('change');
    $("#rejectionReasons").selectpicker('refresh');
}

function getEstatusConstruccion(estatus_construccion) {
    console.log(estatus_construccion)
    
    $('#spiner-loader').removeClass('hide');
    $("#construccion").find("option").remove();
    if(estatus_construccion == null || estatus_construccion == 0){
        $("#construccion").append($('<option disabled selected>').val("").text("Seleccione una opción"));
    }
    $.post('getEstatusConstruccion', function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#construccion").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#construccion").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        if(estatus_construccion != null && estatus_construccion != 0){
            console.log('essd')
            $(`#construccion`).val(estatus_construccion);
            //$(`#construccion`).selectpicker('val',estatus_construccion);
            $(`#construccion`).trigger('change');
            //$('#construccion').val(estatus_construccion).trigger('change');
            //$("#construccion").selectpicker('refresh');

        }
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

function getEstatusPago() {
    $('#spiner-loader').removeClass('hide');
    $("#estatusPago").find("option").remove();
    $("#estatusPago").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
    $.post('getEstatusPago', function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#estatusPago").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#estatusPago").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#estatusPago").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

function createDocRow(row, tr, thisVar){
    console.log('createDocRow')
    console.log(row)
    $.post("getDocumentsClient", {
        idEscritura: row.data().idSolicitud,
        idEstatus: row.data().idEstatus
    }).done(function (data) {
        //if()
        //escrituracionTable.ajax.reload(null,false);
        row.data().solicitudes = JSON.parse(data);
      
       /* if(row.data().solicitudes[0].estatus_solicitud == 4 && row.data().solicitudes[0].num_exp == 2){
            console.log('data createDocRowOtros')
            contador=1;
            if(contador == 1){
                console.log('CONTADOR MAS 1')
                console.log('YA LA RECARGO')
               // escrituracionTable.ajax.reload();
              
            }
        }*/
        escrituracionTable.row(tr).data(row.data());
        row = escrituracionTable.row(tr);
        row.child(buildTableDetail(row.data().solicitudes, $('.details-control').attr('data-permisos'))).show();
        tr.addClass('shown');
        thisVar.parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
        $('#spiner-loader').addClass('hide');
    });
}
     
//ENVIO OBSERVACIONES
$(document).on('click', '#observacionesButton', function () {
    var data = escrituracionTable.row($(this).parents('tr')).data();
    $('#idSolicitud').val(data.idSolicitud);
    $('#viewObservaciones').modal();
});

$(document).on('change', '#pertenece', function () {
    if($(this).val() == 'Postventa'){
        $(document).on("submit", "#observacionesForm", function (e) {
            e.preventDefault();
            let idSolicitud = $("#idSolicitud").val();
            let data = new FormData($(this)[0]);
            data.append("idSolicitud", idSolicitud);

            $.ajax({
                url: "observacionesPostventa",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (response) {
                    $("#viewObservaciones").modal("hide");
                    escrituracionTable.ajax.reload();
                }
            });
        });
    }
    else if ($(this).val() == 'Proyectos'){
        $(document).on("submit", "#observacionesForm", function (e) {
            e.preventDefault();
            let idSolicitud = $("#idSolicitud").val();
            let data = new FormData($(this)[0]);
            data.append("idSolicitud", idSolicitud);

            $.ajax({
                url: "observacionesProyectos",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (response) {
                    $("#viewObservaciones").modal("hide");
                    escrituracionTable.ajax.reload();
                }
            });
        });
    }
});

function saveEstatusLote(idSolicitud, data){
    $('#spiner-loader').removeClass('hide');
    $.ajax({
        url: "saveEstatusLote",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (response) {
            if (response == 1) {
                $("#estatusLModal").modal("hide");
                $('#spiner-loader').addClass('hide');
                escrituracionTable.ajax.reload(null,false);
                alerts.showNotification("top", "right", "Registro editado correctamente.", "success");
            }
        }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
}

function createDocRowPresupuesto(row, tr, thisVar){
    $.post("getPresupuestos", {
        idEscritura: row.data().idSolicitud
    }).done(function (data) {
        row.data().solicitudes = JSON.parse(data);
        escrituracionTable.row(tr).data(row.data());
        row = escrituracionTable.row(tr);
        row.child(buildTableDetailP(row.data().solicitudes, $('.treePresupuesto').attr('data-permisos'))).show();
        tr.addClass('shown');
        thisVar.parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
        $('#spiner-loader').addClass('hide');
    });
}
//MO: Se crea objeto para recargar la tabla y desplegar el row details
let datosPresupuestos = new Object();
function RecargarTablePresupuestos(){
    console.log('funcion recargar');
    console.log(datosPresupuestos);
    escrituracionTable.ajax.reload(null,false);
    createRowNotarias(datosPresupuestos.row, datosPresupuestos.tr, datosPresupuestos.thisVar, datosPresupuestos.idSolicitud)
}

function createRowNotarias(row, tr, thisVar, idSolicitud){
    //MO: Guardamos los parametros recibidos en una variable global para usarlos en la funcion que desplega el row details
    datosPresupuestos = {
        "row" : row,
        "tr" : tr,
        "thisVar" : thisVar,
        "idSolicitud" : idSolicitud
    }
    console.log('row', row);
    console.log('rowData', row.data());

    $.post("getNotariasXUsuario", {
        idSolicitud: idSolicitud
    }).done(function (data) {
        row.data().notarias = JSON.parse(data);
        escrituracionTable.row(tr).data(row.data());
        row = escrituracionTable.row(tr);
        row.child(crearDetailsPresupuestos(row.data(), $('.treePresupuesto').attr('data-permisos'))).show();
        // selectedNotarias(row.data());
        tr.addClass('shown');
        thisVar.parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
        $('#spiner-loader').addClass('hide');
    }, 'json');
   
}

function buildTableDetailP(data, permisos) {
    var filtered = data.filter(function(value){ 
        if(permisos == 2 && value.expediente == ''){
        }else{
            return value;
        }
    });
    var solicitudes = '<table class="table subBoxDetail">';
    solicitudes += '<tr style="border-bottom: 1px solid #fff; color: #4b4b4b;">';
    solicitudes += '<td>' + '<b>' + '# ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'DOCUMENTO ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'TIPO DE PRESUPUESTO' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'FECHA ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'ACCIONES ' + '</b></td>';
    solicitudes += '</tr>';
    console.log(permisos);
    $.each(filtered, function (i, v) {

        //i es el indice y v son los valores de cada fila
        solicitudes += '<tr>';
        solicitudes += '<td> ' + (i + 1) + ' </td>';
        solicitudes += '<td> ' + (permisos == 1 ? v.expediente:'Presupuesto') + ' </td>';
        solicitudes += '<td> ' + v.nombre + ' </td>';
        solicitudes += '<td> ' + v.fecha_creacion + '</td>';
        
        solicitudes += '<td><div class="d-flex justify-center">';
        if(permisos == 1){
            solicitudes += `<button data-idDocumento="${v.idPresupuesto}" data-documentType="13" data-presupuestoType="${v.tipo}" data-idSolicitud=${v.idSolicitud} data-details ="2" data-action=${v.expediente == null || v.expediente == '' ? 1 : 2} class="btn-data btn-${v.expediente == null || v.expediente == '' ? 'blueMaderas' : 'warning'} upload" data-toggle="tooltip" data-placement="left" title=${v.expediente == null || v.expediente == '' ? 'Cargar' : 'Eliminar'}>${v.expediente == null || v.expediente == '' ? '<i class="fas fa-cloud-upload-alt"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
        }
  
        if (v.expediente == null || v.expediente == '')
            solicitudes += '';
        else
            solicitudes += `<button id="preview" data-idDocumento="${v.idPresupuesto}" data-doc="${v.expediente}" data-documentType="13" data-presupuestoType="${v.tipo}"  class="btn-data btn-gray" data-toggle="tooltip" data-placement="left" title="Vista previa"><i class="fas fa-eye"></i></button>`;

        solicitudes += '</div></td></tr>';

    });
    return solicitudes += '</table>';
}

function getEstatusEscrituracion(){
    $('#spiner-loader').removeClass('hide');
    $("#estatusE").find("option").remove();
    $("#estatusE").append($('<option selected>').val("0").text("Propios"));
    $("#estatusE").append($('<option>').val("1").text("Todos"));
    $("#estatusE").selectpicker('refresh');
    $('#spiner-loader').addClass('hide');
    // $.post('getEstatusEscrituracion', function(data) {
    //     var len = data.length;
    //     for (var i = 0; i < len; i++) {
    //         var id = data[i]['id_opcion'];
    //         var name = data[i]['nombre'];
    //         $("#estatusE").append($('<option>').val(id).text(name));
    //     }
    //     if (len <= 0) {
    //         $("#estatusE").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
    //     }
    //     $("#estatusE").selectpicker('refresh');
    //     $('#spiner-loader').addClass('hide');
    // }, 'json');
}

function getTipoEscrituracion() {
    $('#spiner-loader').removeClass('hide');
    $("#tipoE").find("option").remove();
    $("#tipoE").append($('<option disabled selected>').val("").text("Seleccione una opción"));
    $.post('getTipoEscrituracion', function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#tipoE").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#tipoE").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#tipoE").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

$(document).on('click', '#informacion', function () {
    var data = escrituracionTable.row($(this).parents('tr')).data();

    getBudgetInformacion(data.id_solicitud);
    $('#idSolicitud').val(data.id_solicitud);
    
    $("#informacionModal").modal();
});

function getBudgetInformacion(idSolicitud){
    $('#spiner-loader').removeClass('hide');
    $.post('getBudgetInformacion',{
        idSolicitud:idSolicitud
    }, function(data) {
        if(data.id_estatus != 5 && data.id_estatus != 2 && data.id_estatus != 4){
            $('#RequestInformacion').addClass('hide');
            $('#information_campos').addClass('hide');
            document.getElementById('construccionI').disabled = true;
            document.getElementById('clienteI').disabled = true;
            document.getElementById('nombreI').disabled = true;
            document.getElementById('fechaCAI').disabled = true;
            document.getElementById('rfcDatosI').disabled = true;
            document.getElementById('aportacionesI').disabled = true;
            document.getElementById('descuentosI').disabled = true;
            document.getElementById('motivoI').disabled = true;
            }
        $('#liquidado').val(data.nombrePago);
        $('#construccionI').val(data.nombreConst);
        $('#clienteI').val(data.cliente_anterior == 1 ? 'uno':'dos').trigger('change');
        $("#clienteI").selectpicker('refresh');
        $('#nombreI').val(data.nombre_anterior);
        let fechaAnterior =data.fecha_anterior != null ? data.fecha_anterior.split(" ")[0].split("-").reverse().join("-") :data.fecha_anterior;
        $('#fechaCAI').val(fechaAnterior);
        $('#rfcDatosI').val(data.RFC);
        $('#aportacionesI').val(data.aportacion);
        $('#descuentosI').val(data.descuento);
        $('#motivoI').val(data.motivo);
        
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

$(document).on('change', '#clienteI', function () {
    if ($(this).val() == 'uno') {
        $('#ifInformacion').show();
    } else {
        $('#ifInformacion').hide();

    }
});

//AGREGAR INFORMACIÓN - ADMIN
$(document).on("submit", "#formInformacion", function (e) {
    e.preventDefault();
    let idSolicitud = $("#idSolicitud").val();
    let data = new FormData($(this)[0]);
    //data.append('aportaciones', $('#aportaciones').val() == '' ? null : $('#aportaciones').val());
    //data.append('descuentos', $('#descuentos').val() == '' ? null : $('#descuentos').val());
    data.append("idSolicitud", idSolicitud);
    
    $.ajax({
        url: "newInformacion",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (response) {
            alerts.showNotification("top", "right", "Se agrego la información.", "success");
            $("#informacionModal").modal("hide");
            escrituracionTable.ajax.reload(null,false);
        }
    });
});

//NOTARIA
$(document).on('change', '#not', function () {
    if ($(this).val() == 'yes') {
        $('#ifNotaria').show();
    } else {
        $('#ifNotaria').hide();
    }
});
function crearDetailsPresupuestos(data, permisos) {
    let notarias = `<table id="notarias-${data.id_solicitud}" class="table subBoxDetail">`;
    notarias += '<tr style="border-bottom: 1px solid #fff; color: #4b4b4b;">';
    notarias += '<td>' + '<b>' + '# ' + '</b></td>';
    notarias += '<td>' + '<b>' + 'NOTARIA ' + '</b></td>';
    notarias += '<td>' + '<b>' + 'DESCRIPCION' + '</b></td>';
    notarias += '<td>' + '<b>' + 'CARGAR PRESUPUESTOS' + '</b></td>';
    notarias += '</tr>';
    console.log('buildDAta',data);
    console.log('permisos', permisos);

    for(let i = 0;i<3;i++){
        notarias += '<tr>';
        notarias += '<td> ' + (i + 1) + ' </td>';
        notarias += `<td class="d-flex direction-row justify-center align-center"> 
        ${permisos == 1 ? 
                        `<select id="notaria-${i}-${data.id_solicitud}" name="notaria" class="selectpicker select-gral m-0 notaria-select" data-style="btn" data-show-subtext="true"
                        data-live-search="true" data-container="body" title="Selecciona una notaria" data-size="7" required></select>`: 
                        `${data.notarias[i] ? data.notarias[i].nombre_notaria:''}`
                    
                } </td>`;
                    
        notarias += `<td id="desc">${permisos != 1 && data.notarias[i] ? data.notarias[i].direccion: ''}</td>`;
        notarias += '<td><div class="d-flex justify-center">';
        notarias += `<button  class="btn-data btn-blueMaderas ${data.notarias[i] != undefined ? 'modalPresupuestos':'saveNotaria'}" 
        data-idNxS ="${data.notarias[i] ? data.notarias[i].idNotariaxSolicitud:null}" data-idSolicitud="${data.id_solicitud}" data-toggle="tooltip" 
        data-placement="left" title="presupuestos">${data.notarias[i] != undefined ? '<i class="fas fa-box-open"></i>':'<i class="far fa-save"></i>'}
        </button>`;
        notarias += '</div></td></tr>';
    }

    $('#spiner-loader').addClass('hide');
    getNotarias(data);
    return notarias += '</table>';
}

async function getDescriptionNotaria(idNotaria){
    $('#spiner-loader').removeClass('hide');

    return new Promise((resolve, reject)=>{
        $.ajax({
            url: "getNotaria",
            data: {idNotaria: idNotaria},
            type: 'POST',
            dataType:'json',
            success: function (response) {
              resolve(response[0]);
              $('#spiner-loader').addClass('hide');

            }
        });
    })
}

function saveNotaria(idSolicitud, idNotaria, thisVar){
    $.ajax({
        url: "saveNotaria",
        data: {idNotaria: idNotaria, idSolicitud:idSolicitud},
        type: 'POST',
        dataType:'json',
        success: function (response) {
            if (response.message) {
                alerts.showNotification("top", "right", response.message, "danger");
                $('#spiner-loader').addClass('hide');
            } else {
                const tr = $(`#treePresupuesto${idSolicitud}`).closest('tr');
                
                const row = escrituracionTable.row(tr);
                console.log('tr', tr);
                console.log('rowSave2', row.data());

                createRowNotarias(row, tr, $(`#trees${idSolicitud}`), idSolicitud);
                $('#spiner-loader').addClass('hide');
            }
        }
    });
}

function buildUploadCards(idNxS){
    //FUNCIÓN PARA CREAR LOS 3 PRESUPUESTOS POR NOTARIA ESTATUS 13,16 Y 37. PARA MOSTRAR ESTATUS 14, 17 Y 38
    let permisos = $('.treePresupuesto').attr('data-permisos');
    $('#body_uploads').html('');
    $('#spiner-loader').removeClass('hide');
    $.ajax({
        url: "getPresupuestosUpload",
        data: {idNxS: idNxS},
        type: 'POST',
        dataType:'json',
        success: function (response) {
            console.log(response);
            console.log(response[0].id_solicitud);
            let html = '';
          response.forEach(element =>{

            html += `
            <div class="col-12 col-sm-12 col-md-4 col-lg-4 cardUpload">
                <div class="d-flex direction-column">
                ${
                    element.expediente == '' ? '<div class="d-flex justify-end mb-1"></div>':
                    element.expediente != '' && permisos == 1 ? `<div class="d-flex justify-end mb-1"> <i data-details="2" data-doc="${element.expediente}" data-action="2" data-idSolicitud=${element.id_solicitud} data-documentType="13" data-idDocumento="${element.idPresupuesto}" data-idPresupuesto= "${element.idPresupuesto}" data-idNxS= "${element.idNotariaxSolicitud}" data-presupuestoType="${element.tipo}" class="far fa-trash-alt upload"></i></i></div>`:'<div class="d-flex justify-end mb-1"></div>' 
                }
                ${
                    element.expediente == '' && permisos == 1 ? `<i data-details="2" data-action="1" data-idSolicitud=${element.id_solicitud} data-documentType="13" data-idDocumento="${element.idPresupuesto}" data-idPresupuesto= "${element.idPresupuesto}" data-idNxS= "${element.idNotariaxSolicitud}" data-presupuestoType="${element.tipo}" class="fas fa-cloud-upload-alt fs-5 uploadIcon_modal upload"></i>`
                    :
                    element.expediente == '' && permisos != 1 ? `<i class="far fa-file-excel nodata_icon fs-5"></i>`
                    :`<i id="preview" data-details="2" data-doc="${element.expediente}" data-action="2" data-idSolicitud=${element.id_solicitud} data-documentType="13" data-idDocumento="${element.idPresupuesto}" data-idPresupuesto= "${element.idPresupuesto}" data-idNxS= "${element.idNotariaxSolicitud}" data-presupuestoType="${element.tipo}" class="far fa-file-pdf fs-5 watchIcon_modal"></i>`
                }

                    <span class="mt-2">Presupuesto</span>
                    <span>${element.nombre}</span>
                </div>
            </div>
            `;
          })
          $('#body_uploads').append(html);
          $('#spiner-loader').addClass('hide');
          console.log('TERMINA SUCCESS')
        }
    });
}


function createDocRowOtros(row, tr, thisVar,contador = 0){
//FUNCIÓN PARA CREAR ROWDETAILS DE LA ACTIVIDAD APE004 CARGA DE CONTRATO Y OTROS
    let v = 0;
    $.post("getDocumentsClient", {
        idEscritura: row.data().id_solicitud,
        idEstatus:row.data().id_estatus
    }).done(function (data) {
        row.data().solicitudes = JSON.parse(data);
        let estatusAct4 = [3,4,6,8,10];
if(estatusAct4.includes(row.data().solicitudes[0].estatus_solicitud)){
        var index1 = row.data().solicitudes.findIndex(e => e.tipo_documento == 18);
                    if (index1 != -1) {
                if(contador == 1){
                    if(row.data().solicitudes[index1].expediente != null ){
                       v=1;
                    }
                }else if(contador == 2){
                    if(row.data().solicitudes[index1].expediente == null){
                        v=1;
                    }
                }
            }
        }
        if(v==1){
            escrituracionTable.ajax.reload(null,false);
            createDocRowOtros(rowOtros.row,rowOtros.tr,rowOtros.this);
        }else{
            escrituracionTable.row(tr).data(row.data());
            row = escrituracionTable.row(tr);
            row.child(buildTableDetail(row.data().solicitudes, $('.details-control-otros').attr('data-permisos'))).show();
            tr.addClass('shown');
            thisVar.parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
            $('#spiner-loader').addClass('hide');
        }
    });
}


function createDocRowPago(row, tr, thisVar){
    $.post("getDocumentsClient", {
        idEscritura: row.data().idSolicitud,
        idEstatus:row.data().idEstatus
        
    }).done(function (data) {
        row.data().solicitudes = JSON.parse(data);
        escrituracionTable.row(tr).data(row.data());
        row = escrituracionTable.row(tr);
        row.child(buildTableDetail(row.data().solicitudes, $('.details-control-pago').attr('data-permisos'))).show();
        tr.addClass('shown');
        thisVar.parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
        $('#spiner-loader').addClass('hide');
    });
}
////////////////////////////////////////////////////////////////////
// ---------------------------------------------------------------
// ------------------------------------------------------------------
// ----------------------------------------------------------------------

$(document).on('click', '#bajarConMotivo', function () {
    idStatus = 1;
    denegarTexto =''; 
    let estatus_validacion = 0;
    idDocumento = $(this).attr("data-idDocumento");
    ipOcion = $(this).attr("data-idOpcion");
    opcionEditar = $(this).attr("data-editar");
    estatus = $(this).attr("data-editar");
    index = $(this).attr("data-index");
    proceso = document.querySelector("selectMotivo"+index) ;

    Motivo  = document.getElementById("selectMotivo"+index).value ;
         // Dividiendo la cadena "proceso" usando el carácter espacio
         let motivos = Motivo.split('//');
    console.log('Motivo0::::::'+ motivos[0] )
    console.log('Motivo1::::::'+ motivos[1] )
    console.log('proceso::::::')
    console.log( document.getElementById("selectMotivo"+index).getAttribute('data-proceso'))
      console.log('json::::::')
      console.log(document.getElementById("selectMotivo"+index).getAttribute('data-proceso'))
    
    let estatusValidacion = ' ';

    let dataMostrar = ' ';

    if(estatus == 1 ){  
        
        console.log('ESTATUS::::::'+estatus);          
    }else if(estatus == 2){

    }

    $.ajax({
        url : 'validarDocumento',
        type : 'POST',
        dataType: "json",
        data: 
        {   
            "proceso": motivos[1],
            "motivo" : motivos[0], 
            "estatus_validacion" : estatus,
            "Iddocumentos" : idDocumento,
            'idOpcion' : ipOcion, 
            'opcionEditar': opcionEditar, 
        }, 
        success: function(data) {
            document.getElementById('estatusValidacion'+index).innerHTML = estatusValidacion;
 
            if(estatus == 1 ){  
            
                estatusVal = 'Estatus actual VALIDADO';
                denegarTexto += '';
            
            }else if(estatus == 2){
                console.log('ENTRA');
                estatusVal = 'Estatus actual DENEGADO';
            
            }else{
                estatusVal = 'Estatus  CARGADO';
            }

            var estatusmensaje = document.getElementById('estatusValidacion'+index);
            document.getElementById('denegarVISTA'+index).innerHTML = dataMostrar;
            document.getElementById('validarVISTA'+index).innerHTML = dataMostrar;
            document.getElementById('opcionesDeRechazo'+index).innerHTML = dataMostrar;
            document.getElementById('botonRechazo'+index).innerHTML = dataMostrar;
            estatusValidacion += estatusVal;
            estatusmensaje.innerHTML = estatusValidacion;
            alerts.showNotification("top", "right", ""+data.message+"", ""+data.response_type+"");

        },              
        error : (a, b, c) => {
            alerts.showNotification("top", "right", "Descuento No actualizado .", "error");
        }

    });
});

$(document).on('click', '#denegartxt', function () {
idDocumento = $(this).attr("data-idDocumento");
ipOcion = $(this).attr("data-idOpcion");
opcionEditar = $(this).attr("data-editar");
estatus = $(this).attr("data-editar");
opcIndex = $(this).attr("data-index");

var typeDocument = ipOcion;


console.log(typeDocument);
var datos = []  ;
var formData = new FormData();
formData.append('tipoDocumento',typeDocument );
let denegarTexto = '';

$.ajax({
    type: 'POST',
    url: 'motivosRechazos',
    data: formData,
    dataType: "json",
    contentType: false,
    processData:false,
    success: function(data) { 
         console.log(data)
         denegarTexto += '<br> <select class="form-control titulares"  id="selectMotivo'+opcIndex+'" name="selectMotivo'+opcIndex+'" data-size=".3" >';
        data.forEach(function(motivos,index ){
            console.log(motivos.tipo_proceso);
                denegarTexto += '   <option data-proceso="'+motivos.tipo_proceso+'"  value="'+motivos.id_motivo+'//'+motivos.tipo_proceso+'">'+motivos.motivo+'</option>';     
                datos[index]=motivos;
         })
        denegarTexto += '      </select>';

         
        let BOTON =  '<button id="bajarConMotivo" name="bajarConMotivo" ' +
        'class="btn-data btn-warning cancelReg "   title="DENEGAR" '+
        'data-idDocumento="'+idDocumento+'" data-idOpcion="'+ipOcion+'" data-editar="'+opcionEditar+'" '+
        ' data-index="'+opcIndex+'" > ' +
        '<i class="fas fa-folder-minus"></i></button>';
        
        document.getElementById('opcionesDeRechazo3'+opcIndex).innerHTML = BOTON;
        document.getElementById('opcionesDeRechazo'+opcIndex).innerHTML = denegarTexto;
        // opcionesDeRechazo 
    },
    error: function()
    {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
    
});

});
// esta funcion es para denegar docuemdocumento 
$(document).on('click', '#validarDoc', function () {
idStatus = 1;
let estatus_validacion = 0;
idDocumento = $(this).attr("data-idDocumento");
ipOcion = $(this).attr("data-idOpcion");
opcionEditar = $(this).attr("data-editar");
estatus = $(this).attr("data-editar");
index = $(this).attr("data-index");
console.log(  idDocumento, ipOcion ,opcionEditar, index)
let estatusValidacion = ' ';

let dataMostrar = ' ';


$.ajax({
    url : 'validarDocumento',
    type : 'POST',
    dataType: "json",
    data: 
    {
        "estatus_validacion" : estatus,
        "Iddocumentos" : idDocumento,
        'idOpcion' : ipOcion, 
        'opcionEditar': opcionEditar, 
    }, 
    success: function(data) {
        document.getElementById('estatusValidacion'+index).innerHTML = estatusValidacion;

        if(estatus == 1 ){  
        
            estatusVal = 'Estatus actual VALIDADO';
            denegarTexto += '';
        
        }else if(estatus == 2){
            console.log('ENTRA');
            estatusVal = 'Estatus actual DENEGADO';
        
        }else{
            estatusVal = 'Estatus  CARGADO';
        }

        var estatusmensaje = document.getElementById('estatusValidacion'+index);
     
        estatusValidacion += estatusVal;
        estatusmensaje.innerHTML = estatusValidacion;
        alerts.showNotification("top", "right", ""+data.message+"", ""+data.response_type+"");
    },              
    error : (a, b, c) => {
        alerts.showNotification("top", "right", "Descuento No actualizado .", "error");
    }

});

})



// esta funcion es para validar documento 
$(document).on('click', '#visualizarDoc', function () {
idStatus = 1;
denegarTexto =''; 
let estatus_validacion = 0;
idDocumento = $(this).attr("data-idDocumento");
ipOcion = $(this).attr("data-idOpcion");
opcionEditar = $(this).attr("data-editar");
estatus = $(this).attr("data-editar");
index = $(this).attr("data-index");
console.log(  idDocumento, ipOcion ,opcionEditar, index)
let estatusValidacion = ' ';

let dataMostrar = ' ';

if(estatus == 1 ){  
    
    console.log('ESTATUS::::::'+estatus);          
}else if(estatus == 2){

}

$.ajax({
    url : 'validarDocumento',
    type : 'POST',
    dataType: "json",
    data: 
    {
        "estatus_validacion" : estatus,
        "Iddocumentos" : idDocumento,
        'idOpcion' : ipOcion, 
        'opcionEditar': opcionEditar, 
    }, 
    success: function(data) {
        document.getElementById('estatusValidacion'+index).innerHTML = estatusValidacion;

        if(estatus == 1 ){  
        
            estatusVal = 'Estatus actual VALIDADO';
            denegarTexto += '';
        
        }else if(estatus == 2){
            console.log('ENTRA');
            estatusVal = 'Estatus actual DENEGADO';
        
        }else{
            estatusVal = 'Estatus  CARGADO';
        }

        var estatusmensaje = document.getElementById('estatusValidacion'+index);
        document.getElementById('denegarVISTA'+index).innerHTML = dataMostrar;
        document.getElementById('validarVISTA'+index).innerHTML = dataMostrar;
        estatusValidacion += estatusVal;
        estatusmensaje.innerHTML = estatusValidacion;
        alerts.showNotification("top", "right", ""+data.message+"", ""+data.response_type+"");

    },              
    error : (a, b, c) => {
        alerts.showNotification("top", "right", "Descuento No actualizado .", "error");
    }

});
});



// __---------------------------------------------
// __---------------- DOCUMENTOS PARA TITULACIÓN -----------------------------
// __---------------------------------------------



$(document).on('click', '#revisarDocs', function () {
    idStatus = $(this).attr("data-info");
    solicitudes = $(this).attr("data-solicitud");
    let solicitud = solicitudes ;
    let estatus = idStatus;
    let ruta = '';
    var documentos  = '';

    var cuerpoModal = document.getElementById('documentos_revisar');
    cuerpoModal.innerHTML = documentos;
    $("#documentosRevisar").modal();
     
        $.ajax({
            url : 'getDocumentosPorSolicitudss',
            type : 'POST',
            dataType: "json",
            data: 
            {
                // "pagos_activos"     : pagos_activos,
                "estatus" : estatus,
                "solicitud" : solicitud
            }, 
            success: function(data) {
                console.log(data);
                console.log(data)
                InfoModal = '';
                InfoModalF = '';
                data.misDocumentos.forEach(function(Losmios,Numero ){
                        
                    ruta =   folders(Losmios.id_opcion);
                    
                    // ruta =    "static/documentos/postventa/escrituracion/CURP/";
                InfoModal += '   <div class="row"  >';
                InfoModal += '  <div class="col-12 col-sm-12 col-md-12 col-lg-12 ">';
                InfoModal += '  </div>';
                 
                        if(Losmios.estatusValidacion == 1 ){
                            estatusVal = 'Estatus actual VALIDADO';
                        }else if(Losmios.estatusValidacion  == 2){
                            estatusVal = 'Estatus actual DENEGADO';
                        }else{
                            estatusVal = ' CARGADO';
                        }

                    InfoModal += '  <div class="col-6 col-sm-6 col-md-6 col-lg-6 ">';
                    InfoModal += '      <p style="font-size: 1em: color: #E92017;"> DOCUMENTO '+Losmios.nombre+' </p>';
                    InfoModal += '      <p id="estatusValidacion'+Numero+'" name="estatusValidacion'+Numero+'" style="font-size: 0.9em;"> Estatus actual '+estatusVal+' </p>';

                    InfoModal += '      <hr style="color: #0056b2;" />';
                    InfoModal += '  </div>';

                    InfoModal += '  <div class="col-5 col-  sm-5 col-md-5 col-lg-5 ">';
                    InfoModal += '  <div name="cambioBajar'+Numero+'" id="cambioBajar'+Numero+'" >';
                    InfoModal += '   <div class="col-2 col-sm-2 col-md-2 col-lg-2 ">';
                                            
                    // InfoModal += '   <a id="descargarDoc"  name="descargarDoc" data_expediente="'+Losmios.expediente+'" data-index="'+Numero+'"  data-idDocumento="'+Losmios.idDocumento +'" data-idSolicitud="'+Losmios.idSolicitud +'" data-idOpcion="'+Losmios.id_opcion +'"' +
                    // 'data-idCliente="" data-fecVen="" data-ubic="" data-code=""  ' +
                    // 'class="btn-data btn-sky cancelReg" title="Visualizar">' +
                    // '<i class="fas fa-download"></i></a>'; 
                    InfoModal += '  </div>';
                 
                    InfoModal += ' <div class="col-2 col-sm-2 col-md-2 col-lg-2">';
                    InfoModal += '<a  data-doc="'+Losmios.expediente+'" data-documentType="'+Losmios.id_opcion+'"   id="preview"  name="preview" data_expediente="'+Losmios.expediente+'"   data-index="'+Numero+'" data-idDocumento="'+Losmios.idDocumento +'" data-idSolicitud="'+Losmios.idSolicitud +'" data-idOpcion="'+Losmios.id_opcion +'"' +
                    'class="btn-data btn-orangeYellow cancelReg" title="Descargar"  data-idCliente="" data-fecVen="" data-ubic="" data-code="" >' +
                    ' ' +
                    '<i class="fas fa-search-plus"></i></a>'; 
                     InfoModal += ' </div>';

                    if(Losmios.validacion == 1 ){ // validacion para saber si este documento ya se valido anteriormente positivo
                        InfoModal += ' <div class="col-2 col-sm-2 col-md-2 col-lg-2 ">';
                        InfoModal += ' <p style="font-size: 1em: color: #E92017;"> REVISADO  </p>';
                        InfoModal += ' </div>';
                    }else if(Losmios.validacion == 2){ // validacion para saber si este documento ya se valido anteriormente negativo
                        InfoModal += ' <div class="col-2 col-sm-2 col-md-2 col-lg-2 ">';
                        InfoModal += ' <p style="font-size: 1em: color: #E92017;"> REVISADO </p>';
                        InfoModal += ' </div>';
                    }else { // si no se ha validado aqui entra
                        InfoModal += ' <div class="col-2 col-sm-2 col-md-2 col-lg-2 " name="validarVISTA'+Numero+'" id="validarVISTA'+Numero+'">';
                       
                        InfoModal += '<button href="#" id="visualizarDoc" name="visualizarDoc" data-editar="1"  data-index="'+Numero+'" data-idDocumento="'+Losmios.idDocumento +'" data-idSolicitud="'+Losmios.idSolicitud +'" data-idOpcion="'+Losmios.id_opcion +'"' +
                        'class="btn-data btn-green cancelReg" title="Aceptar">' +
                        '<i class="fas fa-thumbs-up"></i></button>'; 
                         InfoModal += ' </div>';

                         InfoModal += ' <div class="col-2 col-sm-2 col-md-2 col-lg-2 " name="denegarVISTA'+Numero+'" id="denegarVISTA'+Numero+'" >';
                         InfoModal += '<button href="#" id="denegartxt" name="denegartxt"  data-editar="2" data-index="'+Numero+'" data-idDocumento="'+Losmios.idDocumento +'" data-idSolicitud="'+Losmios.idSolicitud +'" data-idOpcion="'+Losmios.id_opcion +'"' +
                       'data-idCliente="" data-fecVen="" data-ubic="" data-code=""  ' +
                       'class="btn-data btn-warning  cancelReg" title="Rechazar">' +
                       '<i class="fas fa-thumbs-down"></i></button>'; 
                        InfoModal += ' </div>';
                        InfoModal += ' <div class="col-6 col-sm-6 col-md-6 col-lg-6"  name="opcionesDeRechazo'+Numero+'" id="opcionesDeRechazo'+Numero+'" >';                    
                        InfoModal += '      <div class="form-group label-floating select-is-empty"  name="opcionesDeRechazo'+Numero+'" id="opcionesDeRechazo'+Numero+'" >';      
                
                        InfoModal += '      </div>';
                        InfoModal += ' </div>';
                        
                        InfoModal += ' <div class="col-6 col-sm-6 col-md-6 col-lg-6" name="botonRechazo'+Numero+'" id="botonRechazo'+Numero+'">';                    
                        InfoModal += '      <div class="form-group"  name="opcionesDeRechazo3'+Numero+'" id="opcionesDeRechazo3'+Numero+'" >';      
                     
                        InfoModal += '      </div>';
                        InfoModal += ' </div>';
                        // InfoModal += ' <div class="form-group label-floating select-is-empty">';
                        // InfoModal += '       <select id="estatusE" name="estatusE" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un estatus" data-size="7" required>';
                        // InfoModal += '       </select>';
                        // InfoModal += '      </div>';
          
                    }
                        InfoModal += ' </div>';
                        InfoModal += '  </div>';
                        InfoModal += '  </div>';

                         document.getElementById('documentos_revisar').innerHTML = InfoModal;        
                }); 
            },               
            error : (a, b, c) => {
                alerts.showNotification("top", "right", "Descuento No actualizado .", "error");
            }

        });

});

// function para abrir modal 
// aqui se construye cuando se abren los modal de documentos 
// aqui se consulta y se construye
    $(document).on('click', '#subirDocumentos', function () {

        idStatus = $(this).attr("data-info");
        solicitudes = $(this).attr("data-solicitud");           
    let solicitud = solicitudes ;
    let estatus = idStatus;
        console.log()

    var documentos  = '';
        documentos += '';
    var cuerpoModal = document.getElementById('subir_documento');
        cuerpoModal.innerHTML = documentos;
    let banderaTengoDocumentos = false;
    var mandarSolicitud = document.getElementById('mandarSolicitud');
        mandarSolicitud.innerHTML = documentos;
    var BotonMandar = '';
        mandarSolicitud.innerHTML = BotonMandar;

    $("#documentTreeAr").modal();
        $.ajax({
        url : 'getDocumentosPorSolicitudss',
        type : 'POST',
        dataType: "json",
        data: 
        {
            // "pagos_activos"     : pagos_activos,
            "estatus" : estatus,
            "solicitud" : solicitud
        }, 
      success: function(data) {
        // alerts.showNotification("top", "right", ""+data.message+"", ""+data.response_type+"");
        // document.getElementById('updateDescuento').disabled = false;
        // $('#tabla-general').DataTable().ajax.reload(null, false );
       console.log(data);
        banderaEliminar =   true
        // inicio del row
        const No_existen = []; 
        var InfoModal = ' '; //inicio de div que contiene todo el modal]
        InfoModal += '      <h5 id="mainLabelText"></h5>'; 
        InfoModal += '   <div class="row"  >';
        // fin del row1
        // FUCNTIOPNM PARA ELIMINAR LOS DOCUMENTOS QUE YA TENGO 
        if(data.length  != 0){
            data.losDocumentos.forEach(function(elemento,i){
                // console.log(data.misDocumentos.length);
                data.misDocumentos.forEach(function(elementos,e){
                    if( elemento.id_documento == elementos.id_opcion )
                    {
                        console.log('mensaje para analizar si son iguales');
                        banderaEliminar = true;    
                        // arr[index] = element + index;
                        data.losDocumentos[i] = '' , i;                       
                        banderaTengoDocumentos = true;
                    } 
                    })
            })
        }
        // FIN DE FUNTION PARA ELIMINAR LOS DOCUEMTNOS QUE TENGO 

        if(banderaTengoDocumentos){
            InfoModal += '  <div class="col-12 col-sm-12 col-md-12 col-lg-12 ">';
            InfoModal += '     <p style="font-size: 0.8em: color: #E92017;">Documentos faltantes por subir</p>';
            InfoModal += '  <hr style="color: #0056b2;" />';
            InfoModal += '  </div>';
        } 
        if(data.length  != 0){
            data.losDocumentos.forEach(function(faltantes,inde ){
            console.log(faltantes);
                if(faltantes != '')
                {
                  
                    InfoModal += '  <div class="col-12 col-sm-12 col-md-12 col-lg-12 ">';
     
                    InfoModal += '  </div>';


                    InfoModal += '  <div class="col-6 col-sm-6 col-md-6 col-lg-6 "> ' ;
                    InfoModal += '      <p style="font-size: 0.8em: color: #E92017;"> DOCUMENT0 :'+faltantes.descripcion +' </p>';
                    // estatusVariable = ' <span class="label" style="background:#177DE9;" > '+estatusVal +'  </span>';
                    InfoModal += '      <p style="font-size: 0.9em; style="background:#177DE9;"> Estatus actual CARGADO </p>';
                    InfoModal += '      <hr style="color: #0056b2;" />';
                    InfoModal += '   <br> '
                    InfoModal += '  </div>';

                    InfoModal += '  <div class="col-5 col-sm-5 col-md-5 col-lg-5 ">';
                    InfoModal += '  <div name="cambioAlsubir'+inde+'" id="cambioAlsubir'+inde+'" >';
                    InfoModal += '      <input hidden name="numeroDeRow" id="numeroDeRow">';
                    InfoModal += '      <div class="file">';
                    InfoModal += '           <input class="form-control input-gral" id="docSubir'+inde+'" name="docSubir'+inde+'"  type="file" >';
                    InfoModal += '      </div>';
                    InfoModal += '	<button id="guardarImagen" name="guardarImagen"  ' +
                    'class="btn-data btn-green editReg" title="ACTUALIZAR" data-cambiada="1" data-index="'+inde+'" data-solicitud="'+solicitud+'" data-documento="'+faltantes.id_documento +'" data-nomLote="2" data-idCond="">'+
                    '<i class="fas fa-upload"></i></button>';
                    InfoModal += '  </div>';
                    InfoModal += '  </div>';

                    InfoModal += '  <div class="col-1 col-sm-1 col-md-1 col-lg-1 ">';
                    InfoModal += '  <div name="cambioAlsubir1'+inde+'" id="cambioAlsubir1'+inde+'" >';
             
                    InfoModal += '  </div>';                
                    InfoModal += '	</div>';

                }
            });  
            let estatusVal = 0;
            let estatusVariable = '' ;
            let bandera = 0 ;
            let motivo = []; 
            data.misDocumentos.forEach(function(Losmios,Numero ){
                ruta =   folders(Losmios.id_opcion);
                // console.log(Numero);
                // console.log(Losmios.id_opcion)
           
                // console.log(motivo[Numero]);
                // console.log(motivo.length);
                InfoModal += '  <div class="col-12 col-sm-12 col-md-12 col-lg-12 ">';
                InfoModal += '   <br> '
                InfoModal += '  </div>';
                 
                    if(Losmios.validacion == 1 ){
                        bandera = true;
                        estatusVal = 'VALIDADO';
                        
                        estatusVariable = '<span class="label" style="background:#28B463;"> '+estatusVal +' </span>';
                    }else if(Losmios.validacion == 2){
                        bandera = false;
                        estatusVal = 'DENEGADO';
                        estatusVariable = '<span class="label" style="background:#E92017;" > '+estatusVal +' </span>';
                    }else{
                        bandera = false;
                        estatusVal = 'CARGADO';
                        estatusVariable = ' <span class="label" style="background:#177DE9;" > '+estatusVal +'  </span>';
                    }
                    InfoModal += '  <div class="col-6 col-sm-6 col-md-6 col-lg-6 ">';
                    InfoModal += '      <p style="font-size: 1em: color: #E92017;"> DOCUMENTO '+Losmios.nombre +' </p>';
                    InfoModal += '      <div name="estatusActual'+Numero+'" id="estatusActual'+Numero+'" >';
                    InfoModal += '      '+ estatusVariable +' ';
                    InfoModal += '      </div>';
                    InfoModal += '      <hr style="color: #0056b2;" />';
                    InfoModal += '  </div>';

                    InfoModal += '  <div class="col-5 col-  sm-5 col-md-5 col-lg-5 ">';
                    InfoModal += '  <div name="cambioBajar'+Numero+'" id="cambioBajar'+Numero+'" >';
                    if(!bandera){
                        InfoModal += '   <div class="col-2 col-sm-2 col-md-2 col-lg-2 ">';
                        InfoModal += '   <a href="#" id="borrarDoc" name="borrarDoc" data-index="'+Numero+'"  data-idDocumento="'+Losmios.idDocumento +'" data-idSolicitud="'+Losmios.idSolicitud +'" data-idOpcion="'+Losmios.id_opcion +'"' +
                        'data-cambiada="0" class="btn-data btn-warning cancelReg" title="BORRAR">' +
                        '<i class="fas fa-trash-alt"></i></a>'; 
                        
                        InfoModal += '  </div>';
                    }
                  

                    InfoModal += ' <div class="col-2 col-sm-2 col-md-2 col-lg-2 ">';
                    InfoModal += '<a  id="preview"  name="preview"  data-doc="'+Losmios.expediente+'" data-documentType="'+Losmios.id_opcion+'"    data-index="'+Numero+'" data-idDocumento="'+Losmios.idDocumento +'" data-idSolicitud="'+Losmios.idSolicitud +'" data-idOpcion="'+Losmios.id_opcion +'"' +
                    'data-idCliente="" data-fecVen="" data-ubic="" data-code=""  ' +
                    'class="btn-data btn-violetBoots cancelReg" title="Visualizar">' +
                    '<i class="fas fa-scroll"></i></a>'; 
                     InfoModal += ' </div>';  
                    
                     InfoModal += ' </div>';
                    InfoModal += '  </div>';

            }); 


        }
        if(data.length == 0 ){
            InfoModal += '  <h5 id="mainLabelText"> ESTA ACTIVIDAD NO TIENE DOCUMETOS ES NECESARIO REVISARLO CON SOPORTE TI</h5>';
        }

        InfoModal += '  </div>';


        var InformacionModal = document.getElementById('subir_documento');
   
        document.getElementById('subir_documento').innerHTML = InfoModal;

        // $('#documentTree').modal('toggle');
    },              
    error : (a, b, c) => {
        alerts.showNotification("top", "right", "Descuento No actualizado .", "error");
    }

});
});

    $(document).on("click", "#borrarDoc", function () {
        let banderaEliminar = true;
        documento       = $(this).attr("data-idDocumento");
        solicitudId     = $(this).attr("data-idSolicitud");
        idOpcion        = $(this).attr("data-idOpcion");
        inde            = $(this).attr("data-index"); 
        seCambio        = $(this).attr("data-cambiada"); 
        primerIndex     = $(this).attr("data-primer"); 

        let  validarCambioEnMismoModal = 0;
        console.log('index:'+ inde);
        console.log('solicitudId:'+ solicitudId);
        console.log('seCambio:'+ seCambio);
        console.log('index:'+ inde);
        if(seCambio == 1 ){

            cambioAlsubir = 'cambioAlsubir';
            validarCambioEnMismoModal = "1";
        }else {
            validarCambioEnMismoModal = "0";
            cambioAlsubir = 'cambioBajar';

        }
        console.log(inde);
        console.log(solicitudId);
        var formData = new FormData();
        console.log(idOpcion);
        let validacionAjax = true;
        if( idOpcion == '' || idOpcion == undefined ){validacionAjax = false;}
        if( documento == '' || documento == undefined ){validacionAjax = false;}
        if( solicitudId == '' || solicitudId == undefined ){validacionAjax = false;}
         
        if(validacionAjax){
            formData.append('documentType', idOpcion);
            formData.append('idSolicitud',solicitudId );
            formData.append('idDocumento', documento);
            $.ajax({
                type: 'POST',
                url: 'deleteFileActualizado',
                data: formData, 
                dataType: "json",
                contentType: false,
                processData:false,
                success: function(data) {
                    var InfoModall2 = ' ';
                    document.getElementById(cambioAlsubir+inde).innerHTML = InfoModall2;
                  if(data == 1){
                    alerts.showNotification("top", "right", "Documento eliminado .", "success");
                    var InfoModall = ' ';
                    InfoModall += '  <div name="cambioAlsubir'+inde+'" id="cambioAlsubir'+inde+'" >';
                    InfoModall += '      <input hidden name="numeroDeRow" id="numeroDeRow">';
                    InfoModall += '      <div class="file">';
                    InfoModall += '           <input class="form-control input-gral" data-cambiada='+validarCambioEnMismoModal+'  data-primer"'+primerIndex+'" id="docSubir'+inde+'" name="docSubir'+inde+'"  type="file"';
                    InfoModall += '           accept=".jpg, .jpeg, .png ,pdf">';
                    InfoModall += '      </div>';
                    InfoModall += '	<button id="guardarImagen" name="guardarImagen"  ' +
                                    'class="btn-data btn-green editReg" title="ACTUALIZAR" data-cambiada="1" data-index="'+inde+'" data-solicitud="'+solicitudId+'" data-documento="'+idOpcion +'" data-nomLote="2" data-idCond="">'+
                                    '<i class="fas fa-upload"></i></button>';  
                    InfoModall += '  </div>';
                         document.getElementById(cambioAlsubir+inde).innerHTML = InfoModall;
                  }
                },
                error: function(){
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        }
    });
    
    $(document).on("click", "#guardarImagen", function () {
      
        indexData   = $(this).attr("data-index");
        iddocumento = $(this).attr("data-documento");
        solicitudId = $(this).attr("data-solicitud");
        seCambio    = $(this).attr("data-cambiada"); 
        console.log(solicitudId);
        console.log(indexData);
        console.log(iddocumento);
        let  validarCambioEnMismoModal =  0;
        // pago_mensual = $(this).attr("data-mensual");
        // descuento = $(this).attr("data-descuento");
        if(seCambio == 1 ){
            console.log('entrando igual al mismo 1 ;;;'+ seCambio)
            cambioAlsubir = 'cambioAlsubir';
            validarCambioEnMismoModal = "1";
        }else {
            
            cambioAlsubir = 'cambioBajar';
            validarCambioEnMismoModal = "0";
        }
         let validacionAjax = true;
        if( indexData == ''){validacionAjax = false;}
        if( iddocumento == ''){validacionAjax = false;}
        if( solicitudId == ''){validacionAjax = false;}

        var archivos = $("#docSubir"+indexData)[0].files;
        if (archivos.length > 0) {
            //Sólo queremos la primera imagen, ya que el usuario pudo seleccionar más
            var foto = archivos[0]; 
            // var lector = new FileReader();
            var formData = new FormData();
            
            //Ojo: En este caso 'foto' será el nombre con el que recibiremos el archivo en el servidor
            formData.append('docSubir'+indexData, foto);
            formData.append('indexx',indexData );
            formData.append('iddocumento', iddocumento);
            formData.append('solicitudId', solicitudId);
            // formData.append('comentario', comentario);
            console.log(formData);
        }
    
        if(validacionAjax){
            $.ajax({
                type: 'POST',
                url: 'UParchivosFromss',
                data: formData,
                dataType: "json",
                contentType: false,
                processData:false,
                success: function(data) {
                    alerts.showNotification("top", "right", "Documento se ha cargado .", "success");
                 
                    var infoBotonesWhenSubio = ' ';
                    infoBotonesWhenSubio += '';
                    document.getElementById('cambioAlsubir'+indexData).innerHTML = infoBotonesWhenSubio;
                    infoBotonesWhenSubio += '';
                    // document.getElementById('cambioAlsubir1'+indexData).innerHTML = infoBotonesWhenSubio;
                    
                    PasarNuevaIno = '';
                    PasarNuevaIno1 = '';
                    
                PasarNuevaIno += '   <div class="col-3 col-sm-3 col-md-3 col-lg-3 ">';
                PasarNuevaIno += '<button data-idLote="1" data-cambiada='+validarCambioEnMismoModal+' data-nomLote="2" data-idCond="" id="borrarDoc" name="borrarDoc"' +
                ' data-idDocumento="'+data.ultimoInsert +'"  data-index="'+indexData+'" data-primer="'+indexData+'" data data-idSolicitud="'+solicitudId +'" data-idOpcion="'+iddocumento +'"  ' +
                'class="btn-data btn-warning cancelReg" title="BORRAR">' +
                '<i class="fas fa-trash-alt"></i></button>'; 
                PasarNuevaIno += '  </div>';

                PasarNuevaIno += ' <div class="col-2 col-sm-2 col-md-2 col-lg-2 ">';
                PasarNuevaIno += '<a  id="visualizarDoc" name="visualizarDoc" ' +
                ' data-idDocumento="'+data.ultimoInsert +'" data-cambiada='+validarCambioEnMismoModal+' data-primer="'+indexData+'" data-idSolicitud="'+solicitudId +'" data-idOpcion="'+iddocumento+'"' +
                'class="btn-data btn-violetBoots cancelReg" title="Visualizar">' +
                '<i class="fas fa-scroll"></i></a>'; 
                
                PasarNuevaIno += '  </div>';
                document.getElementById('cambioAlsubir'+indexData).innerHTML = PasarNuevaIno;
            

                },
                error: function(){
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        }
        });

        $(document).on("click", "#cambiarEstatus", function () {
            idStatus = $(this).attr("data-estatus");
            solicitudes = $(this).attr("data-solicitud");
            type = $(this).attr("data-type"); 
            console.log(solicitudes, idStatus)
            let solicitud = solicitudes ;
            let estatus = idStatus;
            let banderaUnRechazado = true;
            let mensaje = 'existe un RECHAZO';
            let code  = 200;
            var docs = []
                $.ajax({
                    type: 'POST',
                    url: 'getDocumentosPorSolicitudss',
                    data: 
                    {
                        "type" : type,
                        "estatus" : estatus,
                        "solicitud" : solicitud
                    } , 
                    dataType: "json",
                    
                    success: function(data) {
                            console.log(data);
                    if(data.length  != 0){
                        data.losDocumentos.forEach(function(elemento,i){
                            // console.log(data.misDocumentos.length);
                            data.misDocumentos.forEach(function(elementos,e){
                                if( elemento.id_documento == elementos.id_opcion )
                                {
                                    if(elementos.estatusValidacion == 2){
                                        banderaUnRechazado = false;
                                        mensaje = 'existe un RECHAZO';
                                        console.log();
                                    }  
                                    data.losDocumentos[i] = '' , i;                       
                                    docs.push(elementos)
                                } 
                                })
                        })
                    }
                    if(docs.length == data.losDocumentos.length && banderaUnRechazado == true){
                            console.log(docs);
                        
                            var type  = 1;
                            var comentarios = 'dadaa'
                            var area_rechazo =  ''
                            $.ajax({
                                type: 'POST',
                                url: 'changeStatus',
                                data: 
                                {
                                    // "pagos_activos"     : pagos_activos,
                                    "id_solicitud" : solicitud,
                                    "type" : type,
                                    "comentarios" : comentarios,
                                    "area_rechazo" : area_rechazo,
                                } , 
                                dataType: "json",                               
                                success: function(data) {
                    
                                },
                                error: function(){
                                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                                }
                            });
                            alerts.showNotification("top", "right", "Docuemntos enviados correctamente,Enviados.", "success");      
                            

                    }else{
                        alerts.showNotification("top", "right", "Oops,Es posible que falte un documento, o se encuentre rechazado.", "warning");
                    }
                    },
                    error: function(){
                        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    }

                });
        })
        
        $(document).on("click", "#preview", function () {
            var itself = $(this);
            var folder;
           
      switch (itself.attr('data-documentType')) {
   
        case '8':
            folder = 'BOLETA_PREDIAL';
            break;
        case '9':
            folder = 'CONSTANCIA_MANTENIMIENTO';
            break;
        case '10':
            folder = 'CONSTANCIA_AGUA';
            break;
        case '7':
            folder = 'FORMAS_DE_PAGO';
            break;
        case '11':
            folder = 'SOLICITUD_PRESUPUESTO';
            break;
        case '12':
            folder = 'PRESUPUESTO';
            break;
        case '13':
            folder = 'FACTURA';
            break;
        case '14':
            folder = 'TESTIMONIO';
            break;
        case '15':
            folder = 'PROYECTO_ESCRITURA';
            break;
        case '16':
            folder = 'TESTIMONIO';
            break;
        case '17':
            folder = 'OTROS';
            break;
        case '18':
            folder = 'CONTRATO';
            break; 
        case '19':
            folder = 'COPIA_CERTIFICADA';
        break;
        case '20':
            folder = 'OTROS';
            break;
        case '21':
            folder = 'CONTRATO';
            break;
        case '22':
            folder = 'COPIA_CERTIFICADA';
        break;
        case '23':
            folder = 'PRESUPUESTO_NOTARIA_EXTERNA';
            break;
        default:
            break;
    }
        
            Shadowbox.open({
                content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;z-index:999999!important;" src="${general_base_url}static/documentos/postventa/escrituracion/${folder}/${itself.attr('data-doc')}"></iframe></div>`,
                player: "html",
                title: `Visualizando archivo: ${itself.attr('data-doc')} `,
                width: 985,
                height: 660
            });
        });




    function folders (documentType){
            console.log(documentType)

        switch (documentType) {
            case 1:
                folder = "static/documentos/postventa/escrituracion/INE/";
                break;
            case 2:
                folder = "static/documentos/postventa/escrituracion/RFC/";
                break;
            case 3:
                folder = "static/documentos/postventa/escrituracion/COMPROBANTE_DE_DOMICILIO/";
                break;
            case 4:
                folder = "static/documentos/postventa/escrituracion/ACTA_DE_NACIMIENTO/";
                break;
            case 5:
                folder = "static/documentos/postventa/escrituracion/ACTA_DE_MATRIMONIO/";
                break;
            case 6:
                folder = "static/documentos/postventa/escrituracion/CURP/";
                break;
            case 7:
                folder = "static/documentos/postventa/escrituracion/FORMAS_DE_PAGO/";
                break;
            case 8:
                folder = "static/documentos/postventa/escrituracion/BOLETA_PREDIAL/";
                break;
            case 9:
                folder = "static/documentos/postventa/escrituracion/CONSTANCIA_MANTENIMIENTO/";
                break;
            case 10:
                folder = "static/documentos/postventa/escrituracion/CONSTANCIA_AGUA/";
                break;
            case 11:
                folder = "static/documentos/postventa/escrituracion/SOLICITUD_PRESUPUESTO/";
                break;
            case 12:
                // antes fue 13
                folder = "static/documentos/postventa/escrituracion/PRESUPUESTO/";
                break;
            case 13:
                // fue 15
                folder = "static/documentos/postventa/escrituracion/FACTURA/";
                break;
            case 14:
                // fue 16
                folder = "static/documentos/postventa/escrituracion/TESTIMONIO/";
                break;
            case 15:
                // fue la 17
                folder = "static/documentos/postventa/escrituracion/PROYECTO_ESCRITURA/";
                break;
            case 18:
                folder = "static/documentos/postventa/escrituracion/RFC_MORAL/";
                break;
            case 19:
                folder = "static/documentos/postventa/escrituracion/ACTA_CONSTITUTIVA/";
                break;
            case 17:
                // fue 20
                folder = "static/documentos/postventa/escrituracion/OTROS/";
                break;
            case 16:
                // fue 21
                folder = "static/documentos/postventa/escrituracion/CONTRATO/";
                break;
            case 20:
                // fue 22
                folder = "static/documentos/postventa/escrituracion/COPIA_CERTIFICADA/";
                break;
            case 23:
                folder = "static/documentos/postventa/escrituracion/PRESUPUESTO_NOTARIA_EXTERNA/";
                break;
        }
        return folder;
    } 

    // 
    // 
// 
// titulación


