
var tr;
var tablaRemanente2;
var totaPen = 0;

$(document).ready(function() {
    $("#tabla_remanente").prop("hidden", true);
    $.post(general_base_url+"Pagos/lista_roles", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#catalogo_remanente").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#catalogo_remanente").selectpicker('refresh');
    }, 'json');

    $.getJSON( general_base_url + "Pagos/getReporteEmpresa").done( function( data ){
        $(".report_empresa").html();
        $.each( data, function( i, v){
            $(".report_empresa").append('<div class="col xol-xs-3 col-sm-3 col-md-3 col-lg-3"><label style="color: #00B397;">&nbsp;'+v.empresa+': $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #00B397; font-weight: bold;" value="'+formatMoney(v.porc_empresa)+'" disabled="disabled" readonly="readonly" type="text"  name="myText_FRO" id="myText_FRO"></label></div>');
        });
    });
});

function CloseModalDelete2(){
    document.getElementById("form_multiples").reset();
    a = document.getElementById('borrarProyect');
    padre = a.parentNode;
    padre.removeChild(a);
    $("#modal_multiples").modal('toggle');  
}

$('#catalogo_remanente').change(function(ruta){
    rol = $('#catalogo_remanente').val();
    $("#usuario_remanente").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url+'Pagos/lista_usuarios/',
        type: 'post',
        data: {
            "rol":    rol,
            "forma_pago": 4,
        },
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++){
                var id = response[i]['idCondominio'];
                var name = response[i]['nombre'];
                $("#usuario_remanente").append($('<option>').val(id).text(name));
            }
            if(len<=0){
                $("#usuario_remanente").append('<option selected="selected" disabled>NO HAY OPCIONES</option>');
            }
            $("#usuario_remanente").selectpicker('refresh');
        }
    });
});

$('#usuario_remanente').change(function(ruta){
    proyecto = $('#catalogo_remanente').val();
    condominio = $('#usuario_remanente').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getAssimilatedCommissions(proyecto, condominio);
});

$(document).on("click", ".pagar_remanente", function() {          
    $("#modal_multiples .modal-body").html("");
    $("#modal_multiples .modal-header").html("");
    $("#modal_multiples .modal-header").append(`<center> <h4 class="card-title"><b>Marcar pagadas</b></h4> </center>`);
    $("#modal_multiples .modal-footer").append(`<div id="borrarProyect"><button type="button" class="btn btn-danger btn-simple " data-dismiss="modal" onclick="CloseModalDelete2()">CANCELAR</button><button type="submit" disabled id="btn-aceptar" class="btn btn-primary" value="ACEPTAR"> ACEPTAR</button></div>`);
    $("#modal_multiples .modal-header").append(`<div class="row"><div class="col-md-12"><select id="desarrolloSelect" name="desarrolloSelect" class="selectpicker select-gral desarrolloSelect ng-invalid ng-invalid-required" title="SELECCIONA UNA OPCIÓN" required data-live-search="true"></select></div></div>`);
    
    $.post(general_base_url + 'Pagos/getDesarrolloSelectINTMEX/', {desarrollo: 4 } ,function(data) {
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
        $("#modal_multiples .modal-body .bodypagos").html("");
        if(document.getElementById('bodypago2')){
            let a =  document.getElementById('bodypago2');
            padre = a.parentNode;
            padre.removeChild(a);
        }
    
        var valorSeleccionado = $(this).val();
        var combo = document.getElementById("desarrolloSelect");
        var selected = combo.options[combo.selectedIndex].text;

        $.getJSON(general_base_url + "Pagos/getPagosByProyect/"+valorSeleccionado+'/'+4).done(function(data) {
            let sumaComision = 0;

            if (!data) {
                $("#modal_multiples .modal-body").append('<div class="row"><div class="col-md-12">SIN DATOS A MOSTRAR</div></div>');
            } 
            else {
                if(data.length > 0){
                    $("#modal_multiples .modal-body ").append(`<center><div class="row bodypagos" ><p style='color:#9D9D9D;'>¿Estas seguro que deseas autorizar <b style="color:green">${formatMoney(data[0][0].suma)}</b> de ${selected}?</div></center>`);
                } 
                
                $("#modal_multiples .modal-body ").append(`<div  id="bodypago2"></div>`);
                $.each(data[1], function(i, v) {
                    $("#modal_multiples .modal-body #bodypago2").append(`<input type="hidden" name="ids[]" id="ids" value="${v.id_pago_i}"></div>`);
                    
                });
                document.getElementById('btn-aceptar').disabled = false;
            }
        });
    });

    $("#modal_multiples").modal({
        backdrop: 'static',
        keyboard: false
    });
});

