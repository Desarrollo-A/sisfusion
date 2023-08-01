function cleanCommentsremanente() {
    var myCommentsList = document.getElementById('comments-list-remanente');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}
var totalLeon = 0;
var totalQro = 0;
var totalSlp = 0;
var totalMerida = 0;
var totalCdmx = 0;
var totalCancun = 0;
var tr;
var tabla_especial2 ;
var totaPen = 0;
let titulos = [];

//INICIO TABLA QUERETARO*************************************
$('#tabla_especial thead tr:eq(0) th').each( function (i) {
    if(i != 0){
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>');
        $('input', this).on('keyup change', function() {
            if (tabla_especial2.column(i).search() !== this.value) {
                tabla_especial2
                .column(i)
                .search(this.value)
                .draw();

                var total = 0;
                var index = tabla_especial2.rows({
                selected: true,
                search: 'applied'
            }).indexes();

                var data = tabla_especial2.rows(index).data();
                $.each(data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });

                var to1 = formatMoney(total);
                document.getElementById("totpagarremanente").textcontent = formatMoney(total);
            }
        });
    }
    else {
        $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
    }
});

$(document).ready(function getAssimilatedCommissions(){
    $('#tabla_especial').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(total);
        document.getElementById("totpagarremanente").textContent = '$' + to;
    });

    $("#tabla_especial").ready("hidden", false);
    tabla_especial2 = $("#tabla_especial").DataTable({
        dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: 'auto',
        buttons: [{
            text: '<i class="fa fa-check"></i> MARCAR COMO PAGADA',
            action: function() {
                if ($('input[name="idTQ[]"]:checked').length > 0) {
                    $('#spiner-loader').removeClass('hide');
                    var idcomision = $(tabla_especial2.$('input[name="idTQ[]"]:checked')).map(function() {
                        return this.value;
                    }).get();
                    
                    var com2 = new FormData();
                    com2.append("idcomision", idcomision); 
                    $.ajax({
                        url : general_base_url + 'Pagos/acepto_internomex_especial/',
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
                                tabla_especial2.ajax.reload();
                                $("#myModalEnviadas .modal-body").html("");
                                $("#myModalEnviadas").modal();
                                $("#myModalEnviadas .modal-body").append(`
                                    <center>
                                        <img style='width: 75%; height: 75%;' src="${general_base_url}dist/img/send_intmex.gif">
                                            <p style='color:#676767;'>
                                                Comisiones de ventas especiales, se marcaron como pagadas correctamente.
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
                    alerts.showNotification("top", "right", "No se han seleccionado comisiones.", "warning");
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
            title: 'REMANENTE_CONTRALORÍA_SISTEMA_COMISIONES',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                format: {
                    header:  function (d, columnIdx) {
                        if(columnIdx == 0){
                            return ' '+d +' ';
                        }else if(columnIdx == 1){
                            return 'ID PAGO';
                        }else if(columnIdx == 2){
                            return 'PROYECTO';
                        }else if(columnIdx == 3){
                            return 'CONDOMINIO';
                        }else if(columnIdx == 4){
                            return 'NOMBRE LOTE ';
                        }else if(columnIdx == 5){
                            return 'REFERENCIA';
                        }else if(columnIdx == 6){
                            return 'PRECIO LOTE';
                        }else if(columnIdx == 7){
                            return 'EMPRESA';
                        }else if(columnIdx == 8){
                            return 'TOT. COMISIÓN';
                        }else if(columnIdx == 9){
                            return 'P. CLIENTE';
                        }else if(columnIdx == 10){
                            return 'TOT. PAGAR';
                        }else if(columnIdx == 11){
                            return 'TIPO VENTA';
                        }else if(columnIdx == 12){
                            return 'COMISIONISTA';
                        }else if(columnIdx == 13){
                            return 'PUESTO';
                        }else if(columnIdx == 14){
                            return 'FECH. ENVÍO';
                        }
                        else if(columnIdx != 15 && columnIdx !=0){
                            return ' '+titulos[columnIdx-1] +' ';
                        }
                    }
                }
            },
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
            "width": "3%" },
        {
            "width": "5%",
            "data": function( d ){
                return '<p class="m-0">'+d.id_pago_i+'</p>';
            }
        },
        {
            "width": "5%",
            "data": function( d ){
                return '<p class="m-0">'+d.proyecto+'</p>';
            }
        },
        {
            "width": "7%",
            "data": function( d ){
                return '<p class="m-0">'+d.condominio+'</p>';
            }
        },
        {
            "width": "7%",
            "data": function( d ){
                return '<p class="m-0"><b>'+d.lote+'</b></p>';
            }
        },
        {
            "width": "7%",
            "data": function( d ){
                return '<p class="m-0">'+d.referencia+'</p>';
            }
        },
        {
            "width": "7%",
            "data": function( d ){
                return '<p class="m-0">$'+formatMoney(d.precio_lote)+'</p>';
            }
        },
        {
            "width": "5%",
            "data": function( d ){
                return '<p class="m-0"><b>'+d.empresa+'</p>';
            }
        },
        {
            "width": "7%",
            "data": function( d ){
                return '<p class="m-0">$'+formatMoney(d.comision_total)+'</p>';
            }
        },
        {
            "width": "5%",
            "data": function( d ){
                return '<p class="m-0">$'+formatMoney(d.pago_neodata)+'</p>';
            }
        },

        {
            "width": "7%",
            "data": function( d ){
                return '<p class="m-0"><b>$'+formatMoney(d.impuesto)+'</b></p>';
            }
        },
        {
            "width": "7%",
            "data": function( d ){
                if(d.lugar_prospeccion == 6){
                    return '<p class="m-0">COMISIÓN + MKTD <br><b> ('+d.porcentaje_decimal+'% de '+d.porcentaje_abono+'%)</b></p>';
                }
                else{
                    return '<p class="m-0">COMISIÓN <br><b> ('+d.porcentaje_decimal+'% de '+d.porcentaje_abono+'%)</b></p>';
                }
            
            }
        },
        {
            "width": "9%",
            "data": function( d ){
                return '<p class="m-0"><b>'+d.usuario+'</b></i></p>';
            }
        },
        {
            "width": "7%",
            "data": function( d ){
                return '<p class="m-0"><i> '+d.puesto+'</i></p>';
            }
        },
        {
            "width": "7%",
            "data": function( d ){
                var BtnStats1;
                BtnStats1 =  '<p class="m-0">'+d.fecha_creacion+'</p>';
                return BtnStats1;

            }
        },
        {
            "width": "8%",
            "orderable": false,
            "data": function( data ){
                var BtnStats;
                
                BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_remanente" title="Detalles">' +'<i class="fas fa-info"></i></button>'+

                '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.id_pago_i+'" data-code="'+data.cbbtton+'" ' + 'class="btn-data btn-warning cambiar_estatus" title="Pausar solicitud">' + '<i class="fas fa-ban"></i></button>';
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
                if(full.estatus == 4){
                    if(full.id_comision){
                        return '<input type="checkbox" name="idTQ[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
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
            "url": general_base_url + "Pagos/getDatosEspecialRContraloria/",
            "type": "POST",
            cache: false,
            "data": function( d ){
            }
        },
    });

    $("#tabla_especial tbody").on("click", ".consultar_logs_remanente", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();

        id_pago = $(this).val();
        lote = $(this).attr("data-value");

        $("#seeInformationModalremanente").modal();
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-remanente").append('<div class="col-lg-12"><p><i style="color:gray;">'+v.comentario+'</i><br><b style="color:#3982C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
            });
        });
    });

    $('#tabla_especial').on('click', 'input', function() {
        tr = $(this).closest('tr');
        var row = tabla_especial2.row(tr).data();
        if (row.pa == 0) {
            row.pa = row.impuesto;
            totaPen += parseFloat(row.pa);
            tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
        }
        else {
            totaPen -= parseFloat(row.pa);
            row.pa = 0;
        }

        $("#totpagarPen").html(formatMoney(totaPen));
    });

    $("#tabla_especial tbody").on("click", ".cambiar_estatus", function(){
        var tr = $(this).closest('tr');
        var row = tabla_especial2.row( tr );
        id_pago_i = $(this).val();

        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de pausar la comisión de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p></div></div>');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="1"><input type="hidden" name="estatus" value="6"><input type="text" class="form-control observaciones" name="observaciones" required placeholder="Describe mótivo por el cual se va activar nuevamente la solicitud"></input></div></div>');
        $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">');
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="PAUSAR"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></div></div>');
        $("#modal_nuevas").modal();
    });
});
//FIN TABLA  ****************************************************************************************

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable()
    .columns.adjust();
});

$(window).resize(function(){
    tabla_especial2.columns.adjust();
});

function formatMoney( n ) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
    j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

//Función para pausar la solicitud
$("#form_interes").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        console.log(data);
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: general_base_url + "Pagos/despausar_solicitud/",
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
                    alerts.showNotification("top", "right", "Se ha pausado la comisión exitosamente", "success");
                    setTimeout(function() {
                        tabla_especial2.ajax.reload();
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

function selectAll(e) {
    tota2 = 0;
    $(tabla_especial2.$('input[type="checkbox"]')).each(function (i, v) {
        if (!$(this).prop("checked")) {
            $(this).prop("checked", true);
            tota2 += parseFloat(tabla_especial2.row($(this).closest('tr')).data().impuesto);
        } else {
            $(this).prop("checked", false);
        }
        $("#totpagarPen").html(formatMoney(tota2));
    });
}