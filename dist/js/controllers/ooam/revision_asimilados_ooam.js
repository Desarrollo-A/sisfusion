var trs;
let tabla_ooam2 ;
var totaPens = 0;
let titulosOoam = [];

$(document).ready(function() {
    $("#tabla_ooam").prop("hidden", true);
    $.post(general_base_url+"Contratacion/lista_proyecto", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#catalogoAsiOoam").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#catalogoAsiOoam").selectpicker('refresh');
    }, 'json');
});

$('#catalogoAsiOoam').change(function(){
    residencial = $('#catalogoAsiOoam').val();
    $("#condominioAsiOoam").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url+'Asesor/getCondominioDesc/'+residencial,
        type: 'post',
        dataType: 'json',
        success:function(response){
            var len = response.length;
            for( var i = 0; i<len; i++){
                var id = response[i]['idCondominio'];
                var name = response[i]['nombre'];
                $("#condominioAsiOoam").append($('<option>').val(id).text(name));
            }
            $("#condominioAsiOoam").selectpicker('refresh');
        }
    });
});

$('#catalogoAsiOoam').change(function(){
    proyecto = $('#catalogoAsiOoam').val();
    condominio = $('#condominioAsiOoam').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getAssimilatedCommissionsOoam(proyecto, condominio);
});

$('#condominioAsiOoam').change(function(){
    proyecto = $('#catalogoAsiOoam').val();
    condominio = $('#condominioAsiOoam').val();
    if(condominio == '' || condominio == null || condominio == undefined){
        condominio = 0;
    }
    getAssimilatedCommissionsOoam(proyecto, condominio);
});

$('#tabla_ooam thead tr:eq(0) th').each(function (i) {
    if(i != 0){
        var title = $(this).text();
        titulosOoam.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_ooam').DataTable().column(i).search() !== this.value ) {
                $('#tabla_ooam').DataTable().column(i).search(this.value).draw();
        }
        });
    }else {
        $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAllOoam(this)"/>');
    }
});

