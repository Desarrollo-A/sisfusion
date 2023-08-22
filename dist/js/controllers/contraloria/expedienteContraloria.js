let titulos = [];
Shadowbox.init();
$('#tableDoct thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $('input', this).on('keyup change', function () {
        if ($('#tableDoct').DataTable().column(i).search() !== this.value) {
            $('#tableDoct').DataTable().column(i).search(this.value).draw();
        }
    });
});

$('body').tooltip({
    selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
    trigger: 'hover',
    container: 'body'
}).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
    $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
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
        console.log('triggered');
    });

    $('#filtro3').change(function(){
        var valorSeleccionado = $(this).val();
        $("#filtro4").empty().selectpicker('refresh');
        $.ajax({
            url: general_base_url+'registroCliente/getCondominios/'+valorSeleccionado,
            type: 'post',
            dataType: 'json',
            beforeSend:function(){
                $('#spiner-loader').removeClass('hide');
            },
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
        var residencial = $('#filtro3').val();
        var valorSeleccionado = $(this).val();
        $("#filtro5").empty().selectpicker('refresh');
        $.ajax({
            url: general_base_url+'registroCliente/getLotesAllTwo/'+valorSeleccionado+'/'+residencial,
            type: 'post',
            dataType: 'json',
            beforeSend:function(){
                $('#spiner-loader').removeClass('hide');
            },
            success:function(response){
                var len = response.length;
                if(len > 0){
                    for( var i = 0; i<len; i++)
                    {
                        var id = response[i]['idLote'];
                        var name = response[i]['nombreLote'];
                        $("#filtro5").append($('<option>').val(id).text(name));
                    }
                }else{
                    $("#filtro5").append($('<option>').val(0).text('No se encontraron lotes'));
                }
                $("#filtro5").selectpicker('refresh');
                $('#spiner-loader').addClass('hide');
            }
        });
    });

    $('#filtro5').change(function(){
        $('#tableDoct').removeClass('hide');
        var valorSeleccionado = $(this).val();
        $('#tableDoct').DataTable({
            destroy: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ajax:
                {
                    url: general_base_url+'registroCliente/expedientesWS/'+valorSeleccionado,
                    dataSrc: ""
                },
                dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
                width: "100%",
                scrollX: true,
                bAutoWidth:true,
                buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: 'Documentación (contraloría)',
                    title:'Documentación (contraloría)',
                    className: 'btn buttons-excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 7, 8],
                        format: {
                            header: function (d, columnIdx) {
                                return ' ' + titulos[columnIdx] + ' ';
                            }
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    titleAttr: 'Documentación (contraloría)',
                    title:'Documentación (contraloría)',
                    className: 'btn buttons-pdf',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 7, 8],
                        format: {
                            header: function (d, columnIdx) {
                                return ' ' + titulos[columnIdx] + ' ';
                            }
                        }
                    }
                }
            ],
            ordering: false,
            language: {
                url: "../static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            columns:
                [
                    {data: 'nombreResidencial'},
                    {data: 'nombre'},
                    {data: 'nombreLote'},
                    {
                        data: null,
                        render: function ( data)
                        {
                            return data.nombreCliente;
                        },
                    },
                    {data: 'movimiento'},
                    {data: 'modificado'},
                    {
                        data: null,
                        render: function ( data )
                        {
                            if (getFileExtension(data.expediente) == "pdf") {
                                if(data.tipo_doc == 8){
                                    file = '<a class="pdfLink3 btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a>';
                                } else {
                                    if(id_rol_general == 13 || id_rol_general == 32 || id_rol_general == 17){
                                        if(data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92){
                                            file = '<a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.expediente+'">'+
                                            '<i class="fas fa-file-pdf"></i></a>'
                                            '<button type="button" title= "Eliminar archivo" id="deleteDoc" class="btn-data btn-warning delete" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></i></button>';
                                        } else {
                                            file = '<a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a>';
                                        }
                                    } else {
                            file = '<a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a>';
                        }
                                }
                            }
                            else if (getFileExtension(data.expediente) == "xlsx" || getFileExtension(data.expediente) == "XLSX") {
                                file = "<a href='../../static/documentos/cliente/corrida/" + data.expediente + "' style='cursor: pointer' class='btn-data btn-green-excel'><i class='fas fa-file-excel'></i><src='../../static/documentos/cliente/corrida/" + data.expediente + "'> </a> ";
                            }
                            else if (getFileExtension(data.expediente) == "NULL" || getFileExtension(data.expediente) == 'null' || getFileExtension(data.expediente) == "") {
                                if(data.tipo_doc == 7){
                                    file = '<button type="button" title= "Corrida inhabilitada" style="cursor: pointer" class="btn-data btn-orangeYellow disabled" disabled><i class="fas fa-border-all"></i></button>';
                                } else if(data.tipo_doc == 8){
                                    file = '<button type="button" title= "Contrato inhabilitado" style="cursor: pointer" class="btn-data btn-orangeYellow disabled" disabled><i class="fas fa-file"></i></button>';
                                } else {
                                    if(id_rol_general == 13 || id_rol_general == 32 || id_rol_general == 17){
                                    if(data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92){
                                        file = '<button type="button" id="updateDoc" style="cursor: pointer" title= "Adjuntar archivo" class="btn-data btn-green update" data-iddoc="'+data.idDocumento+'" data-tipodoc="'+data.tipo_doc+'" data-descdoc="'+data.movimiento+'" data-idCliente="'+data.idCliente+'" data-nombreResidencial="'+data.nombreResidencial+'" data-nombreCondominio="'+data.nombre+'" data-nombreLote="'+data.nombreLote+'" data-idCondominio="'+data.idCondominio+'" data-idLote="'+data.idLote+'"><i class="fas fa-cloud-upload-alt"></i></button>';
                                    } else {
                                        file = '<button type="button" id="updateDoc" style="cursor: pointer" title= "No se permite adjuntar archivos" class="btn-data btn-green disabled" disabled><i class="fas fa-cloud-upload-alt"></i></button>';
                                    }
                                        } else { 
                            file = '<button type="button" id="updateDoc" style="cursor: pointer" title= "No se permite adjuntar archivos" class="btn-data btn-green disabled" disabled><i class="fas fa-cloud-upload-alt"></i></button>'; 
                        }
                                }
                            }
                            else if (getFileExtension(data.expediente) == "Depósito de seriedad") {
                                file = '<a class="btn-data btn-blueMaderas pdfLink2" data-idc="'+data.id_cliente+'" data-nomExp="'+data.expediente+'" style="cursor: pointer" title= "Depósito de seriedad"><i class="fas fa-file"></i></a>';
                            }
                            else if (getFileExtension(data.expediente) == "Autorizaciones") {
                                file = '<a href="#" class="btn-data btn-warning seeAuts" style="cursor: pointer" title= "Autorizaciones" data-id_autorizacion="'+data.id_autorizacion+'" data-idLote="'+data.idLote+'"><i class="fas fa-key"></i></a>';
                            }
                            else if (getFileExtension(data.expediente) == "Prospecto") {
                                file = '<a href="#" class="btn-data btn-blueMaderas verProspectos" style="cursor: pointer" title= "Prospección" data-id-prospeccion="'+data.id_prospecto+'" data-nombreProspecto="'+data.nombreCliente+'"><i class="fas fa-user-check"></i></a>';
                            }
                            else
                            {
                                    if(id_rol_general == 13 || id_rol_general == 32 || id_rol_general == 17){
                                if(data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92){
                                    file = '<a class="pdfLink btn-data btn-acidGreen" title= "Ver archivo" style="cursor: pointer" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-image"></i></a><button type="button" title= "Eliminar archivo" id="deleteDoc" class="btn-data btn-warning delete" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></i></button>';
                                } else {
                                    file = '<a class="pdfLink btn-data btn-acidGreen" title= "Ver archivo" style="cursor: pointer" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-image"></i></a>';
                                }
                                    } else { 
                            file = '<a class="pdfLink btn-data btn-acidGreen" title= "Ver archivo" style="cursor: pointer" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-image"></i></a>'; 
                        }
                            }
                            return "<div class='d-flex justify-center'>" + file + "</div>";
                        }
                    },
                    {
                        data: null,
                        render: function ( data, )
                        {
                            return myFunctions.validateEmptyFieldDocs(data.primerNom) +' '+myFunctions.validateEmptyFieldDocs(data.apellidoPa)+' '+myFunctions.validateEmptyFieldDocs(data.apellidoMa);
                        },
                    },
                    {data: 'ubic'},
                ]
        });

    });

    $('.btn-documentosGenerales').on('click', function () {
        $('#modalFiles').modal('show');
    });

    function getFileExtension(filename) {
        validaFile =  filename == null ? 'null':
            filename == 'Depósito de seriedad' ? 'Depósito de seriedad':
                filename == 'Autorizaciones' ? 'Autorizaciones':
                    filename.split('.').pop();
        return validaFile;
    }

});

