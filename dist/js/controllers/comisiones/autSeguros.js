$(document).ready(function () {
    $('body').tooltip({
        selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
        trigger: 'hover',
        container: 'body'
    }).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
        $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
    });

    $.post(general_base_url+"General/getOpcionesPorCatalogo/125", function (data) {
        $('[data-toggle="tooltip"]').tooltip()
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#estatusSeguro").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#estatusSeguro").selectpicker('refresh');
    }, 'json');

    let titulos_intxt = [];
    $('#tabla_comisiones_seguro thead tr:eq(0) th').each( function (i) {
        $(this).css('text-align', 'center');
        var title = $(this).text();
        titulos_intxt.push(title);
       let id = i == 6 ? 'id="filterInfo"' : '';
            $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" ${id} data-placement="top" title="${title}" placeholder="${title}"/>` );
            $( 'input', this ).on('keyup change', function () {
                if ($('#tabla_comisiones_seguro').DataTable().column(i).search() !== this.value ) {
                    $('#tabla_comisiones_seguro').DataTable().column(i).search(this.value).draw();
                }
                var index = $('#tabla_comisiones_seguro').DataTable().rows({
                selected: true,
                search: 'applied'
            }).indexes();
            var data = $('#tabla_comisiones_seguro').DataTable().rows(index).data();
        });
    });
    
$("#estatusSeguro").change(function() {
    var	valor = $(this).val();
        getSeguros(valor); 
});
    getSeguros();
    function getSeguros(estatus = '') {
        segurosDataTable = $('#tabla_comisiones_seguro').dataTable({
            dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            width: "100%",
            scrollX: true,
            bAutoWidth:true,
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'Comisiones seguros',
                    exportOptions: {
                        columns: [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                        format: {
                            header:  function (d, columnIdx) {
                                return ' ' + titulos_intxt[columnIdx]  + ' ';
                                }
                            }
                    }
                }
            ],
            pagingType: "full_numbers",
            fixedHeader: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            language: {
                url: `${general_base_url}static/spanishLoader_v2.json`,
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            destroy: true,
            ordering: false,
            columns: [
               /* {
                className: 'details-control',
                orderable: false,
                data : null,
                defaultContent: '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
                },*/
                {data: 'nombreResidencial'},
                {data: 'nombreCondominio'},
                { data: function (d) {
                    return d.nombreLote;
                }},
                {data: 'idLote'},
                {data: 'nombreCliente'},
                {data: 'referencia'},
                { data: function (d) {
                        return `<span class="label ${d.claseTipo_venta}">${d.tipo_venta}</span>`;
                }},
                { data: function (d) {
                    return `<span class="label ${d.colorContratacion}">${d.idStatusContratacion}</span><br><span class="label ${d.colorSeguro}">${d.estatusSeguro}</span>`;
                }},
                { data: function (d) {
                    return labelEstatus =`<label class="label lbl-azure btn-dataTable" data-toggle="tooltip"  data-placement="top"  title="VER MÁS DETALLES"><b><span  onclick="showDetailModal(${d.id_plan})" style="cursor: pointer;">${d.plan_comision}</span></label>`;
                }},
                { data: function (d) {
                    return formatMoney(d.Precio_Total);
                }},
                { data: function (d) {
                    return d.porcentaje ? `${parseFloat(d.porcentaje)}%`: 'SIN ESPECIFICAR';
                }},
                { data: function (d) {
                    return formatMoney(d.Comision_total);
                }},
                { data: function (d) {
                    return formatMoney(d.Comisiones_Pagadas);
                }},
                { data: function (d) {
                    return formatMoney(d.Comisiones_pendientes);
                }},
                { data: function (d) {
                        let nuevoSaldo = d.numero_dispersion > 1 ? `<span class="label lbl-azure">Nuevo saldo</span>`  : '';
                        return `<span class="label lbl-azure">${moment(d.fecha_modificacion.split('.')[0],'YYYY/MM/DD HH:mm:ss').format('DD/MM/YYYY HH:mm:ss')}</span> ${nuevoSaldo}`;
                    
                }},
                { data: function (d) {
                            let botonView = `<button href="#" value="${d.idLote}"  data-cliente="${d.id_cliente}" data-nombreLote="${d.nombreLote}" data-totalLote="${d.Precio_Total}" class="btn-data btn-green verify_neodata" title="VERIFICAR COMISIONES"><span class="material-icons">verified_user</span></button>`,
                                botonAutorizar = [0,1,3,4].indexOf(parseInt(d.idestatusSeguro)) >= 0 ?  `<button href="#" value="${d.idLote}"  data-cliente="${d.id_cliente}" data-nombreLote="${d.nombreLote}" data-totalLote="${d.Precio_Total}" data-tipoAut="2" class="btn-data btn-violetDeep aut" title="Autorizar comisiones"><span class="material-icons">thumb_up</span></button>` : '',
                                botonRechazar = d.idestatusSeguro == 1 ? `<button href="#" value="${d.idLote}"  data-cliente="${d.id_cliente}" data-nombreLote="${d.nombreLote}" data-totalLote="${d.Precio_Total}" data-tipoAut="3" class="btn-data btn-warning aut" title="Rechazar comisiones"><span class="material-icons">thumb_down</span></button>` : '',
                                botonHistorial = `<button href="#" value="${d.idLote}"  data-cliente="${d.id_cliente}" data-nombreLote="${d.nombreLote}" data-totalLote="${d.Precio_Total}" class="btn-data btn-gray historial" title="Historial movimientos"><span class="material-icons">info</span></button>`;
                    return `<div class="d-flex justify-center">`+botonView + botonAutorizar + botonRechazar + botonHistorial+`</div>`;
                }}  
            ],
            columnDefs: [{
                visible: false,
                searchable: false
            }],
            ajax: {
                url: general_base_url+'Seguros/getDataPagosSeguro',
                type: "POST",
                cache: false,
                data: {
                    "estatus" : estatus
                }
            }
        }) 
       
    }
    $('#tabla_ingresar_9').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    
