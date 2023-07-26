$(document).ready(function() {
    query = false
    getAssimilatedCommissions(query);
});

$('#tabla_historialGral').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

$('#filtro33').change(function(){
    let tipo_usuario = $(this).val();
    query  = " AND com.rol_generado = "+ tipo_usuario +" " ;
    getAssimilatedCommissions(query);
});
var tr;
var tabla_historialGral2 ;
let titulos = [];

$('#tabla_historialGral thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    if(i != 15){
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_historialGral').DataTable().column(i).search() !== this.value ) {
                $('#tabla_historialGral').DataTable().column(i).search(this.value).draw();
            }
        });
    }
});

function getAssimilatedCommissions(query ){
    if (query == false){
        query = '';
    }
    tabla_historialGral2 = $("#tabla_historialGral").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'Reporte devoluciones',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            }
        },
        ],
        pagingType: "full_numbers",
        fixedHeader: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            data: function( d ){
                return d.id_pago_i; //id pago
            }
            },
            {
                data: function( d ){
                    return d.nombreLote; //Nombre lote
                }
            },
            {
                data: function( d ){
                    return d.empresa; //nombre de empresa
                }
            },
            {
                data: function( d ){
                    return d.user_names; //nombre de usuario
                }
            },
            {
                data: function( d ){
                    return d.id_usuario; //clave del usuario
                }
            },
            {
                data: function( d ){
                    return d.fecha_pago;    // fecha de pagoo
                }
            },
            {
                data: function( d ){
                    return d.puesto; //puesto actual
                }
            },
            {
                data: function( d ){
                    return d.abono; //abono_neodata      
                }
            },
            {
                data: function( d ){
                    return d.sede; //SEDE      
                }
                
            },
            {
                data: function( d ){
                    return d.creado; 
                } // Creado por
            },
                ],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: "getInfoReporteDevolucion" ,
            type: "POST",
            data:{
                query : query 
            },
            cache: false,
            
        }
       
    });

    $("#tabla_historialGral tbody").on("click", ".consultar_logs_asimilados", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();

        id_pago = $(this).val();
        lote = $(this).attr("data-value");

        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:gray;">'+v.comentario+'</i><br><b style="color:#3982C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
            });
        });
    });

    $("#tabla_historialGral tbody").on("click", ".actualizar_pago", function(){
        var tr = $(this).closest('tr');
        var row = tabla_historialGral2.row( tr );

        id_pago_i = $(this).val();

        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p> Actualizar pago <b>'+row.data().nombreLote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().user_names+'</i>?</p></div></div>');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="2"><input type="number" class="form-control observaciones" name="observaciones" required placeholder="Monto a editar"></input></div></div>');
        $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="ACTIVAR"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></div></div>');
        $("#modal_nuevas").modal();
    });

    $("#tabla_historialGral tbody").on("click", ".agregar_pago", function(){
        var tr = $(this).closest('tr');
        var row = tabla_historialGral2.row( tr );

        id_pago_i = $(this).val();

        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>Agregar nuevo pago a <b>'+row.data().nombreLote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().user_names+'</i>?</p></div></div>');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="3"><input type="number" class="form-control observaciones" name="observaciones" required placeholder="Monto a agregar"></input></div></div>');
        $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="ACTIVAR"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></div></div>');
        $("#modal_nuevas").modal();
    });
}