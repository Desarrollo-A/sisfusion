$('#tablaResidenciales thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>`);

    $('input', this).on('keyup change', function () {
        if ($('#tablaResidenciales').DataTable().column(i).search() !== this.value) {
            $('#tablaResidenciales').DataTable().column(i).search(this.value).draw();
        }
    });

    $('[data-toggle="tooltip"]').tooltip();
});

$('#tablaResidenciales').DataTable({
    dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: '100%',
    scrollX: true,
    pagingType: "full_numbers",
    fixedHeader: true,
    language: {
        url: general_base_url + "/static/spanishLoader_v2.json",
        paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>"
        }
    },
    destroy: true,
    ordering: false,
    columns: [{ 
        data: function (d) {
            return d.idResidencial;
        }
    },
    { 
        data: function (d) {
            return d.nombreResidencial;
        }
    },
    { 
        data: function (d) {
            return d.descripcion;
        }
    },
    { 
        data: function (d) {
            return d.empresa;
        }
    }],
    columnDefs: [{
        "searchable": true,
        "orderable": false,
        "targets": 0
    }],
    ajax: {
        url: "getResidenciales",
        dataSrc: ""
    }
});