$(document).on('click', '.pdfLink', function () {
    var $itself = $(this);
    Shadowbox.open({
        content:    '<div style="height: 100%";><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="'+general_base_url+'static/documentos/cliente/expediente/'+$itself.attr('data-Pdf')+'"></iframe></div>',
        player:     "html",
        title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
        width:      985,
        height:     660
    });
});

$(document).on('click', '.pdfLink2', function () {
    var $itself = $(this);
    Shadowbox.open({
        content:    '<div style="height: 100%";><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="'+general_base_url+'asesor/deposito_seriedad/'+$itself.attr('data-idc')+'/1/"></iframe></div>',
        player:     "html",
        title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
        width:      1600,
        height:     900
    });
});

$(document).on('click', '.pdfLink3', function () {
    var $itself = $(this);
    Shadowbox.open({
        content:    '<div style="height: 100%";><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="'+general_base_url+'static/documentos/cliente/contrato/'+$itself.attr('data-Pdf')+'"></iframe></div>',
        player:     "html",
        title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
        width:      985,
        height:     660
    });
});

$(document).on('click', '.verProspectos', function () {
    var $itself = $(this);
    Shadowbox.open({
        content:    '<div style="height: 100%";><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="'+general_base_url+'clientes/printProspectInfo/'+$itself.attr('data-id-prospeccion')+'"></iframe></div>',
        player:     "html",
        title:      "Visualizando Prospecto: " + $itself.attr('data-nombreProspecto'),
        width:      985,
        height:     660
    });
});

