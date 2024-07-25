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
                                                <h4 class="card-title">Configura tu perfil</h4>
                                                <div class="table-responsive">
                                                    <form name="my_personal_info_form" id="my_personal_info_form"
                                                        class="col-md-10 col-md-offset-1">

                                                        <div class="col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Nombre</label>
                                                                <input id="name" name="name" type="text"
                                                                    class="form-control" disabled
                                                                    value="<?= $nombre ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Apellido paterno</label>
                                                                <input id="last_name" name="last_name" type="text"
                                                                    class="form-control" disabled
                                                                    value="<?= $apellido_paterno ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Apellido materno</label>
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
                                                                <label class="control-label">Correo electrónico</label>
                                                                <input id="email" name="email" type="email"
                                                                    class="form-control" disabled
                                                                    value="<?= $correo ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Teléfono celular</label>
                                                                <input id="phone_number" name="phone_number"
                                                                    type="number" class="form-control" maxlength="10"
                                                                    oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                    disabled value="<?= $telefono ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Nombre de usuario</label>
                                                                <input id="username" name="username" type="text"
                                                                    class="form-control" disabled
                                                                    value="<?= $usuario ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Contraseña</label>
                                                                <input id="contrasena" name="contrasena" type="password"
                                                                    class="form-control" maxlength="10"
                                                                    oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                    value="<?= $contrasena ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <input type="checkbox" onclick="showPassword()"
                                                                    style="margin-top: 60px">Mostrar contraseña
                                                                <input type="hidden" name="id_usuario" id="id_usuario"
                                                                    value="<?= $id_usuario ?>">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <?php
                                                            if($this->session->userdata('forma_pago')==2){ ?>
                                                            <div class="col-md-6">
                                                                <?php if(count($opn_cumplimiento) == 0){?>
                                                                <div class="input-group">
                                                                    <label class="input-group-btn">
                                                                        <span class="btn btn-warning btn-file update"
                                                                            data-id_usuario="<?=$this->session->userdata('id_usuario')?>">
                                                                            Subir opinión cumplimiento&hellip;
                                                                        </span>
                                                                    </label>
                                                                    <input type="text" class="form-control" id="txtexp"
                                                                        readonly>
                                                                </div> <?php } else {
                                                                        if($opn_cumplimiento[0]['estatus'] == 1){
                                                                            $idDoc=$opn_cumplimiento[0]["id_opn"];
                                                                            echo '<p><b style="color:#4068AB;">Opinión SAT de este mes cargada con éxito</b></p>';
                                                                            echo '<a href="#" class="btn btn-info btn-round btn-fab btn-fab-mini verPDF" title="Opinión de cumplimiento sin cargar"  style="margin-right:5px;" data-usuario="'.$opn_cumplimiento[0]["archivo_name"].'" ><i class="material-icons">description</i></a>';
                                                                            echo '<button type="button" class="btn btn-danger btn-round btn-fab btn-fab-mini DelPDF" data-toggle="modal" data-target="#Aviso2"  title="Borrar"><i class="material-icons">delete</i></button>';
                                                                        }else if($opn_cumplimiento[0]['estatus'] == 0){
                                                                            ?>
                                                                <div class="input-group">
                                                                    <label class="input-group-btn">
                                                                        <span class="btn btn-warning btn-file update"
                                                                            data-id_usuario="<?=$this->session->userdata('id_usuario')?>">
                                                                            Subir opinión cumplimiento&hellip;
                                                                        </span>
                                                                    </label>
                                                                    <input type="text" class="form-control" id="txtexp"
                                                                        readonly>
                                                                </div> <?php
                                                                            }else if($opn_cumplimiento[0]['estatus'] == 2){
                                                                                ?>
                                                                <p style="color: #02B50C;">Opinión del SAT bloqueda, ya
                                                                    hay facturas cargadas.</p>
                                                                <?php
                                                                            }
                                                                        }?>
                                                            </div>

                                                            <?php } ?>

                                                            <div class="col-md-4 col-md-offset-4">
                                                                <button type="submit"
                                                                    class="btn btn-primary btn-block" id="btn-actualizar">Actualizar</button>
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
        <div class="modal fade modal-alertas" id="addFile" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <h4 class="card-title"><b>Cargar opinión cumplimiento SAT</b></h4>
                    </div>
                    <form id="EditarPerfilForm" name="EditarPerfilForm" method="post">
                        <div class="modal-body">
                            <p>Recuerda que tu opinión de cumplimiento debe ser <b> POSITIVA </b> y una vez cargadas tus
                                facturas no podrás remplazar este archivo, si requieres modificarla te recomendamos que
                                sea <u>antes de cargar una factura</u>.</p>
                            <center>
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
                            </center>
                            <div class="form-group">
                                <center>
                                    <button type="submit" id="sendFile" class="btn btn-primary">GUARDAR</button>
                                    <button class="btn btn-danger" type="button" data-dismiss="modal">CANCELAR</button>
                                </center>
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
                    <div class="modal-header bg-red">
                        <h4 class="card-title"><b>Eliminar Opinión SAT</b></h4>
                    </div>
                    <div class="modal-body">
                        <form id="formDelete">

                            <p>¿Estas seguro de eliminar este archivo?</p>

                            <input type="hidden" value="<?=$idDoc?>" name="idDoc" id="idDoc">

                            <div class="form-group">
                                <center><button type="submit" class="btn btn-danger">Eliminar</button></center>
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