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
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
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
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
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
        { "data": "nombreResidencial" },
        { "data": "nombreCondominio" },
        { "data": "nombreLote" },
        { "data": "idLote" },
        { "data": "cliente" },
        { "data": "nombreAsesor" },
        { "data": "nombreCoordinador" },
        { "data": "nombreGerente" },
        { "data": "nombreSubdirector" },
        { "data": "nombreRegional" },
        { "data": "nombreRegional2" },
        { "data": "fechaApartado" },
        { "data": "sup"},
        {
            "data": function (d) {
                if( d.costom2f == 'SIN ESPECIFICAR')
                    return d.costom2f;
                else
                    return `$${formatMoney(d.costom2f)}`;
            }
        },
        {
            "data": function (d) {
                return `$${formatMoney(d.total)}`;
            }
        },
        {
            "data": function (d) {
                let btns = '';
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
                return `<div class="d-flex justify-center">${btns}</div>`;
            }
        }
    ],
    ajax: {
        url: `${general_base_url}reestructura/getListaClientesReubicar`,
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

$(document).on('click', '.btn-reubicar', function () {
    const tr = $(this).closest('tr');
    const row = $('#reubicacionClientes').DataTable().row(tr);
    const nombreCliente = row.data().cliente;
    const nombreLote = row.data().nombreLote;
    const superficie = row.data().sup;
    const total = row.data().total;
    const idProyecto = $(this).attr("data-idProyecto");
    const tipoLote = $(this).attr("data-tipoLote");
    const idCliente = $(this).attr("data-idCliente");

    changeSizeModal('modal-md');
    appendBodyModal(`
        <form method="post" id="formReubicar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="m-0">Reubicación del cliente</h3>
                        <h6 class="m-0">${nombreCliente}</h6>
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
                </div>
                <div class="row mt-2">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="p-2 pt-1" style="background-color: #eaeaea; border-radius:15px">
                            <h5 class="text-center">LOTE ACTUAL</h5>
                            <span class="w-100 d-flex justify-between">
                                <p class="m-0">Lote</p>
                                <p class="m-0"><b>${nombreLote}</b></p>
                            </span>
                            <span class="w-100 d-flex justify-between">
                                <p class="m-0">Superficie</p>
                                <p class="m-0"><b>${superficie}</b></p>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row mt-2" id="infoLoteSeleccionado">
                </div>
                <input type="hidden" id="superficie" value="${superficie}">
                <input type="hidden" id="tipoLote" value="${tipoLote}">
                <input type="hidden" id="idCliente" name="idCliente" value="${idCliente}">
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

$(document).on("change", "#proyectoAOcupar", function(e){
    $('#spiner-loader').removeClass('hide');
    $("#infoLoteSeleccionado").html("");
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
    $("#infoLoteSeleccionado").html("");
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
    $("#infoLoteSeleccionado").html("");
    const $itself = $(this).find(':selected');
    const nombre = $itself.attr("data-nombre");
    const superficie = $itself.attr("data-superficie");
    const total = $itself.attr("data-total");
    const html = `
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <div class="p-2 pt-1" style="background-color: #eaeaea; border-radius:15px">
                <h5 class="mb-0 mt-2 text-center">LOTE SELECCIONADO</h5>
                <span class="w-100 d-flex justify-between">
                    <p class="m-0">Lote</p>
                    <p class="m-0"><b>${nombre}</b></p>
                </span>
                <span class="w-100 d-flex justify-between">
                    <p class="m-0">Superficie</p>
                    <p class="m-0"><b>${superficie}</b></p>
                </span>
            <div>
        <div>
    `; 
    
    $("#infoLoteSeleccionado").append(html);
})

$(document).on("submit", "#formReubicar", function(e){
    $('#spiner-loader').removeClass('hide');
    e.preventDefault();
    let data = new FormData($(this)[0]);
    $.ajax({
        url : 'setReubicacion',
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
