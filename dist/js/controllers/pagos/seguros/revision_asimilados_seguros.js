var tr;
var tabla_asimilados_seguros ;
var totaPago_asimilados_seguros = 0;
let titulos_seguros = [];

$(document).ready(function() {
    $("#tabla_asimilados_seguros").prop("hidden", true);
    $.post(general_base_url+"Contratacion/lista_proyecto", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#proyectoAsimilados_seguros").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#proyectoAsimilados_seguros").selectpicker('refresh');
    }, 'json');



});

$('#proyectoAsimilados_seguros').change(function(){
residencial = $('#proyectoAsimilados_seguros').val();
$("#condominioAsimilados_seguros").empty().selectpicker('refresh');
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
                $("#condominioAsimilados_seguros").append($('<option>').val(id).text(name));
            }
            $("#condominioAsimilados_seguros").selectpicker('refresh');
        }
    });
});

$('#proyectoAsimilados_seguros').change(function(){
    proyecto = $('#proyectoAsimilados_seguros').val();
    condominio = $('#condominioAsimilados_seguros').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getDataAsimiladosSeguros(proyecto, condominio);
});

$('#condominioAsimilados_seguros').change(function(){
    proyecto = $('#proyectoAsimilados_seguros').val();
    condominio = $('#condominioAsimilados_seguros').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getDataAsimiladosSeguros(proyecto, condominio);
});

