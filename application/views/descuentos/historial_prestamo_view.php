<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
    <!-- modal comentarios -->
    
    <div class="modal fade"
                id="historial-modal"
                tabindex="-1"
                role="dialog"
                aria-labelledby="\"
                aria-hidden="true"
                data-backdrop="static"
                data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable"
                    role="document">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="modal-title">Historial del pago</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="historial-prestamo-content"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <!-- fin de modalComentarios -->
        <div class="modal fade"
                id="historial-modal"
                tabindex="-1"
                role="dialog"
                aria-labelledby="myModalLabel"
                aria-hidden="true"
                data-backdrop="static"
                data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable"
                    role="document">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="modal-title">Historial del pago</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="historial-prestamo-content"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon"
                                 data-background-color="goldMaderas">
                                <i class="fas fa-book fa-2x"></i>
                            </div>

                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Historial de préstamos</h3>
                                    <p class="card-title pl-1">
                                        (Historial de todos los préstamos)
                                    </p>
                                </div>

                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Total pagos:</h4>
                                                    <p class="input-tot pl-1" id="total-pago">$0.00</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="m-0"
                                                           for="roles">Puesto</label>
                                                    <select class="selectpicker select-gral"
                                                            name="roles"
                                                            id="roles"
                                                            required>
                                                        <option value=""
                                                                disabled
                                                                selected>
                                                            Selecciona un rol
                                                        </option>
                                                        <option value="7">Asesor</option>
                                                        <option value="9">Coordinador</option>
                                                        <option value="3">Gerente</option>
                                                        <option value="2">Sub director</option>
                                                    </select>
                                                </div>
                                            </div> -->

                                            <!-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="m-0"
                                                           for="users">Usuario</label>
                                                    <select class="selectpicker select-gral"
                                                            id="users"
                                                            name="users"
                                                            data-style="btn"
                                                            data-show-subtext="true"
                                                            data-live-search="true"
                                                            title="SELECCIONA UN USUARIO"
                                                            data-size="7"
                                                            required>
                                                    </select>
                                                </div>
                                            </div> -->
                                              Z
                                        </div>
                                    </div>
                                </div>
                                <!-- END TOOLBAR -->

                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover"
                                                    id="prestamos-table">
                                                <thead>
                                                    <tr>
                                                        <th>ID PRÉSTAMO</th>
                                                        <th>USUARIO</th>
                                                        <th>PUESTO</th>
                                                        <th>SEDE</th>
                                                        <th>TIPO DESCUENTO</th>
                                                        <th>ID PAGO</th>
                                                        <th>MONTO TOTAL</th>
                                                        <th>PAGADO</th>
                                                        <th>PENDIENTE</th>
                                                        <th>PAGO INDIVUAL</th>
                                                        <th>FECHA</th>
                                                        <th>COMENTARIOS</th>
                                                        <th>COMENTARIOS</th>
                                                        <!-- <th>ESTATUS</th> -->
                                                       
                                                        <th>OPCIONES</th>
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
        <div class="spiner-loader hide" id="spiner-loader">
            <div class="backgroundLS">
                <div class="contentLS">
                    <div class="center-align">
                        Este proceso puede demorar algunos segundos
                    </div>
                    <div class="inner">
                        <div class="load-container load1">
                            <div class="loader">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend');?>
    </div>

    <?php $this->load->view('template/footer'); ?>

    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/descuentos/historial_prestamo.js"></script>                                                               
</body>