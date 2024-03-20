
$(document).on('click', '#save', function (e) {
    e.preventDefault();
    var idLote = $('#idLote').val();
    var comentario = $('#comentario').val();
    var idCondominio = $('#idCondominio').val();
    var nombreLote = $('#nombreLote').val();
    var idCliente = $('#idCliente').val();
    if (comentario == '')
    {
        alerts.showNotification("top", "right", "Asegúrate de haber ingresado un comentario.", "warning");
    }
    else {
        $.post('updateReturnStatus15', {
            idLote: idLote, comentario: comentario, idCondominio: idCondominio, nombreLote: nombreLote,
            idCliente: idCliente
        }, function (data) {
            if (data == 1) {
                $('#returnStatus15').modal("hide");
                $('#tableStatus15Clients').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "El cambio de estatus se ha llevado a cabo correctamente.", "success");
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        });
    }
});

$(document).on('click', '.addComent', function (e) {
    e.preventDefault();
    var $itself = $(this);
    $.post('getInfoReturnStatus15', {idLote: $itself.attr('data-idLote')}, function (data) {
        var $form = $('#returnEditaStatus15');
        $form.find('#idLote').val(data.idLote);
        $form.find('#idCondominio').val(data.idCondominio);
        $form.find('#nombreLote').val(data.nombreLote);
        $form.find('#idCliente').val(data.idCliente);
        $('#returnStatus15').modal('show');
    }, 'json');
});

$('#tableStatus15Clients thead tr:eq(0) th').each(function (i) {
    if(i!=3){
        var title = $(this).text();
        $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($('#tableStatus15Clients').DataTable().column(i).search() !== this.value) {
                $('#tableStatus15Clients').DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    }

});

$(document).ready(function () {
    $.post(general_base_url + "Contratacion/lista_proyecto", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#filtro3").append($('<option>').val(id).text(name.toUpperCase()));
        }

        $("#filtro3").selectpicker('refresh');
    }, 'json');


    $('#filtro3').change(function () {
        var valorSeleccionado = $(this).val();
        $("#filtro4").empty().selectpicker('refresh');
        $.ajax({
            url: general_base_url + 'registroCliente/getCondominios/' + valorSeleccionado,
            type: 'post',
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    var id = response[i]['idCondominio'];
                    var name = response[i]['nombre'];
                    $("#filtro4").append($('<option>').val(id).text(name));
                }
                $("#filtro4").selectpicker('refresh');

            }
        });
    });

    $('#filtro4').change(function () {
        var valorSeleccionado = $(this).val();
        $('#tableStatus15Clients').DataTable({
            width: '100%',
            scrollX: true,
            bAutoWidth: true,
            destroy: true,
            lengthMenu: [[15, 25, 50, -1], [10, 25, 50, "All"]],
            ajax:
                {
                    "url": general_base_url + '/Contraloria/getClientsInStatusFifteen/' + valorSeleccionado,
                    "data": function (d) {
                    }
                },
            dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            pagingType: "full_numbers",
            language: {
                url: general_base_url + "/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            ordering: false,
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Registro estatus 14',
                    title:'Registro estatus 14',
                    exportOptions: {
                        columns: [0, 1, 2],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'PROYECTO';
                                        break;
                                    case 1:
                                        return 'CONDOMINIO';
                                        break;
                                    case 2:
                                        return 'LOTE';
                                        break;
                                }
                            }
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                    className: 'btn buttons-pdf',
                    titleAttr: 'Registro estatus 14',
                    title:'Registro estatus 14',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: [0, 1, 2],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'PROYECTO';
                                        break;
                                    case 1:
                                        return 'CONDOMINIO';
                                        break;
                                    case 2:
                                        return 'LOTE';
                                        break;
                                }
                            }
                        }
                    }
                }
            ],
            columns:
                [
                    {
                        "data": function (d) {
                            return '<p style="font-size: .8em">' + d.nombreResidencial + '</p>';
                        }
                    },
                    {
                        "data": function (d) {
                            return '<p style="font-size: .8em">' + d.nombreCondominio + '</p>';
                        }
                    },
                    {
                        "data": function (d) {
                            return '<p style="font-size: .8em">' + d.nombreLote + '</p>';
                        }
                    },
                    {
                        "data": function (d) {
                            return '<button class="btn btn btn-round btn-fab btn-fab-mini addComent" data-idlote="' + d.idLote + '" style="background-color:#28B463;border-color:#28B463" rel="tooltip" data-placement="left" title="Regresar estatatus ' + d.nombreLote + '"><i class="material-icons">update</i></button>';
                        }
                    }
                ]
        });
    });
});/*document Ready*/
