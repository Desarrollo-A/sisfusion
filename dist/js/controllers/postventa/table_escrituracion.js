$('#prospects-datatable thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    $(this).html('<input class="textoshead"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {
        if ($('#prospects-datatable').DataTable().column(i).search() !== this.value ) {
            $('#prospects-datatable').DataTable().column(i).search(this.value).draw();
        }
    });
});

sp = { // MJ: SELECT PICKER
    initFormExtendedDatetimepickers: function () {
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
                inline: true
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
 

//funciones
function fillTable(beginDate, endDate, estatus) {

    prospectsTable = $('#prospects-datatable').DataTable({
        dom: 'rt' + "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: "auto",
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
                    return d.nombreCondominio
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
                    //return d.tipo == 1 || d.tipo == 3 ? d.comentarios : d.tipo == 2 || d.tipo == 4? d.motivos_rechazo : d.tipo == 5 ? '':'';
                    return '';
                }
            },
            {
                data: function (d) {
                    return `<center><span><b> ${d.clave}</b> - ${d.actividad}</span><center>`;   
                }
            },
            {
                data: function (d) {
                    
                    return `
                           
                            <center><span><b> ${d.clave}</b> - ${d.actividad}</span><center>`;   
                }
            },
            {
                data: function (d) {
                    $('[data-toggle="tooltip"]').tooltip();
                    var botones = '';
                    // return '<center>' + group_buttons + '<center>';
                    if (userType == 57) {
                        botones = `<center> <button id="revisarDocs" name="revisarDocs" data-type="5" class="btn-data btn-green revisarDocs " data-toggle="tooltip" data-info="${d.idEstatus}" data-solicitud='${d.id_solicitud}' data-placement="top" title="documentos"><i class="far fa-paper-plane"></i></button><center>
                                `;
               
                        }else{
                        botones = `<center> <button id="subirDocumentos" name="subirDocumentos" data-type="5" class="btn-data btn-green subirDocumentos " data-toggle="tooltip" data-info="${d.idEstatus}" data-solicitud='${d.id_solicitud}' data-placement="top" title="documentos"><i class="far fa-paper-plane"></i></button><center>
                            <center> <button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="top" title="Rechazar"><i class="fas fa-ban"></i></button>               <center>
                            <center> <button id="request" data-type="5" class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Aprobar"><i class="fa fa-share"></i></button> <center>`;
                        }
                    
                    return botones ;
                    
                    }
            }
        ],
        columnDefs: [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        },
        // {
        //     "targets": [ 10 ],
        //     "visible": false
        // }
        ],
        ajax: {
            url: 'getSolicitudes',
            type: "POST",
            cache: false,
            data: {
                "beginDate": beginDate,
                "endDate": endDate,
                "estatus":estatus
            }
        }

    });
};
 
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

    fillTable(finalBeginDate, finalEndDate, $('#estatusE').val());
}

function getEstatusEscrituracion(){
    $('#spiner-loader').removeClass('hide');
    $("#estatusE").find("option").remove();
    $("#estatusE").append($('<option selected>').val("0").text("Propios"));
    $("#estatusE").append($('<option>').val("1").text("Todos"));
    $("#estatusE").selectpicker('refresh');
    $('#spiner-loader').addClass('hide');
 
}

$(document).on('click', '#request', function () {
    var data = prospectsTable.row($(this).parents('tr')).data();
    $("#approveModal").html();
    $('#id_solicitud').val(data.id_solicitud);
    $('#estatus_siguiente').val(data.id_estatus);
    $('#observaciones').val('');
    $('#tipo').val('');
    // let type = $(this).attr('data-type');
    //BOTON PARA REQUEST DEL BOTON APROBAR
    // $('#type').val(type);
    $("#approveModal .modal-header").append(`<h4 class="modal-title card-title"><b>Comentarios adicionales: </b>CS2GTO-CIRH-005</h4>`);
    $("#approveModal").modal();
});

$(document).on('submit', '#approveForm', function (e) {
    e.preventDefault();
    let id_solicitud = $('#id_solicitud').val();
    let observations = $('#observations').val();
    let id_estatus = $('#status').val();
    let type = $('#type').val();
    
    changeStatus(id_solicitud, 1, observations, type);
})

 
 
 
// $(document).on('click', '#descargarDoc', function () {
//     alert('aaaaaaaaaaaaaaaaaaaaaaaaaaa');
//     index = $(this).attr("data-index");
//     ipOcion = $(this).attr("data-idOpcion");
//     expediente = $(this).attr("data_expediente");

