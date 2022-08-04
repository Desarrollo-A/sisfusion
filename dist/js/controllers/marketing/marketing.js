$(document).ready(function () {
	sp.initFormExtendedDatetimepickers();
	$('.datepicker').datetimepicker({locale: 'es'});
	setInitialValues(0);
});

$(document).on('click', '.menuTab', function(e){
    changeTab(this.id);
});

function changeTab(tab){
	if( tab == "prospectosTab" )
		setInitialValues(0);
	else if ( tab == "clientesTab")
		setInitialValues(1);
}

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

$('#prospectosTable thead tr:eq(0) th').each(function (i) {
	const title = $(this).text();
	$(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
	$('input', this).on('keyup change', function () {
		if ($("#prospectosTable").DataTable().column(i).search() !== this.value) {
			$("#prospectosTable").DataTable().column(i).search(this.value).draw();
		}
	});
});

$('#clientesTable thead tr:eq(0) th').each(function (i) {
	const title = $(this).text();
	$(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
	$('input', this).on('keyup change', function () {
		if ($("#clientesTable").DataTable().column(i).search() !== this.value) {
			$("#clientesTable").DataTable().column(i).search(this.value).draw();
		}
	});
});

function fillProspectos(beginDate, endDate) {
	console.log("prospectos");
	prospectosTable = $('#prospectosTable').dataTable({
		dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
		width: "auto",
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
				className: 'btn buttons-excel',
				titleAttr: 'Descargar archivo de Excel',
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
					format: {
						header: function (d, columnIdx) {
							switch (columnIdx) {
								case 0:
									return 'NOMBRE';
									break;
								case 1:
									return 'FECHA NACIMIENTO'
									break;
								case 2:
									return 'TELÉFONO';
									break;
								case 3:
									return 'CORREO';
									break;
								case 4:
									return 'LUGAR PROSPECCIÓN';
									break;
								case 5:
									return 'ASESOR';
									break;
								case 6:
									return 'COORDINADOR';
									break;
								case 7:
									return 'GERENTE';
									break;
								case 8:
									return 'SUBDIRECTOR';
									break;
								case 9:
									return 'DIRECTOR REGIONAL';
									break;
								case 10:
									return 'FECHA CREACIÓN';
									break;
								case 11:
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
				className: "btn btn-azure reset-prospectos",
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
					return d.nombreProspecto + '<br>' +'<span class="label" style="background:#1ABC9C">'+ d.id_prospecto +'</span>';
				}
			},
			{
				data: function (d) {
					if (d.fn == '' || d.fn  == '01/01/1900' || d.fn == null){
						return 'Sin especificar';
					} 
					else 
						return d.fn;
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
					return d.fecha_creacion
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
				"type": 0,
				"beginDate": beginDate,
				"endDate": endDate
			}
		}
	});
}

function fillClientes(beginDate, endDate) {
	clientesTable = $('#clientesTable').dataTable({
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
									return 'NOMBRE';
									break;
								case 1:
									return 'FECHA NACIMIENTO';
									break;
								case 2:
									return 'TELÉFONO';
									break;
								case 3:
									return 'CORREO';
									break;
								case 4:
									return 'LUGAR PROSPECCIÓN';
									break;
								case 5:
									return 'FECHA APARTADO';
									break;
								case 6:
									return 'ASESOR';
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
				className: "btn btn-azure reset-clientes",
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
					return d.nombreProspecto + '<br>' +'<span class="label" style="background:#1ABC9C">'+ d.id_prospecto +'</span>';
				}
			},
			{
				data: function (d) {
					if (d.id_cliente == null) {
						if (d.fn2 == '' || d.fn2  == '1900-01-01 00:00:00.000' || d.fn2 == null)
						{
							if (d.fn1 == '' || d.fn1  == '01/01/1900' || d.fn1 == null) {
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
					return d.lugar_prospeccion;
				}
			},
			{
				data: function (d) {
					return d.fechaApartado;
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
				"type": 1,
				"beginDate": beginDate,
				"endDate": endDate
			}
		}
	});
}

$(document).on("click", "#searchByDateRangeProspectos", function () {
	console.log("prospectos");
	let finalBeginDate = $("#beginDate").val();
	let finalEndDate = $("#endDate").val();
	fillProspectos(finalBeginDate, finalEndDate);
});

$(document).on("click", "#searchByDateRangeClientes", function () {
	let finalBeginDate = $("#beginDateD").val();
	let finalEndDate = $("#endDateD").val();
	fillClientes(finalBeginDate, finalEndDate);
});

function setInitialValues(type){
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
	
	if ( type == 0 ){
		fillProspectos(finalBeginDate, finalEndDate);
		$("#beginDate").val(convertDate(beginDate));
		$("#endDate").val(convertDate(endDate));
	}
	else{
		fillClientes(finalBeginDate, finalEndDate);
		$("#beginDateD").val(convertDate(beginDate));
		$("#endDateD").val(convertDate(endDate));
	}
}

$(document).on("click", ".reset-clientes", function () {
	setInitialValues(1);
	$(".idLote").val('');
	$(".textoshead").val('');
});

$(document).on("click", ".reset-prospectos", function () {
	setInitialValues(0);
	$(".idLote").val('');
	$(".textoshead").val('');
});