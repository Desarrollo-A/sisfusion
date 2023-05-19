$(document).ready(function() {
    $.post(`${general_base_url}Contratacion/getCatalogosParaUltimoEstatus`, function(data) {
        var len = data.length;
        for(var i = 0; i<len; i++) {
            var id = data[i]['id'];
            var name = data[i]['nombre'];
            if (data[i]['tipo'] == 1) // SON LAS SEDES
                $("#sedes").append($('<option>').val(id).text(name.toUpperCase()));
            else if (data[i]['tipo'] == 2) // SON LAS RESIDENCIALES
                $("#residenciales").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#sedes").selectpicker('refresh');
        $("#residenciales").selectpicker('refresh');
    }, 'json');
});

let titulos_intxt = [];
$('#Jtabla thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html(`<input type="text" class="textoshead" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#Jtabla').DataTable().column(i).search() !== this.value) {
            $('#Jtabla').DataTable().column(i).search(this.value).draw();
        }
    });
});

$(document).on('change', "#sedes", function () {
    if($(this).val() != "2") {
        fillTable($(this).val(), 0);
        $('#div_proyectos').addClass('hide');
        $('#residenciales').val('').selectpicker('refresh')
    }
    else if($(this).val() == "2")
        $('#div_proyectos').removeClass('hide');
    else
        alerts.showNotification("top", "right", "Selecciona una empresa para continuar con la búsqueda.", "warning");
});

$(document).on('change', "#residenciales", function () {
    fillTable($("#sedes").val(), $(this).val());
});

function getFinalDate() {
    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    var dateTime = date + ' ' + time;
    return [date, dateTime];
}

