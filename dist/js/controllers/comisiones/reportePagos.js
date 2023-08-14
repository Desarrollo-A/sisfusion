
$(document).ready(function() {
    $("#tabla_historialGral").prop("hidden", true);
});

$('#filtro33').change(function(){
    let tipo_usuario = $(this).val();
    $("#filtro44").empty();
    $.post('getByTypeOU/' + tipo_usuario, function (data) {
        console.log("Data: ", data);
        data.map(function(element, index){
            let nombre = element.nombre + " " + element.apellido_paterno + " " + element.apellido_materno;
            $("#filtro44").append($('<option>').val(element.id_usuario).text(nombre));
        });
        $("#filtro44").selectpicker('refresh');
    }, 'json');
});

$('#tabla_historialGral').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
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

let titulos = [];
$('#tabla_historialGral thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
    $( 'input', this ).on('keyup change', function () {
        if ($('#tabla_historialGral').DataTable().column(i).search() !== this.value ) {
            $('#tabla_historialGral').DataTable().column(i).search(this.value).draw();
        }
    });
});

var tr;
var tabla_historialGral2 ;

function getAssimilatedCommissions(id_usuario){
    $("#tabla_historialGral").prop("hidden", false);
    tabla_historialGral2 = $("#tabla_historialGral").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'Historial general del sistema de comisiones',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos [columnIdx] + ' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            {
            data: function( d ){
                var lblStats;
                lblStats ='<p class="m-0"><b>'+d.id_pago_i+'</b></p>';
                return lblStats;
            }
        },
            {
                data: function( d ){
                    return '<p class="m-0">'+d.proyecto+'</p>';
                }
            },
            {
                data: function( d ){
                    return '<p class="m-0">'+d.condominio+'</p>';
                }
            },
            {
                data: function( d ){
                    return '<p class="m-0">'+d.nombreLote+'</p>';
                }
            },
            {
                data: function( d ){
                    return '<p class="m-0">'+d.referencia+'</p>';
                }
            },
            {
                data: function( d ){
                    return '<p class="m-0">'+formatMoney(d.precio_lote)+'</p>';
                }
            },
            {
                data: function( d ){
                    return '<p class="m-0">'+formatMoney(d.comision_total)+' </p>';
                }
            },
            {
                data: function( d ){
                    return '<p class="m-0">'+formatMoney(d.pago_neodata)+'</p>';
                }
            },
            {
                data: function( d ){
                    return '<p class="m-0"><b>'+formatMoney(d.pago_cliente)+'</b></p>';
                }
            },
            {
                data: function( d ){
                    return '<p class="m-0">'+formatMoney(d.pagado)+'</p>';
                }
            },
            {
                data: function( d ){
                    if(d.restante==null||d.restante==''){
                        return '<p class="m-0">'+formatMoney(d.comision_total)+'</p>';
                    }
                    else{
                        return '<p class="m-0">'+formatMoney(d.restante)+'</p>';
                    }
                }
            },
            {
                data: function( d ){
                    if(d.activo == 0 || d.activo == '0'){
                        return '<p class="m-0"><b>'+d.user_names+'</b></p><p><span class="label lbl-warning">BAJA</span></p>';
                    }
                    else{
                        return '<p class="m-0"><b>'+d.user_names+'</b></p><p><span class="label lbl-green">ACTIVO</span></p>';
                    }
                }
            },
            {
                data: function( d ){
                    return '<p class="m-0">'+d.puesto+'</p>';
                }
            },
            {
                data: function( d ){
                    if(d.bonificacion >= 1){
                        p1 = '<p class="m-0"><span class="label lbl-pink">Bonificación '+formatMoney(d.bonificacion)+'</span></p>';
                    }
                    else{
                        p1 = '';
                    }
                    if(d.lugar_prospeccion == 0){
                        p2 = '<p class="m-0"><span class="label lbl-warning">Recisión de contrato</span></p>';
                    }
                    else{
                        p2 = '';
                    }
                    return p1 +p2 ;
                }
            },
            {
                data: function( d ){
                    var etiqueta;
                    if((d.id_estatus_actual == 11) && d.descuento_aplicado == 1 ){
                        etiqueta = '<p><span class="label lbl-melon">DESCUENTO</span></p>';
                    }else if((d.id_estatus_actual == 12) && d.descuento_aplicado == 1 ){
                        etiqueta = '<p><span class="label lbl-orangeYellow">DESCUENTO RESGUARDO</span></p>';
                    }else if((d.id_estatus_actual == 0) && d.descuento_aplicado == 1 ){
                        etiqueta = '<p><span class="label lbl-violetBoots">DESCUENTO EN PROCESO</span></p>';
                    }else if((d.id_estatus_actual == 16) && d.descuento_aplicado == 1 ){
                        etiqueta = '<p><span class="label lbl-violetChin">DESCUENTO DE PAGO</span></p>';
                    }else if((d.id_estatus_actual == 17) && d.descuento_aplicado == 1 ){
                        etiqueta = '<p><span class="label lbl-violetDeep">DESCUENTO UNIVERSIDAD</span></p>';
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
                                etiqueta = '<p><span class="label lbl-azure">'+d.estatus_actual+'</span></p>';
                                break;
                            case '3':
                            case 3:
                                etiqueta = '<p><span class="label lbl-azure">'+d.estatus_actual+'</span></p>';
                                break;
                            case '4':
                            case 4:
                                etiqueta = '<p><span class="label  lbl-azure">'+d.estatus_actual+'</span></p>';
                                break;
                            case '5':
                            case 5:
                                etiqueta = '<p><span class="label  lbl-azure">'+d.estatus_actual+'</span></p>';
                                break;
                            case '6':
                            case 6:
                                etiqueta = '<p><span class="label  lbl-azure">'+d.estatus_actual+'</span></p>';
                                break;
                            case '7':
                            case 7:
                                etiqueta = '<p><span class="label  lbl-azure">'+d.estatus_actual+'</span></p>';
                                break;
                            case '8':
                            case 8:
                                etiqueta = '<p><span class="label  lbl-azure">'+d.estatus_actual+'</span></p>';
                                break;
                            case '9':
                            case 9:
                                etiqueta = '<p><span class="label  lbl-azure">'+d.estatus_actual+'</span></p>';
                                break;
                            case '10':
                            case 10:
                                etiqueta = '<p><span class="label  lbl-azure">'+d.estatus_actual+'</span></p>';
                                break;
                            case '11':
                            case 11:
                                if(d.pago_neodata < 1){
                                    etiqueta = '<p><span class="label  lbl-azure">'+d.estatus_actual+'</span></p><p><span class="label lbl-oceanGreen">IMPORTACIÓN</span></p>';
                                }else{
                                    etiqueta = '<p><span class="label  lbl-azure">'+d.estatus_actual+'</span></p>';
                                }
                                break;
                            case '88':
                            case 88:
                                etiqueta = '<p><span class="label lbl-azure">'+d.estatus_actual+'</span></p>';
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
                orderable: false,
                data: function( data ){
                    var BtnStats;
                    BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.nombreLote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_asimilados"  data-toggle="tooltip"  data-placement="top" title="DETALLES">' +'<i class="fas fa-info"></i></button>';
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
            "url": general_base_url + "Comisiones/getDatosHistorialPagoRP/" + id_usuario,
            "type": "POST",
            cache: false,
            data: function( d ){}
        },
        order: [[ 1, 'asc' ]]
    });

    $("#tabla_historialGral tbody").on("click", ".consultar_logs_asimilados", function(e){
        $('#spiner-loader').removeClass('hide');
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").append('<p><h5>HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append(
                '<li>\n' +
                    '  <div class="container-fluid">\n' +
                        '    <div class="row">\n' +
                        '      <div class="col-md-6">\n' +
                                '        <a><b> ' +v.comentario.toUpperCase()+ '</b></a><br>\n' +
                            '      </div>\n' +
                        '      <div class="float-end text-right">\n' +
                        '        <a>' + v.fecha_movimiento + '</a>\n' +
                        '      </div>\n' +
                        '      <div class="col-md-12">\n' +
                        '        <p class="m-0"><small>Usuario: </small><b> ' + v.nombre_usuario + '</b></p>\n'+
                        '      </div>\n' +
                        '    <h6>\n' +
                        '    </h6>\n' +
                    '    </div>\n' +
                    '  </div>\n' +
                '</li>');
            });
            $('#spiner-loader').addClass('hide');
        });
    });

}

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});

function cleanComments(){
    var myCommentsList = document.getElementById('documents');
    myCommentsList.innerHTML = '';
    var myFactura = document.getElementById('facturaInfo');
    myFactura.innerHTML = '';
}