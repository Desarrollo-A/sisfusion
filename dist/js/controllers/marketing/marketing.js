$(document).ready(function () {
	$.post(general_base_url + "Contraloria/get_sede", function (data) {
		var len = data.length;
		for (var i = 0; i < len; i++) {
			var id = data[i]['id_sede'];
			var name = data[i]['nombre'];
			$("#sede").append($('<option>').val(id).text(name.toUpperCase()));
			$("#sedeC").append($('<option>').val(id).text(name.toUpperCase()));
		}

		$("#sede").selectpicker('refresh');
		$("#sedeC").selectpicker('refresh');
	}, 'json');
	sp.initFormExtendedDatetimepickers();
	$('.datepicker').datetimepicker({locale: 'es'});
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

$('#searchButton').click(()=>{

	let name = $('#name').val();
	let mail = $('#mail').val();
	let telephone = $('#telephone').val();
	let sede = $('#sede').val();
	let id_dragon = $('#idDragon').val();
	let fecha_init = $('#beginDate').val();
	let fecha_end = $('#endDate').val();

	name = (name!='') ? name : '';
	mail = (mail!='') ? mail : '';
	telephone = (telephone!='') ? telephone : '';
	sede = (sede!='') ? sede.toString() : '';
	id_dragon = (id_dragon!='') ? id_dragon: '';
	fecha_init = (fecha_init!='') ? fecha_init : '';
	fecha_end = (fecha_end!='') ? fecha_end : '';


	if(name!='' || mail!='' || telephone!='' || sede!='' || id_dragon!=''){
		let array_data = [];
		array_data['idLote'] = '';
		array_data['name'] = name;
		array_data['mail'] = mail;
		array_data['telephone'] = telephone;
		array_data['sede'] = sede;
		array_data['id_dragon'] = id_dragon;
		array_data['fecha_init'] = fecha_init;
		array_data['fecha_end'] = fecha_end;
		fillTable(array_data);
	}else{
		alerts.showNotification('top', 'right', 'Ingresa al menos un parámetro de busqueda', 'warning')
	}

});
$('#searchButtonC').click(()=>{

	let idLote = $('#idLotteC').val();
	let name = $('#nameC').val();
	let mail = $('#mailC').val();
	let telephone = $('#telephoneC').val();
	let sede = $('#sedeC').val();
	let id_dragon = $('#idDragonC').val();
	let fecha_init = $('#beginDateC').val();
	let fecha_end = $('#endDateC').val();


	idLote = (idLote!='') ? idLote : '';
	name = (name!='') ? name : '';
	mail = (mail!='') ? mail : '';
	telephone = (telephone!='') ? telephone : '';
	sede = (sede!='') ? sede.toString() : '';
	id_dragon = (id_dragon!='') ? id_dragon : '';
	fecha_init = (fecha_init!='') ? fecha_init : '';
	fecha_end = (fecha_end!='') ? fecha_end : '';


	if(idLote!='' || name!='' || mail!='' || telephone!='' || sede!='' || id_dragon!=''){
		let array_data = [];
		array_data['idLote'] = idLote;
		array_data['name'] = name;
		array_data['mail'] = mail;
		array_data['telephone'] = telephone;
		array_data['sede'] = sede;
		array_data['id_dragon'] = id_dragon;
		array_data['fecha_init'] = fecha_init;
		array_data['fecha_end'] = fecha_end;


		fillTableClientes(array_data);
	} else {
		alerts.showNotification('top', 'right', 'Ingresa al menos un parámetro de busqueda', 'warning')
	}
});

var tabla_valores_prospectos;
var titulos_encabezado_prospectos = [];
var num_colum_encabezado_prospectos = [];
$("#tabla_prospectos").ready(function () {
	$('#tabla_prospectos thead tr:eq(0) th').each(function (i) {
		var title = $(this).text();
		titulos_encabezado_prospectos.push(title);
        num_colum_encabezado_prospectos.push(i);
		$(this).html(`<input 	type="text"
                                class="textoshead"
                                data-toggle="tooltip_prospectos" 
                                data-placement="top"
                                title="${title}"
                                placeholder="${title}"/>`);
		$('input', this).on('keyup change', function () {
			if (tabla_valores_prospectos.column(i).search() !== this.value) {
				tabla_valores_prospectos
					.column(i)
					.search(this.value)
					.draw();
			}
		});
	});
});

function fillTable(data_search) {
	tabla_valores_prospectos = $("#tabla_prospectos").DataTable({
		width: 'auto',
		dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
				className: 'btn buttons-excel',
				titleAttr: 'Registro de clientes',
				title:'Lista de prospectos',
				exportOptions: {
					columns: num_colum_encabezado_prospectos,
					format: {
						header: function (d, columnIdx) {
							return ' '+titulos_encabezado_prospectos[columnIdx] +' ';
						}
					}
				},

			}
		],
		pagingType: "full_numbers",
		language: {
			url: general_base_url+"static/spanishLoader_v2.json",
			paginate: {
				previous: "<i class='fa fa-angle-left'>",
				next: "<i class='fa fa-angle-right'>"
			}
		},
		processing: false,
		pageLength: 10,
		bAutoWidth: false,
		bLengthChange: false,
		scrollX: true,
		bInfo: true,
		searching: true,
		ordering: false,
		fixedColumns: true,
		destroy: true,
		columns: [
			{
				data: function (d) {
					return '<p class="m-0">' + d.nombre_prospecto + '</p>';
				}
			},
			{
				data: function (d) {
					let tel1 = d.telefono;
					let tel2 = d.telefono_2;
					let telefono;
					if(tel1==null){
						telefono = tel2;
					}else if(tel2==null){
						telefono = tel1;
					}else if(tel1==null || tel2==null){
						telefono = '--'
					}else{
						telefono = 'Sin teléfono';
					}
					return '<p class="m-0">' + telefono + '</p>';
				}
			},
			{
				data: function (d) {
					let correo = '';
					if(d.correo == undefined || d.correo == '' || d.correo == null){
						correo = 'Sin correo';
					}else{
						correo = d.correo;
					}
					return '<p class="m-0">' + correo+ '</p>';
				}
			},
			{
				data: function (d) {
					let lugar_prospeccion = '';
					if(d.lugar_prospeccion=='' || d.lugar_prospeccion==undefined || d.lugar_prospeccion==null){
						lugar_prospeccion = '--';
					}else{
						lugar_prospeccion = d.lugar_prospeccion;
					}
					return '<p class="m-0">'+ lugar_prospeccion + '</p>';
				}
			},
			{
				data: function (d) {
					let asesor;
					if(d.nombre_asesor=='' || d.nombre_asesor==undefined || d.nombre_asesor==null){
						asesor = 'Sin asesor';
					}else{
						asesor = d.nombre_asesor;
					}
					return '<p class="m-0">' + asesor+ '</p>';
				}
			},
			{
				data: function (d) {
					let coordinador;
					if(d.nombre_coordinador == undefined || d.nombre_coordinador==null || d.nombre_coordinador==''){
						coordinador = 'Sin coordinador';
					}else{
						coordinador = d.nombre_coordinador;
					}
					return '<p class="m-0">' + coordinador + '</p>';
				}
			},
			{
				data: function (d) {
					let gerente;
					if(d.nombre_gerente == undefined || d.nombre_gerente == null || d.nombre_gerente ==''){
						gerente = 'Sin gerente';
					}else{
						gerente = d.nombre_gerente;
					}
					return '<p class="m-0">' + gerente + '</p>';
				}
			},
			{
				data: function (d) {
					return '<p class="m-0">' +  myFunctions.convertDateYMDHMS(d.fecha_creacion)  + '</p>';
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
					return `<span class="label" style="background: #F9E79F; color: #7D6608">${d.source}</span>`;
				}
			},
			{
				data: function (d) {
					let sede;
					if(d.sede_nombre==null || d.sede_nombre==undefined || d.sede_nombre ==''){
						sede = 'Sin sede';
					}else{
						sede = d.sede_nombre;
					}
					return '<p class="m-0">' +   sede + '</p>';
				}
			}
		],

		columnDefs: [{
			defaultContent: "",
			targets: "_all",
			searchable: true,
			orderable: false
		}],
		ajax: {
			type: 'POST',
			url: general_base_url+'Clientes/searchData',
			data: {
				"idLote": data_search['idLote'],
				"name" :  data_search['name'],
				"mail" :  data_search['mail'],
				"telephone":data_search['telephone'],
				"sede" : data_search['sede'],
				"id_dragon" : data_search['id_dragon'],
				"fecha_init" : data_search['fecha_init'],
				"fecha_end" : data_search['fecha_end'],
				"TB": 2
			},
			cache: false
		},
		order: [[1, 'asc']],
		initComplete: function () {
            $('[data-toggle="tooltip_prospectos"]').tooltip("destroy");
            $('[data-toggle="tooltip_prospectos"]').tooltip({trigger: "hover"});
        }
	});
}

