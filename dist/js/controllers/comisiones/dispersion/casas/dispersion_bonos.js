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
            success: function(data){
                if( data == 1 ){
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "La petición se ha realizado con éxito", "success");
                    $('#tabla_dispersion_casas').DataTable().ajax.reload();
                    $("#modalPrioridad").modal( 'hide' );
                    $('#btnSubmit').prop('disabled', false);
                    document.getElementById('btnSubmit').disabled = false;
                } else if (data == 2) {
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "Ya se dispersó por otro usuario", "warning");
                    $('#tabla_dispersar_comisiones').DataTable().ajax.reload();
                    $("#modal_NEODATA_Casas").modal( 'hide' );
                    $('#dispersar').prop('disabled', false);
                    document.getElementById('dispersar').disabled = false;
                }else{
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "No se pudo completar tu solicitud", "danger");
                    $('#dispersar').prop('disabled', false);
                    document.getElementById('dispersar').disabled = false;
                }
            },error: function(){
                $('#spiner-loader').addClass('hidden');
                alerts.showNotification("top", "right", "EL LOTE NO SE PUEDE DISPERSAR, INTÉNTALO MÁS TARDE", "warning");
            }
        });
    }
});














