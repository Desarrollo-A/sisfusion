<body>
<div class="wrapper">
	<?php $this->load->view('template/sidebar'); ?>
    
	<div class="content">
		<div class="container-fluid">
			<div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">

						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Consulta de historial <b id="nomLoteHistorial"></b></h4>
						</div>

						<div class="modal-body">
							<div role="tabpanel">
								<ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
									<li role="presentation" class="active"><a href="#changeprocesTab" aria-controls="changeprocesTab" role="tab"
										onclick="javascript:$('#verDet').DataTable().ajax.reload();"	data-toggle="tab">Proceso de contratación</a>
									</li>
									<li role="presentation"><a href="#changelogTab" aria-controls="changelogTab" role="tab" data-toggle="tab"
									onclick="javascript:$('#verDetBloqueo').DataTable().ajax.reload();">Liberación</a>
									</li>
								</ul>
								<!-- Tab panes -->
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="changeprocesTab">
										<div class="row">
											<div class="col-md-12">
												<div class="card card-plain">
													<div class="card-content">
														<table id="verDet" class="table table-bordered table-hover" width="100%" style="text-align:center;">
															<thead>
															<tr>
																<th><center>Lote</center></th>
																<th><center>Status</center></th>
																<th><center>Detalles</center></th>
																<th><center>Comentario</center></th>
																<th><center>Fecha</center></th>
																<th><center>Usuario</center></th>
															</tr>
															</thead>
															<tbody>
															</tbody>
															<tfoot>
															<tr>
																<th><center>Lote</center></th>
																<th><center>Status</center></th>
																<th><center>Detalles</center></th>
																<th><center>Comentario</center></th>
																<th><center>Fecha</center></th>
																<th><center>Usuario</center></th>
															</tr>
															</tfoot>
														</table>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div role="tabpanel" class="tab-pane" id="changelogTab">
							<div class="row">
								<div class="col-md-12">
									<div class="card card-plain">
										<div class="card-content">
														<!--<ul class="timeline timeline-simple" id="changelog"></ul>-->
											<table id="verDetBloqueo" class="table table-bordered table-hover" width="100%" style="text-align:center;">
															<thead>
															<tr>
																<th><center>Lote</center></th>
																<th><center>Precio</center></th>
																<th><center>Fecha Liberación</center></th>
																<th><center>Comentario Liberación</center></th>
																<th><center>Usuario</center></th>
															</tr>
															</thead>
															<tbody>
															</tbody>
															<tfoot>
															<tr>
																<th><center>Lote</center></th>
																<th><center>Precio</center></th>
																<th><center>Fecha Liberación</center></th>
																<th><center>Comentario Liberación</center></th>
																<th><center>Usuario</center></th>
															</tr>
															</tfoot>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
				<input type="hidden" name="prospecto_lbl" id="prospecto_lbl">
			</div>
			<div class="modal-footer">
							<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR </button>
			</div>
		</div>
	</div>
</div>



