<!DOCTYPE html>
<html lang="es" ng-app = "myApp">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Ciudad Maderas | Sistema de Contratación</title>
	<!-- Tell the browser to be responsive to screen width -->

	<link rel="shortcut icon" href="<?=base_url()?>static/images/arbol_cm.png" />



	<?php
	if($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'asesor' && $this->session->userdata('perfil') != 'ventasAsistentes' && $this->session->userdata('perfil') != 'contratacion')
	{
		redirect(base_url().'login');
	}
	?>


	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?=base_url()?>dist/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?=base_url()?>dist/bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?=base_url()?>dist/bower_components/Ionicons/css/ionicons.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="<?=base_url()?>dist/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?=base_url()?>dist/css/AdminLTE.min.css">



	<link rel="stylesheet" href="<?=base_url()?>dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?=base_url()?>dist/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">


	<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?= base_url("static/angular/datatable/dataTables.buttons.min.js")?>"></script>
	<script type="text/javascript" src="<?= base_url("static/angular/datatable/angular-datatables.buttons.js")?>"></script>
	<script type="text/javascript" src="<?= base_url("static/angular/datatable/angular-datatables.min.js")?>"></script>
	<script type="text/javascript" src="<?= base_url("static/angular/datatable/buttons.html5.min.js")?>"></script>
	<script type="text/javascript" src="<?= base_url("static/angular/datatable/buttons.colVis.min.js")?>"></script>
	<script type="text/javascript" src="<?= base_url("static/angular/datatable/buttons.flash.min.js")?>"></script>
	<script type="text/javascript" src="<?= base_url("static/angular/datatable/buttons.print.min.js")?>"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.css">
	<link rel="stylesheet" href="<?= base_url("static/angular/datatable/buttons.dataTables.min.css")?>">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/3.7.0/lodash.min.js"></script>
	<script type="text/javascript" src="<?= base_url("dist/js/angularjs-dropdown-multiselect.js")?>"></script>


	<script type="text/javascript" src="https://cdn.jsdelivr.net/angular.checklist-model/0.1.3/checklist-model.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>






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
							<button ng-click="exportc()" class="btn btn-secondary">Imprimir carátula</button>
							<button ng-click="exportcf()" class="btn btn-secondary">Imprimir carátula + Corrida Financiera</button>

							<table align="center" width="100%" cellpadding="8" cellspacing="8">
								<tr>
									<td align="right">&nbsp&nbsp</td>


									<td rowspan=4 align="left"><img src="https://www.ciudadmaderas.com/assets/img/logo.png" style=" max-width: 70%; height: auto;"></td>
									<td rowspan=4 align="right"><b style="font-size: 2em; font-family:'Sabon LT Std', 'Hoefler Text', 'Palatino Linotype', 'Book Antiqua', serif;"> CORRIDA FINANCIERA<BR></b><small style="font-size: 1.5em; font-family: 'Sabon LT Std', 'Hoefler Text', 'Palatino Linotype', 'Book Antiqua', serif; color: #777;"> Ciudad Maderas</small>
									</td>
									<td align="right">&nbsp&nbsp</td>
								</tr>
							</table>
							<!--<form method="post" action="<?=base_url()?>index.php/registroLote/genera_corrida/" enctype="multipart/form-data" id="corrida" name="corrida">  -->
							<!-- ///////////////////////////////////////////// -->
							<fieldset>
								<legend>






									<section class="content-header" style="font-family: 'Sabon LT Std', 'Hoefler Text', 'Palatino Linotype', 'Book Antiqua', serif;">INFORMACIÓN:</section>
								</legend>
								<div id="areaImprimir">
									<input type="hidden" ng-click="pagoACapital()" ng-model="pagoACapitalName" id="jsPagoCapital" name="pagoACapitalNameJS">
									<input type="hidden" ng-model="pagoACapitalPosition" id="pagoACapitalNumberJS" name="pagoACapitalNumberJS">
									<div class="row">
										<div class="col-md-3 form-group">
											<label>Nombre: </label>
											<input type="text" ng-model="nombre" class="form-control">
										</div >
										<div class="col-md-3 form-group" >
											<label>Edad: </label>
											<select ng-model="age" ng-options="item.age for item in ages" class="form-control" ng-change="getAge(age.age)">
												<option value = ""> - Selecciona la edad - </option>
											</select>
										</div >
										<div class="col-md-3 form-group" >
											<label>Teléfono:</label>
											<input type="text" ng-model="telefono" class="form-control">
										</div>

										<div class="col-md-3 form-group" >
											<label>Email:</label>
											<div class="input-group">
												<span class="input-group-addon" id="basic-addon1">@</span>
												<input type="text" ng-model="email" class="form-control">
											</div>
										</div>
									</div >


								</div >



								<div class="row">
									<div class="col-md-6 form-group" >
										<label>Gerente: </label>
										<select ng-model="gerente" ng-options="item.nombreGerente for item in gerentes" ng-change="onSelectChangeg(gerente)" class="form-control">
											<option value = ""> - Selecciona un Gerente - </option>
										</select>
									</div >
									<div class="col-md-6 form-group" >
										<label>Asesor: </label>
										<select ng-model="asesor" ng-options= "item.nombreAsesor for item in asesores" class="form-control">
											<option value = ""> - Selecciona un Asesor - </option>
										</select>
									</div >
								</div>
								<div class="row">
									<div class="col-md-3 form-group" >
										<label>Proyecto:</label>
										<select ng-model = "proyecto" ng-options = "item.descripcion for item in residencial" ng-change="onSelectChangep(proyecto)" class="form-control">
											<option value = ""> - Selecciona un Proyecto - </option>
										</select>
									</div>
									<div class="col-md-2 form-group" >
										<label>Condominio:</label>
										<select ng-model="condominio" ng-options="item.nombre for item in condominios" ng-change="onSelectChangec(condominio)" class="form-control" style="text-transform: uppercase;">
											<option value = ""> - Selecciona un Condominio - </option>
										</select>
									</div>
									<div class="col-md-3 form-group" >
										<label>Lote:</label>
										<select ng-model="lote" ng-options="item.nombreLote for item in lotes" ng-change="onSelectChangel(lote)" class="form-control">
											<option value = ""> - Selecciona un Lote - </option>
										</select>
									</div>
									<div class="col-md-2 form-group" >
										<label>Plan:</label>
										<select ng-model = "plan" class="form-control" ng-change="payPlan()">
											<option value = ""> - Selecciona un plan - </option>
											<option value = "Crédito"> Crédito </option>
											<option value = "Contado"> Contado </option>
										</select>
									</div>
									<div class="col-md-2 form-group" >
										<label>Años:</label>
										<select ng-model="yearplan" id="yearplan" ng-options="item.yearplan for item in yearsplan" class="form-control" ng-change="getAgePlan()">
											<option value = ""> - Selecciona los años - </option>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-md-2 form-group" >
										<label>Superficie:</label>
										<div class="input-group">
											<input type="text" ng-model="superficie" class="form-control" ng-readonly="true">
											<span class="input-group-addon" id="basic-addon1">m2</span>
										</div>
									</div>
									<div class="col-md-2 form-group" >
										<label>Precio m2:</label>
										<div class="input-group">
											<span class="input-group-addon" id="basic-addon1">$</span>
											<input type="text" ng-model="preciom2" class="form-control" value="{{preciom2 | currency}}" ng-readonly="true">
										</div>
									</div>
									<div class="col-md-2 form-group" >
										<label>Total:</label>
										<div class="input-group">
											<span class="input-group-addon" id="basic-addon1">$</span>
											<input type="text" ng-model="total" class="form-control" value="{{total | currency}}" ng-readonly="true">
										</div>
									</div>
									<div class="col-md-2 form-group" >
										<label>Porcentaje:</label>
										<div class="input-group">
											<input type="text" ng-model="porcentajeInv" class="form-control" value="{{porcentaje | currency}}" ng-readonly="true">
											<span class="input-group-addon" id="basic-addon1">%</span>
										</div>
									</div>
									<div class="col-md-2 form-group" >
										<label>Fecha:</label>
										<input type="date" ng-model="CurrentDate" class="form-control" value="{{CurrentDate | date:'dd-MM-yyyy'}}" ng-readonly="true">
									</div>
									<div class="col-md-2 form-group" >
										<label>Enganche:</label>
										<div class="input-group">
											<span class="input-group-addon" id="basic-addon1">$</span>
											<input type="text" ng-model="enganche" class="form-control" value="{{enganche | currency}}" ng-readonly="true">
										</div>
									</div>

								</div>
								<div class="row">
									<div class="col-md-6 form-group">
										<label>Días para pagar Enganche: </label>
										<select ng-model="day" id="day" ng-options="item.day for item in diasEnganche" class="form-control" ng-change="daysEng(); ChengecheckEngDif">
											<option value = ""> - Selecciona los días de enganche - </option>
										</select>
									</div>



									<div class="col-md-6 form-group" >
										<label>Enganche (%): </label>
										<div class="input-group">
											<span class="input-group-addon" id="basic-addon1">%</span>
											<input type="number" ng-model="porcentaje" max="100" id="porcentajeEnganche" min="0" class="form-control" ng-change="selectPorcentajeEnganche()" string-to-number limit-to-max>
										</div>
										<label>Enganche cantidad ($): </label>
										<div class="input-group">
											<span class="input-group-addon" id="basic-addon1">$</span>
											<input ng-model="cantidad" id="cantidadEnganche" type="number" class="form-control" min="0" ng-change="resultCantidad()" string-to-number>
										</div>
									</div>


									<!--<div ng-if="checkEngDif">-->
									<div class="col-md-2 form-group" >
										<label>Apartado ($):</label>
										<div class="input-group" >
											<span class="input-group-addon" id="basic-addon1">$</span>
											<input input-currency ng-model="apartado" class="form-control" id="aptdo">
										</div>
									</div>




									<div class="col-md-3 form-group" >
										<label>Meses a diferir:</label>
										<div class="input-group">
											<span class="input-group-addon" id="basic-addon1">#</span>
											<select ng-model="mesesdiferir" ng-options="item for item in diasDiferidos" class="form-control" ng-change="changeDaysEng()" id="msdif" >
												<option value = ""> - Selecciona los años - </option>
											</select>
										</div>
									</div>
									<!--</div>-->

								</div>

							</fieldset>
							<fieldset>
								<legend>
									<section class="content-header" style="font-family: 'Sabon LT Std', 'Hoefler Text', 'Palatino Linotype', 'Book Antiqua', serif;">
										DESCUENTOS DISPONIBLES:
									</section>
								</legend>





								<!-- /////////////////////////////////////////////////////////////////////////////////////////////////// -->
								<div class="row">
									<div class="col-md-4" ng-model="id" ng-repeat="paquete in paquetes">
										<div class="foreach">
											<input type="radio" id="checkPack" name="checkPack" required="required" ng-model="paquete.id_paquete"/>
											<span>Paquete {{paquete.descripcion}} </span>
											<div ng-repeat="descuento in paquete.response | orderBy:'-apply'">




												<div ng-if="descuento.apply == 1">
													<li class="list-group-item">
														<input type="checkbox" checklist-model="selected.descuentos" checklist-value="descuento" ng-change="selectDescuentos(descuento, checked)" ng-disabled="paquete.id_paquete"
															   id="paquete.id_paquete" ng-checked="checkedStatus"/>
														<span ng-if="descuento.id_condicion == 1 || descuento.id_condicion == 2" style="color:#000;">{{descuento.porcentaje}}% </span>
														<span ng-if="descuento.id_condicion == 3 || descuento.id_condicion == 4" style="color:#000;">{{descuento.porcentaje | currency }} </span>
														<span ng-if="descuento.id_condicion == 1 || descuento.id_condicion == 2 || descuento.id_condicion == 3" class="animate-if" style="color:#000;">Descuento al total.</span>
														<span ng-if="descuento.id_condicion == 4" class="animate-if" style="color:#000;">Descuento al total por m2.</span>
														<span ng-if="descuento.id_condicion == 6" class="animate-if" style="color:#000;">Primera Mensualidad 5/Mar/2020.</span>

														<span ng-if="descuento.id_condicion == 7" class="animate-if" style="color:#000;">No pago de mensualidades</span>


													</li>
												</div>

												<div ng-if="day.day == 7">
													<div ng-if="descuento.apply == 0">
														<li class="list-group-item">
															<input type="checkbox" checklist-model="selected.descuentos" checklist-value="descuento" ng-change="selectDescuentos(descuento, checked)" ng-disabled="paquete.id_paquete"
																   ng-checked="checkedStatus"/>
															<span ng-if="descuento.id_condicion == 1 || descuento.id_condicion == 2" style="color:#000;">{{descuento.porcentaje}}% </span>
															<span ng-if="descuento.id_condicion == 3 || descuento.id_condicion == 4" style="color:#000;">{{descuento.porcentaje | currency }} </span>
															<span ng-if="descuento.id_condicion == 1 || descuento.id_condicion == 2 || descuento.id_condicion == 3" class="animate-if" style="color:#000;">Descuento al Enganche.</span>
															<span ng-if="descuento.id_condicion == 4" class="animate-if" style="color:#000;">Descuento al total por m2.</span>
															<span ng-if="descuento.id_condicion == 6" class="animate-if" style="color:#000;">Primera Mensualidad 5/Mar/2020.</span>

															<span ng-if="descuento.id_condicion == 7" class="animate-if" style="color:#000;">No pago de mensualidades</span>


														</li>
													</div>
												</div>




											</div>
										</div>
									</div>
								</div>


							</fieldset>
							<table class="table table-striped table-bordered table-hover table-condensed">
								<tr>
									<td class="text-center">
										<label type="text">Lote</label><br>
										<label type="text"><b>{{nombreLote}}</b></label><br>
									</td>
									<td class="text-center">
										<label type="text">Plan(años)</label><br>
										<label type="text"><b>{{age_plan}}</b></label><br>
									</td>
									</td>
									<td class="text-center">
										<label type="text">Precio Lista</label><br>
										<label type="text"><b>{{precioTotal | currency }}</b></label><br>
									</td>
									<td class="text-center">
										<label type="text">Superficie</label><br>
										<label type="text"><b>{{superficie}}</b></label><br>
									</td>
									<td class="text-center" colspan="2">
										<label type="text">Precio m<sup>2 </sup></label><br>
										<label type="text"><b>{{preciom2F | currency }}</b></label><br>
									</td>
								</tr>



								<!---->
								<tr align="center">
									<td colspan="6"><label type="text">Descuentos</label></td>
								</tr>

								<tr align="center">
									<td><label type="text">Porcentaje y/o monto</label></td>
									<td><label type="text">Precio final m2</label></td>
									<td><label type="text">Precio total final</label></td>
									<td><label type="text">Ahorros</label></td>
								</tr>

								<tr ng-repeat="i in decFin">
									<td style="color:#27AE60" class="text-center"><b>
											<span ng-if="i.id_condicion == 1 || i.id_condicion == 2">{{i.porcentaje}}% </span>
											<span ng-if="i.id_condicion == 3 || i.id_condicion == 4">{{i.porcentaje | currency }} </span>
											<span ng-if="i.id_condicion == 6"> Primera Mensualidad 5/Mar/2020 </span>

											<span ng-if="i.id_condicion == 7"> No pago de mensualidades </span>


										</b></td>
									<td style="color:#2E86C1" class="text-center"><b>{{ i.pm | currency }}</b></td>
									<td style="color:#2E86C1" class="text-center"><b>{{ i.pt | currency }}</b></td>
									<td style="color:#27AE60" class="text-center"><b>{{ i.ahorro | currency }}</b></td>

								</tr>
								<!---->



								<tr align="center">
									<td colspan="6"><label type="text">Enganche diferido</label></td>
								</tr>

								<tr align="center">
									<td><label type="text">Fecha</label></td>
									<td><label type="text">Pago #</label></td>
									<td><label type="text">Total</label></td>
								</tr>
								<tr ng-repeat= "i in rangEd">

									<td class="text-center">{{ i.fecha | date:'dd-mm-yyyy'}}</td>
									<td class="text-center">{{ i.pago }}</td>
									<td class="text-center">{{ i.total | currency }}</td>

								</tr>









								<tr align="center">
									<td colspan="9" >
										<label type="text">Saldo</label><br>
										<label type="text"><b>{{saldoFinal | currency }}</b></label>
										<BR><BR>
										<label type="text" style="font-size:30px"><b>PRECIO FINAL</b></label><br>
										<label type="text" style="font-size:30px"><b>{{precioFinal | currency }}</b></label>
									</td>
								</tr>
								<tr>
									<td float="center" colspan ="2" class="text-center"><b><label type="text">Enganche</label></b></td>
									<td float="center" colspan ="4" class="text-center"><b><label type="text">Mensualidades</label></b></td>
								</tr>
								<tr>
									<td><label type="text">Días pago enganche</label></td>
									<td> <label type="text"><b> {{ daysEnganche }} </b></label></td>
									<td><b><label type="text"></label></b><label type="text">Mensualidades SIN interés</label></td>
									<td><b><label type="text"></label>{{ finalMesesp1 }}&nbsp&nbsp&nbsp</b> {{ totalPrimerPlan | currency }}</td>
									<td><label type="text">Primer mensualidad</label></td>
									<td><b><label type="text" id="dias">{{ fechaPM }}</b></label></td>
								</tr>
								<tr>
									<td><label type="text" for="fecha">Fecha Límite </label></td>
									<td> <label type="text" id="fecha"><b> {{fechaEng}} </b></label></td>
									<td><b><label type="text" id="mPlan2" name="mPlan2"></label></b><label type="text6">Mensualidades con interés (1% S.S.I.) </label></td>
									<td><b><label type="text">{{ finalMesesp2 }}&nbsp&nbsp&nbsp</b> {{ totalSegundoPlan | currency }}</label></td>
								</tr>
								<tr>
									<td><label type="text" for="fecha">Pago Enganche</label></td>
									<td>
										<label type="text"><b>{{engancheFinal | currency }}</b></label><br>
									</td>
									<td><b><label type="text" id="mPlan3" name="mPlan3"></label></b><label type="text6">Mensualidades con interés (1.25% S.S.I.) </label></td>
									<td><b><label type="text">{{ finalMesesp3 }}&nbsp&nbsp&nbsp</b> {{ totalTercerPlan | currency }}</label></td>
								</tr>
							</table>
							<table class="table table-striped table-bordered table-hover table-condensed">
								<tr>
									<td colspan="3" ><label type="text2">DATOS BANCARIOS</label></td>
								</tr>
								<tr>
									<td colspan="3" >
										<b>Banco:</b> <label type="text">{{banco}}</label>
										<b>Razón Social:</b> <label type="text">{{rsocial}}</label>
										<b>Cuenta:</b> <label type="text">{{cuenta}}</label>
										<b>CLABE:</b> <label type="text">{{clabe}}</label><p>
											<b>Referencia:</b> <label type="text" style="font-size:30px">{{referencia}}</label>
									</td>
								</tr>
								<tr>
									<td><label type="text">ASESOR</label></td>
									<td  colspan="2"><label type="text">{{asesor.nombreAsesor}}</label></td>
								</tr>
								<tr>
									<td><label type="text">OBSERVACIONES</label></td>
									<td colspan="2"><input type="text" ng-model="observaciones" class="form-control" placeholder="Describa algunas observaciones "></td>
								</tr>
								<tr>
									<td colspan="3"><label type="text2"><p>
												Precios, disponibilidad, descuentos y vigencia sujetos a cambio sin previo aviso. Esta simulación constituye un ejercicio numérico que no implica ningún compromiso de Ciudad Maderas o de sus marcas comerciales, CIUDAD MADERAS. Solo sirve para fines de orientación. Los descuentos se aplican "escalonados", primero uno y luego el siguiente. Para Compra Múltiple: familiares que comprueben parentesco, amigos o socios.
											</p></label></td>
								</tr>
							</table>


						</div >


						<!--           <div ng-if="checkEngDif">-->
						<!--<table class="table table-striped table-bordered table-hover table-condensed text-center">-->
						<!--	<tr>-->
						<!--		  <th>Fechas</th>-->
						<!--		  <th>Pago #</th>-->
						<!--		  <th>Capital</th>-->
						<!--		  <th>Intereses</th>-->
						<!--		  <th>Total</th>-->
						<!--		  <th>Saldo</th>-->
						<!--	</tr>-->
						<!--	<tr ng-repeat= "i in rangEd">-->

						<!--		  <td>{{ i.fecha | date:'dd-mm-yyyy'}}</td>-->
						<!--		  <td>{{ i.pago }}</td>              -->
						<!--		  <td>{{ i.capital | currency }}</td>-->
						<!--		  <td>{{ i.interes | currency }}</td>-->
						<!--		  <td>{{ i.total | currency }}</td>-->
						<!--		  <td>{{ i.saldo | currency }}</td>-->

						<!--	</tr>-->
						<!--</table>-->
						<!--           </div>-->







						<table datatable="ng" class="table table-striped table-bordered table-hover table-condensed text-center" dt-options="dtoptions" dt-columns="dtColumns" dt-column-defs="dtColumnDefs">
							<!--   <thead>-->
							<!--<tr>-->
							<!--	  <th>Fechas</th>-->
							<!--	  <th>Pago #</th>-->
							<!--	  <th>Capital</th>-->
							<!--	  <th>Intereses</th>-->
							<!--	  <th>Total</th>-->
							<!--	  <th>Saldo</th>-->
							<!--</tr>-->
							<!--                  </thead>-->
							<!--                  <tbody>-->



							<!--	<tr ng-repeat= "i in rangEds">-->

							<!--		  <td>{{ i.fecha | date:'dd-mm-yyyy'}}</td>-->
							<!--		  <td>{{ i.pago }}</td>              -->
							<!--		  <td>{{ i.capital | currency }}</td>-->
							<!--		  <td>{{ i.interes | currency }}</td>-->
							<!--		  <td>{{ i.total | currency }}</td>-->
							<!--		  <td>{{ i.saldo | currency }}</td>-->
							<!--	</tr>-->

							<!--	<tr ng-repeat= "i in range">-->

							<!--		  <td>{{ i.fecha | date:'dd-mm-yyyy'}}</td>-->
							<!--		  <td>{{ i.pago }}</td>              -->
							<!--		  <td>{{ i.capital | currency }}</td>-->
							<!--		  <td>{{ i.interes | currency }}</td>-->
							<!--		  <td>{{ i.total | currency }}</td>-->
							<!--		  <td>{{ i.saldo | currency }}</td>-->

							<!--	</tr>-->
							<!--</table>-->

							<!--<table class="table table-striped table-bordered table-hover table-condensed text-center">-->
							<!--	<tr>-->
							<!--		  <th>Fechas</th>-->
							<!--		  <th>Pago #</th>-->
							<!--		  <th>Capital</th>-->
							<!--		  <th>Intereses</th>-->
							<!--		  <th>Total</th>-->
							<!--		  <th>Saldo</th>-->
							<!--	</tr>-->
							<!--	<tr ng-repeat= "i in range2">-->

							<!--		  <td>{{ i.fecha | date:'dd-MM-yyyy'}}</td>-->
							<!--		  <td>{{ i.pago }}</td>              -->
							<!--		  <td>{{ i.capital | currency }}</td>-->
							<!--		  <td>{{ i.interes | currency }}</td>-->
							<!--		  <td>{{ i.total | currency }}</td>-->
							<!--		  <td>{{ i.saldo | currency }}</td>-->

							<!--	</tr>-->
							<!--</table> -->
							<!--<table class="table table-striped table-bordered table-hover table-condensed text-center">-->
							<!--	<tr>-->
							<!--		  <th>Fechas</th>-->
							<!--		  <th>Pago #</th>-->
							<!--		  <th>Capital</th>-->
							<!--		  <th>Intereses</th>-->
							<!--		  <th>Total</th>-->
							<!--		  <th>Saldo</th>-->
							<!--	</tr>-->
							<!--	<tr ng-repeat= "i in range3">-->

							<!--		  <td>{{ i.fecha | date:'dd-MM-yyyy'}}</td>-->
							<!--		  <td>{{ i.pago }}</td>              -->
							<!--		  <td>{{ i.capital | currency }}</td>-->
							<!--		  <td>{{ i.interes | currency }}</td>-->
							<!--		  <td>{{ i.total | currency }}</td>-->
							<!--		  <td>{{ i.saldo | currency }}</td>-->

							<!--	</tr>-->
							<!--</tbody>-->
						</table>
					</div>
				</div>
			</div>

		</div>
	</section>












	<script>
		var myApp = angular.module ('myApp', ['checklist-model','datatables', 'datatables.buttons']);



		myApp.directive('stringToNumber', function() {
			return {
				require: 'ngModel',
				link: function(scope, element, attrs, ngModel) {
					ngModel.$parsers.push(function(value) {
						return '' + value;
					});
					ngModel.$formatters.push(function(value) {
					});
				}
			};
		});



		myApp.directive('inputCurrency', ['$locale', '$filter', function($locale, $filter) {

			// For input validation
			var isValid = function(val) {
				return angular.isNumber(val) && !isNaN(val);
			};

			// Helper for creating RegExp's
			var toRegExp = function(val) {
				var escaped = val.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
				return new RegExp(escaped, 'g');
			};

			// Saved to your $scope/model
			var toModel = function(val) {

				// Locale currency support
				var decimal = toRegExp($locale.NUMBER_FORMATS.DECIMAL_SEP);
				var group = toRegExp($locale.NUMBER_FORMATS.GROUP_SEP);
				var currency = toRegExp($locale.NUMBER_FORMATS.CURRENCY_SYM);

				// Strip currency related characters from string
				val = val.replace(decimal, '').replace(group, '').replace(currency, '').trim();

				return parseInt(val, 10);
			};

			// Displayed in the input to users
			var toView = function(val) {
				return $filter('currency')(val, '$', 0);
			};

			// Link to DOM
			var link = function($scope, $element, $attrs, $ngModel) {
				$ngModel.$formatters.push(toView);
				$ngModel.$parsers.push(toModel);
				$ngModel.$validators.currency = isValid;

				$element.on('keyup', function() {
					$ngModel.$viewValue = toView($ngModel.$modelValue);
					$ngModel.$render();
				});
			};

			return {
				restrict: 'A',
				require: 'ngModel',
				link: link
			};
		}]);



		myApp.controller('myController', function ($scope, $http, $window, DTOptionsBuilder, DTColumnBuilder) {

			var descuentosAplicados = [];

			// var range=[];
			// var range2=[];
			// var range3=[];

			// $scope.range= 0;
			// $scope.range2= 0;
			// $scope.range3= 0;



			$scope.mesesdiferir = 0;

			$scope.resultCantidad = function () {
				$scope.uno = parseFloat($scope.cantidad);
				$scope.dos =  ($scope.uno / $scope.total);
				$scope.result =  ($scope.dos * parseFloat(100));
				$scope.cantidadFR = parseFloat($scope.result.toFixed(6));
				$scope.porcentajeEng = $scope.cantidadFR;

				//comienza nueva funcion
				var porcentajeEnganche = angular.element(document.querySelector('#porcentajeEnganche'));
				var cantidadEnganche  =  angular.element(document.querySelector('#cantidadEnganche'));
				var r1 = $scope.total;
				var cantidadToGetP = (( 100 * cantidadEnganche.val())/r1);
				porcentajeEnganche.val(parseFloat(cantidadToGetP).toFixed(2));
				//termina nueva sección



				calcularCF();
			};



			$scope.selected = {

			};

			$scope.porcentaje = $scope.porcentajeEng = 0;

			$scope.selectDescuentos = function(descuento, checked){

				var idx = descuentosAplicados.indexOf(descuento);
				if (idx >= 0 && !checked) {
					descuentosAplicados.splice(idx, 1);
					$scope.descApply = descuentosAplicados;
				}

				if (idx < 0 && checked) {
					descuentosAplicados.push(descuento);
					$scope.descApply = descuentosAplicados;
				}

				calcularCF();

			}


			function calcularCF(){


///////////////////////////////////////

				var applyTotal = descuentosAplicados.filter(function(condicion) {
					return condicion.apply === '1';
				});

				var orderTotal = applyTotal.sort((a, b) => a.prioridad - b.prioridad)



//////////////////////////////////////

				var applyEnganche = descuentosAplicados.filter(function(condicion) {
					return condicion.apply === '0';
				});

				var orderEnganche = applyEnganche.sort((a, b) => a.prioridad - b.prioridad)



///////////////////////////////////////////




				var porcentaje1 = 0;
				var porcentaje2 = 0;
				var porcentajeDeEnganche = $scope.porcentajeEng;
				var r1 = $scope.total;
				var descEng = 0;
				var enganche = 0;
				var supLote = $scope.superficie;



////////////////////////////// VARIABLES DESCRIPCION DE DESCUENTOS

				var a = 0;
				var b = 0;
				var c = 0;
				var e = 0;
				var f = 0;
				var g = 0;
				var tot = $scope.total;
				var arreglo = [];
				var arreglo2 = [];
				var ultimoAhorro = 0;
				var ultimoAhorropt = 0;
				var ultimoAhorropm = 0;

////////////////////////// FIN VARIABLES DESCRIPCION DE DESCUENTOS



				if (porcentajeDeEnganche === 0 && orderEnganche.length === 0 && orderTotal.length === 0){
					r1

					$scope.decFin = [];

				} else if(porcentajeDeEnganche != 0 && orderEnganche.length === 0 && orderTotal.length === 0){


					$scope.decFin = [];

					enganche = (r1 * (porcentajeDeEnganche / 100));
					r1= (r1 - enganche);


				} else if(porcentajeDeEnganche != 0 && orderEnganche.length > 0 && orderTotal.length === 0){

					enganche = (r1 * (porcentajeDeEnganche / 100));
					r1= (r1 - enganche);

					angular.forEach(orderEnganche, function(item, index) {
						porcentaje1 = (item.porcentaje/100);
						porcentaje2 = (enganche * porcentaje1);

						descEng = porcentaje2;


////////////////////PORCENTAJE TOPADO A $20,000////////////////////////////////
						if(item.eng_top == 1){
							if (descEng > 20000){
								descEng = 20000;
								enganche = (enganche - descEng);
							} else {
								descEng = porcentaje2;
								enganche = (enganche - descEng);
							}
						} else {
							descEng = porcentaje2;
							enganche = (enganche - descEng);
						}
////////////////////PORCENTAJE TOPADO A $20,000////////////////////////////////



///////////////////////DESCIPCION DE DESCUENTOS////////////////////////////////////////
						a +=  descEng;
						b = (tot - a);
						c = (b/supLote);
						arreglo.push({ahorro: a, pm: c, pt: b, td:2, porcentaje: item.porcentaje, id_condicion: item.id_condicion});
						$scope.decFin =arreglo;
///////////////////////DESCIPCION DE DESCUENTOS////////////////////////////////////////

					});

				}


				////////////////////////////////////////////////////////////


				else if(porcentajeDeEnganche === 0 && orderEnganche.length === 0 && orderTotal.length > 0){

					angular.forEach(orderTotal, function(item, index) {

						if(item.id_condicion == 1 || item.id_condicion == 2){
							porcentaje1 = (item.porcentaje/100);
							porcentaje2 = (r1 * porcentaje1);
							r1 -= porcentaje2;
						}

						if(item.id_condicion == 3){
							porcentaje2 = parseFloat(item.porcentaje);
							r1 = (r1 - porcentaje2);
						}


						if(item.id_condicion == 4){
							porcentaje1 = (item.porcentaje);
							porcentaje2 = (supLote * porcentaje1);
							r1 -= porcentaje2;
						}

						// if(item.id_condicion == 5){
						// porcentaje1 = (item.porcentaje);
						// porcentaje2 = (supLote * porcentaje1);
						// r1 = (parseFloat(r1) + porcentaje2);
						// }

///////////////////////DESCIPCION DE DESCUENTOS////////////////////////////////////////
						a +=  porcentaje2;
						b = (tot - a);
						c = (b/supLote);
						arreglo.push({ahorro: a, pm: c, pt: b, td:1, porcentaje: item.porcentaje, id_condicion: item.id_condicion});
						$scope.decFin =arreglo;

///////////////////////DESCIPCION DE DESCUENTOS////////////////////////////////////////

					});

				} else if(porcentajeDeEnganche != 0 && orderEnganche.length === 0 && orderTotal.length > 0){

					angular.forEach(orderTotal, function(item, index) {

						if(item.id_condicion == 1 || item.id_condicion == 2){
							porcentaje1 = (item.porcentaje/100);
							porcentaje2 = (r1 * porcentaje1);
							r1 -= porcentaje2;
						}

						if(item.id_condicion == 3){
							porcentaje2 = parseFloat(item.porcentaje);
							r1 = (r1 - porcentaje2);
						}


						if(item.id_condicion == 4){
							porcentaje1 = (item.porcentaje);
							porcentaje2 = (supLote * porcentaje1);
							r1 -= porcentaje2;
						}



///////////////////////DESCIPCION DE DESCUENTOS////////////////////////////////////////
						a +=  porcentaje2;
						b = (tot - a);
						c = (b/supLote);
						arreglo.push({ahorro: a, pm: c, pt: b, td:1, porcentaje: item.porcentaje, id_condicion: item.id_condicion});
						$scope.decFin =arreglo;

///////////////////////DESCIPCION DE DESCUENTOS////////////////////////////////////////


					});

					enganche = (r1 * (porcentajeDeEnganche / 100));
					r1= (r1 - enganche);

				}

				else if(porcentajeDeEnganche != 0 && orderEnganche.length > 0 && orderTotal.length > 0){


					angular.forEach(orderTotal, function(item, index) {

						if(item.id_condicion == 1 || item.id_condicion == 2){
							porcentaje1 = (item.porcentaje/100);
							porcentaje2 = (r1 * porcentaje1);
							r1 -= porcentaje2;

						}


						if(item.id_condicion == 3){
							porcentaje2 = parseFloat(item.porcentaje);
							r1 = (r1 - porcentaje2);
						}


						if(item.id_condicion == 4){
							porcentaje1 = (item.porcentaje);
							porcentaje2 = (supLote * porcentaje1);
							r1 -= porcentaje2;
						}

///////////////////////DESCIPCION DE DESCUENTOS////////////////////////////////////////
						a +=  porcentaje2;
						b = (tot - a);
						c = (b/supLote);
						arreglo.push({ahorro: a, pm: c, pt: b, td:1, porcentaje: item.porcentaje, id_condicion: item.id_condicion});
						$scope.add =arreglo;
///////////////////////DESCIPCION DE DESCUENTOS////////////////////////////////////////

					});


					enganche = (r1 * (porcentajeDeEnganche / 100));
					r1= (r1 - enganche);

					angular.forEach(orderEnganche, function(item, index) {
						porcentaje1 = (item.porcentaje/100);
						porcentaje2 = (enganche * porcentaje1);
						descEng = porcentaje2;

////////////////////PORCENTAJE TOPADO A $20,000////////////////////////////////
						if(item.eng_top == 1){
							if (descEng > 20000){
								descEng = 20000;
								enganche = (enganche - descEng);
							} else {
								descEng = porcentaje2;
								enganche = (enganche - descEng);
							}
						} else {
							descEng = porcentaje2;
							enganche = (enganche - descEng);
						}
////////////////////PORCENTAJE TOPADO A $20,000////////////////////////////////



						$scope.desc2 = ($scope.desc1 + descEng);
						$scope.desc1t2 = ($scope.desc1t - descEng);
						$scope.desc1m2 = ($scope.desc1t2/supLote);


///////////////////////DESCIPCION DE DESCUENTOS////////////////////////////////////////

						ultimoAhorro = $scope.add[$scope.add.length - 1].ahorro;
						ultimoAhorropt = $scope.add[$scope.add.length - 1].pt;
						ultimoAhorropm = $scope.add[$scope.add.length - 1].pm;
						e = (ultimoAhorro + descEng);
						f = (ultimoAhorropt - descEng);
						g = (f/supLote);
						arreglo2.push({ahorro: e, pm: g, pt: f, td:2, porcentaje: item.porcentaje, id_condicion: item.id_condicion});
						$scope.add2 =arreglo2;
						$scope.decFin = $scope.add.concat($scope.add2);

///////////////////////DESCIPCION DE DESCUENTOS////////////////////////////////////////

					});
				}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

				var ini;
				var ini2;
				var ini3;

//INICIO FECHA
				var day;
				var month = (new Date().getMonth() + 1);
				var yearc = new Date().getFullYear();


				if (month == 1){
					day = '0' + 1;
				}
				if (month == 2){
					day = '0 '+ 2;
				}
				if (month == 3){
					day = '0' + 3;
				}
				if (month == 4){
					day = '0' + 6;
				}
				if (month == 5){
					day = '0' + 7;
				}
				if (month == 6){
					day = '0' + 8;
				}
				if (month == 7){
					day = 11;
				}
				if (month == 8){
					day = 12;
				}
				if (month == 9){
					day = 13;
				}
				if (month == 10){
					day = 14;
				}
				if (month == 11){
					day = 16;
				}
				if (month == 12){

					if ($scope.descDate == 0){
						day = 17;

					} else if($scope.descDate == 1) {
						day = 5;

					}

				}

				var mes = ($scope.apartado && $scope.mesesdiferir > 0) ? (new Date().getMonth() + 2) : (new Date().getMonth() + 3);

//FIN FECHA




/////////////////////////// ENGANCHE DIFERIDO ////////////////////////////////////

				if($scope.day && $scope.apartado && $scope.mesesdiferir > 0){

					var engd = (enganche - $scope.apartado);
					var engd2 = (engd/$scope.mesesdiferir);
					var saldoDif = ($scope.precioFinal - $scope.apartado);

					var rangEd=[];
					for (var e = 0; e < $scope.mesesdiferir; e++) {

						if(mes == 13){
							mes = '01';
							yearc++;
						}
						if(mes == 2){
							mes = '02';
						}
						if(mes == 3){
							mes = '03';
						}
						if(mes == 4){
							mes = '04';
						}
						if(mes == 5){
							mes = '05';
						}
						if(mes == 6){
							mes = '06';
						}
						if(mes == 7){
							mes = '07';
						}
						if(mes == 8){
							mes = '08';
						}
						if(mes == 9){
							mes = '09';
						}
						if(mes == 10){
							mes = '10';
						}
						if(mes == 11){
							mes = '11';
						}
						if(mes == 12){
							mes = '12';
						}
						$scope.dateCf = day + '-' + mes + '-' + yearc;

						if(e == 0){
							$scope.fechaPM = $scope.dateCf;
						}

						rangEd.push({
							"fecha" : $scope.dateCf,
							"pago" : e + 1,
							"capital" : engd2,
							"interes" : 0,
							"total" : engd2,
							"saldo" : saldoDif -= engd2,

						});
						mes++;
					}

					$scope.rangEd= rangEd;

				}

/////////////////////////// ENGANCHE DIFERIDO ////////////////////////////////////




				$scope.infoLote={

					precioTotal: r1,
					yPlan: $scope.age_plan,
					msn: $scope.msni,
					meses: ($scope.age_plan*12),
					mesesSinInteresP1: $scope.msni,
					mesesSinInteresP2: 120,
					mesesSinInteresP3: 60,
					interes_p1: 0,
					interes_p2: 0.01,
					interes_p3: 0.0125,
					contadorInicial: 0,
					capital: ($scope.mesesdiferir > 0) ? (r1 / (($scope.age_plan*12) - $scope.mesesdiferir)) : (r1 / ($scope.age_plan*12)),
					fechaActual: $scope.date = new Date(),
					engancheF: enganche
				}

				$scope.engancheFinal = ($scope.infoLote.engancheF);
				$scope.saldoFinal = $scope.infoLote.precioTotal;
				$scope.precioFinal = ($scope.infoLote.precioTotal + $scope.infoLote.engancheF);

				$scope.preciom2F = ($scope.preciom2);






				/////////// TABLES DE 1 A 3 AÑOS ////////////


				if($scope.infoLote.meses >=12 && $scope.infoLote.meses <= 36)
				{
					var range=[];
					ini = ($scope.mesesdiferir > 0) ? $scope.mesesdiferir : $scope.infoLote.contadorInicial;
					//////////////////////// ON PLAN CONTRUCTOR ////////////////////////////////////
					if($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <=35 && $scope.noPagomensualidad == 1)
					{
						ini =  $scope.infoLote.contadorInicial;
						if($scope.noPagomensualidad == 1)
						{
							////////////////////////////////////////////////////////////////////////////////////
							var rangePlanc=[];
							for (var i = ini; i < 12; i++)
							{
								if( (mes == 13) || (mes == 14) )
								{
									if ($scope.descDate == 0){
										if(mes == 13){
											mes = '01';
											yearc++;
										} else if (mes == 14) {
											mes = '02';
											yearc++;
										}
									} else if($scope.descDate == 1) {
										mes = '03';
										$scope.descDate = 0;
									}
								}
								if(mes == 2){
									mes = '02';
								}
								if(mes == 3){
									mes = '03';
								}
								if(mes == 4){
									mes = '04';
								}
								if(mes == 5){
									mes = '05';
								}
								if(mes == 6){
									mes = '06';
								}
								if(mes == 7){
									mes = '07';
								}
								if(mes == 8){
									mes = '08';
								}
								if(mes == 9){
									mes = '09';
								}
								if(mes == 10){
									mes = '10';
								}
								if(mes == 11){
									mes = '11';
								}
								if(mes == 12){
									mes = '12';
								}
								$scope.dateCf = day + '-' + mes + '-' + yearc;
								rangePlanc.push({
									"fecha" : $scope.dateCf,
									"pago" : i + 1,
									"capital" : 0,
									"interes" : 0,
									"total" : 0,
									"saldo" : $scope.saldoFinal,
								});
								mes++;
								$scope.finalMesesp1PlanC = rangePlanc.length;
								ini = rangePlanc.length;
							}
							$scope.rangePlanc = rangePlanc;
							////////////////////////////////////////////////////////////////////////////////////



							for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++)
							{
								if( (mes == 13) || (mes == 14) )
								{
									if ($scope.descDate == 0)
									{
										if(mes == 13){
											mes = '01';
											yearc++;
										} else if (mes == 14) {
											mes = '02';
											yearc++;
										}
									} else if($scope.descDate == 1) {
										mes = '03';
										$scope.descDate = 0;
									}
								}
								if(mes == 2){
									mes = '02';
								}
								if(mes == 3){
									mes = '03';
								}
								if(mes == 4){
									mes = '04';
								}
								if(mes == 5){
									mes = '05';
								}
								if(mes == 6){
									mes = '06';
								}
								if(mes == 7){
									mes = '07';
								}
								if(mes == 8){
									mes = '08';
								}
								if(mes == 9){
									mes = '09';
								}
								if(mes == 10){
									mes = '10';
								}
								if(mes == 11){
									mes = '11';
								}
								if(mes == 12){
									mes = '12';
								}

								$scope.dateCf = day + '-' + mes + '-' + yearc;

								if(i == 12){
									$scope.fechaPM = $scope.dateCf;
								}


								range.push({
									"fecha" : $scope.dateCf,
									"pago" : i + 1,
									"capital" : $scope.infoLote.capital,
									"interes" : 0,
									"total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
									"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,
								});
								mes++;
								if (i == ($scope.infoLote.mesesSinInteresP1 - 1)){
									$scope.total2 = $scope.infoLote.precioTotal;
									$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;
								}
								$scope.finalMesesp1 = range.length;
								ini2 = (range.length + rangePlanc.length);
							}
							$scope.range= range;

							//////////

							$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses + 12) - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses + 12) - $scope.infoLote.mesesSinInteresP1 )-1);

							var range2=[];

							for (var i = ini2; i < ($scope.infoLote.meses + 12); i++) {

								if( (mes == 13) || (mes == 14) )
								{
									if(mes == 13){
										mes = '01';
										yearc++;
									} else if (mes == 14) {
										mes = '02';
										yearc++;
									}
								}

								if(mes == 2){
									mes = '02';
								}
								if(mes == 3){
									mes = '03';
								}
								if(mes == 4){
									mes = '04';
								}
								if(mes == 5){
									mes = '05';
								}
								if(mes == 6){
									mes = '06';
								}
								if(mes == 7){
									mes = '07';
								}
								if(mes == 8){
									mes = '08';
								}
								if(mes == 9){
									mes = '09';
								}
								if(mes == 10){
									mes = '10';
								}
								if(mes == 11){
									mes = '11';
								}
								if(mes == 12){
									mes = '12';
								}


								$scope.dateCf = day + '-' + mes + '-' + yearc;

								$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
								$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

								range2.push({

									"fecha" : $scope.dateCf,
									"pago" : i + 1,
									"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
									"interes" : ($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
									"total" : $scope.p2,
									"saldo" : ($scope.total2 = ($scope.total2 -$scope.capital2)),

								});
								mes++;


								if (i == ($scope.infoLote.meses - 1)){
									$scope.totalSegundoPlan = $scope.p2;

								}
								$scope.finalMesesp2 = (range2.length);
							}
							$scope.range2= range2;

							// $scope.alphaNumeric = $scope.rangEd.concat($scope.range);
							// $scope.alphaNumeric = $scope.dani.concat($scope.range2);
							// $scope.alphaNumeric = $scope.range.concat($scope.range2);

							$scope.alphaNumeric = $scope.rangePlanc.concat($scope.range).concat($scope.range2);
							$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
									{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
									{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
									{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
									{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
											//pageMargins [left, top, right, bottom]
											doc.pageMargins = [ 140, 40, 10, 50 ];
											doc.alignment = 'center';
										}},
								]
							).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});



						}
					}
					//////////////////////// OFF PLAN CONTRUCTOR ////////////////////////////////////
					// if($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <=35 && $scope.noPagomensualidad == 0)
					// {
					//
					//
					// 	for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {
					//
					// 		if( (mes == 13) || (mes == 14) ){
					//
					// 			if ($scope.descDate == 0){
					//
					// 				if(mes == 13){
					//
					// 					mes = '01';
					// 					yearc++;
					//
					// 				} else if (mes == 14) {
					//
					// 					mes = '02';
					// 					yearc++;
					//
					// 				}
					//
					// 			} else if($scope.descDate == 1) {
					// 				mes = '03';
					// 				$scope.descDate = 0;
					//
					//
					// 			}
					//
					// 		}
					//
					// 		if(mes == 2){
					// 			mes = '02';
					// 		}
					// 		if(mes == 3){
					// 			mes = '03';
					// 		}
					// 		if(mes == 4){
					// 			mes = '04';
					// 		}
					// 		if(mes == 5){
					// 			mes = '05';
					// 		}
					// 		if(mes == 6){
					// 			mes = '06';
					// 		}
					// 		if(mes == 7){
					// 			mes = '07';
					// 		}
					// 		if(mes == 8){
					// 			mes = '08';
					// 		}
					// 		if(mes == 9){
					// 			mes = '09';
					// 		}
					// 		if(mes == 10){
					// 			mes = '10';
					// 		}
					// 		if(mes == 11){
					// 			mes = '11';
					// 		}
					// 		if(mes == 12){
					// 			mes = '12';
					// 		}
					//
					// 		$scope.dateCf = day + '-' + mes + '-' + yearc;
					//
					// 		if(i == 0){
					// 			$scope.fechaPM = $scope.dateCf;
					// 		}
					//
					// 		range.push({
					//
					// 			"fecha" : $scope.dateCf,
					// 			"pago" : i + 1,
					// 			"capital" : $scope.infoLote.capital,
					// 			"interes" : 0,
					// 			"total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
					// 			"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,
					//
					// 		});
					// 		mes++;
					//
					// 		if (i == ($scope.infoLote.mesesSinInteresP1 - 1)){
					// 			$scope.total2 = $scope.infoLote.precioTotal;
					// 			$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;
					//
					// 		}
					//
					// 		$scope.finalMesesp1 = range.length;
					// 		ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
					// 	}
					// 	$scope.range= range;
					//
					// 	//////////
					//
					// 	$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
					//
					// 	var range2=[];
					//
					// 	for (var i = ini2; i < $scope.infoLote.meses; i++) {
					//
					// 		if( (mes == 13) || (mes == 14) ){
					//
					// 			if(mes == 13){
					//
					// 				mes = '01';
					// 				yearc++;
					//
					// 			} else if (mes == 14) {
					//
					// 				mes = '02';
					// 				yearc++;
					//
					// 			}
					//
					// 		}
					//
					// 		if(mes == 2){
					// 			mes = '02';
					// 		}
					// 		if(mes == 3){
					// 			mes = '03';
					// 		}
					// 		if(mes == 4){
					// 			mes = '04';
					// 		}
					// 		if(mes == 5){
					// 			mes = '05';
					// 		}
					// 		if(mes == 6){
					// 			mes = '06';
					// 		}
					// 		if(mes == 7){
					// 			mes = '07';
					// 		}
					// 		if(mes == 8){
					// 			mes = '08';
					// 		}
					// 		if(mes == 9){
					// 			mes = '09';
					// 		}
					// 		if(mes == 10){
					// 			mes = '10';
					// 		}
					// 		if(mes == 11){
					// 			mes = '11';
					// 		}
					// 		if(mes == 12){
					// 			mes = '12';
					// 		}
					//
					//
					// 		$scope.dateCf = day + '-' + mes + '-' + yearc;
					//
					// 		$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
					// 		$scope.capital2 = ($scope.p2 - $scope.interes_plan2);
					//
					// 		range2.push({
					//
					// 			"fecha" : $scope.dateCf,
					// 			"pago" : i + 1,
					// 			"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
					// 			"interes" : ($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
					// 			"total" : $scope.p2,
					// 			"saldo" : ($scope.total2 = ($scope.total2 -$scope.capital2)),
					//
					// 		});
					// 		mes++;
					//
					//
					// 		if (i == ($scope.infoLote.meses - 1)){
					// 			$scope.totalSegundoPlan = $scope.p2;
					//
					// 		}
					// 		$scope.finalMesesp2 = (range2.length);
					// 	}
					// 	$scope.range2= range2;
					//
					//
					// 	// $scope.alphaNumeric = $scope.rangEd.concat($scope.range);
					// 	// $scope.alphaNumeric = $scope.dani.concat($scope.range2);
					// 	// $scope.alphaNumeric = $scope.range.concat($scope.range2);
					//
					//
					// 	$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
					// 	$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2);
					//
					//
					//
					// 	$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
					// 			{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
					// 			{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
					// 			{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
					// 			{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
					// 					//pageMargins [left, top, right, bottom]
					// 					doc.pageMargins = [ 140, 40, 10, 50 ];
					// 					doc.alignment = 'center';
					//
					// 				}},
					// 		]
					// 	).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
					//
					//
					//
					// }
					// if($scope.infoLote.mesesSinInteresP1 == 0)
					// {
					//
					// 	$scope.infoLote.mesesSinInteresP1 = ($scope.mesesdiferir > 0 ) ? ($scope.infoLote.mesesSinInteresP1 + $scope.mesesdiferir) : ($scope.infoLote.mesesSinInteresP1);
					//
					//
					// 	$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.infoLote.precioTotal)
					// 		/ ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
					//
					// 	var range2=[];
					//
					// 	for (var i = ini; i < $scope.infoLote.meses; i++) {
					//
					// 		if( (mes == 13) || (mes == 14) ){
					//
					// 			if(mes == 13){
					//
					// 				mes = '01';
					// 				yearc++;
					//
					// 			} else if (mes == 14) {
					//
					// 				mes = '02';
					// 				yearc++;
					//
					// 			}
					//
					// 		}
					//
					// 		if(mes == 2){
					// 			mes = '02';
					// 		}
					// 		if(mes == 3){
					// 			mes = '03';
					// 		}
					// 		if(mes == 4){
					// 			mes = '04';
					// 		}
					// 		if(mes == 5){
					// 			mes = '05';
					// 		}
					// 		if(mes == 6){
					// 			mes = '06';
					// 		}
					// 		if(mes == 7){
					// 			mes = '07';
					// 		}
					// 		if(mes == 8){
					// 			mes = '08';
					// 		}
					// 		if(mes == 9){
					// 			mes = '09';
					// 		}
					// 		if(mes == 10){
					// 			mes = '10';
					// 		}
					// 		if(mes == 11){
					// 			mes = '11';
					// 		}
					// 		if(mes == 12){
					// 			mes = '12';
					// 		}
					//
					//
					// 		$scope.dateCf = day + '-' + mes + '-' + yearc;
					//
					// 		$scope.interes_plan2 = $scope.infoLote.precioTotal * ($scope.infoLote.interes_p2);
					// 		$scope.capital2 = ($scope.p2 - $scope.interes_plan2);
					//
					// 		range2.push({
					//
					// 			"fecha" : $scope.dateCf,
					// 			"pago" : i + 1,
					// 			"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
					// 			"interes" : ($scope.interes_plan2= ($scope.infoLote.precioTotal * $scope.infoLote.interes_p2)),
					// 			"total" : $scope.p2,
					// 			"saldo" : ($scope.infoLote.precioTotal = ($scope.infoLote.precioTotal -$scope.capital2)),
					//
					// 		});
					// 		mes++;
					//
					// 		if (i == ($scope.infoLote.meses - 1)){
					// 			$scope.totalSegundoPlan = $scope.p2;
					//
					// 		}
					// 		$scope.finalMesesp2 = (range2.length);
					// 	}
					// 	$scope.range2= range2;
					//
					// 	$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
					// 	$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range2);
					// 	// $scope.alphaNumeric = $scope.range2;
					//
					//
					// 	$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
					// 			{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
					// 			{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
					// 			{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
					// 			{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
					// 					//pageMargins [left, top, right, bottom]
					// 					doc.pageMargins = [ 140, 40, 10, 50 ];
					// 					doc.alignment = 'center';
					//
					// 				}},
					// 		]
					// 	).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
					//
					//
					//
					// }
					if($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <= 35  && $scope.noPagomensualidad == 0)
					{


						for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

							if( (mes == 13) || (mes == 14) ){

								if ($scope.descDate == 0){

									if(mes == 13){

										mes = '01';
										yearc++;

									} else if (mes == 14) {

										mes = '02';
										yearc++;

									}

								} else if($scope.descDate == 1) {
									mes = '03';
									$scope.descDate = 0;


								}

							}

							if(mes == 2){
								mes = '02';
							}
							if(mes == 3){
								mes = '03';
							}
							if(mes == 4){
								mes = '04';
							}
							if(mes == 5){
								mes = '05';
							}
							if(mes == 6){
								mes = '06';
							}
							if(mes == 7){
								mes = '07';
							}
							if(mes == 8){
								mes = '08';
							}
							if(mes == 9){
								mes = '09';
							}
							if(mes == 10){
								mes = '10';
							}
							if(mes == 11){
								mes = '11';
							}
							if(mes == 12){
								mes = '12';
							}

							$scope.dateCf = day + '-' + mes + '-' + yearc;

							if(i == 0){
								$scope.fechaPM = $scope.dateCf;
							}
							var numfinalCount = i+1;
							//new code 18 FEB
							$scope.pagoACapital = function()
							{
								var PagoACapital	=	document.getElementsByName("pagoACapitalNameJS")[0].value;
								var PositionPago	=	document.getElementsByName("pagoACapitalNumberJS")[0].value;
								// console.log("alv, ya llegé aquinumaaaa: " + PagoACapital);
								// console.log("se ingreso un pago en en la mensaualidad: " + PositionPago);
								var saldo	=	 PagoACapital;
								var saldoFinalisimo	=	($scope.saldoFinal - $scope.infoLote.capital);//
								var saldoMenosPC	=	saldoFinalisimo - saldo;
								// $scope.total = saldoFinalisimo - saldo;
								// $scope.porcentajeEng = 0;
								// console.log($scope.total);
								// console.log($scope.precioFinal + " " + (($scope.saldoFinal - $scope.infoLote.capital)) + " " + saldo + " REST " + (saldoMenosPC) );
								// calcularCF();
								// for(var n = 0; n<=i-1 ; n++)
								// {
								// }
								var posicionPay =	PositionPago-1;
								var saldoActual	=	$scope.alphaNumeric[posicionPay]['saldo'];
								var nuevoSaldo	=	($scope.alphaNumeric[posicionPay]['saldo'] - PagoACapital);
								var TestEng = $scope.cantidad;
								// console.log("Saldo actual: " + saldoActual);
								$scope.alphaNumeric[posicionPay]['saldo'] = $scope.alphaNumeric[posicionPay]['saldo'] - PagoACapital;
								// console.log("Este es el nuevo saldo: " + nuevoSaldo);

								// $scope.infoLote.capital=0;
								var posPay = PositionPago-1;
								calcularCF2(nuevoSaldo, posPay, saldo, saldoMenosPC);
								/*aqui me quede con la busqueda de la actualizacion de la tabla*/
							}
							/*nuevo código 24 de FEB*/
							var disp = 0;
							var interes = 0;
							var total = 0;
							var capital = 0;
							if ($scope.infoLote.mesesSinInteresP1 == 0) {
								interes = ($scope.interes_plan2= ($scope.infoLote.precioTotal  * $scope.infoLote.interes_p2));
								capital = ($scope.capital2 = ((($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1)) - $scope.interes_plan2));
								total = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
							}
							else
							{
								capital = $scope.infoLote.capital;
								interes = 0;
								total = $scope.infoLote.capital + $scope.infoLote.interes_p1;
							}
							range.push({
								"fecha" : $scope.dateCf,
								"pago" : i + 1,
								"capital" : capital,
								"interes" : interes,
								"total" : total,
								"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
								"pagoCapital"	:	"",// btnmodal+modalBody --- inputToIns onclick='javascript:console.log(65);' //<button ng-click='addNewChoice()' class='btn btn-success' style='width: 20%;float:right' ><i class='fa fa-plus'></i></button>
							});
							window['pagoCapChange' + numfinalCount]=Function("","console.log('pagoCapChange"+numfinalCount+" el parametro es: " + document.getElementById('#idModel'+numfinalCount) + "');");//angular.element(document.querySelector('#idModel'+numfinalCount))

							//end new code


							//original code 18enero20
							// range.push({
							//
							// 	"fecha" : $scope.dateCf,
							// 	"pago" : i + 1,
							// 	"capital" : $scope.infoLote.capital,
							// 	"interes" : 0,
							// 	"total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
							// 	"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,
							//
							// });
							mes++;

							if (i == ($scope.infoLote.mesesSinInteresP1 - 1)){
								$scope.total2 = $scope.infoLote.precioTotal;
								$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;

							}

							$scope.finalMesesp1 = range.length;
							ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
						}
						$scope.range= range;

						//////////

						// $scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.infoLote.precioTotal) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
						$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses) - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses) - $scope.infoLote.mesesSinInteresP1 )-1);

						var range2=[];

						for (var i = ini2; i < $scope.infoLote.meses; i++) {

							if( (mes == 13) || (mes == 14) ){

								if(mes == 13){

									mes = '01';
									yearc++;

								} else if (mes == 14) {

									mes = '02';
									yearc++;

								}

							}

							if(mes == 2){
								mes = '02';
							}
							if(mes == 3){
								mes = '03';
							}
							if(mes == 4){
								mes = '04';
							}
							if(mes == 5){
								mes = '05';
							}
							if(mes == 6){
								mes = '06';
							}
							if(mes == 7){
								mes = '07';
							}
							if(mes == 8){
								mes = '08';
							}
							if(mes == 9){
								mes = '09';
							}
							if(mes == 10){
								mes = '10';
							}
							if(mes == 11){
								mes = '11';
							}
							if(mes == 12){
								mes = '12';
							}


							$scope.dateCf = day + '-' + mes + '-' + yearc;
							//nuevocodigo 19FEB20
							if(i == 0)
							{
								$scope.fechaPM = $scope.dateCf;
							}
							//

							// $scope.interes_plan2 = $scope.infoLote.precioTotal *($scope.infoLote.interes_p2);
							// $scope.capital2 = ($scope.p2 - $scope.interes_plan2);
							$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
							$scope.capital2 = ($scope.p2 - $scope.interes_plan2);


							// capital = ($scope.capital2 = ($scope.p2 - $scope.interes_plan2));
							// interes = (($scope.infoLote.precioTotal  - $scope.p2) *($scope.infoLote.interes_p2));
							// total = capital + interes;
							// console.log($scope.p2);
							range2.push({
								"fecha" : $scope.dateCf,
								"pago" : i + 1,
								"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
								"interes" :($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
								"total" : $scope.p2,
								"saldo" : ($scope.total2 = ($scope.total2 -$scope.capital2)),
								"pagoCapital"	:	"",
							});
							window['pagoCapChange' + numfinalCount]=Function("","console.log('pagoCapChange"+numfinalCount+" el parametro es: " + document.getElementById('#idModel'+numfinalCount) + "');");//angular.element(document.querySelector('#idModel'+numfinalCount))
							mes++;


							if (i == ($scope.infoLote.meses - 1)){
								$scope.totalSegundoPlan = $scope.p2;
							}
							$scope.finalMesesp2 = (range2.length);
						}
						$scope.range2= range2;


						// $scope.alphaNumeric = $scope.rangEd.concat($scope.range);
						// $scope.alphaNumeric = $scope.dani.concat($scope.range2);
						// $scope.alphaNumeric = $scope.range.concat($scope.range2);

						$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
						$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2);
						$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
								{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
								{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
								{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
								{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
										//pageMargins [left, top, right, bottom]
										doc.pageMargins = [ 140, 40, 10, 50 ];
										doc.alignment = 'center';
									}},
							]
						).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
					}
					if($scope.infoLote.mesesSinInteresP1 == 0)
					{
						console.log('alvnoma 0 intereses');
						$scope.infoLote.mesesSinInteresP1 = ($scope.mesesdiferir > 0 ) ? ($scope.infoLote.mesesSinInteresP1 + $scope.mesesdiferir) : ($scope.infoLote.mesesSinInteresP1);


						$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.infoLote.precioTotal)
							/ ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);

						var range2=[];

						for (var i = ini; i < $scope.infoLote.meses; i++) {

							if( (mes == 13) || (mes == 14) ){

								if(mes == 13){

									mes = '01';
									yearc++;

								} else if (mes == 14) {

									mes = '02';
									yearc++;

								}

							}

							if(mes == 2){
								mes = '02';
							}
							if(mes == 3){
								mes = '03';
							}
							if(mes == 4){
								mes = '04';
							}
							if(mes == 5){
								mes = '05';
							}
							if(mes == 6){
								mes = '06';
							}
							if(mes == 7){
								mes = '07';
							}
							if(mes == 8){
								mes = '08';
							}
							if(mes == 9){
								mes = '09';
							}
							if(mes == 10){
								mes = '10';
							}
							if(mes == 11){
								mes = '11';
							}
							if(mes == 12){
								mes = '12';
							}


							$scope.dateCf = day + '-' + mes + '-' + yearc;

							//nuevo codigo 19 FEB
							$scope.pagoACapital = function()
							{
								var PagoACapital	=	document.getElementsByName("pagoACapitalNameJS")[0].value;
								var PositionPago	=	document.getElementsByName("pagoACapitalNumberJS")[0].value;
								// console.log("alv, ya llegé aquinumaaaa: " + PagoACapital);
								// console.log("se ingreso un pago en en la mensaualidad: " + PositionPago);
								var saldo	=	 PagoACapital;
								var saldoFinalisimo	=	($scope.saldoFinal - $scope.infoLote.capital);//
								var saldoMenosPC	=	saldoFinalisimo - saldo;
								// $scope.total = saldoFinalisimo - saldo;
								// $scope.porcentajeEng = 0;
								// console.log($scope.total);
								// console.log($scope.precioFinal + " " + (($scope.saldoFinal - $scope.infoLote.capital)) + " " + saldo + " REST " + (saldoMenosPC) );
								// calcularCF();
								// for(var n = 0; n<=i-1 ; n++)
								// {
								// }
								var posicionPay =	PositionPago-1;
								var saldoActual	=	$scope.alphaNumeric[posicionPay]['saldo'];
								var nuevoSaldo	=	($scope.alphaNumeric[posicionPay]['saldo'] - PagoACapital);
								var TestEng = $scope.cantidad;
								// console.log("Saldo actual: " + saldoActual);
								$scope.alphaNumeric[posicionPay]['saldo'] = $scope.alphaNumeric[posicionPay]['saldo'] - PagoACapital;
								// console.log("Este es el nuevo saldo: " + nuevoSaldo);

								// $scope.infoLote.capital=0;
								var posPay = PositionPago-1;
								calcularCF2(nuevoSaldo, posPay, saldo, saldoMenosPC);
								/*aqui me quede con la busqueda de la actualizacion de la tabla*/
							}
							//CIERRA CODIGO 19 FEB

							$scope.interes_plan2 = $scope.infoLote.precioTotal * ($scope.infoLote.interes_p2);
							$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

							range2.push({
								"fecha" : $scope.dateCf,
								"pago" : i + 1,
								"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
								"interes" : ($scope.interes_plan2= ($scope.infoLote.precioTotal * $scope.infoLote.interes_p2)),
								"total" : $scope.p2,
								"saldo" : ($scope.infoLote.precioTotal = ($scope.infoLote.precioTotal -$scope.capital2)),
								"pagoCapital"	:	"",
							});
							window['pagoCapChange' + numfinalCount]=Function("","console.log('pagoCapChange"+numfinalCount+" el parametro es: " + document.getElementById('#idModel'+numfinalCount) + "');");//angular.element(document.querySelector('#idModel'+numfinalCount))

							mes++;

							if (i == ($scope.infoLote.meses - 1)){
								$scope.totalSegundoPlan = $scope.p2;
							}
							$scope.finalMesesp2 = (range2.length);
						}
						$scope.range2= range2;

						$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
						$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range2);
						// $scope.alphaNumeric = $scope.range2;


						$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
								{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
								{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
								{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
								{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
										//pageMargins [left, top, right, bottom]
										doc.pageMargins = [ 140, 40, 10, 50 ];
										doc.alignment = 'center';

									}},
							]
						).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});



					}
					if($scope.infoLote.mesesSinInteresP1 == 36)
					{
						// console.log('36ALV');
						for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

							if( (mes == 13) || (mes == 14) ){

								if ($scope.descDate == 0){

									if(mes == 13){

										mes = '01';
										yearc++;

									} else if (mes == 14) {

										mes = '02';
										yearc++;

									}

								} else if($scope.descDate == 1) {
									mes = '03';
									$scope.descDate = 0;


								}

							}

							if(mes == 2){
								mes = '02';
							}
							if(mes == 3){
								mes = '03';
							}
							if(mes == 4){
								mes = '04';
							}
							if(mes == 5){
								mes = '05';
							}
							if(mes == 6){
								mes = '06';
							}
							if(mes == 7){
								mes = '07';
							}
							if(mes == 8){
								mes = '08';
							}
							if(mes == 9){
								mes = '09';
							}
							if(mes == 10){
								mes = '10';
							}
							if(mes == 11){
								mes = '11';
							}
							if(mes == 12){
								mes = '12';
							}

							$scope.dateCf = day + '-' + mes + '-' + yearc;

							if(i == 0){
								$scope.fechaPM = $scope.dateCf;
							}
							var numfinalCount = i+1;
							//new code 18 FEB
							$scope.pagoACapital = function()
							{
								var PagoACapital	=	document.getElementsByName("pagoACapitalNameJS")[0].value;
								var PositionPago	=	document.getElementsByName("pagoACapitalNumberJS")[0].value;
								// console.log("alv, ya llegé aquinumaaaa: " + PagoACapital);
								// console.log("se ingreso un pago en en la mensaualidad: " + PositionPago);
								var saldo	=	 PagoACapital;
								var saldoFinalisimo	=	($scope.saldoFinal - $scope.infoLote.capital);//
								var saldoMenosPC	=	saldoFinalisimo - saldo;
								// $scope.total = saldoFinalisimo - saldo;
								// $scope.porcentajeEng = 0;
								// console.log($scope.total);
								// console.log($scope.precioFinal + " " + (($scope.saldoFinal - $scope.infoLote.capital)) + " " + saldo + " REST " + (saldoMenosPC) );
								// calcularCF();
								// for(var n = 0; n<=i-1 ; n++)
								// {
								// }
								var posicionPay =	PositionPago-1;
								var saldoActual	=	$scope.alphaNumeric[posicionPay]['saldo'];
								var nuevoSaldo	=	($scope.alphaNumeric[posicionPay]['saldo'] - PagoACapital);
								var TestEng = $scope.cantidad;
								// console.log("Saldo actual: " + saldoActual);
								$scope.alphaNumeric[posicionPay]['saldo'] = $scope.alphaNumeric[posicionPay]['saldo'] - PagoACapital;
								// console.log("Este es el nuevo saldo: " + nuevoSaldo);

								// $scope.infoLote.capital=0;
								var posPay = PositionPago-1;
								calcularCF2(nuevoSaldo, posPay, saldo, saldoMenosPC);
								/*aqui me quede con la busqueda de la actualizacion de la tabla*/
							}
							/*nuevo código 24 de FEB*/
							var disp = 0;
							var interes = 0;
							var total = 0;
							var capital = 0;
							if ($scope.infoLote.mesesSinInteresP1 == 0) {
								interes = ($scope.interes_plan2= ($scope.infoLote.precioTotal  * $scope.infoLote.interes_p2));
								capital = ($scope.capital2 = ((($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1)) - $scope.interes_plan2));
								total = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
							}
							else
							{
								capital = $scope.infoLote.capital;
								interes = 0;
								total = $scope.infoLote.capital + $scope.infoLote.interes_p1;
							}
							range.push({
								"fecha" : $scope.dateCf,
								"pago" : i + 1,
								"capital" : capital,
								"interes" : interes,
								"total" : total,
								"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
								"pagoCapital"	:	"",// btnmodal+modalBody --- inputToIns onclick='javascript:console.log(65);' //<button ng-click='addNewChoice()' class='btn btn-success' style='width: 20%;float:right' ><i class='fa fa-plus'></i></button>
								"disp" : 0
							});
							window['pagoCapChange' + numfinalCount]=Function("","console.log('pagoCapChange"+numfinalCount+" el parametro es: " + document.getElementById('#idModel'+numfinalCount) + "');");//angular.element(document.querySelector('#idModel'+numfinalCount))

							//end new code


							//original code 18enero20
							// range.push({
							//
							// 	"fecha" : $scope.dateCf,
							// 	"pago" : i + 1,
							// 	"capital" : $scope.infoLote.capital,
							// 	"interes" : 0,
							// 	"total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
							// 	"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,
							//
							// });
							mes++;

							if (i == ($scope.infoLote.mesesSinInteresP1 - 1)){
								$scope.total2 = $scope.infoLote.precioTotal;
								$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;

							}

							$scope.finalMesesp1 = range.length;
							ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
						}
						$scope.range= range;

						//////////

						// $scope.alphaNumeric = $scope.rangEd.concat($scope.range);
						// $scope.alphaNumeric = $scope.dani.concat($scope.range2);
						// $scope.alphaNumeric = $scope.range.concat($scope.range2);


						$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
						$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range);



						$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
								{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
								{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
								{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
								{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
										//pageMargins [left, top, right, bottom]
										doc.pageMargins = [ 140, 40, 10, 50 ];
										doc.alignment = 'center';

									}},
							]
						).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
					}
				}

				////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


				/////////// TABLES X 4 A 10 AÑOS ////////////
				if($scope.infoLote.meses >=48 && $scope.infoLote.meses <=120 )
				{
					var range=[];
					ini = ($scope.mesesdiferir > 0) ? $scope.mesesdiferir : $scope.infoLote.contadorInicial;
					//////////////////////// ON PLAN CONTRUCTOR ////////////////////////////////////
					if($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <=35 && $scope.noPagomensualidad == 1)
					{

						ini =  $scope.infoLote.contadorInicial;


						if($scope.noPagomensualidad == 1)
						{


							////////////////////////////////////////////////////////////////////////////////////


							var rangePlanc=[];


							for (var i = ini; i < 12; i++) {

								if( (mes == 13) || (mes == 14) ){

									if ($scope.descDate == 0){

										if(mes == 13){

											mes = '01';
											yearc++;

										} else if (mes == 14) {

											mes = '02';
											yearc++;

										}

									} else if($scope.descDate == 1) {
										mes = '03';
										$scope.descDate = 0;


									}

								}

								if(mes == 2){
									mes = '02';
								}
								if(mes == 3){
									mes = '03';
								}
								if(mes == 4){
									mes = '04';
								}
								if(mes == 5){
									mes = '05';
								}
								if(mes == 6){
									mes = '06';
								}
								if(mes == 7){
									mes = '07';
								}
								if(mes == 8){
									mes = '08';
								}
								if(mes == 9){
									mes = '09';
								}
								if(mes == 10){
									mes = '10';
								}
								if(mes == 11){
									mes = '11';
								}
								if(mes == 12){
									mes = '12';
								}

								$scope.dateCf = day + '-' + mes + '-' + yearc;


								rangePlanc.push({

									"fecha" : $scope.dateCf,
									"pago" : i + 1,
									"capital" : 0,
									"interes" : 0,
									"total" : 0,
									"saldo" : $scope.saldoFinal,

								});
								mes++;

								$scope.finalMesesp1PlanC = rangePlanc.length;
								ini = rangePlanc.length;
							}


							$scope.rangePlanc = rangePlanc;

////////////////////////////////////////////////////////////////////////////////////



							for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

								if( (mes == 13) || (mes == 14) ){

									if(mes == 13){

										mes = '01';
										yearc++;

									} else if (mes == 14) {

										mes = '02';
										yearc++;

									}

								}

								if(mes == 2){
									mes = '02';
								}
								if(mes == 3){
									mes = '03';
								}
								if(mes == 4){
									mes = '04';
								}
								if(mes == 5){
									mes = '05';
								}
								if(mes == 6){
									mes = '06';
								}
								if(mes == 7){
									mes = '07';
								}
								if(mes == 8){
									mes = '08';
								}
								if(mes == 9){
									mes = '09';
								}
								if(mes == 10){
									mes = '10';
								}
								if(mes == 11){
									mes = '11';
								}
								if(mes == 12){
									mes = '12';
								}


								$scope.dateCf = day + '-' + mes + '-' + yearc;

								if(i == 12){
									$scope.fechaPM = $scope.dateCf;
								}

								range.push({

									"fecha" : $scope.dateCf,
									"pago" : i + 1,
									"capital" : $scope.infoLote.capital,
									"interes" : 0,
									"total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
									"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,

								});
								mes++;

								if (i == ($scope.infoLote.mesesSinInteresP1 - 1)){
									$scope.total2 = $scope.infoLote.precioTotal;
									$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;

								}

								$scope.finalMesesp1 = range.length;
								ini2 = (range.length + rangePlanc.length);


							}
							$scope.range= range;

							//////////

							$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses + 12) - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses + 12) - $scope.infoLote.mesesSinInteresP1 )-1);

							var range2=[];


							for (var i = ini2; i < ($scope.infoLote.meses + 12); i++) {

								if( (mes == 13) || (mes == 14) ){

									if(mes == 13){

										mes = '01';
										yearc++;

									} else if (mes == 14) {

										mes = '02';
										yearc++;

									}

								}

								if(mes == 2){
									mes = '02';
								}
								if(mes == 3){
									mes = '03';
								}
								if(mes == 4){
									mes = '04';
								}
								if(mes == 5){
									mes = '05';
								}
								if(mes == 6){
									mes = '06';
								}
								if(mes == 7){
									mes = '07';
								}
								if(mes == 8){
									mes = '08';
								}
								if(mes == 9){
									mes = '09';
								}
								if(mes == 10){
									mes = '10';
								}
								if(mes == 11){
									mes = '11';
								}
								if(mes == 12){
									mes = '12';
								}


								$scope.dateCf = day + '-' + mes + '-' + yearc;


								$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
								$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

								range2.push({

									"fecha" : $scope.dateCf,
									"pago" : i + 1,
									"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
									"interes" : ($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
									"total" : $scope.p2,
									"saldo" : ($scope.total2 = ($scope.total2 -$scope.capital2)),

								});

								mes++;

								if (i == ($scope.infoLote.meses - 1)){
									$scope.totalSegundoPlan = $scope.p2;

								}
								$scope.finalMesesp2 = (range2.length);


							}
							$scope.range2= range2;


							$scope.alphaNumeric = $scope.rangePlanc.concat($scope.range).concat($scope.range2);

							// $scope.alphaNumeric = $scope.range.concat($scope.range2);



							$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
									{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
									{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
									{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
									{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
											//pageMargins [left, top, right, bottom]
											doc.pageMargins = [ 140, 40, 10, 50 ];
											doc.alignment = 'center';

										}},
								]
							).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});




						}


					}
					//////////////////////// OFF PLAN CONTRUCTOR ////////////////////////////////////

					// if($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <=35 && $scope.noPagomensualidad == 0)
					// {
					//
					// 	for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {
					//
					// 		if( (mes == 13) || (mes == 14) ){
					//
					// 			if(mes == 13){
					//
					// 				mes = '01';
					// 				yearc++;
					//
					// 			} else if (mes == 14) {
					//
					// 				mes = '02';
					// 				yearc++;
					//
					// 			}
					//
					// 		}
					//
					// 		if(mes == 2){
					// 			mes = '02';
					// 		}
					// 		if(mes == 3){
					// 			mes = '03';
					// 		}
					// 		if(mes == 4){
					// 			mes = '04';
					// 		}
					// 		if(mes == 5){
					// 			mes = '05';
					// 		}
					// 		if(mes == 6){
					// 			mes = '06';
					// 		}
					// 		if(mes == 7){
					// 			mes = '07';
					// 		}
					// 		if(mes == 8){
					// 			mes = '08';
					// 		}
					// 		if(mes == 9){
					// 			mes = '09';
					// 		}
					// 		if(mes == 10){
					// 			mes = '10';
					// 		}
					// 		if(mes == 11){
					// 			mes = '11';
					// 		}
					// 		if(mes == 12){
					// 			mes = '12';
					// 		}
					//
					//
					// 		$scope.dateCf = day + '-' + mes + '-' + yearc;
					//
					// 		if(i == 0){
					// 			$scope.fechaPM = $scope.dateCf;
					// 		}
					//
					// 		range.push({
					//
					// 			"fecha" : $scope.dateCf,
					// 			"pago" : i + 1,
					// 			"capital" : $scope.infoLote.capital,
					// 			"interes" : 0,
					// 			"total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
					// 			"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,
					//
					// 		});
					// 		mes++;
					//
					// 		if (i == ($scope.infoLote.mesesSinInteresP1 - 1)){
					// 			$scope.total2 = $scope.infoLote.precioTotal;
					// 			$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;
					//
					// 		}
					// 		$scope.finalMesesp1 = (range.length);
					// 		ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
					//
					// 	}
					// 	$scope.range= range;
					//
					// 	//////////
					//
					// 	$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
					//
					// 	var range2=[];
					//
					//
					// 	for (var i = ini2; i < $scope.infoLote.meses; i++) {
					//
					// 		if( (mes == 13) || (mes == 14) ){
					//
					// 			if(mes == 13){
					//
					// 				mes = '01';
					// 				yearc++;
					//
					// 			} else if (mes == 14) {
					//
					// 				mes = '02';
					// 				yearc++;
					//
					// 			}
					//
					// 		}
					//
					// 		if(mes == 2){
					// 			mes = '02';
					// 		}
					// 		if(mes == 3){
					// 			mes = '03';
					// 		}
					// 		if(mes == 4){
					// 			mes = '04';
					// 		}
					// 		if(mes == 5){
					// 			mes = '05';
					// 		}
					// 		if(mes == 6){
					// 			mes = '06';
					// 		}
					// 		if(mes == 7){
					// 			mes = '07';
					// 		}
					// 		if(mes == 8){
					// 			mes = '08';
					// 		}
					// 		if(mes == 9){
					// 			mes = '09';
					// 		}
					// 		if(mes == 10){
					// 			mes = '10';
					// 		}
					// 		if(mes == 11){
					// 			mes = '11';
					// 		}
					// 		if(mes == 12){
					// 			mes = '12';
					// 		}
					//
					//
					// 		$scope.dateCf = day + '-' + mes + '-' + yearc;
					//
					//
					// 		$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
					// 		$scope.capital2 = ($scope.p2 - $scope.interes_plan2);
					//
					// 		range2.push({
					//
					// 			"fecha" : $scope.dateCf,
					// 			"pago" : i + 1,
					// 			"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
					// 			"interes" : ($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
					// 			"total" : $scope.p2,
					// 			"saldo" : ($scope.total2 = ($scope.total2 -$scope.capital2)),
					//
					// 		});
					//
					// 		mes++;
					//
					// 		if (i == ($scope.infoLote.meses - 1)){
					// 			$scope.totalSegundoPlan = $scope.p2;
					//
					// 		}
					// 		$scope.finalMesesp2 = (range2.length);
					//
					//
					// 	}
					// 	$scope.range2= range2;
					//
					//
					//
					// 	$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
					// 	$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2);
					//
					// 	// $scope.alphaNumeric = $scope.range.concat($scope.range2);
					//
					//
					//
					// 	$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
					// 			{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
					// 			{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
					// 			{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
					// 			{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
					// 					//pageMargins [left, top, right, bottom]
					// 					doc.pageMargins = [ 140, 40, 10, 50 ];
					// 					doc.alignment = 'center';
					//
					// 				}},
					// 		]
					// 	).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
					//
					//
					//
					//
					// }
					if($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <=35  && $scope.noPagomensualidad == 0)
					{

						for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

							if( (mes == 13) || (mes == 14) ){

								if(mes == 13){

									mes = '01';
									yearc++;

								} else if (mes == 14) {

									mes = '02';
									yearc++;

								}

							}

							if(mes == 2){
								mes = '02';
							}
							if(mes == 3){
								mes = '03';
							}
							if(mes == 4){
								mes = '04';
							}
							if(mes == 5){
								mes = '05';
							}
							if(mes == 6){
								mes = '06';
							}
							if(mes == 7){
								mes = '07';
							}
							if(mes == 8){
								mes = '08';
							}
							if(mes == 9){
								mes = '09';
							}
							if(mes == 10){
								mes = '10';
							}
							if(mes == 11){
								mes = '11';
							}
							if(mes == 12){
								mes = '12';
							}


							$scope.dateCf = day + '-' + mes + '-' + yearc;

							if(i == 0){
								$scope.fechaPM = $scope.dateCf;
							}
							var numfinalCount = i+1;
							//new code 18 FEB
							$scope.pagoACapital = function()
							{
								var PagoACapital	=	document.getElementsByName("pagoACapitalNameJS")[0].value;
								var PositionPago	=	document.getElementsByName("pagoACapitalNumberJS")[0].value;
								// console.log("alv, ya llegé aquinumaaaa: " + PagoACapital);
								// console.log("se ingreso un pago en en la mensaualidad: " + PositionPago);
								var saldo	=	 PagoACapital;
								var saldoFinalisimo	=	($scope.saldoFinal - $scope.infoLote.capital);//
								var saldoMenosPC	=	saldoFinalisimo - saldo;
								// $scope.total = saldoFinalisimo - saldo;
								// $scope.porcentajeEng = 0;
								// console.log($scope.total);
								// console.log($scope.precioFinal + " " + (($scope.saldoFinal - $scope.infoLote.capital)) + " " + saldo + " REST " + (saldoMenosPC) );
								// calcularCF();
								// for(var n = 0; n<=i-1 ; n++)
								// {
								// }
								var posicionPay =	PositionPago-1;
								var saldoActual	=	$scope.alphaNumeric[posicionPay]['saldo'];
								var nuevoSaldo	=	($scope.alphaNumeric[posicionPay]['saldo'] - PagoACapital);
								var TestEng = $scope.cantidad;
								// console.log("Saldo actual: " + saldoActual);
								$scope.alphaNumeric[posicionPay]['saldo'] = $scope.alphaNumeric[posicionPay]['saldo'] - PagoACapital;
								// console.log("Este es el nuevo saldo: " + nuevoSaldo);

								// $scope.infoLote.capital=0;
								var posPay = PositionPago-1;
								calcularCF2(nuevoSaldo, posPay, saldo, saldoMenosPC);
								/*aqui me quede con la busqueda de la actualizacion de la tabla*/
							}
							/*nuevo código 24 de FEB*/
							var disp = 0;
							var interes = 0;
							var total = 0;
							var capital = 0;
							if ($scope.infoLote.mesesSinInteresP1 == 0) {
								interes = ($scope.interes_plan2= ($scope.infoLote.precioTotal  * $scope.infoLote.interes_p2));
								capital = ($scope.capital2 = ((($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1)) - $scope.interes_plan2));
								total = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
							}
							else
							{
								capital = $scope.infoLote.capital;
								interes = 0;
								total = $scope.infoLote.capital + $scope.infoLote.interes_p1;
							}
							range.push({
								"fecha" : $scope.dateCf,
								"pago" : i + 1,
								"capital" : capital,
								"interes" : interes,
								"total" : total,
								"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
								"pagoCapital"	:	"",// btnmodal+modalBody --- inputToIns onclick='javascript:console.log(65);' //<button ng-click='addNewChoice()' class='btn btn-success' style='width: 20%;float:right' ><i class='fa fa-plus'></i></button>
							});
							window['pagoCapChange' + numfinalCount]=Function("","console.log('pagoCapChange"+numfinalCount+" el parametro es: " + document.getElementById('#idModel'+numfinalCount) + "');");//
							mes++;

							if (i == ($scope.infoLote.mesesSinInteresP1 - 1)){
								$scope.total2 = $scope.infoLote.precioTotal;
								$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;

							}
							$scope.finalMesesp1 = (range.length);
							ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;

						}
						$scope.range= range;

						//////////

						$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
						var range2=[];


						for (var i = ini2; i < $scope.infoLote.meses; i++) {

							if( (mes == 13) || (mes == 14) ){

								if(mes == 13){

									mes = '01';
									yearc++;

								} else if (mes == 14) {

									mes = '02';
									yearc++;

								}

							}

							if(mes == 2){
								mes = '02';
							}
							if(mes == 3){
								mes = '03';
							}
							if(mes == 4){
								mes = '04';
							}
							if(mes == 5){
								mes = '05';
							}
							if(mes == 6){
								mes = '06';
							}
							if(mes == 7){
								mes = '07';
							}
							if(mes == 8){
								mes = '08';
							}
							if(mes == 9){
								mes = '09';
							}
							if(mes == 10){
								mes = '10';
							}
							if(mes == 11){
								mes = '11';
							}
							if(mes == 12){
								mes = '12';
							}


							$scope.dateCf = day + '-' + mes + '-' + yearc;


							$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
							$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

							range2.push({

								"fecha" : $scope.dateCf,
								"pago" : i + 1,
								"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
								"interes" : ($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
								"total" : $scope.p2,
								"saldo" : ($scope.total2 = ($scope.total2 -$scope.capital2)),
								"disp" : 0

							});

							mes++;

							if (i == ($scope.infoLote.meses - 1)){
								$scope.totalSegundoPlan = $scope.p2;

							}
							$scope.finalMesesp2 = (range2.length);


						}
						$scope.range2= range2;



						$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
						$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2);

						// $scope.alphaNumeric = $scope.range.concat($scope.range2);



						$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
								{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
								{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
								{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
								{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
										//pageMargins [left, top, right, bottom]
										doc.pageMargins = [ 140, 40, 10, 50 ];
										doc.alignment = 'center';

									}},
							]
						).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
					}

					// if($scope.infoLote.mesesSinInteresP1 == 0)
					// {
					//
					// 	$scope.infoLote.mesesSinInteresP1 = ($scope.mesesdiferir > 0) ? ($scope.infoLote.mesesSinInteresP1 + $scope.mesesdiferir) : ($scope.infoLote.mesesSinInteresP1);
					//
					// 	$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.infoLote.precioTotal)
					// 		/ ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
					//
					// 	var range2=[];
					//
					// 	for (var i = ini; i < $scope.infoLote.meses; i++) {
					//
					// 		if( (mes == 13) || (mes == 14) ){
					//
					// 			if(mes == 13){
					//
					// 				mes = '01';
					// 				yearc++;
					//
					// 			} else if (mes == 14) {
					//
					// 				mes = '02';
					// 				yearc++;
					//
					// 			}
					//
					// 		}
					//
					// 		if(mes == 2){
					// 			mes = '02';
					// 		}
					// 		if(mes == 3){
					// 			mes = '03';
					// 		}
					// 		if(mes == 4){
					// 			mes = '04';
					// 		}
					// 		if(mes == 5){
					// 			mes = '05';
					// 		}
					// 		if(mes == 6){
					// 			mes = '06';
					// 		}
					// 		if(mes == 7){
					// 			mes = '07';
					// 		}
					// 		if(mes == 8){
					// 			mes = '08';
					// 		}
					// 		if(mes == 9){
					// 			mes = '09';
					// 		}
					// 		if(mes == 10){
					// 			mes = '10';
					// 		}
					// 		if(mes == 11){
					// 			mes = '11';
					// 		}
					// 		if(mes == 12){
					// 			mes = '12';
					// 		}
					//
					//
					// 		$scope.dateCf = day + '-' + mes + '-' + yearc;
					//
					// 		$scope.interes_plan2 = $scope.infoLote.precioTotal * ($scope.infoLote.interes_p2);
					// 		$scope.capital2 = ($scope.p2 - $scope.interes_plan2);
					//
					// 		range2.push({
					//
					// 			"fecha" : $scope.dateCf,
					// 			"pago" : i + 1,
					// 			"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
					// 			"interes" : ($scope.interes_plan2= ($scope.infoLote.precioTotal * $scope.infoLote.interes_p2)),
					// 			"total" : $scope.p2,
					// 			"saldo" : ($scope.infoLote.precioTotal = ($scope.infoLote.precioTotal -$scope.capital2)),
					//
					// 		});
					// 		mes++;
					//
					// 		if (i == ($scope.infoLote.meses - 1)){
					// 			$scope.totalSegundoPlan = $scope.p2;
					//
					// 		}
					// 		$scope.finalMesesp2 = (range2.length);
					// 	}
					// 	$scope.range2= range2;
					//
					//
					//
					// 	$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
					// 	$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range2);
					//
					// 	// $scope.alphaNumeric = $scope.range2;
					//
					//
					//
					// 	$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
					// 			{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
					// 			{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
					// 			{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
					// 			{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
					// 					//pageMargins [left, top, right, bottom]
					// 					doc.pageMargins = [ 140, 40, 10, 50 ];
					// 					doc.alignment = 'center';
					//
					// 				}},
					// 		]
					// 	).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
					//
					//
					//
					// }
					if($scope.infoLote.mesesSinInteresP1 == 0)
					{
						// console.log('alvnoma 0 intereses');
						$scope.infoLote.mesesSinInteresP1 = ($scope.mesesdiferir > 0 ) ? ($scope.infoLote.mesesSinInteresP1 + $scope.mesesdiferir) : ($scope.infoLote.mesesSinInteresP1);


						$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.infoLote.precioTotal)
							/ ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);

						var range2=[];

						for (var i = ini; i < $scope.infoLote.meses; i++) {

							if( (mes == 13) || (mes == 14) ){

								if(mes == 13){

									mes = '01';
									yearc++;

								} else if (mes == 14) {

									mes = '02';
									yearc++;

								}

							}

							if(mes == 2){
								mes = '02';
							}
							if(mes == 3){
								mes = '03';
							}
							if(mes == 4){
								mes = '04';
							}
							if(mes == 5){
								mes = '05';
							}
							if(mes == 6){
								mes = '06';
							}
							if(mes == 7){
								mes = '07';
							}
							if(mes == 8){
								mes = '08';
							}
							if(mes == 9){
								mes = '09';
							}
							if(mes == 10){
								mes = '10';
							}
							if(mes == 11){
								mes = '11';
							}
							if(mes == 12){
								mes = '12';
							}


							$scope.dateCf = day + '-' + mes + '-' + yearc;

							//nuevo codigo 19 FEB
							$scope.pagoACapital = function()
							{
								var PagoACapital	=	document.getElementsByName("pagoACapitalNameJS")[0].value;
								var PositionPago	=	document.getElementsByName("pagoACapitalNumberJS")[0].value;
								// console.log("alv, ya llegé aquinumaaaa: " + PagoACapital);
								// console.log("se ingreso un pago en en la mensaualidad: " + PositionPago);
								var saldo	=	 PagoACapital;
								var saldoFinalisimo	=	($scope.saldoFinal - $scope.infoLote.capital);//
								var saldoMenosPC	=	saldoFinalisimo - saldo;
								// $scope.total = saldoFinalisimo - saldo;
								// $scope.porcentajeEng = 0;
								// console.log($scope.total);
								// console.log($scope.precioFinal + " " + (($scope.saldoFinal - $scope.infoLote.capital)) + " " + saldo + " REST " + (saldoMenosPC) );
								// calcularCF();
								// for(var n = 0; n<=i-1 ; n++)
								// {
								// }
								var posicionPay =	PositionPago-1;
								var saldoActual	=	$scope.alphaNumeric[posicionPay]['saldo'];
								var nuevoSaldo	=	($scope.alphaNumeric[posicionPay]['saldo'] - PagoACapital);
								var TestEng = $scope.cantidad;
								// console.log("Saldo actual: " + saldoActual);
								$scope.alphaNumeric[posicionPay]['saldo'] = $scope.alphaNumeric[posicionPay]['saldo'] - PagoACapital;
								// console.log("Este es el nuevo saldo: " + nuevoSaldo);

								// $scope.infoLote.capital=0;
								var posPay = PositionPago-1;
								calcularCF2(nuevoSaldo, posPay, saldo, saldoMenosPC);
								/*aqui me quede con la busqueda de la actualizacion de la tabla*/
							}
							//CIERRA CODIGO 19 FEB

							$scope.interes_plan2 = $scope.infoLote.precioTotal * ($scope.infoLote.interes_p2);
							$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

							range2.push({
								"fecha" : $scope.dateCf,
								"pago" : i + 1,
								"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
								"interes" : ($scope.interes_plan2= ($scope.infoLote.precioTotal * $scope.infoLote.interes_p2)),
								"total" : $scope.p2,
								"saldo" : ($scope.infoLote.precioTotal = ($scope.infoLote.precioTotal -$scope.capital2)),
								"pagoCapital"	:	"",
							});
							window['pagoCapChange' + numfinalCount]=Function("","console.log('pagoCapChange"+numfinalCount+" el parametro es: " + document.getElementById('#idModel'+numfinalCount) + "');");//angular.element(document.querySelector('#idModel'+numfinalCount))

							mes++;

							if (i == ($scope.infoLote.meses - 1)){
								$scope.totalSegundoPlan = $scope.p2;
							}
							$scope.finalMesesp2 = (range2.length);
						}
						$scope.range2= range2;

						$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
						$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range2);
						// $scope.alphaNumeric = $scope.range2;


						$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
								{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
								{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
								{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
								{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
										//pageMargins [left, top, right, bottom]
										doc.pageMargins = [ 140, 40, 10, 50 ];
										doc.alignment = 'center';

									}},
							]
						).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});



					}

					// if($scope.infoLote.mesesSinInteresP1 == 36)
					// {
					//
					// 	for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {
					//
					// 		if( (mes == 13) || (mes == 14) ){
					//
					// 			if(mes == 13){
					//
					// 				mes = '01';
					// 				yearc++;
					//
					// 			} else if (mes == 14) {
					//
					// 				mes = '02';
					// 				yearc++;
					//
					// 			}
					//
					// 		}
					//
					//
					// 		if(mes == 2){
					// 			mes = '02';
					// 		}
					// 		if(mes == 3){
					// 			mes = '03';
					// 		}
					// 		if(mes == 4){
					// 			mes = '04';
					// 		}
					// 		if(mes == 5){
					// 			mes = '05';
					// 		}
					// 		if(mes == 6){
					// 			mes = '06';
					// 		}
					// 		if(mes == 7){
					// 			mes = '07';
					// 		}
					// 		if(mes == 8){
					// 			mes = '08';
					// 		}
					// 		if(mes == 9){
					// 			mes = '09';
					// 		}
					// 		if(mes == 10){
					// 			mes = '10';
					// 		}
					// 		if(mes == 11){
					// 			mes = '11';
					// 		}
					// 		if(mes == 12){
					// 			mes = '12';
					// 		}
					//
					//
					// 		$scope.dateCf = day + '-' + mes + '-' + yearc;
					//
					// 		if(i == 0){
					// 			$scope.fechaPM = $scope.dateCf;
					// 		}
					//
					// 		range.push({
					//
					// 			"fecha" : $scope.dateCf,
					// 			"pago" : i + 1,
					// 			"capital" : $scope.infoLote.capital,
					// 			"interes" : 0,
					// 			"total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
					// 			"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,
					//
					// 		});
					// 		mes++;
					//
					// 		if (i == ($scope.infoLote.mesesSinInteresP1 - 1)){
					// 			$scope.total2 = $scope.infoLote.precioTotal;
					// 			$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;
					//
					// 		}
					// 		$scope.finalMesesp1 = (range.length);
					// 		ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
					//
					// 	}
					// 	$scope.range= range;
					//
					// 	//////////
					//
					// 	$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
					//
					// 	var range2=[];
					//
					//
					// 	for (var i = ini2; i < $scope.infoLote.meses; i++) {
					//
					// 		if( (mes == 13) || (mes == 14) ){
					//
					// 			if(mes == 13){
					//
					// 				mes = '01';
					// 				yearc++;
					//
					// 			} else if (mes == 14) {
					//
					// 				mes = '02';
					// 				yearc++;
					//
					// 			}
					//
					// 		}
					//
					// 		if(mes == 2){
					// 			mes = '02';
					// 		}
					// 		if(mes == 3){
					// 			mes = '03';
					// 		}
					// 		if(mes == 4){
					// 			mes = '04';
					// 		}
					// 		if(mes == 5){
					// 			mes = '05';
					// 		}
					// 		if(mes == 6){
					// 			mes = '06';
					// 		}
					// 		if(mes == 7){
					// 			mes = '07';
					// 		}
					// 		if(mes == 8){
					// 			mes = '08';
					// 		}
					// 		if(mes == 9){
					// 			mes = '09';
					// 		}
					// 		if(mes == 10){
					// 			mes = '10';
					// 		}
					// 		if(mes == 11){
					// 			mes = '11';
					// 		}
					// 		if(mes == 12){
					// 			mes = '12';
					// 		}
					//
					//
					// 		$scope.dateCf = day + '-' + mes + '-' + yearc;
					//
					//
					// 		$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
					// 		$scope.capital2 = ($scope.p2 - $scope.interes_plan2);
					//
					// 		range2.push({
					//
					// 			"fecha" : $scope.dateCf,
					// 			"pago" : i + 1,
					// 			"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
					// 			"interes" : ($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
					// 			"total" : $scope.p2,
					// 			"saldo" : ($scope.total2 = ($scope.total2 -$scope.capital2)),
					//
					// 		});
					//
					// 		mes++;
					//
					// 		if (i == ($scope.infoLote.meses - 1)){
					// 			$scope.totalSegundoPlan = $scope.p2;
					//
					// 		}
					// 		$scope.finalMesesp2 = (range2.length);
					//
					//
					// 	}
					// 	$scope.range2= range2;
					//
					//
					//
					// 	$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
					// 	$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2);
					//
					// 	// $scope.alphaNumeric = $scope.range.concat($scope.range2);
					//
					//
					//
					// 	$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
					// 			{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
					// 			{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
					// 			{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
					// 			{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
					// 					//pageMargins [left, top, right, bottom]
					// 					doc.pageMargins = [ 140, 40, 10, 50 ];
					// 					doc.alignment = 'center';
					//
					// 				}},
					// 		]
					// 	).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
					//
					//
					//
					//
					// }
					if($scope.infoLote.mesesSinInteresP1 == 36)
					{
						console.log('36MSI A 48 MESES');
						for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

							if( (mes == 13) || (mes == 14) ){

								if ($scope.descDate == 0){

									if(mes == 13){

										mes = '01';
										yearc++;

									} else if (mes == 14) {

										mes = '02';
										yearc++;

									}

								} else if($scope.descDate == 1) {
									mes = '03';
									$scope.descDate = 0;


								}

							}

							if(mes == 2){
								mes = '02';
							}
							if(mes == 3){
								mes = '03';
							}
							if(mes == 4){
								mes = '04';
							}
							if(mes == 5){
								mes = '05';
							}
							if(mes == 6){
								mes = '06';
							}
							if(mes == 7){
								mes = '07';
							}
							if(mes == 8){
								mes = '08';
							}
							if(mes == 9){
								mes = '09';
							}
							if(mes == 10){
								mes = '10';
							}
							if(mes == 11){
								mes = '11';
							}
							if(mes == 12){
								mes = '12';
							}

							$scope.dateCf = day + '-' + mes + '-' + yearc;

							if(i == 0){
								$scope.fechaPM = $scope.dateCf;
							}
							var numfinalCount = i+1;
							//new code 18 FEB
							$scope.pagoACapital = function()
							{
								var PagoACapital	=	document.getElementsByName("pagoACapitalNameJS")[0].value;
								var PositionPago	=	document.getElementsByName("pagoACapitalNumberJS")[0].value;
								// console.log("alv, ya llegé aquinumaaaa: " + PagoACapital);
								// console.log("se ingreso un pago en en la mensaualidad: " + PositionPago);
								var saldo	=	 PagoACapital;
								var saldoFinalisimo	=	($scope.saldoFinal - $scope.infoLote.capital);//
								var saldoMenosPC	=	saldoFinalisimo - saldo;
								// $scope.total = saldoFinalisimo - saldo;
								// $scope.porcentajeEng = 0;
								// console.log($scope.total);
								// console.log($scope.precioFinal + " " + (($scope.saldoFinal - $scope.infoLote.capital)) + " " + saldo + " REST " + (saldoMenosPC) );
								// calcularCF();
								// for(var n = 0; n<=i-1 ; n++)
								// {
								// }
								var posicionPay =	PositionPago-1;
								var saldoActual	=	$scope.alphaNumeric[posicionPay]['saldo'];
								var nuevoSaldo	=	($scope.alphaNumeric[posicionPay]['saldo'] - PagoACapital);
								var TestEng = $scope.cantidad;
								// console.log("Saldo actual: " + saldoActual);
								$scope.alphaNumeric[posicionPay]['saldo'] = $scope.alphaNumeric[posicionPay]['saldo'] - PagoACapital;
								// console.log("Este es el nuevo saldo: " + nuevoSaldo);

								// $scope.infoLote.capital=0;
								var posPay = PositionPago-1;
								calcularCF2(nuevoSaldo, posPay, saldo, saldoMenosPC);
								/*aqui me quede con la busqueda de la actualizacion de la tabla*/
							}
							/*nuevo código 24 de FEB*/
							var disp = 0;
							var interes = 0;
							var total = 0;
							var capital = 0;
							if ($scope.infoLote.mesesSinInteresP1 == 0) {
								interes = ($scope.interes_plan2= ($scope.infoLote.precioTotal  * $scope.infoLote.interes_p2));
								capital = ($scope.capital2 = ((($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1)) - $scope.interes_plan2));
								total = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
							}
							else
							{
								capital = $scope.infoLote.capital;
								interes = 0;
								total = $scope.infoLote.capital + $scope.infoLote.interes_p1;
							}
							range.push({
								"fecha" : $scope.dateCf,
								"pago" : i + 1,
								"capital" : capital,
								"interes" : interes,
								"total" : total,
								"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
								"pagoCapital"	:	"",// btnmodal+modalBody --- inputToIns onclick='javascript:console.log(65);' //<button ng-click='addNewChoice()' class='btn btn-success' style='width: 20%;float:right' ><i class='fa fa-plus'></i></button>
								"disp" : 0
							});
							window['pagoCapChange' + numfinalCount]=Function("","console.log('pagoCapChange"+numfinalCount+" el parametro es: " + document.getElementById('#idModel'+numfinalCount) + "');");//angular.element(document.querySelector('#idModel'+numfinalCount))

							//end new code


							//original code 18enero20
							// range.push({
							//
							// 	"fecha" : $scope.dateCf,
							// 	"pago" : i + 1,
							// 	"capital" : $scope.infoLote.capital,
							// 	"interes" : 0,
							// 	"total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
							// 	"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,
							//
							// });
							mes++;

							if (i == ($scope.infoLote.mesesSinInteresP1 - 1)){
								$scope.total2 = $scope.infoLote.precioTotal;
								$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;

							}

							$scope.finalMesesp1 = range.length;
							ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
						}
						$scope.range= range;

						//////////

						// $scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
						$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses) - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses) - $scope.infoLote.mesesSinInteresP1 )-1);
						var range2=[];


						for (var i = ini2; i < $scope.infoLote.meses; i++) {

							if( (mes == 13) || (mes == 14) ){

								if(mes == 13){

									mes = '01';
									yearc++;

								} else if (mes == 14) {

									mes = '02';
									yearc++;

								}

							}

							if(mes == 2){
								mes = '02';
							}
							if(mes == 3){
								mes = '03';
							}
							if(mes == 4){
								mes = '04';
							}
							if(mes == 5){
								mes = '05';
							}
							if(mes == 6){
								mes = '06';
							}
							if(mes == 7){
								mes = '07';
							}
							if(mes == 8){
								mes = '08';
							}
							if(mes == 9){
								mes = '09';
							}
							if(mes == 10){
								mes = '10';
							}
							if(mes == 11){
								mes = '11';
							}
							if(mes == 12){
								mes = '12';
							}


							$scope.dateCf = day + '-' + mes + '-' + yearc;


							$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
							$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

							range2.push({
								"fecha" : $scope.dateCf,
								"pago" : i + 1,
								"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
								"interes" : ($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
								"total" : $scope.p2,
								"saldo" : ($scope.total2 = ($scope.total2 -$scope.capital2)),
								"disp" : 0
							});

							mes++;

							if (i == ($scope.infoLote.meses - 1)){
								$scope.totalSegundoPlan = $scope.p2;

							}
							$scope.finalMesesp2 = (range2.length);


						}
						$scope.range2= range2;



						$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
						$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2);



						$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
								{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
								{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
								{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
								{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
										//pageMargins [left, top, right, bottom]
										doc.pageMargins = [ 140, 40, 10, 50 ];
										doc.alignment = 'center';

									}},
							]
						).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
					}
				}


				////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

				/////////// TABLES X 11 A 15 AÑOS ////////////



				if($scope.infoLote.meses >= 132 && $scope.infoLote.meses <= 240)
				{

					var range=[];

					ini = ($scope.mesesdiferir > 0) ? $scope.mesesdiferir : $scope.infoLote.contadorInicial;



					//////////////////////// ON PLAN CONTRUCTOR ////////////////////////////////////
					if($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <=35 && $scope.noPagomensualidad == 1)
					{
						ini =  $scope.infoLote.contadorInicial;
						if($scope.noPagomensualidad == 1)
						{
							////////////////////////////////////////////////////////////////////////////////////


							var rangePlanc=[];


							for (var i = ini; i < 12; i++) {

								if( (mes == 13) || (mes == 14) ){

									if ($scope.descDate == 0){

										if(mes == 13){

											mes = '01';
											yearc++;

										} else if (mes == 14) {

											mes = '02';
											yearc++;

										}

									} else if($scope.descDate == 1) {
										mes = '03';
										$scope.descDate = 0;


									}

								}

								if(mes == 2){
									mes = '02';
								}
								if(mes == 3){
									mes = '03';
								}
								if(mes == 4){
									mes = '04';
								}
								if(mes == 5){
									mes = '05';
								}
								if(mes == 6){
									mes = '06';
								}
								if(mes == 7){
									mes = '07';
								}
								if(mes == 8){
									mes = '08';
								}
								if(mes == 9){
									mes = '09';
								}
								if(mes == 10){
									mes = '10';
								}
								if(mes == 11){
									mes = '11';
								}
								if(mes == 12){
									mes = '12';
								}

								$scope.dateCf = day + '-' + mes + '-' + yearc;


								rangePlanc.push({

									"fecha" : $scope.dateCf,
									"pago" : i + 1,
									"capital" : 0,
									"interes" : 0,
									"total" : 0,
									"saldo" : $scope.saldoFinal,

								});
								mes++;

								$scope.finalMesesp1PlanC = rangePlanc.length;
								ini = rangePlanc.length;
							}


							$scope.rangePlanc = rangePlanc;

////////////////////////////////////////////////////////////////////////////////////



							for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

								if( (mes == 13) || (mes == 14) ){

									if(mes == 13){

										mes = '01';
										yearc++;

									} else if (mes == 14) {

										mes = '02';
										yearc++;

									}

								}



								if(mes == 2){
									mes = '02';
								}
								if(mes == 3){
									mes = '03';
								}
								if(mes == 4){
									mes = '04';
								}
								if(mes == 5){
									mes = '05';
								}
								if(mes == 6){
									mes = '06';
								}
								if(mes == 7){
									mes = '07';
								}
								if(mes == 8){
									mes = '08';
								}
								if(mes == 9){
									mes = '09';
								}
								if(mes == 10){
									mes = '10';
								}
								if(mes == 11){
									mes = '11';
								}
								if(mes == 12){
									mes = '12';
								}


								$scope.dateCf = day + '-' + mes + '-' + yearc;

								if(i == 12){
									$scope.fechaPM = $scope.dateCf;
								}


								range.push({

									"fecha" : $scope.dateCf,
									"pago" : i + 1,
									"capital" : $scope.infoLote.capital,
									"interes" : 0,
									"total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
									"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,

								});
								mes++;

								if (i == ($scope.infoLote.mesesSinInteresP1 - 1)){
									$scope.total2 = $scope.infoLote.precioTotal;
									$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;


								}


								$scope.finalMesesp1 = range.length;
								ini2 = (range.length + rangePlanc.length);


							}
							$scope.range= range;

							//////////

							$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses + 12) - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses + 12) - $scope.infoLote.mesesSinInteresP1 )-1);

							var range2=[];

							for (var i = ini2; i < 120; i++) {

								if( (mes == 13) || (mes == 14) ){

									if(mes == 13){

										mes = '01';
										yearc++;

									} else if (mes == 14) {

										mes = '02';
										yearc++;

									}

								}

								if(mes == 2){
									mes = '02';
								}
								if(mes == 3){
									mes = '03';
								}
								if(mes == 4){
									mes = '04';
								}
								if(mes == 5){
									mes = '05';
								}
								if(mes == 6){
									mes = '06';
								}
								if(mes == 7){
									mes = '07';
								}
								if(mes == 8){
									mes = '08';
								}
								if(mes == 9){
									mes = '09';
								}
								if(mes == 10){
									mes = '10';
								}
								if(mes == 11){
									mes = '11';
								}
								if(mes == 12){
									mes = '12';
								}


								$scope.dateCf = day + '-' + mes + '-' + yearc;


								$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
								$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

								range2.push({

									"fecha" : $scope.dateCf,
									"pago" : i + 1,
									"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
									"interes" : ($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
									"total" : $scope.p2,
									"saldo" : ($scope.total2 = ($scope.total2 -$scope.capital2)),

								});
								mes++;


								if (i == 119){
									$scope.total3 = $scope.total2;
									$scope.totalSegundoPlan = $scope.p2;

								}
								$scope.finalMesesp2 = (range2.length);

							}
							$scope.range2= range2;



							//////////



							$scope.p3 = ($scope.infoLote.interes_p3 *  Math.pow(1 + $scope.infoLote.interes_p3, ($scope.infoLote.meses + 12) - 120) * $scope.total3) / ( Math.pow(1 + $scope.infoLote.interes_p3, ($scope.infoLote.meses + 12) - 120)-1);


							var range3=[];

							for (var i = 121; i < ($scope.infoLote.meses + 12) + 1; i++) {

								if( (mes == 13) || (mes == 14) ){

									if(mes == 13){

										mes = '01';
										yearc++;

									} else if (mes == 14) {

										mes = '02';
										yearc++;

									}

								}

								if(mes == 2){
									mes = '02';
								}
								if(mes == 3){
									mes = '03';
								}
								if(mes == 4){
									mes = '04';
								}
								if(mes == 5){
									mes = '05';
								}
								if(mes == 6){
									mes = '06';
								}
								if(mes == 7){
									mes = '07';
								}
								if(mes == 8){
									mes = '08';
								}
								if(mes == 9){
									mes = '09';
								}
								if(mes == 10){
									mes = '10';
								}
								if(mes == 11){
									mes = '11';
								}
								if(mes == 12){
									mes = '12';
								}

								$scope.dateCf = day + '-' + mes + '-' + yearc;



								$scope.interes_plan3 = $scope.total3*($scope.infoLote.interes_p3);
								$scope.capital2 = ($scope.p3 - $scope.interes_plan3);

								range3.push({

									"fecha" : $scope.dateCf,
									"pago" : i,
									"capital" : ($scope.capital2 = ($scope.p3 - $scope.interes_plan3)),
									"interes" : ($scope.interes_plan3= ($scope.total3 * $scope.infoLote.interes_p3)),
									"total" : $scope.p3,
									"saldo" : ($scope.total3 = ($scope.total3 -$scope.capital2)),

								});
								mes++;


								if (i == 122){
									$scope.totalTercerPlan = $scope.p3;

								}
								$scope.finalMesesp3 = (range3.length);

							}

							$scope.range3= range3;



							$scope.alphaNumeric = $scope.rangePlanc.concat($scope.range).concat($scope.range2).concat($scope.range3);




							// $scope.alphaNumeric = $scope.range.concat($scope.range2).concat($scope.range3);

							$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
									{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
									{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
									{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
									{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
											//pageMargins [left, top, right, bottom]
											doc.pageMargins = [ 140, 40, 10, 50 ];
											doc.alignment = 'center';

										}},
								]
							).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});



						}
					}
					//////////////////////// OFF PLAN CONTRUCTOR ////////////////////////////////////

					// if($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <=35 && $scope.noPagomensualidad == 0)
					// {
					//
					//
					// 	for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {
					//
					// 		if( (mes == 13) || (mes == 14) ){
					//
					// 			if(mes == 13){
					//
					// 				mes = '01';
					// 				yearc++;
					//
					// 			} else if (mes == 14) {
					//
					// 				mes = '02';
					// 				yearc++;
					//
					// 			}
					//
					// 		}
					//
					//
					//
					// 		if(mes == 2){
					// 			mes = '02';
					// 		}
					// 		if(mes == 3){
					// 			mes = '03';
					// 		}
					// 		if(mes == 4){
					// 			mes = '04';
					// 		}
					// 		if(mes == 5){
					// 			mes = '05';
					// 		}
					// 		if(mes == 6){
					// 			mes = '06';
					// 		}
					// 		if(mes == 7){
					// 			mes = '07';
					// 		}
					// 		if(mes == 8){
					// 			mes = '08';
					// 		}
					// 		if(mes == 9){
					// 			mes = '09';
					// 		}
					// 		if(mes == 10){
					// 			mes = '10';
					// 		}
					// 		if(mes == 11){
					// 			mes = '11';
					// 		}
					// 		if(mes == 12){
					// 			mes = '12';
					// 		}
					//
					//
					// 		$scope.dateCf = day + '-' + mes + '-' + yearc;
					//
					// 		if(i == 0){
					// 			$scope.fechaPM = $scope.dateCf;
					// 		}
					//
					//
					// 		range.push({
					//
					// 			"fecha" : $scope.dateCf,
					// 			"pago" : i + 1,
					// 			"capital" : $scope.infoLote.capital,
					// 			"interes" : 0,
					// 			"total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
					// 			"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,
					//
					// 		});
					// 		mes++;
					//
					// 		if (i == ($scope.infoLote.mesesSinInteresP1 - 1)){
					// 			$scope.total2 = $scope.infoLote.precioTotal;
					// 			$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;
					//
					//
					// 		}
					// 		ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
					// 		$scope.finalMesesp1 = (range.length);
					//
					// 	}
					// 	$scope.range= range;
					//
					// 	//////////
					//
					// 	$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
					//
					// 	var range2=[];
					//
					// 	for (var i = ini2; i < 120; i++) {
					//
					// 		if( (mes == 13) || (mes == 14) ){
					//
					// 			if(mes == 13){
					//
					// 				mes = '01';
					// 				yearc++;
					//
					// 			} else if (mes == 14) {
					//
					// 				mes = '02';
					// 				yearc++;
					//
					// 			}
					//
					// 		}
					//
					// 		if(mes == 2){
					// 			mes = '02';
					// 		}
					// 		if(mes == 3){
					// 			mes = '03';
					// 		}
					// 		if(mes == 4){
					// 			mes = '04';
					// 		}
					// 		if(mes == 5){
					// 			mes = '05';
					// 		}
					// 		if(mes == 6){
					// 			mes = '06';
					// 		}
					// 		if(mes == 7){
					// 			mes = '07';
					// 		}
					// 		if(mes == 8){
					// 			mes = '08';
					// 		}
					// 		if(mes == 9){
					// 			mes = '09';
					// 		}
					// 		if(mes == 10){
					// 			mes = '10';
					// 		}
					// 		if(mes == 11){
					// 			mes = '11';
					// 		}
					// 		if(mes == 12){
					// 			mes = '12';
					// 		}
					//
					//
					// 		$scope.dateCf = day + '-' + mes + '-' + yearc;
					//
					//
					// 		$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
					// 		$scope.capital2 = ($scope.p2 - $scope.interes_plan2);
					//
					// 		range2.push({
					//
					// 			"fecha" : $scope.dateCf,
					// 			"pago" : i + 1,
					// 			"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
					// 			"interes" : ($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
					// 			"total" : $scope.p2,
					// 			"saldo" : ($scope.total2 = ($scope.total2 -$scope.capital2)),
					//
					// 		});
					// 		mes++;
					//
					//
					// 		if (i == 119){
					// 			$scope.total3 = $scope.total2;
					// 			$scope.totalSegundoPlan = $scope.p2;
					//
					// 		}
					// 		$scope.finalMesesp2 = (range2.length);
					//
					// 	}
					// 	$scope.range2= range2;
					//
					//
					//
					// 	//////////
					//
					//
					//
					// 	$scope.p3 = ($scope.infoLote.interes_p3 *  Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120) * $scope.total3) / ( Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120)-1);
					//
					//
					// 	var range3=[];
					//
					// 	for (var i = 121; i < $scope.infoLote.meses + 1; i++) {
					//
					// 		if( (mes == 13) || (mes == 14) ){
					//
					// 			if(mes == 13){
					//
					// 				mes = '01';
					// 				yearc++;
					//
					// 			} else if (mes == 14) {
					//
					// 				mes = '02';
					// 				yearc++;
					//
					// 			}
					//
					// 		}
					//
					// 		if(mes == 2){
					// 			mes = '02';
					// 		}
					// 		if(mes == 3){
					// 			mes = '03';
					// 		}
					// 		if(mes == 4){
					// 			mes = '04';
					// 		}
					// 		if(mes == 5){
					// 			mes = '05';
					// 		}
					// 		if(mes == 6){
					// 			mes = '06';
					// 		}
					// 		if(mes == 7){
					// 			mes = '07';
					// 		}
					// 		if(mes == 8){
					// 			mes = '08';
					// 		}
					// 		if(mes == 9){
					// 			mes = '09';
					// 		}
					// 		if(mes == 10){
					// 			mes = '10';
					// 		}
					// 		if(mes == 11){
					// 			mes = '11';
					// 		}
					// 		if(mes == 12){
					// 			mes = '12';
					// 		}
					//
					// 		$scope.dateCf = day + '-' + mes + '-' + yearc;
					//
					//
					//
					// 		$scope.interes_plan3 = $scope.total3*($scope.infoLote.interes_p3);
					// 		$scope.capital2 = ($scope.p3 - $scope.interes_plan3);
					//
					// 		range3.push({
					//
					// 			"fecha" : $scope.dateCf,
					// 			"pago" : i,
					// 			"capital" : ($scope.capital2 = ($scope.p3 - $scope.interes_plan3)),
					// 			"interes" : ($scope.interes_plan3= ($scope.total3 * $scope.infoLote.interes_p3)),
					// 			"total" : $scope.p3,
					// 			"saldo" : ($scope.total3 = ($scope.total3 -$scope.capital2)),
					//
					// 		});
					// 		mes++;
					//
					//
					// 		if (i == 122){
					// 			$scope.totalTercerPlan = $scope.p3;
					//
					// 		}
					// 		$scope.finalMesesp3 = (range3.length);
					//
					// 	}
					//
					// 	$scope.range3= range3;
					//
					// 	$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
					// 	$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2).concat($scope.range3);
					//
					// 	// $scope.alphaNumeric = $scope.range.concat($scope.range2).concat($scope.range3);
					//
					// 	$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
					// 			{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
					// 			{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
					// 			{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
					// 			{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
					// 					//pageMargins [left, top, right, bottom]
					// 					doc.pageMargins = [ 140, 40, 10, 50 ];
					// 					doc.alignment = 'center';
					//
					// 				}},
					// 		]
					// 	).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
					//
					//
					// }
					if($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <=35  && $scope.noPagomensualidad == 0)
					{

						for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

							if( (mes == 13) || (mes == 14) ){

								if(mes == 13){

									mes = '01';
									yearc++;

								} else if (mes == 14) {

									mes = '02';
									yearc++;

								}

							}

							if(mes == 2){
								mes = '02';
							}
							if(mes == 3){
								mes = '03';
							}
							if(mes == 4){
								mes = '04';
							}
							if(mes == 5){
								mes = '05';
							}
							if(mes == 6){
								mes = '06';
							}
							if(mes == 7){
								mes = '07';
							}
							if(mes == 8){
								mes = '08';
							}
							if(mes == 9){
								mes = '09';
							}
							if(mes == 10){
								mes = '10';
							}
							if(mes == 11){
								mes = '11';
							}
							if(mes == 12){
								mes = '12';
							}


							$scope.dateCf = day + '-' + mes + '-' + yearc;

							if(i == 0){
								$scope.fechaPM = $scope.dateCf;
							}
							var numfinalCount = i+1;
							//new code 18 FEB
							$scope.pagoACapital = function()
							{
								var PagoACapital	=	document.getElementsByName("pagoACapitalNameJS")[0].value;
								var PositionPago	=	document.getElementsByName("pagoACapitalNumberJS")[0].value;
								// console.log("alv, ya llegé aquinumaaaa: " + PagoACapital);
								// console.log("se ingreso un pago en en la mensaualidad: " + PositionPago);
								var saldo	=	 PagoACapital;
								var saldoFinalisimo	=	($scope.saldoFinal - $scope.infoLote.capital);//
								var saldoMenosPC	=	saldoFinalisimo - saldo;
								// $scope.total = saldoFinalisimo - saldo;
								// $scope.porcentajeEng = 0;
								// console.log($scope.total);
								// console.log($scope.precioFinal + " " + (($scope.saldoFinal - $scope.infoLote.capital)) + " " + saldo + " REST " + (saldoMenosPC) );
								// calcularCF();
								// for(var n = 0; n<=i-1 ; n++)
								// {
								// }
								var posicionPay =	PositionPago-1;
								var saldoActual	=	$scope.alphaNumeric[posicionPay]['saldo'];
								var nuevoSaldo	=	($scope.alphaNumeric[posicionPay]['saldo'] - PagoACapital);
								var TestEng = $scope.cantidad;
								// console.log("Saldo actual: " + saldoActual);
								$scope.alphaNumeric[posicionPay]['saldo'] = $scope.alphaNumeric[posicionPay]['saldo'] - PagoACapital;
								// console.log("Este es el nuevo saldo: " + nuevoSaldo);

								// $scope.infoLote.capital=0;
								var posPay = PositionPago-1;
								calcularCF2(nuevoSaldo, posPay, saldo, saldoMenosPC);
								/*aqui me quede con la busqueda de la actualizacion de la tabla*/
							}
							/*nuevo código 24 de FEB*/
							var disp = 0;
							var interes = 0;
							var total = 0;
							var capital = 0;
							if ($scope.infoLote.mesesSinInteresP1 == 0) {
								interes = ($scope.interes_plan2= ($scope.infoLote.precioTotal  * $scope.infoLote.interes_p2));
								capital = ($scope.capital2 = ((($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1)) - $scope.interes_plan2));
								total = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
							}
							else
							{
								capital = $scope.infoLote.capital;
								interes = 0;
								total = $scope.infoLote.capital + $scope.infoLote.interes_p1;
							}
							range.push({
								"fecha" : $scope.dateCf,
								"pago" : i + 1,
								"capital" : capital,
								"interes" : interes,
								"total" : total,
								"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
								"pagoCapital"	:	"",// btnmodal+modalBody --- inputToIns onclick='javascript:console.log(65);' //<button ng-click='addNewChoice()' class='btn btn-success' style='width: 20%;float:right' ><i class='fa fa-plus'></i></button>
							});
							window['pagoCapChange' + numfinalCount]=Function("","console.log('pagoCapChange"+numfinalCount+" el parametro es: " + document.getElementById('#idModel'+numfinalCount) + "');");//
							mes++;

							if (i == ($scope.infoLote.mesesSinInteresP1 - 1)){
								$scope.total2 = $scope.infoLote.precioTotal;
								$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;

							}
							$scope.finalMesesp1 = (range.length);
							ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;

						}
						$scope.range= range;

						//////////

						$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
						var range2=[];


						for (var i = ini2; i < $scope.infoLote.meses; i++) {

							if( (mes == 13) || (mes == 14) ){

								if(mes == 13){

									mes = '01';
									yearc++;

								} else if (mes == 14) {

									mes = '02';
									yearc++;

								}

							}

							if(mes == 2){
								mes = '02';
							}
							if(mes == 3){
								mes = '03';
							}
							if(mes == 4){
								mes = '04';
							}
							if(mes == 5){
								mes = '05';
							}
							if(mes == 6){
								mes = '06';
							}
							if(mes == 7){
								mes = '07';
							}
							if(mes == 8){
								mes = '08';
							}
							if(mes == 9){
								mes = '09';
							}
							if(mes == 10){
								mes = '10';
							}
							if(mes == 11){
								mes = '11';
							}
							if(mes == 12){
								mes = '12';
							}


							$scope.dateCf = day + '-' + mes + '-' + yearc;


							$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
							$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

							range2.push({

								"fecha" : $scope.dateCf,
								"pago" : i + 1,
								"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
								"interes" : ($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
								"total" : $scope.p2,
								"saldo" : ($scope.total2 = ($scope.total2 -$scope.capital2)),
								"disp" : 0

							});

							mes++;

							if (i == ($scope.infoLote.meses - 1)){
								$scope.totalSegundoPlan = $scope.p2;

							}
							$scope.finalMesesp2 = (range2.length);


						}
						$scope.range2= range2;



						$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
						$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2);

						// $scope.alphaNumeric = $scope.range.concat($scope.range2);



						$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
								{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
								{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
								{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
								{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
										//pageMargins [left, top, right, bottom]
										doc.pageMargins = [ 140, 40, 10, 50 ];
										doc.alignment = 'center';

									}},
							]
						).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
					}

					// if($scope.infoLote.mesesSinInteresP1 == 0)
					// {
					// 	$scope.infoLote.mesesSinInteresP1 = ($scope.mesesdiferir > 0) ? ($scope.infoLote.mesesSinInteresP1 + $scope.mesesdiferir) : ($scope.infoLote.mesesSinInteresP1);
					//
					// 	$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.infoLote.precioTotal)
					// 		/ ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
					//
					// 	var range2=[];
					//
					// 	for (var i = ini; i < 120; i++) {
					//
					// 		if( (mes == 13) || (mes == 14) ){
					//
					// 			if(mes == 13){
					//
					// 				mes = '01';
					// 				yearc++;
					//
					// 			} else if (mes == 14) {
					//
					// 				mes = '02';
					// 				yearc++;
					//
					// 			}
					//
					// 		}
					//
					// 		if(mes == 2){
					// 			mes = '02';
					// 		}
					// 		if(mes == 3){
					// 			mes = '03';
					// 		}
					// 		if(mes == 4){
					// 			mes = '04';
					// 		}
					// 		if(mes == 5){
					// 			mes = '05';
					// 		}
					// 		if(mes == 6){
					// 			mes = '06';
					// 		}
					// 		if(mes == 7){
					// 			mes = '07';
					// 		}
					// 		if(mes == 8){
					// 			mes = '08';
					// 		}
					// 		if(mes == 9){
					// 			mes = '09';
					// 		}
					// 		if(mes == 10){
					// 			mes = '10';
					// 		}
					// 		if(mes == 11){
					// 			mes = '11';
					// 		}
					// 		if(mes == 12){
					// 			mes = '12';
					// 		}
					//
					//
					// 		$scope.dateCf = day + '-' + mes + '-' + yearc;
					//
					// 		$scope.interes_plan2 = $scope.infoLote.precioTotal * ($scope.infoLote.interes_p2);
					// 		$scope.capital2 = ($scope.p2 - $scope.interes_plan2);
					//
					// 		range2.push({
					//
					// 			"fecha" : $scope.dateCf,
					// 			"pago" : i + 1,
					// 			"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
					// 			"interes" : ($scope.interes_plan2= ($scope.infoLote.precioTotal * $scope.infoLote.interes_p2)),
					// 			"total" : $scope.p2,
					// 			"saldo" : ($scope.infoLote.precioTotal = ($scope.infoLote.precioTotal -$scope.capital2)),
					//
					// 		});
					// 		mes++;
					//
					// 		if (i == 119){
					// 			$scope.total3 = $scope.infoLote.precioTotal;
					// 			$scope.totalSegundoPlan = $scope.p2;
					//
					// 		}
					// 		$scope.finalMesesp2 = (range2.length);
					//
					// 	}
					// 	$scope.range2= range2;
					//
					//
					//
					// 	//////////
					//
					// 	$scope.p3 = ($scope.infoLote.interes_p3 *  Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120) * $scope.total3) / ( Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120)-1);
					//
					// 	var range3=[];
					//
					// 	for (var i = 121; i < $scope.infoLote.meses + 1; i++) {
					//
					// 		if( (mes == 13) || (mes == 14) ){
					//
					// 			if(mes == 13){
					//
					// 				mes = '01';
					// 				yearc++;
					//
					// 			} else if (mes == 14) {
					//
					// 				mes = '02';
					// 				yearc++;
					//
					// 			}
					//
					// 		}
					//
					// 		if(mes == 2){
					// 			mes = '02';
					// 		}
					// 		if(mes == 3){
					// 			mes = '03';
					// 		}
					// 		if(mes == 4){
					// 			mes = '04';
					// 		}
					// 		if(mes == 5){
					// 			mes = '05';
					// 		}
					// 		if(mes == 6){
					// 			mes = '06';
					// 		}
					// 		if(mes == 7){
					// 			mes = '07';
					// 		}
					// 		if(mes == 8){
					// 			mes = '08';
					// 		}
					// 		if(mes == 9){
					// 			mes = '09';
					// 		}
					// 		if(mes == 10){
					// 			mes = '10';
					// 		}
					// 		if(mes == 11){
					// 			mes = '11';
					// 		}
					// 		if(mes == 12){
					// 			mes = '12';
					// 		}
					//
					// 		$scope.dateCf = day + '-' + mes + '-' + yearc;
					//
					//
					//
					// 		$scope.interes_plan3 = $scope.total3*($scope.infoLote.interes_p3);
					// 		$scope.capital2 = ($scope.p3 - $scope.interes_plan3);
					//
					// 		range3.push({
					//
					// 			"fecha" : $scope.dateCf,
					// 			"pago" : i,
					// 			"capital" : ($scope.capital2 = ($scope.p3 - $scope.interes_plan3)),
					// 			"interes" : ($scope.interes_plan3= ($scope.total3 * $scope.infoLote.interes_p3)),
					// 			"total" : $scope.p3,
					// 			"saldo" : ($scope.total3 = ($scope.total3 -$scope.capital2)),
					//
					// 		});
					// 		mes++;
					//
					//
					// 		if (i == 122){
					// 			$scope.totalTercerPlan = $scope.p3;
					//
					// 		}
					// 		$scope.finalMesesp3 = (range3.length);
					//
					// 	}
					//
					// 	$scope.range3= range3;
					//
					//
					// 	$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
					// 	$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range2).concat($scope.range3);
					//
					// 	//$scope.alphaNumeric = $scope.range2.concat($scope.range3);
					//
					//
					//
					// 	$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
					// 			{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
					// 			{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
					// 			{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
					// 			{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
					// 					//pageMargins [left, top, right, bottom]
					// 					doc.pageMargins = [ 140, 40, 10, 50 ];
					// 					doc.alignment = 'center';
					//
					// 				}},
					// 		]
					// 	).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
					//
					//
					//
					//
					//
					// }
					if($scope.infoLote.mesesSinInteresP1 == 0)
					{
						// console.log('alvnoma 0 intereses');
						$scope.infoLote.mesesSinInteresP1 = ($scope.mesesdiferir > 0 ) ? ($scope.infoLote.mesesSinInteresP1 + $scope.mesesdiferir) : ($scope.infoLote.mesesSinInteresP1);


						$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.infoLote.precioTotal)
							/ ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);

						var range2=[];

						for (var i = ini; i < $scope.infoLote.meses; i++) {

							if( (mes == 13) || (mes == 14) ){

								if(mes == 13){

									mes = '01';
									yearc++;

								} else if (mes == 14) {

									mes = '02';
									yearc++;

								}

							}

							if(mes == 2){
								mes = '02';
							}
							if(mes == 3){
								mes = '03';
							}
							if(mes == 4){
								mes = '04';
							}
							if(mes == 5){
								mes = '05';
							}
							if(mes == 6){
								mes = '06';
							}
							if(mes == 7){
								mes = '07';
							}
							if(mes == 8){
								mes = '08';
							}
							if(mes == 9){
								mes = '09';
							}
							if(mes == 10){
								mes = '10';
							}
							if(mes == 11){
								mes = '11';
							}
							if(mes == 12){
								mes = '12';
							}


							$scope.dateCf = day + '-' + mes + '-' + yearc;

							//nuevo codigo 19 FEB
							$scope.pagoACapital = function()
							{
								var PagoACapital	=	document.getElementsByName("pagoACapitalNameJS")[0].value;
								var PositionPago	=	document.getElementsByName("pagoACapitalNumberJS")[0].value;
								// console.log("alv, ya llegé aquinumaaaa: " + PagoACapital);
								// console.log("se ingreso un pago en en la mensaualidad: " + PositionPago);
								var saldo	=	 PagoACapital;
								var saldoFinalisimo	=	($scope.saldoFinal - $scope.infoLote.capital);//
								var saldoMenosPC	=	saldoFinalisimo - saldo;
								// $scope.total = saldoFinalisimo - saldo;
								// $scope.porcentajeEng = 0;
								// console.log($scope.total);
								// console.log($scope.precioFinal + " " + (($scope.saldoFinal - $scope.infoLote.capital)) + " " + saldo + " REST " + (saldoMenosPC) );
								// calcularCF();
								// for(var n = 0; n<=i-1 ; n++)
								// {
								// }
								var posicionPay =	PositionPago-1;
								var saldoActual	=	$scope.alphaNumeric[posicionPay]['saldo'];
								var nuevoSaldo	=	($scope.alphaNumeric[posicionPay]['saldo'] - PagoACapital);
								var TestEng = $scope.cantidad;
								// console.log("Saldo actual: " + saldoActual);
								$scope.alphaNumeric[posicionPay]['saldo'] = $scope.alphaNumeric[posicionPay]['saldo'] - PagoACapital;
								// console.log("Este es el nuevo saldo: " + nuevoSaldo);

								// $scope.infoLote.capital=0;
								var posPay = PositionPago-1;
								calcularCF2(nuevoSaldo, posPay, saldo, saldoMenosPC);
								/*aqui me quede con la busqueda de la actualizacion de la tabla*/
							}
							//CIERRA CODIGO 19 FEB

							$scope.interes_plan2 = $scope.infoLote.precioTotal * ($scope.infoLote.interes_p2);
							$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

							range2.push({
								"fecha" : $scope.dateCf,
								"pago" : i + 1,
								"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
								"interes" : ($scope.interes_plan2= ($scope.infoLote.precioTotal * $scope.infoLote.interes_p2)),
								"total" : $scope.p2,
								"saldo" : ($scope.infoLote.precioTotal = ($scope.infoLote.precioTotal -$scope.capital2)),
								"pagoCapital"	:	"",
							});
							window['pagoCapChange' + numfinalCount]=Function("","console.log('pagoCapChange"+numfinalCount+" el parametro es: " + document.getElementById('#idModel'+numfinalCount) + "');");//angular.element(document.querySelector('#idModel'+numfinalCount))

							mes++;

							if (i == ($scope.infoLote.meses - 1)){
								$scope.totalSegundoPlan = $scope.p2;
							}
							$scope.finalMesesp2 = (range2.length);
						}
						$scope.range2= range2;

						$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
						$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range2);
						// $scope.alphaNumeric = $scope.range2;


						$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
								{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
								{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
								{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
								{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
										//pageMargins [left, top, right, bottom]
										doc.pageMargins = [ 140, 40, 10, 50 ];
										doc.alignment = 'center';

									}},
							]
						).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});



					}

					// if($scope.infoLote.mesesSinInteresP1 == 36)
					// {
					// 	for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {
					//
					// 		if( (mes == 13) || (mes == 14) ){
					//
					// 			if(mes == 13){
					//
					// 				mes = '01';
					// 				yearc++;
					//
					// 			} else if (mes == 14) {
					//
					// 				mes = '02';
					// 				yearc++;
					//
					// 			}
					//
					// 		}
					//
					//
					//
					// 		if(mes == 2){
					// 			mes = '02';
					// 		}
					// 		if(mes == 3){
					// 			mes = '03';
					// 		}
					// 		if(mes == 4){
					// 			mes = '04';
					// 		}
					// 		if(mes == 5){
					// 			mes = '05';
					// 		}
					// 		if(mes == 6){
					// 			mes = '06';
					// 		}
					// 		if(mes == 7){
					// 			mes = '07';
					// 		}
					// 		if(mes == 8){
					// 			mes = '08';
					// 		}
					// 		if(mes == 9){
					// 			mes = '09';
					// 		}
					// 		if(mes == 10){
					// 			mes = '10';
					// 		}
					// 		if(mes == 11){
					// 			mes = '11';
					// 		}
					// 		if(mes == 12){
					// 			mes = '12';
					// 		}
					//
					//
					// 		$scope.dateCf = day + '-' + mes + '-' + yearc;
					//
					// 		if(i == 0){
					// 			$scope.fechaPM = $scope.dateCf;
					// 		}
					//
					//
					// 		range.push({
					//
					// 			"fecha" : $scope.dateCf,
					// 			"pago" : i + 1,
					// 			"capital" : $scope.infoLote.capital,
					// 			"interes" : 0,
					// 			"total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
					// 			"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,
					//
					// 		});
					// 		mes++;
					//
					// 		if (i == ($scope.infoLote.mesesSinInteresP1 - 1)){
					// 			$scope.total2 = $scope.infoLote.precioTotal;
					// 			$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;
					//
					//
					// 		}
					// 		ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
					// 		$scope.finalMesesp1 = (range.length);
					//
					// 	}
					// 	$scope.range= range;
					//
					// 	//////////
					//
					// 	$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
					//
					// 	var range2=[];
					//
					// 	for (var i = ini2; i < 120; i++) {
					//
					// 		if( (mes == 13) || (mes == 14) ){
					//
					// 			if(mes == 13){
					//
					// 				mes = '01';
					// 				yearc++;
					//
					// 			} else if (mes == 14) {
					//
					// 				mes = '02';
					// 				yearc++;
					//
					// 			}
					//
					// 		}
					//
					// 		if(mes == 2){
					// 			mes = '02';
					// 		}
					// 		if(mes == 3){
					// 			mes = '03';
					// 		}
					// 		if(mes == 4){
					// 			mes = '04';
					// 		}
					// 		if(mes == 5){
					// 			mes = '05';
					// 		}
					// 		if(mes == 6){
					// 			mes = '06';
					// 		}
					// 		if(mes == 7){
					// 			mes = '07';
					// 		}
					// 		if(mes == 8){
					// 			mes = '08';
					// 		}
					// 		if(mes == 9){
					// 			mes = '09';
					// 		}
					// 		if(mes == 10){
					// 			mes = '10';
					// 		}
					// 		if(mes == 11){
					// 			mes = '11';
					// 		}
					// 		if(mes == 12){
					// 			mes = '12';
					// 		}
					//
					//
					// 		$scope.dateCf = day + '-' + mes + '-' + yearc;
					//
					//
					// 		$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
					// 		$scope.capital2 = ($scope.p2 - $scope.interes_plan2);
					//
					// 		range2.push({
					//
					// 			"fecha" : $scope.dateCf,
					// 			"pago" : i + 1,
					// 			"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
					// 			"interes" : ($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
					// 			"total" : $scope.p2,
					// 			"saldo" : ($scope.total2 = ($scope.total2 -$scope.capital2)),
					//
					// 		});
					// 		mes++;
					//
					//
					// 		if (i == 119){
					// 			$scope.total3 = $scope.total2;
					// 			$scope.totalSegundoPlan = $scope.p2;
					//
					// 		}
					// 		$scope.finalMesesp2 = (range2.length);
					//
					// 	}
					// 	$scope.range2= range2;
					//
					//
					//
					// 	//////////
					//
					//
					//
					// 	$scope.p3 = ($scope.infoLote.interes_p3 *  Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120) * $scope.total3) / ( Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120)-1);
					//
					//
					// 	var range3=[];
					//
					// 	for (var i = 121; i < $scope.infoLote.meses + 1; i++) {
					//
					// 		if( (mes == 13) || (mes == 14) ){
					//
					// 			if(mes == 13){
					//
					// 				mes = '01';
					// 				yearc++;
					//
					// 			} else if (mes == 14) {
					//
					// 				mes = '02';
					// 				yearc++;
					//
					// 			}
					//
					// 		}
					//
					// 		if(mes == 2){
					// 			mes = '02';
					// 		}
					// 		if(mes == 3){
					// 			mes = '03';
					// 		}
					// 		if(mes == 4){
					// 			mes = '04';
					// 		}
					// 		if(mes == 5){
					// 			mes = '05';
					// 		}
					// 		if(mes == 6){
					// 			mes = '06';
					// 		}
					// 		if(mes == 7){
					// 			mes = '07';
					// 		}
					// 		if(mes == 8){
					// 			mes = '08';
					// 		}
					// 		if(mes == 9){
					// 			mes = '09';
					// 		}
					// 		if(mes == 10){
					// 			mes = '10';
					// 		}
					// 		if(mes == 11){
					// 			mes = '11';
					// 		}
					// 		if(mes == 12){
					// 			mes = '12';
					// 		}
					//
					// 		$scope.dateCf = day + '-' + mes + '-' + yearc;
					//
					//
					//
					// 		$scope.interes_plan3 = $scope.total3*($scope.infoLote.interes_p3);
					// 		$scope.capital2 = ($scope.p3 - $scope.interes_plan3);
					//
					// 		range3.push({
					//
					// 			"fecha" : $scope.dateCf,
					// 			"pago" : i,
					// 			"capital" : ($scope.capital2 = ($scope.p3 - $scope.interes_plan3)),
					// 			"interes" : ($scope.interes_plan3= ($scope.total3 * $scope.infoLote.interes_p3)),
					// 			"total" : $scope.p3,
					// 			"saldo" : ($scope.total3 = ($scope.total3 -$scope.capital2)),
					//
					// 		});
					// 		mes++;
					//
					//
					// 		if (i == 122){
					// 			$scope.totalTercerPlan = $scope.p3;
					//
					// 		}
					// 		$scope.finalMesesp3 = (range3.length);
					//
					// 	}
					//
					// 	$scope.range3= range3;
					//
					// 	$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
					// 	$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2).concat($scope.range3);
					//
					// 	// $scope.alphaNumeric = $scope.range.concat($scope.range2).concat($scope.range3);
					//
					// 	$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
					// 			{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
					// 			{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
					// 			{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
					// 			{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
					// 					//pageMargins [left, top, right, bottom]
					// 					doc.pageMargins = [ 140, 40, 10, 50 ];
					// 					doc.alignment = 'center';
					//
					// 				}},
					// 		]
					// 	).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
					//
					//
					// }
					if($scope.infoLote.mesesSinInteresP1 == 36)
					{
						console.log('36MSI A 48 MESES');
						for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

							if( (mes == 13) || (mes == 14) ){

								if ($scope.descDate == 0){

									if(mes == 13){

										mes = '01';
										yearc++;

									} else if (mes == 14) {

										mes = '02';
										yearc++;

									}

								} else if($scope.descDate == 1) {
									mes = '03';
									$scope.descDate = 0;


								}

							}

							if(mes == 2){
								mes = '02';
							}
							if(mes == 3){
								mes = '03';
							}
							if(mes == 4){
								mes = '04';
							}
							if(mes == 5){
								mes = '05';
							}
							if(mes == 6){
								mes = '06';
							}
							if(mes == 7){
								mes = '07';
							}
							if(mes == 8){
								mes = '08';
							}
							if(mes == 9){
								mes = '09';
							}
							if(mes == 10){
								mes = '10';
							}
							if(mes == 11){
								mes = '11';
							}
							if(mes == 12){
								mes = '12';
							}

							$scope.dateCf = day + '-' + mes + '-' + yearc;

							if(i == 0){
								$scope.fechaPM = $scope.dateCf;
							}
							var numfinalCount = i+1;
							//new code 18 FEB
							$scope.pagoACapital = function()
							{
								var PagoACapital	=	document.getElementsByName("pagoACapitalNameJS")[0].value;
								var PositionPago	=	document.getElementsByName("pagoACapitalNumberJS")[0].value;
								// console.log("alv, ya llegé aquinumaaaa: " + PagoACapital);
								// console.log("se ingreso un pago en en la mensaualidad: " + PositionPago);
								var saldo	=	 PagoACapital;
								var saldoFinalisimo	=	($scope.saldoFinal - $scope.infoLote.capital);//
								var saldoMenosPC	=	saldoFinalisimo - saldo;
								// $scope.total = saldoFinalisimo - saldo;
								// $scope.porcentajeEng = 0;
								// console.log($scope.total);
								// console.log($scope.precioFinal + " " + (($scope.saldoFinal - $scope.infoLote.capital)) + " " + saldo + " REST " + (saldoMenosPC) );
								// calcularCF();
								// for(var n = 0; n<=i-1 ; n++)
								// {
								// }
								var posicionPay =	PositionPago-1;
								var saldoActual	=	$scope.alphaNumeric[posicionPay]['saldo'];
								var nuevoSaldo	=	($scope.alphaNumeric[posicionPay]['saldo'] - PagoACapital);
								var TestEng = $scope.cantidad;
								// console.log("Saldo actual: " + saldoActual);
								$scope.alphaNumeric[posicionPay]['saldo'] = $scope.alphaNumeric[posicionPay]['saldo'] - PagoACapital;
								// console.log("Este es el nuevo saldo: " + nuevoSaldo);

								// $scope.infoLote.capital=0;
								var posPay = PositionPago-1;
								calcularCF2(nuevoSaldo, posPay, saldo, saldoMenosPC);
								/*aqui me quede con la busqueda de la actualizacion de la tabla*/
							}
							/*nuevo código 24 de FEB*/
							var disp = 0;
							var interes = 0;
							var total = 0;
							var capital = 0;
							if ($scope.infoLote.mesesSinInteresP1 == 0) {
								interes = ($scope.interes_plan2= ($scope.infoLote.precioTotal  * $scope.infoLote.interes_p2));
								capital = ($scope.capital2 = ((($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1)) - $scope.interes_plan2));
								total = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
							}
							else
							{
								capital = $scope.infoLote.capital;
								interes = 0;
								total = $scope.infoLote.capital + $scope.infoLote.interes_p1;
							}
							range.push({
								"fecha" : $scope.dateCf,
								"pago" : i + 1,
								"capital" : capital,
								"interes" : interes,
								"total" : total,
								"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
								"pagoCapital"	:	"",// btnmodal+modalBody --- inputToIns onclick='javascript:console.log(65);' //<button ng-click='addNewChoice()' class='btn btn-success' style='width: 20%;float:right' ><i class='fa fa-plus'></i></button>
								"disp" : 0
							});
							window['pagoCapChange' + numfinalCount]=Function("","console.log('pagoCapChange"+numfinalCount+" el parametro es: " + document.getElementById('#idModel'+numfinalCount) + "');");//angular.element(document.querySelector('#idModel'+numfinalCount))

							//end new code


							//original code 18enero20
							// range.push({
							//
							// 	"fecha" : $scope.dateCf,
							// 	"pago" : i + 1,
							// 	"capital" : $scope.infoLote.capital,
							// 	"interes" : 0,
							// 	"total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
							// 	"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,
							//
							// });
							mes++;

							if (i == ($scope.infoLote.mesesSinInteresP1 - 1)){
								$scope.total2 = $scope.infoLote.precioTotal;
								$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;

							}

							$scope.finalMesesp1 = range.length;
							ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
						}
						$scope.range= range;

						//////////

						// $scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
						$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses) - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses) - $scope.infoLote.mesesSinInteresP1 )-1);
						var range2=[];


						for (var i = ini2; i < $scope.infoLote.meses; i++) {

							if( (mes == 13) || (mes == 14) ){

								if(mes == 13){

									mes = '01';
									yearc++;

								} else if (mes == 14) {

									mes = '02';
									yearc++;

								}

							}

							if(mes == 2){
								mes = '02';
							}
							if(mes == 3){
								mes = '03';
							}
							if(mes == 4){
								mes = '04';
							}
							if(mes == 5){
								mes = '05';
							}
							if(mes == 6){
								mes = '06';
							}
							if(mes == 7){
								mes = '07';
							}
							if(mes == 8){
								mes = '08';
							}
							if(mes == 9){
								mes = '09';
							}
							if(mes == 10){
								mes = '10';
							}
							if(mes == 11){
								mes = '11';
							}
							if(mes == 12){
								mes = '12';
							}


							$scope.dateCf = day + '-' + mes + '-' + yearc;


							$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
							$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

							range2.push({
								"fecha" : $scope.dateCf,
								"pago" : i + 1,
								"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
								"interes" : ($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
								"total" : $scope.p2,
								"saldo" : ($scope.total2 = ($scope.total2 -$scope.capital2)),
								"disp" : 0
							});

							mes++;

							if (i == ($scope.infoLote.meses - 1)){
								$scope.totalSegundoPlan = $scope.p2;

							}
							$scope.finalMesesp2 = (range2.length);


						}
						$scope.range2= range2;



						$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
						$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2);



						$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
								{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
								{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
								{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
								{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
										//pageMargins [left, top, right, bottom]
										doc.pageMargins = [ 140, 40, 10, 50 ];
										doc.alignment = 'center';

									}},
							]
						).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
					}
				}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			}


			$scope.paquetes = [];

			$scope.ages = [{age: 18}, {age: 19}, {age: 20}, {age: 21},{age: 22}, {age: 23}, {age: 24}, {age: 25},{age: 26}, {age: 27}, {age: 28}, {age: 29},{age: 30}, {age: 31}, {age: 32},{age: 33}, {age: 34}, {age: 35}, {age: 36},{age: 37}, {age: 38}, {age: 39}, {age: 40}, {age: 41}, {age: 42}, {age: 43}, {age: 44}, {age: 45}, {age: 46}, {age: 47}, {age: 48}, {age: 49}, {age: 50}, {age: 51}, {age: 52}, {age: 53}, {age: 54}, {age: 55},{age: 56}, {age: 57}, {age: 58}, {age: 59}, {age: 60}, {age: 61}, {age: 62},{age: 63}, {age: 64}, {age: 65}, {age: 66}, {age: 67}, {age: 68}, {age: 69}, {age: 70},{age: 71}, {age: 72}, {age: 73}, {age: 74},{age: 75}]


			$scope.diasEnganche = [{day: 7}, {day: 25}, {day: 'Diferido'}]

			$scope.diasDiferidos = [1, 2, 3, 4, 5, 6];




			$scope.daysEng = function() {
				$scope.daysEnganche = $scope.day.day;

				var TuFecha = new Date();
				var dias = parseInt($scope.daysEnganche);
				TuFecha.setDate(TuFecha.getDate() + dias);
				if($scope.day.day != 'Diferido')
				{
					$scope.fechaEng = TuFecha.getDate() + '-' + (TuFecha.getMonth() + 1) + '-' + TuFecha.getFullYear();
					var apartado = angular.element( document.querySelector( '#aptdo' ) );
					var mesesdiferidos = angular.element( document.querySelector( '#msdif' ) );

					$( '#aptdo' ).prop( "disabled", true );
					$( '#msdif' ).prop( "disabled", true );
					if($scope.day.day ==25 || $scope.day.day ==7)
					{
						$scope.rangEd=[];
						$scope.validaEngDif=[];
						$('#aptdo').val("");
						$scope.mesesdiferir = 0;
						if($scope.selected.descuentos)
						{
							var descLenght = $scope.selected.descuentos.length;
							for(i=0; i<=descLenght-1; i++)
							{
								if($scope.selected.descuentos[i]['id_condicion'] == 2)
								{
									$scope.selected.descuentos[i]=[];
								}
							}
						}

						calcularCF();
						var finalLenght = $scope.decFin.length;
						for(i=0; i<=finalLenght-1; i++)
						{
							if($scope.decFin[i]["td"] == 2)
							{
								$scope.decFin[i]="";
								var finalLenght = descuentosAplicados.length;
								for(i=0; i<=finalLenght-1; i++)
								{
									if(descuentosAplicados[i]["id_condicion"] == 2)
									{
										descuentosAplicados[i]=[];
										calcularCF();
									}
									else
									{
									}
								}
							}
							else
							{
							}
						}
					}
				}
				else
				{
					$scope.fechaEng = 'Fecha Indefinida';
					if($scope.day.day =='Diferido')
					{
						var apartado = angular.element( document.querySelector( '#aptdo' ) );
						var mesesdiferidos = angular.element( document.querySelector( '#msdif' ) );

						$( '#aptdo' ).prop( "disabled", false );
						$( '#msdif' ).prop( "disabled", false );
						var finalLenght = $scope.decFin.length;
						for(i=0; i<=finalLenght-1; i++)
						{
							if($scope.decFin[i]["td"] == 2)
							{
								$scope.decFin[i]="";
								var finalLenght = descuentosAplicados.length;
								for(i=0; i<=finalLenght-1; i++)
								{
									if(descuentosAplicados[i]["id_condicion"] == 2)
									{
										descuentosAplicados[i]=[];
										calcularCF();
									}
									else
									{
									}
								}
							}
							else
							{
							}
						}
					}
				}

			};


			$scope.ChengecheckEngDif = function(){
				calcularCF();
			}


			$scope.changeDaysEng = function(){
				calcularCF();
			}


			$scope.getAge = function(age) {
				$scope.age_view = $scope.age.age;
				if(age <= 55){


					$scope.yearsplan = [{yearplan: 20}, {yearplan: 19},{yearplan: 18}, {yearplan: 17}, {yearplan: 16}, {yearplan: 15},{yearplan: 14}, {yearplan: 13},
						{yearplan: 12}, {yearplan: 11},{yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7},{yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

				} else if(age == 56){

					$scope.yearsplan = [{yearplan: 19},{yearplan: 18}, {yearplan: 17}, {yearplan: 16}, {yearplan: 15},{yearplan: 14}, {yearplan: 13},
						{yearplan: 12}, {yearplan: 11},{yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7},{yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

				} else if(age == 57){

					$scope.yearsplan = [{yearplan: 18}, {yearplan: 17}, {yearplan: 16}, {yearplan: 15},{yearplan: 14}, {yearplan: 13},
						{yearplan: 12}, {yearplan: 11},{yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7},{yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

				} else if(age == 58){

					$scope.yearsplan = [{yearplan: 17}, {yearplan: 16}, {yearplan: 15},{yearplan: 14}, {yearplan: 13},
						{yearplan: 12}, {yearplan: 11},{yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7},{yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

				}
				else if(age == 59){

					$scope.yearsplan = [{yearplan: 16}, {yearplan: 15},{yearplan: 14}, {yearplan: 13},
						{yearplan: 12}, {yearplan: 11},{yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7},{yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

				} else if(age == 60){

					$scope.yearsplan = [{yearplan: 15},{yearplan: 14}, {yearplan: 13},
						{yearplan: 12}, {yearplan: 11},{yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7},{yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]
				} else if(age == 61){

					$scope.yearsplan = [{yearplan: 14}, {yearplan: 13},
						{yearplan: 12}, {yearplan: 11},{yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7},{yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

				} else if(age == 62){

					$scope.yearsplan = [{yearplan: 13},
						{yearplan: 12}, {yearplan: 11},{yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7},{yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

				} else if(age == 63){

					$scope.yearsplan = [{yearplan: 12}, {yearplan: 11},{yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7},{yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

				} else if(age == 64){

					$scope.yearsplan = [{yearplan: 11},{yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7},{yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]


				} else if(age == 65){

					$scope.yearsplan = [{yearplan: 10}, {yearplan: 9}, {yearplan: 8}, {yearplan: 7},{yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

				}

				else if(age == 66){

					$scope.yearsplan = [{yearplan: 9}, {yearplan: 8}, {yearplan: 7},{yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

				}

				else if(age == 67){

					$scope.yearsplan = [{yearplan: 8}, {yearplan: 7},{yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]


				} else if(age == 68){

					$scope.yearsplan = [{yearplan: 7},{yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]


				} else if(age == 69){

					$scope.yearsplan = [{yearplan: 6}, {yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]


				} else if(age == 70){

					$scope.yearsplan = [{yearplan: 5}, {yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]


				} else if(age == 71){

					$scope.yearsplan = [{yearplan: 4}, {yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

				} else if(age == 72){

					$scope.yearsplan = [{yearplan: 3}, {yearplan: 2}, {yearplan: 1}]

				}

				else if(age == 73){

					$scope.yearsplan = [{yearplan: 2}, {yearplan: 1}]

				} else if(age == 74 || age == 75){

					$scope.yearsplan = [{yearplan: 1}]

				}


			};

			$scope.getAgePlan = function() {
				$scope.age_plan = $scope.yearplan.yearplan;
				calcularCF();
			};



			$scope.selectPorcentajeEnganche = function() {
				$scope.porcentajeEng = $scope.porcentaje;
				/*nuevo*/
				var porcentajeEnganche = angular.element( document.querySelector('#porcentajeEnganche') );
				var cantidadEnganche  =  angular.element(document.querySelector('#cantidadEnganche'));
				var r1 = $scope.total;
				if(porcentajeEnganche.val() >= 0 && porcentajeEnganche.val()<=100)
				{
					var engToShow  =   (r1 * (porcentajeEnganche.val() / 100));
					cantidadEnganche.val(parseFloat(engToShow).toFixed(2));
				}
				/*termina nuevo*/
				calcularCF();
			};

			//https://contratacion.gphsis.com/contratacion/index.php/queryInventario/getResidencialDisponible
			$http.get("<?=base_url()?>index.php/queryInventario/getResidencialDisponible").then(
				function(data){
					$scope.residencial = data.data;
				},
				function(data){
				});

			$scope.onSelectChangep = function(proyecto) {
				//https://contratacion.gphsis.com/contratacion/index.php/queryInventario/getCondominioDisponibleA
				$http.post('<?=base_url()?>index.php/queryInventario/getCondominioDisponibleA',{residencial: proyecto.idResidencial}).then(
					function (response) {

						var apartado = angular.element( document.querySelector( '#aptdo' ) );
						var mesesdiferidos = angular.element( document.querySelector( '#msdif' ) );
						var checkPack = angular.element( document.querySelector('#checkPack') );
						var cehboxInterno = angular.element( document.querySelector('#paquete.id_paquete') );

						$scope.condominios = response.data;
						$scope.lotes = "";
						$scope.plan = "";
						$scope.diasEnganche = [{day: 7}, {day: 25}, {day: 'Diferido'}]
						$scope.porcentaje="";
						$scope.cantidad="";
						apartado.val('0');
						mesesdiferidos.val('[1, 2, 3, 4, 5, 6]');
						$scope.superficie="";
						$scope.preciom2="";
						$scope.total="";
						$scope.porcentajeInv="";
						$scope.CurrentDate="";
						$scope.enganche="";
						$scope.paquetes = "";

						$scope.nombreLote = "";
						$scope.preciom2 = "";
						$scope.preciom2F = "";
						$scope.saldoFinal = "";
						$scope.precioTotal = "";
						$scope.precioFinal = "";
						$scope.age_plan = "";
						$scope.daysEnganche = "";
						$scope.fechaEng = "";
						$scope.engancheFinal = "";
						$scope.totalPrimerPlan ="";
						$scope.fechaPM = "";
						$scope.totalSegundoPlan ="";
						$scope.finalMesesp1 = "";
						$scope.finalMesesp2 = "";
						$scope.finalMesesp3 = "";
						$scope.banco = "";
						$scope.rsocial = "";
						$scope.cuenta = "";
						$scope.clabe = "";
						$scope.referencia = "";
						$scope.totalTercerPlan ="";

						if(checkPack){
							var r1=0;
							var a=0;
							var b=0;
							var porcentaje2=0;
							var arreglo = [];
							var arreglo2 = [];
							var porcentajeDeEnganche = $scope.porcentajeEng;
							$scope.decFin = [];
							enganche = 0;
							r1= (r1 - enganche);
							a +=  porcentaje2;
							b = (0 - a);
							c = (b/0);
							arreglo.push({ahorro: a, pm: c, pt: b});
							$scope.decFin =arreglo;
							if(descuentosAplicados)
							{
								descuentosAplicados=[];
							}
						}


						if(!$scope.alphaNumeric)
						{
						}
						else
						{
							$scope.alphaNumeric = [];
							$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
								{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
								{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
								{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
								{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
										doc.pageMargins = [ 140, 40, 10, 50 ];
										doc.alignment = 'center';}},]).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
						}
					},
					function (response) {
					});
			}

			$scope.onSelectChangec = function(condominio) {
				//https://contratacion.gphsis.com/contratacion/index.php/queryInventario/getLoteDisponibleA
				$http.post('<?=base_url()?>index.php/queryInventario/getLoteDisponibleA',{condominio: condominio.idCondominio}).then(
					function (response) {
						$scope.lotes = response.data;

						var apartado = angular.element( document.querySelector( '#aptdo' ) );
						var mesesdiferidos = angular.element( document.querySelector( '#msdif' ) );
						var checkPack = angular.element( document.querySelector('#checkPack') );
						var cehboxInterno = angular.element( document.querySelector('#paquete.id_paquete') );

						$scope.plan = "";
						$scope.diasEnganche = [{day: 7}, {day: 25}, {day: 'Diferido'}]
						$scope.porcentaje="";
						$scope.cantidad="";
						apartado.val('0');
						mesesdiferidos.val('[1, 2, 3, 4, 5, 6]');
						$scope.superficie="";
						$scope.preciom2="";
						$scope.total="";
						$scope.porcentajeInv="";
						$scope.CurrentDate="";
						$scope.enganche="";
						$scope.paquetes = "";

						$scope.nombreLote = "";
						$scope.preciom2 = "";
						$scope.preciom2F = "";
						$scope.saldoFinal = "";
						$scope.precioTotal = "";
						$scope.precioFinal = "";
						$scope.age_plan = "";
						$scope.daysEnganche = "";
						$scope.fechaEng = "";
						$scope.engancheFinal = "";
						$scope.totalPrimerPlan ="";
						$scope.fechaPM = "";
						$scope.totalSegundoPlan ="";
						$scope.finalMesesp1 = "";
						$scope.finalMesesp2 = "";
						$scope.finalMesesp3 = "";
						$scope.banco = "";
						$scope.rsocial = "";
						$scope.cuenta = "";
						$scope.clabe = "";
						$scope.referencia = "";
						$scope.totalTercerPlan ="";

						if(checkPack){
							var r1=0;
							var a=0;
							var b=0;
							var porcentaje2=0;
							var arreglo = [];
							var arreglo2 = [];
							var porcentajeDeEnganche = $scope.porcentajeEng;
							$scope.decFin = [];
							enganche = 0;
							r1= (r1 - enganche);
							a +=  porcentaje2;
							b = (0 - a);
							c = (b/0);
							arreglo.push({ahorro: a, pm: c, pt: b});
							$scope.decFin =arreglo;
							if(descuentosAplicados)
							{
								descuentosAplicados=[];
							}

						}
						if(!$scope.alphaNumeric)
						{
						}
						else
						{
							$scope.alphaNumeric = [];
							$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
								{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
								{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
								{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
								{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
										doc.pageMargins = [ 140, 40, 10, 50 ];
										doc.alignment = 'center';}},]).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
						}
					},
					function (response) {
					});
			}
			$scope.onSelectChangel = function(lote) {
				//https://contratacion.gphsis.com/contratacion/index.php/queryInventario/getinfoLoteDisponible
				$http.post('<?=base_url()?>index.php/queryInventario/getinfoLoteDisponible',{lote: lote.idLote}).then(
					function (response) {

						/*Reinicia los valores del arreglo que trae descuentos*/
						descuentosAplicados=[];
						$scope.selected = {};
						$scope.porcentaje = $scope.porcentajeEng = 0;
						$scope.descDate = 0;
						$scope.noPagomensualidad = 0;


						$scope.selectDescuentos = function(descuento, checked){

							var idx = descuentosAplicados.indexOf(descuento);
							/* console.log('Tienes un número negativo ' +idx); */
							if (idx >= 0 && !checked) {
								descuentosAplicados.splice(idx, 1);
								$scope.descApply = descuentosAplicados;


								for(var descuentos of $scope.descApply){

									if(descuentos.id_paquete == 118 || descuentos.id_paquete == 151){
										if(descuentos.id_paquete == 118){
											$scope.descDate = 1;
										} else if (descuentos.id_paquete == 151){
											$scope.noPagomensualidad = 1;
										}
									} else if (descuentos.id_paquete != 118 || descuentos.id_paquete != 151) {
										$scope.descDate = 0;
										$scope.noPagomensualidad = 0;
									}

								}

								if($scope.descApply.length == 0){
									$scope.descDate = 0;
									$scope.noPagomensualidad = 0;
								}

							}

							if (idx < 0 && checked) {
								descuentosAplicados.push(descuento);
								$scope.descApply = descuentosAplicados;
								for(var descuentos of $scope.descApply){

									if(descuentos.id_paquete == 118 || descuentos.id_paquete == 151){
										if(descuentos.id_paquete == 118){
											$scope.descDate = 1;
										} else if (descuentos.id_paquete == 151){
											$scope.noPagomensualidad = 1;
										}
									} else if (descuentos.id_paquete != 118 || descuentos.id_paquete != 151) {
										$scope.descDate = 0;
										$scope.noPagomensualidad = 0;
									}

								}

							}
							/*  console.log("El valor del indez del arreglo es: "+idx); */
							calcularCF();
						}
						/*Termina Reinicia los valores del arreglo que trae descuentos*/



						$scope.superficie = response.data[0].sup;
						$scope.preciom2 = response.data[0].precio;
						$scope.total = response.data[0].total;
						$scope.porcentajeInv = response.data[0].porcentaje;
						$scope.enganche = response.data[0].enganche;
						$scope.CurrentDate = new Date();

						$scope.nombreLote = response.data[0].nombreLote;
						$scope.precioTotal = response.data[0].total;
						$scope.superficie = response.data[0].sup;
						$scope.preciom2 = response.data[0].precio;

						$scope.banco = response.data[0].banco;
						$scope.rsocial = response.data[0].empresa;
						$scope.cuenta = response.data[0].cuenta;
						$scope.clabe = response.data[0].clabe;
						$scope.referencia = response.data[0].referencia;
						$scope.msni = response.data[0].msni;
						calcularCF();


						/*Reset vars from eng days*/
						var apartado = angular.element( document.querySelector( '#aptdo' ) );
						var mesesdiferidos = angular.element( document.querySelector( '#msdif' ) );
						var checkPack = angular.element( document.querySelector('#checkPack') );
						var cehboxInterno = angular.element( document.querySelector('#paquete.id_paquete') );
						var porcentajeEnganche = angular.element( document.querySelector('#porcentajeEnganche') );
						var cantidadEnganche   =  angular.element( document.querySelector('#cantidadEnganche') );
						$scope.diasEnganche=[{day: 7}, {day: 25}, {day: 'Diferido'}];
						$scope.cantidad="";
						porcentajeEnganche.val('10');
						apartado.val('0');
						$scope.porcentajeEng = "10";
						cantidadEnganche.val(response.data[0].enganche);
						mesesdiferidos.val('[1, 2, 3, 4, 5, 6]');


						calcularCF();

////////////////////////////////////////////////////////////////////////////////////////////////////////
						//https://contratacion.gphsis.com/contratacion/index.php/corrida/descuentos
						$http.post('<?=base_url()?>index.php/corrida/descuentos',{lote: response.data[0].idLote}).then(
							function(paquetes){
								$scope.paquetes = paquetes.data;
							},
							function(paquetes){
							});
////////////////////////////////////////////////////////////////////////////////////////////////////////

					},
					function (response) {
					});
			}
			//https://contratacion.gphsis.com/contratacion/index.php/corrida/getGerente
			$http.get("<?=base_url()?>index.php/corrida/getGerente").then(
				function(data){
					$scope.gerentes = data.data;
				},
				function(data){
				});
			//https://contratacion.gphsis.com/contratacion/index.php/corrida/getAsesor
			$scope.onSelectChangeg = function(gerente) {
				$http.post('<?=base_url()?>index.php/corrida/getAsesor',{gerente: gerente.idGerente}).then(
					function (response) {
						$scope.asesores = response.data;
					},
					function (response) {
					});
			}




			$scope.payPlan = function() {
				var planPay = $scope.plan;
				var yearplan  =  angular.element( document.querySelector('#yearplan') );
				var day       =  angular.element(document.querySelector('#day'));
				var porcentajeEnganche =  angular.element(document.querySelector('#porcentajeEnganche'));
				var cantidadEnganche   =  angular.element(document.querySelector('#cantidadEnganche'));
				var aptdo              =  angular.element(document.querySelector('#aptdo'));
				var msdif              =  angular.element(document.querySelector('#msdif'));
				if(planPay == 'Crédito') {
					yearplan.prop('disabled', false);
					day.prop('disabled', false);
					porcentajeEnganche.val($scope.porcentajeInv);
					porcentajeEnganche.prop('disabled', false);
					cantidadEnganche.val($scope.enganche);
					cantidadEnganche.prop('disabled', false);
					aptdo.prop('disabled', true);
					msdif.prop('disabled', true);
					$scope.engancheFinal = ($scope.infoLote.engancheF);
					$scope.porcentajeEng = 10;
					calcularCF();
				}
				else if(planPay == 'Contado') {
					yearplan.prop('disabled', true);
					day.prop('disabled', true);
					porcentajeEnganche.val("");
					porcentajeEnganche.prop('disabled', true);
					cantidadEnganche.val("");
					cantidadEnganche.prop('disabled', true);
					aptdo.prop('disabled', true);
					msdif.prop('disabled', true);
					$scope.engancheFinal = "";
					$scope.porcentajeEng = 0;
					calcularCF();
				}
			}



			$scope.exportc = function() {

				var nombre = ($scope.nombre == undefined) ? 0 : $scope.nombre;
				var id_lote = ($scope.lote == undefined) ? 0 : $scope.lote.idLote;
				var edad = ($scope.age == undefined) ? 0 : $scope.age.age;
				var telefono = ($scope.telefono == undefined) ? 0 : $scope.telefono;
				var correo = ($scope.email == undefined) ? 0 : $scope.email;
				var asesor = ($scope.asesor == undefined) ? 0 : $scope.asesor.idAsesor;
				var gerente = ($scope.gerente == undefined) ? 0 : $scope.gerente.idGerente;
				var plan = ($scope.plan == undefined) ? 0 : $scope.plan;

				if(plan == 'Crédito') {
					var anio = ($scope.yearplan == undefined) ? 0 : $scope.yearplan.yearplan;
				} else if(plan == 'Contado'){
					var anio = 'Activo';
				}

				var dias_pagar_enganche = ($scope.day == undefined) ? 0 : $scope.day.day;
				var porcentaje_enganche = ($scope.porcentaje == undefined) ? 0 : $scope.porcentaje;
				var cantidad_enganche = ($scope.cantidad == undefined) ? 0 : $scope.cantidad;
				var meses_diferir = ($scope.mesesdiferir == undefined) ? 0 : $scope.mesesdiferir;
				var apartado = ($scope.apartado == undefined) ? 0 : $scope.apartado;

				var paquete = ($scope.descApply == undefined) ? 0 : $scope.descApply[0].id_paquete;

				if(paquete > 0) {
					var paqueteEach = $scope.descApply;
					var joinDesc = [];

					for(var descuentos of paqueteEach){
						joinDesc.push(descuentos.id_descuento);
					}
					var cadenaDesc = joinDesc.join(',');
					var opcion_paquete = cadenaDesc;

					var precio_m2_final = $scope.decFin[$scope.decFin.length - 1].pm;

				} else if(paquete == 0){
					var opcion_paquete = 0;
					var precio_m2_final = $scope.preciom2;
				}

				if(id_lote > 0) {

					var saldoc = $scope.saldoFinal;
					var precioFinalc = $scope.precioFinal;
					var fechaEngc = ($scope.fechaEng == undefined) ? 0 : $scope.fechaEng
					var engancheFinalc = $scope.engancheFinal;
					var msi_1p = ($scope.totalPrimerPlan == undefined) ? 0 : $scope.totalPrimerPlan;
					var msi_2p = ($scope.totalSegundoPlan == undefined) ? 0 : $scope.totalSegundoPlan;
					var msi_3p = ($scope.totalTercerPlan == undefined) ? 0 : $scope.totalTercerPlan;
					var primer_mensualidad = $scope.fechaPM;
					var allDescuentos = $scope.decFin;

					var finalMesesp1 = ($scope.finalMesesp1 == 0 || $scope.finalMesesp1 == undefined) ? 0 : $scope.finalMesesp1;
					var finalMesesp2 = ($scope.finalMesesp2 == 0 || $scope.finalMesesp2 == undefined) ? 0 : $scope.finalMesesp2;
					var finalMesesp3 = ($scope.finalMesesp3 == 0 || $scope.finalMesesp3 == undefined) ? 0 : $scope.finalMesesp3;


				}
				var observaciones = ($scope.observaciones == undefined) ? 0 : $scope.observaciones;


				var loaderDiv = angular.element(document.querySelector('#loaderDiv'));

				if(nombre == 0 || edad == 0 || id_lote == 0 || plan == 0 || anio == 0 || gerente == 0 || asesor == 0){


					$.confirm({
						title: '¡Alerta!',
						content: '¡El campo nombre, edad, lote, plan de crédito, años de crédito, gerente y asesor son obligatorios' + '!',
						typeAnimated: true,
						icon: 'fa fa-warning',
						theme: 'modern',
						closeIcon: true,
						animation: 'scale',
						type: 'orange',
						buttons: {
							cancel: {
								text: 'OK',
								action: function () {
									toastr.success('¡Ahora! Cotizemos.');
								}
							}
						}
					});



				} else {

					anio = (anio == 'Activo') ? '0' : anio;

					//https://contratacion.gphsis.com/contratacion/index.php/corrida/editar_ds
					$http.post('<?=base_url()?>index.php/corrida/editar_ds',{nombre: nombre, id_lote: id_lote, edad: edad, telefono: telefono, correo: correo, asesor: asesor, gerente: gerente,
						plan: plan, anio: anio, dias_pagar_enganche: dias_pagar_enganche, porcentaje_enganche: porcentaje_enganche, cantidad_enganche: cantidad_enganche, meses_diferir: meses_diferir,
						apartado: apartado, paquete: paquete, opcion_paquete: opcion_paquete, precio_m2_final: precio_m2_final, saldoc: saldoc, precioFinalc: precioFinalc, fechaEngc: fechaEngc,
						engancheFinalc: engancheFinalc, msi_1p: msi_1p, msi_2p: msi_2p, msi_3p: msi_3p, primer_mensualidad: primer_mensualidad, allDescuentos: allDescuentos, finalMesesp1: finalMesesp1, finalMesesp2: finalMesesp2,
						finalMesesp3: finalMesesp3, observaciones: observaciones }).then(
						function(response){

							if(response.data.message == 'OK') {

								var data = $scope.alphaNumeric;
								var id_corrida = response.data[0].id_corrida;
								//https://contratacion.gphsis.com/contratacion/index.php/corrida/insertCorrida
								$http.post('<?=base_url()?>index.php/corrida/insertCorrida',{data: data, id_corrida: id_corrida}).then(
									function (data) {
										//https://contratacion.gphsis.com/contratacion/index.php/corrida/caratula/
										$window.open("<?=base_url()?>index.php/corrida/caratula/" + id_corrida);
										loaderDiv.addClass('hide');

									},
									function (response) {
									});

								toastr.success('Corrida guardada exitosamente');
								loaderDiv.removeClass('hide');

							}
							else if(response.data.message == 'ERROR'){
								toastr.error('Error al guardar corrida');
							}
						},
						function(){
						});

				}

			}






			$scope.exportcf = function() {

				var nombre = ($scope.nombre == undefined) ? 0 : $scope.nombre;
				var id_lote = ($scope.lote == undefined) ? 0 : $scope.lote.idLote;
				var edad = ($scope.age == undefined) ? 0 : $scope.age.age;
				var telefono = ($scope.telefono == undefined) ? 0 : $scope.telefono;
				var correo = ($scope.email == undefined) ? 0 : $scope.email;
				var asesor = ($scope.asesor == undefined) ? 0 : $scope.asesor.idAsesor;
				var gerente = ($scope.gerente == undefined) ? 0 : $scope.gerente.idGerente;
				var plan = ($scope.plan == undefined) ? 0 : $scope.plan;
				var anio = ($scope.yearplan == undefined) ? 0 : $scope.yearplan.yearplan;

				if(plan == 'Crédito') {
					var anio = ($scope.yearplan == undefined) ? 0 : $scope.yearplan.yearplan;
				} else if(plan == 'Contado'){
					var anio = 'Activo';
				}

				var dias_pagar_enganche = ($scope.day == undefined) ? 0 : $scope.day.day;
				var porcentaje_enganche = ($scope.porcentaje == undefined) ? 0 : $scope.porcentaje;
				var cantidad_enganche = ($scope.cantidad == undefined) ? 0 : $scope.cantidad;
				var meses_diferir = ($scope.mesesdiferir == undefined) ? 0 : $scope.mesesdiferir;
				var apartado = ($scope.apartado == undefined) ? 0 : $scope.apartado;

				var paquete = ($scope.descApply == undefined) ? 0 : $scope.descApply[0].id_paquete;

				if(paquete > 0) {
					var paqueteEach = $scope.descApply;
					var joinDesc = [];

					for(var descuentos of paqueteEach){
						joinDesc.push(descuentos.id_descuento);
					}
					var cadenaDesc = joinDesc.join(',');
					var opcion_paquete = cadenaDesc;

					var precio_m2_final = $scope.decFin[$scope.decFin.length - 1].pm;

				} else if(paquete == 0){
					var opcion_paquete = 0;
					var precio_m2_final = $scope.preciom2;
				}

				if(id_lote > 0) {

					var saldoc = $scope.saldoFinal;
					var precioFinalc = $scope.precioFinal;
					var fechaEngc = ($scope.fechaEng == undefined) ? 0 : $scope.fechaEng
					var engancheFinalc = $scope.engancheFinal;
					var msi_1p = ($scope.totalPrimerPlan == undefined) ? 0 : $scope.totalPrimerPlan;
					var msi_2p = ($scope.totalSegundoPlan == undefined) ? 0 : $scope.totalSegundoPlan;
					var msi_3p = ($scope.totalTercerPlan == undefined) ? 0 : $scope.totalTercerPlan;
					var primer_mensualidad = $scope.fechaPM;
					var allDescuentos = $scope.decFin;

					var finalMesesp1 = ($scope.finalMesesp1 == 0 || $scope.finalMesesp1 == undefined) ? 0 : $scope.finalMesesp1;
					var finalMesesp2 = ($scope.finalMesesp2 == 0 || $scope.finalMesesp2 == undefined) ? 0 : $scope.finalMesesp2;
					var finalMesesp3 = ($scope.finalMesesp3 == 0 || $scope.finalMesesp3 == undefined) ? 0 : $scope.finalMesesp3;


				}
				var observaciones = ($scope.observaciones == undefined) ? 0 : $scope.observaciones;

				var loaderDiv = angular.element(document.querySelector('#loaderDiv'));

				if(nombre == 0 || edad == 0 || id_lote == 0 || plan == 0 || anio == 0 || gerente == 0 || asesor == 0){


					$.confirm({
						title: '¡Alerta!',
						content: '¡El campo nombre, edad, lote, plan de crédito, años de crédito, gerente y asesor son obligatorios' + '!',
						typeAnimated: true,
						icon: 'fa fa-warning',
						theme: 'modern',
						closeIcon: true,
						animation: 'scale',
						type: 'orange',
						buttons: {
							cancel: {
								text: 'OK',
								action: function () {
									toastr.success('¡Ahora! Cotizemos.');
								}
							}
						}
					});



				} else {

					anio = (anio == 'Activo') ? '0' : anio;
					//https://contratacion.gphsis.com/contratacion/index.php/corrida/editar_ds
					$http.post('<?=base_url()?>index.php/corrida/editar_ds',{nombre: nombre, id_lote: id_lote, edad: edad, telefono: telefono, correo: correo, asesor: asesor, gerente: gerente,
						plan: plan, anio: anio, dias_pagar_enganche: dias_pagar_enganche, porcentaje_enganche: porcentaje_enganche, cantidad_enganche: cantidad_enganche, meses_diferir: meses_diferir,
						apartado: apartado, paquete: paquete, opcion_paquete: opcion_paquete, precio_m2_final: precio_m2_final, saldoc: saldoc, precioFinalc: precioFinalc, fechaEngc: fechaEngc,
						engancheFinalc: engancheFinalc, msi_1p: msi_1p, msi_2p: msi_2p, msi_3p: msi_3p, primer_mensualidad: primer_mensualidad, allDescuentos: allDescuentos, finalMesesp1: finalMesesp1, finalMesesp2: finalMesesp2,
						finalMesesp3: finalMesesp3, observaciones: observaciones }).then(
						function(response){

							if(response.data.message == 'OK') {

								var data = $scope.alphaNumeric;
								var id_corrida = response.data[0].id_corrida;
								//https://contratacion.gphsis.com/contratacion/index.php/corrida/insertCorrida
								$http.post('<?=base_url()?>index.php/corrida/insertCorrida',{data: data, id_corrida: id_corrida}).then(
									function (data) {
										//https://contratacion.gphsis.com/contratacion/index.php/corrida/caratulacf/
										$window.open("<?=base_url()?>index.php/corrida/caratulacf/" + id_corrida);
										loaderDiv.addClass('hide');

									},
									function (response) {
									});
								toastr.success('Corrida guardada exitosamente');
								loaderDiv.removeClass('hide');

							}
							else if(response.data.message == 'ERROR'){
								toastr.error('Error al guardar corrida');
							}
						},
						function(){
						});

				}

			}









			$scope.dtoptions = DTOptionsBuilder;
			$scope.dtColumns = [
				DTColumnBuilder.newColumn('fecha').withTitle('Fechas'),
				DTColumnBuilder.newColumn('pago').withTitle('Pago #'),
				DTColumnBuilder.newColumn('capital').withTitle('Capital').renderWith(function(data, type, full) {return (data.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' }))}),
				DTColumnBuilder.newColumn('interes').withTitle('Intereses').renderWith(function(data, type, full) {return (data.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' }))}),
				DTColumnBuilder.newColumn('total').withTitle('Total').renderWith(function(data, type, full) {return (data.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' }))}),
				DTColumnBuilder.newColumn('saldo').withTitle('Saldo').renderWith(function(data, type, full) {return (data.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' }))}),
				DTColumnBuilder.newColumn('pagoCapital').withTitle('Pago a Capital')
					.renderWith(
						function(data, type, full, meta) {
							var inputCapital = '<input name="capVal'+full["pago"]+'" type="text" id="idModel'+full["pago"]+'" ng-model="myModeloAlv" onchange="pagoCapChange('+full["pago"]+')" placeholder="Ingresa un Pago a Capital " class="form-control">';
							var numberPay	 = '<input name="numberPay'+full["pago"]+'" type="hidden" id="payNum'+full["pago"]+'" value="'+full["pago"]+'">';

							return inputCapital+numberPay;
						},
					),
			];

			function calcularCF2(nuevoSaldo, posPay, saldo, saldoMenosPC)
			{
				// console.log(nuevoSaldo + " " + (posPay + 1) + " " + $scope.infoLote.capital);
				var pagoACapitalCantidad = saldoMenosPC;

				//INICIO FECHA
				var day;
				var month = (new Date().getMonth() + 1);
				var yearc = new Date().getFullYear();


				if (month == 1) {
					day = '0' + 1;
				}
				if (month == 2) {
					day = '0 ' + 2;
				}
				if (month == 3) {
					day = '0' + 3;
				}
				if (month == 4) {
					day = '0' + 6;
				}
				if (month == 5) {
					day = '0' + 7;
				}
				if (month == 6) {
					day = '0' + 8;
				}
				if (month == 7) {
					day = 11;
				}
				if (month == 8) {
					day = 12;
				}
				if (month == 9) {
					day = 13;
				}
				if (month == 10) {
					day = 14;
				}
				if (month == 11) {
					day = 16;
				}
				if (month == 12) {
					day = 17;
				}

				var mes = ($scope.apartado && $scope.mesesdiferir > 0) ? (new Date().getMonth() + 2) : (new Date().getMonth() + 3);

				//FIN FECHA

				var ini;
				var ini2;
				var ini3;


				/////////////////////////// ENGANCHE DIFERIDO ////////////////////////////////////

				if ($scope.day && $scope.apartado && $scope.mesesdiferir > 0) {

					var engd = (enganche - $scope.apartado);
					var engd2 = (engd / $scope.mesesdiferir);
					var saldoDif = ($scope.precioFinal);

					var rangEd = [];
					for (var e = 0; e < $scope.mesesdiferir; e++) {

						if (mes == 13) {
							mes = '01';
							yearc++;
						}
						if (mes == 2) {
							mes = '02';
						}
						if (mes == 3) {
							mes = '03';
						}
						if (mes == 4) {
							mes = '04';
						}
						if (mes == 5) {
							mes = '05';
						}
						if (mes == 6) {
							mes = '06';
						}
						if (mes == 7) {
							mes = '07';
						}
						if (mes == 8) {
							mes = '08';
						}
						if (mes == 9) {
							mes = '09';
						}
						if (mes == 10) {
							mes = '10';
						}
						if (mes == 11) {
							mes = '11';
						}
						if (mes == 12) {
							mes = '12';
						}

						$scope.dateCf = day + '-' + mes + '-' + yearc;

						if (e == 0) {
							$scope.fechaPM = $scope.dateCf;
						}

						rangEd.push({
							"fecha": $scope.dateCf,
							"pago": e + 1,
							"capital": engd2,
							"interes": 0,
							"total": engd2,
							"saldo": saldoDif -= engd2,

						});
						mes++;
					}

					$scope.rangEd = rangEd;

				}

				/////////////////////////// ENGANCHE DIFERIDO ////////////////////////////////////


				var r1 = $scope.saldoFinal; //$scope.saldoFinal

				$scope.infoLote = {
					precioTotal: r1,
					yPlan: $scope.age_plan,
					msn: $scope.msni,
					meses: ($scope.age_plan * 12),
					mesesSinInteresP1: $scope.msni,
					mesesSinInteresP2: 120,
					mesesSinInteresP3: 60,
					interes_p1: 0,
					interes_p2: 0.01,
					interes_p3: 0.0125,
					contadorInicial: 0,
					capital: ($scope.mesesdiferir > 0) ? (r1 / (($scope.age_plan * 12) - $scope.mesesdiferir)) : (r1 / ($scope.age_plan * 12)),
					fechaActual: $scope.date = new Date(),
					engancheF: 0,//enganche,
					pagoCapital: saldo
				}


				/////////// TABLES DE 1 A 3 AÑOS ////////////
				if ($scope.infoLote.meses >= 12 && $scope.infoLote.meses <= 36)
				{
					/*me quede en esta posición para tratar de averguar cuales son las posciones que se est+á saltanlarabdo esta asd4*/
					// for(var n=1;n<=$scope.alphaNumeric.length-1;n++)
					// {
					//     var ok=$scope.alphaNumeric[n]['saldo'];
					//     if($scope.alphaNumeric[n]['disp'] == 0)
					//     {
					//         console.log("esta posicion " + n + " tiene " + $scope.alphaNumeric[n]['pagoCapital'] );
					//         $scope.alphaNumeric[n]['saldo'] = ok;
					//     }
					// }
					/************************/
					var range = [];
					ini = ($scope.mesesdiferir >= 0) ? $scope.mesesdiferir : $scope.infoLote.contadorInicial;
					if ($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <= 35   && $scope.noPagomensualidad == 1)
					{
						ini = $scope.infoLote.contadorInicial;
						if ($scope.noPagomensualidad == 1)
						{
							////////////////////////////////////////////////////////////////////////////////////
							var rangePlanc = [];
							for (var i = ini; i < 12; i++)
							{
								if ((mes == 13) || (mes == 14)) {
									if ($scope.descDate == 0) {
										if (mes == 13) {
											mes = '01';
											yearc++;
										} else if (mes == 14) {
											mes = '02';
											yearc++;
										}
									} else if ($scope.descDate == 1) {
										mes = '03';
										$scope.descDate = 0;
									}
								}
								if (mes == 2) {
									mes = '02';
								}
								if (mes == 3) {
									mes = '03';
								}
								if (mes == 4) {
									mes = '04';
								}
								if (mes == 5) {
									mes = '05';
								}
								if (mes == 6) {
									mes = '06';
								}
								if (mes == 7) {
									mes = '07';
								}
								if (mes == 8) {
									mes = '08';
								}
								if (mes == 9) {
									mes = '09';
								}
								if (mes == 10) {
									mes = '10';
								}
								if (mes == 11) {
									mes = '11';
								}
								if (mes == 12) {
									mes = '12';
								}

								$scope.dateCf = day + '-' + mes + '-' + yearc;

								if (i == 0) {
									$scope.fechaPM = $scope.dateCf;
								}
								var newSaldoTable = 0;
								var alphaOriginal = [];
								alphaOriginal = $scope.alphaNumeric;
								if ($scope.alphaNumeric[i]['disp'] != 1)
								{
									/*Para verfificar donde se puso el pago a capital*/
									var dispPC = 0;
									var vuelta = (i + 1);
									var posicionPago = (posPay + 1);
									if (vuelta == posicionPago)
									{
										if (posicionPago == 1)
										{
											/* Este if es para ver si se descuenta la primera posicion*/
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
											dispPC = 1;
											pagoACapitalCantidad = saldo;
										}
										else
										{/* Este else es para ver si se descuenta apartir de la segunda posicion*/
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
											dispPC = $scope.alphaNumeric[posPay]['dispPC'] = 1;
											pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
										}
									}
									else
									{
										/*Hace el calculo cuando es 0apartir de la segunda posición*/
										if ($scope.alphaNumeric[i]['disp'] == 0 || $scope.alphaNumeric[i]['disp'] == undefined)
										{
											//else despues del primer post en segunda posicion
											if ($scope.alphaNumeric[i]['pago'] >= posicionPago)
											{
												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'] - saldo;
												dispPC = 0;
												pagoACapitalCantidad = 0;
											}
											else if ($scope.alphaNumeric[i]['pago'] <= posicionPago)
											{
												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
												// dispPC = 0;
												dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
												pagoACapitalCantidad = 0;
											}
										}
										else
										{
											//else despues del primer post
											if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
												dispPC = 0;
												pagoACapitalCantidad = 0;

											} else if ($scope.alphaNumeric[i]['pago'] <= posicionPago) {

												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
												dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
												pagoACapitalCantidad = 0;
											}
										}
									}
									rangePlanc.push({
										"fecha": $scope.dateCf,
										"pago": i + 1,
										"capital": 0,
										"interes": 0,
										"total": 0,
										"saldo": newSaldoTable,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
										"pagoCapital": pagoACapitalCantidad,
										"disp": dispPC,
									});
								}
								else
								{
									/*Se coloca el valor anterior de donde se modificó, con el valor que trae por defecto en el areglo*/
									rangePlanc.push({
										"fecha": $scope.dateCf,
										"pago": i + 1,
										"capital": $scope.alphaNumeric[i]['capital'],
										"interes": 0,
										"total": $scope.alphaNumeric[i]['total'],
										"saldo": $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
										"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
										"disp": $scope.alphaNumeric[i]['disp'],
									});
								}
								// rangePlanc.push({
								// 	"fecha": $scope.dateCf,
								// 	"pago": i + 1,
								// 	"capital": 0,
								// 	"interes": 0,
								// 	"total": 0,
								// 	"saldo": $scope.saldoFinal,
								// });
								mes++;
								$scope.finalMesesp1PlanC = rangePlanc.length;
								ini = rangePlanc.length;
							}
							$scope.rangePlanc = rangePlanc;
							////////////////////////////////////////////////////////////////////////////////////


							for (var i = ini; i <= $scope.infoLote.mesesSinInteresP1 - 1; i++)
							{
								if (mes == 13) {
									mes = '01';
									yearc++;
								}
								if (mes == 2) {
									mes = '02';
								}
								if (mes == 3) {
									mes = '03';
								}
								if (mes == 4) {
									mes = '04';
								}
								if (mes == 5) {
									mes = '05';
								}
								if (mes == 6) {
									mes = '06';
								}
								if (mes == 7) {
									mes = '07';
								}
								if (mes == 8) {
									mes = '08';
								}
								if (mes == 9) {
									mes = '09';
								}
								if (mes == 10) {
									mes = '10';
								}
								if (mes == 11) {
									mes = '11';
								}
								if (mes == 12) {
									mes = '12';
								}
								$scope.dateCf = day + '-' + mes + '-' + yearc;

								if (i == 0) {
									$scope.fechaPM = $scope.dateCf;
								}
								var newSaldoTable = 0;
								var alphaOriginal = [];
								alphaOriginal = $scope.alphaNumeric;
								if ($scope.alphaNumeric[i]['disp'] != 1)
								{
									/*Para verfificar donde se puso el pago a capital*/
									var dispPC = 0;
									var vuelta = (i + 1);
									var posicionPago = (posPay + 1);
									if (vuelta == posicionPago) {
										// console.log("se tiene que poner esto " + saldo + " en la posición: " + (posPay + 1));
										if (posicionPago == 1) {
											/* Este if es para ver si se descuenta la primera posicion*/
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
											dispPC = 1;
											pagoACapitalCantidad = saldo;
										} else {/* Este else es para ver si se descuenta apartir de la segunda posicion*/
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
											dispPC = $scope.alphaNumeric[posPay]['dispPC'] = 1;
											pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
											// console.log('se descuente de la posicion ' + i);
										}
									}
									else
									{
										/*Hace el calculo cuando es 0apartir de la segunda posición*/
										if ($scope.alphaNumeric[i]['disp'] == 0 || $scope.alphaNumeric[i]['disp'] == undefined) {
											//else despues del primer post en segunda posicion
											if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'] - saldo;
												dispPC = 0;
												pagoACapitalCantidad = 0;
											} else if ($scope.alphaNumeric[i]['pago'] <= posicionPago) {
												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
												// dispPC = 0;
												dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
												pagoACapitalCantidad = 0;
											}
										} else {
											//else despues del primer post
											if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
												dispPC = 0;
												pagoACapitalCantidad = 0;

											} else if ($scope.alphaNumeric[i]['pago'] <= posicionPago) {

												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
												dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
												pagoACapitalCantidad = 0;
											}
										}
									}
									range.push({
										"fecha": $scope.dateCf,
										"pago": i + 1,
										"capital": $scope.infoLote.capital,
										"interes": 0,
										"total": $scope.infoLote.capital + $scope.infoLote.interes_p1,
										"saldo": newSaldoTable,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
										"pagoCapital": pagoACapitalCantidad,
										"disp": dispPC,
									});
								}
								else
								{
									/*Se coloca el valor anterior de donde se modificó, con el valor que trae por defecto en el areglo*/
									range.push({
										"fecha": $scope.dateCf,
										"pago": i + 1,
										"capital": $scope.alphaNumeric[i]['capital'],
										"interes": 0,
										"total": $scope.alphaNumeric[i]['total'],
										"saldo": $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
										"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
										"disp": $scope.alphaNumeric[i]['disp'],
									});
								}
								/*finaliza funcion*/
								mes++;
								if (i == ($scope.infoLote.mesesSinInteresP1 - 1)) {
									$scope.total2 = $scope.infoLote.precioTotal;
									// alert($scope.total2);
									$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;
								}
								$scope.finalMesesp1 = range.length;
								ini2 = (range.length + rangePlanc.length);
							}
							// $scope.finalMesesp1 = range.length;
							// ini2 = (range.length + rangePlanc.length);
							// }
							$scope.range = range;
							//////////
							// $scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses + 12) - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / (Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses + 12) - $scope.infoLote.mesesSinInteresP1) - 1);
							var range2 = [];
							// console.log("xd: " + $scope.infoLote.precioTotal);
							// for (var i = ini2; i < ($scope.infoLote.meses + 12); i++)
							for (var i = ini2; i < ($scope.infoLote.meses + 12); i++)
							{
								if (mes == 13) {
									mes = '01';
									yearc++;
								}
								if (mes == 2) {
									mes = '02';
								}
								if (mes == 3) {
									mes = '03';
								}
								if (mes == 4) {
									mes = '04';
								}
								if (mes == 5) {
									mes = '05';
								}
								if (mes == 6) {
									mes = '06';
								}
								if (mes == 7) {
									mes = '07';
								}
								if (mes == 8) {
									mes = '08';
								}
								if (mes == 9) {
									mes = '09';
								}
								if (mes == 10) {
									mes = '10';
								}
								if (mes == 11) {
									mes = '11';
								}
								if (mes == 12) {
									mes = '12';
								}
								$scope.dateCf = day + '-' + mes + '-' + yearc;
								if (i == 0) {
									$scope.fechaPM = $scope.fechapago;
								}
								//nuevo codigo 21 FEB
								var interes = 0;
								var total = 0;
								var capital = 0;
								var newSaldoTable = 0;

								var alphaOriginal = [];
								alphaOriginal = $scope.alphaNumeric;

								if ($scope.alphaNumeric[i]['disp'] != 1)
								{
									var vuelta = (i + 1);
									var posicionPago = (posPay + 1);
									if (vuelta == posicionPago) {
										if (posicionPago == 1) {
											// console.log('primera posicion');
										}
										else
										{
											// console.log('Segunda posicion: ' + $scope.alphaNumeric[posPay]['saldo'] + 'pagocap: ' + saldo);
											capital = $scope.alphaNumeric[posPay]['capital'];
											newSaldoTable = $scope.total2 = $scope.alphaNumeric[posPay]['saldo'];//= nuevoSaldo;//saldo es el pago a capital (facepalm)
											dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
											pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
											interes = $scope.alphaNumeric[posPay]['interes'];//$scope.alphaNumeric[posPay]['saldo'] * $scope.infoLote.interes_p2
											total = $scope.alphaNumeric[posPay]['total'];//capital + interes
											$scope.alphaNumeric[posPay]['control'] = 1;
										}
									}
									else
									{
										if ($scope.alphaNumeric[posicionPago]['pagoCapital'] == 0 || $scope.alphaNumeric[posicionPago]['pagoCapital']==undefined)
										{
											if (i < posicionPago)
											{
												capital = $scope.alphaNumeric[i]['capital'];
												newSaldoTable = $scope.alphaNumeric[i]['saldo'];//saldo es el pago a capital (facepalm)
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												interes = $scope.alphaNumeric[i]['interes'];
												total = $scope.alphaNumeric[i]['total'];
											}
											else
											{
												if ($scope.alphaNumeric[i]['disp'] == undefined || $scope.alphaNumeric[i]['disp'] == 0)
												{
													if (posicionPago < ($scope.infoLote.msn))
													{
														var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 + 12);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
														parte1 = parte1;
														var parte2 = (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 + 12 ) - 1);
														parte2 = parte2;
														$scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo'] = $scope.infoLote.precioTotal;
														operacionCompleta = (($scope.infoLote.interes_p2 * parte1 * $scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo']) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
													}
													else //if(posicionPago>=$scope.infoLote.msn)
													{
														var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago'] + 12);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
														parte1 = parte1;

														var parte2 = (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago'] + 12) - 1);
														parte2 = parte2;
														operacionCompleta = (($scope.infoLote.interes_p2 * parte1 * $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2)) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
													}
													$scope.interes_plan2 = $scope.alphaNumeric[(i - 1)]['saldo'] * ($scope.infoLote.interes_p2);
													capital = operacionCompleta - $scope.interes_plan2;//($scope.capital2 =	 ($scope.p2 - $scope.interes_plan2))
													// console.log("interes: " + $scope.interes_plan2);
													newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i)]['saldo'] = $scope.total2 - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
													dispPC = $scope.alphaNumeric[i]['disp'] = 0;
													pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
													total = operacionCompleta;//$scope.p2
													interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												}
												else
												{
													capital = $scope.capital2;
													newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i - 1)]['saldo'] - $scope.alphaNumeric[i]['pagoCapital'] - $scope.capital2;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
													dispPC = $scope.alphaNumeric[i]['disp'] = 0;
													pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
													interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
													total = $scope.p2;//$scope.p2
												}
											}
										}
										else
										{
											if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago) {
												if ($scope.alphaNumeric[posicionPago]['disp'] == 1) {
													dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
													saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
													pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'];
												} else {//se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion
													dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
												}
											} else {
												//cuando se salta un espacio en la tabla
												saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
												total = 999999999999999;
											}
										}
									}
									range2.push({
										"fecha": $scope.dateCf,
										"pago": i + 1,
										"capital": capital,
										"interes": interes,
										"total": total,
										"saldo": newSaldoTable,//newSaldoTable
										"pagoCapital": pagoACapitalCantidad,
										"disp": dispPC,
									});
								}
								else
								{
									range2.push({
										"fecha": $scope.dateCf,
										"pago": i + 1,
										"capital": $scope.alphaNumeric[i]['capital'],
										"interes": $scope.alphaNumeric[i]['interes'],
										"total": $scope.alphaNumeric[i]['total'],
										"saldo": $scope.alphaNumeric[i]['saldo'],//newSaldoTable
										"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
										"disp": $scope.alphaNumeric[i]['disp'],
									});
								}
								mes++;
								if (i == ($scope.infoLote.meses - 1)) {
									$scope.totalSegundoPlan = total;
								}
								$scope.finalMesesp2 = (range2.length);
							}
							$scope.range2 = range2;


							$scope.alphaNumeric = $scope.rangePlanc.concat($scope.range).concat($scope.range2);
							$scope.dtoptions = DTOptionsBuilder;
							$scope.dtColumns = [
								DTColumnBuilder.newColumn('fecha').withTitle('Fechas'),
								DTColumnBuilder.newColumn('pago').withTitle('Pago #'),
								DTColumnBuilder.newColumn('capital').withTitle('Capital').renderWith(function (data, type, full) {
									return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
								}),
								DTColumnBuilder.newColumn('interes').withTitle('Intereses').renderWith(function (data, type, full) {
									return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
								}),
								DTColumnBuilder.newColumn('total').withTitle('Total').renderWith(function (data, type, full) {
									return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
								}),
								DTColumnBuilder.newColumn('saldo').withTitle('Saldo').renderWith(function (data, type, full) {
									return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
								}),
								DTColumnBuilder.newColumn('pagoCapital').withTitle('Pago a Capital')
									.renderWith(
										function (data, type, full, meta) {
											// console.log($scope.alphaNumeric[full['pago']-1]['saldo']);
											if ($scope.alphaNumeric[full['pago'] - 1]['saldo'] <= 0) {
												$scope.alphaNumeric[full['pago'] - 1]['saldo'] = 0;
											}
											if ($scope.alphaNumeric[posicionPago - 1]['disp'] == 1 && $scope.alphaNumeric[posicionPago - 1]['pagoCapital'] != "" && full['pagoCapital'] != "")//
											{
												// console.log($scope.alphaNumeric[posicionPago-1]['pago']   +" "+	posicionPago);
												// console.log('Estoy llegando aquí');
												// return "$ " + saldo;
												var inputCapital = '<input name="capVal' + full["pago"] + '" type="number" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control" value="' + $scope.alphaNumeric[full['pago'] - 1]['pagoCapital'] + '" disabled>';
												var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
												return inputCapital + numberPay;
											} else {
												var inputCapital = '<input name="capVal' + full["pago"] + '" type="text" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control">';
												var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
												return inputCapital + numberPay;
											}
											// console.log($scope.alphaNumeric[posicionPago-1]['disp']	+	" "	+	$scope.alphaNumeric[posicionPago-1]['pagoCapital']);
										},
									),
							];
							$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
									{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
									{
										extend: 'print',
										text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
										titleAttr: 'Imprimir'
									},
									{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
									{
										extend: 'pdfHtml5',
										text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
										titleAttr: 'PDF',
										title: '',
										customize: function (doc) {
											//pageMargins [left, top, right, bottom]
											doc.pageMargins = [140, 40, 10, 50];
											doc.alignment = 'center';

										}
									},
								]
							).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
						}
					}
					if ($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <= 35   && $scope.noPagomensualidad == 0)
					{

						for (var i = ini; i <= $scope.infoLote.mesesSinInteresP1 - 1; i++) {
							if (mes == 13) {
								mes = '01';
								yearc++;
							}
							if (mes == 2) {
								mes = '02';
							}
							if (mes == 3) {
								mes = '03';
							}
							if (mes == 4) {
								mes = '04';
							}
							if (mes == 5) {
								mes = '05';
							}
							if (mes == 6) {
								mes = '06';
							}
							if (mes == 7) {
								mes = '07';
							}
							if (mes == 8) {
								mes = '08';
							}
							if (mes == 9) {
								mes = '09';
							}
							if (mes == 10) {
								mes = '10';
							}
							if (mes == 11) {
								mes = '11';
							}
							if (mes == 12) {
								mes = '12';
							}
							$scope.dateCf = day + '-' + mes + '-' + yearc;

							if (i == 0) {
								$scope.fechaPM = $scope.dateCf;
							}
							var newSaldoTable = 0;
							var alphaOriginal = [];
							alphaOriginal = $scope.alphaNumeric;
							if ($scope.alphaNumeric[i]['disp'] != 1) {
								/*Para verfificar donde se puso el pago a capital*/
								var dispPC = 0;
								var vuelta = (i + 1);
								var posicionPago = (posPay + 1);
								if (vuelta == posicionPago) {
									// console.log("se tiene que poner esto " + saldo + " en la posición: " + (posPay + 1));
									if (posicionPago == 1) {
										/* Este if es para ver si se descuenta la primera posicion*/
										newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
										dispPC = 1;
										pagoACapitalCantidad = saldo;
										// console.log('se desceunta de la primera posicion');
									} else {/* Este else es para ver si se descuenta apartir de la segunda posicion*/
										// alert('olv');
										newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
										dispPC = $scope.alphaNumeric[posPay]['dispPC'] = 1;
										pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
										// console.log('se descuente de la posicion ' + i);
									}
									/*ghdfhfdhdhdfhdh*/
									//anterior a 19 enero20
									// for (var n = 0; n < posicionPago; n++) {
									// 	if ($scope.alphaNumeric[n]['disp'] == 0 || $scope.alphaNumeric[n]['disp'] == "0") {
									// 		if ($scope.alphaNumeric[n]['pago'] < posicionPago) {
									// 			console.log($scope.alphaNumeric[n]['pago']);
									// 			$scope.alphaNumeric[n]['saldo'] = alphaOriginal[n]['saldo'];//alphaOriginal[n]['saldo']
									// 			console.log("este es el saldo " + alphaOriginal[n]['saldo'] + " en " + n)
									// 		}
									// 	}
									// }
									// for (var n = 0; n < posicionPago; n++)
									// {
									// 	if($scope.alphaNumeric[n]['disp']!="")
									// 	{
									// 		newSaldoTable = 99999;
									// 	}
									// }
								} else {
									/*Hace el calculo cuando es 0apartir de la segunda posición*/
									if ($scope.alphaNumeric[i]['disp'] == 0 || $scope.alphaNumeric[i]['disp'] == undefined) {
										//newSaldoTable = $scope.inufoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital;
										// dispPC = 0;
										// pagoACapitalCantidad = 0;
										//else despues del primer post en segunda posicion
										if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'] - saldo;
											dispPC = 0;
											pagoACapitalCantidad = 0;
										} else if ($scope.alphaNumeric[i]['pago'] <= posicionPago) {
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
											// dispPC = 0;
											dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
											pagoACapitalCantidad = 0;
										}
									} else {
										//else despues del primer post
										// console.log($scope.alphaNumeric[i]['disp']);
										// console.log('posicion de pago ene ste punto :' + posicionPago);
										if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
											dispPC = 0;
											pagoACapitalCantidad = 0;

										} else if ($scope.alphaNumeric[i]['pago'] <= posicionPago) {

											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
											dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
											pagoACapitalCantidad = 0;
										}
										// if ($scope.alphaNumeric[posicionPago]['pago'] >= posicionPago || $scope.alphaNumeric[posicionPago]['pago'] <= posicionPago)
										// {
										// 	if ($scope.alphaNumeric[posicionPago]['disp'] == 1)
										// 	{
										// 		/*aqui se coloca cuando se hay pagos abajo del nuevo, ejemplo Pago 5:550 y se quiere colocar uno en el 2*/
										// 		newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posicionPago]['saldo'];
										// 		dispPC = 1;
										// 		pagoACapitalCantidad = $scope.alphaNumeric[posicionPago]['pagoCapital'];
										// 	}
										// 	else
										// 	{/*se coloca un valor cuando nohay nada(el resto de los campos*/
										// 			newSaldoTable = $scope.alphaNumeric[i]['saldo'];
										// 			dispPC = 0;
										// 			pagoACapitalCantidad = 0;
										// 	}
										// }
										// else
										// {
										// 	newSaldoTable = 0;
										// 	dispPC = 0;
										// 	pagoACapitalCantidad = 0;
										// }
									}
								}
								range.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.infoLote.capital,
									"interes": 0,
									"total": $scope.infoLote.capital + $scope.infoLote.interes_p1,
									"saldo": newSaldoTable,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
									"pagoCapital": pagoACapitalCantidad,
									"disp": dispPC,
								});
							} else {
								/*Se coloca el valor anterior de donde se modificó, con el valor que trae por defecto en el areglo*/
								range.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.alphaNumeric[i]['capital'],
									"interes": 0,
									"total": $scope.alphaNumeric[i]['total'],
									"saldo": $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
									"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
									"disp": $scope.alphaNumeric[i]['disp'],
								});
								// range.push({
								//     "fecha": $scope.alphaNumeric[i]['fecha'],
								//     "pago": i + 1,
								//     "capital": $scope.alphaNumeric[i]['capital'],
								//     "interes": 0,
								//     "total": $scope.alphaNumeric[i]['total'],
								//     "saldo": $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
								//     "pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
								//     "disp": $scope.alphaNumeric[i]['disp'],
								// });
							}
							/*finaliza funcion*/
							// range.push({
							//     "fecha" : $scope.dateCf,
							//     "pago" : i + 1,
							//     "capital" : $scope.infoLote.capital,
							//     "interes" : 0,
							//     "total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
							//     "saldo" : newSaldoTable,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
							//     "pagoCapital" : pagoACapitalCantidad,
							//     "disp":dispPC,
							// });
							mes++;
							if (i == ($scope.infoLote.mesesSinInteresP1 - 1)) {
								$scope.total2 = $scope.infoLote.precioTotal;
								// alert($scope.total2);
								$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;
							}
							$scope.finalMesesp1 = range.length;
							ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
						}
						$scope.range = range;

						//////////
						// var range2=[];
						// $scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.alphaNumeric[i]['saldo']) / (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);
						var range2 = [];
						// console.log("Saldo para el segundo arreglo " + $scope.total2);
						for (var i = ini2; i < $scope.infoLote.meses; i++) {
							if (mes == 13) {
								mes = '01';
								yearc++;
							}
							if (mes == 2) {
								mes = '02';
							}
							if (mes == 3) {
								mes = '03';
							}
							if (mes == 4) {
								mes = '04';
							}
							if (mes == 5) {
								mes = '05';
							}
							if (mes == 6) {
								mes = '06';
							}
							if (mes == 7) {
								mes = '07';
							}
							if (mes == 8) {
								mes = '08';
							}
							if (mes == 9) {
								mes = '09';
							}
							if (mes == 10) {
								mes = '10';
							}
							if (mes == 11) {
								mes = '11';
							}
							if (mes == 12) {
								mes = '12';
							}
							$scope.dateCf = day + '-' + mes + '-' + yearc;
							if (i == 0) {
								$scope.fechaPM = $scope.fechapago;
							}
							//nuevo codigo 21 FEB
							var interes = 0;
							var total = 0;
							var capital = 0;
							var newSaldoTable = 0;

							// interes = $scope.interes_plan2=$scope.total2*$scope.infoLote.interes_p2;
							// total = $scope.p2;
							var alphaOriginal = [];
							alphaOriginal = $scope.alphaNumeric;

							if ($scope.alphaNumeric[i]['disp'] != 1) {
								var vuelta = (i + 1);
								var posicionPago = (posPay + 1);
								if (vuelta == posicionPago) {
									if (posicionPago == 1) {
										// console.log('primera posicion');
									} else {
										// console.log('Segunda posicion: ' + $scope.alphaNumeric[posPay]['saldo'] + 'pagocap: ' + saldo);
										capital = $scope.alphaNumeric[posPay]['capital'];
										newSaldoTable = $scope.total2 = $scope.alphaNumeric[posPay]['saldo'];//= nuevoSaldo;//saldo es el pago a capital (facepalm)
										dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
										pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
										interes = $scope.alphaNumeric[posPay]['interes'];//$scope.alphaNumeric[posPay]['saldo'] * $scope.infoLote.interes_p2
										total = $scope.alphaNumeric[posPay]['total'];//capital + interes
										$scope.alphaNumeric[posPay]['control'] = 1;
									}
								} else {
									// console.log('el total hasta este punto es de: ' + $scope.total2);
									if ($scope.alphaNumeric[posicionPago]['pagoCapital'] == 0) {
										// capital = $scope.alphaNumeric[i]['capital']=99999999999999;
										// newSaldoTable = $scope.alphaNumeric[i]['saldo'];//saldo es el pago a capital (facepalm)
										// dispPC = $scope.alphaNumeric[i]['disp'] = 0;
										// pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
										if (i < posicionPago) {
											capital = $scope.alphaNumeric[i]['capital'];
											newSaldoTable = $scope.alphaNumeric[i]['saldo'];//saldo es el pago a capital (facepalm)
											dispPC = $scope.alphaNumeric[i]['disp'] = 0;
											pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
											interes = $scope.alphaNumeric[i]['interes'];
											total = $scope.alphaNumeric[i]['total'];
										} else {

											// $scope.interes_plan2 = $scope.alphaNumeric[(i-1)]['saldo'] * ($scope.infoLote.interes_p2);//$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
											// $scope.capital2 = (($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.alphaNumeric[i]['saldo'])
											//  / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1) - $scope.interes_plan2);

											// $scope.capital2 = ((($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1)) - $scope.interes_plan2);

											// capital = $scope.capital2 ;
											// newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i - 1)]['saldo'] - $scope.alphaNumeric[i]['pagoCapital'] - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
											// dispPC = $scope.alphaNumeric[i]['disp'] = 0;
											// pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
											// interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
											// total = $scope.p2 ;//$scope.p2


											// $scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.alphaNumeric[i]['saldo'] ) / (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);
											if ($scope.alphaNumeric[i]['disp'] == undefined || $scope.alphaNumeric[i]['disp'] == 0) {
												// A1 pones Tasa (tipo de interes del periodo)
												// en B1 el nPer  (número de Periodos)
												// en C1 el Va  (Capital inicial)
												// (A1*(1+A1)^B1)*C1/(((1+A1)^B1)-1)
												//(0.01 * (1+0.1)^84*191,520.00/(((1+A1)^84)-1)

												// var mesesAlv=posPay - $scope.alphaNumeric.length;
												// console.log("Total II: " + $scope.total2);

												if (posicionPago < $scope.infoLote.msn) {
													// $scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo'] = $scope.total2;
													// console.log($scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo']);
													var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
													parte1 = parte1;

													var parte2 = (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);
													parte2 = parte2;
													// console.log($scope.infoLote.msn + " - " + posicionPago);

													// console.log($scope.alphaNumeric[posPay]['control']);

													$scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo'] = $scope.infoLote.precioTotal;

													operacionCompleta = (($scope.infoLote.interes_p2 * parte1 * $scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo']) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
													// console.log(parte2 + " - " + $scope.alphaNumeric[($scope.infoLote.msn-1)]['saldo']);
												} else //if(posicionPago>=$scope.infoLote.msn)
												{
													var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago']);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
													parte1 = parte1;

													var parte2 = (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago']) - 1);
													parte2 = parte2;
													// console.log(0);
													// console.log(posPay + " - " + posicionPago);
													operacionCompleta = (($scope.infoLote.interes_p2 * parte1 * $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2)) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
													// console.log(parte2 + " - " + $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2));
												}
												// var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses  - $scope.alphaNumeric[posPay]['pago']);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
												// parte1 = parte1;
												//
												// var parte2 = ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses  - $scope.alphaNumeric[posPay]['pago'])-1);
												// parte2 = parte2;
												$scope.interes_plan2 = $scope.alphaNumeric[(i - 1)]['saldo'] * ($scope.infoLote.interes_p2);
												// operacionCompleta = (($scope.infoLote.interes_p2*parte1*$scope.alphaNumeric[(posPay)]['saldo'].toFixed(2))/parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
												// console.log(parte2 + " - " + $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2));
												capital = operacionCompleta - $scope.interes_plan2;//($scope.capital2 =	 ($scope.p2 - $scope.interes_plan2))
												// console.log("interes: " + $scope.interes_plan2);
												newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i)]['saldo'] = $scope.total2 - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												total = operacionCompleta;//$scope.p2
												interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												// console.log("poscicion " + (i-1) + ": ");
												// console.log($scope.alphaNumeric[(i-1)]['saldo']);
												// console.log(i + " - " + $scope.alphaNumeric[(i - 1)]['saldo']);
												// console.log(parte2 + " - " + $scope.alphaNumeric[($scope.infoLote.msn-1)]['saldo']);


												// console.log($scope.alphaNumeric[i]['pago']);
												// capital = $scope.capital2 ;
												// newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i - 1)]['saldo'] - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												// dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												// pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												// interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												// total = $scope.p2;
												// console.log($scope.alphaNumeric[i]['pago']);
												// console.log("saldo: " +( $scope.alphaNumeric[i]['saldo'] - $scope.alphaNumeric[i]['pagoCapital']) );
											} else {
												// console.log($scope.alphaNumeric[i]['pago']);
												// console.log($scope.alphaNumeric[i]['saldo']);
												capital = $scope.capital2;
												newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i - 1)]['saldo'] - $scope.alphaNumeric[i]['pagoCapital'] - $scope.capital2;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												total = $scope.p2;//$scope.p2
											}
											// console.log($scope.total2);
										}
									} else {
										if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago) {
											if ($scope.alphaNumeric[posicionPago]['disp'] == 1) {
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
												saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'];
											} else {//se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
											}
										} else {
											//cuando se salta un espacio en la tabla
											saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
											total = 999999999999999;
										}
									}
								}
								// console.log("p2: " + $scope.p2);
								range2.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": capital,
									"interes": interes,
									"total": total,
									"saldo": newSaldoTable,//newSaldoTable
									"pagoCapital": pagoACapitalCantidad,
									"disp": dispPC,
								});
							} else {
								range2.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.alphaNumeric[i]['capital'],
									"interes": $scope.alphaNumeric[i]['interes'],
									"total": $scope.alphaNumeric[i]['total'],
									"saldo": $scope.alphaNumeric[i]['saldo'],//newSaldoTable
									"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
									"disp": $scope.alphaNumeric[i]['disp'],
								});
							}
							//
							// range2.push({
							// 	"fecha": $scope.dateCf,
							// 	"pago": i + 1,
							// 	"capital": ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
							// 	"interes": ($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
							// 	"total": $scope.p2,
							// 	"saldo":  ($scope.total2 = ($scope.total2 -$scope.capital2)),//newSaldoTable
							// 	"pagoCapital": 0,
							// 	"disp": dispPC,
							// });
							// window['pagoCapChange' + numfinalCount]=Function("","console.log('pagoCapChange"+numfinalCount+" el parametro es: " + document.getElementById('#idModel'+numfinalCount) + "');");//angular.element(document.querySelector('#idModel'+numfinalCount))

							mes++;
							if (i == ($scope.infoLote.meses - 1)) {
								$scope.totalSegundoPlan = total;
							}
							$scope.finalMesesp2 = (range2.length);
						}
						// range2.push({
						// 	"fecha" : $scope.dateCf,
						// 	"pago" : i + 1,
						// 	"capital" : 88888,
						// 	"interes" : 99999,
						// 	"total" :33333,
						// 	"saldo" : 55555,//newSaldoTable
						// 	"pagoCapital": 0,
						// 	"disp": 6666,
						// });
						$scope.range2 = range2;
						// console.log(range2);

						// $scope.alphaNumeric = $scope.rangEd.concat($scope.range);
						// $scope.alphaNumeric = $scope.dani.concat($scope.range2);
						// $scope.alphaNumeric = $scope.range.concat($scope.range2);


						$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
						$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2);
						// console.log($scope.alphaNumeric);
						$scope.dtoptions = DTOptionsBuilder;
						$scope.dtColumns = [
							DTColumnBuilder.newColumn('fecha').withTitle('Fechas'),
							DTColumnBuilder.newColumn('pago').withTitle('Pago #'),
							DTColumnBuilder.newColumn('capital').withTitle('Capital').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('interes').withTitle('Intereses').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('total').withTitle('Total').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('saldo').withTitle('Saldo').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('pagoCapital').withTitle('Pago a Capital')
								.renderWith(
									function (data, type, full, meta) {
										// console.log($scope.alphaNumeric[full['pago']-1]['saldo']);
										if ($scope.alphaNumeric[full['pago'] - 1]['saldo'] <= 0) {
											$scope.alphaNumeric[full['pago'] - 1]['saldo'] = 0;
										}
										if ($scope.alphaNumeric[posicionPago - 1]['disp'] == 1 && $scope.alphaNumeric[posicionPago - 1]['pagoCapital'] != "" && full['pagoCapital'] != "")//
										{
											// console.log($scope.alphaNumeric[posicionPago-1]['pago']   +" "+	posicionPago);
											// console.log('Estoy llegando aquí');
											// return "$ " + saldo;
											var inputCapital = '<input name="capVal' + full["pago"] + '" type="number" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control" value="' + $scope.alphaNumeric[full['pago'] - 1]['pagoCapital'] + '" disabled>';
											var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
											return inputCapital + numberPay;
										} else {
											var inputCapital = '<input name="capVal' + full["pago"] + '" type="text" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control">';
											var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
											return inputCapital + numberPay;
										}
										// console.log($scope.alphaNumeric[posicionPago-1]['disp']	+	" "	+	$scope.alphaNumeric[posicionPago-1]['pagoCapital']);
									},
								),
						];

						$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
								{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
								{
									extend: 'print',
									text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
									titleAttr: 'Imprimir'
								},
								{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
								{
									extend: 'pdfHtml5',
									text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
									titleAttr: 'PDF',
									title: '',
									customize: function (doc) {
										//pageMargins [left, top, right, bottom]
										doc.pageMargins = [140, 40, 10, 50];
										doc.alignment = 'center';
									}
								},
							]
						).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
					}
					if ($scope.infoLote.mesesSinInteresP1 == 0)
					{
						$scope.infoLote.mesesSinInteresP1 = ($scope.mesesdiferir > 0) ? ($scope.infoLote.mesesSinInteresP1 + $scope.mesesdiferir) : ($scope.infoLote.mesesSinInteresP1);


						// $scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.infoLote.precioTotal)
						// 	/ ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);

						$scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.infoLote.precioTotal) / (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);
						var range2 = [];
						for (var i = ini; i < $scope.infoLote.meses; i++) {

							if (mes == 13) {
								mes = '01';
								yearc++;
							}
							if (mes == 2) {
								mes = '02';
							}
							if (mes == 3) {
								mes = '03';
							}
							if (mes == 4) {
								mes = '04';
							}
							if (mes == 5) {
								mes = '05';
							}
							if (mes == 6) {
								mes = '06';
							}
							if (mes == 7) {
								mes = '07';
							}
							if (mes == 8) {
								mes = '08';
							}
							if (mes == 9) {
								mes = '09';
							}
							if (mes == 10) {
								mes = '10';
							}
							if (mes == 11) {
								mes = '11';
							}
							if (mes == 12) {
								mes = '12';
							}


							$scope.dateCf = day + '-' + mes + '-' + yearc;

							//nuevo codigo 2 marzo 20
							if (i == 0) {
								$scope.fechaPM = $scope.fechapago;
							}
							var interes = 0;
							var total = 0;
							var capital = 0;
							var newSaldoTable = 0;
							var alphaOriginal = [];
							alphaOriginal = $scope.alphaNumeric;

							if ($scope.alphaNumeric[i]['disp'] != 1) {
								var vuelta = (i + 1);
								var posicionPago = (posPay + 1);
								if (vuelta == posicionPago) {
									if (posicionPago == 1) {
										console.log('primera posicion');
									} else {
										// console.log('Segunda posicion: ' + $scope.alphaNumeric[posPay]['saldo'] + 'pagocap: ' + saldo);
										capital = $scope.alphaNumeric[posPay]['capital'];
										newSaldoTable = $scope.total2 = $scope.alphaNumeric[posPay]['saldo'];//= nuevoSaldo;//saldo es el pago a capital (facepalm)
										dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
										pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
										interes = $scope.alphaNumeric[posPay]['interes'];//$scope.alphaNumeric[posPay]['saldo'] * $scope.infoLote.interes_p2
										total = $scope.alphaNumeric[posPay]['total'];//capital + interes
									}
								} else {
									// console.log('el total hasta este punto es de: ' + $scope.total2);
									if ($scope.alphaNumeric[posicionPago]['pagoCapital'] == 0) {
										// capital = $scope.alphaNumeric[i]['capital']=99999999999999;
										// newSaldoTable = $scope.alphaNumeric[i]['saldo'];//saldo es el pago a capital (facepalm)
										// dispPC = $scope.alphaNumeric[i]['disp'] = 0;
										// pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
										if (i < posicionPago) {
											capital = $scope.alphaNumeric[i]['capital'];
											newSaldoTable = $scope.alphaNumeric[i]['saldo'];//saldo es el pago a capital (facepalm)
											dispPC = $scope.alphaNumeric[i]['disp'] = 0;
											pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
											interes = $scope.alphaNumeric[i]['interes'];
											total = $scope.alphaNumeric[i]['total'];
										} else {

											$scope.interes_plan2 = $scope.alphaNumeric[(i - 1)]['saldo'] * ($scope.infoLote.interes_p2);//$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
											$scope.capital2 = (($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.alphaNumeric[i]['saldo'])
												/ (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1) - $scope.interes_plan2);
											// $scope.capital2 = ((($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1)) - $scope.interes_plan2);

											// capital = $scope.capital2 ;
											// newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i - 1)]['saldo'] - $scope.alphaNumeric[i]['pagoCapital'] - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
											// dispPC = $scope.alphaNumeric[i]['disp'] = 0;
											// pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
											// interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
											// total = $scope.p2 ;//$scope.p2


											// $scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.alphaNumeric[i]['saldo'] ) / (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);
											if ($scope.alphaNumeric[i]['disp'] == undefined || $scope.alphaNumeric[i]['disp'] == 0) {

												//version anterior 09MARZO20
												// var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1);
												// parte1 = parte1.toFixed(2);
												// var parte2 = ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
												// parte2 = parte2.toFixed(2);
												// var operacionCompleta = (($scope.infoLote.interes_p2*($scope.alphaNumeric[posPay]['saldo'] * parte1))/parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
												// capital = operacionCompleta - $scope.interes_plan2;//($scope.capital2 = ($scope.p2 - $scope.interes_plan2))
												// console.log("interes: " + $scope.interes_plan2);
												// newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i)]['saldo'] = $scope.total2 - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												// dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												// pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												// total = operacionCompleta;//$scope.p2
												// interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2

												//version nueva 09marzo20 más
												var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago']);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
												parte1 = parte1;

												var parte2 = (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago']) - 1);
												parte2 = parte2;
												// console.log(0);
												// console.log(posPay + " - " + posicionPago);
												operacionCompleta = (($scope.infoLote.interes_p2 * parte1 * $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2)) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
												// console.log(parte2 + " - " + $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2));
												capital = operacionCompleta - $scope.interes_plan2;//($scope.capital2 = ($scope.p2 - $scope.interes_plan2))
												// console.log("interes: " + $scope.interes_plan2);
												newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i)]['saldo'] = $scope.total2 - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												total = operacionCompleta;//$scope.p2
												interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2


												// console.log($scope.alphaNumeric[i]['pago']);
												// capital = $scope.capital2 ;
												// newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i - 1)]['saldo'] - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												// dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												// pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												// interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												// total = $scope.p2;
												// console.log($scope.alphaNumeric[i]['pago']);
												// console.log("saldo: " +( $scope.alphaNumeric[i]['saldo'] - $scope.alphaNumeric[i]['pagoCapital']) );
											} else {
												// console.log($scope.alphaNumeric[i]['pago']);
												// console.log($scope.alphaNumeric[i]['saldo']);
												capital = $scope.capital2;
												newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i - 1)]['saldo'] - $scope.alphaNumeric[i]['pagoCapital'] - $scope.capital2;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												total = $scope.p2;//$scope.p2
											}
											// console.log($scope.total2);
										}
									} else {
										if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago) {
											if ($scope.alphaNumeric[posicionPago]['disp'] == 1) {
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
												saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'];
											} else {//se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
											}
										} else {
											//cuando se salta un espacio en la tabla
											saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
											total = 999999999999999;
										}
									}
								}
								// console.log("p2: " + $scope.p2);
								range2.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": capital,
									"interes": interes,
									"total": total,
									"saldo": newSaldoTable,//newSaldoTable
									"pagoCapital": pagoACapitalCantidad,
									"disp": dispPC,
								});
							} else {
								range2.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.alphaNumeric[i]['capital'],
									"interes": $scope.alphaNumeric[i]['interes'],
									"total": $scope.alphaNumeric[i]['total'],
									"saldo": $scope.alphaNumeric[i]['saldo'],//newSaldoTable
									"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
									"disp": $scope.alphaNumeric[i]['disp'],
								});
							}
							//finaliza nuevo código 2 marzo 20


							//codigo anterior a 2 marzo 20
							// $scope.interes_plan2 = $scope.infoLote.precioTotal * ($scope.infoLote.interes_p2);
							// $scope.capital2 = ($scope.p2 - $scope.interes_plan2);
							// range2.push({
							//
							// 	"fecha" : $scope.dateCf,
							// 	"pago" : i + 1,
							// 	"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
							// 	"interes" : ($scope.interes_plan2= ($scope.infoLote.precioTotal * $scope.infoLote.interes_p2)),
							// 	"total" : $scope.p2,
							// 	"saldo" : ($scope.infoLote.precioTotal = ($scope.infoLote.precioTotal -$scope.capital2)),
							// 	"pagoCapital"	:	"",
							// });


							mes++;

							if (i == ($scope.infoLote.meses - 1)) {
								$scope.totalSegundoPlan = total;
							}
							$scope.finalMesesp2 = (range2.length);
						}
						$scope.range2 = range2;
						/*pasar parametros de lectura intereses de poscion*/
						$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
						$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range2);
						// $scope.alphaNumeric = $scope.range2;


						$scope.dtoptions = DTOptionsBuilder;
						$scope.dtColumns = [
							DTColumnBuilder.newColumn('fecha').withTitle('Fechas'),
							DTColumnBuilder.newColumn('pago').withTitle('Pago #'),
							DTColumnBuilder.newColumn('capital').withTitle('Capital').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('interes').withTitle('Intereses').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('total').withTitle('Total').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('saldo').withTitle('Saldo').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('pagoCapital').withTitle('Pago a Capital')
								.renderWith(
									function (data, type, full, meta) {
										// console.log($scope.alphaNumeric[full['pago']-1]['saldo']);
										if ($scope.alphaNumeric[full['pago'] - 1]['saldo'] <= 0) {
											$scope.alphaNumeric[full['pago'] - 1]['saldo'] = 0;
										}
										if ($scope.alphaNumeric[posicionPago - 1]['disp'] == 1 && $scope.alphaNumeric[posicionPago - 1]['pagoCapital'] != "" && full['pagoCapital'] != "")//
										{
											// console.log($scope.alphaNumeric[posicionPago-1]['pago']   +" "+	posicionPago);
											// console.log('Estoy llegando aquí');
											// return "$ " + saldo;
											var inputCapital = '<input name="capVal' + full["pago"] + '" type="number" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control" value="' + $scope.alphaNumeric[full['pago'] - 1]['pagoCapital'] + '" disabled>';
											var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
											return inputCapital + numberPay;
										} else {
											var inputCapital = '<input name="capVal' + full["pago"] + '" type="text" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control">';
											var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
											return inputCapital + numberPay;
										}
										// console.log($scope.alphaNumeric[posicionPago-1]['disp']	+	" "	+	$scope.alphaNumeric[posicionPago-1]['pagoCapital']);
									},
								),
						];

						$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
								{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
								{
									extend: 'print',
									text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
									titleAttr: 'Imprimir'
								},
								{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
								{
									extend: 'pdfHtml5',
									text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
									titleAttr: 'PDF',
									title: '',
									customize: function (doc) {
										//pageMargins [left, top, right, bottom]
										doc.pageMargins = [140, 40, 10, 50];
										doc.alignment = 'center';
									}
								},
							]
						).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});


					}
					if ($scope.infoLote.mesesSinInteresP1 == 36)
					{
						for (var i = ini; i <= $scope.infoLote.mesesSinInteresP1 - 1; i++) {
							if (mes == 13) {
								mes = '01';
								yearc++;
							}
							if (mes == 2) {
								mes = '02';
							}
							if (mes == 3) {
								mes = '03';
							}
							if (mes == 4) {
								mes = '04';
							}
							if (mes == 5) {
								mes = '05';
							}
							if (mes == 6) {
								mes = '06';
							}
							if (mes == 7) {
								mes = '07';
							}
							if (mes == 8) {
								mes = '08';
							}
							if (mes == 9) {
								mes = '09';
							}
							if (mes == 10) {
								mes = '10';
							}
							if (mes == 11) {
								mes = '11';
							}
							if (mes == 12) {
								mes = '12';
							}
							$scope.dateCf = day + '-' + mes + '-' + yearc;

							if (i == 0) {
								$scope.fechaPM = $scope.dateCf;
							}
							var newSaldoTable = 0;
							var alphaOriginal = [];
							alphaOriginal = $scope.alphaNumeric;
							if ($scope.alphaNumeric[i]['disp'] != 1) {
								/*Para verfificar donde se puso el pago a capital*/
								var dispPC = 0;
								var vuelta = (i + 1);
								var posicionPago = (posPay + 1);
								if (vuelta == posicionPago) {
									// console.log("se tiene que poner esto " + saldo + " en la posición: " + (posPay + 1));
									if (posicionPago == 1) {
										/* Este if es para ver si se descuenta la primera posicion*/
										newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
										dispPC = 1;
										pagoACapitalCantidad = saldo;
										// console.log('se desceunta de la primera posicion');
									} else {/* Este else es para ver si se descuenta apartir de la segunda posicion*/
										// alert('olv');
										newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
										dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
										pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
										// console.log('se descuente de la posicion ' + i);
									}
								} else {
									if ($scope.alphaNumeric[posicionPago]['pagoCapital'] == 0) {
										/*Hace el calculo cuando es 0apartir de la segunda posición*/
										if ($scope.alphaNumeric[posicionPago]['disp'] == 0) {
											//else despues del primer post en segunda posicion
											if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
												capital = $scope.alphaNumeric[i]['capital'] = ($scope.mesesdiferir > 0) ? ($scope.alphaNumeric[posPay]['saldo'] / (((($scope.age_plan * 12) - $scope.alphaNumeric[posPay]['pago'])) - $scope.mesesdiferir)) : ($scope.alphaNumeric[posPay]['saldo'] / ((($scope.age_plan * 12) - $scope.alphaNumeric[posPay]['pago'])));
												// $scope.infoLote.precioTotal = $scope.alphaNumeric[(i - 1)]['saldo'] - capital
												newSaldoTable = $scope.alphaNumeric[i]['saldo'] = $scope.alphaNumeric[(i - 1)]['saldo'] - capital;// - ($scope.mesesdiferir > 0) ? ($scope.alphaNumeric[posPay]['saldo']/ (((($scope.age_plan*12)-$scope.alphaNumeric[posPay]['pago'])) - $scope.mesesdiferir)) : ($scope.alphaNumeric[posPay]['saldo'] / ((($scope.age_plan*12)-$scope.alphaNumeric[posPay]['pago'])))
												dispPC = 0;
												pagoACapitalCantidad = 0;
												// console.log("Faltan: " + (($scope.age_plan * 12) - $scope.alphaNumeric[i]['pago']));
											} else// if ($scope.alphaNumeric[i]['pago'] <= posicionPago)
											{
												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
												dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
												pagoACapitalCantidad = 0;
												capital = $scope.alphaNumeric[i]['capital'];
											}
										}
										// else
										// {
										// 	//else despues del primer post
										// 	console.log('posicion de pago ene ste punto :' + posicionPago);
										// 	if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
										// 		capital = ($scope.mesesdiferir > 0) ? ($scope.alphaNumeric[posPay]['saldo'] / (((($scope.age_plan * 12) - $scope.alphaNumeric[posPay]['pago'])) - $scope.mesesdiferir)) : ($scope.alphaNumeric[posPay]['saldo'] / ((($scope.age_plan * 12) - $scope.alphaNumeric[posPay]['pago'])));
										// 		newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[(i - 1)]['saldo'] - capital;// - ($scope.mesesdiferir > 0) ? ($scope.alphaNumeric[posPay]['saldo']/ (((($scope.age_plan*12)-$scope.alphaNumeric[posPay]['pago'])) - $scope.mesesdiferir)) : ($scope.alphaNumeric[posPay]['saldo'] / ((($scope.age_plan*12)-$scope.alphaNumeric[posPay]['pago'])))
										// 		dispPC = 0;
										// 		pagoACapitalCantidad = 0;
										// 		console.log("Faltan: " + (($scope.age_plan * 12) - $scope.alphaNumeric[i]['pago']));
										// 	} else if ($scope.alphaNumeric[i]['pago'] <= posicionPago) {
										// 		newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
										// 		dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
										// 		pagoACapitalCantidad = 0;
										// 		capital = $scope.alphaNumeric[i]['capital'];
										// 	}
										// }
									}
								}
								range.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": capital,
									"interes": 0,
									"total": capital,
									"saldo": newSaldoTable,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
									"pagoCapital": pagoACapitalCantidad,
									"disp": dispPC,
								});
							} else {
								/*Se coloca el valor anterior de donde se modificó, con el valor que trae por defecto en el areglo*/
								range.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.alphaNumeric[i]['capital'],
									"interes": 0,
									"total": $scope.alphaNumeric[i]['total'],
									"saldo": $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
									"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
									"disp": $scope.alphaNumeric[i]['disp'],
								});
							}
							/*finaliza funcion*/
							mes++;
							if (i == ($scope.infoLote.mesesSinInteresP1 - 1)) {
								$scope.total2 = $scope.infoLote.precioTotal;
								// alert($scope.total2);
								$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;
							}
							$scope.finalMesesp1 = range.length;
							ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
						}
						// console.log($scope.alphaNumeric);
						$scope.range = range;

						$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
						$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range);
						// $scope.alphaNumeric = $scope.range2;


						$scope.dtoptions = DTOptionsBuilder;
						$scope.dtColumns = [
							DTColumnBuilder.newColumn('fecha').withTitle('Fechas'),
							DTColumnBuilder.newColumn('pago').withTitle('Pago #'),
							DTColumnBuilder.newColumn('capital').withTitle('Capital').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('interes').withTitle('Intereses').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('total').withTitle('Total').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('saldo').withTitle('Saldo').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('pagoCapital').withTitle('Pago a Capital')
								.renderWith(
									function (data, type, full, meta) {
										// console.log($scope.alphaNumeric[full['pago']-1]['saldo']);
										if ($scope.alphaNumeric[full['pago'] - 1]['saldo'] <= 0) {
											$scope.alphaNumeric[full['pago'] - 1]['saldo'] = 0;
										}
										if ($scope.alphaNumeric[posicionPago - 1]['disp'] == 1 && $scope.alphaNumeric[posicionPago - 1]['pagoCapital'] != "" && full['pagoCapital'] != "")//
										{
											// console.log($scope.alphaNumeric[posicionPago-1]['pago']   +" "+	posicionPago);
											// console.log('Estoy llegando aquí');
											// return "$ " + saldo;
											var inputCapital = '<input name="capVal' + full["pago"] + '" type="text" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control" value="' + $scope.alphaNumeric[full['pago'] - 1]['pagoCapital'] + '" disabled>';
											var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
											return inputCapital + numberPay;
										} else {
											var inputCapital = '<input name="capVal' + full["pago"] + '" type="text" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control">';
											var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
											return inputCapital + numberPay;
										}
										// console.log($scope.alphaNumeric[posicionPago-1]['disp']	+	" "	+	$scope.alphaNumeric[posicionPago-1]['pagoCapital']);
									},
								),
						];

						$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
								{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
								{
									extend: 'print',
									text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
									titleAttr: 'Imprimir'
								},
								{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
								{
									extend: 'pdfHtml5',
									text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
									titleAttr: 'PDF',
									title: '',
									customize: function (doc) {
										//pageMargins [left, top, right, bottom]
										doc.pageMargins = [140, 40, 10, 50];
										doc.alignment = 'center';
									}
								},
							]
						).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
					}
				}

				/////////////////// TABLES X 4 A 10 AÑOS //////////////
				if ($scope.infoLote.meses >= 48 && $scope.infoLote.meses <= 120)
				{
					// console.log('4mss alv prro');
					var range = [];
					ini = ($scope.mesesdiferir >= 0) ? $scope.mesesdiferir : $scope.infoLote.contadorInicial;
					if ($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <= 35   && $scope.noPagomensualidad == 1)
					{
						ini = $scope.infoLote.contadorInicial;
						if ($scope.noPagomensualidad == 1)
						{
							////////////////////////////////////////////////////////////////////////////////////
							var rangePlanc = [];
							for (var i = ini; i < 12; i++)
							{
								if ((mes == 13) || (mes == 14)) {
									if ($scope.descDate == 0) {
										if (mes == 13) {
											mes = '01';
											yearc++;
										} else if (mes == 14) {
											mes = '02';
											yearc++;
										}
									} else if ($scope.descDate == 1) {
										mes = '03';
										$scope.descDate = 0;
									}
								}
								if (mes == 2) {
									mes = '02';
								}
								if (mes == 3) {
									mes = '03';
								}
								if (mes == 4) {
									mes = '04';
								}
								if (mes == 5) {
									mes = '05';
								}
								if (mes == 6) {
									mes = '06';
								}
								if (mes == 7) {
									mes = '07';
								}
								if (mes == 8) {
									mes = '08';
								}
								if (mes == 9) {
									mes = '09';
								}
								if (mes == 10) {
									mes = '10';
								}
								if (mes == 11) {
									mes = '11';
								}
								if (mes == 12) {
									mes = '12';
								}

								$scope.dateCf = day + '-' + mes + '-' + yearc;

								if (i == 0) {
									$scope.fechaPM = $scope.dateCf;
								}
								var newSaldoTable = 0;
								var alphaOriginal = [];
								alphaOriginal = $scope.alphaNumeric;
								if ($scope.alphaNumeric[i]['disp'] != 1)
								{
									/*Para verfificar donde se puso el pago a capital*/
									var dispPC = 0;
									var vuelta = (i + 1);
									var posicionPago = (posPay + 1);
									if (vuelta == posicionPago)
									{
										if (posicionPago == 1)
										{
											/* Este if es para ver si se descuenta la primera posicion*/
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
											dispPC = 1;
											pagoACapitalCantidad = saldo;
										}
										else
										{/* Este else es para ver si se descuenta apartir de la segunda posicion*/
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
											dispPC = $scope.alphaNumeric[posPay]['dispPC'] = 1;
											pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
										}
									}
									else
									{
										/*Hace el calculo cuando es 0apartir de la segunda posición*/
										if ($scope.alphaNumeric[i]['disp'] == 0 || $scope.alphaNumeric[i]['disp'] == undefined)
										{
											//else despues del primer post en segunda posicion
											if ($scope.alphaNumeric[i]['pago'] >= posicionPago)
											{
												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'] - saldo;
												dispPC = 0;
												pagoACapitalCantidad = 0;
											}
											else if ($scope.alphaNumeric[i]['pago'] <= posicionPago)
											{
												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
												// dispPC = 0;
												dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
												pagoACapitalCantidad = 0;
											}
										}
										else
										{
											//else despues del primer post
											if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
												dispPC = 0;
												pagoACapitalCantidad = 0;

											} else if ($scope.alphaNumeric[i]['pago'] <= posicionPago) {

												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
												dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
												pagoACapitalCantidad = 0;
											}
										}
									}
									rangePlanc.push({
										"fecha": $scope.dateCf,
										"pago": i + 1,
										"capital": 0,
										"interes": 0,
										"total": 0,
										"saldo": newSaldoTable,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
										"pagoCapital": pagoACapitalCantidad,
										"disp": dispPC,
									});
								}
								else
								{
									/*Se coloca el valor anterior de donde se modificó, con el valor que trae por defecto en el areglo*/
									rangePlanc.push({
										"fecha": $scope.dateCf,
										"pago": i + 1,
										"capital": $scope.alphaNumeric[i]['capital'],
										"interes": 0,
										"total": $scope.alphaNumeric[i]['total'],
										"saldo": $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
										"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
										"disp": $scope.alphaNumeric[i]['disp'],
									});
								}
								// rangePlanc.push({
								// 	"fecha": $scope.dateCf,
								// 	"pago": i + 1,
								// 	"capital": 0,
								// 	"interes": 0,
								// 	"total": 0,
								// 	"saldo": $scope.saldoFinal,
								// });
								mes++;
								$scope.finalMesesp1PlanC = rangePlanc.length;
								ini = rangePlanc.length;
							}
							$scope.rangePlanc = rangePlanc;
							////////////////////////////////////////////////////////////////////////////////////


							for (var i = ini; i <= $scope.infoLote.mesesSinInteresP1 - 1; i++)
							{
								if (mes == 13) {
									mes = '01';
									yearc++;
								}
								if (mes == 2) {
									mes = '02';
								}
								if (mes == 3) {
									mes = '03';
								}
								if (mes == 4) {
									mes = '04';
								}
								if (mes == 5) {
									mes = '05';
								}
								if (mes == 6) {
									mes = '06';
								}
								if (mes == 7) {
									mes = '07';
								}
								if (mes == 8) {
									mes = '08';
								}
								if (mes == 9) {
									mes = '09';
								}
								if (mes == 10) {
									mes = '10';
								}
								if (mes == 11) {
									mes = '11';
								}
								if (mes == 12) {
									mes = '12';
								}
								$scope.dateCf = day + '-' + mes + '-' + yearc;

								if (i == 0) {
									$scope.fechaPM = $scope.dateCf;
								}
								var newSaldoTable = 0;
								var alphaOriginal = [];
								alphaOriginal = $scope.alphaNumeric;
								if ($scope.alphaNumeric[i]['disp'] != 1)
								{
									/*Para verfificar donde se puso el pago a capital*/
									var dispPC = 0;
									var vuelta = (i + 1);
									var posicionPago = (posPay + 1);
									if (vuelta == posicionPago) {
										// console.log("se tiene que poner esto " + saldo + " en la posición: " + (posPay + 1));
										if (posicionPago == 1) {
											/* Este if es para ver si se descuenta la primera posicion*/
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
											dispPC = 1;
											pagoACapitalCantidad = saldo;
										} else {/* Este else es para ver si se descuenta apartir de la segunda posicion*/
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
											dispPC = $scope.alphaNumeric[posPay]['dispPC'] = 1;
											pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
											// console.log('se descuente de la posicion ' + i);
										}
									}
									else
									{
										/*Hace el calculo cuando es 0apartir de la segunda posición*/
										if ($scope.alphaNumeric[i]['disp'] == 0 || $scope.alphaNumeric[i]['disp'] == undefined) {
											//else despues del primer post en segunda posicion
											if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'] - saldo;
												dispPC = 0;
												pagoACapitalCantidad = 0;
											} else if ($scope.alphaNumeric[i]['pago'] <= posicionPago) {
												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
												// dispPC = 0;
												dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
												pagoACapitalCantidad = 0;
											}
										} else {
											//else despues del primer post
											if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
												dispPC = 0;
												pagoACapitalCantidad = 0;

											} else if ($scope.alphaNumeric[i]['pago'] <= posicionPago) {

												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
												dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
												pagoACapitalCantidad = 0;
											}
										}
									}
									range.push({
										"fecha": $scope.dateCf,
										"pago": i + 1,
										"capital": $scope.infoLote.capital,
										"interes": 0,
										"total": $scope.infoLote.capital + $scope.infoLote.interes_p1,
										"saldo": newSaldoTable,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
										"pagoCapital": pagoACapitalCantidad,
										"disp": dispPC,
									});
								}
								else
								{
									/*Se coloca el valor anterior de donde se modificó, con el valor que trae por defecto en el areglo*/
									range.push({
										"fecha": $scope.dateCf,
										"pago": i + 1,
										"capital": $scope.alphaNumeric[i]['capital'],
										"interes": 0,
										"total": $scope.alphaNumeric[i]['total'],
										"saldo": $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
										"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
										"disp": $scope.alphaNumeric[i]['disp'],
									});
								}
								/*finaliza funcion*/
								mes++;
								if (i == ($scope.infoLote.mesesSinInteresP1 - 1)) {
									$scope.total2 = $scope.infoLote.precioTotal;
									// alert($scope.total2);
									$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;
								}
								$scope.finalMesesp1 = range.length;
								ini2 = (range.length + rangePlanc.length);
							}
							// $scope.finalMesesp1 = range.length;
							// ini2 = (range.length + rangePlanc.length);
							// }
							$scope.range = range;
							//////////
							// $scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses + 12) - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / (Math.pow(1 + $scope.infoLote.interes_p2, ($scope.infoLote.meses + 12) - $scope.infoLote.mesesSinInteresP1) - 1);
							var range2 = [];
							// console.log("xd: " + $scope.infoLote.precioTotal);
							// for (var i = ini2; i < ($scope.infoLote.meses + 12); i++)
							for (var i = ini2; i < ($scope.infoLote.meses + 12); i++)
							{
								if (mes == 13) {
									mes = '01';
									yearc++;
								}
								if (mes == 2) {
									mes = '02';
								}
								if (mes == 3) {
									mes = '03';
								}
								if (mes == 4) {
									mes = '04';
								}
								if (mes == 5) {
									mes = '05';
								}
								if (mes == 6) {
									mes = '06';
								}
								if (mes == 7) {
									mes = '07';
								}
								if (mes == 8) {
									mes = '08';
								}
								if (mes == 9) {
									mes = '09';
								}
								if (mes == 10) {
									mes = '10';
								}
								if (mes == 11) {
									mes = '11';
								}
								if (mes == 12) {
									mes = '12';
								}
								$scope.dateCf = day + '-' + mes + '-' + yearc;
								if (i == 0) {
									$scope.fechaPM = $scope.fechapago;
								}
								//nuevo codigo 21 FEB
								var interes = 0;
								var total = 0;
								var capital = 0;
								var newSaldoTable = 0;

								var alphaOriginal = [];
								alphaOriginal = $scope.alphaNumeric;

								if ($scope.alphaNumeric[i]['disp'] != 1)
								{
									var vuelta = (i + 1);
									var posicionPago = (posPay + 1);
									if (vuelta == posicionPago) {
										if (posicionPago == 1) {
											// console.log('primera posicion');
										}
										else
										{
											// console.log('Segunda posicion: ' + $scope.alphaNumeric[posPay]['saldo'] + 'pagocap: ' + saldo);
											capital = $scope.alphaNumeric[posPay]['capital'];
											newSaldoTable = $scope.total2 = $scope.alphaNumeric[posPay]['saldo'];//= nuevoSaldo;//saldo es el pago a capital (facepalm)
											dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
											pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
											interes = $scope.alphaNumeric[posPay]['interes'];//$scope.alphaNumeric[posPay]['saldo'] * $scope.infoLote.interes_p2
											total = $scope.alphaNumeric[posPay]['total'];//capital + interes
											$scope.alphaNumeric[posPay]['control'] = 1;
										}
									}
									else
									{
										if ($scope.alphaNumeric[posicionPago]['pagoCapital'] == 0 || $scope.alphaNumeric[posicionPago]['pagoCapital']==undefined)
										{
											if (i < posicionPago)
											{
												capital = $scope.alphaNumeric[i]['capital'];
												newSaldoTable = $scope.alphaNumeric[i]['saldo'];//saldo es el pago a capital (facepalm)
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												interes = $scope.alphaNumeric[i]['interes'];
												total = $scope.alphaNumeric[i]['total'];
											}
											else
											{
												if ($scope.alphaNumeric[i]['disp'] == undefined || $scope.alphaNumeric[i]['disp'] == 0)
												{
													if (posicionPago < ($scope.infoLote.msn))
													{
														var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 + 12);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
														parte1 = parte1;
														var parte2 = (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 + 12 ) - 1);
														parte2 = parte2;
														$scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo'] = $scope.infoLote.precioTotal;
														operacionCompleta = (($scope.infoLote.interes_p2 * parte1 * $scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo']) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
													}
													else //if(posicionPago>=$scope.infoLote.msn)
													{
														var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago'] + 12);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
														parte1 = parte1;

														var parte2 = (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago'] + 12) - 1);
														parte2 = parte2;
														operacionCompleta = (($scope.infoLote.interes_p2 * parte1 * $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2)) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
													}
													$scope.interes_plan2 = $scope.alphaNumeric[(i - 1)]['saldo'] * ($scope.infoLote.interes_p2);
													capital = operacionCompleta - $scope.interes_plan2;//($scope.capital2 =	 ($scope.p2 - $scope.interes_plan2))
													// console.log("interes: " + $scope.interes_plan2);
													newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i)]['saldo'] = $scope.total2 - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
													dispPC = $scope.alphaNumeric[i]['disp'] = 0;
													pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
													total = operacionCompleta;//$scope.p2
													interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												}
												else
												{
													capital = $scope.capital2;
													newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i - 1)]['saldo'] - $scope.alphaNumeric[i]['pagoCapital'] - $scope.capital2;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
													dispPC = $scope.alphaNumeric[i]['disp'] = 0;
													pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
													interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
													total = $scope.p2;//$scope.p2
												}
											}
										}
										else
										{
											if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago) {
												if ($scope.alphaNumeric[posicionPago]['disp'] == 1) {
													dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
													saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
													pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'];
												} else {//se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion
													dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
												}
											} else {
												//cuando se salta un espacio en la tabla
												saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
												total = 999999999999999;
											}
										}
									}
									range2.push({
										"fecha": $scope.dateCf,
										"pago": i + 1,
										"capital": capital,
										"interes": interes,
										"total": total,
										"saldo": newSaldoTable,//newSaldoTable
										"pagoCapital": pagoACapitalCantidad,
										"disp": dispPC,
									});
								}
								else
								{
									range2.push({
										"fecha": $scope.dateCf,
										"pago": i + 1,
										"capital": $scope.alphaNumeric[i]['capital'],
										"interes": $scope.alphaNumeric[i]['interes'],
										"total": $scope.alphaNumeric[i]['total'],
										"saldo": $scope.alphaNumeric[i]['saldo'],//newSaldoTable
										"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
										"disp": $scope.alphaNumeric[i]['disp'],
									});
								}
								mes++;
								if (i == ($scope.infoLote.meses - 1)) {
									$scope.totalSegundoPlan = total;
								}
								$scope.finalMesesp2 = (range2.length);
							}
							$scope.range2 = range2;


							$scope.alphaNumeric = $scope.rangePlanc.concat($scope.range).concat($scope.range2);
							$scope.dtoptions = DTOptionsBuilder;
							$scope.dtColumns = [
								DTColumnBuilder.newColumn('fecha').withTitle('Fechas'),
								DTColumnBuilder.newColumn('pago').withTitle('Pago #'),
								DTColumnBuilder.newColumn('capital').withTitle('Capital').renderWith(function (data, type, full) {
									return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
								}),
								DTColumnBuilder.newColumn('interes').withTitle('Intereses').renderWith(function (data, type, full) {
									return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
								}),
								DTColumnBuilder.newColumn('total').withTitle('Total').renderWith(function (data, type, full) {
									return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
								}),
								DTColumnBuilder.newColumn('saldo').withTitle('Saldo').renderWith(function (data, type, full) {
									return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
								}),
								DTColumnBuilder.newColumn('pagoCapital').withTitle('Pago a Capital')
									.renderWith(
										function (data, type, full, meta) {
											// console.log($scope.alphaNumeric[full['pago']-1]['saldo']);
											if ($scope.alphaNumeric[full['pago'] - 1]['saldo'] <= 0) {
												$scope.alphaNumeric[full['pago'] - 1]['saldo'] = 0;
											}
											if ($scope.alphaNumeric[posicionPago - 1]['disp'] == 1 && $scope.alphaNumeric[posicionPago - 1]['pagoCapital'] != "" && full['pagoCapital'] != "")//
											{
												// console.log($scope.alphaNumeric[posicionPago-1]['pago']   +" "+	posicionPago);
												// console.log('Estoy llegando aquí');
												// return "$ " + saldo;
												var inputCapital = '<input name="capVal' + full["pago"] + '" type="number" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control" value="' + $scope.alphaNumeric[full['pago'] - 1]['pagoCapital'] + '" disabled>';
												var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
												return inputCapital + numberPay;
											} else {
												var inputCapital = '<input name="capVal' + full["pago"] + '" type="text" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control">';
												var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
												return inputCapital + numberPay;
											}
											// console.log($scope.alphaNumeric[posicionPago-1]['disp']	+	" "	+	$scope.alphaNumeric[posicionPago-1]['pagoCapital']);
										},
									),
							];
							$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
									{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
									{
										extend: 'print',
										text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
										titleAttr: 'Imprimir'
									},
									{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
									{
										extend: 'pdfHtml5',
										text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
										titleAttr: 'PDF',
										title: '',
										customize: function (doc) {
											//pageMargins [left, top, right, bottom]
											doc.pageMargins = [140, 40, 10, 50];
											doc.alignment = 'center';

										}
									},
								]
							).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
						}
					}

					if ($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <= 35   && $scope.noPagomensualidad == 0)
					{
						for (var i = ini; i <= $scope.infoLote.mesesSinInteresP1 - 1; i++) {
							if (mes == 13) {
								mes = '01';
								yearc++;
							}
							if (mes == 2) {
								mes = '02';
							}
							if (mes == 3) {
								mes = '03';
							}
							if (mes == 4) {
								mes = '04';
							}
							if (mes == 5) {
								mes = '05';
							}
							if (mes == 6) {
								mes = '06';
							}
							if (mes == 7) {
								mes = '07';
							}
							if (mes == 8) {
								mes = '08';
							}
							if (mes == 9) {
								mes = '09';
							}
							if (mes == 10) {
								mes = '10';
							}
							if (mes == 11) {
								mes = '11';
							}
							if (mes == 12) {
								mes = '12';
							}
							$scope.dateCf = day + '-' + mes + '-' + yearc;

							if (i == 0) {
								$scope.fechaPM = $scope.dateCf;
							}
							var newSaldoTable = 0;
							var alphaOriginal = [];
							alphaOriginal = $scope.alphaNumeric;
							if ($scope.alphaNumeric[i]['disp'] != 1) {
								/*Para verfificar donde se puso el pago a capital*/
								var dispPC = 0;
								var vuelta = (i + 1);
								var posicionPago = (posPay + 1);
								if (vuelta == posicionPago) {
									// console.log("se tiene que poner esto " + saldo + " en la posición: " + (posPay + 1));
									if (posicionPago == 1) {
										/* Este if es para ver si se descuenta la primera posicion*/
										newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
										dispPC = 1;
										pagoACapitalCantidad = saldo;
										// console.log('se desceunta de la primera posicion');
									} else {/* Este else es para ver si se descuenta apartir de la segunda posicion*/
										// alert('olv');
										newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
										dispPC = $scope.alphaNumeric[posPay]['dispPC'] = 1;
										pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
										// console.log('se descuente de la posicion ' + i);
									}
									/*ghdfhfdhdhdfhdh*/
									//anterior a 19 enero20
									// for (var n = 0; n < posicionPago; n++) {
									// 	if ($scope.alphaNumeric[n]['disp'] == 0 || $scope.alphaNumeric[n]['disp'] == "0") {
									// 		if ($scope.alphaNumeric[n]['pago'] < posicionPago) {
									// 			console.log($scope.alphaNumeric[n]['pago']);
									// 			$scope.alphaNumeric[n]['saldo'] = alphaOriginal[n]['saldo'];//alphaOriginal[n]['saldo']
									// 			console.log("este es el saldo " + alphaOriginal[n]['saldo'] + " en " + n)
									// 		}
									// 	}
									// }
									// for (var n = 0; n < posicionPago; n++)
									// {
									// 	if($scope.alphaNumeric[n]['disp']!="")
									// 	{
									// 		newSaldoTable = 99999;
									// 	}
									// }
								} else {
									/*Hace el calculo cuando es 0apartir de la segunda posición*/
									if ($scope.alphaNumeric[i]['disp'] == 0 || $scope.alphaNumeric[i]['disp'] == undefined) {
										//newSaldoTable = $scope.inufoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital;
										// dispPC = 0;
										// pagoACapitalCantidad = 0;
										//else despues del primer post en segunda posicion
										if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'] - saldo;
											dispPC = 0;
											pagoACapitalCantidad = 0;
										} else if ($scope.alphaNumeric[i]['pago'] <= posicionPago) {
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
											// dispPC = 0;
											dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
											pagoACapitalCantidad = 0;
										}
									} else {
										//else despues del primer post
										// console.log($scope.alphaNumeric[i]['disp']);
										// console.log('posicion de pago ene ste punto :' + posicionPago);
										if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
											dispPC = 0;
											pagoACapitalCantidad = 0;

										} else if ($scope.alphaNumeric[i]['pago'] <= posicionPago) {

											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
											dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
											pagoACapitalCantidad = 0;
										}
										// if ($scope.alphaNumeric[posicionPago]['pago'] >= posicionPago || $scope.alphaNumeric[posicionPago]['pago'] <= posicionPago)
										// {
										// 	if ($scope.alphaNumeric[posicionPago]['disp'] == 1)
										// 	{
										// 		/*aqui se coloca cuando se hay pagos abajo del nuevo, ejemplo Pago 5:550 y se quiere colocar uno en el 2*/
										// 		newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posicionPago]['saldo'];
										// 		dispPC = 1;
										// 		pagoACapitalCantidad = $scope.alphaNumeric[posicionPago]['pagoCapital'];
										// 	}
										// 	else
										// 	{/*se coloca un valor cuando nohay nada(el resto de los campos*/
										// 			newSaldoTable = $scope.alphaNumeric[i]['saldo'];
										// 			dispPC = 0;
										// 			pagoACapitalCantidad = 0;
										// 	}
										// }
										// else
										// {
										// 	newSaldoTable = 0;
										// 	dispPC = 0;
										// 	pagoACapitalCantidad = 0;
										// }
									}
								}
								range.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.infoLote.capital,
									"interes": 0,
									"total": $scope.infoLote.capital + $scope.infoLote.interes_p1,
									"saldo": newSaldoTable,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
									"pagoCapital": pagoACapitalCantidad,
									"disp": dispPC,
								});
							} else {
								/*Se coloca el valor anterior de donde se modificó, con el valor que trae por defecto en el areglo*/
								range.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.alphaNumeric[i]['capital'],
									"interes": 0,
									"total": $scope.alphaNumeric[i]['total'],
									"saldo": $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
									"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
									"disp": $scope.alphaNumeric[i]['disp'],
								});
								// range.push({
								//     "fecha": $scope.alphaNumeric[i]['fecha'],
								//     "pago": i + 1,
								//     "capital": $scope.alphaNumeric[i]['capital'],
								//     "interes": 0,
								//     "total": $scope.alphaNumeric[i]['total'],
								//     "saldo": $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
								//     "pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
								//     "disp": $scope.alphaNumeric[i]['disp'],
								// });
							}
							/*finaliza funcion*/
							// range.push({
							//     "fecha" : $scope.dateCf,
							//     "pago" : i + 1,
							//     "capital" : $scope.infoLote.capital,
							//     "interes" : 0,
							//     "total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
							//     "saldo" : newSaldoTable,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
							//     "pagoCapital" : pagoACapitalCantidad,
							//     "disp":dispPC,
							// });
							mes++;
							if (i == ($scope.infoLote.mesesSinInteresP1 - 1)) {
								$scope.total2 = $scope.infoLote.precioTotal;
								// alert($scope.total2);
								$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;
							}
							$scope.finalMesesp1 = range.length;
							ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
						}
						$scope.range = range;

						//////////
						// var range2=[];
						// $scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.alphaNumeric[i]['saldo']) / (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);
						var range2 = [];
						// console.log("Saldo para el segundo arreglo " + $scope.total2);
						for (var i = ini2; i < $scope.infoLote.meses; i++) {
							if (mes == 13) {
								mes = '01';
								yearc++;
							}
							if (mes == 2) {
								mes = '02';
							}
							if (mes == 3) {
								mes = '03';
							}
							if (mes == 4) {
								mes = '04';
							}
							if (mes == 5) {
								mes = '05';
							}
							if (mes == 6) {
								mes = '06';
							}
							if (mes == 7) {
								mes = '07';
							}
							if (mes == 8) {
								mes = '08';
							}
							if (mes == 9) {
								mes = '09';
							}
							if (mes == 10) {
								mes = '10';
							}
							if (mes == 11) {
								mes = '11';
							}
							if (mes == 12) {
								mes = '12';
							}
							$scope.dateCf = day + '-' + mes + '-' + yearc;
							if (i == 0) {
								$scope.fechaPM = $scope.fechapago;
							}
							//nuevo codigo 21 FEB
							var interes = 0;
							var total = 0;
							var capital = 0;
							var newSaldoTable = 0;

							// interes = $scope.interes_plan2=$scope.total2*$scope.infoLote.interes_p2;
							// total = $scope.p2;
							var alphaOriginal = [];
							alphaOriginal = $scope.alphaNumeric;

							if ($scope.alphaNumeric[i]['disp'] != 1) {
								var vuelta = (i + 1);
								var posicionPago = (posPay + 1);
								if (vuelta == posicionPago) {
									if (posicionPago == 1) {
										// console.log('primera posicion');
									} else {
										// console.log('Segunda posicion: ' + $scope.alphaNumeric[posPay]['saldo'] + 'pagocap: ' + saldo);
										capital = $scope.alphaNumeric[posPay]['capital'];
										newSaldoTable = $scope.total2 = $scope.alphaNumeric[posPay]['saldo'];//= nuevoSaldo;//saldo es el pago a capital (facepalm)
										dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
										pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
										interes = $scope.alphaNumeric[posPay]['interes'];//$scope.alphaNumeric[posPay]['saldo'] * $scope.infoLote.interes_p2
										total = $scope.alphaNumeric[posPay]['total'];//capital + interes
										$scope.alphaNumeric[posPay]['control'] = 1;
									}
								} else {
									// console.log('el total hasta este punto es de: ' + $scope.total2);
									if ($scope.alphaNumeric[posicionPago]['pagoCapital'] == 0) {
										// capital = $scope.alphaNumeric[i]['capital']=99999999999999;
										// newSaldoTable = $scope.alphaNumeric[i]['saldo'];//saldo es el pago a capital (facepalm)
										// dispPC = $scope.alphaNumeric[i]['disp'] = 0;
										// pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
										if (i < posicionPago) {
											capital = $scope.alphaNumeric[i]['capital'];
											newSaldoTable = $scope.alphaNumeric[i]['saldo'];//saldo es el pago a capital (facepalm)
											dispPC = $scope.alphaNumeric[i]['disp'] = 0;
											pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
											interes = $scope.alphaNumeric[i]['interes'];
											total = $scope.alphaNumeric[i]['total'];
										} else {

											// $scope.interes_plan2 = $scope.alphaNumeric[(i-1)]['saldo'] * ($scope.infoLote.interes_p2);//$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
											// $scope.capital2 = (($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.alphaNumeric[i]['saldo'])
											//  / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1) - $scope.interes_plan2);

											// $scope.capital2 = ((($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1)) - $scope.interes_plan2);

											// capital = $scope.capital2 ;
											// newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i - 1)]['saldo'] - $scope.alphaNumeric[i]['pagoCapital'] - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
											// dispPC = $scope.alphaNumeric[i]['disp'] = 0;
											// pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
											// interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
											// total = $scope.p2 ;//$scope.p2


											// $scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.alphaNumeric[i]['saldo'] ) / (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);
											if ($scope.alphaNumeric[i]['disp'] == undefined || $scope.alphaNumeric[i]['disp'] == 0) {
												// A1 pones Tasa (tipo de interes del periodo)
												// en B1 el nPer  (número de Periodos)
												// en C1 el Va  (Capital inicial)
												// (A1*(1+A1)^B1)*C1/(((1+A1)^B1)-1)
												//(0.01 * (1+0.1)^84*191,520.00/(((1+A1)^84)-1)

												// var mesesAlv=posPay - $scope.alphaNumeric.length;
												// console.log("Total II: " + $scope.total2);

												if (posicionPago < $scope.infoLote.msn) {
													// $scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo'] = $scope.total2;
													// console.log($scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo']);
													var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
													parte1 = parte1;

													var parte2 = (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);
													parte2 = parte2;
													// console.log($scope.infoLote.msn + " - " + posicionPago);

													// console.log($scope.alphaNumeric[posPay]['control']);

													$scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo'] = $scope.infoLote.precioTotal;

													operacionCompleta = (($scope.infoLote.interes_p2 * parte1 * $scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo']) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
													// console.log(parte2 + " - " + $scope.alphaNumeric[($scope.infoLote.msn-1)]['saldo']);
												} else //if(posicionPago>=$scope.infoLote.msn)
												{
													var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago']);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
													parte1 = parte1;

													var parte2 = (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago']) - 1);
													parte2 = parte2;
													// console.log(0);
													// console.log(posPay + " - " + posicionPago);
													operacionCompleta = (($scope.infoLote.interes_p2 * parte1 * $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2)) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
													// console.log(parte2 + " - " + $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2));
												}
												// var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses  - $scope.alphaNumeric[posPay]['pago']);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
												// parte1 = parte1;
												//
												// var parte2 = ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses  - $scope.alphaNumeric[posPay]['pago'])-1);
												// parte2 = parte2;
												$scope.interes_plan2 = $scope.alphaNumeric[(i - 1)]['saldo'] * ($scope.infoLote.interes_p2);
												// operacionCompleta = (($scope.infoLote.interes_p2*parte1*$scope.alphaNumeric[(posPay)]['saldo'].toFixed(2))/parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
												// console.log(parte2 + " - " + $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2));
												capital = operacionCompleta - $scope.interes_plan2;//($scope.capital2 =	 ($scope.p2 - $scope.interes_plan2))
												// console.log("interes: " + $scope.interes_plan2);
												newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i)]['saldo'] = $scope.total2 - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												total = operacionCompleta;//$scope.p2
												interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												// console.log("poscicion " + (i-1) + ": ");
												// console.log($scope.alphaNumeric[(i-1)]['saldo']);
												// console.log(i + " - " + $scope.alphaNumeric[(i - 1)]['saldo']);
												// console.log(parte2 + " - " + $scope.alphaNumeric[($scope.infoLote.msn-1)]['saldo']);


												// console.log($scope.alphaNumeric[i]['pago']);
												// capital = $scope.capital2 ;
												// newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i - 1)]['saldo'] - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												// dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												// pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												// interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												// total = $scope.p2;
												// console.log($scope.alphaNumeric[i]['pago']);
												// console.log("saldo: " +( $scope.alphaNumeric[i]['saldo'] - $scope.alphaNumeric[i]['pagoCapital']) );
											} else {
												// console.log($scope.alphaNumeric[i]['pago']);
												// console.log($scope.alphaNumeric[i]['saldo']);
												capital = $scope.capital2;
												newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i - 1)]['saldo'] - $scope.alphaNumeric[i]['pagoCapital'] - $scope.capital2;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												total = $scope.p2;//$scope.p2
											}
											// console.log($scope.total2);
										}
									} else {
										if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago) {
											if ($scope.alphaNumeric[posicionPago]['disp'] == 1) {
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
												saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'];
											} else {//se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
											}
										} else {
											//cuando se salta un espacio en la tabla
											saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
											total = 999999999999999;
										}
									}
								}
								// console.log("p2: " + $scope.p2);
								range2.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": capital,
									"interes": interes,
									"total": total,
									"saldo": newSaldoTable,//newSaldoTable
									"pagoCapital": pagoACapitalCantidad,
									"disp": dispPC,
								});
							} else {
								range2.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.alphaNumeric[i]['capital'],
									"interes": $scope.alphaNumeric[i]['interes'],
									"total": $scope.alphaNumeric[i]['total'],
									"saldo": $scope.alphaNumeric[i]['saldo'],//newSaldoTable
									"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
									"disp": $scope.alphaNumeric[i]['disp'],
								});
							}
							//
							// range2.push({
							// 	"fecha": $scope.dateCf,
							// 	"pago": i + 1,
							// 	"capital": ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
							// 	"interes": ($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
							// 	"total": $scope.p2,
							// 	"saldo":  ($scope.total2 = ($scope.total2 -$scope.capital2)),//newSaldoTable
							// 	"pagoCapital": 0,
							// 	"disp": dispPC,
							// });
							// window['pagoCapChange' + numfinalCount]=Function("","console.log('pagoCapChange"+numfinalCount+" el parametro es: " + document.getElementById('#idModel'+numfinalCount) + "');");//angular.element(document.querySelector('#idModel'+numfinalCount))

							mes++;
							if (i == ($scope.infoLote.meses - 1)) {
								$scope.totalSegundoPlan = total;
							}
							$scope.finalMesesp2 = (range2.length);
						}
						// range2.push({
						// 	"fecha" : $scope.dateCf,
						// 	"pago" : i + 1,
						// 	"capital" : 88888,
						// 	"interes" : 99999,
						// 	"total" :33333,
						// 	"saldo" : 55555,//newSaldoTable
						// 	"pagoCapital": 0,
						// 	"disp": 6666,
						// });
						$scope.range2 = range2;
						// console.log(range2);

						// $scope.alphaNumeric = $scope.rangEd.concat($scope.range);
						// $scope.alphaNumeric = $scope.dani.concat($scope.range2);
						// $scope.alphaNumeric = $scope.range.concat($scope.range2);


						$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
						$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2);
						// console.log($scope.alphaNumeric);
						$scope.dtoptions = DTOptionsBuilder;
						$scope.dtColumns = [
							DTColumnBuilder.newColumn('fecha').withTitle('Fechas'),
							DTColumnBuilder.newColumn('pago').withTitle('Pago #'),
							DTColumnBuilder.newColumn('capital').withTitle('Capital').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('interes').withTitle('Intereses').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('total').withTitle('Total').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('saldo').withTitle('Saldo').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('pagoCapital').withTitle('Pago a Capital')
								.renderWith(
									function (data, type, full, meta) {
										// console.log($scope.alphaNumeric[full['pago']-1]['saldo']);
										if ($scope.alphaNumeric[full['pago'] - 1]['saldo'] <= 0) {
											$scope.alphaNumeric[full['pago'] - 1]['saldo'] = 0;
										}
										if ($scope.alphaNumeric[posicionPago - 1]['disp'] == 1 && $scope.alphaNumeric[posicionPago - 1]['pagoCapital'] != "" && full['pagoCapital'] != "")//
										{
											// console.log($scope.alphaNumeric[posicionPago-1]['pago']   +" "+	posicionPago);
											// console.log('Estoy llegando aquí');
											// return "$ " + saldo;
											var inputCapital = '<input name="capVal' + full["pago"] + '" type="number" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control" value="' + $scope.alphaNumeric[full['pago'] - 1]['pagoCapital'] + '" disabled>';
											var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
											return inputCapital + numberPay;
										} else {
											var inputCapital = '<input name="capVal' + full["pago"] + '" type="text" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control">';
											var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
											return inputCapital + numberPay;
										}
										// console.log($scope.alphaNumeric[posicionPago-1]['disp']	+	" "	+	$scope.alphaNumeric[posicionPago-1]['pagoCapital']);
									},
								),
						];

						$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
								{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
								{
									extend: 'print',
									text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
									titleAttr: 'Imprimir'
								},
								{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
								{
									extend: 'pdfHtml5',
									text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
									titleAttr: 'PDF',
									title: '',
									customize: function (doc) {
										//pageMargins [left, top, right, bottom]
										doc.pageMargins = [140, 40, 10, 50];
										doc.alignment = 'center';
									}
								},
							]
						).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
					}

					if ($scope.infoLote.mesesSinInteresP1 == 0)
					{
						// console.log('0 meses alv');
						$scope.infoLote.mesesSinInteresP1 = ($scope.mesesdiferir > 0) ? ($scope.infoLote.mesesSinInteresP1 + $scope.mesesdiferir) : ($scope.infoLote.mesesSinInteresP1);


						// $scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.infoLote.precioTotal)
						// 	/ ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);

						$scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.infoLote.precioTotal) / (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);
						var range2 = [];
						for (var i = ini; i < $scope.infoLote.meses; i++) {

							if (mes == 13) {
								mes = '01';
								yearc++;
							}
							if (mes == 2) {
								mes = '02';
							}
							if (mes == 3) {
								mes = '03';
							}
							if (mes == 4) {
								mes = '04';
							}
							if (mes == 5) {
								mes = '05';
							}
							if (mes == 6) {
								mes = '06';
							}
							if (mes == 7) {
								mes = '07';
							}
							if (mes == 8) {
								mes = '08';
							}
							if (mes == 9) {
								mes = '09';
							}
							if (mes == 10) {
								mes = '10';
							}
							if (mes == 11) {
								mes = '11';
							}
							if (mes == 12) {
								mes = '12';
							}


							$scope.dateCf = day + '-' + mes + '-' + yearc;

							//nuevo codigo 2 marzo 20
							if (i == 0) {
								$scope.fechaPM = $scope.fechapago;
							}
							var interes = 0;
							var total = 0;
							var capital = 0;
							var newSaldoTable = 0;
							var alphaOriginal = [];
							alphaOriginal = $scope.alphaNumeric;

							if ($scope.alphaNumeric[i]['disp'] != 1) {
								var vuelta = (i + 1);
								var posicionPago = (posPay + 1);
								if (vuelta == posicionPago) {
									if (posicionPago == 1) {
										// console.log('primera posicion');
									} else {
										// console.log('Segunda posicion: ' + $scope.alphaNumeric[posPay]['saldo'] + 'pagocap: ' + saldo);
										capital = $scope.alphaNumeric[posPay]['capital'];
										newSaldoTable = $scope.total2 = $scope.alphaNumeric[posPay]['saldo'];//= nuevoSaldo;//saldo es el pago a capital (facepalm)
										dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
										pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
										interes = $scope.alphaNumeric[posPay]['interes'];//$scope.alphaNumeric[posPay]['saldo'] * $scope.infoLote.interes_p2
										total = $scope.alphaNumeric[posPay]['total'];//capital + interes
									}
								} else {
									// console.log('el total hasta este punto es de: ' + $scope.total2);
									if ($scope.alphaNumeric[posicionPago]['pagoCapital'] == 0) {
										// capital = $scope.alphaNumeric[i]['capital']=99999999999999;
										// newSaldoTable = $scope.alphaNumeric[i]['saldo'];//saldo es el pago a capital (facepalm)
										// dispPC = $scope.alphaNumeric[i]['disp'] = 0;
										// pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
										if (i < posicionPago) {
											capital = $scope.alphaNumeric[i]['capital'];
											newSaldoTable = $scope.alphaNumeric[i]['saldo'];//saldo es el pago a capital (facepalm)
											dispPC = $scope.alphaNumeric[i]['disp'] = 0;
											pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
											interes = $scope.alphaNumeric[i]['interes'];
											total = $scope.alphaNumeric[i]['total'];
										} else {

											$scope.interes_plan2 = $scope.alphaNumeric[(i - 1)]['saldo'] * ($scope.infoLote.interes_p2);//$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
											$scope.capital2 = (($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.alphaNumeric[i]['saldo'])
												/ (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1) - $scope.interes_plan2);
											// $scope.capital2 = ((($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1)) - $scope.interes_plan2);

											// capital = $scope.capital2 ;
											// newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i - 1)]['saldo'] - $scope.alphaNumeric[i]['pagoCapital'] - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
											// dispPC = $scope.alphaNumeric[i]['disp'] = 0;
											// pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
											// interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
											// total = $scope.p2 ;//$scope.p2


											// $scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.alphaNumeric[i]['saldo'] ) / (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);
											if ($scope.alphaNumeric[i]['disp'] == undefined || $scope.alphaNumeric[i]['disp'] == 0) {


												// version 09Marzo20
												// var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1);
												// parte1 = parte1.toFixed(2);
												// var parte2 = ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
												// parte2 = parte2.toFixed(2);
												// var operacionCompleta = (($scope.infoLote.interes_p2*($scope.alphaNumeric[posPay]['saldo'] * parte1))/parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
												// // console.log("alv: " + operacionCompleta);
												// capital = operacionCompleta - $scope.interes_plan2;//($scope.capital2 = ($scope.p2 - $scope.interes_plan2))
												// console.log("interes: " + $scope.interes_plan2);
												// newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i)]['saldo'] = $scope.total2 - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												// dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												// pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												// total = operacionCompleta;
												// interes = $scope.interes_plan2;


												//nunevaversion 09MArzo2020
												var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago']);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
												parte1 = parte1;

												var parte2 = (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago']) - 1);
												parte2 = parte2;
												// console.log(0);
												// console.log(posPay + " - " + posicionPago);
												operacionCompleta = (($scope.infoLote.interes_p2 * parte1 * $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2)) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
												// console.log(parte2 + " - " + $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2));
												capital = operacionCompleta - $scope.interes_plan2;//($scope.capital2 = ($scope.p2 - $scope.interes_plan2))
												// console.log("interes: " + $scope.interes_plan2);
												newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i)]['saldo'] = $scope.total2 - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												total = operacionCompleta;//$scope.p2
												interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												// console.log($scope.alphaNumeric[i]['pago']);
												// capital = $scope.capital2 ;
												// newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i - 1)]['saldo'] - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												// dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												// pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												// interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												// total = $scope.p2;
												// console.log($scope.alphaNumeric[i]['pago']);
												// console.log("saldo: " +( $scope.alphaNumeric[i]['saldo'] - $scope.alphaNumeric[i]['pagoCapital']) );
											} else {
												console.log($scope.alphaNumeric[i]['pago']);
												console.log($scope.alphaNumeric[i]['saldo']);
												capital = $scope.capital2;
												newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i - 1)]['saldo'] - $scope.alphaNumeric[i]['pagoCapital'] - $scope.capital2;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												total = $scope.p2;//$scope.p2
											}
											// console.log($scope.total2);
										}
										// console.log('pagoCapital == 0');
									} else {
										if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago) {
											if ($scope.alphaNumeric[posicionPago]['disp'] == 1) {
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
												saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'];
											} else {//se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
											}
										} else {
											//cuando se salta un espacio en la tabla
											saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
											total = 999999999999999;
										}
										// console.log('pagoCapital != 0');
									}
								}
								// console.log("p2: " + $scope.p2);
								range2.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": capital,
									"interes": interes,
									"total": total,
									"saldo": newSaldoTable,//newSaldoTable
									"pagoCapital": pagoACapitalCantidad,
									"disp": dispPC,
								});
							} else {
								range2.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.alphaNumeric[i]['capital'],
									"interes": $scope.alphaNumeric[i]['interes'],
									"total": $scope.alphaNumeric[i]['total'],
									"saldo": $scope.alphaNumeric[i]['saldo'],//newSaldoTable
									"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
									"disp": $scope.alphaNumeric[i]['disp'],
								});
							}
							//finaliza nuevo código 2 marzo 20


							//codigo anterior a 2 marzo 20
							// $scope.interes_plan2 = $scope.infoLote.precioTotal * ($scope.infoLote.interes_p2);
							// $scope.capital2 = ($scope.p2 - $scope.interes_plan2);
							// range2.push({
							//
							// 	"fecha" : $scope.dateCf,
							// 	"pago" : i + 1,
							// 	"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
							// 	"interes" : ($scope.interes_plan2= ($scope.infoLote.precioTotal * $scope.infoLote.interes_p2)),
							// 	"total" : $scope.p2,
							// 	"saldo" : ($scope.infoLote.precioTotal = ($scope.infoLote.precioTotal -$scope.capital2)),
							// 	"pagoCapital"	:	"",
							// });


							mes++;

							if (i == ($scope.infoLote.meses - 1)) {
								$scope.totalSegundoPlan = total;
							}
							$scope.finalMesesp2 = (range2.length);
						}
						$scope.range2 = range2;
						/*pasar parametros de lectura intereses de poscion*/
						$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
						$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range2);
						// $scope.alphaNumeric = $scope.range2;
						// console.log($scope.alphaNumeric);


						$scope.dtoptions = DTOptionsBuilder;
						$scope.dtColumns = [
							DTColumnBuilder.newColumn('fecha').withTitle('Fechas'),
							DTColumnBuilder.newColumn('pago').withTitle('Pago #'),
							DTColumnBuilder.newColumn('capital').withTitle('Capital').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('interes').withTitle('Intereses').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('total').withTitle('Total').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('saldo').withTitle('Saldo').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('pagoCapital').withTitle('Pago a Capital')
								.renderWith(
									function (data, type, full, meta) {
										// console.log($scope.alphaNumeric[full['pago']-1]['saldo']);
										if ($scope.alphaNumeric[full['pago'] - 1]['saldo'] <= 0) {
											$scope.alphaNumeric[full['pago'] - 1]['saldo'] = 0;
										}
										if ($scope.alphaNumeric[posicionPago - 1]['disp'] == 1 && $scope.alphaNumeric[posicionPago - 1]['pagoCapital'] != "" && full['pagoCapital'] != "")//
										{
											// console.log($scope.alphaNumeric[posicionPago-1]['pago']   +" "+	posicionPago);
											// console.log('Estoy llegando aquí');
											// return "$ " + saldo;
											var inputCapital = '<input name="capVal' + full["pago"] + '" type="number" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control" value="' + $scope.alphaNumeric[full['pago'] - 1]['pagoCapital'] + '" disabled>';
											var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
											return inputCapital + numberPay;
										} else {
											var inputCapital = '<input name="capVal' + full["pago"] + '" type="text" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control">';
											var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
											return inputCapital + numberPay;
										}
										// console.log($scope.alphaNumeric[posicionPago-1]['disp']	+	" "	+	$scope.alphaNumeric[posicionPago-1]['pagoCapital']);
									},
								),
						];

						$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
								{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
								{
									extend: 'print',
									text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
									titleAttr: 'Imprimir'
								},
								{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
								{
									extend: 'pdfHtml5',
									text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
									titleAttr: 'PDF',
									title: '',
									customize: function (doc) {
										//pageMargins [left, top, right, bottom]
										doc.pageMargins = [140, 40, 10, 50];
										doc.alignment = 'center';
									}
								},
							]
						).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});


					}

					// if($scope.infoLote.mesesSinInteresP1 == 36)
					// {
					// 	console.log('36 meses alv');
					// 	for (var i = ini; i <= $scope.infoLote.mesesSinInteresP1 - 1; i++)
					// 	{
					// 		if (mes == 13) {
					// 			mes = '01';
					// 			yearc++;
					// 		}
					// 		if (mes == 2) {
					// 			mes = '02';
					// 		}
					// 		if (mes == 3) {
					// 			mes = '03';
					// 		}
					// 		if (mes == 4) {
					// 			mes = '04';
					// 		}
					// 		if (mes == 5) {
					// 			mes = '05';
					// 		}
					// 		if (mes == 6) {
					// 			mes = '06';
					// 		}
					// 		if (mes == 7) {
					// 			mes = '07';
					// 		}
					// 		if (mes == 8) {
					// 			mes = '08';
					// 		}
					// 		if (mes == 9) {
					// 			mes = '09';
					// 		}
					// 		if (mes == 10) {
					// 			mes = '10';
					// 		}
					// 		if (mes == 11) {
					// 			mes = '11';
					// 		}
					// 		if (mes == 12) {
					// 			mes = '12';
					// 		}
					// 		$scope.dateCf = day + '-' + mes + '-' + yearc;
					//
					// 		if (i == 0) {
					// 			$scope.fechaPM = $scope.dateCf;
					// 		}
					// 		var newSaldoTable = 0;
					// 		var alphaOriginal = [];
					// 		alphaOriginal = $scope.alphaNumeric;
					// 		if ($scope.alphaNumeric[i]['disp'] != 1) {
					// 			/*Para verfificar donde se puso el pago a capital*/
					// 			var dispPC = 0;
					// 			var vuelta = (i + 1);
					// 			var posicionPago = (posPay + 1);
					// 			if (vuelta == posicionPago)
					// 			{
					// 				// console.log("se tiene que poner esto " + saldo + " en la posición: " + (posPay + 1));
					// 				if (posicionPago == 1)
					// 				{
					// 					/* Este if es para ver si se descuenta la primera posicion*/
					// 					newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
					// 					dispPC = 1;
					// 					pagoACapitalCantidad = saldo;
					// 					console.log('se desceunta de la primera posicion');
					// 				}
					// 				else
					// 				{/* Este else es para ver si se descuenta apartir de la segunda posicion*/
					// 					alert('olv');
					// 					newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
					// 					dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
					// 					pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
					// 					console.log('se descuente de la posicion ' + i);
					// 				}
					// 			}
					// 			else
					// 			{
					// 				if ($scope.alphaNumeric[posicionPago]['pagoCapital'] == 0)
					// 				{
					// 					/*Hace el calculo cuando es 0apartir de la segunda posición*/
					// 					if ($scope.alphaNumeric[posicionPago]['disp'] == 0)
					// 					{
					// 						//else despues del primer post en segunda posicion
					// 						if ($scope.alphaNumeric[i]['pago'] >= posicionPago)
					// 						{
					// 							capital = $scope.alphaNumeric[i]['capital'] = ($scope.mesesdiferir > 0) ? ($scope.alphaNumeric[posPay]['saldo'] / (((($scope.age_plan * 12) - $scope.alphaNumeric[posPay]['pago'])) - $scope.mesesdiferir)) : ($scope.alphaNumeric[posPay]['saldo'] / ((($scope.age_plan * 12) - $scope.alphaNumeric[posPay]['pago'])));
					// 							// $scope.infoLote.precioTotal = $scope.alphaNumeric[(i - 1)]['saldo'] - capital
					// 							newSaldoTable = $scope.alphaNumeric[i]['saldo'] = $scope.alphaNumeric[(i-1)]['saldo'] - capital;// - ($scope.mesesdiferir > 0) ? ($scope.alphaNumeric[posPay]['saldo']/ (((($scope.age_plan*12)-$scope.alphaNumeric[posPay]['pago'])) - $scope.mesesdiferir)) : ($scope.alphaNumeric[posPay]['saldo'] / ((($scope.age_plan*12)-$scope.alphaNumeric[posPay]['pago'])))
					// 							dispPC = 0;
					// 							pagoACapitalCantidad = 0;
					// 							console.log("Faltan: " + (($scope.age_plan * 12) - $scope.alphaNumeric[i]['pago']));
					// 						}
					// 						else// if ($scope.alphaNumeric[i]['pago'] <= posicionPago)
					// 						{
					// 							newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
					// 							dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
					// 							pagoACapitalCantidad = 0;
					// 							capital = $scope.alphaNumeric[i]['capital'];
					// 						}
					// 					}
					// 					// else
					// 					// {
					// 					// 	//else despues del primer post
					// 					// 	console.log('posicion de pago ene ste punto :' + posicionPago);
					// 					// 	if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
					// 					// 		capital = ($scope.mesesdiferir > 0) ? ($scope.alphaNumeric[posPay]['saldo'] / (((($scope.age_plan * 12) - $scope.alphaNumeric[posPay]['pago'])) - $scope.mesesdiferir)) : ($scope.alphaNumeric[posPay]['saldo'] / ((($scope.age_plan * 12) - $scope.alphaNumeric[posPay]['pago'])));
					// 					// 		newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[(i - 1)]['saldo'] - capital;// - ($scope.mesesdiferir > 0) ? ($scope.alphaNumeric[posPay]['saldo']/ (((($scope.age_plan*12)-$scope.alphaNumeric[posPay]['pago'])) - $scope.mesesdiferir)) : ($scope.alphaNumeric[posPay]['saldo'] / ((($scope.age_plan*12)-$scope.alphaNumeric[posPay]['pago'])))
					// 					// 		dispPC = 0;
					// 					// 		pagoACapitalCantidad = 0;
					// 					// 		console.log("Faltan: " + (($scope.age_plan * 12) - $scope.alphaNumeric[i]['pago']));
					// 					// 	} else if ($scope.alphaNumeric[i]['pago'] <= posicionPago) {
					// 					// 		newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
					// 					// 		dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
					// 					// 		pagoACapitalCantidad = 0;
					// 					// 		capital = $scope.alphaNumeric[i]['capital'];
					// 					// 	}
					// 					// }
					// 				}
					// 			}
					// 			range.push({
					// 				"fecha": $scope.dateCf,
					// 				"pago": i + 1,
					// 				"capital": capital,
					// 				"interes": 0,
					// 				"total": capital,
					// 				"saldo": newSaldoTable,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
					// 				"pagoCapital": pagoACapitalCantidad,
					// 				"disp": dispPC,
					// 			});
					// 		}
					// 		else
					// 		{
					// 			/*Se coloca el valor anterior de donde se modificó, con el valor que trae por defecto en el areglo*/
					// 			range.push({
					// 				"fecha": $scope.dateCf,
					// 				"pago": i + 1,
					// 				"capital": $scope.alphaNumeric[i]['capital'],
					// 				"interes": 0,
					// 				"total": $scope.alphaNumeric[i]['total'],
					// 				"saldo": $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
					// 				"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
					// 				"disp": $scope.alphaNumeric[i]['disp'],
					// 			});
					// 		}
					// 		/*finaliza funcion*/
					// 		mes++;
					// 		if (i == ($scope.infoLote.mesesSinInteresP1 - 1)) {
					// 			$scope.total2 = $scope.infoLote.precioTotal;
					// 			alert($scope.total2);
					// 			$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;
					// 		}
					// 		$scope.finalMesesp1 = range.length;
					// 		ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
					// 	}
					// 	console.log($scope.alphaNumeric);
					// 	$scope.range = range;
					//
					// 	$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
					// 	$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range);
					// 	// $scope.alphaNumeric = $scope.range2;
					//
					//
					// 	$scope.dtoptions = DTOptionsBuilder;
					// 	$scope.dtColumns = [
					// 		DTColumnBuilder.newColumn('fecha').withTitle('Fechas'),
					// 		DTColumnBuilder.newColumn('pago').withTitle('Pago #'),
					// 		DTColumnBuilder.newColumn('capital').withTitle('Capital').renderWith(function (data, type, full) {
					// 			return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
					// 		}),
					// 		DTColumnBuilder.newColumn('interes').withTitle('Intereses').renderWith(function (data, type, full) {
					// 			return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
					// 		}),
					// 		DTColumnBuilder.newColumn('total').withTitle('Total').renderWith(function (data, type, full) {
					// 			return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
					// 		}),
					// 		DTColumnBuilder.newColumn('saldo').withTitle('Saldo').renderWith(function (data, type, full) {
					// 			return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
					// 		}),
					// 		DTColumnBuilder.newColumn('pagoCapital').withTitle('Pago a Capital')
					// 			.renderWith(
					// 				function (data, type, full, meta) {
					// 					// console.log($scope.alphaNumeric[full['pago']-1]['saldo']);
					// 					if ($scope.alphaNumeric[full['pago'] - 1]['saldo'] <= 0) {
					// 						$scope.alphaNumeric[full['pago'] - 1]['saldo'] = 0;
					// 					}
					// 					if ($scope.alphaNumeric[posicionPago - 1]['disp'] == 1 && $scope.alphaNumeric[posicionPago - 1]['pagoCapital'] != "" && full['pagoCapital'] != "")//
					// 					{
					// 						// console.log($scope.alphaNumeric[posicionPago-1]['pago']   +" "+	posicionPago);
					// 						// console.log('Estoy llegando aquí');
					// 						// return "$ " + saldo;
					// 						var inputCapital = '<input name="capVal' + full["pago"] + '" type="number" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control" value="' + $scope.alphaNumeric[full['pago'] - 1]['pagoCapital'] + '" disabled>';
					// 						var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
					// 						return inputCapital + numberPay;
					// 					} else {
					// 						var inputCapital = '<input name="capVal' + full["pago"] + '" type="number" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control">';
					// 						var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
					// 						return inputCapital + numberPay;
					// 					}
					// 					// console.log($scope.alphaNumeric[posicionPago-1]['disp']	+	" "	+	$scope.alphaNumeric[posicionPago-1]['pagoCapital']);
					// 				},
					// 			),
					// 	];
					//
					// 	$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
					// 			{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
					// 			{
					// 				extend: 'print',
					// 				text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
					// 				titleAttr: 'Imprimir'
					// 			},
					// 			{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
					// 			{
					// 				extend: 'pdfHtml5',
					// 				text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
					// 				titleAttr: 'PDF',
					// 				title: '',
					// 				customize: function (doc) {
					// 					//pageMargins [left, top, right, bottom]
					// 					doc.pageMargins = [140, 40, 10, 50];
					// 					doc.alignment = 'center';
					// 				}
					// 			},
					// 		]
					// 	).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
					// }
					if ($scope.infoLote.mesesSinInteresP1 == 36) {
						for (var i = ini; i <= $scope.infoLote.mesesSinInteresP1 - 1; i++) {
							if (mes == 13) {
								mes = '01';
								yearc++;
							}
							if (mes == 2) {
								mes = '02';
							}
							if (mes == 3) {
								mes = '03';
							}
							if (mes == 4) {
								mes = '04';
							}
							if (mes == 5) {
								mes = '05';
							}
							if (mes == 6) {
								mes = '06';
							}
							if (mes == 7) {
								mes = '07';
							}
							if (mes == 8) {
								mes = '08';
							}
							if (mes == 9) {
								mes = '09';
							}
							if (mes == 10) {
								mes = '10';
							}
							if (mes == 11) {
								mes = '11';
							}
							if (mes == 12) {
								mes = '12';
							}
							$scope.dateCf = day + '-' + mes + '-' + yearc;

							if (i == 0) {
								$scope.fechaPM = $scope.dateCf;
							}
							var newSaldoTable = 0;
							var alphaOriginal = [];
							alphaOriginal = $scope.alphaNumeric;
							if ($scope.alphaNumeric[i]['disp'] != 1) {
								/*Para verfificar donde se puso el pago a capital*/
								var dispPC = 0;
								var vuelta = (i + 1);
								var posicionPago = (posPay + 1);
								if (vuelta == posicionPago) {
									// console.log("se tiene que poner esto " + saldo + " en la posición: " + (posPay + 1));
									if (posicionPago == 1) {
										/* Este if es para ver si se descuenta la primera posicion*/
										newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
										dispPC = 1;
										pagoACapitalCantidad = saldo;
										// console.log('se desceunta de la primera posicion');
									} else {/* Este else es para ver si se descuenta apartir de la segunda posicion*/
										// alert('olv');
										newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
										dispPC = $scope.alphaNumeric[posPay]['dispPC'] = 1;
										pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
										// console.log('se descuente de la posicion ' + i);
									}
									/*ghdfhfdhdhdfhdh*/
									//anterior a 19 enero20
									// for (var n = 0; n < posicionPago; n++) {
									// 	if ($scope.alphaNumeric[n]['disp'] == 0 || $scope.alphaNumeric[n]['disp'] == "0") {
									// 		if ($scope.alphaNumeric[n]['pago'] < posicionPago) {
									// 			console.log($scope.alphaNumeric[n]['pago']);
									// 			$scope.alphaNumeric[n]['saldo'] = alphaOriginal[n]['saldo'];//alphaOriginal[n]['saldo']
									// 			console.log("este es el saldo " + alphaOriginal[n]['saldo'] + " en " + n)
									// 		}
									// 	}
									// }
									// for (var n = 0; n < posicionPago; n++)
									// {
									// 	if($scope.alphaNumeric[n]['disp']!="")
									// 	{
									// 		newSaldoTable = 99999;
									// 	}
									// }
								} else {
									/*Hace el calculo cuando es 0apartir de la segunda posición*/
									if ($scope.alphaNumeric[i]['disp'] == 0 || $scope.alphaNumeric[i]['disp'] == undefined) {
										//newSaldoTable = $scope.inufoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital;
										// dispPC = 0;
										// pagoACapitalCantidad = 0;
										//else despues del primer post en segunda posicion
										if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'] - saldo;
											dispPC = 0;
											pagoACapitalCantidad = 0;
										} else if ($scope.alphaNumeric[i]['pago'] <= posicionPago) {
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
											// dispPC = 0;
											dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
											pagoACapitalCantidad = 0;
										}
									} else {
										//else despues del primer post
										// console.log($scope.alphaNumeric[i]['disp']);
										// console.log('posicion de pago ene ste punto :' + posicionPago);
										if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
											dispPC = 0;
											pagoACapitalCantidad = 0;

										} else if ($scope.alphaNumeric[i]['pago'] <= posicionPago) {

											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
											dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
											pagoACapitalCantidad = 0;
										}
										// if ($scope.alphaNumeric[posicionPago]['pago'] >= posicionPago || $scope.alphaNumeric[posicionPago]['pago'] <= posicionPago)
										// {
										// 	if ($scope.alphaNumeric[posicionPago]['disp'] == 1)
										// 	{
										// 		/*aqui se coloca cuando se hay pagos abajo del nuevo, ejemplo Pago 5:550 y se quiere colocar uno en el 2*/
										// 		newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posicionPago]['saldo'];
										// 		dispPC = 1;
										// 		pagoACapitalCantidad = $scope.alphaNumeric[posicionPago]['pagoCapital'];
										// 	}
										// 	else
										// 	{/*se coloca un valor cuando nohay nada(el resto de los campos*/
										// 			newSaldoTable = $scope.alphaNumeric[i]['saldo'];
										// 			dispPC = 0;
										// 			pagoACapitalCantidad = 0;
										// 	}
										// }
										// else
										// {
										// 	newSaldoTable = 0;
										// 	dispPC = 0;
										// 	pagoACapitalCantidad = 0;
										// }
									}
								}
								range.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.infoLote.capital,
									"interes": 0,
									"total": $scope.infoLote.capital + $scope.infoLote.interes_p1,
									"saldo": newSaldoTable,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
									"pagoCapital": pagoACapitalCantidad,
									"disp": dispPC,
								});
							} else {
								/*Se coloca el valor anterior de donde se modificó, con el valor que trae por defecto en el areglo*/
								range.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.alphaNumeric[i]['capital'],
									"interes": 0,
									"total": $scope.alphaNumeric[i]['total'],
									"saldo": $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
									"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
									"disp": $scope.alphaNumeric[i]['disp'],
								});
								// range.push({
								//     "fecha": $scope.alphaNumeric[i]['fecha'],
								//     "pago": i + 1,
								//     "capital": $scope.alphaNumeric[i]['capital'],
								//     "interes": 0,
								//     "total": $scope.alphaNumeric[i]['total'],
								//     "saldo": $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
								//     "pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
								//     "disp": $scope.alphaNumeric[i]['disp'],
								// });
							}
							/*finaliza funcion*/
							// range.push({
							//     "fecha" : $scope.dateCf,
							//     "pago" : i + 1,
							//     "capital" : $scope.infoLote.capital,
							//     "interes" : 0,
							//     "total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
							//     "saldo" : newSaldoTable,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
							//     "pagoCapital" : pagoACapitalCantidad,
							//     "disp":dispPC,
							// });
							mes++;
							if (i == ($scope.infoLote.mesesSinInteresP1 - 1)) {
								$scope.total2 = $scope.infoLote.precioTotal;
								// alert($scope.total2);
								$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;
							}
							$scope.finalMesesp1 = range.length;
							ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
						}
						$scope.range = range;

						//////////
						// var range2=[];
						// $scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.alphaNumeric[i]['saldo']) / (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);
						var range2 = [];
						// console.log("Saldo para el segundo arreglo " + $scope.total2);
						for (var i = ini2; i < $scope.infoLote.meses; i++) {
							if (mes == 13) {
								mes = '01';
								yearc++;
							}
							if (mes == 2) {
								mes = '02';
							}
							if (mes == 3) {
								mes = '03';
							}
							if (mes == 4) {
								mes = '04';
							}
							if (mes == 5) {
								mes = '05';
							}
							if (mes == 6) {
								mes = '06';
							}
							if (mes == 7) {
								mes = '07';
							}
							if (mes == 8) {
								mes = '08';
							}
							if (mes == 9) {
								mes = '09';
							}
							if (mes == 10) {
								mes = '10';
							}
							if (mes == 11) {
								mes = '11';
							}
							if (mes == 12) {
								mes = '12';
							}
							$scope.dateCf = day + '-' + mes + '-' + yearc;
							if (i == 0) {
								$scope.fechaPM = $scope.fechapago;
							}
							//nuevo codigo 21 FEB
							var interes = 0;
							var total = 0;
							var capital = 0;
							var newSaldoTable = 0;

							// interes = $scope.interes_plan2=$scope.total2*$scope.infoLote.interes_p2;
							// total = $scope.p2;
							var alphaOriginal = [];
							alphaOriginal = $scope.alphaNumeric;

							if ($scope.alphaNumeric[i]['disp'] != 1) {
								var vuelta = (i + 1);
								var posicionPago = (posPay + 1);
								if (vuelta == posicionPago) {
									if (posicionPago == 1) {
										console.log('primera posicion');
									} else {
										// console.log('Segunda posicion: ' + $scope.alphaNumeric[posPay]['saldo'] + 'pagocap: ' + saldo);
										capital = $scope.alphaNumeric[posPay]['capital'];
										newSaldoTable = $scope.total2 = $scope.alphaNumeric[posPay]['saldo'];//= nuevoSaldo;//saldo es el pago a capital (facepalm)
										dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
										pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
										interes = $scope.alphaNumeric[posPay]['interes'];//$scope.alphaNumeric[posPay]['saldo'] * $scope.infoLote.interes_p2
										total = $scope.alphaNumeric[posPay]['total'];//capital + interes
										$scope.alphaNumeric[posPay]['control'] = 1;
									}
								} else {
									// console.log('el total hasta este punto es de: ' + $scope.total2);
									if ($scope.alphaNumeric[posicionPago]['pagoCapital'] == 0) {
										// capital = $scope.alphaNumeric[i]['capital']=99999999999999;
										// newSaldoTable = $scope.alphaNumeric[i]['saldo'];//saldo es el pago a capital (facepalm)
										// dispPC = $scope.alphaNumeric[i]['disp'] = 0;
										// pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
										if (i < posicionPago) {
											capital = $scope.alphaNumeric[i]['capital'];
											newSaldoTable = $scope.alphaNumeric[i]['saldo'];//saldo es el pago a capital (facepalm)
											dispPC = $scope.alphaNumeric[i]['disp'] = 0;
											pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
											interes = $scope.alphaNumeric[i]['interes'];
											total = $scope.alphaNumeric[i]['total'];
										} else {

											// $scope.interes_plan2 = $scope.alphaNumeric[(i-1)]['saldo'] * ($scope.infoLote.interes_p2);//$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
											// $scope.capital2 = (($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.alphaNumeric[i]['saldo'])
											//  / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1) - $scope.interes_plan2);

											// $scope.capital2 = ((($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1)) - $scope.interes_plan2);

											// capital = $scope.capital2 ;
											// newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i - 1)]['saldo'] - $scope.alphaNumeric[i]['pagoCapital'] - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
											// dispPC = $scope.alphaNumeric[i]['disp'] = 0;
											// pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
											// interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
											// total = $scope.p2 ;//$scope.p2


											// $scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.alphaNumeric[i]['saldo'] ) / (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);
											if ($scope.alphaNumeric[i]['disp'] == undefined || $scope.alphaNumeric[i]['disp'] == 0) {
												// A1 pones Tasa (tipo de interes del periodo)
												// en B1 el nPer  (número de Periodos)
												// en C1 el Va  (Capital inicial)
												// (A1*(1+A1)^B1)*C1/(((1+A1)^B1)-1)
												//(0.01 * (1+0.1)^84*191,520.00/(((1+A1)^84)-1)

												// var mesesAlv=posPay - $scope.alphaNumeric.length;
												// console.log("Total II: " + $scope.total2);

												if (posicionPago < $scope.infoLote.msn) {
													// $scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo'] = $scope.total2;
													// console.log($scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo']);
													var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
													parte1 = parte1;

													var parte2 = (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);
													parte2 = parte2;
													// console.log($scope.infoLote.msn + " - " + posicionPago);

													// console.log($scope.alphaNumeric[posPay]['control']);

													$scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo'] = $scope.infoLote.precioTotal;

													operacionCompleta = (($scope.infoLote.interes_p2 * parte1 * $scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo']) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
													// console.log(parte2 + " - " + $scope.alphaNumeric[($scope.infoLote.msn-1)]['saldo']);
												} else //if(posicionPago>=$scope.infoLote.msn)
												{
													var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago']);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
													parte1 = parte1;

													var parte2 = (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago']) - 1);
													parte2 = parte2;
													// console.log(0);
													// console.log(posPay + " - " + posicionPago);
													operacionCompleta = (($scope.infoLote.interes_p2 * parte1 * $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2)) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
													// console.log(parte2 + " - " + $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2));
												}
												// var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses  - $scope.alphaNumeric[posPay]['pago']);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
												// parte1 = parte1;
												//
												// var parte2 = ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses  - $scope.alphaNumeric[posPay]['pago'])-1);
												// parte2 = parte2;
												$scope.interes_plan2 = $scope.alphaNumeric[(i - 1)]['saldo'] * ($scope.infoLote.interes_p2);
												// operacionCompleta = (($scope.infoLote.interes_p2*parte1*$scope.alphaNumeric[(posPay)]['saldo'].toFixed(2))/parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
												// console.log(parte2 + " - " + $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2));
												capital = operacionCompleta - $scope.interes_plan2;//($scope.capital2 =	 ($scope.p2 - $scope.interes_plan2))
												// console.log("interes: " + $scope.interes_plan2);
												newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i)]['saldo'] = $scope.total2 - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												total = operacionCompleta;//$scope.p2
												interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												// console.log("poscicion " + (i-1) + ": ");
												// console.log($scope.alphaNumeric[(i-1)]['saldo']);
												// console.log(i + " - " + $scope.alphaNumeric[(i - 1)]['saldo']);
												// console.log(parte2 + " - " + $scope.alphaNumeric[($scope.infoLote.msn-1)]['saldo']);


												// console.log($scope.alphaNumeric[i]['pago']);
												// capital = $scope.capital2 ;
												// newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i - 1)]['saldo'] - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												// dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												// pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												// interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												// total = $scope.p2;
												// console.log($scope.alphaNumeric[i]['pago']);
												// console.log("saldo: " +( $scope.alphaNumeric[i]['saldo'] - $scope.alphaNumeric[i]['pagoCapital']) );
											} else {
												// console.log($scope.alphaNumeric[i]['pago']);
												// console.log($scope.alphaNumeric[i]['saldo']);
												capital = $scope.capital2;
												newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i - 1)]['saldo'] - $scope.alphaNumeric[i]['pagoCapital'] - $scope.capital2;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												total = $scope.p2;//$scope.p2
											}
											// console.log($scope.total2);
										}
									} else {
										if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago) {
											if ($scope.alphaNumeric[posicionPago]['disp'] == 1) {
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
												saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'];
											} else {//se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
											}
										} else {
											//cuando se salta un espacio en la tabla
											saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
											total = 999999999999999;
										}
									}
								}
								// console.log("p2: " + $scope.p2);
								range2.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": capital,
									"interes": interes,
									"total": total,
									"saldo": newSaldoTable,//newSaldoTable
									"pagoCapital": pagoACapitalCantidad,
									"disp": dispPC,
								});
							} else {
								range2.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.alphaNumeric[i]['capital'],
									"interes": $scope.alphaNumeric[i]['interes'],
									"total": $scope.alphaNumeric[i]['total'],
									"saldo": $scope.alphaNumeric[i]['saldo'],//newSaldoTable
									"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
									"disp": $scope.alphaNumeric[i]['disp'],
								});
							}
							//
							// range2.push({
							// 	"fecha": $scope.dateCf,
							// 	"pago": i + 1,
							// 	"capital": ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
							// 	"interes": ($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
							// 	"total": $scope.p2,
							// 	"saldo":  ($scope.total2 = ($scope.total2 -$scope.capital2)),//newSaldoTable
							// 	"pagoCapital": 0,
							// 	"disp": dispPC,
							// });
							// window['pagoCapChange' + numfinalCount]=Function("","console.log('pagoCapChange"+numfinalCount+" el parametro es: " + document.getElementById('#idModel'+numfinalCount) + "');");//angular.element(document.querySelector('#idModel'+numfinalCount))

							mes++;
							if (i == ($scope.infoLote.meses - 1)) {
								$scope.totalSegundoPlan = total;
							}
							$scope.finalMesesp2 = (range2.length);
						}
						// range2.push({
						// 	"fecha" : $scope.dateCf,
						// 	"pago" : i + 1,
						// 	"capital" : 88888,
						// 	"interes" : 99999,
						// 	"total" :33333,
						// 	"saldo" : 55555,//newSaldoTable
						// 	"pagoCapital": 0,
						// 	"disp": 6666,
						// });
						$scope.range2 = range2;
						// console.log(range2);

						// $scope.alphaNumeric = $scope.rangEd.concat($scope.range);
						// $scope.alphaNumeric = $scope.dani.concat($scope.range2);
						// $scope.alphaNumeric = $scope.range.concat($scope.range2);


						$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
						$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2);
						// console.log($scope.alphaNumeric);
						$scope.dtoptions = DTOptionsBuilder;
						$scope.dtColumns = [
							DTColumnBuilder.newColumn('fecha').withTitle('Fechas'),
							DTColumnBuilder.newColumn('pago').withTitle('Pago #'),
							DTColumnBuilder.newColumn('capital').withTitle('Capital').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('interes').withTitle('Intereses').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('total').withTitle('Total').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('saldo').withTitle('Saldo').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('pagoCapital').withTitle('Pago a Capital')
								.renderWith(
									function (data, type, full, meta) {
										// console.log($scope.alphaNumeric[full['pago']-1]['saldo']);
										if ($scope.alphaNumeric[full['pago'] - 1]['saldo'] <= 0) {
											$scope.alphaNumeric[full['pago'] - 1]['saldo'] = 0;
										}
										if ($scope.alphaNumeric[posicionPago - 1]['disp'] == 1 && $scope.alphaNumeric[posicionPago - 1]['pagoCapital'] != "" && full['pagoCapital'] != "")//
										{
											// console.log($scope.alphaNumeric[posicionPago-1]['pago']   +" "+	posicionPago);
											// console.log('Estoy llegando aquí');
											// return "$ " + saldo;
											var inputCapital = '<input name="capVal' + full["pago"] + '" type="number" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control" value="' + $scope.alphaNumeric[full['pago'] - 1]['pagoCapital'] + '" disabled>';
											var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
											return inputCapital + numberPay;
										} else {
											var inputCapital = '<input name="capVal' + full["pago"] + '" type="text" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control">';
											var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
											return inputCapital + numberPay;
										}
										// console.log($scope.alphaNumeric[posicionPago-1]['disp']	+	" "	+	$scope.alphaNumeric[posicionPago-1]['pagoCapital']);
									},
								),
						];

						$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
								{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
								{
									extend: 'print',
									text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
									titleAttr: 'Imprimir'
								},
								{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
								{
									extend: 'pdfHtml5',
									text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
									titleAttr: 'PDF',
									title: '',
									customize: function (doc) {
										//pageMargins [left, top, right, bottom]
										doc.pageMargins = [140, 40, 10, 50];
										doc.alignment = 'center';
									}
								},
							]
						).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
					}
				}

				/////////////////// TABLES X 10 A 20 AÑOS //////////////
				if ($scope.infoLote.meses >= 132 && $scope.infoLote.meses <= 240)
					// {
					// 	console.log('hanumaaa t vas a endeudar prro!');
					// 	if($scope.infoLote.mesesSinInteresP1 == 36)
					// 	{
					// 		for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++)
					// 		{
					// 			if(mes == 13){
					// 				mes = '01';
					// 				yearc++;
					// 			}
					// 			if(mes == 2){
					// 				mes = '02';
					// 			}
					// 			if(mes == 3){
					// 				mes = '03';
					// 			}
					// 			if(mes == 4){
					// 				mes = '04';
					// 			}
					// 			if(mes == 5){
					// 				mes = '05';
					// 			}
					// 			if(mes == 6){
					// 				mes = '06';
					// 			}
					// 			if(mes == 7){
					// 				mes = '07';
					// 			}
					// 			if(mes == 8){
					// 				mes = '08';
					// 			}
					// 			if(mes == 9){
					// 				mes = '09';
					// 			}
					// 			if(mes == 10){
					// 				mes = '10';
					// 			}
					// 			if(mes == 11){
					// 				mes = '11';
					// 			}
					// 			if(mes == 12){
					// 				mes = '12';
					// 			}
					//
					//
					// 			$scope.dateCf = day + '-' + mes + '-' + yearc;
					//
					// 			if(i == 0){
					// 				$scope.fechaPM = $scope.dateCf;
					// 			}
					//
					//
					// 			range.push({
					//
					// 				"fecha" : $scope.dateCf,
					// 				"pago" : i + 1,
					// 				"capital" : $scope.infoLote.capital,
					// 				"interes" : 0,
					// 				"total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
					// 				"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,
					// 				"pagoCapital"	:	"",
					// 			});
					// 			mes++;
					//
					// 			if (i == ($scope.infoLote.mesesSinInteresP1 - 1)){
					// 				$scope.total2 = $scope.infoLote.precioTotal;
					// 				$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;
					//
					//
					// 			}
					// 			ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
					// 			$scope.finalMesesp1 = (range.length);
					//
					// 		}
					// 		$scope.range= range;
					//
					// 		//////////
					//
					// 		$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);
					//
					// 		var range2=[];
					//
					// 		for (var i = ini2; i < 120; i++)
					// 		{
					// 			if(mes == 13){
					// 				mes = '01';
					// 				yearc++;
					// 			}
					// 			if(mes == 2){
					// 				mes = '02';
					// 			}
					// 			if(mes == 3){
					// 				mes = '03';
					// 			}
					// 			if(mes == 4){
					// 				mes = '04';
					// 			}
					// 			if(mes == 5){
					// 				mes = '05';
					// 			}
					// 			if(mes == 6){
					// 				mes = '06';
					// 			}
					// 			if(mes == 7){
					// 				mes = '07';
					// 			}
					// 			if(mes == 8){
					// 				mes = '08';
					// 			}
					// 			if(mes == 9){
					// 				mes = '09';
					// 			}
					// 			if(mes == 10){
					// 				mes = '10';
					// 			}
					// 			if(mes == 11){
					// 				mes = '11';
					// 			}
					// 			if(mes == 12){
					// 				mes = '12';
					// 			}
					//
					//
					// 			$scope.dateCf = day + '-' + mes + '-' + yearc;
					//
					//
					// 			$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
					// 			$scope.capital2 = ($scope.p2 - $scope.interes_plan2);
					//
					// 			range2.push({
					//
					// 				"fecha" : $scope.dateCf,
					// 				"pago" : i + 1,
					// 				"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
					// 				"interes" : ($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
					// 				"total" : $scope.p2,
					// 				"saldo" : ($scope.total2 = ($scope.total2 -$scope.capital2)),
					// 				"pagoCapital"	:	"",
					// 			});
					// 			mes++;
					//
					//
					// 			if (i == 119){
					// 				$scope.total3 = $scope.total2;
					// 				$scope.totalSegundoPlan = $scope.p2;
					//
					// 			}
					// 			$scope.finalMesesp2 = (range2.length);
					//
					// 		}
					// 		$scope.range2= range2;
					//
					//
					//
					// 		//////////
					//
					//
					//
					// 		$scope.p3 = ($scope.infoLote.interes_p3 *  Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120) * $scope.total3) / ( Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120)-1);
					//
					//
					// 		var range3=[];
					//
					// 		for (var i = 121; i < $scope.infoLote.meses + 1; i++)
					// 		{
					//
					// 			if(mes == 13){
					// 				mes = '01';
					// 				yearc++;
					// 			}
					//
					// 			if(mes == 2){
					// 				mes = '02';
					// 			}
					// 			if(mes == 3){
					// 				mes = '03';
					// 			}
					// 			if(mes == 4){
					// 				mes = '04';
					// 			}
					// 			if(mes == 5){
					// 				mes = '05';
					// 			}
					// 			if(mes == 6){
					// 				mes = '06';
					// 			}
					// 			if(mes == 7){
					// 				mes = '07';
					// 			}
					// 			if(mes == 8){
					// 				mes = '08';
					// 			}
					// 			if(mes == 9){
					// 				mes = '09';
					// 			}
					// 			if(mes == 10){
					// 				mes = '10';
					// 			}
					// 			if(mes == 11){
					// 				mes = '11';
					// 			}
					// 			if(mes == 12){
					// 				mes = '12';
					// 			}
					//
					// 			$scope.dateCf = day + '-' + mes + '-' + yearc;
					//
					//
					//
					// 			$scope.interes_plan3 = $scope.total3*($scope.infoLote.interes_p3);
					// 			$scope.capital2 = ($scope.p3 - $scope.interes_plan3);
					//
					// 			range3.push({
					//
					// 				"fecha" : $scope.dateCf,
					// 				"pago" : i,
					// 				"capital" : ($scope.capital2 = ($scope.p3 - $scope.interes_plan3)),
					// 				"interes" : ($scope.interes_plan3= ($scope.total3 * $scope.infoLote.interes_p3)),
					// 				"total" : $scope.p3,
					// 				"saldo" : ($scope.total3 = ($scope.total3 -$scope.capital2)),
					// 				"pagoCapital"	:	"",
					// 			});
					// 			mes++;
					//
					//
					// 			if (i == 122){
					// 				$scope.totalTercerPlan = $scope.p3;
					//
					// 			}
					// 			$scope.finalMesesp3 = (range3.length);
					//
					// 		}
					//
					// 		$scope.range3= range3;
					//
					// 		$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
					// 		$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2).concat($scope.range3);
					//
					// 		// $scope.alphaNumeric = $scope.range.concat($scope.range2).concat($scope.range3);
					//
					// 		$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
					// 				{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
					// 				{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
					// 				{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
					// 				{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
					// 						//pageMargins [left, top, right, bottom]
					// 						doc.pageMargins = [ 140, 40, 10, 50 ];
					// 						doc.alignment = 'center';
					//
					// 					}},
					// 			]
					// 		).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
					//
					//
					// 	}
					// }
				{
					var range=[];

					ini = ($scope.mesesdiferir > 0) ? $scope.mesesdiferir : $scope.infoLote.contadorInicial;

					if ($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <= 35   && $scope.noPagomensualidad == 1)
					{
						ini = $scope.infoLote.contadorInicial;
						if ($scope.noPagomensualidad == 1)
						{
							////////////////////////////////////////////////////////////////////////////////////
							var rangePlanc = [];
							for (var i = ini; i < 12; i++)
							{
								if ((mes == 13) || (mes == 14)) {
									if ($scope.descDate == 0) {
										if (mes == 13) {
											mes = '01';
											yearc++;
										} else if (mes == 14) {
											mes = '02';
											yearc++;
										}
									} else if ($scope.descDate == 1) {
										mes = '03';
										$scope.descDate = 0;
									}
								}
								if (mes == 2) {
									mes = '02';
								}
								if (mes == 3) {
									mes = '03';
								}
								if (mes == 4) {
									mes = '04';
								}
								if (mes == 5) {
									mes = '05';
								}
								if (mes == 6) {
									mes = '06';
								}
								if (mes == 7) {
									mes = '07';
								}
								if (mes == 8) {
									mes = '08';
								}
								if (mes == 9) {
									mes = '09';
								}
								if (mes == 10) {
									mes = '10';
								}
								if (mes == 11) {
									mes = '11';
								}
								if (mes == 12) {
									mes = '12';
								}

								$scope.dateCf = day + '-' + mes + '-' + yearc;

								if (i == 0) {
									$scope.fechaPM = $scope.dateCf;
								}
								var newSaldoTable = 0;
								var alphaOriginal = [];
								alphaOriginal = $scope.alphaNumeric;
								if ($scope.alphaNumeric[i]['disp'] != 1)
								{
									/*Para verfificar donde se puso el pago a capital*/
									var dispPC = 0;
									var vuelta = (i + 1);
									var posicionPago = (posPay + 1);
									if (vuelta == posicionPago)
									{
										if (posicionPago == 1)
										{
											/* Este if es para ver si se descuenta la primera posicion*/
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
											dispPC = 1;
											pagoACapitalCantidad = saldo;
										}
										else
										{/* Este else es para ver si se descuenta apartir de la segunda posicion*/
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
											dispPC = $scope.alphaNumeric[posPay]['dispPC'] = 1;
											pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
										}
									}
									else
									{
										/*Hace el calculo cuando es 0apartir de la segunda posición*/
										if ($scope.alphaNumeric[i]['disp'] == 0 || $scope.alphaNumeric[i]['disp'] == undefined)
										{
											//else despues del primer post en segunda posicion
											if ($scope.alphaNumeric[i]['pago'] >= posicionPago)
											{
												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'] - saldo;
												dispPC = 0;
												pagoACapitalCantidad = 0;
											}
											else if ($scope.alphaNumeric[i]['pago'] <= posicionPago)
											{
												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
												// dispPC = 0;
												dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
												pagoACapitalCantidad = 0;
											}
										}
										else
										{
											//else despues del primer post
											if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
												dispPC = 0;
												pagoACapitalCantidad = 0;

											} else if ($scope.alphaNumeric[i]['pago'] <= posicionPago) {

												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
												dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
												pagoACapitalCantidad = 0;
											}
										}
									}
									rangePlanc.push({
										"fecha": $scope.dateCf,
										"pago": i + 1,
										"capital": 0,
										"interes": 0,
										"total": 0,
										"saldo": newSaldoTable,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
										"pagoCapital": pagoACapitalCantidad,
										"disp": dispPC,
									});
								}
								else
								{
									/*Se coloca el valor anterior de donde se modificó, con el valor que trae por defecto en el areglo*/
									rangePlanc.push({
										"fecha": $scope.dateCf,
										"pago": i + 1,
										"capital": $scope.alphaNumeric[i]['capital'],
										"interes": 0,
										"total": $scope.alphaNumeric[i]['total'],
										"saldo": $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
										"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
										"disp": $scope.alphaNumeric[i]['disp'],
									});
								}
								mes++;
								$scope.finalMesesp1PlanC = rangePlanc.length;
								ini = rangePlanc.length;
							}
							$scope.rangePlanc = rangePlanc;
							////////////////////////////////////////////////////////////////////////////////////

							for (var i = ini; i <= $scope.infoLote.mesesSinInteresP1-1; i++)
							{
								if (mes == 13) {
									mes = '01';
									yearc++;
								}
								if (mes == 2) {
									mes = '02';
								}
								if (mes == 3) {
									mes = '03';
								}
								if (mes == 4) {
									mes = '04';
								}
								if (mes == 5) {
									mes = '05';
								}
								if (mes == 6) {
									mes = '06';
								}
								if (mes == 7) {
									mes = '07';
								}
								if (mes == 8) {
									mes = '08';
								}
								if (mes == 9) {
									mes = '09';
								}
								if (mes == 10) {
									mes = '10';
								}
								if (mes == 11) {
									mes = '11';
								}
								if (mes == 12) {
									mes = '12';
								}
								$scope.dateCf = day + '-' + mes + '-' + yearc;

								if (i == 0) {
									$scope.fechaPM = $scope.dateCf;
								}
								var newSaldoTable = 0;
								var alphaOriginal = [];
								alphaOriginal = $scope.alphaNumeric;
								if ($scope.alphaNumeric[i]['disp'] != 1) {
									/*Para verfificar donde se puso el pago a capital*/
									var dispPC = 0;
									var vuelta = (i + 1);
									var posicionPago = (posPay + 1);
									if (vuelta == posicionPago) {
										// console.log("se tiene que poner esto " + saldo + " en la posición: " + (posPay + 1));
										if (posicionPago == 1) {
											/* Este if es para ver si se descuenta la primera posicion*/
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
											dispPC = 1;
											pagoACapitalCantidad = saldo;
											// console.log('se desceunta de la primera posicion');
										} else {/* Este else es para ver si se descuenta apartir de la segunda posicion*/
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
											dispPC = $scope.alphaNumeric[posPay]['dispPC'] = 1;
											pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
											// console.log('se descuente de la posicion ' + i);
										}
									} else {
										/*Hace el calculo cuando es 0apartir de la segunda posición*/
										if ($scope.alphaNumeric[i]['disp'] == 0 || $scope.alphaNumeric[i]['disp'] == undefined) {
											//else despues del primer post en segunda posicion
											if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'] - saldo;
												dispPC = 0;
												pagoACapitalCantidad = 0;
											} else if ($scope.alphaNumeric[i]['pago'] <= posicionPago) {
												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
												// dispPC = 0;
												dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
												pagoACapitalCantidad = 0;
											}
										} else {
											if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
												dispPC = 0;
												pagoACapitalCantidad = 0;

											} else if ($scope.alphaNumeric[i]['pago'] <= posicionPago) {

												newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
												dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
												pagoACapitalCantidad = 0;
											}
										}
									}
									range.push({
										"fecha": $scope.dateCf,
										"pago": i + 1,
										"capital": $scope.infoLote.capital,
										"interes": 0,
										"total": $scope.infoLote.capital + $scope.infoLote.interes_p1,
										"saldo": newSaldoTable,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
										"pagoCapital": pagoACapitalCantidad,
										"disp": dispPC,
									});
								} else {
									/*Se coloca el valor anterior de donde se modificó, con el valor que trae por defecto en el areglo*/
									range.push({
										"fecha": $scope.dateCf,
										"pago": i + 1,
										"capital": $scope.alphaNumeric[i]['capital'],
										"interes": 0,
										"total": $scope.alphaNumeric[i]['total'],
										"saldo": $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
										"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
										"disp": $scope.alphaNumeric[i]['disp'],
									});
								}
								mes++;
								if (i == ($scope.infoLote.mesesSinInteresP1 - 1)) {
									$scope.total2 = $scope.infoLote.precioTotal;
									// alert($scope.total2);
									$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;
								}
								$scope.finalMesesp1 = range.length;
								ini2 = (range.length + rangePlanc.length);
							}
							$scope.range = range;
							//////////
							var range2 = [];
							//for (var i = ini2; i < ($scope.infoLote.meses + 12); i++)
							for (var i = ini2; i <  120; i++) {
								var f=f+1;
								if ((mes == 13) || (mes == 14)) {

									if (mes == 13) {

										mes = '01';
										yearc++;

									} else if (mes == 14) {

										mes = '02';
										yearc++;

									}

								}

								if (mes == 2) {
									mes = '02';
								}
								if (mes == 3) {
									mes = '03';
								}
								if (mes == 4) {
									mes = '04';
								}
								if (mes == 5) {
									mes = '05';
								}
								if (mes == 6) {
									mes = '06';
								}
								if (mes == 7) {
									mes = '07';
								}
								if (mes == 8) {
									mes = '08';
								}
								if (mes == 9) {
									mes = '09';
								}
								if (mes == 10) {
									mes = '10';
								}
								if (mes == 11) {
									mes = '11';
								}
								if (mes == 12) {
									mes = '12';
								}

								//nueva version 11Marzo20
								$scope.dateCf = day + '-' + mes + '-' + yearc;
								if (i == 0) {
									$scope.fechaPM = $scope.fechapago;
								}
								//nuevo codigo 21 FEB
								var interes = 0;
								var total = 0;
								var capital = 0;
								var newSaldoTable = 0;

								var alphaOriginal = [];
								alphaOriginal = $scope.alphaNumeric;

								if ($scope.alphaNumeric[i]['disp'] != 1) {
									var vuelta = (i + 1);
									var posicionPago = (posPay + 1);
									if (vuelta == posicionPago) {
										if (posicionPago == 1) {
											// console.log('primera posicion');
										}
										else {
											// console.log('Segunda posicion: ' + $scope.alphaNumeric[posPay]['saldo'] + 'pagocap: ' + saldo);
											capital = $scope.alphaNumeric[posPay]['capital'];
											newSaldoTable = $scope.total2 = $scope.alphaNumeric[posPay]['saldo'];//= nuevoSaldo;//saldo es el pago a capital (facepalm)
											dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
											pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
											interes = $scope.alphaNumeric[posPay]['interes'];//$scope.alphaNumeric[posPay]['saldo'] * $scope.infoLote.interes_p2
											total = $scope.alphaNumeric[posPay]['total'];//capital + interes
											$scope.alphaNumeric[posPay]['control'] = 1;
										}
									} else {
										// console.log('el total hasta este punto es de: ' + $scope.total2);

										if ($scope.alphaNumeric[posicionPago]['pagoCapital'] == 0 || $scope.alphaNumeric[posicionPago]['pagoCapital'] == undefined) {
											if (i < posicionPago) {
												capital = $scope.alphaNumeric[i]['capital'];
												newSaldoTable = $scope.alphaNumeric[i]['saldo'];//saldo es el pago a capital (facepalm)
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												interes = $scope.alphaNumeric[i]['interes'];
												total = $scope.alphaNumeric[i]['total'];
											} else {

												if ($scope.alphaNumeric[i]['disp'] == undefined || $scope.alphaNumeric[i]['disp'] == 0) {
													if (posicionPago < $scope.infoLote.msn) {
														var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
														parte1 = parte1;
														var parte2 = (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);
														parte2 = parte2;


														$scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo'] = $scope.infoLote.precioTotal;
														operacionCompleta = (($scope.infoLote.interes_p2 * parte1 * $scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo']) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
													} else //if(posicionPago>=$scope.infoLote.msn)
													{
														var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses -  ($scope.alphaNumeric[posPay]['pago']));//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
														parte1 = parte1;

														var parte2 = (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - ($scope.alphaNumeric[posPay]['pago'])) - 1);
														parte2 = parte2;

														operacionCompleta = (($scope.infoLote.interes_p2 * parte1 * $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2)) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
													}

													$scope.interes_plan2 = $scope.alphaNumeric[(i - 1)]['saldo'] * ($scope.infoLote.interes_p2);
													capital = operacionCompleta - $scope.interes_plan2;//($scope.capital2 =	 ($scope.p2 - $scope.interes_plan2))
													newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i)]['saldo'] = $scope.total2 - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
													dispPC = $scope.alphaNumeric[i]['disp'] = 0;
													pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
													total = operacionCompleta;//$scope.p2
													interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
													// console.log(i + " - " + $scope.alphaNumeric[(i - 1)]['saldo']);
												} else {
													// console.log($scope.alphaNumeric[i]['pago']);
													// console.log($scope.alphaNumeric[i]['saldo']);
													capital = $scope.capital2;
													newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i - 1)]['saldo'] - $scope.alphaNumeric[i]['pagoCapital'] - $scope.capital2;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
													dispPC = $scope.alphaNumeric[i]['disp'] = 0;
													pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
													interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
													total = $scope.p2;//$scope.p2
												}
												// console.log($scope.total2);
											}
										} else {
											if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago) {
												if ($scope.alphaNumeric[posicionPago]['disp'] == 1) {
													dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
													saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
													pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'];
												} else {//se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion
													dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
												}
											} else {
												//cuando se salta un espacio en la tabla
												saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
												total = 999999999999999;
											}
										}
									}
									// console.log("p2: " + $scope.p2);
									range2.push({
										"fecha": $scope.dateCf,
										"pago": i + 1,
										"capital": capital,
										"interes": interes,
										"total": total,
										"saldo": newSaldoTable,//newSaldoTable
										"pagoCapital": pagoACapitalCantidad,
										"disp": dispPC,
									});
								}
								else {
									range2.push({
										"fecha": $scope.dateCf,
										"pago": i + 1,
										"capital": $scope.alphaNumeric[i]['capital'],
										"interes": $scope.alphaNumeric[i]['interes'],
										"total": $scope.alphaNumeric[i]['total'],
										"saldo": $scope.alphaNumeric[i]['saldo'],//newSaldoTable
										"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
										"disp": $scope.alphaNumeric[i]['disp'],
									});
								}
								//se termina nueva parte
								mes++;

								if (i == 119) {
									$scope.total3 = $scope.total2;
									$scope.totalSegundoPlan = total;

								}
								$scope.finalMesesp2 = (range2.length);
							}
							$scope.range2 = range2;

							////////////////////////////
							var range3 = [];
							// console.log("Saldo para el tercer arreglo " + $scope.total2);
							for (var i = 120; i < $scope.infoLote.meses+12; i++) {//$scope.infoLote.meses + 1

								if ((mes == 13) || (mes == 14)) {

									if (mes == 13) {

										mes = '01';
										yearc++;

									} else if (mes == 14) {

										mes = '02';
										yearc++;

									}

								}

								if (mes == 2) {
									mes = '02';
								}
								if (mes == 3) {
									mes = '03';
								}
								if (mes == 4) {
									mes = '04';
								}
								if (mes == 5) {
									mes = '05';
								}
								if (mes == 6) {
									mes = '06';
								}
								if (mes == 7) {
									mes = '07';
								}
								if (mes == 8) {
									mes = '08';
								}
								if (mes == 9) {
									mes = '09';
								}
								if (mes == 10) {
									mes = '10';
								}
								if (mes == 11) {
									mes = '11';
								}
								if (mes == 12) {
									mes = '12';
								}

								//11marzo20
								// $scope.dateCf = day + '-' + mes + '-' + yearc;
								// $scope.interes_plan3 = $scope.total3*($scope.infoLote.interes_p3);
								// $scope.capital2 = ($scope.p3 - $scope.interes_plan3);
								// range3.push({
								//
								// 	"fecha" : $scope.dateCf,
								// 	"pago" : i,
								// 	"capital" : ($scope.capital2 = ($scope.p3 - $scope.interes_plan3)),
								// 	"interes" : ($scope.interes_plan3= ($scope.total3 * $scope.infoLote.interes_p3)),
								// 	"total" : $scope.p3,
								// 	"saldo" : ($scope.total3 = ($scope.total3 -$scope.capital2)),
								//
								// });
								//versioi a terior range3 11Marzo20

								//nueva versions 11Marzo20
								$scope.dateCf = day + '-' + mes + '-' + yearc;
								if (i == 0) {
									$scope.fechaPM = $scope.fechapago;
								}
								//nuevo codigo 21 FEB
								var interes = 0;
								var total = 0;
								var capital = 0;
								var newSaldoTable = 0;

								var alphaOriginal = [];
								alphaOriginal = $scope.alphaNumeric;

								// console.log($scope.alphaNumeric[i]['disp'] + " - " + i);

								if ($scope.alphaNumeric[i]['disp'] != 1) {
									var vuelta = (i + 1);
									var posicionPago = (posPay + 1);
									if (vuelta == posicionPago) {
										if (posicionPago == 1) {
											// console.log('primera posicion');
										}
										else {
											// console.log('Segunda posicion: ' + $scope.alphaNumeric[posPay]['saldo'] + 'pagocap: ' + saldo);
											capital = $scope.alphaNumeric[posPay]['capital'];
											newSaldoTable = $scope.total3 = $scope.alphaNumeric[posPay]['saldo'];//= nuevoSaldo;//saldo es el pago a capital (facepalm)
											dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
											pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
											interes = $scope.alphaNumeric[posPay]['interes'];//$scope.alphaNumeric[posPay]['saldo'] * $scope.infoLote.interes_p2
											total = $scope.alphaNumeric[posPay]['total'];//capital + interes
											$scope.alphaNumeric[posPay]['control'] = 1;
										}
									} else {
										// console.log('el total hasta este punto es de: ' + $scope.total2);

										if ($scope.alphaNumeric[posicionPago]['pagoCapital'] == 0 || $scope.alphaNumeric[posicionPago]['pagoCapital'] == undefined) {
											if (i < posicionPago) {
												capital = $scope.alphaNumeric[i]['capital'];
												newSaldoTable = $scope.alphaNumeric[i]['saldo'];//saldo es el pago a capital (facepalm)
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												interes = $scope.alphaNumeric[i]['interes'];
												total = $scope.alphaNumeric[i]['total'];
											} else {

												if ($scope.alphaNumeric[i]['disp'] == undefined || $scope.alphaNumeric[i]['disp'] == 0) {
													// if (posicionPago < 120) {
													if (posicionPago < 120) {
														var parte1 = Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
														parte1 = parte1;

														var parte2 = (Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses  -120) - 1);
														parte2 = parte2;


														//$scope.alphaNumeric[(119)]['saldo'] = $scope.total2;
														$scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo'] = $scope.total2;
														operacionCompleta = (($scope.infoLote.interes_p3 * parte1 * $scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo']) / parte2);//((0.01*($scope.alphaNumeric[
													}
													else //if(posicionPago>=$scope.infoLote.msn)
													{
														var parte1 = Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago']);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
														parte1 = parte1;

														var parte2 = (Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago']) - 1);
														parte2 = parte2;
														operacionCompleta = (($scope.infoLote.interes_p3 * parte1 * $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2)) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
													}

													// console.log("ALV: " + $scope.alphaNumeric[(i - 1)]['saldo']);
													capital = operacionCompleta - ($scope.alphaNumeric[(i - 1)]['saldo'] * ($scope.infoLote.interes_p3));//($scope.capital2 =	 ($scope.p2 - $scope.interes_plan2))
													// console.log("interes: " + $scope.interes_plan2);
													newSaldoTable = $scope.total3 = $scope.alphaNumeric[(i)]['saldo'] = $scope.total3 - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
													dispPC = $scope.alphaNumeric[i]['disp'] = 0;
													pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
													total = operacionCompleta;//$scope.p2 888888
													$scope.interes_plan3 = $scope.alphaNumeric[i]['interes'] = $scope.alphaNumeric[(i - 1)]['saldo'] * ($scope.infoLote.interes_p3);
													interes = $scope.interes_plan3;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												} else {
													// console.log($scope.alphaNumeric[i]['pago']);
													// console.log($scope.alphaNumeric[i]['saldo']);
													capital = $scope.capital3;
													newSaldoTable = $scope.total3 = $scope.alphaNumeric[(i - 1)]['saldo'] - $scope.alphaNumeric[i]['pagoCapital'] - $scope.capital3;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
													dispPC = $scope.alphaNumeric[i]['disp'] = 0;
													pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
													$scope.interes_plan3 = $scope.alphaNumeric[i]['interes'] = $scope.alphaNumeric[(i - 1)]['saldo'] * ($scope.infoLote.interes_p3);
													interes = $scope.interes_plan3;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
													total = $scope.p3;//$scope.p2
												}
												// console.log($scope.total2);
											}
										} else {
											if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago) {
												if ($scope.alphaNumeric[posicionPago]['disp'] == 1) {
													dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
													saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
													pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'];
												} else {//se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion
													dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
												}
											} else {
												//cuando se salta un espacio en la tabla
												saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
												total = 999999999999999;
											}
										}
									}
									// console.log("p2: " + $scope.p2);
									range3.push({
										"fecha": $scope.dateCf,
										"pago": i + 1,
										"capital": capital,
										"interes": interes,
										"total": total,
										"saldo": newSaldoTable,//newSaldoTable
										"pagoCapital": pagoACapitalCantidad,
										"disp": dispPC,
									});
								} else {
									range3.push({
										"fecha": $scope.dateCf,
										"pago": i + 1,
										"capital": $scope.alphaNumeric[i]['capital'],
										"interes": $scope.alphaNumeric[i]['interes'],
										"total": $scope.alphaNumeric[i]['total'],
										"saldo": $scope.alphaNumeric[i]['saldo'],//newSaldoTable
										"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
										"disp": $scope.alphaNumeric[i]['disp'],
									});
								}
								mes++;


								if (i == 122) {
									$scope.totalTercerPlan = total;

								}
								$scope.finalMesesp3 = (range3.length);

							}

							$scope.range3 = range3;

							$scope.alphaNumeric = $scope.rangePlanc.concat($scope.range).concat($scope.range2).concat($scope.range3);
							$scope.dtoptions = DTOptionsBuilder;
							$scope.dtColumns = [
								DTColumnBuilder.newColumn('fecha').withTitle('Fechas'),
								DTColumnBuilder.newColumn('pago').withTitle('Pago #'),
								DTColumnBuilder.newColumn('capital').withTitle('Capital').renderWith(function (data, type, full) {
									return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
								}),
								DTColumnBuilder.newColumn('interes').withTitle('Intereses').renderWith(function (data, type, full) {
									return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
								}),
								DTColumnBuilder.newColumn('total').withTitle('Total').renderWith(function (data, type, full) {
									return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
								}),
								DTColumnBuilder.newColumn('saldo').withTitle('Saldo').renderWith(function (data, type, full) {
									return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
								}),
								DTColumnBuilder.newColumn('pagoCapital').withTitle('Pago a Capital')
									.renderWith(
										function (data, type, full, meta) {
											// console.log($scope.alphaNumeric[full['pago']-1]['saldo']);
											if ($scope.alphaNumeric[full['pago'] - 1]['saldo'] <= 0) {
												$scope.alphaNumeric[full['pago'] - 1]['saldo'] = 0;
											}
											if ($scope.alphaNumeric[posicionPago - 1]['disp'] == 1 && $scope.alphaNumeric[posicionPago - 1]['pagoCapital'] != "" && full['pagoCapital'] != "")//
											{
												// console.log($scope.alphaNumeric[posicionPago-1]['pago']   +" "+	posicionPago);
												// console.log('Estoy llegando aquí');
												// return "$ " + saldo;
												var inputCapital = '<input name="capVal' + full["pago"] + '" type="number" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control" value="' + $scope.alphaNumeric[full['pago'] - 1]['pagoCapital'] + '" disabled>';
												var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
												return inputCapital + numberPay;
											} else {
												var inputCapital = '<input name="capVal' + full["pago"] + '" type="text" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control">';
												var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
												return inputCapital + numberPay;
											}
											// console.log($scope.alphaNumeric[posicionPago-1]['disp']	+	" "	+	$scope.alphaNumeric[posicionPago-1]['pagoCapital']);
										},
									),
							];
							$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
									{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
									{
										extend: 'print',
										text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
										titleAttr: 'Imprimir'
									},
									{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
									{
										extend: 'pdfHtml5',
										text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
										titleAttr: 'PDF',
										title: '',
										customize: function (doc) {
											//pageMargins [left, top, right, bottom]
											doc.pageMargins = [140, 40, 10, 50];
											doc.alignment = 'center';

										}
									},
								]
							).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
						}
					}
					if ($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <= 35   && $scope.noPagomensualidad == 0)
					{
						// console.log('entraste a la val II');
						$scope.infoLote.mesesSinInteresP1 = ($scope.mesesdiferir > 0) ? ($scope.infoLote.mesesSinInteresP1 + $scope.mesesdiferir) : ($scope.infoLote.mesesSinInteresP1);

						for (var i = ini; i <= $scope.infoLote.mesesSinInteresP1-1; i++) {
							if (mes == 13) {
								mes = '01';
								yearc++;
							}
							if (mes == 2) {
								mes = '02';
							}
							if (mes == 3) {
								mes = '03';
							}
							if (mes == 4) {
								mes = '04';
							}
							if (mes == 5) {
								mes = '05';
							}
							if (mes == 6) {
								mes = '06';
							}
							if (mes == 7) {
								mes = '07';
							}
							if (mes == 8) {
								mes = '08';
							}
							if (mes == 9) {
								mes = '09';
							}
							if (mes == 10) {
								mes = '10';
							}
							if (mes == 11) {
								mes = '11';
							}
							if (mes == 12) {
								mes = '12';
							}
							$scope.dateCf = day + '-' + mes + '-' + yearc;

							if (i == 0) {
								$scope.fechaPM = $scope.dateCf;
							}
							var newSaldoTable = 0;
							var alphaOriginal = [];
							alphaOriginal = $scope.alphaNumeric;
							if ($scope.alphaNumeric[i]['disp'] != 1) {
								/*Para verfificar donde se puso el pago a capital*/
								var dispPC = 0;
								var vuelta = (i + 1);
								var posicionPago = (posPay + 1);
								if (vuelta == posicionPago) {
									// console.log("se tiene que poner esto " + saldo + " en la posición: " + (posPay + 1));
									if (posicionPago == 1) {
										/* Este if es para ver si se descuenta la primera posicion*/
										newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
										dispPC = 1;
										pagoACapitalCantidad = saldo;
										// console.log('se desceunta de la primera posicion');
									} else {/* Este else es para ver si se descuenta apartir de la segunda posicion*/
										newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
										dispPC = $scope.alphaNumeric[posPay]['dispPC'] = 1;
										pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
										// console.log('se descuente de la posicion ' + i);
									}
								} else {
									/*Hace el calculo cuando es 0apartir de la segunda posición*/
									if ($scope.alphaNumeric[i]['disp'] == 0 || $scope.alphaNumeric[i]['disp'] == undefined) {
										//else despues del primer post en segunda posicion
										if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'] - saldo;
											dispPC = 0;
											pagoACapitalCantidad = 0;
										} else if ($scope.alphaNumeric[i]['pago'] <= posicionPago) {
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
											// dispPC = 0;
											dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
											pagoACapitalCantidad = 0;
										}
									} else {
										if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
											dispPC = 0;
											pagoACapitalCantidad = 0;

										} else if ($scope.alphaNumeric[i]['pago'] <= posicionPago) {

											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
											dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
											pagoACapitalCantidad = 0;
										}
									}
								}
								range.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.infoLote.capital,
									"interes": 0,
									"total": $scope.infoLote.capital + $scope.infoLote.interes_p1,
									"saldo": newSaldoTable,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
									"pagoCapital": pagoACapitalCantidad,
									"disp": dispPC,
								});
							} else {
								/*Se coloca el valor anterior de donde se modificó, con el valor que trae por defecto en el areglo*/
								range.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.alphaNumeric[i]['capital'],
									"interes": 0,
									"total": $scope.alphaNumeric[i]['total'],
									"saldo": $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
									"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
									"disp": $scope.alphaNumeric[i]['disp'],
								});
							}
							mes++;
							if (i == ($scope.infoLote.mesesSinInteresP1 - 1)) {
								$scope.total2 = $scope.infoLote.precioTotal;
								// alert($scope.total2);
								$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;
							}
							$scope.finalMesesp1 = range.length;
							ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
						}
						$scope.range = range;

						/////////////
						// 	$scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.infoLote.precioTotal)
						// 		/ (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);
						var range2 = [];
						// console.log("Saldo para el segundo arreglo " + ini2);
						// var range2 = [];
						var f=0;
						for (var i = ini2; i <  120; i++) {
							var f=f+1;
							if ((mes == 13) || (mes == 14)) {

								if (mes == 13) {

									mes = '01';
									yearc++;

								} else if (mes == 14) {

									mes = '02';
									yearc++;

								}

							}

							if (mes == 2) {
								mes = '02';
							}
							if (mes == 3) {
								mes = '03';
							}
							if (mes == 4) {
								mes = '04';
							}
							if (mes == 5) {
								mes = '05';
							}
							if (mes == 6) {
								mes = '06';
							}
							if (mes == 7) {
								mes = '07';
							}
							if (mes == 8) {
								mes = '08';
							}
							if (mes == 9) {
								mes = '09';
							}
							if (mes == 10) {
								mes = '10';
							}
							if (mes == 11) {
								mes = '11';
							}
							if (mes == 12) {
								mes = '12';
							}

							//nueva version 11Marzo20
							$scope.dateCf = day + '-' + mes + '-' + yearc;
							if (i == 0) {
								$scope.fechaPM = $scope.fechapago;
							}
							//nuevo codigo 21 FEB
							var interes = 0;
							var total = 0;
							var capital = 0;
							var newSaldoTable = 0;

							var alphaOriginal = [];
							alphaOriginal = $scope.alphaNumeric;

							if ($scope.alphaNumeric[i]['disp'] != 1) {
								var vuelta = (i + 1);
								var posicionPago = (posPay + 1);
								if (vuelta == posicionPago) {
									if (posicionPago == 1) {
										// console.log('primera posicion');
									}
									else {
										// console.log('Segunda posicion: ' + $scope.alphaNumeric[posPay]['saldo'] + 'pagocap: ' + saldo);
										capital = $scope.alphaNumeric[posPay]['capital'];
										newSaldoTable = $scope.total2 = $scope.alphaNumeric[posPay]['saldo'];//= nuevoSaldo;//saldo es el pago a capital (facepalm)
										dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
										pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
										interes = $scope.alphaNumeric[posPay]['interes'];//$scope.alphaNumeric[posPay]['saldo'] * $scope.infoLote.interes_p2
										total = $scope.alphaNumeric[posPay]['total'];//capital + interes
										$scope.alphaNumeric[posPay]['control'] = 1;
									}
								} else {
									// console.log('el total hasta este punto es de: ' + $scope.total2);

									if ($scope.alphaNumeric[posicionPago]['pagoCapital'] == 0 || $scope.alphaNumeric[posicionPago]['pagoCapital'] == undefined) {
										if (i < posicionPago) {
											capital = $scope.alphaNumeric[i]['capital'];
											newSaldoTable = $scope.alphaNumeric[i]['saldo'];//saldo es el pago a capital (facepalm)
											dispPC = $scope.alphaNumeric[i]['disp'] = 0;
											pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
											interes = $scope.alphaNumeric[i]['interes'];
											total = $scope.alphaNumeric[i]['total'];
										} else {

											if ($scope.alphaNumeric[i]['disp'] == undefined || $scope.alphaNumeric[i]['disp'] == 0) {
												if (posicionPago < $scope.infoLote.msn) {
													var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
													parte1 = parte1;
													var parte2 = (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);
													parte2 = parte2;


													$scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo'] = $scope.infoLote.precioTotal;
													operacionCompleta = (($scope.infoLote.interes_p2 * parte1 * $scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo']) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
												} else //if(posicionPago>=$scope.infoLote.msn)
												{
													var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses -  ($scope.alphaNumeric[posPay]['pago']));//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
													parte1 = parte1;

													var parte2 = (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - ($scope.alphaNumeric[posPay]['pago'])) - 1);
													parte2 = parte2;

													operacionCompleta = (($scope.infoLote.interes_p2 * parte1 * $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2)) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
												}

												$scope.interes_plan2 = $scope.alphaNumeric[(i - 1)]['saldo'] * ($scope.infoLote.interes_p2);
												capital = operacionCompleta - $scope.interes_plan2;//($scope.capital2 =	 ($scope.p2 - $scope.interes_plan2))
												newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i)]['saldo'] = $scope.total2 - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												total = operacionCompleta;//$scope.p2
												interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												// console.log(i + " - " + $scope.alphaNumeric[(i - 1)]['saldo']);
											} else {
												// console.log($scope.alphaNumeric[i]['pago']);
												// console.log($scope.alphaNumeric[i]['saldo']);
												capital = $scope.capital2;
												newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i - 1)]['saldo'] - $scope.alphaNumeric[i]['pagoCapital'] - $scope.capital2;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												total = $scope.p2;//$scope.p2
											}
											// console.log($scope.total2);
										}
									} else {
										if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago) {
											if ($scope.alphaNumeric[posicionPago]['disp'] == 1) {
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
												saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'];
											} else {//se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
											}
										} else {
											//cuando se salta un espacio en la tabla
											saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
											total = 999999999999999;
										}
									}
								}
								// console.log("p2: " + $scope.p2);
								range2.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": capital,
									"interes": interes,
									"total": total,
									"saldo": newSaldoTable,//newSaldoTable
									"pagoCapital": pagoACapitalCantidad,
									"disp": dispPC,
								});
							}
							else {
								range2.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.alphaNumeric[i]['capital'],
									"interes": $scope.alphaNumeric[i]['interes'],
									"total": $scope.alphaNumeric[i]['total'],
									"saldo": $scope.alphaNumeric[i]['saldo'],//newSaldoTable
									"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
									"disp": $scope.alphaNumeric[i]['disp'],
								});
							}
							//se termina nueva parte
							mes++;

							if (i == 119) {
								$scope.total3 = $scope.total2;
								$scope.totalSegundoPlan = total;

							}
							// console.log(total);
							$scope.finalMesesp2 = (range2.length);
						}
						// console.log('aqui termina este pedo: ' + i);
						$scope.range2 = range2;


						//////////

						// $scope.p3 = ($scope.infoLote.interes_p3 * Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120) * $scope.total3) / (Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120) - 1);

						var range3 = [];
						// console.log("Saldo para el tercer arreglo " + $scope.total2);
						for (var i = 120; i < $scope.infoLote.meses; i++) {//$scope.infoLote.meses + 1

							if ((mes == 13) || (mes == 14)) {

								if (mes == 13) {

									mes = '01';
									yearc++;

								} else if (mes == 14) {

									mes = '02';
									yearc++;

								}

							}

							if (mes == 2) {
								mes = '02';
							}
							if (mes == 3) {
								mes = '03';
							}
							if (mes == 4) {
								mes = '04';
							}
							if (mes == 5) {
								mes = '05';
							}
							if (mes == 6) {
								mes = '06';
							}
							if (mes == 7) {
								mes = '07';
							}
							if (mes == 8) {
								mes = '08';
							}
							if (mes == 9) {
								mes = '09';
							}
							if (mes == 10) {
								mes = '10';
							}
							if (mes == 11) {
								mes = '11';
							}
							if (mes == 12) {
								mes = '12';
							}

							//11marzo20
							// $scope.dateCf = day + '-' + mes + '-' + yearc;
							// $scope.interes_plan3 = $scope.total3*($scope.infoLote.interes_p3);
							// $scope.capital2 = ($scope.p3 - $scope.interes_plan3);
							// range3.push({
							//
							// 	"fecha" : $scope.dateCf,
							// 	"pago" : i,
							// 	"capital" : ($scope.capital2 = ($scope.p3 - $scope.interes_plan3)),
							// 	"interes" : ($scope.interes_plan3= ($scope.total3 * $scope.infoLote.interes_p3)),
							// 	"total" : $scope.p3,
							// 	"saldo" : ($scope.total3 = ($scope.total3 -$scope.capital2)),
							//
							// });
							//versioi a terior range3 11Marzo20

							//nueva versions 11Marzo20
							$scope.dateCf = day + '-' + mes + '-' + yearc;
							if (i == 0) {
								$scope.fechaPM = $scope.fechapago;
							}
							//nuevo codigo 21 FEB
							var interes = 0;
							var total = 0;
							var capital = 0;
							var newSaldoTable = 0;

							var alphaOriginal = [];
							alphaOriginal = $scope.alphaNumeric;

							// console.log($scope.alphaNumeric[i]['disp'] + " - " + i);

							if ($scope.alphaNumeric[i]['disp'] != 1) {
								var vuelta = (i + 1);
								var posicionPago = (posPay + 1);
								if (vuelta == posicionPago) {
									if (posicionPago == 1) {
										// console.log('primera posicion');
									}
									else {
										// console.log('Segunda posicion: ' + $scope.alphaNumeric[posPay]['saldo'] + 'pagocap: ' + saldo);
										capital = $scope.alphaNumeric[posPay]['capital'];
										newSaldoTable = $scope.total3 = $scope.alphaNumeric[posPay]['saldo'];//= nuevoSaldo;//saldo es el pago a capital (facepalm)
										dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
										pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
										interes = $scope.alphaNumeric[posPay]['interes'];//$scope.alphaNumeric[posPay]['saldo'] * $scope.infoLote.interes_p2
										total = $scope.alphaNumeric[posPay]['total'];//capital + interes
										$scope.alphaNumeric[posPay]['control'] = 1;
									}
								} else {
									// console.log('el total hasta este punto es de: ' + $scope.total2);

									if ($scope.alphaNumeric[posicionPago]['pagoCapital'] == 0 || $scope.alphaNumeric[posicionPago]['pagoCapital'] == undefined) {
										if (i < posicionPago) {
											capital = $scope.alphaNumeric[i]['capital'];
											newSaldoTable = $scope.alphaNumeric[i]['saldo'];//saldo es el pago a capital (facepalm)
											dispPC = $scope.alphaNumeric[i]['disp'] = 0;
											pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
											interes = $scope.alphaNumeric[i]['interes'];
											total = $scope.alphaNumeric[i]['total'];
										} else {

											if ($scope.alphaNumeric[i]['disp'] == undefined || $scope.alphaNumeric[i]['disp'] == 0) {
												// if (posicionPago < 120) {
												if (posicionPago < 120) {
													var parte1 = Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
													parte1 = parte1;

													var parte2 = (Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses  -120) - 1);
													parte2 = parte2;


													//$scope.alphaNumeric[(119)]['saldo'] = $scope.total2;
													$scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo'] = $scope.total2;
													operacionCompleta = (($scope.infoLote.interes_p3 * parte1 * $scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo']) / parte2);//((0.01*($scope.alphaNumeric[
												}
												else //if(posicionPago>=$scope.infoLote.msn)
												{
													var parte1 = Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago']);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
													parte1 = parte1;

													var parte2 = (Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago']) - 1);
													parte2 = parte2;
													operacionCompleta = (($scope.infoLote.interes_p3 * parte1 * $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2)) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
												}

												// console.log("ALV: " + $scope.alphaNumeric[(i - 1)]['saldo']);
												capital = operacionCompleta - ($scope.alphaNumeric[(i - 1)]['saldo'] * ($scope.infoLote.interes_p3));//($scope.capital2 =	 ($scope.p2 - $scope.interes_plan2))
												// console.log("interes: " + $scope.interes_plan2);
												newSaldoTable = $scope.total3 = $scope.alphaNumeric[(i)]['saldo'] = $scope.total3 - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												total = operacionCompleta;//$scope.p2 888888
												$scope.interes_plan3 = $scope.alphaNumeric[i]['interes'] = $scope.alphaNumeric[(i - 1)]['saldo'] * ($scope.infoLote.interes_p3);
												interes = $scope.interes_plan3;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
											} else {
												// console.log($scope.alphaNumeric[i]['pago']);
												// console.log($scope.alphaNumeric[i]['saldo']);
												capital = $scope.capital3;
												newSaldoTable = $scope.total3 = $scope.alphaNumeric[(i - 1)]['saldo'] - $scope.alphaNumeric[i]['pagoCapital'] - $scope.capital3;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												$scope.interes_plan3 = $scope.alphaNumeric[i]['interes'] = $scope.alphaNumeric[(i - 1)]['saldo'] * ($scope.infoLote.interes_p3);
												interes = $scope.interes_plan3;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												total = $scope.p3;//$scope.p2
											}
											// console.log($scope.total2);
										}
									} else {
										if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago) {
											if ($scope.alphaNumeric[posicionPago]['disp'] == 1) {
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
												saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'];
											} else {//se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
											}
										} else {
											//cuando se salta un espacio en la tabla
											saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
											total = 999999999999999;
										}
									}
								}
								// console.log("p2: " + $scope.p2);
								range3.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": capital,
									"interes": interes,
									"total": total,
									"saldo": newSaldoTable,//newSaldoTable
									"pagoCapital": pagoACapitalCantidad,
									"disp": dispPC,
								});
							} else {
								range3.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.alphaNumeric[i]['capital'],
									"interes": $scope.alphaNumeric[i]['interes'],
									"total": $scope.alphaNumeric[i]['total'],
									"saldo": $scope.alphaNumeric[i]['saldo'],//newSaldoTable
									"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
									"disp": $scope.alphaNumeric[i]['disp'],
								});
							}
							mes++;



							if (i == 122) {
								$scope.totalTercerPlan = total;
							}
							// console.log(total);
							$scope.finalMesesp3 = (range3.length);

						}

						$scope.range3 = range3;


						$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
						$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2).concat($scope.range3);

						//$scope.alphaNumeric = $scope.range2.concat($scope.range3);

						$scope.dtoptions = DTOptionsBuilder;
						$scope.dtColumns = [
							DTColumnBuilder.newColumn('fecha').withTitle('Fechas'),
							DTColumnBuilder.newColumn('pago').withTitle('Pago #'),
							DTColumnBuilder.newColumn('capital').withTitle('Capital').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('interes').withTitle('Intereses').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('total').withTitle('Total').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('saldo').withTitle('Saldo').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('pagoCapital').withTitle('Pago a Capital')
								.renderWith(
									function (data, type, full, meta) {
										// console.log($scope.alphaNumeric[full['pago']-1]['saldo']);
										if ($scope.alphaNumeric[full['pago'] - 1]['saldo'] <= 0) {
											$scope.alphaNumeric[full['pago'] - 1]['saldo'] = 0;
										}
										if ($scope.alphaNumeric[posicionPago - 1]['disp'] == 1 && $scope.alphaNumeric[posicionPago - 1]['pagoCapital'] != "" && full['pagoCapital'] != "")//
										{
											// console.log($scope.alphaNumeric[posicionPago-1]['pago']   +" "+	posicionPago);
											// console.log('Estoy llegando aquí');
											// return "$ " + saldo;
											var inputCapital = '<input name="capVal' + full["pago"] + '" type="number" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control" value="' + $scope.alphaNumeric[full['pago'] - 1]['pagoCapital'] + '" disabled>';
											var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
											return inputCapital + numberPay;
										} else {
											var inputCapital = '<input name="capVal' + full["pago"] + '" type="text" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control">';
											var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
											return inputCapital + numberPay;
										}
										// console.log($scope.alphaNumeric[posicionPago-1]['disp']	+	" "	+	$scope.alphaNumeric[posicionPago-1]['pagoCapital']);
									},
								),
						];

						$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
								{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
								{
									extend: 'print',
									text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
									titleAttr: 'Imprimir'
								},
								{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
								{
									extend: 'pdfHtml5',
									text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
									titleAttr: 'PDF',
									title: '',
									customize: function (doc) {
										//pageMargins [left, top, right, bottom]
										doc.pageMargins = [140, 40, 10, 50];
										doc.alignment = 'center';

									}
								},
							]
						).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});


					}
					if ($scope.infoLote.mesesSinInteresP1 == 0)
					{
						$scope.infoLote.mesesSinInteresP1 = ($scope.mesesdiferir > 0) ? ($scope.infoLote.mesesSinInteresP1 + $scope.mesesdiferir) : ($scope.infoLote.mesesSinInteresP1);

						$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.infoLote.precioTotal)
							/ ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);

						var range2=[];

						for (var i = ini; i < 120; i++) {

							if( (mes == 13) || (mes == 14) ){

								if(mes == 13){

									mes = '01';
									yearc++;

								} else if (mes == 14) {

									mes = '02';
									yearc++;

								}

							}

							if(mes == 2){
								mes = '02';
							}
							if(mes == 3){
								mes = '03';
							}
							if(mes == 4){
								mes = '04';
							}
							if(mes == 5){
								mes = '05';
							}
							if(mes == 6){
								mes = '06';
							}
							if(mes == 7){
								mes = '07';
							}
							if(mes == 8){
								mes = '08';
							}
							if(mes == 9){
								mes = '09';
							}
							if(mes == 10){
								mes = '10';
							}
							if(mes == 11){
								mes = '11';
							}
							if(mes == 12){
								mes = '12';
							}

							//nueva version 11Marzo20
							$scope.dateCf = day + '-' + mes + '-' + yearc;
							if (i == 0) {
								$scope.fechaPM = $scope.fechapago;
							}
							//nuevo codigo 21 FEB
							var interes = 0;
							var total = 0;
							var capital = 0;
							var newSaldoTable = 0;

							var alphaOriginal = [];
							alphaOriginal = $scope.alphaNumeric;

							if ($scope.alphaNumeric[i]['disp'] != 1)
							{
								var vuelta = (i + 1);
								var posicionPago = (posPay + 1);
								if (vuelta == posicionPago)
								{
									if (posicionPago == 1)
									{
										console.log('primera posicion');
									}
									else
									{
										// console.log('Segunda posicion: ' + $scope.alphaNumeric[posPay]['saldo'] + 'pagocap: ' + saldo);
										capital = $scope.alphaNumeric[posPay]['capital'];
										newSaldoTable = $scope.total2 = $scope.alphaNumeric[posPay]['saldo'];//= nuevoSaldo;//saldo es el pago a capital (facepalm)
										dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
										pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
										interes = $scope.alphaNumeric[posPay]['interes'];//$scope.alphaNumeric[posPay]['saldo'] * $scope.infoLote.interes_p2
										total = $scope.alphaNumeric[posPay]['total'];//capital + interes
										$scope.alphaNumeric[posPay]['control'] = 1;
									}
								}
								else
								{
									// console.log('el total hasta este punto es de: ' + $scope.total2);

									if ($scope.alphaNumeric[posicionPago]['pagoCapital'] == 0 || $scope.alphaNumeric[posicionPago]['pagoCapital']==undefined)
									{
										if (i < posicionPago)
										{
											capital = $scope.alphaNumeric[i]['capital'];
											newSaldoTable = $scope.alphaNumeric[i]['saldo'];//saldo es el pago a capital (facepalm)
											dispPC = $scope.alphaNumeric[i]['disp'] = 0;
											pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
											interes = $scope.alphaNumeric[i]['interes'];
											total = $scope.alphaNumeric[i]['total'];
										}
										else
										{

											if ($scope.alphaNumeric[i]['disp'] == undefined || $scope.alphaNumeric[i]['disp'] == 0) {
												// A1 pones Tasa (tipo de interes del periodo)
												// en B1 el nPer  (número de Periodos)
												// en C1 el Va  (Capital inicial)
												// (A1*(1+A1)^B1)*C1/(((1+A1)^B1)-1)
												//(0.01 * (1+0.1)^84*191,520.00/(((1+A1)^84)-1)

												// var mesesAlv=posPay - $scope.alphaNumeric.length;
												// console.log("Total II: " + $scope.total2);

												if (posicionPago < $scope.infoLote.msn)
												{
													var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
													parte1 = parte1;

													var parte2 = (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);
													parte2 = parte2;


													$scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo'] = $scope.infoLote.precioTotal;

													operacionCompleta = (($scope.infoLote.interes_p2 * parte1 * $scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo']) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
													// console.log(parte2 + " - " + $scope.alphaNumeric[($scope.infoLote.msn-1)]['saldo']);
												} else //if(posicionPago>=$scope.infoLote.msn)
												{
													var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago']);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
													parte1 = parte1;

													var parte2 = (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago']) - 1);
													parte2 = parte2;
													// console.log(0);
													// console.log(posPay + " - " + posicionPago);
													operacionCompleta = (($scope.infoLote.interes_p2 * parte1 * $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2)) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
													// console.log(parte2 + " - " + $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2));
												}

												$scope.interes_plan2 = $scope.alphaNumeric[(i - 1)]['saldo'] * ($scope.infoLote.interes_p2);


												capital = operacionCompleta - $scope.interes_plan2;//($scope.capital2 =	 ($scope.p2 - $scope.interes_plan2))
												// console.log("interes: " + $scope.interes_plan2);
												newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i)]['saldo'] = $scope.total2 - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												total = operacionCompleta;//$scope.p2
												interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2

												// console.log(i + " - " + $scope.alphaNumeric[(i - 1)]['saldo']);
											} else {
												console.log($scope.alphaNumeric[i]['pago']);
												console.log($scope.alphaNumeric[i]['saldo']);
												capital = $scope.capital2;
												newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i - 1)]['saldo'] - $scope.alphaNumeric[i]['pagoCapital'] - $scope.capital2;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												total = $scope.p2;//$scope.p2
											}
											// console.log($scope.total2);
										}
									}
									else
									{
										if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago) {
											if ($scope.alphaNumeric[posicionPago]['disp'] == 1) {
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
												saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'];
											} else {//se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
											}
										} else {
											//cuando se salta un espacio en la tabla
											saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
											total = 999999999999999;
										}
									}
								}
								// console.log("p2: " + $scope.p2);
								range2.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": capital,
									"interes": interes,
									"total": total,
									"saldo": newSaldoTable,//newSaldoTable
									"pagoCapital": pagoACapitalCantidad,
									"disp": dispPC,
								});
							}
							else
							{
								range2.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.alphaNumeric[i]['capital'],
									"interes": $scope.alphaNumeric[i]['interes'],
									"total": $scope.alphaNumeric[i]['total'],
									"saldo": $scope.alphaNumeric[i]['saldo'],//newSaldoTable
									"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
									"disp": $scope.alphaNumeric[i]['disp'],
								});
							}
							//se termina nueva parte
							mes++;

							if (i == 119){
								$scope.total3 = $scope.total2;
								$scope.totalSegundoPlan = total;

							}
							$scope.finalMesesp2 = (range2.length);

						}
						// console.log('aqui termina este pedo: ' + i);
						$scope.range2= range2;



						//////////

						$scope.p3 = ($scope.infoLote.interes_p3 *  Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120) * $scope.total3) / ( Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120)-1);

						var range3=[];
						for (var i = 120; i < $scope.infoLote.meses ; i++) {//$scope.infoLote.meses + 1

							if( (mes == 13) || (mes == 14) ){

								if(mes == 13){

									mes = '01';
									yearc++;

								} else if (mes == 14) {

									mes = '02';
									yearc++;

								}

							}

							if(mes == 2){
								mes = '02';
							}
							if(mes == 3){
								mes = '03';
							}
							if(mes == 4){
								mes = '04';
							}
							if(mes == 5){
								mes = '05';
							}
							if(mes == 6){
								mes = '06';
							}
							if(mes == 7){
								mes = '07';
							}
							if(mes == 8){
								mes = '08';
							}
							if(mes == 9){
								mes = '09';
							}
							if(mes == 10){
								mes = '10';
							}
							if(mes == 11){
								mes = '11';
							}
							if(mes == 12){
								mes = '12';
							}

							//11marzo20
							// $scope.dateCf = day + '-' + mes + '-' + yearc;
							// $scope.interes_plan3 = $scope.total3*($scope.infoLote.interes_p3);
							// $scope.capital2 = ($scope.p3 - $scope.interes_plan3);
							// range3.push({
							//
							// 	"fecha" : $scope.dateCf,
							// 	"pago" : i,
							// 	"capital" : ($scope.capital2 = ($scope.p3 - $scope.interes_plan3)),
							// 	"interes" : ($scope.interes_plan3= ($scope.total3 * $scope.infoLote.interes_p3)),
							// 	"total" : $scope.p3,
							// 	"saldo" : ($scope.total3 = ($scope.total3 -$scope.capital2)),
							//
							// });
							//versioi a terior range3 11Marzo20

							//nueva versions 11Marzo20
							$scope.dateCf = day + '-' + mes + '-' + yearc;
							if (i == 0) {
								$scope.fechaPM = $scope.fechapago;
							}
							//nuevo codigo 21 FEB
							var interes = 0;
							var total = 0;
							var capital = 0;
							var newSaldoTable = 0;

							var alphaOriginal = [];
							alphaOriginal = $scope.alphaNumeric;

							// console.log($scope.alphaNumeric[i]['disp'] + " - " + i);

							if ($scope.alphaNumeric[i]['disp'] != 1 )
							{
								var vuelta = (i + 1);
								var posicionPago = (posPay + 1);
								if (vuelta == posicionPago)
								{
									if (posicionPago == 1)
									{
										// console.log('primera posicion');
									}
									else
									{
										// console.log('Segunda posicion: ' + $scope.alphaNumeric[posPay]['saldo'] + 'pagocap: ' + saldo);
										capital = $scope.alphaNumeric[posPay]['capital'];
										newSaldoTable = $scope.total3 = $scope.alphaNumeric[posPay]['saldo'];//= nuevoSaldo;//saldo es el pago a capital (facepalm)
										dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
										pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
										interes = $scope.alphaNumeric[posPay]['interes'];//$scope.alphaNumeric[posPay]['saldo'] * $scope.infoLote.interes_p2
										total = $scope.alphaNumeric[posPay]['total'];//capital + interes
										$scope.alphaNumeric[posPay]['control'] = 1;
									}
								}
								else
								{
									// console.log('el total hasta este punto es de: ' + $scope.total2);

									if ($scope.alphaNumeric[posicionPago]['pagoCapital'] == 0 || $scope.alphaNumeric[posicionPago]['pagoCapital']==undefined)
									{
										if (i < posicionPago)
										{
											capital = $scope.alphaNumeric[i]['capital'];
											newSaldoTable = $scope.alphaNumeric[i]['saldo'];//saldo es el pago a capital (facepalm)
											dispPC = $scope.alphaNumeric[i]['disp'] = 0;
											pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
											interes = $scope.alphaNumeric[i]['interes'];
											total = $scope.alphaNumeric[i]['total'];
										}
										else
										{

											if ($scope.alphaNumeric[i]['disp'] == undefined || $scope.alphaNumeric[i]['disp'] == 0) {
												// A1 pones Tasa (tipo de interes del periodo)
												// en B1 el nPer  (número de Periodos)
												// en C1 el Va  (Capital inicial)
												// (A1*(1+A1)^B1)*C1/(((1+A1)^B1)-1)
												//(0.01 * (1+0.1)^84*191,520.00/(((1+A1)^84)-1)

												// var mesesAlv=posPay - $scope.alphaNumeric.length;
												// console.log("Total II: " + $scope.total2);


												if (posicionPago < 120)
												{
													var parte1 = Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
													parte1 = parte1;

													var parte2 = (Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120) - 1);
													parte2 = parte2;

													// console.log($scope.total2);
													$scope.alphaNumeric[(119)]['saldo'] = $scope.total2;

													operacionCompleta = $scope.infoLote.precioTotal = (($scope.infoLote.interes_p3 * parte1 * $scope.alphaNumeric[(119)]['saldo']) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
													// console.log(parte2 + " - " + $scope.alphaNumeric[($scope.infoLote.msn-1)]['saldo']);
													// console.log(i + " - " + $scope.infoLote.precioTotal);
													// console.log($scope.alphaNumeric[(120)]['saldo']);
												}
												else //if(posicionPago>=$scope.infoLote.msn)
												{
													var parte1 = Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago']);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
													parte1 = parte1;

													var parte2 = (Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago']) - 1);
													parte2 = parte2;
													// console.log(0);
													// console.log(posPay + " - " + posicionPago);
													operacionCompleta = (($scope.infoLote.interes_p3 * parte1 * $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2)) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
													// console.log(parte2 + " - " + $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2));
													// console.log('alv');
												}

												capital = operacionCompleta - ($scope.alphaNumeric[(i-1)]['saldo'] * ($scope.infoLote.interes_p3));//($scope.capital2 =	 ($scope.p2 - $scope.interes_plan2))
												// console.log("interes: " + $scope.interes_plan2);
												newSaldoTable = $scope.total3 = $scope.alphaNumeric[(i)]['saldo'] = $scope.total3 - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												total = operacionCompleta;//$scope.p2 888888
												$scope.interes_plan3 = $scope.alphaNumeric[i]['interes'] = $scope.alphaNumeric[(i-1)]['saldo'] * ($scope.infoLote.interes_p3);
												interes =  $scope.interes_plan3 ;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2

												// console.log(i + " - " +($scope.alphaNumeric[i-1]['interes']));
												// console.log(i + " - " + $scope.alphaNumeric[(i - 1)]['saldo']);
											} else {
												// console.log($scope.alphaNumeric[i]['pago']);
												// console.log($scope.alphaNumeric[i]['saldo']);
												capital = $scope.capital3;
												newSaldoTable = $scope.total3 = $scope.alphaNumeric[(i - 1)]['saldo'] - $scope.alphaNumeric[i]['pagoCapital'] - $scope.capital3;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												$scope.interes_plan3 = $scope.alphaNumeric[i]['interes'] = $scope.alphaNumeric[(i-1)]['saldo'] * ($scope.infoLote.interes_p3);
												interes =  $scope.interes_plan3;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												total = $scope.p3;//$scope.p2
											}
											// console.log($scope.total2);
										}
									}
									else
									{
										if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago) {
											if ($scope.alphaNumeric[posicionPago]['disp'] == 1) {
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
												saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'];
											} else {//se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
											}
										} else {
											//cuando se salta un espacio en la tabla
											saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
											total = 999999999999999;
										}
									}
								}
								// console.log("p2: " + $scope.p2);
								range3.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": capital,
									"interes": interes,
									"total": total,
									"saldo": newSaldoTable,//newSaldoTable
									"pagoCapital": pagoACapitalCantidad,
									"disp": dispPC,
								});
							}
							else
							{
								range3.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.alphaNumeric[i]['capital'],
									"interes": $scope.alphaNumeric[i]['interes'],
									"total": $scope.alphaNumeric[i]['total'],
									"saldo": $scope.alphaNumeric[i]['saldo'],//newSaldoTable
									"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
									"disp": $scope.alphaNumeric[i]['disp'],
								});
							}
							mes++;


							if (i == 122){
								$scope.totalTercerPlan = total;

							}
							$scope.finalMesesp3 = (range3.length);

						}

						$scope.range3= range3;


						$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
						$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range2).concat($scope.range3);

						//$scope.alphaNumeric = $scope.range2.concat($scope.range3);

						$scope.dtoptions = DTOptionsBuilder;
						$scope.dtColumns = [
							DTColumnBuilder.newColumn('fecha').withTitle('Fechas'),
							DTColumnBuilder.newColumn('pago').withTitle('Pago #'),
							DTColumnBuilder.newColumn('capital').withTitle('Capital').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('interes').withTitle('Intereses').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('total').withTitle('Total').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('saldo').withTitle('Saldo').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('pagoCapital').withTitle('Pago a Capital')
								.renderWith(
									function (data, type, full, meta) {
										// console.log($scope.alphaNumeric[full['pago']-1]['saldo']);
										if ($scope.alphaNumeric[full['pago'] - 1]['saldo'] <= 0) {
											$scope.alphaNumeric[full['pago'] - 1]['saldo'] = 0;
										}
										if ($scope.alphaNumeric[posicionPago - 1]['disp'] == 1 && $scope.alphaNumeric[posicionPago - 1]['pagoCapital'] != "" && full['pagoCapital'] != "")//
										{
											// console.log($scope.alphaNumeric[posicionPago-1]['pago']   +" "+	posicionPago);
											// console.log('Estoy llegando aquí');
											// return "$ " + saldo;
											var inputCapital = '<input name="capVal' + full["pago"] + '" type="number" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control" value="' + $scope.alphaNumeric[full['pago'] - 1]['pagoCapital'] + '" disabled>';
											var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
											return inputCapital + numberPay;
										} else {
											var inputCapital = '<input name="capVal' + full["pago"] + '" type="text" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control">';
											var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
											return inputCapital + numberPay;
										}
										// console.log($scope.alphaNumeric[posicionPago-1]['disp']	+	" "	+	$scope.alphaNumeric[posicionPago-1]['pagoCapital']);
									},
								),
						];

						$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
								{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
								{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
								{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
								{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
										//pageMargins [left, top, right, bottom]
										doc.pageMargins = [ 140, 40, 10, 50 ];
										doc.alignment = 'center';

									}},
							]
						).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});





					}
					if ($scope.infoLote.mesesSinInteresP1 == 36)
					{
						$scope.infoLote.mesesSinInteresP1 = ($scope.mesesdiferir > 0) ? ($scope.infoLote.mesesSinInteresP1 + $scope.mesesdiferir) : ($scope.infoLote.mesesSinInteresP1);

						for (var i = ini; i <= $scope.infoLote.mesesSinInteresP1-1; i++) {
							if (mes == 13) {
								mes = '01';
								yearc++;
							}
							if (mes == 2) {
								mes = '02';
							}
							if (mes == 3) {
								mes = '03';
							}
							if (mes == 4) {
								mes = '04';
							}
							if (mes == 5) {
								mes = '05';
							}
							if (mes == 6) {
								mes = '06';
							}
							if (mes == 7) {
								mes = '07';
							}
							if (mes == 8) {
								mes = '08';
							}
							if (mes == 9) {
								mes = '09';
							}
							if (mes == 10) {
								mes = '10';
							}
							if (mes == 11) {
								mes = '11';
							}
							if (mes == 12) {
								mes = '12';
							}
							$scope.dateCf = day + '-' + mes + '-' + yearc;

							if (i == 0) {
								$scope.fechaPM = $scope.dateCf;
							}
							var newSaldoTable = 0;
							var alphaOriginal = [];
							alphaOriginal = $scope.alphaNumeric;
							if ($scope.alphaNumeric[i]['disp'] != 1) {
								/*Para verfificar donde se puso el pago a capital*/
								var dispPC = 0;
								var vuelta = (i + 1);
								var posicionPago = (posPay + 1);
								if (vuelta == posicionPago) {
									// console.log("se tiene que poner esto " + saldo + " en la posición: " + (posPay + 1));
									if (posicionPago == 1) {
										/* Este if es para ver si se descuenta la primera posicion*/
										newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
										dispPC = 1;
										pagoACapitalCantidad = saldo;
										// console.log('se desceunta de la primera posicion');
									} else {/* Este else es para ver si se descuenta apartir de la segunda posicion*/
										newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[posPay]['saldo'];
										dispPC = $scope.alphaNumeric[posPay]['dispPC'] = 1;
										pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
										// console.log('se descuente de la posicion ' + i);
									}
								} else {
									/*Hace el calculo cuando es 0apartir de la segunda posición*/
									if ($scope.alphaNumeric[i]['disp'] == 0 || $scope.alphaNumeric[i]['disp'] == undefined) {
										//else despues del primer post en segunda posicion
										if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'] - saldo;
											dispPC = 0;
											pagoACapitalCantidad = 0;
										} else if ($scope.alphaNumeric[i]['pago'] <= posicionPago) {
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
											// dispPC = 0;
											dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
											pagoACapitalCantidad = 0;
										}
									} else {
										if ($scope.alphaNumeric[i]['pago'] >= posicionPago) {
											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
											dispPC = 0;
											pagoACapitalCantidad = 0;

										} else if ($scope.alphaNumeric[i]['pago'] <= posicionPago) {

											newSaldoTable = $scope.infoLote.precioTotal = $scope.alphaNumeric[i]['saldo'];
											dispPC = $scope.alphaNumeric[i]['dispPC'] = 0;
											pagoACapitalCantidad = 0;
										}
									}
								}
								range.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.infoLote.capital,
									"interes": 0,
									"total": $scope.infoLote.capital + $scope.infoLote.interes_p1,
									"saldo": newSaldoTable,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
									"pagoCapital": pagoACapitalCantidad,
									"disp": dispPC,
								});
							} else {
								/*Se coloca el valor anterior de donde se modificó, con el valor que trae por defecto en el areglo*/
								range.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.alphaNumeric[i]['capital'],
									"interes": 0,
									"total": $scope.alphaNumeric[i]['total'],
									"saldo": $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
									"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
									"disp": $scope.alphaNumeric[i]['disp'],
								});
							}
							mes++;
							if (i == ($scope.infoLote.mesesSinInteresP1 - 1)) {
								$scope.total2 = $scope.infoLote.precioTotal;
								// alert($scope.total2);
								$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;
							}
							$scope.finalMesesp1 = range.length;
							ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
						}
						$scope.range = range;

						/////////////
						// 	$scope.p2 = ($scope.infoLote.interes_p2 * Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.infoLote.precioTotal)
						// 		/ (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);
						var range2 = [];
						// console.log("Saldo para el segundo arreglo " + ini2);
						// var range2 = [];
						var f=0;
						for (var i = ini2; i <  120; i++) {
							var f=f+1;
							if ((mes == 13) || (mes == 14)) {

								if (mes == 13) {

									mes = '01';
									yearc++;

								} else if (mes == 14) {

									mes = '02';
									yearc++;

								}

							}

							if (mes == 2) {
								mes = '02';
							}
							if (mes == 3) {
								mes = '03';
							}
							if (mes == 4) {
								mes = '04';
							}
							if (mes == 5) {
								mes = '05';
							}
							if (mes == 6) {
								mes = '06';
							}
							if (mes == 7) {
								mes = '07';
							}
							if (mes == 8) {
								mes = '08';
							}
							if (mes == 9) {
								mes = '09';
							}
							if (mes == 10) {
								mes = '10';
							}
							if (mes == 11) {
								mes = '11';
							}
							if (mes == 12) {
								mes = '12';
							}

							//nueva version 11Marzo20
							$scope.dateCf = day + '-' + mes + '-' + yearc;
							if (i == 0) {
								$scope.fechaPM = $scope.fechapago;
							}
							//nuevo codigo 21 FEB
							var interes = 0;
							var total = 0;
							var capital = 0;
							var newSaldoTable = 0;

							var alphaOriginal = [];
							alphaOriginal = $scope.alphaNumeric;

							if ($scope.alphaNumeric[i]['disp'] != 1) {
								var vuelta = (i + 1);
								var posicionPago = (posPay + 1);
								if (vuelta == posicionPago) {
									if (posicionPago == 1) {
										// console.log('primera posicion');
									}
									else {
										// console.log('Segunda posicion: ' + $scope.alphaNumeric[posPay]['saldo'] + 'pagocap: ' + saldo);
										capital = $scope.alphaNumeric[posPay]['capital'];
										newSaldoTable = $scope.total2 = $scope.alphaNumeric[posPay]['saldo'];//= nuevoSaldo;//saldo es el pago a capital (facepalm)
										dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
										pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
										interes = $scope.alphaNumeric[posPay]['interes'];//$scope.alphaNumeric[posPay]['saldo'] * $scope.infoLote.interes_p2
										total = $scope.alphaNumeric[posPay]['total'];//capital + interes
										$scope.alphaNumeric[posPay]['control'] = 1;
									}
								} else {
									// console.log('el total hasta este punto es de: ' + $scope.total2);

									if ($scope.alphaNumeric[posicionPago]['pagoCapital'] == 0 || $scope.alphaNumeric[posicionPago]['pagoCapital'] == undefined) {
										if (i < posicionPago) {
											capital = $scope.alphaNumeric[i]['capital'];
											newSaldoTable = $scope.alphaNumeric[i]['saldo'];//saldo es el pago a capital (facepalm)
											dispPC = $scope.alphaNumeric[i]['disp'] = 0;
											pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
											interes = $scope.alphaNumeric[i]['interes'];
											total = $scope.alphaNumeric[i]['total'];
										} else {

											if ($scope.alphaNumeric[i]['disp'] == undefined || $scope.alphaNumeric[i]['disp'] == 0) {
												if (posicionPago < $scope.infoLote.msn) {
													var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
													parte1 = parte1;
													var parte2 = (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) - 1);
													parte2 = parte2;


													$scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo'] = $scope.infoLote.precioTotal;
													operacionCompleta = (($scope.infoLote.interes_p2 * parte1 * $scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo']) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
												} else //if(posicionPago>=$scope.infoLote.msn)
												{
													var parte1 = Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses -  ($scope.alphaNumeric[posPay]['pago']));//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
													parte1 = parte1;

													var parte2 = (Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - ($scope.alphaNumeric[posPay]['pago'])) - 1);
													parte2 = parte2;

													operacionCompleta = (($scope.infoLote.interes_p2 * parte1 * $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2)) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
												}

												$scope.interes_plan2 = $scope.alphaNumeric[(i - 1)]['saldo'] * ($scope.infoLote.interes_p2);
												capital = operacionCompleta - $scope.interes_plan2;//($scope.capital2 =	 ($scope.p2 - $scope.interes_plan2))
												newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i)]['saldo'] = $scope.total2 - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												total = operacionCompleta;//$scope.p2
												interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												// console.log(i + " - " + $scope.alphaNumeric[(i - 1)]['saldo']);
											} else {
												// console.log($scope.alphaNumeric[i]['pago']);
												// console.log($scope.alphaNumeric[i]['saldo']);
												capital = $scope.capital2;
												newSaldoTable = $scope.total2 = $scope.alphaNumeric[(i - 1)]['saldo'] - $scope.alphaNumeric[i]['pagoCapital'] - $scope.capital2;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												interes = $scope.interes_plan2;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												total = $scope.p2;//$scope.p2
											}
											// console.log($scope.total2);
										}
									} else {
										if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago) {
											if ($scope.alphaNumeric[posicionPago]['disp'] == 1) {
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
												saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'];
											} else {//se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
											}
										} else {
											//cuando se salta un espacio en la tabla
											saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
											total = 999999999999999;
										}
									}
								}
								// console.log("p2: " + $scope.p2);
								range2.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": capital,
									"interes": interes,
									"total": total,
									"saldo": newSaldoTable,//newSaldoTable
									"pagoCapital": pagoACapitalCantidad,
									"disp": dispPC,
								});
							}
							else {
								range2.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.alphaNumeric[i]['capital'],
									"interes": $scope.alphaNumeric[i]['interes'],
									"total": $scope.alphaNumeric[i]['total'],
									"saldo": $scope.alphaNumeric[i]['saldo'],//newSaldoTable
									"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
									"disp": $scope.alphaNumeric[i]['disp'],
								});
							}
							//se termina nueva parte
							mes++;

							if (i == 119) {
								$scope.total3 = $scope.total2;
								$scope.totalSegundoPlan = total;

							}
							$scope.finalMesesp2 = (range2.length);
						}
						// console.log('aqui termina este pedo: ' + i);
						$scope.range2 = range2;


						//////////

						// $scope.p3 = ($scope.infoLote.interes_p3 * Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120) * $scope.total3) / (Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120) - 1);

						var range3 = [];
						// console.log("Saldo para el tercer arreglo " + $scope.total2);
						for (var i = 120; i < $scope.infoLote.meses; i++) {//$scope.infoLote.meses + 1

							if ((mes == 13) || (mes == 14)) {

								if (mes == 13) {

									mes = '01';
									yearc++;

								} else if (mes == 14) {

									mes = '02';
									yearc++;

								}

							}

							if (mes == 2) {
								mes = '02';
							}
							if (mes == 3) {
								mes = '03';
							}
							if (mes == 4) {
								mes = '04';
							}
							if (mes == 5) {
								mes = '05';
							}
							if (mes == 6) {
								mes = '06';
							}
							if (mes == 7) {
								mes = '07';
							}
							if (mes == 8) {
								mes = '08';
							}
							if (mes == 9) {
								mes = '09';
							}
							if (mes == 10) {
								mes = '10';
							}
							if (mes == 11) {
								mes = '11';
							}
							if (mes == 12) {
								mes = '12';
							}

							//11marzo20
							// $scope.dateCf = day + '-' + mes + '-' + yearc;
							// $scope.interes_plan3 = $scope.total3*($scope.infoLote.interes_p3);
							// $scope.capital2 = ($scope.p3 - $scope.interes_plan3);
							// range3.push({
							//
							// 	"fecha" : $scope.dateCf,
							// 	"pago" : i,
							// 	"capital" : ($scope.capital2 = ($scope.p3 - $scope.interes_plan3)),
							// 	"interes" : ($scope.interes_plan3= ($scope.total3 * $scope.infoLote.interes_p3)),
							// 	"total" : $scope.p3,
							// 	"saldo" : ($scope.total3 = ($scope.total3 -$scope.capital2)),
							//
							// });
							//versioi a terior range3 11Marzo20

							//nueva versions 11Marzo20
							$scope.dateCf = day + '-' + mes + '-' + yearc;
							if (i == 0) {
								$scope.fechaPM = $scope.fechapago;
							}
							//nuevo codigo 21 FEB
							var interes = 0;
							var total = 0;
							var capital = 0;
							var newSaldoTable = 0;

							var alphaOriginal = [];
							alphaOriginal = $scope.alphaNumeric;

							// console.log($scope.alphaNumeric[i]['disp'] + " - " + i);

							if ($scope.alphaNumeric[i]['disp'] != 1) {
								var vuelta = (i + 1);
								var posicionPago = (posPay + 1);
								if (vuelta == posicionPago) {
									if (posicionPago == 1) {
										// console.log('primera posicion');
									}
									else {
										// console.log('Segunda posicion: ' + $scope.alphaNumeric[posPay]['saldo'] + 'pagocap: ' + saldo);
										capital = $scope.alphaNumeric[posPay]['capital'];
										newSaldoTable = $scope.total3 = $scope.alphaNumeric[posPay]['saldo'];//= nuevoSaldo;//saldo es el pago a capital (facepalm)
										dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
										pagoACapitalCantidad = $scope.alphaNumeric[posPay]['pagoCapital'] = saldo;
										interes = $scope.alphaNumeric[posPay]['interes'];//$scope.alphaNumeric[posPay]['saldo'] * $scope.infoLote.interes_p2
										total = $scope.alphaNumeric[posPay]['total'];//capital + interes
										$scope.alphaNumeric[posPay]['control'] = 1;
									}
								} else {
									// console.log('el total hasta este punto es de: ' + $scope.total2);

									if ($scope.alphaNumeric[posicionPago]['pagoCapital'] == 0 || $scope.alphaNumeric[posicionPago]['pagoCapital'] == undefined) {
										if (i < posicionPago) {
											capital = $scope.alphaNumeric[i]['capital'];
											newSaldoTable = $scope.alphaNumeric[i]['saldo'];//saldo es el pago a capital (facepalm)
											dispPC = $scope.alphaNumeric[i]['disp'] = 0;
											pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
											interes = $scope.alphaNumeric[i]['interes'];
											total = $scope.alphaNumeric[i]['total'];
										} else {

											if ($scope.alphaNumeric[i]['disp'] == undefined || $scope.alphaNumeric[i]['disp'] == 0) {
												// if (posicionPago < 120) {
												if (posicionPago < 120) {
													var parte1 = Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
													parte1 = parte1;

													var parte2 = (Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses  -120) - 1);
													parte2 = parte2;


													//$scope.alphaNumeric[(119)]['saldo'] = $scope.total2;
													$scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo'] = $scope.total2;
													operacionCompleta = (($scope.infoLote.interes_p3 * parte1 * $scope.alphaNumeric[($scope.infoLote.msn - 1)]['saldo']) / parte2);//((0.01*($scope.alphaNumeric[
												}
												else //if(posicionPago>=$scope.infoLote.msn)
												{
													var parte1 = Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago']);//$scope.infoLote.meses  - $scope.infoLote.mesesSinInteresP1
													parte1 = parte1;

													var parte2 = (Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - $scope.alphaNumeric[posPay]['pago']) - 1);
													parte2 = parte2;
													operacionCompleta = (($scope.infoLote.interes_p3 * parte1 * $scope.alphaNumeric[(posPay)]['saldo'].toFixed(2)) / parte2);//((0.01*($scope.alphaNumeric[i]['saldo']*1.17)))/.17
												}

												// console.log("ALV: " + $scope.alphaNumeric[(i - 1)]['saldo']);
												capital = operacionCompleta - ($scope.alphaNumeric[(i - 1)]['saldo'] * ($scope.infoLote.interes_p3));//($scope.capital2 =	 ($scope.p2 - $scope.interes_plan2))
												// console.log("interes: " + $scope.interes_plan2);
												newSaldoTable = $scope.total3 = $scope.alphaNumeric[(i)]['saldo'] = $scope.total3 - capital;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												total = operacionCompleta;//$scope.p2 888888
												$scope.interes_plan3 = $scope.alphaNumeric[i]['interes'] = $scope.alphaNumeric[(i - 1)]['saldo'] * ($scope.infoLote.interes_p3);
												interes = $scope.interes_plan3;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
											} else {
												// console.log($scope.alphaNumeric[i]['pago']);
												// console.log($scope.alphaNumeric[i]['saldo']);
												capital = $scope.capital3;
												newSaldoTable = $scope.total3 = $scope.alphaNumeric[(i - 1)]['saldo'] - $scope.alphaNumeric[i]['pagoCapital'] - $scope.capital3;//$scope.total2= $scope.alphaNumeric[(i-1)]['saldo']-capital
												dispPC = $scope.alphaNumeric[i]['disp'] = 0;
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'] = 0;
												$scope.interes_plan3 = $scope.alphaNumeric[i]['interes'] = $scope.alphaNumeric[(i - 1)]['saldo'] * ($scope.infoLote.interes_p3);
												interes = $scope.interes_plan3;//$scope.alphaNumeric[i]['saldo']*$scope.infoLote.interes_p2
												total = $scope.p3;//$scope.p2
											}
											// console.log($scope.total2);
										}
									} else {
										if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago) {
											if ($scope.alphaNumeric[posicionPago]['disp'] == 1) {
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
												saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
												pagoACapitalCantidad = $scope.alphaNumeric[i]['pagoCapital'];
											} else {//se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion
												dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
											}
										} else {
											//cuando se salta un espacio en la tabla
											saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
											total = 999999999999999;
										}
									}
								}
								// console.log("p2: " + $scope.p2);
								range3.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": capital,
									"interes": interes,
									"total": total,
									"saldo": newSaldoTable,//newSaldoTable
									"pagoCapital": pagoACapitalCantidad,
									"disp": dispPC,
								});
							} else {
								range3.push({
									"fecha": $scope.dateCf,
									"pago": i + 1,
									"capital": $scope.alphaNumeric[i]['capital'],
									"interes": $scope.alphaNumeric[i]['interes'],
									"total": $scope.alphaNumeric[i]['total'],
									"saldo": $scope.alphaNumeric[i]['saldo'],//newSaldoTable
									"pagoCapital": $scope.alphaNumeric[i]['pagoCapital'],
									"disp": $scope.alphaNumeric[i]['disp'],
								});
							}
							mes++;


							if (i == 122) {
								$scope.totalTercerPlan = total;

							}
							$scope.finalMesesp3 = (range3.length);

						}

						$scope.range3 = range3;


						$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
						$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2).concat($scope.range3);

						//$scope.alphaNumeric = $scope.range2.concat($scope.range3);

						$scope.dtoptions = DTOptionsBuilder;
						$scope.dtColumns = [
							DTColumnBuilder.newColumn('fecha').withTitle('Fechas'),
							DTColumnBuilder.newColumn('pago').withTitle('Pago #'),
							DTColumnBuilder.newColumn('capital').withTitle('Capital').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('interes').withTitle('Intereses').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('total').withTitle('Total').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('saldo').withTitle('Saldo').renderWith(function (data, type, full) {
								return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}))
							}),
							DTColumnBuilder.newColumn('pagoCapital').withTitle('Pago a Capital')
								.renderWith(
									function (data, type, full, meta) {
										// console.log($scope.alphaNumeric[full['pago']-1]['saldo']);
										if ($scope.alphaNumeric[full['pago'] - 1]['saldo'] <= 0) {
											$scope.alphaNumeric[full['pago'] - 1]['saldo'] = 0;
										}
										if ($scope.alphaNumeric[posicionPago - 1]['disp'] == 1 && $scope.alphaNumeric[posicionPago - 1]['pagoCapital'] != "" && full['pagoCapital'] != "")//
										{
											// console.log($scope.alphaNumeric[posicionPago-1]['pago']   +" "+	posicionPago);
											// console.log('Estoy llegando aquí');
											// return "$ " + saldo;
											var inputCapital = '<input name="capVal' + full["pago"] + '" type="number" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control" value="' + $scope.alphaNumeric[full['pago'] - 1]['pagoCapital'] + '" disabled>';
											var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
											return inputCapital + numberPay;
										} else {
											var inputCapital = '<input name="capVal' + full["pago"] + '" type="text" id="idModel' + full["pago"] + '" ng-model="myModeloAlv" onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Ingresa un Pago a Capital " class="form-control">';
											var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
											return inputCapital + numberPay;
										}
										// console.log($scope.alphaNumeric[posicionPago-1]['disp']	+	" "	+	$scope.alphaNumeric[posicionPago-1]['pagoCapital']);
									},
								),
						];

						$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
								{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
								{
									extend: 'print',
									text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
									titleAttr: 'Imprimir'
								},
								{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
								{
									extend: 'pdfHtml5',
									text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
									titleAttr: 'PDF',
									title: '',
									customize: function (doc) {
										//pageMargins [left, top, right, bottom]
										doc.pageMargins = [140, 40, 10, 50];
										doc.alignment = 'center';

									}
								},
							]
						).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});


					}
				}
			}
		});




		function printDiv(nombreDiv) {
			window.print();
			return true;
		}
		function pagoCapChange(param)
		{
			var inputVal = document.getElementById('idModel'+param);
			var numberPay = document.getElementById('payNum'+param);
			// console.log('Hubo un cambio en el row: ' + param + ' el valor del cambio es: ' + inputVal.value);
			$('#jsPagoCapital').val(inputVal.value);
			$('#pagoACapitalNumberJS').val(numberPay.value);
			$('#jsPagoCapital').click();
		}
	</script>







</body>


</html>
