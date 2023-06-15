var getInfo1 = new Array(7);
var getInfo3 = new Array(6);
let titulos = [];

$("#tabla_reporte_11").ready( function(){
    $('#tabla_reporte_11 thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if (tabla_9.column(i).search() !== this.value ) {
                tabla_9.column(i).search(this.value).draw();
            }
        } );
    });

    tabla_9 = $("#tabla_reporte_11").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11],
                format: {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos[columnIdx]  + ' ';
                        }
                    }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + '/static/spanishLoader_v2.json',
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
        {
            "data": function( d ){
                return '<p class="m-0">'+d.nombreResidencial+'</p>';
            }	
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+(d.nombreCondominio).toUpperCase();+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.nombreLote+'</p>';

            }
        }, 
        {
            "data": function( d ){
                return '<p class="m-0">'+d.idLote+'</p>';
            }
        }, 
        {
            "data": function( d ){
                return '<p class="m-0">'+d.nombreCliente+'</p>';
            }
        }, 
        {
            "data": function( d ){
                return '<p class="m-0">'+d.fechaApartado+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.estatusActual+'</p>';

            }
        }, 
        {
            "data": function( d ){
                return '<p class="m-0">'+d.estatusLote+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.usuario+'</p>';
            }
        }, 
        { 
            "data": function( d ){
                return '<p class="m-0">'+d.fechaRechazo+'</p>';
            } 
        }, 
        { 
            "data": function( d ){
                return '<p class="m-0">'+d.motivoRechazo+'</p>';
            } 
        },
        {
            "orderable": false,
            "data": function( d ){
                return '<p class="m-0">'+d.movimiento+'</p>';
            }
        }],
        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        ajax: {
            "url": general_base_url +'/RegistroLote/getReporteRechazos',
            "dataSrc": "",
            "type": "POST",
            cache: false,
            "data": function( d ){
            }
        },
    });

    $('#tabla_reporte_11').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
});

