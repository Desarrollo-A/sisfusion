let idLote = 0;
let dumpPlanPago = [];
let nombreLote;
let planesDePagoIds;
let monedaCatalogo;
let periodicidadCatalogo;
let planesPagoCatalogo;
let catalogos;
$(document).ready(function () {
    $.post(`${general_base_url}Contratacion/lista_proyecto`, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#idResidencial").append($('<option>').val(data[i]['idResidencial']).text(data[i]['descripcion']));
        }
        $("#idResidencial").selectpicker('refresh');
    }, 'json');

});

$('#idResidencial').change(function () {
    $('#spiner-loader').removeClass('hide');
    $('#tablaInventario').removeClass('hide');
    index_idResidencial = $(this).val();
    $("#idCondominioInventario").html("");
    $(document).ready(function () {
        $.post(`${general_base_url}Contratacion/lista_condominio/${index_idResidencial}`, function (data) {
            for (var i = 0; i < data.length; i++) {
                $("#idCondominioInventario").append($('<option>').val(data[i]['idCondominio']).text(data[i]['nombre']));
            }
            $("#idCondominioInventario").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }, 'json');
    });
});

$('#idCondominioInventario').change(function () {
    $('#spiner-loader').removeClass('hide');
    $('#tablaInventario').removeClass('hide');
    index_idCondominio = $(this).val();
    $("#idLote").html("");
    $(document).ready(function () {
        $.post(`${general_base_url}Corrida/lista_lotes/${index_idCondominio}`, function (data) {
            for (var i = 0; i < data.length; i++) {
                $("#idLote").append($('<option data-nombreLote="'+data[i]['nombreLote']+'">').val(data[i]['idLote']).text(data[i]['nombreLote']));
            }
            $("#idLote").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }, 'json');
    });
});

let titulosPlanPagos = [];
$('#tablaPlanPagos thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulosPlanPagos.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tablaPlanPagos').DataTable().column(i).search() !== this.value) {
            $('#tablaPlanPagos').DataTable().column(i).search(this.value).draw();
        }
    });
});
$('#idLote').change(function () {
    $('#nombreCliente').val('');
    $('#spiner-loader').removeClass('hide');
    $('#tablaPlanPagos').removeClass('hide');
    index_idLote = $(this).val();
    idLote = index_idLote;
    console.log('index_idLote', index_idLote);
    var nombreLoteSeleccionado = $('option:selected', this).attr('data-nombreLote');
    var disabledButton;
    //tablaPlanPagos
    $('#spiner-loader').removeClass('hide');
    $.post(general_base_url+"Corrida/getInfoByLote/"+idLote, function (data) {
        console.log(data['cliente']);
        console.log(data['planPago']);
        $('#nombreCliente').val(data['cliente'][0].nombre+' '+data['cliente'][0].apellido_paterno+' '+data['cliente'][0].apellido_materno);
        $('#spiner-loader').addClass('hide');
        console.log(data['planPago'].length);

        if(data['planPago'].length <= 0 ){
            tablaPlanPagos.buttons( '.myButtonClass' ).disable();
        }else{
            disabledButton = false;
        }
    }, 'json');


    tablaPlanPagos = $("#tablaPlanPagos").DataTable({
        dom: "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'B><'col-12 col-sm-12 col-md-6 col-lg-6 p-0'f>rt>"+"<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        destroy: true,
        searching: true,
        scrollX: true,
        ajax: {
            url: `${general_base_url}corrida/getPlanesPago/${index_idLote}`,
            dataSrc: ""
        },
        buttons: [
            {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'Planes de pago '+ nombreLoteSeleccionado,
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                className: 'btn buttons-pdf',
                titleAttr: 'PDF',
                title: 'Inventario lotes',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosInventario[columnIdx]  + ' ';
                        }
                    }
                }
            },
            {
                text: '<i class="fa fa-plus aria-hidden="true"></i>',
                className: 'btn btn-azure',
                titleAttr: 'Agregar plan de pago',
                title: 'Agregar plan de pago',
                action:function(){
                    addPlanPago();
                },
            },
            {
                text: '<i class="fa fa-check" aria-hidden="true"></i>',
                className: 'btn btn-azure',
                titleAttr: 'Enviar plan de pago',
                title: 'Enviar plan de pago',
                attr: {id:'buttonAdd'},
                action:function(){
                    enviarPlanPago(index_idLote);
                }
            }],
        // columnDefs: [{
        //     targets: [22, 23, 24, 32],
        //     visible: coordinador = ((id_rol_general == 11 || id_rol_general == 17 || id_rol_general == 63 || id_rol_general == 70) || (id_usuario_general == 2748 || id_usuario_general == 5957)) ? true : false
        // }],
        pagingType: "full_numbers",
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: false,
        pageLength: 10,
        bAutoWidth: false,
        bLengthChange: false,
        bInfo: true,
        paging: true,
        ordering: true,
        columns: [{
            data: 'nombreResidencial'
            },
            {
                data: 'nombreCondominio'
            },
            { data: 'nombreLote' },
            { data: 'idLote' },
            { data: 'nombrePlan' },
            { data: 'numeroPeriodos' },
            {
                data: function (d) {
                    let etiqueta;
                    switch (d.estatusPlan) {
                        case 1: //Se subió
                            etiqueta = `<label class="label lbl-gray">En proceso</label>`;
                            break;
                        case 2: //Se envio correctamente a NeoData
                            etiqueta = `<label class="label lbl-green">Se envió correctamente a NeoData</label>`;
                            break;
                        case 3: //Plan de pago cancelado
                            etiqueta = `<label class="label lbl-warning">Plan de pago cancelado en NeoData</label>`;
                            break;
                    }

                    return etiqueta;
                }
            },
            /***********/
            {
                data: function (d) {
                    let BTN_EDIT;
                    let BTN_SEND;
                    let BTN_DELETE;
                    // if(d.idStatusContratacion == 0 && d.idMovimiento == 0){ //validacion de estatus apra poder eliminar
                        if(d.estatusPlan == 2){
                            BTN_DELETE = `<button class="btn-data btn-warning cancelarPlanPago" value="${d.idLote}" 
                            data-nomLote="${d.nombreLote}" data-idplanPago="${d.idPlanPago}" data-nombrePlan="${d.nombrePlan}" 
                            data-planPagoNumero="${d.ordenPago}"
                            data-toggle="tooltip" data-placement="left" title="Eliminar Plan"><i class="fas fa-trash"></i></button>`;
                        }else{
                            BTN_DELETE = ``;
                        }

                    // }

                    let BTN_VER = `<button class="btn-data btn-blueMaderas ver_planPago" value="${d.idLote}" 
                    data-nomLote="${d.nombreLote}" data-idplanPago="${d.idPlanPago}" data-nombrePlan="${d.nombrePlan}" 
                    data-toggle="tooltip" data-placement="left" title="VER PLAN"><i class="fas fa-eye"></i></button>`;

                    switch (d.estatusPlan) {
                        case 1:
                            BTN_EDIT = `<button class="btn-data btn-blueMaderas editarPago" value="${d.idLote}" 
                            data-nomLote="${d.nombreLote}" data-idplanPago="${d.idPlanPago}" data-nombrePlan="${d.nombrePlan}" 
                            data-saldoSig="${d.saldoSig}"
                            data-toggle="tooltip" data-placement="left" title="EDITAR PLAN" ><i class="fas fa-pencil-alt"></i></button>`;

                            BTN_SEND = `<button class="btn-data btn-blueMaderas enviarPago" value="${d.idLote}" 
                            data-nomLote="${d.nombreLote}" data-idplanPago="${d.idPlanPago}" data-nombrePlan="${d.nombrePlan}" 
                            data-saldoSig="${d.saldoSig}"
                            data-toggle="tooltip" data-placement="left" title="ENVIAR PLAN" ><i class="fas fa-share"></i></button>`;
                            break;
                        case 2:
                            BTN_EDIT = `<button class="btn-data " disabled
                            data-toggle="tooltip" data-placement="left" title="PLAN ENVIADO NO SE PUEDE EDITAR" ><i class="fas fa-pencil-alt"></i></button>`;

                            BTN_SEND = `<button class="btn-data" disabled 
                            data-toggle="tooltip" data-placement="left" title="PLAN ENVIADO" ><i class="fas fa-share"></i></button>`;
                            break;
                        case 3:
                            BTN_EDIT = `<button class="btn-data btn-blueMaderas editarPago" value="${d.idLote}" 
                            data-nomLote="${d.nombreLote}" data-idplanPago="${d.idPlanPago}" data-nombrePlan="${d.nombrePlan}" 
                            data-saldoSig="${d.saldoSig}"
                            data-toggle="tooltip" data-placement="left" title="EDITAR PLAN" ><i class="fas fa-pencil-alt"></i></button>`;

                            BTN_SEND = `<button class="btn-data btn-blueMaderas enviarPago" value="${d.idLote}" 
                            data-nomLote="${d.nombreLote}" data-idplanPago="${d.idPlanPago}" data-nombrePlan="${d.nombrePlan}" 
                            data-saldoSig="${d.saldoSig}"
                            data-toggle="tooltip" data-placement="left" title="ENVIAR NUEVAMENTE" ><i class="fas fa-share"></i></button>`;
                            break;
                            break;
                    }






                    let buttonValidado = (d.tipoPlanPago == 1) ? BTN_SEND + BTN_DELETE: '';
                    return `<center>${BTN_VER} ${BTN_EDIT} ${buttonValidado}</center>`;
                }
            }],
        initComplete: function() {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
    $('#spiner-loader').addClass('hide');
    /*

    * */

});


