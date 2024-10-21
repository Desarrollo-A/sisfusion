let titulosGestor = [];
let titulosTablaIntercambios = [];
let titulosCambioTipoVenta = [];
let titulosTablaCambioRL = [];
let titulos_principal = [];
let num_colum_principal = [];
let tipoTransaccion = '';
let tipoTransaccionModelo = '';
let id_opcion = '';
let idopcion_modelo = '';
let idLote = '';
let usuariosPermitidosRL = [2815, 2875, 12276, 2767, 11947, 2807, 9775, 14342, 2749, 11815];
let usuariosPermitidosIntercambio = [5342, 2767, 11947, 2807, 9775, 14342, 2749, 11815];
let usuariosPermitidosModelosCasas = [2749];
let tablaTipoVenta, idLot, tipoVenta, nameLote, idTipoVentaRowSelected;
let idRl = "";
let idCliente = "";
let selectedRl = "";
let selectedOpcion = "";
let nombreRl = "";
let representanteLegal = "";
let nombreLoteText = "";
let selectedLabelC = "";

$(document).ready(function () {
    modelosTable = $('#modelosTable thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        titulos_principal.push(title);
        num_colum_principal.push(i);
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
        $('input', this).on('keyup change', function () {
            if ($('#modelosTable').DataTable().column(i).search() !== this.value)
                $('#modelosTable').DataTable().column(i).search(this.value).draw();
        });
    });


    $('#modelosTable').DataTable({
        destroy: true,
        ajax: {
            url: `${general_base_url}Contraloria/getModeloCasas`,
            dataSrc: "",
            type: "POST",
            cache: false
        },
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip();
        },
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "auto",
        ordering: false,
        pagingType: "full_numbers",
        scrollX: true,
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'Listado-Modelos De Casas',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos_principal[columnIdx] + ' ';
                        }
                    }
                }
            },
            {
                text: '<i class="fa fa-plus" aria-hidden="true"></i>',
                className: 'btn btn-azure agregarCasa',
                titleAttr: 'Agregar un nuevo modelo de casa',
                title: "Agrega un nuevo modelo de casa:",
                attr: {
                    'data-transaccionmodelo': 0
                }
            }
        ],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        columns: [
            { data: "idModelo" },
            { data: "modelo" },
            { data: "sup" },
            {
                data:
                    function (d) {
                        return `${formatMoney(d.costom2)}`;
                    }
            },
            {
                data: function (d) {
                    let statusEstado = '';
                    if (d['estatus'] == 1) {
                        statusEstado = "<span class='label lbl-green'> Activo</span>";

                    }
                    else if (d['estatus'] == 2) {
                        statusEstado = "<span class='label lbl-warning'>Inactivo</span>";
                    }
                    return statusEstado;
                }
            },
            {
                orderable: false,
                data: function (d) {
                    return `<div class="d-flex justify-center"><button class="btn-data agregarCasa ${d.estatus == 2 ? 'btn-green' : 'btn-warning'}" data-toggle="tooltip" data-placement="top" title="EDITAR ESTATUS" data-transaccionmodelo="${d.estatus == 2 ? '1' : '2'}" data-modelo="${d.modelo}" data-idopcion_modelo="${d.idModelo}" data-estatus="${d.estatus}"><i class="${d.estatus == 2 ? 'fas fa-unlock' : 'fas fa-lock'}"></i></button> </div>`;
                }
            }
        ]
    });
    // AGREGAR - ACTUALIZAR TABLA MODELOS CASA 
    $(document).on('click', '.agregarCasa', function () {
        let tipoTm = $(this).data('transaccionmodelo');
        $('#modalmodelo').modal('show');
        $('#titulomodelo').text(tipoTm == 0 ? 'Agregar modelo de casa' : 'Actualizar estado');
        $('#btnAgregarCasa').text(tipoTm == 0 ? 'Agregar' : 'Actualizar');

        if (tipoTm == 0) {
            $("#divConfirmacionModelo").addClass("d-none");
            $("#divNombreModelo").removeClass("d-none");
            $("#divSuperficie").removeClass("d-none");
            $("#divCosto").removeClass("d-none");
        } else {
            $("#divNombreModelo").addClass("d-none");
            $("#divSuperficie").addClass("d-none");
            $("#divCosto").addClass("d-none");
            $("#divConfirmacionModelo").removeClass("d-none");
            $("#divConfirmacionModelo").html(tipoTm == 1
                ? `¿Estás seguro de activar el modelo de casa?`
                : `¿Estás seguro de desactivar el modelo de casa?`);
        }

        tipoTransaccionModelo = tipoTm;
        idopcion_modelo = $(this).data('idopcion_modelo');
        estatus = $(this).data('estatus');
    });

    $(document).on('click', '#btnAgregarCasa', function (e) {
        e.preventDefault();

        var NombreModelo = $("#nombreModelo").val();
        var superficie = $("#superficie").val();
        var costo = $("#costo").val();
        var dataExp1 = new FormData();
        dataExp1.append("nombreModelo", NombreModelo);
        dataExp1.append("superficie", superficie);
        dataExp1.append("costo", costo);
        dataExp1.append("tipoTransaccionModelo", tipoTransaccionModelo);
        dataExp1.append("idopcion_modelo", idopcion_modelo);
        dataExp1.append("estatus", tipoTransaccionModelo);

        if (tipoTransaccionModelo == 0 && NombreModelo.length === 0) {
            alerts.showNotification('top', 'right', 'Asegúrate de ingresar un valor.', 'warning');
        } else {
            $('#btnAgregarCasa').prop('disabled', true);

            $.ajax({
                url: `${general_base_url}Contraloria/agregarModeloCasas`,
                data: dataExp1,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        alerts.showNotification('top', 'right', `Registro ${tipoTransaccionModelo == 0 ? 'insertado' : 'actualizado'} exitosamente.`, 'success');
                    } else {
                        alerts.showNotification('top', 'right', `Registro no ${tipoTransaccionModelo == 0 ? 'insertado' : 'actualizado'}.`, 'danger');
                    }
                    $('#btnAgregarCasa').prop('disabled', false);
                    $('#modalmodelo').modal('hide');
                    $('#modelosTable').DataTable().ajax.reload();
                },
                error: function () {
                    alerts.showNotification('top', 'right', 'Error al enviar la solicitud.', 'danger');
                    $('#modalmodelo').modal('hide');
                    $('#modelosTable').DataTable().ajax.reload();
                    $('#btnAgregarCasa').prop('disabled', false);
                }
            });
        }
    });
    loadSelectOptions();
    
    $.getJSON("getCatalogoxContraloria").done(function (data) {
        for (var i = 0; i < data.length; i++) {
            if(data[i]['id_catalogo'] == '77'){
                $("#cambiarrepresentante").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre'].toUpperCase()));
            }else if (data[i]['id_catalogo'] == 'tv'){
                $("#tipoVentaModal").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre'].toUpperCase()));    
            }
        }
        $("#cambiarrepresentante").selectpicker('refresh');
        $("#tipoVentaModal").selectpicker('refresh');
       
    });
    $("#divTablaRL, #divTablaIntercambio, #divTablaCambioRL, #divmodelosTable").addClass("hide");
    $.getJSON("getOpcionesPorCatalogo").done(function (data) {
        for (let i = 0; i < data.length; i++) {
            if (data[i]['id_catalogo'] == 155) {
                if (data[i]['id_opcion'] == 1 && usuariosPermitidosRL.includes(id_usuario_general)) {
                    $("#selector").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
                } else if (data[i]['id_opcion'] == 2 && usuariosPermitidosIntercambio.includes(id_usuario_general)) {
                    $("#selector").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
                } else if (data[i]['id_opcion'] == 3 && usuariosPermitidosModelosCasas.includes(id_usuario_general)) {
                    $("#selector").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
                } else if (data[i]['id_opcion'] == 4 && usuariosPermitidosModelosCasas.includes(id_usuario_general)) {
                    $("#selector").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
                } else if (data[i]['id_opcion'] == 5 && usuariosPermitidosModelosCasas.includes(id_usuario_general)) {
                    $("#selector").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
                }
            }
        }
        $('#selector').selectpicker('refresh');
    });

    $(document).on('click', '#btnEditarTipoVenta', function (e) {
        e.preventDefault();
        idLot = $(this).data('idlote');
        nameLote = $(this).data('nombrelote');       
        idTipoVentaRowSelected = $(this).data('idtipoventa');
        
        $('#modalCambiotipoventa').modal('show');
    });

    $(document).on('change', '#tipoVentaModal', function () {
        tipoVenta = $(this).val();
    });
    $(document).on('click', '#btnAceptarCambioTipoVenta', function () {
        $.ajax({
            url: `${general_base_url}Contraloria/actualizar_tipo_venta/${tipoVenta}/${idLot}`,
            type: 'GET',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#spiner-loader').removeClass('hide');
            },
            success: function (response) {
                if (response.message === 'OK') {
                    $('#spiner-loader').addClass('hide');
                    $('#tipo-venta').DataTable().ajax.reload();
                    $('#modalConfirmacionCambiotipoventa').modal('hide');
                    alerts.showNotification("top", "right", 'Se ha actualizo correctamente.', "success");
                    $('#tipoVentaModal').val('');
                    $('#tipoVentaModal').selectpicker('refresh');
                    tipoVenta = null;
                    idLot = null;
                } else {
                    $('#spiner-loader').addClass('hide');
                    alerts.showNotification('top', 'right', `Registro no actualizado.`, 'danger');
                }
            },
            error: function (xhr, status, error) {
                $('#spiner-loader').addClass('hide');
                alerts.showNotification('top', 'right', `Error al enviar la solicitud.`, 'danger');
            }
        });
    });

    $('#btnConfirmarCambioTipoVenta').on('click', function (e) {
        e.preventDefault();
        if (!tipoVenta) {
            alerts.showNotification('top', 'right', 'Asegúrate de seleccionar una opción.', 'warning');
            return;
        }
        if (idTipoVentaRowSelected == tipoVenta) {
            alerts.showNotification('top', 'right', 'Estás seleccionando el mismo tipo de venta.', 'warning');
            return;
        }
        if (tipoVenta && idLot) {
            $('#modalCambiotipoventa').modal('hide');
            $('#mensajeConfirmacion').html(`¿Estás seguro de cambiar el tipo de venta del lote <strong>${nameLote}</strong>?`);
            $('#modalConfirmacionCambiotipoventa').modal('show');
        }
    });

});

