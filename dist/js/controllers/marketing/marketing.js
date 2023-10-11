let array_data = [];

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
	setIniDatesXMonth();
    $('.datepicker').datetimepicker({locale: 'es'});
    setIniDatesXMonth("#beginDate", "#endDate");
	setIniDatesXMonth("#beginDateC", "#endDateC");
});


/** BOTÓN BUSCAR TABLA PROSPECTOS  */
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
		$('#tabla_prospectos').removeClass('hide');
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
		alerts.showNotification('top', 'right', 'Ingresa al menos un parámetro de búsqueda', 'warning')
		$('#tabla_prospectos').addClass('hide');
	}
});

/** BOTÓN BUSCAR TABLA CLIENTES  */
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
		$('#tabla_clientes').removeClass('hide');
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
		alerts.showNotification('top', 'right', 'Ingresa al menos un parámetro de búsqueda', 'warning')
		$('#tabla_clientes').addClass('hide')
	}
});

/** TABLA PROSPECTOS  */
var tabla_valores_prospectos;
var titulos_encabezado_prospectos = [];
var num_colum_encabezado_prospectos = [];
$("#tabla_prospectos").ready(function () {
	$('#tabla_prospectos thead tr:eq(0) th').each(function (i) {
		var title = $(this).text();
		titulos_encabezado_prospectos.push(title);
        num_colum_encabezado_prospectos.push(i);
		$(this).html(`<input type="text"class="textoshead"data-toggle="tooltip_prospectos" data-placement="top"title="${title}"placeholder="${title}"/>`);
		$('input', this).on('keyup change', function () {
			if (tabla_valores_prospectos.column(i).search() !== this.value) {
				tabla_valores_prospectos.column(i).search(this.value).draw();
			}
		});
	});
});

function fillTable(data_search) {
	tabla_valores_prospectos = $("#tabla_prospectos").DataTable({
		dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
		buttons: [{
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

		}],
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
		bInfo: true,
		searching: true,
		ordering: false,
		fixedColumns: true,
		destroy: true,
		columns: [{
			data: function (d) {
				return d.nombre_prospecto 
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
					telefono = 'SIN TELÉFONO';
				}
				return telefono;
			}
		},
		{
			data: function (d) {
				let correo = '';
				if(d.correo == undefined || d.correo == '' || d.correo == null){
					correo = 'SIN CORREO';
				}else{
					correo = d.correo;
				}
				return correo;
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
				return lugar_prospeccion;
			}
		},
		{
			data: function (d) {
				let asesor;
				if(d.nombre_asesor=='' || d.nombre_asesor==undefined || d.nombre_asesor==null){
					asesor = 'SIN ASESOR';
				}else{
					asesor = d.nombre_asesor;
				}
				return asesor;
			}
		},
		{
			data: function (d) {
				let coordinador;
				if(d.nombre_coordinador == undefined || d.nombre_coordinador==null || d.nombre_coordinador==''){
					coordinador = 'SIN COORDINADOR';
				}else{
					coordinador = d.nombre_coordinador;
				}
				return coordinador;
			}
		},
		{
			data: function (d) {
				let gerente;
				if(d.nombre_gerente == undefined || d.nombre_gerente == null || d.nombre_gerente ==''){
					gerente = 'SIN GERENTE';
				}else{
					gerente = d.nombre_gerente;
				}
				return gerente;
			}
		},
		{
			data: function (d) {
				return  myFunctions.convertDateYMDHMS(d.fecha_creacion);
			}
		},
		{
			data: function (d) {
				return `<span class="label lbl-oceanGreen">${d.id_prospecto}</span>`;
			}
		},
		{
			data: function (d) {
				let validateData = d.id_dragon == 0 ? 'No disponible' : d.id_dragon;
				return `<span class="label lbl-azure">${validateData}</span>`;
			}
		},
		{
			data: function (d) {
				return `<span class="label lbl-yellow">${d.source}</span>`;
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
				return sede;
			}
		}],
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
		$(this).html(`<input 	type="text"style="${width}"class="textoshead"data-toggle="tooltip" data-placement="top"title="${title}"placeholder="${title}"${readOnly}/>`);
		$('input', this).on('keyup change', function () {
			if (tabla_valores_cliente.column(i).search() !== this.value) {
				tabla_valores_cliente.column(i).search(this.value).draw();
			}
		});
	});
});

