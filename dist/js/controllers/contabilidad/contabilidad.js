let typeTransaction = 1;
$(document).ready(function () {
    getColumns();
});

let titulos_intxt = [];
$('#tableLotificacion thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($("#tableLotificacion").DataTable().column(i).search() !== this.value) {
            $("#tableLotificacion").DataTable.column(i).search(this.value).draw();
        }
    });
});

function fillTableLotificacion(lotes) {
    $("#tableLotificacion").removeClass('hide');
    generalDataTable = $('#tableLotificacion').dataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22],
                format: {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
                    }
                }
            }
        }],
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
        columns: [{
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
                return d.modificado.split('.')[0];
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
                return d.unidad;
            }
        },
        {
            data: function (d) {
                return d.calle_exacta;
            }
        },
        {
            data: function (d) {
                return d.num_ext;
            }
        },
        {
            data: function (d) {
                return d.codigo_postal;
            }
        },
        {
            data: function (d) {
                return d.colonia;
            }
        },
        {
            data: function (d) {
                return d.folio_real;
            }
        },
        {
            data: function (d) {
                return d.comentario;
            }
        }],
        columnDefs: [{
            defaultContent: "Sin especificar",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: "getInformation",
            type: "POST",
            cache: false,
            data: {
                "lotes": lotes
            }
        },
        initComplete: function(){
            $("#spiner-loader").addClass('hide');
        }
    });

    $('#tableLotificacion').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}

$(document).on('click', '.find-results', function () {
    $(".closeTable").removeClass('hide');
    $("#spiner-loader").removeClass('hide');
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
    $(".closeTable").addClass("hide");
    result = validateEmpty();
    
    if (result) {
        $(".row-load").removeClass("hide");
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
        $(".tableLotificacion").addClass("hide");
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

                var filename = "PlantillaLotes_JSON_To_XLS.xlsx";
                var ws_name = "Plantilla";

                if (typeof console !== 'undefined') console.log(new Date());
                var wb = XLSX.utils.book_new(),
                    ws = XLSX.utils.aoa_to_sheet(createXLSLFormatObj);

                XLSX.utils.book_append_sheet(wb, ws, ws_name);

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
    $("#spiner-loader").removeClass('hide');
    if (file == '')
        alerts.showNotification("top", "right", "Asegúrate de seleccionar un archivo para llevar a cabo la carga de la información.", "warning");
    else {
        let extension = file.substring(file.lastIndexOf("."));
        let statusValidateExtension = validateExtension(extension, ".xlsx");
        if (statusValidateExtension == true) {
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
                        $("#spiner-loader").addClass('hide');
                        alerts.showNotification("top", "right", response["message"], (response["status" == 503]) ? "danger" : (response["status" == 400]) ? "warning" : "success");
                        $('#uploadModal').modal('toggle');
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown){
                        alerts.showNotification("top", "right", XMLHttpRequest.status == 500 ? 'Error en los datos ingresados':'Oops, algo salió mal. Inténtalode nuevo 009.', "danger");
                        $('#uploadModal').modal('toggle');
                    }
                });
            });
        } else
            alerts.showNotification("top", "right", "El archivo que has intentado cargar con la extensión <b>" + extension + "</b> no es válido. Recuerda seleccionar un archivo <b>.xlsx</b>.", "warning");
    }
});

$(document).on('click', '#uploadFile', function () {
    document.getElementById("fileElm").value = "";
    document.getElementById("file-name").value = "";
});

$(document).on('change', "#residenciales", function () {
    cleanSelects(1);
    getCondominios($(this).val());
    $('.bs-select-all').html('Seleccionar todo').css({'font-size': '1.2ex'});
    $('.bs-deselect-all').html('Deseleccionar todo').css({'font-size': '1.2ex'});
});

$(document).on('change', "#condominios", function () {
    cleanSelects(2);
    getLotesC($(this).val());
    $('.bs-select-all').html('Seleccionar todo').css({'font-size': '1.2ex'});
    $('.bs-deselect-all').html('Deseleccionar todo').css({'font-size': '1.2ex'});
});

function cleanSelects(action) {
    if (action == 1) {
        $("#condominios").selectpicker("refresh");
        $("#lotes").empty().selectpicker('refresh');
        $("#columns").val('');
    } else if (action == 2 || action == 3 || action == 4) {
        $("#columns").val('');
        $("#columns").selectpicker("refresh");
    }

}

function getColumns() {
    $('#spiner-loader').removeClass('hide');
    $("#columns").empty().selectpicker('refresh');
    $.ajax({
        url: 'getColumns',
        type: 'post',
        dataType: 'json',
        success: function (response) {
            $('#spiner-loader').addClass('hide');
            var len = response.length;
            for (var i = 0; i < len; i++) {
                $("#columns").append($(`<option data-name='${response[i]['nombre_columna']}'>`).val(response[i]['id_opcion']).text(response[i]['nombre']));
            }
            $("#columns").selectpicker('refresh');
        }
    });
}

function getLotesC(idCondominio) {
    $("#lotes").empty().selectpicker('refresh');
    $.ajax({
        url: 'getLotesListC',
        type: 'post',
        dataType: 'json',
        data: {
            "idCondominio": idCondominio,
            "typeTransaction": typeTransaction
        },
        success: function (response) {
            var len = response.length;
            for (var i = 0; i < len; i++) {
                $("#lotes").append($('<option>').val(response[i]['idLote']).text(response[i]['nombreLote']));
            }
            $("#lotes").selectpicker('refresh');
        }
    });
} 

