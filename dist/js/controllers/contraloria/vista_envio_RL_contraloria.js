let titulosInventario = [];
$("#tabla_envio_RL").ready(function () {
    $('#tabla_envio_RL thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        titulosInventario.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if (tabla_corrida.column(i).search() !== this.value) {
                tabla_corrida.column(i).search(this.value).draw();
            }
        });
    });

    tabla_corrida = $("#tabla_envio_RL").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
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
                            return ' ' + titulosInventario[columnIdx]  + ' ';
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
                            return ' ' + titulosInventario[columnIdx]  + ' ';
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
        bAutoWidth: true,
        fixedColumns: true,
        ordering: false,
        scrollX: true,
        columns: [
            {
                data: function (d) {
                    return `<span class="label lbl-green">${d.tipo_venta}</span>`;
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
                    return '<p class="m-0">' + d.nombreCliente + '</p>';
                }
            },
            {
                data: function (d) {
                    var numeroContrato;
                    if (d.vl == '1')
                        numeroContrato = 'EN PROCESO DE LIBERACIÓN';
                    else {
                        if (d.numContrato == "" || d.numContrato == null)
                            numeroContrato = "<p><i>SIN NÚMERO DE CONTRATO</i></p>";
                        else
                            numeroContrato = d.numContrato;
                    }
                    return numeroContrato;
                }
            },
            {
                data: function (d) {
                    if (d.RL == null || d.RL == '')
                        return '<p class="m-0"> NO DEFINIDO  </p>';
                    else
                        return '<p class="m-0">' + d.RL + '</p>';
                }
            },
            {
                data: function (d) {
                    return `<span class="label lbl-azure">${d.nombreSede}</span>`;
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
        },
        order: [[1, 'asc']]
    });
});

$('#tabla_envio_RL').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
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
            text += "</ul>";
            $.ajax({
                data: "datos=" + arrw,
                url: general_base_url + "Contraloria/registro_lote_contraloria_proceceso10",
                type: 'post',
                success: function (data) {
                    response = JSON.parse(data);
                    if (response.message == 'OK') {
                        $('#btn_show').prop('disabled', false);
                        $('#tabla_envio_RL').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Contratos enviado.", "success");
                    } else if (response.message == 'VOID') {
                        $('#btn_show').prop('disabled', false);
                        $('#tabla_envio_RL').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "No hay contratos por registrar.", "danger");
                    } else if (response.message == 'ERROR') {
                        $('#btn_show').prop('disabled', false);
                        $('#tabla_envio_RL').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                    } else if (response.message == 'NODETECTED') {
                        $('#btn_show').prop('disabled', false);
                        $('#tabla_envio_RL').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "No se encontro el número de contrato.", "danger");
                    }
                },
                error: function (data) {
                    $('#btn_show').prop('disabled', false);
                    $('#tabla_envio_RL').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            });
        }
    });
});
