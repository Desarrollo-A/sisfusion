$('#mes').change(function() {
    anio = $('#anio').val();
    mes = $('#mes').val();
    if(anio == ''){
        anio=0;
    }else{
        getAssimilatedCommissions(mes, anio);
    }
    $('#tabla_historialGral').removeClass('hide');
});

$('#anio').change(function() {
    for (let index = 0; index < meses.length; index++) {
        datos = datos + `<option value="${meses[index]['id']}">${meses[index]['mes']}</option>`;
        $('#mes').html(datos);
        $('#mes').selectpicker('refresh');
        }
    mes = $('#mes').val();
    if(mes == ''){
        mes=0;
    }
    anio = $('#anio').val();
    if (anio == '' || anio == null || anio == undefined) {
        anio = 0;
    }
});

let meses = [
    {
        id: '01',
        mes:'ENERO'
    },
    {
        id:'02',
        mes:'FEBRERO'
    },
    {
        id:'03',
        mes:'MARZO'
    },
    {
        id:'04',
        mes:'ABRIL'
    },
    {
        id:'05',
        mes:'MAYO'
    },
    {
        id:'06',
        mes:'JUNIO'
    },
    {
        id:'07',
        mes:'JULIO'
    },
    {
        id:'08',
        mes:'AGOSTO'
    },
    {
        id:'09',
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
let anios = [2019,2020,2021,2022,2023];
let datos = '';
let datosA = '';

for (let index = 0; index < anios.length; index++) {
    datosA = datosA + `<option value="${anios[index]}">${anios[index]}</option>`;
}
$('#anio').html(datosA);
$('#anio').selectpicker('refresh');


var tr;
var tabla_historialGral2;

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
$('#tabla_historialGral thead tr:eq(0) th').each(function(i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $('input', this).on('keyup change', function() {
        if (tabla_historialGral2.column(i).search() !== this.value) {
            tabla_historialGral2.column(i).search(this.value).draw();
        }
    });
});


function getAssimilatedCommissions(mes, anio) {
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
            title: 'REPORTE MKTD',
            exportOptions: {
                columns: [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14,15,16,17],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            }
        }],
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        pageLength: 10,
        fixedColumns: true,
        ordering: false,
        destroy: true,
        columns: [
            {
                data: function(d) {
                    var lblStats;
                    lblStats = '<p style="font-size: .8em"><b>' + d.idLote + '</b></p>';
                    return lblStats;
                }
            },
            {
                data: function(d) {
                    return '<p style="font-size: .8em">' + d.nombreResidencial + '</p>';
                }
            },
            {
                data: function(d) {
                    return '<p style="font-size: .8em">' + d.condominio + '</p>';
                }
            },
            {
                data: function(d) {
                    return '<p style="font-size: .8em"><b>' + d.nombreLote + '</b></p>';
                }
            },
            {
                data: function(d) {
                    let precio = 0;
                    if(d.totalNeto2 < 1 && d.precio == null){
                        precio = d.totalNeto2;
                        return '<p style="font-size: .8em">' + formatMoney(numberTwoDecimal(precio)) + '</p>';
                    }else if(d.totalNeto2 > 1 && d.precio == null){
                        precio = d.totalNeto2;
                        return '<p style="font-size: .8em">' + formatMoney(numberTwoDecimal(precio)) + '</p>';
                    }else if(d.totalNeto2 < 1 && d.precio != null){
                        precio = d.precio;
                        return '<p style="font-size: .8em">' + formatMoney(numberTwoDecimal(precio)) + '</p>';
                    }else if(d.totalNeto2 > 1 && d.precio > 0){
                        precio = d.totalNeto2;
                        return '<p style="font-size: .8em">' + formatMoney(numberTwoDecimal(precio)) + '</p>';
                    }
                
                }
            },
            {
                data: function(d) {
                    let apartado = d.fechaApartado.split('.')[0];
                    return '<p style="font-size: .8em">' + apartado + ' </p>';
                }
            },
            {
                data: function(d) {
                    return '<p style="font-size: .8em"><b>' + d.mes + '</b></p>';
                }
            },
            {
                data: function(d) {
                    return '<p style="font-size: .8em">' + d.cliente + '</p>';
                }
            },
            {
                data: function(d) {
                    return '<p style="font-size: .8em">' + d.plaza + '</p>';
                }
            },
            {
                data: function(d) {
                    return '<p style="font-size: .8em">' + d.asesor + '</p>';
                }
            }, {
                data: function(d) {
                    return '<p style="font-size: .8em">' + d.gerente + '</p>';
                }
            },
            {
                data: function(d) {
                    let compar ='';
                    if(d.idc_mktd != null){
                        return compar = '<span class="label lbl-cerulean">COMPARTIDA</span><br>'+'<p style="font-size: .8em"><b>' +d.sd1+' / '+d.sd2+ '</b></p>';
                    }
                    if (d.status == 0 || d.status == '0'){
                        return '<span class="label lbl-warning">CANCELADO</span>'+compar+'';
                    }
                    else{
                        return '<span class="label lbl-green">' + (d.estatus) + '</span>'+compar+'';
                    }
                }
            },
            {
                data: function(d) {
                    return '<p style="font-size: .8em">' + d.evidencia + '</p>';
                }
            },
            {
                data: function(d) {
                    if(d.idStatusContratacion>8){
                        if(d.comision_total==null)
                            return '<p style="font-size: .8em">' +formatMoney(d.comision_total) + '</p>';
                        
                        else
                            return '<p style="font-size: .8em">' +formatMoney(numberTwoDecimal(d.comision_total)) + '</p>';
                    }
                    else{
                        return '<p style="font-size: .8em"> - </p>';
                    }
                    
                
                }
            },
            {
                data: function(d) {
                    if(d.idStatusContratacion>8){
                        if(d.abono_dispersado == null) 
                            return '<p style="font-size: .8em">' + formatMoney(d.abono_dispersado) + '</p>';
                        else
                            return '<p style="font-size: .8em">' + formatMoney(numberTwoDecimal(d.abono_dispersado)) + '</p>';
                    }
                    else{
                        return '<p style="font-size: .8em"> - </p>';
                    }
                }
            },
            {
                data: function(d) {
                    if(d.idStatusContratacion>8){
                        if (d.abono_pagado == null)
                        return '<p style="font-size: .8em">' + formatMoney(d.abono_pagado) + '</p>';
                    else
                        return '<p style="font-size: .8em">' + formatMoney(numberTwoDecimal(d.abono_pagado)) + '</p>';
                    }
                    else{ 
                        return '<p style="font-size: .8em"> - </p>';
                    }
                }
            },
            {
                data: function(d) {
                    if(d.idStatusContratacion>8){
                        return '<p style="font-size: .8em">' + formatMoney(numberTwoDecimal(d.comision_total-d.abono_pagado)) + '</p>';
                    }
                    else{
                        return '<p style="font-size: .8em"> - </p>';
                    }
                }
            },
            {
                data: function(d) {
                    $label = '';
                    if(d.idStatusContratacion>8){
                    switch(d.bandera){
                        case 7:
                        case '7':
                        $label = '<span class="label lbl-violetDeep">LIQUIDADA</span>';
                        break;
                        case 1:
                        case 55:
                        case '1':
                        case '55':
                        case 0:
                        case '0':
                        $label = '<span class="label lbl-azure">ACTIVA</span>';
                        break;
                        default:
                        $label = '<span class="label lbl-gray">SIN DISPERSAR</span>';
                        break;
                    }
                }
                    else{
                        $label = '<span class="label lbl-orangeYellow">No aplica</span>';
                    }
                    return $label;
                    
                }
            },
            {
                orderable: false,
                data: function(d) {
                    var BtnStats;
                    let BtnPrecio = '';
                    let BtnStatsCOM = '';
                    if(d.idc_mktd == null)
                    {
                    BtnStatsCOM =  '<button data-toggle="tooltip"  data-placement="top" class="btn-data btn-green compartir_mktd" title="COMPARTIR" value="' + d.idLote +'"><i class="fas fa-share"></i></button>';
                    }
                    if (d.status == 0){
                        BtnStats = '<button data-toggle="tooltip"  data-placement="top" href="#" value="' + d.idLote + '" data-value="' + d.id_cliente + '"  data-code="' + d.cbbtton + '" ' + 'class="btn-data btn-orangeYellow bitacora_reporte_marketing" title="Ver detalles">' + '<i class="fas fa-eye"></i></button>';
                    }
                    else{
                        BtnStats = '<button data-toggle="tooltip"  data-placement="top" href="#" value="' + d.idLote + '" data-value="' + d.id_cliente + '"  data-code="' + d.cbbtton + '" ' + 'class="btn-data btn-orangeYellow bitacora_reporte_marketing" title="Ver detalles">' + '<i class="fas fa-eye"></i></button> <button href="#" value="' + d.idLote + '" data-value="' + d.id_cliente + '" data-code="' + d.cbbtton + '" ' + 'class="btn-data btn-blueMaderas add_reporte_marketing" title="Añadir comentarios">' + '<i class="fas fa-pen"></i></button>';
                        if (d.idStatusContratacion >= 1 && d.idStatusContratacion <= 8) {
                            BtnPrecio = '<button data-toggle="tooltip"  data-placement="top" href="#" value="' + d.idLote + '" data-value="' + d.precio + '"  data-code="' + d.nombreLote + '" ' + 'class="btn-data btn-sky reporte_marketing" title="Agregar precio">' + '<i class="fas fa-dollar-sign"></i></button>';
                        }
                    }
                    return "<div class='d-flex justify-center'>" + BtnStats + BtnPrecio + BtnStatsCOM +"</div>";
                }
            }
        ],
        ajax: {
            url: general_base_url+"Comisiones/getDatosCobranzaRanking/" + mes + "/" + anio,
            dataSrc:"" ,
            type: "POST",
            cache: false,
            data: function( d ){
            }
            },
        order: [
            [1, 'asc']
        ]
    });

    $("#tabla_historialGral tbody").on("click", ".bitacora_reporte_marketing", function() {
        lote = $(this).val();
        cliente = $(this).attr("data-value");
        $("#seeInformationMarketing").modal();
        $.getJSON("getDataMarketing/" + lote + "/" + cliente).done(function(data) {
            $.each(data, function(i, v) {
                $("#comments-list-asimilados").append('<li>\n' +
                '  <div class="container-fluid">\n' +
                '    <div class="row">\n' +
                '      <div class="col-md-6">\n' +
                '        <a><b>Comentario: ' +v.comentario.toUpperCase()+ '</b></a><br>\n' +
                '      </div>\n' +
                '      <div class="float-end text-right">\n' +
                '        <a>' + v.fecha_creacion.split(".")[0] + '</a>\n' +
                '      </div>\n' +
                '      <div class="col-md-12">\n' +
                '        <p class="m-0"><small>Usuario: </small><b>' + v.nombre + '</b></p>\n'+
                '        <p class="m-0"><small>Fecha de prospeccion: </small><b>' + v.prospeccion.split(" ")[0] + '</b></p>\n'+
                '      </div>\n' +
                '    <h6>\n' +
                '    </h6>\n' +
                '    </div>\n' +
                '  </div>\n' +
                '</li>');
            });
        });
    });

    $("#tabla_historialGral tbody").on("click", ".add_reporte_marketing", function() {
        var tr = $(this).closest('tr');
        var row = tabla_historialGral2.row(tr);
        lote = $(this).val();
        cliente = $(this).attr("data-value");
        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-footer").html("");
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>Añadir comentarios a <b>' + row.data().nombreLote + '</b><input type="hidden" name="lote" id="lote" value="' + lote + '"><input type="hidden" name="cliente" id="cliente" value="' + cliente + '">');
        $("#modal_nuevas .modal-body").append(
                                            '<div class="row">'+
                                                '<div class="col-md-12">'+
                                                    '<div class="form-group mt-0">'+
                                                        '<div>'+
                                                            '<label class="control-label ml-0">Fecha de prospección</label>'+
                                                        '</div>'+
                                                        '<div>'+
                                                            '<input class="form-control" type="date" id="fecha" name="fecha" value="">'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>');
        $("#modal_nuevas .modal-body").append(
                                            '<div class="row">'+
                                                '<div class="col-md-12">'+
                                                    '<div class="form-group mt-0">'+
                                                        '<label class="control-label ml-0">Comentarios adicionales</label>'+
                                                        '<textarea id="comentario" name="comentario" class="text-modal" rows="3" required></textarea>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>');
        $("#modal_nuevas .modal-footer").append(
                                            '<div class="row">'+
                                                '<div class="col-md-12">'+
                                                    '<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>'+
                                                    '<input type="submit" class="btn btn-primary" value="Aceptar">'+
                                                '</div>'+
                                            '</div>');
        $("#modal_nuevas").modal();
    });

    $("#tabla_historialGral tbody").on("click", ".reporte_marketing", function() {
        lote = $(this).val();
        precio = $(this).attr("data-value");
        nombre = $(this).attr("data-code");
        $("#modal_precio .modal-header").html("");
        $("#modal_precio .modal-body").html("");
        $("#modal_precio .modal-footer").html("");
        $("#modal_precio .modal-header").append(`<div class="row">
        <div class="col-md-12">
        <center><h6>Cambiar precio al lote <b>${nombre}</b></h6></center>
        </div>
        </div>`);
        $("#modal_precio .modal-body").append(`
        <div class="row">
            <div class="col-md-12">
                <div class="form-group mt-0">
                    <div>
                        <label class="control-label">Precio</label>
                    </div>
                    <div>
                        <input style="width:100%; height:50px !important"class="input-gral" type="number" id="precioL" name="precioL" value="${formatMoney(precio)}">
                        <input type="hidden" value="${lote}" readonly name="idLote" id="idLote">
                    </div>
                </div>
            </div>
        </div>`);
        $("#modal_precio .modal-footer").append(`
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                <input type="submit" class="btn btn-primary" value="Aceptar">
            </div>
        </div>`);
        $("#modal_precio").modal();
    });

    $("#tabla_historialGral tbody").off("click", ".compartir_mktd").on("click", ".compartir_mktd", function(){
        var lote =  $(this).val();
        $("#modal_mktd .modal-footer").html("");
        $("#modal_mktd .modal-footer").append(`
        <input type="hidden" value="${lote}" id="idlote" name="idlote">
        `);
        $("#modal_mktd .modal-footer").append('<br>'+
        '<div class="row pr-3">'+
            '<input type="button" class="btn btn-danger btn-simple"  data-dismiss="modal" value="CANCELAR">'+
            '<input id="guardar" type="submit" class="btn btn-primary" value="GUARDAR">'+
        '');
        $("#modal_mktd").modal();
    });

    $("#form_mktd").submit( function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
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
                            tabla_historialGral2.ajax.reload();
                            alerts.showNotification("top", "right", "Registro agregado con exito.", "success");
                    }
                    else if(data == 3){
                        $("#modal_mktd").modal('toggle');
                            tabla_historialGral2.ajax.reload();
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
                type: 'POST', // For jQuery < 1.9
                success: function(data) {
                    if (true) {
                        $("#modal_nuevas").modal('toggle');
                        alerts.showNotification("top", "right", "Se guardó tu información correctamente", "success");
                        setTimeout(function() {
                            tabla_historialGral2.ajax.reload();
                            // tabla_otras2.ajax.reload();
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
                    type: 'POST', // For jQuery < 1.9
                    success: function(data) {
                        if (1) {
                            $("#modal_precio").modal('toggle');
                            alerts.showNotification("top", "right", "Precio del lote actualizado", "success");
                            setTimeout(function() {
                                tabla_historialGral2.ajax.reload();
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

$('body').tooltip({
    selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
    trigger: 'hover',
    container: 'body'
}).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
    $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
});

function cleanCommentsData() {
    var myCommentsList = document.getElementById('comments-list-asimilados');
    myCommentsList.innerHTML = '';
}