$(document).ready(function () {
    $('#spiner-loader').removeClass('hide');
    $.post(general_base_url + "Asistente_gerente/lista_proyecto", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcionConcat'];
            $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#proyecto").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
});

$('#proyecto').change(function () {
    index_proyecto = $(this).val();
    $("#condominio").html("");
    $('#spiner-loader').removeClass('hide');
    $(document).ready(function () {
        $.post(general_base_url + "Asistente_gerente/lista_condominio/" + index_proyecto, function (data) {
            var len = data.length;            
            for (var i = 0; i < len; i++) {
                var id = data[i]['idCondominio'];
                var name = data[i]['nombre'];
                $("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#condominio").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }, 'json');
    });

});


$('#condominio').change(function () {
    index_condominio = $(this).val();
    $("#lote").html("");
    $('#spiner-loader').removeClass('hide');
    $(document).ready(function () {
        $.post(general_base_url + "Asistente_gerente/lista_lote/" + index_condominio, function (data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['idLote'];
                var name = data[i]['nombreLote'];
                $("#lote").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#lote").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }, 'json');

    });

});

var titulos_encabezado = [];
$('#tabla_contrato_ventas thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_encabezado.push(title);
    let readOnly = (title == 'CONTRATO' || title == '') ? 'readOnly': '';
    let width = title=='CONTRATO' ? 'style="width: 65px;"': '';
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}" ${readOnly}/>`);
    $('input', this).on('keyup change', function () {
        if (tabla_contrato.column(i).search() !== this.value) {
            tabla_contrato.column(i).search(this.value).draw();
        }
    });
});

var tabla_contrato;
$('#lote').change(function () {
    index_lote = $(this).val();
    $('#spiner-loader').removeClass('hide');
    $('#tabla_contrato_ventas').removeClass('hide');
    tabla_contrato = $("#tabla_contrato_ventas").DataTable({
        width: '100%',
        scrollX: true,
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        "ajax":
        {
            "url": `${general_base_url}index.php/Asistente_gerente/get_lote_contrato/${index_lote}`,
            "dataSrc": ""
        },
        initComplete: function () {
            $("#spiner-loader").addClass("hide");
        },
        destroy: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Contrato',
                title: 'Contrato',
                exportOptions: {
                    columns: [0,1,2,3,4],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos_encabezado[columnIdx] + ' ';
                        }
                    }
                },

            }
        ],
        pagingType: "full_numbers",
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: true,
        pageLength: 10,
        bAutoWidth: false,
        bLengthChange: false,
        scrollX: true,
        bInfo: true,
        searching: true,
        ordering: false,
        fixedColumns: true,

        "columns":
            [
                { data: 'nombreResidencial'},
                { data: 'condominio' },
                { data: 'nombreLote' },
                {
                    data: null,
                    render: function (data, type, row) {
                        return data.nombre + ' ' + data.apellido_paterno + ' ' + data.apellido_materno;
                    },
                },
                {
                    data: function (data) {
                        return myFunctions.validateEmptyField(data.contratoArchivo);
                    }
                },
                {
                    "orderable": false,
                    "data": function (data) {
                        $('#cnt-file')
                            .html(`<h3 style="font-weight:100">
                                        Visualizando
                                        <b>
                                            ${myFunctions.validateEmptyField(data.contratoArchivo)}
                                        </b>
                                    </h3>
                                    <embed  src="${general_base_url}static/documentos/cliente/contrato/${data.contratoArchivo}" frameborder="0" width="100%" height="500" style="height: 60vh;"></embed >`);
                                        var myLinkConst = ` <center>
                                                <a type="button" data-toggle="tooltip" data-placement="top" title="VISUALIZAR" class="btn-data btn-blueMaderas contratacion_modal">
                                                    <center>
                                                        <i class="fas fa-eye" style="cursor: pointer"></i>
                                                    </center>
                                                </a>
                                            </center>`;
                        return myLinkConst;
                    }
                }
            ]
    });

    $('#tabla_contrato_ventas').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
    
    $("#tabla_contrato_ventas tbody").on("click", ".contratacion_modal", function () {
        $("#fileViewer").modal();
    });

});



$(window).resize(function () {
    tabla_contrato.adjust();
});