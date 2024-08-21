const excluir_column = ['MÁS', ''];
let columnas_datatable = {};
var fechaGlobal,dataUsuarios = [];
var fechaInicioCorteGlobal, fechaFinCorteGlobal, horaFinCorteGlobal,datosFechaCorte = [];


var totaPen = 0;
var tr;
$(document).ready(function () {
    $.post(general_base_url + "Casas_comisiones/getUsuariosBonos", function (data) {
        dataUsuarios = data;
    }, 'json');
});

var titulos_intxt = [];
$('#tabla_dispersar_comisiones thead tr:eq(0) th').each(function (i) {
    $(this).css('text-align', 'center');
    var title = $(this).text();
    titulos_intxt.push(title);
    if(i != 0){
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_dispersar_comisiones').DataTable().column(i).search() !== this.value ) {
                $('#tabla_dispersar_comisiones').DataTable().column(i).search(this.value).draw();
            }
            var index = $('#tabla_dispersar_comisiones').DataTable().rows({
            selected: true,
            search: 'applied'
            }).indexes();
            var data = $('#tabla_dispersar_comisiones').DataTable().rows(index).data();
        });
    }else 
    $(this).html(`<input id="all" type="checkbox" onchange="selectAll(this)" data-toggle="tooltip_nuevas"  data-placement="top" title="SELECCIONAR"/>`);

});



