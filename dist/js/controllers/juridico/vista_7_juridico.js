var idlote_global = 0;
var getInfo1 = new Array(7);
var getInfo2 = new Array(7);
var getInfo3 = new Array(7);
var getInfo4 = new Array(1);
var idUsuario = id_usuario_general;
var user, id, usuario;

$(document).ready(function () {
    $.post(general_base_url + "Contratacion/lista_proyecto", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#proyecto").selectpicker('refresh');
    }, 'json');
    
    user = idUsuario;
    $.post(`${general_base_url}Contraloria/get_sede`, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_sede'];
            var name = data[i]['nombre'];
            $("#ubicacion").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#ubicacion").selectpicker('refresh');
    }, 'json');
    $.post(`${general_base_url}Juridico/get_users_reassing`, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombreUsuario'];
            $("#user_re").append($('<option>').val(id).text(name));
        }
        $("#user_re").selectpicker('refresh');
    }, 'json');
});

$("#Jtabla").ready(function () {
    let titulos = [];
    $('#Jtabla thead tr:eq(0) th').each(function (i) {
        if (i != 0) {
            var title = $(this).text();
            titulos.push(title);
            $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if (tabla_6.column(i).search() !== this.value) {
                    tabla_6.column(i).search(this.value).draw();
                }
            });
        }
    });

    tabla_6 = $("#Jtabla").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'REGISTRO DE ESTATUS 7',
            title: 'REGISTRO DE ESTATUS 7',
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                format: 
                {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos[columnIdx-1] + ' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        pageLength: 10,
        bAutoWidth: false,
        fixedColumns: true,
        ordering: true,
        columns: [{
            className: 'details-control',
            orderable: false,
            data: null,
            defaultContent: '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
        },
        {
            data: function (d) {
                return `<span class="label lbl-green">${d.tipo_venta}</span>`;
            }
        },
        {
            data: function (d) {
                return `<span class='label lbl-violetBoots'>${d.tipo_proceso}</span>`;
            }
        },
        {
            data: function (d) {
                if(d.etapa == null || d.etapa == "NULL")
                    return `<p class="m-0">${d.nombreResidencial}</p><b><p class="m-0">SIN ESPECIFICAR</p></b>`;
                else
                    return `<p class="m-0">${d.nombreResidencial}</p><b><p class="m-0">${d.etapa}</p></b>`;
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + (d.nombreCondominio).toUpperCase(); +'</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.nombreLote + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.gerente + '</p>';
            }
        },
        {
            data: function (d) {
                var nombre = (d.n_cop == 0) ? '<p class="m-0">' + d.nombre + " " + d.apellido_paterno + " " + d.apellido_materno + '</p>'
                    : '<p class="m-0">' + d.nombret + '</p>' + '<p class="m-0">' + d.nombrec + '</p>'
                return nombre;
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.modificado.split('.')[0] + '</p>';
            }
        },
        {
            data: function (d) {
                var fechaVenc;
                if (d.idStatusContratacion == 6 && d.idMovimiento == 23 || d.idStatusContratacion == 6 && d.idMovimiento == 95 ||
                    d.idStatusContratacion == 6 && d.idMovimiento == 97 || d.idStatusContratacion == 6 && d.idMovimiento == 112) {
                    fechaVenc = d.fechaVenc2.split('.')[0];
                } else if (d.idStatusContratacion == 6 && d.idMovimiento == 36 || d.idStatusContratacion == 6 && d.idMovimiento == 6 ||
                    d.idStatusContratacion == 7 && d.idMovimiento == 83) {
                    fechaVenc = d.fechaVenc.split('.')[0];
                } else if (d.idStatusContratacion == 6 && d.idMovimiento == 76) {
                    fechaVenc = 'VENCIDO';
                }
                return '<p class="m-0">' + fechaVenc + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.juridico + '</p>';
            }
        },
        {
            data: function (d) {
                return `<span class="label lbl-blueMaderas">${d.nombreSede}</span>`;
            }
        },
        {
            orderable: false,
            data: function (data) {
                var cntActions;
                if (data.vl == '1')
                    return 'En proceso de Liberación';
                else {
                    if([6, 7].includes(data.idStatusContratacion)){
                        cntActions = 
                        '<button href="#" data-idLote="' + data.idLote + 
                        '" data-nomLote="' + data.nombreLote + 
                        '" data-idCond="' + data.idCondominio +
                        '" data-idCliente="' + data.id_cliente + 
                        '" data-fecVen="' + data.fechaVenc + 
                        '" data-ubic="' + data.ubicacion + 
                        '" data-code="' + data.cbbtton +
                        '" data-idMov="' + data.idMovimiento +
                        '" data-perfil="' + data.perfil +
                        '" data-idStatusContratacion="' + data.idStatusContratacion +  
                        '" class="btn-data btn-green editLoteRev" data-toggle="tooltip" data-placement="top" title="REGISTRAR ESTATUS (VENTAS)">' +
                        '<i class="fas fa-thumbs-up"></i></button>';

                        cntActions += 
                        '<button href="#" data-idLote="' + data.idLote + 
                        '" data-nomLote="' + data.nombreLote + 
                        '" data-idCond="' + data.idCondominio +
                        '" data-idCliente="' + data.id_cliente + 
                        '" data-fecVen="' + data.fechaVenc2 + 
                        '" data-ubic="' + data.ubicacion + 
                        '" data-code="' + data.cbbtton +
                        '" data-idMov="' + data.idMovimiento +
                        '" data-perfil="' + data.perfil +
                        '" data-idStatusContratacion="' + data.idStatusContratacion + 
                        '" class="btn-data btn-warning cancelReg" data-toggle="tooltip" data-placement="top" title="RECHAZAR ESTATUS (CONTRALORÍA)">' +
                        '<i class="fas fa-thumbs-down"></i></button>';

                        cntActions += 
                        '<button href="#" data-idLote="' + data.idLote + 
                        '" data-nomLote="' + data.nombreLote + 
                        '" data-idCond="' + data.idCondominio +
                        '" data-idCliente="' + data.id_cliente + 
                        '" data-fecVen="' + data.fechaVenc2 + 
                        '" data-ubic="' + data.ubicacion + 
                        '" data-code="' + data.cbbtton +
                        '" data-idMov="' + data.idMovimiento +
                        '" data-perfil="' + data.perfil +
                        '" data-idStatusContratacion="' + data.idStatusContratacion + 
                        '" class="btn-data btn-orangeYellow return2" data-toggle="tooltip" data-placement="top" title="RECHAZAR ESTATUS (ASESOR)">' +
                        '<i class="fas fa-thumbs-down"></i></button>';

                        cntActions += 
                        '<button href="#" title= "Código de barras"'+ 
                        '" data-lote="' + data.cbbtton +
                        '" class="btn-data btn-blueMaderas barcode" data-toggle="tooltip" data-placement="top" title="VER CÓDIGO">' +
                        '<i class="fas fa-barcode"></i></button>';
                    } 
                     else {
                        cntActions = ' ';
                    }

                    if (Array(2762, 6096, 6864, 10937, 10938, 12136, 12173, 13015, 13498, 15041, 15042, 15042).includes(user) ){
                        cntActions += '<button href="#" data-toggle="tooltip" data-placement="top" title= "CAMBIO DE SEDE" data-nomLote="' + data.nombreLote + '" data-lote="' + data.idLote + '" class="btn btn-secondary btn-round btn-fab btn-fab-mini change_sede"><span class="material-icons">pin_drop</span></button>';
                    }

                    if (Array(1, 2, 4, 5, 3, 12, 15, 16).includes(parseInt(data.ubicacion)) && Array(2762, 2845, 2747, 6096, 6864, 10937, 10938, 12136, 12173, 13015, 13498, 15041, 15042, 15042).includes(user)) {
                        cntActions += '<button href="#" data-toggle="tooltip" data-placement="top" title= "REASIGNACIÓN" data-nomLote="' + data.nombreLote + '" data-usuario="' + data.juridico + '" data-lote="' + data.idLote + '" class="btn btn-warning btn-round btn-fab btn-fab-mini change_user"><span class="material-icons">find_replace</span></button>';
                    }
                    var color = (data.idMovimiento == 36) ? '#58D68D' :
                        (data.idMovimiento == 23) ? '#F39C12' : '#85929E';
                    var label = (data.idMovimiento == 36) ? 'NUEVO' :
                        (data.idMovimiento == 23) ? 'MODIFICACIÓN' : 'REVISIÓN';
                    var btn = '<div class="d-flex justify-center">'+cntActions+'</div>';
                    return btn;
                }
            }
        }],
        columnDefs: [{
            defaultContent: "-",
            targets: "_all"
        }],
        ajax: {
            url: `${general_base_url}Juridico/getStatus7ContratacionJuridico`,
            dataSrc: "",
            type: "POST",
            cache: false,
            data: function (d) {
            }
        },
        order: [[1, 'asc']]
    });

    $('#Jtabla').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $('#Jtabla tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tabla_6.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        } else {
            var status;
            
            if (row.data().idStatusContratacion == 6 && row.data().idMovimiento == 36) {
                status = "Status 6 listo (Contraloría) ";
            } else if (row.data().idStatusContratacion == 6 && row.data().idMovimiento == 6 || row.data().idStatusContratacion == 6 && row.data().idMovimiento == 76 ||
                row.data().idStatusContratacion == 6 && row.data().idMovimiento == 83 || row.data().idStatusContratacion == 6 && row.data().idMovimiento == 95) {
                status = "Status 6 enviado a Revisión (Contraloría)";
            } else if (row.data().idStatusContratacion == 6 && row.data().idMovimiento == 23) {
                status = "Status 7 rechazado o enviado para Modificación (Asistentes de Gerentes)";
            } else if (row.data().idStatusContratacion == 6 && row.data().idMovimiento == 83 || row.data().idStatusContratacion == 6 && row.data().idMovimiento == 97) {
                status = "Status 2 enviado a Revisión (Asesor)";
            }
            var informacion_adicional = '<div class="container subBoxDetail">';
            informacion_adicional += '  <div class="row">';
            informacion_adicional += '      <div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">';
            informacion_adicional += '          <label><b>Información adicional</b></label>';
            informacion_adicional += '      </div>';
            informacion_adicional += '     <div class="col-12 col-sm-12 col-md-12 col-lg-12">';
            informacion_adicional += '         <label><b>ESTATUS: </b></label> ' + status;
            informacion_adicional += '     </div>';
            informacion_adicional += '     <div class="col-12 col-sm-12 col-md-12 col-lg-12">';
            informacion_adicional += '         <label><b>COMENTARIO: </b></label> ' + row.data().comentario;
            informacion_adicional += '     </div>';
            informacion_adicional += '     <div class="col-12 col-sm-12 col-md-12 col-lg-12">';
            informacion_adicional += '         <label><b>FECHA APARTADO: </b></label> ' + row.data().fechaApartado.split('.')[0];
            informacion_adicional += '     </div>';
            informacion_adicional += '     <div class="col-12 col-sm-12 col-md-12 col-lg-12">';
            informacion_adicional += '         <label><b>COORDINADOR: </b></label> ' + row.data().coordinador;
            informacion_adicional += '     </div>';
            informacion_adicional += '     <div class="col-12 col-sm-12 col-md-12 col-lg-12">';
            informacion_adicional += '         <label><b>ASESOR: </b></label> ' + row.data().asesor;
            informacion_adicional += '     </div>';
            informacion_adicional += '  </div>';
            informacion_adicional += '</div>';
            row.child(informacion_adicional).show();
            tr.addClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
        }
    });

    $("#Jtabla tbody").on("click", ".editLoteRev", function (e) {
        e.preventDefault();
        getInfo1[0] = $(this).attr("data-idCliente");
        getInfo1[1] = $(this).attr("data-nombreResidencial");
        getInfo1[2] = $(this).attr("data-nombreCondominio");
        getInfo1[3] = $(this).attr("data-idcond");
        getInfo1[4] = $(this).attr("data-nomlote");
        getInfo1[5] = $(this).attr("data-idLote");
        getInfo1[6] = $(this).attr("data-fecven");
        getInfo1[7] = $(this).attr("data-code");
        getInfo1[8] = $(this).attr("data-idMov");
        getInfo1[9] = $(this).attr("data-perfil");
        getInfo1[10] = $(this).attr("data-idStatusContratacion");
    
        document.getElementById("titulo_lote").innerHTML = getInfo1[4];
        $('#editLoteRev').modal('show');
    });

    $("#Jtabla tbody").on("click", ".cancelReg", function (e) {
        e.preventDefault();
        getInfo2[0] = $(this).attr("data-idCliente");
        getInfo2[1] = $(this).attr("data-nombreResidencial");
        getInfo2[2] = $(this).attr("data-nombreCondominio");
        getInfo2[3] = $(this).attr("data-idcond");
        getInfo2[4] = $(this).attr("data-nomlote");
        getInfo2[5] = $(this).attr("data-idLote");
        getInfo2[6] = $(this).attr("data-fecven");
        getInfo2[7] = $(this).attr("data-code");
        getInfo2[8] = $(this).attr("data-idMov");
        getInfo2[9] = $(this).attr("data-perfil");
        getInfo2[10] = $(this).attr("data-idStatusContratacion");

        document.getElementById("titulo_lote_rechazo").innerHTML = getInfo2[4];
        $('#rechReg').modal('show');
    });

    $("#Jtabla tbody").on("click", ".change_sede", function (e) {
        e.preventDefault();
        getInfo4[0] = $(this).attr("data-lote");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#change_s').modal('show');
    });

    $("#Jtabla tbody").on("click", ".change_user", function (e) {
        e.preventDefault();
        id = $(this).attr("data-lote");
        nombreLote = $(this).data("nomlote");
        usuario = $(this).attr("data-usuario");
        $(".userJ").html(usuario);
        $('#change_u').modal('show');
    });

    $("#Jtabla tbody").on("click", ".return2", function (e) {
        e.preventDefault();
        getInfo3[0] = $(this).attr("data-idCliente");
        getInfo3[1] = $(this).attr("data-nombreResidencial");
        getInfo3[2] = $(this).attr("data-nombreCondominio");
        getInfo3[3] = $(this).attr("data-idcond");
        getInfo3[4] = $(this).attr("data-nomlote");
        getInfo3[5] = $(this).attr("data-idLote");
        getInfo3[6] = $(this).attr("data-fecven");
        getInfo3[7] = $(this).attr("data-code");
        getInfo3[8] = $(this).attr("data-idMov");
        getInfo3[9] = $(this).attr("data-perfil");
        getInfo3[10] = $(this).attr("data-idStatusContratacion");

        document.getElementById("titulo_lote_rechazo2").innerHTML = getInfo3[4];
        $('#return2').modal('show');
    });
});

