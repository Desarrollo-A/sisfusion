function closeModalEng() {
    document.getElementById("form_abono").reset();
    a = document.getElementById('inputhidden');
    padre = a.parentNode;
    padre.removeChild(a);
    $("#modal_abono").modal('toggle');
}

$("#tabla_prestamos").ready(function() {
    let titulos = [];

    $('#tabla_prestamos thead tr:eq(0) th').each(function(i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_prestamos').DataTable().column(i).search() !== this.value ) {
                $('#tabla_prestamos').DataTable().column(i).search(this.value).draw();
            }
        });
    });

    tabla_nuevas = $("#tabla_prestamos").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title:'Nuevos bonos',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url+"static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            data: function(d) {
                return '<p class="m-0">' + d.id_pago_bono + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombre + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">'+d.id_rol+'</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + formatMoney(d.monto) + '</p>';
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
                return '<p class="m-0"><b>' + formatMoney(abonado) + '</b></p>';
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
                return '<p class="m-0"><b>' + formatMoney(pendiente) + '</b></p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0"><b>' +d.n_p+'</b>/'+d.num_pagos+ '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0"><b>' + formatMoney(d.pago) + '</b></p>';
            }
        },
        {
            data: function(d) {
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
            data: function(d) {
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
            data: function(d) {
                if (d.estado == 1) {
                    return '<span class="label lbl-green">NUEVO</span>';
                } else if (d.estado == 2) {
                    return '<span class="label lbl-orangeYellow">EN REVISION</span>';
                } else if (d.estado = 3) {
                    return '<span class="label lbl-orangeYellow">EN REVISION</span>';
                }
            }
        },
        {
            data: function(d) {
                let fecha = d.fecha_abono.split('.');
                return '<p class="m-0">' + fecha[0] + '</p>';
            }
        },
        {
            orderable: false,
            data: function(d) {
                if (d.estado == 1) {
                    return '<div class="d-flex justify-center"><button class="btn-data btn-green abonar" value="' + d.id_pago_bono + ',' + d.abono + '" data-toggle="tooltip" data-placement="top" title="AUTORIZAR"><i class="material-icons" >done</i></button>' +
                        '<button class="btn-data btn-gray consulta_abonos" value="' + d.id_pago_bono + ','+d.nombre+'  " data-impuesto="'+d.impuesto1+'" data-toggle="tooltip" data-placement="top" title="HISTORIAL"><i class="fas fa-eye"></i></button></div>';
                }
            }
        }],
        ajax: {
            "url": general_base_url + "Comisiones/getBonosPorUser/" + 1,
            "type": "POST",
            cache: false,
            data: function(d) {}
        },
    });

    $("#tabla_prestamos tbody").on("click", ".consulta_abonos", function() {
        $('#spiner-loader').removeClass('hide');
        valores = $(this).val();
        let nuevos = valores.split(',');
        impuesto2 = $(this).attr("data-impuesto");
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
                color='00A0FF';
            }else if(data[0].estado == 4){
                estatus=data[0].nombre;
                color='C2A205';
            }else if(data[0].estado == 5){
                estatus='CANCELADO';
                color='B03A2E';
            }

            let f = data[0].fecha_movimiento.split('.');
            let impuesto = parseFloat(data[0].impuesto);
            let monto = parseFloat(data[0].abono);
            let operacion = parseFloat(monto - ((impuesto/100)*monto));
            data[0].abono = operacion;
            $("#modal_bonos .modal-body").append(`
            <div class="row">
                <div class="ml-2">
                    <h6 class="m-0">PARA: <b>${nombre}</b></h6>
                </div>
            </div>
            <div class="row">
                <div class="ml-2">
                    <h6 class="m-0">Abono: <b style="color:green;">${formatMoney(impuesto2)}</b></h6>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 m-0"><h6 class="m-0">Fecha: <b>${f[0]}</b></h6></div>
                <div class="col-md-6 d-flex justify-end m-0"><span class="label label-danger" style="color:#${color}; background:#${color}18">${estatus}</span></h6></div>
            </div>`);

            $("#modal_bonos .modal-body").append(`
            <div role="tabpanel">
                <h5 class="text-center mt-4 mb-0"><b>BITÁCORA DE CAMBIOS</b></h5>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="changelogTab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-plain m-0">
                                    <div class="card-content scroll-styles" style=" height: 200px; overflow: auto" pt-0">
                                        <ul class="timeline-3" id="comments-list-asimilados"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`);

            for (let index = 0; index < data.length; index++) {
                $("#comments-list-asimilados").append('<li>\n' +
                '  <div class="container-fluid">\n' +
                '    <div class="row">\n' +
                '      <div class="col-md-6">\n' +
                '        <a><b> ' +data[index].comentario+ '</b></a><br>\n' +
                '      </div>\n' +
                '      <div class="float-end text-right">\n' +
                '        <a>' +data[index].fecha_movimiento.split('.')[0] + '</a>\n' +
                '      </div>\n' +
                '      <div class="col-md-12">\n' +
                '        <p class="m-0"><small>Usuario: </small><b> ' +data[index].nombre_usuario+ '</b></p>\n'+
                '      </div>\n' +
                '    <h6>\n' +
                '    </h6>\n' +
                '    </div>\n' +
                '  </div>\n' +
                '</li>'); 
                }
            $('#spiner-loader').addClass('hide');
            $("#modal_bonos").modal();
        });
    });

    $("#tabla_prestamos tbody").on("click", ".abonar", function() {
        $('#spiner-loader').removeClass('hide');
        bono = $(this).val();
        var dat = bono.split(",");
        $("#modal_abono .modal-body").append(`
        <div id="inputhidden">
            <h6><em>¿Seguro que deseas autorizar el bono seleccionado de <b style="color:green;">${formatMoney(dat[1])}</em></b> ?</h6>
            <input type='hidden' name="id_abono" id="id_abono" value="${dat[0]}"><input type='hidden' name="pago" id="pago" value="${dat[1]}">
            <div class="row d-flex justify-end pr-2">
                <button type="button" onclick="closeModalEng()" class=" btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button>
                <button type="submit" id="" class="btn btn-primary">AUTORIZAR</button>
            </div>
        </div>`);
        $('#spiner-loader').addClass('hide');
        $("#modal_abono .modal-body").append(``);
        $('#modal_abono').modal('show');
    });
});

