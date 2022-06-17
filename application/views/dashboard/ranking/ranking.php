<link href="<?= base_url() ?>dist/css/rankingDashboard.css" rel="stylesheet"/>

<div class="container-fluid p-0">
    <div class="row" id="mainRow">
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 inactivo flexible">
            <div class="card">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart">
                            <button type="btn" class="primary" onclick="toggleDatatable(this)">1..</button>
                            <h5>Ventas de apartados</h5>
                            <div id="chart"></div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-datatable hidden">
                            <table id="tableApartados" class="table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NOMBRE</th>
                                        <th>APELLIDO PATERNO</th>
                                        <th>APELLIDO MATERNO</th>
                                        <th>TELEFONO</th>
                                        <th>CORREO</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 inactivo flexible">
            <div class="card">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart">
                            <button type="btn" class="primary" onclick="toggleDatatable(this)">2..</button>
                            <h5>Ventas con contrato</h5>
                            <div id="chart2"></div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-datatable hidden">
                            <table class="table-striped table-hover" id="tableContratados" name="table">
                                <thead>
                                    <tr>
                                        <th class="detail">ID</th>
                                        <th class="encabezado">NOMBRE</th>
                                        <th>APELLIDO PATERNO</th>
                                        <th>APELLIDO MATERNO</th>
                                        <th>TELEFONO</th>
                                        <th>FECHA NACIMIENTO</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 inactivo flexible">
            <div class="card">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart">
                            <button type="btn" class="primary" onclick="toggleDatatable(this)">3..</button>
                            <h5>Ventas con enganche</h5>
                            <div id="chart3"></div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-datatable hidden">
                            <div class="container-fluid">
                                <table class="table-striped table-hover" id="tableConEnganche" name="table">
                                    <thead>
                                        <tr>
                                            <th class="detail">ID</th>
                                            <th class="encabezado">NOMBRE</th>
                                            <th>APELLIDO PATERNO</th>
                                            <th>APELLIDO MATERNO</th>
                                            <th>TELEFONO</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 inactivo flexible">
            <div class="card">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart">
                            <button type="btn" class="primary" onclick="toggleDatatable(this)">4..</button>
                            <h5>Ventas sin enganche</h5>
                            <div id="chart4"></div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-datatable hidden">
                            <div class="container-fluid">
                                <table class="table-striped table-hover" id="tableSinEnganche" name="table">
                                    <thead>
                                        <tr>
                                            <th class="detail">ID</th>
                                            <th class="encabezado">NOMBRE</th>
                                            <th>APELLIDO PATERNO</th>
                                            <th>APELLIDO MATERNO</th>
                                            <th>TELEFONO</th>
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
<script src="<?=base_url()?>dist/js/controllers/dashboard/ranking/dashboardRanking.js"></script>