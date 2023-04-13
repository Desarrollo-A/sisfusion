$("#tabla_ingresar_9").ready(function () {
    let titulos = [];
    $('#tabla_ingresar_9 thead tr:eq(0) th').each(function (i) {
        if (i != 0) {
            var title = $(this).text();
            titulos.push(title);

            $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if (tabla_1.column(i).search() !== this.value) {
                    tabla_1.column(i).search(this.value).draw();
                }
            });
        }
    });

    tabla_1 = $("#tabla_ingresar_9").DataTable({
        dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: 'auto',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COMISIONES LIQUIDADAS',
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8,9,10,11,12],
                format: {
                    header: function (d, columnIdx) {
                        if (columnIdx != 0) {
                            return ' ' + titulos[columnIdx - 1] + ' ';
                        }
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: url+"/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            width: "3%",
            className: 'details-control',
            orderable: false,
            data : null,
            defaultContent: '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
        },
        {
            "width": "8%",
            "data": function( d ){
                var lblStats;
                lblStats ='<p class="m-0"><b>'+d.idLote+'</b></p>';
                return lblStats;
            }
        },
        {
            "width": "8%",
            "data": function( d ){
                return '<p class="m-0">'+d.nombreResidencial+'</p>';
            }
        },
        {
            "width": "8%",
            "data": function( d ){
                return '<p class="m-0">'+(d.nombreCondominio).toUpperCase();+'</p>';
            }
        },
        
        {
            "width": "15%",
            "data": function( d ){
                return '<p class="m-0">'+d.nombreLote+'</p>';
            }
        }, 
      
        {
        "width": "12%",
        "data": function( d ){
            return '<p class="m-0"><b>'+d.nombre_cliente+'</b></p>';
        }
    }, 

    {
        "width": "7%",
        "data": function( d ){
            var lblType;
            if(d.tipo_venta==1) {
                lblType ='<span class="label label-danger">Particular</span>';
            }else if(d.tipo_venta==2) {
                lblType ='<span class="label label-success">normal</span>';
            }
            else if(d.tipo_venta==7) {
                lblType ='<span class="label label-warning">especial</span>';
            }else{
                lblType ='<span class="label label-danger">SIN TIPO DE VENTA</span>';
            }
            return lblType;
        }
    },           
    {
        "width": "8%",
        "data": function( d ){
            var lblStats;
            if(d.compartida==null) {
                lblStats ='<span class="label label-warning" style="background:#E5D141;">Individual</span>';
            }else {
                lblStats ='<span class="label label-warning">Compartida</span>';
            }
            return lblStats;
        }
    },   {
        "width": "7%",
        "data": function( d ){
            var lblStats;
            if(d.idStatusContratacion==15) {
                lblStats ='<span class="label label-success" style="background:#9E9CD5;">Contratado</span>';
            }else {
                lblStats ='<p class="m-0"><b>'+d.idStatusContratacion+'</b></p>';
            }
            return lblStats;
        }
    },
    {
        "width": "8%",
        "data": function( d ){
            var lblStats;

            if(d.date_final == null ) {
                lblStats ='';
            
                lblStats ='<span class="label label-gray" style="background:#AFAFB0;">Sin especificar</span>';
            
            }else{

                lblStats ='<span class="label label-info" style="background:#11DFC6;">'+d.date_final +'</span>';
            }
            return lblStats;
        }
    },
    {
        "width": "8%",
        "data": function( d ){
            var lblStats;
            var date_neodata
             if (d.registro_comision == 8){
                lblStats ='<span class="label label-gray" style="color:gray;">Recisión Nueva Venta</span>';
            }
            else {
                if(d.date_neodata == null){
                    date_neodata = 'No definida';
                }else{
                    date_neodata = d.date_neodata;
                }
                lblStats ='<span class="label label-info" >'+date_neodata+'</span>';
            }
            return lblStats;
        }
    },
    {
        "width": "8%",
        "data": function( d ){
            return d.plan_descripcion;
        }
    },
    {
            "width": "15%",
            "data": function( d ){
                return '$'+formatMoney(d.abono_comisiones);
                // return '<p class="m-0">'+d.nombreLote+'</p>';

            }
    },
    {
                "data": function (d) {
                    if (d.porcentaje_comisiones) {
                        return `${parseInt(d.porcentaje_comisiones)}%`;
                    }
                    return '-';
                }
    },
    {
            "width": "15%",
            "data": function( d ){
                return '$'+formatMoney(d.pendiente);
            }
    },
    {
            "width": "8%",
            "orderable": false,
            "data": function (data) {
                var BtnStats;
                if (data.totalNeto2 == null) {
                    BtnStats = '';
                } else {
                    if (data.compartida == null) {
                        BtnStats = '<button href="#" value="' + data.idLote + '" data-value="' + data.registro_comision + '" data-code="' + data.cbbtton + '" ' +
                            'class="btn-data btn-green verify_neodata" title="Verificar en NEODATA">' +
                            '<i class="material-icons">person</i></button>';
                    } else {
                        BtnStats = '<button href="#" value="' + data.idLote + '" data-value="' + data.registro_comision + '" data-code="' + data.cbbtton + '" ' +
                            'class="btn-data btn-sky verify_neodata" title="Verificar en NEODATA">' +
                            '<i class="material-icons">group</i></button>';
                    }
                }
                return '<div class="d-flex justify-center">' + BtnStats + '</div>';
            }
        }],
        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        ajax: {
            url: url+'/Comisiones/getSettledCommissions',
            dataSrc: "",
            type: "POST",
            cache: false,
            data: function (d) {}
        },
    });

    $('#tabla_ingresar_9 tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = tabla_1.row(tr);
    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');
        $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
    } 
    else {

        var informacion_adicional = `<div class="container subBoxDetail"><div class="row"><div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>Información colaboradores</b></label></div>
        <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Director: </b>` + row.data().director + `</label></div>
        <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Regional: </b>` + row.data().regional + `</label></div>
        <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Subdirector: </b>` + row.data().subdirector + `</label></div><div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Gerente: </b>` + row.data().gerente + `</label></div>
        <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Coordinador: </b>` + row.data().coordinador + `</label></div><div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Asesor: </b>` + row.data().asesor + `</label></div>
        </div></div>`;

        row.child(informacion_adicional).show();
        tr.addClass('shown');
        $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
    }
});

    $("#tabla_ingresar_9 tbody").on("click", ".verify_neodata", function () {
        var tr = $(this).closest('tr');
        var row = tabla_1.row(tr);
        idLote = $(this).val();

        registro_status = $(this).attr("data-value");

        $("#modal_NEODATA .modal-header").html("");
        $("#modal_NEODATA .modal-body").html("");
        $("#modal_NEODATA .modal-footer").html("");

        $.getJSON(url + "ComisionesNeo/getStatusNeodata/" + idLote).done(function (data) {

            if (data.length > 0) {
                switch (data[0].Marca) {
                    case 0:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>En espera de próximo abono en NEODATA de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;

                    case 1:
                        $.getJSON( url + "Comisiones/getDatosAbonadoSuma11/"+idLote).done( function( data1 ){    
                            let total0 = parseFloat((data[0].Aplicado));
                            let total = 0;

                            if(total0 > 0){
                                total = total0;
                            }
                            else{
                                total = 0; 
                            }

                            var counts=0;
                            $("#modal_NEODATA .modal-header").append('<div class="row"><div class="col-md-6"><h4><b>Lote liquidado: </b>'+row.data().nombreLote+'</i></h4></div><div class="col-md-6"><h4><b>Precio lote: </b>$'+formatMoney(data1[0].totalNeto2)+'</i></h4></div></div><br>');

                            if(parseFloat(data[0].Bonificado) > 0){
                                cadena = data[0].Bonificado;
                            }else{
                                cadena = formatMoney(0);
                            }

                            $("#modal_NEODATA .modal-header").append('<div class="row">'+
                            '<div class="col-md-4">Total pago: <b style="color:blue">'+formatMoney(data1[0].total_comision)+'</b></div>'+
                            '<div class="col-md-4">Total abonado: <b style="color:green">'+formatMoney(data1[0].abonado)+'</b></div>'+
                            '<div class="col-md-4">Total pendiente: <b style="color:orange">'+formatMoney((data1[0].total_comision)-(data1[0].abonado))+'</b></div></div>');

                            $("#modal_NEODATA .modal-header").append('<div class="row">'+
                            '<div class="col-md-4">Aplicado neodata: <b style="color:gray">'+formatMoney(data[0].Aplicado)+'</b></div>'+
                            '<div class="col-md-4">Bonificación: <b style="color:gray">'+formatMoney(cadena)+'</b></div>'+
                            '<div class="col-md-4">Pagado extra: <b style="color:red">'+formatMoney((data1[0].abono_pagado))+'</b></div></div>');

                        
                            $.getJSON( url + "Comisiones/getDatosAbonadoDispersion/"+idLote).done( function( data ){
                                $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-4"><p style="font-zise:10px;"><b>USUARIOS</b></p></div><div class="col-md-1"><b>%</b></div><div class="col-md-2"><b>TOT. COMISIÓN</b></div><div class="col-md-2"><b><b>ABONADO</b></div><div class="col-md-2"><b>PENDIENTE</b></div></div>');
                                let contador=0;

                                for (let index = 0; index < data.length; index++) {
                                    const element = data[index].id_usuario;
                                    if(data[index].id_usuario == 5855){
                                        contador +=1;
                                    }
                                }

                                $.each( data, function( i, v){
                                    saldo =0; 
                                    saldo = ((12.5 *(v.porcentaje_decimal / 100)) * total);

                                    if(v.abono_pagado>0){
                                        evaluar = (v.comision_total-v.abono_pagado);
                                        if(evaluar <0 ){
                                            pending=evaluar;
                                            saldo = 0;
                                        }
                                        else{
                                            pending = evaluar;
                                        }
                                        
                                        resta_1 = saldo-v.abono_pagado;
                                        if(resta_1  <= 0){
                                            saldo = 0;
                                        }
                                        else if(resta_1 > 0){
                                            if(resta_1 > pending){
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


                                    $("#modal_NEODATA  .modal-body").append(`<div class="row">
                                    <div class="col-md-4"><input id="id_disparador" type="hidden" name="id_disparador" value="1"><input type="hidden" name="pago_neo" id="pago_neo" value="${total.toFixed(3)}">
                                    <input type="hidden" name="pending" id="pending" value="${pending}"><input type="hidden" name="idLote" id="idLote" value="${idLote}">
                                    <input id="rol" type="hidden" name="id_comision[]" value="${v.id_comision}"><input id="rol" type="hidden" name="rol[]" value="${v.id_usuario}">
                                    <input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="${v.colaborador}" style="font-size:12px;${v.descuento == "1" ? 'color:red;' : ''}"><b><p style="font-size:12px;${v.descuento == 1 ? 'color:red;' : ''} ">${v.descuento != "1" ?  v.rol : v.rol +' Incorrecto' }</p></b></div>

                                    <div class="col-md-1"><input class="form-control ng-invalid ng-invalid-required" style="${v.descuento == 1 ? 'color:red;' : ''}" required readonly="true" value="${v.porcentaje_decimal}%"></div>
                                    <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" style="${v.descuento == 1 ? 'color:red;' : ''}" required readonly="true" value="${formatMoney(v.comision_total)}"></div>
                                    <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" style="${v.descuento == 1 ? 'color:red;' : ''}" required readonly="true" value="${formatMoney(v.abono_pagado)}"></div>
                                    <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" style="${pending < 0 ? 'color:red' : ''}" required readonly="true" value="${formatMoney(pending)}"></div>
                                    </div>`);
                                    
                                    counts++
                                });
                            });
                        });               
                    break;

                    case 2:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No se encontró esta referencia de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case 3:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No tiene vivienda, si hay referencia de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case 4:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No hay pagos aplicados a esta referencia de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case 5:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Referencia duplicada de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    default:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Sin localizar.</b></h4><br><h5>Revisar con sistemas: ' + row.data().nombreLote + '.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');

                    break;
                }
            }
            else {
                $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><b>No se encontró esta referencia en NEODATA de ' + row.data().nombreLote + '.</b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
            }
        });
        $("#modal_NEODATA").modal();
    });
});

/*jQuery(document).ready(function () {
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

})*/

/*function SoloNumeros(evt) {
    if (window.event) {
        keynum = evt.keyCode;
    } else {
        keynum = evt.which;
    }

    if ((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46) {
        return true;
    } else {
        alerts.showNotification("top", "left", "Solo Numeros.", "danger");
        return false;
    }
}*/

/*function closeModalEng() {
    $("#modal_enganche").modal('toggle');
}*/

function formatMoney(n) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};