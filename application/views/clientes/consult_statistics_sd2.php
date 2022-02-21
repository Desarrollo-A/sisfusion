<body>
<div class="wrapper">
    <?php include 'sidebarParams_statistics.php' ?>
    <div class="content" ng-controller="datos">
        <div class="container-fluid">
            <div class="header text-center">
                    <h3 class="title">Estadísticas generales</h3>
                <p class="category">Visualiza el estatus de todos tus avances</p>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="orange">
                            <i class="material-icons">people</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Prospectos</p>
                            <h3 class="card-title"><?= $prospectsNumber ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">access_time</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Prospectos vigentes</p>
                            <h3 class="card-title"><?= $currentProspectsNumber ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="purple">
                            <i class="material-icons">av_timer</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Prospectos no vigentes</p>
                            <h3 class="card-title"><?= $nonCurrentProspectsNumber ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="rose">
                            <i class="material-icons">group_add</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Clientes</p>
                            <h3 class="card-title"><?= $clientsNumber ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="purple">
                            <i class="material-icons">bubble_chart</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">Número general de tus prospectos actuales</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="formUsuario" name="formUsuario" novalidate>
                                    <!--<form id="formUsuario" name="formUsuario"  >-->
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div ng-app="myChart">
                                                        <canvas id="bar"
                                                                class="chart chart-line"
                                                                chart-data="data"
                                                                chart-labels="labels"
                                                                chart-options="options"
                                                                chart-colors="colours"
                                                                chart-dataset-override="datasetOverride"
                                                                chart-series="series">
                                                        </canvas>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                            <label>Etapa</label>
                                                            <select name="etapaSelect" id="etapaSelect" class="selectpicker form-control" data-style="select-with-transition" ng-model="datos.etapa" required>
                                                                <option value="">SELECCIONE UNA OPCIÓN</option>
                                                                <option value="0">PROSPECTOS</option>
                                                                <option value="1">CLIENTES</option>
                                                                <option value="2">PROSPECTOS & CLIENTES</option>
                                                            </select>
                                                            <span ng-show="etapaInvalido" style="color:white" ng-style="myStyle" >Por favor, seleccione una etapa</span>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label>Gerente</label>
                                                            <select name="managerSelect" id="managerSelect" onchange="getCoordinatorsBySubdirector(this);" class="selectpicker form-control" data-style="select-with-transition" ng-model="datos.gerente">
                                                                <option value="" disabled>SELECCONE UNA OPCIÓN</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                            <label>Coordinador</label>
                                                            <select name="coordinadoresSelect" id="coordinadoresSelect" class="selectpicker form-control" data-style="select-with-transition" onchange="getAdvisersByCoordinator(this)" ng-model="datos.coordinador">
                                                                <option value="" disabled>SELECCONE UNA OPCIÓN</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label>Asesor</label>
                                                            <select name="asesoresSelect" id="asesoresSelect" class="selectpicker form-control" data-style="select-with-transition" ng-model="datos.asesor">
                                                                <option value="" disabled>SELECCONE UNA OPCIÓN</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 form-group ">
                                                            <label>Fecha inicio</label>
                                                            <!--                                                <input type="text" class="form-control datepicker" value="10/10/2016" name="fecha_inicio" id="fecha_inicio"  ng-change="changefecha1()" ng-model="datos.fecha1" required />-->
                                                            <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" ng-change="changefecha1()" ng-model="datos.fecha1" required>
                                                            <!--                                                <span ng-show="fecha2Invalido" style="color:white" ng-style="myStyle">Por favor, introduzca una fecha</span>-->
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label>Fecha fin</label>
                                                            <!--                                                <input type="text" class="form-control datepicker" value="10/10/2016" name="fecha_final" id="fecha_final"  ng-change="changefecha2()" ng-model="datos.fecha2" required />-->
                                                            <input type="date" class="form-control" name="fecha_final" id="fecha_final" ng-change="changefecha2()" ng-model="datos.fecha2" required>
                                                            <!--                                                <span ng-show="fechaInvalido" style="color:white" ng-style="myStyle">Por favor, introduzca una fecha</span>-->
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4 form-group">
                                                            <button class="btn btn-round btn-fab btn-fab-mini" title="Generar gráfico nuevo" ng-click="ObtenerReporte(datos)" style="background-color: #884EA0; color: #FFFFFF;"><i class="material-icons">done</i></button>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <button type="button" style="background-color: #148F77" title="Restablecer datos" class="btn btn-round btn-fab btn-fab-mini" ng-click="Restablecer()"><i class="material-icons">replay</i></button>
                                                        </div>

                                                        <div class="col-md-4 form-group">
                                                            <button type="button" style="background-color: #0E6655" title="Descargar gráfica" class="btn btn-round btn-fab btn-fab-mini" ng-click="Download(datos)"><i class="material-icons">cloud_download</i></button>
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
                                                                <td ng-repeat="user in users" ng-show="HideColumn">{{user.prospectos}}</td>
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


            <!--<div class="row">
                <br><br>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-chart">
                        <div class="card-header" data-background-color="green" data-header-animation="true">
                            <div class="ct-chart" id="dailySalesChartPersonalized"></div>
                        </div>
                        <div class="card-content">
                            <div class="card-actions">
                                <button type="button" class="btn btn-danger btn-simple fix-broken-card">
                                    <i class="material-icons">build</i> ¡Reparar encabezado!
                                </button>
                                <button type="button" class="btn btn-info btn-simple" rel="tooltip" data-placement="bottom" title="Actualizar">
                                    <i class="material-icons">refresh</i>
                                </button>
                                <button type="button" class="btn btn-default btn-simple" rel="tooltip" data-placement="bottom" title="Descargar Excel">
                                    <i class="material-icons">cloud_download</i>
                                </button>
                                <button type="button" class="btn btn-default btn-simple" rel="tooltip" data-placement="bottom" title="Cambiar parámetros">
                                    <i class="material-icons">update</i>
                                </button>
                            </div>
                            <h4 class="card-title">Prospectos dados de alta
                                <small> por mes</small>
                            </h4>
                            <p class="category">
                                <span class="text-success"><i class="fa fa-long-arrow-up"></i> <?= $prospectsNumber ?> </span> prospectos hasta la fecha.</p>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> última actualización <?= date("F j, Y, g:i a") ?> .
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->

            <!--<div class="header text-center">
                <h3 class="title">Prospectos generados por plaza <small><?= date("Y") ?></small></h3>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-chart">
                        <div class="card-header" data-background-color="rose" data-header-animation="true">
                            <div class="ct-chart" id="dailySalesChartQro"></div>
                        </div>
                        <div class="card-content">
                            <div class="card-actions">
                                <button type="button" class="btn btn-danger btn-simple fix-broken-card">
                                    <i class="material-icons">build</i> ¡Reparar encabezado!
                                </button>
                                <button type="button" class="btn btn-info btn-simple" rel="tooltip" data-placement="bottom" title="Actualizar">
                                    <i class="material-icons">refresh</i>
                                </button>
                                <button type="button" class="btn btn-default btn-simple" rel="tooltip" data-placement="bottom" title="Descargar Excel">
                                    <i class="material-icons">cloud_download</i>
                                </button>
                                <button type="button" class="btn btn-default btn-simple" rel="tooltip" data-placement="bottom" title="Cambiar parámetros">
                                    <i class="material-icons">update</i>
                                </button>
                            </div>
                            <h4 class="card-title">Querétaro</h4>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> última actualización <?= date("F j, Y, g:i a") ?> .
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-chart">
                        <div class="card-header" data-background-color="purple" data-header-animation="true">
                            <div class="ct-chart" id="dailySalesChartCdmx"></div>
                        </div>
                        <div class="card-content">
                            <div class="card-actions">
                                <button type="button" class="btn btn-danger btn-simple fix-broken-card">
                                    <i class="material-icons">build</i> ¡Reparar encabezado!
                                </button>
                                <button type="button" class="btn btn-info btn-simple" rel="tooltip" data-placement="bottom" title="Actualizar">
                                    <i class="material-icons">refresh</i>
                                </button>
                                <button type="button" class="btn btn-default btn-simple" rel="tooltip" data-placement="bottom" title="Descargar Excel">
                                    <i class="material-icons">cloud_download</i>
                                </button>
                                <button type="button" class="btn btn-default btn-simple" rel="tooltip" data-placement="bottom" title="Cambiar parámetros">
                                    <i class="material-icons">update</i>
                                </button>
                            </div>
                            <h4 class="card-title">Ciudad de México</h4>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> última actualización <?= date("F j, Y, g:i a") ?> .
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->

	<?php $this->load->view('template/footer_legend');?>