function getAssimilatedCommissionsOoam(proyecto, condominio){
    $('#tabla_ooam').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(numberTwoDecimal(total));
        document.getElementById("totpagarAsimilados").textContent = to;
    });

    $("#tabla_ooam").prop("hidden", false);
    tabla_ooam2 = $("#tabla_ooam").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                title: 'Asimilados contraloría',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosOoam[columnIdx-1] + ' ';
                        }
                    }
                },
            },
            {
            text: '<i class="fa fa-check"></i> ENVIAR A INTERNOMEX',
            action: function() {
                if ($('input[name="idTQOoam[]"]:checked').length > 0) {
                    $('#spiner-loader').removeClass('hide');
                    var idcomision = $(tabla_ooam2.$('input[name="idTQOoam[]"]:checked')).map(function() {
                        return this.value;
                    }).get();
                    var com2 = new FormData();
                    com2.append("idcomision", idcomision); 
                    $.ajax({
                        url : general_base_url + 'Ooam/acepto_internomex_asimilados/',
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
                                $("#myModalEnviadas").modal('toggle');
                                tabla_ooam2.ajax.reload();
                                $("#myModalEnviadas .modal-body").html("");
                                $("#myModalEnviadas").modal();
                                $("#myModalEnviadas .modal-body").append(`
                                    <center><img style="width: 75%; height: 75%;" 
                                        src="${general_base_url}dist/img/send_intmex.gif">
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
                                $("#myModalEnviadas .modal-body").append(`
                                <center>
                                    <P>ERROR AL ENVIAR COMISIONES </P>
                                    <BR>
                                    <i style='font-size:12px;'>NO SE HA PODIDO EJECUTAR ESTA ACCIÓN, INTÉNTALO MÁS TARDE.</i>
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
                                </center> `);
                        }
                    });
                }else{
                    alerts.showNotification("top", "right", "Favor de seleccionar un bono activo .", "warning");
                }
            },
            attr: {
                class: 'btn btn-azure',
                style: 'position: relative;',
            }
            }
        ],
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
                if(d.precio_lote == "" || d.precio_lote == null )
                    return '<p class="m-0"> $0.00 </p>'
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
                if(d.comision_total == "" || d.comision_total == null )
                    return '<p class="m-0"> $0.00 </p>'
                else
                    return '<p class="m-0">'+formatMoney(numberTwoDecimal(d.comision_total))+'</p>';
            }
        },
        {
            data: function( d ){
                if(d.pago_neodata == "" || d.pago_neodata == null )
                    return '<p class="m-0"> $0.00 </p>'
                else
                    return '<p class="m-0">'+formatMoney(numberTwoDecimal(d.pago_neodata))+'</p>';
            }
        },
        {
            data: function( d ){
                if(d.pago_cliente == "" || d.pago_cliente == null )
                    return '<p class="m-0"> $0.00 </p>'
                else
                    return '<p class="m-0">'+formatMoney(numberTwoDecimal(d.pago_cliente))+'</p>';
            }
        },
        {
            data: function( d ){
                return '<p class="m-0"><b>'+d.valimpuesto+'%</b></p>';
            }
        },
        {
            data: function( d ){
                if(d.dcto == "" || d.dcto == null )
                    return '<p class="m-0"> $0.00 </p>'
                else
                    return '<p class="m-0">'+formatMoney(numberTwoDecimal(d.dcto))+'</p>';
            }
        },
        {
            data: function( d ){
                if(d.impuesto == "" || d.impuesto == null )
                    return '<p class="m-0"> $0.00 </p>'
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
                return '<p class="m-0"><b>'+d.codigo_postal+'</b></i></p>';
            }
        },
        {
            data: function( d ){
                return   '<p class="m-0">'+d.fecha_creacion+'</p>';
            }
        },
        {
            "orderable": false,
            data: function( data ){
                let btns = '';
                
                const BTN_HISTORIAL = `<button href="#" value="${data.id_pago_i}" data-value="${data.lote}" data-code="${data.cbbtton}" class="btn-data btn-blueMaderas consultar_logs_asimilados" data-toggle="tooltip"  data-placement="top" title="DETALLES"><i class="fas fa-info"></i></button>`;
                const BTN_PAUSAR = `<button href="#" value="${data.id_pago_i}" data-value="${data.id_pago_i}" data-code="${data.cbbtton}" class="btn-data btn-warning cambiar_estatus" id="cambiar_estatus" data-toggle="tooltip"  data-placement="top" title="PAUSAR LA SOLICITUD"><i class="fas fa-ban"></i></button>`;

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
                        return '<input type="checkbox" name="idTQOoam[]" class="individualCheckOoam" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
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
            url: general_base_url + "Ooam/getDatosNuevasAContraloria/",
            type: "POST",
            data: {
                    proyecto:    proyecto,
                    condominio: condominio
                },
            cache: false,
        },
    });

    $('#tabla_ooam').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $("#tabla_ooam tbody").on("click", ".consultar_logs_asimilados", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        $("#comments-list-asimilados").html('');
        $("#nameLote").html('');
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        changeSizeModal('modal-md');
        appendBodyModal(`<div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons" onclick="cleanCommentsAsimilados()">clear</i>
                        </button>
                    </div>
                    <div class="modal-body">
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
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsAsimilados()"><b>Cerrar</b></button>
                    </div>`);
        showModal();
        
        $("#nameLote").append('<p><h5">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON(general_base_url+"Ooam/getComments/"+id_pago).done( function( data ){
        $('#spiner-loader').addClass('hide');
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
        });
        $('#spiner-loader').removeClass('hide');
    });

    $("#tabla_ooam tbody").on("click", ".cambiar_estatus", function(){
        var trs = $(this).closest('trs');
        var row = tabla_ooam2.row( trs );
        id_pago_i = $(this).val();
        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-body").append(
            '<div class="row">'+
                '<div class="col-lg-12">'+
                    '<p>¿Está seguro de pausar la comisión de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p>'+
                '</div>'+
            '</div>'+
            '<div class="row">'+
                '<div class="col-lg-12">'+
                    '<input type="hidden" name="value_pago" value="1">'+
                    '<input type="hidden" name="estatus" value="6">'+
                    '<input type="text" class="form-control input-gral observaciones mb-1" name="observaciones" required placeholder="Describe mótivo por el cual se va pausar nuevamente la solicitud"></input>'+
                '</div>'+
            '</div>'+
            '<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">'+
            '<div class="row">'+
                '<div class="d-flex justify-end">'+
                    '<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button>'+
                    '<button type="submit" class="btn btn-primary" value="PAUSAR">PAUSAR</button>'+
            '</div>'
            );
        const buttonPausar = document.getElementById('cambiar_estatus');
        buttonPausar.addEventListener('click', function handleClick() {
            $("#totpagarPenOoam").html(formatMoney(0));
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
            url: general_base_url + "Ooam/despausar_solicitud/",
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
                        tabla_ooam2.ajax.reload();
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

$(document).on("click", ".individualCheckOoam", function() {
    totaPens = 0;
    tabla_ooam2.$('input[type="checkbox"]').each(function () {
        let totalChecados = tabla_ooam2.$('input[type="checkbox"]:checked') ;
        let totalCheckbox = tabla_ooam2.$('input[type="checkbox"]');
        if(this.checked){
            trs = this.closest('trs');
            row = tabla_ooam2.row(trs).data();
            totaPens += parseFloat(row.impuesto); 
        }
        if( totalChecados.length == totalCheckbox.length )
            $("#all").prop("checked", true);
        else 
            $("#all").prop("checked", false);
    });
    $("#totpagarPenOoam").html(formatMoney(numberTwoDecimal(totaPens)));
});

function selectAllOoam(e) {
    tota2 = 0;
    if(e.checked == true){
        $(tabla_ooam2.$('input[type="checkbox"]')).each(function (i, v) {
            trs = this.closest('trs');
            row = tabla_ooam2.row(trs).data();
            tota2 += parseFloat(row.impuesto);
            if(v.checked == false){
                $(v).prop("checked", true);
            }
        }); 
        $("#totpagarPenOoam").html(formatMoney(numberTwoDecimal(tota2)));
    }
    if(e.checked == false){
        $(tabla_ooam2.$('input[type="checkbox"]')).each(function (i, v) {
            if(v.checked == true){
                $(v).prop("checked", false);
            }
        }); 
        $("#totpagarPenOoam").html(formatMoney(0));
    }
}