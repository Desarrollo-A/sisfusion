var totaPen = 0;
var tr;
let estatus = '';
let texto = '';
let mensaje = '';
let rol = "<?=$this->session->userdata('id_rol')?>";
if(rol == 18){
    texto = 'ENVIAR A CONTRALORÍA';
    mensaje = 'BONOS ENVIADOS A CONTRALORÍA CORRECTAMENTE.';
    estatus = '1';
}
else{
    estatus = '2,6';
    texto ='ENVIAR A INTERNOMEX';
    mensaje ='BONOS ENVIADOS A INTERNOMEX CORRECTAMENTE.';
}



/**--------------------------TABLA REVISONES-------------------------------- */
$("#tabla_bono_revision").ready(function() {
    $('#tabla_bono_revision thead tr:eq(0) th').each( function (i) {
        if(  i !=14 && i != 0){
            var title = $(this).text();
            $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
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
        document.getElementById("totalp").textContent = '$' + to;
    });

    tabla_nuevas = $("#tabla_bono_revision").DataTable({
        dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: 'auto',
        buttons: [{
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
                style: 'position: relative; float: right;',
            }
        },
        {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13],
                format: {
                    header:  function (d, columnIdx) {
                        if(columnIdx == 1){
                            return 'ID ';
                        }
                        else if(columnIdx == 2){
                            return 'USUARIO ';
                        }else if(columnIdx == 3){
                            return 'ROL ';
                        }else if(columnIdx == 4){
                            return 'MONTO BONO';
                        }else if(columnIdx == 5){
                            return 'ABONDADO';
                        }else if(columnIdx == 6){
                            return 'PENDIENTE';
                        }
                        else if(columnIdx == 7){
                            return 'NÚMERO PAGO';
                        }else if(columnIdx == 8){
                            return 'PAGO INDIVIDUAL';
                        }else if(columnIdx == 9){
                            return 'ESTATUS';
                        }
                        else if(columnIdx == 10){
                            return 'IMPUESTO';
                        }
                        else if(columnIdx == 11){
                            return 'TOTAL APAGAR';
                        }
                        else if(columnIdx == 12){
                            return 'COMENTARIO';
                        }
                        else if(columnIdx == 13){
                            return 'FECHA';
                        }
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
            "width": "3%",
        },
        {
            "width": "3%",
            "data": function(d) {
                return '<p class="m-0"><center>' + d.id_pago_bono + '</center></p>';
            }
        },
        {
            "width": "7%",
            "data": function(d) {
                return '<p class="m-0"><center>' + d.nombre + '</center></p>';
            }
        },
        {
            "width": "7%",
            "data": function(d) {
                return '<p class="m-0"><center>'+d.id_rol+'</center></p>';
            }
        },
        {
            "width": "7%",
            "data": function(d) {
                return '<p class="m-0"><center>$' + formatMoney(d.monto) + '</center></p>';
            }
        },
        {
            "width": "7%",
            "data": function(d) {
                let abonado = d.n_p*d.pago;
                if(abonado >= d.monto -.30 && abonado <= d.monto +.30){
                    abonado = d.monto;
                }else{
                    abonado =d.n_p*d.pago;
                }
                return '<p class="m-0"><center><b>$' + formatMoney(abonado) + '</b></center></p>';
            }
        },
        {
            "width": "7%",
            "data": function(d) {
                let pendiente = d.monto - (d.n_p*d.pago);
                if(pendiente < 1){
                    pendiente = 0;
                }else{
                    pendiente = d.monto - (d.n_p*d.pago);
                }
                return '<p class="m-0"><center><b>$' + formatMoney(pendiente) + '</b></center></p>';
            }
        },
        {
            "width": "3%",
            "data": function(d) {
                return '<p class="m-0"><center><b>' +d.n_p+'</b>/'+d.num_pagos+ '</center></p>';
            }
        },
        {
            "width": "7%",
            "data": function(d) {
                return '<p class="m-0"><center>$' + formatMoney(d.pago) + '</center></p>';
            }
        },
        {
            "width": "5%",
            "data": function(d) {
                if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                    return '<p class=m-0"><center><b>0%</b></center></p>';
                }
                else{
                    return '<p class="m-0"><center><b>'+parseFloat(d.impuesto)+'%</b></center></p>';
                }
            }
        },
        {
            "width": "7%",
            "data": function(d) {
                if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                    return '<p class="m-0"><center><b>$' + formatMoney(d.pago) + '</b></center></p>';
                }
                else{
                    let iva = ((parseFloat(d.impuesto)/100)*d.pago);
                    let pagar = parseFloat(d.pago) - iva;
                    return '<p class="m-0"><center><b>$' + formatMoney(pagar) + '</b></center></p>';
                }
            }
        },
        {
            "width": "7%",
            "data": function(d) {
                if (d.estado == 1) {
                    return '<center><span class="label label-danger" style="background:#29A2CC">NUEVO</span><center>';
                } else if (d.estado == 2) {
                    return '<center><span class="label label-danger" style="background:#9129CC">EN REVISIÓN</span><center>';
                } else if (d.estado == 3) {
                    return '<center><span class="label label-danger" style="background:#05A134">PAGADO</span><center>';
                }
                else if (d.estado == 6) {
                    return '<center><span class="label label-danger" style="background:#4D7FA1">EVIADO A INTERNOMEX</span><center>';
                }
            }
        },
        {
            "width": "15%",
            "data": function(d) {
                return '<p class="m-0"><center>' + d.comentario + '</center></p>';
            }
        },
        {
            "width": "8%",
            "data": function(d) {
                let fecha = d.fecha_abono.split('.')
                return '<p class="m-0"><center>' + fecha[0] + '</center></p>';
            }
        },
        {
            "width": "6%",
            "orderable": false,
            "data": function(d) {
                return '<div class="d-flex justify-center"><button class="btn-data btn-btn-blueMaderas consulta_abonos" value="' + d.id_pago_bono + '" title="HISTORIAL"><i class="fas fa-info"></i></button></div>';
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
                    return '<input type="checkbox" name="idTQ[]" style="width:20px;height:20px;"  value="' + full.id_pago_bono + '">';
                }
                else{
                    return '  <i class="material-icons">check</i>';
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
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE BONO</b></h5></p>');
        $.getJSON(general_base_url +"Comisiones/getHistorialAbono2/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<div class="col-lg-12"><p style="color:gray;font-size:1.1em;">'+v.comentario+'<br><b style="color:#3982C0;font-size:0.9em;">'+v.date_final+'</b><b style="color:gray;font-size:0.9em;"> - '+v.nombre_usuario+'</b></p></div>');
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

/*function mandar_espera(idLote, nombre) {
    idLoteespera = idLote;
    link_espera1 = "Comisiones/generar comisiones/";
    $("#myModalEspera .modal-footer").html("");
    $("#myModalEspera .modal-body").html("");
    $("#myModalEspera ").modal();
    $("#myModalEspera .modal-footer").append("<div class='btn-group'><button type='submit' class='btn btn-success'>GENERAR COMISIÓN</button></div>");
}*/

// FUNCTION MORE
$(window).resize(function(){
    tabla_nuevas.columns.adjust();
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


/*$("#roles").change(function() {
    var parent = $(this).val();
    document.getElementById("users").innerHTML ='';

    $('#users').append(` 
    <label class="label">Usuario</label>   
    <select id="usuarioid" name="usuarioid" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true">
    </select>
    `);
    $.post('getUsuariosRol/'+parent, function(data) {
        $("#usuarioid").append($('<option disabled>').val("default").text("Seleccione una opción"))
        var len = data.length;
        for( var i = 0; i<len; i++){
            var id = data[i]['id_usuario'];
            var name = data[i]['name_user'];
            $("#usuarioid").append($('<option>').val(id).attr('data-value', id).text(name));
        }

        if(len<=0){
            $("#usuarioid").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        
        $("#usuarioid").selectpicker('refresh');
    }, 'json'); 
});*/

/*$("#numeroP").change(function(){
    let monto = parseFloat($('#monto').val());
    let cantidad = parseFloat($('#numeroP').val());
    let resultado=0;

    if (isNaN(monto)) {
        alert('Debe ingresar un monto valido');
        $('#pago').val(resultado);
    }
    else{
        resultado = monto /cantidad;
        $('#pago').val(formatMoney(resultado));
    }
});*/

function cleanCommentsAsimilados() {
    var myCommentsList = document.getElementById('comments-list-asimilados');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}

function selectAll(e) {
    tota2 = 0;
    $(tabla_nuevas.$('input[type="checkbox"]')).each(function (i, v) {
        tr = $(this).closest('tr');
        var row = tabla_nuevas.row(tr).data();
        if (!$(this).prop("checked")) {
            let iva=0,pagar=0;
            if(row.pago == row.impuesto1){
                pagar = row.pago;
                row.pa = pagar;
            }else{
                iva = ((parseFloat(row.impuesto)/100)*row.pago);
                pagar = parseFloat(row.pago) - iva;
                row.pa = pagar;
            
            }
            $(this).prop("checked", true);
            totaPen += parseFloat(pagar);
            tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
        } 
        else {
            $(this).prop("checked", false);
            let iva=0,pagar=0;
            if(row.pago == row.impuesto1){
                pagar = row.pago;
            }else{
                iva = ((parseFloat(row.impuesto)/100)*row.pago);
                pagar = parseFloat(row.pago) - iva;
            }
            totaPen -= parseFloat(pagar);
            row.pa = 0;
        }
        $("#totpagarPen").html(formatMoney(totaPen));
    });
}
