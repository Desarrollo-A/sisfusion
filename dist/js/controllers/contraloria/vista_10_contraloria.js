var url = "<?=base_url()?>";
    var url2 = "<?=base_url()?>index.php/";

	$("#tabla_ingresar_corrida").ready( function(){

    $('#tabla_ingresar_corrida thead tr:eq(0) th').each( function (i) {

       if(i != 0 && i != 11){
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if (tabla_corrida.column(i).search() !== this.value ) {
                tabla_corrida
                .column(i)
                .search(this.value)
                .draw();
            }
        } );
    }
});
 

    tabla_corrida = $("#tabla_ingresar_corrida").DataTable({
      // dom: 'Brtip',
      width: 'auto',
  
"language":{ "url": general_base_url+"static/spanishLoader.json" },
"processing": false,
"pageLength": 10,
"bAutoWidth": false,
"bLengthChange": false,
"scrollX": true,
"bInfo": true,
"searching": true,
"ordering": false,
"fixedColumns": true,
"ordering": false,

"columns": [
{
	  "width": "3%",
	  "className": 'details-control',
	"orderable": false,
	"data" : null,
	"defaultContent": '<i class="material-icons" style="color:#003D82;" title="Click para más detalles">play_circle_filled</i>'
},
{
    data: function (d) {
        return `<span class='label lbl-azure'>${d.tipo_venta}</span>`;
	}
},
{
	"width": "15%",
	"data": function( d ){
		return '<p style="font-size: .8em">'+(d.nombreCondominio).toUpperCase();+'</p>';
	}
},
{
    "width": "15%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.nombreLote+'</p>';
	}
},
{
    "width": "15%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
    }
},
{
	"width": "25%",
	"data": function (data) {
		var cntActions;

		if(data.idStatusContratacion == 9 && data.idMovimiento == 39)
		{
			/*APROBADA*/
			/*registroLote/editarLoteContraloriaStatusContratacion10*/
			cntActions = '<a href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" title= "Registrar Status" ' +
				'class="regStats10 btn btn-primary btn-round btn-fab btn-fab-mini">' +
			'<img src="<?=base_url()?>static/images/grading-white-18dp.svg" style="height:27px;width:21px;padding-top:7px;"></a>';

		}
		else if(data.idStatusContratacion == 9 && data.idMovimiento == 26)
		{
			/*registroLote/editarLoteRevisionContraloriaStatusContratacion10*/
			cntActions = '<a href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" title= "Registrar Status" ' +
				'class="envRev10 btn btn-success btn-round btn-fab btn-fab-mini">' +
				'<img src="<?=base_url()?>static/images/baseline_mark_email_read_white_18dp.png" style="height:27px;width:21px;padding-top:7px;"></a>&nbsp;&nbsp;';
		}
		else if(data.idStatusContratacion == 10 && data.idMovimiento == 40 ||
			data.idStatusContratacion == 7 && data.idMovimiento == 66 ||
			data.idStatusContratacion == 8 && data.idMovimiento == 67)
		{
			/*
			cntActions = '<button type="button" class="boton" title="Sin tiempo" id="limit" data-lote="">'+
				'<img src="<?= base_url() ?>static/images/info.png" height="15" width="15"> Información </button>&nbsp;&nbsp;';*/

			cntActions = '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
				'class="boton btn btn-warning btn-round btn-fab btn-fab-mini" title="Sin tiempo" id="limit">' +
				'<span class="material-icons">priority_high</span></button>&nbsp;&nbsp;';
		}
		else if(data.idStatusContratacion == 12 && data.idMovimiento == 42 && data.firmaRL == 'FIRMADO' && data.validacionEnganche=='VALIDADO' ||
			data.idStatusContratacion == 12 && data.idMovimiento == 42 && data.firmaRL == 'FIRMADO' && data.validacionEnganche=='VALIDADO')
		{
			/*cntActions = '<button type="button" class="boton_3" title="Sin tiempo"'+
			'id="limit3" data-lote=""> <img src="static/images/info.png" '+
			'height="15" width="15"> Información </button>&nbsp;&nbsp;';*/
			cntActions = '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
				'class="boton_3 btn btn-warning btn-round btn-fab btn-fab-mini" title="Sin tiempo" id="limit3">' +
				'<span class="material-icons">priority_high</span></button>&nbsp;&nbsp;';
		}
		else if(data.idStatusContratacion == 11 && data.idMovimiento == 41 &&
			data.firmaRL == 'NULL' && data.validacionEnganche=='VALIDADO')
		{
			/*cntActions = '<button type="button" class="boton_1" title="Sin tiempo" id="limi1" data-lote=""> ' +
				'<img src="static/images/info.png" height="15" width="15"> Información </button>&nbsp;&nbsp;';*/
			cntActions = '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
				'class="boton_1 btn btn-warning btn-round btn-fab btn-fab-mini" title="Sin tiempo" id="limi1">' +
				'<span class="material-icons">priority_high</span></button>&nbsp;&nbsp;';
		}
		else if(data.idStatusContratacion == 12 && data.idMovimiento == 42 && data.firmaRL == 'FIRMADO' && data.validacionEnganche=='NULL' ||
			data.idStatusContratacion == 12 && data.idMovimiento == 42 && data.firmaRL == 'FIRMADO' && data.validacionEnganche=='NULL')
		{
			/*cntActions = '<button type="button" class="boton_2" title="Sin tiempo" id="limit2" data-lote=""> ' +
				'<img src="static/images/info.png"height="15" width="15"> Información </button>';*/
			cntActions = '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
				'class="boton_2 btn btn-warning btn-round btn-fab btn-fab-mini" title="Sin tiempo" id="limit2">' +
				'<span class="material-icons">priority_high</span></button>&nbsp;&nbsp;';

		}
		else
		{
			cntActions ='N/A';
		}

		return cntActions;
	}
},


],

