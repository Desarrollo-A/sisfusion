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
                            <li class="active menuTab" id="prospectosTab"><a href="#generalProspectos" role="tab" data-toggle="tab">LISTADO PROSPECTOS</a></li>
                            <li class="menuTab" id="clientesTab"><a href="#generalClientes" role="tab" data-toggle="tab">LISTADO CLIENTES</a></li>
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
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                                <div class="form-group label-floating div_name">
                                                                    <label class="control-label">NOMBRE</label>
                                                                    <input id="name" name="name" type="text" class="form-control input-gral" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                                <div class="form-group label-floating div_last_name">
                                                                    <label class="control-label">CORREO</label>
                                                                    <input id="mail" name="mail" type="text" class="form-control input-gral" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                                <div class="form-group label-floating div_last_name">
                                                                    <label class="control-label">TELÉFONO</label>
                                                                    <input id="telephone" name="telephone" type="text" class="form-control input-gral" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                                <div class="form-group label-floating div_last_name">
                                                                    <!--<label class="control-label">TELÉFONO</label>-->
                                                                    <select class="selectpicker select-gral m-0" id="sede" name="sede[]" data-style="btn btn-primary " data-show-subtext="true" data-live-search="true" title="Selecciona sede" data-size="7" required="" multiple="" tabindex="-98">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class=" col col-xs-12 col-sm-12 col-md-4 col-lg-4 center-align centered">
                                                                <div class="form-group label-floating div_last_name">
                                                                    <button type="button" class="btn btn-primary" id="searchButton">BUSCAR</button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="material-datatables">
                                                        <table class="table-striped table-hover"
                                                               id="tabla_prospectos" name="tabla_prospectos">
                                                            <thead>
                                                            <tr>
                                                                <!--<th></th>-->
                                                                <th>NOMBRE</th>
                                                                <th>TELÉFONO</th>
                                                                <th>CORREO</th>
                                                                <th>LUGAR PROSPECCIÓN</th>
                                                                <th>ASESOR</th>
                                                                <th>COORDINADOR</th>
                                                                <th>GERENTE</th>
                                                                <th>FECHA CREACIÓN</th>
                                                                <th>ID DRAGON</th>
                                                                <th>SEDE</th>
                                                            </tr>
                                                            </thead>
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
                                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group label-floating div_name">
                                                                <label class="control-label">ID LOTE</label>
                                                                <input id="idLotteC" name="idLotteC" type="text" class="form-control input-gral" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group label-floating div_name">
                                                                <label class="control-label">NOMBRE</label>
                                                                <input id="nameC" name="nameC" type="text" class="form-control input-gral" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group label-floating div_last_name">
                                                                <label class="control-label">CORREO</label>
                                                                <input id="mailC" name="mailC" type="text" class="form-control input-gral" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group label-floating div_last_name">
                                                                <label class="control-label">TELÉFONO</label>
                                                                <input id="telephoneC" name="telephoneC" type="text" class="form-control input-gral" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group label-floating div_last_name">
                                                                <!--<label class="control-label">TELÉFONO</label>-->
                                                                <select class="selectpicker select-gral m-0" id="sedeC" name="sedeC[]" data-style="btn btn-primary " data-show-subtext="true" data-live-search="true" title="Selecciona sede" data-size="7" required="" multiple="" tabindex="-98">
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class=" col col-xs-12 col-sm-12 col-md-4 col-lg-4 center-align centered">
                                                            <div class="form-group label-floating div_last_name">
                                                                <button type="button" class="btn btn-primary" id="searchButtonC">BUSCAR</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="material-datatables">
                                                        <div class="form-group">
                                                            <div class="table-responsive">
                                                                <table class="table-striped table-hover"
                                                                       id="tabla_clientes" name="tabla_clientes">
                                                                    <thead>
                                                                    <tr>
                                                                        <!--<th></th>-->
                                                                        <th>ID LOTE</th>
                                                                        <th>PROYECTO</th>
                                                                        <th>CONDOMINIO</th>
                                                                        <th>LOTE</th>
                                                                        <th>NOMBRE CLIENTE</th>
                                                                        <th>NO. RECIBO</th>
                                                                        <th>REFERENCIA</th>
                                                                        <th>FECHA APARTADO</th>
                                                                        <th>ENGANCHE</th>
                                                                        <th>FECHA ENGANCHE</th>
                                                                        <th>FECHA CREACIÓN PROSPECTO</th>
                                                                        <th>ESTATUS LOTE</th>
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
        var url = "<?=base_url()?>";
        var url2 = "<?=base_url()?>index.php/";
    </script>
    <!-- MODAL WIZARD -->
    <script src="<?=base_url()?>dist/js/controllers/marketing/marketing.js"></script>
</body>
