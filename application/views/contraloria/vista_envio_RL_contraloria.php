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
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 p-0">
                            <label>Ingresa los códigos de los contratos a enviar</label>
                            <textarea name="txt" id="contratos" onkeydown="saltoLinea(value); return true;" class="text-modal" style="text-transform:uppercase; min-height: 400px;width: 100%"></textarea><br><br>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Cancelar</button>
                        <button type="button" id="btn_show" class="btn btn-primary">Aceptar</button>
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
                                
                                <?php if ($this->session->userdata('id_rol') != "63"){?>
                                <div  class="toolbar">
                                    <div class="row">
                                        <div class="col col-xs-12 col-sm-3 col-md-3 col-lg-3 pb-5 d-flex justify-end">
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
                                                <th>TIPO DE PROCESO</th>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>CLIENTE</th>
                                                <th>CÓDIGO</th>
                                                <th>REPRESENTANTE LEGAL</th>
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
</body>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/controllers/contraloria/vista_envio_RL_contraloria.js"></script>

