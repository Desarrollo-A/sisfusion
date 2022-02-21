<body>
<div class="wrapper">
	<?php
if($this->session->userdata('id_rol') == 32 || $this->session->userdata('id_rol') == 8){
	switch ($this->session->userdata('id_usuario')) {
		case 1: // corporativa
		case 2815: // admin
			$datos = array();
			$datos = $datos4;
			$datos = $datos2;
			$datos = $datos3;  
			$this->load->view('template/sidebar', $datos);
			break;
		default:
		echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
		break;
    }

}else{
	echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
}
	

?>

<style type="text/css">
	th {
		background: #003D82;
    	color: white;
	}
	.textoshead::placeholder { color: white; }
</style>




<div class="modal fade modal-alertas" id="modal_pagadas" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form method="post" id="form_pagadas">
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade modal-alertas"  id="modal_NEODATA" style="overflow:auto !important;" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form method="post" id="form_NEODATA">
                <div class="modal-body"></div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>

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
						<li role="presentation"><a href="#coSellingAdvisers" aria-controls="coSellingAdvisers" role="tab" data-toggle="tab"
                            onclick="javascript:$('#seeCoSellingAdvisers').DataTable().ajax.reload();">Asesores venta compartida</a>
                        </li>
						<?php 
						$id_rol = $this->session->userdata('id_rol');
						if($id_rol == 11){
						echo '<li role="presentation"><a href="#tab_asignacion" aria-controls="tab_asignacion" role="tab" data-toggle="tab"
                            onclick="fill_data_asignacion();">Asignación</a>
                        </li>';
						}
						?>
						<li role="presentation" class="hide" id="li_individual_sales"><a href="#salesOfIndividuals" aria-controls="salesOfIndividuals" role="tab" data-toggle="tab">Clausulas</a></li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="changeprocesTab">
							<div class="row">
								<div class="col-md-12">
									<div class="card card-plain">
										<div class="card-content">
											<!--<ul class="timeline timeline-simple" id="changeproces"></ul>-->
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
						
						
						<div role="tabpanel" class="tab-pane" id="coSellingAdvisers">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-plain">
                                        <div class="card-content">
                                            <!--<ul class="timeline timeline-simple" id="changelog"></ul>-->
                                            <table id="seeCoSellingAdvisers" class="table table-bordered table-hover" width="100%" style="text-align:center;">
                                                <thead>
                                                <tr>
                                                    <th><center>Asesor</center></th>
                                                    <th><center>Coordinador</center></th>
                                                    <th><center>Gerente</center></th>
                                                    <th><center>Fecha alta</center></th>
                                                    <th><center>Usuario</center></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th><center>Asesor</center></th>
                                                    <th><center>Coordinador</center></th>
                                                    <th><center>Gerente</center></th>
                                                    <th><center>Fecha alta</center></th>
                                                    <th><center>Usuario</center></th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						
						
						<div role="tabpanel" class="tab-pane" id="tab_asignacion">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-plain">
                                        <div class="card-content">
											<div class="form-group">
												<label for="des">Desarrollo</label>
												<select name="sel_desarrollo" id="sel_desarrollo" class="selectpicker" 
												data-style="btn btn-second" data-show-subtext="true" 
												data-live-search="true"  title="" data-size="7" required>
												<option disabled selected>Selecciona un desarrollo</option></select>
											</div>
											<div class="form-group"></div>
											<div class="form-check">
												<input type="checkbox" class="form-check-input" id="check_edo">
												<label class="form-check-label" for="check_edo">Intercambio</label>
											</div>
											<div class="form-group text-right">
												<button type="button" id="save_asignacion" class="btn btn-primary">ENVIAR</button>
											</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="salesOfIndividuals">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-plain">
                                        <div class="card-content">
                                        	<h4 id="clauses_content"></h4>
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


<div class="modal fade" id="modal_avisos" style="overflow-y: scroll;" style="overflow:auto !important;" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" style="font-size: 20px;top:20px;" class="close" data-dismiss="modal">  <i class="large material-icons">close</i></button>

            </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer"></div>
        </div>
    </div>
</div>



<div class="modal fade modal-alertas" id="myUpdateBanderaModal" data-backdrop="static" data-keyboard="false" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header"></div>
            <form method="post" id="my_updatebandera_form">
              <div class="modal-body"></div>
              <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>



<!-- 

    <div class="modal fade" id="myUpdateBanderaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Cambiar estatus</h4>
			</div>
                <form id="my_updatebandera_form" name="my_updatebandera_form" method="post">
                    <div class="modal-body" style="text-align: center;">
                        <input type="hidden" name="id_pagoc" id="id_pagoc">
                        <p class="modal-title"> ¿Está seguro de regresar este lote a dispersión?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div> -->

<div class="modal fade modal-alertas" id="modal_add" style="overflow-y: scroll;" style="overflow:auto !important;" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header"></div>
            <form method="post" id="form_add">
              <div class="modal-body"></div>
              <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade modal-alertas" id="modal_quitar" style="overflow-y: scroll;" style="overflow:auto !important;" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header"></div>
            <form method="post" id="form_quitar">
              <div class="modal-body"></div>
              <div class="modal-footer"></div>
            </form>
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
                                <div class="card-header">
                                  
                                  <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="card-title" >PANEL - <b>INCIDENCIAS</b></h4>
                                    <!-- <p class="category">Historial de todos los bonos y estatus de pago, para ver bonos activos y/o agregar un abono puedes consultarlos en el panel "Bonos"</b></p> -->
                                  </div>



                                    	<div class="col-md-12">
											<div class="col-md-1">
												<br><label>Lote:</label>
											</div>
											<div class="col-md-9">
												<input id="inp_lote" name="inp_lote" class="form-control" type="number" maxlength="6">
											</div>
											<div class="col-md-2">
												<button type="button" class="btn btn-danger find_doc"> Buscar </button>
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
 

                        <div class="card-content">
                                  <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="material-datatables">
                                      <div class="form-group">
                                        <div class="table-responsive">
                                          <table class="table table-responsive table-bordered table-striped table-hover" style="font-size: .7em;" id="tabla_inventario_contraloria" name="tabla_inventario_contraloria">
                                            <thead>
                                            	<tr>
                                                  <th></th>
                                                  <th style="font-size: .9em;">ID LOTE</th>
                                                  <th style="font-size: .9em;">PROYECTO</th>
                                                  <th style="font-size: .9em;">CONDOMINIO</th>
                                                  <th style="font-size: .9em;">LOTE</th>
                                                  <th style="font-size: .9em;">CLIENTE</th>
                                                  <th style="font-size: .9em;">TIPO VENTA</th>
                                                  <th style="font-size: .9em;">MODALIDAD</th>
                                                  <th style="font-size: .9em;">EST. CONTRATACIÓN</th>
                                                  <th style="font-size: .9em;">ENT. VENTA</th>
                                                  <th style="font-size: .9em;">ESTATUS COM.</th>
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
let rol  = "<?=$this->session->userdata('id_rol')?>"
var urlimg = "<?=base_url()?>/img/";
var idLote = 0;

