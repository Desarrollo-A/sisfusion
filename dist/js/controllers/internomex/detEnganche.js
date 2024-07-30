var cont_eng = 0;
var objEnganche = { enganchesGuardados: [], nuevoEnganche: [] };

$(document).ready(function () {
    $('#spiner-loader').removeClass('hide');
    $.post(`${general_base_url}Contratacion/lista_proyecto`, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#proyecto").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
});

$('#proyecto').change(function () {
    let index_proyecto = $(this).val();
    $("#condominio").html("");
    $("#table_lotes_enganche").removeClass('hide');
    $('#spiner-loader').removeClass('hide');
    $(document).ready(function () {
        $.post(`${general_base_url}Contratacion/lista_condominio/${index_proyecto}`, function (data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['idCondominio'];
                var name = data[i]['nombre'];
                $("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#condominio").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }, 'json');
    });
    fillTable(index_proyecto, 0);
});

$('#condominio').change(function () {
    // $('#spiner-loader').removeClass('hide');
    let index_proyecto = $("#proyecto").val();
    let index_condominio = $(this).val();
    fillTable(index_proyecto, index_condominio);
    // $('#spiner-loader').addClass('hide');
});

$(document).ready(function () {
    $("input:file").on("change", function () {
        var target = $(this);
        var relatedTarget = target.siblings(".file-name");
        var fileName = target[0].files[0].name;
        relatedTarget.val(fileName);
    });
    setInitialDates();
    if (id_rol_global == 31)
        $('.generate').trigger('click');
    else
        $('.find-results').trigger('click');
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({ locale: 'es' });
});

sp = {
    initFormExtendedDatetimepickers: function () {
        $('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove',
                inline: true
            }
        });
    }
}

function setInitialDates() {
    var beginDt = moment().startOf('year').format('DD/MM/YYYY');
    var endDt = moment().format('DD/MM/YYYY');
    $('.beginDate').val(beginDt);
    $('.endDate').val(endDt);
}

function formatDate(date) {
    var dateParts = date.split("/");
    var d = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]), month = '' + (d.getMonth() + 1), day = '' + d.getDate(), year = d.getFullYear();
    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;
    return [year, month, day].join('-');
}

let titulos_encabezado = [];
let num_colum_encabezado = [];
const excluir_column = ['ACCIONES', 'MÁS'];

$("#table_lotes_enganche").ready(function () {
    $('#table_lotes_enganche thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        if (!excluir_column.includes(title) && title !== '') {
            titulos_encabezado.push(title);
            num_colum_encabezado.push(titulos_encabezado.length);
        }
        if (title !== '') {
            let readOnly = excluir_column.includes(title) ? 'readOnly' : '';
            let width = title == 'MÁS' ? 'width: 37px;' : (title == 'ACCIONES' ? 'width: 57px;' : '');
            $(this).html(`<input type="text" style="${width}" class="textoshead " data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}" ${readOnly}/>`);
            $('input', this).on('keyup change', function () {
                if (tabla_valores_cliente.column(i).search() !== this.value) {
                    tabla_valores_cliente.column(i).search(this.value).draw();
                }
            });
        }
    });
});

