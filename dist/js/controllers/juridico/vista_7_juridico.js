var idlote_global = 0;
var getInfo1 = new Array(7);
var getInfo2 = new Array(7);
var getInfo3 = new Array(7);
var getInfo4 = new Array(7);
var getInfo5 = new Array(7);
var getInfo7 = new Array(7);
var getInfo8 = new Array(7);
var idUsuario = id_usuario_general;

var getInfo6 = new Array(1);
var user, id, usuario;

$(document).ready(function () {
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
            $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if (tabla_6.column(i).search() !== this.value) {
                    tabla_6.column(i).search(this.value).draw();
                }
            });
        }
    });

    tabla_6 = $("#Jtabla").DataTable({
        dom: 'Brt' + "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: 'auto',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'REGISTRO DE ESTATUS 7',
                title: 'REGISTRO DE ESTATUS 7',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                    format: {
                        header: function (d, columnIdx) {
                            if (columnIdx == 0) {
                                return ' ' + d + ' ';
                            }
                            return ' ' + titulos[columnIdx - 1] + ' ';
                        }
                    }
                },
            }
        ],
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
        columns: [
            {
                width: "3%",
                className: 'details-control',
                orderable: false,
                data: null,
                defaultContent: '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
            },
            {
                data: function (d) {
                    return `<span class="label" style="background: #A3E4D7; color: #0E6251">${d.tipo_venta}</span>`;
                }
            },
            {
                data: function (d) {
                    return `<span class='label lbl-violetBoots'>${d.tipo_proceso}</span>`;
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + d.nombreResidencial + '</p>' + '<b><p class="m-0">' + d.etapa + '</p></b>';
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
                    return '<p class="m-0">' + d.modificado + '</p>';
                }
            },
            {
                data: function (d) {
                    var fechaVenc;

                    if (d.idStatusContratacion == 6 && d.idMovimiento == 23 || d.idStatusContratacion == 6 && d.idMovimiento == 95 ||
                        d.idStatusContratacion == 6 && d.idMovimiento == 97 || d.idStatusContratacion == 6 && d.idMovimiento == 112) {
                        fechaVenc = d.fechaVenc2;
                    } else if (d.idStatusContratacion == 6 && d.idMovimiento == 36 || d.idStatusContratacion == 6 && d.idMovimiento == 6 ||
                        d.idStatusContratacion == 7 && d.idMovimiento == 83) {
                        fechaVenc = d.fechaVenc;
                    } else if (d.idStatusContratacion == 6 && d.idMovimiento == 76) {
                        fechaVenc = 'Vencido';
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
                    return `<span class="label" style="background: #A9CCE3; color: #154360">${d.nombreSede}</span>`;
                }
            },
            {
                orderable: false,
                data: function (data) {
                    var cntActions;
                    if (data.vl == '1')
                        return 'En proceso de Liberación';
                    else {
                        if (data.idStatusContratacion == 6 && data.idMovimiento == 23 || data.idStatusContratacion == 6 && data.idMovimiento == 95 || data.idStatusContratacion == 6 && data.idMovimiento == 97) {
                            cntActions = `<center><li><button href="#" data-idLote="${data.idLote}" data-nomLote="${data.nombreLote}" data-idCond="${data.idCondominio}" data-idCliente="${data.id_cliente}" data-fecVen="${data.fechaVenc}" data-ubic="${data.ubicacion}" data-code="${data.cbbtton}" class="btn-data btn-green editLoteRev" title="Registrar estatus (Ventas)"> <i class="fas fa-thumbs-up"></i></button></li><br>`;
                            cntActions += `<li><button href="#" data-idLote="${data.idLote}" data-nomLote="${data.nombreLote}" data-idCond="${data.idCondominio}" data-idCliente="${data.id_cliente}" data-fecVen="${data.fechaVenc2}" data-ubic="${data.ubicacion}" data-code="${data.cbbtton}" class="btn-data btn-warning return1" title="Rechazar estatus (Contraloría)"> <i class="fas fa-thumbs-down"></i></button></li><br>`;
                            cntActions += `<li><button href="#" data-idLote="${data.idLote}" data-nomLote="${data.nombreLote}" data-idCond="${data.idCondominio}" data-idCliente="${data.id_cliente}" data-fecVen="${data.fechaVenc2}" data-ubic="${data.ubicacion}" data-code="${data.cbbtton}" class="btn-data btn-orangeYellow return2" title="Rechazar estatus (Asesor)"> <i class="fas fa-thumbs-down"></i></button></li><br>`;
                            cntActions += `<li><button href="#" title= "Código de barras" data-lote="${data.cbbtton}" class="btn-data btn-blueMaderas barcode" title="Ver código"> <i class="fas fa-barcode"></i></button></li><br></center>`;
                        } else if (data.idStatusContratacion == 6 && data.idMovimiento == 36 || data.idStatusContratacion == 6 && data.idMovimiento == 6 || data.idStatusContratacion == 7 && data.idMovimiento == 83) {
                            cntActions = `<center><li><button href="#" data-idLote="${data.idLote}" data-nomLote="${data.nombreLote}" data-idCond="${data.idCondominio}" data-idCliente="${data.id_cliente}" data-fecVen="${data.fechaVenc}" data-ubic="${data.ubicacion}" data-code="${data.cbbtton}" class="btn-data btn-data btn-green editReg" title="Registrar estatus (ventas)"> <i class="fas fa-thumbs-up"></i></button></li><br>`;
                            cntActions += `<li><button href="#" data-idLote="${data.idLote}" data-nomLote="${data.nombreLote}" data-idCond="${data.idCondominio}" data-idCliente="${data.id_cliente}" data-fecVen="${data.fechaVenc}" data-ubic="${data.ubicacion}" data-code="${data.cbbtton}" class="btn-data btn-warning cancelReg" title="Rechazar estatus (Contraloría)"> <i class="fas fa-thumbs-down"></i></button></li><br>`;
                            cntActions += `<li><button href="#" data-idLote="${data.idLote}" data-nomLote="${data.nombreLote}" data-idCond="${data.idCondominio}" data-idCliente="${data.id_cliente}" data-fecVen="${data.fechaVenc}" data-ubic="${data.ubicacion}" data-code="${data.cbbtton}" class="btn-data btn-orangeYellow cancelAs" title="Rechazar estatus (Asesor)"> <i class="fas fa-thumbs-down"></i></button></li><br>`;
                            cntActions += `<li><button href="#" title= "Código de barras" data-lote="${data.cbbtton}" class="btn-data btn-blueMaderas barcode" title="Ver código"> <i class="fas fa-barcode"></i></button></li><br></center>`;
                        } else if (data.idStatusContratacion == 6 && data.idMovimiento == 76 || data.idStatusContratacion == 6 && data.idMovimiento == 95 || data.idStatusContratacion == 6 && data.idMovimiento == 97) {
                            cntActions = `<li><button href="#" data-idLote="${data.idLote}" data-nomLote="${data.nombreLote}" data-idCond="${data.idCondominio}" data-idCliente="${data.id_cliente}" data-fecVen="${data.fechaVenc2}" data-ubic="${data.ubicacion}" data-code="${data.cbbtton}" class="btn btn-warning btn-round btn-fab btn-fab-mini editLoteTo8" title="Registrar estatus (Ventas)"> <span class="material-icons">thumb_up</span></button></li><br>`;
                            cntActions += `<li><button href="#" data-idLote="${data.idLote}" data-nomLote="${data.nombreLote}" data-idCond="${data.idCondominio}" data-idCliente="${data.id_cliente}" data-fecVen="${data.fechaVenc2}" data-ubic="${data.ubicacion}" data-code="${data.cbbtton}" class="btn btn-secondary btn-round btn-fab btn-fab-mini return1" title="Rechazar estatus (Contraloría)"> <span class="material-icons">thumb_down</span></button></li><br>`
                            cntActions += `<li><button href="#" data-idLote="${data.idLote}" data-nomLote="${data.nombreLote}" data-idCond="${data.idCondominio}" data-idCliente="${data.id_cliente}" data-fecVen="${data.fechaVenc2}" data-ubic="${data.ubicacion}" data-code="${data.cbbtton}" class="btn btn-info btn-round btn-fab btn-fab-mini return2" title="Rechazar estatus (Asesor)"> <span class="material-icons">thumb_down</span></button></li><br>`;
                            cntActions += `<li><button href="#" title= "Código de barras" data-lote="${data.cbbtton}" class="btn btn-primary btn-round btn-fab btn-fab-mini barcode" title="Ver código"> <span class="material-icons">select_all</span></button></li><br>`;
                        } else if (data.idStatusContratacion == 6 && data.idMovimiento == 112) {
                            cntActions = `<li><button href="#" data-idLote="${data.idLote}" data-nomLote="${data.nombreLote}" data-idCond="${data.idCondominio}" data-idCliente="${data.id_cliente}" data-fecVen="${data.fechaVenc2}" data-ubic="${data.ubicacion}" data-code="${data.cbbtton}" class="btn btn-warning btn-round btn-fab btn-fab-mini editLoteTo8" title="Registrar estatus (Ventas)"> <span class="material-icons">thumb_up</span></button></li><br>`;
                            cntActions += `<li><button href="#" data-idLote="${data.idLote}" data-nomLote="${data.nombreLote}" data-idCond="${data.idCondominio}" data-idCliente="${data.id_cliente}" data-fecVen="${data.fechaVenc2}" data-ubic="${data.ubicacion}" data-code="${data.cbbtton}" class="btn btn-secondary btn-round btn-fab btn-fab-mini return1" title="Rechazar estatus (Contraloría)"> <span class="material-icons">thumb_down</span></button></li><br>`;
                            cntActions += `<li><button href="#" data-idLote="${data.idLote}" data-nomLote="${data.nombreLote}" data-idCond="${data.idCondominio}" data-idCliente="${data.id_cliente}" data-fecVen="${data.fechaVenc2}" data-ubic="${data.ubicacion}" data-code="${data.cbbtton}" class="btn btn-info btn-round btn-fab btn-fab-mini return2" title="Rechazar estatus (Asesor)"> <span class="material-icons">thumb_down</span></button></li><br>`;
                            cntActions += `<li><button href="#" title= "Código de barras" data-lote="${data.cbbtton}" class="btn btn-primary btn-round btn-fab btn-fab-mini barcode" title="Ver código"> <span class="material-icons">select_all</span></button></li><br>`;
                        } else
                            cntActions = 'N/A';
                        if (Array(2762, 6096, 6864, 10937, 10938, 12136, 12173, 13015, 2747, 13498, 15041, 15042, 15044).includes(user))
                            cntActions += `<li><button href="#" title= "Cambio de sede" data-nomLote="${data.nombreLote}" data-lote="${data.idLote}" class="btn btn-secondary btn-round btn-fab btn-fab-mini change_sede"><span class="material-icons">pin_drop</span></button></li><br>`;
                        if (Array(1, 2, 4, 5, 3, 12, 15, 16, 6, 8, 13).includes(parseInt(data.ubicacion)) && Array(2762, 2845, 2747, 6096, 6864, 10937, 10938, 12136, 12173, 13015, 13498, 15041, 15042, 15044).includes(user))
                            cntActions += `<li><button href="#" title= "Reasignacion" data-nomLote="${data.nombreLote}" data-usuario="${data.juridico}" data-lote="${data.idLote}" class="btn btn-warning btn-round btn-fab btn-fab-mini change_user"><span class="material-icons">find_replace</span></button></li><br>`;
                        var color = (data.idMovimiento == 36) ? '#58D68D' : (data.idMovimiento == 23) ? '#F39C12' : '#85929E';
                        var label = (data.idMovimiento == 36) ? 'NUEVO' :
                            (data.idMovimiento == 23) ? 'MODIFICACIÓN' : 'REVISIÓN';
                        var btn = `<div class="btn-group"><button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="${label}" style="background: ${color};">Acciones <span class="caret"></span> </button><ul class="dropdown-menu" style="min-width:-webkit-fill-available !important;text-align: center;background: #f5f5f5;">${cntActions}</ul></div>`;
                        return btn;
                    }
                }
            }

        ],
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

    $('#Jtabla tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tabla_6.row(tr);
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        } else {
            var status;
            if (row.data().idStatusContratacion == 6 && row.data().idMovimiento == 36)
                status = "Status 6 listo (Contraloría) ";
            else if (row.data().idStatusContratacion == 6 && row.data().idMovimiento == 6 || row.data().idStatusContratacion == 6 && row.data().idMovimiento == 76 ||
                row.data().idStatusContratacion == 6 && row.data().idMovimiento == 83 || row.data().idStatusContratacion == 6 && row.data().idMovimiento == 95) {
                status = "Status 6 enviado a Revisión (Contraloría)";
            } else if (row.data().idStatusContratacion == 6 && row.data().idMovimiento == 23)
                status = "Status 7 rechazado o enviado para Modificación (Asistentes de Gerentes)";
            else if (row.data().idStatusContratacion == 6 && row.data().idMovimiento == 83 || row.data().idStatusContratacion == 6 && row.data().idMovimiento == 97)
                status = "Status 2 enviado a Revisión (Asesor)";

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
            informacion_adicional += '         <label><b>FECHA APARTADO: </b></label> ' + row.data().fechaApartado;
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
            // $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
        }
    });

    $("#Jtabla tbody").on("click", ".editReg", function (e) {
        e.preventDefault();
        getInfo1[0] = $(this).attr("data-idCliente");
        getInfo1[1] = $(this).attr("data-nombreResidencial");
        getInfo1[2] = $(this).attr("data-nombreCondominio");
        getInfo1[3] = $(this).attr("data-idcond");
        getInfo1[4] = $(this).attr("data-nomlote");
        getInfo1[5] = $(this).attr("data-idLote");
        getInfo1[6] = $(this).attr("data-fecven");
        getInfo1[7] = $(this).attr("data-code");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#editReg').modal('show');
    });

    $("#Jtabla tbody").on("click", ".editLoteRev", function (e) {
        e.preventDefault();
        getInfo2[0] = $(this).attr("data-idCliente");
        getInfo2[1] = $(this).attr("data-nombreResidencial");
        getInfo2[2] = $(this).attr("data-nombreCondominio");
        getInfo2[3] = $(this).attr("data-idcond");
        getInfo2[4] = $(this).attr("data-nomlote");
        getInfo2[5] = $(this).attr("data-idLote");
        getInfo2[6] = $(this).attr("data-fecven");
        getInfo2[7] = $(this).attr("data-code");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#editLoteRev').modal('show');
    });

    $("#Jtabla tbody").on("click", ".cancelReg", function (e) {
        e.preventDefault();
        getInfo3[0] = $(this).attr("data-idCliente");
        getInfo3[1] = $(this).attr("data-nombreResidencial");
        getInfo3[2] = $(this).attr("data-nombreCondominio");
        getInfo3[3] = $(this).attr("data-idcond");
        getInfo3[4] = $(this).attr("data-nomlote");
        getInfo3[5] = $(this).attr("data-idLote");
        getInfo3[6] = $(this).attr("data-fecven");
        getInfo3[7] = $(this).attr("data-code");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#rechReg').modal('show');
    });

    $("#Jtabla tbody").on("click", ".cancelAs", function (e) {
        e.preventDefault();
        getInfo4[0] = $(this).attr("data-idCliente");
        getInfo4[1] = $(this).attr("data-nombreResidencial");
        getInfo4[2] = $(this).attr("data-nombreCondominio");
        getInfo4[3] = $(this).attr("data-idcond");
        getInfo4[4] = $(this).attr("data-nomlote");
        getInfo4[5] = $(this).attr("data-idLote");
        getInfo4[6] = $(this).attr("data-fecven");
        getInfo4[7] = $(this).attr("data-code");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#rechazoAs').modal('show');
    });

    $("#Jtabla tbody").on("click", ".editLoteTo8", function (e) {
        e.preventDefault();
        getInfo5[0] = $(this).attr("data-idCliente");
        getInfo5[1] = $(this).attr("data-nombreResidencial");
        getInfo5[2] = $(this).attr("data-nombreCondominio");
        getInfo5[3] = $(this).attr("data-idcond");
        getInfo5[4] = $(this).attr("data-nomlote");
        getInfo5[5] = $(this).attr("data-idLote");
        getInfo5[6] = $(this).attr("data-fecven");
        getInfo5[7] = $(this).attr("data-code");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#rev8').modal('show');
    });


    $("#Jtabla tbody").on("click", ".change_sede", function (e) {
        e.preventDefault();
        getInfo6[0] = $(this).attr("data-lote");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#change_s').modal('show');
    });

    $("#Jtabla tbody").on("click", ".change_user", function (e) {
        e.preventDefault();
        id = $(this).attr("data-lote");
        nombreLote = $(this).data("nomlote");
        usuario = $(this).attr("data-usuario");
        // $(".lote").html(nombreLote);
        $(".userJ").html(usuario);
        $('#change_u').modal('show');
    });

    $("#Jtabla tbody").on("click", ".return1", function (e) {
        e.preventDefault();
        getInfo7[0] = $(this).attr("data-idCliente");
        getInfo7[1] = $(this).attr("data-nombreResidencial");
        getInfo7[2] = $(this).attr("data-nombreCondominio");
        getInfo7[3] = $(this).attr("data-idcond");
        getInfo7[4] = $(this).attr("data-nomlote");
        getInfo7[5] = $(this).attr("data-idLote");
        getInfo7[6] = $(this).attr("data-fecven");
        getInfo7[7] = $(this).attr("data-code");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#return1').modal('show');
    });

    $("#Jtabla tbody").on("click", ".return2", function (e) {
        e.preventDefault();
        getInfo8[0] = $(this).attr("data-idCliente");
        getInfo8[1] = $(this).attr("data-nombreResidencial");
        getInfo8[2] = $(this).attr("data-nombreCondominio");
        getInfo8[3] = $(this).attr("data-idcond");
        getInfo8[4] = $(this).attr("data-nomlote");
        getInfo8[5] = $(this).attr("data-idLote");
        getInfo8[6] = $(this).attr("data-fecven");
        getInfo8[7] = $(this).attr("data-code");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#return2').modal('show');
    });
});

