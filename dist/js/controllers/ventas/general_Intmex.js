var tr;
var tabla_solicitadas ;
let titulos = [];

$('#comisiones_solicitadas thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function() {
        if (tabla_solicitadas.column(i).search() !== this.value) {
            tabla_solicitadas.column(i).search(this.value).draw();
            var total = 0;
            var index = tabla_solicitadas.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_solicitadas.rows(index).data();
            $.each(data, function(i, v) {
                total += parseFloat(v.impuesto);
            });
            document.getElementById("totalDisponible").textContent = formatMoney(numberTwoDecimal(total));
        }
    });
});

$(document).ready( function(){
    $('#comisiones_solicitadas').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(numberTwoDecimal(total));
        document.getElementById("totalDisponible").textContent = to;
    });

    $("#comisiones_solicitadas").prop("hidden", false);
    tabla_solicitadas = $("#comisiones_solicitadas").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE GENERAL PAGOS INTERNOMEX',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17],
                format: {
                    header:  function (d,columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
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
                return '<p class="m-0">'+d.id_pago_i+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.proyecto+'</p>';
            }
        },{
            "data": function( d ){
                return '<p class="m-0">'+d.condominio+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.lote+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.referencia+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(numberTwoDecimal(d.precio_lote))+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.empresa+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+(numberTwoDecimal(d.valimpuesto))+'%</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.dcto)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.impuesto)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.usuario+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.puesto+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.nombre+'</b></i></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.rfc+'</b></i></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><i> '+d.forma_pago+'</i></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><i> '+d.fecha_pago_intmex.split('.')[0]+'</i></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><i> '+d.estatus_usuario+'</i></p>';
            }
        },
        {
            "orderable": false,
            "data": function( data ){
                var BtnStats;
                BtnStats = '<div class="d-flex justify-center"><button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs" title="Detalles">' +'<i class="fas fa-info"></i></button></div>';
                return BtnStats;
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            searchable: false,
            className: 'dt-body-center',
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            "url": general_base_url + "Comisiones/getDatosGralInternomex/",
            "type": "POST",
            cache: false,
            "data": function( d ){
                    }
        }
    });

    $('#comisiones_solicitadas').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });
    
    $("#comisiones_solicitadas tbody").on("click", ".consultar_logs", function(e){
        $("#historial_pago").html('');
        $("#nombreLote").html('');
        $('#spiner-loader').removeClass('hide');
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");

        changeSizeModal('modal-md');
        appendBodyModal(`<div class="modal-body">
                    <div role="tabpanel">
                        <ul>
                            <div id="nombreLote"></div>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="changelogTab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                                <ul class="timeline-3" id="historial_pago"></ul>
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

        $("#nombreLote").append('<p><h5">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#historial_pago").append('<li>\n' +
                '  <div class="container-fluid">\n' +
                '    <div class="row">\n' +
                '      <div class="col-md-6">\n' +
                '        <a><b> ' +v.comentario.toUpperCase()+ '</b></a><br>\n' +
                '      </div>\n' +
                '      <div class="float-end text-right">\n' +
                '        <a>' + v.fecha_movimiento.split(".")[0] + '</a>\n' +
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
});

$(window).resize(function(){
    tabla_solicitadas.columns.adjust();
});

