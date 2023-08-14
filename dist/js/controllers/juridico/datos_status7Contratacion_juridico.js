var idlote_global = 0;
var getInfo1 = new Array(7);
var getInfo2 = new Array(7);
var getInfo3 = new Array(7);
var getInfo4 = new Array(7);
var getInfo5 = new Array(7);
var getInfo7 = new Array(7);
var getInfo8 = new Array(7);
var getInfo6 = new Array(1);
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

    user = id_usuario_general
    $.post(general_base_url + "Contraloria/get_sede", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_sede'];
            var name = data[i]['nombre'];
            $("#ubicacion").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#ubicacion").selectpicker('refresh');
    }, 'json');

    $.post(general_base_url + "Juridico/get_users_reassing", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombreUsuario'];
            $("#user_re").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#user_re").selectpicker('refresh');
    }, 'json');
});


$("#proyecto").on('change', function (e) {
    e.preventDefault();
    $("#Cproyecto").removeClass('col-xs-12 col-sm-12 col-md-6 col-lg-6');
    $("#Ccondominio").addClass('hide');
    let idResidencial = $("#proyecto").val();
    console.log(idResidencial);
    if(idResidencial == 27){
        $("#Cproyecto").addClass('col-xs-12 col-sm-12 col-md-6 col-lg-6');
        $("#Ccondominio").removeClass('hide');
        $.post(general_base_url + "Contratacion/lista_condominio/"+idResidencial, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idCondominio'];
            var name = data[i]['nombre'];
            $("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#condominio").selectpicker('refresh');
    }, 'json');
    alerts.showNotification("top", "right", "Seleccione un condominio.", "success");
    }else{
        fillTable(1, 0, 0, idResidencial,0);
        $("#condominio").empty();
        $("#condominio").selectpicker('refresh');
    }
});

$("#condominio").on('change', function (e) {
    e.preventDefault();
    let idResidencial = $("#proyecto").val();
    let condominio = $("#condominio").val();
    if(idResidencial == 27 ){
        fillTable(1, 0, 0, idResidencial,condominio);
    }else{
        $("#condominio").empty();
        $("#condominio").selectpicker('refresh');
    }
});

