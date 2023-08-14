$(document).ready(function () {
    $.post(general_base_url + "Contratacion/lista_proyecto", function(data) {
        var len = data.length;
        for(var i = 0; i<len; i++){
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#proyecto").selectpicker('refresh');
    }, 'json');
});


$(document).on('change','#proyecto', function() {
    $('#spiner-loader').removeClass('hide');
    $('#repAdministracion').removeClass('hide');
    ix_proyecto = $("#proyecto").val();
    repAdmon(ix_proyecto);
    $(window).resize(function(){
        tabla_inventario.columns.adjust();
    });
});

let titulos_intxt = [];
function repAdmon(idResidencial) {
    $('#repAdministracion thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos_intxt.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $( 'input', this ).on('keyup change', function () {
            if ($('#repAdministracion').DataTable().column(i).search() !== this.value ) {
                $('#repAdministracion').DataTable().column(i).search(this.value).draw();
            }
        });
    });

    $('#repAdministracion').DataTable({
        destroy: true,
        ajax:
        {
            url: 'getRepoAdmin/'+idResidencial,
            dataSrc: "",
            type: "POST",
            cache: false
        },
        initComplete: function(){
            $("#spiner-loader").addClass('hide');
        },
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        bAutoWidth: true,
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
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                format: 
                {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
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
        columns:[{
            data: 'Proyecto'
        },
        {
            data: 'nombre_condominio'
        },
        {
            data: 'nombreLote'
        },
        {
            data: 'idLote'
        },
        {
            data: 'nombreCliente'
        },
        {
            'data': function(d){
                return '<p>'+d.fecha11.split('.')[0]+'</p>';
            }
        },
        {
            "data": function(d){
                return '<p>'+myFunctions.convertDateYMDHMS(d.fechaLiberacion)+'</p>';
            }
        },
        {
            data: 'nombre'
        },
        {
            data: 'idStatusContratacion'
        }]
    });

    $('#repAdministracion').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}

