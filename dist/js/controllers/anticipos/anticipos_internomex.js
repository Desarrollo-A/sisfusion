let anticiposReporteInternomex = []

let id_usuario;

$("#tabla_anticipos_internomex").ready(function () {

    $('#tabla_anticipos_internomex thead tr:eq(0) th').each(function (i) {
        
            var title = $(this).text();
            anticiposReporteInternomex.push(title);
            console.log(title);
            $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
            $('input', this).on('keyup change', function () {
                if (tabla_anticipos_internomex.column(i).search() !== this.value)
                    tabla_anticipos_internomex.column(i).search(this.value).draw();
            });
        
    });

    tabla_anticipos_internomex = $("#tabla_anticipos_internomex").DataTable({
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
                            return ' ' + anticiposReporteInternomex[columnIdx] + ' ';
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
            { data: 'impuesto' },
            { data: 'sede' },
            { data: 'esquema' },
            { data: 'monto' },
            {
                data: function (d) {
                    
                    
                    var botonEstatus = `<center><button class="btn-data btn-blueMaderas anticiposEstatus" data-monto="${d.monto}" data-doc="${d.evidencia}" data-proceso="${d.proceso}" data-anticipo="${d.id_anticipo}" data-usuario="${d.id_usuario}" data-toggle="tooltip" data-placement="left" title="REPORTE"><i class="fas fa-history"></i></button></center>`;
                    
                    

                    
                    return '<div class="d-flex justify-center">'  + botonEstatus  + '</div>';
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

    $('#tabla_anticipos_internomex').on('draw.dt', function () {
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
    
    
        $("#anticipoModalInternomex").modal();
    });

    $("#modal_anticipos_internomex_form").on("submit", function(e) {
        e.preventDefault();
    
        var id_usuario = $("#id_usuario").val();
        var procesoAntInternomex = $("#procesoAntInternomex").val();
        var id_anticipo = $("#id_anticipo").val();
        
    
        var anticipoData = new FormData();
        anticipoData.append("id_usuario", id_usuario);
        anticipoData.append("id_anticipo", id_anticipo);
        anticipoData.append("procesoAntInternomex", procesoAntInternomex);
        
    
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
                    $('#anticipoModalInternomex').modal("hide");
                    alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                    $('#tabla_anticipos_internomex').DataTable().ajax.reload();
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

    
    
});
