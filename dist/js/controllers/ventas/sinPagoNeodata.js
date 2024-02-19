$(`#tabla_comisiones_sin_pago thead tr:eq(0) th`).each( function (i) {
        var title = $(this).text();
        //titulos.push(title);
        $(this).html(`<input data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
        $('input', this).on('keyup change', function() {
            if ($(`#tabla_comisiones_sin_pago`).DataTable().column(i).search() !== this.value) {
                $(`#tabla_comisiones_sin_pago`).DataTable().column(i).search(this.value).draw();
                var total = 0;
                var index = $(`#tabla_comisiones_sin_pago`).rows({ selected: true, search: 'applied'}).indexes();
                var data = $(`#tabla_comisiones_sin_pago`).rows(index).data();
                $.each(data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                var to1 = formatMoney(total);
                document.getElementById("total_disponible").textContent = to1;
            }
        });
        $('[data-toggle="tooltip"]').tooltip();
}); 
function comisionesTableSinPago (proyecto, condominio) {
    tabla_comisiones_sin_pago = $("#tabla_comisiones_sin_pago").DataTable({
        dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
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
            data: function(d) {
                return '<p class="m-0">' + d.idLote + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombreResidencial + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombreCondominio + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombreLote + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombreCliente + ' </p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombreAsesor + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombreCoordinador + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombreGerente + '</p>';
            }
        },
        {
            data: function(d) {
                switch (d.reason) {
                    case '0':
                        return '<p class="m-0"><b>EN ESPERA DE PRÓXIMO ABONO EN NEODATA </b></p>';
                    break;
                    case '1':
                        return '<p class="m-0"><b>NO HAY SALDO A FAVOR. ESPERAR PRÓXIMA APLICACIÓN DE PAGO. </b></p>';
                    break;
                    case '2':
                        return '<p class="m-0"><b>NO SE ENCONTRÓ ESTA REFERENCIA </b></p>';
                    break;
                    case '3':
                        return '<p class="m-0"><b>NO TIENE VIVIENDA, SI HAY REFERENCIA </b></p>';
                    break;
                    case '4':
                        return '<p class="m-0"><b>NO HAY PAGOS APLICADOS A ESTA REFERENCIA </b></p>';
                    break;
                    case '5':
                        return '<p class="m-0"><b>REFERENCIA DUPLICADA </b></p>';
                    break;
                    default:
                        return '<p class="m-0"><b>SIN LOCALIZAR </b></p>';
                    break;
                }
            }
        }],
        columnDefs: [{
            orderable: false,
            searchable: false,
            className: 'dt-body-center'
        }],
        ajax: {
            url: general_base_url + "ComisionesNeo/getGeneralStatusFromNeodata/" + proyecto + "/" + condominio,
            type: "POST",
            cache: false,
            data: function(d) {}
        },
    });
};