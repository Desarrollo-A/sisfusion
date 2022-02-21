<body class="">
<div class="wrapper ">

    <?php
        $dato= array(
            'home' => 0,
            'usuarios' => 0,
            'statistics' => 0,
            'manual' => 0,
            'aparta' => 0,
            'prospectos' => 0,
            'prospectosMktd' => 0,
            'prospectosAlta' => 0,
            'corridaF' => 0,
            'inventario' => 0,
            'inventarioDisponible' => 0,
            'sharedSales' => 0,
            'coOwners' => 0,
            'references' => 0,
            'bulkload' => 0,
            'statistics1' => 1,
            'statistics2' => 0
        );

        $this->load->view('template/sidebar', $dato);

    ?>

    <div class="content" ng-controller="datos">
        <div class="container-fluid">


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="green">
                            <i class="material-icons">multiline_chart</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">Marketing digital</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="formUsuario" name = "formUsuario" ng-submit="function()" novalidate>
                                        <dir-custom-loader class="ng-hide"></dir-custom-loader>
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <label>Lugar de prospección</label>
                                                <select name="lugarSelect" class="form-control" id="lugarSelect" ng-model="datos.lugar" ng-options="item3.id_lugares as item3.nombre_lugares for item3 in lugares">
                                                    <option value="">Seleccione un lugar</option>

                                                </select>
                                            </div>

                                            <div class="col-md-3 form-group">
                                                <label>Sede</label>
                                                <select name="sedeSelect" class="form-control" id="sedeSelect"  ng-change="changesede(datos)" ng-model="datos.sede" ng-options="item3.id_sedes as item3.nombre_sedes for item3 in sedes">
                                                    <option value="">Seleccione una sede</option>
                                                </select>
                                                <span ng-show="etapaInvalido" style="color:white" ng-style="myStyle" >Por favor, seleccione una sede</span>
                                            </div>

                                            <div class="col-md-3 form-group" style="font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                                                <label>Asesor</label>
                                                <select name="asesoresSelect" class="form-control searchAsesoresMkt" id="asesoresSelect" ng-model="datos.asesor" ng-options="item4.id_asesores as item4.nombre_asesores for item4 in asesores">
                                                    <option value="">Seleccione una asesor</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3 form-group">
                                                <br/>
                                                <button type="button" ng-click="ObtenerReporte(datos)" title="Generar Gráfico Nuevo" class="btn btn-primary btn-block" ><span ng-show="searchButtonText == 'Searching'"><i class="glyphicon glyphicon-refresh spinning"></i></span>
                                                    {{ searchButtonText }}</button>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label>Fecha inicio</label>
                                                <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" ng-change="changefecha1()" ng-model="datos.fecha1" required>
                                            </div>

                                            <div class="col-md-3 form-group">
                                                <label>Fecha final</label>
                                                <input type="date" class="form-control" name="fecha_final" id="fecha_final"  ng-change="changefecha2()" ng-model="datos.fecha2" required>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-10">
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

                                            <div id = "tabla" class="col-md-2" ng-model="datos.tabla">
                                                <table>
                                                    <tr>
                                                        <th style="border:1px solid black; text-align:center; width:70px;">Mes</th>
                                                        <th style="border:1px solid black; text-align:center;">{{ tipoDecliente }}</th>
                                                    </tr>
                                                    <tr ng-repeat="user in users">
                                                        <td style="border:1px solid black; text-align:center;">{{user.mes}}</td>
                                                        <td style="border:1px solid black; text-align:center; width:70px;">{{user.clientes}}</td>
                                                    </tr>
                                                </table>

                                            </div>

                                        </div>
                                        <div class="row">

                                            <div class="col-md-3">
                                                <button type="button" title="Descargar Gráfica" class="btn btn-primary btn-block" ng-click="Download(datos)">Descargar Gráfica</button>
                                            </div>

                                            <div class="col-md-3">
                                                <button type="button" title="Exportar Listado a Excel" class="btn btn-success btn-block" ng-click="exportData(datos)">Exportar Listado</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

	<?php $this->load->view('template/footer_legend');?>
