$("#tabla_envio_RL").ready(function () {
    $('#tabla_envio_RL thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if (tabla_corrida.column(i).search() !== this.value) {
                tabla_corrida.column(i).search(this.value).draw();
            }
        });
    });

    tabla_corrida = $("#tabla_envio_RL").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: 'auto',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Envío contrato a RL',
                title: "Envío contrato a RL",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                    format: {
                        header: function (d, columnIdx) {
                            switch (columnIdx) {
                                case 0:
                                    return 'TIPO VENTA';
                                    break;
                                case 1:
                                    return 'PROYECTO'
                                case 2:
                                    return 'CONDOMINIO';
                                    break;
                                case 3:
                                    return 'LOTE';
                                    break;
                                case 4:
                                    return 'CLIENTE';
                                    break;

                                case 5:
                                    return 'CÓDIGO';
                                    break;
                                case 6:
                                    return 'RL';
                                    break;
                                case 7:
                                    return 'UBICACIÓN';
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
                titleAttr: 'Envío contrato a RL',
                title: "Envío contrato a RL",
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                    format: {
                        header: function (d, columnIdx) {
                            switch (columnIdx) {
                                case 0:
                                    return 'TIPO VENTA';
                                    break;
                                case 1:
                                    return 'PROYECTO'
                                case 2:
                                    return 'CONDOMINIO';
                                    break;
                                case 3:
                                    return 'LOTE';
                                    break;
                                case 4:
                                    return 'CLIENTE';
                                    break;
                                case 5:
                                    return 'CÓDIGO';
                                    break;
                                case 6:
                                    return 'RL';
                                    break;
                                case 7:
                                    return 'UBICACIÓN';
                                    break;

                            }
                        }
                    }
                }
            }
        ],
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
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
            {
                data: function (d) {
                    return `<span class="label" style="background: #A3E4D7; color: #0E6251">${d.tipo_venta}</span>`;
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + d.nombreResidencial + '</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + (d.nombreCondominio).toUpperCase(); +'</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + d.nombreLote + '</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + d.nombreCliente + '</p>';
                }
            },
            {
                data: function (d) {
                    var numeroContrato;
                    if (d.vl == '1')
                        numeroContrato = 'En proceso de Liberación';
                    else {
                        if (d.numContrato == "" || d.numContrato == null)
                            numeroContrato = "<p><i>Sin número de contrato</i></p>";
                        else
                            numeroContrato = d.numContrato;
                    }
                    return numeroContrato;
                }
            },
            {
                data: function (d) {
                    if (d.RL == null || d.RL == '')
                        return '<p class="m-0"> No definido  </p>';
                    else
                        return '<p class="m-0">' + d.RL + '</p>';
                }
            },
            {
                data: function (d) {
                    return `<span class="label" style="background: #A9CCE3; color: #154360">${d.nombreSede}</span>`;
                }
            }
        ],
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: 0
            },

        ],
        ajax: {
            url: general_base_url + "Contraloria/getrecepcionContratos",
            dataSrc: "",
            type: "POST",
            cache: false,
            data: function (d) {
            }
        },
        order: [[1, 'asc']]
    });
});

var num = 1;
function saltoLinea(value) {
    if (value.length >= 13 * num) {
        document.getElementById('contratos').value = value;
        ++num;
    }
}

$(document).on('click', '.sendCont', function () {
    $('#enviarContratos').modal();
});

$(document).ready(function () {
    $("#btn_show").click(function () {
        var validaCont = $('#contratos').val();
        if (validaCont.length <= 0)
            alerts.showNotification('top', 'right', 'Ingresa los contratos.', 'danger')
        else {
            $('#btn_show').prop('disabled', true);
            var arr = $('#contratos').val().split('\n');
            var arr2 = new Array();
            ini = 0;
            fin = 1;
            indice = 0;
            for (var i = 0; i < arr.length; i += 1) {
                arr2[indice++] = arr.slice(ini, fin);
                ini += 1;
                fin += 1;
            }
            var descartaVacios2 = function (obj) {
                return Object
                    .keys(obj).map(el => obj[el])
                    .filter(el => el.length)
                    .length;
            }
            var filtrado2 = arr.filter(descartaVacios2);
            function multiDimensionalUnique2(arr) {
                var uniques = [];
                var itemsFound = {};
                for (var i = 0, l = filtrado2.length; i < l; i++) {
                    var stringified = JSON.stringify(filtrado2[i]);
                    if (itemsFound[stringified]) { continue; }
                    uniques.push(filtrado2[i]);
                    itemsFound[stringified] = true;
                }
                return uniques;
            }
            var duplicadosEliminados2 = multiDimensionalUnique2(filtrado2);
            ///////////////////ARREGLO IMPORTANTE ////////////////////////
            var descartaVacios = function (obj) {
                return Object
                    .keys(obj).map(el => obj[el])
                    .filter(el => el.length)
                    .length;
            }

            var filtrado = arr2.filter(descartaVacios);
            function multiDimensionalUnique(arr) {
                var uniques = [];
                var itemsFound = {};
                for (var i = 0, l = filtrado.length; i < l; i++) {
                    var stringified = JSON.stringify(filtrado[i]);
                    if (itemsFound[stringified]) { continue; }
                    uniques.push(filtrado[i]);
                    itemsFound[stringified] = true;
                }
                return uniques;
            }

            var duplicadosEliminados = multiDimensionalUnique(filtrado);
            arrw = JSON.stringify(duplicadosEliminados);
            fLen = duplicadosEliminados2.length;
            text = "<ul>";
            for (i = 0; i < fLen; i++) {
                var hey = text += "<li>" + duplicadosEliminados2[i] + "</li>";
            }

            text += "</ul>";
            $.ajax({
                data: "datos=" + arrw,
                url: general_base_url + "Contraloria/registro_lote_contraloria_proceceso10",
                type: 'post',
                success: function (data) {
                    response = JSON.parse(data);
                    if (response.message == 'OK') {
                        $('#btn_show').prop('disabled', false);
                        $('#enviarContratos').modal('hide');
                        $('#tabla_envio_RL').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Contratos enviado.", "success");
                    } else if (response.message == 'VOID') {
                        $('#btn_show').prop('disabled', false);
                        $('#enviarContratos').modal('hide');
                        $('#tabla_envio_RL').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "No hay contratos por registrar.", "danger");
                    } else if (response.message == 'ERROR') {
                        $('#btn_show').prop('disabled', false);
                        $('#enviarContratos').modal('hide');
                        $('#tabla_envio_RL').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                    } else if (response.message == 'NODETECTED') {
                        $('#btn_show').prop('disabled', false);
                        $('#enviarContratos').modal('hide');
                        $('#tabla_envio_RL').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "No se encontro el número de contrato.", "danger");
                    }
                },
                error: function (data) {
                    $('#btn_show').prop('disabled', false);
                    $('#enviarContratos').modal('hide');
                    $('#tabla_envio_RL').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            });
        }
    });
});
