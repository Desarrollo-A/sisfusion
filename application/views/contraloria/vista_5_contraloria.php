<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
    <?php
/*-------------------------------------------------------*/
$datos = array();
	$datos = $datos4;
	$datos = $datos2;
	$datos = $datos3;  
			$this->load->view('template/sidebar', $datos);
 /*--------------------------------------------------------*/
    ?>

	<!-- modal para revision status 5 100% -->


	<div class="modal fade " id="envARevCE" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content" >
				<div class="modal-header">
					<center><h4 class="modal-title"><label>Registro estatus 5 - <b><span class="lote"></span></b></label></h4></center>
				</div>
				<div class="modal-body">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-12">
							<label>Comentario:</label>
							<input type="text" class="form-control" name="comentario" id="comentarioenvARevCE">
                             <br>
						</div>

						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6"
                             id="tipo-venta-options-div" hidden>
							<label id="tvLbl">Tipo de venta</label>
							<select required="required" name="tipo_venta" id="tipo_ventaenvARevCE"
									class="selectpicker" data-style="btn" title="SELECCIONA TIPO VENTA" data-size="7">
							</select>			
						</div>

                        <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6"
                             id="tipo-venta-particular-div" hidden>
                            <h6><b>Tipo de venta particular</b></h6>
                        </div>

						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<label id="tvLbl">Ubicación</label>
							<select required="required" name="ubicacion" id="ubicacion"
									class="selectpicker" data-style="btn" title="SELECCIONA UBICACIÓN" data-size="7">
							</select>
						</div>

						<input type="hidden" name="idLote" id="idLoteenvARevCE" >
						<input type="hidden" name="idCliente" id="idClienteenvARevCE" >
						<input type="hidden" name="idCondominio" id="idCondominioenvARevCE" >
						<input type="hidden" name="fechaVenc" id="fechaVencenvARevCE" >
						<input type="hidden" name="nombreLote" id="nombreLoteenvARevCE"  >
					</div>
				</div>

				<div class="modal-footer"></div>

				<div class="modal-footer">
					<button type="button" id="enviarenvARevCE" onClick="preguntaenvARevCE()" class="btn btn-success"><span class="material-icons" >send</span> </i> Registrar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
				</div>
			</div>
		</div>
	</div>


	<!-- modal para rechazar estatus-->
	<div class="modal fade" id="rechazarStatus" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content" >
			<div class="modal-header">
		        	<center><h4 class="modal-title"><label>Rechazo estatus 5 - <b><span class="lote"></span></b></label></h4></center>
				</div>
				<div class="modal-body">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
				     	<label>Comentario:</label>
						<textarea class="form-control" id="motivoRechazo" rows="3"></textarea>
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



  <!-- modal  ENVIA A ASESOR por rechazo 2-->
  <div class="modal fade" id="rechazarStatus_2" data-backdrop="static" data-keyboard="false">
		  <div class="modal-dialog">
			  <div class="modal-content" > 
					<div class="modal-header">
						  <center><h4 class="modal-title"><label>Rechazo estatus 5 - <b><span class="lote"></span></b></label></h4></center>
					</div>
					<div class="modal-body">
					<label>Comentario:</label>
						  <textarea class="form-control" id="comentario2" rows="3"></textarea>
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
  





  <!-- modal  ENVIA A JURIDICO por rechazo 1-->
  <div class="modal fade" id="envARev2" data-backdrop="static" data-keyboard="false">
		  <div class="modal-dialog">
			  <div class="modal-content" > 
					<div class="modal-header">
						  <center><h4 class="modal-title"><label>Registro estatus 5 - <b><span class="lote"></span></b></label></h4></center>
					</div>
					<div class="modal-body">
					<label>Comentario:</label>
						  <textarea class="form-control" id="comentario1" rows="3"></textarea>
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




    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-expand fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Registro estatus 5</h3>
                                <p class="card-title pl-1">(revisión 100%)</p>
                            </div>
                            <div  class="toolbar">
                                <div class="row">
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="table-responsive">
                                    <table  id="tabla_ingresar_5" name="tabla_ingresar_5"
                                            class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>REFERENCIA</th>
                                                <th>GERENTE</th>
                                                <th>CLIENTE</th>
                                                <th>F.MOD</th>
                                                <th>F.VENC</th>
                                                <th>UC</th>
                                                <th>ACCIONES</th>
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


    <div class="content hide">
        <div class="container-fluid">
            <div class="row">
                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title center-align">Registro estatus 5 (revisión 100%)</h4>
                            <div class="toolbar">
                             </div>
                            <div class="material-datatables"> 

                                <div class="form-group">
                                    <div class="table-responsive">
 
                                        <table class="table table-responsive table-bordered table-striped table-hover"
                                               id="tabla_ingresar_5" name="tabla_ingresar_5" style="text-align:center;">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
												<th style="font-size: .9em;">PROYECTO</th>
												<th style="font-size: .9em;">CONDOMINIO</th>
                                                <th style="font-size: .9em;">LOTE</th>
                                                <th style="font-size: .9em;">GERENTE</th>
                                                <th style="font-size: .9em;">CLIENTE</th>
                                                <th style="font-size: .9em;">F.MOD</th>
                                                <th style="font-size: .9em;">F.VENC</th>
                                                <th style="font-size: .9em;">UC</th>
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
    $('#tabla_ingresar_5 thead tr:eq(0) th').each( function (i) {
        if(i!=0 && i!=1 && i!=11){
        var title = $(this).text();
        $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_ingresar_5').DataTable().column(i).search() !== this.value ) {
                $('#tabla_ingresar_5').DataTable().column(i).search(this.value).draw();
            }
        });
        }
    });

