let hiddenOptions = {};
let titulos_intxt = [];

$(document).ready(function() {
    loadData();
    $("input:file").on("change", function () {
        var target = $(this);
        var relatedTarget = target.siblings(".file-name");
        var fileName = target[0].files[0].name;
        relatedTarget.val(fileName);
    });
});

$('#tableDoct thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#tableDoct').DataTable().column(i).search() !== this.value ) {
            $('#tableDoct').DataTable().column(i).search(this.value).draw();
        }
    });
});

$(".find_doc").click(function() {
    $("#tableDoct").removeClass('hide');
    var idLote = $('#inp_lote').val();
    documentacionLoteTabla = $("#tableDoct").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        ajax:
        {
            "url": general_base_url + 'index.php/Administracion/getDatosLotes/'+idLote,
            "dataSrc": "",
        },
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'LOTES INFO',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5,6],
                format: 
                {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx]  + ' ';
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
        columns: [
            {data: 'nombreResidencial'},
            {data: 'nombreCondominio'},
            {data: 'nombreCliente'},
            {data: 'fechaApartado'},
            {data: 'representante'},
            {data: 'tipoVenta'},
            {data: 'nombreLote'},
            {data: 'idLote'},
            {data: 'estatusContratacion'},
            {data: 'movimientoEstatus'},
            {data: 'estatusLote'},
            {
                "data": function(d) {
                    return `<div class="d-flex justify-center"><button class="btn-data btn-sky btn_accion" data-toggle="tooltip" data-placement="top" title="ACCIONES" value="${d.idLote}" data-nomLote="${d.nombreLote}" data-idCliente="${d.idCliente}" data-Comentario="${d.comentario}" data-tipoVenta="${d.tipoVenta}"data-cambioEstatus="${d.cambioDisponible}" data-estatus11="[${d.idStatusContratacion}, ${d.idMovimiento}]" data-representante="${d.representante}"data-comentario="${d.comentario}" data-idTipoVenta="${d.idTipoVenta}" data-tipoCasa="${d.tipoCasa}" data-idStatusLote="${d.idStatusLote}"><i class="fas fa-history"></i></button></div>`;
                }
            }
        ],
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            });
        }
    });
    $(window).resize(function(){
        documentacionLoteTabla.columns.adjust();
    });
});
$('#addDeleteFileModal').on('show.bs.modal', function () {
    $(this).css('z-index', 1500); 
    $('.modal-backdrop').css('z-index', 1490); 
});

$(document).on("click", ".btn_accion", function() {
    verificarRol(id_rol_general, 2);
    var idLote = $("#inp_lote").val();
    let buttonMain = '';
    let buttonDelete = '';
    $.ajax({
        type: 'POST',
        url: `${general_base_url}registroCliente/expedientesWS/${idLote}`,
        dataType: 'json',
        success: function(data) {
            if(data.length > 0) {
                $.each(data, function(i, v){
                    if(v.tipo_doc == TipoDoc.CORRIDA){
                        if(v.expediente == null || v.expediente === "") {
                            buttonMain = includesArray(movimientosPermitidosEstatus6, v.idMovimiento)
                                ? crearBotonAccion(AccionDoc.SUBIR_DOC, v)
                                : crearBotonAccion(AccionDoc.DOC_NO_CARGADO, v);
                                $("#rowArchivo").html(`<div class="d-flex justify-center">${buttonMain} ${buttonDelete}</div>`);
                                $("#docTipo").val(0);
                        }else {
                            buttonMain = crearBotonAccion(AccionDoc.DOC_CARGADO, v);
                            buttonDelete = crearBotonAccion(AccionDoc.ELIMINAR_DOC, v);
                            $("#docTipo").val(1);
                            $("#rowArchivo").html(`<div class="d-flex justify-center">${buttonMain} ${buttonDelete}</div>`);
                        }
                    }else {

                    }
                })
            }
        }
    });
    $("#seeInformationModal").modal();
});

$('#seeInformationModal').on('shown.bs.modal', function() {
    let opciones = $("#opciones");
    opciones.find('option').each(function(){
        if ($(this).css('display') !== 'none') {
            $(this).prop('selected', true);
            return false;
        }
    })
    opciones.selectpicker('refresh');
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});
$(document).on("click", "#moreOptions", function(){
    $("#seeInformationModal").modal();
    verificarRol(id_rol_general, 1);
});

