<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper ">
        <?php
            if (in_array($this->session->userdata('id_rol'), array(18, 63)))
                $this->load->view('template/sidebar', '');
            else
                echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
        ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Reporte de lotes por comisionista</h3>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-12 col-sm-3 col-md-3 col-lg-3">
                                                <label class="control-label label-gral"><span class="isRequired">*</span>Comisionista</label>
                                                <select id="comisionista" name="comisionista" class="form-control input-gral pl-0" required>
											        <option value="0" disabled selected>Seleccione una opción</option>
                                                </select>
                                        </div>
                                        <div class="col-12 col-sm-3 col-md-3 col-lg-3">
                                                <label class="control-label label-gral"><span class="isRequired">*</span>Tipo de usuario</label>
                                                <select id="tipoUsuario" name="tipoUsuario" class="form-control input-gral pl-0" required>
											        <option value="0" disabled selected>Seleccione una opción</option>
                                                </select>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-md-12 p-r">
                                                        <div class="form-group d-flex">
                                                            <input type="text" class="form-control datepicker" id="beginDate"/>
                                                            <input type="text" class="form-control datepicker" id="endDate"/>
                                                            <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                                                                <span class="material-icons update-dataTable">search</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="material-datatables" id="box-reporteLotesPorComisionista">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover"
                                                id="reporteLotesPorComisionista" name="reporteLotesPorComisionista">
                                                <thead>
                                                    <tr>
                                                        <th>PROYECTO</th>
                                                        <th>CONDOMINIO</th>
                                                        <th>LOTE</th>
                                                        <th>ID LOTE</th>
                                                        <th>CLIENTE</th>
                                                        <th>FECHA APARTADO</th>
                                                        <th>SEDE</th>
                                                        <th>ESTATUS CONTRATACIÓN</th>
                                                        <th>ESTATUS VENTA</th>
                                                        <th>ESTATUS COMISIÓN</th>
                                                        <th>PRECIO FINAL</th>
                                                        <th>PORCENTAJE COMISIÓN</th>
                                                        <th>TOTAL COMISIÓN</th>
                                                        <th>TOTAL ABONADO</th>
                                                        <th>TOTAL PAGADO</th>
                                                        <th>LUGAR PROSPECCIÓN</th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div><!--main-panel close-->

    <?php $this->load->view('template/footer');?>
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <!--  Plugin for Date Time Picker and Full Calendar Plugin-->
    <script src="<?= base_url() ?>dist/js/moment.min.js"></script>
    <script src="<?= base_url() ?>dist/js/es.js"></script>
    <!-- DateTimePicker Plugin -->
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
    <!-- Sliders Plugin -->
    <script src="<?= base_url() ?>dist/js/nouislider.min.js"></script>
    <!--  Full Calendar Plugin    -->
    <script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/reporteLotesPorComisionista.js"></script>
</body>