$('#tableLotificacion thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    if (i != 13) {
        $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($("#tableLotificacion").DataTable().column(i).search() !== this.value) {
                $("#tableLotificacion").DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    }
});

function fillTableLotificacion(lotes) {
    $(".box-table").removeClass('hide');
    generalDataTable = $('#tableLotificacion').dataTable({
        dom: 'Brt' + "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: "auto",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                    format: {
                        header: function (d, columnIdx) {
                            switch (columnIdx) {
                                case 0:
                                    return "NOMBRE CLIENTE";
                                    break;
                                case 1:
                                    return "NOMBRE LOTE";
                                    break;
                                case 2:
                                    return "SUPERFICIE"
                                case 3:
                                    return "PRECIO POR M2";
                                    break;
                                case 4:
                                    return "TOTAL";
                                    break;
                                case 5:
                                    return "MODIFICADO";
                                    break;
                            }
                        }
                    }
                }
            }
        ],
        pagingType: "full_numbers",
        fixedHeader: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            {
                data: function (d) {
                    return d.nombreCliente;
                }
            },
            {
                data: function (d) {
                    return d.nombreLote;
                }
            },
            {
                data: function (d) {
                    return d.superficie;
                }
            },
            {
                data: function (d) {
                    return d.preciom2;
                }
            },
            {
                data: function (d) {
                    return d.total;
                }
            },
            {
                data: function (d) {
                    return d.modificado;
                }
            },
            {
                data: function (d) {
                    return d.fecha_firma;
                }
            },
            {
                data: function (d) {
                    return d.adendum;
                }
            },
            {
                data: function (d) {
                    return d.superficie_postventa;
                }
            },
            {
                data: function (d) {
                    return d.costo_m2;
                }
            },
            {
                data: function (d) {
                    return d.parcela;
                }
            },
            {
                data: function (d) {
                    return d.superficie_proyectos;
                }
            },
            {
                data: function (d) {
                    return d.presupuesto_m2;
                }
            },
            {
                data: function (d) {
                    return d.deduccion;
                }
            },
            {
                data: function (d) {
                    return d.m2_terreno;
                }
            },
            {
                data: function (d) {
                    return d.costo_terreno;
                }
            },
            {
                data: function (d) {
                    return d.comentario;
                }
            }
        ],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: "getInformation",
            type: "POST",
            cache: false,
            data: {
                "lotes": lotes
            }
        }
    });
}

$(document).on('click', '.find-results', function () {
    result = validateEmpty();
    if (result) {
        $(".row-load").addClass("hide");
        let lotes = $("#lotes").val();
        fillTableLotificacion(lotes);
    } else {
        $('#notificacion').modal('show');
    }
});

$(document).on('click', '.generate', function () {
    result = validateEmpty();
    if (result) {
        $(".row-load").removeClass("hide");
        $(".box-table").addClass("hide");
    } else {
        $('#notificacion').modal('show');
    }
});

$(document).on('change', ".select-gral", function () {
    validateEmpty();
});

function validateEmpty() {
    if ($("#residenciales").val() == '' || $("#condominios").val().length == 0 || $("#lotes").val().length == 0) {
        $(".row-load").addClass("hide");
        $(".box-table").addClass("hide");
        $("#columns").selectpicker('refresh');
        $(".generate").prop('checked', false);
        $(".find-results").prop('checked', false);
        cleanSelects(4);
        return false;
    } else return true;
}

