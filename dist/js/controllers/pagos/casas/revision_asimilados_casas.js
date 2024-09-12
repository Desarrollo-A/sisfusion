var tr1;
var tabla_asimilados_casas_2 ;
var totaPago_asimilados_casas = 0;
let titulos_casas = [];

$(document).ready(function() {
    $("#tabla_asimilados_casas").prop("hidden", true);
    $.post(general_base_url+"Contratacion/lista_proyecto", function (datos) {
        var len = datos.length;
        for (var i = 0; i < len; i++) {
            var id = datos[i]['idResidencial'];
            var name = datos[i]['descripcion'];
            $("#proyectoAsimilados_casas").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#proyectoAsimilados_casas").selectpicker('refresh');
    }, 'json');
});

$('#proyectoAsimilados_casas').change(function(){
    $("#autorizarAsimilados_casas").html(formatMoney(0));
    $("#all_asimilado_casas").prop('checked', false);

residencial = $('#proyectoAsimilados_casas').val();
$("#condominioAsimilados_casas").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url+'Pagos_casas/getCondominioDesc/'+residencial,
        type: 'post',
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++)
            {
                var id = response[i]['idCondominio'];
                var name = response[i]['nombre'];
                $("#condominioAsimilados_casas").append($('<option>').val(id).text(name));
            }
            $("#condominioAsimilados_casas").selectpicker('refresh');
        }
    });
});

$('#proyectoAsimilados_casas').change(function(){
    $("#autorizarAsimilados_casas").html(formatMoney(0));
    $("#all_asimilado_casas").prop('checked', false);

    // alert(4555545554);
    proyecto = $('#proyectoAsimilados_casas').val();
    condominio = $('#condominioAsimilados_casas').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getDataAsimiladosCasas(proyecto, condominio);
});

$('#condominioAsimilados_casas').change(function(){
    $("#autorizarAsimilados_casas").html(formatMoney(0));
    $("#all_asimilado_casas").prop('checked', false);
    proyecto = $('#proyectoAsimilados_casas').val();
    condominio = $('#condominioAsimilados_casas').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getDataAsimiladosCasas(proyecto, condominio);
});

$('#tabla_asimilados_casas thead tr:eq(0) th').each(function (i) {
    if(i != 0){
        var title = $(this).text();
        titulos_casas.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_asimilados_casas').DataTable().column(i).search() !== this.value ) {
                $('#tabla_asimilados_casas').DataTable().column(i).search(this.value).draw();
            }
        });
    }else {
        $(this).html('<input id="all_asimilado_casas" type="checkbox" style="width:20px; height:20px;" onchange="selectAllSeguros(this)"/>');
    }
});

function obtenerModoSeleccionado() {
    var radioButtons = document.getElementsByName("modoSubida");
    var modoSeleccionado = "";

    for (var i = 0; i < radioButtons.length; i++) {
        if (radioButtons[i].checked) {
            modoSeleccionado = radioButtons[i].value;
            break;
        }
    }

    return modoSeleccionado;
}

