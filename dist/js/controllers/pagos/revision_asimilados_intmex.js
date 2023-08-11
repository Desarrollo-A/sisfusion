function cleanCommentsAsimilados() {
    var myCommentsList = document.getElementById('comments-list-asimilados');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}

$('body').tooltip({
    selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
    trigger: 'hover',
    container: 'body'
}).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
    $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
});

$(document).ready(function() {
    $("#tabla_asimilados").prop("hidden", true);
    $.post(general_base_url+"/Pagos/lista_roles", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#filtro33").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#filtro33").selectpicker('refresh');
    }, 'json');

});

$('#filtro33').change(function(ruta){
    rol = $('#filtro33').val();
    $("#filtro44").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url +'Pagos/lista_usuarios',
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
                $("#filtro44").append($('<option>').val(id).text(name));
            }
            if(len<=0){
                $("#filtro44").append('<option selected="selected" disabled>NO HAY OPCIONES</option>');
            }
            $("#filtro44").selectpicker('refresh');
        }
    });
});

$('#filtro44').change(function(ruta){
    proyecto = $('#filtro33').val();
    condominio = $('#filtro44').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getAssimilatedCommissions(proyecto, condominio);
});

var totalLeon = 0;
var totalQro = 0;
var totalSlp = 0;
var totalMerida = 0;
var totalCdmx = 0;
var totalCancun = 0;
var tr;
var tabla_asimilados2 ;
var totaPen = 0;
//INICIO TABLA QUERETARO*********************
let titulos = [];

