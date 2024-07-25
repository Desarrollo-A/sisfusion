$(document).ready(function () {
    $.post(`${general_base_url}Contratacion/lista_proyecto`, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#idResidencial").append($('<option>').val(data[i]['idResidencial']).text(data[i]['descripcion']));
        }
        $("#idResidencial").selectpicker('refresh');
    }, 'json');

    $.post(`${general_base_url}Contratacion/lista_estatus`, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#idEstatus").append($('<option>').val(data[i]['idStatusLote']).text(data[i]['nombre']));
        }
        $("#idEstatus").selectpicker('refresh');
    }, 'json');

    $.post(`${general_base_url}Contratacion/sedesPorDesarrollos`, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_sede'];
            var name = data[i]['nombre'];
            $("#sedes").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#sedes").selectpicker('refresh');
    }, 'json');
});
sp = { 
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

$(document).ready(function () {
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setIniDatesXMonth('#beginDate','#endDate');
});

$(document).on('click', '#date-label', function() {   
    $('#date-picker-input').datepicker('show');
})


$('#idResidencial').change(function () {
    $('#spiner-loader').removeClass('hide'); 
    $('#tablaInventario').removeClass('hide');
    index_idResidencial = $(this).val();
    $("#idCondominioInventario").html("");
    $(document).ready(function () {
        $.post(`${general_base_url}Contratacion/lista_condominio/${index_idResidencial}`, function (data) {
            for (var i = 0; i < data.length; i++) {
                $("#idCondominioInventario").append($('<option>').val(data[i]['idCondominio']).text(data[i]['nombre']));
            }
            $("#idCondominioInventario").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }, 'json');
    });
});

let titulosInventario = [];
$('#tablaInventario thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulosInventario.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tablaInventario').DataTable().column(i).search() !== this.value) {
            $('#tablaInventario').DataTable().column(i).search(this.value).draw();
        }
    });
});

