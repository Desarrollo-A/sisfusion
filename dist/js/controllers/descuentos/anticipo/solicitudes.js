var totaPen = 0;
var tr;
let estatus = '';
let texto = '';
let mensaje = '';

if(id_rol_general == 18){
    texto = 'ENVIAR A CONTRALORÍA';
    mensaje = 'BONOS ENVIADOS A CONTRALORÍA CORRECTAMENTE.';
    estatus = '1';
}
else{
    estatus = '2,6';
    texto ='ENVIAR A INTERNOMEX';
    mensaje ='BONOS ENVIADOS A INTERNOMEX CORRECTAMENTE.';
}

let titulos = [];
$("#tabla_anticipo_revision").ready(function() {
    $('#tabla_anticipo_revision thead tr:eq(0) th').each( function (i) {

            var title = $(this).text();
            titulos.push(title);
            $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
            $( 'input', this ).on('keyup change', function () {
                if (tabla_nuevas.column(i).search() !== this.value ) {
                    tabla_nuevas.column(i).search(this.value).draw();
                    var total = 0;
                    var index = tabla_nuevas.rows({ selected: true, search: 'applied' }).indexes();
                    var data = tabla_nuevas.rows( index ).data();
                    $.each(data, function(i, v){

                    });
                    
                }
            });
            
    });

    $('#tabla_anticipo_revision').on('xhr.dt', function ( e, settings, json, xhr ) {
        
        $.each(json.data, function(i, v){
            
        });
        
    });

    tabla_nuevas = $("#tabla_anticipo_revision").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title:'Bonos activos',
            exportOptions: {
                columns: [1,2,3,4,5,6],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx-1] + ' ';
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
        columns: [
        {
            data: 'id_pago_bono'
        },
        {
            data: 'id_pago_bono'
        },
        {
            data: 'id_pago_bono'
        },
        {
            data: 'id_pago_bono'
        },
        {
            data: 'id_pago_bono'
        },
        {
            data: 'id_pago_bono'
        },
        {
            data: 'id_pago_bono'
        },
        {
            data: 'id_pago_bono'
        }],
        columnDefs: [{
            orderable: false,
            
            targets:   0,
            searchable:false,
            className: 'dt-body-center',
        }],
        ajax: {
            url: general_base_url + "Pagos/getBonosPorUserContra/" + estatus,
            type: "POST",
            cache: false,
            data: function(d) {
            }
        },
    });



});
