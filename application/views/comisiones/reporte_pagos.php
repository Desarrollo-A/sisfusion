<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
<div class="wrapper">
    <?php
    if($this->session->userdata('id_rol')=="49" )
    {
        $this->load->view('template/sidebar');
    }else{
        echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
    }
    ?>
    <!--MODALS-->
    <div class="modal fade" id="seeInformationModalAsimilados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons" data-dismiss="modal" onclick="cleanCommentsAsimilados()">clear</i>
                    </button>
                </div>
                <div class="modal-body">
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist" style="background: #949494;">
                            <div id="nameLote"></div>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="changelogTab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content">
                                                <ul class="timeline timeline-simple" id="comments-list-asimilados"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsAsimilados()"><b>Cerrar</b></button>
                </div>
            </div>
        </div>
    </div>
    <!--END MODALS-->

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
                                <h3 class="card-title center-align">Reporte pagos</h3>
                            </div>
                            <div class="toolbar">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="proyecto"  class="control-label">PUESTO (<span class="isRequired">*</span>)</label>
                                            <select name="filtro33" id="filtro33" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" required>
                                                <option value="3">GERENTE</option>
                                                <option value="9">COORDINADOR</option> 
                                                <option value="7">ASESOR</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label">NOMBRE (<span class="isRequired">*</span>)</label>
                                            <select class="selectpicker select-gral" id="filtro44" name="filtro44[]" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required>
                                            </select>
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
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>REFEFERENCIA</th>
                                                <th>PRECIO DEL LOTE</th>
                                                <th>TOTAL DE LA COMPRA</th>
                                                <th>PAGO POR EL CLIENTE</th>
                                                <th>DISPERSADO</th>
                                                <th>PAGADO</th>
                                                <th>PENDIENTE</th>
                                                <th>USUARIO</th>
                                                <th>PUESTO</th>
                                                <th>DETALLE</th>
                                                <th>ESTATUS</th>
                                                <th>MÁS</th>
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
</div><!--main-panel close-->

<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/controllers/comisiones/reportePagos.js"></script>

</body>