var rolesPermitidos = [7, 9, 42, 3, 2, 6, 5, 15, 13, 17, 32, 70]
var movimientosPermitidos = [36, 6, 23, 76, 83, 95, 97, 35, 22, 62, 75, 94, 106, 37, 7, 64, 66, 77, 41, 31, 85, 20, 63, 73, 82, 92, 96]
Shadowbox.init();


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
    console.log('karma mi perro', $(this));
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
    console.log('fileselect', [numFiles, label]);
});
$(document).ready (function() {
    $('#filtro3').change(function(){
        var valorSeleccionado = $(this).val();
        //build select condominios
        $("#filtro4").empty().selectpicker('refresh');
        $.ajax({
            url: '<?=base_url()?>registroCliente/getCondominios/'+valorSeleccionado,
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
    <?php
            $metodoToExc = 'getLotesAsesor';
            ?>
        $.ajax({
            url: '<?=base_url()?>registroCliente/<?php echo $metodoToExc;?>/'+valorSeleccionado+'/'+residencial,
            type: 'post',
            dataType: 'json',
            success:function(response){
                var len = response.length;
                for( var i = 0; i<len; i++){
                    var datos = response[i]['idLote']+','+response[i]['venta_compartida'];
                    var name = response[i]['nombreLote'];
                    $("#filtro5").append($('<option>').val(datos).text(name));
                }
                $("#filtro5").selectpicker('refresh');

            },
        });
    });

    let titulos = [];
    $('#tableDoct thead tr:eq(0) th').each( function (i) {
        if( i!=0 && i!=13){
            var title = $(this).text();
            titulos.push(title);
        }
    });

    $('#filtro5').change(function(){
        var seleccion = $(this).val();
        let datos = seleccion.split(',');
        let valorSeleccionado=datos[0];
        let ventaC = datos[1];
        let titulos_intxt = [];
        $('#tableDoct thead tr:eq(0) th').each( function (i) {
            $(this).css('text-align', 'center');
            var title = $(this).text();
            titulos_intxt.push(title);
            $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
            $( 'input', this ).on('keyup change', function () {
                if ($('#tableDoct').DataTable().column(i).search() !== this.value ) {
                    $('#tableDoct').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        $('#tableDoct').DataTable({
            destroy: true,
            ajax:
                {
                    "url": '<?=base_url()?>index.php/registroCliente/expedientesWS/'+valorSeleccionado,
                    "dataSrc": ""
                },
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            width: "auto",
            "ordering": false,
            "buttons": [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'DOCUMENTACION_LOTE',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3,4,5, 6, 8, 9 ],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'PROYECTO';
                                        break;
                                    case 1:
                                        return 'CONDOMINIO';
                                        break;
                                    case 2:
                                        return 'ID LOTE';
                                        break;
                                    case 3:
                                        return 'LOTE';
                                        break;
                                    case 4:
                                        return 'CLIENTE';
                                        break;
                                    case 5:
                                        return 'COORDINADOR';
                                        break;
                                    case 6:
                                        return 'GERENTE';
                                        break;
                                    case 7:
                                        return 'SUBDIRECTOR';
                                        break;
                                    case 8:
                                        return 'REGIONAL';
                                        break;
                                    case 9:
                                        return 'NOMBRE DE DOCUMENTO';
                                        break;
                                    case 10:
                                        return 'HORA/FECHA';
                                        break;
                                    case 12:
                                        return 'RESPONSABLE';
                                        break;
                                    case 13:
                                        return 'UBICACIÓN';
                                        break;
                                }
                            }
                        }
                    },
                }
            ],
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            "columns":
                [

                    {data: 'nombreResidencial'},
                    {data: 'nombre'},
                    {data: 'idLote'},
                    {data: 'nombreLote'},
                    {
                        data: null,
                        render: function ( data, type, row )
                        {
                            return data.nomCliente +' ' +data.apellido_paterno+' '+data.apellido_materno;
                        },
                    },
                    {
                        data: null,
                        render: function( data, type, row )
                        {
                            return (data.coordinador == '  ' ? 'No aplica' : data.coordinador);
                        }
                    },
                    {
                        data: null,
                        render: function( data, type, row )
                        {
                            return (data.gerente == '  ' ? 'No aplica' : data.gerente);
                        }
                    },
                    {
                        data: null,
                        render: function( data, type, row )
                        {
                            return (data.subdirector == '  ' ? 'No aplica' : data.subdirector);
                        }
                    },
                    {
                        data: null,
                        render: function( data, type, row )
                        {
                            return (data.regional == '  ' ? 'No aplica' : data.regional);
                        }
                    },
                    {data: 'movimiento'},
                    {data: 'modificado'},
                    {
                        data: null,
                        render: function ( data, type, row ){
                            // if(data.flag_compartida == 1){
                            var disabled_option = myFunctions.revisaObservacionUrgente(data.observacionContratoUrgente);
                            datos = data.id_asesor;
                            // ES ODF
                            if (getFileExtension(data.expediente) == "pdf") {
                                if(data.tipo_doc == 8){ // CONTRATO
                                    file = '<a class="pdfLink3 btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a>';
                                }else if(data.tipo_doc == 66){ // EVIDENCIA MKTD
                                    file = '<a class="verEVMKTD btn-data btn-warning" data-expediente="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><i class="fas fa-file-pdf"></i></a>';
                                } else if(data.tipo_doc == 30){
                                    file = '<center><a class="pdfLinkContratoFirmado btn-data btn-warning" '+disabled_option+' data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><i class="fas fa-file-pdf"></i></a>';
                                    if(id_rol_general ==73 || id_rol_general==70 || id_rol_general==17){
                                        file += '  | <button type="button" title= "Eliminar archivo" id="deleteDoc" class=" btn-data btn-warning delete" data-tipodoc="'+data.movimiento+'" data-tipoId="'+data.tipo_doc+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></button></center>';
                                    }
                                }
                                else if(data.tipo_doc == 31){
                                    file = '<center><a class="pdfAutFI btn-data btn-warning" '+disabled_option+' data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><i class="fas fa-file-pdf"></i></a>';
                                    if(id_rol_general == 7){
                                        file += '  | <button type="button" title= "Eliminar archivo" id="deleteDoc" class=" btn-data btn-warning delete" data-tipodoc="'+data.movimiento+'" data-tipoId="'+data.tipo_doc+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></button></center>';
                                    }
                                }
                                else {
                                    // EVALÚA CON EL ROL Y ESTATUS
                                <?php if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3 || $this->session->userdata('id_rol') == 2 /*&& $this->session->userdata('id_usuario') == $this->session->userdata('datauserjava')*/){?>
                                        if((data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92 || data.idMovimiento == 96) && (id_rol_current==7 || id_rol_current==9 || id_rol_current==3 || id_rol_current==2) && (ventaC == 1) ){
                                            file = '<a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo jajaja" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a><button type="button" title= "Eliminar archivo" id="deleteDoc" class="btn-data btn-warning delete" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></button>';
                                        } else {
                                            file = '<a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo pppp" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a>';
                                        }
                                    <?php } else {?>
                                        file = '<a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo jijijij" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a>';
                                    <?php
                                        if($this->session->userdata('id_rol') == 6){?>
                                            file += '  <button type="button" title= "Eliminar archivo" id="deleteDoc" class="btn-data btn-warning delete" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></button>';
                                        <?php
                                        }
                                            ?>


                                    <?php } ?>
                                }
                            }
                            // NO ES ODF, ES EXEL. HABILITA OPCIÓN PARA DESCARGA
                            else if (getFileExtension(data.expediente) == "xlsx" || getFileExtension(data.expediente) == "XLSX") {
                                file = "<a href='../../static/documentos/cliente/corrida/" + data.expediente + "' class='btn-data btn-green-excel'><i class='fas fa-file-excel'></i><src='../../static/documentos/cliente/corrida/" + data.expediente + "'> </a>";
                            }
                            // EVALUA SI ESTÁ VACÍO
                            else if (getFileExtension(data.expediente) == "NULL" || getFileExtension(data.expediente) == 'null' || getFileExtension(data.expediente) == "") {
                                if(data.tipo_doc == 7) { // MUESTRA ICONO DISABLED PARA CORRIDA CUANDO NO ESTÉ LLENO
                                    file = '<button type="button" title= "Corrida inhabilitada" class="btn-data btn-warning disabled" disabled><i class="fas fa-file-excel"></i></button>';
                                } else if(data.tipo_doc == 8){  // MUESTRA ICONO DISABLED PARA CONTRATO CUANDO NO ESTÉ LLENO
                                    file = '<button type="button" title= "Contrato inhabilitado" class="btn-data btn-warning disabled" disabled><i class="fas fa-file"></i></button>';
                                } else if(data.tipo_doc == 29  && (id_rol_current != 6 && id_rol_current != 5)){
                                    file = '<button type="button" title= "Carta Domicilio inhabilitado" class="btn-data btn-warning disabled" disabled><i class="fas fa-file"></i></button>';
                                }
                                else {

                                    // AVALUA SI ES ASISTENET DE GERENCIA
                                <?php if($this->session->userdata('id_rol') == 6){?>
                                        if((data.idMovimiento == 37 || data.idMovimiento == 7 || data.idMovimiento == 64 || data.idMovimiento == 66 || data.idMovimiento == 77 || data.idMovimiento == 41) && ((id_rol_current == 6 || id_rol_current == 5) && data.tipo_doc==29)){
                                            file = '<button type="button" '+disabled_option+' id="updateDoc" title= "Adjuntar archivo" class="btn-data btn-green update" data-iddoc="'+data.idDocumento+'" data-tipodoc="'+data.tipo_doc+'" data-descdoc="'+data.movimiento+'" data-idCliente="'+data.idCliente+'" data-nombreResidencial="'+data.nombreResidencial+'" data-nombreCondominio="'+data.nombre+'" data-nombreLote="'+data.nombreLote+'" data-idCondominio="'+data.idCondominio+'" data-idLote="'+data.idLote+'"><i class="fas fa-cloud-upload-alt"></i></button>';
                                        }
                                        // EVALÚA ROL
                                    <?php }elseif($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3 || $this->session->userdata('id_rol') == 2 /*&& $this->session->userdata('id_usuario') == $this->session->userdata('datauserjava')*/){?>
                                        // EVALÚA ESTATUS DEL EXPEDIENTE (QUE SEAN LOS QUE LE PERTENECEN AL ASESOR) SI CUMPLE, HABILITA BOTÓN PARA CARGA
                                        if((data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92 || data.idMovimiento == 96) && (id_rol_current==7 || id_rol_current==9 || id_rol_current==3 || id_rol_current==2) && (ventaC == 1)){
                                            file = '<button type="button" '+disabled_option+' id="updateDoc" title= "Adjuntar archivo" class="btn-data btn-green update" data-iddoc="'+data.idDocumento+'" data-tipodoc="'+data.tipo_doc+'" data-descdoc="'+data.movimiento+'" data-idCliente="'+data.idCliente+'" data-nombreResidencial="'+data.nombreResidencial+'" data-nombreCondominio="'+data.nombre+'" data-nombreLote="'+data.nombreLote+'" data-idCondominio="'+data.idCondominio+'" data-idLote="'+data.idLote+'"><i class="fas fa-cloud-upload-alt"></i></button>';
                                        } else {
                                            // SINO CUMPLE SÓLO HABILITA BOTÓN DISABLED
                                            file = '<button id="updateDoc" title= "No se permite adjuntar archivos" class="btn-data btn-green disabled" disabled><i class="fas fa-cloud-upload-alt"></i></button>';
                                        }
                                    <?php } else {?> file = '<button id="updateDoc" title= "No se permite adjuntar archivos" class="btn-data btn-green disabled" disabled><i class="fas fa-cloud-upload-alt"></i></button>'; <?php } ?>
                                }
                            }
                            // SI VIENE EL DS PINTA BOTÓN PARA CONSULTA (VERSIÓN ACTUAL)
                            else if (getFileExtension(data.expediente) == "Depósito de seriedad") {
                                file = '<a class="btn-data btn-blueMaderas pdfLink2" data-idc="'+data.id_cliente+'" data-nomExp="'+data.expediente+'" title= "Depósito de seriedad"><i class="fas fa-file"></i></a>';
                            }
                            // SI VIENE EL DS PINTA BOTÓN PARA CONSULTA (VERSIÓN VIEJA)
                            else if (getFileExtension(data.expediente) == "Depósito de seriedad versión anterior") {
                                file = '<a class="btn-data btn-blueMaderas pdfLink22" data-idc="'+data.id_cliente+'" data-nomExp="'+data.expediente+'" title= "Depósito de seriedad"><i class="fas fa-file"></i></a>';
                            }
                            // SI VIENEN AUTORIZACIONES PINTA BOTÓN PARA CONSULTA
                            else if (getFileExtension(data.expediente) == "Autorizaciones") {
                                file = '<a href="#" class="btn-data btn-blueMaderas seeAuts" title= "Autorizaciones" data-idCliente="'+data.idCliente+'" data-id_autorizacion="'+data.id_autorizacion+'" data-idLote="'+data.idLote+'"><i class="fas fa-key"></i></a>';
                            }
                            // SI VIENE PROSPECTO BOTÓN PARA CONSULTA (VERSIÓN ACTUAL)
                            else if (getFileExtension(data.expediente) == "Prospecto") {
                                file = '<a href="#" class="btn-data btn-blueMaderas verProspectos" title= "Prospección" data-id-prospeccion="'+data.id_prospecto+'" data-lp="'+data.lugar_prospeccion+'" data-nombreProspecto="'+data.nomCliente+' '+data.apellido_paterno+' '+data.apellido_materno+'"><i class="fas fa-user-check"></i></a>';
                            }
                            /*generar funcion para ver Evidencia MKTD*/
                            else
                            {
                            <?php if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3 || $this->session->userdata('id_rol') == 2 /*&& $this->session->userdata('id_usuario') == $this->session->userdata('datauserjava')*/){?>
                                if(data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92 || data.idMovimiento == 96 && (id_rol_current==7 || id_rol_current==9 || id_rol_current==3 || id_rol_current==2) ){

                                    if(data.tipo_doc == 66){
                                        file = '<a class="verEVMKTD btn-data btn-acidGreen" data-expediente="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><i class="fas fas-folder-open"></i></a>' +
                                            '';
                                    }else if(data.tipo_doc == 31){
                                        file = '<a class="autFI btn-data btn-acidGreen" data-expediente="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><i class="fas fa-image"></i></a>' +
                                            '<button type="button" title= "Eliminar archivo" id="deleteDoc" class="btn-data btn-warning delete" data-tipoId="'+data.tipo_doc+'" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></button>';
                                    }else{
                                        file = '<a class="pdfLink btn-data btn-acidGreen" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-image"></i></a><button type="button" title= "Eliminar archivo" id="deleteDoc" class="btn-data btn-warning delete" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></button>' +
                                            '';
                                    }
                                } else {

                                    if(data.tipo_doc == 66){
                                        file = '<a class="verEVMKTD btn-data btn-acidGreen" data-expediente="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><i class="fas fas-folder-open"></i></a>';
                                    }else{
                                        file = '<a class="pdfLink btn-data btn-acidGreen" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-image"></i></a>';
                                    }

                                }
                            <?php } else {?>

                                if(data.tipo_doc == 66){
                                    file = '<a class="verEVMKTD btn-data btn-acidGreen" data-expediente="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><i class="fas fa-image"></i></a>';
                                }else{
                                    file = '<a class="pdfLink btn-data btn-acidGreen" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-image"></i></a>';
                                    if(data.tipo_doc==29 && (id_rol_current == 6 || id_rol_current == 5)){
                                        if((data.idMovimiento == 37 || data.idMovimiento == 7 || data.idMovimiento == 64 || data.idMovimiento == 66 || data.idMovimiento == 77 || data.idMovimiento == 41) && ((id_rol_current == 6 || id_rol_current == 5) &&  data.tipo_doc==29)){
                                            file+= '<button type="button" title= "Eliminar archivo" id="deleteDoc" class="btn-data btn-warning delete" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></button>';
                                        }
                                    }else{
                                        file = '<a class="pdfLink btn-data btn-acidGreen" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-image"></i></a>';

                                    }

                                }

                            <?php }?>

                            }
                            return '<div class="d-flex justify-center">' + file + '</div>';
                            // }else{
                            // 	return '<span class="label label-success">Se necesita especificar si es venta compartida</span>';
                            // }
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
    <?php $this->session->unset_userdata('datauserjava'); ?>
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
$(document).on('click', '.autFI', function () {
    console.log('vámonos alv');
    var $itself = $(this);
    Shadowbox.open({
        content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute" src="<?=base_url()?>static/documentos/cliente/autFechainicio/'+$itself.attr('data-expediente')+'"></iframe></div>',
        player:     "html",
        title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
        width:      985,
        height:     660
    });
});
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
        content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>clientes/'+functionName+'/'+$itself.attr('data-id-prospeccion')+'"></iframe></div>',
        player:     "html",
        title:      "Visualizando Prospecto: " + $itself.attr('data-nombreProspecto'),
        width:      985,
        height:     660

    });
});
$(document).on('click', '.pdfLinkContratoFirmado', function () {
    var $itself = $(this);
    Shadowbox.open({
        content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute" src="<?=base_url()?>static/documentos/cliente/contratoFirmado/'+$itself.attr('data-Pdf')+'"></iframe></div>',
        player:     "html",
        title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
        width:      985,
        height:     660
    });
});
$(document).on('click', '.pdfAutFI', function () {
    var $itself = $(this);
    Shadowbox.open({
        content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute" src="<?=base_url()?>static/documentos/cliente/autFechainicio/'+$itself.attr('data-Pdf')+'"></iframe></div>',
        player:     "html",
        title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
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
    Shadowbox.open({
        content:    cntShow,
        player:     "html",
        title:      "Visualizando Evidencia MKTD: " + $itself.attr('data-nombreCliente'),
        width:      985,
        height:     660

    });
});
function checaTipo(archivo){
    archivo.split('.').pop();
    return validaFile;
}
$(document).on('click', '.seeAuts', function (e) {
    e.preventDefault();
    var $itself = $(this);
    var idLote=$itself.attr('data-idLote');
    $.post( "<?=base_url()?>index.php/registroLote/get_auts_by_lote/"+idLote, function( data ) {
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

<?php if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3 || $this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 6 || $this->session->userdata('id_rol') == 5){?>
    var miArrayAddFile = new Array(8);
    var miArrayDeleteFile = new Array(1);
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
                url: "<?=base_url()?>index.php/registroCliente/addFileAsesor",
                data: dataFile,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success : function (response) {
                    response = JSON.parse(response);
                    if(response.message == 'OK') {
                        alerts.showNotification('top', 'right', 'Expediente enviado', 'success');
                        $("#expediente").val('');
                        $('#sendFile').prop('disabled', false);
                        $('#addFile').modal('hide');
                        $('#tableDoct').DataTable().ajax.reload();
                    }
                    else if(response.message == 'OBSERVACION_CONTRATO'){
                        alerts.showNotification("top", "right", "EN PROCESO DE LIBERACIÓN. No podrás subir documentación" +
                            " hasta que el proceso de liberación haya concluido.", "danger");
                        $("#expediente").val('');
                        $('#sendFile').prop('disabled', false);
                    }
                    else if(response.message == 'ERROR'){
                        alerts.showNotification('top', 'right', 'Error al enviar expediente y/o formato no válido', 'danger');
                        $("#expediente").val('');
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
            var ti_doc= $(this).data("tipoid");

            miArrayDeleteFile[0] = iddoc;
            miArrayDeleteFile[1] = ti_doc;

            $(".tipoA").html(tipodoc);
            $('#cuestionDelete').modal('show');

        });
    });

    $(document).on('click', '#aceptoDelete', function(e) {
        e.preventDefault();
        var id = miArrayDeleteFile[0];
        var id_tipoDoc = miArrayDeleteFile[1];
        var dataDelete = new FormData();
        dataDelete.append("idDocumento", id);
        dataDelete.append("id_tipoDoc", id_tipoDoc);

        $('#aceptoDelete').prop('disabled', true);
        $.ajax({
            url: "<?=base_url()?>index.php/registroCliente/deleteFile",
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
<?php } ?>