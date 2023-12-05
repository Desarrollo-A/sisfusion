

$(document).ready(function () {  
    let titulosHistorialOOAM = [];
    $('#tablaHistorialOOAM thead tr:eq(0) th').each(function (i) {
        var titleooam = $(this).text();
        titulosHistorialOOAM.push(titleooam);
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${titleooam}" placeholder="${titleooam}"/>`);                       
        $('input', this).on('keyup change', function () {
            if ($('#tablaHistorialOOAM').DataTable().column(i).search() !== this.value) {
                $('#tablaHistorialOOAM').DataTable().column(i).search(this.value).draw();
            }
        });
        $('[data-toggle="tooltip"]').tooltip({trigger: "hover" });
    });


    consultarHistorialOOAM();

});




function consultarHistorialOOAM() {

    consultarHistorialOOAM = $("#tablaHistorialOOAM").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%', 
        scrollX:true,  
        ordering: false,             
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'HISTORIAL DESCUENTOS',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosHistorialOOAM[columnIdx] + ' ';
                        }
                    }
                }
            }
        ],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        deferRender: true,
        columns: 
        [
            {data: 'id_pago_i'},
            {data: 'id_comision'},
            {data: 'proyecto'},
            {data: 'precio_lote'},
            {data: 'comision_total'},
            {data: 'porcentaje_decimal'},
            {data: 'estatus'},
            {data: 'fecha_creacion'},
            {data: 'id_usuario'},
            {data: 'lote'},
            {data: 'pj_name'},
            {data: 'forma_pago'},
            { 

                data: function(d) {
                    return `<div class="d-flex justify-center"><button href="#" value="${d.id_pago_i}" data-value="${d.nombreLote}" class="btn-data btn-blueMaderas consultarDetalleDelPago" title="VER MÁS DETALLES" data-toggle="tooltip" data-placement="top"><i class="fas fa-info"></i></button></div>`;
                }
            }
        ],
        columnDefs: [{
			defaultContent: "",
			targets: "_all",
			searchable: true,
			orderable: false
		}],
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            });
        },
        ajax: {
            url: `${general_base_url}Ooam/getDatosHistorialOOAM`,
            type: "POST",
            cache: false,
        }
    });
}


