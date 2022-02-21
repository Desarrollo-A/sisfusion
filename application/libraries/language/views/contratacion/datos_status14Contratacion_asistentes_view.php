
<body class="">
<div class="wrapper ">
	<?php
		if($this->session->userdata('id_rol')=="16")//contratacion
		{
			$dato = array(
				'home' => 0,
				'listaCliente' => 0,
				'contrato' => 0,
				'documentacion' => 0,
				'corrida' => 0,
				'inventario' => 0,
				'inventarioDisponible' => 0,
				'status8' => 0,
				'status14' => 1,
				'lotesContratados' => 0,
				'ultimoStatus' => 0,
				'lotes45dias' => 0,
				'consulta9Status' => 0,
				'consulta12Status' => 0,
				'gerentesAsistentes' => 0,
				'expedientesIngresados'	=>	0,
				'corridasElaboradas'	=>	0
			);
			//$this->load->view('template/contratacion/sidebar', $dato);
			$this->load->view('template/sidebar', $dato);
		}
		elseif ($this->session->userdata('id_rol') == "6")//ventasAsistentes
		{
			$dato = array(
				'home' => 0,
				'listaCliente' => 0,
				'corridaF' => 0,
				'documentacion' => 0,
				'autorizacion' => 0,
				'contrato' => 0,
				'inventario' => 0,
				'estatus8' => 0,
				'estatus14' => 1,
				'estatus7' => 0,
				'reportes' => 0,
				'estatus9' => 0,
				'disponibles' => 0,
				'asesores' => 0,
				'nuevasComisiones' => 0,
				'histComisiones' => 0,
				'prospectos' => 0,
				'prospectosAlta' => 0
			);
			//$this->load->view('template/ventas/sidebar', $dato);
			$this->load->view('template/sidebar', $dato);
		}
	?>
	<!--Contenido de la página-->
	<div class="content">
        <div class="container-fluid">
 
            <div class="row">
                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title center-align">Registro estatus 14 (Firma Acuse cliente)</h4>
                            <div class="toolbar">
                             </div>
                            <div class="material-datatables"> 

                                <div class="form-group">
                                    <div class="table-responsive">
 
									<table class="table table-responsive table-bordered table-striped table-hover" id="tabla_ingresar_14" name="tabla_ingresar_14" style="text-align:center;">

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



<!-- modal  rechazar A CONTRALORIA 7-->
<div class="modal fade" id="editReg" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content" >
                <div class="modal-header">
                    <center><h4 class="modal-title"><label>Registro estatus 14 - <b><span class="lote"></span></b></label></h4></center>
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




  <!-- modal  ENVIA A JURIDICO por rechazo 1-->
  <div class="modal fade" id="envARev2" data-backdrop="static" data-keyboard="false">
		  <div class="modal-dialog">
			  <div class="modal-content" > 
					<div class="modal-header">
						  <center><h4 class="modal-title"><label>Registro estatus 14 - <b><span class="lote"></span></b></label></h4></center>
					</div>
					<div class="modal-body">
					<label>Comentario:</label>
						  <textarea class="form-control" id="comentario1" rows="3"></textarea>
						  <br>              
					</div>
					<div class="modal-footer">              
						<button type="button" id="save2" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
					</div>
		</div>
	  </div>
	</div>
  
  <!-- modal -->
  









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

