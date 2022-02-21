<body>
<div class="wrapper">
	<?php
	$dato= array(
                    'home' => 0,
                    'listaCliente' => 0,
                    'corridaF' => 0,
                    'inventario' => 0,
                    'prospectos' => 0,
                    'prospectosAlta' => 0,
                    'statistic' => 0,
                    'comisiones' => 0,
                    'DS'    => 1,
                    'DSConsult' => 0,
                    'documentacion' => 0,
                    'inventarioDisponible'  =>  0,
                    'manual'    =>  0,
                    'nuevasComisiones'     => 0,
                    'histComisiones'       => 0,
                    'sharedSales' => 0,
                    'coOwners' => 0,
                    'references' => 0,
					'autoriza' => 0,
                    'clientsList' => 0
                );
	//$this->load->view('template/asesor/sidebar', $dato);
	$this->load->view('template/sidebar', $dato);
	?>

	<div class="modal fade" id="modal_aut_ds" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><b>Solicitar</b> autorización.</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h5 class=""></h5>
				</div>
				<form id="my-edit-form" name="my-edit-form" method="post">
					<div class="modal-body">
					</div>

					<div class="modal-footer"></div>
				</form>
			</div>
		</div>
	</div>

<div class="content">
		<div class="container-fluid">

			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">

						<div class="card-header card-header-icon" data-background-color="gray" style=" background: linear-gradient(45deg, #AEA16E, #96843D);">
                                        <i class="material-icons">list</i>
                                    </div>

						<div class="card-content">

							 <h4 class="card-title"><B>Tus ventas</B></h4>
							<div class="toolbar">
								<!--        Here you can write extra buttons/actions for the toolbar              -->
							</div>
							<div class="material-datatables">

								<div class="form-group">
									<div class="table-responsive">
										<!-- 	 Registro de todos los clientes con y sin expediente.  -->

											<table class="table table-responsive table-bordered table-striped table-hover" id="tabla_deposito_seriedad" name="tabla_deposito_seriedad" style="text-align:center;">
												<thead>
													<tr>

												<th style="font-size: .9em;"><center>PROYECTO</center></th>
												<th style="font-size: .9em;"><center>CONDOMINIO</center></th>
												<th style="font-size: .9em;"><center>LOTE</center></th>
												<th style="font-size: .9em;"><center>CLIENTE</center></th>
												<th style="font-size: .9em;"><center>FECHA APARTADO</center></th>
												<th style="font-size: .9em;"><center>FECHA VENCIMIENTO</center></th>
												<th style="font-size: .9em;"><center>COMENTARIO</center></th>
												<th style="font-size: .9em;"><center>EXPEDIENTE</center></th>
												<th style="font-size: .9em;"><center>DS</center></th>

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





<!-- modal  ENVIA A CONTRALORIA 2-->
<div class="modal fade" id="modal1" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content" >
                <div class="modal-header">
                    <center><h4 class="modal-title"><label>Integración de Expediente - <b><span class="lote"></span></b></label></h4></center>
                </div>
                <div class="modal-body">
                    <label>Comentario:</label>
                      <textarea class="form-control" id="comentario" rows="3"></textarea>
                      <br>
                </div>
                <div class="modal-footer">
                    <button type="button" id="save1" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                </div>
        </div>
    </div>
</div>
<!-- modal -->







<!-- modal  ENVIA A CONTRALORIA 5 por rechazo 1-->


<div class="modal fade" id="modal3" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content" >
                  <div class="modal-header">
                       <center><h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 5 Contraloría) - <b><span class="lote"></span></b></label></h4></center>
                  </div>
                  <div class="modal-body">
                    <label>Comentario:</label>
                      <textarea class="form-control" id="comentario3" rows="3"></textarea>
                      <br>
                  </div>
                  <div class="modal-footer">
                  <button type="button" id="save3" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                  </div>
            </div>
        </div>
    </div>

<!-- modal -->