function fillTable(index_proyecto, index_condominio) {
    tabla_valores_cliente = $("#table_lotes_enganche").DataTable({
        width: '100%',
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Registro de clientes',
            title: 'Registro de clientes',
            exportOptions: {
                columns: num_colum_encabezado,
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos_encabezado[columnIdx - 1] + ' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: true,
        pageLength: 10,
        bAutoWidth: true,
        bLengthChange: false,
        scrollX: true,
        bInfo: true,
        searching: true,
        ordering: false,
        fixedColumns: true,
        destroy: true,
        columns: [
            { data: 'nombreResidencial' },
            { data: 'nombreCondominio' },
            { data: 'nombreLote' },
            { data: 'idLote' },
            {
                data: function (d) {
                    let nombreCliente = (d.nombreCliente == null || d.nombreCliente == "  ") ? 'SIN ESPECIFICAR' : d.nombreCliente;
                    return `${nombreCliente}`;
                }
            },
            {
                data: function (d) {
                    let fechaApartado = (d.fechaApartado == null || d.fechaApartado == "  ") ? 'SIN ESPECIFICAR' : d.fechaApartado;
                    return `${fechaApartado}`;
                }
            },
            { data: 'nombreAsesor' },
            {
                data: function (d) {
                    let tipoVenta = (d.tipoVenta == null) ? 'SIN REGISTRO' : d.tipoVenta;
                    return `<span class='label lbl-green'>${tipoVenta}</span>`;
                }
            },
            {
                data: function (d) {
                    let ubicacion = (d.ubicacion == null) ? 'SIN REGISTRO' : d.ubicacion;
                    return `<span class='label lbl-violetBoots'>${ubicacion}</span>`;
                }
            },
            {
                data: function (d) {
                    let engancheContraloria = (d.engancheContraloria == null || d.engancheContraloria == "  ") ? 'SIN ESPECIFICAR' : d.engancheContraloria;
                    return `${engancheContraloria}`;
                }
            },
            {
                data: function (d) {
                    let engancheAdministracion = (d.engancheAdministracion == null || d.engancheAdministracion == "  ") ? 'SIN ESPECIFICAR' : d.engancheAdministracion;
                    return `${engancheAdministracion}`;
                }
            },
            {
                data: function (d) {
                    let informacionEnganche = (d.registroEstatus == 0) ? 'SIN INFORMACIÓN' : "CON INFORMACIÓN";
                    let classLabl = (d.registroEstatus == 0) ? 'lbl-warning' : "lbl-green";
                    return `<span class='label ${classLabl}'>${informacionEnganche}</span>`;

                }
            },
            {
                data: function (d) {
                    return `<button class="btn-data btn-blueMaderas cop" data-toggle="tooltip" data-placement="top" title= "DETALLE ENGANCHE" data-idLote="${d.idLote}" data-idEnganche="${d.idEnganche}" data-idCliente="${d.idCliente}"><i class="material-icons">attach_money</i></button>`;
                }
            }
        ],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: `${general_base_url}Internomex/getRegistroLotesEng`,
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {
                "index_proyecto": index_proyecto,
                "index_condominio": index_condominio
            }
        },
        order: [
            [1, 'asc']
        ],
    });

    $('#table_lotes_enganche').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

}

$(window).resize(function () {
    tabla_valores_cliente.columns.adjust();
});

var id_lote_global = 0;
$(document).on('click', '.cop', function (e) {
    e.preventDefault();
    var $itself = $(this);
    var id_lote = $itself.attr('data-idLote');
    var id_enganche = $itself.attr('data-idEnganche');
    var id_cliente= $itself.attr('data-idCliente');
    id_lote_global = id_lote;
    $('#verDetalles').modal('show');
    $.ajax({
        type: "POST",
        url: `${general_base_url}Internomex/catalogosEnganche`,
        dataType: "json",
        data: { idLote: id_lote },
    })
        .done(function (dto) {
            if (dto != []) {
                try {
                    if (dto.status == 1) {
                        $('#txtIdLote').val(id_lote);
                        $('#idEnganche').val(id_enganche);
                        $('#idCliente').val(id_cliente);
                        generarInputCatalogos(dto);

                        $('#verDetalles').modal('show');
                    }
                    else
                        alerts.showNotification("top", "right", "Oops, algo salió mal al consultar los datos.", "danger");
                } catch (error) {
                    if (error instanceof SyntaxError) {
                    } else {
                        throw error; // si es otro error, que lo siga lanzando
                    }
                }
            }
            else
                alerts.showNotification("top", "right", "Oops, algo salió mal al consultar los datos.", "danger");
            return dto;
        })
        .fail(function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal al consultar los catálogos de enganche.", "danger");
        });
});

function cerrarModalDetEnganche() {
    $("#cmbFormaPago").html("");
    $("#cmbInsMonetario").html("");
    $("#cmbMonedaDiv").html("");
    $("#cdpplote").html("");
    $("#cmbPlanPago").html("");
    $("#txtIdLote").attr("data-idDetEnganche", "0");
    $("#cmbFormaPago").selectpicker('refresh');
    $("#cmbInsMonetario").selectpicker('refresh');
    $("#cmbMonedaDiv").selectpicker('refresh');
    $("#cdpplote").selectpicker('refresh');
    $("#cmbPlanPago").selectpicker('refresh');
    $('#verDetalles').modal('hide');
    $("#pila-carrito").html("");
    objEnganche = { enganchesGuardados: [], nuevoEnganche: [] };
    cont_eng = 0;
}