var titulos_encabezado = [];
var num_colum_encabezado = [];
$("#tabla_clientes").ready(function () {
	let excluir_column = ['ACCIONES'];
	$('#tabla_clientes thead tr:eq(0) th').each(function (i) {
		var title = $(this).text();

		if (!excluir_column.includes(title) && title !== ''){
            titulos_encabezado.push(title);
            num_colum_encabezado.push(i);
        }
		let readOnly = excluir_column.includes(title) ? 'readOnly': '';
        let width = title == 'ACCIONES' ? 'width: 57px;' : '';
		$(this).html(`<input 	type="text"
                                style="${width}"
                                class="textoshead"
                                data-toggle="tooltip" 
                                data-placement="top"
                                title="${title}"
                                placeholder="${title}"
                                ${readOnly}/>`);
		$('input', this).on('keyup change', function () {
			if (tabla_valores_cliente.column(i).search() !== this.value) {
				tabla_valores_cliente
					.column(i)
					.search(this.value)
					.draw();
			}
		});
	});
});

var tabla_valores_cliente;
function fillTableClientes(data_search) {
	tabla_valores_cliente = $("#tabla_clientes").DataTable({
		width: 'auto',
		dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
				className: 'btn buttons-excel',
				titleAttr: 'Registro de clientes',
				title:'Registro de clientes',
				exportOptions: {
					columns: num_colum_encabezado,
					format: {
						header: function (d, columnIdx) {
							return ' '+titulos_encabezado[columnIdx] +' ';
						}
					}
				},

			}
		],
		pagingType: "full_numbers",
		language: {
			url: general_base_url +"static/spanishLoader_v2.json",
			paginate: {
				previous: "<i class='fa fa-angle-left'>",
				next: "<i class='fa fa-angle-right'>"
			}
		},
		processing: false,
		pageLength: 10,
		bAutoWidth: false,
		bLengthChange: false,
		scrollX: true,
		bInfo: true,
		searching: true,
		ordering: false,
		fixedColumns: true,
		destroy: true,
		columns: [
			{
				data: function (d) {
					return '<p class="m-0">' + d.idLote + '</p>';
				}
			},
			{
				data: function (d) {
					return '<p class="m-0">' + d.nombreProyecto + '</p>';
				}
			},
			{
				data: function (d) {
					return '<p class="m-0">' + d.nombreCondominio + '</p>';
				}
			},
			{
				data: function (d) {
					return '<p class="m-0">' + d.nombreLote + '</p>';
				}
			},
			{
				data: function (d) {
					let cliente ;
					if(d.nombreCliente==''||d.nombreCliente==undefined||d.nombreCliente==null){
						cliente = 'Sin cliente';
					}else{
						cliente = d.nombreCliente;
					}
					return '<p class="m-0">'+ cliente + '</p>';
				}
			},
			{
				data: function (d) {
					let numero_recibo;
					if(d.noRecibo == null)
						numero_recibo = '--';
					else
						numero_recibo = d.noRecibo;
					return '<p class="m-0">' + numero_recibo + '</p>';
				}
			},
			{
				data: function (d) {
					let referencia;
					if(d.referencia==undefined || d.referencia==null || d.referencia==''){
						referencia = 'Sin referencia';
					}else{
						referencia = d.referencia;
					}
					return '<p class="m-0">' + referencia + '</p>';
				}
			},
			{
				data: function (d) {
					return '<p class="m-0">' + myFunctions.convertDateYMDHMS(d.fechaApartado)+ '</p>';
				}
			},
			{
				data: function (d) {
					return '<p class="m-0">$' + myFunctions.number_format(d.engancheCliente, 2, '.', ',') + '</p>';
				}
			},
			{
				data: function (d) {
					return '<p class="m-0">' + myFunctions.convertDateYMDHMS(d.fechaEnganche) + '</p>';
				}
			},
			{

				data: function (d) {
					return '<p class="m-0">' +   myFunctions.convertDateYMDHMS(d.fechaCreacionProspecto)  + '</p>';
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
					return `<span class="label" style="background: #F9E79F; color: #7D6608">${d.source}</span>`;
				}
			},
			{
				data: function (d) {
					return `<span class="label" style="background: #D2B4DE; color: #4A235A">${d.nombreStatusContratacion}</span>`;
				}
			},
			{
				data: function (d) {
					return `<center>
								<button class="btn-data btn-blueMaderas cop"
										data-toggle="tooltip" 
                                        data-placement="top"
										title="Ventas compartidas"
										data-idcliente="${d.id_cliente}"
										data-idLote="${d.idLote}">
									<i class="material-icons">
										people
									</i>
								</button>
							</center>`;
				}
			}

		],
		columnDefs: [{
			defaultContent: "",
			targets: "_all",
			searchable: true,
			orderable: false
		}],
		ajax: {
			type: 'POST',
			url: general_base_url + 'Clientes/searchData',
			data: {
				"idLote": data_search['idLote'],
				"name" :  data_search['name'],
				"mail" :  data_search['mail'],
				"telephone":data_search['telephone'],
				"sede" : data_search['sede'],
				"id_dragon" : data_search['id_dragon'],
				"fecha_init" : data_search['fecha_init'],
				"fecha_end" : data_search['fecha_end'],
				"TB": 1
			},
			cache: false
		},
		order: [[1, 'asc']],
		initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip("destroy");
            $('[data-toggle="tooltip"]').tooltip({trigger: "hover"});
        }
	});
}

