<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>
        <div class="modal fade" id="enviarContratos" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md">
                <div class="modal-content" >
                    <div class="modal-body">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <label class="control-label">Ingresa los códigos de los contratos firmados: </label>
                            <textarea name="txt" id="contratos" onkeydown="saltoLinea(value); return true;" class="text-modal"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="btn_show" class="btn btn-primary">Enviar Contratos</button>
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
                                    <h3 class="card-title center-align">Contrato firmado </h3>
                                    <p class="card-title pl-1">(estatus 12)</p>
                                </div>
                                <div  class="toolbar">
                                    <div class="row d-flex justify-end">
                                        <?php 
                                        if ($this->session->userdata('id_rol') != "63"){?>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 pb-5">
                                            <button class="btn-gral-data sendCont">Enviar contratos<i class="fas fa-paper-plane pl-1"></i></button>
                                        </div>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <table id="tabla_ingresar_12" name="tabla_ingresar_12" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>TIPO DE VENTA</th>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>CÓDIGO</th>
                                                <th>CLIENTE</th>
                                                <th>TOTAL NETO</th>
                                                <th>TOTAL VALIDADO</th>
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
</body>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/controllers/contraloria/vista_12_contraloria.js"></script>
