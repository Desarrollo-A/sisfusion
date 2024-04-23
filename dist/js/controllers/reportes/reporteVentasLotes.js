let titulosLotesIndividual = [];
let LotesPorClienteAll = [];
let tablaHistorialLotes;

$("#lotesClientesIndividual").ready(function () {

    $('#lotesClientesIndividual thead tr:eq(0) th').each(function (i) {
        
            var title = $(this).text();
            titulosLotesIndividual.push(title);
            $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
            $('input', this).on('keyup change', function () {
                if (tabla_15.column(i).search() !== this.value)
                    tabla_15.column(i).search(this.value).draw();
            });
        
    });

    tabla_15 = $("#lotesClientesIndividual").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Registro lotes individual',
                title: "Registro lotes individual",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosLotesIndividual[columnIdx - 1] + ' ';
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
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        bAutoWidth: false,
        fixedColumns: true,
        ordering: false,
        scrollX: true,
        columns: [
            
            { data: 'id_cliente' },
            { data: 'nombre_cliente' },
            { data: 'nombre_copropietario' },
            { data: 'repeticiones' },
            {
                data: function (d) {
                    return `<center><button class="btn-data btn-blueMaderas historialReportes" data-cliente="${d.id_cliente}" data-nombreCliente="${d.nombre_cliente}" data-toggle="tooltip" data-placement="left" title="VER MÁS INFORMACIÓN DE LOTES"><i class="fas fa-history"></i></button></center>`;
                }
            }
        ],
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: 0
            },
        ],
        ajax: {
            url: `${general_base_url}Reporte/getLotesUnicos`,
            dataSrc: "",
            type: "POST",
            cache: false,
        },
        order: [[1, 'asc']]
    });

    $('#lotesClientesIndividual').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $('#lotesClientesIndividual tbody').on('click', '.historialReportes', function () {
    
        const nombreCliente = $(this).attr("data-nombreCliente");
        $('#nombreCliente').val(nombreCliente);
    
        $("#reportesClientesModal").modal();
    
        consultarHistorialLotes(nombreCliente);
    });
});


function consultarHistorialLotes(nombreCliente) {

    LotesPorClienteAll = [];

    $('#tablaHistorialLotes thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        LotesPorClienteAll.push(title);
        $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
        $('input', this).on('keyup change', function () {
            if ($('#tablaHistorialLotes').DataTable().column(i).search() !== this.value) {
                $('#tablaHistorialLotes').DataTable().column(i).search(this.value).draw();
            }
        });
    });

    if (tablaHistorialLotes) {
        tablaHistorialLotes.destroy();
    }
  
    tablaHistorialLotes = $('#tablaHistorialLotes').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'HISTORIAL LOTES POR CLIENTE',
                exportOptions: {
                    columns: [0, 1, 2, 3],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + LotesPorClienteAll[columnIdx] + ' ';
                        }
                    }
                },
            }
        ],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        ordering: false,
        scrollX: true,
        columns: [
            { data: "id_cliente" },
            { data: "idLote" },
            { data: "proyectoCondominio" },
            { data: 'descripcion' },
            { data: 'nombre_condominio' },
            { data: 'nombreLote' },
            { data: 'nombreRepetidos' },
            { data: 'fechaApartado' },
            { data: 'nombre_copropietario' },
            { data: 'referencia' },
            { data: 'asesor' },
            { data: 'coordinador' },
            { data: 'gerente' },
            { data: 'estatusApartado' },
            { data: 'estatus_contratacion' },
            { data: 'sede' },
            { data: 'tipo_proceso' }
        ],
        ajax: {
            url: `${general_base_url}Reporte/getAllLotes`,
            type: "POST",
            cache: false,                
            dataSrc: "",
            data :{
                nombreCliente : nombreCliente
            }
        },
    });

    $('#tablaHistorialLotes').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}