let titulos = [];
$('#tabla_remanente thead tr:eq(0) th').each( function (i) {
    if(i != 0){
        var title = $(this).text();
        titulos.push(title);
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
        $('input', this).on('keyup change', function() {
            if (tablaRemanente2.column(i).search() !== this.value) {
                tablaRemanente2.column(i).search(this.value).draw();
                var total = 0;
                var index = tablaRemanente2.rows({ selected: true, search: 'applied' }).indexes();
                var data = tablaRemanente2.rows(index).data();
                $.each(data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                var to1 = formatMoney(total);
                document.getElementById("total_remanente").textContent = formatMoney(numberTwoDecimal(total));
            }
        });
        } 
    else {
        $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
    }
});

function getAssimilatedCommissions(proyecto, condominio){
    $('#tabla_remanente').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(numberTwoDecimal(total));
        document.getElementById("total_remanente").textContent = to;
    });

    $("#tabla_remanente").prop("hidden", false);
    tablaRemanente2 = $("#tabla_remanente").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [{
            text: '<div class="d-flex"><i class="fa fa-check "></i><p class="m-0 pl-1">Marcar como pagado</p></div>',
            action: function() {
                if ($('input[name="idTQ[]"]:checked').length > 0) {
                    $('#spiner-loader').removeClass('hide');
                    var idcomision = $(tablaRemanente2.$('input[name="idTQ[]"]:checked')).map(function() { return this.value; }).get();
                    var com2 = new FormData();
                    com2.append("idcomision", idcomision); 
                    $.ajax({
                        url : general_base_url + 'Pagos/pago_internomex/',
                        data: com2,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST', 
                        success: function(data){
                            response = JSON.parse(data);
                            if(data == 1) {
                                $('#spiner-loader').addClass('hide');
                                $("#total_autorizar").html(formatMoney(0));
                                $("#all").prop('checked', false);
                                var fecha = new Date();
                                tablaRemanente2.ajax.reload();
                                var mensaje = "Comisiones de esquema <b>asimilados</b>, fueron marcadas como <b>PAGADAS</b> correctamente."
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
            title:'Comisiones Remanente - Revisión INTERNOMEX',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx-1] + ' ';
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
                return '<p class="p-0"><b>'+d.usuario+'</b></i></p>';
            }
        },
        {
            data: function( d ){
                return '<p class="p-0"><b>'+d.rfc+'</b></i></p>';
            }
        },
        {
            data: function( d ){
                return '<p class="p-0"><i> '+d.puesto+'</i></p>';
            }
        },
        {
            data: function( d ){
                var BtnStats1;
                if(d.estatus == 8){
                    BtnStats1 =  '<p class="p-0">'+d.fecha_creacion+'</p>';
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
                let btns = '';

                const BTN_DETREM = `<button href="#" value="${data.id_pago_i}"  data-value='"${data.lote}"' data-code="${data.cbbtton}" class="btn-data btn-blueMaderas consultar_logs_remanente" title="DETALLES"><i class="fas fa-info"></i></button>`;
                const BTN_STAREM = `<button href="#" value="${data.id_pago_i}" data-value="${data.id_pago_i}" data-code="${data.cbbtton}" class="btn-data btn-orangeYellow cambiar_estatus" title="PAUSAR SOLICITUD"><i class="fas fa-pause"></i></button>`;
                const BTN_ACTREM = `<button href="#" value="${data.id_pago_i}" data-value="${data.id_pago_i}" data-code="${data.cbbtton}" class="btn-data btn-green regresar_estatus" title="ACTIVAR SOLICITUD"><i class="fas fa-play"></i></button>`

                if(data.estatus == 8){
                    btns += BTN_DETREM;
                    btns += BTN_STAREM;
                }
                else{
                    btns += BTN_DETREM;
                    btns += BTN_ACTREM;
                }
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
                if(full.estatus == 8){
                    if(full.id_comision){
                        return '<input type="checkbox" name="idTQ[]" class="individualCheck" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                    }
                    else{
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
            "url": general_base_url + "Pagos/getDatosNuevasRContraloria/",
            "type": "POST",
            cache: false,
            data: {
                "proyecto":    proyecto,
                "condominio" : condominio
            },
        },
    });

    $("#tabla_remanente tbody").on("click", ".consultar_logs_remanente", function(e){
        $('#spiner-loader').removeClass('hide');
        e.preventDefault();
        e.stopImmediatePropagation();
        $("#nombreLote").html('');
        $("#comentariosAsimilados").html('');
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
                                            <ul class="timeline-3" id="comentariosAsimilados"></ul>
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
        $.getJSON(general_base_url+"Pagos/getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comentariosAsimilados").append('<li>\n' +
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

    $('#tabla_remanente').on('click', 'input', function() {
        tr = $(this).closest('tr');
        var row = tablaRemanente2.row(tr).data();
        if (row.pa == 0) {
            row.pa = row.impuesto;
            totaPen += parseFloat(row.pa);
            tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
        } 
        else {
            totaPen -= parseFloat(row.pa);
            row.pa = 0;
        }

        $("#total_autorizar").html(formatMoney(numberTwoDecimal(totaPen)));
    });

    $("#tabla_remanente tbody").on("click", ".cambiar_estatus", function(){
        var tr = $(this).closest('tr');
        var row = tablaRemanente2.row( tr );
        id_pago_i = $(this).val();

        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-footer").html("");
        $("#modal_nuevas .modal-body").append(`<div class="row"><div class="col-lg-12"><p>¿Está seguro de pausar la comisión de <b>${row.data().lote}</b> para el <b> ${(row.data().puesto).toUpperCase()} :</b><i>${row.data().usuario}</i>?</p></div></div>`);
        $("#modal_nuevas .modal-body").append( `<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="1"><input type="hidden" name="estatus" value="88"><input type="text" class="text-modal observaciones" name="observaciones" required placeholder="Describe mótivo por el cual se va pausar la solicitud"></input></div></div>`);
        $("#modal_nuevas .modal-body").append(`<input class="text-modal" type="hidden" name="id_pago" value="${row.data().id_pago_i}">`);
        $("#modal_nuevas .modal-footer").append(`<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button><button type="submit" class="btn btn-primary" value="PAUSAR">PAUSAR</button>`);
        $("#modal_nuevas").modal();
    });

    $("#tabla_remanente tbody").on("click", ".regresar_estatus", function(){
        var tr = $(this).closest('tr');
        var row = tablaRemanente2.row( tr );
        id_pago_i = $(this).val();

        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-footer").html("");
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de activar la comisión de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p></div></div>');
        $("#modal_nuevas .modal-body").append(`<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="2"><input type="hidden" name="estatus" value="8"><input type="text" class="text-modal observaciones" name="observaciones" required placeholder="Describe mótivo por el cual se va activar nuevamente la solicitud"></input></div></div>`);
        $("#modal_nuevas .modal-body").append(`<input type="hidden" name="id_pago" value="${row.data().id_pago_i}">`);
        $("#modal_nuevas .modal-footer").append(` <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button><button type="submit" class="btn btn-primary" value="ACTIVAR">ACTIVAR</button>`);
        $("#modal_nuevas").modal();
    });
}

$(window).resize(function(){
    tablaRemanente2.columns.adjust();
});

function cancela(){
    $("#modal_nuevas").modal('toggle');
}

$("#form_interes").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: general_base_url + "Pagos/despausar_solicitud",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST',
            success: function(data){
                if( data[0] ){
                    $("#modal_nuevas").modal('toggle' );
                    alerts.showNotification("top", "right", "Se aplicó el cambio exitosamente", "success");
                    setTimeout(function() {
                        tablaRemanente2.ajax.reload();
                    }, 3000);
                }
                else{
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                }
            },error: function( ){
                alert("ERROR EN EL SISTEMA");
            }
        });
        $("#total_autorizar").html(formatMoney(0));
    }
});

$("#form_refresh").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: general_base_url + "Pagos/refresh_solicitud/",
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
                        tablaRemanente2.ajax.reload();
                    }, 3000);
                }
                else{
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                }
            },error: function( ){
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});

