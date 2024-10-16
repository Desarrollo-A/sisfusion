<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-cm">
                            <li class="active">
                                <a href="#procesoCasasBanco" role="tab" data-toggle="tab" onclick="dataFunction(1)">Proceso casas (banco)</a>
                            </li>
                            <li class="hidden">
                                <a href="#procesoCasasDirecto" role="tab" data-toggle="tab" onclick="dataFunction(2)">Proceso casas (directo)</a>
                            </li>
                            <li>
                                <a href="#procesoPagos" role="tab" data-toggle="tab" onclick="dataFunction(3)">Proceso pagos</a>
                            </li>
                        </ul>
                          <div class="card no-shadow m-0">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">

                                        <div class="tab-pane active" id="procesoCasasBanco">
                                            <div class="card-content">
                                                <div class="toolbar">
                                                    <h3 class="card-title center-align">Documentación por lote (banco)</h3>
                                                    <div id="table-filters" class="row mb-1"></div>
                                                </div>

                                               <table id="tableBanco" class="table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ID PROCESO</th>
                                                            <th>PROYECTO</th>
                                                            <th>CONDOMINIO</th>
                                                            <th>NOMBRE LOTE</th>
                                                            <th>ID LOTE</th>
                                                            <th>GERENTE</th>
                                                            <th>ASESOR</th>
                                                            <th>DOCUMENTO</th>
                                                            <th>ACCIONES</th>
                                                        </tr>
                                                    </thead>
                                                </table>

                                            </div>
                                        </div>

                                        <div class="tab-pane" id="procesoCasasDirecto">
                                            <div class="card-content">
                                                <div class="toolbar">
                                                    <h3 class="card-title center-align">Documentación por lote (directo)</h3>
                                                    <div id="table-filters-directo" class="row mb-1"></div>
                                                </div>
                                                <table id="tableDirecto" class="table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ID PROCESO</th>
                                                            <th>PROYECTO</th>
                                                            <th>CONDOMINIO</th>
                                                            <th>NOMBRE LOTE</th>
                                                            <th>ID LOTE</th>
                                                            <th>GERENTE</th>
                                                            <th>ASESOR</th>
                                                            <th>DOCUMENTO</th>
                                                            <th>ACCIONES</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="procesoPagos">
                                            <div class="card-content">
                                                <div class="toolbar">
                                                    <h3 class="card-title center-align">Documentación por lote (pagos)</h3>
                                                    <div id="table-filters-pagos" class="row mb-1"></div>
                                                </div>
                                                <table id="tablePagos" class="table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ID PROCESO</th>
                                                            <th>PROYECTO</th>
                                                            <th>CONDOMINIO</th>
                                                            <th>NOMBRE LOTE</th>
                                                            <th>ID LOTE</th>
                                                            <th>GERENTE</th>
                                                            <th>ASESOR</th>
                                                            <th>DOCUMENTO</th>
                                                            <th>ACCIONES</th>
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
    <?php $this->load->view('template/footer');?>
    <?php $this->load->view('template/modals');?>

    <script src="<?= base_url() ?>dist/js/controllers/casas/toda_documentacion.js?=v2"></script>
</body>