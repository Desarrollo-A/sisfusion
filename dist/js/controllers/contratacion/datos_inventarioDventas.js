
$('#filtro3').change(function(){
    var entra = 0;
    var ruta;
    var residencial = $('#filtro3').val();

    if(residencial == 'InventarioCompleto')
    {
        var ruta = general_base_url + "registroLote/getLotesDventasAll";
        $("#filtro4").html( "" ).append( "" );
        entra = 1;
    }
    else
    {
        entra = 0;
        $("#filtro4").empty().selectpicker('refresh');
        $.ajax({
            url: general_base_url + 'registroLote/getCondominio/'+ residencial,
            type: 'post',
            dataType: 'json',
            success:function(response){
                var len = response.length;
                for( var i = 0; i<len; i++)
                {
                    var id = response[i]['idCondominio'];
                    var name = response[i]['nombre'];
                    $("#filtro4").append($('<option>').val(id).text(name));
                }
                $("#filtro4").selectpicker('refresh');

            }
        });
    }

    if(entra == 1)
    {
        table_6 = $('#tableTerrenos').DataTable({
            dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                fileName: 'Registros de Terrenos',
                titleAttr: 'Registros de terrenos',
                title:'Registros de terrenos',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                    format: {
                        header: function (d, columnIdx) {
                            switch (columnIdx) {
                                case 0:
                                    return 'PROYECTO';
                                    break;
                                case 1:
                                    return 'CONDOMINO';
                                    break;
                                case 2:
                                    return 'LOTE';
                                case 3:
                                    return 'SUPERFICIE';
                                    break;
                                case 4:
                                    return 'TOTAL';
                                    break;
                                case 5:
                                    return 'ENGANCHE';
                                    break;
                                case 6:
                                    return 'A FINANCIAR';
                                    break;
                                case 7:
                                    return 'MESES S/I';
                                    break;
                            }
                        }
                    }
                }
            }],

            ordering: false,
            pagingType: "full_numbers",
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            language: {
                url: general_base_url + "/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            destroy: true,
            columns: [
                { data: 'nombreResidencial' },
                { data: 'nombreCondominio' },
                { data: 'nombreLote' },
                { data: 'sup' },
                {
                    // data: 'total'
                    data: function(d)
                    {
                        return "$"+alerts.number_format(d.total, 2, ".", ",")
                    }
                },
                {
                    // data: 'enganche'
                    data: function(d)
                    {
                        return "$"+alerts.number_format(d.enganche,2, ".", ",");
                    }
                },
                {
                    // data: 'saldo'
                    data: function(d)
                    {
                        return "$"+alerts.number_format(d.saldo, 2, ".", ",");
                    }
                },
                { data: 'msni' },
            ],
            "ajax": {
                "url": ruta,
                "type": "POST",
                "dataSrc": "",
                cache: false,
                "data": function( d ){
                    d.proyecto = $('#empresa').val();
                    d.idproyecto = $('#proyecto').val();
                }
            },
        });
    }
});

let titulos_encabezado = [];

$(document).ready(function() {
    construirHead("tableTerrenos");
});

$('#filtro4').change(function()
{
    var residencial = $('#filtro3').val();
    var valorSeleccionado = $('#filtro4').val();
    table_6 = $('#tableTerrenos').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        ordering: false,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Registros de terrenos',
            title:'Registros de terrenos',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7],
                format: {
                    header: function (d, columnIdx) {
                        return ' '+ titulos_encabezado[columnIdx] +' ';
                    }
                }
            }
        }],


        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        columns: [
            { data: 'nombreResidencial' },
            { data: 'nombreCondominio' },
            { data: 'nombreLote' },
            { data: 'sup' },
            {
                // data: 'total'
                data: function(d)
                {
                    return "$"+alerts.number_format(d.total, 2, ".", ",")
                }
            },
            {
                // data: 'enganche'
                data: function(d)
                {
                    return "$"+alerts.number_format(d.enganche,2, ".", ",");
                }
            },
            {
                // data: 'saldo'
                data: function(d)
                {
                    return "$"+alerts.number_format(d.saldo, 2, ".", ",");
                }
            },
            { data: 'msni' },
        ],
        "ajax": {
            "url": general_base_url + "registroLote/getLotesDventas/" +valorSeleccionado+'/'+residencial,
            "dataSrc": "",
            "type": "POST",
            cache: false,
            "data": function( d ){
                d.proyecto = $('#empresa').val();
                d.idproyecto = $('#proyecto').val();
            }
        },
    });
});

$('#tableTerrenos').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});