$("#modal_avisos").draggable({
    handle: ".modal-header"
}); 
var getInfo1 = new Array(6);
var getInfo3 = new Array(6);
function replaceAll(text, busca, reemplaza) {
        while (text.toString().indexOf(busca) != -1)
            text = text.toString().replace(busca, reemplaza);
        return text;
    }

    function Confirmacion(i){
        $('#modal_avisos .modal-body').html(''); 
        $('#modal_avisos .modal-body').append(`<h5>¿Seguro que desea topar esta comisión?</h5>
        <br><div class="row"><div class="col-md-12"><center><input type="button" onclick="ToparComision(${i})" id="btn-save" class="btn btn-success" value="GUARDAR"><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>`);
        $('#modal_avisos').modal('show');
  
    }
    function ToparComision(i){
       // $('#modal_avisos').modal('toggle');

        $('#modal_avisos .modal-body').html('');

        let id_comision = $('#id_comision_'+i).val();
        let abonado = replaceAll($('#abonado_'+i).val(), ',','');

        

        $.ajax({
                url: '<?=base_url()?>Comisiones/ToparComision/'+id_comision,
                type: 'post',
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    if(len == 0){
                        $('#comision_total_'+i).val(formatMoney(abonado));
                        let pendiente = parseFloat(abonado - abonado);
                        $('#pendiente_'+i).val(formatMoney(pendiente));
                        $('#modal_avisos .modal-body').append('<b>La comisión total se ajustó con éxito</b>');

                    }else{
let suma = 0;
                        console.log(response);
                    $('#modal_avisos .modal-body').append(`<table class="table table-hover">
                    <thead>
                    <tr>
                    <th>ID pago</th>
                    <th>Monto</th>
                    <th>Usuario</th>
                    <th>Estatus</th>
                    </tr>
                    </thead><tbody>`);
                    for( var j = 0; j<len; j++)
                    {
                        suma = suma + response[j]['abono_neodata'];
                        $('#modal_avisos .modal-body .table').append(`<tr>
                        <td>${response[j]['id_pago_i']}</td>
                        <td>$${formatMoney(response[j]['abono_neodata'])}</td>
                        <td>${response[j]['usuario']}</td>
                        <td>${response[j]['nombre']}</td>
 
                        </tr>`);
                    }
                    $('#modal_avisos .modal-body').append(`</tbody></table>`);
                }
            }
            });
            $('#modal_avisos').modal('show');   


    }

function Editar(i,precio){
    $('#modal_avisos .modal-body').html('');
    let precioLote = parseFloat(precio);
    let nuevoPorce1 = replaceAll($('#porcentaje_'+i).val(), ',',''); 
    let nuevoPorce = replaceAll(nuevoPorce1, '%',''); 
    let  abonado =  replaceAll($('#abonado_'+i).val(), ',','');
    let id_comision = $('#id_comision_'+i).val();
    let id_rol = $('#id_rol_'+i).val();
    let pendiente = replaceAll($('#pendiente_'+i).val(), ',',''); 


    if(id_rol == 1 || id_rol == 2 || id_rol == 3 || id_rol == 9 || id_rol == 38 || id_rol == 45){

        if(parseFloat(nuevoPorce) > 1 || parseFloat(nuevoPorce) < 0){
            $('#porcentaje_'+i).val(1);
            nuevoPorce=1;
            document.getElementById('msj_'+i).innerHTML = 'Debe ingresar un número entre 0 y 1';
        }else{
            document.getElementById('msj_'+i).innerHTML = '';

        }

    }else{
        if(parseFloat(nuevoPorce) > 3 || parseFloat(nuevoPorce) < 0){
            $('#porcentaje_'+i).val(3);
            nuevoPorce=3;
            document.getElementById('msj_'+i).innerHTML = '';
            document.getElementById('msj_'+i).innerHTML = 'Debe ingresar un número entre 0 y 3';
        }else{
            document.getElementById('msj_'+i).innerHTML = '';
        }
    
    }



    let comisionTotal = precioLote * (nuevoPorce / 100);
    console.log(abonado);
    console.log('Comision total:'+comisionTotal);
    $('#btn_'+i).addClass('btn-success');

    if(parseFloat(abonado) > parseFloat(comisionTotal)){
        $('#comision_total_'+i).val(formatMoney(comisionTotal));

        //document.getElementById('btn_'+i).disabled=true;
        $.ajax({

                url: '<?=base_url()?>Comisiones/getPagosByComision/'+id_comision,
                type: 'post',
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    if(len == 0){
                        let nuevoPendient=parseFloat(comisionTotal - abonado);
                    $('#pendiente_'+i).val(formatMoney(nuevoPendient));

                        $('#modal_avisos .modal-body').append('<p>La nueva comisión total <b style="color:green;">$'+formatMoney(comisionTotal)+'</b> es menor a lo abondado, No se encontraron pagos disponibles para eliminar. <b style="color:red;">Aplicar los respectivos descuentos</b></p>');

                    }else{
let suma = 0;
                        console.log(response);
                    $('#modal_avisos .modal-body').append(`<table class="table table-hover">
                    <thead>
                    <tr>
                    <th>ID pago</th>
                    <th>Monto</th>
                    <th>Usuario</th>
                    <th>Estatus</th>
                    </tr>
                    </thead><tbody>`);
                    for( var j = 0; j<len; j++)
                    {
                        suma = suma + response[j]['abono_neodata'];
                        $('#modal_avisos .modal-body .table').append(`<tr>
                        <td>${response[j]['id_pago_i']}</td>
                        <td>$${formatMoney(response[j]['abono_neodata'])}</td>
                        <td>${response[j]['usuario']}</td>
                        <td>${response[j]['nombre']}</td>
                        </tr>`);
                    }
                    $('#modal_avisos .modal-body').append(`</tbody></table>`);
                    let nuevoAbono=parseFloat(abonado-suma);
                    let NuevoPendiente=parseFloat(comisionTotal - nuevoAbono);
                    $('#abonado_'+i).val(formatMoney(nuevoAbono));
                    $('#pendiente_'+i).val(formatMoney(NuevoPendiente));


                    if(nuevoAbono > comisionTotal){

                        $('#modal_avisos .modal-body').append('<p>La nueva comisión total <b style="color:green;">$'+formatMoney(comisionTotal)+'</b> es menor a lo abondado <b>$'+formatMoney(nuevoAbono)+'</b> (ya con los pagos eliminados),Se eliminar los pagos mostrados una vez guardado el cambio. <b style="color:red;">Aplicar los respectivos descuentos</b></p>');

                    }else{
                        $('#modal_avisos .modal-body').append('<p>La nueva comisión total es de <b style="color:green;">$'+formatMoney(comisionTotal)+'</b>, se eliminaran los pagos mostrados una vez guardado el ajuste. El nuevo saldo abonado sera de <b>$'+formatMoney(nuevoAbono)+'</b>. <b>No se requiere aplicar descuentos</b> </p>');

                    }



                    }
                    
                 

                }
            });
        $('#modal_avisos').modal('show');   

console.log('NELSON');
    }else{
        let NuevoPendiente=parseFloat(comisionTotal - abonado);
        $('#pendiente_'+i).val(formatMoney(NuevoPendiente));
        document.getElementById('btn_'+i).disabled=false;
        $('#comision_total_'+i).val(formatMoney(comisionTotal));
        console.log('SIMON');


    }
    
        }

function SaveAjuste(i){
     $('#loader').removeClass('hidden');
     $('#btn_'+i).removeClass('btn-success');
     $('#btn_'+i).addClass('btn-default');

    let id_comision = $('#id_comision_'+i).val();
    let id_usuario = $('#id_usuario_'+i).val();
    let id_lote = $('#idLote').val();
    let porcentaje = $('#porcentaje_'+i).val();
    let comision_total = $('#comision_total_'+i).val();


    // let datos = {
    //     'id_comision':id_comision,
    //     'id_usuario':id_usuario,
    //     'id_lote':id_lote,
    //     'porcentaje':porcentaje,
    //     'comision_total':comision_total
    // }
    var formData = new FormData;
    formData.append("id_comision", id_comision);
    formData.append("id_usuario", id_usuario);
    formData.append("id_lote", id_lote);
    formData.append("porcentaje", porcentaje);
    formData.append("comision_total", comision_total);




    $.ajax({
                url: '<?=base_url()?>Comisiones/SaveAjuste',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success:function(response){
                  
                    $('#loader').addClass('hidden');
alerts.showNotification("top", "right", "Modificación almancenada con éxito.", "success");

                }
            });

}



