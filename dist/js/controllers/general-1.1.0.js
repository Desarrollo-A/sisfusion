$(document).ready(function() {

    $(".select-is-empty").removeClass("is-empty");

    $("#myselectgerente").empty().selectpicker('refresh');
    $("#myselectgerente2").empty().selectpicker('refresh');
    $("#subdirectorSelect").empty().selectpicker('refresh');
    $("#myselectasesor").empty().selectpicker('refresh');
    $("#prospecto").empty().selectpicker('refresh');
    $("#asesor").empty().selectpicker('refresh');
    $("#kinship").empty().selectpicker('refresh');


    // Set options for subdirectorSelect
    $.post('getResidencialDisponible', function(data) {
        $("#proyecto").append($('<option disabled>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            var abbreviation = data[i]['nombreResidencial'];
            $("#proyecto").append($('<option>').val(id).attr('data-abbreviation', abbreviation).text(name));
        }
        if (len <= 0) {
            $("#proyecto").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#proyecto").selectpicker('refresh');
    }, 'json');

    // Set options for subdirectorSelect
    $.post('getSubdirectories', function(data) {
        $("#subdirectorSelect").append($('<option disabled>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#subdirectorSelect").append($('<option>').val(id).attr('data-sede', sede).text(name));
        }
        if (len <= 0) {
            $("#subdirectorSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#subdirectorSelect").selectpicker('refresh');
    }, 'json');

    $.getJSON("getCAPListByAdvisor").done(function(data) {
        $("#specify_recommends").append($('<option>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            var type = data[i]['tipo'];
            $("#specify_recommends").append($('<option>').val(id).attr('data-type', type).text(name));
        }
    });

    // Set options for myselectgerente
    $.post('getManagersMktd', function(data) {
        $("#myselectgerente").append($('<option disabled>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#myselectgerente").append($('<option>').val(id).attr('data-sede', sede).text(name));
        }
        if (len <= 0) {
            $("#myselectgerente").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#myselectgerente").selectpicker('refresh');
    }, 'json');

    $.post('getManagers', function(data) {
        $("#myselectgerente2").append($('<option disabled>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#myselectgerente2").append($('<option>').val(id).attr('data-sede', sede).text(name));
        }
        if (len <= 0) {
            $("#myselectgerente2").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#myselectgerente2").selectpicker('refresh');
    }, 'json');

    // Set options for kinship
    $.post('getKinship', function(data) {
        $("#kinship").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#kinship").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#kinship").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#kinship").selectpicker('refresh');
    }, 'json');

    // Set options for kinship_ed
    $.post('getKinship', function(data) {
        $("#kinship_ed").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#kinship_ed").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#kinship_ed").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#kinship_ed").selectpicker('refresh');
    }, 'json');

    // Set options for prospecto
    $.post('getProspects', function(data) {
        $("#prospecto").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_prospecto'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#prospecto").append($('<option>').val(id).attr('data-sede', sede).text(name));
        }
        if (len <= 0) {
            $("#prospecto").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#prospecto").selectpicker('refresh');
    }, 'json');

    $.post('getStatusMktd', function(data) {
        $("#estatus_particular").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#estatus_particular").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#estatus_particular").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#estatus_particular").selectpicker('refresh');
    }, 'json');


    // Set options for prospecto_ed
    $.post('getProspects', function(data) {
        $("#prospecto_ed").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_prospecto'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#prospecto_ed").append($('<option>').val(id).attr('data-sede', sede).text(name));
        }
        if (len <= 0) {
            $("#prospecto_ed").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#prospecto_ed").selectpicker('refresh');
    }, 'json');

    // Set options for asesor
    $.post('getAllAdvisers', function(data) {
        $("#asesor").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_asesor'];
            var name = data[i]['nombre_asesor'];
            var coordinador = data[i]['id_coordinador'];
            var gerente = data[i]['id_gerente'];
            $("#asesor").append($('<option>').val(id).attr({ "data-coordinador": coordinador, "data-gerente": gerente }).text(name));
            // $("#asesor").append($('<option>').val(id).attr({'data-coordinador': coordinador, 'data-gerente': gerente}).text(name));
        }
        if (len <= 0) {
            $("#asesor").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#asesor").selectpicker('refresh');
    }, 'json');

    $.post('getAdvisersM', function(data) {
        $("#myselectasesor2").append($('<option disabled>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#myselectasesor2").append($('<option>').val(id).attr('data-sede', sede).text(name));
        }
        if (len <= 0) {
            $("#myselectasesor2").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#myselectasesor2").selectpicker('refresh');
    }, 'json');

    // Fill the select of prospecting places
    $.getJSON("getProspectingPlaces").done(function(data) {
        $(".prospecting_place").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            if (id == 6 || id == 31) { // SON LOS DOS LP DE MKTD
                $(".prospecting_place").append($('<option>').val(id).text(name).addClass("boldtext"));
            } else { // SON OTROS LP
                $(".prospecting_place").append($('<option>').val(id).text(name));
            }
        }
    });

    // Fill the select of nationality
    $.getJSON("getNationality").done(function(data) {
        $(".nationality").append($('<option disabled selected>').val("").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $(".nationality").append($('<option>').val(id).text(name));
        }
    });

    // Fill the select of legal personality
    $.getJSON("getLegalPersonality").done(function(data) {
        $(".legal_personality").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $(".legal_personality").append($('<option>').val(id).text(name));
        }
    });

    // Fill the select of advertising
    $.getJSON("getAdvertising").done(function(data) {
        $(".advertising").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $(".advertising").append($('<option>').val(id).text(name));
        }
    });

    // Fill the select of sales plaza
    $.getJSON("getSalesPlaza").done(function(data) {
        $(".sales_plaza").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $(".sales_plaza").append($('<option>').val(id).text(name));
        }
    });

    // Fill the select of civil status
    $.getJSON("getCivilStatus").done(function(data) {
        $(".civil_status").append($('<option selected="true">').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $(".civil_status").append($('<option>').val(id).text(name));
        }
    });

    // Fill the select of matrimonial regime
    $.getJSON("getMatrimonialRegime").done(function(data) {
        $(".matrimonial_regime").append($('<option selected="true">').val("5").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $(".matrimonial_regime").append($('<option>').val(id).text(name));
        }
    });

    // Fill the select of state
    $.getJSON("getState").done(function(data) {
        $(".state").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_estado'];
            var name = data[i]['nombre'];
            $(".state").append($('<option>').val(id).text(name));
        }
        //$("#state").selectpicker('refresh');;
    });

    $referencesTable = $('#references-datatable').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        destroy: true,
        columns: [{
                data: function(d) {
                    if (d.estatus == 1) {
                        return '<center><span class="label label-danger" style="background:#27AE60">Activo</span><center>';
                    } else {
                        return '<center><span class="label label-danger" style="background:#E74C3C">Inactivo</span><center>';
                    }
                }
            },
            {
                data: function(d) {
                    return d.nombre_prospecto;
                }
            },
            {
                data: function(d) {
                    return d.nombre;
                }
            },
            {
                data: function(d) {
                    return d.telefono;
                }
            },
            {
                data: function(d) {
                    return d.parentesco;
                }
            },
            {
                data: function(d) {
                    return d.fecha_creacion;
                }
            },
            {
                data: function(d) {
                    if (d.estatus == 1) {
                        return '<button class="btn btn-success btn-round btn-fab btn-fab-mini edit-reference-information" data-id-referencia="' + d.id_referencia + '" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;background-color:#2874A6;border-color:#21618C"><i class="material-icons">edit</i></button>' +
                            '<button class="btn btn btn-round btn-fab btn-fab-mini change-reference-status" data-estatus="0" data-id-referencia="' + d.id_referencia + '" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;background-color:#27AE60;border-color:#27AE60"><i class="material-icons">lock_open</i></button>';
                    } else {
                        return '<button class="btn btn-success btn-round btn-fab btn-fab-mini edit-reference-information" data-id-referencia="' + d.id_referencia + '" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;background-color:#2874A6;border-color:#21618C"><i class="material-icons">edit</i></button>' +
                            '<button class="btn btn btn-round btn-fab btn-fab-mini change-reference-status" data-estatus="1" data-id-referencia="' + d.id_referencia + '" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;background-color:#E74C3C;border-color:#E74C3C"><i class="material-icons">lock</i></button>';
                    }
                }
            }
        ],
        "ajax": {
            "url": "getReferencesList",
            "type": "POST",
            cache: false,
            "data": function(d) {}
        }
    });

    $sharedSalesTable = $('#shared-sales-datatable').DataTable({
        "pagingType": "full_numbers",
        // "dom": "Bfrtip",
        // "buttons": [
        //     {
        //         // extend: 'copyHtml5',
        //         text: '<button class="btn btn-success">Success</button>',
        //         titleAttr: 'Agregar'
        //     }
        // ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        destroy: true,
        columns: [{
                data: function(d) {
                    if (d.estatus == 1) {
                        return '<center><span class="label label-danger" style="background:#27AE60">Activo</span><center>';
                    } else {
                        return '<center><span class="label label-danger" style="background:#E74C3C">Inactivo</span><center>';
                    }
                }
            },
            {
                data: function(d) {
                    return d.nombre_prospecto;
                }
            },
            {
                data: function(d) {
                    return d.nombre_asesor;
                }
            },
            {
                data: function(d) {
                    return d.nombre_coordinador;
                }
            },
            {
                data: function(d) {
                    return d.nombre_gerente;
                }
            },
            {
                data: function(d) {
                    return d.fecha_creacion;
                }
            },
            {
                data: function(d) {
                    if (d.estatus == 1) {
                        return '<button class="btn btn btn-round btn-fab btn-fab-mini change-status" data-estatus="0" data-id-vcompartida="' + d.id_vcompartida + '" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;background-color:#27AE60;border-color:#27AE60"><i class="material-icons">lock_open</i></button>';
                    } else {
                        return '<button class="btn btn btn-round btn-fab btn-fab-mini change-status" data-estatus="1" data-id-vcompartida="' + d.id_vcompartida + '" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;background-color:#E74C3C;border-color:#E74C3C"><i class="material-icons">lock</i></button>';
                    }
                }
            }
        ],
        "ajax": {
            "url": "getSharedSalesList",
            "type": "POST",
            cache: false,
            "data": function(d) {}
        }
    });

    $usersTable = $('#clients-datatable').DataTable({
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            /*url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"*/
            "url": "../../static/spanishLoader.json"
        },
        destroy: true,
        columns: [{
                data: function(d) {
                    return d.nombre;
                }
            },
            {
                data: function(d) {
                    return d.correo;
                }
            },
            {
                data: function(d) {
                    return d.telefono;
                }
            },
            {
                data: function(d) {
                    return d.lp;
                }
            },
            {
                data: function(d) {
                    return d.asesor;
                }
            },
            {
                data: function(d) {
                    return d.coordinador;
                }
            },
            {
                data: function(d) {
                    return d.gerente;
                }
            },
            {
                data: function(d) {
                    return d.fecha_creacion;
                }
            },
            {
                data: function(d) {
                    return d.fecha_cliente;
                }
            },
            {
                data: function(d) {
                    if (idUser != d.id_asesor && d.lugar_prospeccion == 6 && userType != 19 && userType != 20) { // NO ES ASESORY EL REGISTRO ES DE MKTD QUITO EL BOTÓN DE VER
                        return '';
                    } else { // ES EL ASESOR DEL EXPEDIENTE O ES UN GERENTE O SUBIDIRECTOR DE MKTD QUIEN CONSULTA
                        return '<button class="btn btn btn-round btn-fab btn-fab-mini see-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;" rel="tooltip" data-placement="left" title="Ver información"><i class="material-icons">remove_red_eye</i></button>';
                    }
                }
            }
        ],
        "ajax": {
            "url": "getClientsList",
            "type": "POST",
            cache: false,
            "data": function(d) {}
        }
    });


    /*--------------*/


    $('#prospects-datatable thead tr:eq(0) th').each(function(i) {

         if(i != 9){
        var title = $(this).text();
        $(this).html('<input type="text" style="text-align: center; width:100%; background:#003D82; color:white; border: 0; font-weight: 500;" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function() {
            if (prospectsTable.column(i).search() !== this.value) {
                prospectsTable
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
        }
    });
    /*---INPUT SEARCH-----*/


    prospectsTable = $('#prospects-datatable').DataTable({
        // dom: "<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-end p-0'l>rt><'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: 'auto',
          buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Listado general de prospectos' ,
            title: 'Listado general de prospectos'  ,
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                format: {
                    header: function (d, columnIdx) {
                        switch (columnIdx) {
                            case 0:
                                return 'ESTADO';
                            case 1:
                                return 'ETAPA';
                            case 2:
                                return 'PROSPECTO';
                            case 3:
                                return 'ASESOR';
                            case 4:
                                return 'GERENTE';
                            case 5:
                                return 'SUBDIRECTOR';
                            case 6:
                                return 'LP';
                            case 7:
                                return 'CREACIÓN';
                            case 8:
                                return 'VENCIMIENTO';
                        }
                    }
                }
            }
        }],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        "language": {
            "url": "../../static/spanishLoader.json"
        },
        destroy: true,
        ordering: true,
        columns: [
            // {
            //     "className": "details-control",
            //     "orderable": false,
            //     "data": null,
            //     "defaultContent": '<i class="material-icons" style="color: #003d82;" title="Click aquí para más detalles">add_circle</i>'
            // },
            {
                data: function(d) {
                    if (d.estatus == 1) {
                        return '<center><span class="label label-danger" style="background:#27AE60">Vigente</span><center>';
                    } else {
                        return '<center><span class="label label-danger" style="background:#E74C3C">Sin vigencia</span><center>';
                    }
                }

            },
            {
                data: function(d) {

                    if (d.estatus_particular == 1) { // DESCARTADO
                        b = '<center><span class="label" style="background:#E74C3C">Descartado</span><center>';
                    } else if (d.estatus_particular == 2) { // INTERESADO SIN CITA
                        b = '<center><span class="label" style="background:#B7950B">Interesado sin cita</span><center>';
                    } else if (d.estatus_particular == 3) { // CON CITA
                        b = '<center><span class="label" style="background:#27AE60">Con cita</span><center>';
                    } else if (d.estatus_particular == 4) { // SIN ESPECIFICAR
                        b = '<center><span class="label" style="background:#5D6D7E">Sin especificar</span><center>';
                    } else if (d.estatus_particular == 5) { // PAUSADO
                        b = '<center><span class="label" style="background:#2E86C1">Pausado</span><center>';
                    } else if (d.estatus_particular == 6) { // PREVENTA
                        b = '<center><span class="label" style="background:#8A1350">Preventa</span><center>';
                    } else if (d.estatus_particular == 7) { // CLIENTE
                        b = '<center><span class="label" style="background:#27AE60">Cliente</span><center>';
                    } else { // CLIENTE
                        b = '<center><span class="label" style="background:#A569BD">Sin especificar</span><center>';
                    }
                    return b;
                }
            },
            {
                data: function(d) {
                    return d.nombre + '<br>' +'<span class="label" style="background:#1ABC9C">'+ d.id_prospecto +'</span>';
                }
            },
            {
                data: function(d) {
                    return d.asesor;
                }
            },
            {
                data: function(d) {
                    return d.coordinador;
                }
            },
            {
                data: function(d) {
                    return d.gerente;
                }
            },
            {
                data: function(d) {
                    return d.nombre_lp;
                }
            },
            {
                data: function(d) {
                    return d.fecha_creacion;
                }
            },
            {
                data: function(d) {
                    return d.fecha_vencimiento;
                }
            },
            {
                data: function(d) {
                    if (typeTransaction == 0) { // Marketing
                        if (userType == "18" || userType == "19" || userType == "20") { // Array de roles permitidos para reasignar
                            userType == "20" ? change_buttons = '<center><button class="btn-data btn-warning change-pl" data-id-prospecto="' + d.id_prospecto +'" style="margin-right: 3px" rel="tooltip" data-placement="left" title="Remover MKTD de este prospecto"><i class="fas fa-trash"></i></button></center>' : change_buttons = '';
                            if (d.estatus == 1) { // IS ACTIVE
                                var actions = '';
                                var group_buttons = '';
                                group_buttons += '<button class="btn-data btn-orangeYellow  to-comment" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px" rel="tooltip" data-placement="left" title="Ingresar comentario"><i class="fas fa-comment-alt"></i></button>' +
                                    '<button class="btn-data btn-blueMaderas edit-information" data-id-prospecto="' + d.id_prospecto + '"  rel="tooltip" data-placement="left" title="Editar información"><i class="fas fa-pencil-alt"></i></button>' +
                                    '<button class="btn-data btn-details-grey see-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;" rel="tooltip" data-placement="left" title="Ver información"><i class="fas fa-eye"></i></button>' +
                                    '<button class="btn-data btn-details-violet re-asign" data-id-prospecto="' + d.id_prospecto + '"  rel="tooltip" data-placement="left" title="Re - asignar"><i class="fas fa-exchange-alt"></i></button>';

                                actions += '<center><button style="margin-right: 3px;" class="desplegable btn-data btn-details-grey" id="btn_' + d.id_prospecto + '" onclick="javascript: $(this).addClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').removeClass(\'hide\'); "><span class="fas fa-chevron-up"></span></button></center>';
                                actions += '<center><div class="hide" id="cnt_' + d.id_prospecto + '">' + group_buttons + '<br><br><button style="margin-right: 3px;" onclick="javascript: $(\'#btn_' + d.id_prospecto + '\').removeClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').addClass(\'hide\'); " class="btn-data btn-details-grey"><span class="fas fa-chevron-down"></span></button></div></center>';
                                actions += '<center><button class="btn-data btn-details-grey-black update-status" data-id-prospecto="' + d.id_prospecto + '"><i class="fas fa-redo" title="Actualizar estatus"></i></button></center>' + change_buttons;
                                return actions;
                            } else { // IS NOT ACTIVE
                                var actions = '';
                                if (d.vigencia >= 0 /*< 5 && d.fecha_creacion >= '2021-04-19 23:59:59.000'*/) {
                                	// actions += '<button class="btn btn btn-round btn-fab btn-fab-mini update-validity" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;background-color:#CB4335;border-color:#4cae4c" rel="tooltip" data-placement="left" title="Renovar vigencia"><i class="material-icons">update</i></button>';
                                    actions += '<center><button class="btn-data btn-warning update-validity" data-id-prospecto="' + d.id_prospecto + '"  rel="tooltip" data-placement="left" title="Renovar vigencia"><i class="fas fa-retweet"></i></button></center>';

                                }
                                actions += change_buttons;
                                return actions;
                            }
                        }
                    } else if (typeTransaction == 1) { // Ventas
                        if (userType != "19") { // Subdirecctor MKTD puede ver listado todos los prospectos pero no tiene ninguna acción sobre ellos
                            if (userType == "3" || userType == "6") { // Array de roles permitidos para reasignar
                                if (d.estatus == 1) {
                                    var actions = '';
                                    var group_buttons = '';
                                    if (idUser != d.id_asesor && d.lugar_prospeccion == 6) { // NO ES ASESOR Y EL REGISTRO ES DE MKTD QUITO EL BOTÓN DE VER
                                        actions = '';
                                    } else { // ES ASESOR Y EL REGISTRO ES DE MKTD - DEJO EL BOTÓN DE VER
                                         group_buttons = '<button class="btn btn-warning btn-round btn-fab btn-fab-mini to-comment" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px" rel="tooltip" data-placement="left" title="Ingresar comentario"><i class="material-icons">comment</i></button>' +
                                            '<button class="btn btn-success btn-round btn-fab btn-fab-mini edit-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;background-color:#2874A6;border-color:#21618C" rel="tooltip" data-placement="left" title="Editar información"><i class="material-icons">edit</i></button>' +
                                            '<button class="btn btn btn-round btn-fab btn-fab-mini see-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;" rel="tooltip" data-placement="left" title="Ver información"><i class="material-icons">remove_red_eye</i></button>' +
                                            '<button class="btn btn btn-round btn-fab btn-fab-mini re-asign" data-id-prospecto="' + d.id_prospecto + '" style="background-color:#884EA0;border-color:#884EA0" rel="tooltip" data-placement="left" title="Re - asignar"><i class="material-icons">transform</i></button>';
                                        actions += '<button style="margin-right: 3px;" class="desplegable btn btn btn-round btn-fab btn-fab-mini" id="btn_' + d.id_prospecto + '" onclick="javascript: $(this).addClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').removeClass(\'hide\'); "><span class="material-icons">keyboard_arrow_up</span></button>';
                                        actions += '<div class="hide" id="cnt_' + d.id_prospecto + '">' + group_buttons + '<br><br><button style="margin-right: 3px;" onclick="javascript: $(\'#btn_' + d.id_prospecto + '\').removeClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').addClass(\'hide\'); " class="btn btn btn-round btn-fab btn-fab-mini" style="background-color: orangered"><span class="material-icons">keyboard_arrow_down</span></button></div>';
                                        actions += '<button class="btn btn-success btn-round btn-fab btn-fab-mini update-status" data-id-prospecto="' + d.id_prospecto + '" style="background-color:#2C3E50;border-color:#2C3E50"><i class="material-icons" title="Actualizar estatus">refresh</i></button>';
                                    }


                                    return actions;
                                } else {
                                    var actions = '';
                                    var group_buttons = '';
                                    if (idUser != d.id_asesor && d.lugar_prospeccion == 6) { // NO ES ASESOR Y EL REGISTRO ES DE MKTD QUITO EL BOTÓN DE VER
                                        actions = '';
                                    } else { // ES ASESOR Y EL REGISTRO ES DE MKTD - DEJO EL BOTÓN DE VER
                                         group_buttons = '<button class="btn btn-warning btn-round btn-fab btn-fab-mini to-comment" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px" rel="tooltip" data-placement="left" title="Ingresar comentario"><i class="material-icons">comment</i></button>' +
                                            '<button class="btn btn-success btn-round btn-fab btn-fab-mini edit-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;background-color:#2874A6;border-color:#21618C" rel="tooltip" data-placement="left" title="Editar información"><i class="material-icons">edit</i></button>' +
                                            '<button class="btn btn btn-round btn-fab btn-fab-mini see-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;" rel="tooltip" data-placement="left" title="Ver información"><i class="material-icons">remove_red_eye</i></button>' +
                                            '<button class="btn btn btn-round btn-fab btn-fab-mini re-asign" data-id-prospecto="' + d.id_prospecto + '" style="background-color:#884EA0;border-color:#884EA0" rel="tooltip" data-placement="left" title="Re - asignar"><i class="material-icons">transform</i></button>';

                                        actions += '<button class="desplegable btn btn btn-round btn-fab btn-fab-mini" id="btn_' + d.id_prospecto + '" onclick="javascript: $(this).addClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').removeClass(\'hide\'); "><span class="material-icons">keyboard_arrow_up</span></button>';
                                        actions += '<div class="hide" id="cnt_' + d.id_prospecto + '">' + group_buttons + '<br><br><button onclick="javascript: $(\'#btn_' + d.id_prospecto + '\').removeClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').addClass(\'hide\'); " class="btn btn btn-round btn-fab btn-fab-mini" style="background-color: orangered"><span class="material-icons">keyboard_arrow_down</span></button></div>';
                                    }

                                    return actions;
                                }
                            } else {
                                if (d.estatus == 1) {
                                    var actions = '';
                                    var group_buttons = '';
                                    if (idUser != d.id_asesor && d.lugar_prospeccion == 6) { // NO ES ASESOR Y EL REGISTRO ES DE MKTD QUITÓ EL BOTÓN DE VER
                                        actions = '';
                                    } else { // ES ASESOR Y EL REGISTRO ES DE MKTD - DEJO EL BOTÓN DE VER
                                       group_buttons = '<button class="btn btn-warning btn-round btn-fab btn-fab-mini to-comment" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px" rel="tooltip" data-placement="left" title="Ingresar comentario"><i class="material-icons">comment</i></button>' +
                                            '<button class="btn btn-success btn-round btn-fab btn-fab-mini edit-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;background-color:#2874A6;border-color:#21618C" rel="tooltip" data-placement="left" title="Editar información"><i class="material-icons">edit</i></button>' +
                                            '<button class="btn btn btn-round btn-fab btn-fab-mini see-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;" rel="tooltip" data-placement="left" title="Ver información"><i class="material-icons">remove_red_eye</i></button>';
                                        actions += '<button style="margin-right: 3px;" class="desplegable btn btn btn-round btn-fab btn-fab-mini" id="btn_' + d.id_prospecto + '" onclick="javascript: $(this).addClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').removeClass(\'hide\'); "><span class="material-icons">keyboard_arrow_up</span></button>';
                                        actions += '<div class="hide" id="cnt_' + d.id_prospecto + '">' + group_buttons + '<br><br><button style="margin-right: 3px;" onclick="javascript: $(\'#btn_' + d.id_prospecto + '\').removeClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').addClass(\'hide\'); " class="btn btn btn-round btn-fab btn-fab-mini" style="background-color: orangered"><span class="material-icons">keyboard_arrow_down</span></button></div>';
                                        actions += '<button class="btn btn-success btn-round btn-fab btn-fab-mini update-status" data-id-prospecto="' + d.id_prospecto + '" style="background-color:#2C3E50;border-color:#2C3E50"><i class="material-icons" title="Actualizar estatus">refresh</i></button>';
                                    }


                                    return actions;
                                } else {
                                    var actions = '';
                                    var group_buttons = '';
                                    if (idUser != d.id_asesor && d.lugar_prospeccion == 6) { // NO ES ASESOR Y EL REGISTRO ES DE MKTD QUITO EL BOTÓN DE VER
                                        actions = '';
                                    } else { // ES ASESOR Y EL REGISTRO ES DE MKTD - DEJO EL BOTÓN DE VER
                                        group_buttons = '<button class="btn btn-warning btn-round btn-fab btn-fab-mini to-comment" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px" rel="tooltip" data-placement="left" title="Ingresar comentario"><i class="material-icons">comment</i></button>' +
                                            '<button class="btn btn-success btn-round btn-fab btn-fab-mini edit-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;background-color:#2874A6;border-color:#21618C" rel="tooltip" data-placement="left" title="Editar"><i class="material-icons">edit</i></button>' +
                                            '<button class="btn btn btn-round btn-fab btn-fab-mini see-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;"><i class="material-icons" rel="tooltip" data-placement="left" title="Ver información">remove_red_eye</i></button>';
                                        actions += '<button style="margin-right: 3px;" class="desplegable btn btn btn-round btn-fab btn-fab-mini" id="btn_' + d.id_prospecto + '" onclick="javascript: $(this).addClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').removeClass(\'hide\'); "><span class="material-icons">keyboard_arrow_up</span></button>';
                                        actions += '<div class="hide" id="cnt_' + d.id_prospecto + '">' + group_buttons + '<br><br><button style="margin-right: 3px;" onclick="javascript: $(\'#btn_' + d.id_prospecto + '\').removeClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').addClass(\'hide\'); " class="btn btn btn-round btn-fab btn-fab-mini" style="background-color: orangered"><span class="material-icons">keyboard_arrow_down</span></button></div>';
                                        if (d.vigencia >= 0 /*< 5 && d.fecha_creacion >= '2021-04-19 23:59:59.000'*/) {
                                            actions += '<button class="btn btn btn-round btn-fab btn-fab-mini update-validity" data-id-prospecto="' + d.id_prospecto + '" style="background-color:#CB4335;border-color:#4cae4c" rel="tooltip" data-placement="left" title="Renovar vigencia"><i class="material-icons">update</i></button>';
                                        }
                                    }

                                    return actions;
                                }
                            }
                        } else {
                            return '';
                        }
                    }
                }
            }
        ],
        columnDefs: [{
                "searchable": true,
                "orderable": false,
                "targets": 0
            },

        ],
        "ajax": {
            "url": "getProspectsList/" + typeTransaction,
            "type": "POST",
            cache: false,
            "data": function(d) {}
        }
    });

    // $('#prospects-datatable tbody').on('click', 'td.details-control', function () {
    //     var tr = $(this).closest('tr');
    //     var row = $prospectsTable.row(tr);
    //     if (row.data().numero_copropietarios > 0) {
    //         if ( row.child.isShown() ) {
    //             row.child.hide();
    //             tr.removeClass('shown');
    //             $(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
    //         }
    //         else {
    //
    //             var informacion_adicional = '<table class="table text-justify">'+
    //                 '<tr>INFORMACIÓN: <b>'+row.data().nombre+'</b>'+
    //                 '<td style="font-size: .8em"><strong>CORREO: </strong>'+myFunctions.validateEmptyField(row.data().correo)+'</td>'+
    //                 '<td style="font-size: .8em"><strong>TELEFONO: </strong>'+myFunctions.validateEmptyField(row.data().telefono1)+'</td>'+
    //                 '<td style="font-size: .8em"><strong>RFC: </strong>'+myFunctions.validateEmptyField(row.data().rfc)+'</td>'+
    //                 '<td style="font-size: .8em"><strong>FECHA NACIMIENTO: </strong>'+myFunctions.validateEmptyField(row.data().fechaNacimiento)+'</td>'+
    //                 '</tr>'+
    //                 '<tr>'+
    //                 '<td style="font-size: .8em"><b>CALLE:</b> '+myFunctions.validateEmptyField(row.data().calle)+'</td>'+
    //                 '<td style="font-size: .8em"><b>COLONIA:</b> '+myFunctions.validateEmptyField(row.data().colonia)+'</td>'+
    //                 '<td style="font-size: .8em"><b>MUNICIPIO:</b> '+myFunctions.validateEmptyField(row.data().municipio)+'</td>'+
    //                 '<td style="font-size: .8em"><b>ESTADO:</b> '+myFunctions.validateEmptyField(row.data().estado)+'</td>'+
    //                 '<td style="font-size: .8em"><b>ENTERADO:</b> '+myFunctions.validateEmptyField(row.data().enterado)+'</td>'+
    //                 '</tr>'+
    //                 '<tr>'+
    //                 '<td style="font-size: .8em"><b>REFERENCIA I:</b> '+myFunctions.validateEmptyField(row.data().referencia1)+'</td>'+
    //                 '<td style="font-size: .8em"><b>TEL. REFERENCIA I:</b> '+myFunctions.validateEmptyField(row.data().telreferencia1)+'</td>'+
    //                 '<td style="font-size: .8em"><b>REFERENCIA II:</b> '+myFunctions.validateEmptyField(row.data().referencia2)+'</td>'+
    //                 '<td style="font-size: .8em"><b>TEL. REFERENCIA II:</b> '+myFunctions.validateEmptyField(row.data().telreferencia2)+'</td>'+
    //                 '<td style="font-size: .8em"><b>PRIMER CONTACTO:</b> '+myFunctions.validateEmptyField(row.data().primerContacto)+'</td>'+
    //                 '</tr>'+
    //                 '<tr>'+
    //                 '<td style="font-size: .8em"><b>GERENTE :</b> '+myFunctions.validateEmptyField(row.data().gerente)+'</td>'+
    //                 '<td style="font-size: .8em"><b>ASESOR I:</b> '+myFunctions.validateEmptyField(row.data().asesor)+'</td>'+
    //                 '<td style="font-size: .8em"><b>ASESOR II:</b> '+myFunctions.validateEmptyField(row.data().asesor2)+'</td>'+
    //                 '<td style="font-size: .8em"></td>'+
    //                 '</tr>' +
    //                 '</table>';
    //
    //             row.child( informacion_adicional ).show();
    //             tr.addClass('shown');
    //             $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
    //         }
    //     }
    // });

    function reloadPage() {
        location.reload();
    }

    $('#myEditModal').modalSteps();
    $('#myCoOwnerModal').modalSteps();

});

function sendCsvFile() {
    data = new FormData();
    data.append('customFile', $('#customFile')[0].files[0]);
    $.ajax({
        type: 'POST',
        url: 'uploadData',
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            // Actions before send post
            document.getElementById("finish").disabled = true;
            var myDataHTML = '<center>Guardando ...</center> <div class="progress progress-line-info"><div class="progress-bar indeterminate" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 30%;"></div></div>;';
            $('#savingProspect').html(myDataHTML);
        },
        success: function(data) {
            if (data == 1) {
                alerts.showNotification("top", "right", "Los registros se han ingresado exitosamente.", "success");
                var myDataHTML = '<center><b style="color:green">Guardado correctamente</b></center> ';
                setTimeout(function() {
                    document.location.reload()
                }, 3000);
            } else {
                document.getElementById("finish").disabled = false;
                var myDataHTML = '';
                $('#savingProspect').html(myDataHTML);
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            document.getElementById("finish").disabled = false;
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}

$("#my-coowner-form").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'saveCoOwner',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            // Actions before send post
            validateEmptySelects(3);
        },
        success: function(data) {
            if (data == 1) {
                $('#myCoOwnerModal').modal("hide");
                cleanFields(3);
                alerts.showNotification("top", "right", "El registro se ha ingresado exitosamente.", "success");
                $('#prospects-datatable').DataTable().ajax.reload(null, false);
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#editReferencesForm").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'updateReference',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {},
        success: function(data) {
            if (data == 1) {
                $('#editReferencesModal').modal("hide");
                alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                $referencesTable.ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#my-edit-form").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'updateProspect',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            // Actions before send post
            //validateEmptySelects(2);
            //enableSelects(2);
        },
        success: function(data) {
            if (data == 1) {
                $('#myEditModal').modal("hide");
                alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                $('#prospects-datatable').DataTable().ajax.reload(null, false);
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#addSalesPartnerForm").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'saveSalesPartner',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            // Actions before send post
        },
        success: function(data) {
            if (data == 1) {
                $('#addSalesPartnerModal').modal("hide");
                $("#prospecto").val('default');
                $("#asesor").val('default');
                $sharedSalesTable.ajax.reload();
                alerts.showNotification("top", "right", "Se ha compartido exitosamente el prospecto.", "success");
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#referencesForm").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'saveReference',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            // Actions before send post
        },
        success: function(data) {
            if (data == 1) {
                $('#addReferencesModal').modal("hide");
                cleanFields(4);
                $referencesTable.ajax.reload();
                alerts.showNotification("top", "right", "Referencia agregada con éxito.", "success");
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

let datos;
/*$("#my-form").on('submit', function(e){ 
       e.preventDefault();
        datos =  new FormData(this);
    });

  $("#btns").on('click', function(e){         
   e.preventDefault();
    validateEmptySelects(1);
    $.ajax({
        type: 'POST',
        url: 'saveProspect',
        data: datos,
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
            $('#confirmar').modal('hide');
            document.getElementById("btns").disabled=true;
            document.getElementById("finish").disabled=true;
            var myDataHTML = '<center>Guardando ...</center> <div class="progress progress-line-info"><div class="progress-bar indeterminate" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 30%;"></div></div>;';
            $('#savingProspect').html(myDataHTML);
        },
        success: function(data) {
            if (data == 1) {
                 $('#confirmar').modal('hide');
                alerts.showNotification("top", "right", "El registro se ha ingresado exitosamente.", "success");
                var myDataHTML = '<center><b style="color:green">Guardado correctamente</b></center> ';
                $('#savingProspect'
                    ).html(myDataHTML);
                 setTimeout(function() {
                    document.location.reload()
                }, 2000);
            } else {
                 $('#confirmar').modal('hide');
                document.getElementById("btns").disabled=false;
                document.getElementById("finish").disabled=false;
                var myDataHTML = '';
                $('#savingProspect').html(myDataHTML);
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function(){
             $('#confirmar').modal('hide');
            document.getElementById("btns").disabled=false;
            document.getElementById("finish").disabled=false;
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
    });*/

/*update validaciones*/
$('#finish').on('click', function() {
    validateFile();
});
$(document).on('click', '#btns', function() {
    $('#submt').click();
});
$(document).on('click', '#submt', function() {
    $('#confirmar').modal('toggle');
});
$("#my-form").on('submit', function(e) {
    e.preventDefault();
    validateEmptySelects(1);
    $.ajax({
        type: 'POST',
        url: 'saveProspect',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            // Actions before send post
            //validateEmptySelects(1);
            //enableSelects(1);
            document.getElementById("finish").disabled = true;
            var myDataHTML = '<center>Guardando ...</center> <div class="progress progress-line-info"><div class="progress-bar indeterminate" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 30%;"></div></div>;';
            $('#savingProspect').html(myDataHTML);


        },
        success: function(data) {
            if (data == 1) {
                //reloadPage();
                alerts.showNotification("top", "right", "El registro se ha ingresado exitosamente.", "success");
                var myDataHTML = '<center><b style="color:green">Guardado correctamente</b></center> ';
                $('#savingProspect').html(myDataHTML);
                setTimeout(function() {
                    document.location.reload()
                }, 2000);
            } else {
                document.getElementById("finish").disabled = false;
                var myDataHTML = '';
                $('#savingProspect').html(myDataHTML);
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            document.getElementById("finish").disabled = false;
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});
/*end validaciones*/

$("#my-comment-form").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'saveComment',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            // Actions before send post
        },
        success: function(data) {
            if (data == 1) {
                $('#myCommentModal').modal("hide");
                $('#observations').val('');
                $('#prospects-datatable').DataTable().ajax.reload(null, false);
                alerts.showNotification("top", "right", "El comentario se ha ingresado exitosamente.", "success");
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#my_reasign_form_sm").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'reasignProspect',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            // Actions before send post
        },
        success: function(data) {
            if (data == 1) {
                $('#myReAsignModalSubMktd').modal("hide");
                $('#prospects-datatable').DataTable().ajax.reload(null, false);
                alerts.showNotification("top", "right", "La reasignación se ha llevado a cabo correctamente.", "success");
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#my_reasign_form_gm").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'reasignProspect',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            // Actions before send post
        },
        success: function(data) {
            if (data == 1) {
                $('#myReAsignModalGerMktd').modal("hide");
                $('#prospects-datatable').DataTable().ajax.reload(null, false);
                alerts.showNotification("top", "right", "La reasignación se ha llevado a cabo correctamente.", "success");
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#my_reasign_form_ve").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'reasignProspect',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            // Actions before send post
        },
        success: function(data) {
            if (data == 1) {
                $('#myReAsignModalVentas').modal("hide");
                $('#prospects-datatable').DataTable().ajax.reload(null, false);
                alerts.showNotification("top", "right", "La reasignación se ha llevado a cabo correctamente.", "success");
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

function validateFile() {
    if ($('#prospecting_place').val() == '' || $('#prospecting_place').val() == null ||
        $('#sales_plaza').val() == '' || $('#sales_plaza').val() == null ||
        $('#asesor_prospecto').val() == '' || $('#asesor_prospecto').val() == null) {
        console.log('vals 5');
        alerts.showNotification('top', 'right', 'Debes ingresar los campos requeridos', 'danger');

    } else {
        $('#confirmar').modal('toggle');
    }
    /*console.log('emtro aqui');
    if($('#prospecting_place').val() == 6  && $('#specify_mkt').val()=='Recomendado')
    {
        console.log('Entro aqui II');
        if( document.getElementById("archivo_evidencia").files.length == 0 ){
            alerts.showNotification('top', 'right', 'DEBES SELECCIONAR UN ARCHIVO', 'danger');

        }
        else
        {
            if($('#prospecting_place').val()=='' ||  $('#prospecting_place').val() == null ||
                $('#sales_plaza').val() =='' || $('#sales_plaza').val() == null ||
                $('#asesor_prospecto').val()=='' || $('#asesor_prospecto').val() == null)
            {
                console.log('vals 3');
                alerts.showNotification('top', 'right', 'Debes ingresar los campos requeridos', 'danger');

            }
            else
            {
                $('#confirmar').modal('toggle');
            }
        }
    }
    else
    {
        console.log('vals 4');
        if($('#prospecting_place').val()=='' ||  $('#prospecting_place').val() == null ||
            $('#sales_plaza').val() =='' || $('#sales_plaza').val() == null ||
            $('#asesor_prospecto').val()=='' || $('#asesor_prospecto').val() == null)
        {
            console.log('vals 5');
            alerts.showNotification('top', 'right', 'Debes ingresar los campos requeridos', 'danger');

        }
        else {
            $('#confirmar').modal('toggle');
        }
    }*/
}

function validateEmptySelects(type) {
    /*
     * 1 insert prospect
     * 2 update prospect
     * 3 insert co-owner
     */
    if (type == 1 || type == 2) { // validate fields before insert/update a prospect
        if ($("#civil_status").val() == null || $("#civil_status").val() == '') {
            $("#civil_status").val(7);
        }
        if ($("#matrimonial_regime").val() == null || $("#matrimonial_regime").val() == '') {
            $("#matrimonial_regime").val(5);
        }
        if ($("#state").val() == null || $("#state").val() == '') {
            $("#state").val(33);
        }
        /* if (($("#own").val() == null || $("#own").val() == '') && ($("#rented").val() == null || $("#rented").val() == '') && ($("#paying").val() == null || $("#paying").val() == '') && ($("#family").val() == null || $("#family").val() == '') && ($("#other").val() == null || $("#other").val() == '')) {
             $("#hidden").val(6);
         }*/
    } else if (type == 3) { // validate fields before insert a co-owner
        if ($("#civil_status_co").val() == null || $("#civil_status_co").val() == '') {
            $("#civil_status_co").val(7);
        }
        if ($("#matrimonial_regime_co").val() == null || $("#matrimonial_regime_co").val() == '') {
            $("#matrimonial_regime_co").val(5);
        }
        if ($("#state_co").val() == null || $("#state_co").val() == '') {
            $("#state_co").val(33);
        }
        if (($("#own_co").val() == null || $("#own_co").val() == '') && ($("#rented_co").val() == null || $("#rented_co").val() == '') && ($("#paying_co").val() == null || $("#paying_co").val() == '') && ($("#family_co").val() == null || $("#family_co").val() == '') && ($("#other_co").val() == null || $("#other_co").val() == '')) {
            $("#hidden").val(6);
        }
    }
}

function cleanFields(type) {
    /*
     * 1 insert prospect
     * 2 update prospect
     * 3 insert co-owner
     * 4 insert references
     */
    if (type == 1 || type == 2) {
        $("#nationality").val("");
        $("#nationality").selectpicker('refresh');
        $("#legal_personality").val("0");
        $("#legal_personality").selectpicker('refresh');
        $("#curp").val("");
        $("#rfc").val("");
        $("#name").val("");
        $("#last_name").val("");
        $("#mothers_last-name").val("");
        $("#email").val("");
        $("#phone_number").val("");
        $("#phone_number2").val("");
        $("#prospecting_place").val("0");
        $("#prospecting_place").selectpicker('refresh');
        $("#specify").val("");
        $("#specify-mkt").val("0");
        $("#specify-mkt").selectpicker('refresh');
        $("#advertising").val("0");
        $("#advertising").selectpicker('refresh');
        $("#sales-plaza").val("0");
        $("#sales-plaza").selectpicker('refresh');
        $("#comments").val("");
        $(".clean-field").addClass("is-empty");
    } else if (type == 3) {
        $("#nationality_co").val("");
        $("#legal_personality_co").val("");
        $("#rfc_co").val("");
        $("#date_birth_co").val("");
        $("#name_co").val("");
        $("#last_name_co").val("");
        $("#mothers_last_name_co").val("");
        $("#email_co").val("");
        $("#phone_number_co").val("");
        $("#phone_number2_co").val("");
        $("#civil_status_co").val("");
        $("#matrimonial_regime_co").val("");
        $("#spouce_co").val("");
        $("#street_name_co").val("");
        $("#ext_number_co").val("");
        $("#suburb_co").val("");
        $("#postal_code_co").val("");
        $("#town_cow").val("");
        $("#state_co").val("");
        $("#occupation_co").val("");
        $("#company_co").val("");
        $("#position_co").val("");
        $("#antiquity_co").val("");
        $("#company_antiquity_co").val("");
        $("#company_residence_co").val("");
        $("#nationality").val("");
    } else if (type == 4) {
        $("#name").val("");
        $("#phone_number").val("");
        $('#prospecto').val(null).trigger('change');
        $("#prospecto").selectpicker('refresh');
        $('#kinship').val(null).trigger('change');
        $("#kinship").selectpicker('refresh');
    }
}

function validateCivilStatus(type) {
    /*
     * 1 insert prospect
     * 2 update prospect
     * 3 insert co-owner
     */
    if (type == 1 || type == 2) {
        cs = document.getElementById('civil_status');
        cs = cs.value;
        if (cs == 4) { // IS MARRIED
            document.getElementById('matrimonial_regime').removeAttribute("disabled");
        } else { // IT'S NOT MARRIED
            $("#matrimonial_regime").val("5");
            $("#spouce").val("");
            document.getElementById('matrimonial_regime').setAttribute("disabled", "true");
            document.getElementById('spouce').setAttribute("disabled", "true");
        }
    } else if (type == 3) {
        cs = document.getElementById('civil_status_co');
        cs = cs.value;
        if (cs == 4) { // IS MARRIED
            document.getElementById('matrimonial_regime_co').removeAttribute("disabled");
        } else { // IT'S NOT MARRIED
            $("#matrimonial_regime_co").val("5");
            $("#spouce_co").val("");
            document.getElementById('matrimonial_regime_co').setAttribute("disabled", "true");
            document.getElementById('spouce_co').setAttribute("disabled", "true");
        }
    }
}

function validateMatrimonialRegime(type) {
    /*
     * 1 insert prospect
     * 2 update prospect
     * 3 insert co-owner
     */
    if (type == 1 || type == 2) {
        mr = document.getElementById('matrimonial_regime');
        mr = mr.value;
        if (mr == 1) { // IS A CONJUGAL SOCIETY
            document.getElementById('spouce').removeAttribute("readonly");
        } else { // IT'S NOT A CONJUGAL SOCIETY
            $("#spouce").val("");
            document.getElementById('spouce').setAttribute("readonly", "true");
        }
    } else if (type == 3) {
        mr = document.getElementById('matrimonial_regime_co');
        mr = mr.value;
        if (mr == 1) { // IS A CONJUGAL SOCIETY
            document.getElementById('spouce_co').removeAttribute("readonly");
        } else { // IT'S NOT A CONJUGAL SOCIETY
            $("#spouce").val("");
            document.getElementById('spouce_co').setAttribute("readonly", "true");
        }
    }
}
/*
function enableSelects(type){
    /*
    * 1 insert prospect
    * 2 update prospect
    * 3 insert co-owner
    */
/* if (type == 1 || type == 2) {
        $('#matrimonial_regime').removeAttribute("disabled");
        $('#spouce').removeAttribute("disabled");
    } else if (type == 3) {
        $('#matrimonial_regime_co').removeAttribute("disabled");
        $('#spouce_co').removeAttribute("disabled");
    }
}*/

function getAdvisers(element) {
    sede = $('option:selected', element).attr('data-sede');
    $("#myselectasesor").find("option").remove();
    $("#myselectasesor").append($('<option disabled>').val("0").text("Seleccione una opción"));
    $.post('getAdvisers/' + sede, function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#myselectasesor").append($('<option>').val(id).attr('data-sede', sede).text(name));
        }
        if (len <= 0) {
            $("#myselectasesor").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#myselectasesor").selectpicker('refresh');
    }, 'json');
}

function getCoordinatorsByManager(element) {
    gerente = $('option:selected', element).val();
    $("#myselectcoordinador").find("option").remove();
    $("#myselectcoordinador").append($('<option disabled>').val("0").text("Seleccione una opción"));
    $.post('getCoordinatorsByManager/' + gerente, function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#myselectcoordinador").append($('<option>').val(id).attr('data-sede', sede).text(name));
        }
        if (len <= 0) {
            $("#myselectcoordinador").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#myselectcoordinador").selectpicker('refresh');
    }, 'json');
}

function getAdvisersByCoordinator(element) {
    coordinador = $('option:selected', element).val();
    $("#myselectasesor3").find("option").remove();
    $("#myselectasesor3").append($('<option disabled>').val("0").text("Seleccione una opción"));
    $.post('getAdvisersByCoordinator/' + coordinador, function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#myselectasesor3").append($('<option>').val(id).attr('data-sede', sede).text(name));
        }
        if (len <= 0) {
            $("#myselectasesor3").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#myselectasesor3").selectpicker('refresh');
    }, 'json');
}

function getAge(type) {
    // 1 insert
    // 2 update
    // 3 co-owner
    if (type == 1 || type == 2) {
        dateString = $("#date_birth").val();
    } else if (type == 3) {
        dateString = $("#date_birth_co").val();
    }
    today = new Date();
    birthDate = new Date(dateString);
    age = today.getFullYear() - birthDate.getFullYear();
    m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    if (type == 1 || type == 2) {
        $("#company_antiquity").val(age);
    } else if (type == 3) {
        $("#company_antiquity_co").val(age);
    }
}


// Validate prospect's legal personality
function validatePersonality() {
    console.log("entra a la función de validación");
    lp = document.getElementById('legal_personality');
    lp = lp.value;
    if (lp == 1) {
        document.getElementById('curp').value = '';
        document.getElementById('last_name').value = '';
        document.getElementById('mothers_last_name').value = '';

        document.getElementById('curp').setAttribute("readonly", "true");
        document.getElementById('last_name').setAttribute("readonly", "true");
        document.getElementById('mothers_last_name').setAttribute("readonly", "true");
    } else if (lp == 2 || lp == 3) {
        document.getElementById('curp').removeAttribute("readonly");
        document.getElementById('last_name').removeAttribute("readonly");
        document.getElementById('mothers_last_name').removeAttribute("readonly");
    }
}

// Validate the prospecting place to see if it requires specification or not
function validateProspectingPlace() {
    pp = document.getElementById('prospecting_place');
    pp = pp.value;
    if (pp == 3 || pp == 7 || pp == 9 || pp == 10) { // SPECIFY OPTION
        document.getElementById('specify_mkt').value = '';
        document.getElementById('specify_recommends').value = '';
        document.getElementById('type_recomendado').value = '0';
        $("#specify_recommends").removeAttr("required");
        $("#specify").removeAttr("style");
        document.getElementById('specify').removeAttribute("readonly");
        $("#specify_mkt").css({ "display": "none" });
        $("#specify_recommends").css({ "display": "none" });
        $("#specify_recommends").next(".select2-container").hide();

    } else if (pp == 6) { // SPECIFY MKTD OPTION
        document.getElementById('specify').value = '';
        document.getElementById('specify_recommends').value = '';
        document.getElementById('type_recomendado').value = '0';
        $("#specify_recommends").removeAttr("required");
        $("#specify").css({ "display": "none" });
        $("#specify_recommends").css({ "display": "none" });
        $("#specify_recommends").next(".select2-container").hide();
        $("#specify_mkt").removeAttr("style");
    } else if (pp == 21) { // RECOMMENDED SPECIFICATION
        document.getElementById('specify').value = '';
        document.getElementById('specify_mkt').value = '';
        $("#specify").css({ "display": "none" });
        $("#specify_mkt").css({ "display": "none" });
        $("#specify_recommends").removeAttr("style");
        $("#specify_recommends").css({ "required": "true" });
        $("#specify_recommends").select2();
        getPersonsWhoRecommends();
    } else { // WITHOUT SPECIFICATION
        document.getElementById('specify').value = '';
        document.getElementById('specify_mkt').value = '';
        document.getElementById('specify_recommends').value = '';
        document.getElementById('type_recomendado').value = '0';
        document.getElementById('specify').setAttribute("readonly", "true");
        $("#specify_recommends").removeAttr("required");
        $("#specify_mkt").css({ "display": "none" });
        $("#specify_recommends").css({ "display": "none" });
        $("#specify_recommends").next(".select2-container").hide();
        $("#specify").removeAttr("style");
    }
}

// Focus an specific field
function onFocusComment() {
    document.getElementById("comment").focus();
}

function getSalesPartnerInformation(element) {
    coordinador = $('option:selected', element).attr('data-coordinador');
    gerente = $('option:selected', element).attr('data-gerente');
    $("#id_gerente").val(gerente);
    $("#id_coordinador").val(coordinador);
}


function printProspectInfo() {
    id_prospecto = $("#prospecto_lbl").val();
    window.open("printProspectInfo/" + id_prospecto, "_blank")
}

function printProspectInfoMktd() {
    id_prospecto = $("#prospecto_lbl").val();
    window.open("printProspectInfoMktd/" + id_prospecto, "_blank")
}

function fillFields(v, type) {
    /*
     * 0 update prospect
     * 1 see information modal
     * 2 update reference
     */
    if (type == 0) {
        $("#nationality").val(v.nacionalidad);
        $("#legal_personality").val(v.personalidad_juridica);
        $("#curp").val(v.curp);
        $("#rfc").val(v.rfc);
        $("#name").val(v.nombre);
        $("#last_name").val(v.apellido_paterno);
        $("#mothers_last_name").val(v.apellido_materno);
        $("#date_birth").val(v.fecha_nacimiento);
        $("#email").val(v.correo);
        $("#phone_number").val(v.telefono);
        $("#phone_number2").val(v.telefono_2);
        $("#civil_status").val(v.estado_civil);
        $("#matrimonial_regime").val(v.regimen_matrimonial);
        $("#spouce").val(v.conyuge);
        $("#from").val(v.originario_de);
        $("#home_address").val(v.domicilio_particular);
        $("#occupation").val(v.ocupacion);
        $("#company").val(v.empresa);
        $("#position").val(v.posicion);
        $("#antiquity").val(v.antiguedad);
        $("#company_antiquity").val(v.edadFirma);
        $("#company_residence").val(v.direccion);
        $("#prospecting_place").val(v.lugar_prospeccion);
        $("#advertising").val(v.medio_publicitario);
        $("#sales_plaza").val(v.plaza_venta);
        //document.getElementById("observations").innerHTML = v.observaciones;
        $("#observation").val(v.observaciones);
        if (v.tipo_vivienda == 1) {
            document.getElementById('own').setAttribute("checked", "true");
        } else if (v.tipo_vivienda == 2) {
            document.getElementById('rented').setAttribute("checked", "true");
        } else if (v.tipo_vivienda == 3) {
            document.getElementById('paying').setAttribute("checked", "true");
        } else if (v.tipo_vivienda == 4) {
            document.getElementById('family').setAttribute("checked", "true");
        } else {
            document.getElementById('other').setAttribute("checked", "true");
        }

        pp = v.lugar_prospeccion;
        console.log(pp);
        if (pp == 3 || pp == 7 || pp == 9 || pp == 10) { // SPECIFY OPTION
            $("#specify").val(v.otro_lugar);
        } else if (pp == 6) { // SPECIFY MKTD OPTION
            document.getElementById('specify_mkt').value = v.otro_lugar;
        } else if (pp == 21) { // RECOMMENDED SPECIFICATION
            document.getElementById('specify_recommends').value = v.otro_lugar;
        } else { // WITHOUT SPECIFICATION
            $("#specify").val("");
        }

    } else if (type == 1) {
        $("#nationality-lbl").val(v.nacionalidad);
        $("#legal-personality-lbl").val(v.personalidad_juridica);
        $("#curp-lbl").val(v.curp);
        $("#rfc-lbl").val(v.rfc);
        $("#name-lbl").val(v.nombre);
        $("#last-name-lbl").val(v.apellido_paterno);
        $("#mothers-last-name-lbl").val(v.apellido_materno);
        $("#email-lbl").val(v.correo);
        $("#phone-number-lbl").val(v.telefono);
        $("#phone-number2-lbl").val(v.telefono_2);
        $("#prospecting-place-lbl").val(v.lugar_prospeccion);
        $("#specify-lbl").html(v.otro_lugar);
        //$("#advertising-lbl").val(v.medio_publicitario);
        $("#sales-plaza-lbl").val(v.plaza_venta);
        $("#comments-lbl").val(v.observaciones);
        $("#asesor-lbl").val(v.asesor);
        $("#coordinador-lbl").val(v.coordinador);
        $("#gerente-lbl").val(v.gerente);
        $("#phone-asesor-lbl").val(v.tel_asesor);
        $("#phone-coordinador-lbl").val(v.tel_coordinador);
        $("#phone-gerente-lbl").val(v.tel_gerente);

    } else if (type == 2) {
        $("#prospecto_ed").val(v.id_prospecto).trigger('change');
        $("#prospecto_ed").selectpicker('refresh');
        $("#kinship_ed").val(v.parentesco).trigger('change');
        $("#kinship_ed").selectpicker('refresh');
        $("#name_ed").val(v.nombre);
        $("#phone_number_ed").val(v.telefono);
    }
}

function validateEmptyFields(v, type) {
    /*
     * 1 edit prospect
     * 2 edit reference
     */
    if (type === 1) {
        $(".select-is-empty").removeClass("is-empty");
        if (v.nombre != '') {
            $(".div-name").removeClass("is-empty");
        }
        if (v.apellido_paterno != '') {
            $(".div-last-name").removeClass("is-empty");
        }
        if (v.apellido_materno != '') {
            $(".div-mothers-last-name").removeClass("is-empty");
        }
        if (v.rfc != '') {
            $(".div-rfc").removeClass("is-empty");
        }
        if (v.curp != '') {
            $(".div-curp").removeClass("is-empty");
        }
        if (v.correo != '') {
            $(".div-email").removeClass("is-empty");
        }
        if (v.telefono != '') {
            $(".div-phone-number").removeClass("is-empty");
        }
        if (v.telefono_2 != '') {
            $(".div-phone-number2").removeClass("is-empty");
        }
        if (v.observaciones != '') {
            $(".div-observations").removeClass("is-empty");
        }
        if (v.otro_lugar != '') {
            $(".div-specify").removeClass("is-empty");
        }
        if (v.fecha_nacimiento != '') {
            $(".div-date-birth").removeClass("is-empty");
        }
        if (v.conyuge != '') {
            $(".div-spouce").removeClass("is-empty");
        }
        if (v.calle != '') {
            $(".div-street-name").removeClass("is-empty");
        }
        if (v.numero != '') {
            $(".div-ext-number").removeClass("is-empty");
        }
        if (v.colonia != '') {
            $(".div-suburb").removeClass("is-empty");
        }
        if (v.municipio != '') {
            $(".div-town").removeClass("is-empty");
        }
        if (v.codigo_postal != '') {
            $(".div-postal-code").removeClass("is-empty");
        }
        if (v.ocupacion != '') {
            $(".div-occupation").removeClass("is-empty");
        }
        if (v.empresa != '') {
            $(".div-company").removeClass("is-empty");
        }
        if (v.posicion != '') {
            $(".div-position").removeClass("is-empty");
        }
        if (v.antiguedad != '') {
            $(".div-antiquity").removeClass("is-empty");
        }
        if (v.edadFirma != '') {
            $(".div-company-antiquity").removeClass("is-empty");
        }
        if (v.domicilio != '') {
            $(".div-company-residence").removeClass("is-empty");
        }
    } else if (type === 2) {
        if (v.nombre != '') {
            $(".div-name").removeClass("is-empty");
        }
        if (v.telefono != '') {
            $(".div-phone-number").removeClass("is-empty");
        }
    }
}

function fillTimeline(v) {
    //colours = ["success", "danger", "warning", "info", "rose"];
    //colourSelected = colours[Math.floor(Math.random() * colours.length)];
    $("#comments-list").append('<li class="timeline-inverted">\n' +
        '    <div class="timeline-badge info"></div>\n' +
        '    <div class="timeline-panel">\n' +
        '            <label><h6>' + v.creador + '</h6></label>\n' +
        '            <br>' + v.observacion + '\n' +
        '        <h6>\n' +
        '            <span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> ' + v.fecha_creacion + '</span>\n' +
        '        </h6>\n' +
        '    </div>\n' +
        '</li>');
}

function fillChangelog(v) {
    $("#changelog").append('<li class="timeline-inverted">\n' +
        '    <div class="timeline-badge success"></div>\n' +
        '    <div class="timeline-panel">\n' +
        '            <label><h6>' + v.parametro_modificado + '</h6></label><br>\n' +
        '            <b>Valor anterior:</b> ' + v.anterior + '\n' +
        '            <br>\n' +
        '            <b>Valor nuevo:</b> ' + v.nuevo + '\n' +
        '        <h6>\n' +
        '            <span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> ' + v.fecha_creacion + ' - ' + v.creador + '</span>\n' +
        '        </h6>\n' +
        '    </div>\n' +
        '</li>');
}

function cleanComments() {
    var myCommentsList = document.getElementById('comments-list');
    myCommentsList.innerHTML = '';

    var myChangelog = document.getElementById('changelog');
    myChangelog.innerHTML = '';
}

$(document).on('click', '.edit-reference-information', function(e) {
    id_referencia = $(this).attr("data-id-referencia");
    $.getJSON("getReferenceInformation/" + id_referencia).done(function(data) {
        $.each(data, function(i, v) {
            $("#editReferencesModal").modal();
            fillFields(v, 2);
            validateEmptyFields(v, 2);
            $("#id_referencia").val(id_referencia);
        });
    });
});

$(document).on('click', '.change-reference-status', function() {
    estatus = $(this).attr("data-estatus");
    $.ajax({
        type: 'POST',
        url: 'changeReferenceStatus',
        data: { 'id_referencia': $(this).attr("data-id-referencia"), 'estatus': $(this).attr("data-estatus") },
        dataType: 'json',
        success: function(data) {
            if (data == 1) {
                if (estatus == 1) {
                    alerts.showNotification("top", "right", "Se ha activado con éxito.", "success");
                } else {
                    alerts.showNotification("top", "right", "Se ha desactivado con éxito.", "success");
                }
                $referencesTable.ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '.edit-information', function(e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    $.getJSON("getProspectInformation/" + id_prospecto).done(function(data) {
        $.each(data, function(i, v) {
            $("#myEditModal").modal();
            fillFields(v, 0);
            validateEmptyFields(v, 1);
            $("#id_prospecto_ed").val(id_prospecto);
            showSpecificationObject();
        });
    });
});



$(document).on('click', '.update-validity', function() {
    $.ajax({
        type: 'POST',
        url: 'updateValidity',
        data: { 'id_prospecto': $(this).attr("data-id-prospecto") },
        dataType: 'json',
        success: function(data) {
            if (data == 1) {
                alerts.showNotification("top", "right", "La vigencia de tu prospecto se ha renovado exitosamente.", "success");
                //$prospectsTable.ajax.reload();
                $('#prospects-datatable').DataTable().ajax.reload(null, false);
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});



$(document).on('click', '.change-status', function() {
    estatus = $(this).attr("data-estatus");
    $.ajax({
        type: 'POST',
        url: 'changeSalesPartnerStatus',
        data: { 'id_vcompartida': $(this).attr("data-id-vcompartida"), 'estatus': $(this).attr("data-estatus") },
        dataType: 'json',
        success: function(data) {
            if (data == 1) {
                if (estatus == 1) {
                    alerts.showNotification("top", "right", "Se ha activado con éxito.", "success");
                } else {
                    alerts.showNotification("top", "right", "Se ha desactivado con éxito.", "success");
                }
                $sharedSalesTable.ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '.add-co-owner', function(e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    $(".select-is-empty").removeClass("is-empty");
    $("#myCoOwnerModal").modal();
    $("#id_prospecto_ed_co").val(id_prospecto);
});

$(document).on('click', '.to-comment', function(e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    $("#myCommentModal").modal();
    $("#comment").val("");
    $("#id_prospecto").val(id_prospecto);
    $(".label-floating").removeClass("is-empty");
});

$(document).on('click', '.see-information', function(e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    $("#seeInformationModal").modal();
    $("#prospecto_lbl").val(id_prospecto);

    $.getJSON("getInformationToPrint/" + id_prospecto).done(function(data) {
        $.each(data, function(i, v) {
            fillFields(v, 1);
        });
    });

    $.getJSON("getComments/" + id_prospecto).done(function(data) {
        counter = 0;
        $.each(data, function(i, v) {
            counter++;
            fillTimeline(v, counter);
        });
    });

    $.getJSON("getChangelog/" + id_prospecto).done(function(data) {
        if (data.length > 0) {
            $.each(data, function(i, v) {
                fillChangelog(v);
            });
        } else {
            $("#changelog").append('<h3>No se encontraron cambios.</h3>');
        }
    });

});

$(document).on('click', '.re-asign', function(e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    console.log(id_prospecto);
    if (userType == 3 || userType == 6) { // Gerente & asistente de ventas
        $("#myReAsignModalVentas").modal();
        $("#id_prospecto_re_asign_ve").val(id_prospecto);
    } else if (userType == 19) { // Subdirector MKTD
        $("#myReAsignModalSubMktd").modal();
        $("#id_prospecto_re_asign_sm").val(id_prospecto);
    } else if (userType == 20) { // Gerente MKTD
        $("#myReAsignModalGerMktd").modal();
        $("#id_prospecto_re_asign_gm").val(id_prospecto);
    }
    //id_prospecto = $(this).attr("data-id-prospecto");
    //$("#myReAsignModal").modal();
    //$("#id_prospecto_re_asign").val(id_prospecto);
});

function disableButton(id) {
    document.getElementById(id).disabled = true;
}

$(document).on('click', '.update-status', function(e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    $("#myUpdateStatusModal").modal();
    $("#id_prospecto_estatus_particular").val(id_prospecto);
});

$("#my_update_status_form").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'updateStatus',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            // Actions before send post
            document.getElementById("finishS").disabled = true;
        },
        success: function(data) {
            /*$("#proyecto").val("");
            $("#proyecto").selectpicker('refresh');
            $("#condominio").empty().selectpicker('refresh');
            $("#lote").empty().selectpicker('refresh');
            document.getElementById("datatoassign").style.display = "none";
            document.getElementById("housesDetail").style.display = "none";*/
            if (data == 1) { // SUCCESS RESPONSE
                document.getElementById("finishS").disabled = false;
                $('#myUpdateStatusModal').modal("hide");
                $('#estatus_particular').val("0");
                $("#estatus_particular").selectpicker("refresh");
                $('#prospects-datatable').DataTable().ajax.reload(null, false);
                alerts.showNotification("top", "right", "La actualización se ha llevado a cabo correctamente.", "success");
            } else if (data == 2) { // LOTE APARTADO
                document.getElementById("finishS").disabled = false;
                alerts.showNotification("top", "right", "La asignación no se ha podido llevar a cabo debido a que el lote seleccionado ya se encuentra apartado.", "warning");
            } else { // ALGO LE FALTÓ
                document.getElementById("finishS").disabled = false;
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            document.getElementById("finishS").disabled = false;
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});



function cleanSelects() {
    $('#estatus_particular').val("0");
    $("#estatus_particular").selectpicker("refresh");
}




/*----PREVENTA----------------------*/

/*--------------Preventa------------------*/
$.post('getStatusMktdPreventa', function(data) {
    $("#estatus_particular2").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
    var len = data.length;
    for (var i = 0; i < len; i++) {
        var id = data[i]['id_opcion'];
        var name = data[i]['nombre'];
        $("#estatus_particular2").append($('<option>').val(id).text(name));
    }
    if (len <= 0) {
        $("#estatus_particular2").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
    }
    $("#estatus_particular2").selectpicker('refresh');
}, 'json');

/*----------------------*/

$(document).on('click', '.update-status-preventa', function(e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    ///alert(id_prospecto);
    $("#myUpdateStatusModalPreventa").modal();
    $("#id_prospecto_estatus_particular2").val(id_prospecto);
});

$("#my_update_status_form_preventa").on('submit', function(e) {
    e.preventDefault();

    let val = $('#estatus_particular2').val();
    let id = $("#id_prospecto_estatus_particular2").val();
    //si la opcion seleccionada es 6 
    if (val == 7) {

        $("#id_prospecto_estatus_particular3").val(id);
        $("#myUpdateStatusPreve").modal();
        //$('#idestatusPP').val(val);


    } else {

        console.log("NADA");

    }

});


$("#my_update_status_prevee").on('submit', function(e) {
    e.preventDefault();

    //let val = $('#estatus_particular2').val();
    //let id = $("#id_prospecto_estatus_particular2").val();
    //si la opcion seleccionada es 6 
    //$("#id_prospecto_estatus_particular3").val(id);
    //  $("#myUpdateStatusPreve").modal();
    $.ajax({
        type: 'POST',
        url: 'updateStatusPreventa',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            // Actions before send post
        },
        success: function(data) {
            if (data == 1) {
                $('#myUpdateStatusPreve').modal("hide");
                $('#myUpdateStatusModalPreventa').modal("hide");
                $('#estatus_particular2').val("0");
                $("#estatus_particular2").selectpicker("refresh");
                $prospectsPreventaTable.ajax.reload();
                alerts.showNotification("top", "right", "La actualización se ha llevado a cabo correctamente.", "success");
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });

});

/*-----------FIN FUNCIONES PARA PREVENTA------------------*/
$('#prospects-preventa-datatable thead tr:eq(0) th').each(function(i) {

    //  if(i != 0 && i != 11){
    var title = $(this).text();
    $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500;" class="textoshead"  placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function() {
        if (prospectsPreventaTable.column(i).search() !== this.value) {
            prospectsPreventaTable
                .column(i)
                .search(this.value)
                .draw();
        }
    });
    //}
});

/*-------------PREVENTA-----------------------*/

$prospectsPreventaTable = $('#prospects-preventa-datatable').DataTable({

    "pagingType": "full_numbers",
    "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "Todos"]
    ],
    "language": {
        "url": "../../static/spanishLoader.json"
    },

    destroy: true,
    ordering: false,
    columns: [
        // {
        //     "className": "details-control",
        //     "orderable": false,
        //     "data": null,
        //     "defaultContent": '<i class="material-icons" style="color: #003d82;" title="Click aquí para más detalles">add_circle</i>'
        // },
        {
            data: function(d) {


                if (d.estatus == 1) {
                    return '<center><span class="label label-danger" style="background:#27AE60">Vigente</span><center>';
                } else {
                    return '<center><span class="label label-danger" style="background:#E74C3C">Sin vigencia</span><center>';
                }
            }

        },
        {
            data: function(d) {
                if (d.estatus_particular == 1) { // DESCARTADO
                    b = '<center><span class="label" style="background:#E74C3C">Descartado</span><center>';
                } else if (d.estatus_particular == 2) { // INTERESADO SIN CITA
                    b = '<center><span class="label" style="background:#B7950B">Interesado sin cita</span><center>';
                } else if (d.estatus_particular == 3) { // CON CITA
                    b = '<center><span class="label" style="background:#27AE60">Con cita</span><center>';
                } else if (d.estatus_particular == 4) { // SIN ESPECIFICAR
                    b = '<center><span class="label" style="background:#5D6D7E">Sin especificar</span><center>';
                } else if (d.estatus_particular == 5) { // PAUSADO
                    b = '<center><span class="label" style="background:#2E86C1">Pausado</span><center>';
                } else if (d.estatus_particular == 6) { // PREVENTA
                    b = '<center><span class="label" style="background:#8A1350">Preventa</span><center>';
                }

                return b;
            }
        },
        {
            data: function(d) {
                return d.nombre;
            }
        },
        {
            data: function(d) {
                return d.asesor;
            }
        },
        {
            data: function(d) {
                return d.coordinador;
            }
        },
        {
            data: function(d) {
                return d.gerente;
            }
        },
        {
            data: function(d) {
                return d.fecha_creacion;
            }
        },
        {
            data: function(d) {
                return d.fecha_vencimiento;
            }
        },
        {
            data: function(d) {
                if (typeTransaction == 0) { // Marketing
                    if (userType == "18" || userType == "19" || userType == "20") { // Array de roles permitidos para reasignar
                        if (d.estatus == 1) {
                            /*return '<button class="btn btn-warning btn-round btn-fab btn-fab-mini to-comment" data-id-prospecto="' + d.id_prospecto +'" style="margin-right: 3px"><i class="material-icons">comment</i></button>' +
                                '<button class="btn btn-success btn-round btn-fab btn-fab-mini edit-information" data-id-prospecto="' + d.id_prospecto +'" style="margin-right: 3px;background-color:#2874A6;border-color:#21618C"><i class="material-icons">edit</i></button>' +
                                '<button class="btn btn btn-round btn-fab btn-fab-mini see-information" data-id-prospecto="' + d.id_prospecto +'" style="margin-right: 3px;"><i class="material-icons">remove_red_eye</i></button>' +
                                '<button class="btn btn btn-round btn-fab btn-fab-mini re-asign" data-id-prospecto="' + d.id_prospecto +'" style="background-color:#884EA0;border-color:#884EA0"><i class="material-icons">transform</i></button>';*/
                            var actions = '';
                            var group_buttons = '';
                            group_buttons = '<button class="btn btn-warning btn-round btn-fab btn-fab-mini to-comment" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px" rel="tooltip" data-placement="left" title="Ingresar comentario"><i class="material-icons">comment</i></button>' +
                                '<button class="btn btn-success btn-round btn-fab btn-fab-mini edit-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;background-color:#2874A6;border-color:#21618C" rel="tooltip" data-placement="left" title="Editar información"><i class="material-icons">edit</i></button>' +
                                '<button class="btn btn btn-round btn-fab btn-fab-mini see-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;" rel="tooltip" data-placement="left" title="Ver información"><i class="material-icons">remove_red_eye</i></button>' +
                                '<button class="btn btn-success btn-round btn-fab btn-fab-mini update-status-preventa" data-id-prospecto="' + d.id_prospecto + '" style="background-color:#2C3E50;border-color:#2C3E50"><i class="material-icons" title="Actualizar estatus">refresh</i></button>';

                            actions += '<button class="desplegable btn btn btn-round btn-fab btn-fab-mini" id="btn_' + d.id_prospecto + '" onclick="javascript: $(this).addClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').removeClass(\'hide\'); "><span class="material-icons">keyboard_arrow_up</span></button>';
                            actions += '<div class="hide" id="cnt_' + d.id_prospecto + '">' + group_buttons + '<br><br><button onclick="javascript: $(\'#btn_' + d.id_prospecto + '\').removeClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').addClass(\'hide\'); " class="btn btn btn-round btn-fab btn-fab-mini" style="background-color: orangered"><span class="material-icons">keyboard_arrow_down</span></button></div>';
                            return actions;
                        } else {
                            var actions = '';
                            var group_buttons = '';
                            group_buttons = '<button class="btn btn-warning btn-round btn-fab btn-fab-mini to-comment" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px" rel="tooltip" data-placement="left" title="Ingresar comentario"><i class="material-icons">comment</i></button>' +
                                '<button class="btn btn-success btn-round btn-fab btn-fab-mini edit-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;background-color:#2874A6;border-color:#21618C" rel="tooltip" data-placement="left" title="Editar información"><i class="material-icons">edit</i></button>' +
                                '<button class="btn btn btn-round btn-fab btn-fab-mini see-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;" rel="tooltip" data-placement="left" title="Ver información"><i class="material-icons">remove_red_eye</i></button>' +
                                '<button class="btn btn-success btn-round btn-fab btn-fab-mini update-status-preventa" data-id-prospecto="' + d.id_prospecto + '" style="background-color:#2C3E50;border-color:#2C3E50"><i class="material-icons" title="Actualizar estatus">refresh</i></button>';

                            if (d.vigencia >= 0 /*< 5 && d.fecha_creacion >= '2021-04-19 23:59:59.000'*/) {
                            	group_buttons += '<button class="btn btn btn-round btn-fab btn-fab-mini update-validity" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;background-color:#CB4335;border-color:#4cae4c" rel="tooltip" data-placement="left" title="Renovar vigencia"><i class="material-icons">update</i></button>';
                            }

                            actions += '<button class="desplegable btn btn btn-round btn-fab btn-fab-mini" id="btn_' + d.id_prospecto + '" onclick="javascript: $(this).addClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').removeClass(\'hide\'); "><span class="material-icons">keyboard_arrow_up</span></button>';
                            actions += '<div class="hide" id="cnt_' + d.id_prospecto + '">' + group_buttons + '<br><br><button onclick="javascript: $(\'#btn_' + d.id_prospecto + '\').removeClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').addClass(\'hide\'); " class="btn btn btn-round btn-fab btn-fab-mini" style="background-color: orangered"><span class="material-icons">keyboard_arrow_down</span></button></div>';
                            return actions;
                        }
                    }
                } else if (typeTransaction == 1) { // Ventas
                    if (userType != "19") { // Subdirecctor MKTD puede ver listado todos los prospectos pero no tiene ninguna acción sobre ellos
                        if (userType == "3" || userType == "6") { // Array de roles permitidos para reasignar
                            if (d.estatus == 1) {
                                var actions = '';
                                var group_buttons = '';
                                group_buttons = '<button class="btn btn-warning btn-round btn-fab btn-fab-mini to-comment" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px" rel="tooltip" data-placement="left" title="Ingresar comentario"><i class="material-icons">comment</i></button>' +
                                    '<button class="btn btn-success btn-round btn-fab btn-fab-mini edit-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;background-color:#2874A6;border-color:#21618C" rel="tooltip" data-placement="left" title="Editar información"><i class="material-icons">edit</i></button>' +
                                    '<button class="btn btn btn-round btn-fab btn-fab-mini see-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;" rel="tooltip" data-placement="left" title="Ver información"><i class="material-icons">remove_red_eye</i></button>' +
                                    '<button class="btn btn-success btn-round btn-fab btn-fab-mini update-status-preventa" data-id-prospecto="' + d.id_prospecto + '" style="background-color:#2C3E50;border-color:#2C3E50"><i class="material-icons" title="Actualizar estatus">refresh</i></button>';

                                actions += '<button class="desplegable btn btn btn-round btn-fab btn-fab-mini" id="btn_' + d.id_prospecto + '" onclick="javascript: $(this).addClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').removeClass(\'hide\'); "><span class="material-icons">keyboard_arrow_up</span></button>';
                                actions += '<div class="hide" id="cnt_' + d.id_prospecto + '">' + group_buttons + '<br><br><button onclick="javascript: $(\'#btn_' + d.id_prospecto + '\').removeClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').addClass(\'hide\'); " class="btn btn btn-round btn-fab btn-fab-mini" style="background-color: orangered"><span class="material-icons">keyboard_arrow_down</span></button></div>';
                                return actions;
                            } else {
                                var actions = '';
                                var group_buttons = '';
                                group_buttons = '<button class="btn btn-warning btn-round btn-fab btn-fab-mini to-comment" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px" rel="tooltip" data-placement="left" title="Ingresar comentario"><i class="material-icons">comment</i></button>' +
                                    '<button class="btn btn-success btn-round btn-fab btn-fab-mini edit-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;background-color:#2874A6;border-color:#21618C" rel="tooltip" data-placement="left" title="Editar información"><i class="material-icons">edit</i></button>' +
                                    '<button class="btn btn btn-round btn-fab btn-fab-mini see-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;" rel="tooltip" data-placement="left" title="Ver información"><i class="material-icons">remove_red_eye</i></button>' +
                                    '<button class="btn btn-success btn-round btn-fab btn-fab-mini update-status-preventa" data-id-prospecto="' + d.id_prospecto + '" style="background-color:#2C3E50;border-color:#2C3E50"><i class="material-icons" title="Actualizar estatus">refresh</i></button>';

                                actions += '<button class="desplegable btn btn btn-round btn-fab btn-fab-mini" id="btn_' + d.id_prospecto + '" onclick="javascript: $(this).addClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').removeClass(\'hide\'); "><span class="material-icons">keyboard_arrow_up</span></button>';
                                actions += '<div class="hide" id="cnt_' + d.id_prospecto + '">' + group_buttons + '<br><br><button onclick="javascript: $(\'#btn_' + d.id_prospecto + '\').removeClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').addClass(\'hide\'); " class="btn btn btn-round btn-fab btn-fab-mini" style="background-color: orangered"><span class="material-icons">keyboard_arrow_down</span></button></div>';
                                return actions;
                            }
                        } else {
                            if (d.estatus == 1) {
                                var actions = '';
                                var group_buttons = '';
                                group_buttons = '<button class="btn btn-warning btn-round btn-fab btn-fab-mini to-comment" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px" rel="tooltip" data-placement="left" title="Ingresar comentario"><i class="material-icons">comment</i></button>' +
                                    '<button class="btn btn-success btn-round btn-fab btn-fab-mini edit-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;background-color:#2874A6;border-color:#21618C" rel="tooltip" data-placement="left" title="Editar información"><i class="material-icons">edit</i></button>' +
                                    '<button class="btn btn btn-round btn-fab btn-fab-mini see-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;" rel="tooltip" data-placement="left" title="Ver información"><i class="material-icons">remove_red_eye</i></button>' +
                                    '<button class="btn btn-success btn-round btn-fab btn-fab-mini update-status-preventa" data-id-prospecto="' + d.id_prospecto + '" style="background-color:#2C3E50;border-color:#2C3E50"><i class="material-icons" title="Actualizar estatus">refresh</i></button>';

                                actions += '<button class="desplegable btn btn btn-round btn-fab btn-fab-mini" id="btn_' + d.id_prospecto + '" onclick="javascript: $(this).addClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').removeClass(\'hide\'); "><span class="material-icons">keyboard_arrow_up</span></button>';
                                actions += '<div class="hide" id="cnt_' + d.id_prospecto + '">' + group_buttons + '<br><br><button onclick="javascript: $(\'#btn_' + d.id_prospecto + '\').removeClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').addClass(\'hide\'); " class="btn btn btn-round btn-fab btn-fab-mini" style="background-color: orangered"><span class="material-icons">keyboard_arrow_down</span></button></div>';
                                return actions;
                            } else {
                                var actions = '';
                                var group_buttons = '';
                                group_buttons = '<button class="btn btn-warning btn-round btn-fab btn-fab-mini to-comment" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px" rel="tooltip" data-placement="left" title="Ingresar comentario"><i class="material-icons">comment</i></button>' +
                                    '<button class="btn btn-success btn-round btn-fab btn-fab-mini edit-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;background-color:#2874A6;border-color:#21618C" rel="tooltip" data-placement="left" title="Editar"><i class="material-icons">edit</i></button>' +
                                    '<button class="btn btn btn-round btn-fab btn-fab-mini see-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;"><i class="material-icons" rel="tooltip" data-placement="left" title="Ver información">remove_red_eye</i></button>' +
                                    '<button class="btn btn-success btn-round btn-fab btn-fab-mini update-status-preventa" data-id-prospecto="' + d.id_prospecto + '" style="background-color:#2C3E50;border-color:#2C3E50"><i class="material-icons" title="Actualizar estatus">refresh</i></button>';

                                if (d.vigencia >= 0 /*< 5 && d.fecha_creacion >= '2021-04-19 23:59:59.000'*/) {
                                	group_buttons += '<button class="btn btn btn-round btn-fab btn-fab-mini update-validity" data-id-prospecto="' + d.id_prospecto + '" style="background-color:#CB4335;border-color:#4cae4c" rel="tooltip" data-placement="left" title="Renovar vigencia"><i class="material-icons">update</i></button>';
                                }

                                actions += '<button class="desplegable btn btn btn-round btn-fab btn-fab-mini" id="btn_' + d.id_prospecto + '" onclick="javascript: $(this).addClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').removeClass(\'hide\'); "><span class="material-icons">keyboard_arrow_up</span></button>';
                                actions += '<div class="hide" id="cnt_' + d.id_prospecto + '">' + group_buttons + '<br><br><button onclick="javascript: $(\'#btn_' + d.id_prospecto + '\').removeClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').addClass(\'hide\'); " class="btn btn btn-round btn-fab btn-fab-mini" style="background-color: orangered"><span class="material-icons">keyboard_arrow_down</span></button></div>';
                                return actions;
                            }
                        }
                    } else {
                        return '';
                    }
                }
            }
        }
    ],
    columnDefs: [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        },

    ],
    "ajax": {
        "url": "getProspectsPreventaList/" + typeTransaction,
        "type": "POST",
        cache: false,
        "data": function(d) {}
    }

});

/*--------------------------------------*/

function getPersonsWhoRecommends() {
    $.getJSON("getCAPListByAdvisor").done(function(data) {
        $("#specify_recommends").append($('<option disabled selected="true">').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            var type = data[i]['tipo'];
            $("#specify_recommends").append($('<option>').val(id).attr('data-type', type).text(name));
        }
    });
}

function getRecommendationData() {
    type = $("#specify_recommends option:selected").attr('data-type');
    console.log(type);
    $("#type_recomendado").val(type);
}

function showSpecificationObject() {
    pp = document.getElementById('prospecting_place');
    pp = pp.value;
    if (pp == 3 || pp == 7 || pp == 9 || pp == 10) { // SPECIFY OPTION
        $("#specify").removeAttr("style");
    } else if (pp == 6) { // SPECIFY MKTD OPTION
        $("#specify_mkt").removeAttr("style");
    } else if (pp == 21) { // RECOMMENDED SPECIFICATION
        $("#specify_recommends").removeAttr("style");
    } else { // WITHOUT SPECIFICATION
        $("#specify").removeAttr("style");
    }
}

function cleanCombos() {
    $("#specify").val("0");
    $("#specify_mkt").val("0");
    $("#specify_recommends").val("0");

    $("#specify").css({ "display": "none" });
    $("#specify_mkt").css({ "display": "none" });
    $("#specify_recommends").css({ "display": "none" });
}


/*DE AQUÍ VA MI CAMBIO*/


function validateParticularStatus(element) {
    estatus = $('option:selected', element).val();
    if (estatus == 6) { // IT'S PRESALE
        document.getElementById("datatoassign").style.display = "block";
    } else { // IT'S NOT PRESALE
        document.getElementById("datatoassign").style.display = "none";
        $("#condominio").empty().selectpicker('refresh');
        $("#lote").empty().selectpicker('refresh');
    }
}

function getCondominioDisponible(element) {
    proyecto = $('option:selected', element).val();
    $("#condominio").find("option").remove();
    $("#condominio").append($('<option disabled>').val("0").text("Seleccione una opción"));
    $.post('getCondominioDisponible/' + proyecto, function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idCondominio'];
            var name = data[i]['nombre'];
            $("#condominio").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#condominio").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#condominio").selectpicker('refresh');
    }, 'json');
}

function getLoteDisponible(element) {
    condominio = $('option:selected', element).val();
    $("#lote").find("option").remove();
    $("#lote").append($('<option disabled>').val("0").text("Seleccione una opción"));
    $.post('getLoteDisponible/' + condominio, function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idLote'];
            var name = data[i]['nombreLote'];
            $("#lote").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#lote").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#lote").selectpicker('refresh');
    }, 'json');
}

function clean(element) {
    if (element == 1) { // PROYTECTO CHANGED
        $("#condominio").empty().selectpicker('refresh');
        $("#lote").empty().selectpicker('refresh');
        $("#houseType").val('');
        $("#houseType").selectpicker('refresh');
        document.getElementById("housesDetail").style.display = "none";
    } else if (element == 2) { // CONDOMINIO CHANGED
        $("#lote").empty().selectpicker('refresh');
        $("#houseType").val('');
        $("#houseType").selectpicker('refresh');
    } else if (element == 3) { // LOTE CHANGED
        $("#houseType").val('');
        $("#houseType").selectpicker('refresh');
    }
}

function validateHouses() {
    proyecto = $("#proyecto").val();
    /*condominio = $("#proyecto").val();
    lote = $('option:selected', element).val();*/
    if (proyecto == 17) {
        document.getElementById("housesDetail").style.display = "block";
    } else {
        $("#houseType").val('');
        $("#houseType").selectpicker('refresh');
        document.getElementById("housesDetail").style.display = "none";
    }
}

$(document).on('click', '.change-pl', function () { // MJ: FUNCIÓN CAMBIO DE ESTATUS ACTIVO / INACTIVO
    id_prospecto = $(this).attr("data-id-prospecto");
    $.ajax({
        type: 'POST',
        url: 'change_lp',
        data: {
            'id': id_prospecto,
            'lugar_p': 11
        },
        dataType: 'json',
        success: function (data) {
            if (data == 1) {
                alerts.showNotification("top", "right", "El lugar de prospección se ha actualizado con éxito.", "success");
                prospectsTable.ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
            }
        }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});
