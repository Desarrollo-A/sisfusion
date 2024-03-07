$(document).ready(function () {
	filltablaListaClientesSalesforce();
	Shadowbox.init();
});

let titulos = [];
$('#tablaListaClientesSalesforce thead tr:eq(0) th').each(function (i) {
	const title = $(this).text();
	titulos.push(title);
	$(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
	$('input', this).on('keyup change', function () {
		if ($("#tablaListaClientesSalesforce").DataTable().column(i).search() !== this.value) {
			$("#tablaListaClientesSalesforce").DataTable().column(i).search(this.value).draw();
		}
	});
});

function filltablaListaClientesSalesforce() {
	$("#tablaListaClientesSalesforce").dataTable({
		dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
		width: "100%",
		scrollX: true,
		buttons: [{
			extend: 'excelHtml5',
			text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
			className: 'btn buttons-excel',
			titleAttr: 'Descargar archivo de Excel',
			title: 'LISTA DE CLIENTES SALESFORCE',
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
				format: {
					header: function (d, columnIdx) {
						return ' ' + titulos[columnIdx] + ' ';
					}
				}
			}
		}],
		language: {
			url: "../static/spanishLoader_v2.json",
			paginate: {
				previous: "<i class='fa fa-angle-left'>",
				next: "<i class='fa fa-angle-right'>"
			}
		},
		destroy: true,
		ordering: false,
		columns: [
			{ data: 'idLote' },
			{ data: 'nombreResidencial' },
			{ data: 'nombreCondominio' },
			{ data: 'nombreLote' },
			{ data: 'nombreCliente' },
			{ data: 'noRecibo' },
			{ data: 'referencia' },
			{ data: 'fechaApartado' },
			{ data: 'engancheCliente' },
			{ data: 'fechaEnganche' },
			{ data: 'fechaCreacionProspecto' },
			{
				data: function (d) {
					return `<span class="label lbl-oceanGreen">${d.id_prospecto}</span>`;
				}
			},
			{
				data: function (d) {
					return `<span class="label lbl-azure">${d.id_salesforce}</span>`;
				}
			},
			{
				data: function (d) {
					return `<span class="label lbl-violetDeep">${d.nombreStatusContratacion}</span>`;
				}
			}],
		columnDefs: [{
			visible: false,
			searchable: false
		}],
		ajax: {
			url: `${general_base_url}Clientes/getListaClientesSalesforce`,
			type: "POST",
			cache: false
		}
	});
}

$('#tablaListaClientesSalesforce').on('draw.dt', function () {
	$('[data-toggle="tooltip"]').tooltip({
		trigger: "hover"
	});
});
