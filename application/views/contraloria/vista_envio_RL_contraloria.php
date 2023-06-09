<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>
    
    <!-- modal para rechazar estatus-->
    <div class="modal fade" id="enviarContratos" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content" >
                <div class="modal-body">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label>Ingresa los códigos de los contratos a enviar </label>
                        <textarea name="txt" id="contratos" onkeydown="saltoLinea(value); return true;" class="text-modal" style="text-transform:uppercase; min-height: 400px;width: 100%"></textarea><br><br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                    <button type="button" id="btn_show" class="btn btn-primary"><span class="material-icons">send</span> </i> Enviar Contratos</button>
                    <br>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content boxContent ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-expand fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Envío contrato a RL </h3>
                                <p class="card-title pl-1">(estatus 10)</p>
                            </div>

                            <?php 
                            if ($this->session->userdata('id_rol') != "63"){?>
                            <div  class="toolbar">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 pb-5">
                                        <button class="btn-gral-data sendCont mb-1">Enviar contratos <i class="fas fa-paper-plane pl-1"></i></button>
                                    </div>
                                </div>
                            </div>
                            <?php }?>

                            <div class="material-datatables">
                                <table id="tabla_envio_RL" name="tabla_envio_RL" class="table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>TIPO DE VENTA</th>
                                            <th>PROYECTO</th>
                                            <th>CONDOMINIO</th>
                                            <th>LOTE</th>
                                            <th>CLIENTE</th>
                                            <th>CÓDIGO</th>
                                            <th>RL</th>
                                            <th>UBICACIÓN</th>
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

</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/contraloria/vista_envio_RL_contraloria.js"></script>

