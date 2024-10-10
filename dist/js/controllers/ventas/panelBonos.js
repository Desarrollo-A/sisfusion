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
            console.log(data);
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

/**-------------------------  TABLA NUEVOS BONOS --------------------------- */
$("#tabla_prestamos").ready(function() {
    let titulos = [];

    $('#tabla_prestamos thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top"title="${title}" placeholder="${title}"/>`); 
        $( 'input', this).on('keyup change', function () {
            if ($('#tabla_prestamos').DataTable().column(i).search() !== this.value) {
                $('#tabla_prestamos').DataTable().column(i).search(this.value).draw();
            }   
        });
    });

    tabla_nuevas = $("#tabla_prestamos").DataTable({
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
                return '<p class="m-0">$' + formatMoney(d.monto) + '</p>';
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
                return '<p class="m-0"><b>$' + formatMoney(abonado) + '</b></p>';
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
                return '<p class="m-0"><b>$' + formatMoney(pendiente) + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' +d.n_p+'</b>/'+d.num_pagos+ '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b> $' + formatMoney(d.pago) + '</b></p>';
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
                    return '<p class="m-0"><b>$' + formatMoney(d.pago) + '</b></p>';
                }
                else{
                    let iva = ((parseFloat(d.impuesto)/100)*d.pago);
                    let pagar = parseFloat(d.pago) - iva;
                    return '<p class="m-0"><b>$' + formatMoney(pagar) + '</b></p>';
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

                if (d.estado == 1) {
                    return  '<div class="d-flex justify-center"><button class="btn btn-success btn-round btn-fab btn-fab-mini abonar" value="' + d.id_pago_bono + ',' + d.abono + '" data-toggle="tooltip" data-placement="top" title="AUTORIZAR"><i class="material-icons "   >done</i></button>' +
                    '<button class="btn btn-default btn-round btn-fab btn-fab-mini consulta_abonos" value="' + d.id_pago_bono + ','+d.nombre+'  "  data-impuesto="'+d.impuesto1+'" data-toggle="tooltip" data-placement="top" title="HISTORIAL" ><i class="material-icons" >bar_chart</i></button></div>';
                            }
            }
        }],
        ajax: {
            "url": general_base_url + "Comisiones/getBonosPorUser/" + 1,
            "type": "POST",
            cache: false,
            "data": function(d) {
            }
        },
    });

    $('#tabla_prestamos').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $("#tabla_prestamos tbody").on("click", ".consulta_abonos", function() {
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
                color='07DF9F';
            }else if(data[0].estado == 4){
                estatus=data[0].nombre;
                color='C2A205';
            }else if(data[0].estado == 5){
                estatus='CANCELADO';
                color='red';
            }
            
            let f = data[0].fecha_movimiento.split('.');
            $("#modal_bonos .modal-body").append(`<div class="row"><div class="col-md-3"><h6>PARA: <b>${nombre}</b></h6></div>
            <div class="col-md-3"><h6>Abono: <b style="color:green;">$${formatMoney(impuesto)}</b></h6></div>
            <div class="col-md-3"><h6>Fecha: <b>${f[0]}</b></h6></div>
            <div class="col-md-3"><span class="label label-danger" style="background:#${color}">${estatus}</span></h6></div>
            </div>`);

            $("#modal_bonos .modal-body").append(`<div role="tabpanel">
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
                $("#comments-list-asimilados").append('<div class="col-lg-12"><p><b style="color:#896597">'+data[index].fecha_movimiento+'</b><b style="color:gray;"> - '+data[index].nombre_usuario+'</b><br><i style="color:gray;">'+data[index].comentario+'</i></p><br></div>');   
            }
            $('#spiner-loader').addClass('hide');
            $("#modal_bonos").modal();
        });
    });

    $("#tabla_prestamos tbody").on("click", ".abonar", function() {
        bono = $(this).val();
        var dat = bono.split(",");
        $("#modal_abono .modal-body").append(`<div id="inputhidden">
        <h6>¿Seguro que deseas autorizar el bono seleccionado de <b style="color:green;">$${formatMoney(dat[1])}</b> ?</h6>
        <input type='hidden' name="id_abono" id="id_abono" value="${dat[0]}"><input type='hidden' name="pago" id="pago" value="${dat[1]}">
        <div class=" modal-footer">
        <button type="button" class="btn btn-danger btn-simple" onclick="closeModalEng()" > CANCELAR</button>
        <button type="submit" class="btn btn-primary" onclick=".abonar"> AUTORIZAR</button>
        </div>
        </div>`);

        $("#modal_abono .modal-body").append(``);
        $('#modal_abono').modal('show');
    });

    $(window).resize(function () {
        tabla_prestamos.columns.adjust();
    });
});
/** ------------------------ FIN TABLA NUEVOS BONOS ------------------------ */

/**-------------------------TABLA REVISONES-------------------------------- */
$("#tabla_bono_revision").ready(function() {
    let titulos = [];

    $('#tabla_bono_revision thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top"title="${title}" placeholder="${title}"/>`); 
        $( 'input', this).on('keyup change', function () {
            if ($('#tabla_bono_revision').DataTable().column(i).search() !== this.value) {
                $('#tabla_bono_revision').DataTable().column(i).search(this.value).draw();
            }   
        });
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
                return '<p class="m-0">$' + formatMoney(d.monto) + '</p>';
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
                return '<p class="m-0"><b>$' + formatMoney(abonado) + '</b></p>';
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
                return '<p class="m-0"><b>$' + formatMoney(pendiente) + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' +d.n_p+'</b>/'+d.num_pagos+ '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>$' + formatMoney(d.pago) + '</b></p>';
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
                    return '<p class="m-0"><b>$' + formatMoney(d.pago) + '</b></p>';
                }
                else{
                    let iva = ((parseFloat(d.impuesto)/100)*d.pago);
                    let pagar = parseFloat(d.pago) - iva;
                    return '<p class="m-0"><b>$' + formatMoney(pagar) + '</b></p>';
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
                color='07DF9F';
            }else if(data[0].estado == 4){
                estatus=data[0].nombre;
                color='C2A205';
            }else if(data[0].estado == 5){
                estatus='CANCELADO';
                color='red';
            }
    
            let f = data[0].fecha_movimiento.split('.');
            $("#modal_bonos .modal-body").append(`<div class="row"><div class="col-md-3"><h6>PARA: <b>${nombre}</b></h6></div>
            <div class="col-md-3"><h6>Abono: <b style="color:green;">$${formatMoney(impuesto)}</b></h6></div>
            <div class="col-md-3"><h6>Fecha: <b>${f[0]}</b></h6></div>
            <div class="col-md-3"><span class="label label-danger" style="background:#${color}">${estatus}</span></h6></div>
            </div>`);

            $("#modal_bonos .modal-body").append(`<div role="tabpanel">
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
                $("#comments-list-asimilados").append('<div class="col-lg-12"><p><b style="color:#896597">'+data[index].fecha_movimiento+'</b><b style="color:gray;"> - '+data[index].nombre_usuario+'</b><br><i style="color:gray;">'+data[index].comentario+'</i></p><br></div>');  
            }

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
$("#tabla_bono_pagado").ready(function() {
    let titulos = [];

    $('#tabla_bono_pagado thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top"title="${title}" placeholder="${title}"/>`); 
        $( 'input', this).on('keyup change', function () {
            if ($('#tabla_bono_pagado').DataTable().column(i).search() !== this.value) {
                $('#tabla_bono_pagado').DataTable().column(i).search(this.value).draw();
            }   
        });
    });

    $('#tabla_bono_pagado').on('xhr.dt', function ( e, settings, json, xhr ) {
        var total = 0;
        $.each(json.data, function(i, v){
            total += parseFloat(v.impuesto1);
        });
        var to = formatMoney(total);
        document.getElementById("totalp").textContent = '$' +  to;
    });

    tabla_nuevas3 = $("#tabla_bono_pagado").DataTable({
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
                return '<p class="m-0">$' + formatMoney(d.monto) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>$' + formatMoney(d.n_p*d.pago) + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>$' + formatMoney(d.monto - (d.n_p*d.pago)) + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' +d.n_p+'</b>/'+d.num_pagos+ '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">$' + formatMoney(d.pago) + '</p>';
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
                    return '<p class="m-0"><b>$' + formatMoney(d.pago) + '</b></p>';
                }
                else{
                    let iva = ((parseFloat(d.impuesto)/100)*d.pago);
                    let pagar = parseFloat(d.pago) - iva;
                    return '<p class="m-0"><b>$' + formatMoney(pagar) + '</b></p>';
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
                    return '<div class="d-flex justify-center"><button class="btn btn-default btn-round btn-fab btn-fab-mini consulta_abonos" value="' + d.id_pago_bono + ','+d.nombre+ ' " data-impuesto="'+d.impuesto1+'" data-toggle="tooltip" data-placement="top" title="HISTORIAL" ><i class="material-icons">bar_chart</i></button></div>';
                }
            }
        }],
        ajax: {
            "url": general_base_url + "Comisiones/getBonosPorUser/" + 4,
            "type": "POST",
            cache: false,
        },
    });

    $("#tabla_bono_pagado tbody").on("click", ".consulta_abonos", function() {
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

            let estatus = '';
            let color='';
            
            color='1E8449';
            estatus = 'PAGADO';
            $("#modal_bonos .modal-body").append(`<div class="row"><div role="tabpanel">
            <ul class="nav nav-tabs" role="tablist" style="background: #71B85C;">
                <h5 style="color: white;"><b>BONOS PAGADOS</b></h5>
            </ul>
            </div>`);
            $("#modal_bonos .modal-body").append(`<div class="col-md-3"><h6>PARA: <b>${nombre}</b></h6></div>
            <div class="col-md-3"><h6>Abono: <b style="color:green;">$${formatMoney(impuesto)}</b></h6></div>
            <div class="col-md-3"><h6>Fecha: <b>${data[0].fecha_movimiento}</b></h6></div>
            <br><div class="col-md-3"><span class="label label-danger" style="background:#${color}">${estatus}</span></h6></div>
            </div>  `);

            $("#modal_bonos").modal();
            $('#spiner-loader').addClass('hide'); 
        });
    });

    $(window).resize(function () {
        tabla_bono_pagado.columns.adjust();
    });

    $('#tabla_bono_pagado').on('draw.dt', function() {
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
        titulos.push(title);
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top"title="${title}" placeholder="${title}"/>`); 
        $( 'input', this).on('keyup change', function () {
            if ($('#tabla_bono_otros').DataTable().column(i).search() !== this.value) {
                $('#tabla_bono_otros').DataTable().column(i).search(this.value).draw();
            }   
        });
    });

    $('#tabla_bono_otros').on('xhr.dt', function ( e, settings, json, xhr ) {
        var total = 0;
        $.each(json.data, function(i, v){
            total += parseFloat(v.impuesto1);
        });
        var to = formatMoney(total);
        document.getElementById("totalo").textContent = '$' +  to;
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
                return '<p class="m-0">$' + formatMoney(d.monto) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>$' + formatMoney(d.n_p*d.pago) + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>$' + formatMoney(d.monto - (d.n_p*d.pago)) + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' +d.n_p+'</b>/'+d.num_pagos+ '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">$' + formatMoney(d.pago) + '</p>';
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
                return '<p class="m-0"><b>$' + formatMoney(d.pago) + '</b></p>';
                }
                else{
                    let iva = ((parseFloat(d.impuesto)/100)*d.pago);
                    let pagar = parseFloat(d.pago) - iva;
                    return '<p class="m-0"><b>$' + formatMoney(pagar) + '</b></p>';
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

            let estatus = '';
            let color='';
            color='RED';
            estatus = 'CANCELADO';
            $("#modal_bonos .modal-body").append(`<div class="row"><div role="tabpanel">
            <ul class="nav nav-tabs" role="tablist" style="background: #EA4335;">
                <h5 style="color: white;"><b>BONOS CANCELADOS</b></h5>
            </ul>
            </div>`);
            $("#modal_bonos .modal-body").append(`<div class="row"><div class="col-md-3"><h6>PARA: <b>${nombre}</b></h6></div>
            <div class="col-md-3"><h6>Abono: <b style="color:green;">$${formatMoney(impuesto)}</b></h6></div>
            <div class="col-md-3"><h6>Fecha: <b>${data[0].fecha_movimiento}</b></h6></div>
            <br><div class="col-md-3"><span class="label label-danger" style="background:#${color}">${estatus}</span></h6></div>
            </div>`);

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
            console.log(data);
            if (data == 1) {
                $('#tabla_prestamos').DataTable().ajax.reload(null, false);
                $('#tabla_bono_revision').DataTable().ajax.reload(null, false);
                
                tabla_nuevas.ajax.reload();
                tabla_nuevas2.ajax.reload();
                closeModalEng();

                alerts.showNotification("top", "right", "Abono autorizado con éxito.", "success");                    
                document.getElementById("form_abono").reset();

            } else if (data == 2) {
                $('#tabla_prestamos').DataTable().ajax.reload(null, false);
                $('#tabla_bono_revision').DataTable().ajax.reload(null, false);
                closeModalEng();
            
                alerts.showNotification("top", "right", "Pago liquidado.", "warning");
        
            } else if (data == 3) {
                $('#tabla_prestamos').DataTable().ajax.reload(null, false);
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