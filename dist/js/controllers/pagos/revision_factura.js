var tr;
var tabla_remanente2 ;
var totaPen = 0;
let titulos = [];

$(document).ready(function() {
    $("#tabla_factura").prop("hidden", true);
    $.post(general_base_url+"Contratacion/lista_proyecto", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#catalogoFac").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#catalogoFac").selectpicker('refresh');
    }, 'json');
});

$('#catalogoFac').change(function(){
residencial = $('#catalogoFac').val();
$("#condominioFac").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url+'Asesor/getCondominioDesc/'+residencial,
        type: 'post',
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++)
            {
                var id = response[i]['idCondominio'];
                var name = response[i]['nombre'];
                $("#condominioFac").append($('<option>').val(id).text(name));
            }
            $("#condominioFac").selectpicker('refresh');
        }
    });
});

$('#catalogoFac').change(function(){
    proyecto = $('#catalogoFac').val();
    condominio = $('#condominioFac').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getAssimilatedCommissions(proyecto, condominio);
});

$('#condominioFac').change(function(){
    proyecto = $('#catalogoFac').val();
    condominio = $('#condominioFac').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getAssimilatedCommissions(proyecto, condominio);
});

$('#tabla_factura thead tr:eq(0) th').each(function (i) {
    if(i != 0){
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_factura').DataTable().column(i).search() !== this.value ) {
                $('#tabla_factura').DataTable().column(i).search(this.value).draw();
            }
        });
    }else {
        $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
    }
});

