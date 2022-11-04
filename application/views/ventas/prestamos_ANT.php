<body>
<div class="wrapper">

	<?php


	/*if($this->session->userdata('id_rol')=="18")//contraloria
	{


		$dato= array(
			'home' => 0,
			'usuarios' => 0,
			'statistics' => 0,
			'manual' => 0,
			'aparta' => 0,
			'prospectos' => 0,
			'prospectosMktd' => 0,
			'prospectosAlta' => 0,
			'sharedSales' => 0,
			'coOwners' => 0,
			'references' => 0,
			'plazasComisiones'     => 1,
			'nuevasComisiones' => 0,
			'histComisiones' => 0,
			'bulkload' => 0
		);


		//$this->load->view('template/contraloria/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	else
	{
		echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
    }*/
    $datos = array();
    $datos = $datos4;
    $datos = $datos2;
    $datos = $datos3;
    $this->load->view('template/sidebar', $datos);
	?>



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



	<!--<div class="modal fade modal-alertas" id="myModalEspera" role="dialog">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">

				<form method="post" id="form_espera_uno">
					<div class="modal-body"></div>
					<div class="modal-footer"></div>
				</form>
			</div>
		</div>
	</div>-->




	<div class="modal fade modal-alertas" id="miModal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-red">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">PRESTAMOS</h4>
				</div>
				<form method="post" id="form_prestamos">
					<div class="modal-body">
                    
                    <div class="form-group">
                        <label class="label">Puesto del usuario</label>
                    <select class="selectpicker" name="roles" id="roles" required>
                        <option value="">----Seleccionar-----</option>
                        <option value="7">Asesor</option>
                        <option value="9">Coordinador</option>
                        <option value="3">Gerente</option>
                        <option value="2">Sub director</option>      
                    </select>
                    </div>

           
                    <div class="form-group" id="users"></div>

                    <div class="form-group row">

                       <div class="col-md-4">
                       <label class="label">Monto prestado</label>
                        <input class="form-control" type="number" onblur="verificar();" id="monto" name="monto">
    
                       </div>

                       <div class="col-md-4">
                       <label class="label">Numero de pagos</label>
                        <input class="form-control" id="numeroP" type="number" name="numeroP">
                       </div>

                       <div class="col-md-4">
                        <label class="label">Pago</label>
                        <input class="form-control" id="pago" type="text" name="pago" readonly>
                       </div>

                   

                    </div>

                    <div class="form-group">

                        <label class="label">Comentario</label>
                        <textarea id="comentario" name="comentario" class="form-control" rows="3"></textarea>
                        
                    </div>

                    <div class="form-group">

                  <center>
                  <button type="submit" id="btn_abonar" class="btn btn-success">GUARDAR</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal" >CANCELAR</button>

                  </center>
                    </div>

                    </div>
				</form>
			</div>
		</div>
	</div>


	<!--<div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-body"></div>
			</div>
		</div>
	</div>-->




	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-content">
							<div class="row">
								<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="nav-center">
										<ul class="nav nav-pills nav-pills-info nav-pills-icons" role="tablist">
											<!--  <li class="active" style="margin-right: 50px;">
												 <a href="#nuevas-1" role="tab" data-toggle="tab">
													 <i class="fa fa-file-text-o" aria-hidden="true"></i> Nuevas
												 </a>
											 </li> -->
											<!--
																					<li style="margin-right: 50px;">
																						<a href="#dispersadas-1" role="tab" data-toggle="tab">
																							<i class="fa fa-indent" aria-hidden="true"></i> DISPERSADAS
																						</a>
																					</li> -->


										</ul>
									</div>

									<div class="tab-content">

										<div class="tab-pane active" id="nuevas-1">
											<div class="content">
												<div class="container-fluid">
													<div class="row">
														<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
															<div class="card">
																<div class="card-header">

																	<div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
																		<h4 class="card-title">PRESTAMOS</h4>
																		<!--  <p class="category">Las comisiones se encuentran disponibles para enviar a contraloría.</p>  -->                                                           
                                                                      
                                                                    </div>
                                                                    <div class="col-md-12 text-right">
                                                                        <button ype="button" class="btn btn-primary " data-toggle="modal" data-target="#miModal">AGREGAR</button>
                                                                        </div>
                                                                        <label style="color: #0a548b;">&nbsp;Prestamos activos<b>:</b> $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text"  name="totalp" id="totalp"></label>


																</div>
																<div class="card-content">
																	<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
																		<div class="material-datatables">
																			<div class="form-group">
																				<div class="table-responsive">
																					<table class="table table-responsive table-bordered table-striped table-hover" id="tabla_prestamos" name="tabla_prestamos">
																						<thead>
																						<tr>
																							<th style="font-size: .9em;">USUARIO</th>
																							<th style="font-size: .9em;">MONTO</th>
																							<th style="font-size: .9em;">NUM. PAGOS</th>
																							<th style="font-size: .9em;">PAGO CORRESPONDIENTE</th>
																							<th style="font-size: .9em;">ESTATUS</th>
																							<th style="font-size: .9em;">FECHA DE REGISTRO</th>
																							<th style="font-size: .9em;">MÁS</th>
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
											</div>
										</div>

										<!-- ///////////////// -->



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
	var totaPen = 0;
    var tr;
    




	function closeModalEng(){
       // document.getElementById("inputhidden").innerHTML = "";
        document.getElementById("form_prestamos").reset();
     /*   a = document.getElementById('inputhidden');
        padre = a.parentNode;
		padre.removeChild(a);*/
     
    $("#miModal").modal('toggle');
    
}


    $("#form_prestamos").on('submit', function(e){ 
        e.preventDefault();
    let formData = new FormData(document.getElementById("form_prestamos"));
formData.append("dato", "valor");
    $.ajax({
        url: 'savePrestamo',
        data: formData,
        method: 'POST',
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {
            console.log(data);
			if (data == 1) {
                $('#tabla_prestamos').DataTable().ajax.reload(null, false);
                closeModalEng();
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "Prestamo registrado con exito.", "success");
            	document.getElementById("form_abono").reset();
               
            } else if(data == 2) {
                $('#tabla_prestamos').DataTable().ajax.reload(null, false);
                closeModalEng();
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "Pago liquidado.", "warning");
            }else if(data == 3){
                closeModalEng();
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un prestamo activo.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});









	$("#tabla_prestamos").ready( function(){
		let titulos = [];


		$('#tabla_prestamos thead tr:eq(0) th').each( function (i) {
if(  i!=6){
var title = $(this).text();

titulos.push(title);

$(this).html('<input type="text" style="width:100%; background: #003D82; color: white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
$( 'input', this ).on('keyup change', function () {

if (tabla_nuevas.column(i).search() !== this.value ) {
  tabla_nuevas
    .column(i)
    .search(this.value)
    .draw();

    var total = 0;
    var index = tabla_nuevas.rows({ selected: true, search: 'applied' }).indexes();
    var data = tabla_nuevas.rows( index ).data();

    $.each(data, function(i, v){
        total += parseFloat(v.monto);
    });
    var to1 = formatMoney(total);
    document.getElementById("totalp").value = total;
    console.log('fsdf'+total);
}
} );
}
});

$('#tabla_prestamos').on('xhr.dt', function ( e, settings, json, xhr ) {
        var total = 0;
        $.each(json.data, function(i, v){
            total += parseFloat(v.monto);
        });
        var to = formatMoney(total);
        document.getElementById("totalp").value = to;
    });


		tabla_nuevas = $("#tabla_prestamos").DataTable({
			dom: 'Bfrtip',
  "buttons": [
      {
          extend: 'excelHtml5',
          text: 'Excel',
          className: 'btn btn-success',
          titleAttr: 'Excel',
          exportOptions: {
              columns: [0,1,2,3,4,5],
              format: {
                 header:  function (d, columnIdx) {
                     if(columnIdx >= 0){
                      //   return ' '+d +' ';
                        
                                return ' '+titulos[columnIdx] +' ';
                     }  
                    }
                }
            }
        }
    ],
			width: 'auto',
            "ordering": false,
           
            "pageLength": 10,
            "bAutoWidth": false,
            "fixedColumns": true,

			"language":{ "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
		
			"columns": [

				{
					"width": "9%",
					"data": function( d ){
						return '<p style="font-size: .8em"><center>'+d.nombre+'</center></p>';
					}
				},
				{
					"width": "9%",
					"data": function( d ){
						return '<p style="font-size: .8em"><center>$'+formatMoney(d.monto)+'</center></p>';
					}
				},
				{
					"width": "10%",
					"data": function( d ){
						return '<p style="font-size: .8em"><center>'+d.num_pagos+'</center></p>';
					}
				},
				{
					"width": "10%",
					"data": function( d ){
						return '<p style="font-size: .8em"><center>'+formatMoney(d.pago)+'</center></p>';
					}
				},
				{
					"width": "10%",
					"data": function( d ){

                        if(d.estatus == 1){
                            return '<center><span class="label label-danger" style="background:#27AE60">ACTIVO</span><center>';
                        }else{
                            return '<center><span class="label label-danger" style="background:#27AE60">LIQUIDADO</span><center>';
                        }

						
					} 
				},
				{
					"width": "12%",
					"data": function( d ){
						return '<p style="font-size: .8em"><center>'+d.fecha_creacion+'</center></p>';
					}
				},


				{
					"width": "6%",
					"orderable": false,
					"data": function( d ){
					/*	opciones = '<div class="btn-group" role="group">';
						opciones += '<button class="btn btn-just-icon btn-round btn-default" ><i class="material-icons">info</i></button>';


						return opciones + '</div>';*/
						return '';
					}
				}],
			"ajax": {
				"url": url2 + "Comisiones/getPrestamos",
				/*registroCliente/getregistrosClientes*/
				"type": "POST",
				cache: false,
				"data": function( d ){

                }
            },
		});




	});


	//FIN TABLA NUEVA


	// FIN TABLA PAGADAS



	/*function mandar_espera(idLote, nombre) {
		idLoteespera = idLote;
		// link_post2 = "Cuentasxp/datos_para_rechazo1/";
		link_espera1 = "Comisiones/generar comisiones/";
		$("#myModalEspera .modal-footer").html("");
		$("#myModalEspera .modal-body").html("");
		$("#myModalEspera ").modal();
		// $("#myModalEspera .modal-body").append("<div class='btn-group'>LOTE: "+nombre+"</div>");
		$("#myModalEspera .modal-footer").append("<div class='btn-group'><button type='submit' class='btn btn-success'>GENERAR COMISIÓN</button></div>");
	}*/






	// FUNCTION MORE

	$(window).resize(function(){
		tabla_nuevas.columns.adjust();
		tabla_proceso.columns.adjust();
		tabla_pagadas.columns.adjust();
		tabla_otras.columns.adjust();
	});

	function formatMoney( n ) {
		var c = isNaN(c = Math.abs(c)) ? 2 : c,
			d = d == undefined ? "." : d,
			t = t == undefined ? "," : t,
			s = n < 0 ? "-" : "",
			i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
			j = (j = i.length) > 3 ? j % 3 : 0;
		return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	};


    $("#roles").change(function() {
        var parent = $(this).val();

        document.getElementById("users").innerHTML ='';

        $('#users').append(` 
        <label class="label">Usuario</label>   
        <select id="usuarioid" name="usuarioid" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true">
        </select>
        `);
        $.post('getUsuariosRol/'+parent, function(data) {
                        $("#usuarioid").append($('<option disabled>').val("default").text("Seleccione una opción"))
                        var len = data.length;
                        for( var i = 0; i<len; i++)
                        {
                            var id = data[i]['id_usuario'];
                            var name = data[i]['name_user'];
                            // var sede = data[i]['id_sede'];
                            // alert(name);
                            $("#usuarioid").append($('<option>').val(id).attr('data-value', id).text(name));
                        }
                        if(len<=0)
                        {
                        $("#usuarioid").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                        }
                           // $("#usuariosrol").val(v.id_director);
                        $("#usuarioid").selectpicker('refresh');
                    }, 'json'); 
    });

    $("#numeroP").blur(function(){
        let monto = parseFloat($('#monto').val());
        let cantidad = parseFloat($('#numeroP').val());
        let resultado=0;

        if (cantidad < 1 || isNaN(monto)) {
			alerts.showNotification("top", "right", "Debe ingresar una canitdad mayor a 0.", "warning");
			document.getElementById('btn_abonar').disabled=true;
            $('#pago').val(resultado);
        }else{
            //console.log(monto);
        resultado = monto /cantidad;

        $('#pago').val(formatMoney(resultado));
        }
     

});


function verificar(){
    let monto = parseFloat($('#monto').val());
    if(monto < 1 || isNaN(monto)){
        alerts.showNotification("top", "right", "Debe ingresar un monto mayor a 0.", "warning");
        document.getElementById('btn_abonar').disabled=true;
    }else{
		let cantidad = parseFloat($('#numeroP').val());
	
			resultado = monto /cantidad;
        $('#pago').val(formatMoney(resultado));
        document.getElementById('btn_abonar').disabled=false;
        console.log('OK');
		

       
      
    }
}

</script>
   

