$(document).ready(function () {
	sp.initFormExtendedDatetimepickers();
	$('.datepicker').datetimepicker({locale: 'es'});
	/*
	fillTable(typeTransaction, beginDate, endDate, where) PARAMS;
		typeTransaction:
			1 = ES LA PRIMERA VEZ QUE SE LLENA LA TABLA O NO SE SELECCIONÓ UN RANGO DE FECHA (MUESTRA LO DEL AÑO ACTUAL)
			2 = ES LA SEGUNDA VEZ QUE SE LLENA LA TABLA (MUESTRA INFORMACIÓN CON BASE EN EL RANGO DE FECHA SELECCIONADO)
		beginDate
			FECHA INICIO
		endDate
			FECHA FIN
	*/

	setInitialValues();
});

sp = { //  SELECT PICKER
	initFormExtendedDatetimepickers: function () {
		$('.datepicker').datetimepicker({
			format: 'MM/DD/YYYY',
			icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-chevron-up",
				down: "fa fa-chevron-down",
				previous: 'fa fa-chevron-left',
				next: 'fa fa-chevron-right',
				today: 'fa fa-screenshot',
				clear: 'fa fa-trash',
				close: 'fa fa-remove',
				inline: true
			}
		});
	}
}

$('#masterCobranzaTable thead tr:eq(0) th').each(function (i) {
	const title = $(this).text();
	if (i != 19){
		$(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
		$('input', this).on('keyup change', function () {
			if ($("#masterCobranzaTable").DataTable().column(i).search() !== this.value) {
				$("#masterCobranzaTable").DataTable()
					.column(i)
					.search(this.value)
					.draw();
			}
		});
	}
});

function fillTable(beginDate, endDate) {

	generalDataTable = $('#masterCobranzaTable').dataTable({
		dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
		width: "auto",
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
				className: 'btn buttons-excel',
				titleAttr: 'Descargar archivo de Excel',
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
					format: {
						header: function (d, columnIdx) {
							switch (columnIdx) {
								case 0:
									return 'TIPO';
									break;
								case 1:
									return 'NOMBRE';
									break;
								case 2:
									return 'FECHA NACIMIENTO'
								case 3:
									return 'TELÉFONO';
									break;
								case 4:
									return 'CORREO';
									break;
								case 5:
									return 'LUGAR PROSPECCIÓN';
									break;
								case 6:
									return 'FECHA APARTADO';
									break;
								case 7:
									return 'COORDINADOR';
									break;
								case 8:
									return 'GERENTE';
									break;
								case 9:
									return 'SUBDIRECTOR';
									break;
								case 10:
									return 'DIRECTOR REGIONAL';
									break;
								case 11:
									return 'RESIDENCIAL';
									break;
								case 12:
									return 'CONDOMINIO';
									break;
								case 13:
									return 'LOTE';
									break;
								case 14:
									return 'FECHA CREACIÓN';
									break;
								case 15:
									return 'DÍAS CIERRE';
									break;
								case 16:
									return 'DIRECCIÓN';
									break;
							}
						}
					}
				}
			},
			{
				text: "<i class='fa fa-refresh' aria-hidden='true'></i>",
				titleAttr: 'Cargar vista inicial',
				className: "btn btn-azure reset-initial-values",
			}
		],
		pagingType: "full_numbers",
		fixedHeader: true,
		scrollX: true,
		lengthMenu: [
			[10, 25, 50, -1],
			[10, 25, 50, "Todos"]
		],
		language: {
			url: `${general_base_url}static/spanishLoader_v2.json`,
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
					if (d.tipo == 0) // PROSPECTO
						return '<center><span class="label" style="background:#85C1E9; color:#1B4F72">Prospecto</span><center>';
					else if (d.tipo == 1) // CLIENTE
						return '<center><span class="label" style="background:#76D7C4; color:#0E6251">Cliente</span><center>';
				}
			},
			{
				data: function (d) {
					return d.nombreProspecto + '<br>' +'<span class="label" style="background:#1ABC9C">'+ d.id_prospecto +'</span>';
				}
			},
			{
				data: function (d) {
					if (d.id_cliente == null) {
						if (d.fn2 == '' || d.fn2  == '01/01/1900')
						{
							if (d.fn1 == '' || d.fn1  == '01/01/1900') {
								return 'Sin especificar';
							}
							else 
								return d.fn1;
						} 
						else
							return d.fn2;
					}
				}
			},
			{
				data: function (d) {
					return d.telefono;
				}
			},
			{
				data: function (d) {
					return d.correo;
				}
			},
			{
				data: function (d) {
					return d.lugar_prospeccion2;
				}
			},
			{
				data: function (d) {
					return d.fechaApartado
				}
			},
			{
                data: function(d) {
                    return d.asesor;
                }
            },
            {
                data: function (d) {
                    return d.coordinador == '  ' ? 'SIN ESPECIFICAR' : d.coordinador;
                }
            },
            {
                data: function (d) {
                    return d.gerente == '  ' ? 'SIN ESPECIFICAR' : d.gerente;
                }
            },
            {
                data: function (d) {
                    return d.subdirector == '  ' ? 'SIN ESPECIFICAR' : d.subdirector;
                }
            },
            {
                data: function (d) {
                    return d.regional == '  ' ? 'SIN ESPECIFICAR' : d.regional;
                }
            },
			{
				data: function (d) {
					return d.residemcial;
				}
			},
			{
				data: function (d) {
					return d.condominio
				}
			},
			{
                data: function(d) {
                    return d.lote;
                }
            },
			{
				data: function (d) {
					return d.fecha_creacion
				}
			},
			{
                data: function(d) {
                    return d.dias_cierre;
                }
            },
			{
                data: function(d) {
                    return d.direccion;
                }
            },
		],
		columnDefs: [{
			visible: false,
			searchable: false
		}],
		ajax: {
			url: 'getProspectsReportInformation',
			type: "POST",
			cache: false,
			data: {
				"beginDate": beginDate,
				"endDate": endDate
			}
		}
	});
}

$(document).on("click", "#searchByDateRange", function () {
	let finalBeginDate = $("#beginDate").val();
	let finalEndDate = $("#endDate").val();
	fillTable(finalBeginDate, finalEndDate);
});

function setInitialValues() {
	// BEGIN DATE
	const fechaInicio = new Date();
	// Iniciar en este año, este mes, en el día 1
	const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
	// END DATE
	const fechaFin = new Date();
	// Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
	const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
	finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
	finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
	$("#beginDate").val(convertDate(beginDate));
	$("#endDate").val(convertDate(endDate));
	fillTable(finalBeginDate, finalEndDate);
}


$(document).on("click", ".reset-initial-values", function () {
	setInitialValues();
	$(".idLote").val('');
	$(".textoshead").val('');
});

$(document).on('click', '#requestCommissionPayment', function () {
	let idLote = $(this).attr("data-idLote");
	$("#idLote").val(idLote);
	$("#modalConfirmRequest").modal();
});
