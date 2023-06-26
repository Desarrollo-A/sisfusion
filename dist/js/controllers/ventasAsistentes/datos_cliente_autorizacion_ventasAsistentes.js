$(document).ready(function(){
    $.post(general_base_url + "Asistente_gerente/lista_proyecto", function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcionConcat'];
            $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#proyecto").selectpicker('refresh');
    }, 'json');
});

$('#proyecto').change( function() {
   index_proyecto = $(this).val();
   $("#condominio").html("");
   $('#spiner-loader').removeClass('hide');
   $(document).ready(function(){
    $.post(general_base_url + "Asistente_gerente/lista_condominio/"+index_proyecto, function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['idCondominio'];
            var name = data[i]['nombre'];
            $("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#condominio").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
});

});


 $('#condominio').change( function() {
   index_condominio = $(this).val();
   $("#lote").html("");
   $('#spiner-loader').removeClass('hide');
   $(document).ready(function(){
    $.post(general_base_url + "Asistente_gerente/lista_lote/"+index_condominio, function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['idLote'];
            var name = data[i]['nombreLote'];
            $("#lote").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#lote").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');

});

});

$('#lote').change( function() { 
   index_lote = $(this).val();
   $("#spiner-loader").removeClass("hide");
   $("#tabla_autorizaciones_ventas").removeClass('hide');
            tabla_autorizaciones = $("#tabla_autorizaciones_ventas").DataTable({
            width: '100%',
            dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            destroy: true,
            "ajax":
                {
                    "url": general_base_url + 'index.php/Asistente_gerente/get_lote_autorizacion/'+index_lote,
                    "dataSrc": ""
                },initComplete: function () {
                    $("#spiner-loader").addClass("hide");
                },
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Autorizaciones por ingresar',
                    title:'Autorizaciones por ingresar',
                    exportOptions: {
                        columns: [0,1,2,3],
                        format: {
                            header: function (d, columnIdx) {
                                return ' '+titulos[columnIdx] +' ';
                            }
                        }
                    },

                }
            ],
            pagingType: "full_numbers",
            language: {
                url: general_base_url + '/static/spanishLoader_v2.json',
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
                {data: 'nombreLote'},
                {data: 'condominio'},
                {data: 'nombreResidencial'},
                {
                    data: null,
                    render: function ( data, type, row )
                    {
                        return data.nombre+' ' +data.apellido_paterno+' '+data.apellido_materno;
                    },
                },

                { 
                    "orderable": false,
                    "data": function( data ){
                        var id_rol = localStorage.getItem('id_rol');

                    if(id_rol==53){
                        opciones = '<div class="btn-group" role="group">';
                                opciones += '<div class="col-md-1 col-sm-1"><button class="btn btn-just-icon btn-info" disabled><i class="material-icons">open_in_browser</i></button></div>';
                                return opciones + '</div>';
                    }else{
                        opciones = '<div class="btn-group" role="group">';
                                opciones += '<div class="col-md-1 col-sm-1"><button class="btn-data btn-blueMaderas agregar_autorizacion" title="SUBIR ARCHIVO" data-toggle="tooltip" data-placement="top" data-id_condominio="'+data.idCondominio+'" data-id_cliente="'+data.id_cliente+'" data-idClienteHistorial="'+data.id_cliente+'" data-idLoteHistorial="'+data.idLote+'" data-id_user="'+id_usuario_general+'" data-nomResidencial="'+data.nombreResidencial+'" data-nomLote="'+data.nombreLote+'" data-nomCondominio="'+data.condominio+'"><i class="fas fa-plus"></i></button></div>';
                                return opciones + '</div>';
                        }
                        
                    } 
                }

            ]

    });

    $('#tabla_autorizaciones_ventas').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

$("#tabla_autorizaciones_ventas tbody").on("click", ".agregar_autorizacion", function(){

var tr = $(this).closest('tr');
var row = tabla_autorizaciones.row( tr );

idautopago = $(this).val();

    $('#idCliente').val($(this).attr("data-id_cliente"));//data-id_cliente
    $('#idClienteHistorial').val($(this).attr("data-idclientehistorial"));//data-idclientehistorial
    $('#idLoteHistorial').val($(this).attr("data-idlotehistorial"));
    $('#idUser').val($(this).attr("data-id_condominio"));
    $('#idCondominio').val($(this).attr("data-id_user"));
    $('#nombreResidencial').val($(this).attr("data-nomResidencial"));
    $('#nombreLote').val($(this).attr("data-nomLote"));
    $('#nombreCondominio').val($(this).attr("data-nomCondominio"));

    $("#modal_autorizacion .modal-body").html("");
    $("#modal_autorizacion .modal-body").append('<div class="file-gph"><input class="d-none" type="file" id="expediente${i}" name="expediente${i}" onchange="changeName(this)"><input class="file-name" type="text" placeholder="No has seleccionada nada aún" readonly required><label class="upload-btn m-0" for="expediente${i}" readonly><span>Buscar</span><i class="fas fa-search text-right"></i></label></div>');
    $("#modal_autorizacion").modal();
});

});

function changeName(e){
    const fileName = e.files[0].name;
    let relatedTarget = $( e ).closest( '.file-gph' ).find( '.file-name' );
    relatedTarget[0].value = fileName;
}

let titulos = [];
$('#tabla_autorizaciones_ventas thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html('<input class="textoshead" type="text" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if (tabla_autorizaciones.column(i).search() !== this.value) {
            tabla_autorizaciones.column(i).search(this.value).draw();
        }
    });
});

$(window).resize(function(){
    tabla_autorizaciones.columns.adjust();
});