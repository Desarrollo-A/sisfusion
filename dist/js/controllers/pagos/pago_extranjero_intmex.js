
var tr;
var tabla_remanente2 ;
var totaPen = 0;

$(document).ready(function() {
    $("#tabla_extranjero").prop("hidden", true);
    $.post(general_base_url+"/Contratacion/lista_proyecto", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#catalogoFacturaE").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#catalogoFacturaE").selectpicker('refresh');
    }, 'json');
});

$('#catalogoFacturaE').change(function(ruta){
    residencial = $('#catalogoFacturaE').val();
    $("#condominioFacturaEx").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url+'Pagos/getCondominioDesc/'+residencial,
        type: 'post',
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++){
                var id = response[i]['idCondominio'];
                var name = response[i]['nombre'];
                $("#condominioFacturaEx").append($('<option>').val(id).text(name));
            }
            $("#condominioFacturaEx").selectpicker('refresh');
        }
    });
});

$('#catalogoFacturaE').change(function(ruta){
    proyecto = $('#catalogoFacturaE').val();
    condominio = $('#condominioFacturaEx').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getAssimilatedCommissions(proyecto, condominio);
});

$('#condominioFacturaEx').change(function(ruta){
    proyecto = $('#catalogoFacturaE').val();
    condominio = $('#condominioFacturaEx').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getAssimilatedCommissions(proyecto, condominio);
});

let titulos = [];
$('#tabla_extranjero thead tr:eq(0) th').each( function (i) {
    // if(i != 0){
    //     var title = $(this).text();
    //     titulos.push(title);
    //     $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    //     $('input', this).on('keyup change', function() {
    //         if (tabla_extranjero2.column(i).search() !== this.value) {
    //             tabla_extranjero2.column(i).search(this.value).draw();
    //             var total = 0;
    //             var index = tabla_extranjero2.rows({ selected: true, search: 'applied' }).indexes();
    //             var data = tabla_extranjero2.rows(index).data();
    //             $.each(data, function(i, v) {
    //                 total += parseFloat(v.impuesto);
    //             });
    //             document.getElementById("totpagarextranjero").textcontent = formatMoney(numberTwoDecimal(total));
    //             $('[data-toggle="tooltip"]').tooltip();
    //         }
    //     });
    // }
    // else {
    //     $(this).html('<input id="all" type="checkbox" class="hide" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
    // }
    var title = $(this).text();
    titulos.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');


    if (i == 0){
        $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAllS(this)"/>');
    }else{
        $( 'input', this ).on('keyup change', function () {
            if (tabla_extranjero2.column(i).search() !== this.value ) {
                tabla_extranjero2.column(i).search(this.value).draw();
                var total = 0;
                var index = tabla_extranjero2.rows({ selected: true, search: 'applied' }).indexes();
                var data = tabla_extranjero2.rows( index ).data();
                $.each(data, function(i, v){
                    total += parseFloat(v.abono_bono);
                });
                document.getElementById("myText_nuevas_casas_intmex").textContent = formatMoney(numberTwoDecimal(total));

            }
        });
    }
});

function selectAllS(e) {
    totaPen = 0;
    if(e.checked == true){
        $(tabla_extranjero2.$('input[type="checkbox"]')).each(function (i, v) {
            tr = this.closest('tr');
            row = tabla_extranjero2.row(tr).data();
             totaPen += parseFloat(row.impuesto);
            if(v.checked == false){
                $(v).prop("checked", true);
            }
        }); 
        $("#totpagarPen").html(formatMoney(numberTwoDecimal(totaPen)));
    }
    if(e.checked == false){
        $(tabla_extranjero2.$('input[type="checkbox"]')).each(function (i, v) {
            if(v.checked == true){
                $(v).prop("checked", false);
            }
        }); 
        $("#totpagarPen").html(formatMoney(0));
    }
}

