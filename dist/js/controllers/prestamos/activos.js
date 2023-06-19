 $(document).ready(function () {
    
    let titulos_intxt = [];

    $('#tabla_prestamos').on('xhr.dt', function(e, settings, json, xhr) {
        var saldoActivos = 0;
        var saldoAbonado = 0;
        var saldoPendiente = 0;

        $.each(json.data, function (i, v) {

            saldoActivos += parseFloat(v.monto);

            saldoPendiente += v.monto - v.total_pagado;
            if (v.total_pagado == null) {
                saldoAbonado += 0;
            } else {
                saldoAbonado += parseFloat(v.total_pagado);
            }
        });

        var saldoActivos = formatMoney(saldoActivos);
        var saldoAbonado = formatMoney(saldoAbonado);
        var saldoPendiente = formatMoney(saldoPendiente);
        document.getElementById("saldoActivos").textContent = '$' + saldoActivos;
        document.getElementById("saldoAbonado").textContent = '$' + saldoAbonado;
        document.getElementById("saldoPendiente").textContent = '$' + saldoPendiente;

    });


$('#tabla_prestamos thead tr:eq(0) th').each( function (i) {
$(this).css('text-align', 'center');
var title = $(this).text();
titulos_intxt.push(title);
if (i != 12) {
    $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {
        if ($('#tabla_prestamos').DataTable().column(i).search() !== this.value ) {
            $('#tabla_prestamos').DataTable().column(i).search(this.value).draw();
        }
        var index = $('#tabla_prestamos').DataTable().rows({
        selected: true,
        search: 'applied'
    }).indexes();
    var data = $('#tabla_prestamos').DataTable().rows(index).data();
});
}});

prestamosActivosDataTable = $('#tabla_prestamos').dataTable({
    dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: '100%',
    scrollX: true,
    buttons: [
        {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'Préstamos, descuentos y penalizaciones',
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                format: {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
                        }
                    }
            }
        }
    ],
    pagingType: "full_numbers",
    fixedHeader: true,
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, "Todos"]
    ],
    language: {
        url: `${general_base_url}static/spanishLoader_v2.json`,
        paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>"
        }
    },
    scrollX: true,
    destroy: true,
    ordering: false,
    columns: [
        {data: 'id_prestamo'},
        {data: 'id_usuario'},
        {data: 'nombre'},
        { data: function (d) {
                let labelMonto
                labelMonto = `<p class="m-0">$${formatMoney(d.monto)} </p> `;
                return labelMonto;
            }},
        { data: 'num_pagos' },
        { data: function (d) {
                let labelIndividual
                labelIndividual = `<p class="m-0">$${formatMoney(d.pago_individual)} </p> `;
                return labelIndividual;
        }},
        { data: function (d) {
                let labelPagado
                labelPagado = `<p class="m-0">$${formatMoney(d.total_pagado)} </p> `;
                return labelPagado;
        }},
        { data: function (d) {
                let color = 'lbl-gral';
                let resultado = d.monto - d.total_pagado;
                if (resultado > 0.5) {
                    color = 'lbl-orangeYellow';
                } if (resultado < 0.0) {
                    resultado = 0;
                }
                return '<span class="m-0 ' + color + '">$' + formatMoney(resultado) + '</span>';
        }},
        { data: 'comentario' },
        { data: function (d) {
                if (d.estatus == 1) {
                    labelEstatus = '<span class="label lbl-blueMaderas " >ACTIVO</span>';
                } else if (d.estatus == 3 || d.estatus == 2) {
                    labelEstatus = '<span class="label lbl-green" >LIQUIDADO</span>';
                } else if (d.estatus == 0) {
                    labelEstatus = '<span class="label lbl-warning" >CANCELADO</span>';
                }
                return labelEstatus;
        }},
        { data: function (d) {
            if (d.id_opcion == 18) {
                color = 'lbl-green';
            } else if (d.id_opcion == 19) { //SCIO
                color = 'lbl-azure';
            } else if (d.id_opcion == 20) { //PLAZA
                color = 'lbl-sky';
            } else if (d.id_opcion == 21) { //LINEA TELEFÓNICA
                color = 'lbl-violetDeep';
            } else if (d.id_opcion == 22) { //MANTENIMIENTO
                color = 'lbl-violetDeep';
            } else if (d.id_opcion == 23) { //NÓMINA - ANALISTAS DE COMISIONES
                color = 'lbl-violetChin';
            } else if (d.id_opcion == 24) { //NÓMINA - ASISTENTES CDMX
                color = 'lbl-orangeYellow';
            } else if (d.id_opcion == 25) { //NÓMINA - IMSS
                color = 'lbl-acidGreen';
            } else if (d.id_opcion == 26) { //NÓMINA -LIDER DE PROYECTO E INNOVACIÓN
                color = 'lbl-gray';
            } else{
                color = 'lbl-blueMaderas';
            }
            return '<p><span class="label ' + color + '" >' + d.tipo + '</span></p>';
        }},
        { data: function (d) {
            if (d.fecha_creacion_referencia !== null && d.estatus == 1) {
                const fecha = new Date(d.fecha_creacion_referencia);
                const now = new Date();
                const mesesDif = monthDiff(fecha, now);
                
                if (mesesDif >= 2) {
                    return `<p>${d.fecha_creacion_referencia.split('.')[0]}<span class="label" style="background: orange">Sin saldo en ${mesesDif} meses</label></p>`;
                }
            }
            return '<p class="m-0">' + d.fecha_creacion.split('.')[0] + '</p>';
        }},
        { data: function (d) {
            var botonesModal = '';
            botonesModal += `<button href="#" value="${d.id_prestamo}" class="btn-data btn-blueMaderas detalle-prestamo" title="Historial"><i class="fas fa-info"></i></button>`;
            
            if (d.evidencia != null) {
                botonesModal += `<button href="#" value="${d.id_prestamo}"  id="preview" data-doc="${d.evidencia}"  d.evidencia class="btn-data btn-violetDeep " title="Autorización"><i class="fas fa-folder-open"></i></button>`;
            } if (d.id_prestamo2 == null && d.estatus == 1) {
                botonesModal += `<button href="#" value="${d.id_prestamo}" data-name="${d.nombre}" class="btn-data btn-warning delete-prestamo" title="Eliminar"><i class="fas fa-trash"></i></button>`;
            } if (d.estatus == 1 && d.total_pagado == null) {
                botonesModal += `<button href="#" value="${d.id_prestamo}" data-idPrestamo="${d.id_prestamo}" data-tipo="${d.tipo}" data-idtipo="${d.id_opcion}"  data-name="${d.nombre}" data-comentario="${d.comentario}" data-individual="${d.pago_individual}" data-npagos="${d.num_pagos}" data-monto="${d.monto}" class="btn-data btn-sky edit-prestamo" title="Editar"><i class="fas fa-pen-nib"></i></button>`;
            }
            return '<div class="d-flex justify-center">' + botonesModal + '<div>';
        }}
    ],
    columnDefs: [{
        visible: false,
        searchable: false
    }],
    ajax: {
        url: 'getPrestamos',
        type: "POST",
        cache: false,
        data: function( d ){}
    }}) 

 
    $('#tabla_prestamos tbody').on('click', '.delete-prestamo', function () {
        const idPrestamo = $(this).val();
        const nombreUsuario = $(this).attr("data-name");
        const Modalbody = $('#myModalDelete .modal-body');
        const Modalfooter = $('#myModalDelete .modal-footer');
        Modalbody.html('');
        Modalfooter.html('');

        Modalbody.append(`<input type="hidden" value="${idPrestamo}" name="idPrestamo" id="idPrestamo"> <h4>¿Ésta seguro que desea borrar el préstamo de ${nombreUsuario}?</h4>`);
        Modalfooter.append(`
                <button type="button"  class="btn btn-danger btn-simple " data-dismiss="modal" >Cerrar</button>
				<button  type="submit" name=/"disper_btn"  id="dispersar" class="btn btn-gral-data">Aceptar</button>
			                        `);
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
        console.log('tipoD');
        console.log(id_tipo);
        
        document.getElementById("montoPagos").value = pagoEdit;
        document.getElementById("numeroPagos").value = numeroPagos;
        document.getElementById("pagoEdit").value = montoPagos;
        document.getElementById("informacionText").value = comentario;
        document.getElementById("prestamoId").value = prestamoId;
        
        // console.log('pagoedit');
        // console.log(pagoEdit);
        // console.log('numero pagos');
        // console.log(numeroPagos);
        // console.log('montopagos');
        // console.log(montoPagos);
        // console.log('comentario');
        // console.log(comentario);
        // console.log('prestamo');
        // console.log(prestamoId);

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
                console.log(tipoD)
                console.log(tipoD)
                console.log(tipoD)
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
        $.getJSON(`${general_base_url}Prestamos/getDetallePrestamo/${idPrestamo}`).done(function (data) {
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

                detalleHeaderModal.append(`<div class="text-right"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></div>`);
                detalleHeaderModal.append(`<h4 class="card-title"><b>Detalle del préstamo</b><br><p>${importacion}</p></h4>`);
                detalleBodyModal.append(`
                    <div class="row">
                        <div class="col col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <h6>USUARIO: <b>${general.nombre_completo}</b></h6>
                        </div>
                        <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <h6>PAGO MENSUAL: <b>$${formatMoney(general.pago_individual)}</b></h6>
                        </div>
                        <div class="col col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <h6>PAGOS APLICADOS: <b>${numPagosReal}</b></h6>
                        </div>
                        <div class="col col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <h6>MENSUALIDADES: <b>${general.num_pagos}</b></h6>
                        </div>
                        <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <h6>MONTO PRESTADO: <b>$${formatMoney(general.monto_prestado)}</b></h6>
                        </div>
                        <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <h6>ABONADO: <b style="color:green;">$${formatMoney(general.total_pagado)}</b></h6>
                        </div>
                        <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <h6>PENDIENTE: <b style="color:orange;">$${formatMoney(general.pendiente)}</b></h6>
                        </div>
                    </div>
                `);

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
                    htmlTableBody += `<td><b>$${formatMoney(detalle[i].abono_neodata)}</b></td>`;
                    htmlTableBody += `<td style="width:20% !important;">${detalle[i].estatus}</td>`;
                    htmlTableBody += '</tr>';
                }

                detalleBodyModal.append(`
                    <div style="margin-top: 20px;" class="table-responsive">
                        <table class="table table-striped table-hover" id="table_detalles">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Sede</th>
                                    <th>Tipo</th>
                                    <th>#</th>
                                    <th>Proyecto</th>
                                    <th>Lote</th>
                                    <th >Id pago</th>
                                    <th >Comentario</th>
                                    <th >Fecha</th>
                                    <th >Monto</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${htmlTableBody}
                            </tbody>
                        </table>
                    </div>
                `);

                $("#detalle-prestamo-modal").modal();

                $('#table_detalles thead tr:eq(0) th').each(function (i) {

                    if (i != 12) {
                        var title = $(this).text();
                        titulos.push(title);
                        $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
                        $('input', this).on('keyup change', function () {
                            if (tableDetalles.column(i).search() !== this.value) {
                                tableDetalles.column(i).search(this.value).draw();

                            }
                        });
                    }
                });
                var tableDetalles = $('#table_detalles').DataTable({
                    dom: 'Brt' + "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                    width: 'auto',
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                            className: 'btn buttons-excel',
                            titleAttr: 'Descargar archivo de Excel',
                            title: 'Préstamos, descuentos y penalizaciones',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                                format: {
                                    header:  function (d, columnIdx) {
                                        return ' ' + titulos_intxt[columnIdx] + ' ';
                                        }
                                    }
                            }
                        }
                    ],
                    width: 'auto',
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
                tableDetalles
                    .order([0, 'desc'])
                    .draw();
            }
        });
    });
 