$("#tabla_ingresar_14").ready( function(){

$('#tabla_ingresar_14 thead tr:eq(0) th').each( function (i) {

   if(i != 0 && i != 11){
	var title = $(this).text();
	$(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
	$( 'input', this ).on('keyup change', function () {
		if (tabla_14.column(i).search() !== this.value ) {
			tabla_14
			.column(i)
			.search(this.value)
			.draw();
		}
	} );
}
});


tabla_14 = $("#tabla_ingresar_14").DataTable({
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
"width": "10%",
"data": function( d ){
	return '<p style="font-size: .8em">'+d.nombreResidencial+'</p>';
}
},
{
"width": "10%",
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
"width": "20%",
"data": function( d ){
	return '<p style="font-size: .8em">'+d.gerente+'</p>';
}
}, 
{
"width": "20%",
"data": function( d ){
	return '<p style="font-size: .8em">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
}
}, 
{ 
"width": "40%",
"orderable": false,
"data": function( data ){
	var cntActions;

if(data.idStatusContratacion == 13 && data.idMovimiento == 43 && data.perfil == 'contraloria')
{
		cntActions = '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
		 'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" data-code="'+data.cbbtton+'" ' +
		 'class="btn btn-success btn-round btn-fab btn-fab-mini editReg" title="Registrar estatus">' +
		 '<span class="material-icons">thumb_up</span></button>&nbsp;&nbsp;';

}
else if(data.idStatusContratacion == 13 && data.idMovimiento == 68 && data.perfil == 'contraloria')
{
	cntActions = '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
				'class="revCont btn btn-warning btn-round btn-fab btn-fab-mini" title= "Rechazar Status">' +
				'<span class="material-icons">thumb_up</span></button>&nbsp;&nbsp;';

}
else
{
	cntActions ='N/A';
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
"url": '<?=base_url()?>index.php/Asistente_gerente/getStatCont14',
"dataSrc": "",
"type": "POST",
cache: false,
"data": function( d ){
}
},
"order": [[ 1, 'asc' ]]

});

$('#tabla_ingresar_14 tbody').on('click', 'td.details-control', function () {
		 var tr = $(this).closest('tr');
		 var row = tabla_14.row(tr);

		 if (row.child.isShown()) {
			 row.child.hide();
			 tr.removeClass('shown');
			 $(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
		 } else {
			     var status;
				 var fechaVenc;

						if(row.data().idStatusContratacion==13 && row.data().idMovimiento==43){
						    status= "Status 13 listo (Contraloría)";
							} else if(row.data().idStatusContratacion==13 && row.data().idMovimiento==68){
							status="Status 14 Rechazado (Contraloría)";
							} else {
							status="N/A";
						}

						if(row.data().idStatusContratacion==13 && row.data().idMovimiento==43){
							fechaVenc = row.data().fechaVenc;
						} else if(row.data().idStatusContratacion==13 && row.data().idMovimiento==68){
							fechaVenc='VENCIDO';
						} else {
							status="N/A";
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





	 $("#tabla_ingresar_14 tbody").on("click", ".editReg", function(e){
            e.preventDefault();

            getInfo1[0] = $(this).attr("data-idCliente");
            getInfo1[1] = $(this).attr("data-nombreResidencial");
            getInfo1[2] = $(this).attr("data-nombreCondominio");
            getInfo1[3] = $(this).attr("data-idcond");
            getInfo1[4] = $(this).attr("data-nomlote");
            getInfo1[5] = $(this).attr("data-idLote");
            getInfo1[6] = $(this).attr("data-fecven");
            getInfo1[7] = $(this).attr("data-code");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);

            $('#editReg').modal('show');

            });


			
		 $("#tabla_ingresar_14 tbody").on("click", ".revCont", function(e){
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

          
          $('#envARev2').modal('show');

        });


});



$(document).on('click', '#save1', function(e) {
e.preventDefault();

var comentario = $("#comentario").val();

var validaComent = ($("#comentario").val().length == 0) ? 0 : 1;

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
		   alerts.showNotification('top', 'right', 'Ingresa un comentario.', 'danger')
	  }
	  
      if (validaComent == 1) {

        $('#save1').prop('disabled', true);
            $.ajax({
              url : '<?=base_url()?>index.php/Asistente_gerente/editar_registro_lote_asistentes_proceceso14/',
              data: dataExp1,
              cache: false,
              contentType: false,
              processData: false,
              type: 'POST', 
              success: function(data){
              response = JSON.parse(data);

                if(response.message == 'OK') {
                    $('#save1').prop('disabled', false);
                    $('#editReg').modal('hide');
                    $('#tabla_ingresar_14').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save1').prop('disabled', false);
                    $('#editReg').modal('hide');
                    $('#tabla_ingresar_14').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save1').prop('disabled', false);
                    $('#editReg').modal('hide');
                    $('#tabla_ingresar_14').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
              },
              error: function( data ){
                    $('#save1').prop('disabled', false);
                    $('#editReg').modal('hide');
                    $('#tabla_ingresar_14').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
              }
		    });
		
      }

});






$(document).on('click', '#save2', function(e) {
e.preventDefault();

var comentario = $("#comentario1").val();

var validaComent = ($("#comentario1").val().length == 0) ? 0 : 1;

var dataExp2 = new FormData();

dataExp2.append("idCliente", getInfo1[0]);
dataExp2.append("nombreResidencial", getInfo1[1]);
dataExp2.append("nombreCondominio", getInfo1[2]);
dataExp2.append("idCondominio", getInfo1[3]);
dataExp2.append("nombreLote", getInfo1[4]);
dataExp2.append("idLote", getInfo1[5]);
dataExp2.append("comentario", comentario);
dataExp2.append("fechaVenc", getInfo1[6]);

      if (validaComent == 0) {
				alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
      }
        
      if (validaComent == 1) {

        $('#save1').prop('disabled', true);
            $.ajax({
              url : '<?=base_url()?>index.php/Asistente_gerente/editar_registro_loteRevision_asistentes_proceceso14/',
              data: dataExp2,
              cache: false,
              contentType: false,
              processData: false,
              type: 'POST', 
              success: function(data){
              response = JSON.parse(data);

                if(response.message == 'OK') {
                    $('#save2').prop('disabled', false);
                    $('#envARev2').modal('hide');
                    $('#tabla_ingresar_14').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save2').prop('disabled', false);
                    $('#envARev2').modal('hide');
                    $('#tabla_ingresar_14').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save2').prop('disabled', false);
                    $('#envARev2').modal('hide');
                    $('#tabla_ingresar_14').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
              },
              error: function( data ){
                    $('#save2').prop('disabled', false);
                    $('#envARev2').modal('hide');
                    $('#tabla_ingresar_14').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
              }
		    });
		
      }

});




jQuery(document).ready(function(){

	jQuery('#editReg').on('hidden.bs.modal', function (e) {
	jQuery(this).removeData('bs.modal');
	jQuery(this).find('#comentario').val('');
	})

	jQuery('#envARev2').on('hidden.bs.modal', function (e) {
	jQuery(this).removeData('bs.modal');
	jQuery(this).find('#comentario1').val('');
	})


})
 
</script>

