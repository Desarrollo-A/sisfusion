
var totalLeon = 0;
var totalQro = 0;
var totalSlp = 0;
var totalMerida = 0;
var totalCdmx = 0;
var totalCancun = 0;
var tr;
var tabla_historialGral;
var totaPen = 0;

$(document).ready(function() {
    $("#tabla_historialGral").addClass('hide');
});

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
    getAssimilatedCommissions(mes, anio);
    $("#tabla_historialGral").removeClass('hide');
    $("#spiner-loader").removeClass('hide');
});

$.post(general_base_url + "Comisiones/listSedes", function (data) {
    var len = data.length;
    for (var i = 0; i < len -1; i++) {
        var id = data[i]['id_sede'];
        var name = data[i]['nombre'];
        $("#plaza1").append($('<option>').val(id).text(name.toUpperCase()));
        $("#plaza2").append($('<option>').val(id).text(name.toUpperCase()));
    }
    $("#plaza1").selectpicker('refresh');
    $("#plaza2").selectpicker('refresh');
}, 'json');

let titulos = [];
$('#tabla_historialGral thead tr:eq(0) th').each( function (i) {
    if(i != 0){
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function() {
            if (tabla_historialGral.column(i).search() !== this.value) {
                tabla_historialGral.column(i).search(this.value).draw();
                var index = tabla_historialGral.rows({ selected: true, search: 'applied' }).indexes();
                var data = tabla_historialGral.rows(index).data();
                $.each(data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
            }
        });
    }
});

