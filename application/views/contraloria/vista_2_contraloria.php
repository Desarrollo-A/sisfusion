
<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>
    <!--Contenido de la página-->

    <style type="text/css">
        ::-webkit-input-placeholder { /* Chrome/Opera/Safari */
			color: white;
			opacity: 0.4;

			::-moz-placeholder { /* Firefox 19+ */
				color: white;
				opacity: 0.4;
			}
			:-ms-input-placeholder { /* IE 10+ */
				color: white;
				opacity: 0.4;
			}
			:-moz-placeholder { /* Firefox 18- */
				color: white;
				opacity: 0.4;
			}
		}
    </style>

	<!-- modal para registrar expediente-->
	<div class="modal fade modal-alertas" id="integracionExpedienteModal" data-backdrop="static" role="dialog"
		 data-keyboard="false">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Registro Status 2 (Integración de expediente).</h4>
				</div>
				<!--                <form method="post" id="intExpForm">-->
				<div class="modal-body" style="min-height: 380px">
					<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<label>Lote:</label>
						<input type="text" class="form-control" id="nomLoteFake" disabled>

						<br><br>

						<label>Status Contratación</label>
						<select required="required" name="idStatusContratacion" id="idStatusContratacion"
								class="selectpicker" data-style="btn" title="Estatus contratación" data-size="7">
							<option value="2">2. Integración de Expediente (Asistentes de Gerentes)</option>
						</select>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<label>Comentario:</label>
						<input type="text" class="form-control" name="comentario" id="comentario">
						<br><br>

						<label>Tipo de venta</label>
						<select required="required" name="tipo_venta" id="tipo_venta" class="selectpicker"
								data-style="btn" title="Selecciona tipo venta" data-size="7">
							<option value="1"> Venta de particulares</option>
							<option value="2"> Venta normal</option>
							<option value="3"> Bono</option>
							<option value="4"> Donación</option>
							<option value="5"> Intercambio</option>
						</select>
					</div>
					<input type="hidden" name="nombreLote" id="nombreLote" class="form-control">
					<input type="hidden" name="idLote" id="idLote" class="form-control">
					<input type="hidden" name="idCondominio" id="idCondominio" class="form-control">
					<input type="hidden" name="idCliente" id="idCliente" class="form-control">
					<input type="hidden" name="fechaVenc" id="fechaVenc" class="form-control">
					<input type="hidden" name="ubicacion" id="ubicacion" class="form-control">

					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
						<br><br><br>
						<button class="btn btn-social btn-fill btn-info" onclick="pregunta();" value="Enviar"
								id="idRegistrar" style="background:green;
								margin-right: 10px;">ENVIAR
						</button>
						<!--							<button type="submit" class="btn btn-primary" onclick="pregunta();" value="Enviar" id="idRegistrar" style="font-size:18px;" >Registrar Status <i class="fa fa-arrow-circle-right"></i></button>-->
						<button class="btn btn-social btn-fill btn-danger" data-dismiss="modal">CANCELAR</button>
						</center>
					</div>
				</div>
				<!--                </form>-->
			</div>
		</div>
	</div>

	<!-- modal para rechazar estatus-->
	<div class="modal fade" id="rechazarStatus" >
		<div class="modal-dialog">
			<div class="modal-content" >
				<div class="modal-body">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<label>¿Cuáles son las principales causas a que puede atribuirse
							el rechazo de <b><span class="lote"></span></b>? </label>
						<textarea class="form-control" id="motivoRechazo" rows="3"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="guardar" class="btn btn-success"><span
							class="material-icons" onClick="this.disabled=true">send</span> </i> Registrar
						rechazo
					</button>
					<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>
	</div>

	<!-- modal para enviar a revisión-->
	<div class="modal fade" id="enviarARevision" >
		<div class="modal-dialog">
			<div class="modal-content" >
				<div class="modal-header">
					<h4 class="modal-title">Revisión Status a Contraloría (2. Integración de Expediente)</h4>
				</div>
				<div class="modal-body">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<label>Lote:</label>
							<input type="text" class="form-control" id="nomLoteFakeEnARev" disabled>

							<br><br>

							<label>Status Contratación</label>
							<select required="required" name="idStatusContratacion" id="idStatusContratacionEnvARev"
									class="selectpicker" data-style="btn" title="Estatus contratación" data-size="7">
								<option value="2">2. Integración de Expediente (Asistentes de Gerentes)</option>
							</select>
						</div>
						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<label>Comentario:</label>
							<input type="text" class="form-control" name="comentario" id="comentarioEnvARev">
							<br><br>
						</div>
						<input type="hidden" name="idLote" id="idLoteEnvARev" >
						<input type="hidden" name="idCliente" id="idClienteEnvARev" >
						<input type="hidden" name="idCondominio" id="idCondominioEnvARev" >
						<input type="hidden" name="fechaVenc" id="fechaVencEnvARev" >
						<input type="hidden" name="nombreLote" id="nombreLoteEnvARev"  >
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="enviarARevisionGuardar" onClick="preguntaEnvARev()" class="btn btn-success"><span
							class="material-icons" >send</span> </i> Enviar a Revisión
					</button>
					<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>
	</div>

	<!-- modal para enviar a contraloria 6-->
	<div class="modal fade" id="revStatusCont" >
		<div class="modal-dialog">
			<div class="modal-content" >
				<div class="modal-header">
					<h4 class="modal-title">Revisión Status a Contraloría 6 (2. Integración de Expediente)</h4>
				</div>
				<div class="modal-body">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<label>Lote:</label>
							<input type="text" class="form-control" id="nomLoteFakeEnvAContr" disabled>

							<br><br>

							<label>Status Contratación</label>
							<select required="required" name="idStatusContratacion" id="idStatusContratacionEnvAContr"
									class="selectpicker" data-style="btn" title="Estatus contratación" data-size="7">
								<option value="2">2. Integración de Expediente (Asistentes de Gerentes) </option>
							</select>
						</div>
						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<label>Comentario:</label>
							<input type="text" class="form-control" name="comentario" id="comentarioEnvAContr">
							<br><br>
						</div>
						<input type="hidden" name="idLote" id="idLoteEnvAContr" >
						<input type="hidden" name="idCliente" id="idClienteEnvAContr" >
						<input type="hidden" name="idCondominio" id="idCondominioEnvAContr" >
						<input type="hidden" name="fechaVenc" id="fechaVencEnvAContr" >
						<input type="hidden" name="nombreLote" id="nombreLoteEnvAContr"  >
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="enviarAContraloriaGuardar" onClick="preguntaEnvAContr()" class="btn btn-success"><span
							class="material-icons" >send</span> </i> Enviar a Revisión
					</button>
					<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>
	</div>

	<!-- modal para enviar a Juridico integración de expediente-->
	<div class="modal fade" id="revStatusJurid" >
		<div class="modal-dialog">
			<div class="modal-content" >
				<div class="modal-header">
					<h4 class="modal-title">Revisión Status a Jurídico (2. Integración de Expediente)</h4>
				</div>
				<div class="modal-body">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<label>Lote:</label>
							<input type="text" class="form-control" id="nomLoteFakeEnvAJurid" disabled>

							<br><br>

							<label>Status Contratación</label>
							<select required="required" name="idStatusContratacion" id="idStatusContratacionEnvAJuridico"
									class="selectpicker" data-style="btn" title="Estatus contratación" data-size="7">
								<option value="2">2. Integración de Expediente (Asistentes de Gerentes) </option>
							</select>
						</div>
						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<label>Comentario:</label>
							<input type="text" class="form-control" name="comentario" id="comentarioEnvAJuridico">
							<br><br>
						</div>
						<input type="hidden" name="idLote" id="idLoteEnvAJuridico" >
						<input type="hidden" name="idCliente" id="idClienteEnvAJuridico" >
						<input type="hidden" name="idCondominio" id="idCondominioEnvAJuridico" >
						<input type="hidden" name="fechaVenc" id="fechaVencEnvAJuridico" >
						<input type="hidden" name="nombreLote" id="nombreLoteEnvAJuridico"  >
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="enviarAJuridicoGuardar" onClick="preguntaEnvAJuridico()" class="btn btn-success"><span
							class="material-icons" >send</span> </i> Enviar a Revisión
					</button>
					<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>
	</div>



    <div class="content">
        <div class="container-fluid">