<!-- modal  ENVIA A CONTRALORIA 6 por rechazo 1-->
<div class="modal fade" id="modal4" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content" >
                  <div class="modal-header">
                        <center><h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 6 Contraloría) - <b><span class="lote"></span></b></label></h4></center>
                  </div>
                  <div class="modal-body">
                  <label>Comentario:</label>
                        <textarea class="form-control" id="comentario4" rows="3"></textarea>
                        <br>
                  </div>
                  <div class="modal-footer">
                      <button type="button" id="save4" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                  </div>
      </div>
    </div>
  </div>

<!-- modal -->





<!-- modal  ENVIA A VENTAS 8 por rechazo 1-->

<div class="modal fade" id="modal5" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content" >
                  <div class="modal-header">
                        <center><h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 8 Ventas) - <b><span class="lote"></span></b></label></h4></center>
                  </div>
                  <div class="modal-body">
                  <label>Comentario:</label>
                        <textarea class="form-control" id="comentario5" rows="3"></textarea>
                        <br>
                  </div>
                  <div class="modal-footer">
                      <button type="button" id="save5" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                  </div>
      </div>
    </div>
  </div>

<!-- modal -->








<!-- modal  ENVIA A JURIDICO por rechazo 1-->
<div class="modal fade" id="modal6" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content" >
                  <div class="modal-header">
                        <center><h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 7 Jurídico) - <b><span class="lote"></span></b></label></h4></center>
                  </div>
                  <div class="modal-body">
                  <label>Comentario:</label>
                        <textarea class="form-control" id="comentario6" rows="3"></textarea>
                        <br>
                  </div>
                  <div class="modal-footer">
                      <button type="button" id="save6" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                  </div>
      </div>
    </div>
  </div>

<!-- modal -->





<!-- modal  ENVIA A JURIDICO por rechazo 1-->

<div class="modal fade" id="modal7" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content" >
                  <div class="modal-header">
                        <center><h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 5 Contraloría) - <b><span class="lote"></span></b></label></h4></center>
                  </div>
                  <div class="modal-body">
                  <label>Comentario:</label>
                        <textarea class="form-control" id="comentario7" rows="3"></textarea>
                        <br>
                  </div>
                  <div class="modal-footer">
                      <button type="button" id="save7" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                  </div>
      </div>
    </div>
  </div>


<!-- modal -->


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




var miArray = new Array(6);
var miArrayAddFile = new Array(6);

var getInfo2A = new Array(7);
var getInfo2_2A = new Array(7);
var getInfo5A = new Array(7);
var getInfo6A = new Array(7);
var getInfo2_3A = new Array(7);
var getInfo2_7A = new Array(7);
var getInfo5_2A = new Array(7);