var tabla_valores_cliente;
function fillTableClientes(data_search) {
	tabla_valores_cliente = $("#tabla_clientes").DataTable({
		dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
		buttons: [{
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
		}],
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
		bInfo: true,
		searching: true,
		ordering: false,
		fixedColumns: true,
		destroy: true,
		columns: [{
			data: function (d) {
				return d.idLote;
			}
		},
		{
			data: function (d) {
				return d.nombreProyecto.toUpperCase();
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
				let cliente ;
				if(d.nombreCliente==''||d.nombreCliente==undefined||d.nombreCliente==null){
					cliente = 'SIN CLIENTE';
				}else{
					cliente = d.nombreCliente;
				}
				return cliente;
			}
		},
		{
			data: function (d) {
				let numero_recibo;
				if(d.noRecibo == null)
					numero_recibo = '--';
				else
					numero_recibo = d.noRecibo;
				return numero_recibo 
			}
		},
		{
			data: function (d) {
				let referencia;
				if(d.referencia==undefined || d.referencia==null || d.referencia==''){
					referencia = 'SIN REFERENCIA';
				}else{
					referencia = d.referencia;
				}
				return referencia;
			}
		},
		{
			data: function (d) {
				return myFunctions.convertDateYMDHMS(d.fechaApartado);
			}
		},
		{
			data: function (d) {
				return formatMoney(d.engancheCliente);
			}
		},
		{
			data: function (d) {
				return myFunctions.convertDateYMDHMS(d.fechaEnganche);
			}
		},
		{
			data: function (d) {
				return myFunctions.convertDateYMDHMS(d.fechaCreacionProspecto); 
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
				return `<span class="label lbl-yellow">${d.source}</span>`;
			}
		},
		{
			data: function (d) {
				return `<span class="label lbl-violetBoots">${d.nombreStatusContratacion}</span>`;
			}
		},
		{
			data: function (d) {
				return `<button class="btn-data btn-blueMaderas cop" data-toggle="tooltip" data-placement="top"title="VENTAS COMPARTIDAS"data-idcliente="${d.id_cliente}"data-idLote="${d.idLote}">
							<i class="material-icons">people</i>
						</button>`;
			}
		}],
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

let titulos_encabezado_detalle = [];
let num_colum_encabezado_detalle = [];
$('#verDet thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos_encabezado_detalle.push(title);
	num_colum_encabezado_detalle.push(i);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $( 'input', this ).on('keyup change', function () {
        if ($('#verDet').DataTable().column(i).search() !== this.value ) {
            $('#verDet').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
})


$(document).ready(function () {
	tableHistorial = $('#verDet').DataTable({
		dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
		buttons:[{
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
		}],
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
		$('#inside').addClass('col-md-offset-8 col-lg-offset-8');
	}else{
		$('#fechasFiltro').addClass('hide');
		$('#inside').removeClass('col-md-offset-8 col-lg-offset-8');
	}
}

function changeSedeC(){
	let sedes = $('#sedeC').val();
	if(sedes.length>0){
		$('#fechasFiltroC').removeClass('hide');
		$('#insideC').addClass('col-md-offset-7 col-lg-offset-7');
		}else{
		$('#fechasFiltroC').addClass('hide');
		$('#insideC').removeClass('col-md-offset-7 col-lg-offset-7');
	}
}

function cleanFilters(){
	$('#tabla_prospectos').addClass('hide');
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
		$('#beginDate').val('');
		$('#endDate').val('');
		$('#inside').addClass('col-md-4 col-lg-4');
		$('#inside').removeClass('col-md-offset-8 col-lg-offset-8');
		tabla_valores_prospectos.clear().draw();
		tabla_valores_prospectos.destroy();
	}
}

function cleanFiltersC(){
	$('#tabla_clientes').addClass('hide');
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
		$('#beginDateC').val('');
		$('#endDateC').val('');
		$('#insideC').addClass('col-md-5 col-lg-5');
		$('#insideC').removeClass('col-md-offset-7 col-lg-offset-7');
		tabla_valores_cliente.clear().draw();
		tabla_valores_cliente.destroy();
	}
}