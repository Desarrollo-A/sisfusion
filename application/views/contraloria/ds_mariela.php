<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade" id="modal1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title"><label>Integración de Expediente - <b><span class="lote"></span></b></label></h4>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label class="control-label">Comentario:</label>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <textarea class="text-modal" id="comentario" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save1" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal  ENVIA A CONTRALORIA 5 por rechazo 1-->
        <div class="modal fade" id="modal2" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 5 Contraloría) - <b><span class="lote"></span></b></label></h4>
                    </div>
                    <div class="modal-body pt-0">
                        <label class="control-label">Comentario:</label>
                        <textarea class="text-modal" id="comentario2" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Cancelar</button>
                        <button type="button" id="save2" class="btn btn-primary"> Registrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal  ENVIA A CONTRALORIA 5 por rechazo 1-->
        <div class="modal fade" id="modal3" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 5 Contraloría) - <b><span class="lote"></span></b></label></h4>
                    </div>
                    <div class="modal-body pt-0">
                        <label class="control-label">Comentario:</label>
                        <textarea class="text-modal" id="comentario3" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Cancelar</button>
                        <button type="button" id="save3" class="btn btn-primary"> Registrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal  ENVIA A CONTRALORIA 6 por rechazo 1-->
        <div class="modal fade" id="modal4" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 6 Contraloría) - <b><span class="lote"></span></b></label></h4>
                    </div>
                    <div class="modal-body pt-0">
                        <label class="control-label">Comentario:</label>
                        <textarea class="text-modal" id="comentario4" rows="3"></textarea>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Cancelar</button>
                        <button type="button" id="save4" class="btn btn-primary"> Registrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal  ENVIA A VENTAS 8 por rechazo 1-->
        <div class="modal fade" id="modal5" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 8 Ventas) - <b><span class="lote"></span></b></label></h4>
                    </div>
                    <div class="modal-body pt-0">
                        <label class="control-label">Comentario:</label>
                        <textarea class="text-modal" id="comentario5" rows="3"></textarea>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save5" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal  ENVIA A JURIDICO por rechazo 1-->
        <div class="modal fade" id="modal6" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 7 Jurídico) - <b><span class="lote"></span></b></label></h4>
                    </div>
                    <div class="modal-body pt-0">
                        <label class="control-label">Comentario:</label>
                        <textarea class="text-modal" id="comentario6" rows="3"></textarea>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save6" class="btn btn-primary"> Registrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal  ENVIA A JURIDICO por rechazo 1-->
        <div class="modal fade" id="modal7" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 5 Contraloría) - <b><span class="lote"></span></b></label></h4>
                    </div>
                    <div class="modal-body pt-0">
                        <label class="control-label">Comentario:</label>
                        <textarea class="text-modal" id="comentario7" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save7" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!--- END MODALS --->

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
                                    <h3 class="card-title center-align">Depósito de seriedad</h3>
                                    <p class="card-title pl-1"></p>
                                </div>
                                <div  class="toolbar">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <div class="form-group  select-is-empty">
                                                <label class="control-label">Proyecto (<span class="isRequired">*</span>)</label>
                                                <select name="filtro3" id="filtro3" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-live-search="true" data-size="7" data-container="body" required>
                                                    <?php
                                                    if($residencial != NULL) :
                                                        foreach($residencial as $fila) : ?>
                                                            <option value= <?=$fila['idResidencial']?> > <?=$fila['nombreResidencial']?> </option>
                                                        <?php endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="form-group  select-is-empty">
                                                <label class="control-label">Condominio (<span class="isRequired">*</span>)</label>
                                                <select id="filtro4" name="filtro4" class="selectpicker select-gral m-0"data-style="btn" data-show-subtext="true" data-live-search="true"title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="form-group  select-is-empty">
                                                <label class="control-label">Lote (<span class="isRequired">*</span>)</label>
                                                <select id="filtro5" name="filtro5" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7"  data-container="body" required>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <table  id="tabla_deposito_seriedad" name="tabla_deposito_seriedad" class="table-striped table-hover hide">
                                        <thead>
                                        <tr>
                                            <th>PROYECTO</th>
                                            <th>CONDOMINIO</th>
                                            <th>LOTE</th>
                                            <th>CLIENTE</th>
                                            <th>FECHA DE APARTADO</th>
                                            <th>FECHA DE VENCIMIENTO</th>
                                            <th>COMENTARIO</th>
                                            <th>EXPEDIENTE</th>
                                            <th>DS</th>
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
<script src="<?=base_url()?>dist/js/controllers/contraloria/dsMariela.js"></script>

<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
<script type="text/javascript">
    Shadowbox.init();
</script>


