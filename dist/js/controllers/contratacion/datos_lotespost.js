let titulos = [];
$('#Jtabla thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($('#Jtabla').DataTable().column(i).search() !== this.value)
            $('#Jtabla').DataTable().column(i).search(this.value).draw();
    });
});

$(document).ready(function () {
    $.ajax({
            post: "POST",
            url: `${general_base_url}registroLote/getDateToday`
        }).done(function (data) {
            $('#showDate').append('Lotes con más de 45 días al: ' + data);
        }).fail(function () {
        });
    var today = new Date();
    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    var dateTime = date + ' ' + time;
    $('#Jtabla').DataTable({
        ajax: {
            url: `${general_base_url}registroLote/getReportPost45`,
            dataSrc: ""
        },
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        bAutoWidth: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Lotes con más de 45 días al: ' + dateTime,
            title: 'Lotes con más de 45 días al:  ' + dateTime,
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                format: {
					header: function (d, columnIdx) {
						return ' ' + titulos[columnIdx] + ' ';
					}
				}
            }
        }],
        pagingType: "full_numbers",
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
            { data: 'nombreResidencial' },
            { data: 'nombreCondominio' },
            { data: 'nombreLote' },
            { data: 'nombreSede' },
            { data: 'referencia' },
            {
                data: function (data) {
                    var ge1, ge2, ge3, ge4, ge5;
                    if (data.gerente != "" && data.gerente != null) { ge1 = "- " + data.gerente } else { ge1 = ""; }
                    if (data.gerente2 != "" && data.gerente2 != null) { ge2 = "- " + data.gerente2 } else { ge2 = ""; }
                    if (data.gerente3 != "" && data.gerente3 != null) { ge3 = "- " + data.gerente3 } else { ge3 = ""; }
                    if (data.gerente4 != "" && data.gerente4 != null) { ge4 = "- " + data.gerente4 } else { ge4 = ""; }
                    if (data.gerente5 != "" && data.gerente5 != null) { ge5 = "- " + data.gerente5 } else { ge5 = ""; }
                    return ge1;
                }
            },
            {
                data: function (data) {
                    var as1, as2, as3, as4, as5;
                    if (data.asesor != "" && data.asesor != null) { as1 = "- " + data.asesor } else { as1 = ""; }
                    if (data.asesor2 != "" && data.asesor2 != null) { as2 = "- " + data.asesor2 } else { as2 = ""; }
                    if (data.asesor3 != "" && data.asesor3 != null) { as3 = "- " + data.asesor3 } else { as3 = ""; }
                    if (data.asesor4 != "" && data.asesor4 != null) { as4 = "- " + data.asesor4 } else { as4 = ""; }
                    if (data.asesor5 != "" && data.asesor5 != null) { as5 = "- " + data.asesor5 } else { as5 = ""; }
                    return as1;
                }
            },
            {
                data: function (data) {
                    if (data.procesoContratacion == null || data.procesoContratacion == "")
                        return "N/A";
                    else
                        return data.procesoContratacion;
                }
            },
            {
                data: function (data) {
                    if (data.status == null || data.status == "")
                        return "N/A";
                    else
                        return data.status;
                }
            },
            { data: 'comentario' },
            {
                data: 'fechaApartado'
            },
            {
                data: function (data) {
                    if (data.diasVencidos != null)
                        return data.diasVencidos;
                    else
                        return "N/A";
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
        ]
    });
});

$('#Jtabla').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});