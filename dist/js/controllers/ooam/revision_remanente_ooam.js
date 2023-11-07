var trs;
var tabla_remanente_ooam ;
var totaPenooam = 0;
let titulosOoam = [];

$(document).ready(function() {
    $("#tabla_remanente_ooam").prop("hidden", true);
    $.post(general_base_url + "Contratacion/lista_proyecto", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#catalogoRemOoams").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#catalogoRemOoams").selectpicker('refresh');
    }, 'json');
});

$('#catalogoRemOoams').change(function(ruta){
    residencial = $('#catalogoRemOoams').val();
    $("#condominioRemOoams").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url + 'Asesor/getCondominioDesc/'+residencial,
        type: 'post',
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++){
                var id = response[i]['idCondominio'];
                var name = response[i]['nombre'];
                $("#condominioRemOoams").append($('<option>').val(id).text(name));
            }
            $("#condominioRemOoams").selectpicker('refresh');
        }
    });
});

$('#catalogoRemOoams').change(function(ruta){
    $('#catalogoRemOoams').change(function(ruta){
        proyecto = $('#catalogoRemOoams').val();
        condominio = $('#condominioRemOoams').val();
        if(condominio == '' || condominio == null || condominio == undefined){
            condominio = 0;
        }
        getAssimilatedCommissionsOoam(proyecto, condominio);
    });
});

$('#condominioRemOoams').change(function(ruta){
    proyecto = $('#catalogoRemOoams').val();
    condominio = $('#condominioRemOoams').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getAssimilatedCommissionsOoam(proyecto, condominio);

});

$('#tabla_remanente_ooam thead tr:eq(0) th').each(function (i) {
    if(i != 0){
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_remanente_ooam').DataTable().column(i).search() !== this.value ) {
                $('#tabla_remanente_ooam').DataTable().column(i).search(this.value).draw();
            }
        });
    }else {
        $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
    }
});

