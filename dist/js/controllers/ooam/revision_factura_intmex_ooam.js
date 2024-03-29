var trs;
var tabla_factura_ooam ;

function CloseModalDelete2Ooam(){
    document.getElementById("form_multiplesOoam").reset();
    a = document.getElementById('borrarProyect');
    padre = a.parentNode;
    padre.removeChild(a);
    $("#modal_multiplesOoam").modal('toggle');  
}

$(document).ready(function() {
    $("#tabla_factura_ooam").prop("hidden", true);

    $.post(general_base_url+"/pagos/lista_roles", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#catalogo_factura_ooam").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#catalogo_factura_ooam").selectpicker('refresh');
    }, 'json');
});

$('#catalogo_factura_ooam').change(function(ruta){
    rol = $('#catalogo_factura_ooam').val();
    $("#usuario_factura_ooam").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url+'Ooam/lista_usuarios/',
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
                $("#usuario_factura_ooam").append($('<option>').val(id).text(name));
            }
            if(len<=0){
            $("#usuario_factura_ooam").append('<option selected="selected" disabled>NO HAY OPCIONES</option>');
            }
            $("#usuario_factura_ooam").selectpicker('refresh');
        }
    });
});

$('#usuario_factura_ooam').change(function(ruta){
    proyecto = $('#catalogo_factura_ooam').val();
    condominio = $('#usuario_factura_ooam').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getFacturaCommissionsOOAM(proyecto, condominio);
});


$(document).on("click", ".PagarOoam", function() {          
    $("#modal_multiplesOoam .modal-body").html("");
    $("#modal_multiplesOoam .modal-header").html("");
    $("#modal_multiplesOoam .modal-header").append(`<center> <h4 class="card-title"><b>Marcar pagadas</b></h4> </center>`);
    $("#modal_multiplesOoam .modal-footer").append(`<div id="borrarProyect"><button type="button" class="btn btn-danger btn-simple " data-dismiss="modal" onclick="CloseModalDelete2()">CANCELAR</button><button type="submit" disabled id="btn-aceptar" class="btn btn-primary" value="ACEPTAR"> ACEPTAR</button></div>`);
    $("#modal_multiplesOoam .modal-header").append(`<div class="row"><div class="col-md-12"><select id="desarrolloSelect" name="desarrolloSelect" class="selectpicker select-gral desarrolloSelect ng-invalid ng-invalid-required" title="SELECCIONA UNA OPCIÓN" required data-live-search="true"></select></div></div>`);
    
    $.post(general_base_url + 'Ooam/getDesarrolloSelectINTMEX/', {desarrollo: 2 } ,function(data) {
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
        $("#modal_multiplesOoam .modal-body .bodypagos").html("");
        if(document.getElementById('bodypago2')){
            let a =  document.getElementById('bodypago2');
            padre = a.parentNode;
            padre.removeChild(a);
        }
    
        var valorSeleccionado = $(this).val();
        var combo = document.getElementById("desarrolloSelect");
        var selected = combo.options[combo.selectedIndex].text;

        $.getJSON(general_base_url + "Ooam/getPagosByProyect/"+valorSeleccionado+'/'+2).done(function(data) {
            let sumaComision = 0;

            if (!data) {
                $("#modal_multiplesOoam .modal-body").append('<div class="row"><div class="col-md-12">SIN DATOS A MOSTRAR</div></div>');
            } 
            else {
                if(data.length > 0){
                    $("#modal_multiplesOoam .modal-body ").append(`<center><div class="row bodypagos" ><p style='color:#9D9D9D;'>¿Estas seguro que deseas autorizar $ <b style="color:green">${formatMoney(data[0][0].suma)}</b> de ${selected}?</div></center>`);
                } 
                
                $("#modal_multiplesOoam .modal-body ").append(`<div  id="bodypago2"></div>`);
                $.each(data[1], function(i, v) {
                    $("#modal_multiplesOoam .modal-body #bodypago2").append(`<input type="hidden" name="ids[]" id="ids" value="${v.id_pago_i}"></div>`);
                });
                document.getElementById('btn-aceptar').disabled = false;
            }
        });
    });

    $("#modal_multiplesOoam").modal({
        backdrop: 'static',
        keyboard: false
    });
});

