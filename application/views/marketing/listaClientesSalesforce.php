<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">

<body>
    <div class="wrapper">

    <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-list fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="toolbar">
                                    <h3 class="card-title center-align">Listado general de clientes Salesforce</h3>
                                </div>
                                <input class="hide" id="generatedToken"/>
                                <table id="tablaListaClientesSalesforce" name="tablaListaClientesSalesforce" class="table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID LOTE</th> 
                                            <th>PROYECTO</th>
                                            <th>CONDOMINIO</th>
                                            <th>LOTE</th>
                                            <th>NOMBRE DEL CLIENTE</th>
                                            <th>NÚMERO DEL RECIBO</th>
                                            <th>REFERENCIA</th>
                                            <th>FECHA DE APARTADO</th>
                                            <th>ENGANCHE</th>
                                            <th>FECHA DE ENGANCHE</th>
                                            <th>FECHA DE CREACIÓN DEL PROSPECTO</th>
                                            <th>ID CRM</th>
                                            <th>ID SALESFORCE</th>
                                            <th>ESTATUS DEL LOTE</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend'); ?>
    </div>

    <?php $this->load->view('template/footer'); ?>
    <script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/marketing/listaClientesSalesforce.js"></script>
</body>