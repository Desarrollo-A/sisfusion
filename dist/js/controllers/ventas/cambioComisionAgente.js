$("#tabla_ingresar_9").ready(function () {
    let titulos = [];
    $('#tabla_ingresar_9 thead tr:eq(0) th').each(function (i) {
        if (i != 0 ) {
            var title = $(this).text();
            titulos.push(title);
            $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" placeholder="' + title + '" title="'+title+'"/>');
            $('input', this).on('keyup change', function () {
                if (tabla_1.column(i).search() !== this.value) {
                    tabla_1.column(i).search(this.value).draw();
                }
            });
        }
    });

    tabla_1 = $("#tabla_ingresar_9").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        bAutoWidth:true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'AGREGAR O REMOVER MKTD',
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx-1] + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            className: "details-control",
            orderable: false,
            data: null,
            defaultContent: '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
        },
        {
            data: function (d) {
                var lblStats;
                lblStats = '<p class="m-0"><b>' + d.idLote + '</b></p>';
                return lblStats;
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.nombreResidencial + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + (d.nombreCondominio).toUpperCase() +'</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.nombreLote + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0"><b>' + d.nombre_cliente + '</b></p>';
            }
        },
        {
            data: function (d) {
                var lblType;
                
                if (d.tipo_venta == 1) {
                    lblType = '<span class="label lbl-warning">VENTA PARTICULAR</span>';
                } else if (d.tipo_venta == 2) {
                    lblType = '<span class="label lbl-green">VENTA NORMAL</span>';
                }
                return lblType;
            }
        },
        {
            data: function (d) {
                var lblStats;

                if (d.compartida == null) {
                    lblStats = '<span class="label lbl-yellow">INDIVIDUAL</span>';
                } else {
                    lblStats = '<span class="label lbl-orange">COMPARTIDA</span>';
                }
                return lblStats;
            }
        },
        {
            data: function (d) {
                var lblStats;

                if (d.idStatusContratacion == 15) {
                    lblStats = '<span class="label lbl-violetDeep">CONTRATADO</span>';
                } else {
                    lblStats = '<p><b>' + d.idStatusContratacion + '</b></p>';
                }
                return lblStats;
            }
        },
        {
            data: function (d) {
                var lblStats;
                console.log(d.totalNeto2);
                if (d.totalNeto2 == null) {
                    lblStats = '<span class="label lbl-warning">SIN PRECIO LOTE</span>';
                } 
                else {
                    switch (d.lugar_prospeccion) {
                        case '6':
                            lblStats = '<span class="label lbl-orangeYellow">MARKETING DIGITAL</span>';
                            break;
                        case '12':
                            lblStats = '<span class="label lbl-sky">CLUB MADERAS</span>';
                            break;
                        case '25':
                            lblStats = '<span class="label lbl-blueMaderas">IGNACIO GREENHAM</span>';
                            break;
                        default:
                            lblStats = '';
                            break;
                    }
                }
                return lblStats;
            }
        },
        {
            orderable: false,
            data: function (data) {
                var BtnStats;

                if (data.lugar_prospeccion == 6) {
                    BtnStats = '<button class="btn-data btn-warning open-mktd-modal" data-type="2" data-toggle="tooltip" data-placement="top" title="Remover MKTD" data-type="2" data-lote="' + data.nombreLote + '" value="' + data.idLote + '"><i class="fas fa-trash"></i></button>';
                } else { 
                    BtnStats = '<button class="btn-data btn-green open-mktd-modal" data-type="1" data-toggle="tooltip" data-placement="top" title="Agregar MKTD" data-type="1" data-lote="' + data.nombreLote + '" value="' + data.idLote + '" color:#fff;"><i class="fas fa-user-plus"></i></button>';
                }
                return '<div class="d-flex justify-center">'+BtnStats+'</div>';
            }
        }],
        columnDefs: [{
            searchable: false,
            orderable: false,
            targets: 0
        }],
        ajax: {
            url: general_base_url + '/Comisiones/getMktdCommissionsList',
            dataSrc: "",
            type: "POST",
            cache: false,
            data: function (d) {
            }
        },
    });

    $('#tabla_ingresar_9 tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tabla_1.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        } 
        else {
            var informacion_adicional = '<div class="container subBoxDetail"><div class="row"><div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>Información colaboradores</b></label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Subdirector: </b>'+ row.data().subdirector +'</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Gerente: </b>' + row.data().gerente + '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Coordinador: </b>' + row.data().coordinador + '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Asesor: </b>' + row.data().asesor + '</label></div></div></div>';
            row.child(informacion_adicional).show();
            tr.addClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
        }
    });
});

$(document).on('click', '#add-remove-mktd', function (e) { 
    document.getElementById("add-remove-mktd").disabled = true;
    e.preventDefault();
    e.stopImmediatePropagation();
    comments = $("#comments").val();
    type_transaction = $("#type_transaction").val();
    if (comments != '') { 
        $.ajax({
            type: 'POST',
            url: general_base_url + 'Comisiones/addRemoveMktd',
            data: {
                'id_lote': $("#id_lote").val(),
                'comments': comments,
                'type_transaction': type_transaction,
            },
            dataType: 'json',
            success: function (data) {
                if (data == 1) {
                    document.getElementById("add-remove-mktd").disabled = false;
                    alerts.showNotification("top", "right", type_transaction == 1 ? "Marketing digital se ha agregado con éxito." : "Marketing digital se ha removido con éxito.", "success");
                    tabla_1.ajax.reload();
                } else {
                    document.getElementById("add-remove-mktd").disabled = false;
                    alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                }
                $("#comments").val('');
                $("#id_lote").val('');
                $("#modal_agregar_mktd").modal("hide");
            }, error: function () {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    } else {
        document.getElementById("add-remove-mktd").disabled = false;
        alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
    }
});

$(document).on('click', '.open-mktd-modal', function (e) {
    $("#comments").val('');
    e.preventDefault();
    e.stopImmediatePropagation();
    lote_name = $(this).attr("data-lote");
    $("#id_lote").val($(this).val());
    $("#type_transaction").val($(this).attr("data-type"));
    type = $(this).attr("data-type");
    document.getElementById("modal-mktd-title").innerHTML = type == 1 ? "Agregar MKTD en <b>" + lote_name + "</b>" : "Remover MKTD en <b>" + lote_name + "</b>";
    $("#modal_agregar_mktd").modal();
});

$('body').tooltip({ selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', trigger: 'hover', container: 'body' }).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
    $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
});