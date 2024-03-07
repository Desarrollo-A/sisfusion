$(document).ready(function() {
    $('#spiner-loader').removeClass('hide');
    $.post(general_base_url + "Contratacion/lista_proyecto", function (data) {
        $('#spiner-loader').addClass('hide');
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#proyecto").selectpicker('refresh');
    }, 'json');
});

$('#proyecto').change( function(){
    $('#spiner-loader').removeClass('hide');
    index_proyecto = $(this).val();
    index_condominio = 0
    $("#condominio").html("");
    $(document).ready(function(){
        $.post(general_base_url + "Contratacion/lista_condominio/"+index_proyecto, function(data) {
            $('#spiner-loader').addClass('hide');
            var len = data.length;
            for( var i = 0; i<len; i++)
            {
                var id = data[i]['idCondominio'];
                var name = data[i]['nombre'];
                $("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#condominio").selectpicker('refresh');
        }, 'json');
    });
    fillCommissionTableWithoutPayment(index_proyecto, index_condominio);
});

$('#condominio').change( function(){
    index_proyecto = $('#proyecto').val();
    index_condominio = $(this).val();
    // SE MANDA LLAMAR FUNCTION QUE LLENA LA DATA TABLE DE COMISINONES SIN PAGO EN NEODATA
    fillCommissionTableWithoutPayment(index_proyecto, index_condominio);
});


var totaPen = 0;
var tr;

let titulos = [];
$('#tabla_comisiones_sin_pago thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $( 'input', this ).on('keyup change', function () {
        if ($('#tabla_comisiones_sin_pago').DataTable().column(i).search() !== this.value ) {
            $('#tabla_comisiones_sin_pago').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
    })


function fillCommissionTableWithoutPayment (proyecto, condominio) {
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
                return '<p class="m-0">' + d.idLote + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombreResidencial + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombreCondominio + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombreLote + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombreCliente + ' </p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombreAsesor + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombreCoordinador + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombreGerente + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.reason + '</p>';
            }
        }],
        columnDefs: [{
            defaultContent: "",
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
    });
}