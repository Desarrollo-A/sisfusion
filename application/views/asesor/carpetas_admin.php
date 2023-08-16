
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="<?=base_url()?>dist/js/controllers/files/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>dist/js/controllers/files/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>
<body>
    <div class="wrapper">

        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade" id="carpetasE" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content p-1" >
                    <div class="modal-header">
                        <h5 >Agregar nueva carpeta</h5>
                    </div>
                    <form  enctype="multipart/form-data" id="formAdminE">
                        <div class="form-group col-lg-12 m-0">
                            <label for="nombreE">Nombre</label>
                            <input type="text" name="nombreE" class="form-control input-gral" id="nombreE" >
                            <p id="nom" style="color: red;"></p>
                        </div>
                        <div class="form-group col-lg-12 m-0">
                            <label for="descripcionE">Descripción</label>
                            <textarea class="text-modal" rows="2" name="descripcionE" id="descripcionE" required=""></textarea>
                            <p id="des" style="color: red;"></p>
                        </div>
                        <input type="hidden" name="idCarpeta" id="idCarpeta">
                        <div class="form-group col-lg-12 m-0">
                            <div class="file-gph">
                                <input class="d-none" type="hidden" id="filename" name="filename">
                                <input class="file-name" id="file-uploadE" name="file-uploadE" accept=".pdf" type="file"/>
                                <p id="archivoE" class="m-0 w-80 overflow-text"></p>
                                <label for="file-uploadE" class="upload-btn m-0"><i class="fas fa-folder-open"></i> Subir archivo</label>
                            </div>
                        </div>
                        <div class="form-group col-lg-12 m-0">
                            <label for="estatus">Estatus</label>
                            <select id="estatus" name="estatus" class="form-control input-gral">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </form>
                    <div class="modal-footer"><br><br>
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnsave" onclick="update();" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="carpetasP" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content" >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>                                            
                    <div class="modal-footer"><br><br>
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="carpetas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content p-1" >
                    <div class="modal-header">
                        <h5 >Agregar nueva carpeta</h5>
                    </div>
                    <form  enctype="multipart/form-data" id="formAdmin">
                        <div class="form-group col-lg-12 m-0">
                            <label for="nombre">Nombre</label>
                            <input name="nombre" class="form-control input-gral" id="nombre" required>
                            <p id="nom" style="color: red;"></p>
                        </div>
                        <div class="form-group col-lg-12 m-0">
                            <label for="descripción">Descripción</label>                            
                            <textarea class="text-modal" rows="2" name="desc" id="desc" required></textarea>
                            <p id="des" style="color: red;"></p>
                        </div>
                        <div class="form-group col-lg-12 m-0">
                            <div class="file-gph">
                                <input class="d-none" type="hidden" id="filename" name="filename">
                                <input class="file-name" id="file-upload" name="file-upload" accept=".pdf" type="file"/>
                                <p id="archivo" class="m-0 w-80 overflow-text"></p>
                                <label for="file-upload" class="upload-btn m-0"><i class="fas fa-folder-open"></i> Subir archivo</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                            <button type="submit" id="btnsave1" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-folder-open fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Carpetas</h3>
                                <?php 
                                    if($this->session->userdata('id_rol')!=53){
                                ?>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4 com-md-4 col-lg-4">
                                        <button class="btn-data-gral btn-s-blue mb-3" data-toggle="modal" data-target="#carpetas">Agregar carpeta</button>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="material-datatables">
                                    <table id="tableCarpetas" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>CARPETA</th>
                                                <th>DESCRIPCIÓN</th>
                                                <th>ARCHIVO</th>
                                                <th>ESTATUS</th>
                                                <th>USUARIO</th>
                                                <th>FECHA DE CREACIÓN</th>
                                                <th>FECHA DE MODIFICACIÓN</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
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
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/controllers/asesores/carpetas_admin.js"></script>
</body>