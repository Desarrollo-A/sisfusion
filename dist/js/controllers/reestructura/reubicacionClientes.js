const TIPO_LOTE = Object.freeze({
    HABITACIONAL: 0,
    COMERCIAL: 1
});

const PROYECTO = Object.freeze({
    NORTE: 21,
    PRIVADAPENINSULA: 25
});

const STATUSLOTE = Object.freeze({
    DISPONIBLE : 1,
    CONTRATADO : 2,
    APARTADO : 3,
    ENGANCHE : 4,
    INTERCAMBIO : 6,
    DIRECCIÓN : 7,
    BLOQUEO : 8,
    CONTRATADO_POR_INTERCAMBIO : 9,
    APARTADO_CASAS : 10,
    DONACIÓN : 11,
    INTERCAMBIO_ESCRITURADO : 12,
    DISPONIBLE_REUBICACIÓN : 15,
    PARTICULAR : 102,
    APARTADO_REUBICACIÓN : 16,
});

const ESTATUS_PREPROCESO = ['PENDIENTE CARGA DE PROPUESTAS', 'REVISIÓN DE PROPUESTAS', 'ELABORACIÓN DE CORRIDAS', 'ELABORACIÓN DE CONTRATO Y RESICISIÓN', 'DOCUMENTACIÓN ENTREGADA', 'RECEPCIÓN DE DOCUMENTOS CONFIRMADA'];

let titulosTabla = [];
$('#reubicacionClientes thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    titulosTabla.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($('#reubicacionClientes').DataTable().column(i).search() !== this.value) {
            $('#reubicacionClientes').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
});

