var totaPen = 0;
var tr;
let estatus = '';
let texto = '';
let mensaje = '';
if(id_rol_general == 18){
    texto = 'ENVIAR A CONTRALORÍA';
    mensaje = 'BONOS ENVIADOS A CONTRALORÍA CORRECTAMENTE.';
    estatus = '1';
}
else{
    estatus = '2,6';
    texto ='ENVIAR A INTERNOMEX';
    mensaje ='BONOS ENVIADOS A INTERNOMEX CORRECTAMENTE.';
}
let titulos = [];

$("#tabla_bono_revision").ready(function() {
    $('#tabla_bono_revision thead tr:eq(0) th').each( function (i) {
        if( i != 0){
            var title = $(this).text();
            titulos.push(title);
            $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
            $( 'input', this ).on('keyup change', function () {
                if (tabla_nuevas.column(i).search() !== this.value ) {
                    tabla_nuevas.column(i).search(this.value).draw();
                    var total = 0;
                    var index = tabla_nuevas.rows({ selected: true, search: 'applied' }).indexes();
                    var data = tabla_nuevas.rows( index ).data();
                    $.each(data, function(i, v){
                        total += parseFloat(v.pago);
                    });
                    var to1 = formatMoney(total);
                    document.getElementById("totalp").textContent =  to1;
                    console.log('fsdf'+total);
                }
            });
        }
        else if(i == 0){
            $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
        }
    });

    $('#tabla_bono_revision').on('xhr.dt', function ( e, settings, json, xhr ) {
        var total = 0;
        $.each(json.data, function(i, v){
            total += parseFloat(v.pago);
        });
        var to = formatMoney(total);
        document.getElementById("totalp").textContent =to;
    });

    tabla_nuevas = $("#tabla_bono_revision").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [ {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title:'Bonos activos',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx-1] + ' ';
                    }
                }
            },
        },
        {
            text: '<i class="fa fa-check"></i>'+texto+' ',
            action: function(){
                if ($('input[name="idTQ[]"]:checked').length > 0 ) {
                    var idbono = $(tabla_nuevas.$('input[name="idTQ[]"]:checked')).map(function () { return this.value; }).get();
                    $.get(general_base_url+"Comisiones/enviarBonosMex/"+idbono).done(function () {
                        $("#myModalEnviadas").modal('toggle');
                        tabla_nuevas.ajax.reload();
                        $("#myModalEnviadas .modal-body").html("");
                        $("#myModalEnviadas").modal();
                        $("#myModalEnviadas .modal-body").append(`
                            <center>
                                <img style='width: 25%; height: 25%;' src="${general_base_url}dist/img/mktd.png"> 
                                    <br><br>
                                    <b>
                                    <P style="color:#BCBCBC;"> ${mensaje} 
                                    </P></P>
                                    </b>
                            </center>`);
                    });
                }else{
                    alerts.showNotification("top", "right", "Favor de seleccionar un bono activo .", "warning");
                }
            },
            attr: {
                class: 'btn btn-azure',
            }
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
            data: function(d) {
                return '<p class="m-0"><center>' + d.id_pago_bono + '</center></p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0"><center>' + d.nombre + '</center></p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0"><center>'+d.id_rol+'</center></p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0"><center>' + formatMoney(d.monto) + '</center></p>';
            }
        },
        {
            data: function(d) {
                let abonado = d.n_p*d.pago;
                if(abonado >= d.monto -.30 && abonado <= d.monto +.30){
                    abonado = d.monto;
                }else{
                    abonado =d.n_p*d.pago;
                }
                return '<p class="m-0"><center><b>' + formatMoney(abonado) + '</b></center></p>';
            }
        },
        {
            data: function(d) {
                let pendiente = d.monto - (d.n_p*d.pago);
                if(pendiente < 1){
                    pendiente = 0;
                }else{
                    pendiente = d.monto - (d.n_p*d.pago);
                }
                return '<p class="m-0"><center><b>' + formatMoney(pendiente) + '</b></center></p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0"><center><b>' +d.n_p+'</b>/'+d.num_pagos+ '</center></p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0"><center>' + formatMoney(d.pago) + '</center></p>';
            }
        },
        {
            data: function(d) {
                if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                    return '<p class=m-0"><center><b>0%</b></center></p>';
                }
                else{
                    return '<p class="m-0"><center><b>'+parseFloat(d.impuesto)+'%</b></center></p>';
                }
            }
        },
        {
            data: function(d) {
                if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                    return '<p class="m-0"><center><b>' + formatMoney(d.pago) + '</b></center></p>';
                }
                else{
                    let iva = ((parseFloat(d.impuesto)/100)*d.pago);
                    let pagar = parseFloat(d.pago) - iva;
                    return '<p class="m-0"><center><b>' + formatMoney(pagar) + '</b></center></p>';
                }
            }
        },
        {
            data: function(d) {
                if (d.estado == 1) {
                    return '<center><span class="label lbl-cerulean">NUEVO</span><center>';
                } else if (d.estado == 2) {
                    return '<center><span class="label lbl-violetDeep">EN REVISIÓN</span><center>';
                } else if (d.estado == 3) {
                    return '<center><span class="label lbl-green">PAGADO</span><center>';
                }
                else if (d.estado == 6) {
                    return '<center><span class="label lbl-azure">EVIADO A INTERNOMEX</span><center>';
                }
            }
        },
        {
            data: function(d) {
                return '<p class="m-0"><center>' + d.comentario + '</center></p>';
            }
        },
        {
            data: function(d) {
                let fecha = d.fecha_abono.split('.')
                return '<p class="m-0"><center>' + fecha[0] + '</center></p>';
            }
        },
        {
            "orderable": false,
            data: function(d) {
                return '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas consulta_abonos" value="' + d.id_pago_bono + '" title="HISTORIAL"><i class="fas fa-info"></i></button></div>';
            } 
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            searchable:false,
            className: 'dt-body-center',
            render: function (d, type, full, meta){
                if(full.estado == 2 || full.estado== 1){
                    return '<input type="checkbox" name="idTQ[]" class="individualCheck" style="width:20px;height:20px;"  value="' + full.id_pago_bono + '">';
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
            url: general_base_url + "Pagos/getBonosPorUserContra/" + estatus,
            type: "POST",
            cache: false,
            data: function(d) {
            }
        },
    });

    $('#tabla_bono_revision').on('click', 'input', function() {
        tr = $(this).closest('tr');
        var row = tabla_nuevas.row(tr).data();
        let iva=0,pagar=0;
        if(row.pa == 0){
            if(row.pago == row.impuesto1){
                pagar = row.pago;
                row.pa = row.pago;
            }
            else{
                iva = ((parseFloat(row.impuesto)/100)*row.pago);
                pagar = parseFloat(row.pago) - iva;
                row.pa = pagar;
            }
            totaPen += parseFloat(pagar);
            tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
        }
        else{
            if(row.pago == row.impuesto1){
                pagar = row.pago;
            }
            else{
                iva = ((parseFloat(row.impuesto)/100)*row.pago);
                pagar = parseFloat(row.pago) - iva;
            }
            totaPen -= parseFloat(pagar);
            row.pa = 0;
        }
        $("#totpagarPen").html(formatMoney(totaPen));
    });

    $("#tabla_bono_revision tbody").on("click", ".consulta_abonos", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        $("#modal_bonos").modal();
        $("#nameLote").append('<p><h4 class="text-center"><b>HISTORIAL DE BONO</b></h4></p>');
        $.getJSON(general_base_url +"Comisiones/getHistorialAbono2/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append(
                    '<li>'+
                        '<div class="container-fluid">'+
                            '<div class="row">'+
                                '<div class="col-md-6">'+
                                    '<a><b>' + v.comentario + '</b></a><br>'+
                                '</div>'+
                                '<div class="float-end text-right"><a>'+v.date_final.split('.')[0]+'</a></div>'+
                                '<div class="col-md-12">'+
                                    '<p class="m-0">'+
                                        '<small>Modificado por: </small>'+
                                        '<b> ' +v.nombre_usuario+ '</b>'+
                                    '</p>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</li>'
                );
            });
        });
    });
});

