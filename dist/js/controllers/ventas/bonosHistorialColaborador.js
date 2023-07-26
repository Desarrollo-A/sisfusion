$("#tabla_prestamos").ready(function() {
    let titulos = [];
    $('#tabla_prestamos thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top"title="${title}" placeholder="${title}"/>`); 
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
                document.getElementById("totaln").textContent = total;
            }
        });
        $('[data-toggle="tooltip"]').tooltip({trigger: "hover" });
    });

    $('#tabla_prestamos').on('xhr.dt', function ( e, settings, json, xhr ) {
        var total = 0;
        $.each(json.data, function(i, v){
            total += parseFloat(v.pago);
        });
        var to = formatMoney(total);
        document.getElementById("totaln").textContent = to;
    });


    tabla_nuevas = $("#tabla_prestamos").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width:'100%',
        scrollX:true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'Historial bonos',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11,12],
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
            titleAttr: 'Para consultar más detalles sobre el uso y funcionalidad del apartado de Historial bonos podrás visualizarlo en el siguiente tutorial',
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
                    return '<p class="m-0"><b>' + formatMoney(pagar) + '</b></p>';
                }
            }
        },
        {
            "data": function(d) {
                if (d.estado == 1) {
                    return '<span class="label lbl-green">'+d.name+'</span>';
                } else if (d.estado == 2) {
                    return '<span class="label lbl-orangeYellow">'+d.name+'</span>';
                } else if (d.estado == 3) {
                    return '<span class="label lbl-cerulean">'+d.name+'</span>';
                }else if (d.estado == 4) {
                    return '<span class="label lbl-yellow">'+d.name+'</span>';
                }else if (d.estado == 5) {
                    return '<span class="label lbl-warning">'+d.name+'</span>';
                }else if (d.estado == 6) {
                    return '<span class="label lbl-sky">'+d.name+'</span>';
                }
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.comentario + '</p>';
            }
        },
        {
            "data": function(d) {
                let fecha = d.fecha_abono.split('.')
                return '<p class="m-0">' + fecha[0] + '</p>';
            }
        },
        {
            "orderable": false,
            "data": function(d) {
                return '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas consulta_abonos" value="' + d.id_pago_bono + ','+d.nombre+'" data-impuesto="'+d.impuesto1+'" title="HISTORIAL"><i class="fas fa-info"></i></button></div>';
            }
        }],
        ajax: {
            "url": general_base_url + "Comisiones/getBonosX_User",
            "type": "POST",
            cache: false,
            "data": function(d) {

            }
        },
    });

    $("#tabla_prestamos tbody").on("click", ".consulta_abonos", function() {
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

            let f = data[0].fecha_movimiento.split('.');

            $("#modal_bonos .modal-body").append(`<div class="row"><div class="col-md-3"><h6>PARA: <b>${nombre}</b></h6></div>
            <div class="col-md-3"><h6>Abono: <b style="color:green;">${formatMoney(impuesto)}</b></h6></div>
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
        });
    });
});