$('#reubicacionClientes').DataTable({
    dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: '100%',
    scrollX: true,
    buttons: [{
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Lotes para reubicar',
        title:"Lotes para reubicar",
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            format: {
                header: function (d, columnIdx) {
                    return ' ' + titulosTabla[columnIdx] + ' ';
                }
            }
        }
    },
    {
        extend: 'pdfHtml5',
        text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
        className: 'btn buttons-pdf',
        titleAttr: 'Lotes para reubicar',
        title:"Lotes para reubicar",
        orientation: 'landscape',
        pageSize: 'LEGAL',
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
            format: {
                header: function (d, columnIdx) {
                    return ' ' + titulosTabla[columnIdx] + ' ';
                }
            }
        }
    }],
    columnDefs: [{
        searchable: false,
        visible: false
    }],
    pageLength: 10,
    bAutoWidth: false,
    fixedColumns: true,
    ordering: false,
    language: {
        url: general_base_url+"static/spanishLoader_v2.json",
        paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>"
        }
    },
    order: [[4, "desc"]],
    destroy: true,
    columns: [
        { data: "nombreResidencial" },
        { data: "nombreCondominio" },
        { data: "nombreLote" },
        { data: "idLote" },
        { data: "cliente" },
        { data: "nombreAsesor" },
        { data: "nombreCoordinador" },
        { data: "nombreGerente" },
        { data: "nombreSubdirector" },
        { data: "nombreRegional" },
        { data: "nombreRegional2" },
        { data: "fechaApartado" },
        { data: "sup"},
        {
            data: function (d) {
                if( d.costom2f == 'SIN ESPECIFICAR')
                    return d.costom2f;
                else
                    return `$${formatMoney(d.costom2f)}`;
            }
        },
        {
            data: function (d) {
                return `$${formatMoney(d.total)}`;
            }
        },
        {
            data: function (d) {
                return `<span class='label lbl-violetBoots'>${d.estatusPreproceso}</span>`;
            }
        },
        { data: "nombreAsesorAsignado"},
        {
            data: function (d) {
                let btns = '';
                const BTN_PROPUESTAS =  `<button class="btn-data btn-blueMaderas btn-asignar-propuestas"
                            data-toggle="tooltip" 
                            data-placement="left"
                            title="${d.id_estatus_preproceso == 0 ? 'ASIGNAR PROPUESTAS' : 'ACTUALIZAR PROPUESTAS'}"
                            data-idCliente="${d.idCliente}">
                            <i class="fas fa-user-edit"></i>
                    </button>`;
                const BTN_AVANCE =  `<button class="btn-data btn-green btn-avanzar"
                    data-toggle="tooltip" 
                    data-placement="left"
                    title="ENVIAR A ${ESTATUS_PREPROCESO[d.id_estatus_preproceso + 1]}"
                    data-idCliente="${d.idCliente}"
                    data-tipoTransaccion="${d.id_estatus_preproceso}">
                    <i class="fas fa-thumbs-up"></i>
                </button>`;
                const BTN_SUBIR_ARCHIVO =  `<button class="btn-data btn-blueMaderas btn-cargar-documentos"
                    data-toggle="tooltip" 
                    data-placement="left"
                    title="CARGAR DOCUMENTACIÓN"
                    data-idCliente="${d.idCliente}"
                    data-tipoTransaccion="${d.id_estatus_preproceso}">
                    <i class="fas fa-upload"></i>
                </button>`;

                if (d.id_estatus_preproceso == 0 && id_rol_general == 3) // Gerente: PENDIENTE CARGA DE PROPUESTAS
                    btns += BTN_PROPUESTAS;
                else if (d.id_estatus_preproceso == 1 && id_rol_general == 3) // Gerente: REVISIÓN DE PROPUESTAS
                    btns += BTN_PROPUESTAS + BTN_AVANCE;
                else if (d.id_estatus_preproceso == 2 && id_rol_general == 17) { // Contraloría: ELABORACIÓN DE CORRIDAS
                    if (d.totalCorridas == 3)
                        btns += BTN_AVANCE;
                    btns += BTN_SUBIR_ARCHIVO
                }
                else if (d.id_estatus_preproceso == 3 && id_rol_general == 15) { // Jurídico: ELABORACIÓN DE CONTRATO Y RESICISIÓN
                    if (d.totalContratos == 3 && d.totalRescision == 1)
                        btns += BTN_AVANCE;
                    btns += BTN_SUBIR_ARCHIVO
                }
                else if (d.id_estatus_preproceso == 4 && id_rol_general == 6) // Asistente gerente: DOCUMENTACIÓN ENTREGADA
                    btns += BTN_AVANCE;
                else if (d.id_estatus_preproceso == 5) { // EEC: CONFIRMACIÓN DE RECEPCIÓN DE DOCUMENTOS
                    if(d.idProyecto == PROYECTO.NORTE || d.idProyecto == PROYECTO.PRIVADAPENINSULA){
                        btns +=  `<button class="btn-data btn-sky btn-reestructurar"
                                data-toggle="tooltip" 
                                data-placement="left"
                                title="REESTRUCTURAR"
                                data-idCliente="${d.idCliente}">
                                <i class="fas fa-map-marker"></i>
                        </button>`;
                    }
                    btns += `<button class="btn-data btn-green btn-reubicar"
                            data-toggle="tooltip" 
                            data-placement="left"
                            title="REUBICAR CLIENTE"
                            data-idCliente="${d.idCliente}"
                            data-idProyecto="${d.idProyecto}"
                            data-tipoLote="${d.tipo_lote}">
                        <i class="fas fa-route"></i>
                    </button>`;
                }
                btns += `<button class="btn-data btn-blueMaderas infoUser" data-toggle="tooltip" data-placement="top" data-idCliente="${d.idCliente}" data-idLote="${d.idLote}" title="HISTORIAL"><i class="fas fa-user-edit"></i></button>`
                return `<div class="d-flex justify-center">${btns}</div>`;
            }
        }
    ],
    ajax: {
        url: `${general_base_url}Reestructura/getListaClientesReubicar`,
        dataSrc: "",
        type: "POST",
        cache: false,
    },
    initComplete: function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    },
});

