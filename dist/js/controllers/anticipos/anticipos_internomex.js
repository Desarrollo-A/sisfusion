let anticiposReporteInternomex = []

let id_usuario;

$("#tabla_anticipos_internomex").ready(function () {

    $('#tabla_anticipos_internomex thead tr:eq(0) th').each(function (i) {
        
            var title = $(this).text();
            anticiposReporteInternomex.push(title);
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
            { data: 'id_anticipo' },
            { data: 'id_usuario' },
            { data: 'nombreUsuario' },
            { data: 'proceso' },
            { data: 'comentario' },
            { data: 'prioridad_nombre' },
            { data: 'impuesto' },
            { data: 'sede' },
            { data: 'esquema' },
            { data: 'nombre_empresa' },
            {
                data: function( d ){
                    var infoModal = '';
                    var Mensualidades = '';
                    if(d.montoParcial1 != null ){
                        infoModal =  '<p class="m-0">monto parcial: '+d.montoParcial1+'</p>'
                        Mensualidades = '<p class="m-0"> mensualidades: '+d.mensualidades+'</p>' ;

                    }else{
                        Mensualidades = '<p class="m-0">monto actual:  '+d.monto+'</p>' ;
                        // infoModal = d.montoParcial;
                    }

                    return infoModal+  Mensualidades;
                }
            },
            {
                data: function (d) {
                    
                    // console.log(d.monto);
                    // console.log(d.montoParcial);
                    if(d.mensualidadesBoton==0){

                        var botonEstatus = `<center><button class="btn-data btn-blueMaderas anticiposEstatusFinal" data-mensualidades="${d.mensualidades}" data-numero_mensualidades="${d.mensualidadesBoton}" data-montoParcialidad="${d.montoParcial}" data-monto="${d.monto}" data-doc="${d.evidencia}" data-proceso="${d.proceso}" data-anticipo="${d.id_anticipo}" data-usuario="${d.id_usuario}" data-toggle="tooltip" data-placement="left" title="PAGAR"><i class="fas fa-history"></i></button></center>`;
                        
                    }else{

                        var botonEstatus = `<center><button class="btn-data btn-blueMaderas anticiposEstatus" data-mensualidades="${d.mensualidades}" data-numero_mensualidades="${d.mensualidadesBoton}" data-montoParcialidad="${d.montoParcial}" data-monto="${d.monto}" data-doc="${d.evidencia}" data-proceso="${d.proceso}" data-anticipo="${d.id_anticipo}" data-usuario="${d.id_usuario}" data-toggle="tooltip" data-placement="left" title="PAGAR"><i class="fas fa-history"></i></button></center>`;

                    }

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

    $(document).on('click', '.anticiposEstatusFinal', function (e) {

        var id_usuario = $(this).attr("data-usuario");
        $("#id_usuario").val(id_usuario);
    
        var id_anticipo = $(this).attr("data-anticipo");
        $("#id_anticipo").val(id_anticipo);

        var montoP = $(this).attr("data-montoParcialidad");
        $("#montoP").val(montoP);

        var numero_mensualidades = $(this).attr("data-numero_mensualidades");
        $("#numero_mensualidades").val(numero_mensualidades);

        if (numero_mensualidades == null || isNaN(numero_mensualidades)) {
            $("#montoTitulo").text("Monto Restante: " + formatMoney(monto));
        } else {
            $("#montoTitulo").text("Monto Restante: " + formatMoney(montoP * numero_mensualidades));
        }
    
        $("#anticipoModalInternomexFinal").modal();
    });

    $(document).on('click', '.anticiposEstatus', function (e) {

        var id_usuario = $(this).attr("data-usuario");
        $("#id_usuario").val(id_usuario);
    
        var id_anticipo = $(this).attr("data-anticipo");
        $("#id_anticipo").val(id_anticipo);

        var montoP = $(this).attr("data-montoParcialidad");
        $("#montoP").val(montoP);

        var monto = $(this).attr("data-monto");
        $("#monto").val(monto);

        var numero_mensualidades = $(this).attr("data-numero_mensualidades");
        $("#numero_mensualidades").val(numero_mensualidades);

        if (numero_mensualidades == null || isNaN(numero_mensualidades)) {
            $("#montoTitulo").text("Monto Restante: " + formatMoney(monto));
        } else {
            $("#montoTitulo").text("Monto Restante: " + formatMoney(montoP * numero_mensualidades));
        }
    
        $("#anticipoModalInternomex").modal();
    });

    $("#modal_anticipos_internomex_form").on("submit", function(e) {
        e.preventDefault();
    
        var id_usuario = $("#id_usuario").val();
        var procesoAntInternomex = $("#procesoAntInternomex").val();
        var id_anticipo = $("#id_anticipo").val();
        var montoParcial = $("#montoP").val();
        var numero_mensualidades = $("#numero_mensualidades").val();
    
        console.log(montoParcial);
        console.log(numero_mensualidades);
    
        var anticipoData = new FormData();
        anticipoData.append("id_usuario", id_usuario);
        anticipoData.append("id_anticipo", id_anticipo);
        anticipoData.append("procesoAntInternomex", procesoAntInternomex);
        anticipoData.append("montoParcial", montoParcial);
        anticipoData.append("numero_mensualidades", numero_mensualidades);
    
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
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", status, error);
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });

    $("#modal_anticipos_internomex_form_final").on("submit", function(e) {
        e.preventDefault();
    
        var id_usuario = $("#id_usuario").val();
        var procesoAntInternomexFinal = $("#procesoAntInternomexFinal").val();
        var id_anticipo = $("#id_anticipo").val();
        var montoParcial = $("#montoP").val();
        var numero_mensualidades = $("#numero_mensualidades").val();
    
        console.log(montoParcial);
        console.log(numero_mensualidades);
    
        var anticipoData = new FormData();
        anticipoData.append("id_usuario", id_usuario);
        anticipoData.append("id_anticipo", id_anticipo);
        anticipoData.append("procesoAntInternomexFinal", procesoAntInternomexFinal);
        anticipoData.append("montoParcial", montoParcial);
        anticipoData.append("numero_mensualidades", numero_mensualidades);
    
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
                    $('#anticipoModalInternomexFinal').modal("hide");
                    alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                    $('#tabla_anticipos_internomex').DataTable().ajax.reload();
                    document.getElementById("form_aceptar").reset();
                } else {
                    alerts.showNotification("top", "right", "Oops, algo salió mal. Error al intentar actualizar.", "warning");
                }
                
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", status, error);
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });
    

    
    
});
