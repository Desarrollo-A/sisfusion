$(document).ready(function() {
    $("#tabla_historialGral").prop("hidden", true);
    
    $.post(general_base_url + "Contratacion/lista_proyecto", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#catalogoHistorial").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#catalogoHistorial").selectpicker('refresh');
    }, 'json');       
});

$('#catalogoHistorial').change(function(ruta){
residencial = $('#catalogoHistorial').val();
param = $('#param').val();
$("#condominioHistorial").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url + 'Contratacion/lista_condominio/'+residencial,
        type: 'post',
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++)
            {
                var id = response[i]['idCondominio'];
                var name = response[i]['nombre'];
                $("#condominioHistorial").append($('<option>').val(id).text(name));
            }
            $("#condominioHistorial").selectpicker('refresh');
        }
    });
});

$('#catalogoHistorial').change(function(ruta){
    proyecto = $('#catalogoHistorial').val();
    condominio = $('#condominioHistorial').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    if(proyecto == 11 || proyecto == 12){
        // console.log(proyecto);
    }
    else{
        getAssimilatedCommissions(proyecto, condominio);
    }
});

$('#condominioHistorial').change(function(ruta){
    proyecto = $('#catalogoHistorial').val();
    condominio = $('#condominioHistorial').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getAssimilatedCommissions(proyecto, condominio);
});

let titulos_intxt = [];
$('#tabla_historialGral thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#tabla_historialGral').DataTable().column(i).search() !== this.value ) {
            $('#tabla_historialGral').DataTable().column(i).search(this.value).draw();
        }
    });
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

