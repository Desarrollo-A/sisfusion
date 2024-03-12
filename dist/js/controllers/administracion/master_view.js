let hiddenOptions = {};
let titulos_intxt = [];

$(document).ready(function() {
    loadData();
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
                    return `<div class="d-flex justify-center">
                                <button class="btn-data btn-sky btn_accion" 
                                        data-toggle="tooltip" 
                                        data-placement="top" 
                                        title="ACCIONES" 
                                        value="${d.idLote}" 
                                        data-nomLote="${d.nombreLote}" 
                                        data-idCliente="${d.id_cliente}" 
                                        data-Comentario="${d.comentario}" 
                                        data-tipoVenta="${d.tipoVenta}"
                                        data-cambioEstatus="${d.cambioDisponible}" 
                                        data-estatus11="[${d.idStatusContratacion}, ${d.idMovimiento}]" 
                                        data-representante="${d.representante}"
                                        data-comentario="${d.comentario}">
                                    <i class="fas fa-history"></i>
                                </button>
                            </div>`;
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
                    }
                })
            }
        }
    });
    $("#seeInformationModal").modal();
});

$('#seeInformationModal').on('shown.bs.modal', function() {
    $("#opciones").val('');
    $("#opciones").selectpicker('refresh');
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
    console.log("Modal called");
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
    //1 RL
    if(accion == 1) {
        let representante = $(".btn_accion").closest('tr').find('td:eq(4)').text().trim(); 
        selectOptionText("representante", representante);
        $("#representante").closest('.row').show();  
    }
    //2 Cambio tipo venta
    else if(accion == 2) {
        let tipoVenta = $(".btn_accion").data('tipoventa');
        selectOptionText("tipoVenta", tipoVenta);
        $("#tipoVenta").closest('.row').show();
    }
    //3 Actualizar %impuesto sede
    else if(accion == 3) {
        $("#sedes").closest('.row').show();
        setValorExterno("sedes", "impuesto", "impuesto");
    }
    //4 CRUD Representante Agregar
    else if(accion == 4) {
        $("#nombre_rep").closest('.row').show();
    }
    //5 CRUD Representante Modificar
    else if(accion == 5) {
        $("#repData").closest('.row').show();
        setValorExterno("repData","repEstatus", "estatus");
    }
    //UPLOAD DELETE CORRIDA
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
        let cambioDisponible = $(".btn_accion").data('cambioestatus');
        if(cambioDisponible == 1) {
            handleCheckboxButton(false, 'Cambiar status lote intercambio a contratado', 'pointer');
        }else {
            handleCheckboxButton(true, 'Cambiar status lote intercambio a contratado', 'not-allowed');
        }   
    }
    else if(accion == 9) {
        $("#rowCheck").show();
        let cambioDisponible = $(".btn_accion ").data('estatus11');
        if(cambioDisponible == '6,76' || cambioDisponible == '7,77' || cambioDisponible == '8,38'
          || cambioDisponible == '11,41' || cambioDisponible == '7,37'){
            handleCheckboxButton(false, 'Regresar lote al estatus 11', 'pointer');
        }
        else {
            handleCheckboxButton(true,'Regresar lote al estatus 11', 'not-allowed');
        }
    }
});

$("#btn_upt").on('click', function(){
    $("#myModalUpdate").modal();
});
$("#switchCheckbox").on("change", function(){
    if ($(this).is(":checked")) {
        $("#myModalUpdate").modal();
        $("#myModalUpdate #cancelar").click(function(){
            $("#switchCheckbox").prop("checked", false);
        })
    }
});

$(document).on('click', "#actualizarBtn", function(e){
    e.preventDefault();
    let formData = new FormData(document.getElementById("form_rl"));
    $("#idLoteValue").val($(".btn_accion").attr('value'));
    $("#idCliente").val($(".btn_accion").data('idcliente'));
    formData.append("idLote", $("#idLoteValue").val());
    formData.append("idCliente", $("#idCliente").val());
    $.ajax({
        type: 'POST',
        url: general_base_url + 'Administracion/masterOptions',
        data: formData,
        processData: false, 
        contentType: false,
        dataType: 'json',
        success: function(response) {
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
            else {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
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
        $(`#${selectId} option[value='${value}']`).hide();
    });
    $(`#${selectId}`).selectpicker('refresh');
}

function setValorExterno(sourceId, targetId, attr) {
    $(document).on("change", `#${sourceId}`, function(){
        let valor = $(this).find("option:selected").attr(attr);
        $(`#${targetId}`).val(valor).trigger('change');
    });
} 

function loadData() {
    $("#representante, #tipoVenta, #sedes, #nombre_rep, #repData, #rowArchivo, #rowComentario, #rowCheck").closest('.row').hide();
    /*let selectsVacios = ["#opciones", "#representante", "#tipoVenta", "#repData", "#sedes"];
    selectsVacios.forEach(function(element) {
        $(element).empty().selectpicker('refresh');
    });*/
    $.post(`${general_base_url}Administracion/getCatalogoMaster`, function(data) {
        for(let i = 0; i < data.length; i++) {
            if(data[i]['id_catalogo'] == 120) {
                $("#opciones").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
            }
            if(data[i]['id_catalogo'] == 77) {
                $("#representante").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
                $("#repData").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']).attr('estatus', `${data[i]['estatus']}`));
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
    }, 'json'); 
}   
function verificarRol(idRol, type) {
    if(idRol == 11 && type == 1) {
        hideOption("opciones", [1,2,3,4,5,6,7,8,9]);   
    }
    else if(idRol == 11 && type == 2){
        hideOption("opciones", [1,2,3,4,5,6,7,8]);   
    }
    else if(idRol == 17 && type == 1) {
        hideOption("opciones" ,[1,2,6,7,8,9]);
    }
    else if(idRol == 17 && type == 2) {
        hideOption("opciones", [3,4,5,9]);   
    }
}
function handleCheckboxButton(disabled, title, cursor) {
    $("#switchCheckbox").prop('disabled', disabled);
    $("#divSwitch").attr('title', title);
    $("#divSwitch").tooltip();
    $("#divSwitch").css('cursor', cursor);
    $("#switchCheckbox").css('cursor', cursor);
    $("#btn_upt").toggle(!disabled);
    $("#lblSwitch").text(title.toUpperCase());
}
$(document).on('hidden.bs.modal', "#seeInformationModal", function(){
    $(".rowHide").hide();
    $("#opciones option").css('display', 'block');
    $("#btn_upt").show();
    //$("#opciones, #tipoVenta, #representante, #sedes, #impuesto, #repEstatus, #repData").val('').selectpicker('refresh');
    $("#tipoVenta, #representante, #sedes, #impuesto, #repEstatus, #repData").val('').selectpicker('refresh');
});