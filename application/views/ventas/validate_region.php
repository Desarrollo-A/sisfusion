<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php
        switch ($this->session->userdata('id_rol')) {
            case '13': // CONTRALORÍA
            case '19': // SUBDIRECTOR CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
                $this->load->view('template/sidebar');
                break;
            default: // NO ACCESS
                echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
                break;
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
                                    <h3 class="card-title center-align">Validar región de comisiones</h3>
                                </div>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-2 col-lg-2 pr-0">    
                                            <button type="button" value="6" class="btn-data-gral" style="background-color:#4BBC8E; color:#FFF;" onclick="assignManager(this.value)">Cancún</button>
                                        </div>
                                        <div class="col-sm-12 col-md-2 col-lg-2 pr-0">
                                            <button type="button" value="4" class="btn-data-gral" style="background-color:#1FA592; color:#FFF;" onclick="assignManager(this.value)">Ciudad de México</button>
                                        </div>
                                        <div class="col-sm-12 col-md-2 col-lg-2 pr-0">
                                            <button type="button" value="2" class="btn-data-gral" style="background-color:#008E8E; color:#FFF;" onclick="assignManager(this.value)">Querétaro</button> 
                                        </div>
                                        <div class="col-sm-12 col-md-2 col-lg-2 pr-0">
                                            <button type="button" value="3" class="btn-data-gral" style="background-color:#137683; color:#FFF;" onclick="assignManager(this.value)">Península</button>
                                        </div>
                                        <div class="col-sm-12 col-md-2 col-lg-2">
                                            <button type="button" value="5" class="btn-data-gral" style="background-color:#275E70; color:#FFF;" onclick="assignManager(this.value)">León</button>
                                        </div>
                                        <div class="col-sm-12 col-md-2 col-lg-2 pr-0">
                                            <button type="button" value="1" class="btn-data-gral" style="background-color:#2F4858; color:#FFF;" onclick="assignManager(this.value)">San Luis Potosí</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla_validar_comisiones" name="tabla_validar_comisiones">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID PAGO</th>
                                                    <th>ABONO</th>
                                                    <th>ID LOTE</th>
                                                    <th>PROYECTO</th>
                                                    <th>LOTE</th>
                                                    <th>SEDE</th>
                                                    <th>APARTADO</th>
                                                    <th>SEDE COMISIÓN</th>
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
        </div>
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div>
    <!--main-panel close-->
    <?php $this->load->view('template/footer'); ?>
    <script src="<?=base_url()?>dist/js/controllers/ventas/validateRegion.js"></script>

</body>