function generarInputCatalogos(dto) {
    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    });
    dto.dtoCatalogos.map((catalogoOpciones) => {
        if (catalogoOpciones.id_catalogo == 110) // FROMA DE PAGO
            $("#cmbFormaPago").append(`<option value="${catalogoOpciones.id_opcion}" data-FormaPgo="${catalogoOpciones.nombre}">${catalogoOpciones.nombre}</option>`);
        if (catalogoOpciones.id_catalogo == 111) // INSTRUMENTO MONETARIO
            $("#cmbInsMonetario").append(`<option value="${catalogoOpciones.id_opcion}" data-FormaPgo="${catalogoOpciones.nombre}">${catalogoOpciones.nombre}</option>`);
        if (catalogoOpciones.id_catalogo == 112) // MONEDA O DIVISA
            $("#cmbMonedaDiv").append(`<option value="${catalogoOpciones.id_opcion}" data-FormaPgo="${catalogoOpciones.nombre}">${catalogoOpciones.nombre}</option>`);
        if (catalogoOpciones.id_catalogo == 119) // CONCEPTO DEL PRIMER PAGO
            $("#cdpplote").append(`<option value="${catalogoOpciones.id_opcion}" data-FormaPgo="${catalogoOpciones.nombre}">${catalogoOpciones.nombre}</option>`);
        if (catalogoOpciones.id_catalogo == 131) // Plan de pago
            $("#cmbPlanPago").append(`<option value="${catalogoOpciones.id_opcion}" data-FormaPgo="${catalogoOpciones.nombre}">${catalogoOpciones.nombre}</option>`);
    });


    if(dto.dtoEnganches.length>0){
        $("#cmbMonedaDiv").val(dto.dtoEnganches[0].monedaDivisa);
        $("#cmbInsMonetario").val(dto.dtoEnganches[0].instrumentoMonetario);
        $("#cmbFormaPago").val(dto.dtoEnganches[0].formaPago);
        $("#cdpplote").val(dto.dtoEnganches[0].conceptoPago);
        $("#cmbPlanPago").val(dto.dtoEnganches[0].planPago);
        let fechaBase = dto.dtoEnganches[0].fechaPago.split("-");
        $('#txtFechaPago').val(fechaBase[2]+'/'+fechaBase[1]+'/'+fechaBase[0]);
        // Create our number formatter.
        $("#montoEnganche").val(formatter.format(dto.dtoEnganches[0].montoPago));
    }else{
        $("#montoEnganche").val(formatter.format(0));
    }




    $("#cmbFormaPago").selectpicker('refresh');
    $("#cmbInsMonetario").selectpicker('refresh');
    $("#cmbMonedaDiv").selectpicker('refresh');
    $("#cdpplote").selectpicker('refresh');
    $("#cmbPlanPago").selectpicker('refresh');

    if (dto.dtoEnganches.length > 0)
        agregarEngancheT(dto.dtoEnganches);


}

