<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>
        <!---MODALS--->
            <!-- modal  INSERT FILE-->
            <div class="modal fade" id="addFile" >
                <div class="modal-dialog">
                    <div class="modal-content" >
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title" id="myModalLabel"><span class="lote"></span></h3>
                        </div>
                        <div class="modal-body">
                            <div class="file-gph">
                                <input class="d-none" type="file" id="expediente">
                                <input class="file-name" id="txtexp" type="text" placeholder="No has seleccionada nada aún" readonly="">
                                <label class="upload-btn m-0" for="expediente"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>
                            </div>
                            <!-- <div class="input-group">
                                <label class="input-group-btn">
                                    <span class="btn btn-primary btn-file">Seleccionar archivo
                                        <input type="file" name="expediente" id="expediente" style="display: none;">
                                    </span>
                                </label>
                                <input type="text" class="form-control" id= "txtexp" readonly>
                            </div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                            <button type="button" id="sendFile" class="btn btn-primary">Guardar documento </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal INSERT-->

            <!--modal que pregunta cuando se esta borrando un archivo-->
            <div class="modal fade " id="cuestionDelete"  >
                <div class="modal-dialog">
                    <div class="modal-content" >
                        <div class="modal-header">
                            <h4 class="modal-title text-center">¡Eliminar archivo!</h4>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                        <h5 class="modal-title">¿Está seguro de querer eliminar definivamente este archivo (<b><span class="tipoA"></span></b>)? </h5>
                                        <br>
                                        <h6 class="modal-title"><i> Esta acción no se puede deshacer.</i> </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Cancelar </button>
                            <button type="button" id="aceptoDelete" class="btn btn-primary"> Sí, borrar </button>
                        </div>
                    </div>
                </div>
            </div>
            <!--termina el modal de cuestion-->

            <!-- autorizaciones-->
            <div class="modal fade " id="verAutorizacionesAsesor"   >
                <div class="modal-dialog">
                    <div class="modal-content" >
                        <div class="modal-header">
                            <h3 class="modal-title  text-center">Autorizaciones <span class="material-icons">vpn_key</span></h3>
                        </div>
                        <div class="modal-body pt-0 pb-0">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div id="auts-loads">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- autorizaciones end-->
        <!-- END MODALS-->

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
                                    <h3 class="card-title center-align">Documentación (Contraloría)</h3>
                                    <p class="card-title pl-1"></p>
                                </div>
                                <div  class="toolbar">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <div class="form-group select-is-empty">
                                                <label class="control-label">Proyecto</label>
                                                <select name="filtro3" id="filtro3" class="selectpicker select-gral m-0" data-container="body" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-live-search="true" data-size="7" required>
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
                                            <div class="form-group select-is-empty">
                                                <label class="control-label">Condominio</label>
                                                <select id="filtro4" name="filtro4"  class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-container="body" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="form-group select-is-empty">
                                                <label class="control-label">Lote</label>
                                                <select id="filtro5" name="filtro5" class="selectpicker select-gral m-0" data-container="body" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <table  id="tableDoct" class="table-striped table-hover hide">
                                        <thead>
                                            <tr>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>CLIENTE</th>
                                                <th>NOMBRE DE DOCUMENTO</th>
                                                <th>HORA/FECHA</th>
                                                <th>DOCUMENTO</th>
                                                <th>RESPONSABLE</th>
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
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
<script src="<?=base_url()?>dist/js/controllers/contraloria/expedienteContraloria.js"></script>