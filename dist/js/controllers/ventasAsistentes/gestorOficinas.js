$('#tablaOficinas thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>`);

    $('input', this).on('keyup change', function () {
        if ($('#tablaOficinas').DataTable().column(i).search() !== this.value) {
            $('#tablaOficinas').DataTable().column(i).search(this.value).draw();
        }
    });

    $('[data-toggle="tooltip"]').tooltip();
});

let tablaOficinas = $('#tablaOficinas').DataTable({
    dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: '100%',
    scrollX: true,
    pagingType: "full_numbers",
    fixedHeader: true,
    language: {
        url: general_base_url + "/static/spanishLoader_v2.json",
        paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>"
        }
    },
    destroy: true,
    ordering: false,
    columns: [{ 
        data: function (d) {
            return d.id_direccion;
        }
    },
    { 
        data: function (d) {
            return d.sede;
        }
    },
    { 
        data: function (d) {
            return d.nombre;
        }
    },
    { 
        data: function (d) {
            return '<label>'+ d.hora_inicio +'am - ' + d.hora_fin +'pm</label>';
        }
    },
    {
        data: function (d) {
            return `<span class='label ${d.estatus == 0 ? 'lbl-warning' : 'lbl-green'}'>${d.estatus == 0 ? 'INACTIVO' : 'ACTIVO'}</span>`;
        }
    },
    { 
        data: function (d) {
            var btn = `<div class="d-flex justify-center">
                <button class="btn-data btn-sky updateOffice" data-toggle="tooltip" data-placement="top" title="EDITAR">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                <button class="btn-data statusOfficeBtn ${d.estatus == 0 ? 'btn-violetBoots' : 'btn-gray'}" data-toggle="tooltip" data-placement="top" title="${d.estatus == 0 ? 'ACTIVAR' : 'DESACTIVAR'}">
                    <i class="fas ${d.estatus == 0 ? 'fa-thumbs-up' : 'fa-thumbs-down'}"></i>
                </button>
            </div>`;
            $('[data-toggle="tooltip"]').tooltip();
            return btn;
        }
    }],
    columnDefs: [{
        "searchable": true,
        "orderable": false,
        "targets": 0
    }],
    ajax: {
        url: general_base_url + "/General/getOfficeAddressesAll",
        dataSrc: ""
    }
});


$(document).on("click", ".updateOffice", function () {
    let tr = this.closest('tr');
    let row = tablaOficinas.row(tr).data();
    $('#editOffice').modal('show');
    $('#direccionOffice').val(row.nombre);
    $('#idDireccion').val(row.id_direccion);
});

$(document).on("click", ".statusOfficeBtn", function () {
    $('#statusOffice .modal-body').html('');
    let tr = this.closest('tr');
    let row = tablaOficinas.row(tr).data();
    
    $('#idDireccionS').val(row.id_direccion);
    $('#status').val(row.estatus);
    $('#statusOffice .modal-body').append(`
        <h6 style="text-align: justify">¿Estás seguro que deseas cambiar el estatus para la dirección <b>${row.nombre}</b>?</h6>
    `);
    $('#statusOffice').modal('show');
});

$(document).on("click", "#btnAgregarOffice", function () {
    $.post( general_base_url +'/General/listSedes', function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_sede'];
            var name = data[i]['nombre'];
            $("#idSede").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#idSede").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#idSede").selectpicker('refresh');
    }, 'json');

    $('#addOffice').modal('show');
});

$("#formEditOffice").on('submit', function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: 'editDireccionOficce',
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            if (data == 1) {
                tablaOficinas.ajax.reload();
                $("#editOffice").modal('hide');
                alerts.showNotification("top", "right", "El registro se actualizó exitosamente.", "success");
            } else {
                alerts.showNotification("top", "right", "Error al actualizar.", "warning");
            }
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#formStatus").on('submit', function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: 'statusOffice',
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            if (data == 1) {
                tablaOficinas.ajax.reload();
                $("#statusOffice").modal('hide');
                alerts.showNotification("top", "right", "El registro se actualizó exitosamente.", "success");
            } else {
                alerts.showNotification("top", "right", "Error al actualizar.", "warning");
            }
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#formAddOffice").on('submit', function (e) {
    e.preventDefault();
    if(this.newOffice.value == '' || this.inicio.value == '' || this.fin.value == '' || this.idSede.value == ''){
        alerts.showNotification("top", "right", "Faltan datos a ingresar", "warning");
    }
    else if(parseInt(this.inicio.value) > 12 || parseInt(this.fin.value) > 12){
        alerts.showNotification("top", "right", "Formato de 12 horas", "warning");
    }
    else{
        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'addDireccionOficce',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data == 1) {
                    tablaOficinas.ajax.reload();
                    $("#addOffice").modal('hide');
                    alerts.showNotification("top", "right", "Se ha añadido el registro exitosamente.", "success");
                } else {
                    alerts.showNotification("top", "right", "Error al añadir el registro.", "warning");
                }
            },
            error: function () {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    }
});