function agregarEngancheT(enganche) {
    var cantEngancheT = (objEnganche.enganchesGuardados.length + objEnganche.nuevoEnganche.length);
    $("#table_detalle_enganche").show();
    //Tomamos el valor actual del campo "de la vista" 
    if (enganche[0].nuevoEnganche?.id_det_enganche_temp == 0 && cantEngancheT < 3) {
        objEnganche.nuevoEnganche.push(enganche[0].nuevoEnganche);
        enganche = [enganche[0].nuevoEnganche];
    } else if (cantEngancheT < 3)
        objEnganche['enganchesGuardados'] = enganche;
    else
        alerts.showNotification("top", "right", "Oops, Ya cuenta con los 3 pagos del enganche", "danger");

    if (cantEngancheT < 3) {
        if ($.trim(enganche.length) <= 0) {
            $(".error-evento").addClass("has-error");
            $("agregarEnganche").removeClass("btn-primary");
            $("agregarEnganche").addClass("btn-blueMaderas");
        } else {
            enganche.forEach((eng) => {
                cont_eng++;
                var btnEliminar = `<button type="button" class="btn-data btn-blueMaderas ${cont_eng}" data-id="${cont_eng}" data-btnDetEnganche="${eng.id_det_enganche}"><i class="material-icons">edit</i></button>`;
                var inputNombreInvitado = `<input type="hidden" id="idDetEnganche" name="idDetEnganche[]" value="${eng.id_det_enganche}" />`;
                //Con el metodo append un nuevo tr al tbody de la
                //tabla #pila-carrito
                var html_tr = '<tr id="tr-' + cont_eng + '">';
                //Agregamos un campo hidden con el los datos
                /* Usamos un arreglo HTML para llamar de la misma manera 
                a todos los campos "arrgxxx[]", esto genera un
                arreglo de elementos en el enguaje de servidor
                */
                html_tr += `<input type="hidden" id="arrgIDCarrito" name="arrgIDCarrito[]" value="${eng.id_det_enganche}"/>`;
                html_tr += `<td>${(eng.id_det_enganche == 0 ? 'Nuevo enganche' : eng.id_det_enganche)}</td>`;
                html_tr += `<td>${eng.id_lote + inputNombreInvitado}</td>`;
                html_tr += `<td>${eng.nombreFormaPago + inputNombreInvitado}</td>`;
                html_tr += `<td>${eng.fecha_pago + inputNombreInvitado}</td>`;
                html_tr += `<td>${eng.nombreInstrumentoMonetario + inputNombreInvitado}</td>`;
                html_tr += `<td>${eng.nombreMonedaDivisa + inputNombreInvitado}</td>`;
                html_tr += `<td>${btnEliminar + inputNombreInvitado}</td>`;
                html_tr += `<button class="btn-blueMaderas eliminar-item" data-id="${cont_eng}">Eliminar</button> </td>`;
                html_tr += `</tr>`;
                //Lo agregamos
                $("#pila-carrito").append(html_tr);
            });
            //Limpiamos el campo
            $(".error-evento").removeClass("has-error");
        } // ELSE
    }
}

// ELIMINAR INVITADO DE RESERVA EN FORMA DE CARRITO
$(document).on("click", ".btn-blueMaderas", function (event) {
    var id_tr = $(this).attr("data-id");
    var idEnganche = $(this).attr("data-btnDetEnganche");
    //Eliminamos del dom (tr) el elemento seleccionado
    // const removed = objInvitadosReserva.filter(item => item !=idEnganche);
    // $("#tr-" + id_tr).remove();
    var engEditarGuardados = objEnganche.enganchesGuardados.filter(function (item) {
        return item.id_det_enganche == idEnganche;
    });
    var engEditarNuevos = objEnganche.nuevoEnganche.filter(function (item) {
        return item.id_det_enganche == idEnganche;
    });
    $("#cmbFormaPago").val(engEditarGuardados.length > 0 ? engEditarGuardados[0]?.forma_pago : engEditarNuevos[0]?.forma_pago);
    $("#cmbInsMonetario").val(engEditarGuardados.length > 0 ? engEditarGuardados[0]?.instrumento_monetario : engEditarNuevos[0]?.instrumento_monetario);
    $("#cmbMonedaDiv").val(engEditarGuardados.length > 0 ? engEditarGuardados[0]?.moneda_divisa : engEditarNuevos[0]?.moneda_divisa);
    $("#txtFechaPago").val(engEditarGuardados.length > 0 ? engEditarGuardados[0]?.fecha_pago : engEditarNuevos[0]?.fecha_pago);
    $("#txtIdLote").attr("data-idDetEnganche", engEditarGuardados.length > 0 ? engEditarGuardados[0]?.id_det_enganche : engEditarNuevos[0]?.id_det_enganche);
    $("#cmbFormaPago").selectpicker('refresh');
    $("#cmbInsMonetario").selectpicker('refresh');
    $("#cmbMonedaDiv").selectpicker('refresh');
    //SE RESTA LA CELDA BORRADA
    cont_eng--;
}); // FIN ELIMINAR INVITADO DE RESERVA EN FORMA DE CARRITO

