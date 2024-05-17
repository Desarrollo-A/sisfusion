let idLote = 0;

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
        $.post(`${general_base_url}Contratacion/lista_lotes/${index_idCondominio}`, function (data) {
            for (var i = 0; i < data.length; i++) {
                $("#idLote").append($('<option>').val(data[i]['idLote']).text(data[i]['nombreLote']));
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
    $('#spiner-loader').removeClass('hide');
    $('#tablaPlanPagos').removeClass('hide');
    index_idLote = $(this).val();
    idLote = index_idLote;
    console.log('index_idLote', index_idLote);
    //tablaPlanPagos
    tablaPlanPagos = $("#tablaPlanPagos").DataTable({
        dom: "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'B><'col-12 col-sm-12 col-md-6 col-lg-6 p-0'f>rt>"+"<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        destroy: true,
        searching: true,
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
            title: 'Inventario lotes',
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
        fixedColumns: true,
        columns: [{
            data: 'nombreResidencial'
            },
            {
                data: 'nombreCondominio'
            },
            { data: 'nombreLote' },
            { data: 'idLote' },
            { data: 'numeroPeriodos' },
            /***********/
            {
                data: function (d) {
                    return `<center><button class="btn-data btn-blueMaderas ver_historial" value="${d.idLote}" data-nomLote="${d.nombreLote}" data-tipo-venta="${d.tipo_venta}" data-toggle="tooltip" data-placement="left" title="VER MÁS INFORMACIÓN"><i class="fas fa-history"></i></button></center>`;
                }
            }],
        initComplete: function() {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
    $('#spiner-loader').addClass('hide');

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
                        loadInputsCatalogos(dto);

                        $('#addPlanPago').modal('show');
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
    dto.dtoCatalogos.map((catalogoOpciones) => {
        if (catalogoOpciones.id_catalogo == 137) // PLAN DE PAGO
            $("#tipoPP").append(`<option value="${catalogoOpciones.id_opcion}" data-FormaPgo="${catalogoOpciones.nombre}">${catalogoOpciones.nombre}</option>`);
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
    $.ajax({
        type: 'POST',
        url: `${general_base_url}Corrida/guardaPlanPago`,
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
                        cerrarModalAddPlan();
                        alerts.showNotification("top", "right", dto.mensaje, "success");
                        tablaPlanPagos.ajax.reload();
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

}

$(document).on('change','#tipoPP', function(){
    let tipoPlanTxtPP = document.getElementById('tipoPlanTxtPP');
    tipoPlanTxtPP.value = $(this).find("option:selected").attr('data-FormaPgo');
});

function cerrarModalAddPlan() {
    $("#tipoPP").html("");
    $("#descripcionPlanPago").val();
    $("#monedaPP").html("");
    $("#montoPP").val();
    $("#tazaInteresPP").val();
    $("#noPeriodosPP").val();
    $("#periocidadPP").html("");
    $("#fechaInicioPP").val();
    $("#mensualidadPP").val();
    $("#porcentajeIvaPP").val();
    $("#cantidadIvaPP").val();

    $("#tipoPP").selectpicker('refresh');
    $("#monedaPP").selectpicker('refresh');
    $("#periocidadPP").selectpicker('refresh');
    $('#addPlanPago').modal('hide');
    cont_eng = 0;
}