$("#tabla_dispersar_comisiones").ready(function () {    
    tabla_nuevas = $("#tabla_dispersar_comisiones").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: `<i class="fa fa-file-excel-o" aria-hidden="true"></i>`,
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COMISIONES NUEVAS',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11],
                format: {
                    header: function (d, columnIdx) {
                        return '  ';
                    }
                }
            },
        },  {
            text: '<i class="fa fa-paper-plane"></i> ASIGNAR PAGOS',
            className: '',
            action: function () {
            
                    if ($('input[name="idT[]"]:checked').length > 0) {

                        var data = tabla_nuevas.row().data();

                        //$('#spiner-loader').removeClass('hide');
                        var idcomision = $(tabla_nuevas.$('input[name="idT[]"]:checked')).map(function () {
                            return this.value;
                        }).get();
                        $("#modalAsignacion .modal-header").html("");
                        $("#modalAsignacion .modal-body").html("");
                        
                        $("#modalAsignacion .modal-body").append(`
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 overflow-hidden" id="div_proyectos">
                                <label class="control-label">Usuario</label>
                                    <select class="selectpicker select-gral m-0" name="usuarioAsignar" 
                                            id="usuarioAsignar" data-style="btn" data-show-subtext="true" 
                                            title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required>
                                    </select>
                            </div>
                            <input type="hidden" value="${idcomision}" id="idPagos" name="idPagos">`);

                            var len = dataUsuarios.length;
                            for (var i = 0; i < len; i++) {
                                var id = dataUsuarios[i]['id_usuario'];
                                var name = dataUsuarios[i]['nombre'];
                                $("#usuarioAsignar").append($('<option>').val(id).text(name.toUpperCase()));
                            }
                            $("#usuarioAsignar").selectpicker('refresh');
                        $('#modalAsignacion').modal();

                    }
                
            },
            attr: {
                class: 'btn btn-azure',
                style: 'position:relative; float:right'
            }
        }],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        pagingType: "full_numbers",
        fixedHeader: true,
        destroy: true,
        ordering: false,
        columns: [
        {},
        {
            "data": function (d) {
                return '<p class="m-0">' + d.id_pago_i + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + d.proyecto + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0"><b>' + d.lote + '</b></p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">$' + formatMoney(d.precio_lote) + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">$' + formatMoney(d.comision_total) + ' </p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">$' + formatMoney(d.pago_neodata) + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">$' + formatMoney(d.pago_cliente) + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0"><b>$' + formatMoney(d.impuesto) + '</b></p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0"><b>' + d.porcentaje_decimal + '%</b> de ' + d.porcentaje_abono + '% GENERAL </p>';
            }
        },
        {
            "data": function( d ){
                var lblPenalizacion = '';

                if (d.penalizacion == 1){
                    lblPenalizacion ='<p class="m-0" title="PENALIZACIÓN + 90 DÍAS"><span class="label lbl-vividOrange"> + 90 DÍAS</span></p>';
                }

                if(d.bonificacion >= 1){
                    p1 = '<p class="m-0" title="LOTE CON BONIFICACIÓN EN NEODATA"><span class="label lbl-darkPink"">BON. $ '+formatMoney(d.bonificacion)+'</span></p>';
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
            "data": function (d) {
                
                        return `<p class="mb-1">
                                    <span class="label lbl-dark-blue">
                                        DOCUMENTACIÓN FALTANTE
                                    </span>
                                </p>
                                <p>
                                    <span class="label lbl-green">
                                        REVISAR CON RH
                                    </span>
                                </p>`.split("\n").join("").split("  ").join("");
                
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                let botones = ``;
                let proceso = 0;

                return `<div class="d-flex justify-center">
                            <button href="#" 
                                    value="${data.id_pago_i}"
                                    data-value="${data.lote}"
                                    data-monto="${data.impuesto}"
                                    data-idComision="${data.id_comision}"
                                    data-idLote="${data.idLote}"
                                    data-totalNeto2="${data.precio_lote}"
                                    class="btn-data btn-blueMaderas dispersarPago" 
                                    title="Dispersar pogo"
                                    data-toggle="tooltip_nuevas" 
                                    data-placement="top">
                                <i class="fas fa-hand-holding-usd"></i>
                            </button>
                        </div>`;
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
            searchable: false,
            className: 'dt-body-center',
            render: function (d, type, full, meta) {
                return `<input type="checkbox" name="idT[]" style="width:20px;height:20px;"  value="${full.id_pago_i}">`;                
            },
        }],
        ajax: {
            "url": general_base_url + "Casas_comisiones/getPagosBonos/"+1,
            "type": "POST",
            cache: false,
            "data": function (d) { }
        },
        initComplete: function () {
            $('[data-toggle="tooltip_nuevas"]').tooltip("destroy");
            $('[data-toggle="tooltip_nuevas"]').tooltip({ trigger: "hover" });
        }
    });


    $('#tabla_dispersar_comisiones').on('click', 'input', function () {
        tr = $(this).closest('tr');
        var row = tabla_nuevas.row(tr).data();
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



    $("#tabla_dispersar_comisiones tbody").on("click", ".dispersarPago", function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    const idPagoI = $(this).val(), nombreLote = $(this).attr("data-value"), monto = $(this).attr("data-monto"), idLote = $(this).attr("data-idLote"), idComision =  $(this).attr("data-idComision"),
    totalNeto2 = $(this).attr("data-totalNeto2");
        
    $("#modalDispersion .modal-header").html("");
    $("#modalDispersion .modal-body").html("");

    $("#modalDispersion .modal-header").append(`
        <div class="row">
            <div class="col-md-4">
                <h5>Monto a dispersar: <b>${formatMoney(monto)}</b> </h5>
            </div>
            <div class="col-md-4">
                <h5>Pago del lote: <b>${nombreLote}</b> </h5>
            </div>
            <div class="col-md-4">
                <h5>Id del pago: <b>${idPagoI}</b> </h5>
            </div>
        </div>    
    `);
    $("#modalDispersion .modal-body").append(`
        <select class="selectpicker select-gral m-0" name="usuarioBono" 
                id="usuarioBono" data-style="btn" data-show-subtext="true" 
                title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required>
        </select>

        <div class="form-group">
            <label for="monto_dispersar">Asignar monto:</label>
            <input type="number" step="any" class="form-control input-gral" onkeyup="handleKeyUp(event)" id="monto_dispersar" required placeholder="$" name="monto_dispersar">
            <input type="hidden" class="form-control" value="${monto}" id="montoPago" name="montoPago" />
            <input type="hidden" class="form-control" value="${idLote}" id="idLote" name="idLote" />
            <input type="hidden" class="form-control" value="${idComision}" id="idComision" name="idComision" />
            <input type="hidden" class="form-control" value="${idPagoI}" id="id_pago_i" name="id_pago_i" />
            <input type="hidden" class="form-control" value="${totalNeto2}" id="totalNeto2" name="totalNeto2" />
        </div>
        <div class="col-xs-12 col-sm-12 col-sm-12 col-md-12 col-lg-12 mt-1">
            <p>Nota: El monto restante se asignará al usuario que no fue seleccionado.</p>
        </div>
    `);

    var len = dataUsuarios.length;
    for (var i = 0; i < len; i++) {
        var id = dataUsuarios[i]['id_usuario'];
        var name = dataUsuarios[i]['nombre'];
        $("#usuarioBono").append($('<option>').val(id).text(name.toUpperCase()));
    }
    $("#usuarioBono").selectpicker('refresh');


        $("#modalDispersion").modal();

    });
});
//FIN TABLA NUEVA
function selectAll(e) {
    tota2 = 0;
    $(tabla_nuevas.$('input[type="checkbox"]')).each(function (i, v) {
        if (!$(this).prop("checked")) {
            $(this).prop("checked", true);
            tota2 += parseFloat(tabla_nuevas.row($(this).closest('tr')).data().pago_cliente);
        } else {
            $(this).prop("checked", false);
        }
        $("#totpagarPen").html(formatMoney(tota2));
    });
}

