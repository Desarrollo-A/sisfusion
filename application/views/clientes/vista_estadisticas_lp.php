<body class="">
<div class="wrapper ">
<?php $this->load->view('template/sidebar'); ?>


	<div class="content" ng-controller="datos">
		<div class="container-fluid">
			<div class="container-fluid">
				<div class="row">
					<div class="container-fluid">
						<div class="card" >
							<div class="card-header card-header-icon" data-background-color="purple">
								<i class="material-icons">bubble_chart</i>
							</div>
							<div class="card-content">
								<h4 class="card-title"> Estadísticas <span><b>lugar de prospección</b></span></h4>
								<div class="row">
									<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<div class="box">
											<div class="box-header with-border">
												<form id="formUsuario" name = "formUsuario" ng-submit="function()" novalidate>
													<dir-custom-loader class="ng-hide"></dir-custom-loader>
													<div class="row">

														<div class="col-md-6">
															<div ng-app="myChart" style="width:100%;" >
																<canvas id="bar"
																		class="chart chart-line"
																		chart-data="data"
																		chart-labels="labels"
																		chart-options="options"
																		chart-dataset-override="datasetOverride"
																		chart-series="series"
																		chart-colors="colours"
																		ng-model="datos.grafica">
																</canvas>
															</div>
														</div>
														<div class="col-md-6">
															<div class="row">
																<div class="col-md-6 form-group">
																	<label>Lugar de prospección</label>
																	<select name="lugarSelect" id="lugarSelect"
																			class="selectpicker"
																			data-style="select-with-transition"
																			title="Selecciona una opción"
																			ng-model="datos.lugar"
																			ng-options="item3.id_lugares as item3.nombre_lugares for item3 in lugares">
																		<!--<option value="">Seleccione un lugar</option>-->

																	</select>
																</div>

																<div class="col-md-6 form-group">
																	<label>Sede</label>
																	<select name="sedeSelect" id="sedeSelect"
																			class="selectpicker"
																			data-style="select-with-transition"
																			title="Selecciona una opción"
																			ng-model="datos.sede"
																			ng-options="item3.id_sedes as item3.nombre_sedes for item3 in sedes">
																		<!--<option value="">Seleccione una sede</option>-->
																	</select>
																	<span ng-show="etapaInvalido" style="color:white" ng-style="myStyle" >Por favor, seleccione una sede</span>
																</div>


																<div class="col-md-6 form-group">
																	<label>Fecha inicio</label>
																	<input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" ng-change="changefecha1()" ng-model="datos.fecha1" required>
																</div>

																<div class="col-md-6 form-group">
																	<label>Fecha final</label>
																	<input type="date" class="form-control" name="fecha_final" id="fecha_final"  ng-change="changefecha2()" ng-model="datos.fecha2" required>
																</div>

																<div class="col-md-4 form-group">
		                                                            <button class="btn btn-round btn-fab btn-fab-mini" title="Generar gráfico nuevo" ng-click="ObtenerReporte(datos)" style="background-color: #884EA0; color: #FFFFFF;"><i class="material-icons">done</i></button>
		                                                        </div>
		                                                        <div class="col-md-4 form-group">
																<button type="button" title="Descargar Gráfica" class="btn btn-round btn-fab btn-fab-mini"
																		style="background-color: #148F77;" ng-click="Download(datos)"><i class="material-icons">cloud_download</i></button>
																</div>
																<div class="col-md-4 form-group">
																	<button type="button" title="Exportar Listado a Excel" class="btn btn-round btn-fab btn-fab-mini" style="background-color: #0E6655"ng-click="exportData(datos)"> <i class="material-icons">file_copy</i><</button>
																</div>

															</div>
														</div>
													</div>
													<div class="row">
		                                                <div class="col-md-12">
		                                                    <div class="table-responsive">
		                                                        <table class="table">
		                                                            <thead class="text-primary">
		                                                            <th ng-repeat="user in users">{{user.mes}}</th>
		                                                            </thead>
		                                                            <tbody>
		                                                            <tr>
		                                                                <td ng-repeat="user in users">{{user.clientes}}</td>
		                                                            </tr>
		                                                            <tr>
		                                                                <td ng-repeat="user in users" ng-show="HideColumn">{{user.tipoDecliente}}</td>
		                                                            </tr>
		                                                            </tbody>
		                                                        </table>
		                                                    </div>
		                                                </div>
		                                            </div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="Modal_export" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content ">
						<div class="modal-header header-fail">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Advertencia</h4>
						</div>
						<div class="modal-body">
							<h5 class="text-center text-body">Asegúrese de haber llenado los campos <b>Lugar de prospección</b>, <b>Sede,</b> <b>Asesor</b> y <b>Fechas (inicio y fin)</b> antes de intentar exportar. De lo contrario, su resultado se verá afectado.<h5>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-eliminar" data-dismiss="modal">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
			<?php $this->load->view('template/footer_legend');?>
		</div>
	</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>
