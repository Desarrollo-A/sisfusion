var totaPen = 0;
var tr;

$.post(general_base_url + "Comisiones/listSedes", function (data) {
    var len = data.length;
    for (var i = 0; i < len -1; i++) {
        var id = data[i]['id_sede'];
        var name = data[i]['nombre'];
        $("#plaza1").append($('<option>').val(id).text(name.toUpperCase()));
        $("#plaza2").append($('<option>').val(id).text(name.toUpperCase()));
    }
    $("#plaza1").selectpicker('refresh');
    $("#plaza2").selectpicker('refresh');
}, 'json');

$("#tabla_nuevas_comisiones").ready(function() {
    let titulos = [];
    $('#tabla_nuevas_comisiones thead tr:eq(0) th').each( function (i) {
        if(i != 0){
            var title = $(this).text();
            titulos.push(title);

            $(this).html('<input type="text"  class="textoshead" placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function() {

                if (tabla_nuevas.column(i).search() !== this.value) {
                    tabla_nuevas.column(i).search(this.value).draw();
                    var total = 0;
                    var index = tabla_nuevas.rows({ selected: true, search: 'applied' }).indexes();
                    var data = tabla_nuevas.rows(index).data();
                    $.each(data, function(i, v) {
                        total += parseFloat(v.pago_cliente);
                    });
                    var to1 = formatMoney(total);
                    document.getElementById("myText_nuevas").value = to1;
                }
            });
        }
    });

    $('#tabla_nuevas_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.pago_cliente);
        });
        var to = formatMoney(total);
        document.getElementById("myText_nuevas").value = to;
    });

    tabla_nuevas = $("#tabla_nuevas_comisiones").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'COMISIONES NUEVAS COBRANZA MKTD',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                format: {
                    header:  function (d, columnIdx) {
                        if(columnIdx == 0){
                            return ' '+d +' ';
                        }
                        else if(columnIdx == 14){
                            return 'ESTATUS';
                        }
                        else if(columnIdx != 14 && columnIdx !=0){
                            if(columnIdx == 12){
                                return 'SEDE BASE';
                            }
                            else{
                                return ' '+titulos[columnIdx-1] +' ';
                            }
                        }
                    }
                }
            },
        },
        {
            text: ' REGIÓN MARICELA',
            className: 'btn-large btn-orangeYellow',
            action: function() {
                if ($('input[name="idT[]"]:checked').length > 0) {
                    var idcomision = $(tabla_nuevas.$('input[name="idT[]"]:checked')).map(function() {
                        return this.value;
                    }).get();
                    $.get(general_base_url + "Comisiones/asigno_region_dos/" + idcomision).done(function() {                            
                        tabla_nuevas.ajax.reload();
                        mensaje = "COMISIONES ASIGNADAS A REGIÓN 2 - <b>MARICELA RICO</b> PARA SU REVISIÓN.";
                        modalInformation(RESPUESTA_MODAL.SUCCESS, mensaje);
                    });
                }
            },
        }, 
        {
            text: ' REGIÓN FERNANDA',
            className: 'btn-large btn-blueMaderas',
            action: function() {
                if ($('input[name="idT[]"]:checked').length > 0) {
                    var idcomision = $(tabla_nuevas.$('input[name="idT[]"]:checked')).map(function() {
                        return this.value;
                    }).get();
                    $.get(url + "Comisiones/asigno_region_uno/" + idcomision).done(function(){
                        tabla_nuevas.ajax.reload();
                        mensaje = "COMISIONES ASIGNADAS A REGIÓN 1 - <b>MARIA FERNANDA LICEA</b> PARA SU REVISIÓN.";
                        modalInformation(RESPUESTA_MODAL.SUCCESS, mensaje);
                    });
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
            "data": function( d ){
                return '<p class="m-0">'+d.id_lote+'</p>';
            }
        },
        {  
            "data": function( d ){
                return '<p class="m-0">'+d.id_pago_i+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.id_lote+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.lote+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.precio_lote)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.comision_total)+' </p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.pago_neodata)+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+formatMoney(d.pago_cliente)+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+formatMoney(d.pagado)+'</p>';
            }
        },
        {
            "data": function(d) {
                if (d.restante == null || d.restante == '') {
                    return '<p class="m-0">' + formatMoney(d.comision_total) + '</p>';
                } else {
                    return '<p class="m-0">' + formatMoney(d.restante) + '</p>';
                }
            }
        },
        {
            "data": function( d ){
                let fech = d.fechaApartado;
                let fecha = fech.substr(0, 10);
                let nuevaFecha = fecha.split('-');
                return '<p class="m-0">'+nuevaFecha[2]+'-'+nuevaFecha[1]+'-'+nuevaFecha[0]+'</p>';
            }
        },
        {
            "data": function( d ){
                if(d.bonificacion >= 1){
                    p1 = '<p title="Lote con bonificación en NEODATA"><span class="label" style="background:pink;color: black;">Bon. '+formatMoney(d.bonificacion)+'</span></p>';
                }
                else{
                    p1 = '';
                }

                if(d.lugar_prospeccion == 0){
                    p2 = '<p title="Lote con cancelación de CONTRATO"><span class="label" style="background:crimson;">Recisión</span></p>';
                }
                else{
                    p2 = '';
                }

                return p1 + p2;;
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.nombre+'</p>';
            }
        } ,
        {
            "data": function( d ){
                if(d.idc_mktd == null){
                    if (d.ubicacion_dos == null) {
                        return '<p color:crimson;"><b>Sin lugar de venta asignado</b></p>';
                    }else {
                        return '<p>' + d.ubicacion_dos + '</p>';
                    }
                }else{
                    return '<span class="label label-warning">Compartida</span><br><br>'+'<p><b>' +d.sd1+' / '+d.sd2+ '</b></p>';
                }
            }
        },
        {
            "data": function( d ){
                var lblStats;
                    if(d.idc_mktd == null){
                        if (d.ubicacion_dos == null) {
                            if(d.estatus==1) {
                                lblStats ='<span class="label label-danger">Sin validar</span>';
                            }else if(d.estatus==41 || d.estatus == 42) {
                                lblStats ='<span class="label" style="background:dodgerblue;">ENVIADA A REGIÓN 2</span>';
                            }else if(d.estatus==61 || d.estatus==62) {
                                lblStats ='<span class="label" style="background:crimson;">RECHAZO REGIÓN 2</span>';
                            }
                            else{
                                lblStats ='<span class="label label-danger">NA</span>';
                            }
                        }
                        else{
                            if(d.estatus==41 || d.estatus == 42) {
                                lblStats ='<span class="label" style="background:dodgerblue;">ENVIADA A REGIÓN 2</span>';
                            }else if(d.estatus==61 || d.estatus == 62) {
                                lblStats ='<span class="label" style="background:crimson;">RECHAZO REGIÓN 2</span>';
                            }else if(d.estatus==51 || d.estatus==52 ||d.estatus==1) {
                                lblStats ='<div class="d-flex justify-center"><button class="btn-data btn-green aprobar_solicitud" title="ENVIAR A DIRECTOR MKTD" value="' + d.id_pago_i +'" data-value="' + d.id_sede +'"><i class="material-icons">done</i></button></div>';
                            }
                            else{
                                lblStats ='<span class="label label-danger">NA</span>';
                            }
                        }
                    }
                    else{
                        lblStats = '<div class="d-flex justify-center"><button class="btn-data btn-green aprobar_solicitud" title="ENVIAR A DIRECTOR MKTD" value="' + d.id_pago_i +'" data-value="' + d.id_sede +'"><i class="material-icons">done</i></button></div>';
                    }
                return lblStats;
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
            'searchable': false,
            'className': 'dt-body-center',
            'render': function(d, type, full, meta) {
                if((full.ubicacion_dos != '' || full.ubicacion_dos != 0 ) && full.estatus != 41 && full.estatus != 42 ){ 
                    return '<input type="checkbox" name="idT[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                }else{
                    return '';
                }
            }
        }],
        ajax: {
            "url": general_base_url + "Comisiones/getDatosNuevasMktd_pre",
            "type": "POST",
            cache: false,
            "data": function(d) {}
        },
        order: [
            [1, 'asc']
        ]
    });

    $('#tabla_nuevas_comisiones').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });

    $("#tabla_nuevas_comisiones tbody").on("click", ".aprobar_solicitud", function(){
    var tr = $(this).closest('tr');
    var row = tabla_nuevas.row(tr);
    let c=0;
    $("#modal_colaboradores .modal-body").html("");
    $("#modal_colaboradores .modal-footer").html("");
    $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Desea aprobar los pagos de comisiones para el lote: <b>'+row.data().lote+'</b>?</p> </div></div>');
    $("#modal_colaboradores .modal-body").append('<input type="hidden" id="id_pago" name="pago_id" value="'+row.data().id_pago_i+'">');
    $("#modal_colaboradores .modal-body").append('<input type="hidden" id="id_lote" name="id_lote" value="'+row.data().idLote+'">');
    $("#modal_colaboradores .modal-body").append('<input type="hidden" id="precio_lote" name="precio_lote" value="'+row.data().precio_lote+'">');
    $("#modal_colaboradores .modal-body").append('<input type="hidden" id="id_comision" name="com_value" value="'+row.data().id_comision+'">');
    $("#modal_colaboradores .modal-footer").append('<br><div class="row"><div class="col-md-6"><center><input type="submit" class="btn btn-success" value="Aprobar"></center></div><div class="col-md-6"><center><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>');
    $("#modal_colaboradores").modal();
    });

    $("#tabla_nuevas_comisiones tbody").on("click", ".compartir_mktd", function(){
    var lote =  $(this).val();
    $("#modal_mktd .modal-footer").html("");
    $("#modal_mktd .modal-footer").append(`<input type="hidden" value="${lote}" id="idlote" name="idlote">`);
    $("#modal_mktd .modal-footer").append('<br><div class="row"><div class="col-md-6"><center><input type="submit" class="btn btn-success" value="GUARDAR"></center></div><div class="col-md-6"><center><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>');
    $("#modal_mktd").modal();
    });

    $('#tabla_nuevas_comisiones').on('click', 'input', function() {
        tr = $(this).closest('tr');
        var row = tabla_nuevas.row(tr).data();

        if (row.pa == 0) {
            row.pa = row.pago_cliente;
            totaPen += parseFloat(row.pa);
            tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
        } 
        else {
            totaPen -= parseFloat(row.pa);
            row.pa = 0;
        }
        document.getElementById("totpagarPen").value = formatMoney(totaPen);
    });

    $("#tabla_nuevas_comisiones tbody").on("click", ".consultar_logs_asimilados", function() {
        id_pago = $(this).val();
        user = $(this).attr("data-usuario");
        $("#seeInformationModalAsimilados").modal();
        $.getJSON("getComments/" + id_pago + "/" + user).done(function(data) {
            counter = 0;
            $.each(data, function(i, v) {
                counter++;
                $("#comments-list-asimilados").append('<li class="timeline-inverted">\n' +
                '    <div class="timeline-badge info"></div>\n' +
                '    <div class="timeline-panel">\n' +
                '            <label><h6>' + v.nombre_usuario + '</h6></label>\n' +
                '            <br>' + v.comentario + '\n' +
                '        <h6>\n' +
                '            <span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> ' + v.fecha_movimiento + '</span>\n' +
                '        </h6>\n' +
                '    </div>\n' +
                '</li>');
            });
        });
    });
});