$(document).on('click', '#downloadFile', function () {
    if ($("#residenciales").val() == '' || $("#condominios").val().length == 0 || $("#lotes").val().length == 0 || $("#columns").val().length == 0) {
        $('#notificacion').modal('show');
    } else {
        let lotes = $("#lotes").val();
        $.ajax({
            url: 'getClientLote',
            type: 'post',
            dataType: 'json',
            data: {
                "lotes": lotes
            },
            success: function (response) {
                var len = response.length;
                var createXLSLFormatObj = [];
                var xlsHeader = ["id_lote", "nombre_lote", 'id_cliente', "nombre_cliente"];
                $('#columns').find("option:selected").each(function () {
                    xlsHeader.push($(this).data('name'));
                });

                createXLSLFormatObj.push(xlsHeader);
                for (var i = 0; i < len; i++) {
                    var innerRowData = [];
                    innerRowData.push(response[i]['idLote']);
                    innerRowData.push(response[i]['nombreLote']);
                    innerRowData.push(response[i]['id_cliente']);
                    innerRowData.push(response[i]['nombreCliente']);
                    createXLSLFormatObj.push(innerRowData);
                }

                /* File Name */
                var filename = "PlantillaLotes_JSON_To_XLS.xlsx";

                /* Sheet Name */
                var ws_name = "Plantilla";

                if (typeof console !== 'undefined') console.log(new Date());
                var wb = XLSX.utils.book_new(),
                    ws = XLSX.utils.aoa_to_sheet(createXLSLFormatObj);

                /* Add worksheet to workbook */
                XLSX.utils.book_append_sheet(wb, ws, ws_name);

                /* Write workbook and Download */
                if (typeof console !== 'undefined') console.log(new Date());
                XLSX.writeFile(wb, filename);
                if (typeof console !== 'undefined') console.log(new Date());

            }
        });
    }
});

$(document).ready(function () {
    $("input:file").on("change", function () {
        var target = $(this);
        var relatedTarget = target.siblings(".file-name");
        var fileName = target[0].files[0].name;
        relatedTarget.val(fileName);
    });
});

async function processFile(selectedFile) {
    try {
        let arrayBuffer = await readFileAsync(selectedFile);
        console.log(arrayBuffer);
        return arrayBuffer;
    } catch (err) {
        console.log(err);
    }
}

function readFileAsync(selectedFile) {
    return new Promise((resolve, reject) => {
        let fileReader = new FileReader();
        fileReader.onload = function (event) {
            var data = event.target.result;
            var workbook = XLSX.read(data, {
                type: "binary",
                cellDates:true,
            });
            workbook.SheetNames.forEach(sheet => {
                rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet], {defval: '', blankrows: true});
                jsonProspectos = JSON.stringify(rowObject, null);
            });
            resolve(jsonProspectos);
        };
        fileReader.onerror = reject;
        fileReader.readAsArrayBuffer(selectedFile);
    })
}

$(document).on('click', '#cargaCoincidencias', function () {
    fileElm = document.getElementById("fileElm");
    file = fileElm.value;
    if (file == '')
        alerts.showNotification("top", "right", "Asegúrate de seleccionar un archivo para llevar a cabo la carga de la información.", "warning");
    else {
        let extension = file.substring(file.lastIndexOf("."));
        let statusValidateExtension = validateExtension(extension, ".xlsx");
        if (statusValidateExtension == true) { // MJ: ARCHIVO VÁLIDO PARA CARGAR
            let lotes = $("#lotes").val();
            processFile(fileElm.files[0]).then(jsonInfo => {
                $.ajax({
                    url: 'setData',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        "jsonInfo": jsonInfo,
                        "lotes": lotes
                    },
                    success: function (response) {
                        alerts.showNotification("top", "right", response["message"], (response["status" == 503]) ? "danger" : (response["status" == 400]) ? "warning" : "success");
                        $('#uploadModal').modal('toggle');
                    }
                });
            });
        } else // MJ: EL ARCHIVO QUE SE INTENTA CARGAR TIENE UNA EXTENSIÓN INVÁLIDA
            alerts.showNotification("top", "right", "El archivo que has intentado cargar con la extensión <b>" + extension + "</b> no es válido. Recuera seleccionar un archivo <b>.xlsx</b>.", "warning");
    }
});

$(document).on('click', '#uploadFile', function () {
    document.getElementById("fileElm").value = "";
    document.getElementById("file-name").value = "";
});

$(document).on('change', "#residenciales", function () {
    //getCondominios($(this).val());
    cleanSelects(1);
});

$(document).on('change', "#condominios", function () {
    //getLotes($(this).val());
    cleanSelects(2);
});

function cleanSelects(action) {
    if (action == 1) { // MJ: CHANGE RESIDENCIALES
        $("#condominios").selectpicker("refresh");
        $("#lotes").empty().selectpicker('refresh');
        $("#columns").val('');
    } else if (action == 2 || action == 3 || action == 4) {
        $("#columns").val('');
        $("#columns").selectpicker("refresh");
    }

}
