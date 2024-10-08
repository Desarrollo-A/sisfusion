let titulos = [];
var tablaEstatus3;
$('#tabla_historial thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tabla_historial').DataTable().column(i).search() !== this.value) {
            $('#tabla_historial').DataTable().column(i).search(this.value).draw();
        }
    });
});

$(document).ready(()=>{
    tablaEstatus3 = $("#tabla_historial").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Historial estatus 3',
                title: "Historial estatus 3",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                className: 'btn buttons-pdf',
                titleAttr: 'Historial estatus 3',
                title: "Historial estatus 3",
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                }
            }
        ],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        pageLength: 11,
        fixedColumns: true,
        ordering: false,
        columns: [
            { data: 'nombreResidencial' },
            { data: 'nombreCondominio' },
            { data: 'nombreLote' },
            { data: 'nombreCliente' },
            { data: 'fechaEnvioAsesor' },
            {
                //data: 'fechaEnvioPostventa'

                data: function (d) {
                    let fechaEnvioPostventa;
                    if(d.fechaEnvioPostventa == '' || d.fechaEnvioPostventa == null){
                        fechaEnvioPostventa = 'Sin registro de status 3';
                    }else{
                        fechaEnvioPostventa = d.fechaEnvioPostventa;
                    }
                    return fechaEnvioPostventa;
                }

            },
            {
                data: function (d) {
                    return d.comentario;
                }
            },
            {
                // data: 'cantidadRechazos'
                data: function (d) {
                    return myFunctions.validateEmptyField(d.cantidadRechazos);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fechaEstatus01);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fechaEstatus02);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fechaEstatus05);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fechaEstatus06);
                }

            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fechaEstatus07);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fechaEstatus08);
                }

            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fechaEstatus09);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fechaEstatus10);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fechaEstatus11);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fechaEstatus12);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fechaEstatus13);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fechaEstatus14);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fechaEstatus15);
                }
            },
        ],
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: 0
            },
        ],
        ajax: {
            url: "getHistorialEstatus3",
            dataSrc: "",
            type: "POST",
            cache: false,
            data: function (d) {
            }
        },
        order: [[1, 'asc']]
    });
});
