<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php
        if ($this->session->userdata('id_rol') == "31") //intmex
        {
            $this->load->view('template/sidebar');
        } else {
            echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
        }
        ?>
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Reporte de saldos</h3>
                                    <p class="card-title pl-1">(Total de saldos sin impuestos)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                    <p class="input-tot pl-1" id="myText_nuevas">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 overflow-hidden">
                                                <div class="form-group">
                                                    <label class="control-label" for="empresa">Empresa</label>
                                                    <select name="empresa" id="empresa" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 overflow-hidden">
                                                <div class="form-group">
                                                    <label class="control-label" for="regimen">Regimen</label>
                                                    <select name="regimen" id="regimen" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla_historialGral" name="tabla_historialGral">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>PROYECTO</th>
                                                    <th>EMPRESA</th>
                                                    <th>TOTAL DISPONIBLE</th>
                                                    <th>RÉGIMEN</th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    <?php $this->load->view('template/footer'); ?>
    <script src="<?= base_url() ?>dist/js/controllers/ventas/saldo_Intmex.js"></script>
</body>