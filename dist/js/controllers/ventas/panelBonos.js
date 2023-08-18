function closeModalEng() {
    document.getElementById("form_abono").reset();
    a = document.getElementById('inputhidden');
    padre = a.parentNode;
    padre.removeChild(a);

    $("#modal_abono").modal('toggle');
}

$("#form_bonos").on('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(document.getElementById("form_bonos"));
    formData.append("dato", "valor");
    $.ajax({
        url: 'saveBono',
        data: formData,
        method: 'POST',
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            if (data == 1) {
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "Abono registrado con exito.", "success");
                tabla_nuevas.ajax.reload();
                tabla_nuevas2.ajax.reload();
                document.getElementById("form_bonos").reset();
            } else if (data == 2) {
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
            } else if (data == 3) {
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
            }
        },
        error: function() {
            $('#miModal').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

/** Función para dejar solo dos decimales */
function numberTwoDecimal(x) {
    return parseFloat(x).toFixed(2);
} 

/**-------------------------  TABLA NUEVOS BONOS --------------------------- */
$("#tabla_nuevos").ready(function() {
    let titulos = [];
    $('#tabla_nuevos thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_nuevos').DataTable().column(i).search() !== this.value ) {
                $('#tabla_nuevos').DataTable().column(i).search(this.value).draw();
            }
        });
        $('[data-toggle="tooltip"]').tooltip();
    });

    $('#tabla_nuevos').on('xhr.dt', function ( e, settings, json, xhr ) {
        var total = 0;
        $.each(json.data, function(i, v){
            total += parseFloat(v.impuesto1);
        });
        var to = formatMoney(numberTwoDecimal(total));
        document.getElementById("totalnuevos").textContent = to;
    });

    tabla_nuevas = $("#tabla_nuevos").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            title: 'Nuevos bonos',
            titleAttr: 'Descargar archivo de Excel',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            }
        },
        {
            text: '<i class="fas fa-play"></i>',
            className: `btn btn-dt-youtube buttons-youtube`,
            titleAttr: 'Para consultar más detalles sobre el uso y funcionalidad del apartado de Bonos podrás visualizarlo en el siguiente tutorial',
            action: function (e, dt, button, config) {
                window.open('https://youtu.be/wLDdDHQjCrw', '_blank');
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            "data": function(d) {
                return '<p class="m-0">' + d.id_pago_bono + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.nombre + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">'+d.id_rol+'</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.monto) + '</p>';
            }
        },
        {
            "data": function(d) {
                let abonado = d.n_p*d.pago;
                if(abonado >= d.monto -.30 && abonado <= d.monto +.30){
                    abonado = d.monto;
                }else{
                    abonado =d.n_p*d.pago;
                }
                return '<p class="m-0"><b>' + formatMoney(abonado) + '</b></p>';
            }
        },
        {
            "data": function(d) {
                let pendiente = d.monto - (d.n_p*d.pago);
                if(pendiente < 1){
                    pendiente = 0;
                }else{
                    pendiente = d.monto - (d.n_p*d.pago);
                }
                return '<p class="m-0"><b>' + formatMoney(pendiente) + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' +d.n_p+'</b>/'+d.num_pagos+ '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b> ' + formatMoney(d.pago) + '</b></p>';
            }
        },
        {
            "data": function(d) {
                if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                    return '<p class="m-0"><b>0%</b></p>';
                }
                else{
                    let impuesto = d.impuesto;
                    return '<p class="m-0"><b>'+parseFloat(impuesto)+'%</b></p>';
                
                }
            }
        },
        {
            "data": function(d) {
                if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                    return '<p class="m-0"><b>' + formatMoney(d.pago) + '</b></p>';
                }
                else{
                    let iva = ((parseFloat(d.impuesto)/100)*d.pago);
                    let pagar = parseFloat(d.pago) - iva;
                    return '<p class="m-0"><b>' + formatMoney(numberTwoDecimal(pagar)) + '</b></p>';
                }
            }
        },
        {
            "data": function(d) {
                if (d.estado == 1) {
                return '<span class="label lbl-green">NUEVO</span>';
                } else if (d.estado == 2 || d.estado == 3) {
                    return '<span class="label lbl-orangeYellow">EN REVISIÓN</span>';
                }
            }
        },   
        {
            "data": function(d) {
                let fecha = d.fecha_abono.split('.');
                return '<p class="m-0">' + fecha[0] + '</p>';
            }
        },
        {
            "data": function(d) {
                let abonoFinal;

                if (d.estado == 1) {
                    if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                        abonoFinal = parseFloat(d.pago);
                    }
                    else{
                        let iva = ((parseFloat(d.impuesto)/100)*d.pago);
                        let pagar = parseFloat(d.pago) - iva;
                        abonoFinal = parseFloat(pagar);
                    }

                    return  '<div class="d-flex justify-center">'+
                        '<button class="btn-data btn-green abonar" value="' + d.id_pago_bono + ',' + parseFloat(abonoFinal) + '" data-toggle="tooltip" data-placement="top" title="AUTORIZAR">'+
                            '<i class="fas fa-check"></i>'+
                        '</button>' +
                        '<button class="btn-data btn-blueMaderas consulta_abonos" value="' + d.id_pago_bono + ','+d.nombre+'  "  data-impuesto="'+d.impuesto1+'" data-toggle="tooltip" data-placement="top" title="HISTORIAL" >'+
                            '<i class="fas fa-info"></i>'+
                        '</button>';
                            }
            }
        }],
        columnDefs: [{
            orderable : false,
            searchable: true,
            target: 0,
        }],
        ajax: {
            "url": general_base_url + "Comisiones/getBonosPorUser/" + 1,
            "type": "POST",
            cache: false,
            "data": function(d) {
            }
        },
    });

    $('#tabla_nuevos').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });


    $("#tabla_nuevos tbody").on("click", ".consulta_abonos", function() {
        $('#spiner-loader').removeClass('hide');
        valores = $(this).val();
        let nuevos = valores.split(',');
        impuesto = $(this).attr("data-impuesto");

        let id= nuevos[0];
        let nombre=nuevos[1];
        $.getJSON(general_base_url + "Comisiones/getHistorialAbono2/" + id).done(function(data) {

            $("#modal_bonos .modal-header").html("");
            $("#modal_bonos .modal-body").html("");
            $("#modal_bonos .modal-footer").html("");
            let fechaComentario = data[0].fecha_movimiento.split('.')[0];
            let estatus = 'NUEVO';
            $("#modal_bonos .modal-body").append(`<div class="row"><div role="tabpanel">
            <ul class="nav nav-tabs" role="tablist">
                <h5 style="color: white;"><b>BITÁCORA DE CAMBIOS</b></h5>

                <div class="row" style="color: white;"><div class="col-md-6"><h6>usuario bonificado: <b>${nombre}</b></h6></div>
                    <div class="col-md-6"><h6>monto: <b>${formatMoney(numberTwoDecimal(impuesto))}</b></h6></div>
                    <div class="col-md-6"><h6>Fecha: <b>${fechaComentario}</b></h6></div>
                    <br><div class="col-md-6"><h6>Estatus: <b>${estatus}</b></h6></div>
                  </div>
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
                let fechaComentario = data[index].fecha_movimiento.split('.')[0];
               $("#comments-list-asimilados").append('<div class="col-lg-12"><p><b>'+fechaComentario+'</b><b style="color:gray;"> - '+data[index].nombre_usuario+'</b><br>'+data[index].comentario+'</p><br></div>');   
           }

            $("#modal_bonos .modal-body").append(``);

            $("#modal_bonos").modal();
            $('#spiner-loader').addClass('hide');

        });
    });


        $("#tabla_nuevos tbody").on("click", ".abonar", function() {

            $("#modal_abono .modal-header").html('');
            $("#modal_abono .modal-body").html('');
            $("#modal_abono .modal-footer").html('');

            bono = $(this).val();
            var dat = bono.split(",");
            $("#modal_abono .modal-header").append(`<h3>Confirmación</h3>`);
    
            $("#modal_abono .modal-body").append(`
            <h4>¿Está seguro de enviar el bono de <b>${formatMoney(dat[1])}</b> a revisión contraloría?</h4>
            <input type='hidden' name="id_abono" id="id_abono" value="${dat[0]}">
            <input type='hidden' name="pago" id="pago" value="${dat[1]}">
            `);
    
            $("#modal_abono .modal-footer").append(`<div id="inputhidden">
            <button type="button" class="btn btn-danger btn-simple" onclick="closeModalEng()" > CANCELAR</button>
            <button type="submit" class="btn btn-primary" onclick=".abonar"> AUTORIZAR</button></div>`);
    
            $("#modal_abono .modal-header").append(``);
            $("#modal_abono .modal-body").append(``);
            $("#modal_abono .modal-footer").append(``);
            $('#modal_abono').modal('show');

    });

    $(window).resize(function () {
        tabla_nuevos.columns.adjust();
    });
});
/** ------------------------ FIN TABLA NUEVOS BONOS ------------------------ */

/**-------------------------TABLA REVISONES-------------------------------- */
$("#tabla_bono_revision").ready(function() {
    let titulos = [];

    $('#tabla_bono_revision thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_bono_revision').DataTable().column(i).search() !== this.value ) {
                $('#tabla_bono_revision').DataTable().column(i).search(this.value).draw();
            }
        });
        $('[data-toggle="tooltip"]').tooltip();
    });

    $('#tabla_bono_revision').on('xhr.dt', function ( e, settings, json, xhr ) {
        var total = 0;
        $.each(json.data, function(i, v){
            total += parseFloat(v.impuesto1);
        });
        var to = formatMoney(numberTwoDecimal(total));
        document.getElementById("totalrevision").textContent = to;
    });

    tabla_nuevas2 = $("#tabla_bono_revision").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'Bonos en revisión',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            }
        },
        {
            text: '<i class="fas fa-play"></i>',
            className: `btn btn-dt-youtube buttons-youtube`,
            titleAttr: 'Para consultar más detalles sobre el uso y funcionalidad del apartado de Bonos podrás visualizarlo en el siguiente tutorial',
            action: function (e, dt, button, config) {
                window.open('https://youtu.be/wLDdDHQjCrw', '_blank');
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            "data": function(d) {
                return '<p class="m-0">' + d.id_pago_bono + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.nombre + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">'+d.id_rol+'</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.monto) + '</p>';
            }
        },
        {
            "data": function(d) {
                let abonado = d.n_p*d.pago;
                if(abonado >= d.monto -.30 && abonado <= d.monto +.30){
                    abonado = d.monto;
                }else{
                    abonado =d.n_p*d.pago;
                }
                return '<p class="m-0"><b>' + formatMoney(abonado) + '</b></p>';
            }
        },
        {
            "data": function(d) {
                let pendiente = d.monto - (d.n_p*d.pago);
                if(pendiente < 1){
                    pendiente = 0;
                }else{
                    pendiente = d.monto - (d.n_p*d.pago);
                }
                return '<p class="m-0"><b>' + formatMoney(pendiente) + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' +d.n_p+'</b>/'+d.num_pagos+ '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + formatMoney(d.pago) + '</b></p>';
            }
        },
        {
            "data": function(d) {
                if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                    return '<p class="m-0"><b>0%</b></p>';
                }
                else{
                    let impuesto = d.impuesto;
                    return '<p class="m-0"><b>'+parseFloat(impuesto)+'%</b></p>';
                }
            }
        },
        {
            "data": function(d) {
                if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                    return '<p class="m-0"><b>' + formatMoney(d.pago) + '</b></p>';
                }
                else{
                    let iva = ((parseFloat(d.impuesto)/100)*d.pago);
                    let pagar = parseFloat(d.pago) - iva;
                    return '<p class="m-0"><b>' + formatMoney(numberTwoDecimal(pagar)) + '</b></p>';
                }
            }
        },
        {
            "data": function(d) {
                if (d.estado == 1) {
                    return '<span class="label lbl-green">NUEVO</span>';
                } else if (d.estado == 2) {
                    return '<span class="label lbl-warning">EN REVISIÓN</span>';
                } else if (d.estado = 3) {
                    return '<span class="label lbl-warning">EN REVISIÓN</span>';
                }
            }
        },
        {
            "data": function(d) {
                let fecha = d.fecha_abono.split('.');
                return '<p class="m-0">' + fecha[0] + '</p>';
            }
        },
        {
            "orderable": false,
            "data": function(d) {
                if (d.estado == 2) {
                    return '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas consulta_abonos" value="' + d.id_pago_bono + ','+d.nombre+ '" data-impuesto="'+d.impuesto1+'" data-toggle="tooltip" data-placement="top" title="HISTORIAL"><i class="fas fa-info"></i></button></div>';
                }
            }
        }],
        columnDefs: [{
            orderable : false,
            searchable: true,
            target: 0,
        }],
        ajax: {
            url: general_base_url + "Comisiones/getBonosPorUser/" + 2,
            type: "POST",
            cache: false,
            data: function(d) {
            }
        }
    });

    $('#tabla_bono_revision').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $("#tabla_bono_revision tbody").on("click", ".consulta_abonos", function() {
            $('#spiner-loader').removeClass('hide');
            valores = $(this).val();
            let nuevos = valores.split(',');
            impuesto = $(this).attr("data-impuesto");
    
            let id= nuevos[0];
            let nombre=nuevos[1];
            $.getJSON(general_base_url + "Comisiones/getHistorialAbono2/" + id).done(function(data) {
    
                $("#modal_bonos .modal-header").html("");
                $("#modal_bonos .modal-body").html("");
                $("#modal_bonos .modal-footer").html("");
                let fechaComentario = data[0].fecha_movimiento.split('.')[0];
                let estatus = 'EN REVISIÓN';
                $("#modal_bonos .modal-body").append(`<div class="row"><div role="tabpanel">
                <ul class="nav nav-tabs" role="tablist">
                    <h5 style="color: white;"><b>BITÁCORA DE CAMBIOS</b></h5>
    
                    <div class="row" style="color: white;"><div class="col-md-6"><h6>usuario bonificado: <b>${nombre}</b></h6></div>
                        <div class="col-md-6"><h6>monto: <b>${formatMoney(numberTwoDecimal(impuesto))}</b></h6></div>
                        <div class="col-md-6"><h6>Fecha: <b>${fechaComentario}</b></h6></div>
                        <br><div class="col-md-6"><h6>Estatus: <b>${estatus}</b></h6></div>
                      </div>
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
                    let fechaComentario = data[index].fecha_movimiento.split('.')[0];
                   $("#comments-list-asimilados").append('<div class="col-lg-12"><p><b>'+fechaComentario+'</b><b style="color:gray;"> - '+data[index].nombre_usuario+'</b><br>'+data[index].comentario+'</p><br></div>');   
               }
    
                $("#modal_bonos .modal-body").append(``);
    
                $("#modal_bonos").modal();
                $('#spiner-loader').addClass('hide');
    
            });
        });

    $(window).resize(function () {
        tabla_bono_revision.columns.adjust();
    });
});
/**------------------------- FIN TABLA REVISONES---------------------------- */

