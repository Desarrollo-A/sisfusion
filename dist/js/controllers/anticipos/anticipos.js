let anticiposReporte = []
let id_usuario;

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
            console.log(title);
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
            { data: 'prioridad' },
            { data: 'impuesto' },
            { data: 'sede' },
            { data: 'esquema' },
            { data: 'monto' },
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
                    
                    botonesModal += `<center><button class="btn-data btn-blueMaderas anticiposEstatus" data-monto="${d.monto}" data-doc="${d.evidencia}" data-proceso="${d.proceso}" data-anticipo="${d.id_anticipo}" data-usuario="${d.id_usuario}" data-toggle="tooltip" data-placement="left" title="REPORTE"><i class="fas fa-history"></i></button></center>`;
                    
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
    
    $("#modal_anticipos_form").on("submit", function(e) {
        e.preventDefault();
        
        var procesoTipo = $("#procesoTipo").val();

        var comentario = $("#comentario").val().trim();
    
        if (comentario === "") {
            alerts.showNotification("top", "right", "Por favor, ingresa un comentario.", "warning");
            return;
        }

        var procesoTipo = $("#procesoTipo").val();
        if (!procesoTipo) { 
            alerts.showNotification("top", "right", "Por favor, selecciona un tipo.", "warning");
            return;
        }

        var numeroPagos = $("#numeroPagos").val();
        if (!numeroPagos) { 
            alerts.showNotification("top", "right", "Por favor, selecciona un Número de pagos.", "warning");
            return;
        }
    
        var nombreSwitchChecked = $("#nombreSwitch").is(":checked");
    
        var id_usuario = $("#id_usuario").val();
        var procesoAnt = $("#procesoAnt").val();
        var id_anticipo = $("#id_anticipo").val();
        var monto = $("#montoPrestado").val();
        var numeroPagos = $("#numeroPagos").val();
        var pago = $("#pago").val();
    
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
    
        if (!nombreSwitchChecked) {
            var tipoPagoAnticipo = $("#tipo_pago_anticipo").val();
            var numeroPagosParcialidad = $("#numeroPagosParcialidad").val();
        
            if (!tipoPagoAnticipo || !numeroPagosParcialidad) {
                var mensaje = !tipoPagoAnticipo ? "Monto de Pago" : "número de pagos por parcialidad";
                alerts.showNotification("top", "right", "Por favor, selecciona " + mensaje + ".", "warning");
                return;
            }
        
            anticipoData.append("tipo_pago_anticipo", tipoPagoAnticipo);
            anticipoData.append("numeroPagosParcialidad", numeroPagosParcialidad);
        }
    
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
            if (tipo === "0") {
                $("#montoPrestado, #numeroPagos, #pago, #comentario").closest('.row').hide();
            } else {
                $("#montoPrestado, #numeroPagos, #pago, #comentario").closest('.row').show();
                $("#tipo_pago_anticipo, #montoPrestadoParcialidad, #numeroPagosParcialidad, #nombreSwitch").closest('.row').show();

            }
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
    
  });
});
