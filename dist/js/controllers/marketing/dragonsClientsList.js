$(document).ready(function () {
	fillDragonsClientsTable();
	Shadowbox.init();
});

let titulos = [];
$('#dragonsClientsTable thead tr:eq(0) th').each(function (i) {
	const title = $(this).text();
	titulos.push(title);
	$(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
	$('input', this).on('keyup change', function () {
		if ($("#dragonsClientsTable").DataTable().column(i).search() !== this.value) {
			$("#dragonsClientsTable").DataTable().column(i).search(this.value).draw();
		}
	});
});

function fillDragonsClientsTable() {
    $("#dragonsClientsTable").dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons: [{
			extend: 'excelHtml5',
			text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
			className: 'btn buttons-excel',
			titleAttr: 'Descargar archivo de Excel',
			title: 'LISTA DE CLIENTES MARKETING DRAGON',
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
				let validateData = d.id_dragon == 0 ? 'NO DISPONIBLE' : d.id_dragon;
				return `<span class="label lbl-azure">${validateData}</span>`;
			}
		},
		{
			data: function (d) {
				return `<span class="label lbl-violetDeep">${d.nombreStatusContratacion}</span>`;
			}
		},
		{
			data: function (d) {
				let btns = `<div class="d-flex align-center justify-center">`;
				btns += `<button class="btn-data btn-blueMaderas reviewEvidence" data-lote ="${d.nombreLote}" data-nombre-archivo="${d.nombre_archivo}" data-toggle="tooltip"  data-placement="top" title="VER EVIDENCIA"></body><i class="fas fa-file"></i></button>`;
				btns += `<button class="btn-data btn-orangeYellow see-information" data-id-prospecto = "${d.id_prospecto}" data-toggle="tooltip"  data-placement="top" title="BITÁCORA DE CAMBIOS"></body><i class="fas fa-eye"></i></button>`;
				btns += '</div>';
				return btns;
			}
		}],
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

$('#dragonsClientsTable').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

$(document).on('click', '.reviewEvidence', function () {
	let fileName = $(this).attr("data-nombre-archivo");
	let lote = $(this).attr("data-lote");
	let extension = fileName.slice(fileName.length - 4);
	let path = general_base_url + "static/documentos/cliente/expediente/" + fileName;
	if (extension != '.pdf' && fileName != 0) { // MJ: ES UNA IMAGEN
		$("#token_name").text(lote);
		$("#img_actual").empty();
		let img_cnt = '<img src="' + path + '" class="img-responsive zoom m-auto">';
		$("#img_actual").append(img_cnt);
		$("#reviewTokenEvidence").modal();
	} else if (fileName == 0) // MJ: NO HAY EVIDENCIA CARGADA
		alerts.showNotification("top", "right", "No hay ningún archivo cargado para el lote " + lote + ".", "warning");
	else if (extension == '.pdf') { // MJ: ES UN PDF
		Shadowbox.open({
			content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="' + path + '"></iframe></div>',
			player:     "html",
			title:      "Visualizando archivo: " + lote,
			width:      985,
			height:     660
		});
	}
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
	$("#changelog").append('<li>\n' +
        '    <div class="container-fluid">\n' +
        '       <div class="row">\n' +
        '           <div class="col-md-6">\n' +
        '               <a><small>Campo: </small><b> ' +v.parametro_modificado.toUpperCase()+ '</b></a><br>\n' +
        '           </div>\n' +
        '           <div class="float-end text-right">\n' +
        '               <a>' + v.fecha_creacion + '</a>\n' +
        '           </div>\n' +
        '           <div class="col-md-12">\n' +
    '                <p class="m-0"><small>USUARIO: </small><b> ' + v.creador + '</b></p>\n'+
    '                <p class="m-0"><small>VALOR ANTERIOR: </small><b> ' + v.anterior.toUpperCase() + '</b></p>\n' +
    '                <p class="m-0"><small>VALOR NUEVO: </small><b> ' + v.nuevo.toUpperCase() + '</b></p>\n' +
        '           </div>\n' +
        '        <h6>\n' +
        '        </h6>\n' +
        '       </div>\n' +
        '    </div>\n' +
        '</li>');
}