$(document).on('click', '.btn-reestructurar', function () {
    const tr = $(this).closest('tr');
    const row = $('#reubicacionClientes').DataTable().row(tr);
    const idCliente = $(this).attr("data-idCliente");
    const nombreCliente = row.data().cliente;
    const nombreLote = row.data().nombreLote;

    changeSizeModal('modal-md');
    appendBodyModal(`
        <form method="post" id="formReestructura">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="m-0">Restructuración del cliente</h3>
                        <h6 class="m-0">${nombreCliente}</h6>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-2">
                        <p class="text-center">¿Estás seguro que deseas reestructurar el lote <b>${nombreLote}</b>? <br>Recuerda que al realizar este movimiento, el lote sufrirá algunos cambios al confirmar.</p>
                        <input type="hidden" id="idCliente" name="idCliente" value="${idCliente}">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-end">
                        <button type="button" class="btn btn-simple btn-danger" onclick="hideModal()">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </div>
            </div>
        </form>`);
    showModal();
});

$(document).on('click', '.btn-propuestas', function () {
    const tr = $(this).closest('tr');
    const row = $('#reubicacionClientes').DataTable().row(tr);
    const nombreCliente = row.data().cliente;
    const nombreLote = row.data().nombreLote;
    const superficie = row.data().sup;
    const idProyecto = $(this).attr("data-idProyecto");
    const tipoLote = $(this).attr("data-tipoLote");
    const idCliente = $(this).attr("data-idCliente");
    const idLoteOriginal = row.data().idLote;

    changeSizeModal('modal-md');
    appendBodyModal(`
        <form method="post" id="formReubicarProp">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="m-0">Reubicación</h3>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <p class="m-0 text-center">Cliente. ${nombreCliente}</p>
                        <p class="m-0 text-center">Lote. ${nombreLote}</p>
                        <p class="m-0 text-center">Superficie. ${superficie}</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 overflow-hidden">
                        <label class="lbl-gral">Proyecto</label>
                        <select name="proyectoAOcupar" title="SELECCIONA UNA OPCIÓN" id="proyectoAOcupar" class="selectpicker m-0 select-gral" data-live-search="true" data-container="body" data-width="100%">
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 overflow-hidden">
                        <label class="lbl-gral">Condominio</label>
                        <select name="condominioAOcupar" title="SELECCIONA UNA OPCIÓN" id="condominioAOcupar" class="selectpicker m-0 select-gral" data-live-search="true" data-container="body" data-width="100%">
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 overflow-hidden">
                        <label class="lbl-gral">Lote</label>
                        <select name="loteAOcupar" title="SELECCIONA UNA OPCIÓN" id="loteAOcupar" class="selectpicker m-0 select-gral" data-live-search="true" data-container="body" data-width="100%">
                        </select>
                    </div>
                    <div class="col-12 col-sm-9 col-md-9 col-lg-9">
                    </div>
                    <div class="col-12 col-sm-3 col-md-3 col-lg-3">
                        <button type="button" id="btnAddPropuesta" class="btn btn-gral d-none">Añadir</button>
                    </div>
                </div>
                <div class="row mt-2" id="infoLotesSeleccionados">
                </div>
                <input type="hidden" id="superficie" value="${superficie}">
                <input type="hidden" id="tipoLote" value="${tipoLote}">
                <input type="hidden" id="idCliente" name="idCliente" value="${idCliente}">
                <input type="hidden" id="idLoteOriginal" name="idLoteOriginal" value="${idLoteOriginal}">
                <div class="row mt-2">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-end">
                        <button type="button" class="btn btn-simple btn-danger" onclick="hideModal()">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </div>
            </div>
        </form>
    `);
    showModal();

    getProyectosAOcupar(idProyecto, superficie, tipoLote);
    getPropuestas(idLoteOriginal);
});