/**-----------------TABLA PAGADOS-------------------------------- */
$("#tabla_bonos_porpagar").ready(function() {
    let titulos = [];

    $('#tabla_bonos_porpagar thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_bonos_porpagar').DataTable().column(i).search() !== this.value ) {
                $('#tabla_bonos_porpagar').DataTable().column(i).search(this.value).draw();
            }
        });
        $('[data-toggle="tooltip"]').tooltip();
    });

    $('#tabla_bonos_porpagar').on('xhr.dt', function ( e, settings, json, xhr ) {
        var total = 0;
        $.each(json.data, function(i, v){
            total += parseFloat(v.impuesto1);
        });
        var to = formatMoney(numberTwoDecimal(total));
        document.getElementById("totalp").textContent = to;
    });

    tabla_nuevas3 = $("#tabla_bonos_porpagar").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'Bonos pagados',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            }
        },
        {
            text: '<i class="fas fa-play"></i>',
            className: `btn btn-dt-youtube buttons-youtube`,
            titleAttr: 'Para consultar más detalles sobre el uso y funcionalidad del apartado de Bonos podrás visualizarlo en el siguiente tutorial',
            action: function (e, dt, button, config) {
                window.open('https://youtu.be/wLDdDHQjCrw', '_blank');
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            "data": function(d) {
                return '<p class="m-0">' + d.id_pago_bono + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.nombre + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">'+d.id_rol+'</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.monto) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + formatMoney(d.n_p*d.pago) + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + formatMoney(d.monto - (d.n_p*d.pago)) + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' +d.n_p+'</b>/'+d.num_pagos+ '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.pago) + '</p>';
            }
        },
        {
            "data": function(d) {
                if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                    return '<p style="font-size: .9em !important"><b>0%</b></p>';
                }
                else{
                    let impuesto = d.impuesto;
                    return '<p class="m-0"><b>'+parseFloat(impuesto)+'%</b></p>';
                }
            }
        },
        {
            "data": function(d) {
                if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                    return '<p class="m-0"><b>' + formatMoney(d.pago) + '</b></p>';
                }
                else{
                    let iva = ((parseFloat(d.impuesto)/100)*d.pago);
                    let pagar = parseFloat(d.pago) - iva;
                    return '<p class="m-0"><b>' + formatMoney(numberTwoDecimal(pagar)) + '</b></p>';
                }
            }
        },
        {
            "data": function(d) {
                if (d.estado == 1) {
                    return '<span class="label lbl-green">NUEVO</span>';
                } else if (d.estado == 2) {
                    return '<span class="label lbl-orangeYellow">EN REVISIÓN</span>';
                } else if (d.estado == 3) {
                    return '<span class="label lbl-sky">PAGADO</span>';
                }
                else if (d.estado == 4) {
                    return '<span class="label lbl-cerulean">POR PAGAR</span>';
                } else if (d.estado == 5) {
                    return '<span class="label lbl-warning">CANCELADO</span>';
                }
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.fecha_abono + '</p>';
            }
        },
        {
            "orderable": false,
            "data": function(d) {
                if (d.estado == 4) {
                    return '<div class="d-flex justify-center">'+
                                '<button class="btn-data btn-blueMaderas consulta_abonos" value="' + d.id_pago_bono + ','+d.nombre+ ' " data-impuesto="'+d.impuesto1+'" data-toggle="tooltip" data-placement="top" title="HISTORIAL" >'+
                                    '<i class="fas fa-info"></i>'+
                                '</button>'+
                            '</div>';
                }
            }
        }],
        columnDefs: [{
            orderable : false,
            searchable: true,
            target: 0,
        }],
        ajax: {
            "url": general_base_url + "Comisiones/getBonosPorUser/" + 4,
            "type": "POST",
            cache: false,
        },
    });

    $("#tabla_bonos_porpagar tbody").on("click", ".consulta_abonos", function() {
            $('#spiner-loader').removeClass('hide');
            valores = $(this).val();
            let nuevos = valores.split(',');
            impuesto = $(this).attr("data-impuesto");
    
            let id= nuevos[0];
            let nombre=nuevos[1];
            $.getJSON(general_base_url + "Comisiones/getHistorialAbono2/" + id).done(function(data) {
    
                $("#modal_bonos .modal-header").html("");
                $("#modal_bonos .modal-body").html("");
                $("#modal_bonos .modal-footer").html("");
                let fechaComentario = data[0].fecha_movimiento.split('.')[0];
                let estatus = 'POR PAGAR';
                $("#modal_bonos .modal-body").append(`<div class="row"><div role="tabpanel">
                <ul class="nav nav-tabs" role="tablist">
                    <h5 style="color: white;"><b>BITÁCORA DE CAMBIOS</b></h5>
    
                    <div class="row" style="color: white;"><div class="col-md-6"><h6>usuario bonificado: <b>${nombre}</b></h6></div>
                        <div class="col-md-6"><h6>monto: <b>${formatMoney(numberTwoDecimal(impuesto))}</b></h6></div>
                        <div class="col-md-6"><h6>Fecha: <b>${fechaComentario}</b></h6></div>
                        <br><div class="col-md-6"><h6>Estatus: <b>${estatus}</b></h6></div>
                      </div>
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
                    let fechaComentario = data[index].fecha_movimiento.split('.')[0];
                   $("#comments-list-asimilados").append('<div class="col-lg-12"><p><b>'+fechaComentario+'</b><b style="color:gray;"> - '+data[index].nombre_usuario+'</b><br>'+data[index].comentario+'</p><br></div>');   
               }
    
                $("#modal_bonos .modal-body").append(``);
    
                $("#modal_bonos").modal();
                $('#spiner-loader').addClass('hide');
    
            });
        });
         

    $(window).resize(function () {
        tabla_bonos_porpagar.columns.adjust();
    });

    $('#tabla_bonos_porpagar').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
});
/**----------------- FIN TABLA PAGADOS-------------------------------- */

/**------------------------TABLA OTROS-------------------------------- */
$("#tabla_bono_otros").ready(function() {
    let titulos = [];

    $('#tabla_bono_otros thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_bono_otros').DataTable().column(i).search() !== this.value ) {
                $('#tabla_bono_otros').DataTable().column(i).search(this.value).draw();
            }
        });
        $('[data-toggle="tooltip"]').tooltip();
    });

    $('#tabla_bono_otros').on('xhr.dt', function ( e, settings, json, xhr ) {
        var total = 0;
        $.each(json.data, function(i, v){
            total += parseFloat(v.impuesto1);
        });
        var to = formatMoney(numberTwoDecimal(total));
        document.getElementById("totalo").textContent = to;
    });

    tabla_otros = $("#tabla_bono_otros").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title:'Otros bonos',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            }
        },
        {
            text: '<i class="fas fa-play"></i>',
            className: `btn btn-dt-youtube buttons-youtube`,
            titleAttr: 'Para consultar más detalles sobre el uso y funcionalidad del apartado de Bonos podrás visualizarlo en el siguiente tutorial',
            action: function (e, dt, button, config) {
                window.open('https://youtu.be/wLDdDHQjCrw', '_blank');
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            "data": function(d) {
                return '<p class="m-0">' + d.id_pago_bono + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.nombre + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">'+d.id_rol+'</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.monto) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + formatMoney(d.n_p*d.pago) + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + formatMoney(d.monto - (d.n_p*d.pago)) + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' +d.n_p+'</b>/'+d.num_pagos+ '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.pago) + '</p>';
            }
        },
        {
            "data": function(d) {
                if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                    return '<p class="m-0"><b>0%</b></p>';
                }
                else{
                    let impuesto = d.impuesto;
                    return '<p class="m-0"><b>'+parseFloat(impuesto)+'%</b></p>';
                }
            }
        },
        {
            "data": function(d) {
                if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                return '<p class="m-0"><b>' + formatMoney(d.pago) + '</b></p>';
                }
                else{
                    let iva = ((parseFloat(d.impuesto)/100)*d.pago);
                    let pagar = parseFloat(d.pago) - iva;
                    return '<p class="m-0"><b>' + formatMoney(numberTwoDecimal(pagar)) + '</b></p>';
                }
            }
        },
        {
            "data": function(d) {
                if (d.estado == 1) {
                    return '<span class="label lbl-green">NUEVO</span>';
                } else if (d.estado == 2) {
                    return '<span class="label lbl-orangeYellow">EN REVISIÓN</span>';
                } else if (d.estado == 3) {
                    return '<span class="label lbl-sky">PAGADO</span>';
                }
                else if (d.estado == 4) {
                    return '<span class="label lbl-cerulean">POR PAGAR</span>';
                } else if (d.estado == 5) {
                    return '<span class="label lbl-warning">CANCELADO</span>';
                }
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.fecha_abono + '</p>';
            }
        },
        {
            "orderable": false,
            "data": function(d) {
                if (d.estado == 5) {
                    return '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas consulta_abonos" value="' + d.id_pago_bono + ','+d.nombre+ '" data-impuesto="'+d.impuesto1+'" data-toggle="tooltip" data-placement="top" title="HISTORIAL"><i class="fas fa-info"></i></button></div>';
                }
            }
        }],
        columnDefs: [{
            orderable : false,
            searchable: true,
            target: 0,
        }],
        ajax: {
            url: general_base_url + "Comisiones/getBonosPorUser/" + 5,
            type: "POST",
            cache: false,
            data: function(d) {
            }
        },
    });

    $("#tabla_bono_otros tbody").on("click", ".consulta_abonos", function() {    
        $('#spiner-loader').removeClass('hide');
        valores = $(this).val();
        let nuevos = valores.split(',');
        impuesto = $(this).attr("data-impuesto");

        let id= nuevos[0];
        let nombre=nuevos[1];
        $.getJSON(general_base_url + "Comisiones/getHistorialAbono2/" + id).done(function(data) {

            $("#modal_bonos .modal-header").html("");
            $("#modal_bonos .modal-body").html("");
            $("#modal_bonos .modal-footer").html("");
            let fechaComentario = data[0].fecha_movimiento.split('.')[0];
            let estatus = 'CANCELADO';
            $("#modal_bonos .modal-body").append(`<div class="row"><div role="tabpanel">
            <ul class="nav nav-tabs" role="tablist">
                <h5 style="color: white;"><b>BITÁCORA DE CAMBIOS</b></h5>

                <div class="row" style="color: white;"><div class="col-md-6"><h6>usuario bonificado: <b>${nombre}</b></h6></div>
                    <div class="col-md-6"><h6>monto: <b>${formatMoney(numberTwoDecimal(impuesto))}</b></h6></div>
                    <div class="col-md-6"><h6>Fecha: <b>${fechaComentario}</b></h6></div>
                    <br><div class="col-md-6"><h6>Estatus: <b style="color:red;">${estatus}</b></h6></div>
                  </div>
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
                let fechaComentario = data[index].fecha_movimiento.split('.')[0];
               $("#comments-list-asimilados").append('<div class="col-lg-12"><p><b>'+fechaComentario+'</b><b style="color:gray;"> - '+data[index].nombre_usuario+'</b><br>'+data[index].comentario+'</p><br></div>');   
           }

            $("#modal_bonos .modal-body").append(``);

            $("#modal_bonos").modal();
            $('#spiner-loader').addClass('hide');

        });
    });

    $(window).resize(function () {
        tabla_bono_otros.columns.adjust();
    });

    $('#tabla_bono_otros').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

});
/**------------------------ FIN TABLA OTROS-------------------------------- */