$('#tabla_asimilados thead tr:eq(0) th').each( function (i) {
    if(i != 0){
        var title = $(this).text();
        titulos.push(title);
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
        $('input', this).on('keyup change', function() {
            if ($('#tabla_asimilados').DataTable().column(i).search() !== this.value ) {
                $('#tabla_asimilados').DataTable().column(i).search(this.value).draw();
                var total = 0;
                var index = tabla_asimilados2.rows({
                    selected: true,
                    search: 'applied'
                }).indexes();
                var data = tabla_asimilados2.rows(index).data();
                $.each(data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                document.getElementById("totpagarAsimilados").textContent = formatMoney(numberTwoDecimal(total));
            }
        });
    } 
    else {
        $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
    }
});

function getAssimilatedCommissions(proyecto, condominio){
    $('#tabla_asimilados').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(numberTwoDecimal((total)));
        document.getElementById("totpagarAsimilados").textContent = to;
    });
    $("#tabla_asimilados").prop("hidden", false);
    tabla_asimilados2 = $("#tabla_asimilados").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth: true,
        buttons: [{
            text: '<div class="d-flex"><i class="fa fa-check "></i><p class="m-0 pl-1">Marcar como pagado</p></div>',
            action: function() {
                if ($('input[name="idTQ[]"]:checked').length > 0) {
                    $('#spiner-loader').removeClass('hide');
                    var idcomision = $(tabla_asimilados2.$('input[name="idTQ[]"]:checked')).map(function() {
                        return this.value;
                    }).get();
                    
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
                                $("#totpagarPen").html(formatMoney(0));
                                $("#all").prop('checked', false);
                                var fecha = new Date();
                                $("#myModalEnviadas").modal('toggle');
                                tabla_asimilados2.ajax.reload();
                                $("#myModalEnviadas .modal-body").html("");
                                $("#myModalEnviadas").modal();
                                $("#myModalEnviadas .modal-body").append(`
                                    <center>
                                        <img style='width: 75%; height: 75%;' src="${general_base_url}dist/img/send_intmex.gif">
                                            <p style='color:#676767;'>Comisiones de esquema 
                                                <b>asimilados</b>, fueron marcadas como <b>PAGADAS</b> correctamente.
                                            </p>
                                    </center>`);
                            } else {
                                $('#spiner-loader').addClass('hide');
                                $("#myModalEnviadas").modal('toggle');
                                $("#myModalEnviadas .modal-body").html("");
                                $("#myModalEnviadas").modal();
                                $("#myModalEnviadas .modal-body").append(`
                                    <center>
                                        <P>ERROR AL ENVIAR COMISIONES </P>
                                            <BR><i style='font-size:12px;'>NO SE HA PODIDO EJECUTAR ESTA ACCIÓN, INTÉNTALO MÁS TARDE.</i>
                                        </P>
                                    </center>`);
                                }
                        },
                        error: function( data ){
                            $('#spiner-loader').addClass('hide');
                            $("#myModalEnviadas").modal('toggle');
                            $("#myModalEnviadas .modal-body").html("");
                            $("#myModalEnviadas").modal();
                            $("#myModalEnviadas .modal-body").append(`
                                <center>
                                        <P>ERROR AL ENVIAR COMISIONES </P>
                                        <BR><i style='font-size:12px;'>NO SE HA PODIDO EJECUTAR ESTA ACCIÓN, INTÉNTALO MÁS TARDE.</i>
                                        </P>
                                </center>`);
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
            title: 'ASIMILADOS INTERNOMEX COMISIONES',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx-1] + ' ';
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
                return '<p class="m-0">'+formatMoney(d.comision_total)+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0">'+formatMoney(d.pago_neodata)+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0">'+formatMoney(d.pago_cliente)+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0"><b>'+formatMoney(d.valimpuesto)+'%</b></p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0">'+formatMoney(d.dcto)+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0"><b>'+formatMoney(d.impuesto)+'</b></p>';
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
                var BtnStats;
                if(data.estatus == 8){
                    BtnStats = `
                        <button href="#" value="${data.id_pago_i}" data-value="${data.lote}" data-code="${data.cbbtton}" 
                            class="btn-data btn-blueMaderas consultar_logs_asimilados" title="Detalles"> <i class="fas fa-info">
                            </i>
                        </button>
                        <button href="#" value="${data.id_pago_i}" data-value="${data.id_pago_i}" data-code="${data.cbbtton}"  
                            class="btn-data btn-orangeYellow cambiar_estatus" title="Pausar solicitud"> <i class="fas fa-pause">
                            </i>
                        </button>`;
                }
                else{
                    BtnStats = `
                    <button href="#" value="${data.id_pago_i}" 
                        data-value="${data.lote}" data-code="${data.cbbtton}" 
                        class="btn-data btn-blueMaderas consultar_logs_asimilados"title="Detalles"> 
                            <i class="fas fa-info"></i>
                    </button>
                    <button href="#" value="${data.id_pago_i}" data-value="${data.id_pago_i}" data-code="${data.cbbtton}" 
                        class="btn-data btn-green regresar_estatus" title="Activar solicitud">
                            <i class="fas fa-play"></i>
                    </button>`;
                }
                return `<div class="d-flex"> ${BtnStats} </div>`;
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
                        return `<input type="checkbox" name="idTQ[]" class="individualCheck" style="width:20px;height:20px;"  value=" ${full.id_pago_i} ">`;
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
            url: general_base_url + "Pagos/getDatosNuevasAContraloria/",
            type: "POST",
            cache: false,
            data: {
                proyecto:    proyecto,
                condominio: condominio
            }
        },
    });

    $("#tabla_asimilados tbody").on("click", ".consultar_logs_asimilados", function(e){
        $('#spiner-loader').removeClass('hide');
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").append('<p><h5">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON(general_base_url+"Pagos/getComments/"+id_pago  ).done( function( data ){
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

    $("#tabla_asimilados tbody").on("click", ".cambiar_estatus", function(){
        var tr = $(this).closest('tr');
        var row = tabla_asimilados2.row( tr );
        id_pago_i = $(this).val();

        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de pausar la comisión de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p></div></div>');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="1"><input type="hidden" name="estatus" value="88"><input type="text" class="text-modal observaciones" name="observaciones" rows="3" required placeholder="Describe mótivo por el cual se va activar nuevamente la solicitud"></input></div></div>');
        $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">');
        $("#modal_nuevas .modal-body").append(`<div class="row">
                                                    <div class="col-md-6"></div>
                                                    <div class="d-flex justify-end">
                                                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button>
                                                        <button type="submit" class="btn btn-primary" value="PAUSAR">PAUSAR</button>
                                                    </div>
                                                </div>`);
        $("#modal_nuevas").modal();
    });

    $("#tabla_asimilados tbody").on("click", ".regresar_estatus", function(){
        var tr = $(this).closest('tr');
        var row = tabla_asimilados2.row( tr );
        id_pago_i = $(this).val();

        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de activar la comisión de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p></div></div>');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="2"><input type="hidden" name="estatus" value="8"><input type="text" class="text-modal observaciones"  rows="3" name="observaciones" required placeholder="Describe mótivo por el cual se va activar nuevamente la solicitud"></input></div></div>');
        $("#modal_nuevas .modal-body").append(`<div class="d-flex justify-end">
        <input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">
        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button>
        <button type="submit" class="btn btn-primary" value="ACTIVAR">ACTIVAR</button>
        </div>
    ` );        $("#modal_nuevas").modal();
    });

    /**--------------------------------------------------------------------------------------------- */

}

//FIN TABLA  ****************************************************************************************
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable()
    .columns.adjust();
});

