$(document).ready(function () {
	fillTablaClientesArcus();
});

let titulos = [];
$('#tablaClientesArcus thead tr:eq(0) th').each(function (i) {
	const title = $(this).text();
	titulos.push(title);
	$(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
	$('input', this).on('keyup change', function () {
		if ($("#tablaClientesArcus").DataTable().column(i).search() !== this.value)
			$("#tablaClientesArcus").DataTable().column(i).search(this.value).draw();
	});
});

function fillTablaClientesArcus() {
    $("#tablaClientesArcus").dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons: [{
			extend: 'excelHtml5',
			text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
			className: 'btn buttons-excel',
			titleAttr: 'Descargar archivo de Excel',
			title: 'LISTA DE CLIENTES MARKETING ARCUS',
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19],
				format: {
					header: function (d, columnIdx) {
						return ' ' + titulos[columnIdx] + ' ';
					}
				}
			}
		}],
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
			{ data: 'nombreResidencial' },
            { data: 'nombreCondominio' },
            { data: 'nombreLote' },
            { data: 'idLote' },
            { data: 'referencia' },
            { data: 'precioLista' },
            { data: 'precioFinal' },
            { data: 'nombreCliente' },
            { data: 'idCliente' },
            { data: 'correo' },
            { data: 'telefono1' },
            { data: 'fechaApartado' },
            { data: 'nombreAsesor' },
            { data: 'nombreCoordinador' },
            { data: 'nombreGerente' },
            { data: 'nombreSubdirector' },
            { data: 'nombreRegional' },
            { data: 'nombreRegional2' },
			{
                data: function (d) {
                    return `<span class='label lbl-violetBoots'>${d.estatusLote}</span>`;
                }
            },
			{
                data: function (d) {
                    return `<span class='label lbl-green'>${d.estatusContratacion}</span>`;
                }
            },
            {
                data: function (d) {
                    return `<span class='label lbl-blueMaderas'>${d.idMaderasRewards}</span>`;
                }
            }

		],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: `${general_base_url}Clientes/getListaClientesArcus`,
            type: "POST",
            cache: false
        }
    });
}

$('#tablaClientesArcus').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});
