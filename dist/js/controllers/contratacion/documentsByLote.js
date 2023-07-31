let titulos_intxt = [];
$(document).ready (function() {
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

    $(".find_doc").click( function() {
        $('#tableDoct').removeClass('hide');
        var idLote = $('#inp_lote').val();
        if(idLote=='' || idLote == undefined || idLote == null){
            alerts.showNotification('top', 'right', 'Ingresa el ID de lote', 'danger');
        }else{
            $('#tableDoct').DataTable({
                destroy: true,
                width: "100%",
                scrollX: true,
                "ajax":
                    {
                        "url": general_base_url + 'index.php/registroCliente/expedientesWS/'+idLote,
                        "dataSrc": ""
                    },
                dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
                "ordering": false,
                "buttons": [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Descargar archivo de Excel',
                        title:"Documentación del lote",
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 8 ],
                            format: 
                            {
                                header:  function (d, columnIdx) {
                                return ' ' + titulos_intxt[columnIdx] + ' ';
                                }
                            }
                        },
                    }
                ],
                pagingType: "full_numbers",
                language: {
                    url: general_base_url + "/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                columnDefs: [{
                    visible: false,
                    searchable: false
                }],
                columns:
                    [
                        {data: 'nombreResidencial'},
                        {data: 'nombre'},
                        {data: 'nombreLote'},
                        {data: 'idLote'},
                        {data: 'nombreCliente'},
                        {data: 'movimiento'},
                        {data: 'modificado'},
                        {
                            data: null,
                            render: function ( data, type, row )
                            {
                                datos = data.id_asesor;
                                if (getFileExtension(data.expediente) == "pdf") {
                                    if(data.tipo_doc == 8){
                                        file = '<a class="pdfLink3 btn-data btn-warning" data-Pdf="'+data.expediente+'" data-toggle="tooltip" data-placement="top" title= "VER ARCHIVO" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a>';
                                    }else if(data.tipo_doc == 66){
                                        file = '<a class="verEVMKTD  btn-data btn-warning" data-expediente="'+data.expediente+'" data-toggle="tooltip" data-placement="top" title= "VER ARCHIVO" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><i class="fas fa-file-pdf"></i></a>';
                                    }
                                    else {
                                        if(id_rol_general == 7 || id_rol_general == 9 || id_rol_general == 3){
                                        if(data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92 || data.idMovimiento == 96 && (id_rol_current==7 || id_rol_current==9 || id_rol_current==3) ){
                                            file = '<a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" data-toggle="tooltip" data-placement="top" title= "VER ARCHIVO" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a><button type="button" title= "Eliminar archivo" id="deleteDoc" class="btn-data btn-warning delete" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></button>';
                                        } else {
                                            file = '<a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" data-toggle="tooltip" data-placement="top" title= "VER ARCHIVO" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a>';
                                        }
                                        } else {
                                            file = '<a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" data-toggle="tooltip" data-placement="top" title= "VER ARCHIVO" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a>';
                                        }
                                    }
                                }
                                else if (getFileExtension(data.expediente) == "xlsx" || getFileExtension(data.expediente) == "XLSX") {
                                    file = "<a type='button' href='../../static/documentos/cliente/corrida/" + data.expediente + "' class='btn-data btn-green-excel'><i class='fas fa-file-excel'></i><src='../../static/documentos/cliente/corrida/" + data.expediente + "'> </a> ";
                                }
                                else if (getFileExtension(data.expediente) == "NULL" || getFileExtension(data.expediente) == 'null' || getFileExtension(data.expediente) == "") {
                                    if(data.tipo_doc == 7){
                                        file = '<button type="button" data-toggle="tooltip" data-placement="top" title= "CORRIDA INABILITADA" class="btn-data btn-orangeYellow disabled"><i class="fas fa-th"></i></button>';
                                    } else if(data.tipo_doc == 8){
                                        file = '<button type="button" data-toggle="tooltip" data-placement="top" title= "CONTRATO INABILITADO" class="btn-data btn-orangeYellow disabled"><i class="fas fa-th"></i></button>';
                                    } else {
                                        if(id_rol_general == 7 || id_rol_general == 9 || id_rol_general == 3)
                                        if(data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92 || data.idMovimiento == 96 && (id_rol_current==7 || id_rol_current==9 || id_rol_current==3) ){
                                            file = '<button type="button" id="updateDoc" data-toggle="tooltip" data-placement="top" title= "ADJUNTAR ARCHIVOS" class="btn-data btn-green update" data-iddoc="'+data.idDocumento+'" data-tipodoc="'+data.tipo_doc+'" data-descdoc="'+data.movimiento+'" data-idCliente="'+data.idCliente+'" data-nombreResidencial="'+data.nombreResidencial+'" data-nombreCondominio="'+data.nombre+'" data-nombreLote="'+data.nombreLote+'" data-idCondominio="'+data.idCondominio+'" data-idLote="'+data.idLote+'"><i class="fas fa-cloud-upload-alt"></i></button>';
                                        } else {
                                            file = '<button type="button" id="updateDoc" data-toggle="tooltip" data-placement="top" title= "NO SE PERMITE ADJUNTAR ARCHIVOS" class="btn-data btn-green" disabled><i class="fas fa-cloud-upload-alt"></i></button>';
                                        } else { 
                                            file = '<button type="button" id="updateDoc" data-toggle="tooltip" data-placement="top" title= "NO SE PERMITE ADJUNTAR ARCHIVOS" class="btn-data btn-green disabled" disabled><i class="fas fa-cloud-upload-alt"></i></button>';
                                        } 
                                    }
                                }
                                else if (getFileExtension(data.expediente) == "Depósito de seriedad") {
                                    file = '<button class="btn-data btn-blueMaderas pdfLink2" data-idc="'+data.id_cliente+'" data-nomExp="'+data.expediente+'" data-toggle="tooltip" data-placement="top" title= "DEPÓSITO DE SERIEDAD"><i class="fas fa-file"></i></button>';
                                }
                                else if (getFileExtension(data.expediente) == "Depósito de seriedad versión anterior") {
                                    file = '<a class="btn-data btn-blueMaderas pdfLink22" data-idc="'+data.id_cliente+'" data-nomExp="'+data.expediente+'" data-toggle="tooltip" data-placement="top" title= "DEPÓSITO DE SERIEDAD"><i class="fas fa-file"></i></a>';
                                }
                                else if (getFileExtension(data.expediente) == "Autorizaciones") {
                                    file = '<a href="#" class="btn-data btn-warning seeAuts" title= "Autorizaciones" data-idCliente="'+data.idCliente+'" data-id_autorizacion="'+data.id_autorizacion+'" data-idLote="'+data.idLote+'"><i class="fas fa-key"></i></a>';
                                }
                                else if (getFileExtension(data.expediente) == "Prospecto") {
                                    file = '<a href="#" class="btn-data btn-blueMaderas verProspectos" data-toggle="tooltip" data-placement="top" title= "PROSPECCIÓN" data-id-prospeccion="'+data.id_prospecto+'" data-lp="'+ data.lugar_prospeccion +'" data-nombreProspecto="'+data.nomCliente+' '+data.apellido_paterno+' '+data.apellido_materno+'"><i class="fas fa-user-check"></i></a>';
                                }
                                else
                                {
                                    if(id_rol_general == 7 || id_rol_general == 9 || id_rol_general == 3){
                                    if(data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92 || data.idMovimiento == 96 && (id_rol_current==7 || id_rol_current==9 || id_rol_current==3) ){
                                        if(data.tipo_doc == 66){
                                            file = '<a class="verEVMKTD" data-expediente="'+data.expediente+'" data-toggle="tooltip" data-placement="top" title= "VER ARCHIVO" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><img src= general_base_url + "static/images/image-file.png" style="cursor:pointer;width:42px"/></a>';
                                        }else{
                                            file = '<a class="pdfLink" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><img src= general_base_url + "static/documentos/cliente/expediente/'+data.expediente+'" style="cursor:pointer;" width="25" height="23"/></a><button type="button" data-toggle="tooltip" data-placement="top" title= "ELIMINAR ARCHIVO" id="deleteDoc" class="btn-data btn-warning delete" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></button>';
                                        }
                                    } else {
                                        if(data.tipo_doc == 66){
                                            file = '<a class="verEVMKTD" data-expediente="'+data.expediente+'" data-toggle="tooltip" data-placement="top" title= "VER ARCHIVO" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><img src= general_base_url + "static/images/image-file.png" style="cursor:pointer;width:42px"/></a>';
                                        }else{
                                            file = '<a class="pdfLink" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><img src= general_base_url"static/documentos/cliente/expediente/'+data.expediente+'" style="cursor:pointer;" width="25" height="23"/></a>';
                                        }
                                    }
                                    } else {
                                    if(data.tipo_doc == 66){
                                        file = '<a class="verEVMKTD" data-expediente="'+data.expediente+'" data-toggle="tooltip" data-placement="top" title= "VER ARCHIVO" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><img src= general_base_url + "static/images/image-file.png" style="cursor:pointer;width:42px"/></a>';
                                    }else{
                                        file = '<a class="pdfLink btn-data btn-acidGreen" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-image"></i></a>';
                                    }
                                }
                            }
                                return '<div class="d-flex justify-center">'+file+'</div>';
                            }
                        },
                        {
                            data: null,
                            render: function ( data, type, row )
                            {
                                return myFunctions.validateEmptyFieldDocs(data.primerNom) +' '+myFunctions.validateEmptyFieldDocs(data.apellidoPa)+' '+myFunctions.validateEmptyFieldDocs(data.apellidoMa);
                            },
                        },
                        {data: 'ubic'},
                    ]
            });
        }
    });

    $('#tableDoct').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
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
        content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="'+ general_base_url +'static/documentos/cliente/expediente/'+$itself.attr('data-Pdf')+'"></iframe></div>',
        player:     "html",
        title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
        width:      985,
        height:     660
    });
});