$(window).resize(function(){
    tabla_asimilados2.columns.adjust();
});

function cancela(){
    $("#modal_nuevas").modal('toggle');
}

$("#form_interes").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        console.log(data);
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: general_base_url + "Pagos/despausar_solicitud",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                if( data[0] ){
                    $("#modal_nuevas").modal('toggle' );
                    alerts.showNotification("top", "right", "Se aplicó el cambio exitosamente", "success");
                    setTimeout(function() {
                        tabla_asimilados2.ajax.reload();
                        // tabla_otras2.ajax.reload();
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

function CloseModalDelete2(){
    document.getElementById("form_multiples").reset();
    a = document.getElementById('borrarProyect');
    padre = a.parentNode;
    padre.removeChild(a);
    $("#modal_multiples").modal('toggle');  
}

$(document).on("click", ".Pagar", function() {          
    $("#modal_multiples .modal-body").html("");
    $("#modal_multiples .modal-header").html("");
    $("#modal_multiples .modal-header").append(`<center> <h4 class="card-title"><b>Marcar pagadas</b></h4> </center>`);
    $("#modal_multiples .modal-footer").append(`<div id="borrarProyect">
        
                <button type="button" class="btn btn-danger btn-simple " data-dismiss="modal" onclick="CloseModalDelete2()">CANCELAR</button>
                <button type="submit" disabled id="btn-aceptar" class="btn btn-primary" value="ACEPTAR"> ACEPTAR</button>

        </div>`);

    $("#modal_multiples .modal-header").append(`
    <div class="row">
        <div class="col-md-12">
            <select id="desarrolloSelect" name="desarrolloSelect" 
                class="selectpicker select-gral desarrolloSelect ng-invalid ng-invalid-required" title="SELECCIONA UNA OPCIÓN"
                required data-live-search="true">
            </select>
        </div>
    </div>`);
    
    $.post(general_base_url + 'Pagos/getDesarrolloSelectINTMEX/', {desarrollo: 3 } ,function(data) {
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

        $.getJSON(general_base_url + "Pagos/getPagosByProyect/"+valorSeleccionado+'/'+3).done(function(data) {
            let sumaComision = 0;
            console.log(data[0]);
            if (!data) {
                $("#modal_multiples .modal-body").append('<div class="row"><div class="col-md-12">SIN DATOS A MOSTRAR</div></div>');
                CETF981206BS6-
                CETF981206BS6
            } 
            else {
                if(data.length > 0){
                    $("#modal_multiples .modal-body ").append(`
                    <center>
                        <div class="row bodypagos" >
                            <p style='color:#9D9D9D;'>¿Estas seguro que deseas autorizar $
                            <b style="color:green">${formatMoney(data[0][0].suma)}</b> de ${selected}?</div>
                    </center>
                            `);
                } 
                
                $("#modal_multiples .modal-body ").append(`<div  id="bodypago2"></div>`);
                $.each(data[1], function(i, v) {
                    $("#modal_multiples .modal-body #bodypago2").append(`
                    <input type="hidden" name="ids[]" id="ids" value="${v.id_pago_i}"></div>`);
                    
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

//Función para regresar a estatus 7 la solicitud
$("#form_refresh").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        console.log(data);
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: general_base_url + "Pagos/refresh_solicitud/",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                if( data[0] ){
                    $("#modal_refresh").modal('toggle' );
                    alerts.showNotification("top", "right", "Se ha procesado la solicitud exitosamente", "success");
                    setTimeout(function() {
                        tabla_asimilados2.ajax.reload();
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



function cleanComments(){
    var myCommentsList = document.getElementById('documents');
    myCommentsList.innerHTML = '';

    var myFactura = document.getElementById('facturaInfo');
    myFactura.innerHTML = '';
}

// Selección de CheckBox
$(document).on("click", ".individualCheck", function() {
    totaPen = 0;
    tabla_asimilados2.$('input[type="checkbox"]').each(function () {
        let totalChecados = tabla_asimilados2.$('input[type="checkbox"]:checked') ;
        let totalCheckbox = tabla_asimilados2.$('input[type="checkbox"]');
        if(this.checked){
            tr = this.closest('tr');
            row = tabla_asimilados2.row(tr).data();
            totaPen += parseFloat(row.impuesto); 
        }
        // Al marcar todos los CheckBox Marca CB total
        if( totalChecados.length == totalCheckbox.length )
            $("#all").prop("checked", true);
        else 
            $("#all").prop("checked", false); // si se desmarca un CB se desmarca CB total
    });
    $("#totpagarPen").html(formatMoney(numberTwoDecimal(totaPen)));
});
    // Función de selección total
function selectAll(e) {
    tota2 = 0;
    if(e.checked == true){
        $(tabla_asimilados2.$('input[type="checkbox"]')).each(function (i, v) {
            tr = this.closest('tr');
            row = tabla_asimilados2.row(tr).data();
            tota2 += parseFloat(row.impuesto);
            if(v.checked == false){
                $(v).prop("checked", true);
            }
        }); 
        $("#totpagarPen").html(formatMoney(numberTwoDecimal(tota2)));
    }
    if(e.checked == false){
        $(tabla_asimilados2.$('input[type="checkbox"]')).each(function (i, v) {
            if(v.checked == true){
                $(v).prop("checked", false);
            }
        }); 
        $("#totpagarPen").html(formatMoney(0));
    }
}


$(document).ready( function(){
    $.getJSON( general_base_url + "Pagos/getReporteEmpresa").done( function( data ){
        $(".report_empresa").html();
        $.each( data, function( i, v){
            $(".report_empresa").append('<div class="col xol-xs-3 col-sm-3 col-md-3 col-lg-3"><label style="color: #00B397;">&nbsp;'+v.empresa+': $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #00B397; font-weight: bold;" value="'+formatMoney(v.porc_empresa)+'" disabled="disabled" readonly="readonly" type="text"  name="myText_FRO" id="myText_FRO"></label></div>');
        });
    });
});

$("#form_multiples").submit( function(e) {
    $('#spiner-loader').removeClass('hidden');
    e.preventDefault();
}).validate({

    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        console.log(data);
        $.ajax({
            url: general_base_url + "Pagos/IntMexPagadosByProyect",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                if( data == 1){
                    CloseModalDelete2();
                    alerts.showNotification("top", "right", "Se aplicó el cambio exitosamente", "success");
                }else{
                    CloseModalDelete2();
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                }
                $('#spiner-loader').addClass('hidden');

            },error: function( ){
                CloseModalDelete2();
                alert("ERROR EN EL SISTEMA");
                $('#spiner-loader').addClass('hidden');

            }
        });
    }
});