$(document).on('change', '#selector', function () {
    $('#selectCondominio').val('');
    $('#selectCondominio').selectpicker('refresh');
    $('#selectProyecto').val('');
    $('#selectProyecto').selectpicker('refresh');

    $("#divTablaRL, #divTablaIntercambio, #divmodelosTable").addClass("hide");
    selectedOpcion = $(this).val();
    if ($(this).val() == 1) {
        $("#divTablaIntercambio").addClass("hide");
        $('#proyecto').addClass('hide');
        $('#condominio').addClass('hide');
        $("#divTablaRL").removeClass("hide");
        $('#divTablaCambiarVenta').addClass('hide');
        $("#divtablaCambiarRepresentanteLegal").addClass("hide");
        llenarTablaRl($(this).val());
    } else if ($(this).val() == 2) {
        $("#divTablaIntercambio").removeClass("hide");
        $('#proyecto').addClass('hide');
        $('#condominio').addClass('hide');
        $("#divTablaRL").addClass("hide");
        $('#divTablaCambiarVenta').addClass('hide');
        $("#divtablaCambiarRepresentanteLegal").addClass("hide");
        llenarTablaIntercambios($(this).val());
    } else if ($(this).val() == 3) {
        $('#proyecto').addClass('hide');
        $('#condominio').addClass('hide');
        $('#divTablaCambiarVenta').addClass('hide');
        $("#divtablaCambiarRepresentanteLegal").addClass("hide");
        $("#divmodelosTable").removeClass("hide");
    }
    else if ($(this).val() == 4) {
        $('#proyecto').removeClass('hide');
        $('#condominio').removeClass('hide');
        $('#divTablaCambiarVenta').addClass('hide');
        $("#divtablaCambiarRepresentanteLegal").addClass("hide");
    } else if ($(this).val() == 5) {
        // LLEAR EL SELECT DE PROYECTO
        $('#proyecto').removeClass('hide');
        $('#condominio').removeClass('hide');
        $('#divTablaCambiarVenta').addClass('hide');
        $("#divtablaCambiarRepresentanteLegal").addClass("hide");
    }
});

