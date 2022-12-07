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
});


$('#searchButton').click(()=>{

	let name = $('#name').val();
	let mail = $('#mail').val();
	let telephone = $('#telephone').val();
	let sede = $('#sede').val();

	name = (name!='') ? name : '';
	mail = (mail!='') ? mail : '';
	telephone = (telephone!='') ? telephone : '';
	sede = (sede!='') ? sede.toString() : '';

	// console.log('sedeII:', Object.assign({}, sede));
	// var data = new FormData();
	// data.append("idLote", idLote);
	// data.append("name", name);
	// data.append("mail", mail);
	// data.append("telephone", telephone);
	// data.append("sede", sede);

	if(name!='' || mail!='' || telephone!='' || sede!=''){
		let array_data = [];
		array_data['name'] = name;
		array_data['mail'] = mail;
		array_data['telephone'] = telephone;
		array_data['sede'] = sede;
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

	console.log('sedeII:', JSON.stringify(sede));

	idLote = (idLote!='') ? idLote : '';
	name = (name!='') ? name : '';
	mail = (mail!='') ? mail : '';
	telephone = (telephone!='') ? telephone : '';
	sede = (sede!='') ? sede.toString() : '';

	// console.log('sedeII:', Object.assign({}, sede));
	// var data = new FormData();
	// data.append("idLote", idLote);
	// data.append("name", name);
	// data.append("mail", mail);
	// data.append("telephone", telephone);
	// data.append("sede", sede);

	if(idLote!='' || name!='' || mail!='' || telephone!='' || sede!=''){
		let array_data = [];
		array_data['idLote'] = idLote;
		array_data['name'] = name;
		array_data['mail'] = mail;
		array_data['telephone'] = telephone;
		array_data['sede'] = sede;
		fillTableClientes(array_data);
	}else{
		alerts.showNotification('top', 'right', 'Ingresa al menos un parámetro de busqueda', 'warning')
	}


	// $.ajax({
	//     type: 'POST',
	//    url: '<?//=base_url()?>//index.php/Clientes/searchData',
	//     data: data,
	//     contentType: false,
	//     cache: false,
	//     processData: false,
	//     dataType: "json",
	//     beforeSend: function () {
	//
	//     },
	//     success: function (data) {
	//         if (data == 1) {
	//             $('#preguntaDeleteMktd').modal("hide");
	//             $('#checkEvidencia').DataTable().ajax.reload();
	//             $('#sol_aut').DataTable().ajax.reload();
	//             alerts.showNotification('top', 'right', 'Se ha eliminado MKTD de esta venta de manera exitosa.', 'success');
	//         } else {
	//             alerts.showNotification('top', 'right', 'Oops, algo salió mal, inténtalo de nuevo.', 'danger');
	//         }
	//     },
	//     error: function () {
	//         alerts.showNotification('top', 'right', 'Oops, algo salió mal, inténtalo de nuevo.', 'danger');
	//     }
	// });


});


function fillTable(data_search) {
	// var data = new FormData();
	// data.append("idLote", data_search['idLote']);
	// data.append("name", data_search['name']);
	// data.append("mail", data_search['mail']);
	// data.append("telephone", data_search['telephone']);
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
					columns: [0,1, 2, 3, 4, 5, 6, 7, 8, 9],
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
									return 'ID DRAGON';
									break;
								case 9:
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
			// {
			//     "width": "3%",
			//     "className": 'details-control',
			//     "orderable": false,
			//     "data" : null,
			//     "defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
			// },


			{
				"width": "5%",
				"data": function (d) {
					return '<p class="m-0">' + d.nombre_prospecto + '</p>';
				}
			},
			{
				"width": "10%",
				"data": function (d) {
					let tel1 = d.telefono;
					let tel2 = d.telefono_2;
					let telefono;
					if(tel1==null){
						telefono = tel2;
					}else if(tel2==null){
						telefono = tel1;
					}else if(tel1==null || tel2==null){
						telefono = '--'
					}
					return '<p class="m-0">' + telefono + '</p>';
				}
			},

			{
				"width": "12%",
				"data": function (d) {
					return '<p class="m-0">' + d.correo + '</p>';
				}
			},
			{
				"width": "10%",
				"data": function (d) {
					return '<p class="m-0">'+ d.lugar_prospeccion + '</p>';
				}
			},
			{
				"width": "10%",
				"data": function (d) {
					return '<p class="m-0">' + d.nombre_asesor + '</p>';
				}
			},
			{
				"width": "10%",
				"data": function (d) {
					return '<p class="m-0">' + d.nombre_coordinador + '</p>';
				}
			},

			{
				"width": "10%",
				"data": function (d) {
					return '<p class="m-0">' + d.nombre_gerente+ '</p>';
				}
			},

			{
				"width": "8%",
				"data": function (d) {
					//myFunctions.convertDateYMDHMS(d.fechaEnganche)
					return '<p class="m-0">' +  myFunctions.convertDateYMDHMS(d.fecha_creacion)  + '</p>';
				}
			},

			{
				"width": "10%",
				"data": function (d) {
					let id_dragon = d.id_dragon;
					let validateData;
					if(id_dragon==0){
						validateData = 'No disponible';
					}
					return '<p class="m-0">' + validateData + '</p>';
				}
			},

			{
				"width": "8%",
				"data": function (d) {

					return '<p class="m-0">' +   d.sede_nombre  + '</p>';
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
				"idLote": '',
				"name" :  data_search['name'],
				"mail" :  data_search['mail'],
				"telephone":data_search['telephone'],
				"sede" : data_search['sede'],
				"TB": 2
			},
			cache: false
		},
		"order": [[1, 'asc']]
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
		// if (i != 0 && i != 13) {
			var title = $(this).text();

			titulos.push(title);
		// }
	});
});