$('#filtro33').change(function(ruta){
        residencial = $('#filtro33').val();
        $("#filtro44").empty().selectpicker('refresh');
            $.ajax({
                url: '<?=base_url()?>Asesor/getCondominioDesc/'+residencial,
                type: 'post',
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    for( var i = 0; i<len; i++)
                    {
                        var id = response[i]['idCondominio'];
                        var name = response[i]['nombre'];
                        $("#filtro44").append($('<option>').val(id).text(name));
                    }
                    $("#filtro44").selectpicker('refresh');
                    $("#filtro55").selectpicker('refresh');

                }
            });
    });

    $('#filtro44').change(function(ruta){
        conodominio = $('#filtro44').val();
        $("#filtro55").empty().selectpicker('refresh');
            $.ajax({
                url: '<?=base_url()?>Comisiones/lista_lote/'+conodominio,
                type: 'post',
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    for( var i = 0; i<len; i++)
                    {
                        var id = response[i]['idLote'];
                        var name = response[i]['nombreLote'];
                        var totalneto2 = response[i]['totalNeto2'];
                        $("#filtro55").append($('<option>').val(id+','+totalneto2).text(name));
                    }
                    $("#filtro55").selectpicker('refresh');

                }
            });

    });

   

//     function verificar(precio){
//         let precioAnt = parseFloat(precio);
//         let  precioAct =  replaceAll($('#precioL').val(), ',','');

//        // let precioAct = $('#precioL').val();
//         console.log(precioAnt);
//         console.log('-----------');
//         console.log(precioAct);

//         if(rol == 13){
//             if(parseFloat(precioAnt) < parseFloat(precioAct)){
// document.getElementById('btn-save').disabled = false;
// document.getElementById('msj').innerHTML = '';

//         }else{
//             document.getElementById('msj').innerHTML = 'El precio ingresado es menor al actual, verificarlo con sistemas';
//             //alerts.showNotification("top", "right", "El precio ingresado es menor al actual, verificarlo con sistemas.", "warning");
//             document.getElementById('btn-save').disabled = true;
//         }
//         }else{
//             document.getElementById('btn-save').disabled = false;
//             document.getElementById('msj').innerHTML = '';

//         }
       

//     }
    $('#filtro55').change(function(ruta){
        infolote = $('#filtro55').val();
        datos = infolote.split(',');
        idLote = datos[0];
        $.post("<?=base_url()?>index.php/Comisiones/getComisionesLoteSelected/"+idLote, function (data) {
  if( data.length < 1){
    document.getElementById('msj').innerHTML = '';
    document.getElementById('btn-aceptar').disabled  = false;
    var select = document.getElementById("filtro55");
var selected = select.options[select.selectedIndex].text;
       // Lote = $('#filtro55').value;
       let beforelote = $('#natahidden').val();
        
       document.getElementById('nota').innerHTML = 'Se reubicará el lote <b>'+beforelote+'</b> a <b>'+selected+'</b>, una vez aplicado el cambio no se podrá revertir este ajuste';
       $('#comentarioR').val('Se reubicará el lote '+beforelote+' a '+selected+', una vez aplicado el cambio no se podrá revertir este ajuste');
       //alert(selected);
  }else{
      document.getElementById('btn-aceptar').disabled  = true;
      document.getElementById('msj').innerHTML = 'El lote seleccionado tiene comisiones registradas.';
   // alerts.showNotification("top", "right", "El lote seleccionado tiene comisiones registradas.", "warning");

  }
            
        }, 'json');






    });
 

let titulos = [];