let titulosOoam = [];
$('#tabla_factura_ooam thead trs:eq(0) th').each( function (i) {
    if(i != 0){
        var title = $(this).text();
        titulosOoam.push(title);
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
        $('input', this).on('keyup change', function() {
            if (tabla_factura_ooam.column(i).search() !== this.value) {
                tabla_factura_ooam.column(i).search(this.value).draw();
                var total = 0;
                var index = tabla_factura_ooam.rows({ selected: true, search: 'applied' }).indexes();
                var data = tabla_factura_ooam.rows(index).data();
                $.each(data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                var to1 = formatMoney(total);
                document.getElementById("total_factura_ooam").textContent = formatMoney(numberTwoDecimal(total));
            }
        });
    }
    else {
        $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAllOOAM(this)"/>');
    }
});

function getFacturaCommissionsOOAM(proyecto, condominio){
    $('#tabla_factura_ooam').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(numberTwoDecimal(total));
        document.getElementById("total_factura_ooam").textContent = to;
    });

    $("#tabla_factura_ooam").prop("hidden", false);
    tabla_factura_ooam = $("#tabla_factura_ooam").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [{
            text: '<div class="d-flex"><i class="fa fa-check "></i><p class="m-0 pl-1">Marcar como pagado</p></div>',
            action: function() {
                if ($('input[name="idTQOOAM[]"]:checked').length > 0) {
                    $('#spiner-loader').removeClass('hide');
                    var idcomision = $(tabla_factura_ooam.$('input[name="idTQOOAM[]"]:checked')).map(function() {
                        return this.value;
                    }).get();
                    var com2 = new FormData();
                    com2.append("idcomision", idcomision); 
                    $.ajax({
                        url : general_base_url + 'pagos/pago_internomex/',
                        data: com2,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST', 
                        success: function(data){
                            response = JSON.parse(data);
                            if(data == 1) {
                                $('#spiner-loader').addClass('hide');
                                $("#autorizar_factura_ooam").html(formatMoney(0));
                                $("#all").prop('checked', false);
                                $("#myModalEnviadas").modal('toggle');
                                tabla_factura_ooam.ajax.reload();
                                let mensaje = "Comisiones de esquema <b>asimilados</b>, fueron marcadas como <b>PAGADAS</b> correctamente.";
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
            title: 'REMANENTE_INTERNOMEX_COMISIONES',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulosOoam[columnIdx-1] + ' ';
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
                return '<p class="m-0">'+formatMoney(numberTwoDecimal(d.comision_total))+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0">'+formatMoney(numberTwoDecimal(d.pago_neodata))+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0"><b>'+formatMoney(numberTwoDecimal(d.impuesto))+'</b></p>';
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
                BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_remanente" title="Detalles">' +'<i class="fas fa-info"></i></button>';
                return '<div class="d-flex">'+ BtnStats +'</div>';
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
                        return '<input type="checkbox" name="idTQOOAM[]" class="individualCheckOOAM" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
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
            "url": general_base_url + "Ooam/getRevisionFacturasOOAM/" ,
            "type": "POST",
            data:{
                proyecto : proyecto,
                condominio:condominio
            },
            cache: false
        },
    });


    $("#tabla_factura_ooam tbody").on("click", ".consultar_logs_remanente", function(e){
        $('#spiner-loader').removeClass('hide');
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        $("#seeInformationModalremanente").modal();
        $("#nameLote").append('<p><h5">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON(general_base_url+"Ooam/getComments/"+id_pago).done( function( data ){
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

    $('#tabla_factura_ooam').on('click', 'input', function() {
        trs = $(this).closest('trs');
        console.log(trs);
        var rows = tabla_factura_ooam.row(trs).data();  


        console.log(rows)
        if (rows.pa == 0) {
            rows.pa = rows.impuesto;
            totaPen += parseFloat(rows.pa);
            trs.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
        }
        else {
            totaPen -= parseFloat(rows.pa);
            rows.pa = 0;
        }
        $("#autorizar_factura_ooam").html(formatMoney(numberTwoDecimal(totaPen)));
    });

    $("#tabla_factura_ooam tbody").on("click", ".cambiar_estatus", function(){
        var trs = $(this).closest('trs');
        var rows = tabla_factura_ooam.row( trs );
        id_pago_i = $(this).val();
        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de pausar la comisión de <b>'+rows.data().lote+'</b> para el <b>'+(rows.data().puesto).toUpperCase()+':</b> <i>'+rows.data().usuario+'</i>?</p></div></div>');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="text" class="form-control observaciones" name="observaciones" required placeholder="Describe mótivo por el cual se pauso la solicitud"></input></div></div>');
        $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+rows.data().id_pago_i+'">');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="PAUSAR"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></div></div>');
        $("#modal_nuevas").modal();
    });

    $("#tabla_factura_ooam tbody").on("click", ".despausar_estatus", function(){
        var trs = $(this).closest('trs');
        var rows = tabla_factura_ooam.row( trs );
        id_pago_i = $(this).val();
        $("#modal_refresh .modal-body").html("");
        $("#modal_refresh .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro regresar al estatus inicial la comisión  de <b>'+rows.data().lote+'</b> para el <b>'+(rows.data().puesto).toUpperCase()+':</b> <i>'+rows.data().usuario+'</i>?</p></div></div>');
        $("#modal_refresh .modal-body").append('<input class="idComPau" name="id_comision" type="text" value="'+rows.data().id_comision+'" hidden>');
        $("#modal_refresh .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="CONFIRMAR"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></div></div>');
        $("#modal_refresh").modal();
    });

    $("#tabla_factura_ooam tbody").on("click", ".consultar_documentos", function(){
        id_com = $(this).val();
        id_pj = $(this).attr("data-personalidad");
        $("#seeInformationModal").modal();
        $.getJSON( general_base_url + "Pagos/getDatosDocumentos/"+id_com+"/"+id_pj).done( function( data ){
            $.each( data, function( i, v){
                $("#seeInformationModal .documents").append('<div class="row">');
                if (v.estado == "NO EXISTE"){
                    $("#seeInformationModal .documents").append('<div class="col-md-7"><label style="font-size:10px; margin:0; color:gray;">'+(v.nombre).substr(0, 52)+'</label></div><div class="col-md-5"><label style="font-size:10px; margin:0; color:gray;">(No existente)</label></div>');
                }
                else{
                    $("#seeInformationModal .documents").append('<div class="col-md-7"><label style="font-size:10px; margin:0; color:#0a548b;"><b>'+(v.nombre).substr(0, 52)+'</b></label></div> <div class="col-md-5"><label style="font-size:10px; margin:0; color:#0a548b;"><b>('+v.expediente+')</label></b> - <button onclick="preview_info(&#39;'+(v.expediente)+'&#39;)" style="border:none; background-color:#fff;"><i class="fa fa-file" aria-hidden="true" style="font-size: 12px; color:#0a548b;"></i></button></div>');
                }
                $("#seeInformationModal .documents").append('</div>');
            });
        });

        $.getJSON( general_base_url + "Pagos/getDatosFactura/"+id_com).done( function( data ){
            $("#seeInformationModal .facturaInfo").append('<div class="row">');
            if (!data.datos_solicitud['id_factura'] == '' && !data.datos_solicitud['id_factura'] == '0'){
                $("#seeInformationModal .facturaInfo").append('<BR><div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>NOMBRE EMISOR</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombre']+' '+data.datos_solicitud['apellido_paterno']+' '+data.datos_solicitud['apellido_materno']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b> LOTE</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombreLote']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>TOTAL FACT.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+data.datos_solicitud['total']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>MONTO COMSN.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+data.datos_solicitud['porcentaje_dinero']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FOLIO</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['folio_factura']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA FACTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['fecha_factura']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA CAPTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['fecha_ingreso']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>MÉTODO</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['metodo_pago']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>RÉGIMEN F.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['regimen']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>FORMA P.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['forma_pago']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CFDI</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['cfdi']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>UNIDAD</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['unidad']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CLAVE PROD.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['claveProd']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModal .facturaInfo").append('<div class="col-md-6"><label style="font-size:14px; margin:0; color:gray;"><b>UUID</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['uuid']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#seeInformationModal .facturaInfo").append('<div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>DESCRIPCIÓN</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['descripcion']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
            }
            else {
                $("#seeInformationModal .facturaInfo").append('<div class="col-md-12"><label style="font-size:10px; margin:0; color:orange;">SIN HAY DATOS A MOSTRAR</label></div>');
            }
            $("#seeInformationModal .facturaInfo").append('</div>');
        });
    });
}

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable()
    .columns.adjust();
});

$(window).resize(function(){
    tabla_factura_ooam.columns.adjust();
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
            url: general_base_url + "Pagos/pausar_solicitud/",
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
                    alerts.showNotification("top", "right", "Se ha pausado la comisión exitosamente", "success");
                    setTimeout(function() {
                        tabla_factura_ooam.ajax.reload();
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

$("#form_refresh").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: general_base_url + "pagos/refresh_solicitud/",
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
                        tabla_factura_ooam.ajax.reload();
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

$("#form_despausar").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: general_base_url + "pagos/despausar_solicitud/",
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
                        tabla_factura_ooam.ajax.reload();
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

$(document).on("click", ".individualCheckOOAM", function() {
    totaPen = 0;
    tabla_factura_ooam.$('input[type="checkbox"]').each(function () {
        let totalChecados = tabla_factura_ooam.$('input[type="checkbox"]:checked') ;
        let totalCheckbox = tabla_factura_ooam.$('input[type="checkbox"]');
        if(this.checked){
            trs = this.closest('trs');
            rows = tabla_factura_ooam.row(trs).data();
            totaPen += parseFloat(rows.impuesto); 
        }

        if( totalChecados.length == totalCheckbox.length )
            $("#all").prop("checked", true);
        else 
            $("#all").prop("checked", false);
    });
    $("#autorizar_factura_ooam").html(formatMoney(numberTwoDecimal(totaPen)));
});
    
function selectAllOOAM(e) {
    tota2 = 0;
    if(e.checked == true){
        $(tabla_factura_ooam.$('input[type="checkbox"]')).each(function (i, v) {
            trs = this.closest('trs');
            rows = tabla_factura_ooam.row(trs).data();
            tota2 += parseFloat(rows.impuesto);
            if(v.checked == false){
                $(v).prop("checked", true);
            }
        }); 
        $("#autorizar_factura_ooam").html(formatMoney(numberTwoDecimal(tota2)));
    }
    if(e.checked == false){
        $(tabla_factura_ooam.$('input[type="checkbox"]')).each(function (i, v) {
            if(v.checked == true){
                $(v).prop("checked", false);
            }
        }); 
        $("#autorizar_factura_ooam").html(formatMoney(0));
    }
}

function cleanComments(){
    var myCommentsList = document.getElementById('documents');
    myCommentsList.innerHTML = '';
    var myFactura = document.getElementById('facturaInfo');
    myFactura.innerHTML = '';
}

$("#form_multiplesOoam").submit( function(e) {
    $('#loader').removeClass('hidden');
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: general_base_url + "Ooam/IntMexPagadosByProyect",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST',
            success: function(data){
                if( data == 1){
                    CloseModalDelete2Ooam();
                    alerts.showNotification("top", "right", "Se aplicó el cambio exitosamente", "success");
                }else{
                    CloseModalDelete2Ooam();
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                }
                $('#loader').addClass('hidden');
            },error: function( ){
                CloseModalDelete2Ooam();
                alert("ERROR EN EL SISTEMA");
                $('#loader').addClass('hidden');
            }
        });
    }
});

$(document).ready( function(){
    $.getJSON( general_base_url + "Ooam/getReporteEmpresa").done( function( data ){
        $(".report_empresa").html();
        $.each( data, function( i, v){
            $(".report_empresa").append('<div class="col xol-xs-3 col-sm-3 col-md-3 col-lg-3"><label style="color: #00B397;">&nbsp;'+v.empresa+': $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #00B397; font-weight: bold;" value="'+formatMoney(v.porc_empresa)+'" disabled="disabled" readonly="readonly" type="text"  name="myText_FRO" id="myText_FRO"></label></div>');
        });
    });
});