function getAssimilatedCommissions(proyecto, condominio){
    $('#tabla_extranjero').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(numberTwoDecimal(total));
        document.getElementById("totpagarextranjero").textContent = to;
    });

    $("#tabla_extranjero").prop("hidden", false);
    tabla_extranjero2 = $("#tabla_extranjero").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'EXTRANJERO_CONTRALORÍA_SISTEMA_COMISIONES',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15],
                format: {
                    header: function (columnIdx) {
                        return ' ' + titulos[columnIdx-1] + ' ';
                    }
                }
            },
        },
        {
            text: '<div class="d-flex"><i class="fa fa-check "></i><p class="m-0 pl-1">Marcar como pagado</p></div>',
            action: function() {
                if ($('input[name="idTQ[]"]:checked').length > 0) {
                    $('#spiner-loader').removeClass('hide');
                    var idcomision = $(tabla_extranjero2.$('input[name="idTQ[]"]:checked')).map(function() {
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
                                totaPen=0;
                                $("#all").prop('checked', false);
                                tabla_extranjero2.ajax.reload();
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
                    alerts.showNotification("top", "right", "Selecciona una comisión.", "warning");
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
            "orderable": false,
            data: function( data ){

                let btns = '';

                const BTN_DETASI = `<button href="#" value="${data.id_pago_i}" data-value='"${data.lote}"' data-code="${data.cbbtton}" class="btn-data btn-blueMaderas consultar_logs_extranjero" data-toggle="tooltip"  title="Detalles"><i class="fas fa-info"></i></button>`;
                const BTN_PAUASI = `<button href="#" value="${data.id_pago_i}" data-value="${data.id_pago_i}" data-code="${data.cbbtton}" class="btn-data btn-orangeYellow cambiar_estatus" data-toggle="tooltip" title="Pausar solicitud"> <i class="fas fa-pause"></i></button>`;
                const BTN_ACTASI = `<button href="#" value="${data.id_pago_i}" data-value="${data.id_pago_i}" data-code="${data.cbbtton}" class="btn-data btn-green regresar_estatus" data-toggle="tooltip" title="Activar solicitud"><i class="fas fa-play"></i></button>`

                if(data.estatus == 8){
                    btns += BTN_DETASI;
                    btns += BTN_PAUASI;
                }
                else{
                    btns += BTN_DETASI;
                    btns += BTN_ACTASI;
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
                    return '<input type="checkbox" name="idTQ[]" class="checkPagosIndividual" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
           
                }else{
                    return '';
                }
            },
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            "url": general_base_url + "Pagos/getDatosNuevasExContraloria/",
            "type": "POST",
            cache: false,
            data:{
                proyecto:proyecto,
                condominio:condominio
            },
        },
    });

    $("#tabla_extranjero tbody").on("click", ".consultar_logs_extranjero", function(e){
        $('#spiner-loader').removeClass('hide');
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");

        changeSizeModal('modal-md');
        appendBodyModal(`<div class="modal-body">
                        <div role="tabpanel">
                            <ul>
                                <div id="nameLote"></div>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="changelogTab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                                    <ul class="timeline-3" id="comments-list-extranjeros"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanComments()"><b>Cerrar</b></button>
                    </div>`);
        showModal();

        $("#nameLote").append('<p><h5>HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON(general_base_url+"Pagos/getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-extranjeros").append('<li>\n' +
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

    $('#tabla_extranjero').on("click", 'input', function() {
        totaPen = 0;
        tabla_extranjero2.$('input[type="checkbox"]').each(function () {
            let totalChecados = tabla_extranjero2.$('input[type="checkbox"]:checked') ;
            let totalCheckbox = tabla_extranjero2.$('input[type="checkbox"]');
            if(this.checked){
                trs = this.closest('tr');
                row = tabla_extranjero2.row(trs).data();
                totaPen += parseFloat(row.impuesto); 
            }
            if( totalChecados.length == totalCheckbox.length ){
                $("#all").prop("checked", true);
            }else {
                $("#all").prop("checked", false);
            }
        });
        $("#totpagarPen").html(formatMoney(numberTwoDecimal(totaPen)));
    });

    $("#tabla_extranjero tbody").on("click", ".cambiar_estatus", function(){
        var tr = $(this).closest('tr');
        var row = tabla_extranjero2.row( tr );
        id_pago_i = $(this).val();
        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de pausar la comisión de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p></div></div>');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="1"><input type="hidden" name="estatus" value="88"><input type="text" class="text-modal observaciones" name="observaciones" row="3" required placeholder="Describe mótivo por el cual se va activar nuevamente la solicitud"></input></div></div>');
        $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">');
        $("#modal_nuevas .modal-body").append(`<div class="row"><div class="col-md-6"></div><div class="d-flex justify-end"><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button><button type="submit" class="btn btn-primary" value="PAUSAR">PAUSAR</button></div></div>`);
        $("#modal_nuevas").modal();
    });

    $("#tabla_extranjero tbody").on("click", ".regresar_estatus", function(){
        var tr = $(this).closest('tr');
        var row = tabla_extranjero2.row( tr );
        id_pago_i = $(this).val();
        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de activar la comisión de <b>'+row.data().lote+'</b>  para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p></div></div>');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="2"><input type="hidden" name="estatus" value="8"><input type="text" class="text-modal observaciones"  rows="3" name="observaciones" required placeholder="Describe mótivo por el cual se va activar nuevamente la solicitud"></input></div></div>');
        $("#modal_nuevas .modal-body").append(`<div class="d-flex justify-end"><input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'"><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button><button type="submit" class="btn btn-primary" value="ACTIVAR">ACTIVAR</button></div>`);        
        $("#modal_nuevas").modal();
    });

    $("#form_interes").submit( function(e) {
        e.preventDefault();
        }).validate({
        submitHandler: function( form ) {
            $('#spiner-loader').removeClass('hide');
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
                    $("#modal_nuevas").modal('toggle' );
                    alerts.showNotification("top", "right", "Se ha pausado la comisión exitosamente", "success");
                    setTimeout(function() {
                    tabla_extranjero2.ajax.reload();
                    $('#spiner-loader').addClass('hide');
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
}

$('#tabla_factura').ready(function () {
    $('#tabla_factura thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_factura').DataTable().column(i).search() !== this.value ) {
                $('#tabla_factura').DataTable().column(i).search(this.value).draw();
            }
        });
        $('[data-toggle="tooltip"]').tooltip();
    })

    $('#tabla_factura').on('xhr.dt', function (e, settings, json, xhr) {
        let total = 0;
        $.each(json.data, function (i, v) {
            total += parseFloat(v.total);
        });
        document.getElementById('myText_proceso').textContent = `${formatMoney(numberTwoDecimal(total))}`;
    });

    $('#tabla_factura').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COMPROBANTES FISCALES EXTRANJEROS',
            exportOptions: {
                columns: [0,1,2,3,4,5],
                format: {
                    header: function (d, columnIndex) {
                        return ' '+titulos[columnIndex] +' ';
                    }
                }
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
            data: function(d) {
                return `<p class="m-0"><b>${d.id_usuario}</b></p>`;
            }
        },
        {
            data: function(d) {
                return `<p class="m-0">${d.usuario}</p>`;
            }
        },
        {
            data: function(d) {
                return `<p class="m-0">${d.rfc}</p>`;
            }
        },
        {
            data: function (d) {
                return `<p class="m-0">${formatMoney(numberTwoDecimal(d.total))}</p>`;
            }
        },
        {
            data: function (d) {
                return `<p class="m-0">${d.forma_pago}</p>`;
            }
        },
        {
            data: function (d) {
                return `<p class="m-0">${d.nacionalidad}</p>`;
            }
        },
        {
            data: function (d) {
                return `<p class="m-0">${d.estatus_usuario}</p>`;
            }
        },
        {
            data: function (d) {
                return `<div class="d-flex justify-center"><button data-usuario="${d.archivo_name}" class="btn-data btn-blueMaderas consultar-archivo" title="Detalles"><i class="fas fa-file-pdf-o"></i></button></div>`;
            }
        }],
        ajax: {
            "url": general_base_url+"Pagos/getComprobantesExtranjero",
            "type": "GET",
            data: function(d) {}
        },
    });

    $('#tabla_factura tbody').on('click', '.consultar-archivo', function () {
        const $itself = $(this);
        Shadowbox.open({
            content: '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="'+general_base_url+'static/documentos/extranjero/'+$itself.attr('data-usuario')+'"></iframe></div>',
            player: "html",
            title: "Visualizando documento fiscal: " + $itself.attr('data-usuario'),
            width: 985,
            height: 660
        });
    });
});

