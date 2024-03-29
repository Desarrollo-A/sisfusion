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
    $("#tabla_asimilados_ooam").prop("hidden", true);
    $.post(general_base_url+"/Pagos/lista_roles", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#puestoOoam").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#puestoOoam").selectpicker('refresh');
    }, 'json');

});

$('#puestoOoam').change(function(ruta){
    rol = $('#puestoOoam').val();
    $("#UsuarioOoam").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url +'Ooam/lista_usuarios',
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
                $("#UsuarioOoam").append($('<option>').val(id).text(name));
            }
            if(len<=0){
                $("#UsuarioOoam").append('<option selected="selected" disabled>NO HAY OPCIONES</option>');
            }
            $("#UsuarioOoam").selectpicker('refresh');
        }
    });
});

$('#UsuarioOoam').change(function(ruta){
    proyecto = $('#puestoOoam').val();
    condominio = $('#UsuarioOoam').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getAssimilatedCommissionsOOAM(proyecto, condominio);
});

var tr;
var tabla_asimilados_ooam ;
var totaPen = 0;
//INICIO TABLA QUERETARO
let titulosooam = [];

$('#tabla_asimilados_ooam thead tr:eq(0) th').each( function (i) {
    if(i != 0){
        var title = $(this).text();
        titulosooam.push(title);
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
        $('input', this).on('keyup change', function() {
            if ($('#tabla_asimilados_ooam').DataTable().column(i).search() !== this.value ) {
                $('#tabla_asimilados_ooam').DataTable().column(i).search(this.value).draw();
                var total = 0;
                var index = tabla_asimilados_ooam.rows({
                    selected: true,
                    search: 'applied'
                }).indexes();
                var data = tabla_asimilados_ooam.rows(index).data();
                $.each(data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                document.getElementById("totpagarAsimilados").textContent = formatMoney(numberTwoDecimal(total));
            }
        });
    } 
    else {
        $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAllOOAM(this)"/>');
    }
});

function getAssimilatedCommissionsOOAM(proyecto, condominio){
    $('#tabla_asimilados_ooam').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(numberTwoDecimal((total)));
        document.getElementById("totpagarAsimilados").textContent = to;
    });
    $("#tabla_asimilados_ooam").prop("hidden", false);
    tabla_asimilados_ooam = $("#tabla_asimilados_ooam").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [{
            text: '<div class="d-flex"><i class="fa fa-check "></i><p class="m-0 pl-1">Marcar como pagado</p></div>',
            action: function() {
                if ($('input[name="idTQOOAM[]"]:checked').length > 0) {
                    $('#spiner-loader').removeClass('hide');
                    var idcomision = $(tabla_asimilados_ooam.$('input[name="idTQOOAM[]"]:checked')).map(function() {
                        return this.value;
                    }).get();
                    
                    var com2 = new FormData();
                    com2.append("idcomision", idcomision); 
                    $.ajax({
                        url : general_base_url + 'Ooam/pago_internomex/',
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
                                tabla_asimilados_ooam.ajax.reload();
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
                        return ' ' + titulosooam[columnIdx-1] + ' ';
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
                        return `<input type="checkbox" name="idTQOOAM[]" class="individualCheckOOAM" style="width:20px;height:20px;"  value=" ${full.id_pago_i} ">`;
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
            url: general_base_url + "Ooam/getRevisionAsimiladosOOAM/",
            type: "POST",
            cache: false,
            data: {
                proyecto:    proyecto,
                condominio: condominio
            }
        },
    });

    $("#tabla_asimilados_ooam tbody").on("click", ".consultar_logs_asimilados", function(e){
        $('#spiner-loader').removeClass('hide');
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").append('<p><h5">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON(general_base_url+"Ooam/getComments/"+id_pago  ).done( function( data ){
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

    $("#tabla_asimilados_ooam tbody").on("click", ".cambiar_estatus", function(){
        var tr = $(this).closest('tr');
        var row = tabla_asimilados_ooam.row( tr );
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

    $("#tabla_asimilados_ooam tbody").on("click", ".regresar_estatus", function(){
        var tr = $(this).closest('tr');
        var row = tabla_asimilados_ooam.row( tr );
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
    tabla_asimilados_ooam.columns.adjust();
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
            url: general_base_url + "Ooam/despausar_solicitud",
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
                        tabla_asimilados_ooam.ajax.reload();
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

function CloseModalDeleteOoam(){
    document.getElementById("form_multiplesOoam").reset();
    a = document.getElementById('borrarProyect');
    padre = a.parentNode;
    padre.removeChild(a);
    $("#modal_multiplesOoam").modal('toggle');  
}

$(document).on("click", ".PagarOoam", function() {      
    $("#modal_multiplesOoam .modal-body").html("");
    $("#modal_multiplesOoam .modal-header").html("");
    $("#modal_multiplesOoam .modal-header").append(`<center> <h4 class="card-title"><b>Marcar pagadas</b></h4> </center>`);
    $("#modal_multiplesOoam .modal-footer").append(`<div id="borrarProyect">
        
                <button type="button" class="btn btn-danger btn-simple " data-dismiss="modal" onclick="CloseModalDeleteOoam()">CANCELAR</button>
                <button type="submit" disabled id="btn-aceptar" class="btn btn-primary" value="ACEPTAR"> ACEPTAR</button>

        </div>`);

    $("#modal_multiplesOoam .modal-header").append(`
    <div class="row">
        <div class="col-md-12">
            <select id="desarrolloSelectOoam" name="desarrolloSelectOoam" 
                class="selectpicker select-gral desarrolloSelectOoam ng-invalid ng-invalid-required" title="SELECCIONA UNA OPCIÓN"
                required data-live-search="true">
            </select>
        </div>
    </div>`);
    
    $.post(general_base_url + 'Ooam/getDesarrolloSelectINTMEX/', {desarrollo: 3 } ,function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['name_user'];
            $("#desarrolloSelectOoam").append($('<option>').val(id).attr('data-value', id).text(name));
        }
        if (len <= 0) {
            $("#desarrolloSelectOoam").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#desarrolloSelectOoam").val(0);
        $("#desarrolloSelectOoam").selectpicker('refresh');
    }, 'json');
        
    $('#desarrolloSelectOoam').change(function() {
        $("#modal_multiplesOoam .modal-body .bodypagos").html("");
        if(document.getElementById('bodypago2')){
            let a =  document.getElementById('bodypago2');
            padre = a.parentNode;
            padre.removeChild(a);
        }
    
        var valorSeleccionado = $(this).val();
        var combo = document.getElementById("desarrolloSelectOoam");
        var selected = combo.options[combo.selectedIndex].text;

        $.getJSON(general_base_url + "Ooam/getPagosByProyect/"+valorSeleccionado+'/'+3).done(function(data) {
            let sumaComision = 0;
            console.log(data[0]);
            if (!data) {
                $("#modal_multiplesOoam .modal-body").append('<div class="row"><div class="col-md-12">SIN DATOS A MOSTRAR</div></div>');
            } 
            else {
                if(data.length > 0){
                    $("#modal_multiplesOoam .modal-body ").append(`
                    <center>
                        <div class="row bodypagos" >
                            <p style='color:#9D9D9D;'>¿Estas seguro que deseas autorizar $
                            <b style="color:green">${formatMoney(data[0][0].suma)}</b> de ${selected}?</div>
                    </center>
                            `);
                } 
                
                $("#modal_multiplesOoam .modal-body ").append(`<div  id="bodypago2"></div>`);
                $.each(data[1], function(i, v) {
                    $("#modal_multiplesOoam .modal-body #bodypago2").append(`
                    <input type="hidden" name="ids[]" id="ids" value="${v.id_pago_i}"></div>`);
                    
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

//Función para regresar a estatus 7 la solicitud
$("#form_refresh").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        console.log(data);
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: general_base_url + "Ooam/refresh_solicitud/",
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
                        tabla_asimilados_ooam.ajax.reload();
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
$(document).on("click", ".individualCheckOOAM", function() {
    totaPen = 0;
    tabla_asimilados_ooam.$('input[type="checkbox"]').each(function () {
        let totalChecados = tabla_asimilados_ooam.$('input[type="checkbox"]:checked') ;
        let totalCheckbox = tabla_asimilados_ooam.$('input[type="checkbox"]');
        if(this.checked){
            tr = this.closest('tr');
            row = tabla_asimilados_ooam.row(tr).data();
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
function selectAllOOAM(e) {
    tota2 = 0;
    if(e.checked == true){
        $(tabla_asimilados_ooam.$('input[type="checkbox"]')).each(function (i, v) {
            tr = this.closest('tr');
            row = tabla_asimilados_ooam.row(tr).data();
            tota2 += parseFloat(row.impuesto);
            if(v.checked == false){
                $(v).prop("checked", true);
            }
        }); 
        $("#totpagarPen").html(formatMoney(numberTwoDecimal(tota2)));
    }
    if(e.checked == false){
        $(tabla_asimilados_ooam.$('input[type="checkbox"]')).each(function (i, v) {
            if(v.checked == true){
                $(v).prop("checked", false);
            }
        }); 
        $("#totpagarPen").html(formatMoney(0));
    }
}


$(document).ready( function(){
    $.getJSON( general_base_url + "Ooam/getReporteEmpresa").done( function( data ){
        $(".report_empresa").html();
        $.each( data, function( i, v){
            $(".report_empresa").append('<div class="col xol-xs-3 col-sm-3 col-md-3 col-lg-3"><label style="color: #00B397;">&nbsp;'+v.empresa+': $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #00B397; font-weight: bold;" value="'+formatMoney(v.porc_empresa)+'" disabled="disabled" readonly="readonly" type="text"  name="myText_FRO" id="myText_FRO"></label></div>');
        });
    });
});

$("#form_multiplesOoam").submit( function(e) {
    $('#spiner-loader').removeClass('hidden');
    e.preventDefault();
}).validate({

    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        console.log(data);
        $.ajax({
            url: general_base_url + "Ooam/IntMexPagadosByProyect",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                if( data == 1){
                    tabla_asimilados_ooam.ajax.reload();
                    CloseModalDeleteOoam();
                    alerts.showNotification("top", "right", "Se aplicó el cambio exitosamente", "success");

                }else{
                    CloseModalDeleteOoam();
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                }
                $('#spiner-loader').addClass('hidden');

            },error: function( ){
                CloseModalDeleteOoam();
                alert("ERROR EN EL SISTEMA");
                $('#spiner-loader').addClass('hidden');

            }
        });
    }
});