<!--			<h4 style="text-align: center">REGISTRO ESTATUS <b>2</b> (Integración de expediente)</h4>-->
            <div class="row">
                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">Registro estatus <b>2</b> (integración de expediente)</h4>
                            <div class="toolbar">
                             </div>
                            <div class="material-datatables"> 

                                <div class="form-group">
                                    <div class="table-responsive">
 
                                        <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_ingresar_2" name="tabla_ingresar_2">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th style="font-size: .9em;">LOTE</th>
                                                <th style="font-size: .9em;">PROYECTO</th>
                                                <th style="font-size: .9em;">CONDOMINIO</th>
                                                <th style="font-size: .9em;">CLIENTE</th>
                                                <th style="font-size: .9em;"></th>
                                            </tr>
                                        </thead>
                                    </table>

 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('template/footer_legend');?>
</div>
</div>

</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script>


    var url = "<?=base_url()?>";
var url2 = "<?=base_url()?>index.php/";



     $("#tabla_ingresar_2").ready( function(){

    $('#tabla_ingresar_2 thead tr:eq(0) th').each( function (i) {

       if(i != 0 && i != 11){
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if (tabla_2.column(i).search() !== this.value ) {
                tabla_2
                .column(i)
                .search(this.value)
                .draw();
            }
        } );
    }
});
 

    tabla_2 = $("#tabla_ingresar_2").DataTable({
      // dom: 'Brtip',
      width: 'auto',
  
"language":{ "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
"processing": true,
"pageLength": 10,
"bAutoWidth": false,
"bLengthChange": false,
"scrollX": true,
"bInfo": false,
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
    "width": "20%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.nombreLote+'</p>';
    }
},
{
    "width": "20%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.nombreResidencial+'</p>';
    }
},
{
    "width": "20%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+(d.nombreCondominio).toUpperCase();+'</p>';
    }
},
{
    "width": "25%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
    }
},
{ 
    "width": "12%",
    "orderable": false,
    "data": function( data ){

    	var cntActions;

    	if(data.idStatusContratacion == 2 && data.idMovimiento == 84 && data.perfil == 'contraloria')
		{
			/*APROBADA*/
			cntActions = '<a href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" class="integrarExp">' +
				'<img src="<?= base_url() ?>static/images/statusContratacion.png" style="height:35px;width:35px" title="Registrar Status"></a>';
			cntActions += '<button type="button" class="btn btn-danger  btn-round btn-fab btn-fab-mini rechazarA2-0" data-idlote="'+data.idLote+'" ' +
				'data-nomlote="'+data.nombreLote+'"title="Rechazo de expediente">' +
				'<span class="material-icons"> thumb_down_alt </span>' +
				'</button>';

		}
		else if(data.idStatusContratacion == 1 && data.idMovimiento == 18 && data.perfil == 'juridico')
		{
			/*APROBADA*/
			/*<?= base_url() ?>index.php/registroLote/editarLoteRevisionAsistentesStatusContratacion2/'+data.idLote+'*/
			cntActions = '<a href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" class="revStatusJuridico">' +
				'<img src="<?= base_url() ?>static/images/revision.png" style="height:30px;width:45px" title="Enviar status a revisión"></a><br><br>';
		}
		else if(data.idStatusContratacion == 1 && data.idMovimiento == 19 && data.perfil == 'postventa')
		{
			cntActions = '<a href="<?= base_url() ?>index.php/registroLote/editarLoteRevisionAsistentesAPostventaStatusContratacion2/'+data.idLote+'">' +
				'<img src="<?= base_url() ?>static/images/revision.png" height="23" width="35" title="Enviar status a revisión"></a><br><br>';
		}
		else if(data.idStatusContratacion == 1 && data.idMovimiento == 20 && data.perfil == 'contraloria')
		{
			/*APROBADA*/
			/*<?= base_url() ?>index.php/registroLote/editarLoteRevisionAsistentesAContraloriaStatusContratacion2/'+data.idLote+'*/
			cntActions = '<a href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" class="enviARev">' +
				'<img src="<?= base_url() ?>static/images/revision.png" style="height:30px;width:45px" title="Enviar status a revisión"></a><br><br>';
		}
		else if(data.idStatusContratacion == 1 && data.idMovimiento == 63 && data.perfil == 'contraloria')
		{
			/*APROBADA*/
			/*<?= base_url() ?>index.php/registroLote/editarLoteRevisionAsistentesAContraloria6StatusContratacion2/'+data.idLote+'*/
			cntActions = '<a href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" class="revCont6">' +
				'<img src="<?= base_url() ?>static/images/revision.png" style="height:30px;width:45px" title="Enviar status a revisión (cont 6)"></a><br><br>';
		}
		else if(data.idStatusContratacion == 1 && data.idMovimiento == 73 && data.perfil == 'ventasAsistentes')
		{
			cntActions = '<a href="<?= base_url() ?>index.php/registroLote/editarLoteRevisionEliteStatus2aContraloria5/'+data.idLote+'">' +
				'<img src="<?= base_url() ?>static/images/revision.png" height="23" width="35" title="Enviar status a revisión (Contraloría 5)"></a><br><br>';
		}
		else
		{
			cntActions = 'N/A';
		}
        // opciones = '<div class="btn-group" role="group">';
        // opciones += '<button class="btn btn-just-icon btn-square btn-linkedin registrar_estatus_2" title="Registrar estatus" value="'+data.nombreLote+'" data-value="'+data.idLote+'" style="background:#0FC6C6;"><i class="material-icons">description</i></button>';

        // opciones += '<button class="btn btn-just-icon btn-square btn-linkedin rechazar_estatus_2" title="Rechazar expediente" value="'+data.nombreLote+'" data-value="'+data.idLote+'" style="background:#C6120F;margin-left: 10px;"><i class="material-icons">redo</i></button>';
         // opciones += '<button class="btn btn-just-icon btn-square btn-linkedin registrar_estatus_2_0" title="Rechazar expediente" value="'+data.nombreLote+'" data-value="'+data.idLote+'" style="background:#C6120F;margin-left: 10px;"><i class="material-icons">redo</i></button>';
         //  opciones += '<button class="btn btn-just-icon btn-square btn-linkedin registrar_estatus_2_0" title="Rechazar expediente" value="'+data.nombreLote+'" data-value="'+data.idLote+'" style="background:#C6120F;margin-left: 10px;"><i class="material-icons">redo</i></button>';
        // return opciones + '</div>';
		return cntActions;

} 
}
 
],