function fillTable(sede, residencial) {
    const [date, dateTime] = getFinalDate();
    $('#Jtabla').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Estatus actuales de terrenos al: ' + dateTime ,
            title: 'Estatus actuales de terrenos al:  ' + dateTime ,
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        columnDefs: [{
            defaultContent: "Sin especificar",
            targets: "_all",
            searchable: true,
            orderable: true
        }],
        destroy: true,
        ordering: true,
        columns: [
            {data: 'nombreResidencial'}, // PROYECTO
            {data: 'nombreCondominio'}, // CONDOMINIO
            {data: 'nombreLote'}, // LOTE
            {data: 'nombreSede' }, // SEDE
            {data: 'referencia'}, // REFERENCIA
            {data: 'sup'}, // SUPERFICIE
            { data: // GERENTE
                function(data) {
                    return (data.gerente != "" && data.gerente != null) ? " - " + data.gerente : "";
                }
            },
            { data: // ASESOR
                function(data) {
                    return (data.asesor != "" && data.asesor != null) ? " - " + data.asesor : "";
                }
            },
            { // PROCESO CONTRATACIÓN
                data: 'procesoContratacion',
                defaultContent: '<i>Not set</i>'
            },
            { data: // ESTATUS
                function(data) {
                    return (data.status == null || data.status == "") ? "N/A" : data.status;
                }
            },
            { data: 'comentario'}, // COMERNTARIO
            { data : // FECHA VENCIMIENTO
                function(data) {
                    const idStatusContratacion = ["7", "8"];
                    const idMovimiento = ["7", "37", "64", "77", "65", "38", "67"];
                    if (idStatusContratacion.includes(data.idStatusContratacion) && idMovimiento.includes(data.idMovimiento) && data.status8Flag == 1 && (data.validacionEnganche == null || data.validacionEnganche != 'VALIDADO'))
                        return data.fechaVencimiento2;
                    else if (idStatusContratacion.includes(data.idStatusContratacion) && idMovimiento.includes(data.idMovimiento) && data.status8Flag == 0 && data.validacionEnganche == 'VALIDADO')
                        return data.fechaVencimiento;
                    else if (idStatusContratacion.includes(data.idStatusContratacion) && idMovimiento.includes(data.idMovimiento) && data.status8Flag == 0 && data.validacionEnganche != 'VALIDADO')
                        return `Asistentes: ${data.fechaVencimiento} <br>Administración: ${data.fechaVencimiento2}`;
                    else
                        return data.fechaVencimiento;
                }
            },
            { data: // DÍAS RESTANTES
                function(data) {
                    const idStatusContratacion = ["7", "8"];
                    const idMovimiento = ["7", "37", "64", "77", "65", "38", "67"];
                    if (idStatusContratacion.includes(data.idStatusContratacion) && idMovimiento.includes(data.idMovimiento) && data.status8Flag == 1 && (data.validacionEnganche == null || data.validacionEnganche != 'VALIDADO'))
                        return data.diasRest2;
                    else if (idStatusContratacion.includes(data.idStatusContratacion) && idMovimiento.includes(data.idMovimiento) && data.status8Flag == 0 && data.validacionEnganche == 'VALIDADO')
                        return data.diasRest;
                    else if (idStatusContratacion.includes(data.idStatusContratacion) && idMovimiento.includes(data.idMovimiento) && data.status8Flag == 0 && (data.validacionEnganche == null || data.validacionEnganche != 'VALIDADO'))
                        return `Asistentes: ${data.diasRest} <br>Administración: ${data.diasRest2}`;
                    else
                        return data.diasRest;
                }
            },
            { data: // DÍAS VENCIDOS
                function(data) {
                    const idStatusContratacion = ["7", "8"];
                    const idMovimiento = ["7", "37", "64", "77", "65", "38", "67"];
                    if (idStatusContratacion.includes(data.idStatusContratacion) && idMovimiento.includes(data.idMovimiento) && data.status8Flag == 1 && (data.validacionEnganche == null || data.validacionEnganche != 'VALIDADO'))
                        return data.diasVenc2;
                    else if (idStatusContratacion.includes(data.idStatusContratacion) && idMovimiento.includes(data.idMovimiento) && data.status8Flag == 0 && data.validacionEnganche == 'VALIDADO')
                        return data.diasVenc;
                    else if (idStatusContratacion.includes(data.idStatusContratacion) && idMovimiento.includes(data.idMovimiento) && data.status8Flag == 0 && (data.validacionEnganche == null || data.validacionEnganche != 'VALIDADO'))
                        return `Asistentes: ${data.diasVenc} <br>Administración: ${data.diasVenc2}`;
                    else
                        return data.diasVenc;
                }
            },
            { data: // ESTATUS
                function(data) {
                    return (data.statusFecha == null) ? "N/A" : data.statusFecha;
                }
            },
            { data: // FECHA APARTADO
                function(data) {
                    return (data.fechaApartado == null) ? "N/A" : myFunctions.convertDateYMDHMS(data.fechaApartado);
                }
            },
            { data: 'nombreCliente'}, // NOMBRE CLIENTE
            { data: // LIBERACIÓN
                function(data) {
                    let labelAlc = '';
                    if(data.observacionContratoUrgente == '1')
                        labelAlc = `<span class="label" style="background: #E6B0AA; color: #641E16">En Proceso de liberación</span>`;
                    else
                        labelAlc = `<span class="label" style="background: #ABB2B9; color: #17202A">Sin registro</span>`;
                    return  labelAlc;
                }
            },
            { data: // FECHA ÚLTIMO MOVIMIENTO
                function(data) {
                    let label_return = myFunctions.convertDateYMDHMS(data.modificado_historial);
                    return  label_return;
                }
            },
            { data: // ESTATUS LOTE
                function(data) {
                    let label_statusLote = `<span class="label" style="background: #D2B4DE; color: #4A235A">${data.estatus_lote}</span>`;
                    let tipo_venta = `<span class="label" style="background: #FAD7A0; color: #7E5109">${data.tipo_venta}</span>`;
                    return  `<center>${label_statusLote}<br><br>${tipo_venta}</center>`;
                }
            },
            {
                data: function (d) {
                    if (d.id_cliente_reubicacion != 0 && d.id_cliente_reubicacion != null)
                        return `<span class="label" style="background: #A3E4D7; color: #0E6251">REUBICADO</span>`;
                    else
                        return `<span class="label" style="background: #ABB2B9; color: #17202A">NO APLICA</span>`;
                }
            },
            {
                data: function (d) {
                    if (d.id_cliente_reubicacion != 0 && d.id_cliente_reubicacion != null)
                        return d.fechaAlta;
                    else
                        return 'NO APLICA';
                }
            }
        ],
        ajax: {
            url: `${general_base_url}registroLote/getFinalStatus/`,
            type: "POST",
            cache: false,
            data: {
                "id_sede": sede,
                "residencial": residencial,
            }
        }
    });
}