function addPlanPago(){
    $.ajax({
        type: "POST",
        url: `${general_base_url}Corrida/catalogosPlanPago`,
        dataType: "json",
        data: { idLote: idLote }
    })
        .done(function (dto) {
            if (dto != []) {
                try {
                    if (dto.status == 1) {
                        if(dto.enviadoNeodata == 0){
                            console.log('log: ', dto);
                            loadInputsCatalogos(dto);
                            $('#addPlanPago').modal('show');
                        }
                        else{
                            let tituloAviso = '<h5>Estos planes de pago <b>ya fueron enviados a NeoData</b> anteriormente</h5>';
                            let subtitAviso = '<p>Por lo cual, no es posible agregar más planes de pago</p>';
                            let contenedorGeneral = tituloAviso + subtitAviso;
                            document.getElementById("contenidoAviso").innerHTML =  contenedorGeneral;
                            $('#avisoModalPlanPago').modal('show');
                        }
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

}

function loadInputsCatalogos(dto){
    console.log('dto', dto);
    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    });
    cerrarModalAddPlan();
    dto.dtoCatalogos.map((catalogoOpciones) => {
        if (catalogoOpciones.id_catalogo == 137) {
            // PLAN DE PAGO
            if(dto.planDeEngancheActual < 1){
                $("#tipoPP").append(`<option value="${catalogoOpciones.id_opcion}" data-FormaPgo="${catalogoOpciones.nombre}">${catalogoOpciones.nombre}</option>`);
            }else{
                if(catalogoOpciones.id_opcion == 2){
                    $("#tipoPP").append(`<option value="${catalogoOpciones.id_opcion}" data-FormaPgo="${catalogoOpciones.nombre}">${catalogoOpciones.nombre}</option>`);
                }
            }
        }

        if (catalogoOpciones.id_catalogo == 138) // PERIODICIDAD
            $("#periocidadPP").append(`<option value="${catalogoOpciones.id_opcion}" data-FormaPgo="${catalogoOpciones.nombre}">${catalogoOpciones.nombre}</option>`);
        if (catalogoOpciones.id_catalogo == 112) // MONEDA O DIVISA
            $("#monedaPP").append(`<option value="${catalogoOpciones.id_opcion}" data-FormaPgo="${catalogoOpciones.nombre}">${catalogoOpciones.nombre}</option>`);
    });

    $("#tipoPP").selectpicker('refresh');
    $("#periocidadPP").selectpicker('refresh');
    $("#monedaPP").selectpicker('refresh');


    let idLotePP = document.getElementById('idLotePP');
    let idClientePP = document.getElementById('idClientePP');
    let nombreLotePP = document.getElementById('nombreLotePP');
    idLotePP.value = dto.infoLote.idLote;
    idClientePP.value = dto.infoLote.idCliente;
    nombreLotePP.value = dto.infoLote.nombreLote;


    $('#tipoPP').removeAttr('disabled');
    $('#tazaInteresPP').removeAttr('readonly');
    $('#interesesSSI').removeAttr('disabled');

    let planPago = document.getElementById("planPago");
    planPago.value = (dto.planesTotal + 1);
    planPago.readOnly = true;

}

function activarIva(checkboxElem) {
    let porcentajeIvaPP = document.getElementById('porcentajeIvaPP');
    let cantidadIvaPP = document.getElementById('cantidadIvaPP');


    if (checkboxElem.checked) {
        porcentajeIvaPP.disabled = false;
        cantidadIvaPP.disabled = false;

        porcentajeIvaPP.classList.remove('disabledInput');
        cantidadIvaPP.classList.remove('disabledInput');
    } else {
        porcentajeIvaPP.disabled = true;
        cantidadIvaPP.disabled = true;
        porcentajeIvaPP.classList.add('disabledInput');
        cantidadIvaPP.classList.add('disabledInput');
    }
}

$(document).on("submit", "#formPlanPago", function (e) {
    e.preventDefault();

    generarPlanPagoFunction();
    let formulario =  new FormData(this);
    formulario.append("dumpPlanPago", dumpPlanPago);
    console.log('JSON.parse(dumpPlanPago).length', JSON.parse(dumpPlanPago).length);
    console.log('dumpPlanPago', dumpPlanPago);
    // formulario.append("noPeriodosPP", JSON.parse(dumpPlanPago).length);
    // console.log('dumpPlanPago', dumpPlanPago);
    $.ajax({
        type: 'POST',
        url: `${general_base_url}Corrida/guardaPlanPago`,
        data: formulario,
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
                        cerrarModalAddPlan();
                        alerts.showNotification("top", "right", dto.mensaje, "success");
                        $('#tablaPlanPagos').DataTable().ajax.reload();
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
});

function validateInputs(){
    let tipoPP = $('#tipoPP').val();
    let planPago = $('#planPago').val();
    let descripcionPlanPago = $('#descripcionPlanPago').val();
    let monedaPP = $('#monedaPP').val();
    let montoPP = $('#montoPP').val();
    let tazaInteresPP = $('#tazaInteresPP').val();
    let noPeriodosPP = $('#noPeriodosPP').val();
    let periocidadPP = $('#periocidadPP').val();
    let fechaInicioPP = $('#fechaInicioPP').val();
    //let interesesSSI = $('#interesesSSI').val();
    let ivaPP = document.querySelector('.checkBox').checked;
    let mensualidadPP = $('#mensualidadPP').val();
    let porcentajeIvaPP = $('#porcentajeIvaPP').val();
    let cantidadIvaPP = $('#cantidadIvaPP').val();


    if(tipoPP=='' || tipoPP==null){
        alerts.showNotification('top', 'right', 'Debes seleccionar el tipo de plan', 'warning');
        return false;
    }
    if(planPago=='' || planPago==null){
        alerts.showNotification('top', 'right', 'Ingresa el número de plan de pago', 'warning');
        return false;
    }
    if(descripcionPlanPago=='' || descripcionPlanPago==null){
        alerts.showNotification('top', 'right', 'Ingresa una descripción del plan de pago', 'warning');
        return false;
    }
    if(monedaPP=='' || monedaPP==null){
        alerts.showNotification('top', 'right', 'Debes seleccionar la divisa de la moneda', 'warning');
        return false;
    }
    if(montoPP=='' || montoPP==null || montoPP==0){
        alerts.showNotification('top', 'right', 'Ingresa el monto total del plan de pago', 'warning');
        return false;
    }
    if(tazaInteresPP=='' || tazaInteresPP==null){
        alerts.showNotification('top', 'right', 'Ingresa la taza de interés', 'warning');
        return false;
    }
    if(noPeriodosPP=='' || noPeriodosPP==null || noPeriodosPP==0){
        alerts.showNotification('top', 'right', 'Ingresa número de periodos', 'warning');
        return false;
    }
    if(periocidadPP=='' || periocidadPP==null){
        alerts.showNotification('top', 'right', 'Debes seleccionar la periodicidad', 'warning');
        return false;
    }
    if(fechaInicioPP=='' || fechaInicioPP==null ){
        alerts.showNotification('top', 'right', 'Selecciona una fecha de inicio del plan de pago', 'warning');
        return false;
    }
    if(mensualidadPP=='' || mensualidadPP==null || mensualidadPP==0){
        alerts.showNotification('top', 'right', 'Ingresa un monto de mensualidad', 'warning');
        return false;
    }

    if(ivaPP==1){
        //si el checkbox está seleccionado debe validar los campos del IVA
        if(porcentajeIvaPP=='' || porcentajeIvaPP==null || porcentajeIvaPP==0){
            alerts.showNotification('top', 'right', 'Ingresa un porcentaje de IVA', 'warning');
            return false;
        }
        if(cantidadIvaPP=='' || cantidadIvaPP==null || cantidadIvaPP==0){
            alerts.showNotification('top', 'right', 'Ingresa una cantidad de IVA', 'warning');
            return false;
        }
    }

    if(dumpPlanPago.length == 0){
        alerts.showNotification('top', 'right', 'No se ha generado el plan de pago, inténtalo nuevamente', 'warning');
        return false;
    }

}

$(document).on('change','#tipoPP', function(){
    let tipoPlanTxtPP = document.getElementById('tipoPlanTxtPP');
    tipoPlanTxtPP.value = $(this).find("option:selected").attr('data-FormaPgo');

    //1:Enganche 2: Plan de pago
    let tipoPP = parseInt($(this).val());
    let tazaInteresPP = $('#tazaInteresPP');
    let interesesSSI = $('#interesesSSI');
    let tipoNc_valor1 = document.getElementById("tipoNc_valor1");
    let tipoNc_valor2 = document.getElementById("tipoNc_valor2");

    let labelTipoNc_valor1 = document.getElementById("labelTipoNc_valor1");
    let labelTipoNc_valor2 = document.getElementById("labelTipoNc_valor2");

    let descripcionPlanPago = $("#descripcionPlanPago");


    console.log('tipoPP', tipoPP);
    if(tipoPP==1){
        tazaInteresPP.attr('readonly','true');
        tazaInteresPP.val(0);
        interesesSSI.attr('disabled', 'disabled');
        tipoNc_valor1.disabled = false;
        tipoNc_valor2.disabled = false;

        tipoNc_valor1.checked  = false;
        tipoNc_valor2.checked  = false;
        labelTipoNc_valor1.classList.remove('disabledClassRadio');

        descripcionPlanPago.attr("readonly", true);
        descripcionPlanPago.val("Plan de pago Enganche");
    }else{
        tazaInteresPP.removeAttr('readonly');
        tazaInteresPP.val(0);
        descripcionPlanPago.attr("readonly", false);
        descripcionPlanPago.val("");
        if(Number.parseInt(tazaInteresPP.val())  == 0){
            interesesSSI.attr('disabled', 'disabled');
            tipoNc_valor1.disabled = false;
            tipoNc_valor2.disabled = false;

            tipoNc_valor1.checked  = false;
            tipoNc_valor2.checked  = false;
            labelTipoNc_valor1.classList.remove('disabledClassRadio');
        }else{
            interesesSSI.removeAttr('disabled');
            tipoNc_valor1.disabled = true;
            tipoNc_valor2.disabled = true;

            tipoNc_valor1.checked  = true;
            tipoNc_valor2.checked  = false;
            labelTipoNc_valor1.classList.add('disabledClassRadio');
        }

    }
});

function cerrarModalAddPlan() {
    $("#tipoPP").empty();

    $("#descripcionPlanPago").val('');
    $("#monedaPP").empty();
    $("#montoPP").val('');
    $("#tazaInteresPP").val('');
    $("#noPeriodosPP").val('');
    $("#periocidadPP").empty('');
    $("#fechaInicioPP").val('');
    $("#mensualidadPP").val('');
    $("#porcentajeIvaPP").val('');
    $("#cantidadIvaPP").val('');

    $("#tipoPP").selectpicker('refresh');
    $("#monedaPP").selectpicker('refresh');
    $("#periocidadPP").selectpicker('refresh');
    $('#addPlanPago').modal('hide');
    cont_eng = 0;
    document.getElementById("interesesSSI").checked = false;
    document.getElementById("ivaPP").checked = false;
    document.getElementById("tipoNc_valor1").checked = false;
    document.getElementById("tipoNc_valor2").checked = false;

    $("#idLotePP").val('');
    $("#idClientePP").val('');
    $("#nombreLotePP").val('');
    $("#idPlanPagoModal").val('');
    $("#saldoSiguienteModal").val('');

}

function generarPlanPagoFunction(){
    console.log("$('#idPlanPagoModal').val()", $('#idPlanPagoModal').val());
    //let tipoPP = $('#tipoPP').empty().selectpicker('refresh');
    let tipoPP = $('#tipoPP').val();
    let fechaInicio = $('#fechaInicioPP').val();
    let periocidadPP = $('#periocidadPP').val();
    let tazaInteresPP = $('#tazaInteresPP').val();
    let planPago = $('#planPago').val();
    let montoPP = $('#montoPP').val().replace("$", '');
    let mensualidadPP = $('#mensualidadPP').val().replace("$", '');
    montoPP = parseFloat(montoPP.replace(",", ''));
    let interesesSSI = document.getElementById('interesesSSI').checked;
    let ivaPP = document.getElementById('ivaPP').checked;
    let porcentajeIva = document.getElementById('porcentajeIvaPP').value;
    let idPlanPagoModal = ($('#idPlanPagoModal').val() == '' || $('#idPlanPagoModal').val() == undefined) ? undefined : $('#idPlanPagoModal').val();//id del plan de pago viene null o undefined cuando es primera inserción
    let saldoSiguienteModal = $('#saldoSiguienteModal').val();//id del plan de pago viene null o undefined cuando es primera inserción

    mensualidadPP = parseFloat(mensualidadPP.replace(',', ''));
    // let noPeriodosPP = Math.round(montoPP/mensualidadPP); // //$('#noPeriodosPP').val();
    let noPeriodosPP = $('#noPeriodosPP').val();
    let prioridadCalculo = $('input[name="tipoNc_valor"]:checked').val();
    dumpPlanPago = generarPlanPago(fechaInicio, noPeriodosPP, montoPP, tazaInteresPP, periocidadPP, tipoPP, planPago, mensualidadPP, interesesSSI, ivaPP, porcentajeIva, idPlanPagoModal, saldoSiguienteModal, prioridadCalculo);
}

$(document).on('click', '.ver_planPago', async function(){
    let idPlanPago = $(this).attr('data-idplanPago');
    let nombrePlanPago = $(this).attr('data-nombreplan');

    console.log('idPlanPago', idPlanPago);
    console.log('nombrePlanPago', nombrePlanPago);

    $('#spiner-loader').removeClass('hide');
    dumpPlanPago = await getPlanPagoDump(idPlanPago);
    fillTable(dumpPlanPago);

    $('#verPlanPago').modal('toggle');
});
const getPlanPagoDump = (idPlanPago) =>{
    return new Promise((resolve) => {
        $.getJSON(`${general_base_url}Corrida/getPlanPago/${idPlanPago}`,function (sedes) {
            resolve(sedes);
            $('#spiner-loader').addClass('hide');
        });
    });
}

function fillTable(data) {
    var tablePagos

    const createdCell = function(cell) {
        let original;

        const recalcularPlan = function(e) {
            cell.setAttribute("style","border:1px; border-style:solid; border-color:transparent;padding:10px")

            if (original !== e.target.textContent) {
                const row = tablePagos.row(e.target.parentElement)
                //row.invalidate()
                //console.log('Row changed: ', row.data())

                //console.log(data)

                let montoInicial = data.saldoInicialPlan

                let capital = parseFloat(e.target.textContent)

                let pagos = tablePagos.rows().data().toArray()

                let pago_nuevo = row.data()

                let nuevo_capital = montoInicial
                for(const pago of pagos){
                    if(pago.pago == pago_nuevo.pago){
                        pago.capital = capital
                    }

                    nuevo_capital -= pago.capital

                    pago.saldo = nuevo_capital
                }

                //tablePagos.clear()
                //tablePagos.rows.add(pagos).draw(false)
                tablePagos
                    .rows()
                    .invalidate()
                    .draw()
            }
        }

        cell.setAttribute('contenteditable', true)
        cell.setAttribute("style","border:1px; border-style:solid; border-color:transparent;padding:10px")
        cell.setAttribute('spellcheck', false)
        cell.addEventListener("focus", function(e) {
            cell.setAttribute("style","border:1px; border-style:solid; border-color:#000;padding:10px")

            original = e.target.textContent
        })
        cell.addEventListener('keydown', function(e) {
            if (e.keyCode === 13){
                e.preventDefault()

                recalcularPlan(e)
            }
        })
        cell.addEventListener("blur", recalcularPlan )
    }

    $('#nombrePlanPagotxt').val(data.nombrePlanPago);
    $('#nombrePlanPago').val(data.nombrePlan);
    $('#nombreCliente').val(data.nombreCliente);
    $('#montoPlanPago').val(formatMoney(data.monto));
    $('#tazaInteresPlanPago').val(data.tazaInteres);
    $('#mensualidadPlanPago').val(formatMoney(data.mensualidad));
    $('#periodosPlanPago').val(data.numeroPeriodos);
    $('#montoInicialPlan').val(formatMoney(data.saldoInicialPlan));
    data_plan = JSON.parse(data.dumpPlan);
    let titulosTabla = [];
    $('#tabla_plan_pago thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        titulosTabla.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($('#tabla_plan_pago').DataTable().column(i).search() !== this.value) {
                $('#tabla_plan_pago').DataTable().column(i).search(this.value).draw();
            }
        });
        $('[data-toggle="tooltip"]').tooltip();
    });

    tablePagos = $('#tabla_plan_pago').DataTable({
        data: data_plan,
        width: '100%',
        searching: true,
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",

        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip("destroy");
            $('[data-toggle="tooltip"]').tooltip({trigger: "hover"});
        },
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                title: 'Plan de pago',
                titleAttr: 'Descargar archivo de Excel',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10],
                    format: {
                        header: function (d, columnIdx) {
                            return ' '+titulosTabla[columnIdx] +' ';
                        }
                    }
                }
            }
        ],
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        processing: false,
        pageLength: 25,
        bAutoWidth: false,
        bLengthChange: false,
        bInfo: true,
        paging: true,
        ordering: true,
        scrollX:true,
        columns: [
            {
                data: function (d) {
                    return d.pago;
                }
            },
            {
                data: function (d) {//col concepto
                    let nombrePlan = $('#nombrePlanPago').val();
                    let nombreCompuesto = nombrePlan + ' - ' + d.pago;
                    return nombreCompuesto;
                }
            },
            {
                data: function (d) {
                    return d.fecha;
                }
            },
            {
                data: function (d) {
                    if(d.capital){
                        // return d.capital.toFixed(2);
                        return formatMoney(d.capital);
                    }
                    return ''
                }
            },
            {
                data: function (d) {
                    return formatMoney((d.saldoCapital).toFixed(2));
                }
            },
            {
                data: function (d) {
                    // return formatMoney((d.interes).toFixed(2));
                    return formatMoney((d.interes));
                }
            },
            {
                data: function (d) {
                    // return formatMoney((d.saldoInteres).toFixed(2));
                    return formatMoney((d.saldoInteres));
                }
            },
            {
                data: function (d) {
                    // return formatMoney((d.iva).toFixed(2));
                    return formatMoney((d.iva));
                }
            },
            {
                data: function (d) {
                    return formatMoney((d.saldoIva).toFixed(2));
                }
            },
            {
                data: function (d) {
                    // return formatMoney((d.total).toFixed(2));
                    return formatMoney((d.total));
                }
            },
            {
                data: function (d) {
                    // return formatMoney((d.saldo).toFixed(2));
                    return formatMoney((d.saldo));
                }
            },
        ],
        columnDefs: [{
            targets: [3],
            createdCell: createdCell
        }]
    });

    $('.guardarPlan').unbind("click").on('click', function(){
        console.log('guardar plan');

        let pagos = tablePagos.rows().data().toArray()

        $.ajax({
            type: "POST",
            url: `${general_base_url}Corrida/guardarPlanPago/${idLote}?plan=${data.idPlanPago}`,
            data: JSON.stringify(pagos),
            dataType: 'json',
        })
        .done(function() {
            alerts.showNotification("top", "right", "Plan guardado con éxito.", "success");

            $('#verPlanPago').modal('hide');
        })
    });
}