function getAssimilatedCommissions(proyecto, condominio){
    let titulos = [];
    $("#tabla_historialGral").prop("hidden", false);
    tabla_historialGral2 = $("#tabla_historialGral").DataTable({
        dom: 'Brt'+"<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        bAutoWidth: true,
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
                        return ' ' + titulos_intxt[columnIdx] + ' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            "data": function( d ){
                var lblStats;
                lblStats ='<p class="m-0"><b>'+d.id_pago_i+'</b></p>';
                return lblStats;
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.proyecto+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.condominio+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.nombreLote+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.referencia+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.precio_lote)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.comision_total)+' </p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.pago_neodata)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+formatMoney(d.pago_cliente)+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.pagado)+'</p>';
            }
        },
        {
            "data": function( d ){
                if(d.restante==null||d.restante==''){
                    return '<p class="m-0">'+formatMoney(d.comision_total)+'</p>';
                }
                else{
                    return '<p class="m-0">'+formatMoney(d.restante)+'</p>';
                }
            }
        }, 
        {
            "data": function( d ){
                if(d.activo == 0 || d.activo == '0'){
                    return '<p class="m-0"><b>'+d.user_names+'</b></p><p><span class="label lbl-warning">BAJA</span></p>';
                }
                else{
                    return '<p class="m-0"><b>'+d.user_names+'</b></p>';
                }
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><B>'+d.sede_plaza+'<B></p>';
            }
        },
        {
            "data": function( d ){
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
                return p1 + p2 + '<p class="m-0">'+' SEDE ASESOR: </p>'+d.sede_pplaza+'</p>';
            }
        },
        {
            "data": function( d ){
                var etiqueta;
                    
                if((d.id_estatus_actual == 11) && d.descuento_aplicado == 1 ){
                    etiqueta = '<p><span class="label lbl-melon">DESCUENTO</span></p>';
                }else if((d.id_estatus_actual == 12) && d.descuento_aplicado == 1 ){
                    etiqueta = '<p><span class="label lbl-orangeYellow">DESCUENTO RESGUARDO</span></p>';
                }else if((d.id_estatus_actual == 0) && d.descuento_aplicado == 1 ){
                    etiqueta = '<p><span class="label lbl-melon">DESCUENTO EN PROCESO</span></p>';
                }else if((d.id_estatus_actual == 16) && d.descuento_aplicado == 1 ){
                    etiqueta = '<p><span class="label lbl-melon">DESCUENTO DE PAGO</span></p>';
                }else if((d.id_estatus_actual == 17) && d.descuento_aplicado == 1 ){
                    etiqueta = '<p><span class="label lbl-pink">DESCUENTO UNIVERSIDAD</span></p>';
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
                            etiqueta = '<p><span class="label lbl-blueMaderas">'+d.estatus_actual+'</span></p>';
                        break;
                        case '3':
                        case 3:
                            etiqueta = '<p><span class="label lbl-brown">'+d.estatus_actual+'</span></p>';
                        break;
                        case '4':
                        case 4:
                            etiqueta = '<p><span class="label lbl-brown">'+d.estatus_actual+'</span></p>';
                        break;
                        case '5':
                        case 5:
                            etiqueta = '<p><span class="label lbl-pink">'+d.estatus_actual+'</span></p>';
                        break;
                        case '6':
                        case 6:
                            etiqueta = '<p><span class="label lbl-azure">'+d.estatus_actual+'</span></p>';
                        break;
                        case '7':
                        case 7:
                            etiqueta = '<p><span class="label lbl-green">'+d.estatus_actual+'</span></p>';
                        break;
                        case '8':
                        case 8:
                            etiqueta = '<p><span class="label lbl-azure">'+d.estatus_actual+'</span></p>';
                        break;
                        case '9':
                        case 9:
                            etiqueta = '<p><span class="label lbl-brown">'+d.estatus_actual+'</span></p>';
                        break;
                        case '10':
                        case 10:
                            etiqueta = '<p><span class="label lbl-brown">'+d.estatus_actual+'</span></p>';
                        break;
                        case '11':
                        case 11:
                        if(d.pago_neodata < 1){
                            etiqueta = '<p><span class="label lbl-green">'+d.estatus_actual+'</span></p><p><span class="label lbl-oceanGreen">IMPORTACIÓN</span></p>';
                        }else{
                            etiqueta = '<p><span class="label lbl-green">'+d.estatus_actual+'</span></p>';
                        }
                        break;
                        case '88':
                        case 88:
                            etiqueta = '<p><span class="label lbl-pink">'+d.estatus_actual+'</span></p>';
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
            "orderable": false,
            "data": function( data ){
                var BtnStats;
                BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.nombreLote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_asimilados" data-toggle="tooltip" data-placement="top"  title="HISTORIAL DEL PAGO">' +'<i class="fas fa-info"></i></button>';
                return '<div class="d-flex justify-center">'+BtnStats+'</div>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            'searchable':false,
            'className': 'dt-body-center',
        }],
        ajax: {
            "url": general_base_url + "Comisiones/getDatosHistorialPagoM/" + proyecto + "/" + condominio,
            "type": "POST",
            cache: false,
            "data": function( d ){}
        },
        order: [[ 1, 'asc' ]]
    });

    $('#tabla_historialGral').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $("#tabla_historialGral tbody").on("click", ".consultar_logs_asimilados", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        $("#nameLote").html('');
        $("comments-list-asimilados").html('');

        changeSizeModal('modal-md');
        appendBodyModal(`<div class="modal-body">
                        <div role="tabpanel">
                            <ul class="nav" role="tablist">
                                <div id="nameLote"></div>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="changelogTab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                                    <ul class="timeline-3" id="comments-list-asimilados"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"><b>Cerrar</b></button>
                    </div>`);
        showModal();

        $("#nameLote").append('<p><h5>HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><b>' + v.comentario + '</b></a><br></div><div class="float-end text-right"><a>'+v.fecha_movimiento+'</a></div><div class="col-md-12"><p class="m-0"><small>MODIFICADO POR: </small><b> ' +v.nombre_usuario+ '</b></p></div><h6></h6></div></div></li>');
            });
        });
    });
}