/**------------------------------------------------------------------TABLA REVISONES-------------------------------- */
$("#tabla_bono_revision").ready(function() {
    let titulos = [];
    $('#tabla_bono_revision thead tr:eq(0) th').each(function(i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_bono_revision').DataTable().column(i).search() !== this.value ) {
                $('#tabla_bono_revision').DataTable().column(i).search(this.value).draw();
            }
        });
    });

    tabla_nuevas = $("#tabla_bono_revision").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title:'Bonos en revisión',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url+"static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        orderable: false,
        columns: [{
            data: function(d) {
                return '<p class="m-0">' + d.id_pago_bono + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombre + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">'+d.id_rol+'</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + formatMoney(d.monto) + '</p>';
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
                return '<p class="m-0"><b>' + formatMoney(abonado) + '</b></p>';
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
                return '<p class="m-0"><b>' + formatMoney(pendiente) + '</b></p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0"><b>' +d.n_p+'</b>/'+d.num_pagos+ '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0"><b>' + formatMoney(d.pago) + '</b></p>';
            }
        },
        {
            data: function(d) {
                if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                    return '<p class="m-0"><b>0%</b></p>';
                }else{
                    let impuesto = d.impuesto;
                    return '<p class="m-0"><b>'+parseFloat(impuesto)+'%</b></p>';
                }
            }
        },
        {
            data: function(d) {
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
            data: function(d) {
                if (d.estado == 1) {
                    return '<span class="label lbl-green">NUEVO</span>';
                } else if (d.estado == 2) {
                    return '<span class="label lbl-orangeYellow">EN REVISION</span>';
                } else if (d.estado = 3) {
                    return '<span class="label lbl-orangeYellow">EN REVISION</span>';
                }
            }
        },
        {
            data: function(d) {
                let fecha = d.fecha_abono.split('.');
                return '<p class="m-0">' + fecha[0] + '</p>';
            }
        },
        {
            data: function(d) {
                if (d.estado == 2) {
                    return '<div class="d-flex justify-center"><button class="btn-data btn-gray consulta_abonos" value="' + d.id_pago_bono + ','+d.nombre+ ' " data-impuesto="'+d.impuesto1+'" data-toggle="tooltip" data-placement="right" title="HISTORIAL"><i class="fas fa-eye"></i></button></div>';
                }
            }
        }
        ],
        ajax: {
            url: general_base_url + "Comisiones/getBonosPorUser/" + 2,
            type: "POST",
            cache: false,
            data: function(d) {
            }
        },
    });

    $("#tabla_bono_revision tbody").on("click", ".consulta_abonos", function() {
        $('#spiner-loader').removeClass('hide');
        valores = $(this).val();
        let nuevos = valores.split(',');
        impuesto2 = $(this).attr("data-impuesto");
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
                color='00A0FF';
            }else if(data[0].estado == 4){
                estatus=data[0].nombre;
                color='C2A205';
            }else if(data[0].estado == 5){
                estatus='CANCELADO';
                color='B03A2E';
            }
            let f = data[0].fecha_movimiento.split('.');
            let impuesto = parseFloat(data[0].impuesto);
            let monto = parseFloat(data[0].abono);
            let operacion = parseFloat(monto - ((impuesto/100)*monto));
            data[0].abono = operacion;
            $("#modal_bonos .modal-body").append(`
            <div class="row">
                <div class="ml-2">
                    <h6 class="m-0">PARA: <b>${nombre}</b></h6>
                </div>
            </div>
            <div class="row">
                <div class="ml-2">
                    <h6 class="m-0">Abono: <b style="color:green;">${formatMoney(impuesto2)}</b></h6>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 m-0"><h6 class="m-0">Fecha: <b>${f[0]}</b></h6></div>
                <div class="col-md-6 d-flex justify-end m-0"><span class="label label-danger" style="color:#${color}; background:#${color}18">${estatus}</span></h6></div>
            </div>`);
            $("#modal_bonos .modal-body").append(`
            <div role="tabpanel">
                <h5 class="text-center mt-4 mb-0"><b>BITÁCORA DE CAMBIOS</b></h5>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="changelogTab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-plain m-0">
                                    <div class="card-content scroll-styles" style=" height: 200px; overflow: auto" pt-0">
                                        <ul class="timeline-3" id="comments-list-asimilados"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`);
            for (let index = 0; index < data.length; index++) {
                $("#comments-list-asimilados").append('<li>\n' +
                '  <div class="container-fluid">\n' +
                '    <div class="row">\n' +
                '      <div class="col-md-6">\n' +
                '        <a><b> ' +data[index].comentario+ '</b></a><br>\n' +
                '      </div>\n' +
                '      <div class="float-end text-right">\n' +
                '        <a>' +data[index].fecha_movimiento.split('.')[0] + '</a>\n' +
                '      </div>\n' +
                '      <div class="col-md-12">\n' +
                '        <p class="m-0"><small>Usuario: </small><b> ' +data[index].nombre_usuario+ '</b></p>\n'+
                '      </div>\n' +
                '    <h6>\n' +
                '    </h6>\n' +
                '    </div>\n' +
                '  </div>\n' +
                '</li>'); 
                }
            $('#spiner-loader').addClass('hide');
            $("#modal_bonos").modal();
        });
    });

});
/**---------------TABLA PAGADOS-------------------------------- */
$("#tabla_bono_pagado").ready(function() {
    let titulos = [];
    $('#tabla_bono_pagado thead tr:eq(0) th').each(function(i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_bono_pagado').DataTable().column(i).search() !== this.value ) {
                $('#tabla_bono_pagado').DataTable().column(i).search(this.value).draw();
            }
        });
    });

    tabla_nuevas = $("#tabla_bono_pagado").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title:'Bonos pagados',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url+"static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            data: function(d) {
                return '<p class="m-0">' + d.id_pago_bono + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombre + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">'+d.id_rol+'</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + formatMoney(d.monto) + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0"><b>' + formatMoney(d.n_p*d.pago) + '</b></p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0"><b>' + formatMoney(d.monto - (d.n_p*d.pago)) + '</b></p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0"><b>' +d.n_p+'</b>/'+d.num_pagos+ '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + formatMoney(d.pago) + '</p>';
            }
        },
        {
            data: function(d) {
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
            data: function(d) {
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
            data: function(d) {
                return '<span class="label lbl-cerulean">POR PAGAR</span>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.fecha_abono + '</p>';
            }
        },
        {
            orderable: false,
            data: function(d) {
                if (d.estado == 4) {
                    return '<div class="d-flex justify-center"><button class="btn-data btn-gray consulta_abonos" value="' + d.id_pago_bono + ','+d.nombre+ ' " data-toggle="tooltip" data-placement="top" title="HISTORIAL"><i class="fas fa-eye"></i></button></div>';
                }
            }
        }],
        ajax: {
            "url": general_base_url + "Comisiones/getBonosPorUser/" + 4,
            "type": "POST",
            cache: false,
            data: function(d) {
            }
        },
    });

    $("#tabla_bono_pagado tbody").on("click", ".consulta_abonos", function() {
        $('#spiner-loader').removeClass('hide');
        valores = $(this).val();
        let nuevos = valores.split(',');
        let id= nuevos[0];
        let nombre=nuevos[1];
        $.getJSON(general_base_url + "Comisiones/getHistorialAbono2/" + id).done(function(data) {
            $("#modalBonos2 .modal-header").html("");
            $("#modalBonos2 .modal-body").html("");
            $("#modalBonos2 .modal-footer").html("");
            let estatus = 'PAGADO';
            $("#modalBonos2 .modal-body").append(`
            <div class="row aligned-row">
                <div class="col-sm-12 col-md-8" style="font-size:11px"><h6>Fecha: <b>${data[0].fecha_abono}</b></h6></div>
                <div class="col-sm-12 col-md-4 d-flex align-center"><span class="label lbl-cerulean">${estatus}</span></h6></div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-12 col-md-12"><h6 class="m-0">PARA: <b>${nombre}</b></h6></div>
                <div class="col-sm-12 col-md-12"><h6 class="m-0">Abono: <b style="color:green;">${formatMoney(data[0]['abono'])}</b></h6></div>
            </div>
            `);
            $("#modalBonos2").modal();
            $('#spiner-loader').addClass('hide');
        });
    });
});
/**---------------------------------TABLA PAGADOS-------------------------------- */
$("#tabla_bono_otros").ready(function() {
    let titulos = [];
    $('#tabla_bono_otros thead tr:eq(0) th').each(function(i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_bono_otros').DataTable().column(i).search() !== this.value ) {
                $('#tabla_bono_otros').DataTable().column(i).search(this.value).draw();
            }
        });
    });

    tabla_otros = $("#tabla_bono_otros").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
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
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url+"static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            data: function(d) {
                return '<p class="m-0">' + d.id_pago_bono + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombre + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">'+d.id_rol+'</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + formatMoney(d.monto) + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0"><b>' + formatMoney(d.n_p*d.pago) + '</b></p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0"><b>' + formatMoney(d.monto - (d.n_p*d.pago)) + '</b></p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0"><b>' +d.n_p+'</b>/'+d.num_pagos+ '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + formatMoney(d.pago) + '</p>';
            }
        },
        {
            data: function(d) {
                if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                    return '<p class="m-0"><b>0%</b></p>';
                }else{
                    let impuesto = d.impuesto;
                    return '<p class="m-0"><b>'+parseFloat(impuesto)+'%</b></p>';
                }
            }
        },
        {
            data: function(d) {
                if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                    return '<p class="m-0"><b>' + formatMoney(d.pago) + '</b></p>';
                }else{
                    let iva = ((parseFloat(d.impuesto)/100)*d.pago);
                    let pagar = parseFloat(d.pago) - iva;
                    return '<p class="m-0"><b>' + formatMoney(pagar) + '</b></p>';
                }
            }
        },
        {
            data: function(d) {
                return '<span class="label lbl-warning">CANCELADO</span>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.fecha_abono + '</p>';
            }
        },
        {
            "orderable": false,
            data: function(d) {
                if (d.estado == 5) {
                    return '<div class="d-flex justify-center"><button class="btn-data btn-gray consulta_abonos" value="' + d.id_pago_bono + ','+d.nombre+ ' " data-toggle="tooltip" data-placement="top" title="HISTORIAL"><i class="fas fa-eye"></i></button></div>';
                }
            }
        }],
        ajax: {
            "url": general_base_url + "Comisiones/getBonosPorUser/" + 5,
            "type": "POST",
            cache: false,
            data: function(d) {
            }
        },
    });

    $("#tabla_bono_otros tbody").on("click", ".consulta_abonos", function() {
        $('#spiner-loader').removeClass('hide');
        valores = $(this).val();
        let nuevos = valores.split(',');
        let id= nuevos[0];
        let nombre=nuevos[1];
        $.getJSON(general_base_url + "Comisiones/getHistorialAbono2/" + id).done(function(data) {
            $("#modalBonos2 .modal-header").html("");
            $("#modalBonos2 .modal-body").html("");
            $("#modalBonos2 .modal-footer").html("");
            let estatus = 'CANCELADO';
            $("#modalBonos2 .modal-body").append(`
            <div class="row aligned-row">
                <div class="col-sm-12 col-md-8" style="font-size:11px"><h6>Fecha: <b>${data[0].fecha_abono}</b></h6></div>
                <div class="col-sm-12 col-md-4 d-flex align-center"><span class="label lbl-warning">${estatus}</span></h6></div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-12 col-md-12"><h6 class="m-0">PARA: <b>${nombre}</b></h6></div>
                <div class="col-sm-12 col-md-12"><h6 class="m-0">Abono: <b style="color:red;">${formatMoney(data[0]['abono'])}</b></h6></div>
            </div>
            `);
            $("#modalBonos2").modal();
            $('#spiner-loader').addClass('hide');
        });
    });
});

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
                $('#tabla_prestamos').DataTable().ajax.reload(null, false);
                $('#tabla_bono_revision').DataTable().ajax.reload(null, false);
                
                tabla_nuevas.ajax.reload();
                closeModalEng();
                alerts.showNotification("top", "right", "Abono autorizado con exito.", "success");
            
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

$('body').tooltip({
    selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
    trigger: 'hover',
    container: 'body'
}).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
    $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
});