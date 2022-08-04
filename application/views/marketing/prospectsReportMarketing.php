<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<style>
        table.dataTable > thead > tr > th, table.dataTable > tbody > tr > th, table.dataTable > tfoot > tr > th, table.dataTable > thead > tr > td, table.dataTable > tbody > tr > td, table.dataTable > tfoot > tr > td {
        white-space: nowrap!important;
    }
    </style>
<body>
    
    <div class="wrapper">
        <?php 
        $datos = array();
        $datos = $datos4;
        $datos = $datos2;
        $datos = $datos3;  
        $this->load->view('template/sidebar', $datos);
        ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-cm" role="tablist">
                            <li class="active"><a href="#generalProspectos" role="tab" data-toggle="tab">LISTADO PROSPECTOS</a></li>
                            <li><a href="#generalClientes" role="tab" data-toggle="tab">LISTADO CLIENTES</a></li>
                        </ul>
                        <div class="card no-shadow m-0">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <div class="tab-pane active" id="generalProspectos">
                                            <div class="text-center">
                                                <h3 class="card-title center-align">Listado general de prospectos</h3>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-md-8"></div>
                                                        <div class="col-md-4 p-r">
                                                            <div class="form-group d-flex">
                                                                <input type="text" class="form-control datepicker"
                                                                    id="beginDate"/>
                                                                <input type="text" class="form-control datepicker" id="endDate"/>
                                                                <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                                                                    <span class="material-icons update-dataTable">search</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="material-datatables">
                                                        <table id="masterCobranzaTable" class="table-striped table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>TIPO</th>
                                                                    <th>NOMBRE</th>
                                                                    <th>FECHA NACIMIENTO</th>
                                                                    <th>TELÉFONO</th>
                                                                    <th>CORREO</th>
                                                                    <th>LUGAR PROSPECCIÓN</th>
                                                                    <th>FECHA APARTADO</th>
                                                                    <th>ASESOR</th>
                                                                    <th>COORDINADOR</th>
                                                                    <th>GERENTE</th>
                                                                    <th>SUBDIRECTOR</th>
                                                                    <th>DIRECTOR REGIONAL</th>
                                                                    <th>RESIDENCIAL</th>
                                                                    <th>CONDOMINIO</th>
                                                                    <th>LOTE</th>
                                                                    <th>FECHA CREACION</th>
                                                                    <th>DÍAS CIERRE</th>
                                                                    <th>DIRECCIÓN</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="generalClientes">
                                            <div class="text-center">
                                                <h3 class="card-title center-align">Listado general de clientes</h3>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-md-8"></div>
                                                        <div class="col-md-4 p-r">
                                                            <div class="form-group d-flex">
                                                                <input type="text" class="form-control datepicker"
                                                                    id="beginDate"/>
                                                                <input type="text" class="form-control datepicker" id="endDate"/>
                                                                <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                                                                    <span class="material-icons update-dataTable">search</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="material-datatables">
                                                        <table id="masterCobranzaTable" class="table-striped table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>TIPO</th>
                                                                    <th>NOMBRE</th>
                                                                    <th>FECHA NACIMIENTO</th>
                                                                    <th>TELÉFONO</th>
                                                                    <th>CORREO</th>
                                                                    <th>LUGAR PROSPECCIÓN</th>
                                                                    <th>FECHA APARTADO</th>
                                                                    <th>ASESOR</th>
                                                                    <th>COORDINADOR</th>
                                                                    <th>GERENTE</th>
                                                                    <th>SUBDIRECTOR</th>
                                                                    <th>DIRECTOR REGIONAL</th>
                                                                    <th>RESIDENCIAL</th>
                                                                    <th>CONDOMINIO</th>
                                                                    <th>LOTE</th>
                                                                    <th>FECHA CREACION</th>
                                                                    <th>DÍAS CIERRE</th>
                                                                    <th>DIRECCIÓN</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
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
            </div>
        </div>
        <?php $this->load->view('template/footer_legend');
       
        ?>
    </div>
    </div><!-- main-panel close -->

    <?php $this->load->view('template/footer');?>
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script src="<?= base_url() ?>dist/js/es.js"></script>
    <!-- DateTimePicker Plugin -->
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
    <!--  Full Calendar Plugin    -->
    <script>
        userType = <?= $this->session->userdata('id_rol') ?> ;
        idUser = <?= $this->session->userdata('id_usuario') ?> ;
        typeTransaction = 1;
    </script>
    <!-- MODAL WIZARD -->
    <script src="<?=base_url()?>dist/js/controllers/marketing/marketing.js"></script>
</body>