$(document).on('click', '.editarPago', function(){
    $('#spiner-loader').removeClass('hide');
    console.log('acciones para editar el plan de pago');
    let idPlanPago = $(this).attr("data-idplanpago");
    let saldoSigPlan = $(this).attr('data-saldosig');
    $('#saldoSiguienteModal').val(saldoSigPlan);
    console.log('idPlanPago: ', idPlanPago);
    $.ajax({
        // data: {idLote: idLote},
        url: 'getPlanPagoEditar/'+idPlanPago,
        type: 'POST',
        beforeSend: function () {
            // $('#spiner-loader').removeClass('hide');
        },
        success:  function (response) {
            response = JSON.parse(response);
            fillPlanPagoGral(response);
            $('#spiner-loader').addClass('hide');
        }
    });
});
async function getDatalogos(){
    catalogos = await obtenerCatalgosEditar();
    console.log('catalogos', catalogos);

}
const obtenerCatalgosEditar = () =>{
    return new Promise((resolve) => {
        $.getJSON(`${general_base_url}Corrida/getCatalogosEditarPlan`,function (cats) {
            resolve(cats);
        });
    });
}
function fillPlanPagoGral(data){
    console.log('data', data);
    let interesesSSI = $('#interesesSSI');
    $('#planPago').val(data.ordenPago);
    $('#planPago').attr('readonly', true);
    $('#descripcionPlanPago').val(data.descripcion);
    $('#montoPP').val(formatMoney(data.monto));

    $('#tazaInteresPP').val(data.tazaInteres);
    if(data.tipoPlanPago == 1){
        $('#tazaInteresPP').attr('readonly', true);
    }

    $('#noPeriodosPP').val(data.numeroPeriodos);
    $('#mensualidadPP').val(formatMoney(data.mensualidad));
    $('#porcentajeIvaPP').val(data.montoIvaPorcentaje);
    $('#cantidadIvaPP').val((data.cantidadIva<=0) ? 0 : data.cantidadIva);
    $('#idPlanPagoModal').val(data.idPlanPago);


    $('#idLotePP').val(data.idLote);
    $('#idClientePP').val(data.idCliente);
    $('#nombreLotePP').val(data.nombreLote);

    monedaCatalogo = data['monedaLista'];
    periodicidadCatalogo = data['periodicidadLista'];
    planesPagoCatalogo = data['tipos_planes'];

    //catalogos
    monedaCatalogo.forEach((monedasData)=>{
        const id = monedasData.id_opcion;
        const name = monedasData.nombre;
        if (id === parseInt(data.moneda)){
            $("#monedaPP").append($('<option selected>').val(id).text(name.toUpperCase()));
        } else {
            $("#monedaPP").append($('<option>').val(id).text(name.toUpperCase()));
        }
    });
    $("#monedaPP").selectpicker('refresh');

    planesPagoCatalogo.forEach((planesPagoData)=>{
        const id = planesPagoData.id_opcion;
        const name = planesPagoData.nombre;
        if (id === parseInt(data.tipoPlanPago)){
            $("#tipoPP").append($('<option selected>').val(id).text(name.toUpperCase()));
        } else {
            $("#tipoPP").append($('<option>').val(id).text(name.toUpperCase()));
        }
    });
    $('#tipoPP').attr('disabled', true);
    $("#tipoPP").selectpicker('refresh');

    periodicidadCatalogo.forEach((periodicidadData)=>{
        const id = periodicidadData.id_opcion;
        const name = periodicidadData.nombre;
        if (id === parseInt(data.periodicidad)){
            $("#periocidadPP").append($('<option selected>').val(id).text(name.toUpperCase()));
        } else {
            $("#periocidadPP").append($('<option>').val(id).text(name.toUpperCase()));
        }
    });
    $("#periocidadPP").selectpicker('refresh');


    if(data.tipoPlanPago == 1){
        document.getElementById("interesesSSI").checked = false;
        interesesSSI.attr('disabled', 'disabled');
    }else{
        document.getElementById("interesesSSI").checked = false;
        interesesSSI.attr('disabled', 'disabled');
        if(data.ssi == 1){
            document.getElementById("interesesSSI").checked = true;
            interesesSSI.attr('disabled', false);
        }
    }
    if(data.tazaInteres == 1){
        document.getElementById("ivaPP").checked = true;
    }

    if(data.prioridadCalculo == 1){
        document.getElementById("tipoNc_valor1").checked = true;
    }else if(data.prioridadCalculo == 2){
        document.getElementById("tipoNc_valor2").checked = true;
    }

    let fechaBaseData =  data.fechaInicioPLan;
    let fecha_formateada = new Date(fechaBaseData);
    console.log('fecha_formateada', fecha_formateada);




    let dayFormateada = (fecha_formateada.getDate()<10) ? '0'+fecha_formateada.getDate() : fecha_formateada.getDate();
    let monthFormateada = ((fecha_formateada.getMonth()+1)<10) ? '0'+(fecha_formateada.getMonth()+1) : (fecha_formateada.getMonth()+1) ;
    let yearFormateada = fecha_formateada.getFullYear();
    // $('#fechaInicioPP').val(data.fechaInicioPlan);

    $('#fechaInicioPP').val( yearFormateada +'-'+monthFormateada+'-'+ dayFormateada);


    $('#addPlanPago').modal('show');
}