function agregarNuevoEgnacheT() {
    var idLote = $("#txtIdLote").val();
    var formaPago = $("#cmbFormaPago").val();
    var instMonetario = $("#cmbInsMonetario").val();
    var monedaDiv = $("#cmbMonedaDiv").val();
    var fechaPago = $("#txtFechaPago").val();
    var cantEngancheT = (objEnganche.enganchesGuardados.length + objEnganche.nuevoEnganche.length);
    $("#txtIdLote").attr("data-idDetEnganche", (cantEngancheT + 1));
    if (idLote !== '' && formaPago !== '' && instMonetario !== '' &&
        monedaDiv !== '' && fechaPago !== '') {
        agregarEngancheT([{ nuevoEnganche: { id_det_enganche: (cantEngancheT + 1), id_lote: idLote, forma_pago: formaPago, fecha_pago: fechaPago, instrumento_monetario: instMonetario, moneda_divisa: monedaDiv, id_det_enganche_temp: 0 } }]);
    } else
        alerts.showNotification("top", "right", "Oops, Verifique el llenado de todos los campos", "danger");
}

// ELIMINAR INVITADO DE RESERVA EN FORMA DE CARRITO
$('#cmbInsMonetario').change(function () {
    var idDetEnganche = $("#txtIdLote").attr("data-idDetEnganche");
    var objRemplazarValor = objEnganche.enganchesGuardados.filter(function (item) {
        return item.id_det_enganche == idDetEnganche;
    });
    var objRemplazarValorN = objEnganche.nuevoEnganche.filter(function (item) {
        return item.id_det_enganche == idDetEnganche;
    });
    var instMonetario = $("#cmbInsMonetario").val();
    if (objRemplazarValor.length > 0)
        objRemplazarValor[0].instrumento_monetario = instMonetario == '' ? 0 : instMonetario;
    else if (objRemplazarValorN.length > 0)
        objRemplazarValorN[0].instrumento_monetario = instMonetario == '' ? 0 : instMonetario;
    $("#cmbFormaPago").selectpicker('refresh');
    $("#cmbInsMonetario").selectpicker('refresh');
    $("#cmbMonedaDiv").selectpicker('refresh');
});

// ELIMINAR INVITADO DE RESERVA EN FORMA DE CARRITO
$('#cmbFormaPago').change(function () {
    var idDetEnganche = $("#txtIdLote").attr("data-idDetEnganche");
    var objRemplazarValor = objEnganche.enganchesGuardados.filter(function (item) {
        return item.id_det_enganche == idDetEnganche;
    });
    var objRemplazarValorN = objEnganche.nuevoEnganche.filter(function (item) {
        return item.id_det_enganche == idDetEnganche;
    });
    var formaPago = $("#cmbFormaPago").val();
    if (objRemplazarValor.length > 0)
        objRemplazarValor[0].forma_pago = formaPago == '' ? 0 : formaPago;
    else if (objRemplazarValorN.length > 0)
        objRemplazarValorN[0].forma_pago = formaPago == '' ? 0 : formaPago;
    $("#cmbFormaPago").selectpicker('refresh');
    $("#cmbInsMonetario").selectpicker('refresh');
    $("#cmbMonedaDiv").selectpicker('refresh');

});

// ELIMINAR INVITADO DE RESERVA EN FORMA DE CARRITO
$('#cmbMonedaDiv').change(function () {
    var idDetEnganche = $("#txtIdLote").attr("data-idDetEnganche");
    var objRemplazarValor = objEnganche.enganchesGuardados.filter(function (item) {
        return item.id_det_enganche == idDetEnganche;
    });
    var objRemplazarValorN = objEnganche.nuevoEnganche.filter(function (item) {
        return item.id_det_enganche == idDetEnganche;
    });
    var monedaDivisa = $("#cmbMonedaDiv").val();
    if (objRemplazarValor.length > 0)
        objRemplazarValor[0].moneda_divisa = monedaDivisa == '' ? 0 : monedaDivisa;
    else if (objRemplazarValorN.length > 0)
        objRemplazarValorN[0].moneda_divisa = monedaDivisa == '' ? 0 : monedaDivisa;
    $("#cmbFormaPago").selectpicker('refresh');
    $("#cmbInsMonetario").selectpicker('refresh');
    $("#cmbMonedaDiv").selectpicker('refresh');
});

