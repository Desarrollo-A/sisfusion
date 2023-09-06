let titulosTabla = [];

$(document).ready(function () {
    fillTable();
});

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

function fillTable() {
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
                    return `<div class="d-flex justify-center">
                        <button class="btn-data btn-sky btn-reubicar"
                                data-toggle="tooltip" 
                                data-placement="left"
                                title="REUBICAR CLIENTE"
                                data-idCliente="${d.idCliente}"
                                data-idProyecto="${d.idProyecto}"
                        >
                            <i class="fas fa-route"></i>
                        </button>
                    </div>`;
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
}

$(document).on('click', '.btn-reubicar', function () {
    const tr = $(this).closest('tr');
    const row = $('#reubicacionClientes').DataTable().row(tr);
    changeSizeModal('modal-md');
    appendBodyModal(`
        <div class="row">
            <div class="col-12 text-center">
                <h3>Reubicación del cliente</h3>
            </div>
            <div class="col-12 col-sm-4 col-md-4 col-lg-4 overflow-hidden">
                <label class="lbl-gral">Proyecto</label>
                <select name="proyectoAOcupar" title="SELECCIONA UNA OPCIÓN" id="proyectoAOcupar" class="selectpicker m-0 select-gral" data-live-search="true" data-container="body" data-width="100%">
                </select>
            </div>
            <div class="col-12 col-sm-4 col-md-4 col-lg-4 overflow-hidden">
                <label class="lbl-gral">Condominio</label>
                <select name="condominioAOcupar" title="SELECCIONA UNA OPCIÓN" id="condominioAOcupar" class="selectpicker m-0 select-gral" data-live-search="true" data-container="body" data-width="100%">
                </select>
            </div>
            <div class="col-12 col-sm-4 col-md-4 col-lg-4 overflow-hidden">
                <label class="lbl-gral">Lote</label>
                <select name="loteAOcupar" title="SELECCIONA UNA OPCIÓN" id="loteAOcupar" class="selectpicker m-0 select-gral" data-live-search="true" data-container="body" data-width="100%">
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <h5 class="mb-0 mt-2">Lote actual</h5>
                <span class="w-100 d-flex justify-between">
                    <label class="m-0">Cliente</label>
                    <label class="m-0">${row.data().cliente}</label>
                </span>
                <span class="w-100 d-flex justify-between">
                    <label class="m-0">Lote</label>
                    <label class="m-0">${row.data().nombreLote}</label>
                </span>
                <span class="w-100 d-flex justify-between">
                    <label class="m-0">Superficie</label>
                    <label class="m-0">${row.data().nombreLote}</label>
                </span>
                <span class="w-100 d-flex justify-between">
                    <label class="m-0">Total</label>
                    <label class="m-0">${row.data().total}</label>
                </span>
            <div>
            <div class="container-fluid" id="infoLoteSeleccionado">
            <div>
        </div>
    `);
    appendFooterModal(`
        <button type="button" class="btn btn-simple btn-danger" onclick="hideModal()">Cancelar</button>
        <button type="button" class="btn btn-primary">Aceptar</button>
    `);
    getProyectosAOcupar();
    showModal();
});

function getProyectosAOcupar() {
    $('#spiner-loader').removeClass('hide');
    $.post("getProyectosDisponibles", function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idProyecto'];
            var name = data[i]['descripcion'];
            $("#proyectoAOcupar").append($('<option>').val(id).text(name));
        }
        $('#spiner-loader').addClass('hide');
        $("#proyectoAOcupar").selectpicker('refresh');
    }, 'json');
}

$(document).on("change", "#proyectoAOcupar", function(e){
    $('#spiner-loader').removeClass('hide');
    $("#condominioAOcupar").html("");
    idProyecto = $(this).val();
    $.post("getCondominiosDisponibles", {"idProyecto": idProyecto}, function(data) {
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
    $.post("getLotesDisponibles", {"idCondominio": idCondominio}, function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idLote'];
            var name = data[i]['nombreLote'];
            var precioMetro = data[i]['precio'];
            var superficie = data[i]['sup'];
            var total = data[i]['total'];
            $("#loteAOcupar").append($('<option>').val(id).attr('data-nombre', name).attr('data-precioMetro', precioMetro).attr('data-superficie', superficie).attr('data-total', total).text(name));
        }
        $('#spiner-loader').addClass('hide');
        $("#loteAOcupar").selectpicker('refresh');
    }, 'json');
});

$(document).on("change", "#loteAOcupar", function(e){
    const $itself = $(this);
    const nombre = $itself.attr("data-nombre");
    const precioMetro = $itself.attr("data-precioMetro");
    const superficie = $itself.attr("data-superficie");
    const total = $itself.attr("data-total");
    const html = `
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <h5 class="mb-0 mt-2">Lote seleccionado</h5>
            <span class="w-100 d-flex justify-between">
                <label class="m-0">Lote</label>
                <label class="m-0">${nombre}</label>
            </span>
            <span class="w-100 d-flex justify-between">
                <label class="m-0">Superficie</label>
                <label class="m-0">${superficie}</label>
            </span>
            <span class="w-100 d-flex justify-between">
                <label class="m-0">Precio metro</label>
                <label class="m-0">${total}</label>
            </span>
        <div>`; 

    $("#infoLoteSeleccionado").append(html);
})