//      ruta = folder (ipOcion);
//      $.ajax({
//         url : 'descargarDocs',
//         type : 'POST',
//         dataType: "json",
//         data: 
//         {
//             // "pagos_activos"     : pagos_activos,
//             "name" : expediente,
//             "documentType" : ipOcion
//         }, 
//         success: function(data) {
           
            
        
//         },
//         error: function() {
//            console.log("Error");
//         }
//     });
// });
$(document).on('click', '#visualizarDoc', function () {
 
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
            console.log(data);
          
            if(estatus == 1 ){  
                estatusVal = 'Estatus actual VALIDADO';
            }else if(estatus == 2){
                estatusVal = 'Estatus actual DENEGADO';
            }else{
                estatusVal = 'Estatus actual ESPERA';
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
                url : 'getDocumentosPorSolicitud',
                type : 'POST',
                dataType: "json",
                data: 
                {
                    // "pagos_activos"     : pagos_activos,
                    "estatus" : estatus,
                    "solicitud" : solicitud
                }, 
                success: function(data) {
                    
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
                                estatusVal = 'Estatus actual ESPERA';
                            }
    
                        InfoModal += '  <div class="col-6 col-sm-6 col-md-6 col-lg-6 ">';
                        InfoModal += '      <p style="font-size: 1em: color: #E92017;"> DOCUMENTO '+Losmios.nombre+' </p>';
                        InfoModal += '      <p id="estatusValidacion'+Numero+'" name="estatusValidacion'+Numero+'" style="font-size: 0.9em;"> Estatus actual '+estatusVal+' </p>';

                        InfoModal += '      <hr style="color: #0056b2;" />';
                        InfoModal += '  </div>';
    
                        InfoModal += '  <div class="col-5 col-  sm-5 col-md-5 col-lg-5 ">';
                        InfoModal += '  <div name="cambioBajar'+Numero+'" id="cambioBajar'+Numero+'" >';
                        InfoModal += '   <div class="col-2 col-sm-2 col-md-2 col-lg-2 ">';
                                                
                        InfoModal += '   <a href="'+base_url + ruta + Losmios.expediente+'" download="descargarDoc" id="descargarDoc"  name="descargarDoc" data_expediente="'+Losmios.expediente+'" data-index="'+Numero+'"  data-idDocumento="'+Losmios.idDocumento +'" data-idSolicitud="'+Losmios.idSolicitud +'" data-idOpcion="'+Losmios.id_opcion +'"' +
                        'data-idCliente="" data-fecVen="" data-ubic="" data-code=""  ' +
                        'class="btn-data btn-sky cancelReg" title="Visualizar">' +
                        '<i class="fas fa-download"></i></a>'; 
                        InfoModal += '  </div>';
                     
                        InfoModal += ' <div class="col-2 col-sm-2 col-md-2 col-lg-2">';
                        InfoModal += '<a href="'+base_url + ruta + Losmios.expediente+'" target="_blank"  id="verDoc"  name="verDoc" data_expediente="'+Losmios.expediente+'"   data-index="'+Numero+'" data-idDocumento="'+Losmios.idDocumento +'" data-idSolicitud="'+Losmios.idSolicitud +'" data-idOpcion="'+Losmios.id_opcion +'"' +
                        'data-idCliente="" data-fecVen="" data-ubic="" data-code=""  ' +
                        'class="btn-data btn-orangeYellow cancelReg" title="Descargar">' +
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
                             InfoModal += '<button href="#" id="visualizarDoc" name="visualizarDoc"  data-editar="2" data-index="'+Numero+'" data-idDocumento="'+Losmios.idDocumento +'" data-idSolicitud="'+Losmios.idSolicitud +'" data-idOpcion="'+Losmios.id_opcion +'"' +
                           'data-idCliente="" data-fecVen="" data-ubic="" data-code=""  ' +
                           'class="btn-data btn-warning  cancelReg" title="Rechazar">' +
                           '<i class="fas fa-thumbs-down"></i></button>'; 
                            InfoModal += ' </div>';
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


$(document).on('click', '#subirDocumentos', function () {
    idStatus = $(this).attr("data-info");
    solicitudes = $(this).attr("data-solicitud");
    let solicitud = solicitudes ;
    let estatus = idStatus;
  
    // data-info
    var documentos  = '';
    documentos += '';
    var cuerpoModal = document.getElementById('subir_documento');
    cuerpoModal.innerHTML = documentos;
    let banderaTengoDocumentos = false;

    $("#documentTree").modal();
    $.ajax({
        url : 'getDocumentosPorSolicitud',
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

            if(data.length  != 0){
                data.losDocumentos.forEach(function(elemento,i){
                    // console.log(data.misDocumentos.length);
                    data.misDocumentos.forEach(function(elementos,e){
                        if( data.losDocumentos[i].id_opcion == data.misDocumentos[e].id_opcion )
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
            

            if(banderaTengoDocumentos){

                InfoModal += '  <div class="col-12 col-sm-12 col-md-12 col-lg-12 ">';
                InfoModal += '     <p style="font-size: 0.8em: color: #E92017;">Documentos faltantes por subir</p>';
                InfoModal += '  <hr style="color: #0056b2;" />';
                InfoModal += '  </div>';

            } 
            if(data.length  != 0){
                data.losDocumentos.forEach(function(faltantes,inde ){
                
                    if(data.losDocumentos[inde] != "")
                    {
                      
                        InfoModal += '  <div class="col-12 col-sm-12 col-md-12 col-lg-12 ">';
         
                        InfoModal += '  </div>';
    

                        InfoModal += '  <div class="col-6 col-sm-6 col-md-6 col-lg-6 "> ' ;
                        InfoModal += '      <p style="font-size: 0.8em: color: #E92017;"> DOCUMENT0 :'+faltantes.nombre +' </p>';
                        InfoModal += '      <p style="font-size: 0.5em: color: #E92017;"> Estatus actual Espera </p>';
                        InfoModal += '      <hr style="color: #0056b2;" />';
                        InfoModal += '   <br> '
                        InfoModal += '  </div>';
    
    
                        InfoModal += '  <div class="col-5 col-sm-5 col-md-5 col-lg-5 ">';
                        InfoModal += '  <div name="cambioAlsubir'+inde+'" id="cambioAlsubir'+inde+'" >';
                        InfoModal += '      <input hidden name="numeroDeRow" id="numeroDeRow">';
                        InfoModal += '      <div class="file">';
                        InfoModal += '           <input class="form-control input-gral" id="docSubir'+inde+'" name="docSubir'+inde+'"  type="file" >';
                        InfoModal += '      </div>';
                        InfoModal += '  </div>';
                        InfoModal += '  </div>';
                        
                     

                        InfoModal += '  <div class="col-1 col-sm-1 col-md-1 col-lg-1 ">';
                        InfoModal += '  <div name="cambioAlsubir1'+inde+'" id="cambioAlsubir1'+inde+'" >';
                        InfoModal += '	<button id="guardarImagen" name="guardarImagen"  ' +
                                        'class="btn-data btn-green editReg" title="ACTUALIZAR" data-cambiada="1" data-index="'+inde+'" data-solicitud="'+solicitud+'" data-documento="'+faltantes.id_opcion +'" data-nomLote="2" data-idCond="">'+
                                        '<i class="fas fa-upload"></i></button>';
                        InfoModal += '  </div>';                
                        InfoModal += '	</div>';
    
                    }
                });  
                let estatusVal = 0;
                let estatusVariable = '' ;
                let bandera = 0 ;
                data.misDocumentos.forEach(function(Losmios,Numero ){
                    ruta =   folders(Losmios.id_opcion);
                 
                    InfoModal += '  <div class="col-12 col-sm-12 col-md-12 col-lg-12 ">';
                    InfoModal += '   <br> '
                    InfoModal += '  </div>';
                     
                        if(Losmios.validacion == 1 ){
                            bandera = true;
                            estatusVal = 'VALIDADO';
                            estatusVariable = ' <p style="font-size: 0.7em; color: #28B463;"> Estatus actual '+estatusVal +' </p>';
                        }else if(Losmios.validacion == 2){
                            bandera = false;
                            estatusVal = 'DENEGADO';
                            estatusVariable = ' <p style="font-size: 0.7em; color: #E92017;"> Estatus actual '+estatusVal +' </p>';
                        }else{
                            bandera = false;
                            estatusVal = 'ESPERA';
                            estatusVariable = ' <p style="font-size: 0.7em; "> Estatus actual '+estatusVal +' </p>';
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
                            'data-idCliente="" data-fecVen="" data-ubic="" data-code=""  ' +
                            'class="btn-data btn-warning cancelReg" title="BORRAR">' +
                            '<i class="fas fa-trash-alt"></i></a>'; 
                            InfoModal += '  </div>';
                        }
                      

                        InfoModal += ' <div class="col-2 col-sm-2 col-md-2 col-lg-2 ">';
                        InfoModal += '<button href="'+base_url + ruta + Losmios.expediente+'" target="_blank" id="visualizarDoc" name="visualizarDoc" data-index="'+Numero+'" data-idDocumento="'+Losmios.idDocumento +'" data-idSolicitud="'+Losmios.idSolicitud +'" data-idOpcion="'+Losmios.id_opcion +'"' +
                        'data-idCliente="" data-fecVen="" data-ubic="" data-code=""  ' +
                        'class="btn-data btn-violetBoots cancelReg" title="Visualizar">' +
                        '<i class="fas fa-scroll"></i></button>'; 
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
       
            documento       = $(this).attr("data-idDocumento");
            solicitudId     = $(this).attr("data-idSolicitud");
            idOpcion        = $(this).attr("data-idOpcion");
            inde            = $(this).attr("data-index"); 
            seCambio        = $(this).attr("data-cambiada"); 
            primerIndex     = $(this).attr("data-primer"); 
            let  validarCambioEnMismoModal = 0;
        

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
            let  validarCambioEnMismoModal =  "1";
            // pago_mensual = $(this).attr("data-mensual");
            // descuento = $(this).attr("data-descuento");
            if(seCambio == 1 ){

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
                	url: 'UParchivosFroms',
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
                        document.getElementById('cambioAlsubir1'+indexData).innerHTML = infoBotonesWhenSubio;


                        PasarNuevaIno = '';
                        
                        PasarNuevaIno1 = '';
                        
                    PasarNuevaIno += '   <div class="col-3 col-sm-3 col-md-3 col-lg-3 ">';
                    PasarNuevaIno += '<button data-idLote="1" data-cambiada='+validarCambioEnMismoModal+' data-nomLote="2" data-idCond="" id="borrarDoc" name="borrarDoc"' +
                    ' data-idDocumento="'+data.ultimoInsert +'"  data-index="'+indexData+'" data-primer="'+indexData+'" data data-idSolicitud="'+solicitudId +'" data-idOpcion="'+iddocumento +'"  ' +
                    'class="btn-data btn-warning cancelReg" title="BORRAR">' +
                    '<i class="fas fa-trash-alt"></i></button>'; 
                    PasarNuevaIno += '  </div>';

                    PasarNuevaIno += ' <div class="col-2 col-sm-2 col-md-2 col-lg-2 ">';
                    PasarNuevaIno += '<button  id="visualizarDoc" name="visualizarDoc" ' +
                    ' data-idDocumento="'+data.ultimoInsert +'" data-cambiada='+validarCambioEnMismoModal+' data-primer="'+indexData+'" data-idSolicitud="'+solicitudId +'" data-idOpcion="'+iddocumento+'"' +
                    'class="btn-data btn-violetBoots cancelReg" title="Visualizar">' +
                    '<i class="fas fa-scroll"></i></button>'; 
                    PasarNuevaIno += '  </div>';
                    document.getElementById('cambioAlsubir'+indexData).innerHTML = PasarNuevaIno;
                

                	},
                	error: function(){
                		alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                	}
                });
            }
          

            });








        function folders (documentType){

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
                    folder = "static/documentos/postventa/escrituracion/ESTATUS_CONSTRUCCION/";
                    break;
                case 13:
                    folder = "static/documentos/postventa/escrituracion/PRESUPUESTO/";
                    break;
                case 14:
                    folder = "static/documentos/postventa/escrituracion/PROYECTO/";
                    break;
                case 15:
                    folder = "static/documentos/postventa/escrituracion/FACTURA/";
                    break;
                case 16:
                    folder = "static/documentos/postventa/escrituracion/TESTIMONIO/";
                    break;
                case 17:
                    folder = "static/documentos/postventa/escrituracion/PROYECTO_ESCRITURA/";
                    break;
                case 18:
                    folder = "static/documentos/postventa/escrituracion/RFC_MORAL/";
                    break;
                case 19:
                    folder = "static/documentos/postventa/escrituracion/ACTA_CONSTITUTIVA/";
                    break;
                case 20:
                    folder = "static/documentos/postventa/escrituracion/OTROS/";
                    break;
                case 21:
                    folder = "static/documentos/postventa/escrituracion/CONTRATO/";
                    break;
                case 22:
                    folder = "static/documentos/postventa/escrituracion/COPIA_CERTIFICADA/";
                    break;
                case 23:
                    folder = "static/documentos/postventa/escrituracion/PRESUPUESTO_NOTARIA_EXTERNA/";
                    break; 
            }
            return folder ;
        } 


            
