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
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
});

sp = { // MJ: SELECT PICKER
    initFormExtendedDatetimepickers: function () {
        $('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove',
                inline: true
            }
        });
    }
}

function setInitialDates() {
    var beginDt = moment().startOf('year').format('DD/MM/YYYY');
    var endDt = moment().format('DD/MM/YYYY');
    $('.beginDate').val(beginDt);
    $('.endDate').val(endDt);
}

function formatDate(date) {
    var dateParts = date.split("/");
    var d = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]), month = '' + (d.getMonth() + 1), day = '' + d.getDate(), year = d.getFullYear();
    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;
    return [year, month, day].join('-');
}

let titulos = [];
$('#tableLotificacion thead tr:eq(0) th').each(function (i) {
    title = $(this).text();
    titulos.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $( 'input', this).on('keyup change', function () {
        if ($('#tableLotificacion').DataTable().column(i).search() !== this.value) {
            $('#tableLotificacion').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip({trigger: "hover" });
});

function fillTableLotificacion(fechaInicio, fechaFin) {
    $(".box-table").removeClass('hide');
    generalDataTable = $('#tableLotificacion').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX:true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title:'Consulta pago final' ,
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                }
            },
            {
                text: '<i class="fas fa-play"></i>',
                className: `btn btn-dt-youtube buttons-youtube`,
                titleAttr: 'Para consultar más detalles sobre el uso y funcionalidad del apartado de Consulta pago final podrás visualizarlo en el siguiente tutorial',
                action: function (e, dt, button, config) {
                    window.open('https://youtu.be/S7HO2QTLaL0', '_blank');
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
                    return d.id_pagoi;
                }
            },
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
                    return d.monto_internomex;
                }
            },
            {
                data: function (d) {
                    return d.fecha_creacion;
                }
            },
            {
                data: function (d) {
                    return d.comentario;
                }
            },
            {
                "visible": false,
                data: function (d) {
                    if (id_rol_global == 31) {
                        return '<div class="d-flex justify-center"><button class="btn-data btn-sky edit-monto-internomex" data_monto_internomex ="'+ d.monto_internomex +'"data-id-pago="' + d.id_pagoi +'" title="Editar" onclick=><i class="fas fa-pencil-alt"></i></button>'+
                        '<button class="btn-data btn-sky see-bitacora" data-estatus="0" data-id-pago="' + d.id_pagoi +'" data-toggle="tooltip" data-placement="right" title="Bitácora"><i class="fas fa-eye"></i></button></div>';
                    }
                    else{
                        return '<div class="d-flex justify-center"><button class="btn-data btn-sky see-bitacora" data-estatus="0" data-id-pago="' + d.id_pagoi +'" data-toggle="tooltip" data-placement="right" title="Bitácora"><i class="fas fa-eye"></i></button></div>';
                    }
                }
            }
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

$(document).on('click', '.edit-monto-internomex', function(e){
    id_pago = $(this).attr("data-id-pago");
    monto = $(this).attr("data_monto_internomex");
    $("#editMontoInternomex").modal();
    $("#monto").val(monto);
    $("#id_pago").val(id_pago);
});

$(document).on('click', '.see-bitacora', function(e){
    id_pago = $(this).attr("data-id-pago");
    $.post("getBitacora/"+id_pago).done( function( data ){
        $("#changesBitacora").modal();
        $.each( JSON.parse(data), function(i, v){
            fillChangelogUsers(v);
        });
    });
});

function fillChangelogUsers(v) {
    var nombreMovimiento;
    var dataMovimiento;
    nombreMovimiento = v.col_afect;
    dataMovimiento = '<b>Valor anterior:</b> ' + v.anterior + '\n' +
        '            <br>\n' +
        '            <b>Valor nuevo:</b> ' + v.nuevo + '\n';
   $("#changelogUsers").append('<li class="timeline-inverted">\n' +
        '    <div class="timeline-badge success"><span class="material-icons">done</span></div>\n' +
        '    <div class="timeline-panel">\n' +
        '            <label><h6 style="text-transform:uppercase">' + nombreMovimiento + '</h6></label><br>\n' +
                    dataMovimiento +
        '        <h6>\n' +
        '            <span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> ' + v.fecha + ' - ' + v.usuario + '</span>\n' +
        '        </h6>\n' +
        '    </div>\n' +
        '</li>');
}

