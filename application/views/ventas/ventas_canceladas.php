<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<div class="wrapper">
<?php $this->load->view('template/sidebar'); ?>

    <div class="modal fade modal-alertas"
         id="detalle-modal"
         role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">Cerrar</button>
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
                                <div class="table-responsive">
                                    <table class="table-striped table-hover"
                                           id="canceladas-tabla">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>REFERENCIA</th>
                                                <th>PROYECTO</th>
                                                <th>LOTE</th>
                                                <th>CLIENTE</th>
                                                <th>PLAN VENTA</th>
                                                <th>TOTAL</th>
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

<?php $this->load->view('template/footer'); ?>

<!--DATATABLE BUTTONS DATA EXPORT-->
<script>
    const url = "<?=base_url()?>";
</script>

<script src="<?= base_url() ?>dist/js/controllers/comisiones/ventas_canceladas.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

