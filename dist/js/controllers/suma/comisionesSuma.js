$("#tabla_nuevas_comisiones").ready(function() {
    $('#tabla_nuevas_comisiones thead tr:eq(0) th').each( function (i) {
        if( i != 0 ){
            var title = $(this).text();  
            $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function() {
                if (tabla_nuevas.column(i).search() !== this.value) {
                    tabla_nuevas.column(i).search(this.value).draw();

                    var total = 0;
                    var index = tabla_nuevas.rows({
                        selected: true,
                        search: 'applied'
                    }).indexes();
                    var data = tabla_nuevas.rows(index).data();

                    $.each(data, function(i, v) {
                        total += parseFloat(v.total_comision);
                    });
                    var to1 = formatMoney(total);
                    document.getElementById("myText_nuevas").textContent = '$' + formatMoney(total);
                }
            });
        } else {
            $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
        }
    });

    $('#tabla_nuevas_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json, function(i, v) {
            total += parseFloat(v.total_comision);
        });
        var to = formatMoney(total);
        document.getElementById("myText_nuevas").textContent = '$' + to;
    });

    tabla_nuevas = $("#tabla_nuevas_comisiones").DataTable({
        dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        buttons: [
        
            {
                text: '<i class="fa fa-paper-plane"></i> SOLICITAR PAGO',
                action: function() {
                    let actual=13;
                    if(userSede == 8){
                        actual=15;

                    }
                    var hoy = new Date();
                    var dia = hoy.getDate();
                    var mes = hoy.getMonth()+1;
                    var anio = hoy.getFullYear();
                    var hora = hoy.getHours();
                    var minuto = hoy.getMinutes();

                    if (((mes == 10 && dia == 10) || (mes == 10 && dia == 11 && hora <= 13)) ||
                    ((mes == 11 && dia == 7) || (mes == 11 && dia == 8 && hora <= 13)) ||
                    ((mes == 12 && dia == 12) || (mes == 12 && dia == 13 && hora <= 13))){

                        if ($('input[name="idT[]"]:checked').length > 0) {
                            $('#spiner-loader').removeClass('hide');
                            
                            var idcomision = $('#tabla_nuevas_comisiones input[name="idT[]"]:checked').map(function() {
                                return this.value;
                            }).get();
                            
                            var com2 = new FormData();
                            com2.append("idcomision", idcomision); 

                            $.ajax({
                                url : url2 + 'Suma/acepto_comisiones_user/',
                                data: com2,
                                cache: false,
                                contentType: false,
                                processData: false,
                                type: 'POST', 
                                success: function(data){
                                response = JSON.parse(data);
                                    if(data == 1) {
                                        $('#spiner-loader').addClass('hide');
                                        $("#totpagarPen").html(formatMoney(0));
                                        $("#all").prop('checked', false);
                                        var fecha = new Date();

                                        alerts.showNotification("top", "right", "Las comisiones se han enviado exitosamente a Contraloría.", "success");

                                        tabla_nuevas.ajax.reload();
                                        tabla_revision.ajax.reload();
                                    } else {
                                        $('#spiner-loader').addClass('hide');
                                        alerts.showNotification("top", "right", "Error al enviar comisiones, intentalo más tarde", "danger");
                                    }
                                },
                                error: function( data ){
                                        $('#spiner-loader').addClass('hide');
                                        alerts.showNotification("top", "right", "Error al enviar comisiones, intentalo más tarde", "danger");
                                }
                            });
                        }
                    }
                    else{
                        $('#spiner-loader').addClass('hide');
                        alerts.showNotification("top", "right", "No se pueden enviar comisiones, esperar al siguiente corte", "warning");      
                    }
                },
                attr: {
                    class: 'btn btn-azure',
                    style: 'position:relative; float:right'
                }
            }, 
        
        {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COMISIONES SUMA NUEVAS',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9],
                format: {
                    header:  function (d, columnIdx) {
                        if(columnIdx == 0){
                            return ' '+d +' ';
                        }else if(columnIdx == 1){
                            return 'ID PAGO';
                        }else if(columnIdx == 2){
                            return 'REFERENCIA';
                        }else if(columnIdx == 3){
                            return 'NOMBRE COMISIONISTA';
                        }else if(columnIdx == 4){
                            return 'SEDE';
                        }else if(columnIdx == 5){
                            return 'FORMA PAGO';
                        }else if(columnIdx == 6){
                            return 'TOTAL COMISIÓN';
                        }else if(columnIdx == 7){
                            return 'IMPUESTO';
                        }else if(columnIdx == 8){
                            return '% COMISIÓN';
                        }else if(columnIdx == 9){
                            return 'ESTATUS';
                        }
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            "width": "5%"
        },
        {
            "width": "5%",
            "data": function(d) {
                return '<p class="m-0">' + d.id_pago_suma + '</p>';
            }
        },
        {
            "width": "5%",
            "data": function(d) {
                return '<p class="m-0">' + d.referencia + '</p>';
            }
        },
        {
            "width": "9%",
            "data": function(d) {
                return '<p class="m-0"><b>' + d.nombre_comisionista + '</b></p>';
            }
        },
        {
            "width": "5%",
            "data": function(d) {
                return '<p class="m-0"><b>' + d.sede + '</b></p>';
            }
        },
        {
            "width": "5%",
            "data": function(d) {
                return '<p class="m-0"><b>' + d.forma_pago + '</b></p>';
            }
        },
        {
            "width": "9%",
            "data": function(d) {
                return '<p class="m-0">$' + formatMoney(d.total_comision) + '</p>';
            }
        },
        {
            "width": "9%",
            "data": function(d) {
                return '<p class="m-0">$' + formatMoney(d.impuesto) + '</p>';
            }
        },
        {
            "width": "5%",
            "data": function(d) {
                return '<p class="m-0"><b>' + d.porcentaje_comision + '%</b></p>';
            }
        },
        {
            "width": "9%",
            "data": function(d) {
                switch (d.forma_pago) {
                    case '1': //SIN DEFINIR
                    case 1: //SIN DEFINIr
                        return '<p class="mb-1"><span class="label" style="background:#B3B4B4;">SIN DEFINIR FORMA DE PAGO</span><br><span class="label" style="background:#EED943; color:black;">REVISAR CON RH</span></p>';

                    case '2': //FACTURA
                    case 2: //FACTURA
                        return '<p class="mb-1"><span class="label" style="background:#806AB7;">FACTURA</span></p><p style="font-size: .5em"><span class="label" style="background:#EB6969;">SUBIR XML</span></p>';

                    case '3': //ASIMILADOS
                    case 3: //ASIMILADOS
                        return '<p class="mb-1"><span class="label" style="background:#4B94CC;">ASIMILADOS</span></p><p style="font-size: .5em"><span class="label" style="background:#00B397;">LISTA PARA APROBAR</span></p>';

                    case '4': //RD
                    case 4: //RD
                        return '<p class="mb-1"><span class="label" style="background:#6D527E;">REMANENTE DIST.</span></p><p style="font-size: .5em"><span class="label" style="background:#00B397;">LISTA PARA APROBAR</span></p>';

                    case '5':
                    case 5:
                        return `
                            <p class="mb-1">
                                <span class="label" style="background:#0080FF;">FACTURA EXTRANJERO</span>
                            </p>
                        `;
                    default:
                        return '<p class="mb-1"><span class="label" style="background:#B3B4B4;">DOCUMENTACIÓN FALTANTE</span><br><span class="label" style="background:#EED943; color:black;">REVISAR CON RH</span></p>';
                }
            }
        },
        {
            "width": "5%",
            "orderable": false,
            "data": function(data) {
                return '<button href="#" value="'+data.id_pago_suma+'"  data-referencia="'+data.referencia+'" ' +'class="btn-data btn-blueMaderas consultar_history" title="Detalles">' +'<i class="fas fa-info"></i></button>';

            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
            searchable: false,
            className: 'dt-body-center',
            render: function(d, type, full, meta) {
                let actual=13;
                if(userSede == 8){
                    actual=15;

                }
                var hoy = new Date();
                var dia = hoy.getDate();
                var mes = hoy.getMonth()+1;
                var anio = hoy.getFullYear();
                var hora = hoy.getHours();
                var minuto = hoy.getMinutes();



                if (((mes == 10 && dia == 10) || (mes == 10 && dia == 11 && hora <= 13)) ||
                ((mes == 11 && dia == 7) || (mes == 11 && dia == 8 && hora <= 13)) ||
                ((mes == 12 && dia == 12) || (mes == 12 && dia == 13 && hora <= 13)))
                {

                    switch (full.forma_pago) {
                        case '1': //SIN DEFINIR
                        case 1: //SIN DEFINIR
                        case '2': //FACTURA
                        case 2: //FACTURA
                            return '<span class="material-icons" style="color: #DCDCDC;">block</span>';
                        break;

                        case '5':
                        case 5:
                            if (full.fecha_abono && full.estatus == 1) {
                                const fechaAbono = new Date(full.fecha_abono);
                                const fechaOpinion = new Date(full.fecha_opinion);
                                if (fechaAbono.getTime() > fechaOpinion.getTime()) {
                                    return '<span class="material-icons" style="color: #DCDCDC;">block</span>';
                                }
                            }
                            return '<input type="checkbox" name="idT[]" style="width:20px;height:20px;"  value="' + full.id_pago_suma + '">';

                        case '3': //ASIMILADOS
                        case 3: //ASIMILADOS
                        case '4': //RD
                        case 4: //RD
                        default:

                        if (full.id_usuario == 5028  || full.id_usuario == 4773 || full.id_usuario == 5381 ){
                            return '<span class="material-icons" style="color: #DCDCDC;">block</span>';

                        } else {
                            return '<input type="checkbox" name="idT[]" style="width:20px;height:20px;"  value="' + full.id_pago_suma + '">';
                        }
                        break;
                    }
                } else {
                    return '<span class="material-icons" style="color: #DCDCDC;">block</span>';
                }
            },
        }],
        ajax: {
            url: url2 + "Suma/getComisionesByStatus",
            type: "POST",
            data: {estatus: 1},
            dataType: 'json',
            dataSrc: ""
        },
    });

    $("#tabla_nuevas_comisiones tbody").on("click", ".consultar_history", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        referencia = $(this).attr("data-referencia");

        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").html("");
        $("#comments-list-asimilados").html("");
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DE LA REFERENCIA <b style="color:#39A1C0; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+referencia+'</b></h5></p>');
        $.getJSON("getHistorial/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:39A1C0;">'+v.comentario+'</i><br><b style="color:#39A1C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.modificado_por+'</b></p></div>');
            });
        });
    });
});
/* End table nuevas */ 

