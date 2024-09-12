<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<style>
    .bootstrap-select .dropdown-menu {
        max-height: 200px; 
        overflow-y: auto;  
        padding: 0;        
    }

    .bootstrap-select .dropdown-menu .inner {
        max-height: none;  
        overflow: hidden;  
    }
</style>

<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-file"></i>
                            </div>
                            <div class="card-content">
                                <div class="toolbar">
                                    <h3 class="card-title center-align">Lotes Disponibles</h3>
                                    <div id="table-filters" class="row mb-1"></div>
                                </div>
                                <table class="table-striped table-hover" id="tablaLotes">
                                    <thead>
                                        <tr>
                                            <th>ID</th>    
                                            <th>SUPERFICIE</th>
                                            <th>PROYECTO</th>
                                            <th>CONDOMINIO</th>
                                            <th>LOTE</th>
                                            <th>NOMBRE CLIENTE</th>
                                            <th>ESTATUS</th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    <?php $this->load->view('template/footer');?>
    <?php $this->load->view('template/modals');?>
    <script src="<?= base_url() ?>dist/js/controllers/postventa/asignar_escrituracion.js"></script>
</body>