function fillTable(typeTransaction, beginDate, endDate, idResidencial,condominio){
    tabla_6 = $("#Jtabla").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Registro de clientes',
                title: 'Registro de cilentes',
                exportOptions: {
                    columns: [1,2, 3, 4, 5, 6, 7, 8, 9, 10],
                    format: 
                    {
                        header:  function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                },
            }
        ],
        pagingType: "full_numbers",
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        pageLength: 10,
        bAutoWidth: true,
        fixedColumns: true,
        ordering: true,
        columns: [{
            "className": 'details-control',
            "orderable": false,
            "data": null,
            "defaultContent": '<div class="d-flex justify-center"><div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i></div></div>'
        },
        {
            "data": function (d) {
                return `<span class="label lbl-oceanGreen">${d.tipo_venta}</span>`;
            }
        },
        {
            "data": function (d) {
                if(d.etapa == null){
                    return '<p class="m-0">' + d.nombreResidencial + '</p>' + '<b><p class="m-0">SIN ESPECIFICAR</p></b>';
                } else {
                    return '<p class="m-0">' + d.nombreResidencial + '</p>' + '<b><p class="m-0">' + d.etapa + '</p></b>';
                }
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + (d.nombreCondominio).toUpperCase()+'</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + d.nombreLote + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + d.gerente + '</p>';
            }
        },
        {
            "data": function (d) {
                var nombre = (d.n_cop == 0) ? '<p class="m-0">' + d.nombre + " " + d.apellido_paterno + " " + d.apellido_materno + '</p>' : '<p class="m-0">' + d.nombret + '</p>' + '<p class="m-0">' + d.nombrec + '</p>'
                return nombre;
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + d.modificado.split('.')[0] + '</p>';
            }
        },
        {
            "data": function (d) {
                var fechaVenc;
                if (d.idStatusContratacion == 6 && d.idMovimiento == 23 || d.idStatusContratacion == 6 && d.idMovimiento == 95 ||
                    d.idStatusContratacion == 6 && d.idMovimiento == 97) {
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
            "data": function (d) {
                return '<p class="m-0">' + d.juridico + '</p>';
            }
        },
        {
            data: function( d ){
                return `<span class="label lbl-azure">${d.nombreSede}</span>`;
            }
        },
        {
            "orderable": true,
            "data": function (data) {
                var cntActions;
                if (data.vl == '1') {
                    return 'En proceso de Liberación';
                } else {
                    if (data.idStatusContratacion == 6 && data.idMovimiento == 23 || data.idStatusContratacion == 6 && data.idMovimiento == 95 ||
                        data.idStatusContratacion == 6 && data.idMovimiento == 97 && (data.perfil == 6 || data.perfil == 5 || data.perfil == 32 ||
                            data.perfil == 13 || data.perfil == 7 || data.perfil == 9 || data.perfil == 17 || data.perfil == 3)) {
                        cntActions = '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                            'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' +
                            'class="btn-data btn-green editLoteRev" data-toggle="tooltip" data-placement="top" title="REGISTRAR ESTATUS (VENTAS)">' +
                            '<i class="fas fa-thumbs-up"></i></button>';
                        cntActions += '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                            'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc2 + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' +
                            'class="btn-data btn-warning return1" data-toggle="tooltip" data-placement="top" title="RECHAZAR ESTATUS (CONTRALORÍA)">' +
                            '<i class="fas fa-thumbs-down"></i></button>';
                        cntActions += '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                            'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc2 + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' +
                            'class="btn-data btn-orangeYellow return2" data-toggle="tooltip" data-placement="top" title="RECHAZAR ESTATUS (ASESOR)">' +
                            '<i class="fas fa-thumbs-down"></i></button>';
                        cntActions += '<button href="#" data-toggle="tooltip" data-placement="top" title= "CÓDIGO DE BARRAS" data-lote="' + data.cbbtton + '" ' +
                            'class="btn-data btn-blueMaderas barcode" data-toggle="tooltip" data-placement="top" title="VER CÓDIGO">' +
                            '<i class="fas fa-barcode"></i></button>';
                    } else if (data.idStatusContratacion == 6 && data.idMovimiento == 36 && (data.perfil == 32 || data.perfil == 13 || data.perfil == 17) || data.idStatusContratacion == 6 && data.idMovimiento == 6 && (data.perfil == 32 || data.perfil == 13 || data.perfil == 17) ||
                        data.idStatusContratacion == 7 && data.idMovimiento == 83) {
                        cntActions = '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                            'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' +
                            'class="btn-data btn-green editReg" data-toggle="tooltip" data-placement="top" title="REGISTRAR ESTATUS (VENTAS)">' +
                            '<i class="fas fa-thumbs-up"></i></button>';
                        cntActions += '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                            'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' +
                            'class="btn-data btn-warning cancelReg" data-toggle="tooltip" data-placement="top" data-toggle="tooltip" data-placement="top" title="RECHAZAR ESTATUS (CONTRALORÍA)">' +
                            '<i class="fas fa-thumbs-down"></i></button>';
                        cntActions += '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                            'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' +
                            'class="btn-data btn-orangeYellow cancelAs" data-toggle="tooltip" data-placement="top" title="RECHAZAR ESTATUS (ASESOR)">' +
                            '<i class="fas fa-thumbs-down"></i></button>';
                        cntActions += '<button href="#" data-toggle="tooltip" data-placement="top" title= "CÓDIGO DE BARRAS" data-lote="' + data.cbbtton + '" ' +
                            'class="btn-data btn-blueMaderas barcode" data-toggle="tooltip" data-placement="top" title="VER CÓDIGO">' +
                            '<i class="fas fa-barcode"></i></button>';
                    } else if (data.idStatusContratacion == 6 && data.idMovimiento == 76 || data.idStatusContratacion == 6 && data.idMovimiento == 95 ||
                        data.idStatusContratacion == 6 && data.idMovimiento == 97) {
                        cntActions = '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                            'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc2 + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' +
                            'class="btn-data btn-green editLoteTo8" data-toggle="tooltip" data-placement="top" title="REGISTRAR ESTATUS (VENTAS)">' +
                            '<span class="material-icons">thumb_up</span></button>';
                        cntActions += '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                            'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc2 + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' +
                            'class="btn-data btn-warning btn-secondar return1" data-toggle="tooltip" data-placement="top" title="RECHAZAR ESTATUS (CONTRALORÍA)">' +
                            '<span class="material-icons">thumb_down</span></button>';
                        cntActions += '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                            'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc2 + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' +
                            'class="btn-data btn-orangeYellow btn-inf return2" data-toggle="tooltip" data-placement="top" title="RECHAZAR ESTATUS (ASESOR)">' +
                            '<span class="material-icons">thumb_down</span></button>';
                        cntActions += '<button href="#" data-toggle="tooltip" data-placement="top" title="CÓDIGO DE BARRAS" data-lote="' + data.cbbtton + '" class="btn-data btn-blueMaderas barcode" title="Ver código">' +
                            '<span class="material-icons">select_all</span></button>';
                    } else {
                        cntActions = '';
                    }
                    if (Array(2762, 6096, 6864, 10937, 10938, 12136, 12173, 13015, 2747).includes(user) ){
                        cntActions += '<button href="#" data-toggle="tooltip" data-placement="top" title= "CAMBIO DE SEDE" data-nomLote="' + data.nombreLote + '" data-lote="' + data.idLote + '" class="btn-data btn-gray change_sede"><span class="material-icons">pin_drop</span></button><br>';
                    }
                    if ((Array("2762", "2845", "2747").includes(data.user) || Array(6096, 6864, 10937, 10938, 12136, 12173, 13015).includes(user))) {
                        cntActions += '<button href="#" title= "REASIGNACIÓN" data-nomLote="' + data.nombreLote + '" data-usuario="' + data.juridico + '" data-lote="' + data.idLote + '" class="btn-data btn-warning change_user"><span class="material-icons">find_replace</span></button><br>';
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
            "url": general_base_url + 'Juridico/getStatus7ContratacionJuridico',
            "dataSrc": "",
            "type": "POST",
            cache: false,
            data: {
                "typeTransaction": typeTransaction,
                "beginDate": beginDate,
                "endDate": endDate,
                "idResidencial": idResidencial,
                "idCondominio":condominio
            }
        },
        "order": [[1, 'asc']]
    });

    $('#Jtabla').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}

// Declarar funcion individual donde retorne la fecha URI
function setInitialValues() {
    const fechaInicio = new Date();
    const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
    const fechaFin = new Date();
    const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
    let finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
    let finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');  
    fillTable(0, finalBeginDate, finalEndDate, 0);
}

let titulos = [];
$("#Jtabla").ready(function () {
    $('#Jtabla thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if (tabla_6.column(i).search() !== this.value) {
                tabla_6.column(i).search(this.value).draw();
            }
        });
    });

    setInitialValues();
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

    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }

    if (validaComent == 1) {
        $('#save1').prop('disabled', true);
        $.ajax({
            url: general_base_url + 'Juridico/editar_registro_lote_juridico_proceceso7/',
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

    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }

    if (validaComent == 1) {
        $('#save2').prop('disabled', true);
        $.ajax({
            url: general_base_url + 'Juridico/editar_registro_loteRevision_juridico_proceceso7/',
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

    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }

    if (validaComent == 1) {
        $('#save3').prop('disabled', true);
        $.ajax({
            url: general_base_url + 'Juridico/editar_registro_loteRechazo_juridico_proceceso7/',
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

    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }

    if (validaComent == 1) {

        $('#save4').prop('disabled', true);
        $.ajax({
            url: general_base_url + 'Juridico/sendMailRechazoEst3/',
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

    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }

    if (validaComent == 1) {

        $('#save5').prop('disabled', true);
        $.ajax({
            url: general_base_url + 'Juridico/editar_registro_loteRevision_juridico7_Asistentes8/',
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
        url: general_base_url + 'Juridico/changeUs/',
        data: {user: user, idlote: id},
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
    if (validaUbicacion == 0) {
        alerts.showNotification("top", "right", "Selecciona una sede.", "danger");
    }

    if (validaUbicacion == 1) {
        $('#savecs').prop('disabled', true);
        $.ajax({
            url: general_base_url + 'Juridico/changeUb/',
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

    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }

    if (validaComent == 1) {
        $('#save6').prop('disabled', true);
        $.ajax({
            url: general_base_url + 'Juridico/return1_jac/',
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

    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }

    if (validaComent == 1) {
        $('#save7').prop('disabled', true);
        $.ajax({
            url: general_base_url + 'Juridico/return2_jaa/',
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
    $("#imgBar").attr("src", `${general_base_url}/main/bikin_barcode/` + nom);
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
})