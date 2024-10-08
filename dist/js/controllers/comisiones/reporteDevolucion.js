var url = "<?=base_url()?>";
$(document).ready(function() {
    console.log('mmensaje ');
    query = false
   // $("#tabla_historialGral").prop("hidden", true);
   getAssimilatedCommissions(query);
});

$('#filtro33').change(function(){

    // console.log($(this).val());
    let tipo_usuario = $(this).val();
    console.log(tipo_usuario);
    
    query  = " AND com.rol_generado = "+ tipo_usuario +" " ;
    getAssimilatedCommissions(query);
});

$('#filtro44').change(function(ruta){
    id_usuario = $('#filtro44').val();
    getAssimilatedCommissions(id_usuario);
});

function cleanCommentsAsimilados() {
    var myCommentsList = document.getElementById('comments-list-asimilados');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}

$('#tabla_historialGral thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    if(i != 15){
        $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_historialGral').DataTable().column(i).search() !== this.value ) {
                $('#tabla_historialGral').DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    }
});

var url = "<?=base_url()?>";
var url2 = "<?=base_url()?>index.php/";
var totalLeon = 0;
var totalQro = 0;
var totalSlp = 0;
var totalMerida = 0;
var totalCdmx = 0;
var totalCancun = 0;
var tr;
var tabla_historialGral2 ;
var totaPen = 0;

//INICIO TABLA QUERETARO****************************************************************************************

function getAssimilatedCommissions(query ){
    let titulos = [];
    if (query == false){
        query = '';
    }
    tabla_historialGral2 = $("#tabla_historialGral").DataTable({
        dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: 'auto',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'Reporte devoluciones',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9],
                format: {
                    header:  function (d, columnIdx) {
                        switch (columnIdx) {
                            case 0:
                                return 'ID PAGO';
                                break;
                            case 1:
                                return 'LOTE';
                                break;
                            case 2:
                                return 'EMPRESA';
                                break;
                            case 3 :
                                return 'USUARIO';
                                break;   
                            case 4 :
                                return 'ID USUARIO';
                                break;
                            case 5 :
                                return 'FECHA PAGO';
                                break;
                            case 6 :
                                return 'PUESTO';
                                break;
                            case 7 :
                                return 'ABONO';
                                break;     
                            case 8 :
                                return 'SEDE';
                                break;
                            case 9 :
                                return 'MOTIVO';
                                break ;                                                             
                        }
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
            url: "./..//static/spanishLoader_v2.json",
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
                    return d.fecha_devolucion;    // fecha de pagoo
                }
            },  
             {
                data: function( d ){
                    return d.fecha_pago_intmex;    // fecha de pagoo
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
            "url": "getInfoReporteDevolucion" ,
            "type": "POST",
            "data":{
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

//FIN TABLA  ****************************************************************************************
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});

function formatMoney( n ) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

function cancela(){
    $("#modal_nuevas").modal('toggle');
}

//Función para pausar la solicitud
$("#form_interes").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        console.log(data);
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: url + "Comisiones/despausar_solicitud",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                if( data[0] ){
                    $("#modal_nuevas").modal('toggle' );
                    alerts.showNotification("top", "right", "Se ha pausado la comisión exitosamente", "success");
                    setTimeout(function() {
                        tabla_historialGral2.ajax.reload();
                    }, 3000);
                }else{
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");

                }
            },error: function( ){
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});

$(document).on("click", ".btn-historial-lo", function(){
    window.open(url+"Comisiones/getHistorialEmpresa", "_blank");
});

function cleanComments(){
    var myCommentsList = document.getElementById('documents');
    myCommentsList.innerHTML = '';

    var myFactura = document.getElementById('facturaInfo');
    myFactura.innerHTML = '';
}