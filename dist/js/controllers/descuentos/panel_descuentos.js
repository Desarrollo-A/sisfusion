var totaPen = 0;
var tr;
$(document).ready(function () {
    $.post(general_base_url + "/Comisiones/lista_estatus_descuentos", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#tipo").append($('<option>').val(id).text(name.toUpperCase()));     
        }
        $("#tipo").selectpicker('refresh');
    }, 'json');
});

$('#tipo').change(function (ruta) {
    tipo = $('#tipo').val();
    let m = $('#monto').val();
    let texto = '';

    if (tipo == 18) {
        texto = 'Esté es un pago recurrente, el cual se hará cada mes hasta cubrir el monto prestado.'
        document.getElementById("numeroP").value = 1;

        if (m != '') {
            verificar();
        }
    } else {
        texto = 'Esté es un pago único que se hará en una sola exhibición.'
        document.getElementById("numeroP").value = 1;

        if (m != '') {
            verificar();
        }
    }
    document.getElementById("texto").innerHTML = texto;

});

function closeModalEng() {
    document.getElementById("form_prestamos").reset();
    $("#tipo").selectpicker("refresh");
    $("#roles").selectpicker("refresh");
    document.getElementById("users").innerHTML = '';
    $("#miModal").modal('toggle');
}

function replaceAll(text, busca, reemplaza) {
    while (text.toString().indexOf(busca) != -1)
        text = text.toString().replace(busca, reemplaza);
    return text;
}

