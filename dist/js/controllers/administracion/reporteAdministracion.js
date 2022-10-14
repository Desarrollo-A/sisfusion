$(document).ready(function () {

    $.post(url + "Contratacion/lista_proyecto", function(data) {
        var len = data.length;
        for(var i = 0; i<len; i++)
        {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
        }

        $("#proyecto").selectpicker('refresh');
    }, 'json');

});


$(document).on('change','#proyecto', function() {
    ix_proyecto = $("#proyecto").val();

    repAdmon(ix_proyecto);


    $(window).resize(function(){
        tabla_inventario.columns.adjust();
    });
});


function repAdmon(idResidencial) {
    $('#repAdministracion thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        $(this).html('<input class="textoshead"  placeholder="'+title+'"/>' );
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
        dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
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
                columns: [0, 1, 2, 3, 4, 5, 6, 7],
                format: {
                    header: function (d, columnIdx) {
                        switch (columnIdx) {
                            case 0:
                                return 'RESIDENCIAL'
                                break;
                            case 1:
                                return 'CONDOMINIO';
                                break;
                            case 2:
                                return 'LOTE';
                                break;
                            case 3:
                                return 'ID LOTE';
                                break;
                            case 4:
                                return 'NOMBRE CLIENTE';
                                break;
                            case 5:
                                return 'FECHA 9';
                                break;
                            case 6:
                                return 'FECHA LIBERACION';
                                break;
                            case 7:
                                return 'MOTIVO LIBERACION';
                                break;
                        }
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
                {data: 'Proyecto'},
                {data: 'nombre_condominio'},
                {data: 'nombreLote'},
                {data: 'idLote'},
                {data: 'nombreCliente'},
                {data: 'fecha9'},
                {
                    "data": function(d){
                        return '<p>'+myFunctions.convertDateYMDHMS(d.fechaLiberacion)+'</p>';
                    }
                },
                {data: 'nombre'}
            ]
    });
}

