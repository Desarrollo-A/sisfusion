$("#tabla_ingresar_9").ready(function () {

    let titulos = [];
    $('#tabla_ingresar_9 thead tr:eq(0) th').each(function (i) {
        if (i != 0) {
            var title = $(this).text();
            titulos.push(title);

            $(this).html(`<input type="text"
                            class="textoshead"
                            data-toggle="tooltip" 
                            data-placement="top"
                            title="${title}"
                            placeholder="${title}"/>`);
            $('input', this).on('keyup change', function () {
                if (tabla_1.column(i).search() !== this.value) {
                    tabla_1
                        .column(i)
                        .search(this.value)
                        .draw();

                    var total = 0;
                    var index = tabla_1.rows({selected: true, search: 'applied'}).indexes();
                    var data = tabla_1.rows(index).data();
                    $.each(data, function (i, v) {
                        total += parseFloat(v.pago_cliente);
                    });
                    var to1 = formatMoney(total);
                    document.getElementById("myText_nuevas").value = formatMoney(total);
                }
            });
        }
    });

    /*REPORTE_GENERAL_TOTALES_COMISIONES*/
    tabla_1 = $('#tabla_ingresar_9').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'REPORTE_GENERAL_TOTALES_COMISIONES',
                title: 'REPORTE GENERAL TOTALES COMISIONES',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10,11],
                    format: {
                        header: function (d, columnIdx) {
                            switch (columnIdx) {
                                case 1:
                                    return 'ID LOTE';
                                    break;
                                case 2:
                                    return 'PROYECTO';
                                case 3:
                                    return 'CONDOMINIO';
                                    break;
                                case 4:
                                    return 'LOTE';
                                    break;
                                case 5:
                                    return 'REFERENCIA';
                                    break;
                                case 6:
                                    return 'PRECIO LOTE';
                                    break;
                                case 7:
                                    return 'TOTAL COM. ($)';
                                    break;
                                case 8:
                                    return 'ABONADO';
                                    break;
                                case 9:
                                    return 'PAGADO';
                                    break;
                                case 10:
                                    return 'CLIENTE';
                                    break;
                                case 11:
                                    return 'ESTATUS';
                                    break;
                            }
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
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false,
        }],
        destroy: true,
        ordering: false,
        columns: [
            {
                "className": 'details-control',
                "orderable": false,
                "data" : null,
                "defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
            },
            {
                "data": function (d) {
                    var lblStats;
                    lblStats = '<p style="font-size: .8em"><b>' + d.idLote + '</b></p>';
                    return lblStats;
                }
            },
            {
                "data": function (d) {
                    return '<p style="font-size: .8em">' + d.proyecto + '</p>';
                }
            },

             {
                "data": function (d) {
                    return '<p style="font-size: .8em">' + d.condominio + '</p>';
                }
            },


            {
                "data": function (d) {
                    return '<p style="font-size: .8em">' + d.nombreLote + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p style="font-size: .8em">' + d.referencia + '</p>';
                }
            },
            {
                "data": function (d) {
                    var lblStats;
                    lblStats = '<p style="font-size: .8em">$' + formatMoney(d.totalNeto2) + '</p>';
                    return lblStats;
                }
            },
            {
                "data": function (d) {
                    return '<p style="font-size: .8em; "><b>$' + formatMoney(d.total_comision) + ' </b></p>';
                }
            },

            {
                "data": function (d) {
                    return '<p style="font-size: .8em; color:gray;">$<b>' + formatMoney(d.abonados) + '</b></p>';
                }
            },

            {
                "data": function (d) {
                    return '<p style="font-size: .8em; color:gray;">$<b>' + formatMoney(d.abono_pagos) + '</b></p>';
                }
            },
           
            {
                "data": function (d) {
                    return '<p style="font-size: .8em"><b>' + d.nombre+' '+d.apellido_paterno+' '+d.apellido_materno+ '</b></p>';
                }
            },
            {
                "data": function (d) {

                    switch (d.registro_comision) {  
                        case '1':
                        case 1:
                            return '<p style="font-size: .8em"><span class="label" style="background:#29A2CC;">ACTIVA</span></p>';
                            break;

                        case '7':
                        case 7:
                            return '<p style="font-size: .8em"><span class="label" style="background:#CC6C29;">LIQUIDADA</span></p>';
                            break;
                        default:
                            return '<p style="font-size: .8em"><span class="label" style="background:gray;">NA</span></p>';
                            break;

                    
                    }
                }
            },


        ],
        "ajax": {
            "url":general_base_url +"index.php/Comisiones/getDatosHistorialPostventa",
            "type": "POST",
            cache: false,
            "data": function (d) {
            }
        },
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            });
        }
    });

    
    

    $('#tabla_ingresar_9 tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tabla_1.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        } else {
            var status;
            var informacion_adicional2 = '<table class="table text-justify">' +
                '<tr><b>INFORMACIÓN ADICIONAL</b>:' +
                '<td style="font-size: .8em"><strong>PORCENTAJE A COMISIONAR: </strong>' + row.data().porcentaje_decimal + '%</td>' +
                '<td style="font-size: .8em"><strong>FECHA PAGO: </strong>' + row.data().fecha_creacion + '</td>' +
                '</tr>' +
                '</table>';

            var informacion_adicional = '<div class="container subBoxDetail">';
                informacion_adicional += '  <div class="row">';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">';
                informacion_adicional += '          <label><b>Información adicional</b></label>';
                informacion_adicional += '      </div>';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>PORCENTAJE A COMISIONAR: </b>'+ row.data().porcentaje_decimal +'%</label></div>';
                informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>FECHA PAGO: </b> ' + row.data().fecha_creacion + '</label></div>';
                informacion_adicional += '  </div>';
                informacion_adicional += '</div>';




            row.child(informacion_adicional).show();
            tr.addClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");

        }
    });
});

function formatMoney(n) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};