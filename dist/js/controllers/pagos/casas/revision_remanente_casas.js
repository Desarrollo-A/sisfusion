var trs;
var tabla_remanente_casas ;
var totaPago_casas = 0;
let titulos_remanente_casas = [];

$(document).ready(function() {
    $("#tabla_remanente_casas").prop("hidden", true);
    $.post(general_base_url+"Contratacion/lista_proyecto", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#proyectoRemanente_casas").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#proyectoRemanente_casas").selectpicker('refresh');
    }, 'json');
});

$('#proyectoRemanente_casas').change(function(){
    $("#autorizarRemanente_casas").html(formatMoney(0));
    $("#all_casas").prop("checked", false);
residencial = $('#proyectoRemanente_casas').val();
$("#condominioRemanente_casas").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url+'Pagos/getCondominioDesc/'+residencial,
        type: 'post',
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++)
            {
                var id = response[i]['idCondominio'];
                var name = response[i]['nombre'];
                $("#condominioRemanente_casas").append($('<option>').val(id).text(name));
            }
            $("#condominioRemanente_casas").selectpicker('refresh');
        }
    });
});

$('#proyectoRemanente_casas').change(function(){
    $("#autorizarRemanente_casas").html(formatMoney(0));
    $("#all_casas").prop("checked", false);
    proyecto = $('#proyectoRemanente_casas').val();
    condominio = $('#condominioRemanente_casas').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getDataRemanente_casas(proyecto, condominio);
});

$('#condominioRemanente_casas').change(function(){
    $("#autorizarRemanente_casas").html(formatMoney(0));
    $("#all_casas").prop("checked", false);
    proyecto = $('#proyectoRemanente_casas').val();
    condominio = $('#condominioRemanente_casas').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getDataRemanente_casas(proyecto, condominio);
});

$('#tabla_remanente_casas thead tr:eq(0) th').each(function (i) {
    if(i != 0){
        var title = $(this).text();
        titulos_remanente_casas.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_remanente_casas').DataTable().column(i).search() !== this.value ) {
                $('#tabla_remanente_casas').DataTable().column(i).search(this.value).draw();
            }
        });
    }else {
        $(this).html('<input id="all_casas" type="checkbox" style="width:20px; height:20px;" onchange="select_all_remanente_casas(this)"/>');
    }
});
// function obtenerModoSeleccionado() {
//     var radioButtons = document.getElementsByName("modoSubida");
//     var modoSeleccionado = "";

//     for (var i = 0; i < radioButtons.length; i++) {
//         if (radioButtons[i].checked) {
//             modoSeleccionado = radioButtons[i].value;
//             break;
//         }
//     }

//     return modoSeleccionado;
// }

