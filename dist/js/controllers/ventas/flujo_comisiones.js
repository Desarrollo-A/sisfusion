
$("#tabla_flujo_comisiones").ready(function() {
    let titulos = [];
    $('#tabla_flujo_comisiones thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function() {

            if (tabla_nuevas.column(i).search() != this.value) {
                tabla_nuevas.column(i).search(this.value).draw();
            }
                var totalComision = 0;
                var totalAbono = 0;
                var totalPendiente = 0;
                var index = tabla_nuevas.rows({ selected: true, search: 'applied' }).indexes();
                var data = tabla_nuevas.rows(index).data();

                $.each(data, function(i, v) {
                    v.comision_total == null ? totalComision += 0 : totalComision += parseFloat(v.comision_total);
                    v.abono_pagado == null ? totalAbono += 0 : totalAbono += parseFloat(v.abono_pagado);
                    v.pendiente == null ? totalPendiente += 0 : totalPendiente += parseFloat(v.pendiente);
                });
                document.getElementById("total_comision").value = formatMoney(totalComision);
                document.getElementById("total_abono").value = formatMoney(totalAbono);
                document.getElementById("total_pendiente").value = formatMoney(totalPendiente);
        });
    });

    $('#tabla_flujo_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
        var totalComision = 0;
        var totalAbono = 0;
        var totalPendiente = 0;

        $.each(json.data, function(i, v) {
            v.comision_total == null ? totalComision += 0 : totalComision += parseFloat(v.comision_total);
            v.abono_pagado == null ? totalAbono += 0 : totalAbono += parseFloat(v.abono_pagado);
            v.pendiente == null ? totalPendiente += 0 : totalPendiente += parseFloat(v.pendiente);
        });
        
        var toCo = formatMoney(totalComision);
        var toAb = formatMoney(totalAbono);
        var toPe = formatMoney(totalPendiente);

        document.getElementById("total_comision").value = toCo;
        document.getElementById("total_abono").value = toAb;
        document.getElementById("total_pendiente").value = toPe;
    });

    tabla_nuevas = $("#tabla_flujo_comisiones").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'FLUJO DE COMISIONES',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15],
                format: {
                    header: function (d, columnIndex) {
                        return ' '+titulos[columnIndex] +' ';
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
            "data": function( d ){
                return '<p class="m-0"><b>'+d.idLote+'</b></p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0"><b>'+d.nombreLote+'</b></p>';
            }
        },
        {
            "data": function( d ){
                if(d.nombreStatus == null){
                    return '<p class="m-0"><b></b></p>';
                }else{
                    return '<p class="m-0"><b>'+d.nombreStatus+'</b></p>';
                }
            }
        },
        {
            "data": function( d ){
                let fech = d.fechaApartado;

                if(fech == null){
                    return '<p class="m-0"></p>';
                }else{
                    return '<p class="m-0">'+fech+'</p>';
                }
            }
        },
        {
            "data": function( d ){
                let fech = d.fechaProspecto;

                if(fech == null){
                    return '<p class="m-0"></p>';
                }else{
                    return '<p class="m-0">'+fech+'</p>';
                }
            }
        },
        {
            "data": function( d ){

                if(d.comision_total == null){
                    return '<p class="m-0">0</p>';
                }else{
                    return '<p class="m-0">'+formatMoney(d.comision_total)+' </p>';
                }
            }
        },
        {
            "data": function( d ){

                if(d.abono_pagado == null){
                    return '<p class="m-0">0</p>';
                }else{
                    return '<p class="m-0"><b>'+formatMoney(d.abono_pagado)+'</b></p>';
                }
                
            }
        },
        {
            "data": function( d ){
                if(d.pendiente == null){
                    return '<p class="m-0">0</p>';
                }else{
                    return '<p class="m-0">'+formatMoney(d.pendiente)+' </p>';
                }
            }
        },
        
        {
            "data": function( d ){
                return '<p class="m-0">'+d.dispersion+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.observaciones+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.estatus_com+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.estatus_comision_lote+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.ESTATUS_MKTD+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.estatus_evidencia+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.plaza+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.sede+'</p>';
            }
        }],
        columnDefs: [{
            orderable: false,
            targets: 2,
            'searchable': false,
            'className': 'dt-body-center',
        }],
        ajax: {
            "url": general_base_url + "Comisiones/getDatosFlujoComisiones",
            "type": "POST",
            cache: false,
            "data": function(d) {}
        },
        order: [
            [1, 'asc']
        ]
    });
    $('#tabla_flujo_comisiones').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });
});

$(window).resize(function() {
    tabla_nuevas.columns.adjust();
});      