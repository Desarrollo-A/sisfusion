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
        var valorSeleccionado = $(this).val();
        $("#filtro4").empty().selectpicker('refresh');
        $("#spiner-loader").removeClass('hide');
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
                $("#spiner-loader").addClass('hide');
            }
        });
    });

    $('#filtro4').change(function(){
        var residencial = $('#filtro3').val();
        var valorSeleccionado = $(this).val();
        $("#spiner-loader").removeClass('hide');
        $("#filtro5").empty().selectpicker('refresh');
        $.ajax({
            url: general_base_url + 'Corrida/getLotesPC/'+valorSeleccionado+'/'+residencial,
            type: 'post',
            dataType: 'json',
            success:function(response){
                var len = response.length;
                for( var i = 0; i<len; i++)
                {
                    var datos = response[i]['idLote']+','+response[i]['venta_compartida'];
                    var name = response[i]['nombreLote'];
                    $("#filtro5").append($('<option>').val(datos).text(name));
                }
                $("#filtro5").selectpicker('refresh');
                $("#spiner-loader").addClass('hide');
            },
        });
    });

    let titulos_intxt = [];
    $('#tableDoct thead tr:eq(0) th').each( function (i) {
        $(this).css('text-align', 'center');
        var title = $(this).text();
        titulos_intxt.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $( 'input', this ).on('keyup change', function () {
            if ($('#tableDoct').DataTable().column(i).search() !== this.value ) {
                $('#tableDoct').DataTable().column(i).search(this.value).draw();
            }
        });
    });

    $('#filtro5').change(function(){
        var seleccion = $(this).val();
        let datos = seleccion.split(',');
        let valorSeleccionado=datos[0];
        let ventaC = datos[1];
        $("#spiner-loader").removeClass('hide');
        $("#tableDoct").removeClass('hide');
        $('#tableDoct').DataTable({
            destroy: true,
            lengthMenu: [[15, 25, 50, -1], [10, 25, 50, "All"]],
            "ajax":{
                "url": general_base_url + 'Corrida/getCorridasPCByLote/'+valorSeleccionado,
                "dataSrc": ""
            },
            initComplete: function(){
                $("#spiner-loader").addClass('hide');
            },
            dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            width: "100%",
            scrollX: true,
            bAutoWidth: true,
            "ordering": false,
            "buttons": [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'CORRIDAS FINANCIERAS',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7],
                    format:{
                        header:  function (d, columnIdx) {
                            return ' ' + titulos_intxt[columnIdx] + ' ';
                        }
                    }
                },
            }],
            pagingType: "full_numbers",
            language: {
                url: general_base_url + "static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            columnDefs: [{
                visible: false,
                searchable: false
            }],
            "columns":[{
                data: 'id_pc'
            },
            {
                data: 'nombreResidencial'
            },
            {
                data: 'nombreCondominio'
            },
            {
                data: 'idLote'
            },
            {
                data: 'nombreLote'
            },
            {
                data : function (d) {
                    return '<p class="m-0">'+d.fecha_creacionpc.split('.')[0]+'</p>';
                }
            },
            {
                data: 'nombre_creador'
            },
            {
                data: 'modificado_nombre'
            },
            {
                data: null,
                render: function ( data, type, row )
                {
                    let button_action;
                    button_action = '<a href="'+general_base_url+'Corrida/editapc/'+data.id_pc+'" target="_blank"><button class="btn-data btn-green" data-idCorrida="'+data.id_pc+'" data-idLote="'+data.idLote+'"><i class="fa fa-eye"></i></button></a>';
                    return '<center>' + button_action + '</center>';
                }
            }],
        });
    });

    $('#tableDoct').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $(document).on('click', '.desactivar_corrida', function(){
        var $itself = $(this);
        let id_corrida = $itself.attr('data-idCorrida');
        let id_lote = $itself.attr('data-idLote');
        let disabled = 0;
        var formData = new FormData();
        formData.append("idLote", id_lote);
        
        $.ajax({
            url: general_base_url + "Corrida/actionMCorrida/"+id_corrida+"/"+disabled,
            data:formData,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            beforeSend: function(){},
            success : function (response) {
                response = JSON.parse(response);
                if(response.message == 'OK') {
                    alerts.showNotification('top', 'right', 'Corrida financiera deshabilitada', 'success');
                    $('#tableDoct').DataTable().ajax.reload();
                }else if(response.message == 'ERROR'){
                    alerts.showNotification('top', 'right', 'Ocurrií un error, intentalo nuevamente', 'danger');
                }
            }
        });
    });

    $(document).on('click', '.activar_corrida', function(){
        var $itself = $(this);
        let id_corrida = $itself.attr('data-idCorrida');
        let id_lote = $itself.attr('data-idLote');
        let enabled = 1;
        $('#spiner-loader').removeClass('hide');
        $.post(general_base_url + "Corrida/checCFActived/"+id_lote, function(data) {
            if(data.message >= 1){
                $('#avisoModal').modal();
                $('#spiner-loader').addClass('hide');
            }else{
                var formData = new FormData();
                formData.append("idLote", id_lote);
                $.ajax({
                    url: general_base_url + "Corrida/actionMCorrida/"+id_corrida+"/"+enabled,
                    data:formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    beforeSend: function(){
                        $('#spiner-loader').removeClass('hide');
                    },
                    success : function (response) {
                        response = JSON.parse(response);
                        if(response.message == 'OK') {
                            alerts.showNotification('top', 'right', 'Corrida financiera habilitada', 'success');
                            $('#tableDoct').DataTable().ajax.reload();
                        }else if(response.message == 'ERROR'){
                            alerts.showNotification('top', 'right', 'Ocurrií un error, intentalo nuevamente', 'danger');
                        }
                        $('#spiner-loader').addClass('hide');
                    }
                });
            }
        }, 'json');
    });

    $(document).on('click', '.editarpc', function(){
        var $itself = $(this);
        let id_corrida = $itself.attr('data-idcorrida');
        let id_lote = $itself.attr('data-idlote');
        window.location.href= general_base_url + "Corrida/editapc/"+id_corrida;
    });

    $('.btn-documentosGenerales').on('click', function () {
        $('#modalFiles').modal('show');
    });
});