function enviarPlanPago(idLote){
    console.log('se enviara el plan de pago actual');
    console.log('idLote xxD', idLote);

    $('#idLoteSbt').val(idLote);
    $('#aceptarPlanPago').modal();


}

$(document).on('click', '.enviarPago', function(){
    console.log('vamonos alv');
    let idPlanPago = $(this).attr('data-idplanpago');
    console.log('idPlanPago:', idPlanPago);
    $('#idPlanPagoIn').val(idPlanPago);
    $('#aceptarPlanPagoPP').modal();
});

$(document).on('click', '#aceptarEnvioPP2', function(){
   console.log('enviio de plan de pago individual');
    let idPlanPago = $('#idPlanPagoIn').val();
    console.log('idPlanPago:', idPlanPago);
    $.ajax({
        data: {idPlanPago:idPlanPago},
        url: 'generaPlanPagoEnvioidPago/',
        type: 'POST',
        beforeSend: function(){
            $('#spiner-loader').removeClass('hide');
        },
        success: function (response) {
            response = JSON.parse(response);
            if (response.respuesta == 1) {
                //enviar el plan generado pero ahora al servicio de NeoData
                //Descomentar cuando se haga la prueba con el servicio de Rodri
                servicioNeoData(response);
            }
            else if(response.respuesta == -1){
                alerts.showNotification('top', 'right', 'No hay registro de plan de pagos para enviar o ya se enviaron a Neodata anteriormente.', 'danger');
                $('#aceptarPlanPagoPP').modal('toggle');
                $('#spiner-loader').addClass('hide');
            }
            else{
                alerts.showNotification('top', 'right', 'OCURRIO UN ERROR INESPERADO, INTENTELO NUEVAMENTE', 'danger');
                $('#aceptarPlanPagoPP').modal('toggle');
                $('#spiner-loader').addClass('hide');
                $('#tablaPlanPagos').DataTable().ajax.reload();
            }
        }
    });
});