$(document).on('click', '#save1', function (e) {
    e.preventDefault();
    var comentario = $("#comentario").val();
    var validaComent = ($("#comentario").val().length == 0) ? 0 : 1;
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
    console.log($("#comentario").val());

    if (validaComent == 0)
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");

    if (validaComent == 1) {
        $('#save1').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Juridico/editar_registro_lote_juridico_proceceso7`,
            data: dataExp1,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data) {
                response = JSON.parse(data);
                if (response.message == 'OK') {
                    $('#save1').prop('disabled', false);
                    $('#editReg').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if (response.message == 'FALSE') {
                    $('#save1').prop('disabled', false);
                    $('#editReg').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if (response.message == 'ERROR') {
                    $('#save1').prop('disabled', false);
                    $('#editReg').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                } else if (response.message == 'DOCUMENTS') {
                    $('#save1').prop('disabled', false);
                    $('#editReg').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", response.documentos, "danger");
                }
            },
            error: function (data) {
                $('#save1').prop('disabled', false);
                $('#editReg').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save2', function (e) {
    e.preventDefault();
    var comentario = $("#comentario2").val();
    var validaComent = ($("#comentario2").val().length == 0) ? 0 : 1;
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
    if (validaComent == 0)
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");

    if (validaComent == 1) {
        $('#save2').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Juridico/editar_registro_loteRevision_juridico_proceceso7`,
            data: dataExp2,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data) {
                response = JSON.parse(data);

                if (response.message == 'OK') {
                    $('#save2').prop('disabled', false);
                    $('#editLoteRev').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if (response.message == 'FALSE') {
                    $('#save2').prop('disabled', false);
                    $('#editLoteRev').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if (response.message == 'ERROR') {
                    $('#save2').prop('disabled', false);
                    $('#editLoteRev').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                } else if (response.message == 'DOCUMENTS') {
                    $('#save1').prop('disabled', false);
                    $('#editReg').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", response.documentos, "danger");
                }
            },
            error: function (data) {
                $('#save2').prop('disabled', false);
                $('#editLoteRev').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save3', function (e) {
    e.preventDefault();
    var comentario = $("#comentario3").val();
    var validaComent = ($("#comentario3").val().length == 0) ? 0 : 1;
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
    if (validaComent == 0)
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");

    if (validaComent == 1) {
        $('#save3').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Juridico/editar_registro_loteRechazo_juridico_proceceso7`,
            data: dataExp3,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data) {
                response = JSON.parse(data);
                if (response.message == 'OK') {
                    $('#save3').prop('disabled', false);
                    $('#rechReg').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if (response.message == 'FALSE') {
                    $('#save3').prop('disabled', false);
                    $('#rechReg').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if (response.message == 'ERROR') {
                    $('#save3').prop('disabled', false);
                    $('#rechReg').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function (data) {
                $('#save3').prop('disabled', false);
                $('#rechReg').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save4', function (e) {
    e.preventDefault();
    var comentario = $("#comentario4").val();
    var validaComent = ($("#comentario4").val().length == 0) ? 0 : 1;
    var dataExp4 = new FormData();
    dataExp4.append("idCliente", getInfo4[0]);
    dataExp4.append("nombreResidencial", getInfo4[1]);
    dataExp4.append("nombreCondominio", getInfo4[2]);
    dataExp4.append("idCondominio", getInfo4[3]);
    dataExp4.append("nombreLote", getInfo4[4]);
    dataExp4.append("idLote", getInfo4[5]);
    dataExp4.append("comentario", comentario);
    dataExp4.append("fechaVenc", getInfo4[6]);
    dataExp4.append("numContrato", getInfo4[7]);
    if (validaComent == 0)
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");

    if (validaComent == 1) {
        $('#save4').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Juridico/sendMailRechazoEst3`,
            data: dataExp4,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data) {
                response = JSON.parse(data);
                if (response.message == 'OK') {
                    $('#save4').prop('disabled', false);
                    $('#rechazoAs').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if (response.message == 'FALSE') {
                    $('#save4').prop('disabled', false);
                    $('#rechazoAs').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if (response.message == 'ERROR') {
                    $('#save4').prop('disabled', false);
                    $('#rechazoAs').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function (data) {
                $('#save4').prop('disabled', false);
                $('#rechazoAs').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save5', function (e) {
    e.preventDefault();
    var comentario = $("#comentario5").val();
    var validaComent = ($("#comentario5").val().length == 0) ? 0 : 1;
    var dataExp5 = new FormData();
    dataExp5.append("idCliente", getInfo5[0]);
    dataExp5.append("nombreResidencial", getInfo5[1]);
    dataExp5.append("nombreCondominio", getInfo5[2]);
    dataExp5.append("idCondominio", getInfo5[3]);
    dataExp5.append("nombreLote", getInfo5[4]);
    dataExp5.append("idLote", getInfo5[5]);
    dataExp5.append("comentario", comentario);
    dataExp5.append("fechaVenc", getInfo5[6]);
    dataExp5.append("numContrato", getInfo5[7]);
    if (validaComent == 0)
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");

    if (validaComent == 1) {
        $('#save5').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Juridico/editar_registro_loteRevision_juridico7_Asistentes8`,
            data: dataExp5,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data) {
                response = JSON.parse(data);
                if (response.message == 'OK') {
                    $('#save5').prop('disabled', false);
                    $('#rev8').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if (response.message == 'FALSE') {
                    $('#save5').prop('disabled', false);
                    $('#rev8').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if (response.message == 'ERROR') {
                    $('#save5').prop('disabled', false);
                    $('#rev8').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                } else if (response.message == 'DOCUMENTS') {
                    $('#save1').prop('disabled', false);
                    $('#editReg').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", response.documentos, "danger");
                }
            },
            error: function (data) {
                $('#save5').prop('disabled', false);
                $('#rev8').modal('hide');
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
    dataChange.append("idLote", getInfo6[0]);
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

$(document).on('click', '#save6', function (e) {
    e.preventDefault();
    var comentario = $("#comentario6").val();
    var validaComent = ($("#comentario6").val().length == 0) ? 0 : 1;
    var dataExp6 = new FormData();
    dataExp6.append("idCliente", getInfo7[0]);
    dataExp6.append("nombreResidencial", getInfo7[1]);
    dataExp6.append("nombreCondominio", getInfo7[2]);
    dataExp6.append("idCondominio", getInfo7[3]);
    dataExp6.append("nombreLote", getInfo7[4]);
    dataExp6.append("idLote", getInfo7[5]);
    dataExp6.append("comentario", comentario);
    dataExp6.append("fechaVenc", getInfo7[6]);
    dataExp6.append("numContrato", getInfo7[7]);
    if (validaComent == 0)
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");

    if (validaComent == 1) {
        $('#save6').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Juridico/return1_jac`,
            data: dataExp6,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data) {
                response = JSON.parse(data);
                if (response.message == 'OK') {
                    $('#save6').prop('disabled', false);
                    $('#return1').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if (response.message == 'FALSE') {
                    $('#save6').prop('disabled', false);
                    $('#return1').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if (response.message == 'ERROR') {
                    $('#save6').prop('disabled', false);
                    $('#return1').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function (data) {
                $('#save6').prop('disabled', false);
                $('#return1').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save7', function (e) {
    e.preventDefault();
    var comentario = $("#comentario7").val();
    var validaComent = ($("#comentario7").val().length == 0) ? 0 : 1;
    var dataExp7 = new FormData();
    dataExp7.append("idCliente", getInfo8[0]);
    dataExp7.append("nombreResidencial", getInfo8[1]);
    dataExp7.append("nombreCondominio", getInfo8[2]);
    dataExp7.append("idCondominio", getInfo8[3]);
    dataExp7.append("nombreLote", getInfo8[4]);
    dataExp7.append("idLote", getInfo8[5]);
    dataExp7.append("comentario", comentario);
    dataExp7.append("fechaVenc", getInfo8[6]);
    dataExp7.append("numContrato", getInfo8[7]);
    if (validaComent == 0)
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");

    if (validaComent == 1) {
        $('#save7').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Juridico/return2_jaa`,
            data: dataExp7,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data) {
                response = JSON.parse(data);
                if (response.message == 'OK') {
                    $('#save7').prop('disabled', false);
                    $('#return2').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if (response.message == 'FALSE') {
                    $('#save7').prop('disabled', false);
                    $('#return2').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if (response.message == 'ERROR') {
                    $('#save7').prop('disabled', false);
                    $('#return2').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function (data) {
                $('#save7').prop('disabled', false);
                $('#return2').modal('hide');
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

    jQuery('#editReg').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario').val('');
    })

    jQuery('#editLoteRev').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario2').val('');
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