function closeModalEng(){
    document.getElementById("form_abono").reset();
    a = document.getElementById('inputhidden');
    padre = a.parentNode;
    padre.removeChild(a);

    $("#modal_abono").modal('toggle');
}

$("#form_abono").on('submit', function(e){ 
    e.preventDefault();
    var formData = new FormData(document.getElementById("form_abono"));
    formData.append("dato", "valor");        
    $.ajax({
        method: 'POST',
        url: general_base_url+'Comisiones/InsertAbono',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            console.log(data);
            if (data == 1) {
                $('#tabla_prestamos').DataTable().ajax.reload(null, false);
                closeModalEng();
                $('#modal_abono').modal('hide');
                alerts.showNotification("top", "right", "Abono registrado con exito.", "success");
                document.getElementById("form_abono").reset();
            
            } else if(data == 2) {
                $('#tabla_prestamos').DataTable().ajax.reload(null, false);
                closeModalEng();
                $('#modal_abono').modal('hide');
                alerts.showNotification("top", "right", "Pago liquidado.", "warning");
            }else if(data == 3){
                closeModalEng();
                $('#modal_abono').modal('hide');
                alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
            }
        },
        error: function(){
            closeModalEng();
            $('#modal_abono').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    }) 
});

function cleanCommentsAsimilados() {
    var myCommentsList = document.getElementById('comments-list-asimilados');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}

// Selección de CheckBox
$(document).on("click", ".individualCheck", function() {
    totaPen = 0;
    tabla_nuevas.$('input[type="checkbox"]').each(function () {
        let totalChecados = tabla_nuevas.$('input[type="checkbox"]:checked') ;
        let totalCheckbox = tabla_nuevas.$('input[type="checkbox"]');
        if(this.checked){
            tr = this.closest('tr');
            row = tabla_nuevas.row(tr).data();
            totaPen += parseFloat(row.pago); 

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
        $(tabla_nuevas.$('input[type="checkbox"]')).each(function (i, v) {
            tr = this.closest('tr');
            row = tabla_nuevas.row(tr).data();
            tota2 += parseFloat(row.pago);
            if(v.checked == false){
                $(v).prop("checked", true);
            }
        }); 
        $("#totpagarPen").html(formatMoney(numberTwoDecimal(tota2)));
    }
    if(e.checked == false){
        $(tabla_nuevas.$('input[type="checkbox"]')).each(function (i, v) {
            if(v.checked == true){
                $(v).prop("checked", false);
            }
        }); 
        $("#totpagarPen").html(formatMoney(0));
    }
}

$('body').tooltip({
    selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
    trigger: 'hover',
    container: 'body'
}).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
    $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
});