$("#tabla_comisiones_seguro tbody").on('click', '.aut', function () {
    $('#observaciones').val('');
    const nombreLote = $(this).attr("data-nombreLote");
    const idCliente = $(this).attr("data-cliente");
    const cadena = $(this).attr("data-tipoAut") == 2 ? 'Autorizar' : 'Rechazar';
    const tipoAut = $(this).attr("data-tipoAut");
    $('#idCliente').val(idCliente);
    $('#tipoAut').val(tipoAut);
    $("#modalAut .modal-header").html("");
    $("#modalAut .modal-header").append(`<h4 class="modal-title">Estas seguro que deseas ${cadena} el lote  <b>${nombreLote}</b></h4>`);
    $("#modalAut").modal();
});

$("#tabla_comisiones_seguro tbody").on('click', '.historial', function (e) {
    $("#modalHistorial .modal-header").html("");
    $("#historialSeguros").html("");
    const idCliente = $(this).attr("data-cliente");
    $("#modalHistorial .modal-header").append(`<p><h5 style="color: black;">HISTORIAL MOVIENTOS SEGURO <b style="color:#39A1C0; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;"></b></h5></p>`);
    $.getJSON(general_base_url+ "Seguros/getHistorialSeguro/" + idCliente).done(function (data) {
        $.each(data, function (i, v) {
            let color = v.estatus == 3 ? 'red' : 'black';
            $("#historialSeguros").append(`<div class="col-lg-12"><i style="color:${color}">${v.observaciones}</i><br><b style="color:#39A1C0">${v.fechaCreacion}</b><b style="color:gray;"> - ${v.nombreUsuario}</b></p></div>`);
        });
      data.length == 0 ?  alerts.showNotification("top", "right", "No se encontraron observaciones", "warning") :   $("#modalHistorial").modal();
    });  
});


    $("#tabla_comisiones_seguro tbody").on("click", ".verify_neodata", async function(){ 
        $("#modalComisiones .modal-header").html("");
        $("#modalComisiones .modal-body").html("");
        
        var tr = $(this).closest('tr');
        var row = $('#tabla_comisiones_seguro').DataTable().row(tr);
        idLote = $(this).val();
        nombreLote = $(this).attr("data-nombreLote");
        precioSeguro = $(this).attr("data-totalLote");
        idCliente = $(this).attr("data-cliente");
        $.getJSON( general_base_url + "Seguros/getAbonado/"+idLote).done( function( data1 ){
            var counts=0;
            $("#modalComisiones .modal-body").append(`<div class="row"><div class="col-md-4">Total pago: <b style="color:blue">${formatMoney(data1[0].total_comision)}</b></div><div class="col-md-4">Total abonado: <b style="color:green">${formatMoney(data1[0].abonado)}</b></div><div class="col-md-4">Total pendiente: <b  style="color:orange">${formatMoney((data1[0].total_comision)-(data1[0].abonado))}</b></div></div>`);
            $("#modalComisiones .modal-body").append(`<div class="row"><div class="col-md-4"><h4><b>Precio del seguro: ${formatMoney(precioSeguro)}</b></h4></div>
            </div>`);
            $.getJSON( general_base_url + "Seguros/getDatosAbonadoDispersion/"+idLote).done( function( data ){
                $("#modalComisiones .modal-body").append('<div class="row rowTitulos"><div class="col-md-4"><p style="font-size:10px;"><b>USUARIOS</b></p></div><div class="col-md-1"><b>%</b></div><div class="col-md-2"><b>TOTAL DE LA COMISIÓN</b></div><div class="col-md-2"><b><b>ABONADO</b></div><div class="col-md-2"><b>PENDIENTE</b></div></div>');
                $.each( data, function( i, v){
                    saldo =0;
                    if(parseFloat(v.abono_pagado) > 0){
                        evaluar = (parseFloat(v.comision_total)- parseFloat(v.abono_pagado));
                        if(parseFloat(evaluar) < 0){
                            pending=evaluar;
                            saldo = 0;
                        }
                        else{
                            pending = evaluar;
                        }
                        resta_1 = saldo-v.abono_pagado;
                        
                        if(parseFloat(resta_1) <= 0){
                            saldo = 0;
                        }
                        else if(parseFloat(resta_1) > 0){
                            if(parseFloat(resta_1) > parseFloat(pending)){
                                saldo = pending;
                            }
                            else{
                                saldo = saldo-v.abono_pagado;
                            }
                        }
                    }  
                    else if(v.abono_pagado <= 0){
                        pending = (v.comision_total);
                        if(saldo > pending){
                            saldo = pending;
                        }
                        if(pending < 0){
                            saldo = 0;
                        }
                    }
                    if( (parseFloat(saldo) + parseFloat(v.abono_pagado)) > (parseFloat(v.comision_total)+0.5 )){
                        //ENTRA AQUI AL CERO
                        saldo = 0;
                    }
                    $("#modalComisiones .modal-body").append(`
                    <div class="row">
                        <div class="col-md-4 ">
                            <label class="control-label labelNombre hide">USUARIO</label>
                            <input class="form-control input-gral" required readonly="true" value="${v.colaborador}" style=" font-size:12px;${v.descuento == 1 ? 'color:red;' : ''}">
                            <b><p style="font-size:12px;${v.descuento == 1 ? 'color:red;' : ''}">${v.descuento != "1" ?  v.rol : v.rol +' Incorrecto' }</p></b>
                        </div>
                        <div class="col-md-1">
                            <label class="control-label labelPorcentaje hide">%</label>
                            <input class="form-control input-gral" required readonly="true" style="padding:10px ${v.descuento == 1 ? 'color:red;' : ''}" value="${parseFloat(v.porcentaje_decimal)}">
                        </div>
                        <div class="col-md-2">
                            <label class="control-label labelTC hide">Total de la comisión</label>
                            <input class="form-control input-gral" required readonly="true" style="${v.descuento == 1 ? 'color:red;' : ''}" value="${formatMoney(v.comision_total)}">
                        </div>
                        <div class="col-md-2">
                            <label id="" class="control-label labelAbonado hide">Abonado</label>
                            <input class="form-control input-gral" required readonly="true" style="${v.descuento == 1 ? 'color:red;' : ''}" value="${formatMoney(v.abono_pagado)}">
                        </div>
                        <div class="col-md-2">
                            <label id="" class="control-label labelPendiente hide">Pendiente</label>
                            <input class="form-control input-gral" required style="${pending < 0 ? 'color:red' : ''}" readonly="true" value="${formatMoney(pending)}">
                        </div>
                    </div>`);
                    counts++
                });
                responsive(maxWidth);
            });
        });

               
            
    $("#modalComisiones").modal();
        
    }); //FIN VERIFY_NEODATA
});

