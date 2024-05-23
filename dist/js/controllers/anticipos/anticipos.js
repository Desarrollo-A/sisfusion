let anticiposReporte = []
let id_usuario;
let tipoID;

$(document).ready(function() {

    $('#anticipoModal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $('#procesoAnt').selectpicker('refresh');
        $('#procesoTipo').selectpicker('refresh');
        $('#numeroPagos').selectpicker('refresh');
        $('#numeroPagosParcialidad').selectpicker('refresh');
    });

$("#tabla_anticipos").ready(function () {

    function updateVisibility() {
        var isChecked = $('#nombreSwitch').is(':checked');
    
        $('#noTexto').toggle(!isChecked);
        $('#siTexto').toggle(isChecked);
        $('#evidenciaSwitchDIV').toggle(isChecked);
    
        if (isChecked) {
            $('#noTextoDescripcion').addClass('hide');
            $('#siTextoDescripcion').removeClass('hide');
            $('#tipo_pago_anticipo').closest('.form-group').hide();
            $('#montoPrestadoParcialidad').closest('.form-group').hide();
            $('#numeroPagosParcialidad').closest('.form-group').hide();
            $('#tituloParcialidades').hide();
        } else {
            $('#noTextoDescripcion').removeClass('hide');
            $('#siTextoDescripcion').addClass('hide');
            $('#tipo_pago_anticipo').closest('.form-group').show();
            $('#montoPrestadoParcialidad').closest('.form-group').show();
            $('#numeroPagosParcialidad').closest('.form-group').show();
            $('#tituloParcialidades').show();
        }
    }
    
    $('#nombreSwitch').change(updateVisibility);
    
    updateVisibility();
    
    $('#nombreSwitchGeneral').change(function() {
        var isChecked = $(this).is(':checked');
        $('#noTextoGeneral').toggle(isChecked);
        $('#siTextoGeneral').toggle(!isChecked);
    });

    $('#tabla_anticipos thead tr:eq(0) th').each(function (i) {
        
            var title = $(this).text();
            anticiposReporte.push(title);
            $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
            $('input', this).on('keyup change', function () {
                if (tabla_anticipos.column(i).search() !== this.value)
                    tabla_anticipos.column(i).search(this.value).draw();
            });
        
    });

    tabla_anticipos = $("#tabla_anticipos").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Reporte Anticipo',
                title: "Reporte Anticipo",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + anticiposReporte[columnIdx] + ' ';
                        }
                    }
                }
            },{
                text: 'XMLS',
                action: function(){
                        window.location = general_base_url+'Descuentos/descargar_XML';
                },
                attr: {
                    class: 'btn btn-azure ml-1',
                    style: 'position: relative;',
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
        columns: [
            { data: 'id_anticipo' },
            { data: 'id_usuario' },
            { data: 'nombreUsuario' },
            { data: 'proceso' },
            { data: 'comentario' },
            { data: 'prioridad_nombre' },
            { data: 'impuesto' },
            { data: 'sede' },
            { data: 'esquema' },
            {
                data: function( d ){
                    return '<p class="m-0">'+formatMoney(d.montoParcial)+'</p>';
                }
            },
            {
                data: function (d) {
                    var botonesModal = '';
            
                    if (d.evidencia != null) {
                        botonesModal += `
                            <button href="#" id="preview" name="preview" data-doc="${d.evidencia}"  
                            data-ruta="static/documentos/solicitudes_anticipo"
                            class="btn-data btn-violetDeep" title="Ver Evidencia">
                                <i class="fas fa-folder-open"></i>
                            </button>`;
                    }

                    var botonParcialidad= d.mensualidadesBoton;
                    console.log(botonParcialidad);

                    if (botonParcialidad === null) {
                        botonesModal += `
                            <center>
                                <button class="btn-data btn-blueMaderas anticiposEstatus" data-monto="${d.monto}" data-doc="${d.evidencia}" data-proceso="${d.proceso}" data-anticipo="${d.id_anticipo}" data-usuario="${d.id_usuario}" data-toggle="tooltip" data-placement="left" title="REPORTE">
                                    <i class="fas fa-history"></i>
                                </button>
                            </center>`;
                    } else {
                        botonesModal += `
                            <center>
                                <button class="btn-data btn-blueMaderas continuarParcialidad" data-monto="${d.monto}" data-doc="${d.evidencia}" data-proceso="${d.proceso}" data-anticipo="${d.id_anticipo}" data-usuario="${d.id_usuario}" data-toggle="tooltip" data-placement="left" title="CONTINUAR PARCIALIDAD">
                                <i class="fas fa-address-card"></i>
                                </button>
                            </center>`;
                        // alert("nuevo boton");
                    }
            
                    botonesModal += `
                        <button href="#" value="${d.id_anticipo}" data-name="${d.nombreUsuario}" data-id_usuario="${d.id_usuario}" class="btn-data btn-blueMaderas consultar_logs" title="Historial">
                            <i class="fas fa-info"></i>
                        </button>`;
            
                    return '<div class="d-flex justify-center">' + botonesModal + '</div>';
                }
            }
        ],
        ajax: {
            url: `${general_base_url}Anticipos/getAnticipos`,
            dataSrc: "",
            type: "POST",
            cache: false,
        },
        order: [[1, 'asc']]
    });

    $('#tabla_anticipos').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $(document).on('click', '.anticiposEstatus', function (e) {

        var id_usuario = $(this).attr("data-usuario");
        $("#id_usuario").val(id_usuario);
    
        var id_anticipo = $(this).attr("data-anticipo");
        $("#id_anticipo").val(id_anticipo);
    
        var monto = $(this).attr("data-monto");
        $("#montoPrestado").val(monto);
    
        var proceso = $(this).attr("data-proceso");
    
        mostrarOcultarCampos(proceso);

        calcularPago();
        calcularPagoParcialidades();

        $("#anticipoModal").modal();

        fillPagoAnticipos();

        
    });

    $(document).on('click', '.continuarParcialidad', function (e) {

        var id_usuario = $(this).attr("data-usuario");
        $("#id_usuario").val(id_usuario);
    
        var id_anticipo = $(this).attr("data-anticipo");
        $("#id_anticipo").val(id_anticipo);
    
        var monto = $(this).attr("data-monto");
        $("#montoPrestado").val(monto);
    
        var proceso = $(this).attr("data-proceso");
    
        mostrarOcultarCampos(proceso);

        $("#parcialidadModal").modal();
        
    });

    function calcularPago() {
        var montoPrestado = parseFloat($("#montoPrestado").val());
        var numeroPagos = parseInt($("#numeroPagos").val());
        var pago = montoPrestado / numeroPagos;
        $("#pago").val(isNaN(pago) ? '' : pago.toFixed(2));
    }

    $('#montoPrestado, #numeroPagos').on('input change', calcularPago);

    function calcularPagoParcialidades() {
        var montoPrestado = parseFloat($("#montoPrestado").val());
        var numeroPagos = parseInt($("#numeroPagosParcialidad").val());
        var pago = montoPrestado / numeroPagos;
        $("#montoPrestadoParcialidad").val(isNaN(pago) ? '' : pago.toFixed(2));
    }

    $('#montoPrestado, #numeroPagosParcialidad').on('input change', calcularPagoParcialidades);

    $(document).on("click", "#preview", function () {
        var itself = $(this);
        Shadowbox.open({
            content: `<div>
                        <iframe style="overflow:hidden;width: 100%;height: 100%; 
                                        position:absolute;z-index:999999!important;" 
                                        src="${general_base_url}${itself.attr('data-ruta')}/${itself.attr('data-doc')}">
                        </iframe>
                    </div>`,
            player: "html",
            title: `Visualizando archivo: evidencia `,
            width: 985,
            height: 660
        });
    });

    $("#modal_parcialidad_form").on("submit", function(e) {
        e.preventDefault();
        var id_usuario = $("#id_usuario").val();
        var id_anticipo = $("#id_anticipo").val();
        var procesoParcialidad = $("#procesoParcialidad").val();

        var anticipoPData = new FormData();
        anticipoPData.append("id_usuario", id_usuario);
        anticipoPData.append("id_anticipo", id_anticipo);
        anticipoPData.append("procesoParcialidad", procesoParcialidad);

        $.ajax({
            url: general_base_url + 'Anticipos/regresoInternomex',
            data: anticipoPData,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                var jsonResponse = JSON.parse(response);

                if (jsonResponse.result == 1) {
                    $('#parcialidadModal').modal("hide");
                    alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                    $('#tabla_anticipos').DataTable().ajax.reload();
                } else {
                    alerts.showNotification("top", "right", "Oops, algo salió mal. Error al intentar actualizar.", "warning");
                }
            },
            error: function() {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });


    });


    
    $("#modal_anticipos_form").on("submit", function(e) {
        e.preventDefault();
        
        var procesoTipo = $("#procesoTipo").val();
        var nombreSwitchChecked = $("#nombreSwitch").is(":checked");
        var comentario = $("#comentario").val().trim();
        var numeroPagos = $("#numeroPagos").val();
        var id_usuario = $("#id_usuario").val();
        var procesoAnt = $("#procesoAnt").val();
        var id_anticipo = $("#id_anticipo").val();
        var monto = $("#montoPrestado").val();
        var numeroPagos = $("#numeroPagos").val();
        var pago = $("#pago").val();
        var montoParcialidad = $("#montoPrestadoParcialidad").val();
        
        if (!nombreSwitchChecked) {
            var tipoPagoAnticipo = $("#tipo_pago_anticipo").val();
            var numeroPagosParcialidad = $("#numeroPagosParcialidad").val();

            if (!tipoPagoAnticipo || !numeroPagosParcialidad) {
                var mensaje = !tipoPagoAnticipo ? "Monto de Pago" : "número de pagos por parcialidad";
                alerts.showNotification("top", "right", "Por favor, selecciona " + mensaje + ".", "warning");
                return;
            }
        }

        if (comentario === "") {
            alerts.showNotification("top", "right", "Por favor, ingresa un comentario.", "warning");
            return;
        }

        if(procesoTipo==1){
            if (!procesoTipo) { 
                alerts.showNotification("top", "right", "Por favor, selecciona un tipo.", "warning");
                return;
            }

            if (!numeroPagos) { 
                alerts.showNotification("top", "right", "Por favor, selecciona un Número de pagos.", "warning");
                return;
            }   
        }
    
        var anticipoData = new FormData();
        anticipoData.append("comentario", comentario);
        anticipoData.append("id_usuario", id_usuario);
        anticipoData.append("id_anticipo", id_anticipo);
        anticipoData.append("procesoAnt", procesoAnt);
        anticipoData.append("monto", monto);
        anticipoData.append("numeroPagos", numeroPagos);
        anticipoData.append("procesoTipo", procesoTipo);
        anticipoData.append("pago", pago);
        anticipoData.append("nombreSwitch", nombreSwitchChecked ? "true" : "false");
        anticipoData.append("tipo_pago_anticipo", tipoPagoAnticipo);
        anticipoData.append("numeroPagosParcialidad", numeroPagosParcialidad);
        anticipoData.append("montoPrestadoParcialidad", montoParcialidad);
    
        $.ajax({
            url: general_base_url + 'Anticipos/actualizarEstatus',
            data: anticipoData,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.success) {
                    $('#anticipoModal').modal("hide");
                    alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                    $('#tabla_anticipos').DataTable().ajax.reload();
                } else {
                    alerts.showNotification("top", "right", "Oops, algo salió mal. Error al intentar actualizar.", "warning");
                }
            },
            error: function() {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });

    $("#procesoAnt, #procesoTipo").on("change", function() {
        var proceso = $("#procesoAnt").val();
        var tipo = $("#procesoTipo").val();
        
        mostrarOcultarCampos(proceso, tipo);
    });
    
    function mostrarOcultarCampos(proceso, tipo) {
        if (proceso === "6") {
            $("#procesoTipo").parent().parent().hide();
            $("#montoPrestado, #numeroPagos, #pago, #comentario").closest('.row').hide();
            $("#tipo_pago_anticipo, #montoPrestadoParcialidad, #numeroPagosParcialidad, #nombreSwitch").closest('.row').hide();
        } else if (proceso === "0") {
            $("#procesoTipo").parent().parent().hide();
            $("#montoPrestado, #numeroPagos, #pago").closest('.row').hide();
            $("#tipo_pago_anticipo, #montoPrestadoParcialidad, #numeroPagosParcialidad, #nombreSwitch").closest('.row').hide();
        } else {
            $("#procesoTipo").parent().parent().show();
            if (tipo === "1") { 
                $("#montoPrestado, #numeroPagos, #pago, #comentario").closest('.row').show();
            } else { 
                $("#montoPrestado, #numeroPagos, #pago, #comentario").closest('.row').hide();
            }
            $("#tipo_pago_anticipo, #montoPrestadoParcialidad, #numeroPagosParcialidad, #nombreSwitch").closest('.row').show();
        }
    }
    
    function fillPagoAnticipos() {
        $("#tipo_pago_anticipo").empty();

        $.getJSON("fillAnticipos").done(function (data) {
            for (let i = 0; i < data.length; i++) {
                $("#tipo_pago_anticipo").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
            }
            $('#tipo_pago_anticipo').selectpicker('refresh');
        });
    }

    $("#tabla_anticipos tbody").on("click", ".consultar_logs", function(e) {
        $('#spiner-loader').removeClass('hide');
        const idAnticipo = $(this).val();
        const nombreUsuario = $(this).attr("data-name");
        e.preventDefault();
        e.stopImmediatePropagation();

        $('#modal-dialog').removeClass('modal-sm modal-lg modal-xl').addClass('modal-md');

        $('#exampleModal .modal-content').html(`
            <div class="modal-body">
                <div role="tabpanel">
                    <ul>
                        <div id="nombreLote"></div>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="changelogTab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-plain">
                                        <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                            <ul class="timeline-3" id="comentariosAsimilados"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"><b>Cerrar</b></button>
            </div>`);

        // Muestra el modal
        $('#exampleModal').modal('show');

        $("#nombreLote").append('<p><h5>HISTORIAL DEL ANTICIPO DE: <b>' + nombreUsuario + '</b></h5></p>');

        $.getJSON(general_base_url + "Descuentos/getComments/" + idAnticipo).done(function(data) {
            console.log(data);
            $.each(data, function(i, v) {
                console.log(i);
                console.log(v.comentario);
                $("#comentariosAsimilados").append('<li>\n' +
                '  <div class="container-fluid">\n' +
                '    <div class="row">\n' +
                '      <div class="col-md-6">\n' +
                '        <a> Proceso : <b> ' + v.nombre + '</b></a><br>\n' +
                '      </div>\n' +
                '      <div class="float-end text-right">\n' +
                '        <a> Comentario : ' + v.comentario_general + '</a>\n' +
                '      </div>\n' +
                '    <h6>\n' +
                '    </h6>\n' +
                '    </div>\n' +
                '  </div>\n' +
                '</li>');
            });
            $('#spiner-loader').addClass('hide');
        });
    });
  });
});
