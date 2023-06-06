var url = "<?=base_url()?>";
var totaPen = 0;
var tr;

/**-----------------------------------TABLA REVISONES-------------------------------- */
$("#tabla_bono_revision").ready(function() {
    $('#tabla_bono_revision thead tr:eq(0) th').each( function (i) {
        if( i!=0 && i!=9){
            var title = $(this).text();

            $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
            $( 'input', this ).on('keyup change', function () {
                if (tabla_nuevas.column(i).search() !== this.value ) {
                    tabla_nuevas
                    .column(i)
                    .search(this.value)
                    .draw();

                    var total = 0;
                    var index = tabla_nuevas.rows({ selected: true, search: 'applied' }).indexes();
                    var data = tabla_nuevas.rows( index ).data();

                    $.each(data, function(i, v){
                        total += parseFloat(v.pago);
                    });
                    var to1 = formatMoney(total);
                    document.getElementById("totalp").textContent = total;
                    console.log('fsdf'+total);
                }
            });
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
            text: '<i class="fa fa-check"></i> MARCAR COMO PAGADO',
            action: function(){
                if ($('input[name="idTQ[]"]:checked').length > 0 ) {
                    var idbono = $(tabla_nuevas.$('input[name="idTQ[]"]:checked')).map(function () { return this.value; }).get();

                    $.get(general_base_url+"Comisiones/enviarBonosMex/"+idbono).done(function () {
                        $("#myModalEnviadas").modal('toggle');
                        tabla_nuevas.ajax.reload();
                        $("#myModalEnviadas .modal-body").html("");
                        $("#myModalEnviadas").modal();
                        $("#myModalEnviadas .modal-body").append(` 
                            <center><img style='width: 25%; height: 25%;' src="${general_base_url}dist/img/mktd.png">
                                <br><br>
                                <b><P style='color:#BCBCBC;'>BONOS MARCADOS COMO PAGADOS.</P></b>
                            </center>"`);
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
            columns: [1,2,3,4,5,6,7,8,9],
            format: {
                header:  function (d, columnIdx) {
                    if(columnIdx == 1){
                            return 'ID';
                        }  
                    else if(columnIdx == 2){
                            return 'USUARIO ';
                        }else if(columnIdx == 3){
                            return 'ROL ';
                        }else if(columnIdx == 4){
                            return 'ROL ';
                        }else if(columnIdx == 5){
                            return 'PAGO';
                        }else if(columnIdx == 6){
                            return 'IMPUESTO';
                        }else if(columnIdx == 7){
                            return 'TOTAL A PAGAR';
                        }else if(columnIdx == 8){
                            return 'ESTATUS';
                        }else if(columnIdx == 9){
                            return 'COMENTARIO';
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
            "width": "5%",
        },
        {
            "width": "5%",
            "data": function(d) {
                return '<p class="m-0"><center>' + d.id_pago_bono + '</center></p>';
            }
        },
        {
            "width": "17%",
            "data": function(d) {
                return '<p class="m-0"><center>' + d.nombre + '</center></p>';
            }
        },
        {
            "width": "8%",
            "data": function(d) {
                return '<p class="m-0"><center>' + d.rfc + '</center></p>';
            }
        },
        {
            "width": "8%",
            "data": function(d) {
                return '<p class="m-0"><center>'+d.id_rol+'</center></p>';
            }
        },
        {
            "width": "8%",
            "data": function(d) {
                return '<p class="m-0"><center><b>$' + formatMoney(d.pago) + '</b></center></p>';
            }
        },
        {
            "width": "8%",
            "data": function(d) {
                if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                    return '<p class="m-0"><center><b>0%</b></center></p>';

                }else{
                    return '<p class="m-0"><center><b>'+parseFloat(d.impuesto)+'%</b></center></p>';
                }
            }
        },
        {
            "width": "8%",
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
            "width": "10%",
            "data": function(d) {
                if (d.estado == 1) {
                    return '<center><span class="label label-danger" style="background:#27AE60">NUEVO</span><center>';
                } else if (d.estado == 2) {
                    return '<center><span class="label label-danger" style="background:#E3A13C">EN REVISIÓN</span><center>';
                } else if (d.estado == 3) {
                    return '<center><span class="label label-danger" style="background:#04B41E">PAGADO</span><center>';
                }
                else if (d.estado == 6) {
                    return '<center><span class="label label-danger" style="background:#065D7F">REVISIÓN INTERNOMEX</span><center>';
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
            "orderable": false,
            "data": function(d) {
                if (d.estado == 3 || d.estado == 6) {
                    return '<button class="btn-data btn-blueMaderas consulta_abonos" value="' + d.id_pago_bono + ','+ d.nombre +' "  title="Historial"><i class="fas fa-info"></i></button>';
                }
            } 
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets:   0,
            searchable:false,
            className: 'dt-body-center',
            render: function (d, type, full, meta){
                if(full.estado == 6){
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
            "url": general_base_url + "Pagos/getBonosPorUserContra/" + '6',
            "type": "POST",
            cache: false,
            "data": function(d) {

            }
        },
    });

    $("#tabla_bono_revision tbody").on("click", ".consulta_abonos", function() {
        valores = $(this).val();
        let nuevos = valores.split(',');
        let id= nuevos[0];
        let nombre=nuevos[1];
        $.getJSON(general_base_url + "Comisiones/getHistorialAbono2/" + id).done(function(data) {
            $("#modal_bonos .modal-header").html("");
            $("#modal_bonos .modal-body").html("");
            $("#modal_bonos .modal-footer").html("");

            let estatus = '';
            let color='';
            if(data[0].estado == 1){
                estatus=data[0].nombre;
                color='27AE60';
            }else if(data[0].estado == 2){
                estatus=data[0].nombre;
                color='E3A13C';
            }else if(data[0].estado == 3){
                estatus=data[0].nombre;
                color='04B41E';
            }else if(data[0].estado == 4){
                estatus=data[0].nombre;
                color='C2A205';
            }else if(data[0].estado == 5){
                estatus='CANCELADO';
                color='red';
            }
            else if(data[0].estado == 6){
                estatus='ENVIADO A INTERNOMEX';
                color='065D7F';
            }    
            
            let f = data[0].fecha_abono.split('.');
            $("#modal_bonos .modal-body").append(`<div class="row"><div class="col-md-3"><h6>PARA: <b>${nombre}</b></h6></div>
            <div class="col-md-3"><h6>Abono: <b style="color:green;">$${formatMoney(data[0].impuesto1)}</b></h6></div>
            <div class="col-md-3"><h6>Fecha: <b>${f[0]}</b></h6></div>
            <div class="col-md-3"><center><span class="label label-danger" style="background:#${color}">${estatus}</span><center></h6></div>
            </div>`);

            $("#modal_bonos .modal-body").append(`<br>
            <div role="tabpanel">
                <ul class="nav nav-tabs" role="tablist" style="background: #71B85C;">
                    <h5 style="color: white;"><b>BITÁCORA DE CAMBIOS</b></h5>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="changelogTab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-plain">
                                    <div class="card-content">
                                        <ul class="timeline timeline-simple" id="comments-list-asimilados"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`);

            for (let index = 0; index < data.length; index++) {
                $("#comments-list-asimilados").append('<div class="col-lg-12"><p><b style="color:#896597">'+data[index].fecha+'</b><b style="color:gray;"> - '+data[index].nombreAu+'</b><br><i style="color:gray;">'+data[index].comentario+'</i></p><br></div>');
            }

            $("#modal_bonos").modal();
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
        url: general_base_url +'Comisiones/InsertAbono',
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
    });
});

function mandar_espera(idLote, nombre) {
    idLoteespera = idLote;
    link_espera1 = "Comisiones/generar comisiones/";
    $("#myModalEspera .modal-footer").html("");
    $("#myModalEspera .modal-body").html("");
    $("#myModalEspera ").modal();
    $("#myModalEspera .modal-footer").append("<div class='btn-group'><button type='submit' class='btn btn-success'>GENERAR COMISIÓN</button></div>");
}

// FUNCTION MORE
$(window).resize(function(){
    tabla_nuevas.columns.adjust();
    tabla_proceso.columns.adjust();
    tabla_pagadas.columns.adjust();
    tabla_otras.columns.adjust();
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


$("#roles").change(function() {
    var parent = $(this).val();

    document.getElementById("users").innerHTML ='';
    $('#users').append(` <label class="label">Usuario</label>   
    <select id="usuarioid" name="usuarioid" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true">
    </select>`);
    $.post(general_base_url+'Comisiones/getUsuariosRol/'+parent, function(data) {
        $("#usuarioid").append($('<option disabled>').val("default").text("Seleccione una opción"));
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
});

$("#numeroP").change(function(){
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
});