$(document).on('click', '.infoUser', function (){
    $('#idCliente').val($(this).attr('data-idCliente'));
    $('#idLote').val($(this).attr('data-idLote'));
    $('#ineCLi').val('');
    $("#estadoCli").empty();

    var idCliente = $("#idCliente").val();

    $.getJSON("getCliente/" + idCliente, function(data) {
        $('#nombreCli').val(data.nombre);
        $('#apellidopCli').val(data.apellido_paterno);
        $('#apellidomCli').val(data.apellido_materno);
        $('#telefonoCli').val(data.telefono1);
        $('#correoCli').val(data.correo);
        $('#domicilioCli').val(data.domicilio_particular);
        $("#estadoCli").append($('<option selected>').val(data.idEstadoC).text(data.estado_civil));
        $('#ocupacionCli').val(data.ocupacion);

        $.post("getEstadoCivil", function(data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['id_opcion'];
                var name = data[i]['nombre'];

                if(id == data.idEstadoC){
                    $("#estadoCli").append($('<option selected>').val(id).text(name.toUpperCase()));    
                }else{
                    $("#estadoCli").append($('<option>').val(id).text(name.toUpperCase()));
                }
            }
            $("#estadoCli").selectpicker('refresh');
        }, 'json');

        $('#clienteConsulta').modal();
    }, 'json');
});

$(document).on('click', '#guardarCliente', function (){
    var idLote = $('#idLote').val();
    var nombreCli = $('#nombreCli').val();
    var apellidopCli = $('#apellidopCli').val();
    var apellidomCli = $('#apellidomCli').val();
    var telefonoCli = $('#telefonoCli').val();
    var correoCli = $('#correoCli').val();
    var domicilioCli = $('#domicilioCli').val();
    var estadoCli = $('#estadoCli').val();
    var ineCLi = $('#ineCLi').val();
    var ocupacionCli = $('#ocupacionCli').val();

    if(ineCLi == ''){
        alerts.showNotification("top", "right", "Captura el numero INE", "warning");
        return;
    }

    if (telefonoCli == '' || telefonoCli == null){
        alerts.showNotification("top", "right", "Captura el numero de telefono", "warning");
        return;
    }

    if (correoCli == '' || correoCli == null){
        alerts.showNotification("top", "right", "Captura el correo", "warning");
        return;
    }
    
    if (domicilioCli == '' || domicilioCli == null){
        alerts.showNotification("top", "right", "Captura el domicilio", "warning");
        return;
    }

    if(ocupacionCli == '' || ocupacionCli == null){
        alerts.showNotification("top", "right", "Captura la ocupación", "warning");
        return;
    }

    var datos = new FormData();
    datos.append("idLote", idLote);
    datos.append("nombreCli", nombreCli);
    datos.append("apellidopCli", apellidopCli);
    datos.append("apellidomCli", apellidomCli);
    datos.append("telefonoCli", telefonoCli);
    datos.append("correoCli", correoCli);
    datos.append("domicilioCli", domicilioCli);
    datos.append("estadoCli", estadoCli);
    datos.append("ineCLi", ineCLi);
    datos.append("ocupacionCli", ocupacionCli);

    $.ajax({
        method: 'POST',
        url: general_base_url + 'Reestructura/insetarCliente',
        data: datos,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data == 1) {
            $('#clienteConsulta').modal('hide');
            alerts.showNotification("top", "right", "Información capturada con exito.", "success");
            $('#ineCLi').val('');
            $('#telefonoCli').val('');
            $('#correoCli').val('');
            $('#domicilioCli').val('');
            $('#ocupacionCli').val('');
            }
        },
        error: function(){
            $('#aceptarReestructura').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

function getProyectosAOcupar(idProyecto, superficie, tipoLote) {
    $('#spiner-loader').removeClass('hide');
    $.post("getProyectosDisponibles", {"idProyecto" : idProyecto, "superficie" : superficie, "tipoLote": tipoLote}, function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['proyectoReubicacion'];
            var name = data[i]['descripcion'];
            var disponible = data[i]['disponibles'];
            $("#proyectoAOcupar").append($('<option>').val(id).text(name +' ('+ disponible + ')'));
        }
        $('#spiner-loader').addClass('hide');
        $("#proyectoAOcupar").selectpicker('refresh');
    }, 'json');
}

function getPropuestas(idLoteOriginal){
    $('#spiner-loader').removeClass('hide');
    $.post("obtenerPropuestasXLote", {"idLoteOriginal" : idLoteOriginal}, function(data) {
        for (let lote of data) {
            let html = divLotesSeleccionados(lote.nombreLote, lote.sup, lote.id_lotep);
            $("#infoLotesSeleccionados").append(html);
        }
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

$(document).on("change", "#proyectoAOcupar", function(e){
    $('#spiner-loader').removeClass('hide');
    $("#condominioAOcupar").html("");
    $("#loteAOcupar").html("");
    $("#loteAOcupar").selectpicker('refresh');
    idProyecto = $(this).val();
    superficie = $("#superficie").val();
    tipoLote = $("#tipoLote").val();
    $.post("getCondominiosDisponibles", {"idProyecto": idProyecto, "superficie": superficie, "tipoLote": tipoLote}, function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idCondominio'];
            var name = data[i]['nombre'];
            var disponible = data[i]['disponibles'];
            $("#condominioAOcupar").append($('<option>').val(id).text(name +' ('+ disponible + ')'));
        }
        $('#spiner-loader').addClass('hide');
        $("#condominioAOcupar").selectpicker('refresh');
    }, 'json');
});

$(document).on("change", "#condominioAOcupar", function(e){
    $('#spiner-loader').removeClass('hide');
    $("#loteAOcupar").html("");
    idCondominio = $(this).val();
    superficie = $("#superficie").val();

    $.post("getLotesDisponibles", {"idCondominio": idCondominio, "superficie": superficie}, function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idLote'];
            var name = data[i]['nombreLote'];
            var precioMetro = data[i]['precio'];
            var superficie = data[i]['sup'];
            var total = data[i]['total'];
            var a_favor = data[i]['a_favor'];
            $("#loteAOcupar").append($('<option>').val(id).attr('data-nombre', name).attr('data-precioMetro', precioMetro).attr('data-superficie', superficie).attr('data-total', total).addClass('green').text(name +' ('+ a_favor + ')'));
        }
        $('#spiner-loader').addClass('hide');
        $("#loteAOcupar").selectpicker('refresh');
    }, 'json');
});

