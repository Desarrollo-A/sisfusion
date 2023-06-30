$(document).ready(function () {
	$.post(`${general_base_url}Contratacion/sedesPorDesarrollos`, function (data) {
		var len = data.length;
		for (var i = 0; i < len; i++) {
			var id = data[i]['id_sede'];
			var name = data[i]['nombre'];
			$("#sedes").append($('<option>').val(id).text(name.toUpperCase()));
		}
		$("#sedes").selectpicker('refresh');
	}, 'json');
});

$(document).on('change', "#sedes", function () {
	fillTableInventario($(this).val());
	$('#tabla_inventario_contraloria').removeClass('hide');
	$('#spiner-loader').removeClass('hide');
});

let titulos = [];
$('#tabla_inventario_contraloria thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
    $('input', this).on('keyup change', function () {
        if ($('#tabla_inventario_contraloria').DataTable().column(i).search() !== this.value) {
            $('#tabla_inventario_contraloria').DataTable().column(i).search(this.value).draw();
        }
    });
	$('[data-toggle="tooltip"]').tooltip({trigger: "hover" });
});

function fillTableInventario(sede) {
	tabla_inventario = $("#tabla_inventario_contraloria").DataTable({
		dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
		destroy: true,
		buttons: [{
			extend: 'excelHtml5',
			text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
			className: 'btn buttons-excel',
			titleAttr: 'Inventario Lotes',
			title: "Inventario Lotes",
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
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
		processing: true,
		pageLength: 10,
		bAutoWidth: false,
		bLengthChange: false,
		bInfo: true,
		searching: true,
		paging: true,
		ordering: false,
		fixedColumns: true,
		columnDefs: [{
			defaultContent: "",
			targets: "_all",
			searchable: true,
			orderable: false
		}],
		columns:
			[
				{data: 'nombreResidencial'},
				{data: 'nombreCondominio'},
				{data: 'nombreLote'},
				{
					data: function (d) {
						return d.sup + ' <b>m<sup>2</sup></b>';
					}
				},
				{
					data: function (d) {
						return '$ ' + formatMoney(d.precio);
					}
				},
				{
					data: function (d) {
						return '$ ' + formatMoney(d.precio * d.sup);
					}
				},
				{
					data: function (d) {
						return '$ ' + formatMoney(d.totalNeto2);
					}
				},
				{data: 'referencia'},
				{data: 'msni'},
				{
					data: function (d) {
						if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
							return d.asesor2;
						else
							return d.asesor;
					}
				},
				{
					data: function (d) {
						if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
							return d.coordinador2;
						else
							return d.coordinador;
					}
				},
				{
					data: function (d) {
						if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
							return d.gerente2;
						else
							return d.gerente;
					}
				},
				{
					data: function (d) {
						if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
							return d.subdirector2;
						else
							return d.subdirector;
					}
				},
				{
					data: function (d) {
						if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
							return d.regional22;
						else
							return d.regional;
					}
				},
				{
					data: function (d) {
						if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
							return 'SIN ESPECIFICAR';
						else
							return d.regional2;
					}
				},
				{
					data: function (d) {
						libContraloria = (d.observacionContratoUrgente == '1') ? '<center><span class="label lbl-warning";">Lib. Contraloría</span> <center><p><p>' : '';
						valTV = (d.tipo_venta == null) ? '<center><span class="label lbl-danger" style="background:#' + d.background_sl + '18; color:#' + d.color + ';">' + d.descripcion_estatus + '</span> <center>' :
							'<center><span class="label lbl-danger" style="background:#' + d.background_sl + '18; color:#' + d.color + ';">' + d.descripcion_estatus + '</span> <p><p> <span class="label lbl-warning">' + d.tipo_venta + '</span> <center>';
						return valTV + libContraloria;
					}
				},
				{
					data: function (d) {
						if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
							return d.fecha_modst;
						else
							return d.fechaApartado;
					}
				},
				{
					data: function (d) {
						if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10 || d.idStatusLote == 11 || d.idStatusLote == 4
							|| d.idStatusLote == 6 || d.idStatusLote == 7) {
							if (d.motivo_change_status == 'NULL' || d.motivo_change_status == 'null' || d.motivo_change_status == null)
								return ' - ';
							else
								return '<p>' + d.motivo_change_status + '</p>';
						} else {
							if (d.comentario == 'NULL' || d.comentario == 'null' || d.comentario == null)
								return ' - ';
							else
								return d.comentario;
						}
					}
				},
				{data: 'lugar_prospeccion'},
				{data: 'fecha_creacion'},
				{data: 'fecha_validacion'},
				{
					data: function (d) {
						return '$ ' + formatMoney(d.cantidad_enganche);
					}
				},
				{
					data: function (d) {
						if (d.id_cliente_reubicacion == 0)
							return `<span class="label lbl-oceanGreen"">REUBICADO</span>`;
						else
							return `<span class="label lbl-pink">NO APLICA</span>`;
					}
				},
				{
					data: function (d) {
						if (d.id_cliente_reubicacion == 0)
							return d.fechaAlta;
						else
							return 'NO APLICA';
					}
				}
			],
		ajax: {
			url: `${general_base_url}Contratacion/downloadCompleteInventory`,
			type: "POST",
			cache: false,
			data: {id_sede: sede}
		},
		initComplete: function () {
			$('#spiner-loader').addClass('hide');
		}
	});

	$(window).resize(function () {
		tabla_inventario.columns.adjust();
	});
}
