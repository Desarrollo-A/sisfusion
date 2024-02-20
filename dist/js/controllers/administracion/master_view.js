$(document).ready(function(){
    /*$.post(`${general_base_url}Administracion/getOpcionesMaster`, function (data){
        console.log("Received JSON data:", data); // Add this console.log statement
        for(var i = 0; i < data.length; i++) {
            $("#optSelect").append($('<option>').val(data[i]['id_catalogo']).text(data[i]['opcion']));
        }
        $("#optSelect").selectpicker('refresh');
    }, 'json');*/
});




var idLote = 0;
let titulos_intxt = [];
$('#tabla_inventario_contraloria thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#tabla_inventario_contraloria').DataTable().column(i).search() !== this.value ) {
            $('#tabla_inventario_contraloria').DataTable().column(i).search(this.value).draw();
        }
    });
});

$(".find_doc").click( function() {
    $("#tabla_inventario_contraloria").removeClass('hide');
    var idLote = $('#inp_lote').val();
    tabla_inventario = $("#tabla_inventario_contraloria").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        ajax:
        {
            "url": general_base_url + 'index.php/Administracion/getDatosLotes/'+idLote,
            "dataSrc": "",
        },
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'MADERAS_CRM_INVENTARIO',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                format: 
                {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx]  + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            data: 'nombreResidencial'
        },
        {
            data: 'nombreCondominio'
        },
        {
            data: 'idLote'
        },
        {
            data: 'nombreLote'
        },
        {
            data: 'nombreCliente'
        },
        {
            data: 'fechaApartado'
        },
        {
            data: 'representante'
        },
        {
            "data": function(d) {
                return '<div class="d-flex justify-center"><button class="btn-data btn-sky btn_accion" data-toggle="tooltip" data-placement="top" title="ACCIONES" value="' + d.idLote + '" data-nomLote="'+ d.nombreLote+'"><i class="fas fa-history"></i></button></div>';
            }
        }]
    });
    $(window).resize(function(){
        tabla_inventario.columns.adjust();
    });
});

$("#tabla_inventario_contraloria").on('draw.dt', function(){
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

$(document).on("click", ".btn_accion", function(){
    var tr = $(this).closest('tr');
    var row = tabla_inventario.row(tr);
    idLote = $(this).val();
    $("#seeInformationModal").modal();
    $("#seeInformationModal").on("shown.bs.modal", function(){
        $("#idLotelbl").text(idLote)
        $.post(`${general_base_url}Administracion/getOpcionesMaster`, function (data){
        console.log("Received JSON data:", data); // Add this console.log statement
        for(var i = 0; i < data.length; i++) {
            $("#optSelect").append($('<option>').val(data[i]['id_catalogo']).text(data[i]['opcion']));
        }
        $("#optSelect").selectpicker('refresh');
    }, 'json');
    });
    console.log("idLote: ", idLote);
});