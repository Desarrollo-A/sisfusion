var getInfo1 = new Array(7);
var getInfo3 = new Array(6);

$("#tabla_ingresar_11").ready( function(){
    let titulos = [];
    $('#tabla_ingresar_11 thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>' );
        $( 'input', this ).on('keyup change', function () {
            if (tabla_9.column(i).search() !== this.value ) {
                tabla_9.column(i).search(this.value).draw();
            }
        });
    });

    let fecha_title = new Date();
    let year = fecha_title.getFullYear();
    let month = (fecha_title.getMonth()<10) ? '0'+fecha_title.getMonth() : fecha_title.getMonth();
    let day = (fecha_title.getDate()<10) ? '0'+fecha_title.getDate(): fecha_title.getDate();
    let hours = (fecha_title.getHours()<10) ? '0'+fecha_title.getHours(): fecha_title.getHours();
    let minutes = (fecha_title.getMinutes()<10) ? '0'+fecha_title.getMinutes(): fecha_title.getMinutes();
    let seconds = (fecha_title.getSeconds()<10) ? '0'+fecha_title.getSeconds(): fecha_title.getSeconds();
    let fecha_title_ok = year+'-'+month+'-'+day+''+hours+''+minutes+''+seconds;

    tabla_9 = $("#tabla_ingresar_11").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        bAutoWidth:true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            title:'Reporte Validado estatus 11 '+fecha_title_ok,
            titleAttr: 'Descargar archivo de Excel',
            exportOptions: {
                columns: [0, 1, 2, 3, 4],
                format: {
                    header:  function (d, columnIdx) {
                        return ' '+titulos[columnIdx] +' ';
                    }
                }
            }
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
                return '<p class="m-0">'+(d.descripcion).toUpperCase()+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+(d.nombre).toUpperCase()+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.nombreLote+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.nombreCliente+'</p>';
            }
        },
        {
            "data": function( d ){
                let dateFormat = new Date(d.fecha_status_11);
                let year = dateFormat.getFullYear();
                let month = (dateFormat.getMonth()<10) ? '0'+dateFormat.getMonth() : dateFormat.getMonth();
                let day = (dateFormat.getDate()<10) ? '0'+dateFormat.getDate(): dateFormat.getDate();
                let hours = (dateFormat.getHours()<10) ? '0'+dateFormat.getHours(): dateFormat.getHours();
                let minutes = (dateFormat.getMinutes()<10) ? '0'+dateFormat.getMinutes(): dateFormat.getMinutes();
                let seconds = (dateFormat.getSeconds()<10) ? '0'+dateFormat.getSeconds(): dateFormat.getSeconds();
                let fecha_formateada = year+'-'+month+'-'+day+' '+hours+':'+minutes+':'+seconds;
                return '<p class="m-0">'+fecha_formateada+'</p>';
            }
        }],
        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        ajax: {
            "url": general_base_url + 'Administracion/getDateStatus11',
            "dataSrc": "",
            "type": "POST",
            cache: false,
            "data": function( d ){
            }
        },
    });

    $('#tabla_ingresar_11').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
});