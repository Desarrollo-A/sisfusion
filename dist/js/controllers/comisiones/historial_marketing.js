$(document).ready(function() {
    $("#tabla_historialGral").prop("hidden", true);
    
    $.post(url+"Contratacion/lista_proyecto_dos", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#filtro33").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#filtro33").selectpicker('refresh');
    }, 'json');       
});

$('#filtro33').change(function(ruta){
residencial = $('#filtro33').val();
param = $('#param').val();
$("#filtro44").empty().selectpicker('refresh');
    $.ajax({
        url: url+'Contratacion/lista_condominio_dos/'+residencial,
        type: 'post',
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++)
            {
                var id = response[i]['idCondominio'];
                var name = response[i]['nombre'];
                $("#filtro44").append($('<option>').val(id).text(name));
            }
            $("#filtro44").selectpicker('refresh');
        }
    });
});

$('#filtro33').change(function(ruta){
    proyecto = $('#filtro33').val();
    condominio = $('#filtro44').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    if(proyecto == 11 || proyecto == 12){
        console.log(proyecto);
    }
    else{
        getAssimilatedCommissions(proyecto, condominio);
    }
});

$('#filtro44').change(function(ruta){
    proyecto = $('#filtro33').val();
    condominio = $('#filtro44').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getAssimilatedCommissions(proyecto, condominio);
});

function cleanCommentsAsimilados() {
    var myCommentsList = document.getElementById('comments-list-asimilados');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}

