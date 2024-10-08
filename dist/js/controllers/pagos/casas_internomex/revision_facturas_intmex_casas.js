var trs;
var tabla_facturas_casas;
let titulos_casas = [];

function CloseModalDelete2IntmexCasas(){
    document.getElementById("form_multiples_casas").reset();
    a = document.getElementById('borrarProyectoIntmexCasas');
    padre = a.parentNode;
    padre.removeChild(a);
    $("#modal_multiples_IntmexF_casas").modal('toggle');  
}

$(document).ready(function() {
    $("#tabla_facturas_intmex_casas").prop("hidden", true);
    $.post(general_base_url+"Pagos/lista_roles", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#catalogo_factura_intmex_casas").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#catalogo_factura_intmex_casas").selectpicker('refresh');
    }, 'json');

    $.getJSON( general_base_url + "Pagos_casas/getReporteEmpresa").done( function( data ){
        $(".report_empresa").html();
        $.each( data, function( i, v){
            $(".report_empresa").append('<div class="col xol-xs-3 col-sm-3 col-md-3 col-lg-3"><label style="color: #00B397;">&nbsp;'+v.empresa+': $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #00B397; font-weight: bold;" value="'+formatMoney(v.porc_empresa)+'" disabled="disabled" readonly="readonly" type="text"  name="myText_FRO" id="myText_FRO"></label></div>');
        });
    });
});

$('#catalogo_factura_intmex_casas').change(function(ruta){
    $("#autorizar_factura_intmex_casas").html(formatMoney(0));
    $("#all_facturas_intmex").prop('checked', false);
    rol = $('#catalogo_factura_intmex_casas').val();
    $("#usuario_factura_intmex_casas").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url+'Pagos_casas/lista_usuarios/',
        data:{
            rol: rol,
            forma_pago: 2
        },
        type: 'post',
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++)
            {
                var id = response[i]['idCondominio'];
                var name = response[i]['nombre'];
                $("#usuario_factura_intmex_casas").append($('<option>').val(id).text(name));
            }
            if(len<=0){
            $("#usuario_factura_intmex_casas").append('<option selected="selected" disabled>NO HAY OPCIONES</option>');
            }
            $("#usuario_factura_intmex_casas").selectpicker('refresh');
        }
    });
    valuar = $('#usuario_factura_intmex_casas').val();
    proyecto = $('#catalogo_factura_intmex_casas').val();
    valuar == '' && tabla_facturas_casas == undefined ? '' : get_facturas_Intmex_casas(proyecto, 0);
});

$('#usuario_factura_intmex_casas').change(function(ruta){
    $("#autorizar_factura_intmex_casas").html(formatMoney(0));
    $("#all_facturas_intmex").prop('checked', false);
    proyecto = $('#catalogo_factura_intmex_casas').val();
    condominio = $('#usuario_factura_intmex_casas').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    get_facturas_Intmex_casas(proyecto, condominio);
});