$(document).on('click', '#aceptarEnvioPP', function(){

   let idLote = $('#idLoteSbt').val();
    $.ajax({
        data: {idLote:idLote},
        url: 'generaPlanPagoEnvio/',
        type: 'POST',
        beforeSend: function(){
            $('#spiner-loader').removeClass('hide');
        },
        success: function (response) {
            response = JSON.parse(response);
            if (response.respuesta == 1) {
                console.log("response:", response);
                servicioNeoData(response);

                //enviar el plan generado pero ahora al servicio de NeoData
                //Descomentar cuando se haga la prueba con el servicio de Rodri


                /*console.log('response', response);
                planesDePagoIds = response.planesPagoIds;
                $.ajax({
                     data:JSON.stringify(response.planServicio),
                     url: 'http://192.168.16.20/neodata_reps/back/index.php/ServiciosNeo/regPlanPagoCompleto',
                     type: 'POST',
                     success: function (response) {
                         console.log('RESPUES NEODATA:'+response);
                         response = JSON.parse(response);
                         let statusAviso;
                         if(response.status === true){
                             statusAviso = 'success';
                             //actualizar los registros de los  planes de pago com enviados
                             $.ajax({
                                 data:{ids:planesDePagoIds},
                                 url: 'actualizaPlanPagoStatus',
                                 type: 'POST',
                                 success: function (response) {
                                     response = JSON.parse(response);
                                     let statusAviso;
                                     if(response.status === true){
                                         statusAviso = 'success';
                                         //actualizar los registros de los  planes de pago com enviados
                                     }else{
                                         statusAviso = 'danger';
                                     }
                                     alerts.showNotification('top', 'right', response.msj, statusAviso);
                                     $('#aceptarPlanPago').modal('toggle');
                                     $('#spiner-loader').addClass('hide');
                                     $('#tablaPlanPagos').DataTable().ajax.reload();
                                 }
                             });
                         }else{
                             statusAviso = 'danger';
                             alerts.showNotification('top', 'right', response.msj, statusAviso);
                             $('#aceptarPlanPago').modal('toggle');
                             $('#spiner-loader').addClass('hide');
                             $('#tablaPlanPagos').DataTable().ajax.reload();
                         }
                     }

                 });*/


            } else if(response.respuesta == -1){
                alerts.showNotification('top', 'right', 'No hay registro de plan de pagos para enviar o ya se enviaron a Neodata anteriormente.', 'danger');
                $('#aceptarPlanPago').modal('toggle');
                $('#spiner-loader').addClass('hide');
            } else{
                alerts.showNotification('top', 'right', 'OCURRIO UN ERROR INESPERADO, INTENTELO NUEVAMENTE', 'danger');
                $('#aceptarPlanPago').modal('toggle');
                $('#spiner-loader').addClass('hide');
                $('#tablaPlanPagos').DataTable().ajax.reload();
            }

        }
    });
});