$('#addDeleteFileModal').on('show.bs.modal', function () {
    $(this).css('z-index', 1500); 
    $('.modal-backdrop').css('z-index', 1490); 
});
$('#addDeleteFileModal').on('hidden.bs.modal', function () {
    $(this).css('z-index', ''); 
    $('.modal-backdrop').css('z-index', ''); 
});

$('#seeInformationModal').on('hide.bs.modal', function () {
    $('#addDeleteFileModal').css('z-index', ''); 
    $('.modal-backdrop').css('z-index', ''); 
});

$("#opciones").change(function(){
    $(".rowHide").hide();
    $("#btn_upt").show();
    let accion = $("#opciones").val();
    $("#opcionesRow").show();
    if(accion == 1) {
        let representante = $(".btn_accion").closest('tr').find('td:eq(4)').text().trim(); 
        selectOptionText("representante", representante);
        $("#representante").closest('.row').show();  
    }
    else if(accion == 2) {
        let tipoVenta = $(".btn_accion").data('tipoventa');
        selectOptionText("tipoVenta", tipoVenta);
        $("#tipoVenta").closest('.row').show();
    }
    else if(accion == 3) {
        $("#sedes").closest('.row').show();
        setValorExterno("sedes", "impuesto", "impuesto");
        console.log("accion: 3");
    }
    else if(accion == 4) {
        $("#nombre_rep").closest('.row').show();
    }
    else if(accion == 5) {
        $("#repData").closest('.row').show();
        setValorExterno("repData","repEstatus", "estatus");
    }
    else if(accion == 6) {
        $("#rowArchivo").closest('.row').show();
    }
    else if(accion == 7) {
        $("#rowComentario").show();
        $("#comentarioLote").val($(".btn_accion").data('comentario'));
        if($(".btn_accion").data('comentario') === '') {
            $("#comentarioLote").prop('disabled', true);
        }else {
            $("#comentarioLote").prop('disabled', false);
        }
    }
    else if (accion == 8) {
        $("#rowCheck").show();
        $("#btn_upt").hide();
        let cambioDisponible = $(".btn_accion").data('cambioestatus');
        if(cambioDisponible == 1) {
            $("#nombreSwitch").prop('disabled', false);
            switchOpciones('Cambiar status lote intercambio a contratado', 'pointer');
            
        }else {
            switchOpciones('No habilitado', 'not-allowed');
            $("#nombreSwitch").prop('disabled', true);
        }   
    }
    else if(accion == 9) {
        $("#rowCheck").show();
        $("#btn_upt").hide();
        let cambioDisponible = $(".btn_accion ").data('estatus11');
        if(cambioDisponible == '6,76' || cambioDisponible == '7,77' || cambioDisponible == '8,38'
          || cambioDisponible == '11,41' || cambioDisponible == '7,37'){
            $("#nombreSwitch").prop('disabled', false);
            switchOpciones('CAMBIAR EL STATUS', 'pointer');
        }
        else {
            $("#nombreSwitch").prop('disabled', true);
            switchOpciones('No aplica', 'not-allowed');
        }
    }
    else if(accion == 10) {
        $("#rowCheck").show();
        let tipoVenta = $(".btn_accion").data('tipoventa');
    }
    else if(accion == 11) {
        $("#nacionalidad").closest('.row').show();
    }
    else if (accion == 12) {
        $("#tipoCasa").closest('.row').show();
        let tipoCasa = $(".btn_accion").data('tipocasa');
        selectOptionValue("tipoCasa", tipoCasa);
        if (tipoCasa == 0) {
            $("#tipoCasa").prop("disabled", true);
            $("#tipoCasa").closest('.bootstrap-select').addClass("disabled");
            $("#tipoCasa").selectpicker('refresh');
        } else {
            $("#tipoCasa").prop("disabled", false);
            $("#tipoCasa").closest('.bootstrap-select').removeClass("disabled");
            $("#tipoCasa").selectpicker("refresh");
        }
    }
    else if(accion == 13 ) {
        let idStatusLote = $(".btn_accion").data('idstatuslote');        
        $("#rowCheck").show();
        $("#btn_upt").hide();
        if(idStatusLote == 8) {
            $("#nombreSwitch").prop('disabled', false);
            switchOpciones('Cambiar de estatus lote de apartado a contratatado', 'pointer');
        }
        else {
            $("#nombreSwitch").prop('disabled', true);
            switchOpciones('No habilitado', 'not-allowed');
        }
    }
    else if(accion == 14) {
        let estatus = $('.btn_accion').data('estatus11');
        $("#rowEstatus").show();
        console.log("estatus: ", estatus);
        if(estatus[0] == 5 && estatus[1] == 75) {
            $("#statusLote").prop("disabled", false);
            $("#rowComentario").show();
            $("#comentarioLote").prop('disabled', false);
        }
        else {
            $("#statusLote").prop("disabled", true);
        }

    }
    else if(accion == 15) {
        $("#uploadModal").modal('toggle');
        $("#seeInformationModal").modal('toggle');
    }
});