$('#selectCondominio').change(function () {
    idOpcionCondominio = $(this).val();
    if (idOpcionCondominio !== null && idOpcionCondominio !== '' && idOpcionCondominio !== undefined) {
        if (selectedOpcion == 4) {
            crearTablaTipoVenta(idOpcionCondominio);
        } else if (selectedOpcion == 5) {
            ConstruirTablaCAmbiarRepresentante(idOpcionCondominio);
        }
    }
});
// FUNCION PARA LLENAR LA TABLA DE LOTES DISPONIBLES PARA CAMBIO DE TIPO DE VENTA
function crearTablaTipoVenta(idCondominio) {
    $('#tipo-venta thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        titulosCambioTipoVenta.push(title);
        $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
        $('input', this).on('keyup change', function () {
            if (tablaTipoVenta.column(i).search() !== this.value)
                tablaTipoVenta.column(i).search(this.value).draw();
        });
    });
    titulosCambioTipoVenta.pop();
    $('#divTablaCambiarVenta').removeClass('hide');
    construirHead('tipo-venta');
    tablaTipoVenta = $('#tipo-venta').DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'Listado de lotes por tipo de venta',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosCambioTipoVenta[columnIdx] + ' ';
                        }
                    }
                },
            }
        ],
        width: '100%',
        scrollX: true,
        pageLength: 10,
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'></i>",
                next: "<i class='fa fa-angle-right'></i>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            { data: "nombreResidencial" },
            { data: "nombreCondominio" },
            { data: "nombreLote" },
            { data: "referencia" },
            { data: "nombreTipoVenta" },
            {
                data: function (d) {
                    return `
                        <div class="d-flex justify-center">
                            <button href="#" id="btnEditarTipoVenta" class="btn-data btn-blueMaderas" data-idlote="${d.idLote}" data-nombrelote="${d.nombreLote}" data-idtipoventa="${d.idTipoVenta}"  data-toggle="tooltip" data-placement="top" title="EDITAR">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                        </div>`;
                }
            }
        ],
        ajax: {
            url: `${general_base_url}Contraloria/get_registros_tipo_venta/${idCondominio}`,
            dataSrc: ""
        },
    });

    $(document).on('click', '#btnEditarTipoVenta', function (e) {
        e.preventDefault();
        idLot = $(this).data('idlote');               
        $('#modalCambiotipoventa').modal('show');
    });

    // $(document).on('change', '#tipoVentaModal', function () {
    //     tipoVenta = $(this).val();
    // });

    applySearch(tablaTipoVenta);
    $('#tipo-venta').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}