function servicioNeoData(response){
    planesDePagoIds = response.planesPagoIds;
    console.log("planesDePagoIds", planesDePagoIds);

    $.ajax({
        data:JSON.stringify(response.planServicio),
        url: 'http://192.168.16.20/neodata_reps/back/index.php/ServiciosNeo/regPlanPagoCompleto',
        type: 'POST',
        success: function (response) {
            console.log('RESPUES NEODATA:'+response);
            response = JSON.parse(response);
            let statusAviso;
            if(response.status === true){//resultado general de la consulta
                statusAviso = 'success';

                let banderaActualizado = 0;
                response.data.map((elemento, index)=>{//se recorre la respuesta del servidor de NEODATA
                    console.log('elemento', elemento);
                    let avisoCRM = '';
                    if(elemento.status === true){//revisa el estado de la transacción interna de los planes
                        statusAviso = 'success';
                        banderaActualizado += 1;
                        planesDePagoIds.map((planPagoObject, index2)=>{//se recorren los planes de pago del CRM
                            if(planPagoObject.numPlanPago == elemento.numPlan){//se checa que se haya insertado en NEODATA para actualziarlo en CRM
                                $.ajax({
                                    data:{idPlanPago:planPagoObject.idPlanPago},
                                    url: 'actualizaPlanPagoIndividual',
                                    type: 'POST',
                                    success: function (response) {
                                        response = JSON.parse(response);
                                        let statusAviso;
                                        if(response.status === true){//status de la transacción general
                                            console.log('response: ', response);
                                            statusAviso = 'success';
                                        }else{
                                            statusAviso = 'danger';
                                        }
                                        alerts.showNotification('top', 'right', "[CRM] "+response.msj, statusAviso);

                                    }
                                });
                            }
                        });
                    }
                    else{
                        statusAviso = 'danger';
                        avisoCRM = ' [CRM] Registro no actualizado PLAN PAGO '+elemento.numPlan;
                    }
                    alerts.showNotification('top', 'right', '[NEODATA] '+elemento.msj+avisoCRM, statusAviso);
                });

                // if(response.data.length == banderaActualizado){
                //     $.ajax({
                //         data:{ids:planesDePagoIds},
                //         url: 'actualizaPlanPagoStatus',
                //         type: 'POST',
                //         success: function (response) {
                //             response = JSON.parse(response);
                //             let statusAviso;
                //             if(response.status === true){//status de la transacción general
                //                 console.log('response.data: ', response.data);
                //                 statusAviso = 'success';
                //
                //             }else{
                //                 statusAviso = 'danger';
                //             }
                //             alerts.showNotification('top', 'right', response.msj, statusAviso);
                //
                //         }
                //     });
                // }


                //actualizar los registros de los  planes de pago com enviados
                $('#aceptarPlanPago').modal('hide');
                $('#aceptarPlanPagoPP').modal('hide');
                $('#spiner-loader').addClass('hide');
                $('#tablaPlanPagos').DataTable().ajax.reload();
            }
            else{
                statusAviso = 'danger';
                alerts.showNotification('top', 'right', response.msj, statusAviso);
                $('#aceptarPlanPago').modal('hide');
                $('#aceptarPlanPagoPP').modal('hide');
                $('#spiner-loader').addClass('hide');
                $('#tablaPlanPagos').DataTable().ajax.reload();
            }
        }

    });/**/
    setTimeout(()=>{
        $('#tablaPlanPagos').DataTable().ajax.reload();//recargar la tabla por si no se recargó correctamente
    }, 3000)
}