let valorCheck = '';
$("#nombreSwitch").change(function() {
    valorCheck = this.checked;
    if(this.checked) {
        $("#myModalUpdate").modal();
        $("#myModalUpdate #cancelar").click(function() {
            $("#nombreSwitch").prop("checked", false);
        });
    }
});
function switchOpciones(title, cursor) {
    $("#divSwitch").attr('title', title);
    //$("#divSwitch").tooltip('hide').tooltip('fixTitle').tooltip('show');
    $("#divSwitch").css('cursor', cursor);
}
$(document).on('click', "#actualizarBtn", function(e){
    e.preventDefault();
    let formData = new FormData(document.getElementById("form_rl"));
    $("#idLoteValue").val($(".btn_accion").attr('value'));
    $("#idCliente").val($(".btn_accion").data('idcliente'));
    formData.append("idLote", $("#idLoteValue").val());
    formData.append("idCliente", $("#idCliente").val());
    formData.append("idTipoVenta", $(".btn_accion").data('idtipoventa'));
    $.ajax({
        type: 'POST',
        url: general_base_url + 'Administracion/masterOptions',
        data: formData,
        processData: false, 
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if(response.empty === true) {
                alerts.showNotification("top", "right", response.msg, "warning");
            }
            if(response.status === true) {
                $("#myModalUpdate, #seeInformationModal").modal('hide');
                alerts.showNotification("top", "right", "Se han realizado los cambios con exito.", "success");
                if(response.tabla === true) {
                    $("#tableDoct").DataTable().ajax.reload(null, false);
                    document.getElementById("form_rl").reset();
                }
                if(response.reload === true){
                    loadData();
                }
            }
        }, 
        error: function(data) {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
});

function selectOptionText(selectId, text){
    $(`#${selectId} option`).each(function(){
        if ($(this).text().trim().toLowerCase() === text.toLowerCase()){
            $(this).prop('selected', true);
            return false;
        }
    });
    $(`#${selectId}`).selectpicker('refresh');
}

function hideOption(selectId, optionValue) {
    hiddenOptions[selectId] = optionValue;
    optionValue.forEach(function(value) {
        $(`#${selectId} option[value='${value}']`).addClass('d-none');
    });

    // Select the first visible option
    let firstVisibleOption = $(`#${selectId} option:not(.d-none):first`);
    if (firstVisibleOption.length > 0) {
        $(`#${selectId}`).val(firstVisibleOption.val());
    }

    // Refresh the selectpicker
    $(`#${selectId}`).selectpicker('refresh').trigger('change');
}




function setValorExterno(sourceId, targetId, attr) {
    $(document).on("change", `#${sourceId}`, function(){
        let valor = $(this).find("option:selected").attr(attr);
        $(`#${targetId}`).val(valor).trigger('change');
    });
} 
function selectOptionValue(selectId, value) {
    $(`#${selectId}`).val(value);
    $(`#${selectId}`).selectpicker('refresh');
}


function loadData() {
    $("#representante, #tipoVenta, #sedes, #nombre_rep, #repData, #rowArchivo, #rowComentario, #rowCheck, #nacionalidad, #tipoCasa").closest('.row').hide();
    let selectsVacios = ["#opciones", "#representante", "#tipoVenta", "#repData", "#sedes"];
    selectsVacios.forEach(function(element) {
        $(element).empty().selectpicker('refresh');
    });
    $.post(`${general_base_url}Administracion/getCatalogoMaster`, function(data) {
        for(let i = 0; i < data.length; i++) {
            if(data[i]['id_catalogo'] == 120) {
                $("#opciones").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
            }
            if(data[i]['id_catalogo'] == 77) {
                $("#representante").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
                $("#repData").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']).attr('estatus', `${data[i]['estatus']}`));
            }
            if(data[i]['id_catalogo'] == 35) {
                $("#tipoCasa").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']).attr('estatus', `${data[i]['estatus']}`));
            }
            if(data[i]['id_catalogo']  == 'venta_tipo') {
                $("#tipoVenta").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
            }
            if(data[i]['id_catalogo'] == 'sedes') {
                $("#sedes").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']).attr('impuesto', `${data[i]['estatus']}`));
            }
        }
        $("#opciones").selectpicker('refresh');
        $("#representante").selectpicker('refresh');
        $("#tipoVenta").selectpicker('refresh');
        $("#repData").selectpicker('refresh');
        $("#sedes").selectpicker('refresh');
        $("#tipoCasa").selectpicker('refresh');
    }, 'json'); 
}   
function verificarRol(idRol, type) {
    //Administración ->11
    //Contraloría -> 17
    //Juridico -> 15
    console.log("idRol: ", idRol);
    console.log("type: ", type);;
    if(idRol == 11 && type == 1) {
        hideOption("opciones", [1,2,3,4,5,6,7,8,9,14,15]);   
    }
    else if(idRol == 11 && type == 2){
        hideOption("opciones", [1,2,3,4,5,6,7,8,14,15]);   
    }
    else if(idRol == 17 && type == 1) {
        hideOption("opciones" ,[1,2,6,7,8,9,14,15]);
    }
    else if(idRol == 17 && type == 2) {
        hideOption("opciones", [3,4,5,9]);   
    }
    else if(idRol == 15 && type == 1) {
        hideOption("opciones", [1,2,3,4,5,6,7,8,9,11,12,13,14, 15]);   
    }
    else if(idRol == 15 && type == 2) {
        hideOption("opciones", [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15]);   
    }
}

$(document).on('hidden.bs.modal', "#seeInformationModal", function(){
    $(".rowHide").hide();
    $("#opciones option").removeClass('d-none');
    $("#btn_upt").show();
    $("#tipoVenta, #representante, #sedes, #impuesto, #repEstatus, #repData, #tipoCasa, #opciones").val('').selectpicker('refresh');
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


$(document).on('click', '#cargaCoincidencias', function(){
    let tipo_pago = $("#tipo_accion").val();
    let formData = new FormData(document.getElementById("form_rl"));
    fileElm = document.getElementById("fileElm");
    file = fileElm.value;
    
    if(file == '' ) {
        alerts.showNotification("top", "right", "Asegúrate de seleccionar un archivo para llevar a cabo la carga de la información.", "warning");
    } 
    else if(tipo_pago === '') {
        alerts.showNotification("top", "right", "Asegúrate de seleccionar el estatus.", "warning");
    }
    else {
        let extension = file.substring(file.lastIndexOf("."));
        let statusValidateExtension = validateExtension(extension, ".xlsx");
        if (statusValidateExtension == true) {
            processFile(fileElm.files[0]).then(jsonInfo => {
                formData.append('data', generateJWT(jsonInfo));
                formData.append('tipoPago', tipo_pago);
                $.ajax({
                    url: general_base_url + 'Administracion/masterOptions',
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    
                    success: function(response) {

                        if(response.status === true) {
                            $("#uploadModal").modal('toggle');
                            alerts.showNotification("top", "right", "Se han realizado los cambios con exito.", "success");
                            if(response.tabla === true) {
                                $("#tableDoct").DataTable().ajax.reload(null, false);
                                document.getElementById("form_rl").reset();
                            }
                            if(response.reload === true){
                                loadData();
                            }
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown){

                        alerts.showNotification("top", "right", XMLHttpRequest.status == 500 ? 'Error en los datos ingresados':'Oops, algo salió mal. Inténtalo de nuevo.', "danger");
                        if (XMLHttpRequest.status == 301){
                            alerts.showNotification("top", "right", 'intentas subir uno o varios regitros.' , "warning");
                        }
                        //$('#uploadModal').modal('toggle');
                    }
                });
            })
        }
    }
});
console.log("id_rol: ", id_rol_general);