var tableHistorial;
var id_lote_global = 0;
$(document).on('click', '.cop', function (e) {
	e.preventDefault();
	var $itself = $(this);
	var idLote = $itself.attr('data-idLote');
	id_lote_global = idLote;
	tableHistorial.ajax.reload();
	$('#verDetalles').modal('show');
});

var titulos_encabezado_detalle = [];
var num_colum_encabezado_detalle = [];
$("#verDet").ready(function () {
	$('#verDet thead tr:eq(0) th').each(function (i) {
		var title = $(this).text();
		titulos_encabezado_detalle.push(title);
		num_colum_encabezado_detalle.push(i);
		$(this).html(`<input 	type="text"
								class="textoshead"
								data-toggle="tooltip_details" 
								data-placement="top"
								title="${title}"
								placeholder="${title}"
								readOnly/>`);
	});
});

$(document).ready(function () {
	tableHistorial = $('#verDet').DataTable({
		responsive: true,
		autoWidth: 'true',
		dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
		buttons:[
			{
				extend: 'excelHtml5',
				text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
				className: 'btn buttons-excel',
				titleAttr: 'Reporte ventas compartidas',
				title:'Reporte ventas compartidas',
				exportOptions: {
					columns: num_colum_encabezado_detalle,
					format: {
						header: function (d, columnIdx) {
							return ' '+titulos_encabezado_detalle[columnIdx] +' ';
						}
					}
				}
			}
		],
		scrollX: true,
		pageLength: 10,
		language: {
			url: general_base_url+"static/spanishLoader_v2.json",
			paginate: {
				previous: "<i class='fa fa-angle-left'>",
				next: "<i class='fa fa-angle-right'>"
			}
		},
		columns: [
			{
				"data": "asesor"
			},
			{
				"data": "coordinador"
			},
			{
				"data": "gerente"
			},
			{
				"data": "subdirector"
			},
			{
				"data": "regional"
			},
			{
				"data": "regional2"
			},
			{
				"data": "fecha_creacion"
			},
			{
				"data": "creado_por"
			}
		],
		"processing": true,
		"bAutoWidth": false,
		"bLengthChange": false,
		"bInfo": true,
		"ordering": false,
		"fixedColumns": true,
		"ajax": {
			"url": `${general_base_url}Contratacion/getCoSallingAdvisers/`,
			"type": "POST",
			"cache": false,
			"dataSrc": "",
			"data": function (d) {
				d.idLote = id_lote_global;
			}
		},
		initComplete: function () {
            $('[data-toggle="tooltip_details"]').tooltip("destroy");
            $('[data-toggle="tooltip_details"]').tooltip({trigger: "hover"});
        }
	});
});

