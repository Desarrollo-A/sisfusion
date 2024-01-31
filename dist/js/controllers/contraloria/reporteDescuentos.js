sp = {
    initFormExtendedDatetimepickers: function () {
      var today = new Date();
      var date =
        today.getFullYear() +
        "-" +
        (today.getMonth() + 1) +
        "-" +
        today.getDate();
      var time = today.getHours() + ":" + today.getMinutes();
      $(".datepicker").datetimepicker({
        format: "DD/MM/YYYY",
        icons: {
          time: "fa fa-clock-o",
          date: "fa fa-calendar",
          up: "fa fa-chevron-up",
          down: "fa fa-chevron-down",
          previous: "fa fa-chevron-left",
          next: "fa fa-chevron-right",
          today: "fa fa-screenshot",
          clear: "fa fa-trash",
          close: "fa fa-remove",
          inline: true,
        },
      });
    },
  };
var usuarios = [];
$('#spiner-loader').removeClass('hide');

$(document).ready(function () {
    sp.initFormExtendedDatetimepickers();
    $(".datepicker").datetimepicker({ locale: "es" });
    setInitialValues();
    $.post(general_base_url + "/Comisiones/getDatosReporteDesc", function (data) {
        let sedes = data.sedes, empresa = data.empresas, puestos = data.puestos;
        usuarios = data.usuarios;      
        for (var i = 0; i < sedes.length; i++) {
            var id = sedes[i]['id_sede'];
            var name = sedes[i]['nombre'];
            $(`#sede`).append($('<option>').val(id).text(name.toUpperCase()));
        }
        for (var i = 0; i < empresa.length; i++) {
            var id = empresa[i]['nombre'];
            $(`#empresa`).append($('<option>').val(id).text(id.toUpperCase()));
        }
        for (var i = 0; i < puestos.length; i++) {
            var id = puestos[i]['id_opcion'];
            var name = puestos[i]['nombre'];
            $(`#puesto`).append($('<option>').val(id).text(name.toUpperCase()));
        }
        $(`.selectpicker`).selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');

});
$('#puesto').change( function(){
    idPuesto = $(this).val();
    let getUsers = usuarios.filter(users => users.id_rol == idPuesto);
    $("#usuarios").html("");
    for (var i = 0; i < getUsers.length; i++) {
        var id = getUsers[i]['id_usuario'];
        var name = getUsers[i]['nombre'];
        $(`#usuarios`).append($('<option>').val(id).text(name.toUpperCase()));
    }
    $(`#usuarios`).selectpicker('refresh');
});
function setInitialValues() {
    // BEGIN DATE
    const fechaInicio = new Date();
    // Iniciar en este año, este mes, en el día 1
    const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
    // END DATE
    const fechaFin = new Date();
    // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
    const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
    finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
    finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');finalBeginDate2 = [('0' + beginDate.getDate()).slice(-2), ('0' + (beginDate.getMonth() + 1)).slice(-2), beginDate.getFullYear()].join('/');
    finalEndDate2 = [('0' + endDate.getDate()).slice(-2), ('0' + (endDate.getMonth() + 1)).slice(-2), endDate.getFullYear()].join('/');
    $('#beginDate').val(finalBeginDate2);
    $('#endDate').val(finalEndDate2);
    $('[data-toggle="tooltip"]').tooltip();
  }
  var totaPen = 0;
var tr;



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

    $('#tabla_prestamos tbody').on('click', '.detalle-prestamo', function () {
        const idPrestamo = $(this).val();
        let importacion = '';
        $.getJSON(`${general_base_url}Comisiones/getDetallePrestamo/${idPrestamo}`).done(function (data) {
            
            const { general, detalle } = data;

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