$('#tabla_asimilados_seguros thead tr:eq(0) th').each(function (i) {
    if(i != 0){
        var title = $(this).text();
        titulos_seguros.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_asimilados_seguros').DataTable().column(i).search() !== this.value ) {
                $('#tabla_asimilados_seguros').DataTable().column(i).search(this.value).draw();
            }
        });
    }else {
        $(this).html('<input id="all_seguros" type="checkbox" style="width:20px; height:20px;" onchange="selectAllSeguros(this)"/>');
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

function getDataAsimiladosSeguros(proyecto, condominio){
    
    $('#tabla_asimilados_seguros').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(numberTwoDecimal(total));
        document.getElementById("disponibleAsimilados_seguros").textContent = to;
    });

    var modoSubidaSeleccionado = obtenerModoSeleccionado();
    //console.log("prueba");
    //console.log('Valor seleccionado: ' + modoSubidaSeleccionado);
    

    $("#tabla_asimilados_seguros").prop("hidden", false);
    tabla_asimilados_seguros = $("#tabla_asimilados_seguros").DataTable({
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
                            return ' ' + titulos_seguros[columnIdx -1] + ' ';
                        }
                    }
                },
            },
            {
            text: '<i class="fa fa-check"></i> ENVIAR A INTERNOMEX',
            action: function() {
                if ($('input[name="idPagoAsimilados[]"]:checked').length > 0) {
                    $('#spiner-loader').removeClass('hide');
                    var idcomision = $(tabla_asimilados_seguros.$('input[name="idPagoAsimilados[]"]:checked')).map(function() {
                        return this.value;
                    }).get();
                    var com2 = new FormData();
                    com2.append("idcomision", idcomision); 
                    $.ajax({
                        url : general_base_url + 'SegurosComision/updateRevisionaInternomex/',
                        data: com2,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST', 
                        success: function(data){
                            response = JSON.parse(data);
                            if(data == 1) {
                                $('#spiner-loader').addClass('hide');
                                $("#autorizarAsimilados_seguros").html(formatMoney(0));
                                $("#all_seguros").prop('checked', false);
                                var fecha = new Date();
                                tabla_asimilados_seguros.ajax.reload();
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
                    return '<p class="m-0">$'+formatMoney(numberTwoDecimal(d.precio_lote))+'</p>';
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
                    return '<p class="m-0">$'+formatMoney(numberTwoDecimal(d.comision_total))+'</p>';
            }
        },
        {
            data: function( d ){
                if( d.pago_cliente == "" || d.pago_cliente == null)
                    return '<p class="m-0">$0.00</p>'
                else
                    return '<p class="m-0">$'+formatMoney(numberTwoDecimal(d.pago_cliente))+'</p>';
            }
        },
        {
            data: function( d ){
                if( d.solicitado == "" || d.solicitado == null)
                    return '<p class="m-0">$0.00</p>'
                else
                    return '<p class="m-0"><b>$'+formatMoney(numberTwoDecimal(d.solicitado))+'</b></p>';
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
                    return '<p class="m-0"><b>$'+formatMoney(numberTwoDecimal(d.dcto))+'</b></p>';
            }
        },
        {
            data: function( d ){
                if( d.impuesto == "" || d.impuesto == null)
                    return '<p class="m-0">$0.00</p>'
                else
                    return '<p class="m-0"><b>$'+formatMoney(numberTwoDecimal(d.impuesto))+'</b></p>';
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

                const BTN_HISTORIAL = `<button href="#" value="${data.id_pago_i}" data-value='"${data.lote}"' data-code="${data.cbbtton}" class="btn-data btn-blueMaderas consultar_logs_asimilados" data-toggle="tooltip" data-placement="top" title="DETALLES"><i class="fas fa-info"></i></button>`
                const BTN_PAUSAR = `<button href="#" value="${data.id_pago_i}" data-value="${data.id_pago_i}" data-code="${data.cbbtton}" class="btn-data btn-warning cambiar_estatus_seguros" data-toggle="tooltip" data-placement="top" title="PAUSAR LA SOLICITUD"><i class="fas fa-ban"></i></button>`

                btns += BTN_HISTORIAL;
                btns += BTN_PAUSAR;

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
                            return '<input type="checkbox" name="idPagoAsimilados[]" class="checkPagosIndividual" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                    }else{
                        return '';
                    }
                }else{
                    return '';
                }
            },
        }],
        ajax: {
            url: general_base_url + "SegurosComision/getDatosNuevasAsimiladosSeguros/" ,
            type: "POST",
            cache: false,
            data :{
                proyecto : proyecto,
                condominio : condominio
            }
        },
    });

    $('#tabla_asimilados_seguros').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });

    $("#tabla_asimilados_seguros tbody").on("click", ".consultar_logs_asimilados", function(e){
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
        $.getJSON(general_base_url+"Seguros/getComments/"+id_pago).done( function( data ){
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

    $('#tabla_asimilados_seguros').on('click', 'input', function() {
        tr2 = $(this).closest('tr');
        var row = tabla_asimilados_seguros.row(tr2).data();
        if (row.monto == 0) {
            row.monto = row.impuesto;
            totaPago_asimilados_seguros += parseFloat(row.monto);
            tr2.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
        } 
        else {
            totaPago_asimilados_seguros -= parseFloat(row.monto);
            row.monto = 0;
        }
        $("#autorizarAsimilados_seguros").html(formatMoney(numberTwoDecimal(totaPago_asimilados_seguros)));
    });

    $("#tabla_asimilados_seguros tbody").on("click", ".cambiar_estatus_seguros", function(){
        var tr = $(this).closest('tr');
        var row = tabla_asimilados_seguros.row( tr );
        id_pago_i = $(this).val();
        $("#modalPausarAsimiladosSeguros .modal-body").html("");
        $("#modalPausarAsimiladosSeguros .modal-body").append(
            '<div class="row">'+
                '<div class="col-lg-12">'+
                    '<p>¿Está seguro de pausar la comisión de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b>'+
                        '<i>'+row.data().usuario+'</i>?'+
                    '</p>'+
                '</div>'+
            '</div>'+
            '<div class="row">'+
                '<div class="col-lg-12">'+
                    '<input type="text" class="form-control input-gral observaciones" name="observaciones" required placeholder="Describe el motivo por el cual se pausara la solicitud"></input>'+
                '</div>'+
            '</div>'+
            '<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">'+
            '<div class="row">'+
                '<div class="d-flex justify-end">'+
                    '<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button>'+
                    '<button type="submit" class="btn btn-primary" value="PAUSAR" id="btnPausar_seguro">PAUSAR</button>'+
                '</div>'+
            '</div>'
        );
        const buttonPausar_seguro = document.getElementById('btnPausar_seguro');
        buttonPausar_seguro.addEventListener('click', function handleClick() {
            $("#autorizarAsimilados_seguros").html(formatMoney(0));
        });
        $("#modalPausarAsimiladosSeguros").modal();
    });
}

$("#formPausarAsimiladosSeguros").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: general_base_url + "SegurosComision/pausar_solicitudM/",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST',
            success: function(data){
                if( data[0] ){
                    $("#modalPausarAsimiladosSeguros").modal('toggle' );
                    alerts.showNotification("top", "right", "Se ha pausado la comisión exitosamente", "success");
                    setTimeout(function() {
                        tabla_asimilados_seguros.ajax.reload();
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

$(document).on("click", ".checkPagosIndividual", function() {
    totaPago_asimilados_seguros = 0;
    tabla_asimilados_seguros.$('input[type="checkbox"]').each(function () {
        let totalChecados = tabla_asimilados_seguros.$('input[type="checkbox"]:checked') ;
        let totalCheckbox = tabla_asimilados_seguros.$('input[type="checkbox"]');
        if(this.checked){
            tr = this.closest('tr');
            row = tabla_asimilados_seguros.row(tr).data();
            totaPago_asimilados_seguros += parseFloat(row.impuesto); 
        }
        if( totalChecados.length == totalCheckbox.length )
            $("#all_seguros").prop("checked", true);
        else 
            $("#all_seguros").prop("checked", false);
    });
    $("#autorizarAsimilados_seguros").html(formatMoney(numberTwoDecimal(totaPago_asimilados_seguros)));
});
    
function selectAllSeguros(e) {
    tota2 = 0;
    if(e.checked == true){
        $(tabla_asimilados_seguros.$('input[type="checkbox"]')).each(function (i, v) {
            tr = this.closest('tr');
            row = tabla_asimilados_seguros.row(tr).data();
            tota2 += parseFloat(row.impuesto);
            if(v.checked == false){
                $(v).prop("checked", true);
            }
        }); 
        $("#autorizarAsimilados_seguros").html(formatMoney(numberTwoDecimal(tota2)));
    }
    if(e.checked == false){
        $(tabla_asimilados_seguros.$('input[type="checkbox"]')).each(function (i, v) {
            if(v.checked == true){
                $(v).prop("checked", false);
            }
        }); 
        $("#autorizarAsimilados_seguros").html(formatMoney(0));
    }
}
