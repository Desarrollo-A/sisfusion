$(document).ready(function(){
    $("#tabla_historialGral").addClass('hide');
})

$('#mes').change(function(ruta) {
    anio = $('#anio').val();
    mes = $('#mes').val();
    if(anio == ''){
        anio=0;
    }else{
        getAssimilatedCommissions(mes, anio);
    }
});

$('#anio').change(function(ruta) {
    mes = $('#mes').val();
    if(mes == ''){
        mes=0;
    }
    anio = $('#anio').val();
    if (anio == '' || anio == null || anio == undefined) {
        anio = 0;
    }
    $("#tabla_historialGral").removeClass('hide');
    getAssimilatedCommissions(mes, anio);
});

var tr;
var tabla_historialGral2 ;
var totaPen = 0;

let titulos = [];
$('#tabla_historialGral thead tr:eq(0) th').each( function (i) {
    if(i != 0 ){
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" placeholder="'+title+'" title="'+title+'"/>');
        $('input', this).on('keyup change', function() {
            if (tabla_historialGral2.column(i).search() !== this.value) {
                tabla_historialGral2.column(i).search(this.value).draw();

                var total = 0;
                var index = tabla_historialGral2.rows({ selected: true, search: 'applied' }).indexes();
                var data = tabla_historialGral2.rows(index).data();
                $.each(data, function(i, v) {
                    total += parseFloat(v.pago_cliente);
                });
                var to1 = formatMoney(total);
                document.getElementById("myText_pagado").textContent = to1;
            }
        });
    } 
    else{
        $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
    }
});

function getAssimilatedCommissions(sede){
    $('#tabla_historialGral').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.pago_cliente);
        });
        var to = formatMoney(total);
        document.getElementById("myText_pagado").textContent = to;
    });


    $("#tabla_historialGral").prop("hidden", false);
    tabla_historialGral2 = $("#tabla_historialGral").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'PAGADO MARKETING DIGITAL',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx-1] + ' ';
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
                lblStats ='<p class="m-0">'+d.id_pago_i+'</p>';
                return lblStats;
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.idLote+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.nombreLote+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.plaza+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.comision_total)+' </p>';
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
                }else{
                    return '<p class="m-0">'+formatMoney(d.restante)+'</p>';
                }
            }
        }, 
        {
            "data": function( d ){
                var etiqueta;
                etiqueta = '<p class="m-0">'+d.fechaApartado+'</p>';
                return etiqueta;
            }
        },
        {
            "data": function( d ){
                var etiqueta;
                etiqueta = '<p class="m-0">'+d.fecha_pago_intmex+'</p>';
                return etiqueta;
            }
        },
        {
            "data": function( d ){
                var etiqueta;
                etiqueta = '<p class="m-0">'+d.aply_pago_intmex+'</p>';
                return etiqueta;
            }
        },
        {
            "data": function( d ){
                var etiqueta;
                etiqueta = '<p class="m-0"><span class="label lbl-green">'+d.estatus_actual+'</span></p>';
                return etiqueta;
            }
        },
        { 
            "orderable": false,
            "data": function( data ){
                var BtnStats;
                BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.nombreLote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_asimilados" data-toggle="tooltip" data-placement="top" title="DETALLES">' +'<i class="fas fa-info"></i></button>';
                return '<div class="d-flex justify-center">' + BtnStats + '</div>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
            'searchable': false,
            'className': 'dt-body-center',
            select: { style: 'os', selector: 'td:first-child' },
        }],
        ajax: {
            "url": general_base_url + "Comisiones/getDatosHistorialPagado/" + anio + "/" + mes,
            "type": "POST",
            cache: false,
            "data": function(d) {},
        },
        order: [
            [1, 'asc']
        ]
    });

    $("#tabla_historialGral tbody").on("click", ".consultar_logs_asimilados", function(e){
        $("#nameLote").html('');
        $("#comments-list-asimilados").html('');
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");

        changeSizeModal("modal-md");
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
                $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><small>MODIFICADO POR: </small><b>'+v.nombre_usuario+' </b></a><br></div><div class="float-end text-right"><a> '+v.fecha_movimiento+' </a></div><div class="col-md-12"><p class="m-0"><small>COMENTARIOS: </small><b>'+v.comentario+'</b></p></div><h6></h6></div></div></li>');
            });
        });
    });
}

$('#tabla_historialGral').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});

$(window).resize(function() {
    tabla_historialGral2.columns.adjust();
});