$(window).resize(function() {
    tabla_nuevas.columns.adjust();
});

let c = 0;
function saveX() {
    save2();
}

$("#form_mktd").submit( function(e) {
    e.preventDefault();
    var plaza1 = $('#plaza1').val();
    var plaza2=$('#plaza2').val();
    var id_lote=$('#idlote').val();

    if( plaza1 == plaza2){
        alerts.showNotification("top", "right", "Las plazas seleccionadas son iguales.", "warning");
    }
    else{

        $.ajax({
            type: "POST",
            url: general_base_url + "Comisiones/MKTD_compartida",
            data: {id_lote: id_lote, plaza1: plaza1,plaza2:plaza2},
            dataType: 'json',
            success: function(data){
                if(data == 1){
                    $("#modal_mktd").modal('toggle');
                        tabla_nuevas.ajax.reload();
                        alerts.showNotification("top", "right", "Registro agregado con exito.", "success");
                }else if(data == 3){
                    $("#modal_mktd").modal('toggle');
                    alerts.showNotification("top", "right", "No se puede aplicar el ajuste porque ya se hicieron pagos individuales anteriormente.", "warning");
                }
            },error: function( ){
                alerts.showNotification("top", "right", "Las plazas seleccionadas son iguales.", "danger");
            }
        });
    }   
})

$("#form_colaboradores").submit( function(e) {
    e.preventDefault();
    var id_pago = $('#id_pago').val();
    var id_comision=$('#id_comision').val();
    var precio_lote=$('#precio_lote').val();
    var id_lote=$('#id_lote').val();
    $.ajax({
        type: "POST",
        url: general_base_url + "Comisiones/aprobar_comision",
        data: {id_pago: id_pago, id_comision: id_comision, precio_lote: precio_lote, id_lote: id_lote},
        dataType: 'json',
        success: function(data){
            $("#modal_colaboradores").modal('toggle');
            tabla_nuevas.ajax.reload();
            alert("¡Se envío con éxito a Director de MKTD!");
        },error: function( ){
            alert("ERROR EN EL SISTEMA");
        }
    });     
})