$(document).on("click", ".PagarCasas", function() {          
    $("#modal_multiples_IntmexF_casas .modal-body").html("");
    $("#modal_multiples_IntmexF_casas .modal-header").html("");
    $("#modal_multiples_IntmexF_casas .modal-header").append(`<center> <h4 class="card-title"><b>Marcar pagadas</b></h4> </center>`);
    $("#modal_multiples_IntmexF_casas .modal-footer").append(`<div id="borrarProyectoIntmexCasas"><button type="button" class="btn btn-danger btn-simple " data-dismiss="modal" onclick="CloseModalDelete2IntmexCasas()">CANCELAR</button><button type="submit" disabled id="btn-aceptarIntmexCasas" class="btn btn-primary" value="ACEPTAR"> ACEPTAR</button></div>`);
    $("#modal_multiples_IntmexF_casas .modal-header").append(`<div class="row"><div class="col-md-12"><select id="desarrolloSelect_Int_casas" name="desarrolloSelect_Int_casas" class="selectpicker select-gral desarrolloSelect_Int_casas ng-invalid ng-invalid-required" title="SELECCIONA UNA OPCIÓN" required data-live-search="true"></select></div></div>`);
    
    $.post(general_base_url + 'Pagos_casas/getDesarrolloSelectINTMEX/', {desarrollo: 2 } ,function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['name_user'];
            $("#desarrolloSelect_Int_casas").append($('<option>').val(id).attr('data-value', id).text(name));
        }
        if (len <= 0) {
            $("#desarrolloSelect_Int_casas").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#desarrolloSelect_Int_casas").val(0);
        $("#desarrolloSelect_Int_casas").selectpicker('refresh');
    }, 'json');
        
    $('#desarrolloSelect_Int_casas').change(function() {
        $("#modal_multiples_IntmexF_casas .modal-body .bodypagos").html("");
        if(document.getElementById('bodypago2')){
            let a =  document.getElementById('bodypago2');
            padre = a.parentNode;
            padre.removeChild(a);
        }
    
        var valorSeleccionado = $(this).val();
        var combo = document.getElementById("desarrolloSelect_Int_casas");
        var selected = combo.options[combo.selectedIndex].text;

        $.getJSON(general_base_url + "Pagos_casas/getPagosByProyect/"+valorSeleccionado+'/'+2).done(function(data) {
            let sumaComision = 0;
            if (!data) {
                $("#modal_multiples_IntmexF_casas .modal-body").append('<div class="row"><div class="col-md-12">SIN DATOS A MOSTRAR</div></div>');
            } 
            else {
                if(data.length > 0){
                    $("#modal_multiples_IntmexF_casas .modal-body ").append(`<center><div class="row bodypagos"><p style='color:#9D9D9D;'>¿Estas seguro que deseas autorizar $ <b style="color:green">${formatMoney(data[0][0].suma)}</b> de ${selected}?</div></center>`);
                } 
                
                $("#modal_multiples_IntmexF_casas .modal-body ").append(`<div  id="bodypago2"></div>`);
                $.each(data[1], function(i, v) {
                    $("#modal_multiples_IntmexF_casas .modal-body #bodypago2").append(`
                    <input type="hidden" name="ids[]" id="ids" value="${v.id_pago_i}"></div>`);
                });
                document.getElementById('btn-aceptarIntmexCasas').disabled = false;
            }
        });
    });

    $("#modal_multiples_IntmexF_casas").modal({
        backdrop: 'static',
        keyboard: false
    });
});


