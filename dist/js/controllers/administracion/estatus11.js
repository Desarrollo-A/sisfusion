var getInfo1 = new Array(7);
var getInfo3 = new Array(6);

var estatusPermitidosEstatus11 = ["7", "8", "10", "12"];
var movimientosPermitidosEstatus11 = ["40", "67", "72", "37", "7", "64", "77", "38", "65"];

let titulos = [];
$("#tabla_ingresar_11").ready(function () {
	$('#tabla_ingresar_11 thead tr:eq(0) th').each(function (i) {
		var title = $(this).text();
		titulos.push(title);
		$(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
		$('input', this).on('keyup change', function () {
			if (tabla_9.column(i).search() !== this.value)
				tabla_9.column(i).search(this.value).draw();
		});
	});

	tabla_9 = $("#tabla_ingresar_11").DataTable({
		dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
		width: '100%',
		scrollX: true,
		bAutoWidth: true,
		buttons: [{
			extend: 'excelHtml5',
			text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
			className: 'btn buttons-excel',
			titleAttr: 'Descargar archivo de Excel',
			title: 'REGISTRO ESTATUS 11',
			exportOptions: {
				columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
				format: {
					header: function (d, columnIdx) {
						if (columnIdx == 0)
                            return ' ' + d + ' ';
                        return ' ' + titulos[columnIdx] + ' ';
					}
				}
			}
		}],
		pagingType: "full_numbers",
		fixedHeader: true,
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
				className: 'details-control',
				orderable: false,
				data: null,
				defaultContent:  '<center><div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i></div></center>'
			},
			{
				data: function (d) {
					return `<span class="label lbl-green">${d.tipo_venta}</span>`;
				}
			},
			{ data: 'nombreResidencial' },
			{ data: 'nombreCondominio' },
			{ data: 'nombreLote' },
			{ data: 'gerente' },
			{ data: 'nombreCliente' },
			{
				data: function (d) {
					return formatMoney(d.totalNeto);
				}
			},
			{ data: 'modificado' },
			{
				data: function (d) {
					var fechaVenc;
					if (estatusPermitidosEstatus11.includes(d.idStatusContratacion) && movimientosPermitidosEstatus11.includes(d.idMovimiento))
						fechaVenc = d.fechaVenc2;
					else
						fechaVenc = 'N/A';
					return fechaVenc;
				}
			},
			{
				"data": function (d) {
					var dateFuture = new Date(d.fechaVenc2);
					var dateNow = new Date();
					var seconds = Math.floor((dateFuture - (dateNow)) / 1000);
					var minutes = Math.floor(seconds / 60);
					var hours = Math.floor(minutes / 60);
					var days = Math.floor(hours / 24);
					hours = hours - (days * 24);
					minutes = minutes - (days * 24 * 60) - (hours * 60);
					seconds = seconds - (days * 24 * 60 * 60) - (hours * 60 * 60) - (minutes * 60);
					if (d.fechaVenc2 == 'N/A')
						return '<p class="m-0">N/A</p>';
					else {
						var dateFuture = new Date(d.fechaVenc2);
						var dateNow = new Date();
						var seconds = Math.floor((dateFuture - (dateNow)) / 1000);
						var minutes = Math.floor(seconds / 60);
						var hours = Math.floor(minutes / 60);
						var days = Math.floor(hours / 24);
						hours = hours - (days * 24);
						minutes = minutes - (days * 24 * 60) - (hours * 60);
						seconds = seconds - (days * 24 * 60 * 60) - (hours * 60 * 60) - (minutes * 60);
						if (days < 0)
							return 'Vencido';
						else
							return `<p style="font-size: .9em">Vence en: ${days} día(s), ${hours} hora(s), ${minutes} minuto(s)</p>`;
					}
				}
			},
			{ data: 'descripcion' },
			{
				data: function (d) {
					return `<span class="label lbl-azure">${d.nombreSede}</span>`;
				}
			},
			{
				data: function (d) {
					var cntActions;
					if (d.vl == '1')
						cntActions = 'En proceso de Liberación';
					else {
						if (estatusPermitidosEstatus11.includes(d.idStatusContratacion) && movimientosPermitidosEstatus11.includes(d.idMovimiento)) {
							cntActions = `<button href="#" data-idLote="${d.idLote}" data-nomLote="${d.nombreLote}" data-idCond="${d.idCondominio}"
								data-idCliente="${d.id_cliente}" data-fecVen="${d.fechaVenc}" data-ubic="${d.ubicacion}" data-tot="${d.totalNeto}"
								class="btn-data btn-green editReg" data-toggle="tooltip" data-placement="top" title="Registrar estatus">
								<i class="far fa-thumbs-up"></i></button>`;
							cntActions += `<button href="#" data-idLote="${d.idLote}" data-nomLote="${d.nombreLote}" data-idCond="${d.idCondominio}"
								data-idCliente="${d.id_cliente}" data-fecVen="${d.fechaVenc}" data-ubic="${d.ubicacion}"
								class="btn-data btn-warning cancelReg" data-toggle="tooltip" data-placement="top" title="Rechazo/regreso estatus (Jurídico)">
								<i class="far fa-thumbs-down"></i></button>`;
						}
						else
							cntActions = 'N/A';
					}
					return `<div class="d-flex justify-center">${cntActions}</div>`;
				}
			}],
		columnDefs: [{
			searchable: false,
			orderable: false,
			targets: 0
		}],
		ajax: {
			url: `${general_base_url}Administracion/datos_estatus_11_datos`,
			dataSrc: "",
			type: "POST",
			cache: false,
			data: function (d) {
			}
		},
	});

	$('#tabla_ingresar_11').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

	$('#tabla_ingresar_11 tbody').on('click', 'td.details-control', function () {
		var tr = $(this).closest('tr');
		var row = tabla_9.row(tr);
		if (row.child.isShown()) {
			row.child.hide();
			tr.removeClass('shown');
			$(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
		}
		else {
			var status;
			var fechaVenc;
			status = row.data().descripcion;
			var informacion_adicional = '<div class="container subBoxDetail"><div class="row"><div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>Información colaboradores</b></label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Estatus: </b>' + status + '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Comentario: </b>' + row.data().comentario + '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Coordinador: </b>' + row.data().coordinador + '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Asesor: </b>' + row.data().asesor + '</label></div></div></div>';
			row.child(informacion_adicional).show();
			tr.addClass('shown');
			$(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
		}
	});

	$("#tabla_ingresar_11 tbody").on("click", ".editReg", function (e) {
		e.preventDefault();
		getInfo1[0] = $(this).attr("data-idCliente");
		getInfo1[1] = $(this).attr("data-nombreResidencial");
		getInfo1[2] = $(this).attr("data-nombreCondominio");
		getInfo1[3] = $(this).attr("data-idcond");
		getInfo1[4] = $(this).attr("data-nomlote");
		getInfo1[5] = $(this).attr("data-idLote");
		getInfo1[6] = $(this).attr("data-fecven");
		getInfo1[7] = $(this).attr("data-tot");
		nombreLote = $(this).data("nomlote");
		$(".lote").html(nombreLote);
		let val = getInfo1[7];
		if (val == '.00' || val == 'null')
			val = 0;
		document.getElementById("totalNeto").value = val;
		$('#totalNeto').click();
		$('#editReg').modal('show');
	});

	$("#tabla_ingresar_11 tbody").on("click", ".cancelReg", function (e) {
		$("#comentario3").val('').selectpicker('refresh');
		$("#observaciones").val('');
		e.preventDefault();
		getInfo3[0] = $(this).attr("data-idCliente");
		getInfo3[1] = $(this).attr("data-nombreResidencial");
		getInfo3[2] = $(this).attr("data-nombreCondominio");
		getInfo3[3] = $(this).attr("data-idcond");
		getInfo3[4] = $(this).attr("data-nomlote");
		getInfo3[5] = $(this).attr("data-idLote");
		getInfo3[6] = $(this).attr("data-fecven");
		getInfo3[7] = $(this).attr("data-code");
		nombreLote = $(this).data("nomlote");
		$(".lote").html(nombreLote);
		$('#rechReg').modal('show');
	});
});

$(document).on('click', '#save1', function (e) {
	e.preventDefault();
	var comentario = $("#comentario").val();
	var totalValidado = $("#totalValidado").val();
	var validaComent = ($("#comentario").val().length == 0) ? 0 : 1;
	var totalValidado_v = ($("#totalValidado").val().length == 0) ? 0 : 1;
	var dataExp1 = new FormData();
	dataExp1.append("idCliente", getInfo1[0]);
	dataExp1.append("nombreResidencial", getInfo1[1]);
	dataExp1.append("nombreCondominio", getInfo1[2]);
	dataExp1.append("idCondominio", getInfo1[3]);
	dataExp1.append("nombreLote", getInfo1[4]);
	dataExp1.append("idLote", getInfo1[5]);
	dataExp1.append("comentario", comentario);
	dataExp1.append("fechaVenc", getInfo1[6]);
	dataExp1.append("totalValidado", totalValidado);
	if (validaComent == 0 || totalValidado_v == 0)
		alerts.showNotification("top", "right", "Todos los campos son obligatorios.", "danger");
	if (validaComent == 1 && totalValidado_v == 1) {
		$('#save1').prop('disabled', true);
		$.ajax({
			url: `${general_base_url}Administracion/editar_registro_lote_administracion_proceceso11/`,
			data: dataExp1,
			cache: false,
			contentType: false,
			processData: false,
			type: 'POST',
			success: function (data) {
				response = JSON.parse(data);
				if (response.message == 'OK') {
					$('#save1').prop('disabled', false);
					$('#editReg').modal('hide');
					$('#tabla_ingresar_11').DataTable().ajax.reload();
					alerts.showNotification("top", "right", "Estatus enviado.", "success");
				} else if (response.message == 'FALSE') {
					$('#save1').prop('disabled', false);
					$('#editReg').modal('hide');
					$('#tabla_ingresar_11').DataTable().ajax.reload();
					alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
				} else if (response.message == 'ERROR') {
					$('#save1').prop('disabled', false);
					$('#editReg').modal('hide');
					$('#tabla_ingresar_11').DataTable().ajax.reload();
					alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
				}
			},
			error: function (data) {
				$('#save1').prop('disabled', false);
				$('#editReg').modal('hide');
				$('#tabla_ingresar_11').DataTable().ajax.reload();
				alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
			}
		});
	}
});

$(document).on('click', '#save3', function (e) {
	e.preventDefault();
	var comentario = $("#comentario3").val();
	var observaciones = $("#observaciones").val();
	var validaComent = ($("#comentario3").val() == '') ? 0 : 1;
	var dataExp3 = new FormData();
	dataExp3.append("idCliente", getInfo3[0]);
	dataExp3.append("nombreResidencial", getInfo3[1]);
	dataExp3.append("nombreCondominio", getInfo3[2]);
	dataExp3.append("idCondominio", getInfo3[3]);
	dataExp3.append("nombreLote", getInfo3[4]);
	dataExp3.append("idLote", getInfo3[5]);
	dataExp3.append("comentario", comentario);
	dataExp3.append("observaciones", observaciones);
	dataExp3.append("fechaVenc", getInfo3[6]);
	if (validaComent == 0)
		alerts.showNotification("top", "right", "Debes seleccionar un motivo de rechazo para continuar con esta acción.", "danger");

	if (validaComent == 1) {
		$('#save3').prop('disabled', true);
		$.ajax({
			url: `${general_base_url}/Administracion/editar_registro_loteRechazo_administracion_proceceso11/`,
			data: dataExp3,
			cache: false,
			contentType: false,
			processData: false,
			type: 'POST',
			success: function (data) {
				response = JSON.parse(data);
				if (response.message == 'OK') {
					$('#save3').prop('disabled', false);
					$('#rechReg').modal('hide');
					$('#tabla_ingresar_11').DataTable().ajax.reload();
					alerts.showNotification("top", "right", "Estatus enviado.", "success");
				} else if (response.message == 'FALSE') {
					$('#save3').prop('disabled', false);
					$('#rechReg').modal('hide');
					$('#tabla_ingresar_11').DataTable().ajax.reload();
					alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
				} else if (response.message == 'ERROR') {
					$('#save3').prop('disabled', false);
					$('#rechReg').modal('hide');
					$('#tabla_ingresar_11').DataTable().ajax.reload();
					alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
				}
			},
			error: function (data) {
				$('#save3').prop('disabled', false);
				$('#rechReg').modal('hide');
				$('#tabla_ingresar_11').DataTable().ajax.reload();
				alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
			}
		});
	}
});


jQuery(document).ready(function () {
	jQuery('#editReg').on('hidden.bs.modal', function (e) {
		jQuery(this).removeData('bs.modal');
		jQuery(this).find('#comentario').val('');
		jQuery(this).find('#totalNeto').val('');
		jQuery(this).find('#totalValidado').val('');
	});

	jQuery('#rechReg').on('hidden.bs.modal', function (e) {
		jQuery(this).removeData('bs.modal');
		jQuery(this).find('#comentario3').val('0');
		jQuery(this).find('#observaciones').val('');
	});
});

function SoloNumeros(evt) {
	if (window.event)
		keynum = evt.keyCode;
	else
		keynum = evt.which;
	if ((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46)
		return true;
	else {
		alerts.showNotification("top", "left", "Solo Numeros.", "danger");
		return false;
	}
}

$("input[data-type='currency']").on({
	keyup: function () {
		formatCurrency($(this));
	},
	blur: function () {
		formatCurrency($(this), "blur");
	},
	click: function () {
		formatCurrency($(this));
	},
});

function formatNumber(n) {
	return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}

function formatCurrency(input, blur) {
	var input_val = input.val();
	
	if (input_val === "") { return; }
	var original_len = input_val.length;
	var caret_pos = input.prop("selectionStart");
	
	if (input_val.indexOf(".") >= 0) {
		var decimal_pos = input_val.indexOf(".");
		var left_side = input_val.substring(0, decimal_pos);
		var right_side = input_val.substring(decimal_pos);
		left_side = formatNumber(left_side);
		right_side = formatNumber(right_side);

		if (blur === "blur") {
			right_side += "00";
		}
		right_side = right_side.substring(0, 2);
		input_val = "$" + left_side + "." + right_side;
	} else {
		input_val = formatNumber(input_val);
		input_val = "$" + input_val;

		if (blur === "blur") {
			input_val += ".00";
		}
	}

	input.val(input_val);

	var updated_len = input_val.length;
	caret_pos = updated_len - original_len + caret_pos;
	input[0].setSelectionRange(caret_pos, caret_pos);
}