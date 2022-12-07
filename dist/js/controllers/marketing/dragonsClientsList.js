$('#dragonsClientsTable thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($("#dragonsClientsTable").DataTable().column(i).search() !== this.value) {
            $("#dragonsClientsTable").DataTable()
                .column(i)
                .search(this.value)
                .draw();
        }
    });

});

function fillDragonsClientsTable() {
    $("#dragonsClientsTable").dataTable({
        dom: 'Brt' + "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: "auto",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
					format: {
						header: function (d, columnIdx) {
							switch (columnIdx) {
								case 0:
									return 'ID LOTE';
									break;
								case 1:
									return 'PROYECTO';
								case 2:
									return 'CONDOMINIO';
									break;
								case 3:
									return 'LOTE';
									break;
								case 4:
									return 'NOMBRE';
									break;
								case 5:
									return 'NO. RECIBO';
									break;
								case 6:
									return 'REFERENCIA';
									break;
								case 7:
									return 'FECHA APARTADO';
									break;
								case 8:
									return 'ENGANCHE';
									break;
								case 9:
									return 'FECHA ENGANCHE';
									break;
								case 10:
									return 'FECHA CREACIÓN PROSPECTO';
									break;
								case 11:
									return 'ID CRM';
									break;
								case 12:
									return 'ID DRAGON';
									break;
								case 13:
									return 'ESTATUS LOTE';
									break;
							}
						}
					}
                }
            }
        ],
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
			{
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
					return '<p class="m-0">'+ d.nombreCliente;
				}
			},
			{
				data: function (d) {
					let numero_recibo;
					if(d.noRecibo == null)
						numero_recibo = '--';
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
					return myFunctions.convertDateYMDHMS(d.fechaApartado);
				}
			},
			{
				data: function (d) {
					return myFunctions.number_format(d.engancheCliente, 2, '.', ',');
				}
			},
			{
				data: function (d) {
					return myFunctions.convertDateYMDHMS(d.fechaEnganche);
				}
			},
			{

				data: function (d) {
					return   myFunctions.convertDateYMDHMS(d.fechaCreacionProspecto);
				}
			},
			{
				data: function (d) {
					return `<span class="label" style="background: #A3E4D7; color: #0E6251">${d.id_prospecto}</span>`;
				}
			},
			{
				data: function (d) {
					let validateData = d.id_dragon == 0 ? 'No disponible' : d.id_dragon;
					return `<span class="label" style="background: #AED6F1; color: #1B4F72">${validateData}</span>`;
				}
			},
			{
				data: function (d) {
					return `<span class="label" style="background: #D2B4DE; color: #4A235A">${d.nombreStatusContratacion}</span>`;
				}
			},
			{
				data: function (d) {
					return '<center><button class="btn-data btn-deepGray cop" title= "Ventas compartidas" data-idcliente="' + d.id_cliente + '"><i class="material-icons">people</i></button></center>';
				}
			}

		],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: url2 + 'Clientes/getDragonsClientsList',
            type: "POST",
            cache: false
        }
    });
}

$(document).on("click", "#generateToken", function () {
    document.getElementById("fileElm").value = "";
    document.getElementById("file-name").value = "";
    $("#generateTokenModal").modal("show");
    $("#asesoresList").val("").selectpicker("refresh");
});