$(document).on('change', '#idResidencial, #idCondominioInventario, #idEstatus', function () {
    ix_idResidencial = ($("#idResidencial").val().length <= 0) ? 0 : $("#idResidencial").val();
    ix_idCondominio = $("#idCondominioInventario").val() == '' ? 0 : $("#idCondominioInventario").val();
    ix_idEstatus = $("#idEstatus").val() == '' ? 0 : $("#idEstatus").val();
    tabla_inventario = $("#tablaInventario").DataTable({
        dom: "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'B><'col-12 col-sm-12 col-md-6 col-lg-6 p-0'f>rt>"+"<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        destroy: true,
        searching: true,
        ajax: {
            url: `${general_base_url}Contratacion/get_inventario/${ix_idEstatus}/${ix_idCondominio}/${ix_idResidencial}`,
            dataSrc: ""
        },
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'Inventario lotes',
            exportOptions: {
                columns: coordinador = (id_rol_general == 11 || id_rol_general == 17 || id_rol_general == 63 || id_rol_general == 70)   ? [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33] : ( (id_usuario_general == 2748 || id_usuario_general == 5957) ? [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 24, 27, 28, 29, 30, 31]  : ((id_usuario_general==9495) ? [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 24, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 5, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67]: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 26, 27, 28, 29, 30, 31])),
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulosInventario[columnIdx] + ' ';
                    }
                }
            }
        },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                className: 'btn buttons-pdf',
                titleAttr: 'PDF',
                title: 'Inventario lotes',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 22],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosInventario[columnIdx]  + ' ';
                        }
                    }
                }
            }],
        columnDefs: [{
            /*targets: [22, 23, 24, 32],
            visible: coordinador = ((id_rol_general == 11 || id_rol_general == 17 || id_rol_general == 63 || id_rol_general == 70) || (id_usuario_general == 2748 || id_usuario_general == 5957)) ? true : false
            */
        }],
        pagingType: "full_numbers",
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: false,
        pageLength: 10,
        bAutoWidth: false,
        bLengthChange: false,
        bInfo: true,
        paging: true,
        ordering: true,
        fixedColumns: true,
        columns: [{
            data: 'nombreResidencial'
        },
            {
                data: 'nombreCondominio'
            },
            {
                data: function (d) {
                    if (d.casa == 1)
                        return `${d.nombreLote} <br><span class="label lbl-violetDeep">${d.nombre_tipo_casa}</span>`
                    else
                        return d.nombreLote;
                }
            },
            { data: 'idLote' },
            {
                data: function (d) {
                    return d.superficie + ' <b>m<sup>2</sup></b>';
                }
            },
            {
                data: function (d) {
                    return formatMoney(d.precio * d.sup);
                }
            },
            {
                data: function (d) {
                    return formatMoney(d.totalNeto2);
                }
            },
            {
                data: function (d) {
                    return formatMoney(d.precio);
                }
            },
            { data: 'referencia' },
            { data: 'msni' },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.asesor2;
                    else
                        return d.asesor;
                }
            },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.coordinador2;
                    else
                        return d.coordinador;
                }
            },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.gerente2;
                    else
                        return d.gerente;
                }
            },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.subdirector2;
                    else
                        return d.subdirector;
                }
            },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.regional22;
                    else
                        return d.regional;
                }
            },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return 'SIN ESPECIFICAR';
                    else
                        return d.regional2;
                }
            },
            {
                data: function (d) {
                    let libContraloria = (d.observacionContratoUrgente == '1') ? '<center><span class="label lbl-pink">Lib. Contraloría</span> <center><p><p>' : '';
                    return d.tipo_venta == null ?
                        `<center><span class="label" style="background:#${d.background_sl}18; color:#${d.color};">${d.descripcion_estatus}</span> ${libContraloria} <center>` :
                        `<center><span class="label" style="background:#${d.background_sl}18; color:#${d.color};">${d.descripcion_estatus}</span> <p><p> <span class="label lbl-green">${d.tipo_venta}</span> ${libContraloria} <center>`;
                }
            },
            { data: 'statusContratacion' },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.fecha_modst;
                    else
                        return d.fechaApartado;
                }
            },
            {
                data: function (d) {
                    if (d.comentario == null || d.comentario == 'NULL' || d.comentario == '')
                        return 'SIN ESPECIFICAR';
                    else
                        return d.comentario;
                }
            },
            { data: 'lugar_prospeccion' },
            { data: 'fecha_validacion' },
            {
                data: function (d) {
                    return  formatMoney(d.cantidad_enganche);
                }
            },
            {
                data: function (d) {
                    return d.nombreCliente; 
                }
            },
            {
                data: function (d) {
                    return d.nombreCopropietario;
                }
            },
            { data: 'comentario_administracion' },
            {
                data: function(d){
                    if(d.fecha_creacion == 'NULL' || d.fecha_creacion == 'null' || d.fecha_creacion == null || d.fecha_creacion == '')
                        return 'SIN ESPECIFICAR';
                    else
                        return d.fecha_creacion;
                }
            },
            {
                data: function(d){
                    if(d.apartadoXReubicacion == 1)
                        return `<center><span class="label lbl-violetBoots">REUBICACIÓN</span> <center>`;
                    else
                        return `<center><span class="label lbl-gray">NO APLICA</span> <center>`;
                }
            },
            {
                data: function(d){
                    if(d.apartadoXReubicacion == 1)
                        return d.fechaAlta;
                    else
                        return `<center><span class="label lbl-gray">NO APLICA</span> <center>`;
                }
            },
            {
                data: function(d){
                    if(d.venta_compartida != 0)
                        return `<center><span class="label lbl-green">COMPARTIDA</span> <center>`;
                    else
                        return `<center><span class="label lbl-gray">NO APLICA</span> <center>`;
                }
            },
            {
                data: function(d) {
                    if(d.ubicacion != null)
                        return `<center><span class="label lbl-oceanGreen">${d.ubicacion}</span> <center>`;
                    else
                        return `<center><span class="label lbl-gray">NO APLICA</span> <center>`;
                }
            },
            {
                data: function (d) {
                    return `<span class='label lbl-violetBoots'>${d.tipo_proceso}</span>`;
                }
            },
            {
                data: function (d) {
                    return `<span class='label lbl-oceanGreen'>${d.sedeResidencial}</span>`;
                }
            },
            {
                data: function (d) {
                    return `<center><button class="btn-data btn-blueMaderas btn_accion" value="${d.idLote}" data-nomLote="${d.nombreLote}" data-tipo-venta="${d.tipo_venta}" data-idCliente="${d.idCliente}" data-fecha-apertura="${d.fecha_creacion}" data-toggle="tooltip" data-placement="left" title="VER MÁS INFORMACIÓN"><i class="fas fa-history"></i></button></center>`;
                }
            }],
        initComplete: function() {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
});

/*$(window).resize(function () {
    tabla_inventario.columns.adjust();
});
*/
$(document).on("click", ".btn_accion", function(){
    let idLote = $(this).attr('value');
    let idCliente = $(this).data('idcliente');
    let fechaApertura = $(this).data('fechaApertura');
    /*let beginDate = document.getElementById('beginDate').value;
    document.getElementById("titleAceptar").innerHTML = 'Elegir la fecha';*/
    $("#aceptarFecha").addClass("modal-sm");
    $("#fechaModal").modal();
    $("#idLote").val(idLote);
    $("#idCliente").val(idCliente);
    $("#fechaApertura").val(fechaApertura);
});

$(document).on('submit', '#fechaEntrega', function(e){
    e.preventDefault();
    console.log("I was executed");
    let data = new FormData($(this)[0]);
    $.ajax({
        url: `${general_base_url}/Contratacion/editFechaApertura`,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (response) {
            console.log("response: ", response);
        }
    })
});

$('#beginDate').datepicker({
    onselect: function (dateText) {
        console.log("dateText: ", dateText);
    }
});