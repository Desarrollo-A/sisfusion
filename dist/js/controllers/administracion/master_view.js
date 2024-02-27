let hiddenOptions = {};
let titulos_intxt = [];
$(document).ready(function() {
    loadData();
});

$('#tabla_inventario_contraloria thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#tabla_inventario_contraloria').DataTable().column(i).search() !== this.value ) {
            $('#tabla_inventario_contraloria').DataTable().column(i).search(this.value).draw();
        }
    });
});

$(".find_doc").click( function() {
    $("#tabla_inventario_contraloria").removeClass('hide');
    var idLote = $('#inp_lote').val();
    tabla_inventario = $("#tabla_inventario_contraloria").DataTable({
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
            {data: 'idLote'},
            {data: 'nombreLote'},
            {data: 'nombreCliente'},
            {data: 'fechaApartado'},
            {data: 'representante'},
            {
                "data": function(d) {
                    return '<div class="d-flex justify-center"><button class="btn-data btn-sky btn_accion" data-toggle="tooltip" data-placement="top" title="ACCIONES" value="' + d.idLote + '" data-nomLote="'+ d.nombreLote+'" data-idCliente="'+ d.id_cliente+'" data-tipoVenta="'+ d.tipo_venta+'"><i class="fas fa-history"></i></button></div>';
                }
            }
        ],
    });
    $(window).resize(function(){
        tabla_inventario.columns.adjust();
    });
});

$("#tabla_inventario_contraloria").on('draw.dt', function(){
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

$(document).on("click", "#moreOptions", function(){
    $("#seeInformationModal").modal();
    hideOption("opciones", [1,2,6]);
    console.log('Hide options 1,2,6');
});

$(document).on("click", ".btn_accion", function() {
    $("#seeInformationModal").modal();
    hideOption("opciones", [3,4,5]);
});
$("#opciones").change(function(){
    $("#representante").closest('.row').hide();
    $("#tipoVenta").closest('.row').hide();
    $("#sedes").closest('.row').hide();
    $("#nombre_rep").closest('.row').hide();
    $("#repData").closest('.row').hide();
    let accion = $("#opciones").val();
    //1 RL
    if(accion == 1) {
        let representante = $(".btn_accion").closest('tr').find('td:eq(6)').text().trim(); 
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
});

$("#btn_upt").on('click', function(){
    $("#myModalUpdate").modal();
});

$(document).on('click', "#actualizarBtn", function(e){
    e.preventDefault();
    let formData = new FormData(document.getElementById("form_rl"));
    $("#idLote").val($(".btn_accion").attr('value'));
    $("#idCliente").val($(".btn_accion").data('idcliente'));
    formData.append("idLote", $("#idLote").val());
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
                    $("#tabla_inventario_contraloria").DataTable().ajax.reload(null, false);
                    document.getElementById("form_rl").reset();
                }
                if(response.reload === true){
                    //location.reload();
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

/*function hideOption(selectId, optionValue) {
    optionValue.forEach(function(value) {
        $(`#${selectId} option[value='${value}']`).hide();
    });
    $(`#${selectId}`).selectpicker('refresh');
}*/
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
    $("#representante").closest('.row').hide();
    $("#tipoVenta").closest('.row').hide();
    $("#sedes").closest('.row').hide();
    $("#nombre_rep").closest('.row').hide();
    $("#repEstatus").closest('.row').hide();
    $("#repData").closest('.row').hide();

    $("#opciones").empty().selectpicker('refresh');
    $("#representante").empty().selectpicker('refresh');
    $("#tipoVenta").empty().selectpicker('refresh');
    $("#repData").empty().selectpicker('refresh');
    $("#sedes").empty().selectpicker('refresh');
    //$("#repEstatus").empty().selectpicker('refresh');

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
        }
        $("#opciones").selectpicker('refresh');
        $("#representante").selectpicker('refresh');
        $("#tipoVenta").selectpicker('refresh');
        $("#repData").selectpicker('refresh');
    }, 'json'); 
    $.post(`${general_base_url}Administracion/getSedes`, function(data) {
        for (let i = 0; i < data.length; i++) {
            let option = $('<option>').val(data[i]['id_sede']).text(data[i]['nombre']).attr('impuesto',`${data[i]['impuesto']}`);
            $("#sedes").append(option);
        }
        $("#sedes").selectpicker('refresh');
    }, 'json');
}

$(document).on('hidden.bs.modal', "#seeInformationModal", function(){
    console.log("hide modal");
    $("#representante, #tipoVenta, #sedes, #nombre_rep, #repData").closest('.row').hide();
    $("#opciones option").css('display', 'block');
    $("#opciones, #tipoVenta, #representante, #sedes, #impuesto, #repEstatus, #repData").val('').selectpicker('refresh');
});