function handleKeyUp(event) {
    let valorIngresado = parseFloat(event.target.value), valorActual = parseFloat($("#montoPago").val());
    if(valorIngresado > valorActual){
        $('#btnSubmit').prop('disabled', true);
    }else{
        $('#btnSubmit').prop('disabled', false);
    }
}

$("#formDispersion").submit( function(e) {
    $('#btnSubmit').prop('disabled', true);
    document.getElementById('btnSubmit').disabled = true;
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#spiner-loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: general_base_url + 'Casas_comisiones/AsignarBono',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(respuesta){
                console.log(respuesta);
                if( respuesta.resultado == true){
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "La petición se ha realizado con éxito", "success");
                    $('#tabla_dispersar_comisiones').DataTable().ajax.reload();
                    $("#modalDispersion").modal( 'hide' );
                    $('#btnSubmit').prop('disabled', false);
                    document.getElementById('btnSubmit').disabled = false;
                }else{
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "No se pudo completar tu solicitud", "danger");
                    $('#btnSubmit').prop('disabled', false);
                    document.getElementById('btnSubmit').disabled = false;
                }
            },error: function(){
                $('#spiner-loader').addClass('hidden');
                alerts.showNotification("top", "right", "EL LOTE NO SE PUEDE DISPERSAR, INTÉNTALO MÁS TARDE", "warning");
            }
        });
    }
});



$("#formAsignacion").submit( function(e) {
    alert(1);

    $('#btnsubA').prop('disabled', true);
    document.getElementById('btnsubA').disabled = true;
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        alert();
        $('#spiner-loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: general_base_url + 'Casas_comisiones/asigancionMasivaBonos',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(respuesta){
                console.log(respuesta);
                if( respuesta.resultado == true){
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "La petición se ha realizado con éxito", "success");
                    $('#tabla_dispersar_comisiones').DataTable().ajax.reload();
                    $("#modalAsignacion").modal( 'hide' );
                    $('#btnsubA').prop('disabled', false);
                    document.getElementById('btnsubA').disabled = false;
                }else{
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "No se pudo completar tu solicitud", "danger");
                    $('#btnsubA').prop('disabled', false);
                    document.getElementById('btnsubA').disabled = false;
                }
            },error: function(){
                $('#spiner-loader').addClass('hidden');
                alerts.showNotification("top", "right", "EL LOTE NO SE PUEDE DISPERSAR, INTÉNTALO MÁS TARDE", "warning");
            }
        });
    }
});