function loadSelectOptions() {
    $.post(`${general_base_url}Contratacion/lista_proyecto`, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#selectProyecto").append($('<option>').val(data[i]['idResidencial']).text(data[i]['descripcion']));
        }
        $("#selectProyecto").selectpicker('refresh');
    }, 'json');

    $.post(`${general_base_url}Contratacion/lista_estatus`, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#idEstatus").append($('<option>').val(data[i]['idStatusLote']).text(data[i]['nombre']));
        }
        $("#idEstatus").selectpicker('refresh');
    }, 'json');

}

$('#selectProyecto').change(function () {
    $('#spiner-loader').removeClass('hide');
    $('#tablaInventario').removeClass('hide');
    index_idResidencial = $(this).val();
    $("#selectCondominio").html("");
        $.post(`${general_base_url}Contratacion/lista_condominio/${index_idResidencial}`, function (data) {
            for (var i = 0; i < data.length; i++) {
                $("#selectCondominio").append($('<option>').val(data[i]['idCondominio']).text(data[i]['nombre']));
            }
            $("#selectCondominio").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }, 'json');
});

// FUNCIóN PARA LLENAR TABLA CON REPRESENTANTES LEGALES
function llenarTablaRl(tipoOperacion) {
    $('#gestorContraloria thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        titulosGestor.push(title);
        $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
        $('input', this).on('keyup change', function () {
            if (tablaGestor.column(i).search() !== this.value)
                tablaGestor.column(i).search(this.value).draw();
        });
    });
    tablaGestor = $("#gestorContraloria").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Exportar registros a Excel',
                title: "Listado de representantes legales",
                exportOptions: {
                    columns: [0, 1, 2, 3],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosGestor[columnIdx] + ' ';
                        }
                    }
                }
            },
            {
                text: '<i class="fa fa-plus" aria-hidden="true"></i>',
                className: 'btn btn-azure agregar',
                titleAttr: 'Agregar Representante Legal',
                title: "Agregar Representante Legal",
                attr: {
                    'data-transaccion': 0
                }
            }
        ],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        bAutoWidth: false,
        fixedColumns: true,
        ordering: false,
        scrollX: true,
        destroy: true,
        columns: [
            { data: 'id_opcion' },
            { data: 'nombre' },
            {
                data: function (d) {
                    if (d.estatus == 1) {
                        return '<center><span class="label lbl-green">ACTIVO</span><center>';
                    } else {
                        return '<center><span class="label lbl-warning">INACTIVO</span><center>';
                    }
                }
            },
            { data: 'fecha_creacion' },
            {
                orderable: false,
                data: function (d) {
                    return `<div class="d-flex justify-center"><button href="#" class="btn-data agregar ${d.estatus == 0 ? 'btn-green' : 'btn-warning'}" data-nombre="${d.nombre}" data-toggle="tooltip" data-placement="top" title="EDITAR INFORMACIÓN" data-transaccion="${d.estatus == 0 ? '1' : '2'}" data-idopcion="${d.id_opcion}"><i class="${d.estatus == 0 ? 'fas fa-unlock' : 'fas fa-lock'}"></i></button></div>`;

                }
            }
        ],
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: 0
            },
        ],
        ajax: {
            url: `${general_base_url}Contraloria/getDatosTabla/${tipoOperacion}`,
            dataSrc: "",
            type: "POST",
            cache: false,
        },
        order: [[1, 'asc']]
    });

    $('#gestorContraloria').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}

// FUNCIÓN PARA LLENAR LA CON REPRESENTANTES LEGALES PARA EDITAR


