<link href="<?= base_url() ?>dist/css/rankingDashboard.css" rel="stylesheet"/>

<div class="container-fluid p-0">
    <div class="row" id="mainRow">
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 inactivo flexible">
            <div class="card">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart">
                            <button type="btn" class="primary" onclick="toggleDatatable(this)">...</button>
                            <h5>Ventas de apartados</h5>
                            <div id="chart"></div>
                        </div>
                        <div id="Apartados" class="col-12 col-sm-6 col-md-6 col-lg-6 col-datatable hidden">
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
                            <button type="btn" class="primary" onclick="toggleDatatable(this)">...</button>
                            <h5>Ventas con contrato</h5>
                            <div id="chart2"></div>
                        </div>
                        <div id="Contratados" class="col-12 col-sm-6 col-md-6 col-lg-6 col-datatable hidden">
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
                            <button type="btn" class="primary" onclick="toggleDatatable(this)">...</button>
                            <h5>Ventas con enganche</h5>
                            <div id="chart3"></div>
                        </div>
                        <div id="ConEnganche" class="col-12 col-sm-6 col-md-6 col-lg-6 col-datatable hidden">
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
                            <button type="btn" class="primary" onclick="toggleDatatable(this)">...</button>
                            <h5>Ventas sin enganche</h5>
                            <div id="chart4"></div>
                        </div>
                        <div id="sinEnganche" class="col-12 col-sm-6 col-md-6 col-lg-6 col-datatable hidden">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?=base_url()?>dist/js/controllers/dashboard/ranking/dashboardRanking.js"></script>