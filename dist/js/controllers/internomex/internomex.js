$(document).ready(function () {
    $("input:file").on("change", function () {
        var target = $(this);
        var relatedTarget = target.siblings(".file-name");
        var fileName = target[0].files[0].name;
        relatedTarget.val(fileName);
    });
    setInitialDates();
    if( id_rol_global == 31 )
        $('.generate').trigger('click');
    else
        $('.find-results').trigger('click');
});

function setInitialDates() {
    var beginDt = moment().startOf('year').format('DD/MM/YYYY');
    var endDt = moment().format('DD/MM/YYYY');
    $('.beginDate').val(beginDt);
    $('.endDate').val(endDt);
}

function formatDate(date) {
    var dateParts = date.split("/");
    var d = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;
    return [year, month, day].join('-');
}

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

function fillTableLotificacion(fechaInicio, fechaFin) {
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
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                    format: {
                        header: function (d, columnIdx) {
                            switch (columnIdx) {
                                case 0:
                                    return "Nombre";
                                    break;
                                case 1:
                                    return "Rol";
                                    break;
                                case 2:
                                    return "Forma de pago"
                                case 3:
                                    return "Sede";
                                    break;
                                case 4:
                                    return "Monto sin descuento";
                                break;
                                case 5:
                                    return "Monto con descuento";
                                break;
                                case 6:
                                    return "Monto internomex";
                                break;
                                case 7:
                                    return "Fecha de creación";
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
               
                    return d.nombre;
                }
            },
            { 
                data: function (d) {
                    return d.rol;
                }
            },
            { 
                data: function (d) {
                    return d.forma_pago;
                }
            },
            {
                data: function (d) {
                    return d.sede;
                }
            },
            {
                data: function (d) {
                    return d.monto_sin_descuento;
                }
            },
            {
                data: function (d) {
                    return d.monto_con_descuento;
                }
            },
            {
                data: function (d) {
                    return d.monto_internomex   ;
                }
            },
            {
                data: function (d) {
                    return d.fecha_creacion   ;
                }
            },
        ],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: "getPagosFinal",
            type: "POST",
            cache: false,
            data : {
                beginDate: fechaInicio,
                endDate: fechaFin
            }
        }
    });
}


$(document).on('click', '.searchByDateRange', function(){
    let fechaInicio = formatDate( $(".beginDate").val());
    let fechaFin = formatDate( $(".endDate").val());
    if(fechaInicio <= fechaFin ){
        fillTableLotificacion(fechaInicio, fechaFin);
    }else{
        alerts.showNotification("top", "right", "Fecha inicial no puede ser mas mayor a la fecha final", "warning");
    }
});

$(document).on('click', '.find-results', function () {
    $(".row-load").addClass("hide");
    $(".box-table").removeClass("hide");
    let fechaInicio = formatDate( $(".beginDate").val());
    let fechaFin = formatDate( $(".endDate").val());
    fillTableLotificacion(fechaInicio, fechaFin);
});

$(document).on('click', '.generate', function () {
    $(".row-load").removeClass("hide");
    $(".box-table").addClass("hide");
});