// FUNCIóN PARA LLENAR LA TABLA DE LOTES PARA CAMBIO DE ESTATUS
function llenarTablaIntercambios(tipoOperacion) {
    $('#tablaIntercambios thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        titulosTablaIntercambios.push(title);
        $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
        $('input', this).on('keyup change', function () {
            if (tablaIntercambios.column(i).search() !== this.value)
                tablaIntercambios.column(i).search(this.value).draw();
        });
    });
    tablaIntercambios = $("#tablaIntercambios").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Exportar registros a Excel',
                title: "Listado de lotes contratados por intercambio",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosTablaIntercambios[columnIdx] + ' ';
                        }
                    }
                }
            }
        ],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        bAutoWidth: false,
        fixedColumns: true,
        ordering: false,
        scrollX: true,
        destroy: true,
        columns: [
            { data: 'nombreResidencial' },
            { data: 'nombreCondominio' },
            { data: 'nombreLote' },
            { data: 'idLote' },
            { data: 'referencia' },
            {
                data: function (d) {
                    return `<span class="label" style="background:#${d.background_sl}18; color:#${d.color};">${d.nombreEstatusLote}</span>`;
                }
            },
            {
                orderable: false,
                data: function (d) {
                    return `<div class="d-flex justify-center"><button href="#" class="btn-data btn-violetBoots confirmarCambio" data-nombreLote="${d.nombreLote}" data-idlote="${d.idLote}" data-toggle="tooltip" data-placement="top" title="EDITAR INFORMACIÓN"><i class="fas fa-exchange-alt"></i></button></div>`;
                }
            }
        ],
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: 0
            },
        ],
        ajax: {
            url: `${general_base_url}Contraloria/getDatosTabla/${tipoOperacion}`,
            dataSrc: "",
            type: "POST",
            cache: false,
        },
        order: [[1, 'asc']]
    });

    $('#tablaIntercambios').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}

// FUNCION PARA LLENAR LA TABLA DE LOTES DISPONIBLES PARA CAMBIO DE REPRESENTANTE LEGAL
function llenarTablaCambioRL(tipoOperacion) {
    if ($("#nombreLote").val().length == 0) {
        alerts.showNotification('top', 'right', 'Asegúrate de ingresar un valor.', 'warning')
    } else {
        $("#divTablaCambioRL").removeClass("hide");
        $('#tablaCambioRL thead tr:eq(0) th').each(function (i) {
            var title = $(this).text();
            titulosTablaCambioRL.push(title);
            $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
            $('input', this).on('keyup change', function () {
                if (tablaCambioRL.column(i).search() !== this.value)
                    tablaCambioRL.column(i).search(this.value).draw();
            });
        });
        tablaCambioRL = $("#tablaCambioRL").DataTable({
            dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            width: '100%',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Exportar registros a Excel',
                    title: "Listado de lotes",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                        format: {
                            header: function (d, columnIdx) {
                                return ' ' + titulosTablaCambioRL[columnIdx] + ' ';
                            }
                        }
                    }
                }
            ],
            language: {
                url: `${general_base_url}static/spanishLoader_v2.json`,
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            pagingType: "full_numbers",
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            bAutoWidth: false,
            fixedColumns: true,
            ordering: false,
            scrollX: true,
            destroy: true,
            columns: [
                { data: 'nombreResidencial' },
                { data: 'nombreCondominio' },
                { data: 'nombreLote' },
                { data: 'idLote' },
                { data: 'referencia' },
                { data: 'nombreRl' },
                {
                    orderable: false,
                    data: function (d) {
                        return `<div class="d-flex justify-center"><button href="#" class="btn-data btn-violetBoots cambiarRlLote" data-toggle="tooltip" data-placement="top" title="EDITAR INFORMACIÓN"><i class="fas fa-exchange-alt"></i></button></div>`;
                    }
                }
            ],
            columnDefs: [
                {
                    searchable: false,
                    orderable: false,
                    targets: 0
                },
            ],
            ajax: {
                url: `${general_base_url}Contraloria/getDatosTabla/${tipoOperacion}`,
                dataSrc: "",
                type: "POST",
                cache: false,
                data: {
                    nombreLote: $('#nombreLote').val()
                }


            },
            order: [[1, 'asc']]
        });

        $('#tablaCambioRL').on('draw.dt', function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            });
        });
    }
}

// MODAL PARA ACTIVAR O DESACTIVAR REPRESENTANTE LEGAL
$(document).on('click', '.agregar', function () {
    let tipoT = $(this).data('transaccion');
    $('#modal').modal('show');
    document.getElementById('titulo').innerHTML = tipoT == 0 ? `Agregar Representante Legal` : `Editar Representante Legal`;
    document.getElementById('btnAgregar').innerHTML = tipoT == 0 ? `Agregar` : `Actualizar`;
    if (tipoT == 0) {
        $("#divConfirmacion").addClass("hide");
        $("#divNombre").removeClass("hide");
    } else {
        $("#divNombre").addClass("hide");
        $("#divConfirmacion").removeClass("hide");
        document.getElementById("confirmacion").innerHTML = tipoT == 1 ? `¿Estás seguro de activar al Representante Legal <b>${$(this).attr('data-nombre')}</b>?` : `¿Estás seguro de desactivar al Representante Legal <b>${$(this).attr('data-nombre')}</b>?`;
    }
    tipoTransaccion = tipoT;
    id_opcion = $(this).data('idopcion');
});