<div class="content">
	<div class="container-fluid">

		<div class="row">
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="block full">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header card-header-icon" data-background-color="gray" style=" background: linear-gradient(45deg, #AEA16E, #96843D);">
                                        <i class="material-icons">list</i>
                                    </div>

                                    <div class="card-content">
                                    	<div class="row">
                                    		<h4 class="card-title"><B>Inventario</B> Lotes</h4>
                                    		<div class="container-fluid" style="padding: 20px 20px;">
                                    			<div class="row col col-xs-12 col-sm-12 col-md-12 col-lg-12">

									<div class="col-md-4 form-group">
										<label for="proyecto">Proyecto: </label>
										<select name="proyecto" id="proyecto" class="selectpicker" data-style="btn btn-second"data-show-subtext="true" data-live-search="true" title="--SELECCIONA PROYECTO--" data-size="7" required>
											<option value="0">-SELECCIONA TODO-</option>
										</select>
									</div>

									<div class="col-md-4 form-group">
										<label for="condominio">Condominio: </label>
										<select name="condominio" id="condominio" class="selectpicker" data-style="btn btn-second"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA CONDOMINIO -</option></select>
									</div>

									<div class="col-md-4 form-group">
										<label for="estatus">Estatus: </label>
										<select name="estatus" id="estatus" class="selectpicker" data-style="btn btn-second" data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA ESTATUS -</option></select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-content" style="padding: 50px 20px;">
							<div class="material-datatables">
							<table class="table table-responsive table-bordered table-striped table-hover" id="tabla_inventario_contraloria" name="tabla_inventario_contraloria">

								<thead>
									<tr>
										<th style="font-size: .9em;">PROYECTO</th>
                                        <th style="font-size: .9em;">CONDOMINIO</th>
                                        <th style="font-size: .9em;">LOTE</th>
                                        <th style="font-size: .9em;">SUP</th>
                                        <th style="font-size: .9em;">TOTAL</th>
                                        <th style="font-size: .9em;">M2</th>
                                        <th style="font-size: .9em;">CLIENTE</th>
                                        <th style="font-size: .9em;">REFERENCIA</th>
                                        <th style="font-size: .9em;">MSNI</th>
										<th style="font-size: .9em;">GERENTE</th>
                                        <th style="font-size: .9em;">COORDINADOR</th>
										<th style="font-size: .9em;">ASESOR</th>
                                        <th style="font-size: .9em;">ESTATUS</th>
                                        <th style="font-size: .9em;">FECHA.AP</th>
                                        <th style="font-size: .9em;">COMENTARIO</th>
                                        <th style="font-size: .9em;">ACCIONES</th>
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

    /*$('#tabla_inventario_contraloria thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500;" class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_inventario_contraloria').DataTable().column(i).search() !== this.value ) {
                $('#tabla_inventario_contraloria').DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        } );
    });*/

var url = "<?=base_url()?>";
var url2 = "<?=base_url()?>/index.php/";
//var urlimg = "<?=base_url()?>/img/";

$(document).ready(function(){
	$.post(url + "Contratacion/lista_proyecto", function(data) {
		var len = data.length;
		for(var i = 0; i<len; i++)
		{
			var id = data[i]['idResidencial'];
			var name = data[i]['descripcion'];
			$("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
		}

		$("#proyecto").selectpicker('refresh');
	}, 'json');

	$.post(url + "Contratacion/lista_estatus", function(data) {
		var len = data.length;
		for( var i = 0; i<len; i++)
		{
			var id = data[i]['idStatusLote'];
			var name = data[i]['nombre'];
			$("#estatus").append($('<option>').val(id).text(name.toUpperCase()));
		}
		$("#estatus").selectpicker('refresh');
	}, 'json');
});


$('#proyecto').change( function(){
	index_proyecto = $(this).val();
	$("#condominio").html("");
	$(document).ready(function(){
		$.post(url + "Contratacion/lista_condominio/"+index_proyecto, function(data) {
			var len = data.length;
			$("#condominio").append($('<option disabled selected>- SELECCIONA CONDOMINIO -</option>'));

			for( var i = 0; i<len; i++)
			{
				var id = data[i]['idCondominio'];
				var name = data[i]['nombre'];
				$("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
			}
			$("#condominio").selectpicker('refresh');
		}, 'json');
	});
});

let titulos = [];
$('#tabla_inventario_contraloria thead tr:eq(0) th').each( function (i) {
 if( i!=0 && i!=13){
  var title = $(this).text();

  titulos.push(title);
}
});
$(document).on('change','#proyecto, #condominio, #estatus', function() {
	ix_proyecto = $("#proyecto").val();
   	ix_condominio = $("#condominio").val();
   	ix_estatus = $("#estatus").val();

   	tabla_inventario = $("#tabla_inventario_contraloria").DataTable({
   		destroy: true,
   		"ajax":
   		{
   			"url": '<?=base_url()?>index.php/Contratacion/get_inventario/'+ix_estatus+"/"+ix_condominio+"/"+ix_proyecto,
   			"dataSrc": ""
   		},
		"dom": "Bfrtip",
		"buttons": [
				{
					extend: 'excelHtml5',
                    text: 'Excel',
                    className: 'btn btn-success',
                    titleAttr: 'Excel',
					exportOptions: {
                      columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                      format: {
                         header:  function (d, columnIdx) {
                             if(columnIdx == 0){
                                 return ' '+d +' ';
                                }
                               
                                        return ' '+titulos[columnIdx-1] +' ';
                                  
                            }
                        }
                    }
				} ,
				{
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    className: 'btn btn-danger',
                    titleAttr: 'PDF',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
					exportOptions: {
                      columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                      format: {
                         header:  function (d, columnIdx) {
                             if(columnIdx == 0){
                                 return ' '+d +' ';
                                }
                               
                                        return ' '+titulos[columnIdx-1] +' ';
                                  
                            }
                        }
                    }
				}/*,
				{
					extend: 'copyHtml5',
					text: 'Copiar',
					exportOptions: {
						columns: ':visible'
					}
				},*/
			],
   		"language":{ "url": "<?=base_url()?>/static/spanishLoader.json"},
		"processing": true,
		"pageLength": 10,
		"bAutoWidth": false,
		"bLengthChange": false,
		"scrollX": true,
		"bInfo": true,
		"searching": true,
		"paging": true,
		"ordering": true,
		"fixedColumns": true,
		"columns":
		[{
			"width": "10%",
			data: 'nombreResidencial'
		},
		{
			"width": "10%",
			"data": function(d){
				return '<p>'+(d.nombreCondominio).toUpperCase()+'</p>';
			}
		},
		{
			"width": "14%",
			// data: 'nombreLote'
			"data": function(d){
							return '<p>'+(d.nombreLote).toUpperCase()+'</p>';
			}
		},
		{
			"width": "10%",
			"data": function(d){
				return '<p>'+d.superficie+'<b> m<sup>2</sup></b></p>';
			}
		},
		{
			"width": "10%",
			"data": function(d){
				
		var preciot;				
				
		if(d.nombreResidencial == 'CCMP'){
			
			if(d.idStatusLote != 3){
				var stella;
				var aura;
				var terreno;

				if (d.nombreLote == 'CCMP-LAMAY-011' || d.nombreLote == 'CCMP-LAMAY-021' || d.nombreLote == 'CCMP-LAMAY-030' ||
					d.nombreLote == 'CCMP-LAMAY-031' || d.nombreLote == 'CCMP-LAMAY-032' || d.nombreLote == 'CCMP-LAMAY-045' ||
					d.nombreLote == 'CCMP-LAMAY-046' || d.nombreLote == 'CCMP-LAMAY-047' || d.nombreLote == 'CCMP-LAMAY-054' || 
					d.nombreLote == 'CCMP-LAMAY-064' || d.nombreLote == 'CCMP-LAMAY-079' || d.nombreLote == 'CCMP-LAMAY-080' ||
					d.nombreLote == 'CCMP-LAMAY-090' || d.nombreLote == 'CCMP-LIRIO-010' ||
					
					d.nombreLote == 'CCMP-LIRIO-010' ||
					d.nombreLote == 'CCMP-LIRIO-033' || d.nombreLote == 'CCMP-LIRIO-048' || d.nombreLote == 'CCMP-LIRIO-049' ||
					d.nombreLote == 'CCMP-LIRIO-067' || d.nombreLote == 'CCMP-LIRIO-089' || d.nombreLote == 'CCMP-LIRIO-091' ||
					d.nombreLote == 'CCMP-LIRIO-098' || d.nombreLote == 'CCMP-LIRIO-100') {
					    
						stella = ( parseInt(d.total) + parseInt(2029185) );
						aura = ( parseInt(d.total) + parseInt(1037340) );
					    terreno = parseInt(d.total);

						preciot = '<p>S: $ '+formatMoney(stella)+'</p>' +
						          '<p>A: $ '+formatMoney(aura)+'</p>' +
						          '<p>T: $ '+formatMoney(terreno)+'</p>';


				} else {
					
						stella = ( parseInt(d.total) + parseInt(2104340) );
						aura = ( parseInt(d.total) + parseInt(1075760) );
					    terreno = parseInt(d.total);

						preciot = '<p>S: $ '+formatMoney(stella)+'</p>' +
						          '<p>A: $ '+formatMoney(aura)+'</p>' +
						          '<p>T: $ '+formatMoney(terreno)+'</p>';
				}
			} else if(d.idStatusLote == 3){
			
			preciot = '<p>$ '+formatMoney(d.total)+'</p>';

			}
			
		} else {
		
			preciot = '<p>$ '+formatMoney(d.total)+'</p>';

		}

		return preciot;
						
			}
		},
	    {
			"width": "10%",
			"data": function(d){
				
				
		var preciom2;				
				
		if(d.nombreResidencial == 'CCMP'){
			
			if(d.idStatusLote != 3){
				var stella;
				var aura;
				var terreno;

				if (d.nombreLote == 'CCMP-LAMAY-011' || d.nombreLote == 'CCMP-LAMAY-021' || d.nombreLote == 'CCMP-LAMAY-030' ||
					d.nombreLote == 'CCMP-LAMAY-031' || d.nombreLote == 'CCMP-LAMAY-032' || d.nombreLote == 'CCMP-LAMAY-045' ||
					d.nombreLote == 'CCMP-LAMAY-046' || d.nombreLote == 'CCMP-LAMAY-047' || d.nombreLote == 'CCMP-LAMAY-054' || 
					d.nombreLote == 'CCMP-LAMAY-064' || d.nombreLote == 'CCMP-LAMAY-079' || d.nombreLote == 'CCMP-LAMAY-080' ||
					d.nombreLote == 'CCMP-LAMAY-090' || d.nombreLote == 'CCMP-LIRIO-010' ||
					
					d.nombreLote == 'CCMP-LIRIO-010' ||
					d.nombreLote == 'CCMP-LIRIO-033' || d.nombreLote == 'CCMP-LIRIO-048' || d.nombreLote == 'CCMP-LIRIO-049' ||
					d.nombreLote == 'CCMP-LIRIO-067' || d.nombreLote == 'CCMP-LIRIO-089' || d.nombreLote == 'CCMP-LIRIO-091' ||
					d.nombreLote == 'CCMP-LIRIO-098' || d.nombreLote == 'CCMP-LIRIO-100') {
					     
						stella = ( (parseInt(d.total) + parseInt(2029185)) / d.superficie);
						aura = ( (parseInt(d.total) + parseInt(1037340)) / d.superficie );
					    terreno = (parseInt(d.total) / d.superficie);

						preciom2 = '<p>S: $ '+formatMoney(stella)+'</p>' +
						           '<p>A: $ '+formatMoney(aura)+'</p>' +
						           '<p>T: $ '+formatMoney(terreno)+'</p>';


				} else {
					
						stella = ( (parseInt(d.total) + parseInt(2104340)) / d.superficie );
						aura = ( (parseInt(d.total) + parseInt(1075760)) / d.superficie );
					    terreno = (parseInt(d.total) / d.superficie);

						preciom2 = '<p>S: $ '+formatMoney(stella)+'</p>' +
						           '<p>A: $ '+formatMoney(aura)+'</p>' +
						           '<p>T: $ '+formatMoney(terreno)+'</p>';
				}
			} else if(d.idStatusLote == 3) {
			
			preciom2 = '<p>$ '+formatMoney(d.precio)+'</p>';

			}
			
		} else {
		
			preciom2 = '<p>$ '+formatMoney(d.precio)+'</p>';

		}

		return preciom2;
				
				
			}
		},
        {
            "width": "10%",
            data: 'nombreCliente'
        },
        {
            "width": "10%",
            data: 'referencia'
        },
		{
			"width": "5%",
			data: 'msni'
		},
		{
			"data": function(d){
				var gerente;
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
				{
					if(d.id_rol == 9){
						gerente = myFunctions.validateEmptyField(d.coordinador2);
					} else {
						gerente = myFunctions.validateEmptyField(d.gerente2);
					}
				}
				else
				{
					gerente = myFunctions.validateEmptyField(d.gerente);
				}
				return gerente;
			}
		},
		{
			"data": function(d){
				var coordinador;
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
				{
					if(d.id_rol == 9){
						coordinador = myFunctions.validateEmptyField(d.asesor2);
					} else {
						coordinador = myFunctions.validateEmptyField(d.coordinador2);
					}
				}
				else
				{
					coordinador = myFunctions.validateEmptyField(d.coordinador);
				}
				return coordinador;
			}
		},
		{
			"data": function(d){
				var asesor;
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
				{
					asesor = myFunctions.validateEmptyField(d.asesor2);
				}
				else
				{
					asesor = myFunctions.validateEmptyField(d.asesor);
				}
				return asesor;
			}
		},
		{
			"width": "12%",
			"data": function(d){
				valTV = (d.tipo_venta == null) ? '<center><span class="label label-danger" style="background:#'+d.color+';">'+d.descripcion_estatus+'</span> <center>' :
				'<center><span class="label label-danger" style="background:#'+d.color+';">'+d.descripcion_estatus+'</span> <p><p> <span class="label label-warning";">'+d.tipo_venta+'</span> <center>';

				return valTV;
			}
		},
		{
			"width": "10%",
			"data": function(d){
				
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10){
				  return '<p>'+d.fecha_modst+'</p>';
				} else {
				  return '<p>'+d.fechaApartado+'</p>';

				}
			}
		},
		{
			"width": "16%",
			"data": function(d){
				if(d.comentario=='NULL'||d.comentario=='null'||d.comentario==null){
					return ' - ';
				}
				else
				{
					return '<p>'+d.comentario+'</p>';
				}
			}
		},
		{
			"width": "8%",
			"data": function( d ){
				return '<center><button class="btn  btn-round btn-fab btn-fab-mini to-comment ver_historial" value="' + d.idLote +'" data-nomLote="'+d.nombreLote+'"><i class="material-icons">history_toggle_off</i></button></center>';
			}
		}
		]
	});


    $(window).resize(function(){
    tabla_inventario.columns.adjust();
	});
});
$(document).on("click", ".ver_historial", function(){
	var tr = $(this).closest('tr');
	var row = tabla_inventario.row( tr );
	idLote = $(this).val();
	var $itself = $(this);
	$("#seeInformationModal").on("hidden.bs.modal", function(){
		$("#changeproces").html("");
		$("#changelog").html("");
		$('#nomLoteHistorial').html("");
	});
	$("#seeInformationModal").modal();
	var urlTableFred = '';
	$.getJSON(url+"Contratacion/obtener_liberacion/"+idLote).done( function( data ){
		/*console.log(data[0]['nombreLote']);*/;


		/*if(data.length >= 1)
		{
			$.each( data, function(i, v){
				fillLiberacion(i, v);
			});
		}
		else
		{
			$("#changelog").append('<center>No hay liberaciones para este lote </center>');
		}*/
		urlTableFred = url+"Contratacion/obtener_liberacion/"+idLote;
		fillFreedom(urlTableFred);


	});


	var urlTableHist = '';
	$.getJSON(url+"Contratacion/historialProcesoLoteOp/"+idLote).done( function( data ){
		$('#nomLoteHistorial').html($itself.attr('data-nomLote'));
		/*if(data.length >= 1)
			{*/
				/*$.each( data, function(i, v){
					fillProceso(i, v);
				});*/
				urlTableHist = url+"Contratacion/historialProcesoLoteOp/"+idLote;
				fillHistory(urlTableHist);
			/*}
			else
			{
				$("#changeproces").append('<center>No hay historial para este lote </center>');
			}*/
	});
});

function fillLiberacion (v) {
	$("#changelog").append('<li class="timeline-inverted">\n' +
        '<div class="timeline-badge success"></div>\n' +
        '<div class="timeline-panel">\n' +
        '<label><h5><b>LIBERACIÓN - </b>'+v.nombreLote+'</h5></label><br>\n' +
        '<b>ID:</b> '+v.idLiberacion+'\n' +
        '<br>\n' +
        '<b>Estatus:</b> '+v.estatus_actual+'\n' +
        '<br>\n' +
        '<b>Comentario:</b> '+v.observacionLiberacion+'\n' +
        '<br>\n' +
        '<span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> '+v.nombre+' '+v.apellido_paterno+' '+v.apellido_materno+' - '+v.modificado+'</span>\n' +
        '</h6>\n' +
        '</div>\n' +
        '</li>');
}

function fillProceso (i, v) {
	$("#changeproces").append('<li class="timeline-inverted">\n' +
        '<div class="timeline-badge info">'+(i+1)+'</div>\n' +
        '<div class="timeline-panel">\n' +
		'<b>'+v.nombreStatus+'</b><br><br>\n' +
        '<b>Comentario:</b> \n<p><i>'+v.comentario+'</i></p>\n' +
        '<br>\n' +
        '<b>Detalle:</b> '+v.descripcion+'\n' +
        '<br>\n' +
        '<b>Perfil:</b> '+v.perfil+'\n' +
		'<br>\n' +
        '<b>Usuario:</b> '+v.usuario+'\n' +
        '<br>\n' +
        '<span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> '+v.modificado+'</span>\n' +
        '</h6>\n' +
        '</div>\n' +
        '</li>');

	 // comentario, perfil, modificado,
}


function formatMoney( n ) {
	var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;

        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };

    function fillHistory(urlTableHist)
	{
		tableHistorial = $('#verDet').DataTable( {
			responsive: true,

			dom: 'Bfrtip',
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
			"scrollX": true,
			"pageLength": 10,
			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
			},
			"destroy": true,
			"ordering": false,
			columns: [
				{ "data": "nombreLote" },
				{ "data": "nombreStatus" },
				{ "data": "descripcion" },
				{ "data": "comentario" },
				{ "data": "modificado" },
				{ "data": "usuario" }

			],
			/*"ajax": {
				"url": urlTableHist,//"<?=base_url()?>index.php/registroLote/historialProcesoLoteOp/"
				"type": "POST",
				cache: false,
				"data": function( d ){
					d.idLote = idlote_global;
				}
			},*/
			"ajax":
				{
					"url": urlTableHist,
					"dataSrc": ""
				},
		});
	}
	function fillFreedom(urlTableFred)
	{
		tableHistorialBloqueo = $('#verDetBloqueo').DataTable( {
			responsive: true,

			dom: 'Bfrtip',
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
			"scrollX": true,
			"pageLength": 10,
			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
			},
			"destroy": true,
			"ordering": false,
			columns: [
				{ "data": "nombreLote" },
				{ "data": "precio" },
				{ "data": "modificado" },
				{ "data" : "observacionLiberacion"},
				{ "data": "userLiberacion" }

			],
			/*"ajax": {
				"url": urlTableFred,//<?=base_url()?>index.php/registroLote/historialBloqueos/
				"type": "POST",
				cache: false,
				"data": function( d ){
				}
			},*/
			"ajax":
				{
					"url": urlTableFred,
					"dataSrc": ""
				},
		});
	}
</script>

