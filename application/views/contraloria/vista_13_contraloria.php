<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>
        
        <!-- modal  rechazar A CONTRALORIA 7-->
        <div class="modal fade" id="editReg" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center"><label>Registro estatus 13 - <b><span class="lote"></span></b></label></h4>
                    </div>
                    <div class="modal-body">
                        <label class="control-label">Comentario</label>
                        <textarea class="text-modal" id="comentario" rows="3"></textarea>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save1" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->

        <!-- modal para mostrar avisos que se cargan por medio del evento donde clickee el ussuaior -->
        <div class="modal fade" id="showMessageStats" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <b class="text-center">¡IMPORTANTE!</b>
                        </h4>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">
                            Aceptar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!--Contenido de la página-->
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-expand fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Registro estatus 13</h3>
                                    <p class="card-title pl-1">(Contrato listo y entregado asesores)</p>
                                </div>
                                <div class="material-datatables">
                                    <table id="tabla_ingresar_13" name="tabla_ingresar_13" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>TIPO DE VENTA</th>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>CLIENTE</th>
                                                <th>GERENTE</th>
                                                <th>RL</th>
                                                <th>UBICACIÓN</th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
</body>
<?php $this->load->view('template/footer'); ?>
<script src="<?= base_url() ?>dist/js/controllers/contraloria/vista_13_contraloria.js"></script>