</div>
</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>

<script type="application/javascript" src="<?=base_url()?>dist/js/controllers/clientes/alasql.min.js"></script>
<script type="application/javascript" src="<?=base_url()?>dist/js/controllers/clientes/xlsx.core.min.js"></script>
<script type="application/javascript" src="<?=base_url()?>dist/js/controllers/clientes/angular.min.js"></script>

<script type="application/javascript" src="<?php base_url()?>dist/js/Chart.js"></script>
<script type="application/javascript" src="<?php base_url()?>dist/js/angular/angular-chart.min.js"></script>
<script type="application/javascript" src="<?=base_url()?>dist/js/controllers/clientes/charts-1.1.0.js"></script>

<script>
    var myApp = angular.module('CRM', ["chart.js"]);
    var grafica;
    var prueba;
    var ttipo = 'PROSPECTOS '; var ta = new Date().getFullYear();
    var texto = ttipo + ta;
    var maxnumber;
    var tipo_grafica;


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
                url: 'Statistics/get_total_mkt',
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
                            text: 'MARKETING DIGITAL',
                            fontSize: 20
                        }
                    };
                    //angular.element.unblockUI()
                })
                .catch(function (Object) {
                    //alert(Object.data);
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
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

            $scope.changesede = function(datos){
                var request2 = { };
                if(datos.sede){
                    //angular.element.blockUI()
                    request2 = {
                        method: 'POST',
                        url: 'Statistics/get_asesores',
                        data: JSON.stringify({sede: datos.sede})
                    };

                    $http(request2)
                        .then(function successCallback(response) {
                            $scope.asesores = response.data;
                        })
                        .catch(function (Object) {
                            //alert(Object.data);
                            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                        });
                    //angular.element.unblockUI()

                }

            };

            $scope.ObtenerReporte = function(data){
                $scope.myStyle = {'color':'red'}
                var a = $scope.formUsuario.lugarSelect.$viewValue;
                var b = $scope.formUsuario.sedeSelect.$viewValue;
                var c = $scope.formUsuario.asesoresSelect.$viewValue;

                if(a == undefined || b == undefined){

                }else{
                    if(a != undefined && b != undefined && c != undefined){
                        request = {
                            method: 'POST',
                            url: 'Statistics/get_chart_complete',
                            data: JSON.stringify({lugar : data.lugar, sede: data.sede, asesor: data.asesor,  fecha_ini : data.fecha1, fecha_fin : data.fecha2})
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
                                        text: 'MARKETING DIGITAL',
                                        fontSize: 20
                                    }
                                };

                            })

                    }
                    if(a != undefined && b != undefined && (c == undefined || c == null)){
                        request = {
                            method: 'POST',
                            url: 'Statistics/get_chart_mkt',
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
                                        text: 'MARKETING DIGITAL',
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
                var c = $scope.formUsuario.asesoresSelect.$viewValue;

                if(a == undefined || b == undefined){
                    $("#Modal_export").modal("show");
                }
                else{
                    //angular.element.blockUI()
                    if(a != undefined && b != undefined && c != undefined){
                        request = {
                            method: 'POST',
                            url: 'Statistics/get_report_complete',
                            data: JSON.stringify({lugar : data.lugar, sede: data.sede, asesor: data.asesor,  fecha_ini : data.fecha1, fecha_fin : data.fecha2})
                        };
                    }
                    if(a != undefined && b != undefined && (c == undefined || c == null)){
                        request = {
                            method: 'POST',
                            url: 'Statistics/get_report_mkt',
                            data: JSON.stringify({lugar : data.lugar, sede: data.sede, fecha_ini : data.fecha1, fecha_fin : data.fecha2})
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
                            download: 'prospects_chart.jpg'
                        })[0].click();
                        //angular.element.unblockUI()
                    })
            };

        });
</script>

</html>