$(document).on('click', '#aceptarMonto', function(e){
    let monto = $("#monto").val();
    let id_pago = $("#id_pago").val();
    $.ajax({
        type: 'POST',
        url: 'updateMontoInternomex',
        data: {
            'monto': monto,
            'id_pago': id_pago
        },
        dataType: 'json',
        success: function (data) {
            if (data.status == 200) {
                $("#editMontoInternomex").modal("hide");
                alerts.showNotification("top", "right", "El registro ha sido actualizado de manera éxitosa.", "success");
                let fechaInicio = formatDate( $(".beginDate").val());
                let fechaFin = formatDate( $(".endDate").val());
                fillTableLotificacion(fechaInicio, fechaFin);
            } else {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
            }
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

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
    $('#tipo_pago_selector').addClass('hide');
});

$(document).on('click', '.generate', function () {
    $(".row-load").removeClass("hide");
    $(".box-table").addClass("hide");
    $('#tipo_pago_selector').removeClass('hide');
});

$(document).on('click', '#downloadFile', function () {
    let tipo_pago = $('#tipo_accion').val();
    $.ajax({
        url: 'getPaymentsListByCommissionAgent/'+tipo_pago,
        type: 'post',
        dataType: 'json',
        beforeSend: function() {
            $('#spiner-loader').removeClass('hide');
        },
        success: function (response) {
            var len = response.length;
            var createXLSLFormatObj = [];
            var xlsHeader = ["id_usuario", "nombreUsuario", 'sede', "tipoUsuario", "formaPago", "rfc", "nacionalidad", "montoSinDescuentos", "montoConDescuentosSede", "montoFinal", "comentario"];
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
                innerRowData.push(response[i]['comentario']);
                createXLSLFormatObj.push(innerRowData);
            }
            /* File Name */
            let date = new Date();
            var filename = "PlantillaComisionistas_" + date.getDate() + "-" + date.getMonth() + "-" + date.getFullYear() + " " + date.getHours() + date.getMinutes() + date.getSeconds() + date.getMilliseconds() + ".xlsx";
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
    let tipo_pago = $('#tipo_accion').val();
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
                    url: 'insertInformation/'+tipo_pago,
                    type: 'post',
                    dataType:'json',
                    data: {'data': generateJWT(jsonInfo)},
                    success: function (response) {
                        alerts.showNotification("top", "right", response["message"], (response["status" == 503]) ? "danger" : (response["status" == 400]) ? "warning" : "success");
                        $('#uploadModal').modal('toggle');
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown){
                        alerts.showNotification("top", "right", XMLHttpRequest.status == 500 ? 'Error en los datos ingresados':'Oops, algo salió mal. Inténtalo de nuevo.', "danger");
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
    var stringifiedData = CryptoJS.enc.Utf8.parse(JSON.stringify(data));
    var encodedData = base64url(stringifiedData);
    var signature = encodedHeader + "." + encodedData;
    signature = CryptoJS.HmacSHA256(signature, secret);
    signature = base64url(signature);
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

function validaTipoPago(tipo_pago){
    let one = $('#one');
    let two = $('#two');
    let cargarLabel = $('#cargarLabel');
    if(tipo_pago>0){
        one.removeAttr('disabled');
        one.attr('name', 'radio');
        two.removeAttr('disabled');
        two.attr('name', 'radio');
        cargarLabel.removeAttr('style');
        cargarLabel.removeAttr('disabled');
        $(".row-load").removeClass("hide");
        $(".box-table").addClass("hide");
    }
}