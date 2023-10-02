$(document).ready(function () {
    $("#tabla_cancelacion").addClass('hide');
    
    $.post(general_base_url + "Reestructura/lista_proyecto", function (data) {
        var len = data.length;
        const ids = data.map((row) => {
            return row.idResidencial;
        }).join(',');

        $("#proyecto").append($('<option>').val(ids).text('SELECCIONAR TODOS'));
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];            
            $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#proyecto").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
});

$('#proyecto').change(function () {
    $("#spiner-loader").removeClass('hide');
    let index_proyecto = $(this).val();
    $("#tabla_cancelacion").removeClass('hide');
    fillTable(index_proyecto);
});

let titulos_intxt = [];
$('#tabla_cancelacion thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#tabla_cancelacion').DataTable().column(i).search() !== this.value ) {
            $('#tabla_cancelacion').DataTable().column(i).search(this.value).draw();
        }
    });
});

function fillTable(index_proyecto) {
    tabla_cancelacion = $("#tabla_cancelacion").DataTable({
        width: '100%',
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [{
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'CANCELACIÓN POR REESTRUCTURACIÓN',
        title: 'CANCELACIÓN POR REESTRUCTURACIÓN',
            exportOptions: {
                columns: [0,1,2,3,4],
                format: {
                    header: function (d, columnIdx) {
                        return ' '+titulos_intxt[columnIdx] +' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: true,
        pageLength: 10,
        bAutoWidth: true,
        bLengthChange: false,
        scrollX: true,
        bInfo: true,
        searching: true,
        ordering: false,
        fixedColumns: true,
        destroy: true,
        columns: [{
            data: function (d) {
                return '<p class="m-0">' + d.nombreResidencial + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.condominio + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.nombreLote + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.nombreCliente + '</p>';
            }
        },
        {
            data: function(d){
                return '<p class="m-0">'+d.idLote+'</p>';
            }
        },
        {
            data: function(d){
                return '<p class="m-0">'+d.comentarioLiberacion+'</p>';
            }
        }],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: general_base_url + "Postventa/getregistros",
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {
                "index_proyecto": index_proyecto,
            }
        },
        initComplete: function(){
            $("#spiner-loader").addClass('hide');
        },
        "order": [
            [1, 'asc']
        ],
    });
    
    $('#tabla_cancelacion').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}
