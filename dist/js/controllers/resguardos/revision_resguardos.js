
var totalLeon = 0;
var totalQro = 0;
var totalSlp = 0;
var totalMerida = 0;
var totalCdmx = 0;
var totalCancun = 0;
var tr;
var tabla_resguardo2 ;
var totaPen = 0;
let titulos = [];

// ------------Funcion de botones anteriores de comisiones de resguardo------------------

// $(document).ready(function() {
//     $("#tabla_resguardo").prop("hidden", true);
//     $.post(general_base_url + "Comisiones/getResguardo", function (data) {
//         var len = data.length;
//         for (var i = 0; i < len; i++) {
//             var id = data[i]['id_usuario'];
//             var name = data[i]['nombre'];
//             if(id_usuario_general == 1875 ){
//                 if(id == 2){
//                     $("#directivo_resguardo").append($('<option>').val(id).text(name.toUpperCase()));
//                 }
//             }
//             else{
//                 $("#directivo_resguardo").append($('<option>').val(id).text(name.toUpperCase()));
//             }
//         }
//         $("#directivo_resguardo").selectpicker('refresh');
//     }, 'json');
// });


// $('#directivo_resguardo').change(function(ruta){
//     residencial = $('#directivo_resguardo').val();
//     $("#catalogo_resguardo").empty().selectpicker('refresh');
//     $.ajax({
//         url: general_base_url + 'Contratacion/lista_proyecto/'+residencial,
//         type: 'post',
//         dataType: 'json',
//         success:function(response){
//             var len = response.length;
//             for( var i = 0; i<len; i++){
//                 var id = response[i]['idResidencial'];
//                 var name = response[i]['descripcion'];
//                 $("#catalogo_resguardo").append($('<option>').val(id).text(name));
//             }
//             $("#catalogo_resguardo").selectpicker('refresh');
//         }
//     });
// });

//--------------Funcionalidad de botones de comisiones de resguardo actual------------------


$(document).ready(function () { 
    $("#tabla_resguardo, #tabla_resguardo_casas").prop("hidden", true);
    $.post(general_base_url + "Comisiones/getResguardo", function (data) {

    let catalogo = data.catalogo,
    proyecto = data.proyecto, 
    directivos = data.directivos;

        for (var i = 0; i < catalogo.length; i++) {
            var id = catalogo[i]['id_opcion'];
            var anio = catalogo[i]['nombre'];
            $(`#anio, #anio_casas`).append($('<option>').val(anio).text(anio));
        }
        $("#anio, #anio_casas").selectpicker('refresh');

        $(`#catalogo_resguardo, #catalogo_resguardo_casas`).append($('<option>').val(0).text('SIN PROYECTO'));
        for (var i1 = 0; i1 < proyecto.length; i1++) {
            var id = proyecto[i1]['idResidencial'];
            $(`#catalogo_resguardo, #catalogo_resguardo_casas`).append($('<option>').val(id).text(proyecto[i1]['descripcion']));
        }
        $("#catalogo_resguardo, #catalogo_resguardo_casas").selectpicker('refresh');
        
        for (var i2 = 0; i2 < directivos.length; i2++) {
            var id = directivos[i2]['id_usuario'];
            var name = directivos[i2]['nombre'];
            directivos[i2]['tipo'] == 3 ? $(`#directivo_resguardo_casas`).append($('<option>').val(id).text(name)) : $(`#directivo_resguardo`).append($('<option>').val(id).text(name));
            directivos[i2]['tipo_2'] == 3 ? $(`#directivo_resguardo_casas`).append($('<option>').val(id).text(name)) :'';
        }$("#directivo_resguardo, #directivo_resguardo_casas").selectpicker('refresh');
        
    }, 'json');
    let meses = [
        {
            id: '1',
            mes:'ENERO'
        },
        {
            id:'2',
            mes:'FEBRERO'
        },
        {
            id:'3',
            mes:'MARZO'
        },
        {
            id:'4',
            mes:'ABRIL'
        },
        {
            id:'5',
            mes:'MAYO'
        },
        {
            id:'6',
            mes:'JUNIO'
        },
        {
            id:'7',
            mes:'JULIO'
        },
        {
            id:'8',
            mes:'AGOSTO'
        },
        {
            id:'9',
            mes:'SEPTIEMBRE'
        },
        {
            id:'10',
            mes:'OCTUBRE'
        },
        {
            id:'11',
            mes:'NOVIEMBRE'
        },
        {
            id:'12',
            mes:'DICIEMBRE'
        }
    ];
    let datos = '';

        for (let index = 0; index < meses.length; index++) {
        datos = datos + `<option value="${meses[index]['id']}">${meses[index]['mes']}</option>`;
        $('#mes, #mes_casas').html(datos);
        $('#mes, #mes_casas').selectpicker('refresh');
    }

});