$(document).on('click', '#save1', function (e) {
    e.preventDefault();
    var comentario = $("#comentario").val();
    var validaComentario = (document.getElementById("comentario").value.trim() == '') ? 0 : 1;

    var dataExp1 = new FormData();
    dataExp1.append("idCliente", getInfo1[0]);
    dataExp1.append("nombreResidencial", getInfo1[1]);
    dataExp1.append("nombreCondominio", getInfo1[2]);
    dataExp1.append("idCondominio", getInfo1[3]);
    dataExp1.append("nombreLote", getInfo1[4]);
    dataExp1.append("idLote", getInfo1[5]);
    dataExp1.append("comentario", comentario);
    dataExp1.append("fechaVenc", getInfo1[6]);
    dataExp1.append("numContrato", getInfo1[7]);
    dataExp1.append("idMovimiento", getInfo1[8]);
    dataExp1.append("perfil", getInfo1[9]);
    dataExp1.append("idStatusContratacion", getInfo1[10]);

    if (validaComentario == 0)
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");

        else {
        $('#save1').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Juridico/editar_registro_loteRevision_juridico_proceso7`,
            data: dataExp1,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data) {
                response = JSON.parse(data);
                
                if (response.status) {
                    alerts.showNotification("top", "right", response.message, "success");
                }
                else{
                    alerts.showNotification("top", "right", response.message, "danger");
                }

                $()
                $('#save1').prop('disabled', false);
                $('#editLoteRev').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
            },
            error: function () {
                $('#save1').prop('disabled', false);
                $('#editLoteRev').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save2', function (e) {
    e.preventDefault();
    var comentario = $("#comentario2").val();
    var validaComentario = (document.getElementById("comentario2").value.trim() == '') ? 0 : 1;

    var dataExp2 = new FormData();
    dataExp2.append("idCliente", getInfo2[0]);
    dataExp2.append("nombreResidencial", getInfo2[1]);
    dataExp2.append("nombreCondominio", getInfo2[2]);
    dataExp2.append("idCondominio", getInfo2[3]);
    dataExp2.append("nombreLote", getInfo2[4]);
    dataExp2.append("idLote", getInfo2[5]);
    dataExp2.append("comentario", comentario);
    dataExp2.append("fechaVenc", getInfo2[6]);
    dataExp2.append("numContrato", getInfo2[7]);
    dataExp2.append("idMovimiento", getInfo2[8]);
    dataExp2.append("perfil", getInfo2[9]);
    dataExp2.append("idStatusContratacion", getInfo2[10]);

    if (validaComentario == 0)
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    else {
        $('#save2').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Juridico/editar_registro_loteRechazo_juridico_proceceso7`,
            data: dataExp2,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data) {
                response = JSON.parse(data);

                if (response.status) 
                    alerts.showNotification("top", "right", response.message, "success");                
                else
                    alerts.showNotification("top", "right", response.message, "danger");

                $('#save2').prop('disabled', false);
                $('#rechReg').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
            },
            error: function () {
                $('#save2').prop('disabled', false);
                $('#rechReg').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save3', function (e) {
    e.preventDefault();
    var comentario = $("#comentario3").val();
    var validaComentario = (document.getElementById("comentario3").value.trim() == '') ? 0 : 1;

    var dataExp3 = new FormData();
    dataExp3.append("idCliente", getInfo3[0]);
    dataExp3.append("nombreResidencial", getInfo3[1]);
    dataExp3.append("nombreCondominio", getInfo3[2]);
    dataExp3.append("idCondominio", getInfo3[3]);
    dataExp3.append("nombreLote", getInfo3[4]);
    dataExp3.append("idLote", getInfo3[5]);
    dataExp3.append("comentario", comentario);
    dataExp3.append("fechaVenc", getInfo3[6]);
    dataExp3.append("numContrato", getInfo3[7]);
    dataExp3.append("idMovimiento", getInfo3[8]);
    dataExp3.append("perfil", getInfo3[9]);
    dataExp3.append("idStatusContratacion", getInfo3[10]);

    if (validaComentario == 0)
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    else {
        $('#save3').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Juridico/return2_jaa`,
            data: dataExp3,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data) {
                response = JSON.parse(data);
                
                if (response.status) {
                    alerts.showNotification("top", "right", response.message, "success");
                } else {
                    alerts.showNotification("top", "right", response.message, "danger");
                }

                $('#save3').prop('disabled', false);
                $('#return2').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
            },
            error: function () {
                $('#save3').prop('disabled', false);
                $('#return2').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#reassing', function (e) {
    e.preventDefault();
    var user = $('#user_re').val();
    $.ajax({
        url: `${general_base_url}Juridico/changeUs`,
        data: { user: user, idlote: id },
        dataType: 'json',
        type: 'POST',
        success: function (data) {
            alerts.showNotification("top", "right", "Reasignacion completada.", "success");
            $('#Jtabla').DataTable().ajax.reload();
            $('#change_u').modal('hide');
        },
        error: function (data) {
            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
        }
    });
})

$(document).on('click', '#savecs', function (e) {
    e.preventDefault();
    var ubicacion = $("#ubicacion").val();
    var validaUbicacion = ($("#ubicacion").val().trim() == '') ? 0 : 1;
    var dataChange = new FormData();
    dataChange.append("idLote", getInfo4[0]);
    dataChange.append("ubicacion", ubicacion);
    if (validaUbicacion == 0)
        alerts.showNotification("top", "right", "Selecciona una sede.", "danger");
        if (validaUbicacion == 1) {
        $('#savecs').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Juridico/changeUb`,
            data: dataChange,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data) {
                response = JSON.parse(data);
                if (response.message == 'OK') {
                    $('#savecs').prop('disabled', false);
                    $('#change_s').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Sede modificada.", "success");
                } else if (response.message == 'ERROR') {
                    $('#savecs').prop('disabled', false);
                    $('#change_s').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function (data) {
                $('#savecs').prop('disabled', false);
                $('#change_s').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '.barcode', function (e) {
    e.preventDefault();
    var $itself = $(this);
    var nom = $itself.attr('data-lote');
    $("#imgBar").attr("src", `${general_base_url}/main/bikin_barcode/${nom}`);
    $('#imgBar').css('border', '1px dotted black');
    $("#codeB").modal('show');
});

jQuery(document).ready(function () {

    jQuery('#editLoteRev').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario').val('');
    })
    jQuery('#rechReg').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario3').val('');
    })
    jQuery('#rechazoAs').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario4').val('');
    })
    jQuery('#rev8').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario5').val('');
    })
    jQuery('#change_s').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#ubicacion').val(null).trigger('change');
    })
    jQuery('#return1').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario6').val('');
    })
    jQuery('#return2').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario7').val('');
    })
});

