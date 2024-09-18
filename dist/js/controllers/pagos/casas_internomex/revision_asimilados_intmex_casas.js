var tr1;
var tabla_asimilados2_intmex_casas ;
var totaPen_casas = 0;
let titulos_intmex_casas = [];

$(document).ready(function() {
    $("#tabla_asimilados_intmex_casas").prop("hidden", true);
    $.post(general_base_url+"/Pagos/lista_roles", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#puestoAsimilados_intmex_casas").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#puestoAsimilados_intmex_casas").selectpicker('refresh');
    }, 'json');
});

$('#puestoAsimilados_intmex_casas').change(function(ruta){
    $("#all_asimilados_intmex").prop("checked", false);
    $("#totpagarPen_intmex_casas").html(formatMoney(numberTwoDecimal(0)));
    $(".individualCheck_casas").prop("checked", false);
    rol = $('#puestoAsimilados_intmex_casas').val();
    $("#usuarioAsimilados_intmex_casas").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url +'Pagos_casas/lista_usuarios',
        type: 'post',
        data:  { 
            "rol":    rol, 
            "forma_pago" : 3 
                },
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++){
                var id = response[i]['idCondominio'];
                var name = response[i]['nombre'];
                $("#usuarioAsimilados_intmex_casas").append($('<option>').val(id).text(name));
            }
            if(len<=0){
                $("#usuarioAsimilados_intmex_casas").append('<option selected="selected" disabled>NO HAY OPCIONES</option>');
            }
            $("#usuarioAsimilados_intmex_casas").selectpicker('refresh');
        }
    });
    valuar = $('#usuarioAsimilados_intmex_casas').val();
    proyecto = $('#puestoAsimilados_intmex_casas').val();

    valuar == '' && tabla_asimilados2_intmex_casas == undefined ? '' : getAssimilatedCommissions_asimilados_casas(proyecto, 0);

});

$('#usuarioAsimilados_intmex_casas').change(function(ruta){
    $("#all_asimilados_intmex").prop("checked", false);
    $("#totpagarPen_intmex_casas").html(formatMoney(numberTwoDecimal(0)));
    proyecto = $('#puestoAsimilados_intmex_casas').val();
    condominio = $('#usuarioAsimilados_intmex_casas').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getAssimilatedCommissions_asimilados_casas(proyecto, condominio);
});


