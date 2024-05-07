let anticiposReporte = []

let id_usuario;

$("#tabla_anticipos").ready(function () {

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
                    columns: [0, 1, 2, 3],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + anticiposReporte[columnIdx] + ' ';
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
        columns: [
            
            { data: 'id_usuario' },
            { data: 'nombreUsuario' },
            { data: 'proceso' },
            { data: 'comentario' },
            { data: 'prioridad' },
            {
                data: function (d) {
                    var botonesModal = '';
                    if (d.evidencia != null) {
                        botonesModal += `
                        <button href="#" id="preview" data-doc="${d.evidencia}"  
                        data-ruta="static/documentos/solicitudes_anticipo"
                        class="btn-data btn-violetDeep" title="Ver Evidencia">
                            <i class="fas fa-folder-open"></i>
                        </button>`;
                    }
                    
                    var botonEstatus = `<center><button class="btn-data btn-blueMaderas anticiposEstatus" data-monto="${d.monto}" data-doc="${d.evidencia}" data-proceso="${d.proceso}" data-anticipo="${d.id_anticipo}" data-usuario="${d.id_usuario}" data-toggle="tooltip" data-placement="left" title="VER ESTATUS DE USUARIOS"><i class="fas fa-history"></i></button></center>`;
                    
                    return '<div class="d-flex justify-center">' + botonesModal + botonEstatus + '</div>';
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
    
        $("#anticipoModal").modal();
    });

    function calcularPago() {
        var montoPrestado = parseFloat($("#montoPrestado").val());
        var numeroPagos = parseInt($("#numeroPagos").val());
        var pago = montoPrestado / numeroPagos;
        $("#pago").val(isNaN(pago) ? '' : pago.toFixed(2));
    }

    $('#montoPrestado, #numeroPagos').on('input change', calcularPago);

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
    
        var comentario = $("#comentario").val().trim(); 
        
        if (comentario === "") {
            alerts.showNotification("top", "right", "Por favor, ingresa un comentario.", "warning");
            return; 
        }
    
        var id_usuario = $("#id_usuario").val();
        var procesoAnt = $("#procesoAnt").val();
        var id_anticipo = $("#id_anticipo").val();
        var monto = $("#montoPrestado").val();
        var numeroPagos = $("#numeroPagos").val();
    
        var anticipoData = new FormData();
        anticipoData.append("comentario", comentario);
        anticipoData.append("id_usuario", id_usuario);
        anticipoData.append("id_anticipo", id_anticipo);
        anticipoData.append("procesoAnt", procesoAnt);
        anticipoData.append("monto", monto);
        anticipoData.append("numeroPagos", numeroPagos);
    
        $.ajax({
            url: general_base_url + 'Anticipos/actualizarEstatus',
            data: anticipoData,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    $('#anticipoModal').modal("hide");
                    alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                    $('#tabla_anticipos').DataTable().ajax.reload();
                    document.getElementById("form_aceptar").reset();
                } else {
                    alerts.showNotification("top", "right", "Oops, algo salió mal. Error al intentar actualizar.", "warning");
                }
            },
            error: function() {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });
    

    $("#procesoAnt").on("change", function() {
        var proceso = $(this).val();
        mostrarOcultarCampos(proceso);
    });
    
    function mostrarOcultarCampos(proceso) {
        if (proceso === "6") {
            $("#montoPrestado, #numeroPagos, #pago, #comentario").closest('.row').hide();
        } else {
            $("#montoPrestado, #numeroPagos, #pago, #comentario").closest('.row').show();
        }
    }
    
});
