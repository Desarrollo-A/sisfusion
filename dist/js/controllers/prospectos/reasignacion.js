$(document).ready(function () {
    $('#spiner-loader').removeClass('hide');
    $.post('getRoles', function (data) {
        for (let i = 0; i < data.length; i++) {
            $("#tipoUsuario").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
        }
        $('#tipoUsuario').selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');

    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({ locale: 'es' });
    setIniDatesXYear("#beginDate", "#endDate");

    $.getJSON("getListaUsuarios").done(function (data) {
        for (let i = 0; i < data.length; i++) {
            if (data[i]['id_catalogo'] == 7) // MJ: ASESORES
                $("#asesores").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombreUsuario']));
            if (data[i]['id_catalogo'] == 9) // MJ: COORDINADORES
                $("#coordinadores").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombreUsuario']));
            if (data[i]['id_catalogo'] == 3) // MJ: GERENTES
                $("#gerentes").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombreUsuario']));
            if (data[i]['id_catalogo'] == 2 || data[i]['id_catalogo'] == 59) { // MJ: SUBDIRECTORES Y DIRECTORES REGIONALES
                $("#subdirectores").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombreUsuario']));
                $("#directoresRegionales").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombreUsuario']));
                $("#directoresRegionales2").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombreUsuario']));
            }
        }
        $('#asesores').selectpicker('refresh');
        $('#coordinadores').selectpicker('refresh');
        $('#gerentes').selectpicker('refresh');
        $('#subdirectores').selectpicker('refresh');
        $('#directoresRegionales').selectpicker('refresh');
        $('#directoresRegionales2').selectpicker('refresh');
    });

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

let titulos = [];
$('#tablaListaProspectos thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    titulos.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($("#tablaListaProspectos").DataTable().column(i).search() !== this.value)
            $("#tablaListaProspectos").DataTable().column(i).search(this.value).draw();
    });
});

function filltablaListaProspectos(beginDate, endDate, tipoUsuario) {
    tablaListaProspectos = $("#tablaListaProspectos").dataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'LISTADO DE PROSPECTOS',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                }
            },
            {
                text: '<i class="fas fa-exchange-alt"></i> RE ASIGNAR',
                titleAttr: 'RE ASIGNAR',
                attr: {
                    class: 'btn btn-azure reAsignarProspecto',
                    'data-type': '2'
                }
            }
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
            {},
            { data: 'idProspecto' },
            { data: 'nombreProspecto' },
            { data: 'correo' },
            { data: 'telefono' },
            { data: 'nombreAsesor' },
            { data: 'nombreCoordinador' },
            { data: 'nombreGerente' },
            { data: 'nombreSubdirector' },
            { data: 'nombreRegional' },
            { data: 'nombreRegional2' },
            { data: 'lugarProspeccion' },
            { data: 'fechaAlta' },
            {
                data: function (d) {
                    return `<div class='d-flex justify-center'><button class="btn-data btn-blueMaderas reAsignarProspecto" data-toggle="tooltip" data-placement="top" title="RE ASIGNAR" data-idProspecto="${d.idProspecto}" data-type="1"><i class="fas fa-exchange-alt"></i></button></div>`;
                }
            }
        ],
        columnDefs: [
            {
                orderable: false,
                className: 'select-checkbox dt-body-center',
                targets: 0,
                searchable: false,
                render: function (d, type, full, meta) {
                    if (full.ubicacion_dos != null)
                        return '';
                    else
                        return `<input type="checkbox" class="input-check individualCheck" name="idT[]" style="width:20px; height:20px;" value="${full.idProspecto}">`;
                },
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },
            }
        ],
        ajax: {
            url: `${general_base_url}Prospectos/getListaProspectos`,
            type: "POST",
            cache: false,
            data: {
                beginDate: beginDate,
                endDate: endDate,
                tipoUsuario: tipoUsuario
            }
        }
    });
    $('#box-listaProspectos').removeClass('hide');
    $('#spiner-loader').addClass('hide');
}

$('#tablaListaProspectos').on('draw.dt', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

$(document).on("click", "#searchByDateRange", function () {
    //$('#box-reporteLotesPorComisionista').removeClass('hide');
    if ($("#tipoUsuario").val() != '')
        filltablaListaProspectos($("#beginDate").val(), $("#endDate").val(), $("#tipoUsuario").val());
    else
        alerts.showNotification("top", "right", "Selecciona un tipo de usuario para continuar.", "warning");
});

$(document).on('click', '.reAsignarProspecto', function () {
    $('#asesores').val('').selectpicker('refresh');
    $('#coordinadores').val('').selectpicker('refresh');
    $('#gerentes').val('').selectpicker('refresh');
    $('#subdirectores').val('').selectpicker('refresh');
    $('#directoresRegionales').val('').selectpicker('refresh');
    $('#directoresRegionales2').val('').selectpicker('refresh');
    const TIPO_TRANSACCION = $(this).attr('data-type');
    $('#tipoTransaccion').val(TIPO_TRANSACCION);
    document.getElementById("mainLabelText").innerHTML = TIPO_TRANSACCION == 1 ? '¿A quién asignarás este prospecto?' : '¿A quién asignarás estos prospectos?';
    if (TIPO_TRANSACCION == 2) { // MJ: ES MASIVO
        if ($('input[name="idT[]"]:checked').length > 1)
            $('#reAsignarModal').modal();
        else
            alerts.showNotification("top", "right", "Asegúrate de seleccionar al menos dos registros para continuar.", "warning");
    } else { // MJ: ES DE A UNO
        $('input[type="checkbox"]').prop('checked', false);
        $('#idProspecto').val($(this).attr('data-idProspecto'));
        $('#reAsignarModal').modal();
    }
});

$(document).on("click", "#sendRequestButton", function (e) {
    e.preventDefault();
    if ($("#asesores").val() == '' || $("#gerentes").val() == '' || $("#subdirectores").val() == '')
        alerts.showNotification("top", "right", "Asegúrate de llenar los campos mínimos requeridos <b>(*)</b>", "warning");
    else {
        const TIPO_TRANSACCION = parseInt($("#tipoTransaccion").val());
        let idProspecto = 0;
        if (TIPO_TRANSACCION == 2) { // EMJ: ES MASIVO
            idProspecto = $(tablaListaProspectos.$('input[name="idT[]"]:checked')).map(function () {
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
                    $('#tablaListaProspectos').DataTable().ajax.reload();
                $("#reAsignarModal").modal("hide");

            }, error: function () {
                $("#sendRequestButton").prop("disabled", false);
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
        $('#spiner-loader').addClass('hide');
    }
});