var url = "<?=base_url()?>";
var url2 = "<?=base_url()?>index.php/";
var getInfo1 = new Array(6);
var getInfo2 = new Array(6);



$(document).ready(function(){


	$.post(url + "Contraloria/get_tventa", function(data) {
		var len = data.length;
		for(var i = 0; i<len; i++) {
			var id = data[i]['id_tventa'];
			var name = data[i]['tipo_venta'];
			$("#tipo_ventaenvARevCE").append($('<option>').val(id).text(name.toUpperCase()));
		}
		$("#tipo_ventaenvARevCE").selectpicker('refresh');
	}, 'json');


	$.post(url + "Contraloria/get_sede", function(data) {
		var len = data.length;
		for(var i = 0; i<len; i++) {
			var id = data[i]['id_sede'];
			var name = data[i]['nombre'];
			$("#ubicacion").append($('<option>').val(id).text(name.toUpperCase()));
		}
		$("#ubicacion").selectpicker('refresh');
	}, 'json');





});

$("#tabla_ingresar_5").ready( function(){

    tabla_5 = $("#tabla_ingresar_5").DataTable({
        dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
      width: 'auto',
        buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Registro estatus 5',
                    title:"Registro estatus 5",
                    exportOptions: {
                        columns: [1,2,3,4,5,6,7,8,9,10],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 1:
                                        return 'TIPO';
                                    case 2:
                                        return 'PROYECTO';
                                    case 3:
                                        return 'CONDOMINIO';
                                    case 4:
                                        return 'LOTE';
                                    case 5:
                                        return 'REFERENCIA';
                                    case 6:
                                        return 'GERENTE';
                                    case 7:
                                        return 'CLIENTE';
                                    case 8:
                                        return 'FECHA MODIFICADO';
                                    case 9:
                                        return 'FECHA VENCIMIENTO';
                                    case 10:
                                        return 'UC';
                                }
                            }
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                    className: 'btn buttons-pdf',
                    titleAttr: 'Registro estatus 5',
                    title: "Registro estatus 5",
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: [1,2,3,4,5,6,7,8,9,10],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 1:
                                        return 'TIPO';
                                    case 2:
                                        return 'PROYECTO';
                                    case 3:
                                        return 'CONDOMINIO';
                                    case 4:
                                        return 'LOTE';
                                    case 5:
                                        return 'REFERENCIA';
                                    case 6:
                                        return 'GERENTE';
                                    case 7:
                                        return 'CLIENTE';
                                    case 8:
                                        return 'FECHA MODIFICADO';
                                    case 9:
                                        return 'FECHA VENCIMIENTO';
                                    case 10:
                                        return 'UC';
                                }
                            }
                        }
                    }
                }
            ],
        language: {
            url: "<?=base_url()?>/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
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
    "defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
},