$("#form_despausar").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: general_base_url + "Pagos/despausar_solicitud/",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST',
            success: function(data){
                if( data[0] ){
                    $("#modal_despausar").modal('toggle' );
                    alerts.showNotification("top", "right", "Se ha regresado la comisión exitosamente", "success");
                    setTimeout(function() {
                        tablaRemanente2.ajax.reload();
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

function vistapreviaInformacion(archivo){
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

$(document).on("click", ".individualCheck", function() {
    totaPen = 0;
    tablaRemanente2.$('input[type="checkbox"]').each(function () {
        let totalChecados = tablaRemanente2.$('input[type="checkbox"]:checked') ;
        let totalCheckbox = tablaRemanente2.$('input[type="checkbox"]');
        if(this.checked){
            tr = this.closest('tr');
            row = tablaRemanente2.row(tr).data();
            totaPen += parseFloat(row.impuesto); 
        }
        if( totalChecados.length == totalCheckbox.length )
            $("#all").prop("checked", true);
        else 
            $("#all").prop("checked", false); 
    });
    $("#total_autorizar").html(formatMoney(numberTwoDecimal(totaPen)));
});

function selectAll(e) {
    tota2 = 0;
    if(e.checked == true){
        $(tablaRemanente2.$('input[type="checkbox"]')).each(function (i, v) {
            tr = this.closest('tr');
            row = tablaRemanente2.row(tr).data();
            tota2 += parseFloat(row.impuesto);
            if(v.checked == false){
                $(v).prop("checked", true);
            }
        }); 
        $("#total_autorizar").html(formatMoney(numberTwoDecimal(tota2)));
    }
    if(e.checked == false){
        $(tablaRemanente2.$('input[type="checkbox"]')).each(function (i, v) {
            if(v.checked == true){
                $(v).prop("checked", false);
            }
        }); 
        $("#total_autorizar").html(formatMoney(0));
    }
}

$("#form_multiples").submit( function(e) {
    $('#loader').removeClass('hidden');
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: general_base_url + "Pagos/IntMexPagadosByProyect",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', 
            success: function(data){
                if( data == 1){
                    CloseModalDelete2();
                    alerts.showNotification("top", "right", "Se aplicó el cambio exitosamente", "success");
                }else{
                    CloseModalDelete2();
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                }
                $('#loader').addClass('hidden');
            },error: function( ){
                CloseModalDelete2();
                alert("ERROR EN EL SISTEMA");
                $('#loader').addClass('hidden');
            }
        });
    }
});