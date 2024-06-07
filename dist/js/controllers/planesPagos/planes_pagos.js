let idLote = 0;
let dumpPlanPago = [];

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
    $('#spiner-loader').removeClass('hide');
    $.post(general_base_url+"Corrida/getInfoByLote/"+idLote, function (data) {
        $('#nombreCliente').val(data[0].nombre+' '+data[0].apellido_paterno+' '+data[0].apellido_materno);
        $('#spiner-loader').addClass('hide');
    }, 'json');


    tablaPlanPagos = $("#tablaPlanPagos").DataTable({
        dom: "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'B><'col-12 col-sm-12 col-md-6 col-lg-6 p-0'f>rt>"+"<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
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
            /***********/
            {
                data: function (d) {
                    let BTN_VER = `<button class="btn-data btn-blueMaderas ver_planPago" value="${d.idLote}" 
                    data-nomLote="${d.nombreLote}" data-idplanPago="${d.idPlanPago}" data-nombrePlan="${d.nombrePlan}" 
                    data-toggle="tooltip" data-placement="left" title="VER PLAN"><i class="fas fa-eye"></i></button>`;

                    let BTN_EDIT = `<button class="btn-data btn-blueMaderas editarPago" value="${d.idLote}" 
                    data-nomLote="${d.nombreLote}" data-idplanPago="${d.idPlanPago}" data-nombrePlan="${d.nombrePlan}" 
                    data-toggle="tooltip" data-placement="left" title="EDITAR PLAN"><i class="fas fa-pencil-alt"></i></button>`;

                    return `<center>${BTN_VER} ${BTN_EDIT}</center>`;
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
    cerrarModalAddPlan();
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

    generarPlanPagoFunction();
    let formulario =  new FormData(this);
    formulario.append("dumpPlanPago", dumpPlanPago);
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
    if(tipoPP==1){
        tazaInteresPP.attr('readonly','true');
        tazaInteresPP.val(0);
        interesesSSI.attr('disabled', 'disabled');
    }else{
        tazaInteresPP.removeAttr('readonly');
        tazaInteresPP.val(0);
        interesesSSI.removeAttr('disabled');
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
}

function generarPlanPagoFunction(){
    //let tipoPP = $('#tipoPP').empty().selectpicker('refresh');
    let fechaInicio = $('#fechaInicioPP').val();
    let noPeriodosPP = $('#noPeriodosPP').val();
    let periocidadPP = $('#periocidadPP').val();
    let tazaInteresPP = $('#tazaInteresPP').val();
    let planPago = $('#planPago').val();
    let montoPP = $('#montoPP').val().replace("$", '');
    let mensualidadPP = $('#mensualidadPP').val().replace("$", '');
    montoPP = parseFloat(montoPP.replace(",", ''));
    let interesesSSI = document.getElementById('interesesSSI').checked;
    let ivaPP = document.getElementById('ivaPP').checked;
    let porcentajeIva = document.getElementById('porcentajeIvaPP').value;
    dumpPlanPago = generarPlanPago(fechaInicio, noPeriodosPP, montoPP, tazaInteresPP, periocidadPP, tipoPP, planPago, mensualidadPP, interesesSSI, ivaPP, porcentajeIva);
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
                title: 'Master cobranza',
                titleAttr: 'Descargar archivo de Excel',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10],
                    format: {
                        header: function (d, columnIdx) {
                            return ' '+titulos_encabezado[columnIdx] +' ';
                        }
                    }
                }
            },
            {
                text: "<i class='fas fa-pencil-alt' aria-hidden='true'></i>",
                titleAttr: 'Editar plan de pago',
                className: "btn  buttons-pdf editarPlanPago",
            },
            {
                text: "<i class='fas fa-check' aria-hidden='true'></i>",
                titleAttr: 'Enviar planes de pago',
                className: "btn btn-azure  enviarPlanPago",
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
                data: function (d) {
                    return d.fecha;
                }
            },
            {
                data: function (d) {
                    if(d.capital){
                        return d.capital.toFixed(2);
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
                    return formatMoney((d.interes).toFixed(2));
                }
            },
            {
                data: function (d) {
                    return formatMoney((d.saldoInteres).toFixed(2));
                }
            },
            {
                data: function (d) {
                    return formatMoney((d.iva).toFixed(2));
                }
            },
            {
                data: function (d) {
                    return formatMoney((d.saldoIva).toFixed(2));
                }
            },
            {
                data: function (d) {
                    return formatMoney((d.total).toFixed(2));
                }
            },
            {
                data: function (d) {
                    return formatMoney((d.saldo).toFixed(2));
                }
            },
        ],
        columnDefs: [{
            targets: [2],
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

function enviarPlanPago(idLote){
    console.log('se enviara el plan de pago actual');
    console.log('idLote xxD', idLote);

    $.post(general_base_url+"Corrida/enviarPlanPago/"+idLote, function (data) {

    }, 'json');
}

$(document).on('click', '.editarPago', function(){
   console.log('acciones para editar el plan de pago');
});