$(document).ready( function() {

	$("#subdirectorSelect").empty().selectpicker('refresh');

	// Set options for subdirectorSelect
	$.post('Statistics/getSubdirectories', function (data) {
		$("#subdirectorSelect").append($('<option disabled selected>').val("0").text("SELECCIONE UNA OPCIÓN"));
		var len = data.length;
		for (var i = 0; i < len; i++) {
			var id = data[i]['id_usuario'];
			var name = data[i]['nombre'];
			var sede = data[i]['id_sede'];
			$("#subdirectorSelect").append($('<option>').val(id).text(name));
		}
		if (len <= 0) {
			$("#subdirectorSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
		}
		$("#subdirectorSelect").selectpicker('refresh');
	}, 'json');

	// Set options for managerSelect
	$.post('Statistics/getManagersBySub', function (data) {
		$("#managerSelect").empty().selectpicker('refresh');
		$("#managerSelect").append($('<option selected>').val("0").text("SELECCIONE UNA OPCIÓN"));
		var len = data.length;
		for (var i = 0; i < len; i++) {
			var id = data[i]['id_usuario'];
			var name = data[i]['nombre'];
			var sede = data[i]['id_sede'];
			$("#managerSelect").append($('<option>').val(id).attr('label', name).text(name));
		}
		if (len <= 0) {
			// $("#managerSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
			$("#managerSelect").append('<option selected="selected" disabled>SELECCIONE UNA OPCIÓN</option>');
		}
		$("#managerSelect").selectpicker('refresh');
	}, 'json');

	// Set options for coordinadoresSelect
	$.post('Statistics/getCoordinatorsByManager', function (data) {
		$("#coordinadoresSelect").empty().selectpicker('refresh');
		$("#coordinadoresSelect").append($('<option selected>').val("0").text("SELECCIONE UNA OPCIÓN"));
		var len = data.length;
		for (var i = 0; i < len; i++) {
			var id = data[i]['id_usuario'];
			var name = data[i]['nombre'];
			var sede = data[i]['id_sede'];
			$("#coordinadoresSelect").append($('<option>').val(id).attr('label', name).text(name));
		}
		if (len <= 0) {
			// $("#coordinadoresSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
			$("#coordinadoresSelect").append('<option selected="selected" disabled>SELECCIONE UNA OPCIÓN</option>');
		}
		$("#coordinadoresSelect").selectpicker('refresh');
	}, 'json');

	// Set options for managerSelect
	$.post('Statistics/getAdvisersByCoordinator', function (data) {
		$("#asesoresSelect").empty().selectpicker('refresh');
		$("#asesoresSelect").append($('<option selected>').val("0").text("SELECCIONE UNA OPCIÓN"));
		var len = data.length;
		for (var i = 0; i < len; i++) {
			var id = data[i]['id_usuario'];
			var name = data[i]['nombre'];
			var sede = data[i]['id_sede'];
			$("#asesoresSelect").append($('<option>').val(id).attr('label', name).text(name));
		}
		if (len <= 0) {
			// $("#coordinadoresSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
			$("#asesoresSelect").append('<option selected="selected" disabled>SELECCIONE UNA OPCIÓN</option>');
		}
		$("#asesoresSelect").selectpicker('refresh');
	}, 'json');

});

function getManagersBySubdirector(element) {
	id_subdir = $('option:selected', element).val();
	$("#managerSelect").find("option").remove();
	$("#managerSelect").append($('<option disabled selected>').val("default").text("SELECCIONE UNA OPCIÓN"));
	$.post('Statistics/getManagersBySubdirector/'+id_subdir, function(data) {
		var len = data.length;
		for( var i = 0; i<len; i++)
		{
			var id = data[i]['id_usuario'];
			var name = data[i]['nombre'];
			var sede = data[i]['id_sede'];
			$("#managerSelect").append($('<option>').val(id).attr('data-sede', sede).text(name));
		}
		if(len<=0)
		{
			// $("#managerSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
			$("#managerSelect").append('<option selected="selected" disabled>SELECCIONE UNA OPCIÓN</option>');
		}
		$("#managerSelect").selectpicker('refresh');
	}, 'json');
}

function getCoordinatorsBySubdirector(element) {
	id_gerente = $('option:selected', element).val();
	$("#coordinadoresSelect").find("option").remove();
	$("#coordinadoresSelect").append($('<option disabled selected>').val("default").text("SELECCIONE UNA OPCIÓN"));
	$.post('Statistics/get_coordinadores_bysub/'+id_gerente, function(data) {
		var len = data.length;
		for( var i = 0; i<len; i++)
		{
			var id = data[i]['id_coordinadores'];
			var name = data[i]['nombre_coordinadores'];
			var sede = data[i]['id_sede'];
			$("#coordinadoresSelect").append($('<option>', {
				value: id,
				text: name
			}));
		}
		if(len<=0)
		{
			// $("#managerSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
			$("#managerSelect").append('<option selected="selected" disabled>SELECCIONE UNA OPCIÓN</option>');
		}
		$("#coordinadoresSelect").selectpicker('refresh');
	}, 'json');
}

function getAdvisersByCoordinator(element) {
	id_coordinator = $('option:selected', element).val();
	$("#asesoresSelect").find("option").remove();
	$("#asesoresSelect").append($('<option disabled selected>').val("default").text("SELECCIONE UNA OPCIÓN"));
	$.post('Statistics/get_asesores_coordinadores/'+id_coordinator, function(data) {
		var len = data.length;
		for( var i = 0; i<len; i++)
		{
			var id = data[i]['id_asesores'];
			var name = data[i]['nombre_asesores'];
			var sede = data[i]['id_sede'];
			$("#asesoresSelect").append($('<option>', {
				value: id,
				text: name
			}));
		}
		if(len<=0)
		{
			// $("#managerSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
			$("#managerSelect").append('<option selected="selected" disabled>SELECCIONE UNA OPCIÓN</option>');
		}
		$("#asesoresSelect").selectpicker('refresh');
	}, 'json');
}
