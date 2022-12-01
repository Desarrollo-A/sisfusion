$('#prospects-datatable thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    $(this).html('<input class="textoshead"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {
        if ($('#prospects-datatable').DataTable().column(i).search() !== this.value ) {
            $('#prospects-datatable').DataTable().column(i).search(this.value).draw();
        }
    });
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
                    return d.idSolicitud
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
                    return d.nombre;
                }
            },
            {
                data: function (d) {
                    return d.fecha_creacion;
                }
            },
            {
                data: function (d) {
                    return d.tipo == 1 || d.tipo == 3 ? d.comentarios : d.tipo == 2 || d.tipo == 4? d.motivos_rechazo : d.tipo == 5 ? '':'';
                }
            },
            {
                data: function (d) {
                    return `<center><span><b>${d.idEstatus == 91 ? '1/2':d.idEstatus == 92 ? 3:d.idEstatus} - ${d.estatus}</b></span><center>`;   
                    // <center><span>(${d.area})</span><center></center>
                }
            },
            {
                data: function (d) {
                    return 'botones';
                }
            },
            {
                data: function (d) {
                    return d.idEstatus;   
                }
            }
        ],
        columnDefs: [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        },
        {
            "targets": [ 9 ],
            "visible": false
        }
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

    fillTable(finalBeginDate, finalEndDate, $('#estatusE').val());
}
  
 
function permisos(permiso, expediente, idDocumento, tipo_documento, idSolicitud, aditional, newBtn) {
    let botones = '';
    switch (permiso) {
        case 0:
            botones += ``;
            break;
        case 1: //escritura
            if (expediente == null || expediente == '' || expediente == 'null') {
                if (aditional == 2) {
                    //modal paso 22
                    botones += `<button data-idDocumento="${idDocumento}" data-documentType="${tipo_documento}" data-idSolicitud=${idSolicitud} data-action=${expediente == null || expediente == '' ? 1 : 2} class="btn-data ${expediente == null || expediente == '' ? "btn-sky" : "btn-gray"} upload" data-toggle="tooltip" data-placement="top" title=${expediente == null || expediente == '' ? 'Cargar' : 'Eliminar'}>${expediente == null || expediente == '' ? '<i class="fas fa-cloud-upload-alt"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
                } else {
                    botones += `<button data-idDocumento="${idDocumento}" data-documentType="${tipo_documento}" data-idSolicitud=${idSolicitud} data-action=${expediente == null || expediente == '' ? 1 : 2} class="btn-data ${expediente == null || expediente == '' ? "btn-sky" : "btn-gray"} upload" data-toggle="tooltip" data-placement="top" title=${expediente == null || expediente == '' ? 'Cargar' : 'Eliminar'}>${expediente == null || expediente == '' ? '<i class="fas fa-cloud-upload-alt"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
                    botones += newBtn;
                }
            } else {
                if (aditional == 2) {
                    botones += `<button data-idDocumento="${idDocumento}" data-documentType="${tipo_documento}" data-idSolicitud=${idSolicitud} data-action=${expediente == null || expediente == '' ? 1 : 2} class="btn-data ${expediente == null || expediente == '' ? "btn-sky" : "btn-gray"} upload" data-toggle="tooltip" data-placement="top" title=${expediente == null || expediente == '' ? 'Cargar' : 'Eliminar'}>${expediente == null || expediente == '' ? '<i class="fas fa-cloud-upload-alt"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
                } else {
                    botones += `<button data-idDocumento="${idDocumento}" data-documentType="${tipo_documento}" data-idSolicitud=${idSolicitud} data-action=${expediente == null || expediente == '' ? 1 : 2} class="btn-data ${expediente == null || expediente == '' ? "btn-sky" : "btn-gray"} upload" data-toggle="tooltip" data-placement="top" title=${expediente == null || expediente == '' ? 'Cargar' : 'Eliminar'}>${expediente == null || expediente == '' ? '<i class="fas fa-cloud-upload-alt"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
                    botones += newBtn;
                }
                //VISTA PREVIA DOCUEMENTOS
                botones += `<button id="preview" data-doc="${expediente}" data-documentType="${tipo_documento}" class="btn-data btn-details-grey" data-toggle="tooltip" data-placement="top" title="Vista previa"><i class="fas fa-eye"></i></button>`;
                //SI YA SE CARGO LA COPIA CERTIFICADA AGREGAR BOTON PARA CARGAR OTRO ARCHIVO Y BLOQUEAR LA ACCIÓN DE ENVIAR
                //botones += `<button data-idDocumento="${idDocumento}" data-documentType="${tipo_documento}" data-idSolicitud=${idSolicitud} data-action="1" class="btn-data btn-sky upload" data-toggle="tooltip" data-placement="top" title="Cargar"><i class="far fa-trash-alt"></i></button>`;
                botones += '<button id="request" class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Enviar"><i class="far fa-paper-plane"></i></button>';
            }
            break;
        case 2: //lectura
            if (aditional == 1) {
                botones += newBtn;
            }
            if (expediente != 1) {
                botones += `<button id="preview" data-doc="${expediente}" data-documentType="${tipo_documento}" class="btn-data btn-details-grey" data-toggle="tooltip" data-placement="top" title="Vista previa"><i class="fas fa-eye"></i></button>`;
            }
            break;
        case 3: //especial
            if (expediente == null || expediente == '' || expediente == 'null') {
                if (aditional == 1) {
                    botones += newBtn;
                }
            } else {
                if (aditional == 1) {
                    botones += newBtn;
                }
                if (expediente != 1) {
                    botones += `<button id="preview" data-doc="${expediente}" data-documentType="${tipo_documento}" class="btn-data btn-details-grey" data-toggle="tooltip" data-placement="top" title="Vista previa"><i class="fas fa-eye"></i></button>`;
                    botones += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="top" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                }
                botones += '<button id="request" class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Enviar"><i class="far fa-paper-plane"></i></button>';

            }
            break;
        case 4: //especial
            if (aditional == 1) {
                botones += newBtn;
            }
            if (expediente == 2) {// 2 CUANDO NINGÚN DOCUMENTO TENGA MOTIVOS DE RECHAZO
                botones += '<button id="request" class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Enviar"><i class="far fa-paper-plane"></i></button>';
            }
            break;
    }
    return '<div class="d-flex justify-center">'+botones+'</div>';
}
 
 
 