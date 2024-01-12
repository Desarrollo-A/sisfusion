var totalLeon = 0;
var totalQro = 0;
var totalSlp = 0;
var totalMerida = 0;
var totalCdmx = 0;
var totalCancun = 0;
var tr;
var tabla_asimilados2 ;
var totaPen = 0;
let titulos = [];

$(document).ready(function() {
    $("#tabla_asimilados").prop("hidden", true);
    $("#spiner-loader").removeClass('hide');
    $.post(`${general_base_url}Comisiones/lista_roles`, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            var catalog = data[i]['id_catalogo'];
            $("#comisiones_nuevas").append($('<option>').val(id).attr('data-catalogo', catalog).text(name.toUpperCase()));
        }
        $("#comisiones_nuevas").selectpicker('refresh');
        $("#spiner-loader").addClass('hide');
    }, 'json');
});

$('#comisiones_nuevas').change(function(ruta){
    id_rol = $('#comisiones_nuevas').val();
    id_catalogo = $('#comisiones_nuevas>option:selected').attr("data-catalogo");
    $("#usuario_nuevas").empty().selectpicker('refresh');
    $("#spiner-loader").removeClass('hide');
    $.ajax({
        url: `${general_base_url}Comisiones/usuarios_nuevas`,
        type: 'post',
        data: {'id_rol': id_rol, 'id_catalogo': id_catalogo},
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++){
                var id = response[i]['id_usuario'];
                var name = response[i]['nombre'];
                $("#usuario_nuevas").append($('<option>').val(id).text(name));
            }
            $("#usuario_nuevas").selectpicker('refresh');
            $("#spiner-loader").addClass('hide');
        }
    });
});

$('#usuario_nuevas').change(function(ruta){
    $("#spiner-loader").removeClass('hide');
    id_rol = $('#comisiones_nuevas').val();
    id_usuario = $('#usuario_nuevas').val();
    if(id_usuario == '' || id_usuario == null || id_usuario == undefined)
        id_usuario = 0;
    fillTable(id_rol, id_usuario);
});

$('#tabla_asimilados thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function() {
        if (tabla_asimilados2.column(i).search() !== this.value) {
            tabla_asimilados2.column(i).search(this.value).draw();
            var total = 0;
            var index = tabla_asimilados2.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_asimilados2.rows(index).data();
            $.each(data, function(i, v) {
                total += parseFloat(v.pago_cliente);
            });
            document.getElementById("pagar_asimilados").textContent = formatMoney(total);
        }
    });
});

function fillTable(id_rol, id_usuario){

    $('#tabla_asimilados').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.pago_cliente);
        });
        var to = formatMoney(total);
        document.getElementById("pagar_asimilados").textContent = to;
    });

    $("#tabla_asimilados").prop("hidden", false);
    tabla_asimilados2 = $("#tabla_asimilados").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'PAGOS NUEVOS',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                format: {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
            fixedHeader: true,
            language: {
                url: `${general_base_url}static/spanishLoader_v2.json`,
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
                return '<p class="m-0">'+d.puesto+'</p>';
            }
        },
        {
            "data": function( d ){
                var lblPenalizacion = '';

                if (d.penalizacion == 1){
                    lblPenalizacion ='<p class="m-0" title="PENALIZACIÓN + 90 DÍAS"><span class="label lbl-vividOrange"> + 90 DÍAS</span></p>';
                }

                if(d.bonificacion >= 1){
                    p1 = '<p class="m-0" title="LOTE CON BONIFICACIÓN EN NEODATA"><span class="label lbl-darkPink"">BON. '+formatMoney(d.bonificacion)+'</span></p>';
                }
                else{
                    p1 = '';
                }

                if(d.lugar_prospeccion == 0){
                    p2 = '<p class="m-0" title="LOTE CON CANCELACIÓN DE CONTRATO"><span class="label lbl-warning">RECISIÓN</span></p>';
                }
                else{
                    p2 = '';
                }

                if(d.id_cliente_reubicacion_2 != 0 ) {
                    p3 = `<p class="${d.colorProcesoCl}">${d.procesoCl}</p>`;
                }else{
                    p3 = '';
                }

                return p1 + p2 + lblPenalizacion + p3;
            }
        },
        {
            "data": function( d ){
                var etiqueta;

                    if(d.pago_neodata < 1){
                        etiqueta = '<p class="m-1">'+'<span class="label" style="background:'+d.color+'18; color:'+d.color+'">'+d.estatus_actual+'</span>'+'</p>'+'<p class="m-1">'+'<span class="label lbl-green">IMPORTACIÓN</span></p>';
                    }else{
                        etiqueta = '<p class="m-0"><span class="label" style="background:'+d.color+'18; color: '+d.color+'; ">'+d.estatus_actual+'</span></p>';
                    }

                return etiqueta;
            }
        },
        { 
            "orderable": false,
            "data": function( data ){
                var BtnStats;
                BtnStats = `<button href="#" value="${data.id_pago_i}" data-value='"${data.nombreLote}"' data-code="${data.cbbtton}" class="btn-data btn-blueMaderas consultarDetalleDelPago" title="DETALLES" data-toggle="tooltip" data-placement="top"><i class="fas fa-info"></i></button>`;
                return '<div class="d-flex justify-center">'+BtnStats+'</div>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
            searchable:false,
            className: 'dt-body-center',
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            url: `${general_base_url}Comisiones/getDatosNuevasMontos/${id_usuario}`,
            type: "POST",
            cache: false,
            data: function( d ){
            }
        },
        initComplete: function(){
            $("#spiner-loader").addClass('hide');
        }
    });

    $('#tabla_asimilados').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });

    $("#tabla_asimilados tbody").on("click", ".consultarDetalleDelPago", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");

        changeSizeModal("modal-md");
        appendBodyModal(`<div class="modal-body">
            <div role="tabpanel">
                <ul class="nav" role="tablist">
                    <div id="nombreLote"></div>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="changelogTab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-plain">
                                    <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                        <ul class="timeline-3" id="comentariosAsimilados"></ul>
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

        $("#nombreLote").append('<p><h5>HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comentariosAsimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><a><b>' + v.nombre_usuario + '</b></a><br></div> <div class="float-end text-right"><a>' + v.fecha_movimiento + '</a></div><div class="col-md-12"><p class="m-0"><b> ' + v.comentario + '</b></p></div></div></div></li>');
            });
        });
    });
}

$(window).resize(function(){
    tabla_asimilados2.columns.adjust();
});