<script src="<?=base_url()?>dist/js/controllers/clientes/statistics-1.1.0.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?=base_url()?>dist/js/moment.min.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?=base_url()?>dist/js/bootstrap-datetimepicker.js"></script>
<!-- Sliders Plugin -->
<script src="<?=base_url()?>dist/js/nouislider.min.js"></script>
<!--  Full Calendar Plugin    -->
<script src="<?=base_url()?>dist/js/fullcalendar.min.js"></script>

<script src="<?=base_url()?>dist/js/controllers/clientes/alasql.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/clientes/xlsx.core.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/clientes/angular.min.js"></script>

<script src="<?=base_url()?>dist/js/Chart.js"></script>
<script src="<?=base_url()?>dist/js/angular/angular-chart.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/clientes/charts-1.1.0.js"></script>


<script>
	$(document).ready(function(){
		function setCurrency (currency) {
			if (!currency.id) { return currency.text; }
			var $currency = $('<span class="glyphicon glyphicon-' + currency.element.value + '">' + currency.text + '</span>');
			return $currency;
		};
		$(".searchAsesoresMkt").select2({
			placeholder: "Seleccione un asesor", //placeholder
			templateResult: setCurrency,
			templateSelection: setCurrency
		});
	})

	var myApp = angular.module('CRM', ["chart.js"]);
	var grafica;
	var prueba;
	var ttipo = 'PROSPECTOS '; var ta = new Date().getFullYear();
	var texto = ttipo + ta;
	var maxnumber;
	var tipo_grafica;
	var url = "<?php echo base_url().'index.php/'?>";


	myApp.controller('datos',
		function ($scope, $http) {
			// REQUEST OPTIONS USING GET METHOD.
			//angular.element.blockUI()
			$scope.myStyle = {'color':'white'}
			$scope.etapaInvalido = false;
			$scope.HideColumn = false;
			$scope.searchButtonText = "Aplicar Filtros";
			$scope.test = "false";
			$scope.tipoDecliente2 = "Clientes";
			$scope.tipoDecliente = "Prospectos";
			$scope.series = ['Prospectos'];

			var request = {
				method: 'get',
				url: url + 'LP/get_total_lp',
				dataType: 'json',
				contentType: "application/json"
			};

			var opts = {sheetid : 'Listado',
				headers:true,
				column: {style:{Font:{Bold:"1",Color: "#3C3741"}}},
				rows: {1:{style:{Font:{Color:"#FF0077"}}}},
				cells: {1:{1:{
							style: {Font:{Color:"#00FFFF"}}
						}}}


			};
			//$scope.colours = ['#263eab', '#3498DB', '#717984', '#F1C40F'];

			$scope.colours = [
                {
                    backgroundColor: '#fff',
                    borderColor: 'rgb(103, 58, 183)',
                    pointBorderColor: 'rgb(103, 58, 183)',
                    pointBackgroundColor: 'rgb(103, 58, 183)',
                    pointHoverBackgroundColor: 'rgb(103, 58, 183)',
                    pointHoverBorderColor: 'rgb(103, 58, 183, .10)',
                    pointBorderWidth: 10,
                    pointHoverRadius: 10,
                    pointHoverBorderWidth: 1,
                    pointRadius: 1,
                    fill: false,
                    borderWidth: 2,

                },
                // ...colors for additional data sets
            ];

			$http({
				method: 'get',
				url: url + 'LP/get_lugares'
			}).then(function successCallback(response) {
				// Store response data
				var todos = [{
					id_lugares: 'Todos',
					nombre_lugares: 'Todos'
				}];
				//$scope.lugares = angular.extend(response.data, todos);
				$scope.lugares = response.data.concat(todos)


				var len = response.data.length;

				for( var i = 0; i<len; i++)
				{
					var id = response.data[i]['id_lugares'];
					var name = response.data[i]['nombre_lugares'];
					$("#lugarSelect").append($('<option>').val(id).attr('label', name).text(name));
					//console.log(response.data[i]['id_lugares']);

				}

				if (len <= 0) {
					// $("#managerSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
					$("#lugarSelect").append('<option selected="selected" disabled>SIN OPCIONES</option>');
				}
				else
				{
					$("#lugarSelect").append($('<option>').val('Todos').attr('label', 'Todos').text('Todos'));
				}
				$("#lugarSelect").selectpicker('refresh');
			});

			$http({
				method: 'get',
				url: url + 'LP/get_sedes'
			}).then(function successCallback(response) {
				// Store response
				var todos1 = [{
					id_sedes: 'Todas',
					nombre_sedes: 'Todas'
				}];
				$scope.sedes = response.data.concat(todos1)


				var len = response.data.length;

				for( var i = 0; i<len; i++)
				{
					var id = response.data[i]['id_sedes'];
					var name = response.data[i]['nombre_sedes'];
					$("#sedeSelect").append($('<option>').val(id).attr('label', name).text(name));
					//console.log(response.data[i]['id_lugares']);
				}
				if (len <= 0) {
					// $("#managerSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
					$("#sedeSelect").append('<option selected="selected" disabled>SIN OPCIONES</option>');
				}
				else
				{
					$("#sedeSelect").append($('<option>').val('Todas').attr('label', 'Todas').text('Todas'));
				}
				$("#sedeSelect").selectpicker('refresh');
			});

			// MAKE REQUEST USING $http SERVICE.
			$http(request)
				.then(function (jsonData) {
					$scope.CrearGrafica(jsonData.data);
					$scope.options = {
						legend: {
							display: true ,
							position: 'bottom'
						},
						scales: {
							yAxes: [{id: 'y-axis-1', type: 'linear', position: 'left', ticks: {min: 0, max: maxnumber}}]
						},

						animation : {
							onComplete : function(datooos){
								grafica = datooos.chartInstance.toBase64Image();
								//console.log(grafica);
							}
						},

						title: {
							display: true,
							text: 'Número de registros por lugar de prospección',
							fontSize: 20
						}
					};
					//angular.element.unblockUI()
				})
				.catch(function (Object) {
					alert(Object.data);
				});


			$scope.CrearGrafica = function(data){
				$scope.users = data;
				$scope.arrData = new Array;
				$scope.arrLabels = new Array;
				// LOOP THROUGH DATA IN THE JSON FILE.
				angular.forEach(data, function (item) {
					$scope.arrData.push(item.clientes);
					$scope.arrLabels.push(item.mes);
				});
				maxnumber = Math.max.apply(Math,$scope.arrData) + 10;
				$scope.data = new Array;
				$scope.labels = new Array;

				// UPDATE SCOPE PROPERTIES “data” and “label” FOR DATA.
				$scope.data.push($scope.arrData.slice(0));

				for (var i = 0; i < $scope.arrLabels.length; i++) {
					$scope.labels.push($scope.arrLabels[i]);
				}

			}


			$scope.ObtenerReporte = function(data){
				$scope.myStyle = {'color':'red'}
				var a = $scope.formUsuario.lugarSelect.$viewValue;
				var b = $scope.formUsuario.sedeSelect.$viewValue;
				// var c = $scope.formUsuario.asesoresSelect.$viewValue;

				if(a == undefined || b == undefined){

				}else{
					if(a != undefined && b != undefined){
						request = {
							method: 'POST',
							url: url + 'LP/get_chart_complete',
							data: JSON.stringify({lugar : data.lugar, sede: data.sede, fecha_ini : data.fecha1, fecha_fin : data.fecha2})
						};
						$http(request)
							.then(function (jsonData) {

								$scope.CrearGrafica(jsonData.data);
								$scope.options = {
									legend: {
										display: true ,
										position: 'bottom'
									},
									scales: {
										yAxes: [{id: 'y-axis-1', type: 'linear', position: 'left', ticks: {min: 0, max: maxnumber}}]
									},

									animation : {
										onComplete : function(datooos){
											grafica = datooos.chartInstance.toBase64Image();
											//console.log(grafica);
										}
									},

									title: {
										display: true,
										text: 'Número de registros por lugar de prospección',
										fontSize: 20
									}
								};

							})

					}
					if(a != undefined && b != undefined){
						request = {
							method: 'POST',
							url: url + 'LP/get_chart_lp',
							data: JSON.stringify({lugar : data.lugar, sede: data.sede, fecha_ini : data.fecha1, fecha_fin : data.fecha2})
						};
						$http(request)
							.then(function (jsonData) {

								$scope.CrearGrafica(jsonData.data);
								$scope.options = {
									legend: {
										display: true ,
										position: 'bottom'
									},
									scales: {
										yAxes: [{id: 'y-axis-1', type: 'linear', position: 'left', ticks: {min: 0, max: maxnumber}}]
									},

									animation : {
										onComplete : function(datooos){
											grafica = datooos.chartInstance.toBase64Image();
											//console.log(grafica);
										}
									},

									title: {
										display: true,
										text: 'Número de registros por lugar de prospección',
										fontSize: 20
									}
								};

							})

					}


				}

			}

			$scope.exportData = function (data) {
				var a = $scope.formUsuario.lugarSelect.$viewValue;
				var b = $scope.formUsuario.sedeSelect.$viewValue;
				// var c = $scope.formUsuario.asesoresSelect.$viewValue;

				if(a == undefined || b == undefined){
					$("#Modal_export").modal("show");
				}
				else{
					//angular.element.blockUI()
					if(a != undefined && b != undefined){
						request = {
							method: 'POST',
							url: url + 'LP/get_report_complete',
							data: JSON.stringify({lugar : data.lugar, sede: data.sede,  fecha_ini : data.fecha1, fecha_fin : data.fecha2})
						};
					}
					if(a != undefined && b != undefined){
						request = {
							method: 'POST',
							url: url + 'LP/get_report_lp',
							data: JSON.stringify({lugar : data.lugar, sede: data.sede, fecha_ini : data.fecha1, fecha_fin : data.fecha2})
						};
					}

					$http(request)
						.then(function (jsonData) {
							alasql('SELECT * INTO XLSX("Listado.xlsx",?) FROM ?',[opts,jsonData.data]);
							//angular.element.unblockUI()

						})
						.catch(function (Object) {
							alert(Object.data);
						});


				}
			};

			$scope.function = function(data){

			}

			$scope.changefecha1 = function(){
				$scope.datos.fecha2 = null;
				$scope.fecha2Invalido = $scope.formUsuario.fecha_inicio.$invalid;
			};

			$scope.changefecha2 = function(){
				$scope.fechaInvalido = $scope.formUsuario.fecha_final.$invalid;
			};

			$scope.Download = function() {

				$http.get(grafica, {
					responseType: "arraybuffer"
				})
					.then(function(data) {
						//angular.element.blockUI()
						var anchor = angular.element('<a/>');
						//var blob = new Blob([data]);
						var blob = new Blob( [ data ]);
						anchor.attr({
							href: grafica,
							target: '_blank',
							download: 'Grafica.jpg'
						})[0].click();
						//angular.element.unblockUI()
					})
			};

		});

</script>


</html>
