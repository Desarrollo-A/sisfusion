<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon fa-2x" data-background-color="goldMaderas">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Inventario lotes y comisionistas</h3>
                                <div class="toolbar">
                                    <div class="container-fluid"> 
                                        <div class="row">
                                            <div class="col-md-4 form-group pl-0 ">
                                                <div class="form-group overflow-hidden">
                                                    <label class="m-0 control-label" for="residenciales">Proyecto</label>
                                                    <select id="residenciales" name="residenciales"
                                                        class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" size="5" data-container="body" required>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group ">
                                                <div class="form-group overflow-hidden ">
                                                    <label class="m-0 control-label" for="idCondominioInventario">Condominio</label>
                                                    <select name="condominios" id="condominios"
                                                        class="selectpicker select-gral" data-style="btn"
                                                        data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group pr-0">
                                                <div class="form-group  overflow-hidden">
                                                    <label class="m-0 control-label" for="idEstatus">Estatus</label>
                                                    <select name="idEstatus" id="idEstatus" class="selectpicker select-gral" data-style="btn"  data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables hide" id="TableHide">
                                    <div class="container-fluid">
                                        <table class="table-striped table-hover" id="tablaInventarioComisionistas"name="tablaInventarioComisionistas">
                                            <thead>
                                                <tr>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>REFERENCIA</th>
                                                    <th>ASESOR 1</th>
                                                    <th>COORDINADOR 1</th>
                                                    <th>GERENTE 1</th>
                                                    <th>ASESOR 2</th>
                                                    <th>COORDINADOR 2</th>
                                                    <th>GERENTE 2</th>
                                                    <th>ASESOR 3</th>
                                                    <th>COORDINADOR 3</th>
                                                    <th>GERENTE 3</th>
                                                    <th>ESTATUS</th>
                                                    <th>APARTADO</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/controllers/contraloria/inventarioComisionistas.js"></script>
</body>