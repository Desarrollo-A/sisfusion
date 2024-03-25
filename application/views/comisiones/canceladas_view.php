<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<div class="wrapper">
<?php $this->load->view('template/sidebar'); ?>

    <div class="modal fade modal-alertas" id="detalle-modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-wallet fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align" >Comisiones canceladas</h3>
                                <p class="card-title pl-1">Lotes donde la venta se canceló.</p>
                            </div>
                            <div class="material-datatables">
                                <table class="table-striped table-hover" id="canceladas-tabla">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>REFERENCIA</th>
                                            <th>PROYECTO</th>
                                            <th>LOTE</th>
                                            <th>CLIENTE</th>
                                            <th>PLAN VENTA</th>
                                            <th>TOTAL</th>
                                            <th>PRECIO FINAL LOTE</th>
                                            <th>% COMISION TOTAL</th>
                                            <th>IMPORTE COMISION PAGADA</th>
                                            <th>IMPORTE COMISION PENDIENTE</th>
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
<?php $this->load->view('template/footer'); ?>
<script src="<?= base_url() ?>dist/js/controllers/comisiones/canceladas.js"></script>