/* Table revisión */
$("#tabla_revision_comisiones").ready(function() {

    $('#tabla_revision_comisiones thead tr:eq(0) th').each( function (i) {
        if( i != 9 ){
            var title = $(this).text();  
            $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function() {
                if (tabla_revision.column(i).search() !== this.value) {
                    tabla_revision.column(i).search(this.value).draw();

                    var total = 0;
                    var index = tabla_revision.rows({
                        selected: true,
                        search: 'applied'
                    }).indexes();
                    var data = tabla_revision.rows(index).data();

                    $.each(data, function(i, v) {
                        total += parseFloat(v.total_comision);
                    });
                    var to1 = formatMoney(total);
                    document.getElementById("myText_revision").textContent = '$' + formatMoney(total);
                }
            });
        }
    });

    $('#tabla_revision_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json, function(i, v) {
            total += parseFloat(v.total_comision);
        });
        var to = formatMoney(total);
        document.getElementById("myText_revision").textContent = '$' + to;
    });

    tabla_revision = $("#tabla_revision_comisiones").DataTable({
        dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COMISIONES SUMA EN REVISIÓN',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8],
                format: {
                    header:  function (d, columnIdx) {
                        if(columnIdx == 0){
                            return 'ID PAGO';
                        }else if(columnIdx == 1){
                            return 'REFERENCIA';
                        }else if(columnIdx == 2){
                            return 'NOMBRE COMISIONISTA';
                        }else if(columnIdx == 3){
                            return 'SEDE';
                        }else if(columnIdx == 4){
                            return 'FORMA PAGO';
                        }else if(columnIdx == 5){
                            return 'TOTAL COMISIÓN';
                        }else if(columnIdx == 6){
                            return 'IMPUESTO';
                        }else if(columnIdx == 7){
                            return '% COMISIÓN';
                        }else if(columnIdx == 8){
                            return 'ESTATUS';
                        }
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            "width": "5%",
            "data": function(d) {
                return '<p class="m-0">' + d.id_pago_suma + '</p>';
            }
        },
        {
            "width": "5%",
            "data": function(d) {
                return '<p class="m-0">' + d.referencia + '</p>';
            }
        },
        {
            "width": "9%",
            "data": function(d) {
                return '<p class="m-0"><b>' + d.nombre_comisionista + '</b></p>';
            }
        },
        {
            "width": "5%",
            "data": function(d) {
                return '<p class="m-0"><b>' + d.sede + '</b></p>';
            }
        },
        {
            "width": "5%",
            "data": function(d) {
                return '<p class="m-0"><b>' + d.forma_pago + '</b></p>';
            }
        },
        {
            "width": "9%",
            "data": function(d) {
                return '<p class="m-0">$' + formatMoney(d.total_comision) + '</p>';
            }
        },
        {
            "width": "9%",
            "data": function(d) {
                return '<p class="m-0">$' + formatMoney(d.impuesto) + '</p>';
            }
        },
        {
            "width": "5%",
            "data": function(d) {
                return '<p class="m-0"><b>' + d.porcentaje_comision + '%</b></p>';
            }
        },
        {
            "width": "9%",
            "data": function(d) {
                switch (d.forma_pago) {
                    case '1': //SIN DEFINIR
                    case 1: //SIN DEFINIr
                        return '<p class="mb-1"><span class="label" style="background:#B3B4B4;">SIN DEFINIR FORMA DE PAGO</span><br><span class="label" style="background:#EED943; color:black;">REVISAR CON RH</span></p>';

                    case '2': //FACTURA
                    case 2: //FACTURA
                        return '<p class="mb-1"><span class="label" style="background:#806AB7;">FACTURA</span></p><p style="font-size: .5em"><span class="label" style="background:#EB6969;">SUBIR XML</span></p>';

                    case '3': //ASIMILADOS
                    case 3: //ASIMILADOS
                        return '<p class="mb-1"><span class="label" style="background:#4B94CC;">ASIMILADOS</span></p><p style="font-size: .5em"><span class="label" style="background:#00B397;">LISTA PARA APROBAR</span></p>';

                    case '4': //RD
                    case 4: //RD
                        return '<p class="mb-1"><span class="label" style="background:#6D527E;">REMANENTE DIST.</span></p><p style="font-size: .5em"><span class="label" style="background:#00B397;">LISTA PARA APROBAR</span></p>';

                    case '5':
                    case 5:
                        return `
                            <p class="mb-1">
                                <span class="label" style="background:#0080FF;">FACTURA EXTRANJERO</span>
                            </p>
                        `;
                    default:
                        return '<p class="mb-1"><span class="label" style="background:#B3B4B4;">DOCUMENTACIÓN FALTANTE</span><br><span class="label" style="background:#EED943; color:black;">REVISAR CON RH</span></p>';
                }
            }
        },
        {
            "width": "5%",
            "orderable": false,
            "data": function(data) {
                return '<button href="#" value="'+data.id_pago_suma+'"  data-referencia="'+data.referencia+'" ' +'class="btn-data btn-blueMaderas consultar_history" title="Detalles">' +'<i class="fas fa-info"></i></button>';

            }
        }],
        ajax: {
            url: url2 + "Suma/getComisionesByStatus",
            type: "POST",
            data: {estatus: 2},
            dataType: 'json',
            dataSrc: ""
        },
    });

    $("#tabla_revision_comisiones tbody").on("click", ".consultar_history", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        referencia = $(this).attr("data-referencia");

        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").html("");
        $("#comments-list-asimilados").html("");
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DE LA REFERENCIA <b style="color:#39A1C0; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+referencia+'</b></h5></p>');
        $.getJSON("getHistorial/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:39A1C0;">'+v.comentario+'</i><br><b style="color:#39A1C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.modificado_por+'</b></p></div>');
            });
        });
    });
});

