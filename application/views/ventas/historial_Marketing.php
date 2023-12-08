<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="material-icons">reorder</i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Historial general</h3>
                                    <p class="card-title pl-1">(Listado de todos los pagos aplicados y en proceso de Marketing Digítal)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 overflow-hidden">
                                            <div class="form-group">
                                                <label for="catalogoHistorial">Proyecto</label>
                                                <select name="catalogoHistorial" id="catalogoHistorial" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-container="body" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" required> <option value="0">SELECCIONE TODO</option></select>
                                            </div>
                                        </div>
                                        <?php
                                            if($this->session->userdata('id_rol') == 13 || $this->session->userdata('id_rol') == 32 || $this->session->userdata('id_rol') == 17){
                                                ?>
                                                <input type="hidden" id="param" name="param" value="0"> 
                                                <?php 
                                            }else{
                                                ?>
                                                <input type="hidden" id="param" name="param" value="1">
                                                <?php
                                            }
                                        ?>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 overflow-hidden">
                                            <div class="form-group">
                                                <label>Condominio</label>
                                                <select class="selectpicker select-gral" id="condominioHistorial" name="condominioHistorial[]" data-style="btn " data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla_historialGral" name="tabla_historialGral"><thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>REFERENCIAS</th>
                                                    <th>PRECIO LOTE</th>
                                                    <th>TOTAL COMISION</th>
                                                    <th>PAGO CLIENTE</th>
                                                    <th>DISPERSADO</th>
                                                    <th>PAGADO</th>
                                                    <th>PENDIENTE</th>
                                                    <th>USUARIO</th>
                                                    <th>PLAZA MKTD</th>
                                                    <th>DETALLE</th>
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
            </div>
            <?php $this->load->view('template/footer_legend');?>
        </div>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?=base_url()?>dist/js/core/modal-general.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/historial_marketing.js"></script>
    <script src="<?= base_url() ?>dist/js/dataTables.select.js"></script>
    <script src="<?= base_url() ?>dist/js/dataTables.select.min.js"></script>
</body>