$(".find_doc").click( function() {
	var idLote = $('#inp_lote').val();
	tabla_inventario = $("#tabla_inventario_contraloria").DataTable({
   		destroy: true,
   		"ajax":
   		{
   			"url": '<?=base_url()?>index.php/Comisiones/getInCommissions/'+idLote,
   			"dataSrc": ""
   		},
		"dom": "Bfrtip",
		"buttons": [
 
			],
   		width: 'auto',
    "language":{ url: "../static/spanishLoader.json" },
    "pageLength": 10,
    "bAutoWidth": false,
    "fixedColumns": true,
    "ordering": false,
    "destroy": true,
    "columns": [ 


 
{
"width": "3%",
"className": 'details-control',
"orderable": false,
"data" : null,
"defaultContent": '<i class="material-icons" style="color:#003D82;" title="Click para más detalles">play_circle_filled</i>'
},
{
    "width": "5%",
	"data": function( d ){
        var lblStats;
        lblStats ='<p style="font-size: .8em"><b>'+d.idLote+'</b></p>';
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
"width": "8%",
"data": function( d ){
	return '<p style="font-size: .8em">'+(d.nombreCondominio).toUpperCase();+'</p>';
}
},
{
"width": "11%",
"data": function( d ){
	return '<p style="font-size: .8em">'+d.nombreLote+'</p>';

}
}, 
{
"width": "11%",
"data": function( d ){
	return '<p style="font-size: .8em"><b>'+d.nombre_cliente+'</b></p>';

}
}, 
{
"width": "8%",
"data": function( d ){
 
    var lblType;
			if(d.tipo_venta==1) {
				lblType ='<span class="label label-danger">Venta Particular</span>';
			}
			else if(d.tipo_venta==2) {
				lblType ='<span class="label label-success">Venta normal</span>';
			}else{
				lblType ='<span class="label label-warning">SIN TIPO Venta</span>';
			}
        return lblType;
    }
}, 

{
"width": "8%",
"data": function( d ){
    var lblStats;
            if(d.compartida==null) {
                lblStats ='<span class="label label-warning" style="background:#E5D141;">Individual</span>';
            }else {
                lblStats ='<span class="label label-warning">Compartida</span>';
            }
    return lblStats;
}
}, 


{
"width": "8%",
"data": function( d ){
    var lblStats;
    if(d.idStatusContratacion==15) {
        // lblStats ='';
        lblStats ='<span class="label label-success" style="background:#9E9CD5;">Contratado</span>';

    }
    else {
        lblStats ='<p><b>'+d.idStatusContratacion+'</b></p>';

        
    }
    return lblStats;
}
},

{
"width": "8%",
"data": function( d ){
    var lblStats;
 
    if(d.totalNeto2==null) {
            lblStats ='<span class="label label-danger">Sin precio lote</span>';
    }
    else {
        
        switch(d.lugar_prospeccion){
        case '6':
            lblStats ='<span class="label" style="background:#B4A269;">MARKETING DIGÍTAL</span>';
        break;
        
        case '12':
            lblStats ='<span class="label" style="background:#00548C;">CLUB MADERAS</span>';
        break;
        case '25':
            lblStats ='<span class="label" style="background:#0860BA;">IGNACIO GREENHAM</span>';
        break;

        default:
            lblStats ='';
        break;
    }
}
return lblStats;
 
}
},


{
"width": "8%",
"data": function( d ){

	var lblStats = '';

	switch(d.registro_comision){
        case '7':
            lblStats ='<span class="label" style="background:red;">LIQUIDADA</span>';
        break;
        
        case '1':
            lblStats ='<span class="label" style="background:blue;">COMISIÓN ACTIVA</span>';
        break;
        case '8':
            lblStats ='<span class="label" style="color:#0860BA;">NUEVA, rescisión</span>';
        break;

        case '0':
            lblStats ='<span class="label" style="color:#0860BA;">NUEVA, sin dispersar</span>';
        break;

        default:
            lblStats ='';
        break;
    }


  
    return lblStats;
            
 }
}, 


 { 
"width": "14%",
"orderable": false,


"data": function( data ){
    var BtnStats;
    // let btnreubicacion= `<button class="btn btn-info btn-round btn-fab btn-fab-mini reubicar" title="Re-ubicación" data-nombre="${data.nombreLote}" value="${data.idLote}" style="color:#fff;background:#B5AD5E;background-color:#B5AD5E;"><i class="large material-icons" style="font-size:30px;left:40%;">edit_location</i></button>`;

    
    if(data.totalNeto2==null && data.idStatusContratacion > 8 ) {
        BtnStats = '<button class="btn btn-info btn-round btn-fab btn-fab-mini cambiar_precio" title="Cambiar precio" value="' + data.idLote +'" data-precioAnt="'+data.totalNeto2+'" color:#fff;"><i class="material-icons">edit</i></button>';
    }else {
        if(data.registro_comision == 0 || data.registro_comision == 8) {
            BtnStats = '<button class="btn btn-info btn-round btn-fab btn-fab-mini cambiar_precio" title="Cambiar precio" value="' + data.idLote +'" data-precioAnt="'+data.totalNeto2+'" color:#fff;"><i class="material-icons">edit</i></button>';
        }

        else if(data.registro_comision == 7) {
        	BtnStats = '<button class="btn btn-info btn-round btn-fab btn-fab-mini cambiar_precio" title="Cambiar precio" value="' + data.idLote +'" data-precioAnt="'+data.totalNeto2+'" color:#fff;"><i class="material-icons">edit</i></button><button class="btn btn-warning btn-round btn-fab btn-fab-mini update_bandera" title="Cambiar estatus" value="' + data.idLote +'" data-nombre="'+data.nombreLote+'" color:#fff;"><i class="material-icons">autorenew</i></button>';
        }

        else {
        	BtnStats = '<button href="#" value="'+data.idLote+'" data-estatus="'+data.idStatusContratacion+'" data-tipo="I" data-precioAnt="'+data.totalNeto2+'"  data-value="'+data.registro_comision+'" data-code="'+data.cbbtton+'" ' +
			 'class="btn btn-dark btn-round btn-fab btn-fab-mini verify_neodata" title="Verificar en NEODATA"><span class="material-icons">build</span></button><button class="btn btn-info btn-round btn-fab btn-fab-mini cambiar_precio" title="Cambiar precio" value="' + data.idLote +'" data-precioAnt="'+data.totalNeto2+'" color:#fff;"><i class="material-icons">edit</i></button><button class="btn btn-warning btn-round btn-fab btn-fab-mini update_bandera" title="Cambiar estatus" value="' + data.idLote +'" data-nombre="'+data.nombreLote+'" color:#fff;"><i class="material-icons">autorenew</i></button>';  
            }
        }
 
        return BtnStats;
    }
}
]
});



$("#tabla_inventario_contraloria tbody").on("click", ".cambiar_precio", function(){
            var tr = $(this).closest('tr');
            var row = tabla_inventario.row( tr );
            idLote = $(this).val();
            // alert(idLote);
            precioAnt = $(this).attr("data-precioAnt");


            // $("#modal_pagadas .modal-header").html("");
            $("#modal_pagadas .modal-body").html("");

            $("#modal_pagadas .modal-body").append('<h4 class="modal-title">Cambiar precio del lote <b>'+row.data().nombreLote+'</b></h4><br><em>Precio actual: $<b>'+formatMoney(precioAnt)+'</b></em>');
            $("#modal_pagadas .modal-body").append('<input type="hidden" name="idLote" id="idLote" readonly="true" value="'+idLote+'"><input type="hidden" name="precioAnt" id="precioAnt" readonly="true" value="'+precioAnt+'">');
            $("#modal_pagadas .modal-body").append(`<div class="form-group">
            <label>Nuevo precio</label>
            <input type="text" name="precioL" onblur="verificar(${precioAnt})" required id="precioL" class="form-control">
            <p id="msj" style="color:red;"></p>
            </div>`);

            $("#modal_pagadas .modal-body").append('<br><div class="row"><div class="col-md-12"><center><input type="submit" disabled id="btn-save" class="btn btn-success" value="GUARDAR"><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>');
        $("#modal_pagadas").modal();
        });


$("#tabla_inventario_contraloria tbody").on("click", ".verify_neodata", function(e){


	 e.preventDefault();
                e.stopImmediatePropagation();


            var tr = $(this).closest('tr');
            var row = tabla_inventario.row( tr );
            idLote = $(this).val();
            let cadena = '';
            registro_status = $(this).attr("data-value");
            id_estatus = $(this).attr("data-estatus");
            precioAnt = $(this).attr("data-precioAnt");
            tipo = $(this).attr('data-tipo');

            $("#modal_NEODATA .modal-header").html("");
            $("#modal_NEODATA .modal-body").html("");
            $("#modal_NEODATA .modal-footer").html("");
            
            $.getJSON( url + "ComisionesNeo/getStatusNeodata/"+idLote).done( function( data ){
                console.log('NEO');
                console.log(data[0]);
                if(data.length > 0){
                	console.log("entra 1");
                    switch (data[0].Marca) {
                    case '0':
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>En espera de próximo abono en NEODATA de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case '1':
                    
                    if(registro_status==0 || registro_status==8){//COMISION NUEVA

                    }else if(registro_status==1){

                        $.getJSON( url + "Comisiones/getDatosAbonadoSuma11/"+idLote).done( function( data1 ){
                            
                            let total0 = parseFloat((data[0].Aplicado));
                            let total = 0;

                            if(total0 > 0){
                               total = total0;
                            }else{
                               total = 0; 
                            }

                            var counts=0;

                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Precio lote: $'+formatMoney(data1[0].totalNeto2)+'</b></h4></div></div>');
                            if(parseFloat(data[0].Bonificado) > 0){
                            	cadena = '<h4>Bonificación: <b style="color:#D84B16;">$'+formatMoney(data[0].Bonificado)+'</b></h4>';
                            }else{
                            	cadena = '<h4>Bonificación: <b >$'+formatMoney(0)+'</b></h4>';
                            }

                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i> <i>'+row.data().nombreLote+'</i></b></h3></div></div><br>');
                            $.getJSON( url + "Comisiones/getDatosAbonadoDispersion/"+idLote+"/"+1).done( function( data ){
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-2"><p style="font-zise:10px;"><b>USUARIOS</b></p></div><div class="col-md-1"><b>%</b></div><div class="col-md-2"><b>TOT. COMISIÓN</b></div><div class="col-md-2"><b><b>ABONADO</b></div><div class="col-md-2"><b>PENDIENTE</b></div><div class="col-md-3">ACCIONES</div></div>');
                         
                          let contador=0;
                          console.log('gree:'+data.length);

                          for (let index = 0; index < data.length; index++) {
                                    const element = data[index].id_usuario;
                                    if(data[index].id_usuario == 4415){
                                        contador +=1;
                                    }
                                }

                                $.each( data, function( i, v){
                                	$('#btn_'+i).tooltip({ boundary: 'window' })
                                	let nuevosaldo = 0;
                                	let nuevoabono=0;
                                	let evaluar =0;

                                	if(tipo == "I"){
                                		console.log(i);

                                		saldo =0;                           
                                		if(v.rol_generado == 7 && v.id_usuario == 4415){
                                			saldo = (( (v.porcentaje_saldos/2) /100)*(total));
                                			contador +=1;
                                		}else if(v.rol_generado == 7 && contador > 0){
                                			saldo = (( (v.porcentaje_saldos/2) /100)*(total));
                                		}else if(v.rol_generado == 7 && contador == 0){
                                			saldo = ((v.porcentaje_saldos /100)*(total));
                                		}else if(v.rol_generado != 7){
                                			saldo = ((v.porcentaje_saldos /100)*(total));
                                		}

                                		if(v.abono_pagado>0){
                                			console.log("OPCION 1");
                                			evaluar = (v.comision_total-v.abono_pagado);

                                			if(evaluar<1){
                                				pending = 0;
                                				saldo = 0;
                                			}else{
                                				pending = evaluar;
                                			}

                                			resta_1 = saldo-v.abono_pagado;
                                			if(resta_1<1){
                                				saldo = 0;
                                			}else if(resta_1 >= 1){
                                				if(resta_1 > pending){
                                					saldo = pending;
                                				}else{
                                					saldo = saldo-v.abono_pagado;
                                				}
                                			}
                                		}else if(v.abono_pagado<=0){
                                			console.log("OPCION 2");
                                			pending = (v.comision_total);

                                			if(saldo > pending){
                                				saldo = pending;
                                			}
                                			if(pending < 1){
                                				saldo = 0;
                                			}
                                		}
                                	}else{
                                		pending = (v.comision_total-v.abono_pagado);
                                		console.log(v.porcentaje_saldos);
                                		nuevosaldo = 12.5 * v.porcentaje_decimal;
                                		saldo = ((nuevosaldo/100)*(total));
                                		if(v.abono_pagado>0){
                                			console.log("OPCION 1");
                                			evaluar = (v.comision_total-v.abono_pagado);
                                    if(evaluar<1){
                                        pending = 0;
                                        saldo = 0;
                                    }
                                    else{
                                        pending = evaluar;
                                    }
                                    resta_1 = saldo-v.abono_pagado;
                                    if(resta_1<1){
                                        // console.log("entra aqui 1");
                                        saldo = 0;
                                    }
                                    else if(resta_1 >= 1){
                                        // console.log("entra aqui 2");
                                        if(resta_1 > pending){
                                            saldo = pending;
                                        }
                                        else{
                                            saldo = saldo-v.abono_pagado;
                                        }   
                                    }
                                }
                                else if(v.abono_pagado<=0){

                                        console.log("OPCION 2");
                                        pending = (v.comision_total);

                                    if(saldo > pending){
                                        saldo = pending;
                                    }
                                    
                                    if(pending < 1){
                                        saldo = 0;
                                    }
                                }
						        if(saldo > pending){
						            saldo = pending;
						        }
						        
						        if(pending < 1){
						            saldo = 0;
						            pending = 0;
						        }

                            }
                                 

                                $("#modal_NEODATA .modal-body").append(`<div class="row">
                                <div class="col-md-2"><input id="id_disparador" type="hidden" name="id_disparador" value="1"><input type="hidden" name="pago_neo" id="pago_neo" value="${total.toFixed(3)}"><input type="hidden" name="id_rol" id="id_rol_${i}" value="${v.rol_generado}"><input type="hidden" name="pending" id="pending" value="${pending}">
                                <input type="hidden" name="idLote" id="idLote" value="${idLote}"><input id="id_comision_${i}" type="hidden" name="id_comision_${i}" value="${v.id_comision}"><input id="id_usuario_${i}" type="hidden" name="id_usuario_${i}" value="${v.id_usuario}">
                                <input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="${v.colaborador}" style="font-size:12px;"><b><p style="font-size:12px;">${v.rol}</p></b></div>

                                <div class="col-md-1"><input class="form-control ng-invalid ng-invalid-required" id="porcentaje_${i}" ${(v.rol_generado == 1 || v.rol_generado == 2 || v.rol_generado == 3 || v.rol_generado == 9 || v.rol_generado == 45 || v.rol_generado == 38) ? 'max="1"' : 'max="3"'}   onblur="Editar(${i},${precioAnt})" value="${v.porcentaje_decimal}"><br>
                                <b id="msj_${i}" style="color:red;"></b>
                                </div>
                                <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required"  readonly="true" id="comision_total_${i}" value="${formatMoney(v.comision_total)}"></div>
                                
                                <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required"  readonly="true" id="abonado_${i}" value="${formatMoney(v.abono_pagado)}"></div>
                                <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" id="pendiente_${i}" value="${formatMoney(pending)}"></div>
                                
                                <div class="col-md-3">
                                 
                                <button type="button" id="btn_${i}" onclick="SaveAjuste(${i})" data-toggle="tooltip" data-placement="top" title="GUARDAR PORCENTAJE" class="btn btn-dark btn-round btn-fab btn-fab-mini"><span class="material-icons">check</span></button>
                                <button type="button" id="btnTopar_${i}"  data-toggle="tooltip" data-placement="top" title="TOPAR COMISIÓN" onclick="Confirmacion(${i} ,'${v.colaborador}')" class="btn btn-danger btn-round btn-fab btn-fab-mini"><span class="material-icons">pan_tool</span></button>
                                <button type="button" id="btnAdd_${i}"  data-toggle="tooltip" data-placement="top" title="AGREGAR PAGO" onclick="AgregarPago(${i}, ${pending})" class="btn btn-dark btn-success btn-fab btn-fab-mini"><span class="material-icons">add</span></button>

                                </div>

                                </div>`);
                                counts++
                            });

                                // <button type="button" id="btnAdd_${i}"  data-toggle="tooltip" data-placement="top" title="QUITAR PAGO" onclick="VlidarNuevos(${v.id_comision}, ${v.id_usuario})" class="btn btn-dark btn-warning btn-fab btn-fab-mini"><span class="material-icons">delete</span></button>

                        });
                        $("#modal_NEODATA .modal-footer").append('<div class="row"><div class="col-md-3"></div><div class="col-md-3"></div><div class="col-md-3"></div></div>');
                        if(total < 1 ){
                            $('#dispersar').prop('disabled', true);
                        }
                        else{
                            $('#dispersar').prop('disabled', false);
                        }
                    });
                } 
                                       
                    break;
                    case '2':
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No se encontró esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case '3':
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No tiene vivienda, si hay referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case '4':
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No hay pagos aplicados a esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case '5':
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Referencia duplicada de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    default:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Sin localizar.</b></h4><br><h5>Revisar con sistemas: '+row.data().nombreLote+'.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        
                    break;
                }
            }
            else{
                console.log("entra 2");
                 $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><b>No se encontró esta referencia en NEODATA de '+row.data().nombreLote+'.</b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
            }
            });

            $("#modal_NEODATA").modal();

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

	var element = document.getElementById("li_individual_sales");

	if ($itself.attr('data-tipo-venta') == 'Venta de particulares') {
		$.getJSON(url+"Contratacion/getClauses/"+idLote).done( function( data ){
			$('#clauses_content').html(data[0]['nombre']);
		});
		element.classList.remove("hide");
	} else {
		element.classList.add("hide");
		$('#clauses_content').html('');
	}

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
	
	var urlTableCSA = '';
    $.getJSON(url+"Contratacion/getCoSallingAdvisers/"+idLote).done( function( data ){
        urlTableCSA = url+"Contratacion/getCoSallingAdvisers/"+idLote;
        fillCoSellingAdvisers(urlTableCSA);
    });	

	fill_data_asignacion();
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
	
	function fillCoSellingAdvisers(urlTableCSA)
{
    tableCoSellingAdvisers = $('#seeCoSellingAdvisers').DataTable( {
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
        columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
        "scrollX": true,
        "pageLength": 10,
        language: {
            url: "../../static/spanishLoader.json"
        },
        "destroy": true,
        "ordering": false,
        columns: [
            { "data": "asesor" },
            { "data": "coordinador" },
            { "data": "gerente" },
            { "data" : "fecha_creacion"},
            { "data": "creado_por" }

        ],
        "ajax":
            {
                "url": urlTableCSA,
                "dataSrc": ""
            },
    });
}


function fill_data_asignacion(){
    $.getJSON(url+"Administracion/get_data_asignacion/"+idLote).done( function( data ){
		(data.id_estado == 1) ? $("#check_edo").prop('checked', true) : $("#check_edo").prop('checked', false);
		$('#sel_desarrollo').val(data.id_desarrollo_n);
		$("#sel_desarrollo").selectpicker('refresh');
    });
}



$(document).on('click', '#save_asignacion', function(e) {
e.preventDefault();

var id_desarrollo = $("#sel_desarrollo").val();
var id_estado = ($('input:checkbox[id=check_edo]:checked').val() == 'on') ? 1 : 0;

var data_asignacion = new FormData();
data_asignacion.append("idLote", idLote);
data_asignacion.append("id_desarrollo", id_desarrollo);
data_asignacion.append("id_estado", id_estado);

    if (id_desarrollo == null) {
		alerts.showNotification("top", "right", "Debes seleccionar un desarrollo.", "danger");
    } 

    if (id_desarrollo != null) {
        $('#save_asignacion').prop('disabled', true);
            $.ajax({
              url : '<?=base_url()?>index.php/Administracion/update_asignacion/',
              data: data_asignacion,
              cache: false,
              contentType: false,
              processData: false,
              type: 'POST', 
              success: function(data){
              response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save_asignacion').prop('disabled', false);
                    $('#seeInformationModal').modal('hide');
                    alerts.showNotification("top", "right", "Asignado con éxito.", "success");
                } else if(response.message == 'ERROR'){
                    $('#save_asignacion').prop('disabled', false);
                    $('#seeInformationModal').modal('hide');
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
              },
              error: function( data ){
                    $('#save_asignacion').prop('disabled', false);
                    $('#seeInformationModal').modal('hide');
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
              }
            });
    }

});






    $(document).on('click', '.update_bandera', function(e){

        id_pagoc = $(this).val();
        nombre = $(this).attr("data-nombre");
         $("#myUpdateBanderaModal .modal-header").html('');
        $("#myUpdateBanderaModal .modal-body").html('');
        $("#myUpdateBanderaModal .modal-footer").html('');

        $("#myUpdateBanderaModal .modal-header").append('<h4 class="card-title"><b>Regresar a dispersión</b></h4>');
        $("#myUpdateBanderaModal .modal-body").append(`<div id="inputhidden"><p>¿Está seguro de regresar el lote <b>${nombre}</b> a dispersión?</p> <input type="hidden" name="id_pagoc" id="id_pagoc">`);
        $("#myUpdateBanderaModal .modal-footer").append('<div class="row"><div class="col-md-12" style="align-content: left;"><center><input type="submit" class="btn btn-primary" value="ACEPTAR" style="margin: 15px;"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></center></div></div>');

        $("#myUpdateBanderaModal").modal();
        $("#id_pagoc").val(id_pagoc);
    });

    $("#my_updatebandera_form").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'updateBandera',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                // Actions before send post
            },
            success: function(data) {
                if (data == 1) {
                    $('#myUpdateBanderaModal').modal("hide");
                    $("#id_pagoc").val("");
                    alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                     $('#tabla_inventario_contraloria').DataTable().ajax.reload();
                } else {
                    alerts.showNotification("top", "right", "Oops, algo salió mal. Error al intentar actualizar.", "warning");
                }
            },
            error: function(){
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });




$("#form_pagadas").submit(function(e) {
        $('#loader').removeClass('hidden');
        e.preventDefault();
    }).validate({
        submitHandler: function(form) {

            var data = new FormData($(form)[0]);

            $.ajax({
                url: url + "Comisiones/CambiarPrecioLote",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data) {
                    if (true) {
                        $("#modal_pagadas").modal('toggle');
                        $('#tabla_inventario_contraloria').DataTable().ajax.reload();
                        $('#loader').addClass('hidden');
                         alerts.showNotification("top", "right", "Precio Actualizado", "success");

                        // tabla_inventario.ajax.reload();

                       // alert("SE ELIMINÓ EL ARCHIVO");
                    } else {
                        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                        $('#loader').addClass('hidden');

                    }
                },
                error: function() {
                    alert("ERROR EN EL SISTEMA");
                    $('#loader').addClass('hidden');

                }
            });
        }
    });


   

    function verificar(precio){
        let precioAnt = parseFloat(precio);
        let  precioAct =  replaceAll($('#precioL').val(), ',','');

       // let precioAct = $('#precioL').val();
        // console.log(precioAnt);
        // console.log('-----------');
        // console.log(precioAct);

        if(rol == 13){
            if(parseFloat(precioAct) > parseFloat(precioAnt)){
            	 // console.log(100000-parseFloat(precioAct));
            	// if(parseFloat(precioAct)>100000){
            		document.getElementById('btn-save').disabled = false;
            		document.getElementById('msj').innerHTML = '';
            	}else{
            		document.getElementById('msj').innerHTML = 'Precio no válido';
            		//alerts.showNotification("top", "right", "El precio ingresado es menor al actual, verificarlo con sistemas.", "warning");
            		document.getElementById('btn-save').disabled = true;
        }
        }else{
            document.getElementById('btn-save').disabled = false;
            document.getElementById('msj').innerHTML = '';

        }
       

    }




    function verifica_pago(precio){
        let precioAnt = parseFloat(precio);
        let  precioAct =  replaceAll($('#monotAdd').val(), ',','');

       // let precioAct = $('#precioL').val();
        // console.log(precioAnt);
        // console.log('-----------');
        // console.log(precioAct);

        if(rol == 13){
            // if(parseFloat(precioAnt) < parseFloat(precioAct)){
            	 // console.log(100000-parseFloat(precioAct));
            	if(parseFloat(precioAct)<=parseFloat(precioAnt)){
            		document.getElementById('btn-save2').disabled = false;
            		document.getElementById('msj2').innerHTML = '';
            	}else{
            		document.getElementById('msj2').innerHTML = 'Monto no válido, es mayor al disponible.';
            		//alerts.showNotification("top", "right", "El precio ingresado es menor al actual, verificarlo con sistemas.", "warning");
            		document.getElementById('btn-save2').disabled = true;
        }
        }else{
            document.getElementById('btn-save2').disabled = false;
            document.getElementById('msj2').innerHTML = '';

        }
       

    }






    // function Confirmacion(i){
    //     $('#modal_avisos .modal-body').html(''); 



    //     $('#modal_avisos .modal-body').append(`<h5>¿Seguro que desea topar esta comisión?</h5>
    //     <br><div class="row"><div class="col-md-12"><center><input type="button" onclick="ToparComision(${i})" id="btn-save" class="btn btn-success" value="GUARDAR"><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>`);
    //     $('#modal_avisos').modal('show');
  
    // }



    function Confirmacion(i,name){

        $('#modal_avisos .modal-header').html(''); 
        $('#modal_avisos .modal-body').html(''); 
        $('#modal_avisos .modal-footer').html(''); 

        $("#modal_avisos .modal-header").append('<h4 class="card-title"><b>Detener comisión</b></h4>');
        $("#modal_avisos .modal-body").append(`<div id="inputhidden"><p>¿Estás seguro de DETENER la comisión al usuario <b>${name}</b>?<br><br> <b>NOTA:</B> El cambio ya no se podrá revertir.</p><div class="form-group">
        	<textarea id="comentario_topa" name="comentario_topa" class="form-control" rows="3" required placeholder="Describe el motivo por el cual se detendrán los pagos de esta comisión"></textarea></div></div>`);
        $("#modal_avisos .modal-footer").append(`<div class="row"><div class="col-md-12" style="align-content: left;"><center><input type="submit"  onclick="ToparComision(${i})"  class="btn btn-primary" value="ACEPTAR" style="margin: 15px;"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></center></div></div>`);
        $('#modal_avisos').modal('show');
  
    }




    function AgregarPago(i,pendiente){
     	
        $('#modal_add .modal-header').html(''); 
        $('#modal_add .modal-body').html(''); 
        $('#modal_add .modal-footer').html(''); 

        $("#modal_add .modal-header").append('<h4 class="card-title"><b>Agregar Pago</b></h4>');
        $("#modal_add .modal-body").append(`<div id="inputhidden"><p>El monto no puede ser mayor a <b>$${formatMoney(pendiente)}</b>, en caso de ser mayor valida si hay algun pago en <b>NUEVAS</b> que puedas quitar.</p><div class="form-group">
        	<input id="monotAdd" name="monotAdd" class="form-control" type="number" onblur="verifica_pago(${pendiente})" placeholder="Monto a abonar" maxlength="6"/> <p id="msj2" style="color:red;"></p>
        	<br><textarea id="comentario_topa" name="comentario_topa" class="form-control" rows="3" required placeholder="Describe el motivo por el cual se agrega este pago"></textarea></div></div>`);
        $("#modal_add .modal-footer").append(`<div class="row"><div class="col-md-12" style="align-content: left;">

        	<center><input type="button" onclick="GuardarPago(${i})" class="btn btn-primary" disabled id="btn-save2" value="ACEPTAR"><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center>
        	</div></div>`);
        $('#modal_add').modal('show');
  
    }



        function VlidarNuevos(i,usuario){
     	
        $('#modal_quitar .modal-header').html(''); 
        $('#modal_quitar .modal-body').html(''); 
        $('#modal_quitar .modal-footer').html(''); 


         $.getJSON(url + "Comisiones/verPagos/" + i + '/' + usuario).done(function(data) {
    console.log(data.length);

    if(data.length < 1){

    	 $('#modal_quitar .modal-body').append(`SIN PAGOS NUEVOS`);

    }else{


    $('#modal_quitar .modal-body').append(`<table class="table table-hover">
                    <thead>
                    <tr>
                    <th>ID pago</th>
                    <th>Monto</th>
                    <th>Usuario</th>
                    <th>Estatus</th>
                    </tr>
                    </thead><tbody>`);
                    for( var j = 0; j<data.length ; j++)
                    {
                        $('#modal_avisos .modal-body .table').append(`<tr>
                        <td>${data[j]['id_pago_i']}</td>
                        <td>$${formatMoney(data[j]['abono_neodata'])}</td>
                        <td>${data[j]['id_usuario']}</td>
                        <td>${data[j]['id_comision']}</td>

                        </tr>`);
                    }

                }
 


        // $("#modal_quitar .modal-header").append('<h4 class="card-title"><b>Agregar Pago</b></h4>');
        // $("#modal_quitar .modal-body").append(`<div id="inputhidden"><p>El monto no puede ser mayor a <b>$${formatMoney(pendiente)}</b>, en caso de ser mayor valida si hay algun pago en <b>NUEVAS</b> que puedas quitar.</p><div class="form-group">
        // 	<input id="monotAdd" name="monotAdd" class="form-control" type="number" onblur="verifica_pago(${pendiente})" placeholder="Monto a abonar" maxlength="6"/> <p id="msj2" style="color:red;"></p>
        // 	<br><textarea id="comentario_topa" name="comentario_topa" class="form-control" rows="3" required placeholder="Describe el motivo por el cual se agrega este pago"></textarea></div></div>`);
        // $("#modal_quitar .modal-footer").append(`<div class="row"><div class="col-md-12" style="align-content: left;">


        // 	<center><input type="button" onclick="QuitarPago(${i})" class="btn btn-primary" disabled id="btn-save2" value="ACEPTAR"><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center>
        // 	</div></div>`);

          });
        $('#modal_quitar').modal('show');
  
    }


        	// <input type="submit"  onclick="AgregarPago(${i})" id="btn-save2" disabled class="btn btn-primary" value="ACEPTAR" style="margin: 15px;"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></center>



        //  $("#tabla_inventario_contraloria tbody").on("click", ".AgregarPago", function(){
        //     var tr = $(this).closest('tr');
        //     var row = tabla_inventario.row( tr );
        //     idLote = $(this).val();
        //     alert(idLote);


        //     // $("#modal_pagadas .modal-header").html("");
        //     $("#modal_pagadas .modal-body").html("");

        //     $("#modal_pagadas .modal-body").append('<h4 class="modal-title">¿Estás seguro de mandar a recisión este lote? <b style="color:red;" >'+row.data().nombreLote+'</b>?</h4>');
        //     $("#modal_pagadas .modal-body").append(`<div class="form-group"><textarea name="Motivo" id="Motivo" class="form-control" placeholder="Describe brevemente el motivo y detalles de fecha." cols="70" rows="3" required></textarea></div>
        //     <input type="hidden" name="ideLotep" id="ideLotep" value="${idLote}"><input type="hidden" name="estatusL" id="estatusL" value="8">`);

        //     $("#modal_pagadas .modal-body").append('<br><div class="row"><div class="col-md-12"><center><input type="submit" class="btn btn-success" value="ACEPTAR"></center></div></div>');
        // $("#modal_pagadas").modal();
        // });







    function ToparComision(i){
       // $('#modal_avisos').modal('toggle');

        $('#modal_avisos .modal-body').html('');

        let id_comision = $('#id_comision_'+i).val();
        let abonado = replaceAll($('#abonado_'+i).val(), ',','');

        

        $.ajax({
                url: '<?=base_url()?>Comisiones/ToparComision/'+id_comision,
                type: 'post',
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    if(len == 0){
                        $('#comision_total_'+i).val(formatMoney(abonado));
                        let pendiente = parseFloat(abonado - abonado);
                        $('#pendiente_'+i).val(formatMoney(pendiente));

                        $('#modal_avisos').modal('hide');
                        // $('#modal_avisos .modal-body').append('<b>La comisión total se ajustó con éxito</b>');
                         alerts.showNotification("top", "right", "Comisión detenida con éxito.", "success");

                    }else{
                    	let suma = 0;
                        console.log(response);

                         $('#modal_avisos').modal('hide');
                           alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");



                    $('#modal_avisos .modal-body').append(`<table class="table table-hover">
                    <thead>
                    <tr>
                    <th>ID pago</th>
                    <th>Monto</th>
                    <th>Usuario</th>
                    <th>Estatus</th>
                    </tr>
                    </thead><tbody>`);
                    for( var j = 0; j<len; j++)
                    {
                        suma = suma + response[j]['abono_neodata'];
                        $('#modal_avisos .modal-body .table').append(`<tr>
                        <td>${response[j]['id_pago_i']}</td>
                        <td>$${formatMoney(response[j]['abono_neodata'])}</td>
                        <td>${response[j]['usuario']}</td>
                        <td>${response[j]['nombre']}</td>

                        </tr>`);
                    }
                    $('#modal_avisos .modal-body').append(`</tbody></table>`);
                }
            }
            });
            $('#modal_avisos').modal('show');   


    }

 

    function GuardarPago(i){

         let id_comision = $('#id_comision_'+i).val();
         var formData = new FormData(document.getElementById("form_add"));
         formData.append("dato", "valor");

        $.ajax({
        	method: 'POST',
        url: url+'Comisiones/GuardarPago/'+id_comision,
        data: formData,
        processData: false,
        contentType: false,


                success:function(data){
                	console.log(data);
                    if(data == 1){
                    	
                    	$('#modal_add').modal('hide');
                    	$('#modal_NEODATA').modal('hide');
                    	alerts.showNotification("top", "right", "Pago registrado con exito.", "success");
                    	document.getElementById("form_add").reset();

                    }else{

                    	$('#modal_add').modal('hide');
                    	 alerts.showNotification("top", "right", "Ocurrio un error, intenta mas tarde.", "danger");
                    	document.getElementById("form_add").reset();

                }
            },

            error: function(){
            $('#modal_add').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
    }

    function QuitarPago(i){

         let id_comision = $('#id_comision_'+i).val();
         var formData = new FormData(document.getElementById("form_add"));
         formData.append("dato", "valor");

        $.ajax({
        	method: 'POST',
        url: url+'Comisiones/QuitarPago/'+id_comision,
        data: formData,
        processData: false,
        contentType: false,


                success:function(data){
                	console.log(data);
                    if(data == 1){
                    	
                    	$('#modal_quitar').modal('hide');
                    	$('#modal_NEODATA').modal('hide');
                    	alerts.showNotification("top", "right", "Pago eliminado con exito.", "success");
                    	document.getElementById("form_add").reset();

                    }else{

                    	$('#modal_quitar').modal('hide');
                    	 alerts.showNotification("top", "right", "Ocurrio un error, intenta mas tarde.", "danger");
                    	document.getElementById("form_add").reset();

                }
            },

            error: function(){
            $('#modal_quitar').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
    }

    





function Editar(i,precio){
    $('#modal_avisos .modal-body').html('');
    let precioLote = parseFloat(precio);
    let nuevoPorce1 = replaceAll($('#porcentaje_'+i).val(), ',',''); 
    let nuevoPorce = replaceAll(nuevoPorce1, '%',''); 
    let  abonado =  replaceAll($('#abonado_'+i).val(), ',','');
    let id_comision = $('#id_comision_'+i).val();
    let id_rol = $('#id_rol_'+i).val();
    let pendiente = replaceAll($('#pendiente_'+i).val(), ',',''); 


    if(id_rol == 1 || id_rol == 2 || id_rol == 3 || id_rol == 9 || id_rol == 38 || id_rol == 45){

        if(parseFloat(nuevoPorce) > 1 || parseFloat(nuevoPorce) < 0){
            $('#porcentaje_'+i).val(1);
            nuevoPorce=1;
            document.getElementById('msj_'+i).innerHTML = 'Debe ingresar un número entre 0 y 1';
        }else{
            document.getElementById('msj_'+i).innerHTML = '';

        }

    }else{
        if(parseFloat(nuevoPorce) > 3 || parseFloat(nuevoPorce) < 0){
            $('#porcentaje_'+i).val(3);
            nuevoPorce=3;
            document.getElementById('msj_'+i).innerHTML = '';
            document.getElementById('msj_'+i).innerHTML = 'Debe ingresar un número entre 0 y 3';
        }else{
            document.getElementById('msj_'+i).innerHTML = '';
        }
    
    }



    let comisionTotal = precioLote * (nuevoPorce / 100);
    console.log(abonado);
    console.log('Comision total:'+comisionTotal);
    $('#btn_'+i).addClass('btn-success');

    if(parseFloat(abonado) > parseFloat(comisionTotal)){
        $('#comision_total_'+i).val(formatMoney(comisionTotal));

        //document.getElementById('btn_'+i).disabled=true;
        $.ajax({

                url: '<?=base_url()?>Comisiones/getPagosByComision/'+id_comision,
                type: 'post',
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    if(len == 0){
                        let nuevoPendient=parseFloat(comisionTotal - abonado);
                    $('#pendiente_'+i).val(formatMoney(nuevoPendient));

                        $('#modal_avisos .modal-body').append('<p>La nueva comisión total <b style="color:green;">$'+formatMoney(comisionTotal)+'</b> es menor a lo abondado, No se encontraron pagos disponibles para eliminar. <b style="color:red;">Aplicar los respectivos descuentos</b></p>');

                    }else{
let suma = 0;
                        console.log(response);
                    $('#modal_avisos .modal-body').append(`<table class="table table-hover">
                    <thead>
                    <tr>
                    <th>ID pago</th>
                    <th>Monto</th>
                    <th>Usuario</th>
                    <th>Estatus</th>
                    </tr>
                    </thead><tbody>`);
                    for( var j = 0; j<len; j++)
                    {
                        suma = suma + response[j]['abono_neodata'];
                        $('#modal_avisos .modal-body .table').append(`<tr>
                        <td>${response[j]['id_pago_i']}</td>
                        <td>$${formatMoney(response[j]['abono_neodata'])}</td>
                        <td>${response[j]['usuario']}</td>
                        <td>${response[j]['nombre']}</td>

                        </tr>`);
                    }
                    $('#modal_avisos .modal-body').append(`</tbody></table>`);
                    let nuevoAbono=parseFloat(abonado-suma);
                    let NuevoPendiente=parseFloat(comisionTotal - nuevoAbono);
                    $('#abonado_'+i).val(formatMoney(nuevoAbono));
                    $('#pendiente_'+i).val(formatMoney(NuevoPendiente));


                    if(nuevoAbono > comisionTotal){

                        $('#modal_avisos .modal-body').append('<p>La nueva comisión total es de <b style="color:green;">$'+formatMoney(comisionTotal)+'</b> y es menor a lo abondado <b>$'+formatMoney(nuevoAbono)+'</b> (ya con los pagos eliminados), Se eliminar los pagos mostrados una vez guardado el cambio. <b style="color:red;"><br>Recuerda aplicar los respectivos descuentos</b></p>');

                    }else{
                        $('#modal_avisos .modal-body').append('<p>La nueva comisión total es de <b style="color:green;">$'+formatMoney(comisionTotal)+'</b>, se eliminaran los pagos mostrados una vez guardado el ajuste. El nuevo saldo abonado sera de <b>$'+formatMoney(nuevoAbono)+'</b>. <br><b>No se requiere aplicar ningun descuento</b> </p>');

                    }

                    $('#modal_avisos .modal-body').append('<center><button type="button" class="btn btn-primary" data-dismiss="modal">ENTENDIDO</button></center>');



                    }
                    
                 

                }
            });
 
     $('#modal_avisos').modal({
     	keyboard: false,
     	backdrop: 'static'
     });


        $('#modal_avisos').modal('show');   

console.log('NELSON');
    }else{
        let NuevoPendiente=parseFloat(comisionTotal - abonado);
        $('#pendiente_'+i).val(formatMoney(NuevoPendiente));
        document.getElementById('btn_'+i).disabled=false;
        $('#comision_total_'+i).val(formatMoney(comisionTotal));
        console.log('SIMON');


    }
    
        }

function SaveAjuste(i){
     $('#loader').removeClass('hidden');
     $('#btn_'+i).removeClass('btn-success');
     $('#btn_'+i).addClass('btn-default');

    let id_comision = $('#id_comision_'+i).val();
    let id_usuario = $('#id_usuario_'+i).val();
    let id_lote = $('#idLote').val();
    let porcentaje = $('#porcentaje_'+i).val();
    let comision_total = $('#comision_total_'+i).val();


    // let datos = {
    //     'id_comision':id_comision,
    //     'id_usuario':id_usuario,
    //     'id_lote':id_lote,
    //     'porcentaje':porcentaje,
    //     'comision_total':comision_total
    // }
    var formData = new FormData;
    formData.append("id_comision", id_comision);
    formData.append("id_usuario", id_usuario);
    formData.append("id_lote", id_lote);
    formData.append("porcentaje", porcentaje);
    formData.append("comision_total", comision_total);




    $.ajax({
                url: '<?=base_url()?>Comisiones/SaveAjuste',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success:function(response){
                  
                    $('#loader').addClass('hidden');
alerts.showNotification("top", "right", "Modificación almancenada con éxito.", "success");

                }
            });

}



</script>