// EVENTOS DEL BOTÓN AGREGAR REPRESENTANTE LEGAL
$(document).on('click', '#btnAgregar', function (e) {
    e.preventDefault();
    var nombre = $("#nombre").val();
    var validaNombre = ($("#nombre").val().length == 0) ? 0 : 1;
    var dataExp1 = new FormData();
    dataExp1.append("nombre", nombre);
    dataExp1.append("tipoTransaccion", tipoTransaccion);
    dataExp1.append("id_opcion", id_opcion);
    if (validaNombre == 0 && tipoTransaccion == 0) {
        alerts.showNotification('top', 'right', 'Asegúrate de ingresar un valor.', 'warning');
    } else {
        $('#btnAgregar').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Contraloria/agregarRegistroGestorContraloria`,
            data: dataExp1,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data) {
                if (data) {
                    alerts.showNotification('top', 'right', `Registro ${tipoTransaccion == 0 ? 'insertado' : 'actualizado'} exitosamente.`, 'success');
                    $('#btnAgregar').prop('disabled', false);
                    $('#modal').modal('hide');
                    $('#gestorContraloria').DataTable().ajax.reload();
                } else {
                    $('#btnAgregar').prop('disabled', false);
                    alerts.showNotification('top', 'right', `Registro no ${tipoTransaccion == 0 ? 'insertado' : 'actualizado'}.`, 'danger');
                }
            },
            error: function () {
                $('#btnAgregar').prop('disabled', false);
                $('#modal').modal('hide');
                $('#gestorContraloria').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

// MODAL PARA REALIZAR EL CAMBIO DE LOTES CONTRATADOS POR INTERCAMBIO
$(document).on('click', '.confirmarCambio', function () {
    $('#modalConfirmarCambio').modal('show');
    document.getElementById("confirmarCambioEstatus").innerHTML = `¿Estás seguro de realizar el cambio de estatus del lote <b>${$(this).attr('data-nombreLote')}</b>?`;
    idLote = $(this).data('idlote');
});

// EVENTOS DEL BOTÓN PARA REALIZAR EL CAMBIO DE LOTES CONTRATADOS POR INTERCAMBIO
$(document).on('click', '#btnConfirmarCambio', function (e) {
    e.preventDefault();
    var dataExp1 = new FormData();
    dataExp1.append("idLote", idLote);
    $('#btnConfirmarCambio').prop('disabled', true);
    $.ajax({
        url: `${general_base_url}Contraloria/cambiarEstatusLote`,
        data: dataExp1,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (data) {
            if (data) {
                alerts.showNotification('top', 'right', `Registro actualizado exitosamente.`, 'success');
                $('#btnConfirmarCambio').prop('disabled', false);
                $('#modalConfirmarCambio').modal('hide');
                $('#tablaIntercambios').DataTable().ajax.reload();
            } else {
                $('#btnConfirmarCambio').prop('disabled', false);
                alerts.showNotification('top', 'right', `Registro no actualizado.`, 'danger');
            }
        },
        error: function () {
            $('#btnConfirmarCambio').prop('disabled', false);
            $('#modalConfirmarCambio').modal('hide');
            $('#tablaIntercambios').DataTable().ajax.reload();
            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
        }
    });
});

// MODAL PARA REALIZAR EL CAMBIO DE REPRESENTANTE LEGAL POR LOTE
$(document).on('click', '.cambiarRlLote', function () {
    $('#modalCambioRL').modal('show');
});

// EVENTOS DEL BOTÓN PARA ACTUALIZAR EL REPRESENTANTE LEGAL POR LOTE
$(document).on('click', '#btnActualizarRL', function (e) {
    e.preventDefault();
    var opcionNombreRl = $("#selectorCambioRL").val();
    var validarOpcionNombre = ($("#selectorCambioRL").val().length == 0) ? 0 : 1;
    var dataExp1 = new FormData();
    dataExp1.append("opcionNombreRl", opcionNombreRl);
    if (validarOpcionNombre == 0) {
        alerts.showNotification('top', 'right', 'Asegúrate de ingresar un valor.', 'warning')
    } else {
        $('#btnActualizarRL').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Contraloria/actualizarRlLote`,
            data: dataExp1,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST'
        });
    }
});

// TABLA MODELOS CASA 


$("#cambiarrepresentante").change(function () {
    selectedRl = $(this).val();
    selectedLabelC = $("#cambiarrepresentante option:selected").text();


});