$(document).on('click', '.seeAuts', function (e) {
    e.preventDefault();
    var $itself = $(this);
    var idLote=$itself.attr('data-idLote');
    $.post(general_base_url+"registroLote/get_auts_by_lote/"+idLote, function( data ) {
        $('#auts-loads').empty();
        var statusProceso;
        $.each(JSON.parse(data), function(i, item) {
            if(item['estatus'] == 0)
            {
                statusProceso="<small class='label lbl-green'>ACEPTADA</small>";
            }
            else if(item['estatus'] == 1)
            {
                statusProceso="<small class='label lbl-orangeYellow'>En proceso</small>";
            }
            else if(item['estatus'] == 2)
            {
                statusProceso="<small class='label lbl-warning'>DENEGADA</small>";
            }
            else if(item['estatus'] == 3)
            {
                statusProceso="<small class='label lbl-azure'>En DC</small>";
            }
            else
            {
                statusProceso="<small class='label lbl-gray'>NO APLICA</small>";
            }
            $('#auts-loads').append('<h4 class="pb-1">Solicitud de autorización:  '+statusProceso+'</h4>');
            $('#auts-loads').append('<p style="text-align: justify;"><i>'+item['autorizacion']+'</i></p>' +
                '<br>');
        });
        $('#verAutorizacionesAsesor').modal('show');
    });
});

