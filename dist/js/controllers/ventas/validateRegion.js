$('body').tooltip({
    selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
    trigger: 'hover',
    container: 'body'
}).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
    $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
});

function assignManager(e) {
    if ($('input[name="idT[]"]:checked').length > 0) {
        $('#spiner-loader').removeClass('hide');
        var idcomision = $(tabla_validar_comisiones.$('input[name="idT[]"]:checked')).map(function () {
            return this.value;
        }).get();
        $.get(`${general_base_url}Comisiones/updatePlaza/` + idcomision + "/" + e).done(function (data) {
            $('#spiner-loader').addClass('hide');
            if (data == 1) { // COMISIÓN RECHAZADA
                alerts.showNotification("top", "right", "La comisión ha sido regresada correctamente para su validación.", "success");
            } else if (data == 2) { // COMISIÓN ASIGNADA
                alerts.showNotification("top", "right", "La asignación de plaza se ha llevado a cabo exitosamente.", "success");
            } else if (data) { // COMISIÓN ASIGNADA
                alerts.showNotification("top", "right", "Se ha aplicado cambio exitosamente.", "success");
            } else { // NO ENCONTRÓ DATOS, ERROR GENERAL
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
            $('input[type="checkbox"]').prop('checked', false);
            tabla_validar_comisiones.ajax.reload();
        });
    }
    else{
        alerts.showNotification("top", "right", "Selecciona una comisión.", "warning");
        $('#spiner-loader').addClass('hide');
    }
}

function selectAll(e) {
    const cb = document.getElementById('all');
    if (cb.checked) {
        $('input[type="checkbox"]').prop('checked', true);
    } else {
        $('input[type="checkbox"]').prop('checked', false);
    }
}
$(document).on("click", ".individualCheck", function() {
    tabla_validar_comisiones.$('input[type="checkbox"]').each(function () {
        let totalChecados = tabla_validar_comisiones.$('input[type="checkbox"]:checked') ;
        let totalCheckbox = tabla_validar_comisiones.$('input[type="checkbox"]');
        if(this.checked){
            tr = this.closest('tr');
            row = tabla_validar_comisiones.row(tr).data();
        }
        // Al marcar todos los CheckBox Marca CB total
        if( totalChecados.length == totalCheckbox.length )
        $("#all").prop("checked", true);
        else 
        $("#all").prop("checked", false); // si se desmarca un CB se desmarca CB total
    });
});

$("#tabla_validar_comisiones").ready(function () {
    let titulos = [];
    $('#tabla_validar_comisiones thead tr:eq(0) th').each(function (i) {
        if (i != 0 ) {
            var title = $(this).text();
            titulos.push(title);
            $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
            $('input', this).on('keyup change', function () {
                if (tabla_validar_comisiones.column(i).search() !== this.value) {
                    tabla_validar_comisiones.column(i).search(this.value).draw();
                    var total = 0;
                    var index = tabla_validar_comisiones.rows({
                        selected: true,
                        search: 'applied'
                    }).indexes();
                    var data = tabla_validar_comisiones.rows(index).data();
                    $.each(data, function (i, v) {
                        total += parseFloat(v.pago_cliente);
                    });
                    document.getElementById("myText_nuevas").value = formatMoney(total);
                }
            });
        } else {
            $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
        }
    });

    tabla_validar_comisiones = $("#tabla_validar_comisiones").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title:'Validar región de comisiones',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx-1] + ' ';
                        }
                    }
                }
            },
            {
                text: "Enviar comisiones para pago",
                titleAttr: 'Enviar comisiones para pago',
                className: "btn btn-azure send-commissions-to-pay",
            }
        ],
        columns: [
            {},
            {
                data: function (d) {
                    return '<p class="m-0">' + d.id_pago_i + '</p>';
                }
            },
            {
                data: function (d) {
                    return d.pago_cliente;
                }
            },
            {
                data: function (d) {
                    return d.id_lote;
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + d.proyecto + '</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + d.lote + '</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + d.nombre + ' </p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + d.fechaApartado + '</p>';
                }
            },
            {
                data: function (d) {
                    if (d.ubicacion_dos == null)
                        return '<p class="m-0">SIN LUGAR DE VENTA ASIGNADO</p>';
                    else
                        return '<p class="m-0">' + d.ubicacion_dos + '</p>';
                }
            },
            {
                data: function (d) {
                    var lblStats;
                    if (d.ubicacion_dos == null)
                        lblStats = '<span class="label lbl-pink">PENDIENTE DE ASIGNAR SEDE</span>';
                    else
                        lblStats = '<span class="label lbl-violetBoots">SEDE ASIGNADA</span>';
                    return lblStats;
                }
            }
        ],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox dt-body-center',
            targets: 0,
            'searchable': false,
            'render': function (d, type, full, meta) {
                if (full.ubicacion_dos != null)
                    return '';
                else
                    return '<input type="checkbox" class="input-check individualCheck" name="idT[]" style="width:20px; height:20px;" value="' + full.id_pago_i + '">';
            },
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        ajax: {
            url: `${general_base_url}Comisiones/getCommissionsToValidate/`,
            type: "POST",
            cache: false,
            data: function (d) {
            }
        }
    });

    $(document).on("click", ".send-commissions-to-pay", function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            let id_lote = [];
            tabla_validar_comisiones.rows().data().each(function(value, index) { 
                if(value.ubicacion_dos != null){
                id_lote.push(value.id_lote); 
                }
            });
            if(id_lote.length==0){
                alerts.showNotification("top", "right", "No hay sedes asignadas para comisiones ", "warning");
                return false;
            }
            $.ajax({
                type: 'POST',
                url: 'sendCommissionToPay',
                data: {
                    'id_lote': id_lote
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#spiner-loader').removeClass('hide');
                },
                success: function (data) {
                    if (data == true) {
                        alerts.showNotification("top", "right", "Los registros se han enviado de manera exitosa.", "success");
                        $("#tabla_validar_comisiones").DataTable().ajax.reload();
                        $('#spiner-loader').addClass('hide');
                    } else {
                        $('#spiner-loader').addClass('hide');
                        alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
                    }
                }, error: function () {
                    $('#spiner-loader').addClass('hide');
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
    });

});

