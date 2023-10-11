var totaPen = 0;
var tr;
let titulosFac = [];

$("#tabla_bono_revision").ready(function() {
    $('#tabla_bono_revision thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulosFac.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>' );
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
                document.getElementById("totalp").textContent = total;
            }
        });
    });

    $('#tabla_bono_revision').on('xhr.dt', function ( e, settings, json, xhr ) {
        var total = 0;
        $.each(json.data, function(i, v){
            total += parseFloat(v.pago);
        });
        var to = formatMoney(total);
        document.getElementById("totalp").textContent = to;
    });


    tabla_nuevas = $("#tabla_bono_revision").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
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
                style: 'position: relative;',
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
                header: function (d, columnIndex) {
                    return ' '+titulosFac[columnIndex] +' ';
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
            "data": function(d) {
                return '<p class="m-0"><center>' + d.id_pago_bono + '</center></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><center>' + d.nombre + '</center></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><center>' + d.rfc + '</center></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><center>'+d.id_rol+'</center></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><center><b>' + formatMoney(d.pago) + '</b></center></p>';
            }
        },
        {
            "data": function(d) {
                if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                    return '<p class="m-0"><center><b>0%</b></center></p>';
                }else{
                    return '<p class="m-0"><center><b>'+parseFloat(d.impuesto)+'%</b></center></p>';
                }
            }
        },
        {
            "data": function(d) {
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
            "data": function(d) {
                if (d.estado == 1) {
                    return '<center><span class="label lbl-green">NUEVO</span><center>';
                } else if (d.estado == 2) {
                    return '<center><span class="label lbl-orangeYellow">EN REVISIÓN</span><center>';
                } else if (d.estado == 3) {
                    return '<center><span class="label lbl-green">PAGADO</span><center>';
                }
                else if (d.estado == 6) {
                    return '<center><span class="label lbl-blueMaderas">REVISIÓN INTERNOMEX</span><center>';
                }
            }
        },
        {
            "data": function(d) {
            
                return '<p class="m-0"><center>' + d.comentario + '</center></p>';
            }
        },
        {
            "orderable": false,
            "data": function(d) {
                if (d.estado == 3 || d.estado == 6) {
                    return '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas consulta_abonos" value="' + d.id_pago_bono + ','+ d.nombre +' "  title="Historial"><i class="fas fa-info"></i></button></div>';
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
            
            let f = data[0].fecha_movimiento.split('.')[0];
            console.log(data[0]);
            $("#modal_bonos .modal-body").append(`<div class="row"><div class="col-md-4"><h6>PARA: <b>${nombre}</b></h6></div>
            <div class="col-md-4"><h6>Abono: <b style="color:green;">${formatMoney(data[0].abono)}</b></h6></div>
            <div class="col-md-4"><h6>Fecha: <b>${data[0].date_final}</b></h6></div>
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
                                    <div class="card-content scroll-styles p-0" style="height: 350px; overflow: auto">
                                        <ul class="timeline-3" id="comments-list-asimilados"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-end">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CERRAR</button>
                </div>
            </div>`);
            for (let index = 0; index < data.length; index++) {
                $.each( data, function(i, v){
                    $("#comments-list-asimilados").append('<li>\n' +
                    '  <div class="container-fluid">\n' +
                    '    <div class="row">\n' +
                    '      <div class="col-md-6">\n' +
                    '        <a><b>Usuario: ' + v.nombre_usuario + '</b></a><br>\n' +
                    '      </div>\n' +
                    '      <div class="float-end text-right">\n' +
                    '        <a>' + v.fecha_movimiento.split(".")[0] + '</a>\n' +
                    '      </div>\n' +
                    '      <div class="col-md-12">\n' +
                    '        <p class="m-0"><small>Comentario: </small><b> ' + v.comentario + '</b></p>\n'+
                    '      </div>\n' +
                    '    <h6>\n' +
                    '    </h6>\n' +
                    '    </div>\n' +
                    '  </div>\n' +
                    '</li>');
                }); 
                }
            $("#modal_bonos").modal();
        });
    });
});

$('#tabla_bono_revision').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
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

$(window).resize(function(){
    tabla_nuevas.columns.adjust();
    tabla_proceso.columns.adjust();
    tabla_pagadas.columns.adjust();
    tabla_otras.columns.adjust();
});

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