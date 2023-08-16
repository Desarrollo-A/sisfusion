let titulosTabla = [];
let tablaCancelaciones;

const ESTATUS_CANCELACIONES = Object.freeze({
    CANCELACION: 1,
    LIBRE: 2
});

const sp = {
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
$(document).ready(function () {
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({ locale: 'es' });
    setIniDatesXYear('#beginDate', '#endDate');
    fillTable(convertDateDDMMYYYYToYYYYMMDD($('#beginDate').val()), convertDateDDMMYYYYToYYYYMMDD($('#endDate').val()));
});
$('#cancelacionesTabla thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    titulosTabla.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($('#cancelacionesTabla').DataTable().column(i).search() !== this.value) {
            $('#cancelacionesTabla').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
});

function fillTable(fechaInicio, fechaFin) {
    tablaCancelaciones = $('#cancelacionesTabla').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Lotes cancelados en proceso',
                title:"Lotes cancelados en proceso",
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
                titleAttr: 'Lotes cancelados en proceso',
                title:"Lotes cancelados en proceso",
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
            }
        ],
        columnDefs: [
            {
                searchable: false,
                visible: false
            }
        ],
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
            {
                "data": function (d) {
                    if (id_rol_general == 17) {
                        return `<span class='label' style='background: ${d.color}18; color: ${d.color}'>${d.nombreCancelacion}</span>`;
                    }
                    if (parseInt(d.cancelacion_proceso) === ESTATUS_CANCELACIONES.CANCELACION) {
                        return `<span class='label' style='background: ${d.color}18; color: ${d.color}'>${d.nombreCancelacion}</span>`;
                    }
                    return `<div class="d-flex justify-center">
                        <button class="btn-data btn-warning btn-cancelar"
                                data-toggle="tooltip" 
                                data-placement="left"
                                title="CANCELAR LOTE"
                                data-idCliente="${d.idCliente}">
                            <i class="fa fa-close"></i>
                        </button>
                    </div>`;
                }
            }
        ],
        ajax: {
            url: `${general_base_url}clientes/infoCancelacionesProceso`,
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {
                "beginDate": fechaInicio,
                "endDate": fechaFin
            }
        },
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            });
        },
    });
}
$(document).on('click', '#filtrarPorFecha', function () {
    const fechaInicio = convertDateDDMMYYYYToYYYYMMDD($('#beginDate').val());
    const fechaFin = convertDateDDMMYYYYToYYYYMMDD($('#endDate').val());
    fillTable(fechaInicio, fechaFin);
});
$(document).on('click', '.btn-cancelar', function () {
    const $itself = $(this);
    const idCliente = $itself.attr('data-idCliente');
    changeSizeModal('modal-sm');
    appendBodyModal(`
        <div class="row">
            <div class="col-12 text-center">
                <h3>Cancelación de lote</h3>
            </div>
            <div class="col-12 text-center">
                <p>¿Está seguro de cambiar el estatus de este lote?</p>
            </div>
        </div>
    `);
    appendFooterModal(`
        <button type="button" class="btn btn-simple btn-danger" onclick="hideModal()">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="guardarCancelacion(${idCliente})">Aceptar</button>
    `);
    showModal();
});

function guardarCancelacion(idCliente) {
    let data = new FormData();
    data.append('idCliente', idCliente);
    $('#spiner-loader').removeClass('hide');
    $.ajax({
        url: `${general_base_url}Clientes/updateCancelacionProceso`,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (response) {
            const res = JSON.parse(response);
            hideModal();
            $('#spiner-loader').addClass('hide');
            if (res.code === 200) {
                alerts.showNotification("top", "right", `El registro se ha actualizado con éxito.`, "success");
                tablaCancelaciones.ajax.reload();
            }
            if (res.code === 400) {
                alerts.showNotification("top", "right", res.message, "warning");
            }
            if (res.code === 500) {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
            }
        }
    });
}