// /* Table pagadas */
$("#tabla_pagadas_comisiones").ready(function() {
    $('#tabla_pagadas_comisiones thead tr:eq(0) th').each( function (i) {
        if( i != 9 ){
            var title = $(this).text();  
            $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function() {
                if (tabla_pagadas.column(i).search() !== this.value) {
                    tabla_pagadas.column(i).search(this.value).draw();

                    var total = 0;
                    var index = tabla_pagadas.rows({
                        selected: true,
                        search: 'applied'
                    }).indexes();
                    var data = tabla_pagadas.rows(index).data();

                    $.each(data, function(i, v) {
                        total += parseFloat(v.total_comision);
                    });
                    var to1 = formatMoney(total);
                    document.getElementById("myText_pagadas").textContent = '$' + formatMoney(total);
                }
            });
        }
    });

    $('#tabla_pagadas_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json, function(i, v) {
            total += parseFloat(v.total_comision);
        });
        var to = formatMoney(total);
        document.getElementById("myText_pagadas").textContent = '$' + to;
    });

    tabla_pagadas = $("#tabla_pagadas_comisiones").DataTable({
        dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COMISIONES SUMA PAGADAS',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8],
                format: {
                    header:  function (d, columnIdx) {
                        if(columnIdx == 0){
                            return 'ID PAGO';
                        }else if(columnIdx == 1){
                            return 'REFERENCIA';
                        }else if(columnIdx == 2){
                            return 'NOMBRE COMISIONISTA';
                        }else if(columnIdx == 3){
                            return 'SEDE';
                        }else if(columnIdx == 4){
                            return 'FORMA PAGO';
                        }else if(columnIdx == 5){
                            return 'TOTAL COMISIÓN';
                        }else if(columnIdx == 6){
                            return 'IMPUESTO';
                        }else if(columnIdx == 7){
                            return '% COMISIÓN';
                        }else if(columnIdx == 8){
                            return 'ESTATUS';
                        }
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            "width": "5%",
            "data": function(d) {
                return '<p class="m-0">' + d.id_pago_suma + '</p>';
            }
        },
        {
            "width": "5%",
            "data": function(d) {
                return '<p class="m-0">' + d.referencia + '</p>';
            }
        },
        {
            "width": "9%",
            "data": function(d) {
                return '<p class="m-0"><b>' + d.nombre_comisionista + '</b></p>';
            }
        },
        {
            "width": "5%",
            "data": function(d) {
                return '<p class="m-0"><b>' + d.sede + '</b></p>';
            }
        },
        {
            "width": "5%",
            "data": function(d) {
                return '<p class="m-0"><b>' + d.forma_pago + '</b></p>';
            }
        },
        {
            "width": "9%",
            "data": function(d) {
                return '<p class="m-0">$' + formatMoney(d.total_comision) + '</p>';
            }
        },
        {
            "width": "9%",
            "data": function(d) {
                return '<p class="m-0">$' + formatMoney(d.impuesto) + '</p>';
            }
        },
        {
            "width": "5%",
            "data": function(d) {
                return '<p class="m-0"><b>' + d.porcentaje_comision + '%</b></p>';
            }
        },
        {
            "width": "9%",
            "data": function(d) {
                switch (d.forma_pago) {
                    case '1': //SIN DEFINIR
                    case 1: //SIN DEFINIr
                        return '<p class="mb-1"><span class="label" style="background:#B3B4B4;">SIN DEFINIR FORMA DE PAGO</span><br><span class="label" style="background:#EED943; color:black;">REVISAR CON RH</span></p>';

                    case '2': //FACTURA
                    case 2: //FACTURA
                        return '<p class="mb-1"><span class="label" style="background:#806AB7;">FACTURA</span></p><p style="font-size: .5em"><span class="label" style="background:#EB6969;">SUBIR XML</span></p>';

                    case '3': //ASIMILADOS
                    case 3: //ASIMILADOS
                        return '<p class="mb-1"><span class="label" style="background:#4B94CC;">ASIMILADOS</span></p><p style="font-size: .5em"><span class="label" style="background:#00B397;">LISTA PARA APROBAR</span></p>';

                    case '4': //RD
                    case 4: //RD
                        return '<p class="mb-1"><span class="label" style="background:#6D527E;">REMANENTE DIST.</span></p><p style="font-size: .5em"><span class="label" style="background:#00B397;">LISTA PARA APROBAR</span></p>';

                    case '5':
                    case 5:
                        return `
                            <p class="mb-1">
                                <span class="label" style="background:#0080FF;">FACTURA EXTRANJERO</span>
                            </p>
                        `;
                    default:
                        return '<p class="mb-1"><span class="label" style="background:#B3B4B4;">DOCUMENTACIÓN FALTANTE</span><br><span class="label" style="background:#EED943; color:black;">REVISAR CON RH</span></p>';
                }
            }
        },
        {
            "width": "5%",
            "orderable": false,
            "data": function(data) {
                return '<button href="#" value="'+data.id_pago_suma+'"  data-referencia="'+data.referencia+'" ' +'class="btn-data btn-blueMaderas consultar_history" title="Detalles">' +'<i class="fas fa-info"></i></button>';

            }
        }],
        ajax: {
            url: url2 + "Suma/getComisionesByStatus",
            type: "POST",
            data: {estatus: 3},
            dataType: 'json',
            dataSrc: ""
        },
    });

    $("#tabla_pagadas_comisiones tbody").on("click", ".consultar_history", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        referencia = $(this).attr("data-referencia");

        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").html("");
        $("#comments-list-asimilados").html("");
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DE LA REFERENCIA <b style="color:#39A1C0; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+referencia+'</b></h5></p>');
        $.getJSON("getHistorial/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:39A1C0;">'+v.comentario+'</i><br><b style="color:#39A1C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.modificado_por+'</b></p></div>');
            });
        });
    });
});