// ELIMINAR INVITADO DE RESERVA EN FORMA DE CARRITO
$('#txtFechaPago').change(function () {
    var idDetEnganche = $("#txtIdLote").attr("data-idDetEnganche");
    var objRemplazarValor = objEnganche.enganchesGuardados.filter(function (item) {
        return item.id_det_enganche == idDetEnganche;
    });
    var objRemplazarValorN = objEnganche.nuevoEnganche.filter(function (item) {
        return item.id_det_enganche == idDetEnganche;
    });
    var fechaPago = $("#txtFechaPago").val();
    if (objRemplazarValor.length > 0)
        objRemplazarValor[0].fecha_pago = fechaPago == '' ? 0 : fechaPago;
    else if (objRemplazarValorN.length > 0)
        objRemplazarValorN[0].fecha_pago = fechaPago == '' ? 0 : fechaPago;
    $("#cmbFormaPago").selectpicker('refresh');
    $("#cmbInsMonetario").selectpicker('refresh');
    $("#cmbMonedaDiv").selectpicker('refresh');
});

$(document).on("submit", "#formEnganches", function (e) {
    e.preventDefault();
    if (objEnganche.enganchesGuardados.length <= 0)
        objEnganche.enganchesGuardados = [];
    else if (objEnganche.nuevoEnganche <= 0)
        objEnganche.nuevoEnganche = [];

    $.ajax({
        type: 'POST',
        url: `${general_base_url}Internomex/guardarEnganches`,
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend:()=>{
            return validateInputs();
        },
        success:(dto)=>{
            if (dto != []) {
                try {
                    dto = JSON.parse(dto);
                    console.log(dto);
                    if (dto.status == 1) {
                        cerrarModalDetEnganche();
                        alerts.showNotification("top", "right", dto.mensaje, "success");
                        tabla_valores_cliente.ajax.reload();
                    }
                    else
                        alerts.showNotification("top", "right", dto.mensaje, "danger");


                } catch (error) {
                    if (error instanceof SyntaxError) {
                        console.log(error)
                    } else {
                        throw error; // si es otro error, que lo siga lanzando
                    }
                }
            }
            else
                alerts.showNotification("top", "right", "Oops, algo salió mal. inténtalo más tarde.", "danger");
            return dto;
        },
        error:()=>{
            alerts.showNotification("top", "right", "Oops, algo salió mal al consultar los catálogos de enganche.", "danger");
        }
    })
        // .done(function (dto) {
        //     if (dto != []) {
        //         try {
        //             if (dto.status == 1) {
        //                 cerrarModalDetEnganche();
        //                 alerts.showNotification("top", "right", "Exito, se registraron los datos correctamente.", "success");
        //             }
        //             else
        //                 alerts.showNotification("top", "right", "Oops, algo salió mal al guardar los datos", "danger");
        //         } catch (error) {
        //             if (error instanceof SyntaxError) {
        //                 console.log(error)
        //             } else {
        //                 throw error; // si es otro error, que lo siga lanzando
        //             }
        //         }
        //     }
        //     else
        //         alerts.showNotification("top", "right", "Oops, algo salió mal. inténtalo más tarde.", "danger");
        //     return dto;
        // })
        // .fail(function () {
        //     alerts.showNotification("top", "right", "Oops, algo salió mal al consultar los catálogos de enganche.", "danger");
        // });
});

function validateInputs(){
    let idLote = $('#txtIdLote').val();
    let cmbFormaPago = $('#cmbFormaPago').val();
    let cmbInsMonetario = $('#cmbInsMonetario').val();
    let cmbMonedaDiv = $('#cmbMonedaDiv').val();
    let txtFechaPago = $('#txtFechaPago').val();
    let montoPago = $('#montoEnganche').val();

    if(idLote=='' || idLote==null){
        alerts.showNotification('top', 'right', 'Debes haber seleccionado un lote', 'warning');
        return false;
    }
    if(cmbFormaPago=='' || cmbFormaPago==null){
        alerts.showNotification('top', 'right', 'Debes seleccionar una forma de pago', 'warning');
        return false;
    }
    if(cmbInsMonetario=='' || cmbInsMonetario==null){
        alerts.showNotification('top', 'right', 'Debes seleccionar el instrumento monetario', 'warning');
        return false;
    }
    if(cmbMonedaDiv=='' || cmbMonedaDiv==null){
        alerts.showNotification('top', 'right', 'Debes seleccionar la divisa de la moneda', 'warning');
        return false;
    }
    if(txtFechaPago=='' || txtFechaPago==null){
        alerts.showNotification('top', 'right', 'Ingresa fecha del pago', 'warning');
        return false;
    }
    if(montoPago=='' || montoPago==null || montoPago==0){
        alerts.showNotification('top', 'right', 'Ingresa un monto', 'warning');
        return false;
    }
}