$(document).ready(function () {
    $.post(`${general_base_url}Contratacion/lista_proyecto`, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#idResidencial").append($('<option>').val(data[i]['idResidencial']).text(data[i]['descripcion']));
        }
        $("#idResidencial").selectpicker('refresh');
    }, 'json');
});

$('#idResidencial').change(function () {
    $('#spiner-loader').removeClass('hide');
    $('#tablaInventario').removeClass('hide');
    index_idResidencial = $(this).val();
    $("#idCondominioInventario").html("");
    $(document).ready(function () {
        $.post(`${general_base_url}Contratacion/lista_condominio/${index_idResidencial}`, function (data) {
            for (var i = 0; i < data.length; i++) {
                $("#idCondominioInventario").append($('<option>').val(data[i]['idCondominio']).text(data[i]['nombre']));
            }
            $("#idCondominioInventario").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }, 'json');
    });
});

$('#idCondominioInventario').change(function () {
    $('#spiner-loader').removeClass('hide');
    $('#tablaInventario').removeClass('hide');
    index_idCondominio = $(this).val();
    $("#idLote").html("");
    $(document).ready(function () {
        $.post(`${general_base_url}Corrida/lista_lotes/${index_idCondominio}`, function (data) {
            for (var i = 0; i < data.length; i++) {
                $("#idLote").append($('<option data-nombreLote="'+data[i]['nombreLote']+'">').val(data[i]['idLote']).text(data[i]['nombreLote']));
            }
            $("#idLote").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }, 'json');
    });
});

$('#idLote').change(function () {
    $('#spiner-loader').removeClass('hide');
    $('#tablaPlanPagos').removeClass('hide');
    index_idLote = $(this).val();
    idLote = index_idLote;
    console.log('index_idLote', index_idLote);
    var nombreLoteSeleccionado = $('option:selected', this).attr('data-nombreLote');

    //tablaPlanPagos
    $('#spiner-loader').removeClass('hide');
    $.post(general_base_url+"Corrida/getInfoByLote/"+idLote, function (data) {
        $('#nombreCliente').val(data[0].nombre+' '+data[0].apellido_paterno+' '+data[0].apellido_materno);
        $('#spiner-loader').addClass('hide');
    }, 'json');


    tablaPlanPagos = $("#tablaPlanPagos").DataTable({
        dom: "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'B><'col-12 col-sm-12 col-md-6 col-lg-6 p-0'f>rt>"+"<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        destroy: true,
        searching: true,
        ajax: {
            url: `${general_base_url}corrida/getPlanesPago/${index_idLote}`,
            dataSrc: ""
        },
        buttons: [
            {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'Planes de pago '+ nombreLoteSeleccionado,
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                className: 'btn buttons-pdf',
                titleAttr: 'PDF',
                title: 'Inventario lotes',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosInventario[columnIdx]  + ' ';
                        }
                    }
                }
            },
        ],
        // columnDefs: [{
        //     targets: [22, 23, 24, 32],
        //     visible: coordinador = ((id_rol_general == 11 || id_rol_general == 17 || id_rol_general == 63 || id_rol_general == 70) || (id_usuario_general == 2748 || id_usuario_general == 5957)) ? true : false
        // }],
        pagingType: "full_numbers",
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: false,
        pageLength: 10,
        bAutoWidth: false,
        bLengthChange: false,
        bInfo: true,
        paging: true,
        ordering: true,
        columns: [{
            data: 'nombreResidencial'
            },
            {
                data: 'nombreCondominio'
            },
            { data: 'nombreLote' },
            { data: 'idLote' },
            { data: 'nombrePlan' },
            { data: 'numeroPeriodos' },
            {
                data: function (d) {

                    let BTN_ADD = `<button class="btn-data btn-blueMaderas registrarPago" value="${d.idLote}" 
                    data-nomLote="${d.nombreLote}" data-idplanPago="${d.idPlanPago}" data-nombrePlan="${d.nombrePlan}" 
                    data-toggle="tooltip" data-placement="left" title="VER PAGOS"><i class="fas fa-edit"></i></button>`;

                    return `<center>${BTN_ADD}</center>`;
                }
            }],
        initComplete: function() {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
    $('#spiner-loader').addClass('hide');

});

$(document).on('click', '.registrarPago', async function(){
    let idPlanPago = $(this).attr('data-idplanPago');
    let nombrePlanPago = $(this).attr('data-nombreplan');
    console.log('idPlanPago', idPlanPago);
    console.log('nombrePlanPago', nombrePlanPago);

    $('#spiner-loader').removeClass('hide');
    dumpPlanPago = await getPlanPagoDump(idPlanPago);
    fillTable(dumpPlanPago);

    $('#verPlanPago').modal('toggle');
});

const getPlanPagoDump = (idPlanPago) =>{
    return new Promise((resolve) => {
        $.getJSON(`${general_base_url}Corrida/getPlanPago/${idPlanPago}`,function (sedes) {
            resolve(sedes);
            $('#spiner-loader').addClass('hide');
        });
    });
}

