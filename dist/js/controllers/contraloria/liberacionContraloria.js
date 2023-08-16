$(document).ready(function () {
    getResidenciales();
});

$(document).on('click', '#uploadFile', function () {
    document.getElementById("fileElm").value = "";
    document.getElementById("file-name").value = "";
});

$(document).ready(function () {
    $("input:file").on("change", function () {
        var target = $(this);
        var relatedTarget = target.siblings(".file-name");
        var fileName = target[0].files[0].name;
        relatedTarget.val(fileName);
    });
});

function readFileAsync(selectedFile) {
    return new Promise((resolve, reject) => {
        let fileReader = new FileReader();
        fileReader.onload = function (event) {
            var data = event.target.result;
            var workbook = XLSX.read(data, {
                type: "binary",
                cellDates:true,
            });
            //workbook.deleteData(wb, sheet = 1, cols = LETTERS, rows = 18, gridExpand = TRUE)
            workbook.SheetNames.forEach(sheet => {
                rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet], {defval: ''});
                jsonProspectos = JSON.stringify(rowObject, null);
            });
            resolve(jsonProspectos);
        };
        fileReader.onerror = reject;
        fileReader.readAsArrayBuffer(selectedFile);
    })
}

async function processFile(selectedFile) {
    try {
        let arrayBuffer = await readFileAsync(selectedFile);
        return arrayBuffer;
    } catch (err) {
    }
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
            processFile(fileElm.files[0]).then(jsonInfo => {
                $.ajax({
                    url: 'setData',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        "jsonInfo": jsonInfo
                    },
                    success: function (response) {
                        if (response == 0) {
                            alerts.showNotification("top", "right", "Los registros han sido actualizados de manera éxitosa.", "success");
                            $('#uploadModal').modal('toggle');
                            $("#modalConfirmRequest").modal("hide");
                            $("#liberacionesTable").DataTable().ajax.reload();
                        } else {
                            alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
                        }
                    }
                });
            });
        }else // MJ: EL ARCHIVO QUE SE INTENTA CARGAR TIENE UNA EXTENSIÓN INVÁLIDA
            alerts.showNotification("top", "right", "El archivo que has intentado cargar con la extensión <b>" + extension + "</b> no es válido. Recuera seleccionar un archivo <b>.xlsx</b>.", "warning");
    }
});

function validateExtension(extension, allowedExtensions) {
    if (extension == allowedExtensions)
        return true;
    else
        return false;
}

function getResidenciales() {
    $("#selectResidenciales").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url + 'General/getResidencialesList',
        type: 'post',
        dataType: 'json',
        success: function (response) {
            var len = response.length;
            for (var i = 0; i < len; i++) {
                var id = response[i]['idResidencial'];
                var name = response[i]['descripcion'];
                $("#selectResidenciales").append($('<option>').val(id).text(name));
            }
            $("#selectResidenciales").selectpicker('refresh');
        }
    });
}

$('#selectResidenciales').change(function () {
    let idResidencial = $(this).val();
    $("#selectCondominios").empty().selectpicker('refresh');
    var postData = "idResidencial=" + idResidencial;
    $.ajax({
        url: general_base_url + 'General/getCondominiosList',
        type: 'post',
        data:postData,
        dataType: 'JSON',
        success: function (response) {
            var len = response.length;
            for (var i = 0; i < len; i++) {
                var id = response[i]['idCondominio'];
                var name = response[i]['nombre'];
                $("#selectCondominios").append($('<option>').val(id).text(name));
                // $('#liberacionesTable').removeClass('hide');
                // fillTable(idResidencial);
            }
            $("#selectCondominios").selectpicker('refresh');
        }
    });
});

$('#selectCondominios').change(function () {
    let idCondominio = $(this).val();
    $('#liberacionesTable').removeClass('hide');
    fillTable(idCondominio);
});

let titulos = [];
$('#liberacionesTable thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $( 'input', this ).on('keyup change', function () {
        if ($('#liberacionesTable').DataTable().column(i).search() !== this.value ) {
            $('#liberacionesTable').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
})

function fillTable(idCondominio) {
    generalDataTable = $('#liberacionesTable').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true" title="DESCARGAR ARCHIVO DE EXCEL"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'DESCARGAR ARCHIVO DE EXCEL',
                title: 'Liberaciones',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                }
            }
        ],
        pagingType: "full_numbers",
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
            {},
            {
                data: function (d) {
                    return d.idLote;
                }
            },
            {
                data: function (d) {
                    return d.nombreLote;
                }
            },
            {
                data: function (d) {
                    return d.referencia;
                }
            },
            {
                data: function (d) {
                    return d.nombreCliente;
                }
            },
            {
                data: function (d) {
                    return d.fechaApartado.split('.')[0];
                }
            },
            {
                data: function (d) {
                    return '<span class="label" style="color:#' + d.colorEstatusContratacion +'; background:#' + d.colorEstatusContratacion + '18;">' + d.estatusContratacion + '</span>';
                }
            },
            {
                data: function (d) {
                    btns = '';
                    btns += '<span class="label" style="color:#'+d.colorEstatusLiberacion +'; background:#' + d.colorEstatusLiberacion + '18;">' + d.estatusLiberacion + '</span>';
                    if(d.estatusLiberacion == "En proceso de liberación")
                        btns += '<br><div class="d-flex align-center justify-center"><button class="btn-data btn-warning  remove-mark" data-toggle="tooltip"  data-placement="top" title="Remover marca" style="margin: 0;" data-idLote="'+d.idLote+'"><span class="material-icons" data-type="1">clear</span></button></div>';
                    return btns;
                }
            }
        ],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox dt-body-center',
            targets: 0,
            searchable: false,
            render: function (d, type, full, meta) {
                if (full.estatusLiberacion == "En proceso de liberación") {
                    return '';
                } else {
                    return '<input type="checkbox" disabled name="idT[]" style="width:20px; height:20px;" value="' + full.idLote + '">';
                }
            },
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            url: general_base_url + 'Contraloria/getLiberacionesInformation',
            type: "POST",
            cache: false,
            data: {
                "idCondominio": idCondominio
            }
        }
    });
}

function updateLotesStatusLiberacion(e) {
    let idLote = $(generalDataTable.$('input[name="idT[]"]:checked')).map(function () {
        return this.value;
    }).get();
    $.ajax({
        type: 'POST',
        url: general_base_url + 'Contraloria/updateLotesStatusLiberacion',
        data: {
            'idLote': idLote
        },
        dataType: 'json',
        success: function (data) {
            if (data == 0) {
                alerts.showNotification("top", "right", "Los registros han sido actualizados de manera éxitosa.", "success");
                $("#liberacionesTable").DataTable().ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
            }
        }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}

$(document).on('click', '.remove-mark', function () { // MJ: FUNCIÓN CAMBIO DE ESTATUS ACTIVO / INACTIVO
    $.ajax({
        type: 'POST',
        url: general_base_url + 'Contraloria/removeMark',
        data: {
            'idLote': $(this).attr("data-idLote")
        },
        dataType: 'json',
        success: function (data) {
            if (data == 1) {
                alerts.showNotification("top", "right", "El registro se ha actualizado con éxito.", "success");
                $("#liberacionesTable").DataTable().ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
            }
        }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$('#liberacionesTable').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});