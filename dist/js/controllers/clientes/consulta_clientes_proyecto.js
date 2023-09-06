$( document ).ready(function() {   
    let titulos_encabezado = [];
    let num_colum_encabezado = [];
    $('#tabla_clientes thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos_encabezado.push(title);
        num_colum_encabezado.push(i);
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>` );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_clientes').DataTable().column(i).search() !== this.value)
                $('#tabla_clientes').DataTable().column(i).search(this.value).draw();
        });
    });

    $('#tabla_clientes').DataTable({
        destroy: true,
        ajax:{
            url: 'getClientsByProyect/',
            dataSrc: "",
            type: "POST",
            cache: false
        },
        initComplete: function() {
            $('[data-toggle="tooltip"]').tooltip();
        },
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "auto",
        ordering: false,
        pagingType: "full_numbers",
        scrollX: true,
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            exportOptions: {
                columns: num_colum_encabezado,
                format: {
                    header: function (d, columnIdx) {
                        return ' '+titulos_encabezado[columnIdx] +' ';
                    }
                }
            }
        }],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        columns:
            [
                {data: 'proyecto'},
                {data: 'nombre_condominio'},
                {data: 'nombreLote'},
                {data: 'nombre_completo'},
                {data: 'fechaApartado'},
                {
                    data: function (d) {
                        return (d.fecha_nacimiento == null || d.fecha_nacimiento == '' ? 'SIN ESPECIFICAR' : d.fecha_nacimiento);
                    }
                },
                {
                    data: function (d) {
                        if (d.edad == null || d.edad == 'null')
                            return 'SIN ESPECIFICAR';
                        else
                            return d.edad;
                    }
                },
                {
                    data: function (d) {
                        return (d.ocupacion == null || d.ocupacion == '') ? 'SIN ESPECIFICAR' : d.ocupacion;
                    }
                },
                {
                    data: function (d) {
                        return (d.originario_de == null || d.originario_de == '') ? 'SIN ESPECIFICAR' : d.originario_de;
                    }
                }
            ]
    });
});
