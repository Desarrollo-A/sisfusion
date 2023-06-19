<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php
            if($this->session->userdata('id_rol')=="28" ||$this->session->userdata('id_rol')=="18"||$this->session->userdata('id_rol')=="19"||$this->session->userdata('id_rol')=="63"){
                $this->load->view('template/sidebar');
            }else{
                echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
            }
        ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-chart-bar fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <div class="row">
                                        <h3 class="card-title center-align" >Reporte dinámico</h3>
                                        <p class="card-title pl-1">(Concentrado de lotes con apartado por fecha, gerencias y plazas)</p>
                                    </div>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Total vendido:</h4>
                                                    <p class="input-tot pl-1" id="myText_vendido">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 overflow-hidden">
                                                <div class="form-group">
                                                    <label class="m-0" for="proyecto">Mes</label>
                                                    <select name="mes" id="mes" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required>
                                                        <?php
                                                        setlocale(LC_ALL, 'es_ES');
                                                        for ($i=1; $i<=12; $i++) {
                                                            $monthNum  = $i;
                                                            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                                            $monthName = strftime('%B', $dateObj->getTimestamp());
                                                            echo '<option value="'.$i.'">'.$monthName.'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 overflow-hidden">
                                                <div class="form-group">
                                                    <label class="m-0">Año</label>
                                                    <select name="anio" id="anio" class="selectpicker select-gral" data-style="btn btn-second"data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required>
                                                        <option disabled selected>Selecciona una opción</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 overflow-hidden">
                                                <div class="form-group">
                                                    <label class="m-0">Plaza</label>
                                                    <select name="plaza" id="plaza" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required> 
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 overflow-hidden">
                                                <div class="form-group">
                                                    <label class="m-0">Gerente</label>
                                                    <select name="gerente" id="gerente" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required> 
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover hide" id="tableDinamicMKTD" name="tableDinamicMKTD">
                                            <thead>
                                                <tr>
                                                    <th>LOTES VENDIDOS</th>
                                                    <th>MONTO VENDIDO</th>
                                                    <th>ASESOR</th>
                                                    <th>GERENTE</th>
                                                    <th>FECHA DE APARTADO</th>
                                                    <th>PLAZA</th>
                                                    <th>ESTATUS</th>
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
        <?php $this->load->view('template/footer_legend');?>
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
    <script src="<?= base_url() ?>dist/js/controllers/ventas/cobranzaDinamic.js"></script>
</body>