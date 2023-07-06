<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">

<body>
    <div class="wrapper">
    <?php  $this->load->view('template/sidebar'); ?>
     
    <!-- Modelo para eliminar -->
    <div class="modal fade modal-alertas" id="modal-delete" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content" >
            <div class="modal-body"></div>
            <div class="modal-footer"></div>
        </div>
      </div>
    </div>

    <div class="modal fade modal-alertas" id="modal-usuario" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-red">
                    <h4 class="card-title">Agregar notaría</h4>
                </div>
                <form method="post" id="form_notario">
                    <div class="modal-body pt-0">
                        <div class="form-group">
                            <label class="control-label">Nombre de notaría</label>    
                            <input class="form-control input-gral" id="notaria_nombre" type="text" name="notaria_nombre" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Nombre de notario</label>
                            <input class="form-control input-gral" id="notario_nombre" type="text" name="notario_nombre" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Direccion</label>
                            <input class="form-control input-gral" id="direccion" type="text" name="direccion" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Correo</label>
                            <input class="form-control input-gral" id="correo" type="email" name="correo" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Telefono</label>
                            <input class="form-control input-gral" id="telefono" type="text" name="telefono" maxlength="10" required>
                        </div>
                        <div class="form-group overflow-hidden">
                            <label class="control-label">Sede</label>
                            <select name="sede" id="sede" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-container="body" required></select>
                        </div>
                        <div class="form-group d-flex justify-center">
                                <button class="btn btn-danger" id="cancelar-registro" type="button" data-dismiss="modal" onclick="closeModalRegisto()">CANCELAR</button>
                                <button type="submit" class="btn btn-primary">GUARDAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-feather-alt fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Apartado Notarias</h3>
                                <div class="toolbar">
                                    <div class="row"> 
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-usuario" data-whatever="">Agregar Notaría</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="notaria-datatable"
                                            name="notaria-datatable">
                                            <thead>
                                                <tr>
                                                    <th>ID NOTARIA</th>
                                                    <th>NOMBRE NOTARIA</th>
                                                    <th>NOMBRE NOTARIO</th>
                                                    <th>DIRECCION</th>
                                                    <th>CORREO</th>
                                                    <th>TELEFONO</th>
                                                    <th>SEDE</th>
                                                    <th>ACCIONES</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                              <?php include 'common_modals.php' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend');?>
    </div>
    <!--main-panel close-->
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
<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
<!-- MODAL WIZARD -->
<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?= base_url() ?>dist/js/moment.min.js"></script>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<script src="<?=base_url()?>static/yadcf/jquery.dataTables.yadcf.js"></script>
<script src="<?=base_url()?>dist/js/controllers/general/main_services.js"></script>
<script src="<?=base_url()?>dist/js/controllers/postventa/notaria.js"></script>
</html>