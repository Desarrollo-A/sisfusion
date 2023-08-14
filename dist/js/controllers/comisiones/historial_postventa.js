$("#tabla_ingresar_9").ready(function () {
    let titulos = [];
    $('#tabla_ingresar_9 thead tr:eq(0) th').each(function (i) {
        if (i != 0) {
            var title = $(this).text();
            titulos.push(title);
            $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip"  data-placement="top" title="${title}" placeholder="${title}"/>`);
            $('input', this).on('keyup change', function () {
                if (tabla_1.column(i).search() !== this.value) {
                    tabla_1.column(i).search(this.value).draw();
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
                titleAttr: 'Descargar archivo EXCEL',
                title: 'REPORTE GENERAL TOTALES COMISIONES',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10,11,12],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
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
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        destroy: true,
        ordering: false,
        columns: [
            {
                className: 'details-control',
                orderable: false,
                data : null,
                defaultContent: '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
            },
            {
                data: function (d) {
                    var lblStats;
                    lblStats = '<b>' + d.idLote + '</b>';
                    return lblStats;
                }
            },
            {
                data: function (d) {
                    return '' + d.proyecto + '';
                }
            },
            {
                data: function (d) {
                    return '' + d.condominio + '';
                }
            },
            {
                data: function (d) {
                    return '' + d.nombreLote + '';
                }
            },
            {
                data: function (d) {
                    return '' + d.referencia + '';
                }
            },
            {
                data: function (d) {
                    var lblStats;
                    lblStats = formatMoney(numberTwoDecimal(d.totalNeto2));
                    return lblStats;
                }
            },
            {
                data: function (d) {
                    return formatMoney(numberTwoDecimal(d.total_comision));
                }
            },
            {
                data: function (d) {
                    return formatMoney(numberTwoDecimal(d.abonados));
                }
            },
            {
                data: function (d) {
                    return  formatMoney(numberTwoDecimal(d.abono_pagos)) ;
                }
            },
            {
                data: function (d) {
                    return '<b>' + d.nombre+' '+d.apellido_paterno+' '+d.apellido_materno+ '</b>';
                }
            },
            {
                data: function (d) {
                    switch (d.registro_comision) {  
                        case '1':
                        case 1:
                            return '<span class="label lbl-green">ACTIVA</span>';
                            break;
                        case '7':
                        case 7:
                            return '<span class="label lbl-orangeYellow">LIQUIDADA</span>';
                            break;
                        default:
                            return '<span class="label lbl-gray">NO APLICA</span>';
                            break;
                    }
                }
            },
        ],
        ajax: {
            url:general_base_url +"Comisiones/getDatosHistorialPostventa",
            type: "POST",
            cache: false,
            data: function (d) {
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
        var idLote = row.data().idLote;
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        } else {
            $.post( general_base_url + "Comisiones/comisionistasPorLote/"+idLote ,function( d ){
                row.child(buildDatatable(d)).show();
            });
        }
    });

    function buildDatatable(jsonComisionistas){
        let informacion_adicional ;
        informacion_adicional = '<div class="container subBoxDetail">';
        informacion_adicional += '  <div class="row">';
        informacion_adicional += '      <div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">';
        informacion_adicional += '          <label><b>Información adicional</b></label>';
        informacion_adicional += '      </div>';
        informacion_adicional += '<div class="col-sm-12 col-md-4 col-lg-4"><b>Porcentaje a comisionar </b></div>  '+
                                '<div class="col-sm-12 col-md-4 col-lg-4"><b>Fecha de pago</b></div>  '+
                                '<div class="col-sm-12 col-md-4 col-lg-4"><b>Nombre </b></div>  ';

        objComisionistas = JSON.parse( jsonComisionistas );
        objComisionistas.forEach( comisionista => {
            informacion_adicional += '<div class="col-sm-4 col-md-12 col-lg-12">'+
                                        '<div class="col-sm-12 col-md-4 col-lg-4">'+ comisionista.porcentaje_decimal+'% </div>  '+
                                        '<div class="col-sm-12 col-md-4 col-lg-4">' + comisionista.fechaCreacion + '</div>   '+
                                        '<div class="col-sm-12 col-md-4 col-lg-4">' + comisionista.nombre + '</div>'+
                                        '</div>';
        });
            informacion_adicional += '  </div>';
            informacion_adicional += '</div>';
        return informacion_adicional;
    }
});
