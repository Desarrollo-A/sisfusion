<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<div>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="block full">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                            <i class="material-icons">list</i>
                                        </div>
                                        <div class="card-content">
                                            <div class="row">
                                                <h4 class="card-title" data-i18n="configura-tu-perfil">Configura tu perfil</h4>
                                                <div class="table-responsive">
                                                    <form name="my_personal_info_form" id="my_personal_info_form"
                                                        class="col-md-10 col-md-offset-1">

                                                        <div class="col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label" data-i18n="nombre">Nombre</label>
                                                                <input id="name" name="name" type="text"
                                                                    class="form-control" disabled
                                                                    value="<?= $nombre ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label" data-i18n="apellido-paterno">Apellido paterno</label>
                                                                <input id="last_name" name="last_name" type="text"
                                                                    class="form-control" disabled
                                                                    value="<?= $apellido_paterno ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label" data-i18n="apellido-materno">Apellido materno</label>
                                                                <input id="mothers_last_name" name="mothers_last_name"
                                                                    type="text" class="form-control" disabled
                                                                    value="<?= $apellido_materno ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">RFC</label>
                                                                <input id="rfc" name="rfc" type="text"
                                                                    class="form-control" maxlength="13"
                                                                    oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                    disabled value="<?= $rfc ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label" data-i18n="correo-electronico">Correo electrónico</label>
                                                                <input id="email" name="email" type="email"
                                                                    class="form-control" disabled
                                                                    value="<?= $correo ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label" data-i18n="telefono">Teléfono celular</label>
                                                                <input id="phone_number" name="phone_number"
                                                                    type="number" class="form-control" maxlength="10"
                                                                    oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                    disabled value="<?= $telefono ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="control-label" data-i18n="nombre-usuario">Nombre de usuario</label>
                                                                <input id="username" name="username" type="text"
                                                                    class="form-control" disabled
                                                                    value="<?= $usuario ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <label class="control-label" data-i18n="contrasena">Contraseña</label>
                                                                <input id="contrasena" name="contrasena" type="password"
                                                                    class="form-control" maxlength="10"
                                                                    oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                    value="<?= $contrasena ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <input type="checkbox" onclick="showPassword()"
                                                                    style="margin-top: 60px"><span data-i18n="mostrar-contrasena">Mostrar contraseña</span>
                                                                <input type="hidden" name="id_usuario" id="id_usuario"
                                                                    value="<?= $id_usuario ?>">
                                                            </div>
                                                        </div>                                                        
                                                        <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 align-center">
                                                            <?php
                                                            if($this->session->userdata('forma_pago')==2){ ?>
                                                            <div class="col-xs-12 col-sm-12  col-md-6  col-lg-6">
                                                                <?php if(count($opn_cumplimiento) == 0){?>
                                                                    <label class="control-label" style="font-size:1em" data-i18n="subir-opinion-cumplimiento">Subir opinión de cumplimiento</label>
                                                                    <button class="btn btn-primary btn-block update" title="Subir opinión de cumplimiento" data-toggle="modal" data-target="#uploadModal" data-id_usuario="<?=$this->session->userdata('id_usuario')?>"><span data-i18n="subir-archivo">SUBIR ARCHIVO</span></button>
                                                                <?php } else {
                                                                        if($opn_cumplimiento[0]['estatus'] == 1){
                                                                            $idDoc=$opn_cumplimiento[0]["id_opn"];
                                                                            
                                                                            echo '<label class="control-label" style="font-size:1em"><span data-i18n="opinion-subida-con-exito">Opinión SAT de este mes cargada con éxito</span></label><br>';
                                                                            echo '<div class="d-flex ">';
                                                                            echo '<button  type="button" class="btn-data btn-blueMaderas  verPDF " title="Ver Opinión de cumplimiento" data-i18n-tooltip="ver-opinion-cumplimiento" style="margin-right:5px;" data-nombreArchivo="'.$opn_cumplimiento[0]["archivo_name"].'" ><i class="fas fa-eye"></i></button>';
                                                                            echo '<button type="button" class="btn-data btn-warning DelPDF" data-toggle="modal" data-target="#Aviso2" title="Borrar" data-i18n-tooltip="borrar"><i class="material-icons">delete</i></button>';
                                                                            echo '</div>';
                                                                        }else if($opn_cumplimiento[0]['estatus'] == 0){
                                                                            ?>
                                                                            <label class="control-label" style="font-size:1em" data-i18n="subir-opinion-cumplimiento">Subir opinión de cumplimiento</label>
                                                                            <button class="btn btn-primary btn-block update" title="Subir opinión de cumplimiento" data-toggle="modal" data-target="#uploadModal" data-id_usuario="<?=$this->session->userdata('id_usuario')?>"><span data-i18n="subir-archivo">SUBIR ARCHIVO</span></button>
                                                                 <?php
                                                                            }else if($opn_cumplimiento[0]['estatus'] == 2){
                                                                                ?>
                                                                                <label class="control-label" style="font-size:1em" data-i18n="opinion-del-sat">Opinión del SAT bloqueda, ya hay facturas cargadas</label>
                                                                <?php
                                                                            }
                                                                        }?>
                                                            </div>

                                                            <?php } ?>

                                                            <div class="col-xs-12 col-sm-12  <?php echo ($this->session->userdata('forma_pago')==2) ?  'col-md-6 col-lg-6' :  'col-md-offset-8 col-md-4 col-lg-offset-8 col-lg-4'; ?>" <?php echo ($this->session->userdata('forma_pago')==2) ?  'style="padding-top:34px"' :  ''; ?>>
                                                                <button type="submit"
                                                                    class="btn btn-primary btn-block" id="btn-actualizar"><span data-i18n="actualizar">Actualizar</span></button>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <br>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ANIMACIÓN DE CARGA EN TODA LA VISTA -->
    <div class="spiner-loader hide" id="spiner-loader">
        <div class="backgroundLS">
            <div class="contentLS">
                <div class="center-align">
                    <span data-i18n="proceso-puede-demorar">Este proceso puede demorar algunos segundos</span>
                </div>
                <div class="inner">
                    <div class="load-container load1">
                        <div class="loader">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="modal fade modal-alertas" id="addFile" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red text-center">
                        <h4 class="card-title"><b><span data-i18n="cargar-opinion-cumplimiento">Cargar opinión cumplimiento SAT</span></b></h4>
                    </div>
                    <form id="EditarPerfilForm" name="EditarPerfilForm" method="post">
                        <div class="modal-body">
                            <p><span data-i18n="recuerda-opinion-debe-ser">Recuerda que tu opinión de cumplimiento debe ser</span><b> <span data-i18n="positiva">POSITIVA</span> </b> <span data-i18n="una-vez-cargada-factura">y una vez cargadas tus
                                facturas no podrás remplazar este archivo, si requieres modificarla te recomendamos que
                                sea</span> <u><span data-i18n="antes-de-cargar-factura">antes de cargar una factura</span></u>.</p>
                            <!--<center>
                                <div class="input-group">
                                    <label class="input-group-btn">
                                    </label>
                                    <span class="btn btn-info btn-file">
                                        <i class="fa fa-cloud-upload"></i> Subir archivo
                                        <input id="file-uploadE" name="file-uploadE" required accept="application/pdf"
                                            type="file" />
                                    </span>
                                    <p id="archivoE"></p>
                                </div>
                            </center>-->
                            <div class="file-gph">
                            <input class="d-none" type="file" id="fileElm" name="fileElm" required accept="application/pdf">
                            <input class="file-name" id="file-name" type="text" placeholder="No has seleccionada nada aún" data-i18n-label="no-has-seleccionado" readonly="">
                            <label class="upload-btn m-0" for="fileElm"><span data-i18n="seleccionar">Seleccionar</span><i class="fas fa-folder-open"></i></label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"><span data-i18n="cerrar">Cerrar</span></button>
                            <button class="btn btn-primary" type="submit" id="sendFile" data-toggle="modal"><span data-i18n="guardar">Guardar</span></button>
                        </div>                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="Aviso" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="padding:0%">
                        <button type="button" class="close" style="font-size: 40px;padding-right:10px;"
                            onclick="Recargar();" data-dismiss="modal">&times;</button>

                    </div>
                    <div class="modal-body">

                        <h5 class="msj">
                        </h5>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal fade bd-example-modal-sm" id="Aviso2" tabindex="-1" role="dialog"
            aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">                   
                    <div class="modal-body text-center">
                        <form id="formDelete">
                            <h5 data-i18n="seguro-de-eliminar-archivo">¿Estás seguro de eliminar este archivo?</h5>
                            <small><p id="secondaryLabelDetail"><span data-i18n="el-documento-se-eliminara">El documento se eliminará de manera permanente una vez que des clic en</span> <i><span data-i18n="aceptar">Aceptar</span></i>.</p></small>
                            <input type="hidden" value="<?=$idDoc?>" name="idDoc" id="idDoc">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"><span data-i18n="cerrar">Cerrar</span></button>
                                <button class="btn btn-primary" type="submit" data-toggle="modal"><span data-i18n="aceptar">Aceptar</span></button>
                            </div>  
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('template/footer_legend');?>

        </body>

        <?php $this->load->view('template/footer');?>
        <script src="<?=base_url()?>dist/js/controllers/usuarios-1.1.0.js"></script>
        <script src="<?=base_url()?>dist/js/controllers/Usuarios/profile.js"></script>
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
        <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>

        </html>