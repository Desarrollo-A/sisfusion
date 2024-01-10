$(document).ready(function() {
    $("#tabla_comisiones_sin_pago").prop("hidden", true);
    $('#spiner-loader').removeClass('hide');
    $.post(general_base_url + "Contratacion/lista_proyecto", function (data) {
        $('#spiner-loader').addClass('hide');
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#catalogo_pago").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#catalogo_pago").selectpicker('refresh');
    }, 'json');
});

$('#catalogo_pago').change( function(){
    $('#spiner-loader').removeClass('hide');
    index_proyecto = $(this).val();
    index_condominio = 0
    $("#condominio_pago").html("");
    $(document).ready(function(){
        $.post(general_base_url + "Contratacion/lista_condominio/"+index_proyecto, function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++)
            {
                var id = data[i]['idCondominio'];
                var name = data[i]['nombre'];
                $("#condominio_pago").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#condominio_pago").selectpicker('refresh');
        }, 'json');
    });
    comisionTablaSinPago(index_proyecto, index_condominio);
});

$('#condominio_pago').change( function(){
    index_proyecto = $('#catalogo_pago').val();
    index_condominio = $(this).val();
    comisionTablaSinPago(index_proyecto, index_condominio);
});

var totaPen = 0;
var tr;

let titulos = [];
$('#tabla_comisiones_sin_pago thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>' );
    $( 'input', this ).on('keyup change', function () {
        if ($('#tabla_comisiones_sin_pago').DataTable().column(i).search() !== this.value ) {
            $('#tabla_comisiones_sin_pago').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
    })

function comisionTablaSinPago (proyecto, condominio) {
    $("#tabla_comisiones_sin_pago").prop("hidden", false);
    tabla_comisiones_sin_pago = $("#tabla_comisiones_sin_pago").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        language: {
            url: "../static/spanishLoader.json"
        },
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url+"/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title:'Estatus comisiones',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                }
        }],
        columns: [{
            data: function(d) {
                return d.idLote;
            }
        },
        {
            data: function(d) {
                return d.nombreResidencial;
            }
        },
        {
            data: function(d) {
                return d.nombreCondominio;
            }
        },
        {
            data: function(d) {
                return d.nombreLote;
            }
        },
        {
            data: function(d) {
                return d.nombreCliente;
            }
        },
        {
            data: function(d) {
                return d.nombreAsesor;
            }
        },
        {
            data: function(d) {
                return d.nombreCoordinador;
            }
        },
        {
            data: function(d) {
                return d.nombreGerente;
            }
        },
        {
            data: function(d) {
                return d.subdirector;
            }
        },
        {
            data: function(d) {
                return d.regional;
            }
        },
        {
            data: function(d) {
                return d.regional2;
            }
        },
        {
            data: function(d) {
                return d.reason;
            }
        }],
        columnDefs: [{
            defaultContent: "Sin especificar",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: general_base_url + "ComisionesNeo/getGeneralStatusFromNeodata/" + proyecto + "/" + condominio,
            type: "POST",
            cache: false,
            data: function(d) {}
        },
        initComplete: function(){
            $("#tablaInv").removeClass('hide');
            $('#spiner-loader').addClass('hide');
        }
    });
}