function getAssimilatedCommissions(proyecto, condominio){
    $('#tabla_factura').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(numberTwoDecimal(total));
        document.getElementById("totpagarremanente").textContent =to;
    });

    $("#tabla_factura").prop("hidden", false);
    tabla_remanente2 = $("#tabla_factura").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title:'Comisiones nuevas factura',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx -1] + ' ';
                        }
                    }
                },
            },
            {
            text: '<i class="fa fa-check"></i> ENVIAR A INTERNOMEX',
            action: function() {
                if ($('input[name="idTQ[]"]:checked').length > 0) {
                    $('#spiner-loader').removeClass('hide');
                    var idcomision = $(tabla_remanente2.$('input[name="idTQ[]"]:checked')).map(function() {
                        return this.value;
                    }).get();
                    var com2 = new FormData();
                    com2.append("idcomision", idcomision); 
                    $.ajax({
                        url : general_base_url + 'Pagos/acepto_internomex_remanente/',
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
                                tabla_remanente2.ajax.reload();
                                $("#myModalEnviadas .modal-body").html("");
                                $("#myModalEnviadas").modal();
                                $("#myModalEnviadas .modal-body").append(`
                                    <center>
                                        <img style='width: 75%; height: 75%;' src="${general_base_url}dist/img/send_intmex.gif" >
                                            <p style='color:#676767;'>Comisiones de esquema 
                                                <b>asimilados</b>, fueron enviadas a 
                                                <b>INTERNOMEX</b> correctamente.
                                            </p>
                                    </center>`);
                            }
                            else {
                                $('#spiner-loader').addClass('hide');
                                $("#myModalEnviadas").modal('toggle');
                                $("#myModalEnviadas .modal-body").html("");
                                $("#myModalEnviadas").modal();
                                $("#myModalEnviadas .modal-body").append("<center><P>ERROR AL ENVIAR COMISIONES </P><BR><i style='font-size:12px;'>NO SE HA PODIDO EJECUTAR ESTA ACCIÓN, INTÉNTALO MÁS TARDE.</i></P></center>");
                            }
                        },
                        error: function( data ){
                            $('#spiner-loader').addClass('hide');
                            $("#myModalEnviadas").modal('toggle');
                            $("#myModalEnviadas .modal-body").html("");
                            $("#myModalEnviadas").modal();
                            $("#myModalEnviadas .modal-body").append("<center><P>ERROR AL ENVIAR COMISIONES </P><BR><i style='font-size:12px;'>NO SE HA PODIDO EJECUTAR ESTA ACCIÓN, INTÉNTALO MÁS TARDE.</i></P></center>");
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
                if( d.pago_neodata == "" || d.pago_neodata == null)
                    return '<p class="m-0">$0.00</p>'
                else
                    return '<p class="m-0">'+formatMoney(numberTwoDecimal(d.pago_neodata))+'</p>';
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
            "orderable": false,
            data: function( data ){
                let btns = '';

                const BTN_HISTORIAL = `<button href="#" value="${data.id_pago_i}" data-value="${data.lote}" data-code="${data.cbbtton}" class="btn-data btn-blueMaderas consultar_logs_factura" data-toggle="tooltip" data-placement="top" title="DETALLES"><i class="fas fa-info"></i></button>`
                const BTN_PAUSAR = `<button href="#" value="${data.id_pago_i}" data-value="${data.id_pago_i}" data-code="${data.cbbtton}" class="btn-data btn-warning cambiar_estatus" data-toggle="tooltip" data-placement="top" title="PAUSAR LA SOLICITUD"><i class="fas fa-ban"></i></button>`

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
                            return '<input type="checkbox" name="idTQ[]" class="individualCheck" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                    }else{
                        return '';
                    }
                }else{
                    return '';
                }
            },
        }],
        ajax: {
            url: general_base_url + "pagos/getDatosNuevasFContraloria/" ,
            type: "POST",
            cache: false,
            data :{
                proyecto : proyecto,
                condominio : condominio,
            }
        },
    });

    $('#tabla_factura').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $("#tabla_factura tbody").on("click", ".consultar_logs_factura", function(e){
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
        $.getJSON(general_base_url+"Pagos/getComments/"+id_pago).done( function( data ){
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

    $('#tabla_factura').on('click', 'input', function() {
        tr = $(this).closest('tr');
        var row = tabla_remanente2.row(tr).data();
        if (row.pa == 0) {
            row.pa = row.impuesto;
            totaPen += parseFloat(row.pa);
            tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
        } 
        else {
            totaPen -= parseFloat(row.pa);
            row.pa = 0;
        }
        $("#totpagarPen").html(formatMoney(numberTwoDecimal(totaPen)));
    });

    $("#tabla_factura tbody").on("click", ".cambiar_estatus", function(){
        var tr = $(this).closest('tr');
        var row = tabla_remanente2.row( tr );
        id_pago_i = $(this).val();
        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-body").append(
            '<div class="row">'+
                '<div class="col-lg-12">'+
                    '<p>¿Está seguro de pausar la comisión de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b>'+
                        '<i>'+row.data().usuario+'</i>?'+
                    '</p>'+
                '</div>'+
            '</div>'+
            '<div class="row">'+
                '<div class="col-lg-12">'+
                    '<input type="text" class="form-control input-gral observaciones" name="observaciones" required placeholder="Describe el mótivo por el cual se pausara la solicitud"></input>'+
                '</div>'+
            '</div>'+
            '<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">'+
            '<div class="row">'+
                '<div class="d-flex justify-end">'+
                    '<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button>'+
                    '<button type="submit" class="btn btn-primary" value="PAUSAR" id="btnPausar">PAUSAR</button>'+
                '</div>'+
            '</div>'
        );
        const buttonPausar = document.getElementById('btnPausar');
        buttonPausar.addEventListener('click', function handleClick() {
            $("#totpagarPen").html(formatMoney(0));
        });
        $("#modal_nuevas").modal();
    });
}

$("#form_interes").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: general_base_url + "pagos/pausar_solicitudM/",
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
                        tabla_remanente2.ajax.reload();
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

$(document).on("click", ".individualCheck", function() {
    totaPen = 0;
    tabla_remanente2.$('input[type="checkbox"]').each(function () {
        let totalChecados = tabla_remanente2.$('input[type="checkbox"]:checked') ;
        let totalCheckbox = tabla_remanente2.$('input[type="checkbox"]');
        if(this.checked){
            tr = this.closest('tr');
            row = tabla_remanente2.row(tr).data();
            totaPen += parseFloat(row.impuesto); 
        }
        if( totalChecados.length == totalCheckbox.length )
            $("#all").prop("checked", true);
        else 
            $("#all").prop("checked", false);
    });
    $("#totpagarPen").html(formatMoney(numberTwoDecimal(totaPen)));
});
    
function selectAll(e) {
    tota2 = 0;
    if(e.checked == true){
        $(tabla_remanente2.$('input[type="checkbox"]')).each(function (i, v) {
            tr = this.closest('tr');
            row = tabla_remanente2.row(tr).data();
            tota2 += parseFloat(row.impuesto);
            if(v.checked == false){
                $(v).prop("checked", true);
            }
        }); 
        $("#totpagarPen").html(formatMoney(numberTwoDecimal(tota2)));
    }
    if(e.checked == false){
        $(tabla_remanente2.$('input[type="checkbox"]')).each(function (i, v) {
            if(v.checked == true){
                $(v).prop("checked", false);
            }
        }); 
        $("#totpagarPen").html(formatMoney(0));
    }
}