$("#form_prestamos").on('submit', function (e) {
    e.preventDefault();
    let formData = new FormData(document.getElementById("form_prestamos"));
    $.ajax({
        url: 'savePrestamo',
        data: formData,
        method: 'POST',
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {

            if (data == 1) {
                $('#tabla_prestamos').DataTable().ajax.reload(null, false);
                closeModalEng();
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "Préstamo registrado con éxito.", "success");
            } else if (data == 2) {
                $('#tabla_prestamos').DataTable().ajax.reload(null, false);
                closeModalEng();
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "Pago liquidado.", "warning");
            } else if (data == 3) {
                closeModalEng();
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un préstamo activo.", "warning");
            }
            else if (data == 4) {
                closeModalEng();
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "Erro al subir el archivo activo.", "warning");
            }
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#form_delete").on('submit', function (e) {
    e.preventDefault();
    let formData = new FormData(document.getElementById("form_delete"));
    $.ajax({
        url: 'BorrarPrestamo',
        data: formData,
        method: 'POST',
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            
            if (data == 1) {
                $('#tabla_prestamos').DataTable().ajax.reload(null, false);
                $('#myModalDelete').modal('hide');
                alerts.showNotification("top", "right", "Préstamo eliminado con éxito.", "success");
                document.getElementById("form_delete").reset();
            } else {
                $('#myModalDelete').modal('hide');
                alerts.showNotification("top", "right", "Error.", "warning");
            }
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#tabla_prestamos").ready(function () {
    let titulos = [];
    $('#tabla_prestamos thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {

            if (tabla_nuevas.column(i).search() !== this.value) {
                tabla_nuevas.column(i).search(this.value).draw();
                var total = 0;
                var totalAbonado = 0;
                var totalPendiente = 0;
                var index = tabla_nuevas.rows({ selected: true, search: 'applied' }).indexes();
                var data = tabla_nuevas.rows(index).data();

                $.each(data, function (i, v) {
                    total += parseFloat(v.monto);
                    totalPendiente += v.monto - v.total_pagado;

                    if (v.total_pagado == null) {
                        totalAbonado += 0;
                    } else {
                        totalAbonado += parseFloat(v.total_pagado);
                    }
                });
                var to1 = formatMoney(total);
                var to2 = formatMoney(totalAbonado);
                var to3 = formatMoney(totalPendiente);
                document.getElementById("totalPendiente").textContent = to3;
                document.getElementById("totalp").textContent = to1;
                document.getElementById("totalAbonado").textContent = to2;
            }
        });
    });

    $('#tabla_prestamos').on('xhr.dt', function (e, settings, json, xhr) {
        var total = 0;
        var total2 = 0;
        var total3 = 0;

        $.each(json.data, function (i, v) {
            total += parseFloat(v.monto);
            total3 += v.monto - v.total_pagado;

            if (v.total_pagado == null) {
                total2 += 0;
            } else {
                total2 += parseFloat(v.total_pagado);
            }
        });

        var to = formatMoney(total);
        var to2 = formatMoney(total2);
        var to3 = formatMoney(total3);
        document.getElementById("totalPendiente").textContent = to3;
        document.getElementById("totalp").textContent = to;
        document.getElementById("totalAbonado").textContent = to2;
    });

    tabla_nuevas = $("#tabla_prestamos").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'PRÉSTAMOS Y PENALIZACIONES',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                format: {
                    header: function (d, columnIdx) {
                        if (columnIdx >= 0) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        scrollX: true,
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        scrollX: true,
        destroy: true,
        ordering: false,
        columns: [{ 
            data: 'id_prestamo' 
        },
        { 
            data: 'id_usuario' 
        },
        { 
            data: 'nombre' 
        },
        {
            data: function (d) {
                let formato
                formato = `<p class="m-0">${formatMoney(d.monto)} </p> `;
                return formato;
            }
        },
        { 
            data: 'num_pagos'
        },
        {
            data: function (d) {
                let formato
                formato = `<p class="m-0">${formatMoney(d.pago_individual)} </p> `;
                return formato;
            }
        },
        {
            data: function (d) {
                let formato
                formato = `<p class="m-0">${formatMoney(d.total_pagado)} </p> `;
                return formato;
            }
        },
        {
            data: function (d) {
                let color = 'lbl-gral';
                let resultado = d.monto - d.total_pagado;
                if (resultado > 0.5) {
                    color = 'lbl-orangeYellow';
                }
                if (resultado < 0.0) {
                    resultado = 0;
                }
                return '<span class="m-0 ' + color + '">' + formatMoney(resultado) + '</span>';
            }
        },
        { 
            data: 'comentario'
        },
        {
            data: function (d) {
                if (d.estatus == 1) {
                    formato = '<span class="label lbl-blueMaderas " >ACTIVO</span>';
                } else if (d.estatus == 3 || d.estatus == 2) {
                    formato = '<span class="label lbl-green" >LIQUIDADO</span>';
                } else if (d.estatus == 0) {
                    formato = '<span class="label lbl-warning" >CANCELADO</span>';
                }
                return formato;
            }
        },
        {
            "data": function (d) {
                let etiqueta = '';
                color = 'lbl-blueMaderas';

                if (d.id_opcion == 18) { 
                    color = 'lbl-green';
                } else if (d.id_opcion == 19) {
                    color = 'lbl-azure';
                } else if (d.id_opcion == 20) { 
                    color = 'lbl-sky';
                } else if (d.id_opcion == 21) {
                    color = 'lbl-violetDeep';
                } else if (d.id_opcion == 22) {
                    color = 'lbl-violetDeep';
                } else if (d.id_opcion == 23) { 
                    color = 'lbl-violetChin';
                } else if (d.id_opcion == 24) {
                    color = 'lbl-orangeYellow';
                } else if (d.id_opcion == 25) { 
                    color = 'lbl-acidGreen';
                } else if (d.id_opcion == 26) {
                    color = 'lbl-gray';
                }
                return '<p><span class="label ' + color + '" >' + d.tipo + '</span></p>';
            }
        },
        {
            data: function (d) {
                
                if (d.fecha_creacion_referencia !== null && d.estatus == 1) {
                    const fecha = new Date(d.fecha_creacion_referencia);
                    const now = new Date();
                    const mesesDif = monthDiff(fecha, now);

                    if (mesesDif >= 2) {
                        return `<p> ${d.fecha_creacion_referencia.split('.')[0]} <span class="label" style="background: orange">Sin saldo en ${mesesDif} meses</label></p>`;
                    }
                }
                return '<p class="m-0">' + d.fecha_creacion.split('.')[0] + '</p>';
            }
        },
        {
            "orderable": false,
            data: function (d) {
                var botonesModal = '';

                if (d.id_prestamo2 == null && d.estatus == 1 && d.id_opcion != 28) {
                    botonesModal += `<button href="#" value="${d.id_prestamo}" data-name="${d.nombre}" class="btn-data btn-warning delete-prestamo" title="Eliminar"><i class="fas fa-trash"></i></button>`;
                }

                if (d.estatus == 1 && d.total_pagado == null && d.id_opcion != 28 ) {
                    botonesModal += `<button href="#" value="${d.id_prestamo}" data-idPrestamo="${d.id_prestamo}" data-tipo="${d.tipo}" data-idtipo="${d.id_opcion}"  data-name="${d.nombre}" data-comentario="${d.comentario}" data-individual="${d.pago_individual}" data-npagos="${d.num_pagos}" data-monto="${d.monto}" class="btn-data btn-sky edit-prestamo" title="Editar"><i class="fas fa-pen-nib"></i></button>`;
                }

                if (d.total_pagado != null || d.total_pagado > 0) {
                    botonesModal += `<button href="#" value="${d.id_prestamo}" class="btn-data btn-blueMaderas detalle-prestamo" title="Historial"><i class="fas fa-info"></i></button>`;
                }

                return '<div class="d-flex justify-center">' + botonesModal + '<div>';
            }
        }],
        ajax: {
            url: general_base_url + "Comisiones/getPrestamos",
            type: "POST",
            cache: false,
            data: function (d) {
            }
        },
    });
    $('#tabla_prestamos tbody').on('click', '.delete-prestamo', function () {
        const idPrestamo = $(this).val();
        const nombreUsuario = $(this).attr("data-name");
        const Modalbody = $('#myModalDelete .modal-body');
        const Modalfooter = $('#myModalDelete .modal-footer');
        Modalbody.html('');
        Modalfooter.html('');
        Modalbody.append(`<input type="hidden" value="${idPrestamo}" name="idPrestamo" id="idPrestamo"> <h4>¿Ésta seguro que desea borrar el préstamo de ${nombreUsuario}?</h4>`);
        Modalfooter.append(`<button type="button"  class="btn btn-danger btn-simple " data-dismiss="modal" >Cerrar</button>
				<button  type="submit" name=/"disper_btn"  id="dispersar" class="btn btn-primary">Aceptar</button>`);
        $("#myModalDelete").modal();
    });


    $('#tabla_prestamos tbody').on('click', '.edit-prestamo', function () {
        const idPrestamo = $(this).val();
        const prestamoId = $(this).attr("data-idPrestamo");
        const montoPagos = $(this).attr("data-individual");
        const nombreUsuario = $(this).attr("data-name");
        const numeroPagos = $(this).attr("data-npagos");
        const pagoEdit = $(this).attr("data-monto");
        const comentario = $(this).attr("data-comentario");
        const tipo = $(this).attr("data-tipo");
        const id_tipo = $(this).attr("data-idtipo");

        document.getElementById("montoPagos").value = '';
        document.getElementById("numeroPagos").value = '';
        document.getElementById("pagoEdit").value = '';
        document.getElementById("informacionText").value = '';
        document.getElementById("prestamoId").value = '';

        $("#tipoD").val(id_tipo).selectpicker('refresh');
        
        document.getElementById("montoPagos").value = pagoEdit;
        document.getElementById("numeroPagos").value = numeroPagos;
        document.getElementById("pagoEdit").value = montoPagos;
        document.getElementById("informacionText").value = comentario;
        document.getElementById("prestamoId").value = prestamoId;
    
        $("#ModalEdit").modal();
    });
    $(document).on("click", ".updatePrestamo", function () {

        montoPagos = document.getElementById("montoPagos").value;
        numeroPagos = document.getElementById("numeroPagos").value;
        pagoEdit = document.getElementById("pagoEdit").value;
        comentario = document.getElementById("informacionText").value;
        prestamoId = document.getElementById("prestamoId").value;
        tipoD      = document.getElementById("tipoD").value;
        bandera_request = comentario == '' ? false : true;
        pagoEdit = pagoEdit.replace(/,/g, "");
        montoPagos = montoPagos.replace(/,/g, "");
        numeroPagos = numeroPagos.replace(/,/g, "");

        if (pagoEdit != '' && numeroPagos != '' && montoPagos != '' && comentario != '' && prestamoId != '' && bandera_request) {
            if (pagoEdit > 0 && montoPagos > 0 && numeroPagos > 0) {
                $.ajax({
                    url: 'updatePrestamos',
                    type: 'POST',
                    dataType: "json",
                    data: {
                        "tipoD":    tipoD,
                        "pagoEdit": parseInt(pagoEdit),
                        "numeroPagos": parseInt(numeroPagos),
                        "montoPagos": parseInt(montoPagos),
                        "comentario": comentario,
                        "prestamoId": prestamoId,
                    },
                    success: function (data) {
                        alerts.showNotification("top", "right", "" + data.message + "", "" + data.response_type + "");
                        $('#tabla_prestamos').DataTable().ajax.reload(null, false);
                        $('#ModalEdit').modal('toggle');
                    },
                    error: (a, b, c) => {
                        alerts.showNotification("top", "right", "Descuento No actualizado .", "error");
                    }
                });
            } else {
                alerts.showNotification("top", "right", "Asegúrese que no existan valores negativos.", "error");
            }
        } else {
            alerts.showNotification("top", "right", "Es necesario revisar que no se tenga valores vacios.", "error");
        }
    });

    $('#montoPagos').change(function () {
        const bandera = true;
        Monto = document.getElementById("montoPagos").value;
        numeroPagos = document.getElementById("numeroPagos").value;
        mensualidades = document.getElementById("pagoEdit").value;
        comentario = document.getElementById("informacionText").value;
        var input1=  document.getElementById('montoPagos');
        var input2=  document.getElementById('numeroPagos');
        
        input1.addEventListener('input',function(){

        if (this.value.length > 12) 
            this.value = this.value.slice(0,12); 
        })
        input2.addEventListener('input',function(){

            if (this.value.length > 3) 
                this.value = this.value.slice(0,3); 
            })

        if (numeroPagos == null || numeroPagos == '') {
            bandera = false;
        }

        if (Monto == null || Monto == '') {
            bandera = false;
        }

        if (bandera) {
            NuevasMensualidades = Monto / numeroPagos;
            document.getElementById("pagoEdit").value = (formatMoney(NuevasMensualidades.toFixed(3)));
        } else {
            alerts.showNotification("top", "right", "Todos los campos deben de estar llenos.", "error");

        }
    });
    $('#numeroPagos').change(function () {
        const bandera = true;
        Monto = document.getElementById("montoPagos").value;
        numeroPagos = document.getElementById("numeroPagos").value;
        mensualidades = document.getElementById("pagoEdit").value;
        comentario = document.getElementById("informacionText").value;
        var input1=  document.getElementById('montoPagos');
        var input2=  document.getElementById('numeroPagos');

        input1.addEventListener('input',function(){

        if (this.value.length > 12) 
            this.value = this.value.slice(0,12); 
        })
        input2.addEventListener('input',function(){

            if (this.value.length > 3) 
                this.value = this.value.slice(0,3); 
            })

        if (numeroPagos == null || numeroPagos == '') {
            bandera = false;
        }

        if (Monto == null || Monto == '') {
            bandera = false;
        }

        if (bandera) {
            NuevasMensualidades = Monto / numeroPagos;
            document.getElementById("pagoEdit").value = (formatMoney(NuevasMensualidades.toFixed(3)));
        } else {
            alerts.showNotification("top", "right", "Todos los campos deben de estar llenos.", "error");
        }
    });

    $('#tabla_prestamos tbody').on('click', '.detalle-prestamo', function () {
        $('#spiner-loader').removeClass('hide');
        const idPrestamo = $(this).val();
        let importacion = '';
        $.getJSON(`${general_base_url}Comisiones/getDetallePrestamo/${idPrestamo}`).done(function (data) {
            
            const { general, detalle } = data;
            $('#spiner-loader').addClass('hide');

            if (detalle.length == 0) {
                alerts.showNotification("top", "right", "Este préstamo no tiene pagos aplicados.", "warning");
            } else {
                const detalleHeaderModal = $('#detalle-prestamo-modal .modal-header');
                const detalleBodyModal = $('#detalle-prestamo-modal .modal-body');
                const importaciones = [20, 19, 18, 17, 16, 15, 14, 13, 12, 11];

                if (importaciones.indexOf(parseInt(idPrestamo)) >= 0) {
                    importacion = 'Importación contraloría';
                }
                detalleHeaderModal.html('');
                detalleBodyModal.html('');
                let numPagosReal = general.num_pago_act == general.num_pagos ? general.num_pago_act : general.num_pago_act - 1;

                detalleHeaderModal.append(`<h4 class="card-title"><b>Detalle del préstamo</b><br><p>${importacion}</p></h4>`);
                detalleBodyModal.append(`<div class="row">
                        <div class="col col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <h6>USUARIO: <b>${general.nombre_completo}</b></h6>
                        </div>
                        <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <h6>PAGO MENSUAL: <b>${formatMoney(general.pago_individual)}</b></h6>
                        </div>
                        <div class="col col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <h6>PAGOS APLICADOS: <b>${numPagosReal}</b></h6>
                        </div>
                        <div class="col col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <h6>MENSUALIDADES: <b>${general.num_pagos}</b></h6>
                        </div>
                        <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <h6>MONTO PRESTADO: <b>${formatMoney(general.monto_prestado)}</b></h6>
                        </div>
                        <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <h6>ABONADO: <b style="color:green;">${formatMoney(general.total_pagado)}</b></h6>
                        </div>
                        <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <h6>PENDIENTE: <b style="color:orange;">${formatMoney(general.pendiente)}</b></h6>
                        </div>
                    </div>`);

                let htmlTableBody = '';
                for (let i = 0; i < detalle.length; i++) {
                    htmlTableBody += '<tr>';
                    htmlTableBody += `<td scope="row">${general.nombre_completo}</td>`;
                    htmlTableBody += `<td scope="row">${detalle[i].sede}</td>`;
                    htmlTableBody += `<td scope="row">${detalle[i].tipo}</td>`;
                    htmlTableBody += `<td scope="row"><b>${detalle[i].np}</b></td>`;
                    htmlTableBody += `<td scope="row">${detalle[i].nombreResidencial}</td>`;
                    htmlTableBody += `<td>${detalle[i].nombreLote}</td>`;
                    htmlTableBody += `<td scope="row"><b>${detalle[i].id_pago_i}</b></td>`;
                    htmlTableBody += `<td style="width:50% !important;">${detalle[i].comentario}</td>`;
                    htmlTableBody += `<td style="width:20% !important;">${detalle[i].fecha_pago}</td>`;
                    htmlTableBody += `<td><b>${formatMoney(detalle[i].abono_neodata)}</b></td>`;
                    htmlTableBody += `<td style="width:20% !important;">${detalle[i].estatus}</td>`;
                    htmlTableBody += '</tr>';
                }

                detalleBodyModal.append(`<table class="table table-striped table-hover" id="table_detalles">
                        <thead>
                            <tr>
                                <th>USUARIO</th>
                                <th>SEDE</th>
                                <th>TIPO</th>
                                <th>NUMERO</th>
                                <th>PROYECTO</th>
                                <th>LOTE</th>
                                <th>ID PAGO</th>
                                <th>COMENTARIO</th>
                                <th>FECHA</th>
                                <th>MONTO</th>
                                <th>ESTATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${htmlTableBody}
                        </tbody>
                    </table>`);

                $("#detalle-prestamo-modal").modal();

                let titulos2 = [];
                $('#table_detalles thead tr:eq(0) th').each(function (i) {
                    var title = $(this).text();
                    titulos2.push(title);
                    $(this).html('<input type="text" data-toggle="tooltip" data-placement="top" placeholder="' + title + '" title="' + title + '"/>');
                    $('input', this).on('keyup change', function () {
                        if (tableDetalles.column(i).search() !== this.value) {
                            tableDetalles.column(i).search(this.value).draw();
                        }
                    });
                });

                var tableDetalles = $('#table_detalles').DataTable({
                    dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
                    width: "100%",
                    scrollX: true,
                    bAutoWidth:true,
                    buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Descargar archivo de Excel',
                        title: 'PRÉSTAMOS Y PENALIZACIONES',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                            format: {
                                header: function (d, columnIdx) {
                                    return ' ' + titulos2[columnIdx] + ' ';
                                }
                            }
                        }
                    }],
                    ordering: false,
                    "pageLength": 5,
                    "lengthMenu": [5, 10, 25, 50, 75, 100],
                    language: {
                        url: general_base_url + "/static/spanishLoader_v2.json",
                        paginate: {
                            previous: "<i class='fa fa-angle-left'>",
                            next: "<i class='fa fa-angle-right'>"
                        }
                    }
                });
                tableDetalles.order([0, 'desc']).draw();
            }
        })
    });
});