$('#tabla_facturas_intmex_casas thead tr:eq(0) th').each( function (i) {
    if(i != 0){
        var title = $(this).text();
        titulos_casas.push(title);
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
        $('input', this).on('keyup change', function() {
            if (tabla_facturas_casas.column(i).search() !== this.value) {
                tabla_facturas_casas.column(i).search(this.value).draw();
                var total = 0;
                var index = tabla_facturas_casas.rows({ selected: true, search: 'applied' }).indexes();
                var data = tabla_facturas_casas.rows(index).data();
                $.each(data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                var to1 = formatMoney(numberTwoDecimal(total));
                document.getElementById("total_factura_intmex_casas").textContent = to1;
            }
        });
    }
    else {
        $(this).html('<input id="all_facturas_intmex" type="checkbox" style="width:20px; height:20px;" onchange="selectAllIntmexCasas(this)"/>');
    }
});

function get_facturas_Intmex_casas(proyecto, condominio){

    $('#tabla_facturas_intmex_casas').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(numberTwoDecimal(total));
        document.getElementById("total_factura_intmex_casas").textContent = to;
    });

    $("#tabla_facturas_intmex_casas").prop("hidden", false);
    tabla_facturas_casas = $("#tabla_facturas_intmex_casas").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [{
            text: '<div class="d-flex"><i class="fa fa-check "></i><p class="m-0 pl-1">Marcar como pagado</p></div>',
            action: function() {
                if ($('input[name="idTQ[]"]:checked').length > 0) {
                    $('#spiner-loader').removeClass('hide');
                    var idcomision = $(tabla_facturas_casas.$('input[name="idTQ[]"]:checked')).map(function() { return this.value; }).get();
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
                                $("#autorizar_factura_intmex_casas").html(formatMoney(0));
                                $("#all_facturas_intmex").prop('checked', false);
                                tabla_facturas_casas.ajax.reload();
                                var mensaje = "Comisiones de esquema <b>asimilados</b>, fueron marcadas como <b>PAGADAS</b> correctamente.";
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
        },
        {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title:'Comisiones Factura - Revisión INTERNOMEX',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos_casas[columnIdx-1] + ' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url+"static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        orderable: false,
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
                return '<p class="m-0">'+formatMoney(numberTwoDecimal(d.precio_lote))+'</p>';
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
                if(d.lugar_prospeccion == 6){
                    return '<p class="m-0">COMISIÓN + MKTD <br><b> ('+d.porcentaje_decimal+'% de '+d.porcentaje_abono+'%)</b></p>';
                }
                else{
                    return '<p class="m-0">COMISIÓN <br><b> ('+d.porcentaje_decimal+'% de '+d.porcentaje_abono+'%)</b></p>';
                }
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
                var BtnStats1;
                BtnStats1 =  '<p class="m-0">'+d.fecha_creacion+'</p>';
                return BtnStats1;
            }
        },
        {
            data: function( data ){
                var BtnStats;
                BtnStats = `<button href="#" value="${data.id_pago_i}" data-value='"${data.lote}"' data-code="${data.cbbtton}" class="btn-data btn-blueMaderas consultar_logs_factura_casas" data-toggle="tooltip" data-placement="top" title="DETALLES"><i class="fas fa-info"></i></button>`;

                return '<div class="d-flex justify-center">'+ BtnStats +'</div>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            searchable:false,
            className: 'dt-body-center',
            render: function (d, type, full, meta){
                if(full.estatus == 8){
                    if(full.id_comision){
                        return '<input type="checkbox" name="idTQ[]" class="individualFacturaCheck" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
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
            "url": general_base_url + "Pagos_casas/getDatosNuevasFacturasCasas/" ,
            "type": "POST",
            data:{
                proyecto:proyecto,
                condominio:condominio
            },
            cache: false
        },
    });

    $("#tabla_facturas_intmex_casas tbody").on("click", ".consultar_logs_factura_casas", function(e){
        $("#nombreLote").html('');
        $("#comentariosFactura").html('');
        $('#spiner-loader').removeClass('hide');
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");

        changeSizeModal('modal-md');
        appendBodyModal(`<div class="modal-body">
                <div role="tabpanel">
                    <ul>
                        <div id="nombreLote"></div>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="changelogTab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-plain">
                                        <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                            <ul class="timeline-3" id="comentariosFactura"></ul>
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
        
        $("#nombreLote").append('<p><h5">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON(general_base_url+"Pagos_casas/getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comentariosFactura").append('<li>\n' +
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

    $('#tabla_facturas_intmex_casas').on('click', 'input', function() {
        totaPen =0;
        trs = $(this).closest('tr');
        var row = tabla_facturas_casas.row(trs).data();
        if (row.pa == 0) {
            row.pa = row.impuesto;
            totaPen += parseFloat(row.pa);
            trs.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
        }
        else {
            totaPen -= parseFloat(row.pa);
            row.pa = 0;
        }
        $("#autorizar_factura_intmex_casas").html(formatMoney(numberTwoDecimal(totaPen)));
    });

    $('#tabla_facturas_intmex_casas').on("click", 'input', function() {
        totaPen = 0;
        tabla_facturas_casas.$('input[type="checkbox"]').each(function () {
            let totalChecados = tabla_facturas_casas.$('input[type="checkbox"]:checked') ;
            let totalCheckbox = tabla_facturas_casas.$('input[type="checkbox"]');
            if(this.checked){
                trs = this.closest('tr');
                row = tabla_facturas_casas.row(trs).data();
                totaPen += parseFloat(row.impuesto); 
            }
            if( totalChecados.length == totalCheckbox.length ){
                $("#all_facturas_intmex").prop("checked", true);
            }else {
                $("#all_facturas_intmex").prop("checked", false);
            }
        });
        $("#autorizar_factura_intmex_casas").html(formatMoney(numberTwoDecimal(totaPen)));
    });
}

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});

$(window).resize(function(){
    tabla_facturas_casas.columns.adjust();
});

function cancela(){
    $("#modal_nuevas_Intmex_casas").modal('toggle');
}


$("#form_refresh").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: general_base_url + "Pagos_casas/refresh_solicitud/",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST',
            success: function(data){
                if( data[0] ){
                    $("#modal_refresh").modal('toggle' );
                    alerts.showNotification("top", "right", "Se ha procesado la solicitud exitosamente", "success");
                    setTimeout(function() {
                        tabla_facturas_casas.ajax.reload();
                    }, 3000);
                }else{
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                }
            },error: function( ){
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});


function preview_info(archivo){
    $("#documento_preview .modal-dialog").html("");
    $("#documento_preview").css('z-index', 9999);
    archivo = general_base_url+"dist/documentos/"+archivo+"";
    var re = /(?:\.([^.]+))?$/;
    var ext = re.exec(archivo)[1];
    elemento = "";

    if (ext == 'pdf'){
        elemento += '<iframe src="'+archivo+'" style="overflow:hidden; width: 100%; height: -webkit-fill-available">';
        elemento += '</iframe>';
        $("#documento_preview .modal-dialog").append(elemento);
        $("#documento_preview").modal();
    }

    if(ext == 'jpg' || ext == 'jpeg'){
        elemento += '<div class="modal-content" style="background-color: #333; display:flex; justify-content: center; padding:20px 0">';
        elemento += '<img src="'+archivo+'" style="overflow:hidden; width: 40%;">';
        elemento += '</div>';
        $("#documento_preview .modal-dialog").append(elemento);
        $("#documento_preview").modal();
    }

    if(ext == 'xlsx'){
        elemento += '<div class="modal-content">';
        elemento += '<iframe src="'+archivo+'"></iframe>';
        elemento += '</div>';
        $("#documento_preview .modal-dialog").append(elemento);
    }
}



function selectAllIntmexCasas(e) {
    tota2 = 0;
    if(e.checked == true){
        $(tabla_facturas_casas.$('input[type="checkbox"]')).each(function (i, v) {
            trs = this.closest('tr');
            row = tabla_facturas_casas.row(trs).data();
            tota2 += parseFloat(row.impuesto);
            if(v.checked == false){
                $(v).prop("checked", true);
            }
        }); 
        $("#autorizar_factura_intmex_casas").html(formatMoney(numberTwoDecimal(tota2)));
    }
    if(e.checked == false){
        $(tabla_facturas_casas.$('input[type="checkbox"]')).each(function (i, v) {
            if(v.checked == true){
                $(v).prop("checked", false);
            }
        }); 
        $("#autorizar_factura_intmex_casas").html(formatMoney(0));
    }
}

$("#form_multiples_casas").submit( function(e) {
    $('#loader').removeClass('hidden');
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
            type: 'POST',
            success: function(data){
                if( data == 1){
                    CloseModalDelete2IntmexCasas();
                    $('#all_facturas_intmex').prop("checked", false);
                    $("#autorizar_factura_intmex_casas").html(formatMoney(0));
                    alerts.showNotification("top", "right", "Se aplicó el cambio exitosamente", "success");
                    if(tabla_facturas_casas != undefined){
                        tabla_facturas_casas.ajax.reload();
                    }
                    
                }else{
                    CloseModalDelete2IntmexCasas();
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                }
                $('#loader').addClass('hidden');
            },error: function( ){
                CloseModalDelete2IntmexCasas();
                alert("ERROR EN EL SISTEMA");
                $('#loader').addClass('hidden');
            }
        });
    }
});