$(document).on('change','#tazaInteresPP', function(){
    let tazaInteresPP = parseInt($('#tazaInteresPP').val());
        console.log('Ha cambiado a:', tazaInteresPP);
    let tipoPP = parseInt($(this).val());
    let interesesSSI = $('#interesesSSI');
    let tipoNc_valor1 = document.getElementById("tipoNc_valor1");
    let tipoNc_valor2 = document.getElementById("tipoNc_valor2");
    let labelTipoNc_valor1 = document.getElementById("labelTipoNc_valor1");

    if(tazaInteresPP <= 0){
        interesesSSI.attr('disabled', 'disabled');
        tipoNc_valor1.disabled = false;
        tipoNc_valor2.disabled = false;

        tipoNc_valor1.checked  = false;
        tipoNc_valor2.checked  = false;
        labelTipoNc_valor1.classList.remove('disabledClassRadio');
    }else{
        interesesSSI.removeAttr('disabled');
        tipoNc_valor1.disabled = true;
        tipoNc_valor2.disabled = true;

        tipoNc_valor1.checked  = true;
        tipoNc_valor2.checked  = false;
        labelTipoNc_valor1.classList.add('disabledClassRadio');
    }

});

$(document).on('click', '.cancelarPlanPago', function(){
    //CDMAGS-LAVH-097
    //@numPlanPagoCRM = 2
    let numeroPlanPago = $(this).attr('data-planpagonumero');
    let nombreLote = $(this).attr('data-nomlote');
    let idLote = $(this).val();
    let nombrePlan = $(this).attr('data-nombrePlan');
    let idPlanPago = $(this).attr('data-idplanpago');
    console.log('nombrePlan', nombrePlan);
    // idLoteCancelado
    //cancelarPlanPago
    $('#idLoteCancelado').val(idLote);
    // nombreLoteCancelado
    // document.getElementById("nombrePlanPagoCancelatxt").innerText = nombrePlan;
    $("#nombrePlanPagoCancelatxt").text(nombrePlan);
    $('#nombreLoteCancelado').val(nombreLote);
    $('#numeroPlanLoteCancelado').val(numeroPlanPago);
    $('#idPlanPagoCancelado').val(idPlanPago);
    $('#cancelarPlanPago').modal('toggle');

    console.log('numeroPlanPago', numeroPlanPago);
    console.log('nombrePlan', nombrePlan);
    /*$.ajax({
        data:{data:1},
        url: 'Corrida/cancelaPlanPagoNeo',
        type: 'POST',
        success: function (response) {
            response = JSON.parse(response);
            let statusAviso;
            if(response.status === true){//status de la transacción general
                console.log('response: ', response);
                statusAviso = 'success';
            }else{
                statusAviso = 'danger';
            }
            alerts.showNotification('top', 'right', "[CRM] "+response.msj, statusAviso);

        }
    });*/
});