function fillTableClientes(data_search) {
	// var data = new FormData();
	// data.append("idLote", data_search['idLote']);
	// data.append("name", data_search['name']);
	// data.append("mail", data_search['mail']);
	// data.append("telephone", data_search['telephone']);
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
					columns: [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
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
									return 'ID DRAGON';
									break;
								case 12:
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
			// {
			//     "width": "3%",
			//     "className": 'details-control',
			//     "orderable": false,
			//     "data" : null,
			//     "defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
			// },


			{
				"data": function (d) {
					return '<p class="m-0">' + d.idLote + '</p>';
				}
			},
			{
				"data": function (d) {
					return '<p class="m-0">' + d.nombreProyecto + '</p>';
				}
			},

			{
				"data": function (d) {
					return '<p class="m-0">' + d.nombreCondominio + '</p>';
				}
			},

			{
				"data": function (d) {
					return '<p class="m-0">' + d.nombreLote + '</p>';
				}
			},

			{
				"data": function (d) {
					return '<p class="m-0">'+ d.nombreCliente + '</p>';
				}
			},

			{
				"data": function (d) {
					let numero_recibo;
					if(d.noRecibo == null)
						numero_recibo = '--';
					else
						numero_recibo = d.noRecibo;
					return '<p class="m-0">' + numero_recibo + '</p>';
				}
			},

			{
				"data": function (d) {
					return '<p class="m-0">' + d.referencia + '</p>';
				}
			},

			{
				"data": function (d) {
					return '<p class="m-0">' + myFunctions.convertDateYMDHMS(d.fechaApartado)+ '</p>';
				}
			},

			{
				"data": function (d) {
					return '<p class="m-0">$' + myFunctions.number_format(d.engancheCliente, 2, '.', ',') + '</p>';
				}
			},

			{
				"data": function (d) {
					return '<p class="m-0">' + myFunctions.convertDateYMDHMS(d.fechaEnganche) + '</p>';
				}
			},

			{

				"data": function (d) {

					return '<p class="m-0">' +   myFunctions.convertDateYMDHMS(d.fechaCreacionProspecto)  + '</p>';
				}
			},
			{
				"width": "10%",
				"data": function (d) {
					let id_dragon = d.id_dragon;
					let validateData;
					if(id_dragon==0){
						validateData = 'No disponible';
					}
					return '<p class="m-0">' + validateData + '</p>';
				}
			},
			{

				"data": function (d) {
					let backgrColor = '';
					switch (d.idStatusContratacion) {
						case 1:
							backgrColor = "#103F75";
							break;
						case 2:
							backgrColor = "#765FA4";
							break;
						case 5:
							backgrColor = "#D17FC5";
							break;
						case 6:
							backgrColor = "#006A9D";
							break;
						case 7:
							backgrColor = "#0095A9";
							break;
						case 8:
							backgrColor = "#00723F";
							break;
						case 9 :
							backgrColor = "#85DF7F";
							break;
						case 10 :
							backgrColor = "#D7A31A";
							break;
						case 11 :
							backgrColor = "#414656";
							break;
						case 13 :
							backgrColor = "#877555";
							break;
						case 14 :
							backgrColor = "#A75565";
							break;
						case 15 :
							backgrColor = "#00C6BD";
							break;
						default:
							//Declaraciones ejecutadas cuando ninguno de los valores coincide con el valor de la expresión
							break;
					}
					let lblStatusContratacion = '<label class="label label-info" style="color: white;font-size: 0.8em;background-color:'+backgrColor+'">' + d.nombreStatusContratacion + '</label>';
					return '<p class="m-0">' + lblStatusContratacion + '</p>';
				}
			}
			,
			{

				"data": function (d) {
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
			url: url2+'Clientes/searchData',
			data: {
				"idLote": data_search['idLote'],
				"name" :  data_search['name'],
				"mail" :  data_search['mail'],
				"telephone":data_search['telephone'],
				"sede" : data_search['sede'],
				"TB": 1
			},
			cache: false
		},
		"order": [[1, 'asc']]
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
		if ( i != 13) {
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
	// tableHistorial.ajax.reload();


	tableHistorial = $('#verDet').DataTable({
		responsive: true,
		"autoWidth": 'true',
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
		"scrollX": true,
		"pageLength": 10,
		language: {
			url: "<?=base_url()?>/static/spanishLoader_v2.json",
			paginate: {
				previous: "<i class='fa fa-angle-left'>",
				next: "<i class='fa fa-angle-right'>"
			}
		},
		columns: [
			{"data": "nombreGerente"},
			{"data": "nombreCoordinador"},
			{"data": "nombreAsesor"}
		],
		"processing": true,
		"destroy": true,
		"bAutoWidth": false,
		"bLengthChange": false,
		"bInfo": true,
		"ordering": false,
		"fixedColumns": true,
		"ajax": {
			"url": url2+"registroCliente/getcop/",
			"type": "POST",
			cache: false,
			"data": function (d) {
				d.id_cliente = id_cliente_global;
			}
		},
	});
	$('#verDetalles').modal('show');
});