$('#tabla_historialGral thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    if(i != 16){

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

function getAssimilatedCommissions(proyecto, condominio){
    let titulos = [];
    $("#tabla_historialGral").prop("hidden", false);
    tabla_historialGral2 = $("#tabla_historialGral").DataTable({
        dom: 'Brtip',
        width: 'auto',
        select: {
            style: 'single'
        },
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'HISTORIAL_GENERAL_SISTEMA_COMISIONES',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                format: {
                    header:  function (d, columnIdx) {
                        if(columnIdx == 0){
                            //  return ' '+d +' ';
                            return 'ID PAGO';
                        }else if(columnIdx == 1){
                            return 'PROYECTO';
                        }else if(columnIdx == 2){
                            return 'CONDOMINIO';
                        }else if(columnIdx == 3){
                            return 'NOMBRE LOTE';
                        }else if(columnIdx == 4){
                            return 'REFERENCIA';
                        }else if(columnIdx == 5){
                            return 'PRECIO LOTE';
                        }else if(columnIdx == 6){
                            return 'TOTAL COMISIÓN';
                        }else if(columnIdx == 7){
                            return 'PAGO CLIENTE';
                        }else if(columnIdx == 8){
                            return 'DISPERSADO NEODATA';
                        }else if(columnIdx == 9){
                            return 'PAGADO';
                        }else if(columnIdx == 10){
                            return 'PENDIENTE';
                        }else if(columnIdx == 11){
                            return 'COMISIONISTA';
                        }else if(columnIdx == 12){
                            return 'PUESTO';
                        }else if(columnIdx == 13){
                            return 'DETALLE';
                        }else if(columnIdx == 14){
                            return 'ESTATUS ACTUAL';
                        }else if(columnIdx != 15 && columnIdx !=0){
                            return ' '+titulos[columnIdx-1] +' ';
                        }
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: url+"/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            "width": "5%",
            "data": function( d ){
                var lblStats;
                lblStats ='<p class="m-0"><b>'+d.id_pago_i+'</b></p>';
                return lblStats;
            }
        },
        {
            "width": "5%",
            "data": function( d ){
                return '<p class="m-0">'+d.proyecto+'</p>';
            }
        },
        {
            "width": "6%",
            "data": function( d ){
                return '<p class="m-0">'+d.condominio+'</p>';
            }
        },
        {
            "width": "7%",
            "data": function( d ){
                return '<p class="m-0">'+d.nombreLote+'</p>';
            }
        },
        {
            "width": "5%",
            "data": function( d ){
                return '<p class="m-0">'+d.referencia+'</p>';
            }
        },
        {
            "width": "7%",
            "data": function( d ){
                return '<p class="m-0">$'+formatMoney(d.precio_lote)+'</p>';
            }
        },
        {
            "width": "7%",
            "data": function( d ){
                return '<p class="m-0">$'+formatMoney(d.comision_total)+' </p>';
            }
        },
        {
            "width": "7%",
            "data": function( d ){
                return '<p class="m-0">$'+formatMoney(d.pago_neodata)+'</p>';
            }
        },
        {
            "width": "7%",
            "data": function( d ){
                return '<p class="m-0"><b>$'+formatMoney(d.pago_cliente)+'</b></p>';
            }
        },
        {
            "width": "7%",
            "data": function( d ){
                return '<p class="m-0">$'+formatMoney(d.pagado)+'</p>';
            }
        },
        {
            "width": "7%",
            "data": function( d ){
                if(d.restante==null||d.restante==''){
                    return '<p class="m-0">$'+formatMoney(d.comision_total)+'</p>';
                }
                else{
                    return '<p class="m-0">$'+formatMoney(d.restante)+'</p>';
                }
            }
        }, 
        {
            "width": "7%",
            "data": function( d ){
                if(d.activo == 0 || d.activo == '0'){
                    return '<p class="m-0"><b>'+d.user_names+'</b></p><p><span class="label" style="background:red;">BAJA</span></p>';
                }
                else{
                    return '<p class="m-0"><b>'+d.user_names+'</b></p>';
                }
            }
        },
        {
            "width": "7%",
            "data": function( d ){
                return '<p class="m-0"><B>'+d.sede_plaza+'<B></p>';
            }
        },
        {
            "width": "7%",
            "data": function( d ){
                if(d.bonificacion >= 1){
                    p1 = '<p class="m-0"><span class="label" style="background:pink;color: black;">Bonificación $'+formatMoney(d.bonificacion)+'</span></p>';
                }
                else{
                    p1 = '';
                }

                if(d.lugar_prospeccion == 0){
                    p2 = '<p class="m-0"><span class="label" style="background:RED;">Recisión de contrato</span></p>';
                }
                else{
                    p2 = '';
                }

                return p1 + p2 + '<p class="m-0">'+' SEDE ASESOR: </p>'+d.sede_pplaza+'</p>';
            }
        },
        {
            "width": "7%",
            "data": function( d ){
                var etiqueta;
                    
                if((d.id_estatus_actual == 11) && d.descuento_aplicado == 1 ){
                    etiqueta = '<p><span class="label" style="background:#ED7D72;">DESCUENTO</span></p>';
                }else if((d.id_estatus_actual == 12) && d.descuento_aplicado == 1 ){
                    etiqueta = '<p><span class="label" style="background:#EDB172;">DESCUENTO RESGUARDO</span></p>';
                }else if((d.id_estatus_actual == 0) && d.descuento_aplicado == 1 ){
                    etiqueta = '<p><span class="label" style="background:#ED8172;">DESCUENTO EN PROCESO</span></p>';
                }else if((d.id_estatus_actual == 16) && d.descuento_aplicado == 1 ){
                    etiqueta = '<p><span class="label" style="background:#ED8172;">DESCUENTO DE PAGO</span></p>';
                }else if((d.id_estatus_actual == 17) && d.descuento_aplicado == 1 ){
                    etiqueta = '<p><span class="label" style="background:#ED72B9;">DESCUENTO UNIVERSIDAD</span></p>';
                }else{

                    switch(d.id_estatus_actual){
                        case '1':
                        case 1:
                        case '2':
                        case 2:
                        case '12':
                        case 12:
                        case '14':
                        case 14:
                        case '13':
                        case 13:
                        case '14':
                        case 14:
                        case '51':
                        case 51:
                        case '52':
                        case 52:
                            etiqueta = '<p><span class="label" style="background:#29A2CC;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '3':
                        case 3:
                            etiqueta = '<p><span class="label" style="background:#CC6C29;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '4':
                        case 4:
                            etiqueta = '<p><span class="label" style="background:#9129CC;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '5':
                        case 5:
                            etiqueta = '<p><span class="label" style="background:#CC2976;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '6':
                        case 6:
                            etiqueta = '<p><span class="label" style="background:#81BFBE;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '7':
                        case 7:
                            etiqueta = '<p><span class="label" style="background:#28A255;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '8':
                        case 8:
                            etiqueta = '<p><span class="label" style="background:#4D7FA1;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '9':
                        case 9:
                            etiqueta = '<p><span class="label" style="background:#E86606;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '10':
                        case 10:
                            etiqueta = '<p><span class="label" style="background:#E89606;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '11':
                        case 11:

                        if(d.pago_neodata < 1){
                            etiqueta = '<p><span class="label" style="background:#05A134;">'+d.estatus_actual+'</span></p><p><span class="label" style="background:#5FD482;">IMPORTACIÓN</span></p>';
                        }else{

                            etiqueta = '<p><span class="label" style="background:#05A134;">'+d.estatus_actual+'</span></p>';
                        }
                        break;

                        case '88':
                        case 88:
                            etiqueta = '<p><span class="label" style="background:#A1055A;">'+d.estatus_actual+'</span></p>';
                        break;

                        default:
                            etiqueta = '';
                        break;
                    }
                }

                return etiqueta;
            }
        },
        { 
            "width": "2%",
            "orderable": false,
            "data": function( data ){

                var BtnStats;

                BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.nombreLote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_asimilados"  title="Detalles">' +'<i class="fas fa-info"></i></button>';
                return '<div class="d-flex justify-center">'+BtnStats+'</div>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            'searchable':false,
            'className': 'dt-body-center',

            select: {
                style:    'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            "url": url2 + "Comisiones/getDatosHistorialPagoM/" + proyecto + "/" + condominio,
            "type": "POST",
            cache: false,
            "data": function( d ){}
        },
        order: [[ 1, 'asc' ]]
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


    // $("#tabla_historialGral tbody").on("click", ".cambiar_pausa", function(){
    //     var tr = $(this).closest('tr');
    //     var row = tabla_historialGral2.row( tr );

    //     id_pago_i = $(this).val();

    //     $("#modal_nuevas .modal-body").html("");
    //     $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de despausar la comisión de <b>'+row.data().nombreLote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().user_names+'</i>?</p></div></div>');
    //     $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="1"><input type="text" class="form-control observaciones" name="observaciones" required placeholder="Describe mótivo por el cual se va activar nuevamente la solicitud"></input></div></div>');
    //     $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'"><input type="hidden" name="estatus" id="estatus" readonly="true" value="4">');
    //     $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="ACTIVAR"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></div></div>');
    //     $("#modal_nuevas").modal();
    // });

    /*$("#tabla_historialGral tbody").on("click", ".actualizar_pago", function(){
        var tr = $(this).closest('tr');
        var row = tabla_historialGral2.row( tr );

        id_pago_i = $(this).val();

        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p> Actualizar pago <b>'+row.data().nombreLote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().user_names+'</i>?</p></div></div>');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="2"><input type="number" class="form-control observaciones" name="observaciones" required placeholder="Monto a editar"></input></div></div>');
        $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="ACTIVAR"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></div></div>');
        $("#modal_nuevas").modal();
    });*/

    /*$("#tabla_historialGral tbody").on("click", ".agregar_pago", function(){
        var tr = $(this).closest('tr');
        var row = tabla_historialGral2.row( tr );

        id_pago_i = $(this).val();

        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>Agregar nuevo pago a <b>'+row.data().nombreLote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().user_names+'</i>?</p></div></div>');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="3"><input type="number" class="form-control observaciones" name="observaciones" required placeholder="Monto a agregar"></input></div></div>');
        $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="ACTIVAR"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></div></div>');
        $("#modal_nuevas").modal();
    });*/
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

/*function cancela(){
    $("#modal_nuevas").modal('toggle');
}*/

//Función para pausar la solicitud
/*$("#form_interes").submit( function(e) {
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
                        // tabla_otras2.ajax.reload();
                    }, 3000);
                }else{
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");

                }
            },error: function( ){
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});*/

/*$(document).on("click", ".btn-historial-lo", function(){
    window.open(url+"Comisiones/getHistorialEmpresa", "_blank");
});*/

/*function cleanComments(){
    var myCommentsList = document.getElementById('documents');
    myCommentsList.innerHTML = '';

    var myFactura = document.getElementById('facturaInfo');
    myFactura.innerHTML = '';
}*/