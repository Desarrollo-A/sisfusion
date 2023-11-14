let titulos = [];
$('#historialLib thead tr:eq(0) th').each( function (i) {
    let title = $(this).text();
    titulos.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $( 'input', this ).on('keyup change', function () {
        if ($("#historialLib").DataTable().column(i).search() !== this.value) {
            $("#historialLib").DataTable().column(i).search(this.value).draw();
        }
    });
    
    $('[data-toggle="tooltip"]').tooltip();
})

$("#historialLib").ready(function () {
    $("#historialLib").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [ //BOTÓN DE DOCUMENTO EXCEL
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true" title="DESCARGAR ARCHIVO DE EXCEL"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'DESCARGAR ARCHIVO DE EXCEL',
                title: "Historial de Liberaciones",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                }
            },
        ],
        pagingType: "full_numbers",
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        
        pageLength: 11,
        fixedColumns: true,
        ordering: false,
        scrollX: true,
        columns: [ //COLUMNAS A MOSTRAR EN LA TABLA
            {
                data: function(d){
                    return d.nombreResidencial;
                }
            },
            {
                data: function(d){
                    return d.nombre;
                }
            },
            {
                data: function (d) {
                    return d.idLote.toString(); // Convertir a cadena de texto
                }
            },
            {
                data: function (d) {
                    return d.nombreLote;
                }
            },
            {
                data: function (d) {
                    return  `$${formatMoney(d.precio)}`; 
                }
            },
            {
                data: function (d) {
                    return d.idCliente == 0 || d.idCliente == null ? 'Sin Cliente' : d.nombreCliente;
                }
            },
            {
                data: function (d) {
                    return d.fecha_modificacion ? d.fecha_modificacion.split('.')[0] : 'Sin Fecha';
                }
            },
            {
                data: function (d) {
                    return d.justificacion_liberacion;
                }
            },
            {
                data: function (d) {
                    return d.estatus_proceso;
                }
            },
            {
                data: function (d) {
                    return  d.id_tipo_liberacion == 1 ? '<span class="label lbl-warning" "> Rescisión </span>' : '<span class="label lbl-green"> Devolución </span>'
                }
            },
            {
                data: function (d) {
                    btns = '<div class="d-flex justify-left">';
                    if(id_rol_general == 17)
                    {
                        /**Rol Contraloria */
                        btns += '<button type="button" class="btn-data btn-blueMaderas" data-toggle="tooltip"  data-placement="left" title="HISTORIAL" onclick="openHistorialModal('+d.idLote+')"> <i class="fas fa-history"></i></button>';
                        d.id_tipo_liberacion == 1 ?
                        btns += '<button type="button" class="btn-data btn-blueMaderas" data-toggle="tooltip"  data-placement="left" title="VER DOCUMENTO" onclick="visualizarDocumento('+d.id_hist_lib_lote+')"> <i class="fas fa-eye"></i></button>': '';
                    }

                    if(id_rol_general == 33)
                    {
                        /**Rol Administración - Yolanda*/
                        if (d.id_proceso == 1) {
                            btns +='<button type="button" class="btn-data btn-green" type="button" data-toggle="tooltip"  data-placement="left" title="APROBAR" onclick="fillModal(1, '+d.idLote+', '+d.id_tipo_liberacion+',0,0,0,0)"> <i class="fas fa-check"></i></button>'
                            btns +='<button type="button" class="btn-data btn-warning" data-toggle="tooltip"  data-placement="left" title="RECHAZAR" onclick="fillModal(2, '+d.idLote+', '+d.id_tipo_liberacion+',0,0,0,0)"> <i class="fas fa-times"></i></button>'    
                        }
                        btns += '<button type="button" class="btn-data btn-blueMaderas" data-toggle="tooltip"  data-placement="left" title="HISTORIAL" onclick="openHistorialModal('+d.idLote+')"> <i class="fas fa-history"></i></button>';
                        d.id_tipo_liberacion == 1 ?
                        btns += '<button type="button" class="btn-data btn-blueMaderas" data-toggle="tooltip"  data-placement="left" title="VER DOCUMENTO" onclick="visualizarDocumento('+d.id_hist_lib_lote+')"> <i class="fas fa-eye"></i></button>': '';
                    }

                    if(id_rol_general == 2) //93
                    {
                        /**Rol SubDirección */
                        if (d.id_proceso == 2) {
                            btns +='<button type="button" class="btn-data btn-green" data-toggle="tooltip"  data-placement="left" title="APROBAR" onclick="fillModal(1, '+d.idLote+', '+d.id_tipo_liberacion+',0,0,0,0)"> <i class="fas fa-check"></i></button>'
                            btns +='<button type="button" class="btn-data btn-warning" data-toggle="tooltip"  data-placement="left" title="RECHAZAR" onclick="fillModal(2, '+d.idLote+', '+d.id_tipo_liberacion+',0,0,0,0)"> <i class="fas fa-times"></i></button>'
                            btns += "<button class='btn-data btn-orangeYellow' data-toggle='tooltip'  data-placement='left' title='MODIFICAR PRECIO' onclick='editInfo("+d.idLote+","+ JSON.stringify(d.nombreLote)+","+d.precio+")'> <i class='fas fa-edit'></i></button>"
                        }
                        btns += '<button type="button" class="btn-data btn-blueMaderas" data-toggle="tooltip"  data-placement="left" title="HISTORIAL" onclick="openHistorialModal('+d.idLote+')"> <i class="fas fa-history"></i></button>'
                        d.id_tipo_liberacion == 1 ?
                        btns += '<button type="button" class="btn-data btn-blueMaderas" data-toggle="tooltip"  data-placement="left" title="VER DOCUMENTO" onclick="visualizarDocumento('+d.id_hist_lib_lote+')"> <i class="fas fa-eye"></i></button>': '';
                    }

                    if(id_rol_general == 12)
                    {
                         /**Rol Caja*/
                        if (d.id_proceso == 3) {
                            btns += `<button type="button" class="btn-data btn-green" data-toggle="tooltip" data-placement="left" title="APROBAR" onclick="fillModal(3,  ${d.idLote}, ${d.id_tipo_liberacion}, ${d.idCondominio}, ${d.idResidencial}, '${d.nombreLote}', ${d.precio}, ${d.tipo_lote}, '${d.clausulas}')"><i class="fas fa-check"></i></button>
                            <button type="button" class="btn-data btn-warning" data-toggle="tooltip"  data-placement="left" title="RECHAZAR" onclick="fillModal(2, ${d.idLote}, ${d.id_tipo_liberacion},0,0,0,0,0,0)"> <i class="fas fa-times"></i></button>`
                        }
                        btns += '<button type="button" class="btn-data btn-blueMaderas" data-toggle="tooltip"  data-placement="left" title="HISTORIAL" onclick="openHistorialModal('+d.idLote+')"> <i class="fas fa-history"></i></button>';
                        d.id_tipo_liberacion == 1 ?
                        btns += '<button type="button" class="btn-data btn-blueMaderas" data-toggle="tooltip"  data-placement="left" title="VER DOCUMENTO" onclick="visualizarDocumento('+d.id_hist_lib_lote+')"> <i class="fas fa-eye"></i></button>': '';
                    }
                    btns += '</div>'
                    return btns;
                }
            },
        ],
        ajax: {
            url: "get_historial_liberaciones", //URL QUE ARRASTRA LOS DATOS, PROVIENE DEL MODELO
            type: "POST",
            cache: false,
            data: function (d) {}
        }, 
    });
    $('#historialLib').removeClass('hide');
});

