let titulosTabla = [];
$('#tableOrdenCompra thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    titulosTabla.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($('#tableOrdenCompra').DataTable().column(i).search() !== this.value) {
            $('#tableOrdenCompra').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
});

function show_upload(data) {
    /* // console.log(data)

    let form = new Form({
        title: 'Subir carta de autorización',
        onSubmit: function (data) {
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `upload_documento`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Archivo subido con éxito.", "success");

                    table.reload()

                    form.hide()
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");

                    form.loading(false)
                }
            })
        },
        fields: [
            new HiddenField({ id: 'id_proceso', value: data.idProcesoCasas }),
            new HiddenField({ id: 'id_documento', value: data.idDocumento }),
            new HiddenField({ id: 'name_documento', value: data.documento }),
            new FileField({ id: 'file_uploaded', label: 'Archivo', placeholder: 'Selecciona un archivo', accept: ['application/pdf'], required: true }),
        ],
    })

    form.show() */

    $("#archivosOrdenCompra").modal();
}

$(document).on('click', '#saveCancel', function () {
    let idLote = $("#idLote").val();
    let nombreLote = $("#nombreLote").val();
    let obsSolicitudCancel = $("#obsSolicitudCancel").val();
    let tipoCancelacion = $("#tipoCancelacion").val();
    let tipoCancelacionNombre = $('select[name="tipoCancelacion"] option:selected').text();
    if (obsSolicitudCancel.trim() == '' || tipoCancelacion == '') {
        alerts.showNotification("top", "right", "Asegúrate de ingresar una observación y seleccionar el tipo de liberación..", "warning");
        return false;
    }
    var datos = new FormData();
    $("#spiner-loader").removeClass('hide');
    datos.append("idLote", idLote);
    datos.append("nombreLote", nombreLote);
    datos.append("obsSolicitudCancel", obsSolicitudCancel);
    datos.append("tipoCancelacion", tipoCancelacion);
    datos.append("tipoCancelacionNombre", tipoCancelacionNombre);
    $.ajax({
        method: 'POST',
        url: `${general_base_url}Reestructura/setSolicitudCancelacion`,
        data: datos,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data == 1) {
                $('#tabla_lotes').DataTable().ajax.reload(null, false);
                $("#spiner-loader").addClass('hide');
                $('#cancelarLote').modal('hide');
                alerts.showNotification("top", "right", "Opción editada correctamente.", "success");
                $('#idLote').val('');
                $('#obsSolicitudCancel').val('');
            }
        },
        error: function () {
            $('#cancelarLote').modal('hide');
            $("#spiner-loader").addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$('#tableOrdenCompra').DataTable({
    dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: '100%',
    scrollX: true,
    buttons: [{
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Inventario disponible reubicación',
        title:"Inventario disponible reubicación",
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
        { data: "idLote" },
        { data: "lote" },
        { data: "condominio" },
        { data: "proyecto" },
        {
            data: function (data) {
                let upload_button = new RowButton({ icon: 'file_upload', label: 'Subir PDF', id: 'btn-abrir-modal', onClick: show_upload, data })
    
                /* let view_button = ''
                let pass_button = ''
                if (data.archivo) {
                    view_button = new RowButton({ icon: 'visibility', label: 'Visualizar carta de autorización', onClick: show_preview, data })
                    pass_button = new RowButton({ icon: 'thumb_up', color: 'green', label: 'Pasar a concentrar adeudos', onClick: pass_to_adeudos, data })
                }
    
                let cancel_button = new RowButton({ icon: 'thumb_down', color: 'warning', label: 'Regresar proceso', onClick: back_process, data }) */
    
                return `<div class="d-flex justify-center">${upload_button}</div>`
            }
        },
    ],
    ajax: {
        url: `${general_base_url}Credito/getOrdenCompra`,
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