function fillTable(data) {
    console.log(data)
    
    var tablePagos

    const editarPago = function(row, value){
        console.log(row, value)

        let pagos = tablePagos.rows().data().toArray()
        row = row.data()

        console.log(pagos)
        console.log(row)

        let nuevo_capital = parseFloat(data.monto)//montoInicial

        for (var p = 0; p < pagos.length; p++) {
            let pago = pagos[p]

            if(pago.pago == row.pago){
                console.log('si es')

                if(pago.total > value){

                    let new_pago = {
                        capital: pago.saldo - value,
                        fecha: pago.fecha,
                        interes: pago.interes,
                        iva: pago.iva,
                        pago: pagos.length + 1,
                        planPago: pago.planPago,
                        saldo: pago.saldo,
                        saldoCapital: pago.saldoCapital,
                        saldoInteres: pago.saldoInteres,
                        saldoIva: pago.saldoIva,
                        total: pago.total - value,
                    }

                    pago.total = value
                    pago.saldo = nuevo_capital - pago.total
                    pago.capital = value

                    pagos.splice(p + 1, 0, new_pago)
                }
            }

            pago.pago = p + 1

            nuevo_capital -= pago.total
        }

        tablePagos.clear()
        tablePagos.rows.add(pagos).draw(false)
    }

    const createdCell = function(cell) {
        let original;

        /*
        const recalcularPlan = function(row, capital) {
            // const row = tablePagos.row(e.target.parentElement)
            //row.invalidate()
            //console.log('Row changed: ', row.data())

            // let montoInicial = parseFloat(data.monto)

            // let capital = parseFloat(e.target.textContent)

            let pagos = tablePagos.rows().data().toArray()

            let pago_nuevo = row.data()

            let nuevo_capital = parseFloat(data.monto)//montoInicial

            let num_pagos = pagos.length
            for (var p = 0; p < pagos.length; p++) {
                let pago = pagos[p]
                //console.log(pago.capital, capital)

                if(pago.pago == pago_nuevo.pago){
                    pago.capital = capital
                }

                if(pago.capital > nuevo_capital){
                    pago.capital = nuevo_capital
                }

                nuevo_capital -= pago.capital

                pago.total = pago.capital
                pago.saldo = nuevo_capital

                if(pago.capital === 0){
                    pagos.splice(p, 1)
                }

                if(pagos.length === p + 1){
                    if(nuevo_capital > 0){
                        let date_parts = pago.fecha.split('-')
                        let date = new Date(date_parts[2], date_parts[1] - 1, date_parts[0])
                        
                        let new_fecha = new Date(date.setMonth(date.getMonth()+1))
                        let date_str = [
                            ('0' + new_fecha.getDate()).slice(-2),
                            ('0' + (new_fecha.getMonth() + 1)).slice(-2),
                            new_fecha.getFullYear(),
                        ].join('-')

                        pagos.push({
                            capital: nuevo_capital,
                            fecha: date_str,
                            interes: pago.interes,
                            iva: pago.iva,
                            pago: pagos.length + 1,
                            planPago: pago.planPago,
                            saldo: 0,
                            saldoCapital: pago.saldoCapital,
                            saldoInteres: pago.saldoInteres,
                            saldoIva: pago.saldoIva,
                            total: nuevo_capital,
                        })
                    }
                }else{
                    if(nuevo_capital <= 0){
                        pagos.splice(p + 1, 1)
                    }
                }
            }

            // console.log(pagos)

            if(num_pagos === pagos.length){
                tablePagos
                .rows()
                .invalidate()
                .draw()
            }else{
                tablePagos.clear()
                tablePagos.rows.add(pagos).draw(false)
            }
        }
        */

        cell.setAttribute('contenteditable', true)
        cell.setAttribute("style","border:1px; border-style:solid; border-color:transparent;padding:10px")
        cell.setAttribute('spellcheck', false)
        cell.addEventListener("focus", function(e) {
            cell.setAttribute("style","border:1px; border-style:solid; border-color:#000;padding:10px")

            original = e.target.textContent
        })
        cell.addEventListener('keydown', function(e) {
            cell.setAttribute("style","border:1px; border-style:solid; border-color:transparent;padding:10px")

            if (e.keyCode === 13){
                e.preventDefault()

                const row = tablePagos.row(e.target.parentElement)
                const value = parseFloat(e.target.textContent)

                editarPago(row, value)
            }
        })

        cell.addEventListener("blur", function(e) {
            cell.setAttribute("style","border:1px; border-style:solid; border-color:transparent;padding:10px")

            /*
            if (original !== e.target.textContent) {

                const row = tablePagos.row(e.target.parentElement)
                const value = parseFloat(e.target.textContent)

                editarPago(row, value)
            }
            */
        })
    }

    const dateCell = function(cell) {
        let date = cell.innerHTML
        //cell.innerHTML = `<input size="10" id="datetimepicker" value="${cell.innerHTML}" readonly />`

        $(cell).html('').append(
            $('<input>')
            .attr('id', 'datetimepicker')
            .attr('size', 10)
            .attr('type', 'text')
            .css('outline', 'none')
            .css('border', '0px')
            .css('margin', '0px')
            .css('padding', '0px')
            .css('background', 'transparent')
            .val(date)
            .datetimepicker({
                format: 'DD-MM-YYYY',
            })
        ).append(
            $('<span>')
            .html('📅')
            .unbind("click").on('click', function(){
                $("#datetimepicker").focus();
            })
        )

        /*
        $(cell).datetimepicker({
            format: 'dd-mm-yyyy'
        })
        */

        /*
        $(cell).unbind("click").on('click', function(){
            console.log('click')
        })
        */

        /*
        cell.addEventListener("click", function(e) {
            //$("#date").datepicker().focus();

        })
        */
    }

    $('#nombrePlanPagotxt').val(data.nombrePlanPago);
    $('#nombrePlanPago').val(data.nombrePlan);
    $('#nombreCliente').val(data.nombreCliente);
    $('#montoPlanPago').val(formatMoney(data.monto));
    $('#tazaInteresPlanPago').val(data.tazaInteres);
    $('#mensualidadPlanPago').val(formatMoney(data.mensualidad));
    $('#periodosPlanPago').val(data.numeroPeriodos);
    $('#montoInicialPlan').val(formatMoney(data.saldoInicialPlan));
    data_plan = JSON.parse(data.dumpPlan);
    let titulosTabla = [];

    /*
    $('#tabla_plan_pago thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        titulosTabla.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');

        $('input', this).on('keyup change', function () {
            if ($('#tabla_plan_pago').DataTable().column(i).search() !== this.value) {
                $('#tabla_plan_pago').DataTable().column(i).search(this.value).draw();
            }
        });

        $('[data-toggle="tooltip"]').tooltip();
    });
    */

    tablePagos = $('#tabla_plan_pago').DataTable({
        data: data_plan,
        width: '100%',
        // searching: true,
        // destroy: true,
        // dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        dom: "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'B><'col-12 col-sm-12 col-md-6 col-lg-6 p-0'f>rt>"+"<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",

        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip("destroy");
            $('[data-toggle="tooltip"]').tooltip({trigger: "hover"});
        },
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                title: 'Plan de pago',
                titleAttr: 'Descargar archivo de Excel',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10],
                    format: {
                        header: function (d, columnIdx) {
                            return ' '+titulosTabla[columnIdx] +' ';
                        }
                    }
                }
            },
        ],
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        processing: false,
        pageLength: 25,
        //bAutoWidth: false,
        //bLengthChange: false,
        bInfo: true,
        paging: true,
        ordering: false,
        //scrollX:true,
        columns: [
            {
                data: function (d) {
                    return d.pago;
                }
            },
            {
                data: function (d) {//col concepto
                    let nombrePlan = $('#nombrePlanPago').val();
                    let nombreCompuesto = nombrePlan + ' - ' + d.pago;
                    return nombreCompuesto;
                }
            },
            {
                data: function (d) {
                    return d.fecha;
                }
            },
            {
                data: function (d) {
                    return d.fecha;
                }
            },
            {
                data: function (d) {
                    if(d.capital){
                        return formatMoney(parseFloat(d.capital).toFixed(2));
                    }
                    return ''
                }
            },
            {
                data: function (d) {
                    return formatMoney(parseFloat(d.saldoCapital).toFixed(2));
                }
            },
            {
                data: function (d) {
                    return formatMoney(parseFloat(d.interes).toFixed(2));
                }
            },
            {
                data: function (d) {
                    return formatMoney(parseFloat(d.saldoInteres).toFixed(2));
                }
            },
            {
                data: function (d) {
                    return formatMoney(parseFloat(d.iva).toFixed(2));
                }
            },
            {
                data: function (d) {
                    return formatMoney(parseFloat(d.saldoIva).toFixed(2));
                }
            },
            {
                data: function (d) {
                    return parseFloat(d.total).toFixed(2);
                }
            },
            {
                data: function (d) {
                    return formatMoney(parseFloat(d.saldo).toFixed(2));
                }
            },
            {
                data: function (d) {
                    return '<span style="cursor: pointer;" data-toggle="tooltip" data-placement="left" title="REGISTRAR PAGO">🖊</span>'
                }
            },
        ],

        columnDefs: [
            {
                targets: [10],
                createdCell: createdCell
            },
            {
                targets: [3],
                createdCell: dateCell
            }
        ]
    });

    $('.guardarPlan').unbind("click").on('click', function(){
        console.log('guardar plan');

        let pagos = tablePagos.rows().data().toArray()

        $.ajax({
            type: "POST",
            url: `${general_base_url}Corrida/guardarPlanPago/${idLote}?plan=${data.idPlanPago}`,
            data: JSON.stringify(pagos),
            dataType: 'json',
        })
        .done(function() {
            alerts.showNotification("top", "right", "Plan guardado con éxito.", "success");

            $('#verPlanPago').modal('hide');
        })
    });
}