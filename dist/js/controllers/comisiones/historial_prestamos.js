
var tr;
var tabla_descuentos ;
var totaPen = 0;
let titulos = [];

$(document).ready(function(){
    $("#tabla_descuentos").addClass('hide');
});

$('#mes').change(function(){
    anio = $('#anio').val();
    mes = $('#mes').val();
    
    if(mes == '' || anio == ''){
    }else{
        fillTable(anio, mes);
    }
});

$('#anio').change(function() {
    anio = $('#anio').val();
    mes = $('#mes').val();
    if(anio == '' || mes == ''){
    }else{
        $("#tabla_descuentos").removeClass('hide');
        fillTable(anio, mes);
    }
    
});

$('#tabla_descuentos thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function() {
        if (tabla_descuentos.column(i).search() !== this.value) {
            tabla_descuentos.column(i).search(this.value).draw();
            var total = 0;
            var index = tabla_descuentos.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_descuentos.rows(index).data();
            $.each(data, function(i, v) {
                total += parseFloat(v.abonado);
            });
            document.getElementById("pagar_descuentos").textContent = formatMoney(total);
        }
    });
});

function fillTable(anio, mes){

    $('#tabla_descuentos').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.abonado);
        });
        var to = formatMoney(total);
        document.getElementById("pagar_descuentos").textContent = to;
    });

    $("#tabla_descuentos").prop("hidden", false);
    tabla_descuentos = $("#tabla_descuentos").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'Reporte General Prestámos',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11,13,14,15],
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
        columns: [
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
                return '<p class="m-0">'+d.id_pago_i+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.id_prestamo+'</p>';
            }
        },
        {
            "data": function( d ){
                    return '<p class="m-0"><b>'+d.nombre_completo+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.puesto+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.nombre_sede+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.monto_prestado)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+formatMoney(d.abonado)+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.num_pagos+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.fecha_creacion+'</p>';
            }
        },
        {
            data: function( d){         
                const letras = d.comentario.split(" ");
                if(letras.length <= 4)
                {

                    return '<p class="m-0">'+d.comentario+'</p>';
                }else{
                    return `<div class="muestratexto${d.id_pago_i}" id="muestratexto${d.id_pago_i}">
                            <p class="m-0">${letras[0]} ${letras[1]} ${letras[2]} ${letras[3]}....</p> 
                            <a href='#' data-toggle="collapse" data-target="#collapseOne${d.id_pago_i}" 
                                onclick="esconder(${d.id_pago_i})" aria-expanded="true" aria-controls="collapseOne${d.id_pago_i}">
                                <span class="lbl-blueMaderas"><B>Ver más</B></span> 
                            </a>
                        </div>
                        <div id="collapseOne${d.id_pago_i}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                ${d.comentario}</p> 
                                <a href='#' data-toggle="collapse" data-target="#collapseOne${d.id_pago_i}" 
                                    onclick="mostrar(${d.id_pago_i})" aria-expanded="true" aria-controls="collapseOne${d.id_pago_i}">
                                    <span class="lbl-blueMaderas"><B>Ver menos</B></span> 
                                </a>
                            </div>
                        </div>`;
                }
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.comentario+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<span class="label lbl-green" >PAGADO</span>';
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
            targets: [13], visible: false,
            searchable: false,
        }],
        
        ajax: {
            url: `${general_base_url}Comisiones/getPrestamosTable/${mes}/${anio}`,
            type: "POST",
            cache: false,
            data: function( d ){
            }
        },
        initComplete: function(){
            $("#spiner-loader").addClass('hide');
        }
    });

    $('#tabla_descuentos').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });

    $("#tabla_descuentos tbody").on("click", ".consultarDetalleDelPago", function(e){
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
                                        <ul class="timeline-3" id="comentariosDescuentos"></ul>
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
                $("#comentariosDescuentos").append('<li><div class="container-fluid"><div class="row"><div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><a><b>' + v.nombre_usuario + '</b></a><br></div> <div class="float-end text-right"><a>' + v.fecha_movimiento + '</a></div><div class="col-md-12"><p class="m-0"><b> ' + v.comentario + '</b></p></div></div></div></li>');
            });
        });
    });
}

$(window).resize(function(){
    tabla_descuentos.columns.adjust();
});

function esconder(id){
    $('#muestratexto'+id).addClass('hide');
    
}

function mostrar(id){
    $('#muestratexto'+id).removeClass('hide'); 
}

        

