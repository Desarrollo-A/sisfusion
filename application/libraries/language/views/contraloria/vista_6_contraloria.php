
<body class="">
<div class="wrapper ">
    <?php
$dato= array(
        'home' => 0,
        'listaCliente' => 0,
        'expediente' => 0,
        'corrida' => 0,
        'documentacion' => 0,
        'historialpagos' => 0,
        'inventario' => 0,
        'estatus20' => 0,
        'estatus2' => 0,
        'estatus5' => 0,
        'estatus6' => 1,
        'estatus9' => 0,
        'estatus10' => 0,
        'estatus13' => 0,
        'estatus15' => 0,
        'enviosRL' => 0,
        'estatus12' => 0,
        'acuserecibidos' => 0,
        'tablaPorcentajes' => 0,
        'comnuevas' => 0,
        'comhistorial' => 0,
		'integracionExpediente' => 0,
		'expRevisados' => 0,
		'estatus10Report' => 0,
		'rechazoJuridico' => 0
    );
    //$this->load->view('template/contraloria/sidebar', $dato);
	$this->load->view('template/sidebar', $dato);
    ?>
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

	<!-- modal para registrar corrida elaborada-->
	<div class="modal fade " id="regCorrElab" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content" >
				<div class="modal-header">
					<center><h4 class="modal-title"><label>Registro estatus 6 - <b><span class="lote"></span></b></label></h4></center>
				</div>
				<div class="modal-body">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-12">
							<label>Comentario:</label>
							<textarea class="form-control" name="comentario" id="comentarioregCor" rows="3"></textarea>
                             <br>
						</div>
				
						<input type="hidden" name="idLote" id="idLoteregCor" >
						<input type="hidden" name="idCliente" id="idClienteregCor" >
						<input type="hidden" name="idCondominio" id="idCondominioregCor" >
						<input type="hidden" name="fechaVenc" id="fechaVencregCor" >
						<input type="hidden" name="nombreLote" id="nombreLoteregCor"  >
					</div>
				</div>

				<div class="modal-footer"></div>
				<div class="modal-footer">
					<button type="button" id="enviarAContraloriaGuardar" onClick="preguntaRegCorr()" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
				</div>
			</div>
		</div>
	</div>




	<div class="modal fade " id="rechazarStatus" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content" >
				<div class="modal-header">
					<center><h4 class="modal-title"><label>Rechazo estatus 6 - <b><span class="lote"></span></b></label></h4></center>
				</div>
				<div class="modal-body">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-12">
							<label>Comentario:</label>
							<textarea class="form-control" name="motivoRechazo" id="motivoRechazo" rows="3"></textarea>
                             <br>
						</div>
				
						<input type="hidden" name="idCliente" id="idClienterechCor" >
						<input type="hidden" name="idCondominio" id="idCondominiorechCor" >
					</div>
				</div>

				<div class="modal-footer"></div>
				<div class="modal-footer">
					<button type="button" id="guardar" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
				</div>
			</div>
		</div>
	</div>



	<!-- modal para informar que no hay corrida-->
	<div class="modal fade" id="infoNoCorrida" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content" >
			<div class="modal-header"></div>
				<div class="modal-body">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
				     	<center><span class="material-icons" style= "font-size: 48px;">warning</span>
						 </br>
						 </br>
						<h4 class="modal-title"><label>No se ha adjuntado corrida del lote: <b><span class="lote"></span></b></label></h4></center>
					</div>
				</div>
				<div class="modal-footer"></div>
				<div class="modal-footer">
				    <button type="button" class="btn btn-success" data-dismiss="modal"><span class="material-icons">done</span> </i> Entendido</button>
				</div>
			</div>
		</div>
	</div>





	<div class="modal fade " id="regRevCorrElab" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content" >
				<div class="modal-header">
					<center><h4 class="modal-title"><label>Registro estatus 6 - <b><span class="lote"></span></b></label></h4></center>
				</div>
				<div class="modal-body">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-12">
							<label>Comentario:</label>
							<textarea class="form-control" name="comentario1" id="comentario1" rows="3"></textarea>
                             <br>
						</div>
					</div>
				</div>

				<div class="modal-footer"></div>
				<div class="modal-footer">
					<button type="button" id="save1" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
				</div>
			</div>
		</div>
	</div>





	<div class="modal fade " id="regRevA7" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content" >
				<div class="modal-header">
					<center><h4 class="modal-title"><label>Registro estatus 6 - <b><span class="lote"></span></b></label></h4></center>
				</div>
				<div class="modal-body">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-12">
							<label>Comentario:</label>
							<textarea class="form-control" name="comentario2" id="comentario2" rows="3"></textarea>
                             <br>
						</div>
					</div>
				</div>

				<div class="modal-footer"></div>
				<div class="modal-footer">
					<button type="button" id="save2" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
				</div>
			</div>
		</div>
	</div>





	<!-- modal para enviar a revision status corrida elborada -->
	<div class="modal fade" id="envARevCE" >
		<div class="modal-dialog">
			<div class="modal-content" >
				<div class="modal-header">
					<h4 class="modal-title">Revisión Status (6. Corrida elaborada)</h4>
				</div>
				<div class="modal-body">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<label>Lote:</label>
							<input type="text" class="form-control" id="nomLoteFakeenvARevCE" disabled>

							<br><br>

							<label>Status Contratación</label>
							<select required="required" name="idStatusContratacion" id="idStatusContratacionenvARevCE"
									class="selectpicker" data-style="btn" title="Estatus contratación" data-size="7">
								<option value="6">  6. Corrida elaborada (Contraloría) </option>
							</select>
						</div>
						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<label>Comentario:</label>
							<input type="text" class="form-control" name="comentario" id="comentarioenvARevCE">
							<br><br>
						</div>
						<input type="hidden" name="idLote" id="idLoteenvARevCE" >
						<input type="hidden" name="idCliente" id="idClienteenvARevCE" >
						<input type="hidden" name="idCondominio" id="idCondominioenvARevCE" >
						<input type="hidden" name="fechaVenc" id="fechaVencenvARevCE" >
						<input type="hidden" name="nombreLote" id="nombreLoteenvARevCE"  >
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="enviarenvARevCE" onClick="preguntaenvARevCE()" class="btn btn-primary"><span
							class="material-icons" >send</span> </i> Enviar a Revisión
					</button>
					<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>
	</div>


    <div class="content">
        <div class="container-fluid">