$(document).on('click', '.pdfLink', function () {
    var $itself = $(this);
    Shadowbox.open({
        content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="'+general_base_url+'documentos/cliente/expediente/'+$itself.attr('data-Pdf')+'"></iframe></div>',
        player:     "html",
        title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
        width:      985,
        height:     660
    });
});

$(document).on('click', '.pdfLink2', function () {
    var $itself = $(this);
    Shadowbox.open({
        content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="'+general_base_url+'asesor/deposito_seriedad/'+$itself.attr('data-idc')+'/1/"></iframe></div>',
        player:     "html",
        title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
        width:      1600,
        height:     900
    });
});

$(document).on('click', '.pdfLink22', function () {
    var $itself = $(this);
    Shadowbox.open({
        content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="'+general_base_url+'asesor/deposito_seriedad_ds/'+$itself.attr('data-idc')+'/1/"></iframe></div>',
        player:     "html",
        title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
        width:      1600,
        height:     900
    });
});

$(document).on('click', '.pdfLink3', function () {
    var $itself = $(this);
    Shadowbox.open({
        content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="'+general_base_url+'documentos/cliente/contrato/'+$itself.attr('data-Pdf')+'"></iframe></div>',
        player:     "html",
        title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
        width:      985,
        height:     660
    });
});

$(document).on('click', '.verProspectos', function () {
    var $itself = $(this);
    let functionName = '';
    if ($itself.attr('data-lp') == 6) {
        functionName = 'printProspectInfoMktd';
    } else {
        functionName = 'printProspectInfo';
    }
    Shadowbox.open({
        content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="'+general_base_url+'clientes/'+functionName+'/'+$itself.attr('data-id-prospeccion')+'"></iframe></div>',
        player:     "html",
        title:      "Visualizando Prospecto: " + $itself.attr('data-nombreProspecto'),
        width:      985,
        height:     660
    });
});


$(document).on('click', '.verEVMKTD', function () {
    var $itself = $(this);
    var cntShow = '';

    if(checaTipo($itself.attr('data-expediente')) == "pdf")
    {
        cntShow = '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="'+general_base_url+'documentos/evidencia_mktd/'+$itself.attr('data-expediente')+'" allowfullscreen></iframe></div>';
    }else{
        cntShow = '<div><img src="'+general_base_url+'documentos/evidencia_mktd/'+$itself.attr('data-expediente')+'" class="img-responsive"></div>';
    }
    Shadowbox.open({
        content:    cntShow,
        player:     "html",
        title:      "Visualizando Evidencia MKTD: " + $itself.attr('data-nombreCliente'),
        width:      985,
        height:     660
    });
});

function checaTipo(archivo)
{
    archivo.split('.').pop();
    return validaFile;
}

$(document).on('click', '.seeAuts', function (e) {
    e.preventDefault();
    var $itself = $(this);
    var idLote=$itself.attr('data-idLote');
    $.post( general_base_url + "registroLote/get_auts_by_lote/"+idLote, function( data ) {
        $('#auts-loads').empty();
        var statusProceso;
        $.each(JSON.parse(data), function(i, item) {
            if(item['estatus'] == 0)
            {
                statusProceso="<small class='label bg-green' style='background-color: #00a65a'>ACEPTADA</small>";
            }
            else if(item['estatus'] == 1)
            {
                statusProceso="<small class='label bg-orange' style='background-color: #FF8C00'>En proceso</small>";
            }
            else if(item['estatus'] == 2)
            {
                statusProceso="<small class='label bg-red' style='background-color: #8B0000'>DENEGADA</small>";
            }
            else if(item['estatus'] == 3)
            {
                statusProceso="<small class='label bg-blue' style='background-color: #00008B'>En DC</small>";
            }
            else
            {
                statusProceso="<small class='label bg-gray' style='background-color: #2F4F4F'>N/A</small>";
            }
            $('#auts-loads').append('<h4>Solicitud de autorización:  '+statusProceso+'</h4><br>');
            $('#auts-loads').append('<h4>Autoriza: '+item['nombreAUT']+'</h4><br>');
            $('#auts-loads').append('<p style="text-align: justify;"><i>'+item['autorizacion']+'</i></p>' +'<br><hr>');
        });
        $('#verAutorizacionesAsesor').modal('show');
    });
});

if(id_rol_general == 7 || id_rol_general == 9 || id_rol_general == 3){
    var miArrayAddFile = new Array(8);
    var miArrayDeleteFile = new Array(1);

    $(document).ready (function() {
        $(document).on("click", ".update", function(e){
            e.preventDefault();
            $('#txtexp').val('');
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
                url: general_base_url + "registroCliente/addFileAsesor",
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
            url: general_base_url + "registroCliente/deleteFile",
            data: dataDelete,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success : function (response) {
                response = JSON.parse(response);
                if(response.message == 'OK') {
                    alerts.showNotification('top', 'right', 'Archivo eliminado', 'danger');
                    $('#aceptoDelete').prop('disabled', false);
                    $('#cuestionDelete').modal('hide');
                    $('#tableDoct').DataTable().ajax.reload();
                } else if(response.message == 'ERROR'){
                    alerts.showNotification('top', 'right', 'Error al eliminar el archivo', 'danger');
                    $('#tableDoct').DataTable().ajax.reload();
                }
            }
        });
    });
} 