function getAssimilatedCommissionsOoam(proyecto, condominio){
    $('#tabla_remanente_ooam').on('xhr.dt', function(e, settings, json, xhr) {
        var totalooam = 0;
        $.each(json.data, function(i, v) {
            totalooam += parseFloat(v.impuesto);
        });
        var toooam = formatMoney(numberTwoDecimal(totalooam));
        document.getElementById("totpagarremanente").textContent = toooam;
    });

    $("#tabla_remanente_ooam").prop("hidden", false);
    tabla_remanente_ooam = $("#tabla_remanente_ooam").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REMANENTE_CONTRALORÍA_SISTEMA_COMISIONES',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulosOoam[columnIdx] + ' ';
                    }
                }
            },
        },
        {
            text: '<i class="fa fa-check"></i> ENVIAR A INTERNOMEX',
            action: function() {
                if ($('input[name="idTQ[]"]:checked').length > 0) {
                    $('#spiner-loader').removeClass('hide');
                    var idcomision = $(tabla_remanente_ooam.$('input[name="idTQ[]"]:checked')).map(function() {
                        return this.value;
                    }).get();
                    
                    var com2 = new FormData();
                    com2.append("idcomision", idcomision); 
                    $.ajax({
                        url : general_base_url + 'pagos/acepto_internomex_remanente/',
                        data: com2,
                        cache: false,
                        contentType: false,
                        processData: false, 
                        type: 'POST', 
                        success: function(data){
                            response = JSON.parse(data);
                            if(data == 1) {
                                $('#spiner-loader').addClass('hide');
                                $("#totpagarPenOoam").html(formatMoney(0));
                                $("#all").prop('checked', false);
                                var fecha = new Date();
                                tabla_remanente_ooam.ajax.reload();
                                modalInformation(1);
                            }
                            else {
                                modalInformation(0);
                            }
                        },
                        error: function( data ){
                            modalInformation(0);
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
                if(d.precio_lote == "" || d.precio_lote == null)
                    return '<p class="m-0">$0.00</p>';
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
                if(d.comision_total == "" || d.comision_total == null)
                    return '<p class="m-0">$0.00</p>';
                else
                    return '<p class="m-0">'+formatMoney(numberTwoDecimal(d.comision_total))+'</p>';
            }
        },
        {
            data: function( d ){
                if(d.pago_neodata == "" || d.pago_neodata == null)
                    return '<p class="m-0">$0.00</p>';
                else
                    return '<p class="m-0">'+formatMoney(numberTwoDecimal(d.pago_neodata))+'</p>';
            }
        },
        {
            data: function( d ){
                if (d.impuesto == "" || d.impuesto == null)
                    return '<p class="m-0">$0.00</p>';
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
                return '<p class="m-0">'+d.fecha_creacion+'</p>';
                
            }
        },
        {
            "orderable": false,
            data: function( data ){
                let btns = '';

                const BTN_HISTORIAL = `<button href="#" value="${data.id_pago_i}" data-value="${data.lote}" data-code="${data.cbbtton}" 
                class="btn-data btn-blueMaderas consultar_logs_remanente_ooam" data-toggle="tooltip"  data-placement="top" title="DETALLES"><i class="fas fa-info"></i></button>`;
                const BTN_PAUSAR = `<button href="#" value="${data.id_pago_i}" data-value="${data.id_pago_i}" data-code="${data.cbbtton}" 
                class="btn-data btn-warning cambiar_estatus_ooam" id="cambiar_estatus_ooam" data-toggle="tooltip"  data-placement="top" title="PAUSAR LA SOLICITUD"><i class="fas fa-ban"></i></button>`;
                
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
            "url": general_base_url + "Pagos/getDatosNuevasRContraloria/" ,
            "type": "POST",
            data: {
                "proyecto":    proyecto,
                "condominio":   condominio,
            },
            cache: false,
            
        },
    });

    $("#tabla_remanente_ooam tbody").on("click", ".consultar_logs_remanente_ooam", function(e){
        $('#spiner-loader').removeClass('hide');
        $("#comments-list-asimilados").html('');
        $("#nameLote").html('');
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        
        changeSizeModal('modal-md');
        appendBodyModal(`<div class="modal-body m-0">
                        <div role="tabpanel">
                            <div id="nameLote" class="text-center"></div>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="changelogTab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content scroll-styles pt-0" style="height: 350px; overflow: auto">
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
        $.getJSON(general_base_url+"Pagos/getComments/" +id_pago ).done( function( data ){
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
                '        <p class="m-0"><small>Usuario: </small><b> ' + v.nombre_usuario.toUpperCase() + '</b></p>\n'+
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

    $("#tabla_remanente_ooam tbody").on("click", ".cambiar_estatus_ooam", function(){
        var tr = $(this).closest('tr');
        var row = tabla_remanente_ooam.row( tr );
        id_pago_i = $(this).val();
        $("#modal_nuevas .modal-footer").html("");
        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-body").append(`
            <div class="row">  
                <center>
                <div class="col-lg-12">
                    <p>¿Está seguro de pausar la comisión de <b>${row.data().lote}</b> para el <b>${(row.data().puesto).toUpperCase()}:</b> <i>${row.data().usuario}</i>?</p>
                </div>
                </center>
            </div>`);
        $("#modal_nuevas .modal-body").append(`
            <div class="row">
                <div class="col-lg-12">
                    <input type="hidden" name="value_pago" value="1">
                    <input type="hidden" name="estatus" value="6">
                    <input type="text" class="form-control input-gral" name="observaciones" required placeholder="Describe mótivo por el cual se va pausar nuevamente la solicitud"></input>
                </div>
            </div>`);
        $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">');
        $("#modal_nuevas .modal-footer").append(`
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button>
                <button type="submit" class="btn btn-primary"" value="PAUSAR">PAUSAR</button>
            `);
        const buttonPausar = document.getElementById('cambiar_estatus_ooam');
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
            url: general_base_url + "Pagos/despausar_solicitud/",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST',
            success: function(data){
                $('#spiner-loader').removeClass('hide');
                if( data[0] ){
                    $("#modal_nuevas").modal('toggle' );
                    alerts.showNotification("top", "right", "Se ha pausado la comisión exitosamente", "success");
                    setTimeout(function() {
                        tabla_remanente_ooam.ajax.reload();
                    }, 3000);
                    $('#spiner-loader').addClass('hide');
                }else{
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                    $('#spiner-loader').addClass('hide');
                }
            },error: function( ){
                alert("ERROR EN EL SISTEMA");
                $('#spiner-loader').addClass('hide');
            }
        });
    $("#totpagarPen").html(formatMoney(0));
    }
});

$(document).on("click", ".individualCheck", function() {
    totaPen = 0;
    tabla_remanente_ooam.$('input[type="checkbox"]').each(function () {
        let totalChecados = tabla_remanente_ooam.$('input[type="checkbox"]:checked') ;
        let totalCheckbox = tabla_remanente_ooam.$('input[type="checkbox"]');
        if(this.checked){
            tr = this.closest('tr');
            row = tabla_remanente_ooam.row(tr).data();
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
        $(tabla_remanente_ooam.$('input[type="checkbox"]')).each(function (i, v) {
            tr = this.closest('tr');
            row = tabla_remanente_ooam.row(tr).data();
            tota2 += parseFloat(row.impuesto);
            if(v.checked == false){
                $(v).prop("checked", true);
            }
        }); 
        $("#totpagarPen").html(formatMoney(numberTwoDecimal(tota2)));
    }
    if(e.checked == false){
        $(tabla_remanente_ooam.$('input[type="checkbox"]')).each(function (i, v) {
            if(v.checked == true){
                $(v).prop("checked", false);
            }
        }); 
        $("#totpagarPen").html(formatMoney(0));
    }
}