$('#table_detalles').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
});

$(window).resize(function () {
    tabla_nuevas.columns.adjust();
});

$("#roles").change(function () {
    var parent = $(this).val();
    document.getElementById("users").innerHTML = '';

    $('#users').append(` <label class="label control-label">Usuario</label>   
    <select id="usuarioid" name="usuarioid" class="selectpicker m-0 select-gral directorSelect ng-invalid ng-invalid-required" title="SELECCIONA UNA OPCIÓN" required data-live-search="true"></select>`);
    $.post('getUsuariosRol/' + parent + '/1', function (data) {
        var len = data.length;

        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['id_usuario'] +' - '+ data[i]['name_user'];
            $("#usuarioid").append($('<option>').val(id).attr('data-value', id).text(name));
        }

        if (len <= 0) {
            $("#usuarioid").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }

        $("#usuarioid").selectpicker('refresh');
    }, 'json');
});

function verificar() {
    var input1=  document.getElementById('monto');
    var input2=  document.getElementById('numeroP');
    let monto = parseFloat(replaceAll($('#monto').val(), ',', ''));
    input1.addEventListener('input',function(){

        if (this.value.length > 12) 
            this.value = this.value.slice(0,12); 
        })
        input2.addEventListener('input',function(){
            if (this.value.length > 3) 
                this.value = this.value.slice(0,3); 
            })
            
    if ($('#numeroP').val() != '') {
        if (monto < 1 || isNaN(monto)) {
            alerts.showNotification("top", "right", "Debe ingresar un monto valido.", "warning");
            document.getElementById('btn_abonar').disabled = true;
        }
        else {
            let cantidad = parseFloat(replaceAll($('#numeroP').val(), ',', ''));
            resultado = parseFloat(monto / cantidad);
            $('#pago').val(formatMoney(parseFloat(resultado)));
            document.getElementById('btn_abonar').disabled = false;
        }
    }

}
$(document).on('input', '.monto', function () {
    verificar();
});

$(document).on("click", "#preview", function () {
    var itself = $(this);

    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;z-index:999999!important;" src="${general_base_url}static/documentos/evidencia_prestamo_auto/${itself.attr('data-doc')}"></iframe></div>`,
        player: "html",
        title: `Visualizando archivo: evidencia `,
        width: 985,
        height: 660
    });
});

function monthDiff(dateFrom, dateTo) {
    return dateTo.getMonth() - dateFrom.getMonth() + (12 * (dateTo.getFullYear() - dateFrom.getFullYear()))
}