</div>
</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>
<script src="<?php base_url()?>dist/js/controllers/clientes/statistics-1.1.0.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?php base_url()?>dist/js/moment.min.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?php base_url()?>dist/js/bootstrap-datetimepicker.js"></script>
<!-- Sliders Plugin -->
<script src="<?php base_url()?>dist/js/nouislider.min.js"></script>
<!--  Full Calendar Plugin    -->
<script src="<?php base_url()?>dist/js/fullcalendar.min.js"></script>

<script src="<?=base_url()?>dist/js/controllers/clientes/alasql.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/clientes/xlsx.core.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/clientes/angular.min.js"></script>

<script src="<?php base_url()?>dist/js/Chart.js"></script>
<!--<script src="--><?php //base_url()?><!--dist/js/chartist.min.js"></script>-->
<script src="<?php base_url()?>dist/js/angular/angular-chart.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/clientes/charts-1.1.0.js"></script>

<script>
    $(document).ready(function () {
       // $('#avisoNovedades').modal();
    });    
    var myApp = angular.module('CRM', ["chart.js"]);
    var today = new Date();
    var year = today.getFullYear();
    var grafica;
    var ttipo = 'PROSPECTOS '; var ta = year; var ass = '';
    var texto = ttipo + ass + ta;
    var maxnumber;

    myApp.controller('datos',
        function ($scope, $http) {
            // REQUEST OPTIONS USING GET METHOD.
            // angular.element.blockUI()
            $scope.HideColumn = false;
            $scope.test = "false";
            $scope.tipoDecliente2= "Clientes";
            $scope.tipoDecliente  = "Prospectos";
            $scope.series = ['Prospectos'];
            var request = {
                method: 'get',
                url: 'Statistics/get_total_director',
                dataType: 'json',
                contentType: "application/json"
            };

            $scope.etapas = [{
                value: 0,
                label: 'PROSPECTOS'
            }, {
                value: 1,
                label: 'CLIENTES'
            }, {
                value: 2,
                label: 'PROSPECTOS Y CLIENTES'
            }];


            var opts = {sheetid : ' Reporte',
                headers:true,
                column: {style:{Font:{Bold:"1",Color: "#3C3741"}}},
                rows: {1:{style:{Font:{Color:"#FF0077"}}}},
                cells: {1:{1:{
                            style: {Font:{Color:"#00FFFF"}}
                        }}}


            };

            // MAKE REQUEST USING $http SERVICE.
            $http(request)
                .then(function (jsonData) {
                    $scope.CrearGrafica(jsonData.data);
                    $scope.options = {
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
                            text: texto,
                            fontSize: 20
                        },

                        legend: {
                            display: true ,
                            position: 'bottom'
                        }
                    };
                    //angular.element.unblockUI()
                })
                .catch(function (Object) {
                    //alert(Object.data);
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                });



            // NOW, ADD COLOURS TO THE BARS.
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

            $scope.changecoordinador = function(datos){
                var request1 = { };
                if(datos.coordinador){
                    //angular.element.blockUI()
                    request1 = {
                        method: 'POST',
                        url: 'Statistics/get_asesores_coordinadores',
                        data: JSON.stringify({coordinador: datos.coordinador, gerente: datos.gerente })
                    };

                    $http(request1)
                        .then(function successCallback(response) {
                            $scope.asesores = response.data;
                            //angular.element.unblockUI()
                        })
                        .catch(function (Object) {
                            // alert(Object.data);
                            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                        });


                }
                $scope.datos.fecha1 = null;
                $scope.datos.fecha2 = null;
                $scope.datos.asesor = null;
            }

            $scope.Cambio = function(datos){
                var request2 = { };

                if(datos.gerente){
                    //angular.element.blockUI()
                    request2 = {
                        method: 'POST',
                        url: 'Statistics/get_coordinadores_bysub',
                        data: JSON.stringify({gerente: datos.gerente})
                    };

                    $http(request2)
                        .then(function successCallback(response) {
                            $scope.coordinadores = response.data;
                            //angular.element.unblockUI()
                        })
                        .catch(function (Object) {
                            //alert(Object.data);
                            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                        });


                }
                $scope.datos.fecha1 = null;
                $scope.datos.fecha2 = null;
                $scope.datos.asesor = null;
                $scope.datos.coordinador = null;
                $scope.gerenteInvalido = false;
            };

            $scope.changeetapa = function(){
                $scope.datos.fecha1 = null;
                $scope.datos.fecha2 = null;
                $scope.datos.asesor = null;
                $scope.datos.gerente = null;
                $scope.datos.coordinador = null;
                $scope.etapaInvalido = false;
            };

            $scope.changeasesor = function(){
                $scope.datos.fecha1 = null;
                $scope.datos.fecha2 = null;

            };

            $scope.changefecha1 = function(){
                $scope.datos.fecha2 = null;
                $scope.fecha2Invalido = false;
            };

            $scope.changefecha2 = function(){
                $scope.fechaInvalido = false;
            };

            $scope.Restablecer = function(){
                if($scope.formUsuario.etapaSelect.$viewValue == undefined){
                    //angular.element.blockUI()
                    //angular.element.unblockUI()
                }
                else{
                    var currentdate = new Date(); var currentyear = currentdate.getFullYear();
                    var a = currentyear+"/01/01";
                    var b = currentyear+"/12/31";
                    var c = 0;
                    $scope.formUsuario.etapaSelect.$viewValue = 0;
                    $scope.tipoDecliente = "Prospectos";
                    //angular.element.blockUI()
                    $scope.test = "true";
                    request = {
                        method: 'get',
                        url: 'Statistics/get_total_director',
                        dataType: 'json',
                        contentType: "application/json"
                    };
                    $http(request)
                        .then(function (jsonData) {
                            ttipo = 'PROSPECTOS';

                            var yr = a.substring(0, 4);

                            $scope.CrearGrafica(jsonData.data);


                            if(c == "0"){
                                $scope.series = ['Prospectos'];
                            }
                            else{
                                $scope.series = ['Clientes'];
                            }
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
                                    text: ttipo + " " + yr,
                                    fontSize: 20
                                }
                            };



                        }) //fin then function
                        .catch(function (Object) {
                            //alert(Object.data);
                            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                        })
                        .finally(function () {
                            $scope.searchButtonText = "Aplicar Filtros";
                            $scope.datos.etapa = null;
                            $scope.datos.asesor = null;
                            $scope.datos.fecha1 = null;
                            $scope.datos.fecha2 = null;
                            $scope.datos.gerente = null;
                            $scope.datos.coordinador = null;
                            //angular.element.unblockUI()
                        });
                }
            };

            $scope.CrearGrafica = function(data){
                var tipo_grafica = $scope.formUsuario.etapaSelect.$viewValue;

                if(tipo_grafica == "0" || tipo_grafica == "1" || tipo_grafica == undefined){
                    //tipo_grafica == "0"
                    $scope.HideColumn = false;
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
                else{
                    $scope.HideColumn = true;
                    $scope.tipoDecliente = "Clientes";
                    $scope.tipoDecliente2 = "Prospectos";
                    $scope.users = data;
                    $scope.arrData = new Array;
                    $scope.arrLabels = new Array;
                    $scope.arrData2 = new Array;
                    // LOOP THROUGH DATA IN THE JSON FILE.
                    angular.forEach(data, function (item) {
                        $scope.arrData.push(item.clientes);
                        $scope.arrData2.push(item.prospectos);
                        $scope.arrLabels.push(item.mes);
                    });
                    var ax1 = Math.max.apply(Math,$scope.arrData) + 10;
                    var ax2 = Math.max.apply(Math,$scope.arrData2) + 10;
                    if(ax1>ax2){
                        maxnumber = ax1;
                    }
                    else{
                        maxnumber = ax2;
                    }
                    $scope.data = new Array;
                    $scope.labels = new Array;
                    $scope.series = ['Clientes', 'Prospectos'];

                    // UPDATE SCOPE PROPERTIES “data” and “label” FOR DATA.
                    $scope.data.push($scope.arrData.slice(0),$scope.arrData2.slice(0));

                    for (var i = 0; i < $scope.arrLabels.length; i++) {
                        $scope.labels.push($scope.arrLabels[i]);
                    }
                }


            }

            $scope.ObtenerReporte = function(data){

                $scope.gerenteInvalido = $scope.formUsuario.managerSelect.$invalid;
                $scope.etapaInvalido = $scope.formUsuario.etapaSelect.$invalid;
                $scope.fechaInvalido = $scope.formUsuario.fecha_final.$invalid;
                $scope.fecha2Invalido = $scope.formUsuario.fecha_inicio.$invalid;
                $scope.myStyle = {'color':'red'}
                var a = $scope.formUsuario.fecha_inicio.$viewValue;
                var b = $scope.formUsuario.fecha_final.$viewValue;
                var c = $scope.formUsuario.etapaSelect.$viewValue;
                var d = $scope.formUsuario.asesoresSelect.$viewValue;
                var e = $scope.formUsuario.managerSelect.$viewValue;
                var f = $scope.formUsuario.coordinadoresSelect.$viewValue;
                var name = "";

                if(a == "" || b == "" || c == undefined || e == undefined){

                }else{
                    //angular.element.blockUI()
                    if(c == "1"){$scope.tipoDecliente = "Clientes";}
                    else {$scope.tipoDecliente = "Prospectos";}

                    //Grafica por coordinador
                    if(d == undefined && f != undefined && e != undefined){
                        var aas = $scope.datos.coordinador;
                        /*name = $.grep($scope.coordinadores, function (data) {
                            return data.id_coordinadores == aas;
                        })[0].nombre_coordinadores;*/
                        request = {
                            method: 'POST',
                            url: 'Statistics/get_chart_dir_bycoord',
                            data: JSON.stringify({tipo : data.etapa, gerente: data.gerente, coordinador : data.coordinador, fecha_ini : data.fecha1, fecha_fin : data.fecha2})
                        };
                    }
                    //graficaa por gerente
                    if(d == undefined && f == undefined){
                        var aas = $scope.datos.gerente;
                        /*name = $.grep($scope.gerentes, function (data) {
                            return data.id_managers == aas;
                        })[0].nombre_managers;*/
                        request = {
                            method: 'POST',
                            url: 'Statistics/get_chart_dir_byger',
                            data: JSON.stringify({tipo : data.etapa, gerente: data.gerente, fecha_ini : data.fecha1, fecha_fin : data.fecha2})
                        };
                    }
                    //grafica por asesor
                    if(d != undefined){
                        var aas = $scope.datos.asesor;
                        /*name = $.grep($scope.asesores, function (data) {
                            return data.id_asesores == aas;
                        })[0].nombre_asesores;*/
                        request = {
                            method: 'POST',
                            url: 'Statistics/get_chart_gerente',
                            data: JSON.stringify({tipo : data.etapa, gerente: data.gerente, asesor : data.asesor, fecha_ini : data.fecha1, fecha_fin : data.fecha2})
                        };
                    }

                    $scope.test = "true";

                    $http(request)
                        .then(function (jsonData) {
                            var tttipo = $scope.datos.etapa;
                            ttipo = $.grep($scope.etapas, function (data) {
                                return data.value == tttipo;
                            })[0].label;

                            var yr = a.substring(0, 4);


                            $scope.CrearGrafica(jsonData.data);

                            if(c == "0" || c == "1"){
                                if(c == "0"){
                                    $scope.series = ['Prospectos'];
                                }
                                else{
                                    $scope.series = ['Clientes'];
                                }
                                $scope.options = {
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
                                        text: ttipo + " " + name + " "+ yr,
                                        fontSize: 20
                                    },

                                    legend: {
                                        display: true ,
                                        position: 'bottom'
                                    }
                                };
                            }
                            else{
                                $scope.series = ['Clientes', 'Prospectos'];
                                $scope.datasetOverride = [{ yAxisID: 'y-axis-1' }, { yAxisID: 'y-axis-2' }];
                                $scope.options = {
                                    scales: {
                                        yAxes: [
                                            {
                                                id: 'y-axis-1',
                                                type: 'linear',
                                                display: true,
                                                position: 'left',
                                                ticks: {min: 0,
                                                    max: maxnumber}
                                            },
                                            {
                                                id: 'y-axis-2',
                                                type: 'linear',
                                                display: true,
                                                position: 'right',
                                                ticks: {min: 0,
                                                    max: maxnumber}
                                            }
                                        ]
                                    },
                                    animation : {
                                        onComplete : function(datooos){
                                            grafica = datooos.chartInstance.toBase64Image();
                                            //console.log(grafica);
                                        }
                                    },

                                    title: {
                                        display: true,
                                        text: ttipo + " " + name + " "+ yr,
                                        fontSize: 20
                                    },

                                    legend: {
                                        display: true ,
                                        position: 'bottom'
                                    }
                                };
                            }
                        })
                        .catch(function (Object) {
                            //alert(Object.data);
                            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                        })
                        .finally(function () {
                            $scope.searchButtonText = "Aplicar Filtros";
                            //angular.element.unblockUI()

                        });
                }

            }

            $scope.exportData = function (data) {
                //angular.element.blockUI()
                request = {
                    method: 'POST',
                    url: 'Statistics/get_repo_dir'
                };
                $http(request)
                    .then(function (jsonData) {


                        alasql('SELECT * INTO XLSX("Listado.xlsx",?) FROM ?',[opts,jsonData.data]);
                        //angular.element.unblockUI()

                    })
                    .catch(function (Object) {
                        //alert(Object.data);
                        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    });
            };

            $scope.exportData1 = function (data) {

                var a = $scope.formUsuario.fecha_inicio.$viewValue;
                var b = $scope.formUsuario.fecha_final.$viewValue;
                var c = $scope.formUsuario.etapaSelect.$viewValue;
                var d = $scope.formUsuario.asesoresSelect.$viewValue;
                var e = $scope.formUsuario.managerSelect.$viewValue;
                var f = $scope.formUsuario.coordinadoresSelect.$viewValue;

                if(a == "" || b == "" || c == undefined || e == undefined){
                    $scope.gerenteInvalido = $scope.formUsuario.managerSelect.$valid;
                    $scope.etapaInvalido = $scope.formUsuario.etapaSelect.$valid;
                    $scope.fechaInvalido = $scope.formUsuario.fecha_final.$valid;
                    $scope.fecha2Invalido = $scope.formUsuario.fecha_inicio.$valid;
                    $scope.myStyle = {'color':'red'}

                    //angular.element.blockUI()
                    request = {
                        method: 'POST',
                        url: 'Statistics/get_repo_dir_general'
                    };
                    $http(request)
                        .then(function (jsonData) {


                            alasql('SELECT * INTO XLSX("Listado.xlsx",?) FROM ?',[opts,jsonData.data]);
                            //angular.element.unblockUI()

                        })
                        .catch(function (Object) {
                            //alert(Object.data);
                            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                        });
                }else{
                    //angular.element.blockUI()

                    //Reporte por coordinador
                    if(d == undefined && f != undefined && e != undefined){
                        request = {
                            method: 'POST',
                            url: 'Statistics/get_repo_dir_bycoord',
                            data: JSON.stringify({tipo : data.etapa, gerente: data.gerente, coordinador : data.coordinador, fecha_ini : data.fecha1, fecha_fin : data.fecha2})
                        };
                    }
                    //Reporte por gerente
                    if(d == undefined && f == undefined){
                        request = {
                            method: 'POST',
                            url: 'Statistics/get_repo_dir_byger',
                            data: JSON.stringify({tipo : data.etapa, gerente: data.gerente, fecha_ini : data.fecha1, fecha_fin : data.fecha2})
                        };
                    }
                    //reporte por asesor
                    if(d != undefined){
                        request = {
                            method: 'POST',
                            url: 'Statistics/get_repo_dir1',
                            data: JSON.stringify({tipo : data.etapa, gerente : data.gerente, asesor : data.asesor, fecha_ini : data.fecha1, fecha_fin : data.fecha2})
                        };
                    }
                    $http(request)
                        .then(function (jsonData) {
                            alasql('SELECT * INTO XLSX("Listado.xlsx",?) FROM ?',[opts,jsonData.data]);
                            //angular.element.unblockUI()

                        })
                        .catch(function (Object) {
                            //alert(Object.data);
                            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                        });
                }
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
                            download: 'prospects_chart.jpg'
                        })[0].click();
                        //angular.element.unblockUI()
                    })
            };

        });