function ConstruirTablaCAmbiarRepresentante(idCondominio) {
    $("#divtablaCambiarRepresentanteLegal").removeClass("hide");
    if (idCondominio) {
        $('#tablaCambiarRepresentanteLegal thead tr:eq(0) th').each(function (i) {
            var title = $(this).text();
            titulosTablaIntercambios.push(title);
            $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
            $('input', this).on('keyup change', function () {
                if (tablaCambiarRepresentanteLegal.column(i).search() !== this.value)
                    tablaCambiarRepresentanteLegal.column(i).search(this.value).draw();
            });
        });
        tablaCambiarRepresentanteLegal = $("#tablaCambiarRepresentanteLegal").DataTable({
            dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            width: '100%',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Exportar registros a Excel',
                    title: "Listado de lotes contratados por intercambio",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                        format: {
                            header: function (d, columnIdx) {
                                return ' ' + titulosTablaIntercambios[columnIdx] + ' ';
                            }
                        }
                    }
                }
            ],
            language: {
                url: `${general_base_url}static/spanishLoader_v2.json`,
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            pagingType: "full_numbers",
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            bAutoWidth: false,
            fixedColumns: true,
            ordering: false,
            scrollX: true,
            destroy: true,
            columns: [
                { data: 'nombreResidencial' },
                { data: 'nombreCondominio' },
                { data: 'nombreLote' },
                { data: 'idLote' },
                { data: 'referencia' },
                {
                    data: function (d) {
                        return `<span>${d.nombreRL != null ? d.nombreRL : 'N/A'}</span>`
                    }
                },
                {
                    orderable: false,
                    data: function (d) {
                        return `<div class="d-flex justify-center"><button href="#" class="btn-data btn-blueMaderas modalCambioRepresentanteB"  data-nombreLoteText="${d.nombreLote}" data-idlote="${d.idLote}" data-cliente="${d.idCliente}" data-nombrerl="${d.nombreRL}" data-idrl="${d.id_rl}" data-toggle="tooltip" data-placement="top" title="${_("editar")}"><i class="fas fa-pencil-alt"></i></button></div>`;
                    }
                }
            ],
            columnDefs: [
                {
                    searchable: false,
                    orderable: false,
                    targets: 0
                },
            ],
            ajax: {
                url: `${general_base_url}Contraloria/getDatosTablaRepresentanteLegal/${idCondominio}`,
                dataSrc: "",
                type: "POST",
                cache: false,
            },
            order: [[1, 'asc']]
        });
        $('#tablaCambiarRepresentanteLegal').on('draw.dt', function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            });
        });
    }
}
// FUNCIóN PARA LLENAR TABLA CON REPRESENTANTES LEGALES
function llenarTablaRl(tipoOperacion) {
    $('#gestorContraloria thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        titulosGestor.push(title);
        $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
        $('input', this).on('keyup change', function () {
            if (tablaGestor.column(i).search() !== this.value)
                tablaGestor.column(i).search(this.value).draw();
        });
    });
    tablaGestor = $("#gestorContraloria").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Exportar registros a Excel',
                title: "Listado de representantes legales",
                exportOptions: {
                    columns: [0, 1, 2, 3],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosGestor[columnIdx] + ' ';
                        }
                    }
                }
            },
            {
                text: '<i class="fa fa-plus" aria-hidden="true"></i>',
                className: 'btn btn-azure agregar',
                titleAttr: 'Agregar Representante Legal',
                title: "Agregar Representante Legal",
                attr: {
                    'data-transaccion': 0
                }
            }
        ],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        bAutoWidth: false,
        fixedColumns: true,
        ordering: false,
        scrollX: true,
        destroy: true,
        columns: [
            { data: 'id_opcion' },
            { data: 'nombre' },
            {
                data: function (d) {
                    if (d.estatus == 1) {
                        return '<center><span class="label lbl-green">ACTIVO</span><center>';
                    } else {
                        return '<center><span class="label lbl-warning">INACTIVO</span><center>';
                    }
                }
            },
            { data: 'fecha_creacion' },
            {
                orderable: false,
                data: function (d) {
                    return `<div class="d-flex justify-center"><button href="#" class="btn-data agregar ${d.estatus == 0 ? 'btn-green' : 'btn-warning'}" data-nombre="${d.nombre}" data-toggle="tooltip" data-placement="top" title="EDITAR INFORMACIÓN" data-transaccion="${d.estatus == 0 ? '1' : '2'}" data-idopcion="${d.id_opcion}"><i class="${d.estatus == 0 ? 'fas fa-unlock' : 'fas fa-lock'}"></i></button></div>`;

                }
            }
        ],
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: 0
            },
        ],
        ajax: {
            url: `${general_base_url}Contraloria/getDatosTabla/${tipoOperacion}`,
            dataSrc: "",
            type: "POST",
            cache: false,
        },
        order: [[1, 'asc']]
    });

    $('#gestorContraloria').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}