$('#formAut').on('submit', function (e) {
    document.getElementById('btnAcept').disabled = true;
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'changeStatusSeguro',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function (data) {
            if (data) {
                $('#modalAut').modal("hide");
                document.getElementById('btnAcept').disabled = false;
                document.getElementById("formAut").reset();
                alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                $('#tabla_comisiones_seguro').DataTable().ajax.reload();
                $('#spiner-loader').addClass('hide');
            } else {
                alerts.showNotification("top", "right", "Ocurrió un problema, vuelva a intentarlo más tarde.", "warning");
                $('#spiner-loader').addClass('hide');
            }
        }, error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
});

$("#form_NEODATA").submit( function(e) {
    $('#dispersar').prop('disabled', true);
    document.getElementById('dispersar').disabled = true;
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#spiner-loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: general_base_url + 'Comisiones/InsertNeo',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                if( data == 1 ){
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "Dispersión guardada con éxito", "success");
                    $('#tabla_comisiones_seguro').DataTable().ajax.reload();
                    $("#modalComisiones").modal( 'hide' );
                    function_totales();
                    $('#dispersar').prop('disabled', false);
                    document.getElementById('dispersar').disabled = false;
                }else if (data == 2) {
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "Ya se dispersó por otra persona o es una recisión", "warning");
                    $('#tabla_comisiones_seguro').DataTable().ajax.reload();
                    $("#modalComisiones").modal( 'hide' );
                    $('#dispersar').prop('disabled', false);
                    document.getElementById('dispersar').disabled = false;
                }else{
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "No se pudo completar tu solicitud", "danger");
                    $('#dispersar').prop('disabled', false);
                    document.getElementById('dispersar').disabled = false;
                }
            },error: function(){
                $('#spiner-loader').addClass('hidden');
                alerts.showNotification("top", "right", "ERROR EN EL SISTEMA, REVISAR CON SISTEMAS", "danger");
            }
        });     
    }
});   

