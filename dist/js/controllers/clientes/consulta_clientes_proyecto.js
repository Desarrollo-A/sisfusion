$( document ).ready(function() {
    $.post(general_base_url + "Contratacion/lista_proyecto", function(data) {
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
    id_proyecto = $("#proyecto").val();

    getClientsByProyect(id_proyecto);


    $(window).resize(function(){
        tabla_clientes.columns.adjust();
    });
});

function getClientsByProyect(id_proyecto){
    $('#tabla_clientes thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        $(this).html('<input class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_clientes').DataTable().column(i).search() !== this.value ) {
                $('#tabla_clientes').DataTable().column(i).search(this.value).draw();
            }
        });
    });

    $('#tabla_clientes').DataTable({
        destroy: true,
        ajax:
            {
                url: 'getClientsByProyect/'+id_proyecto,
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
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8 , 9, 10],
                format: {
                    header: function (d, columnIdx) {
                        switch (columnIdx) {
                            case 0:
                                return 'PROYECTO'
                                break;
                            case 1:
                                return 'CONDOMINIO';
                                break;
                            case 2:
                                return 'ID LOTE';
                                break;
                            case 3:
                                return 'ESTATUS CONTRATACION';
                                break;
                            case 4:
                                return 'ESTATUS LOTE';
                                break;
                            case 5:
                                return 'NOMBRE COMPLETO';
                                break;
                            case 6:
                                return 'FECHA APARTADO';
                                break;
                            case 7:
                                return 'PERSONALIDAD JURIDICA';
                                break;
                            case 8:
                                return 'FECHA NACIMIENTO';
                                break;
                            case 9:
                                return 'EDAD';
                                break;
                            case 10:
                                return 'OCUPACION';
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
                {data: 'proyecto'},
                {data: 'nombre_condominio'},
                {data: 'nombreLote'},
                {data: 'StatusContratacion'},
                {data: 'StatusLote'},
                {data: 'nombre_completo'},
                {
                    "data": function(d){
                        return '<p>'+myFunctions.convertDateYMDHMS(d.fechaApartado)+'</p>';
                    }
                },
                {data: 'nombre'},
                {data: 'fecha_nacimiento'},
                {
                    "data": function (d) {
                        if (d.edad == null || d.edad == 'null') {
                            return '<center>'+ d.edadFirma+'<p><p> <span class="label label-danger" style="background:#00bcd41f; color:#00bcd4">Edad de firma</span> </center>';
                        }else{
                            return d.edad;
                        }
                    }
                },
                {data: 'ocupacion'}
            ]
    });
}