<!-- 			<h5 style="text-align: center">REGISTRO ESTATUS 6 (Corrida elaborada)</h5>-->
            <div class="row">
                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title center-align">Registro estatus 6 (corrida elaborada)</h4>
                            <div class="toolbar">
                             </div>
                            <div class="material-datatables"> 

                                <div class="form-group">
                                    <div class="table-responsive">
									<table class="table table-responsive table-bordered table-striped table-hover" id="tabla_ingresar_6" name="tabla_ingresar_6" style="text-align:center;">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
												<th style="font-size: .9em;">PROYECTO</th>
												<th style="font-size: .9em;">CONDOMINIO</th>
                                                <th style="font-size: .9em;">LOTE</th>
                                                <th style="font-size: .9em;">GERENTE</th>
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

var getInfo1 = new Array(6);
var getInfo2 = new Array(6);

$("#tabla_ingresar_6").ready( function(){

    $('#tabla_ingresar_6 thead tr:eq(0) th').each( function (i) {

       if(i != 0 && i != 11){
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if (tabla_6.column(i).search() !== this.value ) {
                tabla_6
                .column(i)
                .search(this.value)
                .draw();
            }
        } );
    }
});
 

tabla_6 = $("#tabla_ingresar_6").DataTable({
	  dom: 'Bfrtip',
      width: 'auto',
  
"language":{ "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
"pageLength": 10,
"bAutoWidth": false,
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
		"data": function( d ){
			var lblStats;

				if(d.tipo_venta==1) {
					lblStats ='<span class="label label-danger">Venta Particular</span>';
				}
				else if(d.tipo_venta==2) {
					lblStats ='<span class="label label-success">Venta normal</span>';
				}
				else if(d.tipo_venta==3) {
					lblStats ='<span class="label label-warning">Bono</span>';
				}
				else if(d.tipo_venta==4) {
					lblStats ='<span class="label label-primary">Donación</span>';
				}
				else if(d.tipo_venta==5) {
					lblStats ='<span class="label label-info">Intercambio</span>';
				}

			return lblStats;
		}
},
{
    "width": "8%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.nombreResidencial+'</p>';
    }
},
{
    "width": "9%",
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
	"width": "25%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.gerente+'</p>';
    }
}, 
{
    "width": "25%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
    }
}, 
{ 
    "width": "30%",
    "orderable": false,
    "data": function( data ){

		var cntActions;

		if(data.idStatusContratacion == 5 && data.idMovimiento == 35 && data.perfil == 'contraloria' && getFileExtension(data.expediente) == 'xlxs' ||
			data.idStatusContratacion == 2 && data.idMovimiento == 62 && data.perfil == 'asesor' && getFileExtension(data.expediente) == 'xlxs')
		{
			    cntActions = '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
				'class="regCorrElab btn btn-success btn-round btn-fab btn-fab-mini" title="Registrar estatus">' +
				'<span class="material-icons">thumb_up</span></button>&nbsp;&nbsp;';

				cntActions += '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
				'class="rechazoCorrida btn btn-danger btn-round btn-fab btn-fab-mini" title="Rechazar estatus">' +
				'<span class="material-icons">thumb_down</span></button>';

		}
		else if(data.idStatusContratacion == 5 && data.idMovimiento == 35 && data.perfil == 'contraloria' && getFileExtension(data.expediente) != 'xlxs' ||
			data.idStatusContratacion == 2 && data.idMovimiento == 62 && (data.perfil == 'asesor' || data.perfil == 'contraloria') && getFileExtension(data.expediente) != 'xlxs')
		{
			    cntActions = '<button data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
				'class="btn btn-primary btn-round btn-fab btn-fab-mini noCorrida" title="Información"><i class="material-icons">priority_high</i></button>&nbsp;&nbsp;';

				cntActions += '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
				'class="regCorrElab btn btn-success btn-round btn-fab btn-fab-mini" title="Registrar estatus">' +
				'<span class="material-icons">thumb_up</span></button>&nbsp;&nbsp;';

				cntActions += '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
				'class="rechazoCorrida btn btn-danger btn-round btn-fab btn-fab-mini" title="Rechazar estatus">' +
				'<span class="material-icons">thumb_down</span></button>';

		}
		else if(data.idStatusContratacion == 5 && data.idMovimiento == 22 && data.perfil == 'juridico')
		{


			cntActions = '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
				'class="regRevCorr btn btn-warning btn-round btn-fab btn-fab-mini" title="Enviar estatus a Revisión">' +
				'<span class="material-icons">thumb_up</span></button>&nbsp;&nbsp;';

			cntActions += '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
				'class="rechazoCorrida btn btn-danger btn-round btn-fab btn-fab-mini" title="Rechazar estatus">' +
				'<span class="material-icons">thumb_down</span></button>';


		}
		else if(data.idStatusContratacion == 5 && data.idMovimiento == 75 && data.perfil == 'contraloria')
		{
	
			cntActions = '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
				'class="revStaCE btn btn-warning btn-round btn-fab btn-fab-mini" title="Enviar estatus a Revisión">' +
				'<span class="material-icons">thumb_up</span></button>&nbsp;&nbsp;';
	
		}
		else
		{
			cntActions = 'N/A';
		}

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
    "url": url2 + "contraloria/getregistroStatus6ContratacionContraloria",
    "dataSrc": "",
    "type": "POST",
    cache: false,
    "data": function( d ){
    }
},
"order": [[ 1, 'asc' ]]

});


    $('#tabla_ingresar_6 tbody').on('click', 'td.details-control', function () {
			 var tr = $(this).closest('tr');
			 var row = tabla_6.row(tr);

			 if (row.child.isShown()) {
				 row.child.hide();
				 tr.removeClass('shown');
				 $(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
			 } else {
				 var status;
				 var fechaVenc;
				 if (row.data().idStatusContratacion == 5 && row.data().idMovimiento == 35) {
					 status = 'Status 5 listo (Contraloría) ';
				 } else if (row.data().idStatusContratacion == 2 && row.data().idMovimiento == 62) {
					 status = 'Status 2 enviado a Revisión (Asesor)';
				 } else if (row.data().idStatusContratacion == 5 && row.data().idMovimiento == 22) {
					 status = 'Status 6 Rechazado (Juridico) ';
				 } else if (row.data().idStatusContratacion == 5 && row.data().idMovimiento == 75) {
					 status = 'Status enviado a revisión (Contraloria)';
				 }
				 if (row.data().idStatusContratacion == 5 && row.data().idMovimiento == 22 ||
					 row.data().idStatusContratacion == 5 && row.data().idMovimiento == 75) {
					 fechaVenc = 'vencido';
				 } else if (row.data().idStatusContratacion == 5 && row.data().idMovimiento == 35 ||
					 row.data().idStatusContratacion == 2 && row.data().idMovimiento == 62) {
					 fechaVenc = row.data().fechaVenc;
				 }
				 
				 var informacion_adicional = '<table class="table text-justify">' +
					 '<tr><b>INFORMACIÓN ADICIONAL</b>:' +
					 '<td style="font-size: .8em"><strong>ESTATUS: </strong>'+status+'</td>' +
					 '<td style="font-size: .8em"><strong>COMENTARIO: </strong>' + row.data().comentario + '</td>' +
					 '<td style="font-size: .8em"><strong>FECHA VENCIMIENTO: </strong>' + fechaVenc + '</td>' +
					 '<td style="font-size: .8em"><strong>FECHA REALIZADO: </strong>' + row.data().modificado + '</td>' +
					 '<td style="font-size: .8em"><strong>COORDINADOR: </strong>'+row.data().coordinador+'</td>' +
					 '<td style="font-size: .8em"><strong>ASESOR: </strong>'+row.data().asesor+'</td>' +
					 '</tr>' +
					 '</table>';


				 row.child(informacion_adicional).show();
				 tr.addClass('shown');
				 $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
			 }
		 });



		 $("#tabla_ingresar_6 tbody").on("click", ".regRevCorr", function(e){
            e.preventDefault();

            getInfo1[0] = $(this).attr("data-idCliente");
            getInfo1[1] = $(this).attr("data-nombreResidencial");
            getInfo1[2] = $(this).attr("data-nombreCondominio");
            getInfo1[3] = $(this).attr("data-idcond");
            getInfo1[4] = $(this).attr("data-nomlote");
            getInfo1[5] = $(this).attr("data-idLote");
            getInfo1[6] = $(this).attr("data-fecven");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);

            $('#regRevCorrElab').modal('show');

            });



			$("#tabla_ingresar_6 tbody").on("click", ".revStaCE", function(e){
            e.preventDefault();

            getInfo2[0] = $(this).attr("data-idCliente");
            getInfo2[1] = $(this).attr("data-nombreResidencial");
            getInfo2[2] = $(this).attr("data-nombreCondominio");
            getInfo2[3] = $(this).attr("data-idcond");
            getInfo2[4] = $(this).attr("data-nomlote");
            getInfo2[5] = $(this).attr("data-idLote");
            getInfo2[6] = $(this).attr("data-fecven");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);

            $('#regRevA7').modal('show');

            });




});

	function getFileExtension(filename) {
		return filename.split('.').pop();
	}


	/*regisgtrar Corrida*/
	$(document).on('click', '.regCorrElab', function () {
		var idLote = $(this).attr("data-idLote");
		var nomLote = $(this).attr("data-nomLote");

		$('#nombreLoteregCor').val($(this).attr('data-nomLote'));
		$('#idLoteregCor').val($(this).attr('data-idLote'));
		$('#idCondominioregCor').val($(this).attr('data-idCond'));
		$('#idClienteregCor').val($(this).attr('data-idCliente'));
		$('#fechaVencregCor').val($(this).attr('data-fecVen'));
		$('#nomLoteFakeEregCor').val($(this).attr('data-nomLote'));

		nombreLote = $(this).data("nomlote");
		$(".lote").html(nombreLote);
		$('#regCorrElab').modal();

	});

	function preguntaRegCorr() {

		var idLote = $("#idLoteregCor").val();
		var idCondominio = $("#idCondominioregCor").val();
		var nombreLote = $("#nombreLoteregCor").val();
		var idStatusContratacion = $("#idStatusContratacionregCor").val();
		var idCliente = $("#idClienteregCor").val();
		var fechaVenc = $("#fechaVencregCor").val();
		var comentario = $("#comentarioregCor").val();


		var parametros = {
			"idLote": idLote,
			"idCondominio": idCondominio,
			"nombreLote": nombreLote,
			"idStatusContratacion": idStatusContratacion,
			"idCliente": idCliente,
			"fechaVenc": fechaVenc,
			"comentario": comentario
		};


		if (comentario.length <= 0 ) {

			alerts.showNotification('top', 'right', 'Ingresa un comentario.', 'danger');

		} else if (comentario.length > 0) {

		     	$('#enviarAContraloriaGuardar').prop('disabled', true);
				$.ajax({
					data: parametros,
					url: '<?=base_url()?>index.php/Contraloria/editar_registro_lote_contraloria_proceceso6/',
					type: 'POST',
					success: function(data){
              response = JSON.parse(data);
                if(response.message == 'OK') {
					$('#enviarAContraloriaGuardar').prop('disabled', false);
					$('#regCorrElab').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
					$('#enviarAContraloriaGuardar').prop('disabled', false);
					$('#regCorrElab').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
					$('#enviarAContraloriaGuardar').prop('disabled', false);
					$('#regCorrElab').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
              },
              error: function( data ){
			    	$('#enviarAContraloriaGuardar').prop('disabled', false);
		 			$('#rechazregCorrElabarStatus').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
			  }
			  
			});

		}

	}

	/*rechazar corrida*/
	$(document).on('click', '.rechazoCorrida', function (e) {
		idLote = $(this).data("idlote");
		nombreLote = $(this).data("nomlote");
		$('#idClienterechCor').val($(this).attr('data-idCond'));
		$('#idCondominiorechCor').val($(this).attr('data-idCliente'));
		$(".lote").html(nombreLote);


		$('#rechazarStatus').modal();
		e.preventDefault();
	});

	$("#guardar").click(function () {

		var motivoRechazo = $("#motivoRechazo").val();
		var idCondominioR = $("#idClienterechCor").val();
		var idClienteR = $("#idCondominiorechCor").val();


		parametros = {
			"idLote": idLote,
			"nombreLote": nombreLote,
			"motivoRechazo": motivoRechazo,
			"idCliente" : idClienteR,
			"idCondominio" : idCondominioR
		};


		if (motivoRechazo.length <= 0 ) {

		alerts.showNotification('top', 'right', 'Ingresa un comentario.', 'danger');

		} else if (motivoRechazo.length > 0) {

		$('#guardar').prop('disabled', true);
		$.ajax({
			url: '<?=base_url()?>index.php/Contraloria/editar_registro_loteRechazo_contraloria_proceceso6/',
			type: 'POST',
			data: parametros,
			success: function(data){
              response = JSON.parse(data);
                if(response.message == 'OK') {
					$('#guardar').prop('disabled', false);
					$('#rechazarStatus').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
					$('#guardar').prop('disabled', false);
					$('#rechazarStatus').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
					$('#guardar').prop('disabled', false);
					$('#rechazarStatus').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
              },
              error: function( data ){
     				botonEnviar.disabled = false;
					$('#rechazarStatus').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
              }
		});
	  }
	});

	/*modal para informar que no hay corrida*/
	$(document).on('click', '.noCorrida', function(e){
		nombreLote = $(this).data("nomlote");
		$(".lote").html(nombreLote);
		$('#infoNoCorrida').modal();
		e.preventDefault();
	});





$(document).on('click', '#save1', function(e) {
e.preventDefault();

var comentario = $("#comentario1").val();

var validaComent = ($("#comentario1").val().length == 0) ? 0 : 1;

var dataExp1 = new FormData();

dataExp1.append("idCliente", getInfo1[0]);
dataExp1.append("nombreResidencial", getInfo1[1]);
dataExp1.append("nombreCondominio", getInfo1[2]);
dataExp1.append("idCondominio", getInfo1[3]);
dataExp1.append("nombreLote", getInfo1[4]);
dataExp1.append("idLote", getInfo1[5]);
dataExp1.append("comentario", comentario);
dataExp1.append("fechaVenc", getInfo1[6]);


      if (validaComent == 0) {
				alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
	  }
	  
      if (validaComent == 1) {

        $('#save1').prop('disabled', true);   
            $.ajax({
              url : '<?=base_url()?>index.php/Contraloria/editar_registro_loteRevision_contraloria_proceceso6/',
              data: dataExp1,
              cache: false,
              contentType: false,
              processData: false,
              type: 'POST', 
              success: function(data){
              response = JSON.parse(data);

                if(response.message == 'OK') {
                    $('#save1').prop('disabled', false);
                    $('#regRevCorrElab').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save1').prop('disabled', false);
                    $('#regRevCorrElab').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save1').prop('disabled', false);
                    $('#regRevCorrElab').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
              },
              error: function( data ){
                    $('#save1').prop('disabled', false);
                    $('#regRevCorrElab').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
              }
		    });
		
      }

});





$(document).on('click', '#save2', function(e) {
e.preventDefault();

var comentario = $("#comentario2").val();

var validaComent = ($("#comentario2").val().length == 0) ? 0 : 1;

var dataExp2 = new FormData();

dataExp2.append("idCliente", getInfo2[0]);
dataExp2.append("nombreResidencial", getInfo2[1]);
dataExp2.append("nombreCondominio", getInfo2[2]);
dataExp2.append("idCondominio", getInfo2[3]);
dataExp2.append("nombreLote", getInfo2[4]);
dataExp2.append("idLote", getInfo2[5]);
dataExp2.append("comentario", comentario);
dataExp2.append("fechaVenc", getInfo2[6]);


      if (validaComent == 0) {
				alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
	  }
	  
      if (validaComent == 1) {

        $('#save2').prop('disabled', true);   
            $.ajax({
              url : '<?=base_url()?>index.php/Contraloria/editar_registro_loteRevision_contraloria6_AJuridico7/',
              data: dataExp2,
              cache: false,
              contentType: false,
              processData: false,
              type: 'POST', 
              success: function(data){
              response = JSON.parse(data);

                if(response.message == 'OK') {
                    $('#save2').prop('disabled', false);
                    $('#regRevA7').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save2').prop('disabled', false);
                    $('#regRevA7').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save2').prop('disabled', false);
                    $('#regRevA7').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
              },
              error: function( data ){
                    $('#save2').prop('disabled', false);
                    $('#regRevA7').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
              }
		    });
		
      }

});









jQuery(document).ready(function(){

	jQuery('#regCorrElab').on('hidden.bs.modal', function (e) {
	jQuery(this).removeData('bs.modal');    
	jQuery(this).find('#comentarioregCor').val('');
	})

	jQuery('#rechazarStatus').on('hidden.bs.modal', function (e) {
	jQuery(this).removeData('bs.modal');    
	jQuery(this).find('#motivoRechazo').val('');
	})


	jQuery('#envARevCE').on('hidden.bs.modal', function (e) {
	jQuery(this).removeData('bs.modal');    
	jQuery(this).find('#comentarioenvARevCE').val('');
	jQuery(this).find('#tipo_ventaenvARevCE').val(null).trigger('change');
	jQuery(this).find('#ubicacion').val(null).trigger('change');
	})

	jQuery('#regRevA7').on('hidden.bs.modal', function (e) {
	jQuery(this).removeData('bs.modal');    
	jQuery(this).find('#comentario2').val('');
	})


})



</script>

