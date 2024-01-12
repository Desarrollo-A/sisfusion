$(document).ready(function(){
    $("#tabla_inventario").addClass('hide');

    $.post(general_base_url + "Reestructura/getEstatusLote",   function (data) {
        
        var len = data.length;
        const ids = data.map((row) => {
            return row.idStatusContratacion;
        }).join(',');
    
        for (var i = 0; i < len; i++) {
            var id = data[i]['idStatusContratacion'];
            var name = data[i]['nombreStatus'];            
            $("#estatus_lotes").append($('<option>').val(id).text(name.toUpperCase()));
        }
        
        $("#estatus_lotes").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
});

$('#estatus_lotes').change(function () {
    let index_estatus = $(this).val();

    $("#spiner-loader").removeClass('hide');
    $("#tabla_inventario").removeClass('hide');

    fillTable(index_estatus);
});

let titulos_intxt  = [];
$("#tabla_inventario").ready(function () {
    $('#tabla_inventario thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        titulos_intxt .push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if (tabla_valores_lote.column(i).search() !== this.value) {
                tabla_valores_lote.column(i).search(this.value).draw();
            }
        });
    });
});

function fillTable(index_estatus) {
    tabla_valores_lote = $("#tabla_inventario").DataTable({
        width: '100%',
        scrollX: true,
        bAutoWidth: true,
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Inventario lotes reestructura',
            title: 'Inventario lotes reestructura',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10],
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
        bLengthChange: false,
        bInfo: true,
        searching: true,
        ordering: false,
        fixedColumns: true,
        destroy: true,
        columns: [{
            data: function (d) {
                return `<span class="label lbl-azure">${d.tipo_venta}</span>`;
            }
        },
        {
            data: function (d) {
                return `<span class='label lbl-violetBoots'>${d.tipo_proceso}</span>`;
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.nombreResidencial + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + (d.nombreCondominio).toUpperCase(); + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.nombreLote + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.nombre + " " + d.apellido_paterno + " " + d.apellido_materno + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.nombreAsesor + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.nombreCoordinador + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.nombreGerente + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.nombreStatus + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.movimientoLote + '</p>';
            }
        },
        {
            data: function (d) {
                if (d.nombreSede == null || d.nombreSede == '') {
                    return `<span class="label lbl-azure">SIN UBICACIÓN</span>`;
                } else {
                    return `<span class="label lbl-azure">${d.nombreSede}</span>`;
                }
                
            }
        }],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: general_base_url + "Reestructura/reestructuraLotes",
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {
                "index_estatus": index_estatus,
            }
        },
        initComplete: function(){
            $("#spiner-loader").addClass('hide');
        },
        "order": [
            [1, 'asc']
        ],
    });
    
    $('#tabla_inventario').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}