var aut;


	$("#tabla_deposito_seriedad").ready( function(){

		tabla_valores_ds = $("#tabla_deposito_seriedad").DataTable({
			width: 'auto',
			"dom": "Bfrtip",
			buttons: [
            {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF'
            }
        ],
			"pageLength": 10,
			"bAutoWidth": false,
			"fixedColumns": true,
			"ordering": false,
"language": {
"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
   },
   "order": [[4, "desc"]],
   columns: [
        { "data": "nombreResidencial" },
        { "data": "nombreCondominio" },
        { "data": "nombreLote" },
        {
           "data": function( d ){
			return d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno;
          }
        },
        { "data": "fechaApartado" },
        { "data": "fechaVenc" },
        {
          "data": function( d ){

			comentario = d.idMovimiento == 31 ? d.comentario + "<br> <span class='label label-success'>Nuevo apartado</span>":
                    d.idMovimiento == 85 ?  d.comentario + "<br> <span class='label label-danger'>Rechazo Contraloria estatus 2</span>":
                    d.idMovimiento == 20 ?  d.comentario + "<br> <span class='label label-danger'>Rechazo Contraloria estatus 5</span>":
                    d.idMovimiento == 63 ?  d.comentario + "<br> <span class='label label-danger'>Rechazo Contraloria estatus 6</span>":
                    d.idMovimiento == 73 ?  d.comentario + "<br> <span class='label label-danger'>Rechazo Ventas estatus 8</span>":
                    d.idMovimiento == 82 ?  d.comentario + "<br> <span class='label label-danger'>Rechazo Jurídico estatus 7</span>":
                    d.idMovimiento == 92 ?  d.comentario + "<br> <span class='label label-danger'>Rechazo Contraloria estatus 5</span>":
                    d.comentario;
            return comentario;
           }

        },
        {
          "data": function( d ){

         buttonst = d.idMovimiento == 31 ?  '<a href="" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="getInfo2">  <i class="fa fa-check-square-o fa-2x" aria-hidden="true" title= "Enviar estatus"></i></a>':
                    d.idMovimiento == 85 ?  '<a href="" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="getInfo2_2"><i class="fa fa-check-square-o fa-2x" aria-hidden="true" title= "Enviar estatus"></i></a>':
                    d.idMovimiento == 20 ?  '<a href="" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="getInfo5">  <i class="fa fa-check-square-o fa-2x" aria-hidden="true" title= "Enviar estatus"></i></a>':
                    d.idMovimiento == 63 ?  '<a href="" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="getInfo6">  <i class="fa fa-check-square-o fa-2x" aria-hidden="true" title= "Enviar estatus"></i></a>':
                    d.idMovimiento == 73 ?  '<a href="" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="getInfo2_3"><i class="fa fa-check-square-o fa-2x" aria-hidden="true" title= "Enviar estatus"></i></a>':
                    d.idMovimiento == 82 ?  '<a href="" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="getInfo2_7"><i class="fa fa-check-square-o fa-2x" aria-hidden="true" title= "Enviar estatus"></i></a>':
                    d.idMovimiento == 92 ?  '<a href="" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.modificado+'" class="getInfo5_2"><i class="fa fa-check-square-o fa-2x" aria-hidden="true" title= "Enviar estatus"></i></a>':
                    d.comentario;
         return buttonst;

           }

        },
		{
          "data": function( d ){
                    return '<a href="<?=base_url()?>index.php/Asesor/deposito_seriedad/'+d.id_cliente+'/0"><i class="fa fa-print fa-2x" aria-hidden="true" title= "Depósito de seriedad"></i></a>';
            }
        }
                ],

			"ajax": {
				"url": "<?=base_url()?>index.php/Asesor/tableClienteDS/",
				"dataSrc": "",
				"type": "POST",
				cache: false,
				"data": function( d ){
				}
			},

		});



          $("#tabla_deposito_seriedad tbody").on("click", ".getInfo2", function(e){
            e.preventDefault();

          getInfo2A[0] = $(this).attr("data-idCliente");
          getInfo2A[1] = $(this).attr("data-nombreResidencial");
          getInfo2A[2] = $(this).attr("data-nombreCondominio");
          getInfo2A[3] = $(this).attr("data-idCondominio");
          getInfo2A[4] = $(this).attr("data-nombreLote");
          getInfo2A[5] = $(this).attr("data-idLote");
          getInfo2A[6] = $(this).attr("data-fechavenc");

          nombreLote = $(this).data("nomlote");
          $(".lote").html(nombreLote);


          $('#modal1').modal('show');

        });



        $("#tabla_deposito_seriedad tbody").on("click", ".getInfo2_2", function(e){
            e.preventDefault();

          getInfo2_2A[0] = $(this).attr("data-idCliente");
          getInfo2_2A[1] = $(this).attr("data-nombreResidencial");
          getInfo2_2A[2] = $(this).attr("data-nombreCondominio");
          getInfo2_2A[3] = $(this).attr("data-idCondominio");
          getInfo2_2A[4] = $(this).attr("data-nombreLote");
          getInfo2_2A[5] = $(this).attr("data-idLote");
          getInfo2_2A[6] = $(this).attr("data-fechavenc");

          nombreLote = $(this).data("nomlote");
          $(".lote").html(nombreLote);

          $('#modal2').modal('show');

        });


        $("#tabla_deposito_seriedad tbody").on("click", ".getInfo5", function(e){
            e.preventDefault();

            getInfo5A[0] = $(this).attr("data-idCliente");
            getInfo5A[1] = $(this).attr("data-nombreResidencial");
            getInfo5A[2] = $(this).attr("data-nombreCondominio");
            getInfo5A[3] = $(this).attr("data-idCondominio");
            getInfo5A[4] = $(this).attr("data-nombreLote");
            getInfo5A[5] = $(this).attr("data-idLote");
            getInfo5A[6] = $(this).attr("data-fechavenc");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);

          $('#modal3').modal('show');

        });


        $("#tabla_deposito_seriedad tbody").on("click", ".getInfo6", function(e){
            e.preventDefault();

            getInfo6A[0] = $(this).attr("data-idCliente");
            getInfo6A[1] = $(this).attr("data-nombreResidencial");
            getInfo6A[2] = $(this).attr("data-nombreCondominio");
            getInfo6A[3] = $(this).attr("data-idCondominio");
            getInfo6A[4] = $(this).attr("data-nombreLote");
            getInfo6A[5] = $(this).attr("data-idLote");
            getInfo6A[6] = $(this).attr("data-fechavenc");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);


          $('#modal4').modal('show');

        });



        $("#tabla_deposito_seriedad tbody").on("click", ".getInfo2_3", function(e){
            e.preventDefault();

            getInfo2_3A[0] = $(this).attr("data-idCliente");
            getInfo2_3A[1] = $(this).attr("data-nombreResidencial");
            getInfo2_3A[2] = $(this).attr("data-nombreCondominio");
            getInfo2_3A[3] = $(this).attr("data-idCondominio");
            getInfo2_3A[4] = $(this).attr("data-nombreLote");
            getInfo2_3A[5] = $(this).attr("data-idLote");
            getInfo2_3A[6] = $(this).attr("data-fechavenc");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);


          $('#modal5').modal('show');

        });


        $("#tabla_deposito_seriedad tbody").on("click", ".getInfo2_7", function(e){
            e.preventDefault();

            getInfo2_7A[0] = $(this).attr("data-idCliente");
            getInfo2_7A[1] = $(this).attr("data-nombreResidencial");
            getInfo2_7A[2] = $(this).attr("data-nombreCondominio");
            getInfo2_7A[3] = $(this).attr("data-idCondominio");
            getInfo2_7A[4] = $(this).attr("data-nombreLote");
            getInfo2_7A[5] = $(this).attr("data-idLote");
            getInfo2_7A[6] = $(this).attr("data-fechavenc");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);

          $('#modal6').modal('show');

        });



        $("#tabla_deposito_seriedad tbody").on("click", ".getInfo5_2", function(e){
            e.preventDefault();

            getInfo5_2A[0] = $(this).attr("data-idCliente");
            getInfo5_2A[1] = $(this).attr("data-nombreResidencial");
            getInfo5_2A[2] = $(this).attr("data-nombreCondominio");
            getInfo5_2A[3] = $(this).attr("data-idCondominio");
            getInfo5_2A[4] = $(this).attr("data-nombreLote");
            getInfo5_2A[5] = $(this).attr("data-idLote");
            getInfo5_2A[6] = $(this).attr("data-fechavenc");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);

          $('#modal7').modal('show');

        });


});




