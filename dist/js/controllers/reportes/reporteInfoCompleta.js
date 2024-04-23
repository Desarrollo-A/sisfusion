LotesPorClienteAll = [];

    $('#tablaHistorialCompleta thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        console.log(title);
        LotesPorClienteAll.push(title);
        $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
        $('input', this).on('keyup change', function () {
            if (tablaHistorialLotesALL.column(i).search() !== this.value)
                tablaHistorialLotesALL.column(i).search(this.value).draw();
        });
    });

    tablaHistorialLotesALL = $("#tablaHistorialCompleta").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Registro lotes total',
                title: "Registro lotes total",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + LotesPorClienteAll[columnIdx] + ' ';
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
            url: `${general_base_url}Reporte/getLotesTotal`,
            dataSrc: "",
            type: "POST",
            cache: false,
        },
    });

    $('#tablaHistorialCompleta').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
