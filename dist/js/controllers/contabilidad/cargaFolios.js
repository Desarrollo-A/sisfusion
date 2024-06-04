$(document).ready(function () {
    $('#spiner-loader').removeClass('hide');

    $.post(`${general_base_url}Contabilidad/lista_proyectos`, function(data) {
        for( let i = 0; i<data.length; i++){
            const id = data[i]['idResidencial'];
            const name = data[i]['descripcion'];
            $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#proyecto").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');

    setInitialDates();

    $('.generate').trigger('click');

    sp.initFormExtendedDatetimepickers();
});

$('.datepicker').datetimepicker({locale: 'es'});

$('#proyecto').change(function() {
    $('#spiner-loader').removeClass('hide');
    const proyectoSeleccionado = $(this).val();
    $("#condominio").html("");
    $.post(`${general_base_url}Contabilidad/lista_condominios/${proyectoSeleccionado}`, function(data) {
        $("#condominio").append($('<option disabled selected>SELECCIONA UN CONDOMINIO</option>'));
        for( let i = 0; i<data.length; i++){
            const id = data[i]['idCondominio'];
            const name = data[i]['nombre'];
            $("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#condominio").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
    
});

$('#condominio').change( function() {
    const condominio = $(this).val();
    $("#lote").html("");
    dataTable(condominio);
});

$(document).on("change", "#archivo", function () {
    const target = $(this);
    const relatedTarget = target.siblings(".file-name");
    const fileName = target[0].files[0].name;
    relatedTarget.val(fileName);
});

const downloadTemplate = (idCondominio) => {
    $.ajax({
        url: `${general_base_url}Contabilidad/lista_lotes`,
        type: 'post',
        dataType: 'json',
        data: {
            idCondominio: idCondominio,
        },
        beforeSend: function() {
            $('#spiner-loader').removeClass('hide');
        },
        success: function (response) {
            
            let template = [];
            const headers = ['idLote', 'nombreLote', 'calle', 'colonia', 'exterior', 'codigoPostal', 'superficie', 'régimen', 'folio'];
            template.push(headers);
            for (let i = 0; i < response.length; i++) {
                const row = [];
                row.push(response[i]['idLote']);
                row.push(response[i]['nombreLote']);
                template.push(row);
            }

            const date = new Date();
            const filename = "PlantillaIngresoFolios_" + date.getDate() + "-" + date.getMonth() + "-" + date.getFullYear() + " " + date.getHours() + date.getMinutes() + date.getSeconds() + date.getMilliseconds() + ".xlsx";
            const ws_name = "Plantilla";
            const wb = XLSX.utils.book_new(),
                ws = XLSX.utils.aoa_to_sheet(template);
            XLSX.utils.book_append_sheet(wb, ws, ws_name);
            XLSX.writeFile(wb, filename);
            $('#spiner-loader').addClass('hide');
        },
        error: function() {
            $('#spiner-loader').addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}

sp = { 
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

const setInitialDates = () => {
    const beginDt = moment().startOf('year').format('DD/MM/YYYY');
    const endDt = moment().format('DD/MM/YYYY');
    $('.beginDate').val(beginDt);
    $('.endDate').val(endDt);
}

const formatDate = (date) => {
    const dateParts = date.split("/");
    const d = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]), month = '' + (d.getMonth() + 1), day = '' + d.getDate(), year = d.getFullYear();
    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;
    return [year, month, day].join('-');
}

let titulos = [];
$('#foliosTable thead tr:eq(0) th').each(function (i) {
    title = $(this).text();
    titulos.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $( 'input', this).on('keyup change', function () {
        if ($('#foliosTable').DataTable().column(i).search() !== this.value) {
            $('#foliosTable').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip({trigger: "hover" });
});

const dataTable = (idCondominio) => {
    $(".box-table").removeClass('hide');
    generalDataTable = $('#foliosTable').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX:true,
        buttons: [
        {
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Plantilla para carga de folios',
            action: () => downloadTemplate(idCondominio)
        },
        {
            text: '<i class="fas fa-play"></i>',
            className: `btn btn-dt-youtube buttons-youtube`,
            titleAttr: 'Para consultar más detalles sobre el uso y funcionalidad del apartado de carga de folios podrás visualizarlo en el siguiente tutorial',
            action: function (e, dt, button, config) {
                window.open('https://youtu.be/S7HO2QTLaL0', '_blank');
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
        columns: [
            {
                data: function (d) {
                    return d.idInfoLote;
                }
            },
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
                    return d.calle;
                }
            },
            {
                data: function (d) {
                    return d.colonia;
                }
            },
            {
                data: function (d) {
                    return d.numExterior;
                }
            },
            {
                data: function (d) {
                    return d.codigoPostal;
                }
            },
            {
                data: function (d) {
                    return d.superficie;
                }
            },
            {
                data: function (d) {
                    return d.regimen;
                }
            },
            {
                data: function (d) {
                    return d.folio;
                }
            },
            {
                data: function (d) {
                    return 'ACCIONES';
                }
            }
        ],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: `${general_base_url}Contabilidad/getLotesConFolios`,
            type: "POST",
            cache: false,
            data : {
                idCondominio: idCondominio
            }
        },
        initComplete: function(){
            $("#spiner-loader").addClass('hide');
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

const fillChangelogUsers = (v) => {
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
                dataTable(fechaInicio, fechaFin);
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
        datatable(fechaInicio, fechaFin);
    }else{
        alerts.showNotification("top", "right", "Fecha inicial no puede ser mas mayor a la fecha final", "warning");
    }
});

$(document).on('click', '.find-results', function () {
    $("#spiner-loader").removeClass('hide');
    $(".row-load").addClass("hide");
    $(".box-table").removeClass("hide");
    let fechaInicio = formatDate( $(".beginDate").val());
    let fechaFin = formatDate( $(".endDate").val());
    datatable(fechaInicio, fechaFin);
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

            let date = new Date();
            var filename = "PlantillaComisionistas_" + date.getDate() + "-" + date.getMonth() + "-" + date.getFullYear() + " " + date.getHours() + date.getMinutes() + date.getSeconds() + date.getMilliseconds() + ".xlsx";
            var ws_name = "Plantilla";
            var wb = XLSX.utils.book_new(),
                ws = XLSX.utils.aoa_to_sheet(createXLSLFormatObj);
            XLSX.utils.book_append_sheet(wb, ws, ws_name);
            XLSX.writeFile(wb, filename);
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
        if (statusValidateExtension == true) { 
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
        } else
            alerts.showNotification("top", "right", "El archivo que has intentado cargar con la extensión <b>" + extension + "</b> no es válido. Recuerda seleccionar un archivo <b>.xlsx</b>.", "warning");
    }
});

function generateJWT(excelData) {
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
    encodedSource = CryptoJS.enc.Base64.stringify(source);
    encodedSource = encodedSource.replace(/=+$/, '');
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