$('#directivo_resguardo, #anio, #mes').change(function(ruta){
    directivo = $('#directivo_resguardo').val();
    proyecto = $('#catalogo_resguardo').val();
    anio = $('#anio').val();
    mes = $('#mes').val();

    if(directivo == '' || directivo == null || directivo == undefined || anio == '' || anio == null || anio == undefined
       || mes == '' || mes == null || mes== undefined
     ){
        return false;
    }else{
    getAssimilatedCommissions(directivo, proyecto, anio, mes);
    }
});

$('#catalogo_resguardo').change(function(ruta){
    directivo = $('#directivo_resguardo').val();
    proyecto = $('#catalogo_resguardo').val();
    anio = $('#anio').val();
    mes = $('#mes').val();
    if(directivo == '' || directivo == null || directivo == undefined || anio == '' || anio == null || anio == undefined
        || mes == '' || mes == null || mes== undefined
      ){
         return false;
     }else{
     getAssimilatedCommissions(directivo, proyecto, anio, mes);
     }
});

$('#tabla_resguardo thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function() {
        if (tabla_resguardo2.column(i).search() !== this.value) {
            tabla_resguardo2.column(i).search(this.value).draw();
            var total = 0;
            var index = tabla_resguardo2.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_resguardo2.rows(index).data();
        }
    });
});

function getAssimilatedCommissions(directivo, proyecto, anio, mes){
    $('#tabla_resguardo').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.pago_cliente);
        });
        var to = formatMoney(total);
        document.getElementById("totpagarremanente").textContent = to;
    });

    $("#tabla_resguardo").prop("hidden", false);
    tabla_resguardo2 = $("#tabla_resguardo").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        bAutoWidth: true, 
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'RESGUARDOS_COMISIONES',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,15,16],
                format: {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
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
                return '<p class="m-0">'+d.empresa+'</p>';
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
                    "width": "5%",
                    "data": function( d ){
                        var BtnStats1;
                        BtnStats1 =  '<p class="m-0">'+d.fecha_creacion+'</p>';
                        return BtnStats1;
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
            targets:   0,
            searchable:false,
            className: 'dt-body-center',
        }],
        ajax: {
            url: general_base_url + "Comisiones/getDatosResguardoContraloria/",
            type: "POST",
            cache: false,
            data: {
                directivo:directivo,
                proyecto:proyecto,
                mes:mes,
                anio:anio
            }
        },
    });

    $('#tabla_resguardo').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });

    $("#tabla_resguardo tbody").on("click", ".consultarDetalleDelPago", function(e){
        $("#spiner-loader").removeClass('hide');
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        $("#nombreLote").html('');
        $("#comments-list-remanente").html('');

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
                                        <ul class="timeline-3" id="comments-list-remanente"></ul>
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
                $("#spiner-loader").addClass('hide');
                $("#comments-list-remanente").append('<li><div class="container-fluid"><div class="row"><div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><a><b>' + v.nombre_usuario + '</b></a><br></div> <div class="float-end text-right"><a>' + v.fecha_movimiento + '</a></div><div class="col-md-12"><p class="m-0"><b> ' + v.comentario + '</b></p></div></div></div></li>');
            });
        });
    });

    $('#tabla_resguardo').on('click', 'input', function() {
        tr = $(this).closest('tr');
        var row = tabla_resguardo2.row(tr).data();
        if (row.pa == 0) {
            row.pa = row.impuesto;
            totaPen += parseFloat(row.pa);
            tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
        }
        else {
            totaPen -= parseFloat(row.pa);
            row.pa = 0;
        }
        $("#totpagarPen").html(formatMoney(totaPen));
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });

    $(window).resize(function(){
        tabla_resguardo2.columns.adjust();
    });
}