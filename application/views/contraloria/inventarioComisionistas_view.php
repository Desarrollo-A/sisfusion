<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
    <div class="wrapper">
        <?php
			if (in_array($this->session->userdata('id_rol'), array(17, 70, 71, 73)))
            	$this->load->view('template/sidebar');
			else
				echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
		?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon fa-2x" data-background-color="goldMaderas">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="card-content" >
                                <h3 class="card-title center-align">Inventario lotes y comisionistas</h3>
                                <div class="toolbar">
                                    <div class="container"> 
                                        <div class="row">
                                            <div class="col-md-4 form-group pl-0 overflow-hidden">
                                                <div class="form-group">
                                                    <label class="m-0" for="residenciales">Proyecto</label>
                                                    <select id="residenciales" name="residenciales"
                                                        class="selectpicker select-gral" data-style="btn"
                                                        data-show-subtext="true" data-live-search="true"
                                                        title="Selecciona una opción" data-size="7" size="5" data-container="body" required>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 form-group overflow-hidden ">
                                                <div class="form-group">
                                                    <label class="m-0" for="idCondominioInventario">Condominio</label>
                                                    <select name="condominios" id="condominios"
                                                        class="selectpicker select-gral" data-style="btn"
                                                        data-show-subtext="true" data-live-search="true"
                                                        title="Selecciona una opción" data-size="7" data-container="body" required>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 form-group pr-0 overflow-hidden">
                                                <div class="form-group">
                                                    <label class="m-0" for="idEstatus">Estatus</label>
                                                    <select name="idEstatus" id="idEstatus" class="selectpicker select-gral"
                                                        data-style="btn"  data-show-subtext="true" data-live-search="true"
                                                        title="Selecciona una opción" data-size="7" data-container="body" required>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables hide" id="TableHide">
                                    <div class="container">
                                        <table class="table-striped table-hover" id="tablaInventarioComisionistas"
                                            name="tablaInventarioComisionistas">
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
    </div>
    <!--main-panel close-->
    <?php $this->load->view('template/footer');?>
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/contraloria/inventarioComisionistas.js"></script>
</body>