function changeSede(){
	let sedes = $('#sede').val();
	if(sedes.length>0){
		$('#fechasFiltro').removeClass('hide');
		$('#clientes_btnsPr').removeClass('col-md-4 col-lg-4');
		$('#clientes_btnsPr').addClass('col-md-12 col-lg-12');
		$('#inside').removeClass('col-md-12 col-lg-12');
		$('#inside').addClass('col-md-offset-8 col-lg-offset-8 col-md-4 col-lg-4');
	}else{
		$('#fechasFiltro').addClass('hide');
		$('#clientes_btnsPr').addClass('col-md-4 col-lg-4');
		$('#clientes_btnsPr').removeClass('col-md-12 col-lg-12');
		$('#inside').addClass('col-md-12 col-lg-12');
		$('#inside').removeClass('col-md-offset-8 col-lg-offset-8 col-md-4 col-lg-4');
	}
}
function changeSedeC(){
	let sedes = $('#sedeC').val();
	if(sedes.length>0){
		$('#fechasFiltroC').removeClass('hide');
		$('#clientes_btns').removeClass('col-md-4 col-lg-4');
		$('#clientes_btns').addClass('col-md-12 col-lg-12');
		$('#insideC').removeClass('col-md-12 col-lg-12');
		$('#insideC').addClass('col-md-offset-8 col-lg-offset-8 col-md-4 col-lg-4');
	}else{
		$('#fechasFiltroC').addClass('hide');
		$('#clientes_btns').addClass('col-md-4 col-lg-4');
		$('#clientes_btns').removeClass('col-md-12 col-lg-12');
		$('#insideC').addClass('col-md-12 col-lg-12');
		$('#insideC').removeClass('col-md-offset-8 col-lg-offset-8 col-md-4 col-lg-4');
	}
}
function cleanFilters(){

	if($('#name').val()=='' && $('#mail').val()=='' && $('#telephone').val()=='' && $('#idDragon').val()=='' && $("#sede").val().length<=0){
		alerts.showNotification('top', 'right', 'Primero debes realizar una búsqueda', 'warning')
	}else{
		$('#name').val('');
		$('#mail').val('');
		$('#telephone').val('');
		$('#idDragon').val('');
		$("#sede").val('default');
		$("#sede").selectpicker("refresh");
		$('#fechasFiltro').addClass('hide');
		$('#beginDate').val('01/01/2022');
		$('#endDate').val('12/31/2022');
		$('#clientes_btnsPr').removeClass('col-md-12 col-lg-12');
		$('#clientes_btnsPr').addClass('col-md-4 col-lg-4');
		$('#inside').addClass('col-md-12 col-lg-12');
		$('#inside').removeClass('col-md-offset-8 col-lg-offset-8 col-md-4 col-lg-4');
		// $("#tabla_prospectos").DataTable().clear().draw();
		tabla_valores_prospectos.clear().draw();
		tabla_valores_prospectos.destroy();
	}


}

function cleanFiltersC(){
	// clientes_btns
	// insideC
	if($('#idLotteC').val()=='' && $('#nameC').val()=='' && $('#mailC').val()=='' && $('#telephoneC').val()=='' && $("#sedeC").val().length<=0){
		alerts.showNotification('top', 'right', 'Primero debes realizar una búsqueda', 'warning')
	}else{
		$('#idLotteC').val('');
		$('#nameC').val('');
		$('#mailC').val('');
		$('#telephoneC').val('');
		$('#idDragonC').val('');
		$("#sedeC").val('default');
		$("#sedeC").selectpicker("refresh");
		$('#fechasFiltroC').addClass('hide');
		$('#beginDateC').val('01/01/2022');
		$('#endDateC').val('12/31/2022');
		$('#clientes_btns').removeClass('col-md-12 col-lg-12');
		$('#clientes_btns').addClass('col-md-4 col-lg-4');
		$('#insideC').addClass('col-md-12 col-lg-12');
		$('#insideC').removeClass('col-md-offset-8 col-lg-offset-8 col-md-4 col-lg-4');
		// tabla_valores_cliente.clear();
		tabla_valores_cliente.clear().draw();
		tabla_valores_cliente.destroy();
	}


}