$(document).on('click', '#cancelarPP', ()=>{
    let nombreLoteCancelado = $('#nombreLoteCancelado').val();
    let numeroPlanLoteCancelado = $('#numeroPlanLoteCancelado').val();
    let idPlanPago = $('#idPlanPagoCancelado').val();

    $.ajax({
        data:{nombreLoteCancelado:nombreLoteCancelado, numeroPlanLoteCancelado:numeroPlanLoteCancelado},
        url: 'cancelaPlanPagoNeo',
        type: 'POST',
        success: function (response) {
            console.log('response', response);
            response = JSON.parse(response);
            response = response.responseGeneral[0];
            console.log('response JSON', response);

            let statusAviso;
            if(response.status === 1){//status de la transacción general
                statusAviso = 'success';
                //actualizar elmplan de pago en CRM
                cancelaPlanCRM(idPlanPago);
            }else{
                statusAviso = 'danger';
                if(response.msj == 'No existe el plan de pagos activo para el lote proporcionado'){
                    cancelaPlanCRM(idPlanPago);
                }
            }
            alerts.showNotification('top', 'right', "[NEODATA] "+response.msj, statusAviso);
            $('#cancelarPlanPago').modal('toggle');
        }
    });
    $('#tablaPlanPagos').DataTable().ajax.reload();
});

function cancelaPlanCRM(idPlanPago){
    $.ajax({
        data:{idPlanPago:idPlanPago},
        url: 'cancelaPlanPagoCRM',
        type: 'POST',
        success: function (response) {
            response = JSON.parse(response);
            let statusAviso;
            if(response.status === 1 || response.status === true){//status de la transacción general
                statusAviso = 'success';
                //actualizar el plan de pago en CRM
            }else{
                statusAviso = 'danger';
            }
            alerts.showNotification('top', 'right', "[CRM] "+response.msj, statusAviso);
            $('#tablaPlanPagos').DataTable().ajax.reload();
        }
    });
}