columnDefs: [
{
 "searchable": false,
 "orderable": false,
 "targets": 0
},
 
],

"ajax": {
    "url": url2 + "contraloria/registroStatusContratacionAsistentes2",
    "dataSrc": "",
    "type": "POST",
    cache: false,
    "data": function( d ){
    }
},
"order": [[ 1, 'asc' ]]

});

 

 $('#tabla_ingresar_2 tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = tabla_2.row( tr );

    if ( row.child.isShown() ) {
        row.child.hide();
        tr.removeClass('shown');
        $(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
    }
	else {
		var status;
		var fechaVenc;
		if(row.data().idStatusContratacion == 2 && row.data().idMovimiento==84)
		{
			status = 'Status 2.0 listo (Contraloria)';
		}
		else if(row.data().idStatusContratacion == 1 && row.data().idMovimiento==18)
		{
			status = 'Status 2 Rechazado (Jurídico)';
		}
		else if(row.data().idStatusContratacion == 1 && row.data().idMovimiento==19)
		{
			status = 'Status 2 Rechazado (Postventa)';
		}
		else if(row.data().idStatusContratacion == 1 && row.data().idMovimiento==20)
		{
			status = 'Status 2 Rechazado (Contraloría 5)';
		}
		else if(row.data().idStatusContratacion == 1 && row.data().idMovimiento==63)
		{
			status = 'Status 2 Rechazado (Contraloría 6)';
		}
		else if(row.data().idStatusContratacion == 1 && row.data().idMovimiento==73)
		{
			status = 'Status 2 Rechazado (Asistentes de Gerentes 8)';
		}

		if(row.data().idStatusContratacion == 1 && row.data().idMovimiento==18 ||
		   row.data().idStatusContratacion == 1 && row.data().idMovimiento==19 ||
		   row.data().idStatusContratacion == 1 && row.data().idMovimiento==20 ||
		   row.data().idStatusContratacion == 1 && row.data().idMovimiento==63 ||
		   row.data().idStatusContratacion == 1 && row.data().idMovimiento==73)
		{
			fechaVenc = 'vencido';
		}
		else if(row.data().idStatusContratacion == 2 && row.data().idMovimiento==84)
		{
			fechaVenc = row.data().fechaVenc;
		}



		var informacion_adicional = '<table class="table text-justify">'+
			'<tr><b>STATUS</b>:'+ status +
			'<td style="font-size: .8em"><strong>COMENTARIO: </strong>'+row.data().comentario+'</td>'+
			'<td style="font-size: .8em"><strong>FECHA VENCIMIENTO: </strong>'+fechaVenc+'</td>'+
			'<td style="font-size: .8em"><strong>FECHA REALIZADO: </strong>'+row.data().modificado+'</td>'+
			'</tr>'+
			'</table>';

		row.child( informacion_adicional ).show();
		tr.addClass('shown');
		$(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
	}
});
    $("#tabla_ingresar_2 tbody").on("click", ".registrar_estatus_2", function(){

        nombreLote = $(this).val();
        IDLote =  $(this).attr("data-value");

        $("#modal_ingresar_2 .modal-body").html("");

        $("#modal_ingresar_2 .modal-body").append('<div class="row"><div class="col-lg-12"><label><h4>¿Está seguro de registrar el ingreso de <b>'+nombreLote+'</b>?</h4></label></div></div>');

        $("#modal_ingresar_2 .modal-body").append('<div class="row"><div class="col-lg-2">&nbsp;</div><div class="col-lg-8"><center><button class="btn btn-social btn-fill btn-info boton_aceptar" style="background:green;margin-right: 10px;" value="'+IDLote+'">ACEPTAR</button><button class="btn btn-social btn-fill btn-danger" data-dismiss="modal" >CANCELAR</button></center></div></div>');
        $("#modal_ingresar_2").modal();
});
        $("#tabla_ingresar_2 tbody").on("click", ".rechazar_estatus_2", function(){

        nombreLote = $(this).val();
        IDLote =  $(this).attr("data-value");

        $("#modal_rechazar_2 .modal-body").html("");

        $("#modal_rechazar_2 .modal-body").append('<div class="row"><div class="col-lg-12"><label><h4>¿Está seguro de <b>rechazar</b> el expediente de <b>'+nombreLote+'</b>?</h4></label></div></div>');

        $("#modal_rechazar_2 .modal-body").append('<div class="row"><div class="col-lg-2">&nbsp;</div><div class="col-lg-8"><center><button class="btn btn-social btn-fill btn-info boton_aceptar" style="margin-right: 10px;" value="'+IDLote+'">SI</button><button class="btn btn-social btn-fill btn-danger" data-dismiss="modal">NO</button></center></div></div>');
        $("#modal_rechazar_2").modal();
});
});
	var parametros;
	var idLote;
	var nombreLote;

	/*rechazar status*/
     $(document).on('click', '.rechazarA2-0', function (e) {
		 idLote = $(this).data("idlote");
		 nombreLote = $(this).data("nomlote");
		 $(".lote").html(nombreLote);

		 $('#rechazarStatus').modal();
		 e.preventDefault();
	 });
	$("#guardar").click(function () {

		var motivoRechazo = $("#motivoRechazo").val();

		parametros = {
			"idLote": idLote,
			"nombreLote": nombreLote,
			"motivoRechazo": motivoRechazo
		};


		$('#guardar').prop('disabled', true);
		$.ajax({
			url: '<?=base_url()?>index.php/contraloria/sendMailRechazoEst2_0/',
			type: 'POST',
			data: parametros,
			success: function (data, textStatus, jqXHR) {
				if(data == 1)
				{
					$('#rechazarStatus').modal('hide');
					// toastr.success('Expediente rechazado exitosamente');
					alerts.showNotification('top', 'right', 'Expediente rechazado exitosamente', 'success');
					$('#guardar').prop('disabled', false);
					// location.reload();
					$('#tabla_ingresar_2').DataTable().ajax.reload();
				}
				else
				{
					alerts.showNotification('top', 'right', 'Ocurrio un error, intentalo nuevamente ['+jqXHR+' '+
						textStatus+ ' '+
						errorThrown+']', 'danger');
				}

			},
			error: function (jqXHR, textStatus, errorThrown) {
				// toastr.error('Ocurrio un error');
				alerts.showNotification('top', 'right', 'Ocurrio un error, intentalo nuevamente ['+jqXHR+' '+
				textStatus+ ' '+
				errorThrown+']', 'danger');
			}
		});
	});
	/*integrar expediente*/
	$(document).on('click', '.integrarExp', function () {
		var idLote = $(this).attr("data-idLote");
		var nomLote = $(this).attr("data-nomLote");
		// console.log('diste click alv: '+idLote+' - ' + nomLote);
		$('#nombreLote').val($(this).attr('data-nomLote'));
		$('#idLote').val($(this).attr('data-idLote'));
		$('#idCondominio').val($(this).attr('data-idCond'));
		$('#idCliente').val($(this).attr('data-idCliente'));
		$('#fechaVenc').val($(this).attr('data-fecVen'));
		$('#ubicacion').val($(this).attr('data-ubic'));
		$('#nomLoteFake').val($(this).attr('data-nomLote'));
		$('#integracionExpedienteModal').modal();
	});
	function pregunta() {

		var idLote = $("#idLote").val();
		var idCondominio = $("#idCondominio").val();
		var nombreLote = $("#nombreLote").val();
		var idStatusContratacion = $("#idStatusContratacion").val();
		var idCliente = $("#idCliente").val();
		var fechaVenc = $("#fechaVenc").val();
		var ubicacion = $("#ubicacion").val();
		var comentario = $("#comentario").val();
		var tipo_venta = $("#tipo_venta").val();


		var parametros = {
			"idLote" : idLote,
			"idCondominio" : idCondominio,
			"nombreLote" : nombreLote,
			"idStatusContratacion" : idStatusContratacion,
			"idCliente" : idCliente,
			"fechaVenc" : fechaVenc,
			"ubicacion" : ubicacion,
			"comentario" : comentario,
			"tipo_venta" : tipo_venta
		};


		if (comentario.length <= 0 || tipo_venta == 0) {

			// toastr.error('Todos los campos son requeridos');
			alerts.showNotification('top', 'right', 'Todos los campos son requeridos', 'danger')

		} else if(comentario.length > 0 || tipo_venta != 0){

			if (confirm('¿Estas seguro de registrar el status?')){
				$.ajax({
					data : parametros,
					url : '<?=base_url()?>index.php/registroLote/editar_registro_lote_asistentes_proceceso2/',
					type : 'POST',
					success : function (response) {

						if(response == 1)
						{
							var botonEnviar = document.getElementById('idRegistrar');
							botonEnviar.disabled = true;
							$('#integracionExpedienteModal').modal('hide');
							// toastr.success('Status Registrado');
							alerts.showNotification('top', 'right', 'Status Registrado', 'success');
							//window.location='<?//=base_url()?>//index.php/registroLote/registroStatusContratacionAsistentes2';
							$('#tabla_ingresar_2').DataTable().ajax.reload();
						}
						else
						{
							alerts.showNotification('top', 'right', 'OCURRIO UN ERROR INESPERADO, INTENTELO NUEVAMENTE', 'success');
						}

					}
				});
			}
			else{
				// toastr.error('No se ha registrado el status');
				alerts.showNotification('top', 'right', 'No se ha registrado el status', 'danger');

				//window.location='<?//=base_url()?>//index.php/registroLote/registroStatusContratacionAsistentes2';
				$('#tabla_ingresar_2').DataTable().ajax.reload();
			}

		}

	}

	/*enviar a revision*/
	$(document).on('click', '.enviARev', function () {
		var idLote = $(this).attr("data-idLote");
		var nomLote = $(this).attr("data-nomLote");
		// console.log('diste click alv: '+idLote+' - ' + nomLote);
		$('#nombreLoteEnvARev').val($(this).attr('data-nomLote'));
		$('#idLoteEnvARev').val($(this).attr('data-idLote'));
		$('#idCondominioEnvARev').val($(this).attr('data-idCond'));
		$('#idClienteEnvARev').val($(this).attr('data-idCliente'));
		$('#fechaVencEnvARev').val($(this).attr('data-fecVen'));
		// $('#ubicacion').val($(this).attr('data-ubic'));
		$('#nomLoteFakeEnARev').val($(this).attr('data-nomLote'));
		$('#enviarARevision').modal();
	});
	function preguntaEnvARev() {

		var idLote = $("#idLoteEnvARev").val();
		var idCondominio = $("#idCondominioEnvARev").val();
		var nombreLote = $("#nombreLoteEnvARev").val();
		var idStatusContratacion = $("#idStatusContratacionEnvARev").val();
		var idCliente = $("#idClienteEnvARev").val();
		var fechaVenc = $("#fechaVencEnvARev").val();
		// var ubicacion = $("#ubicacion").val();
		var comentario = $("#comentarioEnvARev").val();


		var parametros = {
			"idLote" : idLote,
			"idCondominio" : idCondominio,
			"nombreLote" : nombreLote,
			"idStatusContratacion" : idStatusContratacion,
			"idCliente" : idCliente,
			"fechaVenc" : fechaVenc,
			// "ubicacion" : ubicacion,
			"comentario" : comentario
		};


		if (comentario.length <= 0 || tipo_venta == 0) {

			// toastr.error('Todos los campos son requeridos');
			alerts.showNotification('top', 'right', 'Todos los campos son requeridos', 'danger')

		} else if(comentario.length > 0 || tipo_venta != 0){

			if (confirm('¿Estas seguro de registrar el status?')){
				$.ajax({
					data : parametros,
					url : '<?=base_url()?>index.php/registroLote/editar_registro_loteRevision_asistentesAContraloria_proceceso2/',
					type : 'POST',
					success : function (response) {

						if(response == 1)
						{
							var botonEnviar = document.getElementById('enviarARevisionGuardar');
							botonEnviar.disabled = true;
							$('#enviarARevision').modal('hide');
							// toastr.success('Status Registrado');
							alerts.showNotification('top', 'right', 'Status Registrado', 'success');
							//window.location='<?//=base_url()?>//index.php/registroLote/registroStatusContratacionAsistentes2';
							$('#tabla_ingresar_2').DataTable().ajax.reload();
						}
						else
						{
							alerts.showNotification('top', 'right', 'OCURRIO UN ERROR INESPERADO, INTENTELO NUEVAMENTE', 'danger');
						}

					}
				});
			}
			else{
				// toastr.error('No se ha registrado el status');
				alerts.showNotification('top', 'right', 'No se ha registrado el status', 'danger');

				//window.location='<?//=base_url()?>//index.php/registroLote/registroStatusContratacionAsistentes2';
				$('#tabla_ingresar_2').DataTable().ajax.reload();
			}

		}

	}

	/*Revision sattus a Contraloria 6*/
	$(document).on('click', '.revCont6', function () {
		var idLote = $(this).attr("data-idLote");
		var nomLote = $(this).attr("data-nomLote");
		console.log('diste click alv: '+idLote+' - ' + nomLote);
		$('#nombreLoteEnvAContr').val($(this).attr('data-nomLote'));
		$('#idLoteEnvAContr').val($(this).attr('data-idLote'));
		$('#idCondominioEnvAContr').val($(this).attr('data-idCond'));
		$('#idClienteEnvAContr').val($(this).attr('data-idCliente'));
		$('#fechaVencEnvAContr').val($(this).attr('data-fecVen'));
		$('#nomLoteFakeEnvAContr').val($(this).attr('data-nomLote'));
		$('#revStatusCont').modal();
	});
	function  preguntaEnvAContr() {
		var idLote = $("#idLoteEnvAContr").val();
		var idCondominio = $("#idCondominioEnvAContr").val();
		var nombreLote = $("#nombreLoteEnvAContr").val();
		var idStatusContratacion = $("#idStatusContratacionEnvAContr").val();
		var idCliente = $("#idClienteEnvAContr").val();
		var fechaVenc = $("#fechaVencEnvAContr").val();
		// var ubicacion = $("#ubicacion").val();
		var comentario = $("#comentarioEnvAContr").val();


		var parametros = {
			"idLote" : idLote,
			"idCondominio" : idCondominio,
			"nombreLote" : nombreLote,
			"idStatusContratacion" : idStatusContratacion,
			"idCliente" : idCliente,
			"fechaVenc" : fechaVenc,
			// "ubicacion" : ubicacion,
			"comentario" : comentario
		};


		if (comentario.length <= 0 || tipo_venta == 0) {

			// toastr.error('Todos los campos son requeridos');
			alerts.showNotification('top', 'right', 'Todos los campos son requeridos', 'danger')

		} else if(comentario.length > 0 || tipo_venta != 0){

			if (confirm('¿Estas seguro de registrar el status?')){
				$.ajax({
					data : parametros,
					url : '<?=base_url()?>index.php/registroLote/editar_registro_loteRevision_asistentesAContraloria6_proceceso2/',
					type : 'POST',
					success : function (response) {

						if(response == 1)
						{
							var botonEnviar = document.getElementById('enviarAContraloriaGuardar');
							botonEnviar.disabled = true;
							$('#revStatusCont').modal('hide');
							// toastr.success('Status Registrado');
							alerts.showNotification('top', 'right', 'Status Registrado', 'success');
							//window.location='<?//=base_url()?>//index.php/registroLote/registroStatusContratacionAsistentes2';
							$('#tabla_ingresar_2').DataTable().ajax.reload();
						}
						else
						{
							alerts.showNotification('top', 'right', 'OCURRIO UN ERROR INESPERADO, INTENTELO NUEVAMENTE', 'danger');
						}

					}
				});
			}
			else{
				// toastr.error('No se ha registrado el status');
				alerts.showNotification('top', 'right', 'No se ha registrado el status', 'danger');

				//window.location='<?//=base_url()?>//index.php/registroLote/registroStatusContratacionAsistentes2';
				$('#tabla_ingresar_2').DataTable().ajax.reload();
			}

		}
	}

	/*Revision a status Juridico Integracion expediente*/
	$(document).on('click', '.revStatusJuridico', function () {
		var idLote = $(this).attr("data-idLote");
		var nomLote = $(this).attr("data-nomLote");
		// console.log('diste click alv: '+idLote+' - ' + nomLote);
		$('#nombreLoteEnvAJuridico').val($(this).attr('data-nomLote'));
		$('#idLoteEnvAJuridico').val($(this).attr('data-idLote'));
		$('#idCondominioEnvAJuridico').val($(this).attr('data-idCond'));
		$('#idClienteEnvAJuridico').val($(this).attr('data-idCliente'));
		$('#fechaVencEnvAJuridico').val($(this).attr('data-fecVen'));
		$('#nomLoteFakeEnvAJurid').val($(this).attr('data-nomLote'));
		$('#revStatusJurid').modal();
	});

	function preguntaEnvAJuridico() {
		var idLote = $("#idLoteEnvAJuridico").val();
		var idCondominio = $("#idCondominioEnvAJuridico").val();
		var nombreLote = $("#nombreLoteEnvAJuridico").val();
		var idStatusContratacion = $("#idStatusContratacionEnvAJuridico").val();
		var idCliente = $("#idClienteEnvAJuridico").val();
		var fechaVenc = $("#fechaVencEnvAJuridico").val();
		// var ubicacion = $("#ubicacion").val();
		var comentario = $("#comentarioEnvAJuridico").val();


		var parametros = {
			"idLote" : idLote,
			"idCondominio" : idCondominio,
			"nombreLote" : nombreLote,
			"idStatusContratacion" : idStatusContratacion,
			"idCliente" : idCliente,
			"fechaVenc" : fechaVenc,
			// "ubicacion" : ubicacion,
			"comentario" : comentario
		};


		if (comentario.length <= 0 || tipo_venta == 0) {

			// toastr.error('Todos los campos son requeridos');
			alerts.showNotification('top', 'right', 'Todos los campos son requeridos', 'danger')

		} else if(comentario.length > 0 || tipo_venta != 0){

			if (confirm('¿Estas seguro de registrar el status?')){
				$.ajax({
					data : parametros,
					url : '<?=base_url()?>index.php/registroLote/editar_registro_loteRevision_asistentes_proceceso2/',
					type : 'POST',
					success : function (response) {

						if(response == 1)
						{
							var botonEnviar = document.getElementById('enviarAJuridicoGuardar');
							botonEnviar.disabled = true;
							$('#revStatusJurid').modal('hide');
							// toastr.success('Status Registrado');
							alerts.showNotification('top', 'right', 'Status Registrado', 'success');
							//window.location='<?//=base_url()?>//index.php/registroLote/registroStatusContratacionAsistentes2';
							$('#tabla_ingresar_2').DataTable().ajax.reload();
						}
						else
						{
							alerts.showNotification('top', 'right', 'OCURRIO UN ERROR INESPERADO, INTENTELO NUEVAMENTE', 'danger');
						}

					}
				});
			}
			else{
				// toastr.error('No se ha registrado el status');
				alerts.showNotification('top', 'right', 'No se ha registrado el status', 'danger');

				//window.location='<?//=base_url()?>//index.php/registroLote/registroStatusContratacionAsistentes2';
				$('#tabla_ingresar_2').DataTable().ajax.reload();
			}

		}
	}
 
</script>

