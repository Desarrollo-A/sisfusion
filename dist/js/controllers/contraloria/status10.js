let titulosInventario = [];
$('#Jtabla thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulosInventario.push(title);
    $(this).html('<input class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {
        if ($('#Jtabla').DataTable().column(i).search() !== this.value ) {
            $('#Jtabla').DataTable().column(i).search(this.value).draw();
        }
    });
});

$(document).ready(function() {
    $.ajax({
        post: "POST",
        url: `${general_base_url}/registroLote/getDateToday/`
    }).done(function(data) {
        $('#showDate').append('(Envio de contrato a RL (Contraloría) al día de hoy: ' + data + ')');
    }).fail(function(){});
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setIniDatesXMonth("#beginDate", "#endDate");
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillDataTable(1, finalBeginDate, finalEndDate, 0);
});

sp = { //  SELECT PICKER
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

function fillDataTable(typeTransaction, beginDate, endDate, where) {
    $('#Jtabla').dataTable( {
        "ajax": {
            "url": `${general_base_url}index.php/contraloria/getRevision10`,
            "dataSrc": "",
            "type": "POST",
            cache: false,
            data: {
                "typeTransaction": typeTransaction,
                "beginDate": beginDate,
                "endDate": endDate,
                "where": where
            }
        },
        "pageLength": 10,
        "bAutoWidth": true,
        "fixedColumns": true,
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        scrollX: true,
        columnDefs: [{
            defaultContent: "-",
            targets: "_all"
        }],
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Estatus 10 solicitud enganche',
                title:'Estatus 10 solicitud enganche',
                exportOptions: {
                    columns: [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosInventario[columnIdx]  + ' ';
                        }
                    }
                },
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                className: 'btn buttons-pdf',
                titleAttr: 'Estatus 10 solicitud enganche',
                title: "Estatus 10 solicitud enganche",
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosInventario[columnIdx]  + ' ';
                        }
                    }
                },
            }
        ],
        "columns": [
            {data: 'nombreResidencial'},
            {data: 'nombreCondominio'},
            {data: 'nombreLote'},
            {data: 'referencia'},
            {
                data: function (data)
                {
                    return myFunctions.validateEmptyField(data.nombreCliente);
                }
            },
            {
                data: function (data)
                {
                    return myFunctions.validateEmptyField(data.nombreUsuario);
                }
            },
            {
                data: function (data)
                {
                    return myFunctions.validateEmptyField(data.asesor);
                }
            },
            {
                data: function (data)
                {
                    return myFunctions.validateEmptyField(data.coordinador);
                }
            },
            {
                data: function (data)
                {
                    return myFunctions.validateEmptyField(data.gerente);
                }
            },
            {
                data: function (data)
                {
                    return data.fechaApartado;
                }
            },
            {
                data: function (data)
                {
                    return data.modificado;
                }
            },
            {
                data: function (data)
                {
                    return data.fechaVenc;
                }
            },
        ]
    })
}

$('#Jtabla').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

$(document).on("click", "#searchByDateRange", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillDataTable(3, finalBeginDate, finalEndDate, 0);
});