</script>

<script>

    $(document).ready(function() {
        estadisticas.initDashboardPageCharts();
        estadisticas.initVectorMap();
        estadisticas.initCharts();
    });

    dataDailySalesChartPersonalized = {
        labels: [
            <?php
            $month_name = array();
            for ($i = 0; $i < COUNT($month_name); $i++) {
                echo $month_name[$i].",";
            }
            ?>
        ],
        series: [
            [
                <?php
                 $prospects_number = array();
                for ($ii = 0; $ii < COUNT($prospects_number); $ii++) {
                    echo $prospects_number[$ii].",";
                }
                ?>
            ]
        ]
    };

    dataDailySalesChartSlp = {
        labels: [],
        series: [[]]
    };

    dataDailySalesChartQro = {
        labels: [
            <?php
            $qro_name = array();
            for ($i = 0; $i < COUNT($qro_name); $i++) {
                echo $qro_name[$i].",";
            }
            ?>
        ],
        series: [
            [
                <?php
                  $qro_number = array();
                for ($i = 0; $i < COUNT($qro_number); $i++) {
                    echo $qro_number[$i].",";
                }
                ?>
            ]
        ]
    };

    dataDailySalesChartPen = {
        labels: [],
        series: [[]]
    };

    dataDailySalesChartCdmx = {
        labels: [
            <?php
            $cdmx_name = array();
            for ($i = 0; $i < COUNT($cdmx_name); $i++) {
                echo $cdmx_name[$i].",";
            }
            ?>
        ],
        series: [
            [
                <?php
                $cdmx_number = array();
                for ($i = 0; $i < COUNT($cdmx_number); $i++) {
                    echo $cdmx_number[$i].",";
                }
                ?>
            ]
        ]
    };

    dataDailySalesChartLeo = {
        labels: [],
        series: [[]]
    };

    dataDailySalesChartCan = {
        labels: [],
        series: [[]]
    };

</script>

</html>
