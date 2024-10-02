$(document).ready(function () {
    construirHead("tablaLista");
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({ locale: 'es' });
    setIniDatesXYear("#beginDate", "#endDate");
    filltablaLista($("#beginDate").val(), $("#endDate").val());
});

sp = { // MJ: DATE PICKER
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

function filltablaLista(beginDate, endDate) {
    tabla_6= $("#tablaLista").dataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: `${_("descargar-excel")}`,
                title: `${_("tus-ventas")}`,
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                }
            },
        ],
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            { data: 'nombreResidencial' },
            { data: 'nombreCondominio' },
            { data: 'nombreLote' },
            { data: 'idLote' },
            { data: 'nombreCliente' },
            { data: 'fechaApartado' },
            { data: 'nombreAsesor' },
            { data: 'nombreCoordinador' },
            { data: 'nombreGerente' },
            { data: 'nombreSubdirector' },
            { data: 'nombreRegional' },
            { data: 'nombreRegional2' },
            { data: 'estatusContratacion' },
            { data: 'detalleMovimiento' },
            {
                data: function (d) {
                    let colorStatus = d.coloStatusLote;
                    let fondoStatuslote = d.fondoStatuslote;
                    return `<span class='label' style="color:#${colorStatus};background-color: #${fondoStatuslote}">${d.estatusLote}</span>`;
                }
            },
            {
                data: function (d) {

                    return `<span class='label lbl-blueMaderas' >${d.estaConAsesor}</span>`;
                }
            },
            {
                data: function (d) {
                    let claseColor = '';
                    switch (d.detalleEstatus) {
                        case 'Nuevo':
                            claseColor = 'lbl-oceanGreen';
                            break;
                        case 'Rechazado':
                            claseColor = 'lbl-warning';
                            break;
                        case 'No aplica':
                            claseColor = 'lbl-gray';
                            break;
                        default:
                            claseColor = '';
                            break;

                    }
                    return `<span class='label ${claseColor}' >${d.detalleEstatus}</span>`;
                }
            },
            { data: 'comentario' }
        ],
        ajax: {
            url: `${general_base_url}Reporte/getListadoDeVentas`,
            type: "POST",
            cache: false,
            data: {
                beginDate: beginDate,
                endDate: endDate
            }
        }
    });
    $('#box-listaProspectos').removeClass('hide');
    $('#spiner-loader').addClass('hide');
}

$('#tablaLista').on('draw.dt', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

$(document).on("click", "#searchByDateRange", function () {
    //$('#box-reporteLotesPorComisionista').removeClass('hide');
        filltablaLista($("#beginDate").val(), $("#endDate").val(), $("#tipoUsuario").val());
});


$(document).on("click", "#sendRequestButton", function (e) {
    e.preventDefault();
    if ($("#asesores").val() == '' || $("#gerentes").val() == '' || $("#subdirectores").val() == '')
        alerts.showNotification("top", "right", "Asegúrate de llenar los campos mínimos requeridos <b>(*)</b>", "warning");
    else {
        const TIPO_TRANSACCION = parseInt($("#tipoTransaccion").val());
        let idProspecto = 0;
        if (TIPO_TRANSACCION == 2) { // EMJ: ES MASIVO
            idProspecto = $(tablaLista.$('input[name="idT[]"]:checked')).map(function () {
                return this.value;
            }).get();
        } else
            idProspecto = $("#idProspecto").val();
        $.ajax({
            type: 'POST',
            url: `${general_base_url}Prospectos/aplicarReAsignacion`,
            data: {
                tipoTransaccion: TIPO_TRANSACCION,
                idProspecto: idProspecto,
                idAsesor: $("#asesores").val(),
                idCoordinador: $("#coordinadores").val(),
                idGerente: $("#gerentes").val(),
                idSubdorector: $("#subdirectores").val(),
                idRegional: $("#directoresRegionales").val() == '' ? 0 : $("#directoresRegionales").val(),
                idRegional2: $("#directoresRegionales2").val() == '' ? 0 : $("#directoresRegionales2").val()
            },
            dataType: 'json',
            beforeSend: function () {
                $('#spiner-loader').removeClass('hide');
                $('#sendRequestButton').prop('disabled', true);
            },
            success: function (response) {
                alerts.showNotification("top", "right", response.message, response.status == 1 ? "success" : 'danger');
                if(response.status == 1 )
                    $('#tablaLista').DataTable().ajax.reload();
                $("#reAsignarModal").modal("hide");

            }, error: function () {
                $("#sendRequestButton").prop("disabled", false);
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
        $('#spiner-loader').addClass('hide');
    }
});