if(id_rol_general == 13 || id_rol_general == 32 || id_rol_general == 17){
    var miArrayAddFile = new Array(8);
    var miArrayDeleteFile = new Array(1);
    $(document).ready (function() {
        $(document).on("click", ".update", function(e){
            e.preventDefault();
            var descdoc= $(this).data("descdoc");
            var idCliente = $(this).attr("data-idCliente");
            var nombreResidencial = $(this).attr("data-nombreResidencial");
            var nombreCondominio = $(this).attr("data-nombreCondominio");
            var idCondominio = $(this).attr("data-idCondominio");
            var nombreLote = $(this).attr("data-nombreLote");
            var idLote = $(this).attr("data-idLote");
            var tipodoc = $(this).attr("data-tipodoc");
            var iddoc = $(this).attr("data-iddoc");
            miArrayAddFile[0] = idCliente;
            miArrayAddFile[1] = nombreResidencial;
            miArrayAddFile[2] = nombreCondominio;
            miArrayAddFile[3] = idCondominio;
            miArrayAddFile[4] = nombreLote;
            miArrayAddFile[5] = idLote;
            miArrayAddFile[6] = tipodoc;
            miArrayAddFile[7] = iddoc;
            $(".lote").html(descdoc);
            $('#addFile').modal('show');
        });
    });

    $(document).on('click', '#sendFile', function(e) {
        e.preventDefault();
        var idCliente = miArrayAddFile[0];
        var nombreResidencial = miArrayAddFile[1];
        var nombreCondominio = miArrayAddFile[2];
        var idCondominio = miArrayAddFile[3];
        var nombreLote = miArrayAddFile[4];
        var idLote = miArrayAddFile[5];
        var tipodoc = miArrayAddFile[6];
        var iddoc = miArrayAddFile[7];
        var expediente = $("#expediente")[0].files[0];
        var validaFile = (expediente == undefined) ? 0 : 1;
        tipodoc = (tipodoc == 'null') ? 0 : tipodoc;
        var dataFile = new FormData();
        dataFile.append("idCliente", idCliente);
        dataFile.append("nombreResidencial", nombreResidencial);
        dataFile.append("nombreCondominio", nombreCondominio);
        dataFile.append("idCondominio", idCondominio);
        dataFile.append("nombreLote", nombreLote);
        dataFile.append("idLote", idLote);
        dataFile.append("expediente", expediente);
        dataFile.append("tipodoc", tipodoc);
        dataFile.append("idDocumento", iddoc);
        if (validaFile == 0) {
            alerts.showNotification('top', 'right', 'Debes seleccionar un archivoo', 'danger');
        }
        if (validaFile == 1) {
            $('#sendFile').prop('disabled', true);
            $.ajax({
                url: general_base_url+"registroCliente/addFileAsesor",
                data: dataFile,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success : function (response) {
                    response = JSON.parse(response);
                    if(response.message == 'OK') {
                        alerts.showNotification('top', 'right', 'Expediente enviado', 'success');
                        $('#sendFile').prop('disabled', false);
                        $('#addFile').modal('hide');
                        $('#tableDoct').DataTable().ajax.reload();
                    } else if(response.message == 'ERROR'){
                        alerts.showNotification('top', 'right', 'Error al enviar expediente y/o formato no válido', 'danger');
                        $('#sendFile').prop('disabled', false);
                    }
                }
            });
        }
    });

    $(document).ready (function() {
        $(document).on("click", ".delete", function(e){
            e.preventDefault();
            var iddoc= $(this).data("iddoc");
            var tipodoc= $(this).data("tipodoc");
            miArrayDeleteFile[0] = iddoc;
            $(".tipoA").html(tipodoc);
            $('#cuestionDelete').modal('show');
        });
    });

    $(document).on('click', '#aceptoDelete', function(e) {
        e.preventDefault();
        var id = miArrayDeleteFile[0];
        var dataDelete = new FormData();
        dataDelete.append("idDocumento", id);
        $('#aceptoDelete').prop('disabled', true);
        $.ajax({
            url: general_base_url+"registroCliente/deleteFile",
            data: dataDelete,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success : function (response) {
                response = JSON.parse(response);
                if(response.message == 'OK') {
                    //toastr.success('Archivo eliminado.', '¡Alerta de Éxito!');
                    alerts.showNotification('top', 'right', 'Archivo eliminado', 'danger');
                    $('#aceptoDelete').prop('disabled', false);
                    $('#cuestionDelete').modal('hide');
                    $('#tableDoct').DataTable().ajax.reload();
                } else if(response.message == 'ERROR'){
                    //toastr.error('Error al eliminar el archivo.', '¡Alerta de error!');
                    alerts.showNotification('top', 'right', 'Error al eliminar el archivo', 'danger');
                    $('#tableDoct').DataTable().ajax.reload();
                }
            }
        });
    });

    jQuery(document).ready(function(){
        jQuery('#addFile').on('hidden.bs.modal', function (e) {
            jQuery(this).removeData('bs.modal');
            jQuery(this).find('#expediente').val('');
            jQuery(this).find('#txtexp').val('');
        })
    })
} 
