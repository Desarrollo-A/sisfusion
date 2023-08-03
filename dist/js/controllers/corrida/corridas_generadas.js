$('[data-toggle="tooltip"]').tooltip();
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

        // console.log(valorSeleccionado);
        //build select condominios
        $("#filtro4").empty().selectpicker('refresh');
        $.ajax({
            url: general_base_url+'registroCliente/getCondominios/'+valorSeleccionado,
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

            }
        });
    });

    $('#filtro4').change(function(){
        var residencial = $('#filtro3').val();
        var valorSeleccionado = $(this).val();
        $("#filtro5").empty().selectpicker('refresh');
        $.ajax({
            url: general_base_url+'Corrida/getLotesWCF/'+valorSeleccionado+'/'+residencial,
            type: 'post',
            dataType: 'json',
            success:function(response){
                console.log("back: ", response);
                var len = response.length;
                for( var i = 0; i<len; i++)
                {
                    var datos = response[i]['idLote']+','+response[i]['venta_compartida'];
                    var name = response[i]['nombreLote'];
                    /*let datos = datos.split(',');
                    let id = datos[0];*/

                    $("#filtro5").append($('<option>').val(datos).text(name));
                }
                $("#filtro5").selectpicker('refresh');

            },
            //async: false
        });
    });



    let titulos_intxt = [];
    $('#tableDoct thead tr:eq(0) th').each( function (i) {
        $(this).css('text-align', 'center');
        var title = $(this).text();
        titulos_intxt.push(title);
        $(this).html('<input type="text"  data-toggle="tooltip" data-placement="top" title="' + title + '" class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tableDoct').DataTable().column(i).search() !== this.value ) {
                $('#tableDoct').DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });

    $('#filtro5').change(function(){

        var seleccion = $(this).val();
        let datos = seleccion.split(',');
        let valorSeleccionado=datos[0];
        let ventaC = datos[1];
        //alert(ventaC);



        console.log("selección:  ", valorSeleccionado);




        $('#tableDoct').DataTable({
            destroy: true,
            lengthMenu: [[15, 25, 50, -1], [10, 25, 50, "All"]],
            "ajax":
                {
                    "url": general_base_url+'Corrida/getCorridasByLote/'+valorSeleccionado,
                    "dataSrc": ""
                },
            dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            width: "auto",
            "ordering": false,
            "buttons": [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'CORRIDAS FINANCIERAS',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3,4,5, 7, 8 ],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'ID CORRIDA';
                                        break;
                                    case 1:
                                        return 'ESTATUS';
                                        break;
                                    case 2:
                                        return 'PROYECTO';
                                        break;
                                    case 3:
                                        return 'CONDOMINIO';
                                        break;
                                    case 4:
                                        return 'ID LOTE';
                                        break;
                                    case 5:
                                        return 'LOTE';
                                        break;
                                    case 7:
                                        return 'CLIENTE';
                                        break;
                                    case 8:
                                        return 'HORA/FECHA';
                                        break;
                                }
                            }
                        }
                    },
                }
            ],
            pagingType: "full_numbers",
            language: {
                url: `${general_base_url}/static/spanishLoader_v2.json`,
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            columnDefs: [{
                visible: false,
                searchable: false
            }],
            "columns":
                [
                    {data: 'id_corrida'},
                    {
                        data: null,
                        render: function ( data, type, row )
                        {
                            let label;
                            if(data.status==1){
                                label = '<span class="label lbl-green">Activa</span>';
                            }else{
                                label = '<span class="label lbl-warning">Inactiva</span>';
                            }
                            return label;
                        },
                    },
                    {data: 'nombreResidencial'},
                    {data: 'nombreCondominio'},
                    {data: 'idLote'},
                    {data: 'nombreLote'},
                    {
                        data: null,
                        render: function ( data, type, row )
                        {
                            return data.nombreCliente;
                        },
                    },
                    {
                        data: null,
                        render: function ( data, type, row )
                        {
                            let d = new Date(data.creacion_corrida);
                            let month = (d.getMonth() + 1).toString().padStart(2, '0');
                            let day = d.getDate().toString().padStart(2, '0');
                            let year = d.getFullYear();
                            let hr = d.getHours().toString().padStart(2, '0');;
                            let min = d.getMinutes().toString().padStart(2, '0');;
                            let segs = d.getSeconds().toString().padStart(2, '0');;
                            let fecha = [year, month, day].join('-');
                            let hrs = [hr, min, segs].join(':');
                            return fecha+' '+hrs;
                        },
                    },
                    {
                        data: null,
                        render: function ( data, type, row )
                        {
                            return data.nombreAsesor;
                        }
                    },
                    {
                        data: null,
                        render: function (data, type, row){
                            let container_btnc;
                            if(id_rol_general == 17 || id_rol_general ==32 || id_rol_general==70){
                                if((data.idStatusContratacion == 5 || data.idStatusContratacion==2) && (data.idMovimiento==35 || data.idMovimiento==22 || data.idMovimiento==62 || data.idMovimiento==75 || data.idMovimiento==94) && data.status==1){
                                    container_btnc =  '<center><a href="'+general_base_url+'Corrida/editacf/'+ data.id_corrida +'" target="_blank" style="padding:10px 0px"><button class="btn-data btn-green ' +
                                        'btn-fab btn-fab-mini"><i class="fas fa-money-check-alt"></i></button></a></center>';
                                }else{
                                    container_btnc =  '<center><button class="btn-data btn-green ' +
                                        'btn-fab btn-fab-mini" disabled><i class="fas fa-money-check-alt"></i></button></center>';
                                }
                            }else{
                                container_btnc =  '<center><a href="'+general_base_url+'Corrida/editacf/'+ data.id_corrida +'" target="_blank" style="padding:10px 0px"><button class="btn-data btn-green ' +
                                    'btn-fab btn-fab-mini"><i class="fas fa-money-check-alt"></i></button></a></center>';
                            }
                            return container_btnc;
                        }
                    },
                    {
                        data: null,
                        visible: (id_rol_general==17 || id_rol_general==32) ? false:true,
                        render: function (data, type, row) {
                            let button_action;

                            if (data.status == 1) {
                                button_action = '<button class="btn-data-gral btn-warning  desactivar_corrida" data-idCorrida="' + data.id_corrida + '" data-idLote="' + data.idLote + '">Desactivar</button>';
                            } else {

                                if (data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82
                                    || data.idMovimiento == 92 || data.idMovimiento == 96 || data.idMovimiento == 99 || data.idMovimiento == 102 || data.idMovimiento == 104 || data.idMovimiento == 104
                                    || data.idMovimiento == 107 || data.idMovimiento == 108 || data.idMovimiento == 109 || data.idMovimiento == 111) {

                                    button_action = '<button class="btn-data-gral btn-green activar_corrida" data-idCorrida="' + data.id_corrida + '" data-idLote="' + data.idLote + '">Activar</button>';
                                } else {
                                    button_action = '<button class="" disabled ' +
                                        'style="width: 100%;\n' +
                                        '    border-radius: 27px;\n' +
                                        '    border: none;\n' +
                                        '    padding: 10px 0;\n' +
                                        '    box-shadow: 0px 8px 15px RGB(0, 0, 0, 0.3);background-color: #a3a3a3; cursor:not-allowed;opacity: 0.6;\n">Activar</button><br>' +
                                        '<center><small>El lote no se encuentra en el estatus para asignación de CF</small></center>';
                                }
                            }
                            return '<center>' + button_action + '</center>';
                        }
                    },

    ],
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            });
        },
    });

    });

    $(document).on('click', '.desactivar_corrida', function(){
        var $itself = $(this);
        let id_corrida = $itself.attr('data-idCorrida');
        let id_lote = $itself.attr('data-idLote');

        let disabled = 0;
        console.log("Desactivar corrida: ", id_corrida);
        var formData = new FormData();
        formData.append("idLote", id_lote);
        $.ajax({
            url: general_base_url+"Corrida/actionMCorrida/"+id_corrida+"/"+disabled,
            data:formData,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            beforeSend: function(){
                console.log('enviando...');
            },
            success : function (response) {
                response = JSON.parse(response);
                console.log(response);
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
        // console.log("Activar corrida: ", id_corrida);

        $('#spiner-loader').removeClass('hide');
        $.post(general_base_url+"Corrida/checCFActived/"+id_lote, function(data) {
            console.log(data.message);
            if(data.message >= 1){
                //lanzar aviso de que no se pueden 2 al mismo tiempo
                $('#avisoModal').modal();
                $('#spiner-loader').addClass('hide');
            }else{
                //hacer la acción puesto que no hay registros
                var formData = new FormData();
                formData.append("idLote", id_lote);
                $.ajax({
                    url: general_base_url+"Corrida/actionMCorrida/"+id_corrida+"/"+enabled,
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
                        console.log(response);
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



});/*document Ready*/

$(document).on('click', '.pdfLink', function () {
    var $itself = $(this);
    Shadowbox.open({
        content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/cliente/expediente/'+$itself.attr('data-Pdf')+'"></iframe></div>',
        player:     "html",
        title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
        width:      985,
        height:     660
    });
});

$(document).on('click', '.pdfLink2', function () {
    var $itself = $(this);
    Shadowbox.open({
        content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>asesor/deposito_seriedad/'+$itself.attr('data-idc')+'/1/"></iframe></div>',
        player:     "html",
        title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
        width:      1600,
        height:     900
    });
});

$(document).on('click', '.pdfLink22', function () {
    var $itself = $(this);
    Shadowbox.open({
        content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>asesor/deposito_seriedad_ds/'+$itself.attr('data-idc')+'/1/"></iframe></div>',
        player:     "html",
        title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
        width:      1600,
        height:     900
    });
});

$(document).on('click', '.pdfLink3', function () {
    var $itself = $(this);
    Shadowbox.open({
        content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/cliente/contrato/'+$itself.attr('data-Pdf')+'"></iframe></div>',
        player:     "html",
        title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
        width:      985,
        height:     660
    });
});

$(document).on('click', '.verProspectos', function () {
    var $itself = $(this);
    let functionName = '';
    if ($itself.attr('data-lp') == 6) { // IS MKTD
        functionName = 'printProspectInfoMktd';
    } else {
        functionName = 'printProspectInfo';
    }
    Shadowbox.open({
        /*verProspectos*/
        content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>clientes/'+functionName+'/'+$itself.attr('data-id-prospeccion')+'"></iframe></div>',
        player:     "html",
        title:      "Visualizando Prospecto: " + $itself.attr('data-nombreProspecto'),
        width:      985,
        height:     660

    });
});


/*evidencia MKTD PDF*/
$(document).on('click', '.verEVMKTD', function () {
    var $itself = $(this);
    var cntShow = '';

    if(checaTipo($itself.attr('data-expediente')) == "pdf")
    {
        cntShow = '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/evidencia_mktd/'+$itself.attr('data-expediente')+'" allowfullscreen></iframe></div>';
    }else{
        cntShow = '<div><img src="<?=base_url()?>static/documentos/evidencia_mktd/'+$itself.attr('data-expediente')+'" class="img-responsive"></div>';
    }
    /*content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/evidencia_mktd/'+$itself.attr('data-expediente')+'" allowfullscreen></iframe></div>',*/
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
    $.post( general_base_url+"registroLote/get_auts_by_lote/"+idLote, function( data ) {
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
            $('#auts-loads').append('<p style="text-align: justify;"><i>'+item['autorizacion']+'</i></p>' +
                '<br><hr>');


        });
        $('#verAutorizacionesAsesor').modal('show');
    });
});

if(id_rol_general==7 || id_rol_general==9 || id_rol_general==3){
    /*más querys alv*/
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
            console.log('alcuishe');

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
            //toastr.error('Debes seleccionar un archivo.', '¡Alerta!');
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
                        //toastr.success('Expediente enviado.', '¡Alerta de Éxito!');
                        alerts.showNotification('top', 'right', 'Expediente enviado', 'success');
                        $('#sendFile').prop('disabled', false);
                        $('#addFile').modal('hide');
                        $('#tableDoct').DataTable().ajax.reload();
                    } else if(response.message == 'ERROR'){
                        //toastr.error('Error al enviar expediente y/o formato no válido.', '¡Alerta de error!');
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

}


/*

*/
