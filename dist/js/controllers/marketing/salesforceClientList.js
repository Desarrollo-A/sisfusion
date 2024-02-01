$(document).ready(function () {
	fillSalesForceClientsTable();
	Shadowbox.init();
});

let titulos = [];
$('#salesforceClientsTable thead tr:eq(0) th').each(function (i) {
	const title = $(this).text();
	titulos.push(title);
	$(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
	$('input', this).on('keyup change', function () {
		if ($("#salesforceClientsTable").DataTable().column(i).search() !== this.value) {
			$("#salesforceClientsTable").DataTable().column(i).search(this.value).draw();
		}
	});
});

function fillSalesForceClientsTable() {
    $("#salesforceClientsTable").dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
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
        columns: [{
			data: function (d) {
				return d.idLote;
			}
		},
		{
			data: function (d) {
				return d.nombreProyecto;
			}
		},
		{
			data: function (d) {
				return d.nombreCondominio;
			}
		},
		{
			data: function (d) {
				return d.nombreLote;
			}
		},
		{
			data: function (d) {
				return d.nombreCliente;
			}
		},
		{
			data: function (d) {
				let numero_recibo;
				if(d.noRecibo == null)
					numero_recibo = 'SIN RECIBO';
				else
					numero_recibo = d.noRecibo;
				return numero_recibo;
			}
		},
		{
			data: function (d) {
				return d.referencia;
			}
		},
		{
			data: function (d) {
				return d.fechaApartado;
			}
		},
		{
			data: function (d) {
				return formatMoney(d.engancheCliente)
			}
		},
		{
			data: function (d) {
				return d.fechaEnganche;
			}
		},
		{
			data: function (d) {
				return   d.fechaCreacionProspecto;
			}
		},
		{
			data: function (d) {
				return `<span class="label lbl-oceanGreen">${d.id_prospecto}</span>`;
			}
		},
		{
			data: function (d) {
				let validateData = d.id_salesforce == 0 ? 'NO DISPONIBLE' : d.id_salesforce;
				return `<span class="label lbl-azure">${validateData}</span>`;
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
            url: general_base_url + 'Clientes/getSalesforceClientsList',
            type: "POST",
            cache: false
        }
    });
}

$('#salesforceClientsTable').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

function cleanComments() {
	var myChangelog = document.getElementById('changelog');
    myChangelog.innerHTML = '';
}
