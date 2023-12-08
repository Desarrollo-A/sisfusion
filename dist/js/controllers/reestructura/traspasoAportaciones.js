let titulosTabla = [];
$('#tablaTraspasoAportaciones thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    titulosTabla.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($('#tablaTraspasoAportaciones').DataTable().column(i).search() !== this.value)
            $('#tablaTraspasoAportaciones').DataTable().column(i).search(this.value).draw();
    });
    $('[data-toggle="tooltip"]').tooltip();
});

tablaTraspasoAportaciones = $('#tablaTraspasoAportaciones').DataTable({
    dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: '100%',
    scrollX: true,
    buttons: [{
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Lotes para reubicar',
        title: "Lotes para reubicar",
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19],
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
        title: "Lotes para reubicar",
        orientation: 'landscape',
        pageSize: 'LEGAL',
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19],
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
        url: general_base_url + "static/spanishLoader_v2.json",
        paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>"
        }
    },
    order: [[4, "desc"]],
    destroy: true,
    columns: [
        {
            data: function (d) {
                return `<span class='label lbl-violetBoots'>${d.tipo_proceso}</span>`;
            }
        },
        { data: "nombreResidencialOrigen" },
        { data: "nombreCondominioOrigen" },
        { data: "nombreLoteOrigen" },
        { data: "referenciaOrigen" },
        { data: "idLoteOrigen" },
        { data: "nombreCliente" },
        { data: "nombreResidencialDestino" },
        { data: "nombreCondominioDestino" },
        { data: "nombreLoteDestino" },
        { data: "referenciaDestino" },
        { data: "idLoteDestino" },
        {
            data: function (d) {
                return `<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas btn-traspaso"
                data-toggle="tooltip" 
                data-placement="left"
                title="Confirmar traspaso / Editar cantidad traspasada"
                data-idLoteOrigen="${d.idLoteOrigen}"
                data-idLoteDestino="${d.idLoteDestino}"
                data-idClienteDestino="${d.idClienteDestino}"
                data-idCondominioDestino="${d.idCondominioDestino}"
                data-cantidadTraspaso="${d.cantidadTraspaso}"
                data-comentarioTraspaso="${d.comentarioTraspaso}"
                data-tipo="${d.tipo}">
                <i class="fas fa-money-check-alt"></i>
                </button></div>`;
            }
        }
    ],
    ajax: {
        url: `${general_base_url}Reestructura/getListaLotesPendienteTraspaso`,
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

$(document).on('click', '.btn-traspaso', function () {
    const tr = $(this).closest('tr');
    const row = $('#tablaTraspasoAportaciones').DataTable().row(tr);
    $("#idLoteOrigen").val(row.data().idLoteOrigen);
    $("#idLoteDestino").val(row.data().idLoteDestino);
    $("#nombreLoteDestino").val(row.data().nombreLoteDestino);
    $("#idClienteDestino").val($(this).attr("data-idClienteDestino"));
    $("#idCondominioDestino").val($(this).attr("data-idCondominioDestino"));
    $("#tipo").val($(this).attr("data-tipo"));
    $("#comentarioTraspaso").val($(this).attr("data-comentarioTraspaso"));
    $("#cantidadTraspaso").val($(this).attr("data-cantidadTraspaso") <= 0 ? '' : $(this).attr("data-cantidadTraspaso"));
    document.getElementById("mainLabelTextTraspaso").innerHTML = `Confirma la cantidad que se va a traspasar del lote <b>${row.data().nombreLoteOrigen}</b> a <b>${row.data().nombreLoteDestino}</b>.`;
    $("#capturaTraspasoModal").modal("show");
});

// ESTA FUNCIÓN LA VOY A MOVER A GENERALES
function soloNumeros(evt) {
    if (window.event)
        keynum = evt.keyCode;
    else
        keynum = evt.which;
    if ((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46)
        return true;
    else {
        alerts.showNotification("top", "left", "Oops, algo salió mal. Asegúrate de ingresar únicamente números.", "danger");
        return false;
    }
}

// SE ENVÍA COMENTARIO Y CANTIDAD A TRASPASAR PARA ACTUALIZAR EN DATOS X CLIENTE
$(document).on("click", "#guardarTraspaso", function (e) {
    e.preventDefault();
    let data = new FormData();
    data.append("idLoteOrigen", $("#idLoteOrigen").val());
    data.append("idLoteDestino", $("#idLoteDestino").val());
    data.append("nombreLoteDestino", $("#nombreLoteDestino").val());
    data.append("idClienteDestino", $("#idClienteDestino").val());
    data.append("idCondominioDestino", $("#idCondominioDestino").val());
    data.append("tipo", $("#tipo").val());
    data.append("cantidadTraspaso", $("#cantidadTraspaso").val());
    data.append("comentarioTraspaso", $("#comentarioTraspaso").val());
    if ($("#cantidadTraspaso").val() == '' || $("#comentarioTraspaso").val() == 'SIN ESPECIFICAR')
        alerts.showNotification("top", "right", `Asegúrate de ingresar la cantidad que se traspasó, no olvides agregar un comentario específico.`, "warning");
    else {
        $.ajax({
            url: `${general_base_url}Reestructura/setTraspaso`,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: "POST",
            success: function (response) {
                $("#guardarTraspaso").prop("disabled", false);
                if (response) {
                    alerts.showNotification("top", "right", `La información ha sido capturada de manera exitosa.`, "success");
                    $('#tablaTraspasoAportaciones').DataTable().ajax.reload(null, false);
                    $("#capturaTraspasoModal").modal("hide");
                }
                else
                    alerts.showNotification("top", "right", "Oops, algo salió mal. Inténtalo más tarde.", "warning");
            },
            error: function () {
                $("#guardarTraspaso").prop("disabled", false);
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    }
});
