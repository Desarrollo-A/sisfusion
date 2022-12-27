$(document).ready(function () {
	$.post(url + "Contraloria/get_sede", function (data) {
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

	console.log('sedeII:', JSON.stringify(sede));

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


function fillTable(data_search) {
	tabla_valores_cliente = $("#tabla_prospectos").DataTable({
		width: 'auto',
		dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
				className: 'btn buttons-excel',
				titleAttr: 'Registro de clientes',
				title:'Lista de prospectos',
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
					format: {
						header: function (d, columnIdx) {
							switch (columnIdx) {
								case 0:
									return 'NOMBRE';
									break;
								case 1:
									return 'TELÉFONO';
									break;
								case 2:
									return 'CORREO';
									break;
								case 3:
									return 'LUGAR PROSPECCIÓN';
									break;
								case 4:
									return 'ASESOR';
									break;
								case 5:
									return 'COORDINADOR';
									break;
								case 6:
									return 'GERENTE';
									break;
								case 7:
									return 'FECHA CREACIÓN';
									break;
								case 8:
									return 'ID CRM';
									break;
								case 9:
									return 'ID DRAGON';
									break;
								case 10:
									return 'SEDE';
									break;
							}
						}
					}
				},

			}
		],
		pagingType: "full_numbers",
		language: {
			url: url+"static/spanishLoader_v2.json",
			paginate: {
				previous: "<i class='fa fa-angle-left'>",
				next: "<i class='fa fa-angle-right'>"
			}
		},
		processing: true,
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
			url: url2+'Clientes/searchData',
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
		order: [[1, 'asc']]
	});

	$('#tabla_prospectos tbody').on('click', 'td.details-control', function () {
		var tr = $(this).closest('tr');
		var row = tabla_valores_cliente.row(tr);

		if ( row.child.isShown() ) {
			row.child.hide();
			tr.removeClass('shown');
			$(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
		}
		else {



			var informacion_adicional2 = '<table class="table text-justify">' +
				'<tr>INFORMACIÓN: <b>' + row.data().nombre + ' ' + row.data().apellido_paterno + ' ' + row.data().apellido_materno + '</b>' +
				'<td style="font-size: .8em"><strong>CORREO: </strong>' + myFunctions.validateEmptyField(row.data().correo) + '</td>' +
				'<td style="font-size: .8em"><strong>TELEFONO: </strong>' + myFunctions.validateEmptyField(row.data().telefono1) + '</td>' +
				'<td style="font-size: .8em"><strong>RFC: </strong>' + myFunctions.validateEmptyField(row.data().rfc) + '</td>' +
				'<td style="font-size: .8em"><b>FECHA +45:</b> ' + myFunctions.validateEmptyField(row.data().fechaVecimiento) + '</td>' +
				'<td style="font-size: .8em"><strong>FECHA NACIMIENTO: </strong>' + myFunctions.validateEmptyField(row.data().fechaNacimiento) + '</td>' +
				'</tr>' +
				'<tr>' +
				'<td style="font-size: .8em"><b>DOMICILIO PARTICULAR:</b> ' + myFunctions.validateEmptyField(row.data().domicilio_particular) + '</td>' +
				'<td style="font-size: .8em"><b>ENTERADO:</b> ' + myFunctions.validateEmptyField(row.data().enterado) + '</td>' +
				'</tr>' +
				'<tr>' +
				'<td style="font-size: .8em"><b>GERENTE TITULAR:</b> ' + myFunctions.validateEmptyField(row.data().gerente) + '</td>' +
				'<td style="font-size: .8em"><b>ASESOR TITULAR:</b> ' + myFunctions.validateEmptyField(row.data().asesor) + '</td>' +
				'</tr>' +
				'</table>';
			var informacion_adicional = '<div class="container subBoxDetail">';
			informacion_adicional += '       <div class="row">';
			informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">';
			informacion_adicional += '               <label><b>'+row.data().nombre+' '+row.data().apellido_paterno+' '+row.data().apellido_materno+'</b></label>';
			informacion_adicional += '           </div>';
			informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
			informacion_adicional += '               <label><b>Correo: </b>'+myFunctions.validateEmptyField(row.data().correo)+'</label>';
			informacion_adicional += '           </div>';
			informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
			informacion_adicional += '               <label><b>Teléfono: </b>'+myFunctions.validateEmptyField(row.data().telefono1)+'</label>';
			informacion_adicional += '           </div>';
			informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
			informacion_adicional += '               <label><b>RFC: </b>'+myFunctions.validateEmptyField(row.data().rfc)+'</label>';
			informacion_adicional += '           </div>';
			informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
			informacion_adicional += '               <label><b>Fecha +45: </b>'+myFunctions.validateEmptyField(row.data().fechaVecimiento)+'</label>';
			informacion_adicional += '           </div>';
			informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
			informacion_adicional += '               <label><b>Fecha nacimiento: </b>'+myFunctions.validateEmptyField(row.data().fechaNacimiento)+'</label>';
			informacion_adicional += '           </div>';
			informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
			informacion_adicional += '               <label><b>Domicilio Particular: </b>'+myFunctions.validateEmptyField(row.data().domicilio_particular)+'</label>';
			informacion_adicional += '           </div>';
			informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
			informacion_adicional += '               <label><b>Enterado: </b>'+myFunctions.validateEmptyField(row.data().enterado)+'</label>';
			informacion_adicional += '           </div>';
			informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
			informacion_adicional += '               <label><b>Gerente: </b>'+myFunctions.validateEmptyField(row.data().gerente) +'</label>';
			informacion_adicional += '           </div>';
			informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
			informacion_adicional += '               <label><b>Asesor Titular: </b>'+myFunctions.validateEmptyField(row.data().asesor)+'</label>';
			informacion_adicional += '           </div>';
			informacion_adicional += '       </div>';
			informacion_adicional += '    </div>';


			row.child(informacion_adicional).show();
			tr.addClass('shown');
			$(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
		}
	});
}

$("#tabla_prospectos").ready(function () {
	$('#tabla_prospectos thead tr:eq(0) th').each(function (i) {
		// if (i != 0 && i != 11) {
			var title = $(this).text();
			$(this).html('<input class="textoshead" placeholder="' + title + '"/>');
			$('input', this).on('keyup change', function () {
				if (tabla_valores_cliente.column(i).search() !== this.value) {
					tabla_valores_cliente
						.column(i)
						.search(this.value)
						.draw();
				}
			});
		// }
	});

	let titulos = [];
	$('#tabla_prospectos thead tr:eq(0) th').each(function (i) {
		// if (i != 0 && i != 14) {
			var title = $(this).text();

			titulos.push(title);
		// }
	});
});

function fillTableClientes(data_search) {
	console.log("sede fillTable", data_search['sede']);

	console.log('data_search:', data_search);
	tabla_valores_cliente = $("#tabla_clientes").DataTable({
		width: 'auto',
		dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
				className: 'btn buttons-excel',
				titleAttr: 'Registro de clientes',
				title:'Registro de clientes',
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
				},

			}
		],
		pagingType: "full_numbers",
		language: {
			url: url+"static/spanishLoader_v2.json",
			paginate: {
				previous: "<i class='fa fa-angle-left'>",
				next: "<i class='fa fa-angle-right'>"
			}
		},
		processing: true,
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
			defaultContent: "",
			targets: "_all",
			searchable: true,
			orderable: false
		}],
		ajax: {
			type: 'POST',
			url: url2 + 'Clientes/searchData',
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
		order: [[1, 'asc']]
	});

	$('#tabla_clientes tbody').on('click', 'td.details-control', function () {
		var tr = $(this).closest('tr');
		var row = tabla_valores_cliente.row(tr);

		if ( row.child.isShown() ) {
			row.child.hide();
			tr.removeClass('shown');
			$(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
		}
		else {



			var informacion_adicional2 = '<table class="table text-justify">' +
				'<tr>INFORMACIÓN: <b>' + row.data().nombre + ' ' + row.data().apellido_paterno + ' ' + row.data().apellido_materno + '</b>' +
				'<td style="font-size: .8em"><strong>CORREO: </strong>' + myFunctions.validateEmptyField(row.data().correo) + '</td>' +
				'<td style="font-size: .8em"><strong>TELEFONO: </strong>' + myFunctions.validateEmptyField(row.data().telefono1) + '</td>' +
				'<td style="font-size: .8em"><strong>RFC: </strong>' + myFunctions.validateEmptyField(row.data().rfc) + '</td>' +
				'<td style="font-size: .8em"><b>FECHA +45:</b> ' + myFunctions.validateEmptyField(row.data().fechaVecimiento) + '</td>' +
				'<td style="font-size: .8em"><strong>FECHA NACIMIENTO: </strong>' + myFunctions.validateEmptyField(row.data().fechaNacimiento) + '</td>' +
				'</tr>' +
				'<tr>' +
				'<td style="font-size: .8em"><b>DOMICILIO PARTICULAR:</b> ' + myFunctions.validateEmptyField(row.data().domicilio_particular) + '</td>' +
				'<td style="font-size: .8em"><b>ENTERADO:</b> ' + myFunctions.validateEmptyField(row.data().enterado) + '</td>' +
				'</tr>' +
				'<tr>' +
				'<td style="font-size: .8em"><b>GERENTE TITULAR:</b> ' + myFunctions.validateEmptyField(row.data().gerente) + '</td>' +
				'<td style="font-size: .8em"><b>ASESOR TITULAR:</b> ' + myFunctions.validateEmptyField(row.data().asesor) + '</td>' +
				'</tr>' +
				'</table>';
			var informacion_adicional = '<div class="container subBoxDetail">';
			informacion_adicional += '       <div class="row">';
			informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">';
			informacion_adicional += '               <label><b>'+row.data().nombre+' '+row.data().apellido_paterno+' '+row.data().apellido_materno+'</b></label>';
			informacion_adicional += '           </div>';
			informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
			informacion_adicional += '               <label><b>Correo: </b>'+myFunctions.validateEmptyField(row.data().correo)+'</label>';
			informacion_adicional += '           </div>';
			informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
			informacion_adicional += '               <label><b>Teléfono: </b>'+myFunctions.validateEmptyField(row.data().telefono1)+'</label>';
			informacion_adicional += '           </div>';
			informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
			informacion_adicional += '               <label><b>RFC: </b>'+myFunctions.validateEmptyField(row.data().rfc)+'</label>';
			informacion_adicional += '           </div>';
			informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
			informacion_adicional += '               <label><b>Fecha +45: </b>'+myFunctions.validateEmptyField(row.data().fechaVecimiento)+'</label>';
			informacion_adicional += '           </div>';
			informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
			informacion_adicional += '               <label><b>Fecha nacimiento: </b>'+myFunctions.validateEmptyField(row.data().fechaNacimiento)+'</label>';
			informacion_adicional += '           </div>';
			informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
			informacion_adicional += '               <label><b>Domicilio Particular: </b>'+myFunctions.validateEmptyField(row.data().domicilio_particular)+'</label>';
			informacion_adicional += '           </div>';
			informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
			informacion_adicional += '               <label><b>Enterado: </b>'+myFunctions.validateEmptyField(row.data().enterado)+'</label>';
			informacion_adicional += '           </div>';
			informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
			informacion_adicional += '               <label><b>Gerente: </b>'+myFunctions.validateEmptyField(row.data().gerente) +'</label>';
			informacion_adicional += '           </div>';
			informacion_adicional += '           <div class="col-12 col-sm-12 col-sm-12 col-lg-12">';
			informacion_adicional += '               <label><b>Asesor Titular: </b>'+myFunctions.validateEmptyField(row.data().asesor)+'</label>';
			informacion_adicional += '           </div>';
			informacion_adicional += '       </div>';
			informacion_adicional += '    </div>';


			row.child(informacion_adicional).show();
			tr.addClass('shown');
			$(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
		}
	});
}
$("#tabla_clientes").ready(function () {
	$('#tabla_clientes thead tr:eq(0) th').each(function (i) {
		if ( i != 14) {
			var title = $(this).text();
			$(this).html('<input class="textoshead" placeholder="' + title + '"/>');
			$('input', this).on('keyup change', function () {
				if (tabla_valores_cliente.column(i).search() !== this.value) {
					tabla_valores_cliente
						.column(i)
						.search(this.value)
						.draw();
				}
			});
		}
	});

	let titulos = [];
	$('#tabla_clientes thead tr:eq(0) th').each(function (i) {
		if ( i != 13) {
			var title = $(this).text();

			titulos.push(title);
		}
	});
});



var id_cliente_global = 0;

$(document).on('click', '.cop', function (e) {
	e.preventDefault();
	var $itself = $(this);
	var id_cliente = $itself.attr('data-idcliente');
	id_cliente_global = id_cliente;
	tableHistorial = $('#verDet').DataTable({
		responsive: true,
		autoWidth: 'true',
		dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
				className: 'btn buttons-excel',
				titleAttr: 'Reporte ventas compartidas',
				title:'Reporte ventas compartidas',
			}
		],
		scrollX: true,
		pageLength: 10,
		language: {
			url: url+"static/spanishLoader_v2.json",
			paginate: {
				previous: "<i class='fa fa-angle-left'>",
				next: "<i class='fa fa-angle-right'>"
			}
		},
		columns: [
			{data: "nombreGerente"},
			{data: "nombreCoordinador"},
			{data: "nombreAsesor"}
		],
		processing: true,
		destroy: true,
		bAutoWidth: false,
		bLengthChange: false,
		bInfo: true,
		ordering: false,
		fixedColumns: true,
		ajax: {
			url: url2+"registroCliente/getcop/",
			type: "POST",
			cache: false,
			data: function (d) {
				d.id_cliente = id_cliente_global;
			}
		},
	});

	$('#verDetalles').modal('show');
});

function changeSede(){
	let sedes = $('#sede').val();
	if(sedes.length>0){
		$('#fechasFiltro').removeClass('hide');
	}else{
		$('#fechasFiltro').addClass('hide');
	}
}
function changeSedeC(){
	let sedes = $('#sedeC').val();
	if(sedes.length>0){
		$('#fechasFiltroC').removeClass('hide');
	}else{
		$('#fechasFiltroC').addClass('hide');
	}
}