$(document).on('click', '#downloadFile', function () {
    $.ajax({
        url: 'getPaymentsListByCommissionAgent',
        type: 'post',
        dataType: 'json',
        beforeSend: function() {
            $('#spiner-loader').removeClass('hide');
          },
        success: function (response) {
            var len = response.length;
            var createXLSLFormatObj = [];
            var xlsHeader = ["id_usuario", "nombreUsuario", 'sede', "tipoUsuario", "formaPago", "rfc", "nacionalidad", "montoSinDescuentos", "montoConDescuentosSede", "montoFinal"];
            xlsHeader.push($(this).data('name'));
            createXLSLFormatObj.push(xlsHeader);
            for (var i = 0; i < len; i++) {
                var innerRowData = [];
                innerRowData.push(response[i]['id_usuario']);
                innerRowData.push(response[i]['nombreUsuario']);
                innerRowData.push(response[i]['sede']);
                innerRowData.push(response[i]['tipoUsuario']);
                innerRowData.push(response[i]['formaPago']);
                innerRowData.push(response[i]['rfc']);
                innerRowData.push(response[i]['nacionalidad']);
                innerRowData.push(response[i]['montoSinDescuentos']);
                innerRowData.push(response[i]['montoConDescuentosSede']);
                innerRowData.push(response[i]['montoFinal']);
                createXLSLFormatObj.push(innerRowData);
            }
            /* File Name */
            var filename = "PlantillaLotes_JSON_To_XLS.xlsx";
            /* Sheet Name */
            var ws_name = "Plantilla";
            //if (typeof console !== 'undefined') console.log(new Date());
            var wb = XLSX.utils.book_new(),
                ws = XLSX.utils.aoa_to_sheet(createXLSLFormatObj);
            /* Add worksheet to workbook */
            XLSX.utils.book_append_sheet(wb, ws, ws_name);
            /* Write workbook and Download */
            //if (typeof console !== 'undefined') console.log(new Date());
            XLSX.writeFile(wb, filename);
            //if (typeof console !== 'undefined') console.log(new Date());
            $('#spiner-loader').addClass('hide');
        },
        error: function() {
          $('#spiner-loader').addClass('hide');
          alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
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
    if (file == '')
        alerts.showNotification("top", "right", "Asegúrate de seleccionar un archivo para llevar a cabo la carga de la información.", "warning");
    else {
        let extension = file.substring(file.lastIndexOf("."));
        let statusValidateExtension = validateExtension(extension, ".xlsx");
        if (statusValidateExtension == true) { // MJ: ARCHIVO VÁLIDO PARA CARGAR
            processFile(fileElm.files[0]).then(jsonInfo => {
                $.ajax({
                    url: 'insertInformation',
                    type: 'post',
                    dataType:'json',
                    data: {'data': generateJWT(jsonInfo)},
                    success: function (response) {
                        alerts.showNotification("top", "right", response["message"], (response["status" == 503]) ? "danger" : (response["status" == 400]) ? "warning" : "success");
                        $('#uploadModal').modal('toggle');
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown){
                        console.log(XMLHttpRequest.status);
                        alerts.showNotification("top", "right", XMLHttpRequest.status == 500 ? 'Error en los datos ingresados':'Oops, algo salió mal. Inténtalode nuevo 009.', "danger");
                        if (XMLHttpRequest.status == 301){
                            alerts.showNotification("top", "right", 'intentas subir uno o varios regitros.' , "warning");
                        }
                        $('#uploadModal').modal('toggle');
                    }
                });
            });
        } else // MJ: EL ARCHIVO QUE SE INTENTA CARGAR TIENE UNA EXTENSIÓN INVÁLIDA
            alerts.showNotification("top", "right", "El archivo que has intentado cargar con la extensión <b>" + extension + "</b> no es válido. Recuerda seleccionar un archivo <b>.xlsx</b>.", "warning");
    }
});

$(document).on('click', '#uploadFile', function () {
    document.getElementById("fileElm").value = "";
    document.getElementById("file-name").value = "";
});


function generateJWT(excelData) {
    // Defining our token parts
    var header = {"alg": "HS256", "typ": "JWT"};
    var data = excelData;
    var secret = "thisismysecretkeytest";
    
    var stringifiedHeader = CryptoJS.enc.Utf8.parse(JSON.stringify(header));
    var encodedHeader = base64url(stringifiedHeader);
    //document.getElementById("header").innerText = encodedHeader;
    
    var stringifiedData = CryptoJS.enc.Utf8.parse(JSON.stringify(data));
    var encodedData = base64url(stringifiedData);
    //document.getElementById("payload").innerText = encodedData;
    
    var signature = encodedHeader + "." + encodedData;
    signature = CryptoJS.HmacSHA256(signature, secret);
    signature = base64url(signature);
    //document.getElementById("signature").innerText = signature;
    
    return encodedHeader + '.' + encodedData +  '.' + signature;
}

function base64url(source) {
    // Encode in classical base64
    encodedSource = CryptoJS.enc.Base64.stringify(source);
    
    // Remove padding equal characters
    encodedSource = encodedSource.replace(/=+$/, '');
    
    // Replace characters according to base64url specifications
    encodedSource = encodedSource.replace(/\+/g, '-');
    encodedSource = encodedSource.replace(/\//g, '_');
    
    return encodedSource;
  }