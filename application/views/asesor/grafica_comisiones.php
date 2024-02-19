<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content"
             ng-controller="graficaComisiones">
            <div class="container-fluid">
                <div class="header text-center">
                    <h3 class="title">Estadísticas de comisiones</h3>
                    <p class="category">Visualiza los datos de las comisiones</p>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon"
                                 data-background-color="purple">
                                <i class="material-icons">bubble_chart</i>
                            </div>

                            <div class="card-content">
                                <h4 class="card-title">Número de comisiones de asesores</h4>
                                <form id="opcionesForm"
                                      name="opcionesForm"
                                      novalidate>
                                    <div class="row">
                                        <div class="col-lg-8 col-md-12">
                                            <div ng-app="grafica-comision">
                                                <canvas id="bar"
                                                        class="chart chart-line"
                                                        chart-data="data"
                                                        chart-labels="labels"
                                                        chart-options="options"
                                                        chart-dataset-override="datasetOverride"
                                                        chart-series="series"
                                                        chart-colors="colors">
                                                </canvas>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <div class="row">
                                                <div class="col-lg-12 form-group">
                                                    <label for="anio">Año</label>
                                                    <input type="number"
                                                           class="form-control"
                                                           name="anio"
                                                           id="anio"
                                                           min="2000"
                                                           max="9999"
                                                           ng-model="anio"
                                                           required>
                                                </div>
                                                <div class="col-lg-12 form-group">
                                                    <label for="mes">Mes</label>
                                                    <select id="mes"
                                                            name="mes"
                                                            class="selectpicker form-control"
                                                            data-style="select-with-transition"
                                                            ng-model="mes">
                                                        <option value="">SELECCIONA UNA OPCIÓN</option>
                                                        <option value="1">ENERO</option>
                                                        <option value="2">FEBRERO</option>
                                                        <option value="3">MARZO</option>
                                                        <option value="4">ABRIL</option>
                                                        <option value="5">MAYO</option>
                                                        <option value="6">JUNIO</option>
                                                        <option value="7">JULIO</option>
                                                        <option value="8">AGOSTO</option>
                                                        <option value="9">SEPTIEMBRE</option>
                                                        <option value="10">OCTUBRE</option>
                                                        <option value="11">NOVIEMBRE</option>
                                                        <option value="12">DICIEMBRE</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="col-md-4 form-group">
                                                        <button class="btn btn-round btn-fab btn-fab-mini"
                                                                title="Generar gráfico"
                                                                ng-click="generarGrafica()"
                                                                style="background-color: #884EA0; color: #FFFFFF;">
                                                            <i class="material-icons">done</i>
                                                        </button>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <button type="button"
                                                                style="background-color: #148F77"
                                                                title="Restablecer datos"
                                                                class="btn btn-round btn-fab btn-fab-mini"
                                                                ng-click="reestablecer()">
                                                            <i class="material-icons">replay</i>
                                                        </button>
                                                    </div>

                                                    <div class="col-md-4 form-group">
                                                        <button type="button"
                                                                style="background-color: #0E6655"
                                                                title="Descargar gráfica"
                                                                class="btn btn-round btn-fab btn-fab-mini"
                                                                ng-click="download()">
                                                            <i class="material-icons">cloud_download</i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <div class="table-responsive">
                                                        <table class="table-striped table-hover"
                                                               id="usuarios-table">
                                                            <thead class="text-primary">
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Nombre</th>
                                                                <th>Año</th>
                                                                <th>Mes</th>
                                                                <th>Total lotes</th>
                                                                <th>Total comisiones</th>
                                                                <th>Total pagos</th>
                                                            </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
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

        <?php $this->load->view('template/footer_legend');?>
    </div>
    <?php $this->load->view('template/footer'); ?>
    <script src="<?=base_url()?>dist/js/controllers/clientes/statistics-1.1.0.js"></script>
    <!--  Plugin for Date Time Picker and Full Calendar Plugin-->
    <script src="<?=base_url()?>dist/js/moment.min.js"></script>
    <!-- DateTimePicker Plugin -->
    <script src="<?=base_url()?>dist/js/bootstrap-datetimepicker.js"></script>

    <script src="<?=base_url()?>dist/js/controllers/clientes/alasql.min.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/clientes/xlsx.core.min.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/clientes/angular.min.js"></script>

    <script src="<?=base_url()?>dist/js/Chart.js"></script>
    <script src="<?=base_url()?>dist/js/angular/angular-chart.min.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/clientes/charts-1.1.0.js"></script>

    <script>
        const baseUrl = '<?=base_url()?>';
        const myApp = angular.module('CRM', ['chart.js']);
        const currentAnio = new Date().getFullYear();
        let tituloGraficaInit = `Gráfica del año ${currentAnio}`;
        let grafica;
        let usuariosTable;
        let titles

        $('#usuarios-table').ready(function () {
            titles = [];

            $('#usuarios-table thead tr:eq(0) th').each(function (i) {
                if (i !== 0) {
                    const title = $(this).text();
                    titles.push(title);

                    $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
                    $('input', this).on('keyup change', function () {
                        if (usuariosTable.column(i).search() !== this.value) {
                            usuariosTable.column(i).search(this.value).draw();
                        }
                    });
                }
            });

            createDataTable(currentAnio, 0);
        });

        myApp.controller('graficaComisiones', function ($scope, $http) {
            $scope.series = ['Lotes', 'Comisiones', 'Pagos'];
            $scope.anio = currentAnio;
            $scope.colors = ['#FF5BFD', '#4AA4F9', '#38DF0F'];

            $http(urlRequestGraphic(currentAnio, 0))
                .then(function (jsonData) {
                    convertData(jsonData.data)
                    $scope.crearGrafica(jsonData.data);
                    $scope.options = optionsTableAnual();
                });

            $scope.crearGrafica = function (data) {
                $scope.arrDataLotes = [];
                $scope.arrDataComisiones = [];
                $scope.arrDataPagos = [];
                $scope.arrLabels = [];

                angular.forEach(data, function (item) {
                    $scope.arrDataLotes.push(item['lotes']);
                    $scope.arrDataComisiones.push(item['comisiones']);
                    $scope.arrDataPagos.push(item['pagos']);
                    if (item.mes !== null) {
                        $scope.arrLabels.push(item.mes);
                    } else {
                        $scope.arrLabels.push(item.nombre);
                    }
                });

                $scope.data = [];
                $scope.labels = [];

                $scope.data.push(
                    $scope.arrDataLotes,
                    $scope.arrDataComisiones,
                    $scope.arrDataPagos
                );

                for (let i = 0; i < $scope.arrLabels.length; i++) {
                    $scope.labels.push($scope.arrLabels[i]);
                }
            };
            
            $scope.generarGrafica = function () {
                const isValid = $scope.opcionesForm.$valid;

                if (isValid) {
                    const mesForm = $scope.opcionesForm.mes.$viewValue;

                    const anio = $scope.opcionesForm.anio.$viewValue;
                    const mes = (mesForm === undefined || mesForm === '') ? 0 : Number.parseInt(mesForm);

                    createDataTable(anio, mes);
                    $http(urlRequestGraphic(anio, mes))
                        .then(function (jsonData) {
                            convertData(jsonData.data)
                            $scope.crearGrafica(jsonData.data);

                            $scope.options.title.text = (mes === 0)
                                ? `Gráfica del año ${anio}`
                                : `Top 5 de ${convertNumberToMonth(mes)} del ${anio}`;
                        });
                } else {
                    alerts.showNotification("top", "right", "El año es obligatorio.", "danger");
                }
            };

            $scope.reestablecer = function () {
                /*$scope.series = ['Lotes', 'Comisiones', 'Pagos'];
                $scope.anio = currentAnio;
                delete $scope.mes;

                createDataTable(currentAnio, 0);
                $http(urlRequestGraphic(currentAnio, 0))
                    .then(function (jsonData) {
                        convertData(jsonData.data)
                        $scope.crearGrafica(jsonData.data);
                        $scope.options = optionsTableAnual();
                    });*/
                location.reload();
            };

            $scope.download = function () {
                $http.get(grafica, {
                    responseType: 'arraybuffer'
                }).then(function (data) {
                    const anchor = angular.element('<a/>');
                    const blob = new Blob( [ data ]);
                    anchor.attr({
                        href: grafica,
                        target: '_blank',
                        download: 'gráfica_comisiones.jpg'
                    })[0]
                        .click();
                });
            };
        });

        function createDataTable(anio, mes) {
            usuariosTable = $('#usuarios-table').DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Descargar archivo de Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6],
                            format: {
                                header: function (d, columnIdx) {
                                    if (columnIdx === 0) {
                                        return ' ID Usuario ';
                                    } else {
                                        return ' ' + titles[columnIdx - 1] + ' ';
                                    }
                                }
                            }
                        }
                    }
                ],
                pagingType: 'full_numbers',
                fixedHeader: true,
                language: {
                    url: `${baseUrl}/static/spanishLoader_v2.json`,
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columns: [
                    {
                        width: '10%',
                        data : function (d) {
                            return '<p class="m-0">'+d.id_usuario+'</p>';
                        }
                    },
                    {
                        width: '35%',
                        data : function (d) {
                            return '<p class="m-0">'+d.nombre_completo.toUpperCase()+'</p>';
                        }
                    },
                    {
                        width: '5%',
                        data : function (d) {
                            return '<p class="m-0">'+d.anio+'</p>';
                        }
                    },
                    {
                        width: '5%',
                        data : function (d) {
                            return '<p class="m-0">'+convertNumberToMonth(d.mes)+'</p>';
                        }
                    },
                    {
                        width: '15%',
                        data : function (d) {
                            return '<p class="m-0">'+formatMoney(d.lotes)+'</p>';
                        }
                    },
                    {
                        width: '15%',
                        data : function (d) {
                            return '<p class="m-0">'+formatMoney(d.comisiones)+'</p>';
                        }
                    },
                    {
                        width: '15%',
                        data : function (d) {
                            return '<p class="m-0">'+formatMoney(d.pagos)+'</p>';
                        }
                    }
                ],
                columnDefs: [{
                    searchable: false,
                    orderable: false,
                    targets: 0
                }],
                ajax: {
                    url: urlRequestTable(anio, mes),
                    dataSrc: '',
                    type: 'GET',
                    cache: false,
                    data: function (d) {}
                }
            });
        }
        
        function optionsTableAnual() {
            return {
                legend: {
                    display: true ,
                    position: 'bottom'
                },
                scales: {
                    yAxes: [
                        {
                            id: 'y-axis-1',
                            type: 'linear',
                            position: 'left',
                            ticks: {
                                min: 0
                            }
                        }
                    ]
                },
                animation : {
                    onComplete : function (data) {
                        grafica = data.chartInstance.toBase64Image();
                    }
                },
                title: {
                    display: true,
                    text: tituloGraficaInit,
                    fontSize: 20
                }
            };
        }

        function urlRequestTable(anio, mes) {
            return `${baseUrl}Statistics/getDataAsesorGraficaTabla/${anio}/${mes}`;
        }

        function urlRequestGraphic(anio, mes) {
            let request = {
                method: 'get',
                dataType: 'json',
                contentType: 'application/json'
            };

            request.url = (mes === 0)
                ? request.url = `${baseUrl}Statistics/getDataAsesorGrafica/${anio}`
                : request.url = `${baseUrl}Statistics/getDataGraficaTopUsuarios/${anio}/${mes}`;

            return request;
        }

        function convertData(data) {
            data.forEach(row => {
                row.mes = this.convertNumberToMonth(row.mes);
            });
        }

        function convertNumberToMonth(mes) {
            switch (mes) {
                case 0: return '';
                case 1: return 'Enero';
                case 2: return 'Febrero';
                case 3: return 'Marzo';
                case 4: return 'Abril';
                case 5: return 'Mayo';
                case 6: return 'Junio';
                case 7: return 'Julio';
                case 8: return 'Agosto';
                case 9: return 'Septiembre';
                case 10: return 'Octubre';
                case 11: return 'Noviembre';
                case 12: return 'Diciembre';
                default: return null;
            }
        }

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        function formatMoney(n) {
            var c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t);
        }
    </script>
</body>