$(document).on("change", "#loteAOcupar", function(e){
    $('#btnAddPropuesta').removeClass('d-none');
})

function removeLote(e){
    let divLote = e.closest( '.lotePropuesto' );
    divLote.remove();
}

$(document).on("click", "#btnAddPropuesta", function(e){
    const $itself = $("#loteAOcupar").find(':selected');
    const numberLotes = $('#infoLotesSeleccionados .lotePropuesto').length;
    const idLotes = document.getElementsByClassName('idLotes');
    let existe = false;
    for (let idLote of idLotes) {
        if(idLote.value == $itself.val()){
            existe = true;
        };
    }

    if(existe){
        alerts.showNotification("top", "right", "El lote ya ha sido agregado", "danger");
        return;
    }
    if ( numberLotes <= 2 ){
        const nombreLote = $itself.attr("data-nombre");
        const superficie = $itself.attr("data-superficie");
        const idLote = $itself.val();
        const html = divLotesSeleccionados(nombreLote, superficie, idLote);
        
        $("#infoLotesSeleccionados").append(html);
    }
    else{
        alerts.showNotification("top", "right", "No puedes seleccionar más de tres lotes", "danger");
    }
});

function divLotesSeleccionados(nombreLote, superficie, idLote){
    html = `
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-2 lotePropuesto">
            <div class="p-2 pt-1" style="background-color: #eaeaea; border-radius:15px">
                <div class="d-flex justify-between">
                    <h5 class="mb-0 mt-2 text-center">LOTE SELECCIONADO</h5>
                    <button type="button" class="fl-r" onclick="removeLote(this)" style="color: gray; background-color:transparent; border:none;" title="Eliminar selección"><i class="fas fa-times"></i></button>
                </div>
                <span class="w-100 d-flex justify-between">
                    <p class="m-0">Lote</p>
                    <p class="m-0"><b>${nombreLote}</b></p>
                </span>
                <span class="w-100 d-flex justify-between">
                    <p class="m-0">Superficie</p>
                    <p class="m-0"><b>${superficie}</b></p>
                </span>
                <input type="hidden" class="idLotes" name="idLotes[]" value="${idLote}">
            <div>
        <div>
    `;

    return html;
}