$("#form_abono").on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(document.getElementById("form_abono"));
    formData.append("dato", "valor");
    $.ajax({
        method: 'POST',
        url: general_base_url + 'Comisiones/UpdateRevision',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data == 1) {
                $('#tabla_nuevos').DataTable().ajax.reload(null, false);
                $('#tabla_bono_revision').DataTable().ajax.reload(null, false);
                tabla_nuevas.ajax.reload();
                tabla_nuevas2.ajax.reload();
                closeModalEng();
                alerts.showNotification("top", "right", "Abono autorizado con éxito.", "success");                    
                document.getElementById("form_abono").reset();
            } else if (data == 2) {
                $('#tabla_nuevos').DataTable().ajax.reload(null, false);
                $('#tabla_bono_revision').DataTable().ajax.reload(null, false);
                closeModalEng();
            
                alerts.showNotification("top", "right", "Pago liquidado.", "warning");
        
            } else if (data == 3) {
                $('#tabla_nuevos').DataTable().ajax.reload(null, false);
                $('#tabla_bono_revision').DataTable().ajax.reload(null, false);
                closeModalEng();

                alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
            }
        },
        error: function() {
            closeModalEng();
            $('#modal_abono').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});


$(window).resize(function(){
    tabla_nuevas.columns.adjust();
});

$(window).resize(function(){
    tabla_nuevas2.columns.adjust();
});

$(window).resize(function(){
    tabla_nuevas3.columns.adjust();
});

$(window).resize(function(){
    tabla_otros.columns.adjust();
});