$('#tabla_asimilados_intmex_casas thead tr:eq(0) th').each( function (i) {
    if(i != 0){
        var title = $(this).text();
        titulos_intmex_casas.push(title);
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
        $('input', this).on('keyup change', function() {
            if (tabla_asimilados2_intmex_casas.column(i).search() !== this.value) {
                tabla_asimilados2_intmex_casas.column(i).search(this.value).draw();
                var total = 0;
                var index = tabla_asimilados2_intmex_casas.rows({ selected: true, search: 'applied' }).indexes();
                var data = tabla_asimilados2_intmex_casas.rows(index).data();
                $.each(data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                var to1 = formatMoney(total);
                document.getElementById("totpagarPen_intmex_casas").textContent = formatMoney(numberTwoDecimal(total));
            }
        });
        } 
    else {
        $(this).html('<input id="all_asimilados_intmex" type="checkbox" style="width:20px; height:20px;" onchange="selectAllIntmexCasas(this)"/>');
    }
});

function getAssimilatedCommissions_asimilados_casas(proyecto, condominio){
    $('#tabla_asimilados_intmex_casas').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(numberTwoDecimal((total)));
        document.getElementById("totpagarAsimilados_intmex_casas").textContent = to;
    });
    
    $("#tabla_asimilados_intmex_casas").prop("hidden", false);
    tabla_asimilados2_intmex_casas = $("#tabla_asimilados_intmex_casas").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [{
            text: '<div class="d-flex"><i class="fa fa-check "></i><p class="m-0 pl-1">Marcar como pagado</p></div>',
            action: function() {
                if ($('input[name="idTQ[]"]:checked').length > 0) {
                    $('#spiner-loader').removeClass('hide');
                    var idcomision = $(tabla_asimilados2_intmex_casas.$('input[name="idTQ[]"]:checked')).map(function() {
                        return this.value;
                    }).get();
                    
                    var com2 = new FormData();
                    com2.append("idcomision", idcomision); 
                    $.ajax({
                        url : general_base_url + 'Pagos_casas/pago_internomex/',
                        data: com2,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST', 
                        success: function(data){
                            response = JSON.parse(data);
                            if(data == 1) {
                                $('#spiner-loader').addClass('hide');
                                $("#totpagarPen_intmex_casas").html(formatMoney(0));
                                $("#all_asimilados_intmex").prop('checked', false);
                                var fecha = new Date();
                                tabla_asimilados2_intmex_casas.ajax.reload();
                                var mensaje = "Comisiones de esquema<b>asimilados</b>, fueron marcadas como <b>PAGADAS</b> correctamente.";
                                modalInformation(data, mensaje);
                            } else {
                                $('#spiner-loader').addClass('hide');
                                modalInformation(2);
                                }
                        },
                        error: function( data ){
                            $('#spiner-loader').addClass('hide');
                            modalInformation(2);
                        }
                    });
                }else{
                    alerts.showNotification("top", "right", "Favor de seleccionar una comisión activa .", "warning");
                }
            },
            attr: {
                class: 'btn btn-azure',
                style: 'position: relative;',
            }
        },
        {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title_casas:'Comisiones Asimilados - Revisión INTERNOMEX',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19],
                format: {
                    header: function (columnIdx, i) {
                        return titulos_intmex_casas[i-1];
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
        },
        {
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
            data: function( d ){
                return '<p class="m-0">'+formatMoney(d.precio_lote)+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0"><b>'+d.empresa+'</p>';
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
                    return '<p class="m-0">COMISIÓN <br><b> ('+d.porcentaje_decimal+'% del 8% DEL COSTO TOTAL)</b></p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0"><b>'+d.usuario+'</b></i></p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0"><b>'+d.rfc+'</b></i></p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0"><i> '+d.puesto+'</i></p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0"><i> '+d.codigo_postal+'</i></p>';
            }
        },
        {
            data: function( d ){
                var BtnStats1;
                if(d.estatus == 8){
                    BtnStats1 =  '<p class="m-0">'+d.fecha_creacion+'</p>';
                }
                else{
                    BtnStats1 =  '<p style="color:red;"><B>PAUSADA</B></p>';
                }
                return BtnStats1;
            }
        },
        {
            
            "orderable": false,
            data: function( data ){
                $('#spiner-loader').removeClass('hide');
                let btns = '';
                
                const BTN_DETASI = `<button href="#" value="${data.id_pago_i}" data-value='"${data.lote}"' data-code="${data.cbbtton}" class="btn-data btn-blueMaderas consultar_logs_asimilados" title="Detalles"><i class="fas fa-info"></i></button>`;
                const BTN_PAUASI = `<button href="#" value="${data.id_pago_i}" data-value="${data.id_pago_i}" data-code="${data.cbbtton}" class="btn-data btn-orangeYellow cambiar_estatus_casas" title="Pausar solicitud"> <i class="fas fa-pause"></i></button>`;
                const BTN_ACTASI = `<button href="#" value="${data.id_pago_i}" data-value="${data.id_pago_i}" data-code="${data.cbbtton}" class="btn-data btn-green regresar_estatus" title="Activar solicitud"><i class="fas fa-play"></i></button>`

                if(data.estatus == 8){
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
            targets: 0,
            searchable:false,
            className: 'dt-body-center',
            render: function (d, type, full, meta){
                if(full.estatus == 8){
                    if(full.id_comision){
                        return `<input type="checkbox" name="idTQ[]" class="individualCheck_casas" style="width:20px;height:20px;"  value=" ${full.id_pago_i} ">`;
                    }else{
                        return '';
                    }
                }
                else{
                    return '';
                }
            },
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            url: general_base_url + "Pagos_casas/getDatosNuevasAsimiladosCasas/",
            type: "POST",
            cache: false,
            data: {
                puesto:  proyecto,
                usuario: condominio
            }
        },
        
    });

    $("#tabla_asimilados_intmex_casas tbody").on("click", ".consultar_logs_asimilados", function(e){
        $('#spiner-loader').removeClass('hide');
        $("#comments-list-asimilados").html('');
        $("#nameLote").html('');
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        changeSizeModal('modal-md');
        appendBodyModal(`<div class="modal-body">
                <div role="tabpanel">
                    <ul >
                        <div id="nameLote"></div>
                    </ul>
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

        $("#nameLote").append('<p><h5">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON(general_base_url+"Pagos_casas/getComments/"+id_pago  ).done( function( data ){
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

    $("#tabla_asimilados_intmex_casas tbody").on("click", ".cambiar_estatus_casas", function(){
        var tr1 = $(this).closest('tr');
        var row = tabla_asimilados2_intmex_casas.row( tr1 );
        id_pago_i = $(this).val(); 
        
        $("#modal_nuevas_casas .modal-body").html("");
        $("#modal_nuevas_casas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de pausar la comisión de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p></div></div>');
        $("#modal_nuevas_casas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="1"><input type="hidden" name="estatus" value="88"><input type="text" class="text-modal observaciones" name="observaciones" rows="3" required placeholder="Describe mótivo por el cual se va activar nuevamente la solicitud"></input></div></div>');
        $("#modal_nuevas_casas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">');
        $("#modal_nuevas_casas .modal-body").append(`<div class="row"><div class="col-md-6"></div><div class="d-flex justify-end"><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button><button type="submit" class="btn btn-primary" value="PAUSAR">PAUSAR</button></div></div>`);
        $("#modal_nuevas_casas").modal('show');
    });

    $("#tabla_asimilados_intmex_casas tbody").on("click", ".regresar_estatus", function(){
        var tr1 = $(this).closest('tr');
        var row = tabla_asimilados2_intmex_casas.row( tr1 );
        id_pago_i = $(this).val();

        $("#modal_nuevas_casas .modal-body").html("");
        $("#modal_nuevas_casas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de activar la comisión de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p></div></div>');
        $("#modal_nuevas_casas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="2"><input type="hidden" name="estatus" value="8"><input type="text" class="text-modal observaciones"  rows="3" name="observaciones" required placeholder="Describe mótivo por el cual se va activar nuevamente la solicitud"></input></div></div>');
        $("#modal_nuevas_casas .modal-body").append(`<div class="d-flex justify-end"><input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'"><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button><button type="submit" class="btn btn-primary" value="ACTIVAR">ACTIVAR</button></div>`);        
        $("#modal_nuevas_casas").modal();
    });

    $('#tabla_asimilados_intmex_casas').on("click", 'input', function() {
        totaPen_casas = 0;
        tabla_asimilados2_intmex_casas.$('input[type="checkbox"]').each(function () {
            let totalChecados = tabla_asimilados2_intmex_casas.$('input[type="checkbox"]:checked') ;
            let totalCheckbox = tabla_asimilados2_intmex_casas.$('input[type="checkbox"]');
            if(this.checked){
                trs = this.closest('tr');
                row = tabla_asimilados2_intmex_casas.row(trs).data();
                totaPen_casas += parseFloat(row.impuesto); 
            }
            if( totalChecados.length == totalCheckbox.length ){
                $("#all_asimilados_intmex").prop("checked", true);
            }else {
                $("#all_asimilados_intmex").prop("checked", false);
            }
        });
        $("#totpagarPen_intmex_casas").html(formatMoney(numberTwoDecimal(totaPen_casas)));
    });
}

$(window).resize(function(){
    tabla_asimilados2_intmex_casas.columns.adjust();
});

function cancela(){
    $("#modal_nuevas_casas").modal('toggle');
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
                    $("#modal_nuevas_casas").modal('toggle' );

                    alerts.showNotification("top", "right", "Se aplicó el cambio exitosamente", "success");
                    setTimeout(function() {
                        tabla_asimilados2_intmex_casas.ajax.reload();
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

function CloseModalDelete2Intmex_casas(){
    document.getElementById("form_multiples_casas").reset();
    a = document.getElementById('borrarProyect');
    padre = a.parentNode;
    padre.removeChild(a);
    $("#modal_multiples_intmexA_casas").modal('toggle');  
}

$(document).on("click", ".PagarCasas", function() {
    $("#modal_multiples_intmexA_casas .modal-body").html("");
    $("#modal_multiples_intmexA_casas .modal-header").html("");
    $("#modal_multiples_intmexA_casas .modal-header").append(`<center> <h4 class="card-title"><b>Marcar pagadas</b></h4> </center>`);
    $("#modal_multiples_intmexA_casas .modal-footer").append(`<div id="borrarProyect"><button type="button" class="btn btn-danger btn-simple " data-dismiss="modal" onclick="CloseModalDelete2Intmex_casas()">CANCELAR</button><button type="submit" disabled id="btn-aceptar" class="btn btn-primary" value="ACEPTAR"> ACEPTAR</button></div>`);
    $("#modal_multiples_intmexA_casas .modal-header").append(`<div class="row"><div class="col-md-12"><select id="desarrolloSelect" name="desarrolloSelect" class="selectpicker select-gral desarrolloSelect ng-invalid ng-invalid-required" title="SELECCIONA UNA OPCIÓN" required data-live-search="true"></select></div></div>`);
    
    $.post(general_base_url + 'Pagos_casas/getDesarrolloSelectINTMEX/', {desarrollo: 3 } ,function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['name_user'];
            $("#desarrolloSelect").append($('<option>').val(id).attr('data-value', id).text(name));
        }
        if (len <= 0) {
            $("#desarrolloSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#desarrolloSelect").val(0);
        $("#desarrolloSelect").selectpicker('refresh');
    }, 'json');
        
    $('#desarrolloSelect').change(function() {
        $("#modal_multiples_intmexA_casas .modal-body .bodypagos").html("");
        if(document.getElementById('bodypago2')){
            let a =  document.getElementById('bodypago2');
            padre = a.parentNode;
            padre.removeChild(a);
        }
    
        var valorSeleccionado = $(this).val();
        var combo = document.getElementById("desarrolloSelect");
        var selected = combo.options[combo.selectedIndex].text;

        $.getJSON(general_base_url + "Pagos_casas/getPagosByProyect/"+valorSeleccionado+'/'+3).done(function(data) {
            let sumaComision = 0;
            if (!data) {
                $("#modal_multiples_intmexA_casas .modal-body").append('<div class="row"><div class="col-md-12">SIN DATOS A MOSTRAR</div></div>');
            } 
            else {
                if(data.length > 0){
                    $("#modal_multiples_intmexA_casas .modal-body ").append(`<center><div class="row bodypagos"><p style='color:#9D9D9D;'>¿Estas seguro que deseas autorizar  <b style="color:green">${formatMoney(data[0][0].suma)}</b> de ${selected}?</div></center>`);
                } 
                
                $("#modal_multiples_intmexA_casas .modal-body ").append(`<div  id="bodypago2"></div>`);
                $.each(data[1], function(i, v) {
                    $("#modal_multiples_intmexA_casas .modal-body #bodypago2").append(`
                    <input type="hidden" name="ids[]" id="ids" value="${v.id_pago_i}"></div>`);
                    
                });
                document.getElementById('btn-aceptar').disabled = false;
            }
        });
    });

    $("#modal_multiples_intmexA_casas").modal({
        backdrop: 'static',
        keyboard: false
    });
});

function cleanComments(){
    var myCommentsList = document.getElementById('documents');
    myCommentsList.innerHTML = '';
    var myFactura = document.getElementById('facturaInfo');
    myFactura.innerHTML = '';
}

function selectAllIntmexCasas(e) {
    tota2 = 0;
    if(e.checked == true){
        $(tabla_asimilados2_intmex_casas.$('input[type="checkbox"]')).each(function (i, v) {
            tr1 = this.closest('tr');
            row = tabla_asimilados2_intmex_casas.row(tr1).data();
            tota2 += parseFloat(row.impuesto);
            if(v.checked == false){
                $(v).prop("checked", true);
            }
        }); 
        $("#totpagarPen_intmex_casas").html(formatMoney(numberTwoDecimal(tota2)));
    }
    if(e.checked == false){
        $(tabla_asimilados2_intmex_casas.$('input[type="checkbox"]')).each(function (i, v) {
            if(v.checked == true){
                $(v).prop("checked", false);
            }
        }); 
        $("#totpagarPen_intmex_casas").html(formatMoney(0));
    }
}

$(document).ready( function(){
    $.getJSON(general_base_url + "Pagos_casas/getReporteEmpresa").done( function( data ){
        $(".report_empresa").html();
        $.each( data, function( i, v){
            $(".report_empresa").append('<div class="col xol-xs-3 col-sm-3 col-md-3 col-lg-3"><label style="color: #00B397;">&nbsp;'+v.empresa+': $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #00B397; font-weight: bold;" value="'+formatMoney(v.porc_empresa)+'" disabled="disabled" readonly="readonly" type="text"  name="myText_FRO" id="myText_FRO"></label></div>');
        });
    });
});

$("#form_multiples_casas").submit( function(e) {
    $('#spiner-loader').removeClass('hidden');
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: general_base_url + "Pagos_casas/IntMexPagadosByProyect",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){

                if( data == 1){
                    CloseModalDelete2Intmex_casas();
                    $("#all_asimilados_intmex").prop("checked", false);
                    $("#totpagarPen_intmex_casas").html(formatMoney(numberTwoDecimal(0)));

                    alerts.showNotification("top", "right", "Se aplicó el cambio exitosamente", "success");
                    tabla_asimilados2_intmex_casas.ajax.reload();
                }else{
                    CloseModalDelete2Intmex_casas();
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                }
                $('#spiner-loader').addClass('hidden');
            },error: function( ){
                CloseModalDelete2Intmex_casas();
                alert("ERROR EN EL SISTEMA");
                $('#spiner-loader').addClass('hidden');
            }
        });
    }
});