function formatMoney(n) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}


$("#roles").change(function () {
    var parent = $(this).val();
    document.getElementById("users").innerHTML = '';

    $('#users').append(` 
    <label class="label">Usuario</label>   
    <select id="usuarioid" name="usuarioid" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true">
    </select>
    `);
    $.post('getUsuariosRol/' + parent + '/1', function (data) {
        $("#usuarioid").append($('<option disabled selected>').val("").text("SELECCIONA UNA OPCIÓN"))
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


 
    $.post(general_base_url + "/Prestamos/lista_estatus_descuentos", function (data) {
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

        //PRESTAMO
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
    $("#modalPrestamosPenalizaciones").modal('toggle');
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
                $('#modalPrestamosPenalizaciones').modal('hide');
                alerts.showNotification("top", "right", "Préstamo registrado con éxito.", "success");
            } else if (data == 2) {
                $('#tabla_prestamos').DataTable().ajax.reload(null, false);
                closeModalEng();
                $('#modalPrestamosPenalizaciones').modal('hide');
                alerts.showNotification("top", "right", "Pago liquidado.", "warning");
            } else if (data == 3) {
                closeModalEng();
                $('#modalPrestamosPenalizaciones').modal('hide');
                alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un préstamo activo.", "warning");
            }
            else if (data == 4) {
                closeModalEng();
                $('#modalPrestamosPenalizaciones').modal('hide');
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

function monthDiff(dateFrom, dateTo) {
    return dateTo.getMonth() - dateFrom.getMonth() + (12 * (dateTo.getFullYear() - dateFrom.getFullYear()))
}