function getDataAsimiladosCasas(proyecto, condominio){
    
    $('#tabla_asimilados_casas').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(numberTwoDecimal(total));
        document.getElementById("disponibleAsimilados_casas").textContent = to;
    });
    

    $("#tabla_asimilados_casas").prop("hidden", false);
    tabla_asimilados_casas_2 = $("#tabla_asimilados_casas").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title:'Comisiones Asimilados - Revisión Contraloría',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos_casas[columnIdx -1] + ' ';
                        }
                    }
                },
            },
            {
            text: '<i class="fa fa-check"></i> ENVIAR A INTERNOMEX',
            action: function() {
                if ($('input[name="idPagoAsimilados[]"]:checked').length > 0) {
                    $('#spiner-loader').removeClass('hide');
                    var idcomision = $(tabla_asimilados_casas_2.$('input[name="idPagoAsimilados[]"]:checked')).map(function() {
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
                                $("#autorizarAsimilados_casas").html(formatMoney(0));
                                $("#all_asimilado_casas").prop('checked', false);
                                var fecha = new Date();
                                tabla_asimilados_casas_2.ajax.reload();
                                var mensaje = "Comisiones de esquema <b>asimilados</b>, fueron enviadas a <b>INTERNOMEX</b> correctamente.";
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
                
                const BTN_DETASI = `<button href="#" value="${data.id_pago_i}" data-value='"${data.lote}"' data-code="${data.cbbtton}" class="btn-data btn-blueMaderas consultar_logs_asimilados" title="Detalles"><i class="fas fa-info"></i></button>`;
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
                            return '<input type="checkbox" name="idPagoAsimilados[]" class="checkPagos" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                    }else{
                        return '';
                    }
                }else{
                    return '';
                }
            },
        }],
        ajax: {
            url: general_base_url + "Pagos_casas/getDatosNuevasAsimiladosCasas" ,
            type: "POST",
            cache: false,
            data :{
                proyecto : proyecto,
                condominio : condominio
            }
        },
    });

    $('#tabla_asimilados_casas').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });

    $("#tabla_asimilados_casas tbody").on("click", ".consultar_logs_asimilados", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        $('#comments-list-asimilados').html('');
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
                                        <ul class="timeline-3" id="comments-list-asimilados"></ul>
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
                $("#comments-list-asimilados").append('<li>\n' +
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

    $('#tabla_asimilados_casas').on("click", 'input', function() {
        totaPago_asimilados_casas = 0;
        tabla_asimilados_casas_2.$('input[type="checkbox"]').each(function () {
            let totalChecados = tabla_asimilados_casas_2.$('input[type="checkbox"]:checked') ;
            let totalCheckbox = tabla_asimilados_casas_2.$('input[type="checkbox"]');
            if(this.checked){
                trs = this.closest('tr');
                row = tabla_asimilados_casas_2.row(trs).data();
                totaPago_asimilados_casas += parseFloat(row.impuesto); 
            }
            if( totalChecados.length == totalCheckbox.length ){
                $("#all_asimilado_casas").prop("checked", true);
            }else {
                $("#all_asimilado_casas").prop("checked", false);
            }
        });
        $("#autorizarAsimilados_casas").html(formatMoney(numberTwoDecimal(totaPago_asimilados_casas)));
    });

    $("#tabla_asimilados_casas tbody").on("click", ".cambiar_estatus_casas", function(){
        var tr1 = $(this).closest('tr');
        var row = tabla_asimilados_casas_2.row( tr1 );
        id_pago_i = $(this).val(); 
        
        $("#modal_asimilados_casas .modal-body").html("");
        $("#modal_asimilados_casas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de pausar la comisión de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p></div></div>');
        $("#modal_asimilados_casas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="1"><input type="hidden" name="estatus" value="6"><input type="text" class="text-modal observaciones" name="observaciones" rows="3" required placeholder="Describe mótivo por el cual se va activar nuevamente la solicitud"></input></div></div>');
        $("#modal_asimilados_casas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">');
        $("#modal_asimilados_casas .modal-body").append(`<div class="row"><div class="col-md-6"></div><div class="d-flex justify-end"><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button><button type="submit" class="btn btn-primary" value="PAUSAR">PAUSAR</button></div></div>`);
        $("#modal_asimilados_casas").modal('show');
    });

    $("#tabla_asimilados_casas tbody").on("click", ".regresar_estatus", function(){
        var tr1 = $(this).closest('tr');
        var row = tabla_asimilados_casas_2.row( tr1 );
        id_pago_i = $(this).val();

        $("#modal_asimilados_casas .modal-body").html("");
        $("#modal_asimilados_casas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de activar la comisión de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p></div></div>');
        $("#modal_asimilados_casas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="2"><input type="hidden" name="estatus" value="4"><input type="text" class="text-modal observaciones"  rows="3" name="observaciones" required placeholder="Describe mótivo por el cual se va activar nuevamente la solicitud"></input></div></div>');
        $("#modal_asimilados_casas .modal-body").append(`<div class="d-flex justify-end"><input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'"><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button><button type="submit" class="btn btn-primary" value="ACTIVAR">ACTIVAR</button></div>`);        
        $("#modal_asimilados_casas").modal();
    });

}

$("#form_interes_casas").submit( function(e) {
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
                    $("#modal_asimilados_casas").modal('toggle' );

                    alerts.showNotification("top", "right", "Se aplicó el cambio exitosamente", "success");
                    setTimeout(function() {
                        tabla_asimilados_casas_2.ajax.reload(null, false);
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


// $("#formPausarAsimiladosCasas").submit( function(e) {
//     e.preventDefault();
//     $('#spiner-loader').removeClass('hide');

// }).validate({

//     submitHandler: function( form ) {
//         var data = new FormData( $(form)[0] );
//         data.append("id_pago_i", id_pago_i);
//         $.ajax({
//             url: general_base_url + "Pagos_casas/pausar_solicitudM/",
//             data: data,
//             cache: false,
//             contentType: false,
//             processData: false,
//             dataType: 'json',
//             method: 'POST',
//             type: 'POST',
//             success: function(data){
//                 if( data[0] ){
//                     $("#modalPausarAsimiladosCasas").modal('toggle' );
//                     alerts.showNotification("top", "right", "Se ha pausado la comisión exitosamente", "success");
//                     setTimeout(function() {
//                         tabla_asimilados_casas_2.ajax.reload();
//                         $('#spiner-loader').addClass('hide');

//                     }, 3000);
//                 }else{
//                     alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
//                     $('#spiner-loader').addClass('hide');

//                 }
//             },error: function( ){
//                 $('#spiner-loader').addClass('hide');

//                 alert("ERROR EN EL SISTEMA");
//             }
//         });
//     }
// });
    
function selectAllSeguros(e) {
    totaPago_asimilados_casas = 0;
    if(e.checked == true){
        $(tabla_asimilados_casas_2.$('input[type="checkbox"]')).each(function (i, v) {
            tr1 = this.closest('tr');
            row = tabla_asimilados_casas_2.row(tr1).data();
            totaPago_asimilados_casas += parseFloat(row.impuesto);
            if(v.checked == false){
                $(v).prop("checked", true);
            }
        }); 
        $("#autorizarAsimilados_casas").html(formatMoney(numberTwoDecimal(totaPago_asimilados_casas)));
    }
    if(e.checked == false){
        $(tabla_asimilados_casas_2.$('input[type="checkbox"]')).each(function (i, v) {
            if(v.checked == true){
                $(v).prop("checked", false);
            }
        }); 
        $("#autorizarAsimilados_casas").html(formatMoney(0));
    }
}