columnDefs: [
{
 "searchable": true,
 "orderable": true,
 "targets": 0
},
 
],

"ajax": {
    "url": general_base_url + "Contraloria/getregistroStatus10ContratacionContraloria",
	"dataSrc": "",
    "type": "POST",
    cache: false,
    "data": function( d ){
    }
},
"order": [[ 1, 'asc' ]]

});

		$('#tabla_ingresar_corrida tbody').on('click', 'td.details-control', function () {
			var tr = $(this).closest('tr');
			var row = tabla_corrida.row(tr);

			if (row.child.isShown()) {
				row.child.hide();
				tr.removeClass('shown');
				$(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
			} else {
				var status;
				var fechaVenc;
				if (row.data().idStatusContratacion == 9 && row.data().idMovimiento == 39) {
					status = 'Status 9 listo (Asistentes de Gerentes)';
				} else if (row.data().idStatusContratacion == 9 && row.data().idMovimiento == 26 ) {
					status = 'Rechazo Status 10 (Administración)';
				}
				else if (row.data().idStatusContratacion == 10 && row.data().idMovimiento == 40 ) {
					status = 'SOLICITUD DE VALIDACIÓN DE ENGANCHE ENVIADA';
				}
				else if (row.data().idStatusContratacion == 7 && row.data().idMovimiento == 66 ) {
					status = 'SOLICITUD DE VALIDACIÓN DE ENGANCHE RECHAZADA A ASISTENTES DE GERENTES';
				}
				else if (row.data().idStatusContratacion == 8 && row.data().idMovimiento == 67 ) {
					status = 'SOLICITUD DE VALIDACIÓN DE ENGANCHE ENVIADA A REVICIÓN A ADMINISTRACIÓN';
				}
				else if (row.data().idStatusContratacion == 11 && row.data().idMovimiento == 41 ) {
					status = 'Status 11 listo (Administración)';
				}
				else if (row.data().idStatusContratacion == 12 && row.data().idMovimiento == 42 ) {
					status = 'Status 12 listo (Representante Legal)';
				}
				else
				{
					status='N/A';
				}

				if (row.data().idStatusContratacion == 9 && row.data().idMovimiento == 39 ||
					row.data().idStatusContratacion == 10 && row.data().idMovimiento == 40 ||
					row.data().idStatusContratacion == 8 && row.data().idMovimiento == 67) {
					fechaVenc = row.data().fechaVenc;
				}
				else if(row.data().idStatusContratacion == 9 && row.data().idMovimiento == 26 ||
					row.data().idStatusContratacion == 7 && row.data().idMovimiento == 66)
				{
					fechaVenc='Vencido';
				}
				else if(row.data().idStatusContratacion == 12 && row.data().idMovimiento == 42 &&
					row.data().validacionEnganche == 'VALIDADO' && row.data().firmaRL == 'FIRMADO')
				{
					fechaVenc = row.data().fechaVenc;
				}
				else if(row.data().idStatusContratacion == 11 && row.data().idMovimiento == 41 &&
					row.data().firmaRL == 'FIRMADO' && row.data().validacionEnganche == 'VALIDADO')
				{
					fechaVenc = row.data().fechaVenc;
				}
				else if(row.data().idStatusContratacion == 11 && row.data().idMovimiento == 41 &&
					row.data().firmaRL == 'NULL' && row.data().validacionEnganche == 'VALIDADO')
				{
					fechaVenc = 'SIN FECHA FALTA FIRMA RL';
				}
				else if(row.data().idStatusContratacion == 12 && row.data().idMovimiento == 42 &&
					row.data().firmaRL == 'FIRMADO' && row.data().validacionEnganche == 'NULL')
				{
					fechaVenc = 'SIN FECHA FALTA VALIDACION DE ENGANCHE';
				}
				else
				{
					fechaVenc='N/A';
				}

				var informacion_adicional = '<table class="table text-justify">' +
					'<tr><b>INFORMACIÓN</b>:' +
					'<td style="font-size: .8em"><strong>COMENTARIO: </strong>' + row.data().comentario + '</td>' +
					'<td style="font-size: .8em"><strong>FECHA VENCIMIENTO: </strong>' + fechaVenc + '</td>' +
					'<td style="font-size: .8em"><strong>FECHA REALIZADO: </strong>' + row.data().modificado + '</td>' +
					'</tr>' +
					'<tr>' +
					'<td style="font-size: .8em"><strong>STATUS: </strong>'+ status +'</td>' +
					'</tr>' +
					'</table>';

				row.child(informacion_adicional).show();
				tr.addClass('shown');
				$(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
			}
		});
}); 


	/*registrar estatus 10*/
	$(document).on('click', '.regStats10', function () {
		var idLote = $(this).attr("data-idLote");
		var nomLote = $(this).attr("data-nomLote");
		console.log('diste click alv: '+idLote+' - ' + nomLote);
		$('#nombreLoteregSt10').val($(this).attr('data-nomLote'));
		$('#idLoteregSt10').val($(this).attr('data-idLote'));
		$('#idCondominioregSt10').val($(this).attr('data-idCond'));
		$('#idClienteregSt10').val($(this).attr('data-idCliente'));
		$('#fechaVencregSt10').val($(this).attr('data-fecVen'));
		$('#nomLoteFakeregSt10').val($(this).attr('data-nomLote'));
		$('#regStats10').modal();
	});
	/*RegSt10Enviar --- preguntaRegSt10()*/
	function preguntaRegSt10() {
		var idLote = $("#idLoteregSt10").val();
		var idCondominio = $("#idCondominioregSt10").val();
		var nombreLote = $("#nombreLoteregSt10").val();
		var idStatusContratacion = $("#idStatusContratacionregSt10").val();
		var idCliente = $("#idClienteregSt10").val();
		var fechaVenc = $("#fechaVencregSt10").val();
		// var ubicacion = $("#ubicacion").val();
		var comentario = $("#comentarioregSt10").val();


		var parametros = {
			"idLote": idLote,
			"idCondominio": idCondominio,
			"nombreLote": nombreLote,
			"idStatusContratacion": idStatusContratacion,
			"idCliente": idCliente,
			"fechaVenc": fechaVenc,
			// "ubicacion" : ubicacion,
			"comentario": comentario
		};


		if (comentario.length <= 0 ) {

			// toastr.error('Todos los campos son requeridos');
			alerts.showNotification('top', 'right', 'Todos los campos son requeridos', 'danger')

		} else if (comentario.length > 0) {

			if (confirm('¿Estas seguro de registrar el status?')) {
				$.ajax({
					data: parametros,
					url: general_base_url + "registroLote/editar_registro_lote_contraloria_proceceso10/",
					type: 'POST',
					success: function (response) {

						if (response == 1) {
							var botonEnviar = document.getElementById('RegSt10Enviar');
							botonEnviar.disabled = true;
							$('#regStats10').modal('hide');
							// toastr.success('Status Registrado');
							alerts.showNotification('top', 'right', 'Status Registrado', 'success');
							//window.location='<?//=base_url()?>//index.php/registroLote/registroStatusContratacionAsistentes2';
							$('#tabla_ingresar_corrida').DataTable().ajax.reload();
						} else {
							alerts.showNotification('top', 'right', 'OCURRIO UN ERROR INESPERADO, INTENTELO NUEVAMENTE', 'danger');
						}

					}
				});
			} else {
				// toastr.error('No se ha registrado el status');
				alerts.showNotification('top', 'right', 'No se ha registrado el status', 'danger');

				//window.location='<?//=base_url()?>//index.php/registroLote/registroStatusContratacionAsistentes2';
				$('#tabla_ingresar_corrida').DataTable().ajax.reload();
			}

		}

	}


	$(document).on('click', '.envRev10', function () {

		var idLote = $(this).attr("data-idLote");
		var nomLote = $(this).attr("data-nomLote");
		console.log('diste click alv: '+idLote+' - ' + nomLote);
		$('#nombreLoteregenvRev10').val($(this).attr('data-nomLote'));
		$('#idLoteregenvRev10').val($(this).attr('data-idLote'));
		$('#idCondominioregenvRev10').val($(this).attr('data-idCond'));
		$('#idClienteregenvRev10').val($(this).attr('data-idCliente'));
		$('#fechaVencregenvRev10').val($(this).attr('data-fecVen'));
		$('#nomLoteFakeenvRev10').val($(this).attr('data-nomLote'));
		$('#envRev10').modal();
	});
	/*preguntaenvRev10  -- envRev10Enviar*/
	function preguntaenvRev10() {
		var idLote = $("#idLoteregenvRev10").val();
		var idCondominio = $("#idCondominioregenvRev10").val();
		var nombreLote = $("#nombreLoteregenvRev10").val();
		var idStatusContratacion = $("#idStatusContratacionenvRev10").val();
		var idCliente = $("#idClienteregenvRev10").val();
		var fechaVenc = $("#fechaVencregenvRev10").val();
		// var ubicacion = $("#ubicacion").val();
		var comentario = $("#comentarioenvRev10").val();


		var parametros = {
			"idLote": idLote,
			"idCondominio": idCondominio,
			"nombreLote": nombreLote,
			"idStatusContratacion": idStatusContratacion,
			"idCliente": idCliente,
			"fechaVenc": fechaVenc,
			// "ubicacion" : ubicacion,
			"comentario": comentario
		};


		if (comentario.length <= 0 && idStatusContratacion.length<=0) {

			// toastr.error('Todos los campos son requeridos');
			alerts.showNotification('top', 'right', 'Todos los campos son requeridos', 'danger')

		} else if (comentario.length > 0 && idStatusContratacion.length>0) {

			if (confirm('¿Estas seguro de registrar el status?')) {
				$.ajax({
					data: parametros,
					url: general_base_url + "registroLote/editar_registro_loteRevision_contraloria_proceceso10/",
					type: 'POST',
					success: function (response) {

						if (response == 1) {
							var botonEnviar = document.getElementById('envRev10Enviar');
							botonEnviar.disabled = true;
							$('#envRev10').modal('hide');
							// toastr.success('Status Registrado');
							alerts.showNotification('top', 'right', 'Status Registrado', 'success');
							//window.location='<?//=base_url()?>//index.php/registroLote/registroStatusContratacionAsistentes2';
							$('#tabla_ingresar_corrida').DataTable().ajax.reload();
						} else {
							alerts.showNotification('top', 'right', 'OCURRIO UN ERROR INESPERADO, INTENTELO NUEVAMENTE', 'danger');
						}

					}
				});
			} else {
				// toastr.error('No se ha registrado el status');
				alerts.showNotification('top', 'right', 'No se ha registrado el status', 'danger');

				//window.location='<?//=base_url()?>//index.php/registroLote/registroStatusContratacionAsistentes2';
				$('#tabla_ingresar_corrida').DataTable().ajax.reload();
			}

		}

	}


	$(document).on('click', '.boton', function (e) {
		var nomLote = $(this).attr("data-nomLote");
		e.preventDefault();
		var cntMessage = "<h4><strong>Importante!</strong> El lote: <b>" + nomLote + "</b> se encuentra en Validación de Enganche.</h4>";
		$("#showMessageStats .modal-body").html("");
		$("#showMessageStats .modal-body").append(cntMessage);
		$('#showMessageStats').modal();
	});

	$(document).on('click', '.boton_3', function (e) {
		var nomLote = $(this).attr("data-nomLote");
		e.preventDefault();
		var cntMessage = "<h4><strong>Importante!</strong> El lote: <b>" + nomLote + "</b> ya se encuentra firmado por " +
			"representante Legal y con enganche validado listo para entrega de contrato a asesor.</h4>";
		$("#showMessageStats .modal-body").html("");
		$("#showMessageStats .modal-body").append(cntMessage);
		$('#showMessageStats').modal();
	});

	$(document).on('click', '.boton_1', function (e) {
		var nomLote = $(this).attr("data-nomLote");
		e.preventDefault();
		var cntMessage = "<h4><strong>Importante!</strong> El lote: <b>" + nomLote + "</b> aun no se encuentra " +
			"firmado por Representante Legal.</h4>";
		$("#showMessageStats .modal-body").html("");
		$("#showMessageStats .modal-body").append(cntMessage);
		$('#showMessageStats').modal();
	});

	$(document).on('click', '.boton_2', function (e) {
		var nomLote = $(this).attr("data-nomLote");
		e.preventDefault();
		var cntMessage = "<h4><strong>Importante!</strong> El lote: <b>" + nomLote + "</b> se encuentra en Validación de Enganche.</h4>";
		$("#showMessageStats .modal-body").html("");
		$("#showMessageStats .modal-body").append(cntMessage);
		$('#showMessageStats').modal();
	});