function resear_formulario(){
    $("#modal_formulario_solicitud input.form-control").prop("readonly", false).val("");
    $("#modal_formulario_solicitud textarea").html('');
    $("#modal_formulario_solicitud #obse").val('');
    var validator = $( "#frmnewsol" ).validate();
    validator.resetForm();
    $( "#frmnewsol div" ).removeClass("has-error");
}

$("#form_colaboradores").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        let sumat=0;
        let valor = parseFloat($('#pago_mktd').val()).toFixed(3);
        let valor1 = parseFloat(valor-0.10);
        let valor2 = parseFloat(valor)+0.010;
        for(let i=0;i<$('#cuantos').val();i++){
            sumat += parseFloat($('#abono_marketing_'+i).val());
        }
        let sumat2 =  parseFloat((sumat).toFixed(3));
        document.getElementById('Sumto').innerHTML= ''+ parseFloat(sumat2.toFixed(3)) +'';
        if(parseFloat(sumat2.toFixed(3)) < valor1){
            alerts.showNotification("top", "right", "Falta dispersar", "warning");
        }
        else{
            if(parseFloat(sumat2.toFixed(3)) >= valor1 && parseFloat(sumat2.toFixed(3)) <= valor2 ){
                $.ajax({
                    url: general_base_url + "pagos/nueva_mktd_comision",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST',
                    success: function(data){
                        if(true){
                            $('#loader').addClass('hidden');
                            $("#modal_colaboradores").modal('toggle');
                            plaza_2.ajax.reload();
                            plaza_1.ajax.reload();
                            alert("¡Se agregó con éxito!");
                        }else{
                            alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                            $('#loader').addClass('hidden');
                        }
                    },error: function( ){
                        alert("ERROR EN EL SISTEMA");
                    }
                });
            }
            else if(parseFloat(sumat2.toFixed(3)) > valor1 && parseFloat(sumat2.toFixed(3)) > valor2 ){
                alerts.showNotification("top", "right", "Cantidad excedida", "danger");
            }
        }
    }
});

$("#frmnewsol").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        data.append("xmlfile", documento_xml);
        $.ajax({
            url: general_base_url + link_post,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST',
            success: function(data){
                if( data.resultado ){
                    alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                    $("#modal_formulario_solicitud").modal( 'toggle' );
                    tabla_nuevas.ajax.reload();
                }else{
                    alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                }
            },error: function(){
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});          

$("#form_MKTD").submit( function(e) {
    e.preventDefault();        
}).validate({
    rules: {
        'porcentajeUserMk[]':{
            required: true,
        }
    },
    messages: {
        'porcentajeUserMk[]':{
            required : "Dato requerido"
        }
    },
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: general_base_url + "Pagos/save_new_mktd",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', 
            success: function(data){
                if( data.resultado ){
                    alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                        $("#modal_mktd").modal( 'toggle' );
                }else{
                    alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                }
            },error: function(){
                alert("ERROR EN EL SISTEMA");
            }
        });   
    }
}); 

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable()
    .columns.adjust();
});