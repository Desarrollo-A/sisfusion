$(document).ready(function() {
    $.post(`${general_base_url}Usuarios/getPaymentMethod`, function(data) {
    var len = data.length;
    for( var i = 0; i<len; i++)
    {
        var id = data[i]['id_opcion'];
        var name = data[i]['nombre'];
        $('#payment_method').append($('<option>').val(id).text(name.toUpperCase()));
    }
    $('#payment_method').selectpicker('refresh');

    }, 'json');
});

let titulos = [];
$('#all_users_datatable thead tr:eq(0) th').each( function (i) {    
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>` );
    $( 'input', this ).on('keyup change', function () {
        if ($('#all_users_datatable').DataTable().column(i).search() !== this.value ) {
            $('#all_users_datatable').DataTable().column(i).search(this.value).draw();
        }
    });
});

$('#all_users_datatable').DataTable({
    dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: "100%",
    scrollX: true,
    bAutoWidth: true,
    buttons: [{
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Lista de usuarios',
        title:'Lista de usuarios',
        exportOptions: {
            columns: id_rol_general == 49 ? [0, 1, 2, 3, 4, 5, 6, 7, 8,10,11,] : [0, 1, 2, 3, 4, 5, 6, 7 ,8 ,9 ,10 ,11,] ,
            format: {
                header: function (d, columnIdx) {
                    return ' ' + titulos[columnIdx] + ' ';
                }
            }
        }
    }],
    ordering: false,
    paging: true,
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
                    return '<center><span class="label lbl-cerulean" >Nuevo usuario</span><center>';
                } else {
                    if (d.estatus == 1) {
                        return '<center><span class="label lbl-green">Activo</span><center>';
                    } else if (d.estatus == 3) {
                        boton = '<center><span class="label lbl-warning">Baja </span><center>';
                        if(id_rol_general == 49){
                            var fecha_baja = '<center>FECHA DE BAJA <b>'+d.fecha_baja+'</b><br><center>';
                        }else{
                            var fecha_baja = '';
                        }
                        return boton + fecha_baja;
                    } else {
                        if (d.abono_pendiente !== undefined) {
                            if (parseFloat(d.abono_pendiente) > 0) {
                                boton = '<center><p class="mt-1"><span class="label lbl-warning">Baja </span></p><center>';
                                if(id_rol_general == 49){
                                    var fecha_baja = '<center>FECHA DE BAJA <b>'+d.fecha_baja+'</b><br><center>';
                                }else{
                                    var fecha_baja = '';
                                }
                                return boton + fecha_baja;
                            } else {
                                var boton = '<center><span class="label lbl-warning">Baja </span></center>';
                                if(id_rol_general == 49){
                                    var fecha_baja = '<center>FECHA DE BAJA <b>'+d.fecha_baja+'</b><br><center>';
                                }else{
                                    var fecha_baja = '';
                                }
                                return boton + fecha_baja;
                            }
                        } else {
                            var boton = '<center><span class="label lbl-warning">Baja </span></center>';
                            if(id_rol_general == 49){
                                var fecha_baja = '<center>FECHA DE BAJA <b>'+d.fecha_baja+'</b><br><center>';
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
        { 
            data: function (d) {
                if (id_rol_general == 49) {
                    if(d.usuariouniv==1){
                        return '<center><span class="label label-info">DESCUENTO UNIVERSIDAD</span><center>';
                    }else{
                        return '<center><span class="label label-info" style="background:gray">SIN DESCUENTO</span><center>';
                    }
                }
                else{
                    return d.forma_pago;
                }
            }
        },
        { data: function (d) {
            
            return '<span class="label lbl-green">'+ d.nacionalidad+ '</span>';
            }
        },
        { data: function (d) {
                return d.jefe_directo;
            }
        },
        {
            data: function (d) {
                if (d.ismktd == 1)
                    return '<center><span class="label lbl-azure">ES MKTD</span><center>';
                else
                    return '<center><span class="label lbl-gray">SIN ESPECIFICAR</span><center>';
            }
        },
        { data: function (d) {
            return d.fecha_creacion;
            }
        },
        { 
            data: function (d) {
                if (id_usuario_general == 2767 || id_usuario_general == 5957 || id_usuario_general == 4878) {
                    return '<div class="d-flex"><button class="btn btn-blueMaderas btn-round btn-fab btn-fab-mini edit-user-information" data-id-usuario="' + d.id_usuario +'" data-toggle="tooltip" data-placement="top" title="CAMBIAR FORMA DE PAGO"><i class="fas fa-pencil-alt"></i></button>'+
                    '<button class="btn btn-green btn-round btn-fab btn-fab-mini see-user-information" data-id-usuario="' + d.id_usuario +'" data-toggle="tooltip" data-placement="top" title="VER HISTORIAL DE CAMBIOS"><i class="far fa-eye"></i></button></div>';
                } else {
                    if(id_usuario_general == 2896){
                        return '';
                    }else{
                        return '<div class="d-flex justify-center"><button class="btn-data btn-green see-user-information" data-id-usuario="' + d.id_usuario +'" data-toggle="tooltip" data-placement="top" title="VER HISTORIAL DE CAMBIOS"><i class="far fa-eye"></i></button>';
                    }
                }
            }
        }
    ],
    ajax: {
        "url": "getUsersList",
        "type": "POST",
        cache: false,
        "data": function( d ){
        }
    },
    columnDefs:[{
        visible: id_rol_general == 49 ? false : true,
        targets:8, 
    }],
});

$('#all_users_datatable').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});   

$(document).on('click', '.edit-user-information', function(e){
    $('#spiner-loader').removeClass('hide');
    id_usuario = $(this).attr("data-id-usuario");
    $.getJSON("getUserInformation/"+id_usuario).done( function( data ){
        $('#spiner-loader').addClass('hide');
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
'            <a>Campo: <b>'+v.parametro_modificado.toUpperCase()+'</b></a>\n' +
'            <a style="float: right">'+v.fecha_creacion+'</a><br>\n' +
'            <a>Valor anterior:</a> <b> '+v.anterior.toUpperCase()+' </b>\n' +
'            <br>\n' +
'            <a>Valor nuevo:</a> <b> '+v.nuevo.toUpperCase()+' </b>\n' +
'            <br>\n' +
'            <a>Usuario:<b> '+v.creador.toUpperCase()+' </b></a>\n' +
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
        url: 'updateUser',
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
        $("#changesRegsUsers").modal();
        $.each( JSON.parse(data), function(i, v){
            fillChangelogUsers(v);
        });
    });
});