{
    "width": "7%",
		"data": function( d ){
			var lblStats;

			if(d.idMovimiento==4 || d.idMovimiento==74 || d.idMovimiento==93)
			{
				lblStats ='<span class="label label-danger">Correción</span>';
			}
			else
			{
				lblStats ='<span class="label label-success">Nuevo</span>';
			}
			return lblStats;
		}
},
{
	"width": "7%",
	"data": function( d ){
		return '<p class="m-0">' + d.nombreResidencial +'</p>';
	}
},
{
    "width": "8%",
    "data": function( d ){
        return '<p class="m-0">'+(d.nombreCondominio).toUpperCase();+'</p>';
    }
},
{
    "width": "8%",
    "data": function( d ){
        return '<p class="m-0">'+d.nombreLote+'</p>';
	}
},
    {
        "width": "7%",
        "data": function (d) {
            return '<p class="m-0">'+d.referencia+'</p>';
        }
    },
{
	"width": "15%",
    "data": function( d ){
        return '<p class="m-0">'+d.gerente+'</p>';
    }
}, 
{
    "width": "15%",
    "data": function( d ){
        return '<p class="m-0">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
    }
}, 
{
	"width": "10%",
    "data": function( d ){
        return '<p class="m-0">'+d.modificado+'</p>';
    }
}, 
{
	"width": "10%",
    "data": function( d ){ 
				 
				 var fechaVenc;

				 if (d.idStatusContratacion == 2 && d.idMovimiento == 4 || d.idStatusContratacion == 2 && d.idMovimiento == 84) {
					 fechaVenc = d.fechaVenc;
				 } else if (d.idStatusContratacion == 2 && d.idMovimiento == 74 || d.idStatusContratacion == 2 && d.idMovimiento == 93) {
					 fechaVenc = 'Vencido';
				 }
				 else
				 {
					 fechaVenc='N/A';
				 }

        return '<p class="m-0">'+fechaVenc+'</p>';
    }
},
{
	"width": "10%",
    "data": function( d ){
		var lastUc = (d.lastUc == null) ? 'Sin registro' : d.lastUc;
		
        return '<p class="m-0">'+lastUc+'</p>';
    }
}, 
{ 
    "width": "8%",
    "orderable": false,
    "data": function( data ){

		var cntActions;

if(data.vl == '1') {
	cntActions = 'En proceso de Liberación';

} else {
		if(data.idStatusContratacion == 2 && data.idMovimiento == 4 || data.idStatusContratacion == 2 && data.idMovimiento == 84)
		{

			cntActions = '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" title= "Registrar Status" ' +
				'data-tipo-venta="'+data.tipo_venta+'" class="stat5Rev btn-data btn-green" title="Registrar estatus">' +
				'<i class="fas fa-thumbs-up"></i></button>&nbsp;&nbsp;';


			cntActions += '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
				'class="rechazarStatus btn-data btn-warning" title="Rechazar estatus">' +
				'<i class="fas fa-thumbs-down"></i></button>';
		}
		else if(data.idStatusContratacion == 2 && data.idMovimiento == 74  || data.idStatusContratacion == 2 && data.idMovimiento == 93)
		{

			cntActions = '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
				'class="revCont6 btn-data btn-warning" title= "Rechazar Status">' +
				'<i class="fas fa-thumbs-up"></i></button>&nbsp;&nbsp;';

			cntActions += '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
				'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
				'class="edit2 btn-data btn-warning" >' +
				'<i class="fas fa-thumbs-down"></i></button>';
		}
		else
		{
			cntActions = 'N/A';
		}
}
		return '<div class="d-flex justify-center">'+cntActions+'</div>';


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
    "url": url2 + "contraloria/getregistroStatus5ContratacionContraloria",
    "dataSrc": "",
    "type": "POST",
    cache: false,
    "data": function( d ){
    }
},
"order": [[ 1, 'asc' ]]

});



		 $('#tabla_ingresar_5 tbody').on('click', 'td.details-control', function () {
			 var tr = $(this).closest('tr');
			 var row = tabla_5.row(tr);

			 if (row.child.isShown()) {
				 row.child.hide();
				 tr.removeClass('shown');
                 $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
             } else {
				 var status;

				 if (row.data().idStatusContratacion == 2 && row.data().idMovimiento == 4 ||
					 row.data().idStatusContratacion == 2 && row.data().idMovimiento == 74 ||
					 row.data().idStatusContratacion == 2 && row.data().idMovimiento == 93) {
					 status = 'Status 2 enviado a Revisión (Asesor)';
				 } else if (row.data().idStatusContratacion == 2 && row.data().idMovimiento == 84 ) {
					 status = 'Listo status 2 (Asesor)';
				 }
				 else
				 {
				 	status='N/A';
				 }


				 var informacion_adicional2 = '<table class="table text-justify">' +
					 '<tr><b>INFORMACIÓN ADICIONAL</b>:' +
					 '<td style="font-size: .8em"><strong>ESTATUS: </strong>'+status+'</td>' +
					 '<td style="font-size: .8em"><strong>COMENTARIO: </strong>' + row.data().comentario + '</td>' +
					 '<td style="font-size: .8em"><strong>COORDINADOR: </strong>'+row.data().coordinador+'</td>' +
					 '<td style="font-size: .8em"><strong>ASESOR: </strong>'+row.data().asesor+'</td>' +
					 '</tr>' +
					 '</table>';


                 var informacion_adicional = '<div class="container subBoxDetail">';
                 informacion_adicional += '  <div class="row">';
                 informacion_adicional += '      <div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">';
                 informacion_adicional += '          <label><b>Información adicional</b></label>';
                 informacion_adicional += '      </div>';
                 informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>ESTATUS: </b>'+ status +'</label></div>';
                 informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>COMENTARIO: </b> ' + row.data().comentario + '</label></div>';
                 informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>COORDINADOR: </b> ' + row.data().coordinador + '</label></div>';
                 informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>ASESOR: </b> ' + row.data().asesor + '</label></div>';
                 informacion_adicional += '  </div>';
                 informacion_adicional += '</div>';

				 row.child(informacion_adicional).show();
				 tr.addClass('shown');
                 $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
             }
		 });


		 $("#tabla_ingresar_5 tbody").on("click", ".revCont6", function(e){
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


		$("#tabla_ingresar_5 tbody").on("click", ".edit2", function(e){
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

          
          $('#rechazarStatus_2').modal('show');

        });


 
});


	/*modal para enviar a revision corrida elaborada*/
	$(document).on('click', '.stat5Rev', function () {
		var idLote = $(this).attr("data-idLote");
		var nomLote = $(this).attr("data-nomLote");
        const tipoVenta = $(this).attr('data-tipo-venta');
		
		$('#nombreLoteenvARevCE').val($(this).attr('data-nomLote'));
		$('#idLoteenvARevCE').val($(this).attr('data-idLote'));
		$('#idCondominioenvARevCE').val($(this).attr('data-idCond'));
		$('#idClienteenvARevCE').val($(this).attr('data-idCliente'));
		$('#fechaVencenvARevCE').val($(this).attr('data-fecVen'));
		$('#nomLoteFakeenvARevCE').val($(this).attr('data-nomLote'));
		$('#tvLbl').removeClass('hide');

        if (tipoVenta == 1) {
            $('#tipo-venta-options-div').attr('hidden', true);
            $('#tipo-venta-particular-div').attr('hidden', false);
            $('#tipo_ventaenvARevCE').val(tipoVenta);
        } else {
            $('#tipo-venta-options-div').attr('hidden', false);
            $('#tipo-venta-particular-div').attr('hidden', true);
        }

		$('#enviarenvARevCE').removeAttr('onClick', 'preguntaenvARevCE2()');
		$('#enviarenvARevCE').attr('onClick', 'preguntaenvARevCE()');
		$("#comentarioenvARevCE").val('');
		$('#enviarenvARevCE').disabled = false;

		nombreLote = $(this).data("nomlote");

		$(".lote").html(nombreLote);

		$('#envARevCE').modal();

	});
	function preguntaenvARevCE() {
		var idLote = $("#idLoteenvARevCE").val();
		var idCondominio = $("#idCondominioenvARevCE").val();
		var nombreLote = $("#nombreLoteenvARevCE").val();
		var idCliente = $("#idClienteenvARevCE").val();
		var fechaVenc = $("#fechaVencenvARevCE").val();
		var ubicacion = $("#ubicacion").val();
		var comentario = $("#comentarioenvARevCE").val();
		var tipo_venta = $('#tipo_ventaenvARevCE').val();


		var parametros = {
			"idLote": idLote,
			"idCondominio": idCondominio,
			"nombreLote": nombreLote,
			"idCliente": idCliente,
			"fechaVenc": fechaVenc,
			"ubicacion" : ubicacion,
			"comentario": comentario,
			"tipo_venta": tipo_venta
		};


var validatventa = ($("#tipo_ventaenvARevCE").val().trim() == '') ? 0 : 1;
var validaUbicacion = ($("#ubicacion").val().trim() == '') ? 0 : 1;

		if (comentario.length <= 0 ||  validatventa == 0 || validaUbicacion == 0) {

			alerts.showNotification('top', 'right', 'Todos los campos son requeridos', 'danger')

		} else if (comentario.length > 0 && validatventa != 0 && validaUbicacion != 0) {
			
			var botonEnviar = document.getElementById('enviarenvARevCE');
				botonEnviar.disabled = true;
				$.ajax({
					data: parametros,
					url: '<?=base_url()?>index.php/contraloria/editar_registro_lote_contraloria_proceceso5/',
					type: 'POST',
			  success: function(data){
              response = JSON.parse(data);

                if(response.message == 'OK') {
					botonEnviar.disabled = false;
					$('#envARevCE').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
					botonEnviar.disabled = false;
					$('#envARevCE').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
					botonEnviar.disabled = false;
					$('#envARevCE').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
              },
              error: function( data ){
     				botonEnviar.disabled = false;
					$('#envARevCE').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
              }


				});
		

		}

	}



	/*rechazar status5*/
	$(document).on('click', '.rechazarStatus', function (e) {
		idLote = $(this).data("idlote");
		nombreLote = $(this).data("nomlote");
		$('#idClienterechCor').val($(this).attr('data-idCond'));
		$('#idCondominiorechCor').val($(this).attr('data-idCliente'));
		$(".lote").html(nombreLote);
		$('#rechazarStatus').modal();
		e.preventDefault();
	});


	$("#guardar").click(function () {

		var comentario = $("#motivoRechazo").val();
		var idCondominioR = $("#idClienterechCor").val();
		var idClienteR = $("#idCondominiorechCor").val();

		parametros = {
			"idLote": idLote,
			"nombreLote": nombreLote,
			"comentario": comentario,
			"idCliente": idClienteR,
			"idCondominio": idCondominioR
		};

	if (comentario.length <= 0) {

		alerts.showNotification('top', 'right', 'Ingresa un comentario.', 'danger')

	} else if (comentario.length > 0) {
		$('#guardar').prop('disabled', true);
		$.ajax({
			url: '<?=base_url()?>index.php/Contraloria/editar_registro_loteRechazo_contraloria_proceceso5/',
			type: 'POST',
			data: parametros,
			success: function(data){
              response = JSON.parse(data);
                if(response.message == 'OK') {
					$('#guardar').prop('disabled', false);
					$('#rechazarStatus').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
					$('#guardar').prop('disabled', false);
					$('#rechazarStatus').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
					$('#guardar').prop('disabled', false);
					$('#rechazarStatus').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
              },
              error: function( data ){
     				botonEnviar.disabled = false;
					$('#rechazarStatus').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
              }
		});
	 }
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
              url : '<?=base_url()?>index.php/Contraloria/editar_registro_loteRevision_contraloria5_Acontraloria6/',
              data: dataExp1,
              cache: false,
              contentType: false,
              processData: false,
              type: 'POST', 
              success: function(data){
              response = JSON.parse(data);

                if(response.message == 'OK') {
                    $('#save1').prop('disabled', false);
                    $('#envARev2').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save1').prop('disabled', false);
                    $('#envARev2').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save1').prop('disabled', false);
                    $('#envARev2').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
              },
              error: function( data ){
                    $('#save1').prop('disabled', false);
                    $('#envARev2').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
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
              url : '<?=base_url()?>index.php/Contraloria/editar_registro_loteRechazo_contraloria_proceceso5_2/',
              data: dataExp2,
              cache: false,
              contentType: false,
              processData: false,
              type: 'POST', 
              success: function(data){
              response = JSON.parse(data);

                if(response.message == 'OK') {
                    $('#save2').prop('disabled', false);
                    $('#rechazarStatus_2').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save2').prop('disabled', false);
                    $('#rechazarStatus_2').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save2').prop('disabled', false);
                    $('#rechazarStatus_2').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
              },
              error: function( data ){
                    $('#save2').prop('disabled', false);
                    $('#rechazarStatus_2').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
              }
		    });
		
      }

});




jQuery(document).ready(function(){

    jQuery('#rechazarStatus').on('hidden.bs.modal', function (e) {
    jQuery(this).removeData('bs.modal');    
    jQuery(this).find('#motivoRechazo').val('');
    })

    jQuery('#edit2').on('hidden.bs.modal', function (e) {
    jQuery(this).removeData('bs.modal');    
    jQuery(this).find('#motivoRechazo2').val('');
	})
	

    jQuery('#envARevCE').on('hidden.bs.modal', function (e) {
    jQuery(this).removeData('bs.modal');    
	jQuery(this).find('#comentarioenvARevCE').val('');
	jQuery(this).find('#tipo_ventaenvARevCE').val(null).trigger('change');
	jQuery(this).find('#ubicacion').val(null).trigger('change');
	})

	jQuery('#envARev2').on('hidden.bs.modal', function (e) {
    jQuery(this).removeData('bs.modal');    
	jQuery(this).find('#comentario1').val('');
	})

	jQuery('#rechazarStatus_2').on('hidden.bs.modal', function (e) {
    jQuery(this).removeData('bs.modal');    
	jQuery(this).find('#comentario2').val('');
	})

	


})


</script>