function getAssimilatedCommissions(mes, anio) {
    $("#tabla_historialGral").prop("hidden", false);
    tabla_historialGral = $("#tabla_historialGral").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COBRANZA APARTADOS',
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14,15,16,17,18, 19],
                format: {
                    header: function (d, columnIndex) {
                        return ' '+titulos[columnIndex-1] +' ';
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
            "className": 'details-control',
            "orderable": false,
            "data" : null,
            "defaultContent": '<i class="material-icons" style="color:#003D82;" title="Click para más detalles">play_circle_filled</i>'
        },
        {
            "data": function(d) {
                var lblStats;
                lblStats = '<p class="m-0"><b>' + d.idLote + '</b></p>';
                return lblStats;
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.nombreResidencial + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.condominio + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + d.nombreLote + '</b></p>';
            }
        },
        {
            "data": function(d) {
                let precio = 0;
                if(d.totalNeto2 < 1 && d.precio == null){
                    if(d.totalNeto == '0.00' || d.totalNeto == null)
                        return '<span style="color: #960034">' + d.total_sindesc + '</span>';
                    else
                        return '<span style="font-weight: 700">' + formatMoney(d.totalNeto2) + '</span>';
                }else if(d.totalNeto2 > 1 && d.precio == null){
                    precio = d.totalNeto2;
                    return '<p class="m-0">' + formatMoney(precio) + '</p>';
                }else if(d.totalNeto2 < 1 && d.precio != null){
                    precio = d.precio;
                    return '<p class="m-0">' + formatMoney(precio) + '</p>';
                }else if(d.totalNeto2 > 1 && d.precio > 0){
                    precio = d.totalNeto2;
                    return '<p class="m-0">' + formatMoney(precio) + '</p>';
                }
                
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.fechaApartado + ' </p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + d.mes + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.cliente + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.plaza + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.asesor + '</p>';
            }
        }, {
            "data": function(d) {
                return '<p class="m-0">' + d.gerente + '</p>';
            }
        },
        {
            "data": function(d) {
                let compar ='';
                if(d.idc_mktd != null)
                {
                    compar = '<span class="label label-info">COMPARTIDA</span><br>'+'<p><b>' +d.sd1+' / '+d.sd2+ '</b></p>';
                }
                if (d.status == 0 || d.status == '0'){
                    return '<p class="m-0" style="color:crimson;"><b>CANCELADO</b></p><center>'+compar+'<center>';
                }
                else{
                    return '<p class="m-0"><b>' + (d.estatus).toUpperCase() + '</b></p><center>'+compar+'<center>';
                }
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.evidencia + '</p>';
            }
        },
        {
            "data": function(d) {
                if(d.idStatusContratacion>8){
                    return '<p class="m-0">' +formatMoney(d.comision_total) + '</p>';
                }
                else{
                    return '<p class="m-0"> - </p>';
                }
                
            }
        },
        {
            "data": function(d) {
                if(d.idStatusContratacion>8){
                    return '<p class="m-0">' + formatMoney(d.abono_dispersado) + '</p>';
                }
                else{
                    return '<p class="m-0"> - </p>';
                }
            }
        },
        {
            "data": function(d) {
                if(d.idStatusContratacion>8){
                    return '<p class="m-0">' + formatMoney(d.abono_pagado) + '</p>';
                }
                else{ 
                    return '<p class="m-0"> - </p>';
                }
            }
        },
        {
            "data": function(d) {
                if(d.idStatusContratacion>8){
                    return '<p class="m-0">' + formatMoney(d.comision_total-d.abono_pagado) + '</p>';
                }
                else{
                    return '<p class="m-0"> - </p>';
                }
            }
        },
        {
            "data": function(d) {
                $label = '';

                if(d.idStatusContratacion > 8){
                switch(d.bandera){
                    case 7:
                    case '7':
                    $label = '<p><b>LIQUIDADA</b></p>';
                    break;
                    case 1:
                    case 55:
                    case '1':
                    case '55':
                    case 0:
                    case '0':
                    $label = '<p style="color: green;"><b>ACTIVA</b></p>';
                    break;
                    default:
                    $label = '<p style="color: dodgerblue;"><b>SIN DISPERSAR</b></p>';
                    break;
                }
            }
                else{
                    $label = '<p style="color: orange;"><b>NA</b></p>';
                }
                return $label;
            }
        },
        {
            "data": function(d) {
                if (d.descuento_mdb == 1) 
                    return d.lugar_prospeccion + ' Martha Debayle';
                else
                    return d.lugar_prospeccion;
            }
        },
        {
            "orderable": false,
            "data": function(d) {
                var BtnStats;
                let BtnPrecio = '';
                let BtnStatsCOM = '';
                if(d.idc_mktd == null){
                    BtnStatsCOM =  '<button class="btn-data btn-violetChin compartir_mktd" title="COMPARTIR" value="' + d.idLote +'"><i class="material-icons">group_add</i></button>';
                }
                if (d.status == 0){
                    BtnStats = '<button href="#" value="' + d.idLote + '" data-value="' + d.id_cliente + '"  data-code="' + d.cbbtton + '" ' + 'class="btn-data btn-blueMaderas bitacora_reporte_marketing" title="Ver detalles">' + '<i class="fas fa-file-alt"></i></button>';
                }
                else{
                    BtnStats = '<button href="#" value="' + d.idLote + '" data-value="' + d.id_cliente + '"  data-code="' + d.cbbtton + '" ' + 'class="btn-data btn-orangeYellow bitacora_reporte_marketing" title="Ver detalles">' + '<i class="fas fa-file-alt"></i> <button href="#" value="' + d.idLote + '" data-value="' + d.id_cliente + '" data-code="' + d.cbbtton + '" ' + 'class="btn-data btn-blueMaderas add_reporte_marketing" title="Añadir mas detalles">' + '<i class="fas fa-pencil-alt"></i></button>';
                    if (d.idStatusContratacion >= 1 && d.idStatusContratacion <= 8) {
                        BtnPrecio = '<button href="#" value="' + d.idLote + '" data-value="' + d.precio + '"  data-code="' + d.nombreLote + '" ' + 'class="btn-data btn-sky reporte_marketing" title="Agregar precio">' + '<i class="fas fa-dollar-sign"></i></button>';
                    }
                }
                return '<div class="d-flex justify-center">'+BtnStats + BtnPrecio + BtnStatsCOM+'</div>';
            }
        }],
        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        "ajax": {
            "url": general_base_url + "Comisiones/getDatosCobranzaReporte/" + mes + "/" + anio,
            "dataSrc": "",
            "type": "POST",
            cache: false,
            "data": function( d ){}
            },
            initComplete(){
                $("#spiner-loader").addClass('hide');
            },
        "order": [
            [1, 'asc']
        ]
    });

    $('#tabla_historialGral').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });

    $("#tabla_historialGral tbody").on("click", ".bitacora_reporte_marketing", function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        lote = $(this).val();
        cliente = $(this).attr("data-value");

        changeSizeModal("modal-md");
        appendBodyModal(`<div class="modal-body">
            <div role="tabpanel">
                <ul class="nav" role="tablist">
                    <h5><b>BITÁCORA DE CAMBIOS</b></h5>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="changelogTab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-plain">
                                    <div class="card-content">
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

        $.getJSON("getDataMarketing/" + lote + "/" + cliente).done(function(data) {

            if(data == ''){
                $("#comments-list-asimilados").append('<p>Sin datos a mostrar</p>');
            }
            $.each(data, function(i, v) {                
                $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><small>COMENTARIO: </small><b>' + v.comentario + '</b></a><br></div><div class="float-end text-right"><a>'+v.fecha_creacion+'</a></div><div class="col-md-12"><p class="m-0"><small>MODIFICADO POR: </small><b> ' + v.nombre + '</b></p></div><h6></h6></div></div></li>');
            });
        });
    });

    $("#tabla_historialGral tbody").on("click", ".add_reporte_marketing", function() {
        var tr = $(this).closest('tr');
        var row = tabla_historialGral.row(tr);
        lote = $(this).val();
        cliente = $(this).attr("data-value");

        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-footer").html("");
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>Añadir comentarios a <b>' + row.data().nombreLote + '</b><input type="hidden" name="lote" id="lote" value="' + lote + '"><input type="hidden" name="cliente" id="cliente" value="' + cliente + '">');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-12"><div class="form-group"><label class="control-label">Fecha prospección</label><input class="form-control" type="date" id="fecha" name="fecha" value=""></div></div></div>');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-12"><div class="form-group"><label class="control-label">Comentarios adicionales</label><textarea id="comentario" name="comentario" class="text-modal" rows="3" required></textarea></div></div></div>');
        $("#modal_nuevas .modal-footer").append('<div class="row"><div class="col-md-12"><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button><button type="submit" class="btn btn-primary">Aceptar</button></div></div>');
        $("#modal_nuevas").modal();
    });

    $("#tabla_historialGral tbody").on("click", ".reporte_marketing", function() {
        lote = $(this).val();
        precio = $(this).attr("data-value");
        nombre = $(this).attr("data-code");
        $("#modal_precio .modal-header").html("");
        $("#modal_precio .modal-body").html("");
        $("#modal_precio .modal-footer").html("");
        $("#modal_precio .modal-header").append(`<div class="row"><div class="col-md-12"><center><h6>Cambiar precio al lote <b>${nombre}</b></h6></center></div></div>`);
        $("#modal_precio .modal-body").append(`<div class="row"><div class="col-md-12"><div class="form-group"><label class="label">Precio</label><input class="form-control" type="number" id="precioL" name="precioL" value="${formatMoney(precio)}"><input type="hidden" value="${lote}" readonly name="idLote" id="idLote"></div></div></div>`);
        $("#modal_precio .modal-footer").append('<div class="row"><div class="col-md-12"><input type="submit" class="btn btn-success" value="Aceptar"><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></div></div>');
        $("#modal_precio").modal();
    });

    $("#tabla_historialGral tbody").on("click", ".compartir_mktd", function(){
        var lote =  $(this).val();
        
        $("#modal_mktd .modal-footer").html("");
        $("#modal_mktd .modal-footer").append(`<input type="hidden" value="${lote}" id="idlote" name="idlote">`);
        $("#modal_mktd .modal-footer").append('<br><div class="row d-flex justify-end"><div class="col-md-6"><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button><button type="submit" class="btn btn-primary">GUARDAR</button></div>');
        $("#modal_mktd").modal();
    });

    $("#form_mktd").submit( function(e) {
        e.preventDefault();
        var plaza1 = $('#plaza1').val();
        var plaza2=$('#plaza2').val();
        var idLote=$('#idlote').val();

        if( plaza1 == plaza2){
            alerts.showNotification("top", "right", "Las plazas seleccionadas son iguales.", "warning");
        }
        else{
            $.ajax({
                type: "POST",
                url: general_base_url + "Comisiones/MKTD_compartida",
                data: {idLote: idLote, plaza1: plaza1,plaza2:plaza2},
                dataType: 'json',
                success: function(data){
                    if(data == 1){
                        $("#modal_mktd").modal('toggle');
                            tabla_historialGral.ajax.reload();
                            alerts.showNotification("top", "right", "Registro agregado con exito.", "success");
                    }
                    else if(data == 3){
                        $("#modal_mktd").modal('toggle');
                        tabla_historialGral.ajax.reload();
                        alerts.showNotification("top", "right", "No se puede aplicar el ajuste porque ya se hicieron pagos individuales anteriormente.", "warning");
                    }
                },error: function( ){
                    alerts.showNotification("top", "right", "Las plazas seleccionadas son iguales.", "danger");
                }
            });
        }
    })

    $("#form_aplicar").submit(function(e) {
        e.preventDefault();
    }).validate({
        submitHandler: function(form) {
            var data = new FormData($(form)[0]);
            $.ajax({
                url: general_base_url + 'Comisiones/agregar_comentarios',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST',
                success: function(data) {
                    if (true) {
                        $("#modal_nuevas").modal('toggle');
                        alerts.showNotification("top", "right", "Se guardó tu información correctamente", "success");
                        setTimeout(function() {
                            tabla_historialGral.ajax.reload();
                        }, 3000);
                    } else {
                        alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                    }
                },
                error: function() {
                    alert("ERROR EN EL SISTEMA");
                }
            });
        }
    });

    function replaceAll( text, busca, reemplaza ){
        while (text.toString().indexOf(busca) != -1)
            text = text.toString().replace(busca,reemplaza);
        return text;
    }

    $("#form_precio").submit(function(e) {
        e.preventDefault();
    }).validate({
        submitHandler: function(form) {
            let precioformato = $('#precioL').val();
            let precio = replaceAll(precioformato,',','');
            if(!isNaN(precio)){
                var data = new FormData($(form)[0]);
                $.ajax({
                    url: general_base_url + 'Comisiones/SavePrecioLoteMKTD',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST',
                    success: function(data) {
                        if (1) {
                            $("#modal_precio").modal('toggle');
                            alerts.showNotification("top", "right", "Precio del lote actualizado", "success");
                            setTimeout(function() {
                                tabla_historialGral.ajax.reload();
                            }, 100);
                        } else {
                            alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                        }
                    },
                    error: function() {
                        alert("ERROR EN EL SISTEMA");
                    }
                });
            }
            else{
                alerts.showNotification("top", "right", "Número invalido", "danger");
            }
        }
    });
}

$(window).resize(function() {
    tabla_historialGral.columns.adjust();
});