function getDataRemanente_casas(proyecto, condominio){
    
    $('#tabla_remanente_casas').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(numberTwoDecimal(total));
        document.getElementById("disponibleRemanente_casas").textContent = to;
    });

    var modoSubidaSeleccionado = obtenerModoSeleccionado();
    // console.log("prueba");
    // console.log('Valor seleccionado: ' + modoSubidaSeleccionado);

    $("#tabla_remanente_casas").prop("hidden", false);
    tabla_remanente_casas = $("#tabla_remanente_casas").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title:'Comisiones Remanente - Revisión Contraloría',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos_remanente_casas[columnIdx -1] + ' ';
                        }
                    }
                },
            },
            {
            text: '<i class="fa fa-check"></i> ENVIAR A INTERNOMEX',
            action: function() {
                if ($('input[name="idPagoRemanente_casas[]"]:checked').length > 0) {
                    $('#spiner-loader').removeClass('hide');
                    var idcomision = $(tabla_remanente_casas.$('input[name="idPagoRemanente_casas[]"]:checked')).map(function() {
                        return this.value;
                    }).get();
                    var com2 = new FormData();
                    com2.append("idcomision", idcomision); 
                    $.ajax({
                        url : general_base_url + 'Pagos_casas/updateRevisionaInternomex/',
                        data: com2,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST', 
                        success: function(data){
                            response = JSON.parse(data);
                            if(data == 1) {
                                $('#spiner-loader').addClass('hide');
                                $("#autorizarRemanente_casas").html(formatMoney(0));
                                $("#all_casas").prop("checked", false);
                                var fecha = new Date();
                                tabla_remanente_casas.ajax.reload();
                                var mensaje = "Comisiones de esquema <b>remanentes</b>, fueron enviadas a <b>INTERNOMEX</b> correctamente.";
                                modalInformation(RESPUESTA_MODAL.SUCCESS, mensaje);
                            }
                            else {
                                $('#spiner-loader').addClass('hide');
                                modalInformation(RESPUESTA_MODAL.FAIL);
                            }
                        },
                        error: function( data ){
                            $('#spiner-loader').addClass('hide');
                            modalInformation(RESPUESTA_MODAL.FAIL);
                        }
                    });
                }else{
                    alerts.showNotification("top", "right", "Favor de seleccionar una comisión.", "warning");
                }
            },
            attr: {
                class: 'btn btn-azure',
                style: 'position: relative;',
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url+"/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
        },
        {
            data: function( d ){
                return '<p class="m-0">'+d.id_pago_i+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0">'+d.proyecto+'</p>';
            }
        },{
            data: function( d ){
                return '<p class="m-0">'+d.condominio+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0"><b>'+d.lote+'</b></p>';
            }
        },
        
        {
            data: function( d ){
                return '<p class="m-0">'+d.referencia+'</p>';
            }
        },
        {
            data: function(d){
                if( d.precio_lote == "" || d.precio_lote == null)
                    return '<p class="m-0">$0.00</p>'
                else
                    return '<p class="m-0">'+formatMoney(numberTwoDecimal(d.precio_lote))+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0"><b>'+d.empresa+'</b></p>';
            }
        },
        {
            data: function( d ){
                if( d.comision_total == "" || d.comision_total == null)
                    return '<p class="m-0">$0.00</p>'
                else
                    return '<p class="m-0">'+formatMoney(numberTwoDecimal(d.comision_total))+'</p>';
            }
        },
        {
            data: function( d ){
                if( d.pago_cliente == "" || d.pago_cliente == null)
                    return '<p class="m-0">$0.00</p>'
                else
                    return '<p class="m-0">'+formatMoney(numberTwoDecimal(d.pago_cliente))+'</p>';
            }
        },
        {
            data: function( d ){
                if( d.solicitado == "" || d.solicitado == null)
                    return '<p class="m-0">$0.00</p>'
                else
                    return '<p class="m-0"><b>'+formatMoney(numberTwoDecimal(d.solicitado))+'</b></p>';
            }
        },
        {
            data: function( d ){
                if( d.valimpuesto == "" || d.valimpuesto == null)
                    return '<p class="m-0">-</p>'
                else
                    return '<p class="m-0"><b>'+d.valimpuesto+'%</b></p>';
            }
        },
        {
            data: function( d ){
                if( d.dcto == "" || d.dcto == null)
                    return '<p class="m-0">$0.00</p>'
                else
                    return '<p class="m-0"><b>'+formatMoney(numberTwoDecimal(d.dcto))+'</b></p>';
            }
        },
        {
            data: function( d ){
                if( d.impuesto == "" || d.impuesto == null)
                    return '<p class="m-0">$0.00</p>'
                else
                    return '<p class="m-0"><b>'+formatMoney(numberTwoDecimal(d.impuesto))+'</b></p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0">'+d.tipo_venta+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0">'+d.plan_descripcion+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0">'+d.porcentaje_decimal+'%</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0">'+d.fecha_apartado+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0">'+d.sede_nombre+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0"><b>'+d.usuario+'</b></p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0">'+d.estatus_usuario+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0">'+d.puesto+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0"><b>'+d.codigo_postal+'</b></p>';
            }
        },
        {
            data: function( d ){
                var BtnStats1;
                BtnStats1 =  '<p class="m-0">'+d.fecha_creacion+'</p>';
                return BtnStats1;
            }
        },
        {
            "orderable": false,
            data: function( data ){
                
                let btns = '';
                
                const BTN_DETASI = `<button href="#" value="${data.id_pago_i}" data-value='"${data.lote}"' data-code="${data.cbbtton}" class="btn-data btn-blueMaderas consultar_logs_remanente" title="Detalles"><i class="fas fa-info"></i></button>`;
                const BTN_PAUASI = `<button href="#" value="${data.id_pago_i}" data-value="${data.id_pago_i}" data-code="${data.cbbtton}" class="btn-data btn-orangeYellow cambiar_estatus_casas" title="Pausar solicitud"> <i class="fas fa-pause"></i></button>`;
                const BTN_ACTASI = `<button href="#" value="${data.id_pago_i}" data-value="${data.id_pago_i}" data-code="${data.cbbtton}" class="btn-data btn-green regresar_estatus" title="Activar solicitud"><i class="fas fa-play"></i></button>`

                if(data.estatus == 4){
                    btns += BTN_DETASI;
                    btns += BTN_PAUASI;

                }
                else{
                    btns += BTN_DETASI;
                    btns += BTN_ACTASI;
                }
                $('#spiner-loader').addClass('hide');
                return `<div class="d-flex justify-center">${btns}</div>`;
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            searchable:false,
            className: 'dt-body-center',
            render: function (d, type, full, meta){
                if(full.estatus == 4){
                    if(full.id_comision){
                            // return '<input type="checkbox" name="idPagoRemanente_casas[]" class="checkPagosIndividual_casas" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                            return '<input type="checkbox" name="idPagoRemanente_casas[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';

                    }else{
                        return '';
                    }
                }else{
                    return '';
                }
            },
        }],
        ajax: {
            url: general_base_url + "Pagos_casas/getDatosNuevasRemanenteCasas/",
            type: "POST",
            cache: false,
            data :{
                proyecto : proyecto,
                condominio : condominio
            }
        },
    });

    $('#tabla_remanente_casas').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $("#tabla_remanente_casas tbody").on("click", ".consultar_logs_remanente", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        $('#comments-list-remanente').html('');
        $('#nameLote').html('');
        id_pago = $(this).val();
        lote = $(this).attr("data-value");

        changeSizeModal('modal-md');
        appendBodyModal(`<div class="modal-body">
                        <div role="tabpanel">
                            <div id="nameLote"></div>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="changelogTab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                                    <ul class="timeline-3" id="comments-list-remanente"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"><b>Cerrar</b></button>
                    </div>`);
        showModal();

        $("#nameLote").append('<p><h5>HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $('#spiner-loader').removeClass('hide');
        $.getJSON(general_base_url+"Pagos_casas/getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-remanente").append('<li>\n' +
                '  <div class="container-fluid">\n' +
                '    <div class="row">\n' +
                '      <div class="col-md-6">\n' +
                '        <a><b> ' +v.comentario.toUpperCase()+ '</b></a><br>\n' +
                '      </div>\n' +
                '      <div class="float-end text-right">\n' +
                '        <a>' + v.fecha_movimiento.split(".")[0] + '</a>\n' +
                '      </div>\n' +
                '      <div class="col-md-12">\n' +
                '        <p class="m-0"><small>Usuario: </small><b> ' + v.nombre_usuario + '</b></p>\n'+
                '      </div>\n' +
                '    <h6>\n' +
                '    </h6>\n' +
                '    </div>\n' +
                '  </div>\n' +
                '</li>');
            });
        $('#spiner-loader').addClass('hide');
        });
    });
    
    $('#tabla_remanente_casas').on("click", 'input', function() {
        totaPago_casas = 0;
        tabla_remanente_casas.$('input[type="checkbox"]').each(function () {
            let totalChecados = tabla_remanente_casas.$('input[type="checkbox"]:checked') ;
            let totalCheckbox = tabla_remanente_casas.$('input[type="checkbox"]');
            if(this.checked){
                trs = this.closest('tr');
                row = tabla_remanente_casas.row(trs).data();
                totaPago_casas += parseFloat(row.impuesto); 
            }
            if( totalChecados.length == totalCheckbox.length ){
                $("#all_casas").prop("checked", true);
            }else {
                $("#all_casas").prop("checked", false);
            }
        });
        $("#autorizarRemanente_casas").html(formatMoney(numberTwoDecimal(totaPago_casas)));
    });

    $("#tabla_remanente_casas tbody").on("click", ".cambiar_estatus_casas", function(){
        var tr1 = $(this).closest('tr');
        var row = tabla_remanente_casas.row( tr1 );
        id_pago_i = $(this).val(); 
        
        $("#modal_remanente_casas .modal-body").html("");
        $("#modal_remanente_casas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de pausar la comisión de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p></div></div>');
        $("#modal_remanente_casas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="1"><input type="hidden" name="estatus" value="6"><input type="text" class="text-modal observaciones" name="observaciones" rows="3" required placeholder="Describe mótivo por el cual se va activar nuevamente la solicitud"></input></div></div>');
        $("#modal_remanente_casas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">');
        $("#modal_remanente_casas .modal-body").append(`<div class="row"><div class="col-md-6"></div><div class="d-flex justify-end"><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button><button type="submit" class="btn btn-primary" value="PAUSAR">PAUSAR</button></div></div>`);
        $("#modal_remanente_casas").modal('show');
    });

    $("#tabla_remanente_casas tbody").on("click", ".regresar_estatus", function(){
        var tr1 = $(this).closest('tr');
        var row = tabla_remanente_casas.row( tr1 );
        id_pago_i = $(this).val();

        $("#modal_remanente_casas .modal-body").html("");
        $("#modal_remanente_casas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de activar la comisión de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p></div></div>');
        $("#modal_remanente_casas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="2"><input type="hidden" name="estatus" value="4"><input type="text" class="text-modal observaciones"  rows="3" name="observaciones" required placeholder="Describe mótivo por el cual se va activar nuevamente la solicitud"></input></div></div>');
        $("#modal_remanente_casas .modal-body").append(`<div class="d-flex justify-end"><input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'"><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button><button type="submit" class="btn btn-primary" value="ACTIVAR">ACTIVAR</button></div>`);        
        $("#modal_remanente_casas").modal();
    });
}

$("#form_pausar_casas").submit( function(e) {
    e.preventDefault();
    $('#spiner-loader').removeClass('hide');
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        data.append("id_pago_i", id_pago_i);
        
        $.ajax({
            url: general_base_url + "Pagos_casas/despausar_solicitud",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST',
            success: function(data){
                if( data[0] ){
                    $("#modal_remanente_casas").modal('toggle' );
                    $("#all_casas").prop("checked", false);
                    alerts.showNotification("top", "right", "Se aplicó el cambio exitosamente", "success");
                    setTimeout(function() {
                        tabla_remanente_casas.ajax.reload(null, false);
                        $('#spiner-loader').addClass('hide');

                    }, 3000);
                }else{
                    $('#spiner-loader').addClass('hide');

                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                }
            },error: function( ){
                $('#spiner-loader').addClass('hide');

                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});

function select_all_remanente_casas(e) {
    tota2 = 0;
    if(e.checked == true){
        $(tabla_remanente_casas.$('input[type="checkbox"]')).each(function (i, v) {
            trs = this.closest('tr');
            row = tabla_remanente_casas.row(trs).data();
            tota2 += parseFloat(row.impuesto);
            if(v.checked == false){
                $(v).prop("checked", true);
            }
        }); 
        $("#autorizarRemanente_casas").html(formatMoney(numberTwoDecimal(tota2)));
    }
    if(e.checked == false){
        $(tabla_remanente_casas.$('input[type="checkbox"]')).each(function (i, v) {
            if(v.checked == true){
                $(v).prop("checked", false);
            }
        }); 
        $("#autorizarRemanente_casas").html(formatMoney(0));
    }
}
