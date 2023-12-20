$(document).ready(function () {
 
    let meses = [
        {id:'0',mes:'TODOS'},
        {id:'01',mes:'Enero'},
        {id:'02',mes:'Febrero'},
        {id:'03',mes:'Marzo'},
        {id:'04',mes:'Abril'},
        {id:'05',mes:'Mayo'},
        {id:'06',mes:'Junio'},
        {id:'07',mes:'Julio'},
        {id:'08',mes:'Agosto'},
        {id:'09',mes:'Septiembre'},
        {id:'10',mes:'Octubre'},
        {id:'11',mes:'Noviembre'},
        {id:'12',mes:'Diciembre'}
    ];

    let anios = [2019,2020,2021,2022,2023,2024];
    let datos = '';
    let datosA = '';

    for (let index = 0; index < meses.length; index++) {
        datos = datos + `<option value="${meses[index]['id']}">${meses[index]['mes']}</option>`;
        $('#mes').html(datos);
        $('#mes').selectpicker('refresh');
    }

    for (let index = 0; index < anios.length; index++) {
        datosA = datosA + `<option value="${anios[index]}">${anios[index]}</option>`;
    }
    $('#anio').html(datosA);
    $('#anio').selectpicker('refresh');
    $('#anio').change(function () {
        for (let index = 0; index < meses.length; index++) {
        datos = datos + `<option value="${meses[index]['id']}">${meses[index]['mes']}</option>`;
        }
    });

    $('#mes').change(function() {
        anio = $('#anio').val();
        mes = $('#mes').val();
        if(anio == ''){
            anio=0;
        }else{
            loadTable(mes, anio);
        }
        $('#tabla-historial').removeClass('hide');
    });
    
    $('#anio').change(function() {
        mes = $('#mes').val();
        if(mes == ''){
            mes=0;
        }
        anio = $('#anio').val();
        if (anio == '' || anio == null || anio == undefined) {
            anio = 0;
        }
        loadTable(mes, anio);
        $('#tabla-historial').removeClass('hide');
    });
    
    $('body').tooltip({
        selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
        trigger: 'hover',
        container: 'body'
    }).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
        $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
    }); 
    
});

let titulos_intxt = [];
$('#tabla-historial thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#tabla-historial').DataTable().column(i).search() !== this.value ) {
            $('#tabla-historial').DataTable().column(i).search(this.value).draw();
        }
    });
});

function loadTable(mes, anio) {
    $('#tabla-historial').ready(function () {
        $('#tabla-historial').on('xhr.dt', function (e, settings, json, xhr) {
            var general = 0;
            $.each(json.data, function (i, v) {
                general += parseFloat(v.abono_neodata);
            });
            var totalFinal = formatMoney(general);
            document.getElementById("totalGeneral").textContent = totalFinal;
        });

        tablaGeneral = $('#tabla-historial').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons:[{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true" title="DESCARGAR ARCHIVO DE EXCEL"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'DESCARGAR ARCHIVO DE EXCEL',
            title: 'Reporte Descuentos Universidad',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns:[
                {"data": function (d) {
                    return `<p style="font-size: 1em;">${d.id_pago_i}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em;">${d.nombreLote}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em;">${d.empresa}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em;">${d.id_usuario}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em;">${d.user_names}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em;">${d.puesto}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em;">${d.sede}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em">${formatMoney(d.abono_neodata)}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em;">${d.creado}</p>`;
                }},
                {"data": function (d) {
                    return '<p style="font-size: 1em">' + d.fecha_descuento + '</p>';
                }},
                {"data": function (d) {
                    base = `<button href="#" value=${d.id_pago_i} data-value=${d.nombreLote} data-nameuser=${d.user_names} data-puesto=${d.puesto} data-monto=${d.abono_neodata} data-code=${d.cbbtton} class="btn btn-round btn-fab btn-fab-mini btn-data btn-yellow btn_devolucion" data-toggle="tooltip" data-placement="top" title="APLICAR DEVOLUCIÓN"><i class="fas fa-rotate-left"></i></button>`;
                    return '<div class="d-flex justify-center">'+base+'</div>';
                }}],
            
                "ajax": {
                "url": `getDatosHistorialUM/`+anio + "/" + mes,
                "type": "GET",
                cache: false,
                "data": function (d) {}
            }
        });

        $("#tabla-historial tbody").on("click", ".btn_devolucion", function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            $('#mensajeConfirmacion').html('');
            $('#comentarioDevolucion').html('');
            $('#montosDescuento').html('');
            $('#pagoDevolver').val(0);

            id_pago_i = $(this).val();
            nombreUsuario = $(this).attr("data-nameuser");
            rolUsuario = $(this).attr("data-puesto");
            totalDescuento = $(this).attr("data-monto");
            nombreLote = $(this).attr("data-value");
            
            $('#mensajeConfirmacion').append('<p>¿Está seguro de devolver el pago al '+rolUsuario+' <b>'+ nombreUsuario+'</b>?</p>');
            $('#montosDescuento').append('<p>Total a devolver: <b>'+formatMoney(totalDescuento)+'</b></p><p>Lote correspondiente: <b>'+nombreLote+'</b></p>');
            $('#pagoDevolver').val(id_pago_i);
            $("#modalDevolucionUM").modal();
        });
});

$("#form_devolucion").submit(function (e) {
    e.preventDefault();
}).validate({
    submitHandler: function (form) {

        var data = new FormData($(form)[0]);
        $.ajax({
            url: general_base_url+"Universidad/CancelarDescuento",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST',
            success: function (data) {

                if (data) {
                    $("#modalDevolucionUM").modal('toggle');
                    alerts.showNotification("top", "right", "Se detuvo el descuento exitosamente", "success");
                    setTimeout(function () {
                        tablaGeneral.ajax.reload();
                    }, 3000);
                } else {
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                }
            }, error: function () {
                alerts.showNotification("top", "right", "ERROR EN EL SISTEMA", "danger");
            }
        });
    }
});
}
