$.getJSON("getPaymentMethod").done( function( data ){
    $(".payment_method").append($('<option disabled selected>').val("").text("Seleccione una opción"));
    var len = data.length;
    for( var i = 0; i<len; i++)
    {
        var id = data[i]['id_opcion'];
        var name = data[i]['nombre'];
        $(".payment_method").append($('<option>').val(id).text(name));
    }
});

$('#all_users_datatable thead tr:eq(0) th').each( function (i) {

     if(i != 14){
    var title = $(this).text();
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>` );
    $( 'input', this ).on('keyup change', function () {
        if ($('#all_users_datatable').DataTable().column(i).search() !== this.value ) {
            $('#all_users_datatable').DataTable().column(i).search(this.value).draw();
        }
    } );
    }
});

$('#all_users_datatable').DataTable({
    dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",

    "buttons": [
        {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Lista de usuarios',
            title:'Lista de usuarios',
            exportOptions: {
            
                columns: userType == 49 ? [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13] : [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14] ,
                format: {
                    header: function (d, columnIdx) {

                        if(userType == 49){
                            switch (columnIdx) {
                            case 0:
                                return 'ESTATUS';
                                break;
                            case 1:
                                return 'ID';
                                break;
                            case 2:
                                return 'NOMBRE';
                            case 3:
                                return 'CORREO';
                                break;
                            case 4:
                                return 'TELÉFONO';
                                break;
                            case 5:
                                return 'TIPO';
                                break;
                            case 6:
                                return 'SEDE';
                                break;
                            case 7:
                                return 'FORMA PAGO';
                                break;
                            case 8:
                                return 'NACIONALIDAD';
                                break;
                            case 9:
                                return 'COORDINADOR';
                                break;
                            case 10:
                                return 'GERENTE';
                                break;
                            case 11:
                                return 'SUBDIRECTOR';
                                break;
                            case 12:
                                return 'DIRECTOR REGIONAL';
                                break;
                            case 13:
                                return 'TIPO DE USUARIO';
                                break;
                            case 14:
                                return 'FECHA ALTA';
                                break;
                        }

                        }else{
                            switch (columnIdx) {
                            case 0:
                                return 'ESTATUS';
                                break;
                            case 1:
                                return 'ID';
                                break;
                            case 2:
                                return 'NOMBRE';
                            case 3:
                                return 'CORREO';
                                break;
                            case 4:
                                return 'TELÉFONO';
                                break;
                            case 5:
                                return 'TIPO';
                                break;
                            case 6:
                                return 'SEDE';
                                break;
                            case 7:
                                return 'FORMA PAGO';
                                break;
                            case 8:
                                return 'COORDINADOR';
                                break;
                            case 9:
                                return 'GERENTE';
                                break;
                            case 10:
                                return 'SUBDIRECTOR';
                                break;
                            case 11:
                                return 'DIRECTOR REGIONAL';
                                break;
                            case 12:
                                return 'TIPO DE USUARIO';
                                break;
                            case 13:
                                return 'FECHA ALTA';
                                break;
                        }

                        }
                    }
                }
            }
        }
    ],
    ordering: false,
    paging: true,
    scrollX: true,
    pagingType: "full_numbers",
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, "Todos"]
    ],
    language: {
        url: general_base_url + "/static/spanishLoader_v2.json",
        paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>"
        }
    },
    destroy: true,
    columns: [
        {
            data: function (d) {
                if (d.nuevo == 1) {
                    return '<center><span class="label label-info" >Nuevo usuario</span><center>';

                } else {
                    if (d.estatus == 1) {
                        return '<center><span class="label label-danger" style="background:#27AE60">Activo</span><center>';
                    } else if (d.estatus == 3) {
                        boton =  '<center><span class="label label-danger" style="background:#E74C3C">Baja </span><center>';

                         
                                    if(userType == 49){
                                
                                 var fecha_baja = '<center>Fecha baja: <b>'+d.fecha_baja+'</b><br><center>';
                                
                                    }else{
                               
                                 var fecha_baja = '';
                                       
                                    }

                              
                                

                                return boton + fecha_baja;


                    } else {
                        if (d.abono_pendiente !== undefined) {
                            if (parseFloat(d.abono_pendiente) > 0) {
                                boton = '<center><p class="mt-1"><span class="label label-danger" style="background:#E74C3C">Baja </span></p><center>';


                                
                                    if(userType == 49){
                                
                                 var fecha_baja = '<center>Fecha baja: <b>'+d.fecha_baja+'</b><br><center>';
                               
                                    }else{
                               
                                 var fecha_baja = '';
                                       
                                    }

                               


                                return boton + fecha_baja;

                            } else {
                                var boton = '<center><span class="label label-danger" style="background:#E74C3C">Baja </span></center>';
                               
                               
                                    if(userType == 49){
                                
                                 var fecha_baja = '<center>Fecha baja: <b>'+d.fecha_baja+'</b><br><center>';
                                
                                    }else{
                                
                                 var fecha_baja = '';
                                        
                                    }

                            
                                return boton + fecha_baja;
                            }

                        } else {
                                var boton = '<center><span class="label label-danger" style="background:#E74C3C">Baja </span></center>';
                               
                                
                                    if(userType == 49){
                                
                                 var fecha_baja = '<center>Fecha baja: <b>'+d.fecha_baja+'</b><br><center>';
                                
                                    }else{
                               
                                 var fecha_baja = '';
                                       
                                    }

                                
                                return boton + fecha_baja;
                        }
                    }
                }
            }
        },
        { data: function (d) {
                return d.id_usuario;
            }
        },
        { data: function (d) {
                return d.nombre;
            }
        },
        { data: function (d) {
                return d.correo;
            }
        },
        { data: function (d) {
                return d.telefono;
            }
        },
        { data: function (d) {
                return d.puesto;
            }
        },
        { data: function (d) {
                return d.sede;
            }
        },
        { data: function (d) {
                return d.jefe_directo;
            }
        },
        { data: function (d) {
                if (userId == 2767 || userId == 5957 || userId == 4878) {
                    return '<button class="btn btn-success btn-round btn-fab btn-fab-mini edit-user-information" data-id-usuario="' + d.id_usuario +'" style="margin-right: 5px;background-color:#2874A6;border-color:#21618C" title="Cambiar forma de pago"><i class="material-icons">edit</i></button>'+
                    '<button class="btn btn-success btn-round btn-fab btn-fab-mini see-user-information" data-id-usuario="' + d.id_usuario +'" style="background-color:#96843d;border-color:#48DBA7" title="Ver historial de cambios"><i class="material-icons">visibility</i></button>';
                } else {
                    return '<button class="btn btn-success btn-round btn-fab btn-fab-mini see-user-information" data-id-usuario="' + d.id_usuario +'" style="background-color:#96843d;border-color:#48DBA7" title="Ver historial de cambios"><i class="material-icons">visibility</i></button>';
                }
            }
        }
    ],
    "ajax": {
        "url": general_base_url + "/usuarios/getUsersList",
        "type": "POST",
        cache: false,
        "data": function( d ){
        }
    }
});

$('#all_users_datatable').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});   

$(document).on('click', '.edit-user-information', function(e){
    id_usuario = $(this).attr("data-id-usuario");
    $.getJSON("getUserInformation/"+id_usuario).done( function( data ){
        $.each( data, function(i, v){
            $("#editUserModal").modal();
            $("#payment_method").val(v.forma_pago);
            $("#id_usuario").val(v.id_usuario);
            $(".div_payment_method").removeClass("is-empty");
        });
    });
});

$(document).on('click', '.see-user-information', function(e){
    id_usuario = $(this).attr("data-id-usuario");
    $.getJSON("getChangelog/"+id_usuario).done( function( data ){
        $("#seeInformationModal").modal();
        $.each( data, function(i, v){
            fillChangelog(v);

        });
    });
});

function fillChangelog (v) {
    $("#changelog").append('<li>\n' +
        '            <a>Campo: <b>'+v.parametro_modificado+'</b></a>\n' +
        '            <a style="float: right">'+v.fecha_creacion+'</a><br>\n' +
        '            <a>Valor anterior:</a> <b> '+v.anterior+' </b>\n' +
        '            <br>\n' +
        '            <a>Valor nuevo:</a> <b> '+v.nuevo+' </b>\n' +
        '            <br>\n' +
        '            <a>Usuario:<b> '+v.creador+' </b></a>\n' +
        '</li>');
}

function cleanComments() {
    var myChangelog = document.getElementById('changelog');
    myChangelog.innerHTML = '';
}

$("#editUserForm").on('submit', function(e){
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: general_base_url + '/usuarios/updateUser',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
        },
        success: function(data) {
            if (data == 1) {
                $('#editUserModal').modal("hide");
                alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                $('#all_users_datatable').DataTable().ajax.reload(null, false);
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});


$(document).on('click', '.see-changes-log', function(){
    id_usuario = $(this).attr("data-id-usuario");
    $.post("getChangeLogUsers/"+id_usuario).done( function( data ){
        console.log("aqui es: " + data);
        $("#changesRegsUsers").modal();
        $.each( JSON.parse(data), function(i, v){
            fillChangelogUsers(v);
        });
    });
});