<!DOCTYPE html>
<html lang="es" ng-app = "myApp">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Ciudad Maderas | Sistema de Contratación</title>
	<!-- Tell the browser to be responsive to screen width -->

	<link rel="shortcut icon" href="<?=base_url()?>static/images/arbol_cm.png" />


	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?=base_url()?>dist/bower_components/bootstrap/dist/css/bootstrap.min.css">
 
	<link rel="stylesheet" href="<?=base_url()?>dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?=base_url()?>dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?=base_url()?>dist/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">

	<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
 	<script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.css">
	 
 	<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/3.7.0/lodash.min.js"></script>
<!--  	// <script type="text/javascript" src="<?= base_url("dist/js/calcularAC.js")?>"></script>
 -->

 	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
	<!-- <script src="<?= base_url("dist/js/select2.full.min.js")?>"></script> -->
	
 
	<!-- Google Font -->
	<link rel="stylesheet"
		  href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<style type="text/css">
		.contenedorinputs {
			position: relative;
		}
		ul li{
			list-style: none;
			display: block;
			padding-bottom: 2em;
		}
		.inputradio{
			opacity: 0; /* Ocultamos el input verdadero con opacity: 0 */
			width: 20px;
			height: 20px;
			position: absolute;
			left: 0px;
		}
		.inputfalso{
			border: 5px solid #dedede;
			border-radius: 10%;
			display: inline-block;
			height: 20px;
			position: absolute;
			left: 0px;
			width: 21px;
			z-index: -1;
		}
		input[type="checkbox"]:checked + span:after {
			content: "✔";
			position: absolute;
			text-indent: 2px;
			top: -5px;
			left: -2px;
			color: black;
		}


		legend {
			background-color: #296D5D;
			color: #fff;
			padding: 3px 6px;
		}

		.output {
			font: 1rem 'Fira Sans', sans-serif;
		}

		.foreach {
			background: #4C9B79;
			height: 15.5em;
			width:auto;
			border-radius: 10px;
			padding:10px;
			font-size:15px;
			color:#fff;
			margin-bottom: 30px;

		}
		.btn-circle.btn-xl {
			width: 70px;
			height: 70px;
			padding: 10px 16px;
			border-radius: 35px;
			font-size: 24px;
			line-height: 1.33;
		}

		.btn-circle {
			width: 30px;
			height: 30px;
			padding: 6px 0px;
			border-radius: 15px;
			text-align: center;
			font-size: 12px;
			line-height: 1.42857;
		}
		.float-right
		{
			position:fixed;
			bottom: 5%;
			right: 3%;
		}
	</style>
	<style type="text/css">


		.panel-pricing {
			-moz-transition: all .3s ease;
			-o-transition: all .3s ease;
			-webkit-transition: all .3s ease;
		}
		.panel-pricing:hover {
			box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.2);
		}
		.panel-pricing .panel-heading {
			padding: 20px 10px;
		}
		.panel-pricing .panel-heading .fa {
			margin-top: 10px;
			font-size: 58px;
		}
		.panel-pricing .list-group-item {
			color: #777777;
			border-bottom: 1px solid rgba(250, 250, 250, 0.5);
		}
		.panel-pricing .list-group-item:last-child {
			border-bottom-right-radius: 0px;
			border-bottom-left-radius: 0px;
		}
		.panel-pricing .list-group-item:first-child {
			border-top-right-radius: 0px;
			border-top-left-radius: 0px;
		}
		.panel-pricing .panel-body {
			background-color: #f0f0f0;
			font-size: 40px;
			color: #777777;
			padding: 20px;
			margin: 0px;
		}


		/*nuevos estilos*/
		.loader,
		.loader:before,
		.loader:after {
			background: #ffffff;
			-webkit-animation: load1 1s infinite ease-in-out;
			animation: load1 1s infinite ease-in-out;
			width: 1em;
			height: 4em;
		}
		.loader {
			color: #ffffff;
			text-indent: -9999em;
			margin: 88px auto;
			position: relative;
			font-size: 11px;
			-webkit-transform: translateZ(0);
			-ms-transform: translateZ(0);
			transform: translateZ(0);
			-webkit-animation-delay: -0.16s;
			animation-delay: -0.16s;
		}
		.loader:before,
		.loader:after {
			position: absolute;
			top: 0;
			content: '';
		}
		.loader:before {
			left: -1.5em;
			-webkit-animation-delay: -0.32s;
			animation-delay: -0.32s;
		}
		.loader:after {
			left: 1.5em;
		}
		@-webkit-keyframes load1 {
			0%,
			80%,
			100% {
				box-shadow: 0 0;
				height: 4em;
			}
			40% {
				box-shadow: 0 -2em;
				height: 5em;
			}
		}
		@keyframes load1 {
			0%,
			80%,
			100% {
				box-shadow: 0 0;
				height: 4em;
			}
			40% {
				box-shadow: 0 -2em;
				height: 5em;
			}
		}

		.bkLoading
		{
			/* background:#000; *//*b3b3b3*/
			background-image: linear-gradient(to bottom, #000, #000);
			position:absolute;
			top:0%;
			left:0%;
			width:100%;
			height:100%;
			z-index:3;
			padding-top:200px;
			color:white;
			font-weight:300;
			opacity: 0.5;


			/* display:none; */
		}
		.center-align
		{
			text-align:center;
			font-size:2em;
			font-weight:lighter;
		}
		.hide
		{
			display:none;
		}
		/*Terminan los nuevos estilos*/



	</style>
</head>
<body class="hold-transition register-page" ng-controller = "myController">


<div class="bkLoading hide" id="loaderDiv">
	<div class="center-align">
		<img src="<?=base_url()?>static/images/logo_blanco_cdm.png" style="width:25%;"><br>
		Este proceso puede demorar algunos segundos, espere por favor ...
	</div>
	<div class="inner">
		<div class="load-container load1">
			<div class="loader">
			</div>
		</div>
	</div>
</div>
 
<div class="wrapper">
 
	<section class="content">
		<div class="row">
			<div class="col-xs-10 col-md-offset-1">
				<div class="box">
					<div class="box-body">
						<div id="exportthis">
					 
							<table align="center" width="100%" cellpadding="8" cellspacing="8">
								<tr>
									<td align="right">&nbsp&nbsp</td>

									<td rowspan=4 align="right"><b style="font-size: 2em; font-family:'Sabon LT Std', 'Hoefler Text', 'Palatino Linotype', 'Book Antiqua', serif;">SOLICITUD DE COMISIONES</b><small style="font-size: 1.5em; font-family: 'Sabon LT Std', 'Hoefler Text', 'Palatino Linotype', 'Book Antiqua', serif; color: #777;"> CIUDAD MADERAS</small>
									</td>
									<td align="right">&nbsp&nbsp</td>
								</tr>
							</table>

							<fieldset>
								<legend style="background: #7EAAD5;">
									<section class="content-header" style="font-family: 'Sabon LT Std', 'Hoefler Text', 'Palatino Linotype', 'Book Antiqua', serif;">PAGO DE COMISIÓN LOTES:</section>
								</legend>

								<div class="row">
									<div class="col-md-6 form-group">
										<label for="gerente">Gerente: </label>
										<select name="gerente" id="gerente" class="form-control lista_gerentes" required></select>
									</div>

									<div class="col-md-6 form-group" >
										<label for="asesor">Asesor: </label>
										<select name="asesor" id="asesor" class="form-control lista_asesores" required><option value=""> - Seleccione Asesor - </option></select>
									</div>
								</div>

								<div class="row">
									<div class="col-md-3 form-group" >
										<label for="proyecto">Proyecto:</label>
										<select name="proyecto" id="proyecto" class="form-control lista_proyecto" required></select>
									</div>
									<div class="col-md-3 form-group" >
										<label for="condominio">Condominio:</label>
										<select name="condominio" id="condominio" class="form-control lista_condominio" required><option value=""> - Seleccione Condominio - </option></select>
									</div>

									<div class="col-md-3 form-group" >
										<label for="lote">Lote:</label>
										<select name="lote" id="lote" class="form-control lista_lote" required><option value=""> - Seleccione Lote - </option></select>
									</div>

										<div class="col-md-3 form-group" >
											<label>Cliente:</label>
											<div class="input-group">
												<span class="input-group-addon" id="basic-addon1"><i class="fa fa-user-o"></i></span>
												<input name="cliente" id="cliente" type="text" class="form-control" readonly="true">
											</div>
										</div>

									</div>
									<div class="row">

										<div class="col-md-3 form-group" >
											<label>Superficie:</label>
											<div class="input-group">
												<input name="superficie" id="superficie" type="text" class="form-control" readonly="true">
												<span class="input-group-addon" id="basic-addon1">m<sup>2</sup></span>
											</div>
										</div>

										<div class="col-md-3 form-group" >
											<label>Total:</label>
											<div class="input-group">
												<span class="input-group-addon" id="basic-addon1">$</span>
												<input name="total" id="total" type="text" class="form-control" readonly="true">
											</div>
										</div>

										<div class="col-md-3 form-group" >
											<label>Plan:</label>
											<div class="input-group">
												<span class="input-group-addon" id="basic-addon1"><i class="fa fa-file-o"></i></span>
												<input name="plan" id="plan" type="text" class="form-control" readonly="true">
											</div>
										</div>

										<div class="col-md-3 form-group" >
											<label>Primer mensualidad:</label>
											<div class="input-group">
												<span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar-o"></i></span>
												<input name="primer_mensualidad" id="primer_mensualidad" type="text" class="form-control" readonly="true">
											</div>
										</div>

									</div>
									<div class="row">
										<div class="col-md-3 form-group" >
											<label>Forma venta:</label>
											<div class="input-group">
												<span class="input-group-addon" id="basic-addon1"><i class="fa fa-bars"></i></span>
												<select class="form-control forma_venta" id="selectForma" name="selectForma" required style="width:100%;" />
									</select>
											</div>
										</div>

										<div class="col-md-3 form-group" >
											<label>Tipo de venta:</label>
											<div class="input-group">
												<span class="input-group-addon" id="basic-addon1"><i class="fa fa-bars"></i></span>
												<select class="form-control tipo_venta" id="selectTipo" name="selectTipo" required style="width:100%;" />
									</select>
											</div>
										</div>




										<div class="col-md-3 form-group" >
											<label>Añadir evidencia:</label>
											<div class="input-group">
												<span class="input-group-addon" id="basic-addon1"><i class="fa fa-upload"></i></span>
												<input name="plan" id="plan" type="file" class="form-control" readonly="true">

											</div>
											</div>
										</div>




										<div class="row"><br><br>
											<div class="col-md-6 form-group">
												<table class="table table-striped" id="tblpa">
													<thead class="thead-dark">
														<tr>
                                                    <th style="font-size: .9em">COMISIÓN</th>
                                                    <th style="font-size: .9em">PORCENTAJE</th>
                                                    <th style="font-size: .9em">TOTAL</th>

                                                </tr>
                                            </thead>
                                            <tbody class="contenido">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>





                                <div class="row"><br><br>

                                    <div class="col-md-10 form-group">
                                    	<label>Observaciones:</label>
												<div class="input-group">
												<span class="input-group-addon" id="basic-addon1"><i class="fa fa-file-o"></i></span>
												<textarea class="form-control" placeholder="Observaciones y comentarios"></textarea>
											</div>
                                    </div>


                                     <div class="col-md-2 ">
                                     	<br>
                                     	<button class="btn form-control btn-secondary" style="height: 56px;">Enviar solicitud</button>	 
                                    </div>
                                </div>
                            </div>

							</fieldset>

						</div>

					</div>
				</div>
			</div>
		</div>
		 
</div>
</section>

<script>

var url = "http://localhost:9081/sisfusion/";
var url2 = "http://localhost:9081/sisfusion/index.php/";
var urlimg = "http://localhost:9081/sisfusion/img/";
 
$(".lista_gerentes").ready( function(){
         $(".lista_gerentes").append('<option value=""> - Seleccione Gerente - </option>');
        $.getJSON( url + "Comisiones/lista_gerentes").done( function( data ){
            $.each( data, function( i, v){
                $(".lista_gerentes").append('<option value="'+v.idGerente+'">'+v.nombreGerente+'</option>');
            });
        });
    });

   $('.lista_gerentes').change( function() {
   	index_gerente = $(this).val();
   	$(".lista_asesores").html("");
   	$(".lista_asesores").append('<option value=""> - Seleccione Asesor - </option>');
        $.getJSON( url + "Comisiones/lista_asesores/"+index_gerente).done( function( data ){
            $.each( data, function( i, v){
                $(".lista_asesores").append('<option value="'+v.idAsesor+'">'+v.nombreAsesor+'</option>');
            });
        });
 
   });
 


 $(".lista_proyecto").ready( function(){
         $(".lista_proyecto").append('<option value=""> - Seleccione Proyecto - </option>');
        $.getJSON( url + "Comisiones/lista_proyecto").done( function( data ){
            $.each( data, function( i, v){
                $(".lista_proyecto").append('<option value="'+v.idResidencial+'">'+v.descripcion+'</option>');
            });
        });
    });

   $('.lista_proyecto').change( function() {
   	index_proyecto = $(this).val();
   	$(".lista_condominio").html("");
   	// $(".lista_lote").html("");
   	$(".lista_condominio").append('<option value=""> - Seleccione Condominio - </option>');
        $.getJSON( url + "Comisiones/lista_condominio/"+index_proyecto).done( function( data ){
            $.each( data, function( i, v){
                $(".lista_condominio").append('<option value="'+v.idCondominio+'">'+v.nombre+'</option>');
            });
        });
 
   });

    $('.lista_condominio').change( function() {
   	index_condominio = $(this).val();
   	$(".lista_lote").html("");
   	$(".lista_lote").append('<option value=""> - Seleccione Lote - </option>');
        $.getJSON( url + "Comisiones/lista_lote/"+index_condominio).done( function( data ){
            $.each( data, function( i, v){
                $(".lista_lote").append('<option value="'+v.idLote+'">'+v.nombreLote+'</option>');
            });
        });
 
   });

    $('.lista_lote').change( function() {
   	index_lote = $(this).val();

   	$(".cliente").html("");
   	$(".superficie").html("");
   	$(".total").html("");
   	$(".plan").html("");
   	$(".primer_mensualidad").html("");
   	// $(".forma_venta").html("");
   	// $(".tipo_venta").html("");
   	$(".contenido").html("");

   	$.getJSON( url + "Comisiones/datos_dinamicos/"+index_lote).done( function( data ){
            $.each( data.lote , function( i, v){
 
            	 $("#cliente").val(v.nombre);
            	 $("#superficie").val(v.sup);
            	 $("#total").val(v.total);
            	 $("#plan").val('Crédito');
            	 $("#primer_mensualidad").val("12 Mayo 2020");

            	  $(".contenido").append('<tr><td>Gerente</td><td>1 %</td><td>$ '+formatMoney(v.total*0.01)+'</td></tr>');
            	  $(".contenido").append('<tr><td>Coordinador</td><td>1 %</td><td>$ '+formatMoney(v.total*0.01)+'</td></tr>');
            	  $(".contenido").append('<tr><td>Asesor</td><td>3 %</td><td>$ '+formatMoney(v.total*0.03)+'</td></tr>');
 
            });
    });
 
  });




 $(".forma_venta").ready( function(){
         $(".forma_venta").append('<option value=""> - Seleccione forma - </option>');
        $.getJSON( url + "Comisiones/forma_venta").done( function( data ){
            $.each( data, function( i, v){
                $(".forma_venta").append('<option value="'+v.id_opcion+'">'+v.descripcion+'</option>');
            });
        });
    });



  $(".tipo_venta").ready( function(){
         $(".tipo_venta").append('<option value=""> - Seleccione tipo - </option>');
        $.getJSON( url + "Comisiones/tipo_venta").done( function( data ){
            $.each( data, function( i, v){
                $(".tipo_venta").append('<option value="'+v.id_opcion+'">'+v.descripcion+'</option>');
            });
        });
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
 



</script> 

</body>

</html>
