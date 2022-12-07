$('#dragonsClientsTable thead tr:eq(0) th').each(function (i) {
	if (i != 14) {
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
	}
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
					let btns = `<div class="d-flex align-center justify-center">`;
                    btns += `<button class="btn-data btn-blueMaderas reviewEvidence" data-lote ="${d.nombreLote}" data-nombre-archivo="${d.nombre_archivo}" title="Ver evidencia"></body><i class="fas fa-file"></i></button>`;
                    btns += `<button class="btn-data btn-gray see-information" data-id-prospecto = "${d.id_prospecto}" title="Bitácora de cambios"></body><i class="fas fa-eye"></i></button>`;
					btns += '</div>';
                    return btns;
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

$(document).on('click', '.reviewEvidence', function () {
    let fileName = $(this).attr("data-nombre-archivo");
    $("#img_actual").empty();
    let path = general_base_url + "static/documentos/cliente/expediente/" + fileName;
    let img_cnt = '<img src="' + path + '" class="img-responsive zoom m-auto">';
    $("#token_name").text($(this).attr("data-token-name"));
    $("#img_actual").append(img_cnt);
    $("#reviewTokenEvidence").modal();
});

$(document).on('click', '.see-information', function(e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    $("#seeInformationModal").modal();
    $.getJSON("getChangelog/" + id_prospecto).done(function(data) {
        if (data.length == 0) {
            $("#changelog").append('SIN DATOS POR MOSTRAR');
        } else {
            $.each(data, function(i, v) {
                fillChangelog(v);
            });
        }
    });
});

function cleanComments() {
	var myChangelog = document.getElementById('changelog');
    myChangelog.innerHTML = '';
}

function fillChangelog(v) {
    $("#changelog").append('<li class="timeline-inverted">\n' +
        '    <div class="timeline-badge success"></div>\n' +
        '    <div class="timeline-panel">\n' +
        '            <label><h6>' + v.parametro_modificado + '</h6></label><br>\n' +
        '            <b>Valor anterior:</b> ' + v.anterior + '\n' +
        '            <br>\n' +
        '            <b>Valor nuevo:</b> ' + v.nuevo + '\n' +
        '        <h6>\n' +
        '            <span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> ' + v.fecha_creacion + ' - ' + v.creador + '</span>\n' +
        '        </h6>\n' +
        '    </div>\n' +
        '</li>');
}