// FUNCION PARA LLENAR LA TABLA DE LOTES DISPONIBLES PARA CAMBIO DE REPRESENTANTE LEGAL
function llenarTablaCambioRL(tipoOperacion) {
    if ($("#nombreLote").val().length == 0) {
        alerts.showNotification('top', 'right', 'Asegúrate de ingresar un valor.', 'warning')
    } else {
        $("#divTablaCambioRL").removeClass("hide");
        $('#tablaCambioRL thead tr:eq(0) th').each(function (i) {
            var title = $(this).text();
            titulosTablaCambioRL.push(title);
            $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
            $('input', this).on('keyup change', function () {
                if (tablaCambioRL.column(i).search() !== this.value)
                    tablaCambioRL.column(i).search(this.value).draw();
            });
        });
        tablaCambioRL = $("#tablaCambioRL").DataTable({
            dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            width: '100%',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Exportar registros a Excel',
                    title: "Listado de lotes",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                        format: {
                            header: function (d, columnIdx) {
                                return ' ' + titulosTablaCambioRL[columnIdx] + ' ';
                            }
                        }
                    }
                }
            ],
            language: {
                url: `${general_base_url}static/spanishLoader_v2.json`,
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            pagingType: "full_numbers",
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            bAutoWidth: false,
            fixedColumns: true,
            ordering: false,
            scrollX: true,
            destroy: true,
            columns: [
                { data: 'nombreResidencial' },
                { data: 'nombreCondominio' },
                { data: 'nombreLote' },
                { data: 'idLote' },
                { data: 'referencia' },
                { data: 'nombreRl' },
                {
                    orderable: false,
                    data: function (d) {
                        return `<div class="d-flex justify-center"><button href="#" class="btn-data btn-violetBoots cambiarRlLote" data-toggle="tooltip" data-placement="top" title="EDITAR INFORMACIÓN"><i class="fas fa-exchange-alt"></i></button></div>`;
                    }
                }
            ],
            columnDefs: [
                {
                    searchable: false,
                    orderable: false,
                    targets: 0
                },
            ],
            ajax: {
                url: `${general_base_url}Contraloria/getDatosTabla/${tipoOperacion}`,
                dataSrc: "",
                type: "POST",
                cache: false,
                data: {
                    nombreLote: $('#nombreLote').val()
                }


            },
            order: [[1, 'asc']]
        });

        $('#tablaCambioRL').on('draw.dt', function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            });
        });
    }
}
// MODAL PARA REALIZAR EL CAMBIO DE LOTES CONTRATADOS POR INTERCAMBIO
$(document).on('click', '.modalCambioRepresentanteB', function () {
    $('#modalCambioRepresentante').modal('show');
    idLote = $(this).data('idlote');
    nombreLoteText = $(this).data('nombrelotetext');
    idRl = $(this).data('idrl');
    idCliente = $(this).data('cliente');
    nombreRl = $(this).data('nombrerl');

});

$(document).on('click', '.cambiarRlLote', function () {
    $('#modalCambioRL').modal('show');
});

$(document).on('click', '#btnCambiarRL', function (e) {
    e.preventDefault();
    var representanteLegal = $(this).data('#cambiarrepresentante');
    var validarOpcionRl = ($("#cambiarrepresentante").val().length == 0) ? 0 : 1;
    if (validarOpcionRl == 0) {
        alerts.showNotification('top', 'right', 'Asegúrate de seleccionar un valor.', 'warning');
    } else {
        if (selectedRl == idRl) {
            alerts.showNotification('top', 'right', 'Estas seleccionando el mismo valor.', 'warning');

        } else {

            // abrir modal para validar el ingreso 
            $('#modalConfimarCambioRl').modal('show');
            document.getElementById("confirmarCambioEstatusRepresentanteLegal").innerHTML = `¿Estás seguro de cambiar el representante legal del lote <b>${nombreLoteText}</b> de <b>${nombreRl}</b> a <b>${selectedLabelC}</b>?`;
            $('#modalCambioRepresentante').modal('hide');
        }


    }
});
$(document).on('click', '#btnConfirmarCambioRl', function (e) {
    e.preventDefault();
    var formData = new FormData();
    formData.append("representanteLegal", representanteLegal);
    formData.append("idLote", idLote);
    formData.append("idRl", selectedRl);
    formData.append("idCliente", idCliente);
  
    if (selectedRl !== 0) {
        $('#btnCambiarRL').prop('disabled', true);

        $.ajax({
            url: `${general_base_url}Contraloria/modificarRlLote`,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            beforeSend: function () {
                $('#spiner-loader').removeClass('hide');
            },
            success: function (data) {
                data = JSON.parse(data);
                if (data.message == 'OK') {
                    $('#btnCambiarRL').prop('disabled', false);

                    $('#spiner-loader').addClass('hide');
                    $('#tablaCambiarRepresentanteLegal').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", 'Se ha actualizo correctamente', "success");
                    // modalConfimarCambioRl
                    $('#modalConfimarCambioRl').modal('hide');
                    // idRl  = selectedRl;
                    // nombreLoteText = selectedLabelC;
                    $('#cambiarrepresentante').val('').selectpicker('refresh');
                } else {
                    $('#btnCambiarRL').prop('disabled', false);

                    $('#spiner-loader').addClass('hide');
                    alerts.showNotification("top", "right", 'Ha ocurrido un error al avanzar' +
                        ' el registro, intentalo nuevamente', "danger");
                }
            }, error: function () {
                $('#spiner-loader').addClass('hide');
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }

        });

    } else {
        alerts.showNotification('top', 'right', 'Asegúrate de seleccionar un representante legal', 'warning');
    }
});