$('#historialLib').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});


$(document).ready(function () {
    
    if(id_rol_general == 12){
        $.post(general_base_url + "Contraloria/get_catalogo", {id_catalogo:110},   function (data) {
            let len = data.length;
            for (let i = 0; i < len; i++) {
                let id = data[i]['id_opcion'];
                let name = data[i]['nombre'];            
                $("#selLib").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#selLib").selectpicker('refresh')
        }, 'json');

        $.post(general_base_url + "Contraloria/get_catalogo", {id_catalogo:48},   function (data) {
            let len = data.length;
            for (let i = 0; i < len; i++) {
                let id = data[i]['id_opcion'];
                let name = data[i]['nombre'];            
                $("#motLib").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#motLib").selectpicker('refresh')
        }, 'json');
    } else{
        $("#contenidoMot").addClass('hide');
        $("#contenidoTip").addClass('hide');
    } 
});

$("#acceptModalButton").click(function() {
    let comentario = $('#comentario').val();
    let accion = $('#accion').val();
    let idLote = $('#idlote').val();
    let idLiberacion = $('#idLiberacion').val();
    let idCondominio = $('#idCondominio').val();
    let idProyecto = $('#idProyecto').val();
    let nombreLote = $('#nombreLote').val();
    let precio = $('#precio').val();
    let selLib = $('#selLib').val(); 
    let motLib = $('#motLib').val();
    let id_usuario_general = $('#id_usuario_general').val();
    let tipo_lote = $('#tipo_lote').val();
    let clausulas = $('#clausulas').val();

    if(id_rol_general == 12){

        if (comentario && accion && (selLib || accion ==2) && (motLib || accion ==2)) {
            $.ajax({
                url: general_base_url + 'Contraloria/avance_estatus_liberacion',
                type: 'POST',
                data: {
                    "idLote": idLote, 
                    "accion": accion, 
                    "idLiberacion": idLiberacion, 
                    "comentario": comentario, 
                    "activeLE": selLib == 2 ? true : false,
                    "activeLP": selLib == 1 ? true : false,
                    "id_proy": idProyecto, 
                    "idCondominio": idCondominio, 
                    "id_usuario": id_usuario_general, 
                    "tipo": motLib,
                    "nombreLote": nombreLote, 
                    "precio": precio, 
                    "tipo_lote": tipo_lote,
                    "clausulas": clausulas
                },
                dataType: 'JSON',
                success: function (data) {
                    data=JSON.parse(data);

                    console.log(data);

                    if(data == true){
                        alerts.showNotification("top", "right", "El registro se ha actualizado con éxito.", "success");
                        $("#historialLib").DataTable().ajax.reload();
                        $("#selLib").empty().selectpicker('refresh');
                        $("#motLib").empty().selectpicker('refresh');
                        closeModal();

                    }else{
                        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error:', jqXHR.status, errorThrown);
                },
                catch: function (c) {
                    console.log('catch:', c);
                },
            });
        }else if (!selLib && accion != 2){
            alerts.showNotification("top", "right", "Elige el tipo de liberación.", "warning");
        }else if (!motLib && accion != 2){
            alerts.showNotification("top", "right", "Elige el motivo de la liberación.", "warning");
        }else if (!comentario) {
            alerts.showNotification("top", "right", "Añada un comentario para actualizar la liberación.", "warning");
        }else{
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    }
    
    else{
        if (comentario && accion ) {
            $.ajax({
                url: general_base_url + 'Contraloria/avance_estatus_liberacion',
                type: 'POST',
                data: {
                    "idLote": idLote, 
                    "accion": accion, 
                    "idLiberacion": idLiberacion, 
                    "comentario": comentario, 
                    "activeLE": selLib == 2 ? true : false,
                    "activeLP": selLib == 1 ? true : false,
                    "id_proy": idProyecto, 
                    "idCondominio": idCondominio, 
                    "id_usuario": id_usuario_general, 
                    "tipo": motLib,
                    "nombreLote": nombreLote, 
                    "precio": precio, 
                    "tipo_lote": tipo_lote,
                    "clausulas": clausulas
                },
                dataType: 'JSON',
                success: function (data) {
                    data=JSON.parse(data);
                    console.log(data);
                    
                    if(data == true){
                        alerts.showNotification("top", "right", "El registro se ha actualizado con éxito.", "success");
                        $("#historialLib").DataTable().ajax.reload();
                        closeModal();

                    }else{
                        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error:', jqXHR.status, errorThrown);
                },
                catch: function (c) {
                    console.log('catch:', c);
                },
            });
        }else if (!comentario) {
            alerts.showNotification("top", "right", "Añada un comentario para actualizar la liberación", "warning");
        }else{
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    }
});

$('#btnEditarPrecio').click(function(){
    let idLote = $('#idLote').val() 
    let costoM2 = $('#costoM2').val().replaceAll('$', '').replaceAll(',','');
    
    $.ajax({
        type: 'POST',
        url: general_base_url + 'Contraloria/actualizar_precio',
        data: {
            'idLote': idLote,
            'costoM2': costoM2
        },
        dataType: 'json',
        success: function (data) {
            if (data == 1) {
                alerts.showNotification("top", "right", "El registro se ha actualizado con éxito.", "success");
                $("#historialLib").DataTable().ajax.reload();
                $('#editarModal').modal('hide');
            } else {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
            }
        }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
})

function openHistorialModal(idLote) {
    
    $.ajax({
        url: general_base_url + 'Contraloria/get_historial_liberaciones_por_lote',
        type: 'POST',
        data: {
            "idLote": idLote,
        },
        dataType: 'JSON',
        success: function (res) {
            $.each( res, function(i, v){
                fillChangelog(i, v);
            });
            $("#seeInformationModal").modal('show')
        },
        error: function (e) {
            console.log('error:', e);
        },
        catch: function (c) {
            console.log('catch:', c);
        },
    });
}

function visualizarDocumento(idLote){
    alert("Función por implementar: Visualizar documento del lote "+idLote);
}

function fillChangelog (i, v) {
    let liberacionTexto = v.id_proceso === 1 ? 'RESCISIÓN' : 'DEVOLUCIÓN';
    let txtRechazado = '';
    if (v.proceso_realizado == '1') {
        txtRechazado = '<b>REGRESADO A: </b>'
    }
    $("#changelog").append('<li>\n' +
'            <a>Campo: <b>PROCESO</b></a>\n' +
'            <a style="float: right">'+v.fecha_modificacion.split('.')[0]+'</a><br>\n' +
'            <a>Tipo de liberación:</a> <b> '+ liberacionTexto +' </b>\n' +
'            <br>\n' + 
'            <a>Estatus:</a> <b> '+txtRechazado+v.nombre_proceso.toUpperCase()+' </b>\n' +
'            <br>\n' +  
'            <a>Modificado por:<b> '+(v.nombre_u+' '+v.ap_u+ ' '+ v.am_u).toUpperCase()+' </b></a>\n' +
'            <br>\n' +
'            <a>Comentarios:<b> '+v.justificacion_liberacion+' </b></a>\n' +
    '</li>');
}

function fillModal(accion, idLote, tipoLiberacion, idCondominio, idProyecto, nombreLote, precio, tipo_lote='', clausulas='') {
    let modalTitle = document.getElementById("modal-title");
    let modalContent = document.getElementById("contenido");
    $('#idlote').val(idLote);
    $('#accion').val(accion);
    $('#idLiberacion').val(tipoLiberacion);
    $('#idCondominio').val(idCondominio);
    $('#idProyecto').val(idProyecto);
    $('#nombreLote').val(nombreLote);
    $('#precio').val(precio); 
    $('#tipo_lote').val(tipo_lote);
    $('#clausulas').val(clausulas);
    let picker = document.getElementById("contenidoTip");
    let pickerb = document.getElementById("contenidoMot");

    if (accion == 1 || accion == 3) { //Validar
        modalTitle.innerHTML = "<b>¿Está seguro de validar la liberación?</b>";
        modalContent.innerHTML= "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>"+
        "<label class='control-label'>Comentarios (<span class='isRequired'>*</span>)</label>"+
        "<input class='text-modal mb-1' name='Comentarios' id='comentario' autocomplete='off'>"+
        "<br><br><br></div>";

        picker.style.display = "block"; 
        pickerb.style.display = "block"; 
     
        $('#modalGeneral').modal('show');
    }
    if(accion == 2){ //Invalidar
        modalTitle.innerHTML = "<b>¿Está seguro de invalidar la liberación?</b>";
        modalContent.innerHTML=" <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>"+
        "<label class='control-label'>Comentarios (<span class='isRequired'>*</span>)</label>"+
        "<input class='text-modal mb-1' name='Comentarios' id='comentario' autocomplete='off'>"+
        "<br><br><br></div>";

        picker.style.display = "none";
        pickerb.style.display = "none";

        $('#modalGeneral').modal('show');
    }
}

function closeModal() {
    $('#modal-title').text('');
    $('#modal-content').text('');
    $('#idlote').val('');
    $('#accion').val(''); 
    $('#idLiberacion').val('');
    $('#modalGeneral').modal('hide');
    $('#editarModal').modal("hide");
    $('#idLote').val('')
    $('#idCondominio').val('');
    $('#idProyecto').val('');
    $('#nombreLote').val('');
    $('#precio').val('');
    $('#selLib').val('');
    $('#motLib').val('');
}

function cleanComments() { 
    let myChangelog = document.getElementById('changelog');
    myChangelog.innerHTML = '';
}

function editInfo(idLote, nombreLote, precio){
    document.getElementById('title').innerHTML = 'PRECIO M2 DEL LOTE <b>' + idLote + '</b> CON NOMBRE <b>' + nombreLote + '</b>';
    let costoM2 = document.getElementById("costoM2");
    costoM2.value = `$${formatMoney(precio)}`;
    $('#idLote').val(idLote)
    $("#editarModal").modal('show')
}