jQuery(document).ready(function(){
    jQuery('#editReg').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario').val('');
        jQuery(this).find('#totalNeto').val('');
        jQuery(this).find('#totalNeto2').val('');
    })
    jQuery('#rechReg').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario3').val('');
    })
})

$('.decimals').on('input', function () {
    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
});

$("#my_updatebandera_form").on('submit', function(e){
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'updateBandera',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
        },
        success: function(data) {
            if (data == 1) {
                $('#myUpdateBanderaModal').modal("hide");
                $("#id_pagoc").val("");
                alerts.showNotification("top", "right", "Lote actualizado exitosamente", "success");
                $('#tabla_comisiones_seguro').DataTable().ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Oops, algo salió mal. Error al intentar actualizar.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '.update_bandera', function(e){
    id_pagoc = $(this).attr("data-idpagoc");
    nombreLote = $(this).attr("data-nombreLote");
    $("#myUpdateBanderaModal .modal-body").html('');
    $("#myUpdateBanderaModal .modal-header").html('');
    $("#myUpdateBanderaModal .modal-header").append('<h4 class="modal-title">Enviar a dispersion de comisiones: <b>'+nombreLote+'</b></h4>');
    $("#myUpdateBanderaModal .modal-body").append('<input type="hidden" name="id_pagoc" id="id_pagoc"><input type="hidden" name="param" id="param">');
    $("#myUpdateBanderaModal").modal();
    $("#id_pagoc").val(id_pagoc);
    $("#param").val(0);
});

function showDetailModal(idPlan) {
    cleanElement('detalle-tabla-div');
    $('#spiner-loader').removeClass('hide');
        $.ajax({
            url: `${general_base_url}Seguros/getDetallePlanesComisiones/${idPlan}`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#plan-detalle-tabla-tbody').empty();
                $('#title-plan').text(`Plan: ${data.descripcion}`);
                $('#detalle-plan-modal').modal();
                $('#detalle-tabla-div').hide();
                const roles = data.comisiones;
                $('#detalle-tabla-div').append(`
                <div class="row subBoxDetail" id="modalInformation">
                    <div class=" col-sm-12 col-sm-12 col-lg-12 text-center" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>PLAN COMISIÓN</b></label></div>
                    <div class="col-2 col-sm-12 col-md-6 col-lg-6 text-center"><label><b>PUESTO</b></label></div>
                    <div class="col-2 col-sm-12 col-md-6 col-lg-6 text-center"><label><b>% COMISIÓN</b></label></div>
                    <div class="prueba"></div>
                `)
                roles.forEach(rol => {
                    if (rol.puesto !== null && (rol.com > 0)) {
                        $('#detalle-tabla-div .prueba').append(`
                        <div class="col-2 col-sm-12 col-md-6 col-lg-6 text-center"><label>${rol.puesto}</label></div>
                        <div class="col-2 col-sm-12 col-md-6 col-lg-6 text-center"><label>${convertirPorcentajes(rol.com)} %</label></div>
                        `);
                    }
                    
                });
                $('#detalle-tabla-div').append(`
                </div>`)
                $('#detalle-tabla-div').show();
                $('#spiner-loader').addClass('hide');
            },
            error: function(){
                alerts.showNotification("top", "right", "No hay datos por mostrar.", "danger");
                $('#spiner-loader').addClass('hide');
            }        
        });
    }


function responsive(maxWidth) {
    if (maxWidth.matches ) { //true mayor 991
        $('.labelNombre').removeClass('hide');
        $('.labelPorcentaje').removeClass('hide');
        $('.labelTC').removeClass('hide');
        $('.labelAbonado').removeClass('hide');
        $('.labelPendiente').removeClass('hide');
        $('.labelDisponible').removeClass('hide');
        $('.rowTitulos').addClass('hide');
    } else { //false menor 991
        $('.labelNombre').addClass('hide');
        $('.labelPorcentaje').addClass('hide');
        $('.labelTC').addClass('hide');
        $('.labelAbonado').addClass('hide');
        $('.labelPendiente').addClass('hide');
        $('.labelDisponible').addClass('hide');
        $('.rowTitulos').removeClass('hide');
    }
}
var maxWidth = window.matchMedia("(max-width: 992px)");
responsive(maxWidth);
maxWidth.addListener(responsive);

