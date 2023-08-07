$('#tabla_remanentes').on('click', 'input', function() {
    tr = $(this).closest('tr');
    var row = tabla_remanentes.row(tr).data();
    if ($(this).prop('checked')) totaPen += row.impuesto;
    else totaPen -= row.impuesto;
    $("#totpagarPen").html(formatMoney(totaPen));
});
let titulos_intxt = [];
$('#tabla_asimilados thead tr:eq(0) th').each( function (i) {
    if(i != 0){
        var title = $(this).text();
        titulos_intxt.push(title);
        $(this).html(`<input type="text" class="textoshead w-100" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
        $('input', this).on('keyup change', function() {
            if (tabla_asimilados.column(i).search() !== this.value) {
                tabla_asimilados.column(i).search(this.value).draw();
                var total = 0;
                var index = tabla_asimilados.rows({
                selected: true,
                search: 'applied'
            }).indexes();
                var data = tabla_asimilados.rows(index).data();
                $.each(data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                
                document.getElementById("totpagarAsimilados").textContent = formatMoney(total);
            }
        });
    } 
    else {
        $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
    }
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});
$('#tabla_asimilados').on('xhr.dt', function(e, settings, json, xhr) {
    var total = 0;
    $.each(json, function(i, v) {
        total += parseFloat(v.impuesto);
    });
    var to = formatMoney(total);
    document.getElementById("totpagarAsimilados").textContent = to;
});

$(document).on("click", ".individualCheck", function() {
    var totaPen = 0;
    let totalChecados = tabla_asimilados.$('input[type="checkbox"]:checked') ;
    let totalCheckbox = tabla_asimilados.$('input[type="checkbox"]');
    tabla_asimilados.$('input[type="checkbox"]').each(function () {
        
        if(this.checked){
            tr = this.closest('tr');
            row = tabla_asimilados.row(tr).data();
            totaPen += row.impuesto;
        }
        // Al marcar todos los CheckBox Marca CB total
        if( totalChecados.length == totalCheckbox.length )
            $("#all").prop("checked", true);
        else 
            $("#all").prop("checked", false);
    });
    $("#totpagarPen").html(formatMoney(totaPen));
});

function selectAll(e) {
    tota2 = 0;
    if(e.checked == true){
        $(tabla_asimilados.$('input[type="checkbox"]')).each(function (i, v) {
            tr = this.closest('tr');
            row = tabla_asimilados.row(tr).data();
            tota2 += parseFloat(row.impuesto);
            if(v.checked == false){
                $(v).prop("checked", true);
            }
        }); 
        $("#totpagarPen").html(formatMoney(tota2));
    }
    if(e.checked == false){
        $(tabla_asimilados.$('input[type="checkbox"]')).each(function (i, v) {
            if(v.checked == true){
                $(v).prop("checked", false);
            }
        }); 
        $("#totpagarPen").html(formatMoney(0));
    }
}
tabla_asimilados = $("#tabla_asimilados").DataTable({
    dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: '100%',
    scrollX:true,
    buttons: [{
        text: '<i class="fa fa-check"></i> ENVIAR A INTERNOMEX',
        action: function() {
            if ($('input[name="idTQ[]"]:checked').length > 0) {
                $('#spiner-loader').removeClass('hide');
                var idcomision = $(tabla_asimilados.$('input[name="idTQ[]"]:checked')).map(function() {
                    return this.value;
                }).get();
                var com2 = new FormData();
                com2.append("idcomision", idcomision); 
                $.ajax({
                    url : general_base_url + 'Suma/aceptoInternomexAsimilados/',
                    data: com2,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST', 
                    success: function(data){
                        if(data) {
                            $('#spiner-loader').addClass('hide');
                            $("#totpagarPen").html(formatMoney(0));
                            $("#all").prop('checked', false);
                            var fecha = new Date();
                            $("#myModalEnviadas").modal('toggle');
                            tabla_asimilados.ajax.reload();
                            $("#myModalEnviadas .modal-body").html("");
                            $("#myModalEnviadas").modal();
                            $("#myModalEnviadas .modal-body").append("<center><img style='width: 75%; height: 75%;' src='"+general_base_url+"dist/img/send_intmex.gif'><p style='color:#676767;'>Comisiones de esquema <b>asimilados</b>, fueron enviadas a <b>INTERNOMEX</b> correctamente.</p></center>");
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
            }
        },
        attr: {
            class: 'btn btn-azure',
            style: 'position: relative; float: right;',
        }
    },
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo de Excel',
        title: 'ASIMILADOS COMISIONES',
        exportOptions: {
            columns: [1,2,3,4,5,6,7,8],
            format: {
                header: function (d, columnIdx) {
                    return ' ' + titulos_intxt[columnIdx -1] + ' ';
                }
            }
        },
    }],
    pagingType: "full_numbers",
    fixedHeader: true,
    language: {
        url: general_base_url + "static/spanishLoader_v2.json",
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
        "data": function(d) {
            return '<p class="m-0">' + d.id_pago_suma + '</p>';
        }
    },
    {
        
        "data": function(d) {
            return '<p class="m-0">' + d.referencia + '</p>';
        }
    },
    {
        "data": function(d) {
            return '<p class="m-0"><b>' + d.nombreComisionista + '</b></p>';
        }
    },
    {
        "data": function(d) {
            return '<p class="m-0"><b>' + d.sede + '</b></p>';
        }
    },
    {
        "data": function(d) {
            return '<p class="m-0">' + formatMoney(d.total_comision) + '</p>';
        }
    },
    {
        "data": function(d) {
            return '<p class="m-0">' + formatMoney(d.impuesto) + '</p>';
        }
    },
    {
        "data": function(d) {
            return '<p class="m-0"><b>' + d.porcentaje_comision + '%</b></p>';
        }
    },
    {
        "data": function(d) {
            return '<p class="m-0"><b>' + d.estatusString + '</b></p>';
        }
    },
    {
        "orderable": false,
        "data": function( data ){
            var BtnStats;
            BtnStats = `<button href="#" value="${data.id_pago_suma}"  data-referencia="${data.referencia}" class="btn-data btn-blueMaderas consultar_logs_asimilados" data-toggle="tooltip" data-placement="top" title="HISTORIAL"><i class="fas fa-info"></i></button>
            <button href="#" value="${data.id_pago_suma}" data-value="${data.id_pago_suma}" class="btn-data ${(data.estatus == 2)? 'btn-warning cambiar_estatus': 'btn-green cambiar_estatus'}" data-toggle="tooltip" data-placement="top"  title="${(data.estatus == 2) ? 'PAUSAR LA SOLICITUD': 'ACTIVAR LA SOLICITUD' }">${(data.estatus == 2) ? '<i class="fas fa-pause"></i>' : '<i class="fas fa-play"></i>'}</button>`;
            return '<div class="d-flex justify-center">'+BtnStats+'</div>';
        }
    }],
    columnDefs: [{
        orderable: false,
        className: 'select-checkbox',
        targets:   0,
        searchable:false,
        className: 'dt-body-center',
        render: function (d, type, full, meta){
            if(full.estatus == 2){
                if(full.referencia){
                    return '<input type="checkbox" name="idTQ[]" class="individualCheck" style="width:20px;height:20px;"  value="' + full.id_pago_suma + '">';
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
        url: general_base_url + "Suma/getRevision",
        data: {formaPago:3},
        type: "POST",
        dataType: 'json',
        dataSrc: ""
    },
    initComplete: function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    },
});
$("#tabla_asimilados tbody").on("click", ".consultar_logs_asimilados", function(e){
    e.preventDefault();
    e.stopImmediatePropagation();
    id_pago = $(this).val();
    referencia = $(this).attr("data-referencia");
    $("#seeInformationModalAsimilados").modal();
    $("#nameLote").html("");
    $("#comments-list-asimilados").html("");
    $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DE LA REFERENCIA <b style="color:#39A1C0; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+referencia+'</b></h5></p>');
    $.getJSON("getHistorial/"+id_pago).done( function( data ){
        $.each( data, function(i, v){
            $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><b>' + v.comentario + '</b></a><br></div><div class="float-end text-right"><a>'+v.fecha_movimiento+'</a></div><div class="col-md-12"><p class="m-0"><small>MODIFICADO POR: </small><b> ' +v.modificado_por+ '</b></p></div><h6></h6></div></div></li>');
        });
    });
});
$("#tabla_asimilados tbody").on("click", ".cambiar_estatus", function(){
    var tr = $(this).closest('tr');
    var row = tabla_asimilados.row( tr );
    id_pago_i = $(this).val();
    $("#modal_nuevas .modal-body").html("");
    $("#modal_nuevas .modal-body").append(`<div class="row"><div class="col-lg-12"><p class="text-center">¿Estás seguro de ${(row.data().estatus == 4 || row.data().estatus == 5) ? 'activar' : 'pausar'} la comisión con referencia <b>${row.data().referencia}</b> para <b>${(row.data().nombreComisionista).toUpperCase()}</b>?</p></div></div>`);
    $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="estatus" value="'+row.data().estatus+'"><input type="text" class="form-control input-gral observaciones" name="observaciones" required placeholder="Describe motivo para el cambio de estatus de esta solicitud"></input></div></div>');
    $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+id_pago_i+'">');
    $("#modal_nuevas .modal-body").append('<div class="modal-footer"><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button><input type="submit" class="btn btn-primary"></div>');
    $("#modal_nuevas").modal();
});

$("#form_interes").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: general_base_url + "Suma/setPausarDespausarComision/",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST',
            success: function(data){
                if(data){
                    $("#modal_nuevas").modal('toggle' );
                    alerts.showNotification("top", "right", "Se ha procesado la solicitud exitosamente", "success");
                    setTimeout(function() {
                        tabla_asimilados.ajax.reload();
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
$(window).resize(function(){
    tabla_asimilados.columns.adjust();
});