$(document).on('click', '.pdfLink2', function () {
    var $itself = $(this);
    Shadowbox.open({
        content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="'+ general_base_url + 'asesor/deposito_seriedad/'+$itself.attr('data-idc')+'/1/"></iframe></div>',
        player:     "html",
        title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
        width:      1600,
        height:     900
    });
});

$(document).on('click', '.pdfLink22', function () {
    var $itself = $(this);
    Shadowbox.open({
        content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="'+ general_base_url +'asesor/deposito_seriedad_ds/'+$itself.attr('data-idc')+'/1/"></iframe></div>',
        player:     "html",
        title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
        width:      1600,
        height:     900
    });
});

$(document).on('click', '.pdfLink3', function () {
    var $itself = $(this);
    Shadowbox.open({
        content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="'+ general_base_url +'static/documentos/cliente/contrato/'+$itself.attr('data-Pdf')+'"></iframe></div>',
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
        content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="'+ general_base_url +'clientes/'+functionName+'/'+$itself.attr('data-id-prospeccion')+'"></iframe></div>',
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
        cntShow = '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="'+ general_base_url +'static/documentos/evidencia_mktd/'+$itself.attr('data-expediente')+'" allowfullscreen></iframe></div>';
    }else{
        cntShow = '<div><img src="'+ general_base_url +'static/documentos/evidencia_mktd/'+$itself.attr('data-expediente')+'" class="img-responsive"></div>';
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
    $.post( general_base_url + "index.php/registroLote/get_auts_by_lote/"+idLote, function( data ) {
        $('#auts-loads').empty();
        var statusProceso;
        $.each(JSON.parse(data), function(i, item) {
            if(item['estatus'] == 0)
            {
                statusProceso="<small class='label bg-green'>ACEPTADA</small>";
            }
            else if(item['estatus'] == 1)
            {
                statusProceso="<small class='label bg-orange'>En proceso</small>";
            }
            else if(item['estatus'] == 2)
            {
                statusProceso="<small class='label bg-red'>DENEGADA</small>";
            }
            else if(item['estatus'] == 3)
            {
                statusProceso="<small class='label bg-blue'>En DC</small>";
            }
            else
            {
                statusProceso="<small class='label bg-gray'>N/A</small>";
            }
            $('#auts-loads').append('<h4>Solicitud de autorización:  '+statusProceso+'</h4><br>');
            $('#auts-loads').append('<h4>Autoriza: '+item['nombreAUT']+'</h4><br>');
            $('#auts-loads').append('<p style="text-align: justify;"><i>'+item['autorizacion']+'</i></p>' +'<br><hr>');
        });
        $('#verAutorizacionesAsesor').modal('show');
    });
});
