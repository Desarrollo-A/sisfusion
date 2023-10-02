$(document).ready(function () {
    $.post(`${general_base_url}Reestructura/getListaUsuariosParaAsignacion`, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#idAsesor").append($('<option>').val(data[i]['id_usuario']).text(data[i]['nombreUsuario']));
        }
        $("#idAsesor").selectpicker('refresh');
    }, 'json');
});

let titulosTabla = [];
$('#tablaAsignacionCartera thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    titulosTabla.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($('#tablaAsignacionCartera').DataTable().column(i).search() !== this.value) {
            $('#tablaAsignacionCartera').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
});

$('#tablaAsignacionCartera').DataTable({
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
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
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
        { data: "nombreAsesorAsignado"},
        {
            data: function (d) {
                btns = `<button class="btn-data btn-sky btn-asignar-venta"
                            data-toggle="tooltip" 
                            data-placement="left"
                            title="ASIGNAR VENTA"
                            data-idCliente="${d.idCliente}"
                            data-idAsesorAsignado="${d.idAsesorAsignado}">
                            <i class="fas fa-exchange-alt"></i>
                    </button>`;
                return `<div class="d-flex justify-center">${btns}</div>`;
            }
        }
    ],
    ajax: {
        url: `${general_base_url}reestructura/getListaAsignacionCartera`,
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

$(document).on('click', '.btn-asignar-venta', function () {
    const tr = $(this).closest('tr');
    const row = $('#tablaAsignacionCartera').DataTable().row(tr);
    const idAsesorAsignado = $(this).attr("data-idAsesorAsignado");
    const idLote = row.data().idLote;
    const nombreLote = row.data().nombreLote;
    $("#idAsesor").val(idAsesorAsignado == 0 ? '' : idAsesorAsignado).selectpicker('refresh');
    $("#nombreLote").val(nombreLote);
    //$('#payment_method').selectpicker('refresh');
    $("#idLote").val(idLote)
    document.getElementById("mainLabelText").innerHTML = `Asigna un asesor para el seguimiento de la venta <b>${nombreLote}</b>`;
    $("#asignacionModal").modal("show");
});

$(document).on("click", "#sendRequestButton", function (e) {
    e.preventDefault();
    const idLote = $("#idLote").val();
    const idAsesor = $("#idAsesor").val();
    const nombreLote = $("#nombreLote").val();
    const select = document.getElementById("idAsesor");
    const textNombreAsesor = select.options[select.selectedIndex].innerText;
    let data = new FormData();
    data.append("idLote", idLote);
    data.append("idAsesor", idAsesor);
    if (idAsesor == '')
        alerts.showNotification("top", "right", `Asegúrate de asignar un asesor para continuar con este proceso.`, "warning");
    else {
        $.ajax({
            url: `${general_base_url}Reestructura/setAsesor`,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: "POST",
            success: function (response) {
                $("#sendRequestButton").prop("disabled", false);
                if (response) {
                    alerts.showNotification("top", "right", `El asignación del lote <b>${nombreLote}</b> a <b>${textNombreAsesor}</b> ha sido exitosa.`, "success");
                    $('#tablaAsignacionCartera').DataTable().ajax.reload(null, false);
                    $("#asignacionModal").modal("hide");
                }
                else
                alerts.showNotification("top", "right", "Oops, algo salió mal. Inténtalo más tarde.", "warning");
            },
            error: function () {
                $("#sendRequestButton").prop("disabled", false);
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    }
  });
