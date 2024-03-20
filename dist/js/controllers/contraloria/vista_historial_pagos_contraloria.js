$('#tabla_historialpagos_contraloria thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_historialpagos_contraloria').DataTable().column(i).search() !== this.value ) {
                $('#tabla_historialpagos_contraloria').DataTable().column(i).search(this.value).draw();
            }
        });
});

$(document).ready(function(){
    $.post(general_base_url + "Contraloria/lista_proyecto", function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#proyecto").selectpicker('refresh');
    }, 'json');
});

$('#proyecto').change( function() {
    index_proyecto = $(this).val();
    $("#condominio").html("");
    $(document).ready(function(){
        $.post(general_base_url + "Contraloria/lista_condominio/"+index_proyecto, function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++){
                var id = data[i]['idCondominio'];
                var name = data[i]['nombre'];
                $("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#condominio").selectpicker('refresh');
        }, 'json');
    });
});


$('#condominio').change( function() {
    index_condominio = $(this).val();
    $("#lote").html("");
    $(document).ready(function(){
        $.post(general_base_url + "Contraloria/lista_lote/"+index_condominio, function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++){
                var id = data[i]['idLote'];
                var name = data[i]['nombreLote'];
                $("#lote").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#lote").selectpicker('refresh');
        }, 'json');
    });
});

$('#lote').change( function() {
    $("#tabla_historialpagos_contraloria").removeClass('hide');
    index_lote = $(this).val();
    tabla_expediente = $("#tabla_historialpagos_contraloria").DataTable({
        width: '100%',
        scrollX: true,
        bAutoWidth: true,
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        destroy: true,
        "buttons": [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Historial pagos',
                title:"Historial pagos",
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                className: 'btn buttons-pdf',
                titleAttr: 'Historial pagos',
                title: "Historial pagos",
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: ':visible'
                }
            }
        ],
        "ajax":
            {
                "url": general_base_url+'Contraloria/get_lote_historial_pagos/'+index_lote,
                "dataSrc": ""
            },
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        "ordering": false,
        "searching": true,
        "paging": true,
        "bAutoWidth": false,
        "bLengthChange": false,
        "scrollX": true,
        "bInfo": true,
        "fixedColumns": true,
        "columns":
            [
                {data: 'nombreLote'},
                {
                    data: null,
                    render: function (data, type, row)
                    {
                        return data.nombre + ' ' + data.apellido_paterno + ' ' + data.apellido_materno;
                    },
                },
                {data: 'noRecibo'},
                {
                    data: null,
                    render: function(data, type, row)
                    {
                        return "$" + myFunctions.number_format(data.engancheCliente, '2', '.', ',');
                    }
                },
                {data: 'concepto'},
                {data: 'tipo'},
                {data: 'fechaEnganche'},
                {data: 'usuario'}
            ]
    });
});

$(window).resize(function(){
    tabla_expediente.columns.adjust();
});