$(document).on("submit", "#formReubicarProp", function(e){
    e.preventDefault();
    const numberLotes = $('#infoLotesSeleccionados .lotePropuesto').length;
    if(numberLotes < 3){
        alerts.showNotification("top", "right", "Debes seleccionar 3 lotes", "danger");
        return;
    }
    else{
        $('#spiner-loader').removeClass('hide');
        let data = new FormData($(this)[0]);
        $.ajax({
            url : 'setPropuestasLotes',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST', 
            success: function(data){
                data = JSON.parse(data);
                alerts.showNotification("top", "right", ""+data.message+"", ""+data.color+"");
                $('#spiner-loader').addClass('hide');
                hideModal();
            },
            error: function( data ){
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                hideModal();
            }
        });
    }
});

$(document).on("submit", "#formReestructura", function(e){
    $('#spiner-loader').removeClass('hide');
    e.preventDefault();
    let data = new FormData($(this)[0]);
    $.ajax({
        url : 'setReestructura',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST', 
        success: function(data){
            data = JSON.parse(data);
            console.log(data);
            alerts.showNotification("top", "right", ""+data.message+"", ""+data.color+"");
            $('#reubicacionClientes').DataTable().ajax.reload();
            $('#spiner-loader').addClass('hide');
            hideModal();
        },
        error: function( data ){
            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            hideModal();
        }
    });
});

$(document).on('click', '.btn-avanzar', function () {
    const tr = $(this).closest('tr');
    const row = $('#reubicacionClientes').DataTable().row(tr);
    const nombreLote = row.data().nombreLote;
    const idLote = row.data().idLote;
    const tipoTransaccion = $(this).attr("data-tipoTransaccion");
    changeSizeModal('modal-sm');
    appendBodyModal(`
        <form method="post" id="formAvanzarEstatus">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <h6 class="m-0">¿Estás seguro de envíar el lote <b>${nombreLote}</b> a <b><i>${ESTATUS_PREPROCESO[parseInt(tipoTransaccion) + 1]}</i></b></h6>
                    </div>                
                    <input type="hidden" id="idLote" name="idLote" value="${idLote}">
                    <input type="hidden" id="tipoTransaccion" name="tipoTransaccion" value="${tipoTransaccion}">
                    <div class="row mt-2">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-end">
                            <button type="button" class="btn btn-simple btn-danger" onclick="hideModal()">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Aceptar</button>
                        </div>
                    </div>
            </div>
        </form>
    `);
    showModal();
});

$(document).on("submit", "#formAvanzarEstatus", function(e){
    $('#spiner-loader').removeClass('hide');
    e.preventDefault();
    let data = new FormData();
    data.append("idLote", $("#idLote").val());
    data.append("tipoTransaccion", $("#tipoTransaccion").val());
    $.ajax({
        url : 'setAvance',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST', 
        success: function(data){
            alerts.showNotification("top", "right", "El registro se ha avanzado con éxito.", "success");
            $('#reubicacionClientes').DataTable().ajax.reload();
            $('#spiner-loader').addClass('hide');
            hideModal();
        },
        error: function( data ){
            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            hideModal();
        }
    });
});