$(document).on('click', '#save1', function(e) {
e.preventDefault();

var comentario = $("#comentario").val();

var validaComent = ($("#comentario").val().length == 0) ? 0 : 1;

var dataExp1 = new FormData();

dataExp1.append("idCliente", getInfo2A[0]);
dataExp1.append("nombreResidencial", getInfo2A[1]);
dataExp1.append("nombreCondominio", getInfo2A[2]);
dataExp1.append("idCondominio", getInfo2A[3]);
dataExp1.append("nombreLote", getInfo2A[4]);
dataExp1.append("idLote", getInfo2A[5]);
dataExp1.append("comentario", comentario);
dataExp1.append("fechaVenc", getInfo2A[6]);

      if (validaComent == 0) {
				alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
      }

      if (validaComent == 1) {

        $('#save1').prop('disabled', true);
            $.ajax({
              url : '<?=base_url()?>index.php/asesor/intExpAsesor/',
              data: dataExp1,
              cache: false,
              contentType: false,
              processData: false,
              type: 'POST',
              success: function(data){
              response = JSON.parse(data);

                if(response.message == 'OK') {
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
              },
              error: function( data ){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
              }
		    });

      }

});



$(document).on('click', '#save3', function(e) {
  e.preventDefault();

var comentario = $("#comentario3").val();

var validaComent = ($("#comentario3").val().length == 0) ? 0 : 1;

var dataExp3 = new FormData();

dataExp3.append("idCliente", getInfo5A[0]);
dataExp3.append("nombreResidencial", getInfo5A[1]);
dataExp3.append("nombreCondominio", getInfo5A[2]);
dataExp3.append("idCondominio", getInfo5A[3]);
dataExp3.append("nombreLote", getInfo5A[4]);
dataExp3.append("idLote", getInfo5A[5]);
dataExp3.append("comentario", comentario);
dataExp3.append("fechaVenc", getInfo5A[6]);


      if (validaComent == 0) {
			   	alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
      }

      if (validaComent == 1) {
        $('#save3').prop('disabled', true);
            $.ajax({
              url : '<?=base_url()?>index.php/asesor/editar_registro_loteRevision_asistentesAContraloria_proceceso2/',
              data: dataExp3,
              cache: false,
              contentType: false,
              processData: false,
              type: 'POST',
              success: function(data){
              response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save3').prop('disabled', false);
                    $('#modal3').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save3').prop('disabled', false);
                    $('#modal3').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save3').prop('disabled', false);
                    $('#modal3').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
              },
              error: function( data ){
                    $('#save3').prop('disabled', false);
                    $('#modal3').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
              }
            });
      }
});






$(document).on('click', '#save4', function(e) {
  e.preventDefault();

var comentario = $("#comentario4").val();

var validaComent = ($("#comentario4").val().length == 0) ? 0 : 1;

var dataExp4 = new FormData();

dataExp4.append("idCliente", getInfo6A[0]);
dataExp4.append("nombreResidencial", getInfo6A[1]);
dataExp4.append("nombreCondominio", getInfo6A[2]);
dataExp4.append("idCondominio", getInfo6A[3]);
dataExp4.append("nombreLote", getInfo6A[4]);
dataExp4.append("idLote", getInfo6A[5]);
dataExp4.append("comentario", comentario);
dataExp4.append("fechaVenc", getInfo6A[6]);


      if (validaComent == 0) {
             alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
      }

      if (validaComent == 1) {
        $('#save4').prop('disabled', true);
            $.ajax({
              url : '<?=base_url()?>index.php/asesor/editar_registro_loteRevision_asistentesAContraloria6_proceceso2/',
              data: dataExp4,
              cache: false,
              contentType: false,
              processData: false,
              type: 'POST',
              success: function(data){
              response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save4').prop('disabled', false);
                    $('#modal4').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save4').prop('disabled', false);
                    $('#modal4').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save4').prop('disabled', false);
                    $('#modal4').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
              },
              error: function( data ){
                    $('#save4').prop('disabled', false);
                    $('#modal4').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
              }
            });
      }
});



$(document).on('click', '#save5', function(e) {
  e.preventDefault();

var comentario = $("#comentario5").val();

var validaComent = ($("#comentario5").val().length == 0) ? 0 : 1;

var dataExp5 = new FormData();

dataExp5.append("idCliente", getInfo2_3A[0]);
dataExp5.append("nombreResidencial", getInfo2_3A[1]);
dataExp5.append("nombreCondominio", getInfo2_3A[2]);
dataExp5.append("idCondominio", getInfo2_3A[3]);
dataExp5.append("nombreLote", getInfo2_3A[4]);
dataExp5.append("idLote", getInfo2_3A[5]);
dataExp5.append("comentario", comentario);
dataExp5.append("fechaVenc", getInfo2_3A[6]);


      if (validaComent == 0) {
             alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
      }

      if (validaComent == 1) {
        $('#save5').prop('disabled', true);
            $.ajax({
              url : '<?=base_url()?>index.php/asesor/editar_registro_loteRevision_eliteAcontraloria5_proceceso2/',
              data: dataExp5,
              cache: false,
              contentType: false,
              processData: false,
              type: 'POST',
              success: function(data){
              response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save5').prop('disabled', false);
                    $('#modal5').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save5').prop('disabled', false);
                    $('#modal5').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save5').prop('disabled', false);
                    $('#modal5').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
              },
              error: function( data ){
                    $('#save5').prop('disabled', false);
                    $('#modal5').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
              }
            });
      }
});


$(document).on('click', '#save6', function(e) {
  e.preventDefault();

var comentario = $("#comentario6").val();

var validaComent = ($("#comentario6").val().length == 0) ? 0 : 1;

var dataExp6 = new FormData();

dataExp6.append("idCliente", getInfo2_7A[0]);
dataExp6.append("nombreResidencial", getInfo2_7A[1]);
dataExp6.append("nombreCondominio", getInfo2_7A[2]);
dataExp6.append("idCondominio", getInfo2_7A[3]);
dataExp6.append("nombreLote", getInfo2_7A[4]);
dataExp6.append("idLote", getInfo2_7A[5]);
dataExp6.append("comentario", comentario);
dataExp6.append("fechaVenc", getInfo2_7A[6]);


if (validaComent == 0) {
             alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
      }

      if (validaComent == 1) {
        $('#save6').prop('disabled', true);
            $.ajax({
              url : '<?=base_url()?>index.php/asesor/envioRevisionAsesor2aJuridico7/',
              data: dataExp6,
              cache: false,
              contentType: false,
              processData: false,
              type: 'POST',
              success: function(data){
              response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save6').prop('disabled', false);
                    $('#modal6').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save6').prop('disabled', false);
                    $('#modal6').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save6').prop('disabled', false);
                    $('#modal6').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
              },
              error: function( data ){
                    $('#save6').prop('disabled', false);
                    $('#modal6').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
              }
            });
      }
});



$(document).on('click', '#save7', function(e) {
  e.preventDefault();

var comentario = $("#comentario7").val();

var validaComent = ($("#comentario7").val().length == 0) ? 0 : 1;

var dataExp7 = new FormData();

dataExp7.append("idCliente", getInfo5_2A[0]);
dataExp7.append("nombreResidencial", getInfo5_2A[1]);
dataExp7.append("nombreCondominio", getInfo5_2A[2]);
dataExp7.append("idCondominio", getInfo5_2A[3]);
dataExp7.append("nombreLote", getInfo5_2A[4]);
dataExp7.append("idLote", getInfo5_2A[5]);
dataExp7.append("comentario", comentario);
dataExp7.append("fechaVenc", getInfo5_2A[6]);


if (validaComent == 0) {
             alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
      }

      if (validaComent == 1) {
        $('#save7').prop('disabled', true);
            $.ajax({
              url : '<?=base_url()?>index.php/asesor/editar_registro_loteRevision_eliteAcontraloria5_proceceso2_2/',
              data: dataExp7,
              cache: false,
              contentType: false,
              processData: false,
              type: 'POST',
              success: function(data){
              response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save7').prop('disabled', false);
                    $('#modal7').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save7').prop('disabled', false);
                    $('#modal7').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save7').prop('disabled', false);
                    $('#modal7').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
              },
              error: function( data ){
                    $('#save7').prop('disabled', false);
                    $('#modal7').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
              }
            });
      }
});





jQuery(document).ready(function(){


    jQuery('#modal1').on('hidden.bs.modal', function (e) {
    jQuery(this).removeData('bs.modal');
    jQuery(this).find('#comentario').val('');
    })

    jQuery('#modal2').on('hidden.bs.modal', function (e) {
    jQuery(this).removeData('bs.modal');
    jQuery(this).find('#comentario2').val('');
    })

    jQuery('#modal3').on('hidden.bs.modal', function (e) {
    jQuery(this).removeData('bs.modal');
    jQuery(this).find('#comentario3').val('');
    })

    jQuery('#modal4').on('hidden.bs.modal', function (e) {
    jQuery(this).removeData('bs.modal');
    jQuery(this).find('#comentario4').val('');
    })

    jQuery('#modal5').on('hidden.bs.modal', function (e) {
    jQuery(this).removeData('bs.modal');
    jQuery(this).find('#comentario5').val('');
    })

    jQuery('#modal6').on('hidden.bs.modal', function (e) {
    jQuery(this).removeData('bs.modal');
    jQuery(this).find('#comentario6').val('');
    })

    jQuery('#modal7').on('hidden.bs.modal', function (e) {
    jQuery(this).removeData('bs.modal');
    jQuery(this).find('#comentario7').val('');
    })

})


 </script>


