<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<link href="<?= base_url() ?>dist/css/table_escrituracion.css" rel="stylesheet" />

<body>
    <div class="wrapper">
        <?php  $this->load->view('template/sidebar'); ?>
        <div class="modal fade" id="modal_nuevas"  nombre="modal_nuevas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header" id="header_modal" name="header_modal">
                        <h3 id="tituloModal" name="tituloModal"></h3>
                    </div>
                    <div class="modal-body" >
                        <div class="col-xs-12 col-sm-12 col-md-12 m-0"> 
                            <h6 class="text-gray textDescripcion" id="textDescripcion" name="textDescripcion"></h6>  
                            <h6 class="text-gray anteriorTitu m-0" >Anterior responsable de la tarea: </h6>  
                            <h6 class="text-gray anteriorTitu m-0" id="anteriorTitu" name="anteriorTitu"></h6>  
                        </div>
                        <div class="col-md-4" style="display:none;">
                            <div class="form-group">
                                <input class="form-control" type="text" name="id_actual" id="id_actual" readonly>
                            </div>
                        </div>
                        <div class="col-md-4" style="display:none;">
                            <div class="form-group">
                                <input class="form-control" type="text" name="solicitud" id="solicitud" readonly>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-12 mb-2">
                            <h6 class="text-gray m-0">Nuevo  responsable de la tarea: </h6>       
                            <select class="selectpicker titulares select-gral m-0" title="SELECCIONA UNA OPCIÓN" name="titulares" id="titulares" required>
                                <?php if(isset($titulaciones)){ foreach($titulaciones as $titulares){ ?>
                                    <option value="<?= $titulares['id_usuario'] ?>"><?= $titulares['nombre'] ?> </option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-lg-12 form-group p-0 d-flex justify-end m-0">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                            <button type="submit" id="updateTitu" name="updateTitu" class="btn btn-primary updateTitu">Aceptar</button>
                        </div>
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
                                <i class="fas fa-feather-alt fa-2x"></i>
                            </div>
                            <div class="card-content m-1">
                                <h3 class="card-title center-align">Solicitudes Escrituración</h3>
                                <div class="toolbar">
                                    <div class="row"> 
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="container-fluid p-0">
                                                <div class="row d-flex align-end">
                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-06">
                                                        <div class="form-group label-floating is-focused">
                                                            <label class="label-gral">Nombre de usuario titulación</label>
                                                            <input id="claveusu" name="claveusu" class="form-control input-gral" type="text" >
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-06">
                                                        <div class="form-group label-floating is-focused">
                                                            <button class="btn-gral-data aportaciones" name="aportaciones" id="aportaciones" ><i class="fas fa-spinner fa-spin" style="display: none"></i><span class="btn-text">Buscar usuario.</span></button>
                                                        </div>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="table-user"name="table-user">
                                            <thead>
                                                <tr>
                                                    <th>ID SOLICITUD</th>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>CLIENTE</th>
                                                    <th>FECHA DE CREACIÓN</th>
                                                    <th>TITULACIÓN</th>
                                                    <th>COMENTARIOS</th>
                                                    <th>ESTATUS</th>
                                                    <th>ÁREA</th>
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
</body>
<?php $this->load->view('template/footer');?>
<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
<script src="<?= base_url() ?>dist/js/moment.min.js"></script>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<script src="<?=base_url()?>static/yadcf/jquery.dataTables.yadcf.js"></script>
<script src="<?=base_url()?>dist/js/controllers/general/main_services.js"></script>
<script src="<?=base